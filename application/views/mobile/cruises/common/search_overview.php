<div class="bpv-search-overview">

	<h2><?=lang('my_search_label')?></h2>
	
	<div class="content clearfix">
	
		<div class="margin-bottom-10">
			<span class="icon icon-hotel-sm"></span> <?=get_cruise_overview_txt_1($search_criteria)?>
		</div>
		<div class="margin-bottom-20">
			<span class="icon icon-calendar-sm"></span> <?=get_cruise_overview_txt_2($search_criteria)?>
		</div>
		
		<button type="button" class="btn btn-bpv btn-search pull-right" onclick="change_search()">
	  		<?=lang('btn_change_search')?>
	  	</button>
	</div>
	
</div>