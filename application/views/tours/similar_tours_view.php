<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(isset($similar_tours) && count($similar_tours)>0):?>
<div id="other_tours" class="left_list_item_block">
	<h2 class="highlight">
    <span class="icon icon-similar"></span><?php $tour_text = get_similar_tour_text($tour);?><?=$tour_text['title']?>
	</h2>
	<div class="price_note"><?=lang('price_per_pax_note')?></div>
	<?php foreach ($similar_tours as $other_tour):?>
	<div class="similar_tour">
		<div class="tour">
		<span class="arrow">&rsaquo;</span><a href="<?=url_builder(TOUR_DETAIL, $other_tour['url_title'], true)?>" title="<?=$other_tour['name']?>"><?=character_limiter($other_tour['name'], TOUR_NAME_LIST_CHR_LIMIT)?></a>
		<?=by_partner($tour, PARTNER_CHR_LIMIT)?>
		</div>
		<div class="tour_price">
			<?php $price_view = get_tour_price_view($other_tour); ?>
			<?php if($price_view['f_price'] > 0):?>
				<?php if($price_view['d_price'] > 0):?>
	        	<?=CURRENCY_SYMBOL?><span class="b_discount"><?=$price_view['d_price']?></span>
	        	<?php endif;?>
	        	<span class="price_total"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span>
	        <?php else:?>
	        	<span class="price_total"><?=lang('na')?></span>
        	<?php endif;?>
		</div>
	</div>
	<?php endforeach;?>
	
	<?php if(isset($tour['des'])):?>
	<div class="more_tour">
		<span class="arrow">&rsaquo;</span><?=get_text_link_function(url_builder(MODULE_TOURS, $tour['des']['url_title'] . '-' .MODULE_TOURS), $tour_text['more_text'], $tour)?>
	</div>
	<?php endif;?>
</div>
<?php endif;?>