<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['Hotel_Star'] = array(5,4,3);

$config['Hotel_Night'] = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15);

$config['Hotel_Status']  = array(
	1 => 'lang:hotel_status_active',
	0 => 'lang:hotel_status_inactive',
);

$config['Room_Type_Max_Person'] = array(2,1,3,4,5);



$config['hotel_sort_by'] = array(
	SORT_BY_RECOMMEND => lang('lbl_recommend'),
	SORT_BY_STAR_5_1 => lang('lbl_stars_5_1'),
	SORT_BY_STAR_1_5 => lang('lbl_stars_1_5'),
	SORT_BY_REVIEW_SCORE => lang('lbl_review_score')
);


