<?php 
	$custom_css = '';
	if(isset($visa_fees)) {
		$custom_css = ' visa-calculator';
	}
	
	if(isset($is_visa_details)) {
		$custom_css .= ' hide';
	}
?>
<div id="visa-rates-form" class="visa-rates <?=$custom_css?>">
	<h2 class="highlight"><?=lang('apply_visa')?></h2>
	<div class="rate-form">
		<input type="hidden" value="" name="action">
		<?php if(isset($rowId)):?>
		<input type="hidden" value="<?=$rowId?>" name="rowId">
		<input type="hidden" value="<?=$visa_booking['number_of_visa']?>" id="crNumbVisa">
		<?php endif;?>
			<div class="row">
				<div class="col1"><?=lang('number_of_visa')?>:</div>
				<div class="col2">
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
				</div>
			</div>
			<div class="row">
				<div class="col1"><?=lang('type_of_visa')?>:</div>
				<div class="col2">
					<select name="visa_type" id="visa_type" onchange="get_visa_rates()">
						<?php foreach ($types as $key => $type) :?>
						<option value="<?=$key?>" <?php if(isset($is_visa_details)) echo set_select('visa_type', $key, $key == $visa_booking['type_of_visa']? true : false)?>>
						<?=translate_text($type)?>
						</option>
						<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col1"><?=lang('your_nationality')?>: <?=mark_required()?></div>
				<div class="col2">
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
				</div>
			</div>
			<div class="row no_margin">
				<div class="col1">
					<ul>
						<li><?=lang('processing_time')?>:</li>
						<li class="process_note"><?=lang('from_monday_to_friday')?></li>
					</ul>
				</div>
				<div class="col2">
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
			</div>
			<div class="row special visa_tip">
				<span class="icon deal_icon"></span>
				<a href="javascript:void(0)" class="special free-visa-halong" style="font-size: 12px"><?=lang('free_vietnam_visa')?> &raquo;</a>
			</div>
	</div>
	<!-- End VN Visa Rate Form -->
	
	<div class="rate-calc">
		<div class="rate-arrow">
			<div class="arrow-before"></div>
			<div class="arrow-after"></div>
		</div>
		<ul>
			<li class="hr">
				<span class="left"><b><?=lang('your_selections')?>:</b></span>
				<div id="your_selections" class="right">
				<?php if(isset($visa_booking['total_price'])):?>
				<ul>
					<li id="selection_nationality">
						<?=$visa_booking['number_of_visa']?> <?=$visa_booking['number_of_visa'] < 2 ?' '.lang('lb_applicant') : ' '.lang('lb_applicants')?>
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
			<li>
				<span class="left" style="width: 180px"><?=lang('recevei_approval_letter')?>:</span>
				<span class="right" style="width: 100px" id="selection_receive_date"></span>
			</li>
			<li id="div_service_fee"><span class="left"><?=lang('visa_service_fee')?>:</span>
			<?php if(isset($visa_booking['total_price'])):?>
				<span id="visa_from_price" class="right" style="font-size: 14px"><?php echo '$'.$visa_booking['price'].' x '.$visa_booking['number_of_visa'];?></span>
			<?php else:?>
				<span id="visa_from_price" class="right"></span>
			<?php endif;?>
			</li>
			
			<?php if(isset($visa_booking['total_discount']) && !empty($visa_booking['total_discount'])):?>
				<li id="div_discount" style="display: block;">
					<span class="left"><?=lang('lb_discount_for_booking_together')?>:</span>
					<span id="visa_discount" class="right price_from"><?php echo '-$'.$visa_booking['total_discount'];?></span>
				</li>
			<?php else:?>
				<li id="div_discount">
					<span class="left"><?=lang('lb_discount_for_booking_together')?>:</span>
					<span id="visa_discount" class="right price_from"></span>
				</li>
			<?php endif;?>
			<li id="div_total_fee">
				<span class="left"><b><?=lang('total_service_fee')?>:</b></span>
				<?php if(isset($visa_booking['total_price'])):?>
					<span id="visa_total_fee" class="right price_from rate_txt"><?php echo '$'.($visa_booking['total_price']-$visa_booking['total_discount']);?></span>
				<?php else:?>
					<span id="visa_total_fee" class="right price_from rate_txt"></span>
				<?php endif;?>
				<span id="visa_price_note"><?=lang('exclude_stamp_fee')?></span>
				<span class="geotrust">
					<script language="javascript" type="text/javascript" src="//smarticon.geotrust.com/si.js"></script>
				</span>
			</li>
			<li style="margin-top: 18px">
				<?php if(isset($is_visa_details)):?>
					<div class="btn_general book_visa" onclick="edit_visa_booking()"><?=lang('lb_update')?></div>
				<?php else:?>
					<div class="btn_general book_visa" onclick="book_visa('apply')">
						<span style="padding-right: 6px"><?=lang('lb_next')?></span>
						<span class="icon icon-go"></span>
					</div>
				<?php endif;?>
			</li>
		</ul>
	</div>
</div>
<?php if(isset($popup_free_visa)):?>
<div class="hide" id="free_visa_halong_content">
	<?=$popup_free_visa?>
</div>
<script>
$(document).ready(function(){
	var dg_content = $('#free_visa_halong_content').html();
	
	var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';

	$(".free-visa-halong").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
});
<?php endif;?>
</script>