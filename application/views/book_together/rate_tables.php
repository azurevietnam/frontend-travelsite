<h3 class="text-highlight">
	<?=$service_1['name']?>
	<span style="font-size: 13px; font-weight: normal;"> ( <a style="font-style: italic; text-decoration: underline;" target="_blank" href="<?=get_page_url(TOUR_DETAIL_PAGE, $service_1)?>"><?=lang('view_your_detail')?></a> )</span>
</h3>
<?=$rate_table_1?>

<h3 class="text-highlight">
	<?=$service_2['name']?>
	<?php if($service_2['service_type'] == HOTEL):?>
		<span style="font-size: 13px; font-weight: normal;"> ( <a style="font-style: italic; text-decoration: underline;" target="_blank" href="<?=get_page_url(HOTEL_DETAIL_PAGE, $service_2)?>"><?=lang('view_hotel_detail')?></a> )</span>
	<?php else:?>
		<span style="font-size: 13px; font-weight: normal;"> ( <a style="font-style: italic; text-decoration: underline;" target="_blank" href="<?=get_page_url(TOUR_DETAIL_PAGE, $service_2)?>"><?=lang('view_your_detail')?></a> )</span>
	<?php endif;?>
</h3>
<?=$rate_table_2?>