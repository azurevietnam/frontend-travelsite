<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  * Advertising
  *
  * @author toanlk
  * @since  Jul 29, 2015
  */
class Advertising extends CI_Controller
{
	
	public function __construct()
    {
       	parent::__construct();
       	
       	$this->load->helper(array('basic', 'resource', 'tour_search'));
       	
       	$this->load->model(array('Visa_Model'));
       	
       	$this->load->language(array('ads'));
		
		// for test only
		//$this->output->enable_profiler(TRUE);	
	}
	
	function index()
    {	
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();
        
        $data['is_mobile'] = $is_mobile;
        
        $url_title = $this->uri->segment(2);
        
        $url_title = str_replace(URL_SUFFIX, '', $url_title);
        
        $data['page_theme'] = get_page_theme(ADVERTISING_PAGE, $is_mobile);
        
        switch ($url_title) {
            case 'halongbay-free-visa-20130815':
                $data = $this->free_vietnam_visa($data);
                break;
            case 'book-together-20130823':
                $data = $this->book_together($data);
                break;
            case 'gift-voucher-20131204':
                $data = $this->voucher_fifty($data);
                break;
            case 'free-visa-applicable':
                $data = $this->free_visa_applicable($data);
                break;
                	
            default:
                redirect(site_url());
                break;
        }
        
        // load the tour search form
        $data = load_tour_search_form($data, $is_mobile, array(), VIEW_PAGE_NOT_ADVERTISE, TRUE);
        
        $data = load_why_use($data, $is_mobile);
        
        render_view('advertising/promotion_ads', $data, $is_mobile);
    }
    
    function free_vietnam_visa($data) {
        
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_PROMOTION_ADS_PAGE, null);
        
        $data = get_page_navigation($data, $data['is_mobile'], ADVERTISING_PROMOTION_ADS_PAGE);
        
        $data['countries'] = $this->Visa_Model->get_nationalities(true);
    
        $data['main_view'] = load_view('advertising/free_visa', $data, $data['is_mobile']);
    
        return $data;
    }
    
    function book_together() {
       
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_BOOK_TOGETHER_PAGE, null);
        
        $data = get_page_navigation($data, $data['is_mobile'], ADVERTISING_BOOK_TOGETHER_PAGE);
    
        $data['main_view'] = load_view('advertising/book_together', $data, $data['is_mobile']);
    
        return $data;
    }
    
    function visa_for_friends()
    {
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_VISA_FOR_FRIENDS_PAGE, null);
        
        $data = get_page_navigation($data, $data['is_mobile'], ADVERTISING_VISA_FOR_FRIENDS_PAGE);
        
        $data['countries'] = $this->Visa_Model->get_nationalities(true);
        
        $data['main_view'] = load_view('advertising/visa_for_friends', $data, $data['is_mobile']);
        
        return $data;
    }
    
    function voucher_fifty($data)
    {
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_GIFT_VOUCHER_PAGE, null);
        
        $data = get_page_navigation($data, $data['is_mobile'], ADVERTISING_GIFT_VOUCHER_PAGE);
        
        $data['main_view'] = load_view('advertising/gift_voucher', $data, $data['is_mobile']);
        
        return $data;
    }

    function free_visa_applicable($data)
    {
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_FREE_VISA_APPLICABLE_PAGE, null);
        
        $data = get_page_navigation($data, $data['is_mobile'], ADVERTISING_FREE_VISA_APPLICABLE_PAGE);
        
        $data['countries'] = $this->Visa_Model->get_nationalities(true);
        
        $data['main_view'] = load_view('advertising/free_visa_applicable', $data, $data['is_mobile']);
        
        return $data;
    }
    
    function booking_together()
    {
        $is_mobile = is_mobile();
        
        $data['page_theme'] = get_page_theme(ADVERTISING_PAGE, $is_mobile);
        
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(ADVERTISING_BOOKING_TOGETHER_PAGE, null);
        
        $data = get_page_navigation($data, $is_mobile, ADVERTISING_BOOKING_TOGETHER_PAGE);
        
        $data['main_view'] = load_view('advertising/book_together_detail', $data, $is_mobile);
        
        // load the tour search form
        $data = load_tour_search_form($data, $is_mobile, array(), VIEW_PAGE_NOT_ADVERTISE, TRUE);
        
        $data = load_why_use($data, $is_mobile);
        
        render_view('advertising/promotion_ads', $data, $is_mobile);
    }
}
?>
