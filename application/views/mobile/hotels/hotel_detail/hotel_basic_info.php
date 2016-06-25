<div class="container basic-info">
	<div class="hotel-address">
		<span class="icon icon-map-xs pull-left margin-right-10"></span>
		<?php 
			$hotel_area = $parents[count($parents) - 1];
		?>
		<p style="margin-top:15px"><?=$hotel['address']?></p>
		<p><span class="icon icon-marker-md"></span><a id="marker_map_click" href="#show_hotel_map_mobile" ><?=lang('view_map')?></a></p>
	</div>
	<div class="row margin-top-10 margin-bottom-10">
		<div class="col-xs-6">
			<?php if (!empty($hotel_price_from)):?>
				<?php if($hotel_price_from['price_origin'] != $hotel_price_from['price_from']):?>
					<span class="bpv-price-origin"><?=bpv_format_currency($hotel_price_from['price_origin'])?></span>
				<?php endif;?>
				
				<span class="bpv-price-from">
				 	<?=bpv_format_currency($hotel_price_from['price_from'])?>
				</span>
			<?php endif;?>
		</div>
		<div class="col-xs-6">
			
			<?php 
				$call_us = load_bpv_call_us_number(HOTEL);
			?>
			<?php if(!empty($call_us)):?>
		    	<a class="btn-call pull-right" href="tel:<?=$call_us?>">
            		<i class="glyphicon glyphicon-earphone"></i> <span><?=$call_us?></span>
            	</a>
	        <?php endif;?>
        </div>
	</div>
	

	<!-- Promotion from the Hotel -->
	<?php if (!empty($hotel_promotions)):?>
		<?php foreach ($hotel_promotions as $pro):?>
			<div class="margin-bottom-10 bpv-pro">
				<?=load_promotion_tooltip($pro,'','left', TRUE)?>
				<i class="icon icon-arrow-right-gray"></i>
			</div>
		<?php endforeach;?>	
	<?php endif;?>
	
	<?php if (!empty($bpv_promotions)):?>
	<!-- Promotion from Best Price -->
		<?php foreach ($bpv_promotions as $bpv_pro):?>
			<div class="margin-bottom-10 bpv-pro">
				<?=load_marketing_pro_tooltip($bpv_pro, $hotel['id'], 'left', TRUE)?>
				<i class="icon icon-arrow-right-gray"></i>
			</div>
		<?php endforeach;?>	
	<?php endif;?>
</div>
<script>
	$("#marker_map_click").click(function(){
    	$("#show_hotel_map_mobile").show();
  	});
</script>
