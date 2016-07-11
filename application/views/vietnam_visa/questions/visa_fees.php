<h1 class="text-highlight"><?=lang('vietnam_visa_fee_title')?></h1>
<p style="font-size: 13px"><?=lang('vietnam_visa_fee_two_kinds')?></p>
<h2><?=lang('vietnam_visa_fee_first_kind')?></h2>
<p><?=lang('vietnam_visa_fee_first_kind_content')?></p>
<h2><?=lang('vietnam_visa_fee_second_kind')?></h2>
<p><?=lang('vietnam_visa_fee_second_kind_content')?></p>
<table class="table table-bordered table-rates">
	<thead>
		<tr>
        	<td rowspan="3" align="center" valign="middle"><b class="medium-font"><?=lang('visa_types')?></b></td>
			<td colspan="4" align="center" valign="middle"><b class="medium-font"><?=lang('lb_service_fee')?></b><br><?=lang('cost_per_person_usd')?></td>
			<td rowspan="3"  align="center" valign="middle">
				<b class="medium-font"><?=lang('lb_stamp_fee')?></b>
				<br><?=lang('cost_per_person_usd')?>
				<br><?=lang('paid_at_airport')?>
			</td>
		</tr>
		<tr>
       		<td colspan="3" align="center" valign="middle"><b><?=lang('lb_normal_processing')?></b></td>
    		<td rowspan="2" align="center" valign="middle"><b><?=lang('urgent_processing_br')?></b></td>
        </tr>
		<tr>
			<?php for ($i=1; $i <= $max_application; $i++) :?>
				<?php if($i == 1):?>
				<td align="center">1-3 <?=lang('lb_pax')?></td>
				<?php endif;?>
				<?php if($i == 4):?>
				<td align="center">4-5 <?=lang('lb_pax')?></td>
				<?php endif;?>
				<?php if($i == 6):?>
				<td align="center">6-10 <?=lang('lb_pax')?></td>
				<?php endif;?>
			<?php endfor;?>
		</tr>
	</thead>
	<tbody>
		<?php $cnt = 1?>
		<?php foreach ($visa_types as $key => $type) :?>
		<tr>
			<td nowrap="nowrap"><?=translate_text($type)?></td>
			<?php for ($i=1; $i <= $max_application; $i++) :?>
				<?php if($i == 1 || $i == 4 || $i == 6):?>
				<td align="center"><?=$rates_table[$key][$i-1]['price']?></td>
				<?php endif;?>
			<?php endfor;?>
			<td align="center">plus <?=$rates_table[$key][0]['urgent_price']?></td>
			<td align="center"><?php echo $visa_stamp_fee[$cnt]?></td>
		</tr>
		<?php $cnt++?>
		<?php endforeach;?>
	</tbody>
</table>

<?php
	$stamp_fee_table = ''; 
	foreach($visa_stamp_fee as $k => $fee) {
		$stamp_fee_table.= $fee;
		if($k < count($visa_stamp_fee)) $stamp_fee_table.= ',';;
	}
?>

<h3><?=lang('visa_service_fee_calculator')?></h3>
<div class="form-horizontal" style="background-color: #f8f8f8; padding: 15px 10px 10px; border: 1px solid #ccc">
	<form id="frmApplyVisaDetail" method="post" action="<?=get_page_url(VN_VISA_DETAILS_PAGE)?>">
	
    	<input type="hidden" value="" name="action">
    	<input type="hidden" id="no_discount" value="1">
    	<input type="hidden" id="stemp_fee_table" value="<?php echo $stamp_fee_table;?>">
    	
    	<div class="form-group">
            <label class="col-xs-3 control-label"><?=lang('select_your_nationality')?></label>
            <div class="col-xs-4">
               <select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()" class="form-control">
            		<option value="0">-- <?=lang('please_select_nationality')?> --</option>
            		<?php foreach ($voa_countries as $country) :?>
            		<option value="<?=$country['id']?>"><?=$country['name']?></option>
            		<?php endforeach;?>
            	</select>
            </div>
    	</div>
    	<div class="form-group">
            <label class="col-xs-3 control-label"><?=lang('number_of_visa')?></label>
            <div class="col-xs-4">
               <select name="numb_visa" id="numb_visa" onchange="get_visa_rates()" class="form-control">
            		<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
            		<?php for ($i=1; $i <= $max_application; $i++) :?>
            		<option value="<?=$i?>">
            			<?=$i?><?=$i<2?' applicant':' applicants'?>
            		</option>
            		<?php endfor;?>
            	</select>
            </div>
    	</div>
    	<div class="form-group">
            <label class="col-xs-3 control-label"><?=lang('type_of_visa')?></label>
            <div class="col-xs-4">
               <select name="visa_type" id="visa_type" onchange="get_visa_rates()" class="form-control">
            		<?php foreach ($visa_types as $key => $type) :?>
            		<option value="<?=$key?>">
            		<?=translate_text($type)?>
            		</option>
            		<?php endforeach;?>
            	</select>
            </div>
    	</div>
    	<div class="form-group">
            <label class="col-xs-3 control-label"><?=lang('processing_time')?></label>
            <div class="col-xs-3">
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
                	<?=translate_text($service)?> <span style="font-size: 11px"><?=translate_text($service.'_note')?></span>
                 </label>
                 </div>
                <?php endforeach;?>
    	    </div>
    	</div>
    	<div class="form-group" style="border-top: 1px solid #ccc; padding-top: 10px">
            <div class="col-xs-6">
                <div class="row">
                    <label class="col-xs-6 control-label"><?=lang('lb_service_fee')?>:</label>
                    <div class="col-xs-6" style="padding-top: 4px">
                        <span id="visa_from_price"></span>
                        <span id="visa_total_fee" class="text-price"></span><br>
                    </div>
                </div>
    			<div class="row">
                    <label class="col-xs-6 control-label"><?=lang('lb_stamp_fee')?>:</label>
                    <div class="col-xs-6" style="padding-top: 7px">
                        <span id="stamp_fee"></span>
                        <span id="stamp_total_fee" class="text-price"></span>
                    </div>
    			</div>
            </div>
            <div class="col-xs-6 text-right">
                <div class="btn btn-blue btn-lg" onclick="book_visa('apply')">
                <?=lang('lb_apply_now')?>
                </div>
            </div>
    	</div>
	</form>
</div>

<div class="margin-top-20">
    <h4><b><?=lang('related_visa_information')?></b></h4>
    <?=$top_visa_questions?>
</div>
<script>
	// refresh event
	get_visa_rates();
</script>