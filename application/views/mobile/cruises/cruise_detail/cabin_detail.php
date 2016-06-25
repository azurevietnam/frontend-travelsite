<?php 
	$cabin_detail_id = 'room_detail_'.$cabin['id'];
	if(isset($acc['promotion'])) {
		$cabin_detail_id .= '_'.$acc['promotion']['id'];
	}
?>
<div class="modal fade" id="<?=$cabin_detail_id?>" tabindex="-1" role="dialog" aria-labelledby="label_<?=$cabin['id']?>" aria-hidden="true">
	<div class="modal-dialog modal-dialog-room">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-hidden="true">
					<span class="icon btn-support-close"></span>
				</button>
				<h4 class="bpv-color-title modal-title" id="label_<?=$cabin['id']?>"><?=$cabin['name']?></h4>
			</div>
			<div class="modal-body">
			
			    <?php if(count($cabin['cabin_facilities']) > 0):?>
  				<h3 class="bpv-color-title margin-top-0"><?=lang('cabin_facilities')?></h3>
				<div class="clearfix">
  					<?php foreach ($cabin['cabin_facilities'] as $fa):?>
  						
  					<div class="col-fa">
						<img src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>"
							style="margin-right: 3px"> <span <?php if($fa['is_important']):?>
							style="color: #4eac00; font-weight: bold" <?php endif;?>>
						<?=$fa['name']?>
						</span>
					</div>
					
  					<?php endforeach;?>
  				</div>
  			    <?php endif;?>
				
				<h3 class="margin-top-10 bpv-color-title"><?=lang('children_extra_bed')?></h3>
				<label><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $cruise['infant_age_util'], lang('infant_policy_label'))?></label>
				<p><?=$cruise['infants_policy']?></p>
				<label>
				    <span class="icon icon-child margin-right-5"></span>
				    <?php
                        $chd_txt = lang('children_policy_label');
                        $chd_txt = str_replace('<from>', $cruise['infant_age_util'], $chd_txt);
                        $chd_txt = str_replace('<to>', $cruise['children_age_to'], $chd_txt);
                        echo $chd_txt;
                    ?>
				</label>
				<p><?=$cruise['children_policy']?></p>
                
                <p>
                    <span class="icon icon-asterisk margin-right-5"></span> 
					<?=str_replace('<year>', $cruise['children_age_to'], lang('adults_info'))?>
                </p>
      	
      	        <?php if(!empty($acc['sell_rate'])):?>
      	        <div class="rate-tables">
          	        <h3 class="bpv-color-title"><?=lang('room_rate_details')?></h3>
              	    <div class="row">
                        <div class="col-xs-8 pd-left-0 rate-name"><?='1 '.lang('adult_label')?></div>
    					<div class="col-xs-4 no-padding text-right bpv-price-from"><?=bpv_format_currency($acc['adult_rate'])?></div>
            	    </div>
                    	   
                    <?php if(!empty($check_rate_info['children'])):?>
                    <div class="row">
                       <div class="col-xs-8 pd-left-0 rate-name"><?='1 '.lang('children_label')?></div>
                       
                       <div class="col-xs-4 no-padding text-right">
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
                       <div class="col-xs-8 pd-left-0 rate-name"><?='1 '.lang('infant_label')?></div>
                       
                       <div class="col-xs-4 no-padding text-right">
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
                       <div class="col-xs-8 pd-left-0 rate-name"><?='1 '.lang('single_sup')?></div>
                       
                       <div class="col-xs-4 no-padding text-right bpv-price-from">
                    		<?=bpv_format_currency($acc['single_sup_rate'])?>
                        </div>
                    </div>
                    <?php endif;?>
                    
                    
                    <div class="row no-border">
                       <div class="col-xs-7 pd-left-0 rate-name"><b><?=lang('total_price')?></b></div>
                       
                       <div class="col-xs-5 no-padding text-right bpv-price-from">
                    		<b><?=bpv_format_currency($acc['sell_rate'])?></b>
                        </div>
                    </div>
                </div>
      			<?php endif;?>
      		    
      			<?php if(!empty($acc['cancellation']) || !empty($tour['extra_cancellation'])):?>
          			<h3 class="bpv-color-title"><?=lang('cancellation_policy')?></h3>
          			
    				<?php if(isset($acc['cancellation']) && $acc['cancellation']['id'] == CANCELLATION_NO_REFUND):?>
    					<?=$acc['cancellation']['content']?>
    				<?php else:?>
          				<?=empty($tour['extra_cancellation']) ? $acc['cancellation']['content'] : $tour['extra_cancellation']?>
          			<?php endif;?>
      			<?php endif;?>
                
            </div>
			<div class="modal-footer">
    			<div class="col-xs-8 col-xs-offset-2">
    			     <button type="button" class="btn btn-bpv btn-block" data-dismiss="modal"><?=lang('btn_close')?></button>
    			</div>
			</div>
		</div>
	</div>
</div>