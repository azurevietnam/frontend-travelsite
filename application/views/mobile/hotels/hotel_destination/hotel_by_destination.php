<div class="container">
	<?=$bpv_search?>
	
	<h1 class="bpv-color-title">
	<?= is_root_destination($destination) ? lang('hotel_in_title') . $destination['name'] : lang('hotel_around_title') . $destination['name'];?>
	</h1>
	
	<div class="row">
		
		<?php if(!empty($bpv_ads_default)):?>
				<?=$bpv_ads_default?>
			<?php elseif(!empty($deal_in_destination)):?>
				<?=$deal_in_destination?>
			<?php else:?>
			
				<?php
					$img_src = '/media/hotel/khach-san-vietnam-05062014.jpg';
					
					if(!empty($destination['picture'])) { 
						$img_src = '/images/destinations/'.$destination['picture'];
					}
					else if( $destination['type'] != DESTINATION_TYPE_CITY && !empty($city['picture'])) {
						$img_src = '/images/destinations/'.$city['picture'];
					}
				?>
					
				<div class="deal-item-h-des" style="cursor: default;">
					<?php if(!empty($destination['number_of_hotels'])):?>
						<div class="deal-content">
							<div class="hotel-des-info">
								<span class="des-name"><?=$destination['name']?></span>
								<span class="des-numb-hotel"><?=$destination['number_of_hotels']?></span>
								<span class="des-hotel"><?=lang('hotel_txt')?></span>
							</div>
						</div>
					<?php endif;?>
					
					<img class="deal-img" src="<?=get_static_resources($img_src)?>">
				</div>
		<?php endif;?>
			
		
	</div>
	
	<?php if( !empty($hotels) ):?>
	
	<div class="row">
		<h2 class="bpv-color-title pd-10">
			<?php if( is_root_destination($destination) ):?>
			<?=lang('top_ten_hotel'). ' ' . $destination['name']?>
			<?php else:?>
			<?=lang('around_hotel'). ' ' . $destination['name']?>
			<?php endif;?>
		</h2>
		
					
		<?=$hotel_list_in_des?>
	</div>
	

	<div class="margin-top-15 margin-bottom-15 text-center">
		<a class="view-more-btn center-block" href="<?=get_url(HOTEL_SEARCH_PAGE, $url_params)?>">
			<?php 
				$number_of_hotels = !empty($destination['number_of_hotels']) ? $destination['number_of_hotels'] : '';
				
				if(is_root_destination($destination)) {
					echo lang_arg('view_more_hote_in_des', $number_of_hotels, $destination['name']);
				} else {
					echo lang_arg('view_more_hote_around_des', $number_of_hotels, $destination['name']);
				}
			?>
	       <i class="icon icon-chevron-right"></i>
	    </a>
	</div>
	
    
			
	<?php endif;?>
	
	<div class="row">
		<div class="col-xs-12">
	
			<?=$place_of_interest?>
			
			<?=$quick_search_links?>
			
			
		</div>
	</div>
	
</div>
<script>
	var gallery_load = new Loader();
	gallery_load.require(<?=get_libary_asyn_js('flexsilder')?>, 
 		function() {
			$('.flexslider').flexslider({
				animation: "slide",
				animationLoop: false,
				slideshow: false,		    
		    	controlNav: false
		  	});
  	}); 
</script>
