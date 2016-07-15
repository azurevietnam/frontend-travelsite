<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="contentLeft">
	<div id="searchForm">
		<?=$tour_search_view?>
	</div>
    
    <?=$why_use?>
    
    <div class="clearfix" style="margin-bottom:10px"></div>
    
    <?=$booking_step?>
</div>
<form method="POST" name="frmMyBooking" action="/my-booking/" style="float: right;">
<input type="hidden" name="action" value="">
<input type="hidden" name="rowid" value="">

<div style="display:none" id="free_visa_halong_content">
	<?=$popup_free_visa?>
</div>

<div id="contentMain">
	<?php if(empty($my_booking)):?>
		<div class="grayBox" style="padding: 15px">
			<h2 class="highlight" style="padding: 0"><span class="icon icon_green_cart"></span><?=lang('cart_empty')?></h2>
			<div style="margin: 20px 0 20px 23px;">
				<a class="continue-txt" href="<?=site_url()?>"><?=lang('continue_shopping')?></a>&nbsp;&nbsp;<span class="icon icon-arrow-right"></span>
			</div>
			<div class="empty-cart-info">
				<?=lang('my_booking_shopping_cart_empty') ?>
			</div>
		</div>
	<?php else:?>
	
	<?=$progress_tracker?>
	
	<div style="float: left;margin:0 0 10px; clear: both;">
			<span class="icon icon_arrow_left"></span> <a class="continue-txt" href="<?=site_url()?>"><?=lang('continue_shopping')?></a>
	</div>
	
	<div  id="your_booking" style="margin-bottom: 5px;">
	<table class="book_service_table">
		<thead>
			<tr>
				<th width="55%" align="center" class="highlight">
				<span class="icon cart_orange_icon" style="float: left; margin:2px 5px 0 5px"></span>
				<?=get_cart_item_text()?>
				<?=lang('services')?></th>
				<th width="20%" align="center" class="highlight"><?=lang('unit')?></th>
				<th width="10%" align="center" class="highlight"><?=lang('rate')?></th>
				<td width="15%" align="center" class="highlight"><b><?=lang('amount')?></b></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($my_booking as $key=> $booking_item):?>
				<tr>
					<td class="highlight" style="padding-left: 10px; font-weight: bold;">					
					
						<img id="<?=$booking_item['rowid'].'_img_booking'?>" onclick="show_booking('<?=$booking_item['rowid']?>')" src="/media/btn_mini_hover.gif" style="cursor: pointer;margin-bottom: -1px;">
												
						<a href="javascript:void(0)" onclick="show_booking('<?=$booking_item['rowid']?>')">					
							<?php if(!empty($booking_item['start_date'])):?>	
								<?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date']))?>: <?=$booking_item['service_name']?>
							<?php else:?>
								<?=$booking_item['service_name']?>
							<?php endif;?>		
						</a>
						
					</td>
					
					<td align="center" class="note_style">
						
						<b><?=$booking_item['unit']?></b>
						
					</td>
					
					<td align="right"></td>
					
					<td class="bg_whiteSmoke price_span" align="right">
						<div class="price_total" style="display: none" id="<?=$booking_item['rowid'].'_booking_total'?>">
							<?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'] + $booking_item['discount'], CURRENCY_DECIMAL)?>
						</div>
					</td>
				</tr>
				
				<tbody id="<?=$booking_item['rowid'].'_booking_content'?>">
				
				<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
					
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
							<div class="note_style"><?=$detail_booking_item['unit']?><?php if(isset($detail_booking_item['unit_text'])):?><?=$detail_booking_item['unit_text']?><?php endif;?></div>
						</td>
						
						<td align="right" class="price_span">
							<?php if($detail_booking_item['rate'] != '$0'):?>
								<div><?=$detail_booking_item['rate']?></div>
							<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>
								<div><?=$detail_booking_item['rate']?></div>
							<?php else:?>
								<div><?=lang('na')?></div>
							<?php endif;?>
						</td>
						
						<td align="right" class="bg_whiteSmoke price_span">
							<div class="price_total">
								<?php if($detail_booking_item['amount'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($detail_booking_item['amount'], CURRENCY_DECIMAL)?>
								<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>
									<span><?=lang('no_charge')?></span>
								<?php else:?>
									<span><?=lang('na')?></span>
								<?php endif;?>
							</div>
						</td>
						
					</tr>
				
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
				
				<tr>
					<td colspan="1" class="padding_left_20" style="font-weight: bold;">						
						<a class="function" href="javascript:void(0)" onclick="remove_booking('<?=$booking_item['rowid']?>')"><?=lang('remove_item')?></a>
					</td>
					
					<?php if(count($my_booking) > 1):?>
						<td colspan="2" align="right" style="padding-right: 18px;"><b><?=lang('subtotal')?></b>&nbsp;</td>
						
						<td align="right" class="price_span bg_whiteSmoke">
							<label class="price_total">
								<?php if($booking_item['total_price'] + $booking_item['discount'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'] + $booking_item['discount'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</label>
						</td>
					<?php else:?>
						<td colspan="2" align="right">&nbsp;</td>
						<td align="right" class="bg_whiteSmoke">							
						</td>
					<?php endif;?>
				</tr>
				
				</tbody>
				
				<tr><td colspan="4" style="border-bottom: 1px solid #CCC;"></td></tr>
				
			<?php endforeach;?>
			
			
			
			<?php if($booking_info['discount'] > 0):?>
			<tr>
				<td align="right" colspan="3" class="total_block_text" style="font-weight: normal; background-color: #fff;font-size: 11px"><?=lang('book_seperate')?></td>
				<td align="right" class="bg_whiteSmoke price_span">
					<div style="font-weight: bold;"><?=CURRENCY_SYMBOL?><?=number_format($booking_info['total_price'], CURRENCY_DECIMAL)?></div>
				</td>
			</tr>
			<tr>
				<td align="right" colspan="3" class="total_block_text" style="background-color: #fff;font-size: 11px"><?=lang('discount_together')?></td>
				<td align="right" class="bg_whiteSmoke price_span">
				<div class="price_total">- <?=CURRENCY_SYMBOL?><?=number_format($booking_info['discount'], CURRENCY_DECIMAL)?></div>
				</td>
			</tr>
			<?php endif;?>
			
			<?php if(!empty($booking_info['gift_voucher'])):?>
				
				<tr>
					<td align="right" colspan="3" class="total_block_text" style="background-color: #fff;font-size: 11px"><?=lang('gift_voucher_discount')?></td>
					<td align="right" class="bg_whiteSmoke price_span">
					<div class="price_total">- <?=CURRENCY_SYMBOL?><?=number_format($booking_info['gift_voucher'], CURRENCY_DECIMAL)?></div>
					</td>
				</tr>
				
			<?php endif;?>
			
			<tr>
				<td colspan="2" class="total_block_text">
					<span class="floatL" style="margin-left: 10px; <?php if(is_applied_promo_code()) echo 'padding-top:6px'?>">
						<label class="floatL" style="font-size: 12px; font-weight: normal; margin-right: 5px">Promotion code (optional):</label>
						<input class="floatL" name="promo_code" id="promo_code" type="text" placeholder="Promotion Code" value="" size="20" maxlength="6">
						<span class="btn_general btn_submit_booking" onclick="apply_promo_code()" 
							style="font-size: 12px; width: 60px; float: left; margin-left: 10px; padding: 0px; border: 0">
							Apply
						</span>
						<span id="promo_board" class="price" style="font-size: 12px; font-weight: normal; float: left;clear: both;">
						<?php if(is_applied_promo_code()):?>
						<?=get_promo_code(true)?>
						<?php endif;?>
						</span>
					</span>
				</td>
				<td class="total_block_text" nowrap="nowrap">
					<?=lang('total_price')?>
				</td>
				<td class="price_span total_block">
					<label class="price_total" style="font-size: 12px;"><?=lang('price_unit').' '?></label>
					<label id="total_price" class="price_total">
						<?php if($booking_info['final_total'] > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($booking_info['final_total'], CURRENCY_DECIMAL)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>
					</label>
				</td>
			</tr>
		</tbody>
	</table>
	
	</div>
	
	<div style="width: 100%; float: left;">	
		
		<?php if(!$is_allow_online_visa_payment):?>
			<div class="btn_general btn_submit_booking" style="float: left;margin-top:5px;margin-left:10px" onclick="go_url('<?=site_url('submit-booking').'/'?>')">
				<?=lang('submit_booking')?>
			</div>
		<?php else:?>		
			
			<div class="btn_general btn_pay" style="float: left;margin-top:5px; font-size: 16px; width: auto;" onclick="go_url('<?=site_url('vietnam-visa/payment.html')?>')">
				<?=lang('proceed_checkout')?>
			</div>
			
		<?php endif;?>
		
		<a class="function" href="javascript:void(0)" onclick="empty()" style="float: right;"><?=lang('empty_booking')?></a>
	</div>
	
	<div class="clearfix" style="padding-top: 15px;"></div>
	
	<div style="margin-top: 5px;">
		<?=$recommendation_view?>
	</div>
	
	<?php endif;?>
</div>
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


function apply_promo_code(){
	var promo_code = $('#promo_code').val();
	if(promo_code.length > 0){	
		$.ajax({
			url: "/my-booking/apply_promo_code/",
			type: "POST",
			data: {
				"promo_code":promo_code
			},
			success:function(value){
				if(value  == -1){
					alert("<?=lang('promo_code_invalid')?>");
				} else if(value  == -2){
					alert("<?=lang('promo_voucher_fail_condition')?>");
				} else {
					$("#promo_board").html(value);
					window.location = '<?=site_url().'my-booking/'?>';
				}
			}
		});
	}
}


$(document).ready(function(){
   
    <?php foreach ($my_booking as $key=> $booking_item):?>
    	<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>

    		<?php if($detail_booking_item['service_desc'] != ''):?>

			<?php 
				$detail_booking_item['service_desc'] = str_replace("\n", "<p>", $detail_booking_item['service_desc']);
			?>
			
    		$('#<?=$booking_item['rowid'].'_'.$detail_booking_item['service_id'].'_desc'?>').tipsy({fallback: "<?=$detail_booking_item['service_desc']?>", gravity: 's', width: '250px', title: "<?=$detail_booking_item['service_name']?>"});
			
    		<?php endif;?>
    	
		<?php endforeach;?>
    <?php endforeach;?>
 });
</script>