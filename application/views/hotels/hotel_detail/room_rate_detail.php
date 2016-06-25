<!-- Modal -->
<div class="modal fade" id="room_detail_<?=get_room_rate_id($room_rate)?>" tabindex="-1" role="dialog" aria-labelledby="label_<?=get_room_rate_id($room_rate)?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="bpv-color-title modal-title" id="label_<?=get_room_rate_id($room_rate)?>"><?=get_room_rate_name($room_rate)?></h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-6">
      			<img class="img-responsive" alt="" src="<?=get_image_path(HOTEL, $room_rate['picture'],'416x312')?>">
      			
      			<p class="margin-top-20"><b><?=get_room_type_square_m2($room_rate)?></b></p>
      			
      			<p class="room-breakfast" style="margin-bottom:10px">
					<b>* <?=get_breakfast_vat_txt($room_rate)?></b>
				</p>
				
				<?php if($room_rate['max_children'] > 0):?>
					<p>
						 * <?=lang_arg('room_children_allow', $room_rate['max_children'])?>
					</p>
				<?php endif;?>
				
				<?php if($room_rate['max_extra_beds'] > 0):?>
					<p>
						 * <?=lang_arg('room_extra_bed_allow', $room_rate['max_extra_beds'])?>
					</p>
				<?php endif;?>
				
				
				<p>
					<?=$room_rate['description']?>
				</p>
				
				<h3 class="margin-top-10 bpv-color-title"><?=lang('children_extra_bed')?></h3>
				<table width="100%" class="margin-bottom-10">
					<tr>
						<td class="td-1" style="text-align:left"><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $hotel['infant_age_util'], lang('infant_policy_label'))?></td>
						<td class="td-2" style="text-align:left"><?=$hotel['infants_policy']?></td>
					</tr>
					<tr>
						<td style="text-align:left">
							<span class="icon icon-child margin-right-5"></span>
							<?php 
								$chd_txt = lang('children_policy_label');
								$chd_txt = str_replace('<from>', $hotel['infant_age_util'], $chd_txt);
								$chd_txt = str_replace('<to>', $hotel['children_age_to'], $chd_txt);
							?>
							<?=$chd_txt?>
						</td>
						<td style="text-align:left"><?=$hotel['children_policy']?></td>
					</tr>
				</table>
				
				<div class="margin-bottom-10"><span class="icon icon-asterisk margin-right-5"></span> <?=str_replace('<year>',$hotel['children_age_to'],lang('adults_info'))?></div>
				
				
      		</div>
      		<div class="col-xs-6">
      			<?php if($room_rate['has_basic_price']):?>
      			<p class="text-left">
      				<span><b><?=lang('room_price_per_night')?>:</b>&nbsp;&nbsp;</span>
      				<?php
      					$basic_rates =  $room_rate['basic_rate'];
						$average_rate_origin = count_average_room_rate($basic_rates[$room_rate['occupancy']]);
						$average_rate_sell =  count_average_room_rate($rate);
						
						$extrabed_rates = $room_rate['extrabed_rate'];
					?>
					<?php if($average_rate_origin != $average_rate_sell):?>
						<span class="bpv-price-origin"><?=bpv_format_currency($average_rate_origin)?></span>
						&nbsp;
					<?php endif;?>
					
					<span class="bpv-price-from"><?=bpv_format_currency($average_rate_sell)?></span>
      			</p>
      			
      				<table class="table table-bordered">
      					<?php if($room_rate['max_extra_beds'] > 0 && count($extrabed_rates) > 0):?>
      					<tr>
      						<th class="text-center"><?=lang('rrd_date')?></th>
      						<th class="text-center"><?=lang('rrd_room_price')?></th>
      						<th class="text-center"><?=lang('rrd_extrabed_price')?></th>
      					</tr>
      					<?php endif;?>
	      				<?php foreach($rate as $key=>$value):?>
      						<tr>
      							<td width="20%" style="vertical-align:middle;"><?=format_bpv_date($key,DATE_FORMAT, true)?></td>
      							<td>
      								<?php if($basic_rates[$room_rate['occupancy']][$key] > 0 && $value == 0):?>
				      					<span class="bpv-price-from"><?=lang('free')?></span>
				      				<?php else:?>
      				
	      								<?php if($value != $basic_rates[$room_rate['occupancy']][$key]):?>
	      									<span class="bpv-price-origin"><?=bpv_format_currency($basic_rates[$room_rate['occupancy']][$key])?></span>
	      									&nbsp;
	      								<?php endif;?>
		      							<span class="bpv-price-from"><?=bpv_format_currency($value)?></span>
		      							
	      							<?php endif?>
	      						</td>
	      						
	      						<?php if($room_rate['max_extra_beds'] > 0 && count($extrabed_rates) > 0):?>
	      							<td><span class="bpv-price-from"><?=isset($extrabed_rates[$key]) ? bpv_format_currency($extrabed_rates[$key]) : ''?></span></td>
	      						<?php endif;?>
      						</tr>
      					<?php endforeach;?>
	      				
					</table>
					
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
      			
      			<?php if(!empty($room_rate['cancellation']) || !empty($hotel['extra_cancellation'])):?>
	      			<h3 class="margin-top-10 bpv-color-title"><?=lang('cancellation_policy')?></h3>
	      			<?=empty($hotel['extra_cancellation']) ? $room_rate['cancellation']['content'] : $hotel['extra_cancellation']?>
      			<?php endif;?>
      		</div>
      	</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bpv" data-dismiss="modal"><?=lang('btn_close')?></button>
      </div>
    </div>
  </div>
</div>