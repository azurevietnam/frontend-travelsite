<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?=$metas['title']?></title>
		<base href="<?=site_url()?>" />
		<meta name="keywords" content="<?=$metas['keywords']?>" />
		<meta name="description" content="<?=$metas['description']?>" />
		<meta name="robots" content="<?=$metas['robots']?>" />
				
		<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.png')?>"/>
		<?php if(has_mobile_version_page()):?>
		<link rel="alternate" media="only screen and (max-width: 640px)" href="<?=get_mobile_url()?>" />
		<link rel="alternate" media="handheld" href="<?=get_mobile_url()?>" />
		<?php endif;?>
		
		<?php if (isset($tour_canonical)) echo $tour_canonical;?>
		
		<?php if (isset($cruise_review_canonical)) echo $cruise_review_canonical;?>

		<?=get_static_resources('main.min.03022015.css');?>
		
		<?php if (isset($inc_css)) echo $inc_css;?>
		
		<?=get_static_resources('i18n/lang.'.lang_code().'.js');?>
		
		<?=get_static_resources('jquery.js,jquery-ui-1.8.18.min.21092013.js,main.min.03022015.js');?>
		
		<?php if(lang_code() != 'en'):?>
		<?=get_static_resources('i18n/datepicker-'.lang_code().'.min.071120140938.js');?>
		<?php endif;?>
		
		<?php if (isset($inc_js)) echo $inc_js;?>
		
		
	</head>
	<body>
		
    	<div id="wrapper">
            <div id="header">
            	<a id="logo" href="<?=site_url()?>"><img width="230" height="60" src="<?=get_static_resources('/media/logo.png')?>" alt="<?=lang('home_title')?>"></img></a>
            	 
            	 <?php if(!check_prevent_promotion()):?>
	       		 <div class="top-ads" id="top-ads">
	       		 	<?php $ads_campaigns = getAds()?>
	       		 	<?php foreach ($ads_campaigns as $campaign):?>
	       		 		<?php foreach ($campaign['images'] as $image):?>
						<a href="<?=$campaign['url']?>" rel="nofollow">
							<img width="260" height="56" src="<?=get_static_resources('/media/ads/'.$image)?>"></img>
						</a>
						<?php endforeach;?>
				<?php endforeach;?>
		         </div>
		         
		         <?php endif;?>
                <div id="sub_menu">
                	<a title="<?=lang_arg('mnu_title_about_us', SITE_NAME)?>" href="<?=url_builder('',ABOUT_US)?>"><?=lang('mnu_about_us')?></a>
                	<a title="<?=lang_arg('mnu_title_contact_us', SITE_NAME)?>" href="<?=url_builder('',ABOUT_US . 'contact/')?>"><?=lang('mnu_contact_us')?></a>
                	<a title="<?=lang('mnu_title_faqs')?>" href="<?=url_builder('',FAQ)?>"><?=lang('mnu_faqs')?></a>
                	<a target="_blank" rel="nofollow" href="http://www.facebook.com/BestPriceTravel" class="social"><span class="icon icon-facebook"></span></a>
                	<a target="_blank" rel="nofollow" href="http://twitter.com/Bestpricevn" class="social"><span class="icon icon-twitter"></span></a>
					<a target="_blank" rel="nofollow" href="https://plus.google.com/u/1/b/101366490486405905702/101366490486405905702/posts" class="social"><span class="icon icon-google-plus"></span></a>
					<a target="_blank" rel="nofollow" href="http://www.patamanager.org/Members/7902" class="social"><span class="icon icon-pata"></span></a>
					<a target="_blank" rel="nofollow" href="http://www.tripadvisor.com/Attraction_Review-g293924-d4869921-Reviews-Best_Price_Vietnam_Private_Day_Tour-Hanoi.html" class="social"><span class="icon icon-tripadvisor"></span></a>
                </div>
                
                <div id="call_us">
                	<div class="number">
                		<span class="icon phone_icon"></span>
                		<label>+84 436-249-007</label>
                		<span class="notes"><?=lang('label_working_time')?></span>
                	</div>
                	<div class="ict">
                	<?=lang('label_hotline')?>:<label> +84 904-699-428</label> / 
                	<?=lang('label_email')?>: <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a>
                	</div>
                </div>
          	</div>
            <div id="menues">
            	<ul>
            		<li id="MNU_HOME" <?=get_selected_menu("MNU_HOME")?>><a title="<?=lang('home_title')?>" href="<?=site_url()?>"><?=lang('home')?></a></li>
            		
            		
            		<li id="MNU_VN_TOURS" <?=get_selected_menu("MNU_VN_TOURS")?>><a title="<?=lang('tours_title')?>" href="<?=url_builder('',TOUR_HOME)?>"><?=lang('tour_home')?></a></li>    
            		
            		
            		<li id="MNU_FLIGHTS" <?=get_selected_menu("MNU_VN_FLIGHT")?>><a title="<?=lang('flights_title')?>" href="<?=url_builder('',FLIGHT_HOME)?>"><?=lang('mnu_vietnam_flights')?></a></li>
            		<li id="MNU_HOTELS" <?=get_selected_menu("MNU_HOTELS")?>><a title="<?=lang('hotels_title')?>" href="<?=url_builder('',HOTEL_HOME)?>"><?=lang('mnu_vietnam_hotels')?></a></li>
            		
            		<li id="MNU_HALONG_CRUISES" <?=get_selected_menu("MNU_HALONG_CRUISES")?>><a title="<?=lang('halongbaycruises_title')?>" href="<?=url_builder('',HALONG_BAY_CRUISES)?>"><?=lang('mnu_halongbaycruises')?></a></li>
            		<li id="MNU_MEKONG_CRUISES" <?=get_selected_menu("MNU_MEKONG_CRUISES")?>><a title="<?=lang('mekongrivercruises_title')?>" href="<?=url_builder('',MEKONG_RIVER_CRUISES)?>"><?=lang('mnu_mekongrivercruises')?></a></li> 
            		
            		<li id="MNU_DEAL_OFFER" <?=get_selected_menu("MNU_DEAL_OFFER")?>><a title="<?=lang('deals_title')?>" href="<?=url_builder('',DEALS)?>"><?=lang('mnu_deals_offers')?></a></li> 
            		<li id="MNU_VN_VISA" <?=get_selected_menu("MNU_VN_VISA")?>><a title="<?=lang('visa_title')?>" href="<?=url_builder('',VIETNAM_VISA)?>"><?=lang('mnu_vietnam_visa')?></a></li>
				</ul>
            </div>
            <div id="navigation">
            	<div class="content"><?=$navigation?></div> 
            	<?php if(!isset($NO_CART)):?>           	
            	<div id="divCart"></div>
            	<?php endif;?>
            </div>
            <div id="content">
	            <?=$main?>
            </div>
            
            <div style="clear:both;height:50px">&nbsp;</div>
             
            <div id="footer" class="grayBox">
            	<div class="bpvLinks">
            		<span class="item_highlight"><?=BRANCH_NAME?>., JSC</span>
            		<ul id="about_bpt">
            		    <li><a title="<?=lang_arg('mnu_title_about_us', SITE_NAME)?>" href="<?=url_builder('',ABOUT_US)?>"><?=lang('mnu_about_us')?></a></li>
                    	<li><a title="<?=lang_arg('mnu_title_contact_us', SITE_NAME)?>" href="<?=url_builder('',ABOUT_US . 'contact/')?>"><?=lang('mnu_contact_us')?></a></li>
                    	<li><a title="<?=lang('mnu_title_faqs')?>" href="<?=url_builder('',FAQ)?>"><?=lang('mnu_faqs')?></a></li>           			
            		</ul>
            		<ul>
            			<li><a rel="nofollow" href="/policy/"><?=lang('mnu_terms_conditions')?></a></li>
            			<li><a rel="nofollow" href="/policy/privacy/"><?=lang('mnu_privacy_statement')?></a></li>
            			<li><a rel="nofollow" href="/partners/"><?=lang('mnu_partners')?></a></li>
            		</ul>       			
            	</div>
                <div class="com_info">
                	<div class="follow-us">
                		<div class="floatL" style="width: 220px">
	                		<div class="floatL">
	                			<label><?=lang('label_follow_us')?></label>
		                		<span>
		                			<a target="_blank" rel="nofollow" href="http://www.facebook.com/BestPriceTravel" class="social"><span class="icon icon-facebook"></span></a>
		                			<a target="_blank" rel="nofollow" href="http://twitter.com/Bestpricevn" class="social"><span class="icon icon-twitter"></span></a>
									<a target="_blank" rel="nofollow" href="http://pinterest.com/bestpricevn" class="social"><span class="icon icon-pinterest"></span></a>
									<a target="_blank" rel="nofollow" href="https://plus.google.com/u/1/b/101366490486405905702/101366490486405905702/posts" class="social"><span class="icon icon-google-plus"></span></a>
									<a target="_blank" rel="nofollow" href="http://www.linkedin.com/company/3113952?trk=tyah" class="social"><span class="icon icon-linkedin"></span></a>
		                		</span>
	                		</div>
	                		<div class="floatL clearfix tripadvisor">
	                			<span><img src="<?=get_static_resources('/media/vietnamtourism.14082014.png')?>"></span>
	                		</div>
                		</div>
                		
						<div class="ourMembers">
	            			<ul>
								<li class="org_member"><a target="_blank" rel="nofollow" href="http://www.patamanager.org/Members/7902"><?=lang('label_member_of_pata')?></a></li>
								<li><a target="_blank" rel="nofollow" href="http://www.patamanager.org/Members/7902" rel="nofollow"><img width="84" height="40" src="<?=get_static_resources('/media/pata-logo.png')?>"></a></li>
							</ul>
							 
							<ul>
								<li class="org_member"><a target="_blank" rel="nofollow" href="https://sealsplash.geotrust.com/splash?&dn=www.bestpricevn.com"><?=lang('label_secure_protected')?></a></li>
								<li class="geotrust">
									<table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose GeoTrust SSL for secure e-commerce and confidential communications.">
                                    <tr>
                                    <td width="135" align="center" valign="top"><script type="text/javascript" src="https://seal.geotrust.com/getgeotrustsslseal?host_name=www.bestpricevn.com&amp;size=S&amp;lang=en"></script><br />
                                    <a href="http://www.geotrust.com/ssl/" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;"></a></td>
                                    </tr>
                                    </table>
								</li>
							</ul>
	            		</div>
                	</div>
            		<div class="payments-method">
            			<label><?=lang('label_we_accept')?></label>
            			<img src="<?=get_static_resources('/media/payments.png')?>"></img>
            		</div>
            	</div>

				<div class="com_profile">
					<div id="TA_certificateOfExcellence138" class="TA_certificateOfExcellence">
                    <ul id="svdsXcI" class="TA_links 1qck3rRmN">
                    <li id="JtTDpF61" class="7zoflXULa">
                    <a target="_blank" href="http://www.tripadvisor.com/Attraction_Review-g293924-d4869921-Reviews-Best_Price_Vietnam_Private_Day_Tour-Hanoi.html"><img src="http://www.tripadvisor.com/img/cdsi/img2/awards/CoE2015_WidgetAsset-14348-2.png" alt="TripAdvisor" class="widCOEImg" id="CDSWIDCOELOGO"/></a>
                    </li>
                    </ul>
                    </div>
                    <script src="http://www.jscache.com/wejs?wtype=certificateOfExcellence&amp;uniq=138&amp;locationId=4869921&amp;lang=en_US&amp;year=2015&amp;display_version=2"></script>					
				</div>
				<div class="office_address">
				    <p style="margin: 10px 0 0"><b><a href="/aboutus/registration/"><?=lang('label_international_tour_operator_license')?></a></b> <?=lang('label_international_tour_operator_license_no')?></p>
				    
				    <div style="float: left; width: 50%">
				        <div class="officeHN">
    				        <b><?=lang('label_hanoi_office')?>:</b><br>
    				        <span style="margin-right: 5px; font-size: 11px"><?=lang('hanoi_office_address')?></span>
    							<a style="text-decoration: underline;" href="javascript:void(0)"
    								onclick="javascript:window.open('/aboutus/company_address/', '_blank','width=800,height=600')"><?=lang('label_view_maps')?> &raquo;</a>
    				    </div>
    				    
    				    <div class="officeHN">
    						<b><?=lang('label_ho_chi_minh_office')?>:</b><br>
    						<span style="font-size: 11px"><?=lang('hcm_office_address')?></span>
    					</div>
    					
    					<div class="officeHN">
    						<b><?=lang('label_siem_reap_office')?>:</b><br>
    						<span style="font-size: 11px"><?=lang('siem_reap_office_address')?></span>
    					</div>
				    </div>
				    <div style="float: left; width: 50%">
				        <div class="officeHN">
    						<b><?=lang('label_phnom_penh_office')?>:</b><br>
    						<span style="font-size: 11px"><?=lang('phnom_penh_office_address')?></span>
    					</div>
    					
    					<div class="officeHN">
    						<b><?=lang('label_myanmar_office')?>:</b><br>
    						<span style="font-size: 11px"><?=lang('myanmar_office_address')?></span>
    					</div>
    					
    					<div class="officeHN">
    						<b><?=lang('label_laos_office')?>:</b><br>
    						<span style="font-size: 11px"><?=lang('laos_office_address')?></span>
    					</div>
				    </div>
				</div>
				<div class="copyright">
					<div><?=lang_arg('label_copyright', date('Y'), SITE_NAME)?></div>
					<div style="text-align: right;"><?=lang('label_call_us')?> <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a></div>
				</div>
				<div class="clearfix" style="height: 5px"></div>
       		 </div>
       	</div>
       	
		<script type="text/javascript">

			<?php if(isset($GLOBAL_DATAS) && $GLOBAL_DATAS != ''):?>				
				var GLOBALS = <?=$GLOBAL_DATAS?>;		
			<?php endif;?>
				
			var base_url = "";
			var site_url = "<?=site_url()?>";

			initGUI();
		</script>
	<?php if (isset($time_exe)):?>
		<?php 
			echo "<!-- Time: ".$time_exe."-->";
		?>
	<?php endif;?>        
	</body>
</html>