<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * For displaying page, loading view...etc
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 04 2015
 */


// ------------------------------------------------------------------------

/**
 *  load_tour_contact
 *
 *  @author toanlk
 *  @since  Oct 8, 2014
 */
if (! function_exists('load_tour_contact'))
{

    function load_tour_contact($tour = null, $is_collapsed = false)
    {
        $CI = & get_instance();

        $data['countries'] = $CI->config->item("countries");

        if(!empty($tour)) {

            $option_contact['tour_name'] = $tour['name'];

            $data['option_contact'] = $option_contact;
        }

        $data['is_collapsed'] = $is_collapsed;

        $view_tour_contact = $CI->load->view('tours/common/tour_contact', $data, TRUE);

        return $view_tour_contact;
    }
}

/**
 * Khuyenpv Feb 06 2014
 * Load search forms of tour, hotel, flight
 * @param unknown $data
 * @param string $is_mobile
 */
function load_multiple_search_forms($data, $is_mobile = false, $display_mode = ''){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	// set flag for display logic in each search form
	$data['multiple_search_forms'] = '1';

	$search_criteria = set_default_flight_search_criteria();

	// load the tour-search-fom
	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode, true);

	$data = load_hotel_search_form($data, $is_mobile,array(), $display_mode);

//	$data = load_flight_search_form($data, $is_mobile, $search_criteria, $display_mode);

	$data['search_form'] = $CI->load->view($mobile_folder.'home/search/search_form', $data, TRUE);

	return $data;
}

/**
 * HuuTD 12.06.2015
 * Load Search Waiting
 */

function load_search_waiting($message, $mode="waiting", $please_wait_txt = ''){
	$CI =& get_instance();
	$data['message'] = $message;
	$data['please_wait_txt'] = $please_wait_txt;
	$data['mode'] = $mode;

	$mobile_view = is_mobile() ? 'mobile/' : '';

	return $CI->load->view($mobile_view.'common/search/search_waiting', $data, TRUE);
}

/**
 * Khuyenpv Feb 09 2015
 * Load Besprice Tripadvisor
 */
function load_tripadvisor($data, $is_mobile){

    if($is_mobile) return $data;

	$data['tripadvisor'] = load_view('common/tripadvisor/tripadvisor', array(), $is_mobile);

	return $data;
}

/**
 * Khuyenpv Feb 26 2015
 * Load How to Book a Trip
 */
function load_how_to_book_trip($data, $is_mobile){

    if($is_mobile) return $data;

    $view_data['faq_booking_process'] = array('url_title' => 'What-is-your-booking-process');

	$data['how_to_book_trip'] = load_view('common/help/how_to_book_trip', $view_data, $is_mobile);

	return $data;
}

/**
 * Khuyenpv Feb 26 2015
 * Load Common Photo Slider for Cruise/Tour/Hotel ...etc
 */
function load_photo_slider($data, $is_mobile, $photos, $folder, $is_free_visa = null){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	$photo_size = $is_mobile ? '375_250' : '848_477';

	foreach ($photos as $k => $photo) {
	    $photo['src'] = get_image_path($folder, $photo['name'], $photo_size);
	    $photos[$k] = $photo;
	}

	if(!empty($data['page']) && $is_mobile) {

	    switch ($data['page']) {
	        case CRUISE_DETAIL_PAGE:
    	        $view_data['cruise'] = $data['cruise'];
    	        break;
	        case TOUR_DETAIL_PAGE:
	            $view_data['tour'] = $data['tour'];
	            break;
            case HOTEL_DETAIL_PAGE:
                $view_data['hotel'] = $data['hotel'];
                break;
	    }
	}

	$view_data['photos'] = $photos;

	$view_data['is_free_visa'] = $is_free_visa;

	$data['photo_slider'] = $CI->load->view($mobile_folder.'common/photo/photo_slider', $view_data, TRUE);

	return $data;
}

/**
 * Load photo list
 *
 * @author toanlk
 * @since  Apr 1, 2015
 */
function load_photo_list($data, $is_mobile, $photos, $folder, $object_name = null, $limit = 9)
{
    if($is_mobile) return $data;

    $CI = & get_instance();

    $photo_list = '';

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    if (! empty($photos))
    {
        foreach ($photos as $k => $photo) {
            $photo['src'] = get_image_path($folder, $photo['name'], '265_177');
            $photo['upload_src'] = get_image_path($folder, $photo['name'], 'origin');
            $photos[$k] = $photo;
        }

        $data['photo_list'] = $photos;

        $data['limit'] = $limit;
        $data['object_name'] = $object_name;

        $photo_list = $CI->load->view($mobile_folder . 'common/photo/photo_list', $data, TRUE);
    }

    $data['photo_list'] = $photo_list;

    return $data;
}

/**
 * Photo gallery for details page
 *
 * @author toanlk
 * @since  Apr 13, 2015
 */
function load_photo_for_details($data, $is_mobile, $photos, $folder, $limit = null) {

    $CI = & get_instance();

    $photo_list = '';

    if (! empty($photos))
    {
        foreach ($photos as $k => $photo) {

            $photo['src'] = get_image_path($folder, $photo['name'], '450_300');
            $photo['small_src'] = get_image_path($folder, $photo['name'], '210_140');
            $photo['upload_src'] = get_image_path($folder, $photo['name'], 'origin');

            $photos[$k] = $photo;
        }

        $data['limit'] = $limit;

        $data['is_free_visa'] = !empty($data['tour']) && is_free_visa($data['tour']);

        $data['photos'] = $photos;

        $photo_list = load_view('common/photo/photo_for_details', $data, $is_mobile);
    }

    $data['photo_for_details'] = $photo_list;

    return $data;
}

/**
 * Khuyenpv March 06 2015
 * Load the datepicker view for each date-selection form
 */
function load_datepicker($is_mobile, $datepicker_options){

	$view_data['options'] = $datepicker_options;

	$datepicker_view = load_view('common/booking/datepicker', $view_data, $is_mobile);

	return $datepicker_view;
}

/**
 * Load the Promotion Content
 *
 * @author Khuyenpv 26.03.2015
 */
function load_promotion_content($is_mobile, $promotion, $service_type = TOUR){

	if(empty($promotion)) return '';

	$view_data['service_type'] = $service_type;

	$view_data['promotion'] = $promotion;

	$pro_content = load_view('common/others/promotion_content', $view_data, $is_mobile);

	return $pro_content;
}

/**
 * Load the Promotion Popup
 *
 * @author Khuyenpv 26.03.2015
 */
function load_promotion_popup($is_mobile, $promotions, $service_type = TOUR, $is_show_background = true){

	if(empty($promotions)) return '';

	$view_data['show_pro_detail'] = !empty($promotions['id']); // if the input promotion is a single promotion => show detail, not show campain

	if($view_data['show_pro_detail'] && empty($promotions['offer_note'])) return '';

	if(!empty($promotions['id'])) $promotions = array($promotions); // convert to array of promotion


	foreach ($promotions as $k=>$value){

		if(empty($value['pro_content'])){
			$value['pro_content'] = load_promotion_content($is_mobile, $value, $service_type);
		}

		$promotions[$k] = $value;
	}

	$view_data['promotions'] = $promotions;

	$view_data['is_show_background'] = $is_show_background;

	$pro_popup = load_view('common/others/promotion_popup', $view_data, $is_mobile);

	return $pro_popup;
}

/**
 * Load the Promotion Popup for old-data storing
 *
 * @author Khuyenpv
 * @since 07.04.2015
 */
function load_promotion_popup_4_old_storing($is_mobile, $offer_name, $offer_note, $offer_cond, $rowid){

	if(empty($offer_note) || empty($offer_name) || empty($offer_cond)) return '';

	$promotion['id'] = $rowid;
	$promotion['name'] = $offer_name;
	$promotion['offer_note'] = $offer_note;
	$promotion['pro_content'] = $offer_cond;

	$pro_popup = load_promotion_popup($is_mobile, $promotion, TOUR, false);

	return $pro_popup;
}

/**
 * Load Booking Step View
 *
 * @author Khuyenpv
 * @since 31.03.2015
 */
function load_booking_step($data, $is_mobile, $current_step, $step_labels = array()){

	$CI = & get_instance();

	$view_data['current_step'] = $current_step;

	if (empty($step_labels)){

		$step_labels = $CI->config->item('step_labels');
	}

	$view_data['step_labels'] = $step_labels;

	$booking_step = load_view('common/booking/booking_steps', $view_data, $is_mobile);

	$data['booking_steps'] = $booking_step;
	return $data;
}

/**
 * Load the free visa popup
 *
 * @author Khuyenpv 26.03.2015
 */
function load_free_visa_popup($is_mobile, $show_icon_deal = false){

	$view_data['free_visa_content'] = load_view('common/visa/free_visa_content', array(), $is_mobile);
	
	$view_data['show_icon_deal'] = $show_icon_deal;

	$popup_free_visa = load_view('common/visa/popup_free_visa', $view_data, $is_mobile);

	return $popup_free_visa;
}

/**
 * Load the common Resouce For Download
 *
 * @author Khuyenpv
 * @maintain by TinMV
 * @since 15.04.2015
 */
function load_download_resources($is_mobile, $title, $files){

	$view_data['files'] = $files;
	$view_data['title'] = $title;

	$download_view = load_view('common/download/download_resources', $view_data, $is_mobile);

	return $download_view;
}

/**
 * Load the common Whyuse View
 *
 * @author Huutd
 * @since 27.05.2015
 */
function load_why_use($data, $is_mobile) {

    if($is_mobile) return $data;

	$data['why_use'] = load_view('common/others/why_use', $data, $is_mobile);

	return $data;
}


/**
 * Load countries of Indochina
 *
 * @author Huutd
 * @since 27.05.2015
 *
 */

function load_indochina_countries($data, $is_mobile, $page='')
{
	$CI = & get_instance();

	$countries = $CI->config->item('indochina_destinations_flag');

	// indochina tour destinations
	$indochina_destinations = array();

	foreach ($countries as $country_id => $value)
	{
		$des = $CI->Tour_Model->get_destination($country_id);

		$des['styles'] = $CI->Tour_Model->get_destination_travel_styles($country_id);
		$des['icon_flag'] = $value;
		$indochina_destinations[] = $des;
	}

	$data['indochina_destinations'] = $indochina_destinations;

	// indochina
	$indochina = $CI->Tour_Model->get_destination(408);

	$indochina['styles'] = $CI->Tour_Model->get_destination_travel_styles(408);

	$data['indochina'] = $indochina;

	switch ($page){
		case HOME_PAGE:
			$data['indochina_tour_service_links'] = load_view('home/indochina_tour_service_links',$data, $is_mobile);
			break;
		case TOUR_HOME:
			$data['indochina_countries'] = load_view('tours/country/indochina_countries',$data, $is_mobile);
			break;
	}

	return $data;
}

/**
 * Load popular fotter links
 *
 * @author Huutd
 * @since 21.06.2015
 *
 */

function load_popular_service_links($data, $is_mobile, $top_tour_des = false , $top_hotel_des = false, $halongcruises = false, $mekongcruises = false){
	 /*
	  $top_tour_des = true/false;
	  $top_hotel_des = true/false;
	  $halongcruises = true/false
	  $mekongcruises = true/false
	  * */
	$CI = & get_instance();
	// Get top destinations
	if ($top_tour_des == true){
		$view_data['top_tour_des'] = $CI->Destination_Model->get_top_destinations('is_top_tour');
	}
	if ($top_hotel_des == true){
		$view_data['top_hotel_des'] = $CI->Destination_Model->get_top_destinations('is_top_hotel');
	}
	// Get popular cruises
	if ($halongcruises == true){
		$view_data['halongcruises'] = $CI->Cruise_Model->get_popular_cruises('0');
	}
	if ($mekongcruises == true){
		$view_data['mekongcruises'] = $CI->Cruise_Model->get_popular_cruises('1');
	}
	$data['popular_service_links'] = load_view('home/popular_service_links',$view_data, $is_mobile);

	return $data;
}

/**
  * set_tooltip
  *
  * @author toanlk
  * @since  Jul 8, 2015
  */
function set_tooltip($content, $limit) {

    $tooltip = '';

    if(strlen($content) > $limit) {
        $tooltip = ' data-toggle="tooltip" title="'.htmlspecialchars($content).'"';
    }

    return $tooltip;
}