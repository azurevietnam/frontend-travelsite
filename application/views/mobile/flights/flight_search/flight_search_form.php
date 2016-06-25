<?=load_search_waiting(lang('flight_search_updating'),'udating')?>

<div class="bpv-search">
	<h2><span class="icon icon-flight-search"></span> <?=lang('search_cheap_ticket')?></h2>
	<div class="bpv-search-content">
		<form role="form" id="flight_search_form" name="flight_search_form" method="get" action="<?=get_url(FLIGHT_SEARCH_PAGE)?>">
			
			<div class="row form-group" id="flight_type">
				<div class="col-xs-6">
					<div class="radio" style="margin:0">
					  <label>
					    <input onclick="select_flight_type()" type="radio" name="Type" value="<?=FLIGHT_TYPE_ROUNDWAY?>" <?=set_radio('Type', FLIGHT_TYPE_ROUNDWAY, !empty($search_criteria['Type']) && $search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY)?>>
					   	<?=lang('search_fields_roundtrip')?>
					  </label>
					</div>

				</div>
				<div class="col-xs-6">
					<div class="radio" style="margin:0">
					  <label>
					    <input onclick="select_flight_type()" type="radio" name="Type" value="<?=FLIGHT_TYPE_ONEWAY?>" <?=set_radio('Type', FLIGHT_TYPE_ONEWAY, !empty($search_criteria['Type']) && $search_criteria['Type'] == FLIGHT_TYPE_ONEWAY)?>>
					   	<?=lang('search_fields_oneway')?>
					  </label>
					</div>
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-xs-6">
					<label for="flight_from"><?=lang('search_fields_from')?></label>
					
					<select class="form-control" id="flight_from" name="From">
						<option value=""><?=lang('select_flight_origin')?></option>
						<?php foreach ($flight_destinations as $value):?>
						<optgroup label="<?=$value['name']?>">
							<?php foreach ($value['destinations'] as $val):?>
							<option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('From', strval($val['destination_code']), isset($search_criteria['From_Code']) && $search_criteria['From_Code'] == strval($val['destination_code']))?>>
							<?=$val['name']?> (<?=$val['destination_code']?>)
							</option>
							<?php endforeach;?>
						</optgroup>
						<?php endforeach;?>
					</select>
					
				</div>
				
				<div class="col-xs-6">
					<label for="flight_to"><?=lang('search_fields_to')?></label>
					
					<select class="form-control" id="flight_to" name="To">
						<option value=""><?=lang('select_flight_destination')?></option>
						<?php foreach ($flight_destinations as $value):?>
						<optgroup label="<?=$value['name']?>">
							<?php foreach ($value['destinations'] as $val):?>
							<option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('To', strval($val['destination_code']), isset($search_criteria['To_Code']) && $search_criteria['To_Code'] == strval($val['destination_code']))?>>
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
		    				value="<?=$search_criteria['Depart']?>" autocomplete="off" readonly="readonly">
		    			<span class="glyphicon glyphicon-calendar" id="btn_flight_departure_date"></span>
	    			</span>
				</div>
				<div class="col-xs-6 return-container">
					<label for="returning_date"><?=lang('search_fields_return')?></label>
					<span class="icon-after">
	   		 			<input type="text" class="form-control bpv-date-input" name="Return" id="flight_returning_date"
	   		 				placeholder="<?=lang('placeholder_date')?>"  
	   		 				value="<?=$search_criteria['Return']?>" autocomplete="off" readonly="readonly">
	   		 			<span class="glyphicon glyphicon-calendar" id="btn_flight_returning_date"></span>
	   		 		</span>
	   		 		
	   		 		<div class="margin-top-5" style="font-size:12px;padding-left:13px">
						<a id="delete_return" href="javascript:void(0)" onclick="delete_flight_return()" class="bpv-color-warning" <?php if(empty($search_criteria['Return'])):?>style="display:none"<?php endif;?>>
							<span class="glyphicon glyphicon-remove"></span>
							<?=lang('flight_delete_return')?>
						</a>
					</div>
			
				</div>
			</div>
			
			<div class="row form-group">
				<div class="col-xs-4">
					<label for="adults" style="font-size:13px"><?=lang('search_fields_adults')?></label>
					<select class="form-control" name="ADT" id="adt">
						<?php for($i=1; $i <= FLIGHT_MAX_ADULTS; $i++):?>
							<option value="<?=$i?>" <?=set_select('ADT', $i, $search_criteria['ADT'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="children" style="font-size:13px"><?=lang('search_fields_children')?></label>
					<select class="form-control" name="CHD" id="chd">
						<?php for($i=0; $i <= FLIGHT_MAX_CHILDREN; $i++):?>
						<option value="<?=$i?>" <?=set_select('CHD', $i, $search_criteria['CHD'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="infants" style="font-size:13px"><?=lang('search_fields_infants')?></label>
					<select class="form-control" name="INF" id="inf">
						<?php for($i=0; $i <= FLIGHT_MAX_INFANTS; $i++):?>
						<option value="<?=$i?>" <?=set_select('INF', $i, $search_criteria['INF'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>
			
			
			<div class="row">
				<div class="col-xs-12">
					<button type="submit" id="submit" onclick="return validate_flight_search()" class="btn btn-bpv btn-search btn-block" name="action" value="<?=ACTION_SEARCH?>"><?=lang('btn_search_now')?></button>
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
       
      	set_up_flight_calendar(true);
      	  
      });

	init_flight_search();

//});
</script>