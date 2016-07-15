<div class="bpv-filter bpv-filter-ariline">
	<div class="text-highlight title bpv-color-title">
		<span><?=lang('sort_by_airlines')?></span>
	</div>
	<div class="content" id="filter_airlines">
		
	</div>
</div>

<div class="bpv-filter bpv-filter-time">
	<div class="title bpv-color-title text-highlight">
		<span><?=lang('sort_by_departure')?></span>
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