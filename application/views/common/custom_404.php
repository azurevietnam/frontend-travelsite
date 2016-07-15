<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">

#searchForm {height: 300px}
#searchForm .row_des{margin-top:0}

/*Hotel Search Form*/
#frmHotelSearchForm .row {
	clear: both;
	padding: 5px 0px;
}

#frmHotelSearchForm .row_inline {
	float: left;
	padding: 5px 0 5px 10px;
}

#frmHotelSearchForm .column_arrive {
	display: block;
	float: left;
	width: 200px;
}

#frmHotelSearchForm .nights {
	display: block;
	padding: 5px 0 5px 10px;
	float: left;
	width: 60px;
}

#frmHotelSearchForm .hotel_destination {
	width: 230px;
}

</style>

<div id="contentLeft">
	<?=$tour_search_view?>

    <?=$why_use?>
	
	<?=$topDestinations?>

</div>

<div id="contentMain" style="text-align: center;">
	
	<h1 class="highlight" style="font-size: 30px">Page Not Found!</h1>
	
	<h2 style="color:#666">We apologize, the page you're looking for is no longer available.</h2>
	
	<br>
	<br>
	
	<span style="font-size: 150px; color: red;">404</span>
	
	<br>
	<br>
	<span style="font-size:14px">Use the search box to find tours of more than 60 <b>cruises in Halong Bay</b>,<br> many interesting <b>trips in Mekong Delta</b> and <b>popular hotels</b> in Hanoi, Ho Chi Minh City.</span>
	<br>
	<br>
	<span style="font-size:14px"><a href="/aboutus/contact/"><b><?=lang('contact_title')?></b></a> if you have any request!</span>
</div>