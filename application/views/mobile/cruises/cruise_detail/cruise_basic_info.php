<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($cruise_photos as $k => $photo):?>
		<li>
	        <img class="img-responsive" src="<?=get_image_path(CRUISE, $photo['name'],'400x300')?>" alt="<?=$photo['caption']?>">
			
			<div class="flex-caption">
			<?php if($k == 0):?>
			    <h1 class="no-margin">
			    <?=$cruise['name']?>
			    <i class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></i>
			    </h1>
			<?php else:?>
                <?=$photo['caption']?>		     
			<?php endif;?>
			</div>
	 	</li>
	 	<?php endforeach;?>
	</ul>
</div>

<div class="container basic-info">
    <div class="margin-top-10">
    	<span class="pull-left margin-right-5"><?=lang('cruise_address')?></span>
    	<?=$cruise['address']?>
    </div>
    
    <div class="row margin-top-10 margin-bottom-10">
        <div class="col-xs-6">
        <?php if (!empty($cruise_price_from)):?>
        	<?php if($cruise_price_from['price_origin'] != $cruise_price_from['price_from']):?>
        		<span class="bpv-price-origin"><?=bpv_format_currency($cruise_price_from['price_origin'])?></span>
        	<?php endif;?>
        	
        	<span class="bpv-price-from">
        		<?=bpv_format_currency($cruise_price_from['price_from'])?>
        		<small style="font-size: 12px; color: #333"><?=lang('/pax')?></small>
        	</span>
        
        <?php endif;?>
        </div>
        <div class="col-xs-6">
            
            <?php 
				$call_us = load_bpv_call_us_number(CRUISE);
			?>
			
			<?php if(!empty($call_us)):?>
		    	<a class="btn-call pull-right" href="tel:<?=$call_us?>">
            		<i class="glyphicon glyphicon-earphone"></i> <span><?=$call_us?></span>
            	</a>
	        <?php endif;?>
            
        </div>
    </div>
    
    <!-- Promotion from the Cruise -->
    <?php if (!empty($cruise_promotions)):?>
    	<?php foreach ($cruise_promotions as $pro):?>
    		<div class="margin-bottom-10 bpv-pro">
    			<?=load_promotion_tooltip($pro,'','left', true)?>
    			<i class="icon icon-arrow-right-gray"></i>
    		</div>
    	<?php endforeach;?>	
    <?php endif;?>
    
    <!-- Promotion from Best Price -->
    <?php if (!empty($bpv_promotions)):?>
    	<?php foreach ($bpv_promotions as $bpv_pro):?>
    		<div class="margin-bottom-10 bpv-pro">
    			<?=load_marketing_pro_tooltip($bpv_pro, $cruise['id'], 'left', true)?>
    			<i class="icon icon-arrow-right-gray"></i>
    		</div>
    	<?php endforeach;?>
    <?php endif;?>
</div>