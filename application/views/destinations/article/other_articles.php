<h2 class="text-highlight header-title"><?=lang('field_other_articles')?></h2>
<ol style="margin-left: -20px">
    <?php foreach($other_articles as $value):?>
        <a href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $value)?>" style="font-size: 14px"><li><?=$value['name']?></li></a>
    <?php endforeach;?>
</ol>