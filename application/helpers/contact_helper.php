<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Contact helper functions
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       March, 03, 2015
 */

/**
 * Khuyenpv Feb 09 2015
 * Load FAQ for each page
 *
 */
function load_enquire_now($data, $is_mobile){
    $CI =& get_instance();

    $data['enquire_now'] = load_view('common/contact/enquire_now', $data, $is_mobile);

    return $data;
}

/**
 * Load the contact Form
 *
 * @author Khuyenpv
 * @since 08.04.2015
 */
function load_contact_form($data, $is_mobile, $call_back_fn = '', $show_subject = false, $call_back_params = array(),
    $without_form = false, $call_back_validation = '')
{

    $CI =& get_instance();
    $CI->load->language('contact');
    $CI->load->config('contact_meta');


    $cf_action = $CI->input->post('cf_action');

    if($cf_action == ACTION_SUBMIT){
        if(validate_contact_form('contact_form_cnf', $call_back_validation)){
            if(!empty($call_back_fn)){
                call_user_func_array($call_back_fn, $call_back_params);
            }
        } else{
            $view_data['has_error'] = STATUS_ACTIVE;
        }
    }

    $view_data['countries'] = $CI->config->item('countries');

    $view_data['without_form'] = $without_form;

    $view_data['title'] = lang('your_information');

    if($show_subject){
        $view_data['show_subject'] = $show_subject;
        $view_data['url'] = $CI->uri->segment(3);
        $view_data['title'] = lang('contact_title');

        if($view_data['url'] == 'claim')
            $view_data['c_tour'] = lang('ctu_rate_guarantee_claim') . ': ' . $CI->uri->segment(4).'/'.$CI->uri->segment(5);
    }

    $data['contact_form'] = load_view('contact/contact_form', $view_data, $is_mobile);

    return $data;
}

/**
 * Validate The Contact Form
 *
 * @author Khuyenpv
 * @since 08.04.2015
 */
function validate_contact_form($form_cnf, $call_back_validation = null)
{
    $CI = & get_instance();
    $CI->load->library('form_validation');

    if (! empty($call_back_validation))
    {
        call_user_func_array($call_back_validation, array());
    }

    $form_rules = $CI->config->item($form_cnf);
    $CI->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    $CI->form_validation->set_rules($form_rules);

    return $CI->form_validation->run();
}

/**
 * Save customer in contact form
 *
 * @author TinVM
 * @since Apr10 2015
 */
function save_customer_contact_form(){
    $CI =& get_instance();
    $CI->load->model('TourModel');
    $CI->load->config('contact_meta');

    $config = $CI->config->item('contact_form_cnf');

    $info = get_contact_post_data();
    $info['date_issue'] = date(DB_DATE_TIME_FORMAT, time());
    $info['subject'] = $CI->input->post('subject');
    $info['status'] = 0; // fix status

    unset($info['fax']);
    $info['message'] = $info['special_request'];
    unset($info['special_request']);

    $id = $CI->TourModel->createContact($info);

    if(!empty($id))
        redirect(site_url('thank-you.html'));
}

/**
 * Get the Contact Post Data
 *
 * @author Khuyenpv
 * @since 08.04.2015
 */
function get_contact_post_data(){
    $CI =& get_instance();
    $cus['title'] = $CI->input->post('title');
    $cus['full_name'] = $CI->input->post('full_name');
    $cus['email'] = $CI->input->post('email');
    $cus['phone'] = $CI->input->post('phone');
    $cus['fax'] = $CI->input->post('fax');
    $cus['country'] = $CI->input->post('country');
    $cus['city'] = $CI->input->post('city');
    $cus['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $special_request = trim($CI->input->post('special_requests'));
    $cus['special_request'] = $special_request;
    return $cus;
}


/**
 * Get the Customize Post Data
 *
 * @athor Khuyennpv
 * @since 09.04.2015
 */
function get_customize_post_data(){
    $CI =& get_instance();

    $CI->load->config('contact_meta');

    $config = $CI->config->item('customize_form_cnf');

    if(!empty($config)) {
        foreach ($config as $value)
        {
            $object[$value['field']] = $CI->input->post($value['field']);
        }
    }

    $object['status'] = 0; // new

    $object['date_issue'] = date(DB_DATE_TIME_FORMAT, time());

    $object['subject'] = lang('title_customize_tour');

    $object['ip_address'] = $_SERVER['REMOTE_ADDR'];

    $object = load_customize_info($object);

    return $object;
}

/**
 * Load the customize this Tour Form
 *
 * @author Khuyenpv
 */
function load_customize_form($data, $is_mobile, $call_back_fn = '', $call_back_params = array()){

    $CI =& get_instance();
    $CI->load->language(array('contact', 'tour'));
    $CI->load->config('contact_meta');
    $CI->load->model(array('Tour_Model', 'Hotline_Model'));


    $cf_action = $CI->input->post('action');

    $now = date(DB_DATE_FORMAT);
    $schedules = $CI->Hotline_Model->get_schedules($now, TOUR);
   
    $view_data = set_contact_diplay($schedules);
    
    if($cf_action == ACTION_SUBMIT){
        if(validate_contact_form('customize_form_cnf')){
            if(!empty($call_back_fn)){
                call_user_func_array($call_back_fn, $call_back_params);
            }
        } else{
            $view_data['has_error'] = STATUS_ACTIVE;
        }
    }

    $view_data['tour'] = $data['tour'];

    $view_data['countries'] = $CI->config->item('countries');

    $view_data['tour_customize_class'] = $CI->config->item('tour_customize_class');

    $view_data['parent_dess'] = $CI->Tour_Model->getTopParentDestinations();

    $view_data['dess'] = $CI->Tour_Model->getTopDestinations();

    $data['customize_form'] = load_view('contact/customize_trip_form', $view_data, $is_mobile);

    return $data;
}

/**
 * Set contact diplay on customize tour
 *
 * TinVM Apr25 2015
 */

function set_contact_diplay($schedules){
    $CI =& get_instance();
    $CI->load->model('Hotline_Model');
    $CI->load->language('about');

    // fix user sale default display in customize tour
    if(empty($schedules)){
    	
        $schedules = $CI->Hotline_Model->get_user(2); // fix id hienkim
        
        $view_data['schedule'] = $schedules;
    }
    else
     $view_data['schedule'] = $schedules[array_rand($schedules)];

    if(empty($view_data['schedule']['tailor_tour_title']))
        $view_data['schedule']['tailor_tour_title'] = lang('field_we_design_perfect');

    if(empty($view_data['schedule']['tailor_tour_description']))
        $view_data['schedule']['tailor_tour_description'] = lang('hien_kim_intro');
    
    return $view_data;
}

/**
 * Save the Customize Trip Info to DB
 *
 * @author Khuyenpv
 * @since 09.04.2015
 */
function save_customize_trip_info(){
    $CI =& get_instance();
    $CI->load->model(array('TourModel'));

    // only get post data
    $data_post = get_customize_post_data();

//    // save DB

    $custom_id = $CI->TourModel->createContact($data_post);

    // send Email

    send_contact_email($data_post);

    if(!empty($custom_id))
        redirect(get_page_url(THANK_YOU_REQUEST_PAGE));
}

/**
 * Customize info
 *
 * @author TinVM
 * @since Apr10 2015
 */

function load_customize_info($info_post){
    $CI =& get_instance();

    $CI->load->config('contact_meta');

    $str_customize = '';

    if (!empty($info_post['tour_name'])){

        $str_customize = $str_customize. 'Tour name: '. $info_post['tour_name']. "\n";

    }

    $str_customize = $str_customize. 'People: '. $info_post['adults']. ($info_post['adults'] > 1 ? ' adults' : ' adult');

    if ($info_post['children'] > 0){

        $str_customize = $str_customize. ', '. $info_post['children']. ($info_post['children'] > 1 ? ' children' : ' child');
    }

    if ($info_post['infants'] > 0){

        $str_customize = $str_customize. ', '. $info_post['infants']. ($info_post['infants'] > 1 ? ' infants' : ' infant');
    }

    $str_customize = $str_customize. "\n";

    $str_customize = $str_customize. "Arrival Date: ". $info_post['departure_date_customize']. "\n";

    if(!empty($info_post['tour_duration']))
    {
        $str_customize = $str_customize. "Duration: ". $info_post['tour_duration']. ($info_post['tour_duration'] > 1 ? ' days' : ' day'). "\n";
    }

    if(!empty($info_post['tour_accommodation'])) {

        $str_accom = $info_post['tour_accommodation'];

        $tour_customize_class = $CI->config->item('tour_customize_class');

        foreach ($tour_customize_class as $value)
        {
            if(strtolower(trim(lang($value['name']))) == strtolower(trim($info_post['tour_accommodation']))) {
                if(empty($value['price_to']))
                {
                    $str_accom = $str_accom. ' ( >' . CURRENCY_SYMBOL . ($info_post['tour_duration'] * $value['price_from']) . ' )';
                } else {
                    $str_accom = $str_accom . ' ( ' . CURRENCY_SYMBOL . ($info_post['tour_duration'] * $value['price_from']) . ' - ' . CURRENCY_SYMBOL . ($info_post['tour_duration'] * $value['price_to']) . ' )';
                }
                break;
            }
        }

        $str_customize = $str_customize. "Accommodation: ". lang($tour_customize_class[$str_accom]['name']) . "\n";
    }

    if ($info_post['destination_visit'] != '' && count($info_post['destination_visit']) > 0){
        $str_customize = $str_customize. "Destination: ". implode("-", $info_post['destination_visit']). "\n";
    }

    if ($info_post['message'] != '' && count($info_post['message']) > 0){
        $str_customize = $str_customize. "Message: ". $info_post['message']. "\n";
    }

    $str_customize = str_replace("<br>", "\n", $str_customize);

    unset($info_post['tour_name']);
    unset($info_post['children']);
    unset($info_post['infants']);
    unset($info_post['adults']);
    unset($info_post['tour_accommodation']);
    unset($info_post['departure_date_customize']);
    unset($info_post['tour_duration']);
    unset($info_post['destination_visit']);

    $info_post['message'] = $str_customize;

    return $info_post;

}

/**
 * Send Email notify User Contact
 *
 * @author Khuyenpv
 * @since 10.04.2015
 */
function send_contact_email($cus){
    $CI =& get_instance();

    $ct = $CI->config->item("countries");

    $title = $cus['title'] == "1"?"Mr." : "Ms.";

    $contact_infor = 'Name: '.$title.$cus['full_name'] . "<br>";

    $contact_infor = $contact_infor."Country: ".$ct[$cus['country']][0]."<br>";

    $contact_infor = $contact_infor."Email: ".$cus['email']. "<br>";

    $contact_infor = $contact_infor."Phone: ".$cus['phone']. "<br>";

    $cus['message'] = $contact_infor.$cus['message'];

    $cus['message'] = str_replace("\n", "<br>", $cus['message']);

    $CI->load->library('email');
    $CI->email->set_newline("\r\n");

    $CI->email->from($cus['email'], $cus['full_name']);
    $CI->email->to('minhtinit@gmail.com');
    $CI->email->subject($cus['subject']);
    $CI->email->message($cus['message']);

    if($CI->email->send()){
        echo "Mail was sent!";
    }
    else
    {
        show_error($CI->email->print_debugger());
    }
}

?>
