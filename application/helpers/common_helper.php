<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Return mark required label for required field
 * @access	public
*/
function mark_required() {
	return '<label style="color:red">*</label>';
}
function note_required() {
	return mark_required() . ': required field';
}

function get_paging_config($total_rows, $uri, $uri_segment) {
	$CI =& get_instance();

	$config['base_url'] = site_url($uri);
	$config['total_rows'] = $total_rows;
	$config['per_page'] = $CI->config->item('per_page');
	$config['uri_segment'] = $uri_segment;
	$config['num_links'] = $CI->config->item('num_links');
	$config['first_link'] = $CI->lang->line('common_paging_first');
	$config['next_link'] = $CI->lang->line('common_paging_next');
	$config['prev_link'] = $CI->lang->line('common_paging_previous');
	$config['last_link'] = $CI->lang->line('common_paging_last');

	return $config;
}
function get_paging_text($total_rows, $offset, $per_page='') {
	$CI =& get_instance();

	if(empty($per_page)) {
		$per_page = $CI->config->item('per_page');
	}

	$paging_text = $CI->lang->line('common_paging_display');
	$next_offset = $offset + $per_page;
	if ($next_offset > $total_rows) {
		$next_offset = $total_rows;
	}
	$paging_text .= '&nbsp;' . '<b>'.($offset + 1) . '</b>'
					. '&nbsp;-&nbsp;' . '<b>' . $next_offset . '</b>'
					. '&nbsp;' . $CI->lang->line('common_paging_of') . '&nbsp;'
					. '<b>' . $total_rows . '</b>';
	return $paging_text;
}

function get_des_upload_config() {
	$CI =& get_instance();
	$config['upload_path'] = $CI->config->item('des_upload_path');
	$config['allowed_types'] = $CI->config->item('allowed_types');
	$config['max_size']	= $CI->config->item('max_size');
	$config['max_width']  = $CI->config->item('max_width');
	$config['max_height']  = $CI->config->item('max_height');
	$config['file_name'] = uniqid();

	return $config;
}

function get_tour_upload_config() {
	$CI =& get_instance();
	$config['upload_path'] = $CI->config->item('tour_upload_path');
	$config['allowed_types'] = $CI->config->item('allowed_types');
	$config['max_size']	= $CI->config->item('max_size');
	$config['max_width']  = $CI->config->item('max_width');
	$config['max_height']  = $CI->config->item('max_height');
	$config['file_name'] = uniqid();

	return $config;
}

function translate_text($text)
{
	$CI =& get_instance();
	// Do we need to translate the field name?
	// We look for the prefix lang: to determine this
	if (substr($text, 0, 5) == 'lang:')
	{
		// Grab the variable
		$line = substr($text, 5);

		// Were we able to translate the field name?  If not we use $line
		if (FALSE === ($text = $CI->lang->line($line)))
		{
			return $line;
		}
	}

	return $text;
}
function get_popup_config($page = '') {
	$CI =& get_instance();
	$c_popup = $CI->config->item('popup');
    if ($page == '') {
		$atts = $c_popup['default'];
    } else {
    	$atts = $c_popup[$page];
    }
    $att_str = '';
    foreach ($atts as $key => $value) {
    	$att_str .= $key . '=' . $value . ',';
    }
    $att_str = substr($att_str, 0, strlen($att_str) - 1);
    return $att_str;
}

function site_metas($action, $data = '') {
	$key = str_replace('/','', $action);
	$metas['robots'] = "index,follow";
	switch ($action) {
		case TOUR_DESTINATION:
			if(!empty($data['tour_title'])) {
				$metas['title'] = $data['tour_title'];
			} else {
				$metas['title'] = str_replace('%s', $data['name'], stripcslashes(lang('tour_destinations_title')));
			}
			if(!empty($data['tour_keywords'])) {
				$metas['keywords'] = $data['tour_keywords'];
			} else {
				$metas['keywords'] = str_replace('%s', $data['name'], stripcslashes(lang('tour_destinations_keywords')));
			}
			if(!empty($data['tour_description'])) {
				$metas['description'] = $data['tour_description'];
			} else {
				$metas['description'] = str_replace('%s', $data['name'], stripcslashes(lang('tour_destinations_description')));
			}

			break;
		case TOUR_DESTINATION_STYLES:
			$data['style_name'] = get_style_short_name($data['style_name']);
			$data['style_name'] = str_replace('-', ' ', $data['style_name']);

			$title = str_replace('%d', $data['name'], stripcslashes(lang('tour_destinations_style_title')));
			$title = str_replace('%s', strtolower($data['style_name']), $title);
			$title = str_replace('%c', $data['name'].' '.$data['style_name'], $title);
			$metas['title'] = $title;
			$metas['keywords'] = str_replace('%s', $data['name'].' '.$data['style_name'], stripcslashes(lang('tour_destinations_style_keywords')));
			$des = str_replace('%s', $data['name'].' '.$data['style_name'], stripcslashes(lang('tour_destinations_style_description')));
			$des = str_replace('%d', strtolower($data['style_name']), $des);
			$des = str_replace('%c', $data['name'], $des);
			$metas['description'] = $des;
			break;
		case TOUR_TRAVEL_STYLE:
			$metas['title'] = lang(url_title($data['name'], 'underscore', true).'_title');
			$metas['keywords'] = lang(url_title($data['name'], 'underscore', true).'_keywords');
			$metas['description'] = lang(url_title($data['name'], 'underscore', true).'_description');
			break;
		case TOUR_DETAIL:
			$CI =& get_instance();
			$CI->load->helper('text');
			$metas['title'] = $data['partner_name'] . ': ' . $data['name'];
			$metas['keywords'] = strtolower($data['partner_name'] . ',' . str_replace(' ', ',', stripcslashes($data['name'])));
			$metas['description'] = 'Tour Name: ' . $data['name'] . ', Tour Operator: ' . $data['partner_name'] . ', Duration: ' . get_duration($data['duration']);
			break;
		case TOUR_BOOKING:
		case HOTEL_BOOKING:
			//$metas['title'] = 'Make a booking: ' . $data['partner_name'] . ' - ' . $data['name'];
			$metas['title'] = 'Book Extra Services';
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";
			break;
		case TOUR_SEARCH:
			$metas['title'] = lang('tour_search');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";
			break;
		case LINK_EXCHANGE:
			if ($data != '') {
				$metas['title'] = lang($key.'_title') . ': ' . $data;
				$metas['description'] = $data.' ' .lang('links_description') . ' in ' . $data;
			} else {
				$metas['title'] = lang($key.'_title');
				$metas['description'] = lang('links_description');
			}
			$metas['keywords'] = lang('home_keywords');

			break;
		case HOTEL_DESTINATION:
			if(!empty($data['hotel_title'])) {
				$metas['title'] = $data['hotel_title'];
			} else {
				$metas['title'] = str_replace('%s', $data['name'], stripcslashes(lang('hotel_destinations_title')));
			}
			if(!empty($data['hotel_keywords'])) {
				$metas['keywords'] = $data['hotel_keywords'];
			} else {
				$metas['keywords'] = str_replace('%s', strtolower($data['name']), stripcslashes(lang('hotel_destinations_keywords')));
			}
			if(!empty($data['hotel_description'])) {
				$metas['description'] = $data['hotel_description'];
			} else {
				$metas['description'] = str_replace('%s', $data['name'], stripcslashes(lang('hotel_destinations_description')));
			}

			break;
		case HOTEL_DETAIL:

			$metas['title'] = str_replace('%s', get_alt_image_text_hotel($data), stripcslashes(lang('hotel_detail_title')));

			$metas['keywords'] = get_alt_image_text_hotel($data);

			$metas['description'] = get_alt_image_text_hotel($data) .': '. $data['location'];
			break;
		case HOTEL_REVIEWS:
			$tile_text = "";

			$description = $data['name'];

			$tile_text = $data['name'].' '.lang('review');

			$metas['title'] = $tile_text;

			$metas['keywords'] = $tile_text;

			$description .= " ".lang('review').": ";

			$description .= str_replace("%", $data['name'], lang('customer_review_description'));

			$metas['description'] = $description;

			break;

		case HOTEL_SEARCH:
			$metas['title'] = lang('hotel_search');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";
			break;
		case CRUISE_HALONG_BAY:
			$metas['title'] = lang('cruise_halong_bay_title');
			$metas['keywords'] = lang('cruise_halong_bay_keywords');
			$metas['description'] = lang('cruise_halong_bay_description');
			break;
		case CRUISE_MEKONG_RIVER:
			$metas['title'] = lang('cruise_mekong_title');
			$metas['keywords'] = lang('cruise_mekong_keywords');
			$metas['description'] = lang('cruise_mekong_description');
			break;
		case CRUISE_REVIEWS:

			$tile_text = "";

			$description = $data['name'];

			if ($data['cruise_destination'] == 1){ // mekong
				/*
				$pos = strpos($data['name'], 'Mekong');

				if ($pos === false){

					$tile_text = $data['name'].' Mekong Review';

				} else {

					$tile_text = $data['name'].' Review';

				}*/

				$tile_text = $data['name'].' '.lang('review');

			} else {

				$tile_text = $data['name'].' Halong Bay Review';

				$description .= " Halong Bay";

			}

			$metas['title'] = $tile_text;

			$metas['keywords'] = $tile_text;

			$description .= " Review: ";

			$description .= str_replace("%", $data['name'], lang('customer_review_description'));

			$metas['description'] = $description;

			break;
		case CRUISE_DETAIL:

			if (isset($data['meta_title'])&& $data['meta_title'] != ''){

				$metas['title'] = $data['meta_title'];

			} else {

				if ($data['cruise_destination'] == 1){ // mekong

					$metas['title'] = $data['name'];

				} else {

					$metas['title'] = $data['name'].' Halong Bay';

				}


				$metas['title'] = str_replace('%s', $metas['title'], stripcslashes(lang('cruise_detail_title')));

			}

			if (isset($data['key_words']) && $data['key_words'] != ''){

				$metas['keywords'] = $data['key_words'];

			} else {

				if ($data['cruise_destination'] == 1){ // mekong

					$metas['keywords'] = $data['name'];

				} else {

					$metas['keywords'] = $data['name'].' Halong Bay, Halong '.$data['name'];


				}

			}

			if (isset($data['meta_description']) && $data['meta_description'] != ''){

				$metas['description'] = $data['meta_description'];

			} else {

				$metas['description'] = $data['name'].': See reviews & Get great deals for '.$data['name'].' at BestPrice Vietnam. Book online with Best Price Guarantee!';

				if ($data['cruise_destination'] == 1){ // mekong


					$pos = strpos($data['name'], 'Mekong');

					if ($pos === false){

						$metas['description'] = $data['name'].': See reviews & Get great deals for Mekong '.$data['name'].' at BestPrice Vietnam. Book online with Best Price Guarantee!';

					}

				} else {

					$pos = strpos($data['name'], 'Halong');

					if ($pos === false){

						$metas['description'] = $data['name'].' Halong Bay: See reviews & Get great deals for Halong '.$data['name'].' at BestPrice Vietnam. Book online with Best Price Guarantee!';

					}

				}

			}

			$des = strip_tags($metas['description']);
			$des = str_replace("&#8230;", "", $des);
			$metas['description'] = $des;

			break;

		case FAQ_DETAIL:
			$metas['title'] = 'FAQ: '.$data['question'];
			$metas['keywords'] = "";
			$metas['description'] = $data['question'];//htmlentities(character_limiter($data['answer'], CRUISE_DESCRIPTION_CHR_LIMIT));
			break;

		case FAQ_CATEGORY:
			$metas['title'] = 'FAQ: '.$data['name'];
			$metas['keywords'] = $data['name'];
			$metas['description'] = $data['name'];
			$metas['robots'] = "noindex";
			break;
		case PARTNERS_META:
			$metas['title'] = lang($key.'_title');
			$metas['keywords'] = lang($key . '_keywords');
			$metas['description'] = lang($key. '_description');
			$metas['robots'] = "noindex,nofollow";
			break;
		case MY_BOOKING:
		case SUBMIT_BOOKING:
		case CUSTOM_404:
			$metas['title'] = lang($key.'_title');
			$metas['keywords'] = lang($key . '_keywords');
			$metas['description'] = lang($key. '_description');
			$metas['robots'] = "noindex,nofollow";
			break;
		case BOOK_TOGHETHER:
			$metas['title'] = lang('book_services_together');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";
			break;

		case DESTINATION_DETAIL:
			$metas['title'] = $data['name'];

			if ($data['title'] != ''){
				$metas['title'] = $metas['title']. ' - '. $data['title'];
			}

			$metas['keywords'] = $data['name']. 'Travel Guide';
			$metas['description'] = 'Travel Guide Of ' . $data['name'];
			break;

		case FLIGHT_SEARCH:
			$metas['title'] = lang('search_flight');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";
			break;

		case FLIGHT_DESTINATION:

			if(!empty($data['flight_title'])) {
				$metas['title'] = $data['flight_title'];
			} else {
				$metas['title'] = str_replace('%s', $data['name'], stripcslashes(lang('flight_destinations_title')));
			}
			if(!empty($data['flight_keywords'])) {
				$metas['keywords'] = $data['flight_keywords'];
			} else {
				$metas['keywords'] = str_replace('%s', strtolower($data['name']), stripcslashes(lang('flight_destinations_keywords')));
			}
			if(!empty($data['flight_description'])) {
				$metas['description'] = $data['flight_description'];
			} else {
				$metas['description'] = str_replace('%s', $data['name'], stripcslashes(lang('flight_destinations_description')));
			}


			break;

		case FLIGHT_DETAIL:

			$metas['title'] = lang('flight_details');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";

			break;

		case FLIGHT_PAYMENT:

			$metas['title'] = lang('flight_payment');
			$metas['keywords'] = '';
			$metas['description'] = '';
			$metas['robots'] = "noindex,nofollow";

			break;

		default:
			$metas['title'] = lang($key.'_title');
			$metas['keywords'] = lang($key . '_keywords');
			$metas['description'] = lang($key. '_description');
			$metas['robots'] = "index,follow";
	}

	$metas['title'] .= ' - ' . BRANCH_NAME;

	if(in_array($action, array('policy', 'privacy', 'customize', 'our_team'))) $metas['robots'] = "noindex,nofollow";;
	return $metas;
}


function createNavigationLink($isLast, $label, $url_basename = '', $title = '') {

  if ($isLast) {
	 //return '<strong>' . $label . '</strong>';
	 return $label;
  }
  else {
	 return '<a title="'.$title.'" href="'.$url_basename.'">'.$label.'</a>';
  }
}

	function createHomeNavLink($isLast) {
		if ($isLast) {
			return createNavigationLink(true, lang('home'));
		} else {
			return createNavigationLink(false, lang('home'), site_url(), SITE_NAME);
		}
	}

	function createMyBookingNavLink($label) {
		$home = createHomeNavLink(false);

		return $home . ARROW_LINK . createNavigationLink(true, $label);
	}

	function createCruiseNavLink($cruise='', $isLast = true){

		$link = '';

		if ($cruise['cruise_destination'] == 0){
			$link = createHalongCruisesNavLink(false);
		} else {
			$link = createMekongCruisesNavLink(false);
		}

		$cruise_link = createNavigationLink($isLast,$cruise['name'], url_builder(CRUISE_DETAIL, $cruise['url_title'], true), $cruise['name']);

		return $link . ARROW_LINK . $cruise_link;
	}

	function createCruiseTourNavLink($cruise='', $program=''){
		$link = createCruiseNavLink($cruise, false);

		return $link . ARROW_LINK . $program['name'];
	}

	function createHotelHomeNavLink($isLast) {
		$home = createHomeNavLink(false);
		if ($isLast) {
			$hotel_home = createNavigationLink(true, lang('hotel_home'));
		} else {
			$hotel_home = createNavigationLink(false, lang('hotel_home'), '/'.HOTEL_HOME, lang('hotel_home'));
		}
		return $home . ARROW_LINK . $hotel_home;
	}

	function createHotelSearchNavLink($isLast) {

		$hotel_home = createHotelHomeNavLink(false);

		if ($isLast) {
			$hotel_search = createNavigationLink(true, lang('search_results'));
		} else {
			$hotel_search = createNavigationLink(false, lang('search_results')
								, HOTEL_HOME . HOTEL_SEARCH, lang('search_results'));
		}
		return $hotel_home . ARROW_LINK . $hotel_search;
	}
	function createHotelDesNavLink($isLast, $des) {
		$hotel_home = createHotelHomeNavLink(false);
		if ($isLast) {

			$hotel_des = createNavigationLink(true, $des['name'] . ' ' . ucfirst(lang('hotels')));
		} else {
			$hotel_des = createNavigationLink(false, $des['name']
								, HOTEL_HOME . HOTEL_DESTINATION . $des['url_title']
								, $des['name'] . ' ' . ucfirst(lang('hotels')));
		}
		return $hotel_home . ARROW_LINK . $hotel_des;
	}

	function createHotelCompareNavLink($isLast) {

		$hotel_home = createHotelHomeNavLink(false);

		if ($isLast) {
			$hotel_compare = createNavigationLink(true, lang('hotels_compare'));
		} else {
			$hotel_compare = createNavigationLink(false, lang('hotels_compare')
								, HOTEL_HOME . HOTEL_COMPARE, lang('hotels_compare'));
		}
		return $hotel_home . ARROW_LINK . $hotel_compare;
	}

	function createHotelDetailNavLink($hotel, $destination, $is_last = true) {

		$hotel_home = createHotelHomeNavLink(false);

		$destination_name = lang('hotel_last_url_title', $destination['name']);


		$destination_url = url_builder(MODULE_HOTELS, url_title($destination['name']).'-'.MODULE_HOTELS);



		$destination_url = createNavigationLink(false, $destination_name, $destination_url, $destination_name);

		//echo $destination_url; exit();

		$hotel_detail = createNavigationLink($is_last, $hotel['name'], url_builder(HOTEL_DETAIL, url_title($hotel['name']), true));

		return $hotel_home . ARROW_LINK . $destination_url. ARROW_LINK. $hotel_detail;
	}

function createVisaHomeNavLink($isLast) {
	$home = createHomeNavLink(false);
	if ($isLast) {
		$visa_home = createNavigationLink(true, lang('visa_navigation'));
	} else {
		$visa_home = createNavigationLink(false, lang('visa_navigation'), '/'.VIETNAM_VISA, lang('visa_navigation'));
	}
	return $home . ARROW_LINK . $visa_home;
}

function createVisaGuideNavLink($title, $plain_text = false, $requirements = false) {
	$home = createHomeNavLink(false);
	$visa_home = createNavigationLink(false, lang('visa_navigation'), '/'.VIETNAM_VISA, lang('visa_navigation'));

	if($plain_text) {
		$txt = $title;
	} else {
		$txt = lang($title);
	}

	$req_nav = '';
	if($requirements) {
		$link =  createNavigationLink(false, lang('visa_requirements'), '/'.VIETNAM_VISA.'visa-requirements.html', lang('visa_requirements'));
		$req_nav = ARROW_LINK . $link;
	}

	$visa_guide = createNavigationLink(true, $txt);

	return $home . ARROW_LINK . $visa_home . $req_nav . ARROW_LINK . $visa_guide;
}

function createVisaDetailNavLink($title) {
	$home = createHomeNavLink(false);
	$visa_home = createNavigationLink(false, lang('visa_navigation'), '/'.VIETNAM_VISA, lang('visa_navigation'));

	$link =  createNavigationLink(false, lang('apply_visa'), '/'.APPLY_VIETNAM_VISA, lang('apply_visa'));
	$req_nav = ARROW_LINK . $link;

	$visa_guide = createNavigationLink(true, lang($title));

	return $home . ARROW_LINK . $visa_home . $req_nav . ARROW_LINK . $visa_guide;
}

function createTourHomeNavLink($isLast) {
	$home = createHomeNavLink(false);
	if ($isLast) {
		$tour_home = createNavigationLink(true, lang('tour_home'));
	} else {
		$tour_home = createNavigationLink(false, lang('tour_home'), '/'.TOUR_HOME, lang('tour_home'));
	}
	return $home . ARROW_LINK . $tour_home;
}
function createTourSearchNavLink($isLast) {
	$tour_home = createTourHomeNavLink(false);
	if ($isLast) {
		$tour_search = createNavigationLink(true, lang('search_results'));
	} else {
		$tour_search = createNavigationLink(false, lang('search_results')
							, TOUR_HOME . TOUR_SEARCH, lang('search_results'));
	}
	return $tour_home . ARROW_LINK . $tour_search;
}
function createTourDesNavLink($isLast, $des, $parent_des, $style_name = '') {

	$home = createHomeNavLink(false);
	if ($isLast) {
		if(!empty($style_name)) {
			$style_name = get_style_short_name($style_name, false);
			$tour_des = createNavigationLink(true, $des['name'].' '.$style_name);

			$des_url = '';
			if($des['id'] == 235) {
				$des_url = createNavigationLink(false, $des['name'] . ' ' . MODULE_TOURS
						, url_builder('',TOUR_HOME)
						, $des['name'] . ' ' . ucfirst(lang('tours')));
			} else {
				$des_url = createNavigationLink(false, $des['name'] . ' ' . MODULE_TOURS
						, url_builder(MODULE_TOURS, $des['url_title'] . '-' .MODULE_TOURS)
						, $des['name'] . ' ' . ucfirst(lang('tours')));
			}
			if(!empty($des_url)) {
				$parent_url = get_parent_des_url($des);
				if(!empty($parent_url)) {
					$des_url = $parent_url .ARROW_LINK. $des_url. ARROW_LINK;
				} else {
					$des_url = $des_url.ARROW_LINK;
				}

			}

			return $home . ARROW_LINK . $des_url . $tour_des;
		} else {
			$tour_des = createNavigationLink(true, $des['name'].' '.ucfirst(lang('tours')));
		}
	} else {
		$tour_des = createNavigationLink(false, $des['name']
							, TOUR_HOME . TOUR_DESTINATION . $des['url_title']
							, $des['name'] . ' ' . ucfirst(lang('tours')));
	}

	if(!empty($parent_des)) {
		if($parent_des['id'] == 235) {
			$parent_url = createNavigationLink(false, $parent_des['name'] . ' ' . MODULE_TOURS
					, url_builder('',TOUR_HOME)
					, $parent_des['name'] . ' ' . ucfirst(lang('tours')));
		} else {
			$parent_url = createNavigationLink(false, $parent_des['name'] . ' ' . MODULE_TOURS
					, url_builder(MODULE_TOURS, $parent_des['url_title'] . '-' .MODULE_TOURS)
					, $parent_des['name'] . ' ' . ucfirst(lang('tours')));
		}

		$desStyle = '';
		if(!empty($style_name)) {
			$desStyle = createNavigationLink(false, $des['name'] . ' ' . MODULE_TOURS
				, url_builder(MODULE_TOURS, $des['url_title'] . '-' .MODULE_TOURS)
				, $des['name'] . ' ' . ucfirst(lang('tours')));
			$desStyle = ARROW_LINK. $desStyle;
		}

		return $home. ARROW_LINK. $parent_url. $desStyle . ARROW_LINK . $tour_des;
	}

	return $home . ARROW_LINK . $tour_des;
}
function createTourStyleNavLink($isLast, $cat) {
	$tour_home = createTourHomeNavLink(false);
	if ($isLast) {
		$tour_style = createNavigationLink(true, $cat['name']);
	} else {
		$tour_style = createNavigationLink(false, $cat['name']
							, TOUR_HOME . TOUR_TRAVEL_STYLE . $cat['url_title'], $cat['name']);
	}
	return $tour_home . ARROW_LINK . $tour_style;
}

function createDealsNavLink($isLast) {
	$key = str_replace('/','', DEALS);
	$home = createHomeNavLink(false);
	if ($isLast) {
		$deals = createNavigationLink(true, lang($key));
	} else {
		$deals = createNavigationLink(false, lang($key), DEALS, lang($key . '_title'));
	}
	return $home . ARROW_LINK . $deals;
}

function createDestinationNavLink($des) {
	$key = str_replace('/','', DESTINATION_DETAIL);
	$home = createHomeNavLink(false);


	return $home . ARROW_LINK . $des['name'].' '.lang('travel_guide');
}

function create_404_Nav_Link() {
	$key = str_replace('/','', CUSTOM_404);
	$home = createHomeNavLink(false);
	$custom_404 = createNavigationLink(true, lang($key . '_title'));
	return $home . ARROW_LINK . $custom_404;
}

function createHalongCruisesNavLink($isLast) {
	$key = str_replace('/','', HALONG_BAY_CRUISES);
	$home = createHomeNavLink(false);
	if ($isLast) {
		$halong_cruises = createNavigationLink(true, lang($key));
	} else {
		$halong_cruises = createNavigationLink(false, lang($key), '/'.HALONG_BAY_CRUISES, lang($key . '_title'));
	}
	return $home . ARROW_LINK . $halong_cruises;
}
function createHalongCruisesCatNavLink($isLast, $action) {
	$key = str_replace('/','', $action);
	$halong_cruises = createHalongCruisesNavLink(false);
	if ($isLast) {
		$subcat = createNavigationLink(true, lang($key));
	} else {
		$subcat = createNavigationLink(false, lang($key), $data['action'], lang($key.'_title'));
	}
	return $halong_cruises . ARROW_LINK . $subcat;
}
function createMekongCruisesNavLink($isLast) {
	$key = str_replace('/','', MEKONG_RIVER_CRUISES);
	$home = createHomeNavLink(false);
	if ($isLast) {
		$halong_cruises = createNavigationLink(true, lang($key));
	} else {
		$halong_cruises = createNavigationLink(false, lang($key), '/'.MEKONG_RIVER_CRUISES, lang($key . '_title'));
	}
	return $home . ARROW_LINK . $halong_cruises;
}

function createCruiseSearchNavLink($isLast) {
	$CI =& get_instance();
	$link = '';
	if ($CI->session->userdata('MENU') == MNU_MEKONG_CRUISES){
		$link = createMekongCruisesNavLink(false);
	} else {
		$link = createHalongCruisesNavLink(false);
	}

	if ($isLast) {
		$cruise_search = createNavigationLink(true, lang('search_results'));
	} else {
		$cruise_search = createNavigationLink(false, lang('search_results')
							, CRUISE_SEARCH, lang('search_results'));
	}
	return $link . ARROW_LINK . $cruise_search;
}

function createMekongCruisesCatNavLink($isLast, $action) {
	$key = str_replace('/','', $action);
	$mekong_cruises = createMekongCruisesNavLink(false);
	if ($isLast) {
		$subcat = createNavigationLink(true, lang($key));
	} else {
		$subcat = createNavigationLink(false, lang($key), $data['action'], lang($key.'_title'));
	}
	return $mekong_cruises . ARROW_LINK . $subcat;
}

function createTourDetailNavLink($isLast, $tour, $type = '') {

	if(isset($tour['cruise_destination']) && $tour['cruise_destination'] == 1){
		$tour['category_id'] = 3; // Khuyenpv 16.03.2015 For fixing in changing the category_id in DB: 1 land tour & 2 cruise tour
	}

	$CI =& get_instance();
	switch ($tour['category_id']) {
	case 2:
		$CI->session->set_userdata('MENU', MNU_HALONG_CRUISES);
		$tour_home = createHalongCruisesNavLink(false);
		break;
	case 3:
		$CI->session->set_userdata('MENU', MNU_MEKONG_CRUISES);
		$tour_home = createMekongCruisesNavLink(false);
		break;
	default:
		$CI->session->set_userdata('MENU', MNU_VN_TOURS);
		$tour_home = createTourHomeNavLink(false);
		break;
	}

	$home = createHomeNavLink(false);

	$service_name = $tour['name'];
	if (strlen($service_name) > TOUR_NAME_LIST_CHR_LIMIT) {
		$service_name = content_shorten($service_name, TOUR_NAME_LIST_CHR_LIMIT, false);
		//$service_name = substr($service_name, 0, TOUR_NAME_LIST_CHR_LIMIT) . '...';
	}

	if ($isLast) {
		$tour_detail = createNavigationLink(true, $service_name);
	} else {
		// for mekong cruise only: short name for very long name of mekong cruise tour
		if($type == TOUR_BOOKING && $tour['category_id'] == 3) {
			//$service_name = character_limiter($service_name, 20);
			$service_name = content_shorten($service_name, 20, false);
		}
		$tour_detail = createNavigationLink(false, $service_name
							, url_builder(TOUR_DETAIL, $tour['url_title'], true), $tour['name']);
	}

	if(count($tour['cruise_name']) != ''){

		$cruise_link = createNavigationLink(false, $tour['cruise_name']
						, url_builder(CRUISE_DETAIL, $tour['cruise_url_title'], true), $tour['cruise_name']);

		$full_link = $tour_home . ARROW_LINK .$cruise_link. ARROW_LINK. $tour_detail;
		if($type == TOUR_BOOKING && $tour['category_id'] == 3 && strlen($full_link) > 500) {
			$service_name = content_shorten($service_name, 15, false);
			$tour_detail = createNavigationLink(false, $service_name
					, url_builder(TOUR_DETAIL, $tour['url_title'], true), $tour['name']);
			$full_link = $tour_home . ARROW_LINK .$cruise_link. ARROW_LINK. $tour_detail;
		}


		return $full_link;

	} else if(isset($tour['des']) && !empty($tour['des'])){ 	// land tour

		if($tour['des']['id'] == 235) {
			$tour_des = createNavigationLink(false, $tour['des']['name']. ' '.ucfirst(lang('tours'))
					, url_builder('',TOUR_HOME)
					, $tour['des']['name'] . ' ' . ucfirst(lang('tours')));
		} else {
			$tour_des = createNavigationLink(false, $tour['des']['name']. ' '.ucfirst(lang('tours'))
					, url_builder(MODULE_TOURS, $tour['des']['url_title'] . '-' .MODULE_TOURS)
					, $tour['des']['name'] . ' ' . ucfirst(lang('tours')));
		}

		$parent_url = get_parent_des_url($tour['des']);

		if(!empty($parent_url)) {
			return $home . ARROW_LINK .$parent_url.ARROW_LINK .$tour_des. ARROW_LINK. $tour_detail;
		}

		return $home . ARROW_LINK .$tour_des. ARROW_LINK. $tour_detail;
	}

	return $tour_home . ARROW_LINK . $tour_detail;
}

function get_parent_des_url($des) {
	$tour_des = '';
	$CI =& get_instance();
	if(isset($des['parent_id'])) {
		$parent_des = $CI->TourModel->getDestination($des['parent_id']);
		if(!empty($parent_des)) {
			if($parent_des['id'] == 235) {
				$tour_des = createNavigationLink(false, $parent_des['name']. ' '.ucfirst(lang('tours'))
						, url_builder('',TOUR_HOME)
						, $parent_des['name'] . ' ' . ucfirst(lang('tours')));
			} else {
				$tour_des = createNavigationLink(false, $parent_des['name']. ' '.ucfirst(lang('tours'))
						, url_builder(MODULE_TOURS, $parent_des['url_title'] . '-' .MODULE_TOURS)
						, $parent_des['name'] . ' ' . ucfirst(lang('tours')));
			}
		}
	}
	return  $tour_des;
}
function createTourBookingNavLink($isLast, $tour) {
	$tour_detail = createTourDetailNavLink(false, $tour, TOUR_BOOKING);
	if ($isLast) {
		$tour_booking = createNavigationLink(true, lang('extra_services'));
	} else {
		$tour_booking = createNavigationLink(false, lang('extra_services')
							, url_builder(TOUR_DETAIL, $tour['url_title'], true), "Booking");
	}
	return $tour_detail . ARROW_LINK . $tour_booking;
}

function create_hotel_booking_nav_link($isLast, $hotel, $destination){
	$hotel_detail = createHotelDetailNavLink($hotel, $destination, false);
	if ($isLast) {
		$hotel_booking = createNavigationLink(true, lang('extra_services'));
	} else {
		$hotel_booking = createNavigationLink(false, lang('extra_services')
							, url_builder(HOTEL_DETAIL, $hotel['url_title'], true), "Booking");
	}
	return $hotel_detail . ARROW_LINK . $hotel_booking;
}

function createToursComparison($isLast, $tours) {
	$tour_home = createTourHomeNavLink(false);
	if ($isLast) {
		$tours_comparison = createNavigationLink(true, "Comparison");
	}
	return $tour_home . ARROW_LINK . $tours_comparison;
}
function createPartnerLink($isLast, $text = '') {
	$home = createHomeNavLink(false);
	if ($isLast) {
		$partner_link = createNavigationLink(true, $text);
	}
	return $home . ARROW_LINK . $partner_link;
}

function createAboutLink($site='about') {
	$home = createHomeNavLink(false);
	switch ($site) {
		case 'about':
			$about_link = createNavigationLink(true, lang('about_title'));
			break;
		case 'registration':
			$about_link = createNavigationLink(true, lang('registration_title'));
			break;
		case 'contact':
			$about_link = createNavigationLink(true, lang('contact_title'));
			break;
		case 'customize':
			$about_link = createNavigationLink(true, lang('customize_title'));
			break;
		case 'our_team':
			$about_link = createNavigationLink(true, lang('our_team_title'));
			break;
		case 'policy':
			$about_link = createNavigationLink(true, lang('tpc_terms_conditions'));
			break;
		case 'privacy':
			$about_link = createNavigationLink(true, lang('privacy_title'));
			break;
	}

	return $home . ARROW_LINK . $about_link;
}
function createPolicyLink($site='policy') {
	$home = createHomeNavLink(false);
	switch ($site) {
		case 'policy':
			$policy_link = createNavigationLink(true, lang('tpc_terms_conditions'));
			break;
		case 'privacy':
			$policy_link = createNavigationLink(true, lang('privacy_title'));
			break;
	}

	return $home . ARROW_LINK . $policy_link;
}
function createAdvertisingLink( $page_title ) {
	$home = createHomeNavLink ( false );
	$ads_link = createNavigationLink ( true, $page_title );

	return $home . ARROW_LINK . $ads_link;
}

function createFaqLink() {
	$home = createHomeNavLink(false);
	$faq_link = createNavigationLink(true, lang('label_faq'));
	return $home . ARROW_LINK . $faq_link;
}

function createFaqCategoryLink($category_name) {

	$home = createHomeNavLink(false);

	$faq_link = createNavigationLink(false, lang('label_faq'), site_url(FAQ), lang('title_faq'));

	return $home . ARROW_LINK . $faq_link . ARROW_LINK. $category_name;
}

function createFaqQuestionLink($category_name, $question) {

	$home = createHomeNavLink(false);

	$faq_link = createNavigationLink(false, lang('label_faq'), site_url(FAQ), lang('title_faq'));

	$faq_category_link = createNavigationLink(false, $category_name, url_builder(FAQ_CATEGORY, url_title($category_name), true), $category_name);

	return $home . ARROW_LINK . $faq_link . ARROW_LINK. $faq_category_link . ARROW_LINK. $question;
}


function format_specialtext($data, $ignore_tags = '') {
	if ($data == '') {
		return $data;
	}
	$allow_tags = array("\n", '&lt;h3-highlight&gt;', '&lt;/h3-highlight&gt;', '&lt;highlight&gt;', '&lt;/highlight&gt;', '&lt;b&gt;', '&lt;/b&gt;');
	$replace_tags = array('<p/>', '<h3 class="highlight">', '</h3>', '<span class="highlight">', '</span>', '<b>', '</b>');

	return str_replace($allow_tags, $replace_tags, stripcslashes($data));
}


function url_builder($module, $url_path, $ishtml=false) {
	if ($module == ''){
		return '/'.$url_path;
	}
	$path = '/'.$module . URL_SEPARATOR . $url_path;
	if ($ishtml) {
		return $path . URL_SUFFIX;
	} else {
		if (substr($path,strlen($path) -1) !='/') {
			$path .= '/';
		}
		return $path;
	}
}



function get_tour_by_promotion_allow_in_vietnam($tours){
	$ret = array();

	foreach ($tours as $tour){

		if (!check_prevent_promotion($tour['id']) || (isset($tour['apply_for_hanoi']) && $tour['apply_for_hanoi'] == STATUS_ACTIVE)){

			$ret[] = $tour;
		}

	}

	return $ret;
}

function check_prevent_promotion($tour_id = ''){
	
	return false; // request from Mr.Dung => don't need to hide the price

	$CI =& get_instance();

	$country_code = '';

	$tour_prevent_config = $CI->config->item('tour_prevent_promotion');

	$ip_trace_country_code = $CI->config->item('ip_trace_country_code');

	$ip_trace_city = $CI->config->item('ip_trace_city');

	/**
	 * don't prevent any tour promotion
	 */
	if ($tour_prevent_config['flag'] != 1){
		return false;
	}


	// if admin login: don't prevent promotion
	$app_context = $CI->session->userdata('APP_CONTEXT');

	if (isset($app_context) && isset($app_context['user'])){
		return false;
	}

	$city = '';

	if ($CI->session->userdata('user_country_code')){

		$country_code = $CI->session->userdata('user_country_code');

		$city =	$CI->session->userdata('user_city');
	}

	// if the user is in Hanoi => only get promotion in Hanoi
	if ($city != '' && count($ip_trace_city) > 0){

		if (in_array($city, $ip_trace_city)){

			return true;

		}

	}

	return false;

	/*
	if(in_array($tour_id, $tour_prevent_config['tour_ids']) && in_array($country_code, $CI->config->item('ip_trace_country_code'))){

		return true;

	} else {

		foreach ($tour_prevent_config as $key=>$value){

			if ($key != 'flag' && $key != 'tour_ids'){

				$arr_cities = explode(",", $key);

				if (in_array($city, $arr_cities) && in_array($tour_id, $value)){

					return true;
				}

			}

		}

		return false;
	}*/

}
function get_star_infor_tour($star, $icon) {
	/* switch ($class_tours) {
		case 3: // luxury - 5 star
			return get_star_infor(5, $icon);
		case 2: // deluxe - 4 star
			return get_star_infor(4, $icon);
		default: // 3 star
			return get_star_infor(3, $icon);
	} */
	return get_star_infor($star, $icon);
}
function get_star_infor($star=1, $icon=1) {
	$star_title = "";
	$css_img = "";
	if($star == 1){
		$star_title = lang('1_star_title');
		$css_img = "star1";
	}  else if ($star == 1.5){
		$star_title = lang('1.5_star_title');
		$css_img = "star1_5";
	}  else if ($star == 2){
		$star_title = lang('2_star_title');
		$css_img = "star2";
	}   else if ($star == 2.5){
		$star_title = lang('2.5_star_title');
		$css_img = "star2_5";
	}  else if ($star == 3){
		$star_title = lang('3_star_title');
		$css_img = "star3";
	}  else if ($star == 3.5){
		$star_title = lang('3.5_star_title');
		$css_img = "star3_5";
	}  else if ($star == 4){
		$star_title = lang('4_star_title');
		$css_img = "star4";
	}  else if ($star == 4.5){
		$star_title = lang('4.5_star_title');
		$css_img = "star4_5";
	}  else if ($star == 5){
		$star_title = lang('5_star_title');
		$css_img = "star5";
	}
	if ($icon == 1) {
		$css_img = 'l_' . $css_img;
	}
	$star_infor['title'] = $star_title;
	$star_infor['css_img'] = $css_img;
	return $star_infor;
}

function get_des_info($CI, $des_name){

	$dess = $CI->TourModel->searchDestinations(trim($des_name));


	if (count($dess) > 0){

		return $dess[0];

	}

	return false;

}

function get_travel_styles_param($cats, $travel_styles){

	$ret = array();

	$travel_styles = explode(":", $travel_styles);

	foreach ($travel_styles as $value){

		foreach ($cats as $cat){

			if ($value == $cat['name']){

				$ret[] = $cat['id'];

			}

		}

	}

	return $ret;

}

function get_duration_param($dur_list, $duration){

	$ret = "";

	foreach ($dur_list as $key=>$value){

		if (lang($value) == $duration){

			$ret = $key;

			break;
		}

	}

	return $ret;

}

function get_class_sv($c_services, $class_sv){

	$ret = array();

	$class_sv = explode(":", $class_sv);

	foreach ($class_sv as $c_v){

		foreach ($c_services as $value){

			if ($c_v == $value['name']){

				$ret[] = $value['id'];

			}

		}
	}

	return $ret;

}

function get_tour_search_params_from_url($CI, $c_services, $dur_list, $cats){

	$search_params = array();

	$url_params = urldecode($CI->uri->segment(2));

	$url_params = anti_sql($url_params);

	if ($url_params != ''){

		$search_criteria = array();

		$url_params = explode("&", $url_params);

		foreach ($url_params as $value){

			$params = explode("=", $value);

			if (isset($params[1])){

				$search_params[$params[0]] = $params[1];

			}

		}

		if(count($search_params) == 0) return false;

		if (isset($search_params['destination'])){

			$search_criteria['destinations'] = $search_params['destination'];

			$des = get_des_info($CI, $search_params['destination']);

			if ($des){

				$search_criteria['destination_ids'] = $des['id'];

			} else {

				$search_criteria['destination_ids'] = '-1';

			}

			$search_criteria['is_cruise_port'] = '';

		} else {
			$search_criteria['destinations'] = lang('search_placeholder');

			$search_criteria['destination_ids'] = "";

			$search_criteria['is_cruise_port'] = 0;
		}

		if (isset($search_params['departure_date'])){

			$search_criteria['departure_date'] = $search_params['departure_date'];

		} else {

			$search_criteria['departure_date'] = getDefaultDate();
		}

		if (isset($search_params['travel_styles'])){

			$search_criteria['travel_styles'] = get_travel_styles_param($cats, $search_params['travel_styles']);

		} else {

			$search_criteria['travel_styles'] = "";
		}

		if (isset($search_params['duration'])){

			$search_criteria['duration'] = get_duration_param($dur_list, $search_params['duration']);

		} else {

			$search_criteria['duration'] = "";
		}

		if (isset($search_params['group'])){

			$search_criteria['group_type'] = $search_params['group'];

		} else {

			$search_criteria['group_type'] = "";
		}

		if (isset($search_params['class_sv'])){

			$search_criteria['class_service'] = get_class_sv($c_services, $search_params['class_sv']);

		} else {
			$search_criteria['class_service'] = "";
		}

		return $search_criteria;

	}

	return false;


}

function load_travel_styles()
{
    $CI = & get_instance();
    $travel_styles = $CI->TourModel->getAllCategories();

    return $travel_styles;
}

function load_tour_type()
{
    $CI = & get_instance();

    $travel_styles = $CI->TourModel->getSystemTourTypes();

    // reorder for search form
    $styles = array();
    $luxury = '';
    $cheap = '';
    foreach ($travel_styles as $style)
    {
    	/**
    	 * Khuyenpv Feb 03, 2015: don't use Private for the Budget
    	 */
    	if($style['id'] == 4){
    		continue;
    	}

        if ($style['id'] == 1)
        {
            $cheap = $style;
            continue;
        }
        if ($style['id'] == 3)
        {
            $luxury = $style;
            $styles[] = $cheap;
        }
        else
        {
            $styles[] = $style;
        }
    }
    array_unshift($styles, $luxury);

    return $styles;
}

function load_global_data(){
	$CI =& get_instance();

	/**
	 *
	 *  Delete cache database element
	 *  Tin.VM 6.11.2014
	 *
	 */
// 	$cache_time = $CI->config->item('cache_day');

// 	$cache_file_id = 'search_global_data';

// 	$CI->load->driver('cache', array('adapter' => 'file'));

// 	if ( ! $global_data = $CI->cache->get($cache_file_id))
// 	{

// 		$regions = $CI->config->item("destination_regions");

// 		$regionData = '[';

// 		foreach ($regions as $key => $region) {
// 			$regionData .= '["' . $key . '",' . '"' . lang($region) . '"' . '],';

// 		}

// 		if ($regionData != '['){

// 			$regionData = substr($regionData, 0, strlen($regionData) - 1);
// 		}


// 		$regionData .= ']';


// 		$dess = $CI->TourModel->searchDestinations();

// 		$destination_data = '[';


// 		foreach ($dess as $key => $des) {

// 			$destination_data = $destination_data. '["'. $des['id']. '","'. $des['name']. '","'. $des['region'] . '","'. $des['parent']. '"]';

// 			if ($key != count($dess) - 1){

// 				$destination_data .= ',';

// 			}
// 		}


// 		$destination_data = $destination_data. ']';


// 		$global_data = '['.$destination_data.','.$regionData.']';

// 		$CI->cache->save($cache_file_id, $global_data, $cache_time);
// 	}

	$regions = $CI->config->item("destination_regions");

	$regionData = '[';

	foreach ($regions as $key => $region) {
		$regionData .= '["' . $key . '",' . '"' . lang($region) . '"' . '],';

	}

	if ($regionData != '['){

		$regionData = substr($regionData, 0, strlen($regionData) - 1);
	}


	$regionData .= ']';


	$dess = $CI->TourModel->searchDestinations();

	$destination_data = '[';


	foreach ($dess as $key => $des) {

		$destination_data = $destination_data. '["'. $des['id']. '","'. $des['name']. '","'. $des['region'] . '","'. $des['parent']. '"]';

		if ($key != count($dess) - 1){

			$destination_data .= ',';

		}
	}


	$destination_data = $destination_data. ']';


	$global_data = '['.$destination_data.','.$regionData.']';

	return $global_data;
}

function buildTourSearchCriteria($data='') {
	$CI =& get_instance();

	//$data['GLOBAL_DATAS'] = get_global_data();

	$data['c_services'] = load_tour_type();//$CI->config->item("class_tours");
	$data['dur_list'] = $CI->config->item("duration_search");

	$data['GLOBAL_DATAS'] = load_global_data();

	$data['cats'] = load_travel_styles();

	if ($CI->input->post('destinations') != '') { // build search criteria from _POST
		$search_criteria['destinations'] = $CI->input->post('destinations');
		$search_criteria['destination_ids'] = $CI->input->post('destination_ids');
		$search_criteria['departure_date'] = $CI->input->post('departure_date');
		$search_criteria['travel_styles'] = $CI->input->post('travel_styles');
		$search_criteria['duration'] = $CI->input->post('duration');
		$search_criteria['class_service'] = $CI->input->post('class_service');
		$search_criteria['is_cruise_port'] = $CI->input->post('is_cruise_port');
		$search_criteria['group_type'] = $CI->input->post('group_type');
		// save search criteria to session

	} elseif (! $CI->session->userdata("FE_tour_search_criteria")){

		$search_criteria = get_tour_search_params_from_url($CI, $data['c_services'], $data['dur_list'], $data['cats']);

		if (!$search_criteria){

			$search_criteria = array();

			$search_criteria['destinations'] = lang('search_placeholder');
			$search_criteria['destination_ids'] = '';
			$search_criteria['departure_date'] = getDefaultDate();
			$search_criteria['travel_styles'] = '';
			$search_criteria['duration'] = '';
			$search_criteria['group_type'] = '';
			$search_criteria['class_service'] = '';
			$search_criteria['is_cruise_port'] = 0;

		}

	} else {

		$search_criteria = get_tour_search_params_from_url($CI, $data['c_services'], $data['dur_list'], $data['cats']);

		if (!$search_criteria){

			$search_criteria = $CI->session->userdata("FE_tour_search_criteria");

		}

	}

	if(isset($data['destinations'])) {
		$search_criteria['destinations'] = $data['destinations'];
		$search_criteria['destination_ids'] = $data['destination_ids'];
	}

	if($CI->input->post('departure_date_check_rates') != '') {
		$search_criteria['departure_date'] = $CI->input->post('departure_date_check_rates');
		// save search criteria to session
		$CI->session->set_userdata("FE_tour_search_criteria", $search_criteria);
	}


	$sort_by = $CI->input->post('sort_by');
	if ($sort_by != ''){
		$search_criteria['sort_by'] = $sort_by;
		$CI->session->set_userdata("FE_tour_sort_criteria", $sort_by);
	} else {
		if (! $CI->session->userdata("FE_tour_sort_criteria")){
			$search_criteria['sort_by'] = 'best_deals';
		} else {
			$search_criteria['sort_by'] = $CI->session->userdata("FE_tour_sort_criteria");
		}
	}


	$search_criteria['uri_segment'] = 3;

	// if departure_date is empty then set departure_date=today
	if($search_criteria['departure_date'] == '') {
		$search_criteria['departure_date'] = date('d-m-Y');
	}

	$CI->session->set_userdata("FE_tour_search_criteria", $search_criteria);



	if(isset($data['action'])){

		$action = $data['action'];

		if($action == HALONG_BAY_CRUISES) {
			$search_criteria['destinations'] = 'Halong Bay';
		} else if ($action == MEKONG_RIVER_CRUISES) {
			$search_criteria['destinations'] = 'Ho Chi Minh City';
		} else if ($action == TOUR_HOME) {
			$search_criteria['destinations'] = 'Vietnam';
		}
	}

	$data['search_criteria'] = $search_criteria;

	$data['tour_search_view'] = $CI->load->view('tours/tour_search/tour_search_form', $data, TRUE);

	return $data;
}

function get_page_header($action){
	$key = str_replace('/','',$action);
	return lang($key);
}

function gen_md5_password($len = 6)
{
	// function calculates 32-digit hexadecimal md5 hash
	// of some random data
	$pass = substr(rand().rand(), 0, $len);
	return array('plaintext'=>$pass, 'encrypt'=>md5($pass));
	//return substr(md5(rand().rand()), 0, $len);
}

function is_enum($departure) {
	$enum = substr($departure, 0, 4);
	if(strtoupper($enum) == "ENUM") {
		return TRUE;
	}
	return FALSE;
}

function get_departure_short_text($departure) {
	$departure = trim($departure);
	$str_up ='UPSTREAM'; $str_down ='DOWNSTREAM';
	$more_dot = " <a href='javascript:void(0)' class='depart_help' style='text-decoration: underline;font-weight:bold'>...</a>";

	// Specific shedule format
	if(is_enum($departure)) {

		if(stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false) {
			$depart_up = get_departure_date($departure, $str_up, DEPARTURE_MONTH_SHOW_LIMIT);
			$depart_down = get_departure_date($departure, $str_down, DEPARTURE_MONTH_SHOW_LIMIT);

			$str_depart_up = '';
			if(!empty($depart_up)) {
				$str_depart_up = departure_shorten(get_depart_text(lang('label_upstream'), $depart_up), 135, ",", '').$more_dot;
			}

			$str_depart_down = '';
			if(!empty($depart_down)) {
				$str_depart_down = "<span style='margin-top:5px; float:left; padding-right:5px'>"
						.departure_shorten(get_depart_text(lang('label_downstream'), $depart_down), 135, ",", '').$more_dot."</span>";
			}

			$departure = $str_depart_up . $str_depart_down;
		} else {
			$depart_round_trip = get_departure_date($departure, "", DEPARTURE_MONTH_SHOW_LIMIT);
			$departure = get_depart_text("", $depart_round_trip) ." ".$more_dot;
		}
	} else {
		// Plain text format
		if(stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false) {
			$arr = explode("\n", $departure);
			$depart_up = isset($arr[0]) ? $arr[0] : '';
			$depart_down = isset($arr[0]) ? $arr[1] : '';
			if(!empty($depart_up)) $depart_up = character_limiter($depart_up, 65, ' ').$more_dot;
			if(!empty($depart_down)) $depart_down = character_limiter($depart_down, 65, ' ').$more_dot;

			$departure = $depart_up."<span style='margin-top:5px; float:left; padding-right:5px'>"
						.$depart_down."</span>";

		} else {
			if(strlen($departure) > 100) {
				$departure = character_limiter($departure, 100, ' ').$more_dot;
			}
		}
	}

	return $departure;
}

function is_roundtrip($departure) {
	$def_text =  array("upstream", "downstream", "up", "down");
	foreach ($def_text as $text) {
		if(stripos($departure, $text) !== false) {
			return false;
		}
	}

	return true;
}

function get_departure_full_text($departure) {

	$str ="";
	$str_up ='UPSTREAM'; $str_down ='DOWNSTREAM';
	$departure = trim($departure);

	if(is_enum($departure)) {

		if(stripos($departure, $str_up) !== false || stripos($departure, $str_down) !== false) {
			$depart_up = get_departure_date($departure, $str_up);
			$depart_down = get_departure_date($departure, $str_down);

			$str = '<table class="tbl_departs" cellspacing=0>';
			$str .= "<tr>";
			$current_month = "";
			for ($i = 1; $i <= 12; $i++) {
				if($i==1) $str .= '<td style="font-weight:bold" colspan="2">'.lang('label_cruise_schedule').'</td>';
				$str .= '<td style="font-weight:bold;width:130px">'.strftime( '%b', mktime( 0, 0, 0, $i, 1 ) )."</td>";
			}
			$str .= "</tr>";

			$years = get_text_depart_year($departure, true);
			if(!empty($years)) {
				foreach ($years as $year) {
					$count_year = 0;
					$str .= "<tr>";
					if(is_roundtrip($departure)) {
						$str .= '<td>&nbsp;</td>';
					} else {
						$str .= '<td style="font-weight:bold" rowspan="2">'.$year.'</td>'.'<td style="font-weight:bold">'.lang('label_upstream').'</td>';
					}

					if(!empty($depart_up)) {
						for ($i = 1; $i <= 12; $i++) {
							$depart = trim($year).'-'.$i.'-1';
							$txtDay = get_text_depart_day($depart_up, $depart);
							if(empty($txtDay)) $txtDay = '&nbsp;';
							$str .= "<td>".$txtDay."</td>";
						}
					}

					$str .= "</tr>";

					$str .= "<tr>";
					if(is_roundtrip($departure)) {
						$str .= '<td>&nbsp;</td>';
					} else {
						$str .= '<td style="font-weight:bold">'.lang('label_downstream').'</td>';
					}
					if(!empty($depart_down)) {
						for ($i = 1; $i <= 12; $i++) {
							$depart = trim($year).'-'.$i.'-1';
							$txtDay = get_text_depart_day($depart_down, $depart);
							if(empty($txtDay)) $txtDay = '&nbsp;';
							$str .= "<td>".$txtDay."</td>";
						}
					}

					$str .= "</tr>";
				}
			}


			$str .= "</table>";
		} else {
			$depart_up = get_departure_date($departure);

			$str = '<table class="tbl_departs" cellspacing=0>';
			$str .= "<tr>";
			$current_month = "";
			for ($i = 1; $i <= 12; $i++) {
				if($i==1) $str .= '<td style="font-weight:bold">'.lang('label_cruise_schedule').'</td>';
				$str .= '<td style="font-weight:bold">'.strftime( '%b', mktime( 0, 0, 0, $i, 1 ) )."</td>";
			}
			$str .= "</tr>";
			$years = get_text_depart_year($departure, true);
			if(!empty($years)) {
				foreach ($years as $year) {
					$count_year = 0;
					$str .= "<tr>";
					$str .= '<td align="center" style="font-weight:bold">'.$year.'</td>';

					for ($i = 1; $i <= 12; $i++) {
						$depart = trim($year).'-'.$i.'-1';
						$txtDay = get_text_depart_day($depart_up, $depart);
						if(empty($txtDay)) $txtDay = '&nbsp;';
						$str .= "<td>".$txtDay."</td>";
					}
					$str .= "</tr>";
				}
			}
			$str .= "</table>";
		}

	} else {
		$str = str_replace("\n", '<br/>', $departure);
		$str = str_replace("\r", '<br/>', $str);
	}

	return $str;
}

function get_text_depart_year($departure, $is_list_years = FALSE) {
	$arrStr = "";
	$departure = trim($departure);

	if(is_enum($departure)) {
		$departure = substr($departure,4, strlen($departure));
		$def_text =  array("upstream", "downstream", "up", "down");
		foreach ($def_text as $text) {
			$departure = str_ireplace($text, '', $departure);
		}
		$departure = str_replace(".", '', $departure);
		$departure = str_replace("\r", '', $departure);
		$departure = strip_tags($departure);
		$arrYear = explode("\n", $departure);

		$start = ""; $end = ""; $cnt = 0;
		$years = array();
		foreach ($arrYear as $strYear) {
			if(!empty($strYear)) {
				$str = get_departure_years($strYear);
				if($cnt ==0) {
					$start = $str['year'];
					$cnt++;
				}
				if($cnt > 0 && $str['year'] > $start) {
					$end = $str['year'];
				}

				if(!in_array($str['year'], $years)) {
					$years[] = $str['year'];
				}
			}
		}

		if($is_list_years) {
			return $years;
		}

		$arrStr = $start;
		if(!empty($end)) $arrStr .= " - ".$end;

		return $arrStr;
	}
	return $arrStr;
}

function get_text_depart_day($departs, $current_month) {
	$str_days = "";
	$current_month = date("Y-m", strtotime($current_month));
	$cnt = 0;
	foreach ($departs as $depart) {
		$compare_date = date("Y-m", strtotime($depart));
		if(strtotime($compare_date) == strtotime($current_month)) {
			if($cnt > 0) $str_days .= ", ";
			$str_days .= date("j", strtotime($depart));
			$cnt++;
		}
	}
	$str_days = trim($str_days);

	return $str_days;
}

function get_depart_text($direction, $arrDate) {
	$str_depart = "";
	if(!empty($direction)) $str_depart = '<label class="highlight" style="font-weight:bold">'.$direction.': </label>';

	$current_month = "";
	$current_year = "";
	$cnt = 0;
	foreach ($arrDate as $key=>$depart) {
		if($key==0)  {
			$str_depart .= "<b>".date("Y", strtotime($depart)).": </b>";
			$current_year = date("Y", strtotime($depart));
		}
		if($current_month != date("M", strtotime($depart))) {
			if(!empty($current_month)) $str_depart .= " | ";

			if($current_year != date("Y", strtotime($depart)) && $key > 0) {
				$current_year = date("Y", strtotime($depart));
				$str_depart .= "<b>".date("Y", strtotime($depart)).": </b>";
			}

			$str_depart .= date("M j", strtotime($depart));
			$current_month = date("M", strtotime($depart));
			$cnt = 1;
		} else {
			if($cnt > 0) $str_depart .= ", ";
			$str_depart .= date("j", strtotime($depart));
			$cnt++;
		}

	}
	return trim($str_depart);
}

function getDepartureDate($departure) {
	$departure = trim($departure);

	if(is_enum($departure)) {
		$departure = substr($departure,4, strlen($departure));

		$def_text =  array("upstream", "downstream", "up", "down");
		foreach ($def_text as $text) {
			$departure = str_ireplace($text, '', $departure);
		}
		$departure = str_replace(".", '', $departure);
		$departure = str_replace("\r", '', $departure);
		$departure = strip_tags($departure);
		$arrYear = explode("\n", $departure);

		$arrStr = "[";
		foreach ($arrYear as $strYear) {
			if(!empty($strYear)) {
				$str = get_departure_years($strYear);
				$year = $str['year'];
				$strDate = $str['dates'];
				if(!empty($year)) {
					$arrD = json_encode(get_departure_dates_by_year($strDate));
					$arrStr .= '[' . $year . ',' . $arrD . '],';
				}
			}
		}

		$arrStr = substr($arrStr, 0, -1);

		$arrStr .= "]";

		return $arrStr;
	}

	return null;
}

function get_departure_date($departure, $direction='', $month_limit=0, $departure_date='', $format=DATE_FORMAT_STANDARD) {
	$departure = substr($departure,4, strlen($departure));

	if(!empty($direction)) {
		$pos = strripos($departure, "DOWNSTREAM");
		if($pos == 0) $pos = strripos($departure, "DOWN");

		if($pos !== false) {
			if(strtoupper($direction) == "UPSTREAM") {
				$departure = substr($departure, 0, $pos);
			} else {
				$departure = substr($departure, $pos, strlen($departure));
			}
		} else {

			if(strtoupper($direction) == "DOWNSTREAM") {
				return;
			}
		}
	}

	$departure = trim($departure);
	$def_text =  array("upstream", "downstream", "up", "down");
	foreach ($def_text as $text) {
		$departure = str_ireplace($text, '', $departure);
	}
	$departure = str_replace(".", '', $departure);
	$departure = str_replace("\r", '', $departure);
	$departure = strip_tags($departure);
	$arrYear = explode("\n", $departure);

	$arrDate = array();

	foreach ($arrYear as $strYear) {
		if(!empty($strYear)) {
			$str = get_departure_years($strYear);
			$year = $str['year'];
			$strDate = $str['dates'];
			$d_dates = get_departure_dates_by_year($strDate);
			foreach ($d_dates as $st_date) {
				$arr_date = explode(",", $st_date['date']);
				foreach ($arr_date as $d_day) {
					$d_day = trim($d_day);
					$new_date = date($format, strtotime($d_day."-".$st_date['month']."-".$year));
					array_push($arrDate, $new_date);
				}
			}
		}
	}

	if($month_limit > 0) {
		$current_date = date("Y-m-d");
		if(!empty($departure_date)) $current_date = date("Y-m", strtotime($departure_date));
		//$count = DEPARTURE_MONTH_SHOW_LIMIT;


		$arr_short_date = array();
		$start_date;
		foreach ($arrDate as $key => $departure) {
			$compare_date = date("Y-m-d", strtotime($departure));
			$compare_month = date("m", strtotime($compare_date));
			if($key==0) {
				$curent_month = date("m", strtotime($compare_date));
			}

			// compare vs today
			if(strtotime($compare_date) <= strtotime(date("Y-m-d"))) continue;



			if(empty($start_date) && strtotime($current_date) <= strtotime($compare_date)) {
				$start_date = date("Y-m-d", strtotime($departure));
			}
			if(!empty($start_date)
					//&& $count > 0
					&& strtotime($compare_date) >= strtotime($start_date)) {
				array_push($arr_short_date, $departure);
			}

			if($curent_month != $compare_month) {
				//$count--;
				$curent_month = $compare_month;
			}
		}

		$arrDate = $arr_short_date;
	}

	return $arrDate;
}

function get_departure_years($strYear) {
	$arrDates = explode("|", trim($strYear));
	$year = '';
	$strDate = '';
	foreach ($arrDates as $key => $value) {
		$value = trim($value);
		if($key == 0) {
			$arr = explode(":", $value);
			foreach ($arr as $ar)  {
				$ar = trim($ar);
				if(strlen($ar) == 4 && is_numeric($ar)) {
					$year = $ar;
				}
			}
			$strYear = str_replace($value, '', $strYear);
			$str = str_replace($year, '', $value);
			$str = str_replace(":", '', $str);
			$strDate = $str.$strYear;
		}
	}

	return array('year'=> $year, 'dates'=>$strDate);
}

function get_departure_dates_by_year($strDate) {
	$arrStr = array();
	$arrDates = explode('|', trim($strDate));
	foreach ($arrDates as $key => $value) {
		$value = trim($value);
		$strMonth = substr($value, 0, 3);
		$strD = str_replace($strMonth, '', $value);
		$strD = str_replace(':', '', $strD);
		$strD = trim($strD);

		$date = date_parse($strMonth);
		$month = $date['month'];
		array_push($arrStr, array('month'=> $month, 'date'=>$strD));
	}

	return $arrStr;
}

function get_travel_specific_dates($promotion_dates){
	$ret = "";

	$years = array();

	foreach ($promotion_dates as $date){
		$y = date('Y', strtotime($date['date']));
		$years[$y] = $y;
	}

	foreach ($years as $key => $year){

		$months = array();

		foreach ($promotion_dates as $date){
			$y = date('Y', strtotime($date['date']));
			$m = date('M', strtotime($date['date']));

			if ($year == $y){
				$months[$m] = $m;
			}

		}

		$years[$key] = $months;

	}

	foreach ($years as $year => $months){

		foreach ($months as $mk => $month){

			$days = "";
			foreach ($promotion_dates as $date){
				$y = date('Y', strtotime($date['date']));
				$m = date('M', strtotime($date['date']));
				$d = date('d', strtotime($date['date']));

				if ($year == $y && $mk == $m){

					if ($days == "") {$days = $d;}

					else

					$days = $days.", ". $d;
				}
			}

			$months[$mk] = $days;

		}

		$years[$year] = $months;

	}

	foreach ($years as $year => $months){

		if ($ret != '') $ret = $ret. ".\n";

		$ret = $ret. $year. ": ";

		foreach ($months as $month => $days){

			$ret = $ret . $month. ": ". $days." | ";

		}

		if ($ret != '') $ret = substr($ret, 0, strlen($ret) - 2);
	}

	return $ret;
}

function getDefaultDate() {
	//return date(DATE_FORMAT_STANDARD, strtotime("+1 day"));
	return date(DATE_FORMAT_STANDARD);
}


function get_cruise_type($cruise){

	$budget = '';

	if (in_array($cruise['star'], array(5,4.5))){
		$budget = lang('label_luxury');
	} elseif (in_array($cruise['star'], array(4,3.5))){
		$budget = lang('label_deluxe');
	} elseif (in_array($cruise['star'], array(3, 2.5, 2, 1.5, 1))){
		$budget = lang('label_budget');
	}

	$private_sharing = $cruise['cabin_type'] == 1 ? lang('label_sharing') : lang('label_private');

	$cabin_text = "";

	if ($cruise['num_cabin'] == 0){

		$cabin_text = ucwords(lang('label_day_cruise'));

	} elseif ($cruise['num_cabin'] == 1){

		$cabin_text = "1 ".lang('label_cabin');

	} else {

		$cabin_text = $cruise['num_cabin']. ' '.lang('label_cabins');

	}


	return $budget.', '. $private_sharing.', '.$cabin_text;

}

function review_score_lang($score) {
	$score_lang = '';
	if($score >= 9) {
		$score_lang = '<label class="choice">'.lang('review_rate_excellent').'</label>';
	} else if($score >= 8 && $score < 9) {
		$score_lang = '<label class="highlight">'.lang('review_rate_very_good').'</label>';
	} else if($score >= 7 && $score < 8) {
		$score_lang = '<label class="highlight">'.lang('review_rate_good').'</label>';
	} else if($score >= 6 && $score < 7) {
		$score_lang = lang('review_rate_average');
	} else if($score >= 5 && $score < 6) {
		$score_lang = lang('review_rate_poor');
	} else if($score < 5) {
		$score_lang = lang('review_rate_terrible');
	}
	return $score_lang;
}


function get_days_left($expiry_date){

		$now = time();

	    $expiry_date = strtotime($expiry_date);

	    $datediff = $expiry_date - $now;

	    return floor($datediff/(60*60*24) + 1);
}

function get_expired_text($expiry_date) {
	$text='';
	$numb_days = get_days_left($expiry_date);
	if($numb_days == 0) {
		$diff = timeDiff(mktime(24,0,0), time());
		$count = 0;
		foreach($diff as $unit => $value)
		{
			$text .= $value;
			if($count+1 < count($diff)) {
				$text .= " : ";
			}
			$count++;
		}

		$text = lang('time_left_to_buy')
				. '<label id="timeLeft" style="font-size:12pt">'.$text.'</label>';
		$text .= '<script>getTimeLeft();</script>';

	} elseif($numb_days <= 10) {
		$text = lang('days_left');
		$text = str_replace('%s', $numb_days, $text);
	} else {
		$text = lang('expired_on');
		$text = str_replace('%s', date('d M, Y', strtotime($expiry_date)), $text);
	}

	return $text;
}

function get_date_arr($arrival_date, $departure_date)
{
	$dateMonthYearArr = array();
	/*
	$fromDateTS = strtotime($arrival_date);

	$toDateTS = strtotime($departure_date);

	for ($currentDateTS = $fromDateTS; $currentDateTS < $toDateTS; $currentDateTS = $currentDateTS + (60 * 60 * 24)) {

		$currentDateStr = date(DB_DATE_FORMAT,$currentDateTS);

		$dateMonthYearArr[] = $currentDateStr;

	}*/

	$from_date = date(DB_DATE_FORMAT, strtotime($arrival_date));

	$to_date = date(DB_DATE_FORMAT, strtotime($departure_date));

	for ($currentDate = $from_date; $currentDate < $to_date; $currentDate = date(DB_DATE_FORMAT, strtotime($currentDate . " +1 day"))) {

		$dateMonthYearArr[] = $currentDate;

	}


	return $dateMonthYearArr;

}



function get_hotel_search_params_from_url(){

	$CI =& get_instance();

	$search_params = array();

	$url_params = urldecode($CI->uri->segment(3));

	// anti sql injection
	$url_params = anti_sql($url_params);

	if ($url_params != ''){

		$search_criteria = array();

		$url_params = explode("&", $url_params);

		foreach ($url_params as $value){

			$params = explode("=", $value);

			if (isset($params[1])){
				$search_params[$params[0]] = $params[1];
			}
		}

		if (count($search_params) == 0){
			return false;
		}

		if (isset($search_params['destination'])){

			$search_criteria['destination'] = $search_params['destination'];

			$search_objects = $CI->HotelModel->getSearchObjects();

			foreach ($search_objects as $value){

				if ($value['object_type'] == -1 && $value['name'] == $search_params['destination']){

					$search_criteria['destination_id'] = $value['id'];

					break;

				}

			}


		} else {
			$search_criteria['destination'] = lang('hotel_search_title');

		}

		if (isset($search_params['arrival_date'])){

			$search_criteria['arrival_date'] = $search_params['arrival_date'];

		} else {

			$search_criteria['arrival_date'] = getDefaultDate();
		}

		if (isset($search_params['night'])){

			$search_criteria['hotel_night'] = $search_params['night'];

		} else {

			$search_criteria['hotel_night'] = 1;
		}

		$search_criteria['hotel_stars'] = array();
		if (isset($search_params['star'])){

			$stars = explode(":", $search_params['star']);

			$search_criteria['hotel_stars'] = $stars;

		}

		if (isset($search_params['sort_by'])){

			$search_criteria['sort_by'] = $search_params['sort_by'];

		} else {

			$search_criteria['sort_by'] = 'best_deals';

		}


		return $search_criteria;
	}

	return false;

}

function buildHotelSearchCriteria($des='') {
	$CI =& get_instance();

	if (!$CI->session->userdata("FE_hotel_search_criteria")){

		$search_criteria = get_hotel_search_params_from_url();

		if (!$search_criteria){

			$search_criteria = array();

			$search_criteria['destination'] = lang('hotel_search_title');


			$search_criteria['hotel_stars'] = array();

			$search_criteria['destination_id'] = '';
			$search_criteria['arrival_date'] = getDefaultDate(); // return tomorrow
			$search_criteria['hotel_night'] = '1';

			$search_criteria['sort_by'] = 'best_deals';

		}

	} else {

		$search_criteria = get_hotel_search_params_from_url();

		if (!$search_criteria){
			$search_criteria = $CI->session->userdata("FE_hotel_search_criteria");
		}

	}

	if($des != ''){

		$search_criteria['destination_id'] = $des['id'];

		$search_criteria['destination'] = $des['name'];

	} else {

		$destination_id = $CI->input->post('destination_id');

		if ($destination_id != ''){
			$search_criteria['destination_id'] = $destination_id;
		}

		$destination = $CI->input->post('destination');

		if ($destination != ''){

			$search_criteria['destination'] = $destination;
		}

	}


	$hotel_stars = $CI->input->post('hotel_stars');

	if ($hotel_stars != '' && count($hotel_stars) > 0){

		$search_criteria['hotel_stars'] = $hotel_stars;

	}


	$arrival_date = $CI->input->post('arrival_date');

	if ($arrival_date != ''){
		$search_criteria['arrival_date'] =  date('d-m-Y', strtotime($arrival_date));
	}

	$hotel_night = $CI->input->post('hotel_night');

	if ($hotel_night != ''){
		$search_criteria['hotel_night'] = $hotel_night;
	}

	$arrival_date = $CI->input->post('arrival_date_check_rate');

	if ($arrival_date !=''){
		$search_criteria['arrival_date'] =  date('d-m-Y', strtotime($arrival_date));
	}

	$hotel_night = $CI->input->post('hotel_night_check_rate');

	if ($hotel_night != ''){

		$search_criteria['hotel_night'] = $hotel_night;

	}

	$sort_by = $CI->input->post('sort_by');

	if ($sort_by != ''){
		$search_criteria['sort_by'] = $sort_by;
	} else{
		$search_criteria['sort_by'] = 'best_deals';
	}

	$search_criteria = setDefaultHotelSearchCriteria($search_criteria);

	return $search_criteria;
}

function setDefaultHotelSearchCriteria($search_criteria) {
	$CI =& get_instance();
	if(!array_key_exists('destination_id', $search_criteria)){
		$search_criteria['destination_id'] = '';
	}

	if(!array_key_exists('destination', $search_criteria)){
		$search_criteria['destination'] = lang('hotel_search_title');
	}


	if(!array_key_exists('hotel_stars', $search_criteria)){
		$search_criteria['hotel_stars'] = array();
	}

	if(!array_key_exists('arrival_date', $search_criteria)){
		$search_criteria['arrival_date'] = getDefaultDate();
	}

	if(!array_key_exists('hotel_night', $search_criteria)){
		$search_criteria['hotel_night'] = '1';
	}

	/*
	$destination_id = (int)$CI->uri->segment(3);

	if($destination_id != ''){
		$des = $CI->HotelModel->getDestination($destination_id);
		$search_criteria['destination'] = $des['name'];
	}*/

	$departure_date = strtotime(date("d-m-Y", strtotime($search_criteria['arrival_date'])) . " +". $search_criteria['hotel_night']. " day");


	$search_criteria['departure_date'] = date('d-m-Y', $departure_date);

	//log_message('debug','arrival_date = ' . $search_criteria['arrival_date'] . '; departure_date = '. $search_criteria['departure_date']);

	$CI->session->set_userdata("FE_hotel_search_criteria", $search_criteria);

	return $search_criteria;
}

function get_list_dates_hot_deals($promotions){

	$ret = array();

	$today = date('Y-m-d');

	for ($i = 0; $i < 12; $i++) {

		$time = strtotime(date("Y-m-d", strtotime($today)). "+".$i." month");

		$date = date('Y-m-d', $time);

		foreach($promotions as $value){

			if ($date >= $value['start_date'] && ($value['end_date'] == '' || $date <= $value['end_date'])){

				$ret[] = $date;

				break;

			}

		}

	}
	return $ret;
}

function get_header_desc($action) {
	$desc = array();
	if ($action == HALONG_BAY_CRUISES) {
		$desc['header'] = lang('halongbaycruises');
		$desc['desc'] = lang('halong_bay_cruises_desc');
	} else if ($action == MEKONG_RIVER_CRUISES) {
		$desc['header'] = lang('mekongrivercruises');
		$desc['desc'] = lang('mekong_river_cruises_desc');
	} else {
		$overview = str_replace('/', '', $action);
		$desc['header'] = lang($overview);
		$desc['desc'] = '';
	}

	return $desc;
}

function get_list_hotel_destination($hotels){

	$ret = array();

	foreach ($hotels as $hotel){

		if (count($ret) == 0 || !in_array($hotel['destination'], $ret)){

			$ret[] = $hotel['destination'];
		}



	}

	return $ret;
}

function get_promotion_hot_deals($key_field, $promotion_details){

		$today = date('Y-m-d');

		$temp_p = array();

		foreach ($promotion_details as $value){

			if(!array_key_exists($value[$key_field], $temp_p)){

				$temp_p[$value[$key_field]] = $value;

			} else{

				$previous_value = $temp_p[$value[$key_field]];

				$value['start_date'] = date('Y-m-d', strtotime($value['start_date']));

				$previous_value['start_date'] = date('Y-m-d', strtotime($previous_value['start_date']));

				if ($value['is_hot_deals'] == 1){

					if($previous_value['is_hot_deals'] != 1){

						if (($value['start_date'] < $previous_value['start_date'] && $previous_value['start_date'] > $today)
							|| ($value['end_date'] == '' && $previous_value['end_date'] != '') || ($value['end_date'] > $previous_value['end_date'])){

							$temp_p[$value[$key_field]] = $value;
						}

					} else {

						// don't replace

					}

				}


			}

		}


		$ret = array();

		foreach ($temp_p as $value){

			if ($value['is_hot_deals'] == 1){

				$ret[] = $value;

			}

		}

		return $ret;
}

function is_surcharge($departure_date, $duration, $c_date) {

	$c_date = date('Ymd', strtotime($c_date));
	$departure_date = date('Ymd', strtotime($departure_date));
	$arrival_date = $departure_date;

	if(!empty($duration)) {
		$duration = $duration - 2;
		//echo($duration);exit();
		$arrival_date = strtotime ( "+".$duration." day" , strtotime ( $departure_date ) ) ;
		$arrival_date = date ( 'Ymd' , $arrival_date );
	}

	//echo($departure_date.'-'.$arrival_date.'-'.$c_date.'<br>');exit();

	if ($c_date >= $departure_date && $c_date <= $arrival_date) {
		return true;
	}

	return false;
}

function get_extra_service_pax($extra_service_pax, $service_id) {
	if(!empty($extra_service_pax)) {
		foreach ($extra_service_pax as $extra_service) {
			$str = explode('_', $extra_service);
			$extra_service_id = $str[0];
			if($extra_service_id == $service_id) {
				$extra_service_val = $str[1];
				return $extra_service_val;
			}
		}
	}
}

function replace_new_line($content) {
	$content = strip_tags($content);
	$content = str_replace("\n", "<br>", $content);
	$content = str_replace("\r", "", $content);

	return $content;
}

function get_tour_price_view ($tour, $is_format_number = true) {
	$discount_price = 0;
	$final_price = 0;
	$final_together = 0;

	$discount = isset($tour['price']['discount']) ? $tour['price']['discount'] : 0;


	if(!isset($tour['price']['from_price'])) $tour['price']['from_price'] = 0;

	$price_now = get_price_now($tour['price']);


	if($price_now != $tour['price']['from_price']) {
		if ($is_format_number){
			$discount_price = number_format($tour['price']['from_price'], CURRENCY_DECIMAL);
		} else {
			$discount_price = $tour['price']['from_price'];
		}
	}

	if ($is_format_number){
		$final_price = number_format($price_now, CURRENCY_DECIMAL);
		$final_together =  number_format($price_now - $discount, CURRENCY_DECIMAL);
		$discount = number_format($discount, CURRENCY_DECIMAL);
	} else {

		$final_price = $price_now;
		$final_together =  $price_now - $discount;

	}

	return array('d_price' => $discount_price, 'f_price' => $final_price, 'f_together_price' => $final_together, 'discount' => $discount);
}

function get_similar_tour_text ($tour) {
	$title = $more_text = '';
	if(isset($tour['des'])) {
		if ($tour['cruise_id'] > 0) {
			$cruise_location = '';
			if($tour['cruise_destination'] == 0) {
				$title = lang('similar_halong_cruise_tours');
				$more_text = lang('more_halong_bay_tours');
				$cruise_location = ' Halong Bay ';
			} elseif($tour['cruise_destination'] == 1) {
				$title = lang('similar_mekong_cruise_tours');
				$more_text = lang('more_mekong_delta_tours');
				$cruise_location = ' Mekong Delta ';
			}

			$CI = & get_instance();
			$CI->load->model('TourModel');

			$travel_style = $CI->TourModel->getTourTravelStype($tour['class_tours'], $tour['cruise_destination']);

			if(!empty($travel_style)) {
				$title = lang_arg('similar_name_tour', $cruise_location.$travel_style['name']);
				$more_text = lang_arg('more_name_tour', $cruise_location.$travel_style['name']);

			}
		} else {
			$title = lang_arg('similar_name_tour', $tour['des']['name']);
			$more_text = lang_arg('more_name_tour', $tour['des']['name']);
		}
	}

	return array('title' => $title, 'more_text' => $more_text);
}

function get_alt_image_text($cruise){

	$alt = $cruise['name'];

	if ($cruise['cruise_destination'] == 0){

		$alt = $alt. " Halong Bay";

	} else {
		/*
		$pos = strpos($alt, "Mekong");

		if ($pos === false){

			$alt = $alt . " Mekong";
		}*/
	}

	return $alt;

}

function get_alt_image_text_hotel($hotel){

	$alt = $hotel['name'];

	$pos = strpos($alt, $hotel['destination_name']);

	if ($pos === false){

		$alt = $alt . ' ' . $hotel['destination_name'];
	}

	return $alt;
}

function get_alt_tour_image_text($tour){

	$alt = $tour['name'];

	if ($tour['cruise_destination'] == 0){

		$alt = " Halong Bay Cruise Tour on " .$alt;

	} else {

		$pos = strpos($alt, "Mekong");

		if ($pos === false){

			$alt = " Mekong River Cruise Tour on " .$alt;
		}
	}

	return $alt;
}

function is_suitable_service($service, $booking_info) {
	$min = $service['min_cap'];
	$max = $service['max_cap'];
	$numb = $booking_info['children'] + $booking_info['adults'];//+ $booking_info['infants']

	if(empty($max) && !empty($min)) {
		if($numb < $min) return FALSE;
	}
	if(empty($min) && !empty($max)) {
		if($numb > $max) return FALSE;
	}
	if(!empty($min) && !empty($max)) {
		if($numb < $min || $numb > $max) return FALSE;
	}

	return TRUE;
}

function load_faq_by_context($page_id, $data){

	$CI =& get_instance();

	/*
	$cache_time = $CI->config->item('cache_day');

	$CI->load->driver('cache', array('adapter' => 'file'));

	$cache_file_id = 'faq_by_context_'.$page_id;

	if ( ! $faq_by_context_view = $CI->cache->get($cache_file_id))
	{

		$data['faq_questions'] = $CI->FaqModel->getFaqQuestions($page_id);

		$faq_by_context_view = $CI->load->view('faq/faq_context', $data, TRUE);

		// Save into the cache for 5 minutes
		$CI->cache->save($cache_file_id, $faq_by_context_view, $cache_time);

		//echo 'go here'; exit();
	}*/

	$data['faq_questions'] = $CI->FaqModel->getFaqQuestions($page_id);

	$faq_by_context_view = $CI->load->view('faq/faq_context', $data, TRUE);

	$data['faq_context'] = $faq_by_context_view;

	return $data;
}

function load_hotel_top_destination($data){

	$CI =& get_instance();

	/*
	$cache_time = $CI->config->item('cache_day');

	$cache_file_id = 'hotel_top_destinations';

	$CI->load->driver('cache', array('adapter' => 'file'));

	if ( ! $top_destination_view = $CI->cache->get($cache_file_id))
	{
		//$data['parent_dess'] = $CI->HotelModel->getTopParentDestinations();
		$data['top_dess'] = $CI->HotelModel->getHotelTopDestinations();

		$top_destination_view = $CI->load->view('hotels/hotel_top_destination', $data, TRUE);

		// Save into the cache for 5 minutes
		$CI->cache->save($cache_file_id, $top_destination_view, $cache_time);

	}*/


	$data['top_dess'] = $CI->HotelModel->getHotelTopDestinations();

	$top_destination_view = $CI->load->view('hotels/hotel_top_destination', $data, TRUE);

	$data['top_destination_view'] = $top_destination_view;

	return $data;

}

function load_hotel_search_autocomplete($data){

	$CI =& get_instance();

	/**
	 *
	 *  Delete cache database element
	 *  Tin.VM 6.11.2014
	 *
	 */

// 	$cache_time = $CI->config->item('cache_day');

// 	$cache_file_id = 'hotel_search_autocomplete_data';

// 	$CI->load->driver('cache', array('adapter' => 'file'));

// 	if ( ! $search_objects = $CI->cache->get($cache_file_id))
// 	{

// 		$search_objects = $CI->HotelModel->getSearchObjects();

// 		// Save into the cache for 5 minutes
// 		$CI->cache->save($cache_file_id, $search_objects, $cache_time);

// 	}
	$search_objects = $CI->HotelModel->getSearchObjects();

	$regions = $CI->config->item("destination_regions");
	$regionData = '[';
	foreach ($regions as $key => $region) {
		$regionData .= '["' . $key . '",' . '"' . lang($region) . '"' . '],';
	}
	$regionData .= ']';
	$data['search_data'] = json_encode($search_objects);
	$data['regionData'] = $regionData;

	return $data;
}

function get_similar_cruise_type($cruise){

	$budget = '';$more_text =''; $cruise_location='';$cruise_port_str='';

	if($cruise['cruise_destination'] == 0){
		$cruise_location = " Halong Bay ";
		$cruise_port_str = "halongcruises";

		if (in_array($cruise['star'], array(5,4.5))){
			$budget = "Luxury";
			$more_text = get_text_link_function('/luxury'.$cruise_port_str.'/', lang('more_luxury_halong_cruises'));
		} elseif (in_array($cruise['star'], array(4,3.5))){
			$budget = "Mid-range";
			$more_text = get_text_link_function('/deluxe'.$cruise_port_str.'/', lang('more_deluxe_halong_cruises'));
		} elseif (in_array($cruise['star'], array(3, 2.5, 2, 1.5, 1))){
			$budget = "Budget";
			$more_text = get_text_link_function('/cheap'.$cruise_port_str.'/', lang('more_cheap_halong_cruises'));
		}

		if($cruise['cabin_type'] == 2) {
			$budget = "Private";
			$more_text = get_text_link_function('/private'.$cruise_port_str.'/', lang('more_private_halong_cruises'));
		}

		if($cruise['num_cabin'] == 0 ) {
			$budget = "Day";
			$more_text = get_text_link_function('/halongbaydaycruises/', lang('more_halongbay_day_cruises'));
		}
	} else {
		$cruise_location = lang('label_mekong_river_cruises');
		$cruise_port_str = "mekongcruises";
		$cruise_des = VIETNAM_CAMBODIA_CRUISE_DESTINATION;

		$cruise_destination = explode(',', $cruise['mekong_cruise_destination']);

		foreach ($cruise_destination as $key => $des) {
			/* if($des != VIETNAM_CAMBODIA_CRUISE_DESTINATION) {
				$cruise_des = $des;
				break;
			} */
			if($key == 0)$cruise_des = $des;
		}
		switch ($cruise_des) {
			case VIETNAM_CRUISE_DESTINATION:
				$cruise_location = 'Vietnam';
				$cruise_port_str = VIETNAM_CRUISES;
				break;
			case VIETNAM_CAMBODIA_CRUISE_DESTINATION:
				$cruise_location = 'Vietnam &amp; Cambodia';
				$cruise_port_str = VIETNAM_CAMBODIA_CRUISES;
				break;
			case LAOS_CRUISE_DESTINATION:
				$cruise_location = 'Laos';
				$cruise_port_str = LAOS_CRUISES;
				break;
			case THAILAND_CRUISE_DESTINATION:
				$cruise_location = 'Thailand';
				$cruise_port_str = THAILAND_CRUISES;
				break;
			case BURMA_CRUISE_DESTINATION:
				$cruise_location = 'Burma';
				$cruise_port_str = BURMA_CRUISES;
				break;
		}
		$budget = $cruise_location;
		$more_text = get_text_link_function('/'.$cruise_port_str, lang_arg('more_mekong_cruises', $cruise_location));
	}



	return array('budget' => $budget, 'more_text' => $more_text);
}

function get_text_link_function($href, $text, $tour = '') {
	// Halong Bay Cruise Tours
	if(!empty($tour)) {
		$CI = & get_instance();
		$CI->load->model('TourModel');

		$travel_style = $CI->TourModel->getTourTravelStype($tour['class_tours'], $tour['cruise_destination']);

		if(!empty($travel_style)) {
			$href = url_builder(MODULE_TOURS, $tour['des']['url_title'].'_'.$travel_style['name'] . '-' .MODULE_TOURS);
		}
	}

	$link = '<a class="link_function" href="'.$href.'">'.$text.'</a>';
	return $link;
}

function format_review_text($content) {
	$content = str_replace("\n", "<br>", $content);

	return $content;
}

function redirect_case_sensitive_url($module, $url_title, $is_html){

	$CI =& get_instance();

	$input_segment_url = '/'.$CI->uri->segment(1);

	if (!$is_html){
		$input_segment_url = $input_segment_url."/";
	}

	$url = url_builder($module, $url_title, $is_html);

	if ($input_segment_url != $url){

		$url = site_url($url);

		if (!$is_html){
			$url = $url. "/";
		}

		//$data['tour_canonical'] = '<link rel="canonical" href="'.$url.'"/>';
		redirect($url, 'location', 301);
	}
}

function redirect_case_insensitive_url($is_html = false){
	$url = $_SERVER['REQUEST_URI'];
	$pattern = '/([A-Z]+)/';

	if(preg_match($pattern, $url)) {
		$new_url = strtolower($url);
		if(!$is_html) {
			$new_url = $new_url. "/";
		}

		redirect($new_url, 'location', 301);
	}
}

function get_review_filter($review_rate_types, $customer_types, $c_t, $cus_t, $review_url='', $review_for) {
	if ($c_t == -1 && $cus_t == -1) return '';

	$text = '';
	foreach ($review_rate_types as $key => $value) {
		if ($c_t == $key) {
			if(trim($cus_t) == '-1') {
				$r_review_url = $review_url;
			} else {
				$r_review_url = $review_url . '-1_' .$cus_t;
			}

			$href = $r_review_url;
			if($review_for === CRUISE) {
				$href = url_builder(CRUISE_REVIEWS, $review_url, true).'/'.'-1_'.$cus_t.'"';
			} else if($review_for === HOTEL) {
				$href = site_url().'hotel_detail/hotel_review_ajax/'.$review_url.'/'.'-1_'.$cus_t.'"';
			}

			$text = ' <a href="' . $href .'" style="padding-right:20px;color:#333;font-weight:bold"><span class="btnFilter">';
			$text .=translate_text($value) .'<span style="margin: 2px 0 0 5px;*margin: 0;" class="icon icon-remove"/></span></a>';
		}
	}

	if($cus_t != '-1' && $cus_t != '') {
		foreach ($customer_types as $key => $value) {
			if ($cus_t == $key) {
				if(trim($c_t) == '-1') {
					$c_review_url = $review_url;
				} else {
					$c_review_url = $review_url . $c_t . '';
				}

				$href = $c_review_url;
				if($review_for === CRUISE) {
					$href = url_builder(CRUISE_REVIEWS, $review_url, true).'/'.$c_t.'_-1'.'"';
				} else if($review_for === HOTEL) {
					$href = site_url().'hotel_detail/hotel_review_ajax/'.$review_url.'/'.$c_t.'_-1'.'"';
				}

				$text .= ' <a href="' . $href .'" style="color:#333;font-weight:bold"><span class="btnFilter">';
				$text .= translate_text($value) . '<span style="margin: 2px 0 0 5px;*margin: 0;" class="icon icon-remove"/></span></a>';
			}
		}
	}


	return $text;
}

/*
 * Get static resources from cdn
*
* $file_names		: file name or array of file names
* $custom_folder	: specify folder path
*/
function get_static_resources($file_names, $custom_folder = '', $link_only = false) {

	$CI =& get_instance();

	$content = '';
	$file_type = 0;
	$CSS_FOLDER = '/css/';
	$JS_FOLDER = '/js/';

	$file_names = trim($file_names);

	// resource for desktop version
	$resource_path = $CI->config->item('resource_path');

	if(!$link_only) {
		// If specify folder path
		if(!empty($custom_folder)) {
			$CSS_FOLDER = $JS_FOLDER = $custom_folder;
		}

		// --- Check file types

		// CSS, JS
		if(stripos($file_names, '.css') !== false) {
			$file_type = 1;
		} else if(stripos($file_names, '.js') !== false) {
			$file_type = 2;
		}

		// --- Get content
		if($file_type == 1) {
			$files = explode(',', $file_names);

			foreach ($files as $file) {
				$file = trim($file);
				if(empty($file)) continue;

				$full_path = $resource_path.'/'.$CSS_FOLDER . $file;

				$full_path = '<link rel="stylesheet" type="text/css" href="'.$full_path.'"/>';

				$content .= $full_path;
			}
		}if($file_type == 2) {
			$files = explode(',', $file_names);

			foreach ($files as $file) {
				$file = trim($file);
				if(empty($file)) continue;

				$full_path = $resource_path.'/'.$JS_FOLDER . $file;

				$full_path =  '<script type="text/javascript" src="'.$full_path.'"></script>';

				$content .= $full_path;
			}
		}
	}

	if(empty($content))  {
		$content = $resource_path . $file_names;
	}

	// replace duplicate splash
	$content = str_replace("//", "/", $content);
	$content = str_replace("http:/", "http://", $content);

	return $content;


	/* $CI =& get_instance();
	$resource_path = $CI->config->item('resource_path');

	$full_path = $resource_path.$file_path;
	if($file_type == IS_CSS) {
		$full_path = '/css/'.$file_path; // $resource_path.

		// get last modified time
		//$hash = @GetRemoteLastModified($full_path);
		//if (!empty($hash)) $full_path .= '?'.$hash;

		$full_path = '<link rel="stylesheet" type="text/css" href="'.$full_path.'"/>';
	}if($file_type == IS_JAVASCRIPT) {
		$full_path = '/js/'.$file_path; //$resource_path.

		// get last modified time
		//$hash = @GetRemoteLastModified($full_path);
		//if (!empty($hash)) $full_path .= '?'.$hash;

		$full_path =  '<script src="'.$full_path.'"></script>';
	}

	// replace duplicate splash
	$full_path = str_replace("//", "/", $full_path);
	$full_path = str_replace("http:/", "http://", $full_path);

	return $full_path; */
}


function _getCurrentDateTime(){
	date_default_timezone_set("Asia/Saigon");

	return date('Y-m-d H:i:s', time());
}

function message($content = 'Go here!', $exit = true) {
	echo '<b style="margin-left:10px">'.$content.'</b>';
	if($exit) {
		exit();
	}
}

function is_private_tour($tour) {
	if(isset($tour['class_tours'])) {
		$class_tours = explode('-', $tour['class_tours']);
		foreach ($class_tours as $class) {
			if($class == PRIVATE_TOUR) return true;
		}
	}

	return false;
}

function replace_newline_in_description($description){
	$description = str_replace("\n\n", "\n", $description);
	$description = str_replace("\n", "<br>", $description);
	return $description;
}

function get_short_description($description){

	$description = replace_newline_in_description($description);

	$description = character_limiter($description ,SHORT_HOTEL_DESCRIPTION_CHR_LIMIT);

	return $description;
}


function get_tour_itinerary_photos($itinerary_photos, $tour = null)
{
    $itinerary_photos = explode(',', $itinerary_photos);

    $lst_photos = '';

    // Cruise Tour
    if (empty($tour) || ! empty($tour['cruise_id']))
    {
        if(count($itinerary_photos) == 1) {
            $photo = get_itinerary_photo_path($itinerary_photos[0], '220_165_path', true);
            if(!empty($photo)) {

                $medium_size_photo = get_itinerary_photo_path($itinerary_photos[0], 'medium_path', false);

                $lst_photos = '<ul style="float:right; list-style:none; width:220px;margin-left:10px;margin-bottom:10px"><li style="float:left">';

                $lst_photos = $lst_photos.'<div class="highslide-gallery">'.
                    '<a href="'. $medium_size_photo.'" rel="nofollow" class="highslide" onclick="return hs.expand(this);">'.
                    '<img style="border:0" src="'.$photo['path'].'" width="220" height="165" align="right"></a>'.
                    '<div class="highslide-caption">'.
                    '<center><b>'.$photo['caption'].'</b></center>'.
                    '</div>'.
                    '</div>'.
                    '</li>';

                //$lst_photos .= '<img src="'.$photo['path'].'" width="220" height="165" align="right"></li>';

                $lst_photos .= '<li style="text-align:center;width:100%;color:#666;clear:left; float:left">'.$photo['caption'].'</li></ul>';
            }

        } elseif(count($itinerary_photos) > 1) {
            $lst_photos = '<div style="max-width: 390px;float: right;">';
            foreach ($itinerary_photos as $photo) {
                $path = get_itinerary_photo_path($photo, 'small_path');
                if(!empty($path)) {

                    $medium_size_photo = get_itinerary_photo_path($photo, 'medium_path', true);

                    $lst_photos = $lst_photos.'<div class="highslide-gallery">'.
                        '<a href="'. $medium_size_photo['path'].'" rel="nofollow" class="highslide" onclick="return hs.expand(this);">'.
                        '<img src="'.$path.'" width="120" height="90" align="right" style="border:0;float:left;margin-left:10px;margin-top:10px">'.
                        '</a>'.
                        '<div class="highslide-caption">'.
                        '<center><b>'.$medium_size_photo['caption'].'</b></center>'.
                        '</div>'.
                        '</div>'.
                        '</li>';

                    //$lst_photos .= '<img src="'.$path.'" width="120" height="90" align="right" style="float:left;margin-left:10px">';
                }
            }
            $lst_photos .= '</div>';
        }
    }
    else
    {
        // Tour Packages
        if (! empty($itinerary_photos))
        {
            $lst_photos = '<ul class="itinerary-photos">';

            foreach ($itinerary_photos as $value)
            {
                $photo = get_itinerary_photo_path($value, 'medium_path', true);
                if (! empty($photo))
                {

                    $lst_photos = $lst_photos . '<li><div class="highslide-gallery">'
                        . '<a href="' . $photo['path'] . '" rel="nofollow" class="highslide" onclick="return hs.expand(this);">'
                            . '<img src="' . $photo['path'] . '"/>' . '</a>' . '<div class="highslide-caption">' . '<center><b>'
                                . $photo['caption'] . '</b></center>' . '</div>' . '</div>' . '</li>'
                                    . '<li class="photo-caption margin-bottom-10">' . $photo['caption'] . '</li>';
                }
            }

            $lst_photos .= '</ul>';
        }
    }

    return $lst_photos;
}

function get_itinerary_photo_path($pic_name, $config_path, $caption_on = FALSE) {
	$CI =& get_instance();
	$path = '';
	$caption = '';
	$patterns = array('cruise_', 'tour_', 'des_', 'activity_', 'hotel_');

	foreach ($patterns as $pattern) {
		if(stripos($pic_name, $pattern) !== false) {
			$pic_name = str_replace($pattern, '', $pic_name);

			$path .= $CI->config->item($pattern.$config_path).$pic_name;

			if($caption_on) {
				$caption = $CI->TourModel->get_photo_description($pattern, $pic_name);
				return array('path' => $path, 'caption' => $caption);
			} else {
				return $path;
			}

		}
	}

	return $path;
}

function getTourMeals($txtMeals) {
	if (!empty($txtMeals)) {
		$CI =& get_instance();
		$c_config = $CI->config->item('tour_meals');
		$str = '';
		$meals = explode(',', $txtMeals);
		foreach ($meals as $meal) {
			$str .= $c_config[$meal] . '/';
		}
		$str = substr($str, 0, strlen($str) - 1);
		return $str;
	}

	return '';
}

// Get list service details in form mail
function get_list_service_details($my_booking) {
	$service_details = array();
	foreach ($my_booking as $key=> $booking_item) {
		$is_existed = false;
		foreach ($service_details as $detail) {
			if($booking_item['reservation_type'] == $detail['reservation_type'] &&
					$booking_item['service_id'] == $detail['service_id']) {
				$is_existed = true;
			}
		}
		if(!$is_existed) {
			$service_details[] = $booking_item;
		}
	}

	return $service_details;
}

/**
 * Get difference between timestamps broken down into years/months/weeks/etc.
 * @return array
 * @param int $t1 UNIX timestamp
 * @param int $t2 UNIX timestamp
 */
function timeDiff($t1, $t2)
{
	if($t1 > $t2)
	{
		$time1 = $t2;
		$time2 = $t1;
	}
	else
	{
		$time1 = $t1;
		$time2 = $t2;
	}
	$diff = array(
			//'years' => 0,
			//'months' => 0,
			//'weeks' => 0,
			//'days' => 0,
			'hours' => 0,
			'minutes' => 0,
			'seconds' =>0
	);

	//foreach(array('years','months','weeks','days','hours','minutes','seconds') as $unit)
	foreach(array('hours','minutes','seconds') as $unit)
	{
		while(TRUE)
		{
			$next = strtotime("+1 $unit", $time1);
			if($next < $time2)
			{
				$time1 = $next;
				$diff[$unit]++;
			}
			else
			{
				break;
			}
		}
	}
	return($diff);
}

function createBookTogetherLink($name1,$name2) {
	$home = createHomeNavLink(false);

	return $home . ARROW_LINK . lang('label_book') .' '. $name1 .' + '. $name2;
}

function get_tour_travel_style_text($tours, $destinations_url_title, $style) {

	if(isset($tours[$style['style_name']])) {
		$destination_name =  str_replace('-', '_', $destinations_url_title);
		$en_style_name = str_replace(' ', '-', $style['en_style_name']);
	}

	$href = '#'.$destination_name.'_'.$en_style_name.'_Tours';

	$text = $style['style_name'];

	if(strtolower($destinations_url_title) == 'mekong-delta') {
		//$text = $style['style_name']. ' Mekong';
	} else {
	    $text = get_style_short_name($text, FALSE);
	}

	return array('href' => $href, 'text' => $text);
}


/* ------------------
 * Eliminates symnonym words in travel style url
 * ------------------
 */
function get_style_short_name($style_name, $is_url = TRUE, $lang_code = '') {

	$CI =& get_instance();

	if($lang_code ==''){
		$lang_code = lang_code();
	}

	$tour_symnonym = $CI->config->item('tour_symnonym_'.$lang_code);

	$check = false;
	foreach ($tour_symnonym as $word) {
		if(stripos($style_name, $word) !== false) {
			$check = true;
			break;
		}
	}
	$style_url = $style_name;
	if($is_url) {
		$style_url = str_replace(' ', '-', $style_name);

		if(!$check) {
			$style_url = $style_url . '-' .MODULE_TOURS;
		}
	} else {
		if(!$check) {
			$style_url = $style_url . ' '.ucfirst(lang('tours'));
		}
	}

	return $style_url;
}

function get_promotion_condition_text($hot_deal)
{
    $txt1 = lang('departure_date_in');
    $txt2 = lang('departure_date_from');

    if (isset($hot_deal['service_type']) && $hot_deal['service_type'] == HOTEL)
    {
        $txt1 = lang('arrival_in');
        $txt2 = lang('arrival_date_from');
    }

    if ($hot_deal['is_specific_dates'])
    {
        $travel_dates = str_replace("\n", "<br>", $hot_deal['travel_dates']);
        $travel_dates = str_replace("\r", "", $travel_dates);

        $content = '<span><b>' . $txt1 . ':&nbsp;</b> <span class="highlight">' . $travel_dates . '</span></span>';
    }
    else
    {
        $content = '<span><b>' . $txt2 . ':&nbsp;</b> <span class="highlight">' . date(DATE_FORMAT_DISPLAY, strtotime($hot_deal['start_date'])) . '</span></span>';
        $content = $content . ' <span><b>to</b> <span class="highlight">' . date(DATE_FORMAT_DISPLAY, strtotime($hot_deal['end_date'])) . '.</span></span>';

        if ($hot_deal['promotion_type'] == PROMOTION_TYPE_EARLY_BIRD)
        {
            $txt3 = lang_arg('book_over_before_depart', $hot_deal['day_before']);

            if (isset($hot_deal['service_type']) && $hot_deal['service_type'] == HOTEL)
            {
                $txt3 = lang_arg('book_over_before_arrival', $hot_deal['day_before']);
            }

            $content = $content . '<br><span class="highlight">' . $txt3 . '</span>';
        }

        if ($hot_deal['promotion_type'] == PROMOTION_TYPE_LAST_MINUTE)
        {

            // $content = $content. '<br><span class="highlight">Book within '.$hot_deal['day_before'].' days before '.$txt3.' to get this promotion</span>';
        }
    }

    $content = $content . '<p style="margin-top:5px; margin-bottom:0"><span class="price_total">Expired on:&nbsp;&nbsp;' . date(DATE_FORMAT_DISPLAY, strtotime($hot_deal['expiry_date'])) . '</span>';
	
    if (strpos($hot_deal["note"],'<p>') !== false) { //the promotion note contains <p> => already updated by new version
    	$condition = str_replace("\n", "", $hot_deal["note"]);
    	$condition = str_replace("\r", "", $condition);
    } else {
    	$condition = str_replace("\n", "<br>", $hot_deal["note"]);
    	$condition = str_replace("\r", "", $condition);
    }
   
    //$condition = str_replace("\n", "<br>", $hot_deal["note"]);
    //$condition = str_replace("\r", "", $condition);
    $condition = str_replace("'", "&#039", $condition);

    $content = $content . '<p style="margin-top:5px;margin-bottom:0">' . $condition;

    return $content;
}

function get_cruise_offer_content($hot_deals){

	if (count($hot_deals) == 1) return get_promotion_condition_text($hot_deals[0]);

	$content = '';

	foreach ($hot_deals as $key=>$value){

		$style = '';

		if ($key == 0){

			$style = 'style="padding-left: 0; padding-top: 0"';

		} else {
			$style = 'style="padding-left: 0;"';
		}

		$content = $content. '<h3 class="special" ' . $style. '><img alt="" src="/media/compare.gif" style="margin-bottom: -2px; margin-right:2px">'.htmlspecialchars($value['name'], ENT_QUOTES).'</h3><div style="margin-left:10px;">'.get_promotion_condition_text($value).'</div>';

	}

	return $content;
}

function anti_sql($sql) {

    $sql_injection = array('select','insert','delete','where','drop','drop table','show tables','#','*','--','\\');

    $sql = str_ireplace($sql_injection,'', $sql);

    return trim(strip_tags(addslashes($sql)));
}

function get_selected_menu($menu_id) {
	$CI =& get_instance();
	$current_menu = $CI->session->userdata('MENU');

	if($current_menu == $menu_id) {
		return 'class="selected"';
	}
}

function format_text_output($original_text) {
	$formated_text = htmlspecialchars($original_text, ENT_COMPAT);

	return $formated_text;
}

function set_scrore_type_by_review($review_id, $score_types, $scores){

	$my_scores = array();

	$ret = array();

	foreach ($scores as $value){

		if ($value['review_id'] == $review_id){

			$my_scores[] = $value;

		}

	}

	foreach ($score_types as $key=>$type){

		foreach ($my_scores as $score){

			if ($score['score_type'] == $key){

				$ret[$key] = $score['score'];
			}

		}

	}

	return get_display_score($score_types, $ret);
}

function get_display_score($score_types, $scores){

	$str = '<table>';

	foreach ($scores as $key=>$value){

		$str = $str.'<tr>';

		$str = $str. '<td>'.translate_text($score_types[$key]).':&nbsp;</td>';

		$str = $str. '<td><b>'.(int)$value.'</b>&nbsp;</td>';

		$str = $str. '</tr>';
	}

	$str = $str. '</table>';

	return $str;
}

function departure_shorten($str, $maxLength, $ch_explode = "|", $end_char = '&#8230;') {

	$out = "";
	foreach (explode($ch_explode, trim($str)) as $val)
	{
		$out .= $val." ".$ch_explode." ";

		$content_length = strlen($out);

		if ($content_length >= $maxLength)
		{
			$out = trim($out);
			//return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			return $out.$end_char;
		}
	}

	return $str;
}

function fit_content_shortening($str, $maxLength, $allow_tags = true) {
	$content_length = strlen($str);
	if($allow_tags) {
		$content_length = strlen(strip_tags($str));
	}

	// Hidden content length > maxLength/3
	if ($content_length < $maxLength)
	{
		return false;
	}

	if ($content_length > $maxLength && ($content_length - $maxLength) < round($maxLength/3))
	{
		return false;
	}

	return true;
}

function content_shorten($str, $maxLength, $allow_tags = true, $end_char = '&#8230;') {

	if(!fit_content_shortening($str, $maxLength, true)) {
		return $str;
	}

	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

	if (strlen($str) <= $maxLength)
	{
		return $str;
	}

	$out = "";
	foreach (explode(' ', trim($str)) as $val)
	{
		$out .= $val.' ';

		$content_length = strlen($out);
		if($allow_tags) {
			$content_length = strlen(strip_tags($out));
		}

		if ($content_length >= $maxLength)
		{
			$out = trim($out);
			return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
		}
	}

	return $str;
}

function get_accomodation_by_type($accommodations){

	$normal_cabins = array();

	$tripple_cabins = array();

	$family_cabins = array();

	foreach($accommodations as $value){

		if ($value['max_person'] <= 2){
			$normal_cabins[] = $value;

		} else if ($value['max_person'] == 3){
			$tripple_cabins[] = $value;

		} else if ($value['max_person'] > 3){
			$family_cabins[] = $value;
		}

	}

	$ret['normal_cabins'] = $normal_cabins;

	$ret['tripple_cabins'] = $tripple_cabins;

	$ret['family_cabins'] = $family_cabins;

	return $ret;
}


/**
 * Review functions
 */

function get_review_text($tour) {
	if ($tour['review_number'] == 0) {
		return lang('review_zero');
	}else if ($tour['review_number'] == 1){
		return '<a style="text-decoration: underline" href="' . url_builder(TOUR_DETAIL, $tour['url_title'] . '/Reviews', true) . '">' . $tour['review_number'] . ' '.lang('review').'</a>';
	} else {
		return '<a style="text-decoration: underline" href="' . url_builder(TOUR_DETAIL, $tour['url_title'] . '/Reviews', true) . '">' . $tour['review_number'] . ' '.lang('reviews').'</a>';
	}
}

/**
  *  get_full_review_text
  *
  *  @author toanlk
  *  @since  Oct 27, 2014
  */
function get_full_review_text($tour, $showLink = TRUE)
{
    $text_review = '';

    if (! empty($tour['review_number']))
    {
        $r_text = $tour['review_number'] <= 1 ? lang('review') : lang('reviews');

        $text_review = '<label class="highlight"><b>' . $tour['total_score'] . '</b></label> ' . lang('common_paging_of') . ' ';

        if ($showLink)
        {
            $text_review = $text_review . ' <i>' . get_review_text($tour) . '</i>';
        }
        else
        {
            $text_review = $text_review . $tour['review_number'] . ' ' . $r_text;
        }

        $text_review = $text_review . ' - <span class="review_text">' . review_score_lang($tour['total_score']) . '</span>';
    }

    return $text_review;
}

function get_full_hotel_review_text($hotel, $showLink = TRUE, $showRateText = true) {

	if ($hotel['review_number'] == 0) return '';

	$r_text = $hotel['review_number'] <= 1 ? ' '.lang('review') : ' '.lang('reviews');

	$text_review = "<label class='highlight'><b>".$hotel['total_score']."</b></label> of ";

	if($showLink) {

		$text_review = $text_review. '<i><a style="text-decoration:underline" href="' . url_builder(HOTEL_REVIEWS, $hotel['url_title'], true) . '">' . $hotel['review_number'] . $r_text.'</a></i>';

	} else {

		$text_review = $text_review. $hotel['review_number']. $r_text;

	}

	if($showRateText) {
		$text_review = $text_review . " - <span class='review_text'>".review_score_lang($hotel['total_score'])."</span>";
	}

	return $text_review;
}

function get_full_cruise_review_text($cruise, $showLink = TRUE){

	if ($cruise['num_reviews'] == 0) return '';

	$r_text = $cruise['num_reviews'] <= 1 ? lang('review') : lang('reviews');

	$text_review = "<label class='highlight'><b>".$cruise['review_score']."</b></label> of ";

	if($showLink) {

		$text_review = $text_review. '<i><a style="text-decoration:underline" href="' . url_builder(CRUISE_REVIEWS, $cruise['url_title'], true) . '">' . $cruise['num_reviews'] .' '. $r_text.'</a></i>';

	} else {

		$text_review = $text_review. $cruise['num_reviews'] . ' ' . $r_text;

	}

	$text_review = $text_review . " - <span class='review_text'><b>".review_score_lang($cruise['review_score'])."</b></span>";

	return $text_review;
}

function get_recommendation_text($recommendations){

	$text = '';

	if (count($recommendations) > 0){

		$rc = $recommendations[0];

		$name = $rc['name'];

		$save_up_to = 0;

		$dc_unit = '';

		foreach ($rc['services'] as $service){

			$discount_price_info = $service['discount_price_info'];

			if ($discount_price_info['discount_value'] > $save_up_to) {

				$save_up_to = $discount_price_info['discount_value'];

				$dc_unit = $discount_price_info['discount_unit'];
			}
		}

	    $txt_href = '<a style="font-size:16px" href="javascript:void(0)" onclick="go_book_together_position()">';

		if ($save_up_to > 0){

			$text = lang_arg('label_book_together_recommendation_save_up_to', $txt_href, $name).'<span class="text-special" style="font-size:18px"><b>'. CURRENCY_SYMBOL. number_format($save_up_to, CURRENCY_DECIMAL). $dc_unit .'</b></span>';

		} else {

			$text = lang_arg('label_book_together_recommendation', $txt_href, $name);

		}
	}

	return $text;
}

function get_excludes_text($includes, $excludes){

	$text = '';

	$includes = explode("\n", $includes);

	if (count($includes) > 0){

		$text = $text. '<div style="float: left; with: 290px;">';

		$text = $text. '<h3 class="highlight" style="padding:0;padding-bottom: 10px;">'.lang('price_included').':</h3>';

		$text = $text. '<ul style="list-style: disc; width: 290px; float: left">';

		foreach ($includes as $value){

			if (!empty($value)){

				$value = str_replace("'", "&#039", $value);

				$text = $text. '<li style="margin-bottom:5px; margin-left: 15px;">'.$value.'</li>';

			}
		}


		$text = $text. '</ul>';

		$text = $text. '</div>';
	}

	$excludes = explode("\n", $excludes);

	if (count($excludes) > 0){

		$text = $text. '<div style="float: left; with: 290px;">';

		$text = $text. '<h3 class="highlight" style="padding:0;padding-bottom: 10px;">'.lang('price_excluded').':</h3>';
		$text = $text. '<ul style="list-style: disc; width: 290px; float: left">';

		foreach ($excludes as $value){

			if (!empty($value)){

				$value = str_replace("'", "&#039", $value);

				$text = $text. '<li style="margin-bottom:5px; margin-left: 15px;">'.$value.'</li>';

			}
		}


		$text = $text. '</ul>';

		$text = $text. '</div>';
	}

	return $text;

}

function format_object_overview($str){

	return $str;

	$CI =& get_instance();

	$CI->load->library('simple_html_dom');

	$departure_date = date(DATE_FORMAT_STANDARD);

	$search_criteria = $CI->session->userdata("FE_tour_search_criteria");

	if (!empty($search_criteria)){


		if (!empty($search_criteria['departure_date'])){

			$departure_date = $search_criteria['departure_date'];
		}

	}


	$html = str_get_html($str);

	// replace destination overview
	$des_tags = $html->find('des');

	foreach ($des_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$des_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$des_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = 'see_destination_overview(\'\',\''. $departure_date. '\', \'' . url_title($des_name) .'\')';

		$tag->value = null;

	}


	// replace cruise overview
	$cruise_tags = $html->find('cruise');

	foreach ($cruise_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$cruise_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$cruise_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = 'see_cruise_overview(\'\',\''. $departure_date. '\', \'' . url_title($cruise_name) .'\')';

		$tag->value = null;

	}


	// replace hotel overview
	$hotel_tags = $html->find('hotel');

	foreach ($hotel_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$hotel_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$hotel_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = 'see_hotel_overview(\'\',\''. $departure_date. '\', \'' . url_title($hotel_name) .'\')';

		$tag->value = null;

	}


	// replace hotel overview
	$tour_tags = $html->find('tour');

	foreach ($tour_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$tour_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$tour_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = 'see_tour_overview(\'\',\''. $departure_date. '\', \'' . url_title($tour_name) .'\')';

		$tag->value = null;

	}

	// replace hotel overview
	$activity_tags = $html->find('act');

	foreach ($activity_tags as $tag){

		$inner_text = $tag->innertext;

		$tag_value = $tag->value;

		$act_name = $inner_text;

		if($tag_value != null && $tag_value != ''){

			$act_name = $tag_value;
		}

		$tag->href = 'javascript:void(0)';

		$tag->onclick = 'see_activity_overview(\'\',\'' . url_title($act_name) .'\', \''. $departure_date. '\')';

		$tag->value = null;

	}

	$str = strval($html);

	$str = str_replace('<des', '<a', $str);
	$str = str_replace('</des>', '</a>', $str);

	$str = str_replace('<cruise', '<a', $str);
	$str = str_replace('</cruise>', '</a>', $str);

	$str = str_replace('<hotel', '<a', $str);
	$str = str_replace('</hotel>', '</a>', $str);

	$str = str_replace('<tour', '<a', $str);
	$str = str_replace('</tour>', '</a>', $str);

	$str = str_replace('<act', '<a', $str);
	$str = str_replace('</act>', '</a>', $str);

	return $str;
}

function des_character_limiter($str, $n = 80, $end_char = '&#8230;')
{
	if (strlen($str) < $n)
	{
		return $str;
	}

	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

	if (strlen($str) <= $n)
	{
		return $str;
	}

	$out = "";
	foreach (explode('-', trim($str)) as $val)
	{
		$out .= $val.' - ';

		if (strlen($out) >= $n)
		{
			$out = trim($out);
			break;
		}
	}

	if(substr($out, -1) == '-') {
		$out = substr($out, 0, strlen($out) - 1);
	}

	return $out.$end_char;
}

function get_mobile_url($is_home = false){

	$CI =& get_instance();

	if ($is_home){

		$current_url = $CI->config->site_url();

	} else {
		$current_url = $CI->config->site_url($CI->uri->uri_string());
	}

	$is_base_url = false;

	if ($current_url == $CI->config->site_url()){
		if (substr($current_url, -1) == '/'){
			$current_url = substr($current_url, 0, -1);
			$is_base_url = true;
		}
	}

	$current_url = str_replace("//www.", "//m.", $current_url);

	if (strpos(".html", $current_url) === FALSE){

		if (!$is_base_url && substr($current_url, -1) != '/'){

			$current_url = $current_url.'/';

		}
	}

	return $current_url;
}

function is_show_mobile_link(){
	$is_smart_phone = false;
	if (isset($_COOKIE["is_smart_phone"])){
		$is_smart_phone = $_COOKIE["is_smart_phone"];
	}
	return $is_smart_phone;
}

function has_mobile_version_page(){

	$CI =& get_instance();

	$controller_name = $CI->router->fetch_class();

	if (in_array($controller_name, array('deals','partners','faqs','flights'))){
		return false;
	}

	return true;
}

function getAds($side_ads = false) {
	$CI =& get_instance();
	$CI->config->load('ads_meta');

	$ads_campaigns = $CI->config->item('ads_campaigns');

	// for side ads only
	if($side_ads) {
		// get random campaign
		$camp_index = rand(0, count($ads_campaigns) - 1);

		$cnt = 0;
		foreach ($ads_campaigns as $campaign) {

			if($cnt == $camp_index) {
				// get random image
				if(count($campaign['side_images']) > 1) {

					$img_index = rand(0, count($campaign['side_images']) - 1);
					$cnt2 = 0;

					foreach ($campaign['side_images'] as $image) {

						if($cnt2 == $img_index) {
							$campaign['pic'] = $campaign['side_images'][$img_index];
							break;
						}

						$cnt2++;
					}

				} else if(count($campaign['side_images']) == 1) {
					$campaign['pic'] = $campaign['side_images'][0];
				}

				if(!empty($campaign['pic'])) {
					$data['side_ads'] = $campaign;

					$side_ads_view = $CI->load->view('ads/side_ads', $data, TRUE);

					return $side_ads_view;
				}
				 return;
			}

			$cnt++;
		}
	}

	return $ads_campaigns;
}

function getCampaignValidTo($name) {

	$CI =& get_instance();
	$CI->config->load('ads_meta');

	$ads_campaigns = $CI->config->item('ads_campaigns');

	foreach ($ads_campaigns as $key => $campaign) {
		if($key == $name) {
			return $campaign['valid_until'];
		}
	}

	return '';
}

function is_free_visa($tour){

	if (check_prevent_promotion()) return false;

	if(!empty($tour['category_id'])){

		//if(strpos($tour['category_id'], "2") !== FALSE) return true;

	    // Apply for both halong and mekong cruises ( toanlk - 27/08/2014 )
	    if(strpos($tour['category_id'], "2") !== FALSE || strpos($tour['category_id'], "3") !== FALSE) return true;
	}

	if(isset($tour['cruise_destination'])){

	    //if($tour['cruise_destination'] == 0) return true;

	    // Apply for both halong and mekong cruises ( toanlk - 27/08/2014 )
		if($tour['cruise_destination'] == 0 || $tour['cruise_destination'] == 1) return true;

	}

	return false;

}

function get_promotion_sql_condition($departure_date){

	$str_cond = '';

	$today = date(DB_DATE_FORMAT, time());

	// calculate day-before-departure
	$today_time = strtotime($today);

    $departure_time = strtotime($departure_date);

    $day_before = $departure_time - $today_time;

    $day_before =  round($day_before/(60*60*24));


    $str_cond = "(p.book_to is NULL OR p.book_to >='" . $today . "')";

    $str_cond .= " AND p.start_date <='" . $departure_date . "'";

	$str_cond .= " AND (p.end_date is NULL OR p.end_date >='" . $departure_date . "')";

	$str_cond .= " AND (p.is_specific_dates = 0 OR EXISTS(SELECT 1 FROM promotion_dates as p_date WHERE p.id = p_date.promotion_id AND date = '".$departure_date."'))";


    $str_cond .= " AND (p.promotion_type = " . PROMOTION_TYPE_NORMAL . " OR (p.promotion_type = ".PROMOTION_TYPE_EARLY_BIRD." AND p.day_before <= ".$day_before.")".

    " OR (p.promotion_type = ".PROMOTION_TYPE_LAST_MINUTE." AND p.day_before >= ".$day_before."))";


	return $str_cond;
}

function get_promotion_sql_condition_4_hotel($arrival_date, $departure_date){

	$str_cond = '';

	$today = date(DB_DATE_FORMAT, time());

	// calculate day-before-departure
	$today_time = strtotime($today);

    $arrival_time = strtotime($arrival_date);

    $day_before = $arrival_time - $today_time;

    $day_before =  round($day_before/(60*60*24));


    $str_cond = "(p.book_to is NULL OR p.book_to >='" . $today . "')";

    $str_cond .= " AND p.start_date <='" . $departure_date . "'";

	$str_cond .= " AND (p.end_date is NULL OR p.end_date >='" . $arrival_date . "')";


    $str_cond .= " AND (p.promotion_type = " . PROMOTION_TYPE_NORMAL . " OR (p.promotion_type = ".PROMOTION_TYPE_EARLY_BIRD." AND p.day_before <= ".$day_before.")".

    " OR (p.promotion_type = ".PROMOTION_TYPE_LAST_MINUTE." AND p.day_before >= ".$day_before."))";


	return $str_cond;
}


/*
 * Check visa is sufficient for online payment
 *
 * - Normal processing
 * - Booking time + 3 days <= arrival date
 */
function is_allow_online_payment($arrival_date, $processing_type) {

	// set timezone
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	// Normal processing only
	$receive_date = get_visa_receive_date($processing_type, '', DATE_FORMAT_DISPLAY);
	if(strtotime($arrival_date) > strtotime($receive_date)) {
		return true;
	}

	return false;
}

/*
 * Promotion Campaign
 *
 * Type  : Free Visa or Voucher
 * Value : value of voucher (ex: 50USD)
 *
 */

function is_applied_promo_code() {

	$CI =& get_instance();
	if($CI->session->userdata(SESSION_PROMOTION_CAMPAIGN)) {
		return true;
	}

	return false;
}

function get_promo_code($is_message = false, $msg_lang = 'promo_code_applied') {
	$CI =& get_instance();

	if($CI->session->userdata(SESSION_PROMOTION_CAMPAIGN)) {

		$promo_code = $CI->session->userdata(SESSION_PROMOTION_CAMPAIGN);
		if($is_message) {

			if($promo_code['type'] == CAMPAIGN_FREE_VISA) {
				$arr_code = explode(',', $promo_code['code']);

				$msg = lang($msg_lang);
				$cnt = count($arr_code);
				if(count($arr_code) < 10) {
					$cnt = '0'.count($arr_code);
				}
				$msg = str_replace('%d', $cnt, $msg);
			} elseif($promo_code['type'] == CAMPAIGN_VOUCHER) {
				$msg = lang('promo_voucher');

				$msg = str_replace('%d', '$'.$promo_code['value'], $msg);
			}

			return $msg;
		} else {
			return $promo_code;
		}

	}

	return null;
}

function clear_promode_code() {
	$CI =& get_instance();
	if($CI->session->userdata(SESSION_PROMOTION_CAMPAIGN)) {

		$CI->session->unset_userdata(SESSION_PROMOTION_CAMPAIGN);
		return true;
	}

	return false;
}

function get_promo_type($promo_code) {

	// promotion code: not empty and length = 6
	if(!empty($promo_code) && strlen($promo_code) == 6) {
		$cp_type = CAMPAIGN_FREE_VISA;

		// check promotion code type
		$code_type = substr($promo_code, 0, 2);
		switch ($code_type) {
			case 'FB':
				$cp_type = CAMPAIGN_FREE_VISA;
				break;
			case 'VC':
				$cp_type = CAMPAIGN_VOUCHER;
				break;
		}

		return $cp_type;
	}

	return null;
}
/*
 * -- End Promotion Campaign
 */

function apply_canonical($data, $page_url) {

	$page_url = site_url($page_url);

	if (filter_var($page_url, FILTER_VALIDATE_URL) !== FALSE) {

		$link_canonical = '<link rel="canonical" href="'.$page_url;

		if(stripos($page_url, '.html') !== false) {
			$link_canonical .= '"/>';
		} else {
			$link_canonical .= '/"/>';
		}

		$data['tour_canonical'] = $link_canonical;
	}

	return $data;
}

/*
 * Log Action
 *
 * label: name of action
 * value: parameters (string or array)
 * msg:	message
 */
function log_action($label, $msg, $params = '') {

	$txt = '';

	if(!empty($params)) {
		$txt = $params;

		if(is_array($params)) {
			foreach ($params as $key => $val) {
				$txt .= $key.':'.$val.', ';
			}
		}
	}


	log_message('error', $label.' ==> '.$msg.' ==> Params {'.$txt.'}');
}

/**
  *  Show partner in tour
  *
  *  @author toanlk
  *  @since  Oct 22, 2014
  */
function by_partner($tour, $character_limit = null)
{
    $txt = '';
    // if the tour partner is BestPrice Vietnam => no show partner name
    if (isset($tour['partner_id']) && $tour['partner_id'] == PARTNER_BEST_PRICE_VIETNAM){
    	return $txt;
    }

    if (isset($tour['show_partner']) && $tour['show_partner'] == STATUS_ACTIVE) // modified by Khuyenpv on Feb 13 2015
    {

        $partner_name = $tour['partner_name'];

        if (! empty($character_limit))
        {
            $partner_name = character_limiter($partner_name, $character_limit, '');
        }

        $txt = '<span class="partner_name">' . lang('by') . ' ' . $partner_name . '</span>';
    }

    return $txt;
}

?>