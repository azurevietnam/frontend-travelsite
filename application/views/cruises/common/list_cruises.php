<div class="pull-right bpt-item-background">
<?php foreach ($cruises as $key => $cruise):?>

    <div class="bpt-item cruise-ids" data-id="<?=$cruise['id']?>">
        <div class="col-content">
	        <div class="col-img text-center">
	         <?php if ($is_enable_number == true):?>
	        	<?php if ($key == 0):?>
                    <div style="position:absolute; border-radius: 0px 13px 13px 0px; background-color:#b30000; width: 55px;margin-top:10px; height: 23px; font-size: 15px; color: yellow;"> No. <?=$key+1?></div>
				<?php else:?>
					<div style="position:absolute; border-radius: 0px 13px 13px 0px; background-color:#fda041; width: 55px;margin-top:10px; height: 23px; font-size: 15px; color: white;"> No. <?=$key+1?></div>
				<?php endif;?>
			<?php endif;?>
		        <a class="item-name" href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>">
					<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cruise['picture'], '210_140')?>"
							alt="<?=lang_arg('caption_halong_cruise', $cruise['name'])?>">
				</a>
				<div class="btn btn-green btn-xs btn-list" onclick="see_overview('<?=$cruise['url_title']?>', 'cruise', '<?=html_escape($cruise['name'])?>')"><?=lang('see_overview')?></div>

			</div>

        	<div class="col-info">
                <div class="margin-bottom-10" style="margin-top: -5px;">
	                <a class="item-name" href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a> &nbsp;
	                <?php $star_infor = get_star_infor_tour($cruise['star'], 0);?>
	                <span class="icon <?=get_icon_star($cruise['star'])?>" title="<?=$star_infor['title']?>"></span>

                	 <?php if($cruise['is_new'] == 1):?>
						<span class="text-special">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>

					<?php if (!empty($tour)):?>
						<span><?=get_partner_name($tour)?></span>
					<?php endif;?>
                </div>

            		<div class="row margin-bottom-5">
                		<div class="col-label text-unhighlight"><?=lang('cruise_type')?>:</div>
                	 	<div class="text-unhighlight col-text" style="padding-left: 0;"><?=get_cruise_type($cruise)?></div>
                	</div>

                <?php if($cruise['review_number'] > 0):?>
                	<div class="row margin-bottom-5">
                		<div class="col-label text-unhighlight"><?=lang('reviewscore')?>:</div>
                	 	<div class="col-text" style="padding-left: 0;"><?=get_text_review($cruise, CRUISE)?></div>
                	 </div>
                <?php endif;?>

            	<?php if(!empty($cruise['special_offers'])):?>
                	 <div class="margin-bottom-5">
                	 	<?=$cruise['special_offers']?>
                	 </div>
                <?php endif;?>

                <div class="text-unhighlight description">
                	<?=character_limiter(strip_tags($cruise['description']), CRUISE_DESCRIPTION_CHR_LIMIT)?>
    			</div>
        	</div>
		</div>

		<div class="col-price text-right">
			<div class = "item-from">
        		<?=lang('label_from')?>
        	</div>

        	<?php
        	   $price_origin = !empty($cruise['price']['price_origin']) ? show_usd_price($cruise['price']['price_origin']) : '';
        	   $price_from = !empty($cruise['price']['price_from']) ? show_usd_price($cruise['price']['price_from']) : lang('na');
        	?>

        	<div class="margin-bottom-10">
        		<span class="price-origin c-origin-<?=$cruise['id']?>"><?=$price_origin?></span>
        		<span class="price-from c-from-<?=$cruise['id']?>"><?=$price_from?></span>
        		<span class="item-from c-unit-<?=$cruise['id']?>" <?=empty($cruise['price']) ? 'style="display:none"' : ''?>><?=lang('per_pax')?></span>
        	</div>

        	<div class="margin-bottom-10">
        		<span class="icon icon-what-included"></span>
        		<a href="javascript:void(0)" class="what-included" data-placement="left" data-target="#what_included_<?=$cruise['id']?>" data-title="<?=$cruise['name']?>">
        			<?=lang('what_included')?> &raquo;
        		</a>

        		<div class="hide" id="what_included_<?=$cruise['id']?>">
				    <div class="row">
    				    <div class="col-xs-6">
    				        <h4><b><?=lang('price_included')?>:</b></h4>
    				    </div>
    				    <div class="col-xs-6">
    				        <h4><b><?=lang('price_excluded')?>:</b></h4>
    				    </div>
				    </div>

				    <div class="row">
				    	<div class="col-xs-6 c-includes-<?=$cruise['id']?>">

    				    </div>
    				    <div class="col-xs-6 c-excludes-<?=$cruise['id']?>">

    				    </div>
				    </div>
				</div>

        	</div>

            <div class="btn btn-sm btn-yellow margin-top-10" onclick="go_url('<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>')">
				<?=lang('select_cruise')?>
			</div>
        </div>
	</div>

<?php endforeach;?>
</div>
<?php if(isset($is_show_more) && $is_show_more):?>
<div id="more_cruises">
    <div class="text-center" id="more_cruises_btn">
        <button type="button" class="btn btn-default margin-bottom-10" data-link="<?=site_url('show-more-cruise-by-type').'/'?>" data-is_enable_number="<?=$is_enable_number?>" data-page="<?=$page?>" data-offset="10" id="btn_show_more_cruises">
            <span class="glyphicon glyphicon-triangle-bottom margin-right-5"></span><?=lang_arg('lbl_show_more', $page_title)?>
        </button>
        
        <script>
        load_more_cruise_tour_items('#more_cruises', '#btn_show_more_cruises');
        </script>
    </div>
</div>
<?php endif;?>
