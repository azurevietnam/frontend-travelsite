<?php 
	$form_action = $service_type == HOTEL ? "/recommend-more-hotel/" : "/recommend-more-tour/";
?>

<form id="form_<?=$block_id?>" name="form_<?=$block_id?>" method="POST" action="<?=$form_action?>">
	
	<?=$quick_search?>
	
	<input type="hidden" name="parent_id" value="<?=$current_item_info['parent_id']?>">
	
	<input type="hidden" name="destination_id" value="<?=$destination_id?>">
	
	<input type="hidden" name="service_type" value="<?=$service_type?>">
	
	<input type="hidden" name="start_date" value="<?=$current_item_info['start_date']?>">
	
	<input type="hidden" name="block_id" value="<?=$block_id?>">
	
	<input type="hidden" name="current_service_id" value="<?=$current_item_info['service_id']?>">
	
	<input type="hidden" name="current_service_type" value="<?=$current_item_info['service_type']?>">
	
	<input type="hidden" name="current_service_url_title" value="<?=$current_item_info['url_title']?>">
	
	<input type="hidden" name="current_service_normal_discount" value="<?=$current_item_info['normal_discount']?>">
	
	<input type="hidden" name="current_service_is_main_service" value="<?=$current_item_info['is_main_service']?>">
	
	<input type="hidden" name="current_service_destination_id" value="<?=$current_item_info['destination_id']?>">
	
	<input type="hidden" name="current_service_is_booked_it" value="<?=$current_item_info['is_booked_it']?>">

</form>