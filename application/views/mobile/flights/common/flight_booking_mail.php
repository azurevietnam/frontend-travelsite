<html>
<head>
	<meta charset="utf-8">
</head>
<body style="font-family: Arial; font-size:12px;">

<?php 
	
	$customer['title_text'] = $customer['gender'] == 1 ? "Ông":"Bà";
	
	$is_domistic = $search_criteria['is_domistic'];
?>

<div style="width:720px;">
    <p>Xin chào quý khách <?=$customer['full_name']?>,</p>
    <p>Đơn đặt vé máy bay của quý khách đã được gửi tới <a href="<?=site_url()?>"><?=SITE_NAME?></a>. Xin quý khách vui lòng thanh toán sớm để giữ được giá vé tốt.
    
    <p><b>Lưu ý: </b>Nếu quý khách kiểm tra thấy thông tin đặt vé bị sai sót, xin vui lòng liên hệ với chúng tôi theo địa chỉ email <a target="_blank" href="mailto:booking@<?=strtolower(SITE_NAME)?>">booking@<?=strtolower(SITE_NAME)?></a> để thay đổi.</p>
</div>
<table style="width:700px; border-spacing:3px;font-family: Arial; font-size:12px;">
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
        <td style="padding-left: 30px;width: 30%"><b>Họ và tên:</b></td>
        <td width="70%"><?=$customer['title_text'] . ' ' . $customer['full_name']?></td>
    </tr>
    <tr>
        <td style="padding-left: 30px;width: 30%"><b>Email:</b></td>
        <td width="70%"><?=$customer['email']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px;width: 30%"><b>Điện thoại:</b></td>
        <td width="70%"><?=$customer['phone']?></td>
    </tr>	
    <tr>
        <td style="padding-left: 30px;width: 30%"><b>Địa chỉ:</b></td>
        <td width="70%"><?=$customer['address']?></td>
    </tr>
    
    <?php if(!empty($customer['special_request'])):?>
    
   	<tr>
        <td style="padding-left: 30px;width: 30%"><b>Yêu cầu khác:</b></td>
        <td width="70%"><?=$customer['special_request']?></td>
    </tr>
	
	<?php endif;?>
   	
   	<?php if($is_domistic):?>
   	
   	<tr>
    	<td colspan="2">
        <br>
        <span style="font-size:13px; font-weight:bold; color:#36C">Lộ trình chuyến bay</span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
    <tr>
    	<td colspan="2">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 650px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_airline')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_flight_code')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_itineray')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_date')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_time')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_arrival_time')?></th>
					</tr>
				</thead>
				<tbody>
				
				<?php 
					$flight_departure = $flight_booking['flight_departure'];
					$detail = $flight_departure['detail'];
				?>
				
				<?php foreach ($detail['routes'] as $key=>$route):?>
				
					<tr>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$valid_airline_codes[$flight_departure['airline']]?></td>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['airline']?></td>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> <br><?=lang('flight_to')?>: <b><?=$route['to']['city']?></b>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?></td>
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['from']['time']?></td>
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['to']['time']?></td>
					<tr>
				
				<?php endforeach;?>
				
				<?php if(!empty($flight_booking['flight_return'])):?>
					<?php 
						$flight_return = $flight_booking['flight_return'];
						$detail = $flight_return['detail'];
					?>
					
					<?php foreach ($detail['routes'] as $key=>$route):?>
					
						<tr>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$valid_airline_codes[$flight_departure['airline']]?></td>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['airline']?></td>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=lang('flight_from')?>: <b><?=$route['from']['city']?></b> <br><?=lang('flight_to')?>: <b><?=$route['to']['city']?></b>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=format_bpv_date($route['from']['date'], DATE_FORMAT, true)?></td>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['from']['time']?></td>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['to']['time']?></td>
						<tr>
					
					<?php endforeach;?>
				
				<?php endif;?>
					
				</tbody>
			</table>
    	</td>
    </tr>
    
    
    <?php else:?>
				
		<?php 
			$selected_flight = $flight_booking['selected_flight'];
		?>
		
		<tr>
	    	<td colspan="2">
	        <br>
	        <span style="font-size:13px; font-weight:bold; color:#36C">
	        	<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
		        	<?=lang_arg('flight_itineray_depart', $search_criteria['From'], $search_criteria['To'])?>,
					<?=$selected_flight['depart_routes'][0]['DayFrom']?>/<?=$selected_flight['depart_routes'][0]['MonthFrom']?>
				<?php else:?>
					Lộ trình chuyến bay
				<?php endif;?>
	        </span>
			<hr style="background:#39C; height:1px; border:0px;">
	        </td>
	    </tr>
	    
	    <tr>
	    	<td colspan="2">
	    		
	    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 650px">
					<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
						<tr>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_airline')?></th>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_flight_code')?></th>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_itineray')?></th>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_date')?></th>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_time')?></th>
							<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_arrival_time')?></th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($selected_flight['depart_routes'] as $key=>$route):?>
							<tr>
								<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['FlightCode']?></td>
								<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['Airlines'].'-'.$route['FlightCodeNum']?></td>
								<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
									<?=lang('flight_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_to')?>: <b><?=$route['To']?></b>
								</td>
			
								<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
									<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
								</td>
								<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
									<?=flight_time_format($route['TimeFrom'])?>
								</td>
								<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
									<?=flight_time_format($route['TimeTo'])?>
								</td>
							</tr>
							<?php if(isset($selected_flight['depart_routes'][$key + 1])):?>
				
								<?php 
									$next_route = $selected_flight['depart_routes'][$key + 1];
									
									$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
								?>
								<tr>				
									<td colspan="6" align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
										<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
									</td>
								</tr>
							<?php endif;?>
							
						<?php endforeach;?>
					</tbody>
				</table>
	    		
	    	</td>
    	</tr>
    	
    	
    	<?php if(!empty($selected_flight['return_routes'])):?>
    	
    		<tr>
		    	<td colspan="2">
		        <br>
		        <span style="font-size:13px; font-weight:bold; color:#36C">
		        	<?=lang_arg('flight_itineray_return', $search_criteria['To'], $search_criteria['From'])?>, 
					<?=$selected_flight['return_routes'][0]['DayFrom']?>/<?=$selected_flight['return_routes'][0]['MonthFrom']?>
		        </span>
				<hr style="background:#39C; height:1px; border:0px;">
		        </td>
		    </tr>
    		
    		<tr>
	    		<td colspan="2">
	    		
		    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 650px">
						<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
							<tr>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_airline')?></th>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_flight_code')?></th>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_itineray')?></th>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_date')?></th>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_departure_time')?></th>
								<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tbl_arrival_time')?></th>
							</tr>
						</thead>
						<tbody>
						
						<?php foreach ($selected_flight['return_routes'] as $key=>$route):?>
						<tr>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['FlightCode']?></td>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=$route['Airlines'].'-'.$route['FlightCodeNum']?></td>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=lang('flight_from')?>: <b><?=$route['From']?></b> <br><?=lang('flight_to')?>: <b><?=$route['To']?></b>
							</td>
		
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=format_bpv_date(flight_date($route['DayFrom'], $route['MonthFrom']), DATE_FORMAT, true)?>
							</td>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=flight_time_format($route['TimeFrom'])?>
							</td>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=flight_time_format($route['TimeTo'])?>
							</td>
						</tr>	
							<?php if(isset($selected_flight['return_routes'][$key + 1])):?>
				
								<?php 
									$next_route = $selected_flight['return_routes'][$key + 1];
									
									$delay = calculate_flying_time($route['TimeTo'], $route['DayTo'], $route['MonthTo'], $next_route['TimeFrom'], $next_route['DayFrom'], $next_route['MonthFrom']);
								?>
							<tr>				
								<td colspan="6" align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
									<?=lang_arg('change_flight_info', $next_route['From'], $delay['h'], $delay['m'])?>
								</td>
							</tr>		
							<?php endif;?>
							
						
						<?php endforeach;?>
						
						</tbody>
					</table>	
	  
				</td>
			</tr>
		<?php endif;?>	
	<?php endif;?>
			
    
    <tr>
    	<td colspan="2">
        <br>
        <span style="font-size:13px; font-weight:bold; color:#36C">Thông tin hành khách</span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    
	<tr>
    	<td colspan="2">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 650px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<th width="30%" align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">No.</th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('full_name')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('gender')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('date_of_birth')?></th>
						<th align="center" style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('send_baggage')?></th>
					</tr>
				</thead>
				<tbody>
				
				<?php for ($i = 1; $i <= $flight_booking['nr_adults']; $i++):?>
	
					<?php 
						$adult = isset($flight_booking['adults'][$i-1]) ? $flight_booking['adults'][$i-1] : '';
					?>
					
					<tr>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=lang('passenger')?> <?=$i?>, <?=lang('search_fields_adults')?></td>				
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<b><?=!empty($adult)? $adult['first_name'].' '.$adult['last_name'] : ''?></b>
						</td>
						<td align="center" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<?php if(!empty($adult)):?>
								<?=($adult['gender'] == 1? lang('gender_male'):lang('gender_female'))?>
							<?php else:?>
								&nbsp;
							<?php endif;?>							
						</td>
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">&nbsp;</td>
						<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<?=get_checked_baggage_by_index($flight_booking, $i);?>
						</td>				
					</tr>
							
				<?php endfor;?>
					
					
					<?php for ($i = 1; $i <= $flight_booking['nr_children']; $i++):?>
					
						<?php 
							$child = isset($flight_booking['children'][$i-1]) ? $flight_booking['children'][$i-1] : '';
						?>
					
						<tr>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'])?>, <?=lang('search_fields_children')?>:</td>
							
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b><?=!empty($child)? $child['first_name'].' '.$child['last_name'] : ''?></b>
							</td>
							<td align="center" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?php if(!empty($child)):?>
									<?=($child['gender'] == 1? lang('gender_male'):lang('gender_female'))?>
								<?php else:?>
									&nbsp;
								<?php endif;?>							
							</td>
							
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=$child['birth_day']?>
							</td>
							
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=get_checked_baggage_by_index($flight_booking, $i + $flight_booking['nr_adults']);?>
							</td>
						</tr>
					
					<?php endfor;?>
					
					<?php for ($i = 1; $i <= $flight_booking['nr_infants']; $i++):?>
						
						<?php 
							$infant = isset($flight_booking['infants'][$i-1]) ? $flight_booking['infants'][$i-1] : '';
						?>
						
						<tr>
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;"><?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'] + $flight_booking['nr_children'])?>, <?=lang('search_fields_infants')?>:</td>
							
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b><?=!empty($infant)? $infant['first_name'].' '.$infant['last_name'] : ''?></b>
							</td>
							<td align="center" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?php if(!empty($infant)):?>
									<?=($infant['gender'] == 1? lang('gender_male'):lang('gender_female'))?>
								<?php else:?>
									&nbsp;
								<?php endif;?>							
							</td>
							
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=$infant['birth_day']?>
							</td>
							
							<td style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<?=get_checked_baggage_by_index($flight_booking, $i + $flight_booking['nr_adults'] + $flight_booking['nr_children']);?>
							</td>				
						</tr>
					
					
					<?php endfor;?>
				
					
				</tbody>
			</table>
    	</td>
    </tr>    
   	
   	<?php 
		$prices = $flight_booking['prices'];
		
		$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();
		$total_kg = isset($baggage_fees['total_kg']) ? $baggage_fees['total_kg'] : 0;
		$total_fee = isset($baggage_fees['total_fee']) ? $baggage_fees['total_fee'] : 0;
		
		$total_payment = $prices['total_price'] + $total_fee;
		
		$nr_ticket = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];
		$nr_ticket = $search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY ? $nr_ticket * 2 : $nr_ticket;
		
		if(!empty($code_discount_info)){
			$pro_code_discount = calculate_pro_code_discount($code_discount_info, $total_payment, $nr_ticket);
			
			$total_payment = $total_payment - $pro_code_discount;
		}
	?>
		
    <tr>
    	<td colspan="2">
        <br>
        <span style="font-size:13px; font-weight:bold; color:#36C">Chi tiết thanh toán tiền vé</span>
		<hr style="background:#39C; height:1px; border:0px;">
        </td>
    </tr>
    <tr>
    	<td colspan="2">
    		<table style="margin-left: 30px; border-spacing:0;empty-cells:show;border-top: 1px solid #DDD;border-left:1px solid #DDD;font-family: Arial; font-size:12px;width: 650px">
				<thead style="font-size: 110%;font-weight: bold;background-color:#F0F0F0;color:#555;">
					<tr>
						<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=$search_criteria['ADT']?> <?=lang('search_fields_adults')?></th>
						
						<?php if($search_criteria['CHD'] > 0):?>
							<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=$search_criteria['CHD']?> <?=lang('search_fields_children')?></th>
						<?php endif;?>
						
						<?php if($search_criteria['INF'] > 0):?>					
							<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=$search_criteria['INF']?> <?=lang('search_fields_infants')?></th>
						<?php endif;?>
						
						<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('tax_fee')?></th>
						
						<?php if($total_fee > 0):?>
							<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang_arg('baggage_fee', $total_kg)?></th>
						<?php endif;?>
						
						<?php if(!empty($code_discount_info)):?>
							<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;">Mã giảm giá <?=$code_discount_info['code']?></th>
						<?php endif;?>
						
						<th style="border-bottom:1px solid #DDD;padding:3px 7px;border-right:1px solid #DDD;"><?=lang('price_total')?></th>
					</tr>
				</thead>
				<tbody>
					
					<tr>						
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<b><?=!empty($prices['adult_fare_total']) ? bpv_format_currency($prices['adult_fare_total'], false) : '0 '.lang('vnd')?></b>
						</td>
						
						<?php if($search_criteria['CHD'] > 0):?> 
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b><?=!empty($prices['children_fare_total'])?bpv_format_currency($prices['children_fare_total'], false):'0 '.lang('vnd')?></b>
							</td>
						<?php endif;?>
						
						<?php if($search_criteria['INF'] > 0):?>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b><?=!empty($prices['infant_fare_total'])?bpv_format_currency($prices['infant_fare_total'], false):'0 '.lang('vnd')?></b>
							</td>
						<?php endif;?>
						
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
							<b><?=bpv_format_currency($prices['total_tax'], false)?></b>
						</td>
						
						<?php if($total_fee > 0):?>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b><?=bpv_format_currency($total_fee, false)?></b>
							</td>
						<?php endif;?>
						
						<?php if(!empty($code_discount_info)):?>
							<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;">
								<b>- <?=bpv_format_currency($pro_code_discount, false)?></b>
							</td>
						<?php endif;?>
						
						<td align="right" style="border-bottom:1px solid #DDD;border-right:1px solid #DDD;padding: 7px;font-size:18px;font-weight:bold;color:#B20000">
							<?=bpv_format_currency($total_payment, false)?>
						</td>
					</tr>
			
				</tbody>
			</table>
    	</td>
    </tr>
    
    <?php if($is_domistic):?>
    
	    <?php 
			$flight_departure = $flight_booking['flight_departure'];
			$detail = $flight_departure['detail'];
		?>
		<?php if(!empty($detail['fare_rules'])):?>
			<?php foreach ($detail['routes'] as $key=>$route):?>			
				<tr>
			    	<td colspan="2">
			        <br>
			        <span style="font-size:13px; font-weight:bold; color:#36C">Điều kiên vé của chuyến bay <?=$route['airline']?> (<?=$route['from']['city']?> -&gt; <?=$route['to']['city']?>):</span>
					<hr style="background:#39C; height:1px; border:0px;">
			        </td>
			    </tr>
				<tr>
					<td colspan="2" style="padding-left:30px">					
						<?=$detail['fare_rules']?>
					</td>
				<tr>
			
			<?php endforeach;?>
		<?php endif;?>
		
		<?php if(!empty($flight_booking['flight_return'])):?>
			<?php 
				$flight_return = $flight_booking['flight_return'];
				$detail = $flight_return['detail'];
			?>
			<?php if(!empty($detail['fare_rules'])):?>
				<?php foreach ($detail['routes'] as $key=>$route):?>
				
				<tr>
			    	<td colspan="2">
			        <br>
			        <span style="font-size:13px; font-weight:bold; color:#36C">Điều kiện vé của chuyến bay <?=$route['airline']?> (<?=$route['from']['city']?> -&gt; <?=$route['to']['city']?>):</span>
					<hr style="background:#39C; height:1px; border:0px;">
			        </td>
			    </tr>
				<tr>
					<td colspan="2" style="padding-left:30px">					
						<?=$detail['fare_rules']?>
					</td>
				<tr>
				
				<?php endforeach;?>
			<?php endif;?>
		<?php endif;?>
	
	

		<?php if(!empty($invoice_ref) && $hold_status['is_allow_hold'] && ($payment_info['method'] == PAYMENT_METHOD_CREDIT_CARD || $payment_info['method'] == PAYMENT_METHOD_DOMESTIC_CARD)):?>
			<tr>
		    	<td colspan="2">
		        <br>
		        <span style="font-size:13px; font-weight:bold; color:#36C">Link thanh toán trực tuyến bằng thẻ ATM hoặc thẻ Visa/Master</span>
				<hr style="background:#39C; height:1px; border:0px;">
		        </td>
		    </tr>
		    
		    <tr>
				<td colspan="2" style="padding-left:30px">
					<?php 
						$invoice_link = site_url('thanh-toan/hoa-don.html').'?ref='.$invoice_ref;
					?>					
					<a target="blank_" href="<?=$invoice_link?>"><?=$invoice_link?></a>
				</td>
			<tr>
		<?php endif;?>
	
	<?php endif;?>
	
	<?php if($payment_info['method'] == PAYMENT_METHOD_BANK_TRANSFER):?>
		<tr>
	    	<td colspan="2">
	        <br>
	        <span style="font-size:13px; font-weight:bold; color:#36C">Thông tin chuyển khoản ngân hàng</span>
			<hr style="background:#39C; height:1px; border:0px;">
	        </td>
	    </tr>
	    
	    <?php foreach ($bank_transfer as $bank):?>
	    	<?php if(empty($payment_info['bank']) || $payment_info['bank'] == $bank['bank_id']):?>
	    	<tr>
				<td colspan="2" style="padding-left:30px;padding-bottom:10px;">
					<b><?=$bank['bank_name']?></b><br>
					<p><?=$bank['branch_name']?></p>
	                <p><?=lang('account_number')?> <?=$bank['account_number']?></p>
	                <p style="border-bottom:1px solid #CCC;padding-bottom:10px;"><?=lang('account_name')?> <?=$bank['account_name']?></p>
				</td>
			<tr>
			<?php endif;?>
	    <?php endforeach;?>
	
	<?php endif;?>			
</table>
<p>&nbsp;</p>
<p><b>Đặt vé máy bay - <?=BRANCH_NAME?></b></p>
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