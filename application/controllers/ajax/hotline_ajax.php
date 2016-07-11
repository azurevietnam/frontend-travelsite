<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotline_Ajax extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource'));

       	$this->load->model(array('Hotline_Model'));

		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	public function load_hotline_support(){
        $CI =& get_instance();

        $CI->load->model('Hotline_Model');

        $now = date(DB_DATE_FORMAT);

        $schedules = $CI->Hotline_Model->get_schedules($now, TOUR);// fix service = tour

        if(!empty($schedules))
            $view_data['schedule'] = $schedules[array_rand($schedules)];

        if(empty($view_data['schedule']))
            $today_hotline = '';

        else
            $today_hotline = $CI->load->view('common/hotline/today_hotline', $view_data, TRUE);

        echo $today_hotline;
	}

	public function load_tailor_make_tour()
    {
        $CI = & get_instance();
        
        $CI->load->model('Hotline_Model');
        
        $today_hotline = '';
        
        $now = date(DB_DATE_FORMAT);
        
        $schedules = $CI->Hotline_Model->get_schedules($now, TOUR); // fix service = tour
        
        if (! empty($schedules)) {
            $view_data['schedule'] = $schedules[array_rand($schedules)];
        }
        else
        {
            $result = $CI->Hotline_Model->get_user(2); // Fix hotline id
            
            $view_data['schedule'] = $result[0];
        }
        
        $mobile_folder = is_mobile() ? 'mobile/' : '';
        
        if (!empty($view_data['schedule'])) {
            $today_hotline = $CI->load->view($mobile_folder.'common/hotline/tailor_make_tour', $view_data, TRUE);
        }
        
        echo $today_hotline;
    }


}

?>