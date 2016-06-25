<div class="room-types">
	<div class="bpv-rate-table">
		<table>
			<thead>
				<tr>
					<td class="col-1" align="left"><?=lang('room_type')?></td>
					<td class="col-2" align="center"><?=lang('max_capacity')?></td>
					<td class="col-3" align="center"><?=lang('room_price')?></td>
				</tr>			
			</thead>
			<tbody>
				
				<?php foreach ($hotel_room_types as $key=>$room_type):?>
				
				<tr <?php if($key > ($room_type_limit - 1)):?>class="more-rooms" style="display:none;"<?php endif;?>>
					<td>
						<div class="clearfix">
							<div class="col-room-img">
								<?php if(!empty($room_type['picture'])):?>
									
									<img alt="" src="<?=get_image_path(HOTEL, $room_type['picture'],'120x90')?>" alt="<?=$room_type['name']?>">
									
								<?php else:?>
									&nbsp;
								<?php endif;?>
							</div>
							<div class="col-room-info">
								<div class="room-name margin-bottom-10 bpv-color-title"><?=$room_type['name']?></div>
								<div class="room-square"><?=get_room_type_square_m2($room_type)?></div>
							</div>
						</div>
					
					</td>
					<td align="center" style="vertical-align:middle;">
						<?=get_room_type_occupancy_text($room_type)?>
					</td>
					<?php if($key == 0):?>
					<td rowspan="<?=count($hotel_room_types)?>" class="col-rate" align="center">
						<span class="icon icon-arrow-top"></span>
						<br><br>
						<span>(<?=lang('check_rate_title')?>)</span>
					</td>
					<?php endif;?>
				</tr>
				
				<?php endforeach;?>
				
			</tbody>
		</table>
		
		<?php if(count($hotel_room_types) > $room_type_limit):?>
		
			<div class="view-mores">
				<span>
					<a id="show_more_rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()"><?=lang('view_more_room_types')?></a>
				</span>
			</div>
		
		<?php endif?>
	</div>
</div>
