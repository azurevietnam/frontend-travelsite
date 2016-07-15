<?php if(!empty($destination['travel_tips'])):?>
	<?php 
		$travel_tips = explode("\n", $destination['travel_tips']);
	?>
	<div style="clear: both; float: left;">
	<h2 class="highlight" style="padding: 10px 0"><?=lang('flight_des_some_tip')?> <?=$destination['name']?>:</h2>

	<ul class="trip_highlight" style="list-style:decimal;">
		
		<?php foreach ($travel_tips as $tip):?>
			<?php if(trim($tip) != ''):?>			
				<li style="margin-bottom:7px">
					<?=$tip?>
				</li>
			<?php endif;?>
		<?php endforeach;?>
		
	</ul>
	</div>
<?php endif;?>