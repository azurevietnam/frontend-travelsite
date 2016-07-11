<?=$tour_header?>

<div class="bpt-col-left pull-left">
    <?=$itinerary_overview?>
    
	<?=$how_to_book_trip?>
	
	<?=$similar_tours_side?>
	
	<?=$faq_by_page?>
</div>
<div class="bpt-col-right pull-right">
    <?=$trip_highlights?>

	<?=$tour_tab?>

	<?=$recommend_sevices?>
</div>

<script>
<?php if($is_review_on):?>
show_review_tab();
<?php endif;?>

get_tour_price_from();

init_tour_detail();
</script>
