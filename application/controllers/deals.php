<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deals extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->model(array('TourModel','FaqModel', 'HotelModel', 'BookingModel'));
		$this->load->language(array('faq', 'hotel'));
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('tour');
		
		$this->load->helper('group');
		
		$this->load->helper('booking');
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index(){
	
		$this->output->cache($this->config->item('cache_html'));
		//redirect_case_sensitive_url('', 'deals/', false);
		
		$data = $this->_set_common_data();

		$data['hot_deals'] = $this->_get_hot_deals_data();
		
		$data['today_deals'] = $this->_get_today_hot_deals($data);
		
		$data['list_date_halong'] = get_list_dates_hot_deals($data['hot_deals']['halong_bay_deals']);
		
		$data['list_date_mekong'] = get_list_dates_hot_deals($data['hot_deals']['mekong_river_deals']);
		
		$data['list_date_vntour'] = get_list_dates_hot_deals($data['hot_deals']['vietnam_tour_deals']);
		
		$data['list_date_vnhotel'] = get_list_dates_hot_deals($data['hot_deals']['hotel_deals']);

		
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('deal_offer.min.21092013.css');
		
		$data['main'] = $this->load->view('deals/deals_offers', $data, TRUE);
		
		$this->load->view('template', $data);
		
	}
	
	function _set_common_data(){
		
		
		
		$this->session->set_userdata('MENU', MNU_DEAL_OFFER);
	
		
		
		$data['metas'] = site_metas(DEALS, '');
		
		$data['navigation'] = createDealsNavLink(true);
		
		
		
		$data = load_faq_by_context('31', $data);
		
		// home page flag
		$data['flag_home_page'] = 1;
		// load hotel search form
		$data = $this->get_hotel_search_form($data);
		
		$data = buildTourSearchCriteria($data);	
		
		$search_criteria = $data['search_criteria'];

		
		$data = loadTopDestination($data);
		
		// include js/css
		//$data['inc_css'] = '<link rel="stylesheet" type="text/css" href="/css/tour.min.css" />';
	
		
		return $data;
	}
	
	function _get_hot_deals_data(){
	
		$halong_bay_deals = array();
		
		$mekong_river_deals = array();
		
		$vietnam_tour_deals = array();
		
		$hotel_deals = $this->TourModel->get_hotel_hot_deals();
		
		$tour_deals = $this->TourModel->get_all_tour_hot_deals();
		
		foreach ($tour_deals as $value){
			
			if($value['cruise_id'] == 0){
				
				$vietnam_tour_deals[] = $value;
				
 			} elseif ($value['cruise_destination'] == 0) {
 				
 				$halong_bay_deals[] = $value;
 				
 			} elseif ($value['cruise_destination'] == 1){
 				
 				$mekong_river_deals[] = $value;
 			}
			
		}
		
		$ret['halong_bay_deals'] = $halong_bay_deals;
		
		$ret['mekong_river_deals'] = $mekong_river_deals;
		
		$ret['vietnam_tour_deals'] = $vietnam_tour_deals;
		
		$ret['hotel_deals'] = $hotel_deals;
		
		return $ret;
	}
	
	function _get_today_hot_deals($data){
		
		$ret = array();
		
		$hot_deals = $data['hot_deals'];
		
		if (count($hot_deals['halong_bay_deals']) > 0){
			
			$ret[] = $hot_deals['halong_bay_deals'][0];
			
		}
		
		if (count($hot_deals['mekong_river_deals']) > 0){
			
			$ret[] = $hot_deals['mekong_river_deals'][0];
		}
		
		if (count($hot_deals['vietnam_tour_deals']) > 0){
			
			$ret[] = $hot_deals['vietnam_tour_deals'][0];
			
		}
		
		if (count($hot_deals['hotel_deals']) > 0){
			
			//$hot_deals['hotel_deals'][0]['is_hotel'] = true;
			
			//$ret[] = $hot_deals['hotel_deals'][0];
			
			foreach ($hot_deals['hotel_deals'] as $value){
				
				if ($value['destination'] == 'Hanoi'){ // Hanoi
					
					$value['is_hotel'] = true;
					
					$ret[] = $value;
					
					break;
				}
			}
			/*
			foreach ($hot_deals['hotel_deals'] as $value){
				
				if ($value['destination'] == 'Ho Chi Minh City'){ // Ho Chi Minh City
					
					$value['is_hotel'] = true;
					
					$ret[] = $value;
					
					break;
				}
			}*/
			
		}
		
		return $ret;
		
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