<h1 class="highlight"><?=lang('vietnam_visa_types')?></h1>
<?php if(isset($link_data)):?>
	<?php 
		$answers = explode("\n", $link_data);
	?>
	
	<?php foreach ($answers as $value) :?>
		<p><?=$value?></p>
	<?php endforeach;?>	
<?php endif;?>
<div class="related-info">
<h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
<?=$top_visa_questions?>
</div>