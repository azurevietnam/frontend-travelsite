<style type="text/css">
	.tour_check_rate .row{width: 708px;}
</style>
<script type="text/javascript">
	var tour_departure_1 = '';
	var tour_departure_up_stream_1 = '';
	var tour_departure_down_stream_1 = '';
	<?php if(!empty($service_1['departure'])):?>
		
		<?php $str_departure = getDepartureDate($service_1['departure'])?>
		
		<?php if(!empty($str_departure)):?>
		
		
			tour_departure_1 = <?=$str_departure;?>;
			
			<?php if(!is_roundtrip($service_1['departure'])):?>
			
				tour_departure_up_stream_1 = <?=json_encode(get_departure_date($service_1['departure'], 'UPSTREAM', 0, '', 'j-n-Y'));?>;
				
				tour_departure_down_stream_1 = <?=json_encode(get_departure_date($service_1['departure'], 'DOWNSTREAM', 0, '', 'j-n-Y'));?>;
				
			<?php endif;?>
			
		
		
		<?php endif;?>
	
	<?php endif;?>

	var tour_duration_1 = 0;
	<?php if(!empty($service_1['duration'])):?>
		tour_duration_1 = <?=$service_1['duration'] - 1?>;
	<?php endif;?>

	<?php if($mode == 2):?>

		var tour_departure_2 = '';
		var tour_departure_up_stream_2 = '';
		var tour_departure_down_stream_2 = '';
		<?php if(!empty($service_2['departure'])):?>
			
			<?php $str_departure = getDepartureDate($service_2['departure'])?>
			
			<?php if(!empty($str_departure)):?>
			
			
				tour_departure_2 = <?=$str_departure;?>;
				
				<?php if(!is_roundtrip($service_2['departure'])):?>
				
					tour_departure_up_stream_2 = <?=json_encode(get_departure_date($service_2['departure'], 'UPSTREAM', 0, '', 'j-n-Y'));?>;
					
					tour_departure_down_stream_2 = <?=json_encode(get_departure_date($service_2['departure'], 'DOWNSTREAM', 0, '', 'j-n-Y'));?>;
					
				<?php endif;?>
				
			
			
			<?php endif;?>
		
		<?php endif;?>
	
		var tour_duration_2 = 0;
		<?php if(!empty($service_2['duration'])):?>
			tour_duration_2 = <?=$service_2['duration'] - 1?>;
		<?php endif;?>
	
	<?php endif;?>

</script>

<?php 
	
	$start_date_id_1 = '#departure_day_check_rates_'.$service_1['id'];
	
	$start_month_id_1 = '#departure_month_check_rates_'.$service_1['id'];
	
	$departure_date_id_1 = '#departure_date_check_rates_'.$service_1['id'];
	
	
	if ($mode == 2){
		
		$start_date_id_2 = '#departure_day_check_rates_'.$service_2['id'];
	
		$start_month_id_2 = '#departure_month_check_rates_'.$service_2['id'];
		
		$departure_date_id_2 = '#departure_date_check_rates_'.$service_2['id'];
	
	}
	
?>


<input type="hidden" name="action_type" value="check_rate"/>

<div class="tour_check_rate" style="width: 718px;">
	
		<input type="hidden" name="object_change_1" id="object_change_<?=$service_1['id']?>" value="<?=isset($check_rates['object_change_1'])? $check_rates['object_change_1'] : 'change_person'?>">
		
		<input type="hidden" name="object_change_2" id="object_change_<?=$service_2['id']?>" value="<?=isset($check_rates['object_change_2'])? $check_rates['object_change_2'] : 'change_person'?>">
		
		<div class="row highlight">
			<b><?=lang('label_number_of_passenger')?>:</b> 
		</div>
		
		<div class="row">
			
			<div class="col80" style="margin-left: 40px;"><?=lang('adults')?>:</div>
			
			<div class="col60">
				<select name="adults" id="adults_<?=$service_1['id']?>" onchange="change_passenger('change_person')">
					<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
	                 <option value="<?=$i?>" <?=set_select('adults', $i, $check_rates['adults'] == $i? true: false)?>><?=$i?></option>
	                 <?php endfor;?>
	             </select>
			</div>
			
			<div class="col100">
				<?php if(isset($service_1['cruise']) && isset($service_1['cruise']['children_text']) && $service_1['cruise']['children_text'] != ''):?>
					<?=$service_1['cruise']['children_text']?>
				<?php else:?>
	            	<?=lang('children')?>
				<?php endif;?>
			:</div>
			
			<div class="col50">
				<select name="children" id="children_<?=$service_1['id']?>" onchange="change_passenger('change_person')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                <option value="<?=$i?>" <?=set_select('children', $i, $check_rates['children'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
			
			<div class="col80">
				<?php if(isset($service_1['cruise']) && isset($service_1['cruise']['infants_text']) && $service_1['cruise']['infants_text'] != ''):?>
					<?=$service_1['cruise']['infants_text']?>
				<?php else:?>
					<?=lang('infants')?>
				<?php endif;?>
			:</div>
			
			<div class="col50">
				<select name="infants" id="infants_<?=$service_1['id']?>" onchange="change_passenger('change_person')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                	<option value="<?=$i?>" <?=set_select('infants', $i, $check_rates['infants'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
			
		</div>
		
		<div class="row highlight">
			<b><?=$service_1['name']?>:</b> 
		</div>
		
		<div class="row">
			<div class="col120">
				<span style="margin-left:40px;"><?=lang('start')?>:</span>
			</div>
			<div class="col200">
				<select name="departure_day_check_rates" id="departure_day_check_rates_<?=$service_1['id']?>" onchange="changeDay('<?=$start_date_id_1?>', '<?=$start_month_id_1?>', '<?=$departure_date_id_1?>')">
					<option value=""><?=date('D, Y')?></option>
				</select>
				<select name="departure_month_check_rates" id="departure_month_check_rates_<?=$service_1['id']?>" onchange="changeMonth('<?=$start_date_id_1?>', '<?=$start_month_id_1?>', '<?=$departure_date_id_1?>','','',tour_departure_1)">
		            	<option value=""><?=date('M, Y')?></option>                 
		            </select>
		            &nbsp;<input type="hidden" id="departure_date_check_rates_<?=$service_1['id']?>" name="departure_date_check_rates_1"/>
			</div>
			
			<div class="col60"><?=lang('end')?>:</div>
			
			<div class="col170" id="tour_end_date_<?=$service_1['id']?>">
			</div>
		</div>
		
		<?php if (is_arrange_cabin($service_1) && isset($action) && $action == 'check_rate'):?>
		
			<div class="row" id="re_arrange_cabin_text_<?=$service_1['id']?>" <?=isset($check_rates['object_change_1']) && $check_rates['object_change_1'] == 'change_cabin'? 'style="display: none"' : ''?>>
				<div class="col120" style="margin-left: 40px;">
					<?=lang('cabin_arrangement')?>:
				</div>
				
				<div style="float:left; margin-right: 20px;">
					<ul style="float: left;">
					<?php foreach ($service_1['cabin_arangement']['cabins'] as $key => $cabin):?>
						<li style="padding-bottom: 5px;"><?=lang('label_cabin')?> <?=$key?>: <?=$cabin['arrangement']?></li>
					<?php endforeach;?>
					</ul>
				</div>
				
				<div id="re_arrange_cabin_guide_<?=$service_1['id']?>" <?=isset($check_rates['object_change_1']) && $check_rates['object_change_1'] == 'change_cabin'? 'style="display: none"' : ''?>>
					* <?=lang('label_re_arrange_your_cabins')?> <a href="javascript: void(0)" onclick="re_arrange_cabin('<?=$service_1['id']?>');"><?=lang('label_please_click_here')?></a>
				</div>
			</div>
			
			<div id="re_arrange_cabin_<?=$service_1['id']?>" <?=!isset($check_rates['object_change_1']) || $check_rates['object_change_1'] != 'change_cabin'? 'style="display: none"' : ''?>>
			
				<div class="row">
				
					<div class="col120" style="margin-left:40px;"><?=lang('label_number_of_cabin')?>:</div>
					
					<div class="col50">
						<select name="num_cabin_1" id="num_cabin_<?=$service_1['id']?>" onchange="change_cabin('<?=$service_1['id']?>', <?=CABIN_LIMIT?>)">
							<?php for ($i = 1; $i <= CABIN_LIMIT; ++$i) :?>
		                    <option value="<?=$i?>" <?php if($service_1['cabin_arangement']['num_cabin'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
		                    <?php endfor;?>
		                </select>
					
					</div>
					
					<div class="col20">
						<a href="javascript: void(0)" onclick="hide_re_arrange_cabin('<?=$service_1['id']?>')"><?=lang('label_hide_cabin_arrangement')?></a>
					</div>
				
				</div>
				
				<?php for($index = 1; $index <= CABIN_LIMIT; $index++):?>
						
						<?php 
						
							if (isset($service_1['cabin_arangement']['cabins'][$index])){
								$cabin = $service_1['cabin_arangement']['cabins'][$index];
							}
						
						?>
						
						<div class="row" <?php if($index > $service_1['cabin_arangement']['num_cabin']):?>style="display: none;"<?php endif;?>" id="<?=$service_1['id']?>_cabin_<?=$index?>">
							
							<div class="col100"><span style="margin-left:40px;"><?=lang('label_cabin')?> <?=$index?>:</span></div>
							
							<div class="col80">
								
								<select name="type_<?=$index?>_1" id="<?=$service_1['id']?>_type_<?=$index?>" onchange="change_passenger('change_cabin')">
									
									<?php foreach ($cabin_types as $k=>$value):?>
										<option value="<?=$k?>" <?php if ($index <= $service_1['cabin_arangement']['num_cabin'] && $cabin['type'] == $k):?> selected="selected" <?php endif;?>><?=translate_text($value)?></option>
									<?php endforeach;?>
								
				                </select>
							
							</div>						
							
							<div class="col50">
								<?=lang('adults')?>:
							</div>
							
							<div class="col50">
								
								<select name="adults_<?=$index?>_1" id="<?=$service_1['id']?>_adults_<?=$index?>" onchange="change_passenger('change_cabin')">
									
									<?php for ($i = 0; $i <= 2; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $service_1['cabin_arangement']['num_cabin'] && $cabin['adults'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
									<?php endfor;?>
									
								</select>
							
							</div>
							
							<div class="col100">
								<?php if(isset($cruise) && isset($cruise['children_text']) && $cruise['children_text'] != ''):?>
									<?=$cruise['children_text']?>
								<?php else:?>
					            	<?=lang('children')?>
								<?php endif;?>:
							</div>
							
							<div style="float: left; width: 50px;">
								
								<select name="children_<?=$index?>_1" id="<?=$service_1['id']?>_children_<?=$index?>" onchange="change_passenger('change_cabin')">
									
				                    <?php for ($i = 0; $i <= 3; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $service_1['cabin_arangement']['num_cabin'] && $cabin['children'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
									<?php endfor;?>
				                    
				                </select>
							
							</div>
							
							<div class="col80">
								<?php if(isset($cruise) && isset($cruise['infants_text']) && $cruise['infants_text'] != ''):?>
									<?=$cruise['infants_text']?>
								<?php else:?>
									<?=lang('infants')?>
								<?php endif;?>:
							</div>
							
							<div class="col50">
								
								<select name="infants_<?=$index?>_1" id="<?=$service_1['id']?>_infants_<?=$index?>" onchange="change_passenger('change_cabin')">
									
				                   <?php for ($i = 0; $i <= 3; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $service_1['cabin_arangement']['num_cabin'] && $cabin['infants'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
									<?php endfor;?>
				                    
				                </select>
							
							</div>
							
							<div class="col300" style="display: none; margin-left: 35px" id="<?=$service_1['id']?>_errors_<?=$index?>">
								<span class="error" style="display: none" id="<?=$service_1['id']?>_errors_<?=$index?>_1"><?=lang('label_max_3_pax_per_cabin')?></span>
								<span class="error" style="display: none" id="<?=$service_1['id']?>_errors_<?=$index?>_2"><?=lang('label_min_1_pax_per_cabin')?></span>
								<span class="error" style="display: none" id="<?=$service_1['id']?>_errors_<?=$index?>_3"><?=lang('label_single_cabin_only_for_1_pax')?></span>
							</div>	
							
						</div>
							
						<?php endfor;?>
							
			</div>
			
		<?php endif;?>
		
		<?php if($mode == 1):?>
		
			<div class="row highlight">
				<b><?=$service_2['name']?>:</b> 
			</div>
			
			<div class="row" id="more_date_previous" style="display: none; margin-bottom: 5px;">
				
				<div style="float: left; width: 100%">
						<div class="month_label_square">
						</div>
					<?php for ($i=19; $i>=6; $i--):?>
						<div class="day_square" id="pre_<?=$i?>" <?php if($i != 19):?> style="border-left: 0" <?php endif;?>>
							<input type="checkbox" name="hotel_dates[]" class="check_box_position" id="pre_<?=$i?>_checkbox" onclick="select_date(this)">
						</div>
					<?php endfor;?>						
						<div class="month_label_square">
						</div>
				</div>
				<div style="float: left; width: 100%;">
						<div class="month_label" id="start_month_1">
						</div>
					<?php for ($i=19; $i>=6; $i--):?>
						<div class="day_label" id="pre_<?=$i?>_label">
							
						</div>
					<?php endfor;?>						
						<div class="month_label" id="end_month_1">
						</div>
				</div>				
			
			</div>
			
			<div class="row">
				<div style="float: left; width: 100%;">
						<div class="month_label_square">
						</div>
					<?php for ($i=5; $i >= 1; $i--):?>
						<div class="day_square" style="border-right: 0" id="pre_<?=$i?>">
							<input type="checkbox" name="hotel_dates[]" class="check_box_position" id="pre_<?=$i?>_checkbox" onclick="select_date(this)">
						</div>
					<?php endfor;?>
						<div class="tour_square">
							<div class="tour_position"><?=character_limiter($service_1['name'], 15)?></div>
						</div>
					<?php for ($i=1; $i <= 5; $i++):?>
						<div class="day_square" style="border-left: 0" id="next_<?=$i?>">
							<input type="checkbox" name="hotel_dates[]" class="check_box_position" id="next_<?=$i?>_checkbox" onclick="select_date(this)">
						</div>
					<?php endfor;?>
						<div class="month_label_square">							
						</div>
						<div style="float:left; margin-top: 6px"><a id="show_more_dates" class="function" stat="hide" href="javascript:void(0)" onclick="show_hide_dates()">Show more dates</a></div>
				</div>
				<div style="float: left; width: 100%">
						<div class="month_label" id="start_month">
						</div>
					<?php for ($i=5; $i >= 1; $i--):?>
						<div class="day_label" id="pre_<?=$i?>_label">
							
						</div>
					<?php endfor;?>
						<div class="tour_label" id="tour_label">
							
						</div>
					<?php for ($i=1; $i <= 5; $i++):?>
						<div class="day_label" id="next_<?=$i?>_label">
							
						</div>
					<?php endfor;?>
						<div class="month_label" id="end_month">
						</div>
				</div>
				
			</div>
			
			<div class="row" id="more_date_next" style="display: none; margin-top: 5px;">
				
				<div style="float: left; width: 100%;">
						<div class="month_label_square">
						</div>
					<?php for ($i=6; $i < 20; $i++):?>
						<div class="day_square" id="pre_<?=$i?>" <?php if($i != 6):?> style="border-left: 0" <?php endif;?>>
							<input type="checkbox" name="hotel_dates[]" class="check_box_position" id="next_<?=$i?>_checkbox" onclick="select_date(this)">
						</div>
					<?php endfor;?>						
						<div class="month_label_square">
						</div>
				</div>
				<div style="float: left; width: 100%;">
						<div class="month_label" id="start_month_2">
						</div>
					<?php for ($i=6; $i < 20; $i++):?>
						<div class="day_label" id="next_<?=$i?>_label">
							
						</div>
					<?php endfor;?>						
						<div class="month_label" id="end_month_2">
						</div>
				</div>				
			
			</div>
			
			<div class="row">				
				<span class="error" style="display: none" id="hotel_error">* <?=lang('label_please_select_dates_staying')?></span>
			</div>
		
		<?php else:?>
			
			<div class="row highlight">
				<b><?=$service_2['name']?>:</b> 
			</div>
			
			<div class="row">
				<div class="col120">
					<span style="margin-left: 40px;"><?=lang('start')?>:</span>
				</div>
				
				<div class="col200">
					<select name="departure_day_check_rates" id="departure_day_check_rates_<?=$service_2['id']?>" onchange="changeDay('<?=$start_date_id_2?>', '<?=$start_month_id_2?>', '<?=$departure_date_id_2?>')">
						<option value=""><?=date('D, Y')?></option>
					</select>
					<select name="departure_month_check_rates" id="departure_month_check_rates_<?=$service_2['id']?>" onchange="changeMonth('<?=$start_date_id_2?>', '<?=$start_month_id_2?>', '<?=$departure_date_id_2?>','','',tour_departure_2)">
			            	<option value=""><?=date('M, Y')?></option>                 
			            </select>
			            &nbsp;<input type="hidden" id="departure_date_check_rates_<?=$service_2['id']?>" name="departure_date_check_rates_2"/>
				</div>
				
				<div class="col60"><?=lang('end')?>:</div>
				
				<div class="col170" id="tour_end_date_<?=$service_2['id']?>">	
					
				</div>
				<div class="clearfix"></div>
				<div style="float: left; margin-top: 10px;">
					<span class="error" style="display: none" id="tour_date_error">* <?=lang('label_please_select_valid_departure')?></span>
				</div>
			</div>
			<?php if (is_arrange_cabin($service_2) && isset($action) && $action == 'check_rate'):?>
		
				<div class="row" id="re_arrange_cabin_text_<?=$service_2['id']?>" <?=isset($check_rates['object_change_2']) && $check_rates['object_change_2'] == 'change_cabin'? 'style="display: none"' : ''?>>
					<div class="col120" style="margin-left: 40px;">
						<?=lang('cabin_arrangement')?>:
					</div>
					
					<div style="float:left; margin-right: 20px;">
						<ul style="float: left;">
						<?php foreach ($service_2['cabin_arangement']['cabins'] as $key => $cabin):?>
							<li style="padding-bottom: 5px;"><?=lang('label_cabin')?> <?=$key?>: <?=$cabin['arrangement']?></li>
						<?php endforeach;?>
						</ul>
					</div>
					
					<div id="re_arrange_cabin_guide_<?=$service_2['id']?>" <?=isset($check_rates['object_change_2']) && $check_rates['object_change_2'] == 'change_cabin'? 'style="display: none"' : ''?>>
						* <?=lang('label_re_arrange_your_cabins')?> <a href="javascript: void(0)" onclick="re_arrange_cabin('<?=$service_2['id']?>');"><?=lang('label_please_click_here')?></a>
					</div>
				</div>
				
				<div id="re_arrange_cabin_<?=$service_2['id']?>" <?=!isset($check_rates['object_change_2']) || $check_rates['object_change_2'] != 'change_cabin'? 'style="display: none"' : ''?>>
				
					<div class="row">
					
						<div class="col120" style="margin-left:40px;">Number of cabin:</div>
						
						<div class="col50">
							<select name="num_cabin_2" id="num_cabin_<?=$service_2['id']?>" onchange="change_cabin('<?=$service_2['id']?>', <?=CABIN_LIMIT?>)">
								<?php for ($i = 1; $i <= CABIN_LIMIT; ++$i) :?>
			                    <option value="<?=$i?>" <?php if($service_2['cabin_arangement']['num_cabin'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
			                    <?php endfor;?>
			                </select>
						
						</div>
						
						<div class="col20">
							<a href="javascript: void(0)" onclick="hide_re_arrange_cabin('<?=$service_2['id']?>')"><?=lang('label_hide_cabin_arrangement')?></a>
						</div>
					
					</div>
					
					<?php for($index = 1; $index <= CABIN_LIMIT; $index++):?>
							
								<?php 
									if (isset($service_2['cabin_arangement']['cabins'][$index])){
										$cabin = $service_2['cabin_arangement']['cabins'][$index];
									}
								
								?>
							
							<div class="row" <?php if($index > $service_2['cabin_arangement']['num_cabin']):?>style="display: none;"<?php endif;?>" id="<?=$service_2['id']?>_cabin_<?=$index?>">
								
								<div class="col100"><span style="margin-left:40px;"><?=lang('label_cabin')?> <?=$index?>:</span></div>
								
								<div class="col80">
									
									<select name="type_<?=$index?>_2" id="<?=$service_2['id']?>_type_<?=$index?>" onchange="change_passenger('change_cabin')">
										
										<?php foreach ($cabin_types as $k=>$value):?>
											<option value="<?=$k?>" <?php if ($index <= $service_2['cabin_arangement']['num_cabin'] && $cabin['type'] == $k):?> selected="selected" <?php endif;?>><?=translate_text($value)?></option>
										<?php endforeach;?>
									
					                </select>
								
								</div>						
								
								<div class="col50">
									<?=lang('adults')?>:
								</div>
								
								<div class="col50">
									
									<select name="adults_<?=$index?>_2" id="<?=$service_2['id']?>_adults_<?=$index?>" onchange="change_passenger('change_cabin')">
										
										<?php for ($i = 0; $i <= 2; $i++):?>
											<option value="<?=$i?>" <?php if($index <= $service_2['cabin_arangement']['num_cabin'] && $cabin['adults'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
										<?php endfor;?>
										
									</select>
								
								</div>
								
								<div class="col100">
									<?php if(isset($cruise) && isset($cruise['children_text']) && $cruise['children_text'] != ''):?>
										<?=$cruise['children_text']?>
									<?php else:?>
						            	<?=lang('children')?>
									<?php endif;?>:
								</div>
								
								<div style="float: left; width: 50px;">
									
									<select name="children_<?=$index?>_2" id="<?=$service_2['id']?>_children_<?=$index?>" onchange="change_passenger('change_cabin')">
										
					                    <?php for ($i = 0; $i <= 3; $i++):?>
											<option value="<?=$i?>" <?php if($index <= $service_2['cabin_arangement']['num_cabin'] && $cabin['children'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
										<?php endfor;?>
					                    
					                </select>
								
								</div>
								
								<div class="col80">
									<?php if(isset($cruise) && isset($cruise['infants_text']) && $cruise['infants_text'] != ''):?>
										<?=$cruise['infants_text']?>
									<?php else:?>
										<?=lang('infants')?>
									<?php endif;?>:
								</div>
								
								<div class="col50">
									
									<select name="infants_<?=$index?>_2" id="<?=$service_2['id']?>_infants_<?=$index?>" onchange="change_passenger('change_cabin')">
										
					                   <?php for ($i = 0; $i <= 3; $i++):?>
											<option value="<?=$i?>" <?php if($index <= $service_2['cabin_arangement']['num_cabin'] && $cabin['infants'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
										<?php endfor;?>
					                    
					                </select>
								
								</div>
								
								<div class="col300" style="display: none; margin-left: 35px" id="<?=$service_2['id']?>_errors_<?=$index?>">
									<span class="error" style="display: none" id="<?=$service_2['id']?>_errors_<?=$index?>_1"><?=lang('label_max_3_pax_per_cabin')?></span>
									<span class="error" style="display: none" id="<?=$service_2['id']?>_errors_<?=$index?>_2"><?=lang('label_min_1_pax_per_cabin')?></span>
									<span class="error" style="display: none" id="<?=$service_2['id']?>_errors_<?=$index?>_3"><?=lang('label_single_cabin_only_for_1_pax')?></span>
								</div>	
								
							</div>
								
							<?php endfor;?>
								
				</div>
			
			<?php endif;?>
		
			
		<?php endif;?>
	
	<div class="row">		
		<div class="btn_general btn_check_rates" id="btn_tour_check_rate_together" style="float: right; margin-right: 10px;"><?=lang('check_rates')?></div>
	</div>
</div>

<script>

	
	$(document).ready(function(){
		
		var this_date = '<?=trim(getDefaultDate())?>';
		var current_date = '<?=trim($check_rates['departure_date_1'])?>';
		
		initDate(this_date, current_date, '<?=$start_date_id_1?>', '<?=$start_month_id_1?>', '<?=$departure_date_id_1?>','','',tour_departure_1);
		
		get_end_date_of_tour('<?=$start_date_id_1?>', '<?=$start_month_id_1?>', '#tour_end_date_<?=$service_1['id']?>', tour_duration_1, tour_departure_up_stream_1, tour_departure_down_stream_1);

		<?php if($mode == 1):?>
			render_serivce_2_select_dates();
		<?php endif;?>
		
		var departure_day_check_rates = $("<?=$start_date_id_1?>");
		var departure_month_check_rates = $("<?=$start_month_id_1?>");

		$.each([departure_day_check_rates,departure_month_check_rates], function() {
		    this.change(function(){
		    	get_end_date_of_tour('<?=$start_date_id_1?>', '<?=$start_month_id_1?>', '#tour_end_date_<?=$service_1['id']?>', tour_duration_1, tour_departure_up_stream_1, tour_departure_down_stream_1);

		    	<?php if($mode == 1):?>
					render_serivce_2_select_dates();
				<?php endif;?>
				
			});
		});	

		<?php if($mode == 2):?>

			<?php if(isset($check_rates['departure_date_2'])):?>
				current_date = '<?=trim($check_rates['departure_date_2'])?>';
			<?php else:?>
				current_date = get_service_2_default_date();
			<?php endif;?>
			
			initDate(this_date, current_date, '<?=$start_date_id_2?>', '<?=$start_month_id_2?>', '<?=$departure_date_id_2?>','','',tour_departure_2);
			
			get_end_date_of_tour('<?=$start_date_id_2?>', '<?=$start_month_id_2?>', '#tour_end_date_<?=$service_2['id']?>', tour_duration_2, tour_departure_up_stream_2, tour_departure_down_stream_2)
			
			var departure_day_check_rates_2 = $("<?=$start_date_id_2?>");
			var departure_month_check_rates_2 = $("<?=$start_month_id_2?>");
	
			$.each([departure_day_check_rates_2,departure_month_check_rates_2], function() {
			    this.change(function(){
			    	get_end_date_of_tour('<?=$start_date_id_2?>', '<?=$start_month_id_2?>', '#tour_end_date_<?=$service_2['id']?>', tour_duration_2, tour_departure_up_stream_2, tour_departure_down_stream_2);
				});
			});	
			
		<?php endif;?>	
		
		$("#btn_tour_check_rate_together").click(function() {

			if (is_valid_dates() && is_valid_cabin_arrangement()){
				
				var alert_message='<?=lang("search_alert_message")?>';
				
				check_travel_date($("#departure_date_check_rates_<?=$service_1['id']?>").val(), alert_message);
				
				$("#frm_check_rate_together").submit();
			}
			
		});
		
		
	});

	function select_date(obj){
		var checked = $(obj).attr('checked');

		if (checked){
			$(obj).parent().css('background-color','#FEBA02');
		} else {
			$(obj).parent().css('background-color','inherit');
		}
	}

	function render_more_previous_dates(departure_date_1, today){
		
		var has_day_selected = false;
		
		for (var i=19; i >=6 ; i--){
			my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
			
			my_date.setDate(my_date.getDate() - i);

			$('#pre_'+i+'_checkbox').val($.datepicker.formatDate('yy-mm-dd', my_date));
			$('#pre_'+i+'_label').text(my_date.getDate());
			
			if (my_date >= today){
				$('#pre_'+i+'_checkbox').attr('disabled',false);	
			} else {
				$('#pre_'+i+'_checkbox').attr('disabled',true);
			}

			if (is_hotel_date_selected($.datepicker.formatDate('yy-mm-dd', my_date))){
				$('#pre_'+i+'_checkbox').attr('checked',true);

				has_day_selected = true;
			} else {
				$('#pre_'+i+'_checkbox').attr('checked',false);
			}

			select_date($('#pre_'+i+'_checkbox'));
		}

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() - 19);
		var star_month_1_label = $.datepicker.formatDate('M yy', my_date);
		$('#start_month_1').text(star_month_1_label);

		if (has_day_selected){
			$('#show_more_dates').attr('stat', 'hide');
			show_hide_dates();
			$('#more_date_previous').show();
		}
	}

	function render_more_next_dates(departure_date_1, duration){

		var has_day_selected = false;
		
		for (var i=6; i<20;i++){
			my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
			my_date.setDate(my_date.getDate() + i + duration - 1);
			$('#next_'+i+'_label').text(my_date.getDate());

			$('#next_'+i+'_checkbox').val($.datepicker.formatDate('yy-mm-dd', my_date));


			if (is_hotel_date_selected($.datepicker.formatDate('yy-mm-dd', my_date))){
				$('#next_'+i+'_checkbox').attr('checked',true);

				has_day_selected = true;
				
			} else {
				$('#next_'+i+'_checkbox').attr('checked',false);
			}

			select_date($('#next_'+i+'_checkbox'));
		}

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() + 19 + duration - 1);
		var end_month_2_label = $.datepicker.formatDate('M yy', my_date);
		$('#end_month_2').text(end_month_2_label);

		if (has_day_selected){
			$('#show_more_dates').attr('stat', 'hide');
			show_hide_dates();
			$('#more_date_next').show();
		}
	}
	
	function render_serivce_2_select_dates(){
		var my_date = '';
		var departure_date_1 = $.trim($('<?=$departure_date_id_1?>').val());

		var duration = <?=$service_1['duration'] - 1?>;

		// set time for the tour
		var departure_date_1_obj = $.datepicker.parseDate('dd-mm-yy', departure_date_1);

		var date_1 = departure_date_1_obj.getDate();


		var departure_date_2_obj = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		
		departure_date_2_obj.setDate(date_1 + duration);
		
		var date_2 = departure_date_2_obj.getDate();
		
		$('#tour_label').text(date_1 + ' - ' + date_2);

		// set time for the hotel

		var today = new Date();

		today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		
		for (var i=5; i>=1; i--){
			my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
			my_date.setDate(my_date.getDate() - i);
			if (my_date >= today){
				$('#pre_'+i).show();
				$('#pre_'+i+'_label').show();
				$('#pre_'+i+'_label').text(my_date.getDate());

				$('#pre_'+i+'_checkbox').val($.datepicker.formatDate('yy-mm-dd', my_date));

				
				
			} else {
				$('#pre_'+i).hide();
				$('#pre_'+i+'_label').hide();
			}

			if (is_hotel_date_selected($.datepicker.formatDate('yy-mm-dd', my_date))){
				$('#pre_'+i+'_checkbox').attr('checked',true);
			} else {
				$('#pre_'+i+'_checkbox').attr('checked',false);
			}

			select_date($('#pre_'+i+'_checkbox'));
		}

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() - 5);
		var star_month_label = $.datepicker.formatDate('M yy', my_date);
		$('#start_month').text(star_month_label);

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() - 6);
		var end_month_1_label = $.datepicker.formatDate('M yy', my_date);
		$('#end_month_1').text(end_month_1_label);

		render_more_previous_dates(departure_date_1, today);

		for (var i=1; i<=5;i++){
			my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
			my_date.setDate(my_date.getDate() + i + duration - 1);
			$('#next_'+i+'_label').text(my_date.getDate());

			$('#next_'+i+'_checkbox').val($.datepicker.formatDate('yy-mm-dd', my_date));


			if (is_hotel_date_selected($.datepicker.formatDate('yy-mm-dd', my_date))){
				$('#next_'+i+'_checkbox').attr('checked',true);
			} else {
				$('#next_'+i+'_checkbox').attr('checked',false);
			}

			select_date($('#next_'+i+'_checkbox'));
		}

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() + 5 + duration - 1);
		var end_month_label = $.datepicker.formatDate('M yy', my_date);
		$('#end_month').text(end_month_label);

		my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
		my_date.setDate(my_date.getDate() + 6 + duration - 1);
		var start_month_2_label = $.datepicker.formatDate('M yy', my_date);
		$('#start_month_2').text(start_month_2_label);

		render_more_next_dates(departure_date_1, duration);
	}

	function get_service_2_default_date(){

		var departure_date_1 = $.trim($('<?=$departure_date_id_1?>').val());

		var duration = <?=$service_1['duration']?>;

		// set time for the tour
		var departure_date_1_obj = $.datepicker.parseDate('dd-mm-yy', departure_date_1);

		var date_1 = departure_date_1_obj.getDate();


		var departure_date_2_obj = $.datepicker.parseDate('dd-mm-yy', departure_date_1);

		departure_date_2_obj.setDate(date_1 + duration);

		var ret = $.datepicker.formatDate('dd-mm-yy', departure_date_2_obj);

		return ret;
	}

	function change_passenger(value){
		object_change_info(value, '<?=$service_1['id']?>');
		$('#object_change_' + '<?=$service_2['id']?>').val(value);
	}

	function is_hotel_date_selected(date){
		<?php if(isset($check_rates['hotel_dates'])):?>
		
			var hotel_dates = <?=json_encode($check_rates['hotel_dates'])?>;

			for(var i=0; i < hotel_dates.length; i++){
				if (date == hotel_dates[i]) return true;	
			}
			
		<?php endif;?>

		return false;
	}

	function is_valid_hotel_date_selected(){

		<?php if($mode == 1):?>
		
			var departure_date_1 = $.trim($('<?=$departure_date_id_1?>').val());
			
			var today = new Date();
			
			today = new Date(today.getFullYear(), today.getMonth(), today.getDate())
			
			for (var i=19; i>=1; i--){
					
				var my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
				
				my_date.setDate(my_date.getDate() - i);
				
				if (my_date >= today){
	
					var is_date_checked = $('#pre_'+i+'_checkbox').attr('checked');
	
					if (is_date_checked){
						return true;	
					}
				} 
			}
			
			for (var i=1; i<=19;i++){
				
				var is_date_checked = $('#next_'+i+'_checkbox').attr('checked');
	
				if (is_date_checked){
					return true;	
				}
			}
	
			$('#hotel_error').show();
			
			return false;

		<?php else:?>
			return true;
		<?php endif;?>
	}

	function is_valid_tour_date_selected(){

		<?php if($mode == 2):?>

			var duration_1 = <?=$service_1['duration']?>;

			var str_d_d_1 = $.trim($('<?=$departure_date_id_1?>').val());
			
			var start_date_1 = $.datepicker.parseDate('dd-mm-yy', str_d_d_1);
			
			start_date_1.setHours(0);
			start_date_1.setMilliseconds(0);
			start_date_1.setMinutes(0);			
	
			var end_date_1 = $.datepicker.parseDate('dd-mm-yy', str_d_d_1);	

			end_date_1.setDate(start_date_1.getDate() + duration_1 - 1);

			end_date_1.setHours(0);
			end_date_1.setMilliseconds(0);
			end_date_1.setMinutes(0);
			

			var duration_2 = <?=$service_2['duration']?>;

			var str_d_d_2 = $.trim($('<?=$departure_date_id_2?>').val());
			
			var start_date_2 = $.datepicker.parseDate('dd-mm-yy', str_d_d_2);
			
			var end_date_2 = $.datepicker.parseDate('dd-mm-yy', str_d_d_2);	
			
			end_date_2.setDate(start_date_2.getDate() + duration_2 - 1);
	
			
			start_date_2.setHours(0);
			start_date_2.setMilliseconds(0);
			start_date_2.setMinutes(0);	

			end_date_2.setHours(0);
			end_date_2.setMilliseconds(0);
			end_date_2.setMinutes(0);


			if (start_date_2 < end_date_1 && end_date_2 > start_date_1){

				$('#tour_date_error').show();
				
				return false;
			} else {
				return true;
			}		

		<?php else:?>
			return true;
		<?php endif;?>
	}

	function is_valid_dates(){
		return is_valid_hotel_date_selected() && is_valid_tour_date_selected();
	}

	function is_valid_cabin_arrangement(){
		
		var is_valid = !check_error_check_rates('<?=$service_1['id']?>');

		<?php if($mode == 2):?>
			
			is_valid = is_valid && !check_error_check_rates('<?=$service_2['id']?>');

		<?php endif;?>

		return is_valid;
		
	}

	function show_hide_dates(){
		
		var stat = $('#show_more_dates').attr('stat');

		if (stat == 'hide'){

			if (!is_all_previous_dates_in_past()){
				$('#more_date_previous').show();
			}
			
			$('#more_date_next').show();

			$('#show_more_dates').attr('stat', 'show');

			$('#show_more_dates').text('Show less dates');
			
		} else {

			$('#more_date_previous').hide();

			$('#more_date_next').hide();

			$('#show_more_dates').attr('stat', 'hide');

			$('#show_more_dates').text('Show more dates');
		}	
	}

	function is_all_previous_dates_in_past(){
		
		var departure_date_1 = $.trim($('<?=$departure_date_id_1?>').val());
		
		var today = new Date();
		
		today = new Date(today.getFullYear(), today.getMonth(), today.getDate());

		for (var i=19; i >=6 ; i--){
			
			var my_date = $.datepicker.parseDate('dd-mm-yy', departure_date_1);
			
			my_date.setDate(my_date.getDate() - i);
			
			if (my_date >= today){

				return false;
				
			} else {
				
			}

		}

		return true;
	}
	
</script>