<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if(isset($tour)):?>
	<?php if(!empty($tour['tour_highlight'])):?>
		<div class="brief_itinerary">
			<div class="header"><h3 class="highlight"><?=lang('tour_highlight')?></h3></div>
			<div class="content"><?=format_specialtext($tour['tour_highlight'])?></div>
		</div>
	<?php endif;?>
	

<?=format_specialtext($tour['detail_itinerary'])?>
<?php endif;?>