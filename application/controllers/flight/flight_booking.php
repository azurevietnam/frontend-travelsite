<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flight_Booking extends CI_Controller {

	public function __construct()
	{

		parent::__construct();

		$this->load->language('flight');

		$this->load->model(array('Flight_Model', 'Destination_Model'));

		$this->load->helper(array('basic', 'resource', 'booking', 'flight', 'flight_search','advertise','contact'));

		$this->config->load('flight_meta');
			
		//$this->output->enable_profiler(TRUE);
	}

	function index(){
		// check if the current device is Mobile or Not
		$is_mobile = is_mobile();
			
		// set current menu
		set_current_menu(MNU_FLIGHTS);
			
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(FLIGHT_PASSENGER_PAGE);
		
		$data['page_theme'] = get_page_theme(FLIGHT_PASSENGER_PAGE, $is_mobile);
			
		$data = get_page_navigation($data, $is_mobile, FLIGHT_PASSENGER_PAGE);
		
		// get $sid from the link
		$sid = $this->input->get('sid');
		
		// get search-criteria in the session
		$search_criteria = get_flight_session_data($sid, FLIGHT_SEARCH_CRITERIA);
		
		$data['search_criteria'] = $search_criteria;
		
		// get vnisc-id from the session
		$vnisc_sid = get_flight_session_data($sid, FLIGHT_VNISC_SID);
		
		// check if fail to get data from the session
		if($search_criteria == '' || $vnisc_sid == ''){
				
			log_message('error', '[ERROR]flight_detail(): Fail to get Search Criteria or VNISC-ID from the Session');
				
			redirect(get_page_url(VN_FLIGHT_PAGE));exit();
		}
		
		// get the flight-booking of the flight
		$flight_booking = get_flight_booking($sid, $vnisc_sid, $search_criteria);
		
		// if empty result -> redirect to Flight Home Page
		if (empty($flight_booking)){
		
			redirect(get_page_url(FLIGHT_HOME_PAGE));exit();
		}
		
		// save the flight-booking into the session
		set_flight_session_data($sid, FLIGHT_BOOKING_INFO, $flight_booking);
				
		$data = load_booking_step($data, $is_mobile, 2);
		
		$data['flight_booking'] = $flight_booking;
		
		//print_r($search_criteria); exit();
		
		if($search_criteria['is_domistic']){
			$data = load_flight_itinerary($data, $is_mobile, $search_criteria);
			//$data['flight_itinerary'] = $this->load->view($mobile_view.'flights/flight_booking/flight_itinerary', $data, TRUE);
		} else {
			
			$data = load_flight_itinerary_inter($data, $is_mobile, $search_criteria);
			//$data['flight_itinerary'] = $this->load->view($mobile_view.'flights/flight_booking/flight_itinerary_inter', $data, TRUE);
			
		}
		
		$data = load_flight_passenger($data, $is_mobile, $search_criteria);
		
		$data = load_flight_baggage_fees($data, $is_mobile, $search_criteria);
		
		$data = load_flight_summary($data, $is_mobile, $search_criteria);
		
		$action = $this->input->post('action');
		
		if($action == ACTION_NEXT || $action=='change-passenger'){
		
			redirect(get_page_url(FLIGHT_PAYMENT_PAGE.'?sid='.$sid));exit();
		
		}
		
		render_view('flights/flight_booking/flight_booking', $data, $is_mobile);
	}
}
?>