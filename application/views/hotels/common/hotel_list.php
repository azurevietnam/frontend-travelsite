<?php foreach ($hotels as $hotel):?>

<div class="bpv-list-item margin-bottom-20 clearfix">
	<div class="col-1">
		<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
			<img class="img-responsive" alt="" src="<?=get_image_path(HOTEL, $hotel['picture'],'160x120')?>">
		</a>
	</div>
	<div class="col-2">
		<div class="item-name margin-bottom-5" style="margin-top:-5px">
			<a href="<?=hotel_build_url($hotel, $search_criteria)?>"><?=$hotel['name']?></a>
			
			<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
	
		</div>
		<div class="item-address margin-bottom-10">
			<?=$hotel['address']?> - 
			<a href="javascript:void(0)" data-lat="<?=$hotel['latitude']?>" data-lng="<?=$hotel['longitude']?>" 
				data-place-name="<?=$hotel['name']?>" data-hotel-id="<?=$hotel['id']?>" data-des-id="<?=$hotel['destination_id']?>" data-star=<?=$hotel['star']?>
				onclick="view_hotel_map(this)"><?=lang('view_map')?></a>
		</div>
		
		<?php if(!empty($hotel['promotions'])):?>
			<?php foreach ($hotel['promotions'] as $pro):?>
				<div class="margin-bottom-10">
					<?=load_promotion_tooltip($pro)?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		
		
		<?php if(!empty($hotel['bpv_promotions'])):?>
			<?php foreach ($hotel['bpv_promotions'] as $bpv_pro):?>
				<div class="margin-bottom-10">
					<?=load_marketing_pro_tooltip($bpv_pro, $hotel['id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		
		
		<?php if(!empty($hotel['distance'])):?>
			<div class="margin-bottom-10">
				<?=lang('distance')?> <?=number_format($hotel['distance'], 2, ',', '.')?> <?=lang('unit_km')?>
			</div>
		<?php endif;?>
		 
		<?php if(count($hotel['important_facilities']) > 0):?>
		 	<div class="clearfix margin-bottom-10">
		 		<?php foreach ($hotel['important_facilities'] as $facility):?>
		 			<div class="bpv-important-facility" style="white-space: nowrap;"><?=$facility['name']?></div>
		 		<?php endforeach;?>
		 	</div>
		<?php endif;?>
		 
		<div class="item-description">
			
			<?=limit_description($hotel['description'])?>
			 
		</div>
	</div>
	<div class="col-3">
		<?=show_review($hotel, hotel_build_url($hotel), true)?>
	</div>
	
	<div class="col-4">
		<?php if( isset($hotel['price_from']) ):?>
		
			<?php if($hotel['price_origin'] != $hotel['price_from']):?>
				<div class="text-right bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></div>
			<?php endif;?>
			
			<div class="text-right margin-bottom-10 bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></div>
			
			<a type="button" href="<?=hotel_build_url($hotel, $search_criteria)?>" class="btn btn-bpv btn-book-now pull-right"><?=lang('btn_book_now')?></a>
		
		<?php else:?>
			
			
			<?php 
				$params = array('type'=>'hotel','des'=> $search_criteria['destination'],'hotel'=>$hotel['name'],'startdate'=>$search_criteria['startdate'],'night'=>$search_criteria['night']);
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

<?=load_hotel_map()?>

<script type="text/javascript">

$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>


