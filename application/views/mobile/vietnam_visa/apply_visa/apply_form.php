<div id="visa-rates-form" class="visa-rates clearfix">
	<h2 class="text-highlight col-xs-12 margin-top-0"><?=lang('apply_for_voa_short')?></h2>
	
	<input type="hidden" value="" name="action">
	
    <?php if(isset($rowId)):?>
    <input type="hidden" value="<?=$rowId?>" name="rowId">
    <input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
    <?php endif;?>
        
	<div class="col-xs-12 form-group">
        <label class="control-label"><?=lang('select_your_nationality')?></label>
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
	
	<div class="col-xs-6 form-group">
        <label class="control-label"><?=lang('number_of_visa')?>:</label>
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
	<div class="col-xs-6 form-group">
        <label class="control-label"><?=lang('type_of_visa')?>:</label>
        <select name="visa_type" id="visa_type" onchange="get_visa_rates()" class="form-control">
        	<?php foreach ($types as $key => $type) :?>
        	<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
        	<?=translate_text($type)?>
        	</option>
        	<?php endforeach;?>
        </select>
	</div>
	
	<div class="col-xs-12 form-group">
        <label><?=lang('processing_time')?>:</label> <span class="text-price process_note"><?=lang('from_monday_to_friday')?></span>
        <div class="list-group">
            <?php foreach ($rush_services as $key => $service) :?>
    		<div class="radio list-group-item">
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
	
	<div class="hr">
        <div class="col-xs-12"><b><?=lang('your_selections')?>:</b></div>
    	<div class="col-xs-12 text-right" id="your_selections">
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
    	
    	<div class="clearfix">
            <div class="col-xs-8"><?=lang('recevei_approval_letter')?>:</div>
            <div class="col-xs-4 text-right" id="selection_receive_date"></div>
        </div>
	</div>
	
	<div class="clearfix hr">
        <div class="col-xs-5"><?=lang('visa_service_fee')?>:</div>
        <div class="col-xs-7 text-right" id="visa_from_price">
        <?php if(isset($visa_booking['total_price'])):?>
            <?php echo '$'.$visa_booking['price'].' x '.$visa_booking['number_of_visa'];?>
        <?php endif;?>
        </div>
	</div>
	
	<div class="clearfix form-group hr" id="div_total_fee">
        <div class="col-xs-6"><b><?=lang('total_service_fee')?>:</b> <span class="note" id="visa_price_note"><?=lang('exclude_stamp_fee')?></span></div>
    	<div class="col-xs-6 text-right price-from" id="visa_total_fee">
            <?php if(isset($visa_booking['total_price'])):?>
    			<?php echo '$'.($visa_booking['total_price']-$visa_booking['total_discount']);?>	
    		<?php endif;?>
    	</div>
    </div>
    
	<div class="col-xs-12">
        <div class="btn btn-blue btn-block btn-lg" onclick="book_visa('apply')"><?=lang('lb_apply_now')?></div>
    </div>
</div>
<script>
get_visa_rates();
</script>