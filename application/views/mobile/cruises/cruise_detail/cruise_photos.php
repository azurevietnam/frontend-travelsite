<div class="hotel-photos">
	<h2 class="bpv-color-title"><?=lang('cruise_photo_title'). $cruise['name']?></h2>
	
	<?php 
		$arr_photos = array_chunk($cruise_photos, 3);
	?>
	
	<?php foreach ($arr_photos as $key=>$row_cruise_photos):?>
	
		<div class="row margin-bottom-10<?php if($key > 1):?> more-photos<?php endif?>" <?php if($key > 1):?> style="display:none"<?php endif;?>>
			<?php foreach ($row_cruise_photos as $photo):?>
				<div class="col-xs-4">
						
					<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
				        <img class="img-responsive" src="<?=get_image_path(CRUISE, $photo['name'],'268x201')?>" alt="<?=$photo['caption']?>">
				    </a>
		    		
					<div class="img-caption"><?=$photo['caption']?></div>
				</div>
			<?php endforeach;?>
		</div>
	
	<?php endforeach;?>

	<?php if(count($arr_photos) > 2):?>
	<div>
		<a class="view-more" id="show_more_photos" href="javascript:void(0)" onclick="show_more_photos()" show="hide"><?=lang('view_more_cruise_photos')?></a>
	</div>
	<?php endif;?>
</div>
