<?php if(!empty($attractions)):?>
<h2 class="text-highlight margin-top-20">
<span class="icon icon-attraction"></span>
<?=lang_arg('lbl_top_attractions_in_destination', $destination['name'])?>
</h2>
<p><?=lang('lbl_destination_style_desc')?></p>
<div class="cities margin-bottom-40">
	<?php foreach ($attractions as $value):?>
	<div class="city-grid">
        <img width="120" height="80" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $value['picture'], '135_90')?>" 
                    alt="<?=lang_arg('title_tour_destination', $value['name'])?>" class="pull-left margin-right-10">
        <div class="pull-left">
            <a href="<?=get_page_url(DESTINATION_ATTRACTION_PAGE, $value)?>"><?=$value['name']?></a>
            <div class="clearfix margin-top-5 city-desc"><?=character_limiter(strip_tags($value['short_description']), 50)?></div>
            <div class="clearfix text-highlight margin-top-10"><b><?=$value['number_tours'].' '.lang('tours')?></b></div>
        </div>
        <span class="glyphicon glyphicon-chevron-right"></span>
	</div>
	<?php endforeach;?>
	<div class="margin-top-10 show-more">
        <a href="<?=get_page_url(DESTINATION_ATTRACTION_PAGE, $destination)?>">
        <?=lang_arg('lbl_more_attraction_in_destination', $destination['name'])?> &raquo;
        </a>
	</div>
</div>
<?php endif;?>