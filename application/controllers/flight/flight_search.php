<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight_Search extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();
       	
		$this->load->language('flight');	
		
		$this->load->model(array('Flight_Model', 'Destination_Model'));
		
		$this->load->helper(array('basic', 'resource','format', 'flight', 'flight_search','advertise','contact'));
		
		$this->config->load('flight_meta');
			
		//$this->output->enable_profiler(TRUE);
	}
	
	function index(){		
		
		// check if the current device is Mobile or Not
		$is_mobile = is_mobile();
		 
		// set current menu
		set_current_menu(MNU_FLIGHTS);
		 
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(FLIGHT_SEARCH_PAGE);
		
		$data['page_theme'] = get_page_theme(FLIGHT_SEARCH_PAGE, $is_mobile);
		 
		$data = get_page_navigation($data, $is_mobile, FLIGHT_SEARCH_PAGE);
		
		// 1. Get the search-criteria from the url
		//$search_criteria = get_flight_search_criteria_from_url();
		$search_criteria = get_flight_search_criteria();
		
		// 2. Redirect to empty link if the search is invalid
		if(!is_valid_flight_search($search_criteria)){
			redirect(get_page_url(VN_FLIGHT_PAGE));
		}
		
		// 3. Check if the flight search is in exception cases
		$exception = get_flight_search_exception($search_criteria);

		if(!empty($exception)){ // exception case
			
			redirect(get_page_url(FLIGHT_SEARCH_EXCEPTION_PAGE, $exception, $search_criteria));
			
		}

		// load the searc-overview & search form & search filters
		
		$data = load_flight_search_overview($data, $is_mobile, $search_criteria);
		
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
		$data = load_flight_search_form($data, $is_mobile, $search_criteria, $display_mode_form);
	
		$data = load_flight_search_filters($data, $is_mobile, $search_criteria);	
		
		// save to session for save the current search status
		$this->session->set_userdata(FLIGHT_SEARCH_CRITERIA, $search_criteria); // save current search to session
		
		/**
		 *
		 * 02.07.2014: save the search information to the Flight Booking Session
		 *
		 */
		$sid = get_flight_booking_sid($search_criteria);
		
		
		// save search criteria of this session
		set_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA, $search_criteria);
		
		
		$data['sid'] = $sid; // session id of the current search
		
		$data['flight_type'] = FLIGHT_TYPE_DEPART;
		
		$data['search_criteria'] = $search_criteria;
		
		render_view('flights/search/flight_search_results', $data, $is_mobile);
	}
	
	function exception(){
		
		// check if the current device is Mobile or Not
		$is_mobile = is_mobile();
			
		// set current menu
		set_current_menu(MNU_FLIGHTS);
			
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(FLIGHT_SEARCH_EXCEPTION_PAGE);
		
		$data['page_theme'] = get_page_theme(FLIGHT_SEARCH_EXCEPTION_PAGE, $is_mobile);
			
		$data = get_page_navigation($data, $is_mobile, FLIGHT_SEARCH_EXCEPTION_PAGE);	
		
		// 1. Get the search-criteria from the url
		//$search_criteria = get_flight_search_criteria_from_url();
		$search_criteria = get_flight_search_criteria();
		
		// 2. Redirect to empty link if the search is invalid
		if(!is_valid_flight_search($search_criteria)){
			redirect(get_page_url(VN_FLIGHT_PAGE));
		}
		
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
		$data = load_flight_search_form($data, $is_mobile, $search_criteria, $display_mode_form);

		$exception_code =  $this->input->get('code');
		
		if($exception_code == 1){ // over 9 passengers
			$data['message'] = lang('exception_message_2'); //lang_arg('exception_message_1', FLIGHT_PASSENGER_LIMIT);
		}
		else if($exception_code == 2){ // infants > adults
			$data['message'] = lang('exception_message_2');
		}
		else if($exception_code == 3){ // book international flights
			$data['message'] = lang('exception_message_3');
		}
		
		else if($exception_code == 4){ // No Flight Route
			$data['message'] = lang_arg('exception_message_4', $search_criteria['From'], $search_criteria['To']);
		}
		
		else if($exception_code == 5){ // Departure In The Past
			$data['message'] = lang_arg('exception_message_5', '25/06/1991');//$search_criteria['Depart']
		}
		
		else if($exception_code == 6){ // Return Date < Departure Date
			$data['message'] = lang_arg('exception_message_6', $search_criteria['Return'], $search_criteria['Depart']);
		}
		
		$data = load_contact_form($data, $is_mobile, 'save_customer_contact_form');
	
		
		render_view('flights/search/flight_search_exception', $data, $is_mobile);
	}
	
	function get_flight_data(){
		
		$is_mobile = is_mobile();
		$mobile_view = $is_mobile ? 'mobile/' : '';
	
		// type of the flight: depart or return
		$flight_type = $this->input->post('flight_type');
	
		// session id of the current search
		$sid = $this->input->post('sid');
	
		// day_index (from the search calendar)
		$day_index = $this->input->post('day_index');
	
		// selected departure flight
		$departure_flight = $this->input->post('departure_flight');
	
		$is_domistic = true;
	
		// get search criteria in the flight search session structure
		$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
		
		if(!empty($search_criteria)){
			
			$is_domistic = $search_criteria['is_domistic'];				
			// get search criteria in the flight search session structure
			$vnisc_sid = $this->_get_vnisc_sid($sid, $search_criteria, $flight_type);
			
			if(!empty($vnisc_sid)){
				
				if($day_index != 0){
					$err_code = $this->_update_search_data_by_change_day($sid, $flight_type, $search_criteria, $vnisc_sid, $day_index);
					if($err_code != 0){
						$data['error_code'] = 2; // fail to get data
					}
						
					$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
				}
	
				// save the VNISC SID into session for later use
				set_flight_session_data($sid, FLIGHT_VNISC_SID, $vnisc_sid);
					
				$flight_data_url = $this->config->item('flight_data_url');
	
				$flight_data_url .= '?sid='.$vnisc_sid;
					
					
				if ($is_domistic){
					$flight_data_url .= '&Do=GetFlightData';
				} else {
					$flight_data_url .= '&Do=GetFlightInternational';
				}
	
	
					
				$flight_data_url .= '&type='.$flight_type;
				$flight_data_url .= '&sort=price';
				$flight_data_url .= '&Output=JSON';
				
				if($is_domistic){					
					// search domistic flights
					$flight_data = $this->_get_flight_domistic_data($flight_data_url, $flight_type, $search_criteria);
					
					// ok get flight data
					if(strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){
						
						// remove <continue> or <complete> message before decoding JSON data
						$flight_data = str_replace(FLIGHT_PROCESS_CONTINUE, "", $flight_data);
						$flight_data = str_replace(FLIGHT_PROCESS_COMPLETED, "", $flight_data);
	
						$flight_data = json_decode($flight_data, true);
	
						$data['flight_data'] = $this->_restructure_domictic_flight_data($flight_data);
						
						// get all the airlines for creating filter by airlines
						$data['airlines'] = get_domistic_flight_airlines($flight_data);
						
						/*
						 * when the user change the date of return flight (on quick date calendar)
						 * the Flight-ID of the selected departure flight will be changed automatically on VNISC
						 * that why we need to search the departure flights again to update the Flight-ID of the selected
						 * dearture flight
						 *
						 * Only apply for domistic flights
						*/
	
	
						if($flight_type == FLIGHT_TYPE_RETURN && $day_index != 0 && $departure_flight != ''){
							$t1 = microtime(true);
							$selected_departure = $this->_update_selected_departure_flight($vnisc_sid, $departure_flight, $search_criteria);
							$t2 = microtime(true);
								
							//echo ($t2 - $t1);exit();
								
							if($selected_departure != ''){
	
								$data['selected_departure'] = $selected_departure;
	
							}
								
						}
	
	
					} else{
						
						$data['error_code'] = 2; // fail to get data
	
						if($flight_data == FLIGHT_NO_FLIGHT){
								
							$data['error_code'] = 3; // all flight are sold out
								
						}
					}
				
				} else {
						
					// search internatinal flights
					$flight_data = $this->_get_flight_international_data($flight_data_url, $flight_type, $search_criteria);
						
					// ok get flight data
					if(is_valid_flight_data($flight_data)){
	
						$flight_data = json_decode($flight_data, true);
	
						// save the search data to session for later used
						set_flight_session_data($sid, FLIGHT_SEARCH_DATA, $flight_data);
	
						// restructure flight search data for easy diplaying on the view
						$data['flight_data'] = $this->_restructure_international_flight_data($flight_data, $search_criteria);
	
						// get all the airlines for creating filter by airlines
						$data['airlines'] = get_inter_flight_airlines($flight_data);
	
					} else {
	
						$data['error_code'] = 2; // fail to get data
	
						if($flight_data == FLIGHT_NO_FLIGHT){
	
							$data['error_code'] = 3; // all flight are sold out
								
						}
	
					}
				}
	
			} else {
	
				$data['error_code'] = 2; // fail to get data
	
				$this->load->library('user_agent');
				$agent = $this->agent->agent_string();
	
				$error_message = '[ERROR]get_flight_data(): Fail to get VNISC-ID from Session';
	
				$error_message .= '. Agent String = '.$agent;
	
				if($this->agent->is_mobile()){
					$error_message .= '<br> Mobile = '.$this->agent->mobile();
				}
					
				if($this->agent->is_browser()){
					$error_message .= '<br> Browser = '.$this->agent->browser().'; Version = '. $this->agent->version();
				}
					
				$error_message .= '<br> Platform = '.$this->agent->platform();
	
				log_message('error', $error_message);
	
				send_email_flight_error_notify($error_message, 2);
			}
	
		} else {
	
			$data['error_code'] = 2; // fail to get data
				
			$this->load->library('user_agent');
			$agent = $this->agent->agent_string();
				
			$error_message = '[ERROR]get_flight_data(): Fail to get Search-Criteria from Session';
				
			$error_message .= '. Agent String = '.$agent;
				
			if($this->agent->is_mobile()){
				$error_message .= '<br> Mobile = '.$this->agent->mobile();
			}
				
			if($this->agent->is_browser()){
				$error_message .= '<br> Browser = '.$this->agent->browser().'; Version = '. $this->agent->version();
			}
				
			$error_message .= '<br> Platform = '.$this->agent->platform();
				
			log_message('error', $error_message);
				
			send_email_flight_error_notify($error_message, 2);
				
		}
	
		$data['is_mobile'] = $is_mobile;
	
		$data['domistic_airlines'] = $this->config->item('domistic_airlines');
	
		$data['is_domistic'] = $is_domistic;
	
		$data['flight_type'] = $flight_type;
	
		$data['sid'] = $sid;
	
		$data['search_criteria'] = $search_criteria;	
		
		$data['sort_by'] = $this->config->item('sort_by');
		
		$data = $this->_load_filter_data($data, $is_mobile);
	
		$data = $this->_load_flight_sort_by($data, $is_mobile);
		
		if($is_domistic){

			//load_view('flights/flight_search/flight_data_content', $data, $is_mobile, false);
			$this->load->view($mobile_view.'flights/flight_search/flight_data_content', $data);
				
		} else {
			//load_view('flights/flight_search/flight_data_content_international', $data, $is_mobile);
			$this->load->view($mobile_view.'flights/flight_search/flight_data_content_international', $data);
				
		}
	
	}
	
	function _get_flight_domistic_data($flight_data_url, $flight_type, $search_criteria){
	
		$call_times = 0;
		$t1 = microtime(true);
			
		$flight_search_timeut = $this->config->item('flight_search_timeout');
	
		// store previous not-empty flight data
		$previous_flight_data = '';
	
		do{
			$flight_data = get_flight_data($flight_data_url, $flight_type);
	
			$is_continue = is_continue_get_data($flight_data);
	
			$t_search = microtime(true);
	
			// time-out on search flight data
			if($t_search - $t1 > $flight_search_timeut){
				$is_continue = false;
					
				log_message('error', '[ERROR]_get_flight_domistic_data(): Time Out on getting flight data');
			}
	
	
			// store the previous sucessfull get-ting flight data
	
			$flight_data = trim($flight_data);
	
			// only save the data that <continue> or <complete>
			if(strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){
	
				$previous_flight_data = $flight_data;
	
				$previous_flight_data = str_replace(FLIGHT_PROCESS_CONTINUE, "", $previous_flight_data);
				$previous_flight_data = str_replace(FLIGHT_PROCESS_COMPLETED, "", $previous_flight_data);
	
			}
	
	
			$call_times++;
	
			if($is_continue){
	
				if($call_times <= 2){
					sleep(4);
				} else {
					sleep(3);
				}
			}
	
		}while ($is_continue);
		$t2 = microtime(true);
	
		log_message('error', '[INFO]_get_flight_domistic_data(): Number of calls = '. $call_times .'; Time Get Data = '.($t2 - $t1).' seconds; Submit URL = '.$flight_data_url. '; Search URL = '.get_flight_url($search_criteria));
	
		// Get JSON data from Vnisc
		$is_valid_flight_data = strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false;
	
		if(!$is_valid_flight_data){
	
			if ($flight_data == FLIGHT_CURL_ERROR){
				// do nothing, already log in the curl calling function
			} elseif($flight_data == FLIGHT_ERROR_TM){
				log_message('error', '[ERROR]_get_flight_domistic_data(): get Error-TM from VNISC');
	
			}elseif($flight_data == FLIGHT_ERROR_UN){
				log_message('error', '[ERROR]_get_flight_domistic_data(): get Error-UN from VNISC');
	
			}elseif($flight_data == FLIGHT_NO_FLIGHT){
					
				log_message('error', '[ERROR]_get_flight_domistic_data(): get NO_FLIGHT from VNISC');
					
			}elseif(strpos($flight_data, 'ERROR-') !== false){
				log_message('error', '[ERROR]_get_flight_domistic_data(): get '.$flight_data.' from VNISC');
			} else {
				log_message('error', '[ERROR]_get_flight_domistic_data(): get unexpected-error. Content return =  '.$flight_data.'');
			}
	
			if($previous_flight_data != ''){
	
				// get the previous-called flight data
				$flight_data = $previous_flight_data;
	
				log_message('error', '[ERROR]_get_flight_domistic_data(): Error getting data from VNISC But get previous data sucessfully');
			} else {
	
				$error_message = '[ERROR]_get_flight_domistic_data(): Error getting data from VNISC with empty data returned';
	
				log_message('error', $error_message);
	
				$error_message .= ' - Error Message = '.$flight_data;
	
				send_email_flight_error_notify($error_message);
	
			}
		}
	
	
		return $flight_data;
	}
	
	function _get_flight_international_data($flight_data_url, $flight_type, $search_criteria){
	
		$call_times = 0;
		$t1 = microtime(true);
			
		$flight_search_timeut = $this->config->item('flight_search_timeout_inter');
	
		do{
			$flight_data = get_flight_data($flight_data_url, $flight_type);
	
			$is_continue = is_continue_get_international_data($flight_data);
	
			$t_search = microtime(true);
	
			// time-out on search flight data
			if($t_search - $t1 > $flight_search_timeut){
				$is_continue = false;
					
				log_message('error', '[ERROR]_get_flight_international_data(): Time Out on getting flight data');
			}
	
	
			// store the previous sucessfull get-ting flight data
	
			$flight_data = trim($flight_data);
	
			$call_times++;
	
			if($is_continue){
				if($call_times <= 2){
					sleep(4);
				} else {
					sleep(3);
				}
			}
	
		}while ($is_continue);
		$t2 = microtime(true);
			
		log_message('error', '[INFO]_get_flight_international_data(): Number of calls = '. $call_times .'; Time Get Data = '.($t2 - $t1).' seconds; Submit URL = '.$flight_data_url. '; Search URL = '.get_flight_url($search_criteria));
	
		// Get JSON data from Vnisc
		if(!is_valid_flight_data($flight_data)){
	
			if ($flight_data == FLIGHT_CURL_ERROR){
				// do nothing, already log in the curl calling function
			} elseif($flight_data == FLIGHT_ERROR_TM){
				log_message('error', '[ERROR]_get_flight_international_data(): get Error-TM from VNISC');
	
			}elseif($flight_data == FLIGHT_ERROR_UN){
				log_message('error', '[ERROR]_get_flight_international_data(): get Error-UN from VNISC');
	
			}elseif($flight_data == FLIGHT_NO_FLIGHT){
					
				log_message('error', '[ERROR]_get_flight_international_data(): get NO_FLIGHT from VNISC');
					
			}elseif(strpos($flight_data, 'ERROR-') !== false || strpos($flight_data, 'ERROR_') !== false){
	
				log_message('error', '[ERROR]_get_flight_international_data(): get '.$flight_data.' from VNISC');
	
			} else {
	
				log_message('error', '[ERROR]_get_flight_international_data(): get unexpected-error. Content return =  '.$flight_data.'');
			}
	
				
			$error_message = '[ERROR]_get_flight_international_data(): Error getting data from VNISC with no Flight data returned';
	
			log_message('error', $error_message);
	
			$error_message .= ' - Error Message = '.$flight_data;
	
			send_email_flight_error_notify($error_message);
				
		}
	
		return $flight_data;
	}
	
	function _get_vnisc_sid($sid, $search_criteria, $flight_type){
	
		$vnisc_sid = '';
	
		// get in the current session only for return flight
		/*
		 * Comment on 27.08.2014 by Khuyenpv: $sid is unique -> always get Vnisc SID from Session first
		 *
			if($flight_type == FLIGHT_TYPE_RETURN){
	
			$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);
				
			}*/
	
		$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);
	
		//echo $vnisc_sid; exit();
	
		// if the vnisc-sid is not in the session
		if($vnisc_sid == ''){
	
			$flight_url = get_flight_url($search_criteria);
				
			//echo $flight_url;exit();
	
			$vnisc_sid = get_flight_vnisc_sid($flight_url);
	
		}
		
		return $vnisc_sid;
	
	}
	
	/**
	 * Update Search Data & Flight Data by Change Day
	 * 1. Call to Vnisc Link to synchonize search data
	 * 2. Update Search-Criteria for the change of Depart or Return Date
	 */
	function _update_search_data_by_change_day($sid, $flight_type, $search_criteria, $vnisc_sid, $day_index){
	
		if($day_index == 0) return 0; // do nothing
	
	
		$flight_submit_url = $this->config->item('flight_vnisc_iframe_url');
	
		$flight_submit_url .= '?sid='.$vnisc_sid;
	
		if($flight_type == FLIGHT_TYPE_DEPART){
				
			$flight_submit_url .= '&go_day='.$day_index;
				
		} else {
				
			$flight_submit_url .= '&back_day='.$day_index;
		}
	
	
		$submit_status = update_change_day_to_vnisc($flight_submit_url);
	
	
		if($flight_type == FLIGHT_TYPE_DEPART){
	
			$depart = $search_criteria['Depart'];
				
			$depart = format_bpv_date($depart);
				
			if($day_index > 0){
				$depart = strtotime($depart. ' +'.$day_index.' days');
			} else {
				$depart = strtotime($depart. ' -'.(0 - $day_index).' days');
			}
				
			$depart = date(DATE_FORMAT, $depart);
				
			$search_criteria['Depart'] = $depart;
	
		} else {
	
			$return = $search_criteria['Return'];
	
			$return = format_bpv_date($return);
	
			if($day_index > 0){
				$return = strtotime($return. ' +'.$day_index.' days');
			} else {
				$return = strtotime($return. ' -'.(0 - $day_index).' days');
			}
	
			$return = date(DATE_FORMAT, $return);
	
			$search_criteria['Return'] = $return;
		}
	
		set_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA, $search_criteria);
	
		$this->session->set_userdata(FLIGHT_SEARCH_CRITERIA, $search_criteria); // save current search to session
	
		if($submit_status){
				
			return 0; // 0 means everything is successful
				
		} else {
				
			return 2; // 2 means error to connect to VNISC
		}
	}
	
	/**
	 * Search the Departure Flight again and update the selected departure-flight
	 *
	 */
	function _update_selected_departure_flight($vnisc_sid, $departure_flight, $search_criteria){
	
		$ret = '';
	
		$flight_data_url = $this->config->item('flight_data_url');
		$flight_data_url .= '?sid='.$vnisc_sid;
		$flight_data_url .= '&Do=GetFlightData';
			
		$flight_data_url .= '&type='.FLIGHT_TYPE_DEPART;
		$flight_data_url .= '&sort=price';
		$flight_data_url .= '&Output=JSON';
	
		// search domistic flights
		$flight_data = $this->_get_flight_domistic_data($flight_data_url, FLIGHT_TYPE_DEPART, $search_criteria);
			
		// ok get flight data
		if(strpos($flight_data, FLIGHT_PROCESS_CONTINUE) !== false || strpos($flight_data, FLIGHT_PROCESS_COMPLETED) !== false){
	
			// remove <continue> or <complete> message before decoding JSON data
			$flight_data = str_replace(FLIGHT_PROCESS_CONTINUE, "", $flight_data);
			$flight_data = str_replace(FLIGHT_PROCESS_COMPLETED, "", $flight_data);
	
			$flight_data = json_decode($flight_data, true);
				
			if(!empty($flight_data)){
	
				foreach ($flight_data as $flight){
						
					if($flight['FlightCode'] == $departure_flight){
	
						$ret = $flight['Seg'].';'.$flight['Airlines'].';'.$flight['FlightCode'].';0;';
	
						$ret .= $flight['TimeFrom'].';'.$flight['TimeTo'].';';
	
						$flight['Class'] = !empty($flight['PriceInfo'][0]['Class'])? $flight['PriceInfo'][0]['Class'] : '';
	
						$flight['RClass'] = !empty($flight['PriceInfo'][0]['RClass'])? $flight['PriceInfo'][0]['RClass'] : '';
	
						$ret .= $flight['Class'].';'.$flight['RClass'];
	
						break;
					}
						
				}
	
			}
				
		}
	
	
		return $ret;
	}
	
	
	/**
	 * Restructure domistic flight data for easy diplaying on the view
	 * @param unknown $flight_data
	 * @return multitype:number
	 */
	function _restructure_domictic_flight_data($flight_data){
	
		$ret = array();
	
		if(!empty($flight_data)){
			foreach ($flight_data as $flight){
	
				if ($flight['PriceInfo'][0]['ADT_Fare'] > 0){
	
					$flight['departure_time_index'] = get_departure_time_index($flight);
	
					$flight['Stop'] = 0;
	
					$flight['Class'] = !empty($flight['PriceInfo'][0]['Class'])? $flight['PriceInfo'][0]['Class'] : '';
	
					$flight['RClass'] = !empty($flight['PriceInfo'][0]['RClass'])? $flight['PriceInfo'][0]['RClass'] : '';
	
					$flight['Seat'] = !empty($flight['PriceInfo'][0]['Seat'])? $flight['PriceInfo'][0]['Seat'] : 0;
	
					$ret[] = $flight;
	
				}
	
			}
		}
	
		if(count($ret) > 0){
			usort($ret, array($this, 'sort_price_asc'));
		}
	
		return $ret;
	}
	
	/**
	 * Restructure international flight data for easy diplaying on the view
	 * @param unknown $flight_data
	 * @return multitype:unknown
	 */
	function _restructure_international_flight_data($flight_data, $search_criteria){
	
		$ret = array();
	
		if(!empty($flight_data)){
			foreach ($flight_data as $flight){
	
				if ($flight['PriceInfo'][0]['ADT_Fare'] > 0){
	
					$flight['departure_time_index'] = get_departure_time_index($flight);
						
					$first_route = $flight['RouteInfo'][0];
					// used for sort flight by Flight Company
					$flight['FlightCode'] = $first_route['Airlines'].'-'.$first_route['FlightCodeNum'];
	
					// set information of depart flightss
					$depart_routes = get_inter_flight_routes($flight['RouteInfo'], FLIGHT_TYPE_DEPART);
					$flight_depart['TimeFrom'] = $depart_routes[0]['TimeFrom']; // first route time-from
					$flight_depart['DayFrom'] = $depart_routes[0]['DayFrom']; // first route day-from
					$flight_depart['MonthFrom'] = $depart_routes[0]['MonthFrom']; // first route month-from
						
					$flight_depart['TimeTo'] =  $depart_routes[count($depart_routes)-1]['TimeTo']; // last rout time-to
					$flight_depart['DayTo'] = $depart_routes[count($depart_routes)-1]['DayTo']; // first route day-to
					$flight_depart['MonthTo'] = $depart_routes[count($depart_routes)-1]['MonthTo']; // first route month-to
						
					$flight_depart['Airlines'] = $depart_routes[0]['Airlines'];
					$flight_depart['FlightCode'] = $depart_routes[0]['FlightCode'];
						
					$flight_depart['Stop'] = count($depart_routes) - 1;
					$flight_depart['StopTxt'] = $flight_depart['Stop'] == 0 ? lang('direct') : $flight_depart['Stop'].' '.lang('stop');
					$flight_depart['RouteInfo'] = $depart_routes;
						
					$flight['flight_depart'] = $flight_depart;
						
						
					// set information of depart flightss
					$return_routes = get_inter_flight_routes($flight['RouteInfo'], FLIGHT_TYPE_RETURN);
						
					if(count($return_routes) > 0){
							
						$flight_return['TimeFrom'] = $return_routes[0]['TimeFrom']; // first route time-from
						$flight_return['DayFrom'] = $return_routes[0]['DayFrom']; // first route day-from
						$flight_return['MonthFrom'] = $return_routes[0]['MonthFrom']; // first route month-from
	
						$flight_return['TimeTo'] =  $return_routes[count($return_routes)-1]['TimeTo']; // last rout time-to
						$flight_return['DayTo'] = $return_routes[count($return_routes)-1]['DayTo']; // first route day-to
						$flight_return['MonthTo'] = $return_routes[count($return_routes)-1]['MonthTo']; // first route month-to
	
						$flight_return['Airlines'] = $return_routes[0]['Airlines'];
						$flight_return['FlightCode'] = $return_routes[0]['FlightCode'];
	
						$flight_return['Stop'] = count($return_routes) - 1;
						$flight_return['StopTxt'] = $flight_return['Stop'] == 0 ? lang('direct') : $flight_return['Stop'].' '.lang('stop');
						$flight_return['RouteInfo'] = $return_routes;
							
						$flight['flight_return'] = $flight_return;
							
					}
						
					$flight['Airlines'] = get_airline_codes_of_flight($flight['RouteInfo']);
						
					$fare = $flight['PriceInfo'][0]['ADT_Fare'];
					$from_code = $search_criteria['From_Code'];
					$to_code = $search_criteria['To_Code'];
						
					$flight['PriceFrom'] = calculate_discount_fare($flight['Airlines'], $from_code, $to_code, $fare);
						
					if($fare != $flight['PriceFrom']){
							
						$flight['PriceOrigin'] = $fare;
	
						$adt = $search_criteria['ADT'];
						$chd = $search_criteria['CHD'];
						$inf = $search_criteria['INF'];
	
						$total_fare = $flight['PriceInfo'][0]['ADT_Fare'] * $adt + $flight['PriceInfo'][0]['CHD_Fare'] * $chd + $flight['PriceInfo'][0]['INF_Fare'] * $inf;
	
						$total_discount = $total_fare - calculate_discount_fare($flight['Airlines'], $from_code, $to_code, $total_fare);
	
						$total_discount = bpv_format_currency($total_discount, false);
	
						$flight['DiscountNote'] = lang_arg('fare_discount', $total_discount, ($adt + $chd + $inf));
					}
	
					$ret[] = $flight;
	
				}
	
			}
		}
	
		if(count($ret) > 0){
			usort($ret, array($this, 'sort_price_inter_asc'));
		}
	
		return $ret;
	}
	
	function sort_price_inter_asc($f1, $f2){
		if($f1['PriceFrom'] == $f2['PriceFrom']) {
			return ($f1['FlightCode'] < $f2['FlightCode']) ? -1: 1;
		}
		return ($f1['PriceFrom'] < $f2['PriceFrom']) ? -1: 1;
	}
	
	function sort_price_asc($f1, $f2){
		if($f1['PriceInfo'][0]['ADT_Fare'] == $f2['PriceInfo'][0]['ADT_Fare']) {
			return ($f1['FlightCode'] < $f2['FlightCode']) ? -1: 1;
		}
		return ($f1['PriceInfo'][0]['ADT_Fare'] < $f2['PriceInfo'][0]['ADT_Fare']) ? -1: 1;
	}
	
	
	/**
	 * Get flight detail of domistic flight
	 * Call to VNISC to get flight detail (VNISC call to the airlines)
	 */
	function get_flight_detail(){
		$is_mobile = is_mobile();
	
		$mobile_view = $is_mobile ? 'mobile/' : '';
	
		/*
		 * Paramters Posted from Ajax function
		 */
		$sid = $this->input->post('sid');
	
		$flight_id = $this->input->post('flight_id');
	
		$flight_class = $this->input->post('flight_class');
	
		$flight_stop = $this->input->post('flight_stop');
	
		$flight_type = $this->input->post('flight_type');
	
		// get search criteria from session
		$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
		
		$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);
	
		if(empty($search_criteria) || empty($vnisc_sid)){ // fail to get information from the session
				
			echo '';
				
		} else {
	
			$is_domistic = $search_criteria['is_domistic'];
				
			$flight_detail_url = get_flight_detail_url($vnisc_sid, $flight_id, $flight_class, $flight_type, $is_domistic);
			
			$flight_detail = get_flight_detail($flight_detail_url);
			
			if($flight_detail != ''){
					
				$flight_detail_info = get_flight_detail_info($flight_detail, $is_domistic, $flight_stop, $search_criteria);
			
				$this->load->view($mobile_view.'flights/flight_search/flight_detail', $flight_detail_info);
				
					
			} else {
	
				echo '';
	
			}
				
				
		}
	
	}
	
	/**
	 * Get flight detail of internaltional flight
	 * Get the flight detail from the session
	 */
	function get_flight_detail_inter(){
	
		$is_mobile = is_mobile();
	
		$mobile_view = $is_mobile ? 'mobile/' : '';
	
		/*
			* Paramters Posted from Ajax function
			*/
		$sid = $this->input->post('sid');
	
		$flight_id = $this->input->post('flight_id');
	
		$flight_data = get_flight_session_data($sid, FLIGHT_SEARCH_DATA);
	
		$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
	
		$selected_flight = '';
	
		if($flight_data != '' && $search_criteria !=''){
	
			foreach ($flight_data as $flight){
	
				if($flight['Seg'] == $flight_id){
						
					$selected_flight = $flight;
						
					break;
				}
	
			}
	
		}
	
		if($selected_flight != ''){
				
			$selected_flight['depart_routes'] = get_inter_flight_routes($selected_flight['RouteInfo'], FLIGHT_TYPE_DEPART);
				
			$selected_flight['return_routes'] = get_inter_flight_routes($selected_flight['RouteInfo'], FLIGHT_TYPE_RETURN);
				
			$prices = get_flight_prices_inter($selected_flight, $search_criteria);
				
			$data['flight'] = $selected_flight;
			$data['search_criteria'] = $search_criteria;
			$data['prices'] = $prices;
				
			$this->load->view($mobile_view.'flights/flight_search/flight_detail_inter', $data);
				
		} else {
			echo '';
		}
	
	}

	function _load_filter_data($data, $is_mobile = false){
	
		$mobile_view = $is_mobile ? 'mobile/' : '';
	
		$data['departure_times'] = $this->config->item('departure_times');
	
		$data['flight_search_filters'] = $this->load->view($mobile_view.'flights/flight_search/search_filters', $data, TRUE);
	
		return $data;
	}
	
	function _load_flight_sort_by($data, $is_mobile){
		
		$mobile_view = $is_mobile ? 'mobile/' : '';

		$view_data['sort_by'] = $data['sort_by'];
	
		$data['sort_by_view'] = $this->load->view($mobile_view.'flights/search/search_sorts', $view_data, TRUE);
		
		return $data;
	}
	
	
	/**
	 * Flight Bay
	 * @param unknown $id
	 */
	function flight_airline($id){
	
		$data = $this->_set_common_data();
	
		// get flight destination data
		$data['airline'] = $this->Flight_Model->get_airline($id);
	
		if($data['airline'] === FALSE){
			redirect(get_url(FLIGHT_HOME_PAGE));
			exit();
		}
	
		$data['meta'] = get_header_meta(FLIGHT_AIRLINE_PAGE, $data['airline']);
	
		// Set data
		$data = build_search_criteria($data, MODULE_FLIGHT_DESTINATION);
	
	
		// Footer flight links
		$data = load_footer_links($data);
	
		// Render view
		$data['search_dialog'] = $this->load->view('flights/flight_search/flight_search_dialog', $data, TRUE);
	
		$data['bpv_register'] = $this->load->view('common/bpv_register', $data, TRUE);
	
		_render_view('flights/flight_category/flight_airline', $data);
	
	}
	

	function get_lasted_flight_search(){
		
		$lasted_search = $this->session->userdata(FLIGHT_SEARCH_CRITERIA);
	
		echo json_encode($lasted_search);
	}
	
	
}

?>