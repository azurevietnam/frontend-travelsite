<html>
<head>
</head>
<body style="font-family: Arial; font-size:12px;">

<div style="width:720px;">
    <p><?=lang('booking_email_dear', $cus['title_text'] . '. ' . $cus['full_name'])?>
    
    <p>
    	<?=lang('booking_email_request_submited')?>
    	<a href="<?=site_url()?>">www.<?=strtolower(SITE_NAME)?></a>
    	<?=lang('booking_email_one_of_out_travel_consultants')?>
    </p>
    
    <p>
    	<?php 
    		$email_reservation = '<a target="_blank" href="mailto:reservation@'.strtolower(SITE_NAME).'">reservation@'.strtolower(SITE_NAME).'</a>';
    	?>
    	
    	<?=lang('booking_email_note').' '.$email_reservation.'.'?>
    </p>
    
    <label style="font-size: 14px;font-weight: bold;"><?=lang('booking_email_please_review')?>:</label>
</div>

<table style="width:700px; border-spacing:3px;font-family: Arial; font-size:12px;">
	<tr>
    	<td colspan="2">
        <label style="font-size:13px; font-weight:bold; color:#36C"><?=lang('booking_email_your_contact')?></label>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    <tr>
        <td style="padding-left: 30px;width: 30%"><b><?=lang('full_name') ?>:</b></td>
        <td width="70%"><?=$cus['title_text'] . '. ' . $cus['full_name']?></td>
    </tr>
    <tr>
        <td style="padding-left: 30px;width: 30%"><b><?=lang('email') ?>:</b></td>
        <td width="70%"><?=$cus['email']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px;width: 30%"><b><?=lang('phone_number') ?>:</b></td>
        <td width="70%"><?=$cus['phone']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px;width: 30%"><b><?=lang('country') ?>:</b></td>
        <td width="70%"><?=$cus['country_name']?></td>
    </tr>
    <tr>
    	<td colspan="2">
        <br>
        <label style="font-size:13px; font-weight:bold; color:#36C"><?=lang('booking_email_your_booking_information') ?></label>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>

    <tr>
        <td style="padding-left: 30px;width: 30%"><b><?=lang('departure_date') ?>:</b></td>
        <td width="70%" style="color: #F60;"><?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($customer_booking['start_date']))?></td>
    </tr>
    <tr>
        <td style="padding-left: 30px;width: 30%"><b>End Date:</b></td>
        <td width="70%" style="color: #F60;"><?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($customer_booking['end_date']))?></td>
    </tr>
    <tr>
    	<td colspan="2">
        <br>
        <label style="font-size:13px; font-weight:bold; color:#36C"><?=lang('booking_email_your_reservation_detail') ?></label>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    <tr>
    	<td colspan="2">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border: 1px solid #ccc;font-family: Arial; font-size:12px;width: 650px">
				<thead style="font-size: 110%;font-weight: bold;">
					<tr>
						<th width="55%" style="background-color: #F0F0F0;padding: 5px 5px; line-height: 23px;color:#003580;"><?=lang('services') ?></th>
						<th width="15%" style="background-color: #F0F0F0;padding: 5px 5px; line-height: 23px;color:#003580;"><?=lang('unit') ?></th>
						<th width="15%" style="background-color: #F0F0F0;padding: 5px 5px; line-height: 23px;color:#003580;"><?=lang('rate') ?></th>
						<th width="20%" style="background-color: #F0F0F0;padding: 5px 5px; line-height: 23px;color:#003580;"><?=lang('label_amount') ?></th>
					</tr>
				</thead>
				<tbody>
					<?php $is_NA = false;?>
					<?php $total = 0; $discount = 0;?>
					<?php foreach ($my_booking as $key=> $booking_item):?>
						<?php
							$total += $booking_item['total_price'];
							$discount += $booking_item['discount'];
						?>
						<tr>
							
							<?php if(!empty($booking_item['start_date'])):?>
							
							<td style="padding-left: 10px; font-weight: bold;color:#003580;">
								<span style="float: left; width: 80px;"><?=strftime(DATE_FORMAT_DISPLAY_I18N, strtotime($booking_item['start_date']))?>:</span> <?=$booking_item['service_name']?>
							</td>
							
							<?php else:?>
							
							<td style="padding-left: 10px; font-weight: bold;color:#003580;">
								<?=$booking_item['service_name']?>
							</td>
							
							<?php endif;?>
							
							 
							<td width="10%" align="center">
								<b><?=$booking_item['unit']?></b>
							</td>
							
							<td align="right"></td>
							
							<td align="right" style="background-color: whiteSmoke;"></td>
						</tr>
						<?php foreach ($booking_item['detail_booking_items'] as $detail_booking_item):?>
							
							<tr>
							
								<td style="padding-left: 20px"><div style="width: 80%;border-bottom: 1px dotted #D2D2D2;"><?=$detail_booking_item['service_name']?></div></td>
								
								<td width="10%" align="center">
									<div style="font-style: italic;font-size: 90%;width: 80%;border-bottom: 1px dotted #D2D2D2;"><?=$detail_booking_item['unit']?><?php if(isset($detail_booking_item['unit_text'])):?><?=$detail_booking_item['unit_text']?><?php endif;?></div>
								</td>
								
								<td align="right" style="padding-right: 20px;">
									<div style="width: 80%;border-bottom: 1px dotted #D2D2D2;">
									<?php if($detail_booking_item['rate'] != CURRENCY_SYMBOL."0"):?>
										<?=$detail_booking_item['rate']?>
									<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>									
										<?=$detail_booking_item['rate']?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
									</div>
								</td>
								
								<td align="right" style="background-color: whiteSmoke; padding-right: 20px;">
									<div style="color: #B30000; font-weight: bold;width: 80%;border-bottom: 1px dotted #D2D2D2;">
									<?php if($detail_booking_item['amount'] > 0):?>
										<?=CURRENCY_SYMBOL?><?=number_format($detail_booking_item['amount'], CURRENCY_DECIMAL)?>
									<?php elseif($detail_booking_item['reservation_type'] == RESERVATION_TYPE_OTHER || $detail_booking_item['reservation_type'] == RESERVATION_TYPE_TRANSFER):?>									
										<?=lang('no_charge')?>
									<?php else:?>
										<?=lang('na')?>
									<?php endif;?>
									</div>
								</td>
								
							</tr>
						
						<?php endforeach;?>
						
						<?php if(!empty($booking_item['offer_note']) || $booking_item['is_free_visa']):?>
							<tr>
								<td style="padding-left: 20px">
									
									<div style="border:1px solid #FEBA02; padding: 5px">
									
										<?php											
											$offer_note = str_replace("\n", "<br>", $booking_item['offer_note']);
										?>
										<span style="color: #FE8802;font-weight:bold;">
											<?=$offer_note?>
										</span>
									
									<?php if(!empty($booking_item['offer_name']) && !empty($booking_item['offer_cond'])):?>
										<br>									
										<?=$booking_item['offer_cond']?>										
									<?php endif;?>
									
									<?php if($booking_item['is_free_visa']):?>
										<br><br>
										<span style="color: #FE8802;font-weight:bold;"><?=lang('free_vietnam_visa')?></span>										
										<br>
										
										<?php if($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL):?>
											
											<?=$this->load->view('/ads/popup_free_visa_4_hotel', array('hotel'=>array('name'=>$booking_item['service_name'])))?>
										
										<?php else:?>										
											<?=$popup_free_visa?>										
										<?php endif;?>
										
									<?php endif;?>
									
									</div>
								</td>
								<td colspan="2">&nbsp;</td>
								<td style="background-color: whiteSmoke;"></td>
							</tr>
						<?php endif;?>
				
						<tr>
							<td colspan="3" style="border-bottom: 1px dashed #AAA;padding-top: 10px"></td>
							<td style="border-bottom: 1px dashed #AAA;padding-top: 10px; background-color: whiteSmoke;"></td>
						</tr>
					<?php endforeach;?>
					
					<?php if($discount > 0):?>
					<tr>
						<td align="right" colspan="3" style="padding-right: 20px;text-align: right;font-weight: normal;font-size: 11px"><?=lang('book_seperate')?></td>
						<td align="right" style="background-color: whiteSmoke; padding-right: 20px;line-height: 23px;">
							<div style="font-weight: bold;"><?=CURRENCY_SYMBOL?><?=number_format($discount + $total, CURRENCY_DECIMAL)?></div>
						</td>
					</tr>
					<tr>
						<td align="right" colspan="3" style="padding-right: 20px;text-align: right;background-color: #fff;font-size: 11px; font-weight: bold;"><?=lang('discount_together')?></td>
						<td align="right" style="background-color: whiteSmoke; padding-right: 20px; line-height: 23px;">
						<div style="font-weight: bold;">- <?=CURRENCY_SYMBOL?><?=number_format($discount, CURRENCY_DECIMAL)?></div>
						</td>
					</tr>
					<?php endif;?>
					
					<?php if(!empty($promotion_code) && !empty($promotion_code['type']) && !empty($promotion_code['value']) && !empty($promotion_code['code'])):?>
						
						<?php if($promotion_code['type'] == CAMPAIGN_VOUCHER):?>
							
							<tr>
								<td align="right" colspan="3" style="padding-right: 20px;text-align: right;background-color: #fff;font-size: 11px; font-weight: bold;"><?=lang('gift_voucher_discount')?></td>
								<td align="right" style="background-color: whiteSmoke; padding-right: 20px; line-height: 23px;">
								<div style="font-weight: bold;">- <?=CURRENCY_SYMBOL?><?=number_format($promotion_code['value'], CURRENCY_DECIMAL)?></div>
								</td>
							</tr>
							
							<?php $total = $total - $promotion_code['value'];?>
							
						<?php endif;?>
						
					<?php endif;?>
					
					<tr>
						<td colspan="3" style="font-size: 110%;background-color: #F0F0F0;padding-right: 20px;text-align: right;color: #333;font-weight: bold;line-height: 23px;"><?=lang('total_price')?></td>
						<td nowrap="nowrap" style="color: #B30000; font-weight: bold;font-size: 110%;font-size: 16px;background-color: #E7E7E7;padding-bottom: 5px;padding-top: 5px;line-height: 23px;text-align: right; padding-right: 10px">
						<label style="font-size: 12px;color: #B30000;font-weight: bold;">
						<?php if($total > 0):?>
							<?=lang('price_unit').' '?></label><?=CURRENCY_SYMBOL?><?=number_format($total, CURRENCY_DECIMAL)?>
						<?php else:?>
							<?=lang('na')?>
						<?php endif;?>
						</td>
					</tr>
				</tbody>
			</table>
    	</td>
    </tr>

    <?php if(!empty($customer_booking['special_request'])):?>
    <tr>
        <td style="padding-left: 30px;" colspan="2">
	        <span><b><?=lang('special_requests') ?>:</b></span>
	        <span><?=$customer_booking['special_request']?></span>
        </td>
    </tr>
	<?php endif;?>
	
	<?php if(!empty($promotion_code)):?>
    <tr>
        <td style="padding-left: 30px;" colspan="2">
        	<span><?=lang('booking_email_promotion_code_applied') ?>: <?=$promotion_code['code']?></span>
        	<br>
	       <span style="color: #FE8802;font-weight:bold;"><?=get_promo_code(true, 'promo_code_applied_mail')?></span>
        </td>
    </tr>
	<?php endif;?>
	
    <tr>
    	<td colspan="2">
			<p style="margin-top: 10px"><?=lang('booking_email_for_the_sevice_details') ?>
			<?php $service_details = get_list_service_details($my_booking);?>
			<?php foreach ($service_details as $key=> $booking_item):?> 
				<?php if($booking_item['reservation_type'] == RESERVATION_TYPE_CRUISE_TOUR 
						|| $booking_item['reservation_type'] == RESERVATION_TYPE_LAND_TOUR):?>
				<span style="margin: 5px 0 5px 30px; width: 100%; float: left;">
				<?=$key+1?>. <a style="color: #3588DC" href="<?=site_url(url_builder(TOUR_DETAIL, url_title($booking_item['service_name']), true))?>" target="_blank"><?=$booking_item['service_name']?></a>
				</span>
				<?php endif;?>
				<?php if($booking_item['reservation_type'] == RESERVATION_TYPE_HOTEL):?>
				<span style="margin: 5px 0 5px 30px; width: 100%; float: left;">
				<?=$key+1?>. <a style="color: #3588DC" href="<?=site_url(url_builder(HOTEL_DETAIL, url_title($booking_item['service_name']), true))?>" target="_blank"><?=$booking_item['service_name']?></a>
				</span>
				<?php endif;?>
			<?php endforeach;?>
			
			<?php if(isset($invoice_reference) && !empty($invoice_reference)):?>
			<span style="margin: 5px 0 5px 30px; width: 100%; float: left;">
				<a style="color: #3588DC" href="<?=site_url().'payment/invoice.html?ref='.$invoice_reference?>" target="_blank"><?=site_url().'payment/invoice.html?ref='.$invoice_reference?></a>
			</span>
			<?php endif;?>
			</p>
    	</td>
    </tr>
</table>
<p>&nbsp;</p>

<p><b><?=lang('booking_email_reservation', BRANCH_NAME) ?></b></p>

<p>
	<b><?=BRANCH_NAME?>., JSC</b><br>
	<?=lang('booking_email_hanoi_office')?>
	<br>
	Email: sales@<?=strtolower(SITE_NAME)?><br>
	Tel: (+84) 4 3624-9007<br>
	Website: <a href="<?=site_url()?>">http://www.<?=strtolower(SITE_NAME)?></a><br>	
</p>

</body>
</html>