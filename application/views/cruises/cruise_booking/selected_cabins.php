<?php
	$acc = $selected_cabin['cabin_rate_info'];
?>
<input type="hidden" name="selected_cabin" value="<?=get_tour_rate_id($acc)?>">

<div class="bpv-rate-table clearfix margin-bottom-20">	
	<table>
		<thead>
			<tr>
				<td class="col-1" align="left"><?=lang('cabin_type')?></td>
				<td class="col-2" align="center"><?='1 ' . lang('adult_label')?></td>
				<?php if(!empty($check_rate_info['children'])):?>
				<td class="col-2" align="center"><?='1 ' . lang('children_label')?></td>
				<?php endif;?>
				<?php if(!empty($check_rate_info['infants'])):?>
				<td class="col-2" align="center"><?='1 ' . lang('infant_label')?></td>
				<?php endif;?>
				<?php if($check_rate_info['adults']%2 != 0):?>
				<td class="col-2" align="center" nowrap="nowrap"><?=lang('single_sup')?></td>
				<?php endif;?>
				<td class="col-3" align="center"><?=lang('total_price')?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php if(isset($acc['cabin'])):?>
						
						<?php $cabin = $selected_cabin['cabin_rate_info']['cabin']; ?>
						
						<div class="room-name margin-bottom-10 bpv-color-title"><?=$cabin['name']?></div>
						<div class="room-square"><?=get_cruise_cabin_square_m2($cabin)?></div>
						
						<div class="room-breakfast margin-bottom-5">
						<?=lang('include_text').lang('include_tax_and_service_fee')?>
						</div>
						
						<?php if(isset($acc['promotion']) && $acc['promotion']['show_on_web']):?>
						<div class="room-promotion">
							<?=load_promotion_tooltip($acc['promotion'], $acc['id'].'_acc')?>
						</div>
						<?php endif;?>
						
						<?php 
							$cabin_detail_id = '#room_detail_'.$cabin['id'];
							if(isset($acc['promotion'])) {
								$cabin_detail_id .= '_'.$acc['promotion']['id'];
							}
						?>
						
						<div class="room-more-detail margin-top-10">
							<a href="javascript:void(0)" data-toggle="modal"
									data-target="<?=$cabin_detail_id?>"><?=lang('view_room_detail')?></a>
							
							<?=load_tour_accommodation_cancellation($tour, $acc, $check_rate_info['startdate'])?>
							
							<?=get_cabin_detail($cruise, $cabin, $acc)?>
						</div>
					<?php else:?>
							<div class="room-name margin-bottom-10"><?=$acc['name']?></div>
							<p><?=$acc['content']?></p>
					<?php endif;?>
				</td>
				<td align="center" nowrap="nowrap" style="text-align: center;">
					<?php if($acc['adult_rate'] != $acc['adult_basic_rate']):?>
						<div class="bpv-price-origin"><?=bpv_format_currency($acc['adult_basic_rate'])?></div>
					<?php endif;?>
					<div class="bpv-price-from"><?=bpv_format_currency($acc['adult_rate'])?></div>
				</td>
				
				<?php if(!empty($check_rate_info['children'])):?>
				<td align="center" nowrap="nowrap" style="text-align: center;">
					<?php if($acc['children_rate'] != $acc['children_basic_rate']):?>
						<div class="bpv-price-origin"><?=bpv_format_currency($acc['children_basic_rate'])?></div>
					<?php endif;?>
					<div class="bpv-price-from">
						<?php if(!empty($acc['children_rate'])):?>
							<?=bpv_format_currency($acc['children_rate'])?>
						<?php else:?>
							<span style="font-weight: normal; font-size: 13px"><?=lang('free_of_charge')?></span>
						<?php endif;?>
					</div>
				</td>
				<?php endif;?>
				
				<?php if(!empty($check_rate_info['infants'])):?>
				<td align="center" nowrap="nowrap" style="text-align: center;">
					<?php if($acc['infant_rate'] != $acc['infant_basic_rate']):?>
						<div class="bpv-price-origin"><?=bpv_format_currency($acc['infant_basic_rate'])?></div>
					<?php endif;?>
					<div class="bpv-price-from">
						<?php if(!empty($acc['infant_rate'])):?>
							<?=bpv_format_currency($acc['infant_rate'])?>
						<?php else:?>
							<span style="font-weight: normal; font-size: 13px"><?=lang('free_of_charge')?></span>
						<?php endif;?>
					</div>
				</td>
				<?php endif;?>
				
				<?php if($check_rate_info['adults']%2 != 0):?>
				<td align="center" nowrap="nowrap" style="text-align: center;">
					<?php if($acc['single_sup_rate'] != $acc['single_sup_basic_rate']):?>
						<div class="bpv-price-origin"><?=bpv_format_currency($acc['single_sup_basic_rate'])?></div>
					<?php endif;?>
					<div class="bpv-price-from"><?=bpv_format_currency($acc['single_sup_rate'])?></div>
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
</div>