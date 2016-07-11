<?php if(!check_prevent_promotion()):?>
<div id="side-ads">

	<a href="<?=$side_ads['url']?>" rel="nofollow">
		<img width="260" height="96" src="<?=get_static_resources('/media/ads/'.$side_ads['pic'])?>"></img>
	</a>

</div>
<?php endif;?>