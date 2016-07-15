<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('TourModel','FaqModel','BookingModel','HotelModel','CruiseModel'));
		$this->load->library(array('TimeDate','cart','pagination'));
		$this->load->language(array('cruise','tourdetail','faq','hotel'));
		$this->load->helper(array('form','text','group','booking','tour'));
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
		
		$action = $this->input->post('action_type');
		
		if($action == 'delete'){
			
			$rowid = $this->input->post('rowid');
			
			remove_booking_item($rowid);
		}
		
		$data['NO_CART'] = true;
			
		$data = $this->set_form_data($data);
		
		$data['recommedation_services'] = $this->load->view('common/recommendation_services', $data, TRUE);
		
		$data['main'] = $this->load->view('tours/tour_booking_view', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	
	function next(){
		
		$url_title = $this->uri->segment(2);
		
		// anti sql injection
		$url_title = anti_sql($url_title);
		
		$data['tour'] = $this->TourModel->get_tour_obj_by_url_title($url_title);
		
		$data['children_rate'] = $this->TourModel->get_children_rate($data['tour']['id']);
		
		$parent_booking_rowid = $this->uri->segment(3);
		
		$booking_items = $this->get_all_booking_items($data['tour']['id'], $parent_booking_rowid, $data['children_rate']);
		
		foreach($booking_items as $booking_item){
			
			$parent_rowid = $booking_item['rowid'];
			
			if(isset($booking_item['optional_services']['transfer_services']) && count($booking_item['optional_services']['transfer_services']) > 0){
				
				foreach ($booking_item['optional_services']['transfer_services'] as $transfer){
					
					$name = $transfer['name'];
								
					$unit = $transfer['unit'];
					
					$rate = $transfer['rate'];
					
					$amount = $transfer['total_price'];
					
					$service_id = $transfer['optional_service_id'];
					
					$reservation_type = RESERVATION_TYPE_TRANSFER;
					
					$selected = $this->input->post($parent_rowid.'_'.$service_id.'_selected');
					
					$partner_id = '';
					// shuttle bus
					if($transfer['unit_type'] == 1){
						$partner_id = $booking_item['partner_id'];
					}
					
					add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $transfer['description'], $unit, $rate, $amount, '', $partner_id);
					
				}
				
			}
			
			if(isset($booking_item['optional_services']['extra_services']) && count($booking_item['optional_services']['extra_services']) > 0){
				
				foreach ($booking_item['optional_services']['extra_services'] as $extra){
								
					$name = $extra['name'];
					
					$unit = $extra['unit'];
					
					$rate = $extra['rate'];
					
					$amount = $extra['total_price'];
					
					$service_id = $extra['optional_service_id'];
					
					$reservation_type = RESERVATION_TYPE_OTHER;
					
					$unit_change = $this->input->post($parent_rowid.'_'.$service_id.'_unit');
					
					$unit_text = '';
					
					if (!empty($unit_change)){
						
						$unit = $unit_change;
						
						$amount = $extra['price'] * $unit;
						
						$unit_text = ' pax';
						
					}
					
					$partner_id = '';
					
					if (strpos($name, 'Visa') === FALSE){
						$partner_id = $booking_item['partner_id'];
					} else {
						//echo 'Visa here';exit();
					}
					
					$selected = $this->input->post($parent_rowid.'_'.$service_id.'_selected');
					
					add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $extra['description'], $unit, $rate, $amount, $unit_text, $partner_id);
					
				}
				
			}
			
			$this->cart->update_item($booking_item['rowid'], 'is_optional_service_selection', true);
			
			$this->cart->update_item($parent_rowid, 'temp_optional_services', array());
		}
		
		$booking_from = $this->uri->segment(4);
		
		if (empty($booking_from)){
		
			$this->session->set_userdata("back_url", '/tour-booking/'.$url_title.'.html');
		
		} else {
			
			$this->session->set_userdata("back_url", '/tour-booking/'.$url_title.'.html/'.$booking_from.'/');
		}
		
		redirect(site_url('my-booking').'/');
		
	}
	
	function set_form_data($data){
		
		$url_title = $this->uri->segment(2);
		
		// anti sql injection
		$url_title = anti_sql($url_title);
		
		
		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));
		
		// search form
		$data = buildTourSearchCriteria($data);
		
		$data['unit_types'] = $this->config->item('unit_types');

		$data['tour'] = $this->TourModel->get_tour_obj_by_url_title($url_title);
		
		if($data['tour'] ===FALSE){
			redirect(site_url());
		}		
		
		$data['children_rate'] = $this->TourModel->get_children_rate($data['tour']['id']);
		
		$parent_booking_rowid = $this->session->userdata('curent_booking_rowid');
		
		$this->session->unset_userdata('curent_booking_rowid');
		
		$booking_items = $this->get_all_booking_items($data['tour']['id'], $parent_booking_rowid, $data['children_rate']);
		
		$data['booking_items'] = $booking_items;
		
		$data['booking_total'] = $this->get_booking_infos($booking_items);

		$parent_id = isset($booking_items) && count($booking_items) > 0 ? $booking_items[0]['rowid'] : '';
		
		$data['parent_id'] = $parent_id;
		
		
		$data['metas'] = site_metas(TOUR_BOOKING, $data['tour']);
		
		$data['navigation'] = createTourBookingNavLink(true, $data['tour']);

		// get faq data
		$data = load_faq_by_context(24, $data);
		
		// show progress tracker bar
		$data['progress_tracker_id'] = 2;
		$data['progress_tracker'] = $this->load->view('common/progress_tracker', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		
		$destination_id = $data['tour']['main_destination_id'];
		
		$service_id = $data['tour']['cruise_id'] > 0 ? CRUISE : TOUR;
		
		$search_criteria = $data['search_criteria'];
		
		
		$current_item_info['service_id'] = $data['tour']['id'];
		
		$current_item_info['service_type'] = $service_id;
		
		$current_item_info['url_title'] = $data['tour']['url_title'];
		
		$current_item_info['normal_discount'] = 0; // don't use this data
		
		$current_item_info['is_main_service'] = false; // don't use this data
		
		$current_item_info['destination_id'] = $destination_id;
		
		$current_item_info['is_booked_it'] = true;
		
		$data['current_item_info'] = $current_item_info;
		
		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['departure_date']);
		
		
		// check where the booking from (cruise or tour)
		
		if ($data['tour']['cruise_id'] > 0){
			
			$data['cruise'] = $this->CruiseModel->getCruiseById($data['tour']['cruise_id'], false);
			
		}
		
		$from = $this->uri->segment(3);
		
		if (!empty($from)){
			$data['booking_from'] = $from.'/'; 	
		} else {
			$data['booking_from'] = '';
		}
		
		// load why use view
		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);
		
		$data['atts'] = get_popup_config('extra_detail');
		
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		
		return $data;
		
	}
	
	function set_optional_services($my_booking, $children_rate){
		
		foreach ($my_booking as $key => $booking_item){
			
			$optional_services = array();
			
			if ($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR || $booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR)
			
			{
				$tour_id = $booking_item['service_id'];
				
				$departure_date = $booking_item['start_date'];
				
				$duration = $booking_item['duration'];
				
				$optional_services = $this->TourModel->get_tour_optional_services($tour_id, $departure_date, $duration);
				
				$booking_info = $booking_item['booking_info'];
				
				$total_accomodation = $booking_item['total_price'];
				
				$optional_services = set_information_4_optional_services($optional_services, $booking_info, $children_rate, $total_accomodation, $booking_item);
			
			} elseif($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL){
				
				$children_rate = HOTEL_CHILDREN_RATE; // children price for optional service is 75% adult price
				
				$hotel_id = $booking_item['service_id'];
				
				$booking_info = isset($booking_item['booking_info']) ? $booking_item['booking_info'] : array();
				
				$staying_dates = isset($booking_info['staying_dates']) ? $booking_info['staying_dates'] : array();	
				
				$optional_services = $this->HotelModel->get_hotel_optional_services($hotel_id, $staying_dates);
				
				
				$total_accomodation = $booking_item['total_price'];
				
				$optional_services = set_information_4_optional_services($optional_services, $booking_info, $children_rate, $total_accomodation, $booking_item);
				
			}
			
			
			$booking_item['optional_services'] = $optional_services;
			
			$my_booking[$key] = $booking_item;
			
		} 
		
		return $my_booking;
	}
	
	function get_all_booking_items($tour_id, $parent_booking_rowid, $children_rate){
		
		$main_item = false;
		
		$related_booking_items = array();
		
		$my_booking = get_my_booking();
		
		foreach ($my_booking as $key => $booking_item){			
			
			if ($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR || $booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR)		
			{
				if (!empty($parent_booking_rowid)){
					
					if ($booking_item['rowid'] == $parent_booking_rowid){
						
						$main_item = $booking_item;
					}
					
				} else {
					
					if ($booking_item['service_id'] == $tour_id){
						
						$main_item = $booking_item;
						
					}
					
				}
				
			} 
			
		}
		
		if ($main_item){

			foreach ($my_booking as $key => $booking_item){
				
				if ($booking_item['parent_id'] == $main_item['rowid']){
					
					$related_booking_items[] = $booking_item;
					
				}
				
			}
			
		
		
		
		array_unshift($related_booking_items, $main_item);
		
		$related_booking_items = $this->set_optional_services($related_booking_items, $children_rate);
		
		return $related_booking_items;
		
		} else {
			return array();
		}
		
	}
	

	function _setValidationRules()
	{
		$this->load->library('form_validation');
		$booking_rules = $this->config->item('booking_rules');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
		$this->form_validation->set_rules($booking_rules);
	}
	
	function _validateBooking()
	{
		$this->_setValidationRules();

		return $this->form_validation->run();

	}
	
	function ajax_search_hotel() {
		
		$parent_id = $this->input->post('parent_id');
		
		$destination_id = $this->input->post('destination_id');
		
		$service_type = $this->input->post('service_type');
		
		$start_date = $this->input->post('start_date');
		
		$block_id = $this->input->post('block_id');
		
		
		// current booking item
		$current_item_info = array();
		
		$current_item_info['service_id'] = $this->input->post('current_service_id');
		
		$current_item_info['service_type'] = $this->input->post('current_service_type');
		
		$current_item_info['url_title'] = $this->input->post('current_service_url_title');
		
		$current_item_info['is_main_service'] = $this->input->post('current_service_is_main_service');
		
		$current_item_info['is_main_service'] = $current_item_info['is_main_service'] == 1 ? true : false;
		
		$current_item_info['normal_discount'] = $this->input->post('current_service_normal_discount');
		
		$current_item_info['destination_id'] = $this->input->post('current_service_destination_id');
		
		$current_item_info['is_booked_it'] = $this->input->post('current_service_is_booked_it');
		
		$current_item_info['is_booked_it'] = $current_item_info['is_booked_it'] == 1 ? true : false;
		
		
		$sort_by = $this->input->post('sort_by');
		
		if (empty($sort_by)) $sort_by = 'recommended';
		
		
		$stars = $this->input->post('stars');
			
		$data = array();
		
		$data = load_hotel_search_autocomplete($data);
			
		$total = $this->HotelModel->getNumHotelsByDestination($destination_id, $stars);
			
		$offset = (int)$this->uri->segment(2);
		
		$per_page_ajax = $this->config->item('per_page_ajax');
			
		$data['hotels'] = $this->HotelModel->get_hotels_by_destination($destination_id, $start_date, $stars, $sort_by, $offset, $per_page_ajax);
			
		if(!empty($data['hotels'])) {
			$config = get_paging_config($total, '/hotel_search_ajax/', 2);
			$config['per_page'] = $per_page_ajax;
			$this->pagination->initialize($config);
			$data['paging_text'] = get_paging_text($total, $offset, $per_page_ajax);
		}

		
		$data['parent_id'] = $parent_id;
		
		$data['destination_id'] = $destination_id;
		
		$data['service_type'] = $service_type;
		
		$data['start_date'] = $start_date;
		
		$data['block_id'] = $block_id;
		
		$data['current_item_info'] = $current_item_info;
		
		
		$data['sort_by'] = $sort_by;
				
		$data['stars'] = $stars;
		
		
		if ($destination_id != ''){
			
			if (!$current_item_info['is_booked_it']){
				
				$special_discounts = $this->BookingModel->get_discounts($current_item_info['service_id'], $current_item_info['service_type']);
				
			}
			
			// the hotel is NOT main service
			$is_main_service = false;  //$this->BookingModel->is_main_service($destination_id, HOTEL);
			
			foreach ($data['hotels'] as $key => $value) {
				
				$service_id = $value['id'];
			
				$service_type = HOTEL;
				
				$discount_coefficient = 1; // per pax
				
				$normal_discount = isset($value['discount']) ? $value['discount'] : 0;
			
				$value['is_special_discounted'] = false;
				
				// the current service is already booked
				if ($current_item_info['is_booked_it']){
					
					$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
			
					$value['discount'] = $discount_together['discount'];
					
					$value['is_discounted'] = $discount_together['is_discounted'];
					
				} else {
					
					$value['is_discounted'] = true;
				
					$special_discount_value = get_discount_2_services($current_item_info['service_id'], $current_item_info['service_type'], $service_id, $service_type, $special_discounts);
					
					if ($special_discount_value > 0){
						
						$value['discount'] = $special_discount_value;
						
						$value['is_special_discounted'] = true;
					}
					
				}
			
				
				// set price information for the service
				$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);
			
				
				$data['hotels'][$key] = $value;
			}
		}
		
		$data['atts'] = get_popup_config('extra_detail');
		
		echo $this->load->view('common/ajax_search_hotel_content', $data, TRUE);
	}
	
	function ajax_search_tour() {
		
		$parent_id = $this->input->post('parent_id');
		
		$destination_id = $this->input->post('destination_id');
		
		$service_type = $this->input->post('service_type');
		
		$start_date = $this->input->post('start_date');
		
		$block_id = $this->input->post('block_id');
		
		
		// current booking item
		$current_item_info = array();
		
		$current_item_info['service_id'] = $this->input->post('current_service_id');
		
		$current_item_info['service_type'] = $this->input->post('current_service_type');
		
		$current_item_info['url_title'] = $this->input->post('current_service_url_title');
		
		$current_item_info['is_main_service'] = $this->input->post('current_service_is_main_service');
		
		$current_item_info['is_main_service'] = $current_item_info['is_main_service'] == 1 ? true : false;
		
		$current_item_info['normal_discount'] = $this->input->post('current_service_normal_discount');
		
		$current_item_info['destination_id'] = $this->input->post('current_service_destination_id');
	
		$current_item_info['is_booked_it'] = $this->input->post('current_service_is_booked_it');
		
		$current_item_info['is_booked_it'] = $current_item_info['is_booked_it'] == 1 ? true : false;
		
		
		$duration = $this->input->post('duration');	
		
		$sort_by = $this->input->post('sort_by');
		if (empty($sort_by)) $sort_by = 'recommended';
		
		$is_cruise= false;
		
		$destination = $this->TourModel->getDestination($destination_id);
		
		if(!empty($destination) && $destination['type'] == 6) {
			$is_cruise = true;
		} 
		
		
		$total = $this->TourModel->getNumToursByDestinationAjax($destination_id, $duration, $is_cruise);

		
		$per_page_ajax = $this->config->item('per_page_ajax');
		
		$offset = (int)$this->uri->segment(2);
			
		$data['tours'] = $this->TourModel->get_tours_by_destination_ajax($destination_id, $start_date, $duration, $sort_by, $offset, $per_page_ajax, $is_cruise);
			
		if(!empty($data['tours'])) {
			$config = get_paging_config($total, '/tour_search_ajax/', 2);
			$config['per_page'] = $per_page_ajax;
			$this->pagination->initialize($config);
			$data['paging_text'] = get_paging_text($total, $offset, $per_page_ajax);
		}
			
		$data['parent_id'] = $parent_id;
		
		$data['destination_id'] = $destination_id;
		
		$data['service_type'] = $service_type;
		
		$data['start_date'] = $start_date;
		
		$data['block_id'] = $block_id;
		
		$data['current_item_info'] = $current_item_info;
		
		$data['sort_by'] = $sort_by;
		
		$data['duration'] = $duration;
		
		$data['dur_list'] = $this->config->item("duration_search");
		
		if ($destination_id != ''){
			
			if (!$current_item_info['is_booked_it']){
				
				$special_discounts = $this->BookingModel->get_discounts($current_item_info['service_id'], $current_item_info['service_type']);

			}
			
			foreach ($data['tours'] as $key => $value) {
				
				$service_id = $value['id'];
			
				$service_type = $value['cruise_id'] > 0 ? CRUISE : TOUR;

				$is_main_service = $this->BookingModel->is_main_service($value['main_destination_id'], $service_type);
				
				$discount_coefficient = 1; // per pax
				
				$normal_discount = isset($value['price']['discount']) ? $value['price']['discount'] : 0;
				
				$value['is_special_discounted'] = false;
				
				// the current service is already booked
				if ($current_item_info['is_booked_it']){
					
					$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
				
					$value['price']['discount'] = $discount_together['discount'];
					
					$value['is_discounted'] = $discount_together['is_discounted'];
					
				} else {
					
					$value['is_discounted'] = true;
					
					$special_discount_value = get_discount_2_services($current_item_info['service_id'], $current_item_info['service_type'], $service_id, $service_type, $special_discounts);
					
					if ($special_discount_value > 0){
						
						$value['price']['discount'] = $special_discount_value;
						
						$value['is_special_discounted'] = true;
					}
					
				}
			
				
				// set price information for the service
				$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);
				
				$data['tours'][$key] = $value;
			}
		}
		
		$data['atts'] = get_popup_config('extra_detail');
		
		echo $this->load->view('common/ajax_search_tour_content', $data, TRUE);
	}
	
	function get_booking_infos($booking_items){
		
		$total = 0;
		$discount = 0;
		$final_total = 0;
		
		foreach ($booking_items as $booking_item){
			
			$total = $total + $booking_item['total_price'];
						
			$discount = $discount + $booking_item['discount'];
			
			
		}
		
		$final_total = $total - $discount;
		
		return array('total_price'=>$total, 'discount'=>$discount, 'final_total'=>$final_total);
	}
	
	function save_optional_service_selection_status(){
		
		$parent_rowid = $this->input->post('parent_rowid');
		
		$unit = $this->input->post('unit');
		
		$service_id = $this->input->post('service_id');
		
		$selected = $this->input->post('selected');
		
		$cart_item = get_booking_item($parent_rowid);
		
		$optional_services = array();
		
		$status = array();
		
		$status['selected'] = $selected;
		
		$status['unit'] = $unit;
		
		if ($cart_item){
			
			if (isset($cart_item['temp_optional_services']) && is_array($cart_item['temp_optional_services'])){
				
				$optional_services = $cart_item['temp_optional_services'];
				
				$optional_services[$service_id] = $status;
				
			} else {
				
				$optional_services[$service_id] = $status;
			}
			
		}
		
		foreach ($optional_services as $key=>$value){
			echo $key.': '.$value['unit'].' - '.$value['selected'].'    ';
		}
		
		$this->cart->update_item($parent_rowid, 'temp_optional_services', $optional_services);
		
		echo '1';
	}
}
?>