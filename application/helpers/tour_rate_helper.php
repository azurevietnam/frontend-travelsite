<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * HELPER FUNCTIONS FOR CHECK THE TOUR RATES
 * 
 * @auther Khuyenpv
 * @since March 16 2015
 */

/**
 * Get check-rate information from GET parameters
 * @author Khuyenpv
 * @since March 16 2015
 */
function get_tour_check_rate_from_url($tour){
	
	$CI =& get_instance();
	
	$check_rates = array();
	
	$tour_id = $CI->input->get('tour_id');
	
	if(!empty($tour_id)){ // check rate in the cruise, we have list tours => the tour_id is the selected tour
		$tour['id'] = 0; // special for cruise check-rate
	}
	
	
	$adults = $CI->input->get('adults_'.$tour['id']);
	$children = $CI->input->get('children_'.$tour['id']);
	$infants = $CI->input->get('infants_'.$tour['id']);
	$departure_date = $CI->input->get('tour_date_'.$tour['id']);
	
	$action = $CI->input->get('action');
	
	$change = $CI->input->get('change_'.$tour['id']);
	
	if($tour_id != '') $check_rates['tour_id'] = $tour_id;
	if($adults != '') $check_rates['adults'] = $adults;
	if($children != '') $check_rates['children'] = $children;
	if($infants != '') $check_rates['infants'] = $infants;
	if($departure_date != '') $check_rates['departure_date'] = $departure_date;
	if($action != '') $check_rates['action'] = $action;
	
	if($change != '') $check_rates['change'] = $change;
	
	return $check_rates;
}

/**
 * Check if the tour has price based on cabin arrangement
 * 
 * @author Khuyenpv
 * @since March 17 2015
 * 
 */
function is_price_per_cabin($tour){
	
	$ret = $tour['cruise_id'] > 0; // is cruise tour
	
	$ret = $ret && is_bit_value_contain($tour['group_type'], TOUR_TYPE_GROUP); // group tour
	
	$ret = $ret && $tour['num_cabin'] > 0; // cruise number of cabin must be > 0
	
	$ret = $ret && !is_bit_value_contain($tour['types'], CRUISE_TYPE_PRIVATE); // the cruise must not be private cruise
	
	$ret = $ret && !is_bit_value_contain($tour['types'], CRUISE_TYPE_DAY); // the cruise must not be day cruise
	
	return $ret;
}

/**
 * Check if a accommodation is a cruise cabin
 * 
 * @author Khuyenpv
 * @since March 19 2015
 */
function is_cruise_cabin($acc){
	return !empty($acc['cruise_cabin_id']);
}

/**
 * Cabin Arrange Automatically
 * 
 * @author Khuyenpv
 * @since March 17 2015
 */
function cabin_arrangement_automatic($check_rates){
	
	$adults = $check_rates['adults'];
	
	$children = $check_rates['children'];
	
	$infants = $check_rates['infants'];
	
	$cabins = array();

	$double = floor($adults / 2);


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


		$cabin['arrangement_text'] = get_cabin_arrangement_text($cabin, $cabin_types);

		$cabins[$key] = $cabin;

	}
	
	return $cabins;
}

/**
 * Cabin Arrange Manually
 *
 * @author Khuyenpv
 * @since March 17 2015
 */
function cabin_arrangement_manually($tour){
	
	$CI =& get_instance();
	
	$num_cabin = $CI->input->get('num_cabin_'.$tour['id']);
	
	$cabin_types = $CI->config->item('cabin_types');
	
	$ret = array();
	
	for ($i = 1; $i <= $num_cabin; $i++) {
		
		$cabin_type = $CI->input->get($tour['id'].'_type_'.$i);
			
		$cabin_adults = $CI->input->get($tour['id'].'_adults_'.$i);
			
		$cabin_children = $CI->input->get($tour['id'].'_children_'.$i);
			
		$cabin_infants = $CI->input->get($tour['id'].'_infants_'.$i);
			
		$cabin['type'] = $cabin_type;
			
		$cabin['adults'] = $cabin_adults;
			
		$cabin['children'] = $cabin_children;
			
		$cabin['infants'] = $cabin_infants;
			
		$cabin['arrangement_text'] = get_cabin_arrangement_text($cabin, $cabin_types);
			
		$ret[$i] = $cabin;
		
	}
	
	return $ret;
	
}

/**
 *	Get Cabin Arrangement Text
 *
 *  @author Khuyenpv
 *  @since March 17 2015
 */
if (! function_exists('get_cabin_arrangement_text'))
{
	function get_cabin_arrangement_text($cabin, $cabin_types){
		
		$text = generate_traveller_text($cabin['adults'], $cabin['children'], $cabin['infants'] );
	
		return (translate_text($cabin_types[$cabin['type']]).' - ' .$text);
	
	}
}
/**
 * Load the tour accommodation detail information
 * @author Khuyenpv
 * @since March 19 2015
 */
function load_acc_info($is_mobile, $acc){
	
	$view_data['acc'] = $acc;
	
	$acc_info_view = load_view('tours/check_rates/acc_info', $view_data, $is_mobile);
	
	return $acc_info_view;
}

/**
 * Get Tour Cabin Arrangements Array
 * 
 * @author Khuyenpv 19.03.2015
 */
function get_tour_cabin_arrangements($tour, $check_rates){
	
	// if the tour price based on cabin price
	if(is_price_per_cabin($tour) && !empty($check_rates)){
	
		$is_change_cabin = !empty($check_rates['change']) && $check_rates['change'] == 'change_cabin';

		if($is_change_cabin){
			return cabin_arrangement_manually($tour);
		} else {
			return cabin_arrangement_automatic($check_rates);
		}
	}
	
	return array();
}

/**
 * Check if the Tour Price Has Single-Suplement or not
 * 
 * @author Khuyenpv 20.03.2015
 */
if (! function_exists('is_single_sup'))
{
	function is_single_sup($adults, $children, $accommodations = array()){
	
		if ($adults % 2 == 0){
	
			return false;
	
		} else {
	
			if ($children % 2 != 0){
					
				return false;
			}
			if(!empty($accommodations)){
				foreach ($accommodations as $accommodation){
						
					$single_sup = get_accommodation_price($accommodation['prices'], 0);
						
					if ($single_sup > 0){
		
						return true;
					}
						
				}
				return false;
			} else {
				return true;	
			}
				
		}
	
	}
}
/**
 * Get price of accomodation based on pax index
 * 
 * @author Khuyenpv 20.03.2015
 */
function get_accommodation_price($prices, $group_size){
	foreach ($prices as $pd){
		if($pd['group_size'] == $group_size) return $pd['price'];
	}
	return 0;
}

/**
 * Group all promotion details by distinct promotion
 * 
 * @author Khuyen 20.03.2015
 */
function group_promotion_details_by_promotion($all_promotion_details){
	
	$promotions = array();
	
	foreach ($all_promotion_details as $value){
		$promotions[$value['id']] = $value; 
	}
	
	$promotions = array_values($promotions);
	
	$is_first_normal_pro = true;
	
	$tmp_promotions = array();
	
	foreach ($promotions as $value){
		
		if($value['is_hot_deals'] == STATUS_ACTIVE){ // always add the IS HOT DEALS promotions
			$tmp_promotions[] = $value;
			
		} else if($is_first_normal_pro){ // ony add the first NOT IS HOT DEAL PROMOTION
			$tmp_promotions[] = $value;
			$is_first_normal_pro = false;
		}
		
	}
	
	$promotions = $tmp_promotions;
	
	foreach ($promotions as $key => $value){
		
		$promotion_details = array();
		
		foreach ($all_promotion_details as $pd){
			
			if($pd['id'] == $value['id']){
				
				$promotion_details[] = $pd;
			}
			
		}
		
		$value['promotion_details'] = $promotion_details;
		
		$promotions[$key] = $value;
	}
	
	return $promotions;
}


/**
 * Count number of tour-rate table column
 * 
 * @author Khuyenpv 20.03.2015
 */
function count_tour_rate_table_colum_nr($tour, $check_rates, $cabin_arrangements, $is_single_sup, $discount){
	$nr = 3;
	
	if(is_price_per_cabin($tour)){
		$nr += count($cabin_arrangements);
	} else {
		$nr = $nr + 1; // adults column
		if($is_single_sup){
			$nr = $nr + 1; // single suplement column
		}
		if($check_rates['children'] > 0){
			$nr = $nr + 1; // children column
		}
		if($check_rates['infants'] > 0){
			$nr = $nr + 1; // children column
		}
	}
	
	if($discount > 0) $nr++;
	
	return $nr;
}


/**
 * Check if the Cabin is tripple cabin or not
 * 
 * @author Khuyenpv 20.03.2015
 */
function is_triple_cabin($tour, $acc){
	return is_price_per_cabin($tour) && $acc['max_person'] == 3;	
}

/**
 * Check if the Cabin is family cabin or not
 *
 * @author Khuyenpv 20.03.2015
 */
function is_family_cabin($tour, $acc){
	return is_price_per_cabin($tour) && $acc['max_person'] > 3;
}

/**
 * Get Cabin Price Type based on Number of pax in Cabin & Cabin Price Configuration
 * 
 * @author Khuyen 
 * @since March 20 2015
 */
if (! function_exists('get_cabin_price_type'))
{
function get_cabin_price_type($cabin, $cabin_price_cnf){

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
				
			$cabin_price_type = !empty($cabin_price_cnf) ? $cabin_price_cnf['a1_c2'] : PRICE_DOUBLE_EXTRA;

			// 1 adult + 1 children
		} elseif ($cabin['children'] == 1){
				
			$cabin_price_type = !empty($cabin_price_cnf) ? $cabin_price_cnf['a1_c1'] : PRICE_DOUBLE;
				
		} else {
				
			// 1 adult: single
			$cabin_price_type = PRICE_SINGLE;
				
		}


	} else {
		// 3 children
		if ($cabin['children'] + $cabin['infants'] == 3){
				
			$cabin_price_type = !empty($cabin_price_cnf) ? $cabin_price_cnf['c3'] : PRICE_DOUBLE;
				
			// 2 children
		} elseif ($cabin['children'] + $cabin['infants'] == 2){
				
			$cabin_price_type = !empty($cabin_price_cnf) ? $cabin_price_cnf['c2'] : PRICE_SINGLE;
				
		} elseif ($cabin['children'] + $cabin['infants'] == 1){
				
			$cabin_price_type = !empty($cabin_price_cnf) ? $cabin_price_cnf['c1'] : PRICE_SINGLE;
				
		}

	}

	return $cabin_price_type;

}
}

/**
 * Get basic Accommodation Prices
 * 
 * @author Khuyenpv 
 * @since Mar 20 2015
 */
if (! function_exists('get_basic_price'))
{
	function get_basic_price($prices, $offer_rate, $num_pax){
	
		$basic_price = array();
	
		if ($num_pax > 10) $num_pax = 10;
	
		$children_percentage =  get_accommodation_price($prices, -1); // -1 for children price
		
		$adult_price = get_accommodation_price($prices, $num_pax);
		
		$children_price = $children_percentage * $adult_price / 100;
		
		$single_sup = get_accommodation_price($prices, 0); // 0 for single suplement
		
		$infant_percentage = get_accommodation_price($prices, -2); // 0 for infant price
		
		$infant_price = $infant_percentage * $adult_price / 100;
		
		if(!empty($offer_rate)){ // discount by % promotion
			
			$adult_price = $adult_price - round($adult_price * $offer_rate / 100,0);
			$children_price = $children_price - round($children_price * $offer_rate / 100,0);
			$single_sup = $single_sup - round($single_sup * $offer_rate / 100,0);
			$infant_price = $infant_price - round($infant_price * $offer_rate / 100,0);
		
		}
		
		$basic_price['adult_price'] = $adult_price;
	
		$basic_price['children_price'] = $children_price;
	
		$basic_price['single_sup'] = $single_sup;
		
		$basic_price['infant_price'] = $infant_price;
	
		return $basic_price;
	
	}
}

/**
 * Calculate Number of Passenger based on Cabin Arrangement
 * 
 * @author Khuyenpv
 * @since Mar 20 2015
 * 
 */
function calculate_tour_nr_pax($tour, $cabin_arrangements, $cabin_price_cnf, $check_rates){

	$ret = 0;
	
	if(is_price_per_cabin($tour)){ // price percabin
		foreach ($cabin_arrangements as $cabin){
	
			$cabin_price_type = get_cabin_price_type($cabin, $cabin_price_cnf);
	
			if ($cabin_price_type == PRICE_DOUBLE || $cabin_price_type == PRICE_DOUBLE_EXTRA){
					
				$ret = $ret + 2;
					
			} elseif ($cabin_price_type == PRICE_SINGLE){
					
				$ret = $ret + 1;
					
			} elseif ($cabin_price_type == PRICE_BY_PERSON){
					
				$ret = $ret + $cabin['adults'];
					
			}
	
		}
		
	} else { // price per pax
		
		$ret = $check_rates['adults'];
		
		if(!empty($check_rates['children'])){
			
			$ret += $check_rates['children'];
		}
		
	}

	return $ret;

}


/**
 * Get Cabin price based on Origin Price, Promotion & Cabin Price Configuration
 * 
 * @author Khuyenpv 
 * @since March 20.03.2015
 */
if (! function_exists('get_cabin_price'))
{
	function get_cabin_price($acc, $promotion, $cabin, $cabin_price_cnf, $num_pax){
		
		
		$offer_rate = get_acc_pro_offer_rate($acc, $promotion);
		
		// get basic cabin price
		$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);
		
		
		/*
		 * Price by cabin type
		*/
		$cabin_price_type = get_cabin_price_type($cabin, $cabin_price_cnf);
		
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
}


/**
 * Get Triple & Family Cabin Price
 *
 * Updated by Khuyenpv 26.03.2015
 * Triple & Family Cabin: price per pax
 */
if (! function_exists('get_triple_family_cabin_price'))
{
	function get_triple_family_cabin_price($acc, $promotion, $check_rates){
	
		$adults = $check_rates['adults'];
		$children = $check_rates['children'];
		
		$num_pax = $adults + $children; // based on the number of adults
		
		$offer_rate = get_acc_pro_offer_rate($acc, $promotion);
		
		$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);
	
		// price per person
		$cabin_price = $basic_price['adult_price'] * $adults + $basic_price['children_price'] * $children;
	
		return $cabin_price;
	}
}

/**
 * Get Accommodation Offer Rate
 * 
 * @author Khuyenpv
 * @since Mar 21 2015
 */
function get_acc_pro_offer_rate($acc, $promotion){
	// find the offer rate from Promotion-Detail first
	$offer_rate = 0;
	
	if(!empty($promotion['promotion_details'])){
	
		foreach ($promotion['promotion_details'] as $pd){
				
			if($pd['accommodation_id'] == $acc['id']){
	
				$offer_rate = $pd['offer_rate'];
	
				break;
			}
				
		}
	
	}
	return $offer_rate;
}

/**
 * Get Accommodation Offer Note
 * 
 * @author Khuyenpv 26.03.2015
 */
function get_acc_pro_offer_note($acc, $promotion){

	$offer_note = '';
	
	if(!empty($promotion['promotion_details'])){
	
		foreach ($promotion['promotion_details'] as $pd){
	
			if($pd['accommodation_id'] == $acc['id']){
	
				$offer_note = $pd['note_detail'];
				
				if(empty($offer_note)) $offer_note = $pd['offer_note'];
	
				break;
			}
	
		}
	
	}
	return $offer_note;
	
}

/**
 * Get Adults Price for NOT PER CABIN TOUR
 * 
 * @author Khuyenpv Mar 21 2015
 */
if (! function_exists('get_adult_price'))
{
	function get_adult_price($acc, $promotion, $num_pax, $check_rates){
		
		$adults = $check_rates['adults'];
		
		$offer_rate = get_acc_pro_offer_rate($acc, $promotion);
	
		$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);
	
		$adult_price = $basic_price['adult_price'] * $adults;
	
		return $adult_price;
	
	}
}

/**
 * Get Adult Price for NOT PER CABIN TOUR
 *
 * @author Khuyenpv Mar 21 2015
 */
if (! function_exists('get_children_price'))
{
	function get_children_price($acc, $promotion, $num_pax, $check_rates){
		
		$children = !empty($check_rates['children']) ? $check_rates['children'] : 0;
		
		if($children == 0) return 0;
		
		
		$offer_rate = get_acc_pro_offer_rate($acc, $promotion);
	
		$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);
	
		$children_price = $basic_price['children_price'] * $children;
	
		return $children_price;
	
	}
}

/**
 * Get Single Suplement Price
 * 
 * @author Khuyenpv Mar 21 2015
 */
if (! function_exists('get_singe_sup_price'))
{
	function get_singe_sup_price($acc, $promotion, $num_pax){
	
		$offer_rate = get_acc_pro_offer_rate($acc, $promotion);
		
		$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);
	
		return $basic_price['single_sup'];
	}
}

/**
 * Get Infant Price for NOT PER CABIN TOUR
 *
 * @author Khuyenpv Mar 21 2015
 */
function get_infant_price($acc, $promotion, $num_pax, $check_rates){

	$infants = !empty($check_rates['infants']) ? $check_rates['infants'] : 0;
	
	if($infants == 0) return 0;

	$offer_rate = get_acc_pro_offer_rate($acc, $promotion);

	$basic_price = get_basic_price($acc['prices'], $offer_rate, $num_pax);

	$infant_price = $basic_price['infant_price'] * $infants;

	return $infant_price;

}


/**
 * Get total cabin price
 * 
 * @author Khuyenpv
 * @since 21.03.2015
 */
function get_total_tour_acc_price($tour, $acc, $promotion, $cabin_arrangements, $cabin_price_cnf, $num_pax, $check_rates, $discount){
	
	$total = 0;
	
	$adults  = $check_rates['adults'];
	$children  = !empty($check_rates['children']) ? $check_rates['children'] : 0;
	$infants  = !empty($check_rates['infants']) ? $check_rates['infants'] : 0;
	
	if(is_price_per_cabin($tour)){
		
		if(is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc)) return get_triple_family_cabin_price($acc, $promotion, $check_rates);
		
		foreach ($cabin_arrangements as $cabin){
			
			$total += get_cabin_price($acc, $promotion, $cabin, $cabin_price_cnf, $num_pax);
			
		}
		
	} else {
		
		$total += get_adult_price($acc, $promotion, $num_pax, $check_rates);
		
		$total += get_children_price($acc, $promotion, $num_pax, $check_rates);
		
		if(is_single_sup($adults, $children)){
			$total += get_singe_sup_price($acc, $promotion, $num_pax);
		}
		
		$total += get_infant_price($acc, $promotion, $num_pax, $check_rates);
		
	}
	
	$total = $total - $discount;
	
	
	return $total;
	
}

/**
 * Get tour discount together of a Tour
 * 
 * @author Khuyenpv 
 * @since 31.03.2015
 */
function get_tour_discount_together($tour, $check_rates, $cabin_price_cnf = array()){
	
	$CI =& get_instance();
	$CI->load->model('BookingModel');
	
	// children - cabin - price - configuration
	if(empty($cabin_price_cnf)){
		$cabin_price_cnf = $CI->Tour_Model->get_children_cabin_price($tour['id']);
	}

	$adults = isset($check_rates['adults']) ? $check_rates['adults'] : 2; // default for 2 adults
	
	$children = isset($check_rates['children']) ? $check_rates['children'] : 0;

	$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
	
	// get default discount on each tour-price
	$normal_discount = 0;
	if(!empty($check_rates['departure_date'])){
		$normal_discount = $CI->Tour_Model->get_tour_discount($tour['id'], $check_rates['departure_date']); 
	}
	
	$service_id = $tour['id'];
	
	$service_type = $tour['cruise_id'] > 0 ? CRUISE : TOUR;
	
	$is_main_service = $CI->BookingModel->is_main_service($tour['main_destination_id'], $service_type);
	
	$discount_coefficient = $adults + ($children * $children_rate / 100);
	
	$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
	
	return $discount_together;
	
}


/**
 * Calculate Transfer Price
 * 
 * @author Khuyenpv
 * @since 01.04.2015
 */

if (! function_exists('transfer_price'))
{
	function transfer_price($adult, $children, $price, $children_rate) {
		$adult_price = $adult * $price;
	
		$children_price = $children * round(($children_rate * $price) / 100, CURRENCY_DECIMAL);
	
		$transfer_price = $adult_price + $children_price;
	
		return $transfer_price;
	}
}
?>