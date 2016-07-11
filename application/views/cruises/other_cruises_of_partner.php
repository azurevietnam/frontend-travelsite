<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(count($partner_cruises) > 0):?>

	<div class="left_list_item_block">
	<h2 class="highlight"><span style="*margin-bottom:5px;" class="icon icon_cruises"></span><?=$cruise['partner_name']?></h2>
	
	<?php foreach ($partner_cruises as $cruise):?>
	<div class="tour"><span class="arrow">&rsaquo;</span><a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>" title="<?=$cruise['name']?>"><?=character_limiter($cruise['name'], TOUR_NAME_LIST_CHR_LIMIT)?></a>
		<?php 
		$star_infor = get_star_infor($cruise['star'], 0);
		?>
		<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>">&nbsp;</span>
	</div>
	<?php endforeach;?>
	</div>

<?php endif;?>