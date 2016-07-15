<div id="dv_err" class="error margin-bottom-5">
	<?=lang('please_review_and_correct_information')?>
</div>
<?php foreach ($visa_booking['visa_details'] as $key => $applicant):?>
<div class="bpv-panel" id="app_<?=$key?>">
    <div class="panel-heading"><b><?=lang('lbl_visa_applications') .' '.($key+1)?></b></div>
    <div class="panel-body rate-tables">
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_full_name')?></b></div>
            <div class="col-xs-6 no-padding text-right" id="app_passport_name<?=$key?>">
            <?=$applicant['passport_name']?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_gender')?></b></div>
            <div class="col-xs-6 no-padding text-right" id="app_gender<?=$key?>">
            <?=$applicant['gender'] == 1 ? lang('lb_male') : lang('lb_female')?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_date_of_birth')?></b></div>
            <div class="col-xs-6 no-padding text-right" id="app_birthday<?=$key?>">
            <?=!empty($applicant['birthday']) ? date(DATE_FORMAT_DISPLAY, strtotime($applicant['birthday'])) : ''?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_nationality')?></b></div>
            <div class="col-xs-6 no-padding text-right" id="app_nationality<?=$key?>">
            <?=$applicant['nationality_name']?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_passport_number')?></b></div>
            <div class="col-xs-6 no-padding text-right" id="app_passport_number<?=$key?>">
            <?=$applicant['passport_number']?>
            </div>
        </div>
        <div class="row no-border">
            <div class="col-xs-12 no-padding text-right">
            <a href="javascript:void(0)" style="text-decoration: underline;" onclick="_edit_applicant(<?=$key?>)"><?=lang('lb_edit')?></a>
            </div>
        </div>
     </div>
</div>

<div class="bpv-panel" id="edit_app_<?=$key?>" style="display: none;">
    <div class="panel-heading">
    <b><?=lang('lbl_visa_applications') .' '.($key+1)?></b>
    <input type="hidden" name="passport_expired<?=$key?>" value="<?=$applicant['passport_expired']?>">
    </div>
    <div class="panel-body rate-tables">
        <div class="row no-border">
            <div class="col-xs-12 no-padding">
                <span><b><?=lang('lb_full_name')?></b></span>
                <input type="text" maxlength="100" name="passport_name<?=$key?>" id="passport_name<?=$key?>" class="form-control" 
    			value="<?=set_value('passport_name'.$key, $applicant['passport_name']); ?>">
            </div>
        </div>
        <div class="row no-border">
            <div class="col-xs-12 no-padding">
                <span><b><?=lang('lb_gender')?></b></span>
                <select name="gender<?=$key?>" id="gender<?=$key?>" class="form-control">
        			<option value=""><?=lang('label_please_select')?></option>
        			<option value="1" <?=set_select('gender'.$key, 1, $applicant['gender']==1)?>><?=lang('lb_male')?></option>
        			<option value="2" <?=set_select('gender'.$key, 2, $applicant['gender']==2)?>><?=lang('lb_female')?></option>
        		</select>
            </div>
        </div>
        <?php 
			// lowest year wanted
			$cutoff = 1910;
			// current year
			$now = date('Y');
			
			$cr_day = !empty($applicant['birthday']) ? date("j",strtotime($applicant['birthday'])) : null;
			$cr_month = !empty($applicant['birthday']) ? date("n",strtotime($applicant['birthday'])) : null;
			$cr_year = !empty($applicant['birthday']) ? date("Y",strtotime($applicant['birthday'])) : null;
		?>
        <div class="row no-border">
            <div class="col-xs-12 no-padding"><b><?=lang('lb_date_of_birth')?></b></div>
            <div class="col-xs-4 no-padding">
                <select id="birth_day<?=$key?>" name="birth_day<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_day')?></option>
    				<?php for ($d=1; $d<=31; $d++):?>
    				<option value="<?=$d?>" <?=set_select('birth_day'.$key, $d, $cr_day==$d)?>><?=$d?></option>
    				<?php endfor;?>
    			</select>
    		</div>
    		<div class="col-xs-4 no-padding">
    			<select id="birth_month<?=$key?>" name="birth_month<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_month')?></option>
    				<?php for ($m=1; $m<=12; $m++):?>
    				<option value="<?=$m?>" <?=set_select('birth_month'.$key, $m, $cr_month==$m); ?>><?=date('F', mktime(0,0,0,$m,10))?></option>
    				<?php endfor;?>
    			</select>
    		</div>
    		<div class="col-xs-4 no-padding">
    			<select id="birth_year<?=$key?>" name="birth_year<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_year')?></option>
    				<?php for ($y=$now; $y>=$cutoff; $y--):?>
    				<option value="<?=$y?>" <?=set_select('birth_year'.$key, $y, $cr_year==$y); ?>><?=$y?></option>
    				<?php endfor;?>
    			</select>
    		</div>
    		<input type="hidden" id="birthday<?=$key?>" name="birthday<?=$key?>" value="">
        </div>
        <div class="row no-border">
            <div class="col-xs-12 no-padding">
                <span><b><?=lang('lb_nationality')?></b></span>
                <select id="nationality<?=$key?>" name="nationality<?=$key?>" class="form-control">
        			<option value=""> -- <?=lang('please_select_nationality')?> -- </option>
        			<?php foreach ($visa_countries as $country) :?>
        				<option value="<?=$country['id']?>" <?=set_select('nationality'.$key , $country['id'], $country['id']==$applicant['nationality'])?>><?=$country['name']?></option>
        			<?php endforeach;?>
        		</select>
        		<input type="hidden" name="nationality_name<?=$key?>" id="nationality_name<?=$key?>" value="">
            </div>
        </div>
        <div class="row no-border">
            <div class="col-xs-12 no-padding">
                <span><b><?=lang('lb_passport_number')?></b></span>
                <input type="text" name="passport_number<?=$key?>" id="passport_number<?=$key?>" maxlength="20" class="form-control"
    			value="<?=set_value('passport_number'.$key, $applicant['passport_number']); ?>">
            </div>
        </div>
        <div class="row no-border">
            <div class="col-xs-12 no-padding text-right">
            <a href="javascript:void(0)" style="text-decoration: underline;" onclick="_update_applicant('update', <?=$key?>)"><?=lang('lb_done')?></a>
            </div>
        </div>
     </div>
</div>
<?php endforeach;?>
