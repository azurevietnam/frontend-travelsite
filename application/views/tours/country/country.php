<?=!empty($rich_snippet) ? $rich_snippet : ''?>

<?=$common_ad?>

<div class="bpt-col-left pull-left">
	<?=empty($common_ad)?  $tour_search_form : '<div class="searh-form-position">'. $tour_search_form .'</div>'?>
	
    <?=$top_tour_destinations?>

    <?=$destination_travel_guide?>

	<?=$faq_by_page?>
</div>
<div class="bpt-col-right pull-right">
	<div class="best-tours">
    	<h2 class="text-special line-border"><span class="icon icon-the-best"></span><?=lang_arg('lbl_best_of_destination_tours', $destination['name'], date('Y'))?></h2>
    	<div class="row">
            <?=$top_recommended_tours?>
    	</div>
    </div>

	<?=$destination_travel_styles?>

	<?=$tailor_make_tour?>

	<?=$indochina_countries?>
</div>

<script type="text/javascript">
	get_tour_price_from();

	// set tooltip
	var options = { placement: 'top' }
    $('[data-toggle="tooltip"]').tooltip(options);   
</script>