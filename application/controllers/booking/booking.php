<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Booking extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	
	
		$this->load->helper(array('basic', 'resource','contact', 'booking', 'shopping_cart', 'tour', 'tour_search','faq', 'hotline','recommend'));
	
		$this->load->model(array('BookingModel', 'Destination_Model', 'Faq_Model'));
	
		$this->load->language(array('mybooking'));
		
		$this->load->library('Cart');
	
		// for test only
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{
		
		$is_mobile = is_mobile();
		
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(MY_BOOKING_PAGE);
		
		$data['page_theme'] = get_page_theme(MY_BOOKING_PAGE, $is_mobile);
		 
		$data = get_page_navigation($data, $is_mobile, MY_BOOKING_PAGE);
		 
		// load the tour search form
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , TRUE);
		 
		// load how-to-book a trip
		$data = load_how_to_book_trip($data, $is_mobile);
		 
		// load fag by page
		$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_MY_BOOKING);
		 
		$data = load_booking_step($data, $is_mobile, 3);
		
		
		$action = $this->input->post('action');
		
		// reset discount
		
		reset_discount();
		
		
		if($action == 'delete'){
				
			$rowid = $this->input->post('rowid');
				
			remove_booking_item($rowid);
		}
		
		if($action == 'empty'){
				
			$this->cart->destroy();
				
			// clear promo code
			clear_promode_code();
		}
		
		
		$my_bookings = get_my_booking();
		
		usort($my_bookings, 'sort_booking_date_asc');
		
		$booking_info  = calculate_booking_info($my_bookings, true);
		
		$data = load_my_booking_table($data, $is_mobile, $my_bookings, $booking_info);
		
		$data['my_bookings'] = $my_bookings;
		
		$current_item_info = array();
		$departure_date = get_current_tour_departure_date();
		$data = load_service_recommendation($data, $is_mobile, $current_item_info, $departure_date);
		
		render_view('booking/my_booking', $data, $is_mobile);
		
	}
	
	function submit(){
		
		$is_mobile = is_mobile();
		
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(SUBMIT_BOOKING_PAGE);
		
		$data['page_theme'] = get_page_theme(SUBMIT_BOOKING_PAGE, $is_mobile);
			
		$data = get_page_navigation($data, $is_mobile, MY_BOOKING_PAGE);
			
		// load the tour search form
		$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, array(), $display_mode_form , true);
			
		// load how-to-book a trip
		$data = load_how_to_book_trip($data, $is_mobile);
			
		// load fag by page
		$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_MY_BOOKING);
			
		$data = load_booking_step($data, $is_mobile, 4);
	
		
		$my_bookings = get_my_booking();
		usort($my_bookings, 'sort_booking_date_asc');
		
		$data['my_bookings'] = $my_bookings;
		
		$booking_info  = calculate_booking_info($my_bookings, true);
		
		$data = load_my_booking_table($data, $is_mobile, $my_bookings, $booking_info, false);
		
		$data = load_contact_form($data, $is_mobile, 'save_my_booking');
		
		render_view('booking/submit_booking', $data, $is_mobile);
		
	}
}
?>