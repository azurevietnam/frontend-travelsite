
<div class="row main-box">
    <div id="articles1st">
        <a class="highlight" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><img width="450px" height="300px" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ARTICLE, $article_1st['picture'], '450_300')?>"></a>
    </div>

    <div>
        <div class="first-item no-padding">
            <a class="highlight no-padding" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><h2><?=$article_1st['name']?></h2></a>
        </div>
        <div class="publish-date"><?=date(ARTICLES_DATE_FORMAT, strtotime($article_1st['date_created']))?></div>
        <div class="content"><?=character_limiter($article_1st['short_description'], 100)?></div>
        <h4><a class="highlight" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><?=ucfirst(lang('field_read_more'))?>...</a></h4>
    </div>
</div>
