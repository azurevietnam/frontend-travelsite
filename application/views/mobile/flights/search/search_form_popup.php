<form id="frm_flight_search"  name="frm_flight_search" class="<?=$is_home_page ? 'form-horizontal' : 'form-vertical'?>" method="get" action="<?=get_page_url(FLIGHT_SEARCH_PAGE)?>">	
	<div class="row">
		<div class="col-xs-4 roundway">					
			<div class="radio"> 
				<label> <input type="radio" onclick="show_return_date('roundway')" value="roundway" name="Type" <?=set_checkbox('flight_type', 'roundway', $search_criteria['Type'] == 'roundway'?TRUE:FALSE); ?>/> <?=lang('roundtrip')?></label>
			</div>
		</div>
		
		<div class="col-xs-6 oneway">
			<div class="radio">
				<label> <input type="radio" onclick="show_return_date('oneway')" value="oneway" name="Type" <?=set_checkbox('flight_type', 'oneway', $search_criteria['Type'] == 'oneway'?TRUE:FALSE); ?>/> <?=lang('one_way')?></label>
			</div>
		</div>
	</div>
	
	
	<div class="row margin-bottom-15">
		<label class="col-xs-4"><?=lang('flight_origin')?>:</label>
		<div class="ui-widget col-xs-8">
			<select class="form-control bpt-input-xs" name="From" id="flight_from" title="<?=lang('flight_placeholder')?>">
				<option value=""><?=lang('flight_placeholder')?></option>
				<?php foreach ($flight_destinations as $value):?>
					<option value="-1"><?=$value['name']?></option>
					<?php foreach ($value['destinations'] as $val):?><option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('From', strval($val['destination_code']), isset($search_criteria['From_Code']) && $search_criteria['From_Code'] == strval($val['destination_code']))?>><?=$val['name']?>(<?=$val['destination_code']?>)</option>
					<?php endforeach;?>
				<?php endforeach;?>
			</select>
		</div>
	</div>

	<div class="row margin-bottom-20">
		<label class="col-xs-4" style="padding-right: 0px;"><?=lang('departure_date')?>:</label>
		<div class="col-xs-8 no-padding input" id="date_picker_depart">
			<?=$datepicker_depart?>
		</div>
	</div>

	<div class="row margin-bottom-15">
		<label class="col-xs-4"><?=lang('flight_destination')?>:</label>
		<div class="col-xs-8" id="to_des">
			<select class="form-control bpt-input-xs" name="To" id="flight_to" title="<?=lang('flight_placeholder')?>">
				<option value=""><?=lang('flight_placeholder')?></option>
				<?php foreach ($flight_destinations as $value):?>
				<option value="-1"><?=$value['name']?></option>
					<?php foreach ($value['destinations'] as $val):?><option value="<?=$val['name']?> (<?=$val['destination_code']?>)" <?=set_select('To', strval($val['destination_code']), isset($search_criteria['To_Code']) && $search_criteria['To_Code'] == strval($val['destination_code']))?>><?=$val['name']?> (<?=$val['destination_code']?>)</option>
					<?php endforeach;?>
				<?php endforeach;?>
			</select>
		</div>
	</div>
	
	<div class="row margin-bottom-15 return-container">
		<label class="col-xs-4"><?=lang('return_date')?>:</label>
		<div class="col-xs-8 no-padding input" id="date_picker_return">
			<?=$datepicker_return?>
		</div>
	</div>
	
	
	<div class="row margin-bottom-15">
		<div class="col-xs-4 adults">
			<label><?=lang('flight_adults')?>:</label>
			<select class="form-control bpt-input-xs" style="width: 70%;" name="ADT" id="flight_adults">
				<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
                 <option value="<?=$i?>" <?=set_select('adults', $i, $search_criteria['ADT'] == $i? true: false)?>><?=$i?></option>
                 <?php endfor;?>
             </select>
		</div>
		<div class="col-xs-4 no-padding children">
			<label><?=lang('flight_children')?>:</label>
			<select class="form-control bpt-input-xs" style="width: 55%;" name="CHD" id="flight_children">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                <option value="<?=$i?>" <?=set_select('children', $i, $search_criteria['CHD'] == $i? true: false)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
		</div>
		<div class="col-xs-4 infants">
			<label><?=lang('flight_infants')?>:</label>
			<select class="form-control bpt-input-xs" style="width: 70%;" name="INF" id="flight_infants">
				<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                	<option value="<?=$i?>" <?=set_select('infants', $i, $search_criteria['INF'] == $i? true: false)?>><?=$i?></option>
                <?php endfor;?>
            </select>
		</div>
	</div>
		
	<div class="col-xs-offset-6">
		<button type="submit" id="search_button" onclick="return validate_flight_search()" class="search_button btn btn-blue btn-block"><?=lang('search_flight')?></button>		
	</div>
</form>
