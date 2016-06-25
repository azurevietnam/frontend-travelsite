<h2 class="bpv-color-title pd-10">
	<?=lang('select_payment_methods')?>
</h2>

<div class="bpv-payment-methods data-area">
	
	<input type="hidden" id="payment_method" name="payment_method" value="">
	
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_BANK_TRANSFER?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('bank_transfer')?>
	    </h5>
		<div class="hidden_paymethod hidden">
			<ul class="list-unstyled bank-list">
				<?php foreach ($bank_transfer as $key=>$bank):?>
				<li>
					<div class="radio">
					    <label>
						<input type="radio" value="<?=$bank['bank_id']?>" name="payment_bank"><span class="bank-name"><?=$bank['bank_name']?></span>
						<div id="<?=$bank['bank_id']?>">
                            <p><?=$bank['branch_name']?></p>
                            <p><?=lang('account_number')?> <?=$bank['account_number']?></p>
                            <p><?=lang('account_name')?> <?=$bank['account_name']?></p>
                            <p class="text-center" style="margin-left: 0"><img src="<?=get_static_resources('/media/mobile/'.$bank['bank_id'].'.png')?>"></p>
                        </div>
                        </label>
                    </div>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_AT_OFFICE?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('payment_at_office')?>
	    </h5>
		<div class="hidden_paymethod hidden">
			<p>
			<?='<b>'.lang('company_address_label') . '</b> ' . lang('company_address')?>
			<a class="company-map" href="javascript:void(0)" onclick="javascript:window.open('<?=get_url(COMPANY_ADDRESS_PAGE)?>', '_blank','width=800,height=600')">(<?=lang('view_map')?>)</a>		
			</p>
			<p>
			 <?='<b>'.lang('company_hcm_address_label') . '</b> ' .lang('company_hcm_address')?>
			 <br><?=lang('payment_working_times')?>
			</p>
		</div>
	</div>
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_DOMESTIC_CARD?>">
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
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_CREDIT_CARD?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('credit_debit_cards')?>
	    </h5>
		<div class="hidden_paymethod hidden">
			<p><?=lang('credit_debit_cards_desc')?></p>
		</div>
	</div>
	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_AT_HOME?>">
	    <h5 class="bpv-color-title">
	       <span class="icon icon_no_tick payment_icon"></span>
	       <?=lang('payment_at_home')?>
	    </h5>
		<div class="hidden_paymethod hidden">
		    <p><?=lang('payment_at_home_sub_title')?></p>
			<p><?=lang('payment_at_home_desc')?></p>
		</div>
	</div>
	
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