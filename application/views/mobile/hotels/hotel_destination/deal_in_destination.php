<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($hotel_deals as $key => $hotel):?>
			<li>
			<div class="item <?= ($key==0) ? 'active': ''?> deal-item-h-des" onclick="go_url('<?=hotel_build_url($hotel, $search_criteria)?>')">
				<div class="deal-content">
					<h2 class="no-margin">
						<?=$hotel['name']?>
						<i class="icon star-<?=$hotel['star']?>"></i>
					</h2>
					
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
					<img class="img-responsive" src="<?=get_image_path(HOTEL, $hotel['picture'],'268x201')?>">
				</a>
			</div>
			
			</li>
		
		<?php endforeach;?>
	</ul>
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
