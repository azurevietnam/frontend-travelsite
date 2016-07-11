<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="search_cruise_main" class="round_coner">
	<?=$search_view?>
</div>

<div id="promotion_cruise" align="center">
	<?php if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES):?>
		<img height="100%" width="100%" src="<?=base_url() .'media/halong_bay_1.jpg'?>" title="Halong bay cruises" alt="Halong bay cruises" >
	<?php else :?>
		<img height="100%" width="100%" src="<?=base_url() .'media/mekong_river_cruise.jpg'?>" title="Mekong river cruises" alt="Mekong river cruises" >
	<?php endif;?>
</div>

<div id="most_popular_cruise">
	<?=$best_deal_view?>
</div>

<?php if (isset($my_viewed_cruises) && count($my_viewed_cruises) > 0):?>
	<div id="my_viewed_cruise_main">
		<?=$my_viewed_cruise_view?>
	</div>
<?php endif;?>

<div id="cruise_faq_main">
	<?=$cruise_faq_view?>
</div>

