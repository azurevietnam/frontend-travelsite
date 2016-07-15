<div class="bpt-left-block">
    <h2 class="title text-highlight"><span class="icon icon-search-green margin-right-5"></span><?=lang('find_your_cruises')?></h2>
    <ul class="list-unstyled">
        <li>
            <span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
            <a href="<?=get_page_url($main_page)?>" <?=$page==$main_page ? 'class="active"': ''?>>
            <?=strpos($page, 'halong') !== FALSE ? lang('label_all_halong_cruise_categories') : lang('label_all_mekong_cruise_categories')?>
            </a>
        </li>
        <?php foreach($cruise_types as $key=>$value):?>
        <li>
            <span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
            <a href="<?=get_page_url($key)?>" <?=$page==$key ? 'class="active"': ''?>><?=lang($value['label'])?></a>
        </li>
        <?php endforeach;?>
    </ul>
</div>
