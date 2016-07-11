<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link rel="stylesheet" type="text/css" href="/css/faq.min.css" />
<h1 class="highlight">	
	<?=lang('cruise_faq')?>
</h1>

<?php foreach ($faq_questions as $faq):?>
<div class="tour"><span class="arrow">&rsaquo;</span><a href="<?=url_builder(FAQ_DETAIL, $faq['url_title'], true)?>" title="<?=$faq['question']?>"><?=character_limiter($faq['question'], TOUR_NAME_LIST_CHR_LIMIT)?></a></div>
<?php endforeach;?>

