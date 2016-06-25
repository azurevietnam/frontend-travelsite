
<h2 class="bpv-color-title">
	<?=lang('select_payment_methods')?>
</h2>

<div class="bpv-payment-methods">
	<!-- 
	<span class="p-notes"><?=lang('please_select_payment_method')?></span>
	 -->
	<input type="hidden" id="payment_method" name="payment_method" value="">
	
	<div class="panel-group" id="accordion">
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title bpv-color-title">
		        <a data-toggle="collapse" href="#collapseOne">
		          1. <?=lang('flight_payment_method_1')?>
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse in">
		      <div class="panel-body">
		         <p>*<?=lang('flight_payment_method_1_note')?></p>   
		         <div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_DOMESTIC_CARD?>">
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
				<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_CREDIT_CARD?>">
					<span class="icon p-credit-card payment_icon"></span>
					<span class="icon icon_no_tick payment_icon"></span>
					<div class="contents">
						<h5 class="bpv-color-title"><?=lang('credit_debit_cards')?></h5>
						<span class="margin-top-5">
							<p><?=lang('credit_debit_cards_desc')?></p>
						</span>
					</div>
				</div>

		      </div>
		    </div>
		  </div>
		 <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title bpv-color-title">
		        <a data-toggle="collapse" href="#collapseTwo">
		          2. <?=lang('flight_payment_method_2')?>
		        </a>
		      </h4>
		    </div>
		    <div id="collapseTwo" class="panel-collapse collapse in">
		      <div class="panel-body">
		      	<p>*<?=lang('flight_payment_method_2_note')?></p>   
		      	<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_BANK_TRANSFER?>">
					<span class="icon p-bank-transfer payment_icon"></span>
					<span class="icon icon_no_tick payment_icon"></span>
					<div class="contents">
						<h5 class="bpv-color-title"><?=lang('bank_transfer')?></h5>
						<div class="hidden_paymethod hidden">
							<?php foreach ($bank_transfer as $key=>$bank):?>
            				<div class="bank-list">
            					<i class="bank_icon bank_<?=$bank['bank_id']?>"></i>
            
            					<ul class="list-unstyled bpv-color-title" id="<?=$bank['bank_id']?>">
            						<li>
                    			      <input type="radio" value="<?=$bank['bank_id']?>" name="payment_bank" id="bank_<?=$bank['bank_id']?>">
                    			      <label class="bank-name" for="bank_<?=$bank['bank_id']?>"><?=$bank['bank_name']?></label>
            						</li>
            						<li><?=$bank['branch_name']?></li>
            						<li><?=lang('account_number')?> <?=$bank['account_number']?></li>
            						<li><?=lang('account_name')?> <?=$bank['account_name']?></li>
            					</ul>
            				</div>
            				<?php endforeach;?>
						</div>
					</div>
				</div>
				<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_AT_OFFICE?>">
					<span class="icon p-office payment_icon"></span>
					<span class="icon icon_no_tick payment_icon"></span>
					<div class="contents">
						<h5 class="bpv-color-title"><?=lang('payment_at_office')?></h5>
						<span class="margin-top-5">
							<p>
							<?='<b>'.lang('company_address_label') . '</b> ' . lang('company_address')?>
							<a class="company-map" href="javascript:void(0)" onclick="javascript:window.open('<?=get_url(COMPANY_ADDRESS_PAGE)?>', '_blank','width=800,height=600')">(<?=lang('view_map')?>)</a>
							<br><?='<b>'.lang('company_hcm_address_label') . '</b> ' . lang('company_hcm_address')?>
							<br><?=lang('payment_working_times')?>
							</p>
						</span>
					</div>
				</div>
				
				<div class="each_paymethod" paymentmethod="<?=PAYMENT_METHOD_AT_HOME?>">
					<span class="icon p-home payment_icon"></span>
					<span class="icon icon_no_tick payment_icon"></span>
					<div class="contents">
						<h5 class="bpv-color-title"><?=lang('payment_at_home')?></h5>
						<span class="margin-top-5">
							<p><?=lang('payment_at_home_sub_title')?></p>
						</span>
						<div class="hidden_paymethod hidden">
							<p><?=lang('payment_at_home_desc')?></p>
						</div>
					</div>
				</div>	
		      		
		      	
		      </div>
		    </div>
		  </div>
	</div>
	
	
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