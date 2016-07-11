<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin">
        <?=lang('hotel_top_destination')?>
    </h3>
    <div class="list-group bpv-list-group">
        <?php foreach($top_hotel_des as $value):?>
            <a class="list-group-item" href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $value)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('hotel_last_url_title', $value['name'])?>
                <span class="badge">
                    <?=$value['number_hotels']?>
                </span>
            </a>
        <?php endforeach;?>
    </div>
</div>