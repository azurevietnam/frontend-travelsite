<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * Payment
  *
  * @author toanlk
  * @since  Jul 30, 2015
  */
class Payment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->config->load('flight_meta');
		
		$this->load->library(array('Cart', 'dompdf_gen'));
		
		$this->load->language(array('cruise','faq', 'visa', 'flight', 'payment'));

        $this->load->model(array('Tour_Model','Faq_Model','CustomerModel','BookingModel', 'Visa_Model'));
        
        $this->load->helper(array('form', 'tour', 'text', 'cookie', 'payment', 'file', 'group', 'visa'));
	}
	
	function index()
    {
		if(isset($_GET["vpc_TxnResponseCode"]) && isset($_GET["vpc_SecureHash"])
				&& isset($_GET["vpc_OrderInfo"]) && isset($_GET["vpc_Amount"])) {
	
			$response = getResponseData();
			
			$txnResponseCode 	= $response['txnResponseCode'];
			$hashValidated 		= $response['hashValidated'];
			$orderInfo 			= $response['orderInfo'];
			$amount 			= $response['amount'];
			
			// get default config
			$data = array();
			$data['config_title'] = $this->config->item('title');
			$data['bank_fee'] = $this->config->item('bank_fee');
			
			$data['response'] = $response;
			
			// get invoice details
			$invoice = $this->CustomerModel->get_invoice_info($orderInfo);
			$invoice_reference = $invoice['invoice_reference'];
			$data['invoice'] = $invoice;
			
			// check amount
			$onepay_return 	= (int)$amount;
			$invoice_amount = round($invoice['amount'] * 100);
			$balance_due = $onepay_return - $invoice_amount;
			
			// log any return payment from Onepay
			log_payment('', $hashValidated, $onepay_return, $invoice_amount, $invoice['type']);
			
			// --- Success
			if($hashValidated=="CORRECT" && $txnResponseCode=="0"
					&& $balance_due == 0){
				
				// --- update payment status
				$this->CustomerModel->update_invoice_status(INVOICE_SUCCESSFUL, $invoice_reference);
				
				
				$for = '';
				
				if($invoice['type'] == FLIGHT) {
					$for = '?type=flight';
					
					$this->process_flight_confirm($data);
				} elseif($invoice['type'] == VISA) {
					$this->process_visa_confirm($data);
				}
					
				
				// --- show thank you
				redirect(site_url('payment').'/success.html'.$for);
			}
			// --- Pending
			elseif ($hashValidated=="INVALID HASH" && $txnResponseCode=="0"){
				 
				// --- update payment status
				$this->CustomerModel->update_invoice_status(INVOICE_PENDING, $invoice_reference);
			
				// --- show pending message
				redirect(site_url('payment').'/pending.html');
			}
			// --- Fail
			elseif ($txnResponseCode!="0") {
				
				if($txnResponseCode == "99"){ // user click 'cancel payment and return the website'
					// do nothing: not update invoice status (keep the previous invoice status)
				} else {
					// --- update payment status
					$this->CustomerModel->update_invoice_status(INVOICE_FAILED, $invoice_reference);
				}
				 
				// --- show unsuccessful page (allow customers to repay or contact)
				redirect(site_url('payment').'/unsuccess.html?invoice_ref=' . $invoice_reference);
			}
			// --- Unknow
			else {
				log_payment('unknow', $hashValidated, $onepay_return, $invoice_amount, $invoice['type']);
				
				// --- update payment status
				$this->CustomerModel->update_invoice_status(INVOICE_UNKNOWN, $invoice_reference);
				
				// --- show pending message
				redirect(site_url('payment').'/pending.html');
			}
		}
		
		
		// ----- Otherwise case go to home page ----- 
		redirect(site_url());
	}
	
	function success() {
	
		$data['payment_status'] = INVOICE_SUCCESSFUL;
		
		if(isset($_GET["type"]) && $_GET["type"] == 'flight') {
			$data['current_step'] = 4;
			$data['step_labels'] = $this->config->item('step_labels');
			
			$data['invoice_type'] = FLIGHT;
			
		} else {
		    $data['current_step'] = 3;
		    $data['step_labels'] = $this->config->item('visa_step_labels');
			
			$data['invoice_type'] = VISA;
			
			$data = get_booking_together_recommend($data);
		}
		
		$data['breadcrumb'] = load_view('/common/booking/booking_steps', $data, $data['is_mobile']);
		
		$this->_setFormData($data, PAYMENT_SUCCESS_PAGE);
	}
	
	function pending() {
	
		$data['payment_status'] = INVOICE_PENDING;
		$this->_setFormData($data, PAYMENT_PENDING_PAGE);
	}
	
	function unsuccess() {
		
		$redirect = false;
		
		if(isset($_GET["invoice_ref"])) {
			$invoice_ref = $_GET["invoice_ref"];
			
			$invoice = $this->CustomerModel->get_invoice_info($invoice_ref);
			
			if(!empty($invoice)) {
				$data['payment_status'] = INVOICE_FAILED;
					
				$data['pay_url'] = get_payment_url($invoice);
				$this->_setFormData($data, PAYMENT_UNSUCCESS_PAGE);
			} else {
				$redirect = true;
			}
		} else {
			$redirect = true;
		}
		
		if($redirect) {
			redirect(site_url());
		}
	}
	
	function _setFormData($data, $page) {
	    
	    // check if the current device is Mobile or Not
	    $is_mobile = is_mobile();
	    
		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta($page);
		
		$data['page_theme'] = get_page_theme($page, $is_mobile);
		
		$data = get_page_navigation($data, $is_mobile, $page);
	
		render_view('common/payment/payment_confirm', $data, $is_mobile);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Generate invoice view.
	 *
	 * @access        public
	 * @return        void
	 */
	
	function invoice() {
	    
	    // check valid invoice and redirect to Onepay
	    $action = $this->input->post('action');
	    
	    $invoice_post_ref = $this->input->post('invoice_reference');
	    	
	    if((!empty($action) && $action == 'redirect') && !empty($invoice_post_ref)) {
	        
	        $invoice = $this->CustomerModel->get_invoice_info($invoice_post_ref);
	        
	        // redirect to Onepay
	        if(!empty($invoice) && ($invoice['status'] == INVOICE_NOT_PAID || $invoice['status'] == INVOICE_FAILED)) {
	        	
	        	//print_r($invoice['customer_booking']);exit();
	        	
	        	if(in_array($invoice['customer_booking']['status'], array(BOOKING_NEW, BOOKING_PENDING))
	        			    		&& $invoice['customer_booking']['deleted'] != DELETED){
	        			    		
	            	redirect(get_payment_url($invoice));
	            
	        	}
	        }
	    }
		
		if(isset($_GET["ref"])) {
		    
			$invoice_ref = $_GET["ref"];
			
			$invoice = $this->CustomerModel->get_invoice_info($invoice_ref);
			
			if(!empty($invoice)) {
				$data['pay_url'] = get_payment_url($invoice);
				$data['invoice'] = $invoice;
				$data['bank_fee'] = $this->config->item('bank_fee');
				$data['countries'] = $this->config->item('countries');
					
				$data['VIEW_INVOICE'] = true;
				
				$data['invoice_type'] = VISA;
				
				if(isset($invoice['type']) && !empty($invoice['type'])) {
					$data['invoice_type'] = $invoice['type'];
				}
				/*
				 * for test the invoce template only
				 * khuyepv: 20.12.2013
				 */
				/*$data['valid_airline_codes'] = $this->config->item('valid_airline_codes');
				$html = $this->load->view('flights/payment/invoice_template', $data, true);
				
				echo $html;exit();*/
				
					
				// get receive date
				if($data['invoice_type'] == VISA) {
					$processing_time = 2;
					$service_reservations = $invoice['customer_booking']['service_reservations'];
					foreach ($service_reservations as $service) {
						if(stripos($service['booking_services'], 'Normal') !== false) {
							$processing_time = 1;
						}
					}
					
					if(!empty($invoice['customer_booking']['booking_date'])) {
						$receive_date = get_visa_receive_date($processing_time, $invoice['customer_booking']['booking_date']);
					} else {
						$receive_date = get_visa_receive_date($processing_time, date(DB_DATE_TIME_FORMAT));
					}
					$data['receive_date'] = get_receive_date_lang($receive_date);
				}
				
				echo $this->load->view('common/payment/invoice_view', $data, true);
				exit();
			} 
		} 
		
		redirect(site_url());
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create pdf, send email confirm to client and system.
	 *
	 * @access        public
	 * @param         object        Invoice object
	 * @return        void
	 */
	
	function process_visa_confirm($data) {
		
		$invoice = $data['invoice'];
		$invoice_reference = $invoice['invoice_reference'];
		
		$data['visa_types'] = $this->config->item('visa_types');
		$data['rush_services'] = $this->config->item('rush_services');
		
		// get receive date
		$processing_time = 2;
		$airport = '';
		$flight_number = '';
		$type_of_visa = '';
		$service_reservations = $invoice['customer_booking']['service_reservations'];
		foreach ($service_reservations as $service) {
			if(stripos($service['booking_services'], 'Normal') !== false) {
				$processing_time = 1;
			}
				
			$start_airport = stripos($service['description'], 'Arrival Airport');
			$end_airport = strpos($service['description'], 'airport');
				
			if($start_airport !== false) {
				$length = ($end_airport + 8) - $start_airport;
				$txt = substr($service['description'], $start_airport, $length);
				$arr_txt = explode(':', $txt);
				if(isset($arr_txt[1])) {
					$airport = trim(str_replace('Flight Number', '', $arr_txt[1]));
				}
			}
				
			$start_flight = stripos($service['description'], 'Flight Number');
			if($start_flight !== false) {
				$txt = substr($service['description'], $start_flight);
				$arr_txt = explode(':', $txt);
				if(isset($arr_txt[1])) {
					$flight_number = trim($arr_txt[1]);
				}
		
				// explode string into flight number and description
				if(!empty($flight_number)) {
					$arr_des = preg_split('/\s+/', $flight_number);
					if(count($arr_des) > 1) {
						$flight_number = $arr_des[0];
					}
				}
			}
				
			$arr_txt = explode('-', $service['description']);
			if(isset($arr_txt[0])) {
				$type_of_visa = trim($arr_txt[0]);
			}
		}
		
		// $invoice['customer_booking']['booking_date']
		$receive_date = get_visa_receive_date($processing_time, date(DB_DATE_FORMAT));
			
		$data['receive_date'] = get_receive_date_lang($receive_date);
		
		$data['processing_time'] = $processing_time;
		$data['flight_number'] = $flight_number;
		$data['airport'] = $airport;
		$data['type_of_visa'] = $type_of_visa;
		
		$def_service = $service_reservations[0];
		if(!empty($def_service) && empty($def_service['visa_users'])) {
			$data['visa_via_email_note'] = lang('visa_via_email_note');
		}
			
		// --- create invoice pdf
		$html = $this->load->view('visa/payment/invoice_template', $data, true);
		$mail_attachment = create_invoice_pdf($invoice_reference, $html);
		
		// --- send email to customer
		$to = $data['invoice']['customer']['email'];
		
		$subject = lang('payment_email_visa_subject', BRANCH_NAME); // edit by Khuyenpv on 04.11.2014 to update language for the visa email subject
		
		$mail_content = $this->load->view('common/payment_success_form_mail', $data, TRUE);
		
		_send_mail_payment($subject, $mail_content, $mail_attachment, $to);
		
		// -- send email to system
		//_send_mail_payment_notification($data, 'Visa');
		_send_mail_payment($subject, $mail_content, $mail_attachment, VISA_PAYMENT_NOTIFICATION_EMAIL);
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Create pdf, send email confirm to client and system.
	 *
	 * @access        public
	 * @param         object        Invoice object
	 * @return        void
	 */
	
	function process_flight_confirm($data) {
		
		$invoice = $data['invoice'];
		$invoice_reference = $invoice['invoice_reference'];
		
		$data['valid_airline_codes'] = $this->config->item('valid_airline_codes');
		
		// --- create invoice pdf
		$html = $this->load->view('flights/payment/invoice_template', $data, true);
		$mail_attachment = create_invoice_pdf($invoice_reference, $html);
		
		// --- send email to customer
		$to = $data['invoice']['customer']['email'];
		
		$subject = lang('payment_email_flight_subject', BRANCH_NAME);
		
		$mail_content = $this->load->view('common/payment_success_form_mail', $data, TRUE);
		
		_send_mail_payment($subject, $mail_content, $mail_attachment, $to);
		//_send_mail_payment_by_google_acc($data, $file_path);
		
		// -- send email to system
		//_send_mail_payment_notification($data, 'Flight');
		_send_mail_payment($subject, $mail_content, $mail_attachment, FLIGHT_PAYMENT_NOTIFICATION_EMAIL);
	}
}
?>