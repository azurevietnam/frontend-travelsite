<div class="tbl-header">
	<span class="tbl-airline"><?=lang('tbl_airline')?></span>
	<span class="tbl-code"><?=lang('tbl_flight_code')?></span>
	<span class="tbl-itinerary"><?=lang('tbl_itineray')?></span>
	<span class="tbl-departure-date"><?=lang('tbl_departure_date')?></span>
	<span class="tbl-departure-time"><?=lang('tbl_departure_time')?></span>
	<span class="tbl-arrival-time"><?=lang('tbl_arrival_time')?></span>			
</div>

<?php 
	$flight_departure = $flight_booking['flight_departure'];
	$detail = $flight_departure['detail'];
?>

<?php foreach ($detail['routes'] as $key=>$route):?>

	<div class="tbl-row">
		<span class="tbl-airline"><span class="flight-<?=$flight_departure['airline']?>"></span></span>
		<span class="tbl-code"><?=$route['airline']?></span>
		<span class="tbl-itinerary"><?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> <br><?=lang('flight_to')?>: <b><?=$route['to']['city']?></b></span>
		<span class="tbl-departure-date"><?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?></span>
		<span class="tbl-departure-time"><?=$route['from']['time']?></span>
		<span class="tbl-arrival-time"><?=$route['to']['time']?></span>
		
		<?php if(!empty($detail['fare_rules'])):?>
		
			<div class="tbl-fare-rules"><a id="txt_departure_<?=$key?>" href="javascript:show_fare_rules('departure_<?=$key?>')"><?=lang('show_fare_rules')?></a></div>
			
			<div class="tbl-fare-rules" style="display:none" id="fare_rules_departure_<?=$key?>" show="hide">
				<?=$detail['fare_rules']?>
			</div>
		
		<?php endif;?>
		
	</div>

<?php endforeach;?>


<?php if(!empty($flight_booking['flight_return'])):?>
	<?php 
		$flight_departure = $flight_booking['flight_return'];
		$detail = $flight_departure['detail'];
	?>
	
	<?php foreach ($detail['routes'] as $key=>$route):?>
	
		<div class="tbl-row">
			<span class="tbl-airline"><span class="flight-<?=$flight_departure['airline']?>"></span></span>
			<span class="tbl-code"><?=$route['airline']?></span>
			<span class="tbl-itinerary"><?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> <br><?=lang('flight_to')?>: <b><?=$route['to']['city']?></b></span>
			<span class="tbl-departure-date"><?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?></span>
			<span class="tbl-departure-time"><?=$route['from']['time']?></span>
			<span class="tbl-arrival-time"><?=$route['to']['time']?></span>
			
			<?php if(!empty($detail['fare_rules'])):?>
			
				<div class="tbl-fare-rules"><a id="txt_return_<?=$key?>" href="javascript:show_fare_rules('return_<?=$key?>')"><?=lang('show_fare_rules')?></a></div>
				
				<div class="tbl-fare-rules" style="display:none" id="fare_rules_return_<?=$key?>" show="hide">
					<?=$detail['fare_rules']?>
				</div>
			
			<?php endif;?>
			
		</div>
	
	<?php endforeach;?>

<?php endif;?>