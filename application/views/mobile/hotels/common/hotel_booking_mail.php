<html>
<head>
	<meta charset="utf-8">
</head>
<body style="font-family: Arial; font-size:12px;">

<?php 
	
	$customer['title_text'] = $customer['gender'] == 1 ? "Ông":"Bà";

?>

<div style="width:800px;margin-bottom:10px">
    <p>Xin chào quý khách <?=$customer['full_name']?>,</p>
    <p>Đơn đặt phòng khách sạn của quý khách đã được gửi tới <a href="<?=site_url()?>"><?=SITE_NAME?></a>. Nhân viên của chúng tôi sẽ tiến hành đặt phòng khách sạn và liên hệ tới quý khách sớm nhất trong vòng 8h.
    
    <p><b>Lưu ý: </b>Nếu quý khách kiểm tra thấy thông tin đặt phòng bị sai sót, xin vui lòng liên hệ với chúng tôi theo địa chỉ email <a target="_blank" href="mailto:booking@<?=strtolower(SITE_NAME)?>">booking@<?=strtolower(SITE_NAME)?></a> để thay đổi.</p>
</div>

<table style="width:800px; border-spacing:3px;font-family: Arial; font-size:12px">
	<tr>
		<td width="30%">
			 <span style="font-size:13px; font-weight:bold; color:#36C">Mã đơn hàng:</span>
		</td>
    	<td width="70%">
	        <span style="font-size:16px;font-weight:bold;color:#b20000">
				<?=$customer_booking_id?>
			</span>
			
			(Dùng để xác nhận đơn hàng)
        </td>
    </tr>
    
	<tr>
    	<td colspan="2">
        <span style="font-size:13px; font-weight:bold; color:#36C">Thông tin liên hệ</span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    <tr>
        <td width="30%" style="padding-left: 30px"><b>Họ và tên:</b></td>
        <td width="70%"><?=$customer['title_text'] . ' ' . $customer['full_name']?></td>
    </tr>
    <tr>
        <td style="padding-left: 30px"><b>Email:</b></td>
        <td><?=$customer['email']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px"><b>Điện thoại:</b></td>
        <td><?=$customer['phone']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px"><b>Địa chỉ:</b></td>
        <td><?=$customer['address']?></td>
    </tr>
    
    <?php if(!empty($customer['special_request'])):?>
    
   	<tr>
        <td style="padding-left: 30px"><b>Nội dung yêu cầu:</b></td>
        <td><?=$customer['special_request']?></td>
    </tr>
	
	<?php endif;?>
   	
   	<tr>
    	<td colspan="2">
	        <br>
	        <span style="font-size:13px; font-weight:bold; color:#36C">Thông tin đặt phòng</span>
			<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b>Khách sạn:</b></td>
        <td>
        	<span style="font-size:14px;color:#003580;font-weight:bold"><?=$hotel['name']?></span>
        </td>
    </tr>
    
     <tr>
        <td style="padding-left: 30px;"><b><?=lang('hotel_address')?>:</b></td>
        <td>
       		<?=$hotel['address']?>
        </td>
    </tr>
    
     <tr>
        <td style="padding-left: 30px;"><b>Đặt ngày:</b></td>
        <td>
        	<?=get_hotel_selected_date_txt($check_rate_info);?>
        </td>
    </tr>
    
    <tr>
    	<td colspan="2" style="padding-top:10px">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 750px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<th align="center" width="10%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">No.</th>
						<th align="center" width="25%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_col_room_type')?></th>
						<th align="center" width="30%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_col_condition')?></th>
						<th align="center" width="15%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_col_extra_bed')?></th>
						<th align="center" width="20%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=str_replace('<night>', $check_rate_info['night'], lang('hb_col_price'))?></th>
					</tr>
				</thead>
				<tbody>
				
				
			<?php 
				$room_index = 0;
				$total_payment = 0;
			?>
			<?php foreach ($selected_room_rates as $value):?>
				
				<?php for ($i = 0; $i < $value['nr_room']; $i++):?>
					<?php 
						$room_index++;
						
						$room_rate = $value['room_rate_info'];
						
						$occupancy = $room_rate['occupancy'];
						
						$basic_rate = $room_rate['basic_rate'][$occupancy];
						
						$sell_rate = $value['sell_rate'];
						
						$total_rate_origin = count_total_room_rate($basic_rate);
						
						$total_rate = count_total_room_rate($sell_rate);
						
						$extra_bed_nr = $this->input->post($room_index.'_extra_bed_'.get_room_rate_id($room_rate));
						
						if($extra_bed_nr > 0){
							$extrabed_rate = count_total_room_rate($room_rate['extrabed_rate']);
						
							$total_rate = $total_rate + $extra_bed_nr * $extrabed_rate;
						}
						
						$total_payment += $total_rate;
						
					?>
					<tr>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<?=lang('hb_room')?> <?=$room_index?>
						</td>
						
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<b><?=get_room_rate_name($room_rate)?></b>
							<br>
							<span style="font-size:11px"><?=get_room_type_square_m2($room_rate)?></span>
						</td>
						
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<div style="margin-bottom:5px"><?=lang('hb_max_stay')?>: <b><?=get_room_type_max_person($room_rate)?></b></div>
							<div style="margin-bottom:5px;">
								<?=get_breakfast_vat_txt($room_rate)?>
							</div>
							
							<?php /*if(!empty($room_rate['cancellation'])):?>
								<div style="color:#409224">
									<?=get_room_conditon_text($room_rate['cancellation'], $check_rate_info['startdate'], true)?>
								</div>
							<?php endif;*/?>
						</td>
						
						
						<td align="center" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<?php if($extra_bed_nr > 0):?>
								<?=$extra_bed_nr?> <?=lang('hb_col_extra_bed')?>
							<?php else:?>
								Không
							<?php endif;?>
						</td>
						
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<span style="font-size:16px;font-weight:bold;color:#b20000">
								<?=bpv_format_currency($total_rate)?>
							</span>
						</td>
					</tr>
				<?php endfor;?>
				
			<?php endforeach;?>
						
				</tbody>
			</table>
    	</td>
    </tr>
   	
   	<?php if(!empty($surcharges)):?>
   	
	<tr>
    	<td colspan="2" style="padding-top:10px">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 750px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<td align="center" width="35%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_surcharge_name')?></td>
						<td align="center" width="15%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_surcharge_unit')?></td>
						<td align="center" width="30%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_surcharge_apply')?></td>
						<td align="center" width="20%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('hb_surcharge_total')?></td>
					</tr>
				</thead>
				<tbody>
				
				<?php foreach ($surcharges as $sur):?>
					<?php 
						$total_payment += $sur['total_charge'];
					?>
				<tr>
					<td style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<b><?=$sur['name']?></b>
					</td>
					
					<td align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<b><?=bpv_format_currency($sur['amount'])?></b> /<?=get_surcharge_unit($sur)?>
					</td>
					
					<td align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<?=get_surcharge_apply($sur, $room_pax_total)?>
					</td>
					<td align="right" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<span style="font-size:16px;font-weight:bold;color:#b20000">
							<?=bpv_format_currency($sur['total_charge'])?>
						</span>
					</td>
				</tr>
				<?php endforeach;?>
					
				</tbody>
			</table>
    	</td>
    </tr>    
   	<?php endif;?>
   	
    <tr>
    	<td colspan="2" style="padding-top:10px">
    		<table style="margin-left: 30px; background-color:#F0F0F0; border-spacing:0;empty-cells:show;border:1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 750px">
    			<tbody>
    				
    				<?php if(!empty($code_discount_info)):?>
    					
    					<?php 
    						$pro_code_discount = calculate_pro_code_discount($code_discount_info, $total_payment);
    						
    						$total_payment = $total_payment - $pro_code_discount;
    					?>
    					
    					<tr>
	    					<td width="80%" align="right" style="padding:5px 7px;">
	    						<span style="font-weight:bold;color:#555">Mã giảm giá <?=$code_discount_info['code']?>:</span>
	    					</td>
	    					<td width="20%" align="right" style="padding:5px 7px;">
	    						<span style="font-size:16px;font-weight:bold;color:#b20000">
									- <?=bpv_format_currency($pro_code_discount)?>
								</span>
	    					</td>
	    				</tr>
    				<?php endif;?>
    				
    				<tr>
    					<td width="80%" align="right" style="padding:5px 7px;">
    						<span style="font-size:18px;font-weight:bold;color:#555">Tổng tiền:</span>
    					</td>
    					<td width="20%" align="right" style="padding:5px 7px;">
    						<span style="font-size:20px;font-weight:bold;color:#b20000">
								<?=bpv_format_currency($total_payment)?>
							</span>
    					</td>
    				</tr>
    			</tbody>
    		</table>	
    	</td>
    </tr>
    
    <tr>
    	<td colspan="2">
    	<br>
        <span style="font-size:13px; font-weight:bold; color:#36C">Quy định của <?=$hotel['name']?></span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;" ><b>Thời gian nhận phòng:</b></td>
        <td>
        	<p style="margin:5px 0">
        		<?=$hotel['check_in']?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b>Thời gian trả phòng:</b></td>
        <td>
        	<p style="margin:5px 0">
        	<?=$hotel['check_out']?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b><?=lang('checkin_policy')?>:</b></td>
        <td>
        	<p style="margin:5px 0">
        	<?=lang('checkin_policy_content')?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b><?=lang('cancellation_policy')?>:</b></td>
        <td>
        	<p style="margin:5px 0">
	        	<div style="margin-bottom:5px"><?=lang('cal_content_1')?></div>
				<div style="margin-bottom:5px">* <?=lang('cal_content_2')?>:</div>
				<div style="padding-left:15px;margin-bottom:5px">
					<?php if(!empty($hotel['extra_cancellation'])):?>
						<?=$hotel['extra_cancellation']?>
					<?php elseif(isset($hotel['cancellation'])):?>
						<?=$hotel['cancellation']['content']?>
					<?php endif;?>
				</div>
				
				<div style="margin-bottom:5px">* <?=lang('cal_content_3')?>:</div>
				
				<div style="padding-left:15px;margin-bottom:5px">
					<?=lang('cal_content_4')?>
				</div>
			</p>
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b>Trẻ em đi kèm:</b></td>
        <td>
        	<table width="100%" style="background-color:#F0F0F0;border-spacing:0;empty-cells:show;font-family: Arial; font-size:12px; margin:5px 0">
        		<tr>
        			<td width="30%" style="padding:10px;border:1px solid #FFF">
        				Em bé (dưới <?=$hotel['infant_age_util']?> tuổi
        			</td>
        			<td style="padding:10px;border:1px solid #FFF">
        				<?=$hotel['infants_policy']?>
        			</td>
        		</tr>
        		<tr>
        			<td style="padding:10px;border:1px solid #FFF">
        				Trẻ em (<?=$hotel['infant_age_util']?> đến <?=$hotel['children_age_to']?> tuổi)
        			</td>
        			<td style="padding:10px;border:1px solid #FFF">
        				<?=$hotel['children_policy']?>
        			</td>
        		</tr>
        	</table>
        	<p>(*) Trẻ em trên <?=$hotel['children_age_to']?> tuổi được coi là người lớn</p>
        </td>
    </tr>
			
</table>
<p>&nbsp;</p>
<p><b>Đặt phòng khách sạn - <?=BRANCH_NAME?></b></p>
<p>
<b><?=BRANCH_NAME?>., JSC</b><br>
Địa chỉ: Tầng 6, Nhà 12A, Ngõ Bà Triệu, Phố Bà Triệu<br>
Quận Hai Bà Trưng, Hà Nội, Việt Nam.<br>
Email: sales@<?=strtolower(SITE_NAME)?><br>
Tel: (04) 3978-1425<br>
Website: <a href="<?=site_url()?>">http://www.<?=strtolower(SITE_NAME)?></a><br>	
</p>
</body>
</html>