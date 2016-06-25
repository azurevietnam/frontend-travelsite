<?php foreach ($popular_tours as $tour):?>
<div class="col-xs-3">
    <div class="item">
		<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
			<img alt="<?=$tour['name']?>" src="<?=get_image_path(TOUR, $tour['picture'], '268x201')?>" class="img-responsive">
		</a>

		<?php 
			$deal_offer = get_tour_pro_value($tour);
		?>
		<?php if(!empty($deal_offer)):?>
			<div class="deal-offer"><?=$deal_offer?><div class="deal-arrow"></div></div>
		<?php endif;?>

		<div class="margin-top-10 item-name">
			<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" title="<?=$tour['name']?>"><?=$tour['name']?></a>
		</div>
		
		<?php if(!empty($tour['promotions'])):?>
			<?php foreach ($tour['promotions'] as $pro):?>
				<div class="item-promotion">
					<?=load_promotion_tooltip($pro, $tour['id'])?>
				</div>
			<?php endforeach;?>
		<?php elseif($has_promotion):?>
		    <div class="item-promotion"></div>
		<?php endif;?>
		
		<?php if(!empty($tour['bpv_promotions'])):?>
			<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
				<div>
					<?=load_marketing_pro_tooltip($bpv_pro, $tour['id'])?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
		
		<div class="clearfix item-route">
			<?=lang('lbl_tour_route')?><?=$tour['route']?>
		</div>
		
		<div class="clearfix item-duration">
			<?=lang('lbl_duration_short')?><span class="bpv-color-marketing"><?=get_duration_text($tour)?></span>
		</div>

		<div class="clearfix item-price">
		    <?php if(!empty($tour['price_origin'])):?>
		        
		        <?php if($has_price_off):?>
                <span class="bpv-price-origin">
                <?php if($tour['price_origin'] != $tour['price_from']):?>
                <?=bpv_format_currency($tour['price_origin'])?>
                <?php endif;?>
                </span>
                <?php endif;?>

                <span class="bpv-price-from"><?=bpv_format_currency($tour['price_from'])?></span>
                <a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" class="btn btn-bpv btn-book-now"> 
                <?=lang('btn_book_now')?>
                </a>
            <?php else:?>
                <?php 
    				$params = get_tour_contact_params($tour, $search_criteria);
    			?>
    			
    			<a href="<?=get_url(CONTACT_US_PAGE, $params)?>" class="btn btn-bpv btn-book-now btn-sm pull-right">
    				<?=lang('contact_for_price')?>
    			</a>
            <?php endif;?>
		</div>
    </div>
</div>

<?php endforeach;?>