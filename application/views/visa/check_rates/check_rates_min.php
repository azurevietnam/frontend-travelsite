<div id="visa-rates-form" class="visa-rates" style="height: auto; float: left; width: 258px">
    <h2 class="highlight"><?=lang('apply_for_voa_short')?></h2>
	<ul style="padding: 10px; float: left; width: 240px">
		<li>
			<label><b><?=lang('your_selections')?>:</b></label>
			<div id="your_selections" class="unitRight" style="text-align: right; padding-bottom: 10px">
				<?php if(isset($visa_booking['total_price'])):?>
				<ul>
					<li id="selection_nationality">
						<?=$visa_booking['number_of_visa']?> <?=$visa_booking['number_of_visa'] < 2 ? ' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
						<?php 
							foreach ($countries as $country) {
								if($country['id'] == $visa_booking['nationality']) {
									echo ' - '.$country['name'];
								}
							}
						?>
					</li>
					<li id="selection_visa_type">
					<?php 
						foreach ($types as $key => $type)  {
							if($key == $visa_booking['type_of_visa']) {
								echo translate_text($type);
							}
						}
					?>
					</li>
					<li id="selection_rush_service">
					<?php 
						foreach ($rush_services as $key => $service) {
							if($key == $visa_booking['processing_time']) {
								echo translate_text($service).' '.lang('lb_processing');
							}
						}
					?>
					</li>
				</ul>
				<?php else:?>
				<ul>
					<li id="selection_nationality"><?=lang('please_fill_the_apply_form')?></li>
					<li id="selection_visa_type">&nbsp;</li>
					<li id="selection_rush_service">&nbsp;</li>
				</ul>
				<?php endif;?>
			</div>
		</li>
		
		<li id="div_service_fee" class="hr" style="width: 100%; clear: both; border-top: 1px solid #F3F3F3">
			<label><?=lang('visa_service_fee')?>:</label>
			<span class="unitRight" id="visa_from_price">
				<?php if(isset($visa_booking['total_price'])):?>
					<?php echo '$'.$visa_booking['price'].' x '.$visa_booking['number_of_visa'];?>
				<?php endif;?>
			</span>
		</li>
		
		<li>
			<span>
				<b><?=lang('total_service_fee')?>:</b>
				<br><label class="process_note"><?=lang('exclude_stamp_fee')?></label>
			</span>
			<span class="unitRight rate_txt price_from" id="visa_total_fee">
				<?php if(isset($visa_booking['total_price'])):?>
					<?php echo '$'.($visa_booking['total_price']-$visa_booking['total_discount']);?>
				<?php endif;?>
			</span>
		</li>
		
		<li style="margin-top: 20px" id="update_visa_form" class="hide">
			<ul>
				<li>
					<label><?=lang('number_of_visa')?>:</label>
					<span>
						<select name="numb_visa" id="numb_visa" onchange="get_visa_rates()">
							<option value="0">-- <?=lang('please_select_number_of_visa')?> --</option>
							<?php for ($i=1; $i <= $max_application; $i++) :?>
							<option value="<?=$i?>" 
								<?php 
									if(isset($is_visa_details)) {
										echo set_select('numb_visa', $i, $i == $visa_booking['number_of_visa']? true : false);
									} else {
										echo set_select('numb_visa', $i, $i == 2);
									}
								?>
							>
								<?=$i?><?=$i < 2 ? ' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
							</option>
							<?php endfor;?>
						</select>
					</span>
				</li>
				<li style="margin-top: 8px">
					<label><?=lang('type_of_visa')?>:</label>
					<span>
						<select name="visa_type" id="visa_type" onchange="get_visa_rates()">
							<?php foreach ($types as $key => $type) :?>
							<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
							<?=translate_text($type)?>
							</option>
							<?php endforeach;?>
						</select>
					</span>
				</li>
				<li style="margin-top: 8px">
					<input type="hidden" value="" name="action">
					<?php if(isset($rowId)):?>
					<input type="hidden" value="<?=$rowId?>" name="rowId">
					<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
					<?php endif;?>
					
					<label><?=lang('your_nationality')?>: <?=mark_required()?></label>
					<span>
						<select name="visa_nationality" id="visa_nationality" onchange="get_visa_rates()">
							<option value="0">-- <?=lang('please_select_nationality')?> --</option>
							<?php foreach ($countries as $country) :?>
							<option value="<?=$country['id']?>" 
							<?php if(isset($visa_req_nationality)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_req_nationality ? true : false)?>
							<?php if(isset($is_visa_details)) echo set_select('visa_nationality', $country['id'], $country['id'] == $visa_booking['nationality'] ? true : false)?>>
							<?=$country['name']?>
							</option>
							<?php endforeach;?>
						</select>
					</span>
				</li>
				<li style="margin-top: 8px">
					<div><?=lang('processing_time')?>: <label class="process_note"><?=lang('from_monday_to_friday')?></label></div>
					<div>
						<ul class="process_time">
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
								<span><?=translate_text($service)?></span><label><?=translate_text($service.'_note')?></label>
							</li>
							<?php endforeach;?>
						</ul>
					</div>
				</li>
				<li style="margin-top: 10px">
					<div class="btn_general book_visa" onclick="edit_visa_booking()" style="float: none;"><?=lang('lb_update')?></div>
				</li>
			</ul>
		</li>
		
		<li style="margin-top: 20px; text-align: right; width: 100%">
			<a id="change_search" href="javascript:change_visa_options()"><?=lang('change_visa_options')?><span class="icon icon-arrow-down"></span></a>
		</li>
	</ul>
</div>