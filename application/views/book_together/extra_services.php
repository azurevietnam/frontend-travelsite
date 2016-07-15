<div class="alert alert-warning service-selection-warning" role="alert">
	<p id="warning_<?=$service_1['id'].'_'.$service_1['service_type']?>">
		<span class="glyphicon glyphicon-warning-sign" style="margin-right:5px"></span>
		<?=lang('tour_accommodation_select')?> <b><?=$service_1['name']?></b>
	</p>
	
	<p id="warning_<?=$service_2['id'].'_'.$service_2['service_type']?>">
		<span class="glyphicon glyphicon-warning-sign" style="margin-right:5px"></span>
		<?=$service_2['service_type'] == HOTEL ? lang('hotel_accommodation_select') :  lang('tour_accommodation_select')?> <b><?=$service_2['name']?></b>
	</p>
</div>

<div id="book_tg_extra_services" style="display: none">
<h2 class="text-highlight"><?=lang('book_extra_services')?></h2>
<table class="table table-hover tbl-extra-services">
	<thead>
        <tr>
          <th width="55%"><?=lang('services')?></th>
          <th width="20%" class="text-center"><?=lang('unit')?></th>
          <th width="10%" class="text-center"><?=lang('rate')?></th>
          <th width="15%" class="text-center"><?=lang('amount')?></th>
        </tr>
     </thead>
     
     <?php foreach ($booking_services as $key=>$service):?>
		
		<?php 
			$id_index = $service['id'].'_'.$service['service_type'];
			$img_toggle_src = '/media/btn_mini_hover.gif';
			$optional_services = $service['optional_services'];
			$check_rates  = $service['check_rates'];
			
			if($service['service_type'] == TOUR || $service['service_type'] == CRUISE){
				$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
				
				$service_unit = generate_traveller_text($check_rates['adults'], $check_rates['children'], $check_rates['infants']);
				
			} else {
				$num_pax = 2;
				
				$service_unit = count($check_rates['staying_dates']).' '.(count($check_rates['staying_dates']) > 1? lang('nights') : lang('night')).' <br>('.get_hotel_dates_text($check_rates['staying_dates']).')';
			}
			
			
		?>	
			
		<tr class="table-border-top booking-items" rowid="<?=$id_index?>">
			<th>
				<img id="<?=$id_index.'_img_booking'?>" onclick="show_booking('<?=$id_index?>')" src="<?=$img_toggle_src?>" style="cursor: pointer; margin-bottom: 2px; margin-right: 5px;">
				<a href="javascript:void(0)" onclick="show_booking('<?=$id_index?>')">
					<?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($service['start_date']))?>: <?=$service['name']?>
				</a>		
			</th>
			
			<th class="text-center none-style">
      			<?=$service_unit?>
      		</th>
      		
      		<th></th>
      		
      		<td class="bgr-whiteSmoke text-right">
      			<span class="text-price" id="<?=$id_index.'_booking_total'?>" style="display:none">
					
				</span>
      		</td>
      		
		</tr>
		
		
		<input type="hidden" id="<?=$id_index.'_total_accommodation'?>" value="">
		<input type="hidden" id="<?=$id_index.'_discount'?>" value="<?=$service['discount_together']['discount']?>">
			
		<tbody id="<?=$id_index?>_booking_content">
			
			<?php if(!empty($optional_services['additional_charge'])):?>
				
				<?php foreach ($optional_services['additional_charge'] as $charge):?>
					
					<tr class="charge_<?=$id_index?>" chargeid="<?=$charge['id']?>" chargetype="<?=$charge['charge_type']?>" chargerate="<?=$charge['price']?>" amount="<?=number_format($charge['amount'], CURRENCY_DECIMAL)?>">
						<td>
							<div class="margin-left-20 border-dashed">
								<?=$charge['name']?>
								<?php if($charge['description'] != ''):?>
									<div class="border-dashed">
										<span id="<?=$id_index.'_'.$charge['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
									</div>
								<?php endif;?>
							</div>
						</td>
						
						<td class="text-center none-style">
							<div class="border-dashed">
								<?=$charge['unit']?>
							</div>						
						</td>
						
						<td class="text-center">
							<div class="border-dashed">
								<?=$charge['rate']?>
							</div>
						</td>
						
						<td class="text-right bgr-whiteSmoke">
							<div class="text-price border-dashed" id="charge_total_<?=$charge['id']?>">
								<?=CURRENCY_SYMBOL?><?=number_format($charge['amount'], CURRENCY_DECIMAL)?>
							</div>
						</td>
					</tr>
					
					
				<?php endforeach;?>
			
			<?php endif;?>
			
			<?php if(!empty($optional_services['transfer_services'])):?>
				
				<tr style="background-color: #fff;">
					<td colspan="3" class="text-unhighlight"><label><?=lang('transfer_services')?> (<?=lang('lbl_optional')?>)</label></td>
					<td class="bgr-whiteSmoke"></td>
				</tr>
				
				<?php foreach ($optional_services['transfer_services'] as $transfer):?>
					
					<?php if(!is_suitable_service($transfer, $check_rates)) continue;?>
					
					<?php 
																				
						$amount = '"'.$transfer['total_price'].'"';
						
						$service_id = '"'.$transfer['optional_service_id'].'"';
						
					?>
									
					<tr>
						<td>				
							<div class="checkbox margin-left-20 border-dashed"> 
								<label>
									<input type="checkbox" style="margin-top: 1px;" name="<?=$id_index?>_optional_services[]" onclick='select_optional_service(this, "<?=$id_index?>", <?=$service_id?>, <?=$amount?>)' 
									value="<?=number_format($transfer['total_price'], CURRENCY_DECIMAL)?>" <?php if($transfer['default_selected']==1) echo('checked="checked"'); ?>>
									
									<?php if(!empty($transfer['url'])):?>
										<a href="<?=$transfer['url']?>" target="_blank"><?=$transfer['name']?></a>
									<?php else:?>
										<?=$transfer['name']?>
									<?php endif;?>
									
									<?php if($transfer['description'] != ''):?>
										
										<?php 
											$ops_id = $id_index.'_'.$transfer['optional_service_id'].'_desc';
										?>
											
										<span class="glyphicon glyphicon-question-sign" data-title="<?=$transfer['name']?>" data-target="#<?=$ops_id?>"></span>
										
										<span style="display:none" id="<?=$ops_id?>">
											<?=$transfer['description']?>
										</span>
										
										
									<?php endif;?>
									
									<input type="hidden" id="<?=$id_index.'_'.$transfer['optional_service_id'].'_selected'?>" name="<?=$id_index.'_'.$transfer['optional_service_id'].'_selected'?>" value="<?=$transfer['default_selected']?>">
								</label>					
							</div>
						</td>
						<td style="vertical-align: middle;" class="none-style" align="center">
							<div class="border-dashed">
								<?=$transfer['unit']?>	
							</div>				
						</td>
						<td style="vertical-align: middle;" align="center">
							<div class="border-dashed">			
								<?=$transfer['rate']?>
							</div>
						</td>
						<td align="right" class="bgr-whiteSmoke">
							<div class="text-price border-dashed" id="<?=$id_index.'_'.$transfer['optional_service_id'].'_total'?>" <?php if($transfer['default_selected'] == 1):?>class="price_total"<?php endif;?>>
							<?=$transfer['amount']?>
							</div>
						</td>
					</tr>
					
				
				<?php endforeach;?>
			
			<?php endif;?>
			
			<?php if(!empty($optional_services['extra_services'])):?>
				
				<tr style="background-color: #fff;">
					<td colspan="3" class="text-unhighlight"><label><?=lang('extra_services')?></label></td>
					<td class="bgr-whiteSmoke"></td>
				</tr>
		
				<?php foreach ($optional_services['extra_services'] as $extra):?>
					
					<?php 
							$rate = '"'.$extra['rate'].'"';
												
							$amount = '"'.$extra['total_price'].'"';
												
							$service_id = '"'.$extra['optional_service_id'].'"';
							
							$is_visa = strpos($extra['name'], 'Visa') !== FALSE;
						
						?>	
						<tr>
							<td>
								<div class="checkbox margin-left-20 border-dashed">
									<label>
									<input type="checkbox" style="margin-top: 1px;" name="<?=$id_index?>_optional_services[]" id="<?=$id_index.'_'.$extra['optional_service_id'].'_checkbox'?>" onclick='select_optional_service(this, "<?=$id_index?>", <?=$service_id?>, <?=$amount?>)'
										value="<?=number_format($extra['total_price'], CURRENCY_DECIMAL)?>" <?php if($extra['default_selected']==1) echo('checked="checked"'); ?>>
									
									<?php if($is_visa):?>
										<b><?=$extra['name']?></b>
									<?php else:?>
								
										<?php if(!empty($extra['url'])):?>
											<a href="<?=$extra['url']?>" target="_blank"><?=$extra['name']?></a>
										<?php else:?>
											<?=$extra['name']?>
										<?php endif;?>
									
									<?php endif;?>
									
									<?php if($extra['description'] != ''):?>
									
										<?php 
											$ops_id = $id_index.'_'.$extra['optional_service_id'].'_desc';
										?>
													
										<span class="glyphicon glyphicon-question-sign" data-title="<?=$extra['name']?>" data-target="#<?=$ops_id?>"></span>
									
										<span style="display:none" id="<?=$ops_id?>">
											<?=$extra['description']?>
										</span>
												
									<?php endif;?>
										
									<input type="hidden" id="<?=$id_index.'_'.$extra['optional_service_id'].'_selected'?>" name="<?=$id_index.'_'.$extra['optional_service_id'].'_selected'?>" value="<?=$extra['default_selected']?>">
									
									</label>
								</div>
							</td>
							
							<td class="text-center none-style" style="vertical-align: middle;">	
								<div class="border-dashed">	
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
							<td class="text-center" style="vertical-align: middle;">	
								<div class="border-dashed">
									<?=$extra['rate']?>
								</div>
							</td>
							<td align="right" class="bgr-whiteSmoke">
								<div class="border-dashed" id="<?=$id_index.'_'.$extra['optional_service_id'].'_total'?>" <?php if($extra['default_selected'] == 1):?>class="price_total"<?php endif;?>>
									<?=$extra['amount']?>
								</div>
							</td>
						</tr>
		
					
				<?php endforeach;?>
			
			<?php endif;?>
			
			<tr>
				<td colspan="3" align="right"><b><?=lang('subtotal')?></b></td>
				<td  class="bgr-whiteSmoke text-right">
					<div class="text-price">
						<label id="<?=$id_index.'_total_display'?>">
						
						</label>
					</div>
				</td>					
			</tr>	
		</tbody>	
		
	<?php endforeach;?>
	
	<tbody id="discount_together_block" style="display: none;">
		<tr class="table-border-top">
			<td align="right" colspan="3" class="discount-txt"><?=lang('book_seperate')?></td>
			<td class="bgr-whiteSmoke text-right">
				<div class="text-price margin-bottom-5" id="total_book_seperate" >
					
				</div>
			</td>
		</tr>
		
		<tr>
			<td align="right" colspan="3" class="discount-txt"><b><?=lang('discount_together')?></b></td>
			<td align="right" class="bgr-whiteSmoke">
				<div class="text-price margin-bottom-5" id="discount_booking_together_display"></div>			
				<input type="hidden" id="discount_booking_together" value="0">
			</td>
		</tr>
	</tbody>
	
	<tr>
		<td class="bgr-header-table" align="right" colspan="3" style="font-size: 15px;">
			<b><?=lang('total_price')?></b>
		</td>
		<td class="bgr-header-table" align="right" style="font-size: 15px;">
			<div class="margin-bottom-5">
				<b class="text-price"><?=lang('price_unit').' '?></b>
				<b id="final_total" class="text-price">
									
				</b>
			</div>
		</td>
	</tr>
</table>

<div class="margin-top-15 text-right">
	<button class="btn btn-blue btn-lg" type="submit" name="action" value="<?=ACTION_ADD_CART?>">
		<span class="glyphicon glyphicon-shopping-cart"></span>
		<?=lang('add_cart')?>
	</button>
</div>

</div>


<script type="text/javascript">

/**
 * @author Khuyenpv
 * Select Tour Accommodation on booking-together
 */
function select_acc(tour_id, acc_val, service_type, is_price_per_cabin, is_triple_family, travellers){
	
	var acc_html = '';
	var total_acc = getPriceNumber($('#total_'+acc_val).text());
	var acc_name = $('#total_'+acc_val).attr('data-name');
	
	var id_index = tour_id + '_' + service_type;
	
	if(is_triple_family == '1' || is_price_per_cabin != '1'){
		acc_html = generate_acc_html(id_index, acc_name, travellers, total_acc, total_acc);
	} else {
		$('.bt-cabin-arrangements-'+tour_id).each(function(){
			var cabin = $(this).attr('data-cabin');
			var arrangement = $(this).attr('data-arrangement');
			var key = $(this).attr('data-key');

			var acc_price = getPriceNumber($('#'+ acc_val + '_' + key).attr('data-price'));
			acc_price = Math.round(acc_price);

			var name = cabin + ': ' + acc_name + arrangement;
			var unit = '1 cabin';

			acc_html = acc_html + generate_acc_html(id_index, name, unit, acc_price, acc_price);
		});
	}

	$('.acc-added-' + id_index).remove();
	$('#' + id_index + '_booking_content').prepend(acc_html);

	
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

	$('#' + id_index + '_total_accommodation').val(total_acc + total_charge);

	update_discount();

	update_booking_total();

	change_button_selection();
	
	show_warning_selections();
}

/**
 * @author Khuyenpv
 * Select Hotel Room on booking-together
 */
function select_rooms(hotel_id){

	var id_index = hotel_id + '_' + '<?=HOTEL?>';
	
	var total_acc = 0;
	var acc_html = ''; 
	$('.room_select_'+hotel_id).each(function(){
		var rooms = getFormatNumber($(this).find("option:selected").val());
		if (rooms > 0){
			var acc_name = $(this).attr('data-name');
			var acc_id = $(this).attr('data-id');
			var unit = rooms + ((rooms > 1) ? ' rooms' : ' room');
			var rate = getPriceNumber($(this).attr('data-rate'));
			var room_total = Math.round(rooms * rate);

			var extra_bed = $('#nr_extra_bed_' + acc_id).find("option:selected").val();	
			
			if (extra_bed != 'undefined' && extra_bed > 0){
				
				var extra_bed_price = getFormatNumber($('#nr_extra_bed_' + acc_id).attr('data-rate'));

				unit = unit + ' + ' + extra_bed + (extra_bed > 1 ? ' extra-beds' : ' extra-bed');

				room_total = room_total + extra_bed * extra_bed_price;
			}

			total_acc = total_acc + room_total;

			acc_html = acc_html + generate_acc_html(id_index, acc_name, unit, rate, room_total);
			
		}
	});

	$('.acc-added-' + id_index).remove();
	$('#' + hotel_id + '_<?=HOTEL?>_booking_content').prepend(acc_html);


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

	update_booking_total();

	show_warning_selections();
}

/**
 * @author Khuyenpv
 * @since 23.06.2013
 * Generate Acc selected HTMLs
 */
function generate_acc_html(id_index, name, unit, rate, total){

	var acc_html = '<tr class="acc-added-' + id_index + '"><td><div class="margin-left-20 border-dashed">' + name + '</div></td>'+
	'<td class="text-center none-style">' + 
		'<div class="border-dashed">' + 
			unit + 
		'</div>' +						
	'</td>' + 
	'<td class="text-center">' +
		'<div class="border-dashed">' + 
			'<?=CURRENCY_SYMBOL?>' + rate + 
		'</div>' +
	'</td>' +
	'<td class="text-right bgr-whiteSmoke">' + 
		'<div class="text-price border-dashed">' + 
			'<?=CURRENCY_SYMBOL?>' + total +  
		'</div>' + 
	'</td>' + 
	'</tr>';

	return acc_html;
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

	<?php if($service_2['service_type'] == HOTEL):?>
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

/**
 * Change the color of the button selection
 * 
 * @author Khuyenpv
 * @since 27.06.2015
 */
function change_button_selection(){
	$('.acc-selection').each(function(){
		if($(this).find('input').is(':checked')){
			$(this).removeClass('btn-default');
			$(this).addClass('btn-green');
		} else {
			$(this).removeClass('btn-green');
			$(this).addClass('btn-default');
		}
	});
}
/**
 * Fire click event on the first loading
 *
 * @author Khuyenpv
 * @since 27.06.2015
 */
function first_page_loading_click(){
	$('.acc-selection').each(function(){
		if($(this).find('input').is(':checked')){
			$(this).find('input').click();
		}
	});

	change_button_selection();
	show_warning_selections
}

/**
 * Show the Service Selection Warning
 * 
 * @author Khuyenpv
 * @since 27.06.2015
 */
function show_warning_selections(){

	var is_ok_1 = false;

	var is_ok_2 = false;

	$('.acc-selection-<?=$service_1['id']?>').each(function(){
		if($(this).find('input').is(':checked')){
			
			is_ok_1 = true;
			return;
		}
	});

	<?php if($service_2['service_type'] == HOTEL):?>

		$('.room_select_<?=$service_2['id']?>').each(function(){
			var rooms = getFormatNumber($(this).find("option:selected").val());
			if (rooms > 0){
				
				is_ok_2 = true;
				return;	
			}
		});	
			

	<?php else:?>

	$('.acc-selection-<?=$service_2['id']?>').each(function(){
			if($(this).find('input').is(':checked')){
				is_ok_2 = true;
				return;
			}
		});

	<?php endif;?>

	var id_index_1 = '<?=$service_1['id']?>' + '_' + '<?=$service_1['service_type']?>';
	var id_index_2 = '<?=$service_2['id']?>' + '_' + '<?=$service_2['service_type']?>';

	if(is_ok_1){
		$('#warning_' + id_index_1).hide();	
	} else {
		$('#warning_' + id_index_1).show();
	}

	if(is_ok_2){
		$('#warning_' + id_index_2).hide();	
	} else {
		$('#warning_' + id_index_2).show();
	}
	
	if(is_ok_1 && is_ok_2){
		$('.service-selection-warning').hide();
		$('#book_tg_extra_services').show();
		go_position('#book_tg_extra_services','slow');
	} else {
		$('.service-selection-warning').show();
		$('#book_tg_extra_services').hide();
	}
}

first_page_loading_click();
										
</script>
