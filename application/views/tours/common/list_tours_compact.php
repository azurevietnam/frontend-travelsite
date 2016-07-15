<?php if(!empty($tours)):?>
<?php foreach ($tours as $key => $tour):?>
<div class="bpt-item-compact tour-ids" data-id="<?=$tour['id']?>">
    <div class="col-img">
        <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
        	<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '135_90')?>" alt="<?=$tour['name']?>" title="<?=$tour['name']?>"/>
    	</a>
    </div>
    
    <div class="col-content">
        <div class="item-name">
        	<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
        </div>
          <div class="text-unhighlight margin-top-5">
        	<?=$tour['route']?>
        </div>
        <?php if(!empty($tour['review_number'])):?>
	        <div class="text-unhighlight margin-top-5">
	        	<?=lang('reviewscore')?>: <?=get_text_review($tour)?>
	        </div>
        <?php endif;?>
        <div class="margin-top-5 hide <?=$tour['id'].'block_text_promotion'?>">
        	<?=lang('special_offers')?>: <span class="<?=$tour['id'].'text_promotion'?>"></span>
        </div>
    </div>
    
    <div class="col-price">
    	<div class="item-from text-unhighlight from <?=$tour['id'].'from_label'?>"><?=lang('bt_from')?></div>
    	<div>
			<span class="price-origin t-origin-<?=$tour['id']?>"></span>
			<span class="price-from t-from-<?=$tour['id']?>"><?=lang('na')?></span>
			<?=lang('per_pax')?>
		</div>	 
    </div>
    
    <div class="col-book">
        <a class="btn btn-green btn-sm" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=lang('book_now')?></a>
    </div>
</div>
<?php endforeach;?>
<?php endif;?>