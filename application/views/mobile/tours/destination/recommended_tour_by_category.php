<?php foreach($categories as $cat):?>
	<?php if(!empty($cat['tours'])):?>
	<div class="bpv-list">
		<h2>
			<img src="<?=get_static_resources('images/categories/'.$cat['picture'])?>" width="35" height="35"/>
			
			<?=$cat['name']?>
			
			<?php if($cat['is_hot'] == 1):?>
				<img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
			<?php endif;?>
		</h2>
			
			<?php foreach($cat['tours'] as $tour):?>
			
				<?php
			        $class_has_pro_off = ''; 
			        if ( isset($tour['price_from']) && $tour['price_origin'] != $tour['price_from'] && !empty($tour['promotions'])) {
			            $class_has_pro_off = ' has-pro-off';
			        }
			    ?>
			    <div class="bpv-item" onclick="go_url('<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>')" >
					<img class="pull-left" src="<?=get_image_path(TOUR, $tour['picture'],'160x120')?>">

			        <div class="item-name<?=$class_has_pro_off?>">
			        	<?=$tour['name']?><label class="bpv-color-marketing tour-duration">(<?=get_duration_text($tour)?>)</label>
			        </div>
			        
			        <?php if(!empty($tour['review_number'])):?>
			        <div class="item-review-lst">
			            <?=show_review($tour, get_url(TOUR_DETAIL_PAGE, $tour), false, true)?>
			        </div>
			        <?php endif;?>
			        
			        <?php if(!empty($tour['code'])):?>
						<div class="margin-bottom-5">
					        <?=lang('lbl_tour_code')?> <?=$tour['code']?>
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
			    
			            <?php $params = get_tour_contact_params($tour, $search_criteria);?>
			    			
			    		<a type="button" class="btn btn-bpv btn-book-now btn-sm col-xs-4 margin-top-5 pull-right margin-right-5" href="<?=get_url(CONTACT_US_PAGE, $params)?>">
			    			<?=lang('m_contact_for_price')?>
			    		</a>    
			        
			        <?php endif;?>
		        </div>
			
			
			<?php endforeach;?>
			
		
		<div class="col-xs-offset-1 col-xs-10 text-center clearfix margin-top-20 margin-bottom-20">
			<a class="view-more" href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>"> 
			<?=lang('more_tours_category')?> <?=$cat['name']?>
			 <i class="icon icon-chevron-right"></i>
			</a>
		</div>
	</div>
<?php endif;?>
<?php endforeach;?>
