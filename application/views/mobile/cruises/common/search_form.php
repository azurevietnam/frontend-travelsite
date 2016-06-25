<?=load_search_waiting(lang('cruise_search_updating'),'udating')?>
	
<div class="bpv-search">
	<h2><?=lang('search_cruise_label')?></h2>
	
	<div class="bpv-search-content">
		
		<form role="form" method="post" action="<?=site_url(CRUISE_HL_SEARCH_PAGE)?>" name="frmSearchForm" id="frmSearchForm">
		
		<div class="row form-group">
			<div class="col-xs-12">
    		    <label for="destination"><?=lang('search_cruise_label')?></label>
    		    <div class="div-destination">
        			<input type="text" class="form-control icon-small" data-provide="typeahead" 
        				name="destination" id="destination" 
        				value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
        				placeholder="<?=lang('placeholder_cruises')?>" autocomplete="off">
        		</div>
        		<input type="hidden" name="cruise_destination_input" id="cruise_destination_input">
        		<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
    		</div>
		</div>
		
		<div class="row form-group">
		  	<div class="col-xs-6">
		  		<label for="startdate"><?=lang('departure_date')?></label>
			    <span class="icon-after">
		    		<input type="text" class="form-control bpv-date-input" name="startdate" id="startdate" maxlength="10" 
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
			     <button type="submit" id="submit" onclick="return search_sort_cruises('<?=site_url(CRUISE_HL_SEARCH_PAGE)?>')" class="btn btn-bpv btn-search pull-right" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
			</div>
	    </div>  	
	
		</form>
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