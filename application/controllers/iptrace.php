<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class iptrace extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();
       		
		$this->load->model(array('FaqModel'));
	}
	
	function index(){
		set_time_limit(60*60); 
		$this->FaqModel->traceIp();
		echo 'finish';
	}
}

?>