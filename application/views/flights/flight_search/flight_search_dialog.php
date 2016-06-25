<?php 
	$mobile_detect = new Mobile_Detect();
	$is_tablet = $mobile_detect->isTablet();
?>
<!-- Modal -->
<div class="modal fade" id="flightModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="icon btn-support-close"></span>
				</button>
				<h4 class="modal-title" id="flightModalLabel">
					<?=lang('flight_from')?> <b id="dg_txt_from" class="bpv-color-title"></b>
					 <?=lang('flight_to')?> <b id="dg_txt_to" class="bpv-color-title"></b>
				</h4>
			</div>
			<div class="modal-body">
				<form id="frmSearchDialogForm" name="frmSearchDialogForm" method="get" action="<?=get_url(FLIGHT_SEARCH_PAGE)?>">
					<div class="row form-group">
						<div class="col-xs-12 fligh-item">
							<img src="<?=get_static_resources('media/flight/VN.gif')?>" class="floatL" id="dg_airline_img">
							<label class="floatL" id="dg_airline_name">Vietnam Airlines</label>
							<input type="hidden" name="From" id="dg_from" value="">
							<input type="hidden" name="To" id="dg_to" value="">
							<input type="hidden" name="Airline" id="dg_airline_code">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-6">
							<label for="flight_dialog_departure_date"><?=lang('search_fields_departure')?></label>
							<span class="icon-after">
				    			<input type="text" class="form-control" name="Depart" id="flight_dialog_departure_date" 
				    				value="<?=$flight_search_criteria['Depart']?>" autocomplete="off" <?php if($is_tablet):?>readonly="readonly"<?php endif;?>>
				    			<span id="btn_flight_dialog_departure_date" class="icon icon-calendar"></span>
			    			</span>
						</div>
						<div class="col-xs-6">
							<label for="flight_dialog_returning_date"><?=lang('search_fields_return')?></label>
							<span class="icon-after">
			   		 			<input type="text" class="form-control" name="Return" id="flight_dialog_returning_date" 
			   		 				value="<?=$flight_search_criteria['Return']?>" autocomplete="off" <?php if($is_tablet):?>readonly="readonly"<?php endif;?>>
			   		 			<span id="btn_flight_dialog_returning_date" class="icon icon-calendar"></span>
			   		 		</span>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-4">
							<label for="adults"><?=lang('search_fields_adults')?></label>
							<select class="form-control" name="ADT" id="dialog_adt">
								<?php for($i=1; $i <= FLIGHT_MAX_ADULTS; $i++):?>
									<option value="<?=$i?>" <?=set_select('ADT', $i, $flight_search_criteria['ADT'] == $i ? true : false)?>><?=$i?></option>
								<?php endfor;?>
							</select>
						</div>
						<div class="col-xs-4">
							<label for="adults"><?=lang('search_fields_children')?></label>
							<select class="form-control" name="CHD" id="dialog_chd">
								<?php for($i=0; $i <= FLIGHT_MAX_CHILDREN; $i++):?>
								<option value="<?=$i?>" <?=set_select('CHD', $i, $flight_search_criteria['CHD'] == $i ? true : false)?>><?=$i?></option>
								<?php endfor;?>
							</select>
						</div>
						<div class="col-xs-3">
							<label for="adults"><?=lang('search_fields_infants')?></label>
							<select class="form-control" name="INF" id="dialog_inf">
								<?php for($i=0; $i <= FLIGHT_MAX_INFANTS; $i++):?>
								<option value="<?=$i?>" <?=set_select('INF', $i, $flight_search_criteria['INF'] == $i ? true : false)?>><?=$i?></option>
								<?php endfor;?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" name="action" value="<?=ACTION_SEARCH?>" onclick="return validate_flight_search_dialog()" class="btn btn-bpv btn-search pull-right">
							<?=lang('view_price')?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var cal_load = new Loader();
	cal_load.require(
		<?=get_libary_asyn_js('datepicker')?>, 
	  function() {
	
	  	set_up_flight_dialog_calendar();
	  	  
	  });

	init_flight_search_dialog();
</script>