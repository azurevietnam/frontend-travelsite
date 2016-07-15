<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Common Tour SQL Conditions
	 *
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function _common_tour_condition($alias = 't'){

		$this->db->where($alias.'.status', STATUS_ACTIVE);

		$this->db->where($alias.'.deleted !=', DELETED);

		$this->db->where('('.$alias.'.language_id = 0 OR '.$alias.'.language_id = ' . lang_id() . ')');
	}

	/**
	 * Get Tour Price From for Ajax Price Loading
	 *
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function get_tour_price_from_ajax($tour_ids, $departure_date){

		if(empty($tour_ids)) return array();

		$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

		$this->db->select('tpf.price_origin, tpf.price_from, t.id as tour_id, p.is_hot_deals');

		$this->db->from('tour_price_froms as tpf');

		$this->db->join('tours as t', 't.id = tpf.tour_id');

		$pro_sql = create_tour_promotion_condition($departure_date);

		$this->db->join('promotions as p', 'p.id = tpf.promotion_id AND '.$pro_sql, 'left outer');

		$this->_common_tour_condition();

		$this->db->where_in('t.id', $tour_ids);

		$this->db->where('(tpf.start_date is NULL or tpf.start_date <="'.$departure_date.'")');

		$this->db->where('(tpf.end_date is NULL or tpf.end_date >="'.$departure_date.'")');
		
		$this->db->where('tpf.promotion_id = 0 or tpf.promotion_id=p.id');

		$this->db->order_by('tpf.price_from');

		$query = $this->db->get();

		$prices = $query->result_array();

		$ret = array();

		foreach($tour_ids as $tour_id){

			foreach ($prices as $value){

				if($value['tour_id'] == $tour_id){

					$ret[] = $value;

					break;
				}

			}


		}


		return $ret;
	}


	/**
	 * Get Price Form for list of tours
	 *
	 * @author Khuyenpv
	 * @since 02.04.2015
	 */
	function get_tour_price_froms($tours, $departure_date){

		if(empty($tours)) return $tours;

		$tour_ids = array();

		foreach ($tours as $tour){
			$tour_ids[] = $tour['id'];
		}

		$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

		$this->db->select('pr.price_origin, pr.price_from, pr.promotion_id, pr.tour_id, p.is_hot_deals');

		$this->db->from('tour_price_froms as pr');

		$sql_pro = create_tour_promotion_condition($departure_date);

		$this->db->join('promotions as p', 'p.id = pr.promotion_id AND '.$sql_pro, 'left outer');

		$this->db->where_in('pr.tour_id', $tour_ids);

		$this->db->where('(pr.start_date is NULL OR pr.start_date <= "'.$departure_date.'")');

		$this->db->where('(pr.end_date is NULL OR pr.end_date >= "'.$departure_date.'")');
		
		$this->db->where('pr.promotion_id = 0 or pr.promotion_id=p.id');

		$this->db->order_by('pr.price_from');

		$query = $this->db->get();

		$price_froms = $query->result_array();

		// set data for array of tours

		foreach ($tours as $key => $tour){

			$price = array();

			foreach ($price_froms as $pr){

				if($pr['tour_id'] == $tour['id']){

					$price = $pr;

					break;
				}
			}

			$tour['price'] = $price;

			$tours[$key] = $tour;
		}

		return $tours;
	}

	/**
	 * Get Normal Tour Discount in Rate-Table
	 *
	 * @author Khuyenpv
	 * @since 18.04.2015
	 */
	function get_tour_discount($tour_id, $start_date){

		$start_date = date(DB_DATE_FORMAT, strtotime($start_date));

		$this->db->select('discount');

		$this->db->from('tour_prices');

		$this->db->where('tour_id', $tour_id);

		$this->db->where('deleted !=', DELETED);

		$this->db->where('from_date <=', $start_date);

		$this->db->where('(to_date is NULL OR to_date >= "'.$start_date.'")');

		$query = $this->db->get();

		$prices = $query->result_array();

		if(count($prices) > 0){
			return $prices[0]['discount'];
		} else {
			return 0;
		}

	}

	/**
	  * get_tour_special_offers
	  *
	  * @author toanlk
	  * @since  Jun 27, 2015
	  */
	function get_tour_special_offers($tours, $departure_date = ''){

		if(empty($tours)) return $tours;

		$tour_ids = array_column($tours, 'id');

		$today = date(DB_DATE_FORMAT);

		$this->db->select('p.id, p.name, p.book_from, p.book_to, p.stay_from, p.stay_to, p.check_in_on, p.note, p.promotion_condition,
						   p.is_specific_dates, p.promotion_type, pt.note as offer_note, p.day_before,
						   t.id as tour_id');

		$this->db->from('promotion_tours as pt');

		$this->db->join('tours as t', 't.id = pt.tour_id');

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

			if(is_visitor_in_hanoi()){
				$this->db->where('p.apply_for_hanoi', STATUS_ACTIVE); // if Hanoi Visitor: only show Promotion apply for Hanoi
			}

		} else {

			$pro_sql = create_tour_promotion_condition($departure_date);
			$this->db->where($pro_sql);
		}

		$this->db->where_in('t.id', $tour_ids);

		$this->db->order_by('p.position','asc');

		$query = $this->db->get();

		$promotions = $query->result_array();

		$promotions = $this->get_travel_dates($promotions);

		foreach ($tours as $key=>$tour){

			$tour['promotions'] = array();

			foreach ($promotions as $pro){

				if($pro['tour_id'] == $tour['id']){

					$is_added = false;

					foreach ($tour['promotions'] as $v){
						if($pro['id'] == $v['id']) $is_added = true;
					}

					if(!$is_added){
						$tour['promotions'][] = $pro;
					}
				}

			}

			$tours[$key] = $tour;

		}

		return $tours;
	}

	/**
	 * Khuyenpv Feb 12 2015
	 * Get tours by destination & travel styles
	 */
	function get_tours_by_destination_travel_style($destination_id, $travel_style_id, $exclude_tour_id = null, $limit = 5, $offset = 0){

		$query_select = "t.id, t.name, t.brief_description, t.url_title, t.picture, t.review_number, t.category_id, t.partner_id, t.route_highlight, " .
				" t.tour_highlight, t.total_score, t.main_destination_id, t.route, t.class_tours, t.cruise_id, ts.includes, ts.excludes,t.show_partner,".
				" p.short_name as partner_name, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new";

		$this->db->select($query_select);

		$this->db->join('partners p', 'p.id = t.partner_id', 'left outer');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->join('tour_services ts', 'ts.tour_id = t.id', 'left outer');

		$this->db->join('tour_destinations td', 'td.tour_id = t.id', 'left outer');

		$this->db->join('tour_travel_styles tts', 'tts.tour_id = t.id', 'left outer');

		// halong bay tours:
		if ($destination_id == 5 && $travel_style_id != PRIVATE_TOUR && $travel_style_id != DAY_TOUR)
        {
            $this->db->where('tts.travel_style_id !=', PRIVATE_TOUR);
            $this->db->where('tts.travel_style_id !=', DAY_TOUR);
        }

        if(!empty($exclude_tour_id))
        {
            $this->db->where('t.id !=', $exclude_tour_id);
        }

		$this->db->where('td.destination_id', $destination_id);

		$this->db->where('tts.travel_style_id', $travel_style_id);

		$this->db->where('td.is_land_tour', 1);

		$this->_common_tour_condition();

		$this->db->where('p.deleted !=', DELETED);

		$this->db->group_by('t.id');

		$this->db->order_by('t.position', 'asc');

		if (! empty($offset))
		{
		    $this->db->limit($limit, $offset);
		}
		else
		{
		    $this->db->limit($limit);
		}

		$query = $this->db->get('tours t');

		$tours = $query->result_array();

		return $tours;
	}
	
	/**
	  * count_tours_by_destination_travel_style
	  *
	  * @author toanlk
	  * @since  Jun 16, 2015
	  */
	function count_tours_by_destination_travel_style($destination_id, $travel_style_id, $exclude_tour_id = null){
	    
	    $this->db->join('partners p', 'p.id = t.partner_id', 'left outer');
	    
	    $this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');
	    
	    $this->db->join('tour_services ts', 'ts.tour_id = t.id', 'left outer');
	    
	    $this->db->join('tour_destinations td', 'td.tour_id = t.id', 'left outer');
	    
	    $this->db->join('tour_travel_styles tts', 'tts.tour_id = t.id', 'left outer');
	    
	    // halong bay tours:
	    if ($destination_id == 5 && $travel_style_id != PRIVATE_TOUR && $travel_style_id != DAY_TOUR)
	    {
	        $this->db->where('tts.travel_style_id !=', PRIVATE_TOUR);
	        $this->db->where('tts.travel_style_id !=', DAY_TOUR);
	    }
	    
	    if(!empty($exclude_tour_id))
	    {
	        $this->db->where('t.id !=', $exclude_tour_id);
	    }
	    
	    $this->db->where('td.destination_id', $destination_id);
	    
	    $this->db->where('tts.travel_style_id', $travel_style_id);
	    
	    $this->db->where('td.is_land_tour', 1);
	    
	    $this->_common_tour_condition();
	    
	    $this->db->where('p.deleted !=', DELETED);
	    
	    $this->db->group_by('t.id');
	    
	    $query = $this->db->get('tours t');
	    
	    $tours = $query->result_array();
	    
	    return count($tours);
	}

	/**
	 * Khuyenpv Feb 12 2015
	 * Get tours by Destinations
	 */
	function get_most_recommended_tour_in_des($destination_id, $limit = 1){
        
	    $this->db->distinct('t.id');
	    
		$this->db->select('t.id, t.name, t.url_title, t.picture, t.route, t.route_highlight, t.total_score, t.partner_id, t.show_partner,
		    p.short_name as partner_name, t.review_number, t.brief_description, t.tour_highlight, t.short_description, ts.includes, ts.excludes');

		$this->db->join('partners p', 'p.id = t.partner_id', 'left outer');

		$this->db->join('tour_destinations td', 'td.tour_id = t.id', 'left outer');

		$this->db->join('tour_services ts', 'ts.tour_id = t.id', 'left outer');

		$this->db->where('td.is_land_tour', 1);

		$this->db->where('td.destination_id', $destination_id);

		$this->_common_tour_condition();

		$this->db->order_by('t.position', 'asc');

		$this->db->limit($limit);

		$query = $this->db->get('tours t');

		$tours = $query->result_array();

		if ($limit == 1)
        {
            if (! empty($tours))
            {
                return $tours[0];
            }

            return null;
        }

		return $tours;
	}

	/**
	 * get_destination_travel_styles
	 *
	 * @author toanlk
	 * @since  Mar 6, 2015
	 */
	function get_destination_travel_styles($destination_id, $is_get_all = false)
	{
	    $this->db->select('dts.*, st.id as travel_style_id, st.name, st.url_title, st.name as en_name, st.picture as style_picture, st.description as style_description');

	    $this->db->join('travel_styles st', 'st.id = dts.style_id', 'left outer');

	    $this->db->where('dts.destination_id', $destination_id);
	    
	    if(!$is_get_all) {
	        $this->db->where('dts.show_on_tab', 1);
	    }
	    
	    $this->db->where('st.deleted !=', DELETED);

	    $this->db->order_by('dts.position', 'asc');

	    $query = $this->db->get('destination_travel_styles dts');

	    $destination_travel_styles = $query->result_array();

	    $table_cnf[] = array(
            'col_id_name' => 'travel_style_id',
            'table_name' => 'travel_styles');

        // $colum_cnf[] = array('table_name'=>'travel_styles', 'col_name_db'=>'name', 'col_name_alias'=>'style_name');
        $colum_cnf[] = array(
            'table_name' => 'travel_styles',
            'col_name_db' => 'description',
            'col_name_alias' => 'style_description');

	    $destination_travel_styles = update_i18n_data($destination_travel_styles, I18N_MULTIPLE_MODE, $table_cnf, $colum_cnf);

	    return $destination_travel_styles;
	}

	/**
	 * Get the tour categoris
	 *
	 * @author Khuyenpv
	 * @since  Mar 9, 2015
	 */
	function get_tour_categories()
	{
		$this->db->select('id, name');

		$this->db->order_by('order_');

		$query = $this->db->get('categories');

		$results = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'categories');
		$results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;
	}

	function get_destination($id)
	{
	    $this->db->select('id, name, url_title, full_description, picture');

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
	 * get rich snippet for tour destination
	 *
	 * @author toanlk
	 * @since  Apr 8, 2015
	 */
	function get_rich_snippet_destination_review($destination_id)
    {
        $this->db->select('gr.total_review_score');
        $this->db->from('guest_reviews AS gr');
        $this->db->join('tours AS t', 'gr.review_for_id = t.id', 'left');
        $this->db->join('tour_destinations AS td', 'td.tour_id= t.id', 'left');
        $this->db->where_in('td.destination_id', $destination_id);
        if (count($destination_id) == 1)
        {
            $this->db->where('td.is_land_tour =', 1);
        }
        $this->db->where('t.deleted !=', DELETED);
        $this->db->where('gr.deleted !=', DELETED);

        $query = $this->db->get();
        $reviews = $query->result_array();

        $review_numb = count($reviews);

        // return empty
        if ($review_numb == 0)
            return null;

        $total_score = 0;
        foreach ($reviews as $review)
        {
            $total_score += $review['total_review_score'];
        }
        $review_score = number_format($total_score / $review_numb, 1);

        return array('review_score' => $review_score,'review_numb' => $review_numb);
    }

	function get_rich_snippet_review_infor($cruise_destination, $type)
    {
        $this->db->select('gr.total_review_score');
        $this->db->from('guest_reviews AS gr');
        $this->db->join('tours AS t', 'gr.review_for_id = t.id', 'left');
        $this->db->join('cruises AS c', 't.cruise_id = c.id', 'left');
        $this->db->where('c.cruise_destination', $cruise_destination);
        $this->db->where('gr.deleted !=', DELETED);

        if ($type != HALONG_BAY_CRUISES && $type != MEKONG_RIVER_CRUISES)
        {
            // budget
            if (strpos($type, "luxury") !== false)
            {
                $this->db->where('c.star >=', 4.5);
            }
            elseif (strpos($type, "deluxe") !== false)
            {
                $this->db->where('c.star >=', 3.5);
            }
            elseif (strpos($type, "cheap") !== false)
            {
                $this->db->where('c.star <', 3.5);
            }

            // cruise type
            if (strpos($type, "private") !== false)
            {
                $this->db->where('c.cabin_type', 2);
            }
            else
            {
                $this->db->where('c.cabin_type !=', 2);
            }
        }

        $query = $this->db->get();
        $reviews = $query->result_array();

        $review_numb = count($reviews);

        // return empty
        if ($review_numb == 0)
            return null;

        $total_score = 0;
        foreach ($reviews as $review)
        {
            $total_score += $review['total_review_score'];
        }
        $review_score = number_format($total_score / $review_numb, 1);

        return array('review_score' => $review_score,'review_numb' => $review_numb);
    }

    /**
     * Get Specific Travel Dates of the Promotion
     *
     * @author Khuyenpv 26.03.2015
     */
    function get_travel_dates($promotions){

        foreach ($promotions as $key => $promotion){

            $travel_dates = "";

            $promotion['specific_dates'] = array();

            if ($promotion['is_specific_dates'] == 1){

                $this->db->where('promotion_id', $promotion['id']);

                $this->db->where('date >=', date(DB_DATE_FORMAT)); // in the future

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


    /**
     *  -------------------------------------------------------------------------------------------------------
     *
     *  BEGIN FUNCTIONS OF SEARCH TOURS
     *
     *  -------------------------------------------------------------------------------------------------------
     */

    /**
     * Count the number of tours based on search criteria
     *
     * @author Khuyenpv
     * @since March 14 2015
     */
    function count_total_search_results($search_criteria){

    	$this->db->from('tour_destinations as td');

    	$this->db->join('tours as t', 't.id = td.tour_id');

    	if(!empty($search_criteria['cruise_cabin']) || !empty($search_criteria['cruise_properties'])){
    		$this->db->join('cruises as c', 'c.id = t.cruise_id');
    	}

    	$this->_build_tour_search_conditions($search_criteria);

    	return $this->db->count_all_results();

    }

    /**
     * Search Tours
     *
     * @author Khuyenpv
     * @since March 14 2015
     */
    function search_tours($search_criteria){

    	$departure_date = $search_criteria['departure_date'];

    	$sort_by = $search_criteria['sort_by'];

    	$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

    	$per_page = $this->config->item('per_page');

		$this->db->select('t.id, t.name, t.brief_description, t.url_title, t.picture, t.review_number, t.total_score, t.route, t.show_partner, t.service_includes as includes, t.service_excludes as excludes,t.has_special_discount, ptn.short_name as partner_name, t.cruise_id, c.star as star, c.name as cruise_name, c.url_title as cruise_url_title, c.is_new');

		$this->db->from('tour_destinations as td');

		$this->db->join('tours as t', 't.id = td.tour_id');

		$this->db->join('cruises as c', 'c.id = t.cruise_id', 'left outer');

		$this->db->join('partners as ptn', 'ptn.id = t.partner_id');

		switch ($sort_by){

			case SORT_BY_RECOMMEND:
				$this->db->order_by('t.position');
				break;

			case SORT_BY_REVIEW_SCORE:
				$this->db->order_by('t.total_score','desc');
				$this->db->order_by('t.position');
				break;

			case SORT_BY_PRICE_LOW_HIGH:
			case SORT_BY_PRICE_HIGH_LOW:

				$this->db->join('promotion_tours as tp', 'tp.tour_id = t.id','left outer');

				$this->db->join('promotions as p', 'p.id = tp.promotion_id','left outer');

				$pro_cond = create_tour_promotion_condition($departure_date);

				$this->db->join('tour_price_froms as tpf', 'tpf.tour_id = t.id AND (tpf.promotion_id = 0 OR (tpf.promotion_id = p.id AND '.$pro_cond .'))', 'left outer');

				$this->db->where('(tpf.start_date is NULL or tpf.start_date <="'.$departure_date.'")');

				$this->db->where('(tpf.end_date is NULL or tpf.end_date >="'.$departure_date.'")');

				$this->db->order_by('tpf.price_from', $sort_by == SORT_BY_PRICE_LOW_HIGH ? 'asc' : 'desc');

				break;

			default:
				$this->db->order_by('t.position');

		}

		$this->_build_tour_search_conditions($search_criteria);


		$this->db->group_by('t.id');


		$offset = !empty($search_criteria['page']) ? $search_criteria['page'] : 0;

		$this->db->limit($per_page, $offset);


		$query = $this->db->get();

		$results = $query->result_array();

		$results = $this->get_tour_special_offers($results);

		$results = $this->get_tour_price_froms($results, $departure_date);

		return $results;
    }

    /**
     * Build the common using of search conditions
     *
     * @author Khuyenpv
     * @since March 14 2015
     */
    function _build_tour_search_conditions($search_criteria, $is_action_filter = false){

    	$this->db->where('td.destination_id', $search_criteria['destination_id']);

    	// travel styles conditions
    	$travel_styles = get_tour_search_criteria_values($search_criteria['travel_styles'], 'tour_travel_styles');
   		if(empty($travel_styles) || count($travel_styles) > 2){
   			// don't have the travel-styles conditions
   		} else {
   			$travel_style = $travel_styles[0];

   			$this->db->where('t.category & '.pow(2, $travel_style).' > 0');
   		}

   		$duration = get_tour_search_criteria_values($search_criteria['duration'], 'duration_search');


   		if(!empty($duration)){

   			if($duration < 4){

   				$this->db->where('t.duration', $duration);

   			} else if($duration == 4){

   				$this->db->where_in('t.duration', array(4, 5, 6, 7));

   			} else{

   				$this->db->where('t.duration > ', 7);
   			}
   		}

   		$group_type = get_tour_search_criteria_values($search_criteria['group_type'], 'tour_group_types');

   		if(!empty($group_type)){
   			$this->db->where('t.group_type & '.pow(2, $group_type).' > 0');
   		}

   		$tour_budgets = get_tour_search_criteria_values($search_criteria['budgets'], 'tour_budgets');
   		if(!empty($tour_budgets) && count($tour_budgets) < 3){

   			$budget_sql = '';

   			foreach ($tour_budgets as $key => $value){

   				$budget_sql .= 't.budget & '.pow(2, $value). ' > 0';

   				if($key < count($tour_budgets) - 1){
   					$budget_sql .= ' OR ';
   				}

   			}

   			if(!empty($budget_sql)) {

   				$budget_sql = '('.$budget_sql.')';

   				$this->db->where($budget_sql);
   			}


   		}

   		// condition not apply when using count number of tours for filter
   		if(!$is_action_filter){

			$cruise_cabin = $search_criteria['cruise_cabin'];

   			if(!empty($cruise_cabin)){
   				$this->db->where('c.cabin_index & '.$cruise_cabin.' > 0');
   			}

   			$cruise_properties = $search_criteria['cruise_properties'];
   			if(!empty($cruise_properties)){
   				if(in_array(-1, $cruise_properties)){

   					$this->db->where('c.has_triple_family', STATUS_ACTIVE);
   				}

   				foreach($cruise_properties as $fa_id){
   					if($fa_id != -1){
   						$str_fa = '-'.$fa_id.'-';

   						$this->db->like('c.cruise_facility_ids', $str_fa, 'both');
   					}
   				}

   			}

   			$activities = $search_criteria['activities'];

   			if(!empty($activities)){

   				foreach($activities as $act_id){

   					$str_act = '-'.$act_id.'-';

   					$this->db->like('t.activity_ids', $str_act, 'both');

   					/*
   					$sql_act = 'EXISTS (SELECT 1 FROM tour_activities as ta WHERE t.id = ta.tour_id AND ta.activity_id = '.$act_id.')';

   					$this->db->where($sql_act, NULL, FALSE);
   					*/

   				}
   			}

   			$des_styles = $search_criteria['des_styles'];
   			if(!empty($des_styles)){

   				foreach($des_styles as $style_id){

   					$sql_style = 'EXISTS (SELECT 1 FROM tour_travel_styles as ts WHERE t.id = ts.tour_id AND ts.travel_style_id = '.$style_id.')';

   					//$sql_style = 'EXISTS (SELECT 1 FROM tour_travel_styles as ts WHERE t.id = ts.tour_id AND ts.destination_id = '.$search_criteria['destination_id'].' AND ta.travel_style_id = '.$style_id.')';

   					$this->db->where($sql_style, NULL, FALSE);
   				}
   			}

   			$sub_des = $search_criteria['sub_des'];
   			if(!empty($sub_des)){
   				foreach($sub_des as $des_id){

   					/*
   					$sql_des = 'EXISTS (SELECT 1 FROM tour_destinations as td2 WHERE t.id = td2.tour_id AND td2.destination_id = '.$des_id.')';

   					$this->db->where($sql_des, NULL, FALSE);
   					*/

   					$str_des = '-'.$des_id.'-';

   					$this->db->like('t.route_ids', $str_des, 'both');
   				}
   			}

   		}

    	$this->_common_tour_condition();
    }

    /**
     * Get all tour-data for for counting number of tours in search filters
     *
     * @auther Khuyenpv
     * @since Mar 15 2015
     */
    function get_all_tours_for_search_filters($search_criteria){

    	$this->db->select('t.id, t.route_ids, t.activity_ids, c.cabin_index, c.cruise_facility_ids, c.has_triple_family');

    	$this->db->from('tour_destinations as td');

    	$this->db->join('tours as t', 't.id = td.tour_id');

    	$this->db->join('cruises as c', 'c.id = t.cruise_id', 'left outer');

    	$this->_build_tour_search_conditions($search_criteria);

    	$query = $this->db->get();

    	$results = $query->result_array();

    	return $results;
    }

    /**
     * Count the number of tours for Destination Travel Style
     *
     * @auther Khuyenpv
     * @since Mar 15 2015
     */
    function count_nr_tour_by_travel_styles($travel_styles, $search_criteria){

    	if(!empty($travel_styles)){

    		$ids = array();

    		foreach ($travel_styles as $value){
    			$ids[] = $value['id'];
    		}

    		$this->db->select('ts.travel_style_id as id, count(*) as cnt');

    		$this->db->from('tour_destinations as td');

    		$this->db->join('tours as t', 't.id = td.tour_id');

    		$this->db->join('tour_travel_styles as ts', 'ts.tour_id = t.id');

    		$this->_build_tour_search_conditions($search_criteria, true);

    		//$this->db->where('ts.destination_id', $search_criteria['destination_id']);

    		$this->db->where_in('ts.travel_style_id', $ids);

    		$this->db->group_by('ts.travel_style_id');

    		$query = $this->db->get();

    		$results = $query->result_array();

    		return $results;

    	} else {
    		return array();
    	}
    }


    /**
     * Count Number of Search More Tours
     *
     * @author Khuyenpv
     * @since 05.04.2015
     */
    function count_recommend_more_tours($search_criteria){

    	$this->db->from('tour_destinations as td');

    	$this->db->join('tours as t', 't.id = td.tour_id');

    	$this->_build_recommend_more_tour_conditions($search_criteria);

    	return $this->db->count_all_results();

    }

    /**
     * Recommend More Tours
     *
     * @author Khuyenpv
     * @since 05.04.2015
     */
    function recommend_more_tours($search_criteria, $departure_date, $offset = 0, $limit = 5){

    	$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

    	$this->db->select('t.id, t.name, t.url_title, t.cruise_id, t.main_destination_id, t.route, t.picture, t.review_number, t.total_score, tpf.price_origin, tpf.price_from');

    	$this->db->from('tour_destinations as td');

    	$this->db->join('tours as t', 't.id = td.tour_id');

    	$this->db->join('tour_price_froms as tpf','tpf.tour_id = t.id', 'left outer');

    	//$this->db->join('promotions as p','p.id = tpf.promotion_id', 'left outer');

    	$this->db->where('td.destination_id', $search_criteria['destination_id']);

    	$this->db->where('tpf.start_date <= ', $departure_date);

    	$this->db->where('(tpf.end_date is NULL OR tpf.end_date >= "'.$departure_date.'")');

    	/*
    	$pro_sql = create_tour_promotion_condition($departure_date);
    	$this->db->where($pro_sql);
    	*/

    	$this->_build_recommend_more_tour_conditions($search_criteria);

    	$this->db->order_by('tpf.price_from');

    	$this->_build_order_condtions($search_criteria);

    	$this->db->group_by('t.id');

    	$this->db->limit($limit, $offset);

    	$query = $this->db->get();

    	$results = $query->result_array();

    	return $results;
    }

    /**
     * Build Recommend SQL condition
     *
     * @author Khuyenpv
     * @since 05.04.2015
     */
    function _build_recommend_more_tour_conditions($search_criteria){

    	$this->db->where('td.destination_id', $search_criteria['destination_id']);

    	if(!empty($search_criteria['duration'])){

    		$duration = $search_criteria['duration'];

    		if($duration < 4){

    			$this->db->where('t.duration', $duration);

    		} else if($duration == 4){

    			$this->db->where_in('t.duration', array(4, 5, 6, 7));

    		} else{

    			$this->db->where('t.duration > ', 7);
    		}
    	}

    	// search on the English Version Firsts
    	$sql_lang = '(t.language_id = 0 OR t.language_id = '.lang_id().')';
    	$this->db->where($sql_lang);

    	$this->db->where('t.status', STATUS_ACTIVE);
    	$this->db->where('t.deleted !=', DELETED);
    }

    /**
     * Build the common tour order conditions
     */
    function _build_order_condtions($search_criteria){
    	if(!empty($search_criteria['sort_by'])){
    		$sort_by = $search_criteria['sort_by'];
	    	switch ($sort_by) {
				case SORT_BY_PRICE_LOW_HIGH:
					$this->db->order_by('tpf.price_from', 'asc');
					break;
				case SORT_BY_PRICE_HIGH_LOW:
					$this->db->order_by('tpf.price_from', 'desc');
					break;
				case SORT_BY_REVIEW_SCORE:
					$this->db->order_by('t.total_score', 'desc');
					break;
				default :
					$this->db->order_by('t.position', 'asc');
					break;
			}
    	}
    }

    /**
     *  -------------------------------------------------------------------------------------------------------
     *
     *  END FUNCTIONS OF SEARCH TOURS
     *
     *  -------------------------------------------------------------------------------------------------------
     */


    /**
     *  -------------------------------------------------------------------------------------------------------
     *
     *  BEGIN FUNCTIONS OF TOUR-CHECK-RATES
     *
     *  -------------------------------------------------------------------------------------------------------
     */

    /**
     * Get list tour accommodations
     *
     * @author Khuyenpv
     * @since March 18 2015
     */
    function get_tour_accommodations($tour_id, $departure_date = '', $acc_id = ''){

    	$this->db->select('ta.id, ta.name, ta.content, ta.cruise_cabin_id, cc.name as cabin_name, cc.picture, cc.cabin_size, cc.bed_size, cc.id as cruise_cabin_id, cc.cruise_id as cruise_id, cc.max_person, cc.description as cabin_description');

    	$this->db->from('tour_accommodations_ as ta');

    	$this->db->join('cruise_cabins cc', 'cc.id = ta.cruise_cabin_id', 'left outer');

		$this->db->where('ta.tour_id', $tour_id);

		if(!empty($acc_id)){ // get the specific Accommodation ID

			$this->db->where('ta.id', $acc_id);

		}

		$this->db->order_by('ta.position');

		$query = $this->db->get();

		$results = $query->result_array();

		foreach ($results as $key => $value){

			// accomodation of cruise tour
			if(!empty($value['cruise_cabin_id'])){
				$value['cabin_facilities'] = $this->get_cruise_cabin_facilities($value['cruise_cabin_id']);
			}

			if(!empty($departure_date)){
				$value['prices'] = $this->get_tour_accommodation_prices($value['id'], $departure_date);
			}

			$results[$key] = $value;
		}

		return $results;
    }

    /**
     * Get Tour Accommodation Prices
     *
     * @author Khuyenpv 20.03.2015
     */
    function get_tour_accommodation_prices($acommodation_id, $departure_date){

    	$this->db->select('tpd.group_size, tpd.price, tpd.accommodation_id, tp.tour_id, tp.discount');

    	$this->db->from('tour_price_details tpd');

    	$this->db->join('tour_prices tp', 'tp.id = tpd.tour_price_id');

    	$this->db->where('tpd.accommodation_id', $acommodation_id);

    	if ($departure_date != '') {

    		$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

    		$this->db->where('tp.from_date <=', $departure_date);

    		$pr_where = "(tp.to_date is NULL OR tp.to_date >='" . $departure_date . "')";

    		$this->db->where($pr_where);
    	}

    	$this->db->where('tp.deleted !=', DELETED);

    	$query = $this->db->get();

    	$prices = $query->result_array();

    	return $prices;

    }

    /**
     * Get tour children price configuration
     *
     * @author Khuyenpv
     * @since Mar 20 2015
     */
    function get_children_cabin_price($tour_id){

    	$this->db->where('tour_id', $tour_id);

    	$query = $this->db->get('tour_children_prices');

    	$children_prices = $query->result_array();

    	if (count($children_prices) > 0){

    		return $children_prices[0];

    	}

    	return array();
    }


    /**
     * Get Cruise Cabin Facilities
     *
     * @author Khuyenpv
     * @since March 18 2015
     */
    function get_cruise_cabin_facilities($cruise_cabin_id){

    	$this->db->select('f.id, f.name, f.important');

    	$this->db->from('cruise_facilities as cf');

    	$this->db->join('facilities as f', 'f.id = cf.facility_id');

    	$this->db->where('cf.cruise_cabin_id', $cruise_cabin_id);

    	$this->db->where('cf.deleted !=', DELETED);

    	$this->db->where('f.status', STATUS_ACTIVE);
    	$this->db->where('f.deleted !=', DELETED);

    	$this->db->order_by('f.name');

    	$query = $this->db->get();

    	return $query->result_array();
    }

    /**
     * Get all tour promotions available
     *
     * @author Khuyenpv Mar 20.03.2015
     */
    function get_all_tour_promotions($tour_id, $departure_date, $pro_id = ''){

    	if(empty($departure_date)) $departure_date = date(DB_DATE_FORMAT); // today if no departure date specified

    	$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date)); // convert to DB_DATE_FORMAT

    	$this->db->select('p.id, p.name, p.promotion_type, p.stay_from, p.stay_to, p.book_from, p.book_to, p.is_hot_deals, p.is_specific_dates, p.note, p.promotion_condition, p.day_before, pd.offer_rate, pd.note as offer_note, pd.note_detail, pd.accommodation_id');

    	$this->db->from('promotion_details as pd');

    	$this->db->join('promotions as p', 'p.id = pd.promotion_id');

    	$sql_pro = create_tour_promotion_condition($departure_date);

    	$this->db->where($sql_pro);

    	$this->db->where('pd.tour_id', $tour_id);
    	$this->db->where('pd.deleted !=', DELETED);

    	if(!empty($pro_id)){
    		$this->db->where('p.id', $pro_id); // get the specific promotion
    	}

    	$this->db->order_by('p.position');

    	$query = $this->db->get();

    	$results = $query->result_array();

    	return $results;
    }

    /**
     *
     * Get Tour Optional Services
     *
     * @author Khuyenpv
     * @since 31.03.2015
     */
    function get_tour_optional_services($tour_id, $departure_date , $duration){

    	$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

    	$this->db->select('ts.id, ts.tour_id, ts.optional_service_id, ts.charge_type, ts.price, op.name, op.type, op.unit_type, op.min_cap, op.max_cap, op.description, op.url, ts.default_selected, sp.price as specific_price, sp.default_selected as def_selected');

    	$this->db->from('tour_optional_services ts');

    	$this->db->join('optional_services op', 'op.id = ts.optional_service_id');

    	$p_where = " AND (sp.start_date <='" . $departure_date . "'";
    	$p_where .= " AND (sp.end_date is NULL OR sp.end_date >='" . $departure_date . "'))";
    	$p_where .= " AND sp.deleted != ".DELETED;
    	$p_where .= " AND (sp.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM tour_optional_service_price_dates as p_date WHERE sp.id = p_date.tour_optional_service_price_id AND p_date.date = '" . $departure_date . "'))";

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

    	$ret['additional_charge'] = $additional_charge;
    	$ret['transfer_services'] = $transfer_services;
    	$ret['extra_services'] = $extra_services;

    	return $ret;
    }

    /**
     * Get Normal Discount for List of Tours
     *
     * @author Khuyenpv
     * @since 02.04.2015
     */
    function get_tour_normal_discount($tours, $departure_date){

    	if(empty($tours)) return $tours;

    	$tour_ids = array();

    	foreach ($tours as $tour){
    		$tour_ids[] = $tour['id'];
    	}

    	$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));

    	$this->db->select('discount, tour_id');

    	$this->db->from('tour_prices');

    	$this->db->where_in('tour_id', $tour_ids);

    	$this->db->where('from_date <=', $departure_date);

    	$this->db->where('(to_date is NULL OR to_date >= "'.$departure_date.'")');

    	$query = $this->db->get();

    	$discounts = $query->result_array();

    	// set data for array of tours

    	foreach ($tours as $key => $tour){

    		$discount = 0;

    		foreach ($discounts as $discount){

    			if($discount['tour_id'] == $tour['id']){

    				$discount = $discount['discount'];

    				break;
    			}
    		}

    		$price = !empty($tour['price']) ? $tour['price'] : array();
    		$price['discount'] = $discount;

    		$tour['price'] = $price;

    		$tours[$key] = $tour;
    	}

    	return $tours;
    }



    /**
     *  -------------------------------------------------------------------------------------------------------
     *
     *  END FUNCTIONS OF TOUR-CHECK-RATES
     *
     *  -------------------------------------------------------------------------------------------------------
     */



    /* BEGIN FUNCTIONS OF TOUR-DETAILS
     ========================================================================== */

    /**
     * Khuyenpv Feb 12 2015
     * Get tour detail information
     *
     */
    function get_tour_detail($url_title){

        $this->db->select(
           't.id, t.name, t.url_title, t.duration, t.category, t.group_type, t.main_destination_id, t.cruise_id, t.tour_highlight, t.note,
            t.picture, t.departure, t.total_score, t.brief_description, t.budget, t.review_number, t.route, t.service_includes, t.service_excludes,
            t.partner_id, t.show_partner, t.cancellation_policy, t.children_extrabed,  p.short_name as partner_name, c.num_cabin, c.types, c.name as cruise_name,
            c.url_title as cruise_url_title, c.star, c.is_new, c.cruise_destination');

        $this->db->from('tours as t');

        $this->db->join('cruises as c', 'c.id = t.cruise_id', 'left outer');

        $this->db->join('partners as p', 'p.id = t.partner_id', 'left outer');

        $this->db->where('t.deleted != ', DELETED);

        $this->db->where('t.url_title', $url_title);

        $query = $this->db->get();

        $tours = $query->result_array();

        if (empty($tours))
        {
            $tours = $this->get_tour_by_url_history($url_title);
        }

        $tours = $this->get_tour_special_offers($tours);

        return count($tours) > 0 ? $tours[0] : FALSE;
    }

    /**
     * get_tour_by_url_history
     *
     * @author toanlk
     * @since  Apr 22, 2015
     */
    function get_tour_by_url_history($url_title) {

        $this->db->select(
           't.id, t.name, t.url_title, t.url_title_history, t.duration, t.category, t.group_type, t.main_destination_id, t.cruise_id, t.tour_highlight, t.note,
            t.picture, t.departure, t.total_score, t.brief_description, t.budget, t.review_number, t.route, t.service_includes, t.service_excludes,
            t.partner_id, t.show_partner, t.cancellation_policy, t.children_extrabed,  p.short_name as partner_name, c.num_cabin, c.types, c.name as cruise_name,
            c.url_title as cruise_url_title, c.star, c.is_new, c.cruise_destination');

        $this->db->from('tours as t');

        $this->db->join('cruises as c', 'c.id = t.cruise_id', 'left outer');

        $this->db->join('partners as p', 'p.id = t.partner_id', 'left outer');

        $this->db->like('t.url_title_history', $url_title);

        $this->db->where('t.deleted !=', DELETED);

        $query = $this->db->get();

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

        return null;
    }

    /**
     * Get Tour Detail By ID
     *
     * @author Khuyenpv
     * @since 13.04.2015
     */
    function get_tour_by_id($id, $departure_date){
    	$this->db->select('id, name, url_title, cruise_id, main_destination_id');
    	$this->db->from('tours');
    	$this->db->where('id', $id);
    	$query = $this->db->get();
    	$tours = $query->result_array();

    	if(!empty($departure_date)){
    		$tours = $this->get_tour_price_froms($tours, $departure_date);
    	}

    	return count($tours) > 0 ? $tours[0] : FALSE;
    }

    /**
     * Get all photos of a tours
     *
     * @author toanlk
     * @since  Mar 19, 2015
     */
    function get_tour_photos($tour_id)
    {
        /* $this->db->select('id, name, caption, type');
        $this->db->where('tour_id', $tour_id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('tour_photos'); */
        
        $sql = "SELECT id, name, caption, type FROM (tour_photos) ";
        $sql .= "WHERE tour_id =  '".$tour_id."' ORDER BY FIELD (type, 2,1,4) , position asc";
        
        $query = $this->db->query($sql);
        
        $results = $query->result_array();

        return $results;
    }

    /**
     * Get similar tours
     *
     * @author toanlk
     * @since  Mar 25, 2015
     */
    function get_similar_tours($tour) {

        $duration = $tour['duration'];
        $cruise_port = $tour['cruise_destination'];

        $this->db->select('t.id, t.name, t.url_title, t.picture, t.review_number, t.total_score,
            p.short_name as partner_name, c.name as cruise_name, c.url_title as cruise_url_title, c.star as star, c.is_new');

		$this->db->from('tours as t');

		$this->db->join('partners as p', 'p.id = t.partner_id');

		$this->db->join('cruises c', 'c.id = t.cruise_id', 'left outer');

		$this->db->where('t.status', STATUS_ACTIVE);

		$this->db->where('t.deleted !=', DELETED);

		$this->db->where('p.deleted !=', DELETED);

		$this->db->where('t.id !=', $tour['id']);

		$this->db->where('(t.language_id = 0 OR t.language_id = ' . lang_id().')');

		// for cruise tours
		if (! empty($tour['cruise_id']))
        {
            $this->db->where('t.group_type &'.$tour['group_type'].' > 0');    // similar group type
            
            $this->db->where('t.budget &'.$tour['budget'].' > 0');            // similar budget
            
		    $this->db->where('t.cruise_id >', 0);

		    $this->db->where('c.cruise_destination', $cruise_port);

		    // Mekong cruise tours
		    if ($cruise_port == MEKONG_CRUISE_DESTINATION)
		    {
		        if($duration >= 4 && $duration <= 7) {            // similar duration
		            $this->db->where('t.duration >=', 4);
		            $this->db->where('t.duration <=', 7);
		        } else if($duration > 7) {
		            $this->db->where('t.duration >', 7);
		        } else {
		            $this->db->where('t.duration =', $duration);
		        }
		    } else {
		        // Halong Bay cruise tours
		        $this->db->where('t.duration =', $duration);      // similar duration
		    }
		} else {
		    $this->db->where('t.main_destination_id =', $tour['main_destination_id']);
		}

		$this->db->order_by("t.position", "asc");

		$this->db->limit(4);

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
    }

    /**
     * Get itinerary
     *
     * @author toanlk
     * @since  Mar 25, 2015
     */
    function get_itinerary($tour_id)
    {
        $this->db->select(
            'id,itinerary_types, type, meals_options, title, content, accommodation, activities,
            transportations, label, itinerary_photos, notes');
        $this->db->where('tour_id', $tour_id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('detail_itinerary');
        $results = $query->result_array();

        // get itinerary photos
        $results = $this->get_itinerary_photos($results);

        return $results;
    }

    /**
     * Get itinerary photos
     *
     * @author toanlk
     * @since  Mar 27, 2015
     */
    function get_itinerary_photos($itineraries)
    {
        $ids = array_column($itineraries, 'id');
        
        if(!empty($ids)) {
            $this->db->select('ip.itinerary_id, ip.tour_photo_id, ip.cruise_photo_id, ip.destination_photo_id,
            ip.activity_photo_id, ip.hotel_photo_id, tp.caption, tp.name t_name, cp.name c_name, ap.name a_name, dp.name d_name');
            
            $this->db->join('tour_photos tp', 'tp.id = ip.tour_photo_id', 'left outer');
            $this->db->join('cruise_photos cp', 'cp.id = ip.cruise_photo_id', 'left outer');
            $this->db->join('destination_photos dp', 'dp.id = ip.destination_photo_id', 'left outer');
            $this->db->join('activity_photos ap', 'ap.id = ip.activity_photo_id', 'left outer');
            
            $this->db->where_in('ip.itinerary_id', $ids);
            $this->db->order_by('ip.position', 'asc');
            
            $query = $this->db->get('itinerary_photos ip');
            $results = $query->result_array();
            
            foreach ($itineraries as $k => $value)
            {
            
                $value['photos'] = array();
                foreach ($results as $photo)
                {
                    if ($photo['itinerary_id'] == $value['id'])
                    {
                        $value['photos'][] = $photo;
                    }
                }
            
                $itineraries[$k] = $value;
            }    
        }

        return $itineraries;
    }

    /**
     * Get itinerary highlight
     *
     * @author toanlk
     * @since  Mar 25, 2015
     */
    function get_itinerary_highlight($tour_id)
    {
        $this->db->select('label, itinerary_types, title, content, accommodation');
        $this->db->where('tour_id', $tour_id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('itinerary_highlight');
        $results = $query->result_array();

        return $results;
    }

    /**
     * get_photo_description
     *
     * @author toanlk
     * @since  Mar 27, 2015
     */
    function get_photo_description($type, $picture_name)
    {
        $results = array();

        if ($type == 'cruise_')
        {
            $this->db->where('name', $picture_name);
            $query = $this->db->get('cruise_photos');
            $results = $query->result_array();

            if (! empty($results))
            {
                return $results[0]['caption'];
            }
        }
        else
        {
            $this->db->where('name', $picture_name);
            $query = $this->db->get('tour_photos');
            $results = $query->result_array();

            if (! empty($results))
            {
                return $results[0]['caption'];
            }
        }

        return '';
    }

    /* END FUNCTIONS OF TOUR-DETAILS
     ========================================================================== */

    /**
     *  Get top parrent destinations for Customize
     *  TinVM  Apr09 2015
     */

    function getTopParentDestinations()
    {
        $this->db->select('id,name,region,picture_name,number_tours,url_title,parent_id');
        $this->db->where_in('id', array(VIETNAM, LAOS, CAMBODIA, MYANMAR));
        $this->db->order_by('name', 'desc');

        $query = $this->db->get('destinations');

        $destinations =  $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
        $destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

        return $destinations;
    }

    /**
     * Get all destinations which is top destination
     * TinVM  Apr09 2015
     */
    function getTopDestinations()
    {
        $this->db->select('id, name, parent_id');

        $this->db->where('is_top_tour', 1);

        $this->db->order_by('position');

        $query = $this->db->get('destinations');

        $destinations = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
        $destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

        return $destinations;
    }

    /**
     * Get top tour destination
     * @author TinVM
     * @since Jun 2 2015
     */
    function get_top_tour_destination(){
        $this->db->select('id,name,region,picture_name,url_title, number_tours, parent_id');

        $this->db->from('destinations');

        $this->db->where('deleted !=', DELETED);

        $this->db->where('is_top_tour', STATUS_ACTIVE);

        $this->db->order_by('order_','asc');

        $query = $this->db->get();

        $result = $query->result_array();

        // 24.10.2014: Update multi langguage TinVM
        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
        $result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

        return $result;
    }

    /**
      * get_tour_route
      *
      * @author toanlk
      * @since  Jun 10, 2015
      */
    function get_tour_route($id) {

        $this->db->select('d.name, d.longitude, d.latitude, d.short_description as description, d.picture, d.url_title');

        $this->db->join('destinations as d', 'd.id = td.destination_id', 'left outer');

        $this->db->where('td.is_highlight', 1);

        $this->db->where('td.tour_id', $id);

        $query = $this->db->get('tour_destinations td');

        $results = $query->result_array();

        return $results;
    }

    /**
     * Get hotel hot deals for Deals & Offer page
     * @author TinVM
     * @since Jun12 2015
     */
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

        $this->db->order_by('p.position', 'asc');

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


            $value['room_types'] = $this->Hotel_Model->getRoomTypes($value['id'], $arrival_date, $departure_date);

            $value = $this->Hotel_Model->_getPriceFrom($value, $value['room_types']);

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

    /**
     * Get Tour hot deals for Deals & Offer page
     * @author TinVm
     * @since Jun12 2015
     */
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

    /**
     * Get tour of hot deal promotion
     * @author TinVM
     * @since Jun12 2015
     */
    function get_tour_off_hot_deal_promotion(){

        $today = date('Y-m-d');

        $this->db->distinct();

        $this->db->select('t.id, t.name, t.url_title, t.picture_name as picture, t.position, pd.order_new, c.id as cruise_id, c.cruise_destination, p.name as promotion_name, p.note as p_note, p.id as promotion_id, p.start_date, p.end_date, p.book_to as expiry_date, p.is_hot_deals, p.is_specific_dates, p.apply_for_hanoi, p.promotion_type, p.day_before');

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

    /**
     * Get from price/best-price of tours	 *
     * @author TinVM
     * @since Jun12 2015
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

    /**
     * Get tour Promotion
     * @author TinVM
     * @since Jun12 2015
     */
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
     * Sort Deal desc
     * @author TinVM
     * @since Jun12 2015
     */
    function sortDealDesc($t1, $t2){
        if($t1['order_new'] == $t2['order_new']) {
            return 0;
        }
        return ($t1['order_new'] > $t2['order_new']) ? 1: -1;
    }
    
    /**
     * allways create a new customer after each booking
     * @author HuuTD
     * @since 19.06.2015
     */
    
    function create_or_update_customer($cus){
    	
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
}