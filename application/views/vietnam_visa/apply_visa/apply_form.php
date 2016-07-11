<div id="visa-rates-form" class="visa-rates">
	<h2 class="text-highlight"><?=lang('apply_visa')?></h2>
	<div class="form-horizontal col-xs-6">
		<input type="hidden" value="" name="action">
		<?php if(isset($rowId)):?>
		<input type="hidden" value="<?=$rowId?>" name="rowId">
		<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
		<?php endif;?>
		<div class="form-group">
			<label class="col-xs-4 control-label"><?=lang('number_of_visa')?>:</label>
			<div class="col-xs-8">
				<select name="numb_visa" id="numb_visa" onchange="get_visa_rates()" class="form-control">
					<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
					<?php for ($i=1; $i <= $max_application; $i++) :?>
					<option value="<?=$i?>" 
						<?php 
							if(isset($is_visa_details)) {
								echo set_select('numb_visa', $i, $i == $visa_booking['number_of_visa']? true : false);
							} else {
								echo set_select('numb_visa', $i, $i == 1);
							}
						?>
					>
						<?=$i?><?=$i < 2 ? ' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
					</option>
					<?php endfor;?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label"><?=lang('type_of_visa')?>:</label>
			<div class="col-xs-8">
				<select name="visa_type" id="visa_type" onchange="get_visa_rates()" class="form-control">
					<?php foreach ($types as $key => $type) :?>
					<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
					<?=translate_text($type)?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-4 control-label"><?=lang('your_nationality')?>: <?=mark_required()?></label>
			<div class="col-xs-8">
				<select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()" class="form-control">
					<option value="0">-- <?=lang('please_select_nationality')?> --</option>
					<?php foreach ($voa_countries as $country) :?>
					<option value="<?=$country['id']?>" 
					<?php if(isset($visa_req_nationality)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_req_nationality ? true : false)?>
					<?php if(isset($is_visa_details)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_booking['nationality'] ? true : false)?>>
					<?=$country['name']?>
					</option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-xs-4 text-right">
                <label><?=lang('processing_time')?>:</label><br>
                <span class="process_note"><?=lang('from_monday_to_friday')?></span>
			</div>
			<div class="col-xs-8 processing-time">
				<?php foreach ($rush_services as $key => $service) :?>
				<div class="radio">
                    <label>
					<input type="radio" name="rush_service" value="<?=$key?>" 
						<?php 	
							if(isset($is_visa_details)) {
								echo set_checkbox('rush_service', $key, $key == $visa_booking['processing_time']? true : false);
							} else {
								echo set_checkbox('rush_service', $key, $key == 1? true : false);
							}
						?> 
						onclick="get_visa_rates()" title="<?=translate_text($service)?>">
					<?=translate_text($service)?> <span><?=translate_text($service.'_note')?></span>
					</label>
				</div>
				<?php endforeach;?>
			</div>
		</div>
		<div class="col-xs-12 form-group margin-top-20">
			<?=load_free_visa_popup($is_mobile)?>
		</div>
	</div>
	<div class="col-xs-6">
        <div class="rate-calc">
    		<div class="rate-arrow">
    			<div class="arrow-before"></div>
    			<div class="arrow-after"></div>
    		</div>
    		<div class="row hr">
				<div class="col-xs-4"><b><?=lang('your_selections')?>:</b></div>
				<div id="your_selections" class="col-xs-8">
				<?php if(!empty($visa_booking['total_price'])):?>
				<ul>
					<li id="selection_nationality">
						<?=$visa_booking['number_of_visa']?> <?=$visa_booking['number_of_visa'] < 2 ?' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
						<?php 
							foreach ($countries as $country) {
								if($country['id'] == $visa_booking['nationality']) {
									echo ' - '.$country['name'];
								}
							}
						?>
					</li>
					<li id="selection_visa_type">
					<?php 
						foreach ($types as $key => $type)  {
							if($key == $visa_booking['type_of_visa']) {
								echo translate_text($type);
							}
						}
					?>
					</li>
					<li id="selection_rush_service">
					<?php 
						foreach ($rush_services as $key => $service) {
							if($key == $visa_booking['processing_time']) {
								echo translate_text($service).' '.lang('lb_processing');
							}
						}
					?>
					</li>
				</ul>
				<?php else:?>
				<ul class="list-unstyled">
					<li id="selection_nationality"><?=lang('please_fill_the_apply_form')?></li>
					<li id="selection_visa_type">&nbsp;</li>
					<li id="selection_rush_service">&nbsp;</li>
				</ul>
				<?php endif;?>
				</div>
			</div>
			<div class="row padding-bottom-5">
                <div class="col-xs-8"><?=lang('recevei_approval_letter')?>:</div>
                <div class="col-xs-4 text-right" id="selection_receive_date"></div>
			</div>
			<div class="row" id="div_service_fee">
                <div class="col-xs-4"><?=lang('visa_service_fee')?>:</div>
                <div class="col-xs-8 text-right" id="visa_from_price">
                <?php if(isset($visa_booking['total_price'])):?>
                    <?php echo '$'.$visa_booking['price'].' x '.$visa_booking['number_of_visa'];?>
                <?php endif;?>
                </div>
			</div>
			<?php if(isset($visa_booking['total_discount']) && !empty($visa_booking['total_discount'])):?>
				<div class="row" id="div_discount">
					<div class="col-xs-4"><?=lang('lb_discount_for_booking_together')?>:</div>
					<div class="col-xs-8 text-right" id="visa_discount"><?php echo '-$'.$visa_booking['total_discount'];?></div>
				</div>
			<?php else:?>
				<div class="row" id="div_discount">
					<div class="col-xs-4"><?=lang('lb_discount_for_booking_together')?>:</div>
					<div class="col-xs-8 text-right" id="visa_discount"></div>
				</div>
			<?php endif;?>
			
			<div class="row" id="div_total_fee">
                <div class="col-xs-4"><b><?=lang('total_service_fee')?>:</b> <span id="visa_price_note"><?=lang('exclude_stamp_fee')?></span></div>
    			<div class="col-xs-8 text-right price-from" id="visa_total_fee">
                    <?php if(isset($visa_booking['total_price'])):?>
        				<?php echo '$'.($visa_booking['total_price']-$visa_booking['total_discount']);?>	
        			<?php endif;?>
    			</div>
			</div>
			<div class="row">
                <div class="col-xs-6">
                </div>
                <div class="col-xs-6 margin-top-10">
                    <div class="btn btn-blue btn-block" onclick="book_visa('apply')">
						<?=lang('lb_next')?>
					</div>
                </div>
			</div>
    	</div>
	</div>
</div>
<script>
get_visa_rates();
</script>