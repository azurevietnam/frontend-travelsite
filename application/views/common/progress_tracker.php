<div id="tracker">
	<div id="breadCrumb0">
		<div class="breadCrumb_text"><?=lang('label_welcome')?></div>
	</div>
	<div id="breadCrumb1" <?php if($progress_tracker_id == 1):?>class="currentStep"<?php endif;?>>
		<div class="icon breadCrumb_stepNo">1</div>
		<div class="breadCrumb_text"><?=lang('step_1')?></div>
	</div>
	<div id="breadCrumb2" <?php if($progress_tracker_id == 2):?>class="currentStep"<?php endif;?>>
		<div class="icon breadCrumb_stepNo">2</div>
		<div class="breadCrumb_text"><?=lang('extra_services')?></div>
	</div>
	<div id="breadCrumb3" <?php if($progress_tracker_id == 3):?>class="currentStep"<?php endif;?>>
		<div class="icon breadCrumb_stepNo">3</div>
		<div class="breadCrumb_text"><?=lang('label_my_booking')?></div>
	</div>
	 
	<div id="breadCrumb4" <?php if($progress_tracker_id == 4):?>class="currentStep"<?php endif;?>>
		<div class="icon breadCrumb_stepNo">4</div>
		<div class="breadCrumb_text"><?=lang('step_3')?></div>
	</div>

</div>