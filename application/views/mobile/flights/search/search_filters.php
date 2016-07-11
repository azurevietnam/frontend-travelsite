
<h2 class="bpv-filter-title bpv-color-title text-highlight" style="margin-top:30px"><?=lang('filter_results')?></h2>
<div class="bpv-filter">
	<div class="text-highlight title bpv-color-title">
		<span class="icon icon-flight-special margin-right-10"></span><span><?=lang('sort_by_airlines')?></span>
	</div>
	<div class="content" id="filter_airlines">
		<center><img width="32" src="<?=get_static_resources('/media/icon/loading.gif')?>"></center>
	</div>
</div>

<div class="bpv-filter">
	<div class="title bpv-color-title text-highlight">
		<span class="icon icon-flight-departure-time margin-right-10"></span><span><?=lang('sort_by_departure')?></span>
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