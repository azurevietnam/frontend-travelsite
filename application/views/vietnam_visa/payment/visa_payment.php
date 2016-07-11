<?=$breadcrumb?>
<div class="col-xs-12">
<form method="POST" name="frmPayment" action="<?=get_page_url(VN_VISA_PAYMENT_PAGE)?>">
	
	<input type="hidden" id="numb_visa" value="<?=$visa_booking['number_of_visa']?>">
	<input type="hidden" id="visa_nationality" value="<?=$visa_booking['nationality']?>">
	<input type="hidden" id="visa_type" value="<?=$visa_booking['type_of_visa']?>">
	<input type="hidden" id="rush_service" value="<?=$visa_booking['processing_time']?>">
	<input type="hidden" id="bank_fee" value="<?=$bank_fee?>">
	
	<h3 class="margin-top-10 text-highlight"><?=lang('please_recheck_information')?></h3>
	<table class="table table-bordered">
        <caption><?=lang('lbl_visa_booking')?>.</caption>
        <thead>
    		<tr>
    			<th align="left" width="40%"><?=lang('type_of_visa')?></th>
    			<th class="text-center" nowrap="nowrap"><?=lang('date_of_arrival')?></th>
    			<th class="text-center" nowrap="nowrap"><?=lang('date_of_exit')?></th>
    			<th class="text-center" nowrap="nowrap"><?=lang('processing_time')?></th>
    			<th align="left" nowrap="nowrap"><?=lang('lb_arrival_airport')?></th>
    			<th align="left" nowrap="nowrap"><?=lang('flight_number')?></th>
    		</tr>
		</thead>
		<tbody>
		<tr>
			<td align="left">
				<?=lang('vietnam_visa') .' - '. translate_text($visa_types[$visa_booking['type_of_visa']])?>
			</td>
			<td align="center" nowrap="nowrap">
                <?=!empty($visa_booking['arrival_date']) ? date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['arrival_date'])) : ''?>
			</td>
			<td align="center" nowrap="nowrap">
                <?=!empty($visa_booking['exit_date']) ? date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['exit_date'])) : ''?>
			</td>
			<td align="center"><?=translate_text($rush_services[$visa_booking['processing_time']])?></td>
			<td align="left">
                <?=get_airport($airports, $visa_booking['arrival_airport'])?>
			</td>
			<td align="left"><?=$visa_booking['flight_number']?></td>
		</tr>
		</tbody>
	</table>
	
	<?=$visa_applications?>
	
	<div class="margin-top-10">
        <p><b><?=lang('important_notes')?>:</b></p>
		<ul class="text-price">
			<li><?=lang('visa_note_1')?></li>
			<li><?=$visa_booking['type_of_visa']<=2?lang('visa_special_notes'):lang('visa_special_notes_2')?></li>
			<li><?=$receive_date?></li>
			<li><?=lang('visa_special_notes_3')?></li>
		</ul>
	</div>
	
	<?=$booking_details?>
	
	<div class="form-horizontal payment-contact-form">
	<?=$contact_form?>
	</div>
	
	<h3 class="text-highlight border-title"><?=lang('term_and_condition')?></h3>
	<div class="clearfix">
		<ul>
			<li><?=lang('visa_term_1')?></li>
			<li><?=lang('visa_term_2')?></li>
			<li><?=lang('visa_special_notes')?></li>
		</ul>
	</div>
	
	<div class="margin-top-10 checkbox">
		<label for="agree_cancelpolicy" class="text-highlight">
            <input type="checkbox" name="conditionsAgreement" id="agree_cancelpolicy">
            <?=lang('read_and_agree_term_condition')?>
		</label>
	</div>
	
	<div class="row">
        <div class="margin-top-10 col-xs-3">
            <div class="btn btn-lg btn-yellow btn-block" onclick="book()"><?=lang('pay_by_credit_card')?></div>
        </div>
	</div>
	
</form>
</div>

<script>
	check_form();
</script>