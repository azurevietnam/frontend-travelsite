<?php if(!empty($videos)):?>
<h2 class="text-highlight header-title margin-top-20"><?=$cruise_name. ' '.lang('cruise_videos')?></h2>
<div class="cruise-videos">
    <?php foreach ($videos as $key => $video):?>
    
	<div <?php if($key > 0):?> class="margin-top-10"<?php endif;?>>
		<img onclick="showVideo(<?=$video['id']?>)" id="video_<?=$video['id']?>_img" alt="<?=$video['name']?>" 
            src="<?=get_static_resources('/media/btn_mini.gif')?>">
		<b><a href="javascript:void(0)" onclick="showVideo(<?=$video['id']?>)"><?=$video['name']?></a></b>					
	</div>
	
	<div class="margin_top_10" id="video_<?=$video['id']?>_content" style="display: none">
		<?=$video['code']?>
	</div>
	
    <?php endforeach;?>
</div>
<?php endif;?>