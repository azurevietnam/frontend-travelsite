<?php
	$acc = $selected_cabin['cabin_rate_info'];
?>
<input type="hidden" name="selected_cabin" value="<?=get_tour_rate_id($acc)?>">

<div class="bpv-panel">
    <div class="panel-heading">
    
        <div class="panel-title">
           <h3 class="bpv-color-title"><?=$acc['name']?></h3>
        </div>
        
        <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
        <?=$acc['content']?>
        </div>
    	
    </div>
    
    <div class="panel-body rate-tables">
        <div class="row">
            <div class="col-xs-6 pd-left-0 rate-name"><?='1 '.lang('adult_label')?></div>
        	<div class="col-xs-6 no-padding text-right bpv-price-from"><?=bpv_format_currency($acc['adult_rate'])?></div>
        </div>
        
        <?php if(!empty($check_rate_info['children'])):?>
        <div class="row">
           <div class="col-xs-6 pd-left-0 rate-name"><?='1 '.lang('children_label')?></div>
           
           <div class="col-xs-6 no-padding text-right">
        		<?php if(!empty($acc['children_rate'])):?>
        		    <div class="bpv-price-from">
        			<?=bpv_format_currency($acc['children_rate'])?>
        			</div>
        		<?php else:?>
        			<div class="bpv-color-price"><?=lang('free_of_charge')?></div>
        		<?php endif;?>
            </div>
        </div>
        <?php endif;?>
        
        <?php if(!empty($check_rate_info['infants'])):?>
        <div class="row">
           <div class="col-xs-6 pd-left-0 rate-name"><?='1 '.lang('infant_label')?></div>
           
           <div class="col-xs-6 no-padding text-right">
        		<?php if(!empty($acc['infant_rate'])):?>
        		    <div class="bpv-price-from">
        			<?=bpv_format_currency($acc['infant_rate'])?>
        			</div>
        		<?php else:?>
        			<div class="bpv-color-price"><?=lang('free_of_charge')?></div>
        		<?php endif;?>
            </div>
        </div>
        <?php endif;?>
        
        <?php if($check_rate_info['adults']%2 != 0):?>
        <div class="row">
           <div class="col-xs-6 pd-left-0 rate-name"><?='1 '.lang('single_sup')?></div>
           
           <div class="col-xs-6 no-padding text-right">
        		<div class="bpv-price-from">
        		<?=bpv_format_currency($acc['single_sup_rate'])?>
        		</div>
            </div>
        </div>
        <?php endif;?>
        
        <?php if(!empty($acc['sell_rate'])):?>
        <div class="row no-border">
           <div class="col-xs-6 pd-left-0 rate-name"><b><?=lang('total_price')?></b></div>
           
           <div class="col-xs-6 no-padding text-right">
        		<div class="bpv-price-from">
        			<b><?=bpv_format_currency($acc['sell_rate'])?></b>
        		</div>
            </div>
        </div>
        <?php endif;?>
    </div>
    
</div>

<script>
$('.bpv-toggle').bpvToggle();
</script>