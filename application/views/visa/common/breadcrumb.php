<div id="tracker">
	<div id="breadCrumb0" <?=isset($is_visa_details) ? 'style="width:auto"' : ''?>>
		<div class="breadCrumb_text"><?=lang_arg('apply_visa_progress', $breadcrumb_pos)?></div>
	</div>
	<div id="breadCrumb1" <?php if($breadcrumb_pos == 1) echo 'class="currentStep"';?>>
		<div class="icon breadCrumb_stepNo">1</div>
		<div class="breadCrumb_text"><?=lang('apply_visa_progress_1')?></div>
	</div>
	<div id="breadCrumb2" <?php if($breadcrumb_pos == 2) echo 'class="currentStep"';?>>
		<div class="icon breadCrumb_stepNo">2</div>
		<div class="breadCrumb_text"><?=lang('apply_visa_progress_2')?></div>
	</div>
	<div id="breadCrumb3" <?php if($breadcrumb_pos == 3) echo 'class="currentStep"';?>>
		<div class="icon breadCrumb_stepNo">3</div>
		<div class="breadCrumb_text"><?=lang('apply_visa_progress_3')?></div>
	</div>
</div>