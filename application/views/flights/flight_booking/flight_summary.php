
<div>
	<div class="bpv-total-payment margin-bottom-20">
		<h2><?=lang('payment_detail')?></h2>
		
		<?php 
			$prices = $flight_booking['prices'];
			$baggage_fees = isset($flight_booking['baggage_fees']) ? $flight_booking['baggage_fees'] : array();
			$total_kg = isset($baggage_fees['total_kg']) ? $baggage_fees['total_kg'] : 0;
			$total_fee = isset($baggage_fees['total_fee']) ? $baggage_fees['total_fee'] : 0;
		?>

		<div class="content">
			<div class="row margin-bottom-10">
				<div class="col-xs-12">
					<b><?=$search_criteria['From']?></b>
					<?=lang('flight_go')?>
					<b><?=$search_criteria['To']?></b>
				</div>
			</div>
			
			<?php 
				if($search_criteria['is_domistic']){
					$flight_departure = $flight_booking['flight_departure'];
					$detail = $flight_departure['detail'];
					$time_depart = !empty($detail['routes'][0]) ? $detail['routes'][0]['from']['time'] : '';
				} else {
					$selected_flight = $flight_booking['selected_flight'];
					$time_depart = flight_time_format($selected_flight['depart_routes'][0]['TimeFrom']);
				}			
			?>

			<div class="row margin-bottom-5">
				<div class="col-xs-4">
					<b><?=lang('search_fields_departure')?>:</b>
				</div>
				<div class="col-xs-8">
					<?=$time_depart?> <?=format_bpv_date($search_criteria['Depart'], DATE_FORMAT, true)?>
				</div>
			</div>
			
			<?php if(!empty($search_criteria['Return'])):?>
			
				<?php
					if($search_criteria['is_domistic']){ 
						$flight_return = $flight_booking['flight_return'];
						$detail = $flight_return['detail'];
						$time_return = !empty($detail['routes'][0]) ? $detail['routes'][0]['from']['time'] : '';
					} else {
						$selected_flight = $flight_booking['selected_flight'];
						$time_return = flight_time_format($selected_flight['return_routes'][0]['TimeFrom']);
					}
				?>
		
				<div class="row margin-bottom-10">
					<div class="col-xs-4">
						<b><?=lang('search_fields_return')?>:</b>
					</div>
					<div class="col-xs-8">
						<?=$time_return?> <?=format_bpv_date($search_criteria['Return'], DATE_FORMAT, true)?>
					</div>
				</div>
			
			<?php endif;?>
			
			<div class="p-row clearfix">	
				<div class="col-1"><?=$search_criteria['ADT']?> <?=lang('search_fields_adults')?>:</div>
				<div class="col-2 price-value text-right"><?=!empty($prices['adult_fare_total'])?bpv_format_currency($prices['adult_fare_total']):0?></div>
			</div>
			
			<?php if($search_criteria['CHD'] > 0):?>
			<div class="p-row clearfix">	
				<div class="col-1"><?=$search_criteria['CHD']?> <?=lang('search_fields_children')?>:</div>
				<div class="col-2 price-value text-right"><?=!empty($prices['children_fare_total'])?bpv_format_currency($prices['children_fare_total']):0?></div>
			</div>
			<?php endif;?>
			
			<?php if($search_criteria['INF'] > 0):?>
			<div class="p-row clearfix">	
				<div class="col-1"><?=$search_criteria['INF']?> <?=lang('search_fields_infants')?>:</div>
				<div class="col-2 price-value text-right"><?=!empty($prices['infant_fare_total'])?bpv_format_currency($prices['infant_fare_total']):0?></div>
			</div>
			<?php endif;?>
			
			<div class="p-row clearfix">	
				<div class="col-1"><?=lang('tax_fee')?>:</div>
				<div class="col-2 price-value text-right"><?=bpv_format_currency($prices['total_tax'])?></div>
			</div>
			
			<div class="p-row clearfix" id="flight_baggage_fee" <?php if($total_fee == 0):?> style="display:none"<?php endif;?>>
				<div class="col-1"><?=lang_arg('baggage_fee', $total_kg)?>:</div>
				<div class="col-2 price-value text-right"><?=bpv_format_currency($total_fee)?></div>
			</div>
			
			<?php if(isset($prices['total_discount']) && $prices['total_discount'] > 0):?>
			<div class="p-row clearfix">	
				<div class="col-1"><b><?=lang('price_discount')?>:</b></div>
				<div class="col-2 price-value bpv-color-price text-right">- <?=bpv_format_currency($prices['total_discount'])?></div>
			</div>
			<?php endif;?>
			
			<div class="p-row clearfix" id="p_applied_code" style="display:none">
				<div class="col-1"><b><?=lang('discount_code')?> <span id="applied_code"></span>:</b></div>
				<div class="col-2 text-right bpv-color-price" id="applied_code_discount"></div>
			</div>
			
			<div class="p-row clearfix margin-bottom-5 total-payment" style="border-bottom:0">	
				<div class="col-1 text-right"><?=lang('price_total')?>:</div>
				<?php 
					$total_payment = $prices['total_price'] + $total_fee;
				?>
				<div class="col-2 text-right bpv-color-price" id="flight_total_price" ticket-price="<?=$prices['total_price']?>" total-price="<?=$total_payment?>"><?=bpv_format_currency($total_payment)?></div>
			</div>
			
			<div class="text-right">
				*<?=lang('flight_price_include')?>
			</div>
			
		</div>
		
		<div class="pro-code">
			<div class="p-row clearfix" style="border-bottom:0">
				<p class="text-warning" style="display:none" id="code_invalid">
					<span class="glyphicon glyphicon-warning-sign"></span>
					<?=lang('bpv_pro_code_invalid')?>
				</p>
				
				<p class="text-warning pro_phone_invalid" style="display:none">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    <span class="pro_phone_invalid_msg"><?=lang('bpv_pro_phone_invalid')?></span>
        		</p>
				
				<p class="text-success" style="display:none" id="code_ok">
					<span class="glyphicon glyphicon-ok"></span>
					<?=lang('bpv_pro_code_ok')?>
				</p>
				
				<div class="pro_phone_block" style="display: none; margin-bottom: 5px; overflow: hidden;">
        			<div class="col-2" style="padding-top:10px"><b><?=lang('lbl_phone')?></b></div>
        			<div class="col-1 text-right">
                        <input type="text" class="form-control" id="pro_phone" placeholder="" style="font-weight:normal">
        			</div>
    			</div>
				<div class="col-1" style="padding-top:7px"><b><?=lang('bpv_pro_code')?>:</b></div>
				<div class="col-2 text-right">
					<input type="text" class="form-control" value="<?=!empty($flight_booking['promotion_code']) ? $flight_booking['promotion_code'] : ''?>" id="pro_code" placeholder="ABCXYZ..." style="font-weight:normal">
					
					<?php 
						$nr_ticket = $search_criteria['ADT'] + $search_criteria['CHD'] + $search_criteria['INF'];
						$nr_ticket = $search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY ? $nr_ticket * 2 : $nr_ticket;
					?>
					<input type="hidden" id="nr_ticket" value="<?=$nr_ticket?>">
					
					<button class="btn btn-bpv btn-book-now btn-sm margin-top-10" id="pro_use" style="display:none" onclick="use_pro_code(<?=FLIGHT?>)" data-loading-text="<?=lang('bpv_pro_code_loading')?>">
						<?=lang('bpv_pro_use')?>
					</button>
				</div>
			</div>
		</div>
		
	</div>
	<?=load_bpv_call_us(FLIGHT)?>
	<div class="margin-bottom-20"></div>
</div>

<script type="text/javascript">
$(function() {
	init_payment_detail();
	<?php if(!empty($flight_booking['promotion_code'])):?>
		use_pro_code(<?=FLIGHT?>);
	<?php endif;?>
});
</script>