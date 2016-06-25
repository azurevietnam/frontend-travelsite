<div class="row room-types">
	<div class="col-xs-12">
	
	<h2 class="bpv-color-title">
		<?=lang('room_type')?>
	</h2>
		
	<?php foreach ($hotel_room_types as $key=>$room_type):?>
		<?php $more_css = ($key > ($room_type_limit - 1)) ? ' more-rooms' : '';?>
    	    <?php $more_style = ($key > ($room_type_limit - 1)) ? ' style="display:none"' : '';?>
    	    
    	    <div class="bpv-panel<?=$more_css?>"<?=$more_style?>>
            	<div class="panel-heading">
            	  	<div class="panel-title bpv-toggle" data-target="#acc_<?=$room_type['id']?>">
	            	   	<div class="row">
		                	<div class="col-xs-10">
		                		<h3 class="bpv-color-title"><?=$room_type['name']?></h3>
		                		<span class="notes"><?=get_room_type_square_m2($room_type)?>, <?=lang_arg('occupancy_allow', $room_type['max_occupancy'])?></span>
		                    </div>
		                    	<div class="col-xs-2 pd-left-0 text-right">
		                   	 	<i class="bpv-toggle-icon icon icon-chevron-down"></i>
		                    </div>
	                   	</div>
            	  	</div>
				
					<div id="acc_<?=$room_type['id']?>" class="bpv-toggle-content margin-top-10">
						<?php if(!empty($room_type['picture'])):?>
							<img class="img-responsive" alt="" src="<?=get_image_path(HOTEL, $room_type['picture'],'416x312')?>">
	      				<?php endif;?>
		      			
		      			<p class="room-breakfast margin-top-20 margin-bottom-10">
							<b>* <?=get_breakfast_vat_txt($room_type)?></b>
						</p>
						
						<?php if($room_type['max_children'] > 0):?>
							<p>
								 * <?=lang_arg('room_children_allow', $room_type['max_children'])?>
							</p>
						<?php endif;?>
						
						<?php if($room_type['max_extra_beds'] > 0):?>
							<p>
								 * <?=lang_arg('room_extra_bed_allow', $room_type['max_extra_beds'])?>
							</p>
						<?php endif;?>
						
						
						<p>
							<?=$room_type['description']?>
						</p>
						
						<div class="row">
							<div class="col-xs-8 col-xs-offset-2">
								<button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#room_detail_<?=$room_type['id']?>">
									<?=lang('view_room_detail')?>
								</button>
							</div>
						</div>
					
					</div>
					<?=get_room_detail($hotel, $room_type)?>
				</div>
			<div class="panel-body text-center bpv-color-warning"> <?=lang('check_rate_title')?>
           		<span class="glyphicon glyphicon-arrow-up"></span>
            </div>
		</div>
				
	<?php endforeach;?>
	<?php if(count($hotel_room_types) > $room_type_limit):?>
    		
    	<div class="view-mores">
    		<span>
    			<a id="show_more_rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()"><?=lang('view_more_room_types')?></a>
    		</span>
    	</div>
    
    <?php endif?>
	</div>
</div>

<script>
	$('.bpv-toggle').bpvToggle();
</script>