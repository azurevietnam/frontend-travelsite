<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin">
        <?=lang('faq_by_categories')?>
    </h3>
    <div class="list-group bpv-list-group">
        <?php foreach($categories as $key=>$value):?>
            <a class="list-group-item <?= $current_category_id == $value['id'] ? 'active' : ''?>" href="<?=get_page_url(FAQ_CATEGORY_PAGE, $value)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=$value['name']?>
            </a>
        <?php endforeach;?>
    </div>
</div>