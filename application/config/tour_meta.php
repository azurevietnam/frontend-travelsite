<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['cruise_cabins'] = array(
	
	0 => 'lang:all_cabins',

	1 => 'lang:1_5_cabins',
	
	2 => 'lang:6_10_cabins',

	4 => 'lang:11_20_cabins',
	
	8 => 'lang:over_20_cabins'
	
);

$config['tour_durations'] = array(
	
	0 => 'lang:all_day',

	1 => 'lang:1_day',
	
	2 => 'lang:2_days',
	
	3 => 'lang:3_days',
	
	4 => 'lang:4_7_days',
	
	5 => 'lang:over_7_days'
);


$config['tour_types'] = array(

	3 => 'lang:type_luxury',
	
	2 => 'lang:type_mid_range',
	
	1 => 'lang:type_cheap',
	
	4 => 'lang:type_private',
	
	5 => 'lang:type_group'
);

$config['tour_symnonym_en'] = array('Vacation', 'Holiday', 'Trip', 'Tours', 'Tour');
$config['tour_symnonym_es'] = array();
$config['tour_symnonym_fr'] = array();

// Customize Tour
$config['tour_customize_class'] = array(

    array(
        'name' => 'tour_customize_standard',
        'price_from' => 90,
        'price_to' => 110,
    ),

    array(
        'name' => 'tour_customize_deluxe',
        'price_from' => 110,
        'price_to' => 130,
    ),
    
    array(
        'name' => 'tour_customize_luxury',
        'price_from' => 130,
        'price_to' => 160,
    ),

    array(
        'name' => 'tour_customize_the_best',
        'price_from' => 200,
    ),
);

$config['myanmar_tour_destinations'] = array(
    'Yangon',
    'Bagan',
    'Inle Lake',
    'Mandalay',
    'Golden Rock',
    'Ngapali'
);

$config['tour_sort_by'] = array(	
	SORT_BY_RECOMMEND => lang('lbl_recommend'),
	SORT_BY_PRICE_LOW_HIGH => lang('lbl_price_low_high'),
	SORT_BY_PRICE_HIGH_LOW => lang('lbl_price_high_low'),
	SORT_BY_REVIEW_SCORE => lang('lbl_review_score')
);

$config['group_types']  = array(
    1=>'type_private',
    2=>'type_group',
);

$config['tour_transportations']  = array(
    1   =>  array(
        'icon' => 'icon-airplane',
        'label' => 'label_airplane'
    ),
    2   =>  array(
        'icon' => 'icon-car',
        'label' => 'label_car'
    ),
    3   =>  array(
        'icon' => 'icon-train',
        'label' => 'label_train'
    ),
    4   =>  array(
        'icon' => 'icon-cruise',
        'label' => 'label_cruise'
    ),
    5   =>  array(
        'icon' => 'icon-motorcycle',
        'label' => 'label_motorcycle'
    ),
    6   =>  array(
        'icon' => 'icon-bicycle',
        'label' => 'label_bicycle'
    ),
    7   =>  array(
        'icon' => 'icon-trekking',
        'label' => 'label_trekking'
    ),
);
/* End of file tourtination_meta.php */
/* Location: ./system/application/config/tourtination_meta.php */