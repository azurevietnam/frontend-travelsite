<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BestDealModel extends CI_Model {
	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();		
	
	}
	
	function getHomeBestDeals(){
		
		$this->db->select('object_type, object_name, picture, description');
		
		$this->db->from('best_deals');
		
		$this->db->where('show_home', STATUS_ACTIVE);
		
		$query = $this->db->get();
		
		$best_deals = $query->result_array();
		
		return $best_deals;
	}
	
	function getHotelBestDeals(){
		
		$this->db->select('object_type, object_name, picture, description');
		
		$this->db->from('best_deals');
		
		$this->db->where('object_type', HOTEL);
		
		$query = $this->db->get();
		
		$best_deals = $query->result_array();
		
		return $best_deals;	
			
	}
	
	function getBestDealsByModule($module=''){
		
		$this->db->select('object_type, object_name, picture, description, detail_description');
		
		$this->db->from('best_deals');
		
		if ($module != ''){
			
			$this->db->like('page_apply', "-".$module."-", 'both');
			
		}
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$query = $this->db->get();
		
		$best_deals = $query->result_array();
		
		return $best_deals;	
	}
	
}
?>