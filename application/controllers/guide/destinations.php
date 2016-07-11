<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
  *  Destinations Page
  *
  *  @author khuyenpv
  *  @since  March 04 2015
  */
class Destinations extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource', 'tour', 'destination', 'hotline', 'text'));

       	$this->load->model(array('Destination_Model'));

        $this->load->config('destination_meta');

        $this->load->language('destination');
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index($url_title)
    {
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	$data = $this->_load_common_data($is_mobile, $url_title, DESTINATION_DETAIL_PAGE);

    	$destination = $data['destination'];

    	$destination_photos = $this->Destination_Model->get_destination_photos($destination['id']);
        $destination_photos = $this->_add_avatar_hotel_and_roomtype_picture($destination_photos, $destination);
    	$data = load_photo_slider($data, $is_mobile, $destination_photos, PHOTO_FOLDER_DESTINATION, false);

        //load destination info link
        $data = load_destination_info_links($data, $is_mobile, $destination);

    	// load travel tips
    	$data = load_destination_travel_tips($data, $is_mobile, $destination);

    	// load most recommeded tours in Destination
    	$data = $this->_load_tour_in_destination($data, $is_mobile, $destination);

    	// load top tours including destinations
    	$data = $this->_load_tour_including_destination($data, $is_mobile, $destination);

        render_view('destinations/detail/destination_detail', $data, $is_mobile);
    }

    function things_to_do($url_title){

    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	$data = $this->_load_common_data($is_mobile, $url_title, DESTINATION_THINGS_TO_DO_PAGE);
    	$destination = $data['destination'];

    	// load list things to do
    	$data = $this->_load_things_to_do($data, $is_mobile, $destination);

    	render_view('destinations/things_to_do/things_to_do', $data, $is_mobile);
    }

    function thing_todo_detail($destination_url, $activity_url){
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        $activity = $this->Destination_Model->get_destination_activities_detail($activity_url);

        $destination = $this->Destination_Model->get_destination_detail($destination_url);

        if(empty($activity) || empty($destination_url)){
            // redirect to homepage if cannot find the destination
            redirect(get_page_url(VN_TOUR_PAGE),'location',301);

            exit();
        }

        $activity_photos = $this->Destination_Model->get_activity_photos($activity['id']);
        $data = load_photo_slider(array(), $is_mobile, $activity_photos, PHOTO_FOLDER_ACTIVITY, false);

        $data['destination'] = $destination;
        $data['activity'] = $activity;

        $data = $this->_load_common_data($is_mobile, $destination_url, DESTINATION_THINGS_TO_DO_PAGE, $data);

        render_view('destinations/things_to_do/things_todo_detail', $data, $is_mobile);
    }

    function attraction($url_title){

    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

    	$data = $this->_load_common_data($is_mobile, $url_title, DESTINATION_ATTRACTION_PAGE);
    	$destination = $data['destination'];

    	$data = $this->_load_attractions($data, $is_mobile, $destination);

    	render_view('destinations/attraction/attractions', $data, $is_mobile);

    }

    function useful_information($des_url_title, $information_url_title){
        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

    	// set cache html
    	set_cache_html();

    	// load the destination
    	$destination = $this->Destination_Model->get_destination_detail($des_url_title);

    	// load the destination
    	$useful_information = $this->Destination_Model->get_useful_information_detail($information_url_title);

    	if (empty($destination) || empty($useful_information)){

    		// redirect to homepage if cannot find the destination
    		redirect(get_page_url(VN_TOUR_PAGE),'location',301);

    		exit();
    	}

        // get list usefull information
        $usefull_info = $this->Destination_Model->get_list_useful_information($destination['id']);

    	$data['destination'] = $destination;

    	$data['useful_information'] = $useful_information[0];

        $useful_information_photos = $this->Destination_Model->get_destination_useful_information_photos($useful_information[0]['id']);
        $data = load_photo_slider($data, $is_mobile, $useful_information_photos, PHOTO_FOLDER_DESTINATION_USEFUL_INFORMATION, false);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta(DESTINATION_INFORMATION_PAGE, $destination, $useful_information[0]);

    	$data['page_theme'] = get_page_theme(DESTINATION_INFORMATION_PAGE, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, DESTINATION_INFORMATION_PAGE);

        $data = load_destination_categories($data, $is_mobile, $destination, DESTINATION_INFORMATION_PAGE, $usefull_info);

        $data = load_destination_useful_information($data, $is_mobile);

        $data = load_tripadvisor($data, $is_mobile);

    	$data = load_tailor_make_tour($data, $is_mobile);

    	render_view('destinations/useful_information/useful_information', $data, $is_mobile);
    }

    function article_detail($des_url_title, $article_url_title){

        $is_mobile = is_mobile();

    	// set cache html
    	set_cache_html();

        $article = $this->Destination_Model->get_article_detail($article_url_title);

        $data['article'] = $article;

        $data = $this->_load_common_data($is_mobile, $des_url_title, DESTINATION_ARTICLE_DETAIL_PAGE, $data);

        //load article detail
        $data = $this->_load_article_detail($data, $is_mobile, $article_url_title);

        //load other articles
        $data = $this->_load_other_article($data, $is_mobile);

    	render_view('destinations/article/article_detail_home', $data, $is_mobile);
    }

    /**
     * TinVM Mar20 2015
     * load article detail
     */
    function _load_article_detail($data, $is_mobile){

        if(!empty($data['article'])){

        $view_data['article'] = $data['article'];

        } else {

            $view_data['article'] = '';
        }

        $view_data['destination'] = $data['destination'];

        $data['article_detail'] = load_view('destinations/article/article_detail', $view_data, $is_mobile);

        return $data;
    }

    /**
     * TinVM Mar20 2015
     * load other article
     */

    function _load_other_article($data, $is_mobile){

        $other_articles = $this->Destination_Model->get_other_article($data['destination']['id'], $data['article']['services']);

        if(!empty($other_articles)){

            $view_data['other_articles'] = $other_articles;

        } else {

            $view_data['other_articles'] = '';
        }

        $view_data['destination'] = $data['destination'];

        $data['other_articles'] = load_view('destinations/article/other_articles', $view_data, $is_mobile);

        return $data;

    }

    function travel_article($url_title){
    	// check if the current device is Mobile or Not
    	$is_mobile = is_mobile();

        $page = $this->uri->segment(2);

        $offset = empty($page) ? 0 : $page;

    	$data = $this->_load_common_data($is_mobile, $url_title, DESTINATION_ARTICLE_PAGE);
    	$destination = $data['destination'];

    	$articles = $this->Destination_Model->get_travel_articles($destination['id'], 10, $offset);

        $data['count_results'] = count($articles);
        
        // load top article
        if(empty($page))
            $data = $this->_load_top_articles($data, $is_mobile, $articles);

        else
            $data['top_article'] = '';

        // load list article
        if($data['count_results']) $articles;
        
        $data = $this->_load_list_articles($data, $is_mobile, $articles);

        render_view('destinations/article/travel_articles', $data, $is_mobile);
    }

    function _set_paging_info($data)
    {
        $this->load->library('pagination');

        $page = $this->uri->segment(2);

        $offset = empty($page) ? 0 : $page;

        $total_rows = $this->Destination_Model->get_travel_articles($data['destination']['id'], '', 0, true);

        $paging_config = create_paging_config($total_rows, get_page_url(DESTINATION_ARTICLE_PAGE, $data['destination']), 2);

        // initialize pagination
        $this->pagination->initialize($paging_config);

        $paging_info['paging_text'] = create_paging_text($total_rows, $offset);

        $paging_info['paging_links'] = $this->pagination->create_links();

        $data['paging_info'] = $paging_info;

        $data['page'] = $page;

        return $data;
    }

    /**
     * Load Common Data of Destination Module
     * TinVM Mar20 2015
     */
    function _load_common_data($is_mobile, $url_title, $page, $data = array()){

    	// set cache html
    	set_cache_html();

        set_current_menu(MNU_HOME);

    	// load the destination
    	$destination = $this->Destination_Model->get_destination_detail($url_title);

    	if (empty($destination)){

    		// redirect to homepage if cannot find the destination
    		redirect(get_page_url(VN_TOUR_PAGE),'location',301);

    		exit();
    	}

    	$data['destination'] = $destination;

        // get list usefull information
        $usefull_info = $this->Destination_Model->get_list_useful_information($destination['id']);

    	// get page meta title, keyword, description, canonical, ...etc
    	$data['page_meta'] = get_page_meta($page, $destination);

    	$data['page_theme'] = get_page_theme($page, $is_mobile);

    	$data = get_page_navigation($data, $is_mobile, $page);

    	$data = load_destination_categories($data, $is_mobile, $destination, $page, $usefull_info);

    	$data = load_tripadvisor($data, $is_mobile);

    	$data = load_tailor_make_tour($data, $is_mobile);

    	return $data;
    }


    /**
     * Khuyenpv March 04 2015
     * Load most recommend tour-in-destination view
     */
    function _load_tour_in_destination($data, $is_mobile, $destination){

    	$tours_in_destination = $this->Destination_Model->get_tours_in_destination($destination['id']);

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

    	if(!empty($tours_in_destination)){

    		$view_data = load_list_tours_compact(array(), $is_mobile, $tours_in_destination);

    		$data['tours_in_destination'] = $this->load->view($mobile_folder.'destinations/detail/tours_in_destination', $view_data, TRUE);

    	} else {

    		$data['tours_in_destination'] = '';
    	}

    	return $data;
    }

    /**
     * Khuyenpv March 04 2015
     * Load most recommend tour-in-destination view
     */
    function _load_tour_including_destination($data, $is_mobile, $destination){

    	$tours_including_destination = $this->Destination_Model->get_tours_including_destination($destination['id']);

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

    	if(!empty($tours_including_destination)){

    		$view_data = load_list_tours_compact(array(), $is_mobile, $tours_including_destination);

    		$data['tours_including_destination'] = $this->load->view($mobile_folder.'destinations/detail/tours_including_destination', $view_data, TRUE);

    	} else {

    		$data['tours_including_destination'] = '';
    	}

    	return $data;
    }

    /**
     * Khuyenpv March 04 2015
     * Load list things to do of a destination
     */
    function _load_things_to_do($data, $is_mobile, $destination){

    	$things_to_do = $this->Destination_Model->get_things_to_do($destination['id'], DESTINATION_THING_TO_DO_MAX_LIST);

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

    	if(!empty($things_to_do)){

            $list_id_activity = $this->_bpt_array_column($things_to_do, 'id');

            $tour_activity = $this->Destination_Model->load_tour_contain_activity($list_id_activity);

            // get tour activity show in activity

            if(!empty($tour_activity))
                foreach ($things_to_do as $value)
                    foreach ($tour_activity as $v)
                        if(!empty($v['tour_id']) && $value['id'] == $v['tour_id'] && count($things_to_do['tour_contain']) < 3){
                            $things_to_do['tour_contain'][] = $v;
                    }

            $view_data['things_to_do'] = $things_to_do;

            $view_data['destination'] = $destination;

            $view_data['count_activity'] = $this->Destination_Model->get_things_to_do($destination['id'], '', '', true);

            $view_data = $this->_load_tour_including_destination($view_data, $is_mobile, $destination);

    		$data['list_things_to_do'] = load_view('destinations/things_to_do/list_things_to_do', $view_data, $is_mobile);

    	} else {

    		$data['list_things_to_do'] = '';
    	}

    	return $data;

    }

    /**
     * Array column
     * TinVM Apr 17 2015
     */
    function _bpt_array_column($array, $field){
        $new_arr = array();

        foreach($array as $value){
            $new_arr[] = $value[$field];
        }

        return $new_arr;
    }

    /**
     * Khuyenpv March 04 2015
     * Load list things to do of a destination
     */
    function _load_attractions($data, $is_mobile, $destination){

        if($destination['type'] == DESTINATION_TYPE_COUNTRY)
    	    $attractions = $this->Destination_Model->get_attractions($destination['id'], DESTINATION_ATTRACTION_MAX_LIST, '', '', '', '', true);
        else
            $attractions = $this->Destination_Model->get_attractions($destination['id'], DESTINATION_ATTRACTION_MAX_LIST, '', '', '', '', false);

    	if(!empty($attractions)){

            if($destination['type'] == DESTINATION_TYPE_COUNTRY)
                foreach ($attractions as $key=>$value) {
                    if($value['type'] != DESTINATION_TYPE_CITY)
                        unset($attractions[$key]);
                }

            $view_data['destination'] = $destination;
            $view_data['attractions'] = $attractions;

            $view_data['count_attractions'] = $this->Destination_Model->get_attractions($destination['id'], '', '', true);

    		$data['list_attractions'] = load_view('destinations/attraction/list_attractions', $view_data, $is_mobile);

    	} else {

    		$data['list_attractions'] = '';
    	}

    	return $data;

    }

    /**
     * Khuyenpv March 04 2015
     * Load top article view
     */
    function _load_top_articles($data, $is_mobile, $articles){

        $article_1st = count($articles) > 0 ? $articles[0] : '';


    	if(!empty($articles)){

    		$view_data['articles'] = $articles;

            $view_data['article_1st'] = $article_1st;

            $view_data['destination'] = $data['destination'];

    		$data['top_article'] = load_view('destinations/article/top_article', $view_data, $is_mobile);

    	} else {

    		$data['top_article'] = '';
    	}

    	return $data;
    }

    /**
     * Khuyenpv March 04 2015
     * Load top article view
     */
    function _load_list_articles($data, $is_mobile, $articles){

    	$mobile_folder = $is_mobile ? 'mobile/' : '';

        $view_data = $this->_set_paging_info($data);

    	if(!empty($articles)){

    		$view_data['articles'] = $articles;

    		$data['list_articles'] = $this->load->view($mobile_folder.'destinations/article/list_articles', $view_data, TRUE);

    	} else {

    		$data['list_articles'] = '';
    	}

        $data['page'] = $view_data['page'];

    	return $data;
    }

    /**
     * Add avatar destination
     * @author TinVM
     * @since July24 2015
     */
    function _add_avatar_hotel_and_roomtype_picture($destination_photos, $destination){

        $avatar_destination = array('name' => $destination['picture'], 'caption' => $destination['name']);
        array_unshift($destination_photos, $avatar_destination);

        return $destination_photos;
    }
}
?>