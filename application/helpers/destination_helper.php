<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Destination helper functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 06, 2015
 */

/**
 * Khuyenpv Feb 09 2015
 * Load FAQ for each page
 *
 */
function load_destination_info_links($data, $is_mobile, $destination)
{
    if($is_mobile) return $data;

    $CI =& get_instance();

    $view_data['destination'] = $destination;

    $view_data['count_attractions'] = $CI->Destination_Model->get_attractions($destination['id'],6 , 0, true);

    $view_data['count_things_todo'] = $CI->Destination_Model->get_things_to_do($destination['id'], 6, 0, true);

    $view_data['count_articles'] = $CI->Destination_Model->get_travel_articles($destination['id'], 10, 0, true);

    $data['destination_info_links'] = load_view('destinations/common/destination_info_links', $view_data, $is_mobile);

    return $data;
}

/**
 * Load the list link of destination Articles
 *
 *
 */
function load_destination_article_links($data, $is_mobile, $destination){

    if($is_mobile) return $data;

    $CI =& get_instance();

    $articles = $CI->Destination_Model->get_travel_articles($destination['id'], 5);

    $view_data['destination'] = $destination;

    $view_data['articles'] = $articles;

    $data['destination_article_links'] = load_view('destinations/common/destination_article_links', $view_data, $is_mobile);

    return $data;
}

/**
 * Khuyenpv March 04 2015
 * Load Destination Categories
 */
function load_destination_categories($data, $is_mobile, $destination, $page, $useful_information = ''){
	$CI =& get_instance();

    $view_data['destination'] = $destination;

    $view_data['page'] = $page;

    $view_data['usefull_information'] = $useful_information;

    $view_data['usefull_select'] = !empty($data['useful_information']) ? $data['useful_information'] : '';

    $view_data['count_attractions'] = $CI->Destination_Model->get_attractions($destination['id'],6 , 0, true);

    $view_data['count_things_todo'] = $CI->Destination_Model->get_things_to_do($destination['id'], 6, 0, true);

    $view_data['count_articles'] = $CI->Destination_Model->get_travel_articles($destination['id'], 10, 0, true);

    $data['destination_categories'] = load_view('destinations/common/destination_categories', $view_data, $is_mobile);

	return $data;
}

/**
 * Khuyenpv March 04 2015
 * Load destination travel tips here
 */
function load_destination_travel_tips($data, $is_mobile, $destination){

	$CI =& get_instance();
	/*	
	    $data['destination']['travel_tips'] = str_replace('<br />','</p>', $data['destination']['travel_tips']);
	    $data['destination']['travel_tips'] = explode('</p>', $data['destination']['travel_tips']);
	
	    $count  = count($data['destination']['travel_tips']);
	    if($count > 1)
	        unset($data['destination']['travel_tips'][$count - 1]);
	*/
	$data['travel_tips'] = load_view('destinations/common/travel_tips', $data, $is_mobile);

	return $data;
}

/**
 * TinVM March 19 2015
 * Load Usefull Information detail here
 */
function load_destination_useful_information($data, $is_mobile){
    $CI =& get_instance();

    $data['useful_information_detail'] = load_view('destinations/useful_information/useful_information_detail', $data, $is_mobile);

    return $data;
}

/**
 * Load destination travel guide
 * @author TinVM
 * @since Jun3 2015
 */
function load_destination_travel_guide($data, $is_mobile, $destination) {

    if($is_mobile) return $data;

    $CI =& get_instance();

    $view_data['destination'] = $destination;

    $view_data['articles'] = $CI->Destination_Model->get_travel_articles($destination['id'], 3);

    $data['destination_travel_guide'] = load_view('destinations/common/destination_travel_guide', $view_data, $is_mobile);

    return $data;
}


?>