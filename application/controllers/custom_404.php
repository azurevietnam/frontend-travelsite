<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_404 extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->model(array('TourModel', 'HotelModel'));
		$this->load->language(array('hotel'));
		$this->load->helper('form');

		$this->load->helper('tour');
	
	}
	
	function index(){
		
		$this->output->set_status_header('404');
		
		$data = $this->_set_common_data();

		
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('deal_offer.min.16072013.css');
		
		$data['main'] = $this->load->view('common/custom_404', $data, TRUE);
		
		
		$this->load->view('template', $data);
		
	}
	
	function _set_common_data(){
		
		$data['metas'] = site_metas(CUSTOM_404, '');
		
		$data['navigation'] = create_404_Nav_Link();
		

		
		// home page flag
		$data['flag_home_page'] = 1;
		// load hotel search form
		$data = $this->get_hotel_search_form($data);
		
		$data = buildTourSearchCriteria($data);	
		
		$search_criteria = $data['search_criteria'];

		
		$data = loadTopDestination($data);
		
		return $data;
	}


	function get_hotel_search_form($data) {
		
		$data = load_hotel_search_autocomplete($data);
		
		//$data = load_hotel_top_destination($data);
		
		$data['hotel_stars'] = $this->HotelModel->hotel_stars;
		$data['hotel_nights'] = $this->HotelModel->hotel_nights;
		
		$search_criteria = buildHotelSearchCriteria();
		
		$data['search_criteria'] = $search_criteria;
		
		$data['hotel_search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
		return $data;
	}
}
?>