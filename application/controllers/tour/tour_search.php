<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Home Page
  *
  *  @author khuyenpv
  *  @since  Feb 04 2015
  */
class Tour_Search extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->language(array('tour', 'cruise'));

       	$this->load->config('tour_meta');

       	$this->load->helper(array('basic', 'resource', 'tour', 'tour_search','advertise','destination','faq', 'hotline', 'review', 'text', 'group'));

       	$this->load->model(array('Tour_Model', 'Destination_Model'));

		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index()
    {
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	// set current menu
    	set_current_menu(MNU_VN_TOURS);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(TOUR_SEARCH_PAGE);

    	$data['page_theme'] = get_page_theme(TOUR_SEARCH_PAGE, $is_mobile);

    	// 1. Get the search-criteria from the url
    	$search_criteria = get_tour_search_criteria_from_url();

    	// 2. Redirect to empty link if the search is invalid
    	if(!is_valid_tour_search($search_criteria)){

    		redirect(get_page_url(TOUR_SEARCH_EMPTY_PAGE, $search_criteria));

    	}

    	// 3. Push the search to an History Array, & save to coookie
    	save_search_criteria_history(TOUR_SEARCH_HISTORY, $search_criteria);

    	// get search link
    	$data['search_criteria']  = $search_criteria;

    	$data = get_page_navigation($data, $is_mobile, TOUR_SEARCH_PAGE);

    	$data = load_tour_search_overview($data, $is_mobile, $search_criteria);

    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE_ADVERTISE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, $search_criteria, $display_mode_form , TRUE);

    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_SEARCH);

    	$destination = $this->Destination_Model->get_search_destination($search_criteria['destination_id']);

    	// load tour search filters
    	$data = $this->_load_tour_search_filters($data, $is_mobile, $destination, $search_criteria);

    	// load tour search results
    	$data = $this->_load_tour_search_results($data, $is_mobile, $search_criteria);

        render_view('tours/search/tour_search', $data, $is_mobile);
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

    	$search_criteria = get_tour_search_criteria_from_url();

    	$destination = $this->Destination_Model->get_search_destination($search_criteria['destination_id']);

    	$data = $this->_load_filtered_items(array(), $is_mobile, $destination, $search_criteria);
    	
    	if($is_mobile) {
    	    $data = $this->_load_tour_search_filters($data, $is_mobile, $destination, $search_criteria);
    	}

    	$data = $this->_load_tour_search_results($data, $is_mobile, $search_criteria);

    	$search_results = $data['search_results'];

    	echo $search_results;
    }

    /**
	 * Search Tour with Empty Ressults
	 *
	 * @author Khuyenpv
	 * @since  Mar 10, 2015
	 */
    function search_empty(){
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	// set current menu
    	set_current_menu(MNU_VN_TOURS);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(TOUR_SEARCH_EMPTY_PAGE);

    	$data['page_theme'] = get_page_theme(TOUR_SEARCH_EMPTY_PAGE, $is_mobile);

    	// 1. Get the search-criteria from the url
    	$search_criteria = get_tour_search_criteria_from_url();

    	// get search link
    	$data['search_criteria']  = $search_criteria;
    	$data = get_page_navigation($data, $is_mobile, TOUR_SEARCH_PAGE);


    	// load the tour search form
    	$display_mode_form = !empty($data['common_ad'])? VIEW_PAGE : VIEW_PAGE_NOT_ADVERTISE;
    	$data = load_tour_search_form($data, $is_mobile, $search_criteria, $display_mode_form , TRUE); 

    	// load fag by page
    	$data = load_faq_by_page($data, $is_mobile, '', FAQ_PAGE_TOUR_SEARCH);




    	render_view('tours/search/tour_search_empty', $data, $is_mobile);
    }

    /**
     * Load Tour Search Filters
     *
     * @author Khuyenpv
	 * @since  Mar 12, 2015
     */
    function _load_tour_search_filters($data, $is_mobile, $destination, $search_criteria){

    	$view_data['search_criteria'] = $search_criteria;

    	$view_data['destination'] =  $destination;

    	// load the filter data
    	$view_data = $this->_load_filter_data($view_data, $destination, $search_criteria);

    	$data['search_filters'] = load_view('tours/search/search_filters', $view_data, $is_mobile);

    	return $data;
    }


    /**
     * Load the filtered items
     *
     * @author Khuyenpv
     * @since  Mar 12, 2015
     */
    function _load_filtered_items($data, $is_mobile, $destination, $search_criteria){

    	$view_data['search_criteria'] = $search_criteria;

    	// load the filter data
    	$view_data = $this->_load_filter_data($view_data, $destination, $search_criteria);


    	$data['filtered_items'] = load_view('tours/search/filtered_items', $view_data, $is_mobile);

    	return $data;
    }



    /**
     * Load the Search Results
     *
     * @author Khuyenpv
     * @since  Mar 12, 2015
     */
    function _load_tour_search_results($data, $is_mobile, $search_criteria){

    	$view_data['search_criteria'] = $search_criteria;

    	$view_data = $this->_load_sort_by($view_data, $is_mobile, $search_criteria);

    	$cnt_total_results = $this->Tour_Model->count_total_search_results($search_criteria);

    	if($cnt_total_results == 0 && !$this->input->is_ajax_request()){

    		redirect(get_page_url(TOUR_SEARCH_EMPTY_PAGE, $search_criteria), 'location', '302');
    	}

    	$tours = $this->Tour_Model->search_tours($search_criteria);

    	foreach($tours as $key=>$tour){

    		$tour['special_offers'] = empty($tour['promotions']) ? '' : load_promotion_popup($is_mobile, $tour['promotions'][0]);

    		$departure_date = $search_criteria['departure_date'];
    		$tour['most_rec_service'] = load_most_recommend_item($is_mobile, $tour, $departure_date);

    		$tours[$key] = $tour;
    	}

    	$view_data = load_list_tours($view_data, $is_mobile, $tours);

    	$view_data = $this->_load_search_paging($view_data, $is_mobile, $cnt_total_results);
    	
    	if(!empty($data['search_filters'])) {
    	    $view_data['search_filters'] = $data['search_filters'];
    	}

    	$view_data['cnt_total_results'] = $cnt_total_results;

    	if(isset($data['filtered_items'])) $view_data['filtered_items'] = $data['filtered_items'];

    	$data['search_results'] = load_view('tours/search/search_results', $view_data, $is_mobile);

    	return $data;
    }

    /**
     * Load the Sort-By View
     *
     * @author Khuyenpv
     * @since  Mar 12, 2015
     */

    function _load_sort_by($data, $is_mobile, $search_criteria){

    	$view_data['search_criteria'] = $search_criteria;

    	$view_data['cnf_sort_by'] = $this->config->item('tour_sort_by');


    	$data['sort_by'] = load_view('tours/search/sort_by', $view_data, $is_mobile);

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
    	
    	$p_config = $is_mobile ? $this->config->item('paging_config_mobile') : array();

    	$paging_config = create_paging_config($total_rows, get_page_url(TOUR_SEARCH_PAGE), 2, $p_config, true);
    	// initialize pagination

    	$this->pagination->initialize($paging_config);

    	$paging_info['paging_text'] = create_paging_text($total_rows, $offset);

    	$paging_info['paging_links'] = $this->pagination->create_links();

    	$view_data['paging_info'] = $paging_info;

    	$data['search_paging'] = load_view('tours/search/search_paging', $view_data, $is_mobile);

    	return $data;

    }

    /**
     * Load the filter data
     *
     * @author Khuyenpv
     * @since  Mar 13, 2015
     */
    function _load_filter_data($data, $destination, $search_criteria){

    	$all_tours_4_count_filters = $this->Tour_Model->get_all_tours_for_search_filters($search_criteria);

    	$data['is_show_cruise_facilitiy_filter'] = is_show_cruise_facilitiy_filter($destination, $search_criteria);

    	if($data['is_show_cruise_facilitiy_filter']){ // only show cruise filter in some case

	    	$cruise_cabins = $this->config->item('cruise_cabins');
	    	$data['cruise_cabins'] = $cruise_cabins;
	    	$cruise_cabins_nr = $this->_count_cruise_cabin_nr($cruise_cabins, $all_tours_4_count_filters);
	    	$data['cruise_cabins_nr'] = $cruise_cabins_nr;

	    	$cruise_properties = $this->Destination_Model->get_cruise_facilities_4_search();
	    	$data['cruise_properties'] = $this->_count_filter_data_nr($cruise_properties, $all_tours_4_count_filters, 'cruise_facility_ids');

	    	$data['nr_tripple_family_cabin'] = $this->_count_triple_family_nr($all_tours_4_count_filters);

    	}

    	$sub_destinations = $this->Destination_Model->get_sub_destination_4_filter($destination);
    	$data['sub_destinations'] = $this->_count_filter_data_nr($sub_destinations, $all_tours_4_count_filters, 'route_ids');

    	$activities = $this->Destination_Model->get_destination_activities($destination['id']);
    	$data['activities'] = $this->_count_filter_data_nr($activities, $all_tours_4_count_filters, 'activity_ids');

    	$travel_styles = $this->Destination_Model->get_destination_travel_styles($destination['id']);
    	$data['travel_styles'] = $this->_count_filter_travel_styles_nr($travel_styles, $search_criteria);

    	return $data;
    }

    /**
     * Count number of tours for cruise Cabin
     *
     * @auther Khuyenpv
     * @since Mar 14 2015
     */
    function _count_cruise_cabin_nr($cruise_cabins, $all_tours_4_count_filters){

    	$cruise_cabins_nr = array();

    	foreach ($cruise_cabins as $key => $value){

    		$nr = 0;

    		foreach ($all_tours_4_count_filters as $tour){

    			if ($tour['cabin_index'] & $key){

    				$nr++;

    			}

    		}

    		$cruise_cabins_nr[$key] = $nr;

    	}

    	$cruise_cabins_nr[0] = count($all_tours_4_count_filters);

    	return $cruise_cabins_nr;

    }

    /**
     * Count number of tours has triple-family cabbin
     *
     * @auther Khuyenpv
     * @since 11.04.2015
     */

    function _count_triple_family_nr($all_tours_4_count_filters){
    	// has triple-family cabin
    	$nr = 0;
    	foreach ($all_tours_4_count_filters as $tour){

    		if ($tour['has_triple_family'] == STATUS_ACTIVE){

    			$nr ++;

    		}

    	}

    	return $nr;
    }

    /**
     * Count number of tours for filter data
     *
     * @auther Khuyenpv
     * @since Mar 15 2015
     */
    function _count_filter_data_nr($fitler_data, $all_tours_4_count_filters, $field_name){

    	foreach($fitler_data as $key => $value){
    		$nr = 0;
    		$str_id = '-'.$value['id'].'-';

    		foreach ($all_tours_4_count_filters as $tour){
    			if ($tour[$field_name] != '' && strpos($tour[$field_name], $str_id) !== FALSE){
    				$nr++;
    			}
    		}

    		$value['cnt'] = $nr;

    		$fitler_data[$key] = $value;
    	}

    	foreach($fitler_data as $key => $value){
    		if($value['cnt'] == 0) unset($fitler_data[$key]);
    	}

    	return $fitler_data;
    }


    /**
     * Count number of tours by Travel Styles in a Destinations
     *
     * @auther Khuyenpv
     * @since Mar 14 2015
     */
    function _count_filter_travel_styles_nr($filter_data, $search_criteria){

    	$nr_data  = $this->Tour_Model->count_nr_tour_by_travel_styles($filter_data, $search_criteria);

    	foreach ($filter_data as $key => $value){

    		$cnt = 0;

    		foreach ($nr_data as $nr){

    			if ($nr['id'] == $value['id']){

    				$cnt = $nr['cnt'];
    				break;
    			}

    		}

    		$value['cnt'] = $cnt;

    		$filter_data[$key] = $value;

    	}

    	return $filter_data;

    }
}
?>
