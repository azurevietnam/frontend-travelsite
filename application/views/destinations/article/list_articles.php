    <?php foreach($articles as $key => $value) if($key > 0 || $page > 0):?>
    <div class="articles-item">
            <div class="col-xs-3">
                <img width="210" height="140px" class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_ARTICLE, $value['picture'], '210_140')?>">
            </div>
            <div class="col-xs-9">
                <h3><a href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $value)?>"><?=$value['name']?></a></h3>
                <div class="publish-date"><?=date(ARTICLES_DATE_FORMAT, strtotime($value['date_created']))?></div>
                <div class="content"><?=character_limiter($value['short_description'], 300)?></div>
            </div>
        <hr>
    </div>
    <?php endif;?>

    <div class="row margin-top-10 margin-bottom-10">
        <div class="col-xs-2" onclick="go_top()">
            <a class="backtotop"><span class="glyphicon glyphicon-circle-arrow-up text-special margin-right-5 margin-left-10"></span><?=lang('back_to_top')?></a>
        </div>
        <div class="col-xs-10 text-right">
            <p class="showing-results"><?=$paging_info['paging_text']?> <?=lang('field_articles')?></p>
            <?=$paging_info['paging_links']?>
        </div>
    </div>


