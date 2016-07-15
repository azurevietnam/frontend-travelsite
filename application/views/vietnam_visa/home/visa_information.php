<div class="voa-information margin-top-10">
	<div class="col-xs-5">
    	<h2 class="text-highlight"><span class="icon icon-information"></span><?=lang('vietnam_visa_information')?></h2>
        <?=$top_visa_questions?>
	</div>
	<div class="col-xs-5 col-xs-offset-2">
        <h2 class="text-highlight"><span class="icon icon-recommend"></span><?=lang('why_apply_us')?></h2>
		<ul class="list-unstyled voa-why-us" >
			<li class="why">
			    <label id="why_1" class="why_apply_us" data-title="<?=lang('visa_secure_private')?>" data-target='#why_apply_us1' data-placement='left'><?=lang('visa_secure_private')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_secure_private_summary')?></span>
			</li>
			<li class="why">
			    <label id="why_2" class="why_apply_us" data-title="<?=lang('visa_easy_convenient')?>" data-target='#why_apply_us2' data-placement='left'><?=lang('visa_easy_convenient')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_easy_convenient_summary')?></span>
			</li>
			<li class="why">
			    <label id="why_3" class="why_apply_us text-special" data-title="<?=lang('visa_lowest_fee')?>" data-target='#why_apply_us3' data-placement='left'><?=lang('visa_lowest_fee')?></label>
			</li>
			<li class="summary">
			    <span class="visa_note"><?=lang('visa_lowest_fee_summary')?></span>
			</li>
		</ul>
	</div>
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