<div class="bpv-tour-destination">
	<div class="bpv-color-title title" style="background-color: #F4F4F4; font-weight: bold; padding: 0px 10px; margin-bottom: 0">
        <?php if($type == NAV_VIEW_DOMESTIC):?>
        <span class="icon icon-domestic-tour"></span><a style="font-size: 16px" class="bpv-color-title" href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"><?=lang('label_domestic_tours')?></a>
        <?php elseif ($type == NAV_VIEW_OUTBOUND):?>
        <span class="icon icon-outbound-tour"></span><a style="font-size: 16px" class="bpv-color-title" href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"><?=lang('label_outbound_tours')?></a>
        <?php elseif ($type == NAV_VIEW_CATEGORY):?>
        <span class="icon icon-suitcase"></span><a style="font-size: 16px" class="bpv-color-title" href="<?=site_url(TOUR_CATEGORY_PAGE)?>"><?=lang('label_category_tours')?></a>
        <?php endif;?>
   </div>
   
   <?php if($type == NAV_VIEW_CATEGORY):?>
   
       <div class="list-group">
    	    <?php foreach ($tour_categories as $cat):?>    
    		<a class="list-group-item item-enable" href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>">
    	       <?=$cat['name']?>
    	       <?php if($cat['is_hot']):?>
    	       <img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
    	       <?php endif;?>
    	       <span class="icon icon-arrow-right-b"></span>
    	    </a>
    		<?php endforeach;?>
    	</div>
   
   <?php else:?>
   
        <?php foreach ($tour_destinations as $k => $des):?>
           <div class="group-name" data-target="<?='#group_'.$des['url_title']?>" style="padding: 5px 10px">
               <span class="icon <?=$k == 0 ? 'icon-arrow-right-sm icon-arrow-right-sm-down' : 'icon-arrow-right-sm'?> bpv-toggle-icon"></span>
               <?=$des['name']?>
           </div>
           
           <?php if(!empty($des['destinations'])):?>
           <div class="list-group" id="<?='group_'.$des['url_title']?>" <?php if($k>0) echo'style="display:none"'?>>
               <a class="list-group-item item-enable" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
                   <?=lang('label_departing').$des['name']?> (<?=$des['is_outbound'] == TOUR_DOMESTIC ? $des['nr_tour_domistic'] : $des['nr_tour_outbound']?>)
                   <span class="icon icon-arrow-right-b"></span>
               </a>
               
               <?php foreach ($des['destinations'] as $highlight_des):?>
               <a class="list-group-item item-enable" href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>">
                   <?=$highlight_des['name']?> (<?=$highlight_des['is_outbound'] == TOUR_DOMESTIC ? $highlight_des['nr_tour_domistic'] : $highlight_des['nr_tour_outbound']?>)
                   <span class="icon icon-arrow-right-b"></span>
               </a>
               <?php endforeach;?>
           </div>
        
           <?php endif;?>
           
        <?php endforeach;?>
   
   <?php endif;?>

</div>