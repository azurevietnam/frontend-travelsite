<div class="bpt-col-right pull-right">
	<?=$booking_steps?>
	
	<?=$extra_services?>
	
	<?=$recommend_sevices?>
	
	<div class="text-right">
		<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>" class="btn btn-default btn-sm"><?=lang('btn_back')?></a>
		<div class="btn btn-blue btn-lg" style="margin-left:20px" onclick="next_step()">
			<span class="glyphicon glyphicon-shopping-cart"></span>
			<?=lang('add_cart')?>
		</div>
	</div>
</div>
<div class="bpt-col-left pull-left">
	<?=$how_to_book_trip?>
	<?=$faq_by_page?>
</div>
