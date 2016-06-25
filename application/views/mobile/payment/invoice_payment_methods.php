<h2 class="bpv-color-title" style="padding: 20px 10px 0 10px">
	<?=lang('select_payment_methods')?>
</h2>
	
<div class="bpv-payment-methods margin-top-10">

	<input type="hidden" id="payment_method" name="payment_method" value="">
	
	<?php if( (isset($payment_status) && $payment_status == INVOICE_FAILED) || isset($VIEW_INVOICE) ):?>
	
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_DOMESTIC_CARD?>" paymenturl="<?=get_domestic_payment_url($invoice)?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('domestic_cards')?>
	    </h5>
	    <div class="hidden_paymethod hidden">
            <p><?=lang('domestic_cards_sub_title')?></p>
			<p><?=lang('domestic_cards_desc')?></p>
			<img class="img-responsive" src="<?=get_static_resources('/media/icon/onepay-banks.23032015.png')?>">
	    </div>
	</div>
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_CREDIT_CARD?>" paymenturl="<?=get_international_payment_url($invoice)?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('credit_debit_cards')?>
	    </h5>
	    <div class="hidden_paymethod hidden">
	       <p><?=lang('credit_debit_cards_desc')?></p>
	    </div>
	</div>
	
	<?php endif;?>
	
</div>

<script>
$(function() {
    $('.each_paymethod h5').click(function () {
	    var selected = $(this).parent().attr('paymentmethod');
    	$('#payment_method').val('');
	    
		// add selected method
		$(this).parent().toggleClass('active');
		$(this).parent().find('.icon_no_tick').toggleClass('icon_tick');
		$(this).parent().find('.hidden_paymethod').toggleClass('hidden');

		if( $(this).parent().hasClass( "active" ) ) {
			$('#payment_method').val(selected);
		}
		$('.each_paymethod').each(function( index ) {
			if(selected != $(this).attr('paymentmethod')) {
				$(this).removeClass('active');
				$(this).find('.icon_no_tick').removeClass('icon_tick');
				$(this).find('.hidden_paymethod').addClass('hidden');
			}
		});
	});
});
</script>