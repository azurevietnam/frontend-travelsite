<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(isset($des)):?>
<div id="page_title">
	<h1 class="highlight"><?=lang('hotel_top_recommended').$des['name']?></h1>
</div>
<?php endif;?>

<div id="contentMain">
	<?=$hotel_list_view?>
</div>

<div id="contentLeft">
	<div id="search_area_list">
		<?=$search_view?>
	</div>
	
	<div id="top_destination_list">
		<?=$top_destination_view?>
	</div>
	
	<div id="hotel_faq_list">
		<?=$faq_context?>
	</div>
</div>

<?php if(isset($all_hotel_in_destination_view)):?>
	<?=$all_hotel_in_destination_view?>
<?php endif;?>

