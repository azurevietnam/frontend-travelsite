<div id="how-to-apply" class="box-left" style="height: auto; border-color: #fca903">
	<div class="box-title">
		<h2 class="highlight"><?=lang('why_apply_with_us')?></h2>
	</div>
	<ul class="voa-why-us note_normal" >
		<li>
		    <label id="why_1" class="why_apply_us"><?=lang('visa_secure_private')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_secure_private_summary')?></span>
		</li>
		<li>
		    <label id="why_2" class="why_apply_us"><?=lang('visa_easy_convenient')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_easy_convenient_summary')?></span>
		</li>
		<li>
		    <label id="why_3" class="why_apply_us special"><?=lang('visa_lowest_fee')?></label>
		</li>
		<li class="summary">
		    <span class="visa_note"><?=lang('visa_lowest_fee_summary')?></span>
		</li>
		<?php if(isset($apply_button) && !isset($NO_APPLY_BUTTON)):?>
		<li style="text-align: center; background: none; margin-top: 8px">
			<a href="<?=url_builder('', APPLY_VIETNAM_VISA)?>" class="btnApplyNow">
			<span class="btn_general book_visa">
					<span style="padding: 7px 20px"><?=lang('lb_apply_now')?></span>
			</span>
			</a>
		</li>
		<?php endif;?>
	</ul>
</div>

<div id="why_apply_us_full_text" style="display: none;">
    <p><?=lang('secure_privacy_description')?></p>
    <p><?=lang('easy_convenience_description')?></p>
    <p><?=lang('saving_description')?></p>
</div>

<script>
    $('#why_1').tipsy({fallback: $('#why_1_details').html(), gravity: 's', width: '350px', title: "<?=lang('visa_secure_private')?>"});
    $('#why_2').tipsy({fallback: $('#why_2_details').html(), gravity: 's', width: '350px', title: "<?=lang('visa_easy_convenient')?>"});
    $('#why_3').tipsy({fallback: $('#why_3_details').html(), gravity: 's', width: '350px', title: "<?=lang('visa_lowest_fee')?>"});
</script>