<?php if(!empty($photo_maps)):?>
<div class="photo-map margin-bottom-20">
    <h2 class="text-highlight"><?=lang('lbl_tour_map')?></h2>
    <img class="img-responsive" src="<?=$photo_maps[0]['src']?>" alt="<?=$photo_maps[0]['caption']?>">
    <div class="photo-map-bottom">
        <div class="btn btn-green btn-sm" onclick="expand_route_map('#tour_map_area')"><?=lang('btn_view_map')?></div>
    </div>
</div>
<?php endif;?>