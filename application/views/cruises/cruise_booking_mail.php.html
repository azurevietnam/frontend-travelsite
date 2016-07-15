<html>
<head>
<style type="text/css">

	body,table{font-family:Arial,Verdana;font-size:12px;}


.price_total{
	color:#B30000;
	font-weight:bold;
}

.special{
	color:#E47911;
	color:#EB8F00;
	color:#FE8802;
	color:RGB(254,136,2);
}

.sys_border_1{
	border:1px solid #779BCA;
}

.items{
	clear:both;
	padding:5px 10px;
}
.items .col_1 {
	float:left;
	width:150px;
}
.items .col_2 {
	float:left;
	
}

.border {
	font-size: 12px;
	border-collapse: collapse;
	border: 1px solid #7BA0CD;
	empty-cells: show;
}

.border thead {
	font-weight:bold; background-color: #D3DFEE;
	color: #333;
}

.border thead th {
	border: 1px solid #7BA0CD;
	padding: 4px 4px 4px 4px;
}

.border td {
	border: 1px solid #7BA0CD;
	padding: 4px 4px 4px 4px;
}

.margin_top_10{
	margin-top: 10px; 
}
	

</style>
</head>
<body style="font-family: Arial;font-size:12px;">

<p>Dear <?=$cus['title_text'] . '. ' . $cus['full_name']?>,</p>
<p>Your request has been submitted to <a href="<?=site_url()?>">www.<?=strtolower(SITE_NAME)?></a>. One of our travel consultants will respond to you within 1 working day.

<p><b>Please note: </b>If you submit incorrect information, please contact our travel consultants to change your request at <a target="_blank" href="mailto:reservation@<?=strtolower(SITE_NAME)?>">reservation@<?=strtolower(SITE_NAME)?></a>.</p>
<h1>Please review the details below of what you selected:</h1>

<h2>Customer Information Information</h2>
<div style="width: 600px;">
	<table width="200%">
		<tr>
			<td width="250">
				<b><?=lang('full_name')?>:</b>
			</td>
			<td>
				<?=$cus['title_text'] . '. ' . $cus['full_name']?>
			</td>
		<tr>
		
		<tr>
			<td ><b><?=lang('email_address')?>:</b></td>
			<td ><?=$cus['email']?></td>
		</tr>	
		
		<tr>
			<td ><b><?=lang('phone_number')?>:</b></td>
			<td >
				<?=$cus['phone']?>
			</td>
		</tr>
		
		<tr>
			<td ><b><?=lang('fax_number')?>:</b></td>
			<td >
				<?=$cus['fax']?>
			</td>
		</tr>	
		
		<tr>
			<td ><b><?=lang('country')?>:</b></td>
			<td >
				<?=$cus['country_name']?>
			</td>
		</tr>
		
		<tr>
			<td ><b><?=lang('city')?>:</b></td>
			<td ><?=$cus['city']?></td>
		</tr>				
	
	</table>	
</div>

<h2>Booking Information</h2>

<div style="clear: both; width: 600px;">	
	<table width="100%">
		<tr>
			<td width="250"><b>Booking Number:</b></td>
			<td>CRUISE_BOOKING_<?=$cruise_booking['id']?></td>
		</tr>
		<tr>
			<td><b>Booking Date:</b></td>
			<td><?=date(DB_DATE_TIME_FORMAT, time())?></td>
		</tr>	
		<tr>
			<td><b><?=lang('cruise_ship')?>:</b></td>
			<td ><a href="<?=site_url(url_builder(CRUISE_DETAIL, $cruise['url_title'], true))?>"><?=$cruise['name']?></a>	 
			</td>
		</tr>
		
		<tr >
			<td ><b><?=lang('cruise_program')?>:</b></td>
			<td ><a href="<?=site_url(url_builder(CRUISE_PROGRAM_DETAIL, $cruise_program['url_title'], true))?>"><?=$cruise_program['name']?></a></td>
		</tr>
		
		<tr >
			<td ><b><?=lang('cruise_destinations')?>:</b></td>
			<td ><?=$cruise_program['route']?></td>
		</tr>
	
		<tr >
			<td><b><?=lang('cruise_duration')?>:</b></td>
			<td ><?=$durations[$cruise_program['duration']]?></td>
		</tr>
		
		<tr >
			<td><b><?=lang('cruise_departure')?>:</b></td>
			<td ><?=date(DB_DATE_FORMAT, strtotime($search_criteria['departure_date']))?></td>
		</tr>
	</table>
</div>

<div style="float: left; width: 600px;">
	<table cellpadding="0" cellspacing="0" class="border" width="100%">
		<thead>
			<tr>
				<td width="30%"><?=lang('cruise_cabin')?></td>
				<td width="40%"><?=lang('nr_items')?></td>
				<td width="30%" align="center"><?=lang('price')?></td>
			</tr>
		</thead>
		<tbody>
			<?php $index = 0;?>
			<?php foreach ($cruise['cabins'] as $cabin):?>
				<?php if ($cabin_selections[$cabin['id']]['nr_total'] > 0):?>
				
				<tr>
					<td><?=$cabin['name']?></td>
					<td>
						<div style="margin-left: 20px;">
							<ul>
								<?php if ($cabin_selections[$cabin['id']]['nr_single'] > 0):?>
									<li>
										<?=$cabin_selections[$cabin['id']]['nr_single'].' '.lang('single')?>
										
										<span class="price_total" style="float: right;"><?=CURRENCY_SYMBOL?><?=number_format($cruise_program['price'][$cabin['id']]['single_promotion_price_'.$cabin_selections[$cabin['id']]['nr_single']], CURRENCY_DECIMAL)?></span>										
									</li>
								<?php endif;?>
								
								<?php if ($cabin_selections[$cabin['id']]['nr_double'] > 0):?>
									<li>
										<?=$cabin_selections[$cabin['id']]['nr_double'].' '.lang('double')?>
										
										<span class="price_total" style="float: right;"><?=CURRENCY_SYMBOL?><?=number_format($cruise_program['price'][$cabin['id']]['double_promotion_price_'.$cabin_selections[$cabin['id']]['nr_double']], CURRENCY_DECIMAL)?></span>										
									</li>
								<?php endif;?>
								
								<?php if ($cabin_selections[$cabin['id']]['nr_children'] > 0):?>
									<li>
										<?=$cabin_selections[$cabin['id']]['nr_children'].' '.lang('double_children')?>
										
										<span class="price_total" style="float: right;"><?=CURRENCY_SYMBOL?><?=number_format($cruise_program['price'][$cabin['id']]['children_promotion_price_'.$cabin_selections[$cabin['id']]['nr_children']], CURRENCY_DECIMAL)?></span>										
									</li>
								<?php endif;?>
							</ul>
						</div>	
					
					</td>
					<?php if ($index == 0):?>
					
						<td align="center" rowspan="<?=$nr_booked_cabin?>">
							<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_cabin_price, CURRENCY_DECIMAL)?></span>
						</td>
					
					<?php $index++;?>
					<?php endif;?>
				</tr>
				<?php endif;?>
			<?php endforeach;?>
		</tbody>
		
		<?php if (count($cruise_program['required_services']) > 0):?>
			<tbody>
				<?php foreach ($cruise_program['required_services'] as $key => $service):?>
					<tr>
						<?php if ($key == 0):?>
							<td rowspan="<?=count($cruise_program['required_services'])?>"><b><?=lang('required_services')?></b></td>
						<?php endif;?>
						
						<td>
							<div style="margin-left: 20px;">
								<?=$service['name']?>
								
								<span style="float: right;">
									<span class="price_total">
										<?php if($service['price_per'] == 2):?>
											<?=$service['price'].' %'?>
										<?php else:?>
										<?=CURRENCY_SYMBOL?><?=number_format($service['price'], CURRENCY_DECIMAL)?>
										<?php endif;?>
									</span>
									
									<?php if ($service['price_per'] == 0):?>
										<?=lang('per_pax')?>
									<?php elseif ($service['price_per'] == 1):?>
										<?=lang('per_item')?>
									<?php elseif($service['price_per'] == 2):?>
										<?=lang('per_percent')?> <?=lang('on_rates')?>
									<?php endif;?>
								
								</span>
								 
							</div>
						</td>
						
						<td align="center">							
							<?php if($service['is_free'] == 0):?>									
								<?php if ($service['price_per'] == 0):?>
									<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price']*$nr_pax, CURRENCY_DECIMAL)?></span> /<?=$nr_pax.' pax'?>
								<?php elseif ($service['price_per'] == 1):?>
									<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price'], CURRENCY_DECIMAL)?></span><?=lang('per_item')?>
								<?php elseif($service['price_per'] == 2):?>
									<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price']/100 * $total_cabin_price, CURRENCY_DECIMAL)?></span>
								<?php endif;?>									
							<?php else:?>	
								<span class="special"><i><b><?=lang('free')?></b></i></span>
							<?php endif;?>
						</td>
						
					</tr>
				<?php endforeach;?>
			</tbody>
			<?php endif;?>
			
		<?php if (count($cruise_program['transfers']) > 0 && count($route_selections) > 0):?>
			<tbody>
				<?php $index = 0;?>
				<?php foreach ($cruise_program['transfers'] as $key => $transfer):?>
					<?php if(in_array($key, $route_selections)):?>
					<tr>
						<?php if ($index == 0):?>
							<td rowspan="<?=count($route_selections)?>"><b><?=lang('transfer_service')?></b></td>
						<?php endif;?>
						
						<td>
							<div style="margin-left: 20px;">
								 <?=$key?>
							</div>
							<div style="margin-left: 50px">
								<ul>
									<?php foreach ($transfer as $k => $value):?>
										
										<?php if(in_array($value['transfer_route_id'].'_'.$value['id'], $transfer_selections)):?>
										
										<li style="margin-top: 5px;">
											<span><?=$value['name']?></span>
											<span style="float: right;">
												<span class="price_total">											
													<?=CURRENCY_SYMBOL?><?=number_format($value['price'], CURRENCY_DECIMAL)?>
												</span>
												
												<?php if(isset($value['price_per'])):?>
													<?php if ($value['price_per'] == 0):?>
																											
														<?=lang('per_pax')?>																								
													
													<?php endif;?>
												<?php else:?>
																								
													<?=lang('per_car')?>
													
												<?php endif;?>											
											</span>
										</li>
										<?php endif;?>						
									<?php endforeach;?>									
								</ul>
							</div>
						</td>
						
						<td align="center">	
							<?php if($route_prices[$key] == 0):?>
								<span class="special"><i><b><?=lang('free')?></b></i></span>
							<?php else:?>						
							<span class="price_total">											
								<?=CURRENCY_SYMBOL?><?=number_format($route_prices[$key], CURRENCY_DECIMAL)?>
							</span>
							<?php endif;?>
						</td>
						
					</tr>
					<?php $index++?>
					<?php endif;?>
				<?php endforeach;?>
			</tbody>
		<?php endif;?>
		
		<?php if (count($cruise_program['optional_services']) > 0 && count($optional_service_selections) > 0):?>
			<tbody>
				<?php $index = 0;?>
				<?php foreach ($cruise_program['optional_services'] as $key => $service):?>
					<?php if(in_array($service['id'], $optional_service_selections)):?>
						<tr>
							<?php if ($index == 0):?>
								<td rowspan="<?=count($optional_service_selections)?>"><b><?=lang('optional_services')?></b></td>
							<?php endif;?>
							
							<td>
								<div style="margin-left: 20px;">
									<?=$service['name']?> 
									
									<span style="float: right;">
										<span class="price_total">
											<?php if($service['price_per'] == 2):?>
												<?=$service['price'].' %'?>
											<?php else:?>
												<?=CURRENCY_SYMBOL?><?=number_format($service['price'], CURRENCY_DECIMAL)?>
											<?php endif;?>									
										</span>
										
										<?php if ($service['price_per'] == 0):?>
											<?=lang('per_pax')?>
										<?php elseif ($service['price_per'] == 1):?>
											<?=lang('per_item')?>
										<?php elseif($service['price_per'] == 2):?>
											<?=lang('per_percent')?> <?=lang('on_rates')?>
										<?php endif;?>
									
									</span>	
									
								</div>
							</td>
							
							<td align="center">
								
								
								<?php if($service['is_free'] == 0):?>									
									<?php if ($service['price_per'] == 0):?>
										<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price']*$nr_pax, CURRENCY_DECIMAL)?></span> /<?=$nr_pax.' pax'?>
									<?php elseif ($service['price_per'] == 1):?>
										<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price'], CURRENCY_DECIMAL)?></span><?=lang('per_item')?>
									<?php elseif($service['price_per'] == 2):?>
										<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($service['price']/100 * $total_cabin_price, CURRENCY_DECIMAL)?></span>
									<?php endif;?>									
								<?php else:?>	
									<span class="special"><i><b><?=lang('free')?></b></i></span>
								<?php endif;?>
							</td>
							
						</tr>
						<?php $index++;?>
					<?php endif;?>					
				<?php endforeach;?>
			</tbody>
			<?php endif;?>
			
			<?php if ($cruise_booking['special_requests'] != ''):?>
				<tbody>
					<tr>
						<td><b><?=lang('special_requests')?>:</b></td>
						<td colspan="3"><?=$cruise_booking['special_requests']?></td>
					</tr>
				</tbody>
			<?php endif;?>
			
			<tbody>
				<tr>
					<td colspan="2" align="right">
						<b>Total Price</b>
					</td>
					<td align="center"><span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($total_price, CURRENCY_DECIMAL)?></span></td>			
				</tr>
				<tr>
					<td colspan="2" align="right">
						<b>Deposit <?=$deposit_config?></b>
					</td>
					<td align="center"><span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($deposit, CURRENCY_DECIMAL)?></span></td>			
				</tr>
				<tr>
					<td colspan="2" align="right">
						<b>Balance By Cash</b>
					</td>
					<td align="center"><span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($by_cash, CURRENCY_DECIMAL)?></span></td>			
				</tr>
				
				<tr>
					<td colspan="2" align="right">
						<b>Balance By Credit Card</b>
					</td>
					<td align="center"><span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($by_credit_card, CURRENCY_DECIMAL)?></span></td>			
				</tr>
			</tbody>
			
	</table>

</div>



<p>&nbsp;</p>
<p><b>Reservation - <?=BRANCH_NAME?></b></p>
<p>
<b><?=BRANCH_NAME?>., JSC</b><br>
Head Office: 29/131, Trai Ca Alley, Truong Dinh Street,<br>
HBT Dist, Hanoi, Vietnam<br>
Email: sales@<?=strtolower(SITE_NAME)?><br>
Tel: (+84) 4 3576-5748<br>
Website: <a href="<?=site_url()?>">http://www.<?=strtolower(SITE_NAME)?></a><br>	
</p>
</body>
</html>