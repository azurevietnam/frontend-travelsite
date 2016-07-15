<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Review Model
 *
 * @author toanlk
 * @since  Mar 27, 2015
 */
class Review_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	function get_reviews($search_criteria, $offset = 0, $num = 10){

	    $this->db->select('r.id, r.guest_name, r.total_review_score as total_score, r.review_date, r.positive_review, r.negative_review,
	         r.guest_city, r.guest_country');

	    $this->_build_search_condition($search_criteria);

	    $this->db->order_by("r.review_date", "desc");

	    $query = $this->db->get('guest_reviews r', $num, $offset);

	    $results = $query->result_array();

	    return $results;
	}

	function get_num_reviews($search_criteria)
    {
        $this->_build_search_condition($search_criteria);

        return $this->db->count_all_results('guest_reviews r');
    }

	function get_review_scores($search_criteria) {

	    $this->db->select('sc.score score, sc.score_type, sc.review_id');

	    $this->db->from('review_score sc');

	    $this->db->join('guest_reviews r', 'r.id = sc.review_id');

	    $this->_build_search_condition($search_criteria);

	    $query = $this->db->get();

	    return $query->result_array();
	}

	function _build_search_condition($search_criteria) {

	    $this->db->where('r.deleted !=', DELETED);

	    if( !empty($search_criteria['review_score']) ) {

	        switch ($search_criteria['review_score']) {
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
	    }

	    if( !empty($search_criteria['hotel_id']) ) {
	        $this->db->where_in('r.review_for_id', $search_criteria['hotel_id']);
	    }

	    if( !empty($search_criteria['tour_id']) ) {
	        $this->db->where_in('r.review_for_id', $search_criteria['tour_id']);
	    }

	    if( !empty($search_criteria['cruise_id']) && !empty($search_criteria['tour_ids']) ) {
	        $this->db->where_in('r.review_for_id', $search_criteria['tour_ids']);
	    }

	    if( isset($search_criteria['review_for_type']) ) {
	        $this->db->where('r.review_for_type', $search_criteria['review_for_type']);
	    }

	    if( isset($search_criteria['customer_type']) ) {
	        $this->db->where('guest_type', $search_criteria['customer_type']);
	    }
	}

	function get_review_object($search_criteria, $url_title) {

	    if(!empty($search_criteria['tour_id'])) {

	        $this->db->select('id, name, url_title, review_number, cruise_id');

	        $this->db->where('url_title', $url_title);

	        $this->db->limit(1);

	        $query = $this->db->get('tours');

	        $results = $query->result_array();

            return count($results) > 0 ? $results[0] : null;
	    }

	    if(!empty($search_criteria['cruise_id'])) {

	        $this->db->select('id, name, url_title, num_reviews as review_number');

	        $this->db->where('url_title', $url_title);

	        $this->db->limit(1);

	        $query = $this->db->get('cruises');

	        $results= $query->result_array();

	        return count($results) > 0 ? $results[0] : null;
	    }

        if(!empty($search_criteria['hotel_id'])) {

            $this->db->select('id, name, url_title, review_number');

            $this->db->where('url_title', $url_title);

            $this->db->limit(1);

            $query = $this->db->get('hotels');

            $results = $query->result_array();

            return count($results) > 0 ? $results[0] : null;
        }

	    return null;
	}
}