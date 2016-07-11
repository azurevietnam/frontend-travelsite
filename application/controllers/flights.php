<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flights extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();
       	
		$this->load->language(array('flight','faq'));	
		$this->load->model(array('FlightModel', 'FaqModel', 'DestinationModel','TourModel','CustomerModel'));
		
		$this->load->helper(array('form','text','cookie','flight', 'payment','booking'));
		$this->config->load('flight_meta');
			
		
		$this->load->driver('cache', array('adapter' => 'file'));
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		
		$this->session->set_userdata('MENU', MNU_FLIGHTS);
			
		$data['metas'] = site_metas(FLIGHT_HOME);
		$data['navigation'] = create_flight_home_nav_link(true);
			
		//$data = load_faq_by_context('11', $data);
		
		$data = build_flight_search_criteria($data);
		
		$data['popular_routes'] = $this->Flight_Model->get_popular_fights();
		
		$data['flight_routes'] = $this->FlightModel->get_all_flight_routes();
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
	
		$data = get_flight_theme($data);
		
		$data['search_dialog'] = $this->load->view('flights/flight_search/flight_search_dialog', $data, TRUE);
		
		$data['flight_destination_links'] = $this->load->view('flights/flight_destination/flight_destination_links', $data, TRUE);
		
		$data['main'] = $this->load->view('flights/flight_home', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function search(){
		$this->session->set_userdata('MENU', MNU_FLIGHTS);
			
		$data['metas'] = site_metas(FLIGHT_SEARCH);
		$data['navigation'] = create_flight_search_nav_link(true);
		
			
		$data = load_faq_by_context('11', $data);
		
		$data = build_flight_search_criteria($data, true);
		
		$search_criteria = $data['search_criteria'];
		
		if(!$search_criteria['valid_url_params']){
			redirect(url_builder('', FLIGHT_HOME));
			exit();
		}
		
		
		/*
		 * Get VNISC SID END THEN CALL AJAX TO GET FLIGHT DATA
		 * 26.01.2014: should get VNISC SID & FLIGHT DATA IN AJAX CALLING TOGETHER
		 * 
		 *
		$flight_url = get_flight_url($data['search_criteria']);		
		
		$data['sid'] = get_flight_vnisc_sid($flight_url);
		
		$data['flight_type'] = FLIGHT_TYPE_DEPART;
		
		if(!empty($data['sid'])){
			
			$search_criteria['sid'] = $data['sid'];
			
			$this->session->set_userdata(FLIGHT_SEARCH_CRITERIA, $search_criteria);
		}
		
		*
		*/
		
		$this->session->set_userdata(FLIGHT_SEARCH_CRITERIA, $search_criteria); // save current search to session
		$data['sid'] = 1; // for not changing code in the view
		$data['flight_type'] = FLIGHT_TYPE_DEPART;
		
		
		if($search_criteria['ADT'] + $search_criteria['CHD'] > FLIGHT_PASSENGER_LIMIT){
			
			log_message('error', '[INFO]search(): passenger limited (adt + chd > 9), adt = '.$search_criteria['ADT'].', chd = '.$search_criteria['CHD']);
			
		}elseif($search_criteria['INF'] > $search_criteria['ADT']){
			
			log_message('error', '[INFO]search(): infants limited (inf > adt) , inf = '.$search_criteria['INF'].', adt = '.$search_criteria['ADT']);
			
		}
			
		
		
		$data = $this->load_filter_data($data);
	
		$data = get_flight_theme($data);
		
		$data['main'] = $this->load->view('flights/flight_search/flight_search_main', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function get_flight_data(){
		
		$search_criteria = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
		$is_domistic = $search_criteria['is_domistic'];
		$flight_type = $this->input->post('flight_type');
		
		/*
		 * Get VNISC SID END THEN CALL AJAX TO GET FLIGHT DATA
		 * 26.01.2014: should get VNISC SID & FLIGHT DATA IN AJAX CALLING TOGETHER
		 * 
		 $sid = $this->input->post('sid');
		 */
		
		$sid = $this->_get_vnisc_sid($search_criteria);
		
		if(!$is_domistic){
			$sid = '';
		}
		
		if(!empty($sid)){
			
			$flight_data_url = $this->config->item('flight_data_url');
			
			$flight_data_url .= '?sid='.$sid;
			
			
			if ($is_domistic){
				$flight_data_url .= '&Do=GetFlightData';
			} else {
				$flight_data_url .= '&Do=GetFlightInternational';
			}
			
			$flight_data_url .= '&type='.$flight_type;
			$flight_data_url .= '&sort=price';
			$flight_data_url .= '&Output=JSON';
			
			
			$call_times = 0;
			$t1 = microtime(true);
			
			$flight_search_timeut = $this->config->item('flight_search_timeut');
			
			// store previous not-empty flight data
			$previous_flight_data = '';
			
			do{
				$flight_data = get_flight_data($flight_data_url, $flight_type);
				
				$is_continue = is_continue_get_data($flight_data);
				
				$t_search = microtime(true);
				
				// time-out on search flight data
				if($t_search - $t1 > $flight_search_timeut){
					$is_continue = false;
						
					log_message('error', '[ERROR]get_flight_data(): Time Out on getting flight data');
				}
				
				
				// store the previous sucessfull get-ting flight data
				
				$flight_data = trim($flight_data);
				
				// only save the data that <continue> or <complete>
				if(strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){
					
					$previous_flight_data = $flight_data;
					
					$previous_flight_data = str_replace(FLIGHT_PROCESS_CONTINUE, "", $previous_flight_data);
					$previous_flight_data = str_replace(FLIGHT_PROCESS_COMPLETED, "", $previous_flight_data);
					
				}
				
				
				if(!$is_domistic){
					$is_continue = FALSE;
				}
				
				$call_times++;
				
				if($is_continue){
					if($call_times <= 2){
						sleep(3);
					} else {
						sleep(2);
					}
				}
					
			}while ($is_continue);
			$t2 = microtime(true);
			
			// Get JSON data from Vnisc
			if(strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){
				
				$flight_data = str_replace(FLIGHT_PROCESS_CONTINUE, "", $flight_data);
				$flight_data = str_replace(FLIGHT_PROCESS_COMPLETED, "", $flight_data);
				
				// get the last-called flight data
				$flight_data = json_decode($flight_data, true);
			
			} else {
				
				if (trim($flight_data) == FLIGHT_CURL_ERROR){
					// do nothing, already log in the curl calling function 
				} elseif(trim($flight_data) == FLIGHT_ERROR_TM){
					log_message('error', '[ERROR]get_flight_data(): get Error-TM from VNISC'); 
					
				}elseif(trim($flight_data) == FLIGHT_ERROR_UN){
					log_message('error', '[ERROR]get_flight_data(): get Error-UN from VNISC');
					
				}elseif(strpos($flight_data, 'ERROR-') !== false){
					log_message('error', '[ERROR]get_flight_data(): get '.$flight_data.' from VNISC');
				} else {
					log_message('error', '[ERROR]get_flight_data(): get unexpected-error. Content return =  '.$flight_data.'');
				}
				
				if($previous_flight_data != ''){
					// get the previous-called flight data
					$flight_data = json_decode($previous_flight_data, true); 
					
					log_message('error', '[ERROR]get_flight_data(): Error getting data from VNISC But get previous data sucessfully');
				} else {
					
					$error_message = '[ERROR]get_flight_data(): Error getting data from VNISC with empty data returned';
					
					log_message('error', $error_message);
					
					$error_message .= ' - Error Message = '.$flight_data;
					
					send_email_flight_error_notify($error_message);
					
					$flight_data = array();
					$sid = '';

				}
			}
			
			log_message('error', '[INFO]get_flight_data(): Number of calls = '. $call_times .'; Time Get Data = '.($t2 - $t1).' seconds; Submit URL = '.$flight_data_url. '; Search URL = '.get_flight_url($search_criteria));

		} else {
			
			$flight_data = array();
		}
	
		$data['flight_data'] = $this->check_flight_data($flight_data, $is_domistic);
		
		$data['valid_airlines_codes'] = $this->config->item('valid_airline_codes');
		
		$data['sid'] = $sid;
		
		$data['is_domistic'] = $is_domistic;
		
		$data['flight_type'] = $flight_type;
		
		$data['search_criteria'] = $search_criteria;
		
		$this->load->view('flights/flight_search/flight_data_content', $data);
		
	}
	
	function get_flight_detail(){
		
		$search_criteria = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
		
		$is_domistic = $search_criteria['is_domistic'];
		
		$sid = $search_criteria['sid'];
		
		$flight_id = $this->input->post('flight_id');
		
		$flight_class = $this->input->post('flight_class');
		
		$flight_stop = $this->input->post('flight_stop');
		
		$flight_type = $this->input->post('flight_type');
		
		$flight_detail_url = get_flight_detail_url($sid, $flight_id, $flight_class, $flight_type, $is_domistic);
		
		$flight_detail = get_flight_detail($flight_detail_url);
		
		if($flight_detail != ''){
		
			$flight_detail_info = get_flight_detail_info($flight_detail, $is_domistic, $flight_stop);
			
			$this->load->view('flights/flight_search/flight_detail', $flight_detail_info);
			
			//echo $flight_detail;
			
		} else {
			echo '';
		}
		
	}
	
	function load_filter_data($data){
		
		$data['airlines'] = $this->FlightModel->get_airlines();
		
		$data['departure_times'] = $this->config->item('departure_times');
		
		$data['flight_filter'] = $this->load->view('flights/flight_search/flight_filter', $data, true);
		
		return $data;
	}
	
	function check_flight_data($flight_data, $is_domistic = true){
		
		$ret = array();
		$valid_airlines_codes = $this->config->item('valid_airline_codes');
		
		if(!empty($flight_data)){
			foreach ($flight_data as $flight){
				$airline = $flight['Airlines'];
				if(array_key_exists($airline, $valid_airlines_codes)){
					
					if ($flight['PriceInfo'][0]['ADT_Fare'] > 0){
					
						$flight['departure_time_index'] = get_departure_time_index($flight);
						
						$flight['Stop'] = 0;
						
						$flight['Class'] = !empty($flight['PriceInfo'][0]['Class'])? $flight['PriceInfo'][0]['Class'] : '';
						
						$flight['RClass'] = !empty($flight['PriceInfo'][0]['RClass'])? $flight['PriceInfo'][0]['RClass'] : '';
						
						$flight['Seat'] = !empty($flight['PriceInfo'][0]['Seat'])? $flight['PriceInfo'][0]['Seat'] : 0;
						
						if(!$is_domistic){
							$flight['Stop'] = count($flight['RouteInfo']) - 1;
							$flight['StopTxt'] = $flight['Stop'] == 0 ? lang('direct') : $flight['Stop'].' '.lang('stop');
							if($flight['Stop'] > 1) $flight['StopTxt'] .= 's';
							$flight['FlightCode'] = $flight['Airlines'].'-'.$flight['Stop'].'-'.$flight['TimeFrom'];
							
							// get flight class
							$flight['Class'] = '';
							foreach ($flight['RouteInfo'] as $route){
								$flight['Class'] = $flight['Class'].$route['Class'].'-';
							}
							if(strlen($flight['Class']) > 0) $flight['Class'] = substr($flight['Class'],0,-1);
							
							// get time to
							$cnt = count($flight['RouteInfo']);
							if($cnt > 0){
								
								$last_route = $flight['RouteInfo'][$cnt -1];
								
								$flight['TimeTo'] = $last_route['TimeTo'];
							}
						}
						
						// convert vnd to usd
						
						$flight['PriceInfo'][0]['ADT_Fare'] = convert_vnd_to_usd($flight['PriceInfo'][0]['ADT_Fare']);
						
						//$flight['PriceInfo'][0]['ADT_Fare'] = add_ticket_fee($flight['PriceInfo'][0]['ADT_Fare'], 1);
					
						$ret[] = $flight;
					
					}
				}
			}
		}
		
		if(count($ret) > 0){
			usort($ret, array($this, 'sort_price_asc'));
		}
		
		return $ret;
	}
	
	function sort_price_asc($f1, $f2){
		if($f1['PriceInfo'][0]['ADT_Fare'] == $f2['PriceInfo'][0]['ADT_Fare']) {
			return ($f1['FlightCode'] < $f2['FlightCode']) ? -1: 1;
		}
		return ($f1['PriceInfo'][0]['ADT_Fare'] < $f2['PriceInfo'][0]['ADT_Fare']) ? -1: 1;
	}
	
	function flight_detail(){
		
		$this->session->set_userdata('MENU', MNU_FLIGHTS);
			
		$data['metas'] = site_metas(FLIGHT_DETAIL);
		$data['navigation'] = create_flight_details_nav_link(true);
		
		$data['baggage_fee_cnf'] = $this->config->item('baggage_fees');
		
		$data = get_flight_theme($data);
		
		$data['breadcrumb_pos'] = 2;
		
		$data['breadcrumb'] = $this->load->view('flights/common/progress_tracker', $data, TRUE);
		
		$search_criteria = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
		
		$data['search_criteria'] = $search_criteria;
			
		$flight_booking = $this->get_flight_booking($search_criteria);
		
		if (empty($flight_booking)){
			
			redirect('/flights/');exit();
		}
		
		$action = $this->input->post('action');
		
		if($action == 'change-passenger' || $action == 'next'){
			
			redirect('/flights/payment.html');exit();
				
		}
		
		$data['flight_booking'] = $flight_booking;
		
		$data['flight_summary'] = $this->load->view('flights/flight_booking/flight_summary', $data, TRUE);
		
		$data['flight_itinerary'] = $this->load->view('flights/flight_booking/flight_itinerary', $data, TRUE);
		
		$data['flight_passenger'] = $this->load->view('flights/flight_booking/flight_passenger', $data, TRUE);
		
		$data['flight_baggage_fees'] = $this->load->view('flights/flight_booking/flight_baggage_fees', $data, TRUE);
		
		$data['main'] = $this->load->view('flights/flight_booking/flight_detail', $data, TRUE);
		
		$this->load->view('template', $data);
		
	}
	
	function flight_payment(){
		
		$this->session->set_userdata('MENU', MNU_FLIGHTS);
			
		$data['metas'] = site_metas(FLIGHT_PAYMENT);
		$data['navigation'] = create_flight_payment_nav_link(true);
		
		$data = get_flight_theme($data);
		
		$data['breadcrumb_pos'] = 3;
		
		$data['breadcrumb'] = $this->load->view('flights/common/progress_tracker', $data, TRUE);
		
		$search_criteria = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
		
		$data['search_criteria'] = $search_criteria;
			
		$flight_booking = $this->get_flight_booking($search_criteria);
		
		if (empty($flight_booking)){
			
			redirect('/flights/');exit();
			
		}elseif(count($flight_booking['adults']) == 0){
			
			redirect(FLIGHT_DETAIL);exit();
		}
		
		$current_time = microtime(true);
		
		// check if the flight-booking-data is timed out
		if(isset($flight_booking['time_check_flight'])){
			
			$delta_time = $current_time - $flight_booking['time_check_flight'];
			
			$flight_data_timeout = $this->config->item('flight_data_timeout');
			
			log_message('error', '[INFO]flight_payment(): DELTA TIME = '. $delta_time. ' and TimeOut Threshold = '.$flight_data_timeout. '. Search URL = '.$search_criteria['search_url']);
			
			if($delta_time > $flight_data_timeout){
				
				$flight_booking['is_unavailable'] = true;
				
				log_message('error', '[ERROR ]flight_payment(): TIME-OUT on Payment page, DELTA TIME = '. $delta_time .' and Timeout Threshold = '.$flight_data_timeout. '. Search URL = '.$search_criteria['search_url']);
			}
			
		} else {
			$flight_booking['is_unavailable'] = true;
			
			log_message('error', '[ERROR]flight_payment(): TIME-OUT on Payment page, [time_check_flight] not set. Search URL = '.$search_criteria['search_url']);
		}
		
		
		$action = $this->input->post('action');
		
		// book action when the data has not been time-out	
		if ($action == 'book' && !$flight_booking['is_unavailable']){
			
			$submit_status_nr = $this->_book();
			
			if(!is_null($submit_status_nr)){
				
				$data['submit_status_nr'] = $submit_status_nr;
				
			}
		}
		
		
		$data['flight_booking'] = $flight_booking;
		
		$data['bank_fee'] = $this->config->item('bank_fee');

		$data['countries'] = $this->config->item('countries');
		
		$data['hold_status'] = check_pre_hold_flight($flight_booking, $search_criteria);
		
		$data['flight_summary'] = $this->load->view('flights/flight_booking/flight_summary', $data, TRUE);
		
		$data['flight_itinerary'] = $this->load->view('flights/flight_booking/flight_itinerary', $data, TRUE);
		
		$data['flight_passenger'] = $this->load->view('flights/flight_booking/flight_passenger', $data, TRUE);
		
		$data = $this->_load_flight_term_conditioins($data);
		
		$data['main'] = $this->load->view('flights/flight_booking/flight_submit', $data, TRUE);
		
		$this->load->view('template', $data);
		
	}
	
	function get_flight_booking($search_criteria){
		
		$flight_booking = array();
		
		$flight_departure_str = $this->input->post('flight_departure');		
		$flight_return_str = $this->input->post('flight_return');
		
		$action = $this->input->post('action');
		
		// if access from the link, get from cookie
		if(empty($flight_departure_str)){
			$flight_booking = $this->session->userdata(FLIGHT_BOOKING_INFO);
		}else{
			
			$flight_booking['flight_departure'] = get_flight_for_booking($flight_departure_str, $search_criteria, FLIGHT_TYPE_DEPART);
			
			$flight_booking['flight_return'] = get_flight_for_booking($flight_return_str, $search_criteria, FLIGHT_TYPE_RETURN);
			
			$flight_booking['nr_adults'] = $search_criteria['ADT'];
			
			$flight_booking['nr_children'] = $search_criteria['CHD'];
				
			$flight_booking['nr_infants'] = $search_criteria['INF'];
			
			$flight_booking['time_check_flight'] = microtime(true);
							
		}
		
		if($action == 'next' || $action == 'change-passenger'){
			$flight_booking = $this->get_passenger_details($flight_booking);
		}
		
		if($action == 'next' || $action == 'change-baggage'){
		
			$baggage_fees = $this->get_baggage_fees($flight_booking, $search_criteria);
		
			$flight_booking['baggage_fees'] = $baggage_fees;
		
		}
		
		if(!empty($flight_booking)){
			$flight_booking = $this->get_flight_booking_price($flight_booking);
		}
		
		$this->session->set_userdata(FLIGHT_BOOKING_INFO, $flight_booking);		
	
		return $flight_booking;
	
	}
	
	function get_baggage_fees($flight_booking, $search_criteria){
	
		if(!$search_criteria['is_domistic']) return array(); // no baggage fee for internaltional flights
	
		$baggage_fees['depart'] = array();
		$baggage_fees['return'] = array();
	
		$total_kg = 0;
		$total_fee_vnd = 0;
		$total_fee_usd = 0;
	
		$baggage_fees_cnf = $this->config->item('baggage_fees');
		$nr_passengers = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];
	
		// get baggage fee for depart
		$flight_departure = $flight_booking['flight_departure'];
		$fees = $baggage_fees_cnf[$flight_departure['airline']];
		if(is_array($fees['send'])){
			for ($i=1; $i<= $nr_passengers; $i++){
				$kg = $this->input->post('baggage_depart_'.$i);
	
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
					$kg = $this->input->post('baggage_return_'.$i);
						
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
	
	function get_flight_booking_price($flight_booking){
		
		$prices['adult_fare_total'] = 0;
		
		$prices['children_fare_total'] = 0;
		
		$prices['infant_fare_total'] = 0;
		
		$prices['total_tax'] = 0;
		
		$prices['total_price'] = 0;
		
		$prices['baggage_fee'] = 0;
		
		$prices['bank_fee'] = 0;
		
		$prices['total_payment'] = 0;
		
		
		$is_unavailable = false;
		
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
		$total_baggage_fee_usd = isset($baggage_fees['total_fee_usd'])?$baggage_fees['total_fee_usd']:0;
		
		$prices['baggage_fee'] = $total_baggage_fee_usd;
		
		$bank_fee = $this->config->item('bank_fee');
		
		$prices['bank_fee'] = round(($prices['total_price'] + $total_baggage_fee_usd) * $bank_fee/100,2);
		
		$prices['total_payment'] = $prices['total_price'] + $total_baggage_fee_usd +  $prices['bank_fee'];
		
		$flight_booking['prices'] = $prices;
		
		$flight_booking['is_unavailable'] = $is_unavailable;
		
		return $flight_booking;
	}
	
	function get_passenger_details($flight_booking){
		
		$nr_adults = $flight_booking['nr_adults'];
				
		$nr_children = $flight_booking['nr_children'];
			
		$nr_infants = $flight_booking['nr_infants'];
		
		
		$adults = array();
		
		$children = array();
		
		$infants = array();
		
		for ($i = 1; $i <= $nr_adults; $i++){
			
			$gender = $this->input->post('adults_gender_'.$i);
			
			$first = $this->input->post('adults_first_'.$i);
			
			$middle = $this->input->post('adults_middle_'.$i);
			
			$last = $this->input->post('adults_last_'.$i);
			
			$adult['gender'] = $gender;
			$adult['first_name'] = $first;
			$adult['middle_name'] = $middle;
			$adult['last_name'] = $last;
			
			$adults[] = $adult;
		}
		
		for ($i = 1; $i <= $nr_children; $i++){
			
			$gender = $this->input->post('children_gender_'.$i);
			
			$first = $this->input->post('children_first_'.$i);
			
			$middle = $this->input->post('children_middle_'.$i);
			
			$last = $this->input->post('children_last_'.$i);
			
			$day = $this->input->post('children_day_'.$i);
			
			$month = $this->input->post('children_month_'.$i);
			
			$year = $this->input->post('children_year_'.$i);
			
			
			$child['gender'] = $gender;
			$child['first_name'] = $first;
			$child['middle_name'] = $middle;
			$child['last_name'] = $last;
			
			$child['birth_day'] = date(DATE_FORMAT_DISPLAY, mktime(0,0,0,$month,$day,$year));
			
			$children[] = $child;
			
		}
		
		for ($i = 1; $i <= $nr_infants; $i++){
			
			$gender = $this->input->post('infants_gender_'.$i);
			
			$first = $this->input->post('infants_first_'.$i);
			
			$middle = $this->input->post('infants_middle_'.$i);
			
			$last = $this->input->post('infants_last_'.$i);
			
			$day = $this->input->post('infants_day_'.$i);
			
			$month = $this->input->post('infants_month_'.$i);
			
			$year = $this->input->post('infants_year_'.$i);
			
			$infant['gender'] = $gender;
			$infant['first_name'] = $first;
			$infant['middle_name'] = $middle;
			$infant['last_name'] = $last;
			
			$infant['birth_day'] = date(DATE_FORMAT_DISPLAY, mktime(0,0,0,$month,$day,$year));
			
			$infants[] = $infant;
		}
				
		
		$flight_booking['adults'] = $adults;
		
		$flight_booking['children'] = $children;
		
		$flight_booking['infants'] = $infants;
		
		return $flight_booking;
	}
	
	function _validateBooking()
		{
		$this->_setValidationRules();
		return $this->form_validation->run();
	}
	
	function _setValidationRules()
	{
		$this->load->library('form_validation');
		$booking_rules = $this->config->item('booking_rules');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
		$this->form_validation->set_rules($booking_rules);
	}
	
	function _book(){
		if ($this->_validateBooking()) {
			
			/**
			 *
			 * SET RESERVATION INFO FROM FLIGHT BOOKING
			 *
			 */
			
			$flight_booking = $this->session->userdata(FLIGHT_BOOKING_INFO);
			
			$search_criteria = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
			
			if(empty($flight_booking) || empty($search_criteria)){
				
				$this->_clear_flight_session_data();
				
				redirect(url_builder('', FLIGHT_HOME));
				
				exit();
			}
			
			
			$reservation_infos = get_reservations_from_flight_booking($flight_booking, $search_criteria);
				
			$cus['title'] = $this->input->post('title');
			$cus['full_name'] = $this->input->post('full_name');
			$cus['email'] = $this->input->post('email');
			$cus['phone'] = $this->input->post('phone');
			$cus['fax'] = $this->input->post('fax');
			$cus['country'] = $this->input->post('country');
			$cus['city'] = $this->input->post('city');
			$cus['ip_address'] = $_SERVER['REMOTE_ADDR'];
				
			$customer_id = $this->TourModel->create_or_update_customer($cus);
				
			$special_request = trim($this->input->post('special_requests'));
				
			$customer_booking_id = $this->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request);
			
			
			if($customer_booking_id !== FALSE){
				
				$hold_status = check_pre_hold_flight($flight_booking, $search_criteria);
				
				// create invoice
				$invoice_id = $this->CustomerModel->create_invoice($customer_id, $customer_booking_id, FLIGHT);
				
				if ($invoice_id === FALSE){ // false to create invoice
				
					log_message('error', '[INFO]Flight->_book(): FAIL to create Invoice. Go Thank_you Page');
				
					// clear visa session
					$this->_clear_flight_session_data();
						
					// show thank you page as normal submit
					redirect(site_url().'thank_you/');
				
					exit();
						
				} else {
						
					// get invoice detail and call payment module
					$invoice = $this->CustomerModel->get_invoice_4_payment($invoice_id);
				
					$cus['special_request'] = $special_request;
					$submit_status_nr = submit_flight_booking_to_vnisc($flight_booking, $search_criteria, $cus);
				
				
					if($submit_status_nr == 1){ // OK to submit data to VNISC
						
						// send email to customer
						$this->_send_mail($search_criteria, $flight_booking, $cus, $special_request, $invoice['invoice_reference'], false, $hold_status['is_allow_hold']);
						
						// clear visa session
						$this->_clear_flight_session_data();

						// allow book & payment online
						if($hold_status['is_allow_hold']){
							
							log_message('error', '[INFO]Flight->_book(): Submit Booking Data to VNISC Sucessfully & Go to Onepay');
								
							// call payment module with the invoice input
							$pay_url = get_payment_url($invoice);
							
							redirect($pay_url);
								
							exit();
							
						} else {
							
							log_message('error', '[INFO]Flight->_book(): Submit Booking Data to VNISC Sucessfully - But time too close departure - Do not allow online payment - Go to Confirm Page');
							
							redirect(site_url().'thank_you/');
							
							exit();
							
						}
						
				
					} else{ // FAIL to submit
							
						log_message('error', '[ERROR]Flight->_book(): FAIL to Submit Booking Data to VNISC, Show Message to Customer');
							
						return  $submit_status_nr;
							
					}
				
				
				
				}
				
			}
			
		}
	}
	
	function _clear_flight_session_data(){
		
		$this->session->unset_userdata(FLIGHT_SEARCH_CRITERIA);
		
		$this->session->unset_userdata(FLIGHT_BOOKING_INFO);
		
	}
	
	function _send_mail($search_criteria, $flight_booking, $cus, $special_request, $invoice_reference, $is_send_customer = true, $is_allow_hold = true){
	
		
		$data['invoice_reference'] = $invoice_reference;
		
		$data['flight_booking'] = $flight_booking;
		
		$data['search_criteria'] = $search_criteria;
		
		$data['valid_airline_codes'] = $this->config->item('valid_airline_codes');
		
		$data['bank_fee'] = $this->config->item('bank_fee');
		
		$data['special_request'] = $special_request;
		
		$data['is_allow_hold'] = $is_allow_hold;
	
	
		$countries = $this->config->item('countries');
		$cus['country_name'] = $countries[$cus['country']][0];
		$config_title = $this->config->item('title');
		$cus['title_text'] = $config_title[$cus['title']];
	
		$headers = "Content-type: text/html\r\n";
	
		$header_cus = 'From: ' . $cus['email'] . "\r\n". $headers;
		$header_bpt = 'From: ' . BRANCH_NAME.' <reservation@'.strtolower(SITE_NAME).'>'. "\r\n". $headers;
			
		$short_flight_desc = get_flight_short_desc($search_criteria);
		
		
		$subject_cus = 'Autoreply: ' . $short_flight_desc . ' - '. BRANCH_NAME;
		$subject_bpt = 'Reservation: ' . $short_flight_desc . ' - '. $cus['full_name'];
	
		$data['cus'] = $cus;
	
		$content = $this->load->view('flights/common/flight_booking_mail', $data, TRUE);

		//echo $content;exit();
	
		//mail('reservation@'.strtolower(SITE_NAME), $subject_bpt, $content, $header_cus);
		mail(FLIGHT_PAYMENT_NOTIFICATION_EMAIL, $subject_bpt, $content, $header_cus);
	
		
		if ($is_send_customer){
			mail($cus['email'], $subject_cus, $content, $header_bpt);
		}
	
		return true;
	}
	
	function flight_to_destination() {
	
		$url_title = $this->uri->segment(2);
	
		//anti sql injection
		$url_title = anti_sql($url_title);
	
		$destination = substr($url_title, strlen('flight-to')+1);
		$destination = str_replace(URL_SUFFIX, '', $destination);

		if(stripos($destination, FLIGHT_DESTINATION) !== false) {
			$destination = substr($destination, 0, strlen($destination) - strlen(FLIGHT_DESTINATION) - 1);
		}

		$des = $this->DestinationModel->get_destination_flight_info($destination);
	
		if (! $des) {
			redirect(site_url());
		}
	
		$data['destination'] = $des;
		
		$this->session->set_userdata('MENU', MNU_FLIGHTS);
			
		$data['metas'] = site_metas(FLIGHT_DESTINATION, $des);
		$data['navigation'] = create_flight_destination_nav_link(true, $des);
			
		//$data = load_faq_by_context('11', $data);
	
		// Set flight to
		
		$data['flight_to'] = $des['destination_code'];
		
		// Build search form
		
		$data = build_flight_search_criteria($data);
	
		$data['popular_routes'] = $this->FlightModel->get_flights_of_destiantion($des['id']);
	
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
	
		$data = get_flight_theme($data);
		
		$data['search_dialog'] = $this->load->view('flights/flight_search/flight_search_dialog', $data, TRUE);
		
		$data['flight_destination_links'] = $this->load->view('flights/flight_destination/flight_destination_links', $data, TRUE);
	
		$data['main'] = $this->load->view('flights/flight_destination/flight_to_destination', $data, TRUE);
	
		$this->load->view('template', $data);
	}
	
	/**
	 * After Vnisc booked the tickets, they return the link http://www.bestpricevn.com/flights/ticket-booked.html?ID=[bookingid]
	 * 
	 * Get the flight booking & update PRN
	 * 
	 */
	function ticket_booked(){
		
		$cb_id = $this->input->get('id');
		
		$tocken = AgentLogin();
		
		$booking_info = BookingInfo($cb_id, $tocken, md5($cb_id.FLIGHT_WEB_SERVICE_SECURITY_CODE));
		
		echo $cb_id.' - '.print_r($booking_info);
		
		//echo phpinfo();
		
	}
	
	function _get_vnisc_sid($search_criteria){
		
		if(!empty($search_criteria['sid'])){
			
			$sid = $search_criteria['sid'];
			
		} else {
			
			$flight_url = get_flight_url($search_criteria);		
		
			$sid = get_flight_vnisc_sid($flight_url);
			
			if(!empty($sid)){
				
				$search_criteria['sid'] = $sid;
				
				$this->session->set_userdata(FLIGHT_SEARCH_CRITERIA, $search_criteria);
			}
		}
		
		return $sid;
		
	}
	
	function _load_flight_term_conditioins($data){
		
		$this->load->language('about');
		
		$data['is_flight_booking_page'] = 1;
		
		$data['general_policy'] = $this->load->view('about/policy_view', $data, true);
		
		$data['flight_term_conditions'] = $this->load->view('flights/flight_booking/flight_term_conditions', $data, TRUE);
		
		return $data;
	}
}

?>