<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_first_date_of_month($date){
	
	$months = array("Jan"=>'01', "Feb"=>'02', "Mar"=>'03', "Apr"=>'04', "May"=>'05', "Jun"=>'06', "Jul"=>'07', "Aug"=>'08', "Sep"=>'09', "Oct"=>'10', "Nov"=>'11', "Dec"=>'12');
	
	$str_array = explode(",", $date);
	
	$year = trim($str_array[1]);
	
	$month = $months[trim($str_array[0])];
	
	$first = date('Y-m-d', mktime(0, 0, 0, $month, 1, $year));
	
	return $first;
	
}

function get_last_date_of_month($date){
	
	$months = array("Jan"=>'01', "Feb"=>'02', "Mar"=>'03', "Apr"=>'04', "May"=>'05', "Jun"=>'06', "Jul"=>'07', "Aug"=>'08', "Sep"=>'09', "Oct"=>'10', "Nov"=>'11', "Dec"=>'12');
	
	$str_array = explode(",", $date);
	
	$year = trim($str_array[1]);
	
	$month = $months[trim($str_array[0])];
	
	$last = date('Y-m-t', mktime(0, 0, 0, $month, 1, $year));	
	
	return $last;
	
}

function get_price_now($price){
	if(!isset($price['offer_rate'])) $price['offer_rate'] = 0;
	if(!isset($price['from_price'])) $price['from_price'] = 0;
	$price_now = $price['from_price'] - round($price['from_price'] * $price['offer_rate'] / 100,0);

	return $price_now;
}

function get_best_price_now($price){
	if(!isset($price['offer_rate'])) $price['offer_rate'] = 0;
	if(!isset($price['best_price'])) $price['best_price'] = 0;
	$best_price_now = $price['best_price'] - round($price['best_price'] * $price['offer_rate'] / 100,0);

	return $best_price_now;
	
}


function get_best_accommodation_price($prices, $promotion){
	
	$ret = 0;
	
	if ($prices && isset($prices[-2])){
		
		$ret = $prices[-2];
		
		if ($promotion){
			
			$ret = $ret - round($ret * $promotion['offer_rate'] / 100,0);
			
		}	
	}

	return $ret;
	
}

function get_original_accommodation_price($prices, $group_size){
	
	$ret = 0;
	
	if (isset($prices[$group_size])){
		
		$ret = $prices[$group_size];

	}

	return $ret;
}

function get_promotion_accommodation_price($prices, $promotion, $group_size){
	
	$ret = 0;
	
	if ($prices && isset($prices[$group_size])){
		
		$ret = $prices[$group_size];
		
		if ($promotion){
			
			$ret = $ret - round($ret * $promotion['offer_rate'] / 100,0);
			
		}	
	}

	return $ret;
}

function is_group($cruise){
	$ret = false;
	if (isset($cruise['group_id'])){
		$ret = ($cruise['group_id'] > 0);
	}
	
	return $ret;
}



function get_cabin_arrangement_text($cabin, $cabin_types){
		
	$adult_text = 'Adult';
	$children_text = 'Child';
	$infant_text = 'Infant';
	
	if ($cabin['adults'] > 1){
		$adult_text = 'Adults';
	}
	
	if ($cabin['children'] > 1){
		$children_text = 'Children';
	}
	
	if ($cabin['infants'] > 1){
		$infant_text = "Infants";
	}
	
	$is_first = false;
	
	$text = '';
	
	if ($cabin['adults'] > 0){
		$text = $cabin['adults'].' '. $adult_text;
		$is_first = true;
	}	
	
	if ($cabin['children'] > 0){
		
		$text = $text. ($is_first? ', ' :''). $cabin['children'].' '.$children_text;
		
		$is_first = true;
	}
	
	if ($cabin['infants'] > 0){
		
		$text = $text. ($is_first? ', ' :''). $cabin['infants']. ' '. $infant_text;
	}
	
	return (translate_text($cabin_types[$cabin['type']]).' - ' .$text);
	
}

function re_arrange_cabins($CI, $cabin_types, $index = ''){
	
	$ret = array();
	
	$object_change = $CI->input->post('object_change'.$index);
	
	$num_cabin = $CI->input->post('num_cabin'.$index);
	
	if ($object_change == 'change_cabin'){
		
		for ($i = 1; $i <= $num_cabin; $i++) {
			
			$cabin_type = $CI->input->post('type_'.$i.$index);
			
			$cabin_adults = $CI->input->post('adults_'.$i.$index);
			
			$cabin_children = $CI->input->post('children_'.$i.$index);
			
			$cabin_infants = $CI->input->post('infants_'.$i.$index);
			
			$cabin['type'] = $cabin_type;
			
			$cabin['adults'] = $cabin_adults;
			
			$cabin['children'] = $cabin_children;
			
			$cabin['infants'] = $cabin_infants;
			
			$cabin['arrangement'] = get_cabin_arrangement_text($cabin, $cabin_types);
			
			$ret[$i] = $cabin;
			
		}
		
	}
	
	
	return $ret;
	
}


function calculate_pax($adults, $children, $infants, $tour_childen_price, $index = ''){
	
	$cabins = array();
	
	$double = int_divide($adults, 2);
	
	
	// 2 adults per cabin	
	for($i = 1; $i <= $double; $i++) {
		
		$c['adults'] = 2;
		
		$c['children'] = 0;
		
		$c['infants'] = 0;
		
		$cabins[$i] = $c;
	
	}
	
	
	// 1 adults in a single cabin
	if ($adults % 2 > 0){
		
		$c['adults'] = 1;
		
		$c['children'] = 0;
		
		if ($children > 0){
			
			$c['children'] = 1;
			
			$children = $children - 1;
		}
		
		$c['infants'] = 0;
		
		$cabins[$double + 1] = $c;
	
	}
	
	// 1 infants & parent in a cabin
	$num_cabin = count($cabins);
	
	for ($i = 1; $i <= $num_cabin; $i++){
			
		if ($infants > 0){
			
			if ($cabins[$i]['adults'] == 2){
			
				$cabins[$i]['infants'] = 1;
				
				$infants = $infants - 1;
			
			} elseif ($cabins[$i]['adults'] == 1){
				
				if ($infants >= 2){
					
					$cabins[$i]['infants'] = 2;
									
					$infants = $infants - 2;
					
				} else{
					
					$cabins[$i]['infants'] = 1;
									
					$infants = $infants - 1;
				
				}
			}
			
		}
		
	}
	
	for ($i = 1; $i <= $num_cabin; $i++){
				
		if ($children > 0 && ($cabins[$i]['adults'] + $cabins[$i]['children'] + $cabins[$i]['infants']) < 3){
			
			$cabins[$i]['children'] = $cabins[$i]['children'] + 1;
			
			$children = $children - 1;
			
		}
		
	}
	
	$i = 1;
	
	while ($children + $infants >= 3){
		
		$c['adults'] = 0;
		
		$c['infants'] = 0;
		
		$c['children'] = 0;
		
		if ($children >= 3){	
			
			if ($infants > 0){
				
				$c['children'] = 2;
				
				$c['infants'] = 1;
				
				$children = $children - 2;
			
				$infants = $infants - 1;
				
			} else {
			
				$c['children'] = 3;
				
				$children = $children - 3;
			
			}
			
		} elseif($children == 2){
			
			$c['children'] = 2;
			
			$c['infants'] = 1;
			
			$children = $children - 2;
			
			$infants = $infants - 1;
			
		} elseif ($children == 1){
			
			$c['children'] = 1;
			
			$c['infants'] = 2;
			
			$children = $children - 1;
			
			$infants = $infants - 2;
			
		} else{
			
			$c['infants'] = 3;
			
			$infants = $infants - 3;
			
		}
	
		
		$cabins[$num_cabin + $i] = $c;
		
		$i++;
		
	}
	
	if ($children + $infants > 0){
		
		$c['adults'] = 0;
		
		$c['infants'] = $infants;
		
		$c['children'] = $children;
		
		if ($cabins[$num_cabin]['children'] > 0){
			
			$cabins[$num_cabin]['children'] = $cabins[$num_cabin]['children'] - 1;
			
			
			$c['children'] = $c['children'] + 1;
		}
		
		$cabins[$num_cabin + $i] = $c;
		
	}

	
	$CI =& get_instance();
	
	$cabin_types = $CI->config->item('cabin_types');
	
	foreach ($cabins as $key => $cabin) {
		
		$cabin_member = $cabin['adults'] + $cabin['children'] + $cabin['infants'];
		
		if ($cabin_member == 1){
			
			$cabin['type'] = 3; // single
			
		} elseif ($cabin['adults'] == 2){
			
			$cabin['type'] = 1; // double
			
		} else {
			
			$cabin['type'] = 2; // twin
			
		}
		
		
		$cabin['arrangement'] = get_cabin_arrangement_text($cabin, $cabin_types);
		
		$cabins[$key] = $cabin;
		
	}
	
	
	$re_arrange_cabins = re_arrange_cabins($CI, $cabin_types, $index);
	
	if (count($re_arrange_cabins) > 0){
		
		$cabins = $re_arrange_cabins;
	}
	
	$ret = array();
	
	$ret['num_cabin'] = count($cabins);
	
	//$ret['num_pax'] = $adults;
	
	$ret['num_pax'] = get_cruise_tour_pax_calculated($cabins, $tour_childen_price);
	
	$ret['cabins'] = $cabins;
	
	return $ret;
	
}

function get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion){
	
	$basic_price = array();
	
	$adult_price = 0;
	
	$children_price = 0;
	
	$single_sup = 0;
	
	if ($num_pax_calculated > 10) $num_pax_calculated = 10;
	
	$children_percentage =  get_original_accommodation_price($prices, -1);
	
	if ($is_promotion){
		
		$adult_price = $is_group ? get_promotion_accommodation_price($prices, $promotion, -2) : get_promotion_accommodation_price($prices, $promotion, $num_pax_calculated);

		$children_price = $children_percentage * $adult_price / 100;
		
		$single_sup = get_promotion_accommodation_price($prices, $promotion, 0);
	
	} else {
		
		$adult_price = $is_group ? get_original_accommodation_price($prices, -2) : get_original_accommodation_price($prices,  $num_pax_calculated);

		$children_price = $children_percentage * $adult_price / 100;
		
		$single_sup = get_original_accommodation_price($prices, 0);
	}
	
	$basic_price['adult_price'] = $adult_price;
	
	$basic_price['children_price'] = $children_price;
	
	$basic_price['single_sup'] = $single_sup;
	
	return $basic_price;
	
}

function get_cruise_tour_pax_calculated($cabins, $tour_childen_price){
	
	$ret = 0;
	
	foreach ($cabins as $cabin){
		
		$cabin_price_type = get_cabin_price_type($cabin, $tour_childen_price);
		
		if ($cabin_price_type == PRICE_DOUBLE || $cabin_price_type == PRICE_DOUBLE_EXTRA){			
			
			$ret = $ret + 2;
			
		} elseif ($cabin_price_type == PRICE_SINGLE){
			
			$ret = $ret + 1;
			
		} elseif ($cabin_price_type == PRICE_BY_PERSON){
			
			$ret = $ret + $cabin['adults'];
			
		}
		
	}
	
	return $ret;
	
}

function get_cabin_price_type($cabin, $tour_childen_price){
	
	$cabin_price_type = PRICE_BY_PERSON;
	
	if ($cabin['adults'] == 2){
		// 2 adults: double
		$cabin_price_type = PRICE_DOUBLE;
		
		// 2 adults + 1 children: double + extrabed
		if ($cabin['children'] == 1){
			
			$cabin_price_type = PRICE_DOUBLE_EXTRA;
		}
		
	} elseif ($cabin['adults'] == 1){
		// 1 adults + 2 children
		if ($cabin['children'] == 2){
			
			$cabin_price_type = $tour_childen_price ? $tour_childen_price['a1_c2'] : PRICE_DOUBLE_EXTRA;

			// 1 adult + 1 children
		} elseif ($cabin['children'] == 1){
			
			$cabin_price_type = $tour_childen_price ? $tour_childen_price['a1_c1'] : PRICE_DOUBLE;
			
		} else {
			
			// 1 adult: single
			$cabin_price_type = PRICE_SINGLE;
			
		}
		
		
	} else {
		// 3 children
		if ($cabin['children'] + $cabin['infants'] == 3){
			
			$cabin_price_type = $tour_childen_price ? $tour_childen_price['c3'] : PRICE_DOUBLE;
			
		// 2 children
		} elseif ($cabin['children'] + $cabin['infants'] == 2){
			
			$cabin_price_type = $tour_childen_price ? $tour_childen_price['c2'] : PRICE_SINGLE;
			
		} elseif ($cabin['children'] + $cabin['infants'] == 1){
			
			$cabin_price_type = $tour_childen_price ? $tour_childen_price['c1'] : PRICE_SINGLE;
			
		}
		
	}
	
	return $cabin_price_type;
	
}

function get_cabin_price($prices, $promotion, $num_pax_calculated, $is_group, $cabin, $is_promotion, $tour_childen_price){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion);
	
	/*
	 * Price by cabin type
	 */	
	$cabin_price_type = get_cabin_price_type($cabin, $tour_childen_price);
	
	if($cabin_price_type == PRICE_DOUBLE_EXTRA){
		
		$cabin_price = $basic_price['adult_price'] * 2 + $basic_price['children_price'];
		
	} elseif ($cabin_price_type == PRICE_DOUBLE){
		
		$cabin_price = $basic_price['adult_price'] * 2;
		
	} elseif ($cabin_price_type == PRICE_SINGLE){
		
		$cabin_price = $basic_price['adult_price'] + $basic_price['single_sup'];
		
	} elseif ($cabin_price_type == PRICE_BY_PERSON){
		
		$cabin_price = $basic_price['adult_price'] * $cabin['adults'] + $basic_price['children_price'] * $cabin['children'];
		
	} else {
		
		$cabin_price = 0;
		
	}
	
	
	return $cabin_price;
}

function get_total_price($prices, $promotion, $num_pax_calculated, $is_group, $cabins, $is_promotion, $tour_children_price){
	
	$total = 0;
	
	foreach ($cabins as $cabin){
		
		$total = $total + get_cabin_price($prices, $promotion, $num_pax_calculated, $is_group, $cabin, $is_promotion, $tour_children_price);
	}
	
	return $total;
	
}

function get_total_price_accommodation_type($prices, $promotion, $is_group, $pax_accom_info, $type) {
	
	$num_pax_caculated = $pax_accom_info['num_pax'];
	
	$basic_price = $is_group ? get_best_accommodation_price($prices, $promotion) : get_promotion_accommodation_price($prices, $promotion, $num_pax_caculated);
	
	$children_price = get_children_price($prices, $promotion, $num_pax_caculated, $is_group);// get_original_accommodation_price($prices, -1);
	
	$single_sup = get_promotion_accommodation_price($prices, $promotion, 0);
	
	$prices = array();
	if($type == 1) {
		$prices['price'] = $basic_price + $single_sup;
		$prices['total_price'] = $pax_accom_info['single'] * ($basic_price + $single_sup);
	} else if($type == 2) {
		$prices['price'] = $basic_price * 2;
		$prices['total_price'] = $pax_accom_info['double'] * ($basic_price * 2);
	} else {
		$prices['price'] = $basic_price * 2 + $children_price;
		$prices['total_price'] = $pax_accom_info['double_with_children'] * ($basic_price * 2 + $children_price);
	}	
	
	return $prices;
}

function get_check_rate_info($search_criteria){

	$check_rate = array();
	
	$CI =& get_instance();
		
	$departure_date_check_rates = $CI->input->post('departure_date_check_rates');
	
	if(!empty($departure_date_check_rates)) {
		
		$departure_date_check_rates = $search_criteria['departure_date'];
		
	}
	
	$adults = $CI->input->post('adults');
	
	if(!isset($adults) || $adults == ''){
		$adults = 2;
	}
	
	$children = $CI->input->post('children');
	
	if (!isset($children) || $children == ''){
		$children = 0;
	}
	
	$infants = $CI->input->post('infants');
	
	if (!isset($infants) || $infants == ''){
		$infants = 0;
	}
	
	$object_change = $CI->input->post('object_change');
	
	if (!isset($object_change) || $object_change == ''){
		
		$object_change = 'change_person';
	}
	
	
	return array('adults'=>$adults, 'children'=>$children, 'infants' => $infants, 'departure_date'=>$departure_date_check_rates, 'object_change'=>$object_change);
}

function get_booking_info($tour){
	
	$CI =& get_instance();
		
	$departure_date = $CI->input->post('departure_date');
	
	$end_date = $CI->timedate->date_add($departure_date, 0, 0, $tour['duration'] - 1);
	
	$adults = $CI->input->post('adults');
	
	$children = $CI->input->post('children');
	
	$infants = $CI->input->post('infants');
	
	$adults_lang = $adults > 1 ? $adults . ' adults' : $adults.' adult';
	
	$children_lang = $children > 1 ? $children. ' children' : $children.' child';
	
	$object_change = $CI->input->post('object_change');
	
	if (!isset($object_change) || $object_change == ''){
		
		$object_change = 'change_person';
	}
	
	
	$infants_lang = $infants > 1 ? $infants.' infants' : $infants. ' infant';
	
	if ($children == 0) $children_lang = '';
	
	if ($infants == 0) $infants_lang = '';
	
	if ($children_lang != ''){
	
		$guest = $adults_lang. ', '.$children_lang;
	
	} else {
		$guest = $adults_lang;
	}
	
	if ($infants_lang != ''){
	
		$guest = $guest. ', '.$infants_lang;
	
	} else {
		//$guest = $adults_lang;
	}
	 
	// booked accommodations
	
	$accommodation_booked = $CI->input->post('accommodation');
	
	$optional_services_booked = $CI->input->post('optional_services');
	
	$extra_service_pax = $CI->input->post('extra_service_pax');
	
	if ($optional_services_booked == '' || count($optional_services_booked) == 0) $optional_services_booked = array();
	
	return array('guest'=> $guest, 'departure_date'=>$departure_date, 'end_date' => $end_date, 'adults'=>$adults, 'children'=>$children, 'infants' => $infants, 'object_change' => $object_change, 'accommodation'=>$accommodation_booked, 'optional_services'=>$optional_services_booked, 'extra_service_pax'=>$extra_service_pax);
		
}

function is_single_sup($adults, $children, $accommodations){
	
	if ($adults % 2 == 0){
		
		return false;
		
	} else {
		
		if ($children % 2 != 0){
			
			return false;
		}
		
		foreach ($accommodations as $accommodation){
			
			$single_sup = get_original_accommodation_price($accommodation['prices'], 0);
			
			if ($single_sup > 0){
				
				return true;
			}
			
		}
		
		return false;
			
	}
	
}

function get_adult_price($prices, $promotion, $num_pax_calculated, $is_group, $adults, $is_promotion){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion);
	
	$adult_price = $basic_price['adult_price'] * $adults;
	
	return $adult_price;
	
}

function get_children_price($prices, $promotion, $num_pax_calculated, $is_group, $children, $is_promotion){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion);
	
	$children_price = $basic_price['children_price'] * $children;
	
	return $children_price;
	
}

function get_singe_sup_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion);
	
	return $basic_price['single_sup'];
}

function get_total_tour_price($prices, $promotion, $num_pax_calculated, $is_group, $adults, $children, $is_promotion){
	
	$adult_price = get_adult_price($prices, $promotion, $num_pax_calculated, $is_group, $adults, $is_promotion);
	
	$children_price = get_children_price($prices, $promotion, $num_pax_calculated, $is_group, $children, $is_promotion);
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, $is_group, $is_promotion);
	
	$total_price = $adult_price + $children_price;

	if ($adults % 2 != 0 && $children % 2 == 0){
		
		$total_price = $total_price + $basic_price['single_sup'];
		
	}
	
	return $total_price;
}


// for normal tour or private cruise tour
function get_pax_calculated($adults, $children, $tour, $prices = ''){
	
	if ($tour['cruise_id'] > 0 && (is_private_tour($tour) || $tour['num_cabin'] == 0)){ // private charter cruise tour or day cruise tour
		
		$pax_calculated = $adults + $children;
		
		if ($prices != ''){
			
			$children_percentage =  get_original_accommodation_price($prices, -1);
			
			$pax_calculated = $adults + floor($children_percentage * $children / 100);
			
		}
		
		return $pax_calculated;
		
		
	} elseif ($tour['cruise_id'] > 0){ // cruise tour
		
		return 0;
		
	} else { // normal tour
	
		$pax_calculated = $adults;
		
		if ($prices != ''){
			
			$children_percentage =  get_original_accommodation_price($prices, -1);
			
			$pax_calculated = $adults + floor($children_percentage * $children / 100);
			
		}
		
		return $pax_calculated;
	}
	
}


function get_total_ac_price_normal_tour($prices, $promotion, $num_pax_calculated, $is_group, $adults, $children){
	
	$basic_price = $is_group ? get_best_accommodation_price($prices, $promotion) : get_promotion_accommodation_price($prices, $promotion, $num_pax_calculated);
	
	$children_price = get_children_price($prices, $promotion, $num_pax_calculated, $is_group);
	
	$single_sup = $adults % 2 != 0 ? get_promotion_accommodation_price($prices, $promotion, 0) : 0;
	
	$total_price = $basic_price * $adults + $children_price * $children + $single_sup;
	
	return $total_price;
	
}

function int_divide($x, $y) {
    if ($x == 0) return 0;
    if ($y == 0) return FALSE;
    $result = $x/$y;
    $pos = strpos($result, '.');
    if (!$pos) {
        return $result;
    } else {
        return (int) substr($result, 0, $pos);
    }
}

function transfer_price($adult, $children, $price, $children_rate) {
	$adult_price = $adult * $price;
	
	$children_price = $children * round(($children_rate * $price) / 100, CURRENCY_DECIMAL);
	
	$transfer_price = $adult_price + $children_price;
	
	return $transfer_price;
}

function get_tripple_cabin_price($prices, $promotion, $num_pax_calculated, $is_promotion){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, false, $is_promotion);
	
	$tripple_price = $basic_price['adult_price'] * 3;
	
	return $tripple_price;
}

function get_family_cabin_price($prices, $promotion, $num_pax_calculated, $is_promotion, $tour_children_price, $adults, $children){
	
	$basic_price = get_basic_price($prices, $promotion, $num_pax_calculated, false, $is_promotion);

	$family_price = $basic_price['adult_price'] * 3 + $basic_price['single_sup']; // double price + single-sup price
	
	if ($adults == 4 || $adults + $children == 5){ // 4 adults OR 5 pax -> 2 double price
		
		$family_price = $basic_price['adult_price'] * 4;
		
	} else if ($adults == 3 && $children == 1){
		
		$family_price = $basic_price['adult_price'] * 2;
		
		// 1 adult + 1 children
		$cabin_price_type = $tour_children_price ? $tour_children_price['a1_c1'] : PRICE_DOUBLE;
		
		if ($cabin_price_type == PRICE_DOUBLE){
		
			$family_price = $family_price + $basic_price['adult_price'] * 2;
			
		} elseif ($cabin_price_type == PRICE_SINGLE){
			
			$family_price = $family_price + $basic_price['adult_price'] + $basic_price['single_sup'];
			
		} elseif ($cabin_price_type == PRICE_BY_PERSON){
			
			$family_price = $family_price +  $basic_price['adult_price'] + $basic_price['children_price'];
			
		} 
	} else if($adults + $children == 3){
		$family_price = $basic_price['adult_price'] * 3;
	}

	return $family_price;
}

/**
 * Get Triple & Family Cabin Price
 * 
 * Updated by Khuyenpv 21.03.2015
 * Triple & Family Cabin: price per pax
 */
function get_triple_family_cabin_price($prices, $promotion, $check_rates, $is_promotion){
	
	$adults = $check_rates['adults'];
	$children = $check_rates['children'];
	
	$group_size = $adults + $children;
	
	$basic_price = get_basic_price($prices, $promotion, $group_size, false, $is_promotion);
	
	$cabin_price = $basic_price['adult_price'] * $adults + $basic_price['children_price'] * $children;
	
	return $cabin_price;
}
