<div id="contentLeft">
<?=$tour_search_view?>

<div id="tour_faq">
	<?=$faq_context?>
</div>
	
</div>
<form name="frm" method="post">
<input type="hidden" name="action_type"/>
<div id="contentMain">
<div id="your_details">
	<div class="header">
		<table class="table_progress">
			<tr>
				<td colspan="3" align="center" class="line">
					<div class="booking_first_step"></div>
					<div class="booking_step_line"></div>
					<div class="booking_step"></div>
					<div class="booking_step_line"></div>
					<div class="booking_step in_process"></div>
				</td>
			</tr>
			<tr>
				<td class="book_step_text"><?=lang('check_rates')?></td>
				<td class="book_step_text book_step_text_mid"><?=lang('book_extra_services')?></td>
				<td class="book_step_text book_step_text_last book_step_selected"><?=lang('submit_booking')?></td>
			</tr>
		</table>
	</div>

	<div style="margin-left: 10px; margin-top: 10px">
		<h1 class="highlight" style="padding-left: 0; padding-top: 0"><?=$tour['name']?>
			<?=by_partner($tour, PARTNER_CHR_LIMIT)?>
		</h1>
		<div class="tour_detail_image">
			<img src="<?=$this->config->item('tour_220_165_path').$tour['picture_name']?>"></img>
		</div>
	<div class="tour_detail_content">
		<?php if($tour['cruise_name'] != ''):?>
			<div class="row">
				<?php 
					$star_infor = get_star_infor_tour($tour['star'], 0);
				?>
					
				<div class="col_label"><b><?=lang('cruise_ship')?>:</b></div>
				<div class="col_content"><a href="<?=url_builder(CRUISE_DETAIL, $tour['cruise_url_title'], true)?>"><?=$tour['cruise_name']?></a>					 
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
				</div>
			</div>
		<?php endif;?>
		
		<div class="row">
			<div class="col_label"><b><?=lang('cruise_destinations')?>:</b></div>
			<div class="col_content"><?=$tour['route']?></div>
		</div>
		<?php if (isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
		<div class="row">
			<div class="col_label special"><b><?=lang('special_offers')?>:</b></div>
			<div class="col_content">
				<ul>
				<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $item) :?>
				<?php if ($item != '') :?>
					<li class="special"><i><?=$item?></i></li>
				<?php endif;?>	
				<?php endforeach;?>
				</ul>
			</div>
		</div>
		<?php endif;?>
		
		<div class="row">
			<div class="col_label"><b><?=lang('guests')?>:</b></div>
			<div class="col_content"><?=$booking_info['guest']?></div>
		</div>
		<div class="row">
			<div class="col_label"><b><?=lang('departure_date')?>:</b></div>
			<div class="col_content"><?=date(DATE_FORMAT, strtotime($booking_info['departure_date']))?></div>
		</div>
		<div class="row">
			<div class="col_label"><b><?=lang('end_date')?>:</b></div>
			<div class="col_content"><?=date(DATE_FORMAT, strtotime($booking_info['end_date']))?></div>
		</div>
	</div>	
	</div>
	<br>		
	<div class="block_header"><h2><?=lang('booking_services')?></h2></div>
	<table class="tour_accom">
		<thead>
			<tr>
				<th width="40%" align="left"><?=lang('services')?></th>
				<th width="20%"><?=lang('unit')?></th>
				<th width="20%"><?=lang('rate')?></th>
				<th width="15%"><?=lang('amount')?></th>
			</tr>
		</thead>
		<tbody>
			<!-- 
			<tr>
				<td colspan="4" class="table_service_title"><?=lang('accommodation')?></td>
			</tr>
			 -->
			<?php 
				$num_pax_calculated = $pax_accom_info['num_pax'];
						
				$is_group = isset($cruise) && is_group($cruise);
				
				$num_cabin = isset($cruise) ? $cruise['num_cabin'] : 0;
			?>
			<?php if ($tour['cruise_id'] > 0 && !is_private_tour($tour) && $num_cabin > 0): // cruise tour?>
			<?php foreach ($tour['accommodations'] as $accommodation):?>
				<?php foreach ($pax_accom_info['cabins'] as $key => $value):?>
				<tr>
					<td><?='Cabin '.$key?>: <?=$accommodation['name']?> <?=$value['arrangement']?></td>
					<td align="center" class="s_font">1</td>
					<td align="right" class="s_font">
						<?php 
							$promotion_price = get_cabin_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, $is_group, $value, true, $tour_children_price);
						?>
						<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
					</td>
					<td align="right" class="b_font price_total">
						<?=CURRENCY_SYMBOL?><?=number_format($promotion_price, CURRENCY_DECIMAL)?>
						<input type="hidden" id="accom_total" value="<?=$promotion_price?>">
						<input type="hidden" name="accommodation" value="<?=$accommodation['id']?>">
					</td>
				</tr>
				<?php endforeach;?>
			<?php endforeach;?>
			<?php else:?>
				<?php foreach ($tour['accommodations'] as $accommodation):?>
				<tr>
					<td><?=$accommodation['name']?></td>
					<td align="center"><label class="note_style"><?=$booking_info['guest']?></label></td>
					<td align="right" class="s_font">
						<?php 
							
							$total_price = get_total_tour_price($accommodation['prices'], $accommodation['promotion'], $num_pax_calculated, $is_group, $booking_info['adults'], $booking_info['children'], true);
							
						?>
						<?=CURRENCY_SYMBOL?><?=number_format($total_price, CURRENCY_DECIMAL)?>
					</td>
					<td align="right" class="b_font price_total">
						<?=CURRENCY_SYMBOL?><?=number_format($total_price, CURRENCY_DECIMAL)?>
						<input type="hidden" id="accom_total" value="<?=$total_price?>">
						<input type="hidden" name="accommodation" value="<?=$accommodation['id']?>">
					</td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
			<?php $num_pax = $booking_info['adults'] + $booking_info['children'];?>
			<?php if(count($tour['optional_services']['additional_charge']) > 0):?>
				<!-- 
				<tr>
					<td colspan="4" class="table_service_title"><?=lang('additional_charge')?></td>
				</tr>
				 -->
				<?php foreach ($tour['optional_services']['additional_charge'] as $charge):?>
					<tr>
						<td><?=$charge['name']?></td>
						<td width="10%" align="center" class="s_font">
							<?php if ($charge['charge_type'] == 1):?>
								<?=$num_pax?>
							<?php elseif ($charge['charge_type'] == 2):?>
								1
							<?php elseif ($charge['charge_type'] == -1):?>
								<label class="note_style"><?=$booking_info['guest']?></label>
							<?php endif;?>
						</td>
						<td align="right" class="s_font">
							<span>
							<?php if ($charge['charge_type'] != -1):?>
								<?=CURRENCY_SYMBOL?><?=number_format($charge['price'], CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=number_format($charge['price'], CURRENCY_DECIMAL)?>%
							<?php endif;?>
							</span>
						</td>
						<td align="right" class="b_font">
							<span class="price_total">
							<?php if($charge['total_price'] > 0):?>
								<?=CURRENCY_SYMBOL?><?=number_format($charge['total_price'], CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('no_charge')?>
							<?php endif;?>
							</span>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			
			<?php if(count($tour['optional_services']['transfer_services']) > 0):?>
				<!-- 
				<tr>
					<td colspan="4" class="table_service_title"><?=lang('transfer_services')?></td>
				</tr>
				 -->
				<?php foreach ($tour['optional_services']['transfer_services'] as $transfer):?>
					<tr>
						<td>
							<input type="hidden" name="optional_services[]" value="<?=$transfer['optional_service_id']?>">
							<?=$transfer['name']?>
						</td>
						<td width="10%" align="center" class="s_font">
							<label class="note_style"><?=$booking_info['guest']?></label>
						</td>
						<td align="right" class="s_font">
							<span>				
								<?php if ($transfer['charge_type'] != -1):?>
									<?=CURRENCY_SYMBOL?><?=number_format($transfer['price'], CURRENCY_DECIMAL)?>
								<?php endif;?>
							</span>
						</td>
						<td align="right" class="b_font">
							<span class="price_total">
							<?php if($transfer['total_price'] > 0):?>
								<?=CURRENCY_SYMBOL?><?=number_format($transfer['total_price'], CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('no_charge')?>
							<?php endif;?>
							</span>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			
			<?php if(count($tour['optional_services']['extra_services']) > 0):?>
				<!-- 
				<tr>
					<td colspan="4" class="table_service_title"><?=lang('extra_services')?></td>
				</tr>
				 -->
				<?php foreach ($tour['optional_services']['extra_services'] as $key => $extra):?>
					<tr>
						<td>
							<input type="hidden" name="optional_services[]" value="<?=$extra['optional_service_id']?>">
							<?=$extra['name']?>
						</td>
						<td width="10%" align="center">
							<?php if($extra['charge_type'] == 2):?>
								1
							<?php elseif($extra['charge_type'] == -1):?>
								<?=$num_pax?>
								<input type="hidden" id="charge_percent_<?=$extra['optional_service_id']?>" value="<?=$extra['price']?>">
							<?php elseif($extra['charge_type'] == 1):?>
								<?php $extra_service_pax = get_extra_service_pax($booking_info['extra_service_pax'], $extra['optional_service_id'])?>
								<?=$extra_service_pax?>
								<input type="hidden" name="extra_service_pax[]" value="<?=$extra['optional_service_id'].'_'.$extra_service_pax?>">
							<?php endif;?>
						</td>
						<td align="right">
							<span>			
							<?php if ($extra['charge_type'] != -1):?>
								<?=CURRENCY_SYMBOL?><?=number_format($extra['price'], CURRENCY_DECIMAL)?>				
							<?php else:?>
								<?=number_format($extra['price'], CURRENCY_DECIMAL)?>%
							<?php endif;?>
							</span>
						</td>
						<td align="right" class="b_font">
							<span class="price_total">
							<?php if($extra['total_price'] > 0):?>
								<?=CURRENCY_SYMBOL?><?=number_format($extra['total_price'], CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('no_charge')?>
							<?php endif;?>
							</span>
						</td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			<tr>
				<td align="right" colspan="3" class="total_block_text"><b><?=lang('total')?></b></td>
				<td align="right" class="price_span total_block price_total"><?=CURRENCY_SYMBOL?><?=number_format($tour['total_price'], CURRENCY_DECIMAL)?></td>
			</tr>
		</tbody>
	</table>
	<div class="block_header"><h2><?=lang('your_details')?></h2></div>
	<div class="content">
		<div class="items">
			<div class="col_1"><?=lang('full_name')?>: <?=mark_required()?></div>
			<div class="col_2">
			<?=form_error('full_name')?>
			<select name="title">
				<option value="1" <?=set_select('title', '1')?>>Mr</option>
				<option value="2" <?=set_select('title', '2')?>>Ms</option>					
			</select>&nbsp;
			<input type="text" name="full_name" size="40" maxlength="50" value="<?=set_value('full_name')?>" tabindex="1"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email')?><input type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>" tabindex="2"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address_confirm')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email_cf')?><input type="text" name="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" tabindex="3"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('phone_number')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('phone')?><input type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>" tabindex="4"/>&nbsp;&nbsp;&nbsp;
			<?=lang('fax_number')?>: <input type="text" name="fax" size="30" maxlength="30" value="<?=set_value('fax')?>" tabindex="5"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('country')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('country')?>
			 <select name="country" tabindex="6">
				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
				<?php foreach ($countries as $key => $country) :?>
				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
				<?php endforeach;?>
			</select>
			&nbsp;&nbsp;&nbsp;<?=lang('city')?>:&nbsp;<input type="text" name="city" size="30" maxlength="100" value="<?=set_value('city')?>" tabindex="7"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('special_requests')?>:</div>
			<div class="col_2"><textarea name="special_requests" cols="53" rows="5" tabindex="8"><?=set_value('special_requests')?></textarea></div>
		</div>						
		<div class="items item_button">
			<div class="col_1"><?=note_required()?></div>
			<div class="col_2" style="padding-bottom: 7px; *padding-top: 5px">
				<a class="g_button" href="javascript: void(0)" onclick="backStep()">
					<span style="font-weight: bold; padding: 5px 20px">Back</span>
				</a>&nbsp;
				<a class="d_button" href="javascript: void(0)" onclick="book()">
					<span class="submit_button"><?=lang('submit')?></span>
				</a>
			</div>
		</div>
	</div>
</div>
</div>
<input type="hidden" name="adults" value="<?=$booking_info['adults']?>">
<input type="hidden" name="children" value="<?=$booking_info['children']?>">
<input type="hidden" name="infants" value="<?=$booking_info['infants']?>">
<input type="hidden" name="departure_date" value="<?=$booking_info['departure_date']?>">
<input type="hidden" name="object_change" value="<?=$booking_info['object_change']?>">

<?php if ($tour['cruise_id'] > 0 && !is_private_tour($tour) && $num_cabin > 0): // cruise tour?>
	<input type="hidden" name="num_cabin" value="<?=$pax_accom_info['num_cabin']?>">
	
	<?php foreach ($pax_accom_info['cabins'] as $key => $cabin):?>
		
		<input type="hidden" name="type_<?=$key?>" value="<?=$cabin['type']?>">
		<input type="hidden" name="adults_<?=$key?>" value="<?=$cabin['adults']?>">
		<input type="hidden" name="children_<?=$key?>" value="<?=$cabin['children']?>">
		<input type="hidden" name="infants_<?=$key?>" value="<?=$cabin['infants']?>">
		
	<?php endforeach;?>
	
<?php endif;?>

</form>
<script>
function book(){
	document.frm.action_type.value = "book";
	document.frm.submit();	
}

function backStep() {
	document.frm.action = "<?=site_url().'tour-booking/'.$tour['url_title']?>.html";
	document.frm.submit();
}
</script>