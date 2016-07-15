<div class="pull-right bpt-item-background margin-bottom-20">
	<div class="list_hotels">
	    <?php foreach ($hotels as $hotel):?>
	        <div class="bpt-item hotel-ids" data-id="<?=$hotel['id']?>">
	            <div class="col-content">
	                <div class="margin-bottom-10">
	                    <a class="item-name" href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>"><?=$hotel['name']?></a> &nbsp;
	                    <?php $star_infor = get_star_infor_tour($hotel['star'], 0);?>
	                    <span class="icon <?=get_icon_star($hotel['star'])?>" title="<?=$star_infor['title']?>"></span>
	                </div>
	                <div class="col-img text-center">
	                    <a class="item-name" href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>">
	                        <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $hotel['picture'], '210_140')?>" width="210px" height="140px">
	                    </a>
	                </div>

	                <div class="col-info">
	                    <?php if(!empty($hotel['location'])):?>
	                        <div class="row margin-bottom-5 text-unhighlight">
	                            <div class="col-text text-unhighlight"><?=$hotel['location']?></div>
	                        </div>
	                    <?php endif;?>

	                    <?php if($hotel['review_number'] > 0):?>
	                        <div class="row margin-bottom-5">
	                            <div class="col-label text-unhighlight"><?=lang('reviewscore')?>:</div>
	                            <div class="col-text"><?=get_text_review($hotel, HOTEL, true, false)?></div>
	                        </div>
	                    <?php endif;?>

                        <?php if(!empty($hotel['special_offers'])):?>
                            <div class="row margin-bottom-5">
                                <div class="text-unhighlight col-label"><?=lang('special_offers')?>:</div>
                                <div class="col-text"><?=$hotel['special_offers']?></div>
                            </div>
                        <?php endif;?>

	                    <div class="description">
	                        <?=character_limiter(strip_tags($hotel['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
	                    </div>
	                </div>
	            </div>

	            <div class="col-price text-right">
	                <div>
	                    <?=lang('label_from')?>
	                </div>

	                <?php
	                $hotel['price']['price_from'] = 686;
	                $hotel['price']['price_origin'] = 33;
	                $price_origin = !empty($hotel['price']['price_origin']) ? show_usd_price($hotel['price']['price_origin']) : '';
	                $price_from = !empty($hotel['price']['price_from']) ? show_usd_price($hotel['price']['price_from']) : lang('na');
	                ?>

	                <div class="margin-bottom-10">
	                    <span class="price-origin h-origin-<?=$hotel['id']?>"><?=$price_origin?></span>
	                    <span class="price-from h-from-<?=$hotel['id']?>"><?=$price_from?></span>
	                    <span class="h-unit-<?=$hotel['id']?>" <?=empty($hotel['price']) ? 'style="display:none"' : ''?>><?=lang('per_pax')?></span>
	                </div>

	                <div class="btn btn-sm btn-yellow margin-top-10" onclick="go_url('<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>')">
	                    <?=lang('select_hotel')?>
	                </div>
	            </div>
	        </div>
	    <?php endforeach;?>
	</div>
	<?php if($is_hotel_destination):?>
	    <button class="btn btn-default margin-bottom-20 margin-top-10 col-lg-offset-5" destination-id="<?=$destination['id']?>" id="btn_see_more" ONCLICK="load_more_hotel_items('.hotel-ids')"><i class="glyphicon glyphicon-triangle-bottom"></i>    <t><?=lang('field_show_more_hotel', $destination['name'])?></button>

	<?php endif;?>
</div>