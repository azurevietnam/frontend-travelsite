<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Flights extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();
       	
		$this->load->language(array('tour', 'flight'));
			
		$this->load->model(array('Flight_Model','Destination_Model'));
		
		$this->load->helper(array('basic', 'tour', 'resource', 'flight', 'flight_search','advertise'));
		
		//$this->config->load('flight_meta');
			
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		// check if the current device is Mobile or Not
		$is_mobile = is_mobile();
		 
		// set cache html
		set_cache_html();
		 
		// set current menu
		set_current_menu(MNU_FLIGHTS);
		 
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(VN_FLIGHT_PAGE);
		 //page_meta
		$data['page_theme'] = get_page_theme(VN_FLIGHT_PAGE, $is_mobile);
		 
		$data = get_page_main_header_title($data, $is_mobile, VN_FLIGHT_PAGE);
		 
		$data = get_page_navigation($data, $is_mobile, VN_FLIGHT_PAGE);

		// load common advertise
		$data = load_common_advertises($data, $is_mobile, AD_PAGE_VIETNAM_FLIGHT, AD_AREA_DEFAULT);
		
		$search_criteria = get_flight_search_criteria();
		
		// load left componets
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
		$data = load_flight_search_form($data, $is_mobile, $search_criteria, $display_mode_form);
		
		$data = load_why_use($data, $is_mobile);

		$data = load_tripadvisor($data, $is_mobile);
		
		// load top tour destinations
		$data = load_top_tour_destinations($data, $is_mobile);
		
		$data = $this->_load_popular_flights($data, $is_mobile);

		// load footer components
		$data = load_flight_destination_links($data, $is_mobile);
		
		
		render_view('flights/home/flight_home', $data, $is_mobile);
	}
	
	/**
	 * Load the flight to destination
	 *
	 * @author Huutd
	 * @since 27.05.2015
	 */
	function flight_to_destination($url_title) {
		
		// check if the current device is Mobile or Not
		$is_mobile = is_mobile();
			
		// set cache html
		set_cache_html();
			
		// set current menu
		set_current_menu(MNU_FLIGHTS);
			
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(VN_FLIGHT_PAGE);
		//page_meta
		$data['page_theme'] = get_page_theme(FLIGHT_DESTINATION_PAGE, $is_mobile);
			
		$data = get_page_main_header_title($data, $is_mobile, VN_FLIGHT_PAGE);
			
		$data = get_page_navigation($data, $is_mobile, VN_FLIGHT_PAGE);


		$des = $this->Destination_Model->get_destination_flight_info($url_title);
		
		if (empty($des)) {
			redirect(get_page_url(VN_FLIGHT_PAGE));
		}
		
		$data['destination'] = $des;
		
		// load common advertise
		$data = load_common_advertises($data, $is_mobile, AD_PAGE_FLIGHT_BY_DESTINATION, AD_AREA_DEFAULT);
		
		$search_criteria = get_flight_search_criteria();
		
		// load left componets
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
		$data = load_flight_search_form($data, $is_mobile, $search_criteria, $display_mode_form);
					
		$data = load_why_use($data, $is_mobile);

		$data = load_tripadvisor($data, $is_mobile);
		
		$data['search_criteria'] = $search_criteria;
		
		$data = $this->_load_popular_flights($data, $is_mobile, $des['id']);
		
		$data = $this->_load_flight_tips($data, $is_mobile);
		
		$data = $this->_load_some_tips_for_travel($data, $is_mobile);
		
		// load footer components
		$data = load_flight_destination_links($data, $is_mobile);		
		
		render_view('flights/flight_destination/flight_to_destination', $data, $is_mobile);
	}
	
	/**
	 * Load the popular flight
	 *
	 * @author Huutd
	 * @since 27.05.2015
	 */
	
	function _load_popular_flights($data, $is_mobile, $des_id=''){
		
		if($is_mobile) return $data;
		
		$search_criteria = get_flight_search_criteria();
		
		if(empty($des_id)){
			$view_data['popular_routes'] = $this->Flight_Model->get_popular_fights();
		}else{
			$view_data['popular_routes'] = $this->Flight_Model->get_flights_of_destiantion($des_id);
		}		
		
		$view_data['flight_routes'] = $this->Flight_Model->get_all_flight_routes();

		$datepicker_depart_popup = array();
		
		$datepicker_depart_popup['day_id'] = 'pop_departure_day_flight';
		$datepicker_depart_popup['month_id'] = 'pop_departure_month_flight';
		$datepicker_depart_popup['date_id'] = 'pop_departure_date_flight';
		$datepicker_depart_popup['date_name'] = 'Depart';
		$datepicker_depart_popup['css'] ='col-xs-5';
		$datepicker_depart_popup['loading_asyn'] = true;
		
		if(!empty($search_criteria['Depart'])){
			$datepicker_depart_popup['departure_date'] = $search_criteria['Depart'];
		}
		
		$view_data['datepicker_depart_popup'] = load_datepicker($is_mobile, $datepicker_depart_popup);
		
		$datepicker_return_popup = array();
		
		$datepicker_return_popup['day_id'] = 'pop_returning_day_flight';
		$datepicker_return_popup['month_id'] = 'pop_returning_month_flight';
		$datepicker_return_popup['date_id'] = 'pop_returning_date_flight';
		$datepicker_return_popup['date_name'] = 'Return';
		$datepicker_return_popup['css'] = 'col-xs-5';
		$datepicker_return_popup['loading_asyn'] = true;
		
		if(!empty($search_criteria['Return'])){
		
			$datepicker_return_popup['departure_date'] = $search_criteria['Return'];
		}
		
		
		$view_data['datepicker_return_popup'] = load_datepicker($is_mobile, $datepicker_return_popup);
		
		$view_data['search_criteria'] = $search_criteria;
		
		$view_data['search_form_popup'] = load_view('flights/search/search_form_popup', $view_data, $is_mobile);
	
		$data['popular_flights'] = load_view('flights/home/popular_flights', $view_data, $is_mobile);
	
		return $data;
	}
	
	/**
	 * Load some tips flight to destination
	 *
	 * @author Huutd
	 * @since 27.05.2015
	 */
	
	function _load_some_tips_for_travel($data, $is_mobile){
			
		$data['some_tips_for_travel'] = load_view('flights/common/some_tips_for_travel', $data, $is_mobile);
	
		return $data;
	}
	
	function _load_flight_tips($data, $is_mobile){
		
		$data['flight_tips'] = load_view('flights/common/flight_tips', $data, $is_mobile);
		
		return $data;
	}
	/*
	function _load_flight_autocomplete_combobox($data, $is_mobile){
	
		$data['autocomplete_cb'] = load_view('common/booking/autocomplete_cb', $data, $is_mobile);
	
		return $data;
	}*/
	
}

?>