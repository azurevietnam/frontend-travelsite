 <div class="bpt-col-left pull-left">
    <?=$hotel_search_form?>

    <?=$why_use?>

    <?=$tripadvisor?>

    <?=$hotel_destinations?>

    <?=$faq_by_page?>

</div>
<div class="bpt-col-right pull-right">
    <?=$hotel_header?>

    <div class="photo-box hotel-slider-photo">
        <?=$photo_slider?>
    </div>

    <?php if(!empty($hotel['description'])):?>
        <?php $descriptions = str_replace("\n", "<br>", strip_tags($hotel['description']))?>
        <div class="margin-bottom-20 col-desc clearfix pull-left">
            <span id="short_desc">
                <?=content_shorten($descriptions, HOTEL_SHORT_DESCRIPTION_LENGTH)?>
                <?php if(fit_content_shortening($descriptions, HOTEL_SHORT_DESCRIPTION_LENGTH)):?>
                    <a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_more'))?> &raquo;</a>
                <?php endif;?>
            </span>
            <?php if(fit_content_shortening($descriptions, HOTEL_SHORT_DESCRIPTION_LENGTH)):?>
                <span id="full_desc">
    			<?=$descriptions?>
                    <a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_less'))?> &laquo;</a>
    			</span>
            <?php endif;?>
        </div>
    <?php endif;?>

    <?=$hotel_tab?>

    <?=$recommend_sevices?>

</div>



<script>
    get_hotel_price_from();

    // toggle description
    $('.btn-more').click(function() {
        if( $('#short_desc').is(":visible")) {
            $('#short_desc').hide();
            $('#full_desc').show();
        } else {
            $('#short_desc').show();
            $('#full_desc').hide();
        }
    });
</script>