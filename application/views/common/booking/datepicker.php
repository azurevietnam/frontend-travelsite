<?php
	$available_dates = isset($options['available_dates']) ? $options['available_dates'] : array();
	$available_dates = json_encode($available_dates);

	$selected_date = !empty($options['departure_date']) ? $options['departure_date'] : '';
?>

<script type="text/javascript">
	var available_dates = <?=$available_dates?>;
</script>

<div class="<?=$options['css']?>">
	<select class="form-control bpt-input-xs" id="<?=$options['day_id']?>" onchange="change_datepicker_day('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>')">

	</select>
</div>
<div class="padding-left-0 <?=$options['css']?>" id="<?=$options['month_id']?>">
	<select class="form-control bpt-input-xs" id="<?=$options['month_id']?>" onchange="change_datepicker_month('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates)">
		<?php for ($i = 0; $i < CHECK_RATE_MONTH_LIMIT; $i++):?>
			<?php
				$time = strtotime(' +'.$i.' month');
			?>
			<?php if(is_availabe_month($options, $time)):?>
				<option value="<?=date('m-Y', $time)?>"><?=strftime('%b, %Y', strtotime(' +'.$i.' month'))?></option>
			<?php endif;?>
		<?php endfor;?>
	</select>
</div>

<!--
<div class="<?=$options['css']?>">
	<span class="glyphicon glyphicon-calendar"></span>
</div>
 -->

 <?php
 	$night_nr_id = !empty($options['night_nr_id']) ? '#'.$options['night_nr_id'] : '';
 	$night_nr = !empty($options['night_nr']) ? $options['night_nr'] : '';
 ?>

<input type="hidden" id="<?=$options['date_id']?>" name="<?=$options['date_name']?>" onchange="change_datepicker_date('#<?=$options['date_id']?>', '<?=$night_nr?>','<?=$night_nr_id?>')"/>

<input type="hidden" id="upstream_dates" value="<?=!empty($options['upstream_dates']) ? implode(',', $options['upstream_dates']) : ''?>">
<input type="hidden" id="downstream_dates" value="<?=!empty($options['downstream_dates']) ? implode(',', $options['downstream_dates']) : ''?>">

<script type="text/javascript">

	init_datepicker('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, '<?=$selected_date?>');

	<?php if($options['loading_asyn']):?>

	var cal_load = new Loader();
	cal_load.require(
		<?=get_libary_asyn('jquery-ui-datepicker')?>,
      function() {
			setup_datepicker('#<?=$options['date_id']?>', available_dates, function(dateText, inst){

				set_current_selected_date('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, dateText);

			}, '<?=lang_code()?>');
      });

	<?php else:?>

		setup_datepicker('#<?=$options['date_id']?>', available_dates, function(dateText, inst){

			set_current_selected_date('#<?=$options['day_id']?>', '#<?=$options['month_id']?>', '#<?=$options['date_id']?>', available_dates, dateText);

		}, '<?=lang_code()?>');

	<?php endif;?>
</script>