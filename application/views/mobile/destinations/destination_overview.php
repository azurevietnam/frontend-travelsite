<h1 style="padding-left: 0; padding-top: 5px;" class="highlight">
	<?=$destination['name']?>
	
	<?php if($destination['title'] != ''):?>
		<?=' - '.$destination['title']?>
	<?php endif;?>
	
</h1>

<div class="overview_main_img">
	<img id="main_img_<?=$destination['id']?>" width="375" height="250" alt="<?=$destination['name']?>" title="<?=$destination['name']?>" src="<?=$this->config->item('des_375_250_path') . $destination['picture_name']?>"/>
	
	<div class="img_caption">
		<span id="img_caption_<?=$destination['id']?>">
			<?=$destination['name']?>
			
			<?php if($destination['title'] != ''):?>
				<?=' - '.$destination['title']?>
			<?php endif;?>
	
		</span>
	</div>
	
	<div style="margin-top: 5px;">
	
	<?php 
		$index = 0;
		$img_class = "img_style margin_right_7";
	?>
	
	<div class="<?=$img_class?>">
		
		<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$destination['picture_name']?>" imgcaption="<?=htmlentities($destination['name'])?>"  alt="" src="<?=$this->config->item('des_80_60_path') . $destination['picture_name']?>">
		<br>
		<center style="font-size:9px"><?=$destination['name']?></center>
	</div>
	<?php 
		$index++;
	?>	
	
	<?php foreach ($destination['photos'] as $key=>$photo):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('des_375_250_path') . $photo['picture_name']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
		
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$photo['picture_name']?>" imgcaption="<?=htmlentities($photo['comment'])?>"  alt="" src="<?=$this->config->item('des_80_60_path') . $photo['picture_name']?>">
			<br>
			<center style="font-size:9px"><?=$photo['comment']?></center>
		</div>
		
		<?php 
			$index++;
		?>
		
	<?php endforeach;?>
	
	<?php foreach ($destination['activities'] as $key=>$activity):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('activity_375_250_path') . $activity['picture_name']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
		
			<img width="80" height="60" onclick="update_main_img(this)" act="yes" imgname="<?=$activity['picture_name']?>" imgcaption="<?=htmlentities($activity['name'])?>"  alt="" src="<?=$this->config->item('activity_80_60_path') . $activity['picture_name']?>">
			<br>
			<center style="font-size:9px"><?=$activity['name']?></center>
		</div>
		
		<?php 
			$index++;
		?>
		
	<?php endforeach;?>
	
	<?php foreach ($destination['attractions'] as $key=>$value):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('des_375_250_path') . $value['picture_name']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
		
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$value['picture_name']?>" imgcaption="<?=htmlentities($value['name'])?>"  alt="" src="<?=$this->config->item('des_80_60_path') . $value['picture_name']?>">
			<br>
			<center style="font-size:9px"><?=$value['name']?></center>
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

<div class="overview_row">
	<h3 class="highlight" style="padding-left:0;padding-top:0"><?=lang('overview_about')?> <?=$destination['name']?></h3>
	<?=str_replace("\n", "<p/>", $destination['general_info'])?>
	
	<?php if(count($destination['activities']) > 0):?>
		<h3 class="highlight" style="padding-left:0"><?=lang('overview_activities_in')?> <?=$destination['name']?></h3>
		
		<ul class="">
		<?php foreach ($destination['activities'] as $activity):?>
			<li style="margin-bottom: 7px">
				
				 <?php 
					$descriptions = str_replace("\n", "<br>", $activity['description']);
				?>
				 <b><a href="javascript:void(0)" onclick="see_activity_overview('','<?=url_title($activity['name'])?>')"><?=$activity['name']?>:</a></b><span><?=' '.character_limiter($descriptions, 300)?></span>
			</li>
		<?php endforeach;?>
		</ul>
		
	<?php endif;?>
</div>				

<?php if(count($destination['attractions']) > 0):?>

<div class="clearfix"></div>

<h2 style="padding-left:0;padding-top:15px" class="highlight"><?=lang('overview_attractions_in')?> <?=$destination['name']?></h2>

<ul style="float:left;width:100%">
	<?php foreach ($destination['attractions'] as $attraction):?>
	
	<li style="float:left;width:25%;margin-bottom:10px;text-align:center;">
		
		<a style="border:0" href="javascript:void(0)" onclick="see_destination_overview('<?=$attraction['id']?>','<?=$departure_date?>')">
			<img style="border:1px solid #EEE;padding:2px;" width="120" height="90" alt="<?=$attraction['name']?>" src="<?=$this->config->item('des_small_path').$attraction['picture_name']?>">
		</a>
		
		<br>
		
		<a style="border:0" href="javascript:void(0)" onclick="see_destination_overview('<?=$attraction['id']?>','<?=$departure_date?>')">
			<?=$attraction['name']?>
		</a>
		 
	</li>
	
	<?php endforeach;?>
</ul>

<?php endif;?>

<?php if($destination['travel_tips'] != ''):?>
	<div class="clearfix"></div>
	<h2 class="highlight" style="padding-left:0;padding-top:15px"><?=lang('overview_travel_tip')?> <?=$destination['name']?></h2>
	
	<?php 
		
		$travel_tips = explode("\n", $destination['travel_tips']);
	
	?>

	<ul class="trip_highlight" style="list-style:decimal;">
		
		<?php foreach ($travel_tips as $tip):?>
			<?php if(trim($tip) != ''):?>			
				<li style="margin-bottom:7px">
					<?=$tip?>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
	</ul>

<?php endif;?>

<div class="clearfix"></div>

<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(DESTINATION_DETAIL, $destination['url_title'], true)?>')" style="margin-top: 10px; margin-right: 0; float: right; margin-left: 0;margin-bottom:5px">
 	<?=lang('view_more_detail')?>			 	
</div>

<script type="text/javascript">

function update_main_img(img_obj){

	var img_name = $(img_obj).attr('imgname');

	var imgcaption = $(img_obj).attr('imgcaption');

	var act = $(img_obj).attr('act');

	if (act == null || act == ''){
	
		$('#main_img_<?=$destination['id']?>').attr("src",'<?=$this->config->item('des_375_250_path')?>' + img_name);

	} else {

		$('#main_img_<?=$destination['id']?>').attr("src",'<?=$this->config->item('activity_375_250_path')?>' + img_name);
		
	}

	if (imgcaption != ''){
	
		$('#img_caption_<?=$destination['id']?>').text(imgcaption);

	} else {

		$('.img_caption').hide();
		
	}
	
}
</script>