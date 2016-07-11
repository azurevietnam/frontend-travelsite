<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link rel="stylesheet" type="text/css" href="/css/cruise.min.20072013.css" />

<div id="contentLeft">
	<div id="search_cruise_list" class="round_coner">
		<?=$search_view?>
	</div>
	<div id="my_viewed_cruise_list" class="round_coner">
		<?=$my_viewed_cruise_view?>
	</div>
	
	<div id="cruise_faq_list">
		<?=$cruise_faq_view?>
	</div>
</div>

<div id="contentMain">
	<?=$search_list_view?>
</div>