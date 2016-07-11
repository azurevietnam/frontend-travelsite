<?php if(!empty($tours)):?>
<?php
    $is_empty_review = true;
    $is_empty_offer = true;
    $is_empty_route = true;
    foreach ($tours as $tour) {
        if(!empty($tour['special_offers'])) {
            $is_empty_offer = false;
        }
        if(!empty($tour['route_highlight'])) {
            $is_empty_route = false;
        }
        if(!empty($tour['review_number'])) {
            $is_empty_review = false;
        }
    }
    
    if(!isset($is_limited)) $is_limited = true;// default is limited showing
    
    $tmp_tours = array_chunk($tours, 3);
?>

<?php foreach($tmp_tours as $tours):?>

<?php if(!$is_limited):?>
	<div class="row margin-top-15 margin-bottom-15 best-tours">
<?php endif?>

<?php foreach ($tours as $tour):?>
	<div class="col-xs-4 tour-ids" data-id="<?=$tour['id']?>">
	    <div class="item">
	        <div class="item-img">
	        <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
	        <img class="img-responsive" alt="<?=$tour['name']?>" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '265_177')?>">
	        </a>
	        
	        <?php if(!empty($tour['max_offer_rate'])):?>
	        <div class="max-offer-rate"><?='-'.$tour['max_offer_rate'].'%'?></div>
	        <?php endif;?>
	        </div>
	        
	        <div class="item-content">
	            <a class="clearfix item-name" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
			
	            <?php if(!$is_empty_route):?>
	            <div class="clearfix item-row item-route" <?=set_tooltip($tour['route_highlight'], 70)?>>
	            <?php $route = character_limiter($tour['route_highlight'], 70)?>
	            <?php 
                	$icon = '<span class="icon icon-long-arrow-right-orange"></span>';
                    $route = str_replace('-', $icon, $route);
                ?>
                <?=$route?>
	            </div>
	            <?php endif;?>
	            
	            <?php if(!$is_empty_review):?>
	            <div class="clearfix item-row item-review">
	            	<?=get_text_review($tour, TOUR, true, false, true)?>
	            </div>
	            <?php endif;?>
	            
	            <?php if(!$is_empty_offer):?>
	            
	            <div class="item-promotion">
	            <?php if(!empty($tour['special_offers'])):?>
	                <?=$tour['special_offers']?>
	            <?php endif;?>
	            </div>
	            
	            <?php endif;?>
	    		
	    		<div class="clearfix item-price">
	    		    <div class="pull-left">
	        		    <span class="text-unhighlight"><?=lang('from')?>:</span> <span class="text-price"><?=lang('lbl_us')?></span> <span class="price-from t-from-<?=$tour['id']?>"><?=!empty($tour['price']) ? show_usd_price($tour['price']['price_from']) : lang('na')?></span>
	        		    <span class="text-unhighlight"><?=lang('per_pax')?></span>
	                </div>
	        		<a class="btn btn-yellow pull-right" type="button" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=lang('btn_select')?></a>
	    		</div>
	        </div>
	    </div>
	</div>


<?php endforeach;?>

<?php if(!$is_limited):?>
</div>
<?php endif;?>

	<?php if($is_limited) break;?>

<?php endforeach;?>

<?php endif;?>
<?php if ($is_limited):?>
<script type="text/javascript">
	//set_popover('.pro-offer-note');
	load_arrow_offer('.best-tours', true);

	equal_height('.best-tours .item-name,.best-tours .item-route,.best-tours .item-promotion');
</script>
<?php endif;?>