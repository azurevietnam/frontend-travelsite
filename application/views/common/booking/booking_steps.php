<div class="bpt-steps-bar">
	<div class="row">
    <?php foreach($step_labels as $key=>$value):?>
        <div class="col-xs-3 <?php if($current_step == $key) echo 'step_active'; elseif($current_step > $key) echo 'step-ok'?>">
            <div class="step"><?=$key?></div>
            <div class="arrow"></div>
            <div class="title"><?=lang($value)?></div>
        </div>
    <?php endforeach;?>
	</div>
</div>
