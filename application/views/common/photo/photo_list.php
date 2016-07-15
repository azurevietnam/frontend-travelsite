<?php $str_id = uniqid();?>
<div class="row photo-container">
    <?php foreach ($photo_list as $k => $photo):?>
    <div class="col-xs-4 margin-top-5 <?=!empty($limit) && ($k + 1) > $limit ? 'photo-'.$str_id: ''?>" <?=!empty($limit) && ($k + 1) > $limit ? 'style="display:none"': ''?>>
        <a rel="nofollow" href="<?=$photo['upload_src']?>" data-lightbox="photo_list" data-title="<?=$photo['caption']?>">
            <img alt="<?=$photo['caption']?>" src="<?=$photo['src']?>" class="img-responsive">
		</a>
        <div class="photo-caption <?=!empty($limit) && ($k + 1) > $limit ? 'photo-caption-'.$str_id: ''?>"
             <?=!empty($limit) && ($k + 1) > $limit ? 'style="display:none"': ''?>><?=$photo['caption']?></div>
    </div>
    <?php endforeach;?>
</div>
<?php if(!empty($limit) && !empty($object_name) && count($photo_list) > $limit):?>
<div class="text-center clearfix margin-top-10">
    <button class="btn btn-default" type="button" id="btn-photo-list"
            data-label-more="<?=lang_arg('label_show_more_photos', $object_name)?>" data-label-less="<?=lang_arg('label_show_less_photos', $object_name)?>">
    <span class="glyphicon glyphicon-triangle-bottom margin-right-5"></span>
    <?=lang_arg('label_show_more_photos', $object_name)?></button>
</div>
<?php endif;?>
<script>
$('#btn-photo-list').click(function() {
	if( $('.photo-<?=$str_id?>').is(":visible")) {
		$(this).html('<span class="glyphicon glyphicon-triangle-bottom margin-right-5"></span>' + $(this).attr('data-label-more')).button("refresh");
		$('.photo-<?=$str_id?>').hide( "slow" );
		$('.photo-caption-<?=$str_id?>').hide( "slow" );
	} else {
		$(this).html('<span class="glyphicon glyphicon-triangle-top margin-right-5"></span>' + $(this).attr('data-label-less')).button("refresh");
		$('.photo-<?=$str_id?>').show( "slow" );
		$('.photo-caption-<?=$str_id?>').show( "slow" );
	}
});

if(!jQuery().Lightbox) { // check library is loaded
	var slider_load = new Loader();
	slider_load.require(<?=get_libary_asyn('lightbox')?>, function() {});
}
</script>