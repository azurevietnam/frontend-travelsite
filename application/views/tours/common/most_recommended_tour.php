<div class="most-recommended margin-bottom-20 tour-ids" data-id="<?=$tour['id']?>">
    <div class="recommend-header">
        <h2 class="text-special"><span class="icon icon-most-recommend"></span><?=$most_recommended_title?></h2>
    </div>
    <div class="recommend-content">
        <div class="recommend-name margin-bottom-5">
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a><?=get_partner_name($tour)?>
        </div>

        <div class="clearfix margin-bottom-10 margin-left-5">
        <?php
            $icon = '<span class="icon icon-long-arrow-right-orange"></span>';
            $route_highlight = str_replace('-', $icon, $tour['route_highlight']);
            echo $route_highlight;
        ?>
    	</div>

    	<?php if(!empty($tour['highlights'])):?>
    	<div class="clearfix tour-highlight">
            <div class="clearfix tour-highlight-title text-choice"><span class="icon icon-destination-info"></span> <?=lang('lbl_tour_highlights')?>:</div>
            <ul class="clearfix tour-highlight-content">
                <?php foreach ($tour['highlights'] as $k => $value):?>
                <?php if($k > 2) break;?>
                <?php $value = strip_tags($value['label'].': '.$value['title'])?>
                <li class="margin-bottom-5"><span class="circle"></span><span><?=$value?></span></li>
                <?php endforeach;?>
            </ul>
    	</div>
    	<?php else:?>
    	<?php $tour_highlights = explode("\n", $tour['tour_highlight']);?>
    	<div class="clearfix tour-highlight">
            <div class="clearfix tour-highlight-title text-choice"><span class="icon icon-destination-info"></span> <?=lang('lbl_tour_highlights')?>:</div>
            <ul class="clearfix tour-highlight-content">
                <?php $cnt = 0;?>
            	<?php foreach ($tour_highlights as $value):?>
            	<?php if($cnt == 3) break;?>
        		<?php if(!empty($value)):?>
        		<li class="margin-bottom-5"><span class="circle"></span><span><?=$value?></span></li>
        		<?php $cnt++;?>
        		<?php endif;?>
            	<?php endforeach;?>
            </ul>
    	</div>
    	<?php endif;?>
    	
    	<?php if(!empty($tour['special_offers'])):?>
    	<div class="clearfix margin-bottom-10">
            <?=$tour['special_offers']?>
        </div>
        <?php endif;?>

    	<?php if (!empty($tour['review_number'])):?>
    	<div class="clearfix">
    	<span class="icon icon-review margin-right-10"></span><?=get_text_review($tour, TOUR, true, true)?>
    	</div>
    	<?php endif;?>
    </div>
    
    <div class="recommend-price">
        <div class="col-xs-6 text-left">
            <span class="text-price"><?=lang('lbl_us')?></span>
            <span class="price-origin t-origin-<?=$tour['id']?>"></span>
            <span class="price-from t-from-<?=$tour['id']?>"><?=lang('na')?></span><?=lang('per_pax')?>
        </div>
        <div class="col-xs-6 text-right">
            <a class="btn btn-green" type="button" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
        	<?=ucwords(lang('see_details'))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
        	</a>
        </div>
	</div>

    <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '450_300')?>" alt="<?=$tour['name']?>">
</div>