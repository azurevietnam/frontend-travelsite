<h3 class="text-highlight border-title"><?=lang('booking_details')?></h3>
<table class="table table-bordered">
    <thead>
		<tr>
			<th align="left" width="60%"><?=lang('lb_description')?></th>
			<th class="text-center"><?=lang('lb_unit')?></th>
			<th align="right"><?=lang('lb_amount')?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="left">
				<?=$my_booking['service_name']?>
			</td>
			<td class="text-center"><?=$my_booking['unit']?></td>
			<td align="right"><span id="visa_total_fee"><?=CURRENCY_SYMBOL . ' ' . $my_booking['selling_price']?></span>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="2"><?=lang_arg('label_visa_bank_fee', $bank_fee)?></td>
			<td align="right"><span id="visa_bank_fee"><?=CURRENCY_SYMBOL . ' ' . number_format($my_booking['selling_price'] * $bank_fee/100, 2)?></span></td>
		</tr>
		<tr>
			<td align="right" colspan="2" style="font-size: 13px;">
				<b><?=lang('lb_total_payment')?>:</b>
			</td>
			<td align="right" class="text-price" style="font-size: 13px; font-weight: bold;">
				USD <span id="visa_final_total"><?=$my_booking['final_total']?></span>
            </td>
		</tr>
	</tbody>
</table>