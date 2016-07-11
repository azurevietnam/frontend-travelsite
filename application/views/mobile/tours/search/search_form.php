<?php
	// set destination from search-form and specific destination-page
	$destination_name = !empty($search_criteria['destination']) ? $search_criteria['destination'] : '';
	$destination_name = !empty($destination) ?  $destination['name'] : $destination_name;

	$destination_id = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '';
	$destination_id = !empty($destination) ?  $destination['id'] : $destination_id;

	$travel_styles = !empty($search_criteria['travel_styles']) ? $search_criteria['travel_styles'] : array();

	$duration = !empty($search_criteria['duration']) ? $search_criteria['duration'] : '';
	$group_type = !empty($search_criteria['group_type']) ? $search_criteria['group_type'] : '';

	$budgets = !empty($search_criteria['budgets']) ? $search_criteria['budgets'] : array();
?>

<h2><?=lang('find_perfect__trip')?></h2>
<div class="bpv-search-content">
<form id="frm_tour_search" name="frm_tour_search" onsubmit="return validate_search('#tour_destination', '#departure_date')" method="get" action="<?=get_page_url(TOUR_SEARCH_PAGE)?>">
    <div class="form-group">
        <label><?=lang('destination')?></label>
        <input type="text" class="form-control" name="destination" id="tour_destination" value="<?=$destination_name?>" 
            placeholder="<?=lang('search_placeholder')?>" data-target="#tour_des_help_cnt">
    </div>
    <div class="row form-group">
        <div class="col-xs-6">
            <label><?=lang('departure_date')?></label>
            <?=$datepicker?>
        </div>
        <div class="col-xs-6">
            <label><?=lang('duration')?></label>
            <select class="form-control bpt-input-xs dropdown-toggle" name="duration" id="duration">
				<option value=""><?=lang('select_all')?></option>
				<?php foreach ($tour_durations as $key => $value) :?>
					<option value="<?=lang($value)?>" <?=set_select('duration', lang($value), lang($value) == $duration)?>><?=lang($value)?></option>
				<?php endforeach;?>
			</select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-xs-6 margin-bottom-5 text-highlight btn-group-search" data-target="#style_group_search">
            [ + ] <?=lang('travel_styles')?>
        </div>
        <div class="col-xs-6 margin-bottom-5 text-highlight btn-group-search" data-target="#budget_group_search">
            [ + ] <?=lang('tour_budget')?>
        </div>
        
        <div class="col-xs-6">
            <div class="list-group list-group-search" id="style_group_search">
            <?php foreach ($tour_travel_styles as $key => $value):?>
    		<div class="checkbox no-margin tour-travel-style-<?=$key?> list-group-item">
    		    <label>
    		      <?php
    		      	$tour_type_val = lang($value);
    		      ?>
    		      <input type="checkbox" class="-travel-styles" <?=set_checkbox('travel_styles', $tour_type_val, in_array($tour_type_val, $travel_styles))?> value="<?=$tour_type_val?>" name="travel_styles[]"> <?=$tour_type_val?>
    		    </label>
    		</div>
            <?php endforeach;?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="list-group list-group-search margin-bottom-10" id="budget_group_search">
            <?php foreach ($tour_budgets as $key => $value):?>
            <div class="checkbox no-margin list-group-item">
			    <?php
	 				$chc_val = lang($value);
	 			?>
			    <label>
			      <input type="checkbox" class="-budgets" value="<?=$chc_val?>" name="budgets[]" <?=set_checkbox('budgets', $chc_val, in_array($chc_val, $budgets))?>> <?=$chc_val?>
			    </label>
			</div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
    <div class="clearfix">
        <button type="submit" class="btn btn-blue btn-lg btn-block" name="action" value="search"><?=lang('search_now')?></button>
    </div>
    
    <input type="hidden" class="form-control" name="destination_id" id="tour_destination_id" value="<?=$destination_id?>">
</form>
</div>

<script type="text/javascript">
$('.btn-group-search').bpvToggle(function(){
	var html = $(this).html();
	if(html.indexOf('+') != -1) {
		html = html.replace('+', '-');
	} else {
		html = html.replace('-', '+');
	}
	$(this).html(html);
});

var cal_load = new Loader();
cal_load.require( <?=get_libary_asyn('typeahead')?>, function() {
    set_search_des_auto('<?=MODULE_TOUR?>');
});

<?php if(empty($search_criteria)):?>
    get_current_tour_search();
<?php endif;?>
</script>