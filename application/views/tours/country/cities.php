<?php if(!empty($cities)):?>
<div class="clearfix margin-top-20" style="clear: both; display: block;">
<h2 class="text-highlight"><?=lang_arg('title_city_tours', $destination['name'])?></h2>
<p><?=lang('lbl_destination_style_desc')?></p>
<div class="cities">
	<?php foreach ($cities as $city):?>
	<div class="city-grid" onclick="go_url('<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $city)?>')">
        <img width="120" height="80" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $city['picture'], '135_90')?>" 
                    alt="<?=lang_arg('title_tour_destination', $city['name'])?>" class="pull-left margin-right-10">
        <div class="pull-left">
            <a href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $city)?>"><?=lang_arg('title_tour_destination', $city['name'])?></a>
            <div class="clearfix margin-top-5 city-desc"><?=character_limiter(strip_tags($city['full_description']), 40)?></div>
            <div class="clearfix text-highlight margin-top-10"><b><?=$city['number_tours'].' '.lang('tours')?></b></div>
        </div>
        <span class="glyphicon glyphicon-chevron-right"></span>
	</div>
	<?php endforeach;?>
</div>
</div>
<?php endif;?>
