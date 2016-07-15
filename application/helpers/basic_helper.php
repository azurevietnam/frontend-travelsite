<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * New Version of Common Helper
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb, 2, 2015
 */

/**
 * Khuyenpv Feb, 02, 2015
 * Set HTML cache for each page
 */
function set_cache_html(){
    $CI =& get_instance();
    $CI->output->cache($CI->config->item('cache_html'));
}

/**
 * Khuyenpv Feb, 02, 2015
 * Check if the current website version is Mobile or Desktop
 */
function is_mobile(){

    $CI =& get_instance();

    $mobile_on_off = $CI->input->get('mobileon');

    if(!empty($mobile_on_off)){
        $CI->session->set_userdata(MOBILE_ON_OFF, $mobile_on_off);
    }

    $mobile_on_off = $CI->session->userdata(MOBILE_ON_OFF);
    if(empty($mobile_on_off)) $mobile_on_off = 'on';

    $mobile_detect = new Mobile_Detect();
    $is_mobile = ($mobile_detect->isMobile() && !$mobile_detect->isTablet()) && $mobile_on_off == 'on';
    return $is_mobile;
}

function get_mobile_version(){
	$curent_url = current_url();
	if($curent_url != site_url()) $curent_url.='/';
	if(strpos($curent_url, '?') === false){
		$curent_url .= '?mobileon=off';
	} else {
		$curent_url .= '&mobileon=off';
	}
	return $curent_url;
}

/**
 * Khuyenpv Feb 04 2015
 * Set current active menu
 */
function set_current_menu($mnu){
    $CI =& get_instance();
    $CI->session->set_userdata('MENU', $mnu);
}

/**
 * Khuyenpv Feb 04 2015
 * Get Selected Menu
 */
function get_current_menu($mnu){
    $CI =& get_instance();
    $current_mnu = $CI->session->userdata('MENU');
    if($current_mnu == $mnu){
        return 'class="active"';
    }
    return '';
}

/**
 * Khuyenpv Feb 04 2015
 * Render the view
 * @param $page_view: the page to be loaded
 * @param $data: data passed to the page
 */
function render_view($page_view, $data = array(), $is_mobile = false){

    $CI =& get_instance();

    $data['bpt_content'] = load_view($page_view, $data, $is_mobile);

    $data['bpt_header'] = load_view('_templates/header', $data, $is_mobile);

    $data['bpt_footer'] = load_view('_templates/footer', $data, $is_mobile);

    if($is_mobile){
        $CI->load->view('mobile/_templates/bpt_main_layout', $data);
    } else {
        $CI->load->view('_templates/bpt_main_layout', $data);
    }
}

/**
 * Common Load View
 *
 * @author Khuyenpv
 * @since March 12 2015
 */
function load_view($page_view, $view_data, $is_mobile){

    $CI =& get_instance();

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    $page_view = $CI->load->view($mobile_folder. $page_view, $view_data, TRUE);

    return $page_view;
}

/**
 * Khuyenpv Feb 04 2015
 * Get the url of a page
 * @param $page: the constant of the page
 * @param $object: the bussiness object like cruise, tour, hotel
 * @param $search_criteria: the searching data like date, number of passenger, ...vv
 */
function get_page_url($page, $object1 = array(), $object2 = array()){
    $url = $page;

    switch ($page) {
        case HOME_PAGE:
            $url = '';
            break;
        case TOP_TOURS_PAGE:
        case TOURS_BY_DESTINATION_PAGE:
        case TOUR_DETAIL_PAGE:
        case CRUISE_DETAIL_PAGE:
        case TOUR_REVIEW_PAGE:
        case CRUISE_REVIEW_PAGE:
        case TOUR_BOOKING_PAGE:
        case TOUR_BOOK_IT_PAGE:
        case FAQ_DESTINATION_PAGE:
        case FAQ_CATEGORY_PAGE:
        case FAQ_DETAIL_PAGE:
        case DESTINATION_DETAIL_PAGE:
        case DESTINATION_THINGS_TO_DO_PAGE:
        case DESTINATION_ATTRACTION_PAGE:
        case DESTINATION_CITY_IN_COUNTRY:
        case DESTINATION_ARTICLE_PAGE:
        case HOTEL_DETAIL_PAGE:
        case HOTEL_BOOK_IT_PAGE:
        case HOTEL_BOOKING_PAGE:
        case HOTELS_BY_DESTINATION_PAGE:
        case HOTEL_REVIEW_PAGE:
            $url = str_replace_first('%s',$object1['url_title'], $page);
            break;
        case DESTINATION_ARTICLE_DETAIL_PAGE:
        case DESTINATION_INFORMATION_PAGE:
        case DESTINATION_THINGS_TODO_DETAIL_PAGE:
            $url = str_replace_first('%s', $object1['url_title'], $page);
            $url = str_replace_first('%s', $object2['url_title'], $url);
            break;
        case HOTEL_ADD_CART_PAGE:
        case TOUR_ADD_CART_PAGE:
            $url = str_replace_first('%s', $object1['url_title'], $page);
            $url = str_replace_first('%s', $object2, $url);
            break;

        case TOURS_BY_TRAVEL_STYLE_PAGE:
            $url = str_replace_first('%s', $object1['url_title'], $page);
            $url = str_replace_first('%s', $object2['url_title'], $url);

            if(is_symnonym_words($object2['name'])) {
                $url = substr($url, 0, strlen($url) - 6);
            }

            break;

        case TOUR_SEARCH_EMPTY_PAGE:
        case TOUR_SEARCH_PAGE:
        case HOTEL_SEARCH_PAGE:
        case HOTEL_SEARCH_EMPTY_PAGE:

            if(!empty($object1)){

                $url .= '?'.http_build_query($object1);

            }

            break;
        case ABOUT_US_PAGE:
        case REGISTRATION_PAGE:
        case POLICY_PAGE:
        case PRIVACY_PAGE:
        case OUR_TEAM_PAGE:
        case CONTACT_US_PAGE:
        case CUSTOMIZE_TOUR_PAGE:
        case THANK_YOU_REQUEST_PAGE:
        case DEAL_OFFER_PAGE:
            break;
        case FLIGHT_DESTINATION_PAGE:
            $url = str_replace_first('%s',$object1['url_title'], $page);
            break;
        case FLIGHT_SEARCH_EXCEPTION_PAGE:
        	if(!empty($object1)){

        		$url .= '?'.http_build_query($object1) .'&'. http_build_query($object2);

        	}

    }

    $site_url = site_url($url);

    if(strpos($site_url, '.html') === FALSE && $url != ''){
        $site_url .= '/';
    }

    return $site_url;
}

/**
 * Khuyenpv Feb 04 2015
 * Get the meta data of a page
 * @param unknown $page
 * @param unknown $object
 */
function get_page_meta($page, $object1 = array(), $object2 = array()){
	$CI =& get_instance();
	
	$robots 		= 'index,follow';
    $title 			= '';
    $keywords 		= '';
    $description 	= '';
    $canonical 		= '';


    switch ($page) {

        case HOME_PAGE:
            $title 			= lang('home_title');
            $keywords 		= lang('home_keywords');
            $description 	= lang('home_description');
            break;

        case VN_TOUR_PAGE:
            $title 			= lang('tours_title');
            $keywords 		= lang('tours_keywords');
            $description 	= lang('tours_description');
            break;

        case TOP_TOURS_PAGE:
            $title 			= lang('top_tours_title', $object1['name'], $object1['name']);
            $keywords 		= lang('top_tours_keywords', $object1['name'], $object1['name']);
            $description 	= lang('top_tours_description', $object1['name'], $object1['name']);
            break;

        case TOURS_BY_DESTINATION_PAGE:
            $title 			= !empty($object1['tour_title']) ? $object1['tour_title'] : str_replace('%s', $object1['name'], lang('tour_destinations_title'));
            $keywords 		= !empty($object1['tour_keywords']) ? $object1['tour_keywords'] : str_replace('%s', $object1['name'], lang('tour_destinations_keywords'));
            $description 	= !empty($object1['tour_description']) ? $object1['tour_description'] : str_replace('%s', $object1['name'], lang('tour_destinations_description'));
            break;

        case TOURS_BY_TRAVEL_STYLE_PAGE:

            $object2['name'] = !is_symnonym_words($object2['name']) ? lang_arg('title_tour_destination', $object2['name']) : $object2['name'];

            $title = str_replace('%d', $object1['name'], lang('tour_destinations_style_title'));
            $title = str_replace('%s', strtolower($object2['name']), $title);

            if (is_best_of_destination($object1, $object2)) {
                $title = str_replace('%c', $object2['name'], $title);
            } else {
                $title = str_replace('%c', $object1['name'].' '.$object2['name'], $title);
            }

            $keywords = str_replace('%s', $object1['name'].' '.$object2['name'], lang('tour_destinations_style_keywords'));

            $description = str_replace('%s', $object1['name'].' '.$object2['name'], lang('tour_destinations_style_description'));
            $description = str_replace('%d', strtolower($object2['name']), $description);
            $description = str_replace('%c', $object1['name'], $description);

            // Halong Bay Tours && Mekong Delta Tours
            if ($object1['id'] == HALONG_BAY || $object1['id'] == MEKONG_DELTA)
            {
                $canonical = '<link rel="canonical" href="' . get_page_url(TOURS_BY_DESTINATION_PAGE, $object1) . '"/>';
            }

            break;

        case TOUR_DETAIL_PAGE:
            $title 			= $object1['partner_name'] . ': ' . $object1['name'];
            $keywords 		= strtolower($object1['partner_name'] . ',' . str_replace(' ', ',', stripcslashes($object1['name'])));
            $description 	= lang_arg('tour_details_page_description', $object1['name'], $object1['partner_name'], get_duration($object1['duration']));
			
            $review_tab = $CI->uri->segment(2);
           
            if(!empty($object2)) { // cruise tour => canonical to cruise 
                $canonical = '<link rel="canonical" href="' . get_page_url(CRUISE_DETAIL_PAGE, $object2) . '"/>';
            } else {
            	$link_params = $CI->input->get();
            	
            	if(!empty($link_params) || !empty($review_tab)){
            		$canonical = '<link rel="canonical" href="' . get_page_url(TOUR_DETAIL_PAGE, $object1) . '"/>';
            	}
            }

            break;
       
        case TOUR_SEARCH_PAGE:
        	$title = lang('lbl_tour_search_results');
        	$robots 		= 'noindex,nofollow';
        	break;
        case TOUR_SEARCH_EMPTY_PAGE:
        	$title = lang('lbl_tour_search_empty');
        	$robots 		= 'noindex,nofollow';
        	break;

        case VN_HOTEL_PAGE:
            $title 			= lang('hotels_title');
            $keywords 		= lang('hotels_keywords');
            $description 	= lang('hotels_description');
            break;

        case HOTELS_BY_DESTINATION_PAGE:
            $title 			= str_replace('%s', $object1, stripcslashes(lang('hotel_destinations_title')));
            $keywords 		= str_replace('%s', $object1, stripcslashes(lang('hotel_destinations_keywords')));
            $description 	= str_replace('%s', $object1, stripcslashes(lang('hotel_destinations_description')));
            break;
		
        case HOTEL_SEARCH_PAGE:
        	$robots 		= 'noindex,nofollow';
        	$title = lang('lbl_hotel_search_results');
        	break;
        case HOTEL_SEARCH_EMPTY_PAGE:
            $robots 		= 'noindex,nofollow';
            $title = lang('lbl_hotel_search_empty');
            break;

        case HOTEL_DETAIL_PAGE:
        	$title = str_replace('%s', get_alt_image_text_hotel($object1), stripcslashes(lang('hotel_detail_title')));
        	$keywords = get_alt_image_text_hotel($object1);
        	$description = get_alt_image_text_hotel($object1) .': '. $object1['location'];
        	
        	$link_params = $CI->input->get();
        	 
        	if(!empty($link_params) || !empty($review_tab)){
        		$canonical = '<link rel="canonical" href="' . get_page_url(HOTEL_DETAIL_PAGE, $object1) . '"/>';
        	}
        	
            break;

        case HOTEL_REVIEW_PAGE:
            $title = $object1['name'].' '.lang('review');
            $keywords = $title;
            $description = $object1['name'];
            
            $description .= " ".lang('review').": ";
            $description .= str_replace("%", $object1['name'], lang('customer_review_description'));
            
            break;

        case TOUR_BOOKING_PAGE:
        case HOTEL_BOOKING_PAGE:
            $title 			= lang('lbl_book_extra_services');
            $keywords 		= '';
            $description 	= '';
            break;

        case VN_VISA_PAGE:
            $title 			= lang('visa_title');
            $keywords 		= lang('visa_keywords');
            $description 	= lang('visa_description');
            $robots         = 'index, follow';
            break;

        case VN_VISA_FOR_CITIZENS_PAGE:
            $title 			= lang('lb_vietnam') . ' ' . lang_arg('visa_for_citizens_navigation', ucfirst($object1['name'])) . ' - ' . BRANCH_NAME;
            $keywords 		= strtolower(lang_arg('visa_for_citizens_navigation', ucfirst($object1['name'])));
            $description 	= lang_arg('visa_for_citizens_description', ucfirst($object1['name']));
            $robots         = 'index, follow';
            break;

        case VN_VISA_APPLY_PAGE:
            $title 			= lang('visa_title');
            $keywords 		= lang('visa_keywords');
            $description 	= lang('visa_description');
            $robots         = 'index, follow';
            break;

        case VN_VISA_DETAILS_PAGE:
            $title 			= lang('visa_title');
            $keywords 		= lang('visa_keywords');
            $description 	= lang('visa_description');
            break;

        case VN_VISA_PAYMENT_PAGE:
            $title 			= lang('visa_payment');
            $keywords 		= '';
            $description 	= '';
            break;

        case VN_VISA_FEES_PAGE:
            $title 			= lang('visa_fees_title');
            $keywords 		= lang('visa_fees_keywords');
            $description 	= lang('visa_fees_description');
            $robots         = 'index, follow';
            break;

        case VN_VISA_ON_ARRIVAL_PAGE:
            $title 			= lang('visa_on_arrival_page_title');
            $keywords 		= lang('vietnam_visa');
            $description 	= lang('visa_on_arrival_description');
            $robots         = 'index, follow';
            break;

        case VN_VISA_REQUIREMENTS_PAGE:
            $title 			= lang('vietnam_visa_rquirements');
            $keywords 		= lang('vietnam_visa_rquirements');
            $description 	= lang('field_visa_requirements_description');
            $robots         = 'index, follow';
            break;

        case VN_VISA_HOW_TO_APPLY_PAGE:
            $title 			= lang('how_to_apply_page_title');
            $keywords 		= lang('how_to_apply_page_title');
            $description 	= lang('how_to_apply_page_title');
            $robots         = 'index, follow';
            break;

        case VN_VISA_APPLICATION_PAGE:
            $title 			= lang('field_title_arrival_application_form');
            $keywords 		= lang('field_keywords_arrival_application_form');
            $description 	= lang('field_description_arrival_application_form');
            $robots         = 'index, follow';
            break;

        case VN_VISA_EMBASSIES_WORLDWIDE_PAGE:
            $title 			= lang('vietnam_embassies_worldwide');
            $keywords 		= lang('vietnam_embassies_worldwide');
            $description 	= lang('vietnam_embassies_worldwide');
            $robots         = 'index, follow';
            break;

        case VN_VISA_AVAILABILITY_FEE_PAGE:
            $title 			= lang('vietnam_visa_pricing_service');
            $keywords 		= lang('vietnam_visa_pricing_service');
            $description 	= lang('vietnam_visa_pricing_service');
            $robots         = 'index, follow';
            break;

        case VN_VISA_EXEMPTION_PAGE:
            $title 			= lang('vietnam_visa_exemption');
            $keywords 		= lang('vietnam_visa_exemption');
            $description 	= lang('vietnam_visa_exemption');
            $robots         = 'index, follow';
            break;

        case VN_VISA_TYPES_PAGE:
            $title 			= lang('vietnam_visa_types');
            $keywords 		= lang('vietnam_visa_types');
            $description 	= lang('vietnam_visa_types');
            $robots         = 'index, follow';
            break;

        case FAQ_PAGE:
            $title 			= lang('faqs_title');
            $keywords 		= lang('faqs_keywords');
            $description 	= lang('faqs_description');
            break;

        case FAQ_CATEGORY_PAGE:
            $title = 'FAQ: '.$object1['name'];
            $keywords = $object1['name'];
            $description = $object1['name'];
            $robots = "noindex";
            break;

        case FAQ_DESTINATION_PAGE:
            $title = lang('faq_destination_title', $object1['name']);
            $keywords = lang('faq_destination_keyword', $object1['name']);
            $description = lang('faq_destination_description', $object1['name']);
            $robots = "noindex";
            break;

        case FAQ_DETAIL_PAGE:
            $title = 'FAQ: '.$object1['question'];
            $keywords = "";
            $description = $object1['question'];
            break;

        case DESTINATION_DETAIL_PAGE:
            $title = $object1['name'];

            if(!empty($object1['title']))
                $title.=' - '. $object1['title'];

            $keywords = lang('field_travel_guide', $object1['name']);

            $description = lang('field_travel_guide_of', $object1['name']);

            break;

        case DESTINATION_THINGS_TO_DO_PAGE:
            $title = lang('lbl_top_thing_to_do', $object1['name']);

            $keywords = '';

            $description = lang('lbl_top_thing_to_do', $object1['name']);
            break;

        case DESTINATION_ATTRACTION_PAGE:
            $title = lang('lbl_attraction', $object1['name']);

            $keywords = '';

            $description = lang('lbl_attraction', $object1['name']);
            break;

        case DESTINATION_ARTICLE_PAGE:
            $title = lang('field_travel_articles_in', $object1['name']);

            $keywords = '';

            $description = lang('field_travel_articles_in', $object1['name']);
            break;

        case DESTINATION_ARTICLE_DETAIL_PAGE:
            $title = $object1['name'];

            if(!empty($object1['title']))
                $title.=' - '. $object1['title'];

            $keywords = '';

            $description = lang('field_travel_articles_in', $object1['name']);
            $robots = 'index,nofollow';
            break;

        case DESTINATION_INFORMATION_PAGE:
            $title = $object2['name'].' of '.$object1['name'];
            $keywords = "";
            $description = $object2['name'];
            $robots = 'index,nofollow';
            break;

        case ABOUT_US_PAGE:
            $title          = lang('about_title');
            $keywords       = '';
            $description    = '';
            $robots         = 'index, follow';
            break;
        case REGISTRATION_PAGE:
            $title          = lang('registration_title');
            $keywords       = '';
            $description    = '';
            $robots         = 'index, follow';
            break;
        case CONTACT_US_PAGE:
            $title          = lang('contact_title');
            $keywords       = '';
            $description    = '';
            $robots         = 'index, follow';
            break;

        case POLICY_PAGE:
            $title          = lang('policy_title');
            $keywords       = '';
            $description    = '';
            $robots         = 'index, follow';
            break;
        case PRIVACY_PAGE:
            $title          = lang('privacy_title');
            $keywords       = '';
            $description    = '';
            $robots         = 'index, follow';
            break;
        case OUR_TEAM_PAGE:
            $title          = lang('meet_our_team');
            $keywords       = '';
            $description    = '';
            break;
        case MY_BOOKING_PAGE:
            $title = lang('label_my_booking');
            break;
        case SUBMIT_BOOKING_PAGE:
            $title = lang('submit_booking');
            break;
        case CUSTOMIZE_TOUR_PAGE:
            $title = lang('title_customize_tour');
            break;
        case THANK_YOU_PAGE:
            $title = lang('thank_you_after_booking');
            break;
        case BOOK_TOGETHER_PAGE:
        	$title = lang('book_travel_sevices_together');
        	$keywords 		= lang('home_keywords');
        	$description 	= lang('home_description');
        	$robots 		= 'noindex,nofollow';
        	break;

        case DEAL_OFFER_PAGE:
            $title = lang('deals_title');
            $keywords 		= lang('deals_keywords');
            $description 	= lang('deals_description');
            $robots 		= 'index,follow';
            break;
            
        case ADVERTISING_PROMOTION_ADS_PAGE:
            $title = lang('promotion_ads_title');
            $keywords 		= '';
            $description 	= '';
            $robots 		= 'index,follow';
            break;
            
        case HALONG_CRUISE_PAGE:
            $title          = lang('halongbaycruises_title');
            $keywords 		= lang('halongbaycruises_keywords');
            $description 	= lang('halongbaycruises_description');
            break;
            
        case LUXURY_HALONG_CRUISE_PAGE:
            $title          = lang('luxuryhalongcruises_title');
            $keywords 		= lang('luxuryhalongcruises_keywords');
            $description 	= lang('luxuryhalongcruises_description');
            break;
            
        case DELUXE_HALONG_CRUISE_PAGE:
            $title          = lang('deluxehalongcruises_title');
            $keywords 		= lang('deluxehalongcruises_keywords');
            $description 	= lang('deluxehalongcruises_description');
            break;
            
        case CHEAP_HALONG_CRUISE_PAGE:
            $title          = lang('cheaphalongcruises_title');
            $keywords 		= lang('cheaphalongcruises_keywords');
            $description 	= lang('cheaphalongcruises_description');
            break;
            
        case CHARTER_HALONG_CRUISE_PAGE:
            $title          = lang('privatehalongcruises_title');
            $keywords 		= lang('privatehalongcruises_keywords');
            $description 	= lang('privatehalongcruises_description');
            break;
            
        case DAY_HALONG_CRUISE_PAGE:
            $title          = lang('halongbaydaycruises_title');
            $keywords 		= lang('halongbaydaycruises_keywords');
            $description 	= lang('halongbaydaycruises_description');
            break;
            
        case FAMILY_HALONG_CRUISE_PAGE:
            $title          = lang('halongfamilycruises_title');
            $keywords 		= lang('halongfamilycruises_keywords');
            $description 	= lang('halongfamilycruises_description');
            break;
            
        case HONEY_MOON_HALONG_CRUISE_PAGE:
            $title          = lang('halonghoneymooncruises_title');
            $keywords 		= lang('halonghoneymooncruises_keywords');
            $description 	= lang('halonghoneymooncruises_description');
            break;
            
        case MEKONG_CRUISE_PAGE:
            $title          = lang('mekongrivercruises_title');
            $keywords 		= lang('mekongrivercruises_keywords');
            $description 	= lang('mekongrivercruises_description');
            break;
            
        case VIETNAM_CAMBODIA_CRUISE_PAGE:
            $title          = lang('mekongcruisesvietnamcambodia_title');
            $keywords 		= lang('mekongcruisesvietnamcambodia_keywords');
            $description 	= lang('mekongcruisesvietnamcambodia_description');
            break;
            
        case VIETNAM_CRUISE_PAGE:
            $title          = lang('mekongcruisesvietnam_title');
            $keywords 		= lang('mekongcruisesvietnam_keywords');
            $description 	= lang('mekongcruisesvietnam_description');
            break;
            
        case LAOS_CRUISE_PAGE:
            $title          = lang('mekongcruiseslaos_title');
            $keywords 		= lang('mekongcruiseslaos_keywords');
            $description 	= lang('mekongcruiseslaos_description');
            break;
            
        case THAILAND_CRUISE_PAGE:
            $title          = lang('mekongcruisesthailand_title');
            $keywords 		= lang('mekongcruisesthailand_keywords');
            $description 	= lang('mekongcruisesthailand_description');
            break;
            
        case BURMA_CRUISE_PAGE:
            $title          = lang('mekongcruisesburma_title');
            $keywords 		= lang('mekongcruisesburma_keywords');
            $description 	= lang('mekongcruisesburma_description');
            break;
            
        case LUXURY_MEKONG_CRUISE_PAGE:
            $title          = lang('luxurymekongcruises_title');
            $keywords 		= lang('luxurymekongcruises_keywords');
            $description 	= lang('luxurymekongcruises_description');

            break;
            
        case DELUXE_MEKONG_CRUISE_PAGE:
            $title          = lang('deluxemekongcruises_title');
            $keywords 		= lang('deluxemekongcruises_keywords');
            $description 	= lang('deluxemekongcruises_description');
            break;
            
        case CHEAP_MEKONG_CRUISE_PAGE:
            $title          = lang('cheapmekongcruises_title');
            $keywords 		= lang('cheapmekongcruises_keywords');
            $description 	= lang('cheapmekongcruises_description');
            break;
            
        case PRIVATE_MEKONG_CRUISE_PAGE:
            $title          = lang('privatemekongcruises_title');
            $keywords 		= lang('privatemekongcruises_keywords');
            $description 	= lang('privatemekongcruises_description');
            break;
            
        case DAY_MEKONG_CRUISE_PAGE:
            $title          = lang('mekongriverdaycruises_title');
            $keywords 		= lang('mekongriverdaycruises_title');
            $description 	= lang('mekongriverdaycruises_title');
            break;
            
        case CRUISE_DETAIL_PAGE:
            
            if($object1['cruise_destination'] == HALONG_CRUISE_DESTINATION) {
                $title = $object1['name'] . ' ' . lang('halong_bay');
            } else {
                $title = $object1['name'];
            }
            
            $title = str_replace('%s', $title, stripcslashes(lang('cruise_detail_title')));
            
            if($object1['cruise_destination'] == HALONG_CRUISE_DESTINATION) {
                $keywords = lang_arg('cruise_halong_detail_keywords', $object1['name'], $object1['name']);
            } else {
                $keywords = $object1['name'];
            }
            
            $description = lang_arg('cruise_detail_description', $object1['name'], $object1['name']);
            
            if ($object1['cruise_destination'] == MEKONG_CRUISE_DESTINATION && strpos($object1['name'], 'Mekong') === false){ // mekong
                
                $description = lang_arg('cruise_mekong_detail_description', $object1['name'], $object1['name']);
                
            } elseif( strpos($object1['name'], 'Halong' === false) ) {
            
                $description = lang_arg('cruise_halong_detail_description', $object1['name'], $object1['name']);

            }
            
            $description = str_replace("&#8230;", "", strip_tags($description));
            
            $link_params = $CI->input->get();
            
            if(!empty($link_params) || !empty($review_tab)){
            	$canonical = '<link rel="canonical" href="' . get_page_url(CRUISE_DETAIL_PAGE, $object1) . '"/>';
            }
            
            break;
            
        case CRUISE_REVIEW_PAGE:
            
            $title = "";
            
            $description = $object1['name'];
            
            if ($object1['cruise_destination'] == MEKONG_CRUISE_DESTINATION){ // mekong
            
                $title = $object1['name'].' '.ucfirst(lang('review'));
            
            } else {
            
                $title = $object1['name'].' '.lang('halong_bay').' '.ucfirst(lang('review'));
            
                $description .= ' '.lang('halong_bay');
            
            }
            
            $keywords = $title;
            
            $description = lang_arg('cruise_reviews_description', $description, str_replace("%", $object1['name'], lang('customer_review_description')));
            
            break;
            
        case PAYMENT_SUCCESS_PAGE:
            $title = lang('payment_page_header');
            $robots 		= 'noindex,nofollow';
            break;
        case PAYMENT_PENDING_PAGE:
            $title = lang('payment_pending_header');
            $robots 		= 'noindex,nofollow';
            break;
        case PAYMENT_UNSUCCESS_PAGE:
            $title = lang('payment_declined_header');
            $robots 		= 'noindex,nofollow';
            break;

        default:
            $title 			= lang('home_title');
            $keywords 		= lang('home_keywords');
            $description 	= lang('home_description');
            $robots 		= 'noindex,nofollow';
    }

    $header_meta['title'] 		= $title;
    $header_meta['title'] .= ' - ' . BRANCH_NAME;

    $header_meta['keywords'] 	= $keywords;
    $header_meta['description'] = $description;
    $header_meta['robots'] 		= $robots;
    $header_meta['canonical'] 	= $canonical;

    return $header_meta;
}

/**
 * Khuyenpv Feb 27 2015
 * Get Navigation to each Page
 */
function get_page_navigation($data, $is_mobile, $page){

    $CI =& get_instance();

    if(!$is_mobile){
    	
    	$view_data['page'] = $page;

        $view_data['navigations'] = get_page_navigation_links($data, $page);

        if(!empty($data['main_header_title']))
        {
            $view_data['main_header_title'] = $data['main_header_title'];
        }

        $data['page_navigation'] = $CI->load->view('common/navigation/page_navigation', $view_data, TRUE);

    } else {

        $data['page_navigation'] = '';
    }

    return $data;
}

/**
 * Khuyenpv March 09 2015
 * Get Navigation Links by each page
 *
 * Return an array of link object: title & link
 */
function get_page_navigation_links($data, $page)
{
    $CI =& get_instance();

    $navigations = array();

    switch ($page)
    {
        case HOME_PAGE:

            $link['title'] = lang('home');
            $link['link'] = site_url();

            $navigations[] = $link;
            break;

        case VN_TOUR_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('tour_home_navigation');
            $link['link'] = get_page_url(VN_TOUR_PAGE);

            $navigations[] = $link;
            break;

        case TOURS_BY_DESTINATION_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            if (! empty($data['destination']))
            {
                $link['title'] = lang_arg('breadcrumb_tour_destination', $data['destination']['name']);
                $link['link'] = get_page_url(TOURS_BY_DESTINATION_PAGE, $data['destination']);

                $parent_des = $CI->Destination_Model->get_parent_destinations($data['destination']['id']);

                foreach ($parent_des as $des)
                {
                    $parent_link['title'] = lang_arg('breadcrumb_tour_destination', $des['name']);

                    if ($des['id'] == VIETNAM)
                    { // Vietnam
                        $parent_link['link'] = get_page_url(VN_TOUR_PAGE);
                    } else {
                        $parent_link['link'] = get_page_url(TOURS_BY_DESTINATION_PAGE, $des);
                    }

                    $navigations[] = $parent_link;
                }

                $navigations[] = $link;
            }

            break;

        case TOURS_BY_TRAVEL_STYLE_PAGE:

            $navigations = get_page_navigation_links($data, TOURS_BY_DESTINATION_PAGE);

            if (! empty($data['destination']) && !empty($data['travel_style']))
            {
                $destination_name = stripos($data['travel_style']['name'], $data['destination']['name']) === false ? $data['destination']['name'] .' ' : '';

                if (is_symnonym_words($data['travel_style']['name']))
                {
                    if(is_best_of_destination($data['destination'], $data['travel_style'])) {
                        $link['title'] = $data['travel_style']['name'];
                    } else {
                        $link['title'] = $destination_name . $data['travel_style']['name'];
                    }

                }
                else
                {
                    if(is_best_of_destination($data['destination'], $data['travel_style'])) {
                        $link['title'] = lang_arg('breadcrumb_tour_destination', $data['travel_style']['name']);
                    } else {
                        $link['title'] = lang_arg('breadcrumb_tour_destination', $destination_name . $data['travel_style']['name']);
                    }
                }

                $navigations[] = $link;
            }

            break;

        case VN_HOTEL_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('hotel_home');
            $link['link'] = get_page_url(VN_HOTEL_PAGE);

            $navigations[] = $link;
            break;


        case HOTELS_BY_DESTINATION_PAGE:
            $navigations = get_page_navigation_links($data, VN_HOTEL_PAGE);

            $link['title'] = lang('hotel_last_url_title', $data['destination']['name']);
            $link['link'] = get_page_url(HOTELS_BY_DESTINATION_PAGE, $data['destination']);

            $navigations[] = $link;
            break;
        case HOTEL_DETAIL_PAGE:
            $navigations = get_page_navigation_links($data, HOTELS_BY_DESTINATION_PAGE);

            $link['title'] = $data['hotel']['name'];
            $link['link'] = get_page_url(HOTEL_DETAIL_PAGE, $data['hotel']);

            $navigations[] = $link;
            break;
        case HOTEL_REVIEW_PAGE:
        	$navigations = get_page_navigation_links($data, HOTEL_DETAIL_PAGE);
        	
        	$link['title'] = lang('reviews');
        	$link['link'] = get_page_url(HOTEL_REVIEW_PAGE, $data['hotel']);
        	
        	$navigations[] = $link;
        	break;

        case HOTEL_SEARCH_PAGE:
            $navigations = get_page_navigation_links($data, VN_HOTEL_PAGE);

            $link['title'] = lang('field_search_results');
            $link['link'] = get_page_url(HOTEL_SEARCH_PAGE);

            $navigations[] = $link;
            break;

        case HOTEL_SEARCH_EMPTY_PAGE:
            $navigations = get_page_navigation_links($data, VN_HOTEL_PAGE);

            $link['title'] = lang('field_search_results');
            $link['link'] = get_page_url(HOTEL_SEARCH_EMPTY_PAGE);

            $navigations[] = $link;
            break;

        case HOTEL_BOOKING_PAGE:

            $navigations = get_page_navigation_links($data, HOTEL_DETAIL_PAGE);

            $link['title'] = lang('extra_services');
            $link['link'] = get_page_url(HOTEL_BOOKING_PAGE, $data['hotel']);

            $navigations[] = $link;

            break;

        case HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('halongbaycruises');

            $link['link'] = get_page_url(HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case LUXURY_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('luxuryhalongcruises');

            $link['link'] = get_page_url(LUXURY_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DELUXE_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('deluxehalongcruises');

            $link['link'] = get_page_url(DELUXE_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case CHEAP_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('cheaphalongcruises');

            $link['link'] = get_page_url(CHEAP_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case CHARTER_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('privatehalongcruises');

            $link['link'] = get_page_url(CHARTER_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DAY_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('halongbaydaycruises');

            $link['link'] = get_page_url(DAY_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case FAMILY_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('familyhalongcruises');

            $link['link'] = get_page_url(FAMILY_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case HONEY_MOON_HALONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('honeymoonhalongcruises');

            $link['link'] = get_page_url(HONEY_MOON_HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case HALONG_BAY_BIG_SIZE_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('halongbigsizecruises');

            $link['link'] = get_page_url(HALONG_BAY_BIG_SIZE_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('halongmediumsizecruises');

            $link['link'] = get_page_url(HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case HALONG_BAY_SMALL_SIZE_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HALONG_CRUISE_PAGE);

            $link['title'] = lang('halongsmallsizecruises');

            $link['link'] = get_page_url(HALONG_BAY_SMALL_SIZE_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('mekongrivercruises');

            $link['link'] = get_page_url(HALONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case VIETNAM_CAMBODIA_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('mekongcruisesvietnamcambodia');

            $link['link'] = get_page_url(VIETNAM_CAMBODIA_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case VIETNAM_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('mekongcruisesvietnam');

            $link['link'] = get_page_url(VIETNAM_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case LAOS_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('mekongcruiseslaos');

            $link['link'] = get_page_url(LAOS_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case THAILAND_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('mekongcruisesthailand');

            $link['link'] = get_page_url(THAILAND_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case BURMA_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('mekongcruisesburma');

            $link['link'] = get_page_url(BURMA_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case LUXURY_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_luxury_mekong_cruises');

            $link['link'] = get_page_url(LUXURY_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DELUXE_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_deluxe_mekong_cruises');

            $link['link'] = get_page_url(DELUXE_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DELUXE_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_deluxe_mekong_cruises');

            $link['link'] = get_page_url(DELUXE_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case CHEAP_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_cheap_mekong_cruises');

            $link['link'] = get_page_url(CHEAP_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case PRIVATE_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_private_mekong_cruises');

            $link['link'] = get_page_url(PRIVATE_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DAY_MEKONG_CRUISE_PAGE:
            $navigations = get_page_navigation_links($data, MEKONG_CRUISE_PAGE);

            $link['title'] = lang('label_mekong_day_cruises');

            $link['link'] = get_page_url(DAY_MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case DEAL_OFFER_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('deals');

            $link['link'] = get_page_url(DEAL_OFFER_PAGE);

            $navigations[] = $link;
            break;

        case FAQ_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('label_faq');

            $link['link'] = get_page_url(MEKONG_CRUISE_PAGE);

            $navigations[] = $link;
            break;

        case FAQ_CATEGORY_PAGE:
            $navigations = get_page_navigation_links($data, FAQ_PAGE);

            $link['title'] = $data['category']['name'];

            $link['link'] = get_page_url(FAQ_CATEGORY_PAGE, $data['category']);

            $navigations[] = $link;
            break;

        case FAQ_DESTINATION_PAGE:
            $navigations = get_page_navigation_links($data, FAQ_PAGE);

            $link['title'] = $data['destination']['name'];

            $link['link'] = get_page_url(FAQ_DESTINATION_PAGE,$data['destination']);

            $navigations[] = $link;
            break;

        case FAQ_DETAIL_PAGE:
            $navigations = get_page_navigation_links($data, FAQ_CATEGORY_PAGE);

            $link['title'] = $data['question']['question'];

            $link['link'] = $data['question'];

            $navigations[] = $link;

            break;

        case DESTINATION_DETAIL_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            if (! empty($data['destination']))
            {

                $parent_des = $CI->Destination_Model->get_parent_destinations($data['destination']['id']);

                foreach ($parent_des as $des)
                {
                    $parent_link['title'] = $des['name'];

                    $parent_link['link'] = get_page_url(DESTINATION_DETAIL_PAGE, $des);


                    $navigations[] = $parent_link;
                }

                $link['title'] = $data['destination']['name'];
                $link['link']  = get_page_url(DESTINATION_DETAIL_PAGE, $data['destination']);

                $navigations[] = $link;
            }

            break;
        case DESTINATION_THINGS_TO_DO_PAGE:
            $navigations = get_page_navigation_links($data, DESTINATION_DETAIL_PAGE);

            $link['title'] = lang('field_thing_to_do');
            $link['link'] = get_page_url(DESTINATION_THINGS_TO_DO_PAGE, $data['destination']);

            $navigations[] = $link;
            break;

        case DESTINATION_ATTRACTION_PAGE:
            $navigations = get_page_navigation_links($data, DESTINATION_DETAIL_PAGE);

            $link['title'] = lang('field_attractions');
            $link['link'] = get_page_url(DESTINATION_ATTRACTION_PAGE, $data['destination']);

            $navigations[] = $link;
            break;

        case DESTINATION_INFORMATION_PAGE:
            $navigations = get_page_navigation_links($data, DESTINATION_DETAIL_PAGE);

            $link['title'] = $data['useful_information']['name'];
            $link['link'] = get_page_url(DESTINATION_INFORMATION_PAGE, $data['destination'], $data['useful_information']);

            $navigations[] = $link;
            break;

        case DESTINATION_ARTICLE_PAGE:
            $navigations = get_page_navigation_links($data, DESTINATION_DETAIL_PAGE);

            $link['title'] = lang('field_travel_articles');
            $link['link'] = get_page_url(DESTINATION_ARTICLE_PAGE, $data['destination']);

            $navigations[] = $link;
            break;

        case DESTINATION_ARTICLE_DETAIL_PAGE:
            $navigations = get_page_navigation_links($data, DESTINATION_ARTICLE_PAGE);

            $link['title'] = $data['article']['name'];
            $link['link'] = get_page_url(DESTINATION_ARTICLE_PAGE, $data['article']);

            $navigations[] = $link;
            break;

        case TOUR_SEARCH_PAGE:
        case TOUR_SEARCH_EMPTY_PAGE:

            $search_criteria = $data['search_criteria'];

            if(!empty($search_criteria['destination']) && !empty($search_criteria['destination_id'])){

                $destination['name'] = $search_criteria['destination'];

                $destination['id'] = $search_criteria['destination_id'];

                $destination['url_title'] = url_title($destination['name']);

                $nav_data['destination'] = $destination;

                $navigations = get_page_navigation_links($nav_data, TOURS_BY_DESTINATION_PAGE);
            } else {
                $navigations = get_page_navigation_links($data, VN_TOUR_PAGE);
            }

            $link['title'] = lang('search_results');
            $link['link'] = get_page_url($page, $search_criteria);

            $navigations[] = $link;

            break;

        case CRUISE_DETAIL_PAGE:
        	
            $cruise = $data['cruise'];

            $parent_page = $cruise['cruise_destination'] == 0 ? HALONG_CRUISE_PAGE : MEKONG_CRUISE_PAGE;

            $navigations = get_page_navigation_links($data, $parent_page);

            $link['title'] = $cruise['name'];
            $link['link'] = get_page_url(CRUISE_DETAIL_PAGE, $cruise);

            $navigations[] = $link;
            break;
        case CRUISE_REVIEW_PAGE:
        	$cruise = $data['cruise'];
        	$navigations = get_page_navigation_links($data, CRUISE_DETAIL_PAGE);
        	
        	$link['title'] = lang('reviews');
        	$link['link'] = get_page_url(CRUISE_REVIEW_PAGE, $cruise);
        	
        	$navigations[] = $link;
        	
         	break;
         	
        case TOUR_DETAIL_PAGE:

            $tour = $data['tour'];

            $parent_page = !empty($data['cruise']) ? CRUISE_DETAIL_PAGE : TOURS_BY_DESTINATION_PAGE;

            $navigations = get_page_navigation_links($data, $parent_page);

            $link['title'] = $tour['name'];
            $link['link'] = get_page_url(TOUR_DETAIL_PAGE, $tour);

            $navigations[] = $link;

            break;
        case TOUR_BOOKING_PAGE:

            $tour = $data['tour'];

            $navigations = get_page_navigation_links($data, TOUR_DETAIL_PAGE);

            $link['title'] = lang('extra_services');
            $link['link'] = get_page_url(TOUR_BOOKING_PAGE, $tour);

            $navigations[] = $link;

            break;

        case VN_VISA_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('visa_navigation');
            $link['link'] = get_page_url(VN_VISA_PAGE);

            $navigations[] = $link;
            break;

        case VN_VISA_FOR_CITIZENS_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang_arg('visa_for_citizens_navigation', ucfirst($data['country']['name']));
            $link['link'] = get_page_url(VN_VISA_FOR_CITIZENS_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_FEES_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('visa_fees');
            $link['link'] = get_page_url(VN_VISA_FEES_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_REQUIREMENTS_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('visa_requirements');
            $link['link'] = get_page_url(VN_VISA_REQUIREMENTS_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_ON_ARRIVAL_PAGE:
            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('vietnam_visa');
            $link['link'] = get_page_url(VN_VISA_ON_ARRIVAL_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_HOW_TO_APPLY_PAGE:
            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('how_to_apply_navigation');
            $link['link'] = get_page_url(VN_VISA_HOW_TO_APPLY_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_APPLY_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('apply_visa');
            $link['link'] = get_page_url(VN_VISA_APPLY_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_DETAILS_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_APPLY_PAGE);

            $link['title'] = lang('visa_details');
            $link['link'] = get_page_url(VN_VISA_DETAILS_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_PAYMENT_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_DETAILS_PAGE);

            $link['title'] = lang('visa_payment');
            $link['link'] = get_page_url(VN_VISA_PAYMENT_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_APPLICATION_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('visa_application');
            $link['link'] = get_page_url(VN_VISA_APPLICATION_PAGE);
            $navigations[] = $link;
            break;


        case VN_VISA_EMBASSIES_WORLDWIDE_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('vietnam_embassies_worldwide');
            $link['link'] = get_page_url(VN_VISA_EMBASSIES_WORLDWIDE_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_AVAILABILITY_FEE_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('vietnam_visa_pricing_service');
            $link['link'] = get_page_url(VN_VISA_AVAILABILITY_FEE_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_EXEMPTION_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('vietnam_visa_exemption');
            $link['link'] = get_page_url(VN_VISA_EXEMPTION_PAGE);
            $navigations[] = $link;
            break;

        case VN_VISA_TYPES_PAGE:

            $navigations = get_page_navigation_links($data, VN_VISA_PAGE);

            $link['title'] = lang('vietnam_visa_types');
            $link['link'] = get_page_url(VN_VISA_TYPES_PAGE);
            $navigations[] = $link;
            break;

        case ABOUT_US_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('about_title');
            $link['link'] = get_page_url(ABOUT_US_PAGE);

            $navigations[] = $link;

            break;

        case REGISTRATION_PAGE:
            $navigations = get_page_navigation_links($data, ABOUT_US_PAGE);

            $link['title'] = lang('registration_title');
            $link['link'] = get_page_url(REGISTRATION_PAGE);

            $navigations[] = $link;
            break;

        case POLICY_PAGE:
            $navigations = get_page_navigation_links($data, ABOUT_US_PAGE);

            $link['title'] = lang('tpc_terms_conditions');
            $link['link'] = get_page_url(POLICY_PAGE);

            $navigations[] = $link;
            break;

        case PRIVACY_PAGE:
            $navigations = get_page_navigation_links($data, ABOUT_US_PAGE);

            $link['title'] = lang('privacy_title');
            $link['link'] = get_page_url(PRIVACY_PAGE);

            $navigations[] = $link;
            break;

        case OUR_TEAM_PAGE:
            $navigations = get_page_navigation_links($data, ABOUT_US_PAGE);

            $link['title'] = lang('meet_our_team');
            $link['link'] = get_page_url(OUR_TEAM_PAGE);

            $navigations[] = $link;
            break;

        case CONTACT_US_PAGE:
            $navigations = get_page_navigation_links($data, ABOUT_US_PAGE);

            $link['title'] = lang('ctu_contact_us');
            $link['link'] = get_page_url(CONTACT_US_PAGE);

            $navigations[] = $link;
            break;

        case MY_BOOKING_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('mybooking');
            $link['link'] = get_page_url(MY_BOOKING_PAGE);

            $navigations[] = $link;

            break;

        case SUBMIT_BOOKING_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('submit_booking');
            $link['link'] = get_page_url(SUBMIT_BOOKING_PAGE);

            $navigations[] = $link;

            break;

        case CUSTOMIZE_TOUR_PAGE:
            $navigations = get_page_navigation_links($data, VN_TOUR_PAGE);

            $link['title'] = lang('nav_tailor_make_a_tour');
            $link['link'] = get_page_url(CUSTOMIZE_TOUR_PAGE);

            $navigations[] = $link;
            break;

        case THANK_YOU_PAGE:

            $navigations = get_page_navigation_links($data, HOME_PAGE);

            $link['title'] = lang('thank_you_after_booking');
            $link['link'] = get_page_url(THANK_YOU_PAGE);

            $navigations[] = $link;

            break;

        case BOOK_TOGETHER_PAGE:

        	$navigations = get_page_navigation_links($data, HOME_PAGE);

        	$link['title'] = $data['title_service_name'];
        	$link['link'] = get_page_url(BOOK_TOGETHER_PAGE);

        	$navigations[] = $link;

        	break;
        case VN_FLIGHT_PAGE:

        	$navigations = get_page_navigation_links($data, HOME_PAGE);

        	$link['title'] = lang('vietnam_flights');
        	$link['link'] = get_page_url(VN_FLIGHT_PAGE);

        	$navigations[] = $link;
        	break;

        case FLIGHT_SEARCH_PAGE:

        	$navigations = get_page_navigation_links($data, VN_FLIGHT_PAGE);

        	$link['title'] = lang('flights_search_result');
        	$link['link'] = get_page_url(FLIGHT_SEARCH_PAGE);

        	$navigations[] = $link;
        	break;
        case FLIGHT_PASSENGER_PAGE:
        	$navigations = get_page_navigation_links($data, VN_FLIGHT_PAGE);

        	$link['title'] = lang('flights_search_passenger');
        	$link['link'] = get_page_url(FLIGHT_PASSENGER_PAGE);

        	$navigations[] = $link;
        	break;

        case FLIGHT_PAYMENT_PAGE:
        	$navigations = get_page_navigation_links($data, FLIGHT_PASSENGER_PAGE);

        	$link['title'] = lang('flights_search_contact_payment');
        	$link['link'] = get_page_url(FLIGHT_PAYMENT_PAGE);

        	$navigations[] = $link;
        	break;
        case FLIGHT_SEARCH_EXCEPTION_PAGE:
        	$navigations = get_page_navigation_links($data, VN_FLIGHT_PAGE);

        	$link['title'] = 'Flight Exception';//lang('flights_search_contact_payment');
        	$link['link'] = get_page_url(FLIGHT_SEARCH_EXCEPTION_PAGE);

        	$navigations[] = $link;
        	break;
        	
    	case ADVERTISING_PROMOTION_ADS_PAGE:
    	    $navigations = get_page_navigation_links($data, HOME_PAGE);
    	    
    	    $link['title'] = lang('promotion_ads_title');
    	    $link['link'] = '';
    	    
    	    $navigations[] = $link;
    	    break;
    	    
	    case ADVERTISING_BOOK_TOGETHER_PAGE:
	        $navigations = get_page_navigation_links($data, HOME_PAGE);
	        	
	        $link['title'] = lang('book_together_title');
	        $link['link'] = '';
	        	
	        $navigations[] = $link;
	        break;
	        
        case ADVERTISING_FREE_VISA_APPLICABLE_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('free_visa_applicable');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
            
        case ADVERTISING_VISA_FOR_FRIENDS_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('title_visa_for_friends');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
            
        case ADVERTISING_BOOKING_TOGETHER_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('book_together_title');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
            
        case PAYMENT_SUCCESS_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('payment_page_header');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
            
        case PAYMENT_PENDING_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('payment_pending_header');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
            
        case PAYMENT_UNSUCCESS_PAGE:
            $navigations = get_page_navigation_links($data, HOME_PAGE);
        
            $link['title'] = lang('payment_declined_header');
            $link['link'] = '';
        
            $navigations[] = $link;
            break;
    }

    return $navigations;
}


/**
 * Khuyenpv March 09 2015
 * Get page Main Header Title of each page
 */
function get_page_main_header_title($data, $is_mobile, $page){

    $CI =& get_instance();

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    $view_data = array();

    switch ($page) {

        case VN_TOUR_PAGE:
            $view_data['title'] = lang('tour_home');
            $view_data['description'] = lang('tours_desc');
            break;

        case TOURS_BY_DESTINATION_PAGE:
            $view_data['title'] = lang_arg('breadcrumb_tour_destination', $data['destination']['name']);
            $view_data['description'] = !empty($data['destination']['tour_heading']) ? $data['destination']['tour_heading'] : '';
            break;

        case TOURS_BY_TRAVEL_STYLE_PAGE:
            
            if (is_best_of_destination($data['destination'], $data['travel_style']))
            {
                $view_data['title'] = lang_arg('breadcrumb_tour_destination', $data['travel_style']['name']);
            } else {

                // check destination name in travel style
                $destination_name = stripos($data['travel_style']['name'], $data['destination']['name']) === false ? $data['destination']['name'] .' ' : '';

                $view_data['title'] = lang_arg('breadcrumb_tour_destination', $destination_name . $data['travel_style']['name']);

                // check symnonym words in travel style
                if(is_symnonym_words($data['travel_style']['name'])) {
                    $view_data['title'] = $destination_name . $data['travel_style']['name'];
                }
            }
            
            // H1 description priority: Destination Style Desc --> Destination Tour Heading
            $view_data['description'] = !empty($data['travel_style']['destination_style_desc']) ? $data['travel_style']['destination_style_desc'] : '';
            
            $view_data['description'] = empty($view_data['description']) && !empty($data['destination']['tour_heading']) ? $data['destination']['tour_heading'] : $view_data['description'];

            break;

        case VN_HOTEL_PAGE:
            $view_data['title'] = lang('hotel_last_url_title', $data['destination']['name']);
            $view_data['description'] = lang('hotels_desc');
            break;

        case HOTELS_BY_DESTINATION_PAGE:
            $view_data['title'] = lang('hotel_top_recommended', $data['destination']['name']);
            $view_data['description'] = !empty($data['destination']['hotel_heading']) ? $data['destination']['hotel_heading'] : '';
            break;

        case HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('halongbaycruises');
            $view_data['description'] = lang('halong_bay_cruises_desc');
            break;

        case LUXURY_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('luxuryhalongcruises');
            break;

        case DELUXE_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('deluxehalongcruises');
            break;

        case CHEAP_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('cheaphalongcruises');
            break;

        case CHARTER_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('privatehalongcruises');
            break;

        case DAY_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('halongbaydaycruises');
            break;

        case HALONG_BAY_BIG_SIZE_CRUISE_PAGE:
            $view_data['title'] = lang('halongbigsizecruises');
            break;

        case HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE:
            $view_data['title'] = lang('halongmediumsizecruises');
            break;

        case HALONG_BAY_SMALL_SIZE_CRUISE_PAGE:
            $view_data['title'] = lang('halongsmallsizecruises');
            break;

        case FAMILY_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('familyhalongcruises');
            break;

        case HONEY_MOON_HALONG_CRUISE_PAGE:
            $view_data['title'] = lang('honeymoonhalongcruises');
            break;

        case MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('mekongrivercruises');
            $view_data['description'] = lang('mekong_river_cruises_desc');
            break;

        case VIETNAM_CAMBODIA_CRUISE_PAGE:
            $view_data['title'] = lang('mekongcruisesvietnamcambodia');
            $view_data['description'] = lang('desc_vietnam_cambodia_cruises');
            break;

        case VIETNAM_CRUISE_PAGE:
            $view_data['title'] = lang('mekongcruisesvietnam');
            $view_data['description'] = lang('desc_vietnam_mekong_cruises');
            break;

        case LAOS_CRUISE_PAGE:
            $view_data['title'] = lang('mekongcruiseslaos');
            $view_data['description'] = lang('desc_laos_mekong_cruises');
            break;

        case THAILAND_CRUISE_PAGE:
            $view_data['title'] = lang('mekongcruisesthailand');
            break;

        case BURMA_CRUISE_PAGE:
            $view_data['title'] = lang('mekongcruisesburma');
            $view_data['description'] = lang('desc_burma_mekong_cruises');
            break;

        case LUXURY_MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('label_luxury_mekong_cruises');
            $view_data['description'] = lang('desc_luxury_mekong_cruises');
            break;

        case DELUXE_MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('label_deluxe_mekong_cruises');
            break;

        case CHEAP_MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('label_cheap_mekong_cruises');
            break;

        case PRIVATE_MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('label_private_mekong_cruises');
            break;

        case DAY_MEKONG_CRUISE_PAGE:
            $view_data['title'] = lang('label_mekong_day_cruises');
            $view_data['description'] = lang('desc_mekong_day_cruises');
            break;

        case VN_VISA_PAGE:
            $view_data['title'] = lang('vietnam_visa_h1');
            $view_data['description'] = lang('vietnam_visa_summary');
            break;
        case VN_FLIGHT_PAGE:
            $view_data['title'] = lang('vietnam_flights');
            $view_data['description'] = lang('vietnam_flight_desc');
            break;
    }

    if(!$is_mobile) {
        $data['main_header_title'] = $CI->load->view($mobile_folder.'common/navigation/main_header_title', $view_data, TRUE);
    }

    // for rich snippet: toanlk
    $data['rich_snippet_header'] = $view_data;

    return $data;
}

/**
 * Save Each Search Action To History
 *
 * @author Khuyenpv
 * @since Mar 10 2015
 *
 */
function save_search_criteria_history($cookie_name, $search_criteria){

    $CI =& get_instance();

    // get from the session first
    $search_histories = $CI->session->userdata($cookie_name);

    if(empty($search_histories)) $search_histories = array();

    $cnt = count($search_histories);

    if($cnt == 0){

        $search_criteria['timestamp'] = time();

        $search_histories[] = $search_criteria;

    } else {

        $last_search = $search_histories[$cnt-1];
        unset($last_search['timestamp']);

        if(http_build_query($last_search) == http_build_query($search_criteria)){
            $last_search['timestamp'] = time();
            $search_histories[$cnt-1] = $last_search;
        } else {
            $search_criteria['timestamp'] = time();
            $search_histories[] = $search_criteria;
        }
    }

    // only save last 5 search
    $cnt = count($search_histories);
    if($cnt > 5){
        for($i = 0; $i < $cnt - 5; $i++){
            array_shift($search_histories);
        }
    }

    $CI->session->set_userdata($cookie_name, $search_histories);
}

/**
 * Get Last Search in the History
 *
 * @author Khuyenpv
 * @since Mar 11 2015
 *
 */
function get_last_search($cookie_name){
    $CI =& get_instance();

    $search_histories = $CI->session->userdata($cookie_name);

    if(empty($search_histories)){
        return array();
    } else {
        $cnt = count($search_histories);

        return $search_histories[$cnt - 1];
    }
}


/**
 * Get the Image Path of each object
 * @param $use_old_path = true: use the old image system path
 *
 * Khuyenpv March 05 2015
 *
 */
function get_image_path($directory, $image_name, $size = '')
{
    $CI = & get_instance();

    if($size == '') $size = 'origin'; // default for origin image

    if($size == '468_351') $size = 'mediums';

    if($size == '120_90') $size = 'smalls';

    // Resource path

    // $resource_path = 'http://www.bestpricevn.com';
    
    $resource_path = $CI->config->item('resource_path');

    $image_path = $resource_path. '/images/'.$directory.'/'.$size.'/'.$image_name;

    return $image_path;
}

/**
 * Create common paging configuration
 *
 * @author Khuyenpv
 * @since March 12 2015
 */
function create_paging_config($total_rows, $uri, $uri_segment, $paging_cnf = array(), $is_page_query_string = false) {

    $CI =& get_instance();

    $is_mobile = is_mobile();

    $config['base_url'] = $uri;
    $config['total_rows'] = $total_rows;
    $config['uri_segment'] = $uri_segment;

    if(empty($paging_cnf)){
        $config['per_page'] = $CI->config->item('per_page');
        $config['num_links'] = $CI->config->item('num_links');
    } else {
        $config['per_page'] = $paging_cnf['per_page'];
        $config['num_links'] = $paging_cnf['num_links'];
    }

    if($is_page_query_string) {
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
    }


    // for boostrap pagingnation
    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['first_link'] = $CI->lang->line('common_paging_first');
    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = $CI->lang->line('common_paging_last');
    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = $CI->lang->line('common_paging_next');
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = $CI->lang->line('common_paging_previous');
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><span>';
    $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';


    return $config;
}

/**
 * Create common paging text
 *
 * @author Khuyenpv
 * @since March 12 2015
 */

function create_paging_text($total_rows, $offset, $paging_cnf = array()) {
    $CI =& get_instance();

    if(empty($paging_cnf)){
        $per_page = $CI->config->item('per_page');
    } else {
        $per_page = $paging_cnf['per_page'];
    }


    $paging_text = $CI->lang->line('common_paging_display');
    $next_offset = $offset + $per_page;
    if ($next_offset > $total_rows) {
        $next_offset = $total_rows;
    }
    $paging_text .= '&nbsp;' . '<b>'.($offset + 1) . '</b>'
        . '&nbsp;-&nbsp;' . '<b>' . $next_offset . '</b>'
        . '&nbsp;' . $CI->lang->line('common_paging_of') . '&nbsp;'
        . '<b>' . $total_rows . '</b>';
    return $paging_text;
}

/**
 * Check if customer is the list of 'limited promotion viewing or not'
 *
 * @author Khuyenpv 20.03.2015
 */
function is_visitor_in_hanoi(){

	return false; //request from Mr.Dung => don't need to hide the price

    $CI =& get_instance();

    $country_code = '';

    $ip_trace_country_code = $CI->config->item('ip_trace_country_code');

    $ip_trace_city = $CI->config->item('ip_trace_city');

    // if admin login: don't prevent promotion
    $app_context = $CI->session->userdata('APP_CONTEXT');

    if (isset($app_context) && isset($app_context['user'])){
        return false;
    }

    $city = '';

    if ($CI->session->userdata('user_country_code')){

        $country_code = $CI->session->userdata('user_country_code');

        $city =	$CI->session->userdata('user_city');
    }

    // if the user is in Hanoi => only get promotion in Hanoi
    if ($city != '' && count($ip_trace_city) > 0){

        if (in_array($city, $ip_trace_city)){

            return true;

        }

    }

    return false;
}

/**
 * Set type and color seach Autocomplete
 *
 * @author Huutd 15.05.2015
 */
function set_color_des($destinations){

	$return_data = array();

	foreach ($destinations as $destination){

		switch ($destination['destination_type']){

			case DESTINATION_TYPE_CITY:
				$destination['destination_type'] = lang('lbl_city');
				$destination['color'] = '#12a90a';
				break;

			case DESTINATION_TYPE_COUNTRY:
				$destination['destination_type'] = lang('lbl_country');
				$destination['color'] = '#ff8000';
				break;

			case DESTINATION_TYPE_CRUISE:
				$destination['destination_type'] = lang('lbl_cruise') ;
				$destination['color'] = '#0080ff';
				break;

			default: $destination['destination_type'] = 'Place';
					 $destination['color'] = '#ed56da';

		}

		$return_data[] = $destination;
	}
	return $return_data;
}

if(!function_exists('array_column')){
    function array_column($arrs, $colum){
        $ret = array();

        foreach ($arrs as $value){
            $ret[] = $value[$colum];
        }
        return $ret;
    }
}

?>
