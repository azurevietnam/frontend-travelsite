<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-depart"></span><?=lang('filter_departing');?>
	</h3>
	
	<div class="list-group">
		<?php foreach($departure_destinations as $k =>$des):?>
			<?php if($des['nr_tour'] > 0):?>
				<a class="list-group-item item-enable a-link" href="<?=$des['search_link']?>">
					 <?=$des['name']?> (<?=$des['nr_tour']?>)
					 <span class="icon icon-arrow-right-b pull-right"></span> 
				</a>
			<?php else:?>
				<div class="list-group-item"><?=$des['name']?> (0)</div>
			<?php endif;?>
		<?php endforeach;?>
	</div>
</div>