<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_my_booking() {
	
	$my_bookings = array();
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	$is_mobile = is_mobile();
	
	//echo count($carts);
	
	foreach ($carts as $item){
		
		//echo $item['name'];
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			$booking_item = array();
			
			$booking_item['start_date'] = $options['start_date'];
			
			$booking_item['end_date'] = $options['end_date'];
			
			$booking_item['service_name'] = $item['name'];
			
			$booking_item['service_id'] = $options['service_id'];
			
			$booking_item['reservation_type'] = $options['reservation_type'];
			
			$booking_item['partner_id'] = $options['partner_id'];
			
			
			$booking_item['service_name'] = $options['service_name'];
			
			$booking_item['unit'] = $options['unit'];
			
			$booking_item['rate'] = $options['rate'];
			
			$booking_item['amount'] = $options['amount'];
			
			$booking_item['id'] = $item['id'];
			
			$booking_item['discount'] = $item['discount'];
			
			$booking_item['rowid'] = $item['rowid'];
			
			$booking_item['parent_id'] = $options['parent_id'];
			
			if (isset($options['duration'])) $booking_item['duration'] = $options['duration'];
			
			if (isset($item['booking_info'])) $booking_item['booking_info'] = $item['booking_info'];
			
			if (isset($item['pax_accom_info'])) $booking_item['pax_accom_info'] = $item['pax_accom_info'];

			if (isset($item['offer_note'])) $booking_item['offer_note'] = $item['offer_note'];
			
			if (isset($item['offer_cond'])) $booking_item['offer_cond'] = $item['offer_cond'];
			
			if (isset($item['offer_name'])) $booking_item['offer_name'] = $item['offer_name'];
			
			if (isset($item['check_rates'])) $booking_item['check_rates'] = $item['check_rates'];
			
			if (isset($item['promotion'])) $booking_item['promotion'] = $item['promotion'];
			
			if (isset($item['temp_optional_services'])) $booking_item['temp_optional_services'] = $item['temp_optional_services'];
			
			$booking_item['is_optional_service_selection'] = isset($item['is_optional_service_selection']) ? $item['is_optional_service_selection'] : false;
			
			
			$booking_item['destination_id'] = $options['destination_id'];
			
			$booking_item['is_free_visa'] = isset($item['is_free_visa']) ? $item['is_free_visa'] : false;
			
			$booking_item['free_visa_content'] = $booking_item['is_free_visa'] ? load_free_visa_popup($is_mobile) : '';
			
			$booking_item['special_offers'] = '';
			$service_type = $options['reservation_type'] == RESERVATION_TYPE_HOTEL ? HOTEL : TOUR;
			
			if(!empty($booking_item['promotion'])){
				$booking_item['special_offers'] = load_promotion_popup($is_mobile, $booking_item['promotion'], $service_type, false);
			}
			if(!empty($booking_item['offer_note']) && !empty($booking_item['offer_cond'])){
				$booking_item['special_offers'] = load_promotion_popup_4_old_storing($is_mobile, $booking_item['offer_name'], $booking_item['offer_note'], $booking_item['offer_cond'], $booking_item['rowid']);
			}
			
			$my_bookings[] = $booking_item;
			
		}
	}
	
	foreach ($my_bookings as $key => $booking_item){
		
		$detail_booking_items = array();
		
		$carts = $CI->cart->contents();
		
		$total_price = 0;
		
		foreach ($carts as $item){
			
			$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array();
			
			$type = $options['type'];
			
			$parent_rowid = $options['parent_rowid'];
			
			if ($type == ITEM_TYPE_CHILD && $parent_rowid == $booking_item['rowid']){
				
				$detail_booking_item = array();
				
				$detail_booking_item['service_name'] = $options['service_name'];
				
				$detail_booking_item['service_desc'] = isset($options['service_desc']) ? $options['service_desc'] : '';
				
				$detail_booking_item['service_id'] = $options['service_id'];
				
				$detail_booking_item['unit'] = $options['unit'];
				
				// for pax of visa, kayak ...etc
				if (isset($options['unit_text'])){
					$detail_booking_item['unit_text'] = $options['unit_text'];
				}
				
				$detail_booking_item['rate'] = $options['rate'];
				
				$detail_booking_item['amount'] = $options['amount'];
				
				$detail_booking_item['reservation_type'] = $options['reservation_type'];
				
				$detail_booking_items[] = $detail_booking_item;
			
				$total_price = $total_price + $detail_booking_item['amount'];
				
			}
		
		}
		
		$total_price = $total_price - $booking_item['discount'];
		
		$booking_item['total_price'] = $total_price;
		
		$booking_item['detail_booking_items'] = $detail_booking_items;

		$my_bookings[$key] = $booking_item;
		
	}
	
	return $my_bookings;
}

function get_my_reservations(){
	
	$customer_booking = array();
	
	$service_reservations = array();
	
	$total_selling_price = 0;
	
	$is_set_booking_info = false;
	
	// get cart data 
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	foreach ($carts as $item) {
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array();
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			if (empty($options['start_date']) || empty($options['end_date'])){
				
				$start_date = date(DB_DATE_FORMAT);
				
				$end_date = date(DB_DATE_FORMAT);				
				
			} else {
			
				$start_date = date(DB_DATE_FORMAT, strtotime($options['start_date']));
				
				$end_date = date(DB_DATE_FORMAT, strtotime($options['end_date']));
			
			}
			
			if (empty($customer_booking['start_date']) || strtotime($start_date) < strtotime($customer_booking['start_date'])) {
						
				$customer_booking['start_date'] = $start_date;
				
			}
				
			
			if (empty($customer_booking['end_date']) || strtotime($end_date) > strtotime($customer_booking['end_date'])) {
				
				$customer_booking['end_date'] = $end_date;
				
			}
			
			$service_reservation = array();
			
			$service_reservation['service_id'] = $options['service_id'];
				
			$service_reservation['service_name'] = $options['service_name'];
				
			$service_reservation['partner_id'] = $options['partner_id'];
			
			$service_reservation['start_date'] = $start_date;
				
			$service_reservation['end_date'] = $end_date;
			
			$service_reservation['selling_price'] = 0; // set later
			
			$service_reservation['description'] = $options['unit']; // set later
			
			$service_reservation['unit'] = $options['unit'];
			
			$service_reservation['reservation_type'] = $options['reservation_type'];
			
			// if the reservation type is Visa
			if ($service_reservation['reservation_type'] == RESERVATION_TYPE_VISA){
				
				$service_reservation['type_of_visa'] = $item['v_type_of_visa'];
				
				$service_reservation['processing_time'] = $item['v_processing_time'];
				
				if (isset($item['v_visa_details'])) $service_reservation['visa_users'] = $item['v_visa_details'];
				
				if (isset($item['v_flight_number'])) $service_reservation['flight_number'] = $item['v_flight_number'];
				
				if (isset($item['v_arrival_airport'])) $service_reservation['arrival_airport'] = $item['v_arrival_airport'];
				
				$service_reservation['description'] = ''; //reset for visa (don't need unit)
				
			}
			
			$service_reservation['discount'] = $item['discount'];
			
			$service_reservation['rowid'] = $item['rowid'];
			
			$service_reservation['destination_id'] = $options['destination_id'];
			
			if (isset($item['booking_info']) && !$is_set_booking_info) {
				
				$booking_info = $item['booking_info'];
				
				$customer_booking['adults'] = $booking_info['adults'];
					
				$customer_booking['children'] = $booking_info['children'];
					
				$customer_booking['infants'] = $booking_info['infants'];
				
				$customer_booking['guest'] = $booking_info['guest'];
				
				$is_set_booking_info = true;
				
			} elseif(isset($item['check_rates'])){
				
				$check_rates = $item['check_rates'];
				
				$customer_booking['adults'] = $check_rates['adults'];
					
				$customer_booking['children'] = $check_rates['children'];
					
				$customer_booking['infants'] = $check_rates['infants'];
				
				$customer_booking['guest'] = generate_traveller_text($check_rates['adults'], $check_rates['children'], $check_rates['infants']);
				
				$is_set_booking_info = true;
			}
			
			if (isset($item['pax_accom_info'])){
						
				$service_reservation['pax_booked'] = $item['pax_accom_info']['num_pax'];
				
				$service_reservation['cabin_booked'] = $item['pax_accom_info']['num_cabin'];
			}elseif(isset($options['pax_booked']) && isset($options['cabin_booked'])){
				$service_reservation['pax_booked'] = $options['pax_booked'];
				$service_reservation['cabin_booked'] = $options['pax_booked'];
			}
			
			if (isset($options['cruise_id'])){
				
				$service_reservation['cruise_id'] = $options['cruise_id'];
			
			}
			
			if (isset($options['group_id'])){
				
				$service_reservation['group_id'] = $options['group_id'];
			}
			
			$service_reservations[] = $service_reservation;
		}
	}

	
	
	
	foreach ($service_reservations as $key => $booking_item){
		
		$related_service_reservations = array();
		
		$selling_price = 0;
		
		$description = $booking_item['description'];
		
		$booking_services = '';
		
		foreach ($carts as $item){
				
			$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array();
				
			$type = $options['type'];
				
			$parent_rowid = $options['parent_rowid'];
				
			if ($type == ITEM_TYPE_CHILD && $parent_rowid == $booking_item['rowid']){
				
				$reservation_type = $options['reservation_type'];
				
				if ($reservation_type == RESERVATION_TYPE_NONE){
					
					if (strpos($options['service_name'], lang('cart_vat_item')) === false) { // dont't add 10%VAT on cabin price to the description
					
						if ($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR || $booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR){
							
							$description = $description. "\n".$options['service_name'];
							
							$booking_services = $booking_services. "\n".$options['service_name'];
							
						} else {
							
							$description = $description. "\n".$options['service_name'].': '.$options['unit'].' - '.CURRENCY_SYMBOL. number_format($options['amount'], CURRENCY_DECIMAL);;
							
							$booking_services = $booking_services. "\n".$options['service_name'].': '.$options['unit'];
						}
					
					}
					
					// selling price of main booking item
					$selling_price = $selling_price + $options['amount'];
				
				} else {
					
					if ($reservation_type == RESERVATION_TYPE_ADDITONAL_CHARGE){
						
						$reservation_type = RESERVATION_TYPE_OTHER;
					}
					
					$sr = array();
					
					$sr['service_name'] = $options['service_name'];
					
					$sr['service_id'] = $options['service_id'];
					
					$sr['reservation_type'] = $reservation_type;
					
					$sr['start_date'] = $booking_item['start_date'];
					
					$sr['end_date'] = $booking_item['end_date'];
					
					$sr['selling_price'] = $options['amount'];
					
					$sr['destination_id'] = $booking_item['destination_id'];
					
					if (isset($options['partner_id'])){
						$sr['partner_id'] = $options['partner_id'];
					}
				
					
					$unit_text = '';
					// for pax of visa, kayak ...etc
					if (isset($options['unit_text'])){
						$unit_text = $options['unit_text'];
					}
					
					$sr['description'] = $options['unit'].$unit_text.' - '.CURRENCY_SYMBOL. number_format($options['amount'], CURRENCY_DECIMAL);
					
					// Extra service Visa					
					if (strpos($sr['service_name'], 'Visa') !== FALSE){
						$sr['reservation_type'] = RESERVATION_TYPE_VISA;
						$sr['type_of_visa'] = 1; // 1 month single entry
					}
					
					$related_service_reservations[] = $sr;
					
				}
				
				$total_selling_price = $total_selling_price + $options['amount'];
			}
			
			
		}
		
		$selling_price = $selling_price - $booking_item['discount'];
		
		$total_selling_price = $total_selling_price + $selling_price;
		
		$booking_item['selling_price'] = $selling_price;
		
		$booking_item['description'] = $description;
		
		if ($booking_item['discount'] > 0){
			
			$booking_item['description'] = $booking_item['description']. "\n Discount booking together: ".CURRENCY_SYMBOL. number_format($booking_item['discount'], CURRENCY_DECIMAL);
			
		}
		
		if ($booking_item['reservation_type'] == RESERVATION_TYPE_VISA){
			
			$airports = $CI->config->item('airports');
			
			if (isset($booking_item['arrival_airport']) && $booking_item['arrival_airport'] != 0){
			
				$booking_item['description'] = $booking_item['description']."\n Arrival Airport: ".translate_text($airports[$booking_item['arrival_airport']]);
			
			}
			
			if (isset($booking_item['flight_number']) && $booking_item['flight_number'] != ''){
			
				$booking_item['description'] = $booking_item['description']."\n Flight Number: ". $booking_item['flight_number'];
			
			}
			
			if(isset($booking_item['arrival_airport'])) unset($booking_item['arrival_airport']);
			
			if(isset($booking_item['flight_number'])) unset($booking_item['flight_number']);
			
			if (!isset($booking_item['visa_users']) || count($booking_item['visa_users']) == 0){
				
				$booking_item['description'] = $booking_item['description']."\n <b>[Skip & Provide Later]</b>";
				
			}
		}
		
		
		$booking_item['booking_services'] = $booking_services;
		
		$booking_item['related_service_reservations'] = $related_service_reservations;
		
		unset($booking_item['discount']);
		
		unset($booking_item['rowid']);
		
		$service_reservations[$key] = $booking_item;

	}
	
	$customer_booking['request_date'] = _getCurrentDateTime();
		
	$customer_booking['selling_price'] = $total_selling_price;
	
	return array('customer_booking' => $customer_booking, 'service_reservations' => $service_reservations);
}


function insert_tour_accomodation_to_cart($data){

	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	
	$tour = $data['tour'];
		
	$booking_info = $data['booking_info'];
		
	$pax_accom_info = $data['pax_accom_info'];
		
	$num_pax_calculated = $pax_accom_info['num_pax'];
						
	$is_group = isset($data['cruise']) && is_group($data['cruise']);
		
	$num_cabin = isset($data['cruise']) ? $data['cruise']['num_cabin'] : 0;
		
	$tour_children_price = $data['tour_children_price'];
	
	$children_rate = $data['children_rate'];
		
	$accommodation = get_accommodation_selected($tour, $booking_info);
	
	$parent_id = isset($data['parent_id'])? $data['parent_id'] : "";
	
	$discount_together = $data['discount_together'];
	
	
	$is_main_service = $discount_together['is_main_service'];
	
	$normal_discount = $discount_together['normal_discount'];
	
	$discount_coefficient = $discount_together['discount_coefficient'];

	$is_discounted = $discount_together['is_discounted'];
	
	$discount = $discount_together['discount'];
	
	$discounted_rowids = $discount_together['discounted_rowids'];
	
	// special offer:
	
	$offer_note = isset($tour['price']['offer_note']) ? $tour['price']['offer_note'] : '';
	
	$offer_name = isset($tour['price']['deal_info']) ? $tour['price']['deal_info']['name'] : '';
	
	$offer_cond = isset($tour['price']['deal_info']) ? get_promotion_condition_text($tour['price']['deal_info']) : '';
	
	$is_free_visa = is_free_visa($tour);
	
	// add tour service to cart
	
	$options = array();
		
	$options['type'] = ITEM_TYPE_MAIN;
		
	$options['parent_rowid'] ='';

	$options['parent_id'] = $parent_id;
	
	$options['start_date'] = $booking_info['departure_date'];
		
	$options['end_date'] = $booking_info['end_date'];
		
	$options['service_id'] = $tour['id'];

	$options['service_name'] = $tour['name'];
	
	$options['destination_id'] = $tour['main_destination_id'];
		
	if ($tour['cruise_id'] > 0){
		

		$options['reservation_type'] = RESERVATION_TYPE_CRUISE_TOUR;
		
		if (isset($data['cruise'])){
			
			$options['cruise_id'] = $data['cruise']['id'];
			
			//$options['group_id'] = $data['cruise']['group_id'];
		}
		
	} else {
			
		$options['reservation_type'] = RESERVATION_TYPE_LAND_TOUR;
	}
		
	$options['unit'] = $booking_info['guest'];
		
	$options['rate'] = 0;

	$options['amount'] = 0;
		
		
	$options['pax_booked'] = $pax_accom_info['num_pax'];
		
	$options['cabin_booked'] = $pax_accom_info['num_cabin'];
	
		
	$options['partner_id'] = $tour['partner_id'];
	
	$options['duration'] = $tour['duration'];
	
	$id = 'sku_tour_'.$tour['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
	

	$tour_item = array(
	               'id'      => $id,
	               'qty'     => 1,
	               'price'   => 1,
	               'name'    => 'notuse',
	               'options' => $options,
				   'booking_info' =>$booking_info,
				   'pax_accom_info'=>$pax_accom_info,
				   'is_main_service' => $is_main_service,
				   'normal_discount' =>$normal_discount,
				   'is_discounted' => $is_discounted,
				   'discount' => $discount,
				   'discounted_rowids' => $discounted_rowids,
				   'offer_note' => $offer_note,
				   'offer_cond' => $offer_cond,
				   'offer_name' => $offer_name,
				   'is_optional_service_selection' => false,
				   'discount_coefficient' => $discount_coefficient,
				   'is_free_visa' => $is_free_visa
	
	);
		
         
    $parent_rowid = $CI->cart->insert($tour_item); 
    
    // update discounted status if inserted OK
    if ($parent_rowid){
    	
    	update_status_discounted($discounted_rowids, true);
    }
	
    $total_accomodation = 0;
    
    // cruise tour
	if ($tour['cruise_id'] > 0 && !is_private_tour($tour) && $num_cabin > 0){

		if ($accommodation['max_person'] <= 2){
		
			foreach ($pax_accom_info['cabins'] as $key => $value){
					
				$options = array();
		
				$options['type'] = ITEM_TYPE_CHILD;
				
				$options['parent_rowid'] = $parent_rowid;
				
				$options['unit'] = '1 cabin';				
				
				$price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, $is_group, $value, true, $tour_children_price);
				
				$options['rate'] = CURRENCY_SYMBOL. number_format($price, CURRENCY_DECIMAL);
				
				$options['amount'] = round($price, CURRENCY_DECIMAL); 
				
				$options['reservation_type'] = RESERVATION_TYPE_NONE;
				
				$name = 'Cabin '.$key.': '.$accommodation['name'].' '.$value['arrangement'];
				
				$options['service_id'] = '';
				
				$options['service_name'] = $name;
				
				$id = 'sku_cabin_'.$key.'_'.date(DATE_FORMAT_CART_TIMESTAMP);
				
				$item = array(
	               'id'      => $id,
	               'qty'     => 1,
	               'price'   => 1,
	               'name'    => 'notuse',
	               'options' => $options
				);
				
				$rowid = $CI->cart->insert($item);
				
				//echo $rowid.'<br>'; exit();
				
				$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);	
			}
		
		} else { // triple cabin & family cabin
			
			$options = array();
		
			$options['type'] = ITEM_TYPE_CHILD;
			
			$options['parent_rowid'] = $parent_rowid;
			
			$options['unit'] = '1 cabin';				
			
			/*
			 * Comment By Khuyenpv on 21.03.2015
			 * 
			 * 
			if ($accommodation['max_person'] == 3){ // tripple cabin				
				
				$price = get_tripple_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, true);
				
			} else { // family cabin
				
				$price = get_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, true, $tour_children_price, $booking_info['adults'], $booking_info['children']);
			}*/
			// price by person
			$price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $booking_info, true);
			
			
			$options['rate'] = CURRENCY_SYMBOL. number_format($price, CURRENCY_DECIMAL);
			
			$options['amount'] = round($price, CURRENCY_DECIMAL); 
			
			$options['reservation_type'] = RESERVATION_TYPE_NONE;
			
			$name = 'Cabin 1: '.$accommodation['name'].' - '.$booking_info['guest'];
			
			$options['service_id'] = '';
			
			$options['service_name'] = $name;
			
			$id = 'sku_cabin_1_'.date(DATE_FORMAT_CART_TIMESTAMP);
			
			$item = array(
               'id'      => $id,
               'qty'     => 1,
               'price'   => 1,
               'name'    => 'notuse',
               'options' => $options
			);
			
			$rowid = $CI->cart->insert($item);
			
			//echo $rowid.'<br>'; exit();
			
			$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);
			
			
		}
		
	} else {
		
		// land tour
		
		$options = array();
	
		$options['type'] = ITEM_TYPE_CHILD;
		
		$options['parent_rowid'] = $parent_rowid;
		
		$options['unit'] = $booking_info['guest'];
		
		$num_pax_calculated = get_pax_calculated($booking_info['adults'], $booking_info['children'], $tour, $accommodation['prices']);
		
		$price = get_total_tour_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, $is_group, $booking_info['adults'], $booking_info['children'], true);
		
		//echo $booking_info['adults'].' '. $booking_info['children']. ' '.$num_pax_calculated.' '.$price; exit();
		
		$options['rate'] = CURRENCY_SYMBOL. number_format($price, CURRENCY_DECIMAL);
				
		$options['amount'] = round($price, CURRENCY_DECIMAL);
		
		$options['reservation_type'] = RESERVATION_TYPE_NONE;
		
		$options['service_id'] = $accommodation['id'];
		
		$options['service_name'] = $accommodation['name'];
		
		$id = 'sku_accommodation_'.$accommodation['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
		
			$item = array(
               'id'      => $id,
               'qty'     => 1,
               'price'   => 1,
               'name'    => 'notuse',
               'options' => $options
			);
			
		$rowid = $CI->cart->insert($item); 
		
		$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);
				
	}
	
	// if the tour is marked as No-VAT then insert an VAT item to the shopping cart
	if(is_tour_no_vat($tour['id'])){
		
		$vat_value = $total_accomodation * 0.1;
		
		// 10% VAT
		
		$options = array();
		
		$options['type'] = ITEM_TYPE_CHILD;
		
		$options['parent_rowid'] = $parent_rowid;
		
		$options['unit'] = '10% VAT';
		
		$options['rate'] = CURRENCY_SYMBOL. number_format($vat_value, CURRENCY_DECIMAL);
		
		$options['amount'] = round($vat_value, CURRENCY_DECIMAL);
		
		$options['reservation_type'] = RESERVATION_TYPE_NONE;
		
		$options['service_id'] = '';
		
		$options['service_name'] = lang('cart_vat_item');
		
		$id = 'sku_vat_'.date(DATE_FORMAT_CART_TIMESTAMP);
		
		$item = array(
				'id'      => $id,
				'qty'     => 1,
				'price'   => 1,
				'name'    => 'notuse',
				'options' => $options
		);
			
		$rowid = $CI->cart->insert($item);
		
		$total_accomodation = $total_accomodation + round($vat_value, CURRENCY_DECIMAL);
		
	}
	
	if(count($tour['optional_services']['additional_charge']) > 0){
		
		$num_pax = $booking_info['adults'] + $booking_info['children'];
		
		foreach ($tour['optional_services']['additional_charge'] as $charge){
			
			$options = array();
	
			$options['type'] = ITEM_TYPE_CHILD;
			
			$options['parent_rowid'] = $parent_rowid;
			
			if ($charge['charge_type'] == 1){
				
				$options['unit'] = $num_pax. ' pax';
					
			} else {
				
				$options['unit'] = '1';
			}				
			
			if ($charge['charge_type'] != -1){
				
				$options['rate'] = CURRENCY_SYMBOL. number_format($charge['price'], CURRENCY_DECIMAL);
				
			} else {
				
				$options['rate'] = $charge['price'].'%';
				
			} 
			
			$options['amount'] = round(get_total_charge($charge, $total_accomodation, $num_pax), CURRENCY_DECIMAL);
			
			//echo get_total_charge($charge, $total_accomodation, $num_pax); exit();
			
			$options['reservation_type'] = RESERVATION_TYPE_ADDITONAL_CHARGE;
			
			$options['service_id'] = $charge['optional_service_id'];
			
			$options['service_name'] = $charge['name'];
			
			$options['service_desc'] = $charge['description'];
			
			$id = 'sku_optional_'.$charge['optional_service_id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
			
			$item = array(
               'id'      => $id,
               'qty'     => 1,
               'price'   => 1,
               'name'    => 'notuse',
               'options' => $options
			);
			
			$rowid = $CI->cart->insert($item);
		}
		
	}
	
	return $parent_rowid;
}

function insert_hotel_acoomodation_to_cart($data){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$parent_id = isset($data['parent_id'])? $data['parent_id'] : "";
	
	$hotel = $data['hotel'];	
	
	$search_criteria = $data['search_criteria'];
	
	$discount_together = $data['discount_together'];	
	
	$normal_discount = $discount_together['normal_discount'];
	
	$discount_coefficient = $discount_together['discount_coefficient'];
	
	$is_main_service = $discount_together['is_main_service'];

	$is_discounted = $discount_together['is_discounted'];
	
	$discount = $discount_together['discount'];
	
	$discounted_rowids = $discount_together['discounted_rowids'];
	
	$is_free_visa = isset($hotel['is_free_visa']) ? $hotel['is_free_visa'] : FALSE;
	
	$offer_note = '';
	$offer_name = '';
	$offer_cond = '';
	if (count($hotel['room_types']) > 0){
				
		$room_type = $hotel['room_types'][0];
		
		if (isset($room_type['price']['hotel_promotion_note'])){
			$offer_note = $room_type['price']['hotel_promotion_note'];
		}
		
		if (isset($room_type['price']['deal_info'])){
			$deal_info = $room_type['price']['deal_info'];
			
			$offer_name = $deal_info['name'];
			
			$offer_cond = get_promotion_condition_text($deal_info);
		}
		
	}


	$booking_info = get_hotel_booking_info($hotel);
	
	$booking_info['nights'] = $search_criteria['hotel_night'];
	
	$booking_info['staying_dates'] = $search_criteria['staying_dates'];
	
	// add hotel to cart
	$options = array();
		
	$options['type'] = ITEM_TYPE_MAIN;
		
	$options['parent_rowid'] ='';
	
	$options['parent_id'] = $parent_id;
		
	$options['start_date'] = $search_criteria['arrival_date'];
		
	$options['end_date'] = $search_criteria['departure_date'];
		
	$options['service_id'] = $hotel['id'];
	
	$options['service_name'] = $hotel['name'];		
		
	$options['description'] = '';
		
	$options['reservation_type'] = RESERVATION_TYPE_HOTEL;
		
	$options['unit'] = $search_criteria['hotel_night'].($search_criteria['hotel_night'] > 1 ? ' nights' : ' night');
	
	if (!empty($search_criteria['hotel_date_text'])){
		
		$options['unit'] = $options['unit']. ' ('.$search_criteria['hotel_date_text'].')';
	}
	
	$options['rate'] = 0;

	$options['amount'] = 0;
		
	$options['discount'] = 0;
		
	$options['partner_id'] = $hotel['partner_id'];
	
	$options['destination_id'] = $hotel['destination_id'];
		
	$id = 'sku_hotel_'.$hotel['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
		
	$hotel_item = array(
	               'id'      => $id,
	               'qty'     => 1,
	               'price'   => 1,
	               'name'    => 'notuse',
	               'options' => $options,
				   'booking_info' =>$booking_info,
				   'is_main_service' => $is_main_service,
				   'normal_discount' =>$normal_discount,
				   'is_discounted' => $is_discounted,
				   'discount' => $discount,
				   'discounted_rowids' => $discounted_rowids,		
				   'offer_note' => $offer_note,
				   'offer_cond' => $offer_cond,
				   'offer_name' => $offer_name,	
				   'is_optional_service_selection' => false,
				   'discount_coefficient' => $discount_coefficient,
				   'is_free_visa' => $is_free_visa
	);

         
    $parent_rowid = $CI->cart->insert($hotel_item); 
    
    
 	// update discounted status if inserted OK
    if ($parent_rowid){
    	
    	update_status_discounted($discounted_rowids, true);
    }
    
    $total_accomodation = 0;
    
	foreach ($hotel['room_types'] as $key => $value) {			
			
		$nr_room = $value['nr_room'];
		
		$nr_extra_bed = $value['nr_extra_bed'];
		
		$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'];
		
		if ($nr_room > 0){
		
			$options = array();
		
			$options['type'] = ITEM_TYPE_CHILD;
			
			$options['parent_rowid'] = $parent_rowid;
			
			$options['unit'] = $nr_room.($nr_room > 1 ? ' rooms' : ' room');
	
			if ($nr_extra_bed > 0){
				$options['unit'] = $options['unit']. ' + '.$nr_extra_bed.' extra-bed';
			}
			
			$options['rate'] = CURRENCY_SYMBOL.number_format($value['price']['promotion_price'], CURRENCY_DECIMAL);
			
			$options['amount'] = round($total_promotion_price, CURRENCY_DECIMAL);
			
			$options['service_id'] = $value['id'];
			
			$options['service_name'] = $value['name'];
			
			$options['reservation_type'] = RESERVATION_TYPE_NONE;

			$id = 'sku_room_'.$value['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
			
			$item = array(
	            'id'      => $id,
	            'qty'     => 1,
	            'price'   => 1,
	            'name'    => 'notuse',
	            'options' => $options
			);
			
			
				
			$rowid = $CI->cart->insert($item);
			
		}

		$total_accomodation = $total_accomodation + $total_promotion_price;
	}
	
	$additional_charges = $CI->HotelModel->get_hotel_additional_charge($hotel['id'], $booking_info['staying_dates'], $booking_info['rooms'], $booking_info['adults'], $booking_info['children']);
	
	if(count($additional_charges) > 0){
		
		$num_pax = $booking_info['adults'] + $booking_info['children'];
		
		foreach ($additional_charges as $charge){
			
			$options = array();
	
			$options['type'] = ITEM_TYPE_CHILD;
			
			$options['parent_rowid'] = $parent_rowid;
			
			if ($charge['charge_type'] == 1){
				
				$options['unit'] = $num_pax. ' pax';
					
			} elseif($charge['charge_type'] == 2){
				
				$rn = $booking_info['rooms'] * isset($charge['night_apply']) ? $charge['night_apply'] : count($booking_info['staying_dates']);
				
				$options['unit'] = $rn. ' room.night'. ($rn > 1 ? 's':'');
				
			} else {
				$options['unit'] = '1';
			}				
			
			if ($charge['charge_type'] == -1){
				
				$options['rate'] = $charge['price'].'%';
				
			} else { // per pax or per room.night

				$options['rate'] = CURRENCY_SYMBOL. number_format($charge['price'], CURRENCY_DECIMAL);
				
			} 
			
			if ($charge['charge_type'] == 2){ // per room.night
			
				$options['amount'] = $charge['price_total'];
			
			} else {
				
				$options['amount'] = round(get_total_charge($charge, $total_accomodation, $num_pax), CURRENCY_DECIMAL);
			}
			
			$options['reservation_type'] = RESERVATION_TYPE_ADDITONAL_CHARGE;
			
			$options['service_id'] = $charge['optional_service_id'];
			
			$options['service_name'] = $charge['name'];
			
			$options['service_desc'] = $charge['description'];
			
			$id = 'sku_optional_'.$charge['optional_service_id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
			
			$item = array(
               'id'      => $id,
               'qty'     => 1,
               'price'   => 1,
               'name'    => 'notuse',
               'options' => $options
			);
			
			$rowid = $CI->cart->insert($item);
		}
		
	}
	
	return $parent_rowid;
	
}


function get_total_charge($charge, $total_accommodation, $num_pax){
	
	$total = 0;
	
	if ($charge['charge_type'] != -1){

		if($charge['unit_type'] == 1){

			$total = $charge['price'] * $num_pax; // per pax

		} else {

			$total = $charge['price']; // group
		}

	} else {
		$total = $charge['price']/100 * $total_accommodation; // %

	}
	
	return $total;
			
}

function set_information_4_optional_services($optional_services, $booking_info, $children_rate, $total_accomodation, $booking_item){
	
	if(empty($booking_info)) return array('additional_charge'=>array(), 'transfer_services'=>array(), 'extra_services'=>array());
	
	$temp_optiona_services = isset($booking_item['temp_optional_services'])? $booking_item['temp_optional_services'] : array(); // temporary optional service selection
		
	$detail_booking_items = $booking_item['detail_booking_items'];
	
	$num_pax = $booking_info['adults'] + $booking_info['children'];
	
	foreach ($optional_services['transfer_services'] as $key=>$transfer){
		
		$transfer['unit'] = $booking_info['guest'];
		
		$transfer['rate'] = '';
		
		if ($transfer['charge_type'] != -1){
			
			$transfer['rate'] = CURRENCY_SYMBOL.number_format($transfer['price'], CURRENCY_DECIMAL);
		
		}
		
		$total_price = 0;
		
		if($transfer['unit_type'] == 1){
			
			$total_price = transfer_price($booking_info['adults'], $booking_info['children'], $transfer['price'], $children_rate);
			 
		} else {
			
			$total_price = $transfer['price'];
			
		}
		
		$transfer['total_price'] = $total_price;
		
		if ($total_price > 0){
			
			$transfer['amount'] = CURRENCY_SYMBOL.number_format($total_price, CURRENCY_DECIMAL);
			
		} else {
			
			$transfer['amount'] = lang('no_charge');
			
		}
		
		// check if the transfer is temporay selected:
		$transfer['is_booked'] = false;
		
		if (isset($temp_optiona_services[$transfer['optional_service_id']])){
			
			$status = $temp_optiona_services[$transfer['optional_service_id']];
			
			if ($status['selected'] == '1'){
				
				$transfer['is_booked'] = true;
				
			} 
			
		} else {
			
			$transfer['is_booked'] = is_optinal_service_booked($transfer['optional_service_id'], RESERVATION_TYPE_TRANSFER, $detail_booking_items); 
			
			$transfer['is_booked'] = $transfer['is_booked'] || (!$booking_item['is_optional_service_selection'] && $transfer['default_selected'] == 1);
		
		}
		
		$optional_services['transfer_services'][$key] = $transfer;
		
	}	

	foreach ($optional_services['extra_services'] as $key=>$extra){
		
		if ($extra['charge_type'] != -1){
			
			$extra['rate'] = CURRENCY_SYMBOL.number_format($extra['price'], CURRENCY_DECIMAL);
			
		} else {
			
			$extra['rate'] = number_format($extra['price'], CURRENCY_DECIMAL).'%';
			
		}
		
		$extra['unit'] = $num_pax;
		
		// Visa
		if (strpos($extra['name'], 'Visa') !== FALSE){
			$extra['unit'] = $num_pax + $booking_info['infants'];
		} 
		
		$total_price = 0;
		
		if ($extra['charge_type'] != -1){
			
			if($extra['unit_type'] == 1){ // per pax
				
				$total_price = $extra['price']* $num_pax;
				
			} else {
				
				$total_price = $extra['price']; // per group;
			}
			
		} else {
			
			$total_price = $extra['price']/100 * $total_accomodation;
		}
	
		$extra['total_price'] = $total_price;
		
		if ($total_price > 0){
			
			$extra['amount'] = CURRENCY_SYMBOL.number_format($total_price, CURRENCY_DECIMAL);
			
		} else {
			
			$extra['amount'] = lang('no_charge');
			
		}
		
		// check if the extra service is temporary selected:
		$extra['is_booked'] = false;
		
		if (isset($temp_optiona_services[$extra['optional_service_id']])){
			
			$status = $temp_optiona_services[$extra['optional_service_id']];
			
			if ($status['selected'] == '1'){
				
				$extra['is_booked'] = true;
				
				if($extra['unit_type'] == 1){
					
					$unit = $status['unit'];
					
					if ($unit != $extra['unit']){
						
						$extra['unit'] = $unit;
						
						$extra['total_price'] = $extra['price']* $unit;
						
						if ($extra['total_price'] > 0){
			
							$extra['amount'] = CURRENCY_SYMBOL.number_format($extra['total_price'], CURRENCY_DECIMAL);
							
						} else {
							
							$extra['amount'] = lang('no_charge');
							
						}
						
					}
					
				}
			} 
			
		} else {
				
			$extra['is_booked'] = is_optinal_service_booked($extra['optional_service_id'], RESERVATION_TYPE_OTHER, $detail_booking_items);
		
			// extra service & price per_pax && booked
			if($extra['unit_type'] == 1 && $extra['is_booked']){
				$booked_in_cart = get_optional_servcie_booked_in_cart($extra['optional_service_id'], RESERVATION_TYPE_OTHER, $detail_booking_items);
				$extra['unit'] = $booked_in_cart['unit'];
				$extra['rate'] = $booked_in_cart['rate'];
				$extra['amount'] = CURRENCY_SYMBOL.number_format($booked_in_cart['amount'], CURRENCY_DECIMAL);
			}
			
			$extra['is_booked'] = $extra['is_booked'] || (!$booking_item['is_optional_service_selection'] && $extra['default_selected'] == 1);
				
		}
	
		
		$optional_services['extra_services'][$key] = $extra;
	}
	
	return $optional_services;
	
}

function is_optinal_service_booked($optional_service_id, $reservation_type, $detail_booking_items){
	
	foreach ($detail_booking_items as $detail_booking_item){
		
		if ($detail_booking_item['service_id'] == $optional_service_id && $detail_booking_item['reservation_type'] == $reservation_type){
			return true;
		}
		
	}
	
	return false;
	
}

function get_optional_servcie_booked_in_cart($optional_service_id, $reservation_type, $detail_booking_items){
	
	foreach ($detail_booking_items as $detail_booking_item){
		
		if ($detail_booking_item['service_id'] == $optional_service_id && $detail_booking_item['reservation_type'] == $reservation_type){
			return $detail_booking_item;
		}
		
	}
	
	return false;
}

function remove_optional_service_from_cart($service_id, $reservation_type, $parent_rowid){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	$items = array();
	
	foreach ($carts as $item){
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		if ($options['parent_rowid'] == $parent_rowid && ($service_id == '' || $options['service_id'] == $service_id) && ($reservation_type == '' || $options['reservation_type'] == $reservation_type)){
			
			$items[] =  $item;
			
			
		}
	}
	// remove the item from the cart
	if (count($items) > 0){
		
		foreach ($items as $item){
			
			$rowid = $item['rowid'];
			
			if (isset($item['discounted_rowids'])){
				
				update_status_discounted($item['discounted_rowids'], false);
				
			}
			
			$data = array(
	           'rowid' => $rowid,
	           'qty'   => 0
	        );
	        
	        $CI->cart->update($data); 
        	
	        remove_optional_service_from_cart('', '', $rowid);
		}
		
	}
	
}

function remove_booking_item($rowid){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	$remove_item = array();
	
	foreach ($carts as $item){ 
		
		if ($item['rowid'] == $rowid){
			
			$remove_item =  $item;
			
			break;
			
		}
	}
	// remove the item from the cart
	if (count($remove_item) > 0){
		
		$rowid = $remove_item['rowid'];

			
		$data = array(
	       'rowid' => $rowid,
	       'qty'   => 0
	    );
	        
	    $CI->cart->update($data); 
        	
	    remove_optional_service_from_cart('', '', $rowid);
	    
	    /*
		if (isset($remove_item['discounted_rowids'])){
				
			update_status_discounted($remove_item['discounted_rowids'], false);
				
		}*/
		
	    reset_discount();
	}
}


function get_hotel_room_number($hotel){
	
	$nr_room = 0;
	
	foreach ($hotel['room_types'] as $key => $value) {			
			
		$nr_room = $nr_room + $value['nr_room'];
		
	}
	
	return $nr_room;
}

function update_status_discounted($rowids, $status){
	
	$CI =& get_instance();
	
	foreach ($rowids as $rowid){
		
		$CI->cart->update_item($rowid, 'is_discounted', $status);
		
	}
	
}

function get_my_booking_overview($data) {

	$data['my_booking_overview'] = '';

	$CI =& get_instance();
	$my_booking = get_my_booking();

	if($my_booking) {
		
		$total = 0;
		
		$discount = 0;
		
		foreach ($my_booking as $key=> $booking_item) {
			
			$total += $booking_item['total_price'];
			
			$discount += $booking_item['discount'];
			
		}
		
		$data['my_booking_services'] = $my_booking;
		$data['my_booking_info']['total_price'] = $total + $discount;
		$data['my_booking_info']['discount'] = $discount;
		$data['my_booking_info']['final_total'] = $total;

		$data['my_booking_overview'] = $CI->load->view('common/my_booking_overview', $data, TRUE);
	}

	return $data;
}

function get_my_cart_text() {
	
	$CI =& get_instance();
	$my_booking = get_my_booking();
	$num = count($my_booking);
	$my_cart = '';
	if($num == 0) {
		$text = '';
		$color = '#777';
		$img =  '<span class="icon icon-cart-empty"></span>';
	} else {
		$text = ($num == 1) ? ' (1 item)' :  ' ('.$num.' items)';
		$color = '#FF6600';
		$img =  '<span class="icon icon-cart-origin"></span>';
	}

	$my_cart = $img;
	
	$my_cart .= '<a rel="nofollow" href="'.site_url().'my-booking/'.'" style="margin-top:2px; color:'.$color.'; text-decoration: none;" >'.lang('label_my_booking').$text.'</a>';
	
	return $my_cart;
}

function get_cart_item_icon(){

	$CI =& get_instance();

	$my_booking = get_my_booking();

	$num = count($my_booking);

	$my_cart = '';
	
	if($num == 0) {
		$text = '';
		$color = '#777';
		$img =  '<a href="'.site_url().'my-booking/'.'" class="icon icon-cart-empty"></a>';
	} else {
		$img =  '<span class="icon icon-cart-origin"></span>';
		$text = ($num == 1) ? '<a href="'.site_url().'my-booking/'.'" class="item-num-cart text-cart">1</a>' : '<a href="'.site_url().'my-booking/'.'" class="item-num-cart text-cart">'.$num.'</a>';
		$color = '#FF6600';	
	}
	
	$icon = $text.$img;

	return $icon;
}

function get_cart_item_text(){

	$CI =& get_instance();

	$my_booking = get_my_booking();

	$num = count($my_booking);

	$my_cart = '';

	$text = ($num == 1) ? ' (1 item)' :  ' ('.$num.' items)';

	//$text = '<label style="color:#FF6600; float: left; font-size:12px; font-weight: normal;">'.$text.'</label>';

	return $text;
}

function get_service_name($destination_name, $service_id, $is_url_title = false)
{
    $service_name = '';
    
    if ($service_id == TOUR)
    {
        $service_name = $is_url_title ? 'Tours' : ucfirst(lang('tours'));
    }
    elseif ($service_id == CRUISE)
    {
        $service_name = $is_url_title ? 'Cruises' : ucfirst(lang('cruises'));
    }
    elseif ($service_id == HOTEL)
    {
        $service_name = $is_url_title ? 'Hotels' : ucfirst(lang('hotels'));
    }
    elseif ($service_id == VISA)
    {
        $service_name = $is_url_title ? 'Visas' : ucfirst(lang('visas'));
    }
    
    $service_name = $destination_name . ' ' . $service_name;
    
    return $service_name;
}

function get_accommodation_selected($tour, $booking_info){
	
	$accommodation_selected = $booking_info['accommodation'];
	
	foreach ($tour['accommodations'] as $accommodation){

		if ($accommodation_selected == $accommodation['id']){
			
			return  $accommodation;

		}

	}
	
	return false;
		
}

function reset_discount(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	
	$services = get_main_and_together_service();
	
	$main_services = $services['main_services'];
	
	$together_services = $services['together_services'];
	
	$has_main_service = count($main_services) > 0;

	
	foreach ($together_services as $key=>$item){
		
		$discount = 0;
		
		$is_discounted = false;
		
		
		
		$options = $CI->cart->product_options($item['rowid']);
			
		$reservation_type = $options['reservation_type'];
		
		// visa
		if ($reservation_type == RESERVATION_TYPE_VISA){
			
			if (is_already_booked_other_service_4_visa()){				
				
				$discount_coefficient = $item['discount_coefficient'];
	
				$normal_discount = $item['normal_discount'];
				
				
				$discount = $discount_coefficient * $normal_discount;
				
				// if visa book with halong bay => discount = total price : free visa
				$visa_booking_type = get_discount_visa_type();
				if ($visa_booking_type == 2){
					$discount = $item['v_total_price'];
				}
				
				$is_discounted = true;
			}
		} else {
			
			if ($has_main_service){
				
				$is_discounted = true;
				
				$discount = get_discount_item_service($item, $main_services);
				
			} else {
				
				// get discount between normal service
				$discount = get_discount_item_service($item, $together_services);
				
			}
			
		}
		
		$CI->cart->update_item($item['rowid'], 'discount', $discount);
		
		$CI->cart->update_item($item['rowid'], 'is_discounted', $is_discounted);
		
		$item['discount'] = $discount;
		
		$together_services[$key] = $item;
	}
	
	if ($has_main_service){
		
		foreach ($main_services as $key=>$item){
			
			$discount = get_discount_item_service($item, $main_services);
			
			$item['discount'] = $discount;
			
			$CI->cart->update_item($item['rowid'], 'discount', $discount);
		
			$CI->cart->update_item($item['rowid'], 'is_discounted', true);
			
			$main_services[$key] = $item;
		}
		
		
		$min_item = $main_services[0];
	
		foreach ($main_services as $item){
			
			$dc = $item['discount'];
			
			if ($dc < $min_item['discount']){
				
				$min_item = $item;
				
			}
		}
		
		$CI->cart->update_item($min_item['rowid'], 'discount', 0);
		
		$CI->cart->update_item($min_item['rowid'], 'is_discounted', false);
		
	
	} elseif(count($together_services) > 0) {
		
		$min_item = $together_services[0];
	
		foreach ($together_services as $item){
			
			$dc = $item['discount'];
			
			if ($dc < $min_item['discount']){
				
				$min_item = $item;
				
			}
		}
		
		$CI->cart->update_item($min_item['rowid'], 'discount', 0);
		
		$CI->cart->update_item($min_item['rowid'], 'is_discounted', false);
		
	}
}

function get_booked_destination_services(){
	
	$ret = array();
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	//echo count($carts);
	
	foreach ($carts as $item){
		
		//echo $item['name'];
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			if (isset($options['destination_id'])){
				
				$destination_id = $options['destination_id'];
				
				$service_id = "";
				
				$reservation_type = $options['reservation_type'];

				if ($reservation_type == RESERVATION_TYPE_CRUISE_TOUR){
					$service_id = CRUISE;
				}
				
				if ($reservation_type == RESERVATION_TYPE_LAND_TOUR){
					$service_id = TOUR;
				}
				
				if ($reservation_type == RESERVATION_TYPE_HOTEL){
					$service_id = HOTEL;
				}
				
				if ($reservation_type == RESERVATION_TYPE_VISA){
					$service_id = VISA;
				}
				
				$d['destination_id'] = $destination_id;
				
				$d['service_id'] = $service_id;
				
				$key = $destination_id.'_'.$service_id;
				
				$ret[$key] = $d;
			}
			
		}
	}
	return $ret;
}

function get_booking_item($rowid){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	foreach ($carts as $item){
		
		if ($item['rowid'] == $rowid){
			
			return $item;
			
		}
		
	}
	
	return FALSE;
}



function get_check_rate_together_info($search_criteria){

	$check_rate = array();
	
	$CI =& get_instance();
		
	$departure_date_check_rates_1 = $CI->input->post('departure_date_check_rates_1');
	
	if (empty($departure_date_check_rates_1)){
		$departure_date_check_rates_1 = $search_criteria['departure_date'];
	}
	
	$departure_date_check_rates_2 = $CI->input->post('departure_date_check_rates_2');
	
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
	
	$object_change_1 = $CI->input->post('object_change_1');
	
	if (!isset($object_change_1) || $object_change_1 == ''){
		
		$object_change_1 = 'change_person';
	}
	
	$object_change_2 = $CI->input->post('object_change_2');
	
	if (!isset($object_change_2) || $object_change_2 == ''){
		
		$object_change_2 = 'change_person';
	}
	
	$hotel_dates = $CI->input->post('hotel_dates');
	
	$check_rate['adults'] = $adults;
	
	$check_rate['children'] = $children;
	
	$check_rate['infants'] = $infants;
	
	$check_rate['departure_date_1'] = $departure_date_check_rates_1;
	
	if (!empty($departure_date_check_rates_2)){
		$check_rate['departure_date_2'] = $departure_date_check_rates_2;
	}
	
	$check_rate['object_change_1'] = $object_change_1;
	
	$check_rate['object_change_2'] = $object_change_2;
	
	if (!empty($hotel_dates)){
		asort($hotel_dates);
		$check_rate['hotel_dates'] = $hotel_dates;
	}
	
	$check_rate['guest'] = get_group_passenger_text($adults, $children, $infants);
	
	return $check_rate;
}

function is_arrange_cabin($service){
	
	return $service['service_type'] == TOUR && $service['cruise_id'] > 0 && !is_private_tour($service) && $service['num_cabin'] > 0;
	
}

function get_group_passenger_text($adults, $children, $infants){
	
	$adult_text = 'Adult';
	$children_text = 'Child';
	$infant_text = 'Infant';
	
	if ($adults > 1){
		$adult_text = 'Adults';
	}
	
	if ($children > 1){
		$children_text = 'Children';
	}
	
	if ($infants > 1){
		$infant_text = "Infants";
	}
	
	$is_first = false;
	
	$text = '';
	
	if ($adults > 0){
		$text = $adults.' '. $adult_text;
		$is_first = true;
	}	
	
	if ($children > 0){
		
		$text = $text. ($is_first? ', ' :''). $children.' '.$children_text;
		
		$is_first = true;
	}
	
	if ($infants > 0){
		
		$text = $text. ($is_first? ', ' :''). $infants. ' '. $infant_text;
	}
	
	return $text;
}

function set_optional_services_booking_together($optional_services, $check_rates, $children_rate, $total_acc = 0){
	
	$num_pax = $check_rates['adults'] + $check_rates['children'];
	
	
	foreach ($optional_services['additional_charge'] as $key=>$charge){
			
		if ($charge['charge_type'] == 1){
				
			$charge['unit'] = $num_pax. ' pax';
					
		} elseif($charge['charge_type'] == 2){ // per room.night
			
			$rn = isset($charge['night_apply']) ? $charge['night_apply'] : 1;
				
			$charge['unit'] = $rn. ' night'. ($rn > 1 ? 's':'');
			
		} else {		
			$charge['unit'] = '1';
		}				
			
		if ($charge['charge_type'] != -1){
				
			$charge['rate'] = CURRENCY_SYMBOL. number_format($charge['price'], CURRENCY_DECIMAL);
				
		} else {
				
			$charge['rate'] = $charge['price'].'%';
				
		}
		
		if ($charge['charge_type'] == 2){ // per room.night
			
			$charge['amount'] = round($charge['price_total'], CURRENCY_DECIMAL);
			
		} else {
		
			$charge['amount'] = round(get_total_charge($charge, 0, $num_pax), CURRENCY_DECIMAL);
		
		}
		
		$optional_services['additional_charge'][$key] = $charge;
			
	}	
		

	
	foreach ($optional_services['transfer_services'] as $key=>$transfer){
		
		$transfer['unit'] = get_group_passenger_text($check_rates['adults'], $check_rates['children'], $check_rates['infants']);
		
		$transfer['rate'] = '';
		
		if ($transfer['charge_type'] != -1){
			
			$transfer['rate'] = CURRENCY_SYMBOL.number_format($transfer['price'], CURRENCY_DECIMAL);
		
		}
		
		$total_price = 0;
		
		if($transfer['unit_type'] == 1){
			
			
			$total_price = transfer_price($check_rates['adults'], $check_rates['children'], $transfer['price'], $children_rate);
			
			
			 
		} else {
			
			$total_price = $transfer['price'];
			
		}
		
		$transfer['total_price'] = $total_price;
		
		if ($total_price > 0){
			
			$transfer['amount'] = CURRENCY_SYMBOL.number_format($total_price, CURRENCY_DECIMAL);
			
		} else {
			
			$transfer['amount'] = lang('no_charge');
			
		}
		
		$optional_services['transfer_services'][$key] = $transfer;
		
	}	

	foreach ($optional_services['extra_services'] as $key=>$extra){
		
		if ($extra['charge_type'] != -1){
			
			$extra['rate'] = CURRENCY_SYMBOL.number_format($extra['price'], CURRENCY_DECIMAL);
			
		} else {
			
			$extra['rate'] = number_format($extra['price'], CURRENCY_DECIMAL).'%';
			
		}
		
		$extra['unit'] = $num_pax;
		
		// Visa
		if (strpos($extra['name'], 'Visa') !== FALSE){
			$extra['unit'] = $num_pax + $check_rates['infants'];
		} 
		
		$total_price = 0;
		
		if ($extra['charge_type'] != -1){
			
			if($extra['unit_type'] == 1){ // per pax
				
				$total_price = $extra['price']* $num_pax;
				
			} else {
				
				$total_price = $extra['price']; // per group;
			}
			
		} else {
			
			$total_price = $extra['price'] * $total_acc / 100;
		}
	
		$extra['total_price'] = $total_price;
		
		if ($total_price > 0){
			
			$extra['amount'] = CURRENCY_SYMBOL.number_format($total_price, CURRENCY_DECIMAL);
			
		} else {
			
			$extra['amount'] = lang('no_charge');
			
		}
		
		$optional_services['extra_services'][$key] = $extra;
	}
	
	return $optional_services;
	
}

function add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $desc,  $unit, $rate, $amount, $unit_text = '', $partner_id = ''){

	$CI =& get_instance();
	
	remove_optional_service_from_cart($service_id, $reservation_type, $parent_rowid);
			
	if ($selected == '1'){
	
		$options = array();
	
		$options['type'] = ITEM_TYPE_CHILD;
			
		$options['parent_rowid'] = $parent_rowid;
			
		$options['unit'] = $unit;				
			
		$options['rate'] = $rate;
			
		$options['amount'] = $amount;
			
		$options['reservation_type'] = $reservation_type;
			
		$options['service_id'] = $service_id;
		
		$options['service_name'] = $name;
		
		$options['service_desc'] = $desc;
		
		if ($unit_text != ''){
			$options['unit_text'] = $unit_text;	
		}
		
		if ($partner_id != ''){
			$options['partner_id'] = $partner_id;
		}
			
		$item = array(
               'id'      => 'sku_optional_'.$service_id,
               'qty'     => 1,
               'price'   => 1,
               'name'    => 'notuse',
               'options' => $options
		);
			
		$rowid = $CI->cart->insert($item);
	
	}
	
}

function get_hotel_dates_text($hotel_dates){
	
	$ret = '';
	
	foreach ($hotel_dates as $key => $value) {
		
		$date_text = date('d M', strtotime($value));
		
		if ($key == 0){
			
			$ret = $date_text;
			
		} else {
			$ret = $ret.', '.$date_text;
		}
	}

	return $ret;
}

/**
 * 
 * COMMON FUNCTION FOR SPECIFIC DISCOUNT
 * 
 */

function get_ds_ids($service_id, $service_type, $discounts){
		
	$ds_ids = array();
	
	foreach ($discounts as $value){
	
		if ($service_id == $value['service_id_1'] && $service_type == $value['service_type_1']){
					
			
			$re_destination_service = $value['destination_service_id_2'];
			
			if (!empty($re_destination_service)){
				$ds_ids[$re_destination_service] = $re_destination_service;
			}
		}
		
		if ($service_id == $value['service_id_2'] && $service_type == $value['service_type_2']){
			
			
			$re_destination_service = $value['destination_service_id_1'];
			
			if(!empty($re_destination_service)){
				$ds_ids[$re_destination_service] = $re_destination_service;
			}
			
		}
	
	}
	
	if (count($ds_ids) > 0) $ds_ids = array_keys($ds_ids);
	
	return $ds_ids;
}

function set_service_ids($destination_services, $service_id, $service_type, $discounts){
	
	foreach ($destination_services as $key=>$ds){
			
		$service_ids = array();
		
		foreach ($discounts as $discount){
			
			if ($service_id == $discount['service_id_1'] && $service_type == $discount['service_type_1']){

				if ($ds['id'] == $discount['destination_service_id_2']){
					
					$service_ids[] = $discount['service_id_2'];
				}
			}
			
			if ($service_id == $discount['service_id_2'] && $service_type == $discount['service_type_2']){
				
				if ($ds['id'] == $discount['destination_service_id_1']){
					
					$service_ids[] = $discount['service_id_1'];
				}
			}
			
		}
		
		$ds['service_ids'] = $service_ids;
		
		$destination_services[$key] = $ds;
	}
	
	return $destination_services;
}

function get_discount_value($service_id, $service_type, $discounts, $item_id, $item_type){
		
	foreach ($discounts as $value){
			
		if ($service_id == $value['service_id_1'] && $service_type == $value['service_type_1']){
			
			$re_service_id = $value['service_id_2'];
			
			$re_service_type = $value['service_type_2'];
		}
		
		if ($service_id == $value['service_id_2'] && $service_type == $value['service_type_2']){
			
			$re_service_id = $value['service_id_1'];
			
			$re_service_type = $value['service_type_1'];
		}
		
		if ($re_service_id == $item_id && $re_service_type == $item_type){
			
			return $value;
		}
		
	}
	
	return '';
		
}

function get_specific_ds_dc_by_id($id, $specific_ds_discounts){
	
	foreach ($specific_ds_discounts as $value){
		
		if ($id == $value['id']){
			
			return $value;
			
		}
		
	}
	
	return FALSE;
}

function merge_service_array($specific_services, $recommend_services){
	
	foreach ($recommend_services as $value){
		
		if (!is_in_list($value, $specific_services)){
			
			$specific_services[] = $value;
		}
		
	}
	
	return $specific_services;
	
}

function is_in_list($service, $list_services){
	
	foreach ($list_services as $s){
		
		if ($s['id'] == $service['id']){
			
			return true;
			
		}
		
	}
	
	
	return false;
	
}

function get_discount_2_services($service_id_1, $service_type_1, $service_id_2, $service_type_2, $discount_vector = ''){
	
	if ($service_id_1 == '' || $service_id_2 == '') return 0;
	
	if ($discount_vector != ''){
	
		foreach ($discount_vector as $value){
			
			if ($service_id_1 == $value['service_id_1'] && $service_type_1 == $value['service_type_1'] && $service_id_2 == $value['service_id_2'] && $service_type_2 == $value['service_type_2'])
			{
				return $value['discount'];
			}
			
			if ($service_id_1 == $value['service_id_2'] && $service_type_1 == $value['service_type_2'] && $service_id_2 == $value['service_id_1'] && $service_type_2 == $value['service_type_1'])
			{
				return $value['discount'];
			}
		}
	
	} else {
		
		$CI =& get_instance();
		
		$discount = $CI->BookingModel->get_discount_2_services($service_id_1, $service_type_1, $service_id_2, $service_type_2);
		
		if ($discount !== FALSE){
			
			return $discount['discount'];
			
		}
		
		
	}
	
	return 0;
	
}

function get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount){
	
	$normal_discount_temp = $normal_discount;
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$discount_vector = $CI->BookingModel->get_discounts($service_id, $service_type);
	
	$normal_discount = $normal_discount * $discount_coefficient;
	
	$discount = 0;
	
	$is_discounted = false;
	
	$row_ids = array();
	
	$service_booked = get_main_and_together_service();
	
	$main_services = $service_booked['main_services'];
	
	$together_services = $service_booked['together_services'];
	
	
	// the current service is not main service
	if (!$is_main_service){
		
		$discount_array = array();
		
		foreach ($main_services as $item){
			
			$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
			
			$is_discounted = true;
			
			$item_service_id  = $options['service_id']; 
			
			$item_service_type = $options['reservation_type'];
			
			$item_service_type = get_service_type($item_service_type);
			
			// get special discount between current service and each of the main services
			$discount_array[] = $discount_coefficient * get_discount_2_services($service_id, $service_type, $item_service_id, $item_service_type, $discount_vector);
		
		}
		
		// not the main service, but book with visa, no main sevice booked before
		
		if ($service_type != VISA && count($main_services) == 0){
			
			$total_discount = 0;
			
			foreach ($together_services as $item){
				
				$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
				
				$item_service_type = $options['reservation_type'];
				
				// get totel discount from visa item
				if (!$item['is_discounted'] && $item_service_type == RESERVATION_TYPE_VISA){

					// discount on visa
					$item_normal_discount = isset($item['normal_discount']) && isset($item['discount_coefficient']) ? ($item['normal_discount'] * $item['discount_coefficient']) : 0;
					
					// total_discount from visa
					$total_discount = $total_discount + $item_normal_discount;
					
					$row_ids[] = $item['rowid'];
				
				}
				
				// 
				if (!$item['is_discounted'] && $item_service_type != RESERVATION_TYPE_VISA){
					
					// normal discount
					$item_normal_discount = isset($item['normal_discount']) && isset($item['discount_coefficient']) ? ($item['normal_discount'] * $item['discount_coefficient']) : 0;
					
					$item_service_id  = $options['service_id']; 
			
					$item_service_type = $options['reservation_type'];
					
					$item_service_type = get_service_type($item_service_type);
					
					$item_discount_coefficient = isset($item['discount_coefficient']) ? $item['discount_coefficient'] : 0;
					
					if ($item_service_type == HOTEL && $service_type != HOTEL){
						$discount_coefficient_apply = $item_discount_coefficient;
					}elseif($item_service_type != HOTEL && $service_type == HOTEL){
						$discount_coefficient_apply = $discount_coefficient;
					}else{
						$discount_coefficient_apply = max(array($discount_coefficient, $item_discount_coefficient));	
					}
					
					// sepecific discount
					$item_sepecific_discount = $discount_coefficient_apply * get_discount_2_services($service_id, $service_type, $item_service_id, $item_service_type, $discount_vector);
					
					// get the max discount between normal discount & specific discount
					$max_dc_value =  max(array($item_normal_discount, $item_sepecific_discount));
					
					$discount_array[] = $max_dc_value;
					
				}
			
			}
			
			$discount = $total_discount;
			
			if (count($discount_array) > 0){
				$discount_array[] = $normal_discount;			
				$discount = $discount + max($discount_array);
			}
		}
		
		
		// get max discount from normal discount & relation discount with other main service
		if (count($main_services) > 0){
		
			$discount_array[] = $normal_discount;
			
			$discount = max($discount_array);
		
		}
	
	} else {
		
		// no main sevice booked before
		if (count($main_services) == 0){
			
			$total_discount = 0;
				
			foreach ($together_services as $item){
				
				$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
				
				if (!$item['is_discounted']){

					// normal discount
					$item_normal_discount = isset($item['normal_discount']) && isset($item['discount_coefficient']) ? ($item['normal_discount'] * $item['discount_coefficient']) : 0;
					
					$item_service_id  = $options['service_id']; 
			
					$item_service_type = $options['reservation_type'];
					
					$item_service_type = get_service_type($item_service_type);
					
					$item_discount_coefficient = isset($item['discount_coefficient']) ? $item['discount_coefficient'] : 0;
					
					// sepecific discount
					$item_sepecific_discount = $item_discount_coefficient * get_discount_2_services($service_id, $service_type, $item_service_id, $item_service_type, $discount_vector);
					
					// get the max discount between normal discount & specific discount
					$total_discount = $total_discount + ($item_sepecific_discount > $item_normal_discount ? $item_sepecific_discount : $item_normal_discount);
					
					$row_ids[] = $item['rowid'];
				
				} 
			
			}
		
			
			$discount = $total_discount;
			
		} else {
			
			$discount_array = array();
			
			$main_dc_item = get_service_not_discounted($main_services);
			
			foreach ($main_services as $item){
				
				$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
				
				
				$item_service_id  = $options['service_id']; 
			
				$item_service_type = $options['reservation_type'];
				
				$item_service_type = get_service_type($item_service_type);

				$discount_array[] = $discount_coefficient * get_discount_2_services($service_id, $service_type, $item_service_id, $item_service_type, $discount_vector);
			
			}
			
			$discount = max($discount_array);
			
			if ($main_dc_item !== FALSE){
				
				$dc = isset($main_dc_item['normal_discount']) && isset($main_dc_item['discount_coefficient']) ? ($main_dc_item['normal_discount'] * $main_dc_item['discount_coefficient']) : 0;
				
				if ($dc > $discount){
					
					$discount = $dc;
					
					$row_ids[] = $main_dc_item['rowid'];
				}
			}
		
		}
		
	}
	
	
	$ret['discount'] = $discount; 
		
	$ret['is_discounted'] = $is_discounted;
	
	$ret['discounted_rowids'] = $row_ids;
	
	$ret['is_main_service'] = $is_main_service;
	
	$ret['normal_discount'] = $normal_discount_temp;
	
	$ret['discount_coefficient'] = $discount_coefficient;
	
	return $ret;
	
}

function get_service_type($reservation_type){
	
	if ($reservation_type == RESERVATION_TYPE_CRUISE_TOUR){
		
		return CRUISE;
	}
	
	if ($reservation_type == RESERVATION_TYPE_LAND_TOUR){
		
		return TOUR;
	}
	
	if ($reservation_type == RESERVATION_TYPE_HOTEL){
		
		return HOTEL;
	}
	
	if ($reservation_type == RESERVATION_TYPE_VISA){
		
		return VISA;
	}
	
	return -1;
}

function get_main_and_together_service(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$main_services = array();
	
	$together_services = array();
	
	$carts = $CI->cart->contents();
	
	foreach ($carts as $item){	
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
				
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){

			if ($item['is_main_service']){
				
				$main_services[] = $item;
				
			} else {
				
				$together_services[] = $item;
				
			}
		}
			
	}
	
	$ret['main_services'] = $main_services;
	
	$ret['together_services'] = $together_services;
	
	return $ret;
	
}

function get_service_not_discounted($servcies){
	
	foreach ($servcies as $value){
		
		if (!$value['is_discounted']){
			
			return $value;
			
		}
		
	}
	
	return false;
}

function get_discount_item_service($item_service, $services){
	
	$discount = 0;
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$options = $CI->cart->product_options($item_service['rowid']); 
	
	$service_id  = $options['service_id']; 
		
	$service_type = $options['reservation_type'];
		
	$service_type = get_service_type($service_type);
	
	$discount_coefficient = $item_service['discount_coefficient'];
	
	$normal_discount = $item_service['normal_discount'];

	$discount_vector = $CI->BookingModel->get_discounts($service_id, $service_type);
	
	$discount_array = array();
		
	foreach ($services as $item){
		
		if ($item_service['rowid'] != $item['rowid']){
		
			$options = $CI->cart->product_options($item['rowid']); 
			
			$item_service_id  = $options['service_id']; 
			
			$item_service_type = $options['reservation_type'];
			
			$item_service_type = get_service_type($item_service_type);
			
			$item_discount_coefficient = isset($item['discount_coefficient']) ? $item['discount_coefficient'] : 0;
					
			if ($item_service_type == HOTEL && $service_type != HOTEL){
				$discount_coefficient_apply = $item_discount_coefficient;
			}elseif($item_service_type != HOTEL && $service_type == HOTEL){
				$discount_coefficient_apply = $discount_coefficient;
			}else{
				$discount_coefficient_apply = max(array($discount_coefficient, $item_discount_coefficient));	
			}
			
			$discount_array[] = $discount_coefficient_apply * get_discount_2_services($service_id, $service_type, $item_service_id, $item_service_type, $discount_vector);
		
		}
	}
	
	// get max discount from normal discount & relation discount with other services
	$discount_array[] = $normal_discount * $discount_coefficient;
		
	$discount = max($discount_array);
	
	return $discount;
}

// get booking together price information info
function get_service_discount_price_info($service, $service_type, $is_main_service, $current_item_info){
	
	$price_from_unit = $service_type == HOTEL ? lang('per_room_night') : lang('per_pax');
	
	$discount_unit = $price_from_unit;
	
	if (!$service['is_discounted']){
		$discount_unit = '';
	}
	
	$discount_value = 0;
	
	$discount_price_info = array();
	
	$discount_price_info['is_na'] = false;
	
	
	$is_same_discount_unit = $current_item_info['service_type'] == $service_type || (($current_item_info['service_type'] == CRUISE || $current_item_info['service_type'] == TOUR) 
					&& ($service_type == CRUISE || $service_type == TOUR));
	
	// the current service is not booked (in tour-detail & cruise-detail & hotel-detail page)
	if (!$current_item_info['is_booked_it']){
		
		// the current service is a main servide
		if ($current_item_info['is_main_service']){
			
			// do nothing
			
		} else {
			
			// the listed item is not the main service
			if (!$is_main_service){				
				
				// get discount from the current viewing service
				$dc_v = $current_item_info['normal_discount'];
				
				$item_dc_v = $service_type == HOTEL ? $service['discount'] : $service['price']['discount'];
				
				// if the list item has it own discount
				if ($item_dc_v > 0){
					$dc_v = $item_dc_v;
					
					// if has the special discount between current service and the listed item
					if ($service['is_special_discounted']){
						
						// discount per room.night
						if($service_type == HOTEL || $current_item_info['service_type'] == HOTEL){
							$discount_unit = lang('per_room_night');
						} else {
							$discount_unit = lang('per_pax');
						}
					}
				}
				
				// not the same discount unit
				if (!$is_same_discount_unit){
					
					// reset to 0: correct number in the price-from
					if ($service_type == HOTEL && $discount_unit == lang('per_pax')){
						
						$service['discount'] = 0;
						
					} elseif($discount_unit == lang('per_room_night')) {
						
						if ($service_type == HOTEL){
							
							$service['discount'] = $dc_v;
							
						} else {
							
							$service['price']['discount'] = $dc_v;
							
						}
						
					}
					
					$discount_value = $dc_v;
					
				}
				
				
				
			} else { // the listed item is the main service			
				
				$dc_v = $current_item_info['normal_discount'];
				
				if ($service['is_special_discounted']){
					
					if ($service_type == HOTEL){
							
						$dc_v = $service['discount'];
							
					} else {
							
						$dc_v = $service['price']['discount'];
							
					}
				
				}
					
					
				if ($is_same_discount_unit){
				
					if ($service_type == HOTEL){
						
						$service['discount'] = $dc_v;
						
					} else {
						
						$service['price']['discount'] = $dc_v;
						
					}
					
				} else {
					
					if ($service_type == HOTEL){
						
						$service['discount'] = 0;
						
					} else {
						
						$service['price']['discount'] = 0;
						
					}
					
					$discount_value = $dc_v;
					
				}
					
					
				
				$discount_unit = $current_item_info['service_type'] == HOTEL ? lang('per_room_night') : lang('per_pax');
				
				if ($current_item_info['service_type'] == VISA){
					$discount_unit = lang('per_visa');
				}
				
			}
			
		}
		
	} else {
		
		// do nothing
	}
	
	$list_price = 0;
	
	$promotion_price = 0;
	
	if ($service_type == HOTEL){
		
		$discount_price_info['is_na'] = $service['price'] == 0;
		
		if($service['discount'] > 0){
			
			$list_price = $service['promotion_price'];
			
		} else if($service['price'] != $service['promotion_price']){
			
			$list_price = $service['price'];
			
		}
		
		$promotion_price = $service['promotion_price'] - $service['discount'];
		
		
		$discount_price_info['discount_value'] = $service['discount'];
		
	} else {
		/*
		$price_view = get_tour_price_view($service, false);
		
		$discount_price_info['is_na'] = $price_view['f_price'] == 0;
		
		
		if($price_view['discount'] > 0){
			
			$list_price = $price_view['f_price'];
			
		} elseif ($price_view['d_price'] > 0){
			
			$list_price = $price_view['d_price'];
			
		}
			
		$promotion_price = $price_view['f_together_price'];
							  

		$discount_price_info['discount_value'] = $price_view['discount'];
		*/
		
		$price = $service['price'];
		
		$discount_price_info['is_na'] = empty($price['price_from']);
		
		if(empty($price['price_from']) || empty($price['price_origin'])){
			$list_price = $promotion_price = 0;
		} else {
			$list_price = !empty($price['discount']) ? $price['price_from'] : $price['price_origin'];
			$promotion_price = $price['price_from'] - $price['discount'];
		}
		
		$discount_price_info['discount_value'] = $price['discount'];
		
	}
	
	
	$discount_price_info['price_from_unit'] = $price_from_unit;
	
	$discount_price_info['discount_unit'] = $discount_unit;
	
	
	$discount_price_info['list_price'] = $list_price;
	
	$discount_price_info['promotion_price'] = $promotion_price;
	
	if ($discount_value != 0){
		
		$discount_price_info['discount_value'] = $discount_value;
	}
	
	$service['discount_price_info'] = $discount_price_info;

	
	return $service;
}

function is_already_booked_other_service_4_visa(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	//echo count($carts);
	
	foreach ($carts as $item){
		
		//echo $item['name'];
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			$re_type = $options['reservation_type'];
			
			if ($re_type == RESERVATION_TYPE_CRUISE_TOUR || $re_type == RESERVATION_TYPE_LAND_TOUR || $re_type == RESERVATION_TYPE_HOTEL){
				
				return TRUE;
				
			}
			
		}
	}
	
	
	
	return FALSE;
	
}

function is_already_book_halong_bay_cruise(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	//echo count($carts);
	
	foreach ($carts as $item){
		
		//echo $item['name'];
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			$re_type = $options['reservation_type'];
			
			if ($re_type == RESERVATION_TYPE_CRUISE_TOUR){
				
				$des_id = $options['destination_id'];
				
				return $des_id == HALONG_BAY;
				
			}
			
		}
	}
	
	
	
	return FALSE;
}

function get_discount_visa_type(){
	
	if(is_already_book_halong_bay_cruise() && !check_prevent_promotion()) return 2; // type 2 - already booked halong bay cruises
	
	if(is_already_booked_other_service_4_visa()) return 1; // type 1 - normal discount
	
	return 0; // type 0 - no discount
	
}

function insert_visa_to_cart($visa_booking){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
		
	
	$normal_discount = $visa_booking['discount'];
	
	$discount_coefficient = $visa_booking['number_of_visa'];
	
	$is_main_service = FALSE; // visa is not the main service

	$is_discounted = is_already_booked_other_service_4_visa(); 
	
	$discount = $is_discounted? $normal_discount * $discount_coefficient : 0;
	
	$discounted_rowids = array();
		
	
	// add hotel to cart
	$options = array();
		
	$options['type'] = ITEM_TYPE_MAIN;
		
	$options['parent_rowid'] = '';
	
	$options['parent_id'] = '';
		
	$options['start_date'] = $visa_booking['arrival_date'];
		
	$options['end_date'] = $visa_booking['exit_date'];
		
	$options['service_id'] = '';
	
	$options['service_name'] = lang('vietnam_visa');		
		
	$options['description'] = '';
		
	$options['reservation_type'] = RESERVATION_TYPE_VISA;
		
	$options['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' visas' : ' visa');
	
	
	$options['rate'] = 0;

	$options['amount'] = 0;
		
	$options['discount'] = 0;
		
	$options['partner_id'] = 0;
	
	$options['destination_id'] = VIETNAM;
		
	$id = 'sku_vietnam_visa_'.date(DATE_FORMAT_CART_TIMESTAMP);
		
	$visa_item = array(
	               'id'      => $id,
	               'qty'     => 1,
	               'price'   => 1,
	               'name'    => 'notuse',
	               'options' => $options,
				   'is_main_service' => $is_main_service,
				   'normal_discount' =>$normal_discount,
				   'is_discounted' => $is_discounted,
				   'discount' => $discount,
				   'discounted_rowids' => $discounted_rowids,
				   'discount_coefficient' => $discount_coefficient,
				   'v_price'=>$visa_booking['price'],
				   'v_total_price' => $visa_booking['total_price'],
				   'v_nationality' => $visa_booking['nationality'],
				   'v_type_of_visa' => $visa_booking['type_of_visa'],
				   'v_processing_time' => $visa_booking['processing_time'],
				   'v_flight_number' => $visa_booking['flight_number'],
				   'v_arrival_airport' => $visa_booking['arrival_airport'],
				   'v_visa_details'	=> $visa_booking['visa_details'] 
	);

         
    $parent_rowid = $CI->cart->insert($visa_item); 
    
    // insert one visa child price
   	
    $visa_types = $CI->config->item('visa_types');
    
    $rush_services = $CI->config->item('rush_services');
    
    $options = array();
		
	$options['type'] = ITEM_TYPE_CHILD;
		
	$options['parent_rowid'] = $parent_rowid;
		
	$options['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' visas' : ' visa');
		
	$options['rate'] = CURRENCY_SYMBOL.number_format($visa_booking['price'], CURRENCY_DECIMAL);
		
	$options['amount'] = round($visa_booking['total_price'], CURRENCY_DECIMAL);
		
	
	$options['service_id'] = '';
		
	$options['service_name'] = translate_text($visa_types[$visa_booking['type_of_visa']]) . ' - '. translate_text($rush_services[$visa_booking['processing_time']]);
		
	$options['reservation_type'] = RESERVATION_TYPE_NONE;

	$id = 'sku_vietnam_visa_child_'.date(DATE_FORMAT_CART_TIMESTAMP);
		
	$item = array(
	    'id'      => $id,
        'qty'     => 1,
        'price'   => 1,
        'name'    => 'notuse',
        'options' => $options
	);
		
		
			
	$rowid = $CI->cart->insert($item);
			
	
	return $parent_rowid;
	
}

function get_visa_booking_from_cart($rowid){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$item = get_booking_item($rowid);
	
	if ($item == FALSE) return FALSE;
	
	$visa_booking = array();
	
	$visa_booking['price'] = $item['v_price'];
	
	$visa_booking['total_price'] = $item['v_total_price'];
	
	$visa_booking['discount'] = $item['normal_discount'];
	
	$visa_booking['total_discount'] = $item['discount'];
	
	$visa_booking['nationality'] = $item['v_nationality'];
	
	$visa_booking['type_of_visa'] = $item['v_type_of_visa'];
	
	$visa_booking['number_of_visa'] = $item['discount_coefficient'];
	
	
	$visa_booking['processing_time'] = $item['v_processing_time'];
	
	$visa_booking['flight_number'] = $item['v_flight_number'];
	
	$visa_booking['arrival_airport'] = $item['v_arrival_airport'];
	
	$visa_booking['visa_details'] = $item['v_visa_details'];
	
	
	$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array();

	$visa_booking['arrival_date'] = $options['start_date'];
	
	$visa_booking['exit_date'] = $options['end_date'];
	
	$visa_booking['rowid'] = $rowid;
	
	return $visa_booking;
}

function get_first_visa_booking_in_cart(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	
	$carts = $CI->cart->contents();
	
	//echo count($carts);
	
	foreach ($carts as $item){
		
		//echo $item['name'];
		
		$options = $CI->cart->has_options($item['rowid']) ? $CI->cart->product_options($item['rowid']) : array(); 
		
		$type = $options['type'];
		
		if ($type == ITEM_TYPE_MAIN){
			
			$re_type = $options['reservation_type'];
			
			if ($re_type == RESERVATION_TYPE_VISA){
				
				return get_visa_booking_from_cart($item['rowid']);
				
			}
			
		}
	}
	
	return FALSE;
}

function is_allow_online_payment_4_visa_in_shopping_cart(){
	
	$my_booking = get_my_booking();
	
	if (count($my_booking) == 1){
		
		$visa_booking = get_first_visa_booking_in_cart();
		
		if ($visa_booking !== FALSE){
			
			return is_allow_online_payment($visa_booking['arrival_date'], $visa_booking['processing_time']);
			
		}
		
	}
	
	return FALSE;
}

function get_reservations_from_visa_booking($visa_booking){
	
	$CI =& get_instance();
	
	$visa_types = $CI->config->item('visa_types');
    
    $rush_services = $CI->config->item('rush_services');
    
    $airports = $CI->config->item('airports');
    
	
	$customer_booking = array();
	
	$service_reservations = array();
	
	
	$customer_booking['start_date'] = date(DB_DATE_FORMAT, strtotime($visa_booking['arrival_date']));
	
	$customer_booking['end_date'] = date(DB_DATE_FORMAT, strtotime($visa_booking['exit_date']));
	
	$customer_booking['request_date'] = _getCurrentDateTime();
		
	$customer_booking['selling_price'] = $visa_booking['total_price'];
	
	
	
	$service_reservation = array();
			
	$service_reservation['service_id'] = 0;
		
	$service_reservation['service_name'] = lang('vietnam_visa');
		
	$service_reservation['partner_id'] = 0;
	
	$service_reservation['start_date'] = date(DB_DATE_FORMAT, strtotime($visa_booking['arrival_date']));
		
	$service_reservation['end_date'] = date(DB_DATE_FORMAT, strtotime($visa_booking['exit_date']));
	
	$service_reservation['selling_price'] = $visa_booking['total_price']; 
	
	$service_reservation['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' visas' : ' visa');
	
	$service_reservation['reservation_type'] = RESERVATION_TYPE_VISA;
	
	$service_reservation['destination_id'] = VIETNAM;
	
	$service_reservation['type_of_visa'] = $visa_booking['type_of_visa'];
	
	$service_reservation['processing_time'] = $visa_booking['processing_time'];
	
	$service_reservation['visa_users'] = !empty($visa_booking['visa_details']) ? $visa_booking['visa_details']: array();
	
	
	$booking_services = translate_text($visa_types[$visa_booking['type_of_visa']]) . ' - '. translate_text($rush_services[$visa_booking['processing_time']]);	
	 
	$booking_services = $booking_services.': '.$service_reservation['unit'];
	
	$service_reservation['booking_services'] = $booking_services;
	
	
	$service_reservation['description'] = $booking_services.' - '.CURRENCY_SYMBOL. number_format($visa_booking['total_price'], CURRENCY_DECIMAL);

	
	if(!empty($visa_booking['arrival_airport'])){
		
		$service_reservation['description'] = $service_reservation['description']. "\n Arrival Airport: ".translate_text($airports[$visa_booking['arrival_airport']]);
	}
	
	if(!empty($visa_booking['flight_number'])){
		
		$service_reservation['description'] = $service_reservation['description']. "\n Flight Number: ". $visa_booking['flight_number'];
	}
	
	if (empty($service_reservation['visa_users'])){
		
		$service_reservation['description'] = $service_reservation['description']."\n <b>[Skip & Provide Later]</b>";
		
	}
			
	
	$service_reservation['related_service_reservations'] = array();
		
	
	$service_reservations[] = $service_reservation;
	
	$ret['customer_booking'] = $customer_booking;
	
	$ret['service_reservations'] = $service_reservations;
	
	return $ret;
	
}

function get_booking_items_from_visa_booking($visa_booking){
	
	$CI =& get_instance();
	
	$visa_types = $CI->config->item('visa_types');
    
    $rush_services = $CI->config->item('rush_services');
    
	$my_bookings = array();

			
	$booking_item['start_date'] = $visa_booking['arrival_date'];
	
	$booking_item['end_date'] = $visa_booking['exit_date'];
	
	$booking_item['service_id'] = 0;
	
	$booking_item['reservation_type'] = RESERVATION_TYPE_VISA;
	
	$booking_item['partner_id'] = 0;
	
	
	$booking_item['service_name'] = lang('vietnam_visa');
	
	$booking_item['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' visas' : ' visa');
	
	$booking_item['rate'] = 0;
	
	$booking_item['amount'] = 0;
	
	$booking_item['id'] = 'sku_vietnam_visa_'.date(DATE_FORMAT_CART_TIMESTAMP);;
	
	$booking_item['discount'] = 0;
	
	$booking_item['rowid'] = '';
	
	$booking_item['parent_id'] = '';
	
	$booking_item['is_optional_service_selection'] = false;
	
	
	$booking_item['destination_id'] = VIETNAM;
	
	$booking_item['is_free_visa'] = FALSE;
	
	$booking_item['total_price'] = $visa_booking['total_price'];

	$detail_booking_items = array();
		
	
		$detail_booking_item['service_name'] = translate_text($visa_types[$visa_booking['type_of_visa']]) . ' - '. translate_text($rush_services[$visa_booking['processing_time']]);
		
		$detail_booking_item['service_desc'] = '';
		
		$detail_booking_item['service_id'] = '';
		
		$detail_booking_item['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' visas' : ' visa');
		
		
		$detail_booking_item['rate'] = CURRENCY_SYMBOL.number_format($visa_booking['price'], CURRENCY_DECIMAL);
		
		$detail_booking_item['amount'] = round($visa_booking['total_price'], CURRENCY_DECIMAL);
		
		$detail_booking_item['reservation_type'] = RESERVATION_TYPE_NONE;
		
	
	$detail_booking_items[] = $detail_booking_item;
				
	
	$booking_item['detail_booking_items'] = $detail_booking_items;
	
	
	$my_bookings[] = $booking_item;
			
	
	return $my_bookings;
}

function get_hotel_booking_info($hotel){
	
	$booking_info['adults'] = 0;
	
	$booking_info['children'] = 0;
	
	$booking_info['infants'] = 0;
	
	$booking_info['guest'] = '';
	
	$booking_info['rooms'] = 0;
	
	foreach ($hotel['room_types'] as $key => $value) {			
			
		$nr_room = $value['nr_room'];
		
		$nr_extra_bed = $value['nr_extra_bed'];		
		
		if ($nr_room > 0){
		
			$booking_info['adults'] = $booking_info['adults'] + $nr_room * 2;
			
			$booking_info['rooms'] = $booking_info['rooms'] + $nr_room;
			
		}

		if ($nr_extra_bed > 0){
			
			$booking_info['children'] = $booking_info['children'] + $nr_extra_bed;
			
		}
	}
	
	$adults = $booking_info['adults'];
	
	$children = $booking_info['children'];

	$infants = $booking_info['infants'];

	$booking_info['guest'] = generate_traveller_text($adults, $children, $infants);
	
	return $booking_info;
}

function is_free_vietnam_visa($optional_services){
		
	$extra_services = $optional_services['extra_services'];
	
	foreach ($extra_services as $service) {
		
		if($service['optional_service_id'] == 13 && $service['price'] == 0){ //vietnam visal on arrival
			
			return TRUE;
			
		}
		
	}
	
	return false;
}

function get_reservations_from_flight_booking($flight_booking, $search_criteria){
	
	$is_domistic = $search_criteria['is_domistic'];
	
	$customer_booking = array();
	
	$service_reservations = array();
	
	
	$start_end_date = get_start_end_date_of_flight_booking($flight_booking, $search_criteria);
	
	$customer_booking['start_date'] = $start_end_date['start_date'];
	
	$customer_booking['end_date'] = $start_end_date['end_date'];
	
	$customer_booking['request_date'] = _getCurrentDateTime();
		
	$customer_booking['selling_price'] = $flight_booking['prices']['total_price'];
	
	$customer_booking['flight_short_desc'] = get_flight_short_desc_4_cb($search_criteria);
	
	$customer_booking['adults'] = $flight_booking['nr_adults'];
	
	$customer_booking['children'] = $flight_booking['nr_children'];
	
	$customer_booking['infants'] = $flight_booking['nr_infants'];
	
	$flight_booking = set_checked_baggage($flight_booking);
	
	$flight_users['adults'] = $flight_booking['adults'];
	$flight_users['children'] = $flight_booking['children'];
	$flight_users['infants'] = $flight_booking['infants'];
	
	
	$customer_booking['flight_users'] = $flight_users;

	if($is_domistic){ // for domistic flights
		
	$flight_departure = $flight_booking['flight_departure'];
	
	$sr_arr = get_reservation_from_flight_route_info($flight_departure, $flight_booking);
	
	if(!empty($sr_arr)){

		$service_reservations = $sr_arr;
	}	
	
	
	$flight_return = $flight_booking['flight_return'];
	
	$sr_arr = get_reservation_from_flight_route_info($flight_return, $flight_booking);
	
	if(!empty($sr_arr)){

		foreach ($sr_arr as $rs){
			
			$service_reservations[] = $rs;
		}
	}	
	
	$sr_arr = get_reservation_from_baggage_fess($flight_booking, $search_criteria);
	
	if(!empty($sr_arr)){
	
		foreach ($sr_arr as $rs){
				
			$service_reservations[] = $rs;
		}
	}
	
	} else { // for International Flights
	
		$sr_arr = get_reservation_of_international_flights($flight_booking, $search_criteria);
	
		if(!empty($sr_arr)){
	
			$service_reservations = $sr_arr;
		}
	
	}
	
	
	$ret['customer_booking'] = $customer_booking;
	
	$ret['service_reservations'] = $service_reservations;
	
	return $ret;
}

function set_checked_baggage($flight_booking){
	
	$adults = $flight_booking['adults'];
	$children = $flight_booking['children'];
	$infants = $flight_booking['infants'];
	
	foreach ($adults as $key=>$value){
		
		$index = $key + 1;
		
		$value['checked_baggage'] = get_checked_baggage_by_index($flight_booking, $index);
		
		$adults[$key] = $value;
		
	}
	
	foreach ($children as $key=>$value){
	
		$index = $key + 1 + count($adults);
	
		$value['checked_baggage'] = get_checked_baggage_by_index($flight_booking, $index);
	
		$children[$key] = $value;
	
	}
	
	foreach ($infants as $key=>$value){
	
		$index = $key + 1 + count($adults) + count($children);
	
		$value['checked_baggage'] = get_checked_baggage_by_index($flight_booking, $index);
	
		$infants[$key] = $value;
	
	}
	
	$flight_booking['adults'] = $adults;
	$flight_booking['children'] = $children;
	$flight_booking['infants'] = $infants;
	
	return $flight_booking;
	
}

function get_start_end_date_of_flight_booking($flight_booking, $search_criteria){
	
	$start_date = date(DB_DATE_FORMAT, strtotime($search_criteria['Depart']));
	
	$end_date = $start_date;
	
	if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
		
		$end_date = date(DB_DATE_FORMAT, strtotime($search_criteria['Return']));

		if(!empty($flight_booking['flight_return'])){
		
			$flight_return = $flight_booking['flight_return'];
			
			if(!empty($flight_return['detail']) && !empty($flight_return['detail']['routes'])){
				
				$routes = $flight_return['detail']['routes'];
				
				$last_route = $routes[count($routes) - 1];
				
				if(!empty($last_route['to']) && !empty($last_route['to']['date'])){
					
					$end_date = date(DB_DATE_FORMAT, strtotime($last_route['to']['date']));
					
				}
			}
		
		}
		
	} else {
		
		if(!empty($flight_booking['flight_departure'])){
		
			$flight_departure = $flight_booking['flight_departure'];
			
			if(!empty($flight_departure['detail']) && !empty($flight_departure['detail']['routes'])){
				
				$routes = $flight_departure['detail']['routes'];
				
				$last_route = $routes[count($routes) - 1];
				
				if(!empty($last_route['to']) && !empty($last_route['to']['date'])){
					
					$end_date = date(DB_DATE_FORMAT, strtotime($last_route['to']['date']));
					
				}
			}
		
		}
		
	}
	
	
	return array('start_date' => $start_date, 'end_date' => $end_date);
	
}

function get_reservation_from_flight_route_info($flight_route_info, $flight_booking){
	
	if(empty($flight_route_info)) return '';
	
	$ret = array();
	
	$detail = $flight_route_info['detail'];
	
	$class = $flight_route_info['class'];
	
	if(!empty($detail['routes'])){
		
		foreach ($detail['routes'] as $key=>$route){
			
			$flight_classes = explode("-", $class);
			
			$service_reservation = array();
			
			$service_reservation['service_id'] = 0;
				
			$service_reservation['service_name'] = $route['airline'];
			
			if(isset($flight_classes[$key])){
				
				$service_reservation['service_name'] .= ' - Class '.$flight_classes[$key];
				
			}
			
			$service_reservation['service_name'] .= ' - '.$route['from']['city_code'].' -> '.$route['to']['city_code']. ' '.$route['from']['time'].'-'.$route['to']['time'];
				
			$service_reservation['partner_id'] = 0;
			
			$service_reservation['start_date'] = date(DB_DATE_FORMAT, strtotime($route['from']['date']));
				
			$service_reservation['end_date'] = date(DB_DATE_FORMAT, strtotime($route['to']['date']));
			
			$service_reservation['reservation_type'] = RESERVATION_TYPE_FLIGHT;
			
			$service_reservation['destination_id'] = VIETNAM;
			
			
			$service_reservation['airline'] = $flight_route_info['airline'];
			$service_reservation['flight_code'] = $route['airline'];
			$service_reservation['flight_from'] = $route['from']['city_code'];
			$service_reservation['flight_to'] = $route['to']['city_code'];
			$service_reservation['departure_time'] = $route['from']['time'];
			$service_reservation['arrival_time'] = $route['to']['time'];
			
			$service_reservation['fare_rules'] = $detail['fare_rules'];
			if(isset($flight_classes[$key])){				
				$service_reservation['flight_class'] = $flight_classes[$key];				
			}
			
			
			if($key == 0){
				//set the total flight for the first route
				$service_reservation['selling_price'] = $detail['prices']['total_price'];
			} else{
				$service_reservation['selling_price'] = 0;
			} 
			
			$ticket = $flight_booking['nr_adults'] + $flight_booking['nr_children'] + $flight_booking['nr_infants'];
			$service_reservation['unit'] = $ticket.' ticket'.($ticket > 1 ? 's':'');
	
			
			
			$booking_services = get_passenger_text($flight_booking['nr_adults'], $flight_booking['nr_children'], $flight_booking['nr_infants']);
			
			//$booking_services = $booking_services.' - '.$service_reservation['unit'];
			
			
			$service_reservation['booking_services'] = $booking_services;
			
			
			$service_reservation['description'] = $booking_services.' - '.$service_reservation['unit'];
					
			
			$service_reservation['related_service_reservations'] = array();
			
			$ret[] =  $service_reservation;
		}
		
	}
	
	return $ret;
}

function get_reservation_from_baggage_fess($flight_booking, $search_criteria){
	
	$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();
	
	$start_date = date(DB_DATE_FORMAT, strtotime($search_criteria['Depart']));
	
	$end_date = date(DB_DATE_FORMAT, strtotime($search_criteria['Return']));

	$flight_departure = $flight_booking['flight_departure'];//departure_date

	$flight_return = $flight_booking['flight_return'];//return_date

	$ret = array();

	if(!empty($baggage_fees['depart'])){

		foreach ($baggage_fees['depart'] as $key=>$value){
			
			$passenger = get_passenger_by_index($flight_booking, $key);
			
			$pas_name = !empty($passenger) ? $passenger['first_name']. ' '.$passenger['last_name'] : 'Pas.'.$key;
				
			$rs['service_id'] = 0;
				
			$rs['service_name'] = "Baggage Depart (".$flight_departure['airline'].") - ".$pas_name.": ".$value['kg']." Kg";

			$rs['start_date'] = $start_date;
				
			$rs['end_date'] = $start_date;
				
			$rs['reservation_type'] = RESERVATION_TYPE_FLIGHT;
				
			$rs['destination_id'] = VIETNAM;
				
			$rs['selling_price'] = $value['money_usd'];
			
			if(!empty($passenger)){
				$rs['description'] = $passenger['first_name']. ' '.$passenger['last_name'];
			} else {
				$rs['description'] = "Passenger ".$key;
			}
				
			$rs['description'] .= ": ".$value['kg']." Kg - $".number_format($value['money_usd']);
			
			$rs['related_service_reservations'] = array();
				
			$ret[] = $rs;
		}

	}

	if(!empty($baggage_fees['return']) && !empty($flight_return)){
		
		foreach ($baggage_fees['return'] as $key=>$value){
			
			$passenger = get_passenger_by_index($flight_booking, $key);
			
			$pas_name = !empty($passenger) ? $passenger['first_name']. ' '.$passenger['last_name'] : 'Pas.'.$key;
			
			$rs['service_id'] = 0;

			$rs['service_name'] = "Baggage Return (".$flight_return['airline'].") - ".$pas_name.": ".$value['kg']." Kg";

			$rs['start_date'] = $end_date;

			$rs['end_date'] = $end_date;

			$rs['reservation_type'] = RESERVATION_TYPE_FLIGHT;

			$rs['destination_id'] = VIETNAM;

			$rs['selling_price'] = $value['money_usd'];
				
			if(!empty($passenger)){
				$rs['description'] = $passenger['first_name']. ' '.$passenger['last_name'];
			} else {
				$rs['description'] = "Passenger ".$key;
			}
				
			$rs['description'] .= ": ".$value['kg']." Kg - $".number_format($value['money_usd']);
			
			$rs['related_service_reservations'] = array();

			$ret[] = $rs;
		}

	}



	return $ret;
}


/**
 * Get Reservation of International Flights
 * @param unknown $flight_booking
 * @param unknown $search_criteria
 */
function get_reservation_of_international_flights($flight_booking, $search_criteria){

	$ret = array();

	$selected_flight = $flight_booking['selected_flight'];
	
	foreach ($selected_flight['RouteInfo'] as $key => $route){

		$service_reservation = array();

		$service_reservation['service_id'] = 0;

		$service_reservation['service_name'] = $route['Airlines'].'-'.$route['FlightCodeNum'];

		$service_reservation['service_name'] .= ' - Class '.$route['Class'];

		$service_reservation['service_name'] .= ' - '.$route['From'].' -> '.$route['To'];

		$service_reservation['partner_id'] = 0;

		$service_reservation['start_date'] = flight_date($route['DayFrom'], $route['MonthFrom'], DB_DATE_FORMAT);

		$service_reservation['end_date'] = flight_date($route['DayTo'], $route['MonthTo'], DB_DATE_FORMAT);

		$service_reservation['reservation_type'] = RESERVATION_TYPE_FLIGHT;

		$service_reservation['destination_id'] = DESTINATION_VIETNAM;


		$service_reservation['airline'] = $route['Airlines'];
		//$service_reservation['airline_name'] = $route['FlightCode'];
		$service_reservation['flight_code'] = $route['Airlines'].'-'.$route['FlightCodeNum'];
		$service_reservation['flight_from'] = $route['From'];
		$service_reservation['flight_to'] = $route['To'];
		$service_reservation['departure_time'] = flight_time_format($route['TimeFrom']);
		$service_reservation['arrival_time'] = flight_time_format($route['TimeTo']);

		$service_reservation['fare_rules'] = '';

		$service_reservation['flight_class'] = $route['Class'];
	
		/*
		$service_reservation['airport_from'] = $route['AirportFrom'];
		$service_reservation['airport_to'] = $route['AirportTo'];
		$service_reservation['flight_way'] = $route['FlightWay'];
		$service_reservation['flight_type'] = $route['FlightType'];*/
		
		//$service_reservation['fare_rule_short'] = set_fare_rule_short($service_reservation['airline'], $service_reservation['flight_class']);

		if($key == 0){
			//set the total flight for the first route
			$service_reservation['selling_price'] = $flight_booking['prices']['total_price'];
			/*	
			$service_reservation['adt_price'] = $flight_booking['prices']['adult_fare_total'];
			$service_reservation['chd_price'] = isset($flight_booking['prices']['children_fare_total']) ? $flight_booking['prices']['children_fare_total'] : 0;
			$service_reservation['inf_price'] = isset($flight_booking['prices']['infant_fare_total']) ? $flight_booking['prices']['infant_fare_total'] : 0;
			$service_reservation['tax_fee'] = $flight_booking['prices']['total_tax'];
			*/
				
		} else{
				
			$service_reservation['selling_price'] = 0;
		}
		
		$ticket = $flight_booking['nr_adults'] + $flight_booking['nr_children'] + $flight_booking['nr_infants'];
		
		$service_reservation['unit'] = $ticket.' ticket'.($ticket > 1 ? 's':'');

		$booking_services = get_passenger_text($flight_booking['nr_adults'], $flight_booking['nr_children'], $flight_booking['nr_infants']);

		$service_reservation['booking_services'] = $booking_services;

		$service_reservation['description'] = $booking_services.' - '.$service_reservation['unit'];
			
		$service_reservation['related_service_reservations'] = array();

		$ret[] =  $service_reservation;


	}

	return $ret;
}


/**
 * New Version of Inserting Tour Accommodation to Cart
 * 
 * @author Khuyenpv
 * @since 30.03.2015
 */
function insert_tour_acc_to_cart($tour, $acc, $pro, $check_rates, $cabin_arrangements, $cabin_price_cnf, $discount_together, $additional_charges, $parent_id){
	
	$CI =& get_instance();
	$CI->load->library('cart');
	
	
	$is_main_service = $discount_together['is_main_service'];
	
	$normal_discount = $discount_together['normal_discount'];
	
	$discount_coefficient = $discount_together['discount_coefficient'];
	
	$is_discounted = $discount_together['is_discounted'];
	
	$discount = $discount_together['discount'];
	
	$discounted_rowids = $discount_together['discounted_rowids'];
	
	
	$is_free_visa = is_free_visa_tour($tour);
	
	$traveller_text = generate_traveller_text($check_rates['adults'], $check_rates['children'], $check_rates['infants']);
	
	$departure_date = $check_rates['departure_date'];
	$nr_night = $tour['duration'] - 1;
	$end_date = date(DATE_FORMAT_STANDARD, strtotime($departure_date . ' +'.$nr_night.' days'));
	
	
	
	// num_pax for price-index
	$num_pax = calculate_tour_nr_pax($tour, $cabin_arrangements, $cabin_price_cnf, $check_rates);
	
	// add tour service to cart
	
	$options = array();
	
	$options['type'] = ITEM_TYPE_MAIN;
	
	$options['parent_rowid'] ='';
	
	$options['parent_id'] = $parent_id;
	
	$options['start_date'] = $departure_date;
	
	$options['end_date'] = $end_date;
	
	$options['service_id'] = $tour['id'];
	
	$options['service_name'] = $tour['name'];
	
	$options['destination_id'] = $tour['main_destination_id'];
	
	if ($tour['cruise_id'] > 0){
	
		$options['reservation_type'] = RESERVATION_TYPE_CRUISE_TOUR;
	
		$options['cruise_id'] = $tour['cruise_id'];
	
	} else {
			
		$options['reservation_type'] = RESERVATION_TYPE_LAND_TOUR;
	}
	
	$options['unit'] = $traveller_text;
	
	$options['rate'] = 0;
	
	$options['amount'] = 0;
	
	
	$options['pax_booked'] = calculate_tour_nr_pax($tour, $cabin_arrangements, $cabin_price_cnf, $check_rates);
	
	$options['cabin_booked'] = count($cabin_arrangements);
	
	
	$options['partner_id'] = $tour['partner_id'];
	
	$options['duration'] = $tour['duration'];
	
	$id = 'sku_tour_'.$tour['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
	
	
	$tour_item = array(
			'id'      => $id,
			'qty'     => 1,
			'price'   => 1,
			'name'    => 'notuse',
			'options' => $options,
			
			'check_rates' => $check_rates,
			'cabin_arrangements' => $cabin_arrangements,
			'promotion' => $pro,
			
			'is_main_service' => $is_main_service,
			'normal_discount' =>$normal_discount,
			'is_discounted' => $is_discounted,
			'discount' => $discount,
			'discounted_rowids' => $discounted_rowids,
			'discount_coefficient' => $discount_coefficient,
			
			'is_optional_service_selection' => false,
			'is_free_visa' => $is_free_visa
	);
	
	 
	$parent_rowid = $CI->cart->insert($tour_item);
	
	// update discounted status if inserted OK
	if ($parent_rowid){
		 
		update_status_discounted($discounted_rowids, true);
	}
	
	$total_accomodation = 0;
	
	
	// price per cabin tour
	if(is_price_per_cabin($tour)){
		
		// Triple & Family Cabin
		if(is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc)){
			
			$options = array();
			
			$options['type'] = ITEM_TYPE_CHILD;
			
			$options['parent_rowid'] = $parent_rowid;
			
			$options['unit'] = lang('lbl_1_cabin');
			
			
			// price by person
			$price = get_triple_family_cabin_price($acc, $pro, $check_rates);
			
			
			$options['rate'] = show_usd_price($price);
			
			$options['amount'] = round($price, CURRENCY_DECIMAL);
			
			$options['reservation_type'] = RESERVATION_TYPE_NONE;
			
			$name = lang('lbl_cabin_arrangement', 1, $acc['name']).' - '.$traveller_text;
			
			$options['service_id'] = '';
			
			$options['service_name'] = $name;
			
			$id = 'sku_cabin_1_'.date(DATE_FORMAT_CART_TIMESTAMP);
			
			$item = array(
					'id'      => $id,
					'qty'     => 1,
					'price'   => 1,
					'name'    => 'notuse',
					'options' => $options
			);
			
			$rowid = $CI->cart->insert($item);
			
			//echo $rowid.'<br>'; exit();
			
			$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);
			
			
		} else {
			
			// cabin arrangement
			foreach ($cabin_arrangements as $key => $cabin){
					
				$options = array();
	
				$options['type'] = ITEM_TYPE_CHILD;
	
				$options['parent_rowid'] = $parent_rowid;
	
				$options['unit'] = lang('lbl_1_cabin');;
	
				$price = get_cabin_price($acc, $pro, $cabin, $cabin_price_cnf, $num_pax);
	
				$options['rate'] = show_usd_price($price);
	
				$options['amount'] = round($price, CURRENCY_DECIMAL);
	
				$options['reservation_type'] = RESERVATION_TYPE_NONE;
	
				$name = lang('lbl_cabin_arrangement', $key, $acc['name']).' '.$cabin['arrangement_text'];
	
				$options['service_id'] = '';
	
				$options['service_name'] = $name;
	
				$id = 'sku_cabin_'.$key.'_'.date(DATE_FORMAT_CART_TIMESTAMP);
	
				$item = array(
						'id'      => $id,
						'qty'     => 1,
						'price'   => 1,
						'name'    => 'notuse',
						'options' => $options
				);
	
				$rowid = $CI->cart->insert($item);
	
				//echo $rowid.'<br>'; exit();
	
				$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);
			}
	
		}
	
	} else {
	
		// Tour that calculate price per cabin
	
		$options = array();
	
		$options['type'] = ITEM_TYPE_CHILD;
	
		$options['parent_rowid'] = $parent_rowid;
	
		$options['unit'] = $traveller_text;

		$price = get_total_tour_acc_price($tour, $acc, $pro, $cabin_arrangements, $cabin_price_cnf, $num_pax, $check_rates, $discount);
	
	
		$options['rate'] = show_usd_price($price);
	
		$options['amount'] = round($price, CURRENCY_DECIMAL);
	
		$options['reservation_type'] = RESERVATION_TYPE_NONE;
	
		$options['service_id'] = $acc['id'];
	
		$options['service_name'] = $acc['name'];
	
		$id = 'sku_accommodation_'.$acc['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
	
		$item = array(
				'id'      => $id,
				'qty'     => 1,
				'price'   => 1,
				'name'    => 'notuse',
				'options' => $options
		);
			
		$rowid = $CI->cart->insert($item);
	
		$total_accomodation = $total_accomodation + round($price, CURRENCY_DECIMAL);
	
	}
	
	// if the tour is marked as No-VAT then insert an VAT item to the shopping cart
	if(is_tour_no_vat($tour['id'])){
	
		$vat_value = $total_accomodation * 0.1;
	
		// 10% VAT
	
		$options = array();
	
		$options['type'] = ITEM_TYPE_CHILD;
	
		$options['parent_rowid'] = $parent_rowid;
	
		$options['unit'] = '10% VAT';
	
		$options['rate'] = show_usd_price($vat_value);
	
		$options['amount'] = round($vat_value, CURRENCY_DECIMAL);
	
		$options['reservation_type'] = RESERVATION_TYPE_NONE;
	
		$options['service_id'] = '';
	
		$options['service_name'] = lang('cart_vat_item');
	
		$id = 'sku_vat_'.date(DATE_FORMAT_CART_TIMESTAMP);
	
		$item = array(
				'id'      => $id,
				'qty'     => 1,
				'price'   => 1,
				'name'    => 'notuse',
				'options' => $options
		);
			
		$rowid = $CI->cart->insert($item);
	
		$total_accomodation = $total_accomodation + round($vat_value, CURRENCY_DECIMAL);
	
	}
	
	if(!empty($additional_charges)){
	
		$num_pax = $check_rates['adults'] + $check_rates['children'];
	
		foreach ($additional_charges as $charge){
				
			$options = array();
	
			$options['type'] = ITEM_TYPE_CHILD;
				
			$options['parent_rowid'] = $parent_rowid;
				
			if ($charge['charge_type'] == 1){
	
				$options['unit'] = $num_pax. ' pax';
					
			} else {
	
				$options['unit'] = '1';
			}
				
			if ($charge['charge_type'] != -1){
	
				$options['rate'] = show_usd_price($charge['price']);
	
			} else {
	
				$options['rate'] = $charge['price'].'%';
	
			}
				
			$options['amount'] = round(get_total_charge($charge, $total_accomodation, $num_pax), CURRENCY_DECIMAL);
				
			$options['reservation_type'] = RESERVATION_TYPE_ADDITONAL_CHARGE;
				
			$options['service_id'] = $charge['optional_service_id'];
				
			$options['service_name'] = $charge['name'];
				
			$options['service_desc'] = $charge['description'];
				
			$id = 'sku_optional_'.$charge['optional_service_id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
				
			$item = array(
					'id'      => $id,
					'qty'     => 1,
					'price'   => 1,
					'name'    => 'notuse',
					'options' => $options
			);
				
			$rowid = $CI->cart->insert($item);
		}
	
	}
	
	return $parent_rowid;

}

/**
 * New version of Insert Hotel Booking to Cart
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function insert_hotel_room_to_cart($hotel, $room_types, $start_date, $end_date, $check_rates, $is_free_visa, $discount_together, $parent_id){

	$CI =& get_instance();

	$CI->load->library('cart');

	$normal_discount = $discount_together['normal_discount'];

	$discount_coefficient = $discount_together['discount_coefficient'];

	$is_main_service = $discount_together['is_main_service'];

	$is_discounted = $discount_together['is_discounted'];

	$discount = $discount_together['discount'];

	$discounted_rowids = $discount_together['discounted_rowids'];

	$offer_note = '';
	$offer_name = '';
	$offer_cond = '';
	if (count($room_types) > 0){

		$room_type = $room_types[0];

		if (isset($room_type['price']['hotel_promotion_note'])){
			$offer_note = $room_type['price']['hotel_promotion_note'];
		}

		if (isset($room_type['price']['deal_info'])){
			$deal_info = $room_type['price']['deal_info'];
				
			$offer_name = $deal_info['name'];
				
			$offer_cond = get_promotion_condition_text($deal_info);
		}

	}


	$booking_info = get_hotel_booking_info($hotel);

	$booking_info['nights'] = $check_rates['night_nr'];

	$booking_info['staying_dates'] = !empty($check_rates['staying_dates']) ? $check_rates['staying_dates'] : get_date_arr($start_date, $end_date);

	// add hotel to cart
	$options = array();

	$options['type'] = ITEM_TYPE_MAIN;

	$options['parent_rowid'] ='';

	$options['parent_id'] = $parent_id;

	$options['start_date'] = $start_date;

	$options['end_date'] = $end_date;

	$options['service_id'] = $hotel['id'];

	$options['service_name'] = $hotel['name'];

	$options['description'] = '';

	$options['reservation_type'] = RESERVATION_TYPE_HOTEL;

	$options['unit'] = $check_rates['night_nr'].($check_rates['night_nr'] > 1 ? ' nights' : ' night');

	$options['rate'] = 0;

	$options['amount'] = 0;

	$options['discount'] = 0;

	$options['partner_id'] = $hotel['partner_id'];

	$options['destination_id'] = $hotel['destination_id'];

	$id = 'sku_hotel_'.$hotel['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);

	$hotel_item = array(
			'id'      => $id,
			'qty'     => 1,
			'price'   => 1,
			'name'    => 'notuse',
			'options' => $options,
			'booking_info' =>$booking_info,
			'is_main_service' => $is_main_service,
			'normal_discount' =>$normal_discount,
			'is_discounted' => $is_discounted,
			'discount' => $discount,
			'discounted_rowids' => $discounted_rowids,
			'offer_note' => $offer_note,
			'offer_cond' => $offer_cond,
			'offer_name' => $offer_name,
			'is_optional_service_selection' => false,
			'discount_coefficient' => $discount_coefficient,
			'is_free_visa' => $is_free_visa
	);

	 
	$parent_rowid = $CI->cart->insert($hotel_item);


	// update discounted status if inserted OK
	if ($parent_rowid){
		 
		update_status_discounted($discounted_rowids, true);
	}

	$total_accomodation = 0;

	foreach ($room_types as $key => $value) {
			
		$nr_room = $value['nr_room'];

		$nr_extra_bed = $value['nr_extra_bed'];

		$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'];

		if ($nr_room > 0){

			$options = array();

			$options['type'] = ITEM_TYPE_CHILD;
				
			$options['parent_rowid'] = $parent_rowid;
				
			$options['unit'] = $nr_room.($nr_room > 1 ? ' rooms' : ' room');

			if ($nr_extra_bed > 0){
				$options['unit'] = $options['unit']. ' + '.$nr_extra_bed.' extra-bed';
			}
				
			$options['rate'] = CURRENCY_SYMBOL.number_format($value['price']['promotion_price'], CURRENCY_DECIMAL);
				
			$options['amount'] = round($total_promotion_price, CURRENCY_DECIMAL);
				
			$options['service_id'] = $value['id'];
				
			$options['service_name'] = $value['name'];
				
			$options['reservation_type'] = RESERVATION_TYPE_NONE;

			$id = 'sku_room_'.$value['id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
				
			$item = array(
					'id'      => $id,
					'qty'     => 1,
					'price'   => 1,
					'name'    => 'notuse',
					'options' => $options
			);
				
				

			$rowid = $CI->cart->insert($item);
				
		}

		$total_accomodation = $total_accomodation + $total_promotion_price;
	}

	$additional_charges = $CI->HotelModel->get_hotel_additional_charge($hotel['id'], $booking_info['staying_dates'], $booking_info['rooms'], $booking_info['adults'], $booking_info['children']);

	if(count($additional_charges) > 0){

		$num_pax = $booking_info['adults'] + $booking_info['children'];

		foreach ($additional_charges as $charge){
				
			$options = array();

			$options['type'] = ITEM_TYPE_CHILD;
				
			$options['parent_rowid'] = $parent_rowid;
				
			if ($charge['charge_type'] == 1){

				$options['unit'] = $num_pax. ' pax';
					
			} elseif($charge['charge_type'] == 2){

				$rn = $booking_info['rooms'] * isset($charge['night_apply']) ? $charge['night_apply'] : count($booking_info['staying_dates']);

				$options['unit'] = $rn. ' room.night'. ($rn > 1 ? 's':'');

			} else {
				$options['unit'] = '1';
			}
				
			if ($charge['charge_type'] == -1){

				$options['rate'] = $charge['price'].'%';

			} else { // per pax or per room.night

				$options['rate'] = CURRENCY_SYMBOL. number_format($charge['price'], CURRENCY_DECIMAL);

			}
				
			if ($charge['charge_type'] == 2){ // per room.night
					
				$options['amount'] = $charge['price_total'];
					
			} else {

				$options['amount'] = round(get_total_charge($charge, $total_accomodation, $num_pax), CURRENCY_DECIMAL);
			}
				
			$options['reservation_type'] = RESERVATION_TYPE_ADDITONAL_CHARGE;
				
			$options['service_id'] = $charge['optional_service_id'];
				
			$options['service_name'] = $charge['name'];
				
			$options['service_desc'] = $charge['description'];
				
			$id = 'sku_optional_'.$charge['optional_service_id'].'_'.date(DATE_FORMAT_CART_TIMESTAMP);
				
			$item = array(
					'id'      => $id,
					'qty'     => 1,
					'price'   => 1,
					'name'    => 'notuse',
					'options' => $options
			);
				
			$rowid = $CI->cart->insert($item);
		}

	}

	return $parent_rowid;

}

?>