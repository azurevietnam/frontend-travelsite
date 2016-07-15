<div class="bpt-left-block">
    <h2 class="title text-highlight"><span class="icon icon-tour-green margin-right-5"></span><?=$similar_title?></h2>
  	<ul class="list-unstyled">
        <?php foreach ($cruises as $cruise):?>
        <li>
            <span class="text-special arrow-orange">&rsaquo;</span>
            <a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a>
            <span class="icon <?=get_icon_star($cruise['star'])?>"></span>
        </li>
        <?php endforeach;?>
    </ul>
</div>