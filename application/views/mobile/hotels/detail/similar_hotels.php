<div class="bpt-mb-list margin-top-15">
    <h2><?=lang('field_similar_hotel', $hotel_desc['name'])?></h2>
    <?=$list_hotels?>
    <div class="text-center margin-bottom-15 container">
        <a class="btn btn-default col-xs-12 margin-top-15" href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $destination)?>"><?=lang('field_more_hotel_in', $destination['name'])?> <span class="icon icon-arrow-right-blue-sm margin-left-5"></span></a>
    </div>
</div>