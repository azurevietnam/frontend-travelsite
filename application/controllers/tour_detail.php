<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tour_Detail extends CI_Controller {

	public function __construct()
    {

       	parent::__construct();

		$this->load->model(array('TourModel', 'FaqModel', 'CruiseModel', 'BookingModel'));
		$this->load->helper(array('form','tour'));
		$this->load->library('TimeDate');
		$this->load->language(array('cruise','tourdetail','faq', 'tour'));
		$this->load->library('pagination');
		$this->load->helper('text');
		$this->load->helper('cookie');
		$this->load->helper('group');
		$this->load->helper('booking');
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{
		$action = $this->input->post('action_type');
		/*
		// cache only no cache rate
		if ($action == ''){

			$this->output->cache($this->config->item('cache_html'));

		}*/

		// delete booking data in session
		$this->session->unset_userdata("FE_tour_booking");

		$url_title = $this->uri->segment(1);


		// anti sql injection
		$url_title = anti_sql($url_title);

		$url_title = substr($url_title, strlen(TOUR_DETAIL)+1);
		$sub_title = $this->uri->segment(2);

		if ($sub_title == '') {
			$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));
		} else {
			$sub_title = substr($sub_title, 0, strlen($sub_title) - strlen(URL_SUFFIX));
		}



		$departure_date_check_rates = $this->input->post('departure_date_check_rates');

		if(isset($departure_date_check_rates)) {
			$data['departure_date_check_rates'] = $departure_date_check_rates;
		}

		$data = buildTourSearchCriteria($data);

		$search_criteria = $data['search_criteria'];


		$data['search_criteria'] = $search_criteria;

		if ($this->input->post('object_change') != ''){
			$data['object_change'] = $this->input->post('object_change');
		}

		$data['check_rates'] = get_check_rate_info($search_criteria);



		$data['cabin_types'] = $this->config->item('cabin_types');



		$tour = $this->TourModel->get_tour_by_url_title($url_title, $search_criteria['departure_date']);


		if ($tour === FALSE) {
			redirect(site_url()); exit();
		}
		
		// redirect to the Halongbaycruise for Paradise Cruises: 24/01/2015
		if($tour['partner_id'] == 18){
			redirect('/halongbaycruises/', 'location', 302);
		}

		if ($this->uri->segment(2) == ''){

			redirect_case_sensitive_url(TOUR_DETAIL, $tour['url_title'], true);

		}


		$tour['hot_deals'] = $this->TourModel->get_tour_hot_deal_info($tour['id']);

		$tour_children_price = $this->TourModel->get_children_cabin_price($tour['id']);

		$data['pax_accom_info'] = calculate_pax($data['check_rates']['adults'], $data['check_rates']['children'], $data['check_rates']['infants'], $tour_children_price);

		$data['tour_children_price'] = $tour_children_price;

		$data['children_rate'] = $this->TourModel->get_children_rate($tour['id']);


		// set selected tab
		$data = $this->_setSelectedTab($data);

		$des = $this->TourModel->getDestination($tour['main_destination_id']);

		$tour['des'] = $des;


		$service_id = TOUR;
		// cruise tours
		if ($tour['cruise_id'] > 0){

			$data['cruise'] = $this->TourModel->get_cruise_of_tour($tour['cruise_id'], $tour['id'], $search_criteria['departure_date']);

			$data['similar_tours'] = $this->TourModel->getSimilarCruiseTours($tour['duration'], $tour['id'], $search_criteria, $tour['class_tours'], $tour['cruise_destination']);

			// canonical tour -> cruise
			if ($data['tab_selected'] == 0){//check-rates tab

				$data['tour_canonical'] = '<link rel="canonical" href="'.site_url(url_builder(CRUISE_DETAIL, $data['cruise']['url_title'], true)).'"/>';

			}

			$service_id = CRUISE;

			/* if($data['cruise']['cruise_destination'] == 0){ // halong bay cruises
				$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
			} */

			// Apply for both halong and mekong cruises ( toanlk - 27/08/2014 )
			if($data['cruise']['cruise_destination'] == 0 || $data['cruise']['cruise_destination'] == 1){ // halong bay cruises
			    $data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
			}

		} else if(!empty($tour['main_destination_id'])) {

			$data['similar_tours'] = $this->TourModel->getSimilarTours($tour['main_destination_id'], $tour['id'], $search_criteria);

		}

		$is_seg = $this->uri->segment(2);
		if(!empty($is_seg)) {
				$data['tour_canonical'] = '<link rel="canonical" href="'.site_url(url_builder(TOUR_DETAIL, $tour['url_title'], true)).'"/>';
		}


		$data['tour'] = $tour;

		$data['similar_tours_view'] = $this->load->view('tours/similar_tours_view', $data, TRUE);

		$data['similar_tours_bottom_view'] = $this->load->view('tours/similar_tours_bottom_view', $data, TRUE);

		$data['metas'] = site_metas(TOUR_DETAIL, $tour);

		$data['navigation'] = createTourDetailNavLink(true, $tour);

		$data['countries'] = $this->config->item('countries');

		if ($action == 'check_rate' && $tour['cruise_id'] > 0 && !is_private_tour($tour) && $data['cruise']['num_cabin'] > 0){

			$data['action'] = 'check_rate';
		}

		$data['check_rate_form'] = $this->load->view('tours/check_rate_form', $data, TRUE);


		// calculate discount

		$data['discount_together'] = $this->_get_discount_of_tour($data['check_rates']['adults'], $data['check_rates']['children'],$data);

		$data = $this->_load_tour_recommendation($data);


		if (isset($data['cruise']) && $data['cruise']['cruise_destination'] == 0){ // halong bay

			$data['cancellation_weather'] = $this->load->view('common/cancellation_weather','',true);

		} else {

			$data['cancellation_weather'] = '';
		}

		$data['price_include_exclude'] = $this->load->view('tours/price_include_exclude', $data, TRUE);

		if($action == 'check_rate') {

			$search_criteria['departure_date'] = $data['departure_date_check_rates'];
			$this->session->set_userdata("FE_tour_search_criteria", $search_criteria);

			$data['unit_types'] = $this->config->item('unit_types');

			$data['action'] = 'check_rate';

			if ($tour['cruise_id'] > 0 && !is_private_tour($tour) && $data['cruise']['num_cabin'] > 0){ // cruise tour

				$data['action'] = 'check_rate';

				$data['tour_check_rate'] = $this->load->view('tours/cruise_tour_check_rate', $data, TRUE);


			} else {
			    // open check rates tab for normal tour
			    if(is_private_tour($tour) && $tour['cruise_id']) // 02/12/2014 toanlk: select rates tab for private cruise tour
			    {
			        $data['tab_selected'] = 0;
			    } else {
                    $data['tab_selected'] = 1;
			    }

				if(isset($data['cruise'])){
					$tour['num_cabin'] = $data['cruise']['num_cabin'];
				} else {
					$tour['num_cabin'] = 0;
				}

				$data['tour'] = $tour;

				//$data['num_pax_calculated'] = get_pax_calculated($data['check_rates']['adults'], $data['check_rates']['children'], $tour);

				$data['tour_check_rate'] = $this->load->view('tours/tour_check_rate', $data, TRUE);
			}


		} else {

			$data['tour_check_rate'] = $this->load->view('tours/tour_check_overview', $data, TRUE);
		}

		// get destination data
		$data = loadTopDestination($data);

		$data = $this->load_other_tours($data);

		// get faq data
		$data = load_faq_by_context(23, $data);
        $data = $this->get_stylesheet($data);


		$data = $this->load_tour_itinerary($data);

		$data = $this->load_tour_gallery($data);

		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);

		$data['main'] = $this->load->view('tours/tour_detail_view', $data, TRUE);

		$this->load->view('template', $data);
	}

	function tour_review(){

		$url_title = $this->uri->segment(3);

		// anti sql injection
		$url_title = anti_sql($url_title);

		$data = buildTourSearchCriteria();
		$search_criteria = $data['search_criteria'];

		$data['tour'] = $this->TourModel->get_tour_by_url_title($url_title, $search_criteria['departure_date']);
		$tour_id = $data['tour']['id'];
		if ($data['tour'] == FALSE) {
			echo lang('message_no_price');
			exit;
		}

		$types = $this->config->item('score_types');

		$data['review_for'] = TOUR;

		$data['score_types'] = $types[TOUR];

		if ($data['tour']['category_id'] == 2 || $data['tour']['category_id'] == 3){
			$data['score_types'] = $types[CRUISE];
			$data['review_for'] = CRUISE;

		}

		$data['customer_types'] = $this->config->item('customer_types');

		$data['review_rate_types'] = $this->config->item('review_rate_types');

		$data['customer_countries'] = $this->config->item('countries');

		$cus_type = ''; $review_rate = '';
		$filter_type = $this->uri->segment(5);
		if (strpos($filter_type, "_") !== FALSE) {
			$e_array = explode("_", $filter_type);
			$review_rate = $e_array[0];
			$cus_type = $e_array[1];

			if(!is_numeric($cus_type) || $cus_type == '-1') $cus_type = '';
		} else {
			$review_rate = $this->uri->segment(5);
		}

		$is_score_filter = TRUE;
		$data['is_score_filter'] = $is_score_filter;


		$tour_ids = array($tour_id);
		$tour_ids = $this->TourModel->get_group_object_by_language($tour_ids, TOUR);

		// set data for pagination
		$data['total_rows'] = $this->TourModel->getNumReviews($tour_ids, $data['review_for'], $review_rate, $cus_type);

		$offset = $this->uri->segment(6);

		// get customer reviews
		$data['reviews'] = $this->TourModel->getReviews($tour_ids, $data['review_for'], $review_rate
						, $this->config->item('per_page')
						, (int)$offset, $cus_type);

		$url_offset = $review_rate.'_'.$cus_type;
		if($review_rate == '') $url_offset = "-1";
		$url_paging = 'tour_detail/tour_review/' . $url_title . '/' . REVIEWS_TAB . '/' .  $url_offset;

		// initialize pagination
		$this->pagination->initialize(get_paging_config($data['total_rows']
							, $url_paging
							, 6));

		$data['paging_text'] = get_paging_text($data['total_rows'], $offset);

		// get number reviews for each customer type
		$data['review_rate_numbes'] = $this->_getNumberReviewsEachType($tour_ids, $data['review_for'], $data['review_rate_types'], false, $cus_type);

		$data['cus_type_numbes'] = $this->_getNumberReviewsEachType($tour_ids, $data['review_for'], $data['customer_types'], true, $cus_type, $review_rate);

		$scores = $this->TourModel->getAllReviewScores($tour_ids, $data['review_for'], $review_rate, $cus_type);

		$data['average_scores'] = $this->_getAverageScores($data['score_types'], $scores);

		if ($review_rate == -1 && trim($cus_type) == ''){
			$data['total_score'] = $data['tour']['total_score']; // Prevent round inaccurate total score
		} else {
			$data['total_score'] = $this->_getTotalScore($data['average_scores']);
		}

		$data['review_for'] = TOUR;


		// set socre by review

		foreach ($data['reviews'] as $key=>$value){

			$value['review_scores'] = set_scrore_type_by_review($value['id'], $data['score_types'], $scores);

			$data['reviews'][$key] = $value;
		}

        $data = $this->get_stylesheet($data);

		$this->load->view('reviews/customer_reviews', $data);
	}


	function _getNumberReviewsEachType($tour_ids, $review_for_type, $filter_types, $is_cus_type=FALSE, $cus_type='', $review_rate='')
	{
		$ret = array();

		if($is_cus_type) {
			$ret[-1] = $this->TourModel->getNumReviews($tour_ids, $review_for_type, $review_rate, '');
		} else {
			$ret[-1] = $this->TourModel->getNumReviews($tour_ids, $review_for_type, -1, $cus_type);
		}

		foreach ($filter_types as $key=>$value) {
			if($is_cus_type) {
				$ret[$key] = $this->TourModel->getNumReviews($tour_ids, $review_for_type, $review_rate, $key);
			} else {
				$ret[$key] = $this->TourModel->getNumReviews($tour_ids, $review_for_type, $key, $cus_type);
			}

		}

		return $ret;
	}

	function _getAverageScoreByType($type, $scores){
		$index = 0;
		$score = 0;
		foreach ($scores as $value) {

			if ($type == $value['score_type']){

				$score = $score + $value['score'];

				$index = $index + 1;
			}

		}
		if ($index != 0){
			return round($score/$index,1);
		}
	}

	function _getAverageScores($score_types, $scores){
		$ret = array();

		foreach ($score_types as $key=>$value){
			$ret[$key] = $this->_getAverageScoreByType($key, $scores);
		}

		return $ret;
	}

	function _getTotalScore($average_scores){
		$total = 0;
		$index = 0;
		foreach ($average_scores as $value) {
			$total = $total + $value;
			$index = $index + 1;

		}
		$total = round($total/$index,1);
		if ($index != 0)
		{
			return $total;
		}
	}

	function _setSelectedTab($data) {
		$tab = $this->uri->segment(2);
		$tab = substr($tab, 0, strlen($tab) - strlen(URL_SUFFIX));
		switch ($tab) {
			case REVIEWS_TAB:
				$tab_selected = 2;
				break;
			default:
				$tab_selected = 0;
		}
		$data['tab_selected'] = $tab_selected;

		return $data;
	}

	function _getSystemCruiseCabinFacilities(){

		$ret = array();

		$all_facilities = $this->CruiseModel->getSystemCruiseCabinFacilities();

		foreach ($all_facilities as $value) {

			$ret[$value['id']] = $value['name'];

		}

		return $ret;
	}

	function load_other_tours($data) {

		$tour = $data['tour'];

		$data['other_tours'] = $this->TourModel->getToursOfPartner($tour['partner_id'], $tour['id']);

		$data['other_tours'] = $this->load->view('tours/other_tours', $data, TRUE);

		return $data;
	}

	function add_cart(){

		$url_title = $this->uri->segment(2);

		// anti sql injection
		$url_title = anti_sql($url_title);

		$tour_url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

		$departure_date = $this->input->post('departure_date');

		$data['unit_types'] = $this->config->item('unit_types');

		$data['tour'] = $this->TourModel->get_tour_by_url_title($tour_url_title, $departure_date);

		$service_id = TOUR;

		if ($data['tour']['cruise_id'] > 0){

			$data['cruise'] = $this->TourModel->get_cruise_of_tour($data['tour']['cruise_id'],$data['tour']['id'], $departure_date);

			$data['tour']['num_cabin'] = $data['cruise']['num_cabin'];

			$service_id = CRUISE;

		} else {
			$data['tour']['num_cabin'] = 0;
		}

		$data['booking_info'] = get_booking_info($data['tour']);


		$tour_children_price = $this->TourModel->get_children_cabin_price($data['tour']['id']);

		//echo $data['booking_info']['adults']. ' - '. $data['booking_info']['children']. ' - '. $data['booking_info']['infants']. ' - '. $tour_children_price;

		$data['pax_accom_info'] = calculate_pax($data['booking_info']['adults'], $data['booking_info']['children'], $data['booking_info']['infants'], $tour_children_price);

		/*
		if ($data['tour']['cruise_id'] > 0 && !is_private_tour($data['tour']) && $data['tour']['num_cabin'] > 0){ // cruise tour

		} else {

			$data['pax_accom_info']['num_pax'] = get_pax_calculated($data['booking_info']['adults'], $data['booking_info']['children'], $data['tour']);


		}*/

		$data['tour_children_price'] = $tour_children_price;

		$data['children_rate'] = $this->TourModel->get_children_rate($data['tour']['id']);


		$parent_id = $this->input->post('parent_id');

		$data['parent_id'] = $parent_id;


		$data['discount_together'] = $this->_get_discount_of_tour($data['booking_info']['adults'], $data['booking_info']['children'], $data);

		$booking_rowid = insert_tour_accomodation_to_cart($data);

		$is_extra_booking = $this->input->post('is_extra_booking');

		// extra booking in recommendation
		if ($is_extra_booking == '1'){

		} else {

			$this->session->set_userdata("curent_booking_rowid", $booking_rowid);

			$from = $this->uri->segment(3);

			if (empty($from)){

				redirect('/tour-booking/'.$url_title.'/');

			} else {

				redirect('/tour-booking/'.$url_title.'/'.$from.'/');
			}
		}

	}

	function extra_booking(){

		$action = $this->input->post('action_type');

		$url_title = $this->uri->segment(2);

		// anti sql injection
		$url_title = anti_sql($url_title);


		$parent_id = $this->uri->segment(3);

		$data['parent_id'] = $parent_id;

		$departure_date_check_rates = $this->input->post('departure_date_check_rates');

		if(isset($departure_date_check_rates)) {
			$data['departure_date_check_rates'] = $departure_date_check_rates;
		}

		$data = buildTourSearchCriteria($data);

		$search_criteria = $data['search_criteria'];


		$data['search_criteria'] = $search_criteria;

		$data['atts'] = get_popup_config('extra_detail');

		$data['full_atts'] = get_popup_config('full_detail');

		if ($this->input->post('object_change') != ''){
			$data['object_change'] = $this->input->post('object_change');
		}

		$data['check_rates'] = get_check_rate_info($search_criteria);



		$data['cabin_types'] = $this->config->item('cabin_types');

		$tour = $this->TourModel->get_tour_by_url_title($url_title, $search_criteria['departure_date']);

		if ( ! $tour) {
			redirect(site_url());
		}

		$tour_children_price = $this->TourModel->get_children_cabin_price($tour['id']);

		$data['pax_accom_info'] = calculate_pax($data['check_rates']['adults'], $data['check_rates']['children'], $data['check_rates']['infants'], $tour_children_price);

		$data['tour_children_price'] = $tour_children_price;

		$des = $this->TourModel->getDestination($tour['main_destination_id']);

		$tour['des'] = $des;

		// cruise tours
		if ($tour['cruise_id'] > 0){

			$data['cruise'] = $this->TourModel->get_cruise_of_tour($tour['cruise_id'], $tour['id'], $search_criteria['departure_date']);


		}

		$data['tour'] = $tour;

		if ($action == 'check_rate' && $tour['cruise_id'] > 0 && !is_private_tour($tour) && $data['cruise']['num_cabin'] > 0){

			$data['action'] = 'check_rate';
		}

		$data['is_extra_booking'] = '1';

		$data['check_rate_form'] = $this->load->view('tours/check_rate_form', $data, TRUE);

		$data['system_cruise_cabin_facilities'] = $this->_getSystemCruiseCabinFacilities();

		// get discount together
		$data['children_rate'] = $this->TourModel->get_children_rate($tour['id']);

		$data['discount_together'] = $this->_get_discount_of_tour($data['check_rates']['adults'], $data['check_rates']['children'], $data);

		$data['popup_free_visa'] = $this->load->view('/ads/popup_free_visa', $data, true);

		if($action == 'check_rate') {

			$search_criteria['departure_date'] = $data['departure_date_check_rates'];
			$this->session->set_userdata("FE_tour_search_criteria", $search_criteria);

			$data['unit_types'] = $this->config->item('unit_types');

			$data['action'] = 'check_rate';

			if ($tour['cruise_id'] > 0 && !is_private_tour($tour) && $data['cruise']['num_cabin'] > 0){ // cruise tour

				$data['action'] = 'check_rate';

				$data['tour_check_rate'] = $this->load->view('tours/cruise_tour_check_rate', $data, TRUE);


			} else {

				if(isset($data['cruise'])){
					$tour['num_cabin'] = $data['cruise']['num_cabin'];
				} else {
					$tour['num_cabin'] = 0;
				}

				//$data['num_pax_calculated'] = get_pax_calculated($data['check_rates']['adults'], $data['check_rates']['children'], $tour);

				$data['tour'] = $tour;

				$data['tour_check_rate'] = $this->load->view('tours/tour_check_rate', $data, TRUE);
			}


		} else {

			$data['tour_check_rate'] = $this->load->view('tours/tour_check_overview', $data, TRUE);
		}


		$this->load->view('tours/tour_extra_booking', $data);
	}

	function _get_discount_of_tour($adults, $children, $data){

		$tour = $data['tour'];

		$children_rate = $data['children_rate'];

		$service_id = $tour['id'];

		$service_type = TOUR;

		if ($tour['cruise_id'] > 0){

			$service_type = CRUISE;
		}

		$is_main_service = $this->BookingModel->is_main_service($tour['main_destination_id'], $service_type);

		$discount_coefficient = $adults + ($children * $children_rate / 100);

		$normal_discount = $tour['price']['discount'];

		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);

		return $discount_together;
	}

	function detail(){

		$url_title = $this->uri->segment(3);

		// anti sql injection
		$url_title = anti_sql($url_title);

		// replace html extension
		$url_title = trim($url_title);
		$url_title = str_replace('.html', '', $url_title);

		$data = array();

        $data = $this->get_stylesheet($data);

		$search_criteria = $this->session->userdata("FE_tour_search_criteria");

		$tour = $this->TourModel->get_tour_by_url_title($url_title, $search_criteria['departure_date']);


		// cruise tours
		if ($tour['cruise_id'] > 0){

			$data['cruise'] = $this->TourModel->get_cruise_of_tour($tour['cruise_id'], $tour['id'], $search_criteria['departure_date']);

		}

		unset($tour['partner_id']); //don't show customize button

		$data['tour'] = $tour;


		if (isset($data['cruise']) && $data['cruise']['cruise_destination'] == 0){ // halong bay

			$data['cancellation_weather'] = $this->load->view('common/cancellation_weather','',true);

		} else {

			$data['cancellation_weather'] = '';
		}

		$data['price_include_exclude'] = $this->load->view('tours/price_include_exclude', $data, TRUE);


		$data = $this->load_tour_itinerary($data);

		$data = $this->load_tour_gallery($data);

		$data['detail_itinerary'] = $this->load->view('tours/tour_detail_itinerary', $data, TRUE);

		$data['main'] = $this->load->view('tours/tour_more_detail', $data, TRUE);

		$this->load->view('popup_template', $data);
	}

	function _load_tour_recommendation($data){

		$destination_id = $data['tour']['main_destination_id'];

		$service_id = $data['tour']['cruise_id'] > 0 ? CRUISE : TOUR;

		$search_criteria = $data['search_criteria'];


		$current_item_info['service_id'] = $data['tour']['id'];

		$current_item_info['service_type'] = $service_id;

		$current_item_info['url_title'] = $data['tour']['url_title'];

		$current_item_info['normal_discount'] = $data['discount_together']['normal_discount'];

		$current_item_info['is_main_service'] = $data['discount_together']['is_main_service'];

		$current_item_info['destination_id'] = $destination_id;

		$current_item_info['is_booked_it'] = false;

		$data['current_item_info'] = $current_item_info;

		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['departure_date']);

		$data['parent_id'] = -1;

		$data['atts'] = get_popup_config('extra_detail');


		$data['recommendation_before_book_it'] = $this->load->view('common/recommendation_before_book_it', $data, TRUE);

		return $data;
	}

	function _restructure_itineraries($itineraries){

		$routes = array();

		foreach ($itineraries as $value){

			if ($value['type'] == 2){ // route

				$route['route'] = $value;

				$route['itineraries'] = array();

				$routes[] = $route;
			}
		}

		if (count($routes) == 0){ // for halong bay tours

			$route['route'] = array();

			$route['itineraries'] = $itineraries;

			$routes[] = $route;

		} else {

			foreach ($routes as $key=>$route){

				$current_route_id = $route['route']['id'];

				$its = array();

				foreach ($itineraries as $it){

					if ($it['id'] > $current_route_id && (!isset($routes[$key + 1]) || $it['id'] < $routes[$key + 1]['route']['id'])){

						$its[] = $it;

					}

				}

				$route['itineraries'] = $its;

				$routes[$key] = $route;
			}

		}
		return $routes;
	}

	function load_tour_itinerary($data){

		$tour = $data['tour'];

		$itineraries = $this->TourModel->get_tour_detail_itinerary($tour['id']);
		$routes = $this->_restructure_itineraries($itineraries);
		$data['routes'] = $routes;

		$data['detail_itinerary'] = $this->load->view('tours/tour_detail_itinerary', $data, TRUE);

		return $data;
	}

	function load_tour_gallery($data){

		$tour = $data['tour'];

		$tour_photos = $tour['photos'] = $this->TourModel->getTourPhotos($tour['id']);

		$cruise_photos = array();

		if ($tour['cruise_id'] > 0){

			$cruise_photos = $this->CruiseModel->getCruisePhotos($tour['cruise_id']);

		}

		$days = $this->_get_unique_days($data);

		$data['gallery_photos'] = $this->_get_tour_photos($tour_photos, $cruise_photos, $days, $tour['duration']);

		$data['tour_photos'] = $this->load->view('tours/tour_gallery', $data, TRUE);

		return $data;
	}

	function _is_exist_day($days, $day){

		if(count($days) == 0 || trim($day['label']) == '') return false;

		foreach ($days as $value){

			if(trim(strtolower($value['label'])) == trim(strtolower($day['label']))){
				return true;
			}
		}

		return false;
	}

	function _get_unique_days($data){

		$ret = array();

		if(isset($data['routes']) && count($data['routes']) > 0){

			$itineraries = $data['routes'][0]['itineraries'];

			foreach ($itineraries as $day){

				if (!$this->_is_exist_day($ret, $day) && (trim($day['label']) == '') || strpos(strtolower($day['label']), 'day') !== FALSE){

					$ret[] = $day;

				}

			}
		}

		return $ret;
	}

	function _get_tour_photos($tour_photos, $cruise_photos, $days, $duration){

		$ret = array();

		foreach ($days as $day){

			if (!empty($day['photos'])){

				$day_photos = $day['photos'];

				$day_photos = explode(',', $day_photos);

				foreach ($day_photos as $photo){

					$partern = '';

					if(stripos($photo, 'tour_') !== false) {

						$partern = 'tour_';
					}


					if(stripos($photo, 'cruise_') !== false) {

						$partern = 'cruise_';
					}

					$photo_name = str_replace($partern, '', $photo);

					$photo_caption = $this->_get_photo_caption($partern, $photo_name, $tour_photos, $cruise_photos);

					if ($partern != ''){

						$photo_item['name'] = $photo_name;

						$photo_item['medium_path'] = $this->config->item($partern.'medium_path');

						$photo_item['220_165_path'] = $this->config->item($partern.'220_165_path');

						$photo_item['small_path'] = $this->config->item($partern.'small_path');

						if (trim($day['label']) != '' && $duration >= 4){

							$photo_item['caption'] = $day['label'];

							if ($photo_caption != ''){
								$photo_item['caption'] = $photo_item['caption']. ' - '. $photo_caption;
							} else {
								//$photo_item['caption'] = '';
							}

						} else {

							$photo_item['caption'] = $photo_caption;
						}

						$photo_item['partern'] = $partern;

						$ret[] = $photo_item;

					}
				}
			}

		}

		foreach ($tour_photos as $photo){

			$photo_item['name'] = $photo['picture_name'];

			$photo_item['partern'] = 'tour_';

			$photo_item['medium_path'] = $this->config->item('tour_medium_path');

			$photo_item['220_165_path'] = $this->config->item('tour_220_165_path');

			$photo_item['small_path'] = $this->config->item('tour_small_path');

			$photo_item['caption'] = $photo['comment'];

			if (!$this->_is_photo_item_added($ret, $photo_item['name'], 'tour_')){

				$ret[] = $photo_item;

			}
		}

		/*
		foreach ($cruise_photos as $photo){

			$photo_item['name'] = $photo['name'];

			$photo_item['partern'] = 'cruise_';

			$photo_item['medium_path'] = $this->config->item('cruise_medium_path');

			$photo_item['220_165_path'] = $this->config->item('cruise_220_165_path');

			$photo_item['caption'] = $photo['description'];

			if (!$this->_is_photo_item_added($ret, $photo_item['name'], 'cruise_')){
				$ret[] = $photo_item;
			}
		}*/


		return $ret;
	}

	function _get_photo_caption($partern, $photo_name, $tour_photos, $cruise_photos){

		if($partern == 'tour_'){

			foreach ($tour_photos as $photo){

				if ($photo['picture_name'] == $photo_name){

					return $photo['comment'];

				}

			}
		}

		if($partern == 'cruise_'){

			foreach ($cruise_photos as $photo){

				if ($photo['name'] == $photo_name){

					return $photo['description'];

				}

			}
		}

		return '';

	}

	function _is_photo_item_added($photo_items, $photo_name, $partern){

		foreach ($photo_items as $photo_item){

			if ($photo_item['name'] == $photo_name && $photo_item['partern'] == $partern) return true;

		}

		return false;
	}

    function get_stylesheet($data) {

        $data['inc_css'] = get_static_resources('tour_detail.min.171120141459.css');

        return $data;
    }
}
?>