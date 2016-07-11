<div class="bpt-col-right pull-right">
    <?=!empty($rich_snippet) ? $rich_snippet : ''?>
    
	<?=$today_hot_deal?>
	
	<?php if(!empty($top_deals)):?>
	<div class="clearfix best-tours margin-bottom-20">
	   <h2 class="text-special"><span class="icon icon-best-of-lg margin-right-5"></span><?=$top_deals_title?></h2>
	   <div class="row">
	   <?=$top_deals?>
	   </div>
	</div>
	<?php endif;?>
	
	<?=!empty($cruise_categories) ? $cruise_categories : ''?>
	
	<?=$most_recommended_cruises?>
</div>
<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>
	
	<?=$why_use?>
	
	<?=$tripadvisor?>
	
	<?=$recommendations?>
	
	<?=$top_tour_destinations?>
	
	<?=$destination_travel_guide?>
	
	<?=$faq_by_page?>
</div>

<script type="text/javascript">
	get_cruise_price_from();
</script>
