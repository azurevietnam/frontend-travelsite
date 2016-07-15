<form method="POST" name="frmMyBooking" action="<?=get_page_url(MY_BOOKING_PAGE)?>">
<input type="hidden" name="action" value="">
<input type="hidden" name="rowid" value="">

<table class="table table-hover tbl-extra-services">
		<thead>
			<tr>
				<th width="80%">
						
					<?=lang('services')?>
					
					<span class="text-special">
						<span class="glyphicon glyphicon-shopping-cart"></span>
						<?=get_cart_item_text()?>
					</span>		
				</th>			
				<th width="20%" class="text-right"><b><?=lang('amount')?></b></th>
			</tr>
		</thead>
		
			<?php foreach ($my_bookings as $key=> $booking_item):?>
									
					<tr class="table-border-top booking-items">
						<th class="text-highlight">			
							<?php if($is_my_booking_page):?>
								<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="/media/btn_mini_hover.gif" class="tbl-icon">						
								<a href="javascript:void(0)" onclick="show_booking('<?=$booking_item['rowid']?>')">					
									<?=show_service_item($booking_item)?>
									<small>(<?=$booking_item['unit']?>)</small>	
								</a>
							<?php else:?>
								<?=show_service_item($booking_item)?>
								<small>(<?=$booking_item['unit']?>)</small>
							<?php endif;?>							
						</th>
			
						<th class="text-right">
							<span class="text-price" style="display: none" id="<?=$booking_item['rowid'].'_booking_total'?>">
								<?=show_usd_price($booking_item['total_price'] + $booking_item['discount'])?>
							</span>
						</th>
					</tr>				
				
				
				<tbody id="<?=$booking_item['rowid'].'_booking_content'?>">				
				<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
					<tr>
						<td class="border-dashed">
							<?=$detail_booking_item['service_name']?>
							<small>(<?=$detail_booking_item['unit']?><?php if(isset($detail_booking_item['unit_text'])):?><?=$detail_booking_item['unit_text']?><?php endif;?>)</small>
						</td>
					
						<td align="right" class="text-price border-dashed">
							<?php if($detail_booking_item['amount'] > 0):?>
							
								<?=show_usd_price($detail_booking_item['amount'])?>
								
							<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>
								<span><?=lang('no_charge')?></span>
							<?php else:?>
								<span><?=lang('na')?></span>
							<?php endif;?>
						</td>
						
					</tr>
				
				<?php endforeach;?>
				
				<?php if(has_special_offers($booking_item)):?>
					<tr>
						<td colspan="2">
							<?=$booking_item['special_offers']?>						
							<?=$booking_item['free_visa_content']?>
						</td>
					</tr>
			
				<?php endif;?>
				
				<?php if($is_my_booking_page):?>
					<tr>
						<td colspan="2">
							<div class="btn btn-default btn-sm margin-bottom-10" onclick="remove_booking('<?=$booking_item['rowid']?>')">
								<span class="glyphicon glyphicon-remove"></span>&nbsp;<?=lang('remove_item')?>	
							</div>
						</td>
					</tr>
				
					<?php if(count($my_bookings) > 1):?>
					<tr>
						<td align="right" style="padding-right: 18px;"><b><?=lang('subtotal')?></b>&nbsp;</td>
						<td align="right" class="text-price bgr-whiteSmoke">
								<label>
									<?php if($booking_item['total_price'] + $booking_item['discount'] > 0):?>
										
										<?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'] + $booking_item['discount'], CURRENCY_DECIMAL)?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
								</label>
						</td>
					</tr>	
					<?php endif;?>
				<?php endif;?>
				
				</tbody>
				
			<?php endforeach;?>
			
			<?php if($booking_info['discount'] > 0):?>
			<tr class="table-border-top">
				<td align="right"><?=lang('book_seperate')?></td>
				<td align="right" class="text-price">
				
					<div class="margin-bottom-5" style="font-weight: bold;">
						<?=show_usd_price($booking_info['total_price'])?>
					</div>
				
				</td>
			</tr>
			<tr>
				<td align="right"><b><?=lang('discount_together')?></b></td>
				<td align="right" class="text-price">
					<div class="margin-bottom-5">- <?=show_usd_price($booking_info['discount'])?></div>
				</td>
			</tr>
			<?php endif;?>
			
			<tr> 
				<td class="bgr-header-table" style="font-size: 15px;" nowrap="nowrap">
					<b><?=lang('total_price')?></b>
				</td>
				<td class="text-price text-right bgr-header-table" style="font-size: 15px;">
					<div class="margin-bottom-5">
						<b><?=lang('price_unit').' '?></b>
						<b id="total_price">
							<?php if($booking_info['final_total'] > 0):?>
								<?=show_usd_price($booking_info['final_total'])?>
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