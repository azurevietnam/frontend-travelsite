<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Home Page
 *
 *  @author khuyenpv
 *  @since  Feb 04 2015 replace by TinVM May 19 2015
 */
class Hotels extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic', 'display', 'resource', 'hotel', 'tour', 'hotel_search','advertise','destination','faq', 'hotline', 'review', 'text'));

        $this->load->model(array('Hotel_Model', 'Destination_Model', 'Tour_Model'));

        $this->load->language(array('hotel', 'tour'));
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
        set_current_menu(MNU_HOTELS);

        // load the destination
        $destination = $this->Destination_Model->get_destination_4_hotel('Vietnam');

        // redirect to homepage if cannot find the destination
        if (empty($destination))
        {
            redirect(get_page_url(VN_HOTEL_PAGE), 'location');
        }

        $data['destination'] = $destination;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_HOTEL_PAGE);

        $data['page_theme'] = get_page_theme(VN_HOTEL_PAGE, $is_mobile);

        $data = get_page_main_header_title($data, $is_mobile, VN_HOTEL_PAGE);

        $data = get_page_navigation($data, $is_mobile, VN_HOTEL_PAGE);

        /**
         * Leftmenu Data
         */
        // load ad for hotel page
        $data = load_common_advertises($data, $is_mobile, AD_PAGE_VIETNAM_HOTEL, AD_AREA_DEFAULT, '', AD_DISPLAY_MULTIPLE);

        // load hotel search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;

    	$data = load_hotel_search_form($data, $is_mobile, array(), $display_mode_form , true);

        $data = load_why_use($data, $is_mobile);

        // load tripadvisor
        $data = load_tripadvisor($data, $is_mobile);

        //load top hotel destinations
        $data = load_top_hotel_destinations($data, $is_mobile);
        
        // load top tour destinations
        $data = load_top_tour_destinations($data, $is_mobile);

        //load faq by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_VN_HOTEL_PAGE);

        $data = $this->_load_most_recommeded_hotels($data, $is_mobile);

        //load list popular cities
        $data = load_popular_hotel_destinations($data, $is_mobile);

        render_view('hotels/home/hotel_home', $data, $is_mobile);
    }

    /**
     * Hotel By Destination
     * @author TinVM 21.05.2015
     *
     * @param $url_title: Url of the Destination
     */
    function hotels_by_destination($url_title){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $url_title = substr($url_title, 0, -7); // sub '-Hotels' in the end url_title

        //get destination info
        $destination = $this->Destination_Model->get_destination_by_url_title($url_title);

        if (empty($destination))
        {
            redirect(get_page_url(VN_HOTEL_PAGE), 'location');
        }

        $destination['number_hotels'] = $this->Hotel_Model->count_nr_hotel_in_destination($destination['id']);
        $data['destination'] = $destination;

        // set cache html
        set_cache_html();

        // set current menu
        set_current_menu(MNU_HOTELS);

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(HOTELS_BY_DESTINATION_PAGE, $destination['name']);

        $data['page_theme'] = get_page_theme(HOTELS_BY_DESTINATION_PAGE, $is_mobile);

        $data = get_page_main_header_title($data, $is_mobile, HOTELS_BY_DESTINATION_PAGE);

        $data = get_page_navigation($data, $is_mobile, HOTELS_BY_DESTINATION_PAGE);

        // load common advertise
        $data = load_common_advertises($data, $is_mobile, AD_PAGE_HOTEL_BY_DESTINATION, AD_AREA_DEFAULT);

        // load hotel search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_hotel_search_form($data, $is_mobile, array(), $display_mode_form , true);

        //load top hotel destinations
        $data = load_top_hotel_destinations($data, $is_mobile);
        
        // load top tour destinations
        $data = load_top_tour_destinations($data, $is_mobile);

        //load faq by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HOTEL_BY_DESTINATION);

        //load list hotel in destination
        $data = load_hotel_in_destination($data, $is_mobile);

        //load list hotels

        $hotels = $this->Hotel_Model->get_hotels_by_destination($data['destination']['id'], 10);

        $hotels = $this->Hotel_Model->get_hotel_special_offers($hotels);

        foreach ($hotels as $key=>$hotel) {
            $hotel['special_offers'] = empty($hotel['promotions']) ? '' : load_promotion_popup($is_mobile, $hotel['promotions'][0], HOTEL, true, true);
            
            $hotels[$key] = $hotel;
        }

        $data = load_list_hotels($data, $is_mobile, $hotels, true);

        render_view('hotels/destination/hotel_destination_home', $data, $is_mobile);
    }

    /**
     * Load 10 Hotes in eacch top destination
     * @author TinVM 21.05.2015
     */
    function _load_most_recommeded_hotels($data, $is_mobile){

        $view_data = array();

        $top_destinations = $data['top_hotel_destinations']; // aready called in load_top_hotel_destinations()

        $is_first = true;

        foreach ($top_destinations as $key => $value)
        {
            $hotels = $this->Hotel_Model->get_hotels_by_destination($value['id']);

            $hotels = $this->Hotel_Model->get_hotel_special_offers($hotels);
            
            foreach ($hotels as $k => $hotel)
            {
                $hotel['special_offers'] = empty($hotel['promotions']) ? '' : load_promotion_popup($is_mobile, $hotel['promotions'][0], HOTEL, true, true);
                
                $hotels[$k] = $hotel;
            }
            
            $list_hotel = load_list_hotels(array(), $is_mobile, $hotels);

            $top_destinations[$key]['list_hotels'] = $list_hotel['list_hotels'];

            $top_destinations[$key]['is_first'] = $is_first;

            $is_first = false;
        }

        $view_data['hotel_by_top_destinations'] = $top_destinations;

        $data['most_recommeded_hotels'] = load_view('hotels/home/most_recommended_hotels', $view_data, $is_mobile);

        return $data;
    }

}
?>