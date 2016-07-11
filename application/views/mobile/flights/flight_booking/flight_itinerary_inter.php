<?php 
	$selected_flight = $flight_booking['selected_flight'];
?>

<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
	<h4 class="bpv-color-title text-highlight  margin-bottom-10">
		<?=lang('flight_itineray') .' '.lang('label_from').' '. $search_criteria['From'] .' '.lang('label_to').' '. $search_criteria['To']?>:
		<?=$selected_flight['depart_routes'][0]['DayFrom']?>/<?=$selected_flight['depart_routes'][0]['MonthFrom']?>
	</h4>
<?php endif;?>


<?php foreach ($selected_flight['depart_routes'] as $key=>$route):?>

	<div class="tbl-row padding-bottom-10" style="padding-top:5px; border-top: 1px dashed #CCC;">
		<div class="tbl-airline">
			<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
			<span><?=$route['FlightCode']?></span>			
			<span><b><?=$route['Airlines'].'-'.$route['FlightCodeNum']?></b></span>
		</div>
		
		<div class="tbl-itinerary">
			<?=lang('flight_label_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_label_to')?>: <b><?=$route['To']?></b>
		</div>
		
		<div class="tbl-departure-date">
			<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>,  
			<?=flight_time_format($route['TimeFrom'])?> - <?=flight_time_format($route['TimeTo'])?>
		</div>
		
	</div>
	
	<?php if(isset($selected_flight['depart_routes'][$key + 1])):?>
				
		<?php 
			$next_route = $selected_flight['depart_routes'][$key + 1];
			
			$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
		?>
					
		<div class="tbl-row text-right" style="padding-top:5px; border-top: 1px dashed #CCC;">
			<?=lang('change_flight_info') .' <b>'.$next_route['From'] .'</b>.</br>'.lang('waiting_time').':<b> '. $delay['h'] .'h '. $delay['m'].'m</b>.'?>
		</div>
		
	<?php endif;?>
			

<?php endforeach;?>


<?php if(!empty($selected_flight['return_routes'])):?>

	<h4 class="bpv-color-title text-highlight margin-top-10" >
		<?=lang('flight_itineray') .' '.lang('label_from').' '. $search_criteria['To'] .' '.lang('label_to').' '. $search_criteria['From']?>:
		<?=$selected_flight['return_routes'][0]['DayFrom']?>/<?=$selected_flight['return_routes'][0]['MonthFrom']?>
	</h4>
	
	<?php foreach ($selected_flight['return_routes'] as $key=>$route):?>

		<div class="tbl-row padding-bottom-10" style="padding-top:5px; border-top: 1px dashed #CCC;">
			<div class="tbl-airline">
				<img src="<?=get_logo_of_flight_company($route['Airlines'])?>">
				<span><?=$route['FlightCode']?></span>			
				<span><b><?=$route['Airlines'].'-'.$route['FlightCodeNum']?></b></span>
			</div>
			
			<div class="tbl-itinerary">
				<?=lang('flight_label_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_label_to')?>: <b><?=$route['To']?></b>
			</div>
			
			<div class="tbl-departure-date">
				<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>, <?=flight_time_format($route['TimeFrom'])?> - <?=flight_time_format($route['TimeTo'])?>
			</div>

		</div>
		
		<?php if(isset($selected_flight['return_routes'][$key + 1])):?>
				
			<?php 
				$next_route = $selected_flight['return_routes'][$key + 1];
				
				$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
			?>
						
			<div class="tbl-row text-right" style="padding-top:5px; border-top: 1px dashed #CCC;">
				<?=lang('change_flight_info') .' <b>'.$next_route['From'] .'</b>.</br>'.lang('waiting_time').':<b> '. $delay['h'] .'h '. $delay['m'].'m</b>.'?>
			</div>
			
		<?php endif;?>
	
	<?php endforeach;?>
	
<?php endif;?>