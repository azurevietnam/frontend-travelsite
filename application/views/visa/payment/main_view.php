<?=$breadcrumb?>
<div class="payment-block">
	<form method="POST" name="frmPayment" action="/vietnam-visa/payment.html">
	<input type="hidden" name="action" value="">
	<input type="hidden" id="numb_visa" value="<?=$visa_booking['number_of_visa']?>">
	<input type="hidden" id="visa_nationality" value="<?=$visa_booking['nationality']?>">
	<input type="hidden" id="visa_type" value="<?=$visa_booking['type_of_visa']?>">
	<input type="hidden" id="rush_service" value="<?=$visa_booking['processing_time']?>">
	<input type="hidden" id="bank_fee" value="<?=$bank_fee?>">
	<h3 style="margin: 0; border:0"><?=lang('please_recheck_information')?></h3>
	<table class="payment-detail" style="margin-bottom: 20px">
		<tr>
			<th align="left" width="40%"><?=lang('type_of_visa')?></th>
			<th align="center" nowrap="nowrap"><?=lang('date_of_arrival')?></th>
			<th align="center" nowrap="nowrap"><?=lang('date_of_exit')?></th>
			<th align="center" nowrap="nowrap"><?=lang('processing_time')?></th>
			<th align="left" nowrap="nowrap"><?=lang('lb_arrival_airport')?></th>
			<th align="left" nowrap="nowrap"><?=lang('flight_number')?></th>
		</tr>
		<tr>
			<td align="left">
				<?=lang('vietnam_visa') .' - '. translate_text($visa_types[$visa_booking['type_of_visa']])?>
			</td>
			<td align="center" nowrap="nowrap">
				<?php 
					if(!empty($visa_booking['arrival_date'])) {
						echo date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['arrival_date']));;
					}
				?>
			</td>
			<td align="center" nowrap="nowrap">
				<?php 
					if(!empty($visa_booking['exit_date'])) {
						echo date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['exit_date']));;
					}
				?>
			</td>
			<td align="center"><?=translate_text($rush_services[$visa_booking['processing_time']])?></td>
			<td align="left">
				<?php 
					foreach ($airports as $key => $airport) {
						if($visa_booking['arrival_airport'] == $key) {
							echo translate_text($airport);
						}
					}
				?>
			</td>
			<td align="left"><?=$visa_booking['flight_number']?></td>
		</tr>
	</table>
	
	<?php if(! (isset($visa_booking['detail_type']) && $visa_booking['detail_type'] == 2)):?>
	
	<p id="dv_err" class="hide error" style="font-size: 13px">
		<?=lang('please_review_and_correct_information')?>
	</p>
	<table class="payment-detail" id="applicant_details">
		<tr>
			<th align="left" width="3%" nowrap="nowrap"></th>
			<th align="left"><?=lang('lb_full_name')?></th>
			<th align="left"><?=lang('lb_gender')?></th>
			<th align="left"><?=lang('lb_date_of_birth')?></th>
			<th align="left"><?=lang('lb_nationality')?></th>
			<th align="left"><?=lang('lb_passport_number')?></th>
			<th align="center"></th>
		</tr>
		<?php foreach ($visa_booking['visa_details'] as $key => $applicant):?>
		<tr id="app_<?=$key?>">
			<td align="center"><?=$key+1?></td>
			<td><?=$applicant['passport_name']?></td>
			<td>
				<?php 
					if($applicant['gender'] == 1) {
						echo lang('lb_male');
					} else {
						echo lang('lb_female');
					}
				?>
			</td>
			<td>
				<?php 
					if(!empty($applicant['birthday'])) {
						echo date(DATE_FORMAT_DISPLAY, strtotime($applicant['birthday']));;
					}
				?>
			</td>
			<td><?=$applicant['nationality_name']?></td>
			<td><?=$applicant['passport_number']?></td>
			<td align="center">
				<a href="javascript:void(0)" style="text-decoration: underline;" onclick="_edit_applicant(<?=$key?>)"><?=lang('lb_edit')?></a>
			</td>
		</tr>
		<tr class="hide" id="edit_app_<?=$key?>">
			<td align="center">
				<?=$key+1?>
				<input type="hidden"  name="passport_expired<?=$key?>" value="<?=$applicant['passport_expired']?>">
			</td>
			<td>
				<input type="text" maxlength="100" name="passport_name<?=$key?>" 
					value="<?php echo set_value('passport_name'.$key, $applicant['passport_name']); ?>">
			</td>
			<td>
				<select name="gender<?=$key?>" style="font-size: 11px; width: 60px">
					<option value=""> -- Please select -- </option>
					<option value="1" <?php echo set_select('gender'.$key, 1, ($applicant['gender']==1)?true:false); ?>><?=lang('lb_male')?></option>
					<option value="2" <?php echo set_select('gender'.$key, 2, ($applicant['gender']==2)?true:false); ?>><?=lang('lb_female')?></option>
				</select>
			</td>
			<td>
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
				<select id="birth_day<?=$key?>" name="birth_day<?=$key?>">
					<option value="">* <?=lang('lb_select_day')?></option>
					<?php for ($d=1; $d<=31; $d++):?>
					<option value="<?=$d?>" <?php echo set_select('birth_day'.$key, $d, $cr_day==$d?true:false); ?>><?=$d?></option>
					<?php endfor;?>
				</select>
				<select id="birth_month<?=$key?>" name="birth_month<?=$key?>">
					<option value="">* <?=lang('lb_select_month')?></option>
					<?php for ($m=1; $m<=12; $m++):?>
					<option value="<?=$m?>" <?php echo set_select('birth_month'.$key, $m, $cr_month==$m?true:false); ?>><?=date('F', mktime(0,0,0,$m,10))?></option>
					<?php endfor;?>
				</select>
				<select id="birth_year<?=$key?>" name="birth_year<?=$key?>">
					<option value="">* <?=lang('lb_select_year')?></option>
					<?php for ($y=$now; $y>=$cutoff; $y--):?>
					<option value="<?=$y?>" <?php echo set_select('birth_year'.$key, $y, $cr_year==$y?true:false); ?>><?=$y?></option>
					<?php endfor;?>
				</select>
				<input type="hidden" id="birthday<?=$key?>" name="birthday<?=$key?>" value="">
			</td>
			<td>
				<select id="nationality<?=$key?>" name="nationality<?=$key?>" style="width: 120px">
					<option value=""> -- <?=lang('please_select_nationality')?> -- </option>
					<?php foreach ($visa_countries as $country) :?>
						<option value="<?=$country['id']?>" <?=set_select('nationality'.$key , $country['id'], $country['id']==$applicant['nationality']?true:false)?>><?=$country['name']?></option>
					<?php endforeach;?>
				</select>
				<input type="hidden" name="nationality_name<?=$key?>" id="nationality_name<?=$key?>" value="">
			</td>
			<td>
				<input type="text" name="passport_number<?=$key?>" maxlength="20" size="15"
					value="<?php echo set_value('passport_number'.$key, $applicant['passport_number']); ?>">
			</td>
			<td align="center">
				<a href="javascript:void(0)" style="text-decoration: underline;" onclick="_update_applicant('update', <?=$key?>)"><?=lang('lb_done')?></a>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
	
	<?php else:?>
		<p>
		<b><?=lang('applicant_details')?></b><br>
		<?=lang('visa_via_email_note')?>
		</p>
	<?php endif;?>
	
	<div class="floatL" style="margin: 10px 0; clear: both;">
		<ul class="floatL price">
			<li style="color: red"><b><?=lang('important_notes')?>:</b></li>
			<li><?=lang('visa_note_1')?></li>
			<li><?=$visa_booking['type_of_visa']<=2?lang('visa_special_notes'):lang('visa_special_notes_2')?></li>
			<li><?=$receive_date?><?=lang('lbl_check_spam_mail_box')?></li>
			<li><?=lang('visa_special_notes_3')?></li>
		</ul>
	</div>
	
	<h3><?=lang('booking_details')?></h3>
	<table class="payment-detail">
		<tr>
			<th align="left" width="60%"><?=lang('lb_description')?></th>
			<th align="center"><?=lang('lb_unit')?></th>
			<th align="right"><?=lang('lb_amount')?></th>
		</tr>
		<tr>
			<td align="left">
				<?=$my_booking['service_name']?>
			</td>
			<td align="center"><?=$my_booking['unit']?></td>
			<td align="right"><span id="visa_total_fee"><?=CURRENCY_SYMBOL . ' ' . $my_booking['selling_price']?></span>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2"><?=lang_arg('label_visa_bank_fee', $bank_fee)?></td>
			<td align="right"><span id="visa_bank_fee"><?=CURRENCY_SYMBOL . ' ' . number_format($my_booking['selling_price'] * $bank_fee/100, 2)?></span></td>
		</tr>
		<tr>
			<td align="right" colspan="2" style="font-size: 13px;">
				<b><?=lang('lb_total_payment')?>:</b>
			</td>
			<td align="right" class="price" style="font-size: 13px; font-weight: bold;">
				USD <span id="visa_final_total"><?=$my_booking['final_total']?></span></td>
		</tr>
	</table>
	
	<h3><?=lang('contact_details')?></h3>
	<div class="contact-details">
		<div class="items item_button">
			<div class="col_1"><?=note_required()?></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('full_name')?>: <?=mark_required()?></div>
			<div class="col_2">
			<?=form_error('full_name')?>
			<select name="title">
				<option value="1" <?=set_select('title', '1')?>><?=lang('lb_mr')?></option>
				<option value="2" <?=set_select('title', '2')?>><?=lang('lb_ms')?></option>					
			</select>&nbsp;
			<input type="text" name="full_name" size="40" maxlength="50" value="<?=set_value('full_name')?>" tabindex="1"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address')?>: <?=mark_required()?></div>
			<div class="col_2">
				<div style="float: left;">
					<?=form_error('email')?><input type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>" tabindex="2"/>
				</div>
				
				<div style="font-size: 11px; float: left; padding-left: 10px;">
					<span style="color: red;">(*)&nbsp;</span>	
					<span style="position: absolute; width: 300px; white-space: normal;"><?=lang('spam_email_notify')?></span>
				
				</div>	
			</div>
			
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address_confirm')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email_cf')?><input type="text" name="email_cf" id="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" tabindex="3" autocomplete="off"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('phone_number')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('phone')?><input type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>" tabindex="4"/>&nbsp;&nbsp;&nbsp;
			<?=lang('fax_number')?>: <input type="text" name="fax" size="30" maxlength="30" value="<?=set_value('fax')?>" tabindex="5"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('country')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('country')?>
			 <select name="country" tabindex="6">
				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
				<?php foreach ($countries as $key => $country) :?>
				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
				<?php endforeach;?>
			</select>
			<label style="padding-left: 27px;padding-right: 45px;"><?=lang('city')?></label>:&nbsp;<input type="text" name="city" size="30" maxlength="100" value="<?=set_value('city')?>" tabindex="7"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('special_requests')?>:</div>
			<div class="col_2"><textarea name="special_requests" cols="66" rows="5" tabindex="8"><?=set_value('special_requests')?></textarea></div>
		</div>						
	</div>

	<h3><?=lang('term_and_condition')?></h3>
	<div class="floatL tearm-block">
		<ul>
			<li><?=lang('visa_term_1')?></li>
			<li><?=lang('visa_term_2')?></li>
			<li><?=lang('visa_special_notes')?></li>
		</ul>
	</div>
	
	<div class="floatL mar-top-20" style="clear: both;">
		<input type="checkbox" name="conditionsAgreement" class="checkbox" id="agree_cancelpolicy">
		<label class="highlight lbl-agree" for="agree_cancelpolicy"><?=lang('read_and_agree_term_condition')?></label>
	</div>
	
	<div class="floatL mar-top-20 btn-block">
		<div class="btn_general btn_pay" onclick="book()">
			<?=lang('pay_by_credit_card')?>
		</div>
	</div>
	</form>
</div>

<script>
	check_form();
</script>