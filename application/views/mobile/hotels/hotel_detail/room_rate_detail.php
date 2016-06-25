<!-- Modal -->
<div class="modal fade" id="room_detail_<?=get_room_rate_id($room_rate)?>" tabindex="-1" role="dialog" aria-labelledby="label_<?=get_room_rate_id($room_rate)?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="bpv-color-title modal-title" id="label_<?=get_room_rate_id($room_rate)?>"><?=get_room_rate_name($room_rate)?></h4>
      </div>
      <div class="modal-body">
      	<?php if($room_rate['has_basic_price']):?>
      		<span class="margin-top-10 bpv-color-title" style="font-size:15px;">
      		<?=lang('room_price_per_night')?>
      		</span>
      		<?php
      		$basic_rates =  $room_rate['basic_rate'];
			$average_rate_origin = count_average_room_rate($basic_rates[$room_rate['occupancy']]);
			$average_rate_sell =  count_average_room_rate($rate);
					
			$extrabed_rates = $room_rate['extrabed_rate'];
			?>
			 
			<?php if($average_rate_origin != $average_rate_sell):?>
				<span class="bpv-price-origin"><?=bpv_format_currency($average_rate_origin)?></span>
			<?php endif;?>
				<span class="bpv-price-from"><?=bpv_format_currency($average_rate_sell)?></span>
			 
	   	<div class="rate-tables"> 
	       
				<table class="table table-bordered margin-bottom-0">
      				<?php if($room_rate['max_extra_beds'] > 0 && count($extrabed_rates) > 0):?>
      					<tr>
      						<td class="text-center"><?=lang('rrd_date')?></td>
      						<td class="text-center"><?=lang('rrd_room_price')?></td>
      						<td class="text-center"><?=lang('rrd_extrabed_price')?></td>
      					</tr>
      				<?php endif;?>
      				<?php foreach($rate as $key=>$value):?>
      					<tr>
      						<td width="25%" style="vertical-align:middle;"><?=format_bpv_date($key,DATE_FORMAT, true)?></td>
      						<td>
      							<div class="text-right">
      							<?php if($basic_rates[$room_rate['occupancy']][$key] > 0 && $value == 0):?>
			      					<span class="bpv-price-from"><?=lang('free')?></span>
			      				<?php else:?>
      									
	      							<?php if($value != $basic_rates[$room_rate['occupancy']][$key]):?>
      									<span class="bpv-price-origin"><?=bpv_format_currency($basic_rates[$room_rate['occupancy']][$key])?></span>
      									
      								<?php endif;?>
	      								<span class="bpv-price-from"><?=bpv_format_currency($value)?></span>
      							<?php endif?>
      							</div>
      						</td>
      						
      						<?php if($room_rate['max_extra_beds'] > 0 && count($extrabed_rates) > 0):?>
      							<td><span class="bpv-price-from text-right"><?=isset($extrabed_rates[$key]) ? bpv_format_currency($extrabed_rates[$key]) : ''?></span></td>
      						<?php endif;?>
      					</tr>
      				<?php endforeach;?>
      				
				</table>
			 
		</div>		
      	<?php endif;?>
      
      <?php if(count($room_rate['room_facilities']) > 0):?>
      <h3 class="margin-top-10 bpv-color-title"><?=lang('room_facilities')?></h3>
      <div class="clearfix">
      <?php foreach ($room_rate['room_facilities'] as $fa):?>
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
	      	<div class="col-xs-6 col-xs-offset-3">
	      		<button type="button" class="btn btn-bpv btn-block center-block" data-dismiss="modal"><?=lang('btn_close')?></button>
	      	</div>
	      </div>
      </div>
    </div>
  </div>
</div>