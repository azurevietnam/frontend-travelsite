<div class="room-rates">

	<form id="room-rates" role="form" method="post" action="<?=land_tour_booking_url($tour, $check_rate_info)?>">

		<input type="hidden" name="action" value="<?=ACTION_BOOK_NOW?>">

		<div class="bpv-rate-table clearfix">
			<table>
				<thead>
					<tr>
						<td class="col-1" align="left"><?=lang('class_name')?></td>
						
						<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px"><?='1<br> ' . lang('adult_label')?></td>
						
						<?php if(!empty($check_rate_info['children'])):?>
						<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px"><?='1<br>' . lang('children_label')?></td>
						<?php endif;?>
						
						<?php if(!empty($check_rate_info['infants'])):?>
						<td class="col-2" align="center" nowrap="nowrap" style="font-size: 12px"><?='1<br>' . lang('infant_label')?></td>
						<?php endif;?>
						
						<?php if($check_rate_info['adults']%2 != 0):?>
						<td class="col-2" align="center" style="font-size: 12px"><?=lang('single_sup')?></td>
						<?php endif;?>
						
						<td class="col-3" align="center"><?=lang('total_price')?></td>
						
						<td class="col-2" align="center" nowrap="nowrap"><?=lang('book_room')?></td>
					</tr>
				</thead>
				<tbody>
			<?php foreach ($accommodations as $key => $acc):?>
				
				<tr <?php if($key > ($accommodation_limit - 1)):?>class="more-rooms" style="display:none;"<?php endif;?>>

					<td>
						<div class="room-name margin-bottom-10 bpv-color-title"><?=$acc['name']?></div>
						
						<p><?=$acc['content']?></p>
						
						<?php 
							$cabin_detail_id = '#room_detail_'.$acc['id'];
							if(isset($acc['promotion'])) {
								$cabin_detail_id .= '_'.$acc['promotion']['id'];
							}
						?>
						
						<?php if(isset($acc['promotion']) && $acc['promotion']['show_on_web']):?>
						<div class="room-promotion">
							<?=load_promotion_tooltip($acc['promotion'], $acc['id'].'_acc')?>
						</div>
						<?php endif;?>
						
						<?php if (!empty($bpv_promotions)):?>
						<!-- Promotion from Best Price -->
							<?php foreach ($bpv_promotions as $bpv_pro):?>
								<div class="margin-bottom-5">
									<?=load_marketing_pro_tooltip($bpv_pro, str_replace('#', '', $cabin_detail_id))?>
								</div>
							<?php endforeach;?>	
					
						<?php endif;?>
						
						<div class="room-more-detail margin-top-10">
							<?=get_land_tour_accommodation_cancellation($tour, $acc, $check_rate_info['startdate'])?>
						</div>
					</td>
					
					<?php if(!empty($acc['adult_basic_rate']) && !empty($acc['sell_rate'])):?>
					<td align="center" nowrap="nowrap">
						<?php if($acc['adult_rate'] != $acc['adult_basic_rate']):?>
							<div class="bpv-price-origin"><?=bpv_format_currency($acc['adult_basic_rate'])?></div>
						<?php endif;?>
						<div class="bpv-price-from"><?=bpv_format_currency($acc['adult_rate'])?></div>
					</td>
					<?php endif;?>
					
					<?php if(!empty($check_rate_info['children']) && !empty($acc['sell_rate'])):?>
					<td align="center" nowrap="nowrap">
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
					
					<?php if(!empty($check_rate_info['infants']) && !empty($acc['sell_rate'])):?>
					<td align="center" nowrap="nowrap">
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
					<td align="center" nowrap="nowrap">
						<?php if($acc['single_sup_rate'] != $acc['single_sup_basic_rate']):?>
							<div class="bpv-price-origin"><?=bpv_format_currency($acc['single_sup_basic_rate'])?></div>
						<?php endif;?>
						<div class="bpv-price-from"><?=bpv_format_currency($acc['single_sup_rate'])?></div>
					</td>
					<?php endif;?>
					
					<?php if(!empty($acc['sell_rate'])):?>
						
						<td align="center" nowrap="nowrap">
							<?php if($acc['sell_rate'] != $acc['basic_rate']):?>
							<div class="bpv-price-origin"><?=bpv_format_currency($acc['basic_rate'])?></div>
							<?php endif;?>
							<div class="bpv-price-from"><?=bpv_format_currency($acc['sell_rate'])?></div>
						</td>
						
						<td class="col-rate" align="center" style="vertical-align: middle;">
							<button class="btn btn-bpv btn-book-now" type="submit" name="selected_cabin" value="<?=get_tour_rate_id($acc)?>"><?=lang('btn_book_now')?></button>
						</td>
					<?php else:?>
						<td class="col-rate" align="center" colspan="5">
							<?php $params = get_tour_contact_params($tour, $check_rate_info);?>
							<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
									href="<?=get_url(CONTACT_US_PAGE, $params)?>">
								<?=lang('contact_for_price')?>
							</a>
						</td>
					<?php endif;?>
				</tr>
				
				<?php endforeach;?>
				
			</tbody>
		</table>
		
		<?php if(count($accommodations) > $accommodation_limit):?>
		
			<div class="view-mores">
				<span>
					<a id="show_more_rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()"><?=lang('view_more_tour_accom')?></a>
				</span>
			</div>
		
		<?php endif?>
	
	</div>

	</form>
</div>

<?=$price_include_exclude?>

<script>
$('.pop-promotion').on('click', function (e) {
    $('.pop-promotion').not(this).popover('hide');
});
</script>