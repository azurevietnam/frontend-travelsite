<?php if(count($my_booking_services) > 0):?>
<div id="overview" class="left_list_item_block">
	<h2 class="highlight"><?=lang('mybooking_overview') ?></h2>
	<ul style="list-style: none;">
	
	<?php foreach ($my_booking_services as $key=> $booking_item):?>
		<li style="padding-left: 10px; float: left; line-height: 20px">
			<?php
				$service_name = $booking_item['service_name'];
				if (strlen($service_name) > 30) {
					$service_name = substr($service_name, 0, 30) . '...';
				}
			?>
			<div style="font-size: 12px; float: left; width: 190px;font-size: 11px;"><?=$service_name?></div>
			<div style="float: left; text-align: right; width: 50px;font-size: 11px;"><?=CURRENCY_SYMBOL?><?=number_format($booking_item['total_price'], CURRENCY_DECIMAL)?></div>
		</li>
	<?php endforeach;?>
		<li>
			<div style="border-bottom: 1px dashed #AAA;width: 240px; float: left;margin: 3px 0 3px 10px;"></div>
		</li>
		
		<?php if ($my_booking_info['discount'] > 0):?>
		<li style="padding-left: 10px; float: left; line-height: 18px">
			<div style="font-size: 11px;float: left;width: 190px;text-align: right;">If book seperately</div>
			<div style="float: left; text-align: right; width: 50px;font-size: 11px;"><?=CURRENCY_SYMBOL?><?=number_format($my_booking_info['total_price'], CURRENCY_DECIMAL)?></div>
		</li>
		<li style="padding-left: 10px; float: left; line-height: 18px">
			<div style="font-size: 11px; font-weight: bold;float: left; width: 190px;text-align: right;">Discount for book together</div>
			<div style="float: left; text-align: right; width: 50px;font-size: 11px;">- <?=CURRENCY_SYMBOL?><?=number_format($my_booking_info['discount'], CURRENCY_DECIMAL)?></div>
		</li>
		<li>
			<div style="border-bottom: 1px dashed #AAA;width: 90%; float: left;margin: 3px 0 3px 10px;"></div>
		</li>
		<?php endif;?>
		<li style="padding-left: 10px; float: left; line-height: 20px">
			<div style="font-size: 13px; font-weight: bold;float: left; width: 190px; text-align: right;">Total:</div>
			<div style="float: left; color: #B30000;font-size: 13px; font-weight: bold;width: 50px;text-align: right;"><?=CURRENCY_SYMBOL?><?=number_format($my_booking_info['final_total'], CURRENCY_DECIMAL)?></div>
		</li>
		<li style="padding-left: 10px; float: left; line-height: 20px; width: 240px;">					
			<div class="more_tour" style="float: right; padding: 0; margin: 0">
				<span class="arrow">&rsaquo;</span>
				<a class="link_function" href="/my-booking">View Detail</a>
			</div>

		</li>
	</ul>
</div>
<?php endif;?>