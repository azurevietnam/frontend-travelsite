<!-- Top Tour Destinations -->
<div class="indochina container">
	<?php if (!empty($top_tour_des)):?>
		<h2 class="text-highlight popular-listing-tite">
			<span class="icon icon-tour-destination-special"></span>		
			<?=lang('top_tour_des')?>
		</h2>
		<ul class="list-unstyled popular-listing clearfix">
			<?php foreach ($top_tour_des as  $des):?>
				<li>
					<span class="text-special arrow-orange margin-right-5">›</span>
					<a title="<?=$des['name']?>" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $des)?>">
					<?=$des['name'].' '.ucfirst(lang('tours'))?></a>
				</li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
		
	<!-- 	Feature Hotel Destinations -->
	<?php if (!empty($top_hotel_des)):?>
		<h2 class="text-highlight margin-top-20 popular-listing-tite">
			<span class="icon icon-hotel-special"></span>		
			<?=lang('featured_hotel_des')?>
		</h2>
		<ul class="list-unstyled popular-listing clearfix">
			<?php foreach ($top_hotel_des as $des):?>
				<li>
					<span class="text-special arrow-orange margin-right-5">›</span>
					<a title="<?=$des['name']?>" href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $des)?>"><?=$des['name'].' '.ucfirst(lang("hotels"))?></a>
				</li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
	
	<!-- Popular Halong Bay Cruises -->
	<?php if (!empty($halongcruises)):?>
		<h2 class="text-highlight margin-top-20 popular-listing-tite">
			<span class="icon icon-cruise-halong-special"></span>		
			<?=lang('popular_halong_cruises')?>
		</h2>
		
		<ul class="list-unstyled popular-listing clearfix">
			<?php foreach ($halongcruises as $cruise):?>
				<li>
					<span class="text-special arrow-orange margin-right-5">›</span>
					<a title="<?=$cruise['name']?>" href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a>
					<?php if($cruise['is_new'] == 1):?>
						<span class="text-special">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
	
		
	<!-- Popular Mekong River Cruises -->
	<?php if (!empty($mekongcruises)):?>
		<h2 class="text-highlight margin-top-20 margin-bottom-20 popular-listing-tite">
			<span class="icon icon-cruise-mekong-special"></span>		
			<?=lang('popular_mekong_river_cruises')?>
		</h2>
		
		<ul class="list-unstyled popular-listing clearfix">
			<?php foreach ($mekongcruises as $cruise):?>
				<li>
					<span class="text-special arrow-orange margin-right-5">›</span>
					<a title="<?=$cruise['name']?>" href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a>
					<?php if($cruise['is_new'] == 1):?>
						<span class="text-special">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</li>
			<?php endforeach;?>
		</ul>
	<?php endif;?>
</div>