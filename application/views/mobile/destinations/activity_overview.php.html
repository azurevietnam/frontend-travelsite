<h1 style="padding-left: 0; padding-top: 5px;" class="highlight">
	<?=$activity['name']?>
	
	<?php if($activity['title'] != ''):?>
		<?=' - '.$activity['title']?>
	<?php endif;?>
	
</h1>

<div class="overview_main_img">
	<img id="main_img_<?=$activity['id']?>" width="375" height="250" alt="<?=$activity['name']?>" title="<?=$activity['name']?>" src="<?=$this->config->item('activity_375_250_path') . $activity['picture_name']?>"/>
	
	<div class="img_caption">
		<span id="img_caption_<?=$activity['id']?>">
			<?=$activity['name']?>
			
			<?php if($activity['title'] != ''):?>
				<?=' - '.$activity['title']?>
			<?php endif;?>
	
		</span>
	</div>
	
	<div style="margin-top: 5px;">
	
	<?php 
		$index = 0;
		$img_class = "img_style margin_right_7";
	?>
	
	<div class="<?=$img_class?>">
		
		<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$activity['picture_name']?>" imgcaption="<?=htmlentities($activity['name'])?>"  alt="" src="<?=$this->config->item('activity_80_60_path') . $activity['picture_name']?>">
		<br>
		<center style="font-size:9px"><?=$activity['name']?></center>
	</div>
	<?php 
		$index++;
	?>	
	
	<?php foreach ($activity['photos'] as $key=>$photo):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('activity_375_250_path') . $photo['picture_name']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
		
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$photo['picture_name']?>" imgcaption="<?=htmlentities($photo['comment'])?>"  alt="" src="<?=$this->config->item('activity_80_60_path') . $photo['picture_name']?>">
			<br>
			<center style="font-size:9px"><?=$photo['comment']?></center>
		</div>
		
		<?php 
			$index++;
		?>
		
	<?php endforeach;?>
	
	
	</div>
	
	<?php if($index > 4):?>
		<div class="show_more"><a style="margin-right: 10px;" href="javascript:void(0)" onclick="show_hide_img(this)" class="function" stat="hide"><?=lang('label_show_more')?> &raquo;</a></div>
	<?php endif;?>
</div>

<?php if(!empty($activity['destination_name'])):?>
<div class="overview_row">
	<u><?=lang('destination')?>:</u>
	<b><a href="javascript:void(0)" onclick="see_destination_overview('','<?=$departure_date?>','<?=url_title($activity['destination_name_en'])?>')"><?=$activity['destination_name']?></a></b>
</div>
<?php endif;?>

<div class="overview_row">
	<?=str_replace("\n", "<p/>", $activity['description'])?>
</div>				

<script type="text/javascript">

function update_main_img(img_obj){

	var img_name = $(img_obj).attr('imgname');

	var imgcaption = $(img_obj).attr('imgcaption');

	var act = $(img_obj).attr('act');

	$('#main_img_<?=$activity['id']?>').attr("src",'<?=$this->config->item('activity_375_250_path')?>' + img_name);

	if (imgcaption != ''){
	
		$('#img_caption_<?=$activity['id']?>').text(imgcaption);

	} else {

		$('.img_caption').hide();
		
	}
	
}
</script>