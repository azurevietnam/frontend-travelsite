<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotline_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    /**
     * TinVM Mar25 2015
     * Get hotline schedule from date and service
     */

    function get_schedules($date = '', $service = '', $id = '')
    {
        $this->db->select('u.sale_name, u.hotline_number, u.email, u.hotline_description, u.avatar, u.tailor_tour_title, u.tailor_tour_description');

        $this->db->from('hotline_schedules hs');

        $this->db->join('users u', 'hs.user_id = u.id');

        if(!empty($service))
            $this->db->where('u.display_on &'.pow(2, $service).' > 0');

        if(!empty($id))
            $this->db->where('u.id', $id);

        if(!empty($date))
            $this->db->where('hs.hotline_date', $date);

        $this->db->group_by('u.id');

        $query = $this->db->get();

        return $query->result_array();
    }

    function get_user($id){
        $this->db->select('u.sale_name, u.hotline_number, u.email, u.hotline_description, u.avatar, u.tailor_tour_title, u.tailor_tour_description');

        $this->db->where('u.id', $id);

        $query = $this->db->get('users u');

        return $query->result_array();
    }
}