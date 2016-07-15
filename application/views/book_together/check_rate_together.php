<form name="frm_book_together" id="frm_book_together" method="GET" onsubmit="return check_rate_together()">
<div class="check-rate-form">
	<?=$check_rate_1?>
	<div style="margin-top:15px"></div>
	<?=$check_rate_2?>
	<div class="text-right">
		<button type="submit" class="btn btn-primary btn-lg" value="<?=ACTION_CHECK_RATE?>" name="action">
			<?=lang('check_rates')?>
		</button>
	</div>
</div>
</form>

<script type="text/javascript">
	function check_rate_together(){
		<?php if($service_2['service_type'] == HOTEL):?>
			return !check_error_check_rates(<?=$service_1['id']?>, <?=CABIN_LIMIT?>) && is_valid_hotel_date_selected();
		<?php else:?>
			return !check_error_check_rates(<?=$service_1['id']?>, <?=CABIN_LIMIT?>) && !check_error_check_rates(<?=$service_2['id']?>, <?=CABIN_LIMIT?>);
		<?php endif;?>
	}
</script>