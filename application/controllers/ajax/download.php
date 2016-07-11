<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *  Download
 *
 *  @author TinVM
 *  @since  Apr 15 2015
 */


class Download extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('download');

    }

    function index ($service, $file_name){

        $system_path = str_replace('system/', 'resources/' . $service . '/' . $file_name, BASEPATH);

        force_download($file_name, $system_path);
    }

    function download_tour_itinerary($file_name){
        $file_name = $file_name.'.pdf';

        $system_path = str_replace('system/', 'itinerary' . '/' . $file_name, BASEPATH);

        force_download($file_name, $system_path);
    }
}