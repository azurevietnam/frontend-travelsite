<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_Booking extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model(array('TourModel','HotelModel','FaqModel','BookingModel','CustomerModel'));
		
		$this->load->library('Cart');
		
		$this->load->language(array('cruise','faq','hotel'));
		
		$this->load->helper(array('form','text','tour','group','booking','visa'));
		
		// for test only
		//$this->output->enable_profiler(TRUE);
	}
	
	function  index(){
		
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
		
		
		$data = $this->_set_common_data();
		
		$data['my_booking'] = get_my_booking();
		
		usort($data['my_booking'], array($this,"sortBooking"));
		
		$data['booking_info'] = $this->_get_booking_info($data['my_booking'], true);
		
		// show progress tracker bar
		$data['progress_tracker_id'] = 3;
		$data['progress_tracker'] = $this->load->view('common/progress_tracker', $data, TRUE);
	
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		$departure_date = $data['search_criteria']['departure_date'];
		
		$data['recommendations'] = $this->BookingModel->get_remaining_recommendations($departure_date);
		
		$data['recommendation_view'] = $this->load->view('common/remain_recommendation', $data, TRUE);
		
		$data['main'] = $this->load->view('common/my_booking', $data, TRUE);
		
		$this->load->view('template', $data);
		
	}
	
	// for the check-out page
	function submit(){

		$action = $this->input->post('action');		
		
		if($action == 'book') {
			
			$this->_book();
		}
	
		
		$data = $this->_set_common_data_4_submit();
		
		$data['my_booking'] = get_my_booking();
		
		if(count($data['my_booking']) == 0){
			
			redirect(site_url('my-booking').'/');
		}
		
		usort($data['my_booking'], array($this,"sortBooking"));
		
		$data['booking_info'] = $this->_get_booking_info($data['my_booking'], true);
		
		// show progress tracker bar
		$data['progress_tracker_id'] = 4;
		$data['progress_tracker'] = $this->load->view('common/progress_tracker', $data, TRUE);
	
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		$data['main'] = $this->load->view('common/submit_booking', $data, TRUE);
		
		$this->load->view('template', $data);
		
		
	}
	
	function _set_common_data(){	
		

		$data['metas'] = site_metas(MY_BOOKING, '');
		
		$data['navigation'] = createMyBookingNavLink('My Booking');		
		
		$data['countries'] = $this->config->item('countries');
		
		
		// home page flag
		$data['flag_home_page'] = 1;
		// load hotel search form
		$data = $this->get_hotel_search_form($data);
		
		$data = buildTourSearchCriteria($data);	
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$data = loadTopDestination($data);
		
		
		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);
		
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		
		$data['is_allow_online_visa_payment'] = is_allow_online_payment_4_visa_in_shopping_cart(); 
		
		return $data;
	}
	
	
	function _set_common_data_4_submit(){	
		

		$data['metas'] = site_metas(SUBMIT_BOOKING, '');
		
		$data['navigation'] = createMyBookingNavLink('Checkout');		
		
		$data['countries'] = $this->config->item('countries');
		
		
		// home page flag
		$data['flag_home_page'] = 1;
		// load hotel search form
		$data = $this->get_hotel_search_form($data);
		
		$data = buildTourSearchCriteria($data);	
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$data = loadTopDestination($data);
		
			
		$data['booking_step'] = $this->load->view('common/booking_step_view', $data, TRUE);
		
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
	
		
		return $data;
	}
	
	
	function get_hotel_search_form($data) {
		
		$data = load_hotel_search_autocomplete($data);
		
		$data = load_hotel_top_destination($data);
		
		$data['hotel_stars'] = $this->HotelModel->hotel_stars;
		$data['hotel_nights'] = $this->HotelModel->hotel_nights;
		
		$search_criteria = buildHotelSearchCriteria();
		
		$data['search_criteria'] = $search_criteria;
		
		$data['hotel_search_view'] = $this->load->view('hotels/hotel_search_form', $data, TRUE);
		
		$data['atts'] = get_popup_config('extra_detail');
		return $data;
	}
	
	function _book(){
		
		if ($this->_validateBooking()) {
			
			$reservation_infos = get_my_reservations();
			
			$cus['title'] = $this->input->post('title');
			$cus['full_name'] = $this->input->post('full_name');
			$cus['email'] = $this->input->post('email');
			$cus['phone'] = $this->input->post('phone');
			$cus['fax'] = $this->input->post('fax');
			$cus['country'] = $this->input->post('country');
			$cus['city'] = $this->input->post('city');
			$cus['ip_address'] = $_SERVER['REMOTE_ADDR'];
			
			$customer_id = $this->TourModel->create_or_update_customer($cus);
			
			$special_request = trim($this->input->post('special_requests'));
			
			$promotion_code = get_promo_code();
			
			$customer_booking_id = $this->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request, $promotion_code);
			
			// call send-email
			$this->_send_mail($reservation_infos, $cus, $special_request, true, $promotion_code);
			
			//$this->_send_email_by_google_acc($reservation_infos, $cus, $special_request, true, $promotion_code);
			
			clear_promode_code();
			
			if ($customer_booking_id !== FALSE){
					
				$this->cart->destroy();
					
				redirect(site_url().'thank_you/');
			}
		}
	}

	function _send_mail($reservation_infos, $cus, $special_request, $is_send_customer = true, $promotion_code = ''){
		
		$data['my_booking'] = get_my_booking();
		
		usort($data['my_booking'], array($this,"sortBooking"));
		
		$customer_booking = $reservation_infos['customer_booking'];;
		
		$data['customer_booking'] = $customer_booking;
		$data['customer_booking']['tour_name'] = $reservation_infos['service_reservations'][0]['service_name'];
		$data['customer_booking']['special_request'] = $special_request;
		

		$countries = $this->config->item('countries');
		$cus['country_name'] = $countries[$cus['country']][0];
		$config_title = $this->config->item('title');
		$cus['title_text'] = $config_title[$cus['title']];
		
		$headers = "Content-type: text/html\r\n";
		
		$header_cus = 'From: ' . $cus['email'] . "\r\n". $headers;
		$header_bpt = 'From: ' . BRANCH_NAME.' <reservation@'.strtolower(SITE_NAME).'>'. "\r\n". $headers;
		
		$subject_cus = 'Autoreply: ' . $data['customer_booking']['tour_name'] . ' - '. BRANCH_NAME;
		$subject_bpt = 'Reservation: ' . $data['customer_booking']['tour_name'] . ' - '. $cus['full_name'];
		
		$data['cus'] = $cus;
		
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		
		if (!empty($promotion_code)){
			
			$data['promotion_code'] = $promotion_code;
		}
		
		$content = $this->load->view('common/my_booking_form_mail', $data, TRUE);
		
		//echo $content;exit();
		
		//mail('reservation@'.strtolower(SITE_NAME), $subject_bpt, $content, $header_cus);
		mail('bestpricevn@gmail.com', $subject_bpt, $content, $header_cus);
		
		if (count($data['my_booking']) > 0 && $is_send_customer){
			mail($cus['email'], $subject_cus, $content, $header_bpt);
		}
		
		return true;
	}
	
	function _send_email_by_google_acc($reservation_infos, $cus, $special_request, $is_send_customer, $promotion_code = ''){
		
		$this->load->library('email');
			
		$data['my_booking'] = get_my_booking();
		
		usort($data['my_booking'], array($this,"sortBooking"));
		
		$customer_booking = $reservation_infos['customer_booking'];;
		
		$data['customer_booking'] = $customer_booking;
		$data['customer_booking']['tour_name'] = $reservation_infos['service_reservations'][0]['service_name'];
		$data['customer_booking']['special_request'] = $special_request;
		

		$countries = $this->config->item('countries');
		$cus['country_name'] = $countries[$cus['country']][0];
		$config_title = $this->config->item('title');
		$cus['title_text'] = $config_title[$cus['title']];
		
		$subject_cus = 'Autoreply: ' . $data['customer_booking']['tour_name'] . ' - '. BRANCH_NAME;
		$subject_bpt = 'Reservation: ' . $data['customer_booking']['tour_name'] . ' - '. $cus['full_name'];
		
		$data['cus'] = $cus;
		$data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
		
		if (!empty($promotion_code)){
			
			$data['promotion_code'] = $promotion_code;
		}
		
		$content = $this->load->view('common/my_booking_form_mail', $data, TRUE);
		
		/*
		 * Send to Customer 
		 */		
		if (count($data['my_booking']) > 0 && $is_send_customer){
			$this->email->from('bestpricevn@gmail.com',BRANCH_NAME);
			$this->email->to($cus['email']);
			$this->email->subject($subject_cus);
			$this->email->message($content);
			if (!$this->email->send()){			
				log_message('error', 'Submit Booking - '.$cus['full_name'].': Can not send email to '.$cus['email']);
			}
			$this->email->clear();
		}
		
		/**
		 * Send to Bestpricevn@gmail.com
		 */		
		$this->email->from($cus['email'], $cus['full_name']);
		$this->email->to('bestpricevn@gmail.com');
		$this->email->reply_to($cus['email']);
		$this->email->subject($subject_bpt);
		$this->email->message($content);
		if (!$this->email->send()){			
			log_message('error', 'Submit Booking - '.$cus['full_name'].': Can not send email to bestpricevn@gmail.com');
		}
		
		return true;
		
	}
	
	function _validateBooking()
	{
		$this->_setValidationRules();
		return $this->form_validation->run();
	}
	
	function _setValidationRules()
	{
		$this->load->library('form_validation');
		$booking_rules = $this->config->item('booking_rules');
		$this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
		$this->form_validation->set_rules($booking_rules);
	}
	
	function _get_booking_info($my_booking, $is_check_gift_voucher = FALSE){
		
		$total = 0;
		
		$discount = 0;
		
		foreach ($my_booking as $key=> $booking_item) {
			
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

	
	function sortBooking($b1, $b2){
		
		$t1 = strtotime($b1['start_date']);
		
		$t2 = strtotime($b2['start_date']);
		
		if($t1 == $t2) {
			return 0;
		}
		return ($t1 < $t2) ? -1 : 1;
	}
	
	function apply_promo_code() {
		
		$status = -1;
		$cp_value = '';
		
		$promo_code = $this->input->post('promo_code');

		// promotion code: not empty and length = 6
		if(!empty($promo_code) && strlen($promo_code) == 6) {
			$cp_type = get_promo_type($promo_code);
			
			$is_existed = $this->TourModel->check_promo_code($promo_code);
			
			if($is_existed) {
				
				if($cp_type == CAMPAIGN_FREE_VISA) {
					
					$status = lang('promo_code_applied');
						
					$max_free_visa = 10;
						
					// check promotion code exists or not
					if(is_applied_promo_code()) {
						$current = get_promo_code();
					
						if($current['type'] == CAMPAIGN_FREE_VISA) {
							$cr_codes = explode(',', $current['code']);

							$cp_code = $current['value'];
							if(!in_array($promo_code, $cr_codes) && count($cr_codes) < $max_free_visa) {
								$cp_code .= ',' .$promo_code;
							}
						} else {
							$cp_code = $promo_code;
						}
					}
						
					$arr_code = explode(',', $promo_code);
						
					$cnt = count($arr_code);
					if(count($arr_code) < 10) {
						$cnt = '0'.count($arr_code);
					}
					$status = str_replace('%d', $cnt, $status);
					
				} elseif($cp_type == CAMPAIGN_VOUCHER) {
					
					$my_booking = get_my_booking();
					$booking_info = $this->_get_booking_info($my_booking);
					
					$total_price = $booking_info['final_total'];
					
					if($total_price > 500) {
						$status = lang('promo_voucher');
							
						$status = str_replace('%d', '$50', $status);
						
						$cp_code = $promo_code;
							
						$cp_value = 50;
					} else {
						$status = -2;
					}
				}
				
				if (! empty($cp_value)) {
					$cp_promo = array('type' => $cp_type, 'value' => $cp_value, 'code' => $cp_code);
					
					$this->session->set_userdata(SESSION_PROMOTION_CAMPAIGN, $cp_promo);
				}
			
			}
		}
		
		echo $status;
	}
}