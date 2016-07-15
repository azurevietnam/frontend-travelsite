<?=!empty($rich_snippet) ? $rich_snippet : ''?>

<div class="bpt-mb-list margin-bottom-20">
	<h2 class="text-highlight"><?=lang_arg('lbl_best_of_destination_tours', $destination['name'], date('Y'))?></h2>
	<?=$top_recommended_tours?>
</div>
    
<div class="container margin-bottom-20">
    <?=$destination_travel_styles?>
</div>

<?=$tailor_make_tour?>

<script type="text/javascript">
	get_tour_price_from();   
</script>