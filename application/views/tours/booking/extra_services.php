<?php if(!empty($booking_items)):?>
    <?php 
        $page_url = isset($tour) ? get_page_url(TOUR_ADD_CART_PAGE, $tour, $parent_id) : get_page_url(HOTEL_ADD_CART_PAGE, $hotel, $parent_id);
    ?>
	<form name="frm_extra_services" method="post" action="<?=$page_url?>">
	<table class="table table-hover tbl-extra-services">
      <thead>
        <tr>
          <th width="55%"><?=lang('services')?></th>
          <th width="20%" class="text-center"><?=lang('unit')?></th>
          <th width="10%" class="text-center"><?=lang('rate')?></th>
          <th width="15%" class="text-center"><?=lang('amount')?></th>
        </tr>
      </thead>
      
      <?php foreach ($booking_items as $key => $booking_item):?>
      	<?php 
      		$is_show = $key == count($booking_items) - 1;
      		$img_toggle_src = $is_show ? '/media/btn_mini_hover.gif' : '/media/btn_mini.gif';
      		$optional_services = $booking_item['optional_services'];
      		if(!empty($booking_item['check_rates'])){
	      		$check_rates = $booking_item['check_rates'];
	      		$num_pax = $check_rates['adults'] + $check_rates['children'] + $check_rates['infants'];
      		} else {
				$booking_info = $booking_item['booking_info'];
				$num_pax = $booking_info['adults'] + $booking_info['children'] + $booking_info['infants'];
			}
      	?>
      		
      	<tr class="table-border-top booking-items" rowid="<?=$booking_item['rowid']?>">
      		<th>
      			<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="<?=$img_toggle_src?>" style="cursor: pointer; margin-bottom: 2px; margin-right: 5px;">
      			<a href="javascript:void(0)" onclick="show_booking('<?=$booking_item['rowid']?>')">
					<?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date']))?>: <?=$booking_item['service_name']?>
				</a>	
      		</th>
      		
      		<th class="text-center none-style">
      			<?=$booking_item['unit']?>
      		</th>
      		
      		<th></th>
      		
      		<td class="bgr-whiteSmoke text-right">
      			<span class="text-price" <?php if ($is_show):?> style="display: none"<?php endif;?>" id="<?=$booking_item['rowid'].'_booking_total'?>">
					<?=show_usd_price($booking_item['total_price'])?>
				</span>
					
      		</td>
      		
      	</tr>
      	
      	
      	<tbody id="<?=$booking_item['rowid'].'_booking_content'?>" <?php if(!$is_show):?>style="display: none;"<?php endif;?>>
      		
      		<?php 
				$total_accomodation = 0;
			?>
			
			<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
				<?php if($detail_booking_item['reservation_type'] == RESERVATION_TYPE_NONE || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_ADDITONAL_CHARGE):?>
				<tr class="">
					<td>
						<div class="margin-left-20 border-dashed">
							<?=$detail_booking_item['service_name']?>
						</div>
						
						<?php if($detail_booking_item['service_desc'] != ''):?>
							<div class="border-dashed">
								<span id="<?=$booking_item['rowid'].'_'.$detail_booking_item['service_id'].'_desc'?>" class="icon icon-help"></span>
							</div>	
						<?php endif;?>
					</td>
					
					<td class="text-center none-style">
						<div class="border-dashed">
							<?=$detail_booking_item['unit']?>	
						</div>
					</td>
					
					<td class="text-right">
						<div class="border-dashed">
							<?=($detail_booking_item['rate'] != '$0' ? $detail_booking_item['rate']: lang('na'))?>
						</div>
					</td>
					
					<td class="text-right bgr-whiteSmoke">
						<div class="text-price border-dashed">
							<?php if($detail_booking_item['amount'] > 0):?>
								<?=show_usd_price($detail_booking_item['amount'])?>
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
			
			<!-- Show Promotion & Free Visa HERE -->
			
			<?php if(has_special_offers($booking_item)):?>
			
			<tr style="background-color: #fff;">
				<td>
					<div class="padding-left-20">
						<?=$booking_item['special_offers']?>						
						<?=$booking_item['free_visa_content']?>
					</div>	
				</td>
				<td colspan="2">
					
				</td>
				<td class="bgr-whiteSmoke">	
				</td>
			</tr>
			
			
			<?php endif;?>
      		
      		<input type="hidden" id="<?=$booking_item['rowid'].'_total_accommodation'?>" value="<?=$total_accomodation?>">
      		
      		<!-- Tranfer Services -->
      		<?php if(!empty($optional_services['transfer_services'])):?>
      			
      			<tr style="background-color: #fff;">
					<td colspan="3" class="text-unhighlight"><label><?=lang('transfer_services')?> (<?=lang('lbl_optional')?>)</label></td>
					<td class="bgr-whiteSmoke"></td>
				</tr>
				
      			<?php foreach ($optional_services['transfer_services'] as $transfer):?>
      				
      				<?php if(!is_suitable_service($transfer, $check_rates)) continue;?>
		
      				<tr>
						<td>							
							<?php 
								
								$rowid = '"'.$booking_item['rowid'] . '"';
																
								$amount = '"'.$transfer['total_price'].'"';
								
								$service_id = '"'.$transfer['optional_service_id'].'"';
								
							?>
						
							<div class="checkbox margin-left-20 border-dashed"> 
								<label>
									<input style="margin-top: 1px;" type="checkbox" name="<?=$booking_item['rowid']?>_optional_services[]" onclick='select_optional_service(this, <?=$rowid?>, <?=$service_id?>, <?=$amount?>)' 
									value="<?=number_format($transfer['total_price'], CURRENCY_DECIMAL)?>" <?php if($transfer['is_booked']==1) echo('checked="true"'); ?>>
									
									<?php if(!empty($transfer['url'])):?>
										<a href="<?=$transfer['url']?>" target="_blank"><?=$transfer['name']?></a>
									<?php else:?>
										<?=$transfer['name']?>
									<?php endif;?>
								
									<?php if($transfer['description'] != ''):?>
										
										<?php 
											$ops_id = $booking_item['rowid'].'_'.$transfer['optional_service_id'].'_desc';
										?>
										<span class="glyphicon glyphicon-question-sign" data-title="<?=$transfer['name']?>" data-target="#<?=$ops_id?>"></span>
										
										<span style="display:none" id="<?=$ops_id?>">
											<?=$transfer['description']?>
										</span>
										
									<?php endif;?>
								
								</label>
								
							</div>
							
							<input type="hidden" id="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_selected'?>" name="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_selected'?>" value="<?=$transfer['is_booked']?>">
							
						</td>
						<td style="vertical-align: middle;" class="none-style" align="center">
							<div class="border-dashed">
								<?=$transfer['unit']?>
							</div>											
						</td>
						<td style="vertical-align: middle;" class="text-right" align="center">							
								<div class="border-dashed">
									<?=$transfer['rate']?>	
								</div>											
						</td>
						<td align="right" class="bgr-whiteSmoke">
							<div class="text-price border-dashed" id="<?=$booking_item['rowid'].'_'.$transfer['optional_service_id'].'_total'?>"  <?php if($transfer['is_booked']):?><?php endif;?>>
								<?=$transfer['amount']?>								
							</div>
						</td>
					</tr>

      			<?php endforeach;?>	
      			
      		<?php endif;?>
      		
      		<!-- Extra Services -->
      		<?php if(!empty($optional_services['extra_services'])):?>
      			
      			<tr style="background-color: #fff;">
					<td colspan="3" class="text-unhighlight"><label><?=lang('extra_services')?></label></td>
					<td class="bgr-whiteSmoke"></td>
				</tr>
      			
      			<?php foreach ($optional_services['extra_services'] as $extra):?>
      				
      				<?php 
							
						$rowid = '"'.$booking_item['rowid'] . '"';			
						
						$rate = '"'.$extra['rate'].'"';
						
						$amount = '"'.$extra['total_price'].'"';
						
						$service_id = '"'.$extra['optional_service_id'].'"';
						
						$is_visa = strpos($extra['name'], 'Visa') !== FALSE;
						
					?>
							
					<tr valign="middle">
						<td>
							<div class="checkbox margin-left-20 border-dashed">
								<label>
								<input style="margin-top: 0px;" type="checkbox" name="<?=$booking_item['rowid']?>_optional_services[]" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_checkbox'?>" onclick='select_optional_service(this, <?=$rowid?>, <?=$service_id?>, <?=$amount?>)' 
									value="<?=number_format($extra['total_price'], CURRENCY_DECIMAL)?>"  <?php if($extra['is_booked']==1) echo('checked="true"'); ?>>
								
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
										$ops_id = $booking_item['rowid'].'_'.$extra['optional_service_id'].'_desc';
									?>
									<span class="glyphicon glyphicon-question-sign" data-title="<?=$extra['name']?>" data-target="#<?=$ops_id?>"></span>
									
									<span style="display:none" id="<?=$ops_id?>">
										<?=$extra['description']?>
									</span>
									
								<?php endif;?>
								
								</label>
							</div>
							<input type="hidden" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_selected'?>" name="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_selected'?>" value="<?=$extra['is_booked']?>">
						</td>
						
						<td class="text-center none-style" style="vertical-align: middle;">	
							<div class="border-dashed">	
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
						<td class="text-right" style="vertical-align: middle;">						
								<div class="border-dashed"><?=$extra['rate']?></div>
						</td>
						<td align="right" class="bgr-whiteSmoke">
							<div class="border-dashed" id="<?=$booking_item['rowid'].'_'.$extra['optional_service_id'].'_total'?>" <?php if($extra['is_booked']):?>class="text-price"<?php endif;?>>
								<?=$extra['amount']?>							
							</div>
						</td>
					</tr>
					
 			<?php endforeach;?>	
      			
      		<?php endif;?>
      		
      		
      		<?php if(count($booking_items) > 1):?> 
				<tr>
					<td>
						<?php if($key > 0):?>
							<a class="function padding-left-20" href="javascript:void(0)" onclick="remove_item('<?=$booking_item['rowid']?>')">								
								<span class="glyphicon glyphicon-remove"></span> <?=lang('remove_item')?>
							</a>
						<?php else:?>
							&nbsp;
						<?php endif;?>
					</td>
					<td colspan="2" align="right"><b><?=lang('subtotal')?></b></td>
					<td  class="bgr-whiteSmoke text-right">
						<div class="text-price">
							<label id="<?=$booking_item['rowid'].'_total_display'?>">
								<?php if($booking_item['total_price'] > 0):?>
									<?=show_usd_price($booking_item['total_price'])?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</label>
						</div>
					</td>					
				</tr>
			<?php endif;?>
      	</tbody>
      	
      <?php endforeach;?>
      
      <?php if($booking_total['discount'] > 0):?>
		
		<tr class="table-border-top">
			<td align="right" colspan="3" class="discount-txt"><?=lang('book_seperate')?></td>
			<td class="bgr-whiteSmoke text-right">
				<div class="text-price margin-bottom-5" id="total_book_seperate" >
					<?=show_usd_price($booking_total['total_price'])?>
				</div>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="3" class="discount-txt"><b><?=lang('discount_together')?></b></td>
			<td align="right" class="bgr-whiteSmoke">
				<div class="text-price margin-bottom-5">- <?=show_usd_price($booking_total['discount'])?></div>			
				<input type="hidden" id="discount_booking_together" value="<?=$booking_total['discount']?>">
			</td>
		</tr>
		<?php endif;?>
		
		
		<tr >
			<td class="bgr-header-table" align="right" colspan="3" style="font-size: 15px;"><b><?=lang('total_price')?></b></td>
			<td class="bgr-header-table" align="right" style="font-size: 15px;">
				<div class="margin-bottom-5">
					<b class="text-price"><?=lang('price_unit').' '?></b>
					<b id="final_total" class="text-price">
						<?=show_usd_price($booking_total['final_total'])?>
					</b>
				</div>
			</td>
		</tr>	
    </table>
    
    </form>
    
    <div class="text-right">
		<?=lang('next_bellow')?>
		<span class="glyphicon glyphicon-circle-arrow-down text-special" style="cursor:pointer; margin-bottom: 2px; margin-right: 5px;" onclick="go_bottom()"></span>
	</div>
	
	<?php $booking_page = isset($tour) ? get_page_url(TOUR_BOOKING_PAGE, $tour) : get_page_url(HOTEL_BOOKING_PAGE, $hotel) ?>
	<form name="frm_delete_item" method="POST" action="<?=$booking_page?>">
		<input type="hidden" name="action" value="">
		<input type="hidden" name="rowid" value="">
	</form>
	
	
<?php endif;?>

<script type="text/javascript">

	function remove_item(rowid){
		if (confirm("<?=lang('remove_item_confirm')?>")) {
			document.frm_delete_item.action.value = '<?=ACTION_DELETE?>';
			document.frm_delete_item.rowid.value = rowid;
			document.frm_delete_item.submit();	
		}
	}


	function next_step() {
		document.frm_extra_services.submit();
	}
									
	update_booking_total();
	set_help('.glyphicon-question-sign');
					
</script>