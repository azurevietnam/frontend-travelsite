<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h2 class="highlight"><span class="icon icon_faqs"></span><?=lang('faq')?></h2>
<?php foreach ($faq_questions as $faq):?>
<div class="tour"><span class="arrow">&rsaquo;</span><a <?php if(isset($is_new_tab)) echo 'target="_blank"';?> href="<?=url_builder(FAQ_DETAIL, $faq['url_title'], true)?>" title="<?=$faq['question']?>"><?=$faq['question']?></a></div>
<?php endforeach;?>
