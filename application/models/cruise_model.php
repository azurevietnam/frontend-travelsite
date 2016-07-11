<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cruise_Model extends CI_Model {

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
	 * Common Cruise SQL Conditions
	 *
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function _common_cruise_condition($alias = 'c'){
		
		$this->db->where($alias.'.status', STATUS_ACTIVE);
		
		$this->db->where($alias.'.deleted !=', DELETED);
		
		$this->db->where('('.$alias.'.language_id = 0 OR '.$alias.'.language_id = ' . lang_id() . ')');
	}
	
	/**
	 * 
	 * Get Top 4 Cruise Deals of Halong Bay or Mekong River
	 *
	 * @author Khuyenpv
	 * @since 09.04.2015
	 */
	function get_cruise_deals($cruise_port, $cruise_stars = array(), $cruise_types = array(), $limit = 4)
    {
		$service_type = $cruise_port == 0 ? 1 : 2; // Halong Bay or Mekong
		
		$today = date(DB_DATE_FORMAT);
		
		$this->db->select('t.id, t.name, t.url_title, t.picture, t.brief_description, t.short_description, t.review_number, t.total_score, t.show_partner,
						   pt.note as offer_note, c.star, pt.max_offer_rate, t.route_highlight,
						   ptn.short_name as partner_name,
						   p.id as p_id, p.name as p_name, p.book_from, p.book_to, p.stay_from, p.stay_to, p.check_in_on, p.note, p.promotion_condition, p.is_specific_dates, p.promotion_type,	
						   p.day_before');
		
		$this->db->from('promotion_tours as pt');
		
		$this->db->join('tours as t', 't.id = pt.tour_id');
		
		$this->db->join('promotions as p', 'p.id = pt.promotion_id');
		
		$this->db->join('cruises as c', 'c.id = t.cruise_id');
		
		$this->db->join('partners as ptn', 'ptn.id = t.partner_id');
	
		$this->_common_tour_condition(); // status, deleted, language_id
		
		$this->db->where('pt.visibility', STATUS_ACTIVE); // show only promotion_tour has the visibility = 1s
		
		// promotion in the future
		$this->db->where('p.stay_to >= ', $today);
		$this->db->where('p.book_to >= ', $today);
		//$this->db->where('p.display_on & '. pow(2,date('w',strtotime($today))).' > 0');
		

		$this->db->where('p.status', STATUS_ACTIVE);
		
		$this->db->where('p.deleted !=', DELETED);
		
		$this->db->where('p.is_hot_deals', STATUS_ACTIVE); // only show hot-deal
		
		//$this->db->where('p.service_type', $service_type); // show by promotion type
		
		if(is_visitor_in_hanoi()){
			$this->db->where('p.apply_for_hanoi', STATUS_ACTIVE); // if Hanoi Visitor: only show Promootion apply for Hanoi
		}
		
		
		$this->db->where('c.cruise_destination', $cruise_port);
		
		if(!empty($cruise_stars)){
			$this->db->where_in('c.star', $cruise_stars); // hot deals by Cruise Stars
		}
		
		if(!empty($cruise_types)){
			
			$sql_types = '(';
			
			foreach ($cruise_types as $key => $value){
				$sql_types .= 'c.types & '.pow(2, $value) .' > 0';
				
				if ($key < count($cruise_types) - 1){
					$sql_types .= ' OR ';
				}
			}
			
			$sql_types .= ')';
			
			$this->db->where($sql_types); // hot deals by Cruise Types
		}
		
		
		$this->db->order_by('pt.position');
		
		if(!empty($limit)){
			$this->db->limit($limit); // get first 4 hot deals
		}
	
		$query = $this->db->get();

		$tours = $query->result_array();
		
		$promotions = array();
	
		foreach ($tours as $key => $tour){
			
			$pro['id'] = $tour['p_id'];
			unset($tour['p_id']);
			
			$pro['name'] = $tour['p_name'];
			unset($tour['p_name']);
			
			$pro['book_from'] = $tour['book_from'];
			unset($tour['book_from']);
			
			$pro['book_to'] = $tour['book_to'];
			unset($tour['book_to']);
			
			$pro['stay_from'] = $tour['stay_from'];
			unset($tour['stay_from']);
			
			$pro['stay_to'] = $tour['stay_to'];
			unset($tour['stay_to']);
			
			$pro['check_in_on'] = $tour['check_in_on'];
			unset($tour['check_in_on']);
			
			$pro['note'] = $tour['note'];
			unset($tour['note']);
			
			$pro['offer_note'] = $tour['offer_note'];
			unset($tour['offer_note']);
			
			$pro['promotion_condition'] = $tour['promotion_condition'];
			unset($tour['promotion_condition']);
			
			$pro['is_specific_dates'] = $tour['is_specific_dates'];
			unset($tour['is_specific_dates']);
			
			$pro['promotion_type'] = $tour['promotion_type'];
			unset($tour['promotion_type']);
			
			$pro['day_before'] = $tour['day_before'];
			unset($tour['day_before']);
			
			$promotions[] = $pro;
			
			$tours[$key] = $tour;
		}
		
		$promotions = $this->Tour_Model->get_travel_dates($promotions);
		
		foreach($tours as $key => $tour){
			
			$pro = $promotions[$key];
			
			$tour['promotion'] = $promotions[$key];
			
			$promotion_id = $pro['id'];
			$date_of_price = $today;
			
			if(!empty($pro['specific_dates'])){
				$date_of_price = $pro['specific_dates'][0]['date']; //first date of specific dates
			} elseif($pro['stay_from'] > $today){
				$date_of_price = $pro['stay_from']; // stay-from of the promotion
			}
			
			$tour['price'] = $this->get_cruise_deal_price_from($tour['id'], $promotion_id, $date_of_price);
			
			$tours[$key] = $tour;
		}
		
	
        return $tours;
	}
	
	/**
	 * Get the cruise deal price from
	 * 
	 * @author Khuyenpv
	 * @since 09.04.2015
	 */
	function get_cruise_deal_price_from($tour_id, $promotion_id, $date_of_price){
		
		$this->db->select('price_origin, price_from');
		$this->db->from('tour_price_froms');
		$this->db->where('tour_id', $tour_id);
		$this->db->where('promotion_id', $promotion_id);
		$this->db->where("(start_date is NULL or start_date <= '".$date_of_price."')");
		$this->db->where("(end_date is NULL or end_date >= '".$date_of_price."')");
	
		$query = $this->db->get();
		
		$prices = $query->result_array();
		
		if(!empty($prices)){
			return $prices[0];
		}
		
		return array();
	}
	
	/**
	 * Get current cruise special offers
	 * 
	 * @author Khuyenpv
	 * @since 09.04.2015
	 */
	function get_cruise_special_offers($cruises){
		
		if(empty($cruises)) return $cruises;
		$cruise_ids = array();
		foreach ($cruises as $cruise){
			$cruise_ids[] = $cruise['id'];
		}
		
		$today = date(DB_DATE_FORMAT);
		
		$this->db->select('p.id, p.name, p.book_from, p.book_to, p.stay_from, p.stay_to, p.check_in_on, p.note, p.promotion_condition, 
						   p.is_specific_dates, p.promotion_type, pt.note as offer_note, p.day_before,
						   c.id as cruise_id');
		
		$this->db->from('promotion_tours as pt');
		
		$this->db->join('tours as t', 't.id = pt.tour_id');
		
		$this->db->join('promotions as p', 'p.id = pt.promotion_id');
		
		$this->db->join('cruises as c', 'c.id = t.cruise_id');
		
		$this->db->where('pt.note != ','');
		
		// promotion in the future
		$this->db->where('p.stay_to >= ', $today);
		$this->db->where('p.book_to >= ', $today);
		//$this->db->where('p.display_on & '. pow(2,date('w',strtotime($today))).' > 0');
		
		
		$this->db->where('p.status', STATUS_ACTIVE);
		
		$this->db->where('p.deleted !=', DELETED);
		
		$this->db->where('p.is_hot_deals', STATUS_ACTIVE); // only show hot-deal
		
		if(is_visitor_in_hanoi()){
			$this->db->where('p.apply_for_hanoi', STATUS_ACTIVE); // if Hanoi Visitor: only show Promootion apply for Hanoi
		}
		
		$this->db->where_in('c.id', $cruise_ids);
		
		$this->db->order_by('p.position','asc');
		
		$query = $this->db->get();
		
		$promotions = $query->result_array();
		
		$promotions = $this->Tour_Model->get_travel_dates($promotions);
		
		foreach ($cruises as $key=>$cruise){
			
			$cruise['promotions'] = array();
			
			foreach ($promotions as $pro){
				
				if($pro['cruise_id'] == $cruise['id']){
					
					$is_added = false;
					
					foreach ($cruise['promotions'] as $v){
						if($pro['id'] == $v['id']) $is_added = true;
					}
					
					if(!$is_added){
						$cruise['promotions'][] = $pro;
					}
				}
				
			}
			
			$cruises[$key] = $cruise;
			
		}
		
		
		return $cruises;
	}
	
	/**
	 * Get Price From for list of Cruises
	 * 
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function get_cruise_price_from_ajax($cruise_ids, $departure_date){
		
		if(empty($cruise_ids)) return array();
		
		$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));
		
		$this->db->select('tpf.price_origin, tpf.price_from, t.service_includes, t.service_excludes, c.id as cruise_id, p.is_hot_deals');
		
		$this->db->from('tour_price_froms as tpf');
		
		$this->db->join('tours as t', 't.id = tpf.tour_id');
		
		$this->db->join('cruises as c', 'c.id = t.cruise_id');
		
		$pro_sql = create_tour_promotion_condition($departure_date);
		
		$this->db->join('promotions as p', 'p.id = tpf.promotion_id AND '.$pro_sql, 'left outer');
	
		$this->_common_tour_condition();
		
		$this->db->where_in('c.id', $cruise_ids);
		
		$this->db->where('(tpf.start_date is NULL or tpf.start_date <="'.$departure_date.'")');
		
		$this->db->where('(tpf.end_date is NULL or tpf.end_date >="'.$departure_date.'")');
		
		$this->db->where('tpf.promotion_id = 0 or tpf.promotion_id=p.id');
		
		$this->db->order_by('tpf.price_from');
		
		$query = $this->db->get();
		
		$prices = $query->result_array();
		
		$ret = array();
		
		foreach($cruise_ids as $cruise_id){
		
			foreach ($prices as $value){
				
				if($value['cruise_id'] == $cruise_id){
					
					$ret[] = $value;
					
					break;
				}
				
			}
			
			
		}
		
		
		return $ret;
	}
	
	/**
	 * Get Price From for list of Cruises
	 *
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function get_cruise_price_froms($cruises, $departure_date){
	
		if(empty($cruises)) return array();
		
		$cruise_ids = array();
		
		foreach ($cruises as $cruise){
			$cruise_ids[] = $cruise['id'];
		}
	
		$departure_date = date(DB_DATE_FORMAT, strtotime($departure_date));
	
		$this->db->select('tpf.price_origin, tpf.price_from, c.id as cruise_id, p.is_hot_deals');
	
		$this->db->from('tour_price_froms as tpf');
	
		$this->db->join('tours as t', 't.id = tpf.tour_id');
	
		$this->db->join('cruises as c', 'c.id = t.cruise_id');
	
		$pro_sql = create_tour_promotion_condition($departure_date);
	
		$this->db->join('promotions as p', 'p.id = tpf.promotion_id AND '.$pro_sql, 'left outer');
	
		$this->_common_tour_condition();
	
		$this->db->where_in('c.id', $cruise_ids);
	
		$this->db->where('(tpf.start_date is NULL or tpf.start_date <="'.$departure_date.'")');
	
		$this->db->where('(tpf.end_date is NULL or tpf.end_date >="'.$departure_date.'")');
		
		$this->db->where('tpf.promotion_id = 0 or tpf.promotion_id=p.id');
	
		$this->db->order_by('tpf.price_from');
	
		$query = $this->db->get();
	
		$price_froms = $query->result_array();

		 
		foreach ($cruises as $key => $cruise){
	
			$price = array();
	
			foreach ($price_froms as $pr){
				 
				if($pr['cruise_id'] == $cruise['id']){
	
					$price = $pr;
	
					break;
				}
			}
	
			$cruise['price'] = $price;
	
			$cruises[$key] = $cruise;
		}
		
		return $cruises;
	}
	
	
	
	/**
	 * Get the most recommended cruises for Halong Bay Cruises or Mekong River Cruises
	 *
	 * @author toanlk
	 * @since  Mar 13, 2015
	 */
	function get_most_recommended_cruises($type, $limit = LIMIT_TOUR_ON_TAB, $offset = null)
    {
        $this->db->select(
            'c.id, c.name, c.url_title, c.star, c.num_cabin, c.picture, c.num_reviews as review_number, c.review_score as total_score, 
		    c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id');
        
        $this->db->join('partners p', 'p.id = c.partner_id', 'left outer');
        
        $this->_common_cruise_condition();
        
        $this->db->where('p.deleted !=', DELETED);
        
        $this->_set_cruise_port_and_type($type);
        
        if (! empty($limit))
        {
            if (! empty($offset))
            {
                $this->db->limit($limit, $offset);
            }
            else
            {
                $this->db->limit($limit);
            }
        }
        
        $this->db->order_by('c.position', 'asc');
        
        $query = $this->db->get('cruises c');
   
        $cruises = $query->result_array();
        
        $cruises = $this->get_cruise_special_offers($cruises);
        
        $is_mobile = is_mobile();
        
        foreach ($cruises as $key => $cruise){
        	
        	$pro = $cruise['promotions'];
      	
        	// show the only the first promotion available
        	$cruise['special_offers'] = empty($pro) ? '' : load_promotion_popup($is_mobile, $pro, TOUR, true);
        	
        	$cruises[$key] = $cruise;
        }
        
        return $cruises;
    }
    
    function get_cruises_by_type($type)
    {
        $this->db->select(
            'c.id, c.name, c.url_title, c.star, c.types, c.cabin_index, c.num_cabin, c.picture, c.num_reviews as review_number, c.review_score as total_score,
		    c.description, c.cabin_type, c.is_new, c.cruise_destination, p.short_name as partner_name, p.id as partner_id');
        
        $this->db->join('partners p', 'p.id = c.partner_id', 'left outer');
        
        $this->_common_cruise_condition();
        
        $this->db->where('p.deleted !=', DELETED);
        
        $this->_set_cruise_port_and_type($type);
        
        $this->db->order_by('c.position', 'asc');
        
        $query = $this->db->get('cruises c');
        
        $cruises = $query->result_array();
        
        return $cruises;
    }
    
    function _set_cruise_port_and_type($type)
    {
        // set cruise port
        switch ($type)
        {
            case HALONG_CRUISE_PAGE:
            case LUXURY_HALONG_CRUISE_PAGE:
            case DELUXE_HALONG_CRUISE_PAGE:
            case CHEAP_HALONG_CRUISE_PAGE:
            case CHARTER_HALONG_CRUISE_PAGE:
            case DAY_HALONG_CRUISE_PAGE:
            case FAMILY_HALONG_CRUISE_PAGE:
            case HONEY_MOON_HALONG_CRUISE_PAGE:
            case HALONG_BAY_BIG_SIZE_CRUISE_PAGE:
            case HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE:
            case HALONG_BAY_SMALL_SIZE_CRUISE_PAGE:
                $this->db->where('c.cruise_destination', HALONG_CRUISE_DESTINATION);
                break;
            case MEKONG_CRUISE_PAGE:
            case VIETNAM_CAMBODIA_CRUISE_PAGE:
            case VIETNAM_CRUISE_PAGE:
            case LAOS_CRUISE_PAGE:
            case THAILAND_CRUISE_PAGE:
            case BURMA_CRUISE_PAGE:
            case LUXURY_MEKONG_CRUISE_PAGE:
            case DELUXE_MEKONG_CRUISE_PAGE:
            case CHEAP_MEKONG_CRUISE_PAGE:
            case PRIVATE_MEKONG_CRUISE_PAGE:
            case DAY_MEKONG_CRUISE_PAGE:
                $this->db->where('c.cruise_destination', MEKONG_CRUISE_DESTINATION);
                break;
        }
        
        // set cruise type
        switch ($type)
        {
            // Halong & Mekong Cruises
            case LUXURY_HALONG_CRUISE_PAGE:
            case LUXURY_MEKONG_CRUISE_PAGE:
                $this->db->where('c.star >= 4.5');
                $this->db->where('c.types &' . pow(2, 1) . ' > 0');
                $this->db->where('c.num_cabin > 0');
                break;
            case DELUXE_HALONG_CRUISE_PAGE:
                $this->db->where('c.star < 4.5 AND c.star >= 3.5');
                $this->db->where('c.types &' . pow(2, 1) . ' > 0');
                $this->db->where('c.num_cabin > 0');
                break;
            case CHEAP_HALONG_CRUISE_PAGE:
                $this->db->where('c.star < 3.5');
                $this->db->where('c.types &' . pow(2, 1) . ' > 0');
                $this->db->where('c.num_cabin > 0');
                break;
            case CHARTER_HALONG_CRUISE_PAGE:
            case PRIVATE_MEKONG_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 2) . ' > 0');
                break;
            case DAY_HALONG_CRUISE_PAGE:
            case DAY_MEKONG_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 3) . ' > 0');
                break;
            case FAMILY_HALONG_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 4) . ' > 0');
                break;
            case HONEY_MOON_HALONG_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 5) . ' > 0');
                break;
            case HALONG_BAY_BIG_SIZE_CRUISE_PAGE:
                $this->db->where('c.cabin_index', 8);
                break;
            case HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE:
                $this->db->where('c.cabin_index', 4);
                break;
            case HALONG_BAY_SMALL_SIZE_CRUISE_PAGE:
                $this->db->where('(c.cabin_index = 2 OR c.cabin_index = 1)');
                break;

            // Mekong Cruises
            case VIETNAM_CAMBODIA_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 6) . ' > 0');
                break;
            case VIETNAM_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 7) . ' > 0');
                break;
            case LAOS_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 8) . ' > 0');
                break;
            case THAILAND_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 9) . ' > 0');
                break;
            case BURMA_CRUISE_PAGE:
                $this->db->where('c.types &' . pow(2, 10) . ' > 0');
                break;
        }
    }
   
	
	/**
	 * Khuyenpv Feb 25 2015
	 * Get all cruise for footer page links
	 */
	function get_all_cruises($cruise_port){
		
		$this->db->select('c.id, c.name, c.url_title');
		
		$this->db->from('cruises as c');
		
		$this->db->where('c.cruise_destination', $cruise_port);
		
		$this->_common_cruise_condition();
		
		$query = $this->db->get();
		
		$cruises = $query->result_array();
		
		return $cruises;
	}
	
	/**
	 * Khuyenpv Feb 27 2015
	 * Get the cruise detail
	 */
	function get_cruise_detail($url_title){
		
		$this->db->select(
            'c.id, c.name, c.url_title, c.star, c.is_new, c.address, c.types, c.review_score, c.review_score as total_score, c.num_reviews as review_number, c.cruise_destination, c.description, 
		    c.shuttle_bus, c.check_in, c.check_out, c.children_extra_bed, c.cancellation_prepayment, c.guide, c.note, c.picture, c.num_cabin, c.cabin_type, p.short_name as partner_name');
		
		$this->db->from('cruises c');
		
		$this->db->join('partners as p', 'p.id = c.partner_id');
		
		$this->db->where('c.url_title', $url_title);
		
		$this->db->where('c.deleted !=', DELETED);
		
		$query = $this->db->get();
		
		$cruises = $query->result_array();
		
		if (empty($cruises))
        {
            $cruises = $this->get_cruise_by_url_history($url_title);
        }
		
		// get all promotion available for this cruise
		$cruises = $this->get_cruise_special_offers($cruises);
		
		
		return count($cruises) > 0 ? $cruises[0] : FALSE;
	}
	
	/**
	 * get_cruise_by_url_history
	 *
	 * @author toanlk
	 * @since  Apr 22, 2015
	 */
	function get_cruise_by_url_history($url_title) {
	
	    $this->db->select(
            'id, name, url_title, url_title_history, star, is_new, address, types, review_score, review_score as total_score, num_reviews as review_number, cruise_destination, description, 
		    shuttle_bus, check_in, check_out, children_extra_bed, cancellation_prepayment, guide, note, picture,  num_cabin, cabin_type');
		
		$this->db->from('cruises');
	    	
	    $this->db->like('url_title_history', $url_title);
	    	
	    $this->db->where('deleted !=', DELETED);
	    	
	    $query = $this->db->get();
	    	
	    $cruises = $query->result_array();

	    foreach ($cruises as $cruise) {
	        $url_title_history = $cruise['url_title_history'];
	        	
	        $arr_name = explode(',', $url_title_history);
	        foreach ($arr_name as $str_name) {
	            if($str_name == $url_title) {
	                	
	                $crs = array();
	                $crs[] = $cruise;
	                return $crs;
	            }
	        }
	    }
	
	    return null;
	}
	
	/**
	 * Get all the photos of a cruise
	 *
	 * @author toanlk
	 * @since  Mar 31, 2015
	 */
	function get_cruise_photos($cruise_id)
    {
        /* $this->db->select('id, name, caption');
        $this->db->where('cruise_id', $cruise_id);
        $this->db->order_by('position', 'asc');
        $query = $this->db->get('cruise_photos'); */
        
        $sql = "SELECT id, name, caption FROM (cruise_photos) ";
        $sql .= "WHERE cruise_id =  '".$cruise_id."' ORDER BY FIELD (type, 2,1,3) , position asc";
        
        $query = $this->db->query($sql);
        
        $results = $query->result_array();
        
        return $results;
    }

	/**
	 * Get all the videos of a Cruise
	 *
	 * @author toanlk
	 * @since  Apr 7, 2015
	 */
	function get_cruise_videos($cruise_id)
    {
        $this->db->select('cv.id, cv.name, cv.code, c.name as cruise_name');
        
        $this->db->join('cruises as c', 'c.id = cv.cruise_id');
        
        $this->db->where('cv.cruise_id', $cruise_id);
       
        $query = $this->db->get('cruise_videos cv');
        
        $rerutls = $query->result_array();
        
        return $rerutls;
    }
    
    
    /**
     * Get all cruise cabins
     *
     * @author Khuyenpv
     * @since 15.04.2015
     */
    function get_cruise_cabins($cruise_id){
    	 
    	$this->db->select('id, name, picture, cabin_size, bed_size, max_person, description');
    	 
    	$this->db->from('cruise_cabins');
    	
    	$this->db->where('cruise_id', $cruise_id);
    	
    	$this->db->where('type', STATUS_INACTIVE); // cabin
    	
    	$this->db->where('status', STATUS_ACTIVE);
    	
    	$this->db->where('deleted !=', DELETED);
    	 
    	$this->db->order_by('position');
    
    	$query = $this->db->get();
    
    	$results = $query->result_array();
    
    	foreach ($results as $key => $value){
    			
    		$value['facilities'] = $this->Tour_Model->get_cruise_cabin_facilities($value['id']);
    			
    		$results[$key] = $value;
    	}
    		
    	return $results;
    }
    
	
	/**
	 * Khuyenpv Feb 28 2015
	 * Get all tours of Cruise
	 */
	function get_cruise_tours($cruise_id){
		
		$this->db->select('t.id, t.name, t.url_title, t.picture, t.route, t.review_number, t.total_score
		    , t.cancellation_policy, t.children_extrabed, t.service_includes, t.service_excludes
		    , t.cruise_id, t.tour_highlight, t.duration, t.main_destination_id, t.group_type, c.cruise_destination, c.num_cabin, c.types');
		
		$this->db->join('cruises as c', 'c.id = t.cruise_id');
		
		$this->db->where('t.cruise_id', $cruise_id);
		
		$this->_common_tour_condition();
		
		$this->db->order_by('t.duration');
		
		$query = $this->db->get('tours t');
		
		$tours = $query->result_array();

		return $tours;
	}
	
	
	/**
	 * Get All Cruise Cabins
	 * 
	 * 
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
	 * Get similar cruise
	 *
	 * @author toanlk
	 * @since  Mar 31, 2015
	 */
	function get_similar_cruises($cruise)
    {
        $this->db->select(
            'c.id, c.name, c.star, c.cabin_type, c.review_score as total_score, c.url_title, c.num_reviews as review_number, c.picture, 
            p.short_name as partner_name, p.id as partner_id');
        
        $this->db->from('cruises as c');
        
        $this->db->join('partners as p', 'p.id = c.partner_id');
        
        $this->db->where('c.cruise_destination', $cruise['cruise_destination']);
        
        $this->db->where('c.id !=', $cruise['id']);
        
        $this->_common_cruise_condition();
     
        
        $this->db->where('c.types &'.$cruise['types'].' > 0');
        
        if ($cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION)
        {
            // luxury, mid-range, cheap (not day or private cruises)
            if (!is_bit_value_contain($cruise['types'], 2) && !is_bit_value_contain($cruise['types'], 3))
            {
                if ($cruise['star'] >= 4.5)
                {
                    $this->db->where('c.star >=', 4.5);
                }
                elseif ($cruise['star'] >= 3.5)
                {
                    $this->db->where('c.star >=', 3.5);
                    $this->db->where('c.star <', 4.5);
                }
                else
                {
                    $this->db->where('c.star <', 3.5);
                }
            }
        }
        
        $this->db->order_by("c.position", "asc");
        
        $this->db->limit(4);
        
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        return $results;
    }
    
    /**
     * get cruise facilities
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_facilities($cruise_id) {
        $this->db->select('f.id, f.name, f.important, f.hotel_facility_type');
        
        $this->db->from('cruise_facilities as cf');
        
        $this->db->join('facilities as f', 'f.id = cf.facility_id');
        
        $this->db->where('cf.cruise_id', $cruise_id);
        
        $this->db->where('cf.value', STATUS_ACTIVE);
        
        $this->db->where('cf.deleted !=', DELETED);
        
        $this->db->where('f.status', STATUS_ACTIVE);
        
        $this->db->where('f.deleted !=', DELETED);
        
        $this->db->order_by('f.name', 'asc');
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * get cruise properties
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_properties($cruise_id)
    {
        $this->db->from('cruise_properties');
        
        $this->db->where('cruise_id', $cruise_id);
        
        $this->db->or_where('cruise_id', '0');
        
        $this->db->order_by("position", "asc");
        
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        return $results;
    }
    
    /**
     * get cruise members
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_members($cruise_id)
    {
        $this->db->from('cruise_members');
        
        $this->db->where('cruise_id', $cruise_id);
        
        $this->db->order_by("id", "asc");
        
        $query = $this->db->get();
        
        $results = $query->result_array();
        
        foreach ($results as $key => $value)
        {
            
            $value['photos'] = $this->get_cruise_member_photos($value['id']);
            
            $results[$key] = $value;
        }
        
        return $results;
    }
    
    /**
     * get cruise member photos
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_member_photos($cruise_member_id){
    
        $this->db->from('cruise_photos');
    
        $this->db->where('cruise_member_id', $cruise_member_id);
    
        $query = $this->db->get();
    
        $results = $query->result_array();
    
        return $results;
    }
    
    /**
     * get cruise member properties
     *
     * @author toanlk
     * @since  Mar 31, 2015
     */
    function get_cruise_member_properties($cruise_id){
    
        $this->db->from('cruise_member_properties');
    
        $this->db->where('cruise_id', $cruise_id);
    
        $query = $this->db->get();
    
        $results = $query->result_array();
    
        $ret = array();
    
        foreach ($results as $value){
            	
            $ret[$value['cruise_property_id']][$value['cruise_member_id']] = $value;
        }
    
        return $ret;
    }
    
    /**
     * get cruise files
     *
     * @author toanlk
     * @since  Apr 1, 2015
     */
    function get_cruise_files($cruise_id)
    {
        $this->db->from('cruise_files');
        
        $this->db->where('cruise_id', $cruise_id);
        
        $query = $this->db->get();
        
        return $query->result_array();
    }
    
    /**
     * get rich snippet review
     *
     * @author toanlk
     * @since  Apr 1, 2015
     */
    function get_rich_snippet_review($type)
    {
        $this->db->select('gr.total_review_score');
        $this->db->join('tours AS t', 'gr.review_for_id = t.id', 'left');
        $this->db->join('cruises AS c', 't.cruise_id = c.id', 'left');
        $this->db->where('gr.deleted !=', DELETED);
    
        $this->_set_cruise_port_and_type($type);

        if($type == HALONG_CRUISE_PAGE) {
            $this->db->where('c.cruise_destination', HALONG_CRUISE_DESTINATION);
        } elseif($type == MEKONG_CRUISE_PAGE) {
            $this->db->where('c.cruise_destination', HALONG_CRUISE_DESTINATION);
        }
    
        $query = $this->db->get('guest_reviews AS gr');
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
    
        return array('review_score' => $review_score, 'review_numb' => $review_numb);
    }
    
    /**
     * Get top popular Cruises
     * using in Home page
     * 
     * @author Khuyenpv
     * @since 09.04.2015
     */
    function get_popular_cruises($cruise_port){
    	
    	$this->db->select('c.id, c.name, c.url_title, c.star, c.is_new');
    	
    	$this->db->where('c.num_cabin >', 0);
    	
    	if ($cruise_port != ''){
    	
    		$this->db->where('c.cruise_destination', $cruise_port);
    	}
    	
    	$this->_common_cruise_condition();
    	
    	$this->db->order_by('c.position');
    	
    	$this->db->limit(20);
    	
    	$query = $this->db->get('cruises as c');
    	
    	$results = $query->result_array();
    	
    	return $results;
    }
}