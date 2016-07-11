<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Cruise Detail
 *
 *  @author khuyenpv
 *  @since  Feb 04 2015
 */
class Cruise_Detail extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic', 'resource', 'tour', 'tour_rate', 'tour_search','faq', 'hotline','review','recommend', 'cruise'));

        $this->load->model(array('Tour_Model', 'Cruise_Model'));

        $this->load->language(array('cruise', 'tour', 'tourdetail'));

        // for test only
        //$this->output->enable_profiler(TRUE);
    }

    function index($url_title)
    {
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        // set cache html
        set_cache_html();

        $cruise = $this->Cruise_Model->get_cruise_detail($url_title);

        // redirect to homepage if cannot find the destination
        if (empty($cruise))
        {
            redirect(get_page_url(HOME_PAGE), 'location', 301);
        }
        
        // set current menu
        set_current_menu($cruise['cruise_destination'] == MEKONG_CRUISE_DESTINATION ? MNU_MEKONG_CRUISES : MNU_HALONG_CRUISES);

        $cruise['special_offers'] = load_promotion_popup($is_mobile, $cruise['promotions'], TOUR, false, false, true);

        $data['cruise'] = $cruise;

        $data['is_mobile'] = $is_mobile;

        $data['page'] = CRUISE_DETAIL_PAGE;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(CRUISE_DETAIL_PAGE, $cruise);

        $data['page_theme'] = get_page_theme(CRUISE_DETAIL_PAGE, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, CRUISE_DETAIL_PAGE);

        // load the tour search form

        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;

        $data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , true);

        $data = load_why_use($data, $is_mobile);

        $data = load_tripadvisor($data, $is_mobile);

        // load how-to-book a trip
        $data = load_how_to_book_trip($data, $is_mobile);

        // load fag by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HALONG_CRUISE);

        // load cruise header
        $data = $this->_load_cruise_header_area($data, $is_mobile, $cruise);

        // load cruise slider
        $cruise_photos = $this->Cruise_Model->get_cruise_photos($cruise['id']);
        $data = load_photo_slider($data, $is_mobile, $cruise_photos, PHOTO_FOLDER_CRUISE, true);

        $tours = $this->Cruise_Model->get_cruise_tours($cruise['id']);

        // load cruise tab
        $data = $this->_load_cruise_rate_itinerary_facility($data, $is_mobile, $cruise, $tours, $cruise_photos);

        // load cruise tours
        $data = $this->_load_cruise_tours($data, $is_mobile, $tours);

        // load similar cruises
        $data = $this->_load_similar_cruises($data, $is_mobile, $cruise);

        $data = load_top_tour_destinations($data, $is_mobile);
        
        // load cruise header tabs for Mobile
        if ($is_mobile) {
            $activeTab = $this->input->get('activeTab');
            $data['activeTab']  = !empty($activeTab) ? $activeTab : 'tab_check_rates';
            
            $data['cruise_header_tabs'] = $this->load->view('mobile/cruises/detail/cruise_header_tabs', $data, TRUE);
            
            $data['popup_free_visa'] = load_free_visa_popup($is_mobile);
        }

        render_view('cruises/detail/cruise_detail', $data, $is_mobile);
    }

    function review($url_title){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        // set cache html
        set_cache_html();

        // set current menu
        set_current_menu(MNU_HALONG_CRUISES);

        $cruise = $this->Cruise_Model->get_cruise_detail($url_title);

        // redirect to homepage if cannot find the destination
        if (empty($cruise))
        {
            redirect(get_page_url(HOME_PAGE), 'location', 301);
        }

        $data['is_mobile'] = $is_mobile;

        $data['cruise'] = $cruise;

        $data['page'] = CRUISE_REVIEW_PAGE;

        $data['review_page'] = true;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(CRUISE_REVIEW_PAGE, $cruise);

        $data['page_theme'] = get_page_theme(CRUISE_REVIEW_PAGE, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, CRUISE_REVIEW_PAGE);

        // load cruise header
        $data = $this->_load_cruise_header_area($data, $is_mobile, $cruise);

        // load the tour search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
        $data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , true);


        // load how-to-book a trip
        $data = load_how_to_book_trip($data, $is_mobile);

        // load fag by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HALONG_CRUISE);

        // load explore cruising
        //$data = $this->_load_explore_cruising($data, $is_mobile);

        $data = load_customer_reviews($data, $is_mobile, $cruise, CRUISE);

        // load similar cruises
        $data = $this->_load_similar_cruises($data, $is_mobile, $cruise);
        
        // load cruise header tabs for Mobile
        if ($is_mobile) {
            $mobile_folder = $is_mobile ? 'mobile/' : '';
            $data['cruise_header_tabs'] = $this->load->view($mobile_folder . 'cruises/detail/cruise_header_tabs', $data, TRUE);
        }

        render_view('cruises/detail/cruise_review', $data, $is_mobile);
    }

    /**
     * load_cruise_summary
     *
     * @author toanlk
     * @since  Apr 29, 2015
     */
    function load_cruise_summary($data, $is_mobile)
    {
        $cruise_summary = '';

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $cruise_properties = $this->Cruise_Model->get_cruise_member_properties($data['cruise']['id']);

        if (! empty($cruise_properties))
        {
            $properties = array();

            foreach ($cruise_properties as $property) {
                foreach ($property as $value) {
                    if($value['cruise_property_id'] == 1) {
                        $properties['since'] = $value['value'];
                    } elseif($value['cruise_property_id'] == 476) {
                        $properties['materials'] = $value['value'];
                    }
                }
            }

            if($data['cruise']['cruise_destination'] == HALONG_CRUISE_DESTINATION) {
                $properties['destination'] = lang('label_halong_bay');
            } else {
                $mekong_destination = array(6, 7, 8, 9, 10);

                foreach ($mekong_destination as $value)
                {
                    if (is_bit_value_contain($data['cruise']['types'], $value))
                    {
                        switch ($value) {
                            case 6:
                                $properties['destination'] = lang('vietnam_cambodia');
                                break;
                            case 7:
                                $properties['destination'] = lang('vietnam');
                                break;
                            case 8:
                                $properties['destination'] = lang('laos');
                                break;
                            case 9:
                                $properties['destination'] = lang('thailand');
                                break;
                            case 10:
                                $properties['destination'] = lang('burma');
                                break;
                        }
                    }
                }
            }


            $data['cruise_properties'] = $properties;

            $cruise_summary  = $this->load->view($mobile_folder . 'cruises/detail/cruise_summary', $data, TRUE);
        }

        $data['cruise_summary'] = $cruise_summary;

        return $data;
    }

    /**
     * Khuyenpv Feb 27 2015
     * Load Explore Cruising
     */
    function _load_explore_cruising($data, $is_mobile){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $data['explore_cruising'] = $this->load->view($mobile_folder.'cruises/detail/explore_cruising', $data, TRUE);

        return $data;
    }

    /**
     * Khuyenpv Feb 27 2015
     * Load tour-header area: name, destination, review, price & offer
     */
    function _load_cruise_header_area($data, $is_mobile, $cruise){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $review_link = get_page_url(CRUISE_REVIEW_PAGE, $cruise);

        // load review overview
        $rich_snippet = array(
            'name'     => $cruise['name'],
            'photo'    => get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture']) // small photo
        );
        
        $data = load_review_overview($data, $is_mobile, $cruise['review_score'], $cruise['review_number'], $review_link, $rich_snippet);

        $data['cruise_header'] = $this->load->view($mobile_folder.'cruises/detail/cruise_header', $data, TRUE);

        return $data;
    }

    /**
     * Khuyenpv Feb 28 2015
     * Load cruise tab
     */
    function _load_cruise_rate_itinerary_facility($data, $is_mobile, $cruise, $tours, $cruise_photos){

        $selected_tour = $this->_get_selected_tour($tours);

        $data['form_action'] = get_page_url(CRUISE_DETAIL_PAGE, $cruise);
        $data = load_tour_check_rate_form($data, $is_mobile, $selected_tour, $tours);

        $data = load_tour_rate_table($data, $is_mobile, $selected_tour);

        $data = load_tour_booking_conditions($data, $is_mobile, $selected_tour);
		
        // only load service recommendation when the customer click on 'Check-Rates' button
        $check_rates = get_tour_check_rate_from_url($selected_tour);
        
        if(!empty($check_rates) && !$is_mobile){
            
        	$current_item_info = get_current_tour_booking_info($selected_tour, $data['discount_together']);
        	
        	$data = load_service_recommendation($data, $is_mobile, $current_item_info);
        	
        	// load the extra-saving recommend
        	$data = load_extra_saving_recommendation($data, $is_mobile);
        }
        
        // load cruise videos
        $data = $this->_load_cruise_videos($data, $is_mobile, $cruise);

        // load list of cruise photos
        $data = load_photo_list($data, $is_mobile, $cruise_photos, PHOTO_FOLDER_CRUISE, $data['cruise']['name']);

        // load cruise facilites
        $data = $this->_load_cruise_itineraries($data, $is_mobile, $tours);

        // load cruise policies
        $data = $this->_load_cruise_policies($data, $is_mobile, $cruise, $selected_tour);

        // load cruise facilities
        $data = $this->_load_cruise_faclilities($data, $is_mobile, $cruise);

        // load cruise resources
        $file = $this->_get_file_cruise_resource($cruise);

        $title = lang('label_cruise_resources_for_download');

        $data['cruise_resources'] = load_download_resources($is_mobile, $title, $file);

        $data['cruise_tab'] = load_view('cruises/detail/cruise_tab', $data, $is_mobile);

        return $data;
    }

    /**
     * TinVM 15.04.2015
     * Get File Cruise resource
     */

    function _get_file_cruise_resource($cruise){

        $upload_files = $this->Cruise_Model->get_cruise_files($cruise['id']);

        foreach($upload_files as $key=>$value){

            $upload_files[$key]['service'] = 'cruises';

        }

        return $upload_files;
    }

    /**
     * Khuyenpv Feb 28 2015
     * Load Cruise Tours View
     */
    function _load_cruise_tours($data, $is_mobile, $tours)
    {
        $mobile_folder = $is_mobile ? 'mobile/' : '';

        if (count($tours) > 0)
        {
            $view_data = load_list_tours_compact(array(), $is_mobile, $tours);
            
            $view_data['cruise'] = $data['cruise'];
          
            $data['cruise_tours'] = $this->load->view($mobile_folder . 'cruises/detail/cruise_tours', $view_data, TRUE);
            
            $view_data['tours'] = $tours;
            
            if(!$is_mobile) {
                $data['cruise_tours_side'] = $this->load->view($mobile_folder . 'cruises/detail/cruise_tours_side', $view_data, TRUE);
            }
        }
        else
        {
            $data['cruise_tours'] = '';
            
            $data['cruise_tours_side'] = '';
        }

        return $data;
    }

    /**
     * Khuyenpv March 03 2015
     * Load Cruise Videos
     */
    function _load_cruise_videos($data, $is_mobile, $cruise){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $data['cruise_videos'] = $this->load->view($mobile_folder.'cruises/detail/cruise_videos', $data, TRUE);

        return $data;
    }

    /**
     * Load Similar Cruises
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function _load_similar_cruises($data, $is_mobile, $cruise)
    {
        $similar_title = '';
        $similar_cruises  = '';
        $similar_cruises_side = '';
        $more_cruise_text = '';
        $more_cruise_link = '';

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $view_data['cruises'] = $this->Cruise_Model->get_similar_cruises($cruise);

        if (! empty($view_data['cruises']))
        {
            $budget = '';

            if($cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION) {

                if (in_array($cruise['star'], array(5,4.5))){
                    $budget = lang('lbl_luxury');
                    $more_cruise_text = lang('more_luxury_halong_cruises');
                    $more_cruise_link = get_page_url(LUXURY_HALONG_CRUISE_PAGE);
                } elseif (in_array($cruise['star'], array(4,3.5))){
                    $budget = lang('lbl_mid_range');
                    $more_cruise_text = lang('more_deluxe_halong_cruises');
                    $more_cruise_link = get_page_url(DELUXE_HALONG_CRUISE_PAGE);
                } elseif (in_array($cruise['star'], array(3, 2.5, 2, 1.5, 1))){
                    $budget = lang('lbl_budget');
                    $more_cruise_text = lang('more_cheap_halong_cruises');
                    $more_cruise_link = get_page_url(CHEAP_HALONG_CRUISE_PAGE);
                }

                // private cruises
                if(is_bit_value_contain($cruise['types'], 2)) {
                    $budget = lang('lbl_private');
                    $more_cruise_text = lang('more_private_halong_cruises');
                    $more_cruise_link = get_page_url(CHARTER_HALONG_CRUISE_PAGE);
                }

                // day cruises
                if(is_bit_value_contain($cruise['types'], 3)) {
                    $budget = lang('lbl_day');
                    $more_cruise_text = lang('more_halongbay_day_cruises');
                    $more_cruise_link = get_page_url(DAY_HALONG_CRUISE_PAGE);
                }


                $similar_title = lang_arg('label_similar_halong_cruises', $budget);
            }
            else
            {
                $mekong_destination = array(6, 7, 8, 9, 10);

                foreach ($mekong_destination as $value)
                {
                    if (is_bit_value_contain($cruise['types'], $value))
                    {
                        switch ($value) {
                            case 6:
                                $cruise_location = lang('vietnam_cambodia');
                                $more_cruise_link = get_page_url(VIETNAM_CAMBODIA_CRUISES);
                                break;
                            case 7:
                                $cruise_location = lang('vietnam');
                                $more_cruise_link = get_page_url(VIETNAM_CRUISES);
                                break;
                            case 8:
                                $cruise_location = lang('laos');
                                $more_cruise_link = get_page_url(LAOS_CRUISES);
                                break;
                            case 9:
                                $cruise_location = lang('thailand');
                                $more_cruise_link = get_page_url(THAILAND_CRUISES);
                                break;
                            case 10:
                                $cruise_location = lang('burma');
                                $more_cruise_link = get_page_url(BURMA_CRUISES);
                                break;
                        }
                    }
                }

                $more_cruise_text = lang_arg('more_mekong_cruises', $cruise_location);

                $similar_title = lang_arg('label_similar_mekong_cruises', $cruise_location);
            }

            $view_data['similar_title'] = $similar_title;

            $view_data['more_tour_text'] = $more_cruise_text;

            $view_data['more_tour_link'] = $more_cruise_link;

            if($is_mobile) {
                
                $view_data = load_list_cruises($view_data, $is_mobile, $view_data['cruises']);
                
            } else {
                $similar_cruises_side = $this->load->view($mobile_folder . 'cruises/detail/similar_cruises_side', $view_data, TRUE);
            }
            
            $similar_cruises = $this->load->view($mobile_folder . 'cruises/detail/similar_cruises', $view_data, TRUE);
        }

        $data['similar_cruises_side'] = $similar_cruises_side;

        $data['similar_cruises'] = $similar_cruises;

        return $data;
    }


    /**
     * Khuyenpv March 03 2015
     * Load Cruise Itinerary View
     */
    function _load_cruise_itineraries($data, $is_mobile, $tours){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        if(!empty($tours)) {
            
            $data = load_tour_itinerary($data, $is_mobile, $tours[0]);

            $data['tours'] = $tours;
        }

        $data['cruise_itineraries'] = $this->load->view($mobile_folder.'cruises/detail/cruise_itineraries', $data, TRUE);

        return $data;
    }

    /**
     * Khuyenpv March 03 2015
     * Load Cruise Policies
     */
    function _load_cruise_policies($data, $is_mobile, $cruise, $selected_tour){

        $view_data = load_tour_booking_conditions($data, $is_mobile, $selected_tour, $cruise);

        $data['cruise_policies'] = $view_data['tour_booking_conditions'];

        return $data;
    }

    /**
     * Load Facilities & Deckplan
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function _load_cruise_faclilities($data, $is_mobile, $cruise){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $cruise_facilities = array();

        $cruise_facilities[CRUISE_FACILITY_GENERAL] = array();

        $cruise_facilities[CRUISE_FACILITY_SERVICE] = array();

        $cruise_facilities[CRUISE_FACILITY_ACTIVITY] = array();

        $cruise_facilities[CRUISE_FACILITY_ACTIVITY_ON_REQUEST] = array();

        $facilities = $this->Cruise_Model->get_cruise_facilities($cruise['id']);

        foreach ($facilities as $value) {

            if($value['hotel_facility_type'] == 0){ // general facitility

                $cruise_facilities[CRUISE_FACILITY_GENERAL][] = $value;

            }

            if($value['hotel_facility_type'] == 1){ // service facitility

                $cruise_facilities[CRUISE_FACILITY_SERVICE][] = $value;

            }

            if($value['hotel_facility_type'] == 2){ // activity facitility

                $cruise_facilities[CRUISE_FACILITY_ACTIVITY][] = $value;

            }

            if($value['hotel_facility_type'] == 3){ // activity facitility

                $cruise_facilities[CRUISE_FACILITY_ACTIVITY_ON_REQUEST][] = $value;

            }

        }
        
        $view_data['cruise'] = $data['cruise'];

        $view_data['cruise_facilities'] = $cruise_facilities;

        $data['cruise_facilities'] = $this->load->view($mobile_folder.'cruises/detail/cruise_facilities', $view_data, TRUE);

        return $data;
    }

    /**
     * get_cruise_properties_deckplans
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_properties_deckplans()
    {
        $cruise_id = $this->input->post("id");

        $data['cruise_name'] = $this->input->post("cruise_name");

        $data['properties'] = $this->Cruise_Model->get_cruise_properties($cruise_id);

        $data['members'] = $this->Cruise_Model->get_cruise_members($cruise_id);

        $data['member_properties'] = $this->Cruise_Model->get_cruise_member_properties($cruise_id);

        $properties_deckplans = $this->load->view('cruises/detail/cruise_properties_deckplans', $data, TRUE);

        echo $properties_deckplans;
    }

    /**
     * get_videos
     *
     * @author toanlk
     * @since  Apr 7, 2015
     */
    function get_videos()
    {
        $cruise_id = $this->input->post("id");

        $video_view = '';

        $data['videos'] = $this->Cruise_Model->get_cruise_videos($cruise_id);

        if (! empty($data['videos']))
        {
            $data['cruise_name'] = $data['videos'][0]['cruise_name'];

            $video_view = $this->load->view('cruises/detail/cruise_videos', $data, TRUE);
        }

        echo $video_view;
    }

    /**
     * Get cruise tour itinerary
     *
     * @author toanlk
     * @since  Apr 1, 2015
     */
    function get_itinerary() {

        $url_title = $this->input->post("url_title");
        
        $tour = $this->Tour_Model->get_tour_detail($url_title);

        $is_mobile = is_mobile();

        $data = load_tour_itinerary(array(), $is_mobile, $tour);

        echo $data['tour_itinerary'];
    }

    /**
     * Get the selected tour in Check Rate Form
     *
     * @author Khuyenpv
     * @since 10.04.2015
     */
    function _get_selected_tour($tours){

        if(empty($tours)) return null;

        $ret = $tours[0];

        $tour_id = $this->input->get('tour_id');

        foreach ($tours as $tour){
            if($tour['id'] == $tour_id){
                $ret = $tour;
                break;
            }
        }

        return $ret;

    }
}
?>
