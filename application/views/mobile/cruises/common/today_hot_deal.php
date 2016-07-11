<?php if(!empty($tours)):?>
<div class="flexslider flexslider_loader">
    <div class="loader"></div>
    <ul class="slides">
    <?php foreach ($tours as $tour):?>
        <li>
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
                <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '450_300')?>" alt="<?=$tour['name']?>">
            </a>
            <div class="flex-caption" onclick="go_url('<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>')">
                <h2><?=$tour['name']?></h2>
                <div class="row margin-top-5">
                    <div class="col-xs-8 text-special">
                        <?php if(!empty($tour['promotion'])):?>
                        <?php $offer_note = explode("\n", $tour['promotion']['offer_note']);?>
                        <?=$offer_note[0]?>
                        <?php endif;?>
                    </div>
                    <div class="col-xs-4 text-right tour-ids" data-id="<?=$tour['id']?>">
                        <span class="price-from text-special t-from-<?=$tour['id']?>"></span><span class="text-special"><?=lang('per_pax')?></span>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach;?>
    </ul>
</div>

<script type="text/javascript">
    var cal_load = new Loader();
    cal_load.require(
        <?=get_libary_asyn('flexslider')?>,
        function() {
            
        	$('.flexslider .loader').remove();
        	$('.flexslider').removeClass('flexslider_loader');
        	
            $('.flexslider').flexslider({
                animation: "slide",
                animationLoop: true,
                slideshow: false,
                controlNav: false,
                directionNav: true,
                //slideshowSpeed: 4000
            });
        });

    get_tour_price_from();
</script>
<?php endif;?>