<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<h1 class="highlight" style="padding-left: 0;"><?=$category_name?></h1>
				
	<?php foreach ($questions as $key=>$value):?>	
		<div class="faq_question margin_top_10">
			<a href="<?=url_builder(FAQ_DETAIL, $value['url_title'], true)?>"><?=$value['question']?></a>
		</div>		
	<?php endforeach;?>
