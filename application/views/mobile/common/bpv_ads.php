<?php if(empty($advertises)):?>
	
	<?php if($ad_page == AD_PAGE_HOME):?>
		<a href="<?=site_url()?>khach-san-da-nang-16.html?utm_source=bestprice&utm_medium=banner&utm_content=hotel_page&utm_campaign=km_70_off">
		    <img class="img-responsive" src="<?=get_static_resources('media/mobile/home-mobile.jpg')?>">
		</a>
	<?php elseif($ad_page == AD_PAGE_HOTEL_HOME || $ad_page == AD_PAGE_DEAL):?>
		<a href="<?=site_url()?>khach-san-da-nang-16.html?utm_source=bestprice&utm_medium=banner&utm_content=hotel_page&utm_campaign=km_70_off">
		    <img class="img-responsive" src="<?=get_static_resources('media/mobile/hotel-home.png')?>">
		</a>
	<?php elseif($ad_page == AD_PAGE_FLIGHT):?>
		
		<a href="<?=site_url()?>gioi-thieu.html?utm_source=bestprice&utm_medium=banner&utm_content=flight_page&utm_campaign=about_us">
			<img class="img-responsive" src="<?=get_static_resources('/media/mobile/flight-home.jpg')?>">
		</a>
	
	<?php elseif($ad_page == AD_PAGE_CRUISE_HOME):?>
		
		<a href="<?=site_url('du-thuyen-ha-long/du-thuyen-paloma-8.html?utm_source=bestprice&utm_medium=banner&utm_content=cruise_home_page&utm_campaign=BPV2907')?>">
		    <img class="img-responsive" src="<?=get_static_resources('/media/mobile/cruise-home.jpg')?>">
		</a>
	
	<?php elseif($ad_page == AD_PAGE_TOUR_HOME):?>
		
	<?php elseif($ad_page == AD_PAGE_TOUR_DOMISTIC):?>
		
	<?php elseif($ad_page == AD_PAGE_TOUR_OUTBOUND):?>
		
	<?php elseif($ad_page == AD_PAGE_TOUR_CATEGORY):?>
		
	<?php elseif($ad_page == AD_PAGE_TOUR_DESTINATION):?>
		
	<?php endif;?>
		
<?php else :?>

<div class="flexslider">
	<ul class="slides" style="height:auto">
		<?php foreach ($advertises as $ads):?>
			<?php foreach ($ads['photos'] as $photo):?>
			<li>
				<a href="<?=generate_advertise_link($ads, $ad_page)?>">
					<img class="img-responsive" src="<?=get_static_resources('/images/advertises/'.$photo['name'])?>" alt="<?=$ads['name']?>">
				</a>
		 	</li>
		 	<?php endforeach;?>
	 	<?php endforeach;?>
	</ul>
</div>

<script type="text/javascript">

	var gallery_load = new Loader();
	gallery_load.require(
		<?=get_libary_asyn_js('flexsilder')?>, 
	  function() {
			
			$('.flexslider').flexslider({
				animation: "slide",
				animationLoop: true,
				slideshow: true,
			    controlNav: false,
			    directionNav: false,
			    slideshowSpeed: 4000
			  });
			
	  }); 
</script>
<?php endif;?>