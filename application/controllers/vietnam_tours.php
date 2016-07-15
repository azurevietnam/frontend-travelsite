<?php
class Vietnam_Tours extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model(array('TourModel','FaqModel','BestDealModel', 'BookingModel'));
		$this->load->helper(array('form', 'tour', 'text', 'cookie', 'group','booking'));
		$this->load->language(array('cruise','faq', 'tour'));
		$this->load->config('tour_meta');
		
		$this->load->driver('cache', array('adapter' => 'file'));
		// for test only
		// $this->output->enable_profiler(TRUE);
	}
	
	function index() 
	{
		$data = array();
		$data['action']	= TOUR_HOME;
		
		$data = $this->_setFormData($data);
		
		// set site meta and navigation
		$data['metas'] = site_metas('tours');
		$data['navigation'] = createTourHomeNavLink(true);
		
		redirect_case_sensitive_url('', 'tours/', false);
		
		$data = $this->get_vietnam_tours($data);
		
		$data['main'] = $this->load->view('tour_vietnam/main_view' , $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function _setFormData($data){
		// highlight tour menu
		$this->session->set_userdata('MENU', MNU_VN_TOURS);
	
		// get faq data
		$data = load_faq_by_context(FAQ_TOUR_ID, $data);
	
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
	
		// get destination data
		$data = loadTopDestination($data);
	
		// load search block
		$data = buildTourSearchCriteria($data);
		
		// load my booking overview
		//$data = get_my_booking_overview($data);
		
		// css
		$data['inc_css'] = get_static_resources('tour_destinations.min.14092013.css');
		
		// cache HTML
		$this->output->cache($this->config->item('cache_html'));
	
		return $data;
	}
	
	function get_vietnam_tours($data) {
		$des_id = $this->config->item('indochina_destinations');
		$data = $this->load_rich_snippet_infor($data, $des_id, 'Indochina');
	
		$countries = $this->config->item('indochina_destinations');
		$data['indochina_tour'] = $this->TourModel->get_recommended_Vietnam_tours();
		
		$data['indochina_styles'] = $this->TourModel->getDestinationTravelStyles(VIETNAM);
		
		$indochina_countries = array();
		foreach ($countries as $country_id) {
			$country = array();
			$des = $this->TourModel->getDestination($country_id);
			$country['name'] = $des['name'].' '.ucfirst(lang('tours'));
			$country['detail_info'] = $des['detail_info'];
			$country['picture_name'] = $des['picture_name'];
			$country['url'] = url_builder(MODULE_TOURS, $des['url_title'].'-'. MODULE_TOURS);

			$styles = $this->TourModel->getDestinationTravelStyles($country_id);
			$country_styles = array();
			foreach ($styles as $key => $style) {
				$ct_style = array();
				$style_url = get_style_short_name($style['style_name']);
				$ct_style['url'] = url_builder(MODULE_TOURS, $des['url_title'].'_'. $style_url);
				$ct_style['name'] = $des['name'].' '.$style['style_name'];
					
				$country_styles[] = $ct_style;
			}
			$country['style'] = $country_styles;

			$indochina_countries[] = $country;
		}
			
		$data['indochina_countries'] = $indochina_countries;

		$data['tour_ids'] = $data['indochina_tour']['id'];
	
		$data['contentMain'] = $this->load->view('tour_vietnam/indochina_tours_view' , $data, TRUE);
	
		$data['page_header'] = lang('tour_home');
	
		return $data;
	}
	
	function get_tour_prices() {
		ob_start(); // turn on output buffering
		
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
			$tour_prices = $this->TourModel->get_tours_price_optimize($tours, $departure_date, true);
			
			$tours = array();
			foreach ($tour_prices as $tour) {
				$price_view = get_tour_price_view($tour);
				$text_promotion = '';
				if (isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])) {
					$offers = explode("\n", $tour['price']['offer_note']);
					foreach ($offers as $key => $item) {
						if(!empty($item)) {
							$text_promotion.= $item;
							if($key < count($offers)-1) $text_promotion .= ',';
						}
					}
				}
				
				$deal_info = isset($tour['price']['deal_info']) ? $tour['price']['deal_info'] : FALSE;
				
				$deal_content = $deal_info !== FALSE ? get_promotion_condition_text($deal_info) : '';
				
				$deal_title = $deal_info !== FALSE ? '<span class="special" style="font-size: 13px;">'.htmlspecialchars($deal_info['name'], ENT_QUOTES).'</span>' : '';
				
				$promotion_id = $deal_info !== FALSE ? $deal_info['promotion_id'] : '';
				
				$is_hot_deal = $deal_info !== FALSE ? $deal_info['is_hot_deals'] : 0;
				
				array_push($tours, array(
					'id'=> $tour['id'], 
					'd_price'=> $price_view['d_price'],
					'f_price'=> $price_view['f_price'], 
					'text_promotion'=> $text_promotion,
					'deal_content' => $deal_content,
					'deal_title' => $deal_title,
					'promotion_id' => $promotion_id,
				    'is_hot_deal' => $is_hot_deal
				));
			}
			
			echo json_encode($tours);
		}
	}
	
	function tours_by_destinations()
    {
        $url_title = $this->uri->segment(1);
        
        // anti sql injection
        $url_title = anti_sql($url_title);
        
        $destination = substr($url_title, strlen(MODULE_TOURS) + 1);
        
        if (stripos($destination, MODULE_TOURS) !== false)
        {
            $destination = substr($destination, 0, strlen($destination) - strlen(MODULE_TOURS) - 1);
        }
        
        $data = array();
        
        // check if it includes a travel style
        if (strpos($destination, "_") !== false)
        {
            $des_styles = explode('_', $destination);
            
            $data['destination_style'] = $des_styles[1];
            
            $data['destination_url'] = $des_styles[0];
        }
        else
        {
            $data['destination_url'] = $destination;
        }
        
        $data = $this->load_destination($data);
        
        $des = $data['des'];
        if (! $des)
        {
            redirect(site_url());
        }
        
        if ($des['id'] == VIETNAM && ! isset($data['destination_style']))
        {
            redirect(url_builder('', TOUR_HOME));
        }
		
		// Indochina
		if($des['id'] == INDOCHINA && isset($data['destination_style'])) {
			redirect(url_builder(MODULE_TOURS, lang('indochina') . URL_SEPARATOR .MODULE_TOURS));
		}

		$data['id'] = $des['id'];
		
		// set destination to search form
		$data['destinations'] = $des['name'];
		$data['destination_ids'] = $des['id'];
		$data['destination_url_title'] = $des['url_title'];
		
		
		$data = $this->_setFormData($data);
		$parent_des = null;
		if(isset($des['parent_des'])) $parent_des = $des['parent_des'];
		
		$data['metas'] = site_metas(TOUR_DESTINATION, $des);
		$data['navigation'] = createTourDesNavLink(true, $data['des'], $parent_des);
		$data['url_title'] = $this->uri->segment(1);
		
		$data['page_header'] = str_replace('-',' ', substr($data['url_title'], 6));
		$data['page_header'] = str_replace('_',' ', $data['page_header']);
		
		if(!empty($des['tour_heading'])) {
		    $data['page_header_desc'] = $des['tour_heading'];
		}
		
		if(isset($data['destination_style'])) {
			// Show more tours by destination
			$style_name = $data['destination_style'];
			if(stripos($style_name, 'Mid-range') === false) {
				$style_name = str_replace('-', ' ', $style_name);
				$style_name = str_replace('_', ' ', $style_name);
			}
			
			$data['navigation'] = createTourDesNavLink(true, $data['des'], $parent_des, $style_name);
			$des['style_name'] = get_style_short_name($style_name, false);
			$data['metas'] = site_metas('tour_destination_styles', $des);
			
			$data = $this->getMoreToursByDestination($data);
			
			$destination_style = get_style_short_name($data['destination_style']);
			redirect_case_sensitive_url(MODULE_TOURS, $des['url_title'] .'_' . $destination_style, false);
			
			
			if ($des['id'] == 5 || $des['id'] == 227){ // Halong Bay Tours && Mekong Delta Tours				
				$data['tour_canonical'] = '<link rel="canonical" href="'.site_url(url_builder(MODULE_TOURS, $des['url_title']. '-' .MODULE_TOURS)).'/"/>';
			}
			
		} else {
			// Show recommeneded tours by destination
			$data = $this->load_destination_tours($data);
			
			redirect_case_sensitive_url(MODULE_TOURS, $des['url_title']. '-' .MODULE_TOURS, false);
			
			// remove canonical 07/11/2014 - toanlk
			/* if ($des['id'] == 5){ // Halong Bay Tours
								
				$data['tour_canonical'] = '<link rel="canonical" href="'.site_url(HALONG_BAY_CRUISES).'/"/>';
			} 
			
			if ($des['id'] == 227){ // Mekong Delta Tours
								
				$data['tour_canonical'] = '<link rel="canonical" href="'.site_url(MEKONG_RIVER_CRUISES).'/"/>';
			}  */
		}		
		
		$data['main'] = $this->load->view('tour_vietnam/main_view', $data, TRUE);
		
		$this->load->view('template', $data);
	}
	
	function load_destination($data) {
		
		$destination = $this->TourModel->getDestinationByUrlTitle($data['destination_url']);
			
		if(!empty($destination['parent_id'])) {
			$destination['parent_des'] = $this->TourModel->getDestination($destination['parent_id']);
		}
			
		$data['des'] = $destination;
		
		return $data;
	}
	
	function load_destination_tours($data) {
		
		// Rich Snippet
		$data = $this->load_rich_snippet_infor($data, $data['destination_ids'], $data['destinations']);
		
		$data['tour_vn_title'] = lang_arg('most_recommended_of_destination', $data['destinations'], date('Y'));
		$data['tour_list_title'] = lang_arg('recommended_', $data['destinations'], ucfirst(lang('tours')),'');
		
		// get destination travel styles
		$des_styles = $this->TourModel->getDestinationTravelStyles($data['destination_ids']);
		
		$tours = array();
		if(!empty($des_styles)) {
			// get best tour
			$best_tour = $this->TourModel->getToursByDestination_Optimize($data['destination_ids'], $data['search_criteria'], 1);
			
			//$tours = $this->TourModel->get_recommended_tours_by_destination($data['destination_ids'], $des_styles, $best_tour);
			
			$tours = $this->TourModel->get_tours_of_destination($data['destination_ids'], $des_styles, $best_tour);
			
			if(!empty($best_tour) && count($best_tour) > 0) {
				//array_unshift($tours, $best_tour[0]);
				$data['best_tour'] = $best_tour[0];
			}
		} else {
			$tours = $this->TourModel->getToursByDestination_Optimize($data['destination_ids'], $data['search_criteria']);
			
		}
			
		$tour_ids = array();
		if(isset($data['best_tour']) && !empty($data['best_tour'])) {
			$tour_ids[] = $data['best_tour']['id'].',';
		}

		foreach ($tours as $key => $tour)
        {
            if (! empty($des_styles))
            {
                foreach ($des_styles as $style)
                {
                    foreach ($tours[$style['style_name']] as $tour_value)
                    {
                        if(!in_array($tour_value['id'], $tour_ids)) {
                            $tour_ids[] = $tour_value['id'];
                        }
                    }
                }
            }
            elseif(!in_array($tour['id'], $tour_ids))
            {
                $tour_ids[] = $tour['id'];              
            }
        }
        
        $str_tour_ids = '';
        
        foreach ($tour_ids as $str_id)
        {
            $str_tour_ids .= $str_id . ',';
        }
        
		$data['tour_ids'] = rtrim($str_tour_ids, ',');
			
		// initial the best tour and remove it in tour list
		if(!empty($tours) > 0 && empty($des_styles)) {
			$data['best_tour'] = $tours[0];
			array_shift($tours);
		}
		
		// Book together: get recommendations
		//$data['recommendations'] = $this->getRecommendation($data);
		// End book together
		
		$data['tours'] = $tours;
		
		$data['best_tour_view'] = $this->load->view('tour_vietnam/best_tour_view', $data, TRUE);
		
		
		$data['tour_hot_deals'] = $this->get_tour_hot_deals($data['destination_ids']);
		
		if(!empty($des_styles)) {
			$data['des_styles'] = $des_styles;
			
			/* $results = array();
			foreach ($des_styles as $key => $style) {
				foreach ($tours as $num => $tour) {
					if(strpos($tour['class_tours'], $style['style_id']) !== false) {
						if((isset($results[$style['style_name']]) && count($results[$style['style_name']]) == LIMIT_TOUR_ON_TAB)) {
							continue;
						}
						$results[$style['style_name']][] = $tour;
					}
				}
			}

			$data['tours'] = $results; */
			
			$package_tours_view = $this->load->view('tour_vietnam/tour_by_travel_styles', $data, TRUE);
			
		} else {
			
			$package_tours_view = $this->load->view('tour_vietnam/tour_by_destination', $data, TRUE);
		}
		
		
		$data['contentMain'] = $package_tours_view;
	
		return $data;
	}
	
	function _setTourId($tours) {
		
		$tour_ids = '';
		
		if(!empty($tours)) {
			foreach ($tours as $key => $tour) {
				$tour_ids .= $tour['id'] . ',';
			}
		}
		
		return $tour_ids;
	}
	
	function getMoreToursByDestination($data) {
		
		$style_name = $data['destination_style'];
		
		$des_styles = $this->TourModel->getDestinationStyleUrl($style_name);
		
		$style_name_opt  	= $des_styles['name'];
		
		if(stripos($style_name, 'Mid-range') === false) {
			$style_name = str_replace('-', ' ', $data['destination_style']);
		}
		
		if(stripos($style_name_opt, 'Mid-range') === false) {
			$style_name_opt = str_replace('-', ' ', $des_styles['name']);
		}	
		
		if($data['destinations'] == "Mekong Delta") {
			$data['tour_vn_title'] = lang_arg('most_recommended_of_destination_style', $data['destinations'], $style_name_opt, date('Y'));
			$data['tour_list_title'] = lang_arg('recommended_', $data['destinations'], $style_name_opt, ucfirst(lang('tours')));
		} else {
			$title = get_style_short_name($style_name_opt, false);
			$data['tour_vn_title'] = lang_arg('most_recommended_of_destination_style', $data['destinations'], $title, date('Y'));
			$data['tour_list_title'] = lang_arg('recommended_in', $title, $data['destinations']);
		}
	
		// Book together: get recommendations
		// $data['recommendations'] = $this->getRecommendation($data);
		// End book together
		
		$tours = array();
		$tour_ids = '';
		// $des_styles = $this->TourModel->getDestinationStyleUrl($style_name);
		
		if(!empty($des_styles)) {
			$tours = $this->TourModel->get_more_tours_by_destination($data['destination_ids'], $des_styles['id']);
			
			foreach ($tours as $key => $tour) {
				$tour_ids .= $tour['id'];
				if($key < count($tours)-1) $tour_ids .= ',';
			}
			
			$data['travel_style_id'] = $des_styles['id'];
			
			$destination_info = array('name' => $data['destinations'], 'style_name' => $style_name);
			
			$data['metas'] = site_metas('tour_destination_styles', $destination_info);
			
			$data['tour_hot_deals'] = $this->get_tour_hot_deals($data['destination_ids'], $des_styles['id']);
		} 
		
		$data['tour_ids'] = $tour_ids;
	
		//$data['tours'] = $tours;
		
		// initial the best tour and remove it in tour list
		if(!empty($tours) > 0) {
			$data['best_tour'] = $tours[0];
			array_shift($tours);
		}
			
		$data['tours'] = $tours;
					
			
		$data['best_tour_view'] = $this->load->view('tour_vietnam/best_tour_view', $data, TRUE);
		
		$package_tours_view = $this->load->view('tour_vietnam/more_tours_destination_view', $data, TRUE);
		
		$data['contentMain'] = $package_tours_view;
		
		return $data;
	}
	
	function get_tour_hot_deals($destination_id, $travel_style_id = ''){
		
		$tour_hot_deals = $this->TourModel->get_tour_hot_deals_by_destination($destination_id);
		
		if ($travel_style_id != ''){
			
			$ret = array();
			
			foreach ($tour_hot_deals as $value){
				
				if (strpos($value['class_tours'], '-'.$travel_style_id.'-') !== FALSE){
					
					$ret[] = $value;
					
				}
				
			}
			
			$tour_hot_deals = $ret;
		}
		
		return $tour_hot_deals;

	}
	
	function load_rich_snippet_infor($data, $destination_id, $des_name) {
		
		$rich_snippet_infor = $this->TourModel->get_rich_snippet_destination_review($destination_id);
		
		if(!empty($rich_snippet_infor)) {
			$rich_snippet_infor['des_name'] = $des_name.' '.ucfirst(lang('tours'));
			
			$data['rich_snippet_infor'] = $rich_snippet_infor;
		}
		
		return $data;
	}
} 
?>
