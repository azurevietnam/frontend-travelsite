<style>
.bpv-search{display:block}
.flight-tips img {   display: block;
  max-width: 100%;
  height: auto; }
</style>

<div class="container">
	
	<?=$bpv_search?>
	
	<h1 class="bpv-color-title no-margin"><?=lang('flights_to_text').$destination['name']?></h1>
	<div class="margin-top-10 margin-bottom-20 flight-tips">
	<?php
		$tips = $destination['flight_tips'];
		echo str_replace("\n", "<p/>", $tips);
	?>
	</div>
	<?php if(!empty($popular_routes)):?>
	<h3 class="bpv-color-title">
		<span class="icon icon-popular-flight"></span>
		<?=lang('popular_flight_des_routes') . $destination['name']?>
	</h3>
	<div class="row form-group">
        <div class="col-xs-12"><b><?=lang('flight_column_route')?></b></div>
	</div>
	<?php foreach ($popular_routes as $k => $route):?>
		<div class="row" style="border-top: 1px solid #eee">
            <div class="col-xs-12">
                <b id="sl_from_des_<?=$route['id']?>"><?=$route['from_des']?></b> - <b id="sl_to_des_<?=$route['id']?>"><?=$route['to_des']?></b>
            </div>
		</div>
	
        <?php foreach ($route['basic_prices'] as $z => $price):?>
        <div class="row" style="border-bottom: 1px solid #eee; padding-top: 10px">
        	<div class="col-xs-6">
        		<?php 
        			if($price['airline_id'] == 1) {
        				$src = '/media/flight/VN.gif';
        			} elseif($price['airline_id'] == 2) {
        				$src = '/media/flight/BL.gif';
        			} else {
        				$src = '/media/flight/VJ.gif';
        			}
        		?>
        		<img src="<?=get_static_resources($src)?>" class="floatL" id="sl_airline_img_<?=$route['id']?>_<?=$price['airline_id']?>">
                <br>
        		<label class="floatL" id="sl_airline_name_<?=$price['airline_id']?>"><?=$price['name']?></label>
        	</div>
        	<div class="col-xs-6">
        		<span class="bpv-price-from" style="font-size: 14px"><?=bpv_format_currency($price['price'])?></span>
        		<button class="btn btn btn-bpv" type="button" data-from="<?=$route['from_des']?>" data-to="<?=$route['to_des']?>"
        			onclick="select_destination_flight(this, '<?=$route['id']?>', '<?=$price['airline_id']?>', '<?=$price['code']?>', '<?=$route['from_code']?>', '<?=$route['to_code']?>')">
        		<?=lang('btn_flight_select')?>
        		</button>
        	</div>
        </div>
        <?php endforeach;?>
	<?php endforeach;?>
	
	<p class="bpv-color-title pull-right margin-top-10" style="font-size: 11px"><?=lang('popular_flight_routes_note')?></p>
	<?php endif;?>
    
    <?=$search_dialog?>
</div>