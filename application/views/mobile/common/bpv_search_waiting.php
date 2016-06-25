
<?php if($mode == 'waiting'):?>
<div class="bpv-search-waiting">
	<div class="ms1"><?=$message?></div>
	<div class="ms2">
		<img style="margin-right:15px;" alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
		<span><?=empty($please_wait_txt)? lang('search_please_wait') : $please_wait_txt?></span>
	</div>		
</div>
<?php else :?>

<div class="bpv-update-wrapper" style="display:none">
	<div class="bpv-search-updating center-block" >
		<div class="ms1"><?=$message?></div>
		<div class="ms2">
			<img style="margin-right:10px;" alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
			<span><?=empty($please_wait_txt)? lang('search_please_wait') : $please_wait_txt?></span>
		</div>		
	</div>
</div>

<?php endif;?>
