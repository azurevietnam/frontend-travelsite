<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertising extends CI_Controller {
	
	public function __construct()
    {
        
       	parent::__construct();	
		$this->load->helper(array('form', 'url'));
		$this->load->language(array('ads'));
		$this->load->model(array('TourModel', 'VisaModel'));
		
		$this->load->driver('cache', array('adapter' => 'file'));
		
		//$this->output->enable_profiler(TRUE);
	}
	
	function index()
	{			
		$url_title = $this->uri->segment(2);
		
		$url_title = str_replace(URL_SUFFIX, '', $url_title);
		
		$data = array();
		
		switch ($url_title) {
			case 'halongbay-free-visa-20130815':
				$data = $this->free_vietnam_visa($data);
				break;
			case 'book-together-20130823':
				$data = $this->book_together($data);
				break;
			// Modified on 06 Dec 2013
			/*
			case 'visa-for-friends-20131017':
				$data = $this->visa_for_friends($data);
				break;
			*/
			case 'gift-voucher-20131204':
				$data = $this->voucher_fifty($data);
				break;
			case 'free-visa-applicable':
			    $data = $this->free_visa_applicable();
			    break;
			
			default:
				redirect(site_url());
				break;
		}
		
		$data['main'] = $this->load->view('ads/promotion_ads', $data, TRUE);
		
		$this->load->view('template', $data);	
	}
	
	function free_vietnam_visa($data) {
		$metas['title'] = lang('promotion_ads_title');
		$metas['keywords'] = '';
		$metas['description'] = '';
		$metas['robots'] = 'index, follow';
		$data['metas'] = $metas;
		$data['navigation'] = createAdvertisingLink('Free Vietnam Visa');
		
		// Get all normal nationalities
		/**
		 * 
		 *  Delete cache database element
		 *  TinVM 6.11.2014
		 * 
		 */
		
// 		$cache_time = $this->config->item('cache_day');
		
// 		if ( ! $all_normal_nationalities = $this->cache->get('all_normal_nationalities'))
// 		{
// 			$all_normal_nationalities = $this->VisaModel->getAllNationalities(true);
		
		
// 			$this->cache->save('all_normal_nationalities', $all_normal_nationalities, $cache_time);
// 		}
		
		$all_normal_nationalities = $this->VisaModel->getAllNationalities(true);
		
		$data['countries'] = $all_normal_nationalities;
		
		$data = $this->setFormData($data);
		
		$data['main_view'] = $this->load->view('ads/free_visa', $data, TRUE);
		
		return $data;
	}
	
	function book_together() {
		$metas['title'] = lang('book_together_title');
		$metas['keywords'] = '';
		$metas['description'] = '';
		$metas['robots'] = 'index, follow';
		$data['metas'] = $metas;
		$data['navigation'] = createAdvertisingLink('Book Together');
		
		$data = $this->setFormData($data);
		
		$data['main_view'] = $this->load->view('ads/book_together', $data, TRUE);
		
		return $data;
	}
	
	
	function setFormData($data) {
		
		// load why use view
		$data['why_use'] = $this->load->view('common/why_use_view', $data, TRUE);
		
		// load search block
		$data = buildTourSearchCriteria($data);
		
		$data['inc_css'] = get_static_resources('ads.min.css');
		
		return $data;
	}
	
	function booking_together() {
		$metas['title'] = lang('book_together_title');
		$metas['keywords'] = '';
		$metas['description'] = '';
		$metas['robots'] = 'index, follow';
		$data['metas'] = $metas;
		$data['navigation'] = createAdvertisingLink(lang('book_together'));
		
		$data = $this->setFormData($data);
	
		$data['main_view'] = $this->load->view('ads/book_together_detail', $data, TRUE);
		$data['main'] = $this->load->view('ads/promotion_ads', $data, TRUE);
		$this->load->view('template', $data);
	
		return $data;
	}
	
	function visa_for_friends() {
		
		// Get all normal nationalities
		
		/**
		 * 
		 *  Delete cache database element
		 *  TinVM 6.11.2014
		 * 
		 */
// 		$cache_time = $this->config->item('cache_day');
		
// 		if ( ! $all_normal_nationalities = $this->cache->get('all_normal_nationalities'))
// 		{
// 			$all_normal_nationalities = $this->VisaModel->getAllNationalities(true);
		
		
// 			$this->cache->save('all_normal_nationalities', $all_normal_nationalities, $cache_time);
// 		}
		
		$all_normal_nationalities = $this->VisaModel->getAllNationalities(true);
		$data['countries'] = $all_normal_nationalities;
		
		$metas['title'] = 'Visa For Friends';
		$metas['keywords'] = '';
		$metas['description'] = '';
		$metas['robots'] = 'index, follow';
		$data['metas'] = $metas;
		$data['navigation'] = createAdvertisingLink('Visa For Friends');
	
		$data = $this->setFormData($data);
	
		$data['main_view'] = $this->load->view('ads/visa_for_friends', $data, TRUE);
	
		return $data;
	}
	
	function voucher_fifty($data) {
		
		$metas['title'] = 'Gift Voucher Only For You!';
		$metas['keywords'] = '';
		$metas['description'] = '';
		$metas['robots'] = 'index, follow';
		
		$data['metas'] = $metas;
		$data['navigation'] = createAdvertisingLink('Gift Voucher');
		
		$data = $this->setFormData($data);
		
		$data['main_view'] = $this->load->view('ads/gift_voucher', $data, TRUE);
		
		return $data;
	}
	
	
	function free_visa_applicable()
    {
        $metas['title'] = lang('free_visa_applicable');
        $metas['keywords'] = '';
        $metas['description'] = '';
        $metas['robots'] = 'noindex, nofollow';
        $data['metas'] = $metas;
        $data['navigation'] = createAdvertisingLink(lang('free_visa_applicable'));
        
        $all_normal_nationalities = $this->VisaModel->getAllNationalities(true);
        
        $data['countries'] = $all_normal_nationalities;
        
        $data = $this->setFormData($data);
        
        $data['main_view'] = $this->load->view('ads/free_visa_applicable', $data, TRUE);
        
        return $data;
    }
}
?>