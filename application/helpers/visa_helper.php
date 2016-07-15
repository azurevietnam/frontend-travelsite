<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Visa Helper Class
 *
 * Store visa booking in session and calculate visa fees
 *
 * @author toanlk
 * @since  Nov 17, 2014
 */

// ------------------------------------------------------------------------

/**
 * Create visa booking
 *
 * Create new visa booking in session.
 *
 */
function _create_visa_booking($is_details = false, $visa_booking = null)
{
    $CI = & get_instance();
    
    $visa_booking = array();
        
    $visa_booking['type_of_visa'] = $CI->input->post('visa_type');
    $visa_booking['number_of_visa'] = $CI->input->post('numb_visa');
    $visa_booking['nationality'] = $CI->input->post('visa_nationality');
    $visa_booking['processing_time'] = $CI->input->post('rush_service');
    
    // $is_discount = get_discount_visa_type();
    
    $is_free = false;
    $is_discount = 0; // normal book
    /*
     * if($is_discount == 2) { // booked halong bay cruise service $is_free = true; }
     */

    $visa_prices = $CI->Visa_Model->get_visa_rates($visa_booking['nationality'], $visa_booking['number_of_visa'], $visa_booking['type_of_visa']);
    
    $visa_rates = _get_visa_prices($visa_prices, $visa_booking['number_of_visa'], $visa_booking['type_of_visa'], $visa_booking['processing_time'], $is_discount, $is_free);
    
    // $visa_booking['discount'] = 0;
    $visa_booking['discount'] = $visa_prices['discount'];
    $visa_booking['total_discount'] = 0;
    $visa_booking['price'] = $visa_prices['price'];
    if ($visa_booking['processing_time'] == VISA_URGENT_SERVICE)
    {
        $visa_booking['price'] = $visa_prices['price'] + $visa_prices['urgent_price'];
    }
    
    if ($is_discount)
    {
        $visa_booking['total_discount'] = $visa_rates['discount'];
    }
    
    if ($is_free)
    {
        $visa_booking['discount'] = $visa_prices['price'];
        $visa_booking['total_discount'] = $visa_rates['discount'];
    }
    
    $visa_booking['total_price'] = $visa_rates['rate'] + $visa_booking['total_discount'];
    
    $visa_booking['arrival_date'] = null;
    $visa_booking['exit_date'] = null;
    $visa_booking['flight_number'] = null;
    $visa_booking['arrival_airport'] = null;
    $visa_booking['visa_details'] = null;
    
    $visa_booking['rowId'] = time();
    $CI->session->set_userdata('last_visa_details', $visa_booking);
    
    return $visa_booking;
}

// ------------------------------------------------------------------------

/**
 * _update_visa_details
 *
 * Update visa booking information
 *
 * @author toanlk
 * @since  Nov 17, 2014
 */
function _update_visa_details($visa_booking, $arrival_details = false)
{
    $CI = & get_instance();
    
    // Update visa information
    
    if ($arrival_details)
    {
        $visa_booking['detail_type'] = $CI->input->post('detail_type');
        $visa_booking['arrival_date'] = $CI->input->post('arrival_date');
        $visa_booking['exit_date'] = $CI->input->post('exit_date');
        $visa_booking['flight_number'] = $CI->input->post('flight_number');
        $visa_booking['arrival_airport'] = $CI->input->post('arrival_airport');
    }
    
    $visa_details = array();
    
    $nationalities = array();
    
    if ($arrival_details)
    {
        for ($i = 1; $i <= $visa_booking['number_of_visa']; $i ++)
        {
            $visa_detail['gender'] = $CI->input->post('gender' . $i);
            $visa_detail['nationality'] = $CI->input->post('nationality' . $i);
            $visa_detail['nationality_name'] = $CI->input->post('nationality_name' . $i);
            $visa_detail['birthday'] = $CI->input->post('birthday' . $i);
            $visa_detail['passport_name'] = $CI->input->post('passport_name' . $i);
            $visa_detail['passport_number'] = $CI->input->post('passport_number' . $i);
            $visa_detail['passport_expired'] = $CI->input->post('passport_expired' . $i);
            
            // $nationalities[] = $visa_detail['nationality'];
            
            $visa_details[] = $visa_detail;
        }
    }
    else
    {
        for ($i = 0; $i < $visa_booking['number_of_visa']; $i ++)
        {
            $visa_detail['gender'] = $CI->input->post('gender' . $i);
            $visa_detail['nationality'] = $CI->input->post('nationality' . $i);
            $visa_detail['nationality_name'] = $CI->input->post('nationality_name' . $i);
            $visa_detail['birthday'] = $CI->input->post('birthday' . $i);
            $visa_detail['passport_name'] = $CI->input->post('passport_name' . $i);
            $visa_detail['passport_number'] = $CI->input->post('passport_number' . $i);
            $visa_detail['passport_expired'] = $CI->input->post('passport_expired' . $i);
            
            // $nationalities[] = $visa_detail['nationality'];
            
            $visa_details[] = $visa_detail;
        }
    }
    
    $visa_booking['visa_details'] = $visa_details;
     
    $CI->session->set_userdata('last_visa_details', $visa_booking);
    
    return $visa_booking;
}

// ------------------------------------------------------------------------

/**
 * Clear visa booking in session
 *
 * @author toanlk
 * @since  Nov 17, 2014
 */
function _clear_visa_booking()
{
    $CI = & get_instance();
    $CI->session->unset_userdata('last_visa_details');
}

// ------------------------------------------------------------------------

/**
 * _get_visa_booking
 *
 * @author toanlk
 * @since  Nov 17, 2014
 */
function _get_visa_booking()
{
    $CI = & get_instance();

    if ($CI->session->userdata('last_visa_details'))
    {
        $visa_booking = $CI->session->userdata('last_visa_details');

        return $visa_booking;
    }

    return null;
}

// ------------------------------------------------------------------------

/**
 * check_visa_booking
 *
 * @author toanlk
 * @since  Nov 17, 2014
 */
function check_visa_booking($visa_booking)
{
    if (empty($visa_booking))
    {
        return false;
    }
    
    if (! (isset($visa_booking['detail_type']) && $visa_booking['detail_type'] == 2))
    {
        if (! isset($visa_booking['visa_details']) || empty($visa_booking['visa_details']))
        {
            return false;
        }
    }
    
    return true;
}

function get_receive_date_lang($receive_date)
{
    return lang('receive_date') . '<span style="color:red;font-weight:bold">' . $receive_date . '</span>' . ' (GMT+7).';
}

function _get_rate_of_visa()
{
    $CI = & get_instance();
    
    $nationality = $CI->input->post('nationality');
    $numb_visa = $CI->input->post('numb_visa');
    $visa_type = $CI->input->post('visa_type');
    $rush_service = $CI->input->post('rush_service');
    $no_discount = $CI->input->post('no_discount');
    
    // $time_start = microtime(true);
    
    $visa_prices = _get_visa_rates_table($nationality, $numb_visa, $visa_type, $rush_service);
    
    $is_free = false;
    $is_discount = false;
    /*
     * if($no_discount != 1) { $is_discount = get_discount_visa_type(); // $is_discount = 1 : normal book if($is_discount == 2) { // booked halong bay cruise service $is_free = true; } }
     */
    
    $visa_rates = _get_visa_prices($visa_prices, $numb_visa, $visa_type, $rush_service, $is_discount, $is_free);
    
    return $visa_rates;
}

function _get_visa_prices($visa_prices, $numb_visa, $visa_type, $rush_service, $is_discount = false, $is_free = false)
{
    $price = 0;
    
    if (isset($visa_prices['price']))
    {
        $total_fee = $visa_prices['price'] * $numb_visa;
        $price = $visa_prices['price'];
    }
    else
    {
        $total_fee = 0;
    }
    
    if ($rush_service == VISA_URGENT_SERVICE)
    {
        $total_fee += ($visa_prices['urgent_price'] * $numb_visa);
        $price = $visa_prices['price'] + $visa_prices['urgent_price'];
    }
    
    $discount = 0;

    if ($is_free)
    {
        $discount = $total_fee;
        $total_fee = 0;
    }
    elseif ($is_discount)
    {
        $discount = $visa_prices['discount'] * $numb_visa;
        $total_fee = $total_fee - $discount;
    }
    
    if ($total_fee == 0)
    {
        if (! empty($visa_prices['price']))
        {
            $total_fee = lang('label_visa_free');
        }
        else
        {
            $total_fee = lang('label_visa_na');
        }
    }
    
    $visa_rates = array(
        'rate'      => $total_fee,
        'discount'  => $discount,
        'price'     => $price
    );
    
    return $visa_rates;
}

function _get_visa_rates_table($nationality, $numb_visa, $visa_type, $rush_service)
{
    $CI = & get_instance();
    
    $rates_table = $CI->Visa_Model->get_visa_group_price();
    
    $visa_prices = array();
    
    // get visa group id
    $group_id = 0;
    foreach ($rates_table as $rates_t)
    {
        if(!empty($rates_t['country'])) {
            foreach ($rates_t['country'] as $country)
            {
                if ($country == $nationality)
                {
                    $group_id = $rates_t['id'];
                }
            }
        }
    }
    
    // get visa price
    foreach ($rates_table as $rates_t)
    {
        
        if ($rates_t['id'] == $group_id)
        {
            
            foreach ($rates_t['price'] as $key => $v_price)
            {
                
                if ($visa_type == $key)
                {
                    foreach ($v_price as $rates)
                    {
                        if ($numb_visa == $rates['quantity'])
                        {
                            $visa_prices['price'] = $rates['price'];
                            $visa_prices['urgent_price'] = $rates['urgent_price'];
                            $visa_prices['discount'] = $rates['discount'];
                        }
                    }
                }
            }
        }
    }
    
    return $visa_prices;
}

function get_visa_receive_date($processing_type, $booked_date = '', $format_date = 'h:i A, l d F Y')
{
    // set timezone
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    
    // $booked_date = '9/27/2013 10:0:0';
    if (empty($booked_date))
        $booked_date = date('Y-m-d H:i:s');
        
        // Normal processing only
    if ($processing_type == 1)
    {
        $numb_day = 3;
    }
    else
    {
        $numb_day = 1;
    }
    
    $receive_date = addWorkingDays(strtotime($booked_date), $numb_day);
    
    // set return time base on current time
    if (date('H', strtotime($booked_date)) < 11)
    { // if booking time is morning (before 11:00 AM)
        $receive_date = mktime(11, 00, 0, date('m', $receive_date), date('d', $receive_date), date('Y', $receive_date));
    }
    else if (date('H', strtotime($booked_date)) < 15)
    { // if booking time is afternoon (before 03:00 PM)
        
        $receive_date = mktime(17, 00, 0, date('m', $receive_date), date('d', $receive_date), date('Y', $receive_date));
    }
    else
    { // return in the next day
        
        $receive_date = addWorkingDays(strtotime($booked_date), $numb_day + 1);
        $receive_date = mktime(11, 00, 0, date('m', $receive_date), date('d', $receive_date), date('Y', $receive_date));
    }
    
    return date($format_date, $receive_date);
}

function addWorkingDays($timestamp, $days, $skipdays = array("Saturday", "Sunday"), $skipdates = NULL)
{
    // $skipdays: array (Monday-Sunday) eg. array("Saturday","Sunday")
    // $skipdates: array (YYYY-mm-dd) eg. array("2012-05-02","2015-08-01");
    // timestamp is strtotime of ur $startDate
    // timestamp = strtotime('29-01-2014');
    $i = 1;
    
    while ($days >= $i)
    {
        $timestamp = strtotime("+1 day", $timestamp);
        if (! in_array(date("l", $timestamp), $skipdays) && ! is_holiday($timestamp))
        {
            $i ++;
        }
    }
    
    return $timestamp;
}

/*
 * check if it's holiday
 */
function is_holiday($cr_date)
{
    $CI = & get_instance();
    
    $c_year = date('Y', $cr_date);
    
    $cr_date = strtotime(date(DATE_FORMAT_STANDARD, $cr_date), 0);
    
    // Public Holidays
    $holidays = $CI->config->item('public_holidays');
    
    foreach ($holidays as $holiday)
    {
        
        if (is_array($holiday))
        { // if it's Luna Calendar
            
            foreach ($holiday as $k => $date)
            {
                if ($c_year == $k)
                {
                    $p_holiday = $date . '-' . $c_year;
                    
                    if ($cr_date == strtotime($p_holiday, 0))
                    {
                        return true;
                    }
                }
            }
        }
        else
        { // Gregorian Calendar
            if ($cr_date == strtotime($holiday . '-' . $c_year, 0))
            {
                return true;
            }
        }
    }
    
    // Lunar New Year :-)
    $lunar_new_year = $CI->config->item('lunar_new_year');
    foreach ($lunar_new_year as $k => $date)
    {
        if ($c_year == $k)
        {
            $lunar_new_year = $date . '-' . $c_year;
            
            if ($cr_date == strtotime($lunar_new_year, 0))
            {
                return true;
            }
        }
    }
    
    // Visa : Day Off
    $visa_day_off = $CI->config->item('visa_day_off');
    foreach ($visa_day_off as $date)
    {
        
        $y = substr($date, - 4);
        if ($c_year == $y)
        {
            
            if ($cr_date == strtotime($date, 0))
            {
                return true;
            }
        }
    }
    
    return false;
}

function get_countries_by_letter($countries, $letter)
{
    $lstCountry = array();
    
    foreach ($countries as $country)
    {
        $name = $country['name'];
        if (substr($name, 0, 1) == $letter)
        {
            if (! empty($country['embassy_address']))
            {
                $lstCountry[] = $country;
            }
        }
    }
    
    return $lstCountry;
}

function get_visa_theme($data, $js_lib = true)
{
    
    // css
    $data['inc_css'] = get_static_resources('visa.min.120120151154.css');
    
    // js
    if ($js_lib)
    {
        $data['inc_js'] = get_static_resources('visa.min.120120151211.js');
    }
    
    return $data;
}

function get_booking_together_recommend($data)
{
    $CI = & get_instance();
    
    $departure_date = date('d-m-Y');
    
    if ($CI->session->userdata("FE_tour_search_criteria"))
    {
        
        $search_criteria = $CI->session->userdata("FE_tour_search_criteria");
        
        if (isset($search_criteria['departure_date']))
        {
            
            $departure_date = $search_criteria['departure_date'];
        }
    }
    
    $data['atts'] = get_popup_config('extra_detail');
    
    $rates_table = $CI->Visa_Model->get_visa_group_price();
    
    $min_visa_discount = 0;
    
    foreach ($rates_table as $k => $t)
    {
        if ($k < 1)
        {
            $min_visa_discount = $t['price'][1][0]['discount'];
            break;
        }
    }
    
    $min_visa_discount = $CI->Visa_Model->get_min_visa_discount();
    
    $data['min_visa_discount'] = $min_visa_discount;
    
    $data['recommendations'] = $CI->BookingModel->get_vietnam_visa_recommendations($departure_date, $min_visa_discount);
    
    $data['recommendation_view'] = $CI->load->view('common/remain_recommendation', $data, TRUE);
    
    return $data;
}

function get_visa_faqs($data)
{
    $CI = & get_instance();
    
    $data['faq_questions'] = $CI->FaqModel->getFaqQuestionByCategory(10);
    
    $faq_by_context_view = $CI->load->view('faq/faq_context', $data, TRUE);
    
    $data['faq_by_context_view'] = $faq_by_context_view;
    
    return $data;
}

/*
 * Check if it allows send passport details via email - Normal processing - at least 3 applicants
 */
function is_allow_visa_via_email()
{
    $visa_booking = _get_visa_booking();
    
    if (! empty($visa_booking))
    {
        if ($visa_booking['processing_time'] == 1 && $visa_booking['number_of_visa'] >= 3)
        {
            return true;
        }
    }
    
    return false;
}

/**
 * get_visa_booking_price
 *
 * Calculate visa booking price base on visa details information
 *
 * @author toanlk
 * @since  Jan 12, 2015
 */
function get_visa_booking_price($visa_booking) {
    
    $CI = & get_instance();
    
    if (! empty($visa_booking) && ! empty($visa_booking['visa_details']))
    {
        $rates_table = $CI->Visa_Model->get_visa_group_price();
        
        $total_price = 0;
        
        foreach ($visa_booking['visa_details'] as $visa_details)
        {
            $detail_price = get_visa_price_by_group($rates_table, $visa_details['nationality'], 1, $visa_booking['type_of_visa']);
           
            $visa_price = $detail_price['price'];
            
            // check processing time
            if ($visa_booking['processing_time'] == VISA_URGENT_SERVICE)
            {
                $visa_price = $detail_price['price'] + $detail_price['urgent_price'];
            }
            
            $total_price += $visa_price;
        }
        
        if ($total_price == 0)
        {
            $total_price = lang('label_visa_na');
        }
        
        $visa_booking['total_price'] = $total_price;
    }
    
    return $visa_booking;
}

/**
 * get_visa_price_by_group
 * 
 * @param int $nationality
 * @param int $numb_visa
 * @param int $visa_type
 * @param int $rush_service
 * @return visa_price
 */
function get_visa_price_by_group($rates_table, $nationality, $numb_visa, $visa_type) {
    
    $visa_prices = array();
    
    // get visa group id
    $group_id = 0;
    
    foreach ($rates_table as $rates_t)
    {
        if(!empty($rates_t['country'])) {
            foreach ($rates_t['country'] as $country)
            {
                if ($country == $nationality)
                {
                    $group_id = $rates_t['id'];
                }
            }
        }
    }
    
    // get visa price
    foreach ($rates_table as $rates_t)
    {
        // check group
        if ($rates_t['id'] == $group_id) {
            
            foreach ($rates_t['price'] as $key => $v_price) {

                // check type of visa
                if ($visa_type == $key) {
                    
                    foreach ($v_price as $rates) {

                        // check number of applicants
                        if ($numb_visa == $rates['quantity']) {
                            $visa_prices['price'] = $rates['price'];
                            $visa_prices['urgent_price'] = $rates['urgent_price'];
                            $visa_prices['discount'] = $rates['discount'];
                        }
                    }
                }
            }
        }
    }
    
    return $visa_prices;
}

// --------------------------------------------------------------------

/**
 * Insert items into the visa and save it to the session table
 *
 * @access	public
 * @param	bool
 * @return	array
 */
function insert_visa($is_details = false, $booking = null)
{
    $CI = & get_instance();
    
    $booking = array();
    
    $booking['type_of_visa'] = $CI->input->post('visa_type');
    $booking['number_of_visa'] = $CI->input->post('numb_visa');
    $booking['nationality'] = $CI->input->post('visa_nationality');
    $booking['processing_time'] = $CI->input->post('rush_service');
    
    $is_free = false;
    $is_discount = 0; // normal book
    
    $visa_prices = $CI->Visa_Model->get_visa_rates($booking['nationality'], $booking['number_of_visa'], $booking['type_of_visa']);
    
    $visa_rates = get_visa_prices($visa_prices, $booking['number_of_visa'], $booking['type_of_visa'], $booking['processing_time'], 
        $is_discount, $is_free);
    
    $booking['discount'] = $visa_prices['discount'];
    $booking['total_discount'] = 0;
    $booking['price'] = $visa_prices['price'];
    if ($booking['processing_time'] == VISA_URGENT_SERVICE)
    {
        $booking['price'] = $visa_prices['price'] + $visa_prices['urgent_price'];
    }
    
    if ($is_discount)
    {
        $booking['total_discount'] = $visa_rates['discount'];
    }
    
    if ($is_free)
    {
        $booking['discount'] = $visa_prices['price'];
        $booking['total_discount'] = $visa_rates['discount'];
    }
    
    $booking['total_price'] = $visa_rates['rate'] + $booking['total_discount'];
    
    $booking['arrival_date'] = null;
    $booking['exit_date'] = null;
    $booking['flight_number'] = null;
    $booking['arrival_airport'] = null;
    $booking['visa_details'] = null;
    
    $booking['rowId'] = time();
    
    $CI->session->set_userdata(VISA_BOOKING_DETAILS, $booking);
    
    return $booking;
}

// ------------------------------------------------------------------------

/**
 * update_visa
 *
 * @author toanlk
 * @since  May 15, 2015
 */
function update_visa($visa_booking, $arrival_details = false)
{
    $CI = & get_instance();

    // Update visa information
    if ($arrival_details)
    {
        $visa_booking['arrival_date'] = $CI->input->post('arrival_date');
        $visa_booking['exit_date'] = $CI->input->post('exit_date');
        $visa_booking['flight_number'] = $CI->input->post('flight_number');
        $visa_booking['arrival_airport'] = $CI->input->post('arrival_airport');
    }

    $visa_details = array();

    for ($i = 0; $i < $visa_booking['number_of_visa']; $i ++)
    {
        $visa_detail['gender'] = $CI->input->post('gender' . $i);
        $visa_detail['nationality'] = $CI->input->post('nationality' . $i);
        $visa_detail['nationality_name'] = $CI->input->post('nationality_name' . $i);
        $visa_detail['birthday'] = $CI->input->post('birthday' . $i);
        $visa_detail['passport_name'] = $CI->input->post('passport_name' . $i);
        $visa_detail['passport_number'] = $CI->input->post('passport_number' . $i);
        $visa_detail['passport_expired'] = $CI->input->post('passport_expired' . $i);
        
        $visa_details[] = $visa_detail;
    }

    $visa_booking['visa_details'] = $visa_details;

    $CI->session->set_userdata(VISA_BOOKING_DETAILS, $visa_booking);

    return $visa_booking;
}

// ------------------------------------------------------------------------

/**
 * get_visa_prices
 *
 * @author toanlk
 * @since  May 13, 2015
 */
function get_visa_prices($visa_prices, $numb_visa, $visa_type, $rush_service, $is_discount = false, $is_free = false)
{
    $price = 0;
    
    if (isset($visa_prices['price']))
    {
        $total_fee = $visa_prices['price'] * $numb_visa;
        $price = $visa_prices['price'];
    }
    else
    {
        $total_fee = 0;
    }
    
    if ($rush_service == VISA_URGENT_SERVICE)
    {
        $total_fee += ($visa_prices['urgent_price'] * $numb_visa);
        $price = $visa_prices['price'] + $visa_prices['urgent_price'];
    }
    
    $discount = 0;
    
    if ($is_free)
    {
        $discount = $total_fee;
        $total_fee = 0;
    }
    elseif ($is_discount)
    {
        $discount = $visa_prices['discount'] * $numb_visa;
        $total_fee = $total_fee - $discount;
    }
    
    if ($total_fee == 0)
    {
        if (! empty($visa_prices['price']))
        {
            $total_fee = lang('label_visa_free');
        }
        else
        {
            $total_fee = lang('label_visa_na');
        }
    }
    
    $visa_rates = array('rate' => $total_fee,'discount' => $discount,'price' => $price);
    
    return $visa_rates;
}

// ------------------------------------------------------------------------

/**
 * get_visa_booking
 *
 * @author toanlk
 * @since  May 13, 2015
 */
function get_visa_booking($is_calculate_price = false)
{
    $CI = & get_instance();

    if ($CI->session->userdata(VISA_BOOKING_DETAILS))
    {
        // get data from session
        $visa_booking = $CI->session->userdata(VISA_BOOKING_DETAILS);
        
        // recalculate price
        if($is_calculate_price) {
            $visa_booking = get_visa_booking_price($visa_booking);
        }

        return $visa_booking;
    }

    return null;
}

// ------------------------------------------------------------------------

/**
 * Empty visa booking
 *
 * @author toanlk
 * @since  May 20, 2015
 */
function empty_visa_booking()
{
    $CI = & get_instance();
    $CI->session->unset_userdata(VISA_BOOKING_DETAILS);
}

// ------------------------------------------------------------------------

/**
 * get_voa_countries
 *
 * @author toanlk
 * @since  May 12, 2015
 */
function get_voa_countries($countries)
{
    $voa_countries = array();
    
    foreach ($countries as $country)
    {
        if ($country['voa_accepted'] == 1)
        {
            $voa_countries[] = $country;
        }
    }
    
    return $voa_countries;
}

// ------------------------------------------------------------------------

/**
 * get_airport
 *
 * @author toanlk
 * @since  May 15, 2015
 */
function get_airport($airports, $arrival_airport)
{
    foreach ($airports as $key => $airport)
    {
        if ($arrival_airport == $key)
        {
            return translate_text($airport);
        }
    }
    
    return '';
}

// ------------------------------------------------------------------------

/**
 * get_current_visa_booking_info
 *
 * @author toanlk
 * @since  May 18, 2015
 */
function get_current_visa_booking_info()
{
    $CI = & get_instance();
    
    $min_visa_discount = $CI->Visa_Model->get_min_visa_discount();
    
    $current_item_info['service_type'] = VISA;
    
    $current_item_info['is_booked_it'] = false;
    
    $current_item_info['is_main_service'] = false;
    
    $current_item_info['url_title'] = '';
    
    $current_item_info['service_id'] = 0; // no service_id for Vietnam Visa
    
    $current_item_info['destination_id'] = VIETNAM;
    
    $current_item_info['normal_discount'] = $min_visa_discount;
    
    $current_item_info['parent_id'] = ''; // NO CURRENT SELECTED BOOKING ITEM
    
    $current_item_info['start_date'] = get_current_tour_departure_date();
    
    return $current_item_info;
}

// ------------------------------------------------------------------------

/**
 * save_visa_payment
 *
 * @author toanlk
 * @since  May 20, 2015
 */
function save_visa_payment()
{
    $CI = & get_instance();
    
    $CI->load->model(array('TourModel','CustomerModel'));
    
    $visa_booking = get_visa_booking(true);
        
    $reservation_infos = get_reservations_from_visa_booking($visa_booking);

    $customer = get_contact_post_data();

    $special_request = $customer['special_request'];
    unset($customer['special_request']);
    
    $customer_id = $CI->TourModel->create_or_update_customer($customer);

    $booking_id = $CI->CustomerModel->save_customer_booking($reservation_infos, $customer_id, $special_request);

    if ($booking_id !== FALSE)
    {
        if (is_allow_online_payment_4_visa_in_shopping_cart())
        {
            $CI->cart->destroy();
        }

        // create invoice
        $invoice_id = $CI->CustomerModel->create_invoice($customer_id, $booking_id);

        if ($invoice_id === FALSE)      // fail to create invoice: redirect to thank you page as normal submit
        {
            // clear visa session
            empty_visa_booking();

            redirect(get_page_url(THANK_YOU_PAGE));
        }
        else                            // success to create invoice: send email notification and redirect to Onepay
        {
            $invoice = $CI->CustomerModel->get_invoice_4_payment($invoice_id);

            // send email notification to visa booking
            send_mail_notification_visa_booking($reservation_infos, $customer, $special_request, $invoice['invoice_reference'], $visa_booking);

            // call payment module with the invoice input
            $pay_url = get_payment_url($invoice);

            // clear visa session
            empty_visa_booking();

            redirect($pay_url);
        }
    }
}

// ------------------------------------------------------------------------

/**
 * send mail visa payment notification
 *
 * @author toanlk
 * @since  May 15, 2015
 */
function send_mail_notification_visa_booking($reservation_infos, $customer, $special_request, $invoice_reference, $visa_booking)
{
    $CI = & get_instance();
    
    $CI->load->library('email');
    
    $data['my_booking'] = get_booking_items_from_visa_booking($visa_booking);
    
    $data['customer_booking'] = $reservation_infos['customer_booking'];
    $data['customer_booking']['tour_name'] = $reservation_infos['service_reservations'][0]['service_name'];
    $data['customer_booking']['special_request'] = $special_request;
    $data['invoice_reference'] = $invoice_reference;
    
    $countries = $CI->config->item('countries');
    $config_title = $CI->config->item('title');
    $customer['country_name'] = $countries[$customer['country']][0];
    $customer['title_text'] = $config_title[$customer['title']];
    
    $subject_bpt = 'Reservation: ' . $data['customer_booking']['tour_name'] . ' - ' . $customer['full_name'];
    
    $data['cus'] = $customer;
    
    $data['popup_free_visa'] = $CI->load->view('ads/popup_free_visa', $data, true);
    
    $content = $CI->load->view('common/my_booking_form_mail', $data, TRUE);
    
    /**
     * Send to visabestprice@gmail.com
     */
    $CI->email->from($customer['email'], $customer['full_name']);
    $CI->email->to(VISA_PAYMENT_NOTIFICATION_EMAIL);
    $CI->email->reply_to($customer['email']);
    $CI->email->subject($subject_bpt);
    $CI->email->message($content);
    if (! $CI->email->send())
    {
        log_message('error', 'Visa Booking - ' . $customer['full_name'] . ': Can not send email to ' . VISA_PAYMENT_NOTIFICATION_EMAIL);
    }
    
    return true;
}

// ------------------------------------------------------------------------

/**
 * validation_visa_call_back
 * 
 * update visa booking when visa applications are valid data 
 *
 * @author toanlk
 * @since  May 20, 2015
 */
function validation_visa_call_back()
{
    if (validate_visa_payment())
    {
        $visa_booking = get_visa_booking();
        
        update_visa($visa_booking);
    }
}


/**
 * validate_visa_payment
 *
 * @author toanlk
 * @since  May 20, 2015
 */
function validate_visa_payment()
{
    $CI = & get_instance();
    
    $visa_booking = get_visa_booking();
    
    //$CI->form_validation->set_message('required', 'class="bg_error"');
    //$CI->form_validation->set_error_delimiters('', '');
    
    for ($i = 0; $i < $visa_booking['number_of_visa']; $i ++)
    {
        $CI->form_validation->set_rules('nationality' . $i, 'nationality', 'required');
        $CI->form_validation->set_rules('gender' . $i, 'Gender', 'required');
        $CI->form_validation->set_rules('birth_day' . $i, 'birth_day', 'required');
        $CI->form_validation->set_rules('birth_month' . $i, 'birth_month', 'required');
        $CI->form_validation->set_rules('birth_year' . $i, 'birth_year', 'required');
        $CI->form_validation->set_rules('passport_name' . $i, 'passport_name', 'required');
        $CI->form_validation->set_rules('birthday' . $i, 'birthday', 'required');
        $CI->form_validation->set_rules('passport_number' . $i, 'passport_number', 'required');
    }
    
    return $CI->form_validation->run();
}
?>