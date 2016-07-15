<div class="clearfix margin-bottom-20">
    <div class="bp-header-img">
        <?=$photo_for_details?>
    </div>
    <div class="bp-header bp-header-tour tour-ids" data-id="<?=$tour['id']?>">
    	<div class="col-license">
    		<h2><b class="text-highlight"><?=$tour['name']?></b><?=get_partner_name($tour, PARTNER_CHR_LIMIT)?></h2>
    		
    		<?php if($tour['cruise_id']):?>
    		<div class="col-info margin-bottom-10">
    			<span class="col-label"><span class="icon icon-cruise-blue"></span><?=lang('cruise_ship')?>:</span>
    			
                <?php $cruise = array('url_title' => $tour['cruise_url_title'])?>
                
                <a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$tour['cruise_name']?></a>
                <span class="icon <?=get_icon_star($tour['star'])?>"></span>
                <?php if($tour['is_new'] == 1):?>
                    <span class="text-special"><?=lang('obj_new')?></span>
                <?php endif;?>
    		</div>
    		<?php endif;?>
    	</div>
    	
    	<div class="col-price">
            <div class="price-tag margin-bottom-10">
                <?=ucfirst(lang('label_from'))?>:
                <span class="text-price"><?=lang('lbl_us')?>&nbsp;</span>
                <span class="price-origin t-origin-<?=$tour['id']?>"></span>
                <span class="price-from t-from-<?=$tour['id']?>"><?=lang('na')?></span>
                <?=lang('per_pax')?>
                <span class="price-tag-arrow"></span>
            </div>
            <?php if(!empty($tour['special_offers'])):?>
	    		<div class="clearfix text-right cruise-header-promotion">
		    	    <span class="pull-right"><?=$tour['special_offers']?></span>
			    </div>
	    	<?php endif;?>				
    	</div>
    	
		<?php 
        	$icon = '<span class="icon icon-long-arrow-right-orange"></span>';
            $route = str_replace('-', $icon, $tour['route']);
        ?>
        
    	<div class="col-info margin-bottom-10">
            <span class="col-label"><span class="icon icon-destination-blue"></span><?=lang('cruise_destinations')?>:</span>
            <span class="col-content"><?=$route?></span>
    	</div>    		
    	
		<div class="col-info margin-bottom-10">
            <span class="col-label"><span class="icon icon-clock-blue"></span><?=lang('duration')?>:</span>
            <span><?=get_duration($tour['duration'])?></span>
            <span class="margin-left-5">
            <b>-&nbsp;&nbsp;</b> <span class="icon icon-group-tour"></span> <?=get_group_type($tour['group_type'])?>
            </span>
		</div>
		
		<div class="col-info margin-bottom-10 col-departure">
            <div class="col-label"><span class="icon icon-calendar-blue"></span><?=lang('label_departure')?>:</div>
            <div class="col-content">
    		<?php if(empty($tour['departure'])):?>
                <i><?=lang('lb_daily')?></i>
    		<?php else:?>
                <?php $departure_title = $tour['cruise_name'].' '.lang('departure_dates').' '.get_text_depart_year($tour['departure'])?>
                <?=get_departure_short($tour['departure'], $departure_title)?>

                <div class="hide" id="tour_departure">
                <div class="table-responsive">
                <?=get_departure_full($tour['departure']);?>
                </div>
                </div>
                <script type="text/javascript">
                	set_popover('.tour_departure');
                </script>
    	    <?php endif;?>
    	    </div>
    	</div>
		
		<?=$review_overview?>
    	
    	<div class="margin-top-10 col-desc clearfix pull-left"><?=$tour['brief_description']?></div>
    	
    	<?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
    	<div class="clearfix pull-right margin-top-10 margin-right-10">
			<div class="btn btn-lg btn-green" onclick="go_url('/customize-tours/<?=$tour['url_title']?>/')">
			<?=lang('label_customize_this_tour')?> <span class="glyphicon glyphicon-circle-arrow-right"></span>
			</div>
		</div>
		<?php endif;?>
    </div>
</div>
