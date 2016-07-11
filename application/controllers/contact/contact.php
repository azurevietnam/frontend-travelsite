<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('basic', 'resource', 'contact', 'tour_search','hotline'));

		$this->load->model(array('Destination_Model','Tour_Model','Hotline_Model'));

		$this->load->language('contact');

		//$this->output->enable_profiler(TRUE);
	}

	/**
	 * Customize This Tour
	 *
	 * @author Khuyenpv
	 * @since 09.04.2015
	 */
	function customize($url_title = ''){

		$is_mobile = is_mobile();


		if(!empty($url_title)){

			$tour = $this->Tour_Model->get_tour_detail($url_title);

		}

        $data['tour'] = empty($tour)? '' : $tour;


		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(CUSTOMIZE_TOUR_PAGE);

		$data['page_theme'] = get_page_theme(CUSTOMIZE_TOUR_PAGE, $is_mobile);

		$data = get_page_navigation($data, $is_mobile, CUSTOMIZE_TOUR_PAGE);

		// load the tour search form
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);

		// load tripadvisor
		$data = load_tripadvisor($data, $is_mobile);

		// load customize form
		$data = load_customize_form($data, $is_mobile, 'save_customize_trip_info');

		render_view('contact/customize_trip', $data, $is_mobile);
	}

	/**
	 * Thank-You after submit booking
	 *
	 * @author Khuyenpv
	 * @since 09.04.2015
	 */
	function thank_you(){

		$is_mobile = is_mobile();

		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(THANK_YOU_PAGE);

		$data['page_theme'] = get_page_theme(THANK_YOU_PAGE, $is_mobile);

		$data = get_page_navigation($data, $is_mobile, THANK_YOU_PAGE);

		$get_url_thank_you = $this->uri->segment(1);

		$data['is_from_thank_you_page'] = $get_url_thank_you == THANK_YOU_PAGE ? TRUE : FALSE;

		// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);
    	
		// load tripadvisor
		$data = load_tripadvisor($data, $is_mobile);

		render_view('contact/thank_you_after_booking', $data, $is_mobile);

	}

}

?>