<?php

class Generate_Sitemap extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->model('TourModel');
	

		// for test only - will replace by session data from login module
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{		
		$xml_sitemap = '';
		$xml_doctag = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml_openroot = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';	
		$xml_closeroot = '</urlset>';
		$xml_sitemap = $xml_doctag . "\n" . $xml_openroot;
		$xml_sitemap .= $this->create_home_url() . $this->create_hotel_home_url() . $this->create_tour_home_url();
		$dess = $this->TourModel->getTopDestinations();
		foreach ($dess as $des) {
			$xml_sitemap .= $this->create_tour_destination_url($des['url_title']);
		}
		$cats = $this->TourModel->getAllCategories('');
		foreach ($cats as $cat) {
			$xml_sitemap .= $this->create_tour_travelstyle_url($cat);
		}
		$xml_sitemap .= $this->create_halongcruises_cat_url() . $this->create_mekongriver_cat_url();
		
		
		$tours = $this->TourModel->getAllToursForSitemap();
		foreach ($tours as $tour) {
			$xml_sitemap .= $this->create_tour_detail_url($tour['url_title']);
		}
		$xml_sitemap .= $this->create_partners_url();
		$xml_sitemap .= "\n" . $xml_closeroot;
		
		$ourFileName = "Sitemap.xml";
		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fwrite($ourFileHandle, $xml_sitemap);
		fclose($ourFileHandle);

		echo 'Success generate sitemap!';
	}
	function create_url($loc, $lastmod, $changefreq, $priority) {
		$url = "\n" . '<url>' . "\n" 
				. '<loc>' . $loc . '</loc>' . "\n" 
				. '<lastmod>' . $lastmod . '</lastmod>' . "\n"
				. '<changefreq>' . $changefreq . '</changefreq>' . "\n"
	      		. '<priority>' . $priority . '</priority>' . "\n"
	    		. '</url>';
		return $url;
	}
	function create_home_url(){
		return $this->create_url(site_url(), date('Y-m-d'), 'daily', '1.0');
	}
	function create_hotel_home_url(){
		return $this->create_url(site_url('hotels') . '/', date('Y-m-d'), 'daily', '0.9');
	}
	function create_tour_home_url(){
		return $this->create_url(site_url(TOUR_HOME) . '/', date('Y-m-d'), 'daily', '0.9');
	}
	function create_tour_destination_url($url_title){
		return $this->create_url(site_url(url_builder(MODULE_TOURS, $url_title . '-' . MODULE_TOURS, false)) . '/', date('Y-m-d'), 'daily', '0.9');
	}
	function create_tour_travelstyle_url($cat){
		return $this->create_url(site_url($cat['url_title']) . '/', date('Y-m-d'), 'daily', '0.8');
	}
	
	function create_halongcruises_cat_url(){
		$luxury = $this->create_url(site_url(LUXURY_HALONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		$deluxe = $this->create_url(site_url(DELUXE_HALONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		$cheap = $this->create_url(site_url(CHEAP_HALONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		return $luxury . $deluxe . $cheap;
	}
	function create_mekongriver_cat_url(){
		$luxury = $this->create_url(site_url(LUXURY_MEKONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		$deluxe = $this->create_url(site_url(DELUXE_MEKONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		$cheap = $this->create_url(site_url(CHEAP_MEKONG_CRUISES) . '/', date('Y-m-d'), 'daily', '0.8');
		return $luxury . $deluxe . $cheap;
	}		
	function create_tour_detail_url($url_title){
		return $this->create_url(site_url(url_builder(TOUR_DETAIL, $url_title, true)), date('Y-m-d'), 'daily', '0.7');
	}
	function create_partners_url(){
		return $this->create_url(site_url(PARTNERS) . '/', date('Y-m-d'), 'daily', '0.9');
	}
}
?>