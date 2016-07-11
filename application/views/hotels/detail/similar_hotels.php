<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(isset($similar_hotels) && count($similar_hotels)>0):?>

        <div class="bpt-similar">
            <h2 class="container text-highlight border-title-organe"><span class="icon icon-hotel-special margin-right-10"></span> <?=lang('hotel_detail_similar_hotels')?></h2>
            <div class="container">
                <?php foreach ($similar_hotels as $hotel):?>
                    <div class="col-xs-3 bpt-similar-item hotel-ids" data-id="<?=$hotel['id']?>">
                        <div class="bpt-similar-name bpt-similar-name-hotel text-left margin-bottom-10">
                            <a href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>"><?=$hotel['name']?></a> &nbsp;
                            <span class="icon <?=get_icon_star($hotel['star'])?>"></span>
                        </div>

                        <a href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>">
                            <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], '265_177')?>" alt="<?=$hotel['name']?>">
                        </a>
                        <div class="margin-top-10 text-left review-height">
                            <?=get_text_review($hotel, HOTEL, true, true)?>
                        </div>

                        <div class="row">
                            <div class="col-xs-7 text-left">
                                <span class="price-origin h-origin-<?=$hotel['id']?>"></span>
                                <span class="price-from h-from-<?=$hotel['id']?>"><?=lang('na')?></span>
                                <span class="h-unit-<?=$hotel['id']?>" style="display:none;"><?=lang('per_room_night')?></span>
                            </div>
                            <div class="col-xs-5 text-right margin-top-5">
                                <a href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>" class="btn btn-yellow btn-sm"><?=lang('book_now')?></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>

                <div class="pull-right margin-top-10 tab-content">
                    <a class="bpt-see-more" href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $destination)?>"><?=lang('field_more_hotel_in', $destination['name'])?> <span class="icon icon-arrow-right-blue-sm margin-left-5"></span></a>
                </div>
            </div>
        </div>

	<script type="text/javascript">
		get_hotel_price_from();
	</script>

<?php endif;?>