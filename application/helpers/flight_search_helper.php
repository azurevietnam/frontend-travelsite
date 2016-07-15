<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Search Flights Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 06 2015
 */


function load_flight_search_form($data, $is_mobile, $search_criteria = array(),  $display_mode = '', $show_type_tour = '', $loading_asyn = true){

	$CI =& get_instance();

	$CI->load->model('Flight_Model');

	$datepicker_depart_options = array();

	$datepicker_depart_options['day_id'] = 'departure_day_flight';
	$datepicker_depart_options['month_id'] = 'departure_month_flight';
	$datepicker_depart_options['date_id'] = 'departure_date_flight';
	$datepicker_depart_options['date_name'] = 'Depart';
	$datepicker_depart_options['css'] = $display_mode == VIEW_PAGE_HOME ? 'col-xs-2' : 'col-xs-5';
	$datepicker_depart_options['loading_asyn'] = $loading_asyn;

	if(!empty($search_criteria['Depart'])){

		$datepicker_depart_options['departure_date'] = $search_criteria['Depart'];

	}

	$view_data['datepicker_depart'] = load_datepicker($is_mobile, $datepicker_depart_options);

	$datepicker_return_options = array();

	$datepicker_return_options['day_id'] = 'returning_day_flight';
	$datepicker_return_options['month_id'] = 'returning_month_flight';
	$datepicker_return_options['date_id'] = 'returning_date_flight';
	$datepicker_return_options['date_name'] = 'Return';
	$datepicker_return_options['css'] = $display_mode == VIEW_PAGE_HOME ? 'col-xs-2' : 'col-xs-5';
	$datepicker_return_options['loading_asyn'] = $loading_asyn;

	if(!empty($search_criteria['Return'])){

		$datepicker_return_options['departure_date'] = $search_criteria['Return'];

	}

	$view_data['datepicker_return'] = load_datepicker($is_mobile, $datepicker_return_options);

	if(isset($data['multiple_search_forms'])){
		$view_data['multiple_search_forms'] = '1';
	}

	if(isset($data['search_overview'])){
		$view_data['search_overview'] = '1';
	}

	switch ($display_mode){
		case VIEW_PAGE_HOME:
			$view_data['is_home_page'] = true;
			$view_data['css_content'] = 'search-form-type-1';
			$view_data['css'] = 'padding-5';
			break;
		case VIEW_PAGE_ADVERTISE:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-2';
			$view_data['css'] = 'padding-5';
			break;
		case VIEW_PAGE_NOT_ADVERTISE:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-3';
			break;
		case VIEW_PAGE_DEAL:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-4';
			$view_data['css'] = 'padding-5';
			break;
	}

	$view_data['flight_destinations'] = $CI->Flight_Model->get_all_flight_destinations();
	
	$view_data['flight_routes']= $CI->Flight_Model->get_all_flight_routes();
	
	$view_data['search_criteria'] = $search_criteria;

	$data['search_form'] = load_view('flights/search/search_form', $view_data, $is_mobile);


	return $data;

}

/**
 * Get the search-criteria based on url parameters
 * Return Empty if the search-parameter is invalid
 *
 * @author		khuyenpv
 * @since       Feb 10 2015
 */
function get_flight_search_criteria_from_url(){
	
	
	$CI =& get_instance();
	
	$CI->load->model('Flight_Model');
	
	$type = $CI->input->get('Type', true);
	$from = $CI->input->get('From', true);	
	$to = $CI->input->get('To', true);
	$depart = $CI->input->get('Depart', true);
	$return = $CI->input->get('Return', true);
	$adt = $CI->input->get('ADT', true);
	$chd = $CI->input->get('CHD', true);
	$inf = $CI->input->get('INF', true);
	$airline = $CI->input->get('Airline', true);
	
	if(empty($from) || empty($to) || empty($depart) || empty($adt)){ // invalid url
		return false;
	}
	
	$search_criteria['Type'] = $type;
	$search_criteria['From'] = $from;
	$search_criteria['From_Code'] = _get_des_code($from);
	$search_criteria['To'] = $to;
	$search_criteria['To_Code'] = _get_des_code($to);
	$search_criteria['Depart'] = $depart;
	$search_criteria['Return'] = $return;
	$search_criteria['Type'] = $type;
	$search_criteria['ADT'] = $adt;
	$search_criteria['CHD'] = $chd;
	$search_criteria['INF'] = $inf;
	$search_criteria['Airline'] = $airline;

	$from_des = $CI->Flight_Model->get_destination_by_code($search_criteria['From_Code']);
	$to_des = $CI->Flight_Model->get_destination_by_code($search_criteria['To_Code']);

	$search_criteria['is_domistic'] = false;
	
	if(!empty($from_des) && !empty($to_des)){

		$is_domistic_from = $CI->Flight_Model->is_domistic_des($from_des['id']);
		
		$is_domistic_to = $CI->Flight_Model->is_domistic_des($to_des['id']);

		if($is_domistic_from && $is_domistic_to){
			
			$search_criteria['is_domistic'] = true;
			
		}
		
	} else {
		
		log_message('error', '[ERROR] Invalid Destination Input: From Des = '.$from.' - To Des = '.$to);		
		return false;
	}
	
	return $search_criteria;
}

function get_flight_search_criteria($data = array()){

	$CI =& get_instance();

	$search_criteria = get_flight_search_criteria_from_url();

	// set default value for flight search form
	if ($search_criteria === FALSE){
		
		// get the lasted search
		
		$search_criteria = $CI->session->userdata(FLIGHT_SEARCH_CRITERIA);
		
		if(empty($search_criteria)){
			$search_criteria = set_default_flight_search_criteria();
		}

	} 

	if(isset($data['flight_to'])) {
		$search_criteria['To'] = $data['flight_to'];
	}

	return $search_criteria;
}

/**
 * Check if the current seach is valid or not
 *
 * @author		Huutd
 * @since       28 05 2015
 */
function is_valid_flight_search($search_criteria){

	// code later for many params check

	return true;
}


function load_flight_search_overview($data, $is_mobile, $search_criteria){

	if ($is_mobile) return $data;
	
	$view_data['search_criteria'] = $search_criteria;

	$data['search_overview'] = load_view('flights/search/search_overview', $view_data, $is_mobile);

	return $data;
}


function load_flight_search_filters($data, $is_mobile, $search_criteria){
	
	if ($is_mobile) return $data;
	
	$CI =& get_instance();

	$view_data['search_criteria'] = $search_criteria;
	
	$view_data['departure_times'] = $CI->config->item('departure_times');

	$data['search_filters'] = load_view('flights/search/search_filters', $view_data, $is_mobile);

	return $data;
}

function load_flight_calendar(){
	
}

function load_flight_booking_exception($search_criteria, $code = 1, $is_mobile = FALSE){
	
	$message = lang('flight_seat_unavailable');
	//$link = get_current_flight_search_url($search_criteria);
	$link = get_flight_search_criteria_from_url();
	$link_label = lang('search_flight_again');

	if($code == 2){ // fail to get VNISC Sid

		$message = lang('fail_to_get_flights');

	} elseif($code == 3){ // flight sold out

		$message = lang('all_flight_sold_out');

		$link = get_page_url(VN_FLIGHT_PAGE);

	} elseif($code == 4){// time-out

		$message = lang('flight_timeout');
	}


	$data['message'] = $message;

	$data['link'] = $link;

	$data['link_label'] = $link_label;
	
	$request = get_flight_exception_short_req($search_criteria);

	$data = load_contact_form($data, $is_mobile, 'save_customer_contact_form');

	$mobile_view = $is_mobile ? 'mobile/' : '';

	$CI =& get_instance();
	return $CI->load->view($mobile_view.'flights/common/flight_booking_exception', $data, TRUE);
}

function load_flight_itinerary($data, $is_mobile, $search_criteria){
	
	$view_data['search_criteria'] = $search_criteria;
	
	$view_data['flight_booking'] = $data['flight_booking'];
	
	$data['flight_itinerary'] = load_view('flights/flight_booking/flight_itinerary', $view_data, $is_mobile);

	return $data;
}

function load_flight_itinerary_inter($data, $is_mobile, $search_criteria){

	$view_data['search_criteria'] = $search_criteria;
	$view_data['flight_booking'] = $data['flight_booking'];
	$data['flight_itinerary'] = load_view('flights/flight_booking/flight_itinerary_inter', $view_data, $is_mobile);

	return $data;
}

function load_flight_passenger($data, $is_mobile, $search_criteria){
	
	$CI =& get_instance();
	
	//$CI->load->config('flight_meta');
	
	$view_data['passenger_nationalities'] = $CI->config->item('passenger_nationalities');
	
	$view_data['search_criteria'] = $search_criteria;
	
	$view_data['flight_booking'] = $data['flight_booking'];
	
	$data['flight_passenger'] = load_view('flights/flight_booking/flight_passenger', $view_data, $is_mobile);
	
	return $data;
}

function load_flight_baggage_fees($data, $is_mobile, $search_criteria){

	$CI =& get_instance();
	
	$CI->load->config('flight_meta');
	
	$view_data['search_criteria'] = $search_criteria;
	
	$view_data['baggage_fee_cnf'] = $CI->config->item('baggage_fees');
	$view_data['flight_booking'] = $data['flight_booking'];
	$data['flight_baggage_fees'] = load_view('flights/flight_booking/flight_baggage_fees', $view_data, $is_mobile);

	return $data;
}

function load_flight_summary($data, $is_mobile, $search_criteria){

	//$CI->load->config('flight_meta');

	$view_data['search_criteria'] = $search_criteria;

//	$view_data['baggage_fee_cnf'] = $CI->config->item('baggage_fees');
	$view_data['flight_booking'] = $data['flight_booking'];
	$data['flight_summary'] = load_view('flights/flight_booking/flight_summary', $view_data, $is_mobile);

	return $data;
}

/**
 * Load Booking payment
 * @author HuuTD
 * @since 22.06.2015
 *
 */

function load_flight_booking_payment($data, $is_mobile, $search_criteria){
	
	if ($is_mobile) return $data;
	
	$CI =& get_instance();
	
	$view_data['search_criteria'] = $search_criteria;

	$view_data['flight_booking'] = $data['flight_booking'];
	
	$bank_fee = $CI->config->item('bank_fee');
	
	$view_data['bank_fee'] = $bank_fee;
	
	$view_data['hold_status'] = check_pre_hold_flight($data['flight_booking'], $search_criteria);
	
	$data['flight_booking_payment'] = load_view('flights/flight_payment/flight_booking_payment', $view_data, $is_mobile);

	return $data;
}

/**
 * Load Flight Review Booking
 * @author HuuTD
 * @since 18.06.2015
 * 
 */

function load_flight_review_booking($data, $is_mobile, $search_criteria){

	if ($is_mobile) return $data;
	
	$view_data['search_criteria'] = $search_criteria;
	
	$view_data['flight_booking'] = $data['flight_booking'];
	
	$data['flight_review_booking'] = load_view('flights/flight_payment/flight_review_booking', $view_data, $is_mobile);

	return $data;
}


function load_flight_term_conditioins($data, $is_mobile, $search_criteria){

	if ($is_mobile) return $data;
	
	$CI =& get_instance();
	
	$CI->load->language('about');

	$view_data['is_flight_booking_page'] = 1;

	$view_data['general_policy'] = load_view('about/policy_view', $data, $is_mobile);

	$data['flight_term_conditions'] = load_view('flights/flight_booking/flight_term_conditions', $view_data, $is_mobile);

	return $data;
}
/**
 * Get Flight Booking Information
 * @param unknown $sid
 * @param unknown $vnisc_sid
 * @param unknown $search_criteria
 *
 */
function get_flight_booking($sid, $vnisc_sid, $search_criteria){
	
	$CI =& get_instance();
	
	$is_domistic = $search_criteria['is_domistic'];

	$flight_booking = array();

	// for domistic flight
	if($is_domistic){
		
		$flight_departure_str = $CI->input->post('flight_departure');
		$flight_return_str = $CI->input->post('flight_return');


		// if access from the link, get from cookie
		if(empty($flight_departure_str)){
			
			$flight_booking = get_flight_session_data($sid, FLIGHT_BOOKING_INFO);
			
		}else{
			
			$flight_booking['flight_departure'] = get_flight_for_booking($vnisc_sid, $flight_departure_str, $search_criteria, FLIGHT_TYPE_DEPART);
				
			$flight_booking['flight_return'] = get_flight_for_booking($vnisc_sid, $flight_return_str, $search_criteria, FLIGHT_TYPE_RETURN);
				
			$flight_booking['nr_adults'] = $search_criteria['ADT'];
				
			$flight_booking['nr_children'] = $search_criteria['CHD'];

			$flight_booking['nr_infants'] = $search_criteria['INF'];
				
			$flight_booking['time_check_flight'] = microtime(true);
			
		}

	} else {
		// for international flights
		$flight_id = $CI->input->post('flight_inter_id');

		// if access from the link, get from the session
		if(empty($flight_id)){

			$flight_booking = get_flight_session_data($sid, FLIGHT_BOOKING_INFO);
		
		} else {

			// get flight-data saved in the session on the Search Step
			$flight_data = get_flight_session_data($sid, FLIGHT_SEARCH_DATA);

			$selected_flight = '';

			if($flight_data != ''){

				foreach ($flight_data as $flight){

					if($flight['Seg'] == $flight_id){

						$selected_flight = $flight;

						break;
					}

				}

			}

			if($selected_flight != ''){
				// store the selected flight in the FLIGHT BOOKING INFO
				$selected_flight['depart_routes'] = get_inter_flight_routes($selected_flight['RouteInfo'], FLIGHT_TYPE_DEPART);
				
				$selected_flight['return_routes'] = get_inter_flight_routes($selected_flight['RouteInfo'], FLIGHT_TYPE_RETURN);

				$flight_booking['selected_flight'] = $selected_flight;


				$flight_booking['nr_adults'] = $search_criteria['ADT'];

				$flight_booking['nr_children'] = $search_criteria['CHD'];

				$flight_booking['nr_infants'] = $search_criteria['INF'];

				$flight_booking['time_check_flight'] = microtime(true);


			} else {

				log_message('error', '[ERROR]get_flight_booking(): Fail to get Selected Flight in the Session');
			}

		}

	}
	
	if(!empty($flight_booking)){
		
		$action = $CI->input->post('action');

		if($action == ACTION_NEXT || $action == 'change-passenger'){
			$flight_booking = get_passenger_details($flight_booking);
			//print_r('get data user payment'); exit();
		}

		if($action == ACTION_NEXT || $action == 'change-baggage'){
			//print_r('get data user payment'); exit();
			$baggage_fees = get_baggage_fees($flight_booking, $search_criteria);
				
			$flight_booking['baggage_fees'] = $baggage_fees;
				
		}

		$flight_booking = get_flight_booking_price($flight_booking, $search_criteria);

	}
	//print_r($flight_booking); exit();

	return $flight_booking;
}

function get_baggage_fees($flight_booking, $search_criteria){

	$CI = & get_instance();
	
	if(!$search_criteria['is_domistic']) return array(); // no baggage fee for internaltional flights

	$baggage_fees['depart'] = array();
	$baggage_fees['return'] = array();

	$total_kg = 0;
	$total_fee_vnd = 0;
	$total_fee_usd = 0;

	$baggage_fees_cnf = $CI->config->item('baggage_fees');
	$nr_passengers = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];

	// get baggage fee for depart
	$flight_departure = $flight_booking['flight_departure'];
	$fees = $baggage_fees_cnf[$flight_departure['airline']];
	if(is_array($fees['send'])){
		for ($i=1; $i<= $nr_passengers; $i++){
			$kg = $CI->input->post('baggage_depart_'.$i);

			if($kg != ''){
				$bg_item = array('kg'=>$kg, 'money_vnd'=>$fees['send'][$kg]['vnd'], 'money_usd'=>$fees['send'][$kg]['usd']);
				
				$baggage_fees['depart'][$i] = $bg_item;

				$total_kg += $kg;
				$total_fee_vnd += $fees['send'][$kg]['vnd'];
				$total_fee_usd += $fees['send'][$kg]['usd'];
			}
		}
	}

	// get baggage fee for return

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY && !empty($flight_booking['flight_return'])){

		$flight_return = $flight_booking['flight_return'];
		$fees = $baggage_fees_cnf[$flight_return['airline']];
		if(is_array($fees['send'])){
			for ($i=1; $i<= $nr_passengers; $i++){
				$kg = $CI->input->post('baggage_return_'.$i);

				if($kg != ''){
					$bg_item = array('kg'=>$kg, 'money_vnd'=>$fees['send'][$kg]['vnd'], 'money_usd'=>$fees['send'][$kg]['usd']);
					$baggage_fees['return'][$i] = $bg_item;

					$total_kg += $kg;
					$total_fee_vnd += $fees['send'][$kg]['vnd'];
					$total_fee_usd += $fees['send'][$kg]['usd'];
				}
			}
		}

	}

	$baggage_fees['total_kg'] = $total_kg;
	$baggage_fees['total_fee_vnd'] = $total_fee_vnd;
	$baggage_fees['total_fee_usd'] = $total_fee_usd;


	return $baggage_fees;
}

/**
 * Get flight Booking Price
 * @param unknown $flight_booking
 * @param unknown $search_criteria
 * @return boolean
 */
function get_flight_booking_price($flight_booking, $search_criteria){

	$is_unavailable = false;

	$is_domistic = $search_criteria['is_domistic'];

	if($is_domistic){

		$prices['adult_fare_total'] = 0;

		$prices['children_fare_total'] = 0;

		$prices['infant_fare_total'] = 0;

		$prices['total_tax'] = 0;

		$prices['total_price'] = 0;

		$prices['baggage_fee'] = 0;

		$prices['bank_fee'] = 0;

		$prices['total_payment'] = 0;


		$flight_departure = $flight_booking['flight_departure'];

		$flight_return = $flight_booking['flight_return'];

		if(!empty($flight_departure) && !empty($flight_departure['detail'])){
				
			$detail = $flight_departure['detail']['prices'];
				
			$prices['adult_fare_total'] = !empty($detail['adult_fare_total'])? $detail['adult_fare_total'] : 0;
				
			$prices['children_fare_total'] = !empty($detail['children_fare_total'])? $detail['children_fare_total'] : 0;
				
			$prices['infant_fare_total'] = !empty($detail['infant_fare_total'])? $detail['infant_fare_total'] : 0;
				
			$prices['total_tax'] = $detail['total_tax'];
				
			$prices['total_price'] = $detail['total_price'];
				
			if($detail['total_price'] == 0){

				$is_unavailable = true;

			}
				
		}

		if(!empty($flight_return) && !empty($flight_return['detail'])){
				
			$detail = $flight_return['detail']['prices'];
				
			$prices['adult_fare_total'] += !empty($detail['adult_fare_total'])? $detail['adult_fare_total'] : 0;
				
			$prices['children_fare_total'] += !empty($detail['children_fare_total'])? $detail['children_fare_total'] : 0;
				
			$prices['infant_fare_total'] += !empty($detail['infant_fare_total'])? $detail['infant_fare_total'] : 0;
				
			$prices['total_tax'] += $detail['total_tax'];
				
			$prices['total_price'] += $detail['total_price'];
				
			if($detail['total_price'] == 0){

				$is_unavailable = true;

			}
				
		}


		$baggage_fees = isset($flight_booking['baggage_fees'])?$flight_booking['baggage_fees']:array();
		$total_baggage_fee = isset($baggage_fees['total_fee_usd'])?$baggage_fees['total_fee_usd']:0;

		$prices['baggage_fee'] = $total_baggage_fee;

		/*
		 *
		 * Not applied bank fee for Vietnameses customers
		 *
		 $bank_fee = $this->config->item('bank_fee');
		 	
		 $prices['bank_fee'] = round(($prices['total_price'] + $total_baggage_fee) * $bank_fee/100,2);
		 */

		$prices['total_payment'] = $prices['total_price'] + $total_baggage_fee;

	} else {

		$selected_flight = $flight_booking['selected_flight'];

		$prices = get_flight_prices_inter($selected_flight, $search_criteria);
	}

	$flight_booking['prices'] = $prices;

	$flight_booking['is_unavailable'] = $is_unavailable;

	return $flight_booking;
}

function get_passenger_details($flight_booking){
	
	$CI =& get_instance();

	$nr_adults = $flight_booking['nr_adults'];

	$nr_children = $flight_booking['nr_children'];
		
	$nr_infants = $flight_booking['nr_infants'];

	
	$adults = array();

	$children = array();

	$infants = array();

	for ($i = 1; $i <= $nr_adults; $i++){

		$gender = $CI->input->post('adults_gender_'.$i);
		$first_name = $CI->input->post('adults_first_'.$i);
		$last_name = $CI->input->post('adults_last_'.$i);

		$adult['gender'] = $gender;
		$adult['full_name'] = $first_name .' '. $last_name;
		$adult['first_name'] = $first_name;
		$adult['middle_name'] = '';
		$adult['last_name'] = $last_name;
			
		// for international flight: adult birthday, nationality, passport & passport expired date
		$day = $CI->input->post('adult_day_'.$i);
		$month = $CI->input->post('adult_month_'.$i);
		$year = $CI->input->post('adult_year_'.$i);
		if(!empty($day) && !empty($month) && !empty($year)){
			$adult['birth_day'] = date(ARTICLES_DATE_FORMAT, mktime(0,0,0,$month,$day,$year));
		}
			
		$adult['nationality'] = $CI->input->post('country_orgin_adt_'.$i);
			
		// passport
		$adult['passport'] = $CI->input->post('passport_adt_'.$i);
			
		// passport expired date
		$day = $CI->input->post('passportexp_adt_day_'.$i);
		$month = $CI->input->post('passportexp_adt_month_'.$i);
		$year = $CI->input->post('passportexp_adt_year_'.$i);
		if(!empty($day) && !empty($month) && !empty($year)){
			$adult['passportexp'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$month,$day,$year));
		}

		$adults[] = $adult;
	}

	for ($i = 1; $i <= $nr_children; $i++){

		$gender = $CI->input->post('children_gender_'.$i);
		$first_name = $CI->input->post('children_first_'.$i);
		$last_name = $CI->input->post('children_last_'.$i);

		$day = $CI->input->post('children_day_'.$i);

		$month = $CI->input->post('children_month_'.$i);

		$year = $CI->input->post('children_year_'.$i);


		$child['gender'] = $gender;
		$child['full_name'] = $first_name .' '. $last_name;
		//$first_last = seperate_first_last_from_full_name($full_name);
			
		$child['first_name'] = $first_name;
		$child['middle_name'] = '';
		$child['last_name'] = $last_name;

		$child['birth_day'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$month,$day,$year));
			
		// for international flight: children nationality, passport & passport expired date
		$child['nationality'] = $CI->input->post('country_orgin_chd_'.$i);

		// passport
		$child['passport'] = $CI->input->post('passport_chd_'.$i);

		// passport expired date
		$day = $CI->input->post('passportexp_chd_day_'.$i);
		$month = $CI->input->post('passportexp_chd_month_'.$i);
		$year = $CI->input->post('passportexp_chd_year_'.$i);
		if(!empty($day) && !empty($month) && !empty($year)){
			$child['passportexp'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$month,$day,$year));
		}

		$children[] = $child;

	}

	for ($i = 1; $i <= $nr_infants; $i++){

		$gender = $CI->input->post('infants_gender_'.$i);
		$first_name = $CI->input->post('infants_first_'.$i);
		$last_name = $CI->input->post('infants_last_'.$i);
			
		$day = $CI->input->post('infants_day_'.$i);

		$month = $CI->input->post('infants_month_'.$i);

		$year = $CI->input->post('infants_year_'.$i);

		$infant['gender'] = $gender;
		$infant['full_name'] = $first_name .' '. $last_name;
		$infant['first_name'] = $first_name;
		$infant['middle_name'] = '';
		$infant['last_name'] = $last_name;

		$infant['birth_day'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$month,$day,$year));
			
		// for international flight: infant nationality, passport & passport expired date
		$infant['nationality'] = $CI->input->post('country_orgin_inf_'.$i);
			
		// passport
		$infant['passport'] = $CI->input->post('passport_inf_'.$i);
			
		// passport expired date
		$day = $CI->input->post('passportexp_inf_day_'.$i);
		$month = $CI->input->post('passportexp_inf_month_'.$i);
		$year = $CI->input->post('passportexp_inf_year_'.$i);
		if(!empty($day) && !empty($month) && !empty($year)){
			$infant['passportexp'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$month,$day,$year));
		}

		$infants[] = $infant;
	}


	$flight_booking['adults'] = $adults;

	$flight_booking['children'] = $children;

	$flight_booking['infants'] = $infants;

	return $flight_booking;
}

function save_flight_booking(){
	
	$CI =& get_instance();
	
	$CI->load->model('Tour_Model');
	
	$CI->load->helper('payment');
	
	$CI->load->model('CustomerModel');
	
	/**
	 *
	 * SET RESERVATION INFO FROM FLIGHT BOOKING
	 *
	 */
	// get $sid from the link
	$sid = $CI->input->get('sid');
	$data['sid'] = $sid;
	// get search-criteria in the session
	$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
	//$data['search_criteria'] = $search_criteria;
	// get vnisc-id from the session
	$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);
	
	// check if fail to get data from the session
	if($search_criteria == '' || $vnisc_sid == ''){
	
		log_message('error', '[ERROR]flight_detail(): Fail to get Search Criteria or VNISC-ID from the Session');
	
		redirect(get_page_url(VN_FLIGHT_PAGE));exit();
	}
	
	// get the flight-booking of the flight
	$flight_booking = get_flight_booking($sid, $vnisc_sid, $search_criteria);
	 
	if(empty($flight_booking) || empty($search_criteria)){
	
		_clear_flight_session_data($sid);
	
		redirect(get_page_url(VN_FLIGHT_PAGE));exit();
	
		exit();
	}
	
	$reservation_infos = get_reservations_from_flight_booking($flight_booking, $search_criteria);

	$customer = get_contact_post_data();
	
	$special_request = $customer['special_request'];
	
	$customer_id = $CI->Tour_Model->create_or_update_customer($customer);
	
	$customer_booking_id = $CI->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request);

	if($customer_booking_id !== FALSE){

		$hold_status = check_pre_hold_flight($flight_booking, $search_criteria);
		
		// create invoice
		$invoice_id = $CI->CustomerModel->create_invoice($customer_id, $customer_booking_id, FLIGHT);
		
		if ($invoice_id === FALSE){ // false to create invoice
			
			log_message('error', '[INFO]Flight->_book(): FAIL to create Invoice. Go Thank_you Page');
			
			// clear visa session
			_clear_flight_session_data($sid);

			// show thank you page as normal submit
			redirect(get_page_url(THANK_YOU_PAGE));
			exit();

		} else {

			// get invoice detail and call payment module
			$invoice = $CI->CustomerModel->get_invoice_4_payment($invoice_id);

			$customer['special_request'] = $special_request;

			//echo "<pre>";
			//print_r($flight_booking); exit();
			//echo "</pre>";
			$submit_status_nr = submit_flight_booking_to_vnisc($sid, $flight_booking, $search_criteria, $customer, $customer_booking_id);
		
			if($submit_status_nr == 1){ // OK to submit data to VNISC
				
				// send email to customer
				_send_mail($search_criteria, $flight_booking, $customer, $special_request, $invoice['invoice_reference'], $customer_booking_id, $hold_status['is_allow_hold']);

				// clear visa session
				_clear_flight_session_data($sid);

				// allow book & payment online
				if($hold_status['is_allow_hold']){

					log_message('error', '[INFO]Flight->_book(): Submit Booking Data to VNISC Sucessfully & Go to Onepay');

					redirect(get_page_url(VN_FLIGHT_PAGE));
					// call payment module with the invoice input
					//$pay_url = get_payment_url($invoice);

					//redirect($pay_url);

					exit();

				} else {

					log_message('error', '[INFO]Flight->_book(): Submit Booking Data to VNISC Sucessfully - But time too close departure - Do not allow online payment - Go to Confirm Page');
					
					redirect(get_page_url(THANK_YOU_PAGE));

					exit();

				}


			} else{ // FAIL to submit
				
				log_message('error', '[ERROR]Flight->_book(): FAIL to Submit Booking Data to VNISC, Show Message to Customer');
					
				return  $submit_status_nr;
					
			}

		}

	}
}

function _send_mail($search_criteria, $flight_booking, $customer, $payment_info, $code_discount_info, $customer_booking_id, $invoce_ref=''){

	$CI =& get_instance();

	$data['flight_booking'] = $flight_booking;

	$data['search_criteria'] = $search_criteria;

	$data['valid_airline_codes'] = $CI->config->item('valid_airline_codes');
	
	$countries = $CI->config->item('passenger_nationalities');
	
	$customer['country_name'] = $countries[$customer['country']][0];

	$config_title = $CI->config->item('title');
	$customer['title_text'] = $config_title[$customer['title']];

	$data['customer'] = $customer;

	$data['payment_info'] = $payment_info;

	$data['code_discount_info'] = $code_discount_info;

	$data['customer_booking_id'] = $customer_booking_id;

	$data['invoice_ref'] = $invoce_ref;
	
	$data['bank_transfer'] = $CI->config->item('bank_transfer');

	$data['hold_status'] = check_pre_hold_flight($flight_booking, $search_criteria);

	$short_flight_desc = get_flight_short_desc($search_criteria);

	$content = $CI->load->view('flights/common/flight_booking_mail', $data, TRUE);

	//echo $content;exit();

	$CI->load->library('email');

	$config = array();
	/*
		$config['protocol']='smtp';
		$config['smtp_host']='74.220.207.140';
		$config['smtp_port']='25';
		$config['smtp_timeout']='30';
		$config['smtp_user']='booking@bestprice.vn';
		$config['smtp_pass']='Bpt052010';
	*/


	$config['protocol'] = 'mail';
	$config['charset']='utf-8';
	$config['newline']="\r\n";
	$config['mailtype'] = 'html';

	// send to Best Price Booking Email
	$CI->email->initialize($config);

	$CI->email->from($customer['email'], $customer['full_name']);

	$CI->email->to('bestpricebooking@gmail.com');

	$subject = lang('flight_email_reply').': ' . $short_flight_desc . ' - '. $customer['full_name'];
	$CI->email->subject($subject);

	$CI->email->message($content);

	if (!$CI->email->send()){
		log_message('error', '[ERROR]flight_boooking: Can not send email to bestpricevn@gmail.com');
	}


	$t1 = microtime(true);

	$config = array();
	/*
		$config['protocol']='smtp';
		$config['smtp_host']='74.220.207.140';
		$config['smtp_port']='25';
		$config['smtp_timeout']='30';
		$config['smtp_user']='booking@bestprice.vn';
		$config['smtp_pass']='Bpt052010';
	*/

	$config['protocol']='smtp';
	$config['smtp_host']='ssl://smtp.googlemail.com';
	$config['smtp_port']='465';
	$config['smtp_timeout']='30';

	$config['smtp_user']='bestpricebooking@gmail.com';
	$config['smtp_pass']='Bpt20112008';


	/*
		$config['smtp_user']='booking@bestprice.vn';
		$config['smtp_pass']='Bpt052010';
		*/

	//$config['protocol'] = 'mail';
	$config['charset']='utf-8';
	$config['newline']="\r\n";
	$config['mailtype'] = 'html';

	// send to customer
	$CI->email->initialize($config);

	$CI->email->from('booking@bestprice.vn', BRANCH_NAME);

	$CI->email->reply_to('booking@bestprice.vn');

	$CI->email->to($customer['email']);

	$subject = lang('flight_email_reply').': ' . $short_flight_desc . ' - '. BRANCH_NAME;
	$CI->email->subject($subject);

	$CI->email->message($content);

	if (!$CI->email->send()){
		log_message('error', '[ERROR]flight_boooking: Can not send email to '.$customer['email']);
	}

	$t2 = microtime(true);

	//echo 'Connect SMTP email time = '.($t2 - $t1);exit();

	log_message('error', '[INFO]Connect SMTP email time = '.($t2 - $t1));

	return true;
}

function _validateBooking()
{
	$CI =& get_instance();
	_setValidationRules();
	return $CI->form_validation->run();
}

function _clear_flight_session_data(){

	$CI =& get_instance();
	
	$CI->session->unset_userdata(FLIGHT_SEARCH_CRITERIA);

	$CI->session->unset_userdata(FLIGHT_BOOKING_INFO);

}

function _setValidationRules()
{
	$CI =& get_instance();
	$CI->load->library('form_validation');
	$booking_rules = $CI->config->item('booking_rules');
	$CI->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
	$CI->form_validation->set_rules($booking_rules);
}
?>