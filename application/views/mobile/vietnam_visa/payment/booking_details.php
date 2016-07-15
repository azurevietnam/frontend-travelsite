<div class="bpv-panel">
    <div class="panel-heading"><b><?=lang('booking_details')?></b></div>
    <div class="panel-body rate-tables">
        <div class="row">
            <div class="col-xs-5 no-padding"><b><?=lang('lb_description')?></b></div>
            <div class="col-xs-7 no-padding text-right">
            <?=$my_booking['service_name']?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_unit')?></b></div>
            <div class="col-xs-6 no-padding text-right">
            <?=$my_booking['unit']?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_amount')?></b></div>
            <div class="col-xs-6 no-padding text-right">
            <span id="visa_total_fee"><?=CURRENCY_SYMBOL . ' ' . $my_booking['selling_price']?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang_arg('label_visa_bank_fee', $bank_fee)?></b></div>
            <div class="col-xs-6 no-padding text-right">
            <span id="visa_bank_fee"><?=CURRENCY_SYMBOL . ' ' . number_format($my_booking['selling_price'] * $bank_fee/100, 2)?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 no-padding"><b><?=lang('lb_total_payment')?>:</b></div>
            <div class="col-xs-6 no-padding text-right text-price">
            USD <span id="visa_final_total"><?=$my_booking['final_total']?></span>
            </div>
        </div>
     </div>
</div>