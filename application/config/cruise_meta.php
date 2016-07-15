<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['cruise_destinations'] = array(
	0 => 'lang:halong_bay_cruises',
	1 => 'lang:mekong_river_cruises',
);

$config['cruise_star'] = array(5,4,3,2);

$config['program_duration']  = array(1=>'1 day', 2=>'2 days', 3=>'3 days', 4=>'4-7 days', 5=>'over 7 days');

$config['customer_review_types'] = array(
	0 => 'lang:customer_type_business',
	1 => 'lang:customer_type_couples',
	2 => 'lang:customer_type_familly',
	3 => 'lang:customer_type_friends',
	4 => 'lang:customer_type_solo',
);

$config['review_rate_types'] = array(
		6 => 'lang:review_rate_excellent',
		5 => 'lang:review_rate_very_good',
		4 => 'lang:review_rate_good',
		3 => 'lang:review_rate_average',
		2 => 'lang:review_rate_poor',
		1 => 'lang:review_rate_terrible',
);

/**
 * Halong Bay Cruise Categories Configuration
 * 
 */
$config['halongcruise_categories'] = array(
		
	'luxuryhalongcruises' => array(
		'label'=> 'luxury_cruises',
	    'full_label' => 'luxuryhalongcruises',
		'show_tab' => true,
	    'type' => LUXURY_HALONG_CRUISE_PAGE,
	    'more_lang' => 'more_luxury_halong_cruises',
	),
		
	'deluxehalongcruises' => array(
		'label' => 'deluxe_cruises',
	    'full_label' => 'deluxehalongcruises',
		'show_tab' => true,
	    'type' => DELUXE_HALONG_CRUISE_PAGE,
	    'more_lang' => 'more_deluxe_halong_cruises',
	),
	
	'cheaphalongcruises' => array(
		'label'  => 'cheap_cruises',
	    'full_label' => 'cheaphalongcruises',
		'show_tab' => true,
	    'type' => CHEAP_HALONG_CRUISE_PAGE,
	    'more_lang' => 'more_cheap_halong_cruises',
	),
		
	'privatehalongcruises' => array(
		'label' => 'charter_cruises',
	    'full_label' => 'privatehalongcruises',
		'show_tab' => true,
	    'type' => CHARTER_HALONG_CRUISE_PAGE,
	    'more_lang' => 'more_private_halong_cruises',
	),
    
    'halongbaydaycruises' => array(
        'label' => 'day_cruises',
        'full_label' => 'halongbaydaycruises',
        'show_tab' => true,
        'type' => DAY_HALONG_CRUISE_PAGE,
        'more_lang' => 'more_halongbay_day_cruises',
    ),
    
    /* 'halongbigsizecruises' => array(
        'label' => 'bigsize_cruises',
        'full_label' => 'bigsize_cruises',
        'show_tab' => false,
        'type' => HALONG_BAY_BIG_SIZE_CRUISE_PAGE,
    ),
    
    'halongmediumsizecruises' => array(
        'label' => 'mediumsize_cruises',
        'full_label' => 'mediumsize_cruises',
        'show_tab' => false,
        'type' => HALONG_BAY_MEDIUM_SIZE_CRUISE_PAGE,
    ),
    
    'halongsmallsizecruises' => array(
        'label' => 'smallsize_cruises',
        'full_label' => 'smallsize_cruises',
        'show_tab' => false,
        'type' => HALONG_BAY_SMALL_SIZE_CRUISE_PAGE,
    ), */
    
    'halongfamilycruises' => array(
        'label' => 'family_cruises',
        'full_label' => 'family_cruises',
        'show_tab' => false,
        'type' => FAMILY_HALONG_CRUISE_PAGE,
        'more_lang' => 'more_halong_family_cruises',
    ),
    
    'halonghoneymooncruises' => array(
        'label' => 'honeymoon_cruises',
        'full_label' => 'honeymoon_cruises',
        'show_tab' => false,
        'type' => HONEY_MOON_HALONG_CRUISE_PAGE,
        'more_lang' => 'more_halong_honeymoon_cruises',
    )
);

/**
 * Mekong River Cruise Configuration
 * 
 */
$config['mekongcruise_categories'] = array(
    
	'mekongcruisesvietnamcambodia' => array(
		'label' => 'vietnam_cambodia_cruises',
	    'full_label' => 'vietnam_cambodia_cruises',
		'show_tab' => true,
	    'type' => VIETNAM_CAMBODIA_CRUISE_PAGE,
	    'more_lang' => 'more_vietnam_cambodia_cruises',

		'show_on_styles' => true,
		'style_label' => 'label_vietnam_cambodia_cruises',
		'style_desc' => 'desc_vietnam_cambodia_cruises',
			
		'show_on_bottom' => false,
	),
    
	'mekongcruisesvietnam' => array(
		'label' => 'vietnam_cruises',
	    'full_label' => 'vietnam_cruises',
		'show_tab' => true,
	    'type' => VIETNAM_CRUISE_PAGE,
	    'more_lang' => 'more_vietnam_cruises',
			
		'show_on_styles' => true,
		'style_label' => 'label_vietnam_mekong_cruises',
		'style_desc' => 'desc_vietnam_mekong_cruises',
			
		'show_on_bottom' => false,
	),
    
    'mekongcruiseslaos' => array(
        'label' => 'laos_cruises',
        'full_label' => 'laos_cruises',
        'show_tab' => true,
        'type' => LAOS_CRUISE_PAGE,
        'more_lang' => 'more_laos_cruises',
    	
    	'show_on_styles' => true,
    	'style_label' => 'label_laos_mekong_cruises',
    	'style_desc' => 'desc_laos_mekong_cruises',
    		
    	'show_on_bottom' => false,
    ),
    
    'mekongcruisesthailand' => array(
        'label' => 'thailand_cruises',
        'full_label' => 'thailand_cruises',
        'show_tab' => true,
        'type' => THAILAND_CRUISE_PAGE,
        'more_lang' => 'more_thailand_cruises',
    		
    	'show_on_styles' => false,
        'style_label'    => 'label_thailand_mekong_cruises',
        'style_desc'     => '',
    	'show_on_bottom' => false,
    ),
    
    'mekongcruisesburma' => array(
        'label' => 'burma_cruises',
        'full_label' => 'burma_cruises',
        'show_tab' => true,
        'type' => BURMA_CRUISE_PAGE,
        'more_lang' => 'more_burma_cruises',
    		
    	'show_on_styles' => true,
    	'style_label' => 'label_burma_mekong_cruises',
    	'style_desc' => 'desc_burma_mekong_cruises',
    		
    	'show_on_bottom' => false,
    ),

	'luxurymekongcruises' => array(
		'label' => 'label_luxury_mekong_cruises',
		'full_label' => 'label_luxury_mekong_cruises',
		'show_tab' => false,
		'type' => LUXURY_MEKONG_CRUISE_PAGE,
		'more_lang' => 'more_luxury_mekong_cruises',

		'show_on_styles' => true,
		'style_label' => 'label_luxury_mekong_cruises',
		'style_desc' => 'desc_luxury_mekong_cruises',
			
		'show_on_bottom' => true,
	),
		
	'deluxemekongcruises' => array(
		'label' => 'label_deluxe_mekong_cruises',
		'full_label' => 'label_deluxe_mekong_cruises',
		'show_tab' => false,
		'type' => DELUXE_MEKONG_CRUISE_PAGE,
		'more_lang' => 'more_deluxe_mekong_cruises',

		'show_on_styles' => false,
		'style_label' => 'label_deluxe_mekong_cruises',
		'style_desc' => 'desc_deluxe_mekong_cruises',
			
		'show_on_bottom' => true,
	),
	
	'cheapmekongcruises' => array(
		'label' => 'label_cheap_mekong_cruises',
		'full_label' => 'label_cheap_mekong_cruises',
		'show_tab' => false,
		'type' => CHEAP_MEKONG_CRUISE_PAGE,
		'more_lang' => 'more_cheap_mekong_cruises',

		'show_on_styles' => false,
		'style_label' => 'label_cheap_mekong_cruises',
		'style_desc' => 'desc_cheap_mekong_cruises',
			
		'show_on_bottom' => true,
	),
	
	'privatemekongcruises' => array(
		'label' => 'label_private_mekong_cruises',
		'full_label' => 'label_private_mekong_cruises',
		'show_tab' => false,
		'type' => PRIVATE_MEKONG_CRUISE_PAGE,
		'more_lang' => 'more_private_mekong_cruises',

		'show_on_styles' => false,
		'style_label' => 'label_private_mekong_cruises',
		'style_desc' => 'desc_private_mekong_cruises',
			
		'show_on_bottom' => true,
	),
		
	'mekongriverdaycruises' => array(
		'label' => 'label_mekong_day_cruises',
		'full_label' => 'label_mekong_day_cruises',
		'show_tab' => false,
		'type' => DAY_MEKONG_CRUISE_PAGE,
		'more_lang' => 'more_mekong_day_cruises',

		'show_on_styles' => true,
		'style_label' => 'label_mekong_day_cruises',
		'style_desc' => 'desc_mekong_day_cruises',
			
		'show_on_bottom' => true,
	)
);

