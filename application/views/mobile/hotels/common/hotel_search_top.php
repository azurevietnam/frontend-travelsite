<div class="container bpv-search-top">

	<p class="text-danger">
		<span class="glyphicon glyphicon glyphicon-warning-sign"></span>
		<?=lang('please_input_correct_info')?>
	</p>
	
	<form role="form" id="hotel_search_form" name="hotel_search_form" method="post" action="<?=get_url(HOTEL_SEARCH_PAGE)?>">
		
		<div class="row">
			
			<div class="col-xs-4">
				
				<?php $warning_class = empty($search_criteria['destination']) ? "bpv-input-warning":"";?>
				
				<label for="destination"><?=lang('search_hotel_label')?></label>
				<span class="div-destination">
    				<input type="text" class="form-control <?=$warning_class?>" name="destination" id="destination" maxlength="100"
    					value="<?= !empty($search_criteria['destination']) ? $search_criteria['destination'] : ''?>" 
    					placeholder="<?=lang('placeholder_hotel_destination')?>" autocomplete="off">
    			</span>
    			<input type="hidden" name="hotel_destination_input" id="hotel_destination_input">
		    	<input type="hidden" name="oid" id="oid" value="<?=isset($search_criteria['oid'])?$search_criteria['oid']:''?>">
				
			</div>
			
			<div class="col-xs-2">
				<label for="startdate"><?=lang('check_in_date')?></label>
				<span class="icon-after">
					<?php $warning_class = empty($search_criteria['startdate']) ? "bpv-input-warning":"";?>
					
	    			<input type="text" class="form-control bpv-date-input <?=$warning_class?>" name="startdate" id="startdate" maxlength="10" 
	    				value="<?= !empty($search_criteria['startdate']) && check_bpv_date($search_criteria['startdate']) ? $search_criteria['startdate'] : ''?>" autocomplete="off">
	    			<span class="icon icon-calendar" id="btn_startdate"></span>
    			</span>
			</div>
			
			<div class="col-xs-1">
				<label for="night"><?=lang('number_of_nights')?></label>
				<?php $warning_class = empty($search_criteria['night']) ? "bpv-input-warning":"";?>
				<select class="form-control <?=$warning_class?>" id="night" name="night">
					<option value="">----</option>
					<?php for($i=1; $i <= $max_nights; $i++):?>
					<option value="<?=$i?>" <?=set_select('night', $i, $search_criteria['night'] == $i ? true : false)?>><?=$i?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-2">
				<label for="enddate"><?=lang('check_out_date')?></label>
				<div>
					<input type="hidden" id="enddate" readonly="readonly" name="enddate" value="<?= !empty($search_criteria['enddate']) ? $search_criteria['enddate'] : ''?>">
					<span id="show_search_end_date"><?= !empty($search_criteria['enddate']) ? $search_criteria['enddate'] : ''?></span>
					<!-- 
					<span class="icon icon-calendar" id="btn_enddate"></span>
					 -->
				</div>
			</div>
			
			<div class="col-xs-3">
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
		<div class="ms1"><?=lang('hotel_search_updating')?></div>
		<div class="ms2">
			<span style="margin-right:15px;"><?=lang('hotel_search_please_wait')?></span>
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
      	set_up_hotel_calendar(true);

 
      });

	var au_load = new Loader();
	au_load.require(
	  <?=get_libary_asyn_js('typehead')?>, 
      function() {
         	 // Callback
      	set_up_hotel_autocomplete(true);   
      }); 
        				
	init_hotel_search(false, true);

});
</script>