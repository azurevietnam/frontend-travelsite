<?php if(!empty($advertises)):?>
<h2 class="bpt-color-title text-highlight margin-top-20"><?=lang('top_promotions')?></h2>
<div class="row">			
	<?php for($i=0; $i < 3; $i++):?>
		<?php if(isset($advertises[$i])):?>
			<div>
				<a href="<?=$advertises[$i]['link']?>">
				<?php foreach ($advertises[$i]['photos'] as $photo): ?>				
					<img class="col-xs-4" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ADVERTISE, $photo['name'])?>">
				<?php endforeach;?>
				</a>
			</div>
		<?php endif;?>
	<?php endfor;?>
</div>
<?php endif;?>
