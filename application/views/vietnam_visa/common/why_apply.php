<div id="how-to-apply" class="box-left">
	<div class="box-title">
		<h2 class="highlight"><?=lang('why_apply_with_us')?></h2>
	</div>
	<ul class="voa-why-us note_normal" >
		<li class="why">
		    <label id="why_1" class="why_apply_us" data-title="<?=lang('visa_secure_private')?>" data-target='#why_apply_us1' data-placement='right'><?=lang('visa_secure_private')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_secure_private_summary')?></span>
		</li>
		<li class="why">
		    <label id="why_2" class="why_apply_us" data-title="<?=lang('visa_easy_convenient')?>" data-target='#why_apply_us2' data-placement='right'><?=lang('visa_easy_convenient')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_easy_convenient_summary')?></span>
		</li>
		<li class="why">
		    <label id="why_3" class="why_apply_us special" data-title="<?=lang('visa_lowest_fee')?>" data-target='#why_apply_us3' data-placement='right'><?=lang('visa_lowest_fee')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_lowest_fee_summary')?></span>
		</li>
		<?php if(isset($apply_button) && !isset($NO_APPLY_BUTTON)):?>
		<li style="text-align: center; background: none; margin-top: 8px">
			<a href="<?=get_page_url(VN_VISA_APPLY_PAGE)?>" class="btnApplyNow">
			<span class="btn_general book_visa">
					<span style="padding: 7px 20px"><?=lang('lb_apply_now')?></span>
			</span>
			</a>
		</li>
		<?php endif;?>
	</ul>
</div>
<div id='why_apply_us1' class="hidden">
    <?=lang('field_popover_secure_privacy', '<a rel="nofollow" target="_blank" href="https://sealsplash.geotrust.com/splash?&dn=www.bestpricevn.com">Geotrust</a>')?>
</div>
<div id='why_apply_us2' class="hidden">
    <?=lang('field_popover_easy_convenience_description')?>
</div>
<div id='why_apply_us3' class="hidden">
    <?=lang('field_popover_saving_description')?>
</div>

<script>
    set_help('.why .why_apply_us');
</script>