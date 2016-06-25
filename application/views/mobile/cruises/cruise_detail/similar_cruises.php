<?php if(count($s_cruises) > 0):?>
<div class="bpv-list margin-top-20">
	<h2 class="bpv-color-title"><?=lang('similar_cruises')?></h2>
	
    <?php foreach ($s_cruises as $k => $cruise):?>
    
        <div class="bpv-item" onclick="go_url('<?=cruise_build_url($cruise, $search_criteria)?>')">
                
            <img class="pull-left" src="<?=get_image_path(CRUISE, $cruise['picture'],'160x120')?>">
        
            <div class="item-name"><?=$cruise['name']?> <i class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></i></div>
             
            <?php if(!empty($cruise['review_number'])):?>
            <div class="item-review-lst">
                 <?=show_review($cruise, cruise_build_url($cruise), false, true)?>
            </div>
            <?php endif;?>

            <?php if (isset($cruise['price_from'])):?>
        
                <div class="pull-right item-price">
                    <?php if ($cruise['price_origin'] != $cruise['price_from']):?>
                    <span class="bpv-price-origin"><?=bpv_format_currency($cruise['price_origin'])?></span>
                    <?php endif;?>
                    
                    <span class="bpv-price-from">
                		<?=bpv_format_currency($cruise['price_from'])?>
                		<small class="price-unit" <?php if ($cruise['price_origin'] != $cruise['price_from']) echo 'style="display:block"';?>><?=lang('/pax')?></small>
                    </span>
                </div>
                
                <?php if ($cruise['price_origin'] != $cruise['price_from'] && !empty($cruise['promotions'])):?>
                   <span class="pro-off"><?=get_pro_off($cruise)?></span>
                <?php endif;?>
            
             <?php else:?>
        
                <?php $params = get_contact_params($cruise, $search_criteria);?>
        			
        		<a type="button" class="btn btn-bpv btn-book-now btn-sm col-xs-4 margin-top-5 pull-right margin-right-5" href="<?=get_url(CONTACT_US_PAGE, $params)?>">
        			<?=lang('m_contact_for_price')?>
        		</a>    
            
            <?php endif;?>
        </div>

	<?php endforeach;?>
</div>
<?php endif;?>