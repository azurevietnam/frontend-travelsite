<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="boxGray">
<h1 class="highlight" style="padding-left: 0;"><?=$faq['question']?></h1>
			
<div class="faq_question margin_top_10">
	<?php 
		$answers = explode("\n", $faq['answer']);
	?>
	
	<?php foreach ($answers as $value) :?>
		<p><?=$value?></p>
	<?php endforeach;?>	
	
	<?php if ($faq['picture'] != ''):?>
		<img width="100%" src="<?=$this->config->item('faq_path').'/'.$faq['picture']?>"></img>
	<?php endif;?>
</div>

<br/>
<?php if(count($questions) > 0):?>
	<h3 style="padding-left: 0"><?=lang('related_questions')?>:</h3>
<?php endif;?>

<?php foreach ($questions as $key=>$value):?>
	<?php if($faq['id'] != $value['id']):?>
	<div class="faq_question margin_top_10">
	
		<a href="<?=url_builder(FAQ_DETAIL, $value['url_title'], true)?>"><?=$value['question']?></a>
		
	</div>		
	<?php endif;?>
<?php endforeach;?>
</div>