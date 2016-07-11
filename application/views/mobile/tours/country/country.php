<?=!empty($rich_snippet) ? $rich_snippet : ''?>

<div class="bpt-mb-list margin-bottom-20">
	<h2 class="text-highlight"><?=lang_arg('lbl_best_of_destination_tours', $destination['name'], date('Y'))?></h2>
	<?=$top_recommended_tours?>
</div>
    
<div class="container">
    <?=$destination_travel_styles?>
    
    <?=$top_tour_destinations?>
    
    <?=$indochina_countries?>
    
    <?=$tailor_make_tour?>
</div>

<script type="text/javascript">
	get_tour_price_from();   
</script>