<style>
    .carousel-indicators .active {
        border-color:#FFF;
        background-color: #FFB300;
    }
	
    .carousel-indicators li {
        /*border-radius: 0;
        background-color: #fff;*/
        margin: 0px;
    }

    .carousel-indicators{
        bottom:0;
    }
</style>
<?php if($display_mode == AD_DISPLAY_SINGLE):?>

	<!-- Show Image & Link of this Ad -->
    <div class="bpt-bga">
    	<div class="margin-bottom-10">
            <a href="<?=$advertises[0]['link'];?>">
            <?php foreach ($advertises[0]['photos'] as $photo): ?>
            <img class="img-responsive" alt="<?=$advertises[0]['name']?>" title="" src="<?=get_image_path(PHOTO_FOLDER_ADVERTISE, $photo['name'])?>"/>
           <!-- <img class="img-responsive" alt="<?=$advertises[0]['name']?>" title="" src="http://www.bestpricevn.com/images/advertises/origin/558cb6379c2b2.jpg"/> -->
            <?php endforeach;?>
            </a>
    	</div>
    </div>
<?php else:?>

    <div id="bpt-common-ad" class="carousel slide margin-bottom-10" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators text-right">
            <?php for($i = 0 ; $i < $photo_count; $i++):?>
                <li data-target="#bpt-common-ad" style="width:15px;height:15px" data-slide-to="<?=$i?>" class="<?=$i == 0 ? 'active' : ''?>"></li>
            <?php endfor;?>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php $thefirst = true; ?>
            <?php foreach ($advertises as $ad):?>
                <?php foreach ($ad['photos'] as $photo):?>
                    <div class="item <?php if($thefirst){ echo('active'); $thefirst = false; }?>">
                    	<a href="<?=$ad['link'];?>">
                        	<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ADVERTISE ,$photo['name'])?>" alt="<?=$ad['name']?>">
                        </a>
                    </div>
                <?php endforeach;?>
            <?php endforeach;?>
        </div>

        <!-- Controls -->
        <!--
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next" style="background-image: none">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
         -->
    </div>



<?php endif;?>
