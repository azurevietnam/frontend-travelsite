<?php 
	$flight_departure = $flight_booking['flight_departure'];
	$detail = $flight_departure['detail'];
?>

<?php foreach ($detail['routes'] as $key=>$route):?>
	<?php 
		if($flight_departure['airline'] == 'VN'){
			$route['airline_name'] = 'Vietnam Ariline';
		}else if ($flight_departure['airline'] == 'VJ'){
			$route['airline_name'] = 'Vietjet Ari';
		} else {
			$route['airline_name'] = 'Jestar';
		}
	?>
	<div class="tbl-row padding-bottom-10">
		<div>
			<span class="tbl-airline"><span class="flight-<?=$flight_departure['airline']?>"></span></span>
			<span> <?=$route['airline_name']?> &nbsp;</span>
			<span class="tbl-code"><b><?=$route['airline']?></b></span>	
		</div>
		<div>
			<span class="tbl-itinerary"><?=lang('flight_label_from')?>: <b><?=$route['from']['city']?></b> - 
			<?=lang('flight_label_to')?>: <b><?=$route['to']['city']?></b></span>	
		</div>
		<div class="margin-bottom-5">
			<span class="tbl-departure-date"><?=date(FLIGHT_DATE_FORMAT, strtotime($route['from']['date']))?></span>, 
			<span class="tbl-departure-time"><?=$route['from']['time']?></span> -
			<span class="tbl-arrival-time"><?=$route['to']['time']?></span>
		</div>
		
		<?php if(!empty($detail['fare_rules'])):?>
		
			<div class="tbl-fare-rules"><a id="txt_departure_<?=$key?>" href="javascript:show_fare_rules('departure_<?=$key?>')"><?=lang('flight_show_fare_rules')?></a></div>
			
			<div class="tbl-fare-rules margin-top-10" style="display:none" id="fare_rules_departure_<?=$key?>" show="hide">
				<?=$detail['fare_rules']?>
			</div>
		
		<?php endif;?>
		
	</div>

<?php endforeach;?>


<?php if($search_criteria['Type'] == 'roundway'):?>
	<?php 
		$flight_departure = $flight_booking['flight_return'];
		$detail = $flight_departure['detail'];		
	?>
	
	<?php foreach ($detail['routes'] as $key=>$route):?>
		<?php 
			if($flight_departure['airline'] == 'VN'){
				$route['airline_name'] = 'Vietnam Ariline';
			}else if ($flight_departure['airline'] == 'VJ'){
				$route['airline_name'] = 'Vietjet Ari';
			} else {
				$route['airline_name'] = 'Jestar';
			}
		?>
		<div class="tbl-row" style="padding-top:5px; border-top:1px dashed #CCC;">
			<div>
				<span class="tbl-airline"><span class="flight-<?=$flight_departure['airline']?>"></span></span>
				<span> <?=$route['airline_name']?> &nbsp;</span>
				<span class="tbl-code"><b><?=$route['airline']?></b></span>
			</div>
			<div>
				<span class="tbl-itinerary"><?=lang('flight_label_from')?>: <b><?=$route['from']['city']?></b> - <?=lang('flight_label_to')?>: <b><?=$route['to']['city']?></b></span>
			</div>
			<div class="margin-bottom-5">
				<span class="tbl-departure-date"><?=date(FLIGHT_DATE_FORMAT, strtotime($route['from']['date']))?></span>, 
				<span class="tbl-departure-time"><?=$route['from']['time']?></span> - 
				<span class="tbl-arrival-time"><?=$route['to']['time']?></span>
			</div>	
			<?php if(!empty($detail['fare_rules'])):?>
			
				<div class="tbl-fare-rules"><a id="txt_return_<?=$key?>" href="javascript:show_fare_rules('return_<?=$key?>')"><?=lang('flight_show_fare_rules')?></a></div>
				
				<div class="tbl-fare-rules margin-top-10" style="display:none" id="fare_rules_return_<?=$key?>" show="hide">
					<?=$detail['fare_rules']?>
				</div>
			
			<?php endif;?>
			
		</div>
	
	<?php endforeach;?>

<?php endif;?>