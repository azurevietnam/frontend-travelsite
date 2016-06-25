<?=$bpv_ads?>

<div class="container">
	
	<?=$bpv_search?>
	
	<?=load_bpv_call_us(TOUR)?>
	
	<h2 class="bpv-color-title margin-top-20">
		<span class="icon icon-best"></span>
		
		<?=lang('popular_tour_categories')?>
	</h2>
	<div class="bpv_line_bottom"></div>
	<?php foreach($categories as $ct):?>
		<div class="col-xs-12 bpv_line_bottom">
			<div class="col-xs-4">
				<img class="margin-top-10 margin-bottom-10" src="<?=get_static_resources('images/categories/'.$ct['picture'])?>"/>
			</div>
			<div class="col-xs-8 margin-top-20">
				<a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $ct);?>">
					<span class="bpv-a-color-default" style="font-size:15px"><?=$ct['name']?></span>
				</a>
			</div>
		</div>
	<?php endforeach;?>
	<div class="clearfix"></div>
	<div class="row">
	<?=$recommended_tours_by_cat?>
	</div>
	<?=$tour_contact?>
</div>