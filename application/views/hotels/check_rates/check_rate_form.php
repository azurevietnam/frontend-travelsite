<form id="frm_hotel_check_rate_<?=$hotel['id']?>" name="frm_hotel_check_rate" method="get" action="<?=$form_action?>">

	<div class="check-rate-form">
		<h3 class="text-highlight"><?=lang('select_your_departure')?></h3>

		<div class="row">
			<div class="col-xs-10">

			<div class="row">
				<div class="col-xs-2" style="width: 12%">
					<label><?=lang('lbl_check_in')?>:</label>
				</div>
				<div class="col-xs-5">
					<div class="row">
						<?=$datepicker?>
					</div>
				</div>

				<div class="col-xs-1">
					<label><?=lang('lbl_nights')?>:</label>
				</div>

				<div class="col-xs-2" style="width: 10%">

					<select class="form-control bpt-input-xs" name="night_nr_<?=$hotel['id']?>" id="night_nr_<?=$hotel['id']?>" onchange="change_datepicker_date('#<?=$datepicker_options['date_id']?>', '', '#<?=$datepicker_options['night_nr_id']?>')">

						<?php for ($i = 1; $i <= HOTEL_NIGHT_LIMIT; $i++):?>
							<option value="<?=$i?>" <?=set_select('night_nr_'.$hotel['id'], $i, !empty($check_rates['night_nr']) && $check_rates['night_nr'] == $i)?>><?=$i?></option>
						<?php endfor;?>

					</select>

				</div>

				<div class="col-xs-1" style="width: 10%; padding-right: 0;">
					<label><?=lang('lbl_check_out')?>:</label>
				</div>

				<div class="col-xs-2 padding-right-0">
					<label id="hotel_date_<?=$hotel['id']?>_end">

					</label>
				</div>

			</div>

			</div>
			
			<button type="submit" class="btn btn-blue btn-check-rate" value="<?=ACTION_CHECK_RATE?>" name="action" onclick="return hotel_check_rate(<?=$hotel['id']?>)">
				<?=lang('check_rates')?>
			</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	<?php
		$date_id = $datepicker_options['date_id'];
	?>
	$('#<?=$date_id?>').change();

	<?php if(!empty($check_rates)):?>
		go_position('#frm_hotel_check_rate_<?=$hotel['id']?>');
	<?php endif;?>

	/**
	 * Click on the Hotel Check Rate Button
	 * @author Khuyenpv
	 * @since 06.04.2015
	 */
	function hotel_check_rate(hotel_id){

		var submit_return = false;

		var is_ajax = '<?=$is_ajax?>' == '1';

		alert_travel_start_date('#<?=$date_id?>');

		// ajax submit
		if(is_ajax){

			var form_id = '#frm_hotel_check_rate_<?=$hotel['id']?>';

			var url = $(form_id).attr('action');

			var area_id = '#<?='hotel_'.$hotel['id']?>';

			var dataString = $(form_id).serialize();

			$('div'+area_id).html('');
			show_loading_data(true, area_id);

			$.ajax({
				url: url,
				type: "GET",
				data: dataString,
				success:function(value){
					$('div'+area_id).html(value);
					show_loading_data(false);
				}
			});


			submit_return = false;

		} else { // normal submit

			submit_return = true;
		}

		return submit_return;
	}
</script>