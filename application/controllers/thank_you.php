<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thank_You extends CI_Controller {
	
	public function __construct()
    {
    	parent::__construct();
    	$this->load->model(array('TourModel','FaqModel','BestDealModel'));
    	$this->load->helper(array('form', 'tour', 'text', 'cookie', 'group', 'payment'));
    	$this->load->language(array('cruise','faq'));
	}
	
	function index()
	{			
		$data['metas'] = site_metas('home');
		$data['navigation'] = createMyBookingNavLink('Thank You');
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		$action = $this->uri->segment(1);
		
		/*if ($action == 'thank_you'){
		
			// show progress tracker bar
			$data['progress_tracker_id'] = 4;
			$data['progress_tracker'] = $this->load->view('common/progress_tracker', $data, TRUE);
		
		} else {
			$data['progress_tracker'] = '';
		}*/
		
		$data['progress_tracker'] = '';
	
		// get destination data
		$data = loadTopDestination($data);
	
		// load search block
		$data = buildTourSearchCriteria($data);
		
		$data = load_faq_by_context('31', $data);
		
		$data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');
		
		$data['main'] = $this->load->view('tours/booking_complete', $data, TRUE);
		$this->load->view('template', $data);
	}

    function success() {

        $data['payment_status'] = "Success";
        $this->_setFormData($data);
    }

    function pending() {

        $data['payment_status'] = "Pending";
        $this->_setFormData($data);
    }

    function unsuccess() {
        $data['payment_status'] = "Fail";

        $invoice = array();
        $invoice['amount']      = 30;
        $invoice['orderInfo']   = "BEST_A_".rand();
        $invoice['ticketNo']    = $_SERVER['REMOTE_ADDR'];

        $data['pay_url'] = get_payment_url($invoice);
        $this->_setFormData($data);
    }

    function _setFormData($data) {
        $metas['robots'] = "noindex,nofollow";
        $metas['title'] = "Thank you - ". BRANCH_NAME;
        $metas['keywords'] = "";
        $metas['description'] = "";
        $data['metas'] = $metas;

        // load why use view
        $data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
        // load search block
        $data = buildTourSearchCriteria($data);
        $data['NO_CART'] = true;

        $data['navigation'] = createMyBookingNavLink($data['payment_status']);
        $data['inc_css'] = get_static_resources('tour_booking.min.28102013.css');

        $data['main'] = $this->load->view('common/visa_confirm', $data, TRUE);
        $this->load->view('template', $data);
    }
}
?>