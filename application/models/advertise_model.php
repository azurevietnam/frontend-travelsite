<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertise_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->database();
    }

    function get_advertises($ad_page, $ad_area = AD_AREA_DEFAULT, $des_id = '', $is_mobile = false, $travel_style_id = '') {

        $today = date(DB_DATE_FORMAT);

        $apply_on = date('w', strtotime($today));

        $this->db->where('ad.status', STATUS_ACTIVE);
        $this->db->where('ad.deleted !=', DELETED);

        $this->db->where('ad.start_date <=', $today);

        $this->db->where('ad.end_date >=', $today);

        $this->db->where('ad.display_on & '.pow(2,$ad_page).'>',0);

        $this->db->where('ad.ad_area & '.pow(2,$ad_area).'>',0);

        $this->db->where('ad.week_day & '.pow(2,$apply_on).'>',0);

        if(!empty($travel_style_id) && !empty($des_id) && $ad_page == AD_PAGE_VIETNAM_TOUR){
            $sql_cond = '(EXISTS (SELECT 1 FROM advertise_destinations ad_des WHERE ad_des.advertise_id = ad.id AND ad_des.module = '.TOUR. ' AND ad_des.destination_id = '.$des_id. ' AND ad_des.travel_style_id = '. $travel_style_id .'))';

            $this->db->where($sql_cond);
        }

        elseif(($ad_page == AD_PAGE_HOTEL_BY_DESTINATION || $ad_page == AD_PAGE_FLIGHT_BY_DESTINATION || $ad_page == AD_PAGE_TOUR_BY_DESTINATION) && !empty($des_id)){

            $module = $ad_page == AD_PAGE_HOTEL_BY_DESTINATION ? HOTEL : FLIGHT;

            $module = $ad_page == AD_PAGE_TOUR_BY_DESTINATION ? TOUR : $module;

            $sql_cond = '(EXISTS (SELECT 1 FROM advertise_destinations ad_des WHERE ad_des.advertise_id = ad.id AND ad_des.module = '.$module. ' AND ad_des.destination_id = '.$des_id.'))';

            $this->db->where($sql_cond);
        }

        $this->db->order_by('ad.position','asc');

        $query = $this->db->get('advertises ad');

        $results = $query->result_array();

        foreach ($results as $key => $value) {

            $value['photos'] = $this->get_ad_photos($value['id'], $ad_page, $is_mobile);

            $results[$key] = $value;
        }


        return $results;
    }

    function get_ad_photos($ad_id, $ad_page, $is_mobile){

        $version = $is_mobile ? STATUS_INACTIVE : STATUS_ACTIVE;

        $this->db->select('id, name, advertise_id, display_on');

        $this->db->where('advertise_id', $ad_id);

		$this->db->where('display_on & '.pow(2,$ad_page).'>',0);

        $this->db->where('status', STATUS_ACTIVE);

        $this->db->where('version', $version);

        $this->db->order_by('id','asc');

        $query = $this->db->get('advertise_photos');

        $rerults = $query->result_array();

        return $rerults;
    }

    function get_advertise_by_page($page_id = '', $ad_area = '', $destination_id = '')
    {
        $now = date(DB_DATE_FORMAT);

        $this->db->select('a.id, a.name, a.link, ap.name as picture');

        $this->db->from('advertise_photos ap');

        $this->db->join('advertises a', 'ap.advertise_id = a.id');

        if(!empty($destination_id)){
            $this->db->join('advertise_destinations ad', 'ad.advertise_id = a.id');

            $this->db->where('ad.destination_id', $destination_id);
        }

        $this->db->where('a.display_on & '.$page_id.' > 0');

        if(!empty($ad_area))
            $this->db->where('a.ad_area & '.$ad_area.' > 0');

        $this->db->where('a.status != ', STATUS_INACTIVE);

        $pr_where = "(`start_date` <= '" . $now . "'";
        $pr_where .= " AND (`end_date` is NULL OR `end_date` >= '" . $now . "'))";

        $this->db->order_by('a.position', 'asc');

        $this->db->group_by('a.id');

        $query = $this->db->get('advertise_photos');

        $results = $query->result_array();

        return $results;
    }
}
