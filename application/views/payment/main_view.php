<div class="container">
	<div class="bpv-box">
		<?php if($payment_status == INVOICE_PENDING):?>
			<h2 class="text-warning"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp; <?=$page_header?></h2>
		<?php elseif($payment_status == INVOICE_FAILED):?>
			<h2 class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp; <?=$page_header?></h2>
		<?php endif;?>
		
		<div class="content">
			<div class="mess-1"><?=lang('cf_thank_you')?></div>
				<?php if($payment_status == INVOICE_PENDING):?>
					<div class="mess-2 bpv-color-title">
						<?=lang('payment_pending_msg_1')?>
					</div>
					<div class="mess-2">
						<?=lang('payment_pending_msg_2')?>
					</div>
				<?php elseif($payment_status == INVOICE_FAILED):?>
					<div class="mess-2">
						<?=lang('payment_failed_msg')?>
					</div>
				<?php endif;?>
			
			<?php if($payment_status == INVOICE_PENDING):?>
			<div>
					<a href="<?=site_url()?>" type="button" class="btn btn-bpv btn-xs">
						<span class="glyphicon glyphicon-home"></span>
						<?=lang('cf_back_to_home')?>
					</a>
			</div>
			<?php endif;?>
		</div>
		
		
		<?php if($payment_status == INVOICE_FAILED):?>
		<div style="padding-left: 10%;">
			<?=$payment_method?>
			
			<div style="margin: 20px 0; text-align: center;">
					<a href="javascript:pay()" type="button" class="btn btn-bpv btn-lg">
						<span class="glyphicon glyphicon-circle-arrow-right"></span>
						<?=lang('btn_pay')?>
					</a>
			</div>
		</div>
		
		<script>
			function pay() {
				var url = $('.bpv-payment-methods').find('.active').attr('paymenturl');
				var method = $('#payment_method').val();
				if (method != '') {
					window.document.location = url;
				} else {
					alert('Xin vui lòng chọn hình thức thanh toán!');	
				}
			}
		</script>
		<?php endif;?>
	</div>
</div>