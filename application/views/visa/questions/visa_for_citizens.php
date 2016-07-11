<div id="visa-citizens">
<h1 class="highlight"><?=lang_arg('need_passport_holder_question', ucfirst($nationality))?></h1>
	<?php if($nat['voa_accepted'] == 1 || $nat['voa_accepted'] == 0):?>	
	<p class="price medium-font"><?=lang_arg('need_passport_holder_answer_yes', ucfirst($nationality))?></p>
	  	
	<ul style="margin-top: 20px">
	  		<li>
	  			<div class="title" style="font-size: 14px">
	  				<?php if($nat['voa_accepted'] == 1):?>
	  				1.
	  				<?php endif;?>
	  				<?=lang_arg('how_can_apply_for_vietnam_visa', ucfirst($nationality))?>
	  			</div>
	  			<div style="margin-left: 25px;">
				  	<p style="font-size: 13px; margin: 8px 0"><?=lang('there_are_two_options')?></p>
				  	<ul class="opt-list" style="margin-left: 0">
				  		<?php if($nat['voa_accepted'] == 1):?>
				  			<li>
				  				<span class="icons-visa icon-opt2"><label><?=lang('option_1')?></label></span><b><?=lang('apply_for_voa_recommend')?> - <label class="choice"><?=lang('lb_recommended')?></label></b>
				  				<p>
				  				<?=lang_arg('need_passport_holder_answer_yes_1', ucfirst($nationality))?>
				  				</p>
				  			</li>
				  			<li>
				  			   <span class="icons-visa icon-opt1"><label><?=lang('option_2')?></label></span>
				  			   <b><?=lang('contact_a_vietnam_embassy')?></b>
				  			   <p><?=lang('contact_a_vietnam_embassy_desc')?></p>
					  		</li>
				  		<?php else:?>
				  			<li><span class="icons-visa icon-opt2"><label><?=lang('option_1')?></label></span><b><?=lang('contact_a_vietnam_embassy')?> <?php if($nat['voa_accepted'] != 1) echo ' - <label class="choice">'.lang('lb_recommended').'</label>';?></b><br>
					  		<?=lang('contact_a_vietnam_embassy_desc_2')?>
					  		<br><br>
					  		</li>
				  			<li>
				  				<span class="icons-visa icon-opt1"><label><?=lang('option_2')?></label></span><b><?=lang('apply_for_voa')?></b><br>
				  				<?php if(!empty($nat['group_description'])):?>
				  					<?php echo $nat['group_description']?>
				  				<?php else:?>
				  				<?=lang_arg('need_passport_holder_answer_yes_2', ucfirst($nationality))?>
				  				<?php endif;?>
				  			</li>
				  		<?php endif;?>
				  	</ul>
			  	</div>
	  		</li>
	  		
	  		<?php if($nat['voa_accepted'] == 1):?>
	  		<li>
	  			<div class="title" style="font-size: 14px">
	  				<?=lang_arg('how_much_does_voa_cost_question', ucfirst($nationality))?>
	  			</div>
	 			<div style="margin-left: 25px;">
	 				<p><?=lang_arg('how_much_does_voa_cost_answer', ucfirst($nationality))?></p>
				  	<table class="tour_accom">
						<thead>
							<tr>
					        	<td rowspan="3" align="center" valign="middle"><b><?=lang('visa_types')?></b></td>
								<td colspan="4" align="center" valign="middle"><b><?-lang_arg('service_fee_for', ucfirst($nationality))?></b><br><?=lang('cost_per_person_usd')?></td>
								<td rowspan="3"  align="center" valign="middle"><b><?=lang('lb_stamp_fee')?></b></td>
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
	 			</div>
	  		</li>
	  		<li>
	  			<form name="frmApplyVisa" method="post" action="<?=url_builder('',APPLY_VIETNAM_VISA)?>">
	  			<div style="position: absolute; right: 10px; top: 30px">
  					
  						<input type="hidden" name="visa_req_nationality" value="<?=$nationality_id?>">
  						<div class="btn_general book_visa" style="width: 120px;" onclick="javascript:window.frmApplyVisa.submit()">
	  						<?=lang('lb_apply_now')?>
						</div>
  				</div>
  				<input type="hidden" name="visa_req_nationality" value="<?=$nationality_id?>">
  				<div class="btn_general book_visa" style="float: none;margin: 20px 0 0;width: 180px;" 
  						onclick="javascript:window.frmApplyVisa.submit()">
  					<?=lang('apply_for_a_visa_now')?>
				</div>
				</form>
	  		</li>
	  		<?php endif;?>
	  		
	  	</ul>
	  	<div style="font-weight: bold;margin: 20px 0 5px; color: #DF1F26"><?=lang('lb_note')?>:</div>
	  	<ul style="line-height: 20px; margin-left: 30px; list-style: square;color: #DF1F26">
	  		<li><?=lang('visa_for_citizens_note_1')?></li>
	  		<li><?=lang('visa_for_citizens_note_2')?></li>
	  	</ul>
	  	
	  	<?php else:?>
	  	<p class="choice medium-font"><?=lang_arg('need_passport_holder_answer_no', ucfirst($nationality))?></p>
	  	<?php endif;?>
</div>