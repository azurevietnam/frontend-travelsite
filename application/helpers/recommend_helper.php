<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * For Serivce Recommendation
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 27 2015
 */

function load_service_recommendation($data, $is_mobile, $current_item_info, $departure_date = '', $show_header = true, $show_bgr = TRUE){

	$data['recommendations'] = array(); //default is empty

	if(!$is_mobile){

		$CI =& get_instance();

		$CI->load->model('BookingModel');

		$view_data['current_item_info'] = $current_item_info;

		$view_data['show_header'] = $show_header;

		if(empty($departure_date)){

			$departure_date = $current_item_info['start_date'];
		}

		if(!empty($current_item_info)){
			$view_data['recommendations'] = $CI->BookingModel->get_recommendations($current_item_info, $departure_date);
		} else {
			$view_data['recommendations'] = $CI->BookingModel->get_remaining_recommendations($departure_date);
		}

		$view_data['recommend_css'] = ($show_bgr == true) ? 'bgr-quick-search' : '';

		$data['recommendations'] = $view_data['recommendations']; // save the to the global DATA for later used

		$data['recommend_sevices'] = load_view('common/recommend/recommend_services', $view_data, $is_mobile);

	} else {

		$data['recommend_sevices'] = '';
	}

	return $data;
}

/**
 * Load the general RECOMMEND SUBMIT FORM DATA
 *
 * @author Khuyenpv
 * @since 04.04.2015
 */
function load_recommend_form_data($destination_id, $service_type, $block_id, $current_item_info, $quick_search = ''){

	if(empty($current_item_info)) return ''; // return empty if no current-item-booking

	$view_data['destination_id'] = $destination_id;

	$view_data['service_type'] = $service_type;

	$view_data['block_id'] = $block_id;

	$view_data['current_item_info'] = $current_item_info;

	$view_data['quick_search'] = $quick_search;

	return load_view('common/recommend/recommend_form_data', $view_data, false);
}

/**
 * Load the Tour Quick Search Form
 *
 * @author Khuyenpv
 * @since 04.04.2015
 */
function load_tour_quick_search($block_id, $search_params){

	$CI =& get_instance();

	$CI->load->config('tour_meta');

	$view_data['block_id'] = $block_id;

	$view_data['dur_list'] = $CI->config->item("duration_search");

	$view_data['tour_sort_by'] = $CI->config->item('tour_sort_by');

	$view_data['search_params'] = $search_params;

	$quick_search = load_view('common/recommend/quick_tour_search', $view_data, false);

	return $quick_search;
}

/**
 * Load the Hotel Quick Search Form
 *
 * @author Khuyenpv
 * @since 04.04.2015
 */
function load_hotel_quick_search($block_id, $search_params){

	$CI =& get_instance();

	$CI->load->config('hotel_meta');

	$view_data['block_id'] = $block_id;

	$view_data['hotel_sort_by'] = $CI->config->item('hotel_sort_by');

	$view_data['search_params'] = $search_params;

	$quick_search = load_view('common/recommend/quick_hotel_search', $view_data, false);

	return $quick_search;
}

/**
 * Get the tour quick search post data
 *
 * @author Khuyenpv
 * @since 04.04.2015
 */
function get_tour_quick_search_params($block_id){

	$CI =& get_instance();

	$quick_seach_params['destination'] = $CI->input->post('destination_'.$block_id);
	$quick_seach_params['destination_id'] = $CI->input->post('destination_id_'.$block_id);
	$quick_seach_params['duration'] = $CI->input->post('duration');
	$quick_seach_params['sort_by'] = $CI->input->post('sort_by');

	if(empty($quick_seach_params['sort_by'])) $quick_seach_params['sort_by'] = 'recommend'; // by default

	return $quick_seach_params;
}


/**
 * Get the hotel quick search post data
 *
 * @author Khuyenpv
 * @since 05.04.2015
 */
function get_hotel_quick_search_params($block_id){

	$CI =& get_instance();

	$quick_seach_params['destination'] = $CI->input->post('destination_'.$block_id);
	$quick_seach_params['destination_id'] = $CI->input->post('destination_id_'.$block_id);
	$quick_seach_params['hotel_id'] = $CI->input->post('hotel_id_'.$block_id);
	$quick_seach_params['stars'] = $CI->input->post('stars');
	$quick_seach_params['sort_by'] = $CI->input->post('sort_by');

	if(empty($quick_seach_params['sort_by'])) $quick_seach_params['sort_by'] = 'recommend'; // by default

	return $quick_seach_params;
}

/**
 * Get the current item info from Post data
 *
 * @author Khuyenpv
 * @since 04.04.2015
 */
function get_current_item_info_post_data(){

	$CI =& get_instance();

	// current booking item
	$current_item_info = array();

	$current_item_info['service_id'] = $CI->input->post('current_service_id');

	$current_item_info['service_type'] = $CI->input->post('current_service_type');

	$current_item_info['url_title'] = $CI->input->post('current_service_url_title');

	$current_item_info['is_main_service'] = $CI->input->post('current_service_is_main_service');

	$current_item_info['is_main_service'] = $current_item_info['is_main_service'] == 1 ? true : false;

	$current_item_info['normal_discount'] = $CI->input->post('current_service_normal_discount');

	$current_item_info['destination_id'] = $CI->input->post('current_service_destination_id');

	$current_item_info['is_booked_it'] = $CI->input->post('current_service_is_booked_it');

	$current_item_info['is_booked_it'] = $current_item_info['is_booked_it'] == 1 ? true : false;

	$current_item_info['start_date'] = $CI->input->post('start_date');

	$current_item_info['parent_id'] = $CI->input->post('parent_id');

	return $current_item_info;
}

/**
 * Set Discount-Together Information for list of Services
 *
 * @author Khuyenpv
 * @since 05.04.2015
 */
function set_disount_together_for_services($services, $current_item_info, $is_hotel = false){

	$CI =& get_instance();

	if(empty($services)) return $services;

	if (!$current_item_info['is_booked_it']){

		$special_discounts = $CI->BookingModel->get_discounts($current_item_info['service_id'], $current_item_info['service_type']);

	}

	foreach ($services as $key => $value) {

		$service_id = $value['id'];

		if($is_hotel){

			$service_type = HOTEL;
			// the hotel is NOT main service
			$is_main_service = false;  //$this->BookingModel->is_main_service($destination_id, HOTEL);
			$normal_discount = isset($value['discount']) ? $value['discount'] : 0;

		} else {

			$service_type = $value['cruise_id'] > 0 ? CRUISE : TOUR;
			$is_main_service = $CI->BookingModel->is_main_service($value['main_destination_id'], $service_type);
			$normal_discount = isset($value['price']['discount']) ? $value['price']['discount'] : 0;

		}

		$discount_coefficient = 1; // per pax

		$value['is_special_discounted'] = false;

		// the current service is already booked
		if ($current_item_info['is_booked_it']){

			$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);

			if($is_hotel){
				$value['discount'] = $discount_together['discount'];
			}  else {
				$value['price']['discount'] = $discount_together['discount'];
			}

			$value['is_discounted'] = $discount_together['is_discounted'];

		} else {

			$value['is_discounted'] = true;

			$special_discount_value = get_discount_2_services($current_item_info['service_id'], $current_item_info['service_type'], $service_id, $service_type, $special_discounts);

			if ($special_discount_value > 0){

				if($is_hotel){
					$value['discount'] = $special_discount_value;
				}  else {
					$value['price']['discount'] = $special_discount_value;
				}

				$value['is_special_discounted'] = true;
			}

		}


		// set price information for the service
		$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);

		$value['service_type'] = $service_type;

		$services[$key] = $value;
	}

	return $services;
}

/**
 * Load the service Item View
 *
 * @author Khuyenpv
 * @since 05.04.2015
 */
function load_service_recommend_item($service, $service_type, $current_item_info){

	$view_data['service_type'] = $service_type;
	$view_data['service'] = $service;
	$view_data['current_item_info'] = $current_item_info;

	return load_view('common/recommend/service_item', $view_data, false);
}

/**
 * Load the recommendation links
 *
 * @author Khuyenpv
 * @since 09.04.2015
 *
 */
function load_recommend_info_links($data, $is_mobile, $destination_id, $service_type){

    if($is_mobile) return $data;

	$CI =& get_instance();

	$CI->load->model('Recommend_Model');

	$view_data['destination'] = $destination_id;

	$recommendations = $CI->Recommend_Model->get_service_recommendations($destination_id, $service_type);

    $is_show_tour_recommened = false;
    $is_show_hotel_recommened = false;

    if(!empty($recommendations))
        foreach($recommendations as $key=>$value)
        {
            if($value['service_type'] == TOUR ||  $value['service_type'] == CRUISE)
                $is_show_tour_recommened = true;

            if($value['service_type'] == HOTEL)
                $is_show_hotel_recommened = true;

            //Description for recommended
            if(!empty($value['rec_description']))
                $recommendations[$key]['description'] = $value['rec_description'];
            else
                $recommendations[$key]['description'] = $value['ds_description'];

            unset($recommendations[$key]['rec_description']);
            unset($recommendations[$key]['ds_description']);

			// picture display for recommended
            if(!empty($value['rec_picture']))
                $recommendations[$key]['picture'] = get_image_path(PHOTO_FOLDER_DESTINATION_SERVICE, $value['rec_picture'], '80_60');
            else
                $recommendations[$key]['picture'] = get_image_path(PHOTO_FOLDER_DESTINATION, $value['des_picture'], '80_60');

        }

    $view_data['is_show_tour_recommened'] = $is_show_tour_recommened;
    $view_data['is_show_hotel_recommened'] = $is_show_hotel_recommened;

    $view_data['recommendations'] = generate_destination_service_info($recommendations);

	$data['recommendations'] = load_view('common/recommend/recommend_info_links', $view_data, $is_mobile);

    return $data;
}



/**
 * Get current booking info for Tour Service Recommendation
 *
 * @author Khuyenpv
 * @since 02.04.2015
 */
function get_current_tour_booking_info($tour, $discount_together){

	// load service recommendation
	$current_item_info['service_id'] = $tour['id'];

	$current_item_info['service_type'] = $tour['cruise_id'] > 0 ? CRUISE : TOUR;

	$current_item_info['url_title'] = $tour['url_title'];

	$current_item_info['normal_discount'] = $discount_together['normal_discount'];

	$current_item_info['is_main_service'] = $discount_together['is_main_service'];

	$current_item_info['destination_id'] = $tour['main_destination_id'];

	$current_item_info['is_booked_it'] = false;

	$current_item_info['parent_id'] = ''; // NO CURRENT SELECTED BOOKING ITEM

	$current_item_info['start_date'] = get_current_tour_departure_date($tour);

	return $current_item_info;
}

/**
 * Load the Extra-Saving Text, showing on each Check-Rate table
 *
 * @author Khuyenpv
 * @since 27.06.2015
 */
function load_extra_saving_recommendation($data, $is_mobile){

    if($is_mobile) return $data;

	$view_data['recommendations'] = !empty($data['recommendations']) ? $data['recommendations'] : array();

	$data['extra_saving_recommend'] = load_view('common/recommend/extra_saving_recommend', $view_data, $is_mobile);

	return $data;
}

?>