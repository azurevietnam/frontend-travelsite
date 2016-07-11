<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	$num_pax_calculated = $pax_accom_info['num_pax'];
	
	$is_hot_deals = !empty($selected_tour['price']['offer_note']);
	
	$is_free_visa = is_free_visa($selected_tour);
?>
	
<form id="frm_book_now_<?=$selected_tour['id']?>" name="frm_book_now" method="post" action="/touraddcart/<?=$selected_tour['url_title']?>.html/fromcruise/">

<div class="cabin_rate_area">

<div class="tour_accommodation_text">
	<h2 class="highlight" style="padding: 0;"><?=lang('select_your_accommodation')?></h2>
</div>
			
<?php if ($is_hot_deals || $is_free_visa):?>
	
	<?php 
		$deal_info = $selected_tour['price']['deal_info'];
	?>
	
	<div class="tour_detail_promotion">
		<div class="hot_deals_info">
			<table style="float: right;">				
				<tr>
					<td class="special">
						<?php if($deal_info['is_hot_deals'] || $is_free_visa):?>
							<span class="icon icon-hot-deals"></span>
						<?php else:?>
							<span class="icon icon-sale"></span>
						<?php endif;?>
						
					</td>
					
					<td align="left" class="special">						
						<?php 
							$offers = explode("\n", $selected_tour['price']['offer_note']);
						?>
						
						<ul>
							<?php foreach ($offers as $k=>$offer):?>							
								<?php if($offer != ''):?>
								<li><a class="special" href="javascript:void(0)" id="deal_<?=$selected_tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$offer?> &raquo;</a></li>
								<?php endif;?>
							<?php endforeach;?>
							
							<!-- Free Vietnam Visa For Halong Bay Cruise -->
							<?php if($is_free_visa):?>
								<li><a class="special free-visa-halong" href="javascript:void(0)"><?=lang('free_vietnam_visa')?> &raquo;</a></li>								
							<?php endif;?>
						</ul>							
					</td>
				</tr>
			</table>
		</div>
	
	</div>
	
	
<?php endif;?>
</div>


<div class="clearfix"></div>
<div class="tour_accommodations">

	<?php 

		$discount = $discount_together['discount'];
		
		$num_col = $pax_accom_info['num_cabin'] + 3;
		
		if ($discount > 0){
			$num_col = $num_col + 1;
		}
	?>
	
	<table class="tour_accom" cellpadding="0" cellspacing="0" width="698">
		<thead>
			<tr>
				<th width="35%" align="left"><?=lang('accommodation')?></th>
				
				<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
					
					<th>
						<?=lang('cruise_cabin').' '.$key?><br>
						<span style="font-weight: normal;"><?=$value['arrangement']?></span>
					</th>
				
				<?php endforeach;?>
				
				<?php if($discount > 0):?>
					<th><?=lang('discount')?></th>
				<?php endif;?>
				
				<th><?=lang('total_price')?></th>
				<th width="15%" align="center"></th>
			</tr>
		</thead>
		
		<tbody>
		
		<?php 
			
			$accommodations_types = get_accomodation_by_type($selected_tour['accommodations']);
		?>
		
		
		<?php foreach ($accommodations_types['normal_cabins'] as $k=>$accommodation):?>
			<?php 
				$class_name = ($k & 1) ? "odd_row" : "";
			?>
			<tr class="<?=$class_name?>">
				<td>
				
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>
						<img style="margin-right: 5px; float: left;" src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
					<?php endif;?>
						
					<a id="<?=$accommodation['id']?>" href="javascript: void(0);" onclick="return openCabinInfo(this);"><span class="togglelink"></span><?=$accommodation['name']?></a>
									
					<br>
					
					
					
					<?php if ($accommodation['promotion'] && $accommodation['promotion']['note_detail'] != ''):?>
					<div class="row special">
						
						<div class="col_2" style="font-style: italic;">
							
							<ul style="list-style:none;margin:0;padding:0;margin-bottom:5px;float:left">
							<?php $offers = explode("\n", $accommodation['promotion']['note_detail']); foreach ($offers as $item) :?>
							<?php if ($item != '') :?>
								<li><i><?=$item?></i></li>
							<?php endif;?>	
							<?php endforeach;?>
							</ul>	
							
						</div>
					</div>
					<br>
					<?php endif;?>
					<span style="font-size: 10px;"><?=!is_tour_no_vat($selected_tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
				</td>
				
				<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
					
					<td align="right" nowrap="nowrap">
						
						<?php 
							$list_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $value, false, $tour_children_price);
							
							$promotion_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $value, true, $tour_children_price);
						?>
						
						<?php if ($list_price != $promotion_price):?>
							<span class="b_discount" style="font-size: 11px; font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($list_price, CURRENCY_DECIMAL)?></span>
						<?php endif;?>
		        		
		        		
		        		<?php if($promotion_price > 0):?>
		        			<span class="price_total" style="font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?></span>
		        		<?php else:?>
		        			<span class="price_total" style="font-weight: normal;"><?=lang('na')?></span>
						<?php endif;?>
					</td>
				
				<?php endforeach;?>
				
				<?php if($discount > 0):?>
					<td align="right" nowrap="nowrap"><span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span>	</td>
				<?php endif;?>
				
				<td align="right" nowrap="nowrap">
				
					<?php 
						
						$total_price = get_total_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $pax_accom_info['cabins'], true, $tour_children_price);
						
					?>
					<?php if($total_price > 0):?>
					<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_price - $discount, CURRENCY_DECIMAL)?></span>
					<?php else:?>
					<span class="price_total"><?=lang('na')?></span>
					<?php endif;?>	
				</td>
				<td align="center" nowrap="nowrap">
				
					<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation" value="<?=$accommodation['id']?>" style="display: none;">
					
					<div class="btn_general btn_book_it" id="btn_book_<?=$accommodation['id']?>">
						<span class="icon icon-cart-bg"></span><span><?=lang('book_it')?></span>
					</div>
					
				</td>
			</tr>
			
			<tr style="display: none;" id="cabin_detail_<?=$accommodation['id']?>" style="display: none;" class="<?=$class_name?>">
				
				<td colspan="<?=$num_col?>">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>
					
						<div class="cabin_image">
							<div style="position: relative;">	
								<div class="highslide-gallery">
									<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
										<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>"/>
									</a>
										
									<div class="highslide-caption">
										<center><b><?=$accommodation['name']?></b></center>
									</div>					
								</div>
							</div>
						</div>	
						<p style="margin-top: 0; margin-bottom: 7px;">
							<b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> <?=lang('cruise_m2')?><br>
							<b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?>
						</p>
						
						<?php 
							$descriptions = str_replace("\n", "<br>", $accommodation['cabin_description']);
						?>
						<p style="margin-top: 0px; margin-bottom: 0"><?=$descriptions?></p>		
					
						<p style="clear: both; margin-top: 0; margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>
							
						<ul style="font-size: 11px;">				
						
							<?php foreach ($accommodation['cabin_facilities'] as $fkey => $value) :?>																		
										
								<li style="float: left; margin-bottom: 5px; width: 33%"><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																										
							<?php endforeach ;?>
											
						</ul>
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
					
				</td>
			
			</tr>
			
		<?php endforeach;?>
		
		<?php 
			//$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
		?>
		
		<?php if(count($accommodations_types['tripple_cabins']) > 0):?>
			
			<tbody>
				<tr>
					<td colspan="<?=$num_col?>" style="border-bottom: 0;"></td>
				</tr>
			</tbody>
		
			<thead>
				<tr>
					<th width="30%" align="left" style="border-top: 1px solid #CDCDCD;">
						<?=lang('tripple_cabin')?>: <span style="font-weight:normal;"><?=lang('maximum_3_pax')?></span>
					</th>				
					
					<td colspan="<?=$num_col - 1?>" style="background-color: #FFF"></td>
				</tr>
			</thead>
			
			<tbody>
				
				<?php foreach ($accommodations_types['tripple_cabins'] as $k=>$accommodation):?>
				
				<?php 
					$class_name = ($k & 1) ? "odd_row" : "";
				?>
				
				<tr class="<?=$class_name?>">
					<td>
						
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>
							<img style="margin-right: 5px; float: left;" src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
						<?php endif;?>
							
						<a id="<?=$accommodation['id']?>" href="javascript: void(0);" onclick="return openCabinInfo(this);"><span class="togglelink"></span><?=$accommodation['name']?></a>
									
					<br>
									
						<br>
						
						
						
						<?php if ($accommodation['promotion'] && $accommodation['promotion']['note_detail'] != ''):?>
						<div class="row special">
							
							<div class="col_2" style="font-style: italic;">
								
								<ul style="list-style:none;margin:0;padding:0;margin-bottom:5px;float:left">
								<?php $offers = explode("\n", $accommodation['promotion']['note_detail']); foreach ($offers as $item) :?>
								<?php if ($item != '') :?>
									<li><i><?=$item?></i></li>
								<?php endif;?>	
								<?php endforeach;?>
								</ul>	
								
							</div>
						</div>
						<br>
						<?php endif;?>
						<span style="font-size: 10px;"><?=!is_tour_no_vat($selected_tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
					</td>
					
					<td colspan="<?=count($pax_accom_info['cabins'])?>" align="right">
						
						<?php 
							$list_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, false);
							
							$promotion_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
						?>
						
						<?php if ($list_price != $promotion_price):?>
							<span class="b_discount" style="font-size: 11px; font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($list_price, CURRENCY_DECIMAL)?></span>
						<?php endif;?>
		        		
		        		
		        		<?php if($promotion_price > 0):?>
		        			<span class="price_total" style="font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?></span>
		        		<?php else:?>
		        			<span class="price_total" style="font-weight: normal;"><?=lang('na')?></span>
						<?php endif;?>
						
					</td>
					
					<?php if($discount > 0):?>
						<td align="right" nowrap="nowrap"><span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span>	</td>
					<?php endif;?>
					
					<td align="right" nowrap="nowrap">
					
						<?php 
							
							$total_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
							
						?>
						<?php if($total_price > 0):?>
						<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_price - $discount, CURRENCY_DECIMAL)?></span>
						<?php else:?>
						<span class="price_total"><?=lang('na')?></span>
						<?php endif;?>	
					</td>
					<td align="center" nowrap="nowrap">
						
						<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation" value="<?=$accommodation['id']?>" style="display: none;">
						
						<div class="btn_general btn_book_it" id="btn_book_<?=$accommodation['id']?>">
							<span class="icon icon-cart-bg"></span><span><?=lang('book_it')?></span>
						</div>
					
					</td>
				</tr>
				
				<tr style="display: none;" id="cabin_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
					
					<td colspan="<?=$num_col?>">
						
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>
					
						<div class="cabin_image">
							<div style="position: relative;">	
								<div class="highslide-gallery">
									<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
										<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>"/>
									</a>
										
									<div class="highslide-caption">
										<center><b><?=$accommodation['name']?></b></center>
									</div>					
								</div>
							</div>
						</div>	
						<p style="margin-top: 0; margin-bottom: 7px;">
							<b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> <?=lang('cruise_m2')?><br>
							<b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?>
						</p>
						
						<?php 
							$descriptions = str_replace("\n", "<br>", $accommodation['cabin_description']);
						?>
						<p style="margin-top: 0px; margin-bottom: 0"><?=$descriptions?></p>	
					
						<p style="clear: both; margin-top: 0; margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>
							
						<ul style="font-size: 11px;">				
						
							<?php foreach ($accommodation['cabin_facilities'] as $value) :?>																		
										
								<li style="float: left; margin-bottom: 5px; width: 33%"><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																										
							<?php endforeach ;?>
											
						</ul>
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>					
						
					</td>
				
				</tr>
				
				<?php endforeach;?>
				
			</tbody>	
		
		<?php endif;?>
		
		<?php if(count($accommodations_types['family_cabins']) > 0):?>
			
			<?php 
				$max_person = $accommodations_types['family_cabins'][0]['max_person'];
			?>
			
			<tbody>
				<tr>
					<td colspan="<?=$num_col?>" style="border-bottom: 0;"></td>
				</tr>
			</tbody>
			
			
			<thead>
				<tr>
					<th width="30%" align="left" style="border-top: 1px solid #CDCDCD;"><?=lang('family_cabin')?>: <span style="font-weight:normal;"><?=lang_arg('maximum_person', $max_person)?></span></th>				
					
					<td colspan="<?=$num_col - 1?>" style="background-color: #FFF"></td>
				</tr>
			</thead>
			
			<tbody>
			
			<?php foreach ($accommodations_types['family_cabins'] as $k=>$accommodation):?>
				
				<?php 
					$class_name = ($k & 1) ? "odd_row" : "";
				?>
				
				<tr class="<?=$class_name?>">
					<td>
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>
							<img style="margin-right: 5px; float: left;" src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
						<?php endif;?>
							
						<a id="<?=$accommodation['id']?>" href="javascript: void(0);" onclick="return openCabinInfo(this);"><span class="togglelink"></span><?=$accommodation['name']?></a>
								
						<br>
						
						
						
						<?php if ($accommodation['promotion'] && $accommodation['promotion']['note_detail'] != ''):?>
						<div class="row special">
							
							<div class="col_2" style="font-style: italic;">
								
								<ul style="list-style:none;margin:0;padding:0;margin-bottom:5px;float:left">
								<?php $offers = explode("\n", $accommodation['promotion']['note_detail']); foreach ($offers as $item) :?>
								<?php if ($item != '') :?>
									<li><i><?=$item?></i></li>
								<?php endif;?>	
								<?php endforeach;?>
								</ul>	
								
							</div>
						</div>
						<br>
						<?php endif;?>
						<span style="font-size: 10px;"><?=!is_tour_no_vat($selected_tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
					</td>
					
					<td colspan="<?=count($pax_accom_info['cabins'])?>" align="right">
						
						<?php 
							$list_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, false);
							
							$promotion_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
						?>
						
						<?php if ($list_price != $promotion_price):?>
							<span class="b_discount" style="font-size: 11px; font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($list_price, CURRENCY_DECIMAL)?></span>
						<?php endif;?>
		        		
		        		
		        		<?php if($promotion_price > 0):?>
		        			<span class="price_total" style="font-weight: normal;"><?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?></span>
		        		<?php else:?>
		        			<span class="price_total" style="font-weight: normal;"><?=lang('na')?></span>
						<?php endif;?>
						
					</td>
					
					<?php if($discount > 0):?>
						<td align="right" nowrap="nowrap"><span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span>	</td>
					<?php endif;?>
					
					<td align="right" nowrap="nowrap">
					
						<?php 
							
							$total_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
							
						?>
						<?php if($total_price > 0):?>
						<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_price - $discount, CURRENCY_DECIMAL)?></span>
						<?php else:?>
						<span class="price_total"><?=lang('na')?></span>
						<?php endif;?>	
					</td>
					<td align="center" nowrap="nowrap">
						
						<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation" value="<?=$accommodation['id']?>" style="display: none;">
						
						<div class="btn_general btn_book_it" id="btn_book_<?=$accommodation['id']?>">
							<span class="icon icon-cart-bg"></span><span><?=lang('book_it')?></span>
						</div>
						
					</td>
				</tr>
				
				<tr style="display: none;" id="cabin_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
					
					<td colspan="<?=$num_col?>">
						
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>
					
							<div class="cabin_image">
								<div style="position: relative;">	
									
									<div class="highslide-gallery">
										<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
											<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>"/>
										</a>
											
										<div class="highslide-caption">
											<center><b><?=$accommodation['name']?></b></center>
										</div>					
									</div>
									
								</div>
							</div>	
							<p style="margin-top: 0; margin-bottom: 7px;">
								<b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> <?=lang('cruise_m2')?><br>
								<b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?>
							</p>
								
							<?php 
								$descriptions = str_replace("\n", "<br>", $accommodation['cabin_description']);
							?>
							<p style="margin-top: 0px; margin-bottom: 0"><?=$descriptions?></p>
						
							<p style="clear: both; margin-top: 0; margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>
								
							<ul style="font-size: 11px;">				
							
								<?php foreach ($accommodation['cabin_facilities'] as $value) :?>																		
											
									<li style="float: left; margin-bottom: 5px; width: 33%"><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																											
								<?php endforeach ;?>
												
							</ul>
						<?php elseif(!empty($accommodation['content'])):?>
							
							<?php					
								$acc_contents = explode("\n", $accommodation['content']);					
							?>
							
							<ul>
								<?php foreach ($acc_contents as $value):?>
									<?php if (trim($value) != ''):?>
										<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
									<?php endif;?>
								<?php endforeach;?>
							</ul>
		
							
						<?php endif;?>
					
					</td>
				
				</tr>
				
			<?php endforeach;?>
				
			
			
			</tbody>
		
		<?php endif;?>
		
		
		<?php if(count($selected_tour['optional_services']['additional_charge']) > 0):?>
		<tr class="additional_charges">
			<td colspan="<?=$num_col?>" align="left">
				<div class="header"><?=lang('additional_charge')?></div>
				<?php foreach ($selected_tour['optional_services']['additional_charge'] as $charge):?>
				<div style="margin-bottom: 3px">
					<label><?=$charge['name']?>: </label>
					<?php if($charge['description'] != ''):?>
								
							<span id="opt_<?=$selected_tour['id'].'_'.$charge['optional_service_id']?>" class="icon icon-help"></span>
								
					<?php endif;?>
					<?php if ($charge['charge_type'] != -1):?>
						<span class="price_total" style="padding-left: 15%"><?=CURRENCY_SYMBOL?><?=number_format($charge['price'], CURRENCY_DECIMAL)?></span>/<?=translate_text($unit_types[$charge['charge_type']]);?>
					<?php else:?>
						<span class="price_total" style="padding-left: 15%"><?=number_format($charge['price'], CURRENCY_DECIMAL).lang('of_total')?></span>
					<?php endif;?>
				</div>
				<?php endforeach;?>	
			</td>
		</tr>
		<?php endif;?>
		
		</tbody>
	
		
	</table>
	
	<div class="claim_best_price"><span class="icon icon_checkmark" style="margin-bottom: -2px;"></span><a href="/aboutus/contact/claim/<?=$selected_tour['url_title']?>/<?=$search_criteria['departure_date']?>" rel="nofollow"><b><?=lang('claim_for_best_price_guaranteed')?></b></a></div>
		
	<?php if(count($recommendations) > 0):?>
		<div class="saving_tips highlight">
			<span class="icon deal_icon"></span>
			<span class="tip_text"><?=lang('extra_saving')?>:</span>
			<span><?=get_recommendation_text($recommendations)?>&nbsp;</span>
			<a href="javascript:void(0)" class="tip_text" style="text-decoration:underline;" onclick="go_book_together_position()"><?=lang('see_deals')?> &raquo;</a>		
		</div>
	<?php endif;?>
	
	
	<?=$price_include_exclude?>
	
	
</div>

<input type="hidden" name="object_change" value="<?=$check_rates['object_change']?>">
<input type="hidden" name="adults" value="<?=$check_rates['adults']?>">
<input type="hidden" name="children" value="<?=$check_rates['children']?>">
<input type="hidden" name="infants" value="<?=$check_rates['infants']?>">
<input type="hidden" name="departure_date" value="<?=$check_rates['departure_date']?>">

<?php if ($selected_tour['cruise_id'] > 0 && !is_private_tour($selected_tour)):?>
	<input type="hidden" name="num_cabin" value="<?=$pax_accom_info['num_cabin']?>">
	
	<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
		
		<input type="hidden" name="type_<?=$key?>" value="<?=$value['type']?>">
		<input type="hidden" name="adults_<?=$key?>" value="<?=$value['adults']?>">
		<input type="hidden" name="children_<?=$key?>" value="<?=$value['children']?>">
		<input type="hidden" name="infants_<?=$key?>" value="<?=$value['infants']?>">
		
	<?php endforeach;?>

<?php endif;?>

</form>


<script type="text/javascript">

	$(document).ready(function(){

		<?php foreach ($selected_tour['accommodations'] as $accommodation):?>

			$("#btn_book_<?=$accommodation['id']?>").click(function() {
	
				$("#acc_<?=$accommodation['id']?>").attr('checked', 'checked');
				
				$("#frm_book_now_<?=$selected_tour['id']?>").submit();
				
			});

		<?php endforeach;?>

		<?php if (isset($selected_tour['price']['deal_info']) && isset($selected_tour['price']['offer_note']) && !empty($selected_tour['price']['offer_note'])):?>
		
			<?php 
				$deal_info = $selected_tour['price']['deal_info'];
			?>
	
			<?php $offers = explode("\n", $selected_tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>
	
				var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
				
				var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';
	
				$("#deal_<?=$selected_tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
					
			<?php endforeach;?>
	
		<?php endif;?>

		<?php if(count($selected_tour['optional_services']['additional_charge']) > 0):?>		
			<?php foreach ($selected_tour['optional_services']['additional_charge'] as $charge):?>
	
				<?php if($charge['description'] != ''):?>

				<?php $charge['description'] = str_replace("\n", "<p>", $charge['description']);?>
				
				$('#opt_<?=$selected_tour['id'].'_'.$charge['optional_service_id']?>').tipsy({fallback: "<?=$charge['description']?>", gravity: 's', width: '250px', title: "<?=$charge['name']?>"});
	
				<?php endif;?>
				
			<?php endforeach;?>
		<?php endif;?>			
			
	});
</script>

