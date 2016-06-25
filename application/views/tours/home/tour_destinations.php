<div class="hero-item">
<?php if($type == NAV_VIEW_CATEGORY):?>
    
    <div class="list-group">
        
        <?php foreach ($tour_categories as $k => $cat):?>
        
        <?php if($k > 6) break;?>
        
        <a class="list-group-item item-enable" href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>" style="font-size: 13px">
           <?=$cat['name']?>
	       <?php if($cat['is_hot']):?>
	       <img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
	       <?php endif;?>
	       <span class="icon icon-arrow-right-b"></span>
        </a>
        
        <?php endforeach;?>
        
    </div>
    
<?php else:?>

    <div class="list-group">
        
        <?php foreach ($tour_destinations as $k => $des):?>
        
        <span class="list-group-item item-enable" onclick="go_url('<?=get_url(TOUR_DESTINATION_PAGE, $des)?>')">
           <span class="des-name"><?=$des['name']?></span> (<?=$des['is_outbound'] == TOUR_DOMESTIC ? $des['nr_tour_domistic'] : $des['nr_tour_outbound']?>)
           <span class="sub-des">
           <?php foreach ($des['destinations'] as $k => $highlight_des):?>
                <?php if($k > 2) break;?>
                <a href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>"><?=$highlight_des['name']?></a><?php if($k < 2) echo ','?>
           <?php endforeach;?>...
           </span>
           <span class="icon icon-arrow-right-b"></span>
        </span>
        
        <?php endforeach;?>
        
    </div>

<?php endif;?>
</div>