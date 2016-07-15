<div class="container">
    <h1 class="text-highlight"><?=lang('vietnam_visa_types')?></h1>
    <?php if(isset($link_data)):?>
    	<?php 
    		$answers = explode("\n", $link_data);
    	?>
    	
    	<?php foreach ($answers as $value) :?>
    		<p><?=$value?></p>
    	<?php endforeach;?>	
    <?php endif;?>
    <div class="margin-top-20">
    <h3><?=lang('related_visa_information')?></h3>
    <?=$top_visa_questions?>
    </div>
</div>