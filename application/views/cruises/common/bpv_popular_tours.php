<?php if(!empty($popular_tours)):?>
<div class="bpv-unbox">
	<h2 class="bpv-color-title">
		<?=lang('halong_popular_tours')?>
	</h2>
	<div class="tab-content">
		<?php foreach ($popular_tours as $k => $tour):?>
			<div class="bpt-list-md <?=($k == count($popular_tours) - 1) ? ' no-border' : ''?>">
				<div class="col-xs-3 no-padding">
				<a href="<?=cruise_tour_build_url($tour)?>">
					<img class="img-responsive" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'], '160x120')?>">
				</a>
				</div>
				<div class="col-xs-7">
					<a class="item-name" href="<?=cruise_tour_build_url($tour, $search_criteria)?>">
						<?=$tour['name']?>
						<span class="icon star-<?=str_replace('.', '_', $tour['star'])?>"></span>
					</a>
					<div class="item-address margin-bottom-5"><b style="color: #666"><?=lang('tour_route')?></b><?=$tour['route']?></div>
					
					<?php if(!empty($tour['promotions'])):?>
						<?php foreach ($tour['promotions'] as $pro):?>
							<p>
								<?=load_promotion_tooltip($pro, $tour['id'])?>
							</p>
						<?php endforeach;?>
					<?php endif;?>
					
					
					<?php if(!empty($tour['bpv_promotions'])):?>
						<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
							<p>
								<?=load_marketing_pro_tooltip($bpv_pro, $tour['cruise_id'])?>
							</p>
						<?php endforeach;?>
					<?php endif;?>
					
					
					<?=show_review($tour, cruise_tour_build_url($tour))?>
				</div>
				<div class="col-xs-2 price-info">
					<?php if (isset($tour['price_from'])):?>
						<?php if ($tour['price_origin'] != $tour['price_from']):?>
						<div class="bpv-price-origin">
							<?=bpv_format_currency($tour['price_origin'])?>
						</div>
						<?php endif;?>
						
						<div class="bpv-price-from margin-bottom-10">
							<?=bpv_format_currency($tour['price_from'])?>
							<small style="font-size: 12px; float: right; margin-bottom: 10px; color: #333"><?=lang('/pax')?></small>
						</div>
						
						<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
							href="<?=cruise_tour_build_url($tour, $search_criteria)?>">
							<?=lang('btn_book_now')?>
						</a>
					<?php else:?>
						<?php 
							$params = get_contact_params($tour, $search_criteria);
						?>
						
						<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
							href="<?=cruise_tour_build_url($tour)?>">
							<?=lang('btn_view_now')?>
						</a>
							
					<?php endif;?>
				</div>
			</div>
			<?php endforeach;?>
			<div class="col-xs-12 view-more">
				<a href="<?=get_url(CRUISE_HL_SEARCH_PAGE, $halong_des['url_params'])?>">
					<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
					<?=lang_arg('view_more_cruise_tour_in_des', $halong_des['name'])?>
				</a>
			</div>
		</div>
</div>

<script type="text/javascript">
$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
</script>
<?php endif;?>