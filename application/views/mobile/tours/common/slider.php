<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($photos as $k => $photo):?>
		<li>
	        <img class="img-responsive" src="<?=get_image_path($page, $photo['name'],'400x300')?>" alt="<?=$photo['caption']?>">
			
			<div class="flex-caption">
			     <?php if($k == 0 && $page == TOUR):?>
    			    <h1 class="no-margin">
    			    <?=$tour['name']?>
    			    </h1>
    			 <?php else:?>
                    <?=$photo['caption']?>		     
    			 <?php endif;?>	
			</div>
	 	</li>
	 	<?php endforeach;?>
	</ul>
</div>