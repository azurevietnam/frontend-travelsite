<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['contact_form_cnf'] = array(
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
    'subject' => array(
            'field'		=> 'subject',
            'label' 	=> 'lang:subject',
            'rules'		=> 'xss_clean',
    ),
	'special_requests' 	=> array (
			'field'		=> 'special_requests',
			'label' 	=> 'lang:special_requests',
			'rules'		=> 'max_length[1000]|xss_clean',
	)
);

$config['customize_form_cnf'] = array(
        'tour_name' => array (
            'field'		=> 'tour_name',
            'label' 	=> '',
            'rules'		=> '',
        ),
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
		'tour_accommodation' 	=> array (
				'field'		=> 'tour_accommodation',
				'label' 	=> 'lang:field_accomodation',
				'rules'		=> 'required',
		),
         'tour_duration' 	=> array (
                'field'		=> 'tour_duration',
                'label' 	=> 'lang:field_tour_duration',
                'rules'		=> 'required',
        ),
        'departure_date_customize' 	=> array (
            'field'		=> 'departure_date_customize',
            'label' 	=> 'lang:field_date_arrival',
            'rules'		=> 'required',
        ),
		'phone' 	=> array (
				'field'		=> 'phone',
				'label' 	=> 'lang:phone_number',
				'rules'		=> 'required|xss_clean',
		),
		'country' 	=> array (
				'field'		=> 'country',
				'label' 	=> 'lang:country',
				'rules'		=> 'required',
		),
//		'city' 	=> array (
//				'field'		=> 'city',
//				'label' 	=> 'lang:city',
//				'rules'		=> 'xss_clean',
//		),

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

// Customize Tour
$config['tour_customize_class'] = array(

    array(
        'name' => 'tour_customize_standard',
        'price_from' => 270,
        'price_to' => 330,
    ),

    array(
        'name' => 'tour_customize_deluxe',
        'price_from' => 330,
        'price_to' => 390,
    ),

    array(
        'name' => 'tour_customize_luxury',
        'price_from' => 390,
        'price_to' => 480,
    ),

    array(
        'name' => 'tour_customize_the_best',
        'price_from' => 600,
    ),
);


?>