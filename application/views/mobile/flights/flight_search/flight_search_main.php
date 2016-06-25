<div class="container">
	<div class="bpv-col-left">
		<?=$flight_search_overview?>
		<?=$flight_search_form?>
		<?=$flight_search_filter?>
	</div>
	
	<div class="bpv-col-right">	
		<?php if($search_criteria['INF'] > $search_criteria['ADT']):?>
			<div id="no_flight_found" class="flight_loading_content">
				<div class="checking_message">
					
					Opp! The number of infants in your group is greater than the number of adults!
					
				</div>
				
				<div>
					Based on the airlines policies, we <b>can not automatically hold</b> the flight tickets for your group!
					
				</div>
			
				<div>
					<a href="/aboutus/contact/">Contact Us Now</a>, Our Travel Consultant Will <b>Manually</b> Find Best Fares For You! 	
				</div>
			</div>
		
		<?php else:?>
			
			<div id="your_selected_departure" class="bpt_item your_selected_departure" style="display:none">
				<div class="row-content">
					<div class="select_flight">
						<span class="highlight">
							<?=lang('your_selected_departure')?>:
						</span>
						
						<span class="select_flight select_date">
							<?=$search_criteria['From_Des']['name']?> to <?=$search_criteria['To_Des']['name']?>, <?=date('d M Y', strtotime($search_criteria['departure_date']))?>
							| <a href="javascript:change_departure()">Change</a>
						</span>										
					</div>
				</div>
		
				<div class="row-content" style="margin-top:10px" id="flight_selected_content">			
					
				</div>
				
				<form id="flight_selected_form" name="flight_selected_form" method="post" action="/flights/flight-details.html">
					<input type="hidden" name="flight_departure" id="flight_departure" value="">
					<input type="hidden" name="flight_return" id="flight_return" value="">
				</form>
			</div>
			
		
			<div id="flight_data_content">
				
			</div>
			
			<div id="flight_loading_content" style="display:none;">
				<div class="checking_message">
					<?=lang('flight_checking')?>
				</div>
				
				<div>
					<span><?=lang('flying_from')?></span>
					<span class="highlight des">
						<?=$search_criteria['From_Des']['name']?> (<?=$search_criteria['From_Des']['destination_code']?>),
						<?=date('d M Y', strtotime($search_criteria['departure_date']))?>
					</span>
					<span class="flight_arrow"> - </span>
					<span><?=lang('flying_to')?></span>
					<span class="highlight des">
						<?=$search_criteria['To_Des']['name']?> (<?=$search_criteria['To_Des']['destination_code']?>)
						<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
						,
						<?=date('d M Y', strtotime($search_criteria['return_date']))?>
						<?php endif;?>
					</span>
					
				</div>
				<div class="flight-search-loading"><b><?=lang('loading_flight_data')?></b></div>
			</div>
			
			<div id="flight-search-loading" style="display:none">
				<div class="flight-search-loading"><b><?=lang('loading_return_flight')?></b></div>
			</div>
		<?php endif;?>
		
	</div>

</div>

<?php if($search_criteria['ADT'] + $search_criteria['CHD'] <= FLIGHT_PASSENGER_LIMIT  && $search_criteria['INF'] <= $search_criteria['ADT']):?>

<?php 
	$selected_airline = isset($search_criteria['Airline'])? $search_criteria['Airline'] : '';
?>

<script type="text/javascript">
	function change_departure(sid, type){
		$('#your_selected_departure').hide();
		
		get_flight_data('<?=$sid?>','<?=FLIGHT_TYPE_DEPART?>','<?=$selected_airline?>');
	}

	function select_flight(flight_id, flight_type){

		var trip_type = '<?=$search_criteria['Type']?>';

		// for roundtrip flight
		if(trip_type == 'roundway'){

			// select after search for departure flights
			if(flight_type == '<?=FLIGHT_TYPE_DEPART?>'){

				$('#flight_departure').val(get_selected_flight_info(flight_id));
				
				$('#flight_selected_content').html($('#flight_content_' + flight_id).html());
		
				$('#your_selected_departure').show();
		
				$("html, body").animate({ scrollTop: 0}, "slow");

				get_flight_data('<?=$sid?>','<?=FLIGHT_TYPE_RETURN?>','<?=$selected_airline?>');
				

			} else { // select after search for return flights

				$('#select_'+flight_id).html('Processing...');
				
				$('#flight_return').val(get_selected_flight_info(flight_id));
				
				$('#flight_selected_form').submit();

				
			}

		} else { // for oneway flight

			$('#select_'+flight_id).html('Processing...');
			
			$('#flight_departure').val(get_selected_flight_info(flight_id));
			
			$('#flight_selected_form').submit();	
		}
	}
	
	//$(document).ready(function(){
		//get_flight_data('<?=$sid?>','<?=$flight_type?>','<?=$selected_airline?>');
	//});
</script>
<?php endif;?>
