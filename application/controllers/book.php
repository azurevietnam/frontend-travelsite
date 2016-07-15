<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Book extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('TourModel', 'FaqModel','BookingModel','HotelModel','CruiseModel'));
		$this->load->library(array('TimeDate','cart'));
		$this->load->language(array('cruise','tourdetail','faq','hotel','booktogether'));
		$this->load->helper(array('form','text','group','booking','tour'));
		
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
		$data = $this->set_common_data();
		
		$action = $this->input->post('action_type');
		
		$mode = $this->uri->segment(4);
		
		$data['mode'] = $mode;
		
		$data['action'] = $action;
		
		$data = $this->load_data_by_action($action, $data);
		
		$data['navigation'] = createBookTogetherLink($data['service_1']['name'],$data['service_2']['name']);
		
		$data['main'] = $this->load->view('common/book_together/book_together', $data, TRUE);
		
		$this->load->view('template', $data);
	}

	function set_common_data(){
		
		$data = array();
		
		$data = buildTourSearchCriteria($data);
		
		$data = load_faq_by_context(24, $data);
		
		$data['metas'] = site_metas(BOOK_TOGHETHER);
		
		$data['atts'] = get_popup_config('extra_detail');
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		$search_criteria = $data['search_criteria'];
		
		$data['check_rates'] = get_check_rate_together_info($search_criteria);
		
		$data['cabin_types'] = $this->config->item('cabin_types');
		
		$data['unit_types'] = $this->config->item('unit_types');
		
		return $data;
	}
	
	function load_data_by_action($action, $data){
		
		$url_title_1 = $this->uri->segment(2);
		
		$url_title_1 = anti_sql($url_title_1);
		
		$url_title_2 = $this->uri->segment(3);
		
		$url_title_2 = anti_sql($url_title_2);
		
		$mode = $this->uri->segment(4);
		
		$check_rates = $data['check_rates'];
		
		// load tour & hotel & price data
		if ($action == 'check_rate'){
			
			
			$tour_departure_date_1 = $check_rates['departure_date_1'];			
			
			$service_1 = $this->TourModel->get_tour_by_url_title($url_title_1, $tour_departure_date_1);
			
			$service_1['service_type'] = TOUR;
			
			$service_1['num_cabin'] = 0;
			
			if ($service_1['cruise_id'] > 0){
				
				$cruise_1 = $this->CruiseModel->getCruiseById($service_1['cruise_id'], false);
				
				if ($cruise_1 != ''){
					
					$service_1['num_cabin'] = $cruise_1['num_cabin'];
					
					$service_1['cruise'] = $cruise_1;
					
				}
				
			}
			
			$tour_children_price_1 = $this->TourModel->get_children_cabin_price($service_1['id']);
			
			$children_rate_1 = $this->TourModel->get_children_rate($service_1['id']);
			
			$service_1['optional_services'] = set_optional_services_booking_together($service_1['optional_services'], $check_rates, $children_rate_1);
			
			$service_1['discount_together'] = $this->get_discount_of_tour($service_1, $check_rates['adults'], $check_rates['children'], $children_rate_1);
			
			
			$service_1['tour_children_price'] = $tour_children_price_1;
			
			$service_1['cabin_arangement'] = calculate_pax($check_rates['adults'], $check_rates['children'], $check_rates['infants'], $tour_children_price_1, '_1');
			
			$service_1['children_rate'] = $children_rate_1;
		
			if ($mode == 1){ // tour and hotel
				
				$hotel_dates = $check_rates['hotel_dates'];
				
				$service_2 = $this->HotelModel->get_hotel_by_url_title($url_title_2, $hotel_dates);
				
				$service_2['service_type'] = HOTEL;
				
				$service_2['discount_together'] = $this->get_discount_of_hotel($service_2, 1, $check_rates['hotel_dates'], $service_1['id']);
				
				$discount_together = $this->reset_discount_together($service_1, $service_2);
				
				$service_1['discount_together'] = $discount_together['discount_together_1'];
				
				$service_2['discount_together'] = $discount_together['discount_together_2'];
				
				$service_2['optional_services'] = set_optional_services_booking_together($service_2['optional_services'], $check_rates, HOTEL_CHILDREN_RATE);//default children rate is 75%
				
				
				$data_to_view['tour'] = $service_1;
				
				$data_to_view['hotel'] = $service_2;
				
				$data_to_view['cabin_arangement'] = $service_1['cabin_arangement'];
				
				$data_to_view['check_rates'] = $check_rates;
				
				$data_to_view['tour_children_price'] = $service_1['tour_children_price'];
				
				$data_to_view['unit_types'] = $this->config->item('unit_types');
				
				$data_to_view['is_free_visa'] = is_free_vietnam_visa($service_2['optional_services']);
				
				$data_to_view['popup_free_visa_4_tour'] = $this->load->view('ads/popup_free_visa', $data_to_view, true);
				
				$data_to_view['popup_free_visa_4_hotel'] = $this->load->view('ads/popup_free_visa_4_hotel', $data_to_view, true);
				
				$rate_view_1 = $this->load->view('common/book_together/tour_rate_table_after_checkrate', $data_to_view, TRUE);
				
				$rate_view_2 = $this->load->view('common/book_together/hotel_rate_table_after_checkrate', $data_to_view, TRUE);
				
			} else { // tour and tour
				
				$tour_departure_date_2 = $check_rates['departure_date_2'];				
				$service_2 = $this->TourModel->get_tour_by_url_title($url_title_2, $tour_departure_date_2);				
				$service_2['service_type'] = TOUR;
				$service_2['num_cabin'] = 0;
				
				if ($service_2['cruise_id'] > 0){
					
					$cruise_2 = $this->CruiseModel->getCruiseById($service_2['cruise_id'], false);
					
					if ($cruise_2 != ''){
						
						$service_2['num_cabin'] = $cruise_2['num_cabin'];
						
						$service_2['cruise'] = $cruise_2;
						
					}
					
				}
		
				$tour_children_price_2 = $this->TourModel->get_children_cabin_price($service_2['id']);				
				$children_rate_2 = $this->TourModel->get_children_rate($service_2['id']);
				
				$service_2['optional_services'] = set_optional_services_booking_together($service_2['optional_services'], $check_rates, $children_rate_2);
				$service_2['discount_together'] = $this->get_discount_of_tour($service_2, $check_rates['adults'], $check_rates['children'], $children_rate_2);
				
				$service_2['tour_children_price'] = $tour_children_price_2;		
				$service_2['cabin_arangement'] = calculate_pax($check_rates['adults'], $check_rates['children'], $check_rates['infants'], $tour_children_price_2, '_2');				
				$service_2['children_rate'] = $children_rate_2;
				
				$discount_together = $this->reset_discount_together($service_1, $service_2);
								
				$service_1['discount_together'] = $discount_together['discount_together_1'];				
				$service_2['discount_together'] = $discount_together['discount_together_2'];
				
				$data_to_view['tour'] = $service_1;				
				$data_to_view['cabin_arangement'] = $service_1['cabin_arangement'];
				$data_to_view['check_rates'] = $check_rates;
				$data_to_view['tour_children_price'] = $service_1['tour_children_price'];
				
				$data_to_view['unit_types'] = $this->config->item('unit_types');
				$data_to_view['popup_free_visa_4_tour'] = $this->load->view('ads/popup_free_visa', $data_to_view, true);
				
				$rate_view_1 = $this->load->view('common/book_together/tour_rate_table_after_checkrate', $data_to_view, TRUE);
				
				
				$data_to_view['tour'] = $service_2;				
				$data_to_view['cabin_arangement'] = $service_2['cabin_arangement'];
				$data_to_view['check_rates'] = $check_rates;
				$data_to_view['tour_children_price'] = $service_2['tour_children_price'];
				$rate_view_2 = $this->load->view('common/book_together/tour_rate_table_after_checkrate', $data_to_view, TRUE);
				
			}
			
		} else { //load tour & hotel: no need load price data
			
			if ($mode == 1){ // tour and hotel
				
				$service_1 = $this->TourModel->get_tour_by_url_title($url_title_1);
				
				$service_1['num_cabin'] = 0;
				
				if ($service_1['cruise_id'] > 0){
					
					$cruise_1 = $this->CruiseModel->getCruiseById($service_1['cruise_id'], false);
					
					if ($cruise_1 != ''){
						
						$service_1['num_cabin'] = $cruise_1['num_cabin'];
						
						$service_1['cruise'] = $cruise_1;
						
					}
					
				}
				
				$service_2 = $this->HotelModel->get_hotel_by_url_title($url_title_2);
				
				$service_1['service_type'] = TOUR;
				
				$service_2['service_type'] = HOTEL;
				
				$data_to_view['tour'] = $service_1;
				
				$data_to_view['hotel'] = $service_2;
				
				$rate_view_1 = $this->load->view('common/book_together/tour_rate_table_before_checkrate', $data_to_view, TRUE);
				
				$rate_view_2 = $this->load->view('common/book_together/hotel_rate_table_before_checkrate', $data_to_view, TRUE);
				
			} else { // tour & tour
				
				$service_1 = $this->TourModel->get_tour_by_url_title($url_title_1);
				
				$service_2 = $this->TourModel->get_tour_by_url_title($url_title_2);
				
				$service_1['service_type'] = TOUR;
				
				$service_2['service_type'] = TOUR;
				
				$service_1['num_cabin'] = 0;
				
				if ($service_1['cruise_id'] > 0){
					
					$cruise_1 = $this->CruiseModel->getCruiseById($service_1['cruise_id'], false);
					
					if ($cruise_1 != ''){
						
						$service_1['num_cabin'] = $cruise_1['num_cabin'];
						
						$service_1['cruise'] = $cruise_1;
						
					}
					
				}
				
				$service_2['num_cabin'] = 0;
				
				if ($service_2['cruise_id'] > 0){
					
					$cruise_2 = $this->CruiseModel->getCruiseById($service_2['cruise_id'], false);
					
					if ($cruise_2 != ''){
						
						$service_2['num_cabin'] = $cruise_2['num_cabin'];
						
						$service_2['cruise'] = $cruise_2;
						
					}
					
				}
				
				
				$data_to_view['tour'] = $service_1;			
				
				$rate_view_1 = $this->load->view('common/book_together/tour_rate_table_before_checkrate', $data_to_view, TRUE);
				
				
				$data_to_view['tour'] = $service_2;
				$rate_view_2 = $this->load->view('common/book_together/tour_rate_table_before_checkrate', $data_to_view, TRUE);
				
			}
			
		}
		
		
		if ($service_1 === FALSE || $service_2 === FALSE){
			
			//redirect(site_url()); 
			
		}
		
		$data['service_1'] = $service_1;
		
		$data['service_2'] = $service_2;
		
		$data['rate_view_1'] = $rate_view_1;
		
		$data['rate_view_2'] = $rate_view_2;
		
		if ($action == 'check_rate'){
			
			$booking_services[] = $service_1;
			
			$booking_services[] = $service_2;
			
			$data['booking_services'] = $booking_services;
			
			$data['book_extra_services'] = $this->load->view('common/book_together/book_extra_services', $data, TRUE);
			
		}
		
		$data['check_rate_together'] = $this->load->view('common/book_together/check_rate_together', $data, TRUE);
		
		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);
		
		return $data;
	}
	
	function get_discount_of_tour($tour, $adults, $children, $children_rate){
		
		$service_id = $tour['id'];
		
		$service_type = TOUR;
		
		if ($tour['cruise_id'] > 0){
						
			$service_type = CRUISE;	
		}
		
		$is_main_service = $this->BookingModel->is_main_service($tour['main_destination_id'], $service_type);
		
		$discount_coefficient = $adults + ($children * $children_rate / 100);
		
		$normal_discount = $tour['price']['discount'];
		
		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
		
		return $discount_together;
	}
	
	function get_discount_of_hotel($hotel, $rooms, $hotel_dates, $tour_id){

		$nights = count($hotel_dates);
		
		$is_main_service = $this->BookingModel->is_main_service($hotel['destination_id'], HOTEL);
		
		$normal_discount = $this->BookingModel->get_hotel_discount($hotel['id'], $hotel_dates[0]);
		
		$service_id = $hotel['id'];
		
		$service_type = HOTEL;
		
		$discount_coefficient = $rooms * $nights;

		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
			
		return $discount_together;
		
	}
	
	function reset_discount_together($service_1, $service_2){
		
		$id_1 = $service_1['id'];		
		$type_1 = $service_1['service_type'];
		if ($type_1 == TOUR){
			if ($service_1['cruise_id'] > 0){
				$type_1 = CRUISE;
			}
		}
		
		$id_2 = $service_2['id'];
		$type_2 = $service_2['service_type'];
		if ($type_2 == TOUR){
			if ($service_2['cruise_id'] > 0){
				$type_2 = CRUISE;
			}
		}
		
		$specific_discount = get_discount_2_services($id_1, $type_1, $id_2, $type_2);
		
		$discount_together_1 = $service_1['discount_together'];

		$discount_together_2 = $service_2['discount_together'];
		
		$ret = array();
		
		// main service book with normal service
		if ($discount_together_1['is_main_service']){
			
			$discount_together_1['discount'] = 0;
			
			$discount_together_1['is_discounted'] = false;
			
			$discount_together_1['discounted_rowids'] = array();
			
	

			if ($specific_discount > $discount_together_2['normal_discount']){
				
				$discount_together_2['discount'] = $specific_discount * $discount_together_2['discount_coefficient'];
				
			} else {
				
				$discount_together_2['discount'] = $discount_together_2['normal_discount'] * $discount_together_2['discount_coefficient'];
			}
			
			$discount_together_2['is_discounted'] = true;
				
				
			
			
		}
		
		// normal service book with main service
		if (!$discount_together_1['is_main_service'] && $discount_together_2['is_main_service']){
			
			$discount_together_2['discount'] = 0;
			
			$discount_together_2['is_discounted'] = false;
			
			$discount_together_2['discounted_rowids'] = array();
		
				
			if ($specific_discount > $discount_together_1['normal_discount']){
					
				$discount_together_1['discount'] = $specific_discount * $discount_together_1['discount_coefficient'];
				
			} else {
				
				$discount_together_1['discount'] = $discount_together_1['normal_discount'] * $discount_together_1['discount_coefficient'];
			}
				
				
			$discount_together_1['is_discounted'] = true;
				
		}
		
		// 2 normal service book together
		
		if (!$discount_together_1['is_main_service'] && !$discount_together_2['is_main_service']){
			
			$discount_together_1['discount'] = $discount_together_1['normal_discount'] * $discount_together_1['discount_coefficient'];
		
			if ($specific_discount > $discount_together_2['normal_discount']){
				
				$discount_together_2['discount'] = $specific_discount * $discount_together_2['discount_coefficient'];
				
			} else {
				
				$discount_together_2['discount'] = $discount_together_2['normal_discount'] * $discount_together_2['discount_coefficient'];
			}
			
			if($discount_together_2['discount'] >= $discount_together_1['discount']){
				
				$discount_together_1['discount'] = 0;
			
				$discount_together_1['is_discounted'] = false;
			
				$discount_together_1['discounted_rowids'] = array();
				
			} else {
				
				$discount_together_2['discount'] = 0;
			
				$discount_together_2['is_discounted'] = false;
			
				$discount_together_2['discounted_rowids'] = array();
				
			}
				
		}
		
		
		$ret['discount_together_1'] = $discount_together_1;
		
		$ret['discount_together_2'] = $discount_together_2;
		
		
		
		return $ret;
	}
	
	function addcart(){
		
		$data = $this->set_common_data();
		
		$url_title_1 = $this->uri->segment(2);
		
		$url_title_2 = $this->uri->segment(3);
		
		$mode = $this->uri->segment(4);
				
		$tour_id = $this->insert_tour_to_cart($url_title_1, 1, $data);
		
		if ($mode == 1){
			
			$this->insert_hotel_to_cart($url_title_2, $data, $tour_id);
			
		} else {
			
			$this->insert_tour_to_cart($url_title_2, 2, $data);
		}
		
		redirect('/my-booking/');
	}
	
	function insert_optional_service($data, $parent_rowid, $mode = TOUR){
		
		if ($mode == TOUR){
		
			$tour = $data['tour'];
			
			$id_index = $tour['id'].'_'.TOUR;
			
			$check_rates = $data['check_rates'];
			
			$children_rate = $data['children_rate'];
			
			$optional_services = $tour['optional_services'];
			
			$partner_obj_id = $tour['partner_id'];
		
		} elseif($mode == HOTEL){
			
			$hotel = $data['hotel'];
			
			$id_index = $hotel['id'].'_'.HOTEL;
			
			$check_rates = $data['check_rates'];
			
			$children_rate = HOTEL_CHILDREN_RATE;
			
			$optional_services = $hotel['optional_services'];
			
			$partner_obj_id = $hotel['partner_id'];
			
		}
		
		$total_acc = $this->get_total_acc_of_booking_item($parent_rowid);
		
		$optional_services = set_optional_services_booking_together($optional_services, $check_rates, $children_rate, $total_acc);
		
		if (isset($optional_services['transfer_services'])){
		
			foreach ($optional_services['transfer_services'] as $transfer){
						
				$name = $transfer['name'];
							
				$unit = $transfer['unit'];
				
				$rate = $transfer['rate'];
				
				$amount = $transfer['total_price'];
				
				$service_id = $transfer['optional_service_id'];
				
				$reservation_type = RESERVATION_TYPE_TRANSFER;
				
				$selected = $this->input->post($id_index.'_'.$service_id.'_selected');
				
				$partner_id = '';
				// shuttle bus
				if($transfer['unit_type'] == 1){
					$partner_id = $partner_obj_id;
				}
				
				add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $transfer['description'], $unit, $rate, $amount, '', $partner_id);
				
			}
		
		}
		
		if (isset($optional_services['extra_services'])){
			
			foreach ($optional_services['extra_services'] as $extra){
								
				$name = $extra['name'];
				
				$unit = $extra['unit'];
				
				$rate = $extra['rate'];
				
				$amount = $extra['total_price'];
				
				$service_id = $extra['optional_service_id'];
				
				$reservation_type = RESERVATION_TYPE_OTHER;
				
				$unit_change = $this->input->post($id_index.'_'.$service_id.'_unit');
				
				$unit_text = '';
				
				if (!empty($unit_change)){
					
					$unit = $unit_change;
					
					$amount = $extra['price'] * $unit;
					
					$unit_text = ' pax';
					
				}
				
				$partner_id = '';
				
				if (strpos($name, 'Visa') === FALSE){
					$partner_id = $partner_obj_id;
				} else {
					//echo 'Visa here';exit();
				}
				
				$selected = $this->input->post($id_index.'_'.$service_id.'_selected');
				
				add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $extra['description'], $unit, $rate, $amount, $unit_text, $partner_id);
				
			}
		}
	}
	
	function insert_tour_to_cart($url_title, $index, $data){
		
		$check_rates = $data['check_rates'];
		
		if ($index == 1){
			
			$departure_date = $check_rates['departure_date_1'];
			
		} else {
			
			$departure_date = $check_rates['departure_date_2'];
			
		}
		
		$data['tour'] = $this->TourModel->get_tour_by_url_title($url_title, $departure_date);
		
		$service_id = TOUR;
		
		if ($data['tour']['cruise_id'] > 0){
			
			$data['cruise'] = $this->TourModel->get_cruise_of_tour($data['tour']['cruise_id'],$data['tour']['id'], $departure_date);
			
			$data['tour']['num_cabin'] = $data['cruise']['num_cabin'];
			
			$service_id = CRUISE;
			
		} else {
			$data['tour']['num_cabin'] = 0;
		}

		
		$data['booking_info'] = $this->get_booking_info_tour($data['tour'], $check_rates, $index);
		
		
		$tour_children_price = $this->TourModel->get_children_cabin_price($data['tour']['id']);
		

		$data['pax_accom_info'] = calculate_pax($data['booking_info']['adults'], $data['booking_info']['children'], $data['booking_info']['infants'], $tour_children_price, $index);
		
		/*
		if ($data['tour']['cruise_id'] > 0 && !is_private_tour($data['tour']) && $data['tour']['num_cabin'] > 0){ // cruise tour
			
		} else {
			
			$data['pax_accom_info']['num_pax'] = get_pax_calculated($data['booking_info']['adults'], $data['booking_info']['children'], $data['tour']);
			
		}*/	
		
		$data['tour_children_price'] = $tour_children_price;
		
		$data['children_rate'] = $this->TourModel->get_children_rate($data['tour']['id']);	
	
		
		$data['discount_together'] = $this->get_discount_of_tour($data['tour'], $check_rates['adults'], $check_rates['children'], $data['children_rate']);
		
		$booking_rowid = insert_tour_accomodation_to_cart($data);
		
		$this->insert_optional_service($data, $booking_rowid);
		
		return $data['tour']['id'];
	}
	
	function insert_hotel_to_cart($url_title, $data, $tour_id){
		
		$check_rates = $data['check_rates'];
		
		$hotel_dates = $check_rates['hotel_dates'];
				
		$hotel = $this->HotelModel->get_hotel_by_url_title($url_title, $hotel_dates);
		
		$hotel['is_free_visa'] =$this->HotelModel->is_free_visa($hotel['id']);
		
		$data['hotel'] = $hotel;
		
		$data = $this->set_booking_info_hotel($data);
		
		$rooms = get_hotel_room_number($data['hotel']);
		
		$data['discount_together'] = $this->get_discount_of_hotel($hotel, $rooms, $check_rates['hotel_dates'], $tour_id);
		
		$booking_rowid = insert_hotel_acoomodation_to_cart($data);
		
		$this->insert_optional_service($data, $booking_rowid, HOTEL);
	}
	
	function get_booking_info_tour($tour, $check_rates, $index){
		
		if ($index == 1){
			
			$departure_date = $check_rates['departure_date_1'];
			
		} else {
			
			$departure_date = $check_rates['departure_date_2'];
		}
	
		$end_date = $this->timedate->date_add($departure_date, 0, 0, $tour['duration'] - 1);
		
		$check_rates['departure_date'] = $departure_date;
		
		$check_rates['end_date'] = $end_date;
		
		$check_rates['accommodation'] = $this->input->post('accommodation_'.$tour['id']);
		
		return $check_rates;
	}
	
	function get_total_acc_of_booking_item($rowid){
		
		$my_booking = get_my_booking();
		
		foreach ($my_booking as $item){
			
			if ($item['rowid'] == $rowid){
				
				return $item['total_price'];
				
			}
			
		}
		return 0;
		
	}
	
	function set_booking_info_hotel($data){
		
		$total_price = 0;
		
		$total_promotion_price = 0;
		
		$hotel = $data['hotel'];
		
		foreach ($hotel['room_types'] as $key => $value) {
			$input_name = "nr_room_type_" . $value['id'];
			
			$nr_room = $this->input->post($input_name);
			
			
			$extra_bed_name = "nr_extra_bed_" . $value['id'];
			$nr_extra_bed = $this->input->post($extra_bed_name);
			
			if ($nr_extra_bed > $nr_room){
				$nr_extra_bed = $nr_room;
			}
			
			$value['nr_room'] = $nr_room;
			
			$value['nr_extra_bed'] = $nr_extra_bed;
			
			$data['hotel']['room_types'][$key] = $value;
			
			$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_promotion_price;
			
			$total_price = $nr_room * $value['price']['price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_price;
			
		}
		
		$data['total_promotion_price'] = $total_promotion_price;
		
		$data['total_price'] = $total_price;
		
		$data['countries'] = $this->config->item('countries');
		
		$hotel_dates = $data['check_rates']['hotel_dates'];
				
		$search_criteria['arrival_date'] = date(DATE_FORMAT_STANDARD, strtotime($hotel_dates[0]));
		
		$search_criteria['departure_date'] = date(DATE_FORMAT_STANDARD, strtotime($hotel_dates[count($hotel_dates) - 1]));
		
		$search_criteria['staying_dates'] = $hotel_dates;
		
		$search_criteria['hotel_night'] = count($hotel_dates);
		
		$search_criteria['hotel_date_text'] = get_hotel_dates_text($hotel_dates);
		
		$data['search_criteria'] = $search_criteria;
		
		return $data;
		
	}

}
?>