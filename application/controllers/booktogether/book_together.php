<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Book_Together extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	
	
		$this->load->helper(array('basic', 'resource', 'tour', 'tour_search','tour_rate','hotel','hotel_rate','faq','text'));
	
		$this->load->model(array('Tour_Model', 'Hotel_Model','HotelModel', 'Destination_Model'));
		
		$this->load->language(array('cruise','tourdetail','hotel','booktogether'));
	
		// for test only
		//$this->output->enable_profiler(TRUE);
	}
	
	function index($url_title_1, $url_title_2, $mode)
	{
		
		$is_mobile = is_mobile();
		
		$service_1 = $this->Tour_Model->get_tour_detail($url_title_1);
		$service_1['service_type'] = $service_1['cruise_id'] > 0 ? CRUISE : TOUR;
		if($mode == 1){
			$service_2 = $this->Hotel_Model->get_hotel_detail($url_title_2);
			$service_2['service_type'] = HOTEL;
		} else {
			$service_2 = $this->Tour_Model->get_tour_detail($url_title_2);
			$service_2['service_type'] = $service_2['cruise_id'] > 0 ? CRUISE : TOUR;
				
		}
		if(empty($service_1) || empty($service_2)){
			redirect(get_page_url(HOME_PAGE));
		}
		
		// if the customer click on 'Add to Cart' Button
		$action = $this->input->get('action');
		if($action == ACTION_ADD_CART){
			$this->_add_cart($service_1, $service_2);	
		}
		
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(BOOK_TOGETHER_PAGE);
		$data['page_theme'] = get_page_theme(BOOK_TOGETHER_PAGE, $is_mobile);
	
		// load the tour search form
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);

		// load how-to-book a trip
		$data = load_how_to_book_trip($data, $is_mobile);
	
		
		$data['title_service_name'] = $service_1['name'] . ' + '. $service_2['name'];

		$data = get_page_navigation($data, $is_mobile, BOOK_TOGETHER_PAGE);
	
		
		$data = $this->_load_check_rate_form($data, $is_mobile, $service_1, $service_2);
		
		$data = $this->_load_service_rate_tables($data, $is_mobile, $service_1, $service_2);
		
		$data = $this->_load_extra_services($data, $is_mobile, $service_1, $service_2);
		
		$data['check_rate_params'] = $this->input->get();
		$data['book_together_page'] = site_url(BOOK_TOGETHER_PAGE.'/'.$url_title_1.'/'.$url_title_2.'/'.$mode).'/';
		
		// load fag by page
		$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_BOOKING);
		
		render_view('book_together/book_together', $data, $is_mobile);
		
	}
	
	/**
	 * Load the check_rate_form
	 * 
	 * @author Khuyenpv
	 * @since 17.04.2015
	 */
	function _load_check_rate_form($data, $is_mobile, $service_1, $service_2){
		
		$tmp_data = load_tour_check_rate_form(array(), $is_mobile, $service_1, array(), false, true);
		
		$view_data['check_rate_1']  = $tmp_data['check_rate_form'];
		
		if($service_2['service_type'] == HOTEL){
			$tmp_data = $this->_load_hotel_date_selections($data, $is_mobile, $service_1, $service_2);
			$view_data['check_rate_2']  = $tmp_data['hotel_date_selections'];
		} else {
			$tmp_data = load_tour_check_rate_form(array(), $is_mobile, $service_2, array(), false, true);
			$view_data['check_rate_2']  = $tmp_data['check_rate_form'];
		}
		
		$view_data['service_1'] = $service_1;
		$view_data['service_2'] = $service_2;
		
		$data['check_rate_form'] = load_view('book_together/check_rate_together', $view_data, $is_mobile);
		
		return $data;
	}
	
	/**
	 * Load the Service Rate Tables
	 * 
	 * @author Khuyenpv
	 * @since 17.04.2015
	 */
	function _load_service_rate_tables($data, $is_mobile, $service_1, $service_2){
		
		// optional service of each service
		$optional_services_1 = array();
		$optional_services_2 = array();
		
		// discountogether of each service
		$discount_together_1 = '';
		$discount_together_2 = '';
		
		// 1.get the discount_together of service_1
		$check_rates_1 = get_tour_check_rate_from_url($service_1);
		if(!empty($check_rates_1)){
			$discount_together_1 = get_tour_discount_together($service_1, $check_rates_1);
		}
		
		// 2.get the discount_together of service_2
		if($service_2['service_type'] == HOTEL){
			$check_rates_2 = get_hotel_check_rate_from_url($service_2);
			if(!empty($check_rates_2) && !empty($check_rates_2['night_nr']) && !empty($check_rates_2['staying_dates'])){
				$nights = $check_rates_2['night_nr'];
				$start_date = $check_rates_2['staying_dates'][0];
				$discount_together_2 = get_hotel_discount_together(1, $nights, $start_date, $service_2);
			}		
		} else {
			$check_rates_2 = get_tour_check_rate_from_url($service_2);
			if(!empty($check_rates_2)){
				$discount_together_2 = get_tour_discount_together($service_2, $check_rates_2);
			}
		}
		
		//3.Reset the Discount-together for the right value on rate-table
		if(!empty($discount_together_1) && !empty($discount_together_2)){
			$discounts = $this->_reset_discount_together($service_1, $service_2, $discount_together_1, $discount_together_2);
			$discount_together_1 = $discounts['discount_together_1'];
			$discount_together_2 = $discounts['discount_together_2'];
		}
		
		// load the service_1 rate table
		$rate_data = array();
		$rate_data['discount_together'] = $discount_together_1;
		$rate_data = load_tour_rate_table($rate_data, $is_mobile, $service_1, true); //service 1 is always tour
		$rate_table_1 = $rate_data['tour_rate_table'];
		if(!empty($rate_data['optional_services'])) $optional_services_1 = $rate_data['optional_services']; // set optional services
		
		$rate_data = array();
		$rate_data['discount_together'] = $discount_together_2;
		if($service_2['service_type'] == HOTEL){
			$rate_data = load_hotel_rate_table($rate_data, $is_mobile, $service_2, true);
			$rate_table_2 = $rate_data['hotel_rate_table'];
		} else {
			$rate_data = load_tour_rate_table($rate_data, $is_mobile, $service_2, true); //service 1 is always tour
			$rate_table_2 = $rate_data['tour_rate_table'];	
		}
		if(!empty($rate_data['optional_services'])) $optional_services_2 = $rate_data['optional_services']; // set optional services
		
		$view_data['rate_table_1'] = $rate_table_1;
		
		$view_data['rate_table_2'] = $rate_table_2;
		
		$view_data['service_1'] = $service_1;
		$view_data['service_2'] = $service_2;
		
		$data['rate_tables'] = load_view('book_together/rate_tables', $view_data, $is_mobile);
		
		// save optional-services for later using in Extra-service functions
		$data['optional_services_1'] = $optional_services_1;
		$data['optional_services_2'] = $optional_services_2;
		
		// save discount-together for later using in Extra-Service functions
		$data['discount_together_1'] = $discount_together_1;
		$data['discount_together_2'] = $discount_together_2;
		
		return $data;
	}
	
	/**
	 * Load the hotel date selections
	 * @author Khuyenpv
	 * @since 17.04.2015
	 */
	function _load_hotel_date_selections($data, $is_mobile, $tour, $hotel){
		
		$view_data['hotel'] = $hotel;
		$view_data['tour'] = $tour;
		
		// get tour check_rate
		$check_rates = get_tour_check_rate_from_url($tour);
		
		$start_date = !empty($check_rates['departure_date']) ? $check_rates['departure_date'] : date(DATE_FORMAT_STANDARD);
		//$start_date = $check_rates['departure_date'];
		
		$night_nr = $tour['duration'] - 1;
		$end_date = $night_nr == 1 ? $start_date : date(DATE_FORMAT_STANDARD, strtotime($start_date. ' +'.($night_nr - 1).' days'));
		//echo $start_date.$end_date.$night_nr; exit();
		$view_data['tour_start_date'] = $start_date;
		$view_data['tour_end_date'] = $end_date;
		$view_data['check_rates'] = get_hotel_check_rate_from_url($hotel);
		
		$data['hotel_date_selections'] = load_view('book_together/hotel_date_selections', $view_data, $is_mobile);
		
		return $data;
	}
	
	/**
	 * Load the Extra Services
	 *
	 * @author Khuyenpv
	 * @since 17.04.2015
	 */
	function _load_extra_services($data, $is_mobile, $service_1, $service_2){
		
		$action = $this->input->get('action');
		
		if(!empty($action)){ // only load extra-service view when user click on Action Button
		
			$view_data['service_1'] = $service_1;
			$view_data['service_2'] = $service_2;
			
			// get optional-services from global $data
			$optional_services_1 = $data['optional_services_1'];
			$optional_services_2 = $data['optional_services_2'];
			
			// get discount-together from global $data
			$discount_together_1 = $data['discount_together_1'];
			$discount_together_2 = $data['discount_together_2'];
			
			$start_date_1 = date(DATE_FORMAT_STANDARD);
			$start_date_2 = date(DATE_FORMAT_STANDARD);
			
			$check_rate_1 = array();
			$check_rate_2 = array();
			
			if(!empty($optional_services_1)){
				$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($service_1['id']);
				$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
				$check_rates = get_tour_check_rate_from_url($service_1);
				$optional_services_1 = set_optional_services_booking_together($optional_services_1, $check_rates, $children_rate);
				$start_date_1 = $check_rates['departure_date'];
				
				$check_rate_1 = $check_rates;
			}
			
			if(!empty($optional_services_2)){
				if($service_2['service_type'] == HOTEL){
					$check_rates = get_tour_check_rate_from_url($service_1);
					$optional_services_2 = set_optional_services_booking_together($optional_services_2, $check_rates, HOTEL_CHILDREN_RATE);//default children rate is 75%
					
					$hotel_check_rates = get_hotel_check_rate_from_url($service_2);
					$start_date_2 = !empty($hotel_check_rates['staying_dates']) ? $hotel_check_rates['staying_dates'][0] : $start_date_2;
					
					$check_rate_2 = $hotel_check_rates;
				} else {
					$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($service_2['id']);
					$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
					$check_rates = get_tour_check_rate_from_url($service_2);
					$optional_services_2 = set_optional_services_booking_together($optional_services_2, $check_rates, $children_rate);
					$start_date_2 = $check_rates['departure_date'];
					
					$check_rate_2 = $check_rates;
				}
			}
			
			$service_1['optional_services'] = $optional_services_1;
			$service_2['optional_services'] = $optional_services_2;
			
			$service_1['discount_together'] = $discount_together_1;
			$service_2['discount_together'] = $discount_together_2;
			
			$service_1['start_date'] = $start_date_1;
			$service_2['start_date'] = $start_date_2;
			
			$service_1['check_rates'] = $check_rate_1;
			$service_2['check_rates'] = $check_rate_2;
			
			
			$booking_services[] = $service_1;
			$booking_services[] = $service_2;
			
			$view_data['booking_services'] = $booking_services;
			
			$data['extra_services'] = load_view('book_together/extra_services', $view_data, $is_mobile);
		
		} else {
			
			$data['extra_services'] = '';
		}
		
		return $data;
	}
	
	/**
	 * Reset the service-discount-together
	 * 
	 * @author Khuyenpv
	 * @since 16.06.2015
	 */
	function _reset_discount_together($service_1, $service_2, $discount_together_1, $discount_together_2){
	
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
	
	/**
	 * Add 2 Services to Cart
	 * @author Khuyenpv
	 * @since 24.06.2015
	 */
	function _add_cart($service_1, $service_2){
		
		$booking_rowid = $this->_insert_tour_to_cart($service_1);
		
		$first_tour_check_rates = get_tour_check_rate_from_url($service_1);
		
		$this->_insert_optional_service_to_cart($service_1, $booking_rowid);
		
		if($service_2['service_type'] == HOTEL){

			$booking_rowid = $this->_insert_hotel_to_cart($service_2);
			
			$this->_insert_optional_service_to_cart($service_2, $booking_rowid, $first_tour_check_rates);
		
		} else {
			
			$booking_rowid = $this->_insert_tour_to_cart($service_2);
			
			$this->_insert_optional_service_to_cart($service_2, $booking_rowid);
		}
		//redirect(get_page_url(MY_BOOKING_PAGE));
	}
	
	/**
	 * Add Tour-Booking to Cart
	 * @author Khuyenpv
	 * @since 24.06.2015
	 */
	function _insert_tour_to_cart($tour){
		
		/**
		 * Get the selected Accommodation & Promotion
		 *
		 */
		$acc = $this->input->get('acc');
		$acc_arr = explode('_', $acc);
		 
		$acc_id = count($acc_arr) > 0 ? $acc_arr[0] : '';
		$pro_id = count($acc_arr) > 1 ? $acc_arr[1] : '';
		
		
		$parent_id = ''; // no parent_id in book-together module
		 
		$check_rates = get_tour_check_rate_from_url($tour);
		 
		// load the tour accommodations & detail acc infor view
		$departure_date = !empty($check_rates['departure_date']) ? $check_rates['departure_date'] : '';
		 
		$accommodations = $this->Tour_Model->get_tour_accommodations($tour['id'], $departure_date, $acc_id);
		 
		$cabin_arrangements = get_tour_cabin_arrangements($tour, $check_rates);
		 
		$all_promotion_details = $this->Tour_Model->get_all_tour_promotions($tour['id'], $departure_date, $pro_id);
		 
		$promotions = group_promotion_details_by_promotion($all_promotion_details);
		 
		$promotions = $this->Tour_Model->get_travel_dates($promotions);
		 
		$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($tour['id']);
		 
		$discount_together = get_tour_discount_together($tour, $check_rates, $cabin_price_cnf);
		
		
		$acc = count($accommodations) >  0 ? $accommodations[0] : array();
		$pro = count($promotions) > 0 ? $promotions[0] : array();
		 
		$optional_services = $this->Tour_Model->get_tour_optional_services($tour['id'], $departure_date , $tour['duration']);
		$additional_charges = $optional_services['additional_charge'];
		 
		$booking_rowid = insert_tour_acc_to_cart($tour, $acc, $pro, $check_rates, $cabin_arrangements, $cabin_price_cnf, $discount_together, $additional_charges, $parent_id);
		
		return $booking_rowid;
	}
	
	/**
	 * Add Hotel-Booking to Cart
	 * @author Khuyenpv
	 * @since 24.06.2015
	 */
	function _insert_hotel_to_cart($hotel){
		
		// check if the current device is Mobile or Not
		$parent_id = ''; // no parent_id in book-together module
		
		$check_rates = get_hotel_check_rate_from_url($hotel);
		 
		// hotel start-date & end-date
		$start_date = !empty($check_rates['staying_dates']) ? $check_rates['staying_dates'][0] : '';
		$nights = count($check_rates['staying_dates']);
		$end_date = !empty($check_rates['staying_dates']) ? $check_rates['staying_dates'][$nights - 1] : '';
		 
		$staying_dates = get_date_arr($start_date, $end_date);
		$room_types = $this->HotelModel->get_hotel_rooms($hotel['id'], $check_rates['staying_dates']);
	
		
		$total_price = 0;
		$total_promotion_price = 0;
		 
		$rooms = 0;
		 
		foreach ($room_types as $key => $value) {
			$input_name = "nr_room_type_" . $value['id'];
			 
			$nr_room = $this->input->get($input_name);
			 
			 
			$extra_bed_name = "nr_extra_bed_" . $value['id'];
			$nr_extra_bed = $this->input->get($extra_bed_name);
			 
			if ($nr_extra_bed > $nr_room){
				$nr_extra_bed = $nr_room;
			}
			 
			$value['nr_room'] = $nr_room;
			 
			$value['nr_extra_bed'] = $nr_extra_bed;
			 
			$room_types[$key] = $value;
			 
			$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_promotion_price;
			 
			$total_price = $nr_room * $value['price']['price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_price;
		
			$rooms += $nr_room;
		}
		 
		$hotel['room_types'] = $room_types;
		 
		$discount_together = get_hotel_discount_together($rooms, $nights, $start_date, $hotel);
		 
		$is_free_visa = $this->HotelModel->is_free_visa($hotel['id']);
		 
		$booking_rowid = insert_hotel_room_to_cart($hotel, $room_types, $start_date, $end_date, $check_rates, $is_free_visa, $discount_together, $parent_id);
		
		return $booking_rowid;
		
	}
	
	/**
	 * Insert Optional Services To Cart
	 * 
	 * @author Khuyenpv
	 * @since 24.06.2015
	 */
	function _insert_optional_service_to_cart($service, $parent_rowid, $specific_check_rates = array()){
		
		$id_index = $service['id'].'_'.$service['service_type'];
		
		$partner_obj_id = $service['partner_id'];
		
		if($service['service_type'] == HOTEL){
			
			$children_rate = HOTEL_CHILDREN_RATE;
			
			$check_rates = get_hotel_check_rate_from_url($service);
			// get hotel additional services
			$optional_services = $this->HotelModel->get_hotel_optional_services($service['id'], $check_rates['staying_dates']);
			$additional_charges = $this->HotelModel->get_hotel_additional_charge($service['id'], $check_rates['staying_dates']);
			$optional_services['additional_charge'] = $additional_charges;
			
		} else {
			
			$check_rates = get_tour_check_rate_from_url($service);
			
			$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($service['id']);
			$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
			$departure_date = !empty($check_rates['departure_date']) ? $check_rates['departure_date'] : '';
			
			$optional_services  = $this->Tour_Model->get_tour_optional_services($service['id'], $departure_date, $service['duration']);
		}

		
		$total_acc = $this->_get_total_acc_of_booking_item($parent_rowid);
		
		if(!empty($specific_check_rates)) $check_rates = $specific_check_rates; // if the service is HOTEL, the check_rates is from the Tour Check Rate
		
		$optional_services = set_optional_services_booking_together($optional_services, $check_rates, $children_rate, $total_acc);
		
		if (isset($optional_services['transfer_services'])){
		
			foreach ($optional_services['transfer_services'] as $transfer){
		
				$name = $transfer['name'];
					
				$unit = $transfer['unit'];
		
				$rate = $transfer['rate'];
		
				$amount = $transfer['total_price'];
		
				$service_id = $transfer['optional_service_id'];
		
				$reservation_type = RESERVATION_TYPE_TRANSFER;
		
				$selected = $this->input->get($id_index.'_'.$service_id.'_selected');
				
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
		
				$unit_change = $this->input->get($id_index.'_'.$service_id.'_unit');
		
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
		
				$selected = $this->input->get($id_index.'_'.$service_id.'_selected');
		
				add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $extra['description'], $unit, $rate, $amount, $unit_text, $partner_id);
		
			}
		}
		
	}
	
	function _get_total_acc_of_booking_item($rowid){
	
		$my_booking = get_my_booking();
	
		foreach ($my_booking as $item){
				
			if ($item['rowid'] == $rowid){
	
				return $item['total_price'];
	
			}
				
		}
		return 0;
	
	}
}