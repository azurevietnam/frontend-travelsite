<div class="bpv-search-overview">

	<h2><?=lang('my_search_label')?></h2>
	
	<div class="content clearfix">
	
	    <?php
            $departing_txt = get_tour_search_overview($search_criteria);
            $departure_txt = get_tour_search_overview($search_criteria, 'duration'); 
		?>
	
	    <?php if(!empty($departing_txt)):?>
		<div class="margin-bottom-10">
			<span class="icon icon-tour-sm"></span> <?=get_tour_search_overview($search_criteria)?>
		</div>
		<?php endif;?>
		
		<?php if(!empty($departure_txt)):?>
		<div class="margin-bottom-20">
			<span class="icon icon-calendar-sm"></span> <?=$departure_txt?>
		</div>
		<?php endif;?>
		
		<button type="button" class="btn btn-bpv btn-search pull-right" onclick="change_search()">
	  		<?=lang('btn_change_search')?>
	  	</button>
	</div>
	
</div>