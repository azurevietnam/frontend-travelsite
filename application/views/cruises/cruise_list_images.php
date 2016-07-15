
<?php 
	$img_url = $this->config->item('cruise_medium_path');
	
	if ($cruise['img_status'] == 1){
		$img_url = $this->config->item('cruise_800_600_path');
	}
?>

<?php $count = 1;?>

<?php foreach ($cabins as $key =>$value) :?>
	<?php if($count <= 9):?>
		<a rel="nofollow" href="<?=$img_url.$value['picture']?>" class="highslide" onclick="return hs.expand(this);">
			<img alt="<?=$value['name']?>" class="list_image_item" id="img_cabin_<?=$key?>" width="80" height="60" src="<?=$this->config->item('cruise_80_60_path').$value['picture']?>">
		</a>
		
		<div class="highslide-caption">
			<center><b><?=$value['name']?></b></center>
		</div>
			
	<?php endif;?>
	<?php $count++;?> 
<?php endforeach;?>

<?php foreach ($photos as $key =>$value) :?>
	<?php if($count <= 9):?>
		<a rel="nofollow" href="<?=$img_url.$value['name']?>" class="highslide" onclick="return hs.expand(this);">
		<img alt="<?=$value['description']?>" class="list_image_item" id="img_<?=$key?>" width="80" height="60" src="<?=$this->config->item('cruise_80_60_path').$value['name']?>">
		</a>
		<div class="highslide-caption">
			<center><b><?=$value['description']?></b></center>
		</div>
	<?php endif;?>
	<?php $count++;?>
<?php endforeach;?>
