<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Tours extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->language(array('tour', 'cruise'));

       	$this->load->config('tour_meta');

       	$this->load->helper(array('basic', 'resource', 'tour', 'tour_search','advertise','destination','faq', 'hotline', 'review', 'text', 'recommend'));

       	$this->load->model(array('Tour_Model', 'Destination_Model', 'Faq_Model'));

		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
    {
    	$data = $this->_load_common_data();

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(VN_TOUR_PAGE);

    	$data['page_theme'] = get_page_theme(VN_TOUR_PAGE, $data['is_mobile']);

    	$data = get_page_main_header_title($data, $data['is_mobile'], VN_TOUR_PAGE);

    	$data = get_page_navigation($data, $data['is_mobile'], VN_TOUR_PAGE);

    	// load the destination
    	$destination = $this->Destination_Model->get_destination_4_tour('Vietnam');

    	// redirect to homepage if cannot find the destination
    	if (empty($destination))
        {
            redirect(get_page_url(VN_TOUR_PAGE), 'location');
        }

    	$data['destination'] = $destination;

    	// load common advertise
    	$data = load_common_advertises($data, $data['is_mobile'], AD_PAGE_VIETNAM_TOUR, AD_AREA_DEFAULT, $destination['id']);

    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $data['is_mobile'], array(), $display_mode_form , TRUE);

    	$data = load_why_use($data, $data['is_mobile']);

    	// load tripadvisor
    	$data = load_tripadvisor($data, $data['is_mobile']);

        // load top tour destinations
        $data = load_top_tour_destinations($data, $data['is_mobile']);

        // load tour travel guide
        $data = load_destination_travel_guide($data, $data['is_mobile'], $destination);

    	// load fag by page
    	$data = load_faq_by_page($data, $data['is_mobile'], '', FAQ_PAGE_VN_TOUR);

    	// load rich snippet
    	$data = load_rich_snippet($data, $destination['id'], $destination['name']);

    	// load best tour
    	$data = $this->_load_country_best_tours($data, $data['is_mobile'], $destination);

    	// load travel styles of country
    	$data = $this->_load_country_travel_styles($data, $data['is_mobile'], $destination);

    	// load tailor make tour
    	$data = load_tailor_make_tour($data, $data['is_mobile']);

    	// load countries of Indochina Tours
    	$data = load_indochina_countries($data, $data['is_mobile'], TOUR_HOME);

        $data = load_destination_article_links($data, $data['is_mobile'], $destination);
        
        render_view('tours/country/country', $data, $data['is_mobile']);
    }

    /**
     * Khuyenpv Feb 12 2015
     * Controller for tours by destinations
     */
    function tours_by_destination($url_title)
    {
        $data = $this->_load_common_data();

        // load the destination
        $destination = $this->Destination_Model->get_destination_4_tour($url_title);

        // redirect to homepage if cannot find the destination
        if (empty($destination) || $url_title == 'Vietnam')
        {
            redirect(get_page_url(VN_TOUR_PAGE), 'location', 301);
        }

        $data['destination'] = $destination;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(TOURS_BY_DESTINATION_PAGE, $destination);

        // get the page css/js
        $data['page_theme'] = get_page_theme(TOURS_BY_DESTINATION_PAGE, $data['is_mobile']);

        $data = get_page_main_header_title($data, $data['is_mobile'], TOURS_BY_DESTINATION_PAGE);

        $data = get_page_navigation($data, $data['is_mobile'], TOURS_BY_DESTINATION_PAGE);

        // load common advertise
        $data = load_common_advertises($data, $data['is_mobile'], AD_PAGE_TOUR_BY_DESTINATION, AD_AREA_DEFAULT, $destination['id']);
        
        // load the tour search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
        $data = load_tour_search_form($data, $data['is_mobile'], array(), $display_mode_form, TRUE);

        $data = load_why_use($data, $data['is_mobile']);

        // load tripadvisor
        $data = load_tripadvisor($data, $data['is_mobile']);

        //load tour by destinations
        $data = load_top_tour_destinations($data, $data['is_mobile']);

        // load tour travel guide
        $data = load_destination_travel_guide($data, $data['is_mobile'], $destination);

        // load fag by page
        $data = load_faq_by_page($data, $data['is_mobile'], '', FAQ_PAGE_TOUR_BY_DESTINATION);

        // load rich snippet
        $data = load_rich_snippet($data, $destination['id'], $destination['name']);

        // load travel styles of country
        $data = $this->_load_country_travel_styles($data, $data['is_mobile'], $destination);

        // load tailor make tour
        $data = load_tailor_make_tour($data, $data['is_mobile']);

        $data = load_destination_article_links($data, $data['is_mobile'], $destination);
        
        // load countries of Indochina Tours
        $data = load_indochina_countries($data, $data['is_mobile'], TOUR_HOME);

        // if destination is a country
        if ($destination['destination_type'] == DESTINATION_TYPE_COUNTRY)
        {
            $this->_load_tours_by_country($data, $data['is_mobile'], $destination);
        }
        else // if destination is a city
        {
            $this->_load_tours_by_city($data, $data['is_mobile'], $destination);
        }
    }

    /**
     * Khuyenpv Feb 10 2015
     * Controller for tours of destination & travel style
     * @param $destination_url_title
     * @param $travel_style_url_title
     */
    function tours_by_travel_style($destination_url_title, $travel_style_url_title)
    {
        // redirect highlight tour to best of vietnam tour
        if($destination_url_title == 'Vietnam' && $travel_style_url_title == 'Highlight') {
            redirect(site_url('Tours_Vietnam_Best-of-Vietnam-Tours'), 'location', 301);
        }
        
        $data = $this->_load_common_data();

        // load the destination
        $destination = $this->Destination_Model->get_destination_4_tour($destination_url_title);

        $travel_style = $this->Destination_Model->get_travel_style_4_tour($travel_style_url_title);

        // redirect to homepage if cannot find the destination
        if (empty($destination) || empty($travel_style))
        { // empty destination
            redirect(get_page_url(VN_TOUR_PAGE), 'location', 301);
        }

        $destination['styles'] = $this->Tour_Model->get_destination_travel_styles($destination['id']);
        
        $data['destination'] = $destination;

        $data['travel_style'] = $travel_style;
        
        // get destination travel style description
        if(!empty($destination['styles'])) {
            foreach ($destination['styles'] as $des_style) {
                if($des_style['style_id'] == $travel_style['id']) {
                    $data['travel_style']['destination_style_desc'] = $des_style['description'];
                    break;
                }
            }
        }
        
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $travel_style);

        // get the page css/js
        $data['page_theme'] = get_page_theme(TOURS_BY_TRAVEL_STYLE_PAGE, $data['is_mobile']);

        $data = get_page_main_header_title($data, $data['is_mobile'], TOURS_BY_TRAVEL_STYLE_PAGE);

        $data = get_page_navigation($data, $data['is_mobile'], TOURS_BY_TRAVEL_STYLE_PAGE);

        // load common advertise
        $data = load_common_advertises($data, $data['is_mobile'], AD_PAGE_TOUR_BY_TRAVEL_STYLES, AD_AREA_DEFAULT, $destination['id'], AD_DISPLAY_SINGLE, $travel_style['id']);
        
        // load the tour search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
        $data = load_tour_search_form($data, $data['is_mobile'], array(), $display_mode_form, TRUE);

        $data = load_why_use($data, $data['is_mobile']);

        // load tripadvisor
        $data = load_tripadvisor($data, $data['is_mobile']);

        // load the tour-categories links
        $data = load_tour_categories($data, $data['is_mobile'], $destination, $destination['styles'], $travel_style['url_title']);

        // load top tour destinations
        $data = load_top_tour_destinations($data, $data['is_mobile']);

        // load tour travel guide
        $data = load_destination_travel_guide($data, $data['is_mobile'], $destination);
        
        // load fag by page
        $data = load_faq_by_page($data, $data['is_mobile'], $destination['id']);

        // get the top-tours
        $tours = $this->Tour_Model->get_tours_by_destination_travel_style($destination['id'], $travel_style['id'], null, 10);
        
        // check number of tours for show more button
        if(count($tours) < 10) {
            $number_of_tours = count($tours);
        } else {
            $number_of_tours = $this->Tour_Model->count_tours_by_destination_travel_style($destination['id'], $travel_style['id']);
        }
        
        $data['is_show_more'] = $number_of_tours > count($tours) ? true : false;

        // load tour special offers
       	$tours = set_tour_special_offers($tours);
       	
       	$is_enable_number = false;

       	// special destination style: vietnam highlight -> best of vietnam tour
       	if (is_best_of_destination($destination, $travel_style))
        {
            $data['best_of_country'] = true;
            $is_enable_number = true;
        }
        elseif (empty($data['common_ad']) && !empty($tours)) // only show most recommend when advertises aren't avaiable
        {
            // get the most recommended tour
            $most_recommended_tour = count($tours) > 0 ? $tours[0] : '';
            
            // get itinerary highlight
            $most_recommended_tour['highlights'] = $this->Tour_Model->get_itinerary_highlight($most_recommended_tour['id']);
            
            // remove most recommended tour in list of tours
            array_shift($tours);

            // load most recommended tours
            $data = load_most_recommended_tour($data, $data['is_mobile'], $most_recommended_tour);
        }

        // load the remaining tours
        $data = load_list_tours($data, $data['is_mobile'], $tours, $is_enable_number);

        // load tailor make tour
        $data = load_tailor_make_tour($data, $data['is_mobile']);

        render_view('tours/city/destination_travel_style_tours', $data, $data['is_mobile']);
    }

    /**
     * Khuyenpv Feb 09 2015
     * Controller for top 10 tours of a country
     * @param $url_title: url_title of the country
     */
    function top_country_tours($url_title){

    	$data = $this->_load_common_data();

    	// load the destination
    	$destination = $this->Destination_Model->get_destination_4_tour($url_title);

    	// redirect to homepage if cannot find the destination
    	// empty destination or not country
    	if (empty($destination) || $destination['type'] != DESTINATION_TYPE_COUNTRY)
        {
            redirect(get_page_url(VN_TOUR_PAGE), 'location', 301);
        }

    	$data['destination'] = $destination;

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(TOP_TOURS_PAGE, $destination);

    	// get the page css/js
    	$data['page_theme'] = get_page_theme(TOP_TOURS_PAGE, $data['is_mobile']);

    	$data = get_page_navigation($data, $data['is_mobile'], TOP_TOURS_PAGE);


    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
        $data = load_tour_search_form($data, $data['is_mobile'], array(), $display_mode_form, TRUE);

    	// load tripadvisor
    	$data = load_tripadvisor($data, $data['is_mobile']);

    	// load the tour-categories links
    	$data = load_tour_categories($data, $data['is_mobile'], $destination);

    	// load destination info links
    	$data = load_destination_info_links($data, $data['is_mobile'], $destination);

    	// load fag by page
    	$data = load_faq_by_page($data, $data['is_mobile'], $destination['id']);

    	// get the top-tours
    	$top_tours = $this->Tour_Model->get_most_recommended_tour_in_des($destination['id'], 10);

    	// get the most recommended tour
    	$most_recommended_tour = count($top_tours) > 0 ? $top_tours[0] : '';
    	if (count($top_tours) > 0){
    		array_shift($top_tours);
    	}

    	// load most recommended tours
    	$data = load_most_recommended_tour($data, $data['is_mobile'], $most_recommended_tour);


    	// load the remaining tours
    	$data = load_list_tours($data, $data['is_mobile'], $top_tours);

    	render_view('tours/country/top_tours', $data, $data['is_mobile']);
    }

    /**
     * Khuyenpv Feb 09 2015
     * Load best tours of a country
     */
    function _load_country_best_tours($data, $is_mobile, $destination){

        $tours = $this->Tour_Model->get_most_recommended_tour_in_des($destination['id'], 3);

    	$data = load_top_recommended_tours($data, $is_mobile, $tours);

    	return $data;
    }

    /**
     * Khuyenpv Feb 09 2015
     * Load the travel styles of a country
     */
    function _load_country_travel_styles($data, $is_mobile, $destination){
        
        $is_get_all = false;
        
        if ($destination['destination_type'] == DESTINATION_TYPE_COUNTRY)
        {
            $is_get_all = true;
        }

        $data['destination_styles'] = $this->Tour_Model->get_destination_travel_styles($destination['id'], $is_get_all);

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

    	$data['destination_travel_styles'] = $this->load->view($mobile_folder.'tours/country/travel_styles', $data, TRUE);

    	return $data;
    }

    /**
     * Khuyenpv Feb 09 2015
     * Load the citites of a country
     */
    function _load_country_cities($data, $is_mobile, $destination)
    {
        $data['cities'] = $this->Destination_Model->get_cities_of_destination($destination['id']);

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $data['cities'] = $this->load->view($mobile_folder . 'tours/country/cities', $data, TRUE);

        return $data;
    }

    /**
     * Khuyenpv Feb 12 2015
     * Load tours by country data
     */
    function _load_tours_by_country($data, $is_mobile, $destination){

    	// load common advertise
    	$data = load_common_advertises($data, $is_mobile, AD_PAGE_TOUR_BY_DESTINATION, AD_AREA_DEFAULT, $destination['id']);

    	// load best tour
    	$data = $this->_load_country_best_tours($data, $is_mobile, $destination);

    	// load travel styles of country
    	$data = $this->_load_country_travel_styles($data, $is_mobile, $destination);

    	// load cities of a country
    	//$data = $this->_load_country_cities($data, $is_mobile, $destination);

    	// load countries of Indochina Tours
    	$data = load_indochina_countries($data, $is_mobile, $destination, TOUR_HOME);

    	render_view('tours/country/country', $data, $is_mobile);
    }

    /**
     * Khuyenpv Feb 12 2015
     * Load tours by city data
     */
    function _load_tours_by_city($data, $is_mobile, $destination){

    	// load all travel styles of destinations
    	$travel_styles = $this->Tour_Model->get_destination_travel_styles($destination['id'], true);

    	$destination['styles'] = $travel_styles;

        // load recommends in tour
        $data = load_recommend_info_links($data, $is_mobile, $destination['id'], TOUR);

        $lst_travel_styles = array();
        
        foreach ($travel_styles as $k => $travel_style)
        {
            $tours = $this->Tour_Model->get_tours_by_destination_travel_style($destination['id'], $travel_style['style_id'], null, 5);
            
            if(!empty($tours)) {
                $tours = $this->Tour_Model->get_tour_special_offers($tours);
            
                foreach($tours as $key => $tour){
                     
                    $tour['special_offers'] = load_promotion_popup($is_mobile, $tour['promotions'], TOUR, true);
                     
                    $tours[$key] = $tour;
                }
            }
            
            $travel_style = load_list_tours($travel_style, $is_mobile, $tours);
            
            $travel_styles[$k] = $travel_style;
            
            if(!empty($travel_style['list_tours'])) $lst_travel_styles[] = $travel_style;
        }

        $data['travel_styles'] = $lst_travel_styles;

    	// load recommended tours
    	if (empty($travel_styles))
        {
            // load most recommended tour
            $recommended_tours = $this->Tour_Model->get_most_recommended_tour_in_des($destination['id'], 10);
            
            $recommended_tours = $this->Tour_Model->get_tour_special_offers($recommended_tours);
            
            foreach($recommended_tours as $key => $tour){
                 
                $tour['special_offers'] = load_promotion_popup($is_mobile, $tour['promotions'], TOUR, true);
                 
                $recommended_tours[$key] = $tour;
            }

            if (! empty($recommended_tours))
            {
                $data['best_tours'] = $recommended_tours;

                $data = load_list_tours($data, $is_mobile, $recommended_tours);
            }
        }
        else
        {
            // load most recommended tour
            $recommended_tours = $this->Tour_Model->get_most_recommended_tour_in_des($destination['id'], 3);
            
            $recommended_tours = $this->Tour_Model->get_tour_special_offers($recommended_tours);
            
            foreach($recommended_tours as $key => $tour){
                
                // get offer note of first promotion
                $offer_note = !empty($tour['promotions']) ? $tour['promotions'][0] : null;
                	
                $tour['special_offers'] = load_promotion_popup($is_mobile, $offer_note, TOUR, true);
                	
                $recommended_tours[$key] = $tour;
            }
            
            if(!$is_mobile) {
                $data['city_travel_styles'] = load_view('tours/city/city_travel_styles', $data, $is_mobile);
            }

            $data = load_top_recommended_tours($data, $is_mobile, $recommended_tours);
        }


    	render_view('tours/city/city_tours', $data, $is_mobile);
    }

    /**
     * load top attraction
     *
     * @author toanlk
     * @since  Apr 10, 2015
     */
    function _load_top_attraction($data, $is_mobile, $destination) {

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $data['attractions'] = $this->Destination_Model->get_attractions($destination['id'], 10, 0, false, true, true);

        $data['top_attractions'] = $this->load->view($mobile_folder . 'tours/city/top_attractions', $data, TRUE);

        return $data;
    }
    
    /**
     * load common data
     *
     * @author toanlk
     * @since  June 10, 2015
     */
    function _load_common_data($data = array()) {
    
        // check if the current device is Mobile or Not
        $data['is_mobile'] = is_mobile();
    
        // set cache html
        set_cache_html();
    
        // set current menu
        set_current_menu(MNU_VN_TOURS);
    
        // load bottom links
        $data = load_indochina_countries($data, $data['is_mobile'], HOME_PAGE);
    
        $data = load_popular_service_links($data, $data['is_mobile'], true);
    
        return $data;
    }
}
?>
