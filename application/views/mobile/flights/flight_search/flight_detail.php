<div class="flight-details" >
<?php if($prices['total_price'] == 0):?>
<div class="col-xs-12">
	<div class="alert alert-warning alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
      <strong><?=$seat_unavailable_txt?></strong>
    </div>
</div>   
<?php else:?>
<div class="margin-top-10 padding-top-10" style="border-top: 1px dashed #c8c8c8;">
	<div class="flight-price">
		<div class="row margin-bottom-10">	
			<div class="col-xs-6 text-left"><?=$prices['adults']?> <?=lang('label_adults')?>:</div>
			<div class="col-xs-6 price-value text-right">$&nbsp;<?=!empty($prices['adult_fare_total'])? $prices['adult_fare_total']:0?></div>
		</div>
		<?php if($prices['children'] > 0):?>
		<div class="row margin-bottom-10">	
			<div class="col-xs-6 text-left"><?=$prices['children']?> <?=lang('label_children')?>:</div>
			<div class="col-xs-6 price-value text-right">$&nbsp;<?=!empty($prices['children_fare_total'])? $prices['children_fare_total'] :0?></div>
		</div>
		<?php endif;?>
		
		<?php if($prices['infants'] > 0):?>
		<div class="row margin-bottom-10">	
			<div class="col-xs-6 text-left"><?=$prices['infants']?> <?=lang('label_infants')?>:</div>
			<div class="col-xs-6 price-value text-right">$&nbsp;<?=!empty($prices['infant_fare_total'])? $prices['infant_fare_total']:0?></div>
		</div>
		<?php endif;?>
		
		<div class="row margin-bottom-10">	
			<div class="col-xs-6 text-left"><?=lang('tax_fee')?>:</div>
			<div class="col-xs-6 price-value text-right">$&nbsp;<?=$prices['total_tax']?></div>
		</div>
		
		<div style="border-top: 1px solid #c8c8c8;" class="margin-bottom-10"></div>
		
		<div class="row price-total">	
			<div class="col-xs-6 label-total  text-left"><?=lang('total_price')?>:</div>
			<div class="col-xs-6 price-total text-right text-price"><?=CURRENCY_SYMBOL?><?=$prices['total_price']?></div>
		</div>
	</div>

	<div class="sep-line">
		<h3 class="bpv-color-title text-highlight"><?=lang('flight_itineray')?>:</h3>
		<?php foreach ($routes as $key=>$route):?>
		<div class="row flight-route" <?php if($key == count($routes) - 1):?> style="border-bottom: 0"<?php endif;?>>
			<div class="col-xs-6">
				<?php $from = $route['from']?>
				<div class="margin-bottom-5">
					<?=lang('flight_label_from')?>: <b><?=$from['city']?></b>
					<?php if(!empty($from['country'])):?>
					, <?=$from['country']?>
					<?php endif;?>
				</div>
				
				<div class="margin-bottom-5">
					<?=$from['airport']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=$from['time']?></b> <?=$from['date']?> 
				</div>
				
				<div class="margin-bottom-5">
					<b><?=$route['airline']?></b> 
				</div>
			</div>
			
			<div class="col-xs-6">
				<?php $to = $route['to']?>
				<div class="margin-bottom-5">
					<?=lang('flight_label_to')?>: <b><?=$to['city']?></b><!-- city -->
					<?php if(!empty($to['country'])):?>
					, <?=$to['country']?>
					<?php endif;?>
				</div>
				
				<div class="margin-bottom-5">
					<?=$to['airport']?>
				</div>
				
				<div class="margin-bottom-5">
					<b><?=$to['time']?></b> <?=$to['date']?>
				</div>
			</div>
		</div>	
		<?php endforeach;?>
		
		<?php if(!empty($fare_rules)):?>
		<div class="row">
			<div class="col-xs-12">
				<h3 class="bpv-color-title text-highlight margin-top-10"><?=lang('fare_rules')?>:</h3>
				<?=$fare_rules?>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>
<?php endif;?>
</div>
