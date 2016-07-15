<div class="footer-list-link margin-top-10">
    <div class="container">
        <h3 class="text-highlight title"><span class="icon icon-hotel-special"></span><?=lang('hotel_popular_cities')?></h3>
        <?php if(!empty($hotel_des)):?>
            <ul class="list-unstyled content">
                <?php foreach($hotel_des as $value):?>
                    <li class="margin-bottom-10 col-xs-3"><a class="<?=$value['is_top_hotel'] ? 'text-highlight' : ''?>" style="<?=$value['is_top_hotel'] ? 'font-weight:bold' : ''?>" href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $value)?>"><?=$value['name'] . ' (' . $value['number_hotels'] . ')'?></a></li>
                <?php endforeach;?>
            </ul>
            <div class="clearfix"></div>
        <?php endif;?>
    </div>
</div>

