<?php if(empty($advertises)):?>
		
	<?php if($ad_page == AD_PAGE_FLIGHT):?>
		<img class="img-responsive" style="min-height: 355px" src="<?=get_static_resources('/media/banners/flight_banner.jpg')?>">
	<?php elseif($ad_page == AD_PAGE_HOME):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/home_banner_07052014.jpg')?>">
	<?php elseif($ad_page == AD_PAGE_HOTEL_HOME || $ad_page == AD_PAGE_DEAL):?>
		<img class="img-responsive" style="min-height: 355px" src="<?=get_static_resources('/media/banners/hotel_banner.jpg')?>">
	<?php elseif($ad_page == AD_PAGE_CRUISE_HOME):?>
		<img class="img-responsive" style="min-height: 355px" src="<?=get_static_resources('/media/banners/cruise_banner.05062014.jpg')?>">
	
	<?php elseif($ad_page == AD_PAGE_TOUR_HOME):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/tour/tour.jpg')?>" style="min-height: 355px; margin: 0 auto;">
	<?php elseif($ad_page == AD_PAGE_TOUR_DOMISTIC):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/tour/tour_trong_nuoc.jpg')?>" style="min-height: 355px; margin: 0 auto;">
	<?php elseif($ad_page == AD_PAGE_TOUR_OUTBOUND):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/tour/tour_nuoc_ngoai.jpg')?>" style="min-height: 355px; margin: 0 auto;">
	<?php elseif($ad_page == AD_PAGE_TOUR_CATEGORY):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/tour/tour_chu_de.jpg')?>" style="min-height: 355px; margin: 0 auto;">
	<?php elseif($ad_page == AD_PAGE_TOUR_DESTINATION):?>
		<img class="img-responsive" src="<?=get_static_resources('/media/banners/tour/tour.jpg')?>" style="min-height: 355px; margin: 0 auto;">
	<?php endif;?>
		
<?php else :?>

	<?php if(count($advertises) == 1 && count($advertises[0]['photos']) == 1):?>
		<div>
			<a href="<?=generate_advertise_link($advertises[0], $ad_page)?>">
				<img class="img-responsive" <?php if($ad_page != AD_PAGE_HOME && $ad_page != AD_PAGE_HOTEL_DESTINATION) echo 'style="min-height: 355px"';?> src="<?=get_static_resources('/images/advertises/'.$advertises[0]['photos'][0]['name'])?>">
			</a>
		</div>
	<?php else:?>
	
		<div id="carousel-bpv-ads" class="carousel slide" data-ride="carousel" data-ride="carousel">
		  	<!-- Indicators -->
			<ol class="carousel-indicators">
				<?php $index = 0;?>
				<?php foreach ($advertises as $ads):?>
				
					<?php foreach ($ads['photos'] as $photo):?>
					<li data-target="#carousel-bpv-ads" data-slide-to="<?=$index?>" <?=($index==0) ? 'class="active"' : ''?>></li>
					<?php $index++;?>
					<?php endforeach;?>
					
				<?php endforeach;?>
	  		</ol>
	  
			<!-- Wrapper for slides -->
			<div class="carousel-inner">
				<?php $cnt = 0;?>
				<?php foreach ($advertises as $ads):?>
				
					<?php foreach ($ads['photos'] as $photo):?>
					<div class="item <?= ($cnt==0) ? 'active': ''?>">
						<a href="<?=generate_advertise_link($ads, $ad_page)?>">
							<img class="img-responsive" <?php if($ad_page != AD_PAGE_HOME && $ad_page != AD_PAGE_HOTEL_DESTINATION):?>style="min-height: 355px; margin: 0 auto;"<?php endif;?> src="<?=get_static_resources('/images/advertises/'.$photo['name'])?>">
						</a>
					</div>
					<?php $cnt++;?>
					<?php endforeach;?>
					
				<?php endforeach;?>
			</div>
			
			<!-- Controls -->
			<!-- 
			<a class="left carousel-control" href="#carousel-bpv-ads" data-slide="prev">
	    		<span class="glyphicon glyphicon-chevron-left"></span>
	  		</a>
	  		<a class="right carousel-control" href="#carousel-bpv-ads" data-slide="next">
	    		<span class="glyphicon glyphicon-chevron-right"></span>
	  		</a>
	  		 -->
		</div>
	<?php endif;?>
<?php endif;?>