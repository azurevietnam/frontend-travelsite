<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Partners extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->model(array('TourModel'));
		$this->load->helper('url');
		$this->load->library('pagination');
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{	
		redirect_case_sensitive_url('', PARTNERS, false);
		$this->session->set_userdata('MENU', MNU_PARTNERS);
		
		$data = array();
		$data = $this->_setFormData($data);
		
		$this->load->view('template', $data);		
	}
	
	function _setFormData($data) {
		
		$data['metas'] = site_metas(PARTNERS_META);
		/* $uri_segment = 3;
		 $offset = (int)$this->uri->segment($uri_segment, 0);
		$total = $this->TourModel->countPartners();
		
		$per_page = $this->config->item('partner_per_page');
		$data['partners'] = $this->TourModel->getPartners($per_page, $offset);
		
		if(!empty($data['partners'])) {
		$config = get_paging_config($total, PARTNERS.'index/', $uri_segment);
		$config['num_links'] = 5;
		$this->pagination->initialize($config);
		
		$data['paging_text'] = get_paging_text($total, $offset, $per_page);
		} */
		$type = 1;
		$partner_type = $this->uri->segment(2);
		$nav_text = 'Partners';
		
		if(!empty($partner_type)) {
			$type = $this->getPartType($partner_type);
		}
		
		$partner_count = $this->TourModel->countParners();
		$partner_types = $this->config->item('partner_types');

		// check partners list is empty or not		
		foreach ($partner_types as $key => $value) {
			foreach ($partner_count as $p_count) {
				$name = strtolower(translate_text($value));
				if($p_count['type'] == $name && $p_count['count'] < 1) {
					$partner_types[$key] = '';
				}
			}	
			if($type == $key) {
				$nav_text = translate_text($value);
			}
		}
		$data['partner_types'] = $partner_types;
		
		$partner_href = array();
		foreach ($partner_types as $key => $value) {
			$partner_href[$key] = $this->getPartType('', $key);
		}
		$data['partner_href'] = $partner_href;
		
		$data['navigation'] = createPartnerLink(true, $nav_text);
		
		// get partner by type
		$types = array($type);
		$data['partners'] = $this->TourModel->getPartners($types);
		$data['partner_type'] = $type;
		
		$data['main'] = $this->load->view('about/partners_view', $data, TRUE);
		
		$data['inc_css'] = get_static_resources('partner.min.15082013.css');
		
		return $data;
	} 
	
	function getPartType($partner_type='', $type='') {
		if(!empty($partner_type)) {
			switch ($partner_type) {
				case 'cruise':
					$type = 1;
					break;
				case 'tour':
					$type = 2;
					break;
				case 'hotel':
					$type = 3;
					break;
				case 'transfer':
					$type = 4;
					break;
				case 'visa':
					$type = 5;
					break;
				default:
					$type = 1;
					break;
			}
			
			return $type;
		}
		
		if(!empty($type)) {
			switch ($type) {
				case 2:
					$partner_type = 'tour';
					break;
				case 3:
					$partner_type = 'hotel';
					break;
				case 4:
					$partner_type = 'transfer';
					break;
				case 5:
					$partner_type = 'visa';
					break;
				default:
					$partner_type = '';
					break;
			}
			
			return $partner_type;
		}
	}
	
	
	function hotel() {
		$data = array();
		$data = $this->_setFormData($data);
		
		$this->load->view('template', $data);
	}
	
	function tour() {
		$data = array();
		$data = $this->_setFormData($data);
		
		$this->load->view('template', $data);
	}
	
	function transfer() {
		$data = array();
		$data = $this->_setFormData($data);
		
		$this->load->view('template', $data);
	}
	
	function visa() {
		$data = array();
		$data = $this->_setFormData($data);
		
		$this->load->view('template', $data);
	}
}
?>