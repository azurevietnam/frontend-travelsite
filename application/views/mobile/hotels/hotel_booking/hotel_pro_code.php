<p class="margin-bottom-20">*<?=lang('hotel_promotion_code_note')?>:</p>
				
<div class="row">
	<div class="col-xs-3" style="width:177px;"></div>
	<div class="col-xs-6">
		<p class="text-warning" id="code_invalid_2" style="display:none">
			<span class="glyphicon glyphicon-warning-sign"></span>
			<?=lang('bpv_pro_code_invalid')?>
		</p>
		<p class="text-warning pro_phone_invalid" style="display:none">
            <span class="glyphicon glyphicon-warning-sign"></span>
            <span class="pro_phone_invalid_msg"><?=lang('bpv_pro_phone_invalid')?></span>
		</p>
		<p class="text-success" id="code_ok_2" style="display:none">
			<span class="glyphicon glyphicon-ok"></span>
			<?=lang('bpv_pro_code_ok')?>
		</p>
	</div>
</div>
				
<div class="row pro-code margin-bottom-10">
	<div class="col-xs-3" style="width:177px;padding-top:7px"><b><?=lang('bpv_pro_code')?>:</b></div>
	<div class="col-xs-3">
		<input type="text" class="form-control" value="" id="pro_code_2" placeholder="ABCXYZ..." style="font-weight:normal">
	</div>
	<div class="pro_phone_block col-xs-4" style="display: none; padding: 0">
    	<div class="col-xs-4" style="padding-top:7px"><b><?=lang('lbl_phone')?></b></div>
    	<div class="col-xs-8">
    		<input type="text" class="form-control" value="" id="pro_phone_2" placeholder="" style="font-weight:normal">
    	</div>
	</div>
	<div class="col-xs-3">
		<button type="button" class="btn btn-bpv btn-book-now" id="pro_use_2" style="display:none" onclick="use_pro_code(<?=HOTEL?>)" data-loading-text="<?=lang('bpv_pro_code_loading')?>">
			<?=lang('bpv_pro_use')?>
		</button>
	</div>
</div>