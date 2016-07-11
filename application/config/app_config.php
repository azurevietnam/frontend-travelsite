<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Pagination config
|--------------------------------------------------------------------------
|
*/

$config['per_page'] = 10;
$config['num_links'] = 9;
$config['per_page_ajax'] = 5;
$config['partner_per_page'] = 20;

$config['paging_config_mobile'] = array(
    'per_page' => 10,
    'num_links' => 1
);

$config['resource_path'] = "http://yeahgo.xyz";

$config['cache_cruise_time'] = 0;//60 * 60 * 24;

$config['cache_hot_deal_time'] = 0;//60 * 60;

$config['cache_hour'] = 0;//60 * 60;

$config['cache_day'] = 0;//60 * 60 * 24;

$config['cache_week'] = 0;//60 * 60 * 24 * 7;

$config['cache_month'] = 0;//60 * 60 * 24 * 30;

$config['cache_html'] = 60 * 24;


/**
 * Hotel booking config
 */

$config['max_room'] = 5;
$config['max_hotel_best_deal'] = 5;


$config['top_hotel_number'] = 9;
$config['max_viewed_hotels'] = 7;
$config['max_viewed_tours'] = 7;
$config['max_viewed_cruises'] = 7;

$config['max_cabin'] = 6;
$config['max_service'] = 10;
$config['max_cruise_best_deal'] = 10;

$config['max_home_hot_deals'] = 3;

/**
 * Visa config
 */

$config['max_application'] = 10;

$config['visa_types'] = array(
		'1' => 'lang:1_month_single_entry',
		'2' => 'lang:3_months_single_entry',
		'3' => 'lang:1_month_multiple_entry',
		//'4' => 'lang:3_months_multiple_entry',
);

$config['airports'] = array(
		'1' => 'lang:hanoi_airport',
		'2' => 'lang:hcm_airport',
		'3' => 'lang:danang_airport',
);

$config['rush_services'] = array(
		'1' => 'lang:process_normal',
		'2' => 'lang:process_urgent',
);

$config['visa_stamp_fee'] = array(
		'1' => '45',
		'2' => '45',
		'3' => '65',
		'4' => '95',
);

/*
 * config for the number of date that the customer booking is grouped
 */
$config['customer_booking_nr_date'] = 7;

$config['recommendation_limit'] = 3;

$config['recommendation_limit_deal_offer'] = 3;

/**
 * ip trace link
 */
$config['ip_trace_country_code'] = array('VN');
$config['ip_trace_city'] = array('Hanoi');

$config['tour_prevent_promotion'] = array(

	'flag' => 1, // 1 : on, 0: off

	'tour_ids' => array(), // by country

	//'Hanoi' => array(221,222,105,97,208,214,242,83,152,198,199,197,92,32,213,446,85,86,87,88,89,90,497,342,341,360,351,343,218,454,262,263),
	'Hanoi' => array(119,120,516,517)
);

/**
 * No-show VAT tours
 */
$config['no_vat_tours'] = array(590, 591, 214, 208, 221, 222, 97,105, 730);

/*
 * Paradise Luxury & Paradise Peak: 221,222,105,97
 */

$config['deposit'] = 30; // 30%

$config['bank_fee'] = 3.5; // 3%

$config['usd_rate'] = 21000;// 1USD = 21,000 VND

$config['flight_ticket_fee'] = 6;// 5USD/ticket

$config['net_rate'] = 1.1; // net rate * 1.15 = selling rate

/*
|--------------------------------------------------------------------------
| Upload config
|--------------------------------------------------------------------------
|
*/
$config['des_origin_path'] = $config['resource_path'].'/images/destinations/origin/';
$config['des_small_path'] = $config['resource_path'].'/images/destinations/smalls/';
$config['des_medium_path'] = $config['resource_path'].'/images/destinations/mediums/';
$config['des_40_30_path'] = $config['resource_path'].'/images/destinations/40_30/';
$config['des_375_250_path'] = $config['resource_path'].'/images/destinations/375_250/';
$config['des_220_165_path'] = $config['resource_path'].'/images/destinations/220_165/';
$config['des_135_90_path'] = $config['resource_path'].'/images/destinations/135_90/';
$config['des_80_60_path'] = $config['resource_path'].'/images/destinations/80_60/';
$config['des_800_600_path'] = $config['resource_path'].'/images/destinations/800_600/';

$config['activity_origin_path'] = $config['resource_path'].'/images/activities/origin/';
$config['activity_small_path'] = $config['resource_path'].'/images/activities/smalls/';
$config['activity_medium_path'] = $config['resource_path'].'/images/activities/mediums/';
$config['activity_375_250_path'] = $config['resource_path'].'/images/activities/375_250/';
$config['activity_220_165_path'] = $config['resource_path'].'/images/activities/220_165/';
$config['activity_135_90_path'] = $config['resource_path'].'/images/activities/135_90/';
$config['activity_80_60_path'] = $config['resource_path'].'/images/activities/80_60/';
$config['activity_800_600_path'] = $config['resource_path'].'/images/activities/800_600/';

$config['hotel_origin_path'] = $config['resource_path'].'/images/hotels/origin/';
$config['hotel_medium_path'] = $config['resource_path'].'/images/hotels/mediums/';
$config['hotel_small_path'] = $config['resource_path'].'/images/hotels/smalls/';
$config['hotel_800_600_path'] = $config['resource_path'].'/images/hotels/800_600/';
$config['hotel_375_250_path'] = $config['resource_path'].'/images/hotels/375_250/';
$config['hotel_220_165_path'] = $config['resource_path'].'/images/hotels/220_165/';
$config['hotel_135_90_path'] = $config['resource_path'].'/images/hotels/135_90/';
$config['hotel_80_60_path'] = $config['resource_path'].'/images/hotels/80_60/';

$config['cruise_origin_path'] = $config['resource_path'].'/images/cruises/origin/';
$config['cruise_medium_path'] = $config['resource_path'].'/images/cruises/mediums/';
$config['cruise_small_path'] = $config['resource_path'].'/images/cruises/smalls/';
$config['cruise_800_600_path'] = $config['resource_path'].'/images/cruises/800_600/';
$config['cruise_375_250_path'] = $config['resource_path'].'/images/cruises/375_250/';
$config['cruise_220_165_path'] = $config['resource_path'].'/images/cruises/220_165/';
$config['cruise_135_90_path'] = $config['resource_path'].'/images/cruises/135_90/';
$config['cruise_80_60_path'] = $config['resource_path'].'/images/cruises/80_60/';

$config['tour_upload_path'] = $config['resource_path'].'/images/tours/';
$config['tour_origin_path'] = $config['resource_path'].'/images/tours/origin/';
$config['tour_medium_path'] = $config['resource_path'].'/images/tours/mediums/';
$config['tour_small_path'] = $config['resource_path'].'/images/tours/smalls/';
$config['tour_375_250_path'] = $config['resource_path'].'/images/tours/375_250/';
$config['tour_220_165_path'] = $config['resource_path'].'/images/tours/220_165/';
$config['tour_135_90_path'] = $config['resource_path'].'/images/tours/135_90/';
$config['tour_80_60_path'] = $config['resource_path'].'/images/tours/80_60/';
$config['tour_800_600_path'] = $config['resource_path'].'/images/tours/800_600/';

$config['partner_logo_path'] = $config['resource_path'].'/images/partner/';

$config['cruise_file_resource_path'] = '/resources/cruises/';
$config['visa_file_resource_path'] = '/resources/visa/';

$config['faq_path'] = '/images/faqs/';

$config['invoice_path'] = '/invoice/';

/*
|--------------------------------------------------------------------------
| Enumeration data config
|--------------------------------------------------------------------------
|
*/
// Duration
$config['duration_search']  = array(
	1 => '1day',
	2 => '2days',
	3 => '3days',
	4 => '4-7days',
	5 => 'over7days',
);

// Tour Budget
$config['tour_budgets']  = array(
	1=>'lbl_luxury',
	2=>'lbl_mid_range',
	3=>'lbl_budget',
);
// Tour Types
$config['tour_travel_styles']  = array(
	1=>'lbl_land_tour',
	2=>'lbl_cruise_tour',
);

// Tour Group Type: private or Small Group Tour
$config['tour_group_types']  = array(
	1=>'group_type_private',
	2=>'group_type_group',
);

// Destination
$config['destination_regions']  = array(
	1 => 'des_north',
	2 => 'des_middle',
	3 => 'des_south'
);

$config['destination_types']  = array(
	DES_SYSTEM => 'lang:System',
	DES_USER => 'lang:User'
);

// Tour
$config['class_tours']  = array(
	3 => 'class_tour_luxury',
	2 => 'class_tour_deluxe',
	1 => 'class_tour_standard',
);
$config['class_services']  = array(
	1 => 'class_service_standard',
	2 => 'class_service_superior',
	3 => 'class_service_deluxe',
	4 => 'class_service_suite',
	5 => 'class_service_premium',
);
$config['tour_status']  = array(
	1 => 'tour_status_active',
	0 => 'tour_status_inactive',
);

$config['tour_group_sizes']  = array(
	1  => 'tour_price_1pax',
	2  => 'tour_price_2pax',
	3  => 'tour_price_3pax',
	4  => 'tour_price_4pax',
	5  => 'tour_price_5pax',
	6  => 'tour_price_6pax',
	7  => 'tour_price_7pax',
	8  => 'tour_price_8pax',
	9  => 'tour_price_9pax',
	10 => 'tour_price_10pax',
	0  => 'tour_price_singlesup',
);

$config['tour_activation_error']  = array(
	1 => 'tour_activation_notfound',
	2 => 'tour_activation_price',
	3 => 'tour_activation_accomm',
);

/*
|--------------------------------------------------------------------------
| Promotion config
|--------------------------------------------------------------------------
|
*/
$config['pro_status']  = array(
	1 => 'pro_status_active',
	0 => 'pro_status_inactive',
);
$config['title'] = array(
	1 => 'Mr',
	2 => 'Ms',
);
/*
|--------------------------------------------------------------------------
| Popup config
|--------------------------------------------------------------------------
|
*/
$config['popup'] = array(
	'default' => array(
		'width'      => '650',
		'height'     => '400',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '50',
		'screeny'    => '80'
	),
	'tour_price' => array(
		'width'      => '750',
		'height'     => '400',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '50',
		'screeny'    => '80'
	)
);
/*
|--------------------------------------------------------------------------
| Order tours config
|--------------------------------------------------------------------------
|
*/
$config['tour_orders'] = array(
	0 => 'bestdeals',
	1 => 'reviewscore',
	2 => 'price_from_low_high',
	3 => 'price_from_high_low',
	4 => 'travel_company_a_z',
	5 => 'travel_company_z_a',
);
$config['comparison_orders'] = array(
	0 => 'bestselling',
	1 => 'offer_rate',
	2 => 'price_low_high',
	3 => 'price_high_low',
	4 => 'travel_company_a_z',
	5 => 'travel_company_z_a',
);

$config['booking_rules'] = array(
	'title' => array (
	    'field'		=> 'title',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'full_name' => array (
	    'field'		=> 'full_name',
	    'label' 	=> 'lang:full_name',
	    'rules'		=> 'required|xss_clean',
	),
	'email' 	=> array (
	    'field'		=> 'email',
	    'label' 	=> 'lang:email_address',
	    'rules'		=> 'required|valid_email',
	),
	'email_cf' 	=> array (
	    'field'		=> 'email_cf',
	    'label' 	=> 'lang:email_address_confirm',
	    'rules'		=> 'required|valid_email|matches[email]',
	),
	'phone' 	=> array (
	    'field'		=> 'phone',
	    'label' 	=> 'lang:phone_number',
	    'rules'		=> 'required|xss_clean',
	),
	'fax' 	=> array (
	    'field'		=> 'fax',
	    'label' 	=> 'lang:fax_number',
	    'rules'		=> 'xss_clean',
	),
	'country' 	=> array (
	    'field'		=> 'country',
	    'label' 	=> 'lang:country',
	    'rules'		=> 'required',
	),
	'city' 	=> array (
	    'field'		=> 'city',
	    'label' 	=> 'lang:city',
	    'rules'		=> 'xss_clean',
	),
	'special_requests' 	=> array (
	    'field'		=> 'special_requests',
	    'label' 	=> 'lang:special_requests',
	    'rules'		=> 'max_length[1000]|xss_clean',
	),
	'class_service' 	=> array (
	    'field'		=> 'class_service',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'adults' 	=> array (
	    'field'		=> 'adults',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'children' 	=> array (
	    'field'		=> 'children',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'infants' 	=> array (
	    'field'		=> 'infants',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'departure_date' 	=> array (
	    'field'		=> 'departure_date',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'single_sup' 	=> array (
	    'field'		=> 'single_sup',
	    'label' 	=> '',
	    'rules'		=> '',
	),
);
$config['contact_rules'] = array(
	'title' => array (
	    'field'		=> 'title',
	    'label' 	=> '',
	    'rules'		=> '',
	),
	'full_name' => array (
	    'field'		=> 'full_name',
	    'label' 	=> 'lang:full_name',
	    'rules'		=> 'required|xss_clean',
	),
	'email' 	=> array (
	    'field'		=> 'email',
	    'label' 	=> 'lang:email_address',
	    'rules'		=> 'required|valid_email',
	),
	'email_cf' 	=> array (
	    'field'		=> 'email_cf',
	    'label' 	=> 'lang:email_address_confirm',
	    'rules'		=> 'required|valid_email|matches[email]',
	),
	'phone' 	=> array (
	    'field'		=> 'phone',
	    'label' 	=> 'lang:phone_number',
	    'rules'		=> 'required|xss_clean',
	),
	'fax' 	=> array (
	    'field'		=> 'fax',
	    'label' 	=> 'lang:fax_number',
	    'rules'		=> 'xss_clean',
	),
	'country' 	=> array (
	    'field'		=> 'country',
	    'label' 	=> 'lang:country',
	    'rules'		=> 'required',
	),
	'city' 	=> array (
	    'field'		=> 'city',
	    'label' 	=> 'lang:city',
	    'rules'		=> 'xss_clean',
	),
	'subject' 	=> array (
	    'field'		=> 'subject',
	    'label' 	=> 'lang:subject',
	    'rules'		=> 'xss_clean',
	),

	'adults' 	=> array (
	    'field'		=> 'adults',
	    'label' 	=> 'lang:adults',
	    'rules'		=> '',
	),

	'children' 	=> array (
	    'field'		=> 'children',
	    'label' 	=> 'lang:children',
	    'rules'		=> '',
	),

	'infants' 	=> array (
	    'field'		=> 'infants',
	    'label' 	=> 'lang:infants',
	    'rules'		=> '',
	),

	'destination_visit' 	=> array (
	    'field'		=> 'destination_visit',
	    'label' 	=> 'Destination Visit',
	    'rules'		=> '',
	),

	'message' 	=> array (
	    'field'		=> 'message',
	    'label' 	=> 'lang:message',
	    'rules'		=> 'required|max_length[1000]|xss_clean',
	),
);
$config['continents'] = array(
    'AS' => 'Asia',
    'EU' => 'Europe',
    'NA' => 'North America',
    'SA' => 'South America',
    'OC' => 'Oceania',
    'AF' => 'Africa',
);
$config['countries'] = array(
	'ar' => array('Argentina','NA'),
	'au' => array('Australia','OC'),
	'at' => array('Austria','EU'),
	'bd' => array('Bangladesh','AS'),
	'by' => array('Belarus','EU'),
	'be' => array('Belgium','EU'),
	'bt' => array('Bhutan','AS'),
	'bo' => array('Bolivia','SA'),
	'ba' => array('Bosnia and Herzegovina','EU'),
	'br' => array('Brazil','SA'),
	'bn' => array('Brunei','AS'),
	'bg' => array('Bulgaria','EU'),
	'kh' => array('Cambodia','AS'),
	'cm' => array('Cameroon','AF'),
	'ca' => array('Canada','NA'),
	'cl' => array('Chile','SA'),
	'cn' => array('China','AS'),
	'co' => array('Colombia','SA'),
	'cr' => array('Costa Rica','NA'),
	'hr' => array('Croatia','EU'),
	'cu' => array('Cuba','NA'),
	'cy' => array('Cyprus','AS'),
	'cz' => array('Czech Republic','EU'),
	'dk' => array('Denmark','EU'),
	'dm' => array('Dominica','NA'),
	'tl' => array('East Timor','AS'),
	'ec' => array('Ecuador','SA'),
	'eg' => array('Egypt','EU'),
	'sv' => array('El Salvador','NA'),
	'ee' => array('Estonia','EU'),
	'fo' => array('Faroe Islands','EU'),
	'fj' => array('Fiji','OC'),
	'fi' => array('Finland','EU'),
	'fr' => array('France','EU'),
	'de' => array('Germany','EU'),
	'gi' => array('Gibraltar','EU'),
	'gr' => array('Greece','EU'),
	'gl' => array('Greenland','NA'),
	'gu' => array('Guam','OC'),
	'gt' => array('Guatemala','NA'),
	'hn' => array('Honduras','NA'),
	'hk' => array('Hong Kong','AS'),
	'hu' => array('Hungary','EU'),
	'is' => array('Iceland','EU'),
	'in' => array('India','AS'),
	'id' => array('Indonesia','AS'),
	'ie' => array('Ireland','EU'),
	'il' => array('Israel','AS'),
	'it' => array('Italy','EU'),
	'jm' => array('Jamaica','NA'),
	'jp' => array('Japan','AS'),
	'kz' => array('Kazakhstan','AS'),
	'ki' => array('Kiribati','OC'),
	'kp' => array('Korea, North','AS'),
	'kr' => array('Korea, South','AS'),
	'kw' => array('Kuwait','AS'),
	'la' => array('Laos','AS'),
	'lv' => array('Latvia','EU'),
	'lr' => array('Liberia','AF'),
	'ly' => array('Libya','AF'),
	'li' => array('Liechtenstein','EU'),
	'lt' => array('Lithuania','EU'),
	'lu' => array('Luxembourg','EU'),
	'mo' => array('Macau','AS'),
	'mk' => array('Macedonia','EU'),
	'my' => array('Malaysia','AS'),
	'mv' => array('Maldives','AS'),
	'ml' => array('Mali','AF'),
	'mt' => array('Malta','EU'),
	'mh' => array('Marshall Islands','OC'),
	'mx' => array('Mexico','NA'),
	'fm' => array('Micronesia','OC'),
	'md' => array('Moldova','EU'),
	'mc' => array('Monaco','AS'),
	'mn' => array('Mongolia','AS'),
	'ms' => array('Montserrat','NA'),
	'mm' => array('Myanmar','AS'),
	'nr' => array('Nauru','OC'),
	'np' => array('Nepal','AS'),
	'nl' => array('Netherlands','EU'),
	'an' => array('Netherlands Antilles','EU'),
	'nc' => array('New Caledonia','OC'),
	'nz' => array('New Zealand','OC'),
	'ng' => array('Nigeria','AF'),
	'nu' => array('Niue','OC'),
	'nf' => array('Norfolk Island','OC'),
	'mp' => array('Northern Mariana Islands','OC'),
	'no' => array('Norway','EU'),
	'om' => array('Oman','AS'),
	'pk' => array('Pakistan','AS'),
	'pw' => array('Palau','OC'),
	'pa' => array('Panama','NA'),
	'pg' => array('Papua New Guinea','OC'),
	'py' => array('Paraguay','SA'),
	'pe' => array('Peru','SA'),
	'ph' => array('Philippines','AS'),
	'pn' => array('Pitcairn Island','OC'),
	'pl' => array('Poland','EU'),
	'pt' => array('Portugal','EU'),
	'pr' => array('Puerto Rico','NA'),
	'qa' => array('Qatar','AS'),
	're' => array('Reunion','AF'),
	'ro' => array('Romania','EU'),
	'ru' => array('Russia','EU'),
	'rw' => array('Rwanda','AF'),
	'kn' => array('Saint Kitts & Nevis','NA'),
	'lc' => array('Saint Lucia','NA'),
	'vc' => array('Saint Vincent','NA'),
	'ws' => array('Samoa','OC'),
	'sm' => array('San Marino','EU'),
	'st' => array('Sao Tome','AF'),
	'sa' => array('Saudi Arabia','AS'),
	'sn' => array('Senegal','AF'),
	'sg' => array('Singapore','AS'),
	'sk' => array('Slovakia','EU'),
	'si' => array('Slovenia','EU'),
	'za' => array('South Africa','AF'),
	'es' => array('Spain','EU'),
	'lk' => array('Sri Lanka','AS'),
	'sr' => array('Suriname','SA'),
	'sj' => array('Svalbard','EU'),
	'se' => array('Sweden','EU'),
	'ch' => array('Switzerland','EU'),
	'sy' => array('Syria','AS'),
	'tw' => array('Taiwan','AS'),
	'tj' => array('Tajikistan','AS'),
	'th' => array('Thailand','AS'),
	'tk' => array('Tokelau','OC'),
	'to' => array('Tonga','OC'),
	'tt' => array('Trinidad','NA'),
	'tr' => array('Turkey','EU'),
	'tm' => array('Turkmenistan','AS'),
	'tc' => array('Turks and Caicos','NA'),
	'tv' => array('Tuvalu','OC'),
	'ug' => array('Uganda','AF'),
	'ua' => array('Ukraine','EU'),
	'ae' => array('United Arab Emirates','AS'),
	'uk' => array('United Kingdom','EU'),
	'us' => array('United States','NA'),
	'uy' => array('Uruguay','SA'),
	'uz' => array('Uzbekistan','AS'),
	'va' => array('Vatican City','EU'),
	've' => array('Venezuela','SA'),
	'vn' => array('Vietnam','AS'),
	'ot' => array('Other Country', 'AS')
);


// for customer reviews

$config['customer_types']  = array(
	0 => 'lang:rev_mature_couples',
	1 => 'lang:rev_solo_travellers',
	2 => 'lang:rev_familly_young_children',
	3 => 'lang:rev_group_of_friend',
	4 => 'lang:rev_young_couples',
);

$config['review_rate_types'] = array(
		6 => 'lang:review_rate_excellent',
		5 => 'lang:review_rate_very_good',
		4 => 'lang:review_rate_good',
		3 => 'lang:review_rate_average',
		2 => 'lang:review_rate_poor',
		1 => 'lang:review_rate_terrible',
);

$config['score_types']  = array(
	TOUR => array(TYPE_ITINERARY => 'lang:rev_itinerary',
				  TYPE_DINING_FOOD => 'lang:rev_dining_food',
				  TYPE_STAFF_QUALITY => 'lang:rev_staff_quality',
				  TYPE_ENTERTAIMENT_ACTIVITY => 'lang:rev_entertainment_activity',
				 ),

	HOTEL => array(TYPE_CLEAN => 'lang:rev_clean',
				  TYPE_COMFORT => 'lang:rev_comfort',
				  TYPE_LOCATION => 'lang:rev_location',
				  TYPE_SERVICES => 'lang:rev_services',
				  TYPE_STAFF => 'lang:rev_staff',
				  //TYPE_VALUE_MONEY => 'lang:rev_value_money',
				 ),

	CRUISE => array(TYPE_CRUISE_QUALITY => 'lang:rev_cruise_quality',
				  TYPE_DINING_FOOD => 'lang:rev_dining_food',
				  TYPE_CABIN_QUALITY => 'lang:rev_cabin_quality',
				  TYPE_STAFF_QUALITY => 'lang:rev_staff_quality',
				  TYPE_ENTERTAIMENT_ACTIVITY => 'lang:rev_entertainment_activity',
				 ),

	FLIGHT => array(TYPE_COMFORT => 'lang:rev_comfort',
				  TYPE_SERVICES => 'lang:rev_services',
				  TYPE_STAFF => 'lang:rev_staff',
				  TYPE_VALUE_MONEY => 'lang:rev_value_money',
				 ),

	CAR => array(TYPE_COMFORT => 'lang:rev_comfort',
				  TYPE_SERVICES => 'lang:rev_services',
				  TYPE_STAFF => 'lang:rev_staff',
				  TYPE_VALUE_MONEY => 'lang:rev_value_money',
				 ),
);


$config['unit_types']  = array(
		1 => 'lang:unit_pax',
		2 => 'lang:unit_group',
		3 => 'lang:unit_room_night'
);

$config['cabin_types'] = array(
		1 => 'lang:double',
		2 => 'lang:twin',
		3 => 'lang:single',
);

$config['lunar_new_year']  = array(
		2012 => '23-01',
		2013 => '9-02',
		2014 => '30-01',
		2015 => '18-02',
		2016 => '07-02',
		2017 => '27-01',
		2018 => '15-02',
		2019 => '04-02',
		2020 => '24-01',
		2021 => '11-02',
		2022 => '31-01',
);

$config['public_holidays'] = array(
	1 => '01-01',	// New Year
	2 => array( // Hung Kings Commemoriations : 10-03 lunar calendar
			2014 => '09-04',
			2015 => '28-04',
			2016 => '16-04',
			2017 => '06-04',
			2018 => '25-04',
			2019 => '14-04',
			2020 => '02-04',
			2021 => '21-04',
			2022 => '10-04',
		),
	3 => '30-04',	// Reunification Day
	4 => '01-05',	// International Worker's Day
	5 => '02-09',	// National Day
);

$config['visa_day_off'] = array(
	'28-04-2015',
	'29-04-2015',
	'30-04-2015',
	'01-05-2015',
    '02-05-2015',
    '03-05-2015',
);

$config['popup'] = array(
	'extra_detail' => array(
		'width'      => '760',
		'height'     => '800',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'no',
		'screenx'    => '300',
		'screeny'    => '80',
		'toolbar' 	 => 'no',
		'menubar'    => 'no',
		'location'   => 'no',
		'dialog'	 => 'no'
	),
	'full_detail' => array(
		'width'      => '1024',
		'height'     => '768',
		'scrollbars' => 'yes',
		'status'     => 'yes',
		'resizable'  => 'yes',
		'screenx'    => '0',
		'screeny'    => '0',
		'toolbar' 	 => 'yes',
		'menubar'    => 'yes',
		'location'   => 'yes'
	)
);

$config['partner_types'] = array(
		1 => 'lang:partner_cruise',
		2 => 'lang:partner_tour',
		3 => 'lang:partner_hotel',
		4 => 'lang:partner_transfer',
		5 => 'lang:partner_visa',
);

$config['tour_meals']  = array(
		1=>'Breakfast',
		2=>'Lunch',
		6=>'Brunch',
		3=>'Picnic Lunch',
		4=>'Dinner',
		5=>'NA',
);

$config['tour_itinerary_type']  = array(
		1=>'default',
		2=>'h1',
		3=>'h2',
);

// Add language support 25/03/2015 - toanlk
$config['tour_meal_options']  = array(
    1=>'lbl_breakfast',
    2=>'lbl_lunch',
    6=>'lbl_brunch',
    3=>'lbl_picnic_lunch',
    4=>'lbl_dinner',
    5=>'lbl_na',
);

/**
 *
 * Special discount package:
 * Paradise Luxury (2 days & 3 days) with Sofitel Metropole HN, Mecure, Intercontinental WL
 * Paradise Peak (2 days & 3 days) with Sofitel Metropole HN, Intercontinental WL
 * NOW DON'T NEED IT
 */
$config['booking_packages'] = array(
	105=> array(157=>60, 244=>52,242=>10),
	97=> array(157=>60, 244=>52,242=>10),
	221=> array(157=>60, 244=>52),
	222=> array(157=>60, 244=>52)
);

/**
 *
 * Indochina Destinations
 * Vietnam, Cambodia, Laos destination id
 */
$config['indochina_destinations_flag'] = array(
		235 => 'icon-flag-vietnam' ,
		306 => 'icon-flag-lao',
		234 => 'icon-flag-cambodia',
		420 => 'icon-flag-myanmar'
);

$config['indochina_destinations_name'] = array(
        235 => 'Vietnam' ,
        306 => 'Laos',
        234 => 'Cambodia',
        420 => 'Myanmar'
);

$config['indochina_id'] = 408;

$config['applicant_rules'] = array(
		'arrival_day' 	=> array (
				'field'		=> 'arrival_day',
				'label' 	=> 'Day Of Arrival',
				'rules'		=> '',
		),
		'arrival_month' 	=> array (
				'field'		=> 'arrival_month',
				'label' 	=> 'Month Of Arrival',
				'rules'		=> '',
		),
		'arrival_year' 	=> array (
				'field'		=> 'arrival_year',
				'label' 	=> 'Year Of Arrival',
				'rules'		=> '',
		),
		'arrival_date' 	=> array (
				'field'		=> 'arrival_date',
				'label' 	=> 'Arrival Date',
				'rules'		=> 'required|callback_is_valid_date',
		),
		'exit_day' 	=> array (
				'field'		=> 'exit_day',
				'label' 	=> 'Day Of Exit',
				'rules'		=> '',
		),
		'exit_month' 	=> array (
				'field'		=> 'exit_month',
				'label' 	=> 'Month Of Exit',
				'rules'		=> '',
		),
		'exit_year' 	=> array (
				'field'		=> 'exit_year',
				'label' 	=> 'Year Of Exit',
				'rules'		=> '',
		),
		'exit_date' 	=> array (
				'field'		=> 'exit_date',
				'label' 	=> 'Exit Date',
				'rules'		=> 'required|callback_compare_subm_dates',
		),
		'arrival_airport' 	=> array (
				'field'		=> 'arrival_airport',
				'label' 	=> 'Arrival Airport',
				'rules'		=> 'required',
		),
		'flight_number' 	=> array (
				'field'		=> 'flight_number',
				'label' 	=> 'Flight Number',
				'rules'		=> '',
		),
);

$config['step_labels'] = array(
    1 => 'step_1',
    2 => 'extra_services',
    3 => 'label_my_booking',
    4 => 'step_3'

);

$config['visa_step_labels'] = array(
    1 => 'apply_visa_progress_1',
    2 => 'apply_visa_progress_2',
    3 => 'apply_visa_progress_3',
);

$config['week_days'] = array(
		1 => 'mon',
		2 => 'tue',
		3 => 'wed',
		4 => 'thu',
		5 => 'fri',
		6 => 'sat',
		0 => 'sun'
);



