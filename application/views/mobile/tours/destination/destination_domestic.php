<?=$bpv_ads?>

<div class="container">
	
	<?=$bpv_search?>
	
	<?=load_bpv_call_us(TOUR)?>
	
	<?=$popular_destinations?>
	<div class="row">
		<?=$recommended_tours_by_cat?>
	</div>
	<h2 class="bpv-color-title margin-top-20">
		<span class="icon icon-best"></span>
		
		<?=lang('more_category_tours')?>
	</h2>
	<div class="bpv_line_bottom"></div>
	<?php foreach($categories as $ct):?>
		<?php if(empty($ct['tours'])):?>
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
		<?php endif;?>
	<?php endforeach;?>
	
	<?=$tour_contact?>
</div>