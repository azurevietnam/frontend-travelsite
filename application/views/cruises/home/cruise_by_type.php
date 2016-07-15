<?=$common_ad?>
<div class="bpt-col-right pull-right cruise-by-type">
    <?=!empty($rich_snippet) ? $rich_snippet : ''?>

    <?php if(!empty($top_deals)):?>
    <div class="clearfix best-tours margin-bottom-20">
	   <h2 class="text-highlight"><span class="icon icon-deals margin-right-5"></span><?=$top_deals_title?></h2>
	   <div class="row"><?=$top_deals?></div>
	</div>
	<?php endif;?>

	<?php if(!empty($list_cruises)):?>
	<div class="clearfix">
    	<h2 class="text-highlight margin-bottom-10">
    	<span class="icon icon-recommend"></span><?=$recommended_title?>
    	</h2>
	</div>
	<?=$list_cruises?>
	<?php endif;?>
</div>
<div class="bpt-col-left pull-left">
	<?=empty($common_ad)?  $tour_search_form : '<div class="searh-form-position">'. $tour_search_form .'</div>'?>
	<?=$why_use?>

	<?=$tripadvisor?>

	<?=!empty($cruise_categories) ? $cruise_categories : ''?>
	
	<?=$destination_travel_guide?>

	<?=$faq_by_page?>
</div>

<script type="text/javascript">
get_cruise_price_from();
</script>