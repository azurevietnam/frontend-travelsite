<div id="contentLeft">
	<?=$how_it_works?>
</div>
<div id="contentMain">
	<form id="frmApplyVisaDetail" method="post" action="<?=url_builder('',VIETNAM_VISA)?>visa-details.html">
	<?=$check_rate_view?>
	</form>

	<div class="voa-information grayBox">
		<div class="service-box home-mm-2of3">
			<h2 class="highlight"><span class="icon icon-vn-voa"></span><?=lang('vietnam_visa_h1')?></h2>
			<?=$top_visa_questions?>
		</div>
		<div class="service-box unitRight">
			<h2 class="highlight"><span class="icon recommend_icon"></span><?=lang('why_apply_us')?></h2>
			<ul class="voa-why-us" >
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
			</ul>
		</div>
	</div>

	<?=$recommendation_view?>
</div>
<div id="why_apply_us_full_text" style="display: none;">
	<p><?=lang('secure_privacy_description', '<a rel="nofollow" target="_blank" href="https://sealsplash.geotrust.com/splash?&dn=www.bestpricevn.com">Geotrust</a>')?></p>
	<p><?=lang('easy_convenience_description')?></p>
	<p><?=lang('saving_description')?></p>
</div>
<script>
	// refresh event
	get_visa_rates();

	var dg_content = $('#why_apply_us_full_text').html();

	var d_help = '<span class="highlight" style="font-size: 14px;"><?=lang('why_apply_us')?></span>';

	$(".why_apply_us").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});

	$('#why_1').tipsy({fallback: $('#why_1_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_secure_private')?>"});
	$('#why_2').tipsy({fallback: $('#why_2_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_easy_convenient')?>"});
	$('#why_3').tipsy({fallback: $('#why_3_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_lowest_fee')?>"});
</script>