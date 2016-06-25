<div class="bpv-collapse margin-top-2">
    <h5 class="heading no-margin" data-target="#tab_information">
		<i class="icon icon-star-white"></i>
		<?=lang('tab_information')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	<div id="tab_information" class="content">
	   <h3 class="bpv-color-title no-margin margin-bottom-10"><span class="icon icon-info-details"></span><?=lang('tour_important_info')?></h3>

        <div class="important-info">
        <?php
        	$notes = $tour['notes'];
        	
        	$notes = explode("\n", $notes);
        ?>
        <?php if(count($notes) > 0):?>
        
        	<ul style="padding-left: 20px">
        		<?php foreach ($notes as $value):?>
        			<?php if(!empty($value)):?>
        			<li class="margin-bottom-10"><?=$value?></li>
        			<?php endif;?>
        		<?php endforeach;?>
        	</ul>
        	
        <?php endif;?>
        </div>
	</div>
</div>