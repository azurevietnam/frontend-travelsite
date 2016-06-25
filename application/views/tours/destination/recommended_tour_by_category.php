<?php foreach($categories as $cat):?>
	<?php if(!empty($cat['tours'])):?>
	<div class="margin-top-20">
		<h2>
			<img src="<?=get_static_resources('images/categories/'.$cat['picture'])?>" width="35" height="35"/>
			
			<?=$cat['name']?>
			
			<?php if($cat['is_hot'] == 1):?>
				<img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
			<?php endif;?>
			
		</h2>
		
		<?=$cat['description']?>
		
		<div class="row bpv-popular-tour">
			
			<?php foreach($cat['tours'] as $tour):?>
			
			<div class="col-xs-4">
			    <div class="item">
					
					<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
						<img src="<?=get_image_path(TOUR, $tour['picture'], '416x312')?>" class="img-responsive">
					</a>
	
					<?php 
						$deal_offer = get_tour_pro_value($tour);
					?>
					<?php if(!empty($deal_offer)):?>
						<div class="deal-offer"><?=$deal_offer?><div class="deal-arrow"></div></div>
					<?php endif;?>
					
					<div class="margin-top-10 item-name">
						<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>"><?=$tour['name']?></a>
					</div>
					
					<?php if(!empty($tour['promotions'])):?>
						<?php foreach ($tour['promotions'] as $pro):?>
							<div class="margin-bottom-10">
								<?=load_promotion_tooltip($pro, $tour['id'])?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
					
					<?php if(!empty($tour['bpv_promotions'])):?>
            			<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
            				<div class="margin-bottom-10">
            					<?=load_marketing_pro_tooltip($bpv_pro, $tour['id'])?>
            				</div>
            			<?php endforeach;?>
            		<?php endif;?>
					
					<div class="clearfix">
						<b><?=lang('lbl_tour_route')?></b><?=$tour['route']?>
					</div>
					
					<div class="clearfix">
						<?=lang('lbl_duration_short')?><span class="bpv-color-marketing"><?=get_duration_text($tour)?></span>
					</div>
					
					<div class="clearfix full-width">
					    <?php if(!empty($tour['price_origin'])):?>
		                    <?php if($tour['price_origin'] != $tour['price_from']):?>
		                    	<span class="bpv-price-origin"><?=bpv_format_currency($tour['price_origin'])?></span>
		                    <?php endif;?>
		                    <span class="bpv-price-from"><?=bpv_format_currency($tour['price_from'])?></span>
		                    
		                    <a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" class="btn btn-bpv btn-book-now pull-right"> 
			               		<?=lang('btn_book_now')?>
			                </a>
		                    
	                    <?php else:?>
	                    	 <?php 
			    				$params = get_tour_contact_params($tour, $search_criteria);
			    			?>
	                    
		                    <a href="<?=get_url(CONTACT_US_PAGE, $params)?>" class="btn btn-bpv btn-book-now btn-sm pull-right">
			    				<?=lang('contact_for_price')?>
			    			</a>
			            <?php endif;?>
			            
					</div>
		
					 
		        </div>
			</div>
			
			<?php endforeach;?>
			
		</div>
		
		<div class="margin-top-10 text-right">
			<span class="bpv-color-promotion glyphicon glyphicon-chevron-right"></span><a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>"> <?=lang('more_tours_category')?> <?=$cat['name']?></a>
		</div>
	</div>
	
<?php endif;?>
<?php endforeach;?>
