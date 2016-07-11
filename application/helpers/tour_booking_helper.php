<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Tour Booking Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       01.04.2015
 */


/**
 * Load Tour Extra-Services Booking
 *
 * @author Khuyenpv
 * @since 31.03.2015
 */
function load_tour_extra_services($data, $is_mobile, $tour){
	
	$CI =& get_instance();
	$CI->load->model(array('Tour_Model','HotelModel'));
	
	
	$action = $CI->input->post('action');
	
	if($action == ACTION_DELETE){
	
		$rowid = $CI->input->post('rowid');
			
		remove_booking_item($rowid);
	}
	
	
	// load children rate
	$cabin_price_cnf = $CI->Tour_Model->get_children_cabin_price($tour['id']);
	$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
	 
	$parent_booking_rowid = $CI->session->flashdata('curent_booking_rowid');


	$view_data['booking_items'] = $booking_items = get_tour_booking_items($tour['id'], $parent_booking_rowid, $children_rate);
	
	$view_data['booking_total'] = calculate_booking_total($booking_items);
	
	$view_data['tour'] = $tour;

	
	$current_boooking_item = !empty($booking_items) ? $booking_items[0] : array();
	$view_data['parent_id'] = !empty($current_boooking_item) ? $current_boooking_item['rowid'] : '';
	
	$data['extra_services'] = load_view('tours/booking/extra_services', $view_data, $is_mobile);
	
	$data['current_booking_item'] = $current_boooking_item;

	return $data;
}

/**
 * Get all booking item related to the current selected tour
 * 
 * @author Khuyenpv 
 * @since 01.04.2015
 */
function get_tour_booking_items($tour_id, $parent_booking_rowid, $children_rate){

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

		$related_booking_items = set_booking_item_optional_services($related_booking_items, $children_rate);

		return $related_booking_items;

	} else {
		return array();
	}

}

/**
 * Set Optional Services for each booking item
 * 
 * @author Khuyenpv
 * @since 01.04.2015
 * 
 */
function set_booking_item_optional_services($booking_items, $children_rate){
	
	$CI =& get_instance();

	foreach ($booking_items as $key => $booking_item){
			
		$optional_services = array();
			
		if ($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR || $booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR)
				
		{
			$tour_id = $booking_item['service_id'];

			$departure_date = $booking_item['start_date'];

			$duration = $booking_item['duration'];

			$optional_services = $CI->Tour_Model->get_tour_optional_services($tour_id, $departure_date, $duration);
			
			$booking_info = array();
			if(!empty($booking_item['booking_info'])){ // for old-version, save Check-Rates information in 'booking_info'
				$booking_info = $booking_item['booking_info'];
			}
			
			if(!empty($booking_item['check_rates'])){ // new version 2015, save Check-Rates information in 'check_rates'
				$booking_info = $booking_item['check_rates'];
				$booking_info['guest'] = generate_traveller_text($booking_info['adults'], $booking_info['children'], $booking_info['infants']);
			}

			$total_accomodation = $booking_item['total_price'];

			$optional_services = set_information_4_optional_services($optional_services, $booking_info, $children_rate, $total_accomodation, $booking_item);
				
		} elseif($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL){

			$children_rate = HOTEL_CHILDREN_RATE; // children price for optional service is 75% adult price

			$hotel_id = $booking_item['service_id'];
			
			$booking_info = isset($booking_item['booking_info']) ? $booking_item['booking_info'] : array();
			
			$booking_item['check_rates'] = $booking_info;

			$staying_dates = isset($booking_info['staying_dates']) ? $booking_info['staying_dates'] : array();

			$optional_services = $CI->Hotel_Model->get_hotel_optional_services($hotel_id, $staying_dates);

			$total_accomodation = $booking_item['total_price'];

			$optional_services = set_information_4_optional_services($optional_services, $booking_info, $children_rate, $total_accomodation, $booking_item);

		}
			
		$booking_item['optional_services'] = $optional_services;
			
		$booking_items[$key] = $booking_item;
			
	}

	return $booking_items;
}

/**
 * Calculate Total Price of Booking Items
 * 
 * @author Khuyenpv
 * @since 01.04.2015
 */
function calculate_booking_total($booking_items){
	$total = 0;
	$discount = 0;
	$final_total = 0;
	
	foreach ($booking_items as $booking_item){
		$total = $total + $booking_item['total_price'];
		$discount = $discount + $booking_item['discount'];
	}
	
	$final_total = $total - $discount;
	
	$ret['total_price'] = $total;
	$ret['discount'] = $discount;
	$ret['final_total'] = $final_total;
	
	return $ret;
}



?>