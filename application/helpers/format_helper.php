<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Format Data Helper Functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb 04 2015
 */

/**
 * Fetch a single line of text from the language array. Takes variable number
 * of arguments and supports wildcards in the form of '%1', '%2', etc.
 * Overloaded function.
 *
 * @access public
 * @return mixed false if not found or the language string
 */
function lang_arg()
{
	$CI =& get_instance();
	//get the arguments passed to the function
	$args = func_get_args();

	//count the number of arguments
	$c = count($args);

	//if one or more arguments, perform the necessary processing
	if ($c)
	{
		//first argument should be the actual language line key
		//so remove it from the array (pop from front)
		$line = array_shift($args);

		//check to make sure the key is valid and load the line
		$line = lang($line);

		//if the line exists and more function arguments remain
		//perform wildcard replacements
		if ($line && $args)
		{
			$i = 1;
			foreach ($args as $arg)
			{
				$line = preg_replace('/\%'.$i.'/', $arg, $line);
				$i++;
			}

		}

	}
	else
	{
		//if no arguments given, no language line available
		$line = false;
	}

	return $line;
}


/**
 * Khuyenpv March 06 2015
 * Check if the month is available or not
 * Using in Datepicker view
 */
function is_availabe_month($datepicker_options, $time){

	$available_dates = isset($datepicker_options['available_dates']) ? $datepicker_options['available_dates'] : array();

	if(empty($available_dates)) return true;
	foreach ($available_dates as $value){
		if(date('m-Y', $time) == date('m-Y', strtotime($value))) return true;
	}
	return false;
}

/**
 * Generate String to UL/LI list
 *
 * @author Khuyepv
 * @since 19.03.2015
 */
function generate_string_to_list($str, $ul_class = ''){

	$ret = '';

	if(!empty($str)){

		$arr_str = explode("\n", $str);

		$ret = '<ul class="list-unstyled '.$ul_class.'">';

		foreach ($arr_str as $value){

			if(!empty($value)){
				$ret .= '<li>'.$value.'</li>';
			}
		}

		$ret .= '</ul>';
	}

	return $ret;
}

/**
 * Check if a value contain a bit index
 *
 * @author Khuyenpv
 * @since March 17 2015
 */
function is_bit_value_contain($bit_value, $nr_index){

	$nr = pow(2,$nr_index) & $bit_value;

	return $nr > 0;
}

/**
 * Show Price in USD
 *
 * $author Khuyenpv
 * @since Mar 21 2015
 */
function show_usd_price($price, $has_space = false){

	if($has_space){
		return CURRENCY_SYMBOL.' '.number_format($price, CURRENCY_DECIMAL);
	} else {
		return CURRENCY_SYMBOL.number_format($price, CURRENCY_DECIMAL);
	}
}

/**
 * Generate group of Travellers based on Adults, Children, Infants
 *
 * @author Khuyenpv
 * @since 31.03.2015
 */
function generate_traveller_text($adults, $children, $infants){

	$text = '';
	$is_first = false;

	if ($adults > 0){

		$text = $adults == 1 ? lang('lbl_cabin_adult', $adults) : lang('lbl_cabin_adults', $adults);

		$is_first = true;
	}

	if ($children > 0){

		$text = $text. ($is_first? ', ' :''). ($children == 1 ? lang('lbl_cabin_child', $children) : lang('lbl_cabin_children', $children));

		$is_first = true;
	}

	if ($infants > 0){

		$text = $text. ($is_first? ', ' :''). ($infants == 1 ? lang('lbl_cabin_infant', $infants) : lang('lbl_cabin_infants', $infants));
	}

	return $text;
}

/**
 * Get the common sales@bestpricevn.com
 *
 * @author Khuyenpv
 * @since 06.04.2015
 */
function get_common_sale_emmail_addr(){

	// add more code for changig site from COM -> ES or FR

	return 'sales@'.strtolower(SITE_NAME);
}

/**
 * Generate Destination Service Name
 *
 * @author Khuyenpv
 * @since 09.04.2015
 */
function generate_destination_service_info($recommend){

    $recommends = array();

    if(!empty($recommend)) foreach($recommend as $value){
        $ret = array();

        $service_type = $value['service_type'];

        switch($service_type){
            case TOUR:
                $title = lang('lbl_tours', $value['name']);
                $link = get_page_url(TOURS_BY_DESTINATION_PAGE, $value);
                break;

            case HOTEL:
                $title = lang('hotel_last_url_title', $value['name']);
                $link = get_page_url(HOTELS_BY_DESTINATION_PAGE, $value);
                break;
            case CRUISE:
                if($value['id'] == 5){   // Halong Bay Cruise
                    $title = lang('field_cruise', $value['name']);
                    $link = get_page_url(HALONG_CRUISE_PAGE);
                }

                else{
                    $title = lang('field_cruise', $value['name']);
                    $link = get_page_url(MEKONG_RIVER_CRUISES);
                }
                break;

            default:
                $title = lang('lbl_tours', $value['name']);
                $link = get_page_url(TOURS_BY_DESTINATION_PAGE, $value);
                break;
        }

        $ret['title'] = $title;
        $ret['link'] = $link;
        $ret['service_type'] = $service_type;

        if (!empty($value['picture'])) {
            $ret['picture'] = $value['picture'];
        }
        else
            $ret['picture'] = '';
        $ret['description'] = $value['description'];

        $recommends[] = $ret;
    }

	return $recommends;
}

/**
 * Get icon star
 *
 * @author toanlk
 * @since  Apr 6, 2015
 */
function get_icon_star($star, $is_large = false)
{
    $icon = '';

    $size = $is_large ? 'large-' : '';

    switch ($star)
    {
        case 1:
            $icon = 'star-1';
            break;
        case 1.5:
            $icon = 'star-1_5';
            break;
        case 2:
            $icon = 'star-2';
            break;
        case 2.5:
            $icon = 'star-2_5';
            break;
        case 3:
            $icon = 'star-3';
            break;
        case 3.5:
            $icon = 'star-3_5';
            break;
        case 4:
            $icon = 'star-4';
            break;
        case 4.5:
            $icon = 'star-4_5';
            break;
        case 5:
            $icon = 'star-5';
            break;
    }

    return 'icon-'. $size . $icon;
}

/**
 * get_deal_expired_text
 *
 * @author toanlk
 * @since  Apr 13, 2015
 */
function get_deal_expired_text($expiry_date) {
    $text='';
    $numb_days = get_days_left($expiry_date);
    if($numb_days == 0) {
        $diff = timeDiff(mktime(24,0,0), time());
        $count = 0;
        foreach($diff as $unit => $value)
        {
            $text .= $value;
            if($count+1 < count($diff)) {
                $text .= " : ";
            }
            $count++;
        }

        $text = lang('time_left_to_buy')
        . '<label id="timeLeft" style="font-size:12pt">'.$text.'</label>';
        $text .= '<script>get_time_left();</script>';

    } elseif($numb_days <= 10) {
        $text = lang('days_left');
        $text = str_replace('%s', $numb_days, $text);
    } else {
        $text = lang('expired_on');
        $text = str_replace('%s', date('d M, Y', strtotime($expiry_date)), $text);
    }

    return $text;
}

/**
 * Insert Ajax Calling Service Overview
 *
 * @author Khuyenpv
 * @since 16.04.2015
 */
function insert_see_overview_link($str){

    // check empty
    if(empty($str)) return $str;

	$CI =& get_instance();

	$CI->load->library('simple_html_dom');

	$html = str_get_html($str);

	// replace destination overview
	$des_tags = $html->find('des');

	foreach ($des_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$des_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$des_name = $tag_value;
		}

		$des_obj['url_title'] = url_title($des_name);

		$tag->href = 'javascript:void(0)';

		$tag->onclick = "see_overview('".url_title($des_name)."', 'destination', '".$inner_text."')";

		$tag->value = null;

	}


	// replace cruise overview
	$cruise_tags = $html->find('cruise');

	foreach ($cruise_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$cruise_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$cruise_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = "see_overview('".url_title($cruise_name)."', 'cruise', '".$inner_text."')";

		$tag->value = null;

	}


	// replace hotel overview
	$hotel_tags = $html->find('hotel');

	foreach ($hotel_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$hotel_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$hotel_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = "see_overview('".url_title($hotel_name)."', 'hotel', '".$inner_text."')";

		$tag->value = null;

	}


	// replace hotel overview
	$tour_tags = $html->find('tour');

	foreach ($tour_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$tour_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$tour_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = "see_overview('".url_title($tour_name)."', 'tour', '".$inner_text."')";

		$tag->value = null;

	}

	// replace hotel overview
	$activity_tags = $html->find('act');

	foreach ($activity_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$act_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$act_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = "see_overview('".url_title($act_name)."', 'activity', '".$inner_text."')";

		$tag->value = null;

	}

	$str = strval($html);

	$str = str_replace('<des', '<a', $str);
	$str = str_replace('</des>', '</a>', $str);

	$str = str_replace('<cruise', '<a', $str);
	$str = str_replace('</cruise>', '</a>', $str);

	$str = str_replace('<hotel', '<a', $str);
	$str = str_replace('</hotel>', '</a>', $str);

	$str = str_replace('<tour', '<a', $str);
	$str = str_replace('</tour>', '</a>', $str);

	$str = str_replace('<act', '<a', $str);
	$str = str_replace('</act>', '</a>', $str);

	return $str;
}

?>