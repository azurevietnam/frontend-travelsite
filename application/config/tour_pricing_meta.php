<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array();
$config['TourPrice'] = array(
	'table'	=> 'tour_prices',
	'audit' => true,
  	'comment'	=> 'Store prices of the tour',
  	'fields' => array (
  		'id' => array (
		    'field'		=> 'id',
		    'label' 	=> 'ID',
		    'column'	=> 'id',		    
		    'type'		=> 'id',		    
		    'required'	=> true,		    	   
		    'comment' 	=> 'Unique identifier',
		),  	
  		'tour_id' => array (
		    'field'		=> 'tour_id',
		    'label' 	=> 'tour_id',
		    'column'	=> 'tour_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tours',
		),
		'from_date' 	=> array (
		    'field'		=> 'from_date',
		    'label' 	=> 'lang:tour_price_fromdate',
		    'column'	=> 'from_date',
		    'type'		=> 'datetime',
			'len'		=> 10,		    
		    'required'	=> true,
		    'rules'		=> 'required|callback__is_date|callback__valid_date',
		    'comment' 	=> 'the date from of this price',
		),		
		'to_date' 	=> array (
		    'field'		=> 'to_date',
		    'label' 	=> 'lang:tour_price_todate',
		    'column'	=> 'to_date',
		    'type'		=> 'datetime',
			'len'		=> 10,		    
		    'required'	=> false,
		    'rules'		=> 'callback__is_date',
		    'comment' 	=> 'the date end of this price',
		),				
		'from_price' 	=> array (
		    'field'		=> 'from_price',
		    'label' 	=> 'lang:tour_price_fromprice',
		    'column'	=> 'from_price',
		    'type'		=> 'int',
		    'required'	=> false,
		    'comment' 	=> 'the from price of a tour price',
		),						
		'user_created_id' 	=> array (
		    'field'		=> 'user_created_id',
		    'label' 	=> 'user_created_id',
		    'column'	=> 'user_created_id',
		    'type'		=> 'int',
		    'required'	=> true,
		    'comment' 	=> 'the id of user created this tour',
		),
		'date_created' 	=> array (
		    'field'		=> 'date_created',
		    'label' 	=> 'date_created',
		    'column'	=> 'date_created',
		    'type'		=> 'datetime',
		    'required'	=> true,
		    'comment' 	=> 'the date this tour was created',
		),
		'user_modified_id'	=> array (
		    'field'		=> 'user_modified_id',
		    'label' 	=> 'user_modified_id',
		    'column'	=> 'user_modified_id',
		    'type'		=> 'int',
		    'required'	=> true,
		    'comment' 	=> 'the id of user modified this tour',
		),
		'date_modified' => array (
		    'field'		=> 'date_modified',
		    'label' 	=> 'date_modified',
		    'column'	=> 'date_modified',
		    'type'		=> 'datetime',
		    'required'	=> true,
		    'comment' 	=> 'the last modified of this',
		),
		'deleted' => array (
		    'field'		=> 'deleted',
		    'label' 	=> 'deleted',
		    'column'	=> 'deleted',
		    'type'		=> 'tinyint',
		    'required'	=> true,
		    'comment' 	=> 'mark deleted of this tour',
		),		
	),
);

$config['TourPriceDetail'] = array(
	'table'	=> 'tour_price_details', 
	'audit' => true,
  	'comment'	=> 'Store detail of prices for a tour',
  	'fields' => array (
  		'id' => array (
		    'field'		=> 'id',
		    'label' 	=> 'id',
		    'column'	=> 'id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'Unique identifier',
		),
		'class_service' => array (
		    'field'		=> 'class_service',
		    'label' 	=> 'class_service',
		    'column'	=> 'class_service',
		    'type'		=> 'tinyint',
		    'required'	=> true,
		    'rules'		=> '',
		    'comment' 	=> 'class service for this price',
		),
		'group_size' => array (
		    'field'		=> 'group_size',
		    'label' 	=> 'group_size',
		    'column'	=> 'group_size',
		    'type'		=> 'tinyint',
		    'required'	=> true,
		    'rules'		=> '',
		    'comment' 	=> 'group size for this price',
		),
		'price' => array (
		    'field'		=> 'price',
		    'label' 	=> 'price',
		    'column'	=> 'price',
		    'type'		=> 'double',
		    'len'		=> 5,
		    'required'	=> true,
		    'rules'		=> '',
		    'comment' 	=> 'price for children from 6 to under 12 year olds',
		),
  		'tour_price_id' => array (
		    'field'		=> 'tour_price_id',
		    'label' 	=> 'tour_price_id',
		    'column'	=> 'tour_price_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tour_prices',
		),		
		'user_created_id' 	=> array (
		    'field'		=> 'user_created_id',
		    'label' 	=> 'user_created_id',
		    'column'	=> 'user_created_id',
		    'type'		=> 'int',
		    'required'	=> true,
		    'comment' 	=> 'the id of user created this tour',
		),
		'date_created' 	=> array (
		    'field'		=> 'date_created',
		    'label' 	=> 'date_created',
		    'column'	=> 'date_created',
		    'type'		=> 'datetime',
		    'required'	=> true,
		    'comment' 	=> 'the date this tour was created',
		),
		'user_modified_id'	=> array (
		    'field'		=> 'user_modified_id',
		    'label' 	=> 'user_modified_id',
		    'column'	=> 'user_modified_id',
		    'type'		=> 'int',
		    'required'	=> true,
		    'comment' 	=> 'the id of user modified this tour',
		),
		'date_modified' => array (
		    'field'		=> 'date_modified',
		    'label' 	=> 'date_modified',
		    'column'	=> 'date_modified',
		    'type'		=> 'datetime',
		    'required'	=> true,
		    'comment' 	=> 'the last modified of this',
		),
		'deleted' => array (
		    'field'		=> 'deleted',
		    'label' 	=> 'deleted',
		    'column'	=> 'deleted',
		    'type'		=> 'tinyint',
		    'required'	=> true,
		    'comment' 	=> 'mark deleted of this tour',
		),				
	),
);

$config['TourChildrenPrice'] = array(
	'table'	=> 'tour_children_prices', 
	'audit' => true,
  	'comment'	=> 'Store children prices for a tour',
  	'fields' => array (
  		'tour_id' => array (
		    'field'		=> 'tour_id',
		    'label' 	=> 'tour_id',
		    'column'	=> 'tour_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tours',
		),
		'under6' => array (
		    'field'		=> 'under6',
		    'label' 	=> 'lang:tour_children_under6',
		    'column'	=> 'under6',
		    'type'		=> 'int',
		    'len'		=> 3,
		    'required'	=> true,
		    'rules'		=> '',
		    'comment' 	=> 'price for children under 6 year olds',
		),
		'under12' => array (
		    'field'		=> 'under12',
		    'label' 	=> 'lang:tour_children_under12',
		    'column'	=> 'under12',
		    'type'		=> 'int',
		    'len'		=> 3,
		    'required'	=> true,
		    'rules'		=> '',
		    'comment' 	=> 'price for children from 6 to under 12 year olds',
		),
	),
);

$config['TourService'] = array(
	'table'	=> 'tour_services', 
	'audit' => true,
  	'comment'	=> 'Store services in a tour',
  	'fields' => array (
  		'tour_id' => array (
		    'field'		=> 'tour_id',
		    'label' 	=> 'tour_id',
		    'column'	=> 'tour_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tours',
		),
		'service_includes' => array (
		    'field'		=> 'service_includes',
		    'label' 	=> 'lang:tour_service_includes',
		    'column'	=> 'includes',
		    'type'		=> 'varchar',
		    'len'		=> 1000,
		    'required'	=> true,
		    'rules'		=> 'required|max_length[1000]',
		    'comment' 	=> 'stored sevices included in a tour',
		),
		'service_excludes' => array (
		    'field'		=> 'service_excludes',
		    'label' 	=> 'lang:tour_service_excludes',
		    'column'	=> 'excludes',
		    'type'		=> 'varchar',
		    'len'		=> 1000,
		    'required'	=> true,
		    'rules'		=> 'required|max_length[1000]',
		    'comment' 	=> 'stored sevices excluded in a tour',
		),
	),
);
$config['TourAccommodation'] = array(
	'table'	=> 'tour_accommodations', 
	'audit' => true,
  	'comment'	=> 'Store accommodations in a tour',
  	'fields' => array (
  		'tour_id' => array (
		    'field'		=> 'tour_id',
		    'label' 	=> 'tour_id',
		    'column'	=> 'tour_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tours',
		),
		'class_service' => array (
		    'field'		=> 'class_service',
		    'label' 	=> 'class_service',
		    'column'	=> 'class_service',
		    'type'		=> 'tinyint',
		    'len'		=> 1,
		    'required'	=> true,
		    'comment' 	=> 'class sevice of accommodation',
		),
		'accomm_content' => array (
		    'field'		=> 'accomm_content',
		    'label' 	=> 'accomm_content',
		    'column'	=> 'content',
		    'type'		=> 'varchar',
		    'len'		=> 1000,
		    'required'	=> true,
		    'comment' 	=> 'accommodation for a class service of this tour',
		),		
	),
);

$config['TourBookingPolicy'] = array(
	'table'	=> 'tour_booking_policies', 
	'audit' => true,
  	'comment'	=> 'Store booking policies for a tour',
  	'fields' => array (
  		'tour_id' => array (
		    'field'		=> 'tour_id',
		    'label' 	=> 'tour_id',
		    'column'	=> 'tour_id',		    
		    'type'		=> 'int',
		    'required'	=> true,		    	   
		    'comment' 	=> 'FK -> tours',
		),
		'booking_time' => array (
		    'field'		=> 'booking_time',
		    'label' 	=> 'lang:tour_bookingtime',
		    'column'	=> 'booking_time',
		    'type'		=> 'int',
		    'len'		=> 2,
		    'required'	=> true,
			'rules'		=> 'required|is_natural_no_zero',
		    'comment' 	=> 'required booking time for a tour',
		),
		'cancellation_policy' => array (
		    'field'		=> 'cancellation_policy',
		    'label' 	=> 'lang:tour_cancellation_policy',
		    'column'	=> 'cancellation_policy',
		    'type'		=> 'varchar',
		    'len'		=> 1000,
		    'required'	=> true,
		    'rules'		=> 'required|max_length[1000]',
		    'comment' 	=> 'stored cancellation policy for a tour',
		),
		'children_extrabed' => array (
		    'field'		=> 'children_extrabed',
		    'label' 	=> 'lang:tour_children_extrabed',
		    'column'	=> 'children_extrabed',
		    'type'		=> 'varchar',
		    'len'		=> 1000,
		    'required'	=> true,
		    'rules'		=> 'required|max_length[1000]',
		    'comment' 	=> 'stored cancellation policy for a tour',
		),
	),
);
/* End of file tourtination_meta.php */
/* Location: ./system/application/config/tourtination_meta.php */