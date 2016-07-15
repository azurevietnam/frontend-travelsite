			
<div id="your_booking">

<?php 

	$num_pax = $check_rates['adults'] + $check_rates['children'];
?>

<table class="book_service_table">
	<thead>
		<tr>
			<th width="55%" align="center" class="highlight"><?=lang('services')?></th>
			<th width="20%" align="center" class="highlight"><?=lang('unit')?></th>
			<th width="10%" align="center" class="highlight"><?=lang('rate')?></th>
			<td width="15%" align="center" class="highlight"><b><?=lang('amount')?></b></td>
		</tr>
	</thead>
	
	<?php foreach ($booking_services as $key=>$service):?>
		
		<tr>
		
			<?php 
				$id_index = $service['id'].'_'.$service['service_type'];
			?>	
			
			<td class="block_service_title">
							
				<img id="<?=$id_index.'_img_booking'?>" src="/media/btn_mini_hover.gif" style="cursor: pointer;margin-bottom: -1px;" onclick="show_booking('<?=$id_index?>')">
				
				<a href="javascript:void(0)" onclick="show_booking('<?=$id_index?>')">
					<?php if($service['service_type'] == TOUR):?>
						<?=date('d M Y', strtotime($check_rates['departure_date_'.($key+1)]))?>: <?=$service['name']?>
					<?php else:?>
						<?=date('d M Y', strtotime($check_rates['hotel_dates'][0]))?>: <?=$service_2['name']?>
					<?php endif;?>
				</a>				
			</td>
			
			<td align="center" class="note_style">
				<?php if($service['service_type'] == TOUR):?>
					<b><?=get_group_passenger_text($check_rates['adults'], $check_rates['children'], $check_rates['infants'])?></b>
				<?php else:?>
					<b><?=count($check_rates['hotel_dates']).' '.(count($check_rates['hotel_dates']) > 1? lang('nights') : lang('night')).' <br>('.get_hotel_dates_text($check_rates['hotel_dates']).')'?></b>
				<?php endif;?>
			</td>
			
			<td></td>
			
			<td class="bg_whiteSmoke price_span" align="right">
				<div class="price_total" id="<?=$id_index.'_booking_total'?>" style="display: none;">
					
				</div>
			</td>
		</tr>
				
		<tbody id="<?=$id_index?>_booking_content">
			<input type="hidden" id="<?=$id_index.'_total_accommodation'?>" value="">
			<input type="hidden" id="<?=$id_index.'_discount'?>" value="<?=$service['discount_together']['discount']?>">
			
			<?php if($service['service_type'] == TOUR):?>
				<?php if(is_arrange_cabin($service)):?>
					
					<?php 
						$accommodations_types = get_accomodation_by_type($tour['accommodations']);
					?>
					
					<?php foreach ($accommodations_types['normal_cabins'] as $k=>$accommodation):?>	
						<?php
							$cabin_arangement = $service['cabin_arangement']; 
							$num_pax_calculated = $cabin_arangement['num_pax'];
							$tour_children_price = $service['tour_children_price'];
						?>	
						
						<?php foreach ($cabin_arangement['cabins'] as $key=>$cabin):?>
							
							<?php 
								$promotion_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $cabin, true, $tour_children_price);
							?>
							
							<tr class="accommodation_<?=$service['id']?>" acc="<?=$accommodation['id']?>" amount="<?=number_format($promotion_price, CURRENCY_DECIMAL)?>">
								<td class="padding_left_20">
									<div><?=lang('label_cabin')?> <?=$key?>: <?=$accommodation['name']?> <?=$cabin['arrangement']?></div>
								</td>
								
								<td align="center">
									<div class="note_style">1 <?=strtolower(lang('label_cabin'))?></div>					
								</td>
								
								<td align="right">
									<div style="width: 80%; margin-right: 7px;">
										<?php if($promotion_price > 0):?>
											<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
										<?php else:?>
											<?=lang('na')?>
										<?php endif;?>
									</div>
								</td>
								
								<td align="right" class="bg_whiteSmoke price_span">
									<div class="price_total">
										<?php if($promotion_price > 0):?>
											<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
										<?php else:?>
											<?=lang('na')?>
										<?php endif;?>
									</div>
								</td>
							</tr>
						
						<?php endforeach;?>
					<?php endforeach;?>
					
					<?php 
						$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
					?>
					<?php if(count($accommodations_types['tripple_cabins']) > 0):?>
					
						<?php foreach ($accommodations_types['tripple_cabins'] as $k=>$accommodation):?>
					
						<?php 
							//$promotion_price = get_tripple_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, true);
							
							$promotion_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
						?>
						
					
						<tr class="accommodation_<?=$service['id']?>" acc="<?=$accommodation['id']?>" amount="<?=number_format($promotion_price, CURRENCY_DECIMAL)?>">
							<td class="padding_left_20">
								<div><?=$accommodation['name']?></div>
							</td>
							
							<td align="center">
								<div class="note_style">1 <?=strtolower(lang('label_cabin'))?></div>						
							</td>
							
							<td align="right">
								<div style="width: 80%; margin-right: 7px;">
									<?php if($promotion_price > 0):?>
										<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
								</div>
							</td>
							
							<td align="right" class="bg_whiteSmoke price_span">
								<div class="price_total">
									<?php if($promotion_price > 0):?>
										<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
								</div>
							</td>
						</tr>
						<?php endforeach;?>
							
					<?php endif;?>
					
					<?php if(count($accommodations_types['family_cabins']) > 0):?>			
						<?php 
							$max_person = $accommodations_types['family_cabins'][0]['max_person'];
						?>
						
							<?php foreach ($accommodations_types['family_cabins'] as $k=>$accommodation):?>
					
							<?php 
								//$promotion_price = get_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, true, $tour_children_price, $check_rates['adults'], $check_rates['children']);
								$promotion_price = get_triple_family_cabin_price($accommodation['prices'], $accommodation['promotion'], $check_rates, true);
							?>
							
						
							<tr class="accommodation_<?=$service['id']?>" acc="<?=$accommodation['id']?>" amount="<?=number_format($promotion_price, CURRENCY_DECIMAL)?>">
								<td class="padding_left_20">
									<div><?=$accommodation['name']?></div>
								</td>
								
								<td align="center">
									<div class="note_style">1 <?=strtolower(lang('label_cabin'))?></div>						
								</td>
								
								<td align="right">
									<div style="width: 80%; margin-right: 7px;">
										<?php if($promotion_price > 0):?>
											<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
										<?php else:?>
											<?=lang('na')?>
										<?php endif;?>
									</div>
								</td>
								
								<td align="right" class="bg_whiteSmoke price_span">
									<div class="price_total">
										<?php if($promotion_price > 0):?>
											<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
										<?php else:?>
											<?=lang('na')?>
										<?php endif;?>
									</div>
								</td>
							</tr>
							<?php endforeach;?>
						
						
					<?php endif;?>
					
				<?php else:?>
					<?php foreach ($service['accommodations'] as $k=>$accommodation):?>	
						<?php
							$num_pax_calculated = get_pax_calculated($check_rates['adults'], $check_rates['children'], $service, $accommodation['prices']);					
							$total_price = get_total_tour_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, false, $check_rates['adults'], $check_rates['children'], true);
						?>
						
						<tr class="accommodation_<?=$service['id']?>" acc="<?=$accommodation['id']?>" amount="<?=number_format($total_price, CURRENCY_DECIMAL)?>">
							<td class="padding_left_20">
								<div><?=$accommodation['name']?></div>
							</td>
							
							<td align="center">
								<div class="note_style">
									<?=get_group_passenger_text($check_rates['adults'], $check_rates['children'], $check_rates['infants'])?>
								</div>						
							</td>
							
							<td align="right">
								<div style="width: 80%; margin-right: 7px;">
									<?=CURRENCY_SYMBOL?><?=number_format($total_price, CURRENCY_DECIMAL)?>
								</div>
							</td>
							
							<td align="right" class="bg_whiteSmoke price_span">
								<div class="price_total">
									<?=CURRENCY_SYMBOL?><?=number_format($total_price, CURRENCY_DECIMAL)?>
								</div>
							</td>
						</tr>

					<?php endforeach;?>
				<?php endif;?>		
				
			<?php else:?>
				
				<?php foreach ($service['room_types'] as $key => $value):?>
			
					<tr class="room_type_<?=$service['id']?>" rt="<?=$value['id']?>" rate="<?=number_format($value['price']['promotion_price'], CURRENCY_DECIMAL)?>">
						<td class="padding_left_20">
							<div><?=$value['name']?></div>
						</td>
						
						<td align="center">
							<div class="note_style" id="rt_unit_<?=$value['id']?>"></div>						
						</td>
						
						<td align="right">
							<div style="width: 80%; margin-right: 7px;">
								<?php if($value['price']['promotion_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['price']['promotion_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</div>
						</td>
						
						<td align="right" class="bg_whiteSmoke price_span">
							<div class="price_total" id="rt_total_<?=$value['id']?>">
								
							</div>
						</td>
					</tr>
				
				<?php endforeach;?>
					
			<?php endif;?>
			
			<?php if(!empty($service['optional_services']['additional_charge'])):?>
		
				<?php foreach ($service['optional_services']['additional_charge'] as $charge):?>
					
					<tr class="charge_<?=$id_index?>" chargeid="<?=$charge['id']?>" chargetype="<?=$charge['charge_type']?>" chargerate="<?=$charge['price']?>" amount="<?=number_format($charge['amount'], CURRENCY_DECIMAL)?>">
						<td class="padding_left_20">
							<div>
								<?=$charge['name']?>
								<?php if($charge['description'] != ''):?>
										
										<span id="<?=$id_index.'_'.$charge['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
									
								<?php endif;?>
							</div>
						</td>
						
						<td align="center">
							<div class="note_style">
								<?=$charge['unit']?>
							</div>						
						</td>
						
						<td align="right">
							<div style="width: 80%; margin-right: 7px;">
								<?=$charge['rate']?>
							</div>
						</td>
						
						<td align="right" class="bg_whiteSmoke price_span">
							<div class="price_total" id="charge_total_<?=$charge['id']?>">
								<?=CURRENCY_SYMBOL?><?=number_format($charge['amount'], CURRENCY_DECIMAL)?>
							</div>
						</td>
					</tr>
				
				<?php endforeach;?>
		
			<?php endif;?>
	
				
			<?php if(!empty($service['optional_services']['transfer_services'])):?>
				<tr>
					<th colspan="3"><?=lang('transfer_services')?> (Optional)</th>
					<td class="bg_whiteSmoke"></td>
				</tr>
				<?php foreach ($service['optional_services']['transfer_services'] as $transfer):?>
					<?php if(!is_suitable_service($transfer, $check_rates)) continue;?>
					
					<?php 
																				
						$amount = '"'.$transfer['total_price'].'"';
						
						$service_id = '"'.$transfer['optional_service_id'].'"';
						
					?>
									
					<tr>
						<td class="padding_left_20">				
							<div>
								<input type="checkbox" name="<?=$id_index?>_optional_services[]" onclick='select_optional_service(this, "<?=$id_index?>", <?=$service_id?>, <?=$amount?>)' 
								value="<?=number_format($transfer['total_price'], CURRENCY_DECIMAL)?>" <?php if($transfer['default_selected']==1) echo('checked="checked"'); ?>>
								
								<?php if(!empty($transfer['url'])):?>
									<a href="<?=$transfer['url']?>" target="_blank"><?=$transfer['name']?></a>
								<?php else:?>
									<?=$transfer['name']?>
								<?php endif;?>
								
								<?php if($transfer['description'] != ''):?>
										
										<span id="<?=$id_index.'_'.$transfer['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
									
								<?php endif;?>
								
								<input type="hidden" id="<?=$id_index.'_'.$transfer['optional_service_id'].'_selected'?>" name="<?=$id_index.'_'.$transfer['optional_service_id'].'_selected'?>" value="<?=$transfer['default_selected']?>">					
							</div>
						</td>
						<td align="center">
							<div class="note_style">
								<?=$transfer['unit']?>	
							</div>				
						</td>
						<td align="right">
							<div style="width: 80%; margin-right: 7px;">				
								<?=$transfer['rate']?>
							</div>
						</td>
						<td align="right" class="bg_whiteSmoke price_span">
							<div id="<?=$id_index.'_'.$transfer['optional_service_id'].'_total'?>" <?php if($transfer['default_selected'] == 1):?>class="price_total"<?php endif;?>>
							<?=$transfer['amount']?>
							</div>
						</td>
					</tr>
				<?php endforeach;?>	
			<?php endif;?>
	

	<?php if(!empty($service['optional_services']['extra_services']) > 0):?>		
		<tr>
			<th colspan="3"><?=lang('extra_services')?></th>
			<th class="bg_whiteSmoke"></th>
		</tr>
		<?php foreach ($service['optional_services']['extra_services'] as $extra):?>
		<?php 
			$rate = '"'.$extra['rate'].'"';
								
			$amount = '"'.$extra['total_price'].'"';
								
			$service_id = '"'.$extra['optional_service_id'].'"';
		
		?>	
		<tr>
			<td class="padding_left_20">
				<div>
				<input type="checkbox" name="<?=$id_index?>_optional_services[]" id="<?=$id_index.'_'.$extra['optional_service_id'].'_checkbox'?>" onclick='select_optional_service(this, "<?=$id_index?>", <?=$service_id?>, <?=$amount?>)'
					value="<?=number_format($extra['total_price'], CURRENCY_DECIMAL)?>" <?php if($extra['default_selected']==1) echo('checked="checked"'); ?>>
				
				<?php if(!empty($extra['url'])):?>
					<a href="<?=$extra['url']?>" target="_blank"><?=$extra['name']?></a>
				<?php else:?>
					<?=$extra['name']?>
				<?php endif;?>
				
				<?php if($extra['description'] != ''):?>
								
					<span id="<?=$id_index.'_'.$extra['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
							
				<?php endif;?>
						
					<input type="hidden" id="<?=$id_index.'_'.$extra['optional_service_id'].'_selected'?>" name="<?=$id_index.'_'.$extra['optional_service_id'].'_selected'?>" value="<?=$extra['default_selected']?>">
					
					
				</div>
			</td>
			
			<td align="center">	
				<div>
					<?php if($extra['charge_type'] == 2):?>
						1
					<?php elseif($extra['charge_type'] == -1):?>
						<?=$num_pax?>									
					<?php elseif($extra['charge_type'] == 1):?>
					
						<select name="<?=$id_index.'_'.$extra['optional_service_id'].'_unit'?>" id="<?=$id_index.'_'.$extra['optional_service_id'].'_unit'?>" <?php if($extra['default_selected']!=1) echo('disabled="disabled"');?> onchange='select_unit_extra_service("<?=$id_index?>", <?=$service_id?>, <?=$rate?>)'>
							<?php for ($i=$num_pax; $i >= 1; $i--):?>
								<option value="<?=$i?>" <?php if($i == $extra['unit']):?> selected="selected" <?php endif;?>><?=$i?></option>
							<?php endfor;?>
						</select> <?=lang('unit_pax')?>
						
					<?php endif;?>
				</div>
			</td>
			<td align="right">
				<div style="margin-right: 7px;">	
				<?=$extra['rate']?>
				</div>
			</td>
			<td align="right" class="bg_whiteSmoke price_span">
				<div id="<?=$id_index.'_'.$extra['optional_service_id'].'_total'?>" <?php if($extra['default_selected'] == 1):?>class="price_total"<?php endif;?>>
					<?=$extra['amount']?>
				</div>
			</td>
		</tr>
		<?php endforeach;?>
	<?php endif;?>
	
		<tr>
			<td style="padding-left: 10px; font-weight: bold;">
				&nbsp;
			</td>
			<td colspan="2" align="right" style="padding-right: 18px;"><b><?=lang('subtotal')?></b>&nbsp;</td>
			<td align="right" class="price_span bg_whiteSmoke">
				<div class="price_total" id="<?=$id_index.'_total_display'?>">
				</div>
			</td>
			
		</tr>
	</tbody>					
	<tr><td colspan="4" style="border-bottom: 1px solid #CCC"></td></tr>	
		
	<?php endforeach;?>
	
	<tbody id="discount_together_block" style="display: none;">
	<tr>
		<td align="right" colspan="3" class="total_block_text" style="font-weight: normal; background-color: #fff;font-size: 11px"><?=lang('book_seperate')?></td>
		<td align="right" class="bg_whiteSmoke price_span">
			<div style="font-weight: bold;" id="total_book_seperate" ></div>
		</td>
	</tr>
	<tr>
		<td align="right" colspan="3" class="total_block_text" style="background-color: #fff;font-size: 11px"><?=lang('discount_together')?></td>
		<td align="right" class="bg_whiteSmoke price_span">
			<div class="price_total" id="discount_booking_together_display"></div>
			<input type="hidden" id="discount_booking_together" value="0">			
		</td>
	</tr>
	</tbody>
	
	<tr>
		<td colspan="3" class="total_block_text"><?=lang('total_price')?></td>
		<td class="price_span total_block"><label class="price_total" style="font-size: 12px;"><?=lang('price_unit').' '?></label><label id="final_total" class="price_total"></label></td>
	</tr>
</table>
</div>

<script type="text/javascript">

	function is_warning_selection(is_nav){
		
		var warning_1 = true;

		var warning_2 = true;

		$('input[name=<?="accommodation_".$service_1["id"]?>]').each(function(){

			if($(this).attr('checked')){
				warning_1 = false;

				//break;
			}	
			
		});

		<?php if($mode == 1):?>

			warning_2 = !checkRoomTypeBooking('<?=$service_2['id']?>');
			
		<?php else:?>

			$('input[name=<?="accommodation_".$service_2["id"]?>]').each(function(){
	
				if($(this).attr('checked')){
					warning_2 = false;
	
					//break;
				}	
				
			});
		
		<?php endif;?>

		if (warning_1){
			$('#warning_selection_<?=$service_1['id']?>').show();
		} else {
			$('#warning_selection_<?=$service_1['id']?>').hide();
		}

		if (warning_2){
			$('#warning_selection_<?=$service_2['id']?>').show();
		} else {	
			$('#warning_selection_<?=$service_2['id']?>').hide();
		}

		if (warning_1 || warning_2){

			$('#book_extra_services').hide();
			
		} else {
			
			$('#book_extra_services').show();

			if (is_nav != undefined && is_nav == true){
				$("html, body").animate({ scrollTop: $("#book_extra_services").offset().top}, "slow");
			}
		}	
		
		return warning_1 || warning_2;
	}

	function select_accommodation(tour_id, acc_id){

		var total_acc = 0;
		
		if (acc_id == undefined){
			acc_id = $("input[name=accommodation_" + tour_id + "]:checked").val();
		}
		
		$('.accommodation_' + tour_id).each(function(){
					
			$(this).hide();	

			if ($(this).attr('acc') == acc_id){
				$(this).show();	

				total_acc = total_acc + getPriceNumber($(this).attr('amount'));
			}
			
		});

		var total_charge = 0;
		
		$('.charge_' + tour_id + '_<?=TOUR?>').each(function(){
			
			var chargeid = $(this).attr('chargeid');
			
			var chargetype = $(this).attr('chargetype');

			var chargerate = $(this).attr('chargerate');

			var amount = getPriceNumber($(this).attr('amount'));
			
			if (chargetype == -1){
				
				total_charge = total_charge + Math.round(chargerate * total_acc / 100);

				$('#charge_total_'+chargeid).text('<?=CURRENCY_SYMBOL?>' + Math.round(chargerate * total_acc / 100));
				
			} else {

				total_charge = total_charge + amount;
				
			}	
			
		});

		$('#' + tour_id + '_<?=TOUR?>_total_accommodation').val(total_acc + total_charge);

		update_discount();
			
		if (!is_warning_selection(true)){
			update_booking_total();
		}
	}

	function get_number_rooms(rt, hotel_id){

		var ret = 0;

		$('.room_select_'+hotel_id).each(function(){
			
			var rooms = getFormatNumber($(this).find("option:selected").val());
			
			if (rooms > 0 && $(this).attr('rt') == rt){
				
				ret = rooms;
				
			
			}
		});
		
		return ret;

	}

	function select_hotel_rooms(hotel_id){

		var room_type_selected = new Array();
		var i = 0;
		$('.room_select_'+hotel_id).each(function(){
			
			var rooms = getFormatNumber($(this).find("option:selected").val());
			
			if (rooms > 0){
				
				room_type_selected[i] = $(this).attr('rt');
				i++;
			
			}
		});

		var total_acc = 0;

		var total_rooms = 0;
			
		$('.room_type_' + hotel_id).each(function(){
			
			$(this).hide();	

			var rt = $(this).attr('rt');
			
			if (is_in_array(rt, room_type_selected)){
				
				var rate = getFormatNumber($(this).attr('rate'));

				var rooms = get_number_rooms(rt, hotel_id);

				var night = rooms > 1 ? ' rooms' : ' room';

				var rt_unit = rooms + night;

				var rt_total = Math.round(rooms * rate);
				
				var extra_bed = $('#nr_extra_bed_' + rt).find("option:selected").val();	
				
				if (extra_bed != 'undefined' && extra_bed > 0){
					
					var extra_bed_price = getFormatNumber($('#nr_extra_bed_' + rt).attr('extrabedprice'));

					rt_unit = rt_unit + ' + ' + extra_bed + (extra_bed > 1 ? ' extra-beds' : ' extra-bed');

					rt_total = rt_total + extra_bed * extra_bed_price;
				}

				$('#rt_unit_'+rt).text(rt_unit);		

				if (rt_total > 0){
						
					$('#rt_total_' + rt).text('<?=CURRENCY_SYMBOL?>' + rt_total);

				} else {
					$('#rt_total_' + rt).text('<?=lang('na')?>');
				}

				$(this).show();

				total_acc = total_acc + rt_total;

				total_rooms = total_rooms + rooms;	
			}
			
		});


		var total_charge = 0;
		
		$('.charge_' + hotel_id + '_<?=HOTEL?>').each(function(){
			
			var chargeid = $(this).attr('chargeid');
			
			var chargetype = $(this).attr('chargetype');

			var chargerate = $(this).attr('chargerate');

			var amount = getPriceNumber($(this).attr('amount'));
			
			if (chargetype == -1){
				
				total_charge = total_charge + Math.round(chargerate * total_acc / 100);

				$('#charge_total_'+chargeid).text('<?=CURRENCY_SYMBOL?>' + Math.round(chargerate * total_acc / 100));
				
			} else if(chargetype == 2){

				total_charge = total_charge + Math.round(amount * total_rooms);

				$('#charge_total_'+chargeid).text('<?=CURRENCY_SYMBOL?>' + Math.round(amount * total_rooms));
				
			} else {

				total_charge = total_charge + amount;
				
			}	
			
		});
		

		if (total_acc > 0){
			$('#' + hotel_id + '_<?=HOTEL?>_total_accommodation').val(total_acc + total_charge);
		} else {
			$('#' + hotel_id + '_<?=HOTEL?>_total_accommodation').val('<?=lang('na')?>');
		}	

		update_discount();
		
		if (!is_warning_selection(true)){
			update_booking_total();
		}
	}

	function is_in_array(value, arr){

		for(var i = 0; i < arr.length; i++){

			if (value == arr[i]) return true;
			
		}	

		return false;
	}

	function get_tour_discount(tour_id){
		
		var discount = $('#' + tour_id + '_<?=TOUR?>_discount').val();

		discount = discount == '' || discount == undefined ? 0 : getFormatNumber(discount);

		return discount;

	}

	function get_hotel_discount(hotel_id){
		
		var discount = $('#' + hotel_id + '_<?=HOTEL?>_discount').val();
		
		discount = discount == '' || discount == undefined ? 0 : getFormatNumber(discount);

		var rooms = 0;

		$('.room_select_'+hotel_id).each(function(){
			
			rooms = rooms + getFormatNumber($(this).find("option:selected").val());
			
		});

		discount = discount * rooms;

		return discount;		
	}

	function update_discount(){

		var discount = get_tour_discount(<?=$service_1['id']?>);

		<?php if($mode == 1):?>
			discount = discount + get_hotel_discount(<?=$service_2['id']?>);
		<?php else:?>
			discount = discount + get_tour_discount(<?=$service_2['id']?>);
		<?php endif;?>
		

		$('#discount_booking_together').val(discount);

		$('#discount_booking_together_display').text('-' + '<?=CURRENCY_SYMBOL?>' + discount);
		
		if (discount > 0){			
			$('#discount_together_block').show();
		} else {
			$('#discount_together_block').hide();
		}
		
	}

	function count_total_booking(parent_rowid){

		//alert('gohere 1');
		var total_accomodation = $('#' + parent_rowid + '_total_accommodation').val();
		
		total_accomodation = getFormatNumber(total_accomodation);
		//alert('gohere 2');
		$('input[name="' + parent_rowid + '_optional_services[]"]').each(function() {
			
			var price = $(this).val();
			
			if($(this).attr('checked')){
				
				total_accomodation = total_accomodation + getFormatNumber(price);
			} 
		});
		//alert('gohere 3');

		return total_accomodation;
	}

	function update_optional_total(parent_rowid, service_id, amount, selected){
		
		var optional_total_id = '#' + parent_rowid + '_' + service_id + '_total';

		var booking_total_display_id = '#' + parent_rowid + '_total_display';

		var booking_total_hide_id = '#' + parent_rowid + '_booking_total';  

		var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';
		
		if (selected == '1'){
			
			$(optional_total_id).addClass('price_total');

			$(optional_unit_id).removeAttr('disabled');

		} else {

			$(optional_total_id).removeClass('price_total');

			$(optional_unit_id).attr('disabled', 'disabled');
		}

		var booking_total = count_total_booking(parent_rowid);
		
		if (booking_total > 0){
			$(booking_total_display_id).text('<?=CURRENCY_SYMBOL?>'+booking_total);
			$(booking_total_hide_id).text('<?=CURRENCY_SYMBOL?>'+booking_total);
		} else {
			$(booking_total_display_id).text('<?=lang('na')?>');
			$(booking_total_hide_id).text('<?=lang('na')?>');
		}  
	}

	function update_booking_total(){

		var total = 0;		

		var parent_rowid = '<?=$service_1['id'].'_'.$service_1['service_type']?>';

		var booking_total_display_id = '#' + parent_rowid + '_total_display'; 

		var booking_total_hide_id = '#' + parent_rowid + '_booking_total';
		
		var booking_total = count_total_booking(parent_rowid);

		if (booking_total > 0){
		
			$(booking_total_display_id).text('<?=CURRENCY_SYMBOL?>' + booking_total); 
	
			$(booking_total_hide_id).text('<?=CURRENCY_SYMBOL?>'+booking_total); 

		} else {

			$(booking_total_display_id).text('<?=lang('na')?>'); 
			
			$(booking_total_hide_id).text('<?=lang('na')?>'); 
			
		} 

		total = total + booking_total;


		

		var parent_rowid = '<?=$service_2['id'].'_'.$service_2['service_type']?>';

		var booking_total_display_id = '#' + parent_rowid + '_total_display'; 

		var booking_total_hide_id = '#' + parent_rowid + '_booking_total';
		
		var booking_total = count_total_booking(parent_rowid);

		if (booking_total > 0){
			
			$(booking_total_display_id).text('<?=CURRENCY_SYMBOL?>' + booking_total); 
	
			$(booking_total_hide_id).text('<?=CURRENCY_SYMBOL?>'+booking_total); 

		} else {

			$(booking_total_display_id).text('<?=lang('na')?>'); 
			
			$(booking_total_hide_id).text('<?=lang('na')?>');
			
		} 

		total = total + booking_total;

		
		

		var discount = $('#discount_booking_together').val();

		if (discount == '' || discount == undefined) {discount = 0;} else{discount = getFormatNumber(discount);}

		var final_total = total - discount;

		if (total > 0){
			$('#total_book_seperate').text('<?=CURRENCY_SYMBOL?>' + total); 
		} else {
			$('#total_book_seperate').text('<?=lang('na')?>');
		}

		if (final_total > 0){
			$('#final_total').text('<?=CURRENCY_SYMBOL?>' + final_total);
		} else {
			$('#final_total').text('<?=lang('na')?>');
		}

	}

	function select_optional_service(obj, parent_rowid, service_id, amount){

		var select_optional_service_id = '#'+ parent_rowid + '_' + service_id + '_selected';
		
		var selected = obj.checked ? '1' : '0';

		$(select_optional_service_id).val(selected);
		
		update_optional_total(parent_rowid, service_id, amount, selected);

		update_booking_total();
		
	}

	function select_unit_extra_service(parent_rowid, service_id, rate){

		var optional_total_id = '#' + parent_rowid + '_' + service_id + '_total';

		var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';

		var checkbox_id = parent_rowid + '_' + service_id + '_checkbox';

		
		var unit = $(optional_unit_id + ' option:selected').val();

		unit = getPriceNumber(unit);

		var rate_number = getPriceNumber(rate);

		var new_amount = unit * rate_number;

		$('#'+checkbox_id).val(Math.round(new_amount));
		
		if (new_amount == 0){
			$(optional_total_id).text('<?=lang('no_charge')?>');
		} else {	
			$(optional_total_id).text('<?=CURRENCY_SYMBOL?>' + new_amount);
		}
		
		var obj = document.getElementById(checkbox_id);

		select_optional_service(obj, parent_rowid, service_id, new_amount);
		
	}

	$(document).ready(function(){
		select_accommodation(<?=$service_1['id']?>);

		<?php if($mode == 1):?>
			select_hotel_rooms(<?=$service_2['id']?>);
		<?php else:?>
			select_accommodation(<?=$service_2['id']?>);
		<?php endif;?>

		<?php foreach ($booking_services as $service):?>

			<?php 
				$id_index = $service['id'].'_'.$service['service_type'];
			?>	
			
			<?php if(!empty($service['optional_services']['additional_charge'])):?>

				<?php foreach ($service['optional_services']['additional_charge'] as $charge):?>
				
				<?php if($charge['description'] != ''):?>
	
					<?php $charge['description'] = str_replace("\n", "<p>", $charge['description']);?>
				
					$('#<?=$id_index.'_'.$charge['optional_service_id'].'_desc'?>').tipsy({fallback: "<?=$charge['description']?>", gravity: 's', width: '250px', title: "<?=$charge['name']?>"});
					
				<?php endif;?>

				<?php endforeach;?>
				
			<?php endif;?>

			<?php if(!empty($service['optional_services']['transfer_services'])):?>
			
				<?php foreach ($service['optional_services']['transfer_services'] as $transfer):?>
					<?php if(!is_suitable_service($transfer, $check_rates)) continue;?>
		
					<?php if($transfer['description'] != ''):?>
		
						<?php $transfer['description'] = str_replace("\n", "<p>", $transfer['description']);?>
					
						$('#<?=$id_index.'_'.$transfer['optional_service_id'].'_desc'?>').tipsy({fallback: "<?=$transfer['description']?>", gravity: 's', width: '250px', title: "<?=$transfer['name']?>"});
						
					<?php endif;?>
				
				<?php endforeach;?>
				
			<?php endif;?>


		<?php if(!empty($service['optional_services']['extra_services'])):?>
			
			<?php foreach ($service['optional_services']['extra_services'] as $extra):?>
	
				<?php if($extra['description'] != ''):?>
	
					<?php $extra['description'] = str_replace("\n", "<p>", $extra['description']);?>
				
					$('#<?=$id_index.'_'.$extra['optional_service_id'].'_desc'?>').tipsy({fallback: "<?=$extra['description']?>", gravity: 's', width: '250px', title: "<?=$extra['name']?>"});
					
				<?php endif;?>
			
			<?php endforeach;?>
			
		<?php endif;?>
			
			
		<?php endforeach;?>
		
	});
	
</script>