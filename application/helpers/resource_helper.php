<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Best Price Vietnam Resource Helpers
 *
 * @category	Helpers
 * @author		khuyenpv
 * @since       Feb, 2, 2015
 */

// ------------------------------------------------------------------------

/**
 * Get static resources from cdn
 *
 * $file_names      : file name or array of file names
 * $custom_folder	: specify folder path
 * @return  mixed
 */

function get_resources($file_names, $custom_folder = '', $link_only = false)
{
        $CI = & get_instance();

        $content = '';

        $CSS_FOLDER = 'css/desktop/';

        $JS_FOLDER = 'js/';

        $resource_path = $CI->config->item('resource_path');

        // For css and javascript files
        if (! $link_only)
        {
            // If specify folder path
            if (! empty($custom_folder))
            {
                $CSS_FOLDER = $JS_FOLDER = $custom_folder;
            }

            // --- Get content
            $files = explode(',', trim($file_names));

            foreach ($files as $file)
            {
                $file = trim($file);

                if (empty($file)) continue;

                // --- Check file types CSS or JS
                if (stripos($file, '.css') !== false)
                {
                    $full_path = '<link rel="stylesheet" type="text/css" href="' . base_url() . $CSS_FOLDER . $file . '"/>' . "\n\t\t";

                    $content .= $full_path;
                }
                else if (stripos($file, '.js') !== false)
                {
                    $full_path = '<script type="text/javascript" src="' . base_url() . $JS_FOLDER . $file . '"></script>' . "\n\t\t";

                    $content .= $full_path;
                }
            }
        }

        // For image files
        if (empty($content))
        {
            $content = $resource_path . $file_names;
        }

        // Reduce Double Slashes
        $content = preg_replace("#(^|[^:])//+#", "\\1/", $content);

        return $content;
}


// ------------------------------------------------------------------------

/**
 * Get javascript library
 *
 * @access	public
 * @return	mixed
 */
    function get_libraries($names, $lib_css = '', $lib_js = '')
    {
        // --- Get content
        $libs = explode(',', trim($names));

        foreach ($libs as $lib)
        {
            switch (trim(strtolower($lib)))
            {
                case 'typeahead':
                    $lib_js .= get_resources('typeahead.bundle.js', 'libs/typeahead-0.10.5/');
                    break;

                case 'jquery-ui-datepicker':

                	$lib_css .= get_resources('jquery-ui.min.css','libs/jquery-ui-1.11.2.datepicker/');

                	if(lang_code() != 'en'){
                		$lib_js .= get_resources('i18n/datepicker-'.lang_code().'.min.071120140938.js');
                	}

                	$lib_js .= get_resources('jquery-ui.min.js','libs/jquery-ui-1.11.2.datepicker/');

                    break;
            }
        }

        $data['lib_css'] = $lib_css;
        $data['lib_js'] = $lib_js;

        return $data;
    }

    /**
     * Khuyenpv March 07 2015
     * Get JS library Asynchronous Links
     *
     */
    function get_libary_asyn($lib_name, $is_json = true, $callback = '', $is_mobile = false){
    	$resouce_links = array();

    	$CI =& get_instance();
    	$resource_path = $CI->config->item('resource_path');

    	if($lib_name == 'jquery-ui-datepicker'){

    		$resouce_links[] = $resource_path.'/libs/jquery-ui-1.11.2.datepicker/jquery-ui.min.css';

    		if($is_mobile) {
    		    $resouce_links[] = $resource_path.'/css/mobile/datepicker-ui.css';
    		}

    		if(lang_code() != 'en'){
    			$resouce_links[] = $resource_path.'/js/i18n/datepicker-'.lang_code().'.min.071120140938.js';
    		}

    		$resouce_links[] = $resource_path.'/libs/jquery-ui-1.11.2.datepicker/jquery-ui.min.js';

    	}

    	if($lib_name == 'jquery-ui-autocomplete'){

    		$resouce_links[] = $resource_path.'/libs/jquery-ui-1.11.4.autocomplete/jquery-ui.min.css';

    		$resouce_links[] = $resource_path.'/libs/jquery-ui-1.11.4.autocomplete/jquery-ui.min.js';

    	}

    	if($lib_name == 'flexslider'){

    		$resouce_links[] = $resource_path.'/libs/flexslider-2.5.0/flexslider.css';

    		$resouce_links[] = $resource_path.'/libs/flexslider-2.5.0/jquery.flexslider-min.js';
    	}


    	if($lib_name == 'typeahead'){
    		$resouce_links[] = $resource_path.'/libs/typeahead-0.10.5/typeahead.bundle.js';
    		$resouce_links[] = $resource_path.'/libs/typeahead-0.10.5/handlebars.js';
    	}


    	if ($lib_name == 'recommendation'){

    		$resouce_links[] = $resource_path.'/css/desktop/recommend.css';

    		$resouce_links[] = $resource_path.'/js/recommend.js';

    		$libs = get_libary_asyn('typeahead', false);
    		foreach ($libs as $link){
    			$resouce_links[] = $link;
    		}

    		$libs = get_libary_asyn('jquery-ui-datepicker', false);
    		foreach ($libs as $link){
    			$resouce_links[] = $link;
    		}
    	}

    	if($lib_name == 'google-map'){

    		$link = '//maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&language=en';

    		if($callback != ''){

    			$link .= '&callback='.$callback;
    		}


    		$resouce_links[] = $link;
    	}

    	if($lib_name == 'fotorama'){
    	    $resouce_links[] = $resource_path.'/libs/fotorama-4.6.3/fotorama.css';
    	    $resouce_links[] = $resource_path.'/libs/fotorama-4.6.3/fotorama.js';
    	}

    	if($lib_name == 'lightbox'){
    	    $resouce_links[] = $resource_path.'/libs/lightbox/css/lightbox.css';
    	    $resouce_links[] = $resource_path.'/libs/lightbox/lightbox.js';
    	}

    	if($lib_name == 'highslide'){
    	    $resouce_links[] = $resource_path.'/libs/highslide/highslide.css';
    	    $resouce_links[] = $resource_path.'/libs/highslide/highslide-with-gallery.min.js';
    	}

    	if($lib_name == 'map'){
    	    $resouce_links[] = $resource_path.'/js/map/map_label.js';
    	    $resouce_links[] = $resource_path.'/js/map/curved_polylines.js';
    	    $resouce_links[] = $resource_path.'/js/map/map.js';
    	}

    	if ($is_json){
    		return json_encode($resouce_links);
    	} else {
    		return $resouce_links;
    	}
    }


/**
 * Khuyenpv Feb, 02, 2015
 *
 * Get the CSS/JS in each page
 *
 */
function get_page_theme($page, $is_mobile = false){

	$CI =& get_instance();

	$lib_css = '';
	$lib_js = '';

	$basic_css = '';
	$basic_js = '';

	$page_css = '';
	$page_js = '';


	/**
	 * Load JQuery First
	 */
	$lib_js .= get_resources('jquery-1.11.2.min.js','libs/');

	/**
	 * Load Bootstrap Second
	 */
	$lib_css .= get_resources('bootstrap.min.css','libs/bootstrap-compact-3.3.5/css/');
	$lib_js .= get_resources('bootstrap.min.js','libs/bootstrap-compact-3.3.5/js/');

	// font awesome
	//$lib_css .= get_resources('font-awesome.min.css', '/libs/font-awesome-4.3.0/css/');

	/**
	 * Load Language File (Message using in JS)
	 */
	$basic_js .= get_resources('i18n/lang.'.lang_code().'.js');


	$basic_css .= $is_mobile ? get_resources('basic.css', 'css/mobile/') : get_resources('basic.css');
	$basic_js .= get_resources('basic.js');



	switch ($page) {
		case HOME_PAGE:

			$page_css = get_resources('home.css');
			$page_js .= get_resources('flight/flight.js');

			if($is_mobile){
				//$page_css = get_resources('home.css', 'css/mobile/');
			}

			break;

		case VN_TOUR_PAGE:
		case TOURS_BY_DESTINATION_PAGE:
		case TOURS_BY_TRAVEL_STYLE_PAGE:

			$page_css = get_resources('tour/tour_by_country.css');

			if($is_mobile){
				//$page_css = get_resources('tour/tour_by_country.css', 'css/mobile/');
			}

			break;

		case HALONG_CRUISE_PAGE:
		case LUXURY_HALONG_CRUISE_PAGE:
	    case DELUXE_HALONG_CRUISE_PAGE:
	    case CHEAP_HALONG_CRUISE_PAGE:
        case CHARTER_HALONG_CRUISE_PAGE:
        case DAY_HALONG_CRUISE_PAGE:
        case HALONG_BAY_BIG_SIZE_CRUISE_PAGE:
        case HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE:
        case HALONG_BAY_SMALL_SIZE_CRUISE_PAGE:
        case FAMILY_HALONG_CRUISE_PAGE:
        case HONEY_MOON_HALONG_CRUISE_PAGE:
		case MEKONG_CRUISE_PAGE:
	    case VIETNAM_CAMBODIA_CRUISE_PAGE:
        case VIETNAM_CRUISE_PAGE:
        case LAOS_CRUISE_PAGE:
        case THAILAND_CRUISE_PAGE:
        case BURMA_CRUISE_PAGE:
        case LUXURY_MEKONG_CRUISE_PAGE:
        case DELUXE_MEKONG_CRUISE_PAGE:
        case CHEAP_MEKONG_CRUISE_PAGE:
        case PRIVATE_MEKONG_CRUISE_PAGE:
        case DAY_MEKONG_CRUISE_PAGE:

			if($is_mobile){
				//$page_css = get_resources('tour/halong_mekong.css', 'css/mobile/');
			} else {
			    $page_css = get_resources('cruise/halong_mekong.css');
			}

			break;

		case TOUR_SEARCH_PAGE:
		case TOUR_SEARCH_EMPTY_PAGE:

			$page_css = get_resources('tour/tour_search.css');
			$page_js = get_resources('tour/tour_search.js');

			if($is_mobile){
				//$page_css = get_resources('tour/tour_search.css', 'css/mobile/');
			} else {

				$page_css .= get_resources('recommend.css');
				$page_js .= get_resources('recommend.js');

			}

			break;

		case TOUR_DETAIL_PAGE:

		    $page_css = get_resources('tour/tour_detail.css,review/review.css');
			$page_js = get_resources('tour/tour_detail.js,review/review.js');

			if($is_mobile){
			    $page_css = get_resources('tour/tour_detail.css,review/review.css', 'css/mobile/');
			}

			// user click on checkrate => load the tour_booking.js
			$action = $CI->input->get('action');
			if($action == ACTION_CHECK_RATE){
				$page_js .= get_resources('tour/tour_booking.js');
			}

			break;

		case HOTEL_BOOKING_PAGE:
		case TOUR_BOOKING_PAGE:

			$page_css .= !$is_mobile ? get_resources('booking/booking.css') : get_resources('booking/booking.css', 'css/mobile/');


			$page_js = get_resources('tour/tour_booking.js');
			$page_js .= get_resources('booking/booking.js');

			break;

        case VN_HOTEL_PAGE:
        case HOTELS_BY_DESTINATION_PAGE:
        case HOTEL_SEARCH_EMPTY_PAGE:
            $page_css = get_resources('hotel/hotel.css');
            $page_js = get_resources('hotel/hotel.js');
            break;

        case HOTEL_SEARCH_PAGE:
            $page_css = get_resources('hotel/hotel.css');
            $page_js  = get_resources('hotel/hotel.js');
            $page_js .= get_resources('hotel/hotel_search.js');
            break;

        case HOTEL_DETAIL_PAGE:
        case HOTEL_REVIEW_PAGE:
            $page_css = get_resources('hotel/hotel_detail.css');

            $page_js .= get_resources('hotel/hotel.js');

            $page_css .= get_resources('review/review.css');
            $page_js .= get_resources('review/review.js');

            if($is_mobile){
            	$page_css = get_resources('tour/tour_detail.css, hotel/hotel_detail.css, review/review.css', 'css/mobile/');
            }
            break;

        case DESTINATION_THINGS_TO_DO_PAGE:
        case DESTINATION_ATTRACTION_PAGE:
            if($is_mobile)
                $page_css = get_resources('destination/destination.css', 'css/mobile/');
            else
                $page_css = get_resources('destination/destination.css');

                $page_js = get_resources('destination/destination.js');
            break;

        case DESTINATION_ARTICLE_PAGE:
            if($is_mobile)
                $page_css = get_resources('destination/article.css', 'css/mobile/');
            else
                $page_css = get_resources('destination/article.css');
            break;

        case CRUISE_DETAIL_PAGE:

            $page_css = get_resources('tour/tour_detail.css');
            $page_js = get_resources('cruise/cruise_details.js');

            if($is_mobile){
                $page_css = get_resources('tour/tour_detail.css', 'css/mobile/');
            }

            // user click on checkrate => load the tour_booking.js
            $action = $CI->input->get('action');
            if($action == ACTION_CHECK_RATE){
                $page_js .= get_resources('tour/tour_booking.js');
            }

            break;

        case CRUISE_REVIEW_PAGE:

            $page_css = get_resources('tour/tour_detail.css, review/review.css');
            $page_js = get_resources('review/review.js');

            if($is_mobile){
            	$page_css = get_resources('tour/tour_detail.css, review/review.css', 'css/mobile/');
            }
            break;

        case ABOUT_US_PAGE:
        case REGISTRATION_PAGE:
        case CONTACT_US_PAGE:
        case POLICY_PAGE:
        case PRIVACY_PAGE:
        case OUR_TEAM_PAGE:
            if($is_mobile){
                $page_css = get_resources('about/about.css', 'css/mobile/');
            }
            else
                $page_css = get_resources('about/about.css');

            break;

        case FAQ_PAGE:
        case FAQ_CATEGORY_PAGE:
        case FAQ_DESTINATION_PAGE:
            $page_css = get_resources('faq/faq.css');
            break;

        case MY_BOOKING_PAGE:
        case SUBMIT_BOOKING_PAGE:

        	$page_css = !$is_mobile ? get_resources('booking/booking.css') : get_resources('booking/booking.css','css/mobile/');
        	$page_js = get_resources('booking/booking.js');
        	break;

        case THANK_YOU_PAGE:
        	$page_css = get_resources('cruise/halong_mekong.css');
        	//$page_css = get_resources('booking/booking.css');
        	break;

        case CUSTOMIZE_TOUR_PAGE:

            if($is_mobile)
                $page_css = get_resources('contact/contact.css', 'css/mobile/');
            else
                $page_css = get_resources('contact/contact.css');

            break;

        case BOOK_TOGETHER_PAGE:

        	$lib_datepicker = get_libraries('jquery-ui-datepicker');// $lib_css, $lib_js

        	$lib_css .= $lib_datepicker['lib_css'];

        	$lib_js .= $lib_datepicker['lib_js'];

        	$page_css .= get_resources('booking/booking.css');

        	$page_js .= get_resources('booking/booking.js');

        	$page_js .= get_resources('tour/tour_booking.js');

        	break;

        case DEAL_OFFER_PAGE:
            $page_css = get_resources('deal_offer.css');
            $page_js  = get_resources('deal_offer/deal_offer.js, flight/flight.js');
            break;

    	case VN_VISA_PAGE:
    	case VN_VISA_FOR_CITIZENS_PAGE:
        case VN_VISA_REQUIREMENTS_PAGE:
        case VN_VISA_APPLY_PAGE:
        case VN_VISA_DETAILS_PAGE:
        case VN_VISA_FEES_PAGE:
        case VN_VISA_ON_ARRIVAL_PAGE:
        case VN_VISA_HOW_TO_APPLY_PAGE:
        case VN_VISA_APPLICATION_PAGE:
        case VN_VISA_EMBASSIES_WORLDWIDE_PAGE:
        case VN_VISA_AVAILABILITY_FEE_PAGE:
        case VN_VISA_EXEMPTION_PAGE:
        case VN_VISA_TYPES_PAGE:
            
            if($is_mobile){
                $page_css = get_resources('visa/visa.css', 'css/mobile/');
            } else {
                $page_css .= get_resources('visa/visa.css, booking/booking.css');
            }

    	    $page_js .= get_resources('visa/visa.js');

    	    break;

    	case VN_VISA_PAYMENT_PAGE:
    	    
    	    if($is_mobile){
    	        $page_css = get_resources('visa/visa.css', 'css/mobile/');
    	    } else {
    	        $page_css .= get_resources('visa/visa.css, booking/booking.css');
    	    }

    	    $page_js .= get_resources('visa/visa.js, visa/payment.js');
    	    break;

		case VN_FLIGHT_PAGE:
		case FLIGHT_SEARCH_PAGE:
		case FLIGHT_SEARCH_EXCEPTION_PAGE:
		case FLIGHT_DESTINATION_PAGE:
		case FLIGHT_PASSENGER_PAGE:
			$page_css .= get_resources('booking/booking.css, flight/flight.css');

			$page_js .= get_resources('booking/booking.js, flight/flight.js');

			if($is_mobile){
				$page_css = get_resources('flight/flight.css', 'css/mobile/');
			}
			break;
			
		case ADVERTISING_PAGE:
		    $page_css .= get_resources('ads.min.css');
		    break;
		    
	    case PAYMENT_SUCCESS_PAGE:
	    case PAYMENT_PENDING_PAGE:
	    case PAYMENT_UNSUCCESS_PAGE:
	        if($is_mobile){
    	        $page_css = get_resources('visa/visa.css', 'css/mobile/');
    	    } else {
    	        $page_css .= get_resources('visa/visa.css, booking/booking.css');
    	    }
	        break;
	}

	return $lib_css.$basic_css.$page_css.$lib_js.$basic_js.$page_js;
}

?>