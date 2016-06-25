<div class="container main-content">
	
	<ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li class="active"><?=lang('flights_to_text').$destination['name']?></li>
	</ol>
	
	<div class="bpv-col-left margin-bottom-20">
		<?=$bpv_search?>
		
		<div class="margin-top-20">
			<a target="_blank" href="<?=get_url(NEWS_HOME_PAGE, $n_book_together)?>">
				<img class="img-responsive" src="<?=get_static_resources('/media/flight/flights-deal.jpg')?>">
			</a>
		</div>
	</div>
	
	<div class="bpv-col-right margin-bottom-20">
		
		<div class="flight-content">
			<h1 class="bpv-color-title no-margin"><?=lang('flights_to_text').$destination['name']?></h1>
			<div class="margin-top-10 margin-bottom-20">
			<?php
				$tips = $destination['flight_tips'];
				echo str_replace("\n", "<p/>", $tips);
			?>
			</div>
			<?php if(!empty($popular_routes)):?>
			<div class="bpv-box flight-box">
				<h3 class="bpv-color-title">
					<span class="icon icon-popular-flight"></span>
					<?=lang('popular_flight_des_routes') . $destination['name']?>
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
						
										<label class="floatL" id="sl_airline_name_<?=$price['airline_id']?>"><?=$price['name']?></label>
									</td>
									<td align="right" <?php if($z+1==count($route['basic_prices'])) echo $custom_css?> style="border-right: 0">
										<span class="bpv-price-from" style="font-size: 14px"><?=bpv_format_currency($price['price'])?></span>
										<button class="btn btn-select" type="button" data-from="<?=$route['from_des']?>" data-to="<?=$route['to_des']?>"
											onclick="select_destination_flight(this, '<?=$route['id']?>', '<?=$price['airline_id']?>', '<?=$price['code']?>', '<?=$route['from_code']?>', '<?=$route['to_code']?>')">
										<?=lang('btn_flight_select')?>
										<span class="icon icon-arrow-right"></span></button>
									</td>
								</tr>
								<?php endforeach;?>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			
			<p class="bpv-color-title pull-right" style="font-size: 11px"><?=lang('popular_flight_routes_note')?></p>
			<?php endif;?>
		</div>
		
		<div class="flight-content-right">
			<?=load_hotline_suport(FLIGHT)?>
			
			<div class="bpv-box bpv-box-payment">
				<h3 class="bpv-color-title">
					<?=lang('payment_methods')?>
				</h3>
				<ul class="list-unstyled">
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_cash')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_at_home')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_bank_transfer')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_credit_card')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_domestic_card')?></li>
				</ul>
			</div>
		</div>
	</div>
	
	<?=$search_dialog?>
	
	<?=$footer_links?>
</div>

<?=$bpv_register?>