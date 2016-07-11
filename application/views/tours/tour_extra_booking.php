<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div style="width: 710px; float: left; position: relative;">
			
		<div id="tour_check_rate">
			<?=$tour_check_rate?>
		</div>
		
		<div class="more_tour">
			<span class="arrow">&rsaquo;</span>	
			
			<a target="_blank" href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>" class="link_function">View full detail about this tour</a> 
		</div>
		
	
	</div>


