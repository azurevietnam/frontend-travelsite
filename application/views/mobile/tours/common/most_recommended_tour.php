<div class="tour-ids" data-id="<?=$tour['id']?>" onclick="go_url('<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>')" style="position: relative;">
    <img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '450_300')?>" alt="<?=$tour['name']?>">
    <div class="flex-caption" style="display: block;">
        <h2><?=$tour['name']?></h2>
        <div class="clearfix">
            <div class="bpt-mb-item-price">
    			<span class="price-from text-special t-from-<?=$tour['id']?>"></span><span class="text-special"><?=lang('per_pax')?></span>
    		</div>
        </div>
    </div>
</div>