<?php if(isset($error_code)):?>
	<?php 
		echo load_flight_booking_exception($search_criteria, $error_code);
	?>	
<?php else:?>
	<div class="margin-bottom-10">
		<h2  class="text-highlight" style="margin-top: 0px;">
			
			<?=lang('select_your_flight')?> <span><?=$search_criteria['From']?></span> <?=lang('label_to')?> <span class="text-highlight"><?=$search_criteria['To']?></span>
			
			<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
				<span class="go">(<?=lang('roundtrip')?>)</span>
			<?php else:?>
				<span class="go">(<?=lang('one_way')?>)</span>
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
							
		<div class="bpv-list-item margin-bottom-20 clearfix" id="flight_row_<?=$flight['Seg']?>" price="<?=$flight['PriceFrom']?>" airline="<?=$flight['Airlines']?>" 
			time="<?=$flight['departure_time_index']?>" code="<?=$flight['FlightCode']?>" timefrom = "<?=$flight['TimeFrom']?>"
			timeto="<?=$flight['TimeTo']?>">
			
			<?php 
				$flight_depart = $flight['flight_depart'];
			?>
			
			<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
				<div class="row margin-bottom-5">
					<div class="col-xs-12">
						<label><?=lang('flight_way_depart').' '.$search_criteria['From']. ' - '.$search_criteria['To']?>, <?=$flight_depart['DayFrom'].'/'.$flight_depart['MonthFrom']?></label>
					</div>
				</div>
			<?php endif;?>
			
			<div>			
				<div class="row">
					<div class="col-xs-3"><img src="<?=get_logo_of_flight_company($flight_depart['Airlines'])?>"></div>
					
					<div class="col-xs-4" style="padding-top: 5px;">
							<?=$flight_depart['StopTxt']?>
					</div>
						
					<div class="col-xs-5 text-right">
						<?php if(isset($flight['PriceOrigin'])):?>
							<span class="bpv-price-origin">
								<?=convert_vnd_to_usd($flight['PriceOrigin'])?>
							</span>
							&nbsp;
						<?php endif;?>
						
						<span class="price-from">
							<?=CURRENCY_SYMBOL?><?=convert_vnd_to_usd($flight['PriceFrom'])?>
						</span><small><?=lang('per_pax')?></small>
						
						<?php if(isset($flight['DiscountNote'])):?>
							
							<div class="bpv-color-promotion margin-top-10">
								<span style="margin:2px 5px 0 0" class="icon icon-promotion"></span>
								<?=$flight['DiscountNote']?>
							</div>
						<?php endif;?>
					</div>
					
				</div>
				
				<div class="row">
					<div class="col-xs-3">
						<?=$flight_depart['FlightCode']?>
					</div>
					<div class="col-xs-8">
						<span class="flight-code"><?=format_flight_time($flight_depart['TimeFrom'])?> - <?=format_flight_time($flight_depart['TimeTo'])?></span>
						<span>
							<?php 
								$flying_time = calculate_flying_time($flight_depart['TimeFrom'], $flight_depart['DayFrom'], $flight_depart['MonthFrom'], 
									$flight_depart['TimeTo'], $flight_depart['DayTo'], $flight_depart['MonthTo']);
							?>
							(<?=lang_arg('total_fly_time', $flying_time['h'], $flying_time['m'])?>)
						</span>
											
					</div>
					
						

				</div>
				
				
				
				
			
			</div>
			
			<?php if(isset($flight['flight_return'])):?>
				
				<?php 
					$flight_return = $flight['flight_return'];
				?>
				
				
				<div class="row" style="margin:10px 0">
					<div class="col-xs-8" style="border-bottom:1px dashed #C8C8C8"></div>
				</div>
				
				<div class="row margin-bottom-5">
					<div class="col-xs-12">
						<label><?=lang('flight_way_return').' '.$search_criteria['To']. ' - '.$search_criteria['From']?>, <?=$flight_return['DayFrom'].'/'.$flight_return['MonthFrom']?></label>
					</div>
				</div>
				<div>			
					<div class="row">
						<div class="col-xs-3">
							<img src="<?=get_logo_of_flight_company($flight_return['Airlines'])?>">
						</div>
						<div class="col-xs-4" style="padding-top: 5px;">
							<?=$flight_return['StopTxt']?>
						</div>
						<div class="col-xs-5">
						</div>
						
						
								
					</div>
					
					<div class="row">
						<div class="col-xs-3">
							<span><?=$flight_return['FlightCode']?></span>
						</div>
						
						<div class="col-xs-9">
							<span class="flight-code"><?=format_flight_time($flight_return['TimeFrom'])?> - <?=format_flight_time($flight_return['TimeTo'])?></span>									
							<span>
								<?php 
									$flying_time = calculate_flying_time($flight_return['TimeFrom'], $flight_return['DayFrom'], $flight_return['MonthFrom'], 
										$flight_return['TimeTo'], $flight_return['DayTo'], $flight_return['MonthTo']);
								?>
								(<?=lang_arg('total_fly_time', $flying_time['h'], $flying_time['m'])?>)
								<?//=$flying_time['h'].'h '.$flying_time['m'].'m'?>
							</span>
						</div>
					</div>
					

				
				</div>
			
			<?php endif;?>
			
			
			<div class="row margin-top-15">
				<div class="col-xs-7">
					<span class="show-detail"><a id="show_<?=$flight['Seg']?>" href="javascript:show_flight_detail('<?=$sid?>',<?=$flight['Seg']?>)"><?=lang('flight_show_details')?></a></span>
				</div>
				
				<div class="col-xs-5">
					<button id="select_<?=$flight['Seg']?>" onclick="select_flight_inter('<?=$flight['Seg']?>')" 
					type="button" class="btn btn-yellow pull-right" data-loading-text="<?=lang('flight_proceed_checkout')?>"><?=lang('select_flight')?></button>			
				</div>
			</div>
			<div class="flight-details margin-top-15" id="flight_detail_<?=$flight['Seg']?>" loaded="0" style="border-top: 1px dashed #c8c8c8; padding-top: 15px; display:none" show="hide">
			</div>
		</div>
		
		<?php endforeach;?>
		
		</div>
	
		<script type="text/javascript">
			var airlines = <?=json_encode($airlines)?>;
			var selected_airline = '<?=isset($search_criteria['Airline'])? $search_criteria['Airline'] : ''?>';
			create_airline_filters(airlines, selected_airline);
		</script>
	
	</div>
	
<?php endif;?>
