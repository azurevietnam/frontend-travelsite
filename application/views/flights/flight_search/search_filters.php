
<h2 class="bpv-filter-title bpv-color-title" style="margin-top:30px"><?=lang('filter_results')?></h2>
<div class="bpv-filter">
	<div class="title bpv-color-title">
		<span class="icon icon-airlines"></span><span><?=lang('filter_by_airlines')?></span>
	</div>
	<div class="content" id="filter_airlines">
		<center><img width="32" src="<?=get_static_resources('media/icon/loading.gif')?>"></center>
	</div>
</div>

<div class="bpv-filter">
	<div class="title bpv-color-title">
		<span class="icon icon-flight-departure-time"></span><span><?=lang('filter_by_departure')?></span>
	</div>
	<div class="content">
		
		<?php foreach ($departure_times as $key=>$value):?>
			
			<div class="checkbox margin-bottom-20">
				<label>
			    	<input onclick="filter_flights()" class="filter-times" type="checkbox" value="<?=$key?>"> <?=$value?>
				</label>
			</div>			
							
		<?php endforeach;?>
		
	</div>
</div>

