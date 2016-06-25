<div class="bpv-step-bar">
	<div class="row" style="white-space:nowrap;">
		<div class="col-xs-3">
			<span class="step step-ok">1</span>
			<span class="title title-ok"><?=lang('flight_step_1')?></span>
		</div>
		<div class="col-xs-3">
			<span class="step <?php if($step==2):?>step-active<?php elseif($step > 2):?>step-ok<?php endif;?>">2</span>
			<span class="title <?php if($step==2):?>title-active<?php elseif($step > 2):?>title-ok<?php endif;?>"><?=lang('flight_step_2')?></span>
		</div>
		<div class="col-xs-3">
			<span class="step <?php if($step==3):?>step-active<?php endif;?>">3</span>
			<span class="title <?php if($step==3):?>title-active<?php endif;?>"><?=lang('flight_step_3')?></span>
		</div>
		<div class="col-xs-3">
			<span class="step">4</span>
			<span class="title"><?=lang('step_confirm')?></span>
		</div>
	</div>
</div>