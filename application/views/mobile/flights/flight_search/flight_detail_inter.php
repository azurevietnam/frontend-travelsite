<div class="flight-price margin-bottom-20">
	<div class="row margin-bottom-10">	
		<div class="col-xs-6"><?=$search_criteria['ADT']?> <?=lang('search_fields_adults')?>:</div>
		<div class="col-xs-6 price-value text-right"><?=bpv_format_currency($prices['adult_fare_total'])?></div>
	</div>
	<?php if($search_criteria['CHD'] > 0):?>
	<div class="row margin-bottom-10">	
		<div class="col-xs-6"><?=$search_criteria['CHD']?> <?=lang('search_fields_children')?>:</div>
		<div class="col-xs-6 price-value text-right"><?=bpv_format_currency($prices['children_fare_total'])?></div>
	</div>
	<?php endif;?>
	
	<?php if($search_criteria['INF'] > 0):?>
	<div class="row margin-bottom-10">	
		<div class="col-xs-6"><?=$search_criteria['INF']?> <?=lang('search_fields_infants')?>:</div>
		<div class="col-xs-6 price-value text-right"><?=bpv_format_currency($prices['infant_fare_total'])?></div>
	</div>
	<?php endif;?>
	
	<div class="row margin-bottom-10">	
		<div class="col-xs-6"><?=lang('tax_fee')?>:</div>
		<div class="col-xs-6 price-value text-right"><?=bpv_format_currency($prices['total_tax'])?></div>
	</div>
	
	<?php if($prices['total_discount'] > 0):?>
	<div class="row margin-bottom-10">	
		<div class="col-xs-6"><b><?=lang('price_discount')?>:</b></div>
		<div class="col-xs-6 price-value bpv-color-price text-right">- <?=bpv_format_currency($prices['total_discount'])?></div>
	</div>
	<?php endif;?>
	
	<div style="border-top: 1px solid #c8c8c8;" class="margin-bottom-10"></div>
	
	<div class="row">	
		<div class="col-xs-6 label-total text-right"><?=lang('price_total')?>:</div>
		<div class="col-xs-6 price-total text-right bpv-color-price" style="padding-left:0">
			<?=bpv_format_currency($prices['total_price'])?>
		</div>
	</div>
</div>
		
	<h3 class="bpv-color-title  margin-bottom-10" style="background-color:#eee;padding:5px 10px;margin-top:0"><?=lang_arg('flight_itineray_depart', $search_criteria['From'], $search_criteria['To'])?>:</h3>
	
	<?php foreach($flight['depart_routes'] as $key=>$route):?>
		<div class="row margin-bottom-10">
			<div class="col-xs-6">
				<div class="margin-bottom-5">
					<?=lang('flight_from')?>: <b><?=$route['From']?></b>
				</div>
				
				<div class="margin-bottom-5">
					<?=lang('airport')?>: <?=$route['AirportFrom']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=flight_time_format($route['TimeFrom'])?></b> <?=flight_date($route['DayFrom'], $route['MonthFrom'])?>
				</div>
				
				<div class="margin-bottom-5">
					<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
					<span><?=$route['FlightCode']?> (<?=$route['Airlines'].'-'.$route['FlightCodeNum']?>)</span>	
				</div>
			</div>
			
			<div class="col-xs-6">
				<div class="margin-bottom-5">
					<?=lang('flight_to')?>: <b><?=$route['To']?></b>
				</div>
				
				<div class="margin-bottom-5">
					<?=lang('airport')?>: <?=$route['AirportTo']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=flight_time_format($route['TimeTo'])?></b> <?=flight_date($route['DayTo'], $route['MonthTo'])?>
				</div>
			</div>
		</div>
		
		<?php if(isset($flight['depart_routes'][$key + 1])):?>
			
			<?php 
				$next_route = $flight['depart_routes'][$key + 1];
				
				$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
			?>
						
			<div class="row margin-bottom-10">
				<div class="col-xs-12 text-right">
					<div style="border: 1px dashed #CCC; padding: 5px 15px;border-right:0;border-left:0">
						<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
					</div>
				</div>
			</div>
			
		<?php endif;?>

	<?php endforeach;?>
	
	
	<?php if(count($flight['return_routes']) > 0):?>

	<h3 class="bpv-color-title  margin-top-10" style="background-color:#eee;padding:5px 10px"><?=lang_arg('flight_itineray_return', $search_criteria['To'], $search_criteria['From'])?>:</h3>
	
	<?php foreach($flight['return_routes'] as $key=>$route):?>
		<div class="row margin-bottom-10">
			<div class="col-xs-6">
				<div class="margin-bottom-5">
					<?=lang('flight_from')?>: <b><?=$route['From']?></b>
				</div>
				
				<div class="margin-bottom-5">
					<?=lang('airport')?>: <?=$route['AirportFrom']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=flight_time_format($route['TimeFrom'])?></b> <?=flight_date($route['DayFrom'], $route['MonthFrom'])?>
				</div>
				
				<div class="margin-bottom-5">
					<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
					<span><?=$route['FlightCode']?> (<?=$route['Airlines'].'-'.$route['FlightCodeNum']?>)</span>	
				</div>
			</div>
			
			<div class="col-xs-6">
				<div class="margin-bottom-5">
					<?=lang('flight_to')?>: <b><?=$route['To']?></b>
				</div>
				
				<div class="margin-bottom-5">
					<?=lang('airport')?>: <?=$route['AirportTo']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=flight_time_format($route['TimeTo'])?></b> <?=flight_date($route['DayTo'], $route['MonthTo'])?>
				</div>
			</div>
		</div>
		
		<?php if(isset($flight['return_routes'][$key + 1])):?>
			
			<?php 
				$next_route = $flight['return_routes'][$key + 1];
				
				$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
			?>
						
			<div class="row margin-bottom-10">
				<div class="col-xs-12 text-right">
					<div style="border: 1px dashed #CCC; padding: 5px 15px;border-right:0;border-left:0">
						<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
					</div>
				</div>
			</div>
			
		<?php endif;?>

	<?php endforeach;?>
	
	
	<?php endif;?>
