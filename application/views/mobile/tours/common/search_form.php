<?=load_search_waiting(lang('tour_search_updating'),'udating')?>

<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>
<div class="bpv-search">
	<h2><?=lang('search_tour_label')?></h2>

	<div class="bpv-search-content">
		
		<form role="form" id="tour_search_form" name="tour_search_form" method="post" action="<?=get_url(TOUR_SEARCH_PAGE)?>">
		<div class="row form-group">
			<div class="col-xs-12">
                <label for="dep_id"><?=lang('departing_from')?></label>
				<select class="form-control" name="dep_id" id="dep_id">
    		        <option value=""><?=lang('select_departing_from')?></option>
    		        <?php foreach ($departure_destinations as $des):?>
    		            
    		        <option value="<?=$des['id']?>"  <?=set_select('dep_id', $des['id'], isset($search_criteria['dep_id']) && $search_criteria['dep_id'] == $des['id'] ? true : false)?>><?=$des['name']?></option>
    		            
    		        <?php endforeach;?>
				 </select>
				 <input type="hidden" id="departure" name="departure" value="<?= !empty($search_criteria['departure']) ? $search_criteria['departure'] : ''?>">
			</div>
		</div>
		
		<div class="row form-group">
		    <div class="col-xs-12">
				<label for="tour_destination"><?=lang('destination_search')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control typeahead" name="destination" id="tour_destination" maxlength="100"
    					value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_tours')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="tour_destination_input" id="tour_destination_input">
		    	<input type="hidden" name="des_id" id="des_id" value="<?=isset($search_criteria['des_id'])?$search_criteria['des_id']:''?>">
			</div>
		</div>
		
		<div class="row form-group">
			<div class="col-xs-6">
				<label for="tour_departure_date"><?=lang('departure_date')?></label>
				<span class="icon-after">
	    			<input type="text" class="form-control" name="startdate" id="tour_departure_date" maxlength="10" 
	    				placeholder="<?=lang('placeholder_date')?>"		    				
	    				<?php 
	    					$startdate = $search_criteria['is_default_date'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
	    				?>
	    				value="<?=$startdate?>" autocomplete="off" readonly="readonly">
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
		
		<div class="row form-group margin-bottom-0">			
			<div class="col-xs-12">
				<button type="submit" class="btn btn-bpv btn-search btn-block" 
					name="action" value="<?=ACTION_SEARCH?>"
					onclick="return validate_tour_search()"><?=lang('btn_search_now')?></button>
			</div>
		</div>
		</form>
		
	</div>
</div>
<script type="text/javascript">
//$(document).ready(function() {

	var cal_load = new Loader();
	cal_load.require(
			<?=get_libary_asyn_js('jquery-ui-datepicker')?>, 
	      function() {
	         	 // Callback
	      	set_up_tour_calendar(true);

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         // Callback
      	 set_up_tour_autocomplete(true);   
      }); 

	init_tour_search(true, true);	
//});
</script>