<!-- Modal -->
<div class="modal fade" id="room_detail_<?=$room_type['id']?>" tabindex="-1" role="dialog" aria-labelledby="label_<?=$room_type['id']?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="bpv-color-title modal-title" id="label_<?=$room_type['id']?>"><?=$room_type['name']?></h4>
      </div>
      <div class="modal-body">
      		
      		<?php if(count($room_type['room_facilities']) > 0):?>
      				<h3 class="margin-top-10 bpv-color-title"><?=lang('room_facilities')?></h3>
      				<div class="clearfix">
      					<?php foreach ($room_type['room_facilities'] as $fa):?>
      						
      					<div class="col-fa">
							<img alt="" src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>" style="margin-right:3px">
					<span <?php if($fa['is_important']):?>style="color:#4eac00;font-weight:bold"<?php endif;?>>
					<?=$fa['name']?>
							</span>	
						</div>
						
      					<?php endforeach;?>
      				</div>
      	    <?php endif;?>
      		
      		<h3 class="margin-top-10 bpv-color-title"><?=lang('children_extra_bed')?></h3>
      		<label>
      			<span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $hotel['infant_age_util'], lang('infant_policy_label'))?>
      		</label>
      		<p>
      			<?=$hotel['infants_policy']?>
      		</p>
      		
      		<label>
      			
      			<span class="icon icon-child margin-right-5"></span>
						<?php 
							$chd_txt = lang('children_policy_label');
							$chd_txt = str_replace('<from>', $hotel['infant_age_util'], $chd_txt);
							$chd_txt = str_replace('<to>', $hotel['children_age_to'], $chd_txt);
						?>
						<?=$chd_txt?>
      		
      		</label>
      		<p>
      			<?=$hotel['children_policy']?>
      		</p>
      		
	
			<div class="margin-bottom-10"><span class="icon icon-asterisk margin-right-5"></span> <?=str_replace('<year>',$hotel['children_age_to'],lang('adults_info'))?></div>
		
				
      			
      			<?php if(!empty($room_type['cancellation']) || !empty($hotel['extra_cancellation'])):?>
      			<h3 class="margin-top-10 bpv-color-title"><?=lang('cancellation_policy')?></h3>
      			<?=empty($hotel['extra_cancellation']) ? $room_type['cancellation']['content'] : $hotel['extra_cancellation']?>
      			<?php endif;?>
      						
      	

      
      </div>
      <div class="modal-footer">
      	<div class="row">
      		<div class="col-xs-8 col-xs-offset-2">
        		<button type="button" class="btn btn-bpv btn-block" data-dismiss="modal"><?=lang('btn_close')?></button>
        	</div>
        </div>
      </div>
    </div>
  </div>
</div>