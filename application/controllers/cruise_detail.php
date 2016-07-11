<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cruise_Detail extends CI_Controller {

	public function __construct()
   	{

       	parent::__construct();

		$this->load->language(array('tourdetail','cruise','faq'));
		$this->load->model(array('CruiseModel','BookingModel','TourModel','FaqModel'));
		$this->config->load('cruise_meta');
		$this->load->library('pagination');
		$this->load->helper(array('form', 'tour', 'text', 'group', 'booking'));

		$this->load->driver('cache', array('adapter' => 'file'));

		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{

		$action = $this->input->post('action_type');
		// only cache if no check rate
		if ($action == ''){

			$this->output->cache($this->config->item('cache_html'));

		}

		$t1 = microtime(true);

		$url_title = $this->uri->segment(1);

		// anti sql injection
		$url_title = anti_sql($url_title);

		$strpos = strpos($url_title, '&');
		if ($strpos) {
			$url_title = substr($url_title, 0, $strpos);
		}

		$url_title = substr($url_title, strlen(CRUISE_DETAIL)+1);
		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

		// update redirect ( 03/12/2014 - toanlk )
		if ($url_title == 'Aclass-Cruise'){
		    $url_title = 'Aclass-Legend-Cruise';
		
		    redirect(url_builder(CRUISE_DETAIL, $url_title, true), 'location', 301);
		}

		// redirect to the Halongbaycruise for Paradise Cruises: 24/01/2015
		if ($url_title == 'Paradise-Cruise'){

			redirect('/halongbaycruises/', 'location', 302);
		}
		
		/*
		if ($url_title == 'Paradise-Luxury-Cruise'){
			$url_title = 'Paradise-Cruise';

			redirect(url_builder(CRUISE_DETAIL, $url_title, true), 'location', 301);
		}


		if ($url_title == 'La-Marguerite-Cruise'){
			$url_title = 'RV-La-Marguerite-Cruise';

			redirect(url_builder(CRUISE_DETAIL, $url_title, true), 'location', 301);
		}

		if ($url_title == 'Amalotus-Cruise'){
			$url_title = 'RV-Amalotus-Cruise';

			redirect(url_builder(CRUISE_DETAIL, $url_title, true), 'location', 301);
		}*/

		$data = buildTourSearchCriteria();
		$search_criteria = $data['search_criteria'];


		$departure_date = date('Y-m-d', strtotime($search_criteria['departure_date']));



		$cruise = $this->_get_cruise_object($url_title);

		if ($cruise == ''){
			return redirect(site_url());
		}


		$cruise['tours'] = $this->_get_cruise_tours($cruise, $departure_date);

		$data['cruise'] = $cruise;


		$data = $this->_setFormData($data);

		$data['metas'] = site_metas(CRUISE_DETAIL, $cruise);

		if ($cruise['cruise_destination'] == 1){
			$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		} else {
			$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
		}

		$data['navigation'] = createCruiseNavLink($cruise);

		$data = $this->_get_cruise_detail($data);

		$data = $this->_set_check_rate_data($data);

		$data['content'] = 'cruise';

		$data['tab_index'] = 0;

		$data = $this->get_stylesheet($data);

		redirect_case_sensitive_url(CRUISE_DETAIL, $cruise['url_title'], true);

		$data['main'] = $this->load->view('cruises/cruise_detail_view', $data, TRUE);

		$t2 = microtime(true);

		$data['time_exe'] =  $t2 - $t1;

		$this->load->view('template', $data);

	}

	function get_cruise_tours_from_price(){

		$ret = array();

		$tour_ids = $this->input->post('tour_ids');

		$tour_ids = explode(",", $tour_ids);

		$departure_date = $this->input->post('departure_date');

		$departure_date = date('Y-m-d', strtotime($departure_date));

		$tours = $this->TourModel->get_cruise_tours_from_price($tour_ids, $departure_date);

		foreach ($tours as $tour){

			$tour_price_item['id'] = $tour['id'];

			$tour_price_item['price'] = 0;

			$tour_price_item['promotion_price'] = 0;

			$price_now = get_price_now($tour['price']);

			$best_price_now = get_best_price_now($tour['price']);

			$tour_price_item['price'] = $tour['price']['from_price'];

			if(is_group($tour)){

				$tour_price_item['promotion_price'] = $best_price_now;

			} else {

				$tour_price_item['promotion_price'] = $price_now;

			}

			$tour_price_item['is_promotion'] = $tour_price_item['promotion_price'] != $tour_price_item['price'];

			$tour_price_item['price'] = CURRENCY_SYMBOL.number_format($tour_price_item['price'], CURRENCY_DECIMAL);

			$tour_price_item['promotion_price'] = CURRENCY_SYMBOL.number_format($tour_price_item['promotion_price'], CURRENCY_DECIMAL);


			$ret[] = $tour_price_item;

		}

		echo json_encode($ret);

	}

	function get_cruise_tours_view(){
		ob_start();

		$cruise_id = $this->input->post('cruise_id');

		$departure_date = $this->input->post('departure_date');

		$departure_date = date('Y-m-d', strtotime($departure_date));

		$cruise['tours'] = $this->TourModel->get_cruise_tours($cruise_id, $departure_date);

		$data['cruise'] = $cruise;

		$cruise_tours = $this->load->view('cruises/cruise_tours', $data, TRUE);

		echo $cruise_tours;
	}


	function _get_cruise_tours($cruise, $departure_date){

		$tours = $this->TourModel->get_list_tours_of_cruise($cruise['id']);

		return $tours;
	}

	function _get_cruise_object($url_title){

	   $cruise = $this->CruiseModel->getCruiseByUrlTitle($url_title);

		if ($cruise == ''){

			redirect(site_url()); exit();

		}

		$cruise['hot_deals'] = $this->TourModel->get_cruise_hot_deal_info($cruise['id'], $cruise['url_title']);

		return $cruise;
	}

	function _get_cruise_detail($data){

		$cruise = $data['cruise'];

		$cruise_detail_data['cruise_facilities'] = $this->_get_cruise_facilities($cruise['id']);

		$cruise_detail_data['cruise_cabin_facilities'] = $this->_get_cruise_cabin_facilities($cruise['id']);

		$cruise_detail_data['photos'] = $this->CruiseModel->getCruisePhotos($cruise['id']);

		$cruise_detail_data['videos'] = $this->CruiseModel->getCruiseVideos($cruise['id']);

		$data['cruise_facilities'] = $cruise_detail_data['cruise_facilities'];

		$data['cruise_cabin_facilities'] = $cruise_detail_data['cruise_cabin_facilities'];

		$cruise_detail_data['cabins'] = $cruise['cabins'];
		$cruise_detail_data['cruise_name'] = $cruise['name'];
		$data['videos_view'] = $this->load->view('cruises/cruise_videos', $cruise_detail_data, TRUE);
		$data['cruise_photos_view'] = $this->load->view('cruises/cruise_photos', $cruise_detail_data, TRUE);

		$data['list_images'] = $this->load->view('cruises/cruise_list_images', $cruise_detail_data, TRUE);

		if ($cruise['cruise_destination'] == 0){ // halong bay

			$data['cancellation_weather'] = $this->load->view('common/cancellation_weather','',true);

		} else {

			$data['cancellation_weather'] = '';
		}

		return $data;
	}

	function _get_other_cruises_of_partner($data){

		$cruise = $data['cruise'];

		$data['partner_cruises'] = $this->CruiseModel->getOtherCruiseOfPartner($cruise['partner_id'], $cruise['id']);

		$other_cruises_view = $this->load->view('cruises/other_cruises_of_partner', $data, TRUE);

		$data['other_cruises_view'] = $other_cruises_view;

		return $data;
	}

	function _get_similar_cruises($data){

		$cruise = $data['cruise'];

		$data['similar_cruises'] = $this->CruiseModel->get_similar_cruises($data['cruise']);

		$similar_cruises_view = $this->load->view('cruises/similar_cruises', $data, TRUE);

		$data['similar_cruises_view'] = $similar_cruises_view;

		$data['similar_cruises_bottom_view'] = $this->load->view('cruises/similar_cruises_bottom', $data, TRUE);;

		return $data;
	}

	function get_image(){

		ob_start();

		$img = "";

		$cruise_id = $this->input->post("cruise_id");

		$cruise_url_title = $this->input->post("cruise_url_title");

		/**
		 *  delete cache database element
		 *  TinVM 6.11.2014
		 */

// 		$cache_time = $this->config->item('cache_cruise_time');

// 		$cache_file_id = 'photos_'.$cruise_url_title;

// 		if ( ! $cruise_photos = $this->cache->get($cache_file_id))
// 		{
// 			$data['cabins'] = $this->CruiseModel->getCruiseCabins($cruise_id);

// 			$data['photos'] = $this->CruiseModel->getCruisePhotos($cruise_id);

// 			$data['cruise'] = $this->CruiseModel->getCruiseById($cruise_id, FALSE);

// 			$cruise_photos = $this->load->view('cruises/cruise_photos', $data, TRUE);

// 			$this->cache->save($cache_file_id, $cruise_photos, $cache_time);
// 		}

		$data['cabins'] = $this->CruiseModel->getCruiseCabins($cruise_id);

		$data['photos'] = $this->CruiseModel->getCruisePhotos($cruise_id);

		$data['cruise'] = $this->CruiseModel->getCruiseById($cruise_id, FALSE);

		$cruise_photos = $this->load->view('cruises/cruise_photos', $data, TRUE);


		echo $cruise_photos;

	}

	function get_image_pop(){

		ob_start();

		$alt = $this->input->post("alt");

		$name = $this->input->post("name");

		$img = '<img alt="' . $alt . '" style="margin-right: 16px;" width="220" height="165" src="'.$this->config->item("cruise_220_165_path").$name.'">';

		echo $img;

		//ob_end_flush();
	}

	function get_cruise_properties_deckplans(){

		ob_start();

		$cruise_id = $this->input->post("cruise_id");

		$data['cruise_name'] = $this->input->post("cruise_name");

		$cruise_url_title = $this->input->post("cruise_url_title");

		$data['properties'] = $this->CruiseModel->getCruiseProperties($cruise_id);

		$data['members'] = $this->CruiseModel->getCruiseMembers($cruise_id);

		$data['member_properties'] = $this->CruiseModel->getCruiseMemberProperties($cruise_id);

		$properties_deckplans = $this->load->view('cruises/cruise_properties_deckplans', $data, TRUE);

		echo $properties_deckplans;
	}


	function get_image_list(){

		ob_start();

		$cruise_id = $this->input->post("cruise_id");

		$cruise_url_title = $this->input->post("cruise_url_title");

		$data['cabins'] = $this->CruiseModel->getCruiseCabins($cruise_id);

		$data['photos'] = $this->CruiseModel->getCruisePhotos($cruise_id);

		$data['cruise'] = $this->CruiseModel->getCruiseById($cruise_id, FALSE);

		$list_images = $this->load->view('cruises/cruise_list_images', $data, TRUE);

		echo $list_images;
	}

	function get_videos(){

		ob_start();

		$cruise_id = $this->input->post("cruise_id");

		$cruise_url_title = $this->input->post("cruise_url_title");

		$data['cruise_name'] = $this->input->post("cruise_name");

		$data['videos'] = $this->CruiseModel->getCruiseVideos($cruise_id);

		$video = $this->load->view('cruises/cruise_videos', $data, TRUE);

		echo $video;

	}


	function cruise_review(){

		$this->output->cache($this->config->item('cache_html'));

		$url_title = $this->uri->segment(1);

		// anti sql injection

		$url_title = anti_sql($url_title);

		$url_title = substr($url_title, strlen(CRUISE_REVIEWS)+1);
		$url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

		if ($url_title == 'Paradise-Luxury-Cruise'){
			$url_title = 'Paradise-Cruise';

			redirect(url_builder(CRUISE_REVIEWS, $url_title, true), 'location', 301);
		}

		$data = buildTourSearchCriteria();
		$search_criteria = $data['search_criteria'];

		$departure_date = date('Y-m-d', strtotime($search_criteria['departure_date']));

		$cruise = $this->_get_cruise_object($url_title);

		if ($cruise == ''){
			return redirect(site_url());
		}

		$cruise['tours'] = $this->_get_cruise_tours($cruise, $departure_date);

		if ($cruise['cruise_destination'] == 1){
			$this->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		} else {
			$this->session->set_userdata('MENU', MNU_HALONG_CRUISES);
		}

		$data['cruise'] = $cruise;

		$data = $this->_setFormData($data);

		$data = $this->_setReviewDataOld($data);

		$data['metas'] = site_metas(CRUISE_REVIEWS, $cruise);

		$data['navigation'] = createCruiseNavLink($cruise);


		$data['content'] = 'cruise';

		$data['tab_index'] = 2;


		$data['cruise_review_view'] = $this->load->view('reviews/customer_reviews', $data, TRUE);


		$cus_type = (int)$this->uri->segment(2, -2);

		if ($cus_type != -2) {
        	$data['cruise_review_canonical'] = '<link rel="canonical" href="' . site_url(url_builder(CRUISE_REVIEWS, $url_title, true)). '"/>';
        } else {

        	redirect_case_sensitive_url(CRUISE_REVIEWS, $cruise['url_title'], true);

        }

        $data = $this->get_stylesheet($data);

		$data['main'] = $this->load->view('cruises/cruise_detail_view', $data, TRUE);


		$this->load->view('template', $data);
	}

	function cruise_review_ajax() {

		$url_title = $this->uri->segment(3);

		// anti sql injection
		$url_title = anti_sql($url_title);

		if ($url_title == 'Paradise-Luxury-Cruise'){
			$url_title = 'Paradise-Cruise';

			redirect(url_builder(CRUISE_REVIEWS, $url_title, true), 'location', 301);
		}

		$cruise = $this->_get_cruise_object($url_title);

		if ($cruise == ''){
			exit;
		}

		$departure_date = $this->input->post('departure_date');

		$cruise['tours'] = $this->_get_cruise_tours($cruise, $departure_date);

		$data['cruise'] = $cruise;

		$data = $this->_setReviewDataOld($data, true);

		echo $this->load->view('reviews/customer_reviews', $data);
	}

	function _setReviewDataOld($data, $isAjax = false){

		$types = $this->config->item('score_types');

		$data['review_for'] = CRUISE;

		$data['score_types'] = $types[CRUISE];

		$data['customer_types'] = $this->config->item('customer_types');

		$data['review_rate_types'] = $this->config->item('review_rate_types');

		$data['customer_countries'] = $this->config->item('countries');

		$cruise = $data['cruise'];

		$tour_ids = $this->_getTourIds($cruise['tours']);

		// Get the language version ids of the $tour_ids
		$tour_ids = $this->TourModel->get_group_object_by_language($tour_ids, TOUR);


		$cus_type = ''; $review_rate = '';

		$segment = 3;
		if($isAjax) {
			$segment = 5;
			$filter_type = $this->uri->segment(4);
		} else {
			$filter_type = $this->uri->segment(2);
		}
		$data['cus_type_data'] = $filter_type;

		if (strpos($filter_type, "_") !== FALSE) {
			$e_array = explode("_", $filter_type);
			$review_rate = $e_array[0];
			$cus_type = $e_array[1];

			if(!is_numeric($cus_type) || $cus_type == '-1') $cus_type = '';
		} else if(!$isAjax) {
			$review_rate = $this->uri->segment(2);
		}

		// set data for pagination
		$data['total_rows'] = $this->TourModel->getNumReviews($tour_ids, $data['review_for'], $review_rate, $cus_type);

		$offset = $this->uri->segment($segment);

		// get customer reviews
		$data['reviews'] = $this->TourModel->getReviews($tour_ids, $data['review_for'], $review_rate
						, $this->config->item('per_page')
						, (int)$offset, $cus_type);

		$url_offset = $review_rate.'_'.$cus_type;
		if($review_rate == '') $url_offset = "-1";

		$url_paging = '';
		if($isAjax) {
			$url_paging = 'cruise_detail/cruise_review_ajax/'.$cruise['url_title'].'/'.$url_offset;
		} else {
			$url_paging = url_builder(CRUISE_REVIEWS, $data['cruise']['url_title'], true).'/'.$url_offset;
		}

		// initialize pagination
		$this->pagination->initialize(get_paging_config($data['total_rows'], $url_paging, $segment));

		$data['paging_text'] = get_paging_text($data['total_rows'], $offset);

		// get number reviews for each customer type
		$data['review_rate_numbes'] = $this->_getNumberReviewsEachType($tour_ids, $data['review_for'], $data['review_rate_types'], false, $cus_type);

		$data['cus_type_numbes'] = $this->_getNumberReviewsEachType($tour_ids, $data['review_for'], $data['customer_types'], true, $cus_type, $review_rate);

		$scores = $this->TourModel->getAllReviewScores($tour_ids, $data['review_for'], $review_rate, $cus_type);

		$data['average_scores'] = $this->_getAverageScores($data['score_types'], $scores);

		if ($cus_type == -1 || trim($cus_type) == ''){
			$data['total_score'] = $cruise['review_score'];
		} else {
			$data['total_score'] = $this->_getTotalScore($data['average_scores']);
		}

		$data['cruise'] = $cruise;

		// set socre by review

		foreach ($data['reviews'] as $key=>$value){

			$value['review_scores'] = set_scrore_type_by_review($value['id'], $data['score_types'], $scores);

			$data['reviews'][$key] = $value;
		}

		return $data;
	}


	function _getTourIds($tours){

		$ret = array();

		foreach ($tours as $tour){

			$ret[] = $tour['id'];

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


	function _setCategories($sections, $categories){

		foreach ($sections as $key => $section) {

			$c = array();

			foreach ($categories as $category) {

				if ($category['section_id'] == $section['id']){

					$c[] = $category;

				}
			}

			$section['categories'] = $c;

			$sections[$key] = $section;

		}

		return $sections;
	}

	function _setFormData($data){

		$data['durations'] = $this->config->item('program_duration');

		$data['stars'] = $this->config->item('cruise_star');

		$data['locations'] = $this->config->item('cruise_destinations');

		$data = $this->_get_similar_cruises($data);

		$data = $this->_get_other_cruises_of_partner($data);

		$data = load_faq_by_context('3', $data);

		$data['countries'] = $this->config->item('countries');

		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);

		/* if($data['cruise']['cruise_destination'] == 0){ // halong bay cruises
			$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		} */

		// Apply for both halong and mekong cruises ( toanlk - 27/08/2014 )
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);

		return $data;

	}



	function _get_cruise_facilities($cruise_id){

		$ret = array();

		$ret[CRUISE_FACILITY_GENERAL] = array();

		$ret[CRUISE_FACILITY_SERVICE] = array();

		$ret[CRUISE_FACILITY_ACTIVITY] = array();

		$ret[CRUISE_FACILITY_ACTIVITY_ON_REQUEST] = array();

		$cruise_facilities = $this->CruiseModel->getCruiseFacilities($cruise_id);

		foreach ($cruise_facilities as $value) {

			if($value['hotel_facility_type'] == 0){ // general facitility

				$ret[CRUISE_FACILITY_GENERAL][] = $value;

			}

			if($value['hotel_facility_type'] == 1){ // service facitility

				$ret[CRUISE_FACILITY_SERVICE][] = $value;

			}

			if($value['hotel_facility_type'] == 2){ // activity facitility

				$ret[CRUISE_FACILITY_ACTIVITY][] = $value;

			}

			if($value['hotel_facility_type'] == 3){ // activity facitility

				$ret[CRUISE_FACILITY_ACTIVITY_ON_REQUEST][] = $value;

			}

		}

		return $ret;

	}


	function _get_cruise_cabin_facilities($cruise_id){

		$ret = array();

		$cruise_cabin_facilities = $this->CruiseModel->getCruiseCabinFacilities($cruise_id);

		foreach ($cruise_cabin_facilities as $value) {

			$ret[$value['cruise_cabin_id']][] = $value;

		}

		return $ret;

	}

	function _getDepartureDates($str_dates){

		$ret = array();
		if ($str_dates != '' && strlen($str_dates) > 0){
			$today = date('Y-m-d');

			$date_arr = explode(',', $str_dates);

			usort($date_arr, array($this,"sortAsc"));

			//echo $date_arr;

			foreach ($date_arr as $value) {
				$year = date('Y', strtotime($value));

				$month = date('M', strtotime($value));

				$day = date('d', strtotime($value));

				$ret[$year][$month][$day] = $value;
			}

		}
		return $ret;
	}

	function sortAsc($d1, $d2){
		$d1 = strtotime($d1);
		$d2 = strtotime($d2);
		if($d1 == $d2) {
			return 0;
		}
		return ($d1 < $d2) ? -1 : 1;
	}

	function detail(){

		$url_title = $this->uri->segment(3);

		$cruise = $this->_get_cruise_object($url_title);

		if ($cruise == ''){
			return redirect(site_url());
		}

		$data['cruise'] = $cruise;


		$data = $this->_get_cruise_detail($data);

        $data = $this->get_stylesheet($data);

		$data['main'] = $this->load->view('cruises/cruise_more_detail_view', $data, TRUE);


		$this->load->view('popup_template', $data);
	}

	function download(){

		$this->load->helper('download');

		$file_name = $this->uri->segment(3);

		$data = file_get_contents('./'.$this->config->item('cruise_file_resource_path').$file_name); // Read the file's contents

		$name = $file_name;

		force_download($name, $data);
	}

	function _set_check_rate_data($data){

		$cruise = $data['cruise'];

		$cruise['tours'] = $this->_set_departure_info($cruise['tours']);

		$cruise['tours_js'] = $this->_get_cruise_tours_js($cruise['tours']);

		$data['cruise'] = $cruise;

		$action = $this->input->post('action_type');

		$data['action'] = $action;

		$search_criteria = $data['search_criteria'];

		$data['check_rates'] = get_check_rate_info($search_criteria);

		$data['cabin_types'] = $this->config->item('cabin_types');

		$data['unit_types'] = $this->config->item('unit_types');

		$data['cruise_cabins'] = $this->load->view('cruises/check_rates/cruise_cabins', $data, TRUE);

		if (empty($action)){

			$tour_id = '';

			if (count($cruise['tours']) > 0){

				$data['check_rates']['tours'] = $cruise['tours'][0]['id'];

				$tour_id = $cruise['tours'][0]['id'];
			}

			$selected_tour = $this->_get_selected_tour($cruise['tours'], $tour_id);

		} else {

			// click on check rate button
			$tour_id = $this->input->post('tours');

			$data['check_rates']['tours'] = $tour_id;


			$departure_date_check_rates = $this->input->post('departure_date_check_rates');

			if(!empty($departure_date_check_rates)) {

				$search_criteria = $data['search_criteria'];

				$search_criteria['departure_date'] = $departure_date_check_rates;

				$this->session->set_userdata("FE_tour_search_criteria", $search_criteria);
			}

			$selected_tour = $this->_get_selected_tour($cruise['tours'], $tour_id);

			if ($selected_tour !== FALSE){

				$tour_children_price = $this->TourModel->get_children_cabin_price($selected_tour['id']);

				$data['pax_accom_info'] = calculate_pax($data['check_rates']['adults'], $data['check_rates']['children'], $data['check_rates']['infants'], $tour_children_price);

				$data['tour_children_price'] = $tour_children_price;

				$data['children_rate'] = $this->TourModel->get_children_rate($selected_tour['id']);

				$selected_tour = $this->TourModel->get_tour_by_url_title($selected_tour['url_title'], $data['search_criteria']['departure_date'],$tour_id);

				$selected_tour['tour_itinerary'] = $this->TourModel->get_tour_detail_itinerary($selected_tour['id']);

				$selected_tour = $this->_set_departure_info_4_tour($selected_tour);

				$data['selected_tour'] = $selected_tour;


				$data['discount_together'] = $this->_get_discount_of_tour($data['check_rates']['adults'], $data['check_rates']['children'], $selected_tour, $data['children_rate']);

				$data = $this->_load_tour_recommendation($data);

				$data['price_include_exclude'] = $this->load->view('tours/price_include_exclude', $data, TRUE);

				if(!is_private_tour($selected_tour) && $cruise['num_cabin'] > 0){

					$data['cabin_rates'] = $this->load->view('cruises/check_rates/cabin_rates', $data, TRUE);

				} else {

					$data['action'] = 'check_rate_private';

					$selected_tour['num_cabin'] = $data['cruise']['num_cabin'];

					//$data['num_pax_calculated'] = get_pax_calculated($data['check_rates']['adults'], $data['check_rates']['children'], $selected_tour);

					$data['selected_tour'] = $selected_tour;

					$data['cabin_rates'] = $this->load->view('cruises/check_rates/private_cruise_rates', $data, TRUE);

				}

			} else {

				$data['cruise_cabins'] = $this->load->view('cruises/check_rates/cruise_cabins', $data, TRUE);

			}
		}


		if ($this->input->post('object_change') != ''){
			$data['object_change'] = $this->input->post('object_change');
		}

		$data['selected_tour'] = $selected_tour;

		$data['cruise_url'] = url_builder(CRUISE_DETAIL, url_title($cruise['name']), TRUE);

		$it_data['tour'] = $selected_tour;

		$it_data['cruise'] = $cruise;

		if(!empty($selected_tour['tour_itinerary'])) {
			$routes = $this->_restructure_itineraries($selected_tour['tour_itinerary']);
			$it_data['routes'] = $routes;
		}

		$data['tour_itinerary'] = $this->load->view('tours/tour_detail_itinerary', $it_data, TRUE);

		$data['cruise_itineraries'] = $this->load->view('cruises/cruise_itineraries', $data, TRUE);

		// check rate form
		$data['check_rate_form'] = $this->load->view('cruises/check_rates/check_rate_form', $data, TRUE);

		$data['cruise_tab_contents'] = $this->load->view('cruises/cruise_tab_contents', $data, TRUE);

		return $data;
	}

	function _get_selected_tour($tours, $tour_id){
		foreach ($tours as $value){

			if ($tour_id == $value['id']){

				return $value;

			}
		}

		return FALSE;

	}

	function _get_discount_of_tour($adults, $children, $tour, $children_rate){

		$service_id = $tour['id'];

		$service_type = CRUISE;

		$is_main_service = $this->BookingModel->is_main_service($tour['main_destination_id'], $service_type);

		$discount_coefficient = $adults + ($children * $children_rate / 100);

		$normal_discount = $tour['price']['discount'];

		$discount_together = get_discount_together_v2($service_id, $service_type, $discount_coefficient, $is_main_service, $normal_discount);

		return $discount_together;
	}

	function _set_departure_info($tours){

		foreach ($tours as $key=>$value){

			$value['str_departure'] = '';

			$value['up_stream'] = '';

			$value['down_stream'] = '';

			if(!empty($value['departure'])){

				$str_departure = getDepartureDate($value['departure']);

				if(!empty($str_departure)){

					$value['str_departure'] = $str_departure;

					$is_round_trip = is_roundtrip($value['departure']);

					if (!$is_round_trip){

						$up_stream = json_encode(get_departure_date($value['departure'], 'UPSTREAM', 0, '', 'j-n-Y'));

						$down_stream = json_encode(get_departure_date($value['departure'], 'DOWNSTREAM', 0, '', 'j-n-Y'));

						$value['up_stream'] = $up_stream;

						$value['down_stream'] = $down_stream;
					}

				}

			}

			$tours[$key] = $value;
		}

		return $tours;

	}

	function _set_departure_info_4_tour($tour){


		$tour['str_departure'] = '';

		$tour['up_stream'] = '';

		$tour['down_stream'] = '';

		if(!empty($tour['departure'])){

			$str_departure = getDepartureDate($tour['departure']);

			if(!empty($str_departure)){

				$tour['str_departure'] = $str_departure;

				$is_round_trip = is_roundtrip($tour['departure']);

				if (!$is_round_trip){

					$up_stream = json_encode(get_departure_date($tour['departure'], 'UPSTREAM', 0, '', 'j-n-Y'));

					$down_stream = json_encode(get_departure_date($tour['departure'], 'DOWNSTREAM', 0, '', 'j-n-Y'));

					$tour['up_stream'] = $up_stream;

					$tour['down_stream'] = $down_stream;
				}

			}

		}


		return $tour;
	}

	function get_tour_itinerary(){

		ob_start();

		$tour_id = $this->input->post("tour_id");

		$cruise_id = $this->input->post("cruise_id");

		$cruise_name = $this->input->post("cruise_name");

		$is_halong_cruise = $this->input->post("is_halong_cruise");

		$cruise['id'] = $cruise_id;

		$cruise['name'] = $cruise_name;

		$cruise['cruise_destination'] = $is_halong_cruise? 0 : 1;

		$tours = $this->_get_cruise_tours($cruise, '');

		$selected_tour = '';

		foreach ($tours as $value){

			if ($value['id'] == $tour_id){

				$selected_tour = $value;

				break;
			}
		}

		if ($selected_tour != ''){

			$data['tour'] = $selected_tour;

			$data['cruise'] = $cruise;


			if(!empty($selected_tour['tour_itinerary'])) {
				$routes = $this->_restructure_itineraries($selected_tour['tour_itinerary']);
				$data['routes'] = $routes;
			}


			$tour_itinerary = $this->load->view('tours/tour_detail_itinerary', $data, TRUE);

			echo $tour_itinerary;

		} else {

			echo '';
		}

	}

	function _get_cruise_tours_js($tours){

		$ret = array();

		if (count($tours) > 0){

			foreach ($tours as $value){

				$item['id'] = $value['id'];

				$item['str_departure'] = $value['str_departure'];

				$item['up_stream'] = $value['up_stream'];

				$item['down_stream'] = $value['down_stream'];

				$item['duration'] = $value['duration'];

				$ret[] = $item;
			}

		}

		return $ret;

	}

	function _load_tour_recommendation($data){

		$destination_id = $data['selected_tour']['main_destination_id'];

		$service_id = CRUISE;

		$search_criteria = $data['search_criteria'];

		$data['atts'] = get_popup_config('extra_detail');

		$data['tour'] = $data['selected_tour'];

		$data['parent_id'] = -1;


		$current_item_info['service_id'] = $data['selected_tour']['id'];

		$current_item_info['service_type'] = $service_id;

		$current_item_info['url_title'] = $data['selected_tour']['url_title'];

		$current_item_info['normal_discount'] = $data['discount_together']['normal_discount'];

		$current_item_info['is_main_service'] = $data['discount_together']['is_main_service'];

		$current_item_info['destination_id'] = $destination_id;

		$current_item_info['is_booked_it'] = false;

		$data['current_item_info'] = $current_item_info;

		$data['recommendations'] = $this->BookingModel->get_recommendations($current_item_info, $search_criteria['departure_date']);

		$data['recommendation_before_book_it'] = $this->load->view('common/recommendation_before_book_it', $data, TRUE);

		return $data;
	}

	/*
	 * See cruise overview - in Halongbay Cruise & Mekong River Cruise Pages
	 */
	function see_overview(){

		ob_start();

		$cruise_id = $this->input->post('cruise_id');

		$departure_date = $this->input->post('departure_date');

		$cruise_name = $this->input->post('cruise_name');

		$cruise = $this->CruiseModel->get_cruise_overview($cruise_id, $departure_date, $cruise_name);

		$data['cruise'] = $cruise;

		$data['departure_date'] = $departure_date;

		$data['cruise_name'] = $cruise_name;

		$cruise_overview = $this->load->view('cruises/cruise_overview', $data, TRUE);

		echo $cruise_overview;
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

    function get_stylesheet($data) {

        $data['inc_css'] = get_static_resources('cruise.min.05022014.css');

        return $data;
    }
}
?>