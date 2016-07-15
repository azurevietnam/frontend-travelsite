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

<form id="frm_tour_search" class="<?=!empty($is_home_page) ? 'form-horizontal' : 'form-vertical'?>" name="frm_tour_search" onsubmit="return validate_search('#tour_destination', '#departure_date')" method="get" action="<?=get_page_url(TOUR_SEARCH_PAGE)?>">
<?php if(empty($multiple_search_forms)):?>
<div class="search-form <?=!empty($css)? $css : ''?>  <?=!empty($css_height_form)? $css_height_form : ''?>" <?php if(!empty($tour_search_overview)):?>style="display: none;"<?php endif;?>>
<div class="search-title">
	<h2 class="text-highlight">
		<span class="icon icon-search-white"></span>
		<?=lang('find_perfect__trip')?>
		<span class="glyphicon glyphicon-info-sign" data-placement="right" data-target="#tour_search_help_cnt"></span>
	</h2>
</div>
<?php endif;?>

<div class="searh-form-tour-home search-content <?=$css_content?>">
	<?php if(!empty($is_home_page)):?>

		<div class="form-group text-left margin-top-5">
			<label for="destination" class="control-label col-xs-2 item-label" style="width: 18%;">
				<?=lang('destination')?>:
				<span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#tour_des_help_cnt"></span>
			</label>
			<div class="col-xs-10"  style="width: 72%;">
				<input type="text" class="form-control" name="destination" id="tour_destination" value="<?=$destination_name?>" placeholder="<?=lang('search_placeholder')?>" data-target="#tour_des_help_cnt">
			</div>
		</div>

		<div class="form-group">
			<label for="departure_date" class="control-label col-xs-2 item-label"  style="width: 18%;"><?=lang('departure_date')?>:</label>
			<div class="row">
				<?=$datepicker?>
			</div>
		</div>



		<div class="form-group">
			<label for="duration" class="control-label col-xs-2 item-label" style="width: 18%;"><?=lang('duration')?>:</label>
			<div class="col-xs-2" >
				<select class="form-control bpt-input-xs dropdown-toggle " style="width: 104%;" name="duration" id="duration">
					<option value="">
						<?=lang('select_all')?>
					</option>

					<?php foreach ($tour_durations as $key => $value) :?>
						<?php
							$opt_val = lang($value);
						?>
						<option value="<?=$opt_val?>" <?=set_select('duration', $opt_val, $opt_val == $duration)?>>
							<?=$opt_val?>
						</option>
					<?php endforeach;?>
				</select>
			</div>

			<label for="group_type" class="control-label col-xs-2 item-label" style="width: 18%;"><?=lang('group_type')?>:</label>

			<div class="col-xs-3">
				<select class="form-control bpt-input-xs" name="group_type" id="group_type">
					<option value="">
						<?=lang('select_all')?>
					</option>
					<?php foreach($tour_group_types as $key => $value):?>
						<?php
							$group_type_val = lang($value);
						?>

						<option value="<?=$group_type_val?>" <?=set_select('group_type', $group_type_val, $group_type == $group_type_val)?>><?=$group_type_val?></option>

					<?php endforeach;?>
				</select>
			</div>

		</div>

		<?php if(!empty($show_type_tour)):?>
			<div class="row control-group">
				<label for="travel_styles" class="control-label col-xs-2 item-label" style="width: 18%;"><?=lang('travel_styles')?>:<!-- <span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#travel_style_help_cnt"></span> --></label>

					<?php foreach ($tour_travel_styles as $key => $value):?>
						<div class="col-xs-2 padding-right-0 tour-travel-style-<?=$key?>" style="width: 20%;">
							<div class="checkbox">
							    <label>
							      <?php
							      	$tour_type_val = lang($value);
							      ?>
							      <input type="checkbox" class="-travel-styles" <?=set_checkbox('travel_styles', $tour_type_val, in_array($tour_type_val, $travel_styles))?> value="<?=$tour_type_val?>" name="travel_styles[]"> <?=$tour_type_val?>
							    </label>
							</div>
						</div>
					<?php endforeach;?>
				</div>

		<?php endif;?>

		<div class="row control-group">
			<label for="tour_budget" class="control-label col-xs-2 item-label"  style="width: 18%;">
				<?=lang('tour_budget')?>:
			 	<span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#tour_budget_help_cnt"></span>
			 </label>
			 <?php foreach ($tour_budgets as $key => $value):?>
			 	<div class="col-xs-2"  style="width: 20%;">
			 		<div class="checkbox">
					    <?php
			 				$chc_val = lang($value);
			 			?>
					    <label>
					      <input type="checkbox" class="-budgets" value="<?=$chc_val?>" name="budgets[]" <?=set_checkbox('budgets', $chc_val, in_array($chc_val, $budgets))?>> <?=$chc_val?>
					    </label>
					</div>
			 	</div>
			 <?php endforeach;?>
		</div>

		<div class="row">
			<div class="col-xs-2 col-xs-offset-10">
				<button class="btn btn-blue btn-x-lg btn-block" type="submit"><?=lang('search_now')?></button>
			</div>
		</div>

	<?php else:?>

		<div class="form-group" id="tour_destination_group">
			<label for="destination" class="item-label">
				<?=str_replace('...', '', lang('search_placeholder'))?>:
				<span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#tour_des_help_cnt"></span>
			</label>
			<input type="text" class="form-control input-default" name="destination" id="tour_destination" value="<?=$destination_name?>" placeholder="<?=lang('search_placeholder')?>" data-placement="right" data-target="#tour_des_help_cnt">
		</div>

		<div class="form-group">
			<label for="departure_date" class="item-label"><?=lang('departure_date')?>:</label>
			<div class="row">
				<?=$datepicker?>
			</div>
		</div>

		<?php if(!empty($show_type_tour)):?>
			<div class="form-group">
				<label for="travel_styles" class="item-label"><?=lang('travel_styles')?>: <span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#travel_style_help_cnt"></span></label>
				<div class="row">
					<?php foreach ($tour_travel_styles as $key => $value):?>
						<div class="col-xs-6">
							<div class="checkbox">
							    <label>
							      <?php
							      	$tour_type_val = lang($value);
							      ?>
							      <input type="checkbox" class="-travel-styles" <?=set_checkbox('travel_styles', $tour_type_val, in_array($tour_type_val, $travel_styles))?> value="<?=$tour_type_val?>" name="travel_styles[]"> <?=$tour_type_val?>
							    </label>
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
		<?php endif;?>


		<div class="row form-group">

				<div class="col-xs-6">
					<label for="duration" class="item-label"><?=lang('duration')?>:</label>
					<select class="form-control bpt-input-xs" name="duration" id="duration">
						<option value="">
							<?=lang('select_all')?>
						</option>

						<?php foreach ($tour_durations as $key => $value) :?>
							<?php
								$opt_val = lang($value);
							?>
							<option value="<?=$opt_val?>" <?=set_select('duration', $opt_val, $opt_val == $duration)?>>
								<?=$opt_val?>
							</option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="col-xs-6">
					<label for="group_type" class="item-label"><?=lang('group_type')?>:</label>

					<select class="form-control bpt-input-xs" name="group_type" id="group_type">
						<option value="">
							<?=lang('select_all')?>
						</option>

						<?php foreach($tour_group_types as $key => $value):?>
							<?php
								$group_type_val = lang($value);
							?>

							<option value="<?=$group_type_val?>" <?=set_select('group_type', $group_type_val, $group_type == $group_type_val)?>><?=$group_type_val?></option>

						<?php endforeach;?>
					</select>
				</div>

		</div>

		<div class="form-group margin-bottom-10">
			<label class="item-label">
				<?=lang('tour_budget')?>:
			 	<span class="glyphicon glyphicon-question-sign" data-placement="right" data-target="#tour_budget_help_cnt"></span>
			 </label>
			 <div class="row padding-left-10">
				 <?php foreach ($tour_budgets as $key => $value):?>
				 	<div style="width: 33%; float:left;">
				 		<div class="checkbox">
				 			<?php
				 				$chc_val = lang($value);
				 			?>
						    <label>
						      <input type="checkbox" class="-budgets" value="<?=$chc_val?>" name="budgets[]" <?=set_checkbox('budgets', $chc_val, in_array($chc_val, $budgets))?>> <?=$chc_val?>
						    </label>
						</div>
				 	</div>
				 <?php endforeach;?>
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

<input type="hidden" class="form-control" name="destination_id" id="tour_destination_id" value="<?=$destination_id?>">

<div class="hidden" id="tour_search_help_cnt"><?=lang('search_help')?></div>
<div class="hidden" id="tour_des_help_cnt"><?=lang('destination_help')?></div>
<div class="hidden" id="travel_style_help_cnt"><?=lang('travel_style_help')?></div>
<div class="hidden" id="tour_budget_help_cnt"><?=lang('tour_budget_help')?></div>

</form>

<script type="text/javascript">
    var cal_load = new Loader();
    cal_load.require(
            <?=get_libary_asyn('typeahead')?>,
          function() {
                set_search_des_auto('<?=MODULE_TOUR?>');
          });

    set_help('.glyphicon-info-sign');
    set_help('.glyphicon-question-sign');

    <?php if(empty($search_criteria)):?>
        get_current_tour_search();
    <?php endif;?>
</script>