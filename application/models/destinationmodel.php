<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DestinationModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
	
	}
	
	function get_destination_4_filter($destination_id){
		
		$this->db->select('id, name, type');
		
		$this->db->from('destinations');
		
		$this->db->where('id', $destination_id);
	
		$query = $this->db->get();
		
		$destinations = $query->result_array();
		
		if (count($destinations) > 0){
			
			$ret = $destinations[0];
			
			if ($ret['type'] == 1 || $ret['type'] == 2 || $ret['type'] == 3){
				
				$ret['sub_des'] = $this->get_sub_destination($ret['id'], $ret['type']);
				
			} else {
				
				$ret['sub_des'] = array();
				
			}
			
			
			return $ret;
			
		}
		
		return FALSE;
		
	}
	
	function get_sub_destination($parent_id, $parent_type){		

		$this->db->select('id, name, type');
		
		$this->db->from('destinations');
		
		$this->db->where('parent_id', $parent_id);
		
		if ($parent_type == 1){ // country
			
			$this->db->where('is_top', STATUS_ACTIVE);
			
		} elseif ($parent_type == 2 || $parent_type == 3){ // city or district
			
			$this->db->where('type', 4); // attraction
			
			$this->db->where('allow_filter',1);
		}
		
		$this->db->order_by('order_','asc');
	
		$query = $this->db->get();
		
		$destinations = $query->result_array();
		
		return $destinations;
		
	}
	
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
		
		return $facilities;
	}
	
	function get_system_activities(){
		
		$this->db->where('status',STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('destination_id', STATUS_INACTIVE);
		
		$this->db->order_by('name','asc');
		
		$query = $this->db->get('activities');
		
		$activities = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'activities');
		
		$activities = update_i18n_data($activities, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $activities;
		
	}
	
	function get_destination_overview($destination_id, $departure_date, $destination_name = ''){
		
		if ($destination_id == '' && $destination_name == '') return FALSE;
		
		$this->db->select('id, name, title, url_title, picture_name, general_info, detail_info, travel_tips');		
		
		$destination_name = trim($destination_name);
		
		if ($destination_name == '' && $destination_id != ''){

			$this->db->where('id', $destination_id);
			
		} elseif($destination_name != '') {
			
			$this->db->where('url_title', $destination_name);
			
		} 
				
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('destinations');
		
		$destinations = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);
		
		if(empty($destinations) && !empty($destination_name)) {
			$destinations = $this->checkDestinationURLHistory($destination_name);
		}
		
		if (count($destinations) >0) {
			
			$destination = $destinations[0];
			
			$destination['photos'] = $this->get_destination_photos($destination['id']);
			
			$destination['attractions'] = $this->get_destination_attractions($destination['id']);
			
			$destination['activities'] = $this->get_destination_activities($destination['id']);
			
			return $destination;
			
		}
		
		return false;
		
	}
	
	
	function get_activity_overview($activity_id, $activity_name){

		if ($activity_id == '' && $activity_name == '') return FALSE;
		
		$this->db->select('act.id, act.name, act.description, act.picture_name, act.destination_id, act.title, d.id, d.name as destination_name_en, d.name as destination_name');

		$this->db->from('activities act');
		
		$this->db->join('destinations d','d.id = act.destination_id','left outer');
		
		
		$activity_name = trim($activity_name);
		
		if ($activity_name == '' && $activity_id != ''){
			
			$this->db->where('act.id', $activity_id);
			
		} elseif($activity_name != '') {
			
			$this->db->where('act.url_title', $activity_name);
			
		} 
				
		//$this->db->where('status',STATUS_ACTIVE);
		
		$this->db->where('act.deleted !=', DELETED);		
		
		$query = $this->db->get();
		
		$activities = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'destination_id', 'table_name'=>'destinations');
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'activities');
		$colum_cnf[] = array('table_name'=>'destinations', 'col_name_db'=>'name', 'col_name_alias'=>'destination_name');
		
		$activities = update_i18n_data($activities, I18N_MULTIPLE_MODE, $table_cnf, $colum_cnf);
		
		
		if (count($activities) >0) {
			
			$activity = $activities[0];
			
			$activity['photos'] = $this->get_acitivity_photos($activity['id']);
	
			return $activity;
			
		}
		
		return false;
		
	}
	
	function get_destination_photos($destination_id){
		
		$this->db->select('picture_name, comment');
		
		$this->db->where('destination_id', $destination_id);
		
		$this->db->order_by('order_','asc');		
		
		$query = $this->db->get('destination_photos');
		
		$destination_photos =  $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destination_photos');
		
		$destination_photos = update_i18n_data($destination_photos, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $destination_photos;
		
	}
	
	function get_acitivity_photos($activity_id){
		
		$this->db->select('id, picture_name, comment');
		
		$this->db->where('activity_id', $activity_id);
		
		$this->db->order_by('order_','asc');		
		
		$query = $this->db->get('activity_photos');
		
		$activity_photos =  $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'activity_photos');
		
		$activity_photos = update_i18n_data($activity_photos, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $activity_photos;

	}
	
	
	function get_destination_attractions($destination_id){
		
		$this->db->select('id, name, picture_name, general_info');
		
		$this->db->where('parent_id', $destination_id);
		
		$this->db->where('type', 4); //attraction
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->order_by('order_','asc');		
		
		$query = $this->db->get('destinations');
		
		$destinations =  $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $destinations;
		
	}
	
	function get_destination_activities($destination_id){
		
		$this->db->select('id, name, description, picture_name');
		
		$this->db->where('destination_id', $destination_id);
		
		$this->db->order_by('name','asc');		
		
		$query = $this->db->get('activities');
		
		$activities =  $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'activities');
		
		$activities = update_i18n_data($activities, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $activities;
	}
	
	function get_destination_by_url($url_title){
		
		$this->db->select('id, name, title, url_title, picture_name, general_info, detail_info, travel_tips, flight_tips, destination_code');
		
		$this->db->where('url_title', $url_title);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('destinations');
		
		$destinations = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);
		
		
		if(empty($destinations)) {
			$destinations = $this->checkDestinationURLHistory($url_title);
		}
		
		if (count($destinations) >0) {
			
			$destination = $destinations[0];
			
			$destination['photos'] = $this->get_destination_photos($destination['id']);
			
			$destination['attractions'] = $this->get_destination_attractions($destination['id']);
			
			$destination['activities'] = $this->get_destination_activities($destination['id']);
			
			$destination['land_tours'] = $this->get_most_recommended_tours_in_destination($destination['id'], true);
			
			$destination['include_tours'] = $this->get_most_recommended_tours_in_destination($destination['id'], false);
			
			return $destination;
			
		}
		
		return false;
	}
	
	function get_most_recommended_tours_in_destination($destination_id, $is_land_tour = true){
		
		$this->db->select('t.id, t.name, t.url_title, t.picture_name, t.route, t.review_number, t.total_score');
	
		$this->db->from('tours as t');
		
		$this->db->join('tour_destinations td', 'td.tour_id= t.id', 'left outer');
		
		$this->db->where('t.status', STATUS_ACTIVE);
	
		$this->db->where('t.deleted !=', DELETED);
	
		$this->db->where('td.destination_id =', $destination_id);
		
		if ($is_land_tour){
		
			$this->db->where('td.is_land_tour =', 1);
		
		} else {
			
			$this->db->where('td.is_land_tour =', 0);
		}
		
		$this->db->group_by('t.id');
	
		$this->db->order_by("t.deal", "desc");
	
		$this->db->limit(3);
		
		$query = $this->db->get();
	
		$results = $query->result_array();
		
		return $results;
	}
	
	// check tour name history
	
	function checkDestinationURLHistory($url_title) {
	
		$this->db->select('id, name, title, url_title, url_title_history, picture_name, general_info, detail_info, travel_tips');
		
		$this->db->like('url_title_history', $url_title);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('destinations');
		
		$destinations = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');
		$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);
		
		//$str = $this->db->last_query();print_r($str);exit();
	
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
	 * Khuyenpv 30.10.2014
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
}