<div class="bpt-col-right pull-right">
    <?=$cruise_header?>
    
    <div id="tab_reviews" class="clearfix">
    <?=$customer_reviews?>
    </div>
    
    <div class="clearfix text-center">
    <a class="btn btn-yellow" href="<?=get_page_url($page, $cruise)?>"><?=lang('btn_book_this_cruise')?></a>
    </div>
</div>
<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>

	<?=$how_to_book_trip?>
	
	<?=$faq_by_page?>
</div>
<script>
$(function() {
	get_cruise_price_from();
})
</script>
