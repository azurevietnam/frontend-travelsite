<?php
	$available_dates = isset($options['available_dates']) ? $options['available_dates'] : array();
	$available_dates = json_encode($available_dates);

	$selected_date = !empty($options['departure_date']) ? $options['departure_date'] : '';
?>

<?php
 	$night_nr_id = !empty($options['night_nr_id']) ? '#'.$options['night_nr_id'] : '';
 	$night_nr = !empty($options['night_nr']) ? $options['night_nr'] : '';
?>

<span class="icon-after">
    <input type="text" id="<?=$options['date_id']?>" name="<?=$options['date_name']?>" 
    onchange="change_datepicker_date('#<?=$options['date_id']?>', '<?=$night_nr?>','<?=$night_nr_id?>')"
    autocomplete="off" readonly="readonly" class="form-control bpv-date-input"/>
    <span class="glyphicon glyphicon-calendar btn_calendar" data-id="<?=$options['date_id']?>"></span>
</span>

<input type="hidden" id="upstream_dates" value="<?=!empty($options['upstream_dates']) ? implode(',', $options['upstream_dates']) : ''?>">
<input type="hidden" id="downstream_dates" value="<?=!empty($options['downstream_dates']) ? implode(',', $options['downstream_dates']) : ''?>">

<script type="text/javascript">

    var available_dates = <?=$available_dates?>;

	init_datepicker('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, '<?=$selected_date?>');

	<?php if($options['loading_asyn']):?>
	
	var cal_load = new Loader();
	cal_load.require(
		<?=get_libary_asyn('jquery-ui-datepicker', true, '', true)?>,
      function() {
			setup_datepicker('#<?=$options['date_id']?>', available_dates, null, null, true, function(dateText, inst){

				set_current_selected_date('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, dateText);

			}, '<?=lang_code()?>');
      });

	<?php else:?>

		setup_datepicker('#<?=$options['date_id']?>', available_dates, function(dateText, inst){

			set_current_selected_date('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, dateText);

		}, '<?=lang_code()?>');

	<?php endif;?>

	$('.btn_calendar').click(function() {
		var id = $(this).attr('data-id');
		if(id) $('#'+id).focus();
	});
</script>