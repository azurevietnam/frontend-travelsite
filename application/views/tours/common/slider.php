<div id="<?=$slider_id?>" class="carousel slide" data-ride="carousel" data-interval="0">
	
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <?php foreach ($photos as $k => $photo):?>
        <li data-target="<?='#'.$slider_id?>" data-slide-to="<?=$k?>" <?=$k==0 ? 'class="active"' : ''?>></li>
        <?php endforeach;?>
    </ol>
    
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <?php foreach ($photos as $k => $photo):?>        
        <div class="item <?=$k==0 ? 'active' : ''?>" style="background-color:#cdcdcd;min-height:200px">
            <img class="img-responsive center-block" src="<?=get_image_path($page, $photo['name'])?>" title="<?=$photo['caption']?>" alt="<?=$photo['caption']?>">
            <div class="carousel-caption"><?=$photo['caption']?></div>
        </div>
        <?php endforeach;?>
    </div>
    
    <!-- Controls -->
    <a class="left carousel-control" href="<?='#'.$slider_id?>" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="<?='#'.$slider_id?>" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    
</div>

<script>
/*
$(document).ready(function() {
	 
    var imageHeight, wrapperHeight, overlap, container = $('.image-wrap'); 
 
    function centerImage() {
        imageHeight = container.find('img').height();
        wrapperHeight = container.height();
        overlap = (wrapperHeight - imageHeight) / 2;
        container.find('img').css('margin-top', overlap);
    }
     
    $('.image-wrap img').on("load resize", centerImage);

    var el = document.getElementsByClassName('image-wrap');
    if (el.addEventListener) { 
        el.addEventListener("webkitTransitionEnd", centerImage, false); // Webkit event
        el.addEventListener("transitionend", centerImage, false); // FF event
        el.addEventListener("oTransitionEnd", centerImage, false); // Opera event
    }
	  
});
*/ 
</script>