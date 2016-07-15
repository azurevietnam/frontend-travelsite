<div class="bpt-similar">
    <h2 class="container text-highlight border-title-organe"><span class="icon icon-cruise-mekong-special margin-right-10"></span><?=$similar_title?></h2>
    <div class="container">
        <?php foreach ($tours as $tour):?>
	        <div class="col-xs-3 bpt-similar-item tour-ids" data-id="<?=$tour['id']?>">
				<div class="bpt-similar-name bpt-similar-name-tour text-left margin-bottom-10">
					<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a> &nbsp;
					<span class="icon <?=get_icon_star($tour['star'])?>"></span>
				</div>
	
				<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
					<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '265_177')?>" alt="<?=$tour['name']?>">
	            </a>
				<div class="margin-top-10 text-left review-height">
	                <?=get_text_review($tour, TOUR, true, true)?>
				</div>
	
				<div class="row">
	                <div class="col-xs-7 text-left">
	                 	<span class="price-origin t-origin-<?=$tour['id']?>"></span>
	        			<span class="price-from t-from-<?=$tour['id']?>"><?=lang('na')?></span>
	        			<span class="t-unit-<?=$tour['id']?>" style="display:none;"><?=lang('per_pax')?></span>
					</div>
					<div class="col-xs-5 text-right margin-top-5">
						<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>" class="btn btn-yellow btn-sm"><?=lang('book_now')?></a>
					</div>
				</div>
	        </div>
        <?php endforeach;?>

        <?php if(!empty($more_tour_text)):?>
    	<div class="more-tour text-right margin-top-10">
            <a class="link" href="<?=$more_tour_link?>"><?=$more_tour_text?></a><span class="arrow margin-right-5">&raquo;</span>
    	</div>
    	<?php endif;?>
    </div>
</div>
<script>
get_tour_price_from();
equal_height('.bpt-similar-name-tour');
</script>