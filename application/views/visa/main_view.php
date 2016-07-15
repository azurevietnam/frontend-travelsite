<div id="page_title">
	<h1 class="highlight"><?=lang('vietnam_visa_h1')?></h1>
	<span><?=lang('vietnam_visa_summary')?></span>
</div>
<div id="contentLeft">
	<?=$apply_form_small?>

	<?=$how_it_works?>

	<?=$topDestinations?>
</div>
<div id="contentMain">
	<form id="frmApplyVisa" method="post" action="<?=url_builder('',VIETNAM_VISA)?>apply-visa.html">
	<div class="visa-requirement-box">

		<div class="insideBox">
			<select name="nationality" id="ck_nationality">
				<option value=""><?=lang('please_select_nationality')?></option>
				<?php foreach ($countries as $country) :?>
				<?php
					$url_ct_name = strtolower(trim($country['url_title']));
					$url_ct_name = str_replace(' ', '-', $url_ct_name);
					$url_ct_name .= '.html';
				?>
				<option value="<?=$url_ct_name?>"><?php echo $country['name']?></option>
				<?php endforeach;?>
			</select>

			<div onclick="check_requirements()" class="btn_general book_visa"><?=lang('check_requirements')?></div>

			<ul>
				<li>
					<span class="icon deal_icon"></span>
					<a class="free-visa-halong special" href="javascript:void(0)"><?=lang('free_vietnam_visa')?> &raquo;</a>
				</li>
			</ul>

			<div class="inside-title highlight"><?=lang('label_select_nationality')?></div>
		</div>

		<div class="floatL" style="margin: 30px 10px 10px; width: 700px">
			<div class="servicebox">
				<a href="/vietnam-visa/visa-on-arrival.html">
				<div class="box-content">
					<div class="servicetit highlight"><?=lang('visa_on_arrival')?></div>
					<div class="service-content">
						<?=lang('visa_on_arrival_description')?>
					</div>
					<label><?=lang('visa_learn_more')?></label>
				</div>
				</a>
			</div>
			<div class="servicebox" style="text-align: center;">
				<a href="/vietnam-visa/visa-fees.html">
				<div class="box-content" style="text-align: left; margin: auto;">
					<div class="servicetit highlight"><?php echo lang('vietnam_visa_fee')?></div>
					<div class="service-content">
						<?php echo lang('vietnam_visa_fee_description')?>
					</div>
					<label><?=lang('visa_learn_more')?></label>
				</div>
				</a>
			</div>
			<div class="servicebox">
				<a href="/vietnam-visa/how-to-apply.html">
				<div class="box-content unitRight">
					<div class="servicetit highlight"><?php echo lang('how_to_apply')?></div>
					<div class="service-content">
						<?php echo lang('how_to_apply_description')?>
					</div>
					<label><?=lang('visa_learn_more')?></label>
				</div>
				</a>
			</div>
		</div>
	</div>
	</form>

	<div class="voa-information grayBox">
		<div class="service-box home-mm-2of3">
			<h2 class="highlight"><span class="icon icon-vn-voa"></span><?php echo lang('vietnam_visa_information')?></h2>
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
	<p>
		<?php echo lang('secure_privacy_description', '<a rel="nofollow" target="_blank" href="https://sealsplash.geotrust.com/splash?&dn=www.bestpricevn.com">Geotrust</a>')?>
	</p>
	<p>
		<?php echo lang('easy_convenience_description')?>
	</p>
	<p>
		<?php echo lang('saving_description')?>
	</p>
</div>
<div class="hide" id="free_visa_halong_content">
	<?=$popup_free_visa?>
</div>
<script>

	$(document).ready(function(){
		var dg_content = $('#why_apply_us_full_text').html();

		var d_help = '<span class="highlight" style="font-size: 14px;"><?=lang('why_apply_us')?></span>';

		$(".why_apply_us").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});

		$('#why_1').tipsy({fallback: $('#why_1_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_secure_private')?>"});
		$('#why_2').tipsy({fallback: $('#why_2_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_easy_convenient')?>"});
		$('#why_3').tipsy({fallback: $('#why_3_details').html(), gravity: 'e', width: '350px', title: "<?=lang('visa_lowest_fee')?>"});

		var dg_visa_content = $('#free_visa_halong_content').html();

		var d_visa_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';

		$(".free-visa-halong").tiptip({fallback: dg_visa_content, gravity: 's', title: d_visa_help, width: '500px'});
	});
</script>

