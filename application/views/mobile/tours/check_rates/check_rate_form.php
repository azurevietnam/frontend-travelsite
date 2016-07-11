<?php if(!$is_book_together):?>
<form id="frm_tour_check_rate_<?=$tour['id']?>" name="frm_tour_check_rate" method="get" action="<?=$form_action?>">
	<div class="check-rate-form">
<?php endif;?>	

<div class="bpv-check-rate-form margin-bottom-20 margin-top-10">
    <h2 class="text-special"><?=$is_book_together ? $tour['name'] : lang('select_your_departure')?></h2>
    <div class="content">
        <?php if(!empty($arr_tours)):?>
        <div class="form-group">
        	<label for="tour_id"><?=lang('cruise_tour')?>:</label>
        	<select name="tour_id" class="form-control">
    			<?php foreach ($arr_tours as $value):?>
    				<?php
    					if ($value['duration'] - 1 > 0){ 
    						$str_nights = ' / '.($value['duration'] - 1). ($value['duration'] - 1 > 1 ? ' '.lang('nights') : ' '.lang('night'));
    					} else {
    						$str_nights = ' / '.lang('label_day_cruise');
    					}
    				?>
    				<option value="<?=$value['id']?>" <?=set_select('tours', $value['id'], $tour['id'] == $value['id'])?>><?=$value['name'].$str_nights?></option>
    			<?php endforeach;?>
    		</select>
        </div>
		<?php endif;?>
		
		<div class="row form-group">
            <div class="col-xs-6">
                <label><?=lang('departure_date')?>:</label>
                <?=$datepicker?>
            </div>
            <div class="col-xs-6">
                <label><?=lang('end_date')?>:</label>
                <div class="clearfix" id="tour_date_<?=$tour['id']?>_end"></div>
            </div>
		</div>
		
		<div class="row form-group">
            <div class="col-xs-4">
                <label><?=lang('adults')?>:</label>
                <select class="form-control input-sm" name="adults_<?=$tour['id']?>" id="adults_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
    				<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
    					<?php 
    						$checked = empty($check_rates) ? $i == 2 : $i == $check_rates['adults'];
    					?>
                     	<option value="<?=$i?>" <?=set_select('adults', $i, $checked)?>><?=$i?></option>
                     <?php endfor;?>
                 </select>
            </div>
            <div class="col-xs-4">
                <label style="white-space: nowrap;"><?=lang('children')?>:</label>
                <select class="form-control input-sm" name="children_<?=$tour['id']?>" id="children_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
						<?php 
							$checked = !empty($check_rates) &&  $i == $check_rates['children'];
						?>
	               		<option value="<?=$i?>" <?=set_select('children', $i, $checked)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
            </div>
            <div class="col-xs-4">
                <label><?=lang('infants')?>:</label>
                <select class="form-control input-sm" name="infants_<?=$tour['id']?>" id="infants_<?=$tour['id']?>" onchange="object_change_info('change_person', '<?=$tour['id']?>')">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
						<?php 
							$checked = !empty($check_rates) &&  $i == $check_rates['infants'];
						?>
	                	<option value="<?=$i?>" <?=set_select('infants', $i, $checked)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
            </div>
		</div>
		
		<?php if(!empty($cabin_arrangements) && is_price_per_cabin($tour)):?>
					
			<?php 
				$num_cabin = count($cabin_arrangements);
			?>
			
			<div class="row" id="re_arrange_cabin_text_<?=$tour['id']?>" <?php if($is_change_cabin):?> style="display: none"<?php endif;?>>
				<div class="col-xs-12">
					<b class="text-highlight"><?=lang('cabin_arrangement')?>:</b>
					<ul class="list-unstyled">
						<?php foreach ($cabin_arrangements as $key => $cabin):?>
							<li>
								<?=lang('lbl_cabin_arrangement', $key, $cabin['arrangement_text'])?>
							</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<div class="margin-bottom-10" id="re_arrange_cabin_guide_<?=$tour['id']?>" <?php if($is_change_cabin):?> style="display: none"<?php endif;?>>
				<?=lang('label_re_arrange_your_cabins')?> <a href="javascript: void(0)" data-toggle="modal" data-target="#modalCabin"><?=lang('label_please_click_here')?></a>
			</div>
			
			<div class="modal fade" id="modalCabin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="<?=lang('lbl_close')?>"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><?=lang('cabin_arrangement')?></h4>
                    </div>
                    
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?=lang('label_number_of_cabin')?>:</label>
                            
                            <select class="form-control input-sm" name="num_cabin_<?=$tour['id']?>" id="num_cabin_<?=$tour['id']?>" onchange="change_cabin('<?=$tour['id']?>', <?=CABIN_LIMIT?>)">
    							<?php for ($i = 1; $i <= CABIN_LIMIT; ++$i) :?>
    		                    	<option value="<?=$i?>" <?=set_select('num_cabin', $i, $i == count($cabin_arrangements))?>><?=$i?></option>
    		                    <?php endfor;?>
    		                </select>
                        </div>
                        
                        <?php for($index = 1; $index <= CABIN_LIMIT; $index++):?>
				
        					<?php 
        						$cabin = isset($cabin_arrangements[$index]) ? $cabin_arrangements[$index] : array();
        					?>
        				
        				<div class="row form-group"  <?php if($index > $num_cabin):?>style="display: none;"<?php endif;?>" id="<?=$tour['id']?>_cabin_<?=$index?>">
        					
        					<div class="col-xs-12">
        						<label><?=lang('lbl_cabin_index', $index)?>:</label>
        						
        						<select class="form-control input-sm" name="<?=$tour['id']?>_type_<?=$index?>" id="<?=$tour['id']?>_type_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
        							
        							<?php foreach ($cabin_types as $k=>$value):?>
        								<option value="<?=$k?>" <?=set_select('type_'.$index, $k, $index <= $num_cabin && $cabin['type'] == $k)?>>
        									<?=translate_text($value)?>
        								</option>
        							<?php endforeach;?>
        		                </select>
        					</div>
        					
        					<div class="col-xs-4">
                                <label><?=lang('adults')?>:</label>
                                <select class="form-control input-sm" name="<?=$tour['id']?>_adults_<?=$index?>" id="<?=$tour['id']?>_adults_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
        							<?php for ($i = 0; $i <= 2; $i++):?>
        								<option value="<?=$i?>" <?=set_select('adults_'.$index, $i, $index <= $num_cabin && $cabin['adults'] == $i)?>>
        									<?=$i?>
        								</option>
        							<?php endfor;?>
        						</select>
        					</div>
        					<div class="col-xs-4">
                                <label style="white-space: nowrap;"><?=lang('children')?>:</label>
                                <select class="form-control input-sm" name="<?=$tour['id']?>_children_<?=$index?>" id="<?=$tour['id']?>_children_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
        		                    <?php for ($i = 0; $i <= 3; $i++):?>
        								<option value="<?=$i?>" <?=set_select('children_'.$index, $i, $index <= $num_cabin && $cabin['children'] == $i)?>>
        								<?=$i?>
        								</option>
        							<?php endfor;?>
        		                </select>
        					</div>
        					<div class="col-xs-4">
                                <label><?=lang('infants')?>:</label>
                                <select class="form-control input-sm" name="<?=$tour['id']?>_infants_<?=$index?>" id="<?=$tour['id']?>_infants_<?=$index?>" onchange="object_change_info('change_cabin', '<?=$tour['id']?>')">
        		                   <?php for ($i = 0; $i <= 3; $i++):?>
        								<option value="<?=$i?>" <?=set_select('infants_'.$index, $i, $index <= $num_cabin && $cabin['infants'] == $i)?>>
        									<?=$i?>
        								</option>
        							<?php endfor;?>
        		                </select>
        					</div>
        					
        				</div>
        				
        				<div style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>">
        					<label class="text-warning" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_1">
        						<span class="glyphicon glyphicon-warning-sign"></span>
        						<?=lang('label_max_3_pax_per_cabin')?>
        					</label>
        					<label class="text-warning" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_2">
        						<span class="glyphicon glyphicon-warning-sign"></span>
        						<?=lang('label_min_1_pax_per_cabin')?>
        					</label>
        					<label class="text-warning" style="display: none" id="<?=$tour['id']?>_errors_<?=$index?>_3">
        						<span class="glyphicon glyphicon-warning-sign"></span>
        						<?=lang('label_single_cabin_only_for_1_pax')?>
        					</label>
        				</div>	
        					
        				<?php endfor;?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-blue btn-block" id="btn_save_changes"
                        	value="<?=ACTION_CHECK_RATE?>"
                        	name="action" onclick="return tour_check_rate(<?=$tour['id']?>)">
                        	<?=lang('lbl_save_changes')?>
                        </button>
                    </div>
                </div>
            </div>
            </div>
			
			<input type="hidden" name="change_<?=$tour['id']?>" id="object_change_<?=$tour['id']?>" value="<?=!empty($check_rates['change'])? $check_rates['change'] : 'change_person'?>">
			
		<?php endif;?>
		
		<?php if(!$is_book_together):?>
		<div class="clearfix margin-top-20">
			<button type="submit" class="btn btn-blue btn-lg btn-block" value="<?=ACTION_CHECK_RATE?>" 
                name="action" onclick="return tour_check_rate(<?=$tour['id']?>)">
				<?=lang('check_rates')?>
			</button>
		</div>
		<?php endif;?>
    </div>
</div>

<?php if(!$is_book_together):?>
	</div>
</form>
<?php endif;?>

<script type="text/javascript">			
	<?php 
		$date_id = $datepicker_options['date_id'];
	?>
	$('#<?=$date_id?>').change();
	<?php if(!empty($check_rates)):?>
        $('#tour_tabs a[href="#tab_check_rates"]').tab('show');
		go_position('#frm_tour_check_rate_<?=$tour['id']?>');
	<?php endif;?>

	/**
	 * Click on the Tour Check Rate Button
	 * @author Khuyenpv
	 * @since March 17 2015
	 */
	function tour_check_rate(tour_id, is_ajax){

		var submit_return = false;
		
		var is_ajax = '<?=$is_ajax?>' == '1';

		// tour with cabin arrangement: validate the arrangement before submit
		<?php if(!empty($cabin_arrangements)):?>
			if(!check_error_check_rates(tour_id, <?=CABIN_LIMIT?>)){
		<?php endif;?>
					
			alert_travel_start_date('#<?=$date_id?>');

			// ajax submit
			if(is_ajax){

				var form_id = '#frm_tour_check_rate_<?=$tour['id']?>';

				var url = $(form_id).attr('action');	
				
				var area_id = '#<?='tour_'.$tour['id']?>';
				
				var dataString = $(form_id).serialize();

				$('div'+area_id).html('');
				show_loading_data(true, area_id);
				
				$.ajax({
					url: url,
					type: "GET",
					data: dataString,
					success:function(value){
						$('div'+area_id).html(value);
						show_loading_data(false);
					}
				});
				
			
				submit_return = false;
				
			} else { // normal submit

				submit_return = true;
			}
				
		<?php if(!empty($cabin_arrangements)):?>
			}
		<?php endif;?>

		

		return submit_return;		
	}
</script>