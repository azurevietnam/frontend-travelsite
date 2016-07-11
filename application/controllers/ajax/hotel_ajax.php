<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hotel_Ajax extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource', 'hotel', 'hotel_rate', 'review', 'text'));

       	$this->load->model(array('Hotel_Model', 'HotelModel', 'Destination_Model', 'BookingModel'));

       	$this->load->language(array('destination', 'hotel'));
		// for test only
		//$this->output->enable_profiler(TRUE);
	}


	/**
	 * Hotel Destination Autocomplete Remote Loading
	 *
	 * @author Khuyenpv
	 * @since 05.04.2015
	 */
	function hotel_des_auto_remote($name){
		//sleep(10);
		$this->output->set_content_type('application/json');

		$prefetch_types = array(DESTINATION_TYPE_CITY, DESTINATION_TYPE_AREA);

		$destinations = $this->Destination_Model->search_des_auto($prefetch_types, $name, false, HOTEL);

		$return_data = set_color_des($destinations);

		$hotels = $this->Hotel_Model->search_hotel_auto($name);
		
		foreach($hotels as $key=>$value){
			$value['is_hotel'] = 1; // set flag indicating Hotel data in Autocomplete
			$value['destination_type'] = lang('lbl_hotel');
			$value['color'] = '#fd6565';
			$return_data[] = $value; // add to destinations array;
		}
		
		$this->output->set_output(json_encode($return_data));
		
	}

	/**
	 * Hotel Destination Autocomplete Prefetch Loading
	 *
	 * @author Khuyenpv
	 * @since 05.04.2015
	 */
	function hotel_des_auto_prefetch(){
		//sleep(10);
		$this->output->set_content_type('application/json');

		$prefetch_types = array(DESTINATION_TYPE_CITY, DESTINATION_TYPE_AREA);

		$destinations = $this->Destination_Model->search_des_auto($prefetch_types, '', true, HOTEL);

		$return_data = set_color_des($destinations);
		
		$this->output->set_output(json_encode($return_data));
	}


	/**
	 * Search More Hotel Recommendation
	 * Using in 'Service Recommendation' module
	 *
	 * @author Khuyenpv
	 * @since 04.04.2015
	 */
	function recommend_more_hotel(){

		$this->load->helper(array('tour_rate', 'recommend'));
		$this->load->library('pagination');

		$destination_id = $this->input->post('destination_id');

		$service_type = $this->input->post('service_type');

		$start_date = $this->input->post('start_date');

		$block_id = $this->input->post('block_id');


		$search_params = get_hotel_quick_search_params($block_id);

		if(empty($search_params['destination'])){

			$search_params['destination_id'] = $destination_id;

			$destination = $this->Destination_Model->get_destination($destination_id);

			$search_params['destination'] = $destination['name'];

		}

		$quick_search = load_hotel_quick_search($block_id, $search_params);

		// current booking item
		$current_item_info = get_current_item_info_post_data();

		$data['recommend_form_data'] = load_recommend_form_data($destination_id, $service_type, $block_id, $current_item_info, $quick_search);

		$data['block_id'] = $block_id;


		$paging_cnf['per_page'] = 5;
		$paging_cnf['num_links'] = 5;

		$cnt_total = $this->Hotel_Model->count_recommend_more_hotels($search_params);

		$offset = (int)$this->uri->segment(2);

		$hotels = $this->Hotel_Model->recommend_more_hotels($search_params, $start_date, $offset, $paging_cnf['per_page']);


		$paging_config = create_paging_config($cnt_total, '/recommend-more-hotel/', 2, $paging_cnf);
		// initialize pagination
		$this->pagination->initialize($paging_config);

		$paging_info['paging_text'] = create_paging_text($cnt_total, $offset, $paging_cnf);

		$paging_info['paging_links'] = $this->pagination->create_links();

		$data['paging_info'] = $paging_info;

		$hotels = set_disount_together_for_services($hotels, $current_item_info, true);

		$data['services'] = $hotels;

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

		$hotel = $this->Hotel_Model->get_hotel_detail($url_title);

		// redirect to homepage if cannot find the tour
		if (empty($hotel)) {
			echo '';exit();
		}

		$data['form_action'] = '/hotel-extra-booking/'.$url_title.'/'.$parent_id.'/';
		$data['parent_id'] = $parent_id;

		$data = load_hotel_check_rate_form($data, $is_mobile, $hotel);

		$data = load_hotel_rate_table($data, $is_mobile, $hotel);

		echo load_view('hotels/booking/extra_booking', $data, $is_mobile);

	}

	/**
	 * Ajax functions for Hotel-Overview
	 *
	 * @author Khuyenpv
	 * @since 14.04.2015
	 */
	function see_overview(){

		$is_mobile = is_mobile();

		$view_data = array();



		$url_title = $this->input->post('url_title');

		$hotel = $this->Hotel_Model->get_hotel_detail($url_title);

		// get hotel_price price_from & promotion
		$start_date = get_current_hotel_start_date();
		$end_date = date(DATE_FORMAT_STANDARD, strtotime($start_date . " +1 day"));
		$hotels = array($hotel);
		$hotels = $this->HotelModel->get_hotels_price_optimize($hotels, $start_date, $end_date);
		$hotel = $hotels[0];

		$price['price_origin'] = $hotel['price'];
		$price['price_from'] = $hotel['promotion_price'];
		$hotel['price'] = $price;

		$special_offers = '';

		if(!empty($hotel['deal_info'])){
			$deal_info = $hotel['deal_info'];

			$offer_name = $deal_info['name'];

			$offer_note = $hotel['offer_note'];

			$offer_cond = get_promotion_condition_text($deal_info);

			$special_offers = load_promotion_popup_4_old_storing($is_mobile, $offer_name, $offer_note, $offer_cond, $hotel['id']);

			$hotel['special_offers'] = $special_offers;
		}

		$is_free_visa = $this->HotelModel->is_free_visa($hotel['id']);

		$view_data['hotel'] = $hotel;

		$room_types = $this->Hotel_Model->get_hotel_rooms($hotel['id']);

		$room_types  = $this->Hotel_Model->get_hotel_room_facilities($room_types);

		$photos = $this->Hotel_Model->get_hotel_photos($hotel['id']);

		// add room-photo to list of photos
		foreach ($room_types as $room){
			$photo['name'] = $room['picture'];
			$photo['caption'] = $room['name'];
			$photos[] = $photo;
		}

		$view_data = load_photo_slider($view_data, $is_mobile, $photos, PHOTO_FOLDER_HOTEL, $is_free_visa);


		$view_data['room_types'] = $room_types;

		$overview['title'] = $hotel['name']. ' <span class="icon '.get_icon_star($hotel['star'], true).'"></span>';
		$overview['content'] = load_view('hotels/common/hotel_overview', $view_data, $is_mobile);

		echo json_encode($overview);
	}

	/**
	  * function_container
	  *
	  * @author toanlk
	  * @since  Jun 23, 2015
	  */
    function get_hotel_price_from()
    {
        $hotel_ids = $this->input->post('hotel-ids');

        $start_date = get_current_hotel_start_date();

        $prices = $this->Hotel_Model->get_hotel_price_from_ajax($hotel_ids, $start_date);

        echo json_encode($prices);
    }

    function get_more_hotel_list_destination(){

        $destination_id  = $this->input->post('destination_id');

        $data['destination'] = $this->Destination_Model->get_destination($destination_id);

        $offset  = $this->input->post('offset');

        $is_mobile = is_mobile();

        $hotels = $this->Hotel_Model->get_hotels_by_destination($destination_id, 10, $offset);

        $data = load_list_hotels($data, $is_mobile, $hotels, false, '', true);

        echo $data['list_hotels'];
    }

    /**
     * Get the lasted Hotel Search
     *
     * @author TinVM
     * @since  July 20, 2015
     */
    function get_lasted_hotel_search(){
        $lasted_search = get_last_search(HOTEL_SEARCH_HISTORY);

        echo json_encode($lasted_search);
    }
}

?>