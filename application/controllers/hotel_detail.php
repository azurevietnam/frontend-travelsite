<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_Detail extends CI_Controller {

	public function __construct()
    {

       	parent::__construct();

		$this->load->language(array('hotel','faq'));
		$this->load->language('tourdetail');
		$this->load->model(array('HotelModel', 'TourModel', 'CustomerModel','FaqModel', 'BookingModel'));
		$this->load->library('pagination');
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('cookie');
		$this->load->helper('booking');
		$this->load->helper('group');
		$this->load->helper('tour');

		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{

		$action = $this->input->post('action_type');

		// cache only no check rate
		if ($action == ''){
			$this->output->cache($this->config->item('cache_html'));
		}


		$this->session->set_userdata('MENU', MNU_HOTELS);

		$data['GLOBAL_DATAS'] = load_global_data();


		$data['tab_index'] = 0;// show detail tab

		$data = $this->_setFormData($data, HOTEL_DETAIL);

		$data['metas'] = site_metas(HOTEL_DETAIL, $data['hotel']);

		$data['discount_together'] = $this->_get_discount_of_hotel(1, $data['search_criteria']['hotel_night'], $data);

		$data = $this->_load_tour_recommendation($data);

		$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);

		$data['check_rate_form'] = $this->load->view('hotels/hotel_check_rate_form', $data, TRUE);

		if ($action == 'check_rate'){

			$search_criteria = $data['search_criteria'];

			$staying_dates = get_date_arr($search_criteria['arrival_date'], $search_criteria['departure_date']);

			$hotel = $data['hotel'];

			$data['additional_charges'] = $this->HotelModel->get_hotel_additional_charge($hotel['id'], $staying_dates);

			$data['check_rate_table'] = $this->load->view('hotels/hotel_rate_table_result', $data, TRUE);
		} else {
			$data['check_rate_table'] = $this->load->view('hotels/hotel_rate_table_overview', $data, TRUE);
		}

		$data['action'] = $action;

		$data['hotel_detail_view'] = $this->load->view('hotels/hotel_detail', $data, TRUE);


		$data = $this->get_stylesheet($data);

		// get similar hotels
		$data['similar_hotels'] = $this->HotelModel->getSimilarsHotels($data['hotel']);

		if(!empty($data['similar_hotels'])) {
			$data['hotel_desc'] = $this->TourModel->getDestination($data['hotel']['destination_id']);
		}

		$data['similar_hotels_view'] = $this->load->view('hotels/similar_hotels_view', $data, TRUE);

		// get faq data
		$data = load_faq_by_context(13, $data);

		redirect_case_sensitive_url(HOTEL_DETAIL, $data['hotel']['url_title'], true);

		$data['main'] = $this->load->view('hotels/hotel_detail_view', $data, TRUE);

		$this->load->view('template', $data);
	}

	function review (){

// 		$this->output->cache($this->config->item('cache_html'));

		$this->session->set_userdata('MENU', MNU_HOTELS);

		$data['GLOBAL_DATAS'] = '';

		$data['tab_index'] = 1;// show detail tab

		$data = $this->_setFormData($data, HOTEL_REVIEWS);

		$data = $this->_setReviewData($data);

		$data['metas'] = site_metas(HOTEL_REVIEWS, $data['hotel']);

		$data['discount_together'] = $this->_get_discount_of_hotel(1, $data['search_criteria']['hotel_night'], $data);

		$data = $this->_load_tour_recommendation($data);

        // get similar hotels
        $data['similar_hotels'] = $this->HotelModel->getSimilarsHotels($data['hotel']);

        if(!empty($data['similar_hotels'])) {
            $data['hotel_desc'] = $this->TourModel->getDestination($data['hotel']['destination_id']);
        }

        $data['similar_hotels_view'] = $this->load->view('hotels/similar_hotels_view', $data, TRUE);

		$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);

        $data = $this->get_stylesheet($data);

		//$data['hotel_review_view'] = $this->load->view('/customer_reviews', $data, TRUE);

		// get faq data
		$data = load_faq_by_context(13, $data);

		$data['main'] = $this->load->view('hotels/hotel_detail_view', $data, TRUE);

		$cus_type = (int)$this->uri->segment(2, -2);

		if ($cus_type != -2) {
        	$data['cruise_review_canonical'] = '<link rel="canonical" href="' . site_url(url_builder(HOTEL_DETAIL, $data['hotel']['url_title'], true)). '"/>';
        } else {

        	redirect_case_sensitive_url(HOTEL_REVIEWS, $data['hotel']['url_title'], true);
        }

		$this->load->view('template', $data);
	}


	function _set_form_data_reservation($data, $action = ''){

		$hotel_id = $this->uri->segment(2);

		// anti sql injection
		$hotel_id = anti_sql($hotel_id);

		$parent_id = $this->input->post('parent_id');

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;

		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		$search_criteria = buildHotelSearchCriteria();

		$search_criteria['staying_dates'] = get_date_arr($search_criteria['arrival_date'], $search_criteria['departure_date']);

		$hotel = $this->HotelModel->getHotel($hotel_id, $search_criteria['arrival_date'], $search_criteria['departure_date'], $data['tab_index']);

		$hotel['is_free_visa'] =$this->HotelModel->is_free_visa($hotel['id']);

		$data['hotel'] = $hotel;

		$destination = $this->HotelModel->getDestination($hotel['destination_id']);


		$data['search_criteria'] = $search_criteria;

		$data['system_hotel_facilities'] = $this->_getSystemHotelFacilities();

		$data['hotel_facilities'] = $this->_getHotelFacilities($hotel_id);

		$data['parent_id'] = $parent_id;

		return $data;
	}

	function reservation(){

		$data['tab_index'] = 2;// show detail tab

		$data = $this->_set_form_data_reservation($data, HOTEL_BOOKING);

		$data = $this->_setBookingData($data);


		$rooms = get_hotel_room_number($data['hotel']);

		$nights = $data['search_criteria']['hotel_night'];

		$data['discount_together'] = $this->_get_discount_of_hotel($rooms, $nights, $data);

		$booking_rowid = insert_hotel_acoomodation_to_cart($data);


		$is_extra_booking = $this->input->post('is_extra_booking');

		// extra booking in recommendation
		if ($is_extra_booking == '1'){

		} else {

			$this->session->set_userdata("curent_hotel_booking_rowid", $booking_rowid);

			redirect('/hotel-booking/'.$data['hotel']['url_title'].'.html');
		}

	}


	function _setReviewData($data){

		$data['review_for'] = HOTEL;

		$types = $this->config->item('score_types');

		$data['score_types'] = $types[HOTEL];

		$data['customer_types'] = $this->config->item('customer_types');

		$data['review_rate_types'] = $this->config->item('review_rate_types');

		$data['customer_countries'] = $this->config->item('countries');

		$hotel_id = $data['hotel']['id'];

		$cus_type = ''; $review_rate = '';
		$filter_type = $this->uri->segment(2);
		if (strpos($filter_type, "_") !== FALSE) {
			$e_array = explode("_", $filter_type);
			$review_rate = $e_array[0];
			$cus_type = $e_array[1];

			if(!is_numeric($cus_type) || $cus_type == '-1') $cus_type = '';
		} else {
			$review_rate = $this->uri->segment(2);
		}

		// set data for pagination
		$data['total_rows'] = $this->TourModel->getNumReviews($hotel_id, HOTEL, $review_rate, $cus_type);

		$offset = $this->uri->segment(3);
		// get customer reviews
		$data['reviews'] = $this->TourModel->getReviews($hotel_id, HOTEL, $review_rate
						, $this->config->item('per_page')
						, (int)$offset
						, $cus_type);

		$url_offset = $review_rate.'_'.$cus_type;
		if($review_rate == '') $url_offset = "-1";
		$url_paging = url_builder(HOTEL_REVIEWS, $data['hotel']['url_title'], true). '/' .  $url_offset;

		// initialize pagination
		$this->pagination->initialize(get_paging_config($data['total_rows']
							, $url_paging
							, 3));

		$data['paging_text'] = get_paging_text($data['total_rows'], $offset);

		// get number reviews for each customer type
		$data['review_rate_numbes'] = $this->_getNumberReviewsEachType($hotel_id, HOTEL, $data['review_rate_types'], false, $cus_type);

		$data['cus_type_numbes'] = $this->_getNumberReviewsEachType($hotel_id, HOTEL, $data['customer_types'], true, $cus_type, $review_rate);

		$scores = $this->TourModel->getAllReviewScores($hotel_id, HOTEL, $review_rate, $cus_type);

		$data['average_scores'] = $this->_getAverageScores($data['score_types'], $scores);

		if ($cus_type == -1){
			$data['total_score'] = $data['hotel']['total_score'];
		} else {
			$data['total_score'] = $this->_getTotalScore($data['average_scores']);
		}


		// set socre by review

		foreach ($data['reviews'] as $key=>$value){

			$value['review_scores'] = set_scrore_type_by_review($value['id'], $data['score_types'], $scores);

			$data['reviews'][$key] = $value;
		}

		return $data;
	}


	function hotel_review_ajax(){
		$action = $this->input->post('action');

		$url_title = $this->uri->segment(3);
		//$url_title = substr($url_title, strlen($action)+1);
		// $url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));
		//echo($url_title);exit();

		$url_title = anti_sql($url_title);

		$data['tab_index'] = 1;// show detail tab

		$hotel_id = $this->HotelModel->getHotelIdByUrlTitle($url_title);

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;

		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		$search_criteria = buildHotelSearchCriteria();

		$hotel = $this->HotelModel->getHotel($hotel_id, $search_criteria['arrival_date'], $search_criteria['departure_date'], $data['tab_index']);

		$data['hotel'] = $hotel;

		$data['review_for'] = HOTEL;

		$types = $this->config->item('score_types');

		$data['score_types'] = $types[HOTEL];

		$data['customer_types'] = $this->config->item('customer_types');

		$data['review_rate_types'] = $this->config->item('review_rate_types');

		$data['customer_countries'] = $this->config->item('countries');

		$hotel_id = $data['hotel']['id'];

		$cus_type = ''; $review_rate = '';
		$filter_type = $this->uri->segment(4);
		if (strpos($filter_type, "_") !== FALSE) {
			$e_array = explode("_", $filter_type);
			$review_rate = $e_array[0];
			$cus_type = $e_array[1];

			if(!is_numeric($cus_type) || $cus_type == '-1') $cus_type = '';
		}
		$data['cus_type_data'] = $filter_type;


		$hotel_ids = array($hotel_id);
		// Get the language version ids of the $tour_ids
		$hotel_ids = $this->TourModel->get_group_object_by_language($hotel_ids, HOTEL);


		// set data for pagination
		$data['total_rows'] = $this->TourModel->getNumReviews($hotel_ids, HOTEL, $review_rate, $cus_type);

		$offset = $this->uri->segment(5);
		// get customer reviews
		$data['reviews'] = $this->TourModel->getReviews($hotel_ids, HOTEL, $review_rate
				, $this->config->item('per_page')
				, (int)$offset
				, $cus_type);

		$url_offset = $review_rate.'_'.$cus_type;
		if($review_rate == '') $url_offset = "-1";
		$url_paging = 'hotel_detail/hotel_review_ajax/'.$data['hotel']['url_title'].'/'.$url_offset;

		// initialize pagination
		$this->pagination->initialize(get_paging_config($data['total_rows']
				, $url_paging
				, 5));

		$data['paging_text'] = get_paging_text($data['total_rows'], $offset);

		// get number reviews for each customer type
		$data['review_rate_numbes'] = $this->_getNumberReviewsEachType($hotel_ids, HOTEL, $data['review_rate_types'], false, $cus_type);

		$data['cus_type_numbes'] = $this->_getNumberReviewsEachType($hotel_ids, HOTEL, $data['customer_types'], true, $cus_type, $review_rate);

		$scores = $this->TourModel->getAllReviewScores($hotel_ids, HOTEL, $review_rate, $cus_type);

		$data['average_scores'] = $this->_getAverageScores($data['score_types'], $scores);

		if ($cus_type == -1){
			$data['total_score'] = $data['hotel']['total_score'];
		} else {
			$data['total_score'] = $this->_getTotalScore($data['average_scores']);
		}

		// set socre by review

		foreach ($data['reviews'] as $key=>$value){

			$value['review_scores'] = set_scrore_type_by_review($value['id'], $data['score_types'], $scores);

			$data['reviews'][$key] = $value;
		}

		echo $this->load->view('reviews/customer_reviews', $data);
	}

	function _setFormData($data, $action = ''){

		$url_title = $this->uri->segment(1);

		// anti sql injection
		$url_title = anti_sql($url_title);

		$url_title = substr($url_title, strlen($action)+1);
		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

		$hotel_id = $this->HotelModel->getHotelIdByUrlTitle($url_title);

		if ($hotel_id == ''){

			redirect(site_url('hotels')); exit();

		}

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;

		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		$search_criteria = buildHotelSearchCriteria();

		$hotel = $this->HotelModel->getHotel($hotel_id, $search_criteria['arrival_date'], $search_criteria['departure_date'], $data['tab_index']);

		if($hotel === false || !isset($hotel['destination_id'])){

			log_message('error', '[ERROR]hotel_detail(): unexpected error with $hotel_id = '.$hotel_id. '; $url_titile = '.$url_title, '; current url = '.current_url());

			redirect(site_url('hotels')); exit();

		}

		$hotel['hot_deals'] = $this->HotelModel->get_hotel_hot_deal_info($hotel['id'], $hotel['url_title']);

		$data['hotel'] = $hotel;


		//$search_criteria = $this->_setHotelInfo($search_criteria, $hotel);

		// get hotel top destinations
		$data = load_hotel_top_destination($data);

		// get data for autocomplete
		$data = load_hotel_search_autocomplete($data);

		$destination = $this->HotelModel->getDestination($hotel['destination_id']);

		$data['navigation'] = createHotelDetailNavLink($hotel, $destination);


		$data['search_criteria'] = $search_criteria;

		$data['system_hotel_facilities'] = $this->_getSystemHotelFacilities();

		$data['hotel_facilities'] = $this->_getHotelFacilities($hotel_id);

		$data['is_free_visa'] = $this->HotelModel->is_free_visa($hotel['id']);

		$data['popup_free_visa'] = $this->load->view('/ads/popup_free_visa_4_hotel', array('hotel'=>$hotel), true);

		return $data;
	}

	function _setBookingData($data){

		$total_price = 0;

		$total_promotion_price = 0;

		$hotel = $data['hotel'];

		foreach ($hotel['room_types'] as $key => $value) {
			$input_name = "nr_room_type_" . $value['id'];

			$nr_room = $this->input->post($input_name);


			$extra_bed_name = "nr_extra_bed_" . $value['id'];
			$nr_extra_bed = $this->input->post($extra_bed_name);

			if ($nr_extra_bed > $nr_room){
				$nr_extra_bed = $nr_room;
			}

			$value['nr_room'] = $nr_room;

			$value['nr_extra_bed'] = $nr_extra_bed;

			$data['hotel']['room_types'][$key] = $value;

			$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_promotion_price;

			$total_price = $nr_room * $value['price']['price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_price;

		}

		$data['total_promotion_price'] = $total_promotion_price;

		$data['total_price'] = $total_price;

		$data['countries'] = $this->config->item('countries');

		return $data;

	}



	function _getAllCitiesOfVietnam(){
		$ret = array();
		$ret['north'] = array();
		$ret['middle'] = array();
		$ret['south'] = array();

		$allCities = $this->HotelModel->getAllCitiesOfVietnam();

		foreach ($allCities as $value) {
			if($value['region'] == 1){
				$ret['north'][] = $value;
			} elseif ($value['region'] == 2){
				$ret['middle'][] = $value;
			} else {
				$ret['south'][] = $value;
			}
		}

		return $ret;
	}

	function _setHotelInfo($search_criteria, $hotel){

		//$des = $this->HotelModel->getDestination($hotel['destination_id']);

		$search_criteria['destination_id'] = $hotel['id'];

		$search_criteria['destination'] = $hotel['name'];

		$search_criteria['name'] = $hotel['name'];

		$search_criteria['hotel_stars'] = array($hotel['star']);

		$this->session->set_userdata("FE_hotel_search_criteria", $search_criteria);

		return $search_criteria;
	}

	function _buildSearchCriteria() {

		$search_criteria = array();

		if ($this->session->userdata("FE_hotel_search_criteria")){
			$search_criteria = $this->session->userdata("FE_hotel_search_criteria");
		} else {
			// do nothing
		}

		$arrival_date = $this->input->post('arrival_date_check_rate');

		if ($arrival_date !=''){
			$search_criteria['arrival_date'] =  date('d-m-Y', strtotime($arrival_date));
		}

		$hotel_night = $this->input->post('hotel_night_check_rate');

		if ($hotel_night != ''){

			$search_criteria['hotel_night'] = $hotel_night;

		}

		if(!array_key_exists('arrival_date', $search_criteria)){
			$search_criteria['arrival_date'] = date('d-m-Y');
		}

		if(!array_key_exists('hotel_night', $search_criteria)){
			$search_criteria['hotel_night'] = '1';
		}

		$departure_date = strtotime(date("d-m-Y", strtotime($search_criteria['arrival_date'])) . " +". $search_criteria['hotel_night']. " day");

		$search_criteria['departure_date'] = date('d-m-Y', $departure_date);


		if(!array_key_exists('sort_by', $search_criteria)){
			$search_criteria['sort_by'] = 'best_deals';
		}

		$this->session->set_userdata("FE_hotel_search_criteria", $search_criteria);

		return $search_criteria;
	}

	function _getSystemHotelFacilities(){

		$ret = array();

		$ret[HOTEL_FACILITY_GENERAL] = array();

		$ret[HOTEL_FACILITY_SERVICE] = array();

		$ret[HOTEL_FACILITY_ACTIVITY] = array();

		$all_facilities = $this->HotelModel->getSystemHotelFacilities();

		foreach ($all_facilities as $value) {

			if($value['hotel_facility_type'] == 0){ // general facitility

				$ret[HOTEL_FACILITY_GENERAL][$value['id']] = $value['name'];

			}

			if($value['hotel_facility_type'] == 1){ // service facitility

				$ret[HOTEL_FACILITY_SERVICE][$value['id']] = $value['name'];

			}

			if($value['hotel_facility_type'] == 2){ // activity facitility

				$ret[HOTEL_FACILITY_ACTIVITY][$value['id']] = $value['name'];

			}

		}

		return $ret;

	}

	function _getHotelFacilities($hotel_id){

		$ret = array();

		$hotel_facilities = $this->HotelModel->getHotelFacilities($hotel_id);

		foreach ($hotel_facilities as $value) {

			$ret[$value['facility_id']] = $value['value'];

		}

		return $ret;

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

	function _set_common_extra_booking($data){

		$hotel_id = $this->uri->segment(2);

		$parent_id = $this->uri->segment(3);

		$data['parent_id'] = $parent_id;

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;

		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		$search_criteria = buildHotelSearchCriteria();

		$hotel = $this->HotelModel->getHotel($hotel_id, $search_criteria['arrival_date'], $search_criteria['departure_date'], 0);

		$data['hotel'] = $hotel;

		$destination = $this->HotelModel->getDestination($hotel['destination_id']);

		$data['search_criteria'] = $search_criteria;

		$data['system_hotel_facilities'] = $this->_getSystemHotelFacilities();

		$data['hotel_facilities'] = $this->_getHotelFacilities($hotel_id);

		$data['is_extra_booking'] = '1';

		$data['atts'] = get_popup_config('extra_detail');

		$data['full_atts'] = get_popup_config('full_detail');

		return $data;
	}

	function extra_booking(){

		$data = array();

		$data = $this->_set_common_extra_booking($data);

		$data['discount_together'] = $this->_get_discount_of_hotel(1, $data['search_criteria']['hotel_night'], $data);

		$data['check_rate_form'] = $this->load->view('hotels/hotel_check_rate_form', $data, TRUE);

		$action = $this->input->post('action_type');

		if ($action == 'check_rate'){

			$search_criteria = $data['search_criteria'];

			$staying_dates = get_date_arr($search_criteria['arrival_date'], $search_criteria['departure_date']);

			$hotel = $data['hotel'];

			$data['additional_charges'] = $this->HotelModel->get_hotel_additional_charge($hotel['id'], $staying_dates);

			$data['is_free_visa'] = $this->HotelModel->is_free_visa($data['hotel']['id']);
			
			$view_data['popup_free_visa'] = load_free_visa_popup($is_mobile);
			

			$data['popup_free_visa_4_hotel'] = $this->load->view('/ads/popup_free_visa_4_hotel', $data, true);

			$data['check_rate_table'] = $this->load->view('hotels/extrabooking/hotel_extra_rate_table_result', $data, TRUE);
		} else {
			$data['check_rate_table'] = $this->load->view('hotels/hotel_rate_table_overview', $data, TRUE);
		}

		$this->load->view('hotels/extrabooking/hotel_extra_booking', $data);

	}

	function _get_discount_of_hotel($rooms, $nights, $data){

		$hotel = $data['hotel'];

		$search_criteria = $data['search_criteria'];

		$is_main_service = $this->BookingModel->is_main_service($hotel['destination_id'], HOTEL);

		$normal_discount = $this->BookingModel->get_hotel_discount($hotel['id'], $search_criteria['arrival_date']);


		$service_id = $hotel['id'];

		$service_type = HOTEL;

		$discount_coefficient = $rooms * $nights;

		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);


		return $discount_together;
	}

	function detail(){

        $data = array();
        $data = $this->get_stylesheet($data);

		$url_title = $this->uri->segment(3);

		$hotel_id = $this->HotelModel->getHotelIdByUrlTitle($url_title);

		$hotel = $this->HotelModel->getHotel($hotel_id, date(DB_DATE_FORMAT),date(DB_DATE_FORMAT), 0);

		$data['hotel'] = $hotel;

		$data['system_hotel_facilities'] = $this->_getSystemHotelFacilities();

		$data['hotel_facilities'] = $this->_getHotelFacilities($hotel_id);

		$data['detail'] = $this->load->view('hotels/extrabooking/hotel_extra_detail', $data, TRUE);

		$data['main'] = $this->load->view('hotels/extrabooking/hotel_more_detail', $data, TRUE);

		$this->load->view('popup_template', $data);

	}

	function _load_tour_recommendation($data){

		$destination_id = $data['hotel']['destination_id'];

		$search_criteria = $data['search_criteria'];


		$current_item_info['service_id'] = $data['hotel']['id'];

		$current_item_info['service_type'] = HOTEL;

		$current_item_info['url_title'] = $data['hotel']['url_title'];

		$current_item_info['normal_discount'] = $data['discount_together']['normal_discount'];

		$current_item_info['is_main_service'] = $data['discount_together']['is_main_service'];

		$current_item_info['destination_id'] = $destination_id;

		$current_item_info['is_booked_it'] = false;

		$data['current_item_info'] = $current_item_info;

		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['departure_date']);

		$data['parent_id'] = -2;

		$data['atts'] = get_popup_config('extra_detail');


		$data['recommendation_before_book_it'] = $this->load->view('common/recommendation_before_book_it', $data, TRUE);


		return $data;

	}

	function see_overview(){

		ob_start();

		$hotel_id = $this->input->post('cruise_id');

		$arrival_date = $this->input->post('arrival_date');

		$hotel_name = $this->input->post('hotel_name');

		$hotel = $this->HotelModel->get_hotel_overview($hotel_id, $arrival_date, $hotel_name);

		$data['hotel'] = $hotel;

		$data['arrival_date'] = $arrival_date;

		$data['hotel_name'] = $hotel_name;

		$hotel_overview = $this->load->view('hotels/hotel_overview', $data, TRUE);

		echo $hotel_overview;

	}

    function get_stylesheet($data) {

        $data['inc_css'] = get_static_resources('hotel_detail.min.03102013.css');

        return $data;
    }
}
?>