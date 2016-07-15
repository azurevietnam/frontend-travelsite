<div class="flight-summary">
	<div class="header">
		<h2><?=lang('flight_summary')?></h2>
	</div>
	
	<?php 
		$prices = $flight_booking['prices'];
		$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();
		$total_kg = isset($baggage_fees['total_kg']) ? $baggage_fees['total_kg'] : 0;
		$total_fee = isset($baggage_fees['total_fee_usd']) ? $baggage_fees['total_fee_usd'] : 0;
	?>
	
	<div class="content">
	
		<div class="row">
			<b><?=$search_criteria['From']?></b>
			<?=strtolower(lang('flight_label_to'))?>
			<b><?=$search_criteria['To']?></b>
			(<?=($search_criteria['Type'] == 'roundway' ? lang('roundtrip') : lang('one_way'))?>)
		</div>
		
		<div class="row">
			<div class="col-xs-5 no-padding"><b><?=lang('departing')?>: </b> </div> 
			<div class="col-xs-7 "> <?=date(FLIGHT_DATE_FORMAT, strtotime($search_criteria['Depart']))?></div>
		</div>
		<div class="row">
			<?php if($search_criteria['Type'] == 'roundway'):?>
				<div class="col-xs-5 no-padding"><b><?=lang('returning')?>: </b></div> 
				<div class="col-xs-7 "> <?=date(FLIGHT_DATE_FORMAT, strtotime($search_criteria['Return']))?>	</div>
			<?php endif;?>			
		</div>
		
		<div class="row"></div>
		
		<div class="row line">				
			<span class="row-label"><?=$search_criteria['ADT']?> <?=($search_criteria['ADT'] > 1? lang('label_adults'): lang('label_adult'))?>:</span>				
			<span class="row-content"><?=CURRENCY_SYMBOL?><?=$prices['adult_fare_total']?></span>				
		</div>
		
		<?php if($search_criteria['CHD'] > 0):?>			
			<div class="row line">
				<span class="row-label"><?=$search_criteria['CHD']?> <?=($search_criteria['CHD'] > 1? lang('label_children'): lang('label_child'))?>:</span>
				<span class="row-content"><?=CURRENCY_SYMBOL?><?=$prices['children_fare_total']?></span>
			</div>
		<?php endif;?>
		
		<?php if($search_criteria['INF'] > 0):?>
		<div class="row line">
			<span class="row-label"><?=$search_criteria['INF']?> <?=($search_criteria['INF'] > 1? lang('label_infants'): lang('label_infant'))?>:</span>
			<span class="row-content"><?=CURRENCY_SYMBOL?><?=$prices['infant_fare_total']?></span>
		</div>
		<?php endif;?>
		
		<div class="row line">
			<span class="row-label"><?=lang('tax_fee')?>:</span>
			<span class="row-content"><?=CURRENCY_SYMBOL?><?=$prices['total_tax']?></span>
		</div>
		
		<div class="row line" id="flight_baggage_fee" <?php if($total_fee == 0):?> style="display:none"<?php endif;?>>
			<span class="row-label"><?=lang_arg('baggage_fee', $total_kg)?>:</span>
			<span class="row-content" style="width:40%"><?=CURRENCY_SYMBOL?><?=$total_fee?></span>
		</div>
			
		<div class="row price-total">
			<span style="font-size:14px"><?=lang('total')?>:&nbsp;</span>
			<span class="text-price" id="flight_total_price" ticket-price="<?=$prices['total_price']?>"><?=CURRENCY_SYMBOL?><?=$prices['total_price'] + $total_fee?></span>
		</div>
		
		
		<div class="row" style="text-align: right;">
			<?=lang('price_note')?>
		</div>
		
		<div class="row"></div>
	</div>
	
</div>