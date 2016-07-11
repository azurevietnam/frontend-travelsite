<div class="container" id="visa-citizens">
<form name="frmApplyVisa" method="post" action="<?=get_page_url(VN_VISA_APPLY_PAGE)?>">
    <h1 class="highlight"><?=lang_arg('need_passport_holder_question', ucfirst($country['name']))?></h1>
	<?php if($country['voa_accepted'] == 1 || $country['voa_accepted'] == 0):?>	
	<p class="text-price medium-font"><?=lang_arg('need_passport_holder_answer_yes', ucfirst($country['name']))?></p>
	
    <div class="btn btn-blue" onclick="javascript:window.frmApplyVisa.submit()"><?=lang('lb_apply_now')?></div>
  	
	  	
	<ul class="margin-top-20 list-unstyled">
	  		<li>
	  			<div class="title" style="font-weight: bold;">
	  				<?php if($country['voa_accepted'] == 1):?>
	  				1.
	  				<?php endif;?>
	  				<?=lang_arg('how_can_apply_for_vietnam_visa', ucfirst($country['name']))?>
	  			</div>
	  			<div class="margin-top-10">
				  	<p style="font-size: 13px; margin: 8px 0"><?=lang('there_are_two_options')?></p>
				  	<ul class="list-unstyled opt-list" style="margin-left: 0">
				  		<?php if($country['voa_accepted'] == 1):?>
				  			<li>
				  				<span class="icons-visa icon-opt2"><label><?=lang('option_1')?></label> </span><b><?=lang('apply_for_voa_recommend')?> - <label class="choice"><?=lang('lb_recommended')?></label></b>
				  				<p>
				  				<?=lang_arg('need_passport_holder_answer_yes_1', ucfirst($country['name']))?>
				  				</p>
				  			</li>
				  			<li>
				  			   <span class="icons-visa icon-opt1"><label><?=lang('option_2')?></label></span>
				  			   <b><?=lang('contact_a_vietnam_embassy')?></b>
				  			   <p><?=lang('contact_a_vietnam_embassy_desc')?></p>
					  		</li>
				  		<?php else:?>
				  			<li><span class="icons-visa icon-opt2"><label><?=lang('option_1')?></label> </span><b><?=lang('contact_a_vietnam_embassy')?> <?php if($country['voa_accepted'] != 1) echo ' - <label class="choice">'.lang('lb_recommended').'</label>';?></b><br>
					  		<?=lang('contact_a_vietnam_embassy_desc_2')?>
					  		<br><br>
					  		</li>
				  			<li>
				  				<span class="icons-visa icon-opt1"><label><?=lang('option_2')?></label></span><b><?=lang('apply_for_voa')?></b><br>
				  				<?php if(!empty($country['group_description'])):?>
				  					<?php echo $country['group_description']?>
				  				<?php else:?>
				  				<?=lang_arg('need_passport_holder_answer_yes_2', ucfirst($country['name']))?>
				  				<?php endif;?>
				  			</li>
				  		<?php endif;?>
				  	</ul>
			  	</div>
	  		</li>
	  		
	  		<?php if($country['voa_accepted'] == 1):?>
	  		<li>
	  			<div class="title" style="font-weight: bold;">
	  				<?=lang_arg('how_much_does_voa_cost_question', ucfirst($country['name']))?>
	  			</div>
	 			<div class="margin-top-10">
	 				<p><?=lang_arg('how_much_does_voa_cost_answer', ucfirst($country['name']))?></p>
				  	<table class="table table-bordered table-rates" style="font-size: 11px">
						<thead>
							<tr>
					        	<td rowspan="3" align="center" valign="middle"><b><?=lang('visa_types')?></b></td>
								<td colspan="4" align="center" valign="middle"><b><?-lang_arg('service_fee_for', ucfirst($country['name']))?></b><br><?=lang('cost_per_person_usd')?></td>
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
								<td nowrap="nowrap"><?=translate_text($type.'_short')?></td>
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
  				<input type="hidden" name="visa_req_nationality" value="<?=$country['id']?>">
  				<div class="btn btn-blue btn-block" onclick="javascript:window.frmApplyVisa.submit()">
  					<?=lang('apply_for_a_visa_now')?>
				</div>
	  		</li>
	  		<?php endif;?>
	  		
	  	</ul>
	  	<div style="font-weight: bold;margin: 20px 0 5px; color: #DF1F26"><?=lang('lb_note')?>:</div>
	  	<ul style="line-height: 20px; list-style: square;color: #DF1F26; padding-left: 20px">
	  		<li><?=lang('visa_for_citizens_note_1')?></li>
	  		<li><?=lang('visa_for_citizens_note_2')?></li>
	  	</ul>
	  	
	  	<?php else:?>
	  	<p class="choice medium-font"><?=lang_arg('need_passport_holder_answer_no', ucfirst($country['name']))?></p>
	  	<?php endif;?>
</form>
</div>