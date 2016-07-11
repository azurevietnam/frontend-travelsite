

<div class="flexslider">
    <ul class="slides" style="height:auto">
        <?php if(!empty($advertises)):?>
            <?php foreach($advertises as $ad):?>
                <?php foreach($ad['photos'] as $photo):?>
                    <li>
                        <a href="<?=$ad['link']?>">
                            <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ADVERTISE, $photo['name'])?>">
                        </a>
                    </li>
                <?php endforeach;?>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
</div>

<script type="text/javascript">

    var cal_load = new Loader();
    cal_load.require(
        <?=get_libary_asyn('flexslider')?>,
        function() {

            $('.flexslider').flexslider({
                animation: "slide",
                animationLoop: true,
                slideshow: true,
                controlNav: false,
                directionNav: false,
                slideshowSpeed: 4000
            });

        });
</script>