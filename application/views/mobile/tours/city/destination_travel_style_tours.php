<?php if(empty($common_ad) && !empty($most_recommended_tour)):?>
    <?=$most_recommended_tour?>
<?php endif;?>
<div class="bpt-mb-list margin-bottom-20">
    <h2 class="text-highlight">
    <?php if(!empty($best_of_country)):?>
        <?=lang_arg('lbl_top_the_best_country_tours', $destination['name'], date('Y'))?>
    <?php else:?>
    	<?php $style_name = !is_symnonym_words($travel_style['name']) ? lang_arg('tour_travel_style', $travel_style['name']) : $travel_style['name'];?>
    	<?=lang_arg('recommended_in', $style_name, $destination['name'])?>
    <?php endif;?>
    </h2>
	
	<?=$list_tours?>
</div>

<div class="container">
    <?=$tour_categories?>
</div>

<?=$tailor_make_tour?>

<script type="text/javascript">
	get_tour_price_from();   
</script>