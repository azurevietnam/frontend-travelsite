<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Reviews for ajax request
 *
 * @author toanlk
 * @since  Mar 27, 2015
 */
class Review extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper( array('review', 'basic') );
        $this->load->model( array('Review_Model','Tour_Model','Cruise_Model') );

        $this->load->language( array('cruise', 'tourdetail') );
    }

    function index($url_title)
    {
        $is_mobile = is_mobile();

        // check if its an ajax request, exit if not
        if ($this->input->is_ajax_request())
        {
            $search_criteria = $this->get_search_param();

            $review_object = $this->Review_Model->get_review_object($search_criteria, $url_title);

            $is_paging = !empty($search_criteria['page']) || isset($_GET["page"]) ? true : false;

            $service_type = $search_criteria['service_type'];

            if($service_type == TOUR && !empty($review_object['cruise_id'])) {
                $service_type = CRUISE;
            }

            echo load_customer_reviews(array(), $is_mobile, $review_object, $service_type, TRUE, $is_paging);
        }
    }

    function get_search_param() {

        $search_criteria = array();

        $tour_id = $this->input->get('tour_id');

        if (! empty($tour_id))
        {
            $search_criteria['tour_id'] = $tour_id;

            $search_criteria['service_type'] = TOUR;
        }

        $cruise_id = $this->input->get('cruise_id');

        if (! empty($cruise_id))
        {
            $search_criteria['cruise_id'] = $cruise_id;

            $search_criteria['service_type'] = CRUISE;
        }

        $hotel_id = $this->input->get('hotel_id');

        if (! empty($hotel_id))
        {
            $search_criteria['hotel_id'] = $hotel_id;

            $search_criteria['service_type'] = HOTEL;
        }

        $review_score = $this->input->get('review_score');

        if ($review_score != '')
        {
            $search_criteria['review_score'] = $review_score;
        }

        $customer_type = $this->input->get('customer_type');

        if ($customer_type != '')
        {
            $search_criteria['customer_type'] = $customer_type;
        }

        $page = $this->input->get('page');

        if ($page != '')
        {
            $search_criteria['page'] = $page;
        }

        return $search_criteria;
    }
}
