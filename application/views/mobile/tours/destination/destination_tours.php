<div class="container-fluid">
	<?=$bpv_ads?>
</div>
<div class="container">
	
	<?=$bpv_search?>
	
	<?=load_bpv_call_us(TOUR)?>
	
	<?php if(isset($popular_sub_destination)):?>
		<?=$popular_sub_destination?>
	<?php endif;?>
	
	<h2 class="bpv-color-title margin-top-20"><?=lang_arg('popular_tours_in_des', $destination['name'])?></h2>
	
	<div class="row">
	
		<?=$destination_tours;?>
	
	</div>
	
	<div class="bpv-list">
		<?php if($destination['is_outbound'] == TOUR_DOMESTIC && $destination['nr_tour_domistic'] > 10):?>
		<div class="text-center clearfix margin-top-20">
			<a class="view-more" href="<?=$more_link;?>"> 
				<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
				<?=lang_arg('view_more', $destination['nr_tour_domistic'])?> <?=$destination['name']?>
			</a>
		</div>
		<?php elseif($destination['is_outbound'] == TOUR_OUTBOUND && $destination['nr_tour_outbound'] > 10):?>
		<div class="text-center clearfix margin-top-20">
			<a class="view-more" href="<?=$more_link;?>">
				<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
				<?=lang_arg('view_more', $destination['nr_tour_outbound'])?> <?=$destination['name']?> 
			</a>
		</div>
		<?php endif;?>
	</div>
	
	<?=$tour_contact?>
</div>