<?php if(!empty($tours)):?>
<?php foreach ($tours as $tour):?>
    <div class="bpt-mb-item clearfix tour-ids" data-id="<?=$tour['id']?>" onclick="go_url('<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>')">
        <img class="bpt-mb-item-image pull-left" alt="<?=$tour['name']?>" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '265_177')?>">
        
        <div class="bpt-mb-item-name"><?=$tour['name']?></div>
        
        <div class="bpt-mb-item-price">
			<span class="price-from t-from-<?=$tour['id']?>">
                <?php if(!empty($tour['price']['price_from'])):?>
    				<?=show_usd_price($tour['price']['price_from'])?>
    			<?php else:?>
    				<?=lang('na')?>
    			<?php endif;?>
			</span>
			<span><?=lang('per_pax')?></span>
		</div>
		
		<?php if(!empty($tour['review_number'])):?>
		<div class="bpt-mb-item-review margin-top-5"><?=get_text_review($tour, TOUR, false)?></div>
		<?php endif?>
    </div>
<?php endforeach;?>

<?php if(isset($is_show_more) && $is_show_more):?>
<div id="more_tours">
    <div id="more_tours_btn">
        <?php $style_name = !is_symnonym_words($travel_style['name']) ? lang_arg('tour_travel_style', $travel_style['name']) : $travel_style['name'];?>
        <div class="container">
            <button class="btn btn-default btn-block btn-show-more" data-link="<?=site_url('show-more-tours').'/'?>"
                data-destination="<?=$destination['id']?>" data-style="<?=$travel_style['id']?>" data-is_enable_number="<?=$is_enable_number?>" 
                data-offset="10" rel="nofollow" id="btn_show_more_tours">
                <span class="glyphicon glyphicon-triangle-bottom"></span>
                <?=lang_arg('lbl_show_more', '<b>'.$destination['name'].' '.$style_name.'</b>')?>
            </button>
        </div>
        <script>
        load_more_cruise_tour_items('#more_tours', '#btn_show_more_tours');
        </script>
    </div>
</div>
<?php endif;?>

<?php endif;?>