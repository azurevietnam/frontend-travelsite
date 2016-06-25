<div class="row room-rates">

	<div class="col-xs-12">
	
	<h2 class="bpv-color-title">
		<?=lang('room_type')?>
	</h2>

	<form id="room-rates" role="form" method="post"
		action="<?=hotel_booking_url($hotel, $search_criteria)?>">

		<input type="hidden" name="action" value="<?=ACTION_BOOK_NOW?>">
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
						$is_hide = $row_index > $room_type_limit;
					?>
					
				<div class="bpv-panel <?php if($is_hide):?>more-rooms<?php endif?>" <?php if($is_hide):?>style="display:none;"<?php endif?>>
					
					<div class="panel-heading">
		        	   <div class="panel-title bpv-toggle" data-target="#room_<?=get_room_rate_id($room_rate)?>">
		        	        <div class="row">
		            	        <div class="col-xs-10">
		            	           <h3 class="bpv-color-title"><?=get_room_rate_name($room_rate)?></h3>
		            	           <span class="notes">
		            	           		<?=get_room_type_square_m2($room_rate)?>, 
		            	           		<?=lang_arg('occupancy_allow', $room_rate['occupancy'])?>
		            	           		<?php $is_no_cancell = $room_rate['cancellation']['id'] == CANCELLATION_NO_REFUND; ?>
	                	              	 <?php if($is_no_cancell):?>
	                	               	<br><span class="bpv-color-warning"><?=lang('no_cancel')?></span>
	                	               	<?php endif;?>
		            	           		
		            	           </span>
		                        </div>
		                        <div class="col-xs-2 pd-left-0 text-right">
		                        	<i class="bpv-toggle-icon icon icon-chevron-down"></i>
		                        </div>
		                    </div>
		        	   </div>
						
						<div id="room_<?=get_room_rate_id($room_rate)?>" class="bpv-toggle-content margin-top-10">
							
							<img class="img-responsive" alt="" src="<?=get_image_path(HOTEL, $room_rate['picture'],'416x312')?>">
		      			
			      			<p class="room-breakfast margin-top-20 margin-bottom-10">
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
							
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2">
									<button type="button" class="btn btn-default center-block" data-toggle="modal" 
										data-target="#room_detail_<?=get_room_rate_id($room_rate)?>">
										<?=lang('m_view_room_detail')?>
									</button>
								</div>
							</div>
							<?=get_room_rate_detail($hotel, $room_rate, $rate)?>
						
						</div>
					</div>
				
					<div class="panel-body">
						
						<?php if(isset($room_rate['promotion']) && $room_rate['promotion']['show_on_web']):?>
						<div class="room-promotion margin-bottom-10">
							<?=load_promotion_tooltip($room_rate['promotion'], get_room_rate_id($room_rate), '', true)?>
						</div>
						<div class="sep-line"></div>
						<?php endif;?>
						
						<?php if($room_rate['has_basic_price']):?>
					
						
						<div class="row">
							<div class="col-xs-6">
								<?=lang('room_price_per_night')?>:
							</div>
							
							<div class="col-xs-6 text-right">
								
								<?php 
									$average_rate_origin = count_average_room_rate($basic_rates[$occupancy]);
									$average_rate_sell =  count_average_room_rate($rate);
								?>
								<?php if($average_rate_origin != $average_rate_sell):?>
									<span class="bpv-price-origin"><?=bpv_format_currency($average_rate_origin)?></span>
								<?php endif;?>
								
								<span class="bpv-price-from"><?=bpv_format_currency($average_rate_sell)?></span>
								
							</div>
						</div>
						
						<div class="sep-line"></div>
						
						<div class="row">
							<div class="col-xs-6">
								<?=lang('number_rooms')?>:
							</div>
							
							<div class="col-xs-6">
								
								<select
									onchange="select_rooms('<?=lang('vnd')?>')"
									class="form-control num_room"
									name="nr_room_<?=get_room_rate_id($room_rate)?>"
									room-rate-id="<?=get_room_rate_id($room_rate)?>"
									rate-origin="<?=count_total_room_rate($basic_rates[$occupancy])?>"
									rate-sell="<?=count_total_room_rate($rate)?>">
									
								 	<?php for($i = 0; $i <= $max_rooms; $i++):?>
								 		<option value="<?=$i?>"><?=$i?></option>
								 	<?php endfor;?>
								</select>
								
							</div>
						
						</div>
						
						
						<div class="text-right bpv-color-warning margin-top-10" id="select_room_to_book_<?=get_room_rate_id($room_rate)?>">
							<?=lang('select_room_to_book')?>
						</div>
						
						<div id="total_room_info_<?=get_room_rate_id($room_rate)?>" style="display:none">
							<div class="sep-line"></div>
							
							<div class="row margin-bottom-10">
								<div class="col-xs-6" id="total_room_label_<?=get_room_rate_id($room_rate)?>" style="font-weight:bold">
									
								</div>
								<div class="col-xs-6 text-right" id="total_room_price_<?=get_room_rate_id($room_rate)?>">
									
								</div>
							</div>
						
							<div class="row">
								<div class="col-xs-6 col-xs-offset-6">
									
									<button type="submit" 
										onclick="return book_hotel_now('<?=lang('please_select_room')?>')"
										class="btn btn-bpv btn-book-now btn-block"><?=lang('btn_book_now')?></button>
								
								</div>
							</div>
						
						</div>
					
					<?php else:?>
						<?php 
								$params = array('type'=>'hotel','des'=>$hotel['destination_name'],'hotel'=>$hotel['name'],'room' => $room_rate['name'],'startdate'=>$check_rate_info['startdate'],'night'=>$check_rate_info['night']);
							?>
							
							<div class="row">
								<div class="col-xs-8 col-xs-offset-2">
									<a type="button" class="btn btn-bpv btn-book-now btn-block" 
										href="<?=get_url(CONTACT_US_PAGE, $params)?>">
										<?=lang('contact_for_price')?>
									</a>
								</div>
							</div>
					<?php endif;?>

					</div>
					
				</div>

				<?php endforeach;?>
				
			<?php endforeach;?>
		
		
		<?php if($rate_rows > $room_type_limit):?>
			<div class="margin-top-15 margin-bottom-15 text-center">
				 <a type="button" class="btn btn-default" id="show_more_rooms" href="javascript:void(0)" show="hide"
						onclick="show_more_rooms()"><?=lang('view_more_room_types')?></a>
			</div>
		<?php endif?>
		<!-- 
		<div style="display: none">

			<div class="margin-bottom-5 label-total-price"
				id="total_rate_label" style="display: none"><?=lang('total_price')?></div>

			<div class="bpv-price-origin" id="total_rate_origin"
				style="display: none"></div>
			<div class="bpv-price-from margin-bottom-10" id="total_rate_sell"
				style="display: none"></div>
				
			<button type="submit"
					onclick="return book_hotel_now('<?=lang('please_select_room')?>')"
					class="btn btn-bpv btn-book-now btn-block"><?=lang('btn_book_now')?></button>
			
		</div>
		 -->

	</form>
	
	</div>
</div>
<script>
$('.bpv-toggle').bpvToggle();
</script>