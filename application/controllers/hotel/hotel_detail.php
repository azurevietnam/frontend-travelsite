<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Hotel Detail Class
 *
 * @author toanlk
 * @since  May 28, 2015
 */
class Hotel_Detail extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource','advertise','destination','faq', 'hotel', 'tour', 'hotel_search', 'hotel_rate', 'hotline', 'review', 'text', 'recommend'));

       	$this->load->model(array('Hotel_Model', 'Destination_Model', 'Faq_Model', 'Tour_Model', 'BookingModel'));

        $this->load->language('hotel');

		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index($url_title)
    {
        // set cache html
        set_cache_html();

        // set current menu
        set_current_menu(MNU_HOTELS);

        $is_mobile = is_mobile();

    	$hotel = $this->Hotel_Model->get_hotel_detail($url_title);

    	// redirect to homepage if cannot find the tour
    	if (empty($hotel)) {
    	    redirect(get_page_url(HOME_PAGE));
    	}

        $data['destination'] = $this->Destination_Model->get_destination($hotel['destination_id']);
        $hotel['destination_name'] = $data['destination']['name']; //set for meta-setting
    	$data['hotel'] = $hotel;
    	

    	$data['page'] = HOTEL_DETAIL_PAGE;

    	$data = get_page_main_header_title($data, $is_mobile, HOTEL_DETAIL_PAGE);

    	$data = get_page_navigation($data, $is_mobile, HOTEL_DETAIL_PAGE);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(HOTEL_DETAIL_PAGE, $hotel);

    	$data['page_theme'] = get_page_theme(HOTEL_DETAIL_PAGE, $is_mobile);


        // load left block
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;

        $data = load_hotel_search_form($data, $is_mobile, array(), $display_mode_form , true);

        $data = load_why_use($data, $is_mobile);

        $data = load_tripadvisor($data, $is_mobile);

        $data = load_top_hotel_destinations($data, $is_mobile);

        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HOTEL_DETAIL);

        // load right block
        $data = $this->_load_hotel_header_area($data, $is_mobile, $hotel);

        // load hotel slider
        $hotel_photos = $this->Hotel_Model->get_hotel_photos($hotel['id']);

        $hotel_photos = $this->_add_avatar_hotel_and_roomtype_picture($hotel_photos, $hotel, $is_mobile);

        $data = load_photo_slider($data, $is_mobile, $hotel_photos, PHOTO_FOLDER_HOTEL, true);

        $data =  $this->_load_hotel_rate_itinerary_facility($data, $is_mobile, $hotel, $hotel_photos);

        $data = $this->_load_similar_hotels($data, $is_mobile);

        // load cruise header tabs for Mobile
        if ($is_mobile) {
        	$mobile_folder = $is_mobile ? 'mobile/' : '';

        	$activeTab = $this->input->get('activeTab');

        	$data['activeTab']  = !empty($activeTab) ? $activeTab : 'tab_check_rates';

        	$data['hotel_header_tabs'] = $this->load->view($mobile_folder . 'hotels/detail/hotel_header_tabs', $data, TRUE);
        }

        render_view('hotels/detail/hotel_details', $data, $is_mobile);
    }

    /**
     * Add avatar hotel and roomtype picture to hotel photos list
     * @author TinVM
     * @since Jun29 2015
     */
    function _add_avatar_hotel_and_roomtype_picture($hotel_photos, $hotel, $is_mobile){
        if(!$is_mobile){
            $avatar_hotel = array('name' => $hotel['picture'], 'caption' => $hotel['name']);
            array_unshift($hotel_photos, $avatar_hotel);
        }

        $room_type_photos = $this->Hotel_Model->get_hotel_rooms($hotel['id']);

        foreach ($room_type_photos as $value) {
            $room_type_picture = array('name' => $value['picture'], 'caption' => $value['name']);
            array_push($hotel_photos, $room_type_picture);
        }

        return $hotel_photos;
    }

    /**
     * Review Page
     * @author TinVM
     * @since Jun22 2015
     */
    function review($url_title){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        // set cache html
        set_cache_html();

        // set current menu
        set_current_menu(MNU_HOTELS);

        $hotel = $this->Hotel_Model->get_hotel_detail($url_title);

        // redirect to homepage if cannot find the destination
        if (empty($hotel))
        {
            redirect(get_page_url(HOME_PAGE), 'location', 301);
        }

        $data['destination'] = $this->Destination_Model->get_destination($hotel['destination_id']);
        
        $hotel['destination_name'] = $data['destination']['name']; //set for meta-setting

        $data['is_mobile'] = $is_mobile;

        $data['hotel'] = $hotel;

        $data['page'] = HOTEL_REVIEW_PAGE;

        $data['review_page'] = true;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(HOTEL_REVIEW_PAGE, $hotel);

        $data['page_theme'] = get_page_theme(HOTEL_REVIEW_PAGE, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, HOTEL_REVIEW_PAGE);

        // load cruise header
        $data = $this->_load_hotel_header_area($data, $is_mobile, $hotel);

        // load the tour search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
        $data = load_hotel_search_form($data, $is_mobile, array(), $display_mode_form , true);

        // load how-to-book a trip
        $data = load_how_to_book_trip($data, $is_mobile);

        // load fag by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HOTEL_DETAIL);

        // load explore cruising
        //$data = $this->_load_explore_cruising($data, $is_mobile);

        $data = load_customer_reviews($data, $is_mobile, $hotel, HOTEL);

        //  load recommendation service hotels
        $data = load_hotel_rate_table($data, $is_mobile, $hotel);

        $current_item_info = $this->_get_current_hotel_booking_info($hotel, $data['discount_together'], $data['destination']['id']);
        $data = load_service_recommendation($data, $is_mobile, $current_item_info);

        $data = $this->_load_similar_hotels($data, $is_mobile);

        // load cruise header tabs for Mobile
        if ($is_mobile) {
        	$mobile_folder = $is_mobile ? 'mobile/' : '';
        	$data['hotel_header_tabs'] = $this->load->view($mobile_folder . 'hotels/detail/hotel_header_tabs', $data, TRUE);
        }

        render_view('hotels/detail/hotel_review', $data, $is_mobile);
    }

    /**
     * TinVM Jun 18 2015
     * Load hotel-header area: name, destination, review, price & offer
     */
    function _load_hotel_header_area($data, $is_mobile, $hotel){

        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $review_link = get_page_url(HOTEL_REVIEW_PAGE, $hotel);

        // load review overview
        $rich_snippet = array(
            'name'     => $hotel['name'],
            'photo'    => get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture']) // small photo
        );

        $data = load_review_overview($data, $is_mobile, $hotel['total_score'], $hotel['review_number'], $review_link, $rich_snippet);

        $data['hotel_header'] = $this->load->view($mobile_folder.'hotels/detail/hotel_header', $data, TRUE);

        return $data;
    }

    /**
     * TinVM Jun 18 2015
     * Load hotel tab
     */
    function _load_hotel_rate_itinerary_facility($data, $is_mobile, $hotel, $hotel_photos){

        $data['form_action'] = get_page_url(HOTEL_DETAIL_PAGE, $hotel);
        $data = load_hotel_check_rate_form($data, $is_mobile, $hotel);

        $data = load_hotel_rate_table($data, $is_mobile, $hotel);

        $data = load_photo_list($data, $is_mobile, $hotel_photos, PHOTO_FOLDER_HOTEL, $data['hotel']['name']);

        $data = $this->_load_hotel_faclilities($data, $is_mobile, $hotel);

        $data = load_hotel_booking_conditions($data, $is_mobile, $hotel);

        //  load recommencdation service hotels
        $current_item_info = $this->_get_current_hotel_booking_info($hotel, $data['discount_together'], $data['destination']['id']);
        $data = load_service_recommendation($data, $is_mobile, $current_item_info);

        // load extra-saving links
        $data = load_extra_saving_recommendation($data, $is_mobile);

        $data['hotel_tab'] = load_view('hotels/detail/hotel_tab', $data, $is_mobile);

        return $data;
    }

    /**
     * Load Hotel Facilities
     *
     * @author TinVM
     * @since  Jun 19, 2015
     */
    function _load_hotel_faclilities($data, $is_mobile, $hotel){

        $ret = array();

        $facilities = $this->Hotel_Model->get_hotel_facilities($hotel['id']);

        $hotel_facilities = array();

        if (!empty($facilities)) {

            foreach ($facilities as $key => $value) {

                if($value['hotel_facility_type'] == HOTEL_FACILITY_GENERAL){

                    $hotel_facilities[HOTEL_FACILITY_GENERAL][] = $value;

                }

                if($value['hotel_facility_type'] == HOTEL_FACILITY_SERVICE){

                    $hotel_facilities[HOTEL_FACILITY_SERVICE][] = $value;

                }

                if($value['hotel_facility_type'] == HOTEL_FACILITY_ACTIVITY){

                    $hotel_facilities[HOTEL_FACILITY_ACTIVITY][] = $value;

                }
            }

            $view_data['hotel'] = $hotel;

            $view_data['hotel_facilities'] = $hotel_facilities;

            $data['hotel_facilities'] = load_view('hotels/detail/hotel_facilities', $view_data, $is_mobile);

            return $data;
        }
        else
            return '';
    }

    /**
     * Load similar hotel
     * @author TinVM
     * @since Jun 22 2015
     */
    function _load_similar_hotels($data, $is_mobile){

        $data['similar_hotels'] = $this->Hotel_Model->get_similar_hotels($data['hotel']);

        if(!empty($data['similar_hotels'])) {
            $data['hotel_desc'] = $this->Tour_Model->get_destination($data['hotel']['destination_id']);
        }

        if($is_mobile)
            $data = load_list_hotels($data, $is_mobile, $data['similar_hotels']);

        $data['similar_hotels'] = load_view('hotels/detail/similar_hotels', $data, $is_mobile);

        return $data;
    }

    /**
     * Get current booking info for Hotel Service Recommendation
     *
     * @author TinVM
     * @since Jun23 2015
     */
    function _get_current_hotel_booking_info($hotel, $discount_together, $destination_id){

        // load service recommendation
        $current_item_info['service_id'] = $hotel['id'];

        $current_item_info['service_type'] = HOTEL;

        $current_item_info['url_title'] = $hotel['url_title'];

        $current_item_info['normal_discount'] = $discount_together['normal_discount'];

        $current_item_info['is_main_service'] = false;

        $current_item_info['destination_id'] = $destination_id;

        $current_item_info['is_booked_it'] = false;

        $current_item_info['parent_id'] = ''; // NO CURRENT SELECTED BOOKING ITEM

        $current_item_info['start_date'] = get_current_hotel_start_date($hotel);

        return $current_item_info;
    }
}
?>