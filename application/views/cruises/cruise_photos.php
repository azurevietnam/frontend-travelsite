<div class="highslide-gallery">

<?php 
	$img_url = $this->config->item('cruise_medium_path');
	
	if ($cruise['img_status'] == 1){
		$img_url = $this->config->item('cruise_800_600_path');
	}
?>

<?php $cnt = 0;?>

<?php /*?>

<?php foreach ($cabins as $key =>$value) :?>
      	<?php 
			$margin_right = ($cnt + 1)%3 == 0 ? '0px' : '18px';
		?>
		<div class="cruise-photo" style="margin-right:<?=$margin_right?>;">
			
			<a rel="nofollow" href="<?=$img_url.$value['picture']?>" class="highslide" onclick="return hs.expand(this);">
				<img style="border:0" id="cruise_photos_<?=$cnt?>" alt="<?=$value['name']?>" src="<?=$this->config->item('cruise_220_165_path').$value['picture']?>">
			</a>
			
			<div class="highslide-caption">
				<center><b><?=$value['name']?></b></center>
			</div>

			<div class="clearfix"></div>
			<center><b><?=$value['name']?></b></center><br/>			
			
		</div>
		
		<?php $cnt++;?>

		
		<?php foreach($value['photos'] as $k=>$photo):?>
            <?php 
				$margin_right = ($cnt + 1)%3 == 0 ? '0px' : '18px';
			?>
			<div class="cruise-photo" style="margin-right:<?=$margin_right?>;">
			
				<a rel="nofollow" href="<?=$img_url.$photo['name']?>" class="highslide" onclick="return hs.expand(this);">				
					<img style="border:0" id="cruise_photos_<?=$cnt?>" alt="<?=$value['name']?>" src="<?=$this->config->item('cruise_220_165_path').$photo['name']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['name']?></b></center>
				</div>
			
				<div class="clearfix"></div>
				<center><b><?=$value['name']?></b></center><br/>				
			</div>
			
			<?php $cnt++;?>
			
		<?php endforeach;?>
<?php endforeach;?>

<?php */?>

<?php foreach ($photos as $key =>$value) :?>
    <?php 
		$margin_right = ($cnt + 1)%3 == 0 ? '0px' : '18px';
	?>
	<div class="cruise-photo" style="margin-right:<?=$margin_right?>;">

		<a rel="nofollow" href="<?=$img_url.$value['name']?>" class="highslide" onclick="return hs.expand(this);">

			<img style="border:0" id="cruise_photos_<?=$cnt?>" alt="<?=$value['description']?>" src="<?=$this->config->item('cruise_220_165_path').$value['name']?>">

		</a>

		<div class="highslide-caption">
			<center><b><?=$value['description']?></b></center>
		</div>

		<div class="clearfix"></div>
		<center><b><?=$value['description']?></b></center>
		<br/>

	</div>
	<?php $cnt++;?>
<?php endforeach;?>

</div>
