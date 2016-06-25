	<?php if($flight_booking['is_unavailable']):?>
		<div class="container">
			<?=$flight_search_form?>

			<?=load_flight_booking_exception($search_criteria, 1, $is_mobile)?>
			
		</div>
	
	<?php else:?>
	
	<div class="container">
		
		<?=$step_booking?>
		
		<div class="margin-top-10">
			<h2 class="bpv-color-title"><?=lang('flight_itineray')?></h2>
			<?=$flight_itinerary?>
		</div>
		
		<form id="frm_passenger" name="frm_passenger" method="post">
			<input type="hidden" value="<?=ACTION_NEXT?>" name="action">
			<input type="hidden" value="<?=!empty($flight_booking['promotion_code']) ? $flight_booking['promotion_code'] : ''?>" name="promotion_code" id="promotion_code_used">
			
			<div class="margin-bottom-20" id="passenger_area">
				<h2 class="bpv-color-title sep-line"><?=lang('flight_passenger')?></h2>
				<?=$flight_passenger?>
			</div>
			
			<?php if($search_criteria['is_domistic']):?>
				<div class="margin-bottom-20">
					<h2 class="bpv-color-title sep-line"><?=lang('flight_baggage_fees')?></h2>
					<div class="data-area">					
						<?=$flight_baggage_fees?>
					</div>
				</div>
			<?php endif;?>
						
		
		</form>
		
		<div style="display:none">
			<?=$flight_summary?>
		</div>
		
		<div class="row margin-top-20">
			<div class="col-xs-8 col-xs-offset-2">
				<button type="button" class="btn btn-bpv btn-lg btn-block" onclick="proceed_checkout()">
					<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('flight_next')?>
				</button>
			</div>
		</div>
	</div>
<?php endif;?>

<script type="text/javascript">

	function proceed_checkout(){

		if(validate_passengers() && validate_chd_inf_birthday(<?=$search_criteria['CHD']?>, <?=$search_criteria['INF']?>, '<?=$search_criteria['Depart']?>')){

			$('#frm_passenger').submit();
		} else {
			go_position($('#passenger_area').offset().top);
		}
		
	}
</script>