<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Deals extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'tour', 'faq', 'resource', 'text', 'tour_search', 'hotel_search','flight','flight_search','cruise'));

        $this->load->model(array('Tour_Model', 'Hotel_Model', 'Cruise_Model'));

        $this->load->language('tour');

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
    	set_current_menu(MNU_DEAL_OFFER);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(DEAL_OFFER_PAGE);

    	$data['page_theme'] = get_page_theme(DEAL_OFFER_PAGE, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, DEAL_OFFER_PAGE);

        // load left block side
        $data = load_why_use($data, $is_mobile);

        $data = load_tripadvisor($data, $is_mobile);

        $data = load_top_tour_destinations($data, $is_mobile);

        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_DEAL_OFFER);

        // load main deals & offer
        $data = $this->load_deal_tabs($data, $is_mobile);

    	// load search-forms
    	$data = load_multiple_search_forms($data, $is_mobile, VIEW_PAGE_DEAL);

        render_view('deals/home/deal_home', $data, $is_mobile);
    }
    
    /**
     * Load the today-hotdeal-tab
     * @author Khuyenpv
     * @since 11.07.2015
     */
    function load_deal_tabs($data, $is_mobile){
    	
    	// load halong bay deals
    	$halong_deals = $this->Cruise_Model->get_cruise_deals(0, array(), array(), '');
    	
    	$tmp_data = load_top_cruise_deals(array(), $is_mobile, $halong_deals, null, false);
    	$view_data['halong_deals'] = $tmp_data['top_deals'];
    	
    	
    	$mekong_deals = $this->Cruise_Model->get_cruise_deals(1, array(), array(), '');
    	$tmp_data = load_top_cruise_deals(array(), $is_mobile, $mekong_deals, null, false);
    	$view_data['mekong_deals'] = $tmp_data['top_deals'];
    	
    	$data['main_deal_offer'] = load_view('deals/common/best_deals', $view_data, $is_mobile);
    	return $data;
    }

    function _load_main_view($data, $is_mobile){
        $view_data['hot_deals'] = $this->_get_hot_deals_data();

        $view_data['today_deals'] = $this->_get_today_hot_deals($view_data);

        $view_data['list_date_halong'] = get_list_dates_hot_deals($view_data['hot_deals']['halong_bay_deals']);

        $view_data['list_date_mekong'] = get_list_dates_hot_deals($view_data['hot_deals']['mekong_river_deals']);

        $view_data['list_date_vntour'] = get_list_dates_hot_deals($view_data['hot_deals']['vietnam_tour_deals']);

        $view_data['list_date_vnhotel'] = get_list_dates_hot_deals($view_data['hot_deals']['hotel_deals']);

        $data['main_deal_offer'] = load_view('deals/common/best_deals', $view_data, $is_mobile);

        return $data;
    }

    function _get_hot_deals_data(){

        $halong_bay_deals = array();

        $mekong_river_deals = array();

        $vietnam_tour_deals = array();

        $hotel_deals = $this->Tour_Model->get_hotel_hot_deals();

        $tour_deals = $this->Tour_Model->get_all_tour_hot_deals();

        foreach ($tour_deals as $value){

            if($value['cruise_id'] == 0){

                $vietnam_tour_deals[] = $value;

            } elseif ($value['cruise_destination'] == 0) {

                $halong_bay_deals[] = $value;

            } elseif ($value['cruise_destination'] == 1){

                $mekong_river_deals[] = $value;
            }

        }

        $ret['halong_bay_deals'] = $halong_bay_deals;

        $ret['mekong_river_deals'] = $mekong_river_deals;

        $ret['vietnam_tour_deals'] = $vietnam_tour_deals;

        $ret['hotel_deals'] = $hotel_deals;

        return $ret;
    }

    /**
     * get today hote deals data
     * @author TinVM
     * @since Jun12 2015
     */
    function _get_today_hot_deals($data){

        $ret = array();

        $hot_deals = $data['hot_deals'];

        if (count($hot_deals['halong_bay_deals']) > 0){

            $ret[] = $hot_deals['halong_bay_deals'][0];

        }

        if (count($hot_deals['mekong_river_deals']) > 0){

            $ret[] = $hot_deals['mekong_river_deals'][0];
        }

        if (count($hot_deals['vietnam_tour_deals']) > 0){

            $ret[] = $hot_deals['vietnam_tour_deals'][0];

        }

        if (count($hot_deals['hotel_deals']) > 0){

            foreach ($hot_deals['hotel_deals'] as $value){

                if ($value['destination'] == 'Hanoi'){ // Hanoi

                    $value['is_hotel'] = true;

                    $ret[] = $value;

                    break;
                }
            }
        }

        return $ret;

    }
}
?>