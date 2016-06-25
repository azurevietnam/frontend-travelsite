<div class="container">

	<p class="text-danger margin-top-10">
		<span class="glyphicon glyphicon glyphicon-warning-sign"></span>
		<?=lang('please_input_correct_info')?>
	</p>
	
	<div class="bpv-search" style="display: block;">
	
	<h2><?=lang('search_cruise_label')?></h2>
	
	<div class="bpv-search-content">
	
	<form role="form" id="cruise_search_form" name="cruise_search_form" method="post" action="<?=get_url(CRUISE_HL_SEARCH_PAGE)?>">
		<div class="row form-group">
			<div class="col-xs-12">
			
			<?php $warning_class = empty($search_criteria['destination']) ? "bpv-input-warning":"";?>
			
			<label for="destination"><?=lang('search_cruise_label')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control <?=$warning_class?>" name="destination" id="destination" maxlength="100"
    					value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_cruises')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="cruise_destination_input" id="cruise_destination_input">
		    	<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
			</div>
		</div>
		
		<div class="row form-group">
			<div class="col-xs-6">
			    <?php $warning_class = empty($search_criteria['startdate']) ? "bpv-input-warning":"";?>
				<label for="startdate"><?=lang('departure_date')?></label>
				<span class="icon-after">
	    			<input type="text" class="form-control bpv-date-input <?=$warning_class?>" name="startdate" id="startdate" maxlength="10" 
	    				placeholder="<?=lang('placeholder_date')?>"		    				
	    				<?php 
	    					$startdate = $search_criteria['is_default'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
	    				?>
	    				value="<?=$startdate?>" readonly="readonly">
	    			<span class="glyphicon glyphicon-calendar" id="btn_startdate"></span>
    			</span>
			</div>
			<div class="col-xs-6">
				<label for="duration"><?=lang('tour_duration')?></label>
				<select class="form-control" id="duration" name="duration">
					<?php foreach ($duration_search as $key => $value):?>
					<option value="<?=$key?>" <?=set_select('duration', $key, $search_criteria['duration'] == $key ? true : false)?>><?=lang($value)?></option>
					<?php endforeach;?>
				</select>
			</div>
		</div>
		
		<div class="row form-group" id="block_end_date" style="display: none;">
		    <div class="col-xs-12">
				<label for="enddate"><?=lang('end_date')?>:</label>
				<div style="display: inline-block;">
					
					<?php 
    					$enddate = $search_criteria['is_default'] || empty($search_criteria['enddate']) || !check_bpv_date($search_criteria['enddate']) ? '' : $search_criteria['enddate'];
    				?>
    				
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
					<span id="show_search_end_date"><?=$enddate?></span>
				</div>
			</div>
		</div>
		<div class="row form-group margin-bottom-0">			
			<div class="col-xs-12">
				<button type="submit" class="btn btn-bpv btn-search btn-block" 
					name="action" value="<?=ACTION_SEARCH?>"
					onclick="return validate_cruise_search()"><?=lang('btn_search_now')?></button>
			</div>
		</div>
		</form>
		</div>

		</div>
</div>

<div class="update-wrapper" style="display:none">
	<div class="hotel-search-updating center-block" >
		<div class="ms1"><?=lang('cruise_search_updating')?></div>
		<div class="ms2">
			<span style="margin-right:15px;"><?=lang('cruise_search_please_wait')?></span>
			<img alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
		</div>		
	</div>
</div>	

<script type="text/javascript">
$(document).ready(function() {

	var cal_load = new Loader();
	cal_load.require(
			<?=get_libary_asyn_js('jquery-ui-datepicker')?>, 
	      function() {
	         	 // Callback
	      	set_up_cruise_calendar(true);

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         	 // Callback
      	set_up_cruise_autocomplete(true);   
      }); 

	init_cruise_search(false, true);

});
</script>