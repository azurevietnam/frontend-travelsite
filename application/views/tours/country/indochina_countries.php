<div class="indochina-countries margin-top-30">
	<h2 class="text-highlight"><span class="icon icon-tour-green margin-right-5"></span><?=lang('title_indochina_tours')?></h2>
	<p><?=lang('lbl_destination_style_desc')?></p>
	<ul class="list-unstyled">
		<?php foreach ($indochina_destinations as $country):?>
		<?php if($country['id'] == $destination['id']) continue;?>
		<li>
            <a href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $country)?>">
			<img width=170 height="120" alt="<?=$country['name']?>" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $country['picture'], '220_165')?>" />
			</a>
			<div class="country">
				<a class="text-highlight country-name" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $country)?>"><?=lang_arg('title_tour_destination', $country['name'])?></a>

				<p><?=character_limiter($country['full_description'], 200)?></p>

				<?php foreach ($country['styles'] as $key => $style):?>
				<div class="country-style"> 
					<label class="text-special">&rsaquo;</label>
					<a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $country, $style)?>">
					<?php $style_name = !is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
                    <?=stripos($style_name, $country['name']) !== false ? $style_name : $country['name'].' '.$style_name?>
					</a>
				</div>
				<?php endforeach;?>
			</div>
		</li>
		<?php endforeach;?>
		
		<li>
            <a href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $indochina)?>">
            <?php if(!empty($indochina['picture'])):?>
            <img width=170 height="120" alt="<?=lang('multi_countries_tours')?>" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION, $indochina['picture'], '220_165')?>" />
            <?php else:?>
            <img width=170 height="120" alt="<?=lang('multi_countries_tours')?>" src="<?=get_static_resources('/media/tour/multi-countries.jpg')?>" />
            <?php endif;?>
            </a>
            <div class="country">
                <a class="text-highlight country-name" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $indochina)?>"><?=lang('multi_countries_tours')?></a>
			
    			<p><?=character_limiter($indochina['full_description'], 200)?></p>
    			
    			<?php foreach ($indochina['styles'] as $key => $style):?>
    			<div class="country-style"> 
    				<label class="text-special">&rsaquo;</label>
    				<a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $indochina, $style)?>">
    				<?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
    				</a>
    			</div>
                <?php endforeach;?>
            </div>
		</li>
	</ul>
</div>