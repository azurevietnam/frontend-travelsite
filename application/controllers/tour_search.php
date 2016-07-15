<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_Search extends CI_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('TourModel','FaqModel','BookingModel','DestinationModel'));
		
		$this->load->language(array('cruise','faq','tour'));
		$this->load->library('pagination');
		
		$this->load->helper(array('form', 'tour', 'text', 'group'));
				
		$this->load->driver('cache', array('adapter' => 'file'));
		
		// for test only
		// $this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		$data = array();
		$data = $this->_setFormData($data);
		
		$search_criteria = $data['search_criteria'];
		
		$uri_segment = $search_criteria['uri_segment'];
		$offset = (int)$this->uri->segment($uri_segment, 0);
		
		
		$filter_results = $this->get_filter_results($search_criteria);
		
		$search_results = $this->_searchTours($data['search_criteria'], $offset, $filter_results);
		
		if ($search_results != null) {
			$this->pagination->initialize(
					get_paging_config($search_results['total']
							, TOUR_SEARCH.'index/', $uri_segment));
			
			$data['paging_text'] = $search_results['paging_text'];
			$data['tours'] = $search_results['tours'];
			
			$data['total'] = $search_results['total'];
			$data['atts'] = get_popup_config('extra_detail');
			
		} else {
			
			$data['total'] = 0;
		} 
	
		$data = $this->load_filter_configuration($data);
		
		$data['filter_results'] = $filter_results;
		
		if ($this->input->is_ajax_request()/*$this->input->post('ajax')*/) {
			
			$this->load->view('tours/tour_search/tour_search_content', $data);
			
		} else {
			
			if ($search_results == null) {
				
				redirect(TOUR_SEARCH_EMPTY.$this->_getSearchParams($search_criteria, $data));
				
				exit();
			}
			
			$data = $this->count_filter_number($data);
			
			$data['contentMain'] = $this->load->view('tours/tour_search/tour_search_content', $data, TRUE);
			
			$data['filter_results'] = $this->load->view('tours/tour_search/tour_search_filter', $data, TRUE);
			
			$data['main'] = $this->load->view('tours/tour_search/tour_search_main', $data, TRUE);
		
			$this->load->view('template', $data);
			
		}
	}
	
	function _setFormData($data){
		// highlight tour menu	
		$this->session->set_userdata('MENU', MNU_VN_TOURS);
		
		// set site meta and navigation
		$data['metas'] = site_metas(TOUR_SEARCH);
		$data['navigation'] = createTourSearchNavLink(true);
		
		// get faq data
		$data = load_faq_by_context(25, $data);
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		// get destination data
		$data = loadTopDestination($data);
		
		// css
		$data['inc_css'] = get_static_resources('tour.min.16072013.css');
		
		$data = buildTourSearchCriteria($data);
		
		return $data;
	}
	
	function search_empty(){
	
		$data = array();
		$data = $this->_setFormData($data);

		$data['contentMain'] = $this->_search_not_found();
		
		$data['main'] = $this->load->view('tours/tour_search/tour_search_main', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function _search_not_found() {
		return '<div id="search_not_found"><h1 style="padding-left:0">Search Not Found</h1>' 
					. lang('tour_search_not_found') . ' or <a href="/aboutus/contact/" rel="nofollow">contact us</a> for special request.</div><div class="search_hint"><h3 style="padding-left:0">Search Hint:</h3>'.lang('search_help').'</div>';
	}
	
	
	function sort() {
		
		$offset = 0; //reset offset to 0
		
		$data = buildTourSearchCriteria();
		$search_criteria = $data['search_criteria'];
		
		
		$filter_results = $this->get_filter_results($search_criteria);
		
		// do searching
		$search_results = $this->_searchTours($search_criteria, $offset, $filter_results);
	
		if ($search_results != null) {
			// initialize pagination
			$this->pagination->initialize(
						get_paging_config($search_results['total']
								, TOUR_SEARCH.'index/', $search_criteria['uri_segment']));
	
			$data['tours'] = $search_results['tours'];
			$data['paging_text'] = $search_results['paging_text'];
			$data['tour_orders'] = $this->config->item("tour_orders");
			
			$data['total'] = $search_results['total'];
			
			$data['atts'] = get_popup_config('extra_detail');
			
			$data = $this->load_filter_configuration($data);
			
			$data['filter_results'] = $filter_results;
			
			$this->load->view('tours/tour_search/tour_search_content', $data);
		} else {
			echo $this->_search_not_found();
		}
	}
	
	function _getSearchParams($search_criteria, $data){
	
		$params = "destinations=" . $search_criteria['destinations'];
	
		$params = $params . "&departure_date=" . $search_criteria['departure_date'];
	
	
	
		$cats[] = array();
	
		if ($search_criteria['travel_styles'] != ''){
	
			foreach ($data['cats'] as $value) {
	
				$cats[$value['id']] = $value;
	
			}
	
			$travel_styles = '';
	
			foreach ($search_criteria['travel_styles'] as $key => $value) {
				
				if ($key > 0){
					
					$travel_styles = $travel_styles. ':';
				}
				
				$travel_styles = $travel_styles . $cats[$value]['name'];
	
			}
	
			$params = $params . "&travel_styles=" . $travel_styles;
	
		} else {
	
			$params = $params . "&travel_styles=";
	
		}
	
		$duration = "All";
		if ($search_criteria['duration'] == '4'){
			$duration = "4-7 days";
		} else if ($search_criteria['duration'] == '5'){
			$duration = "over 7 days";
		} else if ($search_criteria['duration'] != ''){
			$duration = $search_criteria['duration'];
		}
	
		$params = $params . "&duration=" . $duration;
		
		$params = $params . "&group=" . (isset($search_criteria['group_type']) ? $search_criteria['group_type'] : '');
	
		$class_sv = "";
		$c_services = $data['c_services'];//$this->config->item("class_tours");
		
		$tour_types = array();
		
		if ($search_criteria['class_service'] != ''){
			
			foreach ($c_services as $value) {
	
				$tour_types[$value['id']] = $value;
	
			}
			
			foreach ($search_criteria['class_service'] as $key=>$value) {
				
				if ($key > 0){
					
					$class_sv = $class_sv. ':';
				}
				
				$class_sv = $class_sv . strtolower($tour_types[$value]['name']);
			}
		
			$params = $params . "&class_sv=" . $class_sv;
		} else {
			$params = $params . "&class_sv=";
		}
	
		return $params;
	}
	
	function _searchTours($search_criteria, $offset, $filter_results) {
		$per_page = $this->config->item('per_page');
		//print_r($search_criteria);
	
		$total = $this->TourModel->countSeachResults($search_criteria, $filter_results);
	
		if ($total > 0) {
			if ($offset > $total - $per_page + 1) {
				//$offset = $total - $per_page + 1;
			}
			if ($offset < 0) {
				$offset = 0;
			}
			$order_by = array();
			
			//$order_by['field'] = "t.deal";
			//$order_by['type'] = "desc";
					
			switch ($search_criteria['sort_by']) {
				case 'best_deals':
					$order_by['field'] = "t.deal";
					$order_by['type'] = "desc";
					break;
				case 'num_good_reviews':
					$order_by['field'] = "t.total_score";
					$order_by['type'] = "desc";
					break;
				case 'price_low_high':
					$order_by['field'] = "pr.from_price";
					$order_by['type'] = "asc";
					break;
				case 'price_high_low':
					$order_by['field'] = "pr.from_price";
					$order_by['type'] = "desc";
					break;
				default :
					// do nothing
					break;
			}
			$tours = $this->TourModel->searchTours(
					$search_criteria
					, $per_page, $offset
					, $order_by['field'], $order_by['type'], $filter_results);		
			
			if($search_criteria['sort_by'] == 'price_low_high') {
				usort($tours, array($this, 'sortOffDesc'));
			} else if($search_criteria['sort_by'] == 'price_high_low') {
				usort($tours, array($this, 'sortOffAsc'));
			}
			
			// set specific discount data
			foreach ($tours as $key=>$value){
				
				if ($value['has_special_discount'] == STATUS_ACTIVE){
				
					$departure_date = $search_criteria['departure_date']; 
					
					$service_id = $value['id'];
					
					$service_type = $value['cruise_id'] > 0 ? CRUISE : TOUR;
					
					$value['most_rec_service'] = $this->BookingModel->get_most_recommended_service($service_id, $service_type, $departure_date);
					
					
					$tours[$key] = $value;
				
				}
			}
	
			$data['tours'] = $tours;
			$data['total'] = $total;
			$data['paging_text'] = get_paging_text($total, $offset);
			return $data;
		}
		return null;
	}
	
	function sortOffDesc($a, $b)
	{
		$a_price = get_price_now($a['price']);
		$b_price = get_price_now($b['price']);
		if ($a_price == $b_price) {
			return 0;
		}
		
		return ($a_price < $b_price) ? -1 : 1;
	}
	
	function sortOffAsc($a, $b)
	{
		$a_price = get_price_now($a['price']);
		$b_price = get_price_now($b['price']);
		if ($a_price == $b_price) {
			return 0;
		}
	
		return ($a_price < $b_price) ? 1 : -1;
	}
	
	function see_more_deals(){

		$tour_id = $this->input->post('tour_id');
		
		$departure_date = $this->input->post('departure_date');
		
		$search_criteria['departure_date'] = $departure_date;
		
		$data['search_criteria'] = $search_criteria;
		
		$tour = $this->TourModel->get_tour_by_id($tour_id, $departure_date);
		
		
		$destination_id = $tour['main_destination_id'];
		
		$service_type = $tour['cruise_id'] > 0 ? CRUISE : TOUR;
		
		$is_main_service = $this->BookingModel->is_main_service($destination_id, $service_type);
		
		
		$current_item_info['service_id'] = $tour['id'];
		
		$current_item_info['service_type'] = $service_type;
		
		$current_item_info['url_title'] = $tour['url_title'];
		
		$current_item_info['normal_discount'] = $tour['normal_discount'];
		
		$current_item_info['is_main_service'] = $is_main_service;
		
		$current_item_info['destination_id'] = $destination_id;
		
		$current_item_info['is_booked_it'] = false;
		
		$data['current_item_info'] = $current_item_info;
		
		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['departure_date']);
		
		$data['parent_id'] = -1;
		
		$data['atts'] = get_popup_config('extra_detail');
		
		$data['selected_service_name'] = $tour['name'];
		
		$recommendation_before_book_it = $this->load->view('common/recommendation_before_book_it', $data, TRUE);
		
		echo $recommendation_before_book_it;
	}
	
	function see_overview(){
		
		ob_start();
		
		$tour_id = $this->input->post('tour_id');
		
		$departure_date = $this->input->post('departure_date');
		
		$tour_name = $this->input->post('tour_name');
	
		$tour = $this->TourModel->get_tour_overview($tour_id, $departure_date, $tour_name);
		
		if ($tour === FALSE){
			
			echo '';
			
		} else {
			
			$data['tour'] = $tour;
		
			$data['departure_date'] = $departure_date;
			
			$data['tour_name'] = $tour_name;
		
			$tour_overview = $this->load->view('tours/tour_overview', $data, TRUE);
		
			echo $tour_overview;		
		}
	
	}
	
	function load_filter_configuration($data){
		
		$search_criteria = $data['search_criteria'];
		
		$des_id = $search_criteria['destination_ids'];
		
		$this->config->load('tour_meta');
		
		$cruise_cabins = $this->config->item('cruise_cabins');
		
		$tour_durations = $this->config->item('tour_durations');
		
		$tour_types = $this->config->item('tour_types');
		
		$data['cruise_cabins'] = $cruise_cabins;
		
		$data['tour_durations'] = $tour_durations;
		
		$data['tour_types'] = $tour_types;
		
		$data['search_destination'] = $this->DestinationModel->get_destination_4_filter($des_id);
		
		$data['cruise_properties'] = $this->DestinationModel->get_cruise_facilities_4_search();
		
		$data['tour_activities'] = $this->DestinationModel->get_system_activities();
		
		return $data;
	}
	
	function get_filter_results($search_criteria){
		
		if ($this->input->is_ajax_request()){
			
			$cruise_cabin = $this->input->post('cruise_cabin');
			
			$cruise_properties = $this->input->post('cruise_properties');
			
			$sub_des = $this->input->post('sub_des');
			
			$tour_duration = $this->input->post('tour_duration');
			
			$tour_types = $this->input->post('tour_types');
			
			$tour_activities = $this->input->post('tour_activities');
			
			
			$cruise_properties = $cruise_properties == '' ? array() : $cruise_properties;
			
			$sub_des = $sub_des == '' ? array() : $sub_des;
			
			$tour_types = $tour_types == '' ? array() : $tour_types;
			
			$tour_activities = $tour_activities == '' ? array() : $tour_activities;
			
			if ($cruise_cabin == '') $cruise_cabin = 0;
			
			if ($tour_duration == '') $tour_duration = 0;
			
		} else {
			
			$cruise_cabin = 0;
			
			$cruise_properties = array();
			
			$sub_des = array();
			
			$tour_activities = array();
			
			if (!empty($search_criteria['duration'])){
			
				$tour_duration = $search_criteria['duration'];
			
			} else {
				
				$tour_duration = 0;
			}
			
			if (!empty($search_criteria['class_service']) && count($search_criteria['class_service']) > 0){
				
				$tour_types = $search_criteria['class_service'];
				
			} else {
				
				$tour_types = array();
								
			}
			
			if (!empty($search_criteria['group_type'])){
			
				if($search_criteria['group_type'] == 'private'){
					$tour_types[] = 4; // 4 => private
				}
			
				if($search_criteria['group_type'] == 'group'){
					$tour_types[] = 5; // 5 => group
				}
			}
		}
		
		$filter_results['cruise_cabin'] = $cruise_cabin;
		
		$filter_results['cruise_properties'] = $cruise_properties;
		
		$filter_results['sub_des'] = $sub_des;
		
		$filter_results['tour_duration'] = $tour_duration;
		
		$filter_results['tour_types'] = $tour_types;
		
		$filter_results['tour_activities'] = $tour_activities;
		
		return $filter_results;
	}
	
	function count_filter_number($data){
		
		$search_criteria = $data['search_criteria'];
		
		$cruise_cabins = $data['cruise_cabins'];
		
		$cruise_properties = $data['cruise_properties'];
		
		$tour_durations = $data['tour_durations'];
		
		$tour_types = $data['tour_types'];
		
		$tour_activities = $data['tour_activities'];
		
		$search_destination = $data['search_destination'];
	
		
		$all_search_tours = $this->TourModel->get_all_tours_for_search_filters($search_criteria);
		
		// count cruise properties
		
		$cruise_cabins_nr = array();
				
		foreach ($cruise_cabins as $key => $value){
			
			$nr = 0;
			
			foreach ($all_search_tours as $tour){

				if ($tour['cabin_index'] & $key){
					
					$nr++;
					
				}
				
			}
			
			$cruise_cabins_nr[$key] = $nr;
			
		}
		
		$cruise_cabins_nr[0] = count($all_search_tours); //all
		
		$cruise_properties_nr = array();
		
		// cruise properties		
		foreach ($cruise_properties as $key => $value){
			
			$nr = 0;
			
			$facility_ids = '-'.$value['id'].'-';
			
			foreach ($all_search_tours as $tour){

				if ($tour['cruise_facility_ids'] != '' && strpos($tour['cruise_facility_ids'], $facility_ids) !== FALSE){
					
					$nr++;
					
				}
				
			}
			
			if ($nr > 0){
			
				$cruise_properties_nr[$value['id']] = $nr;
			
			}
		}
		
		
		// has triple-family cabin
		$nr = 0;		
		foreach ($all_search_tours as $tour){

			if ($tour['has_triple_family'] == STATUS_ACTIVE){
				
				$nr ++;
				
			}
			
		}
		
		if ($nr > 0){
			$cruise_properties_nr[-1] = $nr;
		}
		
		
		// sub-des
		$has_tour_in_attraction = false;
		if(!empty($search_destination['sub_des'])){
			foreach ($search_destination['sub_des'] as $key=>$des){			
				
				$route_ids = '-'.$des['id'].'-';
				
				$nr = 0;		
				foreach ($all_search_tours as $tour){
		
					if ($tour['route_ids'] != '' && strpos($tour['route_ids'], $route_ids) !== FALSE){
						
						$nr++;
						
					}
					
				}
	
				$des['tour_nr'] = $nr;
			
				if ($nr > 0){
					
					$has_tour_in_attraction = true;
					
				}
				
				$search_destination['sub_des'][$key] = $des;
			}
		}
		
		$search_destination['has_tour_in_attraction'] = $has_tour_in_attraction;
		
		// count tour_duration
		
		
		$tour_durations_nr = array();
				
		foreach ($tour_durations as $key => $value){
			
			$nr = 0;
			
			foreach ($all_search_tours as $tour){

				if ($key == 1 || $key == 2 || $key == 3){
					
					if ($key == $tour['duration']){
						
						$nr++;
					}
					
				} else if ($key == 4){
					
					if ($tour['duration'] >= 4 && $tour['duration'] <= 7){
						
						$nr++;
					}
					
				} else {
					
					if ($tour['duration'] > 7){
						
						$nr++;
					}
				}
				
				
			}
			
			$tour_durations_nr[$key] = $nr;
			
		}
		
		$tour_durations_nr[0] = count($all_search_tours); // all
		
		// tour_type
		$tour_types_nr = array();
				
		foreach ($tour_types as $key => $value){
			
			$nr = 0;
			
			$type_str = '-'.$key.'-';			

			foreach ($all_search_tours as $tour){

				if ($key == GROUP_TOUR){
					
					if ($tour['class_tours'] != '' && strpos($tour['class_tours'], '-'.PRIVATE_TOUR.'-') === FALSE){
						
						$nr++;
						
					}
				
				} elseif ($tour['class_tours'] != '' && strpos($tour['class_tours'], $type_str) !== FALSE){
					
					$nr++;
					
				}
				
			}
			
			$tour_types_nr[$key] = $nr;
			
		}
		
		// tour_activity
		$tour_activities_nr = array();
				
		foreach ($tour_activities as $value){
			
			$nr = 0;
			
			$activity_str = '-'.$value['id'].'-';			

			foreach ($all_search_tours as $tour){

				if ($tour['activity_ids'] != '' && strpos($tour['activity_ids'], $activity_str) !== FALSE){
						
					$nr++;
					
				}
				
			}
			
			if ($nr > 0){
			
				$tour_activities_nr[$value['id']] = $nr;
			
			}
		}
		
		$data['cruise_cabins_nr'] = $cruise_cabins_nr;
		
		$data['cruise_properties_nr'] = $cruise_properties_nr;
		
		$data['tour_durations_nr'] = $tour_durations_nr;
		
		$data['tour_types_nr'] = $tour_types_nr;
		
		$data['tour_activities_nr'] = $tour_activities_nr;
		
		$data['search_destination'] = $search_destination;
		
		return $data;
	}
}
?>