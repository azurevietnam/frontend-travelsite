<?php if(count($surcharges)> 0):?>
	<p><?=lang('cb_surcharge_note')?></p>
	
	<?php foreach ($surcharges as $sur):?>
	<div class="bpv-panel">
        <div class="panel-heading">
            <div class="panel-title bpv-surcharge" data-target="#surcharge_<?=$sur['id']?>">
    	        <div class="row">
        	        <div class="col-xs-10">
        	           <h3 class="bpv-color-title"><?=$sur['name']?></h3>
                    </div>
                    
                    <?php if(!empty($sur['description'])):?>
                    <div class="col-xs-2 pd-left-0 text-right">
                        <i class="bpv-toggle-icon icon icon-chevron-down"></i>
                    </div>
                    <?php endif;?>
                </div>
    	   </div>
    	   
    	   <?php if(!empty($sur['description'])):?>
    	   <div id="surcharge_<?=$sur['id']?>" class="bpv-toggle-content margin-top-10">
    	       <?=$sur['description']?>
    	   </div>
    	   <?php endif;?>
        </div>
        <div class="panel-body rate-tables">
        
            <div class="row">
                <div class="col-xs-4 pd-left-0 rate-name">
                     <?=lang('cb_surcharge_unit')?>
                </div>
                <div class="col-xs-8 no-padding text-right">
                     <?php if($sur['charge_type'] == SUR_PER_ADULT_PER_BOOKING):?>
                    
        				<b><?=bpv_format_currency($sur['adult_amount'])?></b> /<?=strtolower(lang('adult_label'))?>
        				<?php if( !empty($sur['children_amount']) ):?>
        					<br><b><?=bpv_format_currency($sur['children_amount'])?></b> /<?=strtolower(lang('children_label'))?>
        				<?php endif;?>
        				
        			<?php elseif($sur['charge_type'] == SUR_PER_ROOM_PRICE):?>
        			
        				<b><?=$sur['adult_amount'].lang('cb_sur_percentage_per_total')?></b>
        				
        			<?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-8 pd-left-0 rate-name">
                    <?=lang('cb_surcharge_apply')?>
                </div>
                <div class="col-xs-4 no-padding text-right">
                    <?=get_cruise_surcharge_apply_for($check_rate_info, $sur)?>
                </div>
            </div>
            <div class="row no-border">
                <div class="col-xs-8 pd-left-0 rate-name">
                    <b><?=lang('cb_surcharge_total')?></b>
                </div>
                <div class="col-xs-4 no-padding text-right">
                    <span class="bpv-price-from sur-info" id="total_charge_<?=$sur['id']?>" c-type="<?=$sur['charge_type']?>" charge="<?=$sur['adult_amount']?>" rate="<?=$sur['total_charge']?>">
        				<?=bpv_format_currency($sur['total_charge'])?>
        			</span>
                </div>
            </div>

        </div>
    </div>
    <?php endforeach;?>
	
	<script>
    $('.bpv-surcharge').bpvToggle();
    </script>
<?php endif;?>