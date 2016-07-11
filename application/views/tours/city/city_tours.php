<?=$common_ad?>
<div class="bpt-col-left pull-left">
	<?=empty($common_ad)?  $tour_search_form : '<div class="searh-form-position">'. $tour_search_form .'</div>'?>
	
	<?=$why_use?>

	<?=$tripadvisor?>

    <?=$recommendations?>

    <?=$top_tour_destinations?>

    <?=$destination_travel_guide?>

	<?=$faq_by_page?>
</div>
<div class="bpt-col-right pull-right">
    <?=!empty($rich_snippet) ? $rich_snippet : ''?>

	<?php if(!empty($top_recommended_tours)):?>
	<div class="best-tours">
    	<h2 class="text-special line-border"><span class="icon icon-best-of-lg"></span><?=lang_arg('lbl_best_of_destination_tours', $destination['name'], date('Y'))?></h2>
    	<div class="row">
            <?=$top_recommended_tours?>
    	</div>
    </div>
    <?php elseif (!empty($list_tours)):?>
    <h2 class="text-highlight"><?=lang_arg('title_recommend_tours_of_destination', $destination['name'])?></h2>
    <div class="pull-right bpt-item-background margin-bottom-20">
        <?=$list_tours?>
    </div>
    <?php endif;?>

	<?=$destination_travel_styles?>

	<?=$tailor_make_tour?>

	<?=!empty($city_travel_styles) ? $city_travel_styles : ''?>
</div>

<script type="text/javascript">
	get_tour_price_from();

	load_arrow_offer('#luxury .bpt-item', true);
	
	$('#tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		load_arrow_offer('.active .bpt-item', true);
	})
</script>
