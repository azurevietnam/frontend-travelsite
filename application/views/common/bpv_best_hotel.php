<div class="bpv-unbox">
	<h2 class="bpv-color-title">
		<?=lang('most_recommend_hotels')?>
	</h2>
	<div class="bpv-tab">
		<ul class="nav nav-tabs pull-left" id="hotel-tab">
			<?php foreach ($best_hotel_destinations as $k => $des):?>
			<?php if ($k > (BEST_HOTEL_LIMIT - 1)) break;?>
			<li <?= ($k == 0) ? 'class="active"' : ''?>>
				<a href="<?='#bp_top_'.$des['url_title']?>" data-toggle="tab"><?=$des['name']?><span class="arrow-bottom"><span class="arrow-before"></span><span class="arrow-after"></span></span></a>
			</li>
			<?php endforeach;?>
		</ul>
		<?php if(count($best_hotel_destinations) > 4):?>
		<span class="btn-show-more">
			<a id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
				<?=lang('btn_show_extra')?> <span class="icon icon-btn-more"></span>
			</a>
			<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
				<?php foreach ($best_hotel_destinations as $k => $des):?>
				<?php if ($k > (BEST_HOTEL_LIMIT - 1)):?>
				<li>
					<a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
				</li>
				<?php endif;?>
				<?php endforeach;?>
			</ul>
		</span>
		<?php endif;?>
		
	</div>
	<div class="tab-content">
		<?php foreach ($best_hotel_destinations as $k => $des):?>
		<?php if ($k > (BEST_HOTEL_LIMIT - 1)) break;?>
		<div class="tab-pane <?=($k == 0) ? 'active' : ''?>" id="<?='bp_top_'.$des['url_title']?>">
			<?php foreach ($des['hotels'] as $k => $hotel):?>
			<div class="bpt-list-md <?=($k == count($des['hotels']) - 1) ? ' no-border' : ''?>">
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
						<?=$hotel['address']?>
						- <a href="javascript:void(0)" data-lat="<?=$hotel['latitude']?>" data-lng="<?=$hotel['longitude']?>" 
							data-place-name="<?=$hotel['name']?>" data-hotel-id="<?=$hotel['id']?>" data-des-id="<?=$hotel['destination_id']?>" data-star=<?=$hotel['star']?>
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
					
					<?php if(!empty($hotel['review_number'])):?>
					<p class="item-address">
						<?=show_review($hotel, hotel_build_url($hotel))?>
					</p>
					<?php endif;?>
					
					<?php if(!empty($hotel['distance'])):?>
						<p>
							<?=lang('distance')?> <?=number_format($hotel['distance'], 2, ',', '.')?> <?=lang('unit_km')?>
						</p>
					<?php endif;?>
					
					
				</div>
				<div class="col-xs-2 price-info">
					<?php if (isset($hotel['price_from'])):?>
				
						<?php if ($hotel['price_origin'] != $hotel['price_from']):?>
						<div class="bpv-price-origin">
							<?=bpv_format_currency($hotel['price_origin'])?>
						</div>
						<?php endif;?>
						
						<div class="bpv-price-from margin-bottom-10"><?=bpv_format_currency($hotel['price_from'])?></div>
					
					<?php endif;?>
					<a type="button" href="<?=hotel_build_url($hotel, $search_criteria)?>" 
						class="btn btn-bpv btn-book-now pull-right"><?=lang('btn_book_now')?></a>
				</div>
			</div>
			<?php endforeach;?>
			
			<div class="col-xs-12 view-more">
				<a href="<?=get_url(HOTEL_SEARCH_PAGE, $des['url_params'])?>">
					<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
					<?=lang_arg('view_more_hote_in_des', $des['number_of_hotels'],$des['name'])?>
				</a>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

<?=load_hotel_map()?>

<script type="text/javascript">

$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>