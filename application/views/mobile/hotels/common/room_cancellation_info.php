<?php if(!empty($room_rate['cancellation']) || !empty($hotel['extra_cancellation'])):?>
	
	<?php 
		$is_no_cancell = $room_rate['cancellation']['id'] == CANCELLATION_NO_REFUND;
	?>

	<a href="javascript:void(0)"
		class="pull-right free-cancel can_label_<?=$room_rate['cancellation']['id']?> <?=$is_no_cancell?'bpv-color-warning':''?>"> 
		<?=$is_no_cancell ? lang('no_cancel') : lang('cancellation_policy')?>
	</a>
	
	<span id="can_content_<?=$room_rate['cancellation']['id']?>" style="display: none">
		<?=empty($hotel['extra_cancellation']) || $is_no_cancell ? $room_rate['cancellation']['content'] : $hotel['extra_cancellation']?>
	</span>

	<script type="text/javascript">
		$('.can_label_<?=$room_rate['cancellation']['id']?>').popover(
				{'html':true,
				'trigger':'hover',
				'title':"<b><?=$is_no_cancell ? lang('no_cancel') : lang('cancellation_policy')?></b>", 
				'content':$('#can_content_<?=$room_rate['cancellation']['id']?>').html(),
				'placement':'bottom'}
		);
	</script>
	
<?php endif;?>