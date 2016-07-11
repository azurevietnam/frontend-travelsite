<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class I18nModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
	
	}
	
	/**
	 * Load i18n data of one or more record id
	 * Kim Tan Son
	 */
	function load_i18n_data($language, $table_name, $record_ids){
		
		if(empty($record_ids)) return array();
		
		$this->db->where('table_name', $table_name);
		
		$this->db->where('language', $language);
		
		if(is_array($record_ids)){
			
			$this->db->where_in('record_id', $record_ids);
			
		} else{
			
			$this->db->where('record_id', $record_ids);
			
		}
		
		$query = $this->db->get('i18n_langs');
		
		return $query->result_array();
	}
	
}