<?=$booking_steps?>

<div class="container margin-top-10">
	<?=$extra_services?>
	
	<div class="text-right">
		<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>" class="btn btn-default btn-sm"><?=lang('btn_back')?></a>
		<div class="btn btn-blue btn-lg" style="margin-left:20px" onclick="next_step()">
			<span class="glyphicon glyphicon-shopping-cart"></span>
			<?=lang('add_cart')?>
		</div>
	</div>	
</div>