<?php if(isset($error_code)):?>
	<?php 
		echo load_flight_booking_exception($search_criteria, $error_code, $is_mobile);
	?>	
<?php else:?>
	<div class="margin-bottom-20">
		<h3 class="bpv-color-title">
			
			<?=lang('select_your_flight')?> <?=$search_criteria['From']?> <?=lang('flight_go')?> <?=$search_criteria['To']?>
			
			<?php if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY):?>
				
				 <?=lang('return_ticket')?>
			
			<?php else:?>
				<?=lang('oneway_ticket')?>
			<?php endif;?>
		
		</h3>
		
		<?=load_flight_search_calendar($flight_type, $search_criteria, $sid)?>
		
	</div>
	
	<div id="flight_search_result_area">
	
	<div class="row margin-bottom-10">
		
	    <?php 
			$call_us = load_bpv_call_us_number(FLIGHT);
		?>
		<?php if(!empty($call_us)):?>
	    <div class="search-call-us pull-left">
           <span class="glyphicon glyphicon-earphone"></span> <a href="tel:<?=format_phone_number($call_us)?>"> <?=$call_us?></a>
        </div>
        <?php endif;?>
       
        
        <div class="pull-right text-right no-padding">
	        <button type="button" class="btn btn-default btn-filter" data-target="#bpv-filter">
			    <?=lang('filter_result')?> <span class="caret"></span>
			</button>
			<button type="button" class="btn btn-default btn-filter" data-target="#bpv-sort">
			    <?=lang('sort_by')?> <span class="caret"></span>
			</button>
		</div>
	</div>
		
	
	<div id="bpv-sort" class="bpv-s-content">
		<?=$sort_by_view?>
	</div>
	
	<div id="bpv-filter" class="bpv-s-content">
		<?=$flight_search_filters?>
	</div>

	
	<div class="margin-top-10 text-right">(<?=lang('price_include_desc')?>)</div>
	
	
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
		
		<div class="row">			
			<div class="col-xs-3">
				<img src="<?=get_logo_of_flight_company($flight_depart['Airlines'])?>">
				
			</div>
			
			<div class="col-xs-4">
				<?=$flight_depart['StopTxt']?>
			</div>

			<div class="col-xs-5 text-right">
				
				<?php if(isset($flight['PriceOrigin'])):?>
					<span class="bpv-price-origin">
						<?=bpv_format_currency($flight['PriceOrigin'])?>
					</span>
					&nbsp;
				<?php endif;?>
				
				<span class="bpv-price-from">
					<?=bpv_format_currency($flight['PriceFrom'])?><small><?=lang('per_ticket')?></small>
				</span>
			</div>
		
		</div>
		
		<div class="row">
			<div class="col-xs-3"><span><?=$flight_depart['FlightCode']?></span></div>
			<div class="col-xs-9">
				<b><?=format_flight_time($flight_depart['TimeFrom'])?> - <?=format_flight_time($flight_depart['TimeTo'])?></b>
				
				<?php 
					$flying_time = calculate_flying_time($flight_depart['TimeFrom'], $flight_depart['DayFrom'], $flight_depart['MonthFrom'], 
						$flight_depart['TimeTo'], $flight_depart['DayTo'], $flight_depart['MonthTo']);
				?>
				(<?=lang_arg('total_fly_time', $flying_time['h'], $flying_time['m'])?>)
			</div>
			
		</div>
		
		
		<?php if(isset($flight['flight_return'])):?>
			
			<?php 
				$flight_return = $flight['flight_return'];
			?>
			
			
			<div class="row" style="margin:10px 0">
				<div class="col-xs-10" style="border-bottom:1px dashed #C8C8C8"></div>
			</div>
			
			<div class="row margin-bottom-5">
				<div class="col-xs-12">
					<label><?=lang('flight_way_return').' '.$search_criteria['To']. ' - '.$search_criteria['From']?>, <?=$flight_return['DayFrom'].'/'.$flight_return['MonthFrom']?></label>
				</div>
			</div>
			<div class="row">			
				<div class="col-xs-3">
					<img src="<?=get_logo_of_flight_company($flight_return['Airlines'])?>">
				</div>
				
				<div class="col-xs-4">
					<?=$flight_return['StopTxt']?>
				</div>
			
			</div>
			
			<div class="row">
				<div class="col-xs-3"><?=$flight_return['FlightCode']?></div>
			
				<div class="col-xs-9">
					<b><?=format_flight_time($flight_return['TimeFrom'])?> - <?=format_flight_time($flight_return['TimeTo'])?></b>
				
					<?php 
						$flying_time = calculate_flying_time($flight_return['TimeFrom'], $flight_return['DayFrom'], $flight_return['MonthFrom'], 
							$flight_return['TimeTo'], $flight_return['DayTo'], $flight_return['MonthTo']);
					?>
					(<?=lang_arg('total_fly_time', $flying_time['h'], $flying_time['m'])?>)
				</div>
			</div>
		
		<?php endif;?>
		
		<?php if(isset($flight['DiscountNote'])):?>
			<div class="bpv-color-promotion margin-top-15">
				<span style="margin:2px 5px 0 0" class="icon icon-promotion"></span>
				<?=$flight['DiscountNote']?>
			</div>
		<?php endif;?>
		
		
		<div class="row margin-top-15">
			<div class="col-xs-8">
				<span class="show-detail"><a id="show_<?=$flight['Seg']?>" href="javascript:show_flight_detail('<?=$sid?>',<?=$flight['Seg']?>)"><?=lang('show_flight_detail')?></a></span>
			</div>
			
			<div class="col-xs-4">
				<button id="select_<?=$flight['Seg']?>" onclick="select_flight_inter('<?=$flight['Seg']?>')" 
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

		$('.btn-filter').bpvToggle(function(data) {
	        
	        if( $('#bpv-sort').is(":visible") && data['id'] != '#bpv-sort') {
	            $('#bpv-sort').hide();
	        }
	        if( $('#bpv-filter').is(":visible") && data['id'] != '#bpv-filter') {
	            $('#bpv-filter').hide();
	        }
	    });
	    
	</script>
	
	</div>
<?php endif;?>