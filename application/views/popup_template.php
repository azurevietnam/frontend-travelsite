<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml" style="background-color: white;">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="robots" content="noindex, nofollow" />		
		<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.ico')?>"/>	
		<!-- CSS -->
		<?=get_static_resources('main.min.051120141551.css');?>
		
		<?php if (isset($inc_css)) echo $inc_css;?>
		
		<?=get_static_resources('i18n/lang.'.lang_code().'.min.071120140940.js');?>

        <?=get_static_resources('jquery.js,jquery-ui-1.8.18.min.21092013.js,main.min.26112014.js');?>
        
        <?php if(lang_code() != 'en'):?>
		<?=get_static_resources('i18n/datepicker-'.lang_code().'.min.071120140938.js');?>
		<?php endif;?>
		
		<?php if (isset($inc_js)) echo $inc_js;?>

	</head>
	<body style="background-color: white;">
    	<div style="background-color: white;">           
            <div id="content">
            <?=$main?>
            </div>            
            <div style="clear: both;">&nbsp;</div>            
        </div>
		<script type="text/javascript">
			// google analytis
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-196981-6']);
			_gaq.push(['_trackPageview']);
			
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
				            				
		</script>
	<?php if (isset($time_exe)):?>
		<?php 
			echo "<!-- Time: ".$time_exe."-->";
		?>
	<?php endif;?>        
	</body>
</html>