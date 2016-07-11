
<?php $is_show_filter = $filter_results['cruise_cabin'] > 0
	|| count($filter_results['cruise_properties']) > 0 
	|| count($filter_results['sub_des']) > 0
	|| $filter_results['tour_duration'] > 0
	|| count($filter_results['tour_types']) > 0
	|| count($filter_results['tour_activities']) > 0;
?>

<div class="search_message highlight">
  	<?='<b>'.$total.'</b>'.($total > 1 ? ' '.lang('label_tours') : ' '.lang('label_tour'))?>
  	<?=lang_arg('label_search_results_summary', $search_criteria['destinations'], date('d M Y', strtotime($search_criteria['departure_date'])))?> 	
	<?php if ($is_show_filter):?>
	<?=lang('label_match_following_filters')?>	
	<?php endif;?>
</div>

<?php if($is_show_filter):?>

<div class="clear_filter">
	<ul id="clear_filter">
		
		<?php if($filter_results['cruise_cabin'] != '' && $filter_results['cruise_cabin'] != 0):?>
			
			<li style="float:left;margin-right:10px" id="filter_cruise_cabin_<?=$filter_results['cruise_cabin']?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				<?=translate_text($cruise_cabins[$filter_results['cruise_cabin']])?>				
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('cruise_cabin_<?=$filter_results['cruise_cabin']?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endif;?>
		
	
		<?php foreach ($filter_results['cruise_properties'] as $value):?>
			
			<li style="float:left;margin-right:10px" id="filter_cruise_properties_<?=$value?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				
				<?php if($value != -1):?>
				
					<?php 
					
						foreach ($cruise_properties as $facility){
							
							if ($facility['id'] == $value){
								
								echo $facility['name']; break;
								
							}
							
						}
					
					?>		
				
				<?php else:?>
					
					<?=lang('has_tripple_family_cabin')?>
					
				<?php endif;?>	
								
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('cruise_properties_<?=$value?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endforeach;?>
		
		
		<?php foreach ($filter_results['sub_des'] as $value):?>
			
			<li style="float:left;margin-right:10px" id="filter_sub_des_<?=$value?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				
				<?php 
					
					foreach ($search_destination['sub_des'] as $des){
						
						if ($des['id'] == $value){
							
							echo $des['name']; break;
							
						}
						
					}
				
				?>
								
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('sub_des_<?=$value?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endforeach;?>
		
		<?php foreach ($filter_results['tour_activities'] as $value):?>
			
			<li style="float:left;margin-right:10px" id="filter_tour_activity_<?=$value?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				
				<?php 
					
					foreach ($tour_activities as $activity){
						
						if ($activity['id'] == $value){
							
							echo $activity['name']; break;
							
						}
						
					}
				
				?>
								
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('tour_activity_<?=$value?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endforeach;?>
		
		
		<?php if($filter_results['tour_duration'] != '' && $filter_results['tour_duration'] != '0'):?>
			
			<li style="float:left;margin-right:10px" id="filter_tour_duration_<?=$filter_results['tour_duration']?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				<?=translate_text($tour_durations[$filter_results['tour_duration']])?>				
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('tour_duration_<?=$filter_results['tour_duration']?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endif;?>
		
		
		<?php foreach ($filter_results['tour_types'] as $value):?>
			
			<li style="float:left;margin-right:10px" id="filter_tour_types_<?=$value?>">
				<img src="<?=get_static_resources('/media/green_check_14.png')?>" style="margin-bottom:-3px;margin-right:2px">
				<?=translate_text($tour_types[$value])?>				
				<a style="text-decoration:underline;" href="javascript:void(0)" onclick="filter_clear('tour_types_<?=$value?>')"><?=lang("clear")?></a>
			</li>
		
		<?php endforeach;?>
		
	</ul>
</div>

<?php endif;?>

<?php if ($total == 0):?>
<div class="bpt_item item_radius">
	<div class="item_header"></div>
	<div style="color: red; font-size: 20px; padding: 20px;"><?=lang('label_search_not_found')?></div>
</div>
<?php endif;?>

<?php if(isset($tours)) :?>
	
<div id="sort_by" class="margin_top_10">
	<ul class="item_radius">
		<li style="background-color:#FEBA02">
			<strong><?=lang('sort_by')?>:</strong>
		</li>
		<?php if($search_criteria['sort_by'] == 'best_deals'):?>
			<li class="selected recommend">
				<span><?=lang('recommend')?></span>
			</li>
		<?php else :?>
			<li class="recommend">
				<a href="javascript:sort_By('best_deals');"><?=lang('recommend')?></a>
			</li>
		<?php endif;?>
		
		<?php if($search_criteria['sort_by'] == 'price_low_high'):?>
			<li class="selected sort_price">
				<span><?=lang('price_low_high')?></span>
			</li>
		<?php else :?>
			<li class="sort_price">
				<a href="javascript:sort_By('price_low_high');"><?=lang('price_low_high')?></a>
			</li>
		<?php endif;?>
		
		<?php if($search_criteria['sort_by'] == 'price_high_low'):?>
			<li class="selected sort_price">
				<span><?=lang('price_high_low')?></span>
			</li>
		<?php else :?>
			<li class="sort_price">
				<a href="javascript:sort_By('price_high_low');"><?=lang('price_high_low')?></a>
			</li>
		<?php endif;?>
		
		<?php if($search_criteria['sort_by'] == 'num_good_reviews'):?>
			<li class="selected sort_review">
				<span><?=lang('review_score')?></span>
			</li>
		<?php else :?>
			<li class="sort_review">
				<a href="javascript:sort_By('num_good_reviews');"><?=lang('review_score')?></a>
			</li>
		<?php endif;?>
		
		
	</ul>
</div>




	<?php foreach ($tours as $key=>$tour):?>
	
	<?php 
		$odd = "";
		$last = "";
		
		if ($key%2 == 1) $odd = " odd";
		
		if ($key == count($tours) - 1) $last = " last";
	?>
		
	<div class="bpt_item item_radius<?=$last?>">
		<div class="item_header"></div>
		<div class="area_left" <?php if(isset($tour['most_rec_service'])):?> style="padding-bottom: 0"<?php endif;?>>			
			
			<div class="bpt_item_name">
				<a title="<?=$tour['name']?>" href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><?=$tour['name']?></a>
				<?=by_partner($tour)?>
			</div>
			
			<div class="img_area">
				<div class="bpt_item_image">			
					<img width="135" height="90" alt="<?=$tour['name']?>" title="<?=$tour['name']?>" src="<?=$this->config->item('tour_135_90_path') . $tour['picture_name']?>"/>				 
				</div>
								
				<div class="btn_general btn_book_together btn_overview" onclick="see_tour_overview(<?=$tour['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
				
			</div>
			
			<div class="item_content">
				<?php if($tour['category_id'] == 2 || $tour['category_id'] == 3):?>
				<div class="row">
					<div class="col_label">
						<span><?=lang('cruise_ship')?>:</span>
					</div>
					<div class="col_content">
						<a href="<?=url_builder(CRUISE_DETAIL, url_title($tour['cruise_url_title']), true)?>"><?=$tour['cruise_name']?></a>
						<?php $star_infor = get_star_infor_tour($tour['star'], 0);?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($tour['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
					</div>
				</div>
				<?php endif;?>
				
				<div class="row">
					<div class="col_label">
						<?=lang('cruise_destinations')?>:
					</div>
					<div class="col_content destination">
						<?=$tour['route']?>
					</div>
				</div>
				
				<?php if ($tour['review_number'] > 0):?>	
					<div class="row">
						<div class="col_label">
							<?=lang('reviewscore')?>:
						</div>
						<div class="col_content">
							<?=get_full_review_text($tour)?>
						</div>
					</div>
				<?php endif;?>
				 
				<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
				
				<?php 
					$deal_info = $tour['price']['deal_info'];
				?>
				
				<div class="row">
					<div class="special col_label">
						<?php if($deal_info['is_hot_deals']):?>
							<?=lang('special_offers')?>:
						<?php else:?>
							<?=lang('offers')?>:
						<?php endif;?>					
					</div>
					
					<div class="col_content special">
						<ul class="offer_lst" style="font-size: 11px; line-height: 1.3em">
						<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>
						<?php if ($item != '') :?>
							<li><a class="special" href="javascript:void(0)" id="promotion_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$item?> &raquo;</a></li>
						<?php endif;?>	
						<?php endforeach;?>
						</ul>
					</div>
				</div>
				<?php endif;?>
				
			
				<div class="row description">
					<?=character_limiter(strip_tags($tour['brief_description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
				</div>
				
				<?php if(isset($tour['most_rec_service']) && $tour['most_rec_service'] !== FALSE):?>
				 
				<div class="most_recommended_service">
					
					<div class="header">
						
						<?php 
							$pro_text = $tour['most_rec_service']['promotion_text'];
						?>
						
						<?=lang('save_up_to')?> <span style="font-size: 16px;"><?=number_format($tour['most_rec_service']['discount'], CURRENCY_DECIMAL)?></span>
						<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>
							<?=lang('usd_room_night')?>
						<?php else:?>
							<?=lang('usd_pax')?>
						<?php endif;?>
						
						<?php if(!empty($pro_text)):?>
							- <?=$pro_text?>
						<?php endif;?>
						
					</div>
					
					<div class="content">
						
						<div class="col_1">
							
							<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>							
								<img style="float: left; position: relative; margin-right: 10px;" alt="" src="<?=$this->config->item('hotel_80_60_path') . $tour['most_rec_service']['picture']?>">							
							<?php else:?>
								<img style="float: left; position: relative; margin-right: 10px;" alt="" src="<?=$this->config->item('tour_80_60_path') . $tour['most_rec_service']['picture_name']?>">
							<?php endif;?>
							
							<div class="service_name">
															
																
								<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>
							
									<a href="<?=url_builder(HOTEL_DETAIL, $tour['most_rec_service']['url_title'], true)?>" target="_blank"><?=$tour['most_rec_service']['name']?></a>
									
									<?php 
										$star_infor = get_star_infor($tour['most_rec_service']['star'], 0);
									?>
									<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
									
									<?php if($tour['most_rec_service']['is_new']):?>
										<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
									<?php endif;?>
										
								<?php else:?>
									
									<a href="<?=url_builder(TOUR_DETAIL, $tour['most_rec_service']['url_title'], true)?>" target="_blank"><?=$tour['most_rec_service']['name']?></a>
									
								<?php endif;?>
									
														
							</div>
					
							
							<div class="location">
								<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>
									<?=$tour['most_rec_service']['location']?>
									&nbsp;
									<span><a href="<?=url_builder(HOTEL_DETAIL, $tour['most_rec_service']['url_title'], true)?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
								<?php else:?>
									<?=$tour['most_rec_service']['route']?>
									&nbsp;
									<span><a href="<?=url_builder(TOUR_DETAIL, $tour['most_rec_service']['url_title'], true)?>" target="_blank" class="link_function"><?=lang('see_details')?></a></span>
								<?php endif;?>
							
							</div>
							
							
							<div class="reviews">
								
								<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>
									<?=get_full_hotel_review_text($tour['most_rec_service'], FALSE)?>
								<?php else:?>
									<?=get_full_review_text($tour['most_rec_service'], false)?>
								<?php endif;?>
						
							</div>
							
							
							<div class="service_desc">
								
								<?php if($tour['most_rec_service']['service_type'] == HOTEL):?>
									
									<?=character_limiter(strip_tags($tour['most_rec_service']['description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
									
								<?php else:?>
								
									<?=character_limiter(strip_tags($tour['most_rec_service']['brief_description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
									
								<?php endif;?>
						
							</div>
							
							<div class="row" style="margin-top: 7px;">
									<a onclick="see_more_deals(<?=$tour['id']?>, '<?=$search_criteria['departure_date']?>')" style="text-decoration:underline;font-weight:bold;" class="tip_text" href="javascript:void(0)"><?=lang('label_see_more_deals')?> &raquo;</a>
							</div>
						</div>
						
						<div class="col_2">
								<?php 
									$is_per_rn = $tour['most_rec_service']['service_type'] == HOTEL;
									
									$dc_unit = $is_per_rn ? lang('per_room_night') : lang('per_pax');
								?>
								<div class="bt_price_row">
									<span class="bt_price_text"><?=lang('book_separatly')?>:</span>
																		
									<span style="float: right;"><?=CURRENCY_SYMBOL. number_format($tour['most_rec_service']['price_separatly'], CURRENCY_DECIMAL)?><span class="dc_unit"><?=$dc_unit?></span></span>
									
								</div>											
								
								<div class="bt_price_row" style="margin-top: 5px;">
									<span class="bt_price_text"><?=lang('book_together_and_save')?>:</span>
																		
									<span class="bt_price special">-<?=CURRENCY_SYMBOL. number_format($tour['most_rec_service']['discount'], CURRENCY_DECIMAL)?><span class="dc_unit"><?=$dc_unit?></span></span>
								</div>			
														
								<div class="seperate_line"></div>
								
								<div class="bt_price_row" style="margin-top: 5px;">
									<span class="bt_price_text" style="font-weight: bold;"><?=lang('price_now')?>:</span>
									
									<span class="price_total bt_price"><?=CURRENCY_SYMBOL. number_format($tour['most_rec_service']['price_separatly'] - $tour['most_rec_service']['discount'], CURRENCY_DECIMAL)?><span class="dc_unit"><?=$dc_unit?></span></span>
								</div>
							
								<div class="bt_price_row" style="margin-top: 5px;">
									
									<?php if($is_per_rn):?>
										<span class="unit_text"><?=lang('price_per_room_night')?></span>
									<?php else:?>
										<span class="unit_text"><?=lang('price_per_pax')?></span>
									<?php endif;?>
								</div>
								
								
								<?php
									$mode = $tour['most_rec_service']['service_type'] == HOTEL ? 1 : 2;
									
									$bt_url_1 = $tour['url_title'];
										
									$bt_url_2 = $tour['most_rec_service']['url_title'];
								?>
								
								<div style="margin-top: 15px;" onclick="click_book_together('<?=$bt_url_1?>','<?=$bt_url_2?>', <?=$mode?>)" class="btn_general btn_book_together" id="hotel_157_button_book"><?=lang('label_book_together')?></div>
								
						
						</div>
						
					</div>
				
				</div>
				
				<?php endif;?>
					
			</div>
			
		</div>
		<div class="area_right" <?php if(isset($tour['most_rec_service'])):?> style="padding-bottom: 0"<?php endif;?>>			
			<div class="bpt_item_price">
				<?php $price_view = get_tour_price_view($tour); ?>
				<ul>
					<?php if($price_view['f_price'] > 0):?>
						
						<li class="from"><?=lang('bt_from')?></li>
						<li>
							<?php if($price_view['d_price'] > 0):?>
				        	<span class="b_discount"><?=CURRENCY_SYMBOL?><?=$price_view['d_price']?></span>
				        	<?php endif;?>
				        	<span class="price_from"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span> <?=lang('per_pax')?>
						</li>
					<?php else:?>
						
						<li><span class="price_from"><?=lang('na')?></span></li>
					<?php endif;?>
				</ul>
			</div>
			
			<div class="clearfix"></div>
			
			<div style="margin-top:5px;clear:both;">
				<span class="icon icon-what-included"></span>
				<a href="javascript:void(0)" style="font-size:11px;font-weight:bold;" id="what_included_<?=$tour['id']?>"><?=lang('what_included')?> &raquo;</a>
			</div>
			
			<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')">
			<?php if($tour['cruise_id'] >0):?>
				<?=lang('select_cruise')?>
			<?php else:?>
				<?=lang('select_tour')?>
			<?php endif;?>
			</div>			
		</div>
					
	</div>
	<?php endforeach;?>

<div id="contentMainFooter" class="item_radius">
	<div class="paging_text"><?=$paging_text?>&nbsp;<?=lang('tours')?></div>
    <div id="ajax_paging" class="paging_link"><?=$this->pagination->create_links();?></div>
</div>
<?php endif;?>


<script type="text/javascript">
	
	$(document).ready(function(){
		<?php if(!empty($tours)):?>
		<?php foreach ($tours as $key=>$tour):?>

		<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
		
			<?php 
				$deal_info = $tour['price']['deal_info'];
			?>

			<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>

				var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
				
				var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';

				$("#promotion_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
					
			<?php endforeach;?>

		<?php endif;?>	


			var dg_content = '<?=get_excludes_text($tour['includes'], $tour['excludes'])?>';
			
			var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($tour['name'], ENT_QUOTES)?>:</span>';
	
			$("#what_included_<?=$tour['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
		
		<?php endforeach;?>
		<?php endif;?>
	});
</script>
