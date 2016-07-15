<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Tour Details Page
  *  
  *  include cruise tour and land tour
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Tour_Detail extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
		
       	$this->load->helper(array('basic', 'resource', 'tour', 'tour_rate', 'tour_search','destination','faq', 'text', 'hotline','review','recommend'));
       	
       	$this->load->model(array('Tour_Model', 'Destination_Model', 'Faq_Model'));
       	
       	$this->load->language(array('tour', 'cruise', 'tourdetail'));
       	
       	$this->load->config('tour_meta');
       	
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index($url_title)
    {	
        // review page
        $segments = $this->uri->segments;
        $data['is_review_on'] = !empty($segments[2]) && $segments[2] == 'Reviews';
        
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();
    	
    	// set cache html
    	set_cache_html();
    	
    	// set current menu
    	set_current_menu(MNU_VN_TOURS);
    	
    	$tour = $this->Tour_Model->get_tour_detail($url_title);
    	
    	// redirect to homepage if cannot find the tour
    	if (empty($tour)) {
    		redirect(get_page_url(HOME_PAGE));
    	}
    	
    	$data['page'] = TOUR_DETAIL_PAGE;
    	
    	$tour['special_offers'] = load_promotion_popup($is_mobile, $tour['promotions'], TOUR, false);
    	
    	$data['tour'] = $tour;
    	
    	$data['is_mobile'] = $is_mobile;
    	
    	// for navigation
    	$cruise = get_cruise_data_from_tour($tour);
    	if(!empty($cruise)){
    		$data['cruise'] = $cruise;
    	}
    	
    	// for navigation
    	$destination = $this->Destination_Model->get_destination($tour['main_destination_id']);
    	if(!empty($destination)){
    		$data['destination'] = $destination;
    	}
    	
    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(TOUR_DETAIL_PAGE, $tour, $cruise);
    	 
    	$data['page_theme'] = get_page_theme(TOUR_DETAIL_PAGE, $is_mobile);
    	
    	$data = get_page_navigation($data, $is_mobile, TOUR_DETAIL_PAGE);
    	
    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);
    	
    	// load how-to-book a trip
    	$data = load_how_to_book_trip($data, $is_mobile);
    	
    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_DETAIL);
    	
    	// load tour-photos slider
    	$photos = $this->Tour_Model->get_tour_photos($tour['id']);
        $map_photos = array();
        $gallery_photos = array();
        foreach ($photos as $photo)
        {
            if ($photo['type'] == 4) // map photo
            {
                $map_photos[] = $photo;
            } else {
                $gallery_photos[] = $photo;
            }
        }
        
        if($is_mobile) {
            $data = load_photo_slider($data, $is_mobile, $gallery_photos, PHOTO_FOLDER_TOUR, true);
        } else {
            $data = load_photo_map($data, $map_photos, $is_mobile);
             
            $data = load_photo_for_details($data, $is_mobile, $gallery_photos, PHOTO_FOLDER_TOUR, 5);
        }
    	
    	// load tour header area: name, destination, review, price, offer ...
    	$data = $this->_load_tour_header_area($data, $is_mobile, $tour);
    	
    	// load tour tab (rate, itinerary, review)
    	$data = $this->_load_tour_rate_itinerary_review($data, $is_mobile, $tour);
    	
    	// load itinerary overview
    	$data = $this->_load_itinerary_overview($data, $is_mobile, $tour);
    	
    	// load similar tour
    	$data = $this->_load_similar_tours($data, $is_mobile, $tour);
    	
    	if($is_mobile) {
    	    $activeTab = $this->input->get('activeTab');
    	    $default_tab = !empty($tour['cruise_id']) ? 'tab_check_rates' : 'tab_itinerary';
    	    $data['activeTab']  = !empty($activeTab) ? $activeTab : $default_tab;
    	    
    	    $data['tour_header_tabs'] = $this->load->view('mobile/tours/detail/tour_header_tabs', $data, TRUE);
    	    
    	    if(is_free_visa_tour($tour)){
    	    	
    	    	$data['popup_free_visa'] = load_free_visa_popup($is_mobile);
    	    	
    	    }
    	}
    	
        render_view('tours/detail/tour_detail', $data, $is_mobile);
    }
    
    /**
     * Khuyenpv Feb 26 2015
     * Load Tour Explore Cruising
     */
    function _load_tour_explore_cruising($data, $is_mobile, $tour){
    	
    	if($tour['cruise_id'] > 0){ // only for cruise tour

    		$mobile_folder = $is_mobile ? 'mobile/' : '';
    		 
    		$data['explore_cruising'] = $this->load->view($mobile_folder.'tours/detail/explore_cruising', $data, TRUE);
    		
    	} else {
    		
    		$data['explore_cruising'] = '';
    	}

    	return $data;
    }
    
    /**
     * Khuyenpv Feb 26 2015
     * Load the tour itinerary detail
     */
    function _load_itinerary_overview($data, $is_mobile, $tour){
    	
    	// only load tour itinerary of Land Tour & tour duration >= 3
    	if(!$is_mobile && $tour['cruise_id'] == 0 && $tour['duration'] >= 3){
    		
    		$data['itinerary_overview'] = $this->load->view('tours/detail/itinerary_overview', $data, TRUE);
    		
    	} else {
    		
    		$data['itinerary_overview'] = '';
    	}
    	
    	return $data;
    }
    
    /**
     * Get similar tours with similar duration, group type and budget
     * 
     * Land tours: in the same destination
     * Cruise tours: same cruise port
     *
     * @author toanlk
     * @since  Mar 19, 2015
     */
    function _load_similar_tours($data, $is_mobile, $tour)
    {
        $similar_tours  = ''; 
        $more_tour_text = '';
        $more_tour_link = '';
        
        $mobile_folder = $is_mobile ? 'mobile/' : '';
        
        $view_data['tours'] = $this->Tour_Model->get_similar_tours($tour);
        
        $tour['desination'] = $this->Destination_Model->get_destination($tour['main_destination_id']);
        
        if (! empty($view_data['tours']))
        {
            if (! empty($tour['desination']))
            {
                if (! empty($tour['cruise_id'])) // Cruise Tours
                {
                    if ($tour['cruise_destination'] == HALONG_CRUISE_DESTINATION)
                    {
                        $similar_title = lang('similar_halong_cruise_tours');
                        $more_tour_text = lang('more_halong_bay_tours');
                    }
                    else
                    {
                        $similar_title = lang('similar_mekong_cruise_tours');
                        $more_tour_text = lang('more_mekong_delta_tours');
                    }
                }
                else {                         // Land Tours
                    $similar_title = lang_arg('similar_name_tour', $tour['desination']['name']);
                
                    $more_tour_text = lang_arg('more_name_tour', $tour['desination']['name']);
                }
                
                $more_tour_link = get_page_url(TOURS_BY_DESTINATION_PAGE, $tour['desination']);
                
                $view_data['similar_title'] = $similar_title;
                
                $view_data['more_tour_text'] = $more_tour_text;
                
                $view_data['more_tour_link'] = $more_tour_link;
            }
            
            if($is_mobile) {
                
                $view_data = load_list_tours($view_data, $is_mobile, $view_data['tours']);
                
            } else {
                
                $similar_tours_side = $this->load->view($mobile_folder . 'tours/detail/similar_tours_side', $view_data, TRUE);
            }
            
            $similar_tours = $this->load->view($mobile_folder . 'tours/detail/similar_tours', $view_data, TRUE);
        }
        
        $data['similar_tours'] = $similar_tours;
        
        $data['similar_tours_side'] = !empty($similar_tours_side)? $similar_tours_side : '';
        
        return $data;
    }
    
    /**
     * Load tour-header area: name, destination, review, price & offer
     *
     * @author toanlk
     * @since  Apr 1, 2015
     */
    function _load_tour_header_area($data, $is_mobile, $tour)
    {
        $mobile_folder = $is_mobile ? 'mobile/' : '';
        
        // load review overview
        $data = load_review_overview($data, $is_mobile, $tour['total_score'], $tour['review_number'], null);
        
        $data['tour_header'] = $this->load->view($mobile_folder . 'tours/detail/tour_header', $data, TRUE);
        
        return $data;
    }
    
    /**
     * Load tour tab: rate, itinerary & review
     *
     * @author toanlk
     * @since  Apr 1, 2015
     */
    function _load_tour_rate_itinerary_review($data, $is_mobile, $tour)
    {
        $mobile_folder = $is_mobile ? 'mobile/' : '';

        $data['is_hide_itinerary'] = TOUR_DETAIL_PAGE;
        
        $data = load_customer_reviews($data, $is_mobile, $tour, TOUR);
        
        $data = load_tour_itinerary($data, $is_mobile, $tour);
        
        $data = load_tour_check_rate_form($data, $is_mobile, $tour);
        
        $data = load_tour_rate_table($data, $is_mobile, $tour);
        
        $data = load_tour_booking_conditions($data, $is_mobile, $tour);
        
        // load service recommendations
        $current_item_info = get_current_tour_booking_info($tour, $data['discount_together']);
        $data = load_service_recommendation($data, $is_mobile, $current_item_info);
        
        // load the extra-saving recommend
        $data = load_extra_saving_recommendation($data, $is_mobile);
        
        $data['tour_tab'] = $this->load->view($mobile_folder . 'tours/detail/tour_tab', $data, TRUE);
        
        return $data;
    }
}
?>
