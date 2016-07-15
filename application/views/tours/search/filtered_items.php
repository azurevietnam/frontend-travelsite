<?php if(has_filters($search_criteria)):?>
<div>
	<?php if(!empty($search_criteria['cruise_cabin'])):?>
		<span class="filtered-item" onclick="clear_filter('cruise_cabin_<?=$search_criteria['cruise_cabin']?>')">
			<?=translate_text($cruise_cabins[$search_criteria['cruise_cabin']])?>
			<span class="glyphicon glyphicon-remove removed"></span>
		</span>
	<?php endif;?>
	
	<?php if(!empty($search_criteria['cruise_properties'])):?>
		
		<?php foreach($search_criteria['cruise_properties'] as $value):?>
			<span class="filtered-item" onclick="clear_filter('cruise_properties_<?=$value?>')">
				<?=get_filtered_item_name($value, $cruise_properties)?>
				<span class="glyphicon glyphicon-remove removed"></span>
			</span>
		<?php endforeach;?>
		
	<?php endif;?>
	
	<?php if(!empty($search_criteria['activities'])):?>
		
		<?php foreach($search_criteria['activities'] as $value):?>
			<span class="filtered-item" onclick="clear_filter('activities_<?=$value?>')">
				<?=get_filtered_item_name($value, $activities)?>
				<span class="glyphicon glyphicon-remove removed"></span>
			</span>
		<?php endforeach;?>
		
	<?php endif;?>
	
	<?php if(!empty($search_criteria['des_styles'])):?>
		
		<?php foreach($search_criteria['des_styles'] as $value):?>
			<span class="filtered-item" onclick="clear_filter('des_styles_<?=$value?>')">
				<?=get_filtered_item_name($value, $travel_styles)?>
				<span class="glyphicon glyphicon-remove removed"></span>
			</span>
		<?php endforeach;?>
		
	<?php endif;?>
	
	<?php if(!empty($search_criteria['sub_des'])):?>
		
		<?php foreach($search_criteria['sub_des'] as $value):?>
			<span class="filtered-item" onclick="clear_filter('sub_des_<?=$value?>')">
				<?=get_filtered_item_name($value, $sub_destinations)?>
				<span class="glyphicon glyphicon-remove removed"></span>
			</span>
		<?php endforeach;?>
		
	<?php endif;?>
	
</div>
<?php endif;?>