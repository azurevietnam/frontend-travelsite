<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BookingModel extends CI_Model {	

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
        
		$this->load->database();

		$this->load->model(array('TourModel','HotelModel'));
		
		$this->load->driver('cache', array('adapter' => 'file'));
	}
	
	/**
	 * 
	 * Return list of ordered Destination Services
	 * Each Destination contains 3 items (3: configuration in config file)
	 * Each items conatain: name, price from, discount for booking together
	 * 
	 */
	function get_recommendations($current_item_info, $date){
		
		$specific_ds_discounts = array();
		
		$specific_ds_discounts = $this->get_special_discounts($current_item_info, $date);
		
		$results = $this->get_ds_recommendations($current_item_info['destination_id'], $current_item_info['service_type']);
		
		foreach ($results as $key=>$value){
			
			$value['name'] = get_service_name($value['name'], $value['service_id']);
			
			$is_main_service = $this->is_main_service($value['destination_id'], $value['service_id']);

			$specific_discount = get_specific_ds_dc_by_id($value['id'], $specific_ds_discounts);
			
			$specific_discount_service_ids = $specific_discount !== FALSE ? $specific_discount['service_ids'] : '';
			
			$specific_discount_services = $specific_discount !== FALSE ? $specific_discount['services'] : array();
			
			if ($value['service_id'] == HOTEL){
				
				$value['services'] = $this->get_hotel_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
				
			} elseif($value['service_id'] == TOUR) {

				$value['services'] = $this->get_tour_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
				
			} elseif($value['service_id'] == CRUISE){
				
				$value['services'] = $this->get_cruise_tour_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
			}
		
			$value['services'] = merge_service_array($specific_discount_services, $value['services']);
			
			$results[$key] = $value;
		}
		
		return $results;
	
	}
	
	function get_recommendation_of_destination_service($destination_id, $service_id){
		
		$ret = array();
		
		$this->db->select('d.id, d.name, d.url_title as d_url_title, ds_r.service_id, ds_r.id as ds_id');
		
		$this->db->from('recommendations r');
		
		$this->db->join('destination_services ds', 'r.destination_service_id = ds.id');
		
		$this->db->join('destination_services ds_r', 'r.recommend_service_id = ds_r.id');
		
		$this->db->join('destinations d', 'ds_r.destination_id = d.id');
		
		$this->db->where('ds.service_id', $service_id);
		
		$this->db->where('ds.destination_id', $destination_id);
		
		$this->db->order_by('r.order','asc');
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		foreach ($results as $value){
			
			$d['name'] = get_service_name($value['name'], $value['service_id']);
			
			$d['url_title'] = get_service_name($value['name'], $value['service_id'], true);
			
			$d['d_url_title'] = $value['d_url_title'];
			
			$d['service_id'] = $value['service_id'];
			
			$d['destination_id'] = $value['id'];
			
			$d['id'] = $value['ds_id'];
			
			$key = $value['id']."_".$value['service_id'];
			
			$ret[$key] = $d;
		}
		
		return $ret;
	}
	
	
	function get_hotel_recommendation($destination_id, $date, $is_main_service, $specific_discount_service_ids, $current_item_info){
		
		$arrival_date = date(DB_DATE_FORMAT, strtotime($date));
		
		$departure_date = strtotime(date(DB_DATE_FORMAT, strtotime($arrival_date)) . " +1 day");
		
		$departure_date = date(DB_DATE_FORMAT, $departure_date); 
		
		$limit = $this->config->item('recommendation_limit');
		
		if ($specific_discount_service_ids != ''){
			
			$limit = $limit - count($specific_discount_service_ids);
			
			if($limit <= 0) return array();
		}
		
		$this->db->where('destination_id', $destination_id); // hanoi
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		if ($specific_discount_service_ids != ''){
			
			$this->db->where_not_in('id', $specific_discount_service_ids);
		}
		
		//internationalization: khuyenpv 02.04.2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->limit($limit, 0);
		
		$this->db->order_by('deal','desc');
	
		$query = $this->db->get('hotels');
		
		$hotels = $query->result_array();
		
		$hotels = $this->HotelModel->get_hotels_price_optimize($hotels, $arrival_date, $departure_date);
		
		foreach ($hotels as $key => $value) {
			

			$service_id = $value['id'];
			
			$service_type = HOTEL;
			
			$discount_coefficient = 1; // per 1 room.night
			
			$normal_discount = $value['discount'];
			
			
			// the current service is already booked
			if ($current_item_info['is_booked_it']){
				
				$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);

				$value['discount'] = $discount_together['discount'];
				
				$value['is_discounted'] = $discount_together['is_discounted'];
				
			} else {
				
				$value['is_discounted'] = !$is_main_service;
				
			}
			
			
			$value['is_special_discounted'] = false;
			
			
			// set price information for the service
			$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);
			
			$hotels[$key] = $value;
		}
		
		return $hotels;
		
	}
	
	function get_tour_recommendation($destination_id, $date, $is_main_service, $specific_discount_service_ids, $current_item_info){
		
		$limit = $this->config->item('recommendation_limit');
		
		if ($specific_discount_service_ids != ''){
			
			$limit = $limit - count($specific_discount_service_ids);
			
			if($limit <= 0) return array();
		}
		
		$this->db->where('main_destination_id', $destination_id); // hanoi
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		//internationalization: khuyenpv 21/03/2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->where('cruise_id', 0); // normal tour
		
		$this->db->order_by('position', 'asc');
		
		if ($specific_discount_service_ids != ''){
			
			$this->db->where_not_in('id', $specific_discount_service_ids);
		}
		
		$this->db->limit($limit, 0);
		
		$query = $this->db->get('tours');
		
		$tours = $query->result_array();
	
	
		if(!empty($tours)) {
			
			$departure_date = date(DB_DATE_FORMAT, strtotime($date));
			
			//$tours = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
			
			$this->load->model('Tour_Model'); // load the new Tour_Model
				
			// load tour-price-from
			$tours = $this->Tour_Model->get_tour_price_froms($tours, $departure_date);
				
			// load tour-discount
			$tours = $this->Tour_Model->get_tour_normal_discount($tours, $departure_date);
		}
		
		foreach ($tours as $key=>$value){
			
			//$discount_together = get_discount_together($is_main_service, $value['price']['discount']);
			
			$service_id = $value['id'];
			
			$service_type = TOUR;
			
			$discount_coefficient = 1; // per pax
			
			$normal_discount = isset($value['price']['discount']) ? $value['price']['discount'] : 0;
			
			
			// the current service is already booked
			if ($current_item_info['is_booked_it']){
				
				$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
				
				$value['price']['discount'] = $discount_together['discount'];
				
				$value['is_discounted'] = $discount_together['is_discounted'];
				
			} else {
				
				$value['is_discounted'] = !$is_main_service;
				
			}
		
			
			$value['is_special_discounted'] = false;
			
			
			// set price information for the service
			$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);
			
			$tours[$key] = $value;
		}
		
		return $tours;
		
	}
	
	function get_cruise_tour_recommendation($destination_id, $date, $is_main_service, $specific_discount_service_ids, $current_item_info){
		
		$limit = $this->config->item('recommendation_limit');
		
		if ($specific_discount_service_ids != ''){
			
			$limit = $limit - count($specific_discount_service_ids);
			
			if($limit <= 0) return array();
		}
		
		$this->db->where('main_destination_id', $destination_id); // hanoi
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		//internationalization: khuyenpv 21/03/2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->where('cruise_id !=', 0); // normal tour
		
		if ($specific_discount_service_ids != ''){
			
			$this->db->where_not_in('id', $specific_discount_service_ids);
		}
		
		$this->db->order_by('position','asc');
		
		$this->db->limit($limit, 0);
		
		$query = $this->db->get('tours');
		
		$tours = $query->result_array();
	
	
		if(!empty($tours)) {
			
			$departure_date = date(DB_DATE_FORMAT, strtotime($date));
			
			//$tours = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
			
			$this->load->model('Tour_Model'); // load the new Tour_Model
				
			// load tour-price-from
			$tours = $this->Tour_Model->get_tour_price_froms($tours, $departure_date);
				
			// load tour-discount
			$tours = $this->Tour_Model->get_tour_normal_discount($tours, $departure_date);
		}
		
		foreach ($tours as $key=>$value){
			
			$service_id = $value['id'];
			
			$service_type = CRUISE;
			
			$discount_coefficient = 1; // per pax
			
			$normal_discount = isset($value['price']['discount']) ? $value['price']['discount'] : 0;
			
			
			// the current service is already booked
			if ($current_item_info['is_booked_it']){
				
				$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);
				
				$value['price']['discount'] = $discount_together['discount'];
				
				$value['is_discounted'] = $discount_together['is_discounted'];
				
			} else {
				
				$value['is_discounted'] = !$is_main_service;
			}
			
			
			$value['is_special_discounted'] = false;
			
			// set price information for the service
			$value = get_service_discount_price_info($value, $service_type, $is_main_service, $current_item_info);
			
						
			$tours[$key] = $value;
		}
		
		return $tours;
		
	}
	
	function is_main_service($destination_id, $service_id){
		
		$ret = false;
		
		$this->db->where('destination_id', $destination_id);
		
		$this->db->where('service_id', $service_id);
		
		$query = $this->db->get('destination_services');
		
		$destination_services = $query->result_array();
		
		if (count($destination_services) > 0){
			
			$ret = $destination_services[0]['is_main_service'] == 1;
			
		}

		return $ret;
		
	}
	
	function get_hotel_discount($hotel_id, $arrival_date){
		
		$discount = 0;
		
		$arrival_date = $this->timedate->format($arrival_date, DB_DATE_FORMAT);
		
		$this->db->where('hotel_id', $hotel_id);
		
		$p_where = "(start_date <='" . $arrival_date . "'";
		$p_where =  $p_where. " AND (end_date is NULL OR end_date >='" . $arrival_date . "'))";
		
		$this->db->where($p_where);
		
		$query = $this->db->get('hotel_prices');
		
		$prices = $query->result_array();
		
		if (count($prices) > 0){
			
			$price = $prices[0];
			
			$discount = $price['discount'];
			
		}
		
		return $discount;
		
	}
	

	
	/**
	 * 
	 * GET SPECIAL TOUR DISCOUNT BOOKING TOGETHER
	 * 
	 */
	
	function get_special_discounts($current_item_info, $date){
		
		$ds_ids = array();
		
		$service_id = $current_item_info['service_id'];
		
		$service_type = $current_item_info['service_type'];
		
		$destination_id = $current_item_info['destination_id'];
		
		$discounts = $this->get_discounts($service_id, $service_type);
		
		if (count($discounts) > 0){
			
			$ds_ids = get_ds_ids($service_id, $service_type, $discounts);
			
			$ds_res = $this->get_ds_recommendations($destination_id, $service_type);			
			
			$destination_services = $this->get_destination_services($ds_res, $ds_ids);
		
			$destination_services = set_service_ids($destination_services, $service_id, $service_type, $discounts);
			
			foreach ($destination_services as $key => $value){
				
				$is_main_service = $value['is_main_service'] == 1;
				
				if ($value['service_id'] == CRUISE || $value['service_id'] == TOUR){
					
					$value['services'] = $this->get_specific_tour_discounts($value['service_ids'], $date, $service_id, $service_type, $discounts, $is_main_service, $current_item_info);
					
				} elseif($value['service_id'] == HOTEL) {
					
					$value['services'] = $this->get_specific_hotel_discounts($value['service_ids'], $date, $service_id, $service_type, $discounts, $is_main_service, $current_item_info);
					
				} else {
					// no special service for Visa
					$value['services'] = array();
				}
				
				
				
				$value['name'] = get_service_name($value['name'], $value['service_id']);
				
				$destination_services[$key] = $value;
			}
			
			return $destination_services;
		}
		
		return array();
	}
	
	
	function get_discounts($service_id, $service_type){
		
		if ($service_id == '' || $service_type == '') return array();
		
		$str_query = '(service_id_1 = '.$service_id.' AND service_type_1 = '. $service_type .')';
			
		$str_query = $str_query. ' OR (service_id_2 = '.$service_id.' AND service_type_2 = '. $service_type .')';
			
		$this->db->where($str_query);
		
		$this->db->order_by('order_','asc');
			
		$query = $this->db->get('discounts');
			
		$results = $query->result_array();
		
		return $results;
	}
	
	function get_discount_2_services($service_id_1, $service_type_1, $service_id_2, $service_type_2){
		
		$str_query = '(service_id_1 = '.$service_id_1.' AND service_type_1 = '. $service_type_1;
		
		$str_query = $str_query. ' AND service_id_2 = '.$service_id_2.' AND service_type_2 = '. $service_type_2 .')';
			
		$str_query = $str_query. ' OR (service_id_1 = '.$service_id_2.' AND service_type_1 = '. $service_type_2;
		
		$str_query = $str_query. ' AND service_id_2 = '.$service_id_1.' AND service_type_2 = '. $service_type_1 .')';
			
		$this->db->where($str_query);
			
		$query = $this->db->get('discounts');
			
		$results = $query->result_array();
		
		//echo count($results). $service_id_1. '-'. $service_type_1. '-'.$service_id_2.'-'.$service_type_2; exit();
		
		if (count($results) > 0){
			
			return $results[0];
			
		}
		
		return FALSE;
		
	}
	
	function get_ds_recommendations($destination_id, $service_id){
		
		$this->db->select('ds_r.*, d.name, d.url_title');
			
		$this->db->from('recommendations r');
		
		$this->db->join('destination_services ds', 'r.destination_service_id = ds.id');
		
		$this->db->join('destination_services ds_r', 'r.recommend_service_id = ds_r.id');
		
		$this->db->join('destinations d', 'ds_r.destination_id = d.id');
		
		$this->db->where('ds.service_id', $service_id);
		
		$this->db->where('ds.destination_id', $destination_id);
		
		$this->db->order_by('r.order','asc');
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function get_destination_service_by_id($id){
		
		$this->db->select('ds.*, d.name, d.url_title');
		
		$this->db->from('destination_services as ds');
		
		$this->db->join('destinations as d', 'd.id = ds.destination_id');
		
		$this->db->where('ds.id', $id);

		$query = $this->db->get();
		
		$destination_services = $query->result_array();
		
		if (count($destination_services) > 0){ 
			
			$ds = $destination_services[0];
			
			return $ds;
			
		}
		
		return false;
	}
	
	
	
	
	function get_specific_tour_discounts($service_ids, $date, $service_id, $service_type, $discounts, $is_main_service, $current_item_info){
		
		if (count($service_ids) == 0) return array();
		
		$limit = $this->config->item('recommendation_limit');
		
		if ($limit <= 0) return array();
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where_in('id', $service_ids); // normal tour
		
		//internationalization: khuyenpv 02.04.2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->order_by("position"); // new version 2015 => change to position field (khuyenpv 02.04.2015)
		
		$this->db->limit($limit, 0);
		
		$query = $this->db->get('tours');
		
		$tours = $query->result_array();
		
		if(!empty($tours)) {
		    
			$departure_date = date(DB_DATE_FORMAT, strtotime($date));
			
			//$tours = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
			
			$this->load->model('Tour_Model'); // load the new Tour_Model
			
			// load tour-price-from
			$tours = $this->Tour_Model->get_tour_price_froms($tours, $departure_date);
			
			// load tour-discount
			$tours = $this->Tour_Model->get_tour_normal_discount($tours, $departure_date);
		}
		
		foreach ($tours as $key=>$value){
			
			$item_type = $value['cruise_id'] > 0 ? CRUISE : TOUR;
			
			$special_discount = get_discount_value($service_id, $service_type, $discounts, $value['id'], $item_type);
			
			$value['price']['discount'] = !empty($special_discount)? $special_discount['discount'] : 0;
			
			$value['promotion_text'] = !empty($special_discount)? $special_discount['promotion_text'] : '';
				
			$value['is_discounted'] = $item_type == $service_type || (($item_type == CRUISE || $item_type == TOUR) && ($service_type == CRUISE || $service_type == TOUR));
			
			$value['is_discounted'] = $value['is_discounted'] && !$is_main_service;
			
			$value['is_special_discounted'] = true;
			
			$value = get_service_discount_price_info($value, $item_type, $is_main_service, $current_item_info);
			
			$tours[$key] = $value;
		}
		
		$ret = array();
		
		foreach ($service_ids as $id){

			foreach ($tours as $tour){
				
				if ($tour['id'] == $id){
					
					$ret[] = $tour;
				}
				
			}
			
		}
		
		return $ret;
		
	}
	
	function get_specific_hotel_discounts($service_ids, $date, $service_id, $service_type, $discounts, $is_main_service, $current_item_info){
		
		if (count($service_ids) == 0) return array();
		
		$limit = $this->config->item('recommendation_limit');
		
		if ($limit <= 0) return array();
		
		$arrival_date = date(DB_DATE_FORMAT, strtotime($date));
		
		$departure_date = strtotime(date(DB_DATE_FORMAT, strtotime($arrival_date)) . " +1 day");
		
		$departure_date = date(DB_DATE_FORMAT, $departure_date); 
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where_in('id', $service_ids); 
		
		//internationalization: khuyenpv 02.04.2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->limit($limit, 0);
		
		$query = $this->db->get('hotels');
		
		$hotels = $query->result_array();
		
		$hotels = $this->HotelModel->get_hotels_price_optimize($hotels, $arrival_date, $departure_date);
		
		foreach ($hotels as $key => $value) {
		
			
			$special_discount = get_discount_value($service_id, $service_type, $discounts, $value['id'], HOTEL);
			
			$value['discount'] = !empty($special_discount)? $special_discount['discount'] : 0;
			
			$value['promotion_text'] = !empty($special_discount)? $special_discount['promotion_text'] : '';
				
			$value['is_discounted'] = !$is_main_service; 
			
			$value['is_special_discounted'] = true;
			
			$value = get_service_discount_price_info($value, HOTEL, $is_main_service, $current_item_info);
			
			$hotels[$key] = $value;
		}
		
		// order by the order of the special discount list
		$ret = array();
		
		foreach ($service_ids as $id){

			foreach ($hotels as $hotel){
				
				if ($hotel['id'] == $id){
					
					$ret[] = $hotel;
				}
				
			}
			
		}
		
		return $ret;
		
	}

	
	function get_destination_services($ds_res, $ds_ids){
		
		$ret = array();
			
		foreach ($ds_res as $value){
			
			if (in_array($value['id'], $ds_ids)){
				
				$ret[] = $value;
				
			}
			
		}
		
		foreach ($ds_ids as $value){
			
			$is_recommended = false;
			
			foreach ($ds_res as $ds_value){
				
				if ($value == $ds_value['id']){
					
					$is_recommended = true; 
					
					break;
				}
				
			}
			
			if (!$is_recommended){
				
				
				$ret[] = $this->get_destination_service_by_id($value);
				
			}
			
		}
		
		return $ret;
	}
	
	/**
	 * GET Remain recommendations - At the MY BOOKING page
	 */
	
	function get_remaining_recommendations($date){
		
		$ret = array();
		
		$booked_destination_services = get_booked_destination_services();
		
		foreach ($booked_destination_services as $des_service){
			
			$destination_id = $des_service['destination_id'];
			
			$service_id = $des_service['service_id'];
			
			$recommendations = $this->get_recommendation_of_destination_service($destination_id, $service_id);
			
			foreach ($recommendations as $key => $recomend){
				
				//if (!array_key_exists($key, $booked_destination_services)){
				
				if (!isset($booked_destination_services[$key]) && !isset($ret[$key])){
					
					$ret[$key] = $recomend;
				}
				
			}
		}
		
		$my_booking = get_my_booking();
		
		$specific_ds_discounts = array();
		
		$current_item_info['is_booked_it'] = true;
		
		for ($i = count($my_booking) - 1; $i >= 0; $i--) {
			
			$booking_item = $my_booking[$i];
			
			$current_item_info['service_id'] = $booking_item['service_id'];
			
			if ($booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR){
				
				$current_item_info['service_type'] = TOUR;
				
			} elseif ($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR){
				
				$current_item_info['service_type'] = CRUISE;
				
			} elseif ($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL){
				
				$current_item_info['service_type'] = HOTEL;
				
			} else{
				
				$current_item_info['service_type'] = VISA;
			}
			
			$current_item_info['destination_id'] = $booking_item['destination_id'];


			$specific_ds_discounts = $this->get_special_discounts($current_item_info, $date);
			
			
			if (count($specific_ds_discounts) > 0) break;
		}
		
		
		foreach ($ret as $key=>$value){
			
			
			//$value['name'] = get_service_name($value['name'], $value['service_id']);
			
			$is_main_service = $this->is_main_service($value['destination_id'], $value['service_id']);

			$specific_discount = get_specific_ds_dc_by_id($value['id'], $specific_ds_discounts);
			
			$specific_discount_service_ids = $specific_discount !== FALSE ? $specific_discount['service_ids'] : '';
			
			$specific_discount_services = $specific_discount !== FALSE ? $specific_discount['services'] : array();
			
			if ($value['service_id'] == HOTEL){
				
				$value['services'] = $this->get_hotel_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
				
			} elseif($value['service_id'] == TOUR) {

				$value['services'] = $this->get_tour_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
				
			} elseif($value['service_id'] == CRUISE){
				
				$value['services'] = $this->get_cruise_tour_recommendation($value['destination_id'], $date, $is_main_service, $specific_discount_service_ids, $current_item_info);
			}
			
			$value['services'] = merge_service_array($specific_discount_services, $value['services']);
			
			$ret[$key] = $value;
			
		}
		
		
		return $ret;
		
	}
	
	/*
	 * Get the the service has the bigest discount
	 */
	function get_most_recommended_service($service_id, $service_type, $date){
		
		$max_discount = 0;
		
		$reccommeded_dc = '';
		
		$discounts = $this->get_discounts($service_id, $service_type);
		/*
		foreach ($discounts as $value){
			
			if ($value['discount'] > $max_discount){
				
				$max_discount = $value['discount'];
				
				$reccommeded_dc = $value;
				
			}
			
		}*/
		
		if(count($discounts) > 0){
			$reccommeded_dc = $discounts[0]; 
		}
		
		
		if ($reccommeded_dc != ''){
			
			if ($reccommeded_dc['service_id_1'] == $service_id && $reccommeded_dc['service_type_1'] == $service_type){
				
				$rec_service_id = $reccommeded_dc['service_id_2'];
				
				$rec_service_type = $reccommeded_dc['service_type_2'];
				
			} else {
				
				$rec_service_id = $reccommeded_dc['service_id_1'];
				
				$rec_service_type = $reccommeded_dc['service_type_1'];
					
			}
			
			if($rec_service_type == HOTEL){
				
				$service = $this->get_most_recommended_hotel($rec_service_id, $date, $reccommeded_dc['discount']);
				
			} else {
				
				$service = $this->get_most_recommended_tour($rec_service_id, $date, $reccommeded_dc['discount']);
			}
			
			$service['promotion_text'] = $reccommeded_dc['promotion_text'];
			
			return $service;
			
		}
		
		return FALSE;
	}
	
	
	/**
	 * Get the most recommended hotel of a Tour (in the searching list)
	 * 
	 */
	function get_most_recommended_hotel($hotel_id, $date, $discount){
		
		$this->db->select('id, name, url_title, location, description, star, picture, total_score, review_number, is_new');
		
		$this->db->where('id', $hotel_id);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('hotels');
		
		$hotels = $query->result_array();
		
		if (count($hotels) > 0){
			
			$arrival_date = date(DB_DATE_FORMAT, strtotime($date));
		
			$departure_date = strtotime(date(DB_DATE_FORMAT, strtotime($arrival_date)) . " +1 day");
			
			$departure_date = date(DB_DATE_FORMAT, $departure_date); 
		
			$hotels = $this->HotelModel->get_hotels_price_optimize($hotels, $arrival_date, $departure_date);
			
			$service = $hotels[0];
			
			$service['service_type'] = HOTEL;			
			
			$service['discount'] = $discount;
			
			$service['price_separatly'] = $service['promotion_price'];
			
			return $service;
			
		}
		
		return FALSE;
		
	}
	
	
	/**
	 * Get the most recommended hotel of a Tour (in the searching list)
	 * 
	 */
	function get_most_recommended_tour($tour_id, $date, $discount){
		
		$this->db->select('id, name, url_title, route, brief_description, picture_name, review_number, total_score, cruise_id');
		
		$this->db->where('id', $tour_id);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('tours');
		
		$tours = $query->result_array();

		
		if (count($tours) > 0){
			
			$departure_date = date(DB_DATE_FORMAT, strtotime($date));
			
			$tours = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
			
			$service = $tours[0];
			
			
			$service['service_type'] = $service['cruise_id'] > 0 ? CRUISE : TOUR;			
			
			$service['discount'] = $discount;
			
			
			$price_view = get_tour_price_view($service, false);		
						
			$service['price_separatly'] = $price_view['f_price'];
			
			
			return $service;
			
		}
		
		return FALSE;
		
	}
	
	/**
	 * GET Recommendation For Vietnam Visas
	 */
	
	function get_vietnam_visa_recommendations($date, $min_visa_discount){
		
		$recommendations = $this->get_recommendation_of_destination_service(VIETNAM, VISA);
		
		$specific_ds_discounts = array();
		
		$current_item_info['service_type'] = VISA;
		
		$current_item_info['is_booked_it'] = false;
		
		$current_item_info['is_main_service'] = false;
		
		$current_item_info['service_id'] = 0; // no service_id for Vietnam Visa
		
		$current_item_info['destination_id'] = VIETNAM;

		$current_item_info['normal_discount'] = $min_visa_discount;	
		
		foreach ($recommendations as $key=>$value){
			
			$is_main_service = $this->is_main_service($value['destination_id'], $value['service_id']);

			if ($value['service_id'] == HOTEL){
				
				$value['services'] = $this->get_hotel_recommendation($value['destination_id'], $date, $is_main_service, '', $current_item_info);
				
			} elseif($value['service_id'] == TOUR) {

				$value['services'] = $this->get_tour_recommendation($value['destination_id'], $date, $is_main_service, '', $current_item_info);
				
			} elseif($value['service_id'] == CRUISE){
				
				//if ($value['destination_id'] == HALONG_BAY && !check_prevent_promotion()){
				// update on 13/2/2015: free visa for cruise tour
				if (!check_prevent_promotion()){
					$current_item_info['normal_discount'] = -1; // -1 mean free visa -> display on the view
				} else {
					$current_item_info['normal_discount'] = $min_visa_discount;
				}
				
				$value['services'] = $this->get_cruise_tour_recommendation($value['destination_id'], $date, $is_main_service, '', $current_item_info);
			}
			
			$recommendations[$key] = $value;
			
		}
		
		
		return $recommendations;
		
	}
	
	
}