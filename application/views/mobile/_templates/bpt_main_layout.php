<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, maximum-scale=1.0" />
		
		<title><?=$page_meta['title']?></title>
		
		<base href="<?=site_url()?>" />
		<meta name="keywords" content="<?=$page_meta['keywords']?>" />
		<meta name="description" content="<?=$page_meta['description']?>" />
		<meta name="robots" content="<?=$page_meta['robots']?>" />
		
		<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.21082013.ico')?>"/>
		<?=$page_meta['canonical']?>
		<?=$page_theme?>
	</head>
	<body class="cbp-spmenu-push">
		<?=$bpt_header?>
		
		<?php if(!empty($tour_search_form) || !empty($hotel_search_form) || !empty($search_form)):?>
		<div class="container">
            <div class="bpv-search">
                <?=!empty($tour_search_form) ? $tour_search_form : ''?>
                <?=!empty($hotel_search_form) ? $hotel_search_form : ''?>
                <?=!empty($search_form) ? $search_form : ''?>
            </div>
        </div>
        <?php endif;?>

		<div class="bpv-content">
            <?=!empty($common_ad) ? $common_ad : ''?>
            
			<?=$bpt_content?>
		</div>
		
		<?=$bpt_footer?>
		
        <script>
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
            
            // google analytics
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-196981-6']);
            _gaq.push(['_trackPageview']);
            
            (function() {
            	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
</body>
</html>