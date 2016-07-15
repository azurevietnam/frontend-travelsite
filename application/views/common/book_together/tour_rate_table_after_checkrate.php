<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	$num_pax_calculated = $cabin_arangement['num_pax'];
	
	$is_hot_deals = !empty($tour['price']['offer_note']);
	
	$is_free_visa = is_free_visa($tour);
?>			

	<?php if ($is_hot_deals || $is_free_visa):?>
	
	<?php 
		$deal_info = $tour['price']['deal_info'];
	?>
	
	<div class="tour_detail_promotion">
		<div class="hot_deals_info">
			<table style="float: right;">				
				<tr>
					<td class="special">
						<?php if($deal_info['is_hot_deals'] || is_free_visa($tour)):?>
							<span class="icon icon-hot-deals"></span>
						<?php else:?>
							<span class="icon icon-sale"></span>
						<?php endif;?>
						
					</td>
					
					<td align="left" class="special">						
						<?php 
							$offers = explode("\n", $tour['price']['offer_note']);
						?>
						
						<ul>
							<?php foreach ($offers as $k=>$offer):?>							
								<?php if($offer != ''):?>
								<li><a class="special tour_hot_deal_info" href="javascript:void(0)" id="deal_tour_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$offer?> &raquo;</a></li>
								<?php endif;?>
							<?php endforeach;?>
							
							<!-- Free Vietnam Visa For Halong Bay Cruise -->
							<?php if($is_free_visa):?>
								<li><a class="special free-visa-halong-<?=$tour['id']?>" href="javascript:void(0)"><?=lang('free_vietnam_visa')?> &raquo;</a></li>
								<div style="display:none;" id="free_visa_halong_content_<?=$tour['id']?>">
									<?=$popup_free_visa_4_tour?>
								</div>								
							<?php endif;?>
							
							<script type="text/javascript">

								var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
								
								var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';
					
								$(".tour_hot_deal_info").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

								<?php if($is_free_visa):?>
									var dg_content = $('#free_visa_halong_content_<?=$tour['id']?>').html();
									
									var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
								
									$(".free-visa-halong-<?=$tour['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
								<?php endif;?>
							
							</script>
							
						</ul>							
					</td>
				</tr>
			</table>			
			
		</div>
	
	</div>
	<?php endif;?>


<div class="clearfix"></div>
<div class="tour_accommodations">

	<?php 

		$discount = $tour['discount_together']['discount'];
		
		$num_col = $cabin_arangement['num_cabin'] + 3;
		
		if ($discount > 0){
			$num_col = $num_col + 1;
		}
	?>
	
	<?php if(is_arrange_cabin($tour)):?>
	
	<table class="tour_accom" style="width:720px">
		<thead>
			<tr>
				<th width="30%" align="left"><?=lang('accommodation')?></th>
				
				<?php foreach ($cabin_arangement['cabins'] as $key => $value):?>
					
					<th>
						<?=lang('label_cabin').' '.$key?><br>
						<span style="font-weight: normal;"><?=$value['arrangement']?></span>
					</th>
				
				<?php endforeach;?>
				
				<?php if($discount > 0):?>
					<th width="10%"><?=lang('discount')?></th>
				<?php endif;?>
				
				<th width="12%"><?=lang('total_price')?></th>
				<th width="20%" align="center"><?=lang('select_cabin')?></th>
			</tr>
		</thead>
		
		<tbody>
		
		<?php 
			$accommodations_types = get_accomodation_by_type($tour['accommodations']);
		?>
		
		
		<?php foreach ($accommodations_types['normal_cabins'] as $k=>$accommodation):?>
			<?php 
				$class_name = ($k & 1) ? "odd_row" : "";
			?>
			<tr class="<?=$class_name?>">
				<td>
					
					<a href="javascript:void(0)" onclick="return show_accomm_detail(<?=$accommodation['id']?>);"><span id="img_<?=$accommodation['id']?>" class="togglelink"></span><?=$accommodation['name']?></a>
						
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
					<span style="font-size: 10px; margin-left: 12px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
				</td>
				
				<?php foreach ($cabin_arangement['cabins'] as $key => $value):?>
					
					<td align="right" nowrap="nowrap">
						
						<?php 
							$list_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $value, false, $tour_children_price);
							
							$promotion_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $value, true, $tour_children_price);
						?>
						
						<?php if ($list_price != $promotion_price):?>
							<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($list_price, CURRENCY_DECIMAL)?></span>
						<?php endif;?>
		        		
		        		<span class="price_total" style="font-weight: normal;">
		        			<?php if($promotion_price > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('na')?>
							<?php endif;?>
		        		</span>
		        		
					
					</td>
				
				<?php endforeach;?>
				
				<?php if($discount > 0):?>
					<td align="right" nowrap="nowrap"><span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span>	</td>
				<?php endif;?>
				
				<td align="right" nowrap="nowrap">
				
					<?php 
						
						$total_price = get_total_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $cabin_arangement['cabins'], true, $tour_children_price);
						
					?>
					
					<span class="price_total">
						<?php if($total_price > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($total_price - $discount, CURRENCY_DECIMAL)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>
					</span>	
				</td>
				<td align="center" nowrap="nowrap">
					<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation_<?=$tour['id']?>" value="<?=$accommodation['id']?>" onclick="select_accommodation(<?=$tour['id']?>,<?=$accommodation['id']?>)">
				</td>
			</tr>
			
			<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
				
				<td colspan="<?=$num_col?>">
					
					<div style="border: 0px solid #FEBA02; float: left; width: 100%">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
						
						<div style="float: left;width: 100%;">
							<div style="float: left; width: 100%; margin-bottom: 7px;">
								<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
								<ul class="accomm_cabin_facility" style="width: 100%;">
		
									<?php foreach ($accommodation['cabin_facilities'] as $value) :?>																		
										
										<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																											
									<?php endforeach ;?>
								</ul>
								
							<?php endif;?>
						</div>
					
						
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=$value?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
				
					</div>
				</td>
			
			</tr>
			
		<?php endforeach;?>
		
		<!-- Tripple Cabins -->
		<?php 
			$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
		?>
		<?php if(count($accommodations_types['tripple_cabins']) > 0):?>
			
			<tbody>
				<tr>
					<td colspan="<?=$num_col?>" style="border-bottom: 0;"></td>
				</tr>
			</tbody>
		
			<thead>
				<tr>
					<th width="30%" align="left" style="border-top: 1px solid #CDCDCD;"><?=lang('tripple_cabin')?>: <span style="font-weight:normal;"><?=lang('maximum_3_pax')?></span></th>				
					
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
					
					<a href="javascript:void(0)" onclick="return show_accomm_detail(<?=$accommodation['id']?>);"><span id="img_<?=$accommodation['id']?>" class="togglelink"></span><?=$accommodation['name']?></a>
						
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
					<span style="font-size: 10px; margin-left: 12px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span> 
				</td>
				
				<td colspan="<?=count($cabin_arangement['cabins'])?>" align="right">
					
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
					<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation_<?=$tour['id']?>" value="<?=$accommodation['id']?>" onclick="select_accommodation(<?=$tour['id']?>,<?=$accommodation['id']?>)">
				</td>
			</tr>
			
			<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
				
				<td colspan="<?=$num_col?>">
					
					<div style="border: 0px solid #FEBA02; float: left; width: 100%">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
						
						<div style="float: left;width: 100%;">
							<div style="float: left; width: 100%; margin-bottom: 7px;">
								<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
								<ul class="accomm_cabin_facility" style="width: 100%;">
		
									<?php foreach ($accommodation['cabin_facilities'] as $value) :?>																		
										
										<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																											
									<?php endforeach ;?>
								</ul>
								
							<?php endif;?>
						</div>
					
						
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=$value?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
				
					</div>
				</td>
			
			</tr>
			
			
			<?php endforeach;?>
			</tbody>
		<?php endif;?>
		
		
		<!-- Family Cabins -->
		
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
					
					<a href="javascript:void(0)" onclick="return show_accomm_detail(<?=$accommodation['id']?>);"><span id="img_<?=$accommodation['id']?>" class="togglelink"></span><?=$accommodation['name']?></a>
						
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
					<span style="font-size: 10px; margin-left: 12px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
				</td>
				
				<td colspan="<?=count($cabin_arangement['cabins'])?>" align="right">
					
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
					<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation_<?=$tour['id']?>" value="<?=$accommodation['id']?>" onclick="select_accommodation(<?=$tour['id']?>,<?=$accommodation['id']?>)">
				</td>
			</tr>
			
			<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
				
				<td colspan="<?=$num_col?>">
					
					<div style="border: 0px solid #FEBA02; float: left; width: 100%">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
						
						<div style="float: left;width: 100%;">
							<div style="float: left; width: 100%; margin-bottom: 7px;">
								<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
								<ul class="accomm_cabin_facility" style="width: 100%;">
		
									<?php foreach ($accommodation['cabin_facilities'] as $value) :?>																		
										
										<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																											
									<?php endforeach ;?>
								</ul>
								
							<?php endif;?>
						</div>
					
						
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=$value?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
				
					</div>
				</td>
			
			</tr>
			
			<?php endforeach;?>
			
			</tbody>
				
			
			
		<?php endif;?>
		
		
		<?php 
			$num_pax = $check_rates['adults'] + $check_rates['children'];
		?>
		<?php if(count($tour['optional_services']['additional_charge']) > 0):?>
		<tr class="additional_charges">
			<td colspan="<?=$num_col?>" align="left">
				<div class="header"><?=lang('additional_charge')?></div>
				<?php foreach ($tour['optional_services']['additional_charge'] as $charge):?>
				<div style="margin-bottom: 3px">
					<label><?=$charge['name']?>: </label>
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
	
	<?php else:?>
	
	<table class="tour_accom">
		<thead>
			<tr>
				<th width="30%" align="left"><?=lang('accommodation')?></th>
				
				<th>
					<?=$check_rates['adults'].' '?> 
					
					<?php if ($check_rates['adults'] > 1):?>
						<?=lang('adults')?>
					<?php else:?>
						<?=lang('adult')?>
					<?php endif;?>
					
				</th>
				
				<?php if(is_single_sup($check_rates['adults'], $check_rates['children'], $tour['accommodations'])):?>
					<th><?=lang('single_sup')?></th>
				<?php endif;?>
				
				<?php if($check_rates['children'] > 0):?>
				
					<th>
						
						<?=$check_rates['children']?>
						
						<?php if($check_rates['children'] > 1):?>
						
							<?=lang('children_org')?>
							
						<?php else:?>
							<?=lang('child')?>
						<?php endif;?>
					
					</th>
				
				<?php endif;?>
				
				<?php if($discount > 0):?>
					<th width="10%"><?=lang('discount')?></th>
				<?php endif;?>
				
				<th width="12%"><?=lang('total_price')?></th>
				
				<th width="20%" align="center"><?=lang('select_accommodation')?></th>
			</tr>
		</thead>
		
		<tbody>
		
		<?php foreach ($tour['accommodations'] as $k=>$accommodation):?>
			
			<?php 
				$class_name = ($k & 1) ? "odd_row" : "";
				$col_span = 4;
				
				$num_pax_calculated = get_pax_calculated($check_rates['adults'], $check_rates['children'], $tour, $accommodation['prices']);
			?>
			
			<tr class="<?=$class_name?>">
				<td>
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>
						<img src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
					<?php endif;?>
					
					<a href="javascript:void(0)" onclick="return show_accomm_detail(<?=$accommodation['id']?>);"><span id="img_<?=$accommodation['id']?>" class="togglelink"></span><?=$accommodation['name']?></a>
					
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
					<span style="font-size: 10px; margin-left: 12px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
				</td>
				
				<td align="right" nowrap="nowrap">
					
					<?php			
						
						$list_price_adults = get_adult_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['adults'], false);
						
						$promotion_price_adults = get_adult_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['adults'], true);
					
					?>
					
					<?php if ($list_price_adults != $promotion_price_adults):?>
					
						<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($list_price_adults, CURRENCY_DECIMAL)?></span>
						
					<?php endif;?>
					
					<span class="price_total" style="font-weight: normal;">
						<?php if($promotion_price_adults > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($promotion_price_adults, CURRENCY_DECIMAL)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>
					</span>
					
					
				</td>
				<?php if(is_single_sup($check_rates['adults'], $check_rates['children'], $tour['accommodations'])):?>
					<td align="right" nowrap="nowrap">
						
						<?php			

							$col_span = $col_span + 1;
						
							$list_price_single_sup = get_singe_sup_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, false);
							
							$promotion_price_single_sup = get_singe_sup_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, true);
						
						?>
						
						<?php if ($list_price_single_sup != $promotion_price_single_sup):?>
						
							<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($list_price_single_sup, CURRENCY_DECIMAL)?></span>
							
						<?php endif;?>
						
						<span class="price_total" style="font-weight: normal;">
							<?php if($promotion_price_single_sup > 0):?>						
								<?=CURRENCY_SYMBOL?><?=number_format($promotion_price_single_sup, CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('na')?>
							<?php endif;?>
						</span>
					
					</td>
				<?php endif;?>
				
				<?php if($check_rates['children'] > 0):?>
					
					<td align="right" nowrap="nowrap">
						
						<?php			
							
							$col_span = $col_span + 1;
							
							$list_price_children = get_children_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['children'], false);
							
							$promotion_price_children = get_children_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['children'], true);
						
						?>
						
						<?php if ($list_price_children != $promotion_price_children):?>
						
							<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($list_price_children, CURRENCY_DECIMAL)?></span>
							
						<?php endif;?>
						
						<span class="price_total" style="font-weight: normal;">
							<?php if($promotion_price_children > 0):?>
								<?=CURRENCY_SYMBOL?><?=number_format($promotion_price_children, CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('na')?>
							<?php endif;?>
						</span>
					
					</td>
				<?php endif;?>
				
				<?php if($discount > 0):?>
					<?php 
						$col_span = $col_span + 1;
					?>
					<td align="right" nowrap="nowrap"><span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span>	</td>
				<?php endif;?>
				
				<td align="right" nowrap="nowrap">
				
					<?php 
						
						$total_price = get_total_tour_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['adults'], $check_rates['children'], true);
						
					?>
					
					<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_price - $discount, CURRENCY_DECIMAL)?></span>	
				</td>
				<td align="center" nowrap="nowrap">
					<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation_<?=$tour['id']?>" value="<?=$accommodation['id']?>" onclick="select_accommodation(<?=$tour['id']?>,<?=$accommodation['id']?>)">
				</td>
			</tr>
			
			<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
				
				<td colspan="<?=$col_span?>">
					
					<div style="border: 0px solid #FEBA02; float: left; width: 100%;">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
						
						<div style="float: left;width: 100%;">
							<div style="float: left;width: 100%; margin-bottom: 7px;">
								<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
							
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>							
								<ul class="accomm_cabin_facility">							
								<?php foreach ($accommodation['cabin_facilities'] as $fkey => $value) :?>																		
									<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>																	
								<?php endforeach ;?>
								</ul>
							
							<?php endif;?>
						</div>
					
						
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul style="margin-left: 12px;">
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=$value?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
				
					</div>
				</td>
			
			</tr>
			
		<?php endforeach;?>
		
		<?php 
			$num_pax = $check_rates['adults'] + $check_rates['children'];
		?>
		<?php if(count($tour['optional_services']['additional_charge']) > 0):?>
		<tr class="additional_charges">
			<td colspan="<?=$cabin_arangement['num_cabin'] + 3?>" align="left">
				<div class="header"><?=lang('additional_charge')?></div>
				<?php foreach ($tour['optional_services']['additional_charge'] as $charge):?>
				<div style="margin-bottom: 3px">
					<label><?=$charge['name']?>: </label>
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
	
	
	<?php endif;?>
	
	
</div>


<script>
	
	$(document).ready(function(){
	
	});
</script>


