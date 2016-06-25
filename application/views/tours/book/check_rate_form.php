<?php 
	$chd_label = lang('children_label').'('.$tour['infant_age_util'].'-'.$tour['children_age_to'].')';
	$inf_label = lang('infant_label').'(<'.$tour['infant_age_util'].')';
?>
<div class="bpv-check-rate-form margin-bottom-20">
	<h2><?=lang('check_rate_title')?></h2>
	<div class="content">
	
	<form id="check_rate_form" role="form" method="get">

			<input type="hidden" name="tour_id" value="<?=$tour['id']?>">
		    <input type="hidden" id="stay_night" value="<?=$tour['duration'] - 1?>">
		    
		    <?php if(!empty($tour_departures) && $tour['departure_type'] == MULTIPLE_DEPARTING_FROM):?>
		    
		    <div class="row">
                <div class="col-xs-5">
                    <label for="adults"><?=lang('departing_from')?></label>
    			    <select class="form-control input-sm" id="departure_id" name="departure_id">
    					<?php foreach ($tour_departures as $value):?>
    						<option value="<?=$value['id']?>" <?=set_select('departure_id', $value['id'], $check_rate_info['departure_id'] == $value['id'] ? true:false)?>><?=$value['name']?></option>
    					<?php endforeach;?>
    				</select>
                </div>
                
                <?php 
    		 		$startdate = $check_rate_info['is_default'] || $check_rate_info['is_default_date'] ? '' : $check_rate_info['startdate'];
    		 	?>
                <div class="col-xs-3">				
					 <label for="checkin_date"><?=lang('start_date')?></label>
					 <?php foreach ($tour_departures as $k => $value):?>
					 
					 <?php
					       $is_selected_depart = ($check_rate_info['departure_id'] == $value['id'] || $k == 0) ? true : false;
					 ?>
					 
					 <?php if($value['departure_date_type'] == DEPARTURE_SPECIFIC_DATES):?>
					 <div id="departure_date_<?=$value['id']?>" class="dp_date <?=$is_selected_depart ? '' : 'hide'?>">
    					 <?php $departure_dates = get_specific_dates($value['departure_specific_date']);?>
					     <select class="form-control input-sm" id="checkin_date_<?=$value['id']?>" name="startdate_<?=$value['id']?>">
                            <?php foreach ($departure_dates as $s_date):?>
                            <option value="<?=$s_date?>" <?=set_select('startdate', $s_date, $startdate == $s_date)?>><?=$s_date?></option>
                            <?php endforeach;?>
					     </select>
					 </div>
					 <?php else:?>
					 <div id="departure_date_<?=$value['id']?>" class="dp_date <?=$is_selected_depart ? '' : 'hide'?>">
    					 <span class="icon-after">
    		    		 	<input type="text" class="form-control input-sm" id="checkin_date_<?=$value['id']?>" name="startdate_<?=$value['id']?>" 
    		    		 	placeholder="<?=lang('placeholder_date')?>" value="<?=$startdate?>">
    		    		 	
    		    		 	<span id="btn_checkin_date" class="icon icon-calendar"></span>
    	    			 </span>
					 </div>
					 <?php endif;?>
					 
					 <?php endforeach;?>
					 
					 <input type="hidden" name="startdate" value="<?=$startdate?>" id="multi_startdate">
		    		 <input type="hidden" name="action" value="<?=ACTION_CHECK_RATE?>">	    
				</div>
				
				<?php 
    		 		$enddate = $check_rate_info['is_default'] ? lang('input_startdate_please') : $check_rate_info['enddate'];
    		 	?>
				<div class="col-xs-4">
				    <label for="checkout_date"><?=lang('end_date')?></label>
				    <span class="help-block" id="checkout_date_display"><?=$enddate?></span>
					<input type="hidden" name="enddate" id="checkout_date" value="<?=$enddate?>">
				</div>
		    </div>
		    
		    <div class="row margin-top-5">
				
				<div class="col-xs-2">
					<label for="adults"><?=lang('adult_label')?></label>
				    <select class="form-control input-sm" id="adults" name="adults">
					  <?php for($i = 1; $i <= CRUISE_TOUR_MAX_ADULTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('adults', $i, isset($check_rate_info['adults']) && $check_rate_info['adults'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-2">
					<label for="children"><?=$chd_label?></label>
				    <select class="form-control input-sm" id="children" name="children">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_CHILDREN; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('children', $i, isset($check_rate_info['children']) && $check_rate_info['children'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-2">
					<label for="children"><?=$inf_label?></label>
				    <select class="form-control input-sm" id="infants" name="infants">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_INFANTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('infants', $i, isset($check_rate_info['infants']) && $check_rate_info['infants'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-6">
				    <br>
					<button type="submit" onclick="return validate_tour_check_rate_form()" class="btn btn-bpv btn-check-rate pull-right"><?=lang('btn_check_rate')?></button>
				</div>
			</div>
		    
		    
		    <?php else:?>
		    
		    <div class="row">
				<div class="col-xs-2">				
					 <label for="checkin_date"><?=lang('start_date')?></label>
					 <?php 
	    		 		$startdate = $check_rate_info['is_default'] || $check_rate_info['is_default_date'] ? '' : $check_rate_info['startdate'];
	    		 	 ?>
					 <?php if($tour['departure_date_type'] == DEPARTURE_SPECIFIC_DATES):?>
					     <?php $departure_dates = get_specific_dates($tour['departure_specific_date']);?>
					     <select class="form-control input-sm" id="checkin_date" name="startdate">
                            <?php foreach ($departure_dates as $s_date):?>
                            <option value="<?=$s_date?>" <?=set_select('startdate', $s_date, $startdate == $s_date)?>><?=$s_date?></option>
                            <?php endforeach;?>
					     </select>
					 <?php else:?>
    					 <span class="icon-after">
    		    		 	<input type="text" class="form-control input-sm" id="checkin_date" name="startdate" 
    		    		 	placeholder="<?=lang('placeholder_date')?>" value="<?=$startdate?>">
    		    		 	
    		    		 	<span id="btn_checkin_date" class="icon icon-calendar"></span>
    	    			 </span>
	    			 <?php endif;?>
		    		 <input type="hidden" name="action" value="<?=ACTION_CHECK_RATE?>">	    
				</div>
				<div class="col-xs-2">
				    <label for="checkout_date"><?=lang('end_date')?></label>
				    
				    <?php 
	    		 		$enddate = $check_rate_info['is_default'] ? lang('input_startdate_please') : $check_rate_info['enddate'];
	    		 	?>
				    
				    <span class="help-block" id="checkout_date_display"><?=$enddate?></span>
					<input type="hidden" name="enddate" id="checkout_date" value="<?=$enddate?>">
				</div>
				<div class="col-xs-1 no-padding" style="white-space: nowrap; width: 12%">
					<label for="adults"><?=lang('adult_label')?></label>
				    <select class="form-control input-sm" id="adults" name="adults">
					  <?php for($i = 1; $i <= CRUISE_TOUR_MAX_ADULTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('adults', $i, isset($check_rate_info['adults']) && $check_rate_info['adults'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				<div class="col-xs-1 no-padding" style="margin-left: 20px; width: 12%">
					<label for="children"><?=$chd_label?></label>
				    <select class="form-control input-sm" id="children" name="children">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_CHILDREN; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('children', $i, isset($check_rate_info['children']) && $check_rate_info['children'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				<div class="col-xs-1 no-padding" style="margin-left: 20px; width: 12%">
					<label for="children"><?=$inf_label?></label>
				    <select class="form-control input-sm" id="infants" name="infants">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_INFANTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('infants', $i, isset($check_rate_info['infants']) && $check_rate_info['infants'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				<div class="col-xs-3" style="padding-right: 0; padding-top: 10px">	 
					<button type="submit" onclick="return validate_tour_check_rate_form()" class="btn btn-bpv btn-check-rate pull-right"><?=lang('btn_check_rate')?></button>
				</div>
			</div>
		    
		    <?php endif;?>
	
	</form>
	</div>
</div>

<?php if(!empty($tour_departures)):?>
<script>
	$('#departure_id').change(function (){

		var id = $(this).val();

		get_selected_departure_date();

		get_check_out_date('#checkin_date_' + id, '#stay_night', '#checkout_date', '#checkout_date_display');

		if($( '#checkin_date_' + id ).val() != '') {
			check_accommodation_rates();
		}
		
	});

	$("#departure_id > option").each(function() {
		id = $(this).val();
		$('#departure_date_' + id).change(function (){
			str = $(this).attr('id').split('_');
			var startdate = $( '#checkin_date_' + str[2] ).val();
			$('#multi_startdate').val(startdate);
		});
	});

    function get_selected_departure_date() {
    	var id = $('#departure_id').val();
        
    	$('.dp_date').addClass('hide');
		$( '#departure_date_' + id ).removeClass('hide');

		var startdate = $( '#checkin_date_' + id ).val();
		$('#multi_startdate').val(startdate);
    }

    get_selected_departure_date();
</script>
<?php endif;?>