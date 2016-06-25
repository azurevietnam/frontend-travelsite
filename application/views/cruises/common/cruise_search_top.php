<div class="container bpv-search-top">

	<p class="text-danger">
		<span class="glyphicon glyphicon glyphicon-warning-sign"></span>
		<?=lang('please_input_correct_info')?>
	</p>
	
	<form role="form" id="cruise_search_form" name="cruise_search_form" method="post" action="<?=get_url(CRUISE_HL_SEARCH_PAGE)?>">
		
		<div class="row">
			
			<div class="col-xs-4">
				
				<?php $warning_class = empty($search_criteria['destination']) ? "bpv-input-warning":"";?>
				
				<label for="destination"><?=lang('search_cruise_label')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control typeahead <?=$warning_class?>" name="destination" id="destination" maxlength="100"
    					value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_cruises')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="cruise_destination_input" id="cruise_destination_input">
		    	<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
				
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
			
			<div class="col-xs-2">
				<label for="startdate"><?=lang('check_in_date')?></label>
				<span class="icon-after">
					<?php $warning_class = empty($search_criteria['startdate']) ? "bpv-input-warning":"";?>
					
	    			<input type="text" class="form-control <?=$warning_class?>" name="startdate" id="startdate" maxlength="10" 
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
			
			<div class="col-xs-2">
				<label for="enddate"><?=lang('check_out_date')?></label>
				<div>
					<?php 
    					$enddate = $search_criteria['is_default'] || empty($search_criteria['enddate']) || !check_bpv_date($search_criteria['enddate']) ? '' : $search_criteria['enddate'];
    				?>
					<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
					<span id="show_search_end_date"><?=$enddate?></span>
				</div>
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
	      	set_up_cruise_calendar();

	      });
	
	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         	 // Callback
      	set_up_cruise_autocomplete();   
      });
    
	init_cruise_search(false);
});
</script>