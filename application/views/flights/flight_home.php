<div class="container main-content">
	<div class="row margin-bottom-20 mod-search">
		<div class="col-xs-12">
			<?=$bpv_ads?>
		</div>
		
		<?=$bpv_search?>
	</div>
	
	<div class="row">
		<div class="col-xs-6">
			<?=$bpv_why_us?>
			
			<a target="_blank" href="/khuyen-mai.html?des_id=16&utm_source=bestprice&utm_medium=banner_flight_left_side&utm_content=deal_page&utm_campaign=km_70_off">
				<img class="margin-bottom-20 img-responsive" src="<?=get_static_resources('/media/banners/khuyen-mai-phu-quoc-01-07.jpg')?>">
			</a>
			
			<div class="bpv-newbox">
				<h3 class="bpv-color-title">
					<span class="icon icon-top-des"></span>
					<?=lang('popular_flight_routes')?>
				</h3>
				<table class="tb-flights">
					<thead>
						<tr>
							<th><?=lang('flight_column_route')?></th>
							<th class="text-center"><?=lang('flight_column_airlines')?></th>
							<th style="border-right: 0"><?=lang('flight_column_from_price')?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($popular_routes as $k => $route):?>
					<?php
						$custom_css = '';
						
						if($k >= 0 && count($popular_routes) > 1 && ($k+1 < count($popular_routes))) {
							$custom_css = 'class="bold-border"';
						}
					?>
					<tr>
						<td rowspan="<?=count($route['basic_prices']) +1?>" <?=$custom_css?>>
							<b id="sl_from_des_<?=$route['id']?>"><?=$route['from_des']?></b> - <b id="sl_to_des_<?=$route['id']?>"><?=$route['to_des']?></b>
						</td>
						</tr>
							<?php foreach ($route['basic_prices'] as $z => $price):?>
							<tr>
								<td <?php if($z+1==count($route['basic_prices'])) echo $custom_css?>>
									<?php 
										if($price['airline_id'] == 1) {
											$src = '/media/flight/VN.gif';
										} elseif($price['airline_id'] == 2) {
											$src = '/media/flight/BL.gif';
										} else {
											$src = '/media/flight/VJ.gif';
										}
									?>
									<img src="<?=get_static_resources($src)?>" class="floatL" id="sl_airline_img_<?=$route['id']?>_<?=$price['airline_id']?>">
					
									<span class="floatL" id="sl_airline_name_<?=$price['airline_id']?>"><?=$price['name']?></span>
								</td>
								<td align="right" <?php if($z+1==count($route['basic_prices'])) echo $custom_css?> style="border-right: 0">
									<span class="bpv-price-from" style="font-size: 14px"><?=bpv_format_currency($price['price'])?></span>
									<button class="btn btn-select" type="button" data-from="<?=$route['from_des']?>" data-to="<?=$route['to_des']?>"
										onclick="select_destination_flight(this, '<?=$route['id']?>', '<?=$price['airline_id']?>', '<?=$price['code']?>', '<?=$route['from_code']?>', '<?=$route['to_code']?>')">
									<?=lang('btn_flight_select')?>
									<span class="icon icon-arrow-right"></span>
									</button>
								</td>
							</tr>
							<?php endforeach;?>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
			
		</div>
		
		<div class="col-xs-6">
			<?php if(!empty($lst_news)):?>
			<div class="bpv-unbox">
				<h2 class="bpv-color-promotion"><?=lang('deal_messages')?></h2>
				<ul class="list-unstyled flight-news">
					<?php foreach ($lst_news as $news):?>
					
					<?php if(!empty($news['picture'])):?>
						<li style="padding: 10px 0">
							<div class="row">
								<div class="col-xs-3">
									<img class="img-responsive" src="<?=get_image_path(NEWS_PHOTO, $news['picture'], '120x80')?>">
								</div>
								<div class="col-xs-9" style="padding-left: 0">
									<h4 class="bpv-color-title" style="margin-top: 0">
									<a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
									</h4>
									<p><?=content_shorten($news['short_description'], NEWS_MAX_LENGTH)?></p>
								</div>
							</div>
						</li>	
						<?php else:?>
						<li>
							<h4 class="bpv-color-title">
								<a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
							</h4>
							<p><?=content_shorten($news['short_description'], NEWS_MAX_LENGTH)?></p>
						</li>
					<?php endif;?>
					
						
					
					<?php endforeach;?>
				</ul>
			</div>
			<?php endif;?>
			
			<?=load_hotline_suport(FLIGHT, false)?>
			
		</div>
	</div>
	
	<?=$search_dialog?>

	<?=$footer_links?>
</div>

<?=$bpv_register?>