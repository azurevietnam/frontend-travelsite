<h2 class="highlight" style="padding: 0"><?=lang('flights_to')?> <?=$destination['name']?></h2>
	<div style="float: left;clear: both; margin: 10px 0 20px">
	<?php
		$tips = $destination['flight_tips'];
		if(empty($tips)) $tips = $destination['general_info'];
		echo str_replace("\n", "<p/>", $tips);
	?>
	</div>