<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Search Tour Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 06 2015
 */

/**
 * Khuyenpv Feb 06 2015
 * Load the Tour Search Form
 * @param $data
 * @param $is_mobile
 * @param $is_home_page : check if loading form for the home page or not
 */
function load_tour_search_form($data, $is_mobile, $search_criteria = array(), $display_mode = '', $show_type_tour = '', $loading_asyn = true){
	
	$CI =& get_instance();
	
	$datepicker_options = array();
	
	$datepicker_options['day_id'] = 'departure_day';
	$datepicker_options['month_id'] = 'departure_month';
	$datepicker_options['date_id'] = 'departure_date';
	$datepicker_options['date_name'] = 'departure_date';
	$datepicker_options['css'] = $display_mode == VIEW_PAGE_HOME ? 'col-xs-2':'col-xs-5';//$is_home_page ?  
	$datepicker_options['loading_asyn'] = $loading_asyn;
	
	if(!empty($search_criteria['departure_date'])){
		
		$datepicker_options['departure_date'] = $search_criteria['departure_date'];
		
	}
	
	//$datepicker_options['available_dates'] = array('04-03-2015', '20-03-2015', '20-04-2015', '22-04-2015');
	
	$view_data['datepicker'] = load_datepicker($is_mobile, $datepicker_options);
	
	// load tour types
	$travel_styles = $CI->config->item('tour_travel_styles');
	$view_data['tour_travel_styles'] = $travel_styles;
	
	// load tour durations
	$tour_durations = $CI->config->item("duration_search");
	$view_data['tour_durations'] = $tour_durations;
	
	// load tour group types
	$tour_group_types = $CI->config->item("tour_group_types");
	$view_data['tour_group_types'] = $tour_group_types;
	
	// load tour buget
	$tour_budgets = $CI->config->item('tour_budgets');
	$view_data['tour_budgets'] = $tour_budgets;
	
	$view_data['search_criteria'] = $search_criteria;
	
	// go to page of specific destination
	if(!empty($data['destination'])){
		$view_data['destination'] = $data['destination'];
	}
	
	$view_data['show_type_tour'] = $show_type_tour;
	
	if(isset($data['multiple_search_forms'])){
		$view_data['multiple_search_forms'] = '1';
	}
	
	if(isset($data['tour_search_overview'])){
		$view_data['tour_search_overview'] = '1';
	}
	
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
			$view_data['css_height_form'] = 'search-height-form';
			$view_data['css_content'] = 'search-form-type-3';
			break;
		case VIEW_PAGE_DEAL:
			$view_data['is_home_page'] = false;
			$view_data['css_content'] = 'search-form-type-4';
			$view_data['css'] = 'padding-5';
			break;
	}
	
	$mobile_folder = $is_mobile ? 'mobile/' : '';
	
	$data['tour_search_form'] = $CI->load->view($mobile_folder.'tours/search/search_form', $view_data, TRUE);
	
	return $data;
}

/**
 * Khuyenpv Feb 06 2015
 * Load the Tour Search Overview Form
 * @param $data
 */
function load_tour_search_overview($data, $is_mobile, $search_criteria){
	
	$CI =& get_instance();
	
	if(!$is_mobile){
		$mobile_folder = $is_mobile ? 'mobile/' : '';
		
		$view_data['search_criteria'] = $search_criteria;
		
		$data['tour_search_overview'] = $CI->load->view($mobile_folder.'tours/search/search_overview', $view_data, TRUE);
	} else {
		$data['tour_search_overview'] = '';
	}

	return $data;
}

/**
 * Get the search-criteria based on url parameters
 * Return Empty if the search-parameter is invalid
 * 
 * @author		khuyenpv
 * @since       Feb 10 2015
 */
function get_tour_search_criteria_from_url(){

	$CI =& get_instance();
	
	$destination = $CI->input->get('destination');
	$destination_id = $CI->input->get('destination_id');
	$departure_date = $CI->input->get('departure_date');

	$travel_styles = $CI->input->get('travel_styles');
	$travel_styles = empty($travel_styles) ? array() : $travel_styles;
	
	// depature-date is today if missing this parameter
	$departure_date = $CI->input->get('departure_date');
	$departure_date = empty($departure_date) ? date(DATE_FORMAT_STANDARD) : $departure_date;
	
	
	$duration = $CI->input->get('duration');
	$group_type = $CI->input->get('group_type');
	
	$budgets = $CI->input->get('budgets');
	$budgets = empty($budgets) ? array() : $budgets;
	
	$search_criteria['destination'] = $destination;
	$search_criteria['destination_id'] = $destination_id;
	$search_criteria['departure_date'] = $departure_date;
	$search_criteria['travel_styles'] = $travel_styles;
	$search_criteria['duration'] = $duration;
	$search_criteria['group_type'] = $group_type;
	$search_criteria['budgets'] = $budgets;
	
	/*
	 * For filter parameters
	 */
	$tour_sort_by = $CI->config->item('tour_sort_by');
	$sort_by = $CI->input->get('sort');
	if(empty($sort_by) || !array_key_exists($sort_by, $tour_sort_by)){
		$keys = array_keys($tour_sort_by);
		$sort_by = $keys[0];
	}
	$search_criteria['sort_by'] = $sort_by;
	
	// page parameter
	$page = $CI->input->get('page');
	$search_criteria['page'] = $page;

	// cruise cabins
	$cruise_cabin = $CI->input->get('cruise_cabin');
	$search_criteria['cruise_cabin'] = $cruise_cabin;
	
	// cruise_properties
	$cruise_properties = $CI->input->get('cruise_properties');
	$search_criteria['cruise_properties'] = !empty($cruise_properties) ? $cruise_properties : array();
	
	// things to do
	$activities = $CI->input->get('activities');
	$search_criteria['activities'] = !empty($activities) ? $activities : array();
	
	// destination travel styles
	$des_styles = $CI->input->get('des_styles');
	$search_criteria['des_styles'] = !empty($des_styles) ? $des_styles : array();
	
	// sub destinations
	$sub_des = $CI->input->get('sub_des');
	$search_criteria['sub_des'] = !empty($sub_des) ? $sub_des : array();
	
	return $search_criteria;
}

/**
 * Check if the current seach is valid or not
 *
 * @author		khuyenpv
 * @since       Feb 13 2015
 */
function is_valid_tour_search($search_criteria){
	
	if(empty($search_criteria['destination']) || empty($search_criteria['destination_id'])) return false;
	
	return true;
}

/**
 * Create the label for sub destination of search filter
 *
 * @author		khuyenpv
 * @since       Feb 13 2015
 */
function create_sub_destination_label($destination){
	
	$label = '';
	
	if($destination['type'] < DESTINATION_TYPE_COUNTRY){
		$label = lang('country_in', $destination['name']);
	} elseif($destination['type'] == DESTINATION_TYPE_COUNTRY){
		$label = lang('popular_cities_in', $destination['name']);
	} else {
		$label = lang('attraction_in', $destination['name']);
	}
	
	return $label;
}

/**
 * Check if the Search has Fitler Actions
 *
 * @author		khuyenpv
 * @since       Feb 13 2015
 */
function has_filters($search_criteria){
	return !empty($search_criteria['cruise_cabin']) || !empty($search_criteria['cruise_properties']) || !empty($search_criteria['activities'])
	|| !empty($search_criteria['des_styles']) || !empty($search_criteria['sub_des']);
}

/**
 * Get filtered item names
 *
 * @author		khuyenpv
 * @since       Feb 13 2015
 */
function get_filtered_item_name($id, $arr_vals){
	foreach ($arr_vals as $value){
		if($value['id'] == $id) return $value['name'];
	}
	
	if($id == -1){
		return lang('has_tripple_family_cabin');
	}
	
	return '';
}

/**
 * Get Tour Search Values based on Configuration
 *
 * @author		khuyenpv
 * @since       Feb 14 2015
 */
function get_tour_search_criteria_values($search_criteria_values, $config_name, $is_using_translate_text = false){
	
	$CI =& get_instance();
	
	$config_items = $CI->config->item($config_name);
	
	if(is_array($search_criteria_values)){
		
		$ret = array();
		
		foreach ($config_items as $key=>$value){
			
			$value_text = $is_using_translate_text ? translate_text($value) : lang($value);
			
			if(in_array($value_text, $search_criteria_values)) $ret[] = $key;
		
		}
		
		return $ret;
		
	} else {

		$ret = '';
		
		foreach ($config_items as $key=>$value){
				
			$value_text = $is_using_translate_text ? translate_text($value) : lang($value);
				
			if($value_text == $search_criteria_values) $ret = $key;
		
		}
		
		return $ret;
	}
}

/**
 * Check if show filter for Cruise Property or Not
 * 
 * @author Khuyenpv
 * @since 11.04.2015
 */
function is_show_cruise_facilitiy_filter($destination, $search_criteria){
	
	if($destination['id'] == HALONG_BAY) return true;
	
	if(!empty($search_criteria['travel_styles']) && in_array(lang('lbl_cruise_tour'), $search_criteria['travel_styles'])){
		return true;
	}
	
	return false;
}

/**
 * Load the most recommen items
 * 
 * @author Khuyenpv
 * @since 13.04.2015
 */
function load_most_recommend_item($is_mobile, $tour, $departure_date){
	
	$CI =& get_instance();

	$CI->load->model('BookingModel');
	
	$search_criteria['departure_date'] = $departure_date;
	
	if(!$is_mobile){ // only load for the desktop version
		
		if ($tour['has_special_discount'] == STATUS_ACTIVE){
		
			$service_id = $tour['id'];
		
			$service_type = $tour['cruise_id'] > 0 ? CRUISE : TOUR;
		
			$most_rec_service = $CI->BookingModel->get_most_recommended_service($service_id, $service_type, $departure_date);
			
			if(empty($most_rec_service)) return ''; // if the tour don't have any recommend item
		
			$view_data['tour'] = $tour;
			$view_data['most_rec_service'] = $most_rec_service;
			

			$view_data['search_criteria'] = $search_criteria;
			
			return load_view('tours/common/recommend_item', $view_data, $is_mobile);
		}
	}
	
	return '';
}

?>