
<h2 class="bpv-color-title">
	<?=lang('popular_tour_destination')?>
</h2>

<div class="row popular-destinaton">
	
	<?php foreach ($popular_destinations as $k => $des):?>
	
           <div class="group-name bpv-collapse margin-top-2" data-target="<?='#group_'.$des['url_title']?>">
               <h3 class="heading">
              	 	<?=$des['name']?>
              	 	<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
               </h3>
           </div>
           
           <?php if(!empty($des['destinations'])):?>
           <div class="list-group" id="<?='group_'.$des['url_title']?>" style="display:none; margin-bottom:0px;">
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
</div>
<script>
	$('.group-name').bpvToggle();
</script>