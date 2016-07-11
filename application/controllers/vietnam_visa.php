<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Vietnam Visa
 *
 * Landing page and check rates page
 *
 * @author toanlk
 * @since  Nov 14, 2014
 */
class Vietnam_Visa extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
		
		$this->load->library('form_validation');
		
		$this->load->language(array('faq', 'visa'));
		
		$this->load->model(array('FaqModel', 'VisaModel', 'BookingModel', 'CustomerModel'));

		$this->load->helper(array('form', 'tour', 'text', 'cookie', 'group', 'visa', 'payment'));
		
	}
	
	function index()
    {
        $data = $this->_setFormData();
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa');
        
        $data['navigation'] = createVisaHomeNavLink(true);
        
        $data['countries'] = $this->VisaModel->getAllNationalities();;
        
        redirect_case_insensitive_url();
        
        $data['main'] = $this->load->view('visa/main_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function _setFormData($data = array())
    {
        // highlight menu
        $this->session->set_userdata('MENU', MNU_VN_VISA);
        
        // get destination data
        $data = loadTopDestination($data);
        
        // get faqs
        $data = get_visa_faqs($data);
        
        $data['how_it_works'] = $this->load->view('visa/common/how_it_works', $data, TRUE);
        
        // Get all normal nationalities
        $data['countries'] = $this->VisaModel->getAllNationalities(true);
        
        $data['max_application'] = $this->config->item("max_application");
        
        $data['types'] = $this->config->item("visa_types");
        
        $data['rush_services'] = $this->config->item("rush_services");
        
        $data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
        
        $data['top_visa_questions'] = $this->load->view('visa/common/top_visa_questions', $data, TRUE);
        
        // apply form
        $data['apply_form_small'] = $this->load->view('visa/check_rates/apply_form_small', $data, TRUE);
        
        // CSS and JS
        $data = get_visa_theme($data);
        
        /*
         * For Booking Together Recommendation
         */
        $data = get_booking_together_recommend($data);
        
        return $data;
    }

    function apply_visa()
    { 
        $data = $this->_setFormData();
        
        $data['breadcrumb_pos'] = 1;
        
        $data['breadcrumb'] = $this->load->view('visa/common/breadcrumb', $data, TRUE);
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa');
        
        $data['navigation'] = createVisaGuideNavLink('apply_visa');
        
        $visa_req_nationality = $this->input->post('visa_req_nationality');
        
        if (isset($visa_req_nationality) && ! empty($visa_req_nationality))
        {
            $data['visa_req_nationality'] = $visa_req_nationality;
        }
        
        $data['check_rate_view'] = $this->load->view('visa/check_rate_view', $data, TRUE);
        
        redirect_case_insensitive_url(true);
        
        $data['main'] = $this->load->view('visa/apply_visa', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function vietnam_visa_details()
    {
        $action = $this->input->post('action');
        
        if ($action == 'add_to_cart' || $action == 'check_out')
        {
            $this->_save($action);
        }
        else if ($action == 'book' || $action == 'update')
        {
            $visa_booking = _create_visa_booking();
        }
        
        $data = $this->_setFormData();
        
        $data['is_visa_details'] = true;
        
        $data['breadcrumb_pos'] = 1;
        
        $data['breadcrumb'] = $this->load->view('visa/common/breadcrumb', $data, TRUE);
        
        $visa_booking = _get_visa_booking();

        if (empty($visa_booking))
        {
            redirect(url_builder('', VIETNAM_VISA));
        }
        
        $data['rowId'] = $visa_booking['rowId'];
        
        $data['visa_booking'] = $visa_booking;
        
        $data['NO_CART'] = true;
        
        // set site meta and navigation
        $data['metas'] = site_metas('visa_apply');
        
        $data['navigation'] = createVisaDetailNavLink('visa_details');
        
        // Airport configs
        $data['airports'] = $this->config->item("airports");
        
        // get visa booking from cart
        $data['numb_visa'] = $visa_booking['number_of_visa'];
        
        // get receive date
        $receive_date = get_visa_receive_date($visa_booking['processing_time']);
        
        $data['receive_date'] = get_receive_date_lang($receive_date);
        
        $data['check_rate_view'] = $this->load->view('visa/check_rates/check_rates_min', $data, TRUE);
        
        redirect_case_insensitive_url(true);
        
        $data['main'] = $this->load->view('visa/visa_details_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function _save($action)
    {
        $rowId = $this->input->post('rowId');

        $visa_booking = _get_visa_booking($rowId);
        
        $number_of_visa = $visa_booking['number_of_visa'];
        
        if ($this->_validateBooking($number_of_visa))
        {
            // save visa booking to the session
            $visa_booking = _update_visa_details($visa_booking, true);
            
            // redirect to my booking
            if ($action == 'check_out')
            {
                redirect(site_url() . 'vietnam-visa/payment.html');
            }
            elseif ($action == 'add_to_cart')
            {
                // insert visa to cart
                insert_visa_to_cart($visa_booking);
                
                // clear visa booking session
                // _clear_visa_booking();
                
                redirect(site_url() . 'my-booking/');
            }
        }
    }

    function get_visa_rates()
    {
        $visa_rates = _get_rate_of_visa();
        
        echo json_encode($visa_rates);
    }

    function _setValidationRules($number_of_visa)
    {
        $this->load->library('form_validation');
        
        $this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
        
        $applicant_rules = $this->config->item('applicant_rules');
        $this->form_validation->set_rules($applicant_rules);
        
        $this->form_validation->set_rules('visa_nationality', 'visa_nationality', 'required');
        $this->form_validation->set_rules('numb_visa', 'numb_visa', 'required');
        $this->form_validation->set_rules('visa_type', 'visa_type', 'required');
        $this->form_validation->set_rules('rush_service', 'rush_service', 'required');
        
        for ($i = 1; $i <= $number_of_visa; $i ++)
        {
            $this->form_validation->set_rules('nationality' . $i, 'Nationality', 'required');
            $this->form_validation->set_rules('gender' . $i, 'Gender', 'required');
            $this->form_validation->set_rules('birth_day' . $i, 'birth_day', 'required');
            $this->form_validation->set_rules('birth_month' . $i, 'birth_month', 'required');
            $this->form_validation->set_rules('birth_year' . $i, 'birth_year', 'required');
            
            $this->form_validation->set_rules('passport_name' . $i, 'Passport Name', 'required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('birthday' . $i, 'Date of Birth', 'required|callback_is_valid_birthday');
            $this->form_validation->set_rules('passport_number' . $i, 'Passport Number', 'required|alpha_numeric');
        }
    }

    function _validateBooking($number_of_visa)
    {
        $this->_setValidationRules($number_of_visa);
        
        return $this->form_validation->run();
    }

    function is_valid_date($d)
    {
        if (trim($d) != '' && ! $this->timedate->is_date($d))
        {
            $this->form_validation->set_message('is_valid_date', 'The Arrival Date field must be a valid date');
            return false;
        }
        
        if (strtotime($d) <= strtotime('today'))
        {
            $this->form_validation->set_message('is_valid_date', 'The Arrival Date field must be in the future');
            return false;
        }
        
        $processing_time = $this->input->post('visa_type');
        
        if (! is_allow_online_payment($d, $processing_time))
        {
            $this->form_validation->set_message('is_valid_date', 'Your date of arrival must be greater than the date of receive visa');
            return false;
        }
        
        return true;
    }

    function is_valid_expired_date($d)
    {
        
        // set timezone
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        if (trim($d) != '' && ! $this->timedate->is_date($d))
        {
            $this->form_validation->set_message('is_valid_expired_date', 'The Passport Expired field must be a valid date');
            return false;
        }
        
        // Passport expired must valid at least 6 months
        $arrival_date = $this->input->post('arrival_date');
        
        if ($this->timedate->is_date($arrival_date))
        {
            if (strtotime($d) < strtotime($arrival_date . ' + 6 months'))
            {
                $this->form_validation->set_message('is_valid_expired_date', 'The Passport Expired field must be valid at least 6 months');
                return false;
            }
        }
        
        return true;
    }

    function is_valid_birthday($d)
    {
        if (! (strtotime($d) < strtotime('today')))
        {
            $this->form_validation->set_message('is_valid_birthday', 'The Date of Birth field must be in the past');
            return false;
        }
    }

    public function compare_subm_dates()
    {
        $exit_date = $this->input->post('exit_date');
        $arrival_date = $this->input->post('arrival_date');
        
        if (strtotime($exit_date) <= strtotime($arrival_date))
        {
            $error_message = 'The Exit Date must be greater than the Arrival Date.';
            $this->form_validation->set_message('compare_subm_dates', $error_message);
            return false;
        }
        
        return true;
    }
    
    /*
     * get_receive_date
     */
    public function get_receive_date()
    {
        $processing_type = $this->input->post('rush_service');
        
        $receive_date = get_visa_receive_date($processing_type, '', 'd M Y');
        echo $receive_date;
        
        /*
         * $status = '0'; $msgPayment = ''; $processing_type = $this->input->post('rush_service'); $arrival_date = $this->input->post('arrival_date'); if ($this->timedate->is_date($arrival_date)) { $is_allow = is_allow_online_payment($arrival_date, $processing_type); if($is_allow) { $status = '1'; } else { $msgPayment = " Your date of arrival should be greater than the date of receive visa"; } } //$receive_date = get_visa_receive_date($processing_type); //$receive_date = lang('receive_date') . '<b>' . $receive_date . '</b>' . ' (GMT+7)'; $payment_details = array('online_payment' => $status, 'msgPayment' => $msgPayment); echo json_encode($payment_details);
         */
    }

    function visa_payment()
    {
        $this->session->set_userdata('MENU', MNU_VN_VISA);
        
        $metas['robots'] = "noindex,nofollow";
        $metas['title'] = lang('visa_payment') . " - " . BRANCH_NAME;
        $metas['keywords'] = "";
        $metas['description'] = "";
        $data['metas'] = $metas;
        
        // get visa booking in session
        $visa_booking = _get_visa_booking();
        
        // recalculate price
        $visa_booking = get_visa_booking_price($visa_booking);
        
        // if session is empty get in shopping cart
        if (empty($visa_booking) && is_allow_online_payment_4_visa_in_shopping_cart())
        {
            $visa_booking = get_first_visa_booking_in_cart();
        }
        
        // check visa booking
        
        if (! check_visa_booking($visa_booking))
        {
            redirect(site_url() . 'vietnam-visa/');
        }
        
        $action = $this->input->post('action');
        
        if ($action == 'pay')
        {
            $visa_booking = $this->_payonline();
        }
        
        $data['visa_booking'] = $visa_booking;
        
        $data['my_booking'] = $this->get_my_booking($visa_booking);
        
        // Get all normal nationalities
        $data['visa_countries'] = $this->VisaModel->getAllNationalities(true);
        
        $data['NO_CART'] = true;
        
        $data['breadcrumb_pos'] = 2;
        
        $data['breadcrumb'] = $this->load->view('visa/common/breadcrumb', $data, TRUE);
        
        // Get all configs
        
        $data['visa_types'] = $this->config->item('visa_types');
        
        $data['rush_services'] = $this->config->item('rush_services');
        
        $data['bank_fee'] = $this->config->item('bank_fee');
        
        $data['countries'] = $this->config->item('countries');
        
        $data['airports'] = $this->config->item("airports");
        
        // Get receive date
        $receive_date = get_visa_receive_date($visa_booking['processing_time']);
        
        $data['receive_date'] = get_receive_date_lang($receive_date);
        
        $data['navigation'] = createVisaGuideNavLink(lang('visa_payment'), true);
        
        $data = get_visa_theme($data, false);
        
        $data['inc_js'] = get_static_resources('visa.min.120120151211.js,payment.min.120120151211.js');
        
        $data['main'] = $this->load->view('visa/payment/main_view', $data, TRUE);
        
        $this->load->view('template', $data);
    }

    function _validateApplicant($number_of_visa)
    {
        $this->_setVisaValidationRules($number_of_visa);
        
        return $this->form_validation->run();
    }

    function _validateVisaBooking()
    {
        $this->_setVisaValidationRules();
        return $this->form_validation->run();
    }

    function _setVisaValidationRules($number_of_visa = 0)
    {
        $this->load->library('form_validation');
        
        if (empty($number_of_visa))
        {
            $booking_rules = $this->config->item('booking_rules');
            $this->form_validation->set_message('required', 'The %s field is required.');
            $this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
            $this->form_validation->set_rules($booking_rules);
        }
        else
        {
            $this->form_validation->set_message('required', 'class="bg_error"');
            $this->form_validation->set_error_delimiters('', '');
            
            for ($i = 0; $i < $number_of_visa; $i ++)
            {
                $this->form_validation->set_rules('nationality' . $i, 'nationality', 'required');
                $this->form_validation->set_rules('gender' . $i, 'Gender', 'required');
                $this->form_validation->set_rules('birth_day' . $i, 'birth_day', 'required');
                $this->form_validation->set_rules('birth_month' . $i, 'birth_month', 'required');
                $this->form_validation->set_rules('birth_year' . $i, 'birth_year', 'required');
                $this->form_validation->set_rules('passport_name' . $i, 'passport_name', 'required');
                $this->form_validation->set_rules('birthday' . $i, 'birthday', 'required');
                $this->form_validation->set_rules('passport_number' . $i, 'passport_number', 'required');
            }
        }
    }

    function _payonline()
    {
        $visa_booking = _get_visa_booking();
        $number_of_visa = $visa_booking['number_of_visa'];
        
        if (! (isset($visa_booking['detail_type']) && $visa_booking['detail_type'] == 2))
        {
            if (! $this->_validateApplicant($number_of_visa))
            {
                return false;
            }
            else
            {
                // update visa details
                $visa_booking = _update_visa_details($visa_booking);
                
                $visa_booking = get_visa_booking_price($visa_booking);
            }
        }
        
        if ($this->_validateVisaBooking())
        {
            
            // $reservation_infos = get_my_reservations();
            
            /**
             * SET RESERVATION INFO FROM VISA BOOKING
             */
            $reservation_infos = get_reservations_from_visa_booking($visa_booking);
            
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
            
            $customer_booking_id = $this->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request);
            
            if ($customer_booking_id !== FALSE)
            {
                
                /**
                 * REMOVE BOOKING ITEM FROM THE SHOPPING CART
                 */
                
                if (is_allow_online_payment_4_visa_in_shopping_cart())
                {
                    $this->cart->destroy();
                }
                
                // create invoice
                $invoice_id = $this->CustomerModel->create_invoice($customer_id, $customer_booking_id);
                
                if ($invoice_id === FALSE)
                { // false to create invoice
                                            
                    // clear visa session
                    _clear_visa_booking();
                    
                    // show thank you page as normal submit
                    redirect(site_url() . 'thank_you/');
                }
                else
                {
                    
                    // get invoice detail and call payment module
                    $invoice = $this->CustomerModel->get_invoice_4_payment($invoice_id);
                    
                    // send email to customer
                    $this->_send_mail($reservation_infos, $cus, $special_request, $invoice['invoice_reference'], $visa_booking, false);
                    
                    // $this->_send_email_by_google_acc($reservation_infos, $cus, $special_request, false);
                    
                    // call payment module with the invoice input
                    $pay_url = get_payment_url($invoice);
                    
                    // clear visa session
                    _clear_visa_booking();
                    
                    redirect($pay_url);
                }
            }
        }
        
        return $visa_booking;
    }

    function _send_mail($reservation_infos, $cus, $special_request, $invoice_reference, $visa_booking, $is_send_customer = true)
    {
        $data['my_booking'] = get_booking_items_from_visa_booking($visa_booking);
        
        // usort($data['my_booking'], array($this,"sortBooking"));
        
        $customer_booking = $reservation_infos['customer_booking'];
        ;
        
        $data['customer_booking'] = $customer_booking;
        $data['customer_booking']['tour_name'] = $reservation_infos['service_reservations'][0]['service_name'];
        $data['customer_booking']['special_request'] = $special_request;
        $data['invoice_reference'] = $invoice_reference;
        
        $countries = $this->config->item('countries');
        $cus['country_name'] = $countries[$cus['country']][0];
        $config_title = $this->config->item('title');
        $cus['title_text'] = $config_title[$cus['title']];
        
        $headers = "Content-type: text/html\r\n";
        
        $header_cus = 'From: ' . $cus['email'] . "\r\n" . $headers;
        $header_bpt = 'From: ' . BRANCH_NAME . ' <reservation@' . strtolower(SITE_NAME) . '>' . "\r\n" . $headers;
        
        $subject_cus = 'Autoreply: ' . $data['customer_booking']['tour_name'] . ' - ' . BRANCH_NAME;
        $subject_bpt = 'Reservation: ' . $data['customer_booking']['tour_name'] . ' - ' . $cus['full_name'];
        
        $data['cus'] = $cus;
        
        $data['popup_free_visa'] = $this->load->view('ads/popup_free_visa', $data, true);
        $content = $this->load->view('common/my_booking_form_mail', $data, TRUE);
        
        // echo $content;exit();
        
        // mail('reservation@'.strtolower(SITE_NAME), $subject_bpt, $content, $header_cus);
        mail(VISA_PAYMENT_NOTIFICATION_EMAIL, $subject_bpt, $content, $header_cus);
        
        /*
         * if (count($data['my_booking']) > 0 && $is_send_customer){ mail($cus['email'], $subject_cus, $content, $header_bpt); }
         */
        
        return true;
    }

    function get_my_booking($visa_booking)
    {
        $visa_types = $this->config->item('visa_types');
        
        $rush_services = $this->config->item('rush_services');
        
        $bank_fee = $this->config->item('bank_fee');
        
        $options = array();
        
        $options['start_date'] = $visa_booking['arrival_date'];
        
        $options['end_date'] = $visa_booking['exit_date'];
        
        $service_name = lang('vietnam_visa') . ': <br>';
        
        $service_name .= translate_text($visa_types[$visa_booking['type_of_visa']]) . ' - ' . translate_text($rush_services[$visa_booking['processing_time']]);
        
        $service_name .= ' - '.lang('label_arrival').' ' . date(DATE_FORMAT_DISPLAY, strtotime($options['start_date']));
        
        $options['service_name'] = $service_name;
        
        $options['unit'] = $visa_booking['number_of_visa'] . ($visa_booking['number_of_visa'] > 1 ? ' '.lang('label_visas') : ' '.lang('label_visa'));
        
        $options['selling_price'] = number_format($visa_booking['total_price'], CURRENCY_DECIMAL);
        
        $options['final_total'] = round($visa_booking['total_price'], CURRENCY_DECIMAL) + number_format($visa_booking['total_price'] * $bank_fee / 100, 2);
        
        return $options;
    }
} 
?>
