<?php if(!empty($accommodation_rate['cancellation']) || !empty($tour['extra_cancellation'])):?>
	
	<?php 
		$is_no_cancell = $accommodation_rate['cancellation']['id'] == CANCELLATION_NO_REFUND;
	?>
	
	<a href="javascript:void(0)"
		class="pull-right free-cancel can_label_<?=$accommodation_rate['cancellation']['id']?> <?=$is_no_cancell?'bpv-color-warning':''?>"> 
		<?=$is_no_cancell ? lang('no_cancel') : lang('cancellation_policy')?>
	</a>
	
	<span id="can_content_<?=$accommodation_rate['cancellation']['id']?>" style="display: none">
		<?=empty($tour['extra_cancellation']) || $is_no_cancell? $accommodation_rate['cancellation']['content'] : $tour['extra_cancellation']?>
	</span>

	<script type="text/javascript">
		$('.can_label_<?=$accommodation_rate['cancellation']['id']?>').popover(
				{'html':true,
				'trigger':'hover',
				'title':"<b><?=$is_no_cancell ? lang('no_cancel') : lang('cancellation_policy')?></b>", 
				'content':$('#can_content_<?=$accommodation_rate['cancellation']['id']?>').html(),
				'placement':'bottom'}
		);
	</script>
	
<?php endif;?>