<form id="frmVisaDetails" method="post">
<div class="bpt-col-left pull-left apply-visa">
    <?=$apply_form?>
    
    <?=$why_apply?>
</div>
<div class="bpt-col-right pull-right">
    <?=$breadcrumb?>
    
    <div id="app_details">
		<input type="hidden" value="<?=$rowId?>" name="rowId">

		<p id="dv_err" class="error" style="display: none;">
			<?=lang('please_review_and_correct_information')?>
		</p>
		
		<h3>
			<?=lang('passport_information')?>
			<span style="margin: 0 0 0 10px; font-size: 12px"><?=lang('enter_exactly_as_in_your_passport')?></span>
		</h3>
		
		<div class="clearfix margin-bottom-10" id="applicant_details">
            <div class="row">
                <div class="col-xs-3" style="position: relative; padding-left: 35px">
                    <label style="position: absolute; left: 10px; top: 0"><?=lang('lb_no')?></label>
                    <label><?=lang('lb_full_name')?>:</label> <?=mark_required()?>
                </div>
                <div class="col-xs-2 padding-left-0"><label><?=lang('lb_gender')?>:</label> <?=mark_required()?></div>
                <div class="col-xs-3 padding-left-0"><label><?=lang('lb_date_of_birth')?>:</label> <?=mark_required()?></div>
                <div class="col-xs-2 padding-left-0"><label><?=lang('lb_nationality')?>:</label> <?=mark_required()?></div>
                <div class="col-xs-2 padding-left-0"><label><?=lang('lb_passport_number')?>:</label> <?=mark_required()?></div>
            </div>
            <?php for($i=0; $i<$visa_booking['number_of_visa']; $i++):?>
			<?php 
				$applicant = !empty($visa_booking['visa_details'][$i]) ? $visa_booking['visa_details'][$i] : null;
			?>
			<div class="row form-group" id="edit_app_<?=$i?>">
                <div class="col-xs-3" style="position: relative; padding-left: 35px">
                    <span style="position: absolute; left: 15px; top: 8px"><b><?=$i+1?></b></span>
                    <input type="text" maxlength="100" class="form-control" name="passport_name<?=$i?>"  id="passport_name<?=$i?>" 
						value="<?=set_value('passport_name'.$i, !empty($applicant) ? $applicant['passport_name'] : '')?>">
					<?=form_error('passport_name'.$i); ?>
                </div>
                <div class="col-xs-2 padding-left-0">
                    <select name="gender<?=$i?>" class="form-control">
						<option value="">---</option>
						<option value="1" <?=set_select('gender'.$i, 1, !empty($applicant) && $applicant['gender']==1)?>><?=lang('lb_male')?></option>
						<option value="2" <?=set_select('gender'.$i, 2, !empty($applicant) && $applicant['gender']==2)?>><?=lang('lb_female')?></option>
					</select>
					<?=form_error('gender'.$i); ?>
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
                <div class="col-xs-1 padding-left-0">
                    <select id="birth_day<?=$i?>" name="birth_day<?=$i?>" class="form-control" style="padding: 2px; font-size: 11px">
						<option value=""><?=lang('lb_select_day')?></option>
						<?php for ($d=1; $d<=31; $d++):?>
						<option value="<?=$d?>" <?=set_select('birth_day'.$i, $d, $cr_day==$d)?>><?=$d?></option>
						<?php endfor;?>
					</select>
                </div>
                <div class="col-xs-1 padding-left-0">
                    <select id="birth_month<?=$i?>" name="birth_month<?=$i?>" class="form-control" style="padding: 2px; font-size: 11px">
    					<option value=""><?=lang('lb_select_month')?></option>
    					<?php for ($m=1; $m<=12; $m++):?>
    					<option value="<?=$m?>" <?=set_select('birth_month'.$i, $m, $cr_month==$m)?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
    					<?php endfor;?>
    				</select>
                </div>
                <div class="col-xs-1 padding-left-0">
                    <select id="birth_year<?=$i?>" name="birth_year<?=$i?>" class="form-control" style="padding: 2px; font-size: 11px">
						<option value=""><?=lang('lb_select_year')?></option>
						<?php for ($y=$now; $y>=$cutoff; $y--):?>
						<option value="<?=$y?>" <?=set_select('birth_year'.$i, $y, $cr_year==$y)?>><?=$y?></option>
						<?php endfor;?>
					</select>
					<input type="hidden" id="birthday<?=$i?>" name="birthday<?=$i?>" value="">
					<?php echo form_error('birthday'.$i); ?>
                </div>
                <div class="col-xs-2 padding-left-0">
                    <?php
					  $selected_country =  $visa_booking['nationality'];
					  if(!empty($visa_booking['visa_details']) && !empty($visa_booking['visa_details'][$i])) {
					      $selected_country = $visa_booking['visa_details'][$i]['nationality'];
					  }
					?>
                    <select id="nationality<?=$i?>" name="nationality<?=$i?>" class="form-control">
						<option value=""> -- <?=lang('please_select_nationality')?> -- </option>
						<?php foreach ($voa_countries as $country) :?>
						<option value="<?=$country['id']?>" <?=set_select('nationality'.$i , $country['id'], $country['id']==$selected_country)?>><?=$country['name']?></option>
						<?php endforeach;?>
					</select>
					<input type="hidden" name="nationality_name<?=$i?>" id="nationality_name<?=$i?>" value="">
					<?php echo form_error('nationality'.$i); ?>
                </div>
                <div class="col-xs-2 padding-left-0">
                    <input type="text" id="passport_number<?=$i?>" name="passport_number<?=$i?>" maxlength="20" class="form-control"
						value="<?=set_value('passport_number'.$i, !empty($applicant) ? $applicant['passport_number'] : '')?>">
					<?php echo form_error('passport_number'.$i); ?>
                </div>
			</div>
			<?php endfor;?>
		</div>
		
		<div class="form-horizontal">
            <h3><?=lang('your_arrival_details')?></h3>
			<?php
				$ar_day = !empty($visa_booking['arrival_date']) ? date("j",strtotime($visa_booking['arrival_date'])) : null;
				$ar_month = !empty($visa_booking['arrival_date']) ? date("n",strtotime($visa_booking['arrival_date'])) : null;
				$ar_year = !empty($visa_booking['arrival_date']) ? date("Y",strtotime($visa_booking['arrival_date'])) : null;
			?>
			<div class="row form-group">
                <label class="col-xs-2 control-label"><?=lang('date_of_arrival')?>: <?=mark_required()?></label>
                <div class="col-xs-2">
                    <select id="arrival_day" name="arrival_day" class="form-control">
    					<option value=""><?=lang('lb_select_day')?></option>
    					<?php for ($d=1; $d<=31; $d++):?>
    					<option value="<?=$d?>" <?=set_select('arrival_day', $d, $ar_day==$d); ?>><?=$d?></option>
    					<?php endfor;?>
    				</select>
                </div>
                <div class="col-xs-2">
                    <select id="arrival_month" name="arrival_month" class="form-control">
    					<option value=""><?=lang('lb_select_month')?></option>
    					<?php for ($m=1; $m<=12; $m++):?>
    					<option value="<?=$m?>" <?=set_select('arrival_month', $m, $ar_month==$m); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
    					<?php endfor;?>
    				</select>
                </div>
                <div class="col-xs-2">
                    <select id="arrival_year" name="arrival_year" class="form-control">
    					<option value=""><?=lang('lb_select_year')?></option>
    					<?php for ($y=$now; $y<=$now+1; $y++):?>
    					<option value="<?=$y?>" <?=set_select('arrival_year', $y, $ar_year==$y); ?>><?=$y?></option>
    					<?php endfor;?>
    				</select>
                </div>
                
                <input type="hidden" id="arrival_date" name="arrival_date" value="">
				<?=form_error('arrival_date'); ?>
				
                <div class="col-xs-12 hide" id="msgPayment">
                    <span class="texInfo">&nbsp;</span>
				    <div class="floatL price" id="msgPaymentContent"></div>
                </div>
			</div>
			<?php
				$ex_day = !empty($visa_booking['arrival_date']) ? date("j",strtotime($visa_booking['exit_date'])) : null;
				$ex_month = !empty($visa_booking['arrival_date']) ? date("n",strtotime($visa_booking['exit_date'])) : null;
				$ex_year = !empty($visa_booking['arrival_date']) ? date("Y",strtotime($visa_booking['exit_date'])) : null;
			?>
			<div class="row form-group">
                <label class="col-xs-2 control-label"><?=lang('date_of_exit')?>: <?=mark_required()?></label>
                <div class="col-xs-2">
    				<select id="exit_day" name="exit_day" class="form-control">
    					<option value=""><?=lang('lb_select_day')?></option>
    					<?php for ($d=1; $d<=31; $d++):?>
    					<option value="<?=$d?>" <?=set_select('exit_day', $d, $ex_day==$d); ?>><?=$d?></option>
    					<?php endfor;?>
    				</select>
				</div>
				<div class="col-xs-2">
    				<select id="exit_month" name="exit_month" class="form-control">
    					<option value=""><?=lang('lb_select_month')?></option>
    					<?php for ($m=1; $m<=12; $m++):?>
    					<option value="<?=$m?>" <?=set_select('exit_month', $m, $ex_month==$m); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
    					<?php endfor;?>
    				</select>
				</div>
				<div class="col-xs-2">
    				<select id="exit_year" name="exit_year" class="form-control">
    					<option value=""><?=lang('lb_select_year')?></option>
    					<?php for ($y=$now; $y<=$now+1; $y++):?>
    					<option value="<?=$y?>" <?=set_select('exit_year', $y, $ex_year==$y); ?>><?=$y?></option>
    					<?php endfor;?>
    				</select>
				</div>
				<input type="hidden" id="exit_date" name="exit_date" value="">
				<?php echo form_error('exit_date'); ?>
			</div>
			<div class="row form-group">
                <label class="col-xs-2 control-label"><?=lang('lb_arrival_airport')?>: <?=mark_required()?></label>
				<div class="col-xs-4">
    				<select id="arrival_airport" name="arrival_airport" class="infoH230 form-control">
    					<option value="" <?=set_select('arrival_airport', 0)?>> -- <?=lang('please_select_arrival_airport')?> -- </option>
    					<?php foreach ($airports as $key => $airport):?>
    					<option value="<?=$key?>" <?=set_select('arrival_airport', $key, (isset($visa_booking['arrival_airport']) && $visa_booking['arrival_airport']==$key)?true:false)?>>
    					<?=translate_text($airport)?></option>
    					<?php endforeach;?>
    				</select>
				</div>
				<?php echo form_error('arrival_airport'); ?>
			</div>
			<div class="row form-group">
				<label class="col-xs-2 control-label"><?=lang('flight_number')?>:</label>
				<div class="col-xs-4">
				    <input type="text" id="flight_number" name="flight_number" maxlength="20" class="form-control"
					   value="<?=set_value('flight_number', isset($visa_booking['flight_number'])?$visa_booking['flight_number']:'')?>" >
			    </div>
			</div>
			<div class="row form-group">
				<div class="col-xs-offset-2 col-xs-8">
    				<ul class="list-unstyled text-price">
    					<li style="font-weight: bold;"><?=lang('important_notes')?>:</li>
    					<li><?=$visa_booking['type_of_visa']<=2?lang('visa_special_notes'):lang('visa_special_notes_2')?></li>
    					<li><?=$receive_date?></li>
    					<li><?=lang('visa_special_notes_3')?></li>
    				</ul>
				</div>
			</div>
		</div>
		<div class="row">
		    <div class="col-xs-offset-2 col-xs-8">
    			<div id="btn_checkout" class="btn btn-lg btn-yellow" onclick="submit_visa_details('check_out')">
                    <?=lang('proceed_checkout')?>
    			</div>
    			
    			<input type="hidden" id="processing_time" value="<?=$visa_booking['processing_time']?>">
			</div>
		</div>
	</div>
</div>
</form>
<script>
	init_visa_details();
</script>