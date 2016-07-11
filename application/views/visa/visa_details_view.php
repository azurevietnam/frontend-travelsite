<form id="frmVisaDetails" method="post">
<div id="contentLeft">
	<?=$check_rate_view?>
	
	<div id="how-to-apply" class="box-left" style="height: auto; float: left; margin-top: 10px">
		<div class="box-title">
			<h2 class="highlight"><?=lang('why_apply_with_us')?></h2>
		</div>
		<ul class="voa-why-us note_normal" >
            <li>
			    <label id="why_1" class="why_apply_us"><?=lang('visa_secure_private')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_secure_private_summary')?></span>
			</li>
			<li>
			    <label id="why_2" class="why_apply_us"><?=lang('visa_easy_convenient')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_easy_convenient_summary')?></span>
			</li>
			<li>
			    <label id="why_3" class="why_apply_us special"><?=lang('visa_lowest_fee')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_lowest_fee_summary')?></span>
			</li>
		</ul>
	</div>
</div>
<div id="contentMain">
    <?=$breadcrumb?>
	<div id="app_details">
		<input type="hidden" value="<?=$rowId?>" name="rowId">

		<p id="dv_err" class="hide error">
			<?=lang('please_review_and_correct_information')?>
		</p>
		
		<div class="appInfo">
			<div class="app_title">
				<span class="icon icon-applicant"></span>
				<span class="app_text"><?=lang('passport_information')?></span>
				<span class="floatL" style="margin: 5px 0 0 10px"><?=lang('enter_exactly_as_in_your_passport')?></span>
			</div>
		</div>
		
		<table class="tbApplicant floatL" id="applicant_details">
			<tr>
				<th><?=lang('lb_no')?></th>
				<th><?=lang('lb_full_name')?>: <?=mark_required()?></th>
				<th><?=lang('lb_gender')?>: <?=mark_required()?></th>
				<th><?=lang('lb_date_of_birth')?>: <?=mark_required()?></th>
				<th><?=lang('lb_nationality')?>: <?=mark_required()?></th>
				<th><?=lang('lb_passport_number')?>: <?=mark_required()?></th>
			</tr>
			<?php for($i=1; $i<=$visa_booking['number_of_visa']; $i++):?>
			<?php 
				$first_visa_booking = false;
				$applicant = null;
				if(isset($visa_booking['visa_details'][$i-1])) {
					$first_visa_booking = true;
					$applicant = $visa_booking['visa_details'][$i-1];
				}
				
			?>
			<tr id="edit_app_<?=$i?>">
				<td align="center"><b><?=$i?></b></td>
				<td align="left">
					<input type="text" maxlength="100" class="info100" name="passport_name<?=$i?>"  id="passport_name<?=$i?>" 
						value="<?php echo set_value('passport_name'.$i, $first_visa_booking?$applicant['passport_name']:'' ); ?>">
					<?php echo form_error('passport_name'.$i); ?>
				</td>
				<td align="left">
					<select name="gender<?=$i?>" class="info75">
						<option value="">---</option>
						<option value="1" <?php echo set_select('gender'.$i, 1, ($first_visa_booking && $applicant['gender']==1)?true:false); ?>><?=lang('lb_male')?></option>
						<option value="2" <?php echo set_select('gender'.$i, 2, ($first_visa_booking && $applicant['gender']==2)?true:false); ?>><?=lang('lb_female')?></option>
					</select>
					<?php echo form_error('gender'.$i); ?>
				</td>
				<?php 
					// lowest year wanted
					$cutoff = 1910;
					// current year
					$now = date('Y');
					
					$cr_day = null;$cr_month = null;$cr_year = null;
					if(isset($applicant['birthday'])) {
						$cr_day = date("j",strtotime($applicant['birthday']));
						$cr_month = date("n",strtotime($applicant['birthday']));
						$cr_year = date("Y",strtotime($applicant['birthday']));
					}
				?>
				<td>
					<select id="birth_day<?=$i?>" name="birth_day<?=$i?>" style="width: 60px; display: inline;">
						<option value=""><?=lang('lb_select_day')?></option>
						<?php for ($d=1; $d<=31; $d++):?>
						<option value="<?=$d?>" <?php echo set_select('birth_day'.$i, $d, $cr_day==$d?true:false); ?>><?=$d?></option>
						<?php endfor;?>
					</select>
					<select id="birth_month<?=$i?>" name="birth_month<?=$i?>" style="width: 65px; display: inline;">
						<option value=""><?=lang('lb_select_month')?></option>
						<?php for ($m=1; $m<=12; $m++):?>
						<option value="<?=$m?>" <?php echo set_select('birth_month'.$i, $m, $cr_month==$m?true:false); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
						<?php endfor;?>
					</select>
					<select id="birth_year<?=$i?>" name="birth_year<?=$i?>" style="width: 60px; display: inline;">
						<option value=""><?=lang('lb_select_year')?></option>
						<?php for ($y=$now; $y>=$cutoff; $y--):?>
						<option value="<?=$y?>" <?php echo set_select('birth_year'.$i, $y, $cr_year==$y?true:false); ?>><?=$y?></option>
						<?php endfor;?>
					</select>
					<input type="hidden" id="birthday<?=$i?>" name="birthday<?=$i?>" value="">
					<?php echo form_error('birthday'.$i); ?>
				</td>
				<td>
					<select id="nationality<?=$i?>" name="nationality<?=$i?>" class="infoH230 app_nationality">
						<option value=""> -- <?=lang('please_select_nationality')?> -- </option>
						<?php 
						  $selected_nationality = $visa_booking['nationality'];
						  if(!empty($visa_booking['visa_details'][$i-1])) {
                            //$selected_nationality = $visa_booking['visa_details'][$i-1]['nationality'];
                          }  
						?>
						<?php foreach ($countries as $country) :?>
							<option value="<?=$country['id']?>" <?=set_select('nationality'.$i , $country['id'], $country['id']==$selected_nationality?true:false)?>><?=$country['name']?></option>
						<?php endforeach;?>
					</select>
					<input type="hidden" name="nationality_name<?=$i?>" id="nationality_name<?=$i?>" value="">
					<?php echo form_error('nationality'.$i); ?>
				</td>
				<td>
					<input type="text" id="passport_number<?=$i?>" name="passport_number<?=$i?>" maxlength="20" size="25" class="info100"
						value="<?php echo set_value('passport_number'.$i, $first_visa_booking?$applicant['passport_number']:''); ?>">
					<?php echo form_error('passport_number'.$i); ?>
				</td>
			</tr>
			<?php endfor;?>
		</table>
		
		<div class="appInfo arrival_details">
			<div class="app_title">
				<span class="icon icon-airplane"></span>
				<span class="app_text"><?=lang('your_arrival_details')?></span>
			</div>
			<?php
				$ar_day = null;$ar_month = null;$ar_year = null;
				if(isset($visa_booking['arrival_date'])) {
					$ar_day = date("j",strtotime($visa_booking['arrival_date']));
					$ar_month = date("n",strtotime($visa_booking['arrival_date']));
					$ar_year = date("Y",strtotime($visa_booking['arrival_date']));
				} 
			?>
			<div class="rowInfo">
				<span class="texInfo"><?=lang('date_of_arrival')?>: <?=mark_required()?></span>
				<select id="arrival_day" name="arrival_day">
					<option value=""><?=lang('lb_select_day')?></option>
					<?php for ($d=1; $d<=31; $d++):?>
					<option value="<?=$d?>" <?php echo set_select('arrival_day', $d, $ar_day==$d?true:false); ?>><?=$d?></option>
					<?php endfor;?>
				</select>
				<select id="arrival_month" name="arrival_month">
					<option value=""><?=lang('lb_select_month')?></option>
					<?php for ($m=1; $m<=12; $m++):?>
					<option value="<?=$m?>" <?php echo set_select('arrival_month', $m, $ar_month==$m?true:false); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
					<?php endfor;?>
				</select>
				<select id="arrival_year" name="arrival_year">
					<option value=""><?=lang('lb_select_year')?></option>
					<?php for ($y=$now; $y<=$now+1; $y++):?>
					<option value="<?=$y?>" <?php echo set_select('arrival_year', $y, $ar_year==$y?true:false); ?>><?=$y?></option>
					<?php endfor;?>
				</select>
				<input type="hidden" id="arrival_date" name="arrival_date" value="">
				<?php echo form_error('arrival_date'); ?>
			</div>
			<div class="rowInfo hide" id="msgPayment">
				<span class="texInfo">&nbsp;</span>
				<div class="floatL price" id="msgPaymentContent"></div>
			</div>
			<?php
				$ex_day = null;$ex_month = null;$ex_year = null;
				if(isset($visa_booking['arrival_date'])) {
					$ex_day = date("j",strtotime($visa_booking['exit_date']));
					$ex_month = date("n",strtotime($visa_booking['exit_date']));
					$ex_year = date("Y",strtotime($visa_booking['exit_date']));
				} 
			?>
			<div class="rowInfo">
				<span class="texInfo"><?=lang('date_of_exit')?>: <?=mark_required()?></span>
				<select id="exit_day" name="exit_day">
					<option value=""><?=lang('lb_select_day')?></option>
					<?php for ($d=1; $d<=31; $d++):?>
					<option value="<?=$d?>" <?php echo set_select('exit_day', $d, $ex_day==$d?true:false); ?>><?=$d?></option>
					<?php endfor;?>
				</select>
				<select id="exit_month" name="exit_month">
					<option value=""><?=lang('lb_select_month')?></option>
					<?php for ($m=1; $m<=12; $m++):?>
					<option value="<?=$m?>" <?php echo set_select('exit_month', $m, $ex_month==$m?true:false); ?>><?=date("F", mktime(0, 0, 0, $m, 10))?></option>
					<?php endfor;?>
				</select>
				<select id="exit_year" name="exit_year">
					<option value=""><?=lang('lb_select_year')?></option>
					<?php for ($y=$now; $y<=$now+1; $y++):?>
					<option value="<?=$y?>" <?php echo set_select('exit_year', $y, $ex_year==$y?true:false); ?>><?=$y?></option>
					<?php endfor;?>
				</select>
				<input type="hidden" id="exit_date" name="exit_date" value="">
				<?php echo form_error('exit_date'); ?>
			</div>
			<div class="rowInfo">
				<span class="texInfo"><?=lang('lb_arrival_airport')?>: <?=mark_required()?></span>
				<select id="arrival_airport" name="arrival_airport" class="infoH230" style="width: auto;">
					<option value="" <?=set_select('arrival_airport', 0)?>> -- <?=lang('please_select_arrival_airport')?> -- </option>
					<?php foreach ($airports as $key => $airport):?>
					<option value="<?=$key?>" <?=set_select('arrival_airport', $key, (isset($visa_booking['arrival_airport']) && $visa_booking['arrival_airport']==$key)?true:false)?>>
					<?=translate_text($airport)?></option>
					<?php endforeach;?>
				</select>
				<?php echo form_error('arrival_airport'); ?>
			</div>
			<div class="rowInfo">
				<span class="texInfo"><?=lang('flight_number')?>:</span>
				<input type="text" id="flight_number" name="flight_number" maxlength="20" size="25" 
					value="<?php echo set_value('flight_number', isset($visa_booking['flight_number'])?$visa_booking['flight_number']:''); ?>" class="info260">
			</div>
			<div class="rowInfo">
				<span class="texInfo"></span>
				<ul style="color: #B20000; font-size: 12px; float: left;">
					<li style="font-weight: bold;"><?=lang('important_notes')?>:</li>
					<li><?=$visa_booking['type_of_visa']<=2?lang('visa_special_notes'):lang('visa_special_notes_2')?></li>
					<li><?=$receive_date?></li>
					<li><?=lang('visa_special_notes_3')?></li>
				</ul>
			</div>
		</div>
		<div class="frm_action">
			<div id="btn_checkout" class="btn_general btn_pay btn_next" style="width: 160px; font-size: 14px" onclick="submit_visa_details('check_out')">
				<span><?=lang('proceed_checkout')?></span>
			</div>
			<!-- 
			<div class="floatL" id="lblOr" style="font-weight: bold;margin: 0 15px 0 0;padding: 20px 0;">OR</div>
			<div id="btn_add_cart" class="btn_general book_visa btn_next" onclick="submit_visa_details('add_to_cart')">
				<span class="icon icon-cart-bg"></span><span><?=lang('add_to_cart')?></span>
			</div>
			 -->
			<input type="hidden" id="processing_time" value="<?=$visa_booking['processing_time']?>">
		</div>
	</div>
</div>
</form>
<script>
	init_visa_details();
</script>