<div class="container">

    <h1 class="bpv-color-title"><?=$news_header?></h1>
	
	<?php if(!empty($first_news)): ?>
	<div class="box-hot-news margin-bottom-20">
	    <?php if(!empty($first_news[0]['link'])):?>
            <a href="<?=$first_news[0]['link']?>" target="_blank">
                <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$first_news[0]['picture'])?>">
            </a>
            
            <div class="title-news width-common">
                <a href="<?=$first_news[0]['link']?>" target="_blank"><?=$first_news[0]['name']?></a>
            </div>
            <div class="news_lead width-common">
                <?=word_limiter($first_news[0]['short_description'], 24)?>
            </div>
         <?php else:?>
            <a href="<?=get_url(NEWS_DETAILS_PAGE, $first_news[0])?>">
                <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$first_news[0]['picture'])?>">
            </a>
            
            <div class="title-news width-common">
                <a href="<?=get_url(NEWS_DETAILS_PAGE, $first_news[0])?>"><?=$first_news[0]['name']?></a>
            </div>
            <div class="news_lead width-common">
                <?=word_limiter($first_news[0]['short_description'], 24)?>
            </div>
         <?php endif;?>
	</div>
	
	<?php endif;?>
	
	<?php foreach ($news_cat as $cat):?>
	<div class="box-category">
    	<div class="title-box-category width-common">
    	   <a class="bpv-color-title" href="<?=get_url(NEWS_CATEGORY_PAGE, $cat)?>"><?=$cat['name']?></a>
    	</div>
    	
        <?php foreach ($cat['news'] as $news):?>
        <div class="list-news">
            <?php if(!empty($news['link'])):?>
                <div class="col-left">
                    <a href="<?=$news['link']?>" target="_blank">
                        <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                    </a>
                </div>
                <div class="col-right">
                    <a href="<?=$news['link']?>" target="_blank">
                    <?=$news['name']?>
                    </a>
                </div>
            <?php else:?>
                <div class="col-left">
                    <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>">
                        <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                    </a>
                </div>
                <div class="col-right">
                    <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
                </div>
            <?php endif;?>
        </div>
        <?php endforeach;?>
	</div>
	
	<div class="text-center clearfix margin-top-20 margin-bottom-20 bpv-list">
	   <a class="view-more" href="<?=get_url(NEWS_CATEGORY_PAGE, $cat)?>">
	   <?=lang('btn_show_extra').' '.strtolower($cat['name'])?>
	   <span class="icon icon-chevron-right"></span>
	   </a>
	</div>
	<?php endforeach;?>

</div>