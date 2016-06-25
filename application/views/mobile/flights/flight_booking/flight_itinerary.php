
<?php 
	$flight_departure = $flight_booking['flight_departure'];
	$detail = $flight_departure['detail'];
?>

<?php foreach ($detail['routes'] as $key=>$route):?>
	<div class="flight-i-route">
		
		<div class="row">
			<div class="col-xs-2">
				<span class="flight-<?=$flight_departure['airline']?>"></span>
			</div>
			<div class="col-xs-10">
				<?=$domistic_airlines[$flight_departure['airline']]?>
				&nbsp;
				<b><?=$route['airline']?></b>
			</div>
		</div>
		
		<div class="margin-bottom-10">
			<?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> - <?=lang('flight_to')?>: <b><?=$route['to']['city']?></b>
		</div>
		
		<div class="margin-bottom-10">
			<?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?>
			<?=$route['from']['time']?> - <?=$route['to']['time']?>
		</div>

		
		<?php if(!empty($detail['fare_rules'])):?>
			
			<div class="margin-bottom-10">
				<a id="txt_departure_<?=$key?>" href="javascript:show_fare_rules('departure_<?=$key?>')"><?=lang('show_fare_rules')?></a>
			</div>
			
			<div style="display:none" id="fare_rules_departure_<?=$key?>" show="hide">
				<?=$detail['fare_rules']?>
			</div>
		
		<?php endif;?>
	
	</div>
	
<?php endforeach;?>


<?php if(!empty($flight_booking['flight_return'])):?>
	<?php 
		$flight_return = $flight_booking['flight_return'];
		$detail = $flight_return['detail'];
	?>
	
	<?php foreach ($detail['routes'] as $key=>$route):?>
		<div class="flight-i-route">
		
			<div class="row">
				<div class="col-xs-2">
					<span class="flight-<?=$flight_return['airline']?>"></span>
				</div>
				
				<div class="col-xs-10">
					<?=$domistic_airlines[$flight_return['airline']]?>
					&nbsp;
					<b><?=$route['airline']?></b>
				</div>
			</div>
			
			<div class="margin-bottom-10">
				<?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> - <?=lang('flight_to')?>: <b><?=$route['to']['city']?></b>
			</div>
			
			<div class="margin-bottom-10">
				<?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?>
				<?=$route['from']['time']?> - <?=$route['to']['time']?>
			</div>
			
				
			<?php if(!empty($detail['fare_rules'])):?>
			
				<div class="margin-bottom-10">
					<a id="txt_return_<?=$key?>" href="javascript:show_fare_rules('return_<?=$key?>')"><?=lang('show_fare_rules')?></a>
				</div>
				
				<div style="display:none" id="fare_rules_return_<?=$key?>" show="hide">
					<?=$detail['fare_rules']?>
				</div>
			
			<?php endif;?>
		</div>
	<?php endforeach;?>

<?php endif;?>

<div class="flight-i-route fligh-i-total-price">
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

