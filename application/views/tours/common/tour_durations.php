<div class="bpv-filter-box">
	<h3 class="bpv-color-title">
		<span class="icon icon-circle-duration"></span> 
		<?=lang('filter_duration');?>
	</h3>
	
	<div class="list-group">
		<?php foreach($filter_durations as $value):?>
			<?php if($value['nr_tour'] >0):?>
				<a class="list-group-item item-enable a-link" href="<?=$value['search_link']?>">
					 <?=$value['label']?> (<?=$value['nr_tour']?>) 
					 <span class="icon icon-arrow-right-b pull-right"></span>
				</a>
			<?php endif;?>
		<?php endforeach;?>
	</div>
</div>