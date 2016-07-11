<div class="container">
    <h1 class="text-highlight"><?=lang('vietnam_visa_fee_title')?></h1>
    <p style="font-size: 13px"><?=lang('vietnam_visa_fee_two_kinds')?></p>
    <h2><?=lang('vietnam_visa_fee_first_kind')?></h2>
    <p><?=lang('vietnam_visa_fee_first_kind_content')?></p>
    <h2><?=lang('vietnam_visa_fee_second_kind')?></h2>
    <p><?=lang('vietnam_visa_fee_second_kind_content')?></p>
    <table class="table table-bordered table-rates" style="font-size: 11px">
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
    
    <div class="margin-top-20">
        <h4><b><?=lang('related_visa_information')?></b></h4>
        <?=$top_visa_questions?>
    </div>
</div>