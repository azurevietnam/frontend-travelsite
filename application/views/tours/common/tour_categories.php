<!-- Tour Destination Travel Styles -->
<div class="bpt-left-block tour-destination-styles">
    <h2 class="title text-highlight"><span class="icon icon-like-green margin-right-5"></span><?=lang('lbl_tours_by_styles', $destination['name'])?></h2>
  	<ul class="list-unstyled">
        <li>
            <span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
            <a href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $destination)?>"><?=lang_arg('all_tours_of_destination', $destination['name'])?></a>
        </li>

        <?php if(!empty($destination['styles'])):?>
        <?php foreach ($destination['styles'] as $style):?>
        <li <?=$style['url_title'] == $selected_style_id ? 'class="active"' : ''?>>
            <span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
            <a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
                <?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
            </a>
        </li>
        <?php endforeach;?>
        <?php endif;?>
	</ul>
</div>