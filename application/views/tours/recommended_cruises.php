<?php if(isset($recommended_cruises['luxury_cruises'])):?>

<div style="float: left; width: 100%;">

<?php if(count($tour_hot_deals) > 0):?>
	<h2 class="highlight">
	<span class="icon recommend_icon"></span><?=lang('label_recommended_halong_bay_cruises')?>
	</h2>
<?php endif;?>

<div id="tabs">	
	<ul class="bpt-tabs">
		<?php if(count($recommended_cruises['luxury_cruises']) > 0):?>																				
			<li><a href="javascript:void(0)" data-name="#luxury_cruises"><?=lang('luxury_cruises')?></a></li>
		<?php endif;?>
		
		<?php if(count($recommended_cruises['deluxe_cruises']) > 0):?>		
		<li><a href="javascript:void(0)" data-name="#deluxe_cruises"><?=lang('deluxe_cruises')?></a></li>
		<?php endif;?>
		
		<?php if(count($recommended_cruises['cheap_cruises']) > 0):?>		
		<li><a href="javascript:void(0)" data-name="#cheap_cruises"><?=lang('cheap_cruises')?></a></li>			
		<?php endif;?>
		
		<?php if(count($recommended_cruises['charter_cruises']) > 0):?>
		<li><a href="javascript:void(0)" data-name="#charter_cruises"><?=lang('charter_cruises')?></a></li>
		<?php endif;?>	
		
		<?php if(count($recommended_cruises['day_cruises']) > 0):?>
		<li><a href="javascript:void(0)" data-name="#day_cruises"><?=lang('day_cruises')?></a></li>
		<?php endif;?>
	</ul>	
	
	<?php if(count($recommended_cruises['luxury_cruises']) > 0):?>	
	<div id="luxury_cruises">
		<?php foreach ($recommended_cruises['luxury_cruises'] as $key => $cruise) :?>
		
			<?php 
				$odd = "";
				$last = "";
				
				if ($key%2 == 1) $odd = "";
				
				if ($key == count($recommended_cruises['luxury_cruises']) - 1) $last = " last";
			?>
				
			<div class="bpt_item item_radius">
				
				<div class="item_header"></div>
				
				<div class="area_left">
					
					<div class="img_area">
					
						<div class="bpt_item_image">
							<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
						</div>
						
						<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
					</div>
					
					<div class="bpt_item_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_infor = get_star_infor($cruise['star'], 0);
						?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
											
						<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
					</div>
					
					<div class="row">
						
						<div class="col_label">
							<span><?=lang('cruise_type')?>:</span>
						</div>
						
						<div class="col_content">
							<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
						</div>
						
					</div>
				
					
					<?php if($cruise['num_reviews'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_cruise_review_text($cruise, true)?>
							</div>
						</div>
					<?php endif;?>
				
					<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
						
						<div class="row">
							<div class="col_label special">
								<?=lang('special_offers')?>:
							</div>
							
							<div class="col_content">
							
								<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
									
									<?php if($k > 0):?><br><?php endif;?>
																
									<a class="special" id="lux_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
								
								<?php endforeach;?>
							</div>
						</div>
						
					<?php endif;?>
					
					 
					<div class="row description">
						<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
				
				<div class="area_right">
					
					<?php if(!empty($cruise['includes'])):?>
					
					<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
						<ul>							
							<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>"><?=lang('label_from')?></li>
							<li>
					        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
					        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
					        	<span><?=lang('per_pax')?></span>
							</li>
						</ul>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div style="margin-top: 5px;clear:both;">
						<span class="icon icon-what-included"></span>						
						<a href="javascript:void(0)" class="bpt_item_price_included" id="lux_what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
					</div>
					
					<?php endif;?>
					
					<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
						<?=lang('select_cruise')?>
					</div> 
					
				</div>
				
			</div>
				
				
			<?php endforeach ;?>
			
			<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<a class="link_function" href="/luxuryhalongcruises/"><?=lang('more_luxury_halong_cruises')?></a>
			</div>
	</div>
	<?php endif;?>
	
	<?php if(count($recommended_cruises['deluxe_cruises']) > 0):?>
	<div id="deluxe_cruises">
		<?php foreach ($recommended_cruises['deluxe_cruises'] as $key => $cruise) :?>
		
			<?php 
				$odd = "";
				$last = "";
				
				if ($key%2 == 1) $odd = " odd";
				
				if ($key == count($recommended_cruises['deluxe_cruises']) - 1) $last = " last";
			?>
				
			<div class="bpt_item item_radius">
				
				<div class="item_header"></div>
				
				<div class="area_left">
					
					<div class="img_area">
					
						<div class="bpt_item_image">
							<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
						</div>
						
						<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
					</div>
					
					<div class="bpt_item_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_infor = get_star_infor($cruise['star'], 0);
						?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
						
						<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
					</div>
					
					<div class="row">
						
						<div class="col_label">
							<span><?=lang('cruise_type')?>:</span>
						</div>
						
						<div class="col_content">
							<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
						</div>
						
					</div>
					
					
					<?php if($cruise['num_reviews'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_cruise_review_text($cruise, true)?>
							</div>
						</div>
					<?php endif;?>
					
					<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
						
						<div class="row">
							<div class="col_label special">
								<?=lang('special_offers')?>:
							</div>
							
							<div class="col_content">
							
								<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
									
									<?php if($k > 0):?><br><?php endif;?>
																
									<a class="special" id="dex_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
								
								<?php endforeach;?>
							</div>
						</div>
						
					<?php endif;?>
					
					<div class="row description">
						<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
				
				<div class="area_right">
					
					<?php if(!empty($cruise['includes'])):?>
					
					
					<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
						<ul>							
							<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>">from</li>
							<li>
					        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
					        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
					        	<span><?=lang('per_pax')?></span>
							</li>
						</ul>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div style="margin-top: 5px;clear:both;">
						<span class="icon icon-what-included"></span>
						<a href="javascript:void(0)" class="bpt_item_price_included" id="dex_what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
					</div>
					
					<?php endif;?>
					
					<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
						<?=lang('select_cruise')?>
					</div> 
				</div>
				
			</div>
				
				
			<?php endforeach ;?>
			
			<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<a class="link_function" href="/deluxehalongcruises/"><?=lang('more_deluxe_halong_cruises')?></a>
			</div>
	</div>
	<?php endif;?>
	
	<?php if(count($recommended_cruises['cheap_cruises']) > 0):?>
	<div id="cheap_cruises">
		<?php foreach ($recommended_cruises['cheap_cruises'] as $key => $cruise) :?>
			
			<?php 
				$odd = "";
				$last = "";
				
				if ($key%2 == 1) $odd = " odd";
				
				if ($key == count($recommended_cruises['cheap_cruises']) - 1) $last = " last";
			?>
				
			<div class="bpt_item item_radius">
				
				<div class="item_header"></div>
				
				<div class="area_left">
					
					<div class="img_area">
					
						<div class="bpt_item_image">
							<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
						</div>
						
						<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
					</div>
					
					<div class="bpt_item_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_infor = get_star_infor($cruise['star'], 0);
						?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
						
						<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
					</div>
					
					<div class="row">
						
						<div class="col_label">
							<span><?=lang('cruise_type')?>:</span>
						</div>
						
						<div class="col_content">
							<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
						</div>
						
					</div>
					
					<?php if($cruise['num_reviews'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_cruise_review_text($cruise, true)?>
							</div>
						</div>
					<?php endif;?>
					
					<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
						
						<div class="row">
							<div class="col_label special">
								<?=lang('special_offers')?>:
							</div>
							
							<div class="col_content">
							
								<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
									
									<?php if($k > 0):?><br><?php endif;?>
																
									<a class="special" id="che_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
								
								<?php endforeach;?>
							</div>
						</div>
						
					<?php endif;?>
					
					<div class="row description">
						<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
				
				<div class="area_right">
					<?php if(!empty($cruise['includes'])):?>
					
					
					<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
						<ul>							
							<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>">from</li>
							<li>
					        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
					        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
					        	<span><?=lang('per_pax')?></span>
							</li>
						</ul>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div style="margin-top: 5px;clear:both;">
						<span class="icon icon-what-included"></span>
						<a href="javascript:void(0)" class="bpt_item_price_included" id="che_what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
					</div>
					
					<?php endif;?>
					
					<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
						<?=lang('select_cruise')?>
					</div> 
				</div>
				
			</div>
				
				
			<?php endforeach ;?>
			
			<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<a class="link_function" href="/cheaphalongcruises/"><?=lang('more_cheap_halong_cruises')?></a>
			</div>
	</div>
	<?php endif;?>
	
	<?php if(count($recommended_cruises['charter_cruises']) > 0):?>
	<div id="charter_cruises">
		<?php foreach ($recommended_cruises['charter_cruises'] as $key => $cruise) :?>
		
			<?php 
				$odd = "";
				$last = "";
				
				if ($key%2 == 1) $odd = " odd";
				
				if ($key == count($recommended_cruises['charter_cruises']) - 1) $last = " last";
			?>
				
			<div class="bpt_item item_radius">
				
				<div class="item_header"></div>
				
				<div class="area_left">
					
					<div class="img_area">
					
						<div class="bpt_item_image">
							<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
						</div>
						
						<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
					</div>
					
					<div class="bpt_item_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_infor = get_star_infor($cruise['star'], 0);
						?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
						
						<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
					</div>
					
					<div class="row">
						
						<div class="col_label">
							<span><?=lang('cruise_type')?>:</span>
						</div>
						
						<div class="col_content">
							<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
						</div>
						
					</div>
					
					<?php if($cruise['num_reviews'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_cruise_review_text($cruise, true)?>
							</div>
						</div>
					<?php endif;?>
					
					<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
						
						<div class="row">
							<div class="col_label special">
								<?=lang('special_offers')?>:
							</div>
							
							<div class="col_content">
							
								<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
									
									<?php if($k > 0):?><br><?php endif;?>
																
									<a class="special" id="cha_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
								
								<?php endforeach;?>
							</div>
						</div>
						
					<?php endif;?>
					
					<div class="row description">
						<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
				
				<div class="area_right">
					<?php if(!empty($cruise['includes'])):?>
					
					<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
						<ul>							
							<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>">from</li>
							<li>
					        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
					        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
					        	<span><?=lang('per_pax')?></span>
							</li>
						</ul>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div style="margin-top: 5px;clear:both;">
						<span class="icon icon-what-included"></span>
						<a href="javascript:void(0)" class="bpt_item_price_included" id="cha_what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
					</div>
					
					<?php endif;?>
					
					<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
						<?=lang('select_cruise')?>
					</div>
				</div>
				
			</div>
				
				
			<?php endforeach ;?>
			
			<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<a class="link_function" href="/privatehalongcruises/"><?=lang('more_private_halong_cruises')?></a>
			</div>
	</div>	
	<?php endif;?>
	
	<?php if(count($recommended_cruises['day_cruises']) > 0):?>
	<div id="day_cruises">
		<?php foreach ($recommended_cruises['day_cruises'] as $key => $cruise) :?>
		
			<?php 
				$odd = "";
				$last = "";
				
				if ($key%2 == 1) $odd = " odd";
				
				if ($key == count($recommended_cruises['day_cruises']) - 1) $last = " last";
			?>
				
			<div class="bpt_item item_radius">
				
				<div class="item_header"></div>
				
				<div class="area_left">
					
					<div class="img_area">
					
						<div class="bpt_item_image">
							<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
						</div>
						
						<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
					</div>
					
					<div class="bpt_item_name">
						<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
						<?php 
							$star_infor = get_star_infor($cruise['star'], 0);
						?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
						
						<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
					</div>
					
					<div class="row">
						
						<div class="col_label">
							<span><?=lang('cruise_type')?>:</span>
						</div>
						
						<div class="col_content">
							<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
						</div>
						
					</div>
					
					<?php if($cruise['num_reviews'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_cruise_review_text($cruise, true)?>
							</div>
						</div>
					<?php endif;?>
					
					<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
						
						<div class="row">
							<div class="col_label special">
								<?=lang('special_offers')?>:
							</div>
							
							<div class="col_content">
							
								<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
									
									<?php if($k > 0):?><br><?php endif;?>
																
									<a class="special" id="day_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
								
								<?php endforeach;?>
							</div>
						</div>
						
					<?php endif;?>
					
					<div class="row description">
						<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
				
				<div class="area_right">
					<?php if(!empty($cruise['includes'])):?>
					
					<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
						<ul>							
							<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>">from</li>
							<li>
					        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
					        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
					        	<span><?=lang('per_pax')?></span>
							</li>
						</ul>
					</div>
					
					
					<div class="clearfix"></div>
					
					<div style="margin-top: 5px;clear:both;">
						<span class="icon icon-what-included"></span>
						<a href="javascript:void(0)" class="bpt_item_price_included" id="day_what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
					</div>
					
					<?php endif;?>
					 
					<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
						<?=lang('select_cruise')?>
					</div>
					
				</div>
				
			</div>
				
				
			<?php endforeach ;?>
			
			<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<a class="link_function" href="/halongbaydaycruises/"><?=lang('more_halongbay_day_cruises')?></a>
			</div>
	</div>	
	<?php endif;?>
	
</div>
</div>
<?php else:?>

	<?php if(count($tour_hot_deals) > 0):?>
		<h2 class="highlight" style="padding-bottom: 0"><?='Recommended ' . $page_header?></h2>
	<?php endif;?>
	
	<?php foreach ($recommended_cruises as $key => $cruise) :?>
	
		<?php 
			$odd = "";
			$last = "";
			
			if ($key%2 == 1) $odd = " odd";
			
			if ($key == count($recommended_cruises) - 1) $last = " last";
		?>
			
		<div class="bpt_item item_radius<?=$last?>" <?php if(count($tour_hot_deals) == 0 && $key == 0):?>style="margin-top:0"<?php endif;?>>
			
			<div class="item_header"></div>
			
			<div class="area_left">
	
				<div class="img_area">
				
					<div class="bpt_item_image">
						<img width="135" height="90" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_135_90_path').$cruise['picture']?>"></img>
					</div>
					
					<div class="btn_general btn_book_together btn_overview" onclick="see_cruise_overview(<?=$cruise['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
				
				</div>
				
				<div class="bpt_item_name">
					<a href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
					<?php 
						$star_infor = get_star_infor($cruise['star'], 0);
					?>
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
					
					<?php if($cruise['is_new'] == 1):?>
						<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
					
					<?=by_partner($cruise, PARTNER_CHR_LIMIT)?>		
				</div>
				
				<div class="row">
					
					<div class="col_label">
						<span><?=lang('cruise_type')?>:</span>
					</div>
					
					<div class="col_content">
						<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
					</div>
					
				</div>
				
				<?php if($cruise['num_reviews'] > 0):?>	
					<div class="row">
						<div class="col_label">
							<?=lang('reviewscore')?>:
						</div>
						<div class="col_content">
							<?=get_full_cruise_review_text($cruise, true)?>
						</div>
					</div>
				<?php endif;?>
				
				<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
					
					<div class="row">
						<div class="col_label special">
							<?=lang('special_offers')?>:
						</div>
						
						<div class="col_content">
						
							<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
								
								<?php if($k > 0):?><br><?php endif;?>
															
								<a class="special" id="promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)"><?=$hot_deal['name']?> &raquo;</a>
							
							<?php endforeach;?>
						</div>
					</div>
					
				<?php endif;?>
				
				<div class="row description">
					<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>						
				</div>
				
			</div>
			
			<div class="area_right">
				
				<?php if(!empty($cruise['includes'])):?>
				
				<div class="bpt_item_price <?=$cruise['includes']['tour_id'].'block_price'?>" style="display: none;">
					<ul>							
						<li class="from <?=$cruise['includes']['tour_id'].'from_label'?>">from</li>
						<li>
				        	<span class="<?=$cruise['includes']['tour_id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$cruise['includes']['tour_id'].'promotion_price'?>"></span></span>
				        	<span class="price_from"><label class="<?=$cruise['includes']['tour_id'].'from_price'?>"></label></span>
				        	<span><?=lang('per_pax')?></span>
						</li>
					</ul>
				</div>
				
				
				<div class="clearfix"></div>
				
				<div style="margin-top: 5px;clear:both;">
					<span class="icon icon-what-included"></span>
					<a href="javascript:void(0)" class="bpt_item_price_included" id="what_included_<?=$cruise['id']?>"><?=lang('what_included')?> &raquo;</a>
				</div>
				
				<?php endif;?>
				
				<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')">
					<?=lang('select_cruise')?>
				</div>
				
			</div>
			
		</div>
			
			
		<?php endforeach ;?>
	

	
<?php endif;?>

<script type="text/javascript">


$(function() {

    $('#tabs').tiptab({ type : 1 });
	//$( "#tabs" ).tabs({});
	
	<?php if(isset($recommended_cruises['luxury_cruises'])):?>

		
		<?php foreach ($recommended_cruises['luxury_cruises'] as $cruise):?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#lux_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>


			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#lux_what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});

			<?php endif;?>
	
		<?php endforeach;?>
	
		<?php foreach ($recommended_cruises['deluxe_cruises'] as $cruise):?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#dex_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>


			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#dex_what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
			<?php endif;?>
	
		<?php endforeach;?>
	
		
		<?php foreach ($recommended_cruises['cheap_cruises'] as $cruise):?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#che_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>


			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#che_what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
			<?php endif;?>
	
		<?php endforeach;?>
	
	
		<?php foreach ($recommended_cruises['charter_cruises'] as $cruise):?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#cha_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>


			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#cha_what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
			<?php endif;?>
		
	
		<?php endforeach;?>
	
		<?php foreach ($recommended_cruises['day_cruises'] as $cruise):?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#day_promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>

			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#day_what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
			<?php endif;?>
		

		<?php endforeach;?>

	<?php else:?>
		<?php foreach ($recommended_cruises as $cruise) :?>

			<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

				<?php foreach ($cruise['hot_deals'] as $hot_deal):?>
			
					<?php 
						$promotion_title = htmlspecialchars($hot_deal['name'], ENT_QUOTES);
					?>
					
					var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

				<?php endforeach;?>
				
			<?php endif;?>

			<?php if(!empty($cruise['includes'])):?>
			
				var dg_content = '<?=get_excludes_text($cruise['includes']['includes'], $cruise['includes']['excludes'])?>';
				
				var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($cruise['name'], ENT_QUOTES)?>:</span>';
		
				$("#what_included_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
	
			<?php endif;?>
		
		<?php endforeach;?>
	<?php endif;?>
});
</script>
