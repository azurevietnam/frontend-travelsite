<?php 
	$selected_flight = $flight_booking['selected_flight'];
?>

<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
	<h4 class="bpv-color-title">
		<?=lang_arg('flight_itineray_depart', $search_criteria['From'], $search_criteria['To'])?>,
		<?=$selected_flight['depart_routes'][0]['DayFrom']?>/<?=$selected_flight['depart_routes'][0]['MonthFrom']?>
	</h4>
<?php endif;?>

<div class="tbl-header">
	<span class="tbl-airline"><?=lang('tbl_airline')?></span>
	<span class="tbl-code"><?=lang('tbl_flight_code')?></span>
	<span class="tbl-itinerary"><?=lang('tbl_itineray')?></span>
	<span class="tbl-departure-date"><?=lang('tbl_departure_date')?></span>
	<span class="tbl-departure-time"><?=lang('tbl_departure_time')?></span>
	<span class="tbl-arrival-time"><?=lang('tbl_arrival_time')?></span>			
</div>

<?php foreach ($selected_flight['depart_routes'] as $key=>$route):?>

	<div class="tbl-row">
		<span class="tbl-airline">
			<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
			<span><?=$route['FlightCode']?></span>
		</span>
		<span class="tbl-code">
			<?=$route['Airlines'].'-'.$route['FlightCodeNum']?>
		</span>
		
		<span class="tbl-itinerary">
			<?=lang('flight_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_to')?>: <b><?=$route['To']?></b>
		</span>
		
		<span class="tbl-departure-date">
			<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
		</span>
		
		<span class="tbl-departure-time">
			<?=flight_time_format($route['TimeFrom'])?>
		</span>
		<span class="tbl-arrival-time">
			<?=flight_time_format($route['TimeTo'])?>
		</span>
		
	</div>
	
	<?php if(isset($selected_flight['depart_routes'][$key + 1])):?>
				
		<?php 
			$next_route = $selected_flight['depart_routes'][$key + 1];
			
			$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
		?>
					
		<div class="tbl-row text-right">
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

		<div class="tbl-row" <?php if($key == 0):?>style="border-top:1px solid #DDD"<?php endif;?>>
			<span class="tbl-airline">
				<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
			</span>
			<span class="tbl-code">
				<?=$route['Airlines'].'-'.$route['FlightCodeNum']?>
			</span>
			
			<span class="tbl-itinerary">
				<?=lang('flight_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_to')?>: <b><?=$route['To']?></b>
			</span>
			
			<span class="tbl-departure-date">
				<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
			</span>
			
			<span class="tbl-departure-time">
				<?=flight_time_format($route['TimeFrom'])?>
			</span>
			<span class="tbl-arrival-time">
				<?=flight_time_format($route['TimeTo'])?>
			</span>
			
		</div>
		
		<?php if(isset($selected_flight['return_routes'][$key + 1])):?>
				
			<?php 
				$next_route = $selected_flight['return_routes'][$key + 1];
				
				$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
			?>
						
			<div class="tbl-row text-right">
				<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
			</div>
			
		<?php endif;?>
	
	<?php endforeach;?>
	
<?php endif;?>