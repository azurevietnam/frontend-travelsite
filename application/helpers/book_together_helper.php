<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Booking Together Helper
 * @author Khuyenpv
 * @since 16.04.2015
 */

function get_discount_of_tour($tour, $adults, $children, $children_rate){

	$service_id = $tour['id'];

	$service_type = TOUR;

	if ($tour['cruise_id'] > 0){

		$service_type = CRUISE;
	}

	$is_main_service = $this->BookingModel->is_main_service($tour['main_destination_id'], $service_type);

	$discount_coefficient = $adults + ($children * $children_rate / 100);

	$normal_discount = $tour['price']['discount'];

	$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);

	return $discount_together;
}

function get_discount_of_hotel($hotel, $rooms, $hotel_dates){

	$nights = count($hotel_dates);

	$is_main_service = $this->BookingModel->is_main_service($hotel['destination_id'], HOTEL);

	$normal_discount = $this->BookingModel->get_hotel_discount($hotel['id'], $hotel_dates[0]);

	$service_id = $hotel['id'];

	$service_type = HOTEL;

	$discount_coefficient = $rooms * $nights;

	$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
		
	return $discount_together;

}

function reset_discount_together($service_1, $service_2){

	$id_1 = $service_1['id'];
	$type_1 = $service_1['service_type'];
	if ($type_1 == TOUR){
		if ($service_1['cruise_id'] > 0){
			$type_1 = CRUISE;
		}
	}

	$id_2 = $service_2['id'];
	$type_2 = $service_2['service_type'];
	if ($type_2 == TOUR){
		if ($service_2['cruise_id'] > 0){
			$type_2 = CRUISE;
		}
	}

	$specific_discount = get_discount_2_services($id_1, $type_1, $id_2, $type_2);

	$discount_together_1 = $service_1['discount_together'];

	$discount_together_2 = $service_2['discount_together'];

	$ret = array();

	// main service book with normal service
	if ($discount_together_1['is_main_service']){
			
		$discount_together_1['discount'] = 0;
			
		$discount_together_1['is_discounted'] = false;
			
		$discount_together_1['discounted_rowids'] = array();
			


		if ($specific_discount > $discount_together_2['normal_discount']){

			$discount_together_2['discount'] = $specific_discount * $discount_together_2['discount_coefficient'];

		} else {

			$discount_together_2['discount'] = $discount_together_2['normal_discount'] * $discount_together_2['discount_coefficient'];
		}
			
		$discount_together_2['is_discounted'] = true;


			
			
	}

	// normal service book with main service
	if (!$discount_together_1['is_main_service'] && $discount_together_2['is_main_service']){
			
		$discount_together_2['discount'] = 0;
			
		$discount_together_2['is_discounted'] = false;
			
		$discount_together_2['discounted_rowids'] = array();


		if ($specific_discount > $discount_together_1['normal_discount']){
				
			$discount_together_1['discount'] = $specific_discount * $discount_together_1['discount_coefficient'];

		} else {

			$discount_together_1['discount'] = $discount_together_1['normal_discount'] * $discount_together_1['discount_coefficient'];
		}


		$discount_together_1['is_discounted'] = true;

	}

	// 2 normal service book together

	if (!$discount_together_1['is_main_service'] && !$discount_together_2['is_main_service']){
			
		$discount_together_1['discount'] = $discount_together_1['normal_discount'] * $discount_together_1['discount_coefficient'];

		if ($specific_discount > $discount_together_2['normal_discount']){

			$discount_together_2['discount'] = $specific_discount * $discount_together_2['discount_coefficient'];

		} else {

			$discount_together_2['discount'] = $discount_together_2['normal_discount'] * $discount_together_2['discount_coefficient'];
		}
			
		if($discount_together_2['discount'] >= $discount_together_1['discount']){

			$discount_together_1['discount'] = 0;
				
			$discount_together_1['is_discounted'] = false;
				
			$discount_together_1['discounted_rowids'] = array();

		} else {

			$discount_together_2['discount'] = 0;
				
			$discount_together_2['is_discounted'] = false;
				
			$discount_together_2['discounted_rowids'] = array();

		}

	}


	$ret['discount_together_1'] = $discount_together_1;

	$ret['discount_together_2'] = $discount_together_2;



	return $ret;
}


?>