<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cruise_Ajax extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->helper(array('basic','resource','tour_search','cruise','tour','tour_rate','review','text','recommend'));

		$this->load->language(array('cruise'));
		
		$this->load->model(array('Tour_Model','Cruise_Model','Destination_Model', 'BookingModel'));

		// for test only
		//$this->output->enable_profiler(TRUE);
	}
	
	/**
	 * Get Cruise Price From
	 * 
	 * @author Khuyenpv
	 * @since 10.04.2015
	 */
	public function get_cruise_price_from()
    {
        $is_mobile = is_mobile();
        
        $cruise_ids = $this->input->post('cruise_ids');
        
        $departure_date = get_current_tour_departure_date();
        
        $prices = $this->Cruise_Model->get_cruise_price_from_ajax($cruise_ids, $departure_date);
        
        foreach ($prices as $key => $value)
        {
            if($is_mobile) {
                $value['offer_rate'] = 0;
            
                if($value['is_hot_deals'] == 1) {
                    $value['offer_rate'] = ($value['price_origin'] - $value['price_from'])/$value['price_origin'] * 100;
                }
                
                unset($value['service_includes']);
                unset($value['service_excludes']);
            } else {
                unset($value['is_hot_deals']);
                
                $value['service_includes'] = generate_string_to_list($value['service_includes'], 'bpt-list-standard');
                
                $value['service_excludes'] = generate_string_to_list($value['service_excludes'], 'bpt-list-standard');
            }
            
            $prices[$key] = $value;
        }
        
        echo json_encode($prices);
    }
	
	
	/**
	 * Ajax functions for Cruise-Overview
	 *
	 * @author Khuyenpv
	 * @since 14.04.2015
	 */
	function see_overview(){
	
		$is_mobile = is_mobile();
		
		$departure_date = get_current_tour_departure_date();
		
		$url_title = $this->input->post('url_title');
		
		$cruise = $this->Cruise_Model->get_cruise_detail($url_title);
		
		// set image slider
		$is_free_visa = !is_visitor_in_hanoi();
		$photos = $this->Cruise_Model->get_cruise_photos($cruise['id']);
		$view_data = load_photo_slider(array(), $is_mobile, $photos, PHOTO_FOLDER_CRUISE, $is_free_visa);
		
		// set special offers
		$cruise['special_offers'] = empty($cruise['promotions']) ? '' : load_promotion_popup($is_mobile, $cruise['promotions']);
		
		// get cruise price from
		$cruises = array($cruise);
		$cruises = $this->Cruise_Model->get_cruise_price_froms($cruises, $departure_date);
		$cruise = $cruises[0];
		
		$view_data['cruise'] = $cruise;
		
		$view_data['cabins'] = $this->Cruise_Model->get_cruise_cabins($cruise['id']);
	
	
		$overview['title'] = $cruise['name']. ' <span class="icon '.get_icon_star($cruise['star'], true).'"></span>';
		$overview['content'] = load_view('cruises/common/cruise_overview', $view_data, $is_mobile);
		
		echo json_encode($overview);
	}
	
	/**
	 * Show more cruises by type
	 *
	 * @author toanlk
	 * @since  Apr 15, 2015
	 */
	function show_more_cruise_by_type()
    {
        $data = $this->input->post('data');
        
        if (! empty($data['page']) && ! empty($data['offset']) && is_numeric($data['offset']))
        {
            $is_mobile = is_mobile();
            
            $departure_date = get_current_tour_departure_date();
            
            $cruises = $this->Cruise_Model->get_most_recommended_cruises($data['page'], 10, $data['offset']);
            
            if (! empty($cruises))
            {
                $view_data['is_enable_number'] = $data['is_enable_number'];
                
                if (count($cruises) < 10)
                {
                    $number_of_cruises = count($cruises);
                }
                else
                {
                    $numb_cruises = $this->Cruise_Model->get_most_recommended_cruises($data['page'], null, null);
                    $number_of_cruises = count($numb_cruises);
                }
                
                $view_data['page'] = $data['page'];
                
                $view_data['page_title'] = lang($data['page']);
                
                $view_data['is_show_more'] = $number_of_cruises > count($cruises) ? true : false;
                
                $view_data['cruises'] = $this->Cruise_Model->get_cruise_price_froms($cruises, $departure_date);
                
                $cruise_overview = load_view('cruises/common/list_cruises', $view_data, $is_mobile);
                
                echo $cruise_overview;
            }
        }
    }
}

?>