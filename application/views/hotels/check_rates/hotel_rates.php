<?php 
	$discount = $discount_together['discount'];
	
	$is_discounted = $discount_together['is_discounted'];
	
	$room_discount = 0;
	
	$num_col = $discount > 0 ? 4 : 3; 

?>
		
<?php if(!empty($popup_free_visa)):?>
	<div>
		<?=$popup_free_visa?>
	</div>	
<?php endif;?>

<?php if(!$is_book_together):?>
	<form id="frm_hotel_book_it_<?=$hotel['id']?>" name="frm_hotel_book_it" method="get" action="<?=get_page_url(HOTEL_BOOK_IT_PAGE, $hotel)?>">
<?php endif;?>

<?php if(!empty($parent_id)):?>
	<input name="parent_id" value="<?=$parent_id?>" type="hidden">
<?php endif;?>

<div class="alert alert-warning" role="alert" id="booking_warning_<?=$hotel['id']?>" style="display:none">
	<span class="glyphicon glyphicon-warning-sign"></span> <label><?=lang('msg_select_room')?></label>
</div>
	
<table class="table bpt-table table-bordered">
      <thead>
        <tr class="bgr-header-table">
          <th><?=lang('lbl_room_types')?></th>
          <th class="text-center" width="14%"><?=lang('lbl_room_rate')?></th>
			<?php if ($discount > 0):?>
				<th class="text-center" width="13%"><?=lang('discount')?></th>
			<?php endif;?>
			<th class="text-center" width="20%"><?=!$is_book_together ? lang('lbl_nr_room') : lang('label_select_rooms')?></th>
			
			<?php if(!$is_book_together):?>				
				<th width="20%"><?=lang('lbl_book_reservation')?></th>
			<?php endif;?>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($room_types as $key => $value):?>
      		 <tr>
      		 	<td>
      		 		<?php if(!empty($value['picture']) && !$is_book_together):?>
      		 			<img class="img-check-rate" width="100" height="75" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $value['picture'], '120_90')?>">
      		 		<?php endif;?>	
      		 		<a class="vertical-align-top" href="javascript:void()" data-toggle="modal" data-target="#room_info_<?=$value['id']?>">
      		 			<span class="glyphicon glyphicon-triangle-right text-special vertical-align-top"></span><?=$value['name']?>
      		 		</a>
      		 		<?=$value['special_offers']?>
      		 	</td>
      		 	<td class="text-right">
      		 		<?php if($value['price']['promotion_price'] > 0):?>
						<?php if(($value['price']['promotion_price'] != $value['price']['price'])):?>
	            			<span class="price-origin"><?=show_usd_price($value['price']['price'])?></span>
            			<?php endif;?>
            							            							
            				<span class="price-from-check-rate price-from text-right"><?=show_usd_price($value['price']['promotion_price'])?></span>        
            						
				    <?php else :?>
						<span class="price_total text-right" style="font-weight:normal;"><?=lang('na')?></span>
					<?php endif;?>
								
	            </td>
	            
	            <?php if ($discount > 0):?>
	            	<th class="text-right">
						<span class="price-from-check-rate price-from">-<?=show_usd_price($discount)?></span><?php if($is_discounted):?>/r.<?php endif;?>
					</th>
					<?php 
						$room_discount = $discount;
					?>
	            <?php endif;?>
	            
	            <td align="right">
					<select name="nr_room_type_<?=$value['id']?>" id="nr_room_type_<?=$value['id']?>" 
						class="price-from-check-rate price-from room_select_<?=$hotel['id']?>" 
						data-name="<?=$value['name']?>" data-id="<?=$value['id']?>" data-rate="<?=$value['price']['promotion_price']?>"
						<?php if($is_book_together):?>onchange="select_rooms(<?=$hotel['id']?>)"<?php endif;?>
						>
						<option value="0">0</option>				
						<?php for ($index = 1; $index <= $max_room; $index++):?>										
														
							<option value="<?=$index?>">
								<?php if($value['price']['promotion_price'] > 0):?>
									
									<?=$index . " (" . show_usd_price($index * ($value['price']['promotion_price'] - $room_discount), true). ")"?>
									
								<?php else:?>
									<?=$index . " (" . lang('na') . ")"?>
								<?php endif;?>
							</option>
						
						<?php endfor ;?>				
					</select>
					<?php if($value['extra_bed_allow'] == 1):?>
						
						<div class="margin-top-5">
							<a href="javascript:void(0)" class="room-extra-bed" data-target="#nr_extra_bed_<?=$value['id']?>" data-icon="#icon_extra_bed_<?=$value['id']?>" data-show="hide">
								<span class="glyphicon glyphicon-triangle-right text-special" id="icon_extra_bed_<?=$value['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span> <?=lang('lbl_extra_bed')?> 
							</a>									
						</div>
						
						<div id="extra_bed_<?=$value['id']?>_select">
							<select name="nr_extra_bed_<?=$value['id']?>" id="nr_extra_bed_<?=$value['id']?>" style="display:none" data-rate="<?=$value['price']['extra_bed_price']?>">
								<option value="0">0</option>				
								<?php for ($index = 1; $index <= $max_room; $index++):?>										
																
									<option value="<?=$index?>"><?=$index . " (" . show_usd_price($index * $value['price']['extra_bed_price'], true). ")"?></option>
								
								<?php endfor ;?>				
							</select>
						</div>
									
					<?php endif;?>					
				</td>
				
				<!-- For Normal Hotel Booking  -->	
				<?php if(!$is_book_together):?>		
		            <?php if ($key == 0):?>
						<td rowspan="<?=(count($room_types))?>" style="vertical-align: middle;" align="center">
							
							<?php if($is_ajax):?>
				          		<?php 
				          			$form_id = '#frm_hotel_book_it_'.$hotel['id'];
				          			$area_id = '#hotel_'.$hotel['id'];
				          		?>
				          		<button type="submit" class="btn btn-blue" onclick="return book_it('<?=$form_id?>', '<?=$area_id?>', 'hotel', this, '<?=$hotel['id']?>')">
					          		<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_now')?>
					          	</button>
				          	<?php else:?>
					          	<button type="submit" class="btn btn-blue" onclick="return validate_hotel_room_selection(<?=$hotel['id']?>)">
					          		<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_now')?>
					          	</button>
				          	<?php endif;?>		
						</td>
					<?php endif;?>
				<?php endif;?>
	        </tr>
      	<?php endforeach;?>
      </tbody>
</table>


<?php if(!empty($get_params)):?>
	<?php foreach ($get_params as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>">
	<?php endforeach;?>
<?php endif;?>

<?php if(!$is_book_together):?>
</form>
<?php endif;?>

<?php foreach ($room_types as $key => $value):?>
	<?=$value['room_info']?>
<?php endforeach;?>

<script type="text/javascript">

	set_popover('.pro-offer-note');

	set_show_hide('.room-extra-bed');

</script>