<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['flight_data_url'] = "http://flightbooking.bestpricevn.com/Misc.aspx";

$config['flight_vnisc_iframe_url'] = "http://flightbooking.bestpricevn.com/Booking_Redirect.aspx";


$config['flight_booking_url'] = "";

$config['sid_curl_options'] = array(
	CURLOPT_RETURNTRANSFER => true,         // return web page
   	CURLOPT_HEADER         => true,        // don't return headers
    CURLOPT_FOLLOWLOCATION => true,         // follow redirects
    CURLOPT_ENCODING       => "",           // handle all encodings
    CURLOPT_USERAGENT      => "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",     // who am i
    CURLOPT_AUTOREFERER    => true,         // set referer on redirect
    CURLOPT_CONNECTTIMEOUT => 20,          // timeout on connect - 20s
    CURLOPT_TIMEOUT        => 30,          // timeout on response - 30s
    CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
    CURLOPT_POST            => true,            // i am sending post data
    CURLOPT_POSTFIELDS     => array(),    // this are my post vars
 	CURLOPT_DNS_CACHE_TIMEOUT => 300, 	  // default 120 seconds
 	CURLOPT_MAXCONNECTS => 50,				// maximum persistent connections
 	CURLOPT_COOKIE	=> '',
);

$config['flight_data_curl_options'] = array(
	CURLOPT_RETURNTRANSFER => true,         // return web page
   	CURLOPT_HEADER         => false,        // don't return headers
    CURLOPT_FOLLOWLOCATION => false,         // follow redirects
    CURLOPT_ENCODING       => "",           // handle all encodings
    CURLOPT_USERAGENT      => "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)",     // who am i
    CURLOPT_CONNECTTIMEOUT => 300,          // timeout on connect - 5 minutes
    CURLOPT_TIMEOUT        => 600,          // timeout on response - 10 minutes
    CURLOPT_POST            => true,            // i am sending post data
    CURLOPT_POSTFIELDS     => array(),    // this are my post vars
 	CURLOPT_DNS_CACHE_TIMEOUT => 300, 	  // default 120 seconds
 	CURLOPT_MAXCONNECTS => 50,				// maximum persistent connections
 	CURLOPT_COOKIE	=> 'vniscLang=en',
);

$config['departure_times'] = array(
	1 => lang('flight_fitler_morning'),
	2 => lang('flight_filter_afternoon'),
	3 => lang('flight_filter_evening'),
	4 => lang('flight_filter_night')
);


$config['valid_airline_codes'] = array('VN'=>'Vietnam Airlines','VJ'=>'Vietjet Air','BL' => 'Jestar');

$config['domistic_airlines'] = array('VN'=>'Vietnam Airlines','VJ'=>'Vietjet Air','BL' => 'Jestar');

$config['limit_hold_seats'] = array('VJ'=>32,'BL'=>32,'VN'=>32); // add more 12 hours for processing

$config['limit_hold_seats_inter'] = 48;// 2 days for international flights

$config['flight_data_timeout'] = 60 * 15; // time-out 15 miute from passenger detail page to payment page

$config['flight_search_timeout'] = 60; // time-out search flight data 60s

$config['flight_search_timeout_inter'] = 90; // time-out search flight data 90s for flight international

$config['sort_by'] = array(

		'price' => array(
				'label' => lang('sort_by_prices'),
				'value' => 'price',
				'selected' => true
		),

		'airline' => array(
				'label' => lang('sort_by_airlines'),
				'value' => 'airline',
				'selected' => false
		),

		'departure' => array(
				'label' => lang('sort_by_departure'),
				'value' => 'departure',
				'selected' => false
		),
);

$config['flight_ticket_fee'] = 6; // 6 USD

$config['urgent_flight_ticket_fee'] = 8; // 8USD for urgent booking

$config['flight_ticket_fee_inter'] = 8; // Fee for Internaltional flight

$config['urgent_flight_ticket_fee_inter'] = 8;

$config['baggage_fees'] = array(
		'VN'=>array(
				'hand'=>lang('hand_baggage_note'),
				'send'=>lang('send_baggage_vna')
		),
		'BL'=>array(
				'hand'=>lang('hand_baggage_note'),
				'send'=>array(
						15=>array('vnd'=>155000,'usd'=>8),
						20=>array('vnd'=>175000,'usd'=>10),
						25=>array('vnd'=>230000,'usd'=>13),
						30=>array('vnd'=>280000,'usd'=>15),
						35=>array('vnd'=>330000,'usd'=>18),
						40=>array('vnd'=>380000,'usd'=>20)
				)
		),
		'VJ'=>array(
				'hand'=>lang('hand_baggage_note'),
				'send'=>array(
						15=>array('vnd'=>155000,'usd'=>8),
						20=>array('vnd'=>175000,'usd'=>10),
						25=>array('vnd'=>230000,'usd'=>13),
						30=>array('vnd'=>340000,'usd'=>18)
				)
					
		)
);


$config['baggage_vnisc_options'] = array(
	'BL'=>array(
			0=>7,
			15=>8,
			20=>9,
			25=>10,
			30=>11,
			35=>12,
			40=>13
	),
	'VJ'=>array(
			0=>1,
			15=>2,
			20=>4,
			25=>5,
			30=>6
	)
);

$config['passenger_nationalities'] = array(
		'ar' => array('Argentina','NA'),
		'au' => array('Australia','OC'),
		'at' => array('Austria','EU'),
		'by' => array('Belarus','EU'),
		'be' => array('Belgium','EU'),
		'bt' => array('Bhutan','AS'),
		'br' => array('Brazil','SA'),
		'bn' => array('Brunei','AS'),
		'bg' => array('Bulgaria','EU'),
		'kh' => array('Cambodia','AS'),
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
		'do' => array('Dominican Republic','NA'),
		'tl' => array('East Timor','AS'),
		'ec' => array('Ecuador','SA'),
		'eg' => array('Egypt','EU'),
		'fi' => array('Finland','EU'),
		'fr' => array('France','EU'),
		'de' => array('Germany','EU'),
		'gr' => array('Greece','EU'),
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
		'kp' => array('Korea, North','AS'),
		'kr' => array('Korea, South','AS'),
		'la' => array('Laos','AS'),
		'lv' => array('Latvia','EU'),
		'li' => array('Liechtenstein','EU'),
		'lt' => array('Lithuania','EU'),
		'lu' => array('Luxembourg','EU'),
		'mo' => array('Macau','AS'),
		'mk' => array('Macedonia','EU'),
		'my' => array('Malaysia','AS'),
		'mx' => array('Mexico','NA'),
		'md' => array('Moldova','EU'),
		'mc' => array('Monaco','AS'),
		'mm' => array('Myanmar','AS'),
		'np' => array('Nepal','AS'),
		'nl' => array('Netherlands','EU'),
		'an' => array('Netherlands Antilles','EU'),
		'nz' => array('New Zealand','OC'),
		'ng' => array('Nigeria','AF'),
		'no' => array('Norway','EU'),
		'py' => array('Paraguay','SA'),
		'pe' => array('Peru','SA'),
		'ph' => array('Philippines','AS'),
		'pl' => array('Poland','EU'),
		'pt' => array('Portugal','EU'),
		'qa' => array('Qatar','AS'),
		'ro' => array('Romania','EU'),
		'ru' => array('Russia','EU'),
		'sg' => array('Singapore','AS'),
		'sk' => array('Slovakia','EU'),
		'si' => array('Slovenia','EU'),
		'za' => array('South Africa','AF'),
		'es' => array('Spain','EU'),
		'se' => array('Sweden','EU'),
		'ch' => array('Switzerland','EU'),
		'tw' => array('Taiwan','AS'),
		'th' => array('Thailand','AS'),
		'ua' => array('Ukraine','EU'),
		'uk' => array('United Kingdom','EU'),
		'us' => array('United States','NA'),
		'uy' => array('Uruguay','SA'),
		'vn' => array('Vietnam','AS'),
);
?>
