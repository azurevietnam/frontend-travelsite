<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Lang extends CI_Lang {


  /**************************************************
   configuration
  ***************************************************/

  // languages
  private $languages = array(
	'en' => 'english',
    'es' => 'spanish',
    'fr' => 'french'
  );
  
  private $language_ids = array(
  	 'en' => 1,
     'es' => 2,
  	 'fr' => 3
  );
  
  private $locales = array(
  	 'en' => '',
  	 'es' => 'es_US.utf8',
  	 'fr' => 'fr_FR.utf8'
  );
  
  // sites
  private $sites = array(
  	'bestpricevn.com' => 'en',
  	'bestpricevn.es' => 'es',
  	'bestpricevn.fr' => 'fr'
  );
 
  /*
  private $sites = array(
  	'bpt-bpvn-com' => 'en',
  	'bpt-bpvn-es' => 'es',
  	'bpt-bpvn-fr' => 'fr'
  );*/
  
  
  // current seleted language code
  private $lang_code;
  
  private $lang_id;

  /**************************************************/

  function MY_Lang()
  {
    parent::__construct();

    global $CFG;
  
    /**
	 * Check the domain and set the corresponding language 
     */
    $current_domain = $this->current_domain();
    
    if(isset($this->sites[$current_domain])){
    	
    	$this->lang_code = $this->sites[$current_domain];
    	
    	//$CFG->set_item('base_url', 'http://www.'.$current_domain.'/');
    	
    	$CFG->set_item('base_url', 'http://new.'.$current_domain.'/');
    	
    } else {

    	$this->lang_code = 'en' ; // the default language is English
    }
    
    $this->lang_id = $this->language_ids[$this->lang_code];
	
    $language = $this->languages[$this->lang_code];
    
    $CFG->set_item('language', $language);
    
    $locale = $this->locales[$this->lang_code];
    
    setlocale(LC_TIME, $locale);
    
    //echo $this->lang_code . '<br>';
    
    //echo $locale. ' '. strftime('%d-%b-%Y', strtotime('22-12-2014'));
    
  }

  /**
   * Get the browser language
   */
  function browser_lang()
  {
  	
	$browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
	
	$browser_lang = substr($browser_lang, 0,2);
	
	return $browser_lang;
	
  }
  
  /**
   * Get the curren language code
   * @return string
   */
  function lang_code(){
  	
  	return $this->lang_code;
  	
  }
  
  /**
   * Get the current language id
   */
  function lang_id(){
  	return $this->lang_id;
  }
  
  /**
   * get the current used domain
   * @return unknown
   */
  function current_domain(){
  	

  	$domain_name = $_SERVER['HTTP_HOST'];
  	
  	if (empty($domain_name)){
  	
  		$domain_name = $_SERVER['SERVER_NAME'];
  	
  	}
  	
  	$domain_name = str_replace('www.', '', $domain_name);
  	
  	$domain_name = str_replace('new.', '', $domain_name);
  	 
  	//echo $domain_name;
  	
  	return $domain_name;
  	
  }

} 

// END MY_Lang Class

/* End of file MY_Lang.php */
/* Location: ./application/core/MY_Lang.php */
