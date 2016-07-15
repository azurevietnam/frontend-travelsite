<div class="apply-form-small">
	<h2 class="highlight"><?=lang('apply_for_voa_short')?></h2>
	<form id="frmApplyVisaDetail" method="post" action="<?=url_builder('',VIETNAM_VISA)?>visa-details.html">
	<div class="form-ui floatL">
		<div class="row">
			<label class="form-label"><?=lang('number_of_visa')?>:</label>
			<span class="floatL wd-145">
				<select name="numb_visa" id="numb_visa" onchange="get_visa_rates()">
					<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
					<?php for ($i=1; $i <= $max_application; $i++) :?>
					<option value="<?=$i?>" 
						<?php 
							if(isset($is_visa_details)) {
								echo set_select('numb_visa', $i, $i == $visa_booking['number_of_visa']? true : false);
							} else {
								echo set_select('numb_visa', $i, $i == 1);
							}
						?>
					>
						<?=$i?><?=$i < 2 ? ' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
					</option>
					<?php endfor;?>
				</select>
			</span>
		</div>
		<div class="row">
			<label class="form-label"><?=lang('type_of_visa')?>:</label>
			<span class="floatL wd-145">
				<select name="visa_type" id="visa_type" onchange="get_visa_rates()">
					<?php foreach ($types as $key => $type) :?>
					<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
					<?=translate_text($type)?>
					</option>
					<?php endforeach;?>
				</select>
			</span>
		</div>
		<div class="row">
			<input type="hidden" value="" name="action">
			<?php if(isset($rowId)):?>
			<input type="hidden" value="<?=$rowId?>" name="rowId">
			<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
			<?php endif;?>
			
			<label class="form-label"><?=lang('your_nationality')?>: <?=mark_required()?></label>
			<span class="floatL wd-145">
				<select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()">
					<option value="0">-- <?=lang('lb_please_select')?> --</option>
					<?php foreach ($countries as $country) :?>
					<option value="<?=$country['id']?>" 
					<?php if(isset($visa_req_nationality)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_req_nationality ? true : false)?>
					<?php if(isset($is_visa_details)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_booking['nationality'] ? true : false)?>>
					<?=$country['name']?>
					</option>
					<?php endforeach;?>
				</select>
			</span>
		</div>
		<div class="row">
			<label class="floatL"><?=lang('processing_time')?>: <span class="process_note"><?=lang('from_monday_to_friday')?></span></label>
			<ul class="process_time floatL">
				<?php foreach ($rush_services as $key => $service) :?>
				<li>
					<input type="radio" name="rush_service" value="<?=$key?>" 
					<?php 	
						if(isset($is_visa_details)) {
							echo set_checkbox('rush_service', $key, $key == $visa_booking['processing_time']? true : false);
						} else {
							echo set_checkbox('rush_service', $key, $key == 1? true : false);
						}
					?> 
					onclick="get_visa_rates()" title="<?=translate_text($service)?>">
					<?=translate_text($service)?><label><?=translate_text($service.'_note')?></label>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="row total-fee">
			<div class="floatR">
				<ul>
					<li><b><?=lang('total_service_fee')?>:</b></li>
					<li>
						<div class="unitRight rate_txt price_from" id="visa_total_fee" style="font-size: 26px;"></div>
					</li>
				</ul>
			</div>
			<div class="geotrust">
				<table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose GeoTrust SSL for secure e-commerce and confidential communications.">
                <tr>
                <td width="135" align="left" valign="top"><script type="text/javascript" src="https://seal.geotrust.com/getgeotrustsslseal?host_name=www.bestpricevn.com&amp;size=S&amp;lang=en"></script><br />
                <a href="http://www.geotrust.com/ssl/" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;"></a></td>
                </tr>
                </table>
			</div>
		</div>
		<div class="row" style="margin: 0">
			<div class="btn_general btn-search highlight floatR" onclick="book_visa('apply')"><?=lang('lb_apply_now')?></div>
		</div>
	</div>
	</form>
</div>
<script>
	get_visa_rates();
</script>