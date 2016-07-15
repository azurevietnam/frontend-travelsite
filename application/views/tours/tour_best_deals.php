<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<link rel="stylesheet" type="text/css" href="<?=site_url()?>/js/lofslidernews/css/style6.min.css" />	
<script language="javascript" type="text/javascript" src="<?=site_url()?>/js/lofslidernews/js/jquery.easing.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=site_url()?>/js/lofslidernews/js/script.min.js"></script>
<script type="text/javascript">	
$(document).ready( function(){	
		var buttons = { previous:$('#lofslidecontent45 .lof-previous') ,
						next:$('#lofslidecontent45 .lof-next') };
						
		$obj = $('#lofslidecontent45').lofJSidernews( { interval : 7000,
												direction		: 'opacity',	
											 	easing			: 'easeOutBounce',
												duration		: 1000,
												auto		 	: true,
												mainWidth		: 240,
												buttons			: buttons} );	
	});
</script>

<style type="text/css">
	.lof-main-item-desc{
		height:60px;
		padding:5px;
	}
	
	.lof-main-item-desc p{
		margin:0 4px;
		padding:4px 0;
		clear: both;
	}
</style>

    
<!------------------------------------- THE CONTENT ------------------------------------------------->
<div id="lofslidecontent45" class="lof-slidecontent" style="width:240px; height:165px;">
<div class="preload"><div></div></div>
 <!-- MAIN CONTENT --> 
  <div class="lof-main-outer" style="width:240px; height:165px;">
  	<div onclick="return false" href="" class="lof-previous">Previous</div>
  	<ul class="lof-main-wapper lof-opacity">
  	
  		<?php foreach ($best_deals as $value):?>  				
  			<li style="opacity: 0;">
        		   
        		<?php if($value['object_type'] == CRUISE):?>
        			
        			<img width="240" height="165" alt="<?=$value['object_name']?>" src="<?=site_url($this->config->item('cruise_medium_path')).$value['picture']?>"></img>
        			
        		<?php elseif($value['object_type'] == HOTEL):?>
        			
        			<img width="240" height="165" alt="<?=$value['object_name']?>" src="<?=site_url($this->config->item('hotel_medium_path')).$value['picture']?>"></img>
        			
        		<?php elseif($value['object_type'] == TOUR):?>
        			
        			<img width="240" height="165" alt="<?=$value['object_name']?>" src="<?=site_url($this->config->item('tour_medium_path')).$value['picture']?>"></img>        			
        			
        		<?php endif;?>
        		       
                 <div style="display: none;" class="lof-main-item-desc">
                 	<?php if($value['object_type'] == CRUISE):?>
        					
        				<h2><a href="<?=url_builder(CRUISE_DETAIL, url_title($value['object_name']), true)?>"><?=$value['object_name']?></a></h2>
        			
	        		<?php elseif($value['object_type'] == HOTEL):?>
	        			
	        			<h2><a href="<?=url_builder(HOTEL_DETAIL, url_title($value['object_name']), true)?>"><?=$value['object_name']?></a></h2>
	        			
	        		<?php elseif($value['object_type'] == TOUR):?>
	        			
	        			<h2><a href="<?=url_builder(TOUR_DETAIL, url_title($value['object_name']), true)?>"><?=$value['object_name']?></a></h2>
	        			
	        		<?php endif;?>
        		               
	                <p>
	                	<?=$value['description']?>
	                </p>
             	</div>
        	</li> 	
  				
  				
  		<?php endforeach;?> 		
      </ul> 
      <div onclick="return false" href="" class="lof-next">Next</div>	
  </div>
  <!-- END MAIN CONTENT --> 
    <!-- NAVIGATOR -->

  <!----------------- --------------------->
 </div> 



