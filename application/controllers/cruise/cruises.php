<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Cruises extends CI_Controller
{

	public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('tour_search','cruise','hotline','destination','faq','tour','review','text','recommend', 'advertise'));

        $this->load->config('cruise_meta');

        $this->load->language(array('tour','cruise'));

        $this->load->model(array('Cruise_Model','Destination_Model','Tour_Model'));

        // for test only
        //$this->output->enable_profiler(TRUE);
    }

	function halongbaycruises()
    {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, HALONG_CRUISE_PAGE, AD_PAGE_HALONG_BAY_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        // load cruise deals
        $tours = $this->Cruise_Model->get_cruise_deals(0);

        if($is_mobile) {
            
            $deal_data['tours'] = $tours;
            
            $mobile_folder = $is_mobile ? 'mobile/' : '';
            
            $data['today_hot_deal'] = $this->load->view($mobile_folder.'cruises/common/today_hot_deal', $deal_data, TRUE);
            
        } else {
            $today_hot_deal = ! empty($tours) ? $tours[0] : ''; // the first tour in the list cruise deals
            
            $data = load_today_hot_cruise_deal($data, $is_mobile, $today_hot_deal);
            
            if (! empty($tours))
            {
                array_shift($tours);
            }
            
            $data = load_top_cruise_deals($data, $is_mobile, $tours, HALONG_CRUISE_PAGE);
        }

        // load most recommend cruises
        $data = $this->_load_most_recommended_cruises($data, $is_mobile, HALONG_CRUISE_PAGE);

        render_view('cruises/home/cruise_home', $data, $is_mobile);
    }

    function luxuryhalongcruises(){

    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();
    	
    	$data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, LUXURY_HALONG_CRUISE_PAGE, AD_PAGE_LUXURY_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

    	$cruise_stars = array(5,4.5); // 5 & 4.5 is luxury cruise

    	$cruises = $this->Cruise_Model->get_most_recommended_cruises(LUXURY_HALONG_CRUISE_PAGE, 10);
    	
    	// show more cruises
    	$data['page'] = LUXURY_HALONG_CRUISE_PAGE;
    	
    	$data['page_title'] = lang('luxuryhalongcruises');

    	// is show more
    	$data = $this->is_show_more($cruises, LUXURY_HALONG_CRUISE_PAGE, $data);
    	
    	$data = load_list_cruises($data, $is_mobile, $cruises);

    	$data['recommended_title'] = lang('recommended') .' '. lang('luxuryhalongcruises');

    	render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function deluxehalongcruises(){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, DELUXE_HALONG_CRUISE_PAGE, AD_PAGE_MID_RANGE_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        $cruise_stars = array(4,3.5); // 4 & 3.5 is deluxe cruise

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, $cruise_stars);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(DELUXE_HALONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = DELUXE_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('deluxehalongcruises');
        
        // is show more
        $data = $this->is_show_more($cruises, DELUXE_HALONG_CRUISE_PAGE, $data);

        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('deluxehalongcruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function cheaphalongcruises() {

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, CHEAP_HALONG_CRUISE_PAGE,AD_PAGE_BUDGET_HALONG_CRUISE ,$is_mobile, HALONG_BAY_URL_TITLE);

        $cruise_stars = array(3,2.5); // 3 & 2.5 is cheap cruise

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, $cruise_stars);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(CHEAP_HALONG_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = CHEAP_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('cheaphalongcruises');
        
        // is show more
        $data = $this->is_show_more($cruises, CHEAP_HALONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('cheaphalongcruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function charterhalongcruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, CHARTER_HALONG_CRUISE_PAGE, AD_PAGE_PRIVATE_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        $cruise_types = array(2); // 2 mean private
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(CHARTER_HALONG_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = CHARTER_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('privatehalongcruises');
        
        // is show more
        $data = $this->is_show_more($cruises, CHARTER_HALONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('privatehalongcruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halongbaydaycruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, DAY_HALONG_CRUISE_PAGE,AD_PAGE_HALONG_BAY_DAY_CRUISES , $is_mobile, HALONG_BAY_URL_TITLE);

        $cruise_types = array(3); // 3 mean day cruises

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(DAY_HALONG_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = DAY_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('halongbaydaycruises');
        
        // is show more
        $data = $this->is_show_more($cruises, DAY_HALONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('halongbaydaycruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halongfamilycruises() {

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, FAMILY_HALONG_CRUISE_PAGE, AD_PAGE_HALONG_FAMILY_CRUISES, $is_mobile, HALONG_BAY_URL_TITLE);

        $cruise_types = array(4); // 4 mean family cruises

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(FAMILY_HALONG_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = FAMILY_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('familyhalongcruises');
        
        // is show more
        $data = $this->is_show_more($cruises, FAMILY_HALONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('familyhalongcruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halonghoneymooncruises() {

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, HONEY_MOON_HALONG_CRUISE_PAGE, AD_PAGE_HALONGBAY_HONEYMOON_CRUISES, $is_mobile, HALONG_BAY_URL_TITLE);

       	$cruise_types = array(5); // 5 mean honey moon

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(HONEY_MOON_HALONG_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = HONEY_MOON_HALONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('honeymoonhalongcruises');
        
        // is show more
        $data = $this->is_show_more($cruises, HONEY_MOON_HALONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('honeymoonhalongcruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halongbigsizecruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, HALONG_BAY_BIG_SIZE_CRUISE_PAGE, AD_PAGE_BIG_SIZE_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(HALONG_BAY_BIG_SIZE_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = HALONG_BAY_BIG_SIZE_CRUISE_PAGE;
        
        $data['page_title'] = lang('halongbigsizecruises');
        
        // is show more
        $data = $this->is_show_more($cruises, HALONG_BAY_BIG_SIZE_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('halongbigsizecruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halongmediumsizecruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE, AD_PAGE_MEDIUM_SIZE_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE;
        
        $data['page_title'] = lang('halongmediumsizecruises');
        
        // is show more
        $data = $this->is_show_more($cruises, HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('halongmediumsizecruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function halongsmallsizecruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_HALONG_CRUISES, HALONG_BAY_SMALL_SIZE_CRUISE_PAGE, AD_PAGE_SMALL_SIZE_HALONG_CRUISE, $is_mobile, HALONG_BAY_URL_TITLE);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(HALONG_BAY_SMALL_SIZE_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = HALONG_BAY_SMALL_SIZE_CRUISE_PAGE;
        
        $data['page_title'] = lang('halongsmallsizecruises');
        
        // is show more
        $data = $this->is_show_more($cruises, HALONG_BAY_SMALL_SIZE_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('halongsmallsizecruises');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function mekongrivercruises()
    {
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	$data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, MEKONG_CRUISE_PAGE, AD_PAGE_MEKONG_RIVER_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

    	// load cruise deals
    	$tours = $this->Cruise_Model->get_cruise_deals(1);
    	
    	if($is_mobile) {
    	
    	    $deal_data['tours'] = $tours;
    	
    	    $mobile_folder = $is_mobile ? 'mobile/' : '';
    	
    	    $data['today_hot_deal'] = $this->load->view($mobile_folder.'cruises/common/today_hot_deal', $deal_data, TRUE);
    	
    	} else {
    	    $today_hot_deal = !empty($tours) ? $tours[0] : ''; // the first tour in the list cruise deals
    	    
    	    // load today hot cruise deal
    	    $data = load_today_hot_cruise_deal($data, $is_mobile, $today_hot_deal);
    	    
    	    if (! empty($tours))
    	    {
    	        array_shift($tours); // remove the first deal
    	    }
    	    
    	    // load top cruise deal
    	    $data = load_top_cruise_deals($data, $is_mobile, $tours, MEKONG_CRUISE_PAGE);
    	}

    	// load most recommend cruises
    	$data = $this->_load_most_recommended_cruises($data, $is_mobile, MEKONG_CRUISE_PAGE);

    	render_view('cruises/home/cruise_home', $data, $is_mobile);
    }

    function vietnamcambodiacruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, VIETNAM_CAMBODIA_CRUISE_PAGE, AD_PAGE_VIETNAM_CAMBODIA_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

        $cruise_types = array(6);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(VIETNAM_CAMBODIA_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = VIETNAM_CAMBODIA_CRUISE_PAGE;
        
        $data['page_title'] = lang('mekongcruisesvietnamcambodia');
        
        // is show more
        $data = $this->is_show_more($cruises, VIETNAM_CAMBODIA_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('mekongcruisesvietnamcambodia');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function vietnamcruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, VIETNAM_CRUISE_PAGE,AD_PAGE_VIETNAM_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

        $cruise_types = array(7);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(VIETNAM_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = VIETNAM_CRUISE_PAGE;
        
        $data['page_title'] = lang('mekongcruisesvietnam');
        
        // is show more
        $data = $this->is_show_more($cruises, VIETNAM_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('mekongcruisesvietnam');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function laoscruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, LAOS_CRUISE_PAGE,AD_PAGE_LAOS_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

        $cruise_types = array(8);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(LAOS_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = LAOS_CRUISE_PAGE;
        
        $data['page_title'] = lang('mekongcruiseslaos');
        
        // is show more
        $data = $this->is_show_more($cruises, LAOS_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('mekongcruiseslaos');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function thailandcruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, THAILAND_CRUISE_PAGE,AD_PAGE_THAILAN_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

        $cruise_types = array(9);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(THAILAND_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = THAILAND_CRUISE_PAGE;
        
        $data['page_title'] = lang('mekongcruisesthailand');
        
        // is show more
        $data = $this->is_show_more($cruises, THAILAND_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('mekongcruisesthailand');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    function burmacruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, BURMA_CRUISE_PAGE,AD_PAGE_BURMA_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);

       	$cruise_types = array(10);

        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(0, array(), $cruise_types);

        $data = load_top_cruise_deals($data, $is_mobile, $tours); */

        $cruises = $this->Cruise_Model->get_most_recommended_cruises(BURMA_CRUISE_PAGE, 10);

        // show more cruises
        $data['page'] = BURMA_CRUISE_PAGE;
        
        $data['page_title'] = lang('mekongcruisesburma');
        
        // is show more
        $data = $this->is_show_more($cruises, BURMA_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);

        $data['recommended_title'] = lang('recommended') .' '. lang('mekongcruisesburma');

        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }
    
    function luxurymekongcruises() {
        
        $is_mobile = is_mobile();
        
        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, LUXURY_MEKONG_CRUISE_PAGE,AD_PAGE_LUXURY_MEKONG_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);
        
        $cruise_stars = array(5,4.5); // 5 & 4.5 is luxury cruise
        
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(1, $cruise_stars);
        
        $data = load_top_cruise_deals($data, $is_mobile, $tours); */
        
        $cruises = $this->Cruise_Model->get_most_recommended_cruises(LUXURY_MEKONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = LUXURY_MEKONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('label_luxury_mekong_cruises');
        
        // is show more
        $data = $this->is_show_more($cruises, LUXURY_MEKONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);
        
        $data['recommended_title'] = lang('recommended') .' '. lang('label_luxury_mekong_cruises');
        
        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }
    
    function deluxemekongcruises() {
        
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, DELUXE_MEKONG_CRUISE_PAGE, AD_PAGE_DELUXE_MEKONG_CRUISES, $is_mobile, MEKONG_RIVER_URL_TITLE);
        
        $cruise_stars = array(4,3.5); // 4 & 3.5 is deluxe cruise
        
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(1, $cruise_stars);
        
        $data = load_top_cruise_deals($data, $is_mobile, $tours); */
        
        $cruises = $this->Cruise_Model->get_most_recommended_cruises(DELUXE_MEKONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = DELUXE_MEKONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('label_deluxe_mekong_cruises');
        
        // is show more
        $data = $this->is_show_more($cruises, DELUXE_MEKONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);
        
        $data['recommended_title'] = lang('recommended') .' '. lang('label_deluxe_mekong_cruises');
        
        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }
    
    function cheapmekongcruises() {
    
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, CHEAP_MEKONG_CRUISE_PAGE,AD_PAGE_CHEAP_MEKONG_CRUISES, $is_mobile, MEKONG_RIVER_URL_TITLE);
        
        $cruise_stars = array(3,2.5); // 3 & 2.5 is cheap cruise
        
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(1, $cruise_stars);
        
        $data = load_top_cruise_deals($data, $is_mobile, $tours); */
        
        $cruises = $this->Cruise_Model->get_most_recommended_cruises(CHEAP_MEKONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = CHEAP_MEKONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('label_cheap_mekong_cruises');
        
        // is show more
        $data = $this->is_show_more($cruises, CHEAP_MEKONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);
        
        $data['recommended_title'] = lang('recommended') .' '. lang('label_cheap_mekong_cruises');
        
        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }
    
    function privatemekongcruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, PRIVATE_MEKONG_CRUISE_PAGE,AD_PAGE_PRIVATE_MEKONG_CRUISES, $is_mobile, MEKONG_RIVER_URL_TITLE);
        
        $cruise_types = array(2); // 2 mean private
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(1, array(), $cruise_types);
        
        $data = load_top_cruise_deals($data, $is_mobile, $tours); */
        
        $cruises = $this->Cruise_Model->get_most_recommended_cruises(PRIVATE_MEKONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = PRIVATE_MEKONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('label_private_mekong_cruises');
        
        // is show more
        $data = $this->is_show_more($cruises, PRIVATE_MEKONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);
        
        $data['recommended_title'] = lang('recommended') .' '. lang('label_private_mekong_cruises');
        
        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }
    
    function mekongriverdaycruises() {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        $data = $this->_load_common_cruise_data(MNU_MEKONG_CRUISES, DAY_MEKONG_CRUISE_PAGE, AD_PAGE_MEKONG_DAY_CRUISE, $is_mobile, MEKONG_RIVER_URL_TITLE);
        
        $cruise_types = array(3); // 3 mean day cruises
        
        // load cruise deals
        /* $tours = $this->Cruise_Model->get_cruise_deals(1, array(), $cruise_types);
        
        $data = load_top_cruise_deals($data, $is_mobile, $tours); */
        
        $cruises = $this->Cruise_Model->get_most_recommended_cruises(DAY_MEKONG_CRUISE_PAGE, 10);
        
        // show more cruises
        $data['page'] = DAY_MEKONG_CRUISE_PAGE;
        
        $data['page_title'] = lang('label_mekong_day_cruises');
        
        // is show more
        $data = $this->is_show_more($cruises, DAY_MEKONG_CRUISE_PAGE, $data);
        
        $data = load_list_cruises($data, $is_mobile, $cruises);
        
        $data['recommended_title'] = lang('recommended') .' '. lang('label_mekong_day_cruises');
        
        render_view('cruises/home/cruise_by_type', $data, $is_mobile);
    }

    /**
     * Khuyenpv Feb 25 2015
     * Load Cruises by each types
     */
    function _load_most_recommended_cruises($data, $is_mobile, $page){

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

    	$config_item_name = strpos($page, 'halong') !== FALSE ? 'halongcruise_categories' : 'mekongcruise_categories';

    	$cruise_types = $this->config->item($config_item_name);

    	$tmp_cruises = array();

    	$is_first = true;

    	foreach ($cruise_types as $key => $value)
        {
            $cruises = $this->Cruise_Model->get_most_recommended_cruises($value['type']);

            foreach ($cruises as $cruise){
            	$tmp_cruises[] = $cruise; // add to temporary array
            }

            $value['cruises'] = $cruises;

            $value['is_first'] = $is_first;

            $is_first = false;

            $cruise_types[$key] = $value;
        }

        // get promotion only 1 time
        $tmp_cruises = $this->Cruise_Model->get_cruise_special_offers($tmp_cruises);

        foreach ($cruise_types as $key => $value)
        {
        	if(!empty($value['cruises'])){

        		$cruises = $value['cruises'];

        		foreach ($cruises as $k=>$cruise){
        			foreach($tmp_cruises as $pro_c){
        				if($pro_c['id'] == $cruise['id']){
        					$pro = $pro_c['promotions'];


        					// show the only the first promotion available
        					$cruise['special_offers'] = empty($pro) ? '' : load_promotion_popup($is_mobile, $pro, TOUR, true);

        					break;
        				}
        			}

        			$cruises[$k] = $cruise;
        		}

        		$value = load_list_cruises($value, $is_mobile, $cruises, false);
        	} else {
        		$value = load_list_cruises($value, $is_mobile, array(), false);
        	}

        	unset($value['cruises']);

        	$cruise_types[$key] = $value;
        }

    	$data['cruise_types'] = $cruise_types;

    	// set recommended title
    	$recommended_title = strpos($page, 'halong') !== FALSE ? lang('halongbay_cruises') : lang('mekong_cruises');

    	$data['recommended_title'] = lang('recommended') .' '. $recommended_title;

    	$data['most_recommended_cruises'] = $this->load->view($mobile_folder.'cruises/home/most_recommended_cruises', $data, TRUE);

    	return $data;
    }

    /**
     * Khuyenpv Feb 25 2015
     * Load common cruise data for each page
     */
    function _load_common_cruise_data($mnu, $page, $ad_page, $is_mobile, $destination_url_title){

    	// set cache html
    	set_cache_html();

    	// set current menu
    	set_current_menu($mnu);

    	// load the destination
    	$destination = $this->Destination_Model->get_destination_4_tour($destination_url_title);
    	
    	$data['destination'] = $destination;

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta($page);

    	$data['page_theme'] = get_page_theme($page, $is_mobile);

    	$data = get_page_main_header_title($data, $is_mobile, $page);

    	$data = get_page_navigation($data, $is_mobile, $page);

		// load the tour search form	
		if($ad_page == AD_PAGE_HALONG_BAY_CRUISE || $ad_page == AD_PAGE_MEKONG_RIVER_CRUISE) {
			$show_type_tour =  TRUE;
		}else {
			$show_type_tour =  FALSE;
			$data = load_common_advertises($data, $is_mobile, $ad_page) ;
		}
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;

        $data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);
         	
    	$data = load_why_use($data, $is_mobile);

    	// load tripadvisor
    	$data = load_tripadvisor($data, $is_mobile);
    	
    	// load the cruise categories
    	if($page != HALONG_CRUISE_PAGE) {
    	    $data = load_cruise_categories($data, $is_mobile, $page);
    	}
    	
    	// load tour travel guide
    	$data = load_destination_travel_guide($data, $is_mobile, $destination);

    	// load faq
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HALONG_CRUISE_DETAIL);

    	// load all cruise links
    	$data = load_all_cruise_links($data, $is_mobile, $page);

    	// load rich snippet
    	$data = get_rich_snippet($data, $data['rich_snippet_header']['title'], $page);

    	$data = load_recommend_info_links($data, $is_mobile, $destination['id'], CRUISE);
    	
    	// load top tour destinations
    	$data = load_top_tour_destinations($data, $is_mobile);

    	return $data;
    }
    
    /**
      * is_show_more
      *
      * @author toanlk
      * @since  Jun 17, 2015
      */
    function is_show_more($cruises, $page, $data) {
        
        // check number of tours for show more button
        if(count($cruises) < 10) {
            $number_of_cruises = count($cruises);
        } else {
            $numb_cruises = $this->Cruise_Model->get_most_recommended_cruises($page, null, null);
            $number_of_cruises = count($numb_cruises);
        }
         
        $data['is_show_more'] = $number_of_cruises > count($cruises) ? true : false;
        
        return $data;
    }
}
?>
