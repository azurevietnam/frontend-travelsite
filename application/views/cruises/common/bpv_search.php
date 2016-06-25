<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>

<div class="bpv-search">
	<h1>
		<span class="icon icon-search"></span><?=lang('search_cruise_label')?>
	</h1>

	<div class="bpv-search-content">
		
		<form role="form" id="cruise_search_form" name="cruise_search_form" method="post" action="<?=get_url(CRUISE_HL_SEARCH_PAGE)?>">
		<div class="row form-group margin-bottom-20 margin-top-10">
			<div class="col-xs-12">
			<label for="destination"><?=lang('search_cruise_label')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control typeahead" name="destination" id="destination" maxlength="100"
    					value="<?= !empty($cruise_search_criteria['destination']) ? $cruise_search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_cruises')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="cruise_destination_input" id="cruise_destination_input">
		    	<input type="hidden" name="oid" id="oid" value="<?=isset($cruise_search_criteria['oid'])?$cruise_search_criteria['oid']:''?>">
			</div>
		</div>
		
		<div id="suggestion-des" class="hide">
		     <h3 class="bpv-color-title">
		         <?=lang('halong_popular_cruises')?>
		         <span class="icon btn-support-close" onclick="$('#destination').popover('hide');"></span>
		     </h3>
		     <ul>
		     <?php foreach ($popular_cruises as $cruise): ?>
		         <li><a href="javascript:void(0)" data-name="<?=$cruise['name']?>" data-id="<?=$cruise['id']?>" data-url-title="<?=$cruise['url_title']?>"><?=$cruise['name']?></a></li>
		     <?php endforeach;?>
		     </ul>
		</div>
		
		<div class="row form-group margin-top-10">
			<div class="col-xs-5">
				<label for="startdate"><?=lang('departure_date')?></label>
				<span class="icon-after">
	    			<input type="text" class="form-control" name="startdate" id="startdate" maxlength="10" 
	    				placeholder="<?=lang('placeholder_date')?>"		    				
	    				<?php 
	    					$startdate = $cruise_search_criteria['is_default'] || empty($cruise_search_criteria['startdate']) || !check_bpv_date($cruise_search_criteria['startdate']) ? '' : $cruise_search_criteria['startdate'];
	    				?>
	    				value="<?=$startdate?>" autocomplete="off" <?php if($is_tablet):?>readonly="readonly"<?php endif;?>>
	    			<span class="icon icon-calendar" id="btn_startdate"></span>
    			</span>
			</div>
			<div class="col-xs-4">
				<label for="duration"><?=lang('tour_duration')?></label>
				<select class="form-control" id="duration" name="duration">
					<?php foreach ($duration_search as $key => $value):?>
					<option value="<?=$key?>" <?=set_select('duration', $key, $cruise_search_criteria['duration'] == $key ? true : false)?>><?=lang($value)?></option>
					<?php endforeach;?>
				</select>
			</div>
			<div class="col-xs-3">
				<label for="enddate"><?=lang('end_date')?></label>
				<div style="display: inline-block;">
					
					<?php 
    					$enddate = $cruise_search_criteria['is_default'] || empty($cruise_search_criteria['enddate']) || !check_bpv_date($cruise_search_criteria['enddate']) ? '' : $cruise_search_criteria['enddate'];
    				?>
    				
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
					<span id="show_search_end_date"><?=$enddate?></span>
				</div>
			</div>
			
		</div>
		<div class="row form-group search-btn-group">			
			<div class="col-xs-6 pull-right">
				<button type="submit" class="btn btn-bpv btn-search pull-right" 
					name="action" value="<?=ACTION_SEARCH?>"
					onclick="return validate_cruise_search()"><?=lang('btn_search_now')?></button>
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
	      	set_up_cruise_calendar();

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         	 // Callback
      	set_up_cruise_autocomplete();   
      }); 

	init_cruise_search(true);

});
</script>