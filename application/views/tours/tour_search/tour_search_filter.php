<div class="filter_results" style="margin-top:10px">
	<h2 class="highlight" style="padding-bottom:0;padding-left:0"><?=lang('filter_results')?></h2>
	<form id="frm_search_filter">
	
	<?php if(count($cruise_cabins_nr) > 0 &&  $search_criteria['travel_styles'] != '' && (in_array(2, $search_criteria['travel_styles']) || in_array(3, $search_criteria['travel_styles']))):?>

		<h3 class="highlight"><?=lang('cruise_properties')?></h3>
		
		<ul style="float:left;">
			<?php foreach ($cruise_cabins as $key=>$value):?>
			
			<?php 
				$input_id = 'cruise_cabin_'.$key;
				$is_checked = $key == $filter_results['cruise_cabin'];
			?>
			
			<li style="float: left; width: 50%; margin-bottom: 5px;"><input style="margin-left:0" id="<?=$input_id?>" onclick="filter_result()" type="radio" value="<?=$key?>" name="cruise_cabin" <?php if ($is_checked) echo 'checked="checked"'?>> <?=translate_text($value). ' ('.$cruise_cabins_nr[$key].')'?></li>
			
			
			
			<?php endforeach;?>
		</ul>
		
	<?php endif;?>
	
	
	<?php if(count($cruise_properties_nr) > 0 &&  $search_criteria['travel_styles'] != '' && (in_array(2, $search_criteria['travel_styles']) || in_array(3, $search_criteria['travel_styles']))):?>
	
		<div class="filter_saperation"></div>
		<ul>
		<?php foreach ($cruise_properties as $value):?>
			<?php if(isset($cruise_properties_nr[$value['id']])):?>
				
				<?php 
					$input_id = 'cruise_properties_'.$value['id'];
					$is_checked = count($filter_results['cruise_properties']) > 0 && in_array($value['id'], $filter_results['cruise_properties']);
				?>
					
				<li style="margin-bottom: 5px">
					<input id="<?=$input_id?>" onclick="filter_result()" type="checkbox" value="<?=$value['id']?>" name="cruise_properties[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=$value['name']?> (<?=$cruise_properties_nr[$value['id']]?>)
				</li>	
			<?php endif;?>
		<?php endforeach;?>
		
		
		<?php if(isset($cruise_properties_nr[-1])):?>
		<li style="margin-bottom: 5px">
			<?php 
				$is_checked = count($filter_results['cruise_properties']) > 0 && in_array(-1, $filter_results['cruise_properties']);			
			?>
			<input id="cruise_properties_-1" onclick="filter_result()" type="checkbox" value="-1" name="cruise_properties[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=lang('has_tripple_family_cabin')?> (<?=$cruise_properties_nr[-1]?>)
		</li>
		<?php endif;?>
	
		</ul>
		
	<?php endif;?>

	
	<?php if($search_destination['has_tour_in_attraction'] && count($search_destination['sub_des']) > 0):?>
	
		<?php if($search_destination['type'] == 1):?>
		
			<h3 class="highlight" style="padding-left:0;clear:both;"><?=lang('popular_cities_in')?> <?=$search_destination['name']?></h3>
		
		<?php else:?>
		
			<h3 class="highlight" style="padding-left:0;clear:both;"><?=lang('attraction_in')?> <?=$search_destination['name']?></h3>
		
		<?php endif;?>
		
		
		<ul>
			<?php foreach ($search_destination['sub_des'] as $key=>$value):?>
			
			<?php 
				$input_id = 'sub_des_'.$value['id'];
				
				$is_checked = count($filter_results['sub_des']) > 0 && in_array($value['id'], $filter_results['sub_des']);
			?>
			
			<?php if($value['tour_nr'] > 0):?>
			
			<li style="margin-bottom: 5px;"><input id="<?=$input_id?>" onclick="filter_result()" type="checkbox" value="<?=$value['id']?>" name="sub_des[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=$value['name']. ' ('.$value['tour_nr'].')'?></li>
			
			<?php endif;?>
			
			<?php endforeach;?>
		</ul>
	
	
	<?php endif;?>
	
	<?php if(count($tour_activities_nr) > 0 && count($tour_activities) > 0):?>
	
	<h3 class="highlight" style="clear:both;"><?=lang('tour_activities')?></h3>
	
	
	<ul>
		
		<?php foreach ($tour_activities as $value):?>
		
			<?php if(isset($tour_activities_nr[$value['id']])):?>
				
				<?php 
					$input_id = 'tour_activity_'.$value['id'];
					$is_checked = count($filter_results['tour_activities']) > 0 && in_array($value['id'], $filter_results['tour_activities']);
				?>
					
				<li style="margin-bottom: 5px">
					<input id="<?=$input_id?>" onclick="filter_result()" type="checkbox" value="<?=$value['id']?>" name="tour_activities[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=$value['name']?> (<?=$tour_activities_nr[$value['id']]?>)
				</li>	
			<?php endif;?>
		<?php endforeach;?>
			
	</ul>
	
	<?php endif;?>
	
		
	<h3 class="highlight" style="clear:both;"><?=lang('tour_duration')?></h3>

	<ul>
		<?php foreach ($tour_durations as $key=>$value):?>
		
			<?php 
				$input_id = 'tour_duration_'.$key;
				
				$is_checked = strval($key) == $filter_results['tour_duration'];
			?>
		
		
			
		<li style="float: left; width: 50%; margin-bottom: 5px;"><input style="margin-left:0" id="<?=$input_id?>" type="radio" value="<?=$key?>" onclick="filter_result()" name="tour_duration" <?php if ($is_checked) echo 'checked="checked"'?>> <?=translate_text($value). ' ('.$tour_durations_nr[$key].')'?></li>
		
		
		<?php endforeach;?>
	</ul>
	
	

	
	<h3 class="highlight" style="clear:both;"><?=lang('tour_type')?></h3>	
	
	<ul>
		<?php foreach ($tour_types as $key=>$value):?>
			
			<?php 
				$input_id = 'tour_types_'.$key;
				
				$is_checked = count($filter_results['tour_types']) > 0 && in_array($key, $filter_results['tour_types']);
			?>
			
			<?php if($key != PRIVATE_TOUR && $key != GROUP_TOUR):?>
			
			<li style="float: left; width: 50%; margin-bottom: 5px;"><input id="<?=$input_id?>" onclick="filter_result()" type="checkbox" value="<?=$key?>" name="tour_types[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=translate_text($value).' ('.$tour_types_nr[$key].')'?></li>
			
			<?php endif;?>
			
		<?php endforeach;?>
	</ul>
	
	<div class="filter_saperation"></div>
	
	<ul>
		<?php foreach ($tour_types as $key=>$value):?>
			
			<?php 
				$input_id = 'tour_types_'.$key;
				
				$is_checked = count($filter_results['tour_types']) > 0 && in_array($key, $filter_results['tour_types']);
			?>
			
			<?php if($key == PRIVATE_TOUR || $key == GROUP_TOUR):?>
			
			<li style="float: left; width: 50%; margin-bottom: 5px;"><input id="<?=$input_id?>" onclick="filter_result()" type="checkbox" value="<?=$key?>" name="tour_types[]" <?php if ($is_checked) echo 'checked="checked"'?>> <?=translate_text($value).' ('.$tour_types_nr[$key].')'?></li>
			
			<?php endif;?>
			
		<?php endforeach;?>
	</ul>
	
	
	</form>
</div>

<script type="text/javascript">

	function filter_clear(id){

		$('#'+id).attr('checked', false);

		if(id.indexOf('tour_duration') != -1){
			$('#tour_duration_0').attr('checked', true);
		}

		if(id.indexOf('cruise_cabin') != -1){
			$('#cruise_cabin_0').attr('checked', true);
		}

		filter_result();
	}

	function filter_result(){

		$("html, body").animate({ scrollTop: 0 }, "fast");
		
		var str_filter_data = $('#frm_search_filter').serialize();	

		$("#loading_data").css("display", "");
		$.ajax({
	   		type: "POST",
	   		cache: true,
	   		url: '<?=site_url('/tour_search/').'/'?>',
	    	data: str_filter_data,
	   		success: function(responseText){
	     		$("#contentMain").html(responseText);
	   		},
	   		complete: function(){
	   			$("#loading_data").css("display", "none");
	   			applyPagination();
	   		} 
	 	});

	}

</script>