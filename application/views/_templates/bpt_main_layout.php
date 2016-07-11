<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>

<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?=$page_meta['title']?></title>
		<base href="<?=site_url()?>" />
		<meta name="keywords" content="<?=$page_meta['keywords']?>" />
		<meta name="description" content="<?=$page_meta['description']?>" />
		<meta name="robots" content="<?=$page_meta['robots']?>" />
		<link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
		
		<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.png')?>"/>
		<?=$page_meta['canonical']?>
		<?=$page_theme?>
		
	</head>
	
	<body>
		<div class="bpt-header">
			<?=$bpt_header?>
		</div>
		
		<?php 
			$is_home_page = !empty($page) && $page == HOME_PAGE;
		?>
		
		<div class="bpt-content <?php if(!$is_home_page):?>container<?php endif;?>">
			<?=$bpt_content?>
		</div>
		
		<?=$bpt_footer?>		
	</body>
	
</html>