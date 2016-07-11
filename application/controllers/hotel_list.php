<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_List extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();
       	
		$this->load->language(array('hotel','faq'));	
		$this->load->model(array('HotelModel','FaqModel'));
		$this->load->library('pagination');	
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('cookie');	
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index(){
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_HOTELS);
		
		$data['GLOBAL_DATAS'] = array();	
		
		$data = array();
		
		$data = $this->_setComonData($data);
		
		$url_title = $this->uri->segment(1);
		
		// anti sql injection
		$url_title = anti_sql($url_title);
		
		
		$destination_hotels = substr($url_title, strlen(MODULE_HOTELS)+1);
		
		$destination_title_url = substr($destination_hotels, 0, strlen($destination_hotels) - strlen(MODULE_HOTELS) - 1);
	
		$des = $this->HotelModel->getDestinationByUrlTitle($destination_title_url);	

		if ($des == ''){
			redirect(site_url());
		}
		
		$data['des'] = $des;
		
		$data['navigation'] = $this->_createNavigation(HOTEL_DESTINATION, $data);
		
		$data['metas'] = site_metas(HOTEL_DESTINATION, $data['des']);	
		
		//$search_criteria = $this->_buildSearchCriteria($des);
		$search_criteria = buildHotelSearchCriteria($des);
		
		$data['search_criteria'] = $search_criteria;
		
		$data['hotels'] = $this->HotelModel->getHotelsByDestination($des['id']);
		
		$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
		
		$data['hotel_list_view'] = $this->load->view('hotels/hotel_by_destination', $data, TRUE);
		
		// get faq data
		$data = load_faq_by_context(12, $data);
		
		$data = $this->_load_hotel_by_destination($data);
		
		//$data['inc_css'] = '<link rel="stylesheet" type="text/css" href="/css/hotel.min.css" />';
		$data['inc_css'] = get_static_resources('hotel.min.03102013.css');
		
		$data['main'] = $this->load->view('hotels/hotel_list_view', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function search()
	{	
		$this->session->set_userdata('MENU', MNU_HOTELS);
		
		$data['GLOBAL_DATAS'] = array();	
		
		$data = array();
		
		if (!$this->input->post('ajax')) {
			$data = $this->_setComonData($data);
		}
			
		$data['navigation'] = $this->_createNavigation(HOTEL_SEARCH, $data);
		
		$data['metas'] = site_metas(HOTEL_SEARCH);
			
	
		$search_criteria = $this->_buildSearchCriteria();
		
		$data['search_criteria'] = $search_criteria;
		
		// set data for pagination		
		$data['total_rows'] = $this->HotelModel->getNumHotels($search_criteria);			
		
		$offset = $this->uri->segment(3);
		
		// do searching for customer reviews
		$data['hotels'] = $this->HotelModel->searchHotels(
						$search_criteria
						, $this->config->item('per_page')
						, (int)$offset);
						
		if(count($data['hotels']) == 0){
			redirect('hotels/search_empty'.$this->_getSearchParams($search_criteria));
			exit;
		}	
		
		// initialize pagination
		$this->pagination->initialize(
						get_paging_config($data['total_rows']
							, 'hotels/search'
							, 3));
							
		
		$data['search_criteria'] = $search_criteria;
							
		$data['paging_text'] = get_paging_text($data['total_rows'], $offset);
		
		// get faq data
		$data = load_faq_by_context(15, $data);
		
		$data['inc_css'] = get_static_resources('hotel.min.03102013.css');
		
		if ($this->input->post('ajax')) {
				
			$this->load->view('hotels/hotel_list', $data);
				
		} else {
			
			$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
			
			$data['hotel_list_view'] = $this->load->view('hotels/hotel_list', $data, TRUE);

			$data['main'] = $this->load->view('hotels/hotel_list_view', $data, TRUE);
		
			$this->load->view('template', $data);
				
		}
	}
	
	function sort() {
		$id = $this->input->post("id");
		$url_title = $this->input->post("url_title");
		$offset = 0; //reset offset to 0
		$data['id'] = $id;
		$data['url_title'] = $url_title;
	
		$search_criteria = $this->_buildSearchCriteria();
		$data['search_criteria'] = $search_criteria;
	
	
		// do searching
		$data['hotels'] = $this->HotelModel->searchHotels(
				$search_criteria
				, $this->config->item('per_page')
				, (int)$offset);
	
		if ($data['hotels'] != null) {
			// set data for pagination
			$data['total_rows'] = $this->HotelModel->getNumHotels($search_criteria);
			
			$offset = $this->uri->segment(3);
			
			// initialize pagination
			$this->pagination->initialize(
							get_paging_config($data['total_rows']
								, 'hotels/search'
								, 3));
								
			
			$data['search_criteria'] = $search_criteria;
								
			$data['paging_text'] = get_paging_text($data['total_rows'], $offset);
				
			$this->load->view('hotels/hotel_list', $data);
		} else {
			echo $this->_search_not_found();
		}
	}
	
	function _search_not_found() {
		return '<div id="search_not_found"><h1 style="padding-left:0">Search Not Found</h1>'
		. lang('tour_search_not_found') . ' or <a href="/aboutus/contact/" rel="nofollow">contact us</a> for special request.</div><div class="search_hint"><h3 style="padding-left:0">Search Hint:</h3>'.lang('search_help').'</div>';
	}
	
	function search_empty(){
		
		$this->session->set_userdata('MENU', MNU_HOTELS);
		
		$data['GLOBAL_DATAS'] = array();	
		
		$data = array();
		
		$data = $this->_setComonData($data);
		
			
		$data['navigation'] = $this->_createNavigation(HOTEL_SEARCH, $data);
		
		$data['metas'] = site_metas(HOTEL_SEARCH);
		
		$search_criteria = $this->session->userdata("FE_hotel_search_criteria");
		
		$data['search_criteria'] = $search_criteria;
		
		$data['hotels'] = array();
						
		$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
		
		$data['hotel_list_view'] = $this->load->view('hotels/hotel_list', $data, TRUE);
		
		// get faq data
		$data = load_faq_by_context(15, $data);
		
		//$data['inc_css'] = '<link rel="stylesheet" type="text/css" href="/css/hotel.min.css" />';
		$data['inc_css'] = get_static_resources('hotel.min.03102013.css');
		
		$data['main'] = $this->load->view('hotels/hotel_list_view', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	
	function _getSearchParams($search_criteria){
		
		$params = "/destination=".($search_criteria['destination'] == lang('hotel_search_title') ? '' : $search_criteria['destination']);

		$params = $params . "&star=" .(count($search_criteria['hotel_stars']) == 0? 'All' : implode(":", $search_criteria['hotel_stars']));

		

		$params = $params ."&arrival_date=".$search_criteria['arrival_date'];

		$params = $params . "&night=" .$search_criteria['hotel_night'];
		
		return $params;
	}

	
	function _setComonData($data){
		
		$data['hotel_stars'] = $this->HotelModel->hotel_stars;
		
		$data['hotel_nights'] = $this->HotelModel->hotel_nights;
		
		// get hotel top destinations
		$data = load_hotel_top_destination($data);
		
		//  get list hotel name for seach autocomplete
		$data = load_hotel_search_autocomplete($data);
		
		return $data;
	}
	
	function _createNavigation($action, $data) {
		switch ($action) {
			case HOTEL_HOME:
				return createHotelHomeNavLink(true);
			case HOTEL_SEARCH:
				return createHotelSearchNavLink(true);
			case HOTEL_DESTINATION:	
				return createHotelDesNavLink(true, $data['des']);
			case HOTEL_COMPARE:
				return createHotelCompareNavLink(true);						
			default:
				$data['name'] = $data['page_header'];
				return createTourStyleNavLink(true, $data);		
		}

		return '';		
	}
	
	function _getAllCitiesOfVietnam(){
		$ret = array();
		$ret['north'] = array();
		$ret['middle'] = array();
		$ret['south'] = array();
		
		$allCities = $this->HotelModel->getAllCitiesOfVietnam();
		
		foreach ($allCities as $value) {
			if($value['region'] == 1){
				$ret['north'][] = $value;
			} elseif ($value['region'] == 2){
				$ret['middle'][] = $value;
			} else {
				$ret['south'][] = $value;
			}
		}
		
		return $ret;
	}
	
	function _builSearchCriteria4Compare(){
		
		$search_criteria = array();	
		
		if ($this->session->userdata("FE_hotel_search_criteria")){
			$search_criteria = $this->session->userdata("FE_hotel_search_criteria");	
		} else {
			// do nothing
		}
		
		$sort_by = $this->input->post('sort_by');
		
		if ($sort_by != ''){
			$search_criteria['sort_by'] = $sort_by;
		} else{
			$search_criteria['sort_by'] = 'best_deals';
		}
		
		//echo $search_criteria['sort_by'];
		
		$search_criteria = $this->_setDefaultSearchCriteria($search_criteria);
		
		return $search_criteria;
	}
	
	function _buildSearchCriteria($des = '') {
		
		$search_criteria = array();	
		
		$submit_action = $this->input->post('submit_action');
		
		if ($this->session->userdata("FE_hotel_search_criteria") && $submit_action != 'yes'){
			
			$search_criteria = get_hotel_search_params_from_url();
			
			if (!$search_criteria){

				$search_criteria = $this->session->userdata("FE_hotel_search_criteria");
				
			}
			
		}
		
		if (!$this->session->userdata("FE_hotel_search_criteria")){
			$search_criteria = get_hotel_search_params_from_url();
		}
		
		if($des != ''){			
			
			$search_criteria['destination_id'] = $des['id'];
			
		} else {
		
			$destination_id = $this->input->post('destination_id');
			
			if ($destination_id != ''){
				$search_criteria['destination_id'] = $destination_id;
			} 
			
			$destination = $this->input->post('destination');
			
			if ($destination != ''){
				$search_criteria['destination'] = $destination;				
			}
		
		}
		
		
		$hotel_stars = $this->input->post('hotel_stars');
		
		if ($hotel_stars != '' && count($hotel_stars) > 0){
			
			$search_criteria['hotel_stars'] = $hotel_stars;
				
		} 
		
		
		$arrival_date = $this->input->post('arrival_date');
		
		if ($arrival_date != ''){
			$search_criteria['arrival_date'] =  date('d-m-Y', strtotime($arrival_date));
		}
		
		$hotel_night = $this->input->post('hotel_night');
		
		if ($hotel_night != ''){
			$search_criteria['hotel_night'] = $hotel_night;
		}
		
		$sort_by = $this->input->post('sort_by');
		
		if ($sort_by != ''){
			$search_criteria['sort_by'] = $sort_by;
		} else{
			//$search_criteria['sort_by'] = 'best_deals';
		}
		
		//echo $search_criteria['sort_by'];
		
		$search_criteria = $this->_setDefaultSearchCriteria($search_criteria, $des);
		
		return $search_criteria;
	}
	
	function _setDefaultSearchCriteria($search_criteria, $des = '') {
		
		if(!array_key_exists('destination_id', $search_criteria)){
			$search_criteria['destination_id'] = '';
		}
		
		if(!array_key_exists('destination', $search_criteria)){
			$search_criteria['destination'] = lang('hotel_search_title');
		}
		
				
		if(!array_key_exists('hotel_stars', $search_criteria)){
			$search_criteria['hotel_stars'] = array();
		}
		
		if(!array_key_exists('arrival_date', $search_criteria)){
			$search_criteria['arrival_date'] = date('d-m-Y');
		}
			
		if(!array_key_exists('hotel_night', $search_criteria)){
			$search_criteria['hotel_night'] = '1';
		}
		
		if($des != ''){
			$search_criteria['destination'] = $des['name'];
		}
		
		$departure_date = strtotime(date("d-m-Y", strtotime($search_criteria['arrival_date'])) . " +". $search_criteria['hotel_night']. " day");
		
		$search_criteria['departure_date'] = date('d-m-Y', $departure_date);
		
		$this->session->set_userdata("FE_hotel_search_criteria", $search_criteria);
		
		return $search_criteria;
	}
	
	function _load_hotel_by_destination($data){
		
		$des = $data['des'];
		
		$hotels = $this->HotelModel->get_all_hotels_in_destination($des['id']);
		
		$h_5_stars = array();
		
		$h_4_stars = array();
		
		$h_3_stars = array();
	
		
		foreach ($hotels as $hotel){
			
			if($hotel['star'] >= 5){
				$h_5_stars[] = $hotel;
			} elseif($hotel['star'] >= 4){
				$h_4_stars[] = $hotel;
			} elseif ($hotel['star'] >= 2.5){
				$h_3_stars[] = $hotel;
			}
			
		}
		
		
		$data['h_5_stars'] = $h_5_stars;
		
		$data['h_4_stars'] = $h_4_stars;
		
		$data['h_3_stars'] = $h_3_stars;
		
		$data['all_hotel_in_destination_view'] = $this->load->view('hotels/all_hotel_in_destination', $data, TRUE);
		
		return $data;
	}
}
?>