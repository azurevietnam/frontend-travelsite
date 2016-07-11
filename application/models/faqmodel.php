<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FaqModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
		
		$this->load->helper('url');
		
		$this->load->helper('common');
		
		$this->load->library(array('TimeDate'));
	}
	
	function getTopFAQs(){
		
		$this->db->where('is_top', '1');
		
		$this->db->orderby('order_', 'asc');
		
		$query = $this->db->get('faq_questions');
		
		$questions = $query->result_array();
		
		return $questions;
	}
	
	function getFaqCategories(){
	
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get('faq_categories');
		
		$categories = $query->result_array();
		
		/*
		$this->db->select('faq.id as faq_id, faq.name as faq_name, faq.code, t.id as tour_id, t.name as tour_name, t.code as tour_code');
		$this->db->from('faq_categories faq');
		$this->db->join('tours t, t.id = faq.tour_id');
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
		$table_cnf[] = array('col_id_name'=>'tour_id', 'table_name'=>'tours');
		
		$colum_cnf[] = array('table_name'=>'faq_categories', 'col_name_db'=>'name', 'col_name_alias'=>'faq_name');
		$colum_cnf[] = array('table_name'=>'tours', 'col_name_db'=>'name', 'col_name_alias'=>'tour_name');
		$colum_cnf[] = array('table_name'=>'tours', 'col_name_db'=>'code', 'col_name_alias'=>'tour_code');
		*/
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
		$categories = update_i18n_data($categories, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $categories;
	}
	
	function getFaqQuestions($topic = ''){
			
		if ($topic != ''){
						
			$topic = '-'.$topic.'-';
						
			$this->db->like('topics', $topic, 'both');			
		}
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get('faq_questions');
		
		$questions = $query->result_array();
		
		$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_questions');
		
		$questions = update_i18n_data($questions, I18N_MULTIPLE_MODE, $table_cnf);
		
		return $questions;
	}
	
	function getFaqQuestionByUrl($url_title){
		
		$this->db->where('url_title', $url_title);
		
		$query = $this->db->get('faq_questions');
		
		$questions = $query->result_array();
		
		return count($questions) > 0 ? $questions[0] : '';
	}
	
	function getFaqQuestionByCategory($category_id){
		
		$this->db->like('categories', '-'.$category_id.'-', 'both');
		
		$this->db->order_by('order_', 'asc');
		
		$query = $this->db->get('faq_questions');
		
		$questions = $query->result_array();
		
		return $questions;
	}
	
	function getFaqQuestionByPage($page){
		
		$this->db->where('page', $page);
		
		$query = $this->db->get('faq_questions');
		
		$questions = $query->result_array();
		
		return count($questions) > 0 ? $questions[0] : '';
	}
	
	function traceIp(){
		$query = $this->db->get('ip_traces');
		
		$ips = $query->result_array();
		
		foreach ($ips as $ip) {
			
			if ($ip['region'] == '' || $ip['region'] == NULL){
				$xml = simplexml_load_file("http://xml.utrace.de/?query=".$ip['ip']);
				$region = $xml->result->region.'';
				$this->db->set('region', $region);
				$this->db->where('id', $ip['id']);
				$this->db->update('ip_traces');
				echo $ip['region'];
			}
		}
	}
}