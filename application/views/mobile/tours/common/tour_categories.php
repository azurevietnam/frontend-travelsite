<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin"><?=lang('lbl_tours_by_styles', $destination['name'])?></h3>
    <div class="list-group bpv-list-group">
        <a class="list-group-item" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $destination)?>">
        <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
        <?=lang_arg('all_tours_of_destination', $destination['name'])?>
        </a>
        
        <?php if(!empty($destination['styles'])):?>
        <?php foreach ($destination['styles'] as $style):?>
        <a class="list-group-item" href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
        <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
        <?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
        </a>
        <?php endforeach;?>
        <?php endif;?>
    </div>
</div>