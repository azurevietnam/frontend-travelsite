<?php
// set destination from search-form and specific destination-page
$search_criteria['destination_id'] = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '';
$search_criteria['destination_name'] = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '';
$search_criteria['sort_by'] = !empty($search_criteria['sort_by']) ? $search_criteria['sort_by'] : SORT_BY_RECOMMEND;

$destination_name = !empty($search_criteria['destination']) ? $search_criteria['destination'] : '';
$destination_name = !empty($destination) ?  $destination['name'] : $destination_name;

$destination_id = !empty($search_criteria['destination_id']) ? $search_criteria['destination_id'] : '';
$destination_id = !empty($destination) ?  $destination['id'] : $destination_id;

$hotel_id = !empty($search_criteria['hotel_id']) ? $search_criteria['hotel_id'] : '';

?>
<form id="frm_hotel_search" class="<?=$is_home_page ? 'form-horizontal' : 'form-vertical'?> name="frm_hotel_search" onsubmit="return validate_search('#hotel_destination', '#start_date','hotel')" method="get" action="<?=get_page_url(HOTEL_SEARCH_PAGE)?>" >
<?php if(empty($multiple_search_forms)):?>
<div class="search-form <?=!empty($css)? $css : ''?>" <?php if(!empty($hotel_search_overview)):?>style="display: none;"<?php endif;?>>
    <div>
	    <h2 class="text-highlight">
	    <span class="icon icon-search-white"></span>
	        <?=lang('search_hotel')?>
	    </h2>
    </div>
    <?php endif;?>

	<div  class="search-content <?=$css_content?>">
	    <?php if($is_home_page):?>

	        <div class="form-group margin-top-5" id="hotel_destination_group">
	            <label for="destination" class="control-label col-xs-2 item-label">
	                <?=str_replace('...', '', lang('destination'))?>:
	                <span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#hotel_des_help_cnt"></span>
	            </label>
	            <div class="col-xs-10">
	                <input type="text" class="form-control input-default" name="destination" id="hotel_destination" value="<?=$destination_name?>" placeholder="<?=lang('search_placeholder')?>" data-placement="right" data-target="#hotel_des_help_cnt">
	            </div>
	        </div>

	        <div class="form-group">
	            <label class="col-xs-2 item-label">
	                <?=lang('star')?>:
	            </label>

	            <div class="col-xs-6">
	                <?php foreach ($hotel_stars as $value) :?>
	                    <label class="col-xs-4 padding-left-0">
	                        <input type="checkbox" class="" id="hotel_star_<?=$value?>" name="stars[]" value="<?=$value?>" >
	                        <span><?=$value?>*</span>
	                    </label>
	                <?php endforeach ;?>
	            </div>
	        </div>

	        <div class="form-group">
	            <label class="control-label col-xs-2 item-label">
	                <?=lang('hotel_arrive')?>:
	            </label>
	            <div class="row">
	                <?=$datepicker?>
	            </div>
	        </div>

	        <div class="clearfix"></div>
			<div class="row margin-bottom-15">
		        <div class="col-xs-4">
		            <label class="control-label col-xs-6 item-label padding-left-0">
		                <?=lang('hotel_nights')?>:
		            </label>
		            <div class="col-xs-6">
		                <select class="form-control bpt-input-xs" style="width: 118%;" name="night" id="<?=$datepicker_options['night_nr_id']?>" onchange="change_datepicker_date('#<?=$datepicker_options['date_id']?>', '', '#<?=$datepicker_options['night_nr_id']?>')">
		                    <?php foreach ($night as $value) :?>

		                        <option value="<?=$value?>"><?=$value?></option>

		                    <?php endforeach ;?>
		                </select>
		            </div>
		        </div>

		        <div class="col-xs-6 padding-left-0">
		            <label class="control-label col-xs-2 item-label padding-left-0" style="padding-left: 3px;">
		                <?=lang('hotel_depart')?>:
		            </label>
	                <div class="control-label item-label">
	                    <span id="<?=$datepicker_options['date_id']?>_end" class="margin-left-10"></span>
	                </div>
		        </div>
			</div>

	        <div class="row">
	            <div class="col-xs-2 pull-right col-xs-offset-10">
	                <button class="btn btn-blue btn-x-lg btn-block" type="submit"><?=lang('search_now')?></button>
	            </div>
	        </div>

	    <?php else:?>

	        <div class="margin-bottom-10 margin-top-5" id="hotel_destination_group">
	            <label for="control-label destination">
	                <?=str_replace('...', '', lang('destination'))?>:
	                <span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#hotel_des_help_cnt"></span>
	            </label>
	           <?php 
	                  //  $destination_id = 30;
	                  // $destination_id = 30;
	            ?>
	            <input type="text" class="form-control input-default" name="destination" id="hotel_destination" value="<?=$destination_name?>" placeholder="<?=lang('search_placeholder')?>" data-placement="right" data-target="#hotel_des_help_cnt">
	        </div>

	        <div class="margin-bottom-15">
	            <label class="control-label">
	                <?=lang('star')?>:
	            </label>
	            <div class="column_input star">
	                <?php foreach ($hotel_stars as $value) :?>
	                    <label class="control-label col-xs-4">
	                        <input type="checkbox" class="hotel-stars" id="hotel_star_<?=$value?>" name="stars[]" value="<?=$value?>" >
	                        <span><?=$value?>*</span>
	                    </label>
	                <?php endforeach ;?>
	            </div>
	        </div>

	        <div class="margin-bottom-15">
	            <label class="control-label item-label">
	                <?=lang('hotel_arrive')?>:
	            </label>
	            <div class="row">
	                <?=$datepicker?>
	            </div>
	        </div>

	        <div class="clearfix"></div>

	        <div class="row margin-bottom-15 col-xs-6">
	            <label class="control-label">
	                <?=lang('hotel_nights')?>:
	            </label>
	            <div>
	                <select class="form-control bpt-input-xs" style="width: 87%;" name="night" id="<?=$datepicker_options['night_nr_id']?>" onchange="change_datepicker_date('#<?=$datepicker_options['date_id']?>', '', '#<?=$datepicker_options['night_nr_id']?>')">
	                    <?php foreach ($night as $value) :?>

	                        <option value="<?=$value?>" <?=set_select($datepicker_options['night_nr_id'], $value,!empty($search_criteria['night']) && $value == $search_criteria['night'])?>><?=$value?></option>

	                    <?php endforeach ;?>
	                </select>
	            </div>
	        </div>

	        <div class="col-xs-6 margin-bottom-15">
	            <label class="control-label ">
	                <?=lang('hotel_depart')?>:
	            </label>
                <div class="margin-top-5">
                    <span id="<?=$datepicker_options['date_id']?>_end"></span>
                </div>
	        </div>


	        <div class="row">
	            <div class="col-xs-6 col-xs-offset-6">
	                <button class="btn btn-blue btn-block" type="submit"><?=lang('search_now')?></button>
	            </div>
	        </div>

	    <?php endif;?>

	</div>

    <?php if(empty($multiple_search_forms)):?>
</div>
<?php endif;?>

<input type="hidden" name="destination_id" id="hotel_destination_id" value="<?=$destination_id?>">
<input type="hidden" name="hotel_id" id="hotel_search_id" value="<?=$hotel_id?>">

<div class="hidden" id="hotel_des_help_cnt"><?=lang('hotel_search_help')?></div>

<input type="hidden" name="sort" id="hotel_sort_by" value="<?=$search_criteria['sort_by']?>">

</form>

<script type="text/javascript">

    <?php
		$date_id = $datepicker_options['date_id'];
	?>

    $('#<?=$date_id?>').change();

    var cal_load = new Loader();
    cal_load.require(
        <?=get_libary_asyn('typeahead')?>,
        function() {
            set_search_des_auto('<?=MODULE_HOTEL?>');
        });

    set_help('.glyphicon-question-sign');

    get_current_hotel_search();
</script>