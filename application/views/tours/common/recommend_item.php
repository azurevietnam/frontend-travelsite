<div class="most-recommended-service clearfix">
	
	<div class="header">
		<?php 
			$pro_text = $most_rec_service['promotion_text'];
		?>
		
		<?=lang('save_up_to')?> <span style="font-size: 16px;"><?=number_format($most_rec_service['discount'], CURRENCY_DECIMAL)?></span>
		<?php if($most_rec_service['service_type'] == HOTEL):?>
			<?=lang('usd_room_night')?>
		<?php else:?>
			<?=lang('usd_pax')?>
		<?php endif;?>
		
		<?php if(!empty($pro_text)):?>
			- <?=$pro_text?>
		<?php endif;?>
		
	</div>
	
	<div class="row">		
		<div class="col-service-cnt">
			<?php 
				$img_path = ($most_rec_service['service_type'] == HOTEL) ? PHOTO_FOLDER_HOTEL : PHOTO_FOLDER_TOUR;
			?>
			<?php if($most_rec_service['service_type'] == HOTEL):?>							
				<img alt="" src="<?=get_image_path($img_path, $most_rec_service['picture'], '120_90')?>">							
			<?php else:?>
				<img alt="" src="<?=get_image_path($img_path, $most_rec_service['picture_name'], '120_90')?>">
			<?php endif;?>	
			
			<div class="service-name margin-bottom-5">
				
				<?php if($most_rec_service['service_type'] == HOTEL):?>
			
					<a href="<?=get_page_url(HOTEL_DETAIL_PAGE, $most_rec_service)?>" target="_blank"><?=$most_rec_service['name']?></a>
					
					<?php 
						$star_css = get_icon_star($most_rec_service['star']);
					?>
					<span class="icon <?=$star_css?>"></span>
					
					<?php if($most_rec_service['is_new']):?>
						<span class="special text-special" style="font-weight: normal;"><?=lang('obj_new')?></span>
					<?php endif;?>
						
				<?php else:?>
					
					<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $most_rec_service)?>" target="_blank"><?=$most_rec_service['name']?></a>
					
				<?php endif;?>
					
										
			</div>
	
			
			<div class="location text-unhighlight margin-bottom-5">
				<?php if($most_rec_service['service_type'] == HOTEL):?>
					<?=$most_rec_service['location']?>
					&nbsp;
					<span><a href="<?=url_builder(HOTEL_DETAIL, $most_rec_service['url_title'], true)?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
				<?php else:?>
					<?=$most_rec_service['route']?>
					&nbsp;
					<span><a href="<?=url_builder(TOUR_DETAIL, $most_rec_service['url_title'], true)?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
				<?php endif;?>
			
			</div>
			
			
			<div class="reviews text-unhighlight margin-bottom-5">
				
				<?php if($most_rec_service['service_type'] == HOTEL):?>
					<?=get_full_hotel_review_text($most_rec_service, FALSE)?>
				<?php else:?>
					<?=get_full_review_text($most_rec_service, false)?>
				<?php endif;?>
		
			</div>
			
			
			<div class="service-desc text-unhighlight">
				
				<?php if($most_rec_service['service_type'] == HOTEL):?>
					
					<?=character_limiter(strip_tags($most_rec_service['description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
					
				<?php else:?>
				
					<?=character_limiter(strip_tags($most_rec_service['brief_description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
					
				<?php endif;?>
		
			</div>
			
			<div class="margin-top-10">
				<a onclick="see_more_deals(<?=$tour['id']?>, '<?=htmlentities($tour['name'])?>', '<?=$search_criteria['departure_date']?>')" style="text-decoration:underline;font-weight:bold;" href="javascript:void(0)"><?=lang('label_see_more_deals')?> &raquo;</a>
			</div>
		</div>
		
		<div class="col-service-price">
				<?php 
					$is_per_rn = $most_rec_service['service_type'] == HOTEL;
					
					$dc_unit = $is_per_rn ? lang('per_room_night') : lang('per_pax');
				?>
				<div class="row margin-bottom-5">
					<div class="col-xs-7 text-unhighlight"><?=lang('book_separatly')?>:</div>
														
					<div class="col-xs-5 text-right" style="font-size:12px"><?=show_usd_price($most_rec_service['price_separatly'])?><span class="dc-unit"><?=$dc_unit?></span></div>
					
				</div>											
				
				<div class="row margin-bottom-5">
					<div class="col-xs-7 text-unhighlight"><?=lang('book_together_and_save')?>:</div>
														
					<div class="col-xs-5 bt-price text-special text-right">-<?=show_usd_price($most_rec_service['discount'])?><span class="dc-unit"><?=$dc_unit?></span></div>
				</div>			
										
				<div class="seperate-line margin-bottom-5"></div>
				
				<div class="row margin-bottom-5">
					<div class="col-xs-7 text-unhighlight"><b><?=lang('price_now')?>:</b></div>
					
					<div class="col-xs-5 bt-price text-price text-right"><?=show_usd_price($most_rec_service['price_separatly'] - $most_rec_service['discount'])?><span class="dc-unit"><?=$dc_unit?></span></div>
				</div>
			
				<div class="text-right text-unhighlight margin-bottom-10">
					
					<?php if($is_per_rn):?>
						<span><?=lang('price_per_room_night')?></span>
					<?php else:?>
						<span><?=lang('price_per_pax')?></span>
					<?php endif;?>
				</div>
				
				<div class="text-right">
				<?php
					$mode = $most_rec_service['service_type'] == HOTEL ? 1 : 2;
					
					$bt_url_1 = $tour['url_title'];
						
					$bt_url_2 = $most_rec_service['url_title'];
				?>
				
				<div class="btn btn-green btn-sm" onclick="click_book_together('<?=$bt_url_1?>','<?=$bt_url_2?>', <?=$mode?>)" id="hotel_157_button_book"><?=lang('label_book_together')?></div>
				
				</div>
		</div>
		
	</div>
					
</div>
