<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recommend_Model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->database();
	}

	/**
	 * Get Recommendations of A Destination - Service
	 *
	 * @author Khuyenpv
	 * @sinc 09.04.2015
	 */
	function get_service_recommendations($destination_id, $service_type){

		$this->db->select('d.id, d.name, d.url_title, d.picture as des_picture, ds_r.service_id as service_type, ds_r.description as ds_description, ds_r.picture as rec_picture,  r.description as rec_description');

		$this->db->from('recommendations r');

		$this->db->join('destination_services ds', 'r.destination_service_id = ds.id');

		$this->db->join('destination_services ds_r', 'r.recommend_service_id = ds_r.id');

		$this->db->join('destinations d', 'ds_r.destination_id = d.id');

		$this->db->where('ds.service_id', $service_type);

		$this->db->where('ds.destination_id', $destination_id);

		$this->db->order_by('r.order','asc');

		$query = $this->db->get();

		$results = $query->result_array();

		return $results;
	}
}

?>