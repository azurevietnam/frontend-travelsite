<?=$breadcrumb?>

<form id="frmVisaDetails" method="post">
    <?=$apply_form?>

    <div id="app_details" class="container">
		<input type="hidden" value="<?=$rowId?>" name="rowId">

		<p id="dv_err" class="error" style="display: none;">
			<?=lang('please_review_and_correct_information')?>
		</p>
		
		<h3 class="margin-bottom-0">
			<?=lang('passport_information')?>
			<span class="clearfix note"><?=lang('enter_exactly_as_in_your_passport')?></span>
		</h3>
		
		<?php for($i=0; $i<$visa_booking['number_of_visa']; $i++):?>
		<?php 
			$applicant = !empty($visa_booking['visa_details'][$i]) ? $visa_booking['visa_details'][$i] : null;
		?>
		<div id="edit_app_<?=$i?>" class="margin-top-10">
		
        <div class="row">
            <div class="col-xs-12 margin-bottom-5"><b><?=lang('lbl_application'). ' ' . ($i + 1)?></b></div>
            <div class="col-xs-12 form-group">
                <span><?=lang('lb_full_name')?>:</span> <?=mark_required()?>
                <input type="text" maxlength="100" class="form-control" name="passport_name<?=$i?>"  id="passport_name<?=$i?>" 
        			value="<?=set_value('passport_name'.$i, !empty($applicant) ? $applicant['passport_name'] : '')?>">
        		<?=form_error('passport_name'.$i); ?>
            </div>
            <div class="col-xs-12 form-group">
                <span><?=lang('lb_gender')?>:</span> <?=mark_required()?>
                <select name="gender<?=$i?>" class="form-control">
        			<option value="">---</option>
        			<option value="1" <?=set_select('gender'.$i, 1, !empty($applicant) && $applicant['gender']==1)?>><?=lang('lb_male')?></option>
        			<option value="2" <?=set_select('gender'.$i, 2, !empty($applicant) && $applicant['gender']==2)?>><?=lang('lb_female')?></option>
        		</select>
        		<?=form_error('gender'.$i); ?>
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
    	<div class="row form-group">
            <div class="col-xs-12"><?=lang('lb_date_of_birth')?>: <?=mark_required()?></div>
            <div class="col-xs-4">
                <select id="birth_day<?=$i?>" name="birth_day<?=$i?>" class="form-control">
    				<option value=""><?=lang('lb_select_day')?></option>
    				<?php for ($d=1; $d<=31; $d++):?>
    				<option value="<?=$d?>" <?=set_select('birth_day'.$i, $d, $cr_day==$d)?>><?=$d?></option>
    				<?php endfor;?>
    			</select>
            </div>
            <div class="col-xs-4">
                <select id="birth_month<?=$i?>" name="birth_month<?=$i?>" class="form-control">
    				<option value=""><?=lang('lb_select_month')?></option>
    				<?php for ($m=1; $m<=12; $m++):?>
    				<option value="<?=$m?>" <?=set_select('birth_month'.$i, $m, $cr_month==$m)?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
    				<?php endfor;?>
    			</select>
            </div>
            <div class="col-xs-4">
                <select id="birth_year<?=$i?>" name="birth_year<?=$i?>" class="form-control">
    				<option value=""><?=lang('lb_select_year')?></option>
    				<?php for ($y=$now; $y>=$cutoff; $y--):?>
    				<option value="<?=$y?>" <?=set_select('birth_year'.$i, $y, $cr_year==$y)?>><?=$y?></option>
    				<?php endfor;?>
    			</select>
    			<input type="hidden" id="birthday<?=$i?>" name="birthday<?=$i?>" value="">
            </div>
            <div class="col-xs-12"><?php echo form_error('birthday'.$i); ?></div>
    	</div>
    	
    	<div class="row form-group">
            <div class="col-xs-12">
            <span><?=lang('lb_nationality')?>:</span> <?=mark_required()?>
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
    	</div>
    	
    	<div class="row">
            <div class="col-xs-12">
                <span><?=lang('lb_passport_number')?>:</span> <?=mark_required()?>
                <input type="text" id="passport_number<?=$i?>" name="passport_number<?=$i?>" maxlength="20" class="form-control"
					value="<?=set_value('passport_number'.$i, !empty($applicant) ? $applicant['passport_number'] : '')?>">
				<?php echo form_error('passport_number'.$i); ?>
            </div>
    	</div>
        
        </div>
		<?php endfor;?>
		
		<!-- Arrival Information -->
		
		<div class="row form-group margin-top-20">
            <div class="col-xs-12"><label><?=lang('your_arrival_details')?></label></div>
            <div class="col-xs-12"><?=lang('date_of_arrival')?>: <?=mark_required()?></div>
            <?php
				$ar_day = !empty($visa_booking['arrival_date']) ? date("j",strtotime($visa_booking['arrival_date'])) : null;
				$ar_month = !empty($visa_booking['arrival_date']) ? date("n",strtotime($visa_booking['arrival_date'])) : null;
				$ar_year = !empty($visa_booking['arrival_date']) ? date("Y",strtotime($visa_booking['arrival_date'])) : null;
			?>
            <div class="col-xs-4">
                <select id="arrival_day" name="arrival_day" class="form-control">
					<option value=""><?=lang('lb_select_day')?></option>
					<?php for ($d=1; $d<=31; $d++):?>
					<option value="<?=$d?>" <?=set_select('arrival_day', $d, $ar_day==$d); ?>><?=$d?></option>
					<?php endfor;?>
				</select>
            </div>
            <div class="col-xs-4">
                <select id="arrival_month" name="arrival_month" class="form-control">
					<option value=""><?=lang('lb_select_month')?></option>
					<?php for ($m=1; $m<=12; $m++):?>
					<option value="<?=$m?>" <?=set_select('arrival_month', $m, $ar_month==$m); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
					<?php endfor;?>
				</select>
            </div>
            <div class="col-xs-4">
                <select id="arrival_year" name="arrival_year" class="form-control">
					<option value=""><?=lang('lb_select_year')?></option>
					<?php for ($y=$now; $y<=$now+1; $y++):?>
					<option value="<?=$y?>" <?=set_select('arrival_year', $y, $ar_year==$y); ?>><?=$y?></option>
					<?php endfor;?>
				</select>
            </div>
		</div>
		<div class="row">
            <input type="hidden" id="arrival_date" name="arrival_date" value="">
			<div class="col-xs-12"><?=form_error('arrival_date'); ?></div>
			
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
            <div class="col-xs-12"><?=lang('date_of_exit')?>: <?=mark_required()?></div>
            <div class="col-xs-4">
				<select id="exit_day" name="exit_day" class="form-control">
					<option value=""><?=lang('lb_select_day')?></option>
					<?php for ($d=1; $d<=31; $d++):?>
					<option value="<?=$d?>" <?=set_select('exit_day', $d, $ex_day==$d); ?>><?=$d?></option>
					<?php endfor;?>
				</select>
			</div>
			<div class="col-xs-4">
				<select id="exit_month" name="exit_month" class="form-control">
					<option value=""><?=lang('lb_select_month')?></option>
					<?php for ($m=1; $m<=12; $m++):?>
					<option value="<?=$m?>" <?=set_select('exit_month', $m, $ex_month==$m); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
					<?php endfor;?>
				</select>
			</div>
			<div class="col-xs-4">
				<select id="exit_year" name="exit_year" class="form-control">
					<option value=""><?=lang('lb_select_year')?></option>
					<?php for ($y=$now; $y<=$now+1; $y++):?>
					<option value="<?=$y?>" <?=set_select('exit_year', $y, $ex_year==$y); ?>><?=$y?></option>
					<?php endfor;?>
				</select>
			</div>
			<input type="hidden" id="exit_date" name="exit_date" value="">
			<div class="col-xs-12"><?php echo form_error('exit_date'); ?></div>
		</div>
		
		<div class="row form-group">
			<div class="col-xs-12">
                <label><?=lang('lb_arrival_airport')?>: <?=mark_required()?></label>
				<select id="arrival_airport" name="arrival_airport" class="infoH230 form-control">
					<option value="" <?=set_select('arrival_airport', 0)?>> -- <?=lang('please_select_arrival_airport')?> -- </option>
					<?php foreach ($airports as $key => $airport):?>
					<option value="<?=$key?>" <?=set_select('arrival_airport', $key, (isset($visa_booking['arrival_airport']) && $visa_booking['arrival_airport']==$key)?true:false)?>>
					<?=translate_text($airport)?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="col-xs-12"><?php echo form_error('arrival_airport'); ?></div>
		</div>
		
		<div class="row form-group">
			<div class="col-xs-12">
                <label><?=lang('flight_number')?>:</label>
			    <input type="text" id="flight_number" name="flight_number" maxlength="20" class="form-control"
				   value="<?=set_value('flight_number', isset($visa_booking['flight_number'])?$visa_booking['flight_number']:'')?>" >
		    </div>
		</div>
		
		<div class="row form-group">
			<div class="col-xs-12">
				<ul class="list-unstyled text-price">
					<li><b><?=lang('important_notes')?>:</b></li>
					<li class="margin-top-5"><?=$visa_booking['type_of_visa']<=2?lang('visa_special_notes'):lang('visa_special_notes_2')?></li>
					<li class="margin-top-5"><?=$receive_date?></li>
					<li class="margin-top-5"><?=lang('visa_special_notes_3')?></li>
				</ul>
			</div>
		</div>
		
		<div class="row">
		    <div class="col-xs-12">
    			<div id="btn_checkout" class="btn btn-lg btn-yellow btn-block" onclick="submit_visa_details('check_out')">
                    <?=lang('proceed_checkout')?>
    			</div>
    			
    			<input type="hidden" id="processing_time" value="<?=$visa_booking['processing_time']?>">
			</div>
		</div>
	</div>
</form>
<script>
	init_visa_details();
</script>