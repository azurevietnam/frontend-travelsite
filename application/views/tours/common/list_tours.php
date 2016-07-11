<?php if(!empty($tours)):?>
	<?php foreach ($tours as $key => $tour):?>
        <div class="bpt-item tour-ids" data-id="<?=$tour['id']?>">
	            <div class="col-content">
                    <div class="col-img text-center">
                    <?php if (!empty($is_enable_number)):?>
                    <?php if ($key == 0):?>
	                    <div style="position:absolute; border-radius: 0px 13px 13px 0px; background-color:#b30000; width: 55px;margin-top:10px; height: 23px; font-size: 15px; color: yellow;"> No. <?=$key+1?></div>
					<?php else:?>
						<div style="position:absolute; border-radius: 0px 13px 13px 0px; background-color:#fda041; width: 55px;margin-top:10px; height: 23px; font-size: 15px; color: white;"> No. <?=$key+1?></div>
					<?php endif;?>
					<?php endif;?>
                        <a class="item-name" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
                        	<img class="img-responsive" alt="<?=$tour['name']?>" title="<?=$tour['name']?>" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour['picture'], '210_140')?>"/>
                        </a>

                        <div class="btn btn-green btn-xs btn-list" onclick="see_overview('<?=$tour['url_title']?>', 'tour', '<?=html_escape($tour['name'])?>')"><?=lang('see_overview')?></div>
                    </div>

                    <div class="col-info">
                    	<div style="margin-top: -5px;">
                    		<a class="item-name" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=$tour['name']?></a>
                    	</div>
                    	<?php if(!empty($tour['cruise_id'])):?>
                    	<div class="row margin-bottom-5">
                            <?php $cruise_obj['url_title'] = url_title($tour['cruise_url_title']);?>
							<div class="text-unhighlight col-label"><?=lang('cruise_ship')?>:</div>
							<div class="col-text">
								<a  href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise_obj)?>"><?=$tour['cruise_name']?></a>
									<?php $star_infor = get_star_infor_tour($tour['star'], 0);?>
								<span class="icon <?=get_icon_star($tour['star'])?>" title="<?=$star_infor['title']?>"></span>
								<?php if($tour['is_new'] == 1):?>
									<span class="text-special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
								<?php endif;?>
							</div>
						</div>
						<?php endif;?>

                        <div class="row margin-bottom-5 margin-top-10">
	                        <div class="text-unhighlight col-label"><?=lang('cruise_destinations')?>: </div>
	                        <div class="text-unhighlight col-text" style="padding-left: 0;"> <?=$tour['route']?></div>
                        </div>

                        <?php if($tour['review_number'] > 0):?>
                        <div class="row margin-bottom-5">

	                        	<div class="text-unhighlight col-label"><?=lang('reviewscore')?>:</div>
	                        	<div class="col-text" style="padding-left: 0;"> <?=get_text_review($tour, TOUR)?></div>

	                     </div>
	                     <?php endif;?>

	                     <?php if(!empty($tour['special_offers'])):?>
	                     <div class="margin-bottom-5">
	                        <?=$tour['special_offers']?>
                         </div>
                         <?php endif;?>

                        <div class="text-unhighlight description">
                        	<?=character_limiter(strip_tags($tour['brief_description']), TOUR_DESCRIPTION_CHR_LIMIT)?>
                        </div>

                        <?php if(!empty($tour['most_rec_service'])):?>

                        	<?=$tour['most_rec_service']?>

                        <?php endif;?>
                    </div>

	            </div>

	            <div class="col-price text-right">
		            <div class = "item-from">
	        			<?=lang('label_from')?>
	        		</div>
	            	<div class="margin-bottom-10">
		        		<span class="price-origin t-origin-<?=$tour['id']?>">
		        			<?php if(!empty($tour['price']) && $tour['price']['price_origin'] != $tour['price']['price_from']):?>
		        				<?=show_usd_price($tour['price']['price_origin'])?>
		        			<?php endif;?>
		        		</span>
		        		<span class="price-from t-from-<?=$tour['id']?>">
		        			<?php if(!empty($tour['price']['price_from'])):?>
		        				<?=show_usd_price($tour['price']['price_from'])?>
		        			<?php else:?>
		        				<?=lang('na')?>
		        			<?php endif;?>
		        		</span>
		        		<span class="item-from t-unit-<?=$tour['id']?>" <?=empty($tour['price']) ? 'style="display:none"' : ''?>><?=lang('per_pax')?></span>
		        	</div>

                	<div class="margin-bottom-10">
	    				<span class="icon icon-what-included"></span>
	    				<a href="javascript:void(0)" class="what-included" data-placement="left" data-target="#what_included_<?=$tour['id']?>" data-title="<?=$tour['name']?>">
	    					<?=lang('what_included')?> &raquo;
	    				</a>
	    			</div>

					<div class="hide margin-bottom-10" id="what_included_<?=$tour['id']?>">
					    <div class="row">
	    				    <div class="col-xs-6">
	    				        <h4><b><?=lang('price_included')?>:</b></h4>
	    				    </div>
	    				    <div class="col-xs-6">
	    				        <h4><b><?=lang('price_excluded')?>:</b></h4>
	    				    </div>
					    </div>

					    <div class="row">
					    	<div class="col-xs-6">
					    		<?=generate_string_to_list($tour['includes'], 'bpt-list-standard')?>
					    	</div>
					    	<div class="col-xs-6">
					    		<?=generate_string_to_list($tour['excludes'], 'bpt-list-standard')?>
					    	</div>
					    </div>

					</div>

					<a class="btn btn-sm btn-yellow margin-top-10" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>"><?=lang('select_tour')?>
					</a>
	            </div>
        </div>
	<?php endforeach;?>

<?php if(isset($is_show_more) && $is_show_more):?>
<div id="more_tours">
    <div id="more_tours_btn">
        <?php $style_name = !is_symnonym_words($travel_style['name']) ? lang_arg('tour_travel_style', $travel_style['name']) : $travel_style['name'];?>
        <button type="button" class="btn btn-default clearfix margin-bottom-10 margin-top-10 col-xs-offset-4" data-link="<?=site_url('show-more-tours').'/'?>"
            data-destination="<?=$destination['id']?>" data-style="<?=$travel_style['id']?>" data-is_enable_number="<?=$is_enable_number?>" data-offset="10"
            id="btn_show_more_tours" data-loading-text="<?=lang('label_loading')?>..."><span class="glyphicon glyphicon-triangle-bottom"></span> <?=lang_arg('lbl_show_more', '<b>'.$destination['name'].' '.$style_name.'</b>')?>
        </button>
        <script>
        load_more_cruise_tour_items('#more_tours', '#btn_show_more_tours');
        </script>
    </div>
</div>
<?php endif;?>

<script type="text/javascript">
	set_popover('.what-included');
	load_arrow_offer('.bpt-item');
</script>
<?php endif;?>