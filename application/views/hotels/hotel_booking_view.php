<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="contentLeft">

 <?=$booking_step?>
 
<?=getAds(true)?>
 
<div id="tour_faq">
	<?=$faq_context?>
</div>
	
</div>

<form name="frm_delete_item" method="POST" action="/hotel-booking/<?=$hotel['url_title']?>.html">
	<input type="hidden" name="action_type" value="">
	<input type="hidden" name="rowid" value="">
</form>

<div style="display:none" id="free_visa_halong_content">
	<?=$popup_free_visa?>
</div>
	
<div id="contentMain">
	<?=$progress_tracker?>
	
<?php if(isset($booking_items) && count($booking_items)>0):?>

<form name="frm" method="post" action="/hotelnext/<?=$hotel['url_title']?>/<?=$parent_id?>/">

<input type="hidden" name="action_type"/>

<input type="hidden" name="back_url" value="<?=site_url('hotel-booking/'.$hotel['url_title'].'.html')?>"/>
	
<div id="your_booking"> 	 
	
 
	<div style="width: 100%;">		
		<table class="book_service_table">
			<thead>
				<tr>
					<th width="55%" align="center" class="highlight"><?=lang('services')?></th>
					<th width="20%" align="center" class="highlight"><?=lang('unit')?></th>
					<th width="10%" align="center" class="highlight"><?=lang('rate')?></th>
					<td width="15%" align="center" class="highlight"><b><?=lang('amount')?></b></td>
				</tr>
			</thead>
			
			<?php foreach ($booking_items as $key => $booking_item):?>
			
			<?php 
				$booking_info = $booking_item['booking_info'];					
				
				$num_pax = $booking_info['adults'] + $booking_info['children'] + $booking_info['infants'];
				
				$is_show = $key == count($booking_items) - 1;
			?>

			<tr>
				<td class="highlight" style="padding-left: 10px; font-weight: bold;">
					
					<?php if ($is_show):?>
					
						<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="/media/btn_mini_hover.gif" style="cursor: pointer;margin-bottom: -1px;">
					
					<?php else:?>
					
						<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="/media/btn_mini.gif" style="cursor: pointer;margin-bottom: -1px;">
						
					<?php endif;?>
					
					<a href="javascript:void(0)" onclick="show_booking('<?=$booking_item['rowid']?>')">
						<?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date']))?>: <?=$booking_item['service_name']?>
					</a>				
				</td>
				
				<td align="center" class="note_style"><b><?=$booking_item['unit']?></b></td>
				
				<td></td>
				
				<td class="bg_whiteSmoke price_span" align="right">
					<div class="price_total" <?php if ($is_show):?> style="display: none";<?php endif;?>" id="<?=$booking_item['rowid'].'_booking_total'?>">
					<?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'], CURRENCY_DECIMAL)?>
					</div>
				</td>
			</tr>
		
			
			<tbody id="<?=$booking_item['rowid'].'_booking_content'?>" <?php if(!$is_show):?> style="display: none" <?php endif;?>>
			<?php 
				$total_accomodation = 0;
			?>
			
			<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
				<?php if($detail_booking_item['reservation_type'] == RESERVATION_TYPE_NONE || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_ADDITONAL_CHARGE):?>
				<tr>
					<td class="padding_left_20">
						<div>
							<?=$detail_booking_item['service_name']?>
							<?php if($detail_booking_item['service_desc'] != ''):?>
								
								<span id="<?=$booking_item['rowid'].'_'.$detail_booking_item['service_id'].'_desc'?>" class="icon icon-help"></span>
							
							<?php endif;?>
						</div>
					</td>
					
					<td align="center">
						<div class="note_style"><?=$detail_booking_item['unit']?></div>						
					</td>
					
					<td align="right" class="price_span">
						<div>
							<?=($detail_booking_item['rate'] != '$0' ? $detail_booking_item['rate']: lang('na'))?>	
						</div>
					</td>
					
					<td align="right" class="bg_whiteSmoke price_span">
						<div class="price_total">
						<?php if($detail_booking_item['amount'] > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($detail_booking_item['amount'], CURRENCY_DECIMAL)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>	
						</div>
					</td>
				</tr>
				
				<?php 
					$total_accomodation = $total_accomodation + $detail_booking_item['amount'];
				?>
				
				<?php endif;?>
			<?php endforeach;?>
				
				<?php if(!empty($booking_item['offer_note']) || $booking_item['is_free_visa']):?>
					<tr>
						<td class="padding_left_20 special">
							
							<ul>
							<?php if(!empty($booking_item['offer_name']) && !empty($booking_item['offer_cond'])):?>
							
								<?php 
									$offers = explode("\n", $booking_item['offer_note']);
								?>
								
								
									<?php foreach ($offers as $k=>$offer):?>							
										<?php if(trim($offer) != ''):?>
										<li><a class="special offer_<?=$booking_item['rowid']?>" href="javascript:void(0)"><?=$offer?> &raquo;</a></li>
										<?php endif;?>
									<?php endforeach;?>
								
								
								<script type="text/javascript">		
									var dg_content = '<?=$booking_item['offer_cond']?>';
									var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($booking_item['offer_name'], ENT_QUOTES)?></span>';
									$(".offer_<?=$booking_item['rowid']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
								</script>	
								
							<?php else:?>
								
								<li><?=str_replace("\n", "<br>", $booking_item['offer_note'])?></li>
								
							<?php endif;?>
							
							<?php if($booking_item['is_free_visa']):?>
								<li><a class="special" id="free-visa-<?=$booking_item['service_id']?>" href="javascript:void(0)"><?=lang('free_vietnam_visa')?> &raquo;</a></li>
								
								<?php if($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL):?>
									<div id="free_visa_hotel_<?=$booking_item['service_id']?>" style="display:none;">
										<?=$this->load->view('/ads/popup_free_visa_4_hotel', array('hotel'=>array('name'=>$booking_item['service_name'])))?>
									</div>
								<?php endif;?>
								
								<script type="text/javascript">
									var dg_content = $('#free_visa_halong_content').html();
									<?php if($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL):?>
										dg_content = $('#free_visa_hotel_<?=$booking_item['service_id']?>').html();
									<?php endif;?>
									
									var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
								
									$("#free-visa-<?=$booking_item['service_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});	
								</script>
							<?php endif;?>
							
							</ul>
						</td>
						<td colspan="2">&nbsp;</td>
						<td class="bg_whiteSmoke"></td>
					</tr>
				<?php endif;?>
				
				<input type="hidden" id="<?=$booking_item['rowid'].'_total_accommodation'?>" value="<?=$total_accomodation?>">
				
				<?php if(isset($booking_item['optional_services']['transfer_services']) && count($booking_item['optional_services']['transfer_services']) > 0):?>
				<tr>
					<th colspan="3"><?=lang('transfer_services')?> (optional)</th>
					<td class="bg_whiteSmoke"></td>
				</tr>
				<?php foreach ($booking_item['optional_services']['transfer_services'] as $transfer):?>
					<?php if(!is_suitable_service($transfer, $booking_info)) continue;?>
					<tr>
						<td class="padding_left_20">
							
							<?php 
								
								$rowid = '"'.$booking_item['rowid'] . '"';
																
								$amount = '"'.$transfer['total_price'].'"';
								
								$service_id = '"'.$transfer['optional_service_id'].'"';
								
							?>
						
							<div>
								<input type="checkbox" name="<?=$booking_item['rowid']?>_optional_services[]" onclick='select_optional_service(this, <?=$rowid?>, <?=$service_id?>, <?=$amount?>)' 
								value="<?=number_format($transfer['total_price'], CURRENCY_DECIMAL)?>" <?php if($transfer['is_booked']==1) echo('checked="checked"'); ?>>
								<?=$transfer['name']?>
								
								<?php if($transfer['description'] != ''):?>
								
									<span id="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
								
								<?php endif;?>
								
								<input type="hidden" id="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_selected'?>" name="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_selected'?>" value="<?=$transfer['is_booked']?>">
							</div>
						</td>
						<td align="center">
							<div class="note_style">
							<?=$transfer['unit']?>			
							</div>				
						</td>
						<td align="right" class="price_span">
							<div>				
								<?=$transfer['rate']?>
							</div>
						</td>
						<td align="right" class="bg_whiteSmoke price_span">
							<div id="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_total'?>"  <?php if($transfer['is_booked']):?>class="price_total"<?php endif;?>>
								<?=$transfer['amount']?>								
							</div>
						</td>
					</tr>
				<?php endforeach;?>
				<?php endif;?>
		
				<?php if(isset($booking_item['optional_services']['extra_services']) && count($booking_item['optional_services']['extra_services']) > 0):?>		
				<tr>
					<th colspan="3"><?=lang('extra_services')?></th>
					<th class="bg_whiteSmoke"></th>
				</tr>
				<?php foreach ($booking_item['optional_services']['extra_services'] as $extra):?>
					
					<?php 
								
								$rowid = '"'.$booking_item['rowid'] . '"';			
								
								$rate = '"'.$extra['rate'].'"';
								
								$amount = '"'.$extra['total_price'].'"';
								
								$service_id = '"'.$extra['optional_service_id'].'"';
								
								$is_visa = strpos($extra['name'], 'Visa') !== FALSE;
								
							?>
							
					<tr>
						<td class="padding_left_20">
							<div>
							<input type="checkbox" name="<?=$booking_item['rowid']?>_optional_services[]" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_checkbox'?>" onclick='select_optional_service(this, <?=$rowid?>, <?=$service_id?>, <?=$amount?>)' 
								value="<?=number_format($extra['total_price'], CURRENCY_DECIMAL)?>"  <?php if($extra['is_booked']==1) echo('checked="checked"'); ?>>
							
							<?php if($is_visa):?>
								<b><?=$extra['name']?></b>
							<?php else:?>
								<?=$extra['name']?>
							<?php endif;?>
			
							
							<?php if($extra['description'] != ''):?>
								
									<span id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_desc'?>" class="icon icon-help"></span>
								
							<?php endif;?>
								
							<input type="hidden" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_selected'?>" name="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_selected'?>" value="<?=$extra['is_booked']?>">
							
							</div>
						</td>
						
						<td align="center">	
							<div>
								<?php if($extra['charge_type'] == 2):?>
									1
								<?php elseif($extra['charge_type'] == -1):?>
									<?=$num_pax?>									
								<?php elseif($extra['charge_type'] == 1):?>
									<select name="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_unit'?>" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_unit'?>" <?php if($extra['is_booked']!=1) echo('disabled="disabled"'); ?> onchange='select_unit_extra_service(<?=$rowid?>, <?=$service_id?>, <?=$rate?>)'>
										<?php for ($i=$num_pax; $i >= 1; $i--):?>
											<option value="<?=$i?>" <?php if($i == $extra['unit']):?> selected="selected" <?php endif;?>><?=$i?></option>
										<?php endfor;?>
									</select> <?=lang('unit_pax')?>
								<?php endif;?>
							</div>
						</td>
						<td align="right" class="price_span">
							<div>	
							<?=$extra['rate']?>
							</div>
						</td>
						<td align="right" class="bg_whiteSmoke price_span">
							<div id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_total'?>" <?php if($extra['is_booked']):?>class="price_total"<?php endif;?>>
							
							<?=$extra['amount']?>							
							</div>
						</td>
					</tr>
				<?php endforeach;?>
				<?php endif;?>
				

				
				<?php if(count($booking_items) > 1):?> 
					<tr>
						<td style="padding-left: 10px; font-weight: bold;">
							<?php if($key > 0):?>
								<a class="function" href="javascript:void(0)" onclick="remove_item('<?=$booking_item['rowid']?>')">								
									<?=lang('remove_item')?>
								</a>
							<?php else:?>
								&nbsp;
							<?php endif;?>
						</td>
						<td colspan="2" align="right" style="padding-right: 18px;"><b><?=lang('subtotal')?></b>&nbsp;</td>
						<td align="right" class="price_span bg_whiteSmoke">
							<label id="<?=$booking_item['rowid'].'_total_display'?>" class="price_total">
								<?php if($booking_item['total_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</label>
						</td>
						
					</tr>
				<?php endif;?>
			</tbody>
				
				
					<tr><td colspan="4" style="border-bottom: 1px solid #DDD"></td></tr>
				
			<?php endforeach;?>
			
			
			<?php if($booking_total['discount'] > 0):?>
			<tr>
				<td align="right" colspan="3" class="total_block_text" style="font-weight: normal; background-color: #fff;font-size: 11px"><?=lang('book_seperate')?></td>
				<td align="right" class="bg_whiteSmoke price_span">
					<div style="font-weight: bold;" id="total_book_seperate" ><?=CURRENCY_SYMBOL?><?=number_format($booking_total['total_price'], CURRENCY_DECIMAL)?></div>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3" class="total_block_text" style="background-color: #fff;font-size: 11px"><?=lang('discount_together')?></td>
				<td align="right" class="bg_whiteSmoke price_span">
					<div class="price_total">- <?=CURRENCY_SYMBOL?><?=number_format($booking_total['discount'], CURRENCY_DECIMAL)?></div>
					<input type="hidden" id="discount_booking_together" value="<?=$booking_total['discount']?>">
				</td>
			</tr>
			<?php endif;?>
			
			<tr>
				<td colspan="3" class="total_block_text"><?=lang('total_price')?></td>
				<td class="price_span total_block"><label class="price_total" style="font-size: 12px;"><?=lang('price_unit').' '?></label><label id="final_total" class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($booking_total['final_total'], CURRENCY_DECIMAL)?></label></td>
			</tr>
			
		</table>	
	</div>	
</div>	

</form>

	<?php if(count($recommendations) > 0):?>	
		<div class="help_next">
			<span><?=lang('next_bellow')?></span>
			<span class="icon icon-btn-down" style="cursor:pointer;" onclick="go_bottom()"></span>
		</div>
		
		<?=$recommedation_services?>
	<?php endif;?>			

<?php else:?>
	<center>
		<strong><?=lang('hotel_warning') ?></strong>
		<br><br>
		<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=lang('hotel_click_here') ?></a> <?=lang('hotel_to_back') ?>
	</center>
<?php endif;?>
	
</div>
	


<?php if(isset($booking_items) && count($booking_items)>0):?>
<div style="float: right; margin: 0; margin-top: 20px;">
	
	<div class="btn_back" onclick="backStep()" style="float: left; margin-right: 15px; margin-top: 2px">		
		<?=lang('back') ?>
	</div>
	
	<div class="btn_general btn_next" onclick="nextStep()" style="float: left;">
		<span class="icon icon-cart-bg" style="margin-bottom: -1px"></span>
		<span><?=lang('add_cart') ?></span>
	</div>
	
</div>
	
	<?php 
		
		$main_item = $booking_items[0];
		
		$booking_info = $main_item['booking_info'];
		
		$url_action = url_builder(HOTEL_DETAIL, $hotel['url_title'], true);
		
		$staying_dates = $booking_info['staying_dates'];
		
		$arrival_date = $staying_dates[0];
		
	?>
				
	<form name="frm_check_rate" method="post" action="<?=$url_action?>">
		
		<input type="hidden" name="action_type"/>
		
		<input type="hidden" name="arrival_date_check_rate" value="<?=$arrival_date?>"/>
	
		<input type="hidden" name="hotel_night_check_rate" value="<?=$booking_info['nights']?>">
	
	</form>

<?php endif;?>

<script type="text/javascript">

$(function() {
	update_booking_total();
	set_tool_tip_optional_serivces();
});

function set_tool_tip_optional_serivces(){
	
	// optional service description	
	<?php foreach ($booking_items as $key => $booking_item):?>
		<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
			
			<?php if($detail_booking_item['reservation_type'] == RESERVATION_TYPE_ADDITONAL_CHARGE):?>

			<?php if($detail_booking_item['service_desc'] != ''):?>

				<?php 
					$detail_booking_item['service_desc'] = str_replace("\n", "<p>", $detail_booking_item['service_desc']);
				?>
				
				$('#<?=$booking_item['rowid'].'_'.$detail_booking_item['service_id'].'_desc'?>').tipsy({fallback: "<?=$detail_booking_item['service_desc']?>", gravity: 's', width: '250px', title: "<?=$detail_booking_item['service_name']?>"});

			<?php endif;?>
				
			<?php endif;?>

			<?php if(isset($booking_item['optional_services']['transfer_services']) && count($booking_item['optional_services']['transfer_services']) > 0):?>

				<?php foreach ($booking_item['optional_services']['transfer_services'] as $transfer):?>
					<?php if(!is_suitable_service($transfer, $booking_info)) continue;?>

					<?php if($transfer['description'] != ''):?>

						<?php 
							$transfer['description'] = str_replace("\n", "<p>", $transfer['description']);
						?>
						
						$('#<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_desc'?>').tipsy({fallback: "<?=$transfer['description']?>", gravity: 's', width: '250px', title: "<?=$transfer['name']?>"});	

					<?php endif;?>
					
				<?php endforeach;?>
				
			<?php endif;?>

			<?php if(isset($booking_item['optional_services']['extra_services']) && count($booking_item['optional_services']['extra_services']) > 0):?>

				<?php foreach ($booking_item['optional_services']['extra_services'] as $extra):?>

					<?php if($extra['description'] != ''):?>

						<?php 
							$extra['description'] = str_replace("\n", "<p>", $extra['description']);
						?>
						
						$('#<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_desc'?>').tipsy({fallback: "<?=$extra['description']?>", gravity: 's', width: '250px', title: "<?=$extra['name']?>"});
						
					<?php endif;?>
					
				<?php endforeach;?>
			
			<?php endif;?>
			
		<?php endforeach;?>
	<?php endforeach;?>
}

function nextStep() {
	document.frm.submit();
}

function backStep(){
	document.frm_check_rate.action_type.value = "check_rate";
	document.frm_check_rate.submit();
}

function remove_item(rowid){
	if (confirm("<?=lang('remove_item_confirm')?>")) {
		document.frm_delete_item.action_type.value = "delete";
		document.frm_delete_item.rowid.value = rowid;
		document.frm_delete_item.submit();	
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

	$(booking_total_display_id).text('<?=CURRENCY_SYMBOL?>'+booking_total);

	$(booking_total_hide_id).text('<?=CURRENCY_SYMBOL?>'+booking_total);  
}

function update_booking_total(){

	var total = 0;

	<?php foreach ($booking_items as $key => $booking_item):?>

		var parent_rowid = '<?=$booking_item['rowid']?>';

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
	<?php endforeach;?>

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

	temporary_select_optional_service(obj, parent_rowid, service_id);
	
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

function temporary_select_optional_service(obj, parent_rowid, service_id){
		
	var selected = obj.checked ? '1' : '0';

	var optional_unit_id = '#' + parent_rowid + '_' + service_id + '_unit';
	
	var unit = $(optional_unit_id + ' option:selected').val();

	if (unit == '' || unit == undefined){
		unit = 0;
	} else {		
		unit = getPriceNumber(unit);	
	}
	
	$.ajax({
		url: '/addoptionalservice/',
		type: "POST",
		data: {parent_rowid: parent_rowid, service_id: service_id,  unit: unit, selected: selected},
		success:function(value){
			//alert(value);
		}
	});
	
}

</script>