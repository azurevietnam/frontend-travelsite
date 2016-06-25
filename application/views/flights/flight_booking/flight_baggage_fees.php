<p><?=lang('flight_baggage_note')?>:</p>

<?php 
	
	$selected_baggage_fees = isset($flight_booking['baggage_fees'])? $flight_booking['baggage_fees'] : '';
	$baggage_fees_depart = isset($selected_baggage_fees['depart'])?$selected_baggage_fees['depart'] : array();
	$baggage_fees_return = isset($selected_baggage_fees['return'])?$selected_baggage_fees['return'] : array();

	$flight_departure = $flight_booking['flight_departure'];
	$fees = $baggage_fee_cnf[$flight_departure['airline']];
?>
<div class="margin-bottom-10">
	<b><?=lang_arg('baggage_fees_depart', $search_criteria['From'], $search_criteria['To'])?></b>
</div>
<div class="row margin-bottom-10">
	<div class="col-xs-3" style="width:177px">&nbsp;&nbsp;+ <?=lang('hand_baggage')?>:</div>
	<div class="col-xs-9"><?=$fees['hand']?></div>
</div>

<div class="row margin-bottom-20">
	<div class="col-xs-3" style="width:177px">&nbsp;&nbsp;+ <?=lang('send_baggage')?>:</div>
	<div class="col-xs-9">
		<?php if(!is_array($fees['send'])):?>
		
			<?=$fees['send']?>
			
		<?php else:?>
			
			<?php for ($i=1; $i <= ($search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF']); $i++):?>
				
				<div class="row margin-bottom-10">
					
					<div class="col-xs-3 bag-pas-<?=$i?>" style="padding-top:7px" txtval="<?=lang('passenger')?> <?=$i?>">
						<?=lang('passenger')?> <?=$i?>
					</div>
					<div class="col-xs-5">
						<select class="form-control baggage-fees input-sm" name="baggage_depart_<?=$i?>" onchange="change_baggage('<?=lang('vnd')?>')">
							<option fee='0' value=""><?=lang('no_baggage')?></option>
							<?php foreach ($fees['send'] as $kg=>$money):?>
								
								<?php 
									$selected = isset($baggage_fees_depart[$i]) && $baggage_fees_depart[$i]['kg'] == $kg;
								?>
								
								<option value="<?=$kg?>" fee='<?=$money?>' <?=set_select('baggage_depart_'.$i, $kg, $selected)?>><?=lang_arg('send_baggage_value', $kg, number_format($money))?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
			
			<?php endfor;?>
			
		<?php endif;?>
	</div>
</div>

<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY && !empty($flight_booking['flight_return'])):?>
	
	<?php 
		$flight_return = $flight_booking['flight_return'];
		$fees = $baggage_fee_cnf[$flight_return['airline']];
	?>

	<div class="margin-bottom-10">
		<b><?=lang_arg('baggage_fees_return', $search_criteria['To'], $search_criteria['From'])?></b>
	</div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-3" style="width:177px">&nbsp;&nbsp;+ <?=lang('hand_baggage')?>:</div>
		<div class="col-xs-9"><?=$fees['hand']?></div>
	</div>
	
	<div class="row margin-bottom-20">
		<div class="col-xs-3" style="width:177px">&nbsp;&nbsp;+ <?=lang('send_baggage')?>:</div>
		<div class="col-xs-9">
			<?php if(!is_array($fees['send'])):?>
			
				<?=$fees['send']?>
				
			<?php else:?>
				
				<?php for ($i=1; $i <= ($search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF']); $i++):?>
					
					<div class="row margin-bottom-10">
						
						<div class="col-xs-3 bag-pas-<?=$i?>" style="padding-top:7px" txtval="<?=lang('passenger')?> <?=$i?>">
							<?=lang('passenger')?> <?=$i?>
						</div>
						<div class="col-xs-5">
							<select class="form-control baggage-fees input-sm" name="baggage_return_<?=$i?>" onchange="change_baggage('<?=lang('vnd')?>')">
								<option fee='0'  value=""><?=lang('no_baggage')?></option>
								<?php foreach ($fees['send'] as $kg=>$money):?>
									
									<?php 
										$selected = isset($baggage_fees_return[$i]) && $baggage_fees_return[$i]['kg'] == $kg;
									?>
								
									<option value="<?=$kg?>" fee='<?=$money?>' <?=set_select('baggage_return_'.$i, $kg, $selected)?>><?=lang_arg('send_baggage_value', $kg, number_format($money))?></option>
								<?php endforeach;?>
							</select>
						</div>
					</div>
				
				<?php endfor;?>
				
			<?php endif;?>
		</div>
	</div>
<?php endif;?>

<script type="text/javascript">
	update_flight_baggage_pas_name();
</script>