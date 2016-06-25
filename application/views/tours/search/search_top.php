<div class="container bpv-search-top">

	<p class="text-danger">
		<span class="glyphicon glyphicon glyphicon-warning-sign"></span>
		<?=lang('please_input_correct_info')?>
	</p>
	
	<form role="form" id="tour_search_form" name="tour_search_form" method="post" action="<?=get_url(TOUR_SEARCH_PAGE)?>">
		
		<div class="row">
		    
		    <div class="col-xs-2">
                <label for="dep_id"><?=lang('departing_from')?></label>
                <select class="form-control" name="dep_id" id="dep_id">
                    <option value=""><?=lang('select_departing_from')?></option>
                    <?php foreach ($departure_destinations as $des):?>   
                    <option value="<?=$des['id']?>"  <?=set_select('dep_id', $des['id'], $search_criteria['dep_id'] == $des['id'] ? true : false)?>><?=$des['name']?></option>   
                    <?php endforeach;?>
                </select>
                <input type="hidden" id="departure" name="departure" value="<?= !empty($search_criteria['departure']) ? $search_criteria['departure'] : ''?>">
		    </div>
			
			<div class="col-xs-4">
				
				<?php $warning_class = empty($search_criteria['destination']) ? "bpv-input-warning":"";?>
				
				<label for="tour_destination"><?=lang('destination_search')?></label>
				<span class="div-destination">
    			    <input type="text" class="form-control typeahead <?=$warning_class?>" name="destination" id="tour_destination" maxlength="100"
    					value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_tours')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="tour_destination_input" id="tour_destination_input">
		    	<input type="hidden" name="des_id" id="des_id" value="<?=isset($search_criteria['des_id'])?$search_criteria['des_id']:''?>">
				
			</div>
			
			<?=$destination_suggestion?>
			
			<div class="col-xs-2">
				<label for="tour_departure_date"><?=lang('check_in_date')?></label>
				<span class="icon-after">
					<?php $warning_class = empty($search_criteria['startdate']) ? "bpv-input-warning":"";?>
					
	    			<input type="text" class="form-control <?=$warning_class?>" name="startdate" id="tour_departure_date" maxlength="10" 
	    				value="<?= !empty($search_criteria['startdate']) && check_bpv_date($search_criteria['startdate']) ? $search_criteria['startdate'] : ''?>" autocomplete="off">
	    			<span class="icon icon-calendar" id="btn_startdate"></span>
    			</span>
			</div>
			
			<div class="col-xs-2">
				<label for="night"><?=lang('tour_duration')?></label>
				<select class="form-control" id="duration" name="duration">
					<?php foreach ($duration_search as $key => $value):?>
					<option value="<?=$key?>" <?=set_select('duration', $key, $search_criteria['duration'] == $key ? true : false)?>><?=lang($value)?></option>
					<?php endforeach;?>
				</select>
			</div>
			
			<div class="col-xs-2 no-padding">
				<br>
				<button type="submit" class="btn btn-bpv btn-search" 
					name="action" value="<?=ACTION_SEARCH?>"
					onclick="return validate_hotel_search()"><?=lang('btn_search_now')?></button>
			</div>
				
		</div>
		
	</form>

</div>

<div class="update-wrapper" style="display:none">
	<div class="hotel-search-updating center-block" >
		<div class="ms1"><?=lang('tour_search_updating')?></div>
		<div class="ms2">
			<span style="margin-right:15px;"><?=lang('tour_search_please_wait')?></span>
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
	      	set_up_tour_calendar();

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         // Callback
      	 set_up_tour_autocomplete();   
      }); 

	init_tour_search(true);
	
});
</script>