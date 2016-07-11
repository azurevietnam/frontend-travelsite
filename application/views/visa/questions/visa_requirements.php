<h1 class="highlight" style="padding: 0"><?=lang('vietnam_visa_rquirements')?></h1>
<p><?=lang('please_check_whether_need_a_voa')?></p>
<div class="boxBlue">
	<div class="highlight" style="float: left; margin-left: 175px; font-size: 14px; font-weight: bold; margin-bottom: 5px"><?=lang('label_select_nationality')?></div>
	<div style="clear: both; margin-left: 50px">
	<img width="64" height="64" src="<?=get_static_resources('/media/passport_icon.png')?>" style="position: absolute; left: 100px; top: 10px">
	<select name="nationality" style="padding: 2px" id="ck_nationality">
		<option value="">-- <?=lang('please_select_nationality')?> --</option>
		<?php foreach ($countries as $country) :?>
		<?php
			$url_ct_name = strtolower(trim($country['name']));  
			$url_ct_name = str_replace(' ', '-', $url_ct_name);
			$url_ct_name .= '.html';
		?>
		<option value="<?=$url_ct_name?>"><?php echo $country['name']?></option>
		<?php endforeach;?>
	</select>
	
	<div onclick="check_requirements()" class="btn_general book_visa" style="padding: 6px 14px; float: none; margin: 0 0 0 10px; display: inline;">
		<span><?=lang('check_requirements')?></span>
	</div>
	</div>
</div>
<p><?=lang('check_requirements_desc')?></p>

<div class="related-info">
<h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
<?=$top_visa_questions?>
</div>