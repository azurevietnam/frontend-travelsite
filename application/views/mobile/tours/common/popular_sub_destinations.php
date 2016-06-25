<div class="bpv-box margin-bottom-20">
	<h3 class="box-heading no-margin">
    	<?=lang('popular_tour_destination');?>
    </h3>
	
	<div class="list-group bpv-list-group">
        
	    <?php foreach($sub_destinations as $des):?>
	    
		<a class="list-group-item item-enable a-link" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
		    <?=$des['name']?>
			<?php if($des['nr_tour_domistic'] > 0):?>
				(<?=$des['nr_tour_domistic']?>)
			<?php elseif($des['nr_tour_outbound'] > 0):?>
				(<?=$des['nr_tour_outbound']?>)
			<?php endif;?>
			<span class="icon icon-arrow-right-b pull-right"></span> 
		</a>

		<?php endforeach;?>
		
    </div>
	
</div>