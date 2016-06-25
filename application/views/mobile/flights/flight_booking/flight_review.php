<h2 class="bpv-color-title"><?=lang('review_booking')?></h2>

<div class="data-area">

	<div class="margin-bottom-10"><?=lang('flight_review_message')?>:</div>
	
	<div class="review-booking-line"><span class="review-booking_step">1.</span> <?=lang('flight_review_1')?></div>
	
	<div class="review-booking-line"><span class="review-booking_step">2.</span> <?=lang('flight_review_2')?></div>
	
	<?php for ($i = 1; $i <= $flight_booking['nr_adults']; $i++):?>
		<?php 
			$adult = $flight_booking['adults'][$i-1];
		?>
		<div class="review-booking-traveler">
			<?=lang('passenger')?> <?=$i?>: <b><?=$adult['first_name'].' '.$adult['last_name']?></b>
			(<?=$adult['gender'] == 1 ? lang('gender_male') : lang('gender_female')?>)
			&nbsp;&nbsp;
			<a href="javascript:void(0)" data-toggle='modal' data-target='#flight_passengers'><i><?=lang('make_changes')?></i></a>
		</div>
	<?php endfor;?>
	
	<?php for ($i = 1; $i <= $flight_booking['nr_children']; $i++):?>
		<?php 
			$child = $flight_booking['children'][$i-1];
		?>
		<div class="review-booking-traveler">
			<?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'])?>: <b><?=$child['first_name'].' '.$child['last_name']?></b>
			(<?=$child['gender'] == 1 ? lang('gender_male') : lang('gender_female')?>, <?=$child['birth_day']?>)
			&nbsp;&nbsp;
			<a href="javascript:void(0)" data-toggle='modal' data-target='#flight_passengers'><i><?=lang('make_changes')?></i></a>
		</div>
	<?php endfor;?>
	
	<?php for ($i = 1; $i <= $flight_booking['nr_infants']; $i++):?>
		<?php 
			$infant = $flight_booking['infants'][$i-1];
		?>
		<div class="review-booking-traveler">
			<?=lang('passenger')?> <?=($i + $flight_booking['nr_adults'] + $flight_booking['nr_children'])?>: <b><?=$infant['first_name'].' '.$infant['last_name']?></b>
			(<?=$infant['gender'] == 1 ? lang('gender_male') : lang('gender_female')?>, <?=$infant['birth_day']?>)
			&nbsp;&nbsp;
			<a href="javascript:void(0)" data-toggle='modal' data-target='#flight_passengers'><i><?=lang('make_changes')?></i></a>
		</div>
	<?php endfor;?>
	
	<div class="review-booking-line"><span class="review-booking_step">3.</span> <?=lang('flight_review_3')?></div>

</div>