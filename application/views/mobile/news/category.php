<div class="container">
    <h1 class="bpv-color-title"><?=$news_header?></h1>
    
    <?php foreach ($search_news as $news):?>
    <div class="list-news">
        <?php if(!empty($news['link'])):?>
            <div class="col-left">
                <a href="<?=$news['link']?>" target="_blank">
                    <img width="90" height="60" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
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
                    <img width="90" height="60" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                </a>
            </div>
            <div class="col-right">
                <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
            </div>
        <?php endif;?>
    </div>
    <?php endforeach;?>
</div>