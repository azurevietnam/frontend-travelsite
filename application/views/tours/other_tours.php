<?php if(count($other_tours) >0):?>
<div id="other_tours" class="left_list_item_block">
	<h2 class="highlight"><span class="icon icon_tours"></span>Tours of <?=$tour['partner_name']?></h2>
	<?php foreach ($other_tours as $other_tour):?>
	<div class="tour"><span class="arrow">&rsaquo;</span><a href="<?=url_builder(TOUR_DETAIL, $other_tour['url_title'], true)?>" title="<?=$other_tour['name']?>"><?=character_limiter($other_tour['name'], TOUR_NAME_LIST_CHR_LIMIT)?></a></div>
	<?php endforeach;?>
</div>
<?php endif;?>