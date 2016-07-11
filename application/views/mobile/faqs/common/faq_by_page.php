<?php if(!empty($faq)):?>
<div class="bpt-left-block">
    <h3 class="title text-highlight"><span class="icon icon-faqs-green"></span><?=lang('mnu_faqs')?></h3>
    <ul class="list-unstyled">
        <?php foreach($faq as $value):?>
            <li><span class="text-special arrow-orange">&rsaquo;</span> <a href="<?=get_page_url(FAQ_DETAIL_PAGE, $value)?>"><?=$value['question']?></a></li>
        <?php endforeach;?>
        <li>
            <div class="text-right">
                <a class="text-underline" href="<?=get_page_url(FAQ_PAGE)?>"><?=lang('label_view_more')?><span class="icon icon-arrow-right-blue-sm margin-left-5"></span></a>
            </div>
        </li>
    </ul>
</div>
<?php endif;?>
