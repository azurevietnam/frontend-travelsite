<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Helper Functions for loading hotlines
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 07 2015
 */

function load_tailor_make_tour($data, $is_mobile, $url_tour = ''){
    
    $CI =& get_instance();

    $mobile_folder = $is_mobile ? 'mobile/' : '';

    $CI->load->model('Hotline_Model');

    $now = date(DB_DATE_FORMAT);

    $schedules = $CI->Hotline_Model->get_schedules($now);

    if(!empty($schedules))
        $schedule = $schedules[array_rand($schedules)];

    else{
        $result = $CI->Hotline_Model->get_user(2); // Fix hotline id

        if(!empty($result))
            $schedule = $result[0];
        else $schedule = '';
    }

    $view_data['schedule'] = $schedule;

    $view_data['url_tour'] = $url_tour;

    if(empty($view_data['schedule']))
        $data['tailor_make_tour'] = '';

    else
        $data['tailor_make_tour'] = $CI->load->view($mobile_folder.'common/hotline/tailor_make_tour_ajax', $view_data, TRUE);

    return $data;

}

/**
 * Khuyenpv Feb 10 2015
 * Load today hotline user information
 */
function load_today_hotline($data, $is_mobile, $service = TOUR){

	$CI =& get_instance();

	$mobile_folder = $is_mobile ? 'mobile/' : '';

    $CI->load->model('Hotline_Model');

    $now = date(DB_DATE_FORMAT);

    $schedules = $CI->Hotline_Model->get_schedules($now, $service);

    if(!empty($schedules))
        $view_data['schedule'] = $schedules[array_rand($schedules)];

    if(empty($view_data['schedule']))
        $data['today_hotline'] = '';

    else
        $data['today_hotline'] = $CI->load->view($mobile_folder.'common/hotline/today_hotline_ajax', $view_data, TRUE);

	return $data;

}
?>
