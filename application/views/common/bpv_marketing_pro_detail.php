<a href="javascript:void(0)" class="bpv-color-marketing pop-promotion" id="marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>">
	<span class="icon icon-gift" style="margin:-3px 5px 0 0"></span>
	<b><?=lang('mak_bpt_extra')?>:</b> <?=$bpv_pro['name']?>
</a>

<div id="marketing_title_<?=$bpv_pro['id'].'_'.$hotel_id?>" style="display: none">
	<b><?=$bpv_pro['name']?></b>
	<span onclick="$('#marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>').popover('hide');" class="icon btn-support-close"></span>
</div>

<div id="marketing_content_<?=$bpv_pro['id'].'_'.$hotel_id?>" style="display: none;">
	<div style="min-width:280px;" class="margin-bottom-10">
		<?=lang('mak_expired_date')?>: <b><?=format_bpv_date($bpv_pro['expired_date'], DATE_FORMAT, true)?></b>
	</div>
	<!-- 
	<div class="margin-bottom-10">
		<?=lang('mak_cus_booked')?>: <b><?=($bpv_pro['current_nr_booked'])?></b>
	</div>
	
	 
	<?php if($bpv_pro['hotel_discount_type'] > 0 || $bpv_pro['flight_discount_type'] > 0):?>
	
		<div class="margin-bottom-10">
			<?=lang_arg('mak_available_booked', ($bpv_pro['max_nr_booked'] - $bpv_pro['current_nr_booked']))?>
		</div>
		
	<?php endif;?>
	 -->

	<?php if($bpv_pro['description'] != ''):?>
		<div class="margin-bottom-10">
			<?=$bpv_pro['description']?>
		</div>
	<?php endif;?>
	
</div>

<script type="text/javascript">
	$('#marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>').popover(
			{'html':true,
			'trigger':'click',
			'title':$('#marketing_title_<?=$bpv_pro['id'].'_'.$hotel_id?>').html(), 
			'content':$('#marketing_content_<?=$bpv_pro['id'].'_'.$hotel_id?>').html(),
			'placement':'<?=$position?>'}
	);

	/*$('.pop-promotion').on('click', function (e) {
	    $('.pop-promotion').not(this).popover('hide');
	});*/
</script>
										
