<h2><?=lang('search_flight')?></h2>
<div class="bpv-search-content flight-search-form">
<form id="frm_flight_search"  name="frm_flight_search" class="form-horizontal" method="get" action="<?=get_page_url(FLIGHT_SEARCH_PAGE)?>">	
	
	<div class="btn-group form-group" data-toggle="buttons">
		<?php 
			$is_roundway = $search_criteria['Type'] == 'roundway';
			$is_oneway = $search_criteria['Type'] == 'oneway';
		?>
		<div class="col-xs-12">
			<label class="btn btn-default btn-sm <?=!empty($is_roundway) ? 'active' : ''?>" onclick="show_return_date('roundway')">
		    	<input type="radio" name="Type" id="roundway" value="roundway" onclick="show_return_date('roundway')" hidden="true" <?=set_checkbox('flight_type', 'roundway', $is_roundway); ?>> <?=lang('roundtrip')?>
		 	</label>
		  	<label class="btn btn-default btn-sm <?=!empty($is_oneway) ? 'active' : ''?>" onclick="show_return_date('oneway')">
		    	<input type="radio" name="Type" id="oneway" value="oneway"  hidden="true" <?=set_checkbox('flight_type', 'oneway', $is_oneway); ?>> <?=lang('one_way')?>
		  	</label>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-xs-6 padding-right-0">
			<label><?=lang('flight_origin')?>:</label>
			<div>
				<select class="form-control bpt-input-xs" name="From" id="flight_from" title="<?=lang('flight_placeholder')?>">
					<option value=""><?=lang('select_flight_destination')?></option>
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
		</div>
		<div class="col-xs-6">
			<label><?=lang('departure_date')?>:</label>
			<div class="input" id="date_picker_depart">
				<?=$datepicker_depart?>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-xs-6 padding-right-0">
			<label><?=lang('flight_destination')?>:</label>
			<div id="to_des">
				<select class="form-control bpt-input-xs" name="To" id="flight_to" title="<?=lang('flight_placeholder')?>">
					<option value=""><?=lang('select_flight_destination')?></option>
					<?php foreach ($flight_destinations as $value):?>
					<optgroup label="<?=$value['name']?>">
						<?php foreach ($value['destinations'] as $val):?><option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('To', strval($val['destination_code']), isset($search_criteria['To_Code']) && $search_criteria['To_Code'] == strval($val['destination_code']))?>><?=$val['name']?> (<?=$val['destination_code']?>)</option>
						<?php endforeach;?>
					</optgroup>
					<?php endforeach;?>
				</select>
			</div>
		</div>

		<div class="col-xs-6 return-container">
			<label><?=lang('return_date')?>:</label>
			<div class="input" id="date_picker_return">
				<?=$datepicker_return?>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-xs-4 adults">
			<label><?=lang('flight_adults')?></label>
			<select class="form-control bpt-input-xs" name="ADT" id="flight_adults">
				<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
                 <option value="<?=$i?>" <?=set_select('adults', $i, $search_criteria['ADT'] == $i? true: false)?>><?=$i?></option>
                 <?php endfor;?>
             </select>
		</div>
		<div class="col-xs-4 no-padding children">
			<label><?=lang('flight_children')?></label>
			<select class="form-control bpt-input-xs" name="CHD" id="flight_children">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                <option value="<?=$i?>" <?=set_select('children', $i, $search_criteria['CHD'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
		</div>
		<div class="col-xs-4 infants">
			<label><?=lang('flight_infants')?></label>
			<select class="form-control bpt-input-xs" name="INF" id="flight_infants">
				<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                	<option value="<?=$i?>" <?=set_select('infants', $i, $search_criteria['INF'] == $i? true: false)?>><?=$i?></option>
                <?php endfor;?>
            </select>
		</div>
	</div>
		
	<div>
		<button type="submit" id="search_button" onclick="return validate_flight_search()" class="search_button btn btn-blue btn-lg btn-block"><?=lang('search_now')?></button>		
	</div>
</form>
</div>
  
  
<script type="text/javascript">
// jqueryUI button plugin namespace collisions

$.fn.bootstrapBtn = $.fn.button.noConflict();

// Get jqueryUI
/*
 * *

var cal_load = new Loader();
cal_load.require(
	<? //=get_libary_asyn('jquery-ui-autocomplete')?>,
  function() {
		init_autocomplete();
		$("#flight_from").combobox();
		$("#flight_to").combobox();
  });
*/

change_flight_depart_return_date('departure','returning');

//var mapping_city = <?//=$flight_routes?>;

</script>