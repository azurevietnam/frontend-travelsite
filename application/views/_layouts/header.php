<div class="bpv-header">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<a href="<?=site_url()?>"><img class="bpv-logo" src="<?=get_static_resources('/media/bestpricevn-logo.31052014.png')?>"></a>
			</div>
			<div class="col-xs-8">
				<div class="hotline">
					<ul class="list-unstyled pull-right sub_menu">
						<li>
							<a href="<?=get_url(ABOUT_US_PAGE)?>"><?=lang('about_us_top')?></a>
								<span class="border">|</span>
							<?php
								$user = $this->session->userdata(LOGIN_USER);
							?>
							<?php
								if($user==false) {
							?>
		                	<a href="javascript:void(0)" class="quick-contact" id="btn_sign_in"><?=lang('sign_in')?></a>
								
								<span class="border">|</span>
								
		                	<a href="javascript:void(0)" class="quick-contact" id="btn_sign_up"><?=lang('register')?></a>
							<?php
								}else{
							?>
							<a href="javascript:void(0)" class="quick-contact" id="sign_in"><?=$user["email"];?></a>
								
								<span class="border">|</span>
								
							<a href="javascript:void(0)" class="quick-contact" id="sign_out" onclick="sign_out_request()" >Thoát</a>
							
							<?php
								}
							?>
		                	<a class="social" target="_blank" href="https://www.facebook.com/BestPricevn" style="padding-left: 0">
			            		<span class="icon icon-facebook-hd"></span>
			            	</a>
			            	<a class="social" target="_blank" href="https://twitter.com/bestprice_vn">
			            		<span class="icon icon-twitter-hd"></span>
			            	</a>
			            	<a class="social" target="_blank" href="http://www.pinterest.com/bestpricedulich/">
			            		<span class="icon icon-pinterest-hd"></span>
			            	</a>
			            	<a class="social" target="_blank" href="https://plus.google.com/u/1/+Bestpricevn/posts">
			            		<span class="icon icon-google-plus-hd"></span>
			            	</a>
			            	<a class="social" href="http://www.pata.org/Members/7902">
			            	    <span class="icon icon-pata"></span>
			            	</a>
		                </li>
		                <li class="sub_menu_2">
		                	<a href="javascript:void(0)" class="border_r bpv-color-title quick-contact" id="btn_groupon">
		                		<span class="icon icon-groupon-sm"></span>
		                		<?=lang('groupon')?>
		                		<span class="icon icon-arrow-down-sm"></span>
		                	</a>
		                	<a href="javascript:void(0)" class="bpv-color-title quick-contact" id="btn_contact_popup">
		                		<?=lang('contact_us')?>
		                		<span class="icon icon-arrow-down-sm"></span>
		                	</a>
		                	<span id="bpv_support_popup" class="icon icon-btn-support pull-right btn-support quick-contact"></span>
		                </li>
	                </ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="bpv-header-secondary">
	<div class="container">
		<div class="row">
			<div class="col-xs-8 pd-right-0">
				<ul class="nav nav-pills">
					<?php $mnu = get_selected_menu(MNU_HOME)?>
		        	<li <?=$mnu['class']?>>
				        <a href="<?=site_url()?>"><span class="icon icon-home"></span> <?=lang('mnu_home')?></a>
		          	</li>
		          	<?php $mnu = get_selected_menu(MNU_HOTELS)?>
		          	<li <?=$mnu['class']?>>
			          	<a href="<?=site_url('khach-san')?>/"><span class="icon icon-hotel"></span> <?=lang('mnu_hotels')?></a>
		          	</li>
		          	<?php $mnu = get_selected_menu(MNU_FLIGHTS)?>
		          	<li <?=$mnu['class']?>>
			          	<a href="<?=site_url('ve-may-bay')?>/"><span class="icon icon-flight-up"></span> <?=lang('mnu_flights')?></a>
		          	</li>     	
		          	
		          	<?php $mnu = get_selected_menu(MNU_TOURS)?>
		          	<li <?=$mnu['class']?>>
			          	<a href="<?=get_url(TOUR_HOME_PAGE)?>/"><span class="icon icon-tour"></span> <?=lang('mnu_tours')?></a>
		          	</li>
		          	
		          	<?php $mnu = get_selected_menu(MNU_DEALS)?>
		          	<li <?=$mnu['class']?>>
			          	<a href="<?=get_url(HOT_DEAL_PAGE)?>/" id="mnu-deal"><span class="icon icon-deal"></span> <span class="bpv-color-hot-deal"><?=lang('mnu_deals')?></span></a>
		          	</li>
		          	
		          	<?php $mnu = get_selected_menu(MNU_CRUISES)?>
		          	<li <?=$mnu['class']?>>
			          	<a href="<?=site_url(CRUISE_HL_HOME_PAGE)?>/"><span class="icon icon-cruise"></span> <?=lang('mnu_cruises')?></a>
		          	</li>
		        </ul>
			</div>
			<div class="col-xs-4 hot-line pd-left-0">
				<label class="bpv-color-title" id="hd_phone">
					<span class="icon icon-telephone"></span>
					<?=load_phone_support()?>
				</label>
				<label class="bpv-color-price" id="hd_hotline">
					
				</label>
			</div>
		</div>
	</div>
</div>