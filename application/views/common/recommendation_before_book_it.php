
<div id="booking_together_section" style="float: left; width: 100%;">

<?php if(count($recommendations) > 0):?>

	<h1 class="highlight">
		  
		<span class="icon icon-saving" style="margin-bottom: -13px; margin-right: 3px;"></span>
		<?php if(isset($selected_service_name)):?>
			<?=lang('label_book_with')?> '<?=$selected_service_name?>'<span class="special"> - <?=lang('more_savings')?></span>
		<?php else:?>		
			<?=lang('trip_saving_together')?>
		<?php endif;?>
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
		
		<h2 class="highlight" style="padding-left: 0;" id="block_recommendation_<?=$block_id?>">
			<?php if($recommendation['service_id'] == HOTEL):?>
				<span class="icon icon-hotel-organe"></span>
			<?php elseif($recommendation['service_id'] == TOUR):?>
				<span class="icon icon-tours-organe"></span>
			<?php else:?>
				<span class="icon icon-cruise-organe"></span>
			<?php endif;?>
			<a show="show" href="javascript:void(0)" onclick="show_block(this, '<?=$block_id?>')" style="text-decoration: underline;">
				<?=$recommendation['name']?>
			</a>
			&nbsp;&nbsp;<span style="font-weight:normal" class="special"><?=lang('together')?></span>&nbsp;&nbsp;
			<?php if(isset($hotel)):?>
				<?=$hotel['name']?>
			<?php elseif(isset($tour)):?>					 	
				<?=$tour['name']?>
			<?php elseif(isset($selected_service_name)):?>
				<?=$selected_service_name?>
			<?php endif;?>
			
		</h2>
		
		
		<div id="block_search_content_<?=$block_id?>">
		
		<?php foreach ($recommendation['services'] as $key=>$service):?>
			
			<?php 
				$is_last = $key == (count($recommendation['services']) - 1);
				
				$obj_id = $recommendation['service_id'] == HOTEL ? 'hotel_': 'tour_';
				
				$obj_id = $obj_id. $service['id'];
				
				$mode = $recommendation['service_id'] == HOTEL? 1 : 2;
				
				if ($parent_id == -2){ // from hotel-detail
					$mode = 1;
				}
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
						
						<?php if ($recommendation['service_id'] == HOTEL):?>
							
							<a href="<?=url_builder(HOTEL_DETAIL, $service['url_title'], true)?>" target="_blank"><?=$service['name']?></a>
								
						<?php else:?>
							
							<a href="<?=url_builder(TOUR_DETAIL, $service['url_title'], true)?>" target="_blank"><?=$service['name']?></a>
							
						<?php endif;?>
						
					
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
							<span>
							<a href="<?=url_builder(HOTEL_DETAIL, $service['url_title'], true)?>" target="_blank" class="link_function">
								<?=lang('see_details')?>
							</a>
							</span>
						<?php else:?>
							<?=$service['route']?>
							&nbsp;
							<span>
								<a href="<?=url_builder(TOUR_DETAIL, $service['url_title'], true)?>" target="_blank" class="link_function">
								<?=lang('see_details')?>
								</a>
							</span>
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
							
				        	
						</div>
					
					</div>
					
					<div class="row" style="margin-top: 10px;">
						
						<?php 
							if ($parent_id == -2){
								
								$bt_url_1 = $service['url_title'];
								
								$bt_url_2 = $current_item_info['url_title'];
								
							} else {
								
								$bt_url_1 = $current_item_info['url_title'];
								
								$bt_url_2 = $service['url_title'];							
								
							}
						?>
									
						<div id="<?=$obj_id.'_button_book'?>" class="btn_general btn_book_together btn_compact" onclick="click_book_together('<?=$bt_url_1?>','<?=$bt_url_2?>', <?=$mode?>)"><?=lang('book_together')?></div>
					
					</div>	
				</div>
				
			</div>
			
		<?php endforeach;?>
		
		</div>
		
		<div id="show_more_<?=$block_id?>" class="more_tour" style="padding-bottom: 10px;">
			
			<span class="arrow">&rsaquo;</span><a href="javascript: void(0)" class="link_function" onclick="search_more('<?=$block_id?>')"><?=lang('more')?> <?=$recommendation['name']?></a>
			
			<?php 
				$form_action = $recommendation['service_id'] == HOTEL ? "/hotel_search_ajax/" : "/tour_search_ajax/";
			?>
			
			<form id="form_<?=$block_id?>" name="form_<?=$block_id?>" method="POST" action="<?=$form_action?>">
				
				<input type="hidden" name="parent_id" value="<?=$parent_id?>">
				
				<input type="hidden" name="destination_id" value="<?=$recommendation['destination_id']?>">
				
				<input type="hidden" name="service_type" value="<?=$recommendation['service_id']?>">
				
				<?php if($parent_id == -2):?>
					<input type="hidden" name="start_date" value="<?=$search_criteria['arrival_date']?>">
				<?php else:?>
					<input type="hidden" name="start_date" value="<?=$search_criteria['departure_date']?>">
				<?php endif;?>
				
				<input type="hidden" name="block_id" value="<?=$block_id?>">
				
				<input type="hidden" name="current_service_id" value="<?=$current_item_info['service_id']?>">
				
				<input type="hidden" name="current_service_type" value="<?=$current_item_info['service_type']?>">
				
				<input type="hidden" name="current_service_url_title" value="<?=$current_item_info['url_title']?>">
				
				<input type="hidden" name="current_service_normal_discount" value="<?=$current_item_info['normal_discount']?>">
				
				<input type="hidden" name="current_service_is_main_service" value="<?=$current_item_info['is_main_service']?>">
				
				<input type="hidden" name="current_service_destination_id" value="<?=$current_item_info['destination_id']?>">
				
				<input type="hidden" name="current_service_is_booked_it" value="<?=$current_item_info['is_booked_it']?>">
			
			</form>
			
			
		</div>
			
	</div>
	
	<?php endforeach;?>

</div>
