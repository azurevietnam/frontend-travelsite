<div id="bpv_support_popup_content" class="hide" style="line-height: normal;">
	<span onclick="$('#bpv_support_popup').popover('hide');" class="icon btn-support-close"></span>
	<ul class="list-unstyled">
		<li class="title"><?=lang('hotel_information_support')?></li>
		
		<?php foreach($hotline_users as $user):?>
			<?php if(is_bit_value_contain($user['display_on'], HOTEL) && $user['yahoo_acc'] != ''):?>
				<li>
					<a href="ymsgr:sendim?<?=$user['yahoo_acc']?>">
						<span class="icon icon-yahoo"></span>
						<?=$user['hotline_name']?>
					</a>
					<?php if($user['show_hotline']):?>	
						<a href="tel:<?=str_replace(".", '', $user['hotline_number'])?>">(<?=$user['hotline_number']?>)</a>
					<?php endif;?>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
		<?php foreach($hotline_users as $user):?>
			<?php if(is_bit_value_contain($user['display_on'], HOTEL) && $user['skype_acc'] != ''):?>
				<li>
					<a href="skype:<?=$user['skype_acc']?>?chat">
						<span class="icon icon-skype"></span>
						<?=$user['hotline_name']?>
					</a>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
		
		<li class="title"><?=lang('flying_information_support')?></li>
		
		<?php foreach($hotline_users as $user):?>
			<?php if(is_bit_value_contain($user['display_on'], FLIGHT) && $user['yahoo_acc'] != ''):?>
				<li>
					<a href="ymsgr:sendim?<?=$user['yahoo_acc']?>">
						<span class="icon icon-yahoo"></span>
						<?=$user['hotline_name']?>
					</a>
					<?php if($user['show_hotline']):?>	
						<a href="tel:<?=str_replace(".", '', $user['hotline_number'])?>">(<?=$user['hotline_number']?>)</a>
					<?php endif;?>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
		<?php foreach($hotline_users as $user):?>
			<?php if(is_bit_value_contain($user['display_on'], FLIGHT) && $user['skype_acc'] != ''):?>
				<li>
					<a href="skype:<?=$user['skype_acc']?>?chat">
						<span class="icon icon-skype"></span>
						<?=$user['hotline_name']?>
					</a>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
		<li class="working-times">
			<div><?=lang('working_times_label')?>:</div>
			<div class="bpv-color-title"><?=lang('working_times_content')?></div>
		</li>
	</ul>
</div>

<script>
$('#bpv_support_popup').popover({
	html: true,
	trigger: 'click',
	template: '<div class="popover info_popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
	title: '', 
	content: $('#bpv_support_popup_content').html(),
	placement: 'bottom',
	container: 'body'
}).on('shown.bs.popover', function(e){
	$('.btn-support').addClass('active');
}).on('hidden.bs.popover', function(e){
	$('.btn-support').removeClass('active');
});
</script>