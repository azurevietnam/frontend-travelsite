<div class="bpv-payment-methods margin-top-20">
	<h2 class="bpv-color-title">
		<?=lang('select_payment_methods')?>
	</h2>
	
	<input type="hidden" id="payment_method" name="payment_method" value="">
	
	<span class="p-notes"><?=lang('please_select_payment_method')?></span>
	
	<?php if( (isset($payment_status) && $payment_status == INVOICE_FAILED) || isset($VIEW_INVOICE) ):?>
	
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_DOMESTIC_CARD?>" 
			paymenturl="<?=get_domestic_payment_url($invoice)?>">
		<span class="icon p-domestic-card payment_icon"></span>
		<span class="icon icon_no_tick payment_icon"></span>
		<div class="contents">
			<h5 class="bpv-color-title"><?=lang('domestic_cards')?></h5>
			<span class="margin-top-5">
				<p><?=lang('domestic_cards_sub_title')?></p>
			</span>
			<div class="hidden_paymethod hidden">
				<p><?=lang('domestic_cards_desc')?></p>
				<img src="<?=get_static_resources('/media/icon/onepay-banks.23032015.png')?>">
			</div>
		</div>
	</div>
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_CREDIT_CARD?>" 
			paymenturl="<?=get_international_payment_url($invoice)?>">
		<span class="icon p-credit-card payment_icon"></span>
		<span class="icon icon_no_tick payment_icon"></span>
		<div class="contents">
			<h5 class="bpv-color-title"><?=lang('credit_debit_cards')?></h5>
			<span class="margin-top-5">
				<p><?=lang('credit_debit_cards_desc')?></p>
			</span>
		</div>
	</div>
	
	
	<?php endif;?>
	
	
</div>

<script>
	$(function() {
	    $('.each_paymethod').click(function () {
			// add selected method
			$('.each_paymethod').removeClass('active');
			$(this).addClass('active');

			$('.each_paymethod').find('.icon_no_tick').removeClass('icon_tick');
			$(this).find('.icon_no_tick').addClass('icon_tick');

			$('.each_paymethod').find('.hidden_paymethod').addClass('hidden');
			$(this).find('.hidden_paymethod').removeClass('hidden');

			$('#payment_method').val($(this).attr('paymentmethod'));
		});
	});
</script>