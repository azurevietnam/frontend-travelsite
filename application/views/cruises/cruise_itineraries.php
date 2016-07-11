

<?php 
	$is_unavailable = count($cruise['tours']) == 0 || $cruise['status'] == STATUS_INACTIVE;
?>
				
<?php if (!$is_unavailable):?>

<h2 class="highlight" style="padding-left: 0">
	<?=lang('cruise_tour')?>:&nbsp;

	<select style="font-size: 13px;max-width:440px" name="cruise_itineraries" id="cruise_itineraries" onchange="get_tour_itinerary()">
	
	<?php foreach ($cruise['tours'] as $key => $tour):?>
		<?php 
			$str_nights = ' / '.($tour['duration'] - 1). ($tour['duration'] - 1 > 1 ? ' '.lang('nights') : ' '.lang('night'));
		?>
		
		<option value="<?=$tour['id']?>" <?php if($tour['id'] == $selected_tour['id']):?>selected="selected"<?php endif;?>><?=$tour['name'].$str_nights?></option>
	<?php endforeach;?>
	
	</select>
	&nbsp;
	<input onclick="go_check_rate_position()" type="button" class="metro-theme" style="font-size: 13px; padding: 3px 7px; cursor: pointer;" value="<?=lang('label_view_itinerary')?>">
</h2>

<div id="detail_tour_itinerary">

<?=$tour_itinerary?>

</div>

<?php else:?>

<?=lang('unavailable_desc')?>

<?php endif;?>