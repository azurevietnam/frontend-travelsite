<?//=$common_ad?>

<div class="bpt-col-right pull-right">
    <?=$list_hotels?>
</div>

<div class="bpt-col-left pull-left">
	<?=empty($common_ad)?  $hotel_search_form : '<div class="searh-form-position">'. $hotel_search_form .'</div>'?>
    
    <?=$hotel_destinations?>
    
    <?=$top_tour_destinations?>
    
    <?=$faq_by_page?>
</div>

<script>
    get_hotel_price_from();
</script>