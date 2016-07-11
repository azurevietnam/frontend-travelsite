<?=!empty($hotel_in_destination) ? $hotel_in_destination : ''?>

<?=!empty($popular_cities) ? $popular_cities : ''?>

<?=!empty($similar_hotels) ? $similar_hotels : ''?>

<?php if( !empty($indochina_tour_service_links) || !empty($popular_service_links) ):?>
<!-- Indochina Tour -->
<div class="background-list-service-link">
	<div class="container">
	   <?=!empty($indochina_tour_service_links) ? $indochina_tour_service_links : ''?>

	   <?=!empty($popular_service_links) ? $popular_service_links : ''?>

	</div>
</div>
<?php endif;?>
<div class="background-list-service-link bpt-tab">
	<?=!empty($similar_tours) ? $similar_tours : ''?>

	<?=!empty($similar_cruises) ? $similar_cruises : ''?>

	<?=!empty($all_cruise_links) ? $all_cruise_links : ''?>
</div>
<div class="bpt-footer container">
	<div class="pull-left">
		<a id="logo" href="<?=site_url()?>"><img src="../media/logo.png" alt="<?=lang('home_title')?>"></img></a>
	</div>
	<div class="pull-right">
		© 2016 Travel
	</div>
</div>
</div>


