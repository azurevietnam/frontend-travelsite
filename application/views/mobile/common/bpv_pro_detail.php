<a href="javascript:void(0)" class="bpv-color-promotion pop-promotion" data-toggle="modal" data-target=".pro_detail_<?=$pro['id'].'_'.$obj_id?>" id="pro_detail_<?=$pro['id'].'_'.$obj_id?>">
	<span class="icon icon-promotion"></span>
	<?=$pro['name']?>
</a>

<div class="modal fade pro_detail_<?=$pro['id'].'_'.$obj_id?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
        		<div class="modal-header">
		        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
		        	<h4 class="bpv-color-promotion modal-title" id="pro_title_<?=$pro['id'].'_'.$obj_id?>"> <?=$pro['name']?> </h4>
		      	</div>
		      	
                <div class="modal-body">
                    <div id="pro_content_<?=$pro['id'].'_'.$obj_id?>">
                    	
                    	<div class="margin-bottom-10">
                    		<?=lang_arg('hp_valid_to', date(DATE_FORMAT, strtotime($pro['book_date_from'])), date(DATE_FORMAT, strtotime($pro['book_date_to'])))?>
                    	</div>
                    	
                    	<div style="min-width:280px;" class="margin-bottom-10">
                    		<?=lang_arg('hp_stay_date', date(DATE_FORMAT, strtotime($pro['stay_date_from'])), date(DATE_FORMAT, strtotime($pro['stay_date_to'])))?>
                    	</div>
                    	
                    	<?php 
                    		$cnt = 0;
                    		foreach ($week_days as $key=>$value){
                    			if(is_bit_value_contain($pro['check_in_on'], $key)){
                    				$cnt++;
                    			}
                    		}
                    		
                    	?>
                    	
                    	<?php if($cnt <7):?>
                    	<div class="margin-bottom-10">
                    		<b><?=lang('hp_apply_on')?>:</b>
                    		<?php foreach ($week_days as $key=>$value):?>
                    			
                    			<?php if(is_bit_value_contain($pro['check_in_on'], $key)):?>
                    				<?=lang($value)?>, 
                    			<?php endif;?>
                    			
                    		<?php endforeach;?>
                    	</div>
                    	<?php endif;?>
                    	
                    	<?php if($pro['offer'] != ''):?>
                    		<div class="margin-bottom-10">
                    			<?=$pro['offer']?>
                    		</div>
                    	<?php endif;?>
                </div>
            </div>
            <div class="modal-footer">
            	<div class="row">
            		<div class="col-xs-6 col-xs-offset-3">
						<button type="button" class="btn btn-bpv btn-block" data-dismiss="modal"> <?=lang('btn_close')?></button>
					</div>
				</div>
			</div>
        </div>
    </div>	
</div>					
