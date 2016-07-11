<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function get_duration($duration) {
	if ($duration <= 1) {
		$duration_info = $duration . ' ' . lang('day');

	} else if($duration == 2){
		$duration_info = $duration . ' ' . lang('days') . ' / ' . ($duration - 1) . ' ' . lang('night');
	} else {
		$duration_info = $duration . ' ' . lang('days') . ' / ' . ($duration - 1) . ' ' . lang('nights');
	}
	return $duration_info;
}


function get_dess_info($dess) {
	$dess_info = '';
	if (count($dess) > 0) {
		foreach ($dess as $des) {
			//$dess_info .= '<a href="javascript:void(0);" onclick="showDes('.$des['id'].')">' . $des['name'] . '</a>' . ' - ';
			$dess_info .= $des['name'] . ' - ';
		}
		$dess_info = substr($dess_info, 0, strlen($dess_info) - 3);
	}
	return $dess_info;
}

function loadTopDestination($data) {
	$CI =& get_instance();

	/*
	$cache_time = $CI->config->item('cache_day');

	$CI->load->driver('cache', array('adapter' => 'file'));

	if ( ! $tours_by_destination_view = $CI->cache->get('tours_by_destination'))
	{
		$data['parent_dess'] = $CI->TourModel->getTopParentDestinations();
		$data['dess'] = $CI->TourModel->getTopDestinations();

		$tours_by_destination_view = $CI->load->view('common/top_destination', $data, TRUE);


		// Save into the cache for 5 minutes
		$CI->cache->save('tours_by_destination', $tours_by_destination_view, $cache_time);

		//echo 'go here'; exit();
	}*/

	$data['parent_dess'] = $CI->TourModel->getTopParentDestinations();
	$data['dess'] = $CI->TourModel->getTopDestinations();

	$tours_by_destination_view = $CI->load->view('common/top_destination', $data, TRUE);

	$data['topDestinations'] = $tours_by_destination_view;

	return $data;
}

function update_tour_price_to_net_price($prices){

	$CI =& get_instance();

	foreach ($prices as $key=>$value){

		if(is_tour_no_vat($value['tour_id'])){

			$value['from_price'] = re_calculate_price_no_vat($value['from_price']);

			$prices[$key] = $value;

		}

	}

	return $prices;
}

function re_calculate_price_no_vat($price){

	$CI =& get_instance();

	$net_rate = $CI->config->item('net_rate');

	$price = $price / $net_rate;

	return $price;
}

function is_tour_no_vat($tour_id){

	$CI =& get_instance();

	$no_vat_tours = $CI->config->item('no_vat_tours'); //only some tour show price not VAT

	if(empty($no_vat_tours)) return false;

	return in_array($tour_id, $no_vat_tours);

}

/*
|--------------------------------------------------------------------------
| New functions for Bestpricevn.com 2015
|--------------------------------------------------------------------------
|
*/

/**
 * Create common promotion sql condition
 *
 * @author Khuyenpv 20.03.2015
 */
function create_tour_promotion_condition($departure_date){

	$today = date(DB_DATE_FORMAT);

	// calculate day-before-staying date
	$today_time = strtotime($today);

	$stay_time = strtotime($departure_date);

	$day_before = $stay_time - $today_time;

	$day_before =  round($day_before/(60*60*24));

	$str_cond = '((p.book_from is NULL OR p.book_from <= "'.$today .'") AND p.book_to >= "'.$today.'")';

	$str_cond .= ' AND (p.stay_from <= "'.$departure_date .'" AND p.stay_to >= "'.$departure_date.'")';

	$str_cond .= ' AND (p.display_on & '.pow(2,date('w',strtotime($today))).' > 0)';

	$str_cond .= ' AND (p.check_in_on & '.pow(2,date('w',strtotime($departure_date))).' > 0)';

	$str_cond .= ' AND (p.promotion_type = ' . PROMOTION_TYPE_NORMAL . ' OR (p.promotion_type = '.PROMOTION_TYPE_EARLY_BIRD.' AND p.day_before <= '.$day_before.')'.

			' OR (p.promotion_type = '.PROMOTION_TYPE_LAST_MINUTE.' AND p.day_before >= '.$day_before.'))';

	$str_cond .= " AND (p.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM promotion_dates as p_date WHERE p.id = p_date.promotion_id AND date = '".$departure_date."'))";

	/*
	if(is_visitor_in_hanoi()){ // user in Hanoi only see promotin 'Apply For Hanoi'
		$str_cond .= ' AND p.apply_for_hanoi = '.STATUS_ACTIVE;
	}*/

	$str_cond .= ' AND p.deleted != '.DELETED;

	$str_cond .= ' AND p.status = '.STATUS_ACTIVE;

	$str_cond .= ' AND (p.language_id = 0 OR p.language_id = '.lang_id().')';

	return $str_cond;
}

/**
 * Khuyepv Feb 09 2015
 * Load the most recommend tour in a list tours
 */
function load_most_recommended_tour($data, $is_mobile, $tour){
	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	if(!empty($tour)){

		$data['tour'] = $tour;

		if(!empty($data['travel_style'])) {
		    $style_name = !is_symnonym_words($data['travel_style']['name']) ? lang_arg('tour_travel_style', $data['travel_style']['name']) : $data['travel_style']['name'];
		    $data['most_recommended_title'] = lang_arg('the_best_of_destination_style', $data['destination']['name'], $style_name, date('Y'));
		} else {
		    $data['most_recommended_title'] = lang_arg('1', $data['destination']['name'], date('Y'));
		}

		$data['most_recommended_tour'] = $CI->load->view($mobile_folder.'tours/common/most_recommended_tour', $data, TRUE);

	} else {
		$data['most_recommended_tour'] = '';
	}

	return $data;
}

/**
 * Load common 3 top recommended tours on TOUR DESTINATION VIEW
 *
 * @author Khuyenpv
 * @since 10.04.2015
 */
function load_top_recommended_tours($data, $is_mobile, $tours)
{
    if (! empty($tours))
    {
        $view_data['tours'] = $tours;
        
        if($is_mobile) {
            $data['top_recommended_tours'] = load_view('tours/common/list_tours', $view_data, $is_mobile);
        } else {
            $data['top_recommended_tours'] = load_view('tours/common/top_recommended_tours', $view_data, $is_mobile);
        }
    }
    else
    {
        $data['top_recommended_tours'] = '';
    }
    return $data;
}

/**
 * Khuyenpv Feb 09 2015
 * Load the list tours view
 */
function load_list_tours($data, $is_mobile, $tours , $is_enable_number = FALSE){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	if(!empty($tours)){

		$data['tours'] = $tours;

		$data['is_enable_number'] = $is_enable_number;

		$data['list_tours'] = $CI->load->view($mobile_folder.'tours/common/list_tours', $data, TRUE);

	} else {
		$data['list_tours'] = '';
	}

	return $data;
}

/**
 * Khuyenpv March 04 2015
 * Load the list tours compact view
 */
function load_list_tours_compact($data, $is_mobile, $tours){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	if(!empty($tours)){

		$tour_data['tours'] = $tours;

		$data['list_tours_compact'] = $CI->load->view($mobile_folder.'tours/common/list_tours_compact', $tour_data, TRUE);

	} else {
		$data['list_tours_compact'] = '';
	}

	return $data;
}

/**
 * Khuyenpv Feb 10 2025
 * Load the menu for tour categories
 * @param $data
 * @param $is_mobile
 * @param $destination: the tour-destination
 * @param $travel_styles: travel style of this destination
 * $param $selected_id - id of the current selected travel style
 */
function load_tour_categories($data, $is_mobile, $destination, $travel_styles = array(), $selected_id = null)
{    
    $CI = & get_instance();

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    $view_data['travel_styles'] = $travel_styles;

    $view_data['selected_style_id'] = $selected_id;

    $view_data['destination'] = $destination;

    $data['tour_categories'] = $CI->load->view($mobile_folder . 'tours/common/tour_categories', $view_data, TRUE);

    return $data;
}

function get_recommend_services($recommend_services) {

    foreach ($recommend_services as $k => $service)
    {
        switch ($service['service_id']) {
            case TOUR:
                $service['name'] = lang_arg('recommendation_service_tour', $service['name']);
                $service['url'] = get_page_url(TOURS_BY_DESTINATION_PAGE, $service);
                break;

            case CRUISE:
                $service['name'] = lang_arg('recommendation_service_cruise', $service['name']);
                if($service['destination_id'] == 5) {
                    $service['url'] = site_url(HALONG_CRUISE_PAGE);
                } else {
                    $service['url'] = site_url(MEKONG_CRUISE_PAGE);
                }
                break;

            case HOTEL:
                $service['name'] = lang_arg('recommendation_service_hotel', $service['name']);
                $service['url'] = '';
                break;

            case VISA:
                $service['name'] = lang_arg('recommendation_service_visa', $service['name']);
                $service['url'] = site_url(VN_VISA_PAGE);
                break;
        }

        $recommend_services[$k] = $service;
    }

    return $recommend_services;
}

/**
 * Khuyenpv Feb 27 2015
 * Load tour itinerary
 */
function load_tour_itinerary_highlights($data, $is_mobile, $tour){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	$view_data['tour'] = $tour;
	
	if(!empty($data['map_photos'])) $view_data['map_photos'] = $data['map_photos'];

	$view_data['highlights'] = $CI->Tour_Model->get_itinerary_highlight($tour['id']);

	$view_data['itinerary_highlight'] = $CI->load->view($mobile_folder.'tours/detail/itinerary_highlights', $view_data, TRUE);

	$data['trip_highlights'] = $CI->load->view($mobile_folder.'tours/detail/trip_highlights', $view_data, TRUE);

	return $data;
}

/**
 * load tour itinerary
 *
 * @author toanlk
 * @since  Mar 27, 2015
 */
function load_tour_itinerary($data, $is_mobile, $tour){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

	$view_data['tour'] = $tour;

	$data = load_tour_itinerary_highlights($data, $is_mobile, $tour);

	$itineraries = $CI->Tour_Model->get_itinerary($tour['id']);
	
	$data['itineraries'] = $itineraries;

	$view_data['routes'] = restructure_itineraries($itineraries);

	$data['tour_itinerary'] = $CI->load->view($mobile_folder.'tours/detail/tour_itinerary', $view_data, TRUE);

	return $data;
}

/**
 * restructure_itineraries
 *
 * @author toanlk
 * @since  June 09, 2015
 */
function restructure_itineraries($itineraries) {
	$routes = array ();

	foreach ( $itineraries as $value ) {

		if ($value ['type'] == 2) { // route

			$route ['route'] = $value;

			$route ['itineraries'] = array ();

			$routes [] = $route;
		}
	}

	if (count ( $routes ) == 0) { // for halong bay tours

		$route ['route'] = array ();

		$route ['itineraries'] = $itineraries;

		$routes [] = $route;
	} else {

		foreach ( $routes as $key => $route ) {

			$current_route_id = $route ['route'] ['id'];

			$its = array ();

			foreach ( $itineraries as $it ) {

				if ($it ['id'] > $current_route_id && (! isset ( $routes [$key + 1] ) || $it ['id'] < $routes [$key + 1] ['route'] ['id'])) {

					$its [] = $it;
				}
			}

			$route ['itineraries'] = $its;

			$routes [$key] = $route;
		}
	}

	return $routes;
}

/**
 * Get meal options
 *
 * @author toanlk
 * @since  Mar 25, 2015
 */
function get_tour_meals($meals)
{
    $CI = & get_instance();

    $txt = '';

    $meals_config = $CI->config->item('tour_meal_options');

    foreach ($meals_config as $key => $value)
    {
        if (is_bit_value_contain($meals, $key))
        {
            $txt .= lang($value) . ', ';
        }
    }

    $txt = rtrim(trim($txt), ',');

    return $txt;
}

/**
 * Get itinerary photos
 *
 * @author toanlk
 * @since  Mar 27, 2015
 */
function get_itinerary_photos($itinerary, $is_top_right = true, $is_mobile = false)
{
    $content = '';

    if (! empty($itinerary['photos']))
    {
        foreach ($itinerary['photos'] as $photo)
        {
            if (! empty($photo['tour_photo_id']))
            {
                $folder = PHOTO_FOLDER_TOUR;
                $photo['name'] = $photo['t_name'];
            }
            else if (! empty($photo['cruise_photo_id']))
            {
                $folder = PHOTO_FOLDER_CRUISE;
                $photo['name'] = $photo['c_name'];
            }
            else if (! empty($photo['destination_photo_id']))
            {
                $folder = PHOTO_FOLDER_DESTINATION;
                $photo['name'] = $photo['d_name'];
            }
            else if (! empty($photo['activity_photo_id']))
            {
                $folder = PHOTO_FOLDER_ACTIVITY;
                $photo['name'] = $photo['a_name'];
            }
            
            $img_size = $is_mobile && $folder == PHOTO_FOLDER_TOUR ? '450_300' : '220_165';

            $src = get_image_path($folder, $photo['name'], $img_size);
            $origin_src = get_image_path($folder, $photo['name'], 'origin');

            $photos[] = array(
            		'src' => $src,
            		'origin_src'  => $origin_src,
            		'caption'     => $photo['caption'],
                    'folder'      => $folder
            );
        }
    }
    elseif (! empty($itinerary['itinerary_photos']))
    {
        $itinerary_photos = explode(',', $itinerary['itinerary_photos']);

        foreach ($itinerary_photos as $photo)
        {
            $img_size = $is_mobile && stripos($itinerary_photos[0], 'tour_') !== false ? '450_300' : '220_165';
            
            $pic = _get_itinerary_photo_path($itinerary_photos[0], $img_size);
            
            if(!empty($pic)) {
                $photos[] = array(
                    'src' => $pic['path'],
                    'origin_src' => str_replace('220_165', 'origin', $pic['path']),
                    'caption' => $pic['caption'],
                );
            }
        }
    }

    if (! empty ( $photos )) {

    	if( (count($photos) > 1 && $is_top_right) || (count($photos) == 1 && !$is_top_right) ) {
    		return $content;
    	}

		foreach ( $photos as $k => $photo ) {
			$class = empty ( $photo ['caption'] ) ? ' class="margin-bottom-10"' : '';

			if(count($photos) == 2) {
				$first_child = $k == 0 ? ' col-xs-offset-2' : '';
				$content .= '<div class="col-xs-4 no-padding'.$first_child.'"><ul class="list-unstyled no-padding">';
			} elseif(count($photos) > 2) {
				$content .= '<div class="col-xs-4"><ul class="list-unstyled no-padding">';
			}
			
			$img_size = $is_mobile ? ' class="img-responsive"' : ' width="220" height="165"'; 

			$content .= '<li' . $class . '>';
			$content .= '<a href="' . $photo ['origin_src'] . '" rel="nofollow" data-lightbox="gallery" data-title="' . $photo ['caption'] . '">';
			$content .= '<img src="' . $photo ['src'] .'"'. $img_size.'></a>';
			$content .= '</li>';

			if (! empty ( $photo ['caption'] )) {
				$content .= '<li class="caption">' . $photo ['caption'] . '</li>';
			}

			if(count($photos) > 1) {
				$content .= '</ul></div>';
			}


		}

		if(count($photos) == 1) {
			$content = '<ul class="itinerary-photos pull-right">' . $content . '</ul>';
		} else {
			$content = '<div class="itinerary-photos row">' . $content . '</div>';
		}
	}

    return $content;
}

/**
 * _get_itinerary_photo_path
 *
 * @author toanlk
 * @since  Mar 27, 2015
 */
function _get_itinerary_photo_path($photo_name, $config_path)
{
    $CI = & get_instance();

    $patterns = array(
        'cruise_',
        'tour_',
        'des_',
        'activity_',
        'hotel_');

    foreach ($patterns as $pattern)
    {
        if (stripos($photo_name, $pattern) !== false)
        {
            $photo_name = str_replace($pattern, '', $photo_name);
            
            if($pattern == 'des_') {
                $folder = 'destinations';
            } elseif($pattern == 'activity_') {
                $folder = 'activities';
            } else {
                $folder = str_replace('_', '', $pattern).'s';
            }
            
            $path = get_image_path($folder, $photo_name, $config_path);
            
            $caption = $CI->Tour_Model->get_photo_description($pattern, $photo_name);
            
            return array('path' => $path,'caption' => $caption);
        }
    }
    
    return null;
}

/**
 * Khuyenpv Feb 27 2015
 * Load tour check-rate form
 * @param: $tours
 */
function load_tour_check_rate_form($data, $is_mobile, $tour, $arr_tours = array(), $loading_asyn = true, $is_book_together = false){

	if(empty($tour)){
		$data['check_rate_form'] = '';
		return $data;
	}
	
	// if check_rate in the cruise => set tour['id'] = 0 => not care about the changing in list of cruise-tours
	if(!empty($arr_tours)){
		$tour['id'] = 0;
	}
	

	$CI =& get_instance();

	$view_data['tour'] = $tour;
	$view_data['arr_tours'] = $arr_tours;
	$view_data['is_book_together'] = $is_book_together;
	$view_data['form_action'] = empty($data['form_action']) ? get_page_url(TOUR_DETAIL_PAGE, $tour) : $data['form_action'];

	// get check rate information from the url
	$check_rates = get_tour_check_rate_from_url($tour);

	$view_data['check_rates'] = $check_rates;

	// if the tour price based on cabin price
	if(is_price_per_cabin($tour) && !empty($check_rates)){

		$is_change_cabin = !empty($check_rates['change']) && $check_rates['change'] == 'change_cabin';
		$view_data['is_change_cabin'] = $is_change_cabin;

		$cabin_types = $CI->config->item('cabin_types');
		$view_data['cabin_types'] = $cabin_types;

		$view_data['cabin_arrangements'] = get_tour_cabin_arrangements($tour, $check_rates);
	}

	/**
     * Load the Datepicker Element
	 */
	$datepicker_options = array();

	$datepicker_options['day_id'] = 'tour_day_'.$tour['id'];
	$datepicker_options['month_id'] = 'tour_month_'.$tour['id'];
	$datepicker_options['date_id'] = 'tour_date_'.$tour['id'];
	$datepicker_options['date_name'] = 'tour_date_'.$tour['id'];
	$datepicker_options['css'] = 'col-xs-5';
	$datepicker_options['loading_asyn'] = $loading_asyn;

	$datepicker_options['night_nr'] = $tour['duration'] - 1;

	if(!empty($check_rates['departure_date'])){
		$datepicker_options['departure_date'] = $check_rates['departure_date'];
	}
	
	// check tour schedule is available
	if (! empty($tour['departure'])) {
	    // for mekong cruise tours
        if (stripos($tour['departure'], 'ENUM') !== false) {
            $datepicker_options['upstream_dates'] = get_departure_date($tour['departure'], 'UPSTREAM');
            $datepicker_options['downstream_dates'] = get_departure_date($tour['departure'], 'DOWNSTREAM');
            
            if(!empty($datepicker_options['downstream_dates'])) {
                $datepicker_options['available_dates'] = array_merge($datepicker_options['upstream_dates'], $datepicker_options['downstream_dates']);
            } else {
                $datepicker_options['available_dates'] = $datepicker_options['upstream_dates'];
            }
        }
    }

	$view_data['datepicker'] = load_datepicker($is_mobile, $datepicker_options);

	$view_data['datepicker_options'] = $datepicker_options;

	$view_data['is_ajax'] = $CI->input->is_ajax_request();

	$data['check_rate_form'] = load_view('tours/check_rates/check_rate_form', $view_data, $is_mobile);

	return $data;
}

/**
 * Khuyenpv Feb 27 2015
 * Load tour rate table
 */
function load_tour_rate_table($data, $is_mobile, $tour, $is_book_together = false){

	if(empty($tour)){

		$data['tour_rate_table'] = '';

		return $data;
	}

	$CI =& get_instance();

	$CI->load->model('Tour_Model');

	$check_rates = get_tour_check_rate_from_url($tour);

	$view_data['tour'] = $tour;

	$view_data['check_rates'] = $check_rates;

	$view_data['is_book_together'] = $is_book_together;

	if(!empty($data['parent_id'])){
		$view_data['parent_id'] = $data['parent_id'];
	}

	// this data is saved from the function load_service_recommendation() calling before
	if(!empty($data['recommendations'])){
		$view_data['recommendations'] = $data['recommendations'];
	}

	// load the tour accommodations & detail acc infor view
	$departure_date = !empty($check_rates['departure_date']) ? $check_rates['departure_date'] : '';

	$accommodations = $CI->Tour_Model->get_tour_accommodations($tour['id'], $departure_date);
	foreach ($accommodations as $key => $value){
		$value['acc_info'] = load_acc_info($is_mobile, $value);
		$accommodations[$key] = $value;
	}
	$view_data['accommodations'] = $accommodations;

	// children - cabin - price - configuration
	$cabin_price_cnf = $CI->Tour_Model->get_children_cabin_price($tour['id']);
	$view_data['cabin_price_cnf'] = $cabin_price_cnf;
	
	// discount_together can be passed from the global $data
	$view_data['discount_together'] = empty($data['discount_together']) ? get_tour_discount_together($tour, $check_rates, $cabin_price_cnf) : $data['discount_together'];

	if(empty($check_rates)){ // not check-rate yet

		$data['tour_rate_table'] = load_view('tours/check_rates/tour_accommodations', $view_data, $is_mobile);

	} else {

		if(is_free_visa_tour($tour)){
			$view_data['popup_free_visa'] = load_free_visa_popup($is_mobile, true);
		}

		$view_data['cabin_arrangements'] = get_tour_cabin_arrangements($tour, $check_rates);

		$all_promotion_details = $CI->Tour_Model->get_all_tour_promotions($tour['id'], $departure_date);

		// group promotion details by each promtion
		$promotions = group_promotion_details_by_promotion($all_promotion_details);

		// get specific travel dates for each promotion
		$promotions = $CI->Tour_Model->get_travel_dates($promotions);

		$view_data['promotions'] = $promotions;



		// num_pax for price-index
		$view_data['num_pax'] = calculate_tour_nr_pax($tour, $view_data['cabin_arrangements'], $cabin_price_cnf, $check_rates);
		
		if(!$is_book_together){
			$view_data['get_params'] = $CI->input->get();
		}
		
		$view_data['optional_services'] = $CI->Tour_Model->get_tour_optional_services($tour['id'], $departure_date, $tour['duration']);

		$view_data['op_service_unit_types'] = $CI->config->item('unit_types');

		$view_data['is_ajax'] = $CI->input->is_ajax_request();

		$data['tour_rate_table'] = load_view('tours/check_rates/tour_rates', $view_data, $is_mobile);
		
		$data['optional_services'] = $view_data['optional_services']; // save for later using in Booking-Together Module
	}

	$data['discount_together'] = $view_data['discount_together']; // save to Data for later using

	return $data;
}

/**
 * Get the current tour departure date
 *
 * @author Khuyenpv
 * @since 02.04.2015
 */
function get_current_tour_departure_date($tour = ''){

	$departure_date = date(DATE_FORMAT_STANDARD);

	$check_rates = !empty($tour) ? get_tour_check_rate_from_url($tour) : array();

	if(!empty($check_rates['departure_date'])){

		$departure_date = $check_rates['departure_date'];

	} else {

		$lasted_search = get_last_search(TOUR_SEARCH_HISTORY);

		if(!empty($lasted_search['departure_date'])){

			$departure_date = $lasted_search['departure_date'];
		}

	}

	if (date(DB_DATE_FORMAT, strtotime($departure_date)) < date(DB_DATE_FORMAT)){
		$departure_date = date(DATE_FORMAT_STANDARD);
	}

	return $departure_date;
}

/**
 * Khuyenpv Feb 27 2015
 * Load tour booking conditions
 */
function load_tour_booking_conditions($data, $is_mobile, $tour, $cruise = ''){

	$CI =& get_instance();

	if(empty($tour)){
		$data['tour_booking_conditions'] = '';
		return $data;
	}


	$check_rates = get_tour_check_rate_from_url($tour);

	if(empty($check_rates) && empty($cruise)){ // only load booking conditions after check rates
		$data['tour_booking_conditions'] = '';
	} else {

        if(!empty($tour['policies']['cancellation']))
            $tour['cancellation_policy'] = implode("\n", $tour['policies']['cancellation']);

        if(!empty($tour['policies']['children_extrabed']))
            $tour['children_extrabed'] = implode("\n", $tour['policies']['children_extrabed']);

		$view_data['tour'] = $tour;

		$view_data['cruise'] = $cruise;

		if($tour['cruise_id'] > 0 &&  $tour['cruise_destination'] == 0){ // cancellation due to bad weather in Halong Bay
			$view_data['cancellation_weather'] = load_view('common/others/cancellation_weather', array(), $is_mobile);
		} else {
			$view_data['cancellation_weather'] = '';
		}

		$data['tour_booking_conditions'] = load_view('tours/check_rates/tour_booking_conditions', $view_data, $is_mobile);
	}

	return $data;
}
/**
 * Set special offers for list of tours
 *
 * @author Khuyenpv
 * @since 10.04.2015
 */
function set_tour_special_offers($tours){

	$CI =& get_instance();

	$CI->load->model('Tour_Model');

	$tours = $CI->Tour_Model->get_tour_special_offers($tours);

	foreach ($tours as $key=>$tour){
		$promotions = $tour['promotions'];

		$tour['special_offers'] = empty($promotions) ? '' : load_promotion_popup(is_mobile(), $promotions[0]);

		$tours[$key] = $tour;
	}

	return $tours;
}

/* ------------------
 * check symnonym words in travel style url
 * ------------------
 */
function is_symnonym_words($text, $lang_code = null)
{
    $CI = & get_instance();

    if (empty($lang_code))
    {
        $lang_code = lang_code();
    }

    $tour_symnonym = $CI->config->item('tour_symnonym_' . $lang_code);

    if (! empty($tour_symnonym))
    {
        foreach ($tour_symnonym as $word)
        {
            if (stripos($text, $word) !== false)
            {
                return TRUE;
            }
        }
    }

    return FALSE;
}

/**
 * Load tour rich snippet
 *
 * @author toanlk
 * @since  Mar 18, 2015
 */
function load_rich_snippet($data, $destination_id, $destination_name)
{
    $CI = & get_instance();

    $rich_snippet_data = $CI->Tour_Model->get_rich_snippet_destination_review($destination_id);

    $rich_snippet_data['title'] = lang_arg('title_tour_destination', $destination_name);

    $view_data['rich_snippet'] = $rich_snippet_data;

    $data['rich_snippet'] = $CI->load->view('common/others/rich_snippet', $view_data, TRUE);

    return $data;
}

/**
 * Get group type of tour
 *
 * @author toanlk
 * @since  Mar 18, 2015
 */
function get_group_type($group_type)
{
    $CI = & get_instance();

    $str_type = '';

    $group_types = $CI->config->item('group_types');

    foreach ($group_types as $key => $type)
    {
        if (is_bit_value_contain($group_type, $key))
        {
            $str_type .= strtolower(lang($type)) . ', ';
        }
    }

    $str_type = rtrim(trim($str_type), ',');

    return ucfirst($str_type);
}

/**
 * Check if a tour is free visa or not
 *
 * @author Khuyenpv 20.03.2015
 */
function is_free_visa_tour($tour){
	if(is_visitor_in_hanoi()) return false; // visitor from Hanoi don't see free visa

	return $tour['cruise_id'] > 0; // cruise tour has the free visa
}

/**
 *
 * Get Cruise Data from Cruise
 *
 * @author Khuyenpv 26.03.2015
 */
function get_cruise_data_from_tour($tour){

	// get cruise data from tour
	if(!empty($tour['cruise_name'])){
		$cruise['id'] = $tour['cruise_id'];
		$cruise['name'] = $tour['cruise_name'];
		$cruise['url_title'] = $tour['cruise_url_title'];
		$cruise['cruise_destination'] = $tour['cruise_destination'];

		return $cruise;
	}

	return array();
}

/**
 * Get rich snippet
 *
 * @author toanlk
 * @since  Apr 6, 2015
 */
function get_rich_snippet($data, $title, $page)
{
    $CI = & get_instance();

    $view_rich_snippet = '';

    $rich_snippet = $CI->Cruise_Model->get_rich_snippet_review($page);

    if (! empty($rich_snippet))
    {
        $rich_snippet['title'] = $title;

        $view_data['rich_snippet'] = $rich_snippet;

        $view_rich_snippet = $CI->load->view('common/others/rich_snippet', $view_data, true);
    }

    $data['rich_snippet'] = $view_rich_snippet;

    return $data;
}

/**
 *  Show partner in tour
 *
 *  @author toanlk
 *  @since  Oct 22, 2014
 */
function get_partner_name($tour, $character_limit = null)
{
    $txt = '';
    // if the tour partner is BestPrice Vietnam => no show partner name
    if (isset($tour['partner_id']) && $tour['partner_id'] == PARTNER_BEST_PRICE_VIETNAM){
        return $txt;
    }

    if (isset($tour['show_partner']) && $tour['show_partner'] == STATUS_ACTIVE) // modified by Khuyenpv on Feb 13 2015
    {

        $partner_name = $tour['partner_name'];

        if (! empty($character_limit))
        {
            $partner_name = character_limiter($partner_name, $character_limit, '');
        }

        $txt = '<span class="partner-name">' . lang('by') . ' ' . $partner_name . '</span>';
    }

    return $txt;
}

/**
 * get departure short
 *
 * @author toanlk
 * @since  Apr 11, 2015
 */
function get_departure_short($departure, $departure_title)
{
    $departure = trim($departure);
    $str_up = 'UPSTREAM';
    $str_down = 'DOWNSTREAM';
    $more_dot = ' <a href="javascript:void(0)" class="tour_departure" data-placement="bottom" data-target="#tour_departure" data-title="'.$departure_title.'">...</a>';

    // Specific shedule format
    if (is_enum($departure))
    {

        if (stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false)
        {
            $depart_up = get_departure_date($departure, $str_up, DEPARTURE_MONTH_SHOW_LIMIT);
            $depart_down = get_departure_date($departure, $str_down, DEPARTURE_MONTH_SHOW_LIMIT);

            $str_depart_up = '';
            if (! empty($depart_up))
            {
                $str_depart_up = departure_shorten(get_departure_text(lang('label_upstream'), $depart_up), 135, ",", '') .
                     $more_dot;
            }

            $str_depart_down = '';
            if (! empty($depart_down))
            {
                $str_depart_down = "<span style='margin-top:5px; float:left; padding-right:5px'>" .
                     departure_shorten(get_departure_text(lang('label_downstream'), $depart_down), 135, ",", '') . $more_dot .
                     "</span>";
            }

            $departure = $str_depart_up . $str_depart_down;
        }
        else
        {
            $depart_round_trip = get_departure_date($departure, "", DEPARTURE_MONTH_SHOW_LIMIT);
            $departure = get_departure_text("", $depart_round_trip) . " " . $more_dot;
        }
    }
    else
    {
        // Plain text format
        if (stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false)
        {
            $arr = explode("\n", $departure);
            $depart_up = isset($arr[0]) ? $arr[0] : '';
            $depart_down = isset($arr[0]) ? $arr[1] : '';
            if (! empty($depart_up))
                $depart_up = character_limiter($depart_up, 65, ' ') . $more_dot;
            if (! empty($depart_down))
                $depart_down = character_limiter($depart_down, 65, ' ') . $more_dot;

            $departure = $depart_up . "<span style='margin-top:5px; float:left; padding-right:5px'>" . $depart_down .
                 "</span>";
        }
        else
        {
            if (strlen($departure) > 100)
            {
                $departure = character_limiter($departure, 100, ' ') . $more_dot;
            }
        }
    }

    return $departure;
}

function get_departure_full($departure) {

    $str ="";
    $str_up ='UPSTREAM'; $str_down ='DOWNSTREAM';
    $departure = trim($departure);

    if(is_enum($departure)) {

        if(stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false) {
            $depart_up = get_departure_date($departure, $str_up);
            $depart_down = get_departure_date($departure, $str_down);

            $str = '<table class="table-bordered table-departure">';
            $str .= "<tr>";
            $current_month = "";
            for ($i = 1; $i <= 12; $i++) {
                if($i==1) $str .= '<td style="font-weight:bold" colspan="2">'.lang('label_cruise_schedule').'</td>';
                $str .= '<td style="font-weight:bold;width:130px">'.strftime( '%b', mktime( 0, 0, 0, $i, 1 ) )."</td>";
            }
            $str .= "</tr>";

            $years = get_text_depart_year($departure, true);
            if(!empty($years)) {
                foreach ($years as $year) {
                    $count_year = 0;
                    $str .= "<tr>";
                    if(is_roundtrip($departure)) {
                        $str .= '<td>&nbsp;</td>';
                    } else {
                        $str .= '<td style="font-weight:bold" rowspan="2">'.$year.'</td>'.'<td style="font-weight:bold">'.lang('label_upstream').'</td>';
                    }

                    if(!empty($depart_up)) {
                        for ($i = 1; $i <= 12; $i++) {
                            $depart = trim($year).'-'.$i.'-1';
                            $txtDay = get_text_depart_day($depart_up, $depart);
                            if(empty($txtDay)) $txtDay = '&nbsp;';
                            $str .= "<td>".$txtDay."</td>";
                        }
                    }

                    $str .= "</tr>";

                    $str .= "<tr>";
                    if(is_roundtrip($departure)) {
                        $str .= '<td>&nbsp;</td>';
                    } else {
                        $str .= '<td style="font-weight:bold">'.lang('label_downstream').'</td>';
                    }
                    if(!empty($depart_down)) {
                        for ($i = 1; $i <= 12; $i++) {
                            $depart = trim($year).'-'.$i.'-1';
                            $txtDay = get_text_depart_day($depart_down, $depart);
                            if(empty($txtDay)) $txtDay = '&nbsp;';
                            $str .= "<td>".$txtDay."</td>";
                        }
                    }

                    $str .= "</tr>";
                }
            }


            $str .= "</table>";
        } else {
            $depart_up = get_departure_date($departure);

            $str = '<table class="tbl_departs" cellspacing=0>';
            $str .= "<tr>";
            $current_month = "";
            for ($i = 1; $i <= 12; $i++) {
                if($i==1) $str .= '<td style="font-weight:bold">'.lang('label_cruise_schedule').'</td>';
                $str .= '<td style="font-weight:bold">'.strftime( '%b', mktime( 0, 0, 0, $i, 1 ) )."</td>";
            }
            $str .= "</tr>";
            $years = get_text_depart_year($departure, true);
            if(!empty($years)) {
                foreach ($years as $year) {
                    $count_year = 0;
                    $str .= "<tr>";
                    $str .= '<td align="center" style="font-weight:bold">'.$year.'</td>';

                    for ($i = 1; $i <= 12; $i++) {
                        $depart = trim($year).'-'.$i.'-1';
                        $txtDay = get_text_depart_day($depart_up, $depart);
                        if(empty($txtDay)) $txtDay = '&nbsp;';
                        $str .= "<td>".$txtDay."</td>";
                    }
                    $str .= "</tr>";
                }
            }
            $str .= "</table>";
        }

    } else {
        $str = str_replace("\n", '<br/>', $departure);
        $str = str_replace("\r", '<br/>', $str);
    }

    return $str;
}

function get_departure_text($direction, $arrDate)
{
    $str_depart = "";
    if (! empty($direction))
        $str_depart = '<span class="text-highlight">' . $direction . ':&nbsp;&nbsp;</span>';

    $current_month = "";
    $current_year = "";
    $cnt = 0;
    foreach ($arrDate as $key => $depart)
    {
        if ($key == 0)
        {
            $str_depart .= "<b>" . date("Y", strtotime($depart)) . ": </b>";
            $current_year = date("Y", strtotime($depart));
        }
        if ($current_month != date("M", strtotime($depart)))
        {
            if (! empty($current_month))
                $str_depart .= " | ";

            if ($current_year != date("Y", strtotime($depart)) && $key > 0)
            {
                $current_year = date("Y", strtotime($depart));
                $str_depart .= "<b>" . date("Y", strtotime($depart)) . ": </b>";
            }

            $str_depart .= date("M j", strtotime($depart));
            $current_month = date("M", strtotime($depart));
            $cnt = 1;
        }
        else
        {
            if ($cnt > 0)
                $str_depart .= ", ";
            $str_depart .= date("j", strtotime($depart));
            $cnt ++;
        }
    }
    return trim($str_depart);
}

/**
 * get tour transportation
 *
 * @author toanlk
 * @since  Apr 13, 2015
 */
function get_icon_transportation($transportations, $is_first_only = false)
{
    $txt= '';

    $CI = & get_instance();

    $trans_config = $CI->config->item('tour_transportations');

    if(!empty($transportations))
    {
        foreach ($trans_config as $key => $value)
        {
            if( is_bit_value_contain($transportations, $key) )
            {
                $txt .= '<span class="icon '.$value['icon'].'"></span>';

                // get only first icon
                if($is_first_only) break;
            }
        }

        $txt = rtrim(trim($txt), ',');
    }

    return $txt;
}

/**
 * load_photo_map
 *
 * @author toanlk
 * @since  Apr 14, 2015
 */
function load_photo_map($data, $photos, $is_mobile) {
    $CI = & get_instance();

    $map_photos = '';

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    if (! empty($photos))
    {
        foreach ($photos as $k => $photo) {
            $photo['src'] = get_image_path(PHOTO_FOLDER_TOUR, $photo['name'], 'mediums');
            $photo['upload_src'] = get_image_path(PHOTO_FOLDER_TOUR, $photo['name'], 'origin');
            $photos[$k] = $photo;
        }

        $data['photo_maps'] = $photos;

        $map_photos = $CI->load->view($mobile_folder . 'tours/common/photo_map', $data, TRUE);
    }

    $data['map_photos'] = $map_photos;

    return $data;
}

function load_top_tour_destinations($data, $is_mobile) {
    
    $CI = & get_instance();

    $CI->load->model(array('Tour_Model',  'Destination_Model'));

    $view_data['country_name'] = $CI->config->item('indochina_destinations_name');

    foreach ($view_data['country_name'] as $key => $value) {
        $view_data['country_name'][$key] = $CI->Destination_Model->get_destination($key);
    }
    
    if(!empty($data['destination'])) $view_data['destination'] = $data['destination'];
    
    $view_data['country_flag'] = $CI->config->item('indochina_destinations_flag');

    $view_data['destinations'] = $CI->Tour_Model->get_top_tour_destination();

    $data['top_tour_destinations'] = load_view('tours/common/top_tour_destinations', $view_data, $is_mobile);

    return $data;
}

/**
 * is_best_of_destination
 *
 * @author toanlk
 * @since  Jun 2, 2015
 */
function is_best_of_destination($destination, $travel_style) {
    
    if ($destination['destination_type'] == DESTINATION_TYPE_COUNTRY
        && stripos($travel_style['url_title'], 'best-of') !== false)
    {
        return true;
    }
    return false;
}
?>