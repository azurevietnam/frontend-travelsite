<form id="frmApplyVisaDetail" method="post" action="<?=get_page_url(VN_VISA_DETAILS_PAGE)?>">

<input type="hidden" value="" name="action">
<?php if(isset($rowId)):?>
<input type="hidden" value="<?=$rowId?>" name="rowId">
<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
<?php endif;?>

<div class="search-form <?=empty($common_ad)?  '' : 'searh-form-position padding-5'?>">
    <h2 class="text-highlight">
    <span class="icon icon-search-white margin-right-5"></span><?=lang('apply_for_voa_short')?>
    </h2>
    
    <div class="search-form-type-2">
        <div class="row form-group">
            <label for="numb_visa" class="item-label col-xs-5"><?=lang('number_of_visa')?>:</label>
            <div class="col-xs-7">
                <select name="numb_visa" id="numb_visa" onchange="get_visa_rates()" class="form-control bpt-input-xs">
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
        <div class="row form-group">
            <label for="visa_type" class="item-label col-xs-5"><?=lang('type_of_visa')?>:</label>
            <div class="col-xs-7">
                <select name="visa_type" id="visa_type" onchange="get_visa_rates()" class="form-control bpt-input-xs">
        			<?php foreach ($types as $key => $type) :?>
        			<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
        			<?=translate_text($type)?>
        			</option>
        			<?php endforeach;?>
        		</select>
    		</div>
        </div>
        <div class="row form-group">
            <label for="visa_nationality" class="item-label col-xs-5"><?=lang('your_nationality')?>: <?=mark_required()?></label>
            <div class="col-xs-7">
                <select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()" class="form-control bpt-input-xs">
        			<option value="0">-- <?=lang('lb_please_select')?> --</option>
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
            <label class="item-label"><?=lang('processing_time')?>: <span class="process_note"><?=lang('from_monday_to_friday')?></span></label>
            <ul class="list-unstyled">
    			<?php foreach ($rush_services as $key => $service) :?>
    			<li>
    				<input type="radio" name="rush_service" value="<?=$key?>" 
    				<?php 	
    					if(isset($is_visa_details)) {
    						echo set_checkbox('rush_service', $key, $key == $visa_booking['processing_time']? true : false);
    					} else {
    						echo set_checkbox('rush_service', $key, $key == 1? true : false);
    					}
    				?> 
    				onclick="get_visa_rates()" title="<?=translate_text($service)?>">
    				<?=translate_text($service)?> <?=translate_text($service.'_note')?>
    			</li>
    			<?php endforeach;?>
    		</ul>
        </div>
        <div class="row form-group">
            <div class="col-xs-6">
            </div>
            <div class="col-xs-6">
                <ul class="list-unstyled text-right">
        			<li><b><?=lang('total_service_fee')?>:</b></li>
        			<li class="price-from" id="visa_total_fee"></li>
        		</ul>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-xs-offset-6">
                <div class="btn btn-blue btn-block" onclick="book_visa('apply')"><?=lang('lb_apply_now')?></div>
            </div>
    	</div>
    </div>
</div>
</form>
<script>
	get_visa_rates();
</script>