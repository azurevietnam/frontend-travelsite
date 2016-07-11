<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FlightModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
		
		$this->load->helper('url');
		
		$this->load->helper('common');
	}
	
	function get_airlines(){
		
		$query = $this->db->get('airlines');
		
		return $query->result_array();
	}
	
	function get_destination_by_code($city_code){
		
		$this->db->select('id, name, destination_code, parent_id');
		
		$this->db->where('destination_code', $city_code);
		
		$this->db->where('deleted != ', DELETED);

		$query = $this->db->get('destinations');

		$results = $query->result_array();
		
		if(count($results) > 0){
			return $results[0];
		} 

		return '';
	}	
	
	
	/*
	 * Get flight destinations
	*/
	function get_flight_destinations($parent_des_id, $is_area = false) {
	
		$results = array();
	
		if( !$is_area ) {
	
			$this->db->select ( 'name, destination_code, url_title' );
	
			$this->db->where ( 'parent_id', $parent_des_id );
			$this->db->where ( 'is_flight_destination', 1 );
			$this->db->where ( 'deleted != ', DELETED );
			$this->db->order_by('position_flight', 'asc');
	
			$query = $this->db->get ( 'destinations' );
	
			$results = $query->result_array ();
	
		} else {
	
			$this->db->select ( 'id' );
	
			$this->db->where ( 'parent_id', $parent_des_id );
			$this->db->where ( 'deleted != ', DELETED );
	
			$query = $this->db->get ( 'destinations' );
	
			$lst_des = $query->result_array ();
	
			$des_ids = array();
			foreach ($lst_des as $des) {
				$des_ids[] = $des['id'];
			}
	
			if(!empty($des_ids)) {
				$this->db->select ( 'name, destination_code, url_title' );
					
				$this->db->where_in ( 'parent_id', $des_ids );
				$this->db->where ( 'is_flight_destination', 1 );
				$this->db->where ( 'deleted != ', DELETED );
					
				$query = $this->db->get ( 'destinations' );
					
				$results = $query->result_array ();
			}
		}
	
		return $results;
	}
	
	function get_all_flight_destinations() {
		$dess = array();
		
		$this->db->select ( 'id, name, type' );
		$this->db->where('is_flight_group', 1);
		$this->db->where ( 'deleted != ', DELETED );
		$this->db->order_by('order_', 'asc');
		$query = $this->db->get('destinations');
		$area = $query->result_array();
		
		foreach ($area as $des) {
			
			$is_region = false;
			
			// type=7 : region
			if($des['type'] == 7) {
				$is_region = true;
			}
			
			array_push($dess, array("name" => $des['name'], "destinations" => $this->get_flight_destinations($des['id'], $is_region)));
		}
		
		return $dess;
	}
	
	function get_popular_fights() {
	
		$this->db->select('f.*, d.name as from_des, d2.name as to_des, d.destination_code as from_code, d2.destination_code as to_code');
		
		$this->db->join('destinations d', 'd.id = f.from_destination_id');
		
		$this->db->join('destinations d2', 'd2.id = f.to_destination_id');
	
		$this->db->where('d.is_flight_destination', 1);
	
		$this->db->where('f.is_show_vietnam_flight_page', 1);
		
		$this->db->where('f.status', 1);
	
		$this->db->order_by('f.position', 'asc');
	
		$this->db->limit(5);
	
		$query = $this->db->get('flight_routes f');
	
		$results = $query->result_array();
	
		if(!empty($results)) {
			foreach ($results as $k => $route) {
				$this->db->where('flight_route_id', $route['id']);
				$this->db->join('airlines a', 'fp.airline_id = a.id');
				$this->db->order_by('a.id', 'asc');
				$query = $this->db->get('flight_basic_prices fp');
				$prices = $query->result_array();
				$route['basic_prices'] = $prices;
	
				$results[$k] = $route;
			}
		}
	
		return $results;
	}
	
	function get_flights_of_destiantion($des_id) {
		
		$this->db->select('f.*, d.name as from_des, d2.name as to_des, d.destination_code as from_code, d2.destination_code as to_code');
		
		$this->db->join('destinations d', 'd.id = f.from_destination_id');
		
		$this->db->join('destinations d2', 'd2.id = f.to_destination_id');
		
		$this->db->where('f.to_destination_id', $des_id);
		
		$this->db->where('d.is_flight_destination', 1);
		
		$this->db->where('f.is_show_flight_destination_page', 1);
		
		$this->db->where('f.status', 1);
		
		$this->db->order_by('f.position', 'asc');
		
		$this->db->limit(5);
		
		$query = $this->db->get('flight_routes f');
		
		$results = $query->result_array();
		
		if(!empty($results)) {
			foreach ($results as $k => $route) {
				$this->db->where('flight_route_id', $route['id']);
				$this->db->join('airlines a', 'fp.airline_id = a.id');
				$this->db->order_by('a.id', 'asc');
				$query = $this->db->get('flight_basic_prices fp');
				$prices = $query->result_array();
				$route['basic_prices'] = $prices;
		
				$results[$k] = $route;
			}
		}
		
		return $results;
	}
	
	function get_all_flight_routes() {
		
		$this->db->select('f.*, d.name as from_des, d2.name as to_des, d.destination_code as from_code, d2.destination_code as to_code');
		
		$this->db->join('destinations d', 'd.id = f.from_destination_id');
		
		$this->db->join('destinations d2', 'd2.id = f.to_destination_id');
		
		$this->db->where('d.is_flight_destination', 1);
		
		$this->db->where('f.status', 1);
		
		$this->db->order_by('f.from_destination_id', 'asc');
		
		$this->db->order_by('f.position', 'asc');
		
		$query = $this->db->get('flight_routes f');
		
		$results = $query->result_array();
		
		$city_codes = array();
		$mapping_city = array();
		
		$cnt = 0;
		foreach ($results as $des) {
			if(!in_array($des['from_code'], $city_codes)) {
				if(!empty($city_codes)) $cnt++;
				
				$city_codes[] = $des['from_code'];
				$mapping_city[] = array($des['from_code'] => array($des['to_code']));
			
			} else {
				
				$list = $mapping_city[$cnt];
				if(isset($list[$des['from_code']])) {
					array_push($list[$des['from_code']], $des['to_code']);
					$mapping_city[$cnt] = $list;
				}
			}
		}
		
		return json_encode($mapping_city);
	}
}

?>
