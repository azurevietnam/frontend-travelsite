<?php if(!$is_ajax):?>
<div class="pull-right bpt-item-background margin-bottom-20">
	<div class="list_hotels">
<?php endif;?>
	    <?php foreach ($hotels as $hotel):?>
	        <div class="bpt-item bpt-mb-item hotel-ids" data-id="<?=$hotel['id']?>">
	            <div class="col-content">
	                <div class="col-img text-center">
	                    <a class="item-name" href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>">
	                        <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], '210_158')?>" width="210px" height="158px">
	                    </a>

                        <div class="btn btn-green btn-xs btn-list" onclick="see_overview('<?=$hotel['url_title']?>', 'hotel', '<?=str_replace('\'', ' ', $hotel['name'])?>')"><?=lang('see_overview')?></div>
	                </div>

	                <div class="col-info">
                        <div class="margin-bottom-10">
                            <a class="item-name" href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>"><?=$hotel['name']?></a> &nbsp;
                            <?php $star_infor = get_star_infor_tour($hotel['star'], 0);?>
                            <span class="icon <?=get_icon_star($hotel['star'])?>" title="<?=$star_infor['title']?>"></span>
                        </div>
	                    <?php if(!empty($hotel['location'])):?>
	                        <div class="row margin-bottom-5 text-unhighlight" style="margin-left: 0">
                                <i><?=$hotel['location']?></i>
	                        </div>
	                    <?php endif;?>

                        <?php if(!empty($hotel['number_of_room'])):?>
                            <div class="row margin-bottom-5">
                                <div class="col-label text-unhighlight"><?=lang('hotel_rooms')?>:</div>
                                <div class="text-unhighlight col-text"><b><?=$hotel['number_of_room']?></b>  <?=lang('room_available')?></div>
                            </div>
                        <?php endif;?>

	                    <?php if($hotel['review_number'] > 0):?>
	                        <div class="row margin-bottom-5">
	                            <span class="col-label text-unhighlight"><?=lang('reviewscore')?>:</span>
	                            <span class="col-text"><?=get_text_review($hotel, HOTEL, true, false)?></span>
	                        </div>
	                    <?php endif;?>

                        <?php if(!empty($hotel['special_offers'])):?>
                            <div class="margin-bottom-5">
                                <?=$hotel['special_offers']?>
                            </div>
                        <?php endif;?>

	                    <div class="description">
	                        <?=character_limiter(strip_tags($hotel['description']), HOTEL_DESCRIPTION_CHR_LIMIT)?>
	                    </div>
	                </div>
	            </div>

	            <div class="col-price text-right">
	                <div>
	                    <?=lang('label_from')?>
	                </div>

	                <?php
                        $price_origin = !empty($hotel['price']['price_origin']) ? show_usd_price($hotel['price']['price_origin']) : '';
                        $price_from = !empty($hotel['price']['price_from']) ? show_usd_price($hotel['price']['price_from']) : lang('na');
	                ?>

	                <div class="margin-bottom-10">
	                    <span class="price-origin h-origin-<?=$hotel['id']?>"><?=$price_origin?></span>
	                    <span class="price-from h-from-<?=$hotel['id']?>"><?=$price_from?></span>
	                    <span class="h-unit-<?=$hotel['id']?>" <?=empty($hotel['price']) ? 'style="display:none"' : ''?>><?=lang('per_room_night')?></span>
	                </div>

	                <div class="btn btn-sm btn-yellow margin-top-10" onclick="go_url('<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>')">
	                    <?=lang('select_hotel')?>
	                </div>
	            </div>
	        </div>
	    <?php endforeach;?>
	</div>
	<?php if($is_hotel_destination):?>
	    <button class="btn btn-default margin-bottom-20 margin-top-10 col-lg-offset-5" number-hotels="<?=$destination['number_hotels']?>" data-loading-text="<?=lang('label_loading')?>..." destination-id="<?=$destination['id']?>" id="btn_see_more"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_show_more_hotel', $destination['name'])?></button>
    <?php endif;?>
</div>
<script>
    <?php if($is_ajax):?>
        get_hotel_price_from();
    <?php endif;?>

    <?php if($is_hotel_destination):?>
        load_more_hotel_items('#btn_see_more');
        check_btn_show_more('#btn_see_more', 'number-hotels', '.bpt-item');
    <?php endif;?>
</script>
