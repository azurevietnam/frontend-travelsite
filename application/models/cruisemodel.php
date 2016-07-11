<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CruiseModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
		
		$this->load->helper('url');
		
		$this->load->helper('common', 'file');
		
		$this->load->library(array('TimeDate'));
	
	}
	
	/**
	* 
	* Set up search criteria for cruise searching from an array data.
	* 	*
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
				case 'cruise_stars':
					if ($value != '' && count($value) > 0){
						$this->db->where_in('c.star', $value);	
					}
					break;
				case 'departure_port':
					if ($value != ''){
						$this->db->where('c.cruise_destination', $value);	
					}
					break;
				case 'cruise_ids':
					if ($value != '' && count($value) > 0){
						$this->db->where_in('p.cruise_id', $value);	
					}
					break;
				case 'duration':
					if ($value != '' && $value <= 3){
						
						$this->db->where('p.duration', $value);
							
					} elseif ($value != '' && $value == 4){
						
						$_4_7 = array(4, 5, 6, 7);
						
						$this->db->where_in('p.duration', $_4_7);	
						
					} elseif ($value != '' && $value == 5){
						$this->db->where('p.duration >', 7);	
					}
					break;					
				default :	
					// do nothing
					break;
			}
			
		}
		
	}
	

	function getDestinationByUrlTitle($url_title){

		$this->db->where('url_title', $url_title);
		
		$this->db->where('deleted !=', DELETED);
				
		$query = $this->db->get('destinations');
		
		$destinations = $query->result_array();
		
		if (count($destinations) < 1) {
			return false;
		}
		
		$destination = $destinations[0];
		
		return $destination;
	}
	
	function getTourIds4Cruise($cruise_id){
		
		$ret = array();
		
		$this->db->select('id');
		
		$this->db->from('tours');
		
		$this->db->where('cruise_id', $cruise_id);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get();
		
		$ids = $query->result_array();
		
		foreach ($ids as $id){
			
			$ret[] = $id['id'];
			
		}
		
		return $ret;
	}
	
	function getCruiseByUrlTitle($url_title){
		
		$this->db->select('c.*, p.short_name as partner_name');
		
		$this->db->from('cruises as c');
		
		$this->db->join('partners as p', 'p.id = c.partner_id');
		
		$this->db->where('c.url_title', $url_title);
		
		$this->db->where('c.deleted !=', DELETED);
				
		$query = $this->db->get();
		
		$cruises = $query->result_array();
		
		if (count($cruises) < 1) {
			
			$cruises = $this->checkCruiseURLHistory($url_title);
			
			if(empty($cruises)) return '';
		}
		
		$cruise = $cruises[0];
		
		$cruise['cabins'] = $this->getCruiseCabins($cruise['id']);
		
		$cruise['normal_cabins'] = $this->_getCabinByType(0, $cruise['cabins']);
		
		$cruise['room_cabins'] = $this->_getCabinByType(1, $cruise['cabins']);
		
		$cruise['upload_files'] = $this->getCruiseFiles($cruise['id']);
		
		return $cruise;	
	}
	
	function getCruiseByUrlTitle4Reviews($url_title){
		
		$this->db->select('c.*, p.short_name as partner_name');
		
		$this->db->from('cruises as c');
		
		$this->db->join('partners as p', 'p.id = c.partner_id');
		
		$this->db->where('c.url_title', $url_title);
		
		$this->db->where('c.deleted !=', DELETED);
				
		$query = $this->db->get();
		
		$cruises = $query->result_array();
		
		if (count($cruises) < 1) {
			return '';
		}
		
		$cruise = $cruises[0];
		
		return $cruise;
	}
	
	function getCruiseById($id,$is_get_cabin = true){

		$this->db->where('id', $id);
		
		$query = $this->db->get('cruises');
		
		$cruises = $query->result_array();
		
		if (count($cruises) < 1) {
			return '';
		}
		
		$cruise = $cruises[0];
		
		if ($is_get_cabin){
		
			$cruise['cabins'] = $this->getCruiseCabins($cruise['id'], '0');
		
		}
		return $cruise;	
	}
	
	
	function getPartnerById($id){

		$this->db->where('id', $id);
		
		$query = $this->db->get('partners');
		
		$partners = $query->result_array();
		
		if (count($partners) < 1) {
			return '';
		}
		
		return $partners[0];	
	}
	
	function getCruiseProgramById($cruise_program_id, $departure_date = '', $is_get_price){
		
		$this->db->where('id', $cruise_program_id);
		
		$this->db->where('deleted !=', DELETED);		
		
		$query = $this->db->get('cruise_programs');
		
		$cruise_programs = $query->result_array();
		
		if (count($cruise_programs) < 1) {
			return '';
		}
		
		if ($departure_date != ''){
			$departure_date = date('Y-m-d', strtotime($departure_date));
		}
		
		$cruise_program = $cruise_programs[0];
		
		
		$services = $this->getProgramServices($cruise_program['id'], $departure_date);
		
		
		$transport_services = $this->_getServiceByType($services, SERVICE_TYPE_TRANSPORTATION);
		
		$cruise_program['transfers'] = $this->getProgramTransfers($cruise_program['id'], '', $departure_date);
		
		$cruise_program['transfers'] = $this->_getProgramTransportation($cruise_program['transfers'], $transport_services);
		
		$optional_services = $this->_getServiceByType($services, SERVICE_TYPE_OPTIONAL);
		
		$cruise_program['optional_services'] = $optional_services;
		
		$cruise_program['offers'] = $this->_getFreeServices($services);
		
		if ($is_get_price){
			/**
			 * get program price
			 * 
			 */
			$cruise_program_prices = $this->getCruiseProgramPrices($cruise_program['cruise_id'], $cruise_program['id'], $departure_date);
			
			$cruise_program_promotions = $this->getCruiseProgramPromotions($cruise_program['cruise_id'], $cruise_program['id'], $departure_date);
			
			$cruise_program['price'] = $this->_getCruiseProgramPrices($cruise_program_prices, $cruise_program_promotions);
			
			
			$cruise_program['required_services'] = $this->_getServiceByType($services, SERVICE_TYPE_REQUIRED);
		
			$cruise_program['optional_services'] = $this->_getServiceByType($services, SERVICE_TYPE_OPTIONAL);
		}
		
		return $cruise_program;	
	}
	
	function getCruiseProgramByUrlTitle($url_title, $departure_date=''){

		$this->db->where('url_title', $url_title);
		
		$this->db->where('deleted !=', DELETED);		
		
		$query = $this->db->get('cruise_programs');
		
		$cruise_programs = $query->result_array();
		
		if (count($cruise_programs) < 1) {
			return '';
		}
		
		if ($departure_date != ''){
			$departure_date = date('Y-m-d', strtotime($departure_date));
		}
		
		$cruise_program = $cruise_programs[0];
		
		/**
		 * get program itinerary
		 * 
		 */
		$cruise_program['itineraries'] = $this->getCruiseProgramItinerary($cruise_program['id']);
		
		$services = $this->getProgramServices($cruise_program['id'], $departure_date);
		
		/**
		 * get program services
		 * 
		 */
		$cruise_program['included_services'] = $this->getCruiseSuportedServices(array(1));

		
		$cruise_program['specific_included_services'] = $this->_getServiceByType($services, SERVICE_TYPE_INCLUDED);
		
		$cruise_program['required_services'] = $this->_getServiceByType($services, SERVICE_TYPE_REQUIRED);
		
		$cruise_program['optional_services'] = $this->_getServiceByType($services, SERVICE_TYPE_OPTIONAL);
		
		$transport_services = $this->_getServiceByType($services, SERVICE_TYPE_TRANSPORTATION);
		
		$cruise_program['transfers'] = $this->getProgramTransfers($cruise_program['id'], '1', $departure_date);
		
		$cruise_program['transfers'] = $this->_getProgramTransportation($cruise_program['transfers'], $transport_services);
		
		$cruise_program['offers'] = $this->_getFreeServices($services);
		
		/**
		 * get program price
		 * 
		 */
		$cruise_program_prices = $this->getCruiseProgramPrices($cruise_program['cruise_id'], $cruise_program['id'], $departure_date);
		
		$cruise_program_promotions = $this->getCruiseProgramPromotions($cruise_program['cruise_id'], $cruise_program['id'], $departure_date);
		
		$cruise_program['price'] = $this->_getCruiseProgramPrices($cruise_program_prices, $cruise_program_promotions);
				
		return $cruise_program;	
	}
	
	function getCruiseSuportedServices($types = ''){
		
		$this->db->from('services');
		
		$this->db->where('status', STATUS_ACTIVE); 
		
		$this->db->where('deleted !=', DELETED);
		
		if ($types != ''){
			$this->db->where_in('type', $types);
		}
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function _getCruiseProgramPrices($cruise_program_prices, $cruise_program_promotions){
		$ret = array();
		
		$prices = array();
		
		$promotions = array();
		
		foreach ($cruise_program_prices as $price){
			
			$prices[$price['cruise_cabin_id']] = $price; 
		
		}
		
		foreach ($cruise_program_promotions as $progmotion){
			
			$promotions[$progmotion['cruise_cabin_id']] = $progmotion;
		}
		
		foreach ($prices as $key => $price) {
			
			$price_item = array();
			
			$price_item['single_price_0'] = 0;
			
			$price_item['double_price_0'] = 0;
			
			$price_item['children_price_0'] = 0;
			
			$price_item['single_promotion_price_0'] = 0;
			
			$price_item['double_promotion_price_0'] = 0;
			
			$price_item['children_promotion_price_0'] = 0;
			
			
			for($index = 1; $index <= 6; $index++){

				$price_item['single_price_'.$index] = $index == 1 ? $price['single_price'] : $price['single_price_'.$index];
				
				$price_item['double_price_'.$index] = $index == 1 ? $price['double_price'] : $price['double_price_'.$index];
				
				$price_item['children_price_'.$index] = $price_item['double_price_'.$index] + $price['children_price'];
					
				$price_item['single_promotion_price_'.$index] =  $price_item['single_price_'.$index];		
				
				if (array_key_exists($key, $promotions)){
					
					$price_item['single_promotion_price_'.$index] = (1 - $promotions[$key]['single_offer_rate']/100)*$price_item['single_price_'.$index];
					
				}
				
				$price_item['double_promotion_price_'.$index] =  $price_item['double_price_'.$index];
				
				$price_item['children_promotion_price_'.$index] =  $price_item['children_price_'.$index];
				
				if (array_key_exists($key, $promotions)){
					
					$price_item['double_promotion_price_'.$index] = (1 - $promotions[$key]['double_offer_rate']/100)*$price_item['double_price_'.$index];
					
					$price_item['children_promotion_price_'.$index] = (1 - $promotions[$key]['double_offer_rate']/100)*$price_item['children_price_'.$index];
					
				}
				
			}	
			
			$ret[$key] = $price_item;
		}
		
		return $ret;
	}
	
	function getSystemCruiseCabinFacilities(){
		
		$this->db->select('id, name, hotel_facility_type');
		
		$this->db->from('facilities');
		
		$this->db->where('type', 3); // for cruise cabin
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruiseFacilities($cruise_id){
		
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
	
	function getCruiseCabinFacilities($cruise_id){
		
		$this->db->select('f.id, f.name, f.important, cf.cruise_cabin_id');
		
		$this->db->from('cruise_facilities as cf');
		
		$this->db->join('facilities as f', 'f.id = cf.facility_id');
		
		$this->db->join('cruise_cabins as cb', 'cb.id = cf.cruise_cabin_id');
		
		$this->db->where('cb.cruise_id', $cruise_id);

		$this->db->where('cb.status', STATUS_ACTIVE); 
		
		$this->db->where('cb.deleted !=', DELETED); 
		
		
		$this->db->where('cf.value', STATUS_ACTIVE);

		$this->db->where('cf.deleted !=', DELETED);
		
		$this->db->where('f.status', STATUS_ACTIVE);
		
		$this->db->where('f.deleted !=', DELETED);
		
		$this->db->order_by('f.name', 'asc');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getAllCruises(){
		
		$this->db->from('cruises');
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruisesByStars($stars, $date, $location){
		
		$ret = array();
		
		foreach ($stars as $key => $value) {
		
			$this->db->where('star', $value);
			
			$this->db->where('cruise_destination', $location);
			
			$this->db->where('status', STATUS_ACTIVE);
			
			$this->db->where('deleted !=', DELETED);
			
			$this->db->order_by('deal', 'desc');
			
			$query = $this->db->get('cruises', $this->config->item('max_cruise_best_deal'), 0);
			
			$cruises = $query->result_array();
			
			foreach ($cruises as $k => $v) {
				
				$cruise_prices = $this->getCruisePrices($v['id'], $date);
				
				$cruise_promotions = $this->getCruisePromotions($v['id'], $date);
				
				$v['programs'] = $this->getCruisePrograms($v['id']);
				
				foreach ($v['programs'] as $pk => $pv) {
					
					$pv['min_price'] = $this->_getMinPrice($pv['id'], $cruise_prices, $cruise_promotions);
					
					$v['programs'][$pk] = $pv;
					
				}
				
				$cruises[$k] = $v;			
			}
			
			$ret[$value] = $cruises;
			
		}
		
		return $ret;
	}
	
	function _getStrCruiseIds($programs){
		$ret = "()";
		
		$cruise_id_arr = array();
		
		foreach ($programs as $program){
			
			$cruise_id_arr[] = $program['cruise_id'];
		}
		
		$cruise_id_arr = array_unique($cruise_id_arr);
		
		if (count($cruise_id_arr) > 0){
			$ret = "(";
			
			foreach ($cruise_id_arr as $id) {
				
				$ret = $ret.$id.",";
			}
			
			$ret = substr($ret, 0, strlen($ret) - 1);
			
			$ret = $ret . ")";
		}
		
		return $ret;
	}
	
	function _getMinPrice($program_id, $cruise_prices, $cruise_promotions){
		
		$prices = array();
		
		$offes = array();
		
		foreach ($cruise_prices as $cp) {
			
			if ($cp['cruise_program_id'] == $program_id){
				
				$prices[$cp['cruise_cabin_id']] = $cp;
				
			}
			
		}
		
		foreach ($cruise_promotions as $co){
			
			if ($co['cruise_program_id'] == $program_id){
				
				$offes[$co['cruise_cabin_id']] = $co;
				
			}
		}
		
		$price = 0;
		
		$offer_price = 0;
		
		foreach ($prices as $key => $value) {
			
			$p2 = 0;
			
			if (isset($offes[$key])){
								
				$p2 = (1 - $offes[$key]['double_offer_rate']/100) * $value['double_price'];			
					
			} else {
				
				$p2 = $value['double_price'];
				
			}
			
			$p1 = $value['double_price'];
			
			if ($offer_price == 0 || $p2 < $offer_price){
				
				$price = $p1;
				
				$offer_price = $p2;
				
			}
			
		}
		//echo $offer_price;
		return array('price'=>$price, 'offer_price'=>$offer_price);
		
	}
	
	function getCruisePrograms($cruise_id){
			
		$this->db->where('cruise_id', $cruise_id);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get('cruise_programs');
		
		return $query->result_array();
	}
	
	function getCruiseProgramPrices($cruise_id, $cruise_program_id, $date){
		
		$query_str = "SELECT c_p_c.* FROM cruise_program_cabin_prices AS c_p_c".
				 " INNER JOIN cruise_prices AS c_p ON c_p_c.cruise_price_id = c_p.id".
		         " WHERE c_p_c.cruise_program_id = ".$cruise_program_id.		
		         " AND c_p.cruise_id = ".$cruise_id.		
				 " AND (c_p.start_date <='".$date."' AND (c_p.end_date = NULL OR c_p.end_date >= '" .$date."'))";
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
	}
	
	function getCruiseProgramPromotions($cruise_id, $cruise_program_id, $date){
		
		$query_str = "SELECT pd.cruise_id, pd.cruise_program_id, pd.cruise_cabin_id, pd.single_offer_rate, pd.single_offer_note, pd.double_offer_rate, pd.double_offer_note".
				 " FROM promotion_details AS pd".
				 " INNER JOIN promotions AS p ON pd.promotion_id = p.id".
		         " WHERE p.status = 1 AND p.deleted <> 1 AND pd.cruise_id = ".$cruise_id.
				 " AND pd.cruise_program_id = ". $cruise_program_id.
		         " AND (p.start_date <='".$date."' AND (p.end_date = NULL OR p.end_date >= '" .$date."'))";
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
		         
	}
	
	function getCruisePrices($cruise_id, $date){
		
		$query_str = "SELECT c_p_c.* FROM cruise_program_cabin_prices AS c_p_c".
				 " INNER JOIN cruise_prices AS c_p ON c_p_c.cruise_price_id = c_p.id".
		         " WHERE (c_p.start_date <='".$date."' AND (c_p.end_date = NULL OR c_p.end_date >= '" .$date."'))".
		         " AND c_p.cruise_id = ".$cruise_id;
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
	}
	
	function getCruisePromotions($cruise_id, $date){
		
		$query_str = "SELECT pd.cruise_id, pd.cruise_program_id, pd.cruise_cabin_id, pd.single_offer_rate, pd.single_offer_note, pd.double_offer_rate, pd.double_offer_note".
				 " FROM promotion_details AS pd".
				 " INNER JOIN promotions AS p ON pd.promotion_id = p.id".
		         " WHERE p.status = 1 AND p.deleted <> 1 AND pd.cruise_id = ".$cruise_id.
		         " AND (p.start_date <='".$date."' AND (p.end_date = NULL OR p.end_date >= '" .$date."'))";
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
		         
	}
	
	function getCruisePricesByIds($cruise_ids, $date){
		
		$query_str = "SELECT c_p_c.* FROM cruise_program_cabin_prices AS c_p_c".
				 " INNER JOIN cruise_prices AS c_p ON c_p_c.cruise_price_id = c_p.id".
		         " WHERE (c_p.start_date <='".$date."' AND (c_p.end_date = NULL OR c_p.end_date >= '" .$date."'))".
		         " AND c_p.cruise_id IN ".$cruise_ids;
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
	}
	
	function getCruisePromotionsByIds($cruise_ids, $date){
		
		$query_str = "SELECT pd.cruise_id, pd.cruise_program_id, pd.cruise_cabin_id, pd.single_offer_rate, pd.single_offer_note, pd.double_offer_rate, pd.double_offer_note".
				 " FROM promotion_details AS pd".
				 " INNER JOIN promotions AS p ON pd.promotion_id = p.id".
		         " WHERE p.status = 1 AND p.deleted <> 1 AND pd.cruise_id IN ".$cruise_ids.
		         " AND (p.start_date <='".$date."' AND (p.end_date = NULL OR p.end_date >= '" .$date."'))";
		
		$query = $this->db->query($query_str);
		
		return $query->result_array();
		         
	}
	
	function getCruiseCabinsByIds($cruise_ids){
				
		$query_str = "SELECT id, name, cruise_id".
				 " FROM cruise_cabins".
		         " WHERE cruise_id IN ".$cruise_ids.
		 		 " AND type = 0".
				 " ORDER BY order_";
				
		$query = $this->db->query($query_str);
				
		return $query->result_array();
			         
	}
	
	function getCruiseServicesByIds($cruise_ids, $date, $is_free = ''){
				
		$query_str = "SELECT ps.*, s.name as name, s.picture as picture, s.description as service_description".
				 " FROM cruise_program_services AS ps".
				 " INNER JOIN services AS s ON ps.service_id = s.id".				 
		         " WHERE ps.cruise_id IN ".$cruise_ids.
				 " AND (ps.start_date <='".$date."' AND (ps.end_date is NULL OR ps.end_date >= '" .$date."'))";
		
		if ($is_free != ''){
			$query_str = $query_str. " AND ps.is_free = ".$is_free;
		}
				
		$query = $this->db->query($query_str);
				
		return $query->result_array();
			         
	}
	
	function getProgramServices($program_id, $date='', $type=''){
		
		$query_str = "SELECT ps.*, s.name as name, s.picture as picture, s.description as service_description".
				 " FROM cruise_program_services AS ps".
				 " INNER JOIN services AS s ON ps.service_id = s.id".				 
		         " WHERE ps.cruise_program_id = ".$program_id;
				 
		
		if ($date != ''){
			$query_str = $query_str. " AND (ps.start_date <='".$date."' AND (ps.end_date is NULL OR ps.end_date >= '" .$date."'))";
		}
		
		if ($type != ''){
			$query_str = $query_str. " AND ps.type = ".$type;
		}
				
		$query = $this->db->query($query_str);
				
		return $query->result_array();
	}
	
	function getProgramTransfers($program_id, $is_default = '', $date = ''){
		
		$query_str = "SELECT trp.*, t.id as id, t.name as name, t.picture as picture, t.description as description, ". 
		
				 " r.route as route, r.short_route as short_route, r.km as km, r.shuttle_bus as is_shuttle_bus, r.description as route_description".
		
				 " FROM transfer_route_prices AS trp".
		
				 " INNER JOIN cruise_program_transfers AS cpt ON cpt.transfer_service_id = trp.transfer_service_id".
		
				 " AND cpt.transfer_route_id = trp.transfer_route_id AND cpt.cruise_program_id = ".$program_id.
		
				 " AND cpt.value = 1";
		
		if ($is_default != ''){
			$query_str = $query_str." AND cpt.is_default = ".$is_default;
		}
		
		if ($date != ''){
			$query_str = $query_str." AND (trp.start_date <='".$date."' AND (trp.end_date is NULL OR trp.end_date >= '" .$date."'))";
		}         
		
		$query_str = $query_str." INNER JOIN transfer_services AS t ON t.id = cpt.transfer_service_id".
				 
				 " INNER JOIN transfer_routes AS r ON r.id = cpt.transfer_route_id".
		
				 " ORDER BY r.order_, t.nr_seat";
		
		$query = $this->db->query($query_str);
				
		return $query->result_array();
	}
	
	function _getProgramTransportation($p_transfers, $shuttle_buses){
		
		$ret = array();
		
		foreach ($p_transfers as $value) {
			
			$ret[$value['short_route']] = $value;
			
		}
		
		foreach ($ret as $key=>$value){
			$car_prices = array();
			
			if ($value['is_shuttle_bus'] == 1){
				
				foreach ($shuttle_buses as $shuttle_bus){
					
					$shuttle_bus['transfer_route_id'] = $value['transfer_route_id'];
					
					$shuttle_bus['shuttle_bus'] = 1;
					
					$shuttle_bus['id'] = $shuttle_bus['id'].'_1';
					
					$car_prices[] = $shuttle_bus;
						
				}			
				
			}
			foreach ($p_transfers as $p_transfer){
				if ($p_transfer['short_route'] == $key){
					$car_prices[] = $p_transfer;
				}
			}
			$ret[$key] = $car_prices;
		}
		
		return $ret;
	}
	
	function _getCabinForProram($cruise_id, $cabins){
		$ret = array();
		
		foreach ($cabins as $cabin) {
			
			if ($cabin['cruise_id'] == $cruise_id){
				
				$ret[] = $cabin;
				
			}
		}
		
		return $ret;
	}
	
	function _getOfferForProram($cruise_program_id, $cruise_offer_services){
		$ret = array();
		
		foreach ($cruise_offer_services as $service) {
			
			if ($service['cruise_program_id'] == $cruise_program_id){
				
				$ret[] = $service;
				
			}
		}
		
		return $ret;
	}
	
	function _getServiceByType($services, $type){
		
		$ret = array();
		
		foreach ($services as $service) {
			
			if ($service['type'] == $type){
				
				$ret[] = $service;
				
			}
		}
		
		return $ret;
	}
	
	function _getFreeServices($services){
		
		$ret = array();
		
		foreach ($services as $service) {
			
			if ($service['is_free'] == 1){
				
				$ret[] = $service;
				
			}
		}
		
		return $ret;
	}
	
	function _getCruiseProgramByDestinations($destination_ids, $programs){
				
		$ret = array();
		
		foreach ($programs as $value) {
			
			$route_ids = $value['ids'];
			
			$route_ids = split('-', $route_ids);
			
			$is_contain = true;
			
			foreach ($destination_ids as $id) {
				if ($id != '' && !in_array($id, $route_ids)){
					$is_contain = false;
					break;
				}
			}
			
			if ($is_contain){
				$ret[] = $value;
			}
		}
		
		
		return $ret;
	}
	
	function getCruiseCabins($cruise_id, $type=''){
		
		$this->db->from('cruise_cabins');
		
		$this->db->where('cruise_id', $cruise_id);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		if ($type != ''){
			$this->db->where('type', $type);
		}
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get();
		
		$cabins = $query->result_array();
		
		foreach ($cabins as $key => $value) {
			
			$value['photos'] = $this->getCruiseCabinPhotos($value['id']);
			
			$cabins[$key] = $value;
			
		}
		
		return $cabins;
	}
	
	function getCruiseCabinPhotos($cruise_cabin_id){
		
		$this->db->from('cruise_photos');
		
		$this->db->where('cruise_cabin_id', $cruise_cabin_id);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruisePhotos($cruise_id){
		
		$this->db->from('cruise_photos');
		
		$this->db->where('cruise_id', $cruise_id);
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruisePhoto($photo_id){
		
		$this->db->from('cruise_photos');
		
		$this->db->where('id', $photo_id);
		
		$query = $this->db->get();
		
		$photos = $query->result_array();
		
		if (count($photos) > 0){
			return $photos[0];
		} else {
			return false;
		}
	}
	
	function getCruiseVideos($cruise_id){
		
		$this->db->from('cruise_videos');
		
		$this->db->where('cruise_id', $cruise_id);
		
		$this->db->order_by('name', 'asc');
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruiseVideo($id){
		
		$this->db->from('cruise_videos');
		
		$this->db->where('id', $id);
		
		$query = $this->db->get();
		
		$videos = $query->result_array();
		
		if (count($videos) > 0){
			
			return $videos[0];
			
		} else {
			
			return false;
			
		}
	}
	
	
	function getCruiseFiles($cruise_id){
		
		$this->db->from('cruise_files');
		
		$this->db->where('cruise_id', $cruise_id);
		
		$query = $this->db->get();
		
		return $query->result_array();
	}
	
	function getCruiseProperties($cruise_id){
		
		$this->db->from('cruise_properties');
		
		$this->db->where('cruise_id', $cruise_id); 
		
		$this->db->or_where('cruise_id', '0'); 
		
		$this->db->order_by("order_", "asc");
		
		$query = $this->db->get();
		
		$rerutls = $query->result_array();
		
		return $rerutls;
	}
	
	function getCruiseMembers($cruise_id){
		
		$this->db->from('cruise_members');
		
		$this->db->where('cruise_id', $cruise_id); 
		
		$this->db->order_by("id", "asc");
		
		$query = $this->db->get();
		
		$rerutls = $query->result_array();
		
		foreach ($rerutls as $key => $value) {
			
			$value['photos'] = $this->getCruiseMemberPhotos($value['id']);
			
			$rerutls[$key] = $value;
		}
		
		return $rerutls;
	}
	function getCruiseMemberPhotos($cruise_member_id){
		
		$this->db->from('cruise_photos');
		
		$this->db->where('cruise_member_id', $cruise_member_id); 
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function getCruiseMemberProperties($cruise_id){
		
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
	
	function getCruiseProgramItinerary($cruise_program_id){
		
		$this->db->from('cruise_itineraries');
		
		$this->db->where('cruise_program_id', $cruise_program_id); 
		
		$this->db->order_by('id', 'asc');
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function _getCabinByType($type, $cabins){
		
		$ret = array();
		
		foreach ($cabins as $cabin){
			
			if ($cabin['type'] == $type){
				$ret[] = $cabin;
			}
		}
		
		return $ret;
		
	}
	
	function book($cruise_booking, $cruise_service_bookings, $customer){
		
		$this->db->where('email', $customer['email']);
		
		$nr = $this->db->count_all_results('customers');
		
		$cus_id = 0;
		
		if ($nr == 0){
		
			$this->db->insert('customers', $customer);
			
			$cus_id = $this->db->insert_id();
		
		} else {
			
			$this->db->where('email', $customer['email']);
			
			$this->db->update('customers', $customer);
			
			
			$this->db->where('email', $customer['email']);
			
			$query = $this->db->get('customers');
		
			$results = $query->result_array();
			
			
			$cus_id = $results[0]['id'];
			
		}

		$cruise_booking['customer_id']	= $cus_id;
		
		$this->db->insert('cruise_bookings', $cruise_booking);
		
		$cruise_booking_id = $this->db->insert_id();
		
		foreach ($cruise_service_bookings as $value) {
			
			$value['cruise_booking_id'] = $cruise_booking_id;
			
			$this->db->insert('cruise_service_bookings', $value);
		}
	
		return $cruise_booking_id;
		
	}
	
	/**
	 * For cruise reviews
	 * 
	 */
	
	function getNumCustomerReviews($review_for_id, $review_for_type, $customer_type, $review_rate){
		
		$this->db->where('review_for_id', $review_for_id);
		
		$this->db->where('review_for_type', $review_for_type);
		
		if ($customer_type != ''){
					
			$this->db->where('customer_type', $customer_type);
					
		}
		
		if ($review_rate != ''){
		
			$this->db->where('review_rate', $review_rate);
		
		}		
		
		return $this->db->count_all_results('customer_reviews');
		
	}
	
	function getCustomerReviews($review_for_id, $review_for_type, $customer_type, $review_rate, $num = -1, $offset = 0){
		
		$this->db->where('review_for_id', $review_for_id);
		
		$this->db->where('review_for_type', $review_for_type);
		
		if ($customer_type != ''){
					
			$this->db->where('customer_type', $customer_type);
					
		}
		
		if ($review_rate != ''){
		
			$this->db->where('review_rate', $review_rate);
		
		}		
		
		
		$this->db->order_by('review_date', 'desc');
		
		if ($num == -1) { 
			// do nothing
		} else {
			$this->db->limit($num, $offset);
		}
		
		$query = $this->db->get('customer_reviews');
		
		return $query->result_array();
		
	}
	
	function countReviewByCustomerType($review_for_id, $review_for_type){
		
		$ret = array();
		
		$query_str = "SELECT customer_type, count(*) as nr_customer_type FROM customer_reviews";
		
		$query_str = $query_str. ' WHERE review_for_id = '.$review_for_id;
		
		$query_str = $query_str. ' AND review_for_type = '.$review_for_type;
		
		$query_str = $query_str. ' GROUP BY customer_type';
		
		$query = $this->db->query($query_str);
				
		$results = $query->result_array();
		
		foreach ($results as $key => $value) {
			$ret[$value['customer_type']] = $value['nr_customer_type'];
		}
		
		return $ret;
	}
	
	function countReviewByReviewRate($review_for_id, $review_for_type, $customer_type){
		
		$ret = array();
		
		$query_str = "SELECT review_rate, count(*) as nr_review_rate FROM customer_reviews"; 
		
		$query_str = $query_str. ' WHERE review_for_id = '.$review_for_id;
		
		$query_str = $query_str. ' AND review_for_type = '.$review_for_type;
						
		if ($customer_type != ''){
			
			$query_str = $query_str." AND customer_type = ".$customer_type;
			
		}
		
		$query_str = $query_str." GROUP BY review_rate";
				
		$query = $this->db->query($query_str);
				
		$results = $query->result_array();
		
		foreach ($results as $key => $value) {
			$ret[$value['review_rate']] = $value['nr_review_rate'];
		}
		
		return $ret;
		
	}
	
	function getViewedCruises($ids){
		
		$ids = array_reverse($ids);
		
		$ids = array_unique($ids);
		
		//$ret = array();
		
		$max_viewed_cruises = $this->config->item('max_viewed_cruises');
		
		if (count($ids) > $max_viewed_cruises){
			$ids = array_splice($ids, 0, $max_viewed_cruises);
		}
		
		$this->db->select('c.*, p.short_name as partner');
	
		$this->db->from('cruises as c');
		
		$this->db->join('partners as p', 'c.partner_id = p.id');
		
		$this->db->where_in('c.id', $ids);
		
		$this->db->where('c.status', STATUS_ACTIVE);
		
		$this->db->where('c.deleted !=', DELETED);
		
		$query = $this->db->get();
		
		$results = $query->result_array();
			
		$hotels = $this->sortCruiseByIds($results, $ids);
		
		return $hotels;
	}
	
	function sortCruiseByIds($cruises, $ids){
		$ret = array();
		foreach ($ids as $value) {
			
			foreach ($cruises as $cruise) {
				
				if ($cruise['id'].'' == $value){
					$ret[] = $cruise;
					break;
				}
			}
			
		}
		return $ret;
	}
	
	function getOtherCruiseProgramOfPartner($partner_id, $cruise_program_id){
		
		$this->db->select('cp.*');
	
		$this->db->from('cruise_programs as cp');
		
		$this->db->join('cruises as c', 'cp.cruise_id = c.id');
		
		$this->db->where('c.partner_id', $partner_id);
		
		$this->db->where('cp.id !=', $cruise_program_id);
		
		$this->db->where('cp.status', STATUS_ACTIVE);
		
		$this->db->where('cp.deleted !=', DELETED);
		
		$this->db->order_by('cp.url_title', 'asc');
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function getOtherCruiseOfPartner($partner_id, $cruise_id){
		
		$this->db->select('c.*');
	
		$this->db->from('cruises as c');
		
		$this->db->where('c.partner_id', $partner_id);
		
		$this->db->where('c.id !=', $cruise_id);
		
		$this->db->where('c.status', STATUS_ACTIVE);
		
		$this->db->where('c.deleted !=', DELETED);
		
		// internationalization: toanlk 17/03/2015
		$this->db->where('(c.language_id = 0 OR c.language_id = ' . lang_id().')');
		
		$this->db->order_by('c.url_title', 'asc');
		
		$query = $this->db->get();
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function get_similar_cruises($cruise)
	{
		$this->db->select('c.id, c.name, c.star, c.cabin_type, c.review_score, c.url_title, c.num_reviews, c.picture, p.short_name as partner_name, p.id as partner_id');
	
		$this->db->from('cruises as c');
	
		$this->db->join('partners as p', 'p.id = c.partner_id');
	
		$this->db->where('c.deleted !=', DELETED);
		
		$this->db->where('c.status', STATUS_ACTIVE);
		
		$this->db->where('c.cruise_destination', $cruise['cruise_destination']);
	
		$this->db->where('c.id !=', $cruise['id']);
		
		// internationalization: toanlk 17/03/2015
		$this->db->where('(c.language_id = 0 OR c.language_id = ' . lang_id().')');
		
		if($cruise['cruise_destination'] == 0) {
			
			// private cruise
			if ($cruise['cabin_type'] == 2){
				$this->db->where('c.cabin_type', 2);
			} else {
				$this->db->where('c.cabin_type !=', 2);
			}
			
			// day cruise
			if ($cruise['num_cabin'] == 0){
				$this->db->where('c.num_cabin', 0);
			} else {
				$this->db->where('c.num_cabin >', 0);
			}
			
			// luxury, mid-range, cheap
			if($cruise['num_cabin'] != 0 && $cruise['cabin_type'] != 2) {
				if ($cruise['star'] >= 4.5) {
						
					$this->db->where('c.star >=', 4.5);
						
				} elseif ($cruise['star'] >= 3.5){
						
					$this->db->where('c.star >=', 3.5);
					$this->db->where('c.star <', 4.5);
				} else {
						
					$this->db->where('c.star <', 3.5);
				}
			}
		} else {
			$cruise_location = '1';
			$cruise_destination = explode(',', $cruise['mekong_cruise_destination']);
			foreach ($cruise_destination as $key => $des) {
				/* if(in_array($des, array(VIETNAM_CAMBODIA_CRUISE_DESTINATION,
						VIETNAM_CRUISE_DESTINATION,
						LAOS_CRUISE_DESTINATION,
						THAILAND_CRUISE_DESTINATION,
						BURMA_CRUISE_DESTINATION)) && $des != VIETNAM_CAMBODIA_CRUISE_DESTINATION) {
					$cruise_location = $des;
					break;
				} */
				if($key == 0)$cruise_location = $des;
			}
			$this->db->like('c.mekong_cruise_destination', $cruise_location);
		}
	
		$this->db->order_by("c.deal", "desc");
	
		$this->db->limit(SIMILAR_TOUR_LIMIT);
	
		$query = $this->db->get();
		
		//print_r($this->db->last_query());exit();
		
		$results = $query->result_array();
	
		return $results;
	}
	
	/**
	 * 
	 * GET THE CRUISE OVERVIEW 
	 * @param $cruise_id
	 * @param $departure_date
	 */
	
	function get_cruise_overview($cruise_id, $departure_date, $cruise_name = ''){
		
		if ($cruise_id == '' && $cruise_name == '') return FALSE;
		
		$this->db->select('c.id, c.name, c.url_title, c.address, c.star, c.picture, c.is_new, c.cabin_type, c.num_cabin, c.num_reviews, c.review_score, c.description, p.short_name as partner_name');
		
		$this->db->from('cruises as c');
		
		$this->db->join('partners as p', 'p.id = c.partner_id');
	
		if ($cruise_id != ''){

			$this->db->where('c.id', $cruise_id);
			
		} else {
			
			$this->db->where('c.url_title', $cruise_name);
			
		} 
		
		$this->db->where('c.deleted !=', DELETED);
				
		$query = $this->db->get();
		
		$cruises = $query->result_array();
		
		if (count($cruises) < 1) {
			return FALSE;
		}
		
		$cruise = $cruises[0];
		
		$cruise['photos'] = $this->getCruisePhotos($cruise['id']);
		
		$cruise['hot_deals'] = $this->TourModel->get_cruise_hot_deal_info($cruise['id'], $cruise['url_title']);
		
		/**
		 * GET CRUISE TOURS
		 */
		
		$this->db->select('id, name, url_title, duration, picture_name, route, review_number, total_score');
		
		$this->db->from('tours');
		
		$this->db->where('cruise_id', $cruise['id']);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->order_by('duration', 'asc');
		
		$query = $this->db->get();
		
		$tours = $query->result_array();
		
		// get price of tour
		$tours = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
		
		$cruise['tours'] = $tours;
		
		/**
		 * GET CRUISE CABINS
		 */
		
		$this->db->select('id, name, picture, cabin_size, bed_size, description');
		
		$this->db->from('cruise_cabins');
		
		$this->db->where('cruise_id', $cruise['id']);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->where('type', '0'); // normal cabin
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get();
		
		$cabins = $query->result_array();
		
		$cruise['cabins'] = $cabins;
		
		return $cruise;	
	}
	
	function get_lasted_cruise_review($cruise_id){
		
		$this->db->select('gr.guest_name, gr.guest_country, gr.guest_city, gr.review_date, gr.positive_review');
		
		$this->db->from('guest_reviews as gr');
		
		$this->db->join('tours as t', 't.id = gr.review_for_id');
		
		$this->db->where('t.cruise_id', $cruise_id);
		
		$this->db->where('gr.positive_review !=','');
		
		$this->db->where('gr.review_for_type', CRUISE);
		
		$this->db->where('gr.deleted !=', DELETED);
		
		$this->db->order_by('gr.review_date', 'desc');
		
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$reviews = $query->result_array();
		
		if (count($reviews) > 0){
			
			$countries = $this->config->item('countries');
			
			$reviews[0]['guest_country'] = $countries[$reviews[0]['guest_country']][0];
			
			return $reviews[0];
			
		} else {
			
			return '';
			
		}
		
	}
	
	// check cruise name history
	
	function checkCruiseURLHistory($url_title) {
		
		$this->db->select('c.*, p.short_name as partner_name');
			
		$this->db->from('cruises as c');
			
		$this->db->join('partners as p', 'p.id = c.partner_id');
			
		$this->db->like('c.url_title_history', $url_title);
			
		$this->db->where('c.deleted !=', DELETED);
			
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
		
		//$str = $this->db->last_query();
		
		return null;
	}
}