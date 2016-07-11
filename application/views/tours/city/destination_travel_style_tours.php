<?=$common_ad?>
<div class="bpt-col-left pull-left">
	<?=empty($common_ad)?  $tour_search_form : '<div class="searh-form-position">'. $tour_search_form .'</div>'?>

	<?=$why_use?>
	
	<?=$tripadvisor?>
	
	<?=$tour_categories?>
	
	<?=$top_tour_destinations?>
	
	<?=$destination_travel_guide?>
	
	<?=$faq_by_page?>
</div>
<div class="bpt-col-right pull-right">
    <?php if(!empty($best_of_country)):?>
    
    	<h2 class="text-highlight"><span class="icon icon-the-best"></span><?=lang_arg('lbl_top_the_best_country_tours', $destination['name'], date('Y'))?></h2>
    
        <div class="bpt-item-background clearfix padding-bottom-10 best-of-des">
        <?=$list_tours?>
        </div>
        
    <?php else:?>
    
        <?=!empty($most_recommended_tour) ? $most_recommended_tour : ''?>
    	
    	<?php $style_name = !is_symnonym_words($travel_style['name']) ? lang_arg('tour_travel_style', $travel_style['name']) : $travel_style['name'];?>
    	<h2 class="text-highlight">
    	<span class="icon icon-recommend"></span>
    	<?=stripos($style_name, $destination['name']) !== false ? lang('recommended').' '.$style_name : lang_arg('recommended_in', $style_name, $destination['name']);?>
    	</h2>
    	
    	<div class="pull-right bpt-item-background">
	    	<?=$list_tours?>
    	</div>
    <?php endif;?>
	
	<div style="clear: both; width: 100%; margin-top: 20px; float: left;">
	<?=$tailor_make_tour?>
	</div>
</div>
<script type="text/javascript">
get_tour_price_from();
</script>
