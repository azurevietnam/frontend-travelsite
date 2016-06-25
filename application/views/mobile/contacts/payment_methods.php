<div class="container">
    <h2 class="bpv-color-title"><?=lang('payment_methods')?></h2>
    <ul class="payment-methods">
		<li>
			<h5>1. <?=lang('bank_transfer')?></h5>
			<div class="bpv-method">
				<?php foreach ($bank_transfer as $key=>$bank):?>
					<div class="bank-transfer">
						<span class="bank_icon bank_<?=$bank['bank_id']?>"></span>
						<ul>
							<li class="bank-name bpv-color-title">
								<?=$bank['bank_name']?>
							</li>
							<li>
								<label>Số tài khoản:</label> <b><?=$bank['account_number']?></b>
							</li>
							<li>
								<label>Chủ tài khoản:</label> <span style="text-transform: uppercase;"><?=$bank['account_name']?></span>
							</li>
							<li>
								<label>Chi nhánh:</label> <b><?=$bank['branch_name']?></b>
							</li>
						</ul>
					</div>
				<?php endforeach;?>
			</div>
		</li>
		<li>
			<h5>2. <?=lang('payment_at_office')?></h5>
			<div class="bpv-method">
				<?='<b>'.lang('c_address') . '</b>: ' . lang('company_address')?>
				<a class="company-map" href="javascript:void(0)"
					onclick="javascript:window.open('<?=get_url(COMPANY_ADDRESS_PAGE)?>', '_blank','width=800,height=600')">(<?=lang('view_map')?>)
				</a> <br>
				<?=lang('payment_working_times')?>
			</div>
		</li>
		<li>
			<h5>3. <?=lang('domestic_cards')?></h5>
			<div class="bpv-method">
				<p>
					<?=lang('domestic_cards_sub_title')?>
				</p>
				<p>
					<?=lang('domestic_cards_desc')?>
				</p>
				<img class="img-responsive" src="<?=get_static_resources('/media/icon/onepay-banks.23032015.png')?>">
			</div>
		</li>
		<li>
			<h5>4. <?=lang('credit_debit_cards')?></h5>
			<div class="bpv-method">
				<p>
					<?=lang('credit_debit_cards_desc')?>
				</p>
			</div>
		</li>
		<li>
			<h5>5. <?=lang('payment_at_home')?></h5>
			<div class="bpv-method">
				<p>
					<?=lang('payment_at_home_sub_title')?>
				</p>
				<p>
					<?=lang('payment_at_home_desc')?>
				</p>
				
			</div>
		</li>
	</ul>
</div>
