<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * About_Us Page
 * @author Tinvm
 * @since Mar 04 2015
 */


class About_Us extends CI_Controller {

	public function __construct()
    {

       	parent::__construct();
		$this->load->helper(array('basic', 'resource', 'hotline', 'contact'));
		$this->load->language('about');

		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
	    set_current_menu(MNU_ABOUT_US);

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_set_common_data(array(), ABOUT_US_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, ABOUT_US_PAGE, $is_mobile);

        $data['about_content'] = load_view('about_us/about_view', array(), $is_mobile);

		render_view('about_us/main_view', $data, $is_mobile);
	}

    function registration(){
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_set_common_data(array(), REGISTRATION_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, REGISTRATION_PAGE, $is_mobile);

        $data['about_content'] = load_view('about_us/registration_view', array(), $is_mobile);

        render_view('about_us/main_view', $data, $is_mobile);
    }

    function policy(){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_set_common_data(array(), POLICY_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, POLICY_PAGE, $is_mobile);

        $data['about_content'] = load_view('about_us/policy_view', array(), $is_mobile);

        render_view('about_us/main_view', $data, $is_mobile);
    }

    function privacy(){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_set_common_data(array(), PRIVACY_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, PRIVACY_PAGE, $is_mobile);

        $data['about_content'] = load_view('about_us/privacy_view', array(), $is_mobile);

        render_view('about_us/main_view', $data, $is_mobile);
    }

    function our_team(){

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $data = $this->_set_common_data(array(), OUR_TEAM_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, OUR_TEAM_PAGE, $is_mobile);

        $data['about_content'] = load_view('about_us/our_team_view', array(), $is_mobile);

        render_view('about_us/main_view', $data, $is_mobile);
    }

    function contact_us(){
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        set_current_menu(MNU_CONTACT_US);

        $data = $this->_set_common_data(array(), CONTACT_US_PAGE, $is_mobile);

        $data = $this->_set_about_categories($data, CONTACT_US_PAGE, $is_mobile);

        $data = load_contact_form($data, $is_mobile, "save_customer_contact_form", true);

        $data['about_content'] = $data['contact_form'];

        render_view('about_us/main_view', $data, $is_mobile);
    }

    function _set_about_categories($data, $page, $is_mobile)
    {
        $view_data['page'] = $page;

        $data['about_categories'] = load_view('about_us/about_categories', $view_data, $is_mobile);

        return $data;
    }

    function _set_common_data($data, $page, $is_mobile){
        // get page theme
        $data['page_theme'] = get_page_theme($page, $is_mobile);

        // set page meta
        $data['page_meta'] = get_page_meta($page);

        // set navigation
        $data = get_page_navigation($data, $is_mobile, $page);

        return $data;
    }
}
?>