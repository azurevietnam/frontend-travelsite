<?php if(!empty($articles)):?>
    <div class="bpt-left-block">
        <h2 class="text-highlight title"><span class="icon icon-recommend-services"></span><?=lang('field_article_about', $destination['name'])?></h2>

        <ul class="list-unstyled">
            <?php foreach($articles as $value):?>
                <li><a href="<?=get_page_url(DESTINATION_ARTICLE_DETAIL_PAGE, $destination,  $value)?>"><span class="icon icon-arrow-right-orange"></span><?=$value['name']?></a></li>
            <?php endforeach;?>

            <li class="text-right">
            	<a href="<?=get_page_url(DESTINATION_ARTICLE_PAGE, $destination)?>"><?=lang('field_articles_more')?> <span class="icon icon-double-arrow margin-bottom-5"></span></a>
            </li>
        </ul>
    </div>
<?php endif;?>