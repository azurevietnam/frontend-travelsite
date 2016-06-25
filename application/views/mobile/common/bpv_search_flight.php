
<div class="bpv-search">
	<h2>
		<?=lang('search_cheap_ticket')?>
	</h2>

	<div class="bpv-search-content">
		
		<form role="form" id="flight_search_form" name="flight_search_form" method="get" action="<?=get_url(FLIGHT_SEARCH_PAGE)?>">
			
			<div class="row form-group">
				<div class="col-xs-6">
					<label for="flight_from_code"><?=lang('search_fields_from')?></label>
					
					<select class="form-control" id="flight_from" name="From">
						<option value=""><?=lang('select_flight_origin')?></option>
						<?php foreach ($flight_destinations as $value):?>
						<optgroup label="<?=$value['name']?>">
							<?php foreach ($value['destinations'] as $val):?>
							<option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('From', strval($val['destination_code']), isset($flight_search_criteria['From_Code']) && $flight_search_criteria['From_Code'] == strval($val['destination_code']))?>>
							<?=$val['name']?> (<?=$val['destination_code']?>)
							</option>
							<?php endforeach;?>
						</optgroup>
						<?php endforeach;?>
					</select>
					

				</div>
				<div class="col-xs-6">
					<label for="flight_to_code"><?=lang('search_fields_to')?></label>
					
					<select class="form-control" id="flight_to" name="To">
						<option value=""><?=lang('select_flight_destination')?></option>
						<?php foreach ($flight_destinations as $value):?>
						<optgroup label="<?=$value['name']?>">
							<?php foreach ($value['destinations'] as $val):?>
							<option data-value="<?=$val['destination_code']?>" value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('To', strval($val['destination_code']), isset($flight_search_criteria['To_Code']) && $flight_search_criteria['To_Code'] == strval($val['destination_code']))?>>
							<?=$val['name']?> (<?=$val['destination_code']?>)
							</option>
							<?php endforeach;?>
						</optgroup>
						<?php endforeach;?>
					</select>
					
					<input type="hidden" id="is_update_fly_to" value="<?=empty($flight_to)?'1':'0'?>">
					
				</div>
			</div>
			<div class="row form-group">
				<div class="col-xs-6">
					<label for="departure_date"><?=lang('search_fields_departure')?></label>
					<span class="icon-after">
		    			<input type="text" class="form-control bpv-date-input" name="Depart" id="flight_departure_date"
		    				placeholder="<?=lang('placeholder_date')?>" 
		    				value="<?=$flight_search_criteria['Depart']?>" autocomplete="off" readonly="readonly">
		    				<span class="glyphicon glyphicon-calendar" id="btn_flight_departure_date"></span>
	    			</span>
				</div>
				<div class="col-xs-6 return-container">
					<label for="returning_date"><?=lang('search_fields_return')?></label>
					<span class="icon-after">
	   		 			<input type="text" class="form-control bpv-date-input" name="Return" id="flight_returning_date"
	   		 				placeholder="<?=lang('placeholder_date')?>" 
	   		 				value="<?=$flight_search_criteria['Return']?>" autocomplete="off" readonly="readonly">
	   		 			<span class="glyphicon glyphicon-calendar" id="btn_flight_returning_date"></span>
	   		 		</span>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-xs-6 col-xs-offset-6" style="font-size:12px">
					<a id="delete_return" href="javascript:void(0)" onclick="delete_flight_return()" class="bpv-color-warning" <?php if(empty($flight_search_criteria['Return'])):?>style="display:none"<?php endif;?>>
						<span class="glyphicon glyphicon-remove"></span>
						<?=lang('flight_delete_return')?>
					</a>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-xs-4">
					<label for="adults" style="font-size:13px"><?=lang('search_fields_adults')?></label>
					<select class="form-control" name="ADT" id="adt">
						<?php for($i=1; $i <= FLIGHT_MAX_ADULTS; $i++):?>
							<option value="<?=$i?>" <?=set_select('ADT', $i, $flight_search_criteria['ADT'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="children" style="font-size:13px"><?=lang('search_fields_children')?></label>
					<select class="form-control" name="CHD" id="chd">
						<?php for($i=0; $i <= FLIGHT_MAX_CHILDREN; $i++):?>
						<option value="<?=$i?>" <?=set_select('CHD', $i, $flight_search_criteria['CHD'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="infants" style="font-size:13px"><?=lang('search_fields_infants')?></label>
					<select class="form-control" name="INF" id="inf">
						<?php for($i=0; $i <= FLIGHT_MAX_INFANTS; $i++):?>
						<option value="<?=$i?>" <?=set_select('INF', $i, $flight_search_criteria['INF'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" name="action" value="<?=ACTION_SEARCH?>" class="btn btn-bpv btn-search btn-block" onclick="return validate_flight_search()">
						<?=lang('btn_search_now')?></button>
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
	      	set_up_flight_calendar(true);

			/*
	      	if (typeof(set_up_flight_dialog_calendar) == "function"){
	      		set_up_flight_dialog_calendar();
	      	}*/
	      	    
	      });

       				

	init_flight_search();

//});
</script>