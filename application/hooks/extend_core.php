<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Extend_Core {
	
	public function __construct()
	{
		// do something in the future
	}
	
	public function display_cache_override(){
 		// do nothing for defautl cache override
	}
	
	public function custom_cache_override(){
		
		$CI =& get_instance();
	
		$CFG =& load_class('Config');
	
		$URI =& load_class('URI');
	
		$OUT =& load_class('Output');
	
		$action = $CI->input->get('action');
		
		// the mobile with diferrent view has its own cache folder
		if(is_mobile()){
			$CI->config->set_item('cache_path', APPPATH.'cachemobile/');
		} else {
			$CI->config->set_item('cache_path', APPPATH.'cache/');
		}
		 
		// only get cache if the page don't have action parameter
		if (empty($action)){
	
			if ($OUT->_display_cache($CFG, $URI) == TRUE)
			{
				exit;
			}
	
		}
	
	}	
}