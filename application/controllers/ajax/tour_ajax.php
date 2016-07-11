<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_Ajax extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource','tour','tour_rate','review', 'recommend', 'text'));

       	$this->load->model(array('Tour_Model','Destination_Model', 'BookingModel'));

       	$this->load->language(array('tour','cruise','destination'));

       	$this->load->config('tour_meta');
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	/**
	 * Khuyenpv March 09 2015
	 * Tour Destination Autocomplete Remote Loading
	 */
	function tour_des_auto_remote($name){
		//sleep(10);
		$return_data = array();
		
		$this->output->set_content_type('application/json');

		$prefetch_types = array(DESTINATION_TYPE_CITY, DESTINATION_TYPE_CRUISE);
		
		$destinations = $this->Destination_Model->search_des_auto($prefetch_types, $name, false);
		
		$return_data = set_color_des($destinations);
		
		$this->output->set_output(json_encode($return_data));
	}

	/**
	 * Khuyenpv March 13 2015
	 * Tour Destination Autocomplete Prefetch Loading
	 */
	function tour_des_auto_prefetch(){
		//sleep(10);
		
		$this->output->set_content_type('application/json');

		$prefetch_types = array(DESTINATION_TYPE_CITY, DESTINATION_TYPE_CRUISE);

		$destinations = $this->Destination_Model->search_des_auto($prefetch_types);
		
		$return_data = set_color_des($destinations);

		$this->output->set_output(json_encode($return_data));
	}

	/**
	 * Get the lasted Tour Search
	 *
	 * @author Khuyenpv
	 * @since  Mar 11, 2015
	 */
	function get_lasted_tour_search(){
		$lasted_search = get_last_search(TOUR_SEARCH_HISTORY);

		echo json_encode($lasted_search);
	}


	/**
	 * Search More Tour Recommendation
	 * Using in 'Service Recommendation' module
	 *
	 * @author Khuyenpv
	 * @since 04.04.2015
	 */
	function recommend_more_tour(){

		$this->load->library('pagination');

		$destination_id = $this->input->post('destination_id');

		$service_type = $this->input->post('service_type');

		$start_date = $this->input->post('start_date');

		$block_id = $this->input->post('block_id');

		$search_params = get_tour_quick_search_params($block_id);

		if(empty($search_params['destination'])){

			$search_params['destination_id'] = $destination_id;

			$destination = $this->Destination_Model->get_destination($destination_id);

			$search_params['destination'] = $destination['name'];

		}

		$quick_search = load_tour_quick_search($block_id, $search_params);

		// current booking item
		$current_item_info = get_current_item_info_post_data();

		$data['recommend_form_data'] = load_recommend_form_data($destination_id, $service_type, $block_id, $current_item_info, $quick_search);

		$data['block_id'] = $block_id;

		$paging_cnf['per_page'] = 5;
		$paging_cnf['num_links'] = 5;

		$cnt_total = $this->Tour_Model->count_recommend_more_tours($search_params);

		$offset = (int)$this->uri->segment(2);

		$tours = $this->Tour_Model->recommend_more_tours($search_params, $start_date, $offset, $paging_cnf['per_page']);

		$tours = $this->Tour_Model->get_tour_normal_discount($tours, $start_date);

		// set price for tour-price information
		foreach ($tours as $key=>$tour){
			$tour['price']['price_origin'] = $tour['price_origin'];
			$tour['price']['price_from'] = $tour['price_from'];
			$tours[$key] = $tour;
		}

		$paging_config = create_paging_config($cnt_total, '/recommend-more-tour/', 2, $paging_cnf);
		// initialize pagination
		$this->pagination->initialize($paging_config);

		$paging_info['paging_text'] = create_paging_text($cnt_total, $offset, $paging_cnf);

		$paging_info['paging_links'] = $this->pagination->create_links();

		$data['paging_info'] = $paging_info;

		$tours = set_disount_together_for_services($tours, $current_item_info);

		$data['services'] = $tours;

		$data['service_type'] = $service_type;
		
		$data['current_item_info'] = $current_item_info;

		echo load_view('common/recommend/recommend_more_services', $data, false);

	}

	/**
	 * Tour Extra Booking
	 *
	 * @author Khuyenpv
	 * @since 06.04.2015
	 */
	function extra_booking($url_title, $parent_id){

		$is_mobile = is_mobile();

		$tour = $this->Tour_Model->get_tour_detail($url_title);

		// redirect to homepage if cannot find the tour
		if (empty($tour)) {
			echo '';exit();
		}

		$data['form_action'] = '/tour-extra-booking/'.$url_title.'/'.$parent_id.'/';
		$data['parent_id'] = $parent_id;

		$data = load_tour_check_rate_form($data, $is_mobile, $tour, array(), true, false);

		$data = load_tour_rate_table($data, $is_mobile, $tour);

		echo load_view('tours/booking/extra_booking', $data, $is_mobile);

	}

	/**
	 * Get tour price-from
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	function get_tour_price_from(){

		$tour_ids = $this->input->post('tour_ids');

		$departure_date = get_current_tour_departure_date();

		$prices = $this->Tour_Model->get_tour_price_from_ajax($tour_ids, $departure_date);

		echo json_encode($prices);
	}

	/**
	 * User click on See_More_Deals on Search Page
	 * @author Khuyenpv
	 * @since 13.04.2015
	 */
	function see_more_deals(){

		$is_mobile = is_mobile();

		$tour_id = $this->input->post('tour_id');

		$departure_date = $this->input->post('departure_date');

		$tour = $this->Tour_Model->get_tour_by_id($tour_id, $departure_date);



		$destination_id = $tour['main_destination_id'];

		$service_type = $tour['cruise_id'] > 0 ? CRUISE : TOUR;

		$is_main_service = $this->BookingModel->is_main_service($destination_id, $service_type);


		// load service recommendation
		$current_item_info['service_id'] = $tour['id'];

		$current_item_info['service_type'] = $service_type;

		$current_item_info['url_title'] = $tour['url_title'];

		$current_item_info['normal_discount'] = !empty($tour['price']['discount']) ? $tour['price']['discount'] : 0;

		$current_item_info['is_main_service'] = $is_main_service;

		$current_item_info['destination_id'] = $destination_id;

		$current_item_info['is_booked_it'] = false;

		$current_item_info['parent_id'] = ''; // NO CURRENT SELECTED BOOKING ITEM

		$current_item_info['start_date'] = $departure_date;


		$data = load_service_recommendation(array(), $is_mobile, $current_item_info, '', false, false);

		echo $data['recommend_sevices'];
	}

	/**
	 * Ajax functions for Tour-Overview
	 *
	 * @author Khuyenpv
	 * @since 14.04.2015
	 */
	function see_overview(){

		$is_mobile = is_mobile();

		$departure_date = get_current_tour_departure_date();

		$url_title = $this->input->post('url_title');

		$tour = $this->Tour_Model->get_tour_detail($url_title);

		$tour['special_offers'] = empty($tour['promotions']) ? '' : load_promotion_popup($is_mobile, $tour['promotions']);

		$tours = array($tour);
		$tours = $this->Tour_Model->get_tour_price_froms($tours, $departure_date);
		$tour = $tours[0];

		$tour['itineraries'] = $this->Tour_Model->get_itinerary($tour['id']);
		
		// get itinerary highlight
		$tour['highlights'] = $this->Tour_Model->get_itinerary_highlight($tour['id']);

		$photos = $this->Tour_Model->get_tour_photos($tour['id']);
		$view_data['is_mobile'] = $is_mobile;

		$view_data['tour'] = $tour;
		$view_data = load_photo_for_details($view_data, $is_mobile, $photos, PHOTO_FOLDER_TOUR, 5);

		$overview['title'] = $tour['name'];
		$overview['content'] = load_view('tours/common/tour_overview', $view_data, $is_mobile);

		echo json_encode($overview);
	}

	/**
	 * Load more tours of the destination travel style
	 *
	 * @author toanlk
	 * @since  Apr 18, 2015
	 */
	function show_more_tours()
    {
        $data = $this->input->post('data');
        
        if (! empty($data['destination']) && ! empty($data['style']) && is_numeric($data['destination']) && is_numeric($data['style']))
        {
        	
            $mobile_folder = is_mobile() ? 'mobile/' : '';

            $departure_date = get_current_tour_departure_date();
            
            $tours = $this->Tour_Model->get_tours_by_destination_travel_style($data['destination'], $data['style'], null, 10, $data['offset']);
            
            foreach ($tours as $key => $value){
            	$tour[$key + $data['offset'] - 1] = $tours[$key];
            }
            
            if (! empty($tour))
            {
            	$view_data['is_enable_number'] = $data['is_enable_number'];
            	
                $view_data['tours'] = $this->Tour_Model->get_tour_price_froms($tour, $departure_date);

                $list_tours = $this->load->view($mobile_folder . 'tours/common/list_tours', $view_data, TRUE);

                echo $list_tours;
            }
        }
    }
    
    /**
      * get_route_map
      *
      * @author toanlk
      * @since  Jun 10, 2015
      */
    function get_route_map() {
        $tour_id = $this->input->post('id');
        
        if(!empty($tour_id) && is_numeric($tour_id)) {
            
            $data = $this->Tour_Model->get_tour_route($tour_id);
            
            if(!empty($data)) {
                
                foreach ($data as $k => $value) {
                    
                    $value['full_url'] = get_page_url(DESTINATION_DETAIL_PAGE, $value);
                    
                    unset($value['url_title']);
                    
                    $value['picture'] = get_image_path(PHOTO_FOLDER_DESTINATION, $value['picture'], '135_90');
                    
                    $value['description'] = strip_tags($value['description']);
                    $value['description'] = character_limiter($value['description'], 140);
                
                    $data[$k] = $value;
                }
                
                echo json_encode($data);
            }
        }   
    }
}

?>
