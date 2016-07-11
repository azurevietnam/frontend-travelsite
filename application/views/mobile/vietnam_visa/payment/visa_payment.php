<?=$breadcrumb?>
<div class="col-xs-12">
<form method="POST" name="frmPayment" action="<?=get_page_url(VN_VISA_PAYMENT_PAGE)?>">
	
	<input type="hidden" id="numb_visa" value="<?=$visa_booking['number_of_visa']?>">
	<input type="hidden" id="visa_nationality" value="<?=$visa_booking['nationality']?>">
	<input type="hidden" id="visa_type" value="<?=$visa_booking['type_of_visa']?>">
	<input type="hidden" id="rush_service" value="<?=$visa_booking['processing_time']?>">
	<input type="hidden" id="bank_fee" value="<?=$bank_fee?>">
	
	<h3 class="margin-top-10 text-highlight"><?=lang('please_recheck_information')?></h3>
	<div class="bpv-panel">
        <div class="panel-heading"><b><?=lang('lbl_visa_booking')?></b></div>
        <div class="panel-body rate-tables">
            <div class="row">
                <div class="col-xs-6 no-padding"><b><?=lang('type_of_visa')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                    <?=lang('vietnam_visa') .' - '. translate_text($visa_types[$visa_booking['type_of_visa']])?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 no-padding"><b><?=lang('date_of_arrival')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                <?=!empty($visa_booking['arrival_date']) ? date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['arrival_date'])) : ''?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 no-padding"><b><?=lang('date_of_exit')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                <?=!empty($visa_booking['exit_date']) ? date(DATE_FORMAT_DISPLAY, strtotime($visa_booking['exit_date'])) : ''?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 no-padding"><b><?=lang('processing_time')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                <?=translate_text($rush_services[$visa_booking['processing_time']])?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 no-padding"><b><?=lang('lb_arrival_airport')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                <?=get_airport($airports, $visa_booking['arrival_airport'])?>
                </div>
            </div>
            <div class="row no-border">
                <div class="col-xs-6 no-padding"><b><?=lang('flight_number')?></b></div>
                <div class="col-xs-6 no-padding text-right">
                <?=$visa_booking['flight_number']?>
                </div>
            </div>
        </div>
	</div>
	
	<?=$visa_applications?>
	
	<div class="margin-top-10">
        <p><b><?=lang('important_notes')?>:</b></p>
		<ul class="text-price" style="padding-left: 20px">
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
	
	<div class="row margin-top-10 margin-bottom-20">
        <div class="col-xs-12">
            <div class="btn btn-lg btn-yellow btn-block" onclick="book()"><?=lang('pay_by_credit_card')?></div>
        </div>
	</div>
	
</form>
</div>

<script>
	check_form();
</script>