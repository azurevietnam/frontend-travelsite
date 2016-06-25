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
    <p>Đơn đặt tour của quý khách đã được gửi tới <a href="<?=site_url()?>"><?=SITE_NAME?></a>. Nhân viên của chúng tôi sẽ tiến hành đặt tour và liên hệ tới quý khách sớm nhất trong vòng 8h.
    
    <p><b>Lưu ý: </b>Nếu quý khách kiểm tra thấy thông tin đặt tour bị sai sót, xin vui lòng liên hệ với chúng tôi theo địa chỉ email <a target="_blank" href="mailto:booking@<?=strtolower(SITE_NAME)?>">booking@<?=strtolower(SITE_NAME)?></a> để thay đổi.</p>
</div>

<table style="width:800px; border-spacing:5px;font-family: Arial; font-size:12px">
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
	        <span style="font-size:13px; font-weight:bold; color:#36C">Thông tin đặt tour</span>
			<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;">
        	<b>Tour du thuyền:</b>
        </td>
        <td style="font-size:14px;color:#003580;font-weight:bold"><?=$tour['name']?></td>
    </tr>
    
     <tr>
        <td style="padding-left: 30px;">
        	<b><?=lang('tour_route')?></b>
        </td>
        <td><?=$tour['route']?></td>
    </tr>
    
     <tr>
        <td style="padding-left: 30px;">
        	<b><?=lang('tour_infor')?></b>
        </td>
        <td><?=get_tour_info($check_rate_info)?></td>
    </tr>
    
     <tr>
        <td style="padding-left: 30px;">
        	<b>Đặt ngày:</b>
        </td>
        <td><?=get_tour_selected_date_txt($check_rate_info, $tour);?></td>
    </tr>
    
    <?php
		$acc = $selected_cabin_rates['cabin_rate_info'];
	?>
    
    <?php if(isset($acc['promotion']) && $acc['promotion']['show_on_web']):?>
    <?php $pro = $acc['promotion'];?>
    <tr>
        <td style="padding-left: 30px;color: #fe8802;" valign="top">
        	<b>Khuyến mãi:</b>
        </td>
        <td>
        	<div style="color: #fe8802;margin-bottom: 5px"><?=$pro['name']?></div>
        	<div style="margin-bottom: 5px;">
        		<b>Áp dụng đến ngày:</b> <span style="color: #b20000"><?=date(DATE_FORMAT, strtotime($pro['book_date_to']))?></span>
			</div>
			
			<div style="min-width:280px;margin-bottom: 5px;">
				<b>Thời gian đi tour: </b> từ <span style="color: #b20000"><?=date(DATE_FORMAT, strtotime($pro['stay_date_from']))?></span>
				đến <span style="color: #b20000"><?=date(DATE_FORMAT, strtotime($pro['stay_date_to']))?></span>
			</div>
			
			<?php 
				$cnt = 0;
				foreach ($week_days as $key=>$value){
					if(is_bit_value_contain($pro['check_in_on'], $key)){
						$cnt++;
					}
				}
				
			?>
			
			<?php if($cnt <7):?>
			<div class="margin-bottom-10">
				<b><?=lang('hp_apply_on')?>:</b>
				<?php foreach ($week_days as $key=>$value):?>
					
					<?php if(is_bit_value_contain($pro['check_in_on'], $key)):?>
						<?=lang($value)?>, 
					<?php endif;?>
					
				<?php endforeach;?>
			</div>
			<?php endif;?>
			
			<?php if($pro['offer'] != ''):?>
				<div class="margin-bottom-10">
					<?=$pro['offer']?>
				</div>
			<?php endif;?>
        </td>
    </tr>
	<?php endif;?>
    
    <tr>
    	<td colspan="2" style="padding-top:10px">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 750px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<th align="left" width="50%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('cabin_type')?></th>
						<th align="center" nowrap="nowrap" width="10%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?='1 ' . lang('adult_label')?></th>
						<?php if(!empty($check_rate_info['children'])):?>
						<th align="center" nowrap="nowrap" width="10%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?='1 ' . lang('children_label')?></th>
						<?php endif;?>
						<?php if(!empty($check_rate_info['infants'])):?>
						<th align="center" nowrap="nowrap" width="10%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?='1 ' . lang('infant_label')?></th>
						<?php endif;?>
						<?php if($check_rate_info['adults']%2 != 0):?>
						<th align="center" nowrap="nowrap" width="10%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('single_sup')?></th>
						<?php endif;?>
						<th align="center" nowrap="nowrap" width="20%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('total_price')?></th>
					</tr>
				</thead>
				<tbody>
					<tr>	
						<td style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
							<?php if(isset($acc['cabin'])):?>
								<?php $cabin = $acc['cabin'];?>
								<div style="color: #004F8C; font-weight: bold; margin-bottom: 10px"><?=$cabin['name']?></div>
								<div><?=get_cruise_cabin_square_m2($cabin)?></div>
								
								<div>
								<?=lang('include_text').lang('include_tax_and_service_fee')?>
								</div>
							<?php else:?>
								<div style="color: #004F8C; font-weight: bold; margin-bottom: 10px"><?=$acc['name']?></div>
								<p><?=$acc['content']?></p>
							<?php endif;?>
						</td>
						<td nowrap="nowrap" align="center" style="vertical-align:middle; font-size: 13px; text-align: center; border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"">
							<?php if($acc['adult_rate'] != $acc['adult_basic_rate']):?>
								<div style="font-size: 12px; text-decoration: line-through;"><?=bpv_format_currency($acc['adult_basic_rate'])?></div>
							<?php endif;?>
							<div style="color: #B20000;"><?=bpv_format_currency($acc['adult_rate'])?></div>
						</td style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						
						<?php if(!empty($check_rate_info['children'])):?>
						<td nowrap="nowrap" align="center" style="vertical-align:middle; font-size: 13px; text-align: center;border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"">
							<?php if($acc['children_rate'] != $acc['children_basic_rate']):?>
								<div style="font-size: 12px; text-decoration: line-through;"><?=bpv_format_currency($acc['children_basic_rate'])?></div>
							<?php endif;?>
							<div style="color: #B20000;">
							<?php if(!empty($acc['children_rate'])):?>
								<?=bpv_format_currency($acc['children_rate'])?>
							<?php else:?>
								<span style="font-weight: normal; font-size: 13px"><?=lang('free_of_charge')?></span>
							<?php endif;?>
							</div>
						</td>
						<?php endif;?>
						
						<?php if(!empty($check_rate_info['infants'])):?>
						<td nowrap="nowrap" align="center" style="vertical-align:middle; font-size: 13px; text-align: center; border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"">
							<?php if($acc['infant_rate'] != $acc['infant_basic_rate']):?>
								<div style="font-size: 12px; text-decoration: line-through;"><?=bpv_format_currency($acc['infant_basic_rate'])?></div>
							<?php endif;?>
							<div style="color: #B20000;">
							<?php if(!empty($acc['infant_rate'])):?>
								<?=bpv_format_currency($acc['infant_rate'])?>
							<?php else:?>
								<span style="font-weight: normal; font-size: 13px"><?=lang('free_of_charge')?></span>
							<?php endif;?>
							</div>
						</td>
						<?php endif;?>
						
						<?php if($check_rate_info['adults']%2 != 0):?>
						<td nowrap="nowrap" align="center" style="vertical-align:middle; font-size: 13px; text-align: center; border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"">
							<?php if($acc['single_sup_rate'] != $acc['single_sup_basic_rate']):?>
								<div style="font-size: 12px; text-decoration: line-through;"><?=bpv_format_currency($acc['single_sup_basic_rate'])?></div>
							<?php endif;?>
							<div style="color: #B20000;"><?=bpv_format_currency($acc['single_sup_rate'])?></div>
						</td>
						<?php endif;?>
						
						<td align="right" style="font-size: 15px;border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"">
							<?php if($acc['sell_rate'] != $acc['basic_rate']):?>
							<div style="font-size: 12px; text-decoration: line-through;"><?=bpv_format_currency($acc['basic_rate'])?></div>
							<?php endif;?>
							<div style="color: #B20000; font-weight: bold;"><?=bpv_format_currency($acc['sell_rate'])?></div>
						</td>
					</tr>
				</tbody>
			</table>
    	</td>
    </tr>
    
    <?php
   			$total_payment = $acc['sell_rate'];
    ?>
    
    <?php if(!empty($surcharges)):?>
   	
	<tr>
    	<td colspan="2" style="padding-top:10px">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 750px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<td align="center" width="35%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('cb_surcharge_name')?></td>
						<td align="center" width="15%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('cb_surcharge_unit')?></td>
						<td align="center" width="30%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('cb_surcharge_apply')?></td>
						<td align="center" width="20%" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('cb_surcharge_total')?></td>
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
						<?php if($sur['charge_type'] == SUR_PER_ADULT_PER_BOOKING):?>
							<b><?=bpv_format_currency($sur['adult_amount'])?></b> /<?=strtolower(lang('adult_label'))?>
							
							<?php if( !empty($sur['children_amount']) ):?>
								<br><b><?=bpv_format_currency($sur['children_amount'])?></b> /<?=strtolower(lang('children_label'))?>
							<?php endif;?>
						<?php elseif($sur['charge_type'] == SUR_PER_ROOM_PRICE):?>
							<b><?=$sur['adult_amount'].lang('cb_sur_percentage_per_total')?></b>
						<?php endif;?>
					</td>
					
					<td align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<?=get_cruise_surcharge_apply_for($check_rate_info, $sur)?>
					</td>
					<td align="right" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">
						<span style="font-size:15px;font-weight:bold;color:#b20000">
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
        <span style="font-size:13px; font-weight:bold; color:#36C">Quy định của <?=$tour['cruise']['name']?></span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;" ><b>Thời gian khởi hành:</b></td>
        <td>
        	<p style="margin:5px 0">
        		<?=$tour['cruise']['check_in']?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td style="padding-left: 30px;"><b>Thời gian về:</b></td>
        <td>
        	<p style="margin:5px 0">
        	<?=$tour['cruise']['check_out']?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td valign="top" style="padding-left: 30px;"><b><?=lang('checkin_policy')?>:</b></td>
        <td>
        	<p style="margin:5px 0">
        	<?=lang('checkin_policy_content')?>
        	</p>
        </td>
    </tr>
    
    <tr>
        <td valign="top" style="padding-left: 30px;"><b><?=lang('cancellation_policy')?>:</b></td>
        <td>
        	<p style="margin:5px 0">
	        	<?php if(!empty($acc['cancellation']) || !empty($tour['extra_cancellation'])):?>
	        		<?php 
						$is_no_cancell = $acc['cancellation']['id'] == CANCELLATION_NO_REFUND;
					?>
					<?=$is_no_cancell ? lang('no_cancel') : lang('cancellation_policy')?>
					<span>
						<?=empty($tour['extra_cancellation']) || $is_no_cancell? $acc['cancellation']['content'] : $tour['extra_cancellation']?>
					</span>
	        	<?php endif;?>
			</p>
        </td>
    </tr>
    
    <tr>
        <td valign="top" style="padding-left: 30px;"><b>Trẻ em đi kèm:</b></td>
        <td>
        	<table width="100%" style="background-color:#F0F0F0;border-spacing:0;empty-cells:show;font-family: Arial; font-size:12px; margin:5px 0">
        		<tr>
        			<td width="30%" style="padding:10px;border:1px solid #FFF">
        				Em bé (dưới <?=$tour['cruise']['infant_age_util']?> tuổi
        			</td>
        			<td style="padding:10px;border:1px solid #FFF">
        				<?=$tour['cruise']['infants_policy']?>
        			</td>
        		</tr>
        		<tr>
        			<td style="padding:10px;border:1px solid #FFF">
        				Trẻ em (<?=$tour['cruise']['infant_age_util']?> đến <?=$tour['cruise']['children_age_to']?> tuổi)
        			</td>
        			<td style="padding:10px;border:1px solid #FFF">
        				<?=$tour['cruise']['children_policy']?>
        			</td>
        		</tr>
        	</table>
        	<p>(*) Trẻ em trên <?=$tour['cruise']['children_age_to']?> tuổi được coi là người lớn</p>
        </td>
    </tr>
			
</table>
<p>&nbsp;</p>
<p><b>Đặt phòng khách sạn và tour - <?=BRANCH_NAME?></b></p>
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