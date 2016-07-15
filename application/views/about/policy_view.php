<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(empty($is_flight_booking_page)):?>
<h1 class="highlight" style="padding-left: 0"><?=lang('tpc_terms_conditions') ?></h1>
<?php endif;?>
	<?=lang('tpc_terms_conditions_content', BRANCH_NAME , SITE_NAME, SITE_NAME ) ?>
	<ul id="overview">
		<li><span class="highlight"><?=lang('tpc_make_booking') ?></span>
			<p><?=lang('tpc_make_booking_content', SITE_NAME) ?></p>
			<p><strong><?=BRANCH_NAME?>., JSC</strong><br/>
			<p><?=lang('tpc_hanoi_office') ?> <?=lang('hanoi_office_address')?>, Hanoi, Vietnam.<br/>
			<?=lang('tpc_hanoi_office') ?> <?=lang('hcm_office_address')?>, HCMC, Vietnam.<br/>
			Tel: (+84) 4 3624-9007<br/>
			Fax: (+84) 4 3624-9007<br/>
			Email: <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a><br/>
			Website:  <a href="<?=site_url()?>">http://www.<?=strtolower(SITE_NAME)?></a><br/>
			<p><?=lang('tpc_hanoi_office1', SITE_NAME, SITE_NAME) ?></p>
		</li>
		<li><span class="highlight"><?=lang('tpc_prices_best_guarantee') ?></span>
			<p><?=lang('tpc_prices_best_guarantee_content1') ?></p>
			<p><?=lang('tpc_prices_best_guarantee_content2') ?></p>
		</li>
		<li><span class="highlight"><?=lang('tpc_payment_deposit') ?></span>
			<p><strong><?=lang('tpc_pay_online') ?></strong>
			<br/><?=lang('tpc_pay_online_content1', BRANCH_NAME) ?> <a href="http://www.onepay.vn"><?=lang('tpc_onepay_system') ?></a><?=lang('tpc_pay_online_content2') ?></p>
			<p><?=lang('tpc_pay_online_content3') ?></p>
			<p><strong><?=lang('tpc_bank_transfers') ?></strong><br/>
			<?=lang('tpc_account_name') ?>
			</p>
			<p><?=lang('tpc_other_methods_payment') ?></p>
		</li>
		<li><span class="highlight"><?=lang('tpc_confirm_booking_voucher') ?></span>
			<p><?=lang('tpc_confirm_booking_voucher_content1') ?></p>
			<p><?=lang('tpc_confirm_booking_voucher_content2', BRANCH_NAME) ?></p>
			<p><?=lang('tpc_confirm_booking_voucher_content3') ?></p>			
		</li>
		<li><span class="highlight"><?=lang('tpc_liability_insurance') ?></span>
			<p><?=BRANCH_NAME?> <?=lang('tpc_liability_insurance_content1') ?></p>
			<p><?=lang('tpc_liability_insurance_content2') ?></p>
		</li>
		<li><span class="highlight"><?=lang('tpc_cancellations') ?></span>
			<?=lang('tpc_cancellations_content') ?>						
		</li>		
	</ul>