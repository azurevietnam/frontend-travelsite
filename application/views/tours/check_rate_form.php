
<script type="text/javascript">
	var tour_departure = '';
	var tour_departure_up_stream = '';
	var tour_departure_down_stream = '';
	<?php if(!empty($tour['departure'])):?>
		
		<?php $str_departure = getDepartureDate($tour['departure'])?>
		
		<?php if(!empty($str_departure)):?>
		
		
			tour_departure = <?=$str_departure;?>;
			
			<?php if(!is_roundtrip($tour['departure'])):?>
			
				tour_departure_up_stream = <?=json_encode(get_departure_date($tour['departure'], 'UPSTREAM', 0, '', 'j-n-Y'));?>;
				
				tour_departure_down_stream = <?=json_encode(get_departure_date($tour['departure'], 'DOWNSTREAM', 0, '', 'j-n-Y'));?>;
				
			<?php endif;?>
			
		
		
		<?php endif;?>
	
	<?php endif;?>

	var tour_duration = 0;
	<?php if(!empty($tour['duration'])):?>
		tour_duration = <?=$tour['duration'] - 1?>;
	<?php endif;?>

</script>

<?php 
	
	$start_date_id = '#departure_day_check_rates_'.$tour['id'];
	
	$start_month_id = '#departure_month_check_rates_'.$tour['id'];
	
	$departure_date_id = '#departure_date_check_rates_'.$tour['id'];

?>


<form id="frm_check_rate_<?=$tour['id']?>" name="frm_check_rate" method="post" action="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>">

<input type="hidden" name="action_type" value="check_rate"/>

<?php if(!isset($is_extra_booking)):?>
	<h2 class="highlight" style="padding-left: 0px;padding-top: 0px;"><?=lang('select_your_departure')?></h2>
<?php endif;?>

<div class="tour_check_rate" <?php if(isset($is_extra_booking)):?> style="width: 708px;"<?php endif;?>>
	
	<input type="hidden" name="object_change" id="object_change_<?=$tour['id']?>" value="<?=isset($object_change)? $object_change : 'change_person'?>">
	
	<div class="tour_check_rate_content">
	
		<div class="row">
			
			<div class="col100"><?=lang('adults')?>:</div>
			
			<div class="col50">
				<select name="adults" id="adults_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
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
				<select name="children" id="children_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
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
				<select name="infants" id="infants_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                	<option value="<?=$i?>" <?=set_select('infants', $i, $check_rates['infants'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
			
		</div>
		
		<div class="row">
			<div class="col100"><?=lang('departure_date')?>:</div>
			<div class="col200">
				<select name="departure_day_check_rates" id="departure_day_check_rates_<?=$tour['id']?>" onchange="changeDay('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>')">
					<option value=""><?=date('D, Y')?></option>
				</select>
				<select name="departure_month_check_rates" id="departure_month_check_rates_<?=$tour['id']?>" onchange="changeMonth('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','',tour_departure)">
		            	<option value=""><?=date('M, Y')?></option>                 
		            </select>
		            &nbsp;<input type="hidden" id="departure_date_check_rates_<?=$tour['id']?>" name="departure_date_check_rates"/>
			</div>
			
			<div class="col60"><?=lang('end_date')?>:</div>
			
			<div class="col170" id="tour_end_date_<?=$tour['id']?>">
					
					<?php 
						$end_date = $this->timedate->date_add($search_criteria['departure_date'], 0, 0, $tour['duration'] - 1);
					?>
					
					<?=date('d M, Y', strtotime($end_date))?>
				
			</div>
		</div>
		
		<?php if (isset($action) && $action == 'check_rate'):?>
		
			<div class="row" id="re_arrange_cabin_text_<?=$tour['id']?>" <?=isset($object_change) && $object_change == 'change_cabin'? 'style="display: none"' : ''?>>
				<div class="col120"><b class="highlight"><?=lang('cabin_arrangement')?>:</b></div>
				
				<div class="col300"> 
					<ul>
					<?php foreach ($pax_accom_info['cabins'] as $key => $cabin):?>
						<li style="padding-bottom: 5px;">Cabin <?=$key?>: <?=$cabin['arrangement']?></li>
					<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<div class="row" id="re_arrange_cabin_guide_<?=$tour['id']?>" <?=isset($object_change) && $object_change == 'change_cabin'? 'style="display: none"' : ''?>>
				<?=lang('label_re_arrange_your_cabins')?> <a href="javascript: void(0)" onclick="re_arrange_cabin('<?=$tour['id']?>');"><?=lang('please_click')?></a>
			</div>
		
			
			<div id="re_arrange_cabin_<?=$tour['id']?>" <?=!isset($object_change) || $object_change != 'change_cabin'? 'style="display: none"' : ''?>>
			
				<div class="row">
				
					<div class="col120">Number of cabin:</div>
					
					<div class="col50">
						<select name="num_cabin" id="num_cabin_<?=$tour['id']?>" onchange="change_cabin('<?=$tour['id']?>', <?=CABIN_LIMIT?>)">
							<?php for ($i = 1; $i <= CABIN_LIMIT; ++$i) :?>
		                    <option value="<?=$i?>" <?php if($pax_accom_info['num_cabin'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
		                    <?php endfor;?>
		                </select>
					
					</div>
					
					<div class="col20">
						<a href="javascript: void(0)" onclick="hide_re_arrange_cabin('<?=$tour['id']?>')"><?=lang('label_hide_cabin_arrangement')?></a>
					</div>
				
				</div>
				
				<?php for($index = 1; $index <= CABIN_LIMIT; $index++):?>
						
							<?php 
								if (isset($pax_accom_info['cabins'][$index])){
									$cabin = $pax_accom_info['cabins'][$index];
								}
							
							?>
						
						<div class="row" <?php if($index > $pax_accom_info['num_cabin']):?>style="display: none;"<?php endif;?>" id="<?=$tour['id']?>_cabin_<?=$index?>">
							
							<div class="col60">Cabin <?=$index?>:</div>
							
							<div class="col80">
								
								<select name="type_<?=$index?>" id="<?=$tour['id']?>_type_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
									
									<?php foreach ($cabin_types as $k=>$value):?>
										<option value="<?=$k?>" <?php if ($index <= $pax_accom_info['num_cabin'] && $cabin['type'] == $k):?> selected="selected" <?php endif;?>><?=translate_text($value)?></option>
									<?php endforeach;?>
								
				                </select>
							
							</div>						
							
							<div class="col50">
								<?=lang('adults')?>:
							</div>
							
							<div class="col50">
								
								<select name="adults_<?=$index?>" id="<?=$tour['id']?>_adults_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
									
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
								
								<select name="children_<?=$index?>" id="<?=$tour['id']?>_children_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
									
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
								
								<select name="infants_<?=$index?>" id="<?=$tour['id']?>_infants_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
									
				                   <?php for ($i = 0; $i <= 3; $i++):?>
										<option value="<?=$i?>" <?php if($index <= $pax_accom_info['num_cabin'] && $cabin['infants'] == $i):?> selected="selected" <?php endif;?>><?=$i?></option>
									<?php endfor;?>
				                    
				                </select>
							
							</div>
							
							<div class="col300" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>">
								<span class="error" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_1">* Maximum 3 pax per cabin</span>
								<span class="error" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_2">* Minimum 1 pax per cabin</span>
								<span class="error" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_3">* Single cabin only for 1 pax</span>
							</div>	
							
						</div>
							
						<?php endfor;?>
							
			</div>
			
		<?php endif;?>
		
	</div>
	
	<div class="tour_check_rate_submit">
		<div class="btn_general btn_check_rates" id="btn_tour_check_rate_<?=$tour['id']?>"><?=lang('check_rates')?></div>
	</div>
	
</div>
</form>
<script>

	$(document).ready(function(){
		
		var this_date = '<?=getDefaultDate()?>';
		
		<?php if(!isset($is_extra_booking)):?>
			var current_date = getCookie('departure_date');
			
			if (current_date == null || current_date ==''){
				current_date = '<?=date('d-m-Y', strtotime($search_criteria['departure_date']))?>';
			}
		<?php else:?>
			var current_date = '<?=date('d-m-Y', strtotime($search_criteria['departure_date']))?>';
		<?php endif;?>
		
		initDate(this_date, current_date, '<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','',tour_departure);
		
		get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$tour['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
		
		var departure_day_check_rates = $("<?=$start_date_id?>");
		var departure_month_check_rates = $("<?=$start_month_id?>");

		$.each([departure_day_check_rates,departure_month_check_rates], function() {
		    this.change(function(){
		    	get_end_date_of_tour('<?=$start_date_id?>', '<?=$start_month_id?>', '#tour_end_date_<?=$tour['id']?>', tour_duration, tour_departure_up_stream, tour_departure_down_stream);
				
			});
		});

		<?php if (isset($action) && $action == 'check_rate'):?>
			<?php if(!isset($is_extra_booking)):?>
				go_check_rate_position();
			<?php endif;?>
		<?php endif;?>		

		$("#btn_tour_check_rate_<?=$tour['id']?>").click(function() {

			if (!check_error_check_rates('<?=$tour['id']?>')){
				
				var alert_message='<?=lang("search_alert_message")?>';
				
				check_travel_date($("#departure_date_check_rates_<?=$tour['id']?>").val(), alert_message);
				
				<?php if(!isset($is_extra_booking)):?>
						
					$("#frm_check_rate_<?=$tour['id']?>").submit();
					
				<?php else:?>

					var url ="<?=site_url('/tourextrabooking').'/'.$tour['url_title'].'/'.$parent_id.'/'?>";	
		
					var id = '<?='tour_'.$tour['id']?>';
					
					var dataString = $("#frm_check_rate_<?=$tour['id']?>").serialize();
		
					$('div#'+id).html('<div style="float: left;width:100%;text-align:center;"><img src="/media/loading-indicator.gif"></div>');

					$.ajax({
						url: url,
						type: "POST",
						data: dataString,
						success:function(value){
							$('div#'+id).html(value);
						}
					});
				
				<?php endif;?>
			}
			
		});
		
		
	});
</script>