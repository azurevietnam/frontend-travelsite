
<?php 
	$txt1 = lang('departure_date_in');
	$txt2 = lang('departure_date_from');
	
	if($service_type == HOTEL){
		$txt1 = lang('arrival_in');
		$txt2 = lang('arrival_date_from');
	}
	
	$travel_dates = str_replace("\n", "<br>", $promotion['travel_dates']);
	$travel_dates = str_replace("\r", "", $travel_dates);
?>


	<div>
		<?php if($promotion['is_specific_dates']):?>
			<label><?=$txt1?></label> <span class="text-highlight"><?=$travel_dates?></span>
		<?php else:?>
			<label><?=$txt2?></label> <span class="text-highlight"><?=date(DATE_FORMAT_DISPLAY, strtotime($promotion['stay_from']))?></span>
			<label>to</label> <span class="text-highlight"><?=date(DATE_FORMAT_DISPLAY, strtotime($promotion['stay_to']))?></span>
		<?php endif;?>
	</div>
	
	<?php if($promotion['promotion_type'] == PROMOTION_TYPE_EARLY_BIRD):?>
		<?php 
			$txt3 = $service_type == HOTEL ? lang_arg('book_over_before_arrival', $hot_deal['day_before']) : lang_arg('book_over_before_depart', $hot_deal['day_before']);
		?>
		<div class="text-highlight"><?=$txt3?></div>
	<?php endif;?>
	
	<div>
		<label class="text-price"><?=lang('lbl_expired_on', date(DATE_FORMAT_DISPLAY, strtotime($promotion['book_to'])))?></label>
	</div>
	
	<div>
		<?php if(strpos($promotion['note'], '<p>') !== false):?>
			<?=$promotion['note']?>
		<?php else:?>
			<?=str_replace("\n", "<br>", $promotion['note'])?>
		<?php endif;?>
		
	</div>
	
	<?php if(!empty($promotion['promotion_condition'])):?>
		<div>
			<label class="text-price"><?=lang('lbl_pro_conditions')?>:</label>
		</div>
		<div>
			<?=$promotion['promotion_condition']?>
		</div>
	<?php endif;?>