<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($hotel_photos as $k => $photo):?>
		<li>
			
			<img class="img-responsive" src="<?=get_image_path(HOTEL, $photo['name'],'268x201')?>" alt="<?=$photo['caption']?>">
			
			<div class="flex-caption">
			<?php if($k == 0):?>
				<h1 class="no-margin">
			    	<?=$hotel['name']?>
			    	<i class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></i>
			    </h1>
			
			<?php else:?>
                <?=$photo['caption']?>		     
			<?php endif;?>
			</div>
	 	</li>
	 	<?php endforeach;?>
	</ul>
</div>