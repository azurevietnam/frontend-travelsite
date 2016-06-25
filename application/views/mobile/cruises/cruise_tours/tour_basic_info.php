<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($tour_photos as $k => $photo):?>
		<li>
	        <?php if( !empty($photo['cruise_id'])): ?>
	            <img class="img-responsive" src="<?=get_image_path(CRUISE, $photo['name'],'400x300')?>" alt="<?=$photo['caption']?>">
			<?php else:?>
			    <img class="img-responsive" src="<?=get_image_path(CRUISE_TOUR, $photo['name'],'400x300')?>" alt="<?=$photo['caption']?>">
			<?php endif;?>
			
			<div class="flex-caption">
			     <?php if($k == 0):?>
    			    <h1 class="no-margin">
    			    <?=$tour['name']?>
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
    	<span class="pull-left margin-right-5"><?=lang('tour_route')?></span>
    	<?=$tour['route']?>
    </div>
     <div class="row margin-top-10 margin-bottom-10">
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
</div>
