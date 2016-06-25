<?php if(isset($error_code)):?>
	<?php 
		echo load_flight_booking_exception($search_criteria, $error_code);
	?>	
<?php else:?>
	<div class="margin-bottom-20">
		
		<h2 class="bpv-color-title">
			<?php if($flight_type == FLIGHT_TYPE_DEPART):?>
				<?=lang_arg('select_your_departure', $search_criteria['From'], $search_criteria['To'], format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true))?>
			<?php else:?>
				<?=lang_arg('select_your_return', $search_criteria['To'], $search_criteria['From'], format_bpv_date($search_criteria['Return'], DATE_FORMAT, true))?>
			<?php endif;?>
		</h2>
		
		
		<p class="bpv-color-warning margin-top-10 margin-bottom-20">
			<?=lang('flight_search_note')?>
		</p>
		
		<?=load_flight_search_calendar($flight_type, $search_criteria, $sid)?>
		
	</div>
	
	<div id="flight_search_result_area">
	
		<?=$sort_by_view?>
		
		<div id="rows_content">
			
		<?php foreach ($flight_data as $flight):?>	
			
			<?php 
				$flight_class = $flight['Class'];
				$flight_rclass = $flight['RClass'];
				$flight_stop = $flight['Stop'];
			?>
					
		<div class="bpv-list-item margin-bottom-20 clearfix" id="flight_row_<?=$flight['Seg']?>" price="<?=$flight['PriceInfo'][0]['ADT_Fare']?>" airline="<?=$flight['Airlines']?>" 
			time="<?=$flight['departure_time_index']?>" code="<?=$flight['FlightCode']?>" timefrom = "<?=$flight['TimeFrom']?>"
			timeto="<?=$flight['TimeTo']?>" flightclass="<?=$flight_class?>" flightrclass="<?=$flight_rclass?>" flightstop="<?=$flight_stop?>">
			
			<div class="row" id="flight_content_<?=$flight['Seg']?>">			
				<div class="col-xs-3">
					<span class="flight-<?=$flight['Airlines']?>"></span>
					<span class="flight-name"><?=$domistic_airlines[$flight['Airlines']]?></span>			
				</div>
				
				<div class="col-xs-1 no-padding">
					<span class="flight-code"><?=$flight['FlightCode']?></span>
				</div>
				
				<div class="col-xs-4">
					<span class="flight-code"><?=format_flight_time($flight['TimeFrom'])?> - <?=format_flight_time($flight['TimeTo'])?></span>
					<br>
					<?php if($flight_type == FLIGHT_TYPE_DEPART):?>
						<?=$search_criteria['From']?> - <?=$search_criteria['To']?> - <?=$search_criteria['Depart']?>
					<?php else:?>
						<?=$search_criteria['To']?> - <?=$search_criteria['From']?> - <?=$search_criteria['Return']?>
					<?php endif;?>
				</div>
				
				
				<div class="col-xs-4 text-right">
					<div class="bpv-price-from">
						<?=bpv_format_currency($flight['PriceInfo'][0]['ADT_Fare'])?></span><small><?=lang('per_ticket')?></small>
					</div>
					<?php if($flight['Seat'] > 0 && $flight['Seat'] < 7):?>
						<div class="flight-seat margin-top-5">
							<?=lang_arg('flight_seat_available', $flight['Seat'])?>
						</div>
					<?php endif;?>
					
				</div>
			
			</div>
			
			<div class="row" style="margin-top:15px">
				<div class="col-xs-6">
					<span class="show-detail"><a id="show_<?=$flight['Seg']?>" href="javascript:show_flight_detail('<?=$sid?>',<?=$flight['Seg']?>,'<?=$flight_class?>','<?=$flight_stop?>','<?=$flight_type?>')"><?=lang('show_flight_detail')?></a></span>
				</div>
				
				<div class="col-xs-6">
					<button id="select_<?=$flight['Seg']?>" onclick="select_flight('<?=$flight['Seg']?>','<?=$flight_type?>')" 
					type="button" class="btn btn-bpv btn-book-now pull-right" data-loading-text="<?=lang('flight_processing')?>"><?=lang('select_flight')?></button>			
				</div>
			</div>
			<div class="flight-details" id="flight_detail_<?=$flight['Seg']?>" loaded="0" style="display:none" show="hide">
			</div>
		</div>
		
		<?php endforeach;?>
		
		</div>
		
		
		<script type="text/javascript">
			var airlines = <?=json_encode($airlines)?>;
			var selected_airline = '<?=isset($search_criteria['Airline'])? $search_criteria['Airline'] : ''?>';
			create_airline_filters(airlines, selected_airline);
	
			<?php if(!empty($selected_departure)):?>
				update_selected_depature_flight('<?=$selected_departure?>', '<?=$sid?>');
			<?php endif;?>
		</script>
	
	</div>
	
<?php endif;?>