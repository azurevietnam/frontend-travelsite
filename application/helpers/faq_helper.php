<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * FAQ helper functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb, 2, 2015
 */

/**
 * Khuyenpv Feb 09 2015
 * Load FAQ for each page
 *
 */
function load_faq_by_page($data, $is_mobile, $destination_id = '', $page_id = ''){
    
    if($is_mobile) return $data;
    
	$CI =& get_instance();

	$CI->load->model('Faq_Model');

    $view_data['faq'] = $CI->Faq_Model->get_faq_for_page($destination_id, $page_id);

    if(empty($view_data))
        $data['faq_by_page'] = '';

    else
	    $data['faq_by_page'] = load_view('faqs/common/faq_by_page', $view_data, $is_mobile);

	return $data;
}

/**
 * Khuyenpv March 03 2015
 * Load all FAQ categories
 */
function load_faq_categories($data, $is_mobile, $current_category_id = ''){

	$CI =& get_instance();

    $data['current_category_id'] = $current_category_id;

    $categories = $CI->Faq_Model->get_categories();

    if(empty($categories))

        $data['faq_categories'] = '';

    else{

        $data['categories'] = $categories;

        $data['faq_categories'] = load_view('faqs/common/faq_categories', $data, $is_mobile);
    }

	return $data;
}

/**
 * Khuyenpv March 03 2015
 * Load all FAQ categories
 */
function load_faq_destinations($data, $is_mobile, $current_destination_id = ''){

	$CI =& get_instance();

    $destinations = $CI->Faq_Model->get_destinations();

    // order destinations

    $list_des = array();

    foreach($destinations as $value){
        if(empty($value['parent_id']))
            foreach($destinations as $v)
                if($value['id'] == $v['parent_id'])
                    $list_des[$value['name']][] = $v;
    }

    $data['current_destination_id'] = $current_destination_id;

    if(empty($list_des))
        $data['faq_destinations'] = '';

    else{
        $data['destinations'] = $list_des;

        $data['faq_destinations'] = load_view('faqs/common/faq_destinations', $data, $is_mobile);
    }

	return $data;
}

/**
 * Khuyenpv March 03 2015
 * Load the FAQ list
 */
function load_faq_list($data, $is_mobile, $page, $list_categories, $list_questions){

	$CI =& get_instance();

    if(empty($list_categories) && empty($list_questions))
        $data['faq_list'] = '';

    else
    {
        $view_data['list_categories'] = $list_categories;
        $view_data['list_questions'] = $list_questions;

        $view_data['page'] = $page;

        $data['faq_list'] = load_view('faqs/common/faq_list', $view_data, $is_mobile);
    }

	return $data;
}


?>