<div class="bpt-block-hotline">
    <h2 class="title"><span class="icon icon-hotline"></span><?=lang('label_hotline_support')?></h2>
    <div class="row content">
        <div class="col-xs-4"><img width="90px" height="90px" class="img-circle" src ="<?=base_url('images/users/'.$schedule['avatar'])?>"/></div>
        <div class="col-xs-8">
            <div class="text-highlight"><?=$schedule['sale_name']?></div>
            <?=$schedule['hotline_number']?><br>
            <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a><br>

        </div>
    </div>
    <div class="description">
        <?=$schedule['hotline_description']?>
    </div>
</div>