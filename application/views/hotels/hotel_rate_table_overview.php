
	<div id="hotel_rates" style="float: left;margin-top: 7px; width: 100%">
	
		<p id="booking_warning" style="display: none;">
			<img width="40" height="40" align="middle" alt="" src="<?=site_url('media').'/warning-1.jpg'?>">
			<span class="warning_message"><?=lang('error_room_select_message')?></span>
		</p>
	
		<form id="frm_hotel_reservation_<?=$hotel['id']?>" name="frm_hotel_reservation_<?=$hotel['id']?>" method="POST" action="<?=site_url('hotel_detail/reservation/'.$hotel['id'])?>">
		
		<?php if(isset($is_extra_booking)):?>
			<input type="hidden" name="is_extra_booking" value="1">
		<?php endif;?>
		
		<?php if(isset($parent_id)):?>
			<input type="hidden" name="parent_id" value="<?=$parent_id?>">
		<?php endif;?>
		
		<?php 
			$discount = $discount_together['discount'];
			
			$is_discounted = $discount_together['is_discounted'];
			
			$room_discount = 0;
			
			$num_row = $discount > 0 ? 4 : 3; 
			
		?>
		<table cellpadding="0" cellspacing="0" class="tour_accom">
			<thead>
				<tr>
					<th width="77%"><?=lang('room_type')?></th>			
					<th width="23%"><?=lang('hotel_rate') ?></th>
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
									<b><?=lang('hotel_arrival_date') ?></b>
								</td>
							<?php endif;?>
						</tr>	
					
							
							
						<tr id="detail_infor_<?=$value['id']?>" style="display: none;">
							<td>
								
								<?php if(!isset($is_extra_booking)):?>
								<div class="highslide-gallery">
									<a href="<?=$this->config->item('hotel_medium_path').$value['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
										<img style="position: relative; padding: 0 10px 10px 0px; float: left;border:0" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>"></img>
									</a>
										
									<div class="highslide-caption">
										<center><b><?=$value['name']?></b></center>
									</div>					
								</div>
								<?php else:?>	
									<img style="position: relative; padding: 0 10px 10px 0px; float: left;" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>"></img>											
								<?php endif;?>	
									
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
		
		<?php if(!isset($is_extra_booking)):?>
			
			<?php if(count($recommendations) > 0):?>
			
			<div class="saving_tips highlight">
				<span class="icon deal_icon"></span>
				<span class="tip_text"><?=lang('extra_saving')?>:</span>
				<span><?=get_recommendation_text($recommendations)?>&nbsp;</span>
				<a href="javascript:void(0)" class="tip_text" style="text-decoration:underline;" onclick="go_book_together_position()"><?=lang('see_deals')?> &raquo;</a>		
			</div>
			
			<?php endif;?>
			
		<?php endif;?>
		
		</form>		
	</div>