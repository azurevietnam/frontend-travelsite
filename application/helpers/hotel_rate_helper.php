<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	 * Get Hotel Check-Rate from URL
	 * 
	 * @author Khuyenpv
	 * @since 06.04.2015
	 */
	function get_hotel_check_rate_from_url($hotel){
		
		$CI =& get_instance();
		
		$check_rates = array();

		$start_date = $CI->input->get('hotel_date_'.$hotel['id']);
		
		$night_nr = $CI->input->get('night_nr_'.$hotel['id']);
		
		$staying_dates = $CI->input->get('staying_dates');
		if(!empty($staying_dates)){
			$check_rates['staying_dates'] = $staying_dates;
			$night_nr = count($staying_dates);
		}
		
	
		$action = $CI->input->get('action');
		if($action != '') $check_rates['action'] = $action;
		
		if($start_date != '') $check_rates['start_date'] = $start_date;
		if($night_nr != '') $check_rates['night_nr'] = $night_nr;
		
	
		return $check_rates;
	}
	
	/**
	 * Load the tour accommodation detail information
	 * @author Khuyenpv
	 * @since March 19 2015
	 */
	function load_room_info($is_mobile, $room){
	
		$view_data['room'] = $room;
	
		$room_info_view = load_view('hotels/check_rates/room_info', $view_data, $is_mobile);
	
		return $room_info_view;
	}
	
	/**
	 * Generate the special Offer for each hotel room type
	 * 
	 * @author Khuyenpv
	 * @since 16.04.2015
	 */
	function get_room_special_offers($is_mobile, $room){
		
		$special_offer = '';
		
		$deal_info = !empty($room['price']['deal_info']) ? $room['price']['deal_info'] : array();
		
		if(!empty($deal_info)){

			$offer_note = !empty($room['price']['hotel_promotion_note']) ? $room['price']['hotel_promotion_note'] : array();
			
			$offer_name = $deal_info['name'];
			
			$offer_cond =get_promotion_condition_text($deal_info);
			
			$special_offer = load_promotion_popup_4_old_storing($is_mobile, $offer_name, $offer_note, $offer_cond, $room['id']);
		}
		
		return $special_offer;
	}
	
	
	/**
	 * Get hotel discount together
	 * 
	 * @author Khuyenpv
	 * @since 06.04.2015
	 */
	function get_hotel_discount_together($rooms, $nights, $start_date, $hotel){
		
		$CI =& get_instance();
		
		$CI->load->model('BookingModel');
	
		$is_main_service = $CI->BookingModel->is_main_service($hotel['destination_id'], HOTEL);
	
		$normal_discount = $CI->BookingModel->get_hotel_discount($hotel['id'], $start_date);
	
	
		$service_id = $hotel['id'];
	
		$service_type = HOTEL;
	
		$discount_coefficient = $rooms * $nights;
	
		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
	
		return $discount_together;
	}

?>