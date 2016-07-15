<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author toanlk
  *  @since  Oct 29, 2014
  */
class Home extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
		
		$this->load->model(array('TourModel', 'HotelModel', 'BestDealModel'));
		$this->load->language(array('home','hotel','mybooking'));	
		$this->load->helper(array('form','tour', 'text', 'email', 'booking'));

		$this->load->driver('cache', array('adapter' => 'file'));
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index()
    {
        $this->output->cache($this->config->item('cache_html'));
        
        $this->session->set_userdata('MENU', MNU_HOME);
        
        $data['metas'] = site_metas('home');
        $data['navigation'] = '';
        
        // home page flag
        $data['flag_home_page'] = 1;
        
        $data['big_search_form'] = 1;
        
        // load hotel search form
        $data = $this->get_hotel_search_form($data);
        // load search block
        $data = buildTourSearchCriteria($data);
        
        // set data for header, navigation, main of this view
        $data['inc_css'] = get_static_resources('home.min.03022015.css');
        
        // Get top destinations
        $data['top_tour_des'] = $this->TourModel->getTopDestinations();
        
        $data['top_hotel_des'] = $this->HotelModel->getHotelTopDestinations();
        
        // Get popular cruises
        $data['halongcruises'] = $this->TourModel->get_popular_cruises('0');
        
        $data['mekongcruises'] = $this->TourModel->get_popular_cruises('1');
        
        // Get hotel deals
        $data['hanoi_hotel_deals'] = $this->HotelModel->get_hotels_by_hot_deals('30');
        
        $data['hcm_hotel_deals'] = $this->HotelModel->get_hotels_by_hot_deals('14');
        
        // Get cruise deals
        $data = $this->load_cruise_deals($data);
        
        // Get tour deals
        $data['indochina_des'] = $this->TourModel->getTopParentDestinations();
        
        // Render view
        $data['main'] = $this->load->view('home/home_new_design', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function get_hotel_search_form($data)
    {
        $data = load_hotel_search_autocomplete($data);
        
        $data['hotel_stars'] = $this->HotelModel->hotel_stars;
        $data['hotel_nights'] = $this->HotelModel->hotel_nights;
        
        $search_criteria = buildHotelSearchCriteria();
        
        $data['search_criteria'] = $search_criteria;
        
        $data['hotel_search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
        
        return $data;
    }

    function loadTopDestination($data)
    {
        $CI = & get_instance();
        
        $cache_time = $CI->config->item('cache_day');
        
        $CI->load->driver('cache', array(
            'adapter' => 'file'
        ));
        
        if (! $home_top_destinations_view = $CI->cache->get('home_top_destinations'))
        {
            $data['dess'] = $CI->TourModel->getTopDestinations();
            
            $home_top_destinations_view = $CI->load->view('home/home_top_destinations', $data, TRUE);
            
            // Save into the cache for 5 minutes
            $CI->cache->save('home_top_destinations', $home_top_destinations_view, $cache_time);
        }
        
        $data['home_top_destinations'] = $home_top_destinations_view;
        
        return $data;
    }

    function load_cruise_deals($data)
    {
        $search_criteria = $data['search_criteria'];
        
        $departure_date = date('Y-m-d', strtotime($search_criteria['departure_date']));
        
        $halong_cruise_deals = $this->TourModel->get_tours_by_hot_deals('0', $departure_date);
        
        $mekong_cruise_deals = $this->TourModel->get_tours_by_hot_deals('1', $departure_date);
        
        $data['halong_cruise_deals'] = $halong_cruise_deals;
        
        $data['mekong_cruise_deals'] = $mekong_cruise_deals;
        
        return $data;
    }

    function getcart()
    {
        echo get_my_cart_text();
    }

    function getmobilelink()
    {
        if (is_show_mobile_link())
        {
            
            $ret = '<li><a title="'.lang('label_view_mobile_version').'" href="' . get_mobile_url(true) . '">'.lang('label_mobile_version').'</a></li>';
            echo $ret;
        }
        else
        {
            echo "";
        }
    }
}
?>