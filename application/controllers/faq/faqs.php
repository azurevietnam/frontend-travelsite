<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faqs extends CI_Controller
{

	public function __construct()
    {
       	parent::__construct();

       	$this->load->helper(array('basic', 'resource','faq','contact','hotline'));

       	$this->load->model(array('Faq_Model'));

        $this->load->language('faq');
		// for test only
		//$this->output->enable_profiler(TRUE);
	}

	function index($url_title=''){

		$is_mobile = is_mobile();

		// set cache html
		set_cache_html();

		// set current menu
		set_current_menu(MNU_FAQ);

		if(empty($url_title))
        {
            $url_title = 'Top-10-questions';
        }

		$page = empty($url_title) ? FAQ_PAGE : FAQ_CATEGORY_PAGE;

		$category = $this->Faq_Model->get_category($url_title);

		if(empty($category)){

			redirect(get_page_url(FAQ_PAGE),'location','301');

			exit();
		}

		$data['category'] = $category;

		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta($page, $category);

		$data['page_theme'] = get_page_theme($page, $is_mobile);

		$data = get_page_navigation($data, $is_mobile, $page);


        // load faq categories
		$data = load_faq_categories($data, $is_mobile, $category['id']);

		// load faq destinations
		$data = load_faq_destinations($data, $is_mobile);


		$list_categories = $this->_get_list_categories($category);

		$list_questions = $this->_get_list_questions_by_categories($list_categories);

		$data = load_faq_list($data, $is_mobile,  $page, $list_categories, $list_questions);

		// load enquire now form
//		$data = load_enquire_now($data, $is_mobile);

		render_view('faqs/faq_home', $data, $is_mobile);
	}

	/**
	 * Khuyenpv March 03 2015
	 * FAQs by destination
	 */
	function destination($url_title){

		$is_mobile = is_mobile();

		// set cache html
		set_cache_html();

		// set current menu
		set_current_menu(MNU_FAQ);

        $destination = $this->Faq_Model->get_destination($url_title);

        if(empty($destination)){

            redirect(get_page_url(FAQ_PAGE),'location','301');

            exit();
        }

        $data['destination'] = $destination;

        $page = empty($url_title) ? FAQ_PAGE : FAQ_DESTINATION_PAGE;

        $data['destination'] = $destination;

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(FAQ_DESTINATION_PAGE, $destination);

		$data['page_theme'] = get_page_theme(FAQ_DESTINATION_PAGE, $is_mobile);

		$data = get_page_navigation($data, $is_mobile, FAQ_DESTINATION_PAGE);

        // load faq categories
        $data = load_faq_categories($data, $is_mobile);

        // load faq destinations
        $data = load_faq_destinations($data, $is_mobile, $destination['id']);

        $list_questions = $this->Faq_Model->get_faq_by_destination($destination['id'], 6);

        $data = load_faq_list($data, $is_mobile, FAQ_DESTINATION_PAGE, array(), $list_questions);

        // load enquire now form
//		$data = load_enquire_now($data, $is_mobile);


		render_view('faqs/faq_home', $data, $is_mobile);
	}

	/**
	 * TinVM Mar15 2015
	 * @param unknown $url_title
	 */
	function faq_detail($url_title){

		$is_mobile = is_mobile();

		// set cache html
		set_cache_html();

		// set current menu
		set_current_menu(MNU_FAQ);

        $question = $this->Faq_Model->get_faq_by_url_title($url_title);

		if(empty($question)){

			redirect(get_page_url(FAQ_PAGE),'location','301');

			exit();
		}
        else
            $data['question'] = $question;

        $data['related_categories'] = $this->Faq_Model->get_category_by_faq($question['id']);

        if(!empty($data['related_categories']))
            $data['category'] = $data['related_categories'][0];


		// get page meta title, keyword, description, canonical, ...etc
		$data['page_meta'] = get_page_meta(FAQ_DETAIL_PAGE, $question);

		$data['page_theme'] = get_page_theme(FAQ_DETAIL_PAGE, $is_mobile);

        // Load question detail
        $data = load_faq_by_page($data, $is_mobile);

        $data = get_page_navigation($data, $is_mobile, FAQ_DETAIL_PAGE);

        //Set current category id
        if(empty($data['category']['category_id']))
            $current_category_id = $data['category']['id'];
        else
            $current_category_id = $data['category']['category_id'];

		// load faq categories
		$data = load_faq_categories($data, $is_mobile, $current_category_id);

		// load faq destinations
		$data = load_faq_destinations($data, $is_mobile);

		// load related faqs
		$data = $this->_load_related_faqs($data, $is_mobile);

		// load enquire now form
//		$data = load_enquire_now($data, $is_mobile);

		render_view('faqs/faq_detail', $data, $is_mobile);
	}

	/**
	 * Load the related FAQs
	 */
	function _load_related_faqs($data, $is_mobile){

        $category_ids = array();
        foreach($data['related_categories'] as $value)
            $category_ids[] = $value['id'];

        $view_data['related_question'] = $this->Faq_Model->get_faq_by_category($category_ids);

        if(count($view_data['related_question']) > 10)
            $view_data['related_question'] = array_slice($view_data['related_question'], 0, 10);

        if(empty($view_data['related_question']))
            $data['related_faqs'] = '';

        else
            $data['related_faqs'] = load_view('faqs/common/related_faqs', $view_data, $is_mobile);

		return $data;
	}


	function _get_list_categories($category){

		$sub_categories = $this->Faq_Model->get_sub_categories($category['id']);

		$category['sub_categories'] = $sub_categories;

		$lis_categories = $category; //return array of categories

		return $lis_categories;
	}




	function _get_list_questions_by_categories($list_categories){

        // get array of Id from the list_categories
		$cat_ids = array();
			$cat_ids[] = $list_categories['id'];

			if(!empty($cat['sub_categories'])){

				foreach ($cat['sub_categories'] as $sub_cat){
					$cat_ids[] = $sub_cat['id'];
				}

			}

		$list_questions = $this->Faq_Model->get_faq_by_category($cat_ids);

		return $list_questions;
	}
}
?>
