<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tours extends CI_Controller {
	var $t1, $t2;
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->model(array('TourModel','FaqModel','BestDealModel', 'BookingModel'));
		$this->load->language(array('faq', 'cruise'));
		$this->load->library('pagination');	
		$this->load->helper('form');
		$this->load->helper('tour');
		$this->load->helper('text');
		$this->load->helper('cookie');
		
		$this->load->helper('group');
		
		$this->load->helper('booking');
		
		$this->load->driver('cache', array('adapter' => 'file'));
		
		// for test only
		//$this->output->enable_profiler(TRUE);
		
	}
	
	function halongbaycruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->t1 = microtime(true);
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
		
		$data['metas'] = site_metas(HALONG_BAY_CRUISES, '');
		
		$data = load_faq_by_context('1', $data);
		
		$this->_load_view(HALONG_BAY_CRUISES, $data, 0);
		
	}
	function luxuryhalongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
			
		$data['metas'] = site_metas(LUXURY_HALONG_CRUISES, '');		

		$data = load_faq_by_context('1', $data);
		
		$this->_load_view(LUXURY_HALONG_CRUISES, $data, 0);
	}	
	function deluxehalongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);	
		$data['metas'] = site_metas(DELUXE_HALONG_CRUISES, '');	

		$data = load_faq_by_context('1', $data);
		
		$this->_load_view(DELUXE_HALONG_CRUISES, $data, 0);
	}
	function cheaphalongcruises() {

		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);	
		$data['metas'] = site_metas(CHEAP_HALONG_CRUISES, '');	
		
		$data = load_faq_by_context('1', $data);
		
		$this->_load_view(CHEAP_HALONG_CRUISES, $data, 0);
	}
	
	function charterhalongcruises() {	
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
			
		$data['metas'] = site_metas(CHARTER_HALONG_CRUISES, '');	
		
		$data = load_faq_by_context('1', $data);
		
		$this->_load_view(CHARTER_HALONG_CRUISES, $data, 0);
	}
	
	function halongbaydaycruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->t1 = microtime(true);
		$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
		
		$data['metas'] = site_metas(HALONG_BAY_DAY_CRUISES, '');
		
		$data = load_faq_by_context('1', $data);
	
		
		$this->_load_view(HALONG_BAY_DAY_CRUISES, $data, 0);
	}
	
	function mekongrivercruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->t1 = microtime(true);
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);		
		$data['metas'] = site_metas(MEKONG_RIVER_CRUISES, '');	
		
		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(MEKONG_RIVER_CRUISES, $data, 1);
	}	
	function luxurymekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(LUXURY_MEKONG_CRUISES, '');

		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(LUXURY_MEKONG_CRUISES, $data, 1);
	}
	function deluxemekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(DELUXE_MEKONG_CRUISES, '');	

		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(DELUXE_MEKONG_CRUISES, $data, 1);
	}
	function cheapmekongcruises() {

		$this->output->cache($this->config->item('cache_html'));
		
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(CHEAP_MEKONG_CRUISES, '');

		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(CHEAP_MEKONG_CRUISES, $data, 1);
	}

	function chartermekongcruises() {	
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
			
		$data['metas'] = site_metas(CHARTER_MEKONG_CRUISES, '');	
		
		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(CHARTER_MEKONG_CRUISES, $data, 1);
	}
	
	function vietnamcambodiacruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(VIETNAM_CAMBODIA_CRUISES, '');
	
		$data = load_faq_by_context('2', $data);
		
		$this->_load_view(VIETNAM_CAMBODIA_CRUISES, $data, 1);
	}
	
	function vietnammekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(VIETNAM_CRUISES, '');
	
		$data = load_faq_by_context('2', $data);
	
		$this->_load_view(VIETNAM_CRUISES, $data, 1);
	}
	
	function laosmekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(LAOS_CRUISES, '');
	
		$data = load_faq_by_context('2', $data);
	
		$this->_load_view(LAOS_CRUISES, $data, 1);
	}
	
	function thailandmekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(THAILAND_CRUISES, '');
	
		$data = load_faq_by_context('2', $data);
	
		$this->_load_view(THAILAND_CRUISES, $data, 1);
	}
	
	function burmamekongcruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$data['metas'] = site_metas(BURMA_CRUISES, '');
	
		$data = load_faq_by_context('2', $data);
	
		$this->_load_view(BURMA_CRUISES, $data, 1);
	}
	
	function mekongriverdaycruises() {
		
		$this->output->cache($this->config->item('cache_html'));
		
		$this->t1 = microtime(true);
		
		$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);		
		$data['metas'] = site_metas(MEKONG_RIVER_DAY_CRUISES, '');	
		
		$data = load_faq_by_context('2', $data);
	
		
		$this->_load_view(MEKONG_RIVER_DAY_CRUISES, $data, 1);
	}	

	function _load_view($action, $data, $cruise_destination=''){
		
		$data['action'] = $action;
		
		$data = buildTourSearchCriteria($data);
		
		$search_criteria = $data['search_criteria'];
		
		$page_header = get_page_header($action);
		
		$page_header = str_replace(lang('label_cheap'), lang('label_budget'), $page_header);
		
		$data['page_header'] = $page_header;
		
		$data['countries'] = $this->config->item('countries');		
		
		$data['cruise_destination'] = $cruise_destination;
		
		$data = $this->_prepareMainData($action, $data);				
		
		$data['rich_snippet_infor'] = $this->TourModel->get_rich_snippet_review_infor($cruise_destination, $action);
		
		$data['inc_css'] = get_static_resources('halong-mekong.min.12072013.css');
		
		$data = loadTopDestination($data);
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$data['main'] = $this->load->view('tours/cruise_tours', $data, TRUE);
		
		$this->t2 = microtime(true);
				
		$data['time_exe'] =  $this->t2 - $this->t1;
		
		
		$this->load->view('template', $data);
	}
	
	function getlisttourhotdeals(){
		
		ob_start();
		
		$action = $this->input->post('action_type');
		
		$departure_date = $this->input->post('departure_date');
		
		$cruise_port = $this->_get_cruise_port($action);
		
		$departure_date = date('Y-m-d', strtotime($departure_date));
		
		$tour_hot_deals = $this->TourModel->get_tours_by_hot_deals($cruise_port, $departure_date);
		
		$data['tour_hot_deals'] = $this->_get_hot_deals_by_action($tour_hot_deals, $departure_date, $action);
		
		$list_tour_hot_deals = $this->load->view('tours/tour_hot_deals', $data, TRUE);
		
		echo $list_tour_hot_deals;
	}
	
	function _get_hot_deals_by_action($tour_hot_deals, $departure_date, $action){
		
		if ($action == HALONG_BAY_CRUISES || $action == MEKONG_RIVER_CRUISES){
			
			$cruise_port = $this->_get_cruise_port($action);
			
			$first_tour_hot_deals = $this->TourModel->get_tours_by_hot_deals($cruise_port, $departure_date, 1);
		
			$best_tour = $this->_get_best_offer_tour($first_tour_hot_deals);
			
			
			if (count($tour_hot_deals) > 0 && $best_tour !== FALSE){

				unset($tour_hot_deals[0]);
			}

			
			return $tour_hot_deals;
		}
		
		$ret = array();
		
		foreach ($tour_hot_deals as $value){
			
			if ($action == LUXURY_HALONG_CRUISES || $action == DELUXE_HALONG_CRUISES || $action == CHEAP_HALONG_CRUISES){
				
				$stars = $this->_get_cruise_type($action);
				
				if ($value['cabin_type'] != 2 && $value['num_cabin'] > 0 && in_array($value['star'], $stars)){
					
					$ret[] = $value;
				}
			}
			
			if ($action == CHARTER_HALONG_CRUISES){
				
				if ($value['cabin_type'] == 2){
					
					$ret[] = $value;
				}
			}
			
			if ($action == HALONG_BAY_DAY_CRUISES){
				
				if ($value['num_cabin'] == 0){
					
					$ret[] = $value;
				}
			}
			
			if ($action == VIETNAM_CAMBODIA_CRUISES){
				
				if (strpos($value['mekong_cruise_destination'], VIETNAM_CAMBODIA_CRUISE_DESTINATION) !== FALSE){
					
					$ret[] = $value;
					
				}
				
			}
			
			if ($action == VIETNAM_CRUISES){
				
				if (strpos($value['mekong_cruise_destination'], VIETNAM_CRUISE_DESTINATION) !== FALSE){
					
					$ret[] = $value;
					
				}
			}
			
			if ($action == LAOS_CRUISES){
				
				if (strpos($value['mekong_cruise_destination'], LAOS_CRUISE_DESTINATION) !== FALSE){
					
					$ret[] = $value;
					
				}
				
			}
			
			if ($action == THAILAND_CRUISES){
				
				if (strpos($value['mekong_cruise_destination'], THAILAND_CRUISE_DESTINATION) !== FALSE){
					
					$ret[] = $value;
					
				}
			}
			
			if ($action == BURMA_CRUISES){
				
				if (strpos($value['mekong_cruise_destination'], BURMA_CRUISE_DESTINATION) !== FALSE){
					
					$ret[] = $value;
					
				}
			}
			
		}
		
		return $ret;
	}
	
	function _get_all_cruise($cruise_port, $data){
		
		$data['all_cruises'] = $this->TourModel->get_all_cruises($cruise_port);
		
		$data['all_cruises_view'] = $this->load->view('tours/all_cruises', $data, TRUE);
		
		return $data;
		
	}
	
	function _get_recommeded_cruise_view($data, $cruise_port, $action, $departure_date)
    {
        $cruise_type = $this->_get_cruise_type($action);
        
        $is_charter = $action == CHARTER_HALONG_CRUISES || $action == CHARTER_MEKONG_CRUISES;
        
        $is_day_cruise = $action == HALONG_BAY_DAY_CRUISES || $action == MEKONG_RIVER_DAY_CRUISES;
        
        switch ($action)
        {
            case HALONG_BAY_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommeded_cruises($cruise_port, $departure_date);
                break;
            
            case MEKONG_RIVER_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommeded_mekong_cruises($cruise_port, $departure_date);
                break;
            
            case VIETNAM_CAMBODIA_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommended_cruises_by_location(VIETNAM_CAMBODIA_CRUISE_DESTINATION);
                break;
            
            case VIETNAM_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommended_cruises_by_location(VIETNAM_CRUISE_DESTINATION);
                break;
            
            case LAOS_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommended_cruises_by_location(LAOS_CRUISE_DESTINATION);
                break;
            
            case THAILAND_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommended_cruises_by_location(THAILAND_CRUISE_DESTINATION);
                break;
            
            case BURMA_CRUISES:
                $recommended_cruises = $this->TourModel->get_recommended_cruises_by_location(BURMA_CRUISE_DESTINATION);
                break;
            
            default:
                $recommended_cruises = $this->TourModel->get_recommeded_cruises_by_types($cruise_port, $cruise_type, $departure_date, $is_charter, $is_day_cruise);
                break;
        }
        
        foreach ($recommended_cruises as $key => $cruise)
        {
            
            if ($action == HALONG_BAY_CRUISES || $action == MEKONG_RIVER_CRUISES)
            {
                
                foreach ($cruise as $k => $v)
                {
                    
                    $v['hot_deals'] = $this->TourModel->get_cruise_hot_deal_info($v['id'], $v['url_title']);
                    
                    $cruise[$k] = $v;
                }
            }
            else
            {
                
                $cruise['hot_deals'] = $this->TourModel->get_cruise_hot_deal_info($cruise['id'], $cruise['url_title']);
            }
            
            $recommended_cruises[$key] = $cruise;
        }
        
        $data['tour_ids'] = $this->_load_tour_ids_for_from_price($recommended_cruises, $action);
        
        $data['recommended_cruises'] = $recommended_cruises;
        
        if ($cruise_port == 1)
        { // mekong river cruise
            
            $data['recommended_cruises'] = $this->load->view('tours/recommended_mekong_cruises', $data, TRUE);
        }
        else // halong bay cruise
        {
            
            $data['recommended_cruises'] = $this->load->view('tours/recommended_cruises', $data, TRUE);
        }
        
        return $data;
    }
	
	function _prepareMainData($action, $data) {
		
		$data['action'] = $action;
		
		$data['navigation'] = $this->_createNavigation($action, $data);
		
		redirect_case_sensitive_url('', $action, false);
		
		$cruise_port = $this->_get_cruise_port($action);
	
		$departure_date = date('Y-m-d', strtotime($data['search_criteria']['departure_date']));
		
		$best_deal = $this->TourModel->get_tours_by_hot_deals($cruise_port, $departure_date, 1);
	
		$data['best_tour'] = $this->_get_best_offer_tour($best_deal);
		
		$tour_hot_deals = $this->TourModel->get_tours_by_hot_deals($cruise_port, $departure_date);
		
		$data['tour_hot_deals'] = $this->_get_hot_deals_by_action($tour_hot_deals, $departure_date, $action);
		
		$data = $this->_get_recommeded_cruise_view($data, $cruise_port, $action, $departure_date);
		
		// End book together
		
		$data['departure_date'] = $departure_date;
		
		$data = $this->_get_all_cruise($cruise_port, $data);
	
		
		return $data;
	}
	
	function _get_best_offer_tour($tour_hot_deals){
		
		$ret = false;
		
		if (count($tour_hot_deals) > 0){
			
			$ret = $tour_hot_deals[0];
		
		}
	
		
		return $ret;
		
	}
	
	function _createNavigation($action, $data) {
		switch ($action) {
			case TOUR_HOME:
				return createTourHomeNavLink(true);
			case TOUR_SEARCH:
				return createTourSearchNavLink(true);
			case TOUR_DESTINATION:	
				return createTourDesNavLink(true, $data['des']);			
			case TOUR_TRAVEL_STYLE:
				return createTourStyleNavLink(true, $data['cat']);
			case HALONG_BAY_CRUISES:
				return createHalongCruisesNavLink(true);
			case LUXURY_HALONG_CRUISES:
			case DELUXE_HALONG_CRUISES:
			case CHEAP_HALONG_CRUISES:	
			case CHARTER_HALONG_CRUISES:
			case HALONG_BAY_DAY_CRUISES:	
				return createHalongCruisesCatNavLink(true, $action);							
			case MEKONG_RIVER_CRUISES:
				return createMekongCruisesNavLink(true);
			case LUXURY_MEKONG_CRUISES:
			case DELUXE_MEKONG_CRUISES:
			case CHEAP_MEKONG_CRUISES:	
			case CHARTER_MEKONG_CRUISES:
			case MEKONG_RIVER_DAY_CRUISES:
			case VIETNAM_CAMBODIA_CRUISES:
			case VIETNAM_CRUISES:
			case LAOS_CRUISES:
			case THAILAND_CRUISES:
			case BURMA_CRUISES:
				return createMekongCruisesCatNavLink(true, $action);				
			default:
				$data['name'] = $data['page_header'];
				return createTourStyleNavLink(true, $data);		
		}

		return '';		
	}
	
	
	function _get_cruise_port($action){
		
		$cruise_port = '';
		
		if ($action == HALONG_BAY_CRUISES
				|| $action == LUXURY_HALONG_CRUISES
				|| $action == DELUXE_HALONG_CRUISES
				|| $action == CHEAP_HALONG_CRUISES
				|| $action == CHARTER_HALONG_CRUISES
				|| $action == HALONG_BAY_DAY_CRUISES) {
					
					$cruise_port = 0; // halong bay cruises
			
		} else  if ($action == MEKONG_RIVER_CRUISES
				|| $action == LUXURY_MEKONG_CRUISES
				|| $action == DELUXE_MEKONG_CRUISES
				|| $action == CHEAP_MEKONG_CRUISES
				|| $action == CHARTER_MEKONG_CRUISES
				|| $action == MEKONG_RIVER_DAY_CRUISES
				|| $action == VIETNAM_CAMBODIA_CRUISES
				|| $action == VIETNAM_CRUISES
				|| $action == LAOS_CRUISES
				|| $action == THAILAND_CRUISES
				|| $action == BURMA_CRUISES) {
					
					$cruise_port = 1; // mekong river cruises
			
		} 
		
		return $cruise_port;
	}
	
	function _get_cruise_type($action){
		
		$cruise_types = array();
		
		if ($action == LUXURY_HALONG_CRUISES || $action == LUXURY_MEKONG_CRUISES){
						
			$cruise_types = array(5,4.5);
			
		}
		
		if ($action == DELUXE_HALONG_CRUISES || $action == DELUXE_MEKONG_CRUISES){
			
			$cruise_types = array(4,3.5);
			
		}
		
		if ($action == CHEAP_HALONG_CRUISES || $action == CHEAP_MEKONG_CRUISES){
			
			$cruise_types = array(3, 2.5, 2, 1.5, 1);
			
		}
		
		return $cruise_types;
			
	}
	
	/*
	 * GET CRUISE PRICE FROM
	 */
	
	function get_cruise_price_from(){
		
		$tour_ids = $this->input->post('tour_ids');
		
		$departure_date = $this->input->post('departure_date');
		
		if(!empty($tour_ids)) {
			
			$tours = array();
			$tour_ids = explode(',', $tour_ids);
			foreach ($tour_ids as $id) {
				if(!empty($id)) {
					array_push($tours, array('id'=> $id));
				}
			}
			$tour_prices = $this->TourModel->get_tours_price_optimize($tours, $departure_date);
			
			$tours = array();
			foreach ($tour_prices as $tour) {
				
				$price_view = get_tour_price_view($tour);
				
				$text_promotion = '';
				
				if (isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])) {
					 
					$text_promotion = str_replace("\n", "<br>", $tour['price']['offer_note']);
				}
				
				array_push($tours, array(
					'id'=> $tour['id'], 
					'd_price'=> $price_view['d_price'],
					'f_price'=> $price_view['f_price'],
					'offer_note' =>  $text_promotion,
				));
			}
			
			echo json_encode($tours);
		}
		
	}
	
	function _load_tour_ids_for_from_price($recommended_cruises, $action){
		
		$tour_ids = '';
		
		foreach ($recommended_cruises as $key=>$cruise){
			
			if ($action == HALONG_BAY_CRUISES || $action == MEKONG_RIVER_CRUISES){
				
				foreach ($cruise as $k=>$v){
					
					if (!empty($v['includes'])){
					
						$tour_ids = $tour_ids . ','.$v['includes']['tour_id'];
					
					}
				}
				
			} else {
				
				if (!empty($cruise['includes'])){
					
					$tour_ids = $tour_ids . ','.$cruise['includes']['tour_id'];
					
				}
				
			}
		}
		
		return $tour_ids;
	}
	
}
?>