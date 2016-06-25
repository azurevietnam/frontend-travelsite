<div class="container">
	<?=$bpv_search;?>
 
	<?=load_bpv_call_us(TOUR)?>
		
 		<?=load_slider($photos, DESTINATION)?>
	<h2 class="bpv-color-title margin-top-20">
		<?=$tour_destination_detail['name']?><?php if($tour_destination_detail['marketing_title'] != ''):?> - <?=$tour_destination_detail['marketing_title']?><?php endif;?>
	</h2>
	
	<?php 
		$travel_tip = $tour_destination_detail['travel_tip'];
		$travel_tip_arr = explode("\n", $travel_tip);
	?>
	
	<?php if($travel_tip !=""):?>
	<?php if(count($travel_tip_arr) >0):?>
	<h2 class="bpv-color-title margin-top-20"><?=lang('destination_suggestions')?> <?=$tour_destination_detail['name']?></h2>
		<div class="col-xs-12">
			<?php foreach($travel_tip_arr as $k =>$tip):?>
				<?php if(isset($tip)):?>
					<p>	<b style="color:#4eac00;"><?=$k+1?></b> <?=$tip?>	</p>
				<?php endif;?>
			<?php endforeach?>
		</div>
	<?php endif;?>
	<?php endif;?>
	
	<div class="clearfix"></div>
	
	<div class="row popular-destinaton">
		<?php if(count($activities) >0):?>
		<div class="group-name bpv-collapse margin-top-10" data-target="#activity">
        	<h3 class="heading">
           	 	<?=lang('destination_activities')?> <?=$tour_destination_detail['name']?>
              	<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
            </h3>
        </div>
		
		<div id="activity">
			<?php foreach($activities as $act):?>
				 <div class="col-xs-4">
					<img class="img-circle margin-top-15" width="110px" height="110px" src="<?=get_image_path(DESTINATION, $act['photo'])?>"/>
				 </div>
				 <div class="col-xs-8 margin-top-10">
					<span class="bpv-color-title"><b><?=$act['name']?></b></span>
					<?=character_limiter($act['description'], 210);?>
				 </div>
				<div class="bpv_line_bottom clearfix"></div>
			<?php endforeach;?>
		</div>
		
		<?php endif;?>
		
		
		<?php if(count($destination_travel) >0):?>
		<div class="group-name bpv-collapse margin-top-10" data-target="#destination_travel">
			<h3 class="heading">
           	 	<?=lang('destination_of_travel')?> <?=$tour_destination_detail['name']?>
              	<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
            </h3>
		</div>
		<div id="destination_travel">
			<?php foreach($destination_travel as $des_travel):?>
				<img class="pull-left" src="<?=get_image_path(DESTINATION, $des_travel['photo'], '120x90')?>"/>
				<div class="item-name pd-10"><a href="<?=get_url(TOUR_DESTINATION_DETAIL_PAGE, $des_travel);?>"> <?=$des_travel['name']?></a> </div>
				<?=$des_travel['description_short'];?>
				<div class="bpv_line_bottom clearfix"></div>
			<?php endforeach;?>
		</div>
		<?php endif;?>
	</div>
		
	<?php if($count_land_tour >0):?>
	<div class="destination margin-top-20">
		<h2 class="bpv-color-title margin-top-20"><?=lang('tour_in_destination')?> <?=$tour_destination_detail['name']?></h2>
		<div class="destination_tour">
			<?=$tour_land;?>
		</div>
	</div>
	<?php endif;?>
	
	<?php if($count_over_land_tour >0):?>
	<div class="destination margin-top">
		<h3><?=lang('tour_over_destination')?> <?=$tour_destination_detail['name']?></h3>
		<div class="destination_tour">
			<?=$tour_over_land;?>
		</div>
	</div>
	<?php endif;?>
 	
 	<?=$tour_contact?>
	<script>
		$('.group-name').bpvToggle();
		
		var gallery_load = new Loader();
	    gallery_load.require(
	    	<?=get_libary_asyn_js('flexsilder')?>, 
	      function() {
	    
	    		$('.flexslider').flexslider({
	    			animation: "slide",
	    			animationLoop: false,
	    			slideshow: false,   
	    		    controlNav: false
	    		  });
	    		
	    }); 
	</script>
</div>