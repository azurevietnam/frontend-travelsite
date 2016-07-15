<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cruise Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 12 2015
 */

/**
 * Khuyenpv Feb 25 2015
 * Load the cruise categories 
 */
function load_cruise_categories($data, $is_mobile, $page)
{
    $CI = & get_instance();
    
    $mobile_folder = $is_mobile ? 'mobile/' : '';
    
    $data['page'] = $page;
    
    $config_item_name = strpos($page, 'halong') !== FALSE ? 'halongcruise_categories' : 'mekongcruise_categories';
    
    $destination_id = strpos($page, 'halong') !== FALSE ? HALONG_BAY : MEKONG_DELTA;
    
    $data['main_page'] = strpos($page, 'halong') !== FALSE ? HALONG_CRUISE_PAGE : MEKONG_CRUISE_PAGE;
    
    $data['cruise_types'] = $CI->config->item($config_item_name);
    
    if ($page == HALONG_CRUISE_PAGE || $page == MEKONG_CRUISE_PAGE)
    {
        $data['cruise_categories'] = $CI->load->view($mobile_folder . 'cruises/common/cruise_travel_styles', $data, TRUE);
    }
    else
    {
        $data['cruise_categories'] = $CI->load->view($mobile_folder . 'cruises/common/cruise_categories', $data, TRUE);
    }
    
    return $data;
}

/**
 * Khuyenpv Feb 25 2015
 * Load today hot cruise deal
 */
function load_today_hot_cruise_deal($data, $is_mobile, $tour){
	
	$CI =& get_instance();
	
	$mobile_folder = $is_mobile ? 'mobile/' : '';
	
	if(!empty($tour)){
		
		$tour['special_offers'] = load_promotion_popup($is_mobile, $tour['promotion'], TOUR, false);
		
		$deal_data['tour'] = $tour;
		
		$data['today_hot_deal'] = $CI->load->view($mobile_folder.'cruises/common/today_hot_deal', $deal_data, TRUE);
		
	} else {
		
		$data['today_hot_deal'] = '';
	}
	
	return $data;
}

/**
 * Khuyenpv Feb 25 2015
 * Load top cruise deals of Halong Bay or Mekong River
 */
function load_top_cruise_deals($data, $is_mobile, $tours, $page = null, $is_limited = true){
	
	$CI =& get_instance();
	
	$mobile_folder = $is_mobile ? 'mobile/' : '';
	
	if(!empty($tours)){
		
		foreach($tours as $key => $tour){
			
			$tour['special_offers'] = load_promotion_popup($is_mobile, $tour['promotion'], TOUR, true);
			
			$tours[$key] = $tour;
		}
		
		$deal_data['tours'] = $tours;
	
		//$data['top_deals'] = $CI->load->view($mobile_folder.'cruises/common/top_deals', $deal_data, TRUE);
		
		$data['top_deals_title'] = lang('label_top_cruise_deals');
		
		if($page == HALONG_CRUISE_PAGE) {
		    $data['top_deals_title'] = lang('label_top_deals') . ' - ' . lang('label_halong_bay_cruises');
		} elseif($page == MEKONG_CRUISE_PAGE) {
		    $data['top_deals_title'] = lang('label_top_deals') . ' - ' . lang('label_mekong_river_cruises');
		}
		
		$deal_data['is_limited'] = $is_limited;
		
		if($is_mobile) {
		    $data['top_deals'] = load_view('tours/common/list_tours', $deal_data, $is_mobile);
		} else {
		    $data['top_deals'] = load_view('tours/common/top_recommended_tours', $deal_data, $is_mobile);
		}
	} else {
	
		$data['top_deals'] = '';
	}
	
	return $data;
	
}

/**
 * Khuyenpv Feb 25 2015
 * Load the list cruises view
 */
function load_list_cruises($data, $is_mobile, $cruises, $is_enable_number = FALSE){

	if(!empty($cruises)){

		$view_data['cruises'] = $cruises;

		$view_data['is_enable_number'] = $is_enable_number;
		
		if(isset($data['is_show_more'])) {
		    $view_data['page']            = $data['page'];
		    $view_data['page_title']      = $data['page_title'];
		    $view_data['is_show_more']    = $data['is_show_more'];
		}
		
		$data['list_cruises'] = load_view('cruises/common/list_cruises', $view_data, $is_mobile);

	} else {
		$data['list_cruises'] = '';
	}

	return $data;
}

/**
 * Load all the cruise links base on cruise type
 *
 * @author toanlk
 * @since  Mar 18, 2015
 */
function load_all_cruise_links($data, $is_mobile, $page){
	
	if($is_mobile){

		$data['all_cruise_links'] = '';
		
	} else {
		
		$CI =& get_instance();
		
		$config_item_name = strpos($page, 'halong') !== FALSE ? 'halongcruise_categories' : 'mekongcruise_categories';
		
		$cruise_types = $CI->config->item($config_item_name);
		
		$type = strpos($page, 'halong') !== FALSE ? HALONG_CRUISE_PAGE : MEKONG_CRUISE_PAGE;
		
		$cruises = $CI->Cruise_Model->get_cruises_by_type($type);
		
		foreach ($cruise_types as $key => $value)
		{
			if(isset($value['show_on_bottom']) && !$value['show_on_bottom']) continue;
			
		    $value['cruises'] = get_cruises_by_type($cruises, $value['type']);
		    $cruise_types[$key] = $value;
		}
		
		$view_data['cruise_types'] = $cruise_types;
		
		$data['all_cruise_links'] = $CI->load->view('cruises/common/all_cruise_links', $view_data, TRUE);
	}
	
	return $data;
}

/**
 * get_cruises_by_type
 *
 * @author toanlk
 * @since  Apr 14, 2015
 */
function get_cruises_by_type($cruises, $type) {
    
    $cruise_types = array();
    
    foreach ($cruises as $cruise)
    {
        // Halong Cruises
        if ( ($type == LUXURY_HALONG_CRUISE_PAGE || $type == LUXURY_MEKONG_CRUISE_PAGE)
             && $cruise['num_cabin'] > 0 && $cruise['star'] >= 4.5 &&
             ($cruise['types'] & pow(2, 1)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ( ($type == DELUXE_HALONG_CRUISE_PAGE || $type == DELUXE_MEKONG_CRUISE_PAGE) 
             && $cruise['num_cabin'] > 0 && $cruise['star'] < 4.5 &&
             $cruise['star'] >= 3.5 && ($cruise['types'] & pow(2, 1)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ( ($type == CHEAP_HALONG_CRUISE_PAGE || $type == CHEAP_MEKONG_CRUISE_PAGE) 
              && $cruise['num_cabin'] > 0 && $cruise['star'] < 3.5 &&
             ($cruise['types'] & pow(2, 1)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == CHARTER_HALONG_CRUISE_PAGE && ($cruise['types'] & pow(2, 2)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == DAY_HALONG_CRUISE_PAGE && ($cruise['types'] & pow(2, 3)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == FAMILY_HALONG_CRUISE_PAGE && ($cruise['types'] & pow(2, 4)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == HONEY_MOON_HALONG_CRUISE_PAGE && ($cruise['types'] & pow(2, 5)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == HALONG_BAY_BIG_SIZE_CRUISE_PAGE && $cruise['cabin_index'] == 8)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE && $cruise['cabin_index'] == 4)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == HALONG_BAY_SMALL_SIZE_CRUISE_PAGE && ($cruise['cabin_index'] == 2 || $cruise['cabin_index'] == 1))
        {
            $cruise_types[] = $cruise;
        }
        
        // Mekong Cruises
        if ($type == VIETNAM_CAMBODIA_CRUISE_PAGE && ($cruise['types'] & pow(2, 6)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == VIETNAM_CRUISE_PAGE && ($cruise['types'] & pow(2, 7)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == LAOS_CRUISE_PAGE && ($cruise['types'] & pow(2, 8)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == THAILAND_CRUISE_PAGE && ($cruise['types'] & pow(2, 9)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == BURMA_CRUISE_PAGE && ($cruise['types'] & pow(2, 10)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == PRIVATE_MEKONG_CRUISE_PAGE && ($cruise['types'] & pow(2, 2)) > 0)
        {
            $cruise_types[] = $cruise;
        }
        elseif ($type == DAY_MEKONG_CRUISE_PAGE && empty($cruise['num_cabin']))
        {
            $cruise_types[] = $cruise;
        }
    }
    
    return $cruise_types;
}

?>