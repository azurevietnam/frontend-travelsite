<?php if(!empty($other_articles)):?>
    <div class="panel panel-default margin-top-15">
        <div class="panel-heading"><?=lang('field_other_articles')?></div>

        <ul class="list-group">
            <?php foreach($other_articles as $value):?>
                <li class="list-group-item">
                    <a href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination, $value)?>" style="font-size: 14px"><?=$value['name']?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>