
<?php 
	$flying_date = format_bpv_date($search_criteria['Depart'], DATE_FORMAT);
	
	$f_d = format_bpv_date($search_criteria['Depart'], 'd-m-Y');
	$infant_birthday_limited = date(DATE_FORMAT, strtotime($f_d . ' -2 years'));
	$children_birthday_limited = date(DATE_FORMAT, strtotime($f_d . ' -12 years'));
?>

<p id="passenger_note"><?=lang('passenger_note')?>:</p>

<?php if(!$search_criteria['is_domistic']):?>
	<p><?=lang('passport_note')?></p>
<?php endif;?>
	
<?php for ($i = 1; $i <= $flight_booking['nr_adults']; $i++):?>

	<?php 
		$adult = isset($flight_booking['adults'][$i-1]) ? $flight_booking['adults'][$i-1] : '';
	?>
	
	<div class="row margin-bottom-10">
		<div class="col-xs-9">
			<b><?=lang('passenger')?> <?=$i?>,</b> <?=lang('search_fields_adults')?>:
		</div>
		
		<div class="col-xs-3">
			<?=lang('gender')?>
		</div>
	</div>
	<div class="row margin-bottom-10">
		<div class="col-xs-9">
			<input name="adults_full_<?=$i?>" type="text" placeholder="<?=lang('name_place_holder')?>" value="<?=set_value('adults_full_'.$i, !empty($adult)? $adult['full_name'] : '')?>" 
			index="<?=$i?>" class="form-control required pas-name"
			onkeyup="update_flight_baggage_pas_name()">
		</div>
		<div class="col-xs-3">
			<select name="adults_gender_<?=$i?>" class="form-control required pull-left">
				<option value="">----</option>
				<option value="1" <?=set_select('adults_gender_'.$i, 1, !empty($adult) && $adult['gender'] == 1)?>><?=lang('gender_male')?></option>
				<option value="2" <?=set_select('adults_gender_'.$i, 2, !empty($adult) && $adult['gender'] == 2)?>><?=lang('gender_female')?></option>
			</select>
		</div>
	</div>
	
	<!-- Internaltional Flight: show birthday, passport -->
	<?php if(!$search_criteria['is_domistic']):?>
		<div class="margin-bottom-10">
			<b><?=lang('date_of_birth')?>: <?=mark_required()?></b>
		</div>
		<?php 
			$day = !empty($adult['birth_day'])? date('d',strtotime(format_bpv_date($adult['birth_day'], DB_DATE_FORMAT))) : '';
			
			$month = !empty($adult['birth_day'])? date('m',strtotime(format_bpv_date($adult['birth_day'], DB_DATE_FORMAT))) : '';
			
			$year = !empty($adult['birth_day'])? date('Y',strtotime(format_bpv_date($adult['birth_day'], DB_DATE_FORMAT))) : '';
		?>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-4">
				<select name="adult_day_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('day')?></option>
					<?php for ($j = 1; $j <= 31; $j++):?>
						<option value="<?=$j?>" <?=set_select('adult_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="adult_month_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('month')?></option>
					<?php for ($j = 1; $j <= 12; $j++):?>
						<option value="<?=$j?>" <?=set_select('adult_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="adult_year_<?=$i?>" class="form-control required input-sm">
					<?php 
						$current_year = (int)date('Y');
					?>
					<option value=""><?=lang('year')?></option>
											
					<?php for ($j = $current_year - 12; $j > 1920; $j--):?>
						<option value="<?=$j?>" <?=set_select('adult_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
		</div>
		
		<div class="margin-bottom-10">
			<b><?=lang('passenger_nationality')?>: </b>
		</div>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-9">
				<select class="form-control" name="country_orgin_adt_<?=$i?>">
					<?php foreach ($passenger_nationalities as $key=>$value):?>
						<?php 
							$nationality_value = $value[0].' ('.strtoupper($key).')';
						?>
						<option value="<?=$nationality_value?>" <?=set_select('country_orgin_adt_'.$i, $nationality_value, !empty($adult['nationality']) && $adult['nationality'] == $nationality_value)?>>
							<?=$nationality_value?>
						</option>
						<?php if($key=='vn'):?>
							<option disabled="disabled">------------------------------</option>
						<?php endif;?>
					<?php endforeach;?>
					<option disabled="disabled">------------------------------</option>
					<option value="" <?=set_select('country_orgin_adt_'.$i, '', isset($adult['nationality']) && $adult['nationality'] == '')?>><?=lang('other_country')?></option>
				</select>
			</div>
		</div>
		
		<div class="margin-bottom-10">
			<b><?=lang('passenger_passport')?>: </b>
		</div>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-9">
				<input type="text" class="form-control" name="passport_adt_<?=$i?>" value="<?=set_value('passport_adt_'.$i, !empty($adult['passport'])? $adult['passport'] : '')?>">
			</div>
		</div>
		
		<div class="margin-bottom-10">
			<b><?=lang('passenger_passport_expired')?>: </b>
		</div>
		
		<?php 
			$day = !empty($adult['passportexp'])? date('d',strtotime(format_bpv_date($adult['passportexp'], DB_DATE_FORMAT))) : '';
			
			$month = !empty($adult['passportexp'])? date('m',strtotime(format_bpv_date($adult['passportexp'], DB_DATE_FORMAT))) : '';
			
			$year = !empty($adult['passportexp'])? date('Y',strtotime(format_bpv_date($adult['passportexp'], DB_DATE_FORMAT))) : '';
		?>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-4">
				<select name="passportexp_adt_day_<?=$i?>" class="form-control input-sm">
					<option value=""><?=lang('day')?></option>
					<?php for ($j = 1; $j <= 31; $j++):?>
						<option value="<?=$j?>" <?=set_select('passportexp_adt_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="passportexp_adt_month_<?=$i?>" class="form-control input-sm">
					<option value=""><?=lang('month')?></option>
					<?php for ($j = 1; $j <= 12; $j++):?>
						<option value="<?=$j?>" <?=set_select('passportexp_adt_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="passportexp_adt_year_<?=$i?>" class="form-control input-sm">
					<?php 
						$current_year = (int)date('Y');
					?>
					<option value=""><?=lang('year')?></option>
											
					<?php for ($j = $current_year; $j < $current_year + 10; $j++):?>
						<option value="<?=$j?>" <?=set_select('passportexp_adt_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
		</div>
	<?php endif;?>
	<hr>	
<?php endfor;?>
	
	<?php if($search_criteria['CHD'] + $search_criteria['INF'] > 0 && $search_criteria['is_domistic']):?>
		<p><?=lang('children_infant_age_required')?></p>
	<?php endif;?>
	
	<?php for ($i = 1; $i <= $flight_booking['nr_children']; $i++):?>
	
		<?php 
			$child = isset($flight_booking['children'][$i-1]) ? $flight_booking['children'][$i-1] : '';
		?>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-9">
				<b><?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'])?>,</b> <?=lang('search_fields_children')?>:
			</div>
			
			<div class="col-xs-3">
				<?=lang('gender')?>
			</div>
		</div>
	
		
		<div class="row margin-bottom-10">
			<div class="col-xs-9">
				<input name="children_full_<?=$i?>" type="text" placeholder="<?=lang('name_place_holder')?>" value="<?=set_value('children_full_'.$i, !empty($child)? $child['full_name'] : '')?>" 
				index="<?=($i + $flight_booking['nr_adults'])?>" class="form-control required pas-name"
				onkeyup="update_flight_baggage_pas_name()">
			</div>
			<div class="col-xs-3">
				<select name="children_gender_<?=$i?>" class="form-control required pull-left">
					<option value="">----</option>
					<option value="1" <?=set_select('children_gender_'.$i, 1, !empty($child) && $child['gender'] == 1)?>><?=lang('gender_male')?></option>
					<option value="2" <?=set_select('children_gender_'.$i, 2, !empty($child) && $child['gender'] == 2)?>><?=lang('gender_female')?></option>
				</select>
			</div>
		</div>
		
		<div class="margin-bottom-10">
			<b><?=lang('date_of_birth')?>: <?=mark_required()?></b>
		</div>

		
		<?php 
			$day = !empty($child)? date('d',strtotime(format_bpv_date($child['birth_day'], DB_DATE_FORMAT))) : '';
			
			$month = !empty($child)? date('m',strtotime(format_bpv_date($child['birth_day'], DB_DATE_FORMAT))) : '';
			
			$year = !empty($child)? date('Y',strtotime(format_bpv_date($child['birth_day'], DB_DATE_FORMAT))) : '';
		?>
		
	
		<div class="row">
			<div class="col-xs-4">
				<select name="children_day_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('day')?></option>
					<?php for ($j = 1; $j <= 31; $j++):?>
						<option value="<?=$j?>" <?=set_select('children_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="children_month_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('month')?></option>
					<?php for ($j = 1; $j <= 12; $j++):?>
						<option value="<?=$j?>" <?=set_select('children_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">
				<select name="children_year_<?=$i?>" class="form-control required input-sm">
					<?php 
						$current_year = (int)date('Y');
					?>
					<option value=""><?=lang('year')?></option>
											
					<?php for ($j = $current_year - 1; $j > $current_year - 13; $j--):?>
						<option value="<?=$j?>" <?=set_select('children_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
		</div>
		
		<div class="bpv-color-warning clearfix margin-top-5 age-warning" id="chd_age_warning_<?=$i?>" style="display:none">
			<?=lang_arg('children_age_warning', $children_birthday_limited, $infant_birthday_limited, $flying_date)?>
		</div>
		
		<!-- Internaltional Flight: Children show passport -->
		<?php if(!$search_criteria['is_domistic']):?>
		
			<div class="margin-bottom-10 margin-top-10">
				<b><?=lang('passenger_nationality')?>: </b>
			</div>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-9">
					<select class="form-control" name="country_orgin_chd_<?=$i?>">
						<?php foreach ($passenger_nationalities as $key=>$value):?>
							<?php 
								$nationality_value = $value[0].' ('.strtoupper($key).')';
							?>
							<option value="<?=$nationality_value?>" <?=set_select('country_orgin_chd_'.$i, $nationality_value, !empty($child['nationality']) && $child['nationality'] == $nationality_value)?>>
								<?=$nationality_value?>
							</option>
							<?php if($key=='vn'):?>
								<option disabled="disabled">------------------------------</option>
							<?php endif;?>
						<?php endforeach;?>
						<option disabled="disabled">------------------------------</option>
						<option value="" <?=set_select('country_orgin_chd_'.$i, '', isset($child['nationality']) && $child['nationality'] == '')?>><?=lang('other_country')?></option>
					</select>
				</div>
			</div>
		
			<div class="margin-bottom-10">
				<b><?=lang('passenger_passport')?>: </b>
			</div>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-9">
					<input type="text" class="form-control" name="passport_chd_<?=$i?>" value="<?=set_value('passport_chd_'.$i, !empty($child['passport'])? $child['passport'] : '')?>">
				</div>
			</div>
		
			<div class="margin-bottom-10">
				<b><?=lang('passenger_passport_expired')?>: </b>
			</div>
		
			<?php 
				$day = !empty($child['passportexp'])? date('d',strtotime(format_bpv_date($child['passportexp'], DB_DATE_FORMAT))) : '';
				
				$month = !empty($child['passportexp'])? date('m',strtotime(format_bpv_date($child['passportexp'], DB_DATE_FORMAT))) : '';
				
				$year = !empty($child['passportexp'])? date('Y',strtotime(format_bpv_date($child['passportexp'], DB_DATE_FORMAT))) : '';
			?>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-4">
					<select name="passportexp_chd_day_<?=$i?>" class="form-control input-sm">
						<option value=""><?=lang('day')?></option>
						<?php for ($j = 1; $j <= 31; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_chd_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
						<?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-4">
					<select name="passportexp_chd_month_<?=$i?>" class="form-control input-sm">
						<option value=""><?=lang('month')?></option>
						<?php for ($j = 1; $j <= 12; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_chd_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
						<?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-4">
					<select name="passportexp_chd_year_<?=$i?>" class="form-control input-sm">
						<?php 
							$current_year = (int)date('Y');
						?>
						<option value=""><?=lang('year')?></option>
												
						<?php for ($j = $current_year; $j < $current_year + 10; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_chd_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>	
		
		<?php endif;?>
		<hr>
		
	<?php endfor;?>
	
	<?php for ($i = 1; $i <= $flight_booking['nr_infants']; $i++):?>
		
		<?php 
			$infant = isset($flight_booking['infants'][$i-1]) ? $flight_booking['infants'][$i-1] : '';
		?>
		
		<div class="row margin-bottom-10">
			<div class="col-xs-9">
				<b><?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'] + $flight_booking['nr_children'])?>,</b> <?=lang('search_fields_infants')?>:
			</div>
			
			<div class="col-xs-3">
				<?=lang('gender')?>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-xs-9">
				<input name="infants_full_<?=$i?>" type="text" placeholder="<?=lang('name_place_holder')?>" value="<?=set_value('infants_full_'.$i, !empty($child)? $infant['full_name'] : '')?>" 
				index="<?=($i + $flight_booking['nr_adults'] + $flight_booking['nr_children'])?>" class="form-control required pas-name"
				onkeyup="update_flight_baggage_pas_name()">
			</div>
			
			<div class="col-xs-3">
				<select name="infants_gender_<?=$i?>" class="form-control required">
					<option value="">----</option>
					<option value="1" <?=set_select('infants_gender_'.$i, 1, !empty($infant) && $infant['gender'] == 1)?>><?=lang('gender_male')?></option>
					<option value="2" <?=set_select('infants_gender_'.$i, 2, !empty($infant) && $infant['gender'] == 2)?>><?=lang('gender_female')?></option>
				</select>
			</div>
		</div>
		
		<div class="margin-bottom-10 margin-top-10">
			<b><?=lang('date_of_birth')?>: <?=mark_required()?></b>
		</div>
		
	
		<?php 
			$day = !empty($infant)? date('d',strtotime(format_bpv_date($infant['birth_day'], DB_DATE_FORMAT))) : '';
			
			$month = !empty($infant)? date('m',strtotime(format_bpv_date($infant['birth_day'], DB_DATE_FORMAT))) : '';
			
			$year = !empty($infant)? date('Y',strtotime(format_bpv_date($infant['birth_day'], DB_DATE_FORMAT))) : '';
		?>
		
		<div class="row">
			<div class="col-xs-4">
				<select name="infants_day_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('day')?></option>
					<?php for ($j = 1; $j <= 31; $j++):?>
						<option value="<?=$j?>" <?=set_select('infants_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">	
				<select name="infants_month_<?=$i?>" class="form-control required input-sm">
					<option value=""><?=lang('month')?></option>
					<?php for ($j = 1; $j <= 12; $j++):?>
						<option value="<?=$j?>" <?=set_select('infants_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
					<?php endfor;?>
				</select>
			</div>
			
			<div class="col-xs-4">	
				<select name="infants_year_<?=$i?>" class="form-control required input-sm">
					<?php 
						$current_year = (int)date('Y');
					?>
					<option value=""><?=lang('year')?></option>
											
					<?php for ($j = $current_year; $j > $current_year - 3; $j--):?>
						<option value="<?=$j?>" <?=set_select('infants_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
					<?php endfor;?>
				</select>
			</div>
		</div>
			
		<div class="bpv-color-warning clearfix margin-top-5 age-warning" id="inf_age_warning_<?=$i?>" style="display:none">
			<?=lang_arg('infants_age_warning', $infant_birthday_limited, $flying_date, $flying_date)?>
		</div>
		
		<!-- Internaltional Flight: Children show passport -->
		<?php if(!$search_criteria['is_domistic']):?>
		
			<div class="margin-bottom-10 margin-top-10">
				<b><?=lang('passenger_nationality')?>: </b>
			</div>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-9">
					<select class="form-control" name="country_orgin_inf_<?=$i?>">
						<?php foreach ($passenger_nationalities as $key=>$value):?>
							<?php 
								$nationality_value = $value[0].' ('.strtoupper($key).')';
							?>
							<option value="<?=$nationality_value?>" <?=set_select('country_orgin_inf_'.$i, $nationality_value, !empty($infant['nationality']) && $infant['nationality'] == $nationality_value)?>>
								<?=$nationality_value?>
							</option>
							<?php if($key=='vn'):?>
								<option disabled="disabled">------------------------------</option>
							<?php endif;?>
						<?php endforeach;?>
						<option disabled="disabled">------------------------------</option>
						<option value="" <?=set_select('country_orgin_inf_'.$i, '', isset($infant['nationality']) && $infant['nationality'] == '')?>><?=lang('other_country')?></option>
					</select>
				</div>
			</div>
		
			<div class="margin-bottom-10">
				<b><?=lang('passenger_passport')?>: </b>
			</div>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-9">
					<input type="text" class="form-control" name="passport_inf_<?=$i?>" value="<?=set_value('passport_inf_'.$i, !empty($infant['passport'])? $infant['passport'] : '')?>">
				</div>
			</div>
		
			<div class="margin-bottom-10">
				<b><?=lang('passenger_passport_expired')?>: </b>
			</div>
		
			<?php 
				$day = !empty($infant['passportexp'])? date('d',strtotime(format_bpv_date($infant['passportexp'], DB_DATE_FORMAT))) : '';
				
				$month = !empty($infant['passportexp'])? date('m',strtotime(format_bpv_date($infant['passportexp'], DB_DATE_FORMAT))) : '';
				
				$year = !empty($infant['passportexp'])? date('Y',strtotime(format_bpv_date($infant['passportexp'], DB_DATE_FORMAT))) : '';
			?>
		
			<div class="row margin-bottom-10">
				<div class="col-xs-4">
					<select name="passportexp_inf_day_<?=$i?>" class="form-control input-sm">
						<option value=""><?=lang('day')?></option>
						<?php for ($j = 1; $j <= 31; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_inf_day_'.$i, $j, !empty($day) && $day == $j)?>><?=$j?></option>
						<?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-4">
					<select name="passportexp_inf_month_<?=$i?>" class="form-control input-sm">
						<option value=""><?=lang('month')?></option>
						<?php for ($j = 1; $j <= 12; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_inf_month_'.$i, $j, !empty($month) && $month == $j)?>><?=lang(date("F", mktime(0, 0, 0, $j, 10)))?></option>
						<?php endfor;?>
					</select>
				</div>
				
				<div class="col-xs-4">
					<select name="passportexp_inf_year_<?=$i?>" class="form-control input-sm">
						<?php 
							$current_year = (int)date('Y');
						?>
						<option value=""><?=lang('year')?></option>
												
						<?php for ($j = $current_year; $j < $current_year + 10; $j++):?>
							<option value="<?=$j?>" <?=set_select('passportexp_inf_year_'.$i, $j, !empty($year) && $year == $j)?>><?=$j?></option>
						<?php endfor;?>
					</select>
				</div>
			</div>	
		
		<?php endif;?>
		
		<hr>

	<?php endfor;?>
