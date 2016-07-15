<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotels extends CI_Controller {

	public function __construct()
    {

       	parent::__construct();

		$this->load->language(array('hotel','faq'));
		$this->load->model(array('HotelModel','FaqModel', 'BestDealModel'));
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->helper('cookie');

		$this->load->driver('cache', array('adapter' => 'file'));
		//$this->output->enable_profiler(TRUE);
	}

	function index()
	{

		$this->output->cache($this->config->item('cache_html'));

		$this->session->set_userdata('MENU', MNU_HOTELS);
		$data['metas'] = site_metas(HOTEL_HOME);
		$data['navigation'] = $this->_createNavigation(HOTEL_HOME, $data);

		$data['hotel_stars'] = $this->HotelModel->hotel_stars;

		$data['hotel_nights'] = $this->HotelModel->hotel_nights;

		redirect_case_sensitive_url('', 'hotels/', false);
		/*
		 * get list hotel name for seach autocomplete
		 */

		$data = load_hotel_search_autocomplete($data);


		$search_criteria = buildHotelSearchCriteria();

		$data['search_criteria'] = $search_criteria;


		$data = $this->_get_hotels_by_top_destinaions($data);

		$data = load_faq_by_context('11', $data);

		$data = load_hotel_top_destination($data);

		$data = $this->load_hotel_destinations($data);

		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);


		$data['search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);

		//$data['inc_css'] = '<link rel="stylesheet" type="text/css" href="/css/hotel.min.19072013.css" />';
		$data['inc_css'] = get_static_resources('hotel.min.03102013.css');

		$data['main'] = $this->load->view('hotels/hotel_main_view', $data, TRUE);

		$this->load->view('template', $data);
	}

	function _get_hotels_by_top_destinaions($data){


		/*
		 * Using i18n, should't use cache element
		 *
		$cache_time = $this->config->item('cache_day');

		$cache_file_id = 'hotels_in_top_destinations';

		if ( ! $hotels_in_top_destinations = $this->cache->get($cache_file_id))
		{

			$hotels_in_top_destinations = $this->HotelModel->get_hotels_by_top_destinations();

			$this->cache->save($cache_file_id, $hotels_in_top_destinations, $cache_time);

		}*/


		$hotels_in_top_destinations = $this->HotelModel->get_hotels_by_top_destinations();

		$data['top_destinations'] = $hotels_in_top_destinations;

		$hotels_in_top_destination_view = $this->load->view('hotels/hotel_best_deal', $data, TRUE);

		$data['best_deal_view'] = $hotels_in_top_destination_view;

		return $data;
	}

	function get_hot_deals(){

		ob_start();

		/*
		 * Using i18n, should't use cache element
		 */
// 		$cache_time = $this->config->item('cache_hot_deal_time');

// 		$cache_file_id = 'hotel_hot_deals';

// 		if ( ! $hotel_slide_view = $this->cache->get($cache_file_id))
// 		{
// 			$data['hotel_hot_deals'] = $this->HotelModel->get_hotels_by_hot_deals();

// 			$hotel_slide_view = $this->load->view('hotels/hotel_slide_shows', $data, TRUE);

// 			$this->cache->save($cache_file_id, $hotel_slide_view, $cache_time);
// 		}


		$data['hotel_hot_deals'] = $this->HotelModel->get_hotels_by_hot_deals();

		$hotel_slide_view = $this->load->view('hotels/hotel_slide_shows', $data, TRUE);
		//ob_end_clean();

		echo $hotel_slide_view;

	}

	function get_hotel_from_prices(){

		$ret = array();

		$arrival_date = $this->input->post('arrival_date');

		$hotel_ids = $this->input->post('hotel_ids');

		$hotel_ids = explode("-", $hotel_ids);

		$arrival_date = date("d-m-Y", strtotime($arrival_date));

		$next_date = date("d-m-Y", strtotime($arrival_date . " +1 day"));

		$hotels = array();
		foreach($hotel_ids as $hotel_id){
			$hotel['id'] = $hotel_id;
			$hotels[] = $hotel;
		}

		$hotels = $this->HotelModel->get_hotels_price_optimize($hotels, $arrival_date, $next_date);

		foreach ($hotels as $hotel){

			$hotel_item['id'] = $hotel['id'];

			$hotel_item['price'] = $hotel['price'];

                $hotel_item['promotion_price'] = $hotel['promotion_price'];

			$hotel_item['is_promotion'] = $hotel_item['promotion_price'] != $hotel_item['price'];

			$hotel_item['price'] = CURRENCY_SYMBOL.number_format($hotel_item['price'], CURRENCY_DECIMAL);

			$hotel_item['promotion_price'] = CURRENCY_SYMBOL.number_format($hotel_item['promotion_price'], CURRENCY_DECIMAL);

			$hotel_item['offer_note'] = $hotel['offer_note'];

			$hotel_item['offer_note_arr'] = explode("\n", $hotel_item['offer_note']);


			$deal_info = !empty($hotel['deal_info']) ? $hotel['deal_info'] : FALSE;

			$deal_content = $deal_info !== FALSE ? get_promotion_condition_text($deal_info) : '';

			$deal_title = $deal_info !== FALSE ? '<span class="special" style="font-size: 13px;">'.htmlspecialchars($deal_info['name'], ENT_QUOTES).'</span>' : '';

			$promotion_id = $deal_info !== FALSE ? $deal_info['promotion_id'] : '';

			$is_hot_deal = $deal_info !== FALSE ? $deal_info['is_hot_deals'] : 0;


			$hotel_item['deal_title'] = $deal_title;

			$hotel_item['deal_content'] = $deal_content;

			$hotel_item['promotion_id'] = $promotion_id;

			$hotel_item['is_hot_deal'] = $is_hot_deal;

			$ret[] = $hotel_item;

		}

		echo json_encode($ret);

	}

	function _getFaq($data){

		$data['faq_topic'] = '11';

		$data['faq_questions'] = $this->FaqModel->getFaqQuestions($data['faq_topic']);

		return $data;
	}

	function _getViewedHotel($data){

		$my_viewed_hotel_ids = get_cookie('my_viewed_hotels');
		//echo $my_viewed_hotel_ids.'test';
		if ($my_viewed_hotel_ids != ''){

			$ids = explode(',', $my_viewed_hotel_ids);

			$my_viewed_hotels = $this->HotelModel->getViewedHotels($ids);

			$data['my_viewed_hotels'] = $my_viewed_hotels;

		} else {
			$data['my_viewed_hotels'] = array();
		}

		return $data;
	}


	function _createNavigation($action, $data) {
		switch ($action) {
			case HOTEL_HOME:
				return createHotelHomeNavLink(true);
			case HOTEL_SEARCH:
				return createHotelSearchNavLink(true);
			case HOTEL_DESTINATION:
				return createHotelDesNavLink(true, $data['des']);
			default:
				$data['name'] = $data['page_header'];
				return createTourStyleNavLink(true, $data);
		}

		return '';
	}

	function _getAllCitiesOfVietnam($allCities){
		$ret = array();
		$ret['north'] = array();
		$ret['middle'] = array();
		$ret['south'] = array();

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

	function load_hotel_destinations($data){

		$data['hotel_destinations'] = $this->HotelModel->get_hotel_destinations();

		$data['hotel_destination_view'] = $this->load->view('hotels/hotel_destinations', $data, TRUE);


		return $data;
	}
}
?>