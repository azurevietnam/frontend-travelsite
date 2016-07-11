<?php if(!empty($hotels)):?>
    <div class="list_hotels">
        <?php foreach ($hotels as $hotel):?>
            <div class="bpt-mb-item clearfix hotel-ids" data-id="<?=$hotel['id']?>" onclick="go_url('<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>')">
                <img class="bpt-mb-item-image pull-left" alt="<?=$hotel['name']?>" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], '265_177')?>">

                <div class="bpt-mb-item-name">
                    <?=$hotel['name']?>
                    <div style="display: inline-block; font-size: 12px; color: #fca903">
                        <?php for ($i = 0; $i < $hotel['star']; $i++):?>
                            <span class="glyphicon glyphicon-star"></span>
                        <?php endfor;?>
                    </div>
                </div>

                <div class="bpt-mb-item-price">
                    <span class="price-from h-from-<?=$hotel['id']?>">
                        <?php if(!empty($hotel['price']['price_from'])):?>
                            <?=show_usd_price($hotel['price']['price_from'])?>
                        <?php else:?>
                            <?=lang('na')?>
                        <?php endif;?>
                    </span>
                    <span><?=lang('per_room_night')?></span>
                </div>

                <?php if(!empty($hotel['review_number'])):?>
                <div class="bpt-mb-item-review margin-top-5"><?=get_text_review($hotel, HOTEL, false)?></div>
                <?php endif?>
            </div>
        <?php endforeach;?>
    </div>

<?php if($is_hotel_destination):?>
    <div class="container margin-bottom-10 margin-top-10">
        <button class="btn btn-default btn-block margin-bottom-10 margin-top-10" data-loading-text="<?=lang('label_loading')?>..." number-hotels="<?=$destination['number_hotels']?>" destination-id="<?=$destination['id']?>" id="btn_see_more"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_show_more_hotel', $destination['name'])?></button>
    </div>
    <script>
        load_more_hotel_items('#btn_see_more');
        check_btn_show_more('#btn_see_more', 'number-hotels', '.bpt-mb-item');
    </script>
<?php endif;?>
<?php endif;?>
