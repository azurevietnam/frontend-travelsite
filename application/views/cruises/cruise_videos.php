<?php if (count($videos) > 0):?>
	<!-- 
	<div style="clear: both;"><span><?=lang('cruise_video_description')?><b><?=$cruise_name?></b>:</span></div>
	 -->
	
	 			
	<?php foreach ($videos as $key => $video):?>
		
		<div <?php if($key > 0):?> class="margin_top_10"<?php endif;?>>
			
			<img onclick="showVideo(<?=$video['id']?>)" id="video_<?=$video['id']?>_img" alt="<?=$video['name']?>" src="<?=site_url('media').'/btn_mini.gif'?>" style="cursor: pointer">
			<!--
			<?php if($key > 0):?>
				<img onclick="showVideo(<?=$video['id']?>)" id="video_<?=$video['id']?>_img" alt="<?=$video['name']?>" src="<?=site_url('media').'/btn_mini.gif'?>" style="cursor: pointer">
			<?php else:?>
				<img onclick="showVideo(<?=$video['id']?>)" id="video_<?=$video['id']?>_img" alt="<?=$video['name']?>" src="<?=site_url('media').'/btn_mini_hover.gif'?>" style="cursor: pointer">
			<?php endif;?>
			-->
			&nbsp;<b><a href="javascript:void(0)" onclick="showVideo(<?=$video['id']?>)"><?=$video['name']?></a></b>					
		</div>
		
		<div class="margin_top_10" id="video_<?=$video['id']?>_content" style="display: none">
			<?=$video['code']?>
		</div>
		
	<?php endforeach;?>

<?php endif;?>