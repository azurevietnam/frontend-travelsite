<?php 
	$chunk_hotel_arrays = array_chunk($hotels, 3);
?>

<?php foreach ($chunk_hotel_arrays as $sub_arr):?>

	<div class="row margin-bottom-20">
	
		<?php foreach ($sub_arr as $hotel):?>
			
			<?php
	
				$startdate = isset($hotel['stay_date_from']) ? $hotel['stay_date_from'] : date(DB_DATE_FORMAT);
				
				if($startdate < date(DB_DATE_FORMAT)){
					
					$startdate = date(DB_DATE_FORMAT);
				}
				
			
				$search_criteria['startdate'] = format_bpv_date($startdate, DATE_FORMAT); 
				$search_criteria['night'] = 1;
				$search_criteria['enddate'] = date(DATE_FORMAT, strtotime($startdate.' +1day'));
				$search_criteria['is_default'] = false;
			
			?>

			<div class="col-xs-4">
				<div style="position:relative;">
					<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
						<img alt="" class="img-responsive" src="<?=get_image_path(HOTEL, $hotel['picture'],'416x312')?>">
					</a>
					
					<?php 
						$deal_offer = get_hotel_pro_value($hotel);
					?>
					<?php if(!empty($deal_offer)):?>
						<div class="deal-offer"><?=get_hotel_pro_value($hotel)?><div class="deal-arrow"></div></div>
					<?php endif;?>
				</div>
				
				<div class="deal-hotel">
				
					<div class="margin-bottom-10 hotel-name">
						<a href="<?=hotel_build_url($hotel, $search_criteria)?>"><?=$hotel['name']?></a>
						<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
					</div>
					
					<?php if(!empty($hotel['promotions'])):?>
						<?php foreach ($hotel['promotions'] as $pro):?>
							<div class="margin-bottom-10">
								<?=load_promotion_tooltip($pro, $hotel['id'])?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
					
					
					<?php if(!empty($hotel['bpv_promotions'])):?>
						<?php foreach ($hotel['bpv_promotions'] as $bpv_pro):?>
							<div class="bpv-color-promotion margin-bottom-10">
								<?=load_marketing_pro_tooltip($bpv_pro, $hotel['id'])?>
							</div>
						<?php endforeach;?>
					<?php endif;?>
			
					
					<div class="clearfix">
						<?php if( isset($hotel['price_from']) ):?>
						
							<?php if($hotel['price_origin'] != $hotel['price_from']):?>
								<span class="bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></span>
								&nbsp;
							<?php endif;?>
							
							<span class="bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></span>
						
						<?php endif;?>
						<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
							<span class="glyphicon glyphicon-circle-arrow-right pull-right hotel-go"></span>
						</a>
					</div>
				
				</div>
	
			</div>
		
		
		<?php endforeach;?>
		
	</div>

<?php endforeach;?>
