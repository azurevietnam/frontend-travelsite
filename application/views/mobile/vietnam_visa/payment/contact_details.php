<h3 class="text-highlight border-title"><?=lang('contact_details')?></h3>
<div class="form-horizontal margin-top-10">
    <div class="row">
        <div class="col-xs-12"><?=note_required()?></div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('full_name')?>: <?=mark_required()?></label>
        <div class="col-xs-1">
            <select name="title" class="form-control">
    			<option value="1" <?=set_select('title', '1')?>><?=lang('lb_mr')?></option>
    			<option value="2" <?=set_select('title', '2')?>><?=lang('lb_ms')?></option>					
    		</select>
        </div>
        <div class="col-xs-3">
            <input type="text" name="full_name" class="form-control" maxlength="50" value="<?=set_value('full_name')?>" tabindex="1"/>
        </div>
        <label class="col-xs-4 control-label" style="text-align: left;">
            <?=form_error('full_name')?>
        </label>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('email_address')?>: <?=mark_required()?></label>
        <div class="col-xs-4">
            <input type="text" name="email" class="form-control" maxlength="50" value="<?=set_value('email')?>" tabindex="2"/>
        </div>
        <label class="col-xs-4 control-label" style="text-align: left;">
            <?=form_error('email')?>
        </label>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('email_address_confirm')?>: <?=mark_required()?></label>
        <div class="col-xs-4">
            <input type="text" name="email_cf" id="email_cf" class="form-control" maxlength="50" value="<?=set_value('email_cf')?>" tabindex="3" autocomplete="off"/>
        </div>
        <label class="col-xs-4 control-label" style="text-align: left;">
            <?=form_error('email_cf')?>
        </label>
    </div>
    <div class="form-group">
        <div class="col-xs-10 col-xs-offset-2">
            <span style="color: red;">(*)&nbsp;</span> <span style="font-size: 11px"><?=lang('spam_email_notify')?></span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('phone_number')?>: <?=mark_required()?></label>
        <div class="col-xs-4">
            <input type="text" name="phone" class="form-control" maxlength="30" value="<?=set_value('phone')?>" tabindex="4"/>
        </div>
        <label class="col-xs-4 control-label" style="text-align: left;">
            <?=form_error('phone')?>
        </label>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('fax_number')?>:</label>
        <div class="col-xs-4"><input type="text" name="fax" class="form-control" maxlength="30" value="<?=set_value('fax')?>" tabindex="5"/></div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('country')?>: <?=mark_required()?></label>
        <div class="col-xs-4">
            <select name="country" tabindex="6" class="form-control">
    			<option value=""><?='-- ' . lang('select_country') .' --'?></option>
    			<?php foreach ($countries as $key => $country) :?>
    			<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
    			<?php endforeach;?>
    		</select>
        </div>
        <label class="col-xs-4 control-label" style="text-align: left;">
            <?=form_error('country')?>
        </label>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('city')?>:</label>
        <div class="col-xs-4">
            <input type="text" name="city" class="form-control" maxlength="100" value="<?=set_value('city')?>" tabindex="7"/>
        </div>
    </div>
    <div class="form-group">
        <label class="col-xs-2 control-label"><?=lang('special_requests')?>:</label>
        <div class="col-xs-8">
            <textarea name="special_requests" cols="66" rows="5" tabindex="8" class="form-control"><?=set_value('special_requests')?></textarea>
        </div>
    </div>
</div>