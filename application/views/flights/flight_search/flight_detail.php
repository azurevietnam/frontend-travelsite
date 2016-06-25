<div class="row">
<?php if($prices['total_price'] == 0):?>
<div class="col-xs-12">
	<div class="alert alert-warning alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
      <strong><?=$seat_unavailable_txt?></strong>
    </div>
</div>   
<?php else:?>
<div class="col-xs-8 sep-line">
	<h3 class="bpv-color-title"><?=lang('flight_itineray')?>:</h3>
	<?php foreach ($routes as $key=>$route):?>
	<div class="row flight-route" <?php if($key == count($routes) - 1):?> style="border-bottom: 0"<?php endif;?>>
		<div class="col-xs-6">
			<?php $from = $route['from']?>
			<div class="margin-bottom-5">
				<?=lang('flight_from')?>: <b><?=$from['city']?></b>
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
				<?=lang('flight_to')?>: <b><?=$to['city']?></b>
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
			<h3 class="bpv-color-title margin-top-20"><?=lang('fare_rules')?>:</h3>
			<?=$fare_rules?>
		</div>
	</div>
	<?php endif;?>
</div>

<div class="col-xs-4">
	<div class="flight-price">
		<div class="row margin-bottom-10">	
			<div class="col-xs-6"><?=$prices['adults']?> <?=lang('search_fields_adults')?>:</div>
			<div class="col-xs-6 price-value text-right"><?=!empty($prices['adult_fare_total'])?bpv_format_currency($prices['adult_fare_total']):0?></div>
		</div>
		<?php if($prices['children'] > 0):?>
		<div class="row margin-bottom-10">	
			<div class="col-xs-6"><?=$prices['children']?> <?=lang('search_fields_children')?>:</div>
			<div class="col-xs-6 price-value text-right"><?=!empty($prices['children_fare_total'])?bpv_format_currency($prices['children_fare_total']):0?></div>
		</div>
		<?php endif;?>
		
		<?php if($prices['infants'] > 0):?>
		<div class="row margin-bottom-10">	
			<div class="col-xs-6"><?=$prices['infants']?> <?=lang('search_fields_infants')?>:</div>
			<div class="col-xs-6 price-value text-right"><?=!empty($prices['infant_fare_total'])?bpv_format_currency($prices['infant_fare_total']):0?></div>
		</div>
		<?php endif;?>
		
		<div class="row margin-bottom-10">	
			<div class="col-xs-6"><?=lang('tax_fee')?>:</div>
			<div class="col-xs-6 price-value text-right"><?=bpv_format_currency($prices['total_tax'])?></div>
		</div>
		
		<div style="border-top: 1px solid #c8c8c8;" class="margin-bottom-10"></div>
		
		<div class="row">	
			<div class="col-xs-6 label-total text-right"><?=lang('price_total')?>:</div>
			<div class="col-xs-6 price-total text-right bpv-color-price"><?=bpv_format_currency($prices['total_price'])?></div>
		</div>
	</div>
</div>
<?php endif;?>
</div>
