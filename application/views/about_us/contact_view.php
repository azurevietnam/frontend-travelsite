<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form name="frm" method="post" id="frmRequest">
	<h1 class="highlight"><?=lang('ctu_contact_us') ?></h1>
	<div id="contact">
		<div class="items">
			<div class="col_1"><?=lang('full_name')?>: <?=mark_required()?></div>
			<div class="col_2">
			<?=form_error('full_name')?>
			<select name="title">
				<option value="1" <?=set_select('title', '1')?>><?=lang('mr') ?></option>
				<option value="2" <?=set_select('title', '2')?>><?=lang('ms') ?></option>
			</select>&nbsp;
			<input type="text" name="full_name" size="40" maxlength="50" value="<?=set_value('full_name')?>"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address')?>: <?=mark_required()?></div>
			<div class="col_2">
				<div class="clearfix">
				<?=form_error('email')?>
				</div>
				<div style="float: left;">
					<input type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>"/>
				</div>
				
				<div style="font-size: 11px; float: left; padding-left: 10px;">
					<span style="color: red;">(*)&nbsp;</span>	
					<span style="position: absolute; width: 300px;"><?=lang('spam_email_notify')?></span>
				
				</div>
				
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address_confirm')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email_cf')?><input type="text" name="email_cf" id="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" autocomplete="off"/></div>
		</div>		
		<div class="items">
			<div class="col_1"><?=lang('phone_number')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('phone')?><input type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('country')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('country')?>
			 <select name="country">
				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
				<?php foreach ($countries as $key => $country) :?>
				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
				<?php endforeach;?>
			</select>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('city')?>:</div>
			<div class="col_2"><input type="text" name="city" size="30" maxlength="50" value="<?=set_value('city')?>"/></div>
		</div>		
		<div class="items">
			<div class="col_1"><?=lang('subject')?>:</div>
			<div class="col_2">
				<span class="subject_item"><input type="radio" name="subject" value="info" <?=set_radio('subject', 'info', true)?>/>&nbsp;<?=lang('ctu_information_on') ?>Information on <?=SITE_NAME?></span>
				<span class="subject_item"><input type="radio" name="subject" value="request" <?=set_radio('subject', 'request', $this->uri->segment(3) == 'request'?true:false)?>/>&nbsp;<?=lang('ctu_special_request') ?></span>
				<span class="subject_item"><input type="radio" name="subject" value="claim" <?=set_radio('subject', 'claim', $this->uri->segment(3)=='claim'?true:false)?>/>&nbsp;<?=lang('ctu_rate_guarantee_claim') ?></span>
				<span class="subject_item"><input type="radio" name="subject" value="feedback" <?=set_radio('subject', 'feedback', $this->uri->segment(3) == 'feedback'?true:false)?>/>&nbsp;<?=lang('feedback') ?></span>				
				<span class="subject_item"><input type="radio" name="subject" value="other" <?=set_radio('subject', 'other', $this->uri->segment(3) == 'other'?true:false)?>/>&nbsp;<?=lang('other') ?></span>
			</div>
		</div>		
		<div class="items">
			<div class="col_1"><?=lang('message')?>: <?=mark_required()?></div>
			<?php if ($this->uri->segment(3)== 'claim') $c_tour = lang('ctu_rate_guarantee_claim') . ': ' . $this->uri->segment(4).'/'.$this->uri->segment(5); else $c_tour='';?>
			<div class="col_2"><?=form_error('message')?><textarea name="message" cols="53" rows="5"><?=set_value('message', $c_tour)?></textarea><br/><i><?=lang('ctu_maximum_1000_characters') ?></i></div>
		</div>						
		<div class="items item_button">
			<div class="col_1"><?=note_required()?></div>
			<div class="col_2" style="margin-top: 10px">		
				
				<div class="btn_general btn_submit_booking" onclick="submit_request()" style="float: left;">
					<?=lang('submit')?>
				</div>
				
			</div>
		</div>
	</div>
<script>
	function submit_request() {
		$('#frmRequest').submit();
	}

	$(document).ready(function(){
	    $('#email_cf').bind("cut copy paste",function(e) {
	        e.preventDefault();
	    });
	 });
</script>
</form>