<div class="bpv-newbox">
	<h3>
		<?=lang('popular_tour_destination')?>
	</h3>
	
	<div class="row popular-destinaton">
		<div class="col-xs-4">
			
			<?php foreach($popular_destinations as $key=>$des):?>
			
				<?php if(($key + 1)%3 == 1):?>
				
				<div class="list-group" >
					<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
						<?=$des['name']?> (<?=$is_domistic ? $des['nr_tour_domistic'] : $des['nr_tour_outbound']?>)
					</a> 
					<?php if(!empty($des['destinations'])):?>
						<?php foreach ($des['destinations'] as $highlight_des):?>
								
							<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>">
								<?=$highlight_des['name']?> (<?=$is_domistic ? $highlight_des['nr_tour_domistic'] : $highlight_des['nr_tour_outbound']?>)
								 <span class="icon icon-arrow-right-b pull-right"></span> 
							</a> 
							
						<?php endforeach;?>
					<?php endif;?>
				</div>
				
				<?php endif;?>
			<?php endforeach;?>
				
		</div>
		
		<div class="col-xs-4">
			
			<?php foreach($popular_destinations as $key=>$des):?>
			
				<?php if(($key + 1)%3 == 2):?>
				
				<div class="list-group" >
					<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
						<?=$des['name']?> (<?=$is_domistic ? $des['nr_tour_domistic'] : $des['nr_tour_outbound']?>)
					</a> 
					<?php if(!empty($des['destinations'])):?>
						<?php foreach ($des['destinations'] as $highlight_des):?>
								
							<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>">
								<?=$highlight_des['name']?> (<?=$is_domistic ? $highlight_des['nr_tour_domistic'] : $highlight_des['nr_tour_outbound']?>)
								 <span class="icon icon-arrow-right-b pull-right"></span> 
							</a> 
							
						<?php endforeach;?>
					<?php endif;?>
				</div>
				
				<?php endif;?>
			<?php endforeach;?>
				
		</div>
		
		<div class="col-xs-4">
			
			<?php foreach($popular_destinations as $key=>$des):?>
			
				<?php if(($key + 1)%3 == 0):?>
				
				<div class="list-group" >
					<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>">
						<?=$des['name']?> (<?=$is_domistic ? $des['nr_tour_domistic'] : $des['nr_tour_outbound']?>)
					</a> 
					<?php if(!empty($des['destinations'])):?>
						<?php foreach ($des['destinations'] as $highlight_des):?>
								
							<a class="list-group-item" href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>">
								<?=$highlight_des['name']?> (<?=$is_domistic ? $highlight_des['nr_tour_domistic'] : $highlight_des['nr_tour_outbound']?>)
								 <span class="icon icon-arrow-right-b pull-right"></span> 
							</a> 
							
						<?php endforeach;?>
					<?php endif;?>
				</div>
				
				<?php endif;?>
			<?php endforeach;?>
				
		</div>
	</div>
</div>