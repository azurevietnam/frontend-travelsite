<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Hotel_Booking extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
		
       	$this->load->helper(array('hotel', 'hotel_rate', 'hotel_booking', 'tour_booking','tour_rate', 'destination','faq', 'hotline', 'recommend', 'shopping_cart'));
       	
       	$this->load->model(array('Hotel_Model', 'HotelModel', 'Destination_Model', 'BookingModel','Tour_Model'));
       	
       	$this->load->language('hotel');
       	
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index($url_title)
    {	
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        // set current menu
        set_current_menu(MNU_HOTELS);
         
        $hotel = $this->Hotel_Model->get_hotel_detail($url_title);

    	// redirect to homepage if cannot find the tour
    	if (empty($hotel)) {
    	    redirect(get_page_url(HOME_PAGE));
    	}

    	$data['hotel'] = $hotel;
    	
    	$data['destination'] = $this->Destination_Model->get_destination($hotel['destination_id']);
    	
    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(HOTEL_BOOKING_PAGE, $hotel);
    	
    	$data['page_theme'] = get_page_theme(HOTEL_BOOKING_PAGE, $is_mobile);
    	 
    	$data = get_page_navigation($data, $is_mobile, HOTEL_BOOKING_PAGE);
    	 
    	// load how-to-book a trip
    	$data = load_how_to_book_trip($data, $is_mobile);
    	
    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HOTEL_BOOKING);
    	
    	// load booking step: current step = 2
    	$data = load_booking_step($data, $is_mobile, 2);
    	 
    	// load tour extra-services
    	$data = load_hotel_extra_services($data, $is_mobile, $hotel);
    	
    	$current_booking_item = $data['current_booking_item']; // this data set from function: load_tour_extra_services
    	 
    	if(!empty($current_booking_item)){
    	     
    	    // load service recommendation
    	    $current_item_info['service_id'] = $hotel['id'];
    	
    	    $current_item_info['service_type'] = HOTEL;
    	
    	    $current_item_info['url_title'] = $hotel['url_title'];
    	
    	    $current_item_info['normal_discount'] = 0; // don't use this data
    	
    	    $current_item_info['is_main_service'] = false; // don't use this data
    	
    	    $current_item_info['destination_id'] = $hotel['destination_id'];
    	
    	    $current_item_info['is_booked_it'] = true;
    	
    	    $current_item_info['parent_id'] = $current_booking_item['rowid']; // CART ROW-ID of the current selected item
    	
    	    $current_item_info['start_date'] = $current_booking_item['start_date'];
    	
    	    $data = load_service_recommendation($data, $is_mobile, $current_item_info);
    	     
    	} else {
    	    redirect(get_page_url(HOTEL_DETAIL_PAGE, $hotel));
    	}
    	
    	render_view('hotels/booking/hotel_booking', $data, $is_mobile);
    }
    
    function book_it($url_title){
        
    	// check if the current device is Mobile or Not
    	$parent_id = $this->input->get('parent_id');
    	
    	$hotel = $this->Hotel_Model->get_hotel_detail($url_title);
    	
    	$check_rates = get_hotel_check_rate_from_url($hotel);
    	
    	// hotel start-date & end-date
    	$start_date = !empty($check_rates['start_date']) ? $check_rates['start_date'] : '';
    	$end_date = '';
    	if($start_date != '' && $check_rates['night_nr'] > 0){
    		$end_date = date(DATE_FORMAT_STANDARD, strtotime($start_date. ' +'.$check_rates['night_nr'].' days'));
    	}
    	
    	$staying_dates = get_date_arr($start_date, $end_date);
    	
    	
    	$room_types = $this->HotelModel->getRoomTypes($hotel['id'], $start_date, $end_date);
    	
    	$total_price = 0;
    	
    	$total_promotion_price = 0;
    	
    	$rooms = 0;
    	
    	foreach ($room_types as $key => $value) {
    		$input_name = "nr_room_type_" . $value['id'];
    	
    		$nr_room = $this->input->get($input_name);
    	
    	
    		$extra_bed_name = "nr_extra_bed_" . $value['id'];
    		$nr_extra_bed = $this->input->get($extra_bed_name);
    	
    		if ($nr_extra_bed > $nr_room){
    			$nr_extra_bed = $nr_room;
    		}
    	
    		$value['nr_room'] = $nr_room;
    	
    		$value['nr_extra_bed'] = $nr_extra_bed;
    	
    		$room_types[$key] = $value;
    	
    		$total_promotion_price = $nr_room * $value['price']['promotion_price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_promotion_price;
    	
    		$total_price = $nr_room * $value['price']['price'] + $nr_extra_bed * $value['price']['extra_bed_price'] + $total_price;
    		
    		$rooms += $nr_room;
    	}
    	
    	$hotel['room_types'] = $room_types;
    	
    	$nights = $check_rates['night_nr'];
    	
    	$discount_together = get_hotel_discount_together($rooms, $nights, $start_date, $hotel);
    	
    	$is_free_visa = $this->HotelModel->is_free_visa($hotel['id']);
    	
    	$booking_rowid = insert_hotel_room_to_cart($hotel, $room_types, $start_date, $end_date, $check_rates, $is_free_visa, $discount_together, $parent_id);
    	
    	$is_ajax = $this->input->is_ajax_request();
    	 
    	if($is_ajax){
    	
    		// do nothing
    	} else {
    	
    		$this->session->set_flashdata('curent_booking_rowid', $booking_rowid);
    		redirect(get_page_url(HOTEL_BOOKING_PAGE, $hotel));
    	}
    	
    }
    
    /**
      * add_cart
      *
      * @author toanlk
      * @since  Jun 24, 2015
      */
    function add_cart($url_title, $parent_id)
    {
        $data['hotel'] = $this->Hotel_Model->get_hotel_detail($url_title);
        
        $booking_items = get_hotel_booking_items($data['hotel']['id'], $parent_id);
        
        foreach ($booking_items as $booking_item)
        {
            
            $parent_rowid = $booking_item['rowid'];
            
            if (isset($booking_item['optional_services']['transfer_services']) &&
                 count($booking_item['optional_services']['transfer_services']) > 0)
            {
                
                foreach ($booking_item['optional_services']['transfer_services'] as $transfer)
                {
                    
                    $name = $transfer['name'];
                    
                    $unit = $transfer['unit'];
                    
                    $rate = $transfer['rate'];
                    
                    $amount = $transfer['total_price'];
                    
                    $service_id = $transfer['optional_service_id'];
                    
                    $reservation_type = RESERVATION_TYPE_TRANSFER;
                    
                    $selected = $this->input->post($parent_rowid . '_' . $service_id . '_selected');
                    
                    $partner_id = '';
                    // shuttle bus
                    if ($transfer['unit_type'] == 1)
                    {
                        $partner_id = $booking_item['partner_id'];
                    }
                    
                    add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $transfer['description'], $unit, 
                        $rate, $amount, '', $partner_id);
                }
            }
            
            if (isset($booking_item['optional_services']['extra_services']) &&
                 count($booking_item['optional_services']['extra_services']) > 0)
            {
                
                foreach ($booking_item['optional_services']['extra_services'] as $extra)
                {
                    
                    $name = $extra['name'];
                    
                    $unit = $extra['unit'];
                    
                    $rate = $extra['rate'];
                    
                    $amount = $extra['total_price'];
                    
                    $service_id = $extra['optional_service_id'];
                    
                    $reservation_type = RESERVATION_TYPE_OTHER;
                    
                    $unit_change = $this->input->post($parent_rowid . '_' . $service_id . '_unit');
                    
                    $unit_text = '';
                    
                    if (! empty($unit_change))
                    {
                        
                        $unit = $unit_change;
                        
                        $amount = $extra['price'] * $unit;
                        
                        $unit_text = ' pax';
                    }
                    
                    $partner_id = '';
                    
                    if (strpos($name, 'Visa') === FALSE)
                    {
                        $partner_id = $booking_item['partner_id'];
                    }
                    else
                    {
                        // echo 'Visa here';exit();
                    }
                    
                    $selected = $this->input->post($parent_rowid . '_' . $service_id . '_selected');
                    
                    add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $extra['description'], $unit, $rate, $amount, $unit_text, $partner_id);
                }
            }
            
            $this->cart->update_item($booking_item['rowid'], 'is_optional_service_selection', true);
            
            $this->cart->update_item($parent_rowid, 'temp_optional_services', array());
        }
        
        redirect(get_page_url(MY_BOOKING_PAGE));
    }
}
?>