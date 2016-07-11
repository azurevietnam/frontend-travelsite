
<?php foreach($articles as $key => $value):?>
    <div class="articles-item bpt-mb-item clearfix" onclick="go_url('<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $value)?>')">
        <img width="210" height="140px" class="img-responsive bpt-mb-item-image pull-left" src="<?=get_image_path(PHOTO_FOLDER_ARTICLE, $value['picture'], '210_140')?>">
        <a class="bpt-mb-item-name">
            <?=$value['name']?>
        </a>
        <div class="publish-date"><?=date(ARTICLES_DATE_FORMAT, strtotime($value['date_created']))?></div>
    </div>
<?php endforeach;?>
<div class="row margin-top-10">
    <div class="col-xs-2" onclick="go_top()">
        <a class="backtotop"><span class="glyphicon glyphicon-circle-arrow-up"></span></a>
    </div>
    <div class="col-xs-10 text-right">
        <p class="showing-results"><?=$paging_info['paging_text']?> <?=lang('field_articles')?></p>
        <?=$paging_info['paging_links']?>
    </div>
</div>















