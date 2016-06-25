<div class="container-fluid no-padding">
    <?=$bpv_ads?>
</div>
<div class="container mod-search">

    <?=$bpv_search?>

	<div class="row tour-hero margin-top-10">
	
    	<div class="col-xs-12">
    		<h2 class="bpv-color-title">
    		<span class="icon icon-number-one-orange"></span><?=lang('interesting_tour')?>
    		</h2>
    		<p><?=lang('marketing_tour_home_page')?></p>
    	</div>
    	
    	<div class="col-xs-9">
    	   <div class="destinations">
    	       <div class="col-xs-4">
    	           <a href="<?=site_url(TOUR_DOMESTIC_PAGE)?>">
        	       <img class="img-responsive" src="<?=get_static_resources('/media/tour/du-lich-viet-nam.jpg')?>">
        	       </a>
        	       <?=$domestic_destinations_view?>
        	   </div>
        	   <div class="col-xs-4">
        	       <a href="<?=site_url(TOUR_OUTBOUND_PAGE)?>">
        	       <img class="img-responsive" src="<?=get_static_resources('/media/tour/kham-pha-the-gioi.jpg')?>">
        	       </a>
        	       <?=$outbound_destinations_view?>
        	   </div>
        	   <div class="col-xs-4">
        	       <a href="<?=site_url(TOUR_CATEGORY_PAGE)?>">
        	       <img class="img-responsive" src="<?=get_static_resources('/media/tour/trai-nghiem-moi.31122014.jpg')?>">
        	       </a>
        	       <?=$tour_categories_view?>
        	   </div>
    	   </div>
    	</div>

		<div class="col-xs-3 pd-left-0">
            <div class="why-us">
                <img class="img-responsive" src="<?=get_static_resources('/media/tour/vi-sao-chon-bestprice.jpg')?>">
                <ul class="list-unstyled why-us">
                	<li><span class="icon icon-best"></span> <span><?=lang('why_choose_us_1')?></span></li>
                <li><span class="icon icon-wide-selection"></span>
                	<?=lang('why_choose_us_2')?>
                </li>
                <li><span class="icon icon-checker"></span>
                	<?=lang('why_choose_us_3')?>
                </li>
                <li><span class="icon icon-groupon"></span>
                	<?=lang('why_choose_us_4')?>
                </li>
                <li><span class="icon icon-lowest-fee"></span>
                	<?=lang('why_choose_us_5')?>
                </li>
                <li><span class="icon icon-book-together"></span>
                	<?=lang('why_choose_us_6')?>
                	</li>
                </ul>
            </div>
		</div>
	</div>
	
	<div class="row tour-marketing-box">
	   <div class="col-xs-9">
	       <?=load_random_ad(AD_PAGE_TOUR_HOME, AD_AREA_2)?>
	   </div>
	   <div class="col-xs-3 pd-left-0">
	       <?=load_random_ad(AD_PAGE_TOUR_HOME, AD_AREA_3)?>
	   </div>
	</div>
</div>

<div class="container-fluid margin-top-20 bpv-popular-tour popular-bg">
    <div class="container no-padding">
        <div class="col-xs-12">
    		<h2 class="bpv-color-title">
    		<span class="icon icon-circle-domestic"></span><?=lang('popular_domestic_tours')?></h2>
    		<p><?=lang('marketing_domistic_page')?></p>
    	</div>
    	
    	<?=$domestic_tours_view?>
    	
    	<div class="col-xs-12 margin-top-10 text-right">
           <a href="<?=get_url(TOUR_DOMESTIC_PAGE)?>">
               <span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
               <?=lang('more_domestic_tours')?>
           </a>
        </div>
    </div>
</div>

<div class="container margin-top-10 bpv-popular-tour no-padding">
	<div class="col-xs-12">
		<h2 class="bpv-color-title">
		<span class="icon icon-circle-outbound"></span><?=lang('popular_outbound_tours')?></h2>
		<p><?=lang('marketing_outbound_page')?></p>
	</div>
	
	<?=$outbound_tours_view?>
	
	<div class="col-xs-12 margin-top-10 text-right">
    	<a href="<?=get_url(TOUR_OUTBOUND_PAGE)?>">
           <span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
           <?=lang('more_outbound_tours')?>
       </a>
    </div>
</div>

<?php if(!empty($hot_category)):?>
<div class="container hot-category">
    <div class="row">
        <div class="col-xs-12">
    		<h2 class="bpv-color-title">
    		<img width="40" height="40" src="<?=get_static_resources('images/categories/'.$hot_category['picture'])?>" />
    		<?=$hot_category['name']?>
    		</h2>
    	</div>
    	
        <div class="col-xs-6">
        
        <?php foreach ($hot_category['tours'] as $k => $tour):?>
        
        <div class="bpt-list-md<?=($k == count($hot_category['tours']) - 1) ? ' no-border' : ''?> " <?=($k == 0) ? 'style="border-top: 1px solid #D0D0D0"' : ''?>>
    		<div class="col-xs-3 no-padding">
    			<a href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
    				<img class="img-responsive" src="<?=get_image_path(TOUR, $tour['picture'],'160x120')?>">
    			</a>
    		</div>
    		<div class="col-xs-7" style="width: 55%">
    			<a class="item-name" href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>">
    				<?=$tour['name']?>
    			</a>
    			
    			<p class="margin-bottom-5">
                    <?=lang('lbl_tour_route')?><?=$tour['route']?>
        		</p>
        		
    			<p class="margin-bottom-5">
    			    <?=lang('lbl_duration_short')?><span class="bpv-color-marketing"><?=get_duration_text($tour)?></span>
    			</p>
    			
    			<?php if(!empty($tour['promotions'])):?>
    				<?php foreach ($tour['promotions'] as $pro):?>
    					<p>
    						<?=load_promotion_tooltip($pro)?>
    					</p>
    				<?php endforeach;?>
    			<?php endif;?>
    			
    			<?php if(!empty($tour['bpv_promotions'])):?>
    				<?php foreach ($tour['bpv_promotions'] as $bpv_pro):?>
    					<p>
    						<?=load_marketing_pro_tooltip($bpv_pro, $tour['id'])?>
    					</p>
    				<?php endforeach;?>
    			<?php endif;?>
    			
    			<?php if(!empty($tour['review_number'])):?>
    			<p class="item-address">
    				<?=show_review($tour, get_url(TOUR_DETAIL_PAGE, $tour))?>
    			</p>
    			<?php endif;?>
    			
    			
    		</div>
    		<div class="col-xs-2 price-info" style="margin-top: -6px; width: 20%">
    			<?php if (isset($tour['price_from'])):?>
    		
    				<?php if ($tour['price_origin'] != $tour['price_from']):?>
    				<div class="bpv-price-origin">
    					<?=bpv_format_currency($tour['price_origin'])?>
    				</div>
    				<?php endif;?>
    				
    				<div class="bpv-price-from margin-bottom-10"><?=bpv_format_currency($tour['price_from'])?></div>
    			
    			    <a type="button" href="<?=get_url(TOUR_DETAIL_PAGE, $tour, $search_criteria)?>" 
    				    class="btn btn-bpv pull-right btn-book-now" 
    				    style="font-weight: bold; padding: 5px 10px; background-color: #ffc300; border-bottom: 3px solid #dea800; color: #003580"><?=lang('btn_book_now')?></a>
    			<?php else:?>
                    <?php 
        				$params = get_tour_contact_params($tour, $search_criteria);
        			?>
        			
        			<a href="<?=get_url(CONTACT_US_PAGE, $params)?>" class="btn btn-bpv btn-sm btn-book-now pull-right" style="font-weight: normal; padding: 5px 10px; font-size: 14px">
        				<?=lang('contact_for_price')?>
        			</a>
                <?php endif;?>
    			
    		</div>
    	</div>
        
        <?php endforeach;?>
        
        <div class="col-xs-12 pd-right-0 margin-top-10 text-right">
        	<a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $hot_category)?>">
               <span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
               <?=lang('more_tours_category').' '.$hot_category['name']?>
           </a>
        </div>
        
        </div>
        <div class="col-xs-6">
            <img class="img-responsive margin-bottom-20" src="<?=get_static_resources('/media/tour/thuong-hieu-noi-tieng-bestprice.jpg')?>">
            
            <div class="row margin-bottom-20" style="margin-left: -10px; margin-right: -10px">
                <div class="col-xs-4" style="padding: 0 10px">
                    <a target="_blank" rel="nofollow" href="http://www.patamanager.org/Members/7902">
                    <img class="img-responsive" src="<?=get_static_resources('/media/tour/pata.jpg')?>">
                    </a>
                </div>
                <div class="col-xs-4">
                    <a target="_blank" class="pull-right" rel="nofollow" href="http://www.tripadvisor.com.vn/Attraction_Review-g293924-d4869921-Reviews-Best_Price_Vietnam_Private_Day_Tour-Hanoi.html">
                        <img class="img-responsive" src="<?=get_static_resources('/media/tour/tripadvisor.jpg')?>">
                    </a>
                </div>
                <div class="col-xs-4" style="padding: 0 10px">
                    <a target="_blank" class="pull-right" rel="nofollow" href="http://www.Bestviettravel.xyz/tin-tuc/bestprice-duoc-cap-giay-phep-kinh-doanh-lu-hanh-quoc-te-43.html">
                        <img class="img-responsive" src="<?=get_static_resources('/media/tour/international_licence.jpg')?>">
                    </a>
                </div>
            </div>
            
            <?=load_hotline_suport(TOUR, false)?>
        </div>
    </div>
</div>
<?php endif;?>

<?=$tour_contact?>
<div class="container">
	<?=$footer_links?>
</div>
<?=$bpv_register?>

<script>
$('.group-name').bpvToggle();
</script>