<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="contentLeft">
	<div id="searchForm">
		<?=$tour_search_view?>
	</div>
    
    <?=$why_use?>
    
    <div class="clearfix" style="margin-bottom:10px"></div>
    
    <?=$booking_step?>
</div>
<form method="POST" name="frmMyBooking" action="/submit-booking/" style="float: right;">
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
				<?=lang('label_cart_empty')?>
			</div>
		</div>
	<?php else:?>
	
	<?=$progress_tracker?>
	
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
						<?php if(!empty($booking_item['start_date'])):?>	
							<?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date']))?>: <?=$booking_item['service_name']?>
						<?php else:?>
							<?=$booking_item['service_name']?>
						<?php endif;?>							
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
				<td colspan="3" class="total_block_text">
					<?php if(is_applied_promo_code()):?>
					<span class="floatL price" style="font-size: 12px; font-weight: normal; margin-left: 10px">
					<?=get_promo_code(true)?>
					</span>
					<?php endif;?>
					<?=lang('total_price')?>
				</td>
				<td class="price_span total_block">
					<label class="price_total" style="font-size: 12px;"><?=lang('price_unit').' '?></label>
					<label id="total_price" class="price_total">
						<?php if($booking_info['final_total'] > 0):?>
							<?=CURRENCY_SYMBOL?><?=number_format($booking_info['final_total'], 2)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>
					</label>
				</td>
			</tr>
			
		</tbody>
	</table>
	
	</div>
	
	
	<div class="clearfix" style="padding-top: 15px;"></div>
	 	
	<div class="block_header" style="margin: 0; margin-top: 15px;position: relative;">
		<h1 class="highlight" style="padding-top: 0;">
			<span class="icon icon-form-submit" style="margin-bottom: -12px"></span>
			<?=lang('your_information')?>
		</h1>
		
		<div class="geo_trust">
			<table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose GeoTrust SSL for secure e-commerce and confidential communications.">
            <tr>
            <td width="135" align="right" valign="top"><script type="text/javascript" src="https://seal.geotrust.com/getgeotrustsslseal?host_name=www.bestpricevn.com&amp;size=S&amp;lang=en"></script><br />
            <a href="http://www.geotrust.com/ssl/" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;"></a></td>
            </tr>
            </table>
		</div>
		
	</div>
	<div class="content">
		<div class="items" style="padding-left: 0">
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
		<div class="items" style="padding-left: 0">
			<div class="col_1"><?=lang('email_address')?>: <?=mark_required()?></div>
			<div class="col_2">
				<div class="clearfix">
				<?=form_error('email')?>
				</div>
				<div style="float: left;">
					<input type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>" tabindex="2"/>
				</div>
				
				<div style="font-size: 11px; float: left; padding-left: 10px;">
					<span style="color: red;">(*)&nbsp;</span>	
					<span style="position: absolute; width: 300px;"><?=lang('spam_email_notify')?></span>
				
				</div>	
			</div>
			
		</div>
		<div class="items" style="padding-left: 0">
			<div class="col_1"><?=lang('email_address_confirm')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email_cf')?><input type="text" name="email_cf" id="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" tabindex="3" autocomplete="off"/></div>
		</div>
		<div class="items" style="padding-left: 0; white-space: nowrap;">
			<div class="col_1"><?=lang('phone_number')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('phone')?><input type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>" tabindex="4"/>&nbsp;&nbsp;&nbsp;
			<?=lang('fax_number')?>: <input type="text" name="fax" size="30" maxlength="30" value="<?=set_value('fax')?>" tabindex="5"/></div>
		</div>
		<div class="items" style="padding-left: 0; white-space: nowrap;">
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
		<div class="items" style="padding-left: 0">
			<div class="col_1"><?=lang('special_requests')?>:</div>
			<div class="col_2"><textarea name="special_requests" cols="66" rows="5" tabindex="8"><?=set_value('special_requests')?></textarea></div>
		</div>						
		<div class="items item_button" style="padding-left: 0; padding-top: 10px;">
			<div class="col_1"><?=note_required()?></div>
			<div class="col_2" style="width: 540px">
			
				<div class="btn_back" onclick="go_url('<?=site_url('my-booking').'/'?>')" style="float: left; margin-right: 15px; margin-top: 2px">		
					<?=lang('back')?>
				</div>			
				
				<div class="btn_general btn_submit_booking" onclick="book()" style="float: left;">
					<?=lang('submit')?>
				</div>			
			</div>
		
		</div>
		
	</div>
	
	<?php endif;?>
</div>
</form>
<script>
function book(){
	document.frmMyBooking.action.value = "book";
	document.frmMyBooking.submit();	
}



$(document).ready(function(){
    $('#email_cf').bind("cut copy paste",function(e) {
        e.preventDefault();
    });

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