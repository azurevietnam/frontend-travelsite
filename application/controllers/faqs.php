<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class faqs extends CI_Controller {

    public function __construct()
    {

        parent::__construct();

        $this->load->language('faq');
        $this->load->model('FaqModel');
        $this->load->helper('text');
    }

    function index()
    {
        redirect_case_sensitive_url('', FAQ, false);

        $this->session->set_userdata('MENU', MNU_FAQ);

        $data['metas'] = site_metas(FAQ);

        $data['navigation'] = createFaqLink();

        $data['GLOBAL_DATAS'] = '';

        $data['categories'] = $this->FaqModel->getFaqCategories();

        $data['questions'] = array();

        $data['category_name'] = '';

        if (count($data['categories']) > 0){

            $cat = $data['categories'][0];

            $data['category_name'] = $cat['name'];

            $data['questions'] = $this->FaqModel->getFaqQuestionByCategory($cat['id']);

            $this->session->set_userdata('selected_faq_category', $cat['id']);

        }

        $data['categories_view'] = $this->load->view('faq/faq_categories', $data, TRUE);
        $data['faq_questions_view'] = $this->load->view('faq/faq_questions', $data, TRUE);

        $data = $this->_setFormData($data);

        $data['main'] = $this->load->view('faq/faq_main_view', $data, TRUE);
        $this->load->view('template', $data);
    }

    function category(){

        $this->session->set_userdata('MENU', MNU_FAQ);

        $data['GLOBAL_DATAS'] = '';

        $url_title = $this->uri->segment(1);

        $url_title = anti_sql($url_title);

        $url_title = substr($url_title, strlen(FAQ_CATEGORY)+1);
        $url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

        $data['categories'] = $this->FaqModel->getFaqCategories();

        $category = $this->_getCategoryByUrlTitel($data['categories'], $url_title);

        $data['metas'] = site_metas(FAQ_CATEGORY, $category);

        if (!$category){

            redirect(site_url(FAQ));
        }

        $data['navigation'] = createFaqCategoryLink($category['name']);

        $data['questions'] = $this->FaqModel->getFaqQuestionByCategory($category['id']);

        $data['category_name'] = $category['name'];

        $this->session->set_userdata('selected_faq_category', $category['id']);

        redirect_case_sensitive_url(FAQ_CATEGORY, $category['url_title'], true);

        $data['categories_view'] = $this->load->view('faq/faq_categories', $data, TRUE);
        $data['faq_questions_view'] = $this->load->view('faq/faq_questions', $data, TRUE);

        $data = $this->_setFormData($data);

        $data['main'] = $this->load->view('faq/faq_main_view', $data, TRUE);
        $this->load->view('template', $data);
    }

    function question(){

        $this->session->set_userdata('MENU', MNU_FAQ);

        $data['navigation'] = createFaqLink();

        $data['GLOBAL_DATAS'] = '';

        $url_title = $this->uri->segment(1);

        //$url_title = anti_sql($url_title);

        $url_title = substr($url_title, strlen(FAQ_DETAIL)+1);
        $url_title = substr($url_title, 0, strlen($url_title) - strlen(URL_SUFFIX));

        $data['categories'] = $this->FaqModel->getFaqCategories();

        $data['faq'] = $this->FaqModel->getFaqQuestionByUrl($url_title);

        if ($data['faq'] == ''){

            redirect(site_url(FAQ));
        }

        // canonical to original page if it's avaible
        if(! empty($data['faq']['page'])) {
            $data = apply_canonical($data, $data['faq']['page']);
        }

        $data['metas'] = site_metas(FAQ_DETAIL, $data['faq']);

        $selected_category_id = $this->session->userdata('selected_faq_category');

        $cats = explode("-", trim($data['faq']['categories']));

        if ($data['faq']['categories'] == '-' || count($cats) == 0){

            $data['questions'] = array();

            $data['category_name'] = '';


        } else {

            $cat_id = '';

            if ($selected_category_id != '' && in_array($selected_category_id.'', $cats)){

                $cat_id = $selected_category_id;

            } else {
                //echo $cats;
                $cat_id = $cats[0];

                if ($cat_id == '' && count($cats) > 1){
                    $cat_id = $cats[1];
                }
            }

            $category = $this->_getCategoryById($data['categories'], $cat_id);

            $data['questions'] = $this->FaqModel->getFaqQuestionByCategory($category['id']);

            $data['category_name'] = $category['name'];
        }

        redirect_case_sensitive_url(FAQ_DETAIL, $data['faq']['url_title'], true);

        $data['navigation'] = createFaqQuestionLink($data['category_name'], $data['faq']['question']);

        $data['categories_view'] = $this->load->view('faq/faq_categories', $data, TRUE);
        $data['faq_questions_view'] = $this->load->view('faq/faq_question_detail', $data, TRUE);

        $data = $this->_setFormData($data);

        $data['main'] = $this->load->view('faq/faq_main_view', $data, TRUE);
        $this->load->view('template', $data);
    }

    function _getCategoryByUrlTitel($categories, $url_title){

        foreach ($categories as $category) {

            if ($category['url_title'] == $url_title) return $category;

        }

        return false;
    }

    function _getCategoryById($categories, $id){
        foreach ($categories as $category) {

            if ($category['id'] == $id) return $category;

        }

        return false;
    }

    function _setFormData($data) {

        $data['inc_css'] = get_static_resources('faq.min.01112013.css');

        return $data;
    }
}
?>