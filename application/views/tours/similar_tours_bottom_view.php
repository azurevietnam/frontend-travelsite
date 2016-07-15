<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(isset($similar_tours) && count($similar_tours)>0):?>

	<div class="clearfix"></div>

    <div class="similar-items">
		
		<h2 class="highlight">
			<?php $tour_text = get_similar_tour_text($tour);?>
			<?=$tour_text['title']?>
		</h2>
	
	</div>

    <div class="tile-grid">

        <?php foreach ($similar_tours as $key=>$other_tour):?>
            <?php if($key > 3) continue;?>
            <div class="tile col">
                <h4>
                    <a class="item_name" href="<?=url_builder(TOUR_DETAIL, $other_tour['url_title'], true)?>" title="<?=$other_tour['name']?>"><?=character_limiter($other_tour['name'], TOUR_NAME_LIST_CHR_LIMIT)?></a>
                </h4>
                <a href="<?=url_builder(TOUR_DETAIL, $other_tour['url_title'], true)?>">
                    <img class="item_img" alt="<?=$other_tour['name']?>" src="<?=$this->config->item('tour_220_165_path').$other_tour['picture_name']?>"/>
                </a>

                <?php if ($other_tour['review_number'] > 0):?>
                    <div class="item-review">
                        <b><?=$other_tour['total_score']?></b> of <?=get_review_text($other_tour)?>
                    </div>
                <?php endif;?>


                <div class="item-price">
                    <?php $price_view = get_tour_price_view($other_tour); ?>
                    <?php if($price_view['f_price'] > 0):?>
                        <?php if($price_view['d_price'] > 0):?>
                            <?=CURRENCY_SYMBOL?><span class="b_discount"><?=$price_view['d_price']?></span>
                        <?php endif;?>
                        <span class="price_from"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span><?=lang('per_pax')?>
                    <?php else:?>
                        <span class="price_from"><?=lang('na')?></span>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach;?>

        <div class="more_item">
            <span class="arrow">&rsaquo;</span><?=get_text_link_function(url_builder(MODULE_TOURS, $tour['des']['url_title'] . '-' .MODULE_TOURS), $tour_text['more_text'], $tour)?>
        </div>
    </div>
	
<?php endif;?>