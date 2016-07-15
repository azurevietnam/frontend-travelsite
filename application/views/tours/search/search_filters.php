<div class="bpt-left-block search-filter-bgr">
	<h2 class="text-highlight title">
		<?=lang('filter_results')?>
	</h2>
	
	<form id="frm_search_filters">
		
		<?php if($is_show_cruise_facilitiy_filter):?>
		
			<h3 class="text-highlight"><?=lang('cruise_properties')?></h3>
			<div class="row">
				<?php foreach ($cruise_cabins as $key=>$value):?>
					<?php if($cruise_cabins_nr[$key] > 0):?>
						<div class="col-xs-6">
							<div class="radio">
							    <label>
							      <input type="radio" <?=set_checkbox('cruise_cabin', $key, $key == 0)?> name="cruise_cabin" id="cruise_cabin_<?=$key?>" value="<?=$key?>" onclick="filter_results()"> 
							      <?=translate_text($value)?>
							      (<?=$cruise_cabins_nr[$key]?>)
							    </label>
							 </div>
						</div>
					<?php endif;?>
				<?php endforeach;?>
			</div>
			<div class="separation"></div>
		
			<?php foreach ($cruise_properties as $key=>$value):?>
				<div class="checkbox margin-bottom-15">
				    <label>
				      <input type="checkbox" name="cruise_properties[]" id="cruise_properties_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()"> <?=$value['name']?>
				      (<?=$value['cnt']?>)
				    </label>
				 </div>
			<?php endforeach;?>
			
			<?php if($nr_tripple_family_cabin > 0):?>
				<div class="checkbox margin-bottom-15">
				    <label>
				      <input type="checkbox" name="cruise_properties[]" id="cruise_properties_-1" value="-1" onclick="filter_results()"> <?=lang('has_tripple_family_cabin')?>
				      (<?=$nr_tripple_family_cabin?>)
				    </label>
				</div>
			<?php endif;?>
		
		<?php endif;?>
		
		<?php if(count($activities) > 0):?>
			<h3 class="text-highlight"><?=lang('thing_to_do_in', $destination['name'])?></h3>
			<?php foreach ($activities as $value):?>
				<div class="checkbox margin-bottom-15">
				    <label>
				      <input type="checkbox" name="activities[]" id="activities_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()">
				      <?=$value['name']?>
				      (<?=$value['cnt']?>)
				    </label>
				 </div>
			<?php endforeach;?>
		<?php endif;?>
		
		<?php if(count($travel_styles) > 0):?>
			<h3 class="text-highlight"><?=lang('lbl_travel_styles_in', $destination['name'])?></h3>
			<?php foreach ($travel_styles as $key => $value):?>
				<div class="checkbox margin-bottom-15  <?php if($key >= 5):?>travel-style<?php endif;?>" <?php if($key >= 5):?> style="display: none"<?php endif;?>>
				    <label>
				      <input type="checkbox" name="des_styles[]" id="des_styles_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()">
				      <?=lang('lbl_tours', $value['name'])?>
				      (<?=$value['cnt']?>)
				    </label>
				 </div>					
			<?php endforeach;?>
			<?php if(count($travel_styles) >=5):?>
				<div class="margin-bottom-10">
					<span class="glyphicon glyphicon-plus-sign text-special" data-hide="glyphicon-plus-sign" data-show="glyphicon-minus-sign" id="more_attration_travel_style"></span>
					<a href="javascript:void(0)" class="attr-show-more-travel-style" data-show="hide" data-target=".travel-style" data-icon="#more_attration_travel_style"><?=lang('label_show_more')?></a>
				</div>
				
				<script type="text/javascript">

					set_show_hide('.attr-show-more-travel-style');
				
				</script>
				
			<?php endif;?>
		<?php endif;?>
		
		<?php if(count($sub_destinations) > 0):?>
			<h3 class="text-highlight"><?=create_sub_destination_label($destination)?></h3>
			<?php 
				$cnt = 0;
			?>
			<?php foreach ($sub_destinations as $value):?>
				 <div class="checkbox margin-bottom-15 <?php if($cnt >= 5):?>des-hide<?php endif;?>" <?php if($cnt >= 5):?> style="display: none"<?php endif;?>>
				    <label>
				      <input type="checkbox" name="sub_des[]" id="sub_des_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()"> <?=$value['name']?>
				      (<?=$value['cnt']?>)
				    </label>
				 </div>
				 
				 <?php 
					++$cnt;
				 ?>
			<?php endforeach;?>
			
			<?php if($cnt >= 5):?>
				<div>
					<span class="glyphicon glyphicon-plus-sign text-special" data-hide="glyphicon-plus-sign" data-show="glyphicon-minus-sign" id="more_attration"></span>
					<a href="javascript:void(0)" class="attr-show-more" data-show="hide" data-target=".des-hide" data-icon="#more_attration"><?=lang('label_show_more')?></a>
				</div>
				
				<script type="text/javascript">

					set_show_hide('.attr-show-more');
				
				</script>
				
			<?php endif;?>
		<?php endif;?>
		
		<input type="hidden" name="sort" id="tour_sort_by" value="<?=$search_criteria['sort_by']?>">
	</form>
</div>