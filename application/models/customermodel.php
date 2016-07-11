<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CustomerModel extends CI_Model {	
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
			
		$this->load->database();	
		
		$this->load->helper('url');
		
		$this->load->helper('common');
		
		$this->load->library(array('TimeDate'));
		
		$this->config->load('customer_meta');
		
		$this->load->language('visa');
	
	}
	
	function create_or_update_contact_booking($contact_id){
		
		//$request_date = date('Y-m-d');
		$request_date = $this->_getCurrentDate();
		
		$contact = $this->getContact($contact_id);
		
		if ($contact != ''){
			
			$customer_id = $this->create_or_update_customer($contact);			
				
			$customer_booking = array();
			
			$customer_booking['customer_id'] = $customer_id;
			
			$admin = $this->getAdmin();
			
			if ($admin != ''){
				$customer_booking['user_id'] = $admin['id'];
			}
			
			$customer_booking['request_date'] = $this->_getCurrentDateTime();
			
			$customer_booking['start_date'] = $request_date;
			
			$customer_booking['end_date'] = $request_date;
			
			$customer_booking['selling_price'] = 0;
			
			$customer_booking['description'] = "<b>".$this->_getCurrentDateTime().":</b><br>".$contact['message'];
			
			$customer_booking['date_created'] = $this->_getCurrentDateTime();
			
			
			$customer_booking['booking_site'] = SITE_BESTPRICEVN_COM;
			
			$customer_booking['request_type'] = REQUEST_TYPE_REQUEST;
			
			$customer_booking['customer_type'] = $this->get_customer_type($customer_id);
			
			$customer_booking = $this->set_booking_source_data($customer_booking);
			
			$this->db->insert('customer_bookings', $customer_booking);
			
			$customer_booking_id = $this->db->insert_id();
			
			$subject = $contact['subject'];
			
			if ($subject == 'info'){				
				$subject = "Information on Bestpricevn.com";				
			}
			
			if ($subject == 'request'){				
				$subject = "Special Request";				
			}
			
			if ($subject == 'claim'){				
				$subject = "Rate Guarantee Claim";				
			}
			
			if ($subject == 'feedback'){				
				$subject = "Feedback";				
			}
			
			if ($subject == 'other'){				
				$subject = "Other Request";				
			}
			
			$service_reservation['customer_booking_id'] = $customer_booking_id;
			
			$service_reservation['reservation_type'] = 5; // others
			
			$service_reservation['name'] = '';
			
			$service_reservation['service_id'] = 0;
			
			$service_reservation['service_name'] = $subject;
			
			$service_reservation['partner_id'] = 0;
		
			$service_reservation['partner_name'] = "";
			
			$service_reservation['start_date'] = $request_date;
			
			$service_reservation['end_date'] = $request_date;
			
			$service_reservation['selling_price'] = 0;
			
			$service_reservation['description'] = $contact['message'];
			
			$service_reservation['date_created'] = $this->_getCurrentDateTime();
			
			$this->db->insert('service_reservations', $service_reservation);
		}
	}
	
	function updatePrice($cb_id){		
		
		$this->db->select_sum('net_price', 'net');
		
		$this->db->where('customer_booking_id', $cb_id);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('service_reservations');
		
		$results = $query->result_array();
		
		$net = count($results) > 0 ? $results[0]['net'] : 0;
		
		
		$this->db->select_sum('selling_price', 'sel');
		
		$this->db->where('customer_booking_id', $cb_id);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('service_reservations');
		
		$results = $query->result_array();
		
		$sel = count($results) > 0 ? $results[0]['sel'] : 0;
		
		$this->db->set('net_price', $net);
		
		$this->db->set('selling_price', $sel);
		
		$this->db->where('id', $cb_id);
		
		$this->db->update('customer_bookings');

	}
	
	function getAdmin(){
		
		$this->db->where('is_admin', 1);
		
		$this->db->where('status', STATUS_ACTIVE);
		
		$this->db->where('deleted !=', DELETED);
		
		$query = $this->db->get('users');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			return $results[0];
		} else {
			return '';
		}
	}
	
	function getContact($contact_id){
		
		$this->db->where('id', $contact_id);
		
		$query = $this->db->get('contacts');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			return $results[0];
		} else {
			return '';
		}
	}
	
	function create_or_update_customer($contact){
		
		/**
		 * Modified by Khuyenpv on 02/02/2014
		 * allways create a new customer after each booking
		 */
		
		$cus['title'] = $contact['title'];
		
		$cus['full_name'] = $contact['full_name'];
		
		$cus['email'] = $contact['email'];
		
		$cus['phone'] = $contact['phone'];
		
		$cus['country'] = $contact['country'];
		
		$cus['city'] = $contact['city'];
		
		$cus['ip_address'] = $contact['ip_address'];
		
		$cus['date_created'] = $this->_getCurrentDateTime();
		$cus['date_modified'] = $this->_getCurrentDateTime();
			
		$this->db->insert('customers', $cus);
			
		$cus_id = $this->db->insert_id();
		
		/*
		$this->db->where('email', $contact['email']);
		
		$this->db->where('deleted !=', DELETED);
		
		$nr = $this->db->count_all_results('customers');
		
		$cus_id = 0;
		
		$cus['title'] = $contact['title'];
		
		$cus['full_name'] = $contact['full_name'];
		
		$cus['email'] = $contact['email'];
		
		$cus['phone'] = $contact['phone'];
		
		$cus['country'] = $contact['country'];
		
		$cus['city'] = $contact['city'];
		
		$cus['ip_address'] = $contact['ip_address'];
		
		if ($nr == 0){
			
			$cus['date_created'] = $this->_getCurrentDateTime();
			
			$this->db->insert('customers', $cus);
			
			$cus_id = $this->db->insert_id();
		
		} else {
			
			$cus['date_modified'] = $this->_getCurrentDateTime();
			
			$this->db->where('email', $contact['email']);
			
			$this->db->where('deleted !=', DELETED);
			
			$this->db->update('customers', $cus);
			
			
			$this->db->where('email', $cus['email']);
			
			$this->db->where('deleted !=', DELETED);
			
			$query = $this->db->get('customers');
		
			$results = $query->result_array();
						
			$cus_id = $results[0]['id'];
			
		}*/
		
		return $cus_id;
	}
	
	function _getCurrentDate(){
		
		date_default_timezone_set("Asia/Saigon");
		
		return date('Y-m-d', time());
	}
	
	function _getCurrentDateTime(){
		date_default_timezone_set("Asia/Saigon");
		
		return date('Y-m-d H:i:s', time());
	}

	
	function save_customer_booking($reservation_infos, $customer_id, $special_request, $promotion_code = ''){
		
		$this->db->trans_start();
		
		$customer_booking = $reservation_infos['customer_booking'];
		
		unset($customer_booking['guest']);
		
		$service_reservations = $reservation_infos['service_reservations'];
		
		$admin = $this->getAdmin();
			
		if ($admin != ''){
			$customer_booking['user_id'] = $admin['id'];
		}
		
		$customer_booking['customer_id'] = $customer_id;
		
		$customer_booking['date_created'] = $this->_getCurrentDateTime();
		
		$customer_booking['booking_site'] = SITE_BESTPRICEVN_COM;
			
		$customer_booking['request_type'] = REQUEST_TYPE_RESERVATION;
			
		$customer_booking['customer_type'] = $this->get_customer_type($customer_id);
		
		$customer_booking = $this->set_booking_source_data($customer_booking);
		
		if(!empty($promotion_code)){
			$customer_booking['promotion_code'] = $promotion_code['code'];
			$customer_booking['note'] = 'Promotion Code Applied: '. $promotion_code['code'];
			
			if($promotion_code['type'] == CAMPAIGN_FREE_VISA){
				$customer_booking['note'] .= "\nFree Vietnam Visa";
			} elseif($promotion_code['type'] == CAMPAIGN_VOUCHER){
				$customer_booking['note'] .= "\nGift Voucher Discount $".$promotion_code['value'];	
			}
			
		}
		
		$customer_booking['special_request'] = $special_request;
		
		
		// flight users
		
		$flight_users = array();
		if (isset($customer_booking['flight_users'])){
			
			$flight_users = $customer_booking['flight_users'];
			
			unset($customer_booking['flight_users']);
		}
		
		
		$this->db->insert('customer_bookings', $customer_booking);
			
		$customer_booking_id = $this->db->insert_id();

		foreach ($service_reservations as $service_reservation) {
			
			$related_service_reservations = $service_reservation['related_service_reservations'];
			
			unset($service_reservation['related_service_reservations']);
			
			$visa_users = array();
			if (isset($service_reservation['visa_users'])){
				
				$visa_users = $service_reservation['visa_users'];
				
				unset($service_reservation['visa_users']);
			}
			
			
			$service_reservation['customer_booking_id'] = $customer_booking_id;
			
			$service_reservation['description'] = $service_reservation['description']."\n". $special_request;
			
			$service_reservation['date_created'] = $this->_getCurrentDateTime();
			
			// insert main service
			$this->db->insert('service_reservations', $service_reservation);
			
			$rs_id = $this->db->insert_id();
			
			// inser visa - user
			
			foreach ($visa_users as $value){
				
				$visa_user['service_reservation_id'] = $rs_id;
				
				$visa_user['name'] = $value['passport_name'];
				
				$visa_user['gender'] = $value['gender'] == 1? lang('visa_male'): lang('visa_female');
				
				$visa_user['birth_day'] = $this->timedate->format($value['birthday'], DB_DATE_FORMAT);
				
				$visa_user['nationality'] = $value['nationality_name'];
				
				$visa_user['passport'] = $value['passport_number'];
				
				if(isset($value['passport_expired'])){
						
					$visa_user['passport_expiry'] = $this->timedate->format($value['passport_expired'], DB_DATE_FORMAT);
				}
				
					
				$this->db->insert('visa_users',$visa_user);
				
			}
			
			foreach ($related_service_reservations as $value){
				
				$value['customer_booking_id'] = $customer_booking_id;
				
				$value['date_created'] = $this->_getCurrentDateTime();
				
				if($value['selling_price'] == 0){
					$value['origin_id'] = $rs_id;
				}
				
				// insert optional service
				$this->db->insert('service_reservations', $value);
			}
		}
		
		$start_date = $customer_booking['start_date'];
		$end_date = $customer_booking['end_date'];
		//$this->insert_gift_voucher_res($customer_booking_id, $promotion_code, $start_date, $end_date);
		
		$this->save_flight_users($flight_users, $customer_booking_id);
		
		$this->updatePrice($customer_booking_id);
		
		$this->db->trans_complete();
		
		$save_status = $this->db->trans_status();
		
		if ($save_status) {
			
			return $customer_booking_id;
			
		} else {
			
			return FALSE;
			
		}
	}
	
	function save_flight_users($flight_users, $customer_booking_id){

		if(!empty($flight_users)){
			
			$adults = $flight_users['adults'];
			
			$children = $flight_users['children'];
			
			$infants = $flight_users['infants'];
			
		
			foreach ($adults as $value){
				
				$value['customer_booking_id'] = $customer_booking_id;
				
				$value['type'] = 1; // 1 for adult
					
				$this->db->insert('flight_users',$value);
				
			}
			
			foreach ($children as $value){
				
				$value['customer_booking_id'] = $customer_booking_id;
				
				$value['type'] = 2; // 2 for children
				
				$value['birth_day'] = $this->timedate->format($value['birth_day'], DB_DATE_FORMAT);
					
				$this->db->insert('flight_users',$value);
				
			}
			
			foreach ($infants as $value){
				
				$value['customer_booking_id'] = $customer_booking_id;
				
				$value['type'] = 3; // 3 for infants
				
				$value['birth_day'] = $this->timedate->format($value['birth_day'], DB_DATE_FORMAT);
					
				$this->db->insert('flight_users',$value);
				
			}
			
		}
		
	}
		
	
	function insert_gift_voucher_res($customer_booking_id, $promotion_code, $start_date, $end_date){
		if(!empty($promotion_code) && !empty($promotion_code['type']) && !empty($promotion_code['value']) && !empty($promotion_code['code'])){
			
			if($promotion_code['type'] == CAMPAIGN_VOUCHER){
			
				$service_reservation['customer_booking_id'] = $customer_booking_id;
				
				$service_reservation['description'] = "Promotion Code: ".$promotion_code['code'];
				
				$service_reservation['description'] .= "\nGift Voucher Discount $".$promotion_code['value'];
				
				$service_reservation['date_created'] = $this->_getCurrentDateTime();
				
				
				$service_reservation['service_name'] = "Gift Voucher Discount $".$promotion_code['value'];
				
				$service_reservation['partner_id'] = BESTPRICE_VIETNAM_ID;
				
				$service_reservation['start_date'] = $start_date;
					
				$service_reservation['end_date'] = $end_date;
				
				$service_reservation['selling_price'] = 0 - (int)$promotion_code['value']; // set later
				
				$service_reservation['destination_id'] = VIETNAM;
				
				
				$service_reservation['reservation_type'] = RESERVATION_TYPE_OTHER;
			
				
				// insert main service
				$this->db->insert('service_reservations', $service_reservation);
			
			}
			
		}
	}
	
	function create_or_get_booking_source($source){
		
		if ($source == NULL) return 0;
		
		$this->db->where('name', $source);

		$query = $this->db->get('booking_sources');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			
			return $results[0]['id'];
			
		} else {
			
			$src['name'] = $source;
		
			$this->db->insert('booking_sources', $src);
			
			$src_id = $this->db->insert_id();
			
			return $src_id;
			
		}
		
	}	
	
	function create_or_get_campaign($campaign){
		
		if ($campaign == NULL) return 0;
		
		$this->db->where('name', $campaign);

		$query = $this->db->get('campaigns');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			
			return $results[0]['id'];
			
		} else {
			
			$src['name'] = $campaign;
		
			$this->db->insert('campaigns', $src);
			
			$src_id = $this->db->insert_id();
			
			return $src_id;
			
		}
	}
	
	function get_medium($medium){
		
		$mediums = $this->config->item('mediums');
		
		foreach($mediums as $key => $value){
			
			if ($medium == translate_text($value)){
				
				return $key;
				
			}
			
		}
		
		return 0;
		
	}
	
	function get_customer_type($customer_id){
		
		$this->db->where('customer_id', $customer_id);
		
		$this->db->where('status', 6); // close win
		
		$this->db->where('deleted !=', DELETED);
		
		$nr = $this->db->count_all_results('customer_bookings');
		
		if ($nr > 0){
			
			return CUSTOMER_TYPE_RETURN;
			
		} else {
			
			return CUSTOMER_TYPE_NEW;
			
		}
		
	}
	
	function set_booking_source_data($customer_booking){
		
		return $customer_booking; // added by Khuyenpv 28.05.2015 when the website move to Hostmonster, fix PHP envirioment 
		
		
		if (!isset($_COOKIE["__utma"]) || !isset($_COOKIE["__utmz"])) {
			
			return $customer_booking;
		}
		
		$this->load->library('GA_Parse', $_COOKIE);
		
		$source = $this->ga_parse->campaign_source;
		
		$medium = $this->ga_parse->campaign_medium;
		
		$keyword = $this->ga_parse->campaign_term;
		
		$landing_page = $this->session->userdata('landing_page');
		
		$campaign = $this->ga_parse->campaign_name;
		
		$ad_content = $this->ga_parse->campaign_content;
		
		$first_visist = $this->ga_parse->first_visit;
		
		$previsous_visist = $this->ga_parse->previous_visit;
		
		$current_visist = $this->ga_parse->current_visit_started;
		
		$times_visited = $this->ga_parse->times_visited;
		
		$pages_viewed = $this->ga_parse->pages_viewed;
		
		
		$customer_booking['booking_source_id'] = $this->create_or_get_booking_source($source);		
		
		$customer_booking['medium'] = $this->get_medium($medium);
		
		$customer_booking['keyword'] = $keyword;
		
		if(!empty($landing_page)){
		
			$customer_booking['landing_page'] = $landing_page;

		}
		
		$customer_booking['campaign_id'] = $this->create_or_get_campaign($campaign);
		
		$customer_booking['ad_content'] = $ad_content;
		
		$customer_booking['date_first_visit'] = $this->timedate->format($first_visist, DB_DATE_TIME_FORMAT);
		
		$customer_booking['date_previous_visit'] = $this->timedate->format($previsous_visist, DB_DATE_TIME_FORMAT);
		
		$customer_booking['date_current_visit'] = $this->timedate->format($current_visist, DB_DATE_TIME_FORMAT);
		
		$customer_booking['times_visited'] = $times_visited;
		
		$customer_booking['current_pages_viewed'] = $pages_viewed;
		
		return $customer_booking;
		
	}
	
	function create_invoice($customer_id, $customer_booking_id, $type = VISA){
		
		$customer_booking = $this->get_customer_booking_selling_price($customer_booking_id);
		
		$booking_services = $this->get_services_of_invoice($customer_booking_id);
		
		$invoice_desc = '';
		if (count($booking_services) > 0){
			
			foreach ($booking_services as $value) {
				if($type != FLIGHT){
					$invoice_desc .= $value['service_name'] . ' - ' . $value['booking_services'].', '.date(DATE_FORMAT_DISPLAY, strtotime($value['start_date']));	
					$invoice_desc .= "\n";
				} else {
					if(!empty($value['flight_code'])){
						$invoice_desc .= $value['flight_code'].', '.$value['flight_from'].' -> '.$value['flight_to'].', '.date(DATE_FORMAT_DISPLAY, strtotime($value['start_date']));
						$invoice_desc .= ' ('.$value['booking_services'].')';
						$invoice_desc .= "\n";
					}
				}
			}
			
		}
		
		
		$bank_fee = $this->config->item('bank_fee');
		
		if ($customer_booking !== FALSE){
			
			$amount = round($customer_booking['selling_price'] * (1 + $bank_fee/100), 2);
			
			$invoice['status'] = INVOICE_NOT_PAID;
			
			$invoice['date_created'] = date(DB_DATE_TIME_FORMAT);
			
			$invoice['date_modified'] = date(DB_DATE_TIME_FORMAT);
			
			$invoice['amount'] = $amount;
			
			$invoice['customer_id'] = $customer_id;
			
			$invoice['customer_booking_id'] = $customer_booking_id;
			
			$invoice['description'] = $invoice_desc;
			
			$invoice['type'] = $type;
			
			$this->db->insert('invoices', $invoice);
			
			$id = $this->db->insert_id();			
			
			$invoice_reference = 'BPV_'.time();
			
			// update invoice reference
			
			$this->db->set('invoice_reference', $invoice_reference);
			
			$this->db->where('id', $id);
			
			$this->db->update('invoices');
			
			return $id;
			
		} else {
			
			return FALSE;
		}
		
	}
	
	function update_invoice_status($status, $invoice_reference){
		
		// update the invoice status
		$this->db->set('status', $status);
		
		$this->db->set('date_modified', date(DB_DATE_TIME_FORMAT));
		
		$this->db->where('invoice_reference', $invoice_reference);
		
		$this->db->update('invoices');
		
		
		// get the last updated invoiced
		$this->db->select('id, invoice_reference, customer_booking_id, status, amount');
		
		$this->db->where('invoice_reference', $invoice_reference);
		
		$this->db->order_by('date_modified');
		
		$query = $this->db->get('invoices');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			
			$invoice = $results[0];
			
			$status_text = '';
			
			if($invoice['status'] == INVOICE_NOT_PAID){
				
				$status_text = 'Not Paid';
				
			}elseif($invoice['status'] == INVOICE_PENDING){
				
				$status_text = 'Payment Pending';
				
			}elseif($invoice['status'] == INVOICE_SUCCESSFUL){
				
				$status_text = 'Payment Successful';
				
			}elseif($invoice['status'] == INVOICE_FAILED){
				
				$status_text = 'Payment Failed';
			}elseif($invoice['status'] == INVOICE_UNKNOWN){
				$status_text = 'Unknown';
			}
			
			// update the customer booking
			$this->db->set('note', $status_text);
			
			if($invoice['status'] == INVOICE_SUCCESSFUL){
				$this->db->set('onepay', $invoice['amount']);
				$this->db->set('booking_date', date(DB_DATE_FORMAT));
			}
			
			$this->db->where('id', $invoice['customer_booking_id']);
			
			$this->db->update('customer_bookings');
			
		}
	}
	
	function get_invoice_info($invoice_reference){
		
		$this->db->select('id, invoice_reference, amount, status, customer_id, customer_booking_id, date_created, type, description');
		
		$this->db->where('invoice_reference', $invoice_reference);
		
		$this->db->order_by('date_modified','desc');
		
		$query = $this->db->get('invoices');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			
			$invoice = $results[0];
			
			$invoice['customer'] = $this->get_customer($invoice['customer_id']);
			
			$invoice['customer_booking'] = $this->get_customer_booking_of_invoice($invoice['customer_booking_id']);
			
			return $invoice;
			
		} else {
			
			return FALSE;
			
		}
		
	}
	
	function get_invoice_4_payment($id){
		
		$this->db->select('id, invoice_reference, amount, customer_id, type, description');
		
		$this->db->where('id', $id);
		
		$this->db->order_by('date_modified','desc');
		
		$query = $this->db->get('invoices');
		
		$results = $query->result_array();
		
		if (count($results) > 0){
			
			$invoice = $results[0];
			
			$invoice['customer'] = $this->get_customer($invoice['customer_id']);
			
			return $invoice;
			
		} else {
			
			return FALSE;
			
		}
	}
	
	function get_customer_booking_selling_price($customer_booking_id){
		
		$this->db->select('selling_price');
		
		$this->db->where('id', $customer_booking_id);

		$query = $this->db->get('customer_bookings');
		
		$results = $query->result_array();
		
		if(count($results) > 0){
			
			return $results[0];
			
		} else {
			
			return FALSE;
		}
		
	}
	
	function get_customer($customer_id){
		
		$this->db->select('id, title, full_name, email, phone, fax, country, city, ip_address');
		
		$this->db->where('id', $customer_id);
		
		$query = $this->db->get('customers');
		
		$results = $query->result_array();
		
		if(count($results) > 0){
			
			return $results[0];
			
		} else {
			
			return FALSE;
		}
		
	}
	
	function get_customer_booking_of_invoice($customer_booking_id){
		
		$this->db->select('start_date, end_date, selling_price, booking_date, flight_short_desc, adults, children, infants, status, deleted');
		
		$this->db->where('id', $customer_booking_id);

		$query = $this->db->get('customer_bookings');
		
		$results = $query->result_array();
		
		if(count($results) > 0){
			
			$customer_booking = $results[0];
			
			$customer_booking['service_reservations'] = $this->get_services_of_invoice($customer_booking_id);
			
			$customer_booking['flight_users'] = $this->get_flight_users_of_cb($customer_booking_id);
			
			return $customer_booking;
			
		} else {
			
			return FALSE;
		}
		
	}
	
	function get_services_of_invoice($customer_booking_id){
		
		$this->db->select('id, start_date, end_date, service_name, selling_price, booking_services, unit, reservation_type, description, 
		airline, flight_code, flight_class, flight_from, flight_to, departure_time, arrival_time, fare_rules');
		
		$this->db->where('customer_booking_id', $customer_booking_id);
		
		$this->db->where('deleted !=', DELETED);
		
		$this->db->order_by('id','asc');

		$query = $this->db->get('service_reservations');
		
		$results = $query->result_array();
		
		foreach ($results as $key=>$value){
			
			$value['visa_users'] = $this->get_visa_users_of_sr($value['id']);
			
			$results[$key] = $value;
		}
		
		return $results;
	}
	
	function get_visa_users_of_sr($service_reservation_id){
		
		$this->db->where('service_reservation_id', $service_reservation_id);
		
		$this->db->order_by('name', 'asc');

		$query = $this->db->get('visa_users');
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function get_flight_users_of_cb($customer_booking_id){
		
		$this->db->where('customer_booking_id', $customer_booking_id);
		
		$this->db->order_by('id', 'asc');

		$query = $this->db->get('flight_users');
		
		$results = $query->result_array();
		
		return $results;
	}
	
	function update_vnisc_cb_id($customer_booking_id, $vnisc_cb_id){

		if(!empty($vnisc_cb_id)){
		
			$this->db->set('vnisc_cb_id', $vnisc_cb_id);
			
			$this->db->where('id', $customer_booking_id);
			
			$this->db->update('customer_bookings');
			
		}
		
	}
}