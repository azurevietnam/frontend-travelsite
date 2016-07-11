<?php if(!empty($cruises)):?>

<?php foreach ($cruises as $key => $cruise):?>
<div class="bpt-mb-item clearfix cruise-ids" data-id="<?=$cruise['id']?>" onclick="go_url('<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>')">
    <img class="bpt-mb-item-image pull-left" alt="<?=$cruise['name']?>" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture'], '210_140')?>">
    
    <div class="bpt-mb-item-name" style="margin-right: 32px">
        <?=$cruise['name']?> <span class="icon <?=get_icon_star($cruise['star'])?>"></span>
    </div>
    
    <?php
	   $price_origin = !empty($cruise['price']['price_origin']) ? show_usd_price($cruise['price']['price_origin']) : '';
	   $price_from = !empty($cruise['price']['price_from']) ? show_usd_price($cruise['price']['price_from']) : lang('na');
	?>
	
	<span class="bpt-item-off-bg" id="c-pro-rate-bg-<?=$cruise['id']?>"></span>
	<span class="bpt-item-off-txt" id="c-pro-rate-<?=$cruise['id']?>"></span>
    
    <div class="bpt-mb-item-price">
		<span class="price-origin c-origin-<?=$cruise['id']?>"><?=$price_origin?></span>
		<span class="price-from c-from-<?=$cruise['id']?>"><?=$price_from?></span>
		<span class="item-from c-unit-<?=$cruise['id']?>" <?=empty($cruise['price']) ? 'style="display:none"' : ''?>><?=lang('per_pax')?></span>
	</div>
	
	<?php if($cruise['review_number'] > 0):?>
	<div class="bpt-mb-item-review margin-top-5"><?=get_text_review($cruise, CRUISE, false)?></div>
	<?php endif?>
</div>
<?php endforeach;?>

<?php if(isset($is_show_more) && $is_show_more):?>
<div id="more_cruises">
    <div class="container" id="more_cruises_btn">
        <button class="btn btn-default btn-block btn-show-more" data-link="<?=site_url('show-more-cruise-by-type').'/'?>" 
        data-is_enable_number="<?=$is_enable_number?>" data-page="<?=$page?>" data-offset="10" rel="nofollow" id="btn_show_more_cruises">
        <span class="glyphicon glyphicon-triangle-bottom"></span>
        <?=lang_arg('lbl_show_more', $page_title)?>
        </button>
        <script>
        load_more_cruise_tour_items('#more_cruises', '#btn_show_more_cruises');
        </script>
    </div>
</div>
<?php endif;?>

<?php endif;?>