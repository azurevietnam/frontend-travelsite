<div class="lst_all_hotels background-list-service-link">
    <div class="container padding-bottom-20">
        <?php if(!empty($h_5_stars)):?>
            <h3 class="text-highlight clearfix popular-listing-tite margin-top-10"><?=lang('hotel_5_start_in', $destination['name']) ?></h3>
            <ul class="list-unstyled">
                <?php foreach ($h_5_stars as $hotel) :?>
                    <li>
                        <a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
                        <?php if($hotel['is_new']):?>

                            <span class="special"><?=lang('obj_new') ?></span>

                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
            <div class="clearfix"></div>
        <?php endif;?>
        <?php if(!empty($h_4_stars)):?>
            <h3 class="text-highlight clearfix popular-listing-tite margin-top-20"><?=lang('hotel_4_start_in', $destination['name']) ?></h3>
            <ul class="list-unstyled">
                <?php foreach ($h_4_stars as $hotel) :?>
                    <li>
                        <a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
                        <?php if($hotel['is_new']):?>

                            <span style="font-weight: normal;" class="special"><?=lang('obj_new') ?></span>

                        <?php endif;?>


                    </li>
                <?php endforeach ;?>
            </ul>
            <div class="clearfix"></div>
        <?php endif;?>

        <?php if(!empty($h_3_stars)):?>
            <h3 class="text-highlight popular-listing-tite margin-top-20 widget-title-v2"><?=lang('hotel_3_start_in', $destination['name']) ?></h3>
            <ul class="list-unstyled">
                <?php foreach ($h_3_stars as $hotel) :?>
                    <li>
                        <a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
                        <?php if($hotel['is_new']):?>

                            <span class="special"><?=lang('obj_new') ?></span>

                        <?php endif;?>
                    </li>
                <?php endforeach ;?>
            </ul>
        <?php endif;?>
    </div>

</div>

