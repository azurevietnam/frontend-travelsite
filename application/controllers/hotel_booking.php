<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('TourModel','FaqModel','BookingModel','HotelModel'));
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
		
		$data['GLOBAL_DATAS'] = load_global_data();
		
		$data = $this->set_form_data($data);
		
		$data['recommedation_services'] = $this->load->view('common/recommendation_services', $data, TRUE);
		
		$data['main'] = $this->load->view('hotels/hotel_booking_view', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	
	function next(){
		
		$url_title = $this->uri->segment(2);
		
		// anti sql injection
		$url_title = anti_sql($url_title);
		
		$data['hotel'] = $this->HotelModel->get_hotel_obj_by_url_title($url_title);
		
		$parent_booking_rowid = $this->uri->segment(3);
		
		$booking_items = $this->get_all_booking_items($data['hotel']['id'], $parent_booking_rowid);
		
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
		

		redirect(site_url('my-booking').'/');
		
	}
	
	function set_form_data($data=''){
		
		$url_title = $this->uri->segment(2);
		
		// anti sql injection
		$url_title = anti_sql($url_title);
		
		
		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));
		
		// search form
		$search_criteria = buildHotelSearchCriteria();
		
		$data['search_criteria'] = $search_criteria;
		
		
		$data['unit_types'] = $this->config->item('unit_types');
		
		//echo $url_title; exit();
		
		$data['hotel'] = $this->HotelModel->get_hotel_obj_by_url_title($url_title);
		
		if($data['hotel'] === FALSE){
			redirect(site_url());
		}		
		
		$parent_booking_rowid = $this->session->userdata('curent_hotel_booking_rowid');
		

		$this->session->unset_userdata('curent_booking_rowid');
		
		$booking_items = $this->get_all_booking_items($data['hotel']['id'], $parent_booking_rowid);
		
		$data['booking_items'] = $booking_items;
		
		$data['booking_total'] = $this->get_booking_infos($booking_items);

		$parent_id = isset($booking_items) && count($booking_items) > 0 ? $booking_items[0]['rowid'] : '';
		
		$data['parent_id'] = $parent_id;
		
		$destination_id = $data['hotel']['destination_id'];
		
		$data['metas'] = site_metas(HOTEL_BOOKING, $data['hotel']);
		
		$des = $this->HotelModel->getDestination($destination_id);
		$data['navigation'] = create_hotel_booking_nav_link(true, $data['hotel'], $des);

		// get faq data
		$data = load_faq_by_context(24, $data);
		
		// show progress tracker bar
		$data['progress_tracker_id'] = 2;
		$data['progress_tracker'] = $this->load->view('common/progress_tracker', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		
		
		
		$service_type = HOTEL;		
		
		$current_item_info['service_id'] = $data['hotel']['id'];
		
		$current_item_info['service_type'] = $service_type;
		
		$current_item_info['url_title'] = $data['hotel']['url_title'];
		
		$current_item_info['normal_discount'] = 0; // don't use this data
		
		$current_item_info['is_main_service'] = false; // don't use this data
		
		$current_item_info['destination_id'] = $destination_id;
		
		$current_item_info['is_booked_it'] = true;
		
		$data['current_item_info'] = $current_item_info;
		
		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['arrival_date']);
		
		
		// load why use view
		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);
		
		$data['atts'] = get_popup_config('extra_detail');
		
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		
		return $data;
		
	}
	
	function set_optional_services($my_booking){
		
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
				
				$children_rate = $this->TourModel->get_children_rate($tour_id);
				
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
	
	function get_all_booking_items($hotel_id, $parent_booking_rowid){
		
		$main_item = false;
		
		$related_booking_items = array();
		
		$my_booking = get_my_booking();
		
		foreach ($my_booking as $key => $booking_item){			
			
			if ($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL)		
			{
				if (!empty($parent_booking_rowid)){
					
					if ($booking_item['rowid'] == $parent_booking_rowid){
						
						$main_item = $booking_item;
					}
					
				} else {
					
					if ($booking_item['service_id'] == $hotel_id){
						
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
		
			$related_booking_items = $this->set_optional_services($related_booking_items);
			
			return $related_booking_items;
			
		} else {
			
			return array();
			
		}
		
		
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