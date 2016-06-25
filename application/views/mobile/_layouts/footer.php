<div class="container bpv-footer">
	<div class="row bpv-footer-links">
		<div class="col-xs-6">
			<ul>
				<li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
				<li><a href="<?=site_url('ve-may-bay')?>"><?=lang('mnu_flights')?></a></li>
				<li><a href="<?=get_url(ABOUT_US_PAGE)?>"><?=lang('about_us')?></a></li>
				<li><a href="<?=get_url(FAQS_PAGE)?>"><?=lang('faqs')?></a></li>
				<li><a href="<?=get_url(PRIVACY_PAGE)?>"><?=lang('privacy_statement_short')?></a></li>
				<li class="no-border"><a href="<?=get_url(NEWS_HOME_PAGE)?>"><?=lang('mnu_news')?></a></li>
			</ul>
		</div>
		<div class="col-xs-6">
			<ul>
				<li><a href="<?=site_url('khach-san')?>"><?=lang('mnu_hotels')?></a></li>
				<li><a href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
				<li><a href="<?=site_url(CRUISE_HL_HOME_PAGE)?>"><?=lang('mnu_cruises')?></a></li>
				<li><a href="<?=get_url(CONTACT_US_PAGE)?>"><?=lang('contact_us')?></a></li>
				<li><a href="<?=get_url(TERM_CONDITION_PAGE)?>"><?=lang('term_and_conditions_short')?></a></li>
				<li class="no-border"><a href="<?=get_url(PAYMENT_METHODS_PAGE)?>"><?=lang('payment_methods_page')?></a></li>
			</ul>
		</div>
	</div>
	<div class="bpv-address text-center">
		<p class="company-name text-left">
			<b><?=lang('company_name')?></b>
		</p>
		<p class="company-address text-left"><span><?=lang('tour_operator_no')?></span></p>
		<p class="company-address text-left">
    		<span>
    		<a href="<?=get_url(ABOUT_US_PAGE)?>"><b><?=lang('tour_operator_license')?></b></a>
    		<?=lang('tour_operator_license_granted_by')?></span>
		</p>
		<p class="company-address text-left">
			<b><?=lang('company_address_label')?></b><span><?=lang('company_address')?></span>
		</p>
		<p>
			<a class="company-map" href="javascript:void(0)"
				onclick="javascript:window.open('<?=get_url(COMPANY_ADDRESS_PAGE)?>', '_blank','width=800,height=600')">
			<span class="icon icon-marker margin-right-5"></span><?=lang('view_map')?>
			</a>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_hcm_address_label')?></b> <span><?=lang('company_hcm_address')?></span>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_haiduong_address_label')?></b> <span><?=lang('company_haiduong_address')?></span>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_haiphong_address_label')?></b> <span><?=lang('company_haiphong_address')?></span>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_singapore_address_label')?></b> <span><?=lang('company_singapore_address')?></span>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_korea_address_label')?></b> <span><?=lang('company_korea_address')?></span>
		</p>
		<p class="company-address text-left">
		     <b><?=lang('company_japan_address_label')?></b> <span><?=lang('company_japan_address')?></span>
		</p>
		<p class="margin-bottom-20">
			<a id="sd_hotline_tel_link" class="btn-call" href="tel:<?=load_phone_support()?>"><span class="icon icon-phone"></span> <span id="hd_phone"><?=load_phone_support()?></span></a>
			<br><br>
			<a id="hd_hotline_tel_link" class="btn-call" href="tel:<?=load_phone_support()?>"><span class="icon icon-phone"></span> <span id="hd_hotline"><?=load_phone_support()?></span></a>		
		</p>
		<p>
		    <a class="social" target="_blank" rel="nofollow" href="https://www.facebook.com/BestPricevn"><span class="icon icon-facebook-hd"></span></a>
        	<a class="social" target="_blank" rel="nofollow" href="https://twitter.com/bestprice_vn"><span class="icon icon-twitter-hd"></span></a>
        	<a class="social" target="_blank" rel="nofollow" href="http://www.pinterest.com/bestpricedulich/"><span class="icon icon-pinterest-hd"></span></a>
        	<a class="social" target="_blank" rel="nofollow" href="https://plus.google.com/u/1/b/104363857518456717813/104363857518456717813/posts"><span class="icon icon-google-plus-hd"></span></a>
		    <a class="social" target="_blank" rel="nofollow" href="http://www.pata.org/Members/7902"><span class="icon icon-pata"></span></a>
		    <a target="_bank" rel="nofollow" href="http://online.gov.vn/HomePage/WebsiteDisplay.aspx?DocId=8179">
            <img width="74" height="48" alt="" title="" src="http://online.gov.vn/seals/KAdraI+ZP9fwVL3Uryb1cw==.jpgx"/>
            </a>
		</p>
		<p>
		    <a href="<?=site_url()?>?mobile=off"><?=lang('desktop_version')?></a>
		</p>
	</div>
</div>