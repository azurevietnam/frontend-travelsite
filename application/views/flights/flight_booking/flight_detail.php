	<?php if($flight_booking['is_unavailable']):?>
		<div class="container">
			<div class="bpv-col-left">
				<?=$flight_search_form?>
			</div>
			<div class="bpv-col-right">
			
				<ol class="breadcrumb">
				  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
				  <li><a href="<?=get_url(FLIGHT_HOME_PAGE)?>"><?=lang('mnu_flights')?></a></li>
				  <li><a href="<?=get_current_flight_search_url($search_criteria)?>"><?=lang_arg('flight_search_bredcum', $search_criteria['From'], $search_criteria['To'])?></a></li>
				  <li class="active"><?=lang('passenger_detail')?></li>
				</ol>
				
				<?=load_flight_booking_exception($search_criteria, 1)?>
			</div>
		</div>
	
	<?php else:?>
	<div class="container booking-page">
	
		<ol class="breadcrumb">
		  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
		  <li><a href="<?=get_url(FLIGHT_HOME_PAGE)?>"><?=lang('mnu_flights')?></a></li>
		  <li><a href="<?=get_current_flight_search_url($search_criteria)?>"><?=lang_arg('flight_search_bredcum', $search_criteria['From'], $search_criteria['To'])?></a></li>
		  <li class="active"><?=lang('passenger_detail')?></li>
		</ol>

		<div class="bpv-col-right clearfix">
			
			<?=$step_booking?>
			<div class="margin-top-20 clearfix">
				<h2 class="bpv-color-title pull-left"><?=lang('flight_itineray')?></h2>
				<a href="<?=get_current_flight_search_url($search_criteria)?>" role="button" class="btn btn-default btn-change-booking pull-right">
					<?=lang('change_flight')?>
				</a>
			</div>
			
			<div class="margin-bottom-20">
				<?=$flight_itinerary?>
			</div>
			
			<form id="frm_passenger" name="frm_passenger" method="post">
				<input type="hidden" value="<?=ACTION_NEXT?>" name="action">
				<input type="hidden" value="<?=!empty($flight_booking['promotion_code']) ? $flight_booking['promotion_code'] : ''?>" name="promotion_code" id="promotion_code_used">
				
				<div class="margin-bottom-20" id="passenger_area">
					<h2 class="bpv-color-title"><?=lang('flight_passenger')?></h2>
					<div class="data-area">				
						<?=$flight_passenger?>
					</div>
				</div>
				
				<?php if($search_criteria['is_domistic']):?>
					<div class="margin-bottom-20">
						<h2 class="bpv-color-title"><?=lang('flight_baggage_fees')?></h2>
						<div class="data-area">					
							<?=$flight_baggage_fees?>
						</div>
					</div>
				<?php endif;?>
				
				
				<div class="margin-bottom-20">
					<h2 class="bpv-color-title"><?=lang('discount_code')?></h2>
					<div class="data-area" style="background-color:#FFFFCC">				
						<?=$flight_pro_code?>
					</div>
				</div>
				
			
			</form>
			
			<button type="button" class="btn btn-bpv btn-lg center-block" onclick="proceed_checkout()">
				<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('flight_next')?>
			</button>

				
		</div>
	
		<div class="bpv-col-left">
			<?=$flight_summary?>
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