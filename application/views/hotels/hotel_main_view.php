<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="page_title">
	<h1 class="highlight"><?=lang('hotel_home')?>:</h1>
	
	<span><?=lang('hotels_desc')?></span>
</div>

<div id="contentMain">
	<?=$best_deal_view?>	
</div>

<div id="contentLeft">
	<div id="search_area_list">
		<?=$search_view?>
	</div>
	
	<?=$why_use?>
	
	<div id="top_destination_list">
		<?=$top_destination_view?>
	</div>
	
	<div id="hotel_faq_list">
		<?=$faq_context?>
	</div>
</div>

<?=$hotel_destination_view?>

