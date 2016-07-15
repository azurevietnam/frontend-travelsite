<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function update_hotel_price_to_net_price($prices){

	$CI =& get_instance();

	$net_rate = $CI->config->item('net_rate');

	foreach ($prices as $key=>$value){

		$value['price_from'] = $value['price_from'] / $net_rate;

		$prices[$key] = $value;

	}

	return $prices;
}

function update_hotel_price_value_to_net($price){
	$CI =& get_instance();
	$net_rate = $CI->config->item('net_rate');
	$price = $price / $net_rate;
	return $price;
}

/**
 * Load Hotel Check-Rate Form
 *
 * @author Khuyenpv
 * @since 06.04.2015
 */
function load_hotel_check_rate_form($data, $is_mobile, $hotel, $loading_asyn = true, $is_book_together = false){

	$CI =& get_instance();

	$view_data['hotel'] = $hotel;
	$view_data['is_book_together'] = $is_book_together;
	$view_data['form_action'] = empty($data['form_action']) ? get_page_url(HOTEL_DETAIL_PAGE, $hotel) : $data['form_action'];

	// get check rate information from the url
	$check_rates = get_hotel_check_rate_from_url($hotel);

	$view_data['check_rates'] = $check_rates;

	/**
	 * Load the Datepicker Element
	 */
	$datepicker_options = array();

	$datepicker_options['day_id'] = 'hotel_day_'.$hotel['id'];
	$datepicker_options['month_id'] = 'hotel_month_'.$hotel['id'];
	$datepicker_options['date_id'] = 'hotel_date_'.$hotel['id'];
	$datepicker_options['date_name'] = 'hotel_date_'.$hotel['id'];
	$datepicker_options['css'] = 'col-xs-5';
	$datepicker_options['loading_asyn'] = $loading_asyn;

	$datepicker_options['night_nr'] = empty($check_rates['night_nr']) ? 1 : $check_rates['night_nr']; // default is 1 night

	$datepicker_options['night_nr_id'] = 'night_nr_'.$hotel['id'];

	if(!empty($check_rates['start_date'])){
		$datepicker_options['departure_date'] = $check_rates['start_date'];
	}

	$view_data['datepicker'] = load_datepicker($is_mobile, $datepicker_options);

	$view_data['datepicker_options'] = $datepicker_options;

	$view_data['is_ajax'] = $CI->input->is_ajax_request();

	$data['check_rate_form'] = load_view('hotels/check_rates/check_rate_form', $view_data, $is_mobile);

	return $data;

}

/**
 * Load Hotel Rate Table
 *
 * @author Khuyenpv
 * @since 06.04.2015
 */
function load_hotel_rate_table($data, $is_mobile, $hotel, $is_book_together = false){

	$CI =& get_instance();

	$CI->load->model('HotelModel');

	$check_rates = get_hotel_check_rate_from_url($hotel);

	$view_data['hotel'] = $hotel;

	$view_data['check_rates'] = $check_rates;

	$view_data['is_book_together'] = $is_book_together;


	if(!empty($data['parent_id'])){
		$view_data['parent_id'] = $data['parent_id'];
	}

	// hotel start-date & end-date
	$start_date = !empty($check_rates['start_date']) ? $check_rates['start_date'] : '';
	$end_date = '';
	if($start_date != '' && $check_rates['night_nr'] > 0){
		$end_date = date(DATE_FORMAT_STANDARD, strtotime($start_date. ' +'.$check_rates['night_nr'].' days'));
	}

	if(empty($check_rates['staying_dates'])){ // for normal hotel check-rate

		$room_types = $CI->HotelModel->getRoomTypes($hotel['id'], $start_date, $end_date);

	} else { // for check_rate in Hotel Book-Together Page

		$room_types = $CI->HotelModel->get_hotel_rooms($hotel['id'], $check_rates['staying_dates']);
	}

	foreach ($room_types as $key => $value){
		$value['facilities'] = $CI->HotelModel->getRoomTypeFacilities($value['id']);

		$value['room_info'] = load_room_info($is_mobile, $value);

		$value['special_offers'] = get_room_special_offers($is_mobile, $value);

		$room_types[$key] = $value;
	}
	$view_data['room_types'] = $room_types;

    $nigh_nr = !empty($check_rates['night_nr']) ? $check_rates['night_nr'] : 0;

    if(!empty($check_rates['staying_dates'])){ // check-rate in booking-together function
        $nigh_nr = count($check_rates['staying_dates']);
    }

    $view_data['discount_together'] = empty($data['discount_together']) ? get_hotel_discount_together(1, $nigh_nr, $start_date, $hotel) : $data['discount_together'];

    $data['discount_together'] = $view_data['discount_together'];

    if(empty($check_rates)){ // not check-rate yet

        $data['hotel_rate_table'] = load_view('hotels/check_rates/hotel_rooms', $view_data, $is_mobile);

    } else {

        $is_free_visa = $CI->HotelModel->is_free_visa($hotel['id']);

        if($is_free_visa){
            $view_data['popup_free_visa'] = load_free_visa_popup($is_mobile);
        }


        $staying_dates = empty($check_rates['staying_dates']) ? get_date_arr($start_date, $end_date) : $check_rates['staying_dates'];


		// get hotel additional services
		$optional_services = $CI->HotelModel->get_hotel_optional_services($hotel['id'], $staying_dates);
		$additional_charges = $CI->HotelModel->get_hotel_additional_charge($hotel['id'], $staying_dates);
		$optional_services['additional_charge'] = $additional_charges;
		$view_data['optional_services'] = $optional_services;

		$view_data['max_room'] = $CI->config->item('max_room');

		if(!$is_book_together){
			$view_data['get_params'] = $CI->input->get();
		}

		$view_data['is_ajax'] = $CI->input->is_ajax_request();

		$data['hotel_rate_table'] = load_view('hotels/check_rates/hotel_rates', $view_data, $is_mobile);

		$data['optional_services'] = $optional_services; // save for later using in Booking-Together Module

	}

	return $data;
}

/**
 * Load list top hotel destinations
 * TinVM May 19 2015
 */
function load_top_hotel_destinations($data, $is_mobile){
    $CI =& get_instance();

    $CI->load->model('Hotel_Model');

    $view_data['top_hotel_des'] = $CI->Hotel_Model->get_top_hotel_destinations();

    if(!empty($view_data['top_hotel_des'])){
        $data['hotel_destinations'] = load_view('hotels/common/top_hotel_destinations', $view_data, $is_mobile);
    }
    else
        $data['hotel_destinations'] = '';

    $data['top_hotel_destinations'] = $view_data['top_hotel_des']; // save for later used

    return $data;
}

/**
 * Load list popular cities hotel
 * TinVM May 19 2015
 */
function load_popular_hotel_destinations($data, $is_mobile){
    $CI =& get_instance();

    $CI->load->model('Hotel_Model');

    $view_data['hotel_des'] = $CI->Hotel_Model->get_hotel_destinations();

    if(!empty($view_data['hotel_des']))
        $data['popular_cities'] = load_view('hotels/common/popular_hotel_destinations', $view_data, $is_mobile);
    else
        $data['popular_cities'] = '';

    return $data;
}

/**
 * Load all hotel in destination
 * TinVM May 19 2015
 */
function load_hotel_in_destination($data, $is_mobile){

    if($is_mobile) return $data;

    $CI =& get_instance();

    $CI->load->model('Hotel_Model');

    $des = $data['destination'];

    $hotels = $CI->Hotel_Model->get_all_hotels_in_destination($des['id']);

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

    $data['hotel_in_destination'] = load_view('hotels/destination/hotel_in_destination', $data, $is_mobile);

    return $data;
}

/**
 * Load list hotel
 * TinVM May 19 2015
 */
function load_list_hotels($data, $is_mobile, $hotels, $is_hotel_destination = false, $is_enable_number = FALSE, $is_ajax = false){

    $CI =& get_instance();

    if(!empty($hotels)){

    	$view_data['hotels'] = $hotels;

    	$view_data['is_enable_number'] = $is_enable_number;

        $view_data['is_hotel_destination'] = $is_hotel_destination;

        if (!empty($data['destination'])) {
            $view_data['destination'] = $data['destination'];
        }

        $view_data['is_ajax'] = $is_ajax;

    	$data['list_hotels'] = load_view('hotels/common/list_hotels', $view_data, $is_mobile);

    } else {
    	$data['list_hotels'] = '';
    }

    return $data;
}

/**
 * Get the current hotel start date
 *
 * @author TinVm
 * @since Jun10 2015
 */
function get_current_hotel_start_date($hotel = ''){

    $start_date = date(DATE_FORMAT_STANDARD);

    $check_rates = !empty($hotel) ? get_hotel_check_rate_from_url($hotel) : array();

    if(!empty($check_rates['start_date'])){

        $start_date = $check_rates['start_date'];

    } else {

        $lasted_search = get_last_search(HOTEL_SEARCH_HISTORY);

        if(!empty($lasted_search['start_date'])){

            $start_date = $lasted_search['start_date'];
        }

    }

    if (date(DB_DATE_FORMAT, strtotime($start_date)) < date(DB_DATE_FORMAT)){
        $start_date = date(DATE_FORMAT_STANDARD);
    }

    return $start_date;
}

/**
 * Khuyenpv Feb 27 2015
 * Load tour booking conditions
 */
function load_hotel_booking_conditions($data, $is_mobile, $hotel){

    $CI =& get_instance();

    if(empty($hotel)){
        $data['hotel_booking_conditions'] = '';
        return $data;
    }


    $check_rates = get_hotel_check_rate_from_url($hotel);

    if(!empty($hotel['cancellation_prepayment']))
            $hotel['cancellation_prepayment'] = nl2br($hotel['cancellation_prepayment']);

    if(!empty($hotel['children_extra_bed']))
            $hotel['children_extra_bed'] = nl2br($hotel['children_extra_bed']);

    if(!empty($hotel['note']))
                $hotel['note'] = nl2br($hotel['note']);

    $view_data['hotel'] = $hotel;

    $data['hotel_booking_conditions'] = load_view('hotels/check_rates/hotel_booking_conditions', $view_data, $is_mobile);

    return $data;
}

/**
 * Get Inner Substring
 * @author TinVM
 * @since July21 2015
 */
function get_inner_substring($string,$delim){

    $string = explode($delim, $string, 3);

    return isset($string[1]) ? $string[1] : '';
}

?>