<h2 class="text-special margin-top-15"><span class="icon icon-best-seller margin-right-5"></span><?=lang('best_seller')?></h2>
<div class="row best-seller-container" id="best-seller-container">
<?php if (empty($tour[0]['route_highlight']) && empty($cruise_halong[0]['route_highlight']) && empty($cruise_mekong[0]['route_highlight']))  {$check_router_highlight = false;} ?>
<?php if (!empty($tour)):?>
	<div class="col-xs-6 best-seller margin-bottom-10 tour-ids" data-id="<?=$tour[0]['id']?>">
	    <div class="text-headder"> <?=lang('vietnam_tour')?> </div>
	   	<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour[0])?>">
	   		<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $tour[0]['picture'], '375_250')?>" alt="<?=$tour[0]['name']?>">
	    </a>
	    <div class="best-seller-content">
	        <div class="best-seller-name">
				<div class="col-xs-6 text-left">
					<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour[0])?>"><?=$tour[0]['name']?></a>
				</div>
	            <div class="col-xs-6 text-right">
	                <span class="text-unhighlight"><?=lang('from')?>: </span> 
	                <span class="text-price"><?=lang('lbl_us')?></span>
	                <!-- <span class="price-origin t-origin-<?//=$tour[0]['id']?>"></span>  --> 
	                <span class="price-from t-from-<?=$tour[0]['id']?>"><?=lang('na')?></span><?=lang('per_pax')?>
	            </div>
	        </div>
	        
	        <div class="clearfix text-unhighlight best-seller-router" <?php isset($check_router_highlight) ? print('display: none;') : ''?>">
	        <?php if(!empty($tour[0]['route_highlight'])):?>
	       		<?php 
		       		$icon = '<span class="glyphicon glyphicon-arrow-right" style="font-size:11px; color: #EB8F00; margin: 0 2px"></span>';
		            $route_highlight = str_replace('-', $icon, $tour[0]['route_highlight']);
		            echo $route_highlight;
	            ?>
	        <?php endif;?>
	    	</div>
	    
		    <div class="clearfix">    	
		    	<?php if (!empty($tour[0]['review_number'])):?>
		    		<?=get_text_review($tour[0], TOUR, true, false, true)?>
		    	<?php endif;?>
		    </div>
	    	
	    	<div class="row best-seller-price">
				<!--
	            <div class="col-xs-4 text-right">
	                <a class="btn btn-yellow" type="button" href="<?//=get_page_url(TOUR_DETAIL_PAGE, $tour[0])?>">
	            	<?//=ucwords(lang('select'))?>
	            	</a>
	            </div>
				-->
	    	</div>
	    </div>
	</div>
<?php endif;?>

<?php if (!empty($cruise_halong)):?>
	<div class="col-xs-6 best-seller margin-bottom-10 halong-ids" data-id="<?=$cruise_halong[0]['id']?>">
  
    <div class="text-headder"> <?=lang('halong_bay_cruises')?>  </div>
	    <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $cruise_halong[0])?>">
	   		<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $cruise_halong[0]['picture'], '375_250')?>" alt="<?=$cruise_halong[0]['name']?>"> <!-- $cruise_halong[0]['picture'] -->
	    </a>
    <div class="best-seller-content">
        <div class="best-seller-name">
		<div class="col-xs-6 text-left">
            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $cruise_halong[0])?>"><?=$cruise_halong[0]['name']?></a>
			</div>
            <div class="col-xs-6 text-right">
                <span class="text-unhighlight"><?=lang('from')?>: </span> 
                <span class="text-price"><?=lang('lbl_us')?></span>
               <!-- <span class="price-origin t-origin-<?//=$cruise_halong[0]['id']?>"></span> --> 
                <span class="price-from t-from-<?=$cruise_halong[0]['id']?>"> $<?=lang('na')?></span><?=lang('per_pax')?>
            </div>
        </div>
        
        <div class="clearfix text-unhighlight best-seller-router" <?php isset($check_router_highlight) ? print ('display: none;') : ''?>">

        <?php if(!empty($cruise_halong[0]['route_highlight'])):?>
       		<?php 
	       		$icon = '<span class="glyphicon glyphicon-arrow-right" style="font-size:11px; color: #EB8F00; margin: 0 2px"></span>';
	            $route_highlight = str_replace('-', $icon, $cruise_halong[0]['route_highlight']);
	            echo $route_highlight;
            ?>
            
        <?php endif;?>
    	</div>
    		
   		<div class="clearfix">
	    	<?php if (!empty($cruise_halong[0]['review_number'])):?>	
	    		<?=get_text_review($cruise_halong[0], TOUR, true, false, true)?>
	    	<?php endif;?>
    	</div>
    	
    	<div class="row best-seller-price">
            <!--
			<div class="col-xs-12 text-right">
                <a class="btn btn-yellow" type="button" href="<?//=get_page_url(TOUR_DETAIL_PAGE, $cruise_halong[0])?>">
            	<?//=ucwords(lang('select'))?>
            	</a>
            </div>
			-->
    	</div>
    </div>
</div>
<?php endif;?>

<?php if (!empty($cruise_mekong)):?>
	<div class="col-xs-4 best-seller margin-bottom-10 tour-ids" data-id="<?=$cruise_mekong[0]['id']?>">
	    
	    <div class="text-headder" style="background-color: #f6b14a;"> <?=lang('mekong_river_cruises')?> </div>
		    <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $cruise_mekong[0])?>">
		   		<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_TOUR, $cruise_mekong[0]['picture'], '375_250')?>" alt="<?=$cruise_mekong[0]['name']?>">
		   	</a>
	    <div class="best-seller-content">
	        <div class="best-seller-name">
			<div class="col-xs-6 text-left">
	            <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $cruise_mekong[0])?>"><?=$cruise_mekong[0]['name']?></a>
				
	            <div class="col-xs-6 text-right">
	                <span class="text-unhighlight"><?=lang('from')?>: </span> 
	                <span class="text-price"><?=lang('lbl_us')?></span>
	               <!-- <span class="price-origin t-origin-<?=$cruise_mekong[0]['id']?>"></span>  --> 
	                <span class="price-from t-from-<?=$cruise_mekong[0]['id']?>"> $<?=lang('na')?></span><?=lang('per_pax')?>
	            </div>
	        </div>
	        
	        <div class="clearfix text-unhighlight best-seller-router" <?php isset($check_router_highlight) ? print ('display: none;') : ''?>">
	        <?php if(!empty($cruise_mekong[0]['route_highlight'])):?>
	       		<?php 
		       		$icon = '<span class="glyphicon glyphicon-arrow-right" style="font-size:11px; color: #EB8F00; margin: 0 2px"></span>';
		            $route_highlight = str_replace('-', $icon, $cruise_mekong[0]['route_highlight']);
		            echo $route_highlight;
	            ?>
	        <?php endif;?>
	    	</div>
	    	
	   
	    	<div class="clearfix">
	    	<?php if (!empty($cruise_mekong[0]['review_number'])):?>
	    		<?=get_text_review($cruise_mekong[0], TOUR, true, false, true)?>
	    	<?php endif;?>
	    	</div>
	    	
	    	<div class="row best-seller-price">
	            </div>
				<!--
	            <div class="col-xs-4 text-right">
	                <a class="btn btn-yellow" type="button" href="<?//=get_page_url(TOUR_DETAIL_PAGE, $cruise_mekong[0])?>">
	            	<?//=ucwords(lang('select'))?>
	            	</a>
	            </div>
				-->
	    	</div>
	    </div>
	</div>
<?php endif;?>
</div>

<script type="text/javascript">
	equal_height('.best-seller-router, .best-seller-name');
</script>