<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include("geoip.inc");
include("geoipcity.inc");
include("geoipregionvars.php");
include("Mobile_Detect.php");

function get_ip()
 {
	 if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	 {
	 	$ip=$_SERVER['HTTP_CLIENT_IP'];
	 }
	 elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	 {
	 	$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	 }
	 else
	 {
	 	$ip=$_SERVER['REMOTE_ADDR'];
	 }
 	return $ip;
 }


function trace_client_ip(){
	try {
		$CI =& get_instance();
		
		if (!$CI->session->userdata('flag_28082013')){
			
			$ip = get_ip();
			
			// open GeoIP.dat
			// $open = geoip_open("GeoIP.dat", GEOIP_STANDARD);
			$open = geoip_open("GeoLiteCity.dat", GEOIP_STANDARD);
			
			//$country_code = geoip_country_code_by_addr($open, $ip);
			$record = geoip_record_by_addr($open,$ip);
			
			$country_code = isset($record->country_code) ? $record->country_code : ''; 		
			$city = isset($record->city) ? $record->city : '';
			
			//set user country and city to session
			
			$CI->session->set_userdata('user_country_code', $country_code);
			
			$CI->session->set_userdata('user_city', $city);
			
			 // close database handler
			geoip_close($open);
			
		} 
		
		$CI->session->set_userdata('flag_28082013', 'yes');
		
		save_ip_to_db($CI);
		
		save_landing_page($CI);
		
		custom_cache_override($CI);
	
	} catch (Exception $e) {
		// do nothing
	}
}

function save_ip_to_db($CI){
	//echo $country_code;

	$ip = get_ip();
	
	$country_code = $CI->session->userdata('user_country_code');
			
	$city = $CI->session->userdata('user_city');
			
	if ($country_code != ''){
		
		$ip_trace = array();
		
		$ip_trace['access_date'] = date(DB_DATE_TIME_FORMAT);

		$ip_trace['ip'] = $ip;
		
		$ip_trace['isp'] = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER'] : '';
		
		$ip_trace['isp'] = $ip_trace['isp']. isset($_SERVER['REQUEST_URI'])? ' - '.$_SERVER['REQUEST_URI'] : '';
		
		$ip_trace['org'] = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
		
		$ip_trace['region'] = $city;
		
		$ip_trace['country_code'] = $country_code;
		
		if (in_array($ip_trace['country_code'], $CI->config->item('ip_trace_country_code')) && ($city == '' || in_array($city, $CI->config->item('ip_trace_city')))){
			
			// only save IP click from Google adword
			if (!empty($_GET['gclid'])){
				
				$CI->db->insert('ip_traces', $ip_trace);
			
			}
		}
		
	}
}

function save_landing_page($CI){
	
	if ( ! $CI->input->is_ajax_request())
    {
		// New visit by session expired
		if (!isset($_COOKIE["__utmb"])){
		
			$landing_page = isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : '';
			
			if ($landing_page != ''){
				
				$CI->session->set_userdata('landing_page', $landing_page);
				
			}
		
        } else {        	
        	// new visit by changing search campaign
        	
        	
        	
        }
		
	}
	
}

function display_cache_override(){
 	// do nothing for defautl cache override
}

function custom_cache_override($CI){
	
	$country_code = $CI->session->userdata('user_country_code');
			
	$city = $CI->session->userdata('user_city');
        
    $CFG =& load_class('Config');
    
    $URI =& load_class('URI');
    
    $OUT =& load_class('Output');
    
    if ($country_code != '' && $city != ''){
    
	   if (in_array($country_code, $CI->config->item('ip_trace_country_code')) && in_array($city, $CI->config->item('ip_trace_city'))){
	    	
	    	$CI->config->set_item('cache_path', APPPATH.'cachehanoi/');
	    	
	   }
    
  	}
  	
	$app_context = $CI->session->userdata('APP_CONTEXT'); 
			
	if (isset($app_context) && isset($app_context['user'])){
		$CI->config->set_item('cache_path', APPPATH.'cache/');
	}
  	
  	$action = $CI->input->post('action_type');
  	
  	// only get cache if the page is not check rate
  	if ($action == '' || $action != 'check_rate'){
  		
	  	if ($OUT->_display_cache($CFG, $URI) == TRUE)
		{
			exit;
		}
  		
  	} 

}

function set_departure_date(){
	
	$CI =& get_instance();
	
	if ( ! $CI->input->is_ajax_request())
    {
    	
		// departure date for tour
		$search_criteria = $CI->session->userdata("FE_tour_search_criteria");
	  	
	  	if (!empty($search_criteria) && isset($search_criteria['departure_date'])){
	  		
	  		setcookie('departure_date', $search_criteria['departure_date'], time() + 60 * 60, '/');
	  		
	  	} else {
	  		
	  		setcookie('departure_date', date('d-m-Y'), time() + 60 * 60, '/');
	  	}
	
	  	// arrival date for hotel
	  	
		$search_criteria = $CI->session->userdata("FE_hotel_search_criteria");
	  	
	  	if (!empty($search_criteria) && isset($search_criteria['arrival_date'])){
	  		
	  		setcookie('arrival_date', $search_criteria['arrival_date'], time() + 60 * 60, '/');
	  		
	  	} else {
	  		
	  		setcookie('arrival_date', date('d-m-Y'), time() + 60 * 60, '/');
	  	}
  	
    }
}

function get_web_current_url(){
	
	$CI =& get_instance();
	
	$query = $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : '';
	
	return $CI->config->site_url().$CI->uri->uri_string(). $query;
	
}

function redirect_mobile(){

	if(lang_code() != 'en') return; // only redirect mobile for the English version
	
	/*
	$detect = new Mobile_Detect();
	
	$is_smart_phone = $detect->isMobile() && !$detect->isTablet();
	
	if($is_smart_phone){
		
		$CI =& get_instance();
		
		$current_url = get_web_current_url();
		
		$current_url = str_replace("//www.", "//m.", $current_url);
		
		redirect($current_url, 'location', 301);
		
	}*/
	

	$CI =& get_instance();
	
	$current_url = get_web_current_url();
	
	//echo $current_url;exit();
	
	$current_url = str_replace("//www.", "//m.", $current_url);
	
	/*
	if (strpos(".html", $current_url) === FALSE){
		
		if (substr($current_url, -1) != '/'){
		
			$current_url = $current_url.'/';
		
		}
	}*/
	
	if (empty($_COOKIE["is_smart_phone"])){
		
		$detect = new Mobile_Detect();
		
		$is_smart_phone = $detect->isMobile() && !$detect->isTablet();
		
		$is_smart_phone = $is_smart_phone ? 'smart-phone' : 'desktop';
		
		setcookie('is_smart_phone',$is_smart_phone, time() + 60 * 60 * 24, '/');
	
	} else {
		
		$is_smart_phone = $_COOKIE["is_smart_phone"];
	}
	
	if ($is_smart_phone == 'smart-phone') {
		
		if (empty($_COOKIE["smart_phone_redirected"])){
			
			setcookie('smart_phone_redirected',1, time() + 60 * 60 * 24, '/');
			
			redirect($current_url, 'location', 301);
		}
	}
}