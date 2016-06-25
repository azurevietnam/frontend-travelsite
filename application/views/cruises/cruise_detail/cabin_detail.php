<?php 
	$cabin_detail_id = 'room_detail_'.$cabin['id'];
	if(isset($acc['promotion'])) {
		$cabin_detail_id .= '_'.$acc['promotion']['id'];
	}
?>
<!-- Modal -->
<div class="modal fade" id="<?=$cabin_detail_id?>" tabindex="-1" role="dialog" aria-labelledby="label_<?=$cabin['id']?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="bpv-color-title modal-title" id="label_<?=$cabin['id']?>"><?=$cabin['name']?></h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-6">
      			<img class="img-responsive" alt="" src="<?=get_image_path(CRUISE, $cabin['picture'], '416x312')?>">
      			
      			<p class="margin-top-20"><b><?=get_cruise_cabin_square_m2($cabin)?></b></p>
      			
      			<p class="room-breakfast" style="margin-bottom:10px">
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
				
				
				<p>
					<?=$cabin['description']?>
				</p>
				
				<h3 class="margin-top-10 bpv-color-title"><?=lang('children_extra_bed')?></h3>
				<table width="100%" class="margin-bottom-10">
					<tr>
						<td class="td-1" style="text-align:left"><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $cruise['infant_age_util'], lang('infant_policy_label'))?></td>
						<td class="td-2" style="text-align:left"><?=$cruise['infants_policy']?></td>
					</tr>
					<tr>
						<td style="text-align:left">
							<span class="icon icon-child margin-right-5"></span>
							<?php 
								$chd_txt = lang('children_policy_label');
								$chd_txt = str_replace('<from>', $cruise['infant_age_util'], $chd_txt);
								$chd_txt = str_replace('<to>', $cruise['children_age_to'], $chd_txt);
							?>
							<?=$chd_txt?>
						</td>
						<td style="text-align:left"><?=$cruise['children_policy']?></td>
					</tr>
				</table>
				
				<div class="margin-bottom-10"><span class="icon icon-asterisk margin-right-5"></span> <?=str_replace('<year>', $cruise['children_age_to'], lang('adults_info'))?></div>
      		</div>
      		<div class="col-xs-6">
      			<?php if(!empty($acc['sell_rate'])):?>
      			<table class="margin-bottom-20">
					<thead>
						<tr>
							<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px; font-weight: bold;"><?='1 ' . lang('adult_label')?></td>
							<?php if(!empty($check_rate_info['children'])):?>
							<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px; font-weight: bold;"><?='1 ' . lang('children_label')?></td>
							<?php endif;?>
							<?php if(!empty($check_rate_info['infants'])):?>
							<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px; font-weight: bold;"><?='1 ' . lang('infant_label')?></td>
							<?php endif;?>
							<?php if($check_rate_info['adults']%2 != 0):?>
							<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px; font-weight: bold;"><?=lang('single_sup')?></td>
							<?php endif;?>
							<td class="col-3" align="center" style="font-weight: bold;"><?=lang('total_price')?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="center" class="bpv-price-from" nowrap="nowrap" style="vertical-align:middle; font-size: 13px">
								<?=bpv_format_currency($acc['adult_rate'])?>
							</td>
							
							<?php if(!empty($check_rate_info['children'])):?>
							<td align="center" class="bpv-price-from" nowrap="nowrap" style="vertical-align:middle; font-size: 13px">
								<?=bpv_format_currency($acc['children_rate'])?>
							</td>
							<?php endif;?>
							
							<?php if(!empty($check_rate_info['infants'])):?>
							<td align="center" class="bpv-price-from" nowrap="nowrap" style="vertical-align:middle; font-size: 13px">
								<?=bpv_format_currency($acc['infant_rate'])?>
							</td>
							<?php endif;?>
							
							<?php if($check_rate_info['adults']%2 != 0):?>
							<td align="center" class="bpv-price-from" nowrap="nowrap" style="vertical-align:middle; font-size: 13px">
								<?=bpv_format_currency($acc['single_sup_rate'])?>
							</td>
							<?php endif;?>
							
							<td>
								<?php if($acc['sell_rate'] != $acc['basic_rate']):?>
								<div class="bpv-price-origin"><?=bpv_format_currency($acc['basic_rate'])?></div>
								<?php endif;?>
								<div class="bpv-price-from"><?=bpv_format_currency($acc['sell_rate'])?></div>
							</td>
						</tr>
					</tbody>
				</table>
      			<?php endif;?>
      			
      			<?php if(count($cabin['cabin_facilities']) > 0):?>
      				<h3 class="bpv-color-title"><?=lang('cabin_facilities')?></h3>
      				<div class="clearfix">
      					<?php foreach ($cabin['cabin_facilities'] as $fa):?>
      						
      					<div class="col-fa">
							<img alt="" src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>" style="margin-right:3px">
							<span <?php if($fa['is_important']):?>style="color:#4eac00;font-weight:bold"<?php endif;?>>
							<?=$fa['name']?>
							</span>	
						</div>
						
      					<?php endforeach;?>
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
      	</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bpv" data-dismiss="modal"><?=lang('btn_close')?></button>
      </div>
    </div>
  </div>
</div>