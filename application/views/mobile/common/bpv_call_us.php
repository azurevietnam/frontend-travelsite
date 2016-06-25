<?php if(is_working_time() || is_hotline_time()):?>
<div class="bpv-call-us">
	<span class="icon icon-phone-xs"></span>
	<p class="call"><?=lang('call_us_now')?></p>
	<?php if(is_working_time()):?>
		<?php 
			$phone_nr = $display_on == FLIGHT ? PHONE_SUPPORT_FLIGHT : PHONE_SUPPORT;
		?>
		<p class="phone"><a href="tel:<?=format_phone_number($phone_nr)?>"><?=$phone_nr?></a></p>
	<?php else:?>
		<?php foreach ($hotline_users as $user):?>
			<?php if($user['show_hotline']):?>
			<p class="phone">
				<a href="tel:<?=format_phone_number($user['hotline_number'])?>">
					<?=$user['hotline_number']?> <small>(<?=$user['hotline_name']?>)</small>
				</a>
			</p>
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</div>
<?php endif;?>