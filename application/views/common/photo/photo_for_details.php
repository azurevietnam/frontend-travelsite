<?php if(!empty($photos)):?>
<div class="photo-container">
    <a rel="nofollow" href="<?=$photos[0]['upload_src']?>"
                data-lightbox="photo-gallery" data-title="<?=$photos[0]['name']?>">
        <img class="img-responsive" src="<?=$photos[0]['src']?>" alt="<?=$photos[0]['caption']?>">
    </a>
    <div class="photo-row">
    <?php foreach ($photos as $k => $photo):?>
        <?php 
            if($k == 0) continue;
            if(!empty($limit) && $k > $limit) break; 
        ?>
        <div class="photo-cell">
            <a rel="nofollow" href="<?=$photo['upload_src']?>"
                    data-lightbox="photo-gallery" data-title="<?=$photo['caption']?>">
                <img class="img-responsive" src="<?=$photo['small_src']?>" alt="<?=$photo['caption']?>">
            </a>
        </div>
    <?php endforeach;?>
    </div>
    
    <?php if($is_free_visa):?>
    <div class="pop-free-visa"><span class="icon icon-free-visa"></span><?=load_free_visa_popup($is_mobile)?></div>
    <?php endif;?>
</div>
<script>
if(!jQuery().Lightbox) { // check library is loaded
	var slider_load = new Loader();
	slider_load.require(<?=get_libary_asyn('lightbox')?>, function() {});
}
</script>
<?php endif;?>