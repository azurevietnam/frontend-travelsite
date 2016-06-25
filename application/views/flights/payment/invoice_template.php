<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>Hoá đơn thanh toán đặt vé - <?=lang('company_name')?></title>
	<style>
		body {
			width: 100% !important;
			-webkit-text-size-adjust: 100%;
			-ms-text-size-adjust: 100%;
			margin: 0;
			padding: 0;
			font-family: DejaVu Sans, sans-serif;
			font-size: 13px;
			background-color: #FFFFFF
		}
		
		img {
			outline: none;
			text-decoration: none;
			-ms-interpolation-mode: bicubic;
		}
		
		a img {
			border: none;
		}
		
		p {
			margin: 1em 0;
		}
		
		table td {
			border-collapse: collapse;
		}
		
		table {
			border-collapse: collapse;
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}
		
		a {
			text-decoration: none;
			color: #3385D6;
		}
		h1,h2,h3 {padding: 0; margin: 10px 0}
		h1 {font-size: 18px; margin: 20px 0}
		h2 {font-size: 14px}
		h3 {font-size: 13px}
		
		.wrap-table {border-spacing: 0px; border-collapse: collapse; margin: 0 auto; width: 700px}
		.user-info {width: 100%; line-height: 20px; margin-bottom: 10px}
		.payment-detail {
			border-left: 1px solid #ccc;
			border-spacing: 0;
			border-top: 1px solid #ccc;
			empty-cells: show;
			width: 100%;
		}
		
		.payment-detail th {
			font-weight: bold;
			background-color: #eee
		}
		
		.payment-detail td,.payment-detail th {
			border-bottom: 1px solid #ccc;
			border-right: 1px solid #ccc;
			padding: 7px;
		}
		.price {
			color: #B30000; font-weight: bold;
		}
		.policy {font-size: 12px;padding-top: 10px}
		.policy ul {list-style: decimal; line-height: 18px}
		
		.btn_pay {
			border-radius: 3px;
			font-size: 14px;
			font-weight: bold;
			padding: 10px 10px 7px;
			text-align: center;
			cursor: pointer;
		    border: 0;
			background-color: #FCA903;
			color: #fff;
			border-bottom: 3px solid #BD7F02;
			width: 160px;
		}
	</style>
</head>
<body>
	<table cellspacing="0" cellpadding="0" border="0" class="wrap-table">
		<tbody>
			<tr>
				<td align="left" width="50%">
					<img src="data:image/png;base64,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" />
				</td>
				<td align="right" width="50%">
					<ul style="list-style: none; line-height: 18px">
						<li style="font-size: 14px"><?=lang('company_name')?></li>
						<li>Email: sales@Bestviettravel.xyz</li>
						<li>Tel: (04) 3978 1425 - Fax: +84 4 3624-9007</li>
					</ul>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<h1>Hoá đơn thanh toán</h1>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table cellspacing="0" cellpadding="0" border="0" class="user-info">
						<tr>
							<td width="20%" nowrap="nowrap"><b>Mã hoá đơn:</b></td>
							<td><?=$invoice['invoice_reference']?></td>
							<td align="right"><b>Ngày đặt:</b> <?=format_bpv_date($invoice['date_created'], DATE_FORMAT, true)?></td>
						</tr>
						<tr>
							<td><b>Tên khách hàng:</b></td>
							<td colspan="2"><?=$invoice['customer']['full_name']?></td>
						</tr>
					</table>
				</td>
			</tr>
			<?php
					$customer_booking = $invoice['customer_booking'];
					$service_reservations = $invoice['customer_booking']['service_reservations'];
			?>
			<tr>
				<td align="left" colspan="2">
				<h2>Thông tin chuyến bay</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-bottom: 20px">
					<table cellspacing="0" cellpadding="0" border="0" class="payment-detail">
						<tr>
							<th align="left"><?=lang('tbl_airline')?></th>
							<th align="center" nowrap="nowrap"><?=lang('tbl_flight_code')?></th>
							<th align="left" nowrap="nowrap"><?=lang('tbl_itineray')?></th>
							<th align="left" nowrap="nowrap"><?=lang('tbl_departure_date')?></th>
							<th align="center" nowrap="nowrap"><?=lang('tbl_departure_time')?></th>
							<th align="center" nowrap="nowrap"><?=lang('tbl_arrival_time')?></th>
						</tr>
						
						<?php foreach ($service_reservations as $route):?>
						
						<?php if(!empty($route['flight_code'])):?>
						
							<tr>
								<td align="left">
									<?=isset($valid_airline_codes[$route['airline']]) ? $valid_airline_codes[$route['airline']] : $route['airline']?>
								</td>
								<td align="center" nowrap="nowrap">
									<?=$route['flight_code']?>
								</td>
								<td align="left" nowrap="nowrap">
									<?=lang('flight_from')?>: <b><?=$route['flight_from']?></b>
									<br>
									<?=lang('flight_to')?>: <b><?=$route['flight_to']?></b>
								</td>
								<td align="left">
									<?=format_bpv_date($route['start_date'], DATE_FORMAT, true)?>
								</td>
								<td align="center">
									<?=$route['departure_time']?>
								</td>
								<td align="center">
									<?=$route['arrival_time']?>
								</td>
							</tr>
						
						<?php endif;?>
						
						<?php endforeach;?>
						
					</table>
				</td>
			</tr>
			
			<?php if(!empty($customer_booking['flight_users'])):?>
			
			<tr>
				<td align="left" colspan="2">
				<h2>Thông tin hành khách</h2>
				</td>
			</tr>
			
			<tr>
				<td colspan="2" style="padding-bottom: 10px">
					<table cellspacing="0" cellpadding="0" border="0" class="payment-detail">
						<tr>
							<th align="left">No.</th>
							<th align="left"><?=lang('full_name')?></th>
							<th align="left"><?=lang('gender')?></th>
							<th align="left"><?=lang('date_of_birth')?></th>
							<th align="left"><?=lang('send_baggage')?></th>
						</tr>
						
						<?php foreach ($customer_booking['flight_users'] as $key=>$user):?>
						
						<tr>
							<td>
								<?=lang('passenger')?> <?=($key + 1)?>,
								<?php if($user['type'] == 1):?>
									<?=lang('search_fields_adults')?>
								<?php elseif($user['type'] == 2):?>
									<?=lang('search_fields_children')?>
								<?php else:?>
									<?=lang('search_fields_infants')?>
								<?php endif;?>
							</td>
							<td nowrap="nowrap">
								<?=$user['first_name'].' '.$user['last_name']?>
							</td>
							<td align="left" nowrap="nowrap">
								<?=($user['gender'] == 1? lang('gender_male'):lang('gender_female'))?>
							</td>
							<td>
								<?php if($user['birth_day'] != null):?>
								<?=date(DATE_FORMAT, strtotime($user['birth_day']))?>
								<?php endif;?>
							</td>
							
							<td>
								<?=!empty($user['checked_baggage'])?$user['checked_baggage'] :'0 Kg'?>
							</td>
							
						</tr>
						
						<?php endforeach;?>
						
					</table>
				</td>
			</tr>
			
			<?php endif;?>
			
			
			<tr>
				<td align="left" colspan="2">
				<h2>Chi tiết thanh toán tiền vé</h2>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<table cellspacing="0" cellpadding="0" border="0" class="payment-detail">
						<tr>
							<th align="left" width="60%">Chuyến bay</th>
							<th align="center">Số lượng vé</th>
							<th align="right">Tổng tiền</th>
						</tr>
						<?php
							$total_price = $customer_booking['selling_price'];
							$nr_ticket = $customer_booking['adults'] + $customer_booking['children'] + $customer_booking['infants'];
						?>
						<tr>
							<td align="left">
								<?=$customer_booking['flight_short_desc']?>
							</td>
							<td align="center"><?=$nr_ticket?> vé</td>
							<td align="right" class="price">
								<?=number_format($total_price)?>
							</td>
						</tr>
						
						<?php if($invoice['amount']  > $total_price):?>
							
							<tr>
								<td align="right" colspan="2">
									Phí ngân hàng thu
								</td>

								<td align="right" class="price">
									<?=number_format($invoice['amount'] -  $total_price)?>
								</td>
							</tr>
						
						<?php endif;?>
					
						<tr>
							<th align="left" colspan="3">Thanh toán</th>
						</tr>
						<tr>
							<td align="right" colspan="2">Đã nhận thanh toán vào <?=format_bpv_date($invoice['date_modified'], DATE_TIME_FORMAT, true)?>:</td>
							<td align="right" class="price"><?=number_format($invoice['amount'])?></td>
						</tr>
						<tr>
							<td align="right" colspan="2">
								<b>Dư nợ:</b>
							</td>
							<td align="right" class="price">0.00 <?=lang('vnd')?></td>
						</tr>
					</table>
				</td>
			</tr>
			
			<tr>
				<td align="left" colspan="2" style="padding: 10px 0;">
					<ul style="color: #B20000; float: left; list-style: none; margin: 0; padding: 0; line-height: 18px">
						<li style="color: red"><b>Khách hàng lưu ý:</b></li>
						<li><?=lang('flight_special_note')?></li>					
					</ul>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2">
				<h2>Điều khoản đặt vé</h2>
				</td>
			</tr>
			<tr>
				<td align="left" colspan="2" class="policy" style="padding: 0 0 10px">
					<ul style="margin: 0 0 0 20px; padding: 0; float: left;">
						<li><?=lang('flight_term_1')?></li>
						<?php 
							$flights = $invoice['customer_booking']['service_reservations'];
						?>
						
						<?php foreach ($flights as $value):?>
							
							<?php if(!empty($value['fare_rules'])):?>
							<li style="border-bottom: 1px solid #DDD;color:#003580">
								<b>Điều kiện vé của chuyến bay <?=$value['flight_code']?>, <?=$value['flight_from']?> -&gt; <?=$value['flight_to']?>, 
								<?=format_bpv_date($value['start_date'], DATE_FORMAT, true)?>:</b>
							</li>
							
							<li style="padding-left:20px;list-style:none;">							
								
								<?=$value['fare_rules']?>
								
							</li>
							<?php endif;?>
						<?php endforeach;?>
					</ul>
				</td>
			</tr>
			
			<tr>
				<td align="left" colspan="2" style="border-top: 1px solid #ccc;">
					<h3><?=BRANCH_NAME?></h3>
				</td>
			</tr>
			<tr>
				<td align="left" style="padding-bottom: 10px; font-size: 12px">
					<ul style="list-style: none; margin: 0; padding: 0">
						<li>Email: sales@Bestviettravel.xyz</li>
						<li>Tel: (04) 3978 1425 - Fax: +84 4 3624-9007</li>
					</ul>
				</td>
				<td align="right" style="padding-bottom: 10px; font-size: 12px">
					Địa chỉ: 12A, Ngõ Bà Triệu, Phố Bà Triệu,<br> Quận Hai Bà Trưng, Hà Nội, Việt Nam
				</td>
			</tr>
		</tbody>
	</table>
</body>
</html>
