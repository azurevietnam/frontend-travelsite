<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Visa Payment
 *
 * @author toanlk
 * @since  May 11, 2015
 */
class Visa_Payment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Visa_Model');
        
        $this->load->language('visa');
        
        $this->load->library('form_validation');
        
        $this->load->helper(array('basic', 'resource', 'visa', 'recommend', 'form', 'contact', 'payment'));
        
        // for test only
        // $this->output->enable_profiler(TRUE);
    }

    function index()
    { 
        $data = $this->_get_common_data();
        
        // get page meta title, keyword, description, canonical, ...etc
        $data['page_meta'] = get_page_meta(VN_VISA_PAYMENT_PAGE);
        
        $data['page_theme'] = get_page_theme(VN_VISA_PAYMENT_PAGE, $data['is_mobile']);
        
        $data = get_page_main_header_title($data, $data['is_mobile'], VN_VISA_PAYMENT_PAGE);
        
        $data = get_page_navigation($data, $data['is_mobile'], VN_VISA_PAYMENT_PAGE);
        
        // breadcrumb
        $data['current_step'] = 2;       
        $data['step_labels'] = $this->config->item('visa_step_labels');    
        $data['breadcrumb'] = load_view('/common/booking/booking_steps', $data, $data['is_mobile']);
        
        // load visa contact here
        // whenever users update form, system have to recalculate price
        $data = load_contact_form($data, $data['is_mobile'], 'save_visa_payment', false, array(), true, 'validation_visa_call_back');
        
        // get visa booking in session
        $visa_booking = get_visa_booking(true);
        
        // if session is empty get in shopping cart
        if (empty($visa_booking) && is_allow_online_payment_4_visa_in_shopping_cart())
        {
            $visa_booking = get_first_visa_booking_in_cart();
        }
        
        // check empty visa booking
        if ( empty($visa_booking) || (! empty($visa_booking) && empty($visa_booking['visa_details'])) )
        {
            redirect(get_page_url(VN_VISA_PAGE));
        }
        
        $data['visa_booking'] = $visa_booking;
        
        $data['my_booking'] = $this->get_my_booking($visa_booking);
        
        // Get receive date
        $receive_date = get_visa_receive_date($visa_booking['processing_time']);
        
        $data['receive_date'] = get_receive_date_lang($receive_date);
        
        $data['visa_applications'] = load_view('vietnam_visa/payment/visa_applications', $data, $data['is_mobile']);
        
        $data['booking_details'] = load_view('vietnam_visa/payment/booking_details', $data, $data['is_mobile']);
        
        render_view('vietnam_visa/payment/visa_payment', $data, $data['is_mobile']);
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
        
        // Get all normal nationalities
        $data['visa_countries'] = $this->Visa_Model->get_nationalities(true);
    
        $data['visa_types'] = $this->config->item('visa_types');
        
        $data['rush_services'] = $this->config->item('rush_services');
        
        $data['bank_fee'] = $this->config->item('bank_fee');
       
        $data['airports'] = $this->config->item("airports");
    
        $data['is_mobile'] = $is_mobile;
    
        return $data;
    }
    
    /**
     * get_my_booking
     *
     * @author toanlk
     * @since  May 15, 2015
     */
    function get_my_booking($visa_booking)
    {
        $visa_types = $this->config->item('visa_types');
        
        $rush_services = $this->config->item('rush_services');
        
        $bank_fee = $this->config->item('bank_fee');
        
        $options = array();
        
        $options['start_date'] = $visa_booking['arrival_date'];
        
        $options['end_date'] = $visa_booking['exit_date'];
        
        $service_name = lang('vietnam_visa') . ': <br>';
        
        $service_name .= translate_text($visa_types[$visa_booking['type_of_visa']]) . ' - ' .
             translate_text($rush_services[$visa_booking['processing_time']]);
        
        $service_name .= ' - ' . lang('label_arrival') . ' ' . date(DATE_FORMAT_DISPLAY, strtotime($options['start_date']));
        
        $options['service_name'] = $service_name;
        
        $options['unit'] = $visa_booking['number_of_visa'] .
             ($visa_booking['number_of_visa'] > 1 ? ' ' . lang('label_visas') : ' ' . lang('label_visa'));
        
        $options['selling_price'] = number_format($visa_booking['total_price'], CURRENCY_DECIMAL);
        
        $options['final_total'] = round($visa_booking['total_price'], CURRENCY_DECIMAL) +
             number_format($visa_booking['total_price'] * $bank_fee / 100, 2);
        
        return $options;
    }
}
?>