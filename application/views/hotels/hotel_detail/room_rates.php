<div class="room-rates">

	<form id="room-rates" role="form" method="post"
		action="<?=hotel_booking_url($hotel, $search_criteria)?>">

		<input type="hidden" name="action" value="<?=ACTION_BOOK_NOW?>">

		<div class="bpv-rate-table clearfix">
			<table>
				<thead>
					<tr>
						<td class="col-1" align="left"><?=lang('room_type')?></td>
						<td class="col-2" align="center"><?=lang('max_capacity')?></td>
						<td class="col-3" align="center"><?=lang('room_price_per_night')?></td>
						<td class="col-4" align="center"><?=lang('number_rooms')?></td>
						<td class="col-5" align="center"><?=lang('book_room')?></td>
					</tr>
				</thead>
				<tbody>
			<?php 
				$first_row = true;
				$row_index = 0;
			?>
			<?php foreach ($room_rates as $key=>$room_rate):?>
				<?php 
					$basic_rates =  $room_rate['basic_rate'];
					$sell_rates = $room_rate['sell_rate'];
					
				?>
				<?php foreach ($sell_rates as $occupancy => $rate):?>
					<?php 
						$room_rate['occupancy'] = $occupancy;
						$row_index++;
					?>
				<tr <?php if($row_index > $room_type_limit):?> class="more-rooms"
						style="display: none;" <?php endif;?>>
						<td>
							<div class="clearfix">
								<div class="col-room-img">
								<?php if(!empty($room_rate['picture'])):?>
									
									<img alt=""
										src="<?=get_image_path(HOTEL, $room_rate['picture'],'160x120')?>"
										alt="<?=$room_rate['name']?>">
									
								<?php else:?>
									&nbsp;
								<?php endif;?>
							</div>
								<div class="col-room-info">

									<div class="room-name margin-bottom-10 bpv-color-title"><?=get_room_rate_name($room_rate)?></div>
									<div class="room-square"><?=get_room_type_square_m2($room_rate)?></div>
							
								<div class="room-breakfast margin-bottom-5">
									<?=get_breakfast_vat_txt($room_rate)?>
								</div>
								
								<?php if(isset($room_rate['promotion']) && $room_rate['promotion']['show_on_web']):?>
								<div class="room-promotion">
									<?=load_promotion_tooltip($room_rate['promotion'], get_room_rate_id($room_rate))?>
								</div>
								<?php endif;?>
								
								<div class="room-more-detail margin-top-10">
										<a href="javascript:void(0)" data-toggle="modal"
											data-target="#room_detail_<?=get_room_rate_id($room_rate)?>"><?=lang('view_room_detail')?></a>
									<?=load_hotel_room_cancellation($hotel, $room_rate, $check_rate_info['startdate'])?>
									
									<?=get_room_rate_detail($hotel, $room_rate, $rate)?>
								</div>

								</div>
							</div>

						</td>

						<td align="center" style="vertical-align: middle;">
						
						<?=get_room_type_occupancy_text($room_rate)?>
					</td>
					
					
					<?php if($room_rate['has_basic_price']):?>
					
					<td align="center">
						
						<?php 
							$average_rate_origin = count_average_room_rate($basic_rates[$occupancy]);
							$average_rate_sell =  count_average_room_rate($rate);
						?>
						<?php if($average_rate_origin != $average_rate_sell):?>
							<div class="bpv-price-origin"><?=bpv_format_currency($average_rate_origin)?></div>
						<?php endif;?>
						
						<div class="bpv-price-from"><?=bpv_format_currency($average_rate_sell)?></div>
						
						<div class="margin-top-10">
							<?=load_hotel_room_price_detail($room_rate, $rate)?>
						</div>
						
						</td>

						<td align="center">
							<select
								onchange="select_rooms('<?=lang('vnd')?>')"
								class="form-control num_room"
								style="font-size: 12px; padding: 6px"
								name="nr_room_<?=get_room_rate_id($room_rate)?>"
								rate-origin="<?=count_total_room_rate($basic_rates[$occupancy])?>"
								rate-sell="<?=count_total_room_rate($rate)?>">
								
							 	<?php for($i = 0; $i <= $max_rooms; $i++):?>
							 		<option value="<?=$i?>"><?=$i?></option>
							 	<?php endfor;?>
							</select>
						</td>
					
					<?php else:?>
						<td colspan="2" align="center">
							
							<?php 
								$params = array('type'=>'hotel','des'=>$hotel['destination_name'],'hotel'=>$hotel['name'],'room' => $room_rate['name'],'startdate'=>$check_rate_info['startdate'],'night'=>$check_rate_info['night']);
							?>
							
							<a type="button" class="btn btn-bpv btn-book-now btn-sm" 
								href="<?=get_url(CONTACT_US_PAGE, $params)?>">
								<?=lang('contact_for_price')?>
							</a>
						</td>
					<?php endif;?>
						
					<?php if($first_row):?>
					<td rowspan="<?=$rate_rows?>" align="center"
							class="col-total-price">

							<div class="margin-bottom-5 label-total-price"
								id="total_rate_label" style="display: none"><?=lang('total_price')?></div>

							<div class="bpv-price-origin" id="total_rate_origin"
								style="display: none"></div>
							<div class="bpv-price-from margin-bottom-10" id="total_rate_sell"
								style="display: none"></div>
								
							<div>
								<button type="submit"
									onclick="return book_hotel_now('<?=lang('please_select_room')?>')"
									class="btn btn-bpv btn-book-now"><?=lang('btn_book_now')?></button>
							</div>
						</td>
					<?php endif;?>
				</tr>
				
				<?php 
					$first_row = false;
				?>
				
				<?php endforeach;?>
				
			<?php endforeach;?>
		</tbody>
			</table>
		
		<?php if($rate_rows > $room_type_limit):?>
		
			<div class="view-mores">
				<span> <a id="show_more_rooms" href="javascript:void(0)" show="hide"
					onclick="show_more_rooms()"><?=lang('view_more_room_types')?></a>
				</span>
			</div>
		
		<?php endif?>
	
	</div>

	</form>
</div>