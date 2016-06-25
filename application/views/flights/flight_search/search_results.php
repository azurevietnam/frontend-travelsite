<div class="container">
	<div class="bpv-col-left">
		<?=$flight_search_overview?>
		<?=$flight_search_form?>
		<?=$flight_search_filters?>
	</div>
	
	<div class="bpv-col-right">
	
		<ol class="breadcrumb">
		  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
		  <li><a href="<?=get_url(FLIGHT_HOME_PAGE)?>"><?=lang('mnu_flights')?></a></li>
		  <li class="active"><?=lang_arg('flight_search_bredcum', $search_criteria['From'], $search_criteria['To'])?></li>
		</ol>
		
		<form id="flight_selected_form" name="flight_selected_form" method="post" action="<?=get_url(FLIGHT_DETAIL_PAGE.'?sid='.$sid)?>">
			<input type="hidden" name="flight_departure" id="flight_departure" value="">
			<input type="hidden" name="flight_return" id="flight_return" value="">
			<input type="hidden" name="flight_inter_id" id="flight_inter_id" value="">
			<input type="hidden" name="flight_departure_id" id="flight_departure_id" value="">
		</form>
		
		
		<div id="your_selected_departure" class="bpv-list-item flight-depart-selected">
			<h3 class="header bpv-color-title">
				<span class="glyphicon glyphicon-ok"></span>
				<?=lang_arg('your_selected_departure', $search_criteria['From'], $search_criteria['To'])?>
			</h3>
			
			<div class="content">
				<div id="flight_selected_content">			
					
				</div>
			</div>
		</div>
			
		
		<div id="flight_data_content">
				
		</div>
			
		
		<div id="flight_loading_depart">
		
			<div class="flight-waiting-summary clearfix">
				<div class="col-1">
					<img alt="" src="<?=site_url('media/flight/flight.png')?>">
				</div>
				<div class="col-2">
					<div class="margin-bottom-10">
						<span class="bpv-color-title" style="font-size:18px"><?=$search_criteria['From']?></span>
						<span class="go"><?=lang('flight_go')?></span>
						<span class="bpv-color-title" style="font-size:18px"><?=$search_criteria['To']?></span>
						<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
							<span class="go"><?=lang('return_ticket')?></span>
						<?php else:?>
							<span class="go"><?=lang('oneway_ticket')?></span>
						<?php endif;?>
					</div>
					
					<div class="margin-bottom-10">
						<span><b><?=lang('search_fields_departure')?>:</b> <span class='selected-departure-date'><?=format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true)?></span></span>
						
						<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
						&nbsp;-&nbsp; 
						<span><b><?=lang('search_fields_return')?>:</b> <span class='selected-return-date'><?=format_bpv_date($search_criteria['Return'], DATE_FORMAT, true)?></span></span>
						<?php endif;?>
					</div>
					
					<div>
						<b><?=lang('passenger')?>:</b>
						<?=get_passenger_text($search_criteria['ADT'], $search_criteria['CHD'], $search_criteria['INF'])?>
					</div>
				</div>
			</div>
			
			<?=load_search_waiting(lang('flight_searching'),'waiting', lang('flight_search_please_wait'))?>
		
		</div>
		
		<div id="flight_loading_return" style="display:none">
			
			<?=load_search_waiting(lang('flight_return_searching'))?>
		
		</div>
		
		<div id="flight_loading_change_day" style="display:none">
			<?=load_search_waiting(lang('flight_searching'),'waiting', lang('flight_search_please_wait'))?>
		</div>
	
	</div>
</div>

<script type="text/javascript">
	function change_departure(){
		$('#your_selected_departure').hide();
		$('#flight_selected_content').html('');
		
		get_flight_data('<?=FLIGHT_TYPE_DEPART?>', '<?=$sid?>');
	}

	function select_flight(flight_id, flight_type){

		var trip_type = '<?=$search_criteria['Type']?>';

		// for roundtrip flight
		if(trip_type == '<?=FLIGHT_TYPE_ROUNDWAY?>'){

			// select after search for departure flights
			if(flight_type == '<?=FLIGHT_TYPE_DEPART?>'){

				$('#flight_departure').val(get_selected_flight_info(flight_id));
				$('#flight_departure_id').val(flight_id);

				// close the flight detail area
				var txt = $('#show_'+flight_id).text();
				txt = txt.replace('[ - ]','[ + ]');
				$('#show_'+flight_id).text(txt);
				$('#flight_detail_' + flight_id).attr('show','hide');
				$('#flight_detail_' + flight_id).hide();

				
				$('#flight_selected_content').html($('#flight_row_' + flight_id).html());

				$('#select_' + flight_id).parent().addClass('text-right');
				$('#select_' + flight_id).parent().html('<a id="change_departure_flights" href="javascript:change_departure()"><span class="glyphicon glyphicon-edit"></span> <?=lang('change_flight')?></a>');
				
				$('#your_selected_departure').show();
		
				$("html, body").animate({ scrollTop: 0}, "slow");

				get_flight_data('<?=FLIGHT_TYPE_RETURN?>','<?=$sid?>');
				

			} else { // select after search for return flights

				$('#select_'+flight_id).button('loading');
				
				$('#flight_return').val(get_selected_flight_info(flight_id));
				
				$('#flight_selected_form').submit();

				
			}

		} else { // for oneway flight

			$('#select_'+flight_id).button('loading');
			
			$('#flight_departure').val(get_selected_flight_info(flight_id));
			
			$('#flight_selected_form').submit();	
		}
	}

	function select_flight_inter(flight_id){

		$('#select_'+flight_id).button('loading');
		
		$('#flight_inter_id').val(flight_id);
		
		$('#flight_selected_form').submit();
		
	}
	
	$(document).ready(function(){
		get_flight_data('<?=$flight_type?>', '<?=$sid?>');
	});
</script>