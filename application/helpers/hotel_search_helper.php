<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Search Hotel Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 06 2015
 */

/**
 * Khuyenpv Feb 06 2015
 * Load the Hotel Search Form
 * @param $data
 * @param $is_mobile
 * @param $is_home_page : check if loading form for the home page or not
 */
function load_hotel_search_form($data, $is_mobile, $search_criteria = array(), $display_mode = '', $loading_asyn = true){

	$CI =& get_instance();

    $CI->config->load('hotel_meta');

    //load datepicker
    $datepicker_options = array();

    $datepicker_options['day_id'] = 'start_day';
    $datepicker_options['month_id'] = 'start_month';
    $datepicker_options['date_id'] = 'start_date';
    $datepicker_options['date_name'] = 'start_date';
    $datepicker_options['css'] = $display_mode == VIEW_PAGE_HOME ? 'col-xs-2' : 'col-xs-5';
    $datepicker_options['night_nr_id'] = 'hotel_night_nr';
    $datepicker_options['loading_asyn'] = $loading_asyn;


    if(!empty($search_criteria['start_date'])){

        $datepicker_options['departure_date'] = $search_criteria['start_date'];

    }

    if(!empty($data['hotel_search_overview']))
        $view_data['hotel_search_overview'] = $data['hotel_search_overview'];

    if(isset($data['multiple_search_forms'])){
    	$view_data['multiple_search_forms'] = '1';
    }

    $view_data['datepicker'] = load_datepicker($is_mobile, $datepicker_options);

    $view_data['hotel_stars'] = $CI->config->item('Hotel_Star');

    $view_data['night'] = $CI->config->item('Hotel_Night');

	switch ($display_mode){
		case VIEW_PAGE_HOME:
			$view_data['is_home_page'] = true;
			$view_data['css_content'] = 'search-form-type-1';
			$view_data['css'] = 'padding-5';
			break;
		case VIEW_PAGE_ADVERTISE:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-2';
			$view_data['css'] = 'padding-5';
			break;
		case VIEW_PAGE_NOT_ADVERTISE:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-3';
			break;
		case VIEW_PAGE_DEAL:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-4';
			$view_data['css'] = 'padding-5';
			break;
	}

    $view_data['search_criteria'] = $search_criteria;

    $view_data['datepicker_options'] = $datepicker_options;

	$data['hotel_search_form'] = load_view('hotels/search/search_form', $view_data, $is_mobile);

	return $data;
}

/**
 * Khuyenpv Feb 06 2015
 * Load the Hotel Search Overview Form
 * @param $data
 */
function load_hotel_search_overview($data, $is_mobile = false, $search_criteria){
    $CI =& get_instance();

    if(!$is_mobile){

        $view_data['search_criteria'] = $search_criteria;

        $data['hotel_search_overview'] = load_view('hotels/search/search_overview', $view_data, $is_mobile);
    } else {
        $data['hotel_search_overview'] = '';
    }

    return $data;
}

/**
 * Get the search-criteria based on url parameters
 * Return Empty if the search-parameter is invalid
 *
 * @author		TinVM
 * @since       May 28 2015
 */
function get_hotel_search_criteria_from_url(){

    $CI =& get_instance();

    $destination = $CI->input->get('destination');
    $destination_id = $CI->input->get('destination_id');
    $stars  = $CI->input->get('stars');
    $night = $CI->input->get('night');
    $hotel_id = $CI->input->get('hotel_id');

    // depature-date is today if missing this parameter
    $start_date = $CI->input->get('start_date');
    $start_date = empty($start_date) ? date(DATE_FORMAT_STANDARD) : $start_date;

    $search_criteria['destination'] = $destination;
    $search_criteria['destination_id'] = $destination_id;
    $search_criteria['start_date'] = $start_date;
    $search_criteria['night'] = $night;
    $search_criteria['stars'] = $stars;
    
    $search_criteria['hotel_id'] = $hotel_id;

    /*
	 * For filter parameters
	 */
    $hotel_sort_by = $CI->config->item('hotel_sort_by');
    $sort_by = $CI->input->get('sort');
    if(empty($sort_by) || !array_key_exists($sort_by, $hotel_sort_by)){
        $keys = array_keys($hotel_sort_by);
        $sort_by = $keys[0];
    }
    $search_criteria['sort_by'] = $sort_by;

    // page parameter
    $page = $CI->input->get('page');
    $search_criteria['page'] = $page;

    return $search_criteria;
}

/**
 * Check if the current seach is valid or not
 *
 * @author		TinVM
 * @since       May 28 2015
 */
function is_valid_hotel_search($search_criteria){

    if(empty($search_criteria['destination']) || (empty($search_criteria['destination_id']) && empty($search_criteria['hotel_id']))) return false;

    return true;
}

?>