<?php foreach ($hotels as $k => $hotel):?>

<div class="bpt-list-md  <?=($k == count($hotels) - 1) ? ' no-border' : ''?>">
	<div class="col-xs-3 no-padding">
		<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
			<img class="img-responsive" src="<?=get_image_path(HOTEL, $hotel['picture'],'160x120')?>">
		</a>
	</div>
	<div class="col-xs-7">
		<a class="item-name" href="<?=hotel_build_url($hotel, $search_criteria)?>">
			<?=$hotel['name']?>
			<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
		</a>
		<p class="item-address">
			<?=$hotel['address']?> - 
			<a href="javascript:void(0)" data-lat="<?=$hotel['latitude']?>" data-lng="<?=$hotel['longitude']?>" 
				data-place-name="<?=$hotel['name']?>" data-hotel-id="<?=$hotel['id']?>" data-des-id="<?=$hotel['destination_id']?>" data-star="<?=$hotel['star']?>"
				onclick="view_hotel_map(this)"><?=lang('view_map')?></a>
		</p>
		
		<?php if(!empty($hotel['promotions'])):?>
			<?php foreach ($hotel['promotions'] as $pro):?>
				<p>
					<?=load_promotion_tooltip($pro)?>
				</p>
			<?php endforeach;?>
		<?php endif;?>
		
		<?php if(!empty($hotel['bpv_promotions'])):?>
			<?php foreach ($hotel['bpv_promotions'] as $bpv_pro):?>
				<p>
					<?=load_marketing_pro_tooltip($bpv_pro, $hotel['id'])?>
				</p>
			<?php endforeach;?>
		<?php endif;?>
		
		<?php if(!empty($hotel['distance'])):?>
			<p>
				<?=lang('distance')?> <?=number_format($hotel['distance'], 2, ',', '.')?> <?=lang('unit_km')?>
			</p>
		<?php endif;?>
		
		<?=show_review($hotel, hotel_build_url($hotel))?>
	</div>
	<div class="col-xs-2 price-info">
		<?php if( isset($hotel['price_from']) ):?>
		
		<?php if($hotel['price_origin'] != $hotel['price_from']):?>
			<div class="text-right bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></div>
		<?php endif;?>
		
		<div class="text-right margin-bottom-10 bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></div>
		
		<?php endif;?>
		<a type="button" href="<?=hotel_build_url($hotel, $search_criteria)?>" class="btn btn-bpv btn-book-now btn-sm pull-right"><?=lang('btn_book_now')?></a>
	</div>
</div>
<?php endforeach;?>

<?=load_hotel_map()?>

<script type="text/javascript">

$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>


