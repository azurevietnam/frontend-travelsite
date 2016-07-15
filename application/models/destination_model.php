<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destination_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Khuyenpv Feb 09 2015s
	 * Get Destination Object using in tour pages
	 *
	 * @update toanlk - Mar 12, 2015
	 */
	function get_destination_4_tour($url_title){

		$this->db->select('id, name, title, url_title, destination_type, picture, parent_id, tour_heading, tour_title, tour_keywords, tour_description, number_tours');

		$this->db->where('url_title', $url_title);

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get('destinations');

		$destinations = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($destinations) >0) {

			return $destinations[0];

		}

		return FALSE;
	}


    /**
     * TinVM May 25 2015
     * Get Destination Object using in hotel pages
     *
     */
    function get_destination_4_hotel($url_title){

        $this->db->select('id, name, title, url_title, destination_type as type, parent_id, hotel_heading, hotel_title, hotel_keywords, hotel_description, number_hotels');

        $this->db->where('url_title', $url_title);

        $this->db->where('deleted !=', DELETED);

        $query = $this->db->get('destinations');

        $destinations = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

        $destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

        if (count($destinations) >0) {

            return $destinations[0];

        }

        return FALSE;
    }
	/**
	 * Khuyenpv Feb 10 2015
	 * Get Travel Style Object using in tour pages
	 */
	function get_travel_style_4_tour($url_title){

	    $url_title = str_replace('-', ' ', $url_title);
	    $url_title = str_replace('_', ' ', $url_title);

		$this->db->select('id, name, url_title');

		//$this->db->where('url_title', url_title($url_title));
		// url-title could be a shorten name, use 'like' instead of 'where' (toanlk- 29/06/2015)
		$this->db->like('url_title', url_title($url_title), 'both');

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get('travel_styles');

		$travel_styles = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'travel_styles');

		$travel_styles = update_i18n_data($travel_styles, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($travel_styles) >0) {

			return $travel_styles[0];

		}

		return FALSE;
	}

	/**
	 * Khuyenpv Feb 12 2015
	 * Get all travel styles of a destinations
	 */
	function get_destination_travel_styles($destination_id){

		$this->db->select('ts.id, ts.name, dts.show_on_tab, ts.url_title');

		$this->db->from('destination_travel_styles as dts');

		$this->db->join('travel_styles ts','ts.id = dts.style_id');

		$this->db->where('dts.destination_id', $destination_id);

		$this->db->order_by('position', 'asc');

		$query = $this->db->get();

		$travel_styles = $query->result_array();

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'travel_styles');

		$travel_styles = update_i18n_data($travel_styles, I18N_MULTIPLE_MODE, $table_cnf);

		return $travel_styles;

	}

	/**
	 * Khuyenpv March 04 2015
	 * Get Destination for detail page
	 */
	function get_destination_detail($url_title){

		$this->db->select('id, name, title, url_title, destination_type as type,short_description, full_description, travel_tips, number_tours, picture');

		$this->db->where('url_title', $url_title);

		$this->db->where('deleted !=', DELETED);

		$query = $this->db->get('destinations');

		$destinations = $query->result_array();

		if(empty($destinations))
		{
		    $destinations = $this->get_destination_by_url_history($url_title);
		}

		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

		if (count($destinations) >0) {

			return $destinations[0];

		}

		return FALSE;
	}

	/**
	 * get_destination_by_url_history
	 *
	 * @author toanlk
	 * @since  Apr 22, 2015
	 */
	function get_destination_by_url_history($url_title) {

	    $this->db->select('id, name, title, url_title, url_title_history, destination_type as type,short_description, full_description, travel_tips, number_tours');

	    $this->db->like('url_title_history', $url_title);

	    $this->db->where('deleted !=', DELETED);

	    $query = $this->db->get('destinations');

	    $destinations = $query->result_array();

	    foreach ($destinations as $des) {
	        $url_title_history = $des['url_title_history'];

	        $arr_name = explode(',', $url_title_history);
	        foreach ($arr_name as $str_name) {
	            if($str_name == $url_title) {

	                $crs = array();
	                $crs[] = $des;
	                return $crs;
	            }
	        }
	    }

	    return null;
	}

	/**
	 * Khuyenpv March 04 2015
	 * Get Destination Photos
	 */
	function get_destination_photos($destination_id){
        $this->db->select('name, caption');

        $this->db->where('destination_id', $destination_id);

        $this->db->order_by('position', 'asc');

        $query = $this->db->get('destination_photos');

		return $query->result_array();
	}

	/**
	 * Khuyenpv March 04 2015
	 * Get most recommended tour in Destinations
	 */
	function get_tours_in_destination($destination_id){

		return array(1, 2);
	}

	/**
	 * Khuyenpv March 04 2015
	 * Get most recommended including destination
	 */
	function get_tours_including_destination($destination_id){

		return array(1, 2);
	}

	/**
	 * Khuyenpv March 04 2015
	 * get all things to do of a Destinations
	 */
	function get_things_to_do($destination_id, $limit = '', $offset = 0, $get_count = false){
        $this->db->select('a.id, a.name, a.url_title, a.title, a.description, a.picture');

        $this->db->from('activities a');

        $this->db->join('destinations d', 'a.destination_id = d.id');

        $this->db->where('d.id', $destination_id);

        $this->db->where('a.deleted !=', DELETED);

        $this->db->order_by('a.position', 'asc');

        if(!empty($limit))
            $this->db->limit($limit, $offset);

        if($get_count)
            $results = $this->db->count_all_results();

        else
        {
            $query = $this->db->get();

            $results = $query->result_array();

            $table_cnf[] = array('col_id_name' => 'destination_id','table_name' => 'activities');
            $table_cnf[] = array('col_id_name' => 'id','table_name' => 'destinations');

            $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        }
        return $results;
    }

    /**
     * Get things to do detail
     * @author TinVM
     * @since July 24 2015
     */
    function get_destination_activities_detail($activity_url){
        $this->db->select('id, name, description, url_title');

        $this->db->where('url_title', $activity_url);

        $this->db->where('deleted != ', DELETED);

        $this->db->where('status != ', STATUS_INACTIVE);

        $query = $this->db->get('activities');

        $result = $query->result_array();

        if(!empty($result))
            return $result[0];
        else
            return '';
    }

    function get_activity_photos($activity_id){
        $this->db->select('name, caption');

        $this->db->where('activity_id', $activity_id);

        $query = $this->db->get('activity_photos');

        return $query->result_array();
    }

	/**
	 * Khuyenpv March 04 2015
	 * get all attractions in a destination
	 */
	function get_attractions($destination_id, $limit = '', $offset = 0, $get_count = false, $is_highlight = false, $is_has_tour = null, $is_city = false)
	{
		$this->db->select('d.id, d.name, d.url_title, d.picture, d.short_description, d.number_tours, d.position, d.destination_type as type');

        $this->db->from('destination_places dp');

        $this->db->join('destinations des', 'des.id = dp.parent_id');

        $this->db->join('destinations d', 'd.id = dp.destination_id');

        $this->db->where('dp.parent_id', $destination_id);
           
        $this->db->where('d.deleted != ', DELETED);

        if($is_city == true)
        {
            $this->db->where('d.destination_type', DESTINATION_TYPE_CITY);
        }else {
        	$this->db->where('d.destination_type', DESTINATION_TYPE_ATTRACTION);
        }

        if($is_highlight) {
            $this->db->where('d.is_highlight_attraction', 1);
        }

        if(!empty($is_has_tour) && $is_has_tour) {
            $this->db->where('d.number_tours >', 0);
        }

        if(!empty($limit))
            $this->db->limit($limit, $offset);

        $this->db->order_by('d.position', 'asc');
        if($get_count)
            $results = $this->db->count_all_results();

        else {

            $query = $this->db->get();

            $results = $query->result_array();

            $table_cnf[] = array('col_id_name' => 'parent_id', 'table_name' => 'destination_places');
            $table_cnf[] = array('col_id_name' => 'id', 'table_name' => 'destinations');

            $table_cnf[] = array('col_id_name' => 'destination_id', 'table_name' => 'destination_places');
            $table_cnf[] = array('col_id_name' => 'id', 'table_name' => 'destinations');

            $colum_cnf[] = array('destinations', '*');

            $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);
        }

		return $results;
	}

	/**
	 * Khuyenpv March 04 2015
	 * get travel article of a destination
	 */
	function get_travel_articles($destination_id, $limit = '', $offset = 0, $get_count = false){
        $now = date(DB_DATE_FORMAT);

        // get apply on the day of the week
        $apply_on = date('w', strtotime($now));

        $this->db->select('id, name, url_title, picture, short_description, date_created');

        $this->db->from('articles');

        $this->db->where('destination_id', $destination_id);

        $this->db->where('status !=', STATUS_INACTIVE);

        $pr_where = "(`start_date` <= '" . $now . "'";
        $pr_where .= " AND (`end_date` is NULL OR `end_date` >= '" . $now . "'))";

        $this->db->where($pr_where);

        if(!empty($limit))
            $this->db->limit($limit, $offset);

        $this->db->order_by('position');

        if($get_count)

            $results = $this->db->count_all_results();

        else{

            $query = $this->db->get();

            $results = $query->result_array();

            $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'articles');

            $destinations = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);
        }

        return $results;
	}
    function get_list_useful_information($destination_id){
        $this->db->select('id, name, url_title');

        $this->db->where('destination_id', $destination_id);

        $this->db->where('deleted !=', DELETED);

        $this->db->order_by('position', 'asc');

        $query = $this->db->get('useful_information');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'useful_information');

        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
    }


	/**
	 * Khuyenpv March 04 2015
	 * Get a useful information detail
	 */
	function get_useful_information_detail($url_title){
        $this->db->select('id, name, url_title, destination_id, description');

        $this->db->from('useful_information');

        $this->db->where('url_title', $url_title);

        $query = $this->db->get();

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'useful_information');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

		return $results;
	}

	/**
	 * Khuyenpv March 04 2015
	 * Get article detail
	 */
	function get_article_detail($url_title){
        $this->db->select('id, name, url_title, services, short_description, full_description');

        $this->db->where('url_title', trim($url_title));

        $query = $this->db->get('articles');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'articles');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        if(!empty($results))
            return $results[0];
        else
            return '';
	}

    /**
     * TinVM Mar20 2015
     * Get other articles in destination contain the same service
     */

    function get_other_article($destination_id, $service_bit){
        $this->db->select('name, url_title');

        $this->db->where('destination_id', $destination_id);

        $this->db->where('services & '.$service_bit.' > 0' );

        $this->db->order_by('position', 'asc');

        $query = $this->db->get('articles');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'articles');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        if(!empty($results))
            return $results;
        else
            return '';
    }

	function get_cities_of_destination($destination_id)
    {
        $this->db->select('id, name, region, picture, number_tours, url_title, full_description');

        $this->db->where('is_top_tour', 1);

        $this->db->where('parent_id', $destination_id);

        $this->db->order_by('position', 'asc');

        $query = $this->db->get('destinations');

        $destinations = $query->result_array();

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'destinations');
        $destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

	    return $destinations;
	}

	/**
	 * get_recommendation_services
	 *
	 * @author toanlk
	 * @since  Mar 12, 2015
	 */
	function get_recommendation_services($destination_id, $service_id)
    {
        $this->db->select('ds_r.*, d.name, d.url_title');

        $this->db->from('recommendations r');

        $this->db->join('destination_services ds', 'r.destination_service_id = ds.id');

        $this->db->join('destination_services ds_r', 'r.recommend_service_id = ds_r.id');

        $this->db->join('destinations d', 'ds_r.destination_id = d.id');

        $this->db->where('ds.service_id', $service_id);

        $this->db->where('ds.destination_id', $destination_id);

        $this->db->order_by('r.order', 'asc');

        $query = $this->db->get();

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'recommendations');
        $table_cnf[] = array('col_id_name' => 'destination_service_id','table_name' => 'destination_services');

        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'recommendations');
        $table_cnf[] = array('col_id_name' => 'recommend_service_id','table_name' => 'destination_services');

        $table_cnf[] = array('col_id_name' => 'destination_id','table_name' => 'destination_services');
        $table_cnf[] = array('col_id_name' => 'id','table_name' => 'destinations');

        $colum_cnf[] = array('destination_services','*');
        $colum_cnf[] = array('destinations','name');

        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
    }

    /**
     * Get parent destinations of a destinations
     * Using in navigation link of Tour Destinatio or Hotel Destination
     *
     * @author Toanlk, modifed by Khuyenpv
	 * @since Mar 12 2015
     */
    function get_parent_destinations($destination_id)
    {
        $this->db->select('dp.parent_id as id, d.name, d.url_title, destination_type as type');

        $this->db->join('destinations d', 'dp.parent_id = d.id');

        $this->db->where('destination_id', $destination_id);

        $this->db->where('number_tours > ', 0);

        $this->db->where_in('destination_type', array(DESTINATION_TYPE_ATTRACTION, DESTINATION_TYPE_AREA, DESTINATION_TYPE_DISTRICT, DESTINATION_TYPE_CITY, DESTINATION_TYPE_COUNTRY));

        // khuyenpv: Country before City ...etc
        $this->db->order_by('destination_type', 'asc');

        $query = $this->db->get('destination_places dp');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
    }

    /**
     * -----------------------------------------------------------------------------------------
     * BEGIN OF FUNCTIONS FOR SEARCH TOURS
     * -----------------------------------------------------------------------------------------
     */

    /**
     * Get Sub-Destination for Search Filters
     *
     * Khuyenpv Mar 13 2015
     *
     */
    function get_sub_destination_4_filter($destination){

    	$this->db->select('d.id, d.name, d.destination_type as type');

		$this->db->from('destination_places as dp');

		$this->db->join('destinations as d', 'd.id = dp.destination_id');

		$this->db->where('dp.parent_id', $destination['id']);

		if($destination['type'] < DESTINATION_TYPE_COUNTRY){ // continent or region

			$this->db->where('d.type', DESTINATION_TYPE_COUNTRY); // get all children countries

		} elseif ($destination['type'] == DESTINATION_TYPE_COUNTRY){ // country

			$this->db->where('d.is_top_tour', STATUS_ACTIVE); // get the top - tour - destination

		} elseif (in_array($destination['type'], array(DESTINATION_TYPE_CITY, DESTINATION_TYPE_DISTRICT))){ // city or district

			$this->db->where('d.type', DESTINATION_TYPE_ATTRACTION); // attraction

			$this->db->where('d.is_highlight_attraction', STATUS_ACTIVE);
		}

		$this->db->where('d.deleted !=', DELETED);

		$this->db->order_by('d.position','asc');

		$query = $this->db->get();

		$destinations = $query->result_array();

		return $destinations;

    }

    /**
     * Get Cruise Facilities For Search Tour
     *
     * Khuyenpv Mar 13 2015
     *
     */
    function get_cruise_facilities_4_search(){

    	$this->db->select('id, name');

    	$this->db->from('facilities');

    	$this->db->where('status', STATUS_ACTIVE);

    	$this->db->where('deleted !=', DELETED);

    	$this->db->where('important', STATUS_ACTIVE);

    	$this->db->where_in('type', array(2,3)); // cruise & cruise cabin

    	$this->db->order_by('name','asc');

    	$query = $this->db->get();

    	$facilities = $query->result_array();

    	$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'facilities');
    	$facilities = update_i18n_data($facilities, I18N_MULTIPLE_MODE, $table_cnf);

    	return $facilities;
    }

    /**
     * Get Activities In a Destinations
     *
     * Khuyenpv Mar 13 2015
     *
     */
    function get_destination_activities($destination_id){

    	//$this->db->where('status',STATUS_ACTIVE);

    	$this->db->where('deleted !=', DELETED);

    	$this->db->where('destination_id', $destination_id);

    	$this->db->order_by('position','asc');

    	$query = $this->db->get('activities');

    	$activities = $query->result_array();

    	$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'activities');

    	$activities = update_i18n_data($activities, I18N_MULTIPLE_MODE, $table_cnf);

    	return $activities;

    }


    /**
     * Get Search Destination, using ing Tour Search & Hotel Search
     *
     * @author Khuyenpv
     * @since Mar 12 2015
     *
     */

    function get_search_destination($id){

    	$this->db->select('id, name, title, url_title, destination_type as type, destination_type, number_tours');

    	$this->db->where('id', $id);

    	$this->db->where('deleted !=', DELETED);

    	$query = $this->db->get('destinations');

    	$destinations = $query->result_array();

    	$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

    	$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

    	if (count($destinations) >0) {

    		return $destinations[0];

    	}

    	return FALSE;
    }

    /**
     * Get destination details
     *
     * @author toanlk
     * @since  Mar 20, 2015
     */
    function get_destination($id)
    {
        $this->db->select('id, name, title, url_title, destination_type, number_hotels');

        $this->db->where('id', $id);

        $this->db->where('deleted !=', DELETED);

        $query = $this->db->get('destinations');

        $destinations = $query->result_array();

        $table_cnf[] = array(
            'col_id_name' => 'id',
            'table_name' => 'destinations');

        $destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

        if (count($destinations) > 0)
        {

            return $destinations[0];
        }

        return FALSE;
    }

    /**
     * Search Destination for Search Tour Autocomplete Functions
     *
     * @author Khuyenpv
     * @since  Mar 9, 2015
     */
    function search_des_auto($prefetch_types, $name = '', $is_prefetch = true, $sevice_types = TOUR){

    	 $this->db->select('d.id, d.name, dp.name as parent_name,  d.destination_type');

    	$this->db->from('destinations d');

    	$this->db->join('destinations dp', 'dp.id = d.parent_id', 'left outer');

    	$this->db->where('d.deleted !=', DELETED);

    	if ($sevice_types == TOUR) {
    		//$this->db->where('d.number_tours >', 0);
    		
    		$sql_cond = '(EXISTS (SELECT 1 FROM tour_destinations tour_des WHERE tour_des.destination_id = d.id))';
    		
    		$this->db->where($sql_cond);
    		
    		
    	}else {
    		$this->db->where('d.number_hotels >', 0);
    	}
    	
    	if($is_prefetch){
    		$this->db->where_in('d.destination_type', $prefetch_types); // city & cruise
    	} else {
    		$this->db->where_not_in('d.destination_type', $prefetch_types);
    	}

    	if(!empty($name)){
    		$name = urldecode($name);
    		$this->db->like('d.name', $name);
    	}
    	
    	$query = $this->db->get();

    	$results = $query->result_array();
    	
    	return $results;
    	
    }


    /**
     * Get all Top Tour Destinations
     *
     * @author Khuyenpv
     * @since 09.04.2015
     */
    function get_top_destinations($is_top = 'is_top_tour')
    {

    	$this->db->select('id, name , region, picture, number_tours, url_title, parent_id');

    	$this->db->where($is_top, STATUS_ACTIVE);

    	$this->db->order_by('position');

    	$query = $this->db->get('destinations');


    	$destinations = $query->result_array();

    	$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
    	$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

    	return $destinations;
    }

    /**
     * Get land tour contain activities
     * @author TinVM
     * @since Apr 17 2015
     */
    function load_tour_contain_activity($activities){
        $this->db->select('t.id, t.name, t.url_title, tac.activity_id');

        $this->db->from('tour_activities tac');

        $this->db->join('tours t', 't.id = tac.tour_id');

        $this->db->join('tour_destinations td', 'td.tour_id = t.id');

        $this->db->where_in('tac.activity_id', $activities);

        $this->db->where('td.is_land_tour', STATUS_ACTIVE);

        $this->db->order_by('t.position', 'asc');

        $query = $this->db->get();

        return $query->result_array();
    }


    /**
     * Get destination by url_title
     * $author TinVM
     * $since May26 2015
     * @param $url_title
     * @return bool
     */
    function get_destination_by_url_title($url_title){
        $this->db->select('id, name, url_title, number_hotels, number_tours');

        $this->db->where('url_title', $url_title);

        $this->db->where('deleted != ', DELETED);

        $query = $this->db->get('destinations');

        $result = $query->result_array();

        if(!empty($result))
            return $result[0];
        else
            return false;
    }

    /**
     * Huutd 09.06.2015
     * Get Destination Info for Flight
     * @param unknown $url_title
     */
    function get_destination_flight_info($url_title){

    	$this->db->select('id, name, title, url_title, destination_code, general_info, travel_tips, flight_tips');

    	$this->db->where('url_title', $url_title);

    	$this->db->where('deleted !=', DELETED);

    	$query = $this->db->get('destinations');

    	$destinations = $query->result_array();

    	if (count($destinations) > 0) {

    		$des = $destinations[0];

    		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
    		$des = update_i18n_data($des, I18N_SINGLE_MODE, $table_cnf);

    		return $des;
    	}

    	return FALSE;

    }


    /**
     * Get all Photo useful information
     * @author TinVM
     * @since July 23 2015
     */
    function get_destination_useful_information_photos($useful_information_id){
        $this->db->select('name, caption');

        $this->db->from('useful_information_photos');

        $this->db->where('useful_information_id', $useful_information_id);

        $query = $this->db->get();

        return $query->result_array();
    }
}