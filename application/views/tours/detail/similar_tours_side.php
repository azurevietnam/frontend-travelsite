<div class="bpt-left-block">
    <h2 class="title text-highlight"><span class="icon icon-similar margin-right-5"></span><?=$similar_title?></h2>
    <ul class="list-unstyled margin-bottom-0">
        <?php foreach ($tours as $tour):?>
        <li>
            <span class="text-special arrow-orange">&rsaquo;</span>
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
        </li>
        <?php endforeach;?>
        <?php if(!empty($more_tour_text)):?>
        <li class="text-right no-padding">
            <a class="text-underline" href="<?=$more_tour_link?>"><?=$more_tour_text?></a><span class="icon icon-arrow-right-blue-sm margin-left-5"></span>
        </li>
        <?php endif;?>
    </ul>
</div>