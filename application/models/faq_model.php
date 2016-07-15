<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FAQ_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Khuyenpv March 03 2015
	 * get all faq by category
	 */
	function get_faq_by_category($category_id){

        $this->db->select('q.id, q.question, q.answer, q.url_title, fqc.category_id');

        $this->db->from('faq_question_categories fqc');

        $this->db->join('faq_questions q', 'q.id = fqc.question_id');

        if(is_array($category_id))
            $this->db->where_in('fqc.category_id', $category_id);
        else
            $this->db->where('fqc.category_id', $category_id);

        $this->db->order_by('q.position', 'asc');

        $this->db->group_by('q.id');

        $query = $this->db->get();

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_questions');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
	}

    /**
     * Khuyenpv March 15 2015
     * Get Sub categories In Category
     */

    function get_sub_categories($category_id){
        $this->db->select('id, name, url_title');

        $this->db->from('faq_categories');

        $this->db->where('category_id', $category_id);

        $this->db->order_by('position', 'asc');

        $query = $this->db->get();

        $categories = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
        $categories = update_i18n_data($categories, I18N_MULTIPLE_MODE, $table_cnf);

        return $categories;
    }

	/**
	 * Khuyenpv March 03 2015
	 * get all faq by destination
	 */
	function get_faq_by_destination($destination_id, $limit = ''){

        $this->db->select('q.id, q.question, q.answer, q.url_title, fqc.category_id');

        $this->db->from('faq_question_destinations fqd');

        $this->db->join('faq_questions q', 'q.id = fqd.question_id');

        $this->db->join('faq_question_categories fqc', 'fqc.question_id = q.id');

        if(is_array($destination_id))
            $this->db->where_in('fqd.destination_id', $destination_id);
        else
            $this->db->where('fqd.destination_id', $destination_id);


        $this->db->group_by('q.id');

        $this->db->order_by('q.position', 'asc');

        if(!empty($limit)){

	        $this->db->limit($limit);

        }

        $query = $this->db->get();

        $result = $query->result_array();


        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_questions');
        $result = update_i18n_data($result, I18N_MULTIPLE_MODE, $table_cnf);

        return $result;

	}

	/**
	 * Khuyenpv March 03 2015
	 * get all faq categories
	 */
	function get_categories($id = ''){
        $this->db->select('id, name, url_title');

        $this->db->from('faq_categories');

        $this->db->where('category_id', 0); // parrent category

        if(!empty($id))
            $this->db->where('id', $id);

        $this->db->order_by('position', 'asc');

        $query = $this->db->get();

		$categories = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
        $categories = update_i18n_data($categories, I18N_MULTIPLE_MODE, $table_cnf);

        return $categories;
	}

	/**
	 * Khuyenpv March 03 2015
	 * get all faq destination
	 */
	function get_destinations(){

        $this->db->select('d.id, d.name, d.parent_id, d.url_title');

        $this->db->from('faq_question_destinations fqd');

        $this->db->join('destinations d', 'fqd.destination_id = d.id');

        $this->db->group_by('d.id');

        $this->db->order_by('d.position', 'asc');

        $query = $this->db->get();

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
	}

	/**
	 * Khuyenpv March 03 2015
	 * Get Category By url_title
	 */
	function get_category($url_title){

        $this->db->select('id, name, url_title, category_id');

        $this->db->from('faq_categories');

        $this->db->where('url_title', trim($url_title));

        $query = $this->db->get();

        $categories = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
        $category = update_i18n_data($categories, I18N_MULTIPLE_MODE, $table_cnf);

        return $category[0];
	}

	/**
	 * Khuyenpv March 03 2015
	 * Get Destination By url_title
	 */
	function get_destination($url_title){

        $this->db->select('id, name, url_title');

        $this->db->from('destinations');

        $this->db->where('url_title', trim($url_title));

        $query = $this->db->get();

        $destinations = $query->result_array();

        if(!empty($destinations)){

        	$table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'destinations');

        	$destinations = update_i18n_data($destinations, I18N_MULTIPLE_MODE, $table_cnf);

        	return $destinations[0];

        }

        return FALSE;
	}

	/**
	 * Khuyepv March 03 2015
	 * Get FAQ by url-title
	 */
	function get_faq_by_url_title($url_title){

        $this->db->select('q.id, q.question, q.answer, q.url_title');

        $this->db->from('faq_questions q');

        $this->db->where('url_title', $url_title);

        $query = $this->db->get();

        $result = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_categories');
        $question = update_i18n_data($result[0], I18N_MULTIPLE_MODE, $table_cnf);

		return $question;
	}

    /**
     * Get Faq question
     * TinVM May18 2015
     */
    function get_faq($id){
        $this->db->select('question, answer, url_title');

        $this->db->where('id', $id);

        $query = $this->db->get('faq_questions');

        $result = $query->result_array();

        if(!empty($result))
            return $result['0'];
        else
            return '';
    }

    /**
     * Get Faq display in page
     * @author TinVM
     * @since Jun15 2015
     */
    function get_faq_for_page($destination_id, $page_id, $limit = 5){
        $this->db->select('q.id, q.question, q.url_title');

        if(!empty($page_id)){
            $sql_cond = '(EXISTS (SELECT 1 FROM faq_question_pages fqp WHERE fqp.page = '.$page_id .' AND fqp.question_id = q.id))';

            $this->db->where($sql_cond);
        }

        if(!empty($destination_id)) {
            $sql_cond = '(EXISTS (SELECT 1 FROM faq_question_destinations fqd WHERE fqd.destination_id = '.$destination_id .' AND fqd.question_id = q.id))';

            $this->db->where($sql_cond);
        }

        $this->db->order_by('position');


        if(!empty($limit))
            $this->db->limit($limit);

        $query = $this->db->get('faq_questions q');

        $results = $query->result_array();

        $table_cnf[] = array('col_id_name'=>'id', 'table_name'=>'faq_questions');
        $results = update_i18n_data($results, I18N_MULTIPLE_MODE, $table_cnf);

        return $results;
    }

    /**
     * Get category by faq
     * @author TinVM
     * @since July 10 2015
     */
    function get_category_by_faq($question_id){
        $this->db->select('c.id, c.name, c.url_title');

        $this->db->from('faq_question_categories fqc');

        $this->db->join('faq_categories c', 'fqc.category_id = c.id');

        if(is_array($question_id))
            $this->db->where_in('fqc.question_id', $question_id);
        else
            $this->db->where('fqc.question_id', $question_id);

        $query = $this->db->get();

        return $query->result_array();
    }

}