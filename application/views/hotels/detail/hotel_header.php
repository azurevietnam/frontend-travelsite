<div class="clearfix bp-header margin-bottom-10" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
	<div class="col-license">
        <h1 class="text-highlight">
            <span property="v:itemreviewed"><?=$hotel['name']?></span>
            <span class="icon <?=get_icon_star($hotel['star'], true)?>"></span>
        </h1>
        <div class="col-info margin-bottom-5">
            <?=$hotel['location']?>
        </div>
        <div<?=!empty($review_page) ? ' class="hide"' : ''?>>
        <?=$review_overview?>
        </div>
	</div>

    <div class="col-price">
        <div class="clearfix text-right hotel-ids" data-id="<?=$hotel['id']?>">

            <div class="price-tag">
                <span class="text-price"><?=lang('lbl_us')?>&nbsp;</span>
                <span class="price-origin h-origin-<?=$hotel['id']?>"></span>
                <span class="price-from h-from-<?=$hotel['id']?>" style="display:none"><?=lang('na')?></span>
                <?=lang('per_room_night')?>
                <span class="price-tag-arrow"></span>
            </div>

     	</div>

     	<?php if(!empty($hotel['special_offers'])):?>
     	<div class="clearfix text-right hotel-header-promotion">
     		<?=$hotel['special_offers']?>
     	</div>
     	<?php endif;?>

        <div class="clearfix text-right margin-top-10">
            <?php if(!empty($review_page)):?>
            <a class="btn btn-green" href="<?=get_page_url($page, $hotel)?>"><?=lang('book_now')?></a>
            <?php else:?>
            <button class="btn btn-green" type="button" onclick="go_position('#hotel_rate')"><?=lang('book_now')?></button>
            <?php endif;?>
        </div>
    </div>
</div>