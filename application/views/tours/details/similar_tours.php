<?php if(!empty($s_tours)):?>
<div class="container-fluid margin-top-20 bpv-popular-tour popular-bg bpv-similar-tour">
    <div class="container no-padding">
        <div class="col-xs-12 margin-bottom-10">
            <h2 class="bpv-color-title"><?=lang('similar_tours')?></h2>
        </div>
    
        <?php foreach ($s_tours as $tour):?>
        
        <div class="col-xs-3">
            <div class="item">
        		<div style="position: relative;">
        			<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
        				<img src="<?=get_image_path(TOUR, $tour['picture'],'416x312')?>" class="img-responsive">
        			</a>
        
        			<?php 
        				$deal_offer = get_tour_pro_value($tour);
        			?>
        			<?php if(!empty($deal_offer)):?>
        				<div class="deal-offer"><?=$deal_offer?><div class="deal-arrow"></div></div>
        			<?php endif;?>
        		</div>
        
        		<div class="item-details" style="margin-bottom: 0">
        
        			<div class="margin-bottom-10 item-name">
        				<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>"><?=$tour['name']?></a>
        			</div>
        			
        			<?php if(!empty($tour['promotions'])):?>
        				<?php foreach ($tour['promotions'] as $pro):?>
        					<div class="margin-bottom-10">
        						<?=load_promotion_tooltip($pro, $tour['id'])?>
        					</div>
        				<?php endforeach;?>
        			<?php endif;?>
        
        			<div class="clearfix" style="margin-bottom: 0">
        			    <?php if( isset($tour['price_from']) ):?>
            			    <?php if(!empty($tour['price_origin'])):?>
                            <?php if($tour['price_origin'] != $tour['price_from']):?>
                            	<span class="bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></span>
                            	<br>
                            <?php endif;?>						
                            <span class="bpv-price-from"><?=bpv_format_currency($tour['price_from'])?></span>
                            <?php endif;?>
                            
                            <a type="button" href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" class="btn btn-bpv btn-book-now pull-right"><?=lang('btn_book_now')?></a>
                        <?php else:?>
                			<?php 
                				$params = get_tour_contact_params($tour, $search_criteria);
                			?>
                			
                			<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
                				href="<?=get_url(CONTACT_US_PAGE, $params)?>">
                				<?=lang('contact_for_price')?>
                			</a>
                		<?php endif;?>
        			</div>
        
        		</div>
            </div>
        </div>
        
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>