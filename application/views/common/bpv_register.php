<div class="bpv-register">
	<div class="container">
		<div class="row">
			<div class="col-xs-5 newsletter-form-fields">
				<label id="signup_label" class="bpv-color-title"><?=lang('newsletter_label')?></label>
			</div>
			<form name="newsletter" id="newsletter_form" action="" onsubmit="return validateForm()" method="post">
				
				<div class="col-xs-5 no-padding newsletter-form-fields">
					<p class="hide bpv-color-warning" id="newsletter_invalid">
						<span class="glyphicon glyphicon-warning-sign"></span>
						<?=lang('newsletter_invalid_email')?>
					</p>
					
					<p class="hide text-success" id="newsletter_ok">
						<span class="glyphicon glyphicon-ok"></span>
						<?=lang('newsletter_success')?>
					</p>
					
					<input type="text" class="form-control" name="newsletter_to" id="newsletter_to" placeholder="<?=lang('newsletter_placeholder')?>">
				</div>
				<div class="col-xs-2 newsletter-form-fields">
					<button onclick="send_news_letter_request(this)" class="btn btn-bpv btn-register pull-left" id="newsletter" type="button"><?=lang('btn_newsletter')?></button>
				</div>
			</form>
		</div>
	</div>
</div>
