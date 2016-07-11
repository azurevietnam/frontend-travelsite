<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Home extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
		
       	$this->load->model(array('Destination_Model','Tour_Model', 'Cruise_Model', 'HotelModel'));
       	
       	$this->load->language(array('home', 'tour'));
       	
       	$this->load->helper(array('basic','flight', 'resource', 'tour_search', 'hotel_search','flight_search','advertise','tour','cruise'));

       	$this->load->config('cruise_meta');
       	$this->load->config('tour_meta');
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index()
    {	
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();
    	
    	// set cache html
    	set_cache_html();
    	
    	// set current menu
    	set_current_menu(MNU_HOME);
    	
    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(HOME_PAGE);
    	 
    	$data['page_theme'] = get_page_theme(HOME_PAGE, $is_mobile);
    	 
    	$destination = $this->Destination_Model->get_destination_4_tour('Vietnam');
    	
    	//$data = get_page_navigation($data, $is_mobile, HOME_PAGE);
    	
    	//$data['dest'] = $this->_load_best_seller($data, $is_mobile, $destination);
    	
    	// load search-forms
    	if($is_mobile) {
    	    $data = load_tour_search_form($data, $is_mobile, array(), VIEW_PAGE_HOME, true);
    	} else {
    	    $data = load_multiple_search_forms($data, $is_mobile, VIEW_PAGE_HOME);
    	}
    	
      	$data['page'] = HOME_PAGE;
      	
    	$data = load_common_advertises($data, $is_mobile, AD_PAGE_HOME, AD_AREA_DEFAULT);
    	
    	// load home advertises
    	$data = load_home_advertises($data, $is_mobile, AD_PAGE_HOME, AD_AREA_2);
    	
    	//load best seller
    	$data = $this->_load_best_seller($data, $is_mobile, $destination);
    	
    	// load sale support view
    	$data = $this->_load_sale_support($data, $is_mobile);
    	
    	$data = load_indochina_countries($data, $is_mobile, HOME_PAGE);
    	
    	// load popular service links
    	$data = load_popular_service_links($data, $is_mobile, true, true, true, true);

        render_view('home/home', $data, $is_mobile);
    }
    
    /**
     * Load the sale support view
     * 
     * @author Khuyenpv
     * @since 09.04.2015
     */
    public function _load_sale_support($data, $is_mobile){
    	
    	// call model to get data
    	// $view_data['db_data'] = $db_data;
    	
    	$data['sale_support'] = load_view('home/sale_support', array(), $is_mobile);
    	
    	return $data;
    }
    
    /**
     * Load the Footer Links
     * 
     * @author Khuyenpv
     * @since 09.04.2015
     */
    public function _load_popular_service_links($data, $is_mobile){
    	
    	// Get top destinations
    	$view_data['top_tour_des'] = $this->Destination_Model->get_top_destinations('is_top_tour');
    	
    	$view_data['top_hotel_des'] = $this->Destination_Model->get_top_destinations('is_top_hotel');
    	
    	// Get popular cruises
    	$view_data['halongcruises'] = $this->Cruise_Model->get_popular_cruises('0');
    	
    	$view_data['mekongcruises'] = $this->Cruise_Model->get_popular_cruises('1');
    	
    	$data['popular_service_links'] = load_view('home/popular_service_links',$view_data, $is_mobile);
    	
    	return $data;
    }
    
    function _load_best_seller($data, $is_mobile, $destination){

    	$view_data['tour']= $this->Tour_Model->get_most_recommended_tour_in_des($destination['id'], 2);
    	
    	$view_data['cruise_halong'] = $this->Tour_Model->get_most_recommended_tour_in_des(HALONG_BAY,2);
    	
    	$view_data['cruise_mekong'] = $this->Tour_Model->get_most_recommended_tour_in_des(MEKONG_RIVER,2);

    	$data['best_seller'] = load_view('home/best_seller', $view_data, $is_mobile);
    	
    	return $data;
    }
    
    function getcart()
    {
    	$is_mobile = is_mobile();
    	if($is_mobile){
    		echo get_cart_item_icon();
    	}else {
    		echo get_my_cart_text();
    	}
    }
}
?>