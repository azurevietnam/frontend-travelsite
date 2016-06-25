<a href="javascript:void(0)" class="bpv-color-marketing pop-promotion" data-toggle="modal" data-target=".marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>" id="marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>">
	<span class="icon icon-gift"></span>
	<b><?=lang('mak_bpt_extra')?>:</b> <?=$bpv_pro['name']?>
</a>
<div class="modal fade marketing_detail_<?=$bpv_pro['id'].'_'.$hotel_id?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        	<div class="modal-header">
	        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
	        	<h4 class="bpv-color-title modal-title" id="marketing_title_<?=$bpv_pro['id'].'_'.$hotel_id?>"> <?=$bpv_pro['name']?> </h4>
	      	</div>
        
            <div class="modal-body">
                <div id="marketing_content_<?=$bpv_pro['id'].'_'.$hotel_id?>">
                	<div style="min-width:280px;" class="margin-bottom-10">
                		<?=lang('mak_expired_date')?>: <b><?=format_bpv_date($bpv_pro['expired_date'], DATE_FORMAT, true)?></b>
                	</div>
                	<!-- 
                	<div class="margin-bottom-10">
                		<?=lang('mak_cus_booked')?>: <b><?=($bpv_pro['current_nr_booked'])?></b>
                	</div>
                	
                	 
                	<?php if($bpv_pro['hotel_discount_type'] > 0 || $bpv_pro['flight_discount_type'] > 0):?>
                	
                		<div class="margin-bottom-10">
                			<?=lang_arg('mak_available_booked', ($bpv_pro['max_nr_booked'] - $bpv_pro['current_nr_booked']))?>
                		</div>
                		
                	<?php endif;?>
                	 -->
                
                	<?php if($bpv_pro['description'] != ''):?>
                		<div class="margin-bottom-10">
                			<?=$bpv_pro['description']?>
                		</div>
                	<?php endif;?>
                	
                </div>
            </div>
            <div class="modal-footer">
            	<div class="row">
            		<div class="col-xs-6 col-xs-offset-3">
						<button type="button" class="btn btn-bpv btn-block" data-dismiss="modal"><?=lang('btn_close')?></button>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>								
