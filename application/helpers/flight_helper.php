<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_current_flight_search_url($search_criteria){

	$url = get_page_url(FLIGHT_SEARCH_PAGE);
	
	$params['Type'] = $search_criteria['Type'];
	$params['From'] = $search_criteria['From'];
	$params['To'] = $search_criteria['To'];
	$params['Depart'] = $search_criteria['Depart'];
	$params['Return'] = $search_criteria['Return'];
	$params['ADT'] = $search_criteria['ADT'];
	$params['CHD'] = $search_criteria['CHD'];
	$params['INF'] = $search_criteria['INF'];

	$url .= '?'.http_build_query($params);
	return $url;

}


function format_bpv_date($str, $format = DB_DATE_FORMAT, $is_show_week_day = false){

	$CI =& get_instance();

	$str = str_replace('/', '-', $str);

	$wd = date('w', strtotime($str));

	$str = date($format, strtotime($str));

	if($is_show_week_day){

		$week_days = $CI->config->item('week_days');

		$wd = $week_days[$wd];

		$str = lang($wd).', '.$str;

	}

	return $str;
}

function format_bpv_date1($value){
	return $value;
	
}

function get_flight_search_exception($search_criteria, $log_enable = true){
	
	$CI =& get_instance();
	
	$exception = array();
	
	if($search_criteria['ADT'] + $search_criteria['CHD'] > FLIGHT_PASSENGER_LIMIT){
		
		if($log_enable) log_message('error', '[EXCEPTION]search(): passenger limited (adt + chd > 9), adt = '.$search_criteria['ADT'].', chd = '.$search_criteria['CHD']);

		$exception['code'] = 1;
		
		$exception['exception'] = 'Over-9-Passengers';
		
		return $exception; // over limited passenger

	}
	
	if($search_criteria['INF'] > $search_criteria['ADT']){

		if($log_enable) log_message('error', '[EXCEPTION]search(): infants limited (inf > adt) , inf = '.$search_criteria['INF'].', adt = '.$search_criteria['ADT']);
		
		$exception['code'] = 2;
		
		$exception['exception'] = 'Too Much Infants';
		
		return $exception; // too much infants

	}

	/* 
	if(!$search_criteria['is_domistic']){
	log_message('error', '[EXCEPTION]search(): Search International Flights with Search Data = '.get_flight_exception_short_req($search_criteria));

	return 3; // international flights
	}*/
	
	$has_flight_route = $CI->Flight_Model->has_flight_route($search_criteria['From_Code'], $search_criteria['To_Code']);

	if($search_criteria['is_domistic'] && !$has_flight_route){
			
		log_message('error', '[EXCEPTION]search(): No Flight Route , From = '.$search_criteria['From'].', To = '.$search_criteria['To']);
		
		$exception['code'] = 4;
		
		$exception['exception'] = 'No Flight Route';

		return $exception; // no flight route
	}


	$today = date(DB_DATE_FORMAT);
	$depart = format_bpv_date($search_criteria['Depart']);

	if($depart < $today){
			
		log_message('error', '[EXCEPTION]search(): Invalid Search Date: Departure Date < Today, Departure = '.format_bpv_date($search_criteria['Depart'], DATE_FORMAT));
		
		$exception['code'] = 5;
		
		$exception['exception'] = 'Departure In The Past';

		
		return $exception; // departure in the past
			
	}

	if(!empty($search_criteria['Return']) && $search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){

		$return = format_bpv_date($search_criteria['Return']);
			
		if($return < $depart){

			$message = '[EXCEPTION]search(): Invalid Search Date: Return Date < Depart Date, Departure = '.format_bpv_date($search_criteria['Depart'], DATE_FORMAT).
			'; Return = '.format_bpv_date($search_criteria['Return'], DATE_FORMAT);

			log_message('error', '[EXCEPTION]search(): Invalid Search Date: Return Date < Depart Date, Departure = '.format_bpv_date($search_criteria['Depart'], DATE_FORMAT));

			$exception['code'] = 6;
		
			$exception['exception'] = 'Departure In The Past';
		
			return $exception; // departure in the past

		}
			
	}
	
	return $exception;
}

function load_flight_destination_links($data, $is_mobile){
	
	//if ($is_mobile) return $data;

	$CI =& get_instance();

	$data['flight_destinations'] = $CI->Flight_Model->get_all_flight_destinations();

	$data['flight_destination_links'] = load_view('flights/flight_destination/flight_destination_links', $data, $is_mobile);

	return $data;
}



function _get_des_code($str_des){
	$str_des = explode('(', $str_des);

	if(count($str_des) > 1){
		$str_des = $str_des[1];

		$str_des = explode(')', $str_des);

		if(count($str_des) > 0){
			return trim($str_des[0]);
		}

	}

	return '';
}

function set_default_flight_search_criteria(){

	$search_criteria = array();
	
	$search_criteria['From'] = '';
	
	$search_criteria['To'] = '';
	
	$search_criteria['ADT'] = 2; // default 1 coupble
	
	$search_criteria['CHD'] = 0;
	
	$search_criteria['INF'] = 0;
	
	$search_criteria['Type'] = 'roundway'; // default roudtrip
	
	$today = date('d-m-Y');
	
	$tommorow = date('d-m-Y', strtotime($today . " +1 day"));
	
	$after_tommorow = date('d-m-Y', strtotime($today . " +2 day"));

	$search_criteria['Depart'] = $tommorow;
	
	$search_criteria['Return'] = $after_tommorow;
	
	$search_criteria['Airline'] = '';
	
	return $search_criteria;
}


// make the hash for VNISC accoun
function booking_make_hash($AgentCode, $From, $To, $DayDepart, $MonthDepart, $YearDepart, $DayReturn, $MonthReturn, $YearReturn, $Type, $ADT, $CHD, $SecurityCode)
{
	return strtoupper(md5($AgentCode . $From . $To . $DayDepart . $MonthDepart . $YearDepart . $DayReturn . $MonthReturn . $YearReturn . $Type . $ADT . $CHD . $SecurityCode));
}

// make the flight params to call VNISC link

function get_flight_url($search_criteria){

	$url = '';

	$CI =& get_instance();

	$flight_vnisc_iframe_url = $CI->config->item('flight_vnisc_iframe_url');


	$From = $search_criteria['From_Code'];

	$To = $search_criteria['To_Code'];

	$depart = format_bpv_date($search_criteria['Depart']);

	$DayDepart = date('d', strtotime($depart));

	$MonthDepart = date('m', strtotime($depart));

	$YearDepart = date('Y', strtotime($depart));


	$ADT = $search_criteria['ADT'];

	$CHD = $search_criteria['CHD'];

	$INF = $search_criteria['INF'];

	$Type = $search_criteria['Type'];


	$url = $flight_vnisc_iframe_url.'?';

	$url .= "From=".$From;

	$url .= "&To=".$To;

	$url .= "&DayDepart=".$DayDepart;

	$url .= "&MonthDepart=".$MonthDepart;

	$url .= "&YearDepart=".$YearDepart;

	if($Type == FLIGHT_TYPE_ROUNDWAY){

		$return = format_bpv_date($search_criteria['Return']);

		$DayReturn = date('d', strtotime($return));

		$MonthReturn = date('m', strtotime($return));

		$YearReturn = date('Y', strtotime($return));

		$url .= "&DayReturn=".$DayReturn;

		$url .= "&MonthReturn=".$MonthReturn;

		$url .= "&YearReturn=".$YearReturn;

	} else {
		//date_default_timezone_set("Asia/Saigon");
		// current date
		$DayReturn = date('d');

		$MonthReturn = date('m');

		$YearReturn = date('Y');
	}

	$url .= "&ADT=".$ADT;

	$url .= "&CHD=".$CHD;

	$url .= "&INF=".$INF;


	$url .= "&Type=".$Type;

	$url .= "&Lang=".FLIGHT_LANG;

	$url .= "&Agent=".FLIGHT_AGENT_CODE;

	$url .= "&vHash=".FLIGHT_V_HASH;

	$hash = booking_make_hash(FLIGHT_AGENT_CODE, $From, $To, $DayDepart, $MonthDepart, $YearDepart, $DayReturn, $MonthReturn, $YearReturn, $Type, $ADT, $CHD, FLIGHT_SECURITY_CODE);

	$url .= "&Hash=".$hash;


	return $url;
}

function get_flight_vnisc_sid($flight_url){

	if(empty($flight_url)) return '';

	$vnisc_sid = '';

	$CI =& get_instance();

	$curl_options = $CI->config->item('sid_curl_options');

	// 1. initialize
	$ch = curl_init($flight_url);

	// 2. set the options
	curl_setopt_array($ch, $curl_options);

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);

	$info = curl_getinfo($ch);

	// 4. free up the curl handle

	if($output !== FALSE){
		 
		$url = $info['url'];
		 
		$temp_array = explode("sid=", $url);
		 
		if(count($temp_array) > 1){

			$vnisc_sid = $temp_array[1];

		}
		 
	} else {
		 
		$curl_erro_nr = curl_errno($ch);
		 
		$error_message = 'get_flight_vnisc_sid - cURL Error: --> '.curl_error($ch).'; Error Number = '. $curl_erro_nr.'; Submit URL = '. $flight_url;

		log_message('error', $error_message);

		send_email_flight_error_notify($error_message, 3);
	}

	curl_close($ch);

	if(isset($curl_erro_nr) && $curl_erro_nr == 52){
		 
		return get_flight_vnisc_sid($flight_url);
		 
	}

	return $vnisc_sid;
}


function get_flight_data($flight_data_url, $flight_type){

	if(empty($flight_data_url)) return '';

	$CI =& get_instance();

	$curl_options = $CI->config->item('flight_data_curl_options');

	//$curl_options[CURLOPT_POSTFIELDS] = "type=".$flight_type;

	// 1. initialize
	$ch = curl_init($flight_data_url);

	// 2. set the options
	curl_setopt_array($ch, $curl_options);

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);

	if($output === FALSE){
		 
		$curl_erro_nr = curl_errno($ch);
		 
		$error_message = '[ERROR]get_flight_data - cURL Error: --> '.curl_error($ch).'; Error Number = '.$curl_erro_nr.'; Submit URL = '. $flight_data_url;

		log_message('error', $error_message);
		 
		send_email_flight_error_notify($error_message, 3);

	}

	// 4. free up the curl handle
	curl_close($ch);

	if(isset($curl_erro_nr) && $curl_erro_nr == 52){
		 
		return get_flight_data($flight_data_url, $flight_type);
		 
	}

	if($output !== FALSE){
		 
		return $output;
		 
	} else {
		 
		return FLIGHT_CURL_ERROR;
	}

	return '';
}

function get_flight_detail($flight_detail_url){
	
	if(empty($flight_detail_url)) return '';

	$CI =& get_instance();

	$curl_options = $CI->config->item('flight_data_curl_options');
	
	$curl_options[CURLOPT_POST] = false;

	$curl_options[CURLOPT_POSTFIELDS] = "";

	// 1. initialize
	$ch = curl_init($flight_detail_url);

	// 2. set the options
	$ddd = curl_setopt_array($ch, $curl_options);
	
	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);
	
	if($output === FALSE){

		$curl_erro_nr = curl_errno($ch);
		 
		$error_message = '[ERROR]get_flight_detail - cURL Error: --> '.curl_error($ch).'; Error Number = '.$curl_erro_nr.'; Submit URL = '. $flight_detail_url;
		 
		log_message('error', $error_message);
		 
		send_email_flight_error_notify($error_message, 3);

	}


	// 4. free up the curl handle
	curl_close($ch);

	if(isset($curl_erro_nr) && $curl_erro_nr == 52){
		 
		return get_flight_detail($flight_detail_url);
		
	}


	if($output !== FALSE){
		 
		return $output;
		 
	} else {
		 
	}

	return '';
}

function get_departure_time_index($flight){
	$index = 0;

	$time_from = $flight['TimeFrom'];

	if($time_from >= '0500' && $time_from <= '1159'){
		$index = 1;
	}elseif($time_from >= '1200' && $time_from <= '1759'){
		$index = 2;
	}elseif($time_from >= '1800' && $time_from <= '2359'){
		$index = 3;
	}elseif($time_from >= '0000' && $time_from <='0459'){
		$index = 4;
	}
	return $index;
}

function format_flight_time($time_from){

	$t1 = substr($time_from, 0, 2);

	$t2 = substr($time_from, 2, 4);

	return ($t1 . ':'.$t2);
}

function get_flight_detail_info($html, $is_domistic = true, $stop = 0, $search_criteria){
	
	$routes = array();
	
	$CI =& get_instance();

	$CI->load->library('simple_html_dom');

	$html = str_get_html($html);
	
	$lines = $html->find('div.line');
	
	$number_of_route = get_route_number($stop);
	
	for($i = 0; $i < $number_of_route; $i++){

		if(isset($lines[$i])){

			$route = get_flight_route($lines[$i], $search_criteria['From_Code'], $search_criteria['To_Code']);
			
			if(!empty($route)){
					
				$routes[] = $route;
					
			}

		}
			
	}

	$flight_detail['routes'] = $routes;
	
	/**
	 * 26.05.2014: check the flight urgent or not
	 *
	 */
	$is_urgent_flight = false;
	if(count($routes) > 0){
		$route_1 = $routes[0];
		$from = $route_1['from'];

		$airline = $route_1['airline'];
		$airline = explode("-", $airline);
		$airline = $airline[0];

		$is_urgent_flight = is_too_close_departure($airline, format_bpv_date($from['date']), $from['time']);
	}


	$flight_detail['prices'] = get_flight_prices($lines, $number_of_route, $is_domistic, $search_criteria['ADT'], $search_criteria['CHD'], $search_criteria['INF'], $is_urgent_flight);

	$flight_detail['seat_unavailable_txt'] = get_seat_text_unavailable($search_criteria['ADT'], $search_criteria['CHD'], $search_criteria['INF']);

	$flight_detail['fare_rules'] = get_fare_rules($lines, $number_of_route);

	return $flight_detail;
}

function get_route_number($stop = 0){

	return $stop + 1;
}

function get_flight_route($html, $from, $to){
	$route = array();

	$lefts = $html->find('div.left');

	if(count($lefts) > 0){

		$from_str = $lefts[0]->plaintext;
		
		$route['from'] = get_route_detail_from_str($from_str, $from);
		
	}

	if(count($lefts) > 1){

		$to_str = $lefts[1]->plaintext;

		$route['to'] = get_route_detail_from_str($to_str, $to);
	}

	if(isset($route['from']) && isset($route['to'])){

		$right = $html->find('div.right',0);

		if(!empty($right)){
			$airline = $right->find('b',0);
			if(!empty($airline)){
				$route['airline'] = $airline->plaintext;
			}
		}

	}

	//echo 'From = '.$from . ' To = '.$to;

	return $route;
}

function get_route_detail_from_str($route_str, $city_code){
	
	$route_detail = array();
	
	if (!empty($route_str)){

		$route_detail['city_code'] = $city_code;
		
		$city_code = " (".$city_code.")";

		$str_arr = explode(lang('airport').':', $route_str);
		
		if(count($str_arr) > 1){
				
			$str_date_time_airport = trim($str_arr[2]);
				
			$str_location = trim($str_arr[0]);
			
			$arr_date_time_airport = explode(" ", $str_date_time_airport);
			
			
			if(count($arr_date_time_airport) > 0){
				$route_detail['time'] =  trim($arr_date_time_airport[count($arr_date_time_airport) - 1]).':'.$str_arr[3] ;
			}
			
			if(count($arr_date_time_airport) > 1){
				
				$str_date = trim($arr_date_time_airport[count($arr_date_time_airport) - 2]);

				$arr_date = explode("/", $str_date);
				
				if(count($arr_date) == 3){
					
					$route_detail['date'] = date(DATE_FORMAT_STANDARD, mktime(0,0,0,$arr_date[1], $arr_date[0], $arr_date[2]));
				}
				
			}
			
			if(count($arr_date_time_airport) > 2){

				$route_detail['airport'] = '';

				for($i = 0; $i < count($arr_date_time_airport) - 2; $i++){
					$route_detail['airport'] = $route_detail['airport'] . trim($arr_date_time_airport[$i]).' ';
				}

				$route_detail['airport'] = trim($route_detail['airport']);
			}
			
				
			$arr_city = explode(",", $str_arr[1]);
			
			if(count($arr_city) > 1){

				$route_detail['city'] = trim($arr_city[0]);

				$arr_country = explode(" ", $arr_city[1]);
				
				$route_detail['country'] = trim($arr_country[1]);
			}
			
		}

	}

	return $route_detail;
}

/**
 * get Flight Price of domistic flight
 * @param unknown $lines
 * @param unknown $number_of_route
 * @param unknown $is_domistic
 * @param unknown $adults
 * @param unknown $children
 * @param unknown $infants
 * @param string $is_urgent_flight
 * @return number
 */
function get_flight_prices($lines, $number_of_route, $is_domistic, $adults, $children, $infants, $is_urgent_flight = false){

	$prices['adults'] = $adults;

	$prices['children'] = $children;

	$prices['infants'] = $infants;

	$prices['is_domistic'] = $is_domistic;

	$prices['total_tax'] = 0;
		
	$prices['total_price'] = 0;

	$price_table = isset($lines[$number_of_route]) ? $lines[$number_of_route]->find('table',0) : array();

	if(!empty($price_table)){

		$arr_tr = $price_table->find('tr');

		if(count($arr_tr) > 1){
			$adult_tds = $arr_tr[1]->find('td');
				
			$str_adult_fare = $adult_tds[2]->plaintext;
				
			$str_adult_tax = $adult_tds[3]->plaintext;
				
			$str_adult_total = $adult_tds[4]->plaintext;
				
			$prices['adult_fare'] = convert_vnd_to_usd(get_price_from_text($str_adult_fare));
				
			$prices['adult_fare_total'] = $prices['adult_fare'] * $adults;

			if($is_domistic){
				$prices['adult_tax'] = convert_vnd_to_usd(get_price_from_text($str_adult_tax));
			} else {
				$prices['adult_tax'] = 0;
			}
				
			$prices['adult_total'] = get_price_from_text($str_adult_total);
				
			$prices['adult_fare_total'] = $prices['adult_fare'] * $adults;
				
			$prices['adult_total'] = $prices['adult_fare_total'] + $prices['adult_tax'] * $adults;
				
		}

		if($children > 0){
			if(count($arr_tr) > 2){
					
				$children_tds = $arr_tr[2]->find('td');

				$str_children_fare = $children_tds[2]->plaintext;

				$str_children_tax = $children_tds[3]->plaintext;

				$str_children_total = $children_tds[4]->plaintext;

				$prices['children_fare'] = convert_vnd_to_usd(get_price_from_text($str_children_fare));

				$prices['children_fare_total'] = $prices['children_fare'] * $children;
					
				if($is_domistic){
					$prices['children_tax'] = convert_vnd_to_usd(get_price_from_text($str_children_tax));
				} else {
					$prices['children_tax'] = 0;
				}
				
				$prices['children_total'] = get_price_from_text($str_children_total);

				$prices['children_fare_total'] = $prices['children_fare'] * $children;

				$prices['children_total'] = $prices['children_fare_total'] + $prices['children_tax'] * $children;
				
			}
				
		}

		if($infants > 0){

			if($children > 0 && count($arr_tr) > 3){
				$infant_tds = $arr_tr[3]->find('td');
			}
				
			if($children == 0 && count($arr_tr) > 2){
				$infant_tds = $arr_tr[2]->find('td');
			}
				
			if(isset($infant_tds)){
					
				$str_infant_fare = $infant_tds[2]->plaintext;

				$str_infant_tax = $infant_tds[3]->plaintext;

				$str_infant_total = $infant_tds[4]->plaintext;

				$prices['infant_fare'] = convert_vnd_to_usd(get_price_from_text($str_infant_fare));

				$prices['infant_fare_total'] = $prices['infant_fare'] * $infants;
					
				if($is_domistic){
					$prices['infant_tax'] = convert_vnd_to_usd(get_price_from_text($str_infant_tax));
				} else {
					$prices['infant_tax'] = 0;
				}

				$prices['infant_total'] = get_price_from_text($str_infant_total);

					
					
				$prices['infant_fare_total'] = $prices['infant_fare'] * $infants;

				$prices['infant_total'] = $prices['infant_fare_total'] + $prices['infant_tax'] * $infants;
					
			}
				
		}

		if($is_domistic){
				
			$total_tax = 0;
				
			if(!empty($prices['adult_tax'])) $total_tax = $total_tax + $prices['adult_tax'] * $prices['adults'];
				
			if(!empty($prices['children_tax'])) $total_tax = $total_tax + $prices['children_tax'] * $prices['children'];
				
			if(!empty($prices['infant_tax'])) $total_tax = $total_tax + $prices['infant_tax'] * $prices['infants'];

			$total_price = 0;
				
			if(!empty($prices['adult_total'])) $total_price = $total_price + $prices['adult_total'];
				
			if(!empty($prices['children_total'])) $total_price = $total_price + $prices['children_total'];
				
			if(!empty($prices['infant_total'])) $total_price = $total_price + $prices['infant_total'];
				
			$prices['total_tax'] = $total_tax;
				
			$prices['total_price'] = $total_price;
			
			//$prices['total_tax'] = convert_vnd_to_usd($prices['total_tax']);
			
			//$prices['total_price'] = convert_vnd_to_usd($prices['total_price']);
				
			// adding fee
			if($prices['total_price'] > 0){
				$prices['total_tax'] = add_ticket_fee($prices['total_tax'], ($adults + $children + $infants), $is_urgent_flight);
				//$prices['total_tax'] = convert_vnd_to_usd($prices['total_tax']);
				$prices['total_price'] = add_ticket_fee($prices['total_price'], ($adults + $children + $infants), $is_urgent_flight);
				//$prices['total_price'] = convert_vnd_to_usd($prices['total_price']);
			}
				
		} else{
			$total_tax = $lines[$number_of_route + 1]->plaintext;

			$total_tax = get_price_from_text($total_tax, 1);
				
			$prices['total_tax'] = convert_vnd_to_usd($total_tax);
				
				
			$total_price = $lines[$number_of_route + 2]->plaintext;
			$total_price = get_price_from_text($total_price, 1);
				
			$prices['total_price'] = convert_vnd_to_usd($total_price);
			
			//$prices['total_tax'] = convert_vnd_to_usd($prices['total_tax']);
				
			//$prices['total_price'] = convert_vnd_to_usd($prices['total_price']);

			// adding fee
			if($prices['total_price'] > 0){
				$prices['total_tax'] = add_ticket_fee($prices['total_tax'], ($adults + $children + $infants), $is_urgent_flight);

				$prices['total_price'] = add_ticket_fee($prices['total_price'], ($adults + $children + $infants), $is_urgent_flight);
			}
		}

	}

	return $prices;
}

/**
 * Get Price of International Flights
 * @param unknown $flight
 * @param unknown $search_criteria
 */
function get_flight_prices_inter($flight, $search_criteria){
//
	$is_urgent_flight = is_too_close_departure('', format_bpv_date($search_criteria['Depart']), $flight['TimeFrom'], false);

	$nr_ticket = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		$nr_ticket = $nr_ticket * 2;
	}

	$price_info = $flight['PriceInfo'][0];
	
	$price_info['ADT_Fare'] = convert_vnd_to_usd($price_info['ADT_Fare']);
	$prices['adult_fare'] = $price_info['ADT_Fare'];
	$prices['adult_fare_total'] = $price_info['ADT_Fare'] * $search_criteria['ADT'];
	
	$price_info['CHD_Fare'] = convert_vnd_to_usd($price_info['CHD_Fare']);
	$prices['children_fare'] = $price_info['CHD_Fare'];
	$prices['children_fare_total'] = $price_info['CHD_Fare'] * $search_criteria['CHD'];

	$price_info['INF_Fare'] = convert_vnd_to_usd($price_info['INF_Fare']);
	$prices['infant_fare'] = $price_info['INF_Fare'];
	$prices['infant_fare_total'] = $price_info['INF_Fare'] * $search_criteria['INF'];
	
	// total fare of the booking
	$total_fare = $prices['adult_fare_total'] + $prices['children_fare_total'] + $prices['infant_fare_total'];
	
	// total tax from the airline
	$tax_and_fee = convert_vnd_to_usd($price_info['Tax']);
	
	// add the ticket fee
	$tax_and_fee = add_ticket_fee($tax_and_fee, $nr_ticket, $is_urgent_flight, false);
	
	// calculate total discount
	$airlines = get_airline_codes_of_flight($flight['RouteInfo']);
	$total_discount = $total_fare - calculate_discount_fare($airlines, $search_criteria['From_Code'], $search_criteria['To_Code'], $total_fare);
	$total_discount = bpv_round_rate($total_discount);

	$prices['total_tax'] = $tax_and_fee;

	$prices['total_discount'] = $total_discount;

	$prices['total_price'] = $total_fare + $tax_and_fee - $total_discount;

	// no baggage fee for international flights
	$prices['baggage_fee'] = 0;

	// no bank-fee in the price
	$prices['bank_fee'] = 0;

	$prices['total_tax'] = $prices['total_tax'];
	
	// total payment = total price
	$prices['total_payment'] = $prices['total_price'];

	return $prices;

}

function get_price_from_text($txt,$index=0){
	$arr_str = explode(" ",$txt);
	$price = $arr_str[$index];
	$price = str_replace(",", "", $price);
	return (int)$price;
}

function get_fare_rules($lines, $number_of_route){

	if(!isset($lines[$number_of_route + 3])) return '';

	$fare_rules = $lines[$number_of_route + 3];

	$fare_rules = trim($fare_rules->innertext);

	return $fare_rules;
}


function get_passenger_text($adults, $children, $infants){
	$txt = '';

	if($adults > 0){

		$txt = $adults . ' '.lang('label_adults');

	}

	if($children > 0){
		$txt .= ', '.$children.' '.lang('label_children');
	}

	if($infants > 0){
		$txt .= ', '.$infants.' '.lang('label_infants');
	}


	return $txt;
}

function get_flight_for_booking($vnisc_sid, $flight_str, $search_criteria, $flight_type){

	$flight = array();

	if(!empty($flight_str)){

		$flight_info = explode(";", $flight_str);

		$flight['id'] = $flight_info[0];

		$flight['airline'] = $flight_info[1];

		$flight['code'] = $flight_info[2];

		$flight['stop'] = $flight_info[3];

		$flight['time_from'] = $flight_info[4];

		$flight['time_to'] = $flight_info[5];

		$flight['class'] = $flight_info[6];

		$flight['r_class'] = $flight_info[7];


		$is_domistic = $search_criteria['is_domistic'];


		$flight_detail_url = get_flight_detail_url($vnisc_sid, $flight['id'], $flight['class'], $flight_type, $is_domistic);

		$flight_detail = get_flight_detail($flight_detail_url);

		if($flight_detail != ''){

			$flight_detail_info = get_flight_detail_info($flight_detail, $is_domistic, $flight['stop'], $search_criteria);
				
			$flight['detail'] = $flight_detail_info;
				
		}

	}
	return $flight;
}

function get_flight_detail_url($vnisc_sid, $flight_id, $flight_class, $flight_type, $is_domistic){

	$CI =& get_instance();

	$flight_detail_url = $CI->config->item('flight_data_url');

	$flight_detail_url .= '?sid='.$vnisc_sid;

	$flight_detail_url .= '&Do=GetFlightDetail';

	$flight_detail_url .= '&style=Simple';

	$flight_detail_url .= '&FlightID='.$flight_id;

	if($is_domistic){

		$flight_detail_url .= '&Class='.$flight_class;


	} else {
		if($flight_type == FLIGHT_TYPE_DEPART){
			$flight_detail_url .= '&Class=International_Go';
		}else{
			$flight_detail_url .= '&Class=International_Back';
		}
	}
	return $flight_detail_url;
}

function get_flight_short_desc($search_criteria){

	$desc = $search_criteria['From'] . ' '.lang('flight_go').' '. $search_criteria['To'];

	$desc .= ' ('.($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY ? lang('roundtrip') : lang('one_way')).') ';

	$desc .= ' '.format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true);

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		$desc .= ' - '.format_bpv_date($search_criteria['Return'], DATE_FORMAT, true);
	}

	return $desc;
}

function convert_vnd_to_usd($vnd){
	$CI =& get_instance();
	$usd_rate = $CI->config->item('usd_rate');

	$usd = round($vnd/$usd_rate);

	return $usd;
}

function add_ticket_fee($fare, $ticket_nr = 1, $is_urgent_flight = false, $is_domistic = true){
	$CI =& get_instance();

	$flight_ticket_fee = $is_domistic ? $CI->config->item('flight_ticket_fee') : $CI->config->item('flight_ticket_fee_inter');

	if($is_urgent_flight){
		$flight_ticket_fee = $is_domistic ? $CI->config->item('urgent_flight_ticket_fee') : $CI->config->item('urgent_flight_ticket_fee_inter');
	}

	$ticket_fee = $ticket_nr * $flight_ticket_fee;

	return ($fare + $ticket_fee);
}

function get_step_1_url($sid, $search_criteria){

	$CI =& get_instance();

	$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);


	if(!empty($vnisc_sid)){

		$flight_submit_url = $CI->config->item('flight_vnisc_iframe_url');

		$flight_submit_url .= '?sid='.$vnisc_sid;

	} else {

		$flight_submit_url = '';
	}


	return $flight_submit_url;
}

function get_step_2_url($sid, $search_criteria){

	$CI =& get_instance();

	$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);

	if(!empty($vnisc_sid)){

		$flight_submit_url = $CI->config->item('flight_vnisc_iframe_url');

		$flight_submit_url .= '?step=2&sid='.$vnisc_sid;

	} else {

		$flight_submit_url = '';
	}

	return $flight_submit_url;
}

function get_flight_step_1_submit_params($flight_booking, $search_criteria, $sid){

	$is_domistic = $search_criteria['is_domistic'];

	$duplicate_params = array();

	// general params
	$params['__VIEWSTATE'] = VNISC_VIEW_STATE;
	$params['act'] = 'confirm';
	$params['btnSubmit'] = 'Confirm Flight';

	$cboAirlines = array('{airline}', 'VN');

	if($is_domistic){ // domistic flights only have VN, VJ, BL

		$cboAirlines[] = 'VJ';
		$cboAirlines[] = 'BL';

	} else {

		// internaltional flight data: get airlines from the search data saved in session
		$cboAirlines = array();
		$flight_data = get_flight_session_data($sid, FLIGHT_SEARCH_DATA);
		$airlines = get_inter_flight_airlines($flight_data);
		foreach ($airlines as $airline){
			$cboAirlines[] = $airline['code'];
		}
	}

	$params['cboAirlines'] = $cboAirlines;

	$params['cboSort'] = 'price';

	$params['Go'] = 'Select';
	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY && $is_domistic){ // only return flights and domistic flight has 'Back' parameter
		$params['Back'] = 'Select';
	}


	// set for search form info
	$params['optFlightType'] = $search_criteria['Type'];
	$params['ddlFrom'] = $search_criteria['From_Code'];
	$params['dtpDepDate'] = format_bpv_date($search_criteria['Depart'], 'd/m/Y');

	$params['ddlTo'] = $search_criteria['To_Code'];

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		$params['dtpRetDate'] = format_bpv_date($search_criteria['Return'], 'd/m/Y');
	}

	$params['ddlADT'] = $search_criteria['ADT'];
	$params['ddlCHD'] = $search_criteria['CHD'];
	$params['ddlINF'] = $search_criteria['INF'];

	// set for selected flight

	if($is_domistic){

		$selected_go = get_domistic_selected_flight($flight_booking, $search_criteria, FLIGHT_TYPE_DEPART);

		$selected_back = get_domistic_selected_flight($flight_booking, $search_criteria, FLIGHT_TYPE_RETURN);

		// Go
		$flight_departure = $flight_booking['flight_departure'];
		$params['class_'.$selected_go] = $flight_departure['class'];
		$params['rclass_'.$selected_go] = $flight_departure['r_class'];

		// Back
		if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
				
			$flight_return = $flight_booking['flight_return'];
				
			$params['class_'.$selected_back] = $flight_return['class'];
			$params['rclass_'.$selected_back] = $flight_return['r_class'];
				
		}


		$params['txtFlightGo'] = $selected_go;

		$params['txtFlightBack'] = $selected_back;


	} else {


		$selected_flight = $flight_booking['selected_flight'];

		// Go
		$params['class_'.$selected_flight['Seg']] = 'International_oneway';
		$params['rclass_'.$selected_flight['Seg']] = $selected_flight['Seg'];
		$params['txtFlightGo'] = $selected_flight['Seg'];

		$params['txtFlightBack'] = '';

	}


	$fields_string = '';
	//url-ify the data for the POST
	foreach($params as $key=>$value){

		if(!is_array($value)){

			$fields_string .= $key.'='.urlencode($value).'&';

		} else {
				
			foreach ($value as $item){

				$fields_string .= $key.'='.urlencode($item).'&';

			}
				
		}
			
	}

	if(!empty($duplicate_params)){
		foreach($duplicate_params as $key=>$value){
			$fields_string .= $key.'='.urlencode($value).'&';
		}
	}

	rtrim($fields_string, '&');

	return $fields_string;

}

function get_flight_step_2_submit_params($flight_booking, $search_criteria, $customer){
	
	$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();
	$total_fee = isset($baggage_fees['total_fee_vnd'])? $baggage_fees['total_fee_vnd'] : 0;

	$is_domistic = $search_criteria['is_domistic'];

	$params['__VIEWSTATE'] = VNISC_VIEW_STATE;
	$params['btnSubmit'] = "Confirm Pax";
	$params['current_name'] = "VND"; // or vnd
	$params['ipaddress'] = $customer['ip_address'];

	// set for search form info
	$params['optFlightType'] = $search_criteria['Type'];
	$params['ddlFrom'] = $search_criteria['From_Code'];
	$params['dtpDepDate'] = format_bpv_date($search_criteria['Depart'], 'd/m/Y');

	$params['ddlTo'] = $search_criteria['To_Code'];

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		$params['dtpRetDate'] = format_bpv_date($search_criteria['Return'], 'd/m/Y');
	}

	$params['ddlADT'] = $search_criteria['ADT'];
	$params['ddlCHD'] = $search_criteria['CHD'];
	$params['ddlINF'] = $search_criteria['INF'];

	// set for price info
	$prices = $flight_booking['prices'];
	$params['faretotal'] = $prices['total_price'] - $prices['total_tax'];
	$params['taxtotal'] = $prices['total_tax'];
	$params['flighttotal'] =  $prices['total_price'] + $total_fee; // flight total = total ticket price + total baggage fee

	if($is_domistic){
		$params['taxtotal_nofee'] = $prices['total_tax'];
		$params['totalfee'] =  0;
		$params['totalpromo'] = 0;
	}


	// set for passenger details

	$adults = $flight_booking['adults'];

	foreach ($adults as $key=>$adult){

		$index = $key + 1;

		$params['title_adt_' . $index] = $adult['gender'] == 1 ? 'mr':'ms';

		/**
		 * First Name = Family Name + Middle Name
		 * Last Name: Calling Name
		 *
		 */

		$params['firstname_adt_' . $index] = $adult['first_name'];

		$params['lastname_adt_' . $index] = $adult['last_name'];

		if(!$is_domistic){ //international flight need: nationality, passport, passport expired date, country issue passport
				
			$params['birthday_adt_' . $index] = format_bpv_date($adult['birth_day'], 'd/m/Y');
				
			$params['country_orgin_adt_' . $index] = empty($adult['nationality']) ? 'Vietnam (VN)' : $adult['nationality'];
				
			$params['passport_adt_' . $index] = empty($adult['passport']) ? 'B1023655' : $adult['passport'];
				
			$params['passportexp_adt_' . $index] = empty($adult['passportexp']) ? '25/08/2020' : format_bpv_date($adult['passportexp'], 'd/m/Y');
				
			$params['passportcountry_adt_' . $index] = $params['country_orgin_adt_' . $index]; // default country issue passport = nationality
				
		}

	}


	$children = $flight_booking['children'];

	foreach ($children as $key=>$child){

		$index = $key + 1;

		$params['title_chd_' . $index] = $child['gender'] == 1 ? 'mstr':'miss';
		
		$params['firstname_chd_' . $index] = $child['last_name'];
		
		$params['lastname_chd_' . $index] = $child['first_name'];
		
		
		$params['birthday_chd_' . $index] = date('m/d/Y', strtotime($child['birth_day']));
		/*
		$params['firstname_chd_' . $index] = $child['first_name'];

		$params['lastname_chd_' . $index] = $child['last_name'];

		$params['birthday_chd_' . $index] = '25/08/2008'; //format_bpv_date($child['birth_day'], 'd/m/Y');
*/		
		
		if(!$is_domistic){ //international flight need: nationality, passport, passport expired date, country issue passport

			$params['country_orgin_chd_' . $index] = empty($child['nationality']) ? 'Vietnam (VN)' : $child['nationality'];

			$params['passport_chd_' . $index] = empty($child['passport']) ? 'B1023655' : $child['passport'];

			$params['passportexp_chd_' . $index] = empty($child['passportexp']) ? '25/08/2020' : format_bpv_date($child['passportexp'], 'd/m/Y');

			$params['passportcountry_chd_' . $index] = $params['country_orgin_chd_' . $index]; // default country issue passport = nationality

		}

	}

	$infants = $flight_booking['infants'];

	foreach ($infants as $key=>$infant){

		$index = $key + 1;

		$params['title_inf_' . $index] = $infant['gender'] == 1 ? 'mstr':'miss';

		
		/*
		$params['firstname_inf_' . $index] = $infant['first_name'];

		$params['lastname_inf_' . $index] = $infant['last_name'];
		
		$params['birthday_inf_' . $index] = '25/08/2008'; // format_bpv_date($infant['birth_day'], 'd/m/Y');
	*/
		
		$params['firstname_inf_' . $index] = $infant['last_name'];
		
		$params['lastname_inf_' . $index] = $infant['first_name'];
		
		
		$params['birthday_inf_' . $index] = date('m/d/Y', strtotime($infant['birth_day']));

		

		if(!$is_domistic){ //international flight need: nationality, passport, passport expired date, country issue passport

			$params['country_orgin_inf_' . $index] = empty($infant['nationality']) ? 'Vietnam (VN)' : $infant['nationality'];

			$params['passport_inf_' . $index] = empty($infant['passport']) ? 'B1023655' : $infant['passport'];

			$params['passportexp_inf_' . $index] = empty($infant['passportexp']) ? '25/08/2020' : format_bpv_date($infant['passportexp'], 'd/m/Y');

			$params['passportcountry_inf_' . $index] = $params['country_orgin_chd_' . $index]; // default country issue passport = nationality

		}
	}

	$params = get_flight_baggage_params($params, $flight_booking, $search_criteria);
	
	$CI =& get_instance();

	// set for contact details
	$params['txtConfirmEmail'] = '';
	$params['txtCustomerEmail'] = $customer['email'];
	$params['txtCustomerName'] = $customer['full_name'];
	$params['txtCustomerPhone'] = $customer['phone'];
	$params['txtCustomerAddress'] = !empty($customer['address']) ? $customer['address']:'N/A';
	$params['txtRemark'] = $customer['special_request'];

	// vat information
	$params['txtVat_Address'] = '';
	$params['txtVat_CompanyName'] = '';
	$params['txtVat_ReceivedAddress'] = '';
	$params['txtVat_VatCode'] = '';


	$fields_string = '';
	//url-ify the data for the POST
	foreach($params as $key=>$value){

		$fields_string .= $key.'='.urlencode($value).'&';
			
	}

	rtrim($fields_string, '&');


	return $fields_string;
}

function get_flight_baggage_params($params, $flight_booking, $search_criteria){
	$CI =& get_instance();
	$baggage_options = $CI->config->item('baggage_vnisc_options');

	$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();

	$depart_code = $search_criteria['From_Code'].$search_criteria['To_Code'];
	$return_code = $search_criteria['To_Code'].$search_criteria['From_Code'];
	
	$nr_passenger = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];

	$params['luggage_package'] = '';
	$params['luggage'] = 0;
	$params['price_luggage_'.$depart_code] = 0;
	$params['price_luggage_'.$return_code] = 0;

	if(!empty($baggage_fees['depart'])){
		$flight_departure = $flight_booking['flight_departure'];
		$airline = $flight_departure['airline'];
		$a_bag_options = $baggage_options[$airline];

		for ($i=1; $i<= $nr_passenger; $i++){

			$params['airline_luggage_'.$depart_code.'_'.$i] = 0;
			$params['price_luggage_'.$depart_code.'_'.$i] = 0;
			$params['txtLuggage_'.$depart_code.'_'.$i] = lang('no_baggage').'_0';

			if(isset($baggage_fees['depart'][$i])){

				$kg = $baggage_fees['depart'][$i]['kg'];
				$fee = $baggage_fees['depart'][$i]['money_vnd'];
				$option_id = $a_bag_options[$kg];

				$params['airline_luggage_'.$depart_code.'_'.$i] = $option_id;
				$params['price_luggage_'.$depart_code.'_'.$i] = $fee;
				$params['txtLuggage_'.$depart_code.'_'.$i] = lang_arg('txt_luggage_param',$kg).'_'.$fee.'_'.$option_id;
			}

		}

	}

	if(!empty($baggage_fees['return'])){

		$flight_return = $flight_booking['flight_return'];

		if(!empty($flight_return)){
			$airline = $flight_return['airline'];
			$a_bag_options = $baggage_options[$airline];

			for ($i=1; $i<= $nr_passenger; $i++){

				$params['airline_luggage_'.$return_code.'_'.$i] = 0;
				$params['price_luggage_'.$return_code.'_'.$i] = 0;
				$params['txtLuggage_'.$return_code.'_'.$i] = lang('no_baggage').'_0';
					
				if(isset($baggage_fees['return'][$i])){

					$kg = $baggage_fees['return'][$i]['kg'];
					$fee = $baggage_fees['return'][$i]['money_vnd'];
					$option_id = $a_bag_options[$kg];

					$params['airline_luggage_'.$return_code.'_'.$i] = $option_id;
					$params['price_luggage_'.$return_code.'_'.$i] = $fee;
					$params['txtLuggage_'.$return_code.'_'.$i] = lang_arg('txt_luggage_param',$kg).'_'.$fee.'_'.$option_id;
				}
			}

		}

	}

	return $params;
}

function get_selected_flight_cookie($flight_booking, $search_criteria){

	$str_cookie = '';

	$is_domistic = $search_criteria['is_domistic'];

	if($is_domistic){

		$flight_departure = $flight_booking['flight_departure'];

		$str_cookie = 'vniscChooseFlight_Go_'.$search_criteria['From_Code'].$search_criteria['To_Code'];

		$str_cookie .= '=';

		$str_cookie .= get_domistic_selected_flight($flight_booking, $search_criteria, FLIGHT_TYPE_DEPART);


		if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
				
			$flight_return = $flight_booking['flight_return'];
				
			$str_cookie .= '; ';
				
			$str_cookie .= 'vniscChooseFlight_Back_'.$search_criteria['To_Code'].$search_criteria['From_Code'];
				
			$str_cookie .= '=';
				
			$str_cookie .= get_domistic_selected_flight($flight_booking, $search_criteria, FLIGHT_TYPE_RETURN);
				
				
		}

	} else {

		// code later when we have Abacus Sign-In

		/*
		 $flight_departure = $flight_booking['flight_departure'];

		 $str_cookie = 'vniscChooseFlight_Go_'.$flight_departure['id'].'='.$flight_departure['id'];

		 if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		 	
			$flight_return = $flight_booking['flight_return'];
				
			$str_cookie .= '; ';
				
			$str_cookie .= 'vniscChooseFlight_Back_'.$flight_return['id'].'='.$flight_return['id'];
			}
			*/

	}

	return $str_cookie;

}

function get_domistic_selected_flight($flight_booking, $search_criteria, $type){

	$is_domistic = $search_criteria['is_domistic'];

	if($is_domistic){

		if($type == FLIGHT_TYPE_DEPART){
				
			$flight_departure = $flight_booking['flight_departure'];
				
			$selected_f = $flight_departure['airline'];

			$selected_f .= $search_criteria['From_Code'].$search_criteria['To_Code'];
				
			$selected_f .= format_bpv_date($search_criteria['Depart'], 'dm');
				
			$selected_f .= $flight_departure['time_from'];
				
			$selected_f .= $flight_departure['time_to'];
				
			$selected_f .= $flight_departure['code'];
				
			return $selected_f;
				
		} elseif($type == FLIGHT_TYPE_RETURN) {
				
			if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){

				$flight_return = $flight_booking['flight_return'];

				$selected_f = $flight_return['airline'];
					
				$selected_f .= $search_criteria['To_Code'].$search_criteria['From_Code'];

				$selected_f .= format_bpv_date($search_criteria['Return'], 'dm');

				$selected_f .= $flight_return['time_from'];

				$selected_f .= $flight_return['time_to'];

				$selected_f .= $flight_return['code'];

				return $selected_f;

			}
				
		}

	}

	return '';
}

function submit_step_1_booking_to_vnisc($sid, $flight_booking, $search_criteria){

	$submit_url = get_step_1_url($sid, $search_criteria);

	if(empty($submit_url)) return FALSE;

	$params = get_flight_step_1_submit_params($flight_booking, $search_criteria, $sid);

	$str_cookie = get_selected_flight_cookie($flight_booking, $search_criteria);

	$CI =& get_instance();

	$curl_options = $CI->config->item('sid_curl_options');

	$curl_options[CURLOPT_COOKIE] = $str_cookie;

	$curl_options[CURLOPT_POSTFIELDS] = $params;

	$curl_options[CURLOPT_REFERER] = $submit_url;


	// 1. initialize
	$ch = curl_init($submit_url);
	
	// 2. set the options
	curl_setopt_array($ch, $curl_options);

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);
	
	if($output === FALSE){
		
		$curl_error_nr = curl_errno($ch);

		$log_message = '[ERROR]submit_step_1_booking_to_vnisc - cURL Error: --> '.curl_error($ch).'; Error Number = '. $curl_error_nr.'; Submit URL = '. $submit_url;

		$log_message .= '; Submit Cookie = '.$str_cookie;

		$log_message .= '; Submit Params = '.urldecode($params);

		log_message('error', $log_message);
		 
		send_email_flight_error_notify($log_message);

	}


	// 4. free up the curl handle
	curl_close($ch);
	
	if(isset($curl_error_nr) && $curl_error_nr == 52){
		 
		return submit_step_1_booking_to_vnisc($flight_booking, $search_criteria);
	}
	
	if($output !== FALSE){
		 
		$status = check_step_1_submit_status($output);
		
		if($status){
			return 1; // OK submit step 1 with available seat
		} else {
			return -1; // OK submit step 1 but VNISC shows that the seats are not available
		}
		 
	} else {
		 
		return 0; // CURL ERROR
		 
	}

}

function submit_step_2_booking_to_vnisc($sid, $flight_booking, $search_criteria, $customer, $customer_booking_id){

	$submit_url = get_step_2_url($sid, $search_criteria);
	
	if(empty($submit_url)) return FALSE;

	$params = get_flight_step_2_submit_params($flight_booking, $search_criteria, $customer);

	$str_cookie = get_selected_flight_cookie($flight_booking, $search_criteria);

	$CI =& get_instance();

	$curl_options = $CI->config->item('sid_curl_options');

	$curl_options[CURLOPT_COOKIE] = $str_cookie;

	$curl_options[CURLOPT_POSTFIELDS] = $params;

	$curl_options[CURLOPT_REFERER] = $submit_url;


	// 1. initialize
	$ch = curl_init($submit_url);

	// 2. set the options
	curl_setopt_array($ch, $curl_options);

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);
	
	if($output === FALSE){

		$curl_error_nr = curl_errno($ch);

		$log_message = '[ERROR]submit_step_2_booking_to_vnisc - cURL Error: --> '.curl_error($ch).'; Error Number = '. $curl_error_nr. '; Submit URL = '. $submit_url;

		$log_message .= '; Submit Cookie = '.$str_cookie;

		$log_message .= '; Submit Params = '.urldecode($params);

		log_message('error', $log_message);
		 
		send_email_flight_error_notify($log_message);

	}

	// 4. free up the curl handle
	curl_close($ch);

	if(isset($curl_error_nr) && $curl_error_nr == 52){
		return submit_step_2_booking_to_vnisc($flight_booking, $search_criteria, $customer, $customer_booking_id);
	}

	if($output !== FALSE){
			
		update_vnisc_booking_info($output, $customer_booking_id);
		 
		return 1; // OK submit step 2
		 
	} else {
		return 0; //CURL ERROR
	}
	 

}

function submit_flight_booking_to_vnisc($sid, $flight_booking, $search_criteria, $customer, $customer_booking_id){

	$step_1 = submit_step_1_booking_to_vnisc($sid, $flight_booking, $search_criteria);

	if($step_1 == 1){ // Submit Step 1 OK

		sleep(1);

		$step_2 = submit_step_2_booking_to_vnisc($sid, $flight_booking, $search_criteria, $customer, $customer_booking_id);
		
		return $step_2;
	}

	return $step_1;

}

/**
 *
 * Check if the flight is too close to the departure date or not
 *
 */
function is_too_close_departure($airline, $departure_date, $departure_time, $is_domistic = true){

	$CI =& get_instance();

	$limit_hold_seats = $CI->config->item('limit_hold_seats'); // config for domistic flights

	$limit_hold_seats_inter = $CI->config->item('limit_hold_seats_inter'); // config for international flights


	$booking_time = time();

	$day = (int)date('d', strtotime($departure_date));

	$month = (int)date('m', strtotime($departure_date));

	$year = (int)date('Y', strtotime($departure_date));

	$hour = substr($departure_time, 0 , 2);

	$hour = (int)$hour;

	$minute = substr($departure_time, 2 , 2);

	$minute = (int)$minute;

	//echo 'hour = '. $hour .' - minute = '.$minute . ' - month = '.$month . ' - day = '.$day. ' - year = '.$year;

	//echo '<br>'.$hour_limit;

	$departure_time = mktime($hour, $minute, 0, $month, $day, $year);

	$delta_hour = ($departure_time - $booking_time)/(60*60);

	if($is_domistic){

		$hour_limit = isset($limit_hold_seats[$airline]) ? $limit_hold_seats[$airline] : 36; // if no config then 36 hours

	} else {

		$hour_limit = $limit_hold_seats_inter;
	}

	return $delta_hour <= $hour_limit;

}

function is_allow_hold_seats_close_departure($flight_booking, $search_criteria){

	$flight_departure = $flight_booking['flight_departure'];

	$departure_date = format_bpv_date($search_criteria['Depart']);

	$departure_time = $flight_departure['time_from'];

	$airline = $flight_departure['airline'];

	$is_too_close = is_too_close_departure($airline, $departure_date, $departure_time);

	if($is_too_close){

		return FALSE;

	} else {

		if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
				
			$flight_return = $flight_booking['flight_return'];
				
			$departure_date = format_bpv_date($search_criteria['Return']);

			$departure_time = $flight_return['time_from'];
				
			$airline = $flight_return['airline'];
				
			$is_too_close = is_too_close_departure($airline, $departure_date, $departure_time);
				
			if($is_too_close){

				return FALSE;

			}
				
		}

	}


	return TRUE;
}

function check_pre_hold_flight($flight_booking, $search_criteria){

	$status['is_allow_hold'] = true;

	$status['code'] = 0;

	// international flight
	if(!$search_criteria['is_domistic']){

		$status['is_allow_hold'] = false;

		$status['code'] = 2;

	} else {

		$is_allow = is_allow_hold_seats_close_departure($flight_booking, $search_criteria);

		if(!$is_allow){
				
			$status['is_allow_hold'] = FALSE;

			$status['code'] = 1;

		}

	}

	return $status;
}

/**
 * For domistic flight data: checking if continue call vnisc to get flight data
 * @param unknown $flight_data
 * @return boolean
 */
function is_continue_get_data($flight_data){
	$flight_data = trim($flight_data);

	if($flight_data == FLIGHT_CURL_ERROR) return FALSE; // CURL error case

	if($flight_data == FLIGHT_ERROR_TM) return FALSE; // time-out error from Vnisc

	if($flight_data == FLIGHT_ERROR_UN) return FALSE; // undefine error from Vnisc

	if($flight_data == FLIGHT_NO_FLIGHT) return FALSE; // NO-FLIGHT message from Vnisc

	if($flight_data == FLIGHT_ERROR_INTERNAL) return FALSE; // Internal Error from Vnisc

	if(strpos($flight_data, 'ERROR-') !== false || strpos($flight_data, 'ERROR_') !== false) return FALSE; // other error from Vnisc

	if(strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){ // completed get data
		return FALSE;
	} else {

		if (strpos($flight_data, FLIGHT_PROCESS_WAITING) !== false) { // Vnisc show that waiting getting data
				
			return true;
		}

		if (strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false) { // Vnisc show that continue to get data
			return true;
		}
	}

	// other exception, don't continue to get flight data
	return FALSE;
}

/**
 * For international flight data: checking if continue call vnisc to get flight data
 * @param unknown $flight_data
 * @return boolean
 */
function is_continue_get_international_data($flight_data){

	if (strpos($flight_data, FLIGHT_PROCESS_WAITING) !== false) { // Vnisc show that waiting getting data
			
		return true;

	} else {

		return false;
	}
}

/**
 * Check if the flight data is
 * @param unknown $flight_data
 * @return boolean
 */
function is_valid_flight_data($flight_data){

	$flight_data = trim($flight_data);

	if($flight_data == FLIGHT_CURL_ERROR) return FALSE; // CURL error case

	if($flight_data == FLIGHT_ERROR_TM) return FALSE; // time-out error from Vnisc

	if($flight_data == FLIGHT_ERROR_UN) return FALSE; // undefine error from Vnisc

	if($flight_data == FLIGHT_NO_FLIGHT) return FALSE; // NO-FLIGHT message from Vnisc

	if($flight_data == FLIGHT_ERROR_INTERNAL) return FALSE; // Internal Error from Vnisc

	if(strpos($flight_data, 'ERROR-') !== false || strpos($flight_data, 'ERROR_') !== false) return FALSE; // other error from Vnisc

	if(strpos($flight_data, FLIGHT_PROCESS_WAITING) !== false) return FALSE; // WAITING message from VNISC

	return TRUE;
}

function get_seat_text_unavailable($adults, $children, $infants){

	$passenger_text = get_passenger_text($adults, $children, $infants);

	$txt = lang('flight_seat_unavailable');

	$txt = str_replace("%s", $passenger_text, $txt);

	return $txt;
}

function check_step_1_submit_status($output){


	if($output != ''){

		$CI =& get_instance();

		$CI->load->library('simple_html_dom');

		$html = str_get_html($output);

		$error_divs = $html->find('div[id=showError]');

		if(count($error_divs) == 0){
				
			// no error
			return TRUE;
				
		} else {
			$error_text = trim($error_divs[0]->plaintext);
				
			if(empty($error_text)){
				// no error
				return TRUE;
			} else {

				$error_message = '[ERROR]check_step_1_submit_status(): VNISC return error message = '.$error_text;

				log_message('error', $error_message);

				send_email_flight_error_notify($error_message);
			}
		}

	} else {
		$error_message = '[ERROR]check_step_1_submit_status(): VNISC return Empty Info';

		log_message('error', $error_message);

		send_email_flight_error_notify($error_message);
	}

	// error submit step 1
	return FALSE;
}

/**
 *
 * Send email to the admistrator for flight error
 *
 * $error_type 1.Data Exception, 2.Session Cookie Error, 3.Connection Error
 *
 */
function send_email_flight_error_notify($message, $error_type = 1){

	$CI =& get_instance();

	$email_to = 'vniscflighterror@gmail.com';//'khuyenpv@gmail.com';

	if($error_type == 3){ // only send Connection Error to Mr.Dung
		$email_to .= ';dungkt@bestpricevn.com';
	}

	$from_sbj = "Data Exception";
	$subject = 'Flight Data Exception (Bestprice.VN) '. date('d-m-Y H:i:s');

	if($error_type == 2){
		$subject = 'Flight Session Cookie Lost (Bestprice.VN) '. date('d-m-Y H:i:s');
		$from_sbj = "Session Cookie Lost";
	} elseif ($error_type == 3){
		$subject = 'VNISC Connection Error (Bestprice.VN) '. date('d-m-Y H:i:s');
		$from_sbj = "VNISC Connection Error";
	}


	$content = "<b>Website:</b> Bestprice.VN".'<br>';

	$content .= "<b>Time:</b> ".date('d-m-Y H:i:s').'<br>';

	$content .= "<b>Error Message: </b>".$message;

	$CI->load->library('email');

	$config['protocol'] = 'mail';

	$config['smtp_host']='';
	$config['smtp_port']='25';
	$config['smtp_timeout']='5';
	$config['smtp_user']='';
	$config['smtp_pass']='';

	$config['charset']='utf-8';
	$config['newline']="\r\n";
	$config['mailtype'] = 'html';


	$CI->email->initialize($config);

	$CI->email->from('vniscflighterror@gmail.com', $from_sbj);

	$CI->email->to($email_to);

	$CI->email->subject($subject);

	$CI->email->message($content);

	if (!$CI->email->send()){
		log_message('error', '[ERROR] Flight System Notification Cannot Send Email To Admin');
	}

}

function get_checked_baggage_by_index($flight_booking, $index){

	$str_baggage = '';

	$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();

	$baggage_depart = isset($baggage_fees['depart'])? $baggage_fees['depart'] : array();

	$baggage_return = isset($baggage_fees['return'])? $baggage_fees['return'] : array();

	if(isset($baggage_depart[$index])){
		$str_baggage = lang('baggage_depart').': '.$baggage_depart[$index]['kg'].' Kg';
	}

	if(isset($baggage_return[$index])){

		if($str_baggage != ''){

			$str_baggage .= '<br>';
		}

		$str_baggage .= lang('baggage_return').': '.$baggage_return[$index]['kg'].' Kg';
	}

	if($str_baggage == '') $str_baggage = '&nbsp;';

	return $str_baggage;
}

function get_passenger_by_index($flight_booking, $index){

	$adults = $flight_booking['adults'];

	$children = $flight_booking['children'];

	$infants = $flight_booking['infants'];

	$index = $index - 1;

	if(isset($adults[$index])){
		return $adults[$index];
	}

	$index = $index - count($adults);

	if(isset($children[$index])){
		return $children[$index];
	}

	$index = $index - count($children);

	if(isset($infants[$index])){
		return $infants[$index];
	}

	return '';
}

function get_flight_short_desc_4_cb($search_criteria){

	$desc = '<b>'.$search_criteria['From'] . '</b> '.lang('flight_go').' <b>'. $search_criteria['To'].'</b>';

	$desc .= ' ('.($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY ? lang('roundtrip') : lang('one_way')).') ';

	$desc .= '<br>';

	$desc .= lang('search_fields_departure').' <b>'.format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true).'</b>';

	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		$desc .= ' - '.lang('search_fields_return'). ' <b>'.format_bpv_date($search_criteria['Return'], DATE_FORMAT, true).'</b>';
	}

	return $desc;
}

function seperate_first_last_from_full_name($full_name){
	$ret['first_name'] = '';
	$ret['last_name'] = '';

	if($full_name != ''){
		$full_name = trim($full_name);

		$words = explode(" ", $full_name);

		if(count($words) > 0){
			$ret['first_name'] = trim($words[0]);
		}

		$last_name_words = array();
		for ($i = 1; $i < count($words); $i++){
			if(trim($words[$i]) != ''){
				$last_name_words[] = $words[$i];
			}
		}

		if(count($last_name_words) > 0){
			$ret['last_name'] = implode(' ', $last_name_words);
		}

	}

	return $ret;
}


/**
 * Web Services
 *
 * Functions:
 *
 * AgentLogin:	string AgentLogin(string Agent, string SecurityCode)
 * BookingInfo: OrderID, TokenKey, Hash (md5 of OrderID + SecurityCode), Version (1 or 2)
 * MD5Encrypt
 * GetErrorDescription
 *
 * 	Link: http://webservice.muadi.vn/OTHBookingProcess.asmx
 * 	Agent: WS_BSP
 *	Security_Code: iyMr95mX2NVYa1VnOG3kECOWR74u//YVYV61Zne704
 */

function AgentLogin() {

	$params = array("Agent" => FLIGHT_WEB_SERVICE_AGENT, "SecurityCode" => md5(FLIGHT_WEB_SERVICE_AGENT.FLIGHT_WEB_SERVICE_SECURITY_CODE));

	try {
		$client = new SoapClient(FLIGHT_WEB_SERVICE_URL);

		$response = $client->AgentLogin($params);

		return $response->AgentLoginResult;

	} catch (Exception $e) {
		log_action('Flight Web Service: AgentLogin()', '', $e->getMessage());
	}

	//log_action('Flight Web Service function: AgentLogin()', $params, 'Get Data Failed');

	return null;
}

/*
 * BookingInfo()
 *
 * OrderID: Id of booking
 * Hash: md5(OrderID + Security_Code)
 * TokenKey : AgentLogin return result
 */
function BookingInfo($OrderID, $TokenKey, $Hash, $Version = 1) {

	$params = array("OrderID" => $OrderID, "TokenKey" => $TokenKey, "Hash" => $Hash);

	try {
		$client = new SoapClient(FLIGHT_WEB_SERVICE_URL);

		$response = $client->BookingInfo($params);

		$xmlstring = $response->BookingInfoResult;

		$xml = simplexml_load_string($xmlstring);

		$result = json_decode(json_encode($xml),TRUE);

		/*
		 if(isset($result['BookingInfo']['Travel'])) {
			$travel = $result['BookingInfo']['Travel'];
			$str = explode('|', $travel);
			$result['BookingInfo']['Airline'] = $str[0];
			$result['BookingInfo']['FlightNumber'] = $str[1];
			$result['BookingInfo']['PriceClass'] = $str[2];
			$result['BookingInfo']['Departure'] = $str[3];
			$result['BookingInfo']['From'] = $str[4];
			$result['BookingInfo']['To'] = $str[5];
			$result['BookingInfo']['DepartureTime'] = $str[6];
			$result['BookingInfo']['ArrivalTime'] = $str[7];
		}*/

		return $result['BookingInfo'];

	} catch (Exception $e) {
		log_action('Flight Web Service: BookingInfo()', $params, $e->getMessage());
	}

	return null;
}

// ErrorNumber: int
function GetErrorDescription($ErrorNumber) {

	$params = array("ErrorNumber" => $ErrorNumber);

	try {
		$client = new SoapClient(FLIGHT_WEB_SERVICE_URL);

		$response = $client->GetErrorDescription($params);

		return $response->GetErrorDescriptionResult;

	} catch (Exception $e) {
		log_action('Flight Web Service: GetErrorDescription()', $params, $e->getMessage());
	}

	return null;
}

function MD5Encrypt($InputData) {

	$params = array("InputData" => $InputData);

	try {
		$client = new SoapClient(FLIGHT_WEB_SERVICE_URL);

		$response = $client->MD5Encrypt($params);

		return $response->MD5EncryptResult;

	} catch (Exception $e) {
		log_action('Flight Web Service: MD5Encrypt()', $params, $e->getMessage());
		print_r('Error: '.$e->getMessage());
	}

	return null;
}

function ServerStatus() {

	$params = array();

	try {
		$client = new SoapClient(FLIGHT_WEB_SERVICE_URL);

		$response = $client->ServerStatus($params);

		return $response->ServerStatusResult;

	} catch (Exception $e) {
		log_action('Flight Web Service: ServerStatus()', $e->getMessage());
	}

	return null;
}

/**
 * Functions for International Flights
 */

/**
 * Get flight company logo by code
 *
 */
function get_logo_of_flight_company($flight_company_code){
	$img_src = 'http://flightbooking.bestpricevn.com/Images/Airlines/'.$flight_company_code.'.gif';
	return $img_src;
}

/**
 * Get flight routes: depart route or return route
 *
 */
function get_inter_flight_routes($route_infos, $flight_way = FLIGHT_TYPE_DEPART){
	$ret = array();

	foreach ($route_infos as $route){

		if($route['FlightWay'] == $flight_way){
				
			$ret[] = $route;
				
		}

	}

	return $ret;
}

/**
 * get internaltinonal flight airlines
 */
function get_inter_flight_airlines($flight_data){

	$tmp_arr = array();
	$airlines = array();

	foreach ($flight_data as $flight){

		$route_infos = $flight['RouteInfo'];
		foreach ($route_infos as $route){
			$airline['code'] = $route['Airlines']; // code means: VJ, VN, BJ ... vv
			$airline['name'] = $route['FlightCode']; // name means: Vietjet Air, Vietnam Airlines, ..vv
				
			if(count($tmp_arr) == 0 || !in_array($route['Airlines'], $tmp_arr)){

				$tmp_arr[] = $route['Airlines'];

				$airlines[] = $airline;

			}
		}

	}

	return $airlines;
}

/*
 * get aline codes of the flight
 */
function get_airline_codes_of_flight($route_infos){
	$tmp_arr = array();
	foreach ($route_infos as $route){
		if(count($tmp_arr) == 0 || !in_array($route['Airlines'], $tmp_arr)){

			$tmp_arr[] = $route['Airlines'];
		}
	}

	return implode(',', $tmp_arr);
}

/**
 * Get domistic airline strings for sort & filter
 * @param unknown $flight_data
 */
function get_domistic_flight_airlines($flight_data){

	$CI =& get_instance();

	$domistic_airlines = $CI->config->item('domistic_airlines');

	$tmp_arr = array();
	$airlines = array();
	foreach ($flight_data as $flight){

		$airline['code'] = $flight['Airlines']; // code means: VJ, VN, BJ ... vv
		$airline['name'] = $domistic_airlines[$flight['Airlines']]; // name means: Vietjet Air, Vietnam Airlines, ..vv

		if(count($tmp_arr) == 0 || !in_array($flight['Airlines'], $tmp_arr)){

			$tmp_arr[] = $flight['Airlines'];

			$airlines[] = $airline;

		}
	}

	return $airlines;

}

/**
 * Get flight booking hash based on Search information & current time
 * @param $search_criteria
 * @return string
 */
function get_flight_booking_sid($search_criteria){

	$From = $search_criteria['From_Code'];

	$To = $search_criteria['To_Code'];

	$depart = format_bpv_date($search_criteria['Depart']);

	$DayDepart = date('d', strtotime($depart));

	$MonthDepart = date('m', strtotime($depart));

	$YearDepart = date('Y', strtotime($depart));


	$ADT = $search_criteria['ADT'];

	$CHD = $search_criteria['CHD'];

	$INF = $search_criteria['INF'];

	$Type = $search_criteria['Type'];


	if($Type == FLIGHT_TYPE_ROUNDWAY){

		$return = format_bpv_date($search_criteria['Return']);

		$DayReturn = date('d', strtotime($return));

		$MonthReturn = date('m', strtotime($return));

		$YearReturn = date('Y', strtotime($return));

	} else {
		//date_default_timezone_set("Asia/Saigon");
		// current date
		$DayReturn = date('d');

		$MonthReturn = date('m');

		$YearReturn = date('Y');
	}


	$hash = booking_make_hash(FLIGHT_AGENT_CODE, $From, $To, $DayDepart, $MonthDepart, $YearDepart, $DayReturn, $MonthReturn, $YearReturn, $Type, $ADT, $CHD, FLIGHT_SECURITY_CODE);

	$hash = $hash.time();

	return $hash;
}

/**
 * Set Flight Booking Session Data value
 * @param $sid : hash of the flight search
 * @param $name : name of the data
 * @param $value : value of the data
 */
function set_flight_session_data($sid, $name, $value){

	$CI =& get_instance();

	$flight_session = $CI->session->userdata(FLIGHT_BOOKING_SESSISON_DATA);

	// not in the session before
	if(empty($flight_session)){

		$booking_session = array($name => $value);

		$flight_session[$sid] = $booking_session;

	} else {
		// the session has already store the flight booking
		if(isset($flight_session[$sid])){
				
			$booking_session = $flight_session[$sid];
				
			$booking_session[$name] = $value;
				
			$flight_session[$sid] = $booking_session;
				
		} else {
				
			$booking_session = array($name => $value);
				
			$flight_session[$sid] = $booking_session;
				
		}
	}

	$CI->session->set_userdata(FLIGHT_BOOKING_SESSISON_DATA, $flight_session);

}

/**
 * Get Flight Session Data
 * @param unknown $sid
 * @param unknown $name
 * @return unknown|string
 */
function get_flight_session_data($sid, $name){

	$CI =& get_instance();

	$flight_session = $CI->session->userdata(FLIGHT_BOOKING_SESSISON_DATA);

	if(!empty($flight_session)){

		if(isset($flight_session[$sid])){
				
			$booking_session = $flight_session[$sid];
				
			if(isset($booking_session[$name])){

				return $booking_session[$name];

			}
				
		}
	}

	return '';

}

/**
 * Unset Flight Session Data value
 * @param unknown $sid
 * @param string $name
 */
function unset_flight_session_data($sid, $name = ''){

	$CI =& get_instance();

	$flight_session = $CI->session->userdata(FLIGHT_BOOKING_SESSISON_DATA);

	if(!empty($flight_session)){

		if(isset($flight_session[$sid])){
				
			if($name == ''){ // unset all the booking session
				unset($flight_session[$sid]);
			} else {
				$booking_session = $flight_session[$sid];

				if(isset($booking_session[$name])) unset($booking_session[$name]);

				$flight_session[$sid] = $booking_session;
			}
				
			$CI->session->set_userdata(FLIGHT_BOOKING_SESSISON_DATA, $flight_session);
		}
	}
}

/**
 * Convert from HHmm to HH:mm
 * @param unknown $flight_time
 * @return string
 */
function flight_time_format($flight_time){
	$t1 = substr($flight_time, 0, 2);

	$t2 = substr($flight_time, -2);

	return $t1.':'.$t2;
}

/**
 * Get date of the flight by date and month
 * @param unknown $day
 * @param unknown $month
 * @return string
 */
function flight_date($day, $month, $format = DATE_FORMAT){

	$today = date(DB_DATE_FORMAT);

	$current_year = date('Y');

	$fly_date = $current_year.'-'.$month.'-'.$day;

	$fly_date = date(DB_DATE_FORMAT, strtotime($fly_date));

	if($fly_date < $today){

		$current_year = (int) $current_year;

		$current_year = $current_year + 1;
	}

	$fly_date = $current_year.'-'.$month.'-'.$day;

	$fly_date = date($format, strtotime($fly_date));

	return $fly_date;
}

/**
 * Get time delay between 2 times
 */
function calculate_flying_time($time_1, $day_1, $month_1, $time_2, $day_2, $month_2){

	$date_time_1 = flight_date($day_1, $month_1, DB_DATE_FORMAT).' '.flight_time_format($time_1).':00';

	$date_time_2 = flight_date($day_2, $month_2, DB_DATE_FORMAT).' '.flight_time_format($time_2).':00';

	$date_time_1 = strtotime($date_time_1);

	$date_time_2 = strtotime($date_time_2);

	$seconds = $date_time_2 - $date_time_1;

	$hours = round($seconds/(60 * 60));

	$minutes = ($seconds / 60) % 60;

	$ret['h'] = $hours;
	$ret['m'] = $minutes;

	return $ret;
}

/**
 * Calculate Flight Fare based on Marketing Discount
 */

function calculate_discount_fare($airline, $from, $to, $fare){

	$today = date(DB_DATE_FORMAT);

	$CI =& get_instance();

	$discount_cnf = $CI->config->item('inter_flight_discounts');

	$start_date = format_bpv_date($discount_cnf['start_date']);

	$end_date = format_bpv_date($discount_cnf['end_date']);

	if($today >= $start_date && $today <= $end_date){

		if(isset($discount_cnf[$airline])){
				
			$discount_info = $discount_cnf[$airline];
				
			$from_airports = $discount_info['from'];
				
			$to_airports = $discount_info['to'];
				
			$discount = $discount_info['discount'];
				
			if(!empty($from_airports) && in_array($from, $from_airports)){

				// empty to_airports means applying for all destination
				if(empty($to_airports) || in_array($to, $to_airports)){
						
					if($discount > 0){

						$fare = $fare * (1 - $discount/100);

					}
						
				}

			}
				
		}

	}

	return $fare;
}

/**
 * Load Flight Search Calendar View
 */
function load_flight_search_calendar($flight_type, $search_criteria, $sid){

	$CI =& get_instance();

	$data['flight_type'] = $flight_type;

	$data['search_criteria'] = $search_criteria;

	$data['week_days'] = $CI->config->item('week_days');

	$data['sid'] = $sid;

	$mobile_view = is_mobile() ? 'mobile/' : '';

	$calendar_view = $CI->load->view($mobile_view.'flights/flight_search/flight_calendar', $data, true);

	return $calendar_view;
}

/**
 *
 * @param unknown $flight_url
 * @return string
 */

function update_change_day_to_vnisc($flight_url){

	if(empty($flight_url)) return false;

	$CI =& get_instance();

	$curl_options = $CI->config->item('sid_curl_options');

	// 1. initialize
	$ch = curl_init($flight_url);

	// 2. set the options
	curl_setopt_array($ch, $curl_options);

	// 3. execute and fetch the resulting HTML output
	$output = curl_exec($ch);

	// 4. free up the curl handle

	if($output !== FALSE){
			
		// ok to submit change day infomation to VNISC
		return true;
			
	} else {
			
		$curl_erro_nr = curl_errno($ch);
			
		$error_message = 'update_change_day_to_vnisc - cURL Error: --> '.curl_error($ch).'; Error Number = '. $curl_erro_nr.'; Submit URL = '. $flight_url;

		log_message('error', $error_message);

		send_email_flight_error_notify($error_message, 3);
	}

	curl_close($ch);

	if(isset($curl_erro_nr) && $curl_erro_nr == 52){
			
		return update_change_day_to_vnisc($flight_url);
			
	} else {

		return false;
	}

	return true;
}

/**
 * Update VNISC Booking Information
 * VNISC_BOOKING_ID & VNISC_BOOKING_CODE to Customer Booking
 * Khuyenpv 22.10.2014
 */
function update_vnisc_booking_info($output, $customer_booking_id){

	$CI =& get_instance();

	$CI->load->library('simple_html_dom');

	$html = str_get_html($output);

	$div_pnrs = $html->find('div[id=divPNR]');

	if (count($div_pnrs) > 0){

		$scripts = $div_pnrs[0]->find('script');

		if (count($scripts) > 0){
				
			$link = $scripts[0]->innertext;
				
			$link = str_replace("top.location.href = '", '', $link);
				
			$link = str_replace("';", '', $link);
				
			$params = explode("id=", trim($link));

			if(count($params) > 1){
				 
				$vnisc_booking_id = $params[1];
				 
				$booking_code = '';
				/*
				 $vnisc_login_str = AgentLogin();
				  
				 if(!empty($vnisc_login_str)){

				 $hash = md5($vnisc_booking_id.FLIGHT_WEB_SERVICE_SECURITY_CODE);

				 $booking_info = BookingInfo($vnisc_booking_id, $vnisc_login_str, $hash);

				 if(!empty($booking_info)){
				  
				 $booking_code = $booking_info['BookingCode'];
				 }
				 }
				  
				 // update VNISC Boking-ID & Booking Code
				 $CI->Flight_Model->update_vnisc_booking_info($customer_booking_id, $vnisc_booking_id, $booking_code);
				 */
			}
		}
	}
}

/**
 * Set Fare Rules Short for for the SR
 */
function set_fare_rule_short($airline, $flight_class){

	if($airline == 'VN'){

		if(in_array($flight_class, array('P','E','A'))) return lang('short_fare_rule_1');

		if(in_array($flight_class, array('C','J'))) return lang('short_fare_rule_3');
	}

	return lang('short_fare_rule_2');
}


function bpv_format_currency($rate, $small_end = true){

	$rate = bpv_round_rate($rate);

	if($rate <= 0) return '<span>0 ' .lang('usd').'</span>';

	$rate = number_format($rate);
	$rate = str_replace(',', '.', $rate);

	$rate_2 = substr($rate, -3);

	$rate_1 = substr($rate, 0, strlen($rate) - 3);

	if($small_end){
		$rate = '<span>'.$rate_1.'<small>'.$rate_2.' '.lang('usd').'</small></span>';
	} else {
		$rate = '<span>'.$rate_1.''.$rate_2.' '.lang('usd').'</span>';
	}

	return $rate;
}

function bpv_round_rate($rate){
	$rate = $rate/1000;
	$rate = round($rate) * 1000;
	return $rate;
}

function get_flight_exception_short_req($search_criteria){
	$desc = lang('search_fields_from'). ': '. $search_criteria['From'];
	$desc .= "\n".lang('search_fields_to'). ': '. $search_criteria['To'];
	$desc .= "\n".lang('search_fields_departure'). ': '. $search_criteria['Depart'];
	if(!empty($search_criteria['Return'])){
		$desc .= "\n".lang('search_fields_return'). ': '. $search_criteria['Return'];
	}
	$desc .= "\n".lang('passenger'). ': '. get_passenger_text($search_criteria['ADT'], $search_criteria['CHD'], $search_criteria['INF']);

	$desc .= "\n".'---------------------------';
	return $desc;
}
?>