<?php
// set destination from search-form and specific destination-page
$search_criteria['destination_id'] = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '30';
$search_criteria['destination'] = !empty($search_criteria['destination']) ? $search_criteria['destination'] : 'Hanoi';
$search_criteria['sort_by'] = !empty($search_criteria['sort_by']) ? $search_criteria['sort_by'] : 'recommended';

$destination_name = !empty($search_criteria['destination']) ? $search_criteria['destination'] : '';
$destination_name = !empty($destination) ?  $destination['name'] : $destination_name;

$destination_id = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '';
$destination_id = !empty($destination) ?  $destination['id'] : $destination_id;

$hotel_id = !empty($search_criteria['hotel_id']) ? $search_criteria['hotel_id'] : '';


?>

<h2><?=lang('search_hotel')?></h2>
<div class="bpv-search-content">
    <form id="frm_hotel_search" name="frm_hotel_search" class="form-horizontal" onsubmit="return validate_search('#hotel_destination', '#departure_date', 'hotel')" method="get" action="<?=get_page_url(HOTEL_SEARCH_PAGE)?>">
        <div class="form-group">
            <div class="col-xs-12">
                <label for="destination"><?=lang('destination')?></label>
                <input type="text" class="form-control" name="destination" id="hotel_destination" value="<?=$destination_name?>"
                       placeholder="<?=lang('hotel_search_title')?>" data-target="#hotel_des_help_cnt">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-6">
                <label><?=lang('field_arrive_date')?></label>
                <?=$datepicker?>
            </div>
            <div class="col-xs-6">
                <label><?=lang('hotel_nights')?></label>
                <select class="form-control bpt-input-xs dropdown-toggle " name="night" id="<?=$datepicker_options['night_nr_id']?>">
                    <option value=""><?=lang('select_all')?></option>
                    <?php foreach ($night as $value) :?>
                        <option value="<?=$value?>"  <?=set_select('night', $value, !empty($search_criteria['night']) && $search_criteria['night'] == $value)?>><?=$value?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <label><?=lang('star')?></label>
            </div>
            <div class="btn-group col-xs-12" data-toggle="buttons">
                <?php foreach($hotel_stars as $value):?>
                    <label class="btn btn-default <?=!empty($search_criteria['stars']) && in_array($value, $search_criteria['stars']) ? 'active' : ''?>">
                        <input type="checkbox" id="hotel_star_<?=$value?>" name="stars[]" value="<?=$value?>" autocomplete="off" <?=set_checkbox('hotel_stars', $value, !empty($search_criteria['stars']) && in_array($value, $search_criteria['stars']))?>> <span><?=lang('lbl_stars', $value)?></span>
                    </label>
                <?php endforeach;?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-blue btn-lg btn-block" name="action" value="search"><?=lang('search_now')?></button>
            </div>
        </div>
        <input type="hidden" name="destination_id" id="hotel_destination_id" value="<?=$destination_id?>">
        <input type="hidden" name="hotel_id" id="hotel_search_id" value="<?=$hotel_id?>">

        <div class="hidden" id="hotel_des_help_cnt"><?=lang('hotel_search_help')?></div>

        <input type="hidden" name="sort" id="hotel_sort_by" value="<?=$search_criteria['sort_by']?>">
    </form>
</div>

<script type="text/javascript">
    var cal_load = new Loader();
    cal_load.require( <?=get_libary_asyn('typeahead')?>, function() {
        set_search_des_auto('<?=MODULE_HOTEL?>');
    });

    <?php if(empty($search_criteria)):?>
    get_current_hotel_search();
    <?php endif;?>
</script>