<?php 
	$chd_label = lang('children_label').'('.$cruise['infant_age_util'].'-'.$cruise['children_age_to'].')';
	$inf_label = lang('infant_label').'(<'.$cruise['infant_age_util'].')';
?>
<div class="bpv-check-rate-form margin-bottom-20">
	<h2><?=lang('check_rate_title')?></h2>
	<div class="content">
	
	<form id="check_rate_form" role="form" method="get">
		<?php if(isset($tours)):?>
		
		<div class="row">
			
			<div class="col-xs-5">
				<label for="adults"><?=lang('cruise_tours')?></label>
			    <select class="form-control input-sm" id="tour_id" name="tour_id">
					<?php foreach ($tours as $tour):?>
						<option value="<?=$tour['id']?>" duration="<?=$tour['duration']?>" <?=set_select('tour_id', $tour['id'], $check_rate_info['tour_id'] == $tour['id'] ? true:false)?>><?=$tour['name']?></option>
					<?php endforeach;?>
				</select>
			</div>
			<input type="hidden" id="stay_night" value="">
			
			
			<div class="col-xs-3">				
					 <label for="checkin_date"><?=lang('start_date')?></label>
					 <span class="icon-after">
					 	<?php 
		    		 		$startdate = $check_rate_info['is_default'] ? '' : $check_rate_info['startdate'];
		    		 	?>
		    		 	
		    		 	<input type="text" class="form-control input-sm" id="checkin_date" name="startdate" 
		    		 	placeholder="<?=lang('placeholder_date')?>" value="<?=$startdate?>">
		    		 	
		    		 	<span id="btn_checkin_date" class="icon icon-calendar"></span>
	    			</span>
		    		 <input type="hidden" name="action" value="<?=ACTION_CHECK_RATE?>">	    
				</div>
				
				<div class="col-xs-4">
				    <label for="checkout_date"><?=lang('end_date')?></label>
				    
				    <?php 
	    		 		$enddate = $check_rate_info['is_default'] ? lang('input_startdate_please') : $check_rate_info['enddate'];
	    		 	?>
				    
				    <span class="help-block" id="checkout_date_display"><?=$enddate?></span>
					<input type="hidden" name="enddate" id="checkout_date" value="<?=$enddate?>">
				</div>
		</div>
		<div class="row margin-top-10">
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
				<label for="infants"><?=$inf_label?></label>
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
			
			<input type="hidden" name="tour_id" value="<?=$tour['id']?>">
		    <input type="hidden" id="stay_night" value="<?=$tour['duration'] - 1?>">
		    
		    <div class="row">
				<div class="col-xs-2">				
					 <label for="checkin_date"><?=lang('start_date')?></label>
					 <span class="icon-after">
					 	<?php 
		    		 		$startdate = $check_rate_info['is_default'] ? '' : $check_rate_info['startdate'];
		    		 	?>
		    		 	
		    		 	<input type="text" class="form-control input-sm" id="checkin_date" name="startdate" 
		    		 	placeholder="<?=lang('placeholder_date')?>" value="<?=$startdate?>">
		    		 	
		    		 	<span id="btn_checkin_date" class="icon icon-calendar"></span>
	    			</span>
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

<?php if(isset($tours)):?>
<script>
	$('#tour_id').change(function (){
		getTourDuration();

		get_check_out_date('#checkin_date', '#stay_night', '#checkout_date', '#checkout_date_display');

		if($('#checkin_date').val() != '') {
			check_accommodation_rates();
		}
	});

	function getTourDuration(){
		var duration =  $('#tour_id').find(":selected").attr('duration');
		duration = parseInt(duration, 10) - 1;
		$('#stay_night').val(duration);
	}

	getTourDuration();
</script>
<?php endif;?>