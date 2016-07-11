<div class="most-recommended margin-bottom-20 today-deal">
    <div class="recommend-header">
        <h2 class="text-special"><span class="icon icon-hot-deal margin-right-5"></span><?=lang('today_hot_deals')?></h2>
    </div>
    <div class="recommend-content">
        <?php if(strlen($tour['name']) > 40):?>
        <div class="recommend-name">
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
            <span class="icon <?=get_icon_star($tour['star'])?>"></span><?=get_partner_name($tour)?>
        </div>
        <?php else:?>
        <div class="recommend-name">
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
        </div>
        <div class="clearfix">
        <span class="icon <?=get_icon_star($tour['star'])?> margin-left-5"></span><?=get_partner_name($tour)?>
        </div>
        <?php endif;?>
        
        <?php if(!empty($tour['route_highlight'])):?>
        <div class="clearfix item-route">
        <?php 
        	$icon = '<span class="icon icon-long-arrow-right-orange"></span>';
            $route = str_replace('-', $icon, $tour['route_highlight']);
        ?>
        <?=$route?>
        </div>
        <?php endif;?>
        
        <?php if(!empty($tour['special_offers'])):?>
        <div class="clearfix today-offer" id="today_offer">
            <div class="text-special today-offer-title">
                <b style="font-size: 14px"><?=lang('label_special_offers')?></b>
                <span class="pro-offer-rate">
                <?=lang_arg('lbl_max_offer_rate', $tour['max_offer_rate'])?>
                <span class="pro-offer-rate-arrow-white"></span>
                <span class="pro-offer-rate-arrow"></span>
                </span>
            </div>
            <?=$tour['special_offers']?>
        </div>
        <?php endif;?>
        
    	<?php if (!empty($tour['review_number'])):?>
    	<div class="row text-center review-box">
    	   <div class="col-xs-7">
    	       <span class="icon icon-review"></span><br>
    	       <?=get_text_review($tour, TOUR, true, true)?>
    	   </div>
    	   <?php if(!empty($tour['promotion']['book_to'])):?>
    	   <div class="col-xs-5 time-left text-center">
    	       <div class="clearfix margin-bottom-5 margin-top-5 text-center">
    	       <img style="float: none;" src="<?=get_static_resources('/media/icon/time_left.jpg')?>">
    	       </div>
    	       <?=get_deal_expired_text($tour['promotion']['book_to'])?>
    	   </div>
    	   <?php endif;?>
    	</div>
    	<?php endif;?>
    </div>
    
    <div class="recommend-price">
        <div class="col-xs-6">
            <?php if(!empty($tour['price'])):?>	
            <div class="price-origin-box margin-top-10">
            	<span class="price-origin"><?=lang('lbl_us')?> <?=show_usd_price($tour['price']['price_origin'])?></span>
            	<span class="price-from"><?=show_usd_price($tour['price']['price_from'])?></span><?=lang('per_pax')?>
        	</div>
        	<?php else:?>
                <?=lang('na')?>
        	<?php endif;?>
        </div>
        <div class="col-xs-6 no-padding">
            <a class="btn btn-green pull-right margin-right-10" type="button" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
        	<?=ucwords(strtolower(lang('see_deals')))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
        	</a>
        </div>
	</div>
    
    <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '450_300')?>" alt="<?=$tour['name']?>">
</div>
<script>
$('.pro-offer-rate').css('height', $('#today_offer').height() + 20);
var height = ($('.pro-offer-rate').height() / 2) + 12;
$('.pro-offer-rate-arrow').css('border-top-width', height);
$('.pro-offer-rate-arrow').css('border-bottom-width', height);
$('.pro-offer-rate-arrow').css('margin-top', 0 - height);
$('.pro-offer-rate-arrow, .pro-offer-rate-arrow-white').css('visibility', 'visible');
$('.pro-offer-rate-arrow-white').css('border-top-width', parseInt(height + 2));
$('.pro-offer-rate-arrow-white').css('border-bottom-width', parseInt(height + 2));
$('.pro-offer-rate-arrow-white').css('margin-top', 0 - parseInt(height + 2));
</script>