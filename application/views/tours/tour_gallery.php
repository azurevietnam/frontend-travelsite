<div class="highslide-gallery">

<?php foreach ($gallery_photos as $key=>$photo):?>
		
		<?php 
			$margin_right = ($key + 1)%3 == 0 ? '0px' : '18px';
		?>

		<div style="float: left; margin-right:<?=$margin_right?>; width: 220px; height: 190px">
			
			<a rel="nofollow" href="<?=$photo['medium_path'].$photo['name']?>" class="highslide" onclick="return hs.expand(this);">
				<img style="border:0" alt="<?=$photo['caption']?>" src="<?=$photo['220_165_path'].$photo['name']?>">
			</a>
			
			<div class="highslide-caption">
				<center><b><?=$photo['caption']?></b></center>
			</div>

			<div class="clearfix"></div>
			<center><b><?=$photo['caption']?></b></center><br/>			
			
		</div>
		
<?php endforeach;?>


</div>
