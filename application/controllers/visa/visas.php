<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Visa landing page and check rates page
 *
 * @author toanlk
 * @since  May 11, 2015
 */
class Visas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Visa_Model');

        $this->load->language(array('tour', 'visa'));

        $this->load->library(array('form_validation' , 'TimeDate'));

        $this->load->helper(array('basic', 'resource', 'visa', 'recommend', 'form', 'tour', 'advertise'));

        // $this->output->enable_profiler(TRUE);
    }

    function index()
    {
        // set cache html
        set_cache_html();

        redirect_case_insensitive_url();

        $data = $this->_get_common_data();

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_PAGE);

        $data['page_theme'] = get_page_theme(VN_VISA_PAGE, $data['is_mobile']);
        
        // get advertise
        $data = load_common_advertises($data, $data['is_mobile'], AD_PAGE_VIETNAM_VISA) ;

        if ($data['is_mobile'])
        {
            $mobile_folder = $data['is_mobile'] ? 'mobile/' : '';
            
            $data['top_visa_questions'] = $this->load->view($mobile_folder.'vietnam_visa/common/top_visa_questions', $data, TRUE);
            
            $data['check_requirements'] = $this->load->view($mobile_folder.'vietnam_visa/home/check_requirements', $data, TRUE);
            
            $data['visa_information'] = $this->load->view($mobile_folder.'vietnam_visa/home/visa_information', $data, TRUE);
            
            render_view('vietnam_visa/home/visa_home', $data, $data['is_mobile']);
        }
        else
        {
            // load the service recommendation
            $current_item_info = get_current_visa_booking_info();
            
            $data = load_service_recommendation($data, $data['is_mobile'], $current_item_info);
            
            // load top tour destinations
            $data = load_top_tour_destinations($data, $data['is_mobile']);
            
            // load header and navigation
            $data = get_page_main_header_title($data, $data['is_mobile'], VN_VISA_PAGE);

            $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_PAGE);

            $data = load_tripadvisor($data, $data['is_mobile']);
            
            $data['how_it_works'] = $this->load->view('vietnam_visa/common/how_it_works', $data, TRUE);

            $data['top_visa_questions'] = $this->load->view('vietnam_visa/common/top_visa_questions', $data, TRUE);

            $data['visa_apply_form'] = $this->load->view('vietnam_visa/home/visa_apply_form', $data, TRUE);
            
            $data['visa_information'] = $this->load->view('vietnam_visa/home/visa_information', $data, TRUE);

            $data['check_requirements'] = $this->load->view('vietnam_visa/home/check_requirements', $data, TRUE);

            render_view('vietnam_visa/home/visa_home', $data);
        }
    }

    /**
     * _get_common_data
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function _get_common_data() {

        // set current menu
        set_current_menu(MNU_VN_VISA);

        // check if the current device is Mobile or Not
        $is_mobile = is_mobile();

        // get visa configurations
        $data['max_application'] = $this->config->item("max_application");

        $data['types'] = $this->config->item("visa_types");

        $data['rush_services'] = $this->config->item("rush_services");

        // get countries
        $data['countries'] = $this->Visa_Model->get_nationalities();

        // visa on arrival accepted countries
        $data['voa_countries'] = get_voa_countries($data['countries']);

        $data['is_mobile'] = $is_mobile;

        return $data;
    }

    /**
     * apply_visa
     *
     * @author toanlk
     * @since  May 12, 2015
     */
    function apply_visa()
    {
        redirect_case_insensitive_url(true);

        $data = $this->_get_common_data();

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_APPLY_PAGE);

        $data['page_theme'] = get_page_theme(VN_VISA_APPLY_PAGE, $data['is_mobile']);

        $data['visa_req_nationality'] = $this->input->post('visa_req_nationality');

        if ($data['is_mobile'])
        {
            $mobile_folder = $data['is_mobile'] ? 'mobile/' : '';
            
            $data['step_labels'] = $this->config->item('visa_step_labels');
            
            $data['current_step'] = 1;
            
            $data['breadcrumb'] = $this->load->view($mobile_folder.'vietnam_visa/common/breadcrumb', $data, TRUE);
            
            $data['apply_form'] = $this->load->view($mobile_folder.'vietnam_visa/apply_visa/apply_form', $data, TRUE);
            
            $data['top_visa_questions'] = $this->load->view($mobile_folder.'vietnam_visa/common/top_visa_questions', $data, TRUE);
            
            $data['visa_information'] = $this->load->view($mobile_folder.'vietnam_visa/home/visa_information', $data, TRUE);
            
            render_view('vietnam_visa/apply_visa/apply_visa', $data, $data['is_mobile']);
        }
        else
        {
            // load the service recommendation
            $current_item_info = get_current_visa_booking_info();
            
            $data = load_service_recommendation($data, $data['is_mobile'], $current_item_info);
            
            $data['how_it_works'] = $this->load->view('vietnam_visa/common/how_it_works', $data, TRUE);
            
            // load top tour destinations
            $data = load_top_tour_destinations($data, $data['is_mobile']);
            
            // load header and navigation
            $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_APPLY_PAGE);

            $data = load_tripadvisor($data, $data['is_mobile']);

            $data['apply_form'] = $this->load->view('vietnam_visa/apply_visa/apply_form', $data, TRUE);

            $data['top_visa_questions'] = $this->load->view('vietnam_visa/common/top_visa_questions', $data, TRUE);

            $data['visa_information'] = $this->load->view('vietnam_visa/home/visa_information', $data, TRUE);

            render_view('vietnam_visa/apply_visa/apply_visa', $data);
        }
    }

    /**
     * visa_details
     *
     * @author toanlk
     * @since  May 13, 2015
     */
    function visa_details()
    {
        $action = $this->input->post('action');

        if ($action == ACTION_ADD_CART || $action == ACTION_CHECKOUT)
        {
            $this->_save($action);
        }
        else if ($action == ACTION_BOOK || $action == ACTION_UPDATE)
        {
            $visa_booking = insert_visa();
        }

        redirect_case_insensitive_url(true);

        $data = $this->_get_common_data();

        $visa_booking = get_visa_booking();

        if (empty($visa_booking))
        {
            redirect(get_page_url(VN_VISA_PAGE));
        }

        $data['rowId'] = $visa_booking['rowId'];

        $data['visa_booking'] = $visa_booking;

        // Airport configs
        $data['airports'] = $this->config->item("airports");

        // get visa booking from cart
        $data['numb_visa'] = $visa_booking['number_of_visa'];

        // get receive date
        $receive_date = get_visa_receive_date($visa_booking['processing_time']);

        $data['receive_date'] = get_receive_date_lang($receive_date);

        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_DETAILS_PAGE);

        $data['page_theme'] = get_page_theme(VN_VISA_DETAILS_PAGE, $data['is_mobile']);

        $data['current_step'] = 1;
        
        $data['step_labels'] = $this->config->item('visa_step_labels');
        
        $data['breadcrumb'] = load_view('/common/booking/booking_steps', $data, $data['is_mobile']);

        if ($data['is_mobile'])
        {
            $mobile_folder = $data['is_mobile'] ? 'mobile/' : '';
            
            $data['apply_form'] = $this->load->view($mobile_folder.'vietnam_visa/visa_details/apply_form', $data, TRUE);
            
            render_view('vietnam_visa/visa_details/visa_details', $data, $data['is_mobile']);
        }
        else
        {
            $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_DETAILS_PAGE);

            $data['why_apply'] = $this->load->view('vietnam_visa/common/why_apply', $data, TRUE);

            $data['apply_form'] = $this->load->view('vietnam_visa/visa_details/apply_form', $data, TRUE);

            render_view('/vietnam_visa/visa_details/visa_details', $data, $data['is_mobile']);
        }
    }

    /**
     * _save
     *
     * @author toanlk
     * @since  May 15, 2015
     */
    function _save($action)
    {
        $rowId = $this->input->post('rowId');

        $visa_booking = get_visa_booking();

        if ($this->_validate_booking($visa_booking['number_of_visa']))
        {
            // save visa booking to the session
            $visa_booking = update_visa($visa_booking, true);

            // redirect to my booking
            if ($action == ACTION_CHECKOUT)
            {
                redirect(get_page_url(VN_VISA_PAYMENT_PAGE));
            }
            elseif ($action == 'add_to_cart')
            {
                // insert visa to cart
                insert_visa_to_cart($visa_booking);

                redirect(get_page_url(MY_BOOKING_PAGE));
            }
        }
    }

    /**
     * _validateBooking
     *
     * @author toanlk
     * @since  May 15, 2015
     */
    function _validate_booking($number_of_visa)
    {
        $this->form_validation->set_error_delimiters('<label class="error">', '</label><br>');

        $applicant_rules = $this->config->item('applicant_rules');
        $this->form_validation->set_rules($applicant_rules);

        $this->form_validation->set_rules('visa_nationality', 'visa_nationality', 'required');
        $this->form_validation->set_rules('numb_visa', 'numb_visa', 'required');
        $this->form_validation->set_rules('visa_type', 'visa_type', 'required');
        $this->form_validation->set_rules('rush_service', 'rush_service', 'required');

        for ($i = 0; $i < $number_of_visa; $i ++)
        {
            $this->form_validation->set_rules('nationality' . $i, 'Nationality', 'required');
            $this->form_validation->set_rules('gender' . $i, 'Gender', 'required');
            $this->form_validation->set_rules('birth_day' . $i, 'birth_day', 'required');
            $this->form_validation->set_rules('birth_month' . $i, 'birth_month', 'required');
            $this->form_validation->set_rules('birth_year' . $i, 'birth_year', 'required');

            $this->form_validation->set_rules('passport_name' . $i, 'Passport Name', 'required|max_length[100]|xss_clean');
            $this->form_validation->set_rules('birthday' . $i, 'Date of Birth', 'required|callback_is_valid_birthday');
            $this->form_validation->set_rules('passport_number' . $i, 'Passport Number', 'required|alpha_numeric');
        }

        return $this->form_validation->run();
    }
    
    function is_valid_date($d)
    {
        if (trim($d) != '' && ! $this->timedate->is_date($d))
        {
            $this->form_validation->set_message('is_valid_date', 'The Arrival Date field must be a valid date');
            return false;
        }
    
        if (strtotime($d) <= strtotime('today'))
        {
            $this->form_validation->set_message('is_valid_date', 'The Arrival Date field must be in the future');
            return false;
        }
    
        $processing_time = $this->input->post('visa_type');
    
        if (! is_allow_online_payment($d, $processing_time))
        {
            $this->form_validation->set_message('is_valid_date', 'Your date of arrival must be greater than the date of receive visa');
            return false;
        }
    
        return true;
    }
    
    function is_valid_expired_date($d)
    {
    
        // set timezone
        date_default_timezone_set('Asia/Ho_Chi_Minh');
    
        if (trim($d) != '' && ! $this->timedate->is_date($d))
        {
            $this->form_validation->set_message('is_valid_expired_date', 'The Passport Expired field must be a valid date');
            return false;
        }
    
        // Passport expired must valid at least 6 months
        $arrival_date = $this->input->post('arrival_date');
    
        if ($this->timedate->is_date($arrival_date))
        {
            if (strtotime($d) < strtotime($arrival_date . ' + 6 months'))
            {
                $this->form_validation->set_message('is_valid_expired_date', 'The Passport Expired field must be valid at least 6 months');
                return false;
            }
        }
    
        return true;
    }
    
    function is_valid_birthday($d)
    {
        if (! (strtotime($d) < strtotime('today')))
        {
            $this->form_validation->set_message('is_valid_birthday', 'The Date of Birth field must be in the past');
            return false;
        }
    }
    
    function compare_subm_dates()
    {
        $exit_date = $this->input->post('exit_date');
        $arrival_date = $this->input->post('arrival_date');
    
        if (strtotime($exit_date) <= strtotime($arrival_date))
        {
            $error_message = 'The Exit Date must be greater than the Arrival Date.';
            $this->form_validation->set_message('compare_subm_dates', $error_message);
            return false;
        }
    
        return true;
    }
}
?>