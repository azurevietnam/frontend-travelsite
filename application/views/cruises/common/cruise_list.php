<?php foreach ($tours as $tour):?>

<div class="bpv-list-item margin-bottom-20 clearfix">
	<div class="col-1">
		<a href="<?=cruise_tour_build_url($tour, $search_criteria)?>">
			<img class="img-responsive" alt="" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'], '160x120')?>">
		</a>
	</div>
	<div class="col-2">
		<div class="item-name margin-bottom-5" style="margin-top:-5px">
			<a href="<?=cruise_tour_build_url($tour, $search_criteria)?>"><?=$tour['name']?></a>
			
			<span class="icon star-<?=str_replace('.', '_', $tour['star'])?>"></span>
	
		</div>
		<div class="item-address margin-bottom-5">
			<b><?=lang('tour_route')?></b><?=$tour['route']?>
		</div>
		
		<?php if(!empty($tour['promotions'])):?>
			<?php foreach ($tour['promotions'] as $pro):?>
				<div class="margin-bottom-10">
					<?=load_promotion_tooltip($pro, $tour['cruise_id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		
		
		<?php if(!empty($tour['bpv_promotions'])):?>
			<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
				<div class="margin-bottom-10">
					<?=load_marketing_pro_tooltip($bpv_pro, $tour['id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		 
		<div class="item-description">
			<?=limit_description($tour['description'])?>
		</div>
	</div>
	
	<div class="col-3">
	<?=show_review($tour, cruise_tour_build_url($tour), true)?>
	</div>
	
	<div class="col-4">
		<?php if( isset($tour['price_from']) ):?>
		
			<?php if($tour['price_origin'] != $tour['price_from']):?>
				<div class="text-right bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></div>
			<?php endif;?>
			
			<div class="text-right" style="clear: both; overflow: hidden;">
				<span class="label-price-from"><?=lang('price_from')?></span>
				<span class="bpv-price-from">
					&nbsp;<?=bpv_format_currency($tour['price_from'])?>
					<small style="font-size: 13px; margin-bottom: 10px; float: right; color: #333"><?=lang('/pax')?></small>
				</span>
			</div>
			
			<a type="button" href="<?=cruise_tour_build_url($tour, $search_criteria)?>" class="btn btn-bpv btn-book-now pull-right"><?=lang('btn_book_now')?></a>
		
		<?php else:?>
			
			
			<?php 
				$params = get_contact_params($tour, $search_criteria);
			?>
			
			<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
				href="<?=get_url(CONTACT_US_PAGE, $params)?>">
				<?=lang('contact_for_price')?>
			</a>
							
			
		<?php endif;?>
		
	</div>
	
	<div class="call-us"><span><?=lang('hotel_support')?>:</span> <span class="phone"><?=PHONE_SUPPORT?></span></div>
</div>

<?php endforeach;?>

<script type="text/javascript">

$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>


