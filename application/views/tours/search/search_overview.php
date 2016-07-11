<div class="search-overview">
	<h2 class="text-highlight">
		<?=lang('lbl_search_overview')?>
	</h2>
	
	<div class="row">
		<div class="col-xs-5"><?=lang('destination')?>:</div>
		<div class="col-xs-7"><label><?=$search_criteria['destination']?></label></div>
	</div>
	
	<div class="row">
		<div class="col-xs-5"><?=lang('departure_date')?>:</div>
		<div class="col-xs-7"><label><?=date(DATE_FORMAT, strtotime($search_criteria['departure_date']))?></label></div>
	</div>
	
	<?php if(!empty($search_criteria['travel_styles'])):?>
	<div class="row">
		<div class="col-xs-5"><?=lang('travel_styles')?>:</div>
		<div class="col-xs-7"><label><?=implode(', ', $search_criteria['travel_styles'])?></label></div>
	</div>
	<?php endif;?>
	
	<?php if(!empty($search_criteria['duration'])):?>
	<div class="row">
		<div class="col-xs-5"><?=lang('duration')?>:</div>
		<div class="col-xs-7"><label><?=$search_criteria['duration']?></label></div>
	</div>
	<?php endif;?>
	
	<?php if(!empty($search_criteria['group_type'])):?>
	<div class="row">
		<div class="col-xs-5"><?=lang('group_type')?>:</div>
		<div class="col-xs-7"><label><?=$search_criteria['group_type']?></label></div>
	</div>
	<?php endif;?>
	
	<?php if(!empty($search_criteria['budgets'])):?>
		<div class="row">
			<div class="col-xs-5"><?=lang('tour_budget')?>:</div>
			<div class="col-xs-7"><label><?=implode(', ', $search_criteria['budgets'])?></label></div>
		</div>
	<?php endif;?>
	
	<div class="row">
		<div class="col-xs-7 col-xs-offset-5">
			<button class="btn btn-blue btn-block" type="button" onclick="javascript: $('.search-overview').hide(); $('.search-form').show();"><?=lang('lbl_change_search')?></button>
		</div>
	</div>
	
</div>