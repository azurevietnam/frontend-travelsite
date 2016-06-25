<!DOCTYPE html>
<html lang="vi-vn">
	<head>
		
		<meta charset="utf-8">
    	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0" />
		
		<?php
			$page_meta = isset($meta) ? $meta : null;
			echo get_page_meta($page_meta); 
		?>
		
		<?php 
			$css = isset($lib_css) ? $lib_css : null;
			$js = isset($lib_js) ? $lib_js : null;
			$p_css = isset($page_css) ? $page_css : null;
			$p_js = isset($page_js) ? $page_js : null;
			echo get_core_theme($css, $js, $p_css, $p_js, true);
		?>
		
		<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.21082013.ico')?>"/>
	
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		
	    <!--[if lt IE 9]>
	    	<?=get_static_resources('html5shiv.js','libs/html5shiv/3.7.0/')?>
	      	<?=get_static_resources('respond.min.js','libs/respond.js/1.4.2/')?>
	    <![endif]-->
	    
	    <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-196981-20', 'auto');
		  ga('send', 'pageview');
		
		</script>
		
		<!-- FaceBooking Retargeting -->
		<script>(function() {
		var _fbq = window._fbq || (window._fbq = []);
		if (!_fbq.loaded) {
		var fbds = document.createElement('script');
		fbds.async = true;
		fbds.src = '//connect.facebook.net/en_US/fbds.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(fbds, s);
		_fbq.loaded = true;
		}
		_fbq.push(['addPixelId', '665370716926521']);
		})();
		window._fbq = window._fbq || [];
		window._fbq.push(['track', 'PixelInitialized', {}]);
		</script>
		<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=665370716926521&amp;ev=PixelInitialized" /></noscript>
		  
	</head>
	
	<body class="cbp-spmenu-push">
	    <nav class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-left" id="bpv-menu">
	    
	        <?php $mnu = get_selected_menu(MNU_HOME)?>
			<a <?=$mnu['class']?> href="<?=site_url()?>"><?=lang('mnu_home')?></a>
			
			<?php $mnu = get_selected_menu(MNU_HOTELS)?>
        	<a <?=$mnu['class']?> href="<?=site_url('khach-san')?>"><?=lang('mnu_hotels')?></a>
        	
        	<?php $mnu = get_selected_menu(MNU_FLIGHTS)?>
        	<a <?=$mnu['class']?> href="<?=site_url('ve-may-bay')?>"><?=lang('mnu_flights')?></a>
        	
        	<?php $mnu = get_selected_menu(MNU_TOURS)?>
        	<a <?=$mnu['class']?> href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a>
        	
        	<?php $mnu = get_selected_menu(MNU_DEALS)?>
        	<a <?=$mnu['class']?> href="<?=get_url(HOT_DEAL_PAGE)?>"><?=lang('mnu_deals')?></a>
        	
        	<?php $mnu = get_selected_menu(MNU_CRUISES)?>
        	<a <?=$mnu['class']?> href="<?=site_url(CRUISE_HL_HOME_PAGE)?>"><?=lang('mnu_cruises')?></a>
        	
        	<a href="<?=get_url(ABOUT_US_PAGE)?>"><?=lang('about_us')?></a>
        	<a href="<?=get_url(ACCOMPLISHMENT_PAGE)?>"><?=lang('mnu_accomplishment')?></a>
        	<a href="<?=get_url(TESTIMONIAL_PAGE)?>"><?=lang('mnu_testimonial')?></a>
        	<a href="<?=get_url(BESTPRICE_WITH_PRESS_PAGE)?>"><?=lang('mnu_bestprice_with_press')?></a>
        	<a href="<?=get_url(CONTACT_US_PAGE)?>"><?=lang('contact_us')?></a>
        	<a href="<?=get_url(FAQS_PAGE)?>"><?=lang('faqs')?></a>
        	<a href="<?=get_url(TERM_CONDITION_PAGE)?>"><?=lang('mnu_term_cond')?></a>
        	<a href="<?=get_url(PAYMENT_METHODS_PAGE)?>"><?=lang('payment_methods_page')?></a>
        	<a href="<?=get_url(NEWS_HOME_PAGE)?>"><?=lang('mnu_news')?></a>
		</nav>

		<?php $this->load->view('mobile/_layouts/header')?>
		
		<div class="bpv-content">
			<?=$bpv_content?>
		</div>
		
		<?php $this->load->view('mobile/_layouts/footer')?>

		<script>
		
		  <?php 
		  	$mnu = $this->session->userdata('MENU');
		  	$display_on = $mnu == MNU_FLIGHTS ? FLIGHT : HOTEL;
		  	if($mnu == MNU_CRUISES) $display_on = CRUISE;
		  ?>

		  $('#btnIconSearch').bpvToggle(function (data){
			  $(this).find('.icon').toggleClass( "icon-search-orange" );
		  });

		  function get_icon_search() {
			  if( $('.bpv-search').is(":visible")) {
				  $('#btnIconSearch').find('.icon').toggleClass( "icon-search-orange" );
			  }
		  }

		  get_icon_search();

		  var showLeftPush = document.getElementById( 'btn-menu-left' );

    	  showLeftPush.onclick = function() {
    		  $( document.body ).toggleClass( "cbp-spmenu-push-toright" );
    		  $( '#bpv-menu' ).toggleClass( "cbp-spmenu-open" );
    	  };
			
		  get_hot_line(<?=$display_on?>);
		</script>
		
		<!-- Google Code for Remarketing Tag -->
		
		<!-- 
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 1018666416;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1018666416/?value=0&amp;guid=ON&amp;script=0"/>
		</div>
		</noscript>
		 -->
</body>
</html>