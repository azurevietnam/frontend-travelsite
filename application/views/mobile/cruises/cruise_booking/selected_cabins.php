<?php
	$acc = $selected_cabin['cabin_rate_info'];
?>
<input type="hidden" name="selected_cabin" value="<?=get_tour_rate_id($acc)?>">

<div class="bpv-panel">
    <div class="panel-heading">
    
        <?php if(isset($acc['cabin'])):?>
						
    		<?php $cabin = $selected_cabin['cabin_rate_info']['cabin']; ?>
    		
    		<div class="panel-title bpv-toggle" data-target="#acc_<?=$acc['id']?>">
    	        <div class="row">
        	        <div class="col-xs-10">
        	           <h3 class="bpv-color-title"><?=$cabin['name']?></h3>
        	           <span class="notes"><?=get_cruise_cabin_square_m2($cabin)?></span>
        	           <?php $is_no_cancell = $acc['cancellation']['id'] == CANCELLATION_NO_REFUND; ?>
    	               <?php if($is_no_cancell):?>
    	               <span class="bpv-color-warning"><?=lang('no_cancel')?></span>
    	               <?php endif;?>
                    </div>
                    <div class="col-xs-2 pd-left-0 text-right">
                        <i class="bpv-toggle-icon icon icon-chevron-down"></i>
                    </div>
                </div>
    	   </div>
    	   
    	   <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
        	   
        	    <?php if(!empty($cabin['picture'])):?>
		        <img class="img-responsive" src="<?=get_image_path(CRUISE, $cabin['picture'],'416x312')?>" alt="<?=$cabin['name']?>">
			    <?php endif;?>
      			
      			<p class="bpv-color-green margin-bottom-10 margin-top-10">
					<b>* <?=get_cruise_breakfast_vat_txt($cabin)?></b>
				</p>
	
    		    <?php if($cabin['max_children'] > 0):?>
    			<p>
    				 * <?=lang_arg('room_children_allow', $cabin['max_children'])?>
    			</p>
    		    <?php endif;?>
    		
    		    <?php if($cabin['max_extra_beds'] > 0):?>
    			<p>
    				 * <?=lang_arg('room_extra_bed_allow', $cabin['max_extra_beds'])?>
    			</p>
    		    <?php endif;?>
    		
        		<p><?=$cabin['description']?></p>
        		
        		<?php 
        			$cabin_detail_id = '#room_detail_'.$cabin['id'];
        			if(isset($acc['promotion'])) {
        				$cabin_detail_id .= '_'.$acc['promotion']['id'];
        			}
        		?>
        		
        		<button type="button" class="btn btn-default center-block margin-top-10" data-toggle="modal" data-target="<?=$cabin_detail_id?>">
			    <?=lang('m_view_room_detail')?>
			    </button>
			    
			    <?=get_cabin_detail($cruise, $cabin, $acc, true)?>
    	   </div>
    	
    	<?php else:?>
    	
    	   <div class="panel-title">
    	       <h3 class="bpv-color-title"><?=$acc['name']?></h3>
    	   </div>
    	   
    	   <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
    	   <?=$acc['content']?>
    	   </div>
    	   
    	<?php endif;?>
    	
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