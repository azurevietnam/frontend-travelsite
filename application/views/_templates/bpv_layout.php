<!DOCTYPE html>
<html lang="vi-vn">
	<head>
		<?php
			$page_meta = isset($meta) ? $meta : null;
			echo get_page_meta($page_meta); 
		?>
		
		<?php 
			$css = isset($lib_css) ? $lib_css : null;
			$js = isset($lib_js) ? $lib_js : null;
			$p_css = isset($page_css) ? $page_css : null;
			$p_js = isset($page_js) ? $page_js : null;
			echo get_core_theme($css, $js, $p_css, $p_js);
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
	
	<body>

		<?php $this->load->view('_layouts/header')?>
		
		<div class="bpv-content">
			<?=$bpv_content?>
		</div>
		
		<?php $this->load->view('_layouts/footer')?>
		
		<div id="hotline_popup_area"></div>
		<div id="contact_popup_area"></div>
		<div id="sign_up_area"></div>
		<div id="sign_in_area"></div>
		
	<script>

		  <?php if(!isset($ads_grateful_week_page)):?>
		  get_marketing_popup();
          <?php endif;?>
			
		  $('.quick-contact').on('click', function (e) {
				$('.quick-contact').not(this).popover('hide');
		  });

		  <?php 
		  	$mnu = $this->session->userdata('MENU');
		  	$display_on = $mnu == MNU_FLIGHTS ? FLIGHT : HOTEL;
		  	if($mnu == MNU_CRUISES) $display_on = CRUISE;
		  ?>
			
		  get_hot_line(<?=$display_on?>);
		  get_hotline_support_popup('#hotline_popup_area');
		  get_quick_contact_popup('#contact_popup_area');
		  get_sign_up_popup('#sign_up_area');
		  get_sign_in_popup('#sign_in_area');
	</script>
	
	<!-- Google Code for Remarketing Tag -->
	
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
	
</body>
</html>