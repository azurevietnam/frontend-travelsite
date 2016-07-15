<div class="bpt-headers bpt-header-border-top bpt-header-border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-xs-2 navbar-header">
				<a id="logo" class="navbar-brand" href="<?=site_url()?>"><img src="../media/logo.png" alt="<?=lang('home_title')?>"></img></a>
			</div>
			<div class="col-xs-10 navbar-header">
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
                    <img class="img-responsive" src="../media/banner/paris.jpg">
                </a>
            </li>
            <li>
                <a href="#">
                    <img class="img-responsive" src="../media/banner/rome.jpg">
                </a>
            </li>
            <li>
                <a href="#">
                    <img class="img-responsive" src="../media/banner/santorini.jpg">
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


<script type="text/javascript">
	initGUI();
</script>
