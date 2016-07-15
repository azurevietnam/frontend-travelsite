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

<form id="frm_hotel_book_it_<?=$hotel['id']?>" name="frm_hotel_book_it" method="get" action="<?=get_page_url(HOTEL_BOOK_IT_PAGE, $hotel)?>">

	<?php foreach ($room_types as $key => $value):?>
		<div class="bpv-panel">
            <div class="panel-heading">
                <div class="panel-title bpv-toggle" data-target="#room_<?=$value['id']?>">
                    <div class="row">
                        <div class="col-xs-10">
                            <h3 class="bpv-color-title"><?=$value['name']?></h3>
                            <?=lang('lbl_m2', $value['room_size'])?>, <?=$value['bed_size']?>
                        </div>
                        <div class="col-xs-2 padding-left-0 text-right">
                            <span class="bpv-toggle-icon icon icon-chevron-down"></span>
                        </div>
                    </div>
                </div>
                <div id="room_<?=$value['id']?>" class="bpv-toggle-content margin-top-10">
                    <?php if(!empty($value['picture'])):?>
                        <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $value['picture'], '468_351')?>">
                    <?php endif;?>
                    <div class="margin-top-10">
                        <?=$value['description']?>
                    </div>

                    <button type="button" class="btn btn-default center-block margin-top-5" data-toggle="modal" data-target="#room_info_<?=$value['id']?>">
                        <?=lang('field_room_info')?> <span class="icon icon-chevron-right"></span>
                    </button>
                    <?=$value['room_info']?>
                </div>
            </div>
            <div class="panel-body rate-tables">
           
           	   <?php if(!empty($value['special_offers'])):?>
           	   		<div class="row">
           	   			<div class="col-xs-12 no-padding">
           	   				<?=$value['special_offers']?>
           	   			</div>
           	   		</div>
           	   <?php endif;?>
            
               <div class="row">
               		<div class="col-xs-6 no-padding">
               			<?=lang('lbl_room_rate')?>
               		</div>
               		<div class="col-xs-6 padding-right-0 text-right">
               			<?php if($value['price']['promotion_price'] > 0):?>
							<?php if(($value['price']['promotion_price'] != $value['price']['price'])):?>
		            			<span class="price-origin"><?=show_usd_price($value['price']['price'])?></span>
	            			<?php endif;?>
	
	            				<span class="price-from-check-rate price-from text-right"><?=show_usd_price($value['price']['promotion_price'])?></span>
	
					    <?php else :?>
							<span class="price_total text-right" style="font-weight:normal;"><?=lang('na')?></span>
						<?php endif;?>
               		</div>
               </div>
               
               <?php if ($discount > 0):?>
	               <div class="row">
	               		<div class="col-xs-6 no-padding">
	               			<?=lang('discount')?>
	               		</div>
	               		<div class="col-xs-6 padding-right-0 text-right">
	               			<span class="price-from-check-rate price-from">-<?=show_usd_price($discount)?></span>/r.
	               		</div>
	               </div>
	               
	               <?php 
						$room_discount = $discount;
					?>
					
               <?php endif;?>
               
               <div class="row">
               		<div class="col-xs-6 no-padding">
               			<?=lang('lbl_nr_room')?>
               		</div>
               		<div class="col-xs-6 padding-right-0 text-right">
               			<select name="nr_room_type_<?=$value['id']?>" id="nr_room_type_<?=$value['id']?>"
							class="price-from-check-rate price-from room_select_<?=$hotel['id']?>"
							data-name="<?=$value['name']?>" data-id="<?=$value['id']?>" data-rate="<?=$value['price']['promotion_price']?>"
							onchange="select_hotel_room(this, <?=$value['id']?>)"
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
               		
               		</div>
               </div>
               
               <?php if($value['extra_bed_allow'] == 1):?>
               <div class="row r-hide-<?=$value['id']?>" style="display:none">
               		<div class="col-xs-6 no-padding">
               			<?=lang('extra_bed')?>
               		</div>
               		<div class="col-xs-6 padding-right-0 text-right">
               			<select name="nr_extra_bed_<?=$value['id']?>" id="nr_extra_bed_<?=$value['id']?>" data-rate="<?=$value['price']['extra_bed_price']?>">
							<option value="0">0</option>
							<?php for ($index = 1; $index <= $max_room; $index++):?>

								<option value="<?=$index?>"><?=$index . " (" . show_usd_price($index * $value['price']['extra_bed_price'], true). ")"?></option>

							<?php endfor ;?>
						</select>
               		</div>
               </div>
               <?php endif;?>
               
                <div class="row r-hide-<?=$value['id']?>" style="display:none">
                	<div class="col-xs-offset-6 col-xs-6">
		               	<button type="submit" class="btn btn-blue">
			          		<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_now')?>
			          	</button>
		          	</div>
               	</div>
            </div>
        </div>
	<?php endforeach;?>        

<?php if(!empty($get_params)):?>
	<?php foreach ($get_params as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>">
	<?php endforeach;?>
<?php endif;?>

</form>

<script type="text/javascript">
	function select_hotel_room(obj, room_id){
		var nr_room = $(obj).val();
		if(nr_room == 0){
			$('.r-hide-' + room_id).hide();
		} else {
			$('.r-hide-' + room_id).show();
		}
	}	
	//set_popover('.pro-offer-note');
	//$('.bpv-toggle').bpvToggle();

	$('.bpv-toggle').bpvToggle(function(){
		var icon = $( '.bpv-toggle-icon', $( this ));
		if( $(icon).hasClass ('icon-chevron-down') ) {
			$(icon).toggleClass ('icon-chevron-up');
		}
	});
</script>