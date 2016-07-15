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
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type='text/css'>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" type='text/css'>
		
		<link href='http://titanicthemes.com/demo/travel/blue/dist/js/bootstrap.min.js' rel='stylesheet' type='text/css'>
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
		<div class="bpt-content">
		<div class="container">
				<?php if(!empty($page_navigation)):?>
					<div class="padding-left-10"><?=$page_navigation?></div>
				<?php endif;?>
				<?php if(!empty($main_header_title)):?>
					<div class="padding-left-10"><?=$main_header_title?></div>
				<?php endif;?>
				</div>
			<div class=" <?php if(!$is_home_page):?>container  content-inner<?php endif;?>">
				<div class="row">
				<?=$bpt_content?>
				</div>
		</div>
		
		<?=$bpt_footer?>		
	</body>
	
</html>