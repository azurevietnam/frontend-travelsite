<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Helper Functions for loading advertises
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 07 2015
 */

/**
 * Khuyenpv Feb 07 2015
 * Get Advertises by page & area
 */
function get_advertises($is_mobile, $ad_page, $ad_area = AD_AREA_DEFAULT, $destination_id = '', $travel_style_id = ''){

    $CI =& get_instance();

    $CI->load->helper('Destination');

    $CI->load->model('Advertise_Model');

    $advertises = $CI->Advertise_Model->get_advertises($ad_page, $ad_area, $destination_id, $is_mobile, $travel_style_id);

    return $advertises;
}

/**
 * Khuyenpv Feb 07 2015
 * Load Advertise for common pages (tour, hotel)
 */
function load_common_advertises($data, $is_mobile, $ad_page, $ad_area = AD_AREA_DEFAULT, $destination_id = '', $display_mode = AD_DISPLAY_MULTIPLE, $travel_style_id = ''){

    $view_data['advertises'] = get_advertises($is_mobile, $ad_page, $ad_area, $destination_id, $travel_style_id);
    
    //only 1 advertise & 1 photos => show as single mode
    if(count($view_data['advertises']) == 1 && count($view_data['advertises'][0]['photos']) == 1){
    	$display_mode = AD_DISPLAY_SINGLE;
    }

    if($display_mode == AD_DISPLAY_MULTIPLE){
        $photo_count = 0;
        foreach ($view_data['advertises'] as $ad) {
            $photo_count = count($ad['photos']) + $photo_count;
        }

        $view_data['photo_count'] = $photo_count;

    }

    if(!empty($view_data['photo_count']) && $view_data['photo_count'] <= 1)
        $display_mode = AD_DISPLAY_SINGLE;

	$view_data['display_mode'] = $display_mode;

	$view_data['ad_page'] = $ad_page;

    if(!empty($view_data['advertises']))

    	$data['common_ad'] = load_view('common/advertise/common_ad', $view_data, $is_mobile);

    else
        $data['common_ad'] = '';

	return $data;
}

/**
 * Khuyenpv Feb 07 2015
 * Load Advertise for Home Page
 */
function load_home_advertises($data, $is_mobile = false, $ad_page, $ad_area = AD_AREA_DEFAULT){

	$CI =& get_instance();

	$view_data['advertises'] = get_advertises($is_mobile, $ad_page, $ad_area);

	$data['home_ad'] = load_view('common/advertise/home_ad', $view_data, $is_mobile);

	return $data;
}

?>