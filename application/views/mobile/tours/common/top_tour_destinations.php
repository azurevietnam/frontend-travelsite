<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin">
    <?php foreach($country_name as $c_id => $c_name):?>
        <?=$c_id == $destination['id'] ? lang_arg('title_city_tours', $c_name['name']) : ''?>
    <?php endforeach;?>
    </h3>
    <div class="list-group bpv-list-group">
    <?php foreach($country_name as $country_id => $country_name):?>
        
        <?php if($country_id != $destination['id']) continue;?>
        
        <?php foreach($destinations as $value) if($value['parent_id'] == $destination['id']):?>
            <a class="list-group-item" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $value)?>">
            <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
            <?=lang_arg('tour_travel_style', $value['name'])?>
            </a>
        <?php endif;?>
    <?php endforeach;?>
    </div>
</div>