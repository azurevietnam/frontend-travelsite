<?php if(isset($error_code)):?>
	<?php 
		echo load_flight_booking_exception($search_criteria, $error_code);
	?>	
<?php else:?>

	<div class="margin-bottom-15">
		<h2 class="bpv-color-title margin-bottom-15">
			<?php if($flight_type == FLIGHT_TYPE_DEPART):?>
				<?php echo '<span class="text-highlight">'. lang('select_your_departure') . ' '. $search_criteria['From']. ' - ' . $search_criteria['To'] .': ' . format_bpv_date($search_criteria['Depart'], DATE_FORMAT_DISPLAY, true) . '</span>'?>
			<?php else:?>
				<?php echo '<span class="text-highlight">'. lang('select_your_return') . ' '. $search_criteria['To']. ' - ' . $search_criteria['From'] .': ' . format_bpv_date($search_criteria['Return'], DATE_FORMAT_DISPLAY, true) . '</span>'?>
			<?php endif;?>
		</h2>
		
		<?=load_flight_search_calendar($flight_type, $search_criteria, $sid)?>
		
	</div>
	
	<div id="flight_search_result_area">
		<div class="row margin-bottom-10 text-right clearfix">
	       	<div class="col-xs-3"></div>
	        <div class="col-xs-4">
	            <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-sort">
	        	    <?=lang('sort_by')?> <span class="caret"></span>
	        	</button>
	        </div>
	        <div class="col-xs-5 padding-left-0">
	            <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-filter">
	        	    <?=lang('filter_results')?> <span class="caret"></span>
	        	</button>
	    	</div>
	    </div>
	    <div id="bpv-sort" class="bpv-s-content">
	        <?=$sort_by_view?>
	    </div>
	    
	    <div id="bpv-filter" class="bpv-s-content">
	        <?=$flight_search_filters?>
		</div>
		<script type="text/javascript">
	        $('.btn-filter').bpvToggle(function(data) {
	            if( $('#bpv-sort').is(":visible") && data['id'] != '#bpv-sort') {
	                $('#bpv-sort').hide();
	            }
	            if( $('#bpv-filter').is(":visible") && data['id'] != '#bpv-filter') {
	                $('#bpv-filter').hide();
	            }
	        });
   		</script>
   			
		<div>
			<p class="margin-top-10" style="margin-bottom: 0px; font-size: 13px;">
				<?=lang('price_include_desc')?>
			</p>
   		</div>
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
				
				<div class="col-xs-5">
					<div class=""><?=$flight['FlightCode']?></div>
					<div class="flight-code"><?=format_flight_time($flight['TimeFrom'])?> - <?=format_flight_time($flight['TimeTo'])?></div>
					
				</div>
				
				
				<div class="col-xs-4 padding--0 text-right">
					<div> 
						<span class="price-from"><?=CURRENCY_SYMBOL?><?=convert_vnd_to_usd($flight['PriceInfo'][0]['ADT_Fare'])?></span><small class="text-unhighlight"> <?=lang('per_pax')?></small>
					</div>
					<?php if($flight['Seat'] > 0 && $flight['Seat'] < 7):?>
						<div class="flight-seat margin-top-5">
							<?=lang_arg('flight_seat_available', $flight['Seat'])?>
						</div>
					<?php endif;?>
					
				</div>
			
			</div>
			
			<div class="row margin-top-10">
				<div class="col-xs-7">
					<span class="show-detail "><a id="show_<?=$flight['Seg']?>" href="javascript:show_flight_detail('<?=$sid?>',<?=$flight['Seg']?>,'<?=$flight_class?>','<?=$flight_stop?>','<?=$flight_type?>')"><?=lang('flight_show_details')?></a></span>
				</div>
				
				<div class="col-xs-5" style="padding-left: 0px;">
					<button id="select_<?=$flight['Seg']?>" onclick="select_flight('<?=$flight['Seg']?>','<?=$flight_type?>')" 
					type="button" class="btn btn-yellow pull-right" data-loading-text="<?=lang('flight_proceed_checkout')?>"><?=lang('select_flight')?></button>			
				</div>
			</div>
			<div class="flight-details margin-top-15" id="flight_detail_<?=$flight['Seg']?>" loaded="0" style="display:none;" show="hide">
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