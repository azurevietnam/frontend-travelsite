<?php if(is_working_time() || is_hotline_time()):?>
<div class="bpv-call-us clearfix">
	<span class="icon icon-phone-xs"></span>
	
	<p class="call"><?=lang('call_us_now')?></p>
	<?php if(is_working_time()):?>
		<p class="phone"><?=$display_on == FLIGHT ? PHONE_SUPPORT_FLIGHT : PHONE_SUPPORT?></p>
	<?php else:?>
		<?php foreach ($hotline_users as $user):?>
			<?php if($user['show_hotline']):?>
			<p class="phone"><?=$user['hotline_number']?> <small>(<?=$user['hotline_name']?>)</small></p>
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</div>
<?php endif;?>