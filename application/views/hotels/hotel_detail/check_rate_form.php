<div class="bpv-check-rate-form margin-bottom-20">
	<h2><?=lang('check_rate_title')?></h2>
	<div class="content">
		<div class="row">
			<form id="check_rate_form" role="form" method="get">
				
				<div class="col-xs-3">				
					 <label for="checkin_date"><?=lang('checkin_date')?></label>
					 <span class="icon-after">
		    		 	<input type="text" class="form-control" id="checkin_date" name="startdate" 
		    		 	placeholder="<?=lang('placeholder_date')?>"
		    		 	
		    		 	<?php 
		    		 		$startdate = $check_rate_info['is_default'] ? '' : $check_rate_info['startdate'];
		    		 	?>
		    		 	
		    		 	value="<?=$startdate?>">
		    		 	<span id="btn_checkin_date" class="icon icon-calendar"></span>
	    			</span>
	    		
		    		 <input type="hidden" name="hotel_id" value="<?=$hotel['id']?>">
		    		 <input type="hidden" name="action" value="<?=ACTION_CHECK_RATE?>">	    
				</div>
				
				<div class="col-xs-2">
					<label for="stay_night"><?=lang('stay_night')?></label>
				    <select class="form-control" id="stay_night" name="night" style="width:80px">
					  <?php for($i = 1; $i <= $max_nights; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('night', $i, isset($check_rate_info['night']) && $check_rate_info['night'] == $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-4">
				    <label for="checkout_date"><?=lang('checkout_date')?></label>
				    
				    <?php 
	    		 		$enddate = $check_rate_info['is_default'] ? lang('input_startdate_please') : $check_rate_info['enddate'];
	    		 	?>
				    
				    <span class="help-block" id="checkout_date_display"><?=$enddate?></span>
					<input type="hidden" name="enddate" id="checkout_date" value="<?=$enddate?>">
				</div>
				
				<div class="col-xs-3">
					<br>				 
					<button type="submit" onclick="return validate_hotel_check_rate_form()" class="btn btn-bpv btn-check-rate pull-right"><?=lang('btn_check_rate')?></button>
				</div>
			</form>
		</div>
	
	</div>
</div>

