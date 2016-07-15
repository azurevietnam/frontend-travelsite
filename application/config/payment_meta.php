<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Onepay test account
$config['pay_parameter'] = array(
		
	'Title' 				=> 'Best Price Vietnam Visa Payment',
	
	'AgainLink'				=> '',
		
	'vpc_Merchant' 			=> 'BESTPRICE', // BESTPRICE	TESTONEPAYUSD
	
	'vpc_AccessCode' 		=> 'BE120593', // BE120593	614240F4
	
	'vpc_MerchTxnRef' 		=> '',
	
	'vpc_OrderInfo' 		=> '',
	'vpc_Amount' 			=> '0',
	
	'vpc_ReturnURL' 		=> '',
		
	'vpc_Version' 			=> '2',
	'vpc_Command' 			=> 'pay',
	'vpc_Locale' 			=> 'en',
	
	'vpc_TicketNo' 			=> '10.36.74.105',
		
	// Ticket No is IP address of the computer of the cardholder do the transaction.
/*
	'vpc_SHIP_Street01' 	=> '',
	'vpc_SHIP_Provice' 		=> '',
	'vpc_SHIP_City' 		=> '',
	'vpc_SHIP_Country' 		=> '',
	'vpc_Customer_Phone' 	=> '',
	'vpc_Customer_Email' 	=> '',
	'vpc_Customer_Id' 		=> '',
		
	'AVS_Street01'			=> '',
	'AVS_City'				=> '',
	'AVS_StateProv'			=> '',
	'AVS_PostCode' 			=> '',
	'AVS_Country'			=> '',
	*/
);

