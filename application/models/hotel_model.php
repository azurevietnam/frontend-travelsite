<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();

        $this->load->library(array('TimeDate'));

        $this->load->helper('Hotel');
	}

    /**
     * Common Hotel SQL Conditions
     *
     * @author TinVM
     * @since 10.06.2015
     */
    function _common_hotel_condition($alias = 'h.'){

        $this->db->where($alias.'status', STATUS_ACTIVE);

        $this->db->where($alias.'deleted !=', DELETED);

        $this->db->where('('.$alias.'language_id = 0 OR '.$alias.'language_id = ' . lang_id() . ')');
    }

	/**
	 * Search Hotel for Search Hotel Autocomplete Functions
	 *
	 * @author Khuyenpv
	 * @since  05.04.2015
	 */
	function search_hotel_auto($name){

		$this->db->select('h.id, h.name, d.name as parent_name');

		$this->db->from('hotels h');

		$this->db->join('destinations d', 'd.id = h.destination_id', 'left outer');;

		$this->db->where('h.deleted !=', DELETED);

		$this->db->where('h.status', STATUS_ACTIVE);

		$name = urldecode($name);
		$this->db->like('h.name', $name);

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
	}

	/**
	 * Count number of hotels for Recommend More Hotel
	 *
	 * @autho Khuyenpv
	 * @since 06.04.2015
	 */
	function count_recommend_more_hotels($search_criteria)
	{
		$this->db->from('hotels as h');

		$this->_build_recommend_more_hotel_conditions($search_criteria);

		return $this->db->count_all_results();
	}

	/**
	 * Recommend More Hotels
	 *
	 * @author Khuyenpv
	 * @since 06.04.2015
	 */
	function recommend_more_hotels($search_criteria, $start_date, $offset = 0, $limit = 5){

		$this->load->model('HotelModel'); // load the old hotel-model

		$start_date = date(DB_DATE_FORMAT, strtotime($start_date));

		$end_date = date(DB_DATE_FORMAT, strtotime($start_date . " +1 day"));


		$this->db->select('h.id, h.name, h.url_title, h.picture, h.star, h.is_new, h.destination_id, h.review_number, h.total_score, h.location');

		$this->db->from('hotels as h');

		$this->_build_recommend_more_hotel_conditions($search_criteria);

		$this->_build_order_condtions($search_criteria);

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		$results = $query->result_array();

		// call to old hotel model to get hotel price from
		$results = $this->HotelModel->get_hotels_price_optimize($results, $start_date, $end_date);

		return $results;
	}


 	/**
     * Build Recommend SQL condition
     *
     * @author Khuyenpv
     * @since 05.04.2015
     */
    function _build_recommend_more_hotel_conditions($search_criteria){

    	if(!empty($search_criteria['hotel_id'])){
    		$this->db->where('id', $search_criteria['hotel_id']);
    	} else {
    		$this->db->where('destination_id', $search_criteria['destination_id']);
    	}

    	if(!empty($search_criteria['stars'])){
    		$this->db->where_in('star', $search_criteria['stars']);
    	}

    	$sql_lang = '(h.language_id = 0 OR h.language_id = '.lang_id().')';
    	$this->db->where($sql_lang);

    	$this->db->where('h.status', STATUS_ACTIVE);
    	$this->db->where('h.deleted !=', DELETED);
    }

    /**
     * Build the common hotel order conditions
     *
     * @author Khuyepv
     * @since 06.04.2015
     */
    function _build_order_condtions($search_criteria){
    	if(!empty($search_criteria['sort_by'])){
    		$sort_by = $search_criteria['sort_by'];
    		switch ($sort_by) {
    			case SORT_BY_STAR_5_1:
    				$this->db->order_by('h.star', 'desc');
    				break;
    			case SORT_BY_STAR_1_5:
    				$this->db->order_by('h.star', 'asc');
    				break;
    			case SORT_BY_REVIEW_SCORE:
    				$this->db->order_by('h.total_score', 'desc');
    				break;
    			default :
    				$this->db->order_by('h.deal', 'desc');
    				break;
    		}
    	}
    }

    /**
     *
     * Get Hotel detail information
     *
     * @author Khuyenpv
     * @since 06.05.2015
     */
    function get_hotel_detail($url_title){

    	$this->db->select('id, name, url_title, star, destination_id, partner_id, location, description, picture, total_score, review_number, check_in, check_out, cancellation_prepayment, children_extra_bed, note');

    	$this->db->from('hotels');

    	$this->db->where('deleted != ', DELETED);

    	$this->db->where('url_title', $url_title);

    	$query = $this->db->get();

    	$hotels = $query->result_array();

    	return count($hotels) > 0 ? $hotels[0] : FALSE;
    }

    /**
     * Get all the photos of the hotels
     *
     * @author Khuyenpv
     * @since 15.04.2015
     */
    function get_hotel_photos($hotel_id){

    	$this->db->select('id, name, description as caption');

    	$this->db->where('hotel_id', $hotel_id);

    	$this->db->order_by('order_', 'asc');

    	$query = $this->db->get('hotel_photos');

    	$results = $query->result_array();

    	return $results;
    }

    /**
     * Get all the hotel rooms
     *
     * @author Khuyenpv
     * @since 15.04.2015
     */
    function get_hotel_rooms($hotel_id){

    	$this->db->select('id, name, description, picture, extra_bed_allow, max_person, max_room, room_size, bed_size');

    	$this->db->where('hotel_id', $hotel_id);

    	$this->db->where('status', STATUS_ACTIVE);

    	$this->db->where('deleted !=', DELETED);

    	$this->db->order_by('order_', 'asc');

    	$query = $this->db->get('room_types');

    	$results = $query->result_array();

    	return $results;
    }

    /**
     * Get Hotel Facilities
     * @author TinVM
     * @since Jun19 2015
     */
    function get_hotel_facilities($hotel_id){

        $this->db->select('f.id, f.name, f.important, f.hotel_facility_type');

        $this->db->from('hotel_facilities as hf');

        $this->db->join('facilities as f', 'f.id = hf.facility_id');

        $this->db->where('hf.hotel_id', $hotel_id);

        $this->db->where('hf.value', STATUS_ACTIVE);

        $this->db->where('f.status', STATUS_ACTIVE);

        $this->db->where('f.deleted !=', DELETED);

        $this->db->order_by('f.name', 'asc');

        $query = $this->db->get();

        return $query->result_array();

    }

    /**
     * Get all the hotel room facilities
     *
     * @author Khuyenpv
     * @since 15.04.2015
     */
    function get_hotel_room_facilities($room_types){

    	if(empty($room_types)) return array();

    	$room_type_ids = array();
    	foreach ($room_types as  $room){
    		$room_type_ids[] =  $room['id'];
    	}

    	$this->db->select('f.id, f.name, f.important, hf.room_type_id');

    	$this->db->from('hotel_facilities as hf');

    	$this->db->join('facilities as f', 'f.id = hf.facility_id');

    	$this->db->where_in('hf.room_type_id', $room_type_ids);

    	$this->db->where('hf.value', STATUS_ACTIVE);

    	$this->db->where('f.status', STATUS_ACTIVE);
    	$this->db->where('f.deleted !=', DELETED);

    	$this->db->order_by('f.name');

    	$query = $this->db->get();

    	$hotel_facilities = $query->result_array();

    	foreach ($room_types as $key => $room){

    		$room['facilities'] = array();

    		foreach ($hotel_facilities as $value){

    			if($value['room_type_id'] == $room['id']){

    				$room['facilities'][] = $value;

    			}
    		}

    		$room_types[$key] = $room;
    	}

    	return $room_types;

    }

    /**
     * Get hotel top destinations
     * TinVM May20 2015
     */

    function get_top_hotel_destinations(){

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

    /**
     * Get hotel destinations
     * TinVM May20 2015
     */

    function get_hotel_destinations(){

        $this->db->select('id, name, url_title, is_top_hotel, number_hotels');

        $this->db->where('deleted != ', DELETED);

        $this->db->where('number_hotels > ', 0);

        $this->db->order_by('order_', 'ASC');

        $query = $this->db->get('destinations');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;

    }

    /**
     * Get list hotel by top destinations
     * @author TinVM
     * @since May25 2015
     * @return list hotel
     */

    function get_hotels_by_destination($destination_id, $limit = LIMIT_HOTEL_ON_TAB, $offset = 0){

        $this->db->select('id, name, language_id, url_title, location, description, star, picture, total_score, review_number, is_new, destination_id, number_of_room');

        $this->db->from('hotels');

        $this->db->where('destination_id', $destination_id);

        $this->_common_hotel_condition('');

        $this->db->order_by('deal', 'desc');

        $this->db->limit($limit, $offset);

        $query = $this->db->get();

        return $query->result_array();
    }

    /**
     * Get count number hotel in destination
     * @author TinVM
     * @since July21 2015
     * @return number hotels
     */

    function count_nr_hotel_in_destination($destination_id){

        $this->db->from('hotels');

        $this->db->where('destination_id', $destination_id);

        $this->db->where('deleted != ', DELETED);

        $this->_common_hotel_condition('');

        return $nr_hotels = $this->db->count_all_results();
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

    /**
      * get_hotel_price_from_ajax
      *
      * @author toanlk
      * @since  Jun 23, 2015
      */
    function get_hotel_price_from_ajax($hotel_ids, $arrival_date){

        if(empty($hotel_ids)) return array();

        $arrival_date = date(DB_DATE_FORMAT, strtotime($arrival_date));
        $departure_date = $arrival_date;

		$this->db->where_in('hotel_id', $hotel_ids);
		$this->db->where('deleted !=', DELETED);
		$pr_where = "(start_date <='" . $arrival_date . "'";
		$pr_where .= " AND (end_date is NULL OR end_date >='" . $arrival_date . "'))";
		$this->db->where($pr_where);
		$query = $this->db->get('hotel_prices');
		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)
		$prices = update_hotel_price_to_net_price($prices);

        foreach ($hotel_ids as $hotel_id)
        {
            foreach ($prices as $price)
            {
                if ($price['hotel_id'] == $hotel_id)
                {
                    $offer_rate = 0;
                    $price_origin   = $price['price_from'];
                    $price_from     = $price['price_from'];

                    if(!empty($price['room_type_id'])) {
                        $promotion_details = $this->get_all_hotel_promotion_details($hotel_id, $arrival_date, $departure_date);
                        $promotion_detail = $this->getPromotionDetailByDate($price['room_type_id'], $arrival_date, $promotion_details);

                        if(!empty($promotion_detail)){

                            $offer_rate = (!empty($promotion_detail['offer_rate'])) ? $promotion_detail['offer_rate'] : 0;

                            // reset offer rate to 0 if promotion is stay x pay y
                            if ($promotion_detail['stay'] > 0 && $promotion_detail['pay'] > 0){

                                $offer_rate = 0;
                            }
                        }
                    }

                    $price_from = (1 - $offer_rate / 100) * $price_from;

                    break;
                }
            }

            $ret[] = array(
                'id'            => $hotel_id,
                'price_origin'  => isset($price_origin) ? round($price_origin) : 0,
                'price_from'    => isset($price_from) ? round($price_from) : 0,
            );
        }

        return $ret;
    }

    /**
     * Get Price Form for list of hotels
     *
     * @author TinVm
     * @since Jun 10 2015
     */
    function get_hotel_price_froms($hotels, $arrival_date){

        if(empty($hotels)) return $hotels;

        $hotel_ids = array_column($hotels, 'id');

        $arrival_date = date(DB_DATE_FORMAT, strtotime($arrival_date));
        $departure_date = $arrival_date;

		$this->db->where_in('hotel_id', $hotel_ids);
		$this->db->where('deleted !=', DELETED);
		$pr_where = "(start_date <='" . $arrival_date . "'";
		$pr_where .= " AND (end_date is NULL OR end_date >='" . $arrival_date . "'))";
		$this->db->where($pr_where);
		$query = $this->db->get('hotel_prices');
		$prices = $query->result_array();

		// 06.02.2014: update price from to NET PRICE (85% SELLING PRICE)
		$prices = update_hotel_price_to_net_price($prices);

		foreach ($hotels as $key => $hotel) {

		    foreach ($prices as $price)
		    {
		        if ($price['hotel_id'] == $hotel['id'])
		        {
		            $offer_rate = 0;
		            $price_origin   = $price['price_from'];
		            $price_from     = $price['price_from'];

		            if(!empty($price['room_type_id'])) {
		                $promotion_details = $this->get_all_hotel_promotion_details($hotel['id'], $arrival_date, $departure_date);
		                $promotion_detail = $this->getPromotionDetailByDate($price['room_type_id'], $arrival_date, $promotion_details);

		                if(!empty($promotion_detail)){

		                    $offer_rate = (!empty($promotion_detail['offer_rate'])) ? $promotion_detail['offer_rate'] : 0;

		                    // reset offer rate to 0 if promotion is stay x pay y
		                    if ($promotion_detail['stay'] > 0 && $promotion_detail['pay'] > 0){

		                        $offer_rate = 0;
		                    }
		                }
		            }

		            $price_from = (1 - $offer_rate / 100) * $price_from;

		            break;
		        }
		    }

		    $price['price_origin']    = isset($price_origin) ? round($price_origin) : 0;
            $price['price_from']      = isset($price_from) ? round($price_from) : 0;

            $hotel['price'] = $price;
		    $hotels[$key] = $hotel;
		}

        return $hotels;
    }

    /**
      * get_hotel_special_offers
      *
      * @author toanlk
      * @since  Jun 27, 2015
      */
    function get_hotel_special_offers($hotels){

        if(empty($hotels)) return $hotels;

        $hotel_ids = array_column($hotels, 'id');

		$today = date(DB_DATE_FORMAT);

		$this->db->select('p.id, p.name, p.book_from, p.book_to, p.stay_from, p.stay_to, p.check_in_on, p.note, p.promotion_condition,
						   p.is_specific_dates, p.promotion_type, pt.note as offer_note, p.day_before, h.id as hotel_id');

		$this->db->from('promotion_tours as pt');

		$this->db->join('hotels as h', 'h.id = pt.hotel_id');

		$this->db->join('promotions as p', 'p.id = pt.promotion_id');

		$this->db->where('pt.note != ','');

		if(empty($departure_date)){ // no departure_date specify => get all the promotion available

			// promotion in the future
			$this->db->where('p.stay_to >= ', $today);
			$this->db->where('p.book_to >= ', $today);
			$this->db->where('p.display_on & '. pow(2,date('w',strtotime($today))).' > 0');

			$this->db->where('p.status', STATUS_ACTIVE);

			$this->db->where('p.deleted !=', DELETED);

			$this->db->where('p.is_hot_deals', STATUS_ACTIVE); // only show hot-deal

			if (is_visitor_in_hanoi())
            {
				$this->db->where('p.apply_for_hanoi', STATUS_ACTIVE); // if Hanoi Visitor: only show Promotion apply for Hanoi
			}

		} else {

			$pro_sql = create_tour_promotion_condition($departure_date);
			$this->db->where($pro_sql);
		}

		$this->db->where_in('h.id', $hotel_ids);

		$this->db->order_by('p.position','asc');

		$query = $this->db->get();

		$promotions = $query->result_array();
		
		$promotions = $this->get_travel_dates($promotions);

		foreach ($hotels as $key => $hotel){

			$hotel['promotions'] = array();

			foreach ($promotions as $pro){

				if($pro['hotel_id'] == $hotel['id']){

					$is_added = false;

					foreach ($hotel['promotions'] as $v){
						if($pro['id'] == $v['id']) $is_added = true;
					}

					if(!$is_added){
						$hotel['promotions'][] = $pro;
					}
				}

			}

			$hotels[$key] = $hotel;

		}

		return $hotels;
    }

    /**
     * Count the number of hotels based on search criteria
     *
     * @author TinVM
     * @since Jun 10 2015
     */
    function count_total_hotel_search_results($search_criteria){

        $this->db->from('hotels as h');

        $this->_build_hotel_search_conditions($search_criteria);

        return $this->db->count_all_results();

    }

    /**
     * Build the common using of search conditions
     *
     * @author Khuyenpv
     * @since March 14 2015
     */
    function _build_hotel_search_conditions($search_criteria){
		
    	if(!empty($search_criteria['destination_id'])){
    		$this->db->where('h.destination_id', $search_criteria['destination_id']);
    	}
    	
    	if(!empty($search_criteria['hotel_id'])){
    		$this->db->where('h.id', $search_criteria['hotel_id']);
    	}

        if(!empty($search_criteria['stars'])){
            $this->db->where_in('h.star', $search_criteria['stars']);
        }

        $this->_common_hotel_condition();
    }

    /**
     * Search Hotels
     *
     * @author TinVM
     * @since Jun 10 2015
     */
    function search_hotels($search_criteria){

        $start_date = $search_criteria['start_date'];

        $sort_by = $search_criteria['sort_by'];

        $start_date = date(DB_DATE_FORMAT, strtotime($start_date));

        $per_page = $this->config->item('per_page');

        $this->db->from('hotels as h');

        $this->_build_hotel_search_conditions($search_criteria);

        switch ($sort_by){

            case SORT_BY_RECOMMEND:
                break;

            case SORT_BY_STAR_5_1:
                $this->db->order_by('h.star','desc');
                break;

            case SORT_BY_STAR_1_5:
                $this->db->order_by('h.star','asc');
                break;

            case SORT_BY_REVIEW_SCORE:
                $this->db->order_by('h.review_number', 'desc');
                break;
        }
        $this->db->order_by('h.deal');

        $offset = !empty($search_criteria['page']) ? $search_criteria['page'] : 0;

        $this->db->limit($per_page, $offset);

        $query = $this->db->get();

        $results = $query->result_array();

        $results = $this->get_hotel_special_offers($results);

        $results = $this->get_hotel_price_froms($results, $start_date);

        return $results;
    }

    /**
     * Get Room Type
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get Room Type price
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Calculate Stay x pay promotion price
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Calculate normal promotion price
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get Room Type price by date
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get promotion detail by date
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get all hotel promotion details
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get Travel date
     * @author TinVm
     * @since Jun12 2015
     */
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

    /**
     * Get all room type prices
     * @author TinVM
     * @since Jun12 2015
     */
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

    /**
     * Get Price from
     * @author TinVM
     * @since Jun12 2015
     */
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

        $hotel['price'] = update_hotel_price_value_to_net($price);

        $hotel['promotion_price'] = update_hotel_price_value_to_net($promotion_price);;

        return $hotel;
    }

    /**
     * Get Similar Hotels
     * @author TinVM
     * @since Jun22 2015
     */
    function get_similar_hotels($hotel){

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

    /**
      * get_hotel_optional_services
      *
      * @author toanlk
      * @since  Jun 24, 2015
      */
    function get_hotel_optional_services($hotel_id, $staying_dates){

        if(empty($staying_dates)) return array('additional_charge'=>array(), 'transfer_services'=>array(), 'extra_services'=>array());

        $start_date = $staying_dates[0];

        $end_date = $staying_dates[count($staying_dates) - 1];

        $start_date = date(DB_DATE_FORMAT, strtotime($start_date));

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
}