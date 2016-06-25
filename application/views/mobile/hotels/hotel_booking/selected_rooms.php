<h2 class="bpv-color-title"><?=lang('hb_room_selecteds')?></h2>
<?php foreach ($selected_room_rates as $value):?>
	<?php 
		$room_rate = $value['room_rate_info'];
	?>
	
	<input type="hidden" name="nr_room_<?=get_room_rate_id($room_rate)?>" value="<?=$value['nr_room']?>">
	
<?php endforeach;?>

<?php $room_index = 0;?>
<?php foreach ($selected_room_rates as $value):?>
	
	<?php for ($i = 0; $i < $value['nr_room']; $i++):?>
		<?php 
			$room_index++;
			
			$room_rate = $value['room_rate_info'];
			
			$occupancy = $room_rate['occupancy'];
			
			$basic_rate = $room_rate['basic_rate'][$occupancy];
			
			$sell_rate = $value['sell_rate'];
			
			$total_rate_origin = count_total_room_rate($basic_rate);
			
			$total_rate = count_total_room_rate($sell_rate);
		?>
		<div class="bpv-panel">
			<div class="panel-heading">
			
				<div class="panel-title bpv-toggle" data-target="#acc_<?=get_room_rate_id($room_rate)?>_<?=$room_index?>">
					<div class="row">
						<div class="col-xs-10">
	        	           <h3><span class="bpv-color-title"><?=lang('hb_room')?> <?=$room_index?> : </span><span> <?=get_room_rate_name($room_rate)?></span></h3>
	        	         	</br>
	        	           <span class="room-square"><?=get_room_type_square_m2($room_rate)?>, <?=lang_arg('occupancy_allow', $room_rate['occupancy'])?></span>
	                    </div>
	                    <div class="col-xs-2 pd-left-0 text-right">
	                        <i class="bpv-toggle-icon icon icon-chevron-down"></i>
	                    </div>
					
					

					</div>
				</div>
				
				<div id="acc_<?=get_room_rate_id($room_rate)?>_<?=$room_index?>" class="bpv-toggle-content margin-top-10">
							
					<img class="img-responsive" alt="" src="<?=get_image_path(HOTEL, $room_rate['picture'],'416x312')?>">
   			
	      			<p class="room-breakfast margin-top-20">
						<b>* <?=get_breakfast_vat_txt($room_rate)?></b>
					</p>
					
					<p>* <?=lang('hb_max_stay')?>: <b><?=get_room_type_max_person($room_rate, false)?></b></p>
					
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
							<button1 class="btn btn-default center-block" data-toggle="modal"
													data-target="#room_detail_<?=get_room_rate_id($room_rate)?>">
								<?=lang('m_view_room_detail')?>
							</button1>
						</div>
					</div>
					
					
				
				</div>
				<?=get_room_rate_detail($hotel, $room_rate, $sell_rate)?>
						
			</div>
			
			<div style="padding:10px">
				<?php if($room_rate['max_extra_beds'] > 0):?>
				
				<div class="row" style="padding-bottom:10px; border-bottom: 1px dashed #ccc;">
					<div class="col-xs-6 ">
						<?=lang('hb_col_extra_bed')?>
					</div>
					<div class="col-xs-6 text-right">
						
						<?php 
							$extrabed_rate = count_total_room_rate($room_rate['extrabed_rate']);
						?>
					
						<select class="form-control input-sm extrabed pull-right" name="<?=$room_index?>_extra_bed_<?=get_room_rate_id($room_rate)?>" room-index="<?=$room_index?>" extrabed-rate="<?=$extrabed_rate?>" 
							onchange="select_extra_bed('<?=lang('vnd')?>')">
							<?php for ($j=0;$j <= $room_rate['max_extra_beds']; $j++):?>
								<option value="<?=$j?>">
									<?=$j?>
								</option>
							<?php endfor;?>
						</select>			
					
					</div>
				</div>
				
				<?php endif;?>
				
				<div class="row margin-top-10">
					<div class="col-xs-5">
						<?=str_replace('<night>', $check_rate_info['night'], lang('hb_col_price'))?>
					</div>
					<div class="col-xs-7 text-right">
						
						<?php if($total_rate_origin != $total_rate):?>
							<span class="bpv-price-origin" id="rate_origin_<?=$room_index?>" rate="<?=$total_rate_origin?>">
								<?=bpv_format_currency($total_rate_origin)?>
							</span>
						<?php endif;?>
						
						<span class="bpv-price-from" id="rate_sell_<?=$room_index?>" rate="<?=$total_rate?>">
							<?=bpv_format_currency($total_rate)?>
						</span>
						
					</div>
				</div>
				
				
			</div>
		</div>
	<?php endfor;?>
	
<?php endforeach;?>


<script type="text/javascript">

$(function() {
	update_hotel_total_payment('<?=lang('vnd')?>');
});
</script>