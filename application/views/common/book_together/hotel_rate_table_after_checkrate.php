	
	<?php
		$hotel_promotion_note = ''; 
		if (count($hotel['room_types']) > 0){
			
			$room_type = $hotel['room_types'][0];
			
			if (isset($room_type['price']['hotel_promotion_note'])){
				$hotel_promotion_note = $room_type['price']['hotel_promotion_note'];
			}
			
			if (isset($room_type['price']['deal_info'])){
				$deal_info = $room_type['price']['deal_info'];
			}
			
			$has_deals = isset($hotel_promotion_note) && trim($hotel_promotion_note) != ''; 
			
		}
	?>
	
	<?php if($has_deals || $is_free_visa):?>
	<div style="float: right;">		
		
			<table style="float: right;">
				<tr>
					<td>
					<?php if((isset($deal_info) && $deal_info['is_hot_deals']) || $is_free_visa):?>
						<span class="icon icon-hot-deals"></span>
					<?php else:?>
						<span class="icon icon-sale"></span>
					<?php endif;?>
					</td>
					
					<td class="special">
						<?php 
							$offers = explode("\n", $hotel_promotion_note);
						?>
						<ul>
						<?php foreach ($offers as $k => $offer):?>
							<?php if(trim($offer) != ''):?>
								<li><a class="special hotel_hot_deal_info" href="javascript:void(0)"><?=$offer?> &raquo;</a></li>
								
							<?php endif;?>						
						<?php endforeach;?>
						
						<!-- Free Vietnam Visa booking with Hotel -->
						<?php if($is_free_visa):?>
							<li><a class="special free-visa-hotel" href="javascript:void(0)"><?=lang('free_vietnam_visa')?> &raquo;</a></li>
							<div style="display:none" id="free_visa_hotel_content">
								<?=$popup_free_visa_4_hotel?>
							</div>								
						<?php endif;?>
						</ul>
						
						<script type="text/javascript">
						<?php if(isset($deal_info)):?>
						

							var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
							
							var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';
	
							$(".hotel_hot_deal_info").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});							
							
						<?php endif;?>
						
						<?php if($is_free_visa):?>
							var dg_content = $('#free_visa_hotel_content').html();
							
							var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
						
							$(".free-visa-hotel").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
						<?php endif;?>
								

						</script>
								
					</td>
				</tr>
			</table>
			
			<div class="clearfix"></div>
		
	</div>
	<?php endif;?>
	
	<div id="hotel_rates" style="float: left;">

		<?php 
			$discount = $hotel['discount_together']['discount'];
			
			$is_discounted = $hotel['discount_together']['is_discounted'];
			
			$room_discount = 0;
			
			$num_col = $discount > 0 ? 5 : 4; 
			
		?>
		
		<table width="100%" cellpadding="0" cellspacing="0" class="tour_accom" style="width:720px">
			<thead>
				<tr>
					<th width="30%"><?=lang('room_type')?></th>
					<th width="3%"><?=lang('people')?></th>
					<th><?=lang('rate')?></th>
					<?php if ($discount > 0):?>
						<th width="12%"><?=lang('discount')?></th>
					<?php endif;?>
					<th width="20%"><?=lang('label_select_rooms')?></th>				
				</tr>
			</thead>
			
				<tbody>
					<?php foreach ($hotel['room_types'] as $key => $value):?>
						<?php 
							$class_name = ($key & 1) ? "odd_row" : "";
						?>
						<tr class="<?=$class_name?>">
							<td valign="top">
								
								<div class="room_name">
									<a href="javascript:void(0)" onclick="openRoomTypeInfo(<?=$value['id']?>)">
										<span id="img_<?=$value['id']?>" class="togglelink"></span><?=$value['name']?> 
									</a>
									<br/>
									<!-- 
									<?php if($value['price']['note'] != ''):?>
										<span style="font-size: 10px; margin-left: 14px;"><?=$value['price']['note']?></span>
									<?php endif;?>
									 -->
									<span style="font-size: 10px; margin-left: 12px;"><?=lang('hotel_room_price_included')?></span> 									
								</div>
								
							</td>
							<td align="right"><?=$value['max_person']?></td>						
							<td align="right">
								<?php if($value['price']['promotion_price'] > 0):?>
									
									<?php if ($value['price']['promotion_price'] != $value['price']['price']):?>
										<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($value['price']['price'], CURRENCY_DECIMAL)?></span>
            							
            						<?php endif;?>
            						<span class="price_total" style="font-weight:normal;"><?=CURRENCY_SYMBOL?><?=number_format($value['price']['promotion_price'], CURRENCY_DECIMAL)?></span>
            						
									
								<?php else :?>
									<span class="price_total" style="font-weight:normal;"><?=lang('na')?></span>
								<?php endif;?>
								<?php if($value['price']['promotion_note'] != ''):?>
									<br/>
									<?php 
										$offers = explode("\n", $value['price']['promotion_note']);
									?>
									<ul>
									<?php foreach ($offers as $offer):?>
									
										<li class="special" style="font-style: italic;"><?=$offer?></lid>
									
									<?php endforeach;?>
									</ul>			
								<?php endif;?>		
							</td>
							
							<?php if ($discount > 0):?>
								<td align="right">
									<span class="price_total">-<?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></span><?php if($is_discounted):?>/r.<?php endif;?>
								</td>
								<?php 
									$room_discount = $discount;
								?>
							<?php endif;?>
					
							<td align="right">
								<select name="nr_room_type_<?=$value['id']?>" id="nr_room_type_<?=$value['id']?>" class="price_total room_select_<?=$hotel['id']?>" onchange="select_hotel_rooms(<?=$hotel['id']?>)" rt="<?=$value['id']?>">
										<option value="0">0</option>				
									<?php for ($index = 1; $index <= $this->config->item('max_room'); $index++):?>										
																	
										<option value="<?=$index?>">
											<?php if($value['price']['promotion_price'] > 0):?>
												
												<?=$index . " ($ " . number_format($index * ($value['price']['promotion_price'] - $room_discount), CURRENCY_DECIMAL). ")"?>
												
											<?php else:?>
												<?=$index . " ( " .lang('na'). ")"?>
											<?php endif;?>
										</option>
									
									<?php endfor ;?>				
								</select>
								<?php if($value['extra_bed_allow'] == 1):?>
									<p class="margin_top_10">
										
										<a href="javascript:void(0)" onclick="openExtrabedInfo(<?=$value['id']?>)">
											<span id="img_extra_<?=$value['id']?>" class="togglelink"></span><?=lang('extra_bed')?> 
										</a>									
										<span name="info" class="icon icon-help"></span>
									</p>
									<p id="extra_bed_<?=$value['id']?>_select" style="display: none;">
										<select name="nr_extra_bed_<?=$value['id']?>" id="nr_extra_bed_<?=$value['id']?>" extrabedprice="<?=$value['price']['extra_bed_price']?>" onchange="select_hotel_rooms(<?=$hotel['id']?>)">
											<option value="0">0</option>				
											<?php for ($index = 1; $index <= $this->config->item('max_room'); $index++):?>										
																			
												<option value="<?=$index?>"><?=$index . " ($ " . number_format($index * $value['price']['extra_bed_price'], CURRENCY_DECIMAL). ")"?></option>
											
											<?php endfor ;?>				
										</select>
									</p>
								<?php endif;?>					
							</td>
							
						</tr>
						<tr id="detail_infor_<?=$value['id']?>" class="<?=$class_name?>" style="display: none;">
							<td colspan="<?=$num_col?>">
																			
								<img style="position: relative; padding: 0 10px 10px 0px; float: left;" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>"></img>
								
								<span style="float: left;"><b><?=lang('room_size')?>: </b><?=$value['room_size']?> <?=lang('square_metres')?></span><br/>
								
								<span style="float: left;"><b><?=lang('bed_size')?>:</b> <?=$value['bed_size']?></span><br/>
								
								<p><?=str_replace("\n", "<br>", $value['description'])?></p>
								
								<div class="clearfix"></div>
								<p style="margin-bottom: 7px;"><b><?=lang('room_facilities')?>:</b></p>
								<ul class="accomm_cabin_facility">
				
									<?php foreach ($value['facilities'] as $f_value):?>																		
									
										<li><span class="icon icon_checkmark"></span><?=$f_value['name']?></li>
																											
									<?php endforeach ;?>
								</ul>
							</td>
						
						</tr>	
														
					<?php endforeach;?>
					
					<?php if(!empty($hotel['optional_services']['additional_charge'])):?>
						<tr class="additional_charges">
							<td colspan="<?=$num_col + 1?>" align="left">
								<div class="header"><?=lang('additional_charge')?></div>
								<?php foreach ($hotel['optional_services']['additional_charge'] as $charge):?>
								<div style="margin-bottom: 3px">
									<label><?=$charge['name']?>: </label>
									
									<?php if($charge['description'] != ''):?>
												
											<span id="opt_<?=$hotel['id'].'_'.$charge['optional_service_id']?>" class="icon icon-help"></span>
												
									<?php endif;?>
											
									<?php if ($charge['charge_type'] == -1):?>
										<span class="price_total" style="padding-left: 15%"><?=number_format($charge['price'], CURRENCY_DECIMAL)?>% of total</span>									
									<?php elseif($charge['charge_type'] == 1):?>
										<span class="price_total" style="padding-left: 15%"><?=CURRENCY_SYMBOL?><?=number_format($charge['price'], CURRENCY_DECIMAL)?></span><?=lang('per_pax')?>
									<?php elseif($charge['charge_type'] == 2):?>
										<span class="price_total" style="padding-left: 15%"><?=CURRENCY_SYMBOL?><?=number_format($charge['price'], CURRENCY_DECIMAL)?></span><?=lang('per_room_night')?>
									<?php endif;?>
								</div>
								<?php endforeach;?>	
							</td>
						</tr>
					<?php endif;?>
					
				</tbody>
			
		</table>
	
	</div>
	
<script type="text/javascript">
$(document).ready(function(){
	var img = '<?=lang('extra_bed_help')?>';
	
	$("span[name='info']").tipsy({fallback: img, gravity: 'e', html: true, width: '250px'});	
});
</script>
	
