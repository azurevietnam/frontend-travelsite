<div class="bpt-similar">
    <h2 class="container text-highlight border-title-organe"><span class="icon icon-cruise-mekong-special margin-right-10"></span><?=$similar_title?></h2>
    <div class="container">
        <?php foreach ($cruises as $cruise):?>
       		<div class="col-xs-3 bpt-similar-item cruise-ids" data-id="<?=$cruise['id']?>">
        		<div class="bpt-similar-name bpt-similar-name-cruise text-left margin-bottom-10">
	        		<a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a>
	                <span class="icon <?=get_icon_star($cruise['star'])?>"></span>
               	</div>
               	<a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>">
                	<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture'], '265_177')?>" alt="<?=$cruise['name']?>">
               	</a>
                <div class="margin-top-10 text-left review-height">
                	<?=get_text_review($cruise, TOUR, true, true)?>
                </div>

                <div class="row">
                    <div class="col-xs-7 text-left">
                    	<span class="price-origin c-origin-<?=$cruise['id']?>"></span>
        				<span class="price-from c-from-<?=$cruise['id']?>"><?=lang('na')?></span>
        				<span class="c-unit-<?=$cruise['id']?>"  style="display:none;"><?=lang('per_pax')?></span>
                    </div>
                    <div class="col-xs-5 margin-top-5 text-right">
                        <a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>" class="btn btn-yellow btn-sm"><?=lang('book_now')?></a>
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
get_cruise_price_from();
equal_height('.bpt-similar-name');
</script>