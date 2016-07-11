<p><?=lang('flight_baggage_note')?>:</p>

<?php 
	$selected_baggage_fees = isset($flight_booking['prices']['baggage_fee'])? $flight_booking['prices']['baggage_fee'] : '';
	$baggage_fees_depart = isset($selected_baggage_fees['depart'])?$selected_baggage_fees['depart'] : array();
	$baggage_fees_return = isset($selected_baggage_fees['return'])?$selected_baggage_fees['return'] : array();
	$flight_departure = $flight_booking['flight_departure'];
	$fees = $baggage_fee_cnf[$flight_departure['airline']];
?>
<div class="margin-bottom-10">
	<h3 class="text-highlight"><?=lang_arg('baggage_fees_depart', $search_criteria['From'], $search_criteria['To'])?></h3>
</div>
<div class="margin-bottom-10">
	<div><b>+ <?=lang('hand_baggage')?></b>:&nbsp;<?=$fees['hand']?></div>
</div>

<div class="margin-bottom-20">
	<div class="margin-bottom-10"><b>+ <?=lang('send_baggage')?></b>:</div>
	<div>
		<?php if(!is_array($fees['send'])):?>
		
			<?=$fees['send']?>
			
		<?php else:?>
			
			<?php for ($i=1; $i <= ($search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF']); $i++):?>
				
				<div class="row margin-bottom-10">
					
					<div class="col-xs-5 bag-pas-<?=$i?>" style="padding-top:7px" txtval="<?=lang('passenger')?> <?=$i?>">
						<?=lang('passenger')?> <?=$i?>
					</div>
					<div class="col-xs-7">
						<select class="form-control baggage-fees input-sm" name="baggage_depart_<?=$i?>" onchange="change_baggage('<?=lang('vnd')?>')">
							<option fee='0' value=""><?=lang('no_baggage')?></option>
							<?php foreach ($fees['send'] as $kg=>$money):?>
								
								<?php 
									$selected = isset($baggage_fees_depart[$i]) && $baggage_fees_depart[$i]['kg'] == $kg;									
								?>
								
								<option value="<?=$kg?>" fee='<?=$money['usd']?>' <?=set_select('baggage_depart_'.$i, $kg, $selected)?>><?=lang_arg('send_baggage_value', $kg, number_format($money['usd']))?></option>
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
		<h3 class="text-highlight"><?=lang_arg('baggage_fees_return', $search_criteria['To'], $search_criteria['From'])?></h3>
	</div>
	
	<div class="margin-bottom-10">
		<div><b>+ <?=lang('hand_baggage')?></b>:&nbsp;<?=$fees['hand']?></div>
	</div>
	
	<div class="margin-bottom-20">		
		<div class="margin-bottom-10">+ <b><?=lang('send_baggage')?></b>:</div>
		
		<div>		
			<?php if(!is_array($fees['send'])):?>
			
				<?=$fees['send']?>
				
			<?php else:?>
				
				<?php for ($i=1; $i <= ($search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF']); $i++):?>
					
					<div class="row margin-bottom-10">
						
						<div class="col-xs-5 bag-pas-<?=$i?>" style="padding-top:7px" txtval="<?=lang('passenger')?> <?=$i?>">
							<?=lang('passenger')?> <?=$i?>
						</div>
						<div class="col-xs-7">
							<select class="form-control baggage-fees input-sm" name="baggage_return_<?=$i?>" onchange="change_baggage('<?=lang('vnd')?>')">
								<option fee='0'  value=""><?=lang('no_baggage')?></option>
								<?php foreach ($fees['send'] as $kg=>$money):?>
									
									<?php 
										$selected = isset($baggage_fees_return[$i]) && $baggage_fees_return[$i]['kg'] == $kg;
									?>
								
									<option value="<?=$kg?>" fee='<?=$money['usd']?>' <?=set_select('baggage_return_'.$i, $kg, $selected)?>><?=lang_arg('send_baggage_value', $kg, number_format($money['usd']))?></option>
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
	update_flight_baggage_pas_first_name();
	update_flight_baggage_pas_last_name();
</script>