<div class="room-types">
	<div class="bpv-rate-table">
		<table>
			<thead>
				<tr>
					<td class="col-1" align="left"><?=lang('cabin')?></td>
					<td class="col-2" align="center"><?=lang('max_capacity')?></td>
					<td class="col-3" align="center"><?=lang('cabin_price')?></td>
				</tr>			
			</thead>
			<tbody>
				
				<?php foreach ($cruise_cabins as $key => $cabin):?>
				
				<tr <?php if($key > ($cabin_limit - 1)):?>class="more-rooms" style="display:none;"<?php endif;?>>
					<td>
						<div class="clearfix">
							<div class="col-room-img">
								<?php if(!empty($cabin['picture'])):?>
									
									<img alt="" src="<?=get_image_path(CRUISE, $cabin['picture'], '120x90')?>" alt="<?=$cabin['name']?>">
									
								<?php else:?>
									&nbsp;
								<?php endif;?>
							</div>
							<div class="col-room-info">
								<div class="room-name margin-bottom-10 bpv-color-title"><?=$cabin['name']?></div>
								<div class="room-square"><?=get_cruise_cabin_square_m2($cabin)?></div>
								
								<div class="room-breakfast margin-bottom-5">
								<?=get_cruise_breakfast_vat_txt($cabin)?>
								</div>
								
								<div class="room-more-detail margin-top-10">
									<a href="javascript:void(0)" data-toggle="modal"
											data-target="#room_detail_<?=$cabin['id']?>"><?=lang('view_room_detail')?></a>
									
									<?=get_cabin_detail($cruise, $cabin)?>
								</div>
							</div>
						</div>
					
					</td>
					<td align="center" style="vertical-align:middle;">
						<?=get_cruise_occupancy_text($cabin)?>
					</td>
					<?php if($key == 0):?>
					<td rowspan="<?=count($cruise_cabins)?>" class="col-rate" align="center">
						<span class="icon icon-arrow-top"></span>
						<br><br>
						<span>(<?=lang('check_rate_title')?>)</span>
					</td>
					<?php endif;?>
				</tr>
				
				<?php endforeach;?>
				
			</tbody>
		</table>
		
		<?php if(count($cruise_cabins) > $cabin_limit):?>
		
			<div class="view-mores">
				<span>
					<a id="show_more_rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()"><?=lang('view_more_room_types')?></a>
				</span>
			</div>
		
		<?php endif?>
	</div>
</div>
