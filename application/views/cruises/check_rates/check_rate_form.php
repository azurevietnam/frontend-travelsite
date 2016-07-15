
<script type="text/javascript">
	
	var tour_departure = '';
	var tour_departure_up_stream = '';
	var tour_departure_down_stream = '';
	var tour_duration = 0;

	<?php if($selected_tour !== FALSE):?>
	
		<?php if($selected_tour['str_departure'] != ''):?>
			
			tour_departure = <?=$selected_tour['str_departure']?>;
	
			<?php if(!is_roundtrip($selected_tour['departure'])):?>
			
			tour_departure_up_stream = <?=$selected_tour['up_stream']?>;
			tour_departure_down_stream = <?=$selected_tour['down_stream']?>;
	
			<?php endif;?>
	
		<?php endif;?>
		
		<?php if(!empty($selected_tour['duration'])):?>
			tour_duration = <?=$selected_tour['duration'] - 1?>;
		<?php endif;?>

	<?php endif;?>
	
</script>

<?php 
	
	$start_date_id = '#departure_day_check_rates_'.$cruise['id'];
	
	$start_month_id = '#departure_month_check_rates_'.$cruise['id'];
	
	$departure_date_id = '#departure_date_check_rates_'.$cruise['id'];

?>


<form id="frm_check_rate_<?=$cruise['id']?>" name="frm_check_rate" method="post" action="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>">

<h2 class="highlight" style="padding-left: 0px;padding-top: 0px;"><?=lang('select_your_departure')?></h2>

<input type="hidden" name="action_type" value="check_rate"/>

<div class="tour_check_rate">
	
	<input type="hidden" name="object_change" id="object_change_<?=$cruise['id']?>" value="<?=isset($object_change)? $object_change : 'change_person'?>">
	
	<div class="tour_check_rate_content">
		
		<div class="row">
			
			<div class="col100"><?=lang('cruise_tour')?>:</div>
			
			<div class="col50">
				
				<?php 
					$is_unavailable = count($cruise['tours']) == 0 || $cruise['status'] == STATUS_INACTIVE;
				?>
				
				<select name="tours" id="tours_<?=$cruise['id']?>" onchange="change_cruise_tour()" <?php if($is_unavailable):?>class="error"<?php endif;?>>
					
					<?php if($is_unavailable):?>
						
						<option value=""><?=lang('unavailable')?></option>
						
					<?php else:?>
					
						<?php foreach ($cruise['tours'] as $value):?>
							
							<?php
								if ($value['duration'] - 1 > 0){ 
									$str_nights = ' / '.($value['duration'] - 1). ($value['duration'] - 1 > 1 ? ' '.lang('nights') : ' '.lang('night'));
								} else {
									$str_nights = ' / '.lang('label_day_cruise');
								}
							?>
							
							<option value="<?=$value['id']?>" <?=set_select('tours', $value['id'], isset($check_rates['tours']) && $check_rates['tours'] == $value['id'])?>><?=$value['name'].$str_nights?></option>
							
						<?php endforeach;?>
					
					<?php endif;?>
						
	            </select>
			</div>
			
		</div>
	
		<div class="row ">
			
			<div class="col100"><?=lang('adults')?>:</div>
			
			<div class="col50">
				<select name="adults" id="adults_<?=$cruise['id']?>" onchange="object_change_info('change_person', '<?=$cruise['id']?>')">
					<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
	                 <option value="<?=$i?>" <?=set_select('adults', $i, $check_rates['adults'] == $i? true: false)?>><?=$i?></option>
	                 <?php endfor;?>
	             </select>
			</div>
			
			<div class="col100">
				<?php if(isset($cruise) && isset($cruise['children_text']) && $cruise['children_text'] != ''):?>
					<?=$cruise['children_text']?>
				<?php else:?>
	            	<?=lang('children')?>
				<?php endif;?>
			:</div>
			
			<div class="col50">
				<select name="children" id="children_<?=$cruise['id']?>" onchange="object_change_info('change_person', '<?=$cruise['id']?>')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                <option value="<?=$i?>" <?=set_select('children', $i, $check_rates['children'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
			
			<div class="col80">
				<?php if(isset($cruise) && isset($cruise['infants_text']) && $cruise['infants_text'] != ''):?>
					<?=$cruise['infants_text']?>
				<?php else:?>
					<?=lang('infants')?>
				<?php endif;?>
			:</div>
			
			<div class="col50">
				<select name="infants" id="infants_<?=$cruise['id']?>" onchange="object_change_info('change_person', '<?=$cruise['id']?>')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                	<option value="<?=$i?>" <?=set_select('infants', $i, $check_rates['infants'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col100"><?=lang('departure_date')?>:</div>
			<div class="col200">
				<select name="departure_day_check_rates" id="departure_day_check_rates_<?=$cruise['id']?>" onchange="changeDay('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>')">
					<option value=""><?=date('D, Y')?></option>
				</select>
				<select name="departure_month_check_rates" id="departure_month_check_rates_<?=$cruise['id']?>" onchange="changeMonth('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','',tour_departure)">
		            	<option value=""><?=date('M, Y')?></option>                 
		            </select>
		            &nbsp;<input type="hidden" id="departure_date_check_rates_<?=$cruise['id']?>" name="departure_date_check_rates"/>
			</div>
			
			<div class="col60"><?=lang('end_date')?>:</div>
			
			<div class="col170" id="tour_end_date_<?=$cruise['id']?>">
					
					<?php 
						$end_date = $this->timedate->date_add($search_criteria['departure_date'], 0, 0, $selected_tour['duration'] - 1);
					?>
					
					<?=date('d M, Y', strtotime($end_date))?>
				
			</div>
		</div>
		
		<?php if ($selected_tour !== FALSE && isset($action) && $action == 'check_rate'):?>
		
			<div class="row" id="re_arrange_cabin_text_<?=$cruise['id']?>" <?=isset($object_change) && $object_change == 'change_cabin'? 'style="display: none"' : ''?>>
				<div class="col120"><b class="highlight"><?=lang('cabin_arrangement')?>:</b></div>
				
				<div class="col300"> 
					<ul>
					<?php foreach ($pax_accom_info['cabins'] as $key => $cabin):?>
						<li style="padding-bottom: 5px;">Cabin <?=$key?>: <?=$cabin['arrangement']?></li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<div class="row" id="re_arrange_cabin_guide_<?=$cruise['id']?>" <?=isset($object_change) && $object_change == 'change_cabin'? 'style="display: none"' : ''?>>
				<?=lang('label_re_arrange_your_cabins')?> <a href="javascript: void(0)" onclick="re_arrange_cabin('<?=$cruise['id']?>');"><?=lang('label_please_click_here')?></a>
			</div>
		
			
			<div id="re_arrange_cabin_<?=$cruise['id']?>" <?=!isset($object_change) || $object_change != 'change_cabin'? 'style="display: none"' : ''?>>
			
				<div class="row">
				
					<div class="col120"><?=lang('label_number_of_cabin')?>:</div>
					
					<div class="col50">
						<select name="num_cabin" id="num_cabin_<?=$cruise['id']?>" onchange="change_cabin('<?=$cruise['id']?>', <?=CABIN_LIMIT?>)">
							<?php for ($i = 1; $i <= CABIN_LIMIT; ++$i) :?>
		                    <option value="<?=$i?>" <?php if($pax_accom_info['num_cabin'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
		                    <?php endfor;?>
		                </select>
					
					</div>
					
					<div class="col20">
						<a href="javascript: void(0)" onclick="hide_re_arrange_cabin('<?=$cruise['id']?>')"><?=lang('label_hide_cabin_arrangement')?></a>
					</div>
				
				</div>
				
				<?php for($index = 1; $index <= CABIN_LIMIT; $index++):?>
						
							<?php 
								if (isset($pax_accom_info['cabins'][$index])){
									$cabin = $pax_accom_info['cabins'][$index];
								}
							
							?>
						
						<div class="row" <?php if($index > $pax_accom_info['num_cabin']):?>style="display: none;"<?php endif;?>" id="<?=$cruise['id']?>_cabin_<?=$index?>">
							
							<div class="col60"><?=lang('cruise_cabin')?> <?=$index?>:</div>
							
							<div class="col80">
								
								<select name="type_<?=$index?>" id="<?=$cruise['id']?>_type_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$cruise['id']?>')">
									
									<?php foreach ($cabin_types as $k=>$value):?>
										<option value="<?=$k?>" <?php if ($index <= $pax_accom_info['num_cabin'] && $cabin['type'] == $k):?> selected="selected" <?php endif;?>><?=translate_text($value)?></option>
									<?php endforeach;?>
								
				                </select>
							
							</div>						
							
							<div class="col50">
								<?=lang('adults')?>:
							</div>
							
							<div class="col50">
								
								<select name="adults_<?=$index?>" id="<?=$cruise['id']?>_adults_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$cruise['id']?>')">
									
									<?php for ($i = 0; $i <= 2; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $pax_accom_info['num_cabin'] && $cabin['adults'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
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
								
								<select name="children_<?=$index?>" id="<?=$cruise['id']?>_children_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$cruise['id']?>')">
									
				                    <?php for ($i = 0; $i <= 3; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $pax_accom_info['num_cabin'] && $cabin['children'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
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
								
								<select name="infants_<?=$index?>" id="<?=$cruise['id']?>_infants_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$cruise['id']?>')">
									
				                   <?php for ($i = 0; $i <= 3; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $pax_accom_info['num_cabin'] && $cabin['infants'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
									<?php endfor;?>
				                    
				                </select>
							
							</div>
							
							<div class="col300" style="display: none" id="<?=$cruise['id']?>_errors_<?=$index?>">
								<span class="error" style="display: none" id="<?=$cruise['id']?>_errors_<?=$index?>_1"><?=lang('label_max_3_pax_per_cabin')?></span>
								<span class="error" style="display: none" id="<?=$cruise['id']?>_errors_<?=$index?>_2"><?=lang('label_min_1_pax_per_cabin')?></span>
								<span class="error" style="display: none" id="<?=$cruise['id']?>_errors_<?=$index?>_3"><?=lang('label_single_cabin_only_for_1_pax')?></span>
							</div>	
							
						</div>
							
						<?php endfor;?>
							
			</div>
			
		<?php endif;?>
		
	</div>
	
	<div class="tour_check_rate_submit">
		
		<div class="btn_general btn_check_rates" id="btn_tour_check_rate_<?=$cruise['id']?>"><?=lang('check_rates')?></div>
		
	</div>
	
</div>
</form>
<script type="text/javascript">

	function change_cruise_tour(){

		var tours = <?=json_encode($cruise['tours_js'])?>;

		var tour_id = $('#tours_<?=$cruise['id']?>').val();

		var tour = '';
		
		for(var i = 0; i < tours.length; i++){

			if (tour_id == tours[i].id){

				tour = tours[i];
	
			}
		}

		if (tour != ''){
		
			tour_departure = eval(tour.str_departure);
			
			tour_departure_up_stream = tour.up_stream;
			tour_departure_down_stream = tour.down_stream;

			tour_duration = 0;

			if (tour.duration != '' && tour.duration > 0){
				tour_duration = tour.duration - 1;
			}


			if (tour_departure != ''){

				var this_date = '<?=getDefaultDate()?>';
				
				var current_date = $('#departure_date_check_rates_<?=$cruise['id']?>').val();
				
				initDate(this_date, current_date, '<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','',tour_departure);
				
			}

			get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$cruise['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
			
			var departure_day_check_rates = $("<?=$start_date_id?>");
			var departure_month_check_rates = $("<?=$start_month_id?>");

			$.each([departure_day_check_rates,departure_month_check_rates], function() {
			    this.change(function(){
			    	get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$cruise['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
					
				});
			});
			
		}
		
	}
	
	$(document).ready(function(){
		
		var this_date = '<?=getDefaultDate()?>';
		
		var current_date = getCookie('departure_date');
		
		if (current_date == null || current_date ==''){
			current_date = '<?=date('d-m-Y', strtotime($search_criteria['departure_date']))?>';
		}
		
		initDate(this_date, current_date, '<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','',tour_departure);
		
		get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$cruise['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
		
		var departure_day_check_rates = $("<?=$start_date_id?>");
		var departure_month_check_rates = $("<?=$start_month_id?>");

		$.each([departure_day_check_rates,departure_month_check_rates], function() {
		    this.change(function(){
		    	get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$cruise['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
				
			});
		});	

		<?php if (!empty($action)):?>
			go_check_rate_position();	
		<?php endif;?>
		
		$("#btn_tour_check_rate_<?=$cruise['id']?>").click(function() {

			<?php if($is_unavailable):?>

				alert("<?=lang('unavailable_desc_alert')?>");
	
			<?php else:?>
			
			if (!check_error_check_rates('<?=$cruise['id']?>')){
				
				var alert_message='<?=lang("search_alert_message")?>';
				
				check_travel_date($("#departure_date_check_rates_<?=$cruise['id']?>").val(), alert_message);
				
				$("#frm_check_rate_<?=$cruise['id']?>").submit();
			}

			<?php endif;?>
			
		});
		
	});
</script>