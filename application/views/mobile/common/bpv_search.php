<?php 
	$is_flight = $this->session->userdata('MENU') == MNU_FLIGHTS;
?>

<div class="bpv-search">
	<h2>
		<span class="icon icon-search"></span> <span id="search_label"><?=$is_flight? lang('search_cheap_ticket') : lang('search_hotels')?></span>
	</h2>

	<div class="bpv-search-content">
		
		<div class="row form-group search-opts">
			<?php if(!$is_flight):?>
				<div class="pd-right-0 <?=!isset($search_small) ? 'col-xs-3' : 'col-xs-4'?>">
					<input type="radio" checked="checked" name="search_type" value="0" onclick="check_search_type()">
					<?=lang('search_label_hotels')?>
				</div>
				<div class="col-xs-4">
					<input type="radio" name="search_type" value="1" onclick="check_search_type()">
					<?=lang('search_label_flights')?>
				</div>
			<?php else:?>
				<div class="pd-right-0 col-xs-4">
					<input type="radio" checked="checked" name="search_type" value="1" onclick="check_search_type()">
					<?=lang('search_label_flights')?>
				</div>
				<div class="col-xs-4">
					<input type="radio" name="search_type" value="0" onclick="check_search_type()">
					<?=lang('search_label_hotels')?>
				</div>
			<?php endif;?>
			<span style="display:none" id="txt_search_label_0"><?=lang('search_hotels')?></span>
			<span style="display:none" id="txt_search_label_1"><?=lang('search_cheap_ticket')?></span>
		</div>
		
		<div id="tab_search_hotel" <?php if($is_flight):?>style="display:none"<?php endif;?>>
			<form role="form" id="hotel_search_form" name="hotel_search_form" method="post" action="<?=get_url(HOTEL_SEARCH_PAGE)?>">
			<div class="row form-group">
				<div class="col-xs-12">
				<label for="destination"><?=lang('search_hotel_label')?></label>
					<span class="div-destination">
	    				<input type="text" class="form-control" name="destination" id="destination" maxlength="100"
	    					value="<?= !empty($hotel_search_criteria['destination']) ? $hotel_search_criteria['destination'] : ''?>" 
	    					placeholder="<?=lang('placeholder_hotel_destination')?>" autocomplete="off">
	    			</span>
	    			<input type="hidden" name="hotel_destination_input" id="hotel_destination_input">
			    	<input type="hidden" name="oid" id="oid" value="<?=isset($hotel_search_criteria['oid'])?$hotel_search_criteria['oid']:''?>">
			    	<input type="hidden" id="is_update_des" value="<?=empty($hotel_search_criteria['selected_des'])?'1':'0'?>">
				</div>
			</div>
			<div class="row form-group">
				<div class="col-xs-5">
					<label for="startdate"><?=lang('check_in_date')?></label>
					<span class="icon-after">
		    			<input type="text" class="form-control" name="startdate" id="startdate" maxlength="10" 
		    				placeholder="<?=lang('placeholder_date')?>"		    				
		    				<?php 
		    					$startdate = $hotel_search_criteria['is_default'] || empty($hotel_search_criteria['startdate']) || !check_bpv_date($hotel_search_criteria['startdate']) ? '' : $hotel_search_criteria['startdate'];
		    				?>
		    				value="<?=$startdate?>" autocomplete="off">
		    			<span class="glyphicon glyphicon-calendar" id="btn_startdate"></span>
	    			</span>
				</div>
				<div class="col-xs-3">
					<label for="night"><?=lang('number_of_nights')?></label>
					<select class="form-control" id="night" name="night">
						<?php for($i=1; $i <= HOTEL_MAX_NIGHTS; $i++):?>
						<option value="<?=$i?>" <?=set_select('night', $i, $hotel_search_criteria['night'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="enddate"><?=lang('check_out_date')?></label>
					<div style="display: inline-block;">
						
						<?php 
	    					$enddate = $hotel_search_criteria['is_default'] || empty($hotel_search_criteria['enddate']) || !check_bpv_date($hotel_search_criteria['enddate']) ? '' : $hotel_search_criteria['enddate'];
	    				?>
	    				
						<input type="hidden" id="enddate" name="enddate" value="<?=$enddate?>">
						<span id="show_search_end_date"><?=$enddate?></span>
						<!-- 
						<span class="icon icon-calendar" id="btn_enddate"></span>
						 -->
					</div>
				</div>
			</div>
			<div class="row form-group search-btn-group">
				
				<div class="col-xs-8">
					<?php if(!isset($search_small)):?>
					<span class="icon icon-number-one"></span><h3 class="bpv-color-promotion"><?=lang('search_label_why_us')?></h3>
					<?php endif;?>
				</div>
				
				<div class="col-xs-4">
					<button type="submit" class="btn btn-bpv btn-search pull-right" 
						name="action" value="<?=ACTION_SEARCH?>"
						onclick="return validate_hotel_search()"><?=lang('btn_search_now')?></button>
				</div>
			</div>
			</form>
		</div>
		
		<div id="tab_search_flight" <?php if(!$is_flight):?>style="display:none"<?php endif;?>>
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
				<div class="col-xs-4">
					<label for="departure_date"><?=lang('search_fields_departure')?></label>
					<span class="icon-after">
		    			<input type="text" class="form-control" name="Depart" id="flight_departure_date"
		    				placeholder="<?=lang('placeholder_date')?>" 
		    				value="<?=$flight_search_criteria['Depart']?>" autocomplete="off">
		    			<span class="icon icon-calendar" id="btn_flight_departure_date"></span>
	    			</span>
				</div>
				<div class="col-xs-4 return-container">
					<label for="returning_date"><?=lang('search_fields_return')?></label>
					<span class="icon-after">
	   		 			<input type="text" class="form-control" name="Return" id="flight_returning_date"
	   		 				placeholder="<?=lang('placeholder_date')?>" 
	   		 				value="<?=$flight_search_criteria['Return']?>" autocomplete="off">
	   		 			<span class="icon icon-calendar" id="btn_flight_returning_date"></span>
	   		 		</span>
				</div>
				
				<div class="col-xs-4" style="padding-top:27px;font-size:12px">
					<a id="delete_return" href="javascript:void(0)" onclick="delete_flight_return()" class="bpv-color-warning" <?php if(empty($flight_search_criteria['Return'])):?>style="display:none"<?php endif;?>><?=lang('flight_delete_return')?></a>
				</div>
			</div>
			<div class="row form-group">
				<div class="col-xs-4">
					<label for="adults"><?=lang('search_fields_adults')?></label>
					<select class="form-control" name="ADT" id="adt">
						<?php for($i=1; $i <= FLIGHT_MAX_ADULTS; $i++):?>
							<option value="<?=$i?>" <?=set_select('ADT', $i, $flight_search_criteria['ADT'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="adults"><?=lang('search_fields_children')?></label>
					<select class="form-control" name="CHD" id="chd">
						<?php for($i=0; $i <= FLIGHT_MAX_CHILDREN; $i++):?>
						<option value="<?=$i?>" <?=set_select('CHD', $i, $flight_search_criteria['CHD'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
				<div class="col-xs-4">
					<label for="adults"><?=lang('search_fields_infants')?></label>
					<select class="form-control" name="INF" id="inf">
						<?php for($i=0; $i <= FLIGHT_MAX_INFANTS; $i++):?>
						<option value="<?=$i?>" <?=set_select('INF', $i, $flight_search_criteria['INF'] == $i ? true : false)?>><?=$i?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>
			<div class="row form-group search-btn-group">
				<div class="col-xs-8">
					<?php if(!isset($search_small)):?>
					<span class="icon icon-number-one"></span><h3 class="bpv-color-promotion"><?=lang('search_label_why_us')?></h3>
					<?php endif;?>
				</div>
				<div class="col-xs-4">
					<button type="submit" name="action" value="<?=ACTION_SEARCH?>" class="btn btn-bpv btn-search pull-right" onclick="return validate_flight_search()">
						<?=lang('btn_search_now')?></button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">

//$(document).ready(function() {
	
	var cal_load = new Loader();
	cal_load.require(
			<?=get_libary_asyn_js('jquery-ui-datepicker')?>, 
	      function() {
	         	 // Callback
	      	set_up_hotel_calendar();
	
	      	set_up_flight_calendar();

	      	if (typeof(set_up_flight_dialog_calendar) == "function"){
	      		set_up_flight_dialog_calendar();
	      	}    
	      });
	
	var au_load = new Loader();
	au_load.require(
		  <?=get_libary_asyn_js('typehead')?>, 
	      function() {
	         	 // Callback
	      	set_up_hotel_autocomplete(true);   
	      }); 
       				
	init_hotel_search(true, true);
	init_flight_search();

//});
</script>