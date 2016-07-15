<div class="container margin-top-10">
    <div class="visa-booking-summary">
        <?php if(!empty($visa_booking['total_price'])):?>
        <label class="text-highlight">
        <?=$visa_booking['number_of_visa']?> <?=$visa_booking['number_of_visa'] < 2 ?' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>,
        <?php 
    		foreach ($types as $key => $type)  {
    			if($key == $visa_booking['type_of_visa']) {
    				echo translate_text($type);
    			}
    		}
    	?>,
    	<?php 
    		foreach ($rush_services as $key => $service) {
    			if($key == $visa_booking['processing_time']) {
    				echo strtolower(translate_text($service).' '.lang('lb_processing'));
    			}
    		}
    	?>
        </label>
        <?php endif;?>
        
        <a id="change_search" href="javascript:change_visa_options()"><?=lang('change_visa_options')?></a>
    </div>
</div>

<div class="clearfix visa-rates no-border margin-bottom-20" id="update_visa_form">
	
	<input type="hidden" value="" name="action">
	<?php if(isset($rowId)):?>
	<input type="hidden" value="<?=$rowId?>" name="rowId">
	<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
	<?php endif;?>
	
	<h2 class="text-highlight col-xs-12 margin-top-0"><?=lang('apply_for_voa_short')?></h2>
	<div class="form-group col-xs-12">
		<label class="control-label"><?=lang('select_your_nationality')?>: <?=mark_required()?></label>
		<select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()" class="form-control">
			<option value="0">-- <?=lang('please_select_nationality')?> --</option>
			<?php foreach ($voa_countries as $country) :?>
			<option value="<?=$country['id']?>" <?=set_select('visa_nationality', $country['id'], $country['id'] == $visa_booking['nationality'])?>>
			<?=$country['name']?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
    <div class="form-group col-xs-12">
		<label class="control-label"><?=lang('number_of_visa')?>:</label>
		<select name="numb_visa" id="numb_visa" onchange="get_visa_rates()" class="form-control input-sm">
			<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
			<?php for ($i=1; $i <= $max_application; $i++) :?>
			<option value="<?=$i?>" <?=set_select('numb_visa', $i, $i == $visa_booking['number_of_visa'])?>>
				<?=$i?><?=$i < 2 ? ' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
			</option>
			<?php endfor;?>
		</select>
	</div>
	<div class="form-group col-xs-12">
		<label class="control-label"><?=lang('type_of_visa')?>:</label>
		<select name="visa_type" id="visa_type" onchange="get_visa_rates()" class="form-control">
			<?php foreach ($types as $key => $type) :?>
			<option value="<?=$key?>" <?=set_select('visa_type', $key, $key == $visa_booking['type_of_visa'])?>>
			<?=translate_text($type)?>
			</option>
			<?php endforeach;?>
		</select>
	</div>
	
	<div class="form-group col-xs-12">
		<label><?=lang('processing_time')?>:</label>
		<span class="process_note"><?=lang('from_monday_to_friday')?></span>
		<div class="list-group">
			<?php foreach ($rush_services as $key => $service) :?>
			<div class="radio list-group-item">
                <label>
				<input type="radio" name="rush_service" value="<?=$key?>" 
				    <?=set_checkbox('rush_service', $key, $key == $visa_booking['processing_time'])?> 
					onclick="get_visa_rates()" title="<?=translate_text($service)?>">
				<?=translate_text($service)?> <span><?=translate_text($service.'_note')?></span>
				</label>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	
	<div class="clearfix hr" id="div_service_fee">
        <label class="col-xs-6"><?=lang('visa_service_fee')?>:</label>
		<div class="col-xs-6 text-right" id="visa_from_price">
            <?=!empty($visa_booking['price']) ? CURRENCY_SYMBOL.$visa_booking['price'].' x '.$visa_booking['number_of_visa'] : ''?>
		</div>
    </div>
    
    <div class="clearfix hr">
        <div class="col-xs-6">
            <span><?=lang('total_service_fee')?>:</span>
            <span class="note"><?=lang('exclude_stamp_fee')?></span>
        </div>
        <div class="col-xs-6 text-right price-from" id="visa_total_fee">
            <?=!empty($visa_booking['total_price']) ? CURRENCY_SYMBOL.($visa_booking['total_price']-$visa_booking['total_discount']) : ''?>
        </div>
    </div>
	
	<div class="col-xs-12 margin-top-10">
        <div class="btn btn-blue btn-block" onclick="edit_visa_booking()"><?=lang('lb_update')?></div>
	</div>
</div>