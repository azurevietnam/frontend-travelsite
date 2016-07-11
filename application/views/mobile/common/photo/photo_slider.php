<div class="flexslider flexslider_loader">
    <div class="loader"></div>
    <ul class="slides">

    <?php foreach ($photos as $k => $photo):?>
    
        <?php if($k == 0):?>
        
        <?php if(!empty($cruise)):?>
        <li>
            <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture'], '375_250')?>" alt="<?=$cruise['name']?>">
            <div class="flex-caption" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
                <p>
                <span property="v:itemreviewed" class="item-name"><?=$cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION ? $cruise['name'] . ' ' . lang('halong_bay') : $cruise['name']?></span> <span class="icon <?=get_icon_star($cruise['star'])?>"></span>
                <meta rel="v:photo" content="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture'], 'origin')?>">
    
                <span class="partner-name clearfix"><?=lang('by').' '.$cruise['partner_name']?></span>
    
                <span class="hide" property="v:count"><?=$cruise['review_number']?></span>
                </p>
            </div>
        </li>
        <?php elseif(!empty($tour)):?>
        <li>
            <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '375_250')?>" alt="<?=$tour['name']?>">
            <div class="flex-caption">
                <p>
                <span class="clearfix item-name"><?=$tour['name']?></span>
                <?=get_partner_name($tour)?>
                </p>
            </div>
        </li>
        <?php elseif(!empty($hotel)):?>
        <li>
            <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], '375_250')?>" alt="<?=$hotel['name']?>">
            <div class="flex-caption" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
                <p>
                    <span property="v:itemreviewed"><?=$hotel['name']?></span> <span class="icon <?=get_icon_star($hotel['star'])?>"></span>
                    <meta rel="v:photo" content="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], 'origin')?>">

                    <span class="hide" property="v:count"><?=$hotel['review_number']?></span>
                </p>
            </div>
        </li>
        <?php endif;?>
        
        <?php else:?>
        <li>
            <img class="img-responsive" src="<?=$photo['src']?>" alt="<?=$photo['caption']?>">
            <div class="flex-caption">
                <p><?=$photo['caption']?></p>
            </div>
        </li>
        <?php endif;?>
        
    <?php endforeach;?>
    </ul>
</div>

<script type="text/javascript">
    var cal_load = new Loader();
    cal_load.require(
        <?=get_libary_asyn('flexslider')?>,
        function() {
        	$(".flexslider .img-responsive").last().load(function() {
        		init_slider();
        	})
    });

    function init_slider() {
        
        if($('.flexslider').hasClass( "hasLoaded" )) {
        	$('.flexslider').data('flexslider').setup(); 
        	return false;
        } else {
        	$('.flexslider').addClass('hasLoaded');
        }
        
    	// remove loader
        $('.flexslider .loader').remove();
    	$('.flexslider').removeClass('flexslider_loader');
    	
    	// load slider
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: true,
            slideshow: false,
            controlNav: false,
            directionNav: true,
            //slideshowSpeed: 4000
        });

        // console.log('--> load slider');
    }
</script>