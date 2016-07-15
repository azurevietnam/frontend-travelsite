<div class="container margin-bottom-20">
	<?=$booking_steps?>
	
	<div class="margin-top-5 clearfix" >			
		<h2 class="text-header-content"> <span class="icon icon-flight-black"></span> <?=lang('flight_itineray')?></h2>

	</div>
		
	<div class="margin-bottom-10">
		<?=$flight_itinerary?>
	</div>

	<div class="margin-bottom-10 margin-top-10" style="border: 1px solid #ff9406; padding: 5px 10px;">
		<div style="font-size: 16px;font-weight: bold;">
			<span style="font-size:14px"><?=lang('total')?>:&nbsp;</span>
			<span class="text-price" id="flight_total_price" ticket-price="<?=$flight_booking['prices']['total_payment']?>"><?=CURRENCY_SYMBOL?><?=$flight_booking['prices']['total_payment']?></span>
		</div>
		<?=lang('price_note')?>
	</div>
	
	<div class="margin-bottom-20 text-right">
		<a href="<?=get_current_flight_search_url($search_criteria)?>" role="button" style="margin-top: -7px; text-decoration: underline;">
			<span class="glyphicon glyphicon-edit"></span> <?=lang('change_flight')?>
		</a>
	</div>
	
	<form id="frm_passenger" name="frm_passenger" method="post">
	
		<input type="hidden" value="<?=ACTION_NEXT?>" name="action">
		
		<div class="margin-bottom-20">				
			<h2 class="text-header-content" id="passenger_area"> <span class="icon icon-passenger-black"> </span> <?=lang('flight_passenger')?></h2>
			<div class="data-area">				
				<?=$flight_passenger?>
			</div>
		</div>
		
		<?php if($search_criteria['is_domistic']):?>
			<div class="margin-bottom-20">					
				<h2 class="text-header-content"> <span class="icon icon-passenger-black"></span> <?=lang('flight_baggage_fees')?></h2>
				<div class="data-area">					
					<?=$flight_baggage_fees?>
				</div>
			</div>
		<?php endif;?>			

			
	</form>
	<div class="text-center">
		<button type="button" class="btn btn-yellow btn-lg" onclick="proceed_checkout()">
			<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('proceed_checkout')?>
		</button>
	</div>
</div>
<script type="text/javascript">
	function proceed_checkout(){
		if(validate_passengers() && validate_chd_inf_birthday(<?=$search_criteria['CHD']?>, <?=$search_criteria['INF']?>, '<?=$search_criteria['Depart']?>')){
			$('#frm_passenger').submit();
		} else {
			go_position('#passenger_area');
		}	
	}
</script>