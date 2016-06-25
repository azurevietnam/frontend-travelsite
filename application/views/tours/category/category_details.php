<div class="container-fluid no-padding margin-bottom-20" style="position: relative;">
    <?=$bpv_ads?>
    <div class="container mod-search abs-center">
    	<?=$bpv_search?>
    </div>
</div>
<div class="container">
	 
		<div class="bpv-col-left">
			 <div class="bpv_call_us margin-bottom-20">
				<?=load_bpv_call_us(TOUR)?>
			</div>
			
			<?=$departure_from;?>
			
			<?=$tour_durations;?>
			
			<?=load_hotline_suport(TOUR)?>	
			 
		</div>
		
		<div class="bpv-col-right">
			<h2 class="bpv-color-title"><img src="<?=get_static_resources('images/categories/'.$category['picture'])?>" width="35" height="35"/> <?=$category['name']?></h2>
			<?=$category['description']?>
			<?=$category_tours;?>
			
			<?php if($num_tour_category['n_tour'] > 10):?>
			<div class="view-more pull-right">
				<a href="<?=$more_link;?>">
					<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
					<?=lang_arg('view_more', $num_tour_category['n_tour'])?> <?=$category['name']?>
				</a>
			</div>
			<?php endif;?>
			<div class="clearfix"></div>
			<?=$tour_contact?>	
		</div>
		
	 	<div class="clearfix margin-bottom-20"></div>
	 	
	 	<?=$footer_links?>
</div>
<?=$bpv_register?>
