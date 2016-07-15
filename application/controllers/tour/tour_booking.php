<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Tour Details Page
  *  
  *  include cruise tour and land tour
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Tour_Booking extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
       	
       	$this->load->helper(array('basic', 'resource', 'tour', 'tour_rate', 'tour_booking','destination','faq', 'hotline','recommend','shopping_cart','review'));
       	
       	$this->load->model(array('Tour_Model', 'Destination_Model', 'BookingModel','Hotel_Model'));
       	
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index($url_title)
    {	
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();
    	
    	$tour = $this->Tour_Model->get_tour_detail($url_title);
    	
    	// redirect to homepage if cannot find the tour
    	if (empty($tour)) {
    		redirect(get_page_url(HOME_PAGE));
    	}
    	
    	$data['tour'] = $tour;
    	
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
    	$data['page_meta'] = get_page_meta(TOUR_BOOKING_PAGE, $tour);
    	 
    	$data['page_theme'] = get_page_theme(TOUR_BOOKING_PAGE, $is_mobile);
    	
    	$data = get_page_navigation($data, $is_mobile, TOUR_BOOKING_PAGE);
   
    	// load how-to-book a trip
    	$data = load_how_to_book_trip($data, $is_mobile);
    	
    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_BOOKING);
    	
    	// load booking step: current step = 2
    	$data = load_booking_step($data, $is_mobile, 2);
    	
    	
    	
    	// load tour extra-services
    	$data = load_tour_extra_services($data, $is_mobile, $tour);
    	
    	
    	$current_booking_item = $data['current_booking_item']; // this data set from function: load_tour_extra_services
    	
    	if(!empty($current_booking_item)){
    	
	    	// load service recommendation
	    	$current_item_info['service_id'] = $tour['id'];
	    	
	    	$current_item_info['service_type'] = $tour['cruise_id'] > 0 ? CRUISE : TOUR;
	    	
	    	$current_item_info['url_title'] = $tour['url_title'];
	    	
	    	$current_item_info['normal_discount'] = 0; // don't use this data
	    	
	    	$current_item_info['is_main_service'] = false; // don't use this data
	    	
	    	$current_item_info['destination_id'] = $tour['main_destination_id'];
	    	
	    	$current_item_info['is_booked_it'] = true;
	    	
	    	$current_item_info['parent_id'] = $current_booking_item['rowid']; // CART ROW-ID of the current selected item
	    	
	    	$current_item_info['start_date'] = $current_booking_item['start_date'];
	    		    	
	    	$data = load_service_recommendation($data, $is_mobile, $current_item_info);
    	
    	} else {
    		redirect(get_page_url(TOUR_DETAIL_PAGE, $tour));
    	}
    	
        render_view('tours/booking/tour_booking', $data, $is_mobile);
    }
    
    /**
     * When the customer click on 'Book-It' button on check-rate table
     * 
     * @author Khuyenpv
     * @since 27.03.2015
     */
    function book_it($url_title){
    	
    	/**
		 * Get the selected Accommodation & Promotion
		 * 
    	 */
    	$acc = $this->input->get('acc');
    	$acc_arr = explode('_', $acc);
    	
    	$acc_id = count($acc_arr) > 0 ? $acc_arr[0] : '';
    	$pro_id = count($acc_arr) > 1 ? $acc_arr[1] : '';
    	
    	/**
		 * Get the Parent-ID : indicating the current main booking services
		 *  
    	 */
    	$parent_id = $this->input->get('parent_id');
    	
    	$tour = $this->Tour_Model->get_tour_detail($url_title);
    	
    	$check_rates = get_tour_check_rate_from_url($tour);
    	
    	// load the tour accommodations & detail acc infor view
    	$departure_date = !empty($check_rates['departure_date']) ? $check_rates['departure_date'] : '';
    	
    	$accommodations = $this->Tour_Model->get_tour_accommodations($tour['id'], $departure_date, $acc_id);
    	
    	$cabin_arrangements = get_tour_cabin_arrangements($tour, $check_rates);
    	
    	$all_promotion_details = $this->Tour_Model->get_all_tour_promotions($tour['id'], $departure_date, $pro_id);
    	
    	$promotions = group_promotion_details_by_promotion($all_promotion_details);
    	
    	$promotions = $this->Tour_Model->get_travel_dates($promotions);
    	
    	$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($tour['id']);
    	
    	$discount_together = get_tour_discount_together($tour, $check_rates, $cabin_price_cnf);
		

    	$acc = count($accommodations) >  0 ? $accommodations[0] : array();
    	$pro = count($promotions) > 0 ? $promotions[0] : array();
    	
    	$optional_services = $this->Tour_Model->get_tour_optional_services($tour['id'], $departure_date , $tour['duration']);
    	$additional_charges = $optional_services['additional_charge'];
    	
    	$booking_rowid = insert_tour_acc_to_cart($tour, $acc, $pro, $check_rates, $cabin_arrangements, $cabin_price_cnf, $discount_together, $additional_charges, $parent_id);
    	
    	$is_ajax = $this->input->is_ajax_request();
    	
    	if($is_ajax){
    		
    		// do nothing
    	} else {
    		
    		$this->session->set_flashdata('curent_booking_rowid', $booking_rowid);
    		redirect(get_page_url(TOUR_BOOKING_PAGE, $tour));
    	}
    }
    
    /**
     * When the customer click on 'Add-to-cart' button on Tour-Booking View
     * 
     * @author Khuyenpv
     * @since 27.03.2015
     */
    function add_cart($url_title, $parent_id){
 		
    	$tour = $this->Tour_Model->get_tour_detail($url_title);
    	
    	$cabin_price_cnf = $this->Tour_Model->get_children_cabin_price($tour['id']);
    	$children_rate = !empty($cabin_price_cnf['under12']) ? $cabin_price_cnf['under12'] : 0;
    	
    	$booking_items = get_tour_booking_items($tour['id'], $parent_id, $children_rate);
    	
    	foreach($booking_items as $booking_item){
    			
    		$parent_rowid = $booking_item['rowid'];
    			
    		if(isset($booking_item['optional_services']['transfer_services']) && count($booking_item['optional_services']['transfer_services']) > 0){
    	
    			foreach ($booking_item['optional_services']['transfer_services'] as $transfer){
    					
    				$name = $transfer['name'];
    	
    				$unit = $transfer['unit'];
    					
    				$rate = $transfer['rate'];
    					
    				$amount = $transfer['total_price'];
    					
    				$service_id = $transfer['optional_service_id'];
    					
    				$reservation_type = RESERVATION_TYPE_TRANSFER;
    					
    				$selected = $this->input->post($parent_rowid.'_'.$service_id.'_selected');
    					
    				$partner_id = '';
    				// shuttle bus
    				if($transfer['unit_type'] == 1){
    					$partner_id = $booking_item['partner_id'];
    				}
    					
    				add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $transfer['description'], $unit, $rate, $amount, '', $partner_id);
    					
    			}
    	
    		}
    			
    		if(isset($booking_item['optional_services']['extra_services']) && count($booking_item['optional_services']['extra_services']) > 0){
    	
    			foreach ($booking_item['optional_services']['extra_services'] as $extra){
    	
    				$name = $extra['name'];
    					
    				$unit = $extra['unit'];
    					
    				$rate = $extra['rate'];
    					
    				$amount = $extra['total_price'];
    					
    				$service_id = $extra['optional_service_id'];
    					
    				$reservation_type = RESERVATION_TYPE_OTHER;
    					
    				$unit_change = $this->input->post($parent_rowid.'_'.$service_id.'_unit');
    					
    				$unit_text = '';
    					
    				if (!empty($unit_change)){
    	
    					$unit = $unit_change;
    	
    					$amount = $extra['price'] * $unit;
    	
    					$unit_text = ' pax';
    	
    				}
    					
    				$partner_id = '';
    					
    				if (strpos($name, 'Visa') === FALSE){
    					$partner_id = $booking_item['partner_id'];
    				} else {
    					//echo 'Visa here';exit();
    				}
    					
    				$selected = $this->input->post($parent_rowid.'_'.$service_id.'_selected');
    					
    				add_optional_service($parent_rowid, $service_id, $reservation_type, $selected, $name, $extra['description'], $unit, $rate, $amount, $unit_text, $partner_id);
    					
    			}
    	
    		}
    			
    		$this->cart->update_item($booking_item['rowid'], 'is_optional_service_selection', true);
    			
    		$this->cart->update_item($parent_rowid, 'temp_optional_services', array());
    	}
    	
    	redirect(get_page_url(MY_BOOKING_PAGE));
    	
    }
    
    /**
     * Temporory select a Optional Services 
     * 
     * @author Khuyenpv
     * @since 02.04.2015
     */
    function save_optional_service_selection_status(){
    
    	$parent_rowid = $this->input->post('parent_rowid');
    
    	$unit = $this->input->post('unit');
    
    	$service_id = $this->input->post('service_id');
    
    	$selected = $this->input->post('selected');
    
    	$cart_item = get_booking_item($parent_rowid);
    
    	$optional_services = array();
    
    	$status = array();
    
    	$status['selected'] = $selected;
    
    	$status['unit'] = $unit;
    
    	if ($cart_item){
    			
    		if (isset($cart_item['temp_optional_services']) && is_array($cart_item['temp_optional_services'])){
    
    			$optional_services = $cart_item['temp_optional_services'];
    
    			$optional_services[$service_id] = $status;
    
    		} else {
    
    			$optional_services[$service_id] = $status;
    		}
    			
    	}
    
    	foreach ($optional_services as $key=>$value){
    		echo $key.': '.$value['unit'].' - '.$value['selected'].'    ';
    	}
    
    	$this->cart->update_item($parent_rowid, 'temp_optional_services', $optional_services);
    
    	echo '1';
    }
}
?>
