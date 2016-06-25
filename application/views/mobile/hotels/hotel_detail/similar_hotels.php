<?php if(count($s_hotels) > 0):?>
<div class="bpv-list margin-top-20">
	<h2 class="bpv-color-title"><?=lang('same_class_hotels')?></h2>

	<?php foreach ($s_hotels as $key=>$hotel):?>
			
	<div class="bpv-item"
        onclick="go_url('<?=hotel_build_url($hotel, $search_criteria)?>')">
        <img class="pull-left" src="<?=get_image_path(HOTEL, $hotel['picture'],'268x201')?>" class="img-responsive">
		
		<div class="item-name"><?=$hotel['name']?> <i class="icon star-<?=$hotel['star']?>"></i></div>
		
	 
		<?php if(isset($hotel['price_from'])):?>
			<div class="pull-right item-price">
				
				<?php if($hotel['price_from'] != $hotel['price_origin']):?>
					<span class="bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></span>
				<?php endif;?>
				
					<span class="bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></span>
				
			</div>
			
			<?php if ($hotel['price_origin'] != $hotel['price_from'] && !empty($hotel['promotions'])):?>
	       		<span class="pro-off"><?=get_pro_off($hotel)?></span>
	   		<?php endif;?>
		<?php endif;?>
	 
		
	</div>

	<?php endforeach;?>
	
	<?php 
		$url_params['star'] = floor($hotel['star']);
	?>
	<div class="margin-top-15 margin-bottom-15 text-center">
		<a class="view-more-btn"  href="<?=get_url(HOTEL_SEARCH_PAGE, $url_params)?>">
			<?php 
				
				echo lang_arg('view_more_hotel_same_class');
			?>
			<i class="icon icon-chevron-right"></i>
		</a>
	</div>
	
	
	
</div>
<?php endif;?>