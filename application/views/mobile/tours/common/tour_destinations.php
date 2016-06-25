<div class="bpv-box margin-bottom-20">
<?php if($type == NAV_VIEW_CATEGORY):?>
    
    <a href="<?=site_url(TOUR_CATEGORY_PAGE)?>">
        <h3 class="box-heading no-margin">
            <?=lang('label_category_tours')?>
        </h3>
    </a>

	<div class="list-group bpv-list-group">

	    <?php foreach ($tour_categories as $k => $cat):?>
	    
		<a class="list-group-item<?=($k==0) ? ' no-border' : ''?>" href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>">
		    <span class="icon icon-arrow-right-blue"></span>
			<?=$cat['name']?>
            <?php if($cat['is_hot']):?>
            <img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
            <?php endif;?>
		</a>

		<?php endforeach;?>
		
    </div>

<?php else:?>

    <a href="<?=($type == NAV_VIEW_DOMESTIC) ? site_url(TOUR_DOMESTIC_PAGE) : site_url(TOUR_OUTBOUND_PAGE)?>">
        <h3 class="box-heading no-margin">
            <?=($type == NAV_VIEW_DOMESTIC) ? lang('label_domestic_tours') : lang('label_outbound_tours')?>
        </h3>
    </a>

	<div class="list-group bpv-list-group">
        
	    <?php foreach ($tour_destinations as $k => $des):?>
	    
		<a class="list-group-item<?=($k==0) ? ' no-border' : ''?>" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
		    <span class="icon icon-arrow-right-blue"></span> <?=$des['name']?>
		</a>

		<?php endforeach;?>
		
    </div>

<?php endif;?>
</div>