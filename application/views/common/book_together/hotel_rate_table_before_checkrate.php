<table width="720" cellpadding="0" cellspacing="0" class="tour_accom" style="width:720px">
	<thead>
		<tr>
			<th width="77%" align="left"><?=lang('room_type')?></th>			
			<th width="23%"><?=lang('label_rates')?></th>
		</tr>
	</thead>
	
		<tbody>
			<?php foreach ($hotel['room_types'] as $key => $value):?>
				<?php 
					$class_name = ($key & 1) ? "odd_row" : "";
				?>
				<tr>
					<td valign="top">
						
						<a href="javascript:void(0)" onclick="openRoomTypeInfo(<?=$value['id']?>)">
							<span id="img_<?=$value['id']?>" class="togglelink"></span><?=$value['name']?> 
						</a>																	
			
					</td>
					<?php if ($key == 0):?>				
						<td rowspan="<?=count($hotel['room_types'])*2?>" align="center">
							<span class="icon icon-arrow-up"></span><br>
							<b><?=lang('label_enter_your_arrival_date')?></b>
						</td>
					<?php endif;?>
				</tr>	
			
					
					
				<tr id="detail_infor_<?=$value['id']?>" style="display: none;">
					<td>
																	
							<img style="position: relative; padding: 0 10px 10px 0px; float: left;" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>"></img>
							
							<span style="float: left;"><b><?=lang('room_size')?>: </b><?=$value['room_size']?> <?=lang('square_metres')?></span><br/>
							
							<span style="float: left;"><b><?=lang('bed_size')?>:</b> <?=$value['bed_size']?></span><br/>
							
							<p><?=str_replace("\n", "<br>", $value['description'])?></p>
							
							<div style="clear: left; width: 100%;">
								<p style="margin-bottom: 7px;"><b><?=lang('room_facilities')?>:</b></p>
								<ul class="accomm_cabin_facility">
				
									<?php foreach ($value['facilities'] as $f_value):?>																		
									
										<li><span class="icon icon_checkmark"></span><?=$f_value['name']?></li>
																											
									<?php endforeach ;?>
								</ul>
							</div>
					
					</td>
					
					
				</tr>	
												
			<?php endforeach;?>
		</tbody>
	
</table>