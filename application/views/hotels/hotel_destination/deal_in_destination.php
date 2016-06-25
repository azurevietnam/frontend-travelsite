<div id="carousel-hotel-deal-in-des" class="carousel slide" data-ride="carousel" data-ride="carousel">
  	<!-- Indicators -->
	<ol class="carousel-indicators">
		<?php foreach ($hotel_deals as $key => $hotel):?>
		
			<li data-target="#carousel-hotel-deal-in-des" data-slide-to="<?=$key?>" <?=($key==0) ? 'class="active"' : ''?>></li>
			
		<?php endforeach;?>
  	</ol>
  
		<!-- Wrapper for slides -->
	<div class="carousel-inner">
		<?php foreach ($hotel_deals as $key => $hotel):?>
		
			<div class="item <?= ($key==0) ? 'active': ''?> deal-item-h-des" onclick="go_url('<?=hotel_build_url($hotel, $search_criteria)?>')">
				<div class="deal-content">
					<div class="hotel-name">
						<?=$hotel['name']?>
						<span class="icon star-<?=$hotel['star']?>"></span>
					</div>
					
					<?php if(!empty($hotel['promotions'])):?>
						<?php 
							$pro = $hotel['promotions'][0];
						?>
					<div class="pro-name">
						<?=$pro['name']?>
					</div>
					<?php endif;?>
					
					<?php 
						$deal_offer = get_hotel_pro_value($hotel);
					?>
					<?php if(!empty($deal_offer)):?>
						<div class="deal-offer">
							<span class="deal-txt">
								<?=get_hotel_pro_value($hotel)?>
							</span>
							<span class="go"></span>
							
							<div class="deal-arrow"></div>
						</div>
					<?php endif;?>
					
				</div>
				<a class="deal-img" href="<?=hotel_build_url($hotel, $search_criteria)?>">
					<img width="100%" src="<?=get_image_path(HOTEL, $hotel['picture'])?>">
				</a>
				
			</div>
			
		<?php endforeach;?>
	</div>
	
	<!-- Controls -->
	<!-- 
	<a class="left carousel-control" href="#carousel-hotel-deal-in-des" data-slide="prev">
    	<span class="glyphicon glyphicon-chevron-left"></span>
  	</a>
  	
  	<a class="right carousel-control" href="#carousel-hotel-deal-in-des" data-slide="next">
    	<span class="glyphicon glyphicon-chevron-right"></span>
  	</a>
  	 -->	 
</div>
