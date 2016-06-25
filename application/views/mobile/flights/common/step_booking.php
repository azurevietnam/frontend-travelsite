<div class="row bpv-step-bar">
	<div class="col-xs-3 text-center">
		<span class="step step-ok">1</span>
		<span class="title title-ok"><?=lang('m_flight_step_1')?></span>
		<span class="glyphicon glyphicon-chevron-right arrow arrow-ok"></span>
	</div>
	<div class="col-xs-3 text-center">
		<span class="step <?php if($step==2):?>step-active<?php elseif($step > 2):?>step-ok<?php endif;?>">2</span>
		<span class="title <?php if($step==2):?>title-active<?php elseif($step > 2):?>title-ok<?php endif;?>"><?=lang('m_flight_step_2')?></span>
		<span class="glyphicon glyphicon-chevron-right arrow <?php if($step > 2):?>arrow-ok<?php endif;?>"></span>
	</div>
	<div class="col-xs-3 text-center">
		<span class="step <?php if($step==3):?>step-active<?php endif;?>">3</span>
		<span class="title <?php if($step==3):?>title-active<?php endif;?>"><?=lang('flight_step_3')?></span>
		<span class="glyphicon glyphicon-chevron-right arrow"></span>
	</div>
	<div class="col-xs-3 text-center">
		<span class="step">4</span>
		<span class="title"><?=lang('step_confirm')?></span>
	</div>
</div>
