<nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="bpv-menu">
    <a <?=get_selected_menu("MNU_HOME")?> href="<?=site_url()?>"><?=lang('home')?></a>
    <a <?=get_selected_menu("MNU_VN_TOURS")?> href="<?=get_page_url(TOUR_HOME)?>"><?=lang('tour_home')?></a>
    <a <?=get_selected_menu("MNU_VN_FLIGHT")?> href="<?=get_page_url(FLIGHT_HOME)?>"><?=lang('mnu_vietnam_flights')?></a>
    <a <?=get_selected_menu("MNU_HOTELS")?> href="<?=get_page_url(HOTEL_HOME)?>"><?=lang('mnu_vietnam_hotels')?></a>
    <a <?=get_selected_menu("MNU_HALONG_CRUISES")?> href="<?=get_page_url(HALONG_BAY_CRUISES)?>"><?=lang('mnu_halongbaycruises')?></a>
    <a <?=get_selected_menu("MNU_MEKONG_CRUISES")?> href="<?=get_page_url(MEKONG_RIVER_CRUISES)?>"><?=lang('mnu_mekongrivercruises')?></a>
    <a <?=get_selected_menu("MNU_VN_VISA")?> href="<?=get_page_url(VIETNAM_VISA)?>"><?=lang('mnu_vietnam_visa')?></a>
    <a <?=get_selected_menu("MNU_FAQ")?> href="<?=get_page_url(FAQ)?>"><?=lang('mnu_faqs')?></a>
    <a <?=get_selected_menu("MNU_ABOUT_US")?> href="<?=get_page_url(ABOUT_US)?>"><?=lang('mnu_about_us')?></a>
	<a <?=get_selected_menu("MNU_CONTACT_US")?> href="<?=get_page_url(ABOUT_US . 'contact/')?>"><?=lang('mnu_contact_us')?></a>
</nav>

<div class="container bpv-header">
	<div class="row">
		<div class="col-xs-2">
			<button type="button" id="btn-menu-left">
		    	<span class="icon icon-menu"></span>
		    </button>
		</div>
		<div class="col-xs-7 padding-right-0">
			 <a class="bpv-logo" href="<?=site_url()?>">
			    <img src="<?=get_static_resources('/media/mobile/bestpricevn-m-logo.png')?>" width="160">
			</a>
		</div>
		<?php if(!empty($tour_search_form) || !empty($hotel_search_form) || !empty($search_form)):?>
		<div class="col-xs-3">
			<span>
				<button data-target=".bpv-search" id="btnIconSearch" type="button">
	                <span class="icon icon-search"></span>
		    	</button>
			</span>
			<span id="divCart" class="btnIconCart">
				
			</span>
		</div>
		<?php endif;?>
	</div>
</div>
<script type="text/javascript">
	initGUI();
</script>
