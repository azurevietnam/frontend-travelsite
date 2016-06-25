<?php foreach ($tours as $tour):?>

<div class="bpv-list-item margin-bottom-20 clearfix">
	<div class="col-1">
		<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
		    <?php if(!empty($tour['cruise_id'])):?>
		    <img class="img-responsive" alt="<?=$tour['name']?>" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'], '160x120')?>">
			<?php else:?>
			<img class="img-responsive" alt="<?=$tour['name']?>" src="<?=get_image_path(TOUR, $tour['picture'], '160x120')?>">
			<?php endif;?>
		</a>
	</div>
	<div class="col-2">
		<div class="item-name margin-bottom-5" style="margin-top:-5px">
			<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>"><?=$tour['name']?></a>
			<label class="bpv-color-marketing tour-duration">(<?=get_duration_text($tour)?>)</label>
		</div>
		
		<?php if(!empty($tour['promotions'])):?>
			<?php foreach ($tour['promotions'] as $pro):?>
				<div class="margin-bottom-10">
					<?=load_promotion_tooltip($pro, $tour['id'])?>
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
		
		<?php if(!empty($tour['code'])):?>
		<div class="margin-bottom-5">
            <b><?=lang('lbl_tour_code')?></b> <?=$tour['code']?>
		</div>
		<?php endif;?>
		
		<div class="margin-bottom-5">
			<b><?=lang('lbl_tour_route')?></b><?=$tour['route']?>
		</div>
		
		<div class="margin-bottom-5">
			<?=get_departure_date_text($tour)?>
		</div>
		
		<div class="transport">
			<?=get_tour_transportation($tour['transportations'])?>
		</div>
		
	</div>
	
	<div class="col-3">
	<?=show_review($tour, get_url(TOUR_DETAIL_PAGE, $tour), true)?>
	</div>
	
	<div class="col-4 text-right">
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
			
			<a type="button" href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" class="btn btn-bpv btn-book-now pull-right"><?=lang('btn_book_now')?></a>
		
		<?php else:?>
			
			
			<?php 
				$params = get_tour_contact_params($tour, $search_criteria);
			?>
			
			<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
				href="<?=get_url(CONTACT_US_PAGE, $params)?>">
				<?=lang('contact_for_price')?>
			</a>
							
			
		<?php endif;?>
		
	</div>
	
	<div class="call-us"><span><?=lang('book_tour_support')?>:</span> <span class="phone"><?=PHONE_SUPPORT?></span></div>
</div>

<?php endforeach;?>

<script type="text/javascript">

$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>


