<div class="bpt-tour-destinations margin-top-15">
    <h2 class="title text-highlight"><span class="icon icon-top-tour"></span><?=lang('hotel_top_destination')?></h2>
    <div class="country clearfix">
        <?php foreach($top_hotel_des as $value):?>
            <div class="col-xs-6 margin-bottom-20 padding-left-0">
                <a href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $value)?>"><?=$value['name'].' '.ucfirst(lang('hotels'))?></a>
                <div><?=$value['number_hotels'].' '.lang('hotels')?></div>
            </div>
        <?php endforeach;?>
    </div>
</div>