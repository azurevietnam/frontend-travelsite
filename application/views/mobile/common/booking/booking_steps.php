<div class="row bpv-step-bar">
    <?php $col = count($step_labels)%3 == 0 ? 'col-xs-4' : 'col-xs-3'?>
    <?php foreach($step_labels as $key=>$value):?>
        <div class="<?=$col?> text-center">           
           	<span class="step <?php if($current_step==$key):?>step-active<?php elseif($current_step > $key):?>step-ok<?php endif;?>"><?=$key?></span>
			<span class="title <?php if($current_step==$key):?>title-active<?php elseif($current_step > $key):?>title-ok<?php endif;?>"><?=lang($value)?></span>
			<?php if ($key < count($step_labels)):?>
				<span class="glyphicon glyphicon-chevron-right arrow <?php if($current_step > $key):?>arrow-ok<?php endif;?>"></span>
			<?php endif;?>
        </div>
    <?php endforeach;?>
</div>