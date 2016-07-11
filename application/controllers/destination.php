<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destination extends CI_Controller {

	public function __construct()
    {

       	parent::__construct();

		$this->load->model(array('DestinationModel','TourModel','FaqModel'));
		$this->load->language(array('faq', 'hotel','tour'));
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('tour');
	}

	function index()
	{
		$url_title = $this->uri->segment(1);

		// anti sql injection
		$url_title = anti_sql($url_title);

		$url_title = substr($url_title, strlen(DESTINATION_DETAIL)+1);

		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

		$destination = $this->DestinationModel->get_destination_by_url($url_title);

		if ($destination === FALSE) {redirect(site_url()); exit();}

		$data['destination'] = $destination;

		$data = $this->set_common_data($data);

		redirect_case_sensitive_url(DESTINATION_DETAIL, $destination['url_title'], true);

		$data['main'] = $this->load->view('destinations/destination_detail', $data, TRUE);

		$this->load->view('template', $data);
	}

	function see_overview(){


		$destination_id = $this->input->post('destination_id');

		$departure_date = $this->input->post('departure_date');

		$destination_name = $this->input->post('destination_name');

		$destination = $this->DestinationModel->get_destination_overview($destination_id, $departure_date, $destination_name);

		$data['destination'] = $destination;

		$data['departure_date'] = $departure_date;

		$destination_overview = $this->load->view('destinations/destination_overview', $data, TRUE);

		echo $destination_overview;

	}

	function see_activity_overview(){

		$activity_id = $this->input->post('activity_id');

		$activity_name = $this->input->post('activity_name');

		$departure_date = $this->input->post('departure_date');

		$activity = $this->DestinationModel->get_activity_overview($activity_id, $activity_name);

		$data['activity'] = $activity;

		$data['departure_date'] = $departure_date;

		$activity_overview = $this->load->view('destinations/activity_overview', $data, TRUE);

		echo $activity_overview;

	}

	function set_common_data($data){

		$data['metas'] = site_metas(DESTINATION_DETAIL, $data['destination']);

		$data['navigation'] = createDestinationNavLink($data['destination']);

		$data = loadTopDestination($data);

		$data = load_faq_by_context(22, $data);

		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);

		$data['inc_css'] = get_static_resources('destination.min.16072013.css');

		// home page flag
		$data['flag_home_page'] = 1;
		// load hotel search form
		$data = $this->get_hotel_search_form($data);

		// for search tour only
		$data['destinations'] = $data['destination']['name'];

		$data['destination_ids'] = $data['destination']['id'];

		$data = buildTourSearchCriteria($data);

		unset($data['destinations']);

		unset($data['destination_ids']);

		return $data;
	}

	function get_hotel_search_form($data) {

		$data = load_hotel_search_autocomplete($data);

		//$data = load_hotel_top_destination($data);

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;
		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		$search_criteria = buildHotelSearchCriteria($data['destination']);

		$data['search_criteria'] = $search_criteria;

		$data['hotel_search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
		return $data;
	}
}
?>