<div class="bpt-tour-destinations">
				<div class="filtertip">
					<div class="padding20"> 						
						<h2 class="title"><span class="icon icon-top-tour"></span><?=lang('label_top_tour_destination')?></h2>
					</div>
					<div class="tip-arrow" style="bottom: -9px;"></div>
				</div>
    <?php foreach($country_name as $country_id => $country_name):?>
        <div class="country clearfix">
            <div class="margin-bottom-10"><a href="<?=$country_id == VIETNAM ? get_page_url(VN_TOUR_PAGE) : get_page_url(TOURS_BY_DESTINATION_PAGE, $country_name)?>"> <span class="icon <?=$country_flag[$country_id]?>"></span><?=strtoupper(lang_arg('tour_travel_style', $country_name['name']))?> </a></div>
            <?php foreach($destinations as $value) if($value['parent_id'] == $country_id):?>
                <div class="col-xs-6 margin-bottom-10 padding-left-0">
                    <div>
                        <a href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $value)?>">
                            <?=lang_arg('tour_travel_style', $value['name'])?>
                        </a>
                    </div>
                    <div class="number-tours">
                        <?=lang_arg('tour_travel_style', $value['number_tours'])?>
                    </div>
                </div>
            <?php endif;?>
        </div>
    <?php endforeach;?>
</div>

