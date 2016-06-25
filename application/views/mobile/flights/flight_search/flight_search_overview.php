
<div class="bpv-search-overview">

	<h1><?=lang('my_search_label')?></h1>
	
	<div class="content clearfix">
		<div class="row margin-bottom-10">
			<div class="col-xs-12">
				<b><?=$search_criteria['From']?></b> <?=lang('flight_go')?>
				<b><?=$search_criteria['To']?></b>
			</div>
		</div>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-4">
				<?=lang('search_fields_departure')?>:
			</div>
			<div class="col-xs-8">
				<?=format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true)?>
			</div>
		</div>
		
		<?php if(!empty($search_criteria['Return'])):?>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-4">
				<?=lang('search_fields_return')?>:
			</div>
			<div class="col-xs-8">
				<?=format_bpv_date($search_criteria['Return'], DATE_FORMAT, true)?>
			</div>
		</div>
		
		<?php endif;?>
		
		<div class="row margin-bottom-20">
			<div class="col-xs-4">
				<?=lang('passenger')?>:
			</div>
			<div class="col-xs-8">
				<?=get_passenger_text($search_criteria['ADT'], $search_criteria['CHD'], $search_criteria['INF'])?>
			</div>
		</div>
		
		<button type="button" class="btn btn-bpv btn-search pull-right" onclick="change_search()">
	  		<?=lang('btn_change_search')?>
	  	</button>
	</div>
	
</div>
