<div class="container basic-info">
    <div class="margin-top-10 pull-left block-content">
        <span class="pull-left margin-right-5"><?=lang('lbl_tour_code')?></span>
        <?=$tour['code']?>
    </div>
    <div class="margin-top-5 pull-left">
        <span class="pull-left margin-right-5"><?=lang('lbl_duration')?></span>
        <?=get_duration_text($tour)?>
    </div>
    <div class="margin-top-5 pull-left">
        <span class="pull-left margin-right-5"><?=lang('lbl_tour_route')?></span>
        <?=$tour['route']?>
    </div>
    <div class="margin-top-5 pull-left margin-bottom-10 block-content">
        <?=get_departure_date_text($tour)?>
    </div>
    <div class="row margin-top-10 margin-bottom-10 block-content">
        <div class="col-xs-6">
        <?php if (!empty($tour['price_from'])):?>
            	<?php if($tour['price_origin'] != $tour['price_from']):?>
            		<span class="bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></span>
            	<?php endif;?>
            	<span class="bpv-price-from">
            		<?=bpv_format_currency($tour['price_from'])?>
            		<small style="font-size: 12px; color: #333"><?=lang('/pax')?></small>
            	</span>
        <?php endif;?>
        </div>
        <div class="col-xs-6 pd-right-0">
        <?php 
    		$call_us = load_bpv_call_us_number(TOUR);
    	?>
    	
    	<?php if(!empty($call_us)):?>
        	<a class="btn-call pull-right" href="tel:<?=$call_us?>">
        		<i class="glyphicon glyphicon-earphone"></i> <span><?=$call_us?></span>
        	</a>
        <?php endif;?>
        </div>
    </div>
    
    <?php if(!empty($tour['promotions'])):?>
    	<?php foreach ($tour['promotions'] as $pro):?>
    		<div class="margin-bottom-5 bpv-pro">
    			<?=load_promotion_tooltip($pro, $tour['id'], '', true)?>
    			<i class="icon icon-arrow-right-gray"></i>
    		</div>
    	<?php endforeach;?>
    <?php endif;?>
    
    <?php if(!empty($tour['bpv_promotions'])):?>
    	<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
    		<div class="margin-bottom-5 bpv-pro">
    			<?=load_marketing_pro_tooltip($bpv_pro, $tour['cruise_id'], '', true)?>
    			<i class="icon icon-arrow-right-gray"></i>
    		</div>
    	<?php endforeach;?>
    <?php endif;?>
    
    <div class="margin-top-10 margin-bottom-20">
        <div id="desc_<?=$tour['id']?>_short">
            <?=insert_data_link(character_limiter($tour['description'], 400));?>
            <?php if(strlen($tour['description']) > 400):?>	
            <a href="javascript:void(0)" onclick="readmore('desc_<?=$tour['id']?>')"><?=lang('btn_show_extra')?> &raquo;</a>
            <?php endif;?>
        </div>
        
        <?php if(strlen($tour['description']) > 400):?>		
		<div style="display: none;" id="desc_<?=$tour['id']?>_full">
            <?=insert_data_link($tour['description']);?>
            <a href="javascript:void(0)" onclick="readless('desc_<?=$tour['id']?>')"><?=lang('view_less')?> &laquo;</a>
		</div>
		<?php endif;?>
    </div>
</div>