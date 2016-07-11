<div id="booking_together_section" style="float: left; width: 100%;">
<?php if(count($recommendations) > 0):?>
	<h1 class="highlight">
		<span class="icon icon-saving" style="margin-bottom: -13px; margin-right: 3px;"></span>
		<?=lang('trip_saving_together')?>
	</h1>
	<div style="margin-top: 7px;padding-left:10px"><?=lang('group_service_desc')?></div>
<?php endif;?>

<?php foreach ($recommendations as $key => $recommendation) :?>
	<?php
		$block_id = $recommendation['service_id'] == HOTEL ? 'hotel_': 'tour_';
		$block_id = $recommendation['service_id'] == CRUISE ? 'cruise_': $block_id;
		$block_id = $block_id. $recommendation['destination_id'];
	?>
	<div class="recommendation_items">
		
		<h2 class="highlight" style="padding-left: 0">
			<?php if($recommendation['service_id'] == HOTEL):?>
				<span class="icon icon-hotel-organe"></span>
			<?php elseif($recommendation['service_id'] == TOUR):?>
				<span class="icon icon-tours-organe"></span>
			<?php else:?>
				<span class="icon icon-cruise-organe"></span>
			<?php endif;?>
			<a href="javascript:void(0)" show="show" onclick="show_block(this, '<?=$block_id?>')" style="text-decoration: underline;"><?=$recommendation['name']?></a>
		</h2>
		
		<div id="block_search_content_<?=$block_id?>">
		
		<?php foreach ($recommendation['services'] as $key=>$service):?>
			
			<?php 
				$is_last = $key == (count($recommendation['services']) - 1);
				
			?>
		
			<div class="item<?=$is_last ? ' item_last' : ''?>">
				
				<div class="item_img">
					<?php if ($recommendation['service_id'] == HOTEL):?>
						<img width="80" height="60" src="<?=$this->config->item('hotel_80_60_path').$service['picture']?>"></img>
					<?php else:?>
						<img width="80" height="60" src="<?=$this->config->item('tour_80_60_path').$service['picture_name']?>"/>
					<?php endif;?>
				</div>
				
				<div class="item_content">
					
					<div class="bpt_item_name item_name">
						
						<?php 
							if($recommendation['service_id'] == HOTEL){
								$item_url = url_builder(HOTEL_DETAIL, url_title($service['name']), true);
							} else {
								$item_url = url_builder(TOUR_DETAIL, url_title($service['name']), true);
							}
						?>
						
						<a href="<?=$item_url?>" target="_blank"><?=$service['name']?></a>
						
						
						<?php if($recommendation['service_id'] == HOTEL):?>
						
							<?php 
								$star_infor = get_star_infor($service['star'], 0);
							?>
							<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
							
							<?php if($service['is_new']):?>
								<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
							<?php endif;?>
						
						<?php endif;?>						
					</div>
					
					<div class="row item_address">
						<?php if ($recommendation['service_id'] == HOTEL):?>
							<?=$service['location']?>
							&nbsp;
							<span><a href="<?=$item_url?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
						<?php else:?>
							<?=$service['route']?>
							&nbsp;
							<span><a href="<?=$item_url?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
						<?php endif;?>
					</div>
					
					<div class="row item_review">
						<?php if ($recommendation['service_id'] == HOTEL):?>
							<?=get_full_hotel_review_text($service, FALSE)?>
						<?php else:?>
							<?=get_full_review_text($service, false)?>
						<?php endif;?>
					</div>
					
				</div>
				
				<div class="item_price_from">
					<div class="text_info"><?=lang('bt_from')?></div>
					
					<?php 
						$discount_price_info = $service['discount_price_info'];
					?>
					
					<?php if(!$discount_price_info['is_na']):?>
						
						<?php if($discount_price_info['list_price'] > 0):?>
							<?=CURRENCY_SYMBOL?><span class="b_discount"><?=number_format($discount_price_info['list_price'], CURRENCY_DECIMAL)?></span>
						<?php endif;?>
						
						<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['promotion_price'], CURRENCY_DECIMAL)?></span><?=$discount_price_info['price_from_unit']?>
						
					<?php else:?>
						<span class="price_total"><?=lang('na')?></span>
					<?php endif;?>
				        
				</div>
				
				<div class="item_price_discount">
					
					<div class="row">
						
						<div class="discount_value">
							
							<?php if($discount_price_info['discount_value'] > 0):?>
						        	
					        	<div class="text_info"><?=lang('bt_you_save')?></div>
					        	
					        	<?php if($discount_price_info['discount_value'] < SUPER_SAVE):?>
					        					        	
					       			<span class="price_total special">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?></span><span class="special"><?=$discount_price_info['discount_unit']?></span>			       			
				       			
					        	<?php else:?>
				       			
				       				<span class="price_total special">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?>*</span><span class="special"><?=$discount_price_info['discount_unit']?></span>
				       			
					        	<?php endif;?>
				       		
				       		<?php endif;?>
							
				        	<?php if($discount_price_info['discount_value'] == -1):?>
				        		<span class="special" style="font-size:16px;font-weight:bold"><?=lang('free_visa')?></span>
				        	<?php endif;?>
						</div>
					
					</div>
					
					<div class="row" style="margin-top: 10px;">				
						<div class="btn_general btn_book_together btn_compact" onclick="go_url('<?=$item_url?>')"><?=lang('book_together')?></div>
					</div>	
				</div>			
			</div>
		<?php endforeach;?>
		
		</div>
		
		<div class="more_tour" id="show_more_<?=$block_id?>" style="padding-bottom: 10px;">
			
			
			<?php 
				if($recommendation['service_id'] == HOTEL){
					$more_url = url_builder(MODULE_HOTELS, url_title($recommendation['url_title']));
				} else {
					$link = str_replace('Cruises', 'Tours', $recommendation['url_title']);
					$more_url = url_builder(MODULE_TOURS, url_title($link));
				}
			?>
			
			<span class="arrow">&rsaquo;</span><a href="<?=$more_url?>" class="link_function"><?=lang('lb_more')?> <?=$recommendation['name']?></a>
			
		</div>
	
	</div>
		
	<?php endforeach;?>
</div>	