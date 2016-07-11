<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AboutUs extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->language(array('about', 'tour'));
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		redirect_case_sensitive_url('', ABOUT_US, false);
		
		//$this->session->set_userdata('MENU', MNU_ABOUT_US);			
		$data['metas'] = site_metas('about');
		$data['navigation'] = createAboutLink('about');
		
		$data['selected'] = 1;
		
		$data = $this->setFormData($data);
		
		$data['main_content'] = $this->load->view('about/about_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
		
		$this->load->view('template', $data);	
	}
	
	function setFormData($data) {
		
		$data['GLOBAL_DATAS'] = '';
		$data['inc_css'] = get_static_resources('about.min.190120151556.css');
		
		return $data;
	}
	
	function registration(){
		//$this->session->set_userdata('MENU', MNU_ABOUT_US);
		$data['metas'] = site_metas('registration');
		$data['navigation'] = createAboutLink('registration');
		
		$data['selected'] = 2;
	
		$data = $this->setFormData($data);
		
		$data['main_content'] = $this->load->view('about/registration_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
		
		$this->load->view('template', $data);	
	}
	
	function our_team(){
		
		$data['metas'] = site_metas('our_team');
		$data['navigation'] = createAboutLink('our_team');
	
		$data['selected'] = 4;
	
		$data = $this->setFormData($data);
	
		$data['main_content'] = $this->load->view('about/our_team_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
	
		$this->load->view('template', $data);
	}
	
	function policy(){
	
		$data['metas'] = site_metas('policy');
		$data['navigation'] = createAboutLink('policy');
	
		$data['selected'] = 3;
	
		$data = $this->setFormData($data);
	
		$data['main_content'] = $this->load->view('about/policy_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
	
		$this->load->view('template', $data);
	}
	
	function privacy(){
	
		$data['metas'] = site_metas('privacy');
		$data['navigation'] = createAboutLink('privacy');
	
		$data['selected'] = 6;
	
		$data = $this->setFormData($data);
	
		$data['main_content'] = $this->load->view('about/privacy_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
	
		$this->load->view('template', $data);
	}
	
	function contact(){
		
		//$this->session->set_userdata('MENU', MNU_CONTACT_US);	
		$data['metas'] = site_metas('contact');
		$data['navigation'] = createAboutLink('contact');
		
		$data['selected'] = 5;
		
		$data = $this->setFormData($data);

		$data['countries'] = $this->config->item("countries");
		if ($this->input->post('title')) {
			if ($this->_validateContact()) {
				if($this->_contact()) redirect(site_url().'thank_you_request/');				
			}
		}

		$data['main_content'] = $this->load->view('about/contact_view', $data, TRUE);
		$data['main'] = $this->load->view('about/main_view', $data, TRUE);
		
		$this->load->view('template', $data);	
	}

	function customize(){
	    
	    $this->load->model('TourModel');
	    
	    $this->load->helper('tour');
	    
	    $this->load->config('tour_meta');
		
		$this->session->set_userdata('MENU', MNU_CONTACT_US);	
		$data['metas'] = site_metas('customize');
		$data['navigation'] = createAboutLink('customize');
		
		$data['countries'] = $this->config->item("countries");
		
		$data['tour_customize_class'] = $this->config->item('tour_customize_class');
		
		$data['myanmar_tour_destinations'] = $this->config->item('myanmar_tour_destinations');
		
		$tour_url_title = $this->uri->segment(2);
		
		if (!empty($tour_url_title)){
			
			$tour = $this->TourModel->get_tour_obj_by_url_title($tour_url_title);
			
			$data['tour'] = $tour;
		}
		
		if ($this->input->post('title')) {
		    if ($this->_validateContact(true, $tour['duration'])) {
		        if($this->_contact(true)) redirect(site_url().'thank_you_request/');
		    }
		}
		
		$data = buildTourSearchCriteria($data);
		
		$arrival_date = $this->input->post('departure_date_customize');
		
		if(!empty($arrival_date)) $data['arrival_date'] = $arrival_date;
		
		
		$data['parent_dess'] = $this->TourModel->getTopParentDestinations();
		$data['dess'] = $this->TourModel->getTopDestinations();
		$tours_by_destination_view = $this->load->view('common/top_destination', $data, TRUE);
		$data['topDestinations'] = $tours_by_destination_view;
		
		$data['main'] = $this->load->view('about/customize_view', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('customize.min.16072013.css');
		$this->load->view('template', $data);	
		
	}
	
	function _setValidationRules()
	{
		$this->load->library('form_validation');
		$contact_rules = $this->config->item('contact_rules');		
		$this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');
		$this->form_validation->set_rules($contact_rules);
	}
	function _validateContact($is_customize = false, $tour_duration = null)
	{
		$this->_setValidationRules();
		
		if ($is_customize){
		    
		    if(!empty($tour_duration) && $tour_duration > 1) {
		        $this->form_validation->set_rules('tour_duration', 'Tour Duration', 'required');
		        $this->form_validation->set_rules('tour_accommodation', 'Tour Accommodation', 'required');
		    }
			
			$this->form_validation->set_rules('departure_day_check_rates', 'Arrival Date', 'required');			
			$this->form_validation->set_rules('departure_month_check_rates', 'Arrival Date', 'required');
			
			$this->form_validation->set_rules('message', lang('special_requests'), 'required');
		}
		
		return $this->form_validation->run();
		
	}	
	function _contact($is_customize = false) {
			$this->load->model(array('TourModel','CustomerModel'));
			// build contact info			
			$ct = $this->config->item("countries");
			// build customer info
			$contact['date_issue'] = date(DB_DATE_TIME_FORMAT, time());
			$contact['status'] = 0;//new
			$contact['title'] = $this->input->post('title');
			$contact['full_name'] = trim($this->input->post('full_name'));
			$contact['email'] = trim($this->input->post('email'));
			$contact['phone'] = trim($this->input->post('phone'));
			$contact['country'] = $this->input->post('country');
			$contact['city'] = trim($this->input->post('city'));
			
			$contact['subject'] = $this->input->post('subject');
			$contact['message'] = trim($this->input->post('message'));
			
			if ($is_customize){
				
				$str_customize = $this->load_customize_info();
				
				$str_customize = $str_customize. "\n". '------------------'. "\n";
			
				$contact['message'] = $str_customize. $contact['message'];
			}
				
			//echo $contact['message'];
			
			$contact['ip_address'] = $_SERVER['REMOTE_ADDR'];
			
			$id = $this->TourModel->createContact($contact);
			
			try {
				$this->CustomerModel->create_or_update_contact_booking($id);
			} catch (Exception $e) {
				//do nothing
			}
			
			$title = $contact['title'] == "1"?"Mr." : "Ms.";
			
			$contact_infor = 'Name: '.$title.$contact['full_name'] . "<br>";
			
			$contact_infor = $contact_infor."Country: ".$ct[$contact['country']][0]."<br>";
			
			$contact_infor = $contact_infor."City: ".$contact['city']. "<br>";
			
			$contact_infor = $contact_infor."Email: ".$contact['email']. "<br>";
			
			$contact_infor = $contact_infor."Phone: ".$contact['phone']. "<br>";
			
			$contact['message'] = $contact_infor.$contact['message'];
			
			$contact['message'] = str_replace("\n", "<br>", $contact['message']);
			
			//echo $contact['message'];
			
			$this->_sendMail($contact);
			
			//$this->_send_email_by_google_acc($contact);
			
			return true;
	}
	function _sendMail($contact) {
		$headers = 'From: ' . $contact['email'] . "\r\n";
		$headers .= "Content-type: text/html\r\n";
		//mail('service@' . strtolower(SITE_NAME), $contact['subject'], $contact['message'], $headers);
		mail('bestpricevn@gmail.com', $contact['subject'], $contact['message'], $headers);	
	}
	
	function _send_email_by_google_acc($contact){
		
		$this->load->library('email');
			
		/**
		 * Send to Bestpricevn@gmail.com
		 */
		
		$this->email->from($contact['email'], $contact['full_name']);
		$this->email->reply_to($contact['email']);
		$this->email->to('bestpricevn@gmail.com');
		$this->email->subject($contact['subject'].' - '.$contact['full_name']);
		$this->email->message($contact['message']);
		if (!$this->email->send()){			
			log_message('error', 'Contact Us - '.$contact['full_name'].': Can not send email to bestpricevn@gmail.com');
		}
		
		return true;
		
	}

	function company_address(){
		$this->load->view('about/company_address');
	}
	
	function load_customize_info(){
		
		$tour_name = $this->input->post('tour_name');
		
		$adults = $this->input->post('adults');
		
		$children = $this->input->post('children');
		
		$infants = $this->input->post('infants');
		
		$departure_date = $this->input->post('departure_date_customize');
		
		$tour_duration = $this->input->post('tour_duration');
		
		$tour_accommodation = $this->input->post('tour_accommodation');
		
		$destination_visit = $this->input->post('destination_visit');
		
		$str_customize = '';
		
		if ($tour_name != ''){
			
			$str_customize = $str_customize. 'Tour name: '. $tour_name. "\n";
			
		}
		
		$str_customize = $str_customize. 'People: '. $adults. ($adults > 1 ? ' adults' : ' adult');
		
		if ($children > 0){
			
			$str_customize = $str_customize. ', '. $children. ($children > 1 ? ' children' : ' child');
		}
		
		if ($infants > 0){
			
			$str_customize = $str_customize. ', '. $infants. ($infants > 1 ? ' infants' : ' infant');
		}
		
		$str_customize = $str_customize. "\n";
		
		$str_customize = $str_customize. "Arrival Date: ". $departure_date. "\n";
		
		if(!empty($tour_duration))
		{
		    $str_customize = $str_customize. "Duration: ". $tour_duration. ($tour_duration > 1 ? ' days' : ' day'). "\n";
		}
		
		if(!empty($tour_accommodation)) {
		    
		    $str_accom = $tour_accommodation;
		    
		    $tour_customize_class = $this->config->item('tour_customize_class');
		    
		    foreach ($tour_customize_class as $value)
		    {
		        if(strtolower(trim(lang($value['name']))) == strtolower(trim($tour_accommodation))) {
		            if(empty($value['price_to']))
		            {
		                $str_accom = $str_accom. ' ( >' . CURRENCY_SYMBOL . ($tour_duration * $value['price_from']) . ' )';
		            } else {
		                $str_accom = $str_accom . ' ( ' . CURRENCY_SYMBOL . ($tour_duration * $value['price_from']) . ' - ' . CURRENCY_SYMBOL . ($tour_duration * $value['price_to']) . ' )';
		            }
		            break;
		        }
		    }
		    
		    $str_customize = $str_customize. "Accommodation: ". $str_accom. "\n";
		}
		
		if ($destination_visit != '' && count($destination_visit) > 0){
			$str_customize = $str_customize. "Destination: ". implode("-", $destination_visit);
		}
		
		return $str_customize;
		
	}
	
	/**
	 *  tour_request
	 *
	 *  @author toanlk
	 *  @since  Oct 21, 2014
	 */
	function tour_request()
	{
	    $this->load->model(array('CustomerModel', 'TourModel'));
	     
	    $contact['date_issue'] = date(DB_DATE_TIME_FORMAT, time());
	    $contact['status'] = 0; // new
	    $contact['full_name'] = trim($this->input->post('full_name'));
	    $contact['email'] = trim($this->input->post('email'));
	    $contact['phone'] = trim($this->input->post('phone'));
	    
	    $contact['subject'] = 'Tour Request';
	    $contact['message'] = trim($this->input->post('message'));
	    
	    $contact['title'] = $this->input->post('title');
	    $contact['country'] = trim($this->input->post('country'));
	    
	    $tour_name = $this->input->post('tour_name');
	    
	    if ($tour_name != ''){
	         
	        $str_customize = '';
	        
	        $str_customize = $str_customize. '\nTour name: '. $tour_name. "\n";
	        
	        $str_customize = $str_customize .'\n------------------------------------' . "\n";
	        
	        $contact['message'] = $str_customize . $contact['message'];
	         
	    }
	
	    // echo $contact['message'];
	
	    $contact['ip_address'] = $_SERVER['REMOTE_ADDR'];
	
	    $id = $this->TourModel->createContact($contact);
	
	    try
	    {
	        $this->CustomerModel->create_or_update_contact_booking($id);
	    }
	    catch (Exception $e)
	    {
	        // do nothing
	    }
	
	    redirect(site_url().'thank_you_request/');
	}
}
?>