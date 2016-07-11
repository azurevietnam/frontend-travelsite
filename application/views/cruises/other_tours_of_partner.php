<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h2 class="highlight" style="padding:5px 0 5px 10px;">
	<?=$partner['short_name']?>	<?=lang('other_tour_of')?>
</h2>

<?php foreach ($partner_tours as $f_tour):?>
<div class="tour"><span class="arrow">&rsaquo;</span><a href="<?=url_builder(TOUR_DETAIL, $f_tour['url_title'], true)?>" title="<?=$f_tour['name']?>"><?=character_limiter($f_tour['name'], TOUR_NAME_LIST_CHR_LIMIT)?></a></div>
<?php endforeach;?>