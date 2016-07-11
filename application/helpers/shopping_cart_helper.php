<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * HELPER FUNCTIONS FOR MY-BOOKING PAGE
 */

/**
 * Sort the booking items by Date ASC
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function sort_booking_date_asc($b1, $b2){

	$t1 = strtotime($b1['start_date']);

	$t2 = strtotime($b2['start_date']);

	if($t1 == $t2) {
		return 0;
	}
	return ($t1 < $t2) ? -1 : 1;
}

/**
 * Calculate Booking Total & Discount
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function calculate_booking_info($my_bookings, $is_check_gift_voucher = FALSE){

	$total = 0;

	$discount = 0;

	foreach ($my_bookings as $key=> $booking_item) {
			
		$total += $booking_item['total_price'];
			
		$discount += $booking_item['discount'];
			
	}

	$booking_info['total_price'] = $total + $discount;

	$booking_info['discount'] = $discount;

	$booking_info['final_total'] = $total;

	$promotion_code = get_promo_code();

	if ($is_check_gift_voucher){

		if(!empty($promotion_code) && !empty($promotion_code['type']) && !empty($promotion_code['value']) && !empty($promotion_code['code'])){

			if($promotion_code['type'] == CAMPAIGN_VOUCHER){
					
				$booking_info['gift_voucher'] = $promotion_code['value'];
					
				$booking_info['final_total'] = $booking_info['final_total'] - $booking_info['gift_voucher'];
					
			}
		}

	}

	return $booking_info;
}

/**
 * Load My-Booking Table
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function load_my_booking_table($data, $is_mobile, $my_bookings, $booking_info, $is_my_booking_page = true){
	
	$view_data['my_bookings'] = $my_bookings;
	
	$view_data['booking_info'] = $booking_info;
	
	$view_data['is_my_booking_page'] = $is_my_booking_page;
	
	$data['my_booking_table'] = load_view('booking/my_booking_table', $view_data, $is_mobile);
	
	return $data;
}

/**
 * Check if a Booking-Item has a special offer (promotion or free visa) or not
 * 
 * @author Khuyenpv
 * @since 07.04.2015
 */
function has_special_offers($booking_item){
	
	$has_old_promotion = !empty($booking_item['offer_note']) && !empty($booking_item['offer_cond']); // old storing
	
	$has_visa = $booking_item['is_free_visa'];
	
	$has_new_promotion = !empty($booking_item['promotion']);
	
	return $has_old_promotion || $has_visa || $has_new_promotion;
}

/**
 * Show service item on the booking table
 * 
 * @author Khuyenpv
 * @since 08.04.2015
 */
function show_service_item($booking_item){
	if(!empty($booking_item['start_date'])){
		return strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date'])). ': '. $booking_item['service_name'];
	} else {
		return $booking_item['service_name'];
	}
}

/**
 * Save My-Booking to DB
 * 
 * @author Khuyenpv
 * @since 08.04.2015
 */
function save_my_booking(){
	
	$CI =& get_instance();
	
	$CI->load->library('cart');
	$CI->load->model(array('TourModel','CustomerModel'));
	
	$reservation_infos = get_my_reservations();
	
	$customer = get_contact_post_data();
	
	$special_request = $customer['special_request'];
	unset($customer['special_request']);
	
	$promotion_code = get_promo_code();
	
	$customer_id = $CI->TourModel->create_or_update_customer($customer);
		
	$customer_booking_id = $CI->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request, $promotion_code);

	send_my_booking_email($reservation_infos, $customer, $special_request, true, $promotion_code);
	
	clear_promode_code();
		
	if ($customer_booking_id !== FALSE){
		$CI->cart->destroy();
		redirect(get_page_url(THANK_YOU_PAGE));
	}
}

/**
 * Send My-Current-Booking to the customer
 * 
 * @author Khuyenpv
 * @since 08.04.2015
 */
function send_my_booking_email($reservation_infos, $cus, $special_request, $is_send_customer = true, $promotion_code = ''){
	
	$CI =& get_instance();
	$CI->load->library('email');
	
	$my_bookings = get_my_booking();
	
	usort($my_bookings, 'sort_booking_date_asc');
	
	$data['my_booking'] = $my_bookings;

	$customer_booking = $reservation_infos['customer_booking'];;

	$data['customer_booking'] = $customer_booking;
	$data['customer_booking']['tour_name'] = $reservation_infos['service_reservations'][0]['service_name'];
	$data['customer_booking']['special_request'] = $special_request;


	$countries = $CI->config->item('countries');
	$cus['country_name'] = $countries[$cus['country']][0];
	$config_title = $CI->config->item('title');
	$cus['title_text'] = $config_title[$cus['title']];
	
	$subject_cus = 'Autoreply: ' . $data['customer_booking']['tour_name'] . ' - '. BRANCH_NAME;
	$subject_bpt = 'Reservation: ' . $data['customer_booking']['tour_name'] . ' - '. $cus['full_name'];

	$data['cus'] = $cus;

	$data['popup_free_visa'] = $CI->load->view('ads/popup_free_visa', $data, true);

	if (!empty($promotion_code)){
			
		$data['promotion_code'] = $promotion_code;
	}

	$content = $CI->load->view('booking/email_booking_content', $data, TRUE);

	//echo $content;exit();
	
	
	/**
	 * Send to Customer Email
	 */
	if (count($data['my_booking']) > 0 && $is_send_customer){
		$CI->email->from('reservation@'.strtolower(SITE_NAME), BRANCH_NAME);
		$CI->email->reply_to('reservation@'.strtolower(SITE_NAME));
		$CI->email->to($cus['email']);
		$CI->email->subject($subject_cus);
		$CI->email->message($content);
		if (!$CI->email->send()){
			log_message('error', 'Submit Booking - '.$cus['full_name'].': Can not send email to '.$cus['email']);
		}
		$CI->email->clear();
	}
	
	/**
	 * Send to Bestpricevn@gmail.com
	 */
	$CI->email->from($cus['email'], $cus['full_name']);
	$CI->email->to('bestpricevn@gmail.com');
	$CI->email->reply_to($cus['email']);
	$CI->email->subject($subject_bpt);
	$CI->email->message($content);
	if (!$CI->email->send()){
		log_message('error', 'Submit Booking - '.$cus['full_name'].': Can not send email to bestpricevn@gmail.com');
	}
}

?>