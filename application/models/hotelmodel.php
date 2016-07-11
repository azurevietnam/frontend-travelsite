<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class HotelModel extends CI_Model {

	var $hotel_stars = array();

	var $hotel_nights = array();

	var $hotel_status = array();

	var $top_hotel_number = 8;

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

		$this->load->database();

		$this->load->helper('url');

		$this->load->helper('hotel','common', 'file');

		$this->load->library(array('TimeDate'));

		$this->config->load('hotel_meta');

		$this->hotel_stars = $this->config->item('Hotel_Star');

		$this->hotel_status = $this->config->item('Hotel_Status');

		$this->hotel_nights = $this->config->item('Hotel_Night');

		$this->top_hotel_number = $this->config->item('top_hotel_number');

	}

	/**
	* Set up search criteria for hotel searching from an array data.
	*
	* @access private
	* @param search_criteria	An array of destination search criteria.
	*/
	function _setSearchCriteria($search_criteria = '')
	{

		if ($search_criteria == '')	{

			return;

		}

		foreach ($search_criteria as $key => $value) {

			switch ($key) {

				case 'name':
					if ($value != '' && $value != lang('hotel_name_search_title')){
						$this->db->like('name', $value, 'after');
					}
					break;
				case 'destination_id':
					if ($value != ''){
						$this->db->where($key, $value);
					}
					break;
				case 'hotel_stars':
					if ($value != '' && count($value) > 0){
						$this->db->where_in('star', $value);
					}
					break;
				default :
					// do nothing
					break;
			}

		}

	}

	function get_hotels_by_top_destinations(){

		$this->db->select('id, name, url_title');

		$this->db->from('destinations');

		$this->db->where('is_top_hotel', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->order_by('order_','asc');

		$query = $this->db->get(0, $this->top_hotel_number);

		$destinations = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		//$limit = LIMIT_TOUR_ON_TAB;

// 		$results = $query->result_array();

		$str_query = "";

		foreach ($destinations as $key => $value){

			if ($key > 0){

				$str_query = $str_query. " UNION ";
			}

			$str_query = $str_query . "(SELECT id, name,language_id, url_title, location, description, star, picture, total_score, review_number, is_new, destination_id, number_of_room FROM hotels ".
						 " WHERE destination_id = ". $value['id'].
						 " AND (language_id = 0 OR language_id = ".lang_id().")".
						 " AND status = ". STATUS_ACTIVE.
						 " AND deleted != ". DELETED.
						 " ORDER BY deal desc".
						 " LIMIT ".LIMIT_TOUR_ON_TAB.")";


		}


		$query = $this->db->query($str_query);

		$hotels = $query->result_array();

		foreach ($destinations as $key => $value){

			$des_hotels = array();

			foreach($hotels as $hotel){

				if ($hotel['destination_id'] == $value['id']){

					$hotel['price'] = 0;

					$hotel['promotion_price'] = 0;

					$des_hotels[] = $hotel;
				}

			}

			$value['hotels'] = $des_hotels;

			$destinations[$key] = $value;
		}

		return $destinations;

	}


	function getTopDestinations(){

		$this->db->select('id, name, url_title');

		$this->db->from('destinations');

		$this->db->where('is_top_hotel', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->order_by('order_','asc');

		$query = $this->db->get(0, $this->top_hotel_number);

		$destinations = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		foreach ($destinations as $key => $value) {

			$value['hotels'] = $this->getHotelsByTopDestination($value['id']);

			$destinations[$key] = $value;

		}

		return $destinations;
	}

	function getHotelTopDestinations(){

		$this->db->select('id,name,region,picture_name,url_title, number_hotels, parent_id');

		$this->db->from('destinations');

		$this->db->where('deleted !=', DELETED);

		$this->db->where('is_top_hotel', STATUS_ACTIVE);

		$this->db->order_by('order_','asc');

		$query = $this->db->get();

		$result = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

		return $result;

	}

	function getHotelsByTopDestination($destination_id){

		$this->db->where('destination_id', $destination_id);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->order_by('deal', 'desc');

		$query = $this->db->get('hotels', $this->config->item('max_hotel_best_deal'), 0);

		$results = $query->result_array();

		foreach ($results as $key => $value) {

			//$value = $this->_getPriceFrom($value);

			$value['price'] = 0;

			$value['promotion_price'] = 0;

			$results[$key] = $value;

		}

		return $results;
	}

	function getViewedHotels($ids){

		$ids = array_reverse($ids);

		$ids = array_unique($ids);


		$max_viewed_hotels = $this->config->item('max_viewed_hotels');

		if (count($ids) > $max_viewed_hotels){
			$ids = array_splice($ids, 0, $max_viewed_hotels);
		}

		$this->db->select('id, language_id, name, url_title, star, location');

		$this->db->from('hotels');

		$this->db->where_in('id', $ids);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get();

		$results = $query->result_array();

		$hotels = $this->sortHotelByIds($results, $ids);

		return $hotels;
	}

	function sortHotelByIds($hotels, $ids){
		$ret = array();
		foreach ($ids as $value) {

			foreach ($hotels as $hotel) {

				if ($hotel['id'].'' == $value){
					$ret[] = $hotel;
					break;
				}
			}

		}
		return $ret;
	}

	function _getPriceFrom($hotel, $room_types = ''){

		$current_date = date("d-m-Y");

		$next_date = date("d-m-Y", strtotime(date("d-m-Y") . " +1 day"));

		if ($room_types == ''){

			$room_types = $this->getRoomTypes($hotel['id'], $current_date, $next_date);

		}

		$price = count($room_types) > 0 ? $room_types[0]['price']['price'] : 0;

		$promotion_price = count($room_types) > 0 ? $room_types[0]['price']['promotion_price'] : 0;

		$hotel['discount'] = 0;

		foreach ($room_types as $value) {

			if ($value['price']['promotion_price'] < $promotion_price){

				$promotion_price = $value['price']['promotion_price'];

				$price = $value['price']['price'];

			}

			$hotel['discount'] =  $value['price']['discount'];
		}
		/*
		$hotel['price'] = $price;

		$hotel['promotion_price'] = $promotion_price;
		*/

		$hotel['price'] = update_hotel_price_value_to_net($price);

		$hotel['promotion_price'] = update_hotel_price_value_to_net($promotion_price);;

		return $hotel;
	}

	function getNumHotels($search_criteria = '')
	{
		$this->db->select('h.id');
		$this->db->from('hotels as h');

		$arrival_date = date('d-m-Y');

		if(array_key_exists('arrival_date', $search_criteria)){

			$arrival_date = $search_criteria['arrival_date'];

		}


		if (isset($search_criteria['destination_id']) && $search_criteria['destination_id'] != ''){

			$this->db->where('h.destination_id', $search_criteria['destination_id']);

		} else if (isset($search_criteria['destination']) && $search_criteria['destination'] != ''){

			$this->db->like('h.name', $search_criteria['destination'], 'after');

		}

		if (isset($search_criteria['hotel_stars']) && $search_criteria['hotel_stars'] != '' && count($search_criteria['hotel_stars']) > 0){
			$this->db->where_in('h.star', $search_criteria['hotel_stars']);
		}

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->group_by('h.id');

		$query = $this->db->get();

		$hotels = $query->result_array();

		return count($hotels);
	}

	function getNumHotelsCompare($ids='')
	{
		$this->db->where_in('id', $ids);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		return $this->db->count_all_results('hotels');
	}

	function getListHotelCompare($ids = '', $arrival_date, $departure_date, $sort_by, $num = -1, $offset = 0){

		$this->db->where_in('id', $ids);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		switch ($sort_by) {
			case 'best_deals':
				$this->db->order_by("deal", "desc");
				break;
			case 'stars_5_1':
				$this->db->order_by("star", "desc");
				break;
			case 'stars_1_5':
				$this->db->order_by("star", "asc");
				break;
			case 'review_score':
				$this->db->order_by("total_score", "desc");
				break;
			default :
				// do nothing
				break;
		}

		$this->db->order_by("name", "asc");

		if ($num == -1) { // return all results - no pagination
			$query = $this->db->get('hotels');
		} else {
			$query = $this->db->get('hotels', $num, $offset);
		}

		$hotels = $query->result_array();

		foreach ($hotels as $key => $value) {

			$value['room_types'] = $this->getRoomTypes($value['id'], $arrival_date, $departure_date);

			//$value['max_price'] = $this->_getMaxPrice($value);

			$value = $this->_getPriceFrom($value, $value['room_types']);

			$hotels[$key] = $value;
		}

		if ($sort_by == 'price_low_high'){
			usort($hotels, array($this,"sortAsc"));
		} else if ($sort_by == 'price_high_low'){
			usort($hotels, array($this,"sortDesc"));
		}

		return $hotels;
	}

	function searchHotels($search_criteria = '', $num = -1, $offset = 0)
	{

		$this->db->select('h.id, h.name, h.language_id, h.url_title, h.star, h.is_new, h.number_of_room, h.location, h.description, h.total_score, h.review_number, h.picture');
		$this->db->from('hotels as h');

		$arrival_date = date('d-m-Y');

		if(array_key_exists('arrival_date', $search_criteria)){

			$arrival_date = $search_criteria['arrival_date'];

		}

		//$departure_date = $search_criteria['departure_date'];

		// only get price for 1 night
		$departure_date = date("d-m-Y", strtotime($arrival_date . " +1 day"));


		$pr_where = " AND (hp.start_date <='" . $this->timedate->format($arrival_date, DB_DATE_FORMAT) . "'";
		$pr_where .= " AND (hp.end_date is NULL OR hp.end_date >='" . $this->timedate->format($arrival_date, DB_DATE_FORMAT) . "'))";
		$pr_where .= " AND hp.deleted != ".DELETED;
		$pr_where .= " AND (h.language_id = 0 OR h.language_id = ".lang_id().")";

		$this->db->join('hotel_prices as hp', 'h.id = hp.hotel_id'.$pr_where,'left outer');


		if (isset($search_criteria['destination_id']) && $search_criteria['destination_id'] != ''){

			$this->db->where('h.destination_id', $search_criteria['destination_id']);

		} else if (isset($search_criteria['destination']) && $search_criteria['destination'] != ''){

			$this->db->like('h.name', $search_criteria['destination'], 'after');

		}

		if (isset($search_criteria['hotel_stars']) && $search_criteria['hotel_stars'] != '' && count($search_criteria['hotel_stars']) > 0){
			$this->db->where_in('h.star', $search_criteria['hotel_stars']);
		}

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		switch ($search_criteria['sort_by']) {
			case 'best_deals':
				$this->db->order_by("h.deal", "desc");
				break;
			case 'stars_5_1':
				$this->db->order_by("h.star", "desc");
				break;
			case 'stars_1_5':
				$this->db->order_by("h.star", "asc");
				break;
			case 'review_score':
				$this->db->order_by("h.total_score", "desc");
				break;
			case 'price_low_high':
				$this->db->order_by("hp.price_from", "asc");
				break;
			case 'price_high_low':
				$this->db->order_by("hp.price_from", "desc");
			default :
				// do nothing
				break;
		}

		$this->db->order_by("h.name", "asc");

		if ($num == -1) { // return all results - no pagination
			$query = $this->db->get();
		} else {
			$this->db->limit($num, $offset);
			$query = $this->db->get();
		}

		$hotels = $query->result_array();

		// get price from (01/02/2013)
		$hotels = $this->get_hotels_price_optimize($hotels, $arrival_date, $departure_date);



		if ($search_criteria['sort_by'] == 'price_low_high'){
			usort($hotels, array($this,"sortAsc"));
		} else if ($search_criteria['sort_by'] == 'price_high_low'){
			usort($hotels, array($this,"sortDesc"));
		}

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'hotels');
		$table_cnf[] = array('col_id_name'=>'hotel_id', 'table_name'=>'hotel_prices');

		$colum_cnf[] = array('hotels', 'name','url_title','location','description');

		return $hotels;
	}

	function getHotelsByDestination($destination_id){

		$this->db->select('id, name, language_id, url_title, star, location, description, number_of_room, picture, is_new, total_score, review_number');

		$this->db->where('destination_id', $destination_id);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->where('deleted !=', DELETED);

		$this->db->order_by("deal", "desc");

		$this->db->limit($this->config->item('per_page'));

		$query = $this->db->get('hotels');

		$hotels = $query->result_array();

		return $hotels;
	}

	function sortAsc($p1, $p2){
		if($p1['promotion_price'] == $p2['promotion_price']) {
			return 0;
		}
		return ($p1['promotion_price'] < $p2['promotion_price']) ? -1 : 1;
	}

	function sortDesc($p1, $p2){
		if($p1['promotion_price'] == $p2['promotion_price']) {
			return 0;
		}
		return ($p1['promotion_price'] < $p2['promotion_price']) ? 1: -1;
	}

	function _getMaxPrice($hotel){

		$ret = 0;

		if (count($hotel['room_types']) > 0){
			foreach ($hotel['room_types'] as $value) {
				if ($value['price']['price'] > $ret){
					$ret = $value['price']['price'];
				}
			}
		}

		return $ret;
	}

	function getRoomTypes($hotel_id, $arrival_date = '', $departure_date = ''){

		$this->db->from('room_types');

		$this->db->where('hotel_id', $hotel_id);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->order_by('order_', 'asc');

		$query = $this->db->get();

		$results = $query->result_array();

		if ($arrival_date != '' && $departure_date != ''){

			$all_room_type_prices = $this->get_all_room_type_prices($hotel_id, $arrival_date, $departure_date);

			$all_promotion_details = $this->get_all_hotel_promotion_details($hotel_id, $arrival_date, $departure_date);

			foreach ($results as $key => $value) {

				$value['price'] = $this->getRoomTypePrice($value['id'], $arrival_date, $departure_date, $all_room_type_prices, $all_promotion_details);

				$results[$key] = $value;
			}

		}

		return $results;
	}

	function _getDateArr($arrival_date, $departure_date)
	{
		$dateMonthYearArr = array();

		$fromDateTS = strtotime($arrival_date);

		$toDateTS = strtotime($departure_date);

		for ($currentDateTS = $fromDateTS; $currentDateTS < $toDateTS; $currentDateTS += (60 * 60 * 24)) {

			$currentDateStr = date('Ymd',$currentDateTS);

			$dateMonthYearArr[] = $currentDateStr;

		}

		return $dateMonthYearArr;

	}

	function getRoomTypePrice($room_type_id, $arrival_date, $departure_date, $room_type_prices, $promotion_details){

		$ret = array();

		$ret['price'] = 0;

		$ret['extra_bed_price'] = 0;

		$ret['note'] = '';

		$ret['promotion_price'] = 0;

		$ret['promotion_note'] = '';

		$ret['discount'] = 0;

		$first_promotion_detail = '';

		$dates = get_date_arr($arrival_date, $departure_date);

		foreach ($dates as $value) {

			$room_type_price = $this->getRoomTypePriceByDate($room_type_id, $value, $room_type_prices);

			$promotion_detail = $this->getPromotionDetailByDate($room_type_id, $value, $promotion_details);

			if ($room_type_price != ''){

				$ret['price'] = $ret['price'] + $room_type_price['price'];

				$ret['extra_bed_price'] = $ret['extra_bed_price'] + $room_type_price['extra_bed_price'];

				$ret['note'] = $room_type_price['note'];


				$ret['promotion_price'] = $ret['promotion_price'] + $this->calculate_normal_promotion_price($room_type_price['price'], $promotion_detail);

				if ($promotion_detail != '' && $first_promotion_detail == ''){

					$first_promotion_detail = $promotion_detail;

				}

				$ret['discount'] = $room_type_price['discount'];

			} else {

				$ret['price'] = 0;

				$ret['discount'] = 0;

				$ret['extra_bed_price'] = 0;

				$ret['note'] = '';

				$ret['promotion_price'] = 0;

				$ret['promotion_note'] = '';

				return $ret;
			}
		}

		if ($first_promotion_detail != ''){

			$ret['promotion_note'] = $first_promotion_detail['note_detail'];

			$ret['hotel_promotion_note'] = $first_promotion_detail['note'];

			$deal_info['promotion_id'] = $first_promotion_detail['promotion_id'];
			$deal_info['name'] = $first_promotion_detail['name'];
			$deal_info['start_date'] = $first_promotion_detail['start_date'];
			$deal_info['end_date'] = $first_promotion_detail['end_date'];
			$deal_info['expiry_date'] = $first_promotion_detail['expiry_date'];
			$deal_info['is_hot_deals'] = $first_promotion_detail['is_hot_deals'];
			$deal_info['is_specific_dates'] = $first_promotion_detail['is_specific_dates'];
			$deal_info['note'] = $first_promotion_detail['p_note'];
			$deal_info['travel_dates'] = $first_promotion_detail['travel_dates'];

			$deal_info['promotion_type'] = $first_promotion_detail['promotion_type'];
			$deal_info['day_before'] = $first_promotion_detail['day_before'];
			$deal_info['service_type'] = HOTEL;

			$ret['deal_info'] = $deal_info;

		}

		$ret['promotion_price'] = $ret['promotion_price'] + $this->calculate_stay_x_pay_y_promotion_price($room_type_id, $dates, $room_type_prices, $promotion_details);

		return $ret;

	}

	function calculate_normal_promotion_price($normal_price, $promotion_detail){

		// if don't have promotion: promotion_type = normal_price
		if($promotion_detail == ''){

			$promotion_price = $normal_price;

			return $promotion_price;

		}

		// if normal promotion, %off, calculate as normal
		if($promotion_detail['stay'] == 0 && $promotion_detail['pay'] == 0){

			$off = $promotion_detail['offer_rate'];

			$promotion_price =  (1 - $off/100)*$normal_price;

			return $promotion_price;

		}

		// if stay x pay y, don't calculate promotion

		return 0;
	}

	function calculate_stay_x_pay_y_promotion_price($room_type_id, $dates, $room_type_prices, $promotion_details){

		$ret = 0;

		$stay_x_pay_y_promotion_details = array();

		// get array of promotion detail that stay x pay y
		foreach ($dates as $value){

			$promotion_detail = $this->getPromotionDetailByDate($room_type_id, $value, $promotion_details);

			if($promotion_detail != '' && $promotion_detail['stay'] > 0 && $promotion_detail['pay'] > 0){

				$stay_x_pay_y_promotion_details[$promotion_detail['id']] = $promotion_detail;

			}

		}

		// get array of date apply for each promotion detail
		foreach ($stay_x_pay_y_promotion_details as $key=>$pd){

			$date_apply_arr = array();

			foreach ($dates as $value){

				$promotion_detail = $this->getPromotionDetailByDate($room_type_id, $value, $promotion_details);

				if ($promotion_detail != '' && $promotion_detail['id'] == $pd['id']){

					$date_apply_arr[] = $value;
				}

			}

			$pd['date_apply_arr'] = $date_apply_arr;


			$stay_x_pay_y_promotion_details[$key] = $pd;

		}

		// calculate promotion price value

		foreach ($stay_x_pay_y_promotion_details as $key=>$pd){

			$night_free = 0;

			$date_apply_arr = $pd['date_apply_arr'];

			$night_stays = count($date_apply_arr);

			if ($night_stays > 0){

				$stay = $pd['stay'];

				$pay = $pd['pay'];

				if($night_stays >= $stay && $pay <= $stay){

					$night_free = (floor($night_stays/$stay))*($stay - $pay);

				}

				$total_night_pay = 0;

				foreach ($date_apply_arr as $night){

					$room_type_price = $this->getRoomTypePriceByDate($room_type_id, $night, $room_type_prices);

					if ($room_type_price != ''){

						$total_night_pay = $total_night_pay + $room_type_price['price'];

					}

				}

				$total_night_pay = $total_night_pay - ($total_night_pay/$night_stays) * $night_free;

				$ret = $ret + $total_night_pay;

			}
		}

		return $ret;
	}

	function getRoomTypePriceByDate($room_type_id, $date, $room_type_prices){

		$room_type_price = '';

		foreach ($room_type_prices as $value) {

			if ($room_type_id == $value['room_type_id'] && ($date >= $value['start_date']) && ($value['end_date'] == '' || $date <= $value['end_date'])){

				$room_type_price = $value;

				break;
			}

		}

		return $room_type_price;
	}

	function getPromotionDetailByDate($room_type_id, $date, $promotion_details){

		$promotion_detail = '';

		foreach ($promotion_details as $value) {

				$value['start_date'] = date('Y-m-d', strtotime($value['start_date']));

				$value['start_date'] = $value['start_date'] == ''? $value['start_date'] : date('Y-m-d', strtotime($value['start_date']));

				if ($room_type_id == $value['room_type_id'] && ($date >= $value['start_date']) && ($value['end_date'] == '' || $date <= $value['end_date'])){

					if ($value['is_specific_dates'] == 0 || in_array($date, $value['specific_dates'])){

						$promotion_detail = $value;

						break;

					}

				}
		}


		return $promotion_detail;
	}

	function getAllRoomTypePrices($hotel_id, $arrival_date, $departure_date){

		$room_type_prices = array();

		$this->db->where('hotel_id', $hotel_id);

		$query = $this->db->get('hotel_prices');

		$hotel_prices = $query->result_array();

		$arival_date = $this->timedate->format($arrival_date, 'Ymd');

		$departure_date = $this->timedate->format($departure_date, 'Ymd');

		$hotel_price_ids = array();

		$selected_hotel_prices = array();

		foreach ($hotel_prices as $value) {

			$start_date = $this->timedate->format($value['start_date'], 'Ymd');

			$end_date = 0;

			if ($value['end_date'] != NULL && $value['end_date'] != ''){

				$end_date = $this->timedate->format($value['end_date'], 'Ymd');
			}

			if (($departure_date > $start_date) && ($end_date == 0 || $arival_date <= $end_date)){

				$hotel_price_ids[] = $value['id'];

				$selected_hotel_prices[$value['id']] = $value;

			}
		}

		if (count($hotel_price_ids) > 0){

			$this->db->where_in('hotel_price_id', $hotel_price_ids);

			$query = $this->db->get('room_type_prices');

			$room_type_prices = $query->result_array();

			foreach ($room_type_prices as $key => $value) {

				$value['start_date'] = $this->timedate->format($selected_hotel_prices[$value['hotel_price_id']]['start_date'], 'Ymd');

				$value['end_date'] = $selected_hotel_prices[$value['hotel_price_id']]['end_date'];

				if ($value['end_date'] != '' && $value['end_date'] != NULL){

					$value['end_date'] = $this->timedate->format($value['end_date'], 'Ymd');
				} else {
					$value['end_date'] = 0;
				}

				$room_type_prices[$key] = $value;
	 		}

		}

		return $room_type_prices;
	}



	function get_all_room_type_prices($hotel_id, $arrival_date, $departure_date){

		$arrival_date = $this->timedate->format($arrival_date, DB_DATE_FORMAT);

		$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);


		$this->db->select('rtp.*, hp.start_date, hp.end_date, hp.discount');

		$this->db->from('room_type_prices as rtp');

		$this->db->join('hotel_prices as hp', 'hp.id = rtp.hotel_price_id');

		$this->db->where('hp.hotel_id', $hotel_id);

		$this->db->where('hp.deleted !=', DELETED);

		$p_where = "(hp.start_date <='" . $departure_date . "'";
		$p_where =  $p_where. " AND (hp.end_date is NULL OR hp.end_date >='" . $arrival_date . "'))";

		$this->db->where($p_where);

		$query = $this->db->get();

		$prices = $query->result_array();


		return $prices;


	}

	function get_all_hotel_promotion_details($hotel_id, $arrival_date, $departure_date){

		$today = date('Y-m-d');

		$arrival_date = $this->timedate->format($arrival_date, DB_DATE_FORMAT);

		$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

		$this->db->select('pd.id, pd.room_type_id, pd.offer_rate, pd.note_detail, pd.note, pd.stay, pd.pay, p.id as promotion_id, p.is_hot_deals, p.is_specific_dates, p.start_date, p.end_date, p.name, p.book_to as expiry_date, p.promotion_type, p.day_before, p.note as p_note');

		$this->db->from('promotion_details as pd');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('pd.hotel_id', $hotel_id);

		/*
		$p_where = "(p.start_date <='" . $departure_date . "'";
		$p_where = $p_where ." AND (p.end_date is NULL OR p.end_date >='" . $arrival_date . "'))";

		$this->db->where($p_where);

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);
		*/

		$p_where = get_promotion_sql_condition_4_hotel($arrival_date, $departure_date);

		$this->db->where($p_where);

		$this->db->order_by('p.order_', 'ASC');

		$query = $this->db->get();

		$promotions = $query->result_array();

		$promotions = $this->get_travel_dates($promotions);

		return $promotions;
	}


	function get_travel_dates($promotions){

		foreach ($promotions as $key => $promotion){

			$travel_dates = "";

			$promotion['specific_dates'] = array();

			if ($promotion['is_specific_dates'] == 1){

				$specific_dates = array();

				$this->db->where('promotion_id', $promotion['promotion_id']);

				$this->db->order_by('date', 'asc');

				$query = $this->db->get('promotion_dates');

				$dates = $query->result_array();

				foreach ($dates as $pd){

					$specific_dates[] = $pd['date'];

				}

				$promotion['specific_dates'] = $specific_dates;


				$travel_dates = get_travel_specific_dates($dates);

				//echo $travel_dates; exit();

			} else {


			}

			$promotion['travel_dates'] = $travel_dates;

			$promotions[$key] = $promotion;

		}

		return $promotions;

	}


	function get_promotion_dates($promotion_id){

		$dates = array();

		$this->db->where('promotion_id', $promotion_id);

		$this->db->order_by('date', 'asc');

		$query = $this->db->get('promotion_dates');


		$promotion_dates = $query->result_array();

		foreach ($promotion_dates as $pd){

			$dates[] = $pd['date'];

		}

		return $dates;
	}

	function getHotelPromotionPrice($h_promotion_details, $hotel_prices){

		$ret = array();

		//$h_promotion_details = $this->getHotelPromotionDetails($partner_id, $hotel_id, $date);

		foreach ($hotel_prices as $key => $value) {
			if (array_key_exists($key, $h_promotion_details)){

				$discount = $h_promotion_details[$key]['offer_rate'];

				$value['price'] = (1 - $discount/100)*$value['price'];
			}

			$ret[$key] = $value;
		}

		return $ret;
	}

	function getListHotelForSearch(){

		$this->db->select('h.id, h.language_id, h.name, h.star, h.destination_id,  d.name as destination');

		$this->db->from('hotels as h');

		$this->db->join('destinations as d', 'h.destination_id = d.id');

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		$this->db->order_by('h.name', 'asc');

		$query = $this->db->get();

		$results = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'hotels');
		$table_cnf[] = array('col_id_name'=>'destination_id', 'table_name'=>'destinations');

		$colum_cnf[] = array('destinations', 'name', 'destination');

		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;
	}

	function getSearchObjects(){

		$ret = array();

		$this->db->select('d.id, d.name, d.region, dd.name as parent');

		$this->db->from('destinations d');

		$this->db->join('destinations dd', 'd.parent_id = dd.id','left outer');

		$this->db->where('d.deleted !=', DELETED);

		$this->db->where('d.type', 2); // city

		$this->db->where('d.number_hotels >', 0);

		//$this->db->or_where('is_top_hotel', STATUS_ACTIVE);

		$this->db->order_by('d.name','asc');

		$query = $this->db->get();

		$destinations = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		foreach ($destinations as $value){

			$value['star'] = -1;
			$value['object_type'] = -1;
			$ret[] = $value;
		}

		$this->db->select('h.id, h.language_id, h.name, h.star, h.destination_id, d.name as parent');

		$this->db->from('hotels h');

		$this->db->join('destinations d', 'h.destination_id = d.id', 'left');

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		$this->db->order_by('h.name', 'asc');

		$query = $this->db->get();

		$hotels = $query->result_array();

		foreach ($hotels as $value){
			$value['object_type'] = HOTEL;
			$ret[] = $value;
		}

		return $ret;

	}

	function getHotelIdByUrlTitle($url_title){
		$this->db->select('id', 'language_id');
		$this->db->from('hotels');

		$this->db->where('url_title', $url_title);
		$this->db->where('status', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);


		$query = $this->db->get();

		$hotels = $query->result_array();

		if (count($hotels) < 1) {

			$hotels = $this->checkHotelURLHistory($url_title);

			if(empty($hotels)) return '';
		}

		return $hotels[0]['id'];
	}

	function getHotel($hotel_id, $arrival_date, $departure_date, $tab_index = 0){

		$this->db->select('h.*, d.name as destination_name');

		$this->db->from('hotels as h');

		$this->db->join('destinations as d', 'd.id = h.destination_id');

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('h.id', $hotel_id);

		$query = $this->db->get();

		$rerutls = $query->result_array();


		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'hotels');
		$table_cnf[] = array('col_id_name'=>'destination_id', 'table_name'=>'destinations');

		$colum_cnf[] = array('destinations', 'name', 'destination_name');
		$rerutls = update_i18n_data($rerutls, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($rerutls) > 0){
			$hotel = $rerutls[0];
			if ($tab_index == 0 || $tab_index == 2){
				$hotel['photos'] = $this->getHotelPhotos($hotel['id']);
				$hotel['room_types'] = $this->getRoomTypes($hotel['id'], $arrival_date, $departure_date);

				foreach ($hotel['room_types'] as $key => $value) {

					$value['facilities'] = $this->getRoomTypeFacilities($value['id']);

					$hotel['room_types'][$key] = $value;
				}
			}

			return $hotel;

		} else {
			return false;
		}
	}

	function getDestination($id){

		$this->db->from('destinations');

		$this->db->where('id', $id);

		$query = $this->db->get();

		$rerutls = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$rerutls = update_i18n_data($rerutls, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($rerutls) > 0){

			return $rerutls[0];

		} else {
			return false;
		}
	}

	/**
	* Get a destination by url_title
	*
	*/
	function getDestinationByUrlTitle($url_title){
		$this->db->where('url_title', $url_title);
		$this->db->where('deleted !=', DELETED);
		$query = $this->db->get('destinations');

		$dess = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$dess = update_i18n_data($dess, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($dess) > 0) {
			return $dess[0];
		}
		return '';
	}

	function getSystemHotelFacilities(){

		$this->db->select('id, name, hotel_facility_type');

		$this->db->from('facilities');

		$this->db->where('type', 0); // for hotel

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get();

		$result  = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'facilities');
		$result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

		return $result;
	}

	function getSystemRoomTypeFacilities(){

		$this->db->select('id, name');

		$this->db->from('facilities');

		$this->db->where('type', 1); // for room type

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get();

		$result = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'facilities');
		$result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

		return $result;
	}

	function getHotelFacilities($hotel_id){

		$this->db->select('facility_id, value');

		$this->db->from('hotel_facilities');

		$this->db->where('hotel_id', $hotel_id);

		$query = $this->db->get();

		return $query->result_array();

	}

	function getRoomTypeFacilities($room_type_id){

		$this->db->select('f.id, f.name, f.important, hf.value');

		$this->db->from('hotel_facilities as hf');

		$this->db->join('facilities as f', 'hf.facility_id = f.id');

		$this->db->where('hf.room_type_id', $room_type_id);

		$this->db->where('f.status', STATUS_ACTIVE);

		$this->db->where('f.deleted !=', DELETED);

		$this->db->where('hf.value', 1);

		$query = $this->db->get();

		$result = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'facilities');
		$result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

		return $result;
	}

	function getHotelPhotos($hotel_id){

		$this->db->select('id,name,description');

		$this->db->from('hotel_photos');

		$this->db->where('hotel_id', $hotel_id);

		$this->db->order_by('order_','asc');

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
	}

	function book($hotel_booking, $room_type_bookings, $cus) {

		$this->db->where('email', $cus['email']);

		$nr = $this->db->count_all_results('customers');

		$cus_id = 0;

		if ($nr == 0){

			$this->db->insert('customers', $cus);

			$cus_id = $this->db->insert_id();

		} else {

			$this->db->where('email', $cus['email']);

			$this->db->update('customers', $cus);


			$this->db->where('email', $cus['email']);

			$query = $this->db->get('customers');

			$results = $query->result_array();

			$cus_id = $results[0]['id'];

		}
		/*
		// execute insert customer into db
		$this->db->insert('customers', $cus);

		$cus_id = $this->db->insert_id();
		*/

		$hotel_booking['customer_id']	= $cus_id;

		$this->db->insert('hotel_bookings', $hotel_booking);

		$hotel_booking_id = $this->db->insert_id();

		foreach ($room_type_bookings as $value) {
			$value['hotel_booking_id'] = $hotel_booking_id;

			$this->db->insert('room_type_bookings', $value);
		}

		return $hotel_booking_id;
	}

	function get_home_page_hotels(){

		// hanoi hotels
		$query_str = "(SELECT name, language_id, star, picture, destination_id FROM hotels".
				" WHERE status = ". STATUS_ACTIVE.
				" AND deleted != ". DELETED.
				" AND destination_id = 30".
				" AND (language_id = 0 OR language_id = ".lang_id().")".
				" ORDER BY deal DESC".
				" LIMIT 3) UNION".

				// hcm hotels
				" (SELECT name, language_id, star, picture, destination_id FROM hotels".
				" WHERE status = ". STATUS_ACTIVE.
				" AND deleted != ". DELETED.
				" AND destination_id = 14".
				" AND (language_id = 0 OR language_id = ".lang_id().")".
				" ORDER BY deal DESC".
				" LIMIT 3)";

		$query = $this->db->query($query_str);

		$hotels = $query->result_array();

		$hanoi_hotels = array();

		$hcm_hotels = array();

		foreach ($hotels as $hotel){
			if($hotel['destination_id'] == 30) {
				$hanoi_hotels[] = $hotel;
			} else {
				$hcm_hotels[] = $hotel;
			}
		}

		return array('hanoi_hotels'=>$hanoi_hotels,'hcm_hotels'=>$hcm_hotels);
	}

	function get_hotels_by_hot_deals($destination_id = ''){

		$this->db->distinct();

		$today = date('Y-m-d');

		$this->db->select('h.id, h.language_id, h.name, h.url_title, h.picture, h.star, h.is_new, h.total_score, h.review_number, p.start_date, p.end_date, p.book_to, p.is_hot_deals, pd.note');

		$this->db->from('promotion_details as pd');

		$this->db->join('hotels as h', 'h.id = pd.hotel_id');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		if ($destination_id != ''){

			$this->db->where('h.destination_id', $destination_id);

		}


		//$this->db->where('p.is_hot_deals', STATUS_ACTIVE);

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);

		$this->db->order_by('h.deal', 'desc');

		$this->db->order_by('p.order_ asc');

		$query = $this->db->get();

		$hotels = $query->result_array();


		$hotels = get_promotion_hot_deals('id', $hotels);

		return $hotels;
	}

	function get_hotels_by_destination($destination_id, $arrival_date, $stars, $sortBy = '',$offset = 0, $num=5) {

		$this->db->select('h.*');
		$this->db->from('hotels as h');
		$this->db->where('h.deleted !=', DELETED);
		$this->db->where('h.status', STATUS_ACTIVE);
		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		if(is_numeric($destination_id)) {
			$this->db->where('h.destination_id', $destination_id);
		} else {
			$this->db->like('h.name', $destination_id, 'after');
		}

		if(!empty($stars)) {
			$this->db->where_in('h.star', $stars);
		}

		switch ($sortBy) {
			case 'stars_5_1':
				$this->db->order_by("h.star", "desc");
				break;
			case 'stars_1_5':
				$this->db->order_by("h.star", "asc");
				break;
			case 'review_score':
				$this->db->order_by("h.total_score", "desc");
				break;
			default :
				$this->db->order_by('h.deal desc');
				break;
		}
		//$this->db->order_by('name asc');

		//$query = $this->db->get($num, $offset);
		$this->db->limit($num, $offset);
		$query = $this->db->get();

		$hotels = $query->result_array();

		$arrival_date = date("d-m-Y", strtotime($arrival_date));

		$next_date = date("d-m-Y", strtotime($arrival_date . " +1 day"));

		// get price from (01/02/2013)
		$hotels = $this->get_hotels_price_optimize($hotels, $arrival_date, $next_date);

		/* foreach ($hotels as $key => $value) {

			$value['room_types'] = $this->getRoomTypes($value['id'], $arrival_date, $next_date);

			$value = $this->_getPriceFrom($value, $value['room_types']);

			$hotels[$key] = $value;
		} */

		return $hotels;
	}

	function getNumHotelsByDestination($destination_id, $stars)
	{
		if(is_numeric($destination_id)) { // destination id like hanoi, danang, ..etc
			$this->db->where('destination_id', $destination_id);
		} else {
			$this->db->like('name', $destination_id, 'after');
		}

		if(!empty($stars)) {
			$this->db->where_in('star', $stars);
		}

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->where('deleted !=', DELETED);

		return $this->db->count_all_results('hotels');
	}

	function getTopParentDestinations()
	{
		$this->db->select('id,name,region,picture_name,number_tours,url_title,parent_id');
		$this->db->where_in('id', array(VIETNAM, LAOS, CAMBODIA));
		$this->db->order_by('name', 'desc');

		$query = $this->db->get('destinations');

		$result = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

		return $result;
	}

	function get_hotel_by_url_title($url_title, $dates = ''){

		$this->db->select('h.*, d.name as destination_name');

		$this->db->from('hotels as h');

		$this->db->join('destinations as d', 'd.id = h.destination_id');

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('h.url_title', trim($url_title));

		$query = $this->db->get();

		$rerutls = $query->result_array();

		if (count($rerutls) > 0){

			$hotel = $rerutls[0];

			$hotel['room_types'] = $this->get_hotel_rooms($hotel['id'], $dates);

			if ($dates != ''){

				$optional_services = $this->get_hotel_optional_services($hotel['id'], $dates);

				$additional_charges = $this->get_hotel_additional_charge($hotel['id'], $dates);

				$optional_services['additional_charge'] = $additional_charges;

				$hotel['optional_services'] = $optional_services;
			}

			foreach ($hotel['room_types'] as $key => $value) {

				$value['facilities'] = $this->getRoomTypeFacilities($value['id']);

				$hotel['room_types'][$key] = $value;
			}

			return $hotel;
		}

		return FALSE;
	}

	function get_hotel_rooms($hotel_id, $dates){

		$this->db->from('room_types');

		$this->db->where('hotel_id', $hotel_id);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->order_by('order_', 'asc');

		$query = $this->db->get();

		$results = $query->result_array();

		if ($dates != '' && is_array($dates)){

			$arrival_date = $dates[0];

			$departure_date = $dates[count($dates) - 1];

			$all_room_type_prices = $this->get_all_room_type_prices($hotel_id, $arrival_date, $departure_date);

			$all_promotion_details = $this->get_all_hotel_promotion_details($hotel_id, $arrival_date, $departure_date);
			
			foreach ($results as $key => $room){

				$room['price'] = $this->get_room_type_price($room['id'], $dates, $all_room_type_prices, $all_promotion_details);

				$results[$key] = $room;
			}

		}

		return $results;
	}

	function get_room_type_price($room_type_id, $dates, $room_type_prices, $promotion_details){

		$ret = array();

		$ret['price'] = 0;

		$ret['extra_bed_price'] = 0;

		$ret['note'] = '';

		$ret['promotion_price'] = 0;

		$ret['promotion_note'] = '';

		$ret['discount'] = 0;

		$first_promotion_detail = '';

		foreach ($dates as $value) {
			
			$value = date(DB_DATE_FORMAT, strtotime($value));

			$room_type_price = $this->getRoomTypePriceByDate($room_type_id, $value, $room_type_prices);

			$promotion_detail = $this->getPromotionDetailByDate($room_type_id, $value, $promotion_details);

			if ($room_type_price != ''){

				$ret['price'] = $ret['price'] + $room_type_price['price'];

				$ret['extra_bed_price'] = $ret['extra_bed_price'] + $room_type_price['extra_bed_price'];

				$ret['note'] = $room_type_price['note'];


				$ret['promotion_price'] = $ret['promotion_price'] + $this->calculate_normal_promotion_price($room_type_price['price'], $promotion_detail);

				if ($promotion_detail != '' && $first_promotion_detail == ''){

					$first_promotion_detail = $promotion_detail;

				}

				$ret['discount'] = $room_type_price['discount'];

			} else {

				$ret['price'] = 0;

				$ret['discount'] = 0;

				$ret['extra_bed_price'] = 0;

				$ret['note'] = '';

				$ret['promotion_price'] = 0;

				$ret['promotion_note'] = '';

				return $ret;
			}
		}

		if ($first_promotion_detail != ''){

			$ret['promotion_note'] = $first_promotion_detail['note_detail'];

			$ret['hotel_promotion_note'] = $first_promotion_detail['note'];

			$deal_info['promotion_id'] = $first_promotion_detail['promotion_id'];
			$deal_info['name'] = $first_promotion_detail['name'];
			$deal_info['start_date'] = $first_promotion_detail['start_date'];
			$deal_info['end_date'] = $first_promotion_detail['end_date'];
			$deal_info['expiry_date'] = $first_promotion_detail['expiry_date'];
			$deal_info['is_hot_deals'] = $first_promotion_detail['is_hot_deals'];
			$deal_info['is_specific_dates'] = $first_promotion_detail['is_specific_dates'];
			$deal_info['note'] = $first_promotion_detail['p_note'];
			$deal_info['travel_dates'] = $first_promotion_detail['travel_dates'];

			$deal_info['promotion_type'] = $first_promotion_detail['promotion_type'];
			$deal_info['day_before'] = $first_promotion_detail['day_before'];
			$deal_info['service_type'] = HOTEL;

			$ret['deal_info'] = $deal_info;

		}

		$ret['promotion_price'] = $ret['promotion_price'] + $this->calculate_stay_x_pay_y_promotion_price($room_type_id, $dates, $room_type_prices, $promotion_details);

		return $ret;

	}

	function get_hotels_price_optimize($hotels, $arrival_date, $departure_date) {

		if(empty($hotels)) return $hotels;

		$hotel_id = array();
		foreach ($hotels as $hotel) {
			$hotel_id[] = $hotel['id'];
		}

		$this->db->from('hotel_prices');

		$this->db->where_in('hotel_id', $hotel_id);

		$this->db->where('deleted !=', DELETED);

		if (!empty($arrival_date)) {

			$arrival_date = $this->timedate->format($arrival_date, DB_DATE_FORMAT);

			$pr_where = "(start_date <='" . $arrival_date . "'";

			$pr_where .= " AND (end_date is NULL OR end_date >='" . $arrival_date . "'))";

			$this->db->where($pr_where);
		}

		$query = $this->db->get();

		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)
		$prices = update_hotel_price_to_net_price($prices);

		foreach ($hotels as $key => $hotel) {

			$price_from = 0;
			$discount = 0;
			$promotion_price = 0;
			$offer_note = '';
			$deal_info = array();

			foreach ($prices as $price) {
				if($price['hotel_id'] == $hotel['id']) {
					$price_from = $price['price_from'];
					$discount = $price['discount'];

					$offer_rate = 0;

					$offer_note = "";

					if(!empty($price['room_type_id'])) {
						$promotion_details = $this->get_all_hotel_promotion_details($hotel['id'], $arrival_date, $departure_date);
						$promotion_detail = $this->getPromotionDetailByDate($price['room_type_id'], $arrival_date, $promotion_details);

						if(!empty($promotion_detail)){

							$offer_rate = (!empty($promotion_detail['offer_rate'])) ? $promotion_detail['offer_rate'] : 0;

							// reset offer rate to 0 if promotion is stay x pay y
							if ($promotion_detail['stay'] > 0 && $promotion_detail['pay'] > 0){

								$offer_rate = 0;
							}

							$offer_note = $promotion_detail['note'];

							$deal_info['promotion_id'] = $promotion_detail['promotion_id'];
							$deal_info['name'] = $promotion_detail['name'];
							$deal_info['start_date'] = $promotion_detail['start_date'];
							$deal_info['end_date'] = $promotion_detail['end_date'];
							$deal_info['expiry_date'] = $promotion_detail['expiry_date'];
							$deal_info['is_hot_deals'] = $promotion_detail['is_hot_deals'];
							$deal_info['is_specific_dates'] = $promotion_detail['is_specific_dates'];
							$deal_info['note'] = $promotion_detail['p_note'];
							$deal_info['travel_dates'] = $promotion_detail['travel_dates'];

							$deal_info['promotion_type'] = $promotion_detail['promotion_type'];
							$deal_info['day_before'] = $promotion_detail['day_before'];

							$deal_info['service_type'] = HOTEL;

						}
					}

					$promotion_price = (1 - $offer_rate/100)*$price_from;

					break;
				}
			}

			$hotel['price'] = $price_from;
			$hotel['discount'] = $discount;
			$hotel['promotion_price'] = $promotion_price;
			$hotel['offer_note'] = $offer_note;
			$hotel['deal_info'] = $deal_info;


			$hotels[$key] = $hotel;
		}

		return $hotels;
	}

	function get_hotel_overview($hotel_id, $arrival_date, $hotel_name){

		if ($hotel_id == '' && $hotel_name == '') return FALSE;

		$this->db->select('h.id, h.name, h.language_id, h.url_title, h.star, h.location, h.description, h.star, h.number_of_room, h.picture, h.is_new, h.total_score, h.review_number');

		$this->db->from('hotels as h');

		$this->db->where('h.status', STATUS_ACTIVE);

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

		if ($hotel_id != ''){

			$this->db->where('h.id', $hotel_id);

		} else {

			$this->db->where('h.url_title', $hotel_name);
		}

		$query = $this->db->get();

		$rerutls = $query->result_array();

		if(count($rerutls) > 0){

			$arrival_date = date("d-m-Y", strtotime($arrival_date));

			$next_date = date("d-m-Y", strtotime($arrival_date . " +1 day"));

			$hotels = $this->get_hotels_price_optimize($rerutls, $arrival_date, $next_date);

			$hotel = $hotels[0];

			$hotel['photos'] = $this->getHotelPhotos($hotel['id']);


			// get room_types

			$this->db->select('id, name, description, picture, extra_bed_allow, max_person, max_room, room_size, bed_size');

			$this->db->from('room_types');

			$this->db->where('hotel_id', $hotel['id']);

			$this->db->where('deleted !=', DELETED);

			$this->db->where('status', STATUS_ACTIVE);

			$this->db->order_by('order_', 'asc');

			$query = $this->db->get();

			$room_types = $query->result_array();

			$hotel['room_types'] = $room_types;

			return $hotel;
		}

		return FALSE;
	}

	// check hotel name history

	function checkHotelURLHistory($url_title) {

		$this->db->select('id, language_id, url_title_history');
		$this->db->from('hotels');

		$this->db->like('url_title_history', $url_title);
		$this->db->where('deleted !=', DELETED);
		$this->db->where('status', STATUS_ACTIVE);
		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$query = $this->db->get();

		$hotels = $query->result_array();

		foreach ($hotels as $hotel) {
			$url_title_history = $hotel['url_title_history'];

			$arr_name = explode(',', $url_title_history);
			foreach ($arr_name as $str_name) {
				if($str_name == $url_title) {

					$crs = array();
					$crs[] = $hotel;
					return $crs;
				}
			}
		}

		//$str = $this->db->last_query();

		return null;
	}

	/*
	 * getSimilarsHotels
	 * 	by:	- destionation
	 * 		- star
	 */
	function getSimilarsHotels($hotel){

		$this->db->select('id, name, language_id, url_title, star, location, description, number_of_room, picture, is_new, total_score, review_number');

		$this->db->where('destination_id', $hotel['destination_id']);

		$this->db->where('star', $hotel['star']);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('id !=', $hotel['id']);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->order_by("deal", "desc");

		$this->db->limit(4);

		$query = $this->db->get('hotels');

		$hotels = $query->result_array();

		return $hotels;
	}

	function get_hotel_hot_deal_info($hotel_id, $url_title){

		/**
		 *
		 *  Delete cache database element
		 *  TinVM 6.11.2014
		 *
		 */
// 		$cache_time = $this->config->item('cache_hot_deal_time');

// 		$cache_file_id = 'hot_deals_'.$url_title;

// 		if ( ! $results = $this->cache->get($cache_file_id))
// 		{

// 			$today = date('Y-m-d');

// 			$this->db->distinct();

// 			$this->db->select('h.id,h.language_id, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note,p.apply_for_hanoi,p.promotion_type, p.day_before');

// 			$this->db->from('promotion_details as pd');

// 			$this->db->join('hotels as h', 'h.id = pd.hotel_id', 'left');

// 			$this->db->join('promotions as p', 'p.id = pd.promotion_id', 'left');

// 			$this->db->where('pd.hotel_id', $hotel_id);

// 			$this->db->where('(h.language_id = 0 OR h.language_id = '.lang_id().')');

// 			$this->db->where('pd.deleted !=', DELETED);

// 			$this->db->where('p.status', STATUS_ACTIVE);

// 			$this->db->where('p.deleted !=', DELETED);

// 			$this->db->where('p.is_hot_deals', STATUS_ACTIVE);

// 			$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
// 			$this->db->where($p_where);

// 			$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
// 			$this->db->where($p_where);

// 			$this->db->order_by('p.order_', 'ASC');

// 			$query = $this->db->get();

// 			$results = $query->result_array();

// 			$str = $this->db->last_query();

// 			//print_r($str);exit();

// 			$results = $this->get_travel_dates($results);

// 			$this->cache->save($cache_file_id, $results, $cache_time);
// 		}

		$today = date('Y-m-d');

		$this->db->distinct();

		$this->db->select('h.id,h.language_id, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note,p.apply_for_hanoi,p.promotion_type, p.day_before');

		$this->db->from('promotion_details as pd');

		$this->db->join('hotels as h', 'h.id = pd.hotel_id', 'left');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id', 'left');

		$this->db->where('pd.hotel_id', $hotel_id);

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('p.is_hot_deals', STATUS_ACTIVE);

		$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
		$this->db->where($p_where);

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);

		$this->db->order_by('p.order_', 'ASC');

		$query = $this->db->get();

		$results = $query->result_array();

		$str = $this->db->last_query();

		//print_r($str);exit();

		$results = $this->get_travel_dates($results);

		$temp = array();

		foreach ($results as $promotion){

			$promotion['service_type'] = HOTEL;

			$temp[$promotion['promotion_id']] = $promotion;

		}

		$results = array_values($temp);

		return $results;

	}

	function get_hotel_destinations(){

		$this->db->select('id, name, url_title, is_top_hotel, number_hotels');

		$this->db->where('deleted != ', DELETED);

		$this->db->where('number_hotels > ', 0);

		$this->db->order_by('order_', 'ASC');

		$query = $this->db->get('destinations');

		$results = $query->result_array();

		// 24.10.2014: Update multi langguage TinVM
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;

	}

	function get_all_hotels_in_destination($destination_id){

		$this->db->select('id, name,language_id, url_title, star, is_new');

		$this->db->where('deleted != ', DELETED);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('destination_id', $destination_id);

		$this->db->where('(language_id = 0 OR language_id = '.lang_id().')');

		$this->db->order_by('deal', 'desc');

		$query = $this->db->get('hotels');

		$results = $query->result_array();

		return $results;

	}

	function get_hotel_obj_by_url_title($url_title){

		$this->db->select('id, name,language_id, url_title, destination_id');

		$this->db->where('deleted != ', DELETED);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('url_title', trim($url_title));


		$query = $this->db->get('hotels');

		$results = $query->result_array();

		if (count($results) > 0) {

			return $results[0];

		} else {

			return FALSE;

		}

		return $results;


	}

	function get_hotel_optional_services($hotel_id, $staying_dates){

		if(empty($staying_dates)) return array('additional_charge'=>array(), 'transfer_services'=>array(), 'extra_services'=>array());

		$start_date = $staying_dates[0];

		$end_date = $staying_dates[count($staying_dates) - 1];

		$start_date = $this->timedate->format($start_date, DB_DATE_FORMAT);

		$this->db->select('hs.id, hs.hotel_id, hs.optional_service_id, hs.charge_type, hs.price, op.name, op.type, op.unit_type, op.min_cap, op.max_cap, op.description, hs.default_selected, sp.price as specific_price, sp.default_selected as def_selected, sp.start_date, sp.end_date');

		$this->db->from('hotel_optional_services hs');

		$this->db->join('optional_services op', 'op.id = hs.optional_service_id');

		$p_where = " AND sp.deleted != ".DELETED;

		$p_where .= " AND (sp.start_date <='" . $start_date . "'";
		$p_where .= " AND (sp.end_date is NULL OR sp.end_date >='" . $start_date . "'))";
		$p_where .= " AND (sp.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM hotel_optional_service_price_dates as p_date WHERE sp.id = p_date.hotel_optional_service_price_id AND p_date.date = '".$start_date."'))";

		$this->db->join('hotel_optional_service_prices as sp', 'hs.id = sp.hotel_optional_service_id'.$p_where,'left outer');

		$this->db->where('hs.hotel_id', $hotel_id);

		$this->db->where('op.deleted !=', DELETED);

		$this->db->where('op.type !=', STATUS_ACTIVE); // don't get additional charge

		$this->db->order_by('op.order_', 'asc');


		$query = $this->db->get();

		$optional_services = $query->result_array();

		$additional_charge = array();

		$transfer_services = array();

		$extra_services = array();

		foreach ($optional_services as $key => $value) {

			if(isset($value['specific_price'])) {
				$value['price'] = $value['specific_price'];
				if(isset($value['def_selected'])) {
					$value['default_selected'] = $value['def_selected'];
				}
			}

			if ($value['type'] == 1){ //Additional Charge

				$additional_charge[] = $value;

			} elseif ($value['type'] == 2){ // Transfer Service

				$transfer_services[] = $value;

			} elseif ($value['type'] == 3){ // Extra Service

				$extra_services[] = $value;

			}
		}

		return array('additional_charge'=>$additional_charge, 'transfer_services'=>$transfer_services, 'extra_services'=>$extra_services);

	}

	function get_hotel_additional_charge($hotel_id, $staying_dates, $rooms = 1, $adults = 2, $children = 0){

		$ret = array();

		$this->db->select('hs.id, hs.hotel_id, hs.optional_service_id, hs.charge_type, hs.price, op.name, op.type, op.unit_type, op.description');

		$this->db->from('hotel_optional_services hs');

		$this->db->join('optional_services op', 'op.id = hs.optional_service_id');

		$this->db->where('hs.hotel_id', $hotel_id);

		$this->db->where('op.deleted !=', DELETED);

		$this->db->where('op.type', 1); // type additional charge

		$this->db->order_by('op.order_', 'asc');


		$query = $this->db->get();

		$optional_services = $query->result_array();

		foreach ($optional_services as $key => $value) {

			$price_info = $this->get_specific_op_price_by_dates($value, $staying_dates, $rooms, $adults, $children);

			if ($price_info['has_specific_price']){

				$value['price'] = $price_info['price_unit'];

				$value['price_total'] = $price_info['price_total'];

				$value['night_apply'] = $price_info['night_apply'];
			}

			if ($price_info['has_specific_price'] || $value['price'] > 0){
				$ret[] = $value;
			}

		}

		return $ret;

	}

	function get_specific_op_price_by_dates($h_optional_service, $staying_dates, $rooms, $adults, $children){

		$charge_type = $h_optional_service['charge_type']; // 1 perpax, -1 %, 2 per room.night

		$price = 0;

		$total_price = 0;

		$has_specific_price = FALSE;

		$night_apply = 0;

		foreach ($staying_dates as $staying_date){

			$staying_date = $this->timedate->format($staying_date, DB_DATE_FORMAT);

			$this->db->select('sp.price, sp.default_selected, sp.start_date, sp.end_date');

			$this->db->from('hotel_optional_service_prices as sp');

			$this->db->where('sp.hotel_optional_service_id', $h_optional_service['id']);

			$p_where = "sp.deleted != ".DELETED;
			$p_where .= " AND (sp.start_date <='" . $staying_date . "'";
			$p_where .= " AND (sp.end_date is NULL OR sp.end_date >='" . $staying_date . "'))";
			$p_where .= " AND (sp.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM hotel_optional_service_price_dates as p_date WHERE sp.id = p_date.hotel_optional_service_price_id AND p_date.date = '".$staying_date."'))";

			$this->db->where($p_where);

			$query = $this->db->get();

			$results = $query->result_array();

			if (count($results) > 0){

				$has_specific_price = TRUE;

				$h_op_price = $results[0];

				if ($price == 0 && $h_op_price['price'] > 0){

					$price = $h_op_price['price'];

				}

				if ($charge_type == 1 || $charge_type == -1){

					// per pax or % total : only get the first date having additional charge

					break;

				} else {

					// per room.night, get total charge

					$total_price = $total_price + $h_op_price['price'];

					$night_apply++;

				}

			}

		}

		if ($charge_type == 2){ // per room.night

			$total_price = $total_price * $rooms;

		}

		if ($charge_type == 1){ // per pax

			$total_price = $price * $adults + $price * $children * HOTEL_CHILDREN_RATE/100;

		}

		return array('price_unit' => $price, 'price_total' => $total_price, 'has_specific_price'=>$has_specific_price, 'night_apply'=>$night_apply);

	}

	function is_free_visa($hotel_id){

		$this->db->where('hotel_id', $hotel_id);

		$this->db->where('optional_service_id', 13); //vietnam visa on arrival

		$query = $this->db->get('hotel_optional_services');

		$results = $query->result_array();

		if (count($results) > 0){

			if($results[0]['price'] == 0){

				return true;

			}

		}

		return false;

	}

}

?>