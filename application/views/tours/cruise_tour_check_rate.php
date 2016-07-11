<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?=$check_rate_form?>

<?php 
	$num_pax_calculated = $pax_accom_info['num_pax'];
	
	$is_hot_deals = !empty($tour['price']['offer_note']);
	
	$is_free_visa = is_free_visa($tour);
?>
	
<form id="frm_book_now_<?=$tour['id']?>" name="frm_book_now" method="post" action="/touraddcart/<?=$tour['url_title']?>.html">

<?php if(isset($is_extra_booking)):?>
	<input type="hidden" name="is_extra_booking" value="1">
	
	<?php if($is_free_visa):?>
	<div id="free_visa_halong_content" style="display:none;">
		<?=$popup_free_visa?>
	</div>
	<?php endif;?>
	
<?php endif;?>

<?php if(isset($parent_id)):?>
	<input type="hidden" name="parent_id" value="<?=$parent_id?>">
<?php endif;?>

<div style="float: left;margin-top: 10px; width: 100%; margin-bottom: 5px;">
	
	<?php if(!isset($is_extra_booking)):?>
		<div class="tour_accommodation_text">
			<h2 class="highlight" style="padding: 0;"><?=lang('select_your_accommodation')?></h2>
		</div>
	<?php endif;?>
	
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
								<li><a class="special" href="javascript:void(0)" id="deal_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$offer?> &raquo;</a></li>
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


<div class="tour_accommodations" <?php if(isset($is_extra_booking)):?> style="width: 100%;" <?php endif;?>>
	
	<?php 

		$discount = $discount_together['discount'];
		
		$num_col = $pax_accom_info['num_cabin'] + 3;
		
		if ($discount > 0){
			$num_col = $num_col + 1;
		}
	?>
	
	<table class="tour_accom">
		<thead>
			<tr>
				<th width="30%" align="left"><?=lang('accommodation')?></th>
				
				<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
					
					<th>
						<?='Cabin '.$key?><br>
						<span style="font-weight: normal;"><?=$value['arrangement']?></span>
					</th>
				
				<?php endforeach;?>
				
				<?php if($discount > 0):?>
					<th>Discount</th>
				<?php endif;?>
				
				<th><?=lang('total_price')?></th>
				<th width="15%" align="center"></th>
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
					<?php if(!isset($is_extra_booking)):?>
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>
							<img src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
						<?php endif;?>
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
				
					<span style="font-size: 10px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
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
			
			<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
				
				<td colspan="<?=$num_col?>">
					
					<div style="border: 0px solid #FEBA02; float: left; width: 100%">
					
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
						
						<div style="float: left;width: 100%;">
							<div style="float: left; width: 100%; margin-bottom: 7px;">
								
								<?php if(!isset($is_extra_booking)):?>
									<div class="highslide-gallery">
										<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
											<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
										</a>
											
										<div class="highslide-caption">
											<center><b><?=$accommodation['name']?></b></center>
										</div>					
									</div>
								<?php else:?>
									<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<?php endif;?>
								
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
								<ul class="accomm_cabin_facility" style="width: 100%;">
		
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
						
						<ul>
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
	
						
					<?php endif;?>
				
					</div>
				</td>
			
			</tr>
			
		<?php endforeach;?>
		
		<?php 
			//$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
		?>
		
		<!-- Khuyepv 21/03/2015 Always Show Triple Cabin if the Cruise Have -->
		<?php if(count($accommodations_types['tripple_cabins']) > 0):?>
			
			<tbody>
				<tr>
					<td colspan="<?=$num_col?>" style="border-bottom: 0;"></td>
				</tr>
			</tbody>
		
			<thead>
				<tr>
					<th width="30%" align="left" style="border-top: 1px solid #CDCDCD;">Tripple Cabin: <span style="font-weight:normal;">maximum 3 pax</span></th>				
					
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
						<?php if(!isset($is_extra_booking)):?>
							<?php if(!empty($accommodation['cruise_cabin_id'])):?>
								<img src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
							<?php endif;?>
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
						<span style="font-size: 10px;"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></span>
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
						<div style="padding: 5px 0">
							<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation" value="<?=$accommodation['id']?>" style="display: none;">
							<div class="btn_general btn_book_it" id="btn_book_<?=$accommodation['id']?>">
								<span class="icon icon-cart-bg"></span><span><?=lang('book_it')?></span>
							</div>
						</div>
					</td>
				</tr>
				
				<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
					
					<td colspan="<?=$num_col?>">
						
						<div style="border: 0px solid #FEBA02; float: left; width: 100%">
						
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
							
							<div style="float: left;width: 100%;">
								<div style="float: left; width: 100%; margin-bottom: 7px;">
									
								<?php if(!isset($is_extra_booking)):?>
									<div class="highslide-gallery">
										<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
											<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
										</a>
											
										<div class="highslide-caption">
											<center><b><?=$accommodation['name']?></b></center>
										</div>					
									</div>
								<?php else:?>
									<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<?php endif;?>
									
									<ul>
										<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
										<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
									</ul>
									
									<p><?=$accommodation['cabin_description']?></p>	
								</div>
								<?php if(!empty($accommodation['cabin_facilities'])):?>
									<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
									<ul class="accomm_cabin_facility" style="width: 100%;">
			
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
							
							<ul>
								<?php foreach ($acc_contents as $value):?>
									<?php if (trim($value) != ''):?>
										<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
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
		
		<?php if(count($accommodations_types['family_cabins']) > 0):?>
			
			<tbody>
				<tr>
					<td colspan="<?=$num_col?>" style="border-bottom: 0;"></td>
				</tr>
			</tbody>
			
			
			<thead>
				<tr>
					<?php 
						$max_person = $accommodations_types['family_cabins'][0]['max_person'];
					?>
					<th width="30%" align="left" style="border-top: 1px solid #CDCDCD;">Family Cabin: <span style="font-weight:normal;">maximum <?=$max_person?> pax</span></th>				
					
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
						<?php if(!isset($is_extra_booking)):?>
							<?php if(!empty($accommodation['cruise_cabin_id'])):?>
								<img src="<?=$this->config->item('cruise_80_60_path').$accommodation['picture']?>" class="accomm_cabin_img">
							<?php endif;?>
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
						<span style="font-size: 10px;"><?=!is_tour_no_vat($tour['id'])? lang('room_price_included') : lang('tour_price_no_vat')?></span>
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
						<div style="padding: 5px 0">
							<input type="radio" id="acc_<?=$accommodation['id']?>" name="accommodation" value="<?=$accommodation['id']?>" style="display: none;">
							<div class="btn_general btn_book_it" id="btn_book_<?=$accommodation['id']?>">
								<span class="icon icon-cart-bg"></span><span><?=lang('book_it')?></span>
							</div>
						</div>
					</td>
				</tr>
				
				<tr style="display: none;" id="accomm_detail_<?=$accommodation['id']?>" class="<?=$class_name?>">
					
					<td colspan="<?=$num_col?>">
						
						<div style="border: 0px solid #FEBA02; float: left; width: 100%">
						
						<?php if(!empty($accommodation['cruise_cabin_id'])):?>					
							
							<div style="float: left;width: 100%;">
								<div style="float: left; width: 100%; margin-bottom: 7px;">
									
								<?php if(!isset($is_extra_booking)):?>
									<div class="highslide-gallery">
										<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
											<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
										</a>
											
										<div class="highslide-caption">
											<center><b><?=$accommodation['name']?></b></center>
										</div>					
									</div>
								<?php else:?>
									<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<?php endif;?>
									
									<ul>
										<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
										<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
									</ul>
									
									<p><?=$accommodation['cabin_description']?></p>	
								</div>
								<?php if(!empty($accommodation['cabin_facilities'])):?>
									<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
									<ul class="accomm_cabin_facility" style="width: 100%;">
			
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
							
							<ul>
								<?php foreach ($acc_contents as $value):?>
									<?php if (trim($value) != ''):?>
										<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
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
		
		
		<?php if(count($tour['optional_services']['additional_charge']) > 0):?>
		<tr class="additional_charges">
			<td colspan="<?=$num_col?>" align="left">
				<div class="header"><?=lang('additional_charge')?></div>
				<?php foreach ($tour['optional_services']['additional_charge'] as $charge):?>
				<div style="margin-bottom: 3px">
					<label><?=$charge['name']?>: </label>
					
					<?php if($charge['description'] != ''):?>
								
							<span id="opt_<?=$tour['id'].'_'.$charge['optional_service_id']?>" class="icon icon-help"></span>
								
					<?php endif;?>
							
					<?php if ($charge['charge_type'] != -1):?>
						<span class="price_total" style="padding-left: 15%"><?=CURRENCY_SYMBOL?><?=number_format($charge['price'], CURRENCY_DECIMAL)?></span>/<?=translate_text($unit_types[$charge['charge_type']]);?>
					<?php else:?>
						<span class="price_total" style="padding-left: 15%"><?=number_format($charge['price'], CURRENCY_DECIMAL)?>% of total</span>
					<?php endif;?>
				</div>
				<?php endforeach;?>	
			</td>
		</tr>
		<?php endif;?>
		
		</tbody>
	
		
	</table>
	
	<?php if(!isset($is_extra_booking)):?>
		
		<div class="claim_best_price"><span class="icon icon_checkmark" style="margin-bottom: -2px;"></span><a href="/aboutus/contact/claim/<?=$tour['url_title']?>/<?=$search_criteria['departure_date']?>" rel="nofollow"><b>Claim for Best Price Guaranteed</b></a></div>
		
		<?php if(count($recommendations) > 0):?>
		
		<div class="saving_tips highlight">
			<span class="icon deal_icon"></span>
			<span class="tip_text"><?=lang('extra_saving')?>:</span>
			<span><?=get_recommendation_text($recommendations)?>&nbsp;</span>
			<a href="javascript:void(0)" class="tip_text" style="text-decoration:underline;" onclick="go_book_together_position()"><?=lang('see_deals')?> &raquo;</a>		
		</div>
		
		<?php endif;?>
		
	<?php endif;?>
</div>

<input type="hidden" name="object_change" value="<?=$check_rates['object_change']?>">
<input type="hidden" name="adults" value="<?=$check_rates['adults']?>">
<input type="hidden" name="children" value="<?=$check_rates['children']?>">
<input type="hidden" name="infants" value="<?=$check_rates['infants']?>">
<input type="hidden" name="departure_date" value="<?=$check_rates['departure_date']?>">

<?php if ($tour['cruise_id'] > 0 && !is_private_tour($tour)):?>
	<input type="hidden" name="num_cabin" value="<?=$pax_accom_info['num_cabin']?>">
	
	<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
		
		<input type="hidden" name="type_<?=$key?>" value="<?=$value['type']?>">
		<input type="hidden" name="adults_<?=$key?>" value="<?=$value['adults']?>">
		<input type="hidden" name="children_<?=$key?>" value="<?=$value['children']?>">
		<input type="hidden" name="infants_<?=$key?>" value="<?=$value['infants']?>">
		
	<?php endforeach;?>

<?php endif;?>

</form>

<?php if(!isset($is_extra_booking)):?>
	<?=$price_include_exclude?>
<?php endif;?>

<script>
	
	$(document).ready(function(){

		<?php foreach ($tour['accommodations'] as $accommodation):?>

			$("#btn_book_<?=$accommodation['id']?>").click(function() {
	
				$("#acc_<?=$accommodation['id']?>").attr('checked', 'checked');
				
				<?php if(!isset($is_extra_booking)):?>
					$("#frm_book_now_<?=$tour['id']?>").submit();
				<?php else:?>

					var url ="<?=site_url('/touraddcart/').'/'.$tour['url_title'].'.html'?>";	
			
					var id = '<?='tour_'.$tour['id']?>';
					
					var dataString = $("#frm_book_now_<?=$tour['id']?>").serialize();
			
					$('div#'+id).html('<div style="float: left;width:100%;text-align:center;"><img src="/media/loading-indicator.gif"></div>');
					
					$.ajax({
						url: url,
						type: "POST",
						data: dataString,
						success:function(value){
							
							window.location.href = window.location.href;
							
						}
					});
				
				<?php endif;?>
				
			});

		<?php endforeach;?>

		<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
		
			<?php 
				$deal_info = $tour['price']['deal_info'];
			?>
	
			<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>
	
				var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
				
				var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';
	
				$("#deal_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
					
			<?php endforeach;?>
	
		<?php endif;?>

		<?php if(count($tour['optional_services']['additional_charge']) > 0):?>		
			<?php foreach ($tour['optional_services']['additional_charge'] as $charge):?>

				<?php if($charge['description'] != ''):?>

				<?php 
					$charge['description'] = str_replace("\n", "<p>", $charge['description']);
				?>
				
				$('#opt_<?=$tour['id'].'_'.$charge['optional_service_id']?>').tipsy({fallback: "<?=$charge['description']?>", gravity: 's', width: '250px', title: "<?=$charge['name']?>"});

				<?php endif;?>
				
			<?php endforeach;?>
		<?php endif;?>		


		<?php if($is_free_visa && isset($is_extra_booking)):?>
			var dg_content = $('#free_visa_halong_content').html();
			
			var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
		
			$(".free-visa-halong").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
		<?php endif;?>
		
	});

	
</script>

