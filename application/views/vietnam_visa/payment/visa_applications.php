<div id="dv_err" class="error">
	<?=lang('please_review_and_correct_information')?>
</div>
<table class="table table-bordered">
    <caption><?=lang('lbl_visa_applications')?>.</caption>
    <thead>
		<tr>
			<th class="text-center" width="3%" nowrap="nowrap">#</th>
			<th align="left"><?=lang('lb_full_name')?></th>
			<th align="left"><?=lang('lb_gender')?></th>
			<th align="left"><?=lang('lb_date_of_birth')?></th>
			<th align="left"><?=lang('lb_nationality')?></th>
			<th align="left"><?=lang('lb_passport_number')?></th>
			<th align="center"></th>
		</tr>
	</thead>
	<tbody id="applicant_details">
	<?php foreach ($visa_booking['visa_details'] as $key => $applicant):?>
	<tr id="app_<?=$key?>">
		<td align="center"><?=$key+1?></td>
		<td id="app_passport_name<?=$key?>"><?=$applicant['passport_name']?></td>
		<td id="app_gender<?=$key?>">
            <?=$applicant['gender'] == 1 ? lang('lb_male') : lang('lb_female')?>
		</td>
		<td id="app_birthday<?=$key?>">
            <?=!empty($applicant['birthday']) ? date(DATE_FORMAT_DISPLAY, strtotime($applicant['birthday'])) : ''?>
		</td>
		<td id="app_nationality<?=$key?>"><?=$applicant['nationality_name']?></td>
		<td id="app_passport_number<?=$key?>"><?=$applicant['passport_number']?></td>
		<td align="center">
			<a href="javascript:void(0)" style="text-decoration: underline;" onclick="_edit_applicant(<?=$key?>)"><?=lang('lb_edit')?></a>
		</td>
	</tr>
	<tr id="edit_app_<?=$key?>" style="display: none;">
		<td align="center">
			<?=$key+1?>
			<input type="hidden" name="passport_expired<?=$key?>" value="<?=$applicant['passport_expired']?>">
		</td>
		<td>
			<input type="text" maxlength="100" name="passport_name<?=$key?>" id="passport_name<?=$key?>" class="form-control" 
				value="<?=set_value('passport_name'.$key, $applicant['passport_name']); ?>">
		</td>
		<td>
			<select name="gender<?=$key?>" id="gender<?=$key?>" class="form-control">
				<option value=""><?=lang('label_please_select')?></option>
				<option value="1" <?=set_select('gender'.$key, 1, $applicant['gender']==1)?>><?=lang('lb_male')?></option>
				<option value="2" <?=set_select('gender'.$key, 2, $applicant['gender']==2)?>><?=lang('lb_female')?></option>
			</select>
		</td>
		<td>
			<?php 
				// lowest year wanted
				$cutoff = 1910;
				// current year
				$now = date('Y');
				
				$cr_day = !empty($applicant['birthday']) ? date("j",strtotime($applicant['birthday'])) : null;
				$cr_month = !empty($applicant['birthday']) ? date("n",strtotime($applicant['birthday'])) : null;
				$cr_year = !empty($applicant['birthday']) ? date("Y",strtotime($applicant['birthday'])) : null;
			?>
			<div class="row">
			<div class="col-xs-4">
                <select id="birth_day<?=$key?>" name="birth_day<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_day')?></option>
    				<?php for ($d=1; $d<=31; $d++):?>
    				<option value="<?=$d?>" <?=set_select('birth_day'.$key, $d, $cr_day==$d)?>><?=$d?></option>
    				<?php endfor;?>
    			</select>
			</div>
			<div class="col-xs-4">
    			<select id="birth_month<?=$key?>" name="birth_month<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_month')?></option>
    				<?php for ($m=1; $m<=12; $m++):?>
    				<option value="<?=$m?>" <?=set_select('birth_month'.$key, $m, $cr_month==$m); ?>><?=date('F', mktime(0,0,0,$m,10))?></option>
    				<?php endfor;?>
    			</select>
			</div>
			<div class="col-xs-4">
    			<select id="birth_year<?=$key?>" name="birth_year<?=$key?>" class="form-control">
    				<option value="">* <?=lang('lb_select_year')?></option>
    				<?php for ($y=$now; $y>=$cutoff; $y--):?>
    				<option value="<?=$y?>" <?=set_select('birth_year'.$key, $y, $cr_year==$y); ?>><?=$y?></option>
    				<?php endfor;?>
    			</select>
			</div>
			</div>
			<input type="hidden" id="birthday<?=$key?>" name="birthday<?=$key?>" value="">
		</td>
		<td>
			<select id="nationality<?=$key?>" name="nationality<?=$key?>" class="form-control">
				<option value=""> -- <?=lang('please_select_nationality')?> -- </option>
				<?php foreach ($visa_countries as $country) :?>
					<option value="<?=$country['id']?>" <?=set_select('nationality'.$key , $country['id'], $country['id']==$applicant['nationality'])?>><?=$country['name']?></option>
				<?php endforeach;?>
			</select>
			<input type="hidden" name="nationality_name<?=$key?>" id="nationality_name<?=$key?>" value="">
		</td>
		<td>
			<input type="text" name="passport_number<?=$key?>" id="passport_number<?=$key?>" maxlength="20" class="form-control"
				value="<?=set_value('passport_number'.$key, $applicant['passport_number']); ?>">
		</td>
		<td align="center">
			<a href="javascript:void(0)" style="text-decoration: underline;" onclick="_update_applicant('update', <?=$key?>)"><?=lang('lb_done')?></a>
		</td>
	</tr>
	<?php endforeach;?>
	</tbody>
</table>