<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
  * Tour Booking Helper Functions
  *
  *@category	Helpers
  * @author toanlk
  * @since  Jun 24, 2015
  */


/**
  * load_tour_extra_services
  *
  * @author toanlk
  * @since  Jun 24, 2015
  */
function load_hotel_extra_services($data, $is_mobile, $hotel) {
	
	$CI = & get_instance();
    $CI->load->model(array('Tour_Model','Hotel_Model'));
    
    $action = $CI->input->post('action');
    
    if ($action == ACTION_DELETE)
    {
        $rowid = $CI->input->post('rowid');
        remove_booking_item($rowid);
    }
	
	$parent_booking_rowid = $CI->session->flashdata('curent_booking_rowid');


	$view_data['booking_items'] = $booking_items = get_hotel_booking_items($hotel['id'], $parent_booking_rowid, HOTEL_CHILDREN_RATE);
	
	$view_data['booking_total'] = calculate_booking_total($booking_items);
	
	$view_data['hotel'] = $hotel;

	
	$current_boooking_item = !empty($booking_items) ? $booking_items[0] : array();
	$view_data['parent_id'] = !empty($current_boooking_item) ? $current_boooking_item['rowid'] : '';
	
	$data['extra_services'] = load_view('tours/booking/extra_services', $view_data, $is_mobile);
	
	$data['current_booking_item'] = $current_boooking_item;

	return $data;
}

/**
 * Get all booking item related to the current selected hotel
 * 
 * @author Khuyenpv 
 * @since 01.04.2015
 */
function get_hotel_booking_items($hotel_id, $parent_booking_rowid, $children_rate = HOTEL_CHILDREN_RATE)
{
    $main_item = false;
    
    $related_booking_items = array();
    
    $my_booking = get_my_booking();
    
    foreach ($my_booking as $key => $booking_item)
    {
        
        if ($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL)
        {
            if (! empty($parent_booking_rowid))
            {
                if ($booking_item['rowid'] == $parent_booking_rowid)
                {
                    $main_item = $booking_item;
                }
            }
            else
            {
                
                if ($booking_item['service_id'] == $hotel_id)
                {
                    $main_item = $booking_item;
                }
            }
        }
    }
    
    if ($main_item)
    {
        foreach ($my_booking as $key => $booking_item)
        {
            if ($booking_item['parent_id'] == $main_item['rowid'])
            {
                $related_booking_items[] = $booking_item;
            }
        }
        
        array_unshift($related_booking_items, $main_item);
        
        $related_booking_items = set_booking_item_optional_services($related_booking_items, $children_rate);
        
        return $related_booking_items;
    }
    else
    {
        return array();
    }
}

?>