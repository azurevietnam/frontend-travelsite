<h2 class="bpv-color-title"><?=lang('c_customer_contact')?></h2>

<div class="bpv-contact <?=$custom_css?>">
	<input type="hidden" value="<?=ACTION_MAKE_BOOKING?>" name="action">
	
	<div class="margin-bottom-20"><?=lang('required_message')?></div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-4" style="padding-right:0">
			<label for="title"><?=lang('c_title')?> <?=mark_required()?></label>
			<select class="form-control input-sm" id="gender" name="gender">
				<option value="">--<?=lang('c_choose')?>--</option>
			 <?php foreach ($c_titles as $key=>$value):?>
			 	<option value="<?=$key?>"><?=lang($value)?></option>
			 <?php endforeach;?>
			</select>
		</div>
		<div class="col-xs-8">
			<label for="name"><?=lang('c_name')?> <?=mark_required()?></label>
			<input type="text" class="form-control input-sm" id="name" name="name">
		</div>
		<div class="col-xs-12">
			<div class="bpv-color-warning warning-message" id="title_required"><?=lang('c_title_required')?></div>
			<div class="bpv-color-warning warning-message" id="name_required"><?=lang('c_name_required')?></div>
			<?php echo form_error('gender');?>
			<?php echo form_error('name');?>
		</div>
	</div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-12">
			<label for="phone"><?=lang('c_phone')?> <?=mark_required()?></label>
			<input type="text" class="form-control input-sm" id="phone" name="phone">
			
			<div class="bpv-color-warning warning-message" id="phone_required"><?=lang('c_phone_required')?></div>
			<div class="bpv-color-warning warning-message" id="phone_valid"><?=lang('c_phone_valid')?></div>
			<?php echo form_error('phone');?>
		</div>
	</div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-12">
			<label for="phone_cf"><?=lang('c_phone_cf')?> <?=mark_required()?></label>
			<input type="text" class="form-control input-sm" id="phone_cf" name="phone_cf">
			<div class="bpv-color-warning warning-message" id="phone_cf_required"><?=lang('c_phone_cf_required')?></div>
			<div class="bpv-color-warning warning-message" id="phone_cf_valid"><?=lang('c_phone_cf_valid')?></div>
			<?php echo form_error('phone_cf');?>
		</div>
	</div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-12">
			<label for="email"><?=lang('c_email')?> <?=mark_required()?></label>
			<input type="text" class="form-control input-sm" id="email" name="email">
			
			<div class="bpv-color-warning warning-message" id="email_required"><?=lang('c_email_required')?></div>
			<div class="bpv-color-warning warning-message" id="email_valid"><?=lang('c_email_valid')?></div>

			<?php echo form_error('email');?>
		</div>
	</div>
	
	<div class="row margin-bottom-10" id="date">
		<div class="col-xs-12">
		 <label for="b_day"><?=lang('c_birthday')?></label>
		</div>
		<div class="col-xs-4">
			
			<select name="day" class="form-control" id="c_day">
				<option value="">--<?=lang('c_day')?>--</option>
				<?php for ($i=1; $i<=31; $i++):?>
					<option value="<?=$i?>"><?=$i?></option>
				<?php endfor;?>
			</select>
		</div>
		
		<div class="col-xs-4">
		
			<select name="month" class="form-control" id="c_month">
				<option value="">--<?=lang('c_month')?>--</option>
				<?php for ($i=1; $i<=12; $i++):?>
					<option value="<?=$i?>">Th. <?=$i?></option>
				<?php endfor;?>
			</select>
			
		</div>
		
		<div class="col-xs-4">
		
			<select name="year" class="form-control" id="c_year">
				<option value="">--<?=lang('c_year')?>--</option>
				<?php $current_year = date('Y'); for ($i = ($current_year - 12); $i >= ($current_year - 80); $i--):?>
					<option value="<?=$i?>"> <?=$i ?></option>
				<?php endfor;?>
			</select>
			
		</div>
		
		<div class="col-xs-12">
			<div class="bpv-color-warning warning-message" id="birthday_valid"><?=lang('c_birthday_valid')?></div>
		</div>
	</div>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-6" style="padding-right:0">
			<label for="city"><?=lang('c_city')?></label>
			<select class="form-control input-sm" id="city" name="city">
				<option value=""><?=lang('c_select_city')?></option>
				<?php foreach ($c_cities as $city):?>
					<option value="<?=$city['id']?>"><?=$city['name']?></option>
				<?php endforeach;?>
			</select>
		</div>
		<div class="col-xs-6">
			<label for="address"><?=lang('c_address')?></label>
			<input type="text" class="form-control input-sm" id="address" name="address">
		</div>
	</div>
	<div class="row margin-bottom-10">
		<div class="col-xs-12">
			<label for="special_request"><?=lang('c_special_request')?></label>
			<textarea class="form-control" rows="5" name="special_request" id="special_request"><?=$request?></textarea>	
		</div>
	</div>
		
</div>

<?php if($show_button):?>
<div class="margin-bottom-20 text-center">
	<button type="submit" name="action" value="<?=ACTION_MAKE_BOOKING?>" class="btn btn-bpv btn-lg" onclick="return validate_contact_form()">
		<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('c_send_request')?>
	</button>
</div>
<?php endif;?>
