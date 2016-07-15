
<div class="row main-box">
    <div class="floatL col-left col-xs-6" id="articles1st" style="width: 56%">
        <a class="highlight" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><img width="450px" height="300px" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ARTICLE, $article_1st['picture'], '450_300')?>"></a>
    </div>

    <div class="col-right floatL col-xs-6" style="width: 44%">
        <div class="first-item no-padding">
            <a class="highlight" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><h2><?=$article_1st['name']?></h2></a>
        </div>
        <div class="publish-date"><?=date(ARTICLES_DATE_FORMAT, strtotime($article_1st['date_created']))?></div>
        <div class="content"><?=$article_1st['short_description']?></div>
        <h4><a class="highlight" href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $article_1st)?>"><?=ucfirst(lang('field_read_more'))?>...</a></h4>
    </div>
</div>
