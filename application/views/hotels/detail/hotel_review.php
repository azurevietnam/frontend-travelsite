<div class="bpt-col-right pull-right">
    <?=$hotel_header?>

    <div id="tab_reviews">
    <?=$customer_reviews?>
    </div>

    <?=$recommend_sevices?>

    <div class="clearfix text-center">
    <a class="btn btn-yellow" href="<?=get_page_url($page, $hotel)?>"><?=lang('btn_book_this_hotel')?></a>
    </div>
</div>
<div class="bpt-col-left pull-left">
	<?=$hotel_search_form?>

	<?=$how_to_book_trip?>

	<?=$faq_by_page?>
</div>
<script>
$(function() {
	get_hotel_price_from();
})
</script>
