<div id="searchForm" style="display:inherit">
	<?php if(isset($flag_home_page)):?>
		<div class="search_type">
			<h2 class="highlight"><?=lang('search_type')?> <span id="search_help" class="icon" style="cursor: help;"></span></h2>
			<input type="radio" value="1" name="search_type" checked="checked"/> <label class="highlight"><?=lang('search_type_tour')?></label>
			<input type="radio" value="2" name="search_type"/> <label class="highlight"><?=lang('search_type_hotel')?></label>
			<input type="hidden" id="hotel_help" value="<?=format_text_output(lang('hotel_search_help'))?>">
		</div>
	<?php endif;?>
	
	<div id="search_tour">
		<?php if(!isset($flag_home_page)):?>
			<h2 class="highlight">
				<?=lang('search_tour'). ' '?><span id="search_help" class="icon" style="cursor: help;"></span>
			</h2>
		<?php endif;?>
		<form id="frmSearchForm" name="frmSearchForm" method="post" onsubmit="return search('<?=lang('search_alert_message')?>', '<?=url_builder('','tour_search/')?>');">
			<ul class="row row_des">
				<li class="label">
					<?php if(isset($flag_home_page)):?>
						<?=lang('destinations')?>:
					<?php else:?>
						<?=str_replace('...', '', lang('search_placeholder'))?>:
					<?php endif;?>
					<span class="icon icon-help" style="cursor: help;" id="destination_help"></span>
				</li>
				<li class="input">
					<input name="destinations" id="destinations" alt="<?=lang('search_placeholder')?>"
						value="<?=set_value('destinations', $search_criteria['destinations'])?>"
						title="<?=lang('search_title')?>" maxlength="100"
						onfocus="searchfield_focus(this)" onblur="searchfield_blur(this)"/>
					<input type="hidden" name="destination_ids" id="destination_ids" />
					<input type="hidden" name="is_cruise_port" id="is_cruise_port" /> <input
						type="hidden" name="sort_by" id="sort_by" />
				</li>
			</ul>
			<ul class="row">
				<li class="label"><?=lang('departure_date')?>:</li>
				<li class="input" id="date_picker">
					<select name="departure_day" id="departure_day"
						onchange="changeDay('#departure_day','#departure_month','#departure_date')">
						<option value="">
							<?=date('D, Y')?>
						</option>
					</select> &nbsp; <select name="departure_month"
						id="departure_month" onchange="changeMonth('#departure_day','#departure_month','#departure_date')">
						<option value="">
							<?=date('M, Y')?>
						</option>
					</select> &nbsp;<input type="hidden" id="departure_date"
						name="departure_date" />
				</li>
			</ul>
			<?php if (isset($cats)) :?>
			<ul class="row">
				<li class="label"><?=lang('travel_styles')?>:<span class="icon icon-help" style="cursor: help;" id="travel_style_help"></span></li>
				<?php $i = 0;?>
				<?php foreach ($cats as $cat):?>
				<li class="travelstyle">
					<input type="checkbox" value="<?=$cat['id']?>"
						name="travel_styles[]" id="travelstyle_<?=$i?>"
						<?=set_checkbox('travel_styles', $cat['id'], $search_criteria['travel_styles'] != '' && in_array($cat['id'], $search_criteria['travel_styles'])?TRUE:FALSE)?> />
					<?=$cat['name']?>
				</li>
				<?php $i ++;?>
				<?php endforeach;?>
			</ul>
			<?php endif;?>
			<ul class="row">
				<li class="duration-label"><?=lang('duration')?>:</li>
				
				<?php if(!isset($big_search_form)):?>
					<li class="group-type-label"><?=lang('group_type')?>:</li>
				<?php endif;?>
				
				<li class="travelstyle">
					<select name="duration" id="duration">
						<option value="">
							<?=lang('select_all')?>
						</option>
						<?php foreach ($dur_list as $key => $value) :?>
						<option value="<?=$key?>"
							<?=set_select('duration', $key, $search_criteria['duration']==strval($key)?TRUE:FALSE)?>>
							<?=lang($value)?>
						</option>
						<?php endforeach;?>
					</select>
					
					
				</li>
				
				<?php if(isset($big_search_form)):?>
					<li class="group-type-label"><?=lang('group_type')?>:</li>
				<?php endif;?>
				<li class="travelstyle">	
					<select name="group_type" id="group_type">
						<option value="">
							<?=lang('select_all')?>
						</option>
						<option value="private" <?=set_select('group_type', 'private', isset($search_criteria['group_type']) && $search_criteria['group_type']=='private'?TRUE:FALSE)?>><?=lang('group_type_private')?></option>
						<option value="group" <?=set_select('group_type', 'group',isset($search_criteria['group_type']) && $search_criteria['group_type']=='group'?TRUE:FALSE)?>><?=lang('group_type_group')?></option>
					</select>
				</li>
				
			</ul>
			<ul class="row">
				<li class="label padd">
					<?=lang('tour_budget')?>:
					<span class="icon icon-help" style="cursor: help;" id="tour_type_help"></span>
				</li>
				<li class="input">
					
					<?php foreach ($c_services as $key => $value) :?>
						
						<?php 
							$is_home = $this->uri->segment(1) == '';
							
							$is_last = $is_home && $key == count($c_services) -1;
						?>
					
						<label class="budget padd<?php if($is_last):?> budget_last<?php endif;?>">
						<input type="checkbox" id="class_service_<?=$value['id']?>" 
							style="*float: none; *padding: inherit; height: auto;"
							name="class_service[]" value="<?=$value['id']?>"
							<?=set_checkbox('class_service', $value['id'], $search_criteria['class_service'] != '' && in_array($value['id'], $search_criteria['class_service'])?TRUE:FALSE)?>
							alt="<?=$value['name']?>">&nbsp;<?=$value['name']?>
						</label>
					
					<?php endforeach;?>
					
				</li>
			</ul>
			<div class="row">
				<div id="search_button" class="btn_general btn-search highlight floatR" onclick="search('<?=lang('search_alert_message')?>', '<?=url_builder('','tour_search/')?>')"><?=lang('search_tour')?></div>
			</div>
			    <div class="row">
			</div>
		</form>
		<?php if(isset($flag_home_page)):?>
			<div id="block_hotel_search_form" style="display: none;">
			<?=$hotel_search_view?>
			</div>
		<?php endif;?>
	</div>
</div>
<input type="hidden" id="tour_type_help_content" value="<?=format_text_output(lang('tour_budget_help'))?>">
<input type="hidden" id="search_help_content" value="<?=format_text_output(lang('search_help'))?>">
<input type="hidden" id="destination_help_content" value="<?=format_text_output(lang('destination_help'))?>">
<input type="hidden" id="travel_style_help_content" value="<?=format_text_output(lang('travel_style_help'))?>">
<script>
	var this_date = '<?=getDefaultDate()?>';

	var current_date = getCookie('departure_date');
	
	if (current_date == null || current_date ==''){
		current_date = '<?=date('d-m-Y', strtotime($search_criteria['departure_date']))?>';
	}
	
	var GLOBAL_TRAVEL_STYLE = <?=isset($cats) ? json_encode($cats) : '';?>;
	
	$(document).ready(function(){
		initSearchForm(this_date, current_date, '<?=lang_code()?>');

		$('input[name="search_type"]').bind('click', function() {
			change_search_type(this, this_date, current_date, '<?=lang_code()?>');
	  	});
	});
</script>
