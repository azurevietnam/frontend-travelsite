<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author TinVM
  *  @since  21.05.2015
  */
class Hotel_Search extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource', 'hotel', 'hotel_search','advertise','destination','faq', 'hotline', 'review', 'text'));

        $this->load->model(array('Hotel_Model', 'Destination_Model'));

        $this->load->config('hotel_meta');

        $this->load->language('hotel');

		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
    {
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	// set current menu
    	set_current_menu(MNU_HOTELS);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(HOTEL_SEARCH_PAGE);

    	$data['page_theme'] = get_page_theme(HOTEL_SEARCH_PAGE, $is_mobile);

    	// 1. Get the search-criteria from the url
    	$search_criteria = get_hotel_search_criteria_from_url();

    	// 2. Redirect to empty link if the search is invalid
    	if(!is_valid_hotel_search($search_criteria)){

    		redirect(get_page_url(HOTEL_SEARCH_EMPTY_PAGE, $search_criteria), 'location', '302');

    	}

    	// 3. Push the search to an History Array, & save to coookie
    	save_search_criteria_history(HOTEL_SEARCH_HISTORY, $search_criteria);

    	// get search link
    	$data['search_criteria']  = $search_criteria;

    	$data = get_page_navigation($data, $is_mobile, HOTEL_SEARCH_PAGE);

        //load hotel search overview
        $data = load_hotel_search_overview($data, $is_mobile, $search_criteria);

    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_hotel_search_form($data, $is_mobile, $search_criteria, $display_mode_form , true);

        // load top hotel destinations
        $data = load_top_hotel_destinations($data, $is_mobile);

    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_SEARCH);

    	$destination = $this->Destination_Model->get_search_destination($search_criteria['destination_id']);

    	// load tour search results
    	$data = $this->_load_hotel_search_results($data, $is_mobile, $search_criteria);

        render_view('hotels/search/hotel_search', $data, $is_mobile);
    }

    /**
	 * Tour Search by Ajax Call
	 * Using when user filter the search results
	 *
	 * @author Khuyenpv
	 * @since  Mar 13, 2015
	 */
    function ajax_search(){

    	$is_mobile = is_mobile();

    	$search_criteria = get_hotel_search_criteria_from_url();

    	$destination = $this->Destination_Model->get_search_destination($search_criteria['destination_id']);

    	$data = $this->_load_hotel_search_results(array(), $is_mobile, $search_criteria);

    	$search_results = $data['search_results'];

    	echo $search_results;
    }

    /**
	 * Search Tour with Empty Ressults
	 *
	 * @author Khuyenpv replated by TinVM May 28 2015
	 * @since  Mar 10, 2015
	 */
    function search_empty(){
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	// set current menu
    	set_current_menu(MNU_HOTELS);

        $search_criteria = get_hotel_search_criteria_from_url();

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(HOTEL_SEARCH_EMPTY_PAGE);

    	$data['page_theme'] = get_page_theme(HOTEL_SEARCH_EMPTY_PAGE, $is_mobile);

    	// get search link
    	$data = get_page_navigation($data, $is_mobile, HOTEL_SEARCH_EMPTY_PAGE);

        // load hotel search form
        $display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_hotel_search_form($data, $is_mobile, $search_criteria, $display_mode_form , true);

        //load top hotel destinations
        $data = load_top_hotel_destinations($data, $is_mobile);

        //load faq by page
        $data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_HOTEL_SEARCH);

        render_view('hotels/search/hotel_search_empty', $data, $is_mobile);
    }

    /**
     * Load the Search Results
     *
     * @author TinVM
     * @since  Jun 10, 2015
     */
    function _load_hotel_search_results($data, $is_mobile, $search_criteria){

        $view_data['search_criteria'] = $search_criteria;

        if(!empty($view_data['search_criteria']['destination_id']))
            $view_data['destination'] = $this->Destination_Model->get_destination($view_data['search_criteria']['destination_id']);

        $view_data = $this->_load_sort_by($view_data, $is_mobile, $search_criteria);

        $cnt_total_results = $this->Hotel_Model->count_total_hotel_search_results($search_criteria);

        if($cnt_total_results == 0 && !$this->input->is_ajax_request()){

            redirect(get_page_url(HOTEL_SEARCH_EMPTY_PAGE, $search_criteria));

        }

        $hotels = $this->Hotel_Model->search_hotels($search_criteria);

        $hotels = $this->Hotel_Model->get_hotel_price_froms($hotels, $search_criteria['start_date']);

        foreach ($hotels as $key => $hotel)
        {
            $hotel['special_offers'] = empty($hotel['promotions']) ? '' : load_promotion_popup($is_mobile, $hotel['promotions'][0], HOTEL);
            
            $hotels[$key] = $hotel;
        }

        $view_data = load_list_hotels($view_data, $is_mobile, $hotels);

        $view_data = $this->_load_search_paging($view_data, $is_mobile, $cnt_total_results);

        $view_data['cnt_total_results'] = $cnt_total_results;

        $view_data['number_hotels'] = $cnt_total_results;

        $data['search_results'] = load_view('hotels/search/search_results', $view_data, $is_mobile);

        return $data;
    }

    /**
     * Load the Sort-By View
     *
     * @author TinVM
     * @since  Jun 10, 2015
     */

    function _load_sort_by($data, $is_mobile, $search_criteria){

    	$view_data['search_criteria'] = $search_criteria;

    	$view_data['cnf_sort_by'] = $this->config->item('hotel_sort_by');

    	$data['sort_by'] = load_view('hotels/search/sort_by', $view_data, $is_mobile);

    	return $data;
    }


    /**
     * Load the Paging for Search
     *
     * @author Khuyenpv
     * @since  Mar 12, 2015
     */

    function _load_search_paging($data, $is_mobile, $total_rows = 1){

    	$this->load->library('pagination');

    	$search_criteria = $data['search_criteria'];

    	$offset = !empty($search_criteria['page'])?$search_criteria['page'] : 0;

    	$paging_config = create_paging_config($total_rows, get_page_url(HOTEL_SEARCH_PAGE), 2, array(), true);
    	// initialize pagination

    	$this->pagination->initialize($paging_config);

    	$paging_info['paging_text'] = create_paging_text($total_rows, $offset);

    	$paging_info['paging_links'] = $this->pagination->create_links();

    	$view_data['paging_info'] = $paging_info;

    	$data['search_paging'] = load_view('hotels/search/search_paging', $view_data, $is_mobile);

    	return $data;

    }

}
?>
