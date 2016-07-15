<form method="POST" name="frmMyBooking" action="<?=get_page_url(MY_BOOKING_PAGE)?>">
<input type="hidden" name="action" value="">
<input type="hidden" name="rowid" value="">

<table class="table table-hover tbl-extra-services">
	<thead>
		<tr class="bgr-header-table" >
			<th width="55%" align="center" class="highlight">
				<span class="text-special">
					<span class="glyphicon glyphicon-shopping-cart"></span>
					<?=get_cart_item_text()?>
				</span>			
				<?=lang('services')?>
			</th>			
			<th width="20%" class="text-center highlight"><?=lang('unit')?></th>
			<th width="10%" class="text-center highlight"><?=lang('rate')?></th>
			<td width="15%" class="text-center highlight"><b><?=lang('amount')?></b></td>
		</tr>
	</thead>
			
			<?php foreach ($my_bookings as $key=> $booking_item):?>
								
					<tr class="table-border-top">
						<th class="text-highlight">			
							<?php if($is_my_booking_page):?>
								<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="/media/btn_mini_hover.gif" class="tbl-icon">						
								<a href="javascript:void(0)" onclick="show_booking('<?=$booking_item['rowid']?>')">					
									<?=show_service_item($booking_item)?>		
								</a>
							<?php else:?>
								<?=show_service_item($booking_item)?>
							<?php endif;?>							
						</th>
						
						<th align="center" class="none-style text-center">						
							<b><?=$booking_item['unit']?></b>						
						</th>
						
						<th align="right"></th>
						
						<th class="text-right text-price bgr-whiteSmoke">
							<div class="price_total" style="display: none" id="<?=$booking_item['rowid'].'_booking_total'?>">
								<?=show_usd_price($booking_item['total_price'] + $booking_item['discount'])?>
							</div>
						</th>
					</tr>				
				
				<tbody id="<?=$booking_item['rowid'].'_booking_content'?>">				
				<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
					<tr>
						<td>
							<div class="margin-left-20 border-dashed">
								<?=$detail_booking_item['service_name']?>
								<?php if($detail_booking_item['service_desc'] != ''):?>
									<span id="<?=$booking_item['rowid'].'_'.$detail_booking_item['service_id'].'_desc'?>" class="icon icon-help"></span>
								<?php endif;?>
							</div>
						</td>
						
						<td align="center" class="none-style">
							<div class="border-dashed">
								<?=$detail_booking_item['unit']?><?php if(isset($detail_booking_item['unit_text'])):?><?=$detail_booking_item['unit_text']?><?php endif;?>
							</div>
						</td>
												
						<td align="right"">
							<div class="border-dashed">
								<?php if($detail_booking_item['rate'] != '$0'):?>
									<div><?=$detail_booking_item['rate']?></div>
								<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>
									<div><?=$detail_booking_item['rate']?></div>
								<?php else:?>
									<div><?=lang('na')?></div>
								<?php endif;?>
							</div>
						</td>
						
						<td align="right" class="text-price bgr-whiteSmoke ">
							<div class="border-dashed">
								<?php if($detail_booking_item['amount'] > 0):?>
									
									<?=show_usd_price($detail_booking_item['amount'])?>
									
								<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>
									<span><?=lang('no_charge')?></span>
								<?php else:?>
									<span><?=lang('na')?></span>
								<?php endif;?>
							</div>
						</td>
						
					</tr>
				
				<?php endforeach;?>
				
				<?php if(has_special_offers($booking_item)):?>
					<tr style="background-color: #fff">
						<td class="text-special">
							<div class="padding-left-20">
								<?=$booking_item['special_offers']?>							
								<?=$booking_item['free_visa_content']?>
							</div>
						</td>
						<td colspan="2">&nbsp;</td>
						<td class="bgr-whiteSmoke"></td>
					</tr>
				<?php endif;?>
				<?php if($is_my_booking_page):?>
				
					<tr>
						<td colspan="1" style="font-weight: bold;">
							<a class="function padding-left-20" href="javascript:void(0)" onclick="remove_booking('<?=$booking_item['rowid']?>')"><span class="glyphicon glyphicon-remove"></span>&nbsp;<?=lang('remove_item')?></a>
						</td>
						
						<?php if(count($my_bookings) > 1):?>
							<td colspan="2" align="right" style="padding-right: 18px;"><b><?=lang('subtotal')?></b>&nbsp;</td>
							
							<td align="right" class="text-price bgr-whiteSmoke">
								<label>
									<?php if($booking_item['total_price'] + $booking_item['discount'] > 0):?>
										<?=show_usd_price($booking_item['total_price'] + $booking_item['discount'])?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
								</label>
							</td>
						<?php else:?>
							<td colspan="2" align="right">&nbsp;</td>
							<td align="right" class="bgr-whiteSmoke">							
							</td>
						<?php endif;?>
					</tr>
				
				<?php endif;?>
				
				</tbody>
				
			<?php endforeach;?>
			
			<?php if($booking_info['discount'] > 0):?>
			<tr class="table-border-top">
				<td align="right" colspan="3" class="discount-txt"><?=lang('book_seperate')?></td>
				<td align="right" class="text-price bgr-whiteSmoke">
					<div class="margin-bottom-5" style="font-weight: bold;">
						<?=show_usd_price($booking_info['total_price'])?>
					</div>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3" class="discount-txt"><b><?=lang('discount_together')?></b></td>
				<td align="right" class="text-price bgr-whiteSmoke">
				<div class="margin-bottom-5">- <?=show_usd_price($booking_info['discount'])?></div>
				</td>
			</tr>
			<?php endif;?>
			
			<tr>
				 
				<td colspan="2" class="bgr-header-table"></td>
				 
				<td class="bgr-header-table" style="font-size: 16px;" nowrap="nowrap">
					<b><?=lang('total_price')?></b>
				</td>
				<td class="text-price text-right bgr-header-table" style="font-size: 16px;">
					<div class="margin-bottom-5">
						<b><?=lang('price_unit').' '?></b>
						<b id="total_price">
							<?php if($booking_info['final_total'] > 0):?>
								<?=CURRENCY_SYMBOL?><?=number_format($booking_info['final_total'], CURRENCY_DECIMAL)?>
							<?php else:?>
								<?=lang('na')?>
							<?php endif;?>
						</b>
					</div>
				</td>
			</tr>
		
	</table>
</form>

<script type="text/javascript">

function empty(){
	if (confirm("<?=lang('empty_booking_confirm')?>")) {
		document.frmMyBooking.action.value = "empty";
		document.frmMyBooking.submit();
	}
}

function remove_booking(rowid){

	if (confirm("<?=lang('remove_item_confirm')?>")) {
		
		document.frmMyBooking.action.value = "delete";
	
		document.frmMyBooking.rowid.value = rowid;
		
		document.frmMyBooking.submit();

	}
}
						
</script>