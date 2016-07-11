<div class="bpt-header bpt-header-border-top bpt-header-border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				<a id="logo" href="<?=site_url()?>"><img src="../media/logo.png" alt="<?=lang('home_title')?>"></img></a>
			</div>
			<div class="col-xs-9">
				<ul id="bpt-menu" class="nav bpt-header-menu">
				<li id="MNU_HOME" <?=get_selected_menu("MNU_HOME")?>><a class="social" title="<?=lang('home_title')?>" href="<?=site_url()?>"><?=lang('home')?></a></li>
		        
		        <li id="MNU_VN_TOURS" <?=get_selected_menu("MNU_VN_TOURS")?>><a title="<?=lang('tours_title')?>" href="<?=get_page_url(TOUR_HOME)?>"><?=lang('tour_home')?></a></li>    
		            
				<li id="MNU_HOTELS" <?=get_selected_menu("MNU_HOTELS")?>><a title="<?=lang('hotels_title')?>" href="<?=get_page_url(HOTEL_HOME)?>"><?=lang('mnu_vietnam_hotels')?></a></li>
		            		
				<li id="MNU_HALONG_CRUISES" <?=get_selected_menu("MNU_HALONG_CRUISES")?>><a title="<?=lang('halongbaycruises_title')?>" href="<?=get_page_url(HALONG_BAY_CRUISES)?>"><?=lang('mnu_halongbaycruises')?></a></li>
		            
				<li id="MNU_MEKONG_CRUISES" <?=get_selected_menu("MNU_MEKONG_CRUISES")?>><a title="<?=lang('mekongrivercruises_title')?>" href="<?=get_page_url(MEKONG_RIVER_CRUISES)?>"><?=lang('mnu_mekongrivercruises')?></a></li> 
		            		
				<li id="MNU_DEAL_OFFER" <?=get_selected_menu("MNU_DEAL_OFFER")?>><a title="<?=lang('deals_title')?>" href="<?=get_page_url(DEALS)?>"><?=lang('mnu_deals_offers')?></a></li> 
		    
			</ul>
			</div>
		</div>
	</div>
</div>
<div class="flexslider">
    	<ul class="slides" style="height:auto">
            <li>
                <a href="#">
                    <img class="img-responsive" src="../media/ad1.jpg">
                </a>
            </li>
            <li>
                <a href="#">
                    <img class="img-responsive" src="../media/ad2.jpg">
                </a>
            </li>

	    </ul>
	</div>

	<script type="text/javascript">

	    var cal_load = new Loader();
	    cal_load.require(
	        <?=get_libary_asyn('flexslider')?>,
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

<div class="container">
	<?php if(!empty($page_navigation)):?>
		<div class="padding-left-10"><?=$page_navigation?></div>
	<?php endif;?>
	<?php if(!empty($main_header_title)):?>
		<div class="padding-left-10"><?=$main_header_title?></div>
	<?php endif;?>	
</div>

<script type="text/javascript">
	initGUI();
</script>
