<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin"><?=lang('title_indochina_tours')?></h3>
    <div class="list-group bpv-list-group">
        <?php foreach ($indochina_destinations as $country):?>
        <?php if($country['id'] == $destination['id']) continue;?>
        <a class="list-group-item" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $country)?>">
            <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
            <?=lang_arg('title_tour_destination', $country['name'])?>
		</a>
        <?php endforeach;?>
        <a class="list-group-item" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $indochina)?>">
            <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
            <?=lang('multi_countries_tours')?>
        </a>
    </div>
</div>