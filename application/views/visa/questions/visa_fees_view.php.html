<h1 class="highlight"><?=lang('vietnam_visa_fee_title')?></h1>
		<p style="font-size: 13px"><?=lang('vietnam_visa_fee_two_kinds')?></p>
		<h2 style="padding: 0"><?=lang('vietnam_visa_fee_first_kind')?></h2>
		<p><?=lang('vietnam_visa_fee_first_kind_content')?></p>
	    <h2 style="padding: 0"><?=lang('vietnam_visa_fee_second_kind')?></h2>
	    <p><?=lang('vietnam_visa_fee_second_kind_content')?></p>
		<table class="tour_accom">
			<thead>
				<tr>
		        	<td rowspan="3" align="center" valign="middle"><b class="medium-font"><?=lang('visa_types')?></b></td>
					<td colspan="4" align="center" valign="middle"><b class="medium-font"><?=lang('lb_service_fee')?></b><br><?=lang('cost_per_person_usd')?></td>
					<td rowspan="3"  align="center" valign="middle">
						<b class="medium-font"><?=lang('lb_stamp_fee')?></b>
						<br><?=lang('cost_per_person_usd')?>
						<br><?=lang('paid_at_airport')?>
					</td>
				</tr>
				<tr>
		       		<td colspan="3" align="center" valign="middle"><b><?=lang('lb_normal_processing')?></b></td>
		    		<td rowspan="2" align="center" valign="middle"><b><?=lang('urgent_processing_br')?></b></td>
		        </tr>
				<tr>
					<?php for ($i=1; $i <= $max_application; $i++) :?>
						<?php if($i == 1):?>
						<td align="center">1-3 <?=lang('lb_pax')?></td>
						<?php endif;?>
						<?php if($i == 4):?>
						<td align="center">4-5 <?=lang('lb_pax')?></td>
						<?php endif;?>
						<?php if($i == 6):?>
						<td align="center">6-10 <?=lang('lb_pax')?></td>
						<?php endif;?>
					<?php endfor;?>
				</tr>
			</thead>
			<tbody>
				<?php $cnt = 1?>
				<?php foreach ($visa_types as $key => $type) :?>
				<tr>
					<td nowrap="nowrap"><?=translate_text($type)?></td>
					<?php for ($i=1; $i <= $max_application; $i++) :?>
						<?php if($i == 1 || $i == 4 || $i == 6):?>
						<td align="center"><?=$rates_table[$key][$i-1]['price']?></td>
						<?php endif;?>
					<?php endfor;?>
					<td align="center">plus <?=$rates_table[$key][0]['urgent_price']?></td>
					<td align="center"><?php echo $visa_stamp_fee[$cnt]?></td>
				</tr>
				<?php $cnt++?>
				<?php endforeach;?>
			</tbody>
		</table>	
		
		<?php
			$stamp_fee_table = ''; 
			foreach($visa_stamp_fee as $k => $fee) {
				$stamp_fee_table.= $fee;
				if($k < count($visa_stamp_fee)) $stamp_fee_table.= ',';;
			}
		?>
		
		<h3 style="padding: 20px 0 10px"><?=lang('visa_service_fee_calculator')?></h3>
		<div class="visa-calculator">
			<form id="frmApplyVisaDetail" method="post" action="<?=url_builder('',VIETNAM_VISA)?>visa-details.html">
			<input type="hidden" value="" name="action">
			<input type="hidden" id="no_discount" value="1">
			<input type="hidden" id="stemp_fee_table" value="<?php echo $stamp_fee_table;?>">
			<ul>
				<li>
					<span class="label"><?=lang('select_your_nationality')?></span>
					<select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()">
						<option value="0">-- <?=lang('please_select_nationality')?> --</option>
						<?php foreach ($countries as $country) :?>
						<option value="<?=$country['id']?>"><?=$country['name']?></option>
						<?php endforeach;?>
					</select>
				</li>
				<li>
					<span class="label"><?=lang('number_of_visa')?>:</span>
					<select name="numb_visa" id="numb_visa" onchange="get_visa_rates()">
						<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
						<?php for ($i=1; $i <= $max_application; $i++) :?>
						<option value="<?=$i?>">
							<?=$i?><?=$i<2?' applicant':' applicants'?>
						</option>
						<?php endfor;?>
					</select>
				</li>
				<li>
					<span class="label"><?=lang('type_of_visa')?>:</span>
					<select name="visa_type" id="visa_type" onchange="get_visa_rates()">
						<?php foreach ($types as $key => $type) :?>
						<option value="<?=$key?>">
						<?=translate_text($type)?>
						</option>
						<?php endforeach;?>
					</select>
				</li>
				<li>
					<span class="label"><?=lang('processing_time')?>:</span>
					<?php foreach ($rush_services as $key => $service) :?>
							<input type="radio" name="rush_service" value="<?=$key?>" 
							<?php 	
								if(isset($is_visa_details)) {
									echo set_checkbox('rush_service', $key, $key == $visa_booking['processing_time']? true : false);
								} else {
									echo set_checkbox('rush_service', $key, $key == 1? true : false);
								}
							?> 
							onclick="get_visa_rates()" title="<?=translate_text($service)?>">
							<span><?=translate_text($service)?></span><label><?=translate_text($service.'_note')?></label>
					<?php endforeach;?>
				</li>
				<li style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px; position: relative;">
					<span class="label" style="font-size: 13px;"><?=lang('lb_service_fee')?>:</span>
					<span id="visa_from_price" style="font-size: 14px"></span>
					<span id="visa_total_fee" class="price_from rate_txt"></span><br>
					<span class="label" style="font-size: 13px;"><?=lang('lb_stamp_fee')?>:</span>
					<span id="stamp_fee" style="font-size: 14px"></span>
					<span id="stamp_total_fee" class="price_from rate_txt"></span>
					<div class="btn_general book_visa" onclick="book_visa('apply')" style="float: none; position: absolute; right: 0; top: 10px"><?=lang('lb_apply_now')?></div>
				</li>
			</ul>
			</form>
		</div>
		<div class="related-info">
<h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
<?=$top_visa_questions?>
</div>
<script>
	// refresh event
	get_visa_rates();
</script>