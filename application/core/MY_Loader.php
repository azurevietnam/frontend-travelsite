<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Fixed the Codeigniter for clear cached variables passed to view 
 * Each time calling load->view() the codeigniter will cache the variables passed to view
 * the next calling view will receive the variable from the previous calling 
 * => make error when load different views but access the same variale name
 * 
 * @author Khuyenpv
 * @since 22.06.2015
 */
class MY_Loader extends CI_Loader {
	
	public function view($view, $vars = array(), $return = FALSE){
		// clear the cached vars 
		$this->clear_cached_vars();
		return parent::view($view, $vars, $return);
	}
	
	/**
	 * Clear the Cached Vars passed to Views
	 */
	public function clear_cached_vars(){
		
		$this->_ci_cached_vars = array();	
	}
}