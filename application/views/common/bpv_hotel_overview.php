<?php if(isset($hotel)):?>
	
	<div class="photos">
		<?=load_slider($photos, HOTEL)?>
	</div>
	<div class="hotel_popup">
		<h3><span class="icon icon-destination"></span><?=$hotel['name']?></h3>
		<span class="pull-right pd-right-10"> <?=show_review($hotel, hotel_build_url($hotel))?></span>
	</div>
	<div class="hotel_popup_text">
		<?=$hotel['description'];?>
	</div>
	<div class="hotel_popup_room">
		<h3><?=lang('room_style')?>:</h3>
		<div class="hotel_popup_room_box">
			<?php foreach($hotel_room_types as $key=>$room_type):?>
				<div class="col-xs-4">
					<?php if(!empty($room_type['picture'])):?>
						<img src="<?=get_image_path(HOTEL, $room_type['picture'],'120x90')?>" alt="<?=$room_type['name']?>" width="100%" />
						<?php $info_arr = explode(",", get_room_type_square_m2($room_type));?>
						<p class="text-center bpv-color-hightlight margin-top-20 margin-bottom-10"><b><?php if(isset($info_arr[0])){echo character_limiter($info_arr[0], 28);}?></b></p>
						<p class="text-center margin-bottom-10"><?php if(isset($info_arr[1])){ echo character_limiter($info_arr[1], 28); }?></p>
					<?php else:?>
						&nbsp;
					<?php endif;?>
				</div>
			<?php endforeach;?>
		</div>
		
		<div class="margin-top-20">
			<a target="_blank" href="<?=get_url(HOTEL_DETAIL_PAGE, $hotel);?>" class="btn btn-primary btn-lg btn-bpv btn-view-detail pull-right" role="button" style="margin-right:35px"><span class="icon icon-btn-arrow-blue"></span><?=lang('view_details')?></a>
		</div>
	</div>
	
<?php else:?>
	<center><?=lang('no_data_found')?></center>
<?php endif;?>
