<div class="container">
	<div class="bpv-box">
		<h2 class="text-success"><span class="glyphicon glyphicon-ok"></span>&nbsp; <?=$mess_success?></h2>
		<div class="content">
			<div class="mess-1"><?=lang('cf_thank_you')?></div>
			<div class="mess-2"><?=$mess_check?></div>
			<?php if(isset($email_check)):?>
				<div class="mess-2 bpv-color-title"><?=$email_check?></div>
			<?php endif;?>
			<div>
				<a href="<?=site_url()?>" type="button" class="btn btn-bpv btn-xs">
					<span class="glyphicon glyphicon-home"></span>
					<?=lang('cf_back_to_home')?>
				</a>
			</div>
		</div>
	</div>
</div>