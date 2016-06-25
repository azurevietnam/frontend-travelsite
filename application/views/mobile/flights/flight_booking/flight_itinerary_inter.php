<?php 
	$selected_flight = $flight_booking['selected_flight'];
?>

<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
	<h4 class="bpv-color-title">
		<?=lang_arg('flight_itineray_depart', $search_criteria['From'], $search_criteria['To'])?>,
		<?=$selected_flight['depart_routes'][0]['DayFrom']?>/<?=$selected_flight['depart_routes'][0]['MonthFrom']?>
	</h4>
<?php endif;?>

<?php foreach ($selected_flight['depart_routes'] as $key=>$route):?>

	<div class="flight-i-route">
		
		<div class="row margin-bottom-10">
			<div class="col-xs-2">
				<img style="margin-top:-5px" src="<?=get_logo_of_flight_company($route['Airlines'])?>">
			</div>
			
			<div class="col-xs-10">
				<?=$route['FlightCode']?>
				&nbsp;
				<b><?=$route['Airlines'].'-'.$route['FlightCodeNum']?></b>
			</div>
		</div>
		
		<div class="margin-bottom-10">
			<?=lang('flight_from')?>: <b><?=$route['From']?></b> <?=lang('flight_to')?>: <b><?=$route['To']?></b>
		</div>
		
		<div class="margin-bottom-10">
			<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
			<b><?=flight_time_format($route['TimeFrom'])?> - <?=flight_time_format($route['TimeTo'])?></b>
		</div>
	
	</div>
	
	
	<?php if(isset($selected_flight['depart_routes'][$key + 1])):?>
				
		<?php 
			$next_route = $selected_flight['depart_routes'][$key + 1];
			
			$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
		?>
					
		<div class="flight-i-route text-right">
			<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
		</div>
		
	<?php endif;?>
			

<?php endforeach;?>


<?php if(!empty($selected_flight['return_routes'])):?>

	<h4 class="bpv-color-title margin-top-20">
		<?=lang_arg('flight_itineray_return', $search_criteria['To'], $search_criteria['From'])?>, 
		<?=$selected_flight['return_routes'][0]['DayFrom']?>/<?=$selected_flight['return_routes'][0]['MonthFrom']?>
	</h4>
	
	<?php foreach ($selected_flight['return_routes'] as $key=>$route):?>

		<div class="flight-i-route">
			<div class="row margin-bottom-10">
				<div class="col-xs-2">
					<img style="margin-top:-5px" src="<?=get_logo_of_flight_company($route['Airlines'])?>">
				</div>
				
				<div class="col-xs-10">
					<?=$route['FlightCode']?>
					&nbsp;
					<?=$route['Airlines'].'-'.$route['FlightCodeNum']?>
				</div>
			</div>
			
			<div class="margin-bottom-10">
				<?=lang('flight_from')?>: <b><?=$route['From']?></b> <?=lang('flight_to')?>: <b><?=$route['To']?></b>
			</div>
			
			<div class="margin-bottom-10">
				<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
				<b><?=flight_time_format($route['TimeFrom'])?> - <?=flight_time_format($route['TimeTo'])?></b>
			</div>
			
		</div>
		
		<?php if(isset($selected_flight['return_routes'][$key + 1])):?>
				
			<?php 
				$next_route = $selected_flight['return_routes'][$key + 1];
				
				$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
			?>
						
			<div class="flight-i-route text-right">
				<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
			</div>
			
		<?php endif;?>
	
	<?php endforeach;?>
	
<?php endif;?>

<div class="flight-i-route fligh-i-total-price margin-top-10">
	<span style="font-weight:bold"><?=lang('price_total')?>:</span>
			
	<?php 
		$prices = $flight_booking['prices'];
		$total_price = $prices['total_price'];
	?>
	
	<span class="bpv-price-from"><?=bpv_format_currency($total_price)?></span>
	
	<div>
		*<?=lang('flight_price_include')?>
	</div>
</div>

<div class="margin-top-10 text-right">
	<a href="<?=get_current_flight_search_url($search_criteria)?>" style="text-decoration:underline">
		<span class="glyphicon glyphicon-edit"></span>
		<?=lang('change_flight')?>
	</a>
</div>