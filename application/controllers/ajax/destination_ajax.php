<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Destination_Ajax extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('basic', 'resource', 'text'));

        $this->load->model(array('Destination_Model'));

        // for test only
        //$this->output->enable_profiler(TRUE);
    }

    /**
     * TinVM Mar31 2015
     * Destination Attraction add element when show more
     */

    function load_more_attraction(){

    	$is_mobile = is_mobile();

        $end_value = $this->input->post('end_value');

        $destination_id = $this->input->post('destination_id');

        $count_attractions = $this->Destination_Model->get_attractions($destination_id, '', '', true);

        $destination = $this->Destination_Model->get_destination($destination_id);

        if($count_attractions > 0){
        	
        	$attractions = $this->Destination_Model->get_attractions($destination_id, DESTINATION_ATTRACTION_MAX_LIST, $end_value);

            if($destination['destination_type'] == DESTINATION_TYPE_COUNTRY)
            {
            	$attractions = $this->Destination_Model->get_attractions($destination['id'], DESTINATION_ATTRACTION_MAX_LIST, $end_value, '', '', '', true);
            	foreach ($attractions as $key=>$value) {
            		if($value['type'] != DESTINATION_TYPE_CITY)
            			unset($attractions[$key]);
            	}
            }
            
            $view_data['attractions'] = $attractions;

            $view_data['count_attractions'] = $count_attractions;

            $new_list_attraction = load_view('destinations/attraction/list_attractions', $view_data, $is_mobile);

            echo($new_list_attraction);

        } else {

            echo(false);
        }
    }

    /**
     * TinVM Apr16 2015
     * Destination Thing to do add element when show more
     */

    function load_more_thing_todo(){
    	
        $is_mobile = is_mobile();

        $end_value = $this->input->post('end_value');

        $destination_id = $this->input->post('destination_id');
        
        $url_title = $this->input->post('url_title');

        $count_activity = $this->Destination_Model->get_things_to_do($destination_id, '', '', true);
        
        $destination = $this->Destination_Model->get_destination_detail($url_title);
        
        if($count_activity > 0){
        	
            $activities = $this->Destination_Model->get_things_to_do($destination_id, DESTINATION_THING_TO_DO_MAX_LIST, $end_value);
            
            $view_data['things_to_do'] = $activities;
            
           	$view_data['destination'] = $destination;

            $view_data['count_activity'] = $count_activity;

            $new_list_attraction = load_view('destinations/things_to_do/list_things_to_do', $view_data, $is_mobile);

            echo($new_list_attraction);
            
        } else {

            echo(false);
        }
    }

    /**
     * Ajax functions for Destination-Overview
     *
     * @author Khuyenpv
     * @since 14.04.2015
     */
    function see_overview(){

    	$is_mobile = is_mobile();

    	$url_title = $this->input->post('url_title');

    	$destination = $this->Destination_Model->get_destination_detail($url_title);

    	// set image slider
    	$photos = $this->Destination_Model->get_destination_photos($destination['id']);

    	$view_data = load_photo_slider(array(), $is_mobile, $photos, PHOTO_FOLDER_DESTINATION, false);
    	$view_data['destination'] = $destination;

    	$overview['title'] = $destination['name'];

    	if(!empty($destination['title'])){
    		$overview['title'] .=  ' - '. $destination['title'];
    	}


    	$overview['content'] = load_view('destinations/common/destination_overview', $view_data, $is_mobile);

    	echo json_encode($overview);
    }
}