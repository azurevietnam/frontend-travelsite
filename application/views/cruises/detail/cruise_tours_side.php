<div class="bpt-left-block">
    <h2 class="title text-highlight"><span class="icon icon-tour-green margin-right-5"></span><?=lang_arg('tour_of_cruise', $cruise['name'])?></h2>
    <ul class="list-unstyled">
        <?php foreach ($tours as $key => $tour):?>
        <li>
            <span class="text-special arrow-orange">&rsaquo;</span>
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
        </li>
        <?php endforeach;?>
    </ul>
</div>