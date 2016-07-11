<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TourModel extends CI_Model {
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->database();
		$this->load->library(array('TimeDate'));
		$this->load->model('HotelModel');
		$this->load->helper('tour');
	}
	/**
	* Get all tour categories.
	*
	*/
	function getAllCategories($limit = -1)
	{
		$this->db->order_by('order_');
		if ($limit != -1) {
			$this->db->limit($limit);
		}
		$query = $this->db->get('categories');

		$results = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'categories');
		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;
	}


	/**
	* Get all destinations which is top destination
	*
	*/
	function getTopDestinations()
	{
		//$this->db->cache_on();
		$this->db->select('id,name,region,picture_name,number_tours,url_title,parent_id');
		$this->db->where('is_top', 1);
		//$this->db->order_by('region');
		$this->db->order_by('order_');

		$query = $this->db->get('destinations');
		//$this->db->cache_off();

		$destinations = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		return $destinations;
	}


	/**
	* Get a destination by id
	*
	*/
	function getDestination($id)
	{
		$this->db->where('id', $id);
		$this->db->where('deleted !=', DELETED);
		$query = $this->db->get('destinations');

		$dess = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$dess = update_i18n_data($dess, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($dess) > 0) {
			return $dess[0];
		}
		return false;
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
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$dess = update_i18n_data($dess, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($dess) > 0) {
			return $dess[0];
		}
		return false;
	}
	function searchDestinations($name = '')
	{

		$str_query = 'd.id, d.name, d.region, p.name parent';

		$this->db->distinct();

		$this->db->select($str_query);

		$this->db->from('tour_destinations as td');

		$this->db->join('destinations as d','d.id = td.destination_id');

		$this->db->join('destinations as p', 'd.parent_id = p.id', 'left');


		if($name != ''){

			$this->db->where('d.name', $name);

		}

		$this->db->where('d.deleted !=', DELETED);


		$this->db->order_by('d.name');

		$query = $this->db->get();


		return $query->result_array();
	}

	function searchTours($search_criteria
		, $limit = -1, $offset = 0
		, $order_field = 'name', $order_type = 'asc', $filter_results)
	{
		// check if the search destination is a cruise
		$search_criteria['is_cruise'] = $this->_is_cruise_destination($search_criteria);

		$this->db->select('t.*, ts.includes, ts.excludes, p.short_name as partner_name, p.website as partner_website, pr.from_price, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new');

		$this->db->from('tours as t');

		$this->db->join('tour_services as ts', 'ts.tour_id = t.id', 'left outer');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$departure_date = $search_criteria['departure_date'];
		$pr_where = " AND (`pr`.`from_date` <='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'";
		$pr_where .= " AND (`pr`.`to_date` is NULL OR `pr`.`to_date` >='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'))";
		$pr_where .= " AND pr.deleted != ".DELETED;

		$this->db->join('tour_prices as pr', 't.id = pr.tour_id'.$pr_where,'left outer');

		$this->_setSearchCriteria($search_criteria, $filter_results);

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		// internationalization: toanlk 29/10/2014
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->group_by('t.id');

		$this->db->order_by($order_field, $order_type);

		if ($limit != -1) { // pagination
			$this->db->limit($limit, $offset);
		}

		$query = $this->db->get();

		$results = $query->result_array();

		// optimize function get price
		$results = $this->get_tours_price_optimize($results, $search_criteria['departure_date'], true);

		return $results;
	}


	function getToursByDestination_Optimize($destination_id, $search_criteria, $limit = 10) {
		$this->db->select('t.*, ts.includes, ts.excludes, p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star, c.is_new');

		$this->db->from('tours as t');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->join('tour_destinations td', 'td.tour_id= t.id', 'left outer');

		$this->db->join('tour_services ts', 'ts.tour_id = t.id', 'left outer');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);
		
		$this->db->where('t.deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);


		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('td.destination_id =', $destination_id);

		$this->db->where('td.is_land_tour =', 1);

		$this->db->group_by('t.id');

		$this->db->order_by("t.deal", "desc");

		$this->db->limit($limit, 0);
		$query = $this->db->get();

		$results = $query->result_array();

		/* if(!empty($results)) {
			$results = $this->get_tours_price_optimize($results, $search_criteria['departure_date']);
		} */

		return $results;
	}



	function get_tours_price_optimize($tours, $departure_date, $is_get_promotion = false) {
		if(empty($tours)) return FALSE;
		$tour_id = array();
		foreach ($tours as $key => $tour) {
			$tour_id[$key] = $tour['id'];
		}
		$this->db->select('tp.tour_id, tp.from_price, tp.best_price, tp.discount, tp.accommodation_id');

		$this->db->where_in('tp.tour_id', $tour_id);

		if ($departure_date != '') {

			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

			$pr_where = "(tp.from_date <='" . $departure_date . "'";

			$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

			$this->db->where($pr_where);
		}

		$this->db->where('tp.deleted !=', DELETED);

		$this->db->order_by('tp.from_price', 'asc');

		$query = $this->db->get('tour_prices tp');

		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)
		$prices = update_tour_price_to_net_price($prices);

		foreach ($tours as $key => $tour) {
			$tour['price'] = false;
			$tours[$key] = $tour;
		}

		foreach ($prices as $price) {
			foreach ($tours as $key => $tour) {
				if($price['tour_id'] == $tour['id']) {
					$tour['price'] = $price;
					$tours[$key] = $tour;
				}
			}
		}

		$promotions = $this->get_tours_promotion($tours, $departure_date, $is_get_promotion);

		if(!empty($promotions)) {

			foreach ($tours as $key => $tour) {

				if(isset($tour['price']) && empty($tour['price']['offer_rate'])) {

					$price = $tour['price'];
					$price['offer_rate'] = 0;
					$price['offer_note'] = '';


					foreach ($promotions as $promotion) {

						if($promotion['tour_id'] == $tour['id']) {

							// user in hanoi only get sepecific promotion ('apply for hanoi' is on)

							if (!check_prevent_promotion($tour['id']) || $promotion['apply_for_hanoi'] == STATUS_ACTIVE){

								$price['offer_rate'] = $promotion['offer_rate'];

								$price['offer_note'] = $promotion['note'];

								if ($is_get_promotion){

									$deal_info['promotion_id'] = $promotion['promotion_id'];
									$deal_info['name'] = $promotion['name'];
									$deal_info['start_date'] = $promotion['start_date'];
									$deal_info['end_date'] = $promotion['end_date'];
									$deal_info['expiry_date'] = $promotion['expiry_date'];
									$deal_info['is_hot_deals'] = $promotion['is_hot_deals'];
									$deal_info['is_specific_dates'] = $promotion['is_specific_dates'];
									$deal_info['note'] = $promotion['p_note'];
									$deal_info['travel_dates'] = $promotion['travel_dates'];

									$deal_info['promotion_type'] = $promotion['promotion_type'];
									$deal_info['day_before'] = $promotion['day_before'];


									$price['deal_info'] = $deal_info;
								}

								break;

							}

						}


					}

					$tour['price'] = $price;
					$tours[$key] = $tour;

				}

			}
		}

		return $tours;
	}

	function get_tours_promotion($tours, $departure_date, $is_get_promotion = FALSE){

		$tour_id = array();

		$acommodation_id = array();

		foreach ($tours as $key => $tour) {

			/**
			 * Only get promotion for IP not in Vietnam
			 */
			//if (!check_prevent_promotion($tour['id'])){

				if(isset($tour['price'])) {
					$tour_id[$key] = $tour['id'];
					$acommodation_id[$key] = $tour['price']['accommodation_id'];
				}

			//}
		}

		if(empty($tour_id)) return FALSE;
		// get price from
		$today = date(DB_DATE_FORMAT, time());

		if ($departure_date == ''){
			$departure_date = $today;
		} else {
			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);
		}

		if ($is_get_promotion){
			$this->db->select('pd.id, pd.offer_rate, pd.note, pd.note_detail, pd.tour_id, p.apply_for_hanoi, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note as p_note, p.promotion_type, p.day_before');
		} else {
			$this->db->select('pd.id, pd.offer_rate, pd.note, pd.note_detail, pd.tour_id, p.apply_for_hanoi');
		}

		$this->db->from('promotion_details as pd');
		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->where_in('pd.tour_id', $tour_id);
		$this->db->where_in('pd.accommodation_id', $acommodation_id);
		$this->db->where('pd.deleted !=', DELETED);


		$this->db->where('p.status', STATUS_ACTIVE);
		$this->db->where('p.deleted !=', DELETED);

		/*
		 * // old condition (don't have promotion type)
		$p_where = "(p.start_date <='" . $departure_date . "'";
		$p_where .= " AND (p.end_date is NULL OR p.end_date >='" . $departure_date . "'))";

		$p_where .= " AND (p.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM promotion_dates as p_date WHERE p.id = p_date.promotion_id AND date = '".$departure_date."'))";

		$p_where .= " AND (p.book_to is NULL OR p.book_to >='" . $today . "')";
		*/

		// check promotion type
		$p_where = get_promotion_sql_condition($departure_date);

		//echo $p_where;exit();

		$this->db->where($p_where);

		$this->db->order_by('p.order_', 'ASC');

		$query = $this->db->get();

		$promotions = $query->result_array();

		if (count($promotions) > 0){

			if($is_get_promotion){

				$promotions = $this->get_travel_dates($promotions);
			}

			return $promotions;
		}

		return null;
	}

	function countSeachResults($search_criteria, $filter_results){

		$search_criteria['is_cruise'] = $this->_is_cruise_destination($search_criteria);

		$this->db->select('t.id');
		$this->db->from('tours as t');
		$this->db->join('partners as p', 'p.id = t.partner_id');
		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$departure_date = $search_criteria['departure_date'];
		$pr_where = " AND (pr.from_date <='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'";
		$pr_where .= " AND (pr.to_date is NULL OR pr.to_date >='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'))";
		$pr_where .= " AND pr.deleted != ".DELETED;

		$this->db->join('tour_prices as pr', 't.id = pr.tour_id'.$pr_where,'left outer');

		$this->_setSearchCriteria($search_criteria, $filter_results);

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		// internationalization: toanlk 29/10/2014
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->group_by('t.id');

		$query = $this->db->get();

		$results = $query->result_array();

		return count($results);
	}


	function getTourDestinations($tour_id) {
		// get tour destinations
		$this->db->select('d.*');
		$this->db->from('tour_destinations as td');
		$this->db->join('destinations as d', 'td.destination_id = d.id');
		$this->db->where('td.tour_id', $tour_id);
		$this->db->where('d.deleted !=', DELETED);
		$this->db->order_by('td.order_', 'ASC');
		$query = $this->db->get();
		$dess = $query->result_array();

		return $dess;
	}
	function getTourServices($tour_id) {
		$this->db->where('tour_id', $tour_id);
		$query = $this->db->get('tour_services');

		$tour_services = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'tour_services');

		$tour_services = update_i18n_data($tour_services, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($tour_services) > 0) {
			$s_inclusions = $tour_services[0]['includes'];
			$services['includes'] = explode("\n", $s_inclusions);

			$s_exclusions = $tour_services[0]['excludes'];
			$services['excludes'] = explode("\n", $s_exclusions);

			return $services;
		}
		return FALSE;

	}
	function getTourAccommodations($tour_id, $c_service) {
		$this->db->where('tour_id', $tour_id);
		$this->db->where('class_service', $c_service);
		$this->db->order_by('deal', 'asc');
		$query = $this->db->get('tour_accommodations');

		$tour_accomms = $query->result_array();

		if (count($tour_accomms) > 0) {
			$content = $tour_accomms[0]['content'];
			$tour['accomms'] = explode("\n", $content);
			return $tour;
		}
		return FALSE;

	}
	function getTourPolicies($tour_id) {
		$this->db->where('tour_id', $tour_id);
		$query = $this->db->get('tour_booking_policies');

		$tour_policies = $query->result_array();

		if (count($tour_policies) > 0) {
			$policy['booking_time'] = $tour_policies[0]['booking_time'];
			$policy['cancellation'] = explode("\n", $tour_policies[0]['cancellation_policy']);
			$policy['children_extrabed'] = explode("\n", $tour_policies[0]['children_extrabed']);
			return $policy;
		}
		return FALSE;

	}
	function getTourPhotos($tour_id) {
		$this->db->where('tour_id', $tour_id);
		$this->db->order_by('order_' ,'asc');
		$query = $this->db->get('tour_photos');

		$tour_photos = $query->result_array();

		return $tour_photos;
	}

	/**
	* Set up search criteria for tour searching from an array data.
	*
	* @param search_criteria	An array of tour search criteria.
	*/
	function _setSearchCriteria($search_criteria = '', $filter_results = '')
	{
		if ($search_criteria == '')	{
			return;
		}

		//destination condition

		if (!empty($search_criteria['destination_ids'])){

			$value = $search_criteria['destination_ids'];

			$arr = explode(',', $value);

			foreach ($arr as $des_id) {
				$this->db->like("route_ids", "-".$des_id."-", "both");
			}

			// tour in sub-destination
			if ($filter_results != ''){

				foreach ($filter_results['sub_des'] as $des_id){

					$this->db->like("route_ids", "-".$des_id."-", "both");
				}
			}
		}

		// travel style condition
		if (!empty($search_criteria['travel_styles'])){

			$value = $search_criteria['travel_styles'];

			if ($value != '' && count($value) > 0) {

				if (count($value) == 1) {

					$this->db->like('t.category_id', $value[0]);

				} else {

					$query_cat = "(";
					$cnt = 0;
					foreach ($value as $cat) {
						if($cnt > 0) {
							$query_cat .= " OR ";
						}
						$query_cat = $query_cat."`t`.`category_id` LIKE '%".$cat."%'";
						$cnt++;
					}
					$query_cat .= ')';
					$this->db->where($query_cat);
				}
			}

		}

		// tour duration condition
		if ($filter_results != '' && !empty($filter_results['tour_duration'])){

			$duration = $filter_results['tour_duration'];

			$query_duration = "(";

			switch ($duration) {
				case 1://1 day
				case 2:// 2 day
				case 3:// 3 day
					$query_duration = $query_duration." `t`.`duration`=".$duration;
					break;
				case 4:// 4-7 day

					$query_duration = $query_duration." (`t`.`duration` >= 4 AND `t`.`duration` <= 7)";

					break;
				case 5:// >7 day

					$query_duration = $query_duration." `t`.`duration` > 7";

					break;
			}

			$query_duration .= ')';

			if ($query_duration != '()')

			$this->db->where($query_duration);

		}


		// tour type condition (don't use tour_type for cruise)
		if (!$search_criteria['is_cruise'] && $filter_results != '' && count($filter_results['tour_types']) > 0){

			$tour_types = $filter_results['tour_types'];

			$p_g_condition = '(';

			if (in_array(PRIVATE_TOUR, $tour_types)){

				$p_g_condition = $p_g_condition . "`t`.`class_tours` LIKE '%-".PRIVATE_TOUR."-%'";

				if (in_array(GROUP_TOUR, $tour_types)){

					$p_g_condition = $p_g_condition. " OR ";
				}
			}

			if (in_array(GROUP_TOUR, $tour_types)){

				$p_g_condition = $p_g_condition . "`t`.`class_tours` NOT LIKE '%-".PRIVATE_TOUR."-%'";

			}

			$p_g_condition = $p_g_condition. ')';


			$buget_condition = '(';

			foreach ($tour_types as $k=>$type) {

				if ($type != PRIVATE_TOUR && $type != GROUP_TOUR){

					if($k > 0) {
						$buget_condition .= " OR ";
					}

					$buget_condition = $buget_condition. "`t`.`class_tours` LIKE '%-".$type."-%'";
				}

			}
			$buget_condition .= ')';


			$str_query = '(';

			if ($buget_condition != '()'){

				$str_query = $str_query. $buget_condition;

				if ($p_g_condition != '()'){

					$str_query = $str_query. ' AND ';
				}
			}

			if ($p_g_condition != '()'){

				$str_query = $str_query. $p_g_condition;
			}

			$str_query = $str_query. ')';

			$this->db->where($str_query);

		}

		// cruise properties filter

		if ($filter_results != '' && $filter_results['cruise_cabin'] > 0){

			$cruise_cabin = $filter_results['cruise_cabin'];

			$query_str = "`c`.`cabin_index` & " . $cruise_cabin;

			$this->db->where($query_str);

		}

		// cruise properties filter

		if ($filter_results != '' && count($filter_results['cruise_properties']) > 0){

			$cruise_properties = $filter_results['cruise_properties'];

			if (in_array(-1, $cruise_properties)){ // has triple-family

				$this->db->where('c.has_triple_family', STATUS_ACTIVE);
			}

			foreach ($cruise_properties as $value) {

				if ($value != -1){

					$this->db->like("cruise_facility_ids", "-".$value."-", "both");

				}
			}

		}

		// tour activities filter

		if ($filter_results != '' && count($filter_results['tour_activities']) > 0){

			$tour_activities = $filter_results['tour_activities'];

			foreach ($tour_activities as $value) {

				$this->db->like("activity_ids", "-".$value."-", "both");
			}

		}

	}

	function create_or_update_customer($cus){
		
		/**
		 * Modified by Khuyenpv on 02/02/2014
		 * allways create a new customer after each booking
		 */
		
		$cus['date_created'] = $this->_getCurrentDateTime();
		$cus['date_modified'] = $this->_getCurrentDateTime();
		
		$this->db->insert('customers', $cus);
		
		$cus_id = $this->db->insert_id();
		
		/*
		$this->db->where('email', $cus['email']);

		$this->db->where('deleted !=', DELETED);

		$nr = $this->db->count_all_results('customers');

		$cus_id = 0;

		if ($nr == 0){

			$cus['date_created'] = $this->_getCurrentDateTime();

			$this->db->insert('customers', $cus);

			$cus_id = $this->db->insert_id();

		} else {

			$cus['date_modified'] = $this->_getCurrentDateTime();


			$this->db->where('email', $cus['email']);

			$this->db->where('deleted !=', DELETED);

			$this->db->update('customers', $cus);


			$this->db->where('email', $cus['email']);

			$this->db->where('deleted !=', DELETED);

			$query = $this->db->get('customers');

			$results = $query->result_array();


			$cus_id = $results[0]['id'];

		}*/

		return $cus_id;
	}

	function _getCurrentDateTime(){
		date_default_timezone_set("Asia/Saigon");

		return date('Y-m-d H:i:s', time());
	}

	function book($booking, $cus) {

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
		$booking['customer_id']	= $cus_id;

		// execute insert customer into db
		$this->db->insert('bookings', $booking);

		// return this id just created
		return $this->db->insert_id();;

		*/
	}
	function getPartners($types = '', $limit = -1, $offset = 0) {
		$this->db->where('deleted !=', DELETED);
		$this->db->where('hidden !=', 1);
		$this->db->order_by('order', 'ASC');

		/* if ($limit != -1) { // pagination
			$this->db->limit($limit, $offset);
		} */
		if(!empty($types)) {
			foreach ($types as $type) {
				$this->db->or_like('type', $type);
			}
		}

		$query = $this->db->get('partners');

		$partners = $query->result_array();

		return $partners;
	}

	function countParners() {
		$query_str = '';
		$partner_types = $this->config->item('partner_types');
		$count = 0;
		foreach ($partner_types as $type => $value) {
			$name = strtolower(translate_text($value));
			$query_str .= '(SELECT count( * )  AS count, "'.$name.'" AS type FROM `partners` WHERE `type` LIKE "%'. $type .'%" AND `hidden` !=1 AND `deleted` !=1)';
			if($count < count($partner_types) - 1) {
				$query_str .= ' UNION ';
			}
			$count++;
		}

		$query = $this->db->query($query_str);

		$results = $query->result_array();

		return $results;
	}

	function countPartners() {
		$this->db->where('deleted !=', DELETED);
		$this->db->where('hidden !=', 1);
		$query = $this->db->get('partners');
		$partners = $query->result_array();

		return count($partners);
	}

	function getAllToursForSitemap($order_field = 't.name', $order_type = 'asc')
	{
		$this->db->select('t.id, t.url_title');
		$this->db->from('tours as t');
		$this->db->join('partners as p', 'p.id = t.partner_id');
		$this->db->join('tour_prices as pr', 'pr.tour_id = t.id');

		$this->db->where('t.status', STATUS_ACTIVE);
		$this->db->where('t.deleted !=', DELETED);
		$this->db->where('p.deleted !=', DELETED);
		$this->db->where('pr.deleted !=', DELETED);
		$this->db->order_by($order_field, $order_type);

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
	}

	function createContact($contact) {
		// execute insert contact into db
		$this->db->insert('contacts', $contact);

		// return this id just created
		return $this->db->insert_id();
	}
	function getToursOfPartner($partner_id, $tour_id='')
	{
		$limit = $this->config->item('per_page');
		$this->db->select('id, name, url_title');
		$this->db->from('tours');

		$this->db->where('partner_id', $partner_id);
		$this->db->where('status =', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(language_id = 0 OR language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		
		$this->db->order_by('deal', 'desc');
		$this->db->limit($limit);
		if ($tour_id != '') {
			$this->db->where('id !=', $tour_id);
		}
		$query = $this->db->get();

		$tours = $query->result_array();

		return $tours;
	}
	function getSimilarTours($main_destination_id, $tour_id, $search_criteria)
	{
		$this->db->select('t.*, p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star, c.is_new');

		$this->db->from('tours as t');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('t.main_destination_id =', $main_destination_id);

		$this->db->where('t.id !=', $tour_id);
		
		// internationalization: toanlk 12/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->order_by("t.deal", "desc");

		$this->db->limit(SIMILAR_TOUR_LIMIT);
		$query = $this->db->get();

		$results = $query->result_array();


		if(!empty($results)) {
			$results = $this->get_tours_price_optimize($results, $search_criteria['departure_date']);
		}

		return $results;
	}
	function getSimilarCruiseTours($duration, $tour_id, $search_criteria, $class_accom, $cruise_port)
	{
		$this->db->select('t.*, p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star, c.is_new');

		$this->db->from('tours as t');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('t.cruise_id >', 0);

		$this->db->where('c.cruise_destination', $cruise_port);

		$this->db->where('t.id !=', $tour_id);
		
		// internationalization: toanlk 12/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		// Mekong cruise tours: similar tour duration and in the same location
		$class_tours = explode('-', $class_accom);

		if(!empty($class_tours)) {
			if($cruise_port == 1) {
				if($duration >= 4 && $duration <= 7) {
					$this->db->where('t.duration >=', 4);
					$this->db->where('t.duration <=', 7);
				} else if($duration > 7) {
					$this->db->where('t.duration >', 7);
				} else {
					$this->db->where('t.duration =', $duration);
				}

				$cnt = 0;
				$query_class = '';
				foreach ($class_tours as $class) {
					if($class > PRIVATE_TOUR) { // Not system travel styles
						if($cnt > 0) {
							$query_class .= " OR ";
						}
						$query_class = $query_class."`t`.`class_tours` LIKE '%-".$class."-%'";
						$cnt++;
					}
				}

				if (!empty($query_class)) {
					$query_class = "(".$query_class.')';
					$this->db->where($query_class);
				}

				// Halong Bay cruise tours: similar tour duration and similar system travel styles
			} else {
				if (count($class_tours) == 1) {
					$this->db->like('t.class_tours', '-'.$class_tours[0].'-');
				} else {
					$query_class = "(";
					$cnt = 0;
					foreach ($class_tours as $class) {
						if($cnt > 0 && $class != PRIVATE_TOUR) {
							$query_class .= " OR ";
						} elseif($class == PRIVATE_TOUR) {
							$query_class .= " AND ";
						}
						$query_class = $query_class."`t`.`class_tours` LIKE '%-".$class."-%'";
						$cnt++;
					}
					$query_class .= ')';
					$this->db->where($query_class);
				}

				$this->db->where('t.duration =', $duration);
			}
		}

		$this->db->order_by("t.deal", "desc");

		$this->db->limit(SIMILAR_TOUR_LIMIT);

		$query = $this->db->get();


		$results = $query->result_array();


		if(!empty($results)) {
			$results = $this->get_tours_price_optimize($results, $search_criteria['departure_date']);
		}

		return $results;
	}
	function getLinksCategory() {
		$continents = $this->config->item('continents');
		$continent_datas = array();
		$i=0;
		foreach ($continents as $key => $value) {
			$country_links = $this->getLinkCountries($key);
			if (count($country_links) > 0) {
				$continent_datas[$i]['code'] = $key;
				$continent_datas[$i]['name'] = $value;
				$continent_datas[$i]['countries'] = $country_links;
				$i++;
			}
		}
		return $continent_datas;
	}
	function getLinkCountries($continent) {
		$this->db->select('country');
		$this->db->from('links');
		$this->db->group_by('country');

		$this->db->where('status =', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);
		$this->db->where('continent =', $continent);

		$this->db->where('site =', SITE_BESTPRICEVN_COM);

		$this->db->order_by('country');
		$query = $this->db->get();

		$countries = $query->result_array();

		return $countries;
	}
	function getLinksOfCountry($country){
		$this->db->from('links');

		$this->db->where('status =', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);
		$this->db->where('country =', $country);
		$this->db->where('top_view =', 0);

		$this->db->where('site =', SITE_BESTPRICEVN_COM);

		$this->db->order_by('date_created');
		$query = $this->db->get();

		$links = $query->result_array();

		return $links;
	}
	function getLinksTopView(){
		$this->db->from('links');

		$this->db->where('status =', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);
		$this->db->where('top_view =', 1);

		$this->db->where('site =', SITE_BESTPRICEVN_COM);

		$this->db->order_by('date_created');
		$query = $this->db->get();

		$links = $query->result_array();

		return $links;
	}

	function getNumReviews($tour_ids, $review_for_type, $review_rate, $cus_type = ''){

		if (count($tour_ids) == 0) $tour_ids = array(-1);

		$this->db->where_in('review_for_id', $tour_ids);

		$this->db->where('review_for_type', $review_for_type);

		$this->db->where('deleted !=', DELETED);

		switch ($review_rate) {
			case 6 :
				$this->db->where('total_review_score >=', 9);
				break;
			case 5 :
				$this->db->where('total_review_score >=', 8);
				$this->db->where('total_review_score <', 9);
				break;
			case 4 :
				$this->db->where('total_review_score >=', 7);
				$this->db->where('total_review_score <', 8);
				break;
			case 3 :
				$this->db->where('total_review_score >=', 6);
				$this->db->where('total_review_score <', 7);
				break;
			case 2 :
				$this->db->where('total_review_score >=', 5);
				$this->db->where('total_review_score <', 6);
				break;
			case 1 :
				$this->db->where('total_review_score <', 5);
				break;
		}
		if(is_numeric($cus_type)) {
			$this->db->where('guest_type', $cus_type);
		}

		return $this->db->count_all_results('guest_reviews');
	}

	function getReviews($tour_ids = array(), $review_for_type = 0, $review_rate = -1, $num = -1, $offset = 0, $cus_type = ''){
		/*
		$this->db->select('guest_name, guest_country, guest_city, review_date, negative_review, positive_review, total_review_score');

		$this->db->from('guest_reviews');
		*/

		if (count($tour_ids) == 0) $tour_ids = array(-1);

		$this->db->where_in('review_for_id', $tour_ids);

		$this->db->where('review_for_type', $review_for_type);

		$this->db->where('deleted !=', DELETED);

		switch ($review_rate) {
			case 6 :
				$this->db->where('total_review_score >=', 9);
				break;
			case 5 :
				$this->db->where('total_review_score >=', 8);
				$this->db->where('total_review_score <', 9);
				break;
			case 4 :
				$this->db->where('total_review_score >=', 7);
				$this->db->where('total_review_score <', 8);
				break;
			case 3 :
				$this->db->where('total_review_score >=', 6);
				$this->db->where('total_review_score <', 7);
				break;
			case 2 :
				$this->db->where('total_review_score >=', 5);
				$this->db->where('total_review_score <', 6);
				break;
			case 1 :
				$this->db->where('total_review_score <', 5);
				break;
		}
		if(is_numeric($cus_type)) {
			$this->db->where('guest_type', $cus_type);
		}

		$this->db->order_by("review_date", "desc");

		if ($num == -1) { // return all results - no pagination
			$query = $this->db->get('guest_reviews');
		} else {
			//$query = $this->db->get('guest_reviews');
			$query = $this->db->get('guest_reviews', $num, $offset);
		}

		return   $query->result_array();

	}

	function getAllReviewScores($tour_ids, $review_for_type, $review_rate, $cus_type = ''){

		if (count($tour_ids) == 0) $tour_ids = array(-1);

		$this->db->select('sc.score score, sc.score_type score_type, sc.review_id');

		$this->db->from('review_score sc');

		$this->db->join('guest_reviews gr', 'gr.id = sc.review_id');

		$this->db->where_in('gr.review_for_id', $tour_ids);

		$this->db->where('gr.review_for_type', $review_for_type);

		$this->db->where('gr.deleted !=', DELETED);

		switch ($review_rate) {
			case 6 :
				$this->db->where('total_review_score >=', 9);
				break;
			case 5 :
				$this->db->where('total_review_score >=', 8);
				$this->db->where('total_review_score <', 9);
				break;
			case 4 :
				$this->db->where('total_review_score >=', 7);
				$this->db->where('total_review_score <', 8);
				break;
			case 3 :
				$this->db->where('total_review_score >=', 6);
				$this->db->where('total_review_score <', 7);
				break;
			case 2 :
				$this->db->where('total_review_score >=', 5);
				$this->db->where('total_review_score <', 6);
				break;
			case 1 :
				$this->db->where('total_review_score <', 5);
				break;
		}
		if(is_numeric($cus_type)) {
			$this->db->where('guest_type', $cus_type);
		}

		$query = $this->db->get();

		return $query->result_array();
	}

	function get_tours_by_hot_deals($cruise_port, $departure, $limited = ''){

		$service_type = $cruise_port == 1 ? 2 : 1; // Halong Bay or Mekong

		$departure = $this->timedate->format($departure, DB_DATE_FORMAT);

		if (strval($cruise_port) == ''){

			$cruise_location = 'halong_mekong';

		} else {

			$cruise_location = $cruise_port == 1 ? 'mekongrivercruises' : 'halongbaycruises';

		}

		$today = date('Y-m-d');

		$this->db->distinct();

		$this->db->select('t.id, t.name as name, t.main_destination_id, t.url_title, t.picture_name as picture, t.brief_description, t.review_number, t.total_score, t.show_partner, c.name as cruise_name, c.id as cruise_id, partner.short_name as partner_name, partner.id as partner_id, c.cruise_destination, c.num_cabin, c.cabin_type, c.mekong_cruise_destination, c.star,
			 p.id as promotion_id, p.name as promotion_name, p.note, p.start_date, p.end_date, p.book_to as expiry_date, p.is_specific_dates, p.order_promotion, p.apply_for_hanoi, p.promotion_type, p.day_before');

		$this->db->from('promotion_details as pd');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->join('tours as t', 't.id = pd.tour_id');

		$this->db->join('cruises as c', 'c.id = t.cruise_id');

		$this->db->join('partners as partner', 'partner.id = t.partner_id');


		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);


		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('pd.visibility', STATUS_ACTIVE);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('p.is_hot_deals', STATUS_ACTIVE);

		$this->db->where('p.service_type', $service_type);


		// get promotion hot deals in the future
		$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
		$this->db->where($p_where);


		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);


		$this->db->order_by('pd.order_new', 'ASC');

		$query = $this->db->get();

		$hot_deals = $query->result_array();

		$hot_deals = $this->get_travel_dates($hot_deals);

		foreach ($hot_deals as $key => $value){

			$value['offer_rate'] = 0;

			$value['offer_note'] = '';

			$value['from_price'] = 0;

			/**
			 *
			 * Promotion Infomation
			 *
			 */


			$offer_date = $departure;

			if (isset($value['specific_dates']) && count($value['specific_dates']) > 0){

				$offer_date = $value['specific_dates'][0]['date'];

				foreach ($value['specific_dates'] as $p_d){

					if($p_d['date'] >= $today){
						$offer_date = $p_d['date'];
						break;
					}

				}

			} else {

				$offer_date = $value['start_date'] > $today ? $value['start_date'] : $today;

			}

			$prices = $this->get_hot_deal_price_from($value['id'], $value['promotion_id'], $offer_date);

			if ($prices){

				$value['from_price'] = $prices['from_price'];

				$value['offer_rate'] = $prices['offer_rate'];

				$value['offer_note'] = $prices['offer_note'];
			}

			$value['selling_price'] = $value['from_price'] - round($value['from_price'] * $value['offer_rate'] / 100,0);


			$value['days_left'] = get_days_left($value['expiry_date']);

			$hot_deals[$key] = $value;

		}


		if($limited != '' && count($hot_deals) > $limited){

			array_splice($hot_deals, $limited);

		}

		$hot_deals = get_tour_by_promotion_allow_in_vietnam($hot_deals);

		return $hot_deals;

	}

	function sortPromotionOrderAsc($t1, $t2){
		if($t1['order_promotion'] == $t2['order_promotion']) {
			return 0;
		}
		return ($t1['order_promotion'] < $t2['order_promotion']) ? -1: 1;
	}

	function sortOffDesc($t1, $t2){
		if($t1['off'] == $t2['off']) {
			return 0;
		}
		return ($t1['off'] < $t2['off']) ? 1: -1;
	}

	function sortDealDesc($t1, $t2){
		if($t1['order_new'] == $t2['order_new']) {
			return 0;
		}
		return ($t1['order_new'] > $t2['order_new']) ? 1: -1;
	}

	function get_recommeded_cruises_by_types($cruise_port, $cruise_types, $departure, $is_charter = false, $is_day_cruise = false){

		$today = date('Y-m-d');

		$max_recommmeded_cruise = $this->config->item('max_cruise_best_deal');

		$this->db->select('c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner');

		$this->db->from('cruises as c');

		$this->db->join('partners as p', 'c.partner_id = p.id');

		$this->db->where('c.status', STATUS_ACTIVE);

		$this->db->where('c.deleted !=', DELETED);

		$this->db->where('c.cruise_destination', $cruise_port);

		// internationalization: toanlk 29/10/2014
		$lang_where = '(c.language_id = 0 OR c.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		if ($is_charter){
			$this->db->where_in('c.cabin_type', array(2,3));
		} else {
			$this->db->where('c.cabin_type !=', 2);
		}

		if ($is_day_cruise){
			$this->db->where('c.num_cabin', 0);
		} else {
			$this->db->where('c.num_cabin >', 0);
		}

		if (count($cruise_types) > 0){

			$this->db->where_in('c.star', $cruise_types);
		}

		$this->db->order_by('c.deal', 'desc');


		$this->db->limit($max_recommmeded_cruise, 0);

		$query = $this->db->get();

		$cruises = $query->result_array();

		foreach ($cruises as $key => $cruise){

			$cruise['includes'] = $this->get_cruise_includes($cruise['id']);

			$cruises[$key] = $cruise;

		}

		return $cruises;

	}

	function get_recommended_cruises_by_location($location){

		$this->db->select('c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner');

		$this->db->from('cruises as c');

		$this->db->join('partners as p', 'c.partner_id = p.id');

		$this->db->where('c.status', STATUS_ACTIVE);

		$this->db->where('c.deleted !=', DELETED);

		$this->db->where('c.cruise_destination', 1);

		// internationalization: toanlk 29/10/2014
		$lang_where = '(c.language_id = 0 OR c.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->like('c.mekong_cruise_destination', $location);

		$this->db->order_by('c.deal', 'desc');

		$this->db->limit(LIMIT_MORE_TOUR, 0);

		$query = $this->db->get();

		$cruises = $query->result_array();

		foreach ($cruises as $key=>$cruise){

			$cruise['includes'] = $this->get_cruise_includes($cruise['id']);

			$cruises[$key] = $cruise;

		}

		return $cruises;

	}

	function get_all_cruises($cruise_port){

		$luxury_cruises = array();

		$deluxe_cruises = array();

		$cheap_cruises = array();

		$charter_cruises = array();

		$day_cruises = array();

		$this->db->select('c.id, c.name, c.url_title, c.star, c.cabin_type, c.is_new, c.num_cabin');

		$this->db->from('cruises as c');

		$this->db->where('c.status', STATUS_ACTIVE);

		$this->db->where('c.deleted !=', DELETED);

		$this->db->where('c.cruise_destination', $cruise_port);

		// internationalization: toanlk 29/10/2014
		$lang_where = '(c.language_id = 0 OR c.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->order_by('c.deal', 'desc');

		$query = $this->db->get();

		$cruises = $query->result_array();

		foreach ($cruises as $key => $cruise) {

			if ($cruise['num_cabin'] == 0){

				$day_cruises[] = $cruise;

			} else {

				if ($cruise['star'] >= 4.5) {

					$luxury_cruises[] = $cruise;

				} elseif ($cruise['star'] >= 3.5){

					$deluxe_cruises[] = $cruise;

				} else {

					$cheap_cruises[] = $cruise;
				}

			}

			if ($cruise['cabin_type'] == 2 || $cruise['cabin_type'] == 3){

				$charter_cruises[] = $cruise;

			}
		}

		$ret['luxury_cruises'] = $luxury_cruises;

		$ret['deluxe_cruises'] = $deluxe_cruises;

		$ret['cheap_cruises'] = $cheap_cruises;

		$ret['charter_cruises'] = $charter_cruises;

		$ret['day_cruises'] = $day_cruises;

		return $ret;

	}

	/**
	  *  get_recommeded_cruises
	  *
	  *  @author toanlk
	  *  @since  Oct 24, 2014
	  */
	function get_recommeded_cruises($cruise_port, $departure){

		$luxury_cruises = array();

		$deluxe_cruises = array();

		$cheap_cruises = array();

		$charter_cruises = array();

		$day_cruises = array();

		$query_destination = '';

		if(strval($cruise_port) != '') {
			$query_destination = " AND c.cruise_destination = ".$cruise_port;
		}

		// internationalization: toanlk 29/10/2014
		$query_destination .= ' AND (c.language_id = 0 OR c.language_id = ' . lang_id().')';

					// luxury cruises
		$query_str = "(SELECT c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
					 " FROM cruises as c ".
					 " JOIN partners as p on p.id = c.partner_id".
					 " WHERE c.star >= 4.5 ".
					 " AND c.status = ". STATUS_ACTIVE.
					 " AND c.deleted != ". DELETED.
					 " AND c.cabin_type != 2". $query_destination.
					 " AND c.num_cabin > 0".
					 " ORDER BY c.deal DESC".
					 " LIMIT ". LIMIT_TOUR_ON_TAB. ") UNION ".
					// deluxe cruises
					 "(SELECT c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id ".
					 " FROM cruises as c ".
					 " JOIN partners as p on p.id = c.partner_id".
					 " WHERE (c.star < 4.5 AND c.star >= 3.5)".
					 " AND c.status = ". STATUS_ACTIVE.
					 " AND c.deleted != ". DELETED.
					 " AND c.cabin_type != 2". $query_destination.
				     " AND c.num_cabin > 0".
					 " ORDER BY c.deal DESC".
					 " LIMIT ". LIMIT_TOUR_ON_TAB. ") UNION ".
					// cheap cruises
					 "(SELECT c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id ".
					 " FROM cruises as c ".
					 " JOIN partners as p on p.id = c.partner_id".
					 " WHERE c.star < 3.5".
					 " AND c.status = ". STATUS_ACTIVE.
					 " AND c.deleted != ". DELETED.
					 " AND c.cabin_type != 2". $query_destination.
					 " AND c.num_cabin > 0".
					 " ORDER BY c.deal DESC".
					 " LIMIT ". LIMIT_TOUR_ON_TAB. ") UNION ".
					// day cruises
					 "(SELECT c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id ".
					 " FROM cruises as c ".
					 " JOIN partners as p on p.id = c.partner_id".
					 " WHERE c.status = ". STATUS_ACTIVE.
					 " AND c.deleted != ". DELETED.
					 " AND c.cabin_type != 2". $query_destination.
					 " AND c.num_cabin = 0".
					 " ORDER BY c.deal DESC".
					 " LIMIT ". LIMIT_TOUR_ON_TAB. ") UNION ".
					// charter cruises
					 "(SELECT c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id ".
					 " FROM cruises as c ".
					 " JOIN partners as p on p.id = c.partner_id".
					 " WHERE c.status = ". STATUS_ACTIVE.
					 " AND c.deleted != ". DELETED.
					 " AND c.cabin_type IN (2,3)". $query_destination.
					 " ORDER BY c.deal DESC".
					 " LIMIT ". LIMIT_TOUR_ON_TAB. ")";

		$query = $this->db->query($query_str);

		$cruises = $query->result_array();

		foreach ($cruises as $key => $cruise) {

			$cruise['includes'] = $this->get_cruise_includes($cruise['id']);

			if ($cruise['num_cabin'] == 0){

				$day_cruises[] = $cruise;

			} else {

				if ($cruise['star'] >= 4.5 && count($luxury_cruises) < LIMIT_TOUR_ON_TAB) {

					$luxury_cruises[] = $cruise;

				} elseif ($cruise['star'] >= 3.5 && count($deluxe_cruises) < LIMIT_TOUR_ON_TAB){

					$deluxe_cruises[] = $cruise;

				} elseif(count($cheap_cruises) < LIMIT_TOUR_ON_TAB) {

					$cheap_cruises[] = $cruise;
				}

			}

			if (count($charter_cruises) < LIMIT_TOUR_ON_TAB && ($cruise['cabin_type'] == 2 || $cruise['cabin_type'] == 3)){

				$charter_cruises[] = $cruise;

			}
		}

		$ret['luxury_cruises'] = $luxury_cruises;

		$ret['deluxe_cruises'] = $deluxe_cruises;

		$ret['cheap_cruises'] = $cheap_cruises;

		$ret['charter_cruises'] = $charter_cruises;

		$ret['day_cruises'] = $day_cruises;

		return $ret;

	}


	/**
	  *  get_recommeded_mekong_cruises
	  *
	  *  @author toanlk
	  *  @since  Oct 24, 2014
	  */
	function get_recommeded_mekong_cruises($cruise_port, $departure){

		$query_destination = '';

		if(strval($cruise_port) != '') {
			$query_destination = " AND c.cruise_destination = ".$cruise_port;
		}

		// internationalization: toanlk 29/10/2014
		$query_destination .= ' AND (c.language_id = 0 OR c.language_id = ' . lang_id().')';

		// vietnam cambodia cruises
		$query_str = "(SELECT c.id, c.name, c.url_title, c.mekong_cruise_destination, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
				" FROM cruises as c ".
				" JOIN partners as p on p.id = c.partner_id".
				" WHERE c.mekong_cruise_destination LIKE '%". VIETNAM_CAMBODIA_CRUISE_DESTINATION ."%'".
				" AND c.status = ". STATUS_ACTIVE.
				" AND c.deleted != ". DELETED.
				" ". $query_destination.
				" ORDER BY c.deal DESC".
				" LIMIT ".LIMIT_TOUR_ON_TAB.") UNION ".
		// vietnam cruises
		"(SELECT c.id, c.name, c.url_title, c.mekong_cruise_destination, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
		" FROM cruises as c ".
		" JOIN partners as p on p.id = c.partner_id".
		" WHERE c.mekong_cruise_destination LIKE '%". VIETNAM_CRUISE_DESTINATION ."%'".
		" AND c.status = ". STATUS_ACTIVE.
		" AND c.deleted != ". DELETED.
		" ". $query_destination.
		" ORDER BY c.deal DESC".
		" LIMIT ".LIMIT_TOUR_ON_TAB.") UNION ".
		// laos cruises
		"(SELECT c.id, c.name, c.url_title, c.mekong_cruise_destination, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
		" FROM cruises as c ".
		" JOIN partners as p on p.id = c.partner_id".
		" WHERE c.mekong_cruise_destination LIKE '%". LAOS_CRUISE_DESTINATION ."%'".
		" AND c.status = ". STATUS_ACTIVE.
		" AND c.deleted != ". DELETED.
		" ". $query_destination.
		" ORDER BY c.deal DESC".
		" LIMIT ".LIMIT_TOUR_ON_TAB.") UNION ".
		// thailand cruises
		"(SELECT c.id, c.name, c.url_title, c.mekong_cruise_destination, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
		" FROM cruises as c ".
		" JOIN partners as p on p.id = c.partner_id".
		" WHERE c.mekong_cruise_destination LIKE '%". THAILAND_CRUISE_DESTINATION ."%'".
		" AND c.status = ". STATUS_ACTIVE.
		" AND c.deleted != ". DELETED.
		" ". $query_destination.
		" ORDER BY c.deal DESC".
		" LIMIT ".LIMIT_TOUR_ON_TAB.") UNION ".
		// burma cruises
		"(SELECT c.id, c.name, c.url_title, c.mekong_cruise_destination, c.star, c.num_cabin, c.picture, c.num_reviews, c.review_score, c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id " .
		" FROM cruises as c ".
		" JOIN partners as p on p.id = c.partner_id".
		" WHERE c.mekong_cruise_destination LIKE '%". BURMA_CRUISE_DESTINATION ."%'".
		" AND c.status = ". STATUS_ACTIVE.
		" AND c.deleted != ". DELETED.
		" ". $query_destination.
		" ORDER BY c.deal DESC".
		" LIMIT ".LIMIT_TOUR_ON_TAB.")";

		$query = $this->db->query($query_str);

		$cruises = $query->result_array();

		$vn_cambodia_cruises = array();

		$vietnam_cruises = array();

		$laos_cruises = array();

		$thailand_cruises = array();

		$myanmar_cruises = array();

		foreach ($cruises as $key => $cruise) {

			$cruise['includes'] = $this->get_cruise_includes($cruise['id']);

			$cruise_destination = explode(',', $cruise['mekong_cruise_destination']);

			if (in_array(VIETNAM_CAMBODIA_CRUISE_DESTINATION, $cruise_destination)){

				if (count($vn_cambodia_cruises) < LIMIT_TOUR_ON_TAB){

					$vn_cambodia_cruises[] = $cruise;

				}

			}
			if (in_array(VIETNAM_CRUISE_DESTINATION, $cruise_destination)){

				if (count($vietnam_cruises) < LIMIT_TOUR_ON_TAB){

					$vietnam_cruises[] = $cruise;
				}

			}
			if (in_array(LAOS_CRUISE_DESTINATION, $cruise_destination)){

				if (count($laos_cruises) < LIMIT_TOUR_ON_TAB){

					$laos_cruises[] = $cruise;

				}

			}
			if (in_array(THAILAND_CRUISE_DESTINATION, $cruise_destination)){

				if (count($thailand_cruises) < LIMIT_TOUR_ON_TAB){
					$thailand_cruises[] = $cruise;
				}

			}
			if (in_array(BURMA_CRUISE_DESTINATION, $cruise_destination)){

				if (count($myanmar_cruises) < LIMIT_TOUR_ON_TAB){
					$myanmar_cruises[] = $cruise;
				}
			}

		}

		$ret['vn_ca_cruises'] = $vn_cambodia_cruises;

		$ret['vn_cruises'] = $vietnam_cruises;

		$ret['la_cruises'] = $laos_cruises;

		$ret['th_cruises'] = $thailand_cruises;

		$ret['my_cruises'] = $myanmar_cruises;

		return $ret;

	}

	function get_group_by_cruises($cruise_ids, $departure){

		if (count($cruise_ids) == 0){

			return array();

		}

		$today = date('Y-m-d');

		$this->db->select('id, pax_booked, pax_best_price, expiry_date, cruise_id');

		$this->db->from('groups');

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('start_date <=', $departure);

		$this->db->where('end_date >=', $departure);

		// restrict the oppotunity
		$this->db->where('expiry_date >', $today);

		$this->db->where('pax_booked < pax_best_price');

		$this->db->where_in('cruise_id', $cruise_ids);

		$query = $this->db->get();

		$groups = $query->result_array();

		return $groups;

	}



	function _get_ids($cruises){

		$ret = array();

		foreach ($cruises as $cruise){

			$ret[] = $cruise['id'];

		}

		return $ret;
	}

	function _get_tour_ids_from_promotion($promotion_details){

		$ret = array();

		foreach ($promotion_details as $pd){

			if (count($ret) == 0 || !in_array($pd['tour_id'], $ret)){

				$ret[] = $pd['tour_id'];

			}

		}

		return $ret;
	}

	function _get_cruise_ids_from_group($groups){

		$ret = array();

		foreach ($groups as $g){

			if (count($ret) == 0 || !in_array($g['cruise_id'], $ret)){

				$ret[] = $g['cruise_id'];

			}


		}

		return $ret;
	}

	function _get_remaining_recommended_cruises($cruise_port, $cruise_types, $ids, $remaining_count){

		if ($remaining_count == 0) return array();

		$this->db->select('c.id, c.name, c.url_title, c.star, c.picture, c.num_reviews, c.review_score, c.description, p.short_name as partner');

		$this->db->from('cruises as c');

		$this->db->join('partners as p', 'c.partner_id = p.id');

		$this->db->where('c.status', STATUS_ACTIVE);

		$this->db->where('c.deleted !=', DELETED);

		$this->db->where('c.cruise_destination', $cruise_port);

		if (count($cruise_types) > 0){
			$this->db->where_in('c.star', $cruise_types);
		}

		if (count($ids) > 0){

			$this->db->where_not_in('c.id', $ids);

		}

		$this->db->order_by('c.deal', 'desc');


		$this->db->limit($remaining_count, 0);

		$query = $this->db->get();

		$results = $query->result_array();

		foreach ($results as $key=>$value){
			$value['group_id'] = 0;
			$value['pax_booked'] = 0;
			$value['pax_best_price'] = 0;
			$results[$key] = $value;
		}

		return $results;

	}

	/**
	 * Get from price/best-price of tours	 *
	 */
	function get_tour_from_price($tour_id, $departure_date, $is_check_ip = true, $is_get_promotion = false){

		$this->db->select('tp.tour_id, tp.from_price, tp.best_price, tp.accommodation_id, tp.discount');

		$this->db->where('tp.tour_id', $tour_id);

		if ($departure_date != '') {

			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

			$pr_where = "(tp.from_date <='" . $departure_date . "'";

			$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

			$this->db->where($pr_where);
		}

		$this->db->where('tp.deleted !=', DELETED);

		$this->db->order_by('tp.from_price', 'asc');

		$query = $this->db->get('tour_prices tp');

		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)

		$prices = update_tour_price_to_net_price($prices);

		if (count($prices) > 0){
			$price = $prices[0];

			$promotion = $this->get_tour_promotion($tour_id, $price['accommodation_id'], $departure_date, $is_check_ip, $is_get_promotion);

			$price['offer_rate'] = $promotion ? $promotion['offer_rate'] : 0;

			$price['offer_note'] = $promotion ? $promotion['note'] : '';

			if ($is_get_promotion){

				$deal_info['promotion_id'] = $promotion['promotion_id'];
				$deal_info['name'] = $promotion['name'];
				$deal_info['start_date'] = $promotion['start_date'];
				$deal_info['end_date'] = $promotion['end_date'];
				$deal_info['expiry_date'] = $promotion['expiry_date'];
				$deal_info['is_hot_deals'] = $promotion['is_hot_deals'];
				$deal_info['is_specific_dates'] = $promotion['is_specific_dates'];
				$deal_info['note'] = $promotion['p_note'];
				$deal_info['travel_dates'] = $promotion['travel_dates'];

				$deal_info['promotion_type'] = $promotion['promotion_type'];

				$deal_info['day_before'] = $promotion['day_before'];

				$price['deal_info'] = $deal_info;
			}

			return $price;

		}


		return FALSE;

	}

	function get_tour_promotion($tour_id, $acommodation_id, $departure_date, $is_check_ip = true, $is_get_promotion = false){
		/**
		 * Don't get promotion for IP in Vietnam
		 */
		//if ($is_check_ip && check_prevent_promotion($tour_id)){
			//return false;
		//}

		// get price from
		$today = date(DB_DATE_FORMAT, time());

		if ($departure_date == ''){
			$departure_date = $today;
		} else {
			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);
		}

		// get promotion info
		if ($is_get_promotion){

			$this->db->select('pd.offer_rate, pd.note, pd.note_detail, p.apply_for_hanoi, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note as p_note, p.promotion_type, p.day_before');

		} else {

			$this->db->select('pd.offer_rate, pd.note, pd.note_detail, p.apply_for_hanoi');
		}

		$this->db->from('promotion_details as pd');
		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->where('pd.tour_id', $tour_id);
		$this->db->where('pd.accommodation_id', $acommodation_id);
		$this->db->where('pd.deleted !=', DELETED);


		$this->db->where('p.status', STATUS_ACTIVE);
		$this->db->where('p.deleted !=', DELETED);

		/*
		$p_where = "(p.start_date <='" . $departure_date . "'";
		$p_where .= " AND (p.end_date is NULL OR p.end_date >='" . $departure_date . "'))";

		$p_where .= " AND (p.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM promotion_dates as p_date WHERE p.id = p_date.promotion_id AND date = '".$departure_date."'))";


		$p_where .= " AND (p.book_to is NULL OR p.book_to >='" . $today . "')";
		*/

		$p_where = get_promotion_sql_condition($departure_date);

		$this->db->where($p_where);

		//$this->db->order_by('pd.offer_rate', 'DESC');
		$this->db->order_by('p.order_', 'ASC');

		$query = $this->db->get();

		$promotions = $query->result_array();

		if (count($promotions) > 0){

			if ($is_get_promotion){

				$promotions = $this->get_travel_dates($promotions);

			}

			// for user in Hanoi - Vietnam
			if ($is_check_ip && check_prevent_promotion($tour_id)){

				foreach ($promotions as $value){

					if ($value['apply_for_hanoi'] == STATUS_ACTIVE){

						return $value;

					}

				}

				return FALSE;
			}

			return $promotions[0];

		}

		return FALSE;
	}

	/**
	 * get the tour Overview
	 *
	 * used in tour-search function
	 *
	 */
	function get_tour_overview($tour_id, $departure_date, $tour_name = ''){

		if ($tour_id == '' && $tour_name == '') return FALSE;

		$this->db->select('t.id, t.name, t.url_title, t.picture_name, t.route, t.review_number, t.total_score, t.tour_highlight, t.partner_id,
			t.departure, t.cruise_id, t.brief_description, p.short_name as partner_name, c.is_new, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star');

		$this->db->from('tours t');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->join('partners p', 'p.id = t.partner_id');

		$tour_name = trim($tour_name);

		if ($tour_id != ''){

			$this->db->where('t.id', $tour_id);

		} else {

			$this->db->where('t.url_title', $tour_name);

		}

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$query = $this->db->get();

		$tours = $query->result_array();

		if (count($tours) >0) {

			$tour = $tours[0];

			$tour['price'] = $this->get_tour_from_price($tour['id'], $departure_date, true, true);

			$tour['photos'] = $this->getTourPhotos($tour['id']);


			// get tour itinerary

			$this->db->where('tour_id', $tour['id']);
			$this->db->order_by('id', 'asc');
			$query = $this->db->get('detail_itinerary');
			$results = $query->result_array();

			$tour['itineraries'] = $results;

			return $tour;

		}

		return false;
	}

	/**
	 *
	 * Used in See More Deals function in search results page
	 *
	 */
	function get_tour_by_id($id, $departure_date){

		$this->db->select('id, name, url_title, cruise_id, main_destination_id');

		$this->db->where('id', $id);

		$query = $this->db->get('tours');

		$tours = $query->result_array();

		if (count($tours) >0) {

			$tour = $tours[0];

			$normal_discount = 0;

			/*
			 * get normal discount of this tour
			 */
			$this->db->select('discount');

			$this->db->where('tour_id', $id);

			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

			$pr_where = "(from_date <='" . $departure_date . "'";

			$pr_where .= " AND (to_date is NULL OR to_date >='" . $departure_date . "'))";

			$this->db->where($pr_where);

			$this->db->where('deleted !=', DELETED);

			$this->db->order_by('from_price', 'asc');

			$query = $this->db->get('tour_prices');

			$prices = $query->result_array();

			if (count($prices) > 0){

				$normal_discount = $prices[0]['discount'];

			}

			$tour['normal_discount'] = $normal_discount;

			return $tour;

		}

		return FALSE;
	}

	function get_tour_by_url_title($url_title, $departure_date = '', $tour_id = ''){

		$this->db->select('t.*,p.id as partner_id, p.short_name as partner_name, c.cruise_destination, c.is_new, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star');
		$this->db->from('tours t');
		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');
		$this->db->join('partners p', 'p.id = t.partner_id');

		if ($tour_id == ''){
			$this->db->where('t.url_title', $url_title);
		} else {
			$this->db->where('t.id', $tour_id);
		}

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$query = $this->db->get('tours');

		$tours = $query->result_array();

		if(empty($tours) && empty($tour_id)) {
			$tours = $this->checkTourURLHistory($url_title);
		}

		if (count($tours) >0) {

			$tour = $tours[0];

			if ($departure_date != ''){

				$tour['price'] = $this->get_tour_from_price($tour['id'], $departure_date, true, true);

				$tour['optional_services'] = $this->get_tour_optional_services($tour['id'], $departure_date, $tour['duration']);
			}

			$tour['services'] = $this->getTourServices($tour['id']);

			$tour['policies'] = $this->getTourPolicies($tour['id']);

			$tour['accommodations'] = $this->get_tour_acommodations($tour['id'], $departure_date);

			return $tour;

		}

		return FALSE;
	}

	function get_tour_obj_by_url_title($url_title){

		$this->db->select('t.*, p.id as p_id, p.name as partner_name, c.id as c_id, c.name as cruise_name, c.cruise_destination, c.url_title as cruise_url_title');

		$this->db->from('tours t');

		$this->db->join('partners p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('t.url_title', $url_title);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$query = $this->db->get();

		$tours = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'tours');
		$table_cnf[] = array('col_id_name'=>'p_id', 'table_name'=>'partners');
		$table_cnf[] = array('col_id_name'=>'c_id', 'table_name'=>'cruises');

		$colum_cnf[] = array('table_name'=>'partners', 'col_name_db'=>'id', 'col_name_alias'=>'p_id');
		$colum_cnf[] = array('table_name'=>'partners', 'col_name_db'=>'name', 'col_name_alias'=>'partner_name');

		$colum_cnf[] = array('table_name'=>'cruises', 'col_name_db'=>'id', 'col_name_alias'=>'c_id');
		$colum_cnf[] = array('table_name'=>'cruises', 'col_name_db'=>'name', 'col_name_alias'=>'cruise_name');

		$tours = update_i18n_data($tours, I18N_MULTIPLE_MODE, $table_cnf, $colum_cnf);

		if (count($tours) >0) {

			$tour = $tours[0];

			return $tour;
		}

		return FALSE;
	}


	function get_cruise_tours_from_price($tour_ids, $departure_date){

		$this->db->distinct();

		$this->db->select('t.id, g.id as group_id');

		$this->db->from('tours t');

		$today = date(DB_DATE_FORMAT);
		$sub_where = " AND g.status=".STATUS_ACTIVE." AND g.start_date <='".$departure_date."'";
		$sub_where .= " AND g.end_date >='".$departure_date."' AND g.expiry_date >'".$today."' AND g.pax_booked < g.pax_best_price" ;
		$this->db->join('groups g', 'g.cruise_id = t.cruise_id'.$sub_where, 'left outer');

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where_in('t.id', $tour_ids);

		$query = $this->db->get();

		$tours = $query->result_array();

		foreach ($tours as $key => $tour) {

			$tour['price'] = $this->get_tour_from_price($tour['id'], $departure_date);

			$tours[$key] = $tour;
		}

		return $tours;

	}

	function get_list_tours_of_cruise($cruise_id){

		$this->db->select('t.id, t.name, t.url_title, t.duration, t.departure, t.itinerary_status, t.detail_itinerary, t.picture_name, t.route, t.tour_highlight, t.review_number, t.total_score');

		$this->db->from('tours as t');

		$departure_date = date(DB_DATE_FORMAT);

		$pr_where = "tp.tour_id = t.id";

		$pr_where .= " AND (tp.from_date <='" . $departure_date . "'";

		$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

		$pr_where .= " AND tp.deleted != 1";


		$this->db->join('tour_prices as tp', $pr_where, 'left outer');


		$this->db->where('t.cruise_id', $cruise_id);

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->order_by('t.duration', 'asc');

		$this->db->order_by('tp.from_price', 'asc');

		$query = $this->db->get();

		$tours = $query->result_array();

		foreach ($tours as $key=>$value){

			$value['policies'] = $this->getTourPolicies($value['id']);

			$value['tour_itinerary'] = $this->get_tour_detail_itinerary($value['id']);

			$tours[$key] = $value;

		}

		return $tours;
	}

	function get_cruise_tours($cruise_id, $departure_date){
		$this->db->distinct();
		$this->db->select('t.*, p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star');
		$this->db->from('tours t');
		$this->db->join('cruises c', 'c.id = t.cruise_id');
		$this->db->join('partners p', 'p.id = t.partner_id');

		$this->db->where('t.cruise_id', $cruise_id);

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->order_by('t.duration', 'asc');

		$query = $this->db->get('tours');

		$tours = $query->result_array();

		foreach ($tours as $key => $tour) {

			$tour['price'] = $this->get_tour_from_price($tour['id'], $departure_date, true, true);

			$tours[$key] = $tour;
		}



		return $tours;

	}

	function get_cruise_of_tour($cruise_id, $tour_id, $departure_date){

		$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

		$this->db->select('id, name, url_title, star, picture, children_text, infants_text, num_cabin, mekong_cruise_destination, cruise_destination');

		$this->db->from('cruises');

		$this->db->where('id', $cruise_id);

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get();

		$cruises = $query->result_array();

		if (count($cruises) > 0){

			$cruise = $cruises[0];

			return $cruise;

		} else {
			return FALSE;
		}

	}

	function get_tour_acommodations($tour_id, $departure_date){

		$this->db->select('t.*, cc.name as cabin_name, cc.picture, cc.cabin_size, cc.bed_size, cc.id as cruise_cabin_id, cc.cruise_id as cruise_id, cc.max_person, cc.description as cabin_description');
		$this->db->from('tour_accommodations_ t');
		$this->db->join('cruise_cabins cc', 'cc.id = t.cruise_cabin_id', 'left outer');
		$this->db->where('t.tour_id', $tour_id);
		//$this->db->order_by('t.id', 'asc');
		$this->db->order_by('deal', 'asc');
		$query = $this->db->get();

		$tour_accomms = $query->result_array();

		foreach ($tour_accomms as $key=>$value){
			if ($departure_date != ''){

				$value['prices'] = $this->get_tour_accommodation_prices($value['id'], $departure_date);

				$value['promotion'] = $this->get_tour_promotion($tour_id, $value['id'], $departure_date);
			}

			$value['cabin_facilities'] = $this->getCruiseCabinFacilities($value['cruise_id'],$value['cruise_cabin_id']);

			$tour_accomms[$key] = $value;
		}

		return $tour_accomms;
	}

	function get_tour_accommodation_prices($acommodation_id, $departure_date){

		$this->db->select('tpd.group_size, tpd.price, tpd.accommodation_id, tp.tour_id');

		$this->db->from('tour_price_details tpd');

		$this->db->join('tour_prices tp', 'tp.id = tpd.tour_price_id');

		$this->db->where('tpd.accommodation_id', $acommodation_id);

		if ($departure_date != '') {

			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

			$pr_where = "(tp.from_date <='" . $departure_date . "'";

			$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

			$this->db->where($pr_where);
		}

		$this->db->where('tp.deleted !=', DELETED);

		$query = $this->db->get();

		$prices = $query->result_array();

		if (count($prices) > 0){

			$ret = array();

			foreach ($prices as $price){
				
				if(is_tour_no_vat($price['tour_id'])){
					
					$ret[$price['group_size']] = re_calculate_price_no_vat($price['price']);
					
				} else {
					
					$ret[$price['group_size']] = $price['price'];
					
				}
			}

			return $ret;

		}

		return FALSE;

	}

	function get_tour_optional_services($tour_id, $departure_date='', $duration=''){

		$this->db->select('ts.id, ts.tour_id, ts.optional_service_id, ts.charge_type, ts.price, op.name, op.type, op.unit_type, op.min_cap, op.max_cap, op.description, op.url, ts.default_selected, sp.price as specific_price, sp.default_selected as def_selected');

		$this->db->from('tour_optional_services ts');

		$this->db->join('optional_services op', 'op.id = ts.optional_service_id');

		$p_where = " AND (sp.start_date <='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'";
		$p_where .= " AND (sp.end_date is NULL OR sp.end_date >='" . $this->timedate->format($departure_date, DB_DATE_FORMAT) . "'))";
		$p_where .= " AND sp.deleted != ".DELETED;
		$p_where .= " AND (sp.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM tour_optional_service_price_dates as p_date WHERE sp.id = p_date.tour_optional_service_price_id AND p_date.date = '".$this->timedate->format($departure_date, DB_DATE_FORMAT)."'))";

		$this->db->join('tour_optional_service_prices as sp', 'ts.id = sp.tour_optional_service_id'.$p_where,'left outer');

		$this->db->where('ts.tour_id', $tour_id);

		$this->db->where('op.deleted !=', DELETED);

		$this->db->order_by('op.order_', 'asc');

		// Special surcharge
		$departure_date = date('d-m-Y', strtotime($departure_date));
		$year = date('Y', strtotime($departure_date));
		$christmas = Christmas.'-'.$year;
		$new_year = New_Year.'-'.$year;
		$Saigon_independence_day = Saigon_Independence_Day.'-'.$year;
		$arr_lunar_year = $this->config->item('lunar_new_year');
		foreach ($arr_lunar_year as $key => $value) {
			if($key==$year){
				$lunar_new_year = $value.'-'.$year;
				if(!is_surcharge($departure_date, $duration, $lunar_new_year)) {
					$this->db->where('ts.optional_service_id !=', Surcharge_Lunar_New_Year);
				}
			}
		}
		if(!is_surcharge($departure_date, $duration, $christmas)) {
			$this->db->where('ts.optional_service_id !=', Surcharge_Christmas);
		}
		if(!is_surcharge($departure_date, $duration, $new_year)) {
			$this->db->where('ts.optional_service_id !=', Surcharge_New_Year);
		}
		if(!is_surcharge($departure_date, $duration, $Saigon_independence_day)) {
			$this->db->where('ts.optional_service_id !=', Surcharge_Saigon_Independence_Day);
		}

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

			if ($value['type'] == 1 && $value['price'] > 0){ //Additional Charge

				$additional_charge[] = $value;

			} elseif ($value['type'] == 2){ // Transfer Service

				$transfer_services[] = $value;

			} elseif ($value['type'] == 3){ // Extra Service

				$extra_services[] = $value;

			}
		}

		return array('additional_charge'=>$additional_charge, 'transfer_services'=>$transfer_services, 'extra_services'=>$extra_services);

	}

	function getCruiseCabinFacilities($cruise_id, $cruise_cabin_id){

		$this->db->select('f.id, f.name, f.important');

		$this->db->from('cruise_facilities as cf');

		$this->db->join('cruise_cabins as cb', 'cf.cruise_cabin_id = cb.id');

		$this->db->join('facilities as f', 'f.id = cf.facility_id');

		$this->db->where('cb.cruise_id', $cruise_id);

		$this->db->where('cb.id', $cruise_cabin_id);

		$this->db->where('cf.value', STATUS_ACTIVE);
		$this->db->where('cf.deleted !=', DELETED);

		$this->db->where('f.status', STATUS_ACTIVE);
		$this->db->where('f.deleted !=', DELETED);

		$this->db->order_by('f.name', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

	function get_children_rate($tour_id){

		$this->db->select('tcp.under12');

		$this->db->where('tcp.tour_id', $tour_id);

		$query = $this->db->get('tour_children_prices tcp');

		$children_rates = $query->result_array();

		if (count($children_rates) > 0){
			$children_rate = $children_rates[0];
			return $children_rate['under12'];
		}

		return 0;
	}

	function get_children_cabin_price($tour_id){

		$this->db->where('tour_id', $tour_id);

		$query = $this->db->get('tour_children_prices');

		$children_prices = $query->result_array();

		if (count($children_prices) > 0){

			return $children_prices[0];

		}

		return false;
	}


	function get_hotel_hot_deals($destination_id = ''){

		$this->db->distinct();

		$today = date('Y-m-d');

		$this->db->select('h.id, h.name, h.url_title, h.picture, h.partner_id, d.name as destination, pd.note as offer_note, pd.offer_rate as offer_rate,p.id as promotion_id, p.name as promotion_name, p.note as p_note, p.start_date, p.end_date, p.book_to, p.is_hot_deals, p.is_specific_dates, p.promotion_type, p.day_before');

		$this->db->from('promotion_details as pd');

		$this->db->join('hotels as h', 'h.id = pd.hotel_id');

		$this->db->join('destinations as d', 'd.id = h.destination_id');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		if ($destination_id != ''){

			$this->db->where('d.id', $destination_id);
		}

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);

		$this->db->order_by('h.deal', 'desc');

		$this->db->order_by('p.order_', 'asc');

		$lang_where = '(h.language_id = 0 OR h.language_id = ' . lang_id().')';

		$this->db->where($lang_where);

		$query = $this->db->get();

		$hotels = $query->result_array();


		$hotels = get_promotion_hot_deals('id', $hotels);


		$hotels = $this->get_travel_dates($hotels);

		foreach ($hotels as $key=>$value){

			if (isset($value['specific_dates']) && count($value['specific_dates']) > 0){

				$arrival_date = $value['specific_dates'][0]['date'];

			} else {

				$arrival_date = $value['start_date'];

			}

			//$arrival_date = $value['start_date'];

			$departure_date = strtotime(date("Y-m-d", strtotime($arrival_date)) . " +1 day");

			$departure_date = date('Y-m-d', $departure_date);


			$value['room_types'] = $this->HotelModel->getRoomTypes($value['id'], $arrival_date, $departure_date);

			$value = $this->HotelModel->_getPriceFrom($value, $value['room_types']);

			$value['from_price'] = $value['price'];

			$value['selling_price'] = $value['promotion_price'];


			if ($value['from_price'] != 0){

				$value['off'] = round(($value['from_price'] - $value['selling_price']) * 100/$value['from_price']);

			} else {

				$value['off'] = 0;
			}

			$hotels[$key] = $value;

		}

		//usort($hotels, array($this, 'sortOffDesc'));

		return $hotels;
	}

	function get_tour_off_hot_deal_promotion(){

		$today = date('Y-m-d');

		$this->db->distinct();

		$this->db->select('t.id, t.name, t.url_title, t.picture_name as picture, t.deal, pd.order_new, c.id as cruise_id, c.cruise_destination, p.name as promotion_name, p.note as p_note, p.id as promotion_id, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.apply_for_hanoi, p.promotion_type, p.day_before');

		$this->db->from('promotion_details as pd');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->join('tours as t', 't.id = pd.tour_id');

		$this->db->join('cruises as c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('pd.visibility', STATUS_ACTIVE);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
		$this->db->where($p_where);

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);

		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);


		$this->db->order_by('p.order_', 'ASC');
		//$this->db->order_by('t.deal', 'DESC');

		$query = $this->db->get();

		$results = $query->result_array();

		$results = get_promotion_hot_deals('id', $results);

		$results = get_tour_by_promotion_allow_in_vietnam($results);

		$results = $this->get_travel_dates($results);

		return $results;

	}

	function get_all_tour_hot_deals(){

		$tour_by_hot_deals = $this->get_tour_off_hot_deal_promotion();

		$today = date(DB_DATE_FORMAT);

		foreach ($tour_by_hot_deals as $key => $value){


			if (isset($value['specific_dates']) && count($value['specific_dates']) > 0){

				$from_date = $value['specific_dates'][0]['date'];

				foreach ($value['specific_dates'] as $p_d){

					if($p_d['date'] >= $today){
						$from_date = $p_d['date'];
						break;
					}

				}

				$price = $this->get_tour_from_price($value['id'], $from_date);

			} else {

				$price = $this->get_tour_from_price($value['id'], $value['start_date']);

			}

			if (!$price){

				$value['offer_note'] = '';

				$value['offer_rate'] = 0;

				$value['from_price'] = 0;

				$value['selling_price'] = 0;

				$value['off'] = 0;

			} else {

				$value['from_price'] = $price['from_price'];

				$value['selling_price'] = $price['from_price'] - round($price['from_price'] * $price['offer_rate'] / 100,0);

				$value['off'] = round(($value['from_price'] - $value['selling_price']) * 100/$value['from_price']);

				$value['offer_note'] = $price['offer_note'];

				$value['offer_rate'] = $price['offer_rate'];

			}

			$tour_by_hot_deals[$key] = $value;

		}

		usort($tour_by_hot_deals, array($this, 'sortDealDesc'));

		return $tour_by_hot_deals;

	}

	function get_travel_dates($promotions){

		foreach ($promotions as $key => $promotion){

			$travel_dates = "";

			$promotion['specific_dates'] = array();

			if ($promotion['is_specific_dates'] == 1){

				$this->db->where('promotion_id', $promotion['promotion_id']);

				$this->db->order_by('date', 'asc');

				$query = $this->db->get('promotion_dates');

				$dates = $query->result_array();

				$promotion['specific_dates'] = $dates;

				$travel_dates = get_travel_specific_dates($dates);
			}

			$promotion['travel_dates'] = $travel_dates;

			$promotions[$key] = $promotion;

		}

		return $promotions;

	}

	function get_top_hotel_destinations(){

		$this->db->select('id, name, url_title');

		$this->db->from('destinations');

		$this->db->where('is_top_hotel', STATUS_ACTIVE);

		$this->db->where('deleted !=', DELETED);

		$this->db->order_by('order_','asc');

		$query = $this->db->get();

		$destinations = $query->result_array();

		return $destinations;

	}

	function _is_cruise_destination($search_criteria){
		$ret = false;

		if (isset($search_criteria['destination_ids'])){
			$arr = explode(',', $search_criteria['destination_ids']);

			if (count($arr) > 0){

				$des_id = $arr[0];

				$this->db->where('id', $des_id);

				$this->db->where('type', 6);	// cruise

				$cnt = $this->db->count_all_results('destinations');

				$ret = $cnt > 0;
			}

		}

		return $ret;
	}

	function get_rich_snippet_review_infor($cruise_destination, $action) {
		$this->db->select('gr.total_review_score');
		$this->db->from('guest_reviews AS gr');
		$this->db->join('tours AS t', 'gr.review_for_id = t.id', 'left');
		$this->db->join('cruises AS c', 't.cruise_id = c.id', 'left');
		$this->db->where('c.cruise_destination', $cruise_destination);
		$this->db->where('gr.deleted !=', DELETED);

		if($action != HALONG_BAY_CRUISES && $action != MEKONG_RIVER_CRUISES) {
			// budget
			if(strpos($action, "luxury") !== false) {
				$this->db->where('c.star >=', 4.5);
			} elseif (strpos($action, "deluxe") !== false) {
				$this->db->where('c.star >=', 3.5);
			} elseif (strpos($action, "cheap") !== false) {
				$this->db->where('c.star <', 3.5);
			}

			// cruise type
			if (strpos($action, "private") !== false) {
				$this->db->where('c.cabin_type', 2);
			} else {
				$this->db->where('c.cabin_type !=', 2);
			}
		}


		$query = $this->db->get();
		$reviews = $query->result_array();

		$review_numb = count($reviews);

		// return empty
		if($review_numb == 0) return null;

		$total_score = 0;
		foreach ($reviews as $review) {
			$total_score += $review['total_review_score'];
		}
		$review_score = number_format($total_score/$review_numb, 1);

		return array('review_score' => $review_score, 'review_numb' => $review_numb);
	}


	function getNumToursByDestinationAjax($destination_id, $duration, $is_cruise = false)
	{
		$this->db->select('*');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		

		$this->db->where('p.deleted !=', DELETED);

		if($is_cruise) {
			$this->db->where('t.cruise_id >', 0);
			$this->db->like("t.route_ids", "-".$destination_id."-", "both");
		} else {
			$this->db->where('t.main_destination_id', $destination_id);
		}


		if(!empty($duration)) {
			switch ($duration) {
				case 1://1 day
				case 2:// 2 day
				case 3:// 3 day
					$this->db->where('t.duration', $duration);
					break;
				case 4:// 4-7 day
					$this->db->where('t.duration >=', 4);
					$this->db->where('t.duration <=', 7);
					break;
				case 5:// >7 day
					$this->db->where('t.duration >', 7);
					break;
			}
		}

		return $this->db->count_all_results('tours as t');
	}

	function get_tours_by_destination_ajax($destination_id, $departure, $duration, $sortBy='',$offset = 0, $num=5, $is_cruise = false) {

		$this->db->select('t.*, p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star, c.is_new');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');
		$this->db->join('tour_prices as pr', 't.id = pr.tour_id','left outer');

		$departure_date = date(DB_DATE_FORMAT, strtotime($departure));

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('pr.deleted !=', DELETED);

		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		if($is_cruise) {
			$this->db->where('t.cruise_id >', 0);
			$this->db->like("t.route_ids", "-".$destination_id."-", "both");
		} else {
			$this->db->where('t.main_destination_id', $destination_id);
		}

		if(!empty($duration)) {
			switch ($duration) {
				case 1://1 day
				case 2:// 2 day
				case 3:// 3 day
					$this->db->where('t.duration', $duration);
					break;
				case 4:// 4-7 day
					$this->db->where('t.duration >=', 4);
					$this->db->where('t.duration <=', 7);
					break;
				case 5:// >7 day
					$this->db->where('t.duration >', 7);
					break;
			}
		}

		$this->db->group_by('t.id');

		switch ($sortBy) {
			case 'price_low_high':
				$this->db->order_by("pr.from_price", "asc");
				break;
			case 'price_high_low':
				$this->db->order_by("pr.from_price", "desc");
				break;
			case 'review_score':
				$this->db->order_by("total_score", "desc");
				break;
			default :
				$this->db->order_by("t.deal", "desc");
				break;
		}

		$query = $this->db->get('tours as t', $num, $offset);

		$results = $query->result_array();

		if(!empty($results)) {
			$results = $this->get_tours_price_optimize($results, $departure_date);
		}

		return $results;
	}


	/// get recommended tours for tab tour (Vietnam package tours, Laos tours and Cambodia Tours)
	function get_recommended_tours(){

		$query_select = "SELECT t.id, t.name, t.brief_description, t.url_title, t.picture_name, t.review_number, t. category_id," .
		" t.total_score, t. main_destination_id, t. route,".
		" p.short_name as partner_name, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new";

		$results = array();
		$destinations = array(VIETNAM, LAOS, CAMBODIA);
		$results_name = array('vietnam_tours', 'laos_tours', 'cambodia_tours');

		foreach ($destinations as $key => $des) {
			$limit = LIMIT_TOUR_ON_TAB;
			if($key == 0) $limit = (LIMIT_TOUR_ON_TAB + 1);

			$query_str = $query_select.
			" FROM tours as t".
			" JOIN partners as p on p.id = t.partner_id".
			" LEFT OUTER JOIN cruises as c on c.id = t.cruise_id".
			" JOIN tour_destinations AS td ON td.tour_id= t.id".
			" WHERE td.destination_id = ". $des .
			" AND td.is_land_tour = 1".
			" AND t.status = ". STATUS_ACTIVE.
			" AND t.deleted != ". DELETED.
			" AND p.deleted !=". DELETED.
			" ORDER BY t.deal DESC".
			" LIMIT " . $limit;

			$query = $this->db->query($query_str);

			$results[$results_name[$key]] = $query->result_array();
		}

		return $results;

	}

	function getDestinationTravelStyles($destination_id)
	{
		$this->db->select('dts.*, st.id as travel_style_id, st.name as style_name, st.name as en_style_name, st.description as style_description');

		$this->db->join('travel_styles st', 'st.id = dts.style_id', 'left outer');

		$this->db->where('dts.destination_id', $destination_id);
		$this->db->where('dts.show_on_tab', 1);
		$this->db->where('st.deleted !=', DELETED);

		$this->db->order_by('dts.order', 'asc');

		$query = $this->db->get('destination_travel_styles dts');

		$destination_travel_styles = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'travel_style_id', 'table_name'=>'travel_styles');

		$colum_cnf[] = array('table_name'=>'travel_styles', 'col_name_db'=>'name', 			'col_name_alias'=>'style_name');
		$colum_cnf[] = array('table_name'=>'travel_styles', 'col_name_db'=>'description', 	'col_name_alias'=>'style_description');

		$destination_travel_styles = update_i18n_data($destination_travel_styles, I18N_MULTIPLE_MODE, $table_cnf, $colum_cnf);

		return $destination_travel_styles;
	}

	function get_recommended_tours_by_destination($destination_id, $des_styles, $best_tour = null){

		$query_select = "(SELECT t.id, t.name, t.brief_description, t.url_title, t.picture_name, t.review_number, t. category_id, t.partner_id," .
				" t.total_score, t. main_destination_id, t. route, t.class_tours, ts.includes, ts.excludes,".
				" p.short_name as partner_name, t.cruise_id, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new";

		$query_ignore_best_tour = '';
		if(!empty($best_tour) && count($best_tour) > 0) {
			$query_ignore_best_tour = ' AND t.id !='.$best_tour[0]['id'] ;
		}

		$query_str = '';
		foreach ($des_styles as $key => $style) {

			$not_private = '';
			// Halong Bay Tours
			if($destination_id == 5 && $style['style_id'] != PRIVATE_TOUR && $style['style_id'] != DAY_TOUR) {
				$not_private = " AND t.class_tours NOT LIKE '%-".PRIVATE_TOUR."-%'";
				$not_day_tour = " AND t.class_tours NOT LIKE '%-".DAY_TOUR."-%'";
				$not_private .= $not_day_tour;
			}

			$query_str .= $query_select.
			" FROM tours as t".
			" JOIN partners as p on p.id = t.partner_id".
			" LEFT OUTER JOIN tour_services as ts on ts.tour_id = t.id".
			" LEFT OUTER JOIN cruises as c on c.id = t.cruise_id".
			" JOIN tour_destinations AS td ON td.tour_id= t.id".
			" WHERE td.destination_id = ". $destination_id .
			" AND td.is_land_tour = 1".
			" AND t.class_tours LIKE '%-".$style['style_id']."-%'".
			$not_private.
			" AND t.status = ". STATUS_ACTIVE.
			" AND t.deleted != ". DELETED.
			" AND p.deleted !=". DELETED.
			$query_ignore_best_tour.
			" GROUP BY t.id".
			" ORDER BY t.deal DESC".
			" LIMIT ".LIMIT_TOUR_ON_TAB.")";
			if($key+1 < count($des_styles)) $query_str .= " UNION ";
		}

		$query = $this->db->query($query_str);

		$tours = $query->result_array();

		return $tours;
	}

	/**
	  *  Replace get_recommended_tours_by_destination function
	  *
	  *  remove union query
	  *
	  *  @author toanlk
	  *  @since  Nov 10, 2014
	  */
	function get_tours_of_destination($destination_id, $des_styles, $best_tour = null)
	{
	    $query_select = "SELECT t.id, t.name, t.brief_description, t.url_title, t.picture_name, t.review_number, t. category_id, t.partner_id," .
	        " t.total_score, t. main_destination_id, t. route, t.class_tours, t.show_partner, ts.includes, ts.excludes,".
	        " p.short_name as partner_name, t.cruise_id, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new";

	    $query_ignore_best_tour = '';
	    if(!empty($best_tour) && count($best_tour) > 0) {
	        $query_ignore_best_tour = ' AND t.id !='.$best_tour[0]['id'] ;
	    }

	    $results = array();

	    foreach ($des_styles as $key => $style) {

	        $not_private = '';
	        // Halong Bay Tours
	        if($destination_id == 5 && $style['style_id'] != PRIVATE_TOUR && $style['style_id'] != DAY_TOUR) {
	            $not_private = " AND t.class_tours NOT LIKE '%-".PRIVATE_TOUR."-%'";
	            $not_day_tour = " AND t.class_tours NOT LIKE '%-".DAY_TOUR."-%'";
	            $not_private .= $not_day_tour;
	        }

	        $query_str = $query_select.
	        " FROM tours as t".
	        " JOIN partners as p on p.id = t.partner_id".
	        " LEFT OUTER JOIN tour_services as ts on ts.tour_id = t.id".
	        " LEFT OUTER JOIN cruises as c on c.id = t.cruise_id".
	        " JOIN tour_destinations AS td ON td.tour_id= t.id".
	        " WHERE td.destination_id = ". $destination_id .
	        " AND td.is_land_tour = 1".
	        " AND t.class_tours LIKE '%-".$style['style_id']."-%'".
	        $not_private.
	        " AND t.status = ". STATUS_ACTIVE.
	        " AND t.deleted != ". DELETED.
	        " AND (t.language_id = 0 OR t.language_id = " . lang_id().")".
	        " AND p.deleted !=". DELETED.
	        $query_ignore_best_tour.
	        " GROUP BY t.id".
	        " ORDER BY t.deal DESC".
	        " LIMIT ".LIMIT_TOUR_ON_TAB;

	        $query = $this->db->query($query_str);

	        $tours = $query->result_array();

	        $results[$style['style_name']] = $tours;
	    }

	    return $results;
	}

	function getTopParentDestinations()
	{
		$this->db->select('id,name,region,picture_name,number_tours,url_title,parent_id');
		$this->db->where_in('id', array(VIETNAM, LAOS, CAMBODIA));
		$this->db->order_by('name', 'desc');

		$query = $this->db->get('destinations');

		$destinations =  $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		return $destinations;
	}

	function get_more_tours_by_destination($destination_id, $des_styles){

		$query_select = "SELECT t.id, t.name, t.brief_description, t.url_title, t.picture_name, t.review_number, t. category_id, t.partner_id," .
				" t.total_score, t. main_destination_id, t. route, t.class_tours, t.cruise_id, ts.includes, ts.excludes,".
				" p.short_name as partner_name, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new";

		$not_private = '';
		// Halong Bay Tours
		if($destination_id == 5 && $des_styles != PRIVATE_TOUR && $des_styles != DAY_TOUR) {
			$not_private = " AND t.class_tours NOT LIKE '%-".PRIVATE_TOUR."-%'";
			$not_day_tour = " AND t.class_tours NOT LIKE '%-".DAY_TOUR."-%'";
			$not_private .= $not_day_tour;
		}

		$lang_where = ' AND (t.language_id = 0 OR t.language_id = ' . lang_id().')';

		$query_str = $query_select.
			" FROM tours as t".
			" JOIN partners as p on p.id = t.partner_id".
			" LEFT OUTER JOIN cruises as c on c.id = t.cruise_id".
			" LEFT OUTER JOIN tour_services as ts on ts.tour_id = t.id".
			" JOIN tour_destinations AS td ON td.tour_id= t.id".
			" WHERE td.destination_id = ". $destination_id .
			" AND td.is_land_tour = 1".
			" AND t.class_tours LIKE '%-".$des_styles."-%'".
			  $not_private.
			  $lang_where.
			" AND t.status = ". STATUS_ACTIVE.
			" AND t.deleted != ". DELETED.
			" AND p.deleted !=". DELETED.
			" GROUP BY t.id".
			" ORDER BY t.deal DESC".
			" LIMIT ".LIMIT_MORE_TOUR;



		$query = $this->db->query($query_str);

		$tours = $query->result_array();

		return $tours;
	}

	function getDestinationStyleUrl($style_name)
    {
        $style_name = trim(strtolower($style_name));

        if ($style_name != 'mid-range')
        {
            $style_name = str_replace('-', ' ', $style_name);
            $style_name = str_replace('_', ' ', $style_name);
        }

        $this->db->select('*');
        $this->db->like("name", $style_name, "both");
        $this->db->where('deleted !=', DELETED);

        $query = $this->db->get('travel_styles');
        $results = $query->result_array();

        $table_cnf[] = array(
            'col_id_name' => 'id',
            'table_name' => 'travel_styles'
        );
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        if (count($results) > 0)
        {
            return $results[0];
        }

        return null;
    }

	function getSystemTourTypes() {
		$this->db->select('id, name');
		$this->db->where('id <=', 4);

		$query = $this->db->get('travel_styles');
		$results = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'travel_styles');
		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;
	}

	function get_tour_detail_itinerary($id) {
		$this->db->where('tour_id', $id);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('detail_itinerary');
		$results = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'detail_itinerary');

		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);


		foreach ($results as $key=>$value){

			if(!empty($value['photos'])){

				$value['itinerary_photos'] = get_tour_itinerary_photos($value['photos']);

			}

			$results[$key] = $value;
		}

		return $results;
	}

	function get_photo_description($type, $picture_name) {
		$results = array();

		if($type == 'cruise_') {
			$this->db->where('name', $picture_name);
			$query = $this->db->get('cruise_photos');
			$results = $query->result_array();

			if(!empty($results)) {
				return $results[0]['description'];
			}
		} else {
			$this->db->where('picture_name', $picture_name);
			$query = $this->db->get('tour_photos');
			$results = $query->result_array();

			if(!empty($results)) {
				return $results[0]['comment'];
			}
		}

		return '';
	}

	function get_popular_cruises($cruise_port = ''){

		$this->db->where('status', STATUS_ACTIVE);

		$this->db->where('deleted !=', STATUS_ACTIVE);

		$this->db->where('num_cabin !=', 0);

		$this->db->where('cabin_type !=', 2);

		$this->db->where('( language_id = 0 OR language_id = '.lang_id().')');

		if ($cruise_port != ''){

			$this->db->where('cruise_destination', $cruise_port);
		}

		$this->db->order_by('deal','desc');

		$this->db->limit(20);

		$query = $this->db->get('cruises');

		$results = $query->result_array();

		return $results;

	}

	function getTourTravelStype($str_class_tours, $cruise_destination) {

		$class_tours = explode('-', $str_class_tours);

		// Halong Cruise Tour
		if($cruise_destination == 0) {
			$class_id = $class_tours[0];

			if(in_array(PRIVATE_TOUR, $class_tours)) {
				$class_id = PRIVATE_TOUR;
			}
			if(in_array(DAY_TOUR, $class_tours)) {
				$class_id = DAY_TOUR;
			}
		} else {	// Mekong Cruise Tour
			$class_id = 10;
			foreach ($class_tours as $class) {
				if(in_array($class, array(11,12,13,14))) {
					$class_id = $class;
					break;
				}
			}
		}

		$this->db->select('id, name');
		$this->db->where('id', $class_id);
		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get('travel_styles');
		$travel_styles = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'travel_styles');
		$travel_styles = update_i18n_data($travel_styles, I18N_MULTIPLE_MODE, $table_cnf);


		if(!empty($travel_styles)) {
			return $travel_styles[0];
		}

		return null;
	}


	function get_recommended_Vietnam_tours() {

		$this->db->select('t.*,p.short_name as partner_name');
		$this->db->join('tour_destinations td', 'td.tour_id = t.id', 'left outer');
		$this->db->join('partners p', 't.partner_id = p.id', 'left outer');
		$this->db->where('td.is_land_tour', 1);
		$this->db->where('t.status', STATUS_ACTIVE);
		$this->db->where('t.deleted !=', DELETED);
		$this->db->where('td.destination_id =', 235);	// Vietnam

		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->order_by('t.deal','desc');

		$this->db->limit(1);
		$query = $this->db->get('tours t');

		$recommended_Vietnam_tours = $query->result_array();

		if(count($recommended_Vietnam_tours) >0){

			return $recommended_Vietnam_tours[0];
		}

		return NULL;

	}

	function get_tour_hot_deal_info($tour_id){

		$today = date('Y-m-d');

		$this->db->distinct();

		$this->db->select('t.id, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note, p.apply_for_hanoi, p.promotion_type, p.day_before, pd.note as offer');

		$this->db->from('promotion_details as pd');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->join('tours as t', 't.id = pd.tour_id');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('t.id', $tour_id);

		$this->db->where('p.status', STATUS_ACTIVE);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('p.is_hot_deals', STATUS_ACTIVE);

		$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
		$this->db->where($p_where);

		$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
		$this->db->where($p_where);

		$lang_where = '(p.language_id = 0 OR p.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->order_by('p.order_', 'ASC');

		$query = $this->db->get();

		$results = $query->result_array();

		//$results = get_promotion_hot_deals('id', $results);

		$results = get_tour_by_promotion_allow_in_vietnam($results);

		$results = $this->get_travel_dates($results);

		return $results;
	}

	function get_cruise_hot_deal_info($cruise_id, $url_title){

		$today = date('Y-m-d');

		$this->db->distinct();

		$this->db->select('t.id, p.id as promotion_id, p.name, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.note,p.apply_for_hanoi, p.promotion_type, p.day_before, pd.note as offer');

		$this->db->from('promotion_details as pd');

		$this->db->join('promotions as p', 'p.id = pd.promotion_id');

		$this->db->join('tours as t', 't.id = pd.tour_id');

		$this->db->where('pd.deleted !=', DELETED);

		$this->db->where('t.cruise_id', $cruise_id);

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

		$results = $this->get_travel_dates($results);

		//$results = get_promotion_hot_deals('id', $results);

		$results = get_tour_by_promotion_allow_in_vietnam($results);

		$temp = array();

		foreach ($results as $promotion){

			$temp[$promotion['promotion_id']] = $promotion;

		}

		$results = array_values($temp);

		return $results;

	}

	function get_tour_hot_deals_by_destination($destination_id) {

		$hot_deals = array ();

		// get all tour ids in a destination
		$this->db->distinct ();

		$this->db->select ( 'td.tour_id' );

		$this->db->from ( 'tour_destinations as td' );

		$this->db->join ( 'tours as t', 't.id = td.tour_id' );

		$this->db->join ( 'partners as p', 'p.id = t.partner_id' );

		$this->db->where ( 'td.destination_id', $destination_id );

		$this->db->where ( 'td.is_land_tour', STATUS_ACTIVE );

		$this->db->where ( 't.status', STATUS_ACTIVE );

		$this->db->where ( 't.deleted !=', DELETED );
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);

		$this->db->where ( 'p.deleted !=', DELETED );

		$query = $this->db->get ();

		$results = $query->result_array ();

		$tour_ids = array ();

		foreach ( $results as $value ) {
			$tour_ids [] = $value ['tour_id'];
		}

		if (! empty ( $tour_ids )) {

			// get hot deals
			$today = date ( 'Y-m-d' );

			$this->db->distinct ();

			$this->db->select ( 't.id, t.name, t.url_title, t.picture_name as picture, t.class_tours, p.id as promotion_id, p.name as promotion_name, p.note, p.start_date, p.end_date, p.book_to as expiry_date, p.is_specific_dates, p.order_promotion, p.apply_for_hanoi, p.promotion_type, p.day_before' );

			$this->db->from ( 'promotion_details as pd' );

			$this->db->join ( 'promotions as p', 'p.id = pd.promotion_id' );

			$this->db->join ( 'tours as t', 't.id = pd.tour_id' );

			$this->db->where ( 'pd.deleted !=', DELETED );

			$this->db->where ( 'pd.visibility', STATUS_ACTIVE );

			$this->db->where ( 'p.status', STATUS_ACTIVE );

			$this->db->where ( 'p.deleted !=', DELETED );

			$this->db->where ( 'p.is_hot_deals', STATUS_ACTIVE );

			$p_where = "(p.end_date is NULL OR p.end_date >='" . $today . "')";
			$this->db->where ( $p_where );

			$p_where = "(p.book_to is NULL OR p.book_to >='" . $today . "')";
			$this->db->where ( $p_where );

			$this->db->where_in ( 't.id', $tour_ids );

			$this->db->order_by ( 'pd.order_new', 'ASC' );

			$query = $this->db->get ();

			$hot_deals = $query->result_array ();

			$hot_deals = $this->get_travel_dates ( $hot_deals );

			foreach ( $hot_deals as $key => $value ) {

				$value ['offer_rate'] = 0;

				$value ['offer_note'] = '';

				$value ['from_price'] = 0;

				$offer_date = $value ['start_date'];

				if ($value ['is_specific_dates'] && count ( $value ['specific_dates'] ) > 0) {

					$offer_date = $value ['specific_dates'] [0] ['date'];

				}

				$prices = $this->get_tour_from_price ( $value ['id'], $offer_date, false );

				if ($prices) {

					$value ['from_price'] = $prices ['from_price'];

					$value ['offer_rate'] = $prices ['offer_rate'];

					$value ['offer_note'] = $prices ['offer_note'];
				}

				$value ['selling_price'] = $value ['from_price'] - round ( $value ['from_price'] * $value ['offer_rate'] / 100, 0 );

				$hot_deals [$key] = $value;

			}
		}

		$hot_deals = get_tour_by_promotion_allow_in_vietnam ( $hot_deals );

		return $hot_deals;

	}

	function get_rich_snippet_destination_review($destination_id) {
		$this->db->select('gr.total_review_score');
		$this->db->from('guest_reviews AS gr');
		$this->db->join('tours AS t', 'gr.review_for_id = t.id', 'left');
		$this->db->join('tour_destinations AS td', 'td.tour_id= t.id', 'left');
		$this->db->where_in('td.destination_id', $destination_id);
		if(count($destination_id) == 1) {
			$this->db->where('td.is_land_tour =', 1);
		}
		$this->db->where('t.deleted !=', DELETED);
		$this->db->where('gr.deleted !=', DELETED);

		$query = $this->db->get();
		$reviews = $query->result_array();

		$review_numb = count($reviews);

		// return empty
		if($review_numb == 0) return null;

		$total_score = 0;
		foreach ($reviews as $review) {
			$total_score += $review['total_review_score'];
		}
		$review_score = number_format($total_score/$review_numb, 1);

		return array('review_score' => $review_score, 'review_numb' => $review_numb);
	}

	function get_cruise_includes($cruise_id){

		$this->db->select('ts.tour_id, ts.includes, ts.excludes');

		$this->db->from('tour_services as ts');

		$this->db->join('tours as t', 'ts.tour_id = t.id');


		$departure_date = date(DB_DATE_FORMAT);

		$pr_where = "tp.tour_id = t.id";

		$pr_where .= " AND (tp.from_date <='" . $departure_date . "'";

		$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

		$pr_where .= " AND tp.deleted != 1";


		$this->db->join('tour_prices as tp', $pr_where, 'left outer');


		$this->db->where('t.cruise_id', $cruise_id);

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->order_by('t.duration', 'asc');

		$this->db->order_by('tp.from_price', 'asc');

		$this->db->limit(1);

		$query = $this->db->get();

		$results = $query->result_array();

		if (count($results) > 0){

			return $results[0];
		} else {
			return '';
		}
	}

	function get_hot_deal_price_from($tour_id, $promotion_id, $departure_date){

		$this->db->select('tp.from_price, tp.accommodation_id, tp.tour_id');

		$this->db->where('tp.tour_id', $tour_id);

		if ($departure_date != '') {

			$departure_date = $this->timedate->format($departure_date, DB_DATE_FORMAT);

			$pr_where = "(tp.from_date <='" . $departure_date . "'";

			$pr_where .= " AND (tp.to_date is NULL OR tp.to_date >='" . $departure_date . "'))";

			$this->db->where($pr_where);
		}

		$this->db->where('tp.deleted !=', DELETED);

		$this->db->order_by('tp.from_price', 'asc');

		$query = $this->db->get('tour_prices tp');

		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)
		$prices = update_tour_price_to_net_price($prices);

		if (count($prices) > 0){
			$price = $prices[0];

			$this->db->select('pd.id, pd.offer_rate, pd.note');
			$this->db->from('promotion_details as pd');
			$this->db->where('pd.tour_id', $tour_id);
			$this->db->where('pd.accommodation_id', $price['accommodation_id']);
			$this->db->where('pd.promotion_id', $promotion_id);
			$this->db->where('pd.deleted !=', DELETED);

			$query = $this->db->get();
			$promotions = $query->result_array();

			$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'promotion_details');
			$promotions = update_i18n_data($promotions, I18N_MULTIPLE_MODE, $table_cnf);

			if (count($promotions) > 0){

				$promotion = $promotions[0];

				$price['offer_rate'] = $promotion['offer_rate'];

				$price['offer_note'] = $promotion['note'];

			} else {

				$price['offer_rate'] = 0;

				$price['offer_note'] = '';

			}

			return $price;
		}

		return false;
	}

	function get_all_tours_for_search_filters($search_criteria){

		$this->db->select('t.id, t.route_ids, t.duration, t.class_tours, t.activity_ids, c.cabin_index, c.cruise_facility_ids, c.has_triple_family');

		$this->db->from('tours as t');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);
		
		// internationalization: khuyenpv 21/03/2015
		$lang_where = '(t.language_id = 0 OR t.language_id = ' . lang_id().')';
		$this->db->where($lang_where);
		

		$this->db->where('p.deleted !=', DELETED);


		if (!empty($search_criteria['destination_ids'])){

			$value = $search_criteria['destination_ids'];

			$arr = explode(',', $value);

			foreach ($arr as $des_id) {
				$this->db->like("route_ids", "-".$des_id."-", "both");
			}

		}

		// travel style condition
		if (!empty($search_criteria['travel_styles'])){

			$value = $search_criteria['travel_styles'];

			if ($value != '' && count($value) > 0) {

				if (count($value) == 1) {

					$this->db->like('t.category_id', $value[0]);

				} else {

					$query_cat = "(";
					$cnt = 0;
					foreach ($value as $cat) {
						if($cnt > 0) {
							$query_cat .= " OR ";
						}
						$query_cat = $query_cat."`t`.`category_id` LIKE '%".$cat."%'";
						$cnt++;
					}
					$query_cat .= ')';
					$this->db->where($query_cat);
				}
			}

		}

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
	}

	// check tour name history

	function checkTourURLHistory($url_title) {

		$this->db->select('t.*,p.id as partner_id, p.short_name as partner_name, c.cruise_destination, c.is_new, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star');
		$this->db->from('tours t');
		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');
		$this->db->join('partners p', 'p.id = t.partner_id');

		$this->db->like('t.url_title_history', $url_title);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$query = $this->db->get('tours');

		$tours = $query->result_array();

		foreach ($tours as $tour) {
			$url_title_history = $tour['url_title_history'];

			$arr_name = explode(',', $url_title_history);
			foreach ($arr_name as $str_name) {
				if($str_name == $url_title) {

					$crs = array();
					$crs[] = $tour;
					return $crs;
				}
			}
		}

		//$str = $this->db->last_query();

		return null;
	}

	function check_promo_code($code) {

		$this->db->select('pc.*, cb.promotion_code as cb_code');
		$this->db->from('promotion_code as pc');

		$this->db->join('customer_bookings as cb', 'cb.promotion_code = pc.code', 'left outer');
		$this->db->where('pc.code', $code);

		$this->db->where('pc.deleted !=', DELETED);
		$this->db->where('cb.promotion_code IS NULL');
		$this->db->where('pc.expired_date > NOW()');
		//expire IS NULL
		$query = $this->db->get();

		$promotion_codes = $query->result_array();

		if(!empty($promotion_codes)) {
			return true;
		}

		return false;
	}

	/**
	 * Minh Tin 14.11.2014
	 * Get all the Id of the object with the same object
	 */
	function get_group_object_by_language($review_for_ids, $reviewForType, $table_name = ''){

		$ret = $review_for_ids;
		
		if(empty($review_for_ids)) return array();

		if ($table_name == ''){

			if ($reviewForType == CRUISE || $reviewForType == TOUR){

				$table_name = 'tours';

			}if ($reviewForType == HOTEL){

				$table_name = 'hotels';

			}
		}


		// if the current object is Spanish or France
		$this->db->select('origin_id');
		$this->db->from($table_name);
		$this->db->where_in('id', $review_for_ids);
		$this->db->where('status', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get();
		$results = $query->result_array();

		foreach ($results as $obj){
			$ret[] = $obj['origin_id'];
		}

		// if the current object is English
		$this->db->select('id');
		$this->db->from($table_name);
		$this->db->where_in('origin_id', $review_for_ids);
		$this->db->where('status', STATUS_ACTIVE);
		$this->db->where('deleted !=', DELETED);
		$query = $this->db->get();
		$results = $query->result_array();

		foreach ($results as $obj){
			$ret[] = $obj['id'];
		}

		return $ret;
	}
}

?>