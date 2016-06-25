<?php foreach ($tours as $k => $tour):?>
<?php
    $class_has_pro_off = ''; 
    if ( isset($tour['price_from']) && $tour['price_origin'] != $tour['price_from'] && !empty($tour['promotions'])) {
        $class_has_pro_off = ' has-pro-off';
    }
?>
    
<div class="bpv-item" <?=($k == 0) ? 'style="border-top:1px solid #848484"' : ''?>
        onclick="go_url('<?=cruise_tour_build_url($tour, $search_criteria)?>')">
    <img class="pull-left" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'],'160x120')?>">

    <div class="item-name<?=$class_has_pro_off?>">
    <?=$tour['name']?> <i class="icon star-<?=str_replace('.', '_', $tour['star'])?>"></i>
    </div>
    
    <?php if(!empty($tour['review_number'])):?>
    <div class="item-review-lst">
        <?=show_review($tour, cruise_tour_build_url($tour), false, true)?>
    </div>
    <?php endif;?>
    	
    <?php if (isset($tour['price_from'])):?>
    
        <div class="pull-right item-price">
            <?php if ($tour['price_origin'] != $tour['price_from']):?>
            <span class="bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></span>
            <?php endif;?>
            
            <span class="bpv-price-from">
        		<?=bpv_format_currency($tour['price_from'])?>
        		<small class="price-unit" <?php if ($tour['price_origin'] != $tour['price_from']) echo 'style="display:block"';?>><?=lang('/pax')?></small>
            </span>
        </div>
        
        <?php if ($tour['price_origin'] != $tour['price_from'] && !empty($tour['promotions'])):?>
           <span class="pro-off"><?=get_pro_off($tour)?></span>
        <?php endif;?>
        
    <?php else:?>
    
        <?php $params = get_contact_params($tour, $search_criteria);?>
			
		<a type="button" class="btn btn-bpv btn-book-now btn-sm col-xs-4 margin-top-5 pull-right margin-right-5" href="<?=get_url(CONTACT_US_PAGE, $params)?>">
			<?=lang('m_contact_for_price')?>
		</a>    
    
    <?php endif;?>
		
</div>

<?php endforeach;?>

