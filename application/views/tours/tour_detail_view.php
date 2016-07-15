<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div id="contentLeft">
	
		<div id="searchForm" style="margin-bottom: 10px;">
			<?=$tour_search_view?>
		</div>
		
		<?=$booking_step?>
		
		<div id="TA_selfserveprop417" class="TA_selfserveprop">
        <ul id="dhusqLwQ94x" class="TA_links graXiO9gqk0">
        <li id="i5Qtnqvm" class="69f5CazOa">
        <a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a>
        </li>
        </ul>
        </div>
        <script src="http://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=417&amp;locationId=4869921&amp;lang=en_US&amp;rating=true&amp;nreviews=0&amp;writereviewlink=true&amp;popIdx=false&amp;iswide=false&amp;border=true&amp;langversion=2"></script>
		
		
		<?=getAds(true)?>
		
		<?=$other_tours?>
		
		<?=$similar_tours_view?>
		
		<div id="tour_faq" class="left_list_item_block">
			<?=$faq_context?>
		</div>
			
	</div>
	
	<div id="contentMain">
		
		<div class="tour_header_area grayBox">
			
			<h1 style="padding-left: 0; padding-top:0px;max-width:520px">
				
				<span class="highlight"><?=$tour['name']?></span>
				
				<?=by_partner($tour, PARTNER_CHR_LIMIT)?>
					
			</h1>		
			
		
			<div class="tour_detail_image">
				<?php 
					$img_url = $this->config->item('tour_medium_path').$tour['picture_name'];
				?>
				<div class="highslide-gallery">
					<a id="tour_gallery_main" rel="nofollow" href="<?=$img_url?>" class="highslide" onclick="return hs.expand(this);">
						<img style="border:0;width:300px" src="<?=$this->config->item('tour_375_250_path').$tour['picture_name']?>" alt="<?=$tour['name']?>" title="<?=$tour['name']?>"></img>
					</a>
						
					<div class="highslide-caption">
						<center><b><?=$tour['name']?></b></center>
					</div>					
				</div>
				
				<?php if(count($gallery_photos) > 0):?>
					
					<?php foreach ($gallery_photos as $key=>$photo):?>	
						
						<?php 
							$margin_right = $key < 3 ? '4px' : '0';
						?>
												
						<div class="highslide-gallery">
							<a href="<?=$photo['medium_path'].$photo['name']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
								<img style="border:0;float:left;margin-top:3px;margin-right:<?=$margin_right?>" alt="" width="72" height="54" src="<?=$photo['small_path'].$photo['name']?>">
							</a>
								
							<div class="highslide-caption">
								<center><b><?=$photo['caption']?></b></center>
							</div>					
						</div>
						
						
						<?php 
							if ($key == 3) break;	
						?>
					
					<?php endforeach;?>
					
					
					<?php foreach ($gallery_photos as $key=>$photo):?>	
						
						<?php 
							if ($key <= 3) continue;	
						?>
						
						
						<div class="hidden-container">
							<a href="<?=$photo['medium_path'].$photo['name']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this, {thumbnailId: 'tour_gallery_main'});">
							</a>
								
							<div class="highslide-caption">
								<center><b><?=$photo['caption']?></b></center>
							</div>					
						</div>
						
					
					<?php endforeach;?>
					
				<?php endif;?>
						
				
			</div>
			<div class="tour_detail_content">
								
				<?php if($tour['cruise_name'] != ''):?>
					<div class="row">
						<?php 
							$star_infor = get_star_infor_tour($tour['star'], 0);
						?>
							
						<div class="col_label"><?=lang('cruise_ship')?>:</div>
						<div class="col_content"><a href="<?=url_builder(CRUISE_DETAIL, $tour['cruise_url_title'], true)?>"><?=$tour['cruise_name']?></a>					 
							<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
							<?php if($tour['is_new'] == 1):?>
								<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
							<?php endif;?>
						</div>
					</div>
				<?php endif;?>
				
				<div class="row">
					<div class="col_label"><?=lang('cruise_destinations')?>:</div>
					<div class="col_content destination"><?=$tour['route']?></div>
				</div>
			
				<div class="row">					
					<div class="col_label">
						<?=lang('duration')?>:
					</div>
					<div class="col_content">
						<?=get_duration($tour['duration'])?>&nbsp;
						<?php if($tour['departure'] == ''):?>
						- &nbsp;<b class="destination"><?=lang('label_departure')?>: &nbsp;</b> <i><?=lang('lb_daily')?></i>&nbsp;
						<?php endif;?>
						- &nbsp;<b class="destination"><?=lang('type')?>: &nbsp;</b> 
						<?php if(is_private_tour($tour)):?>
							<?=lang('private_type')?>
						<?php else:?>
							<?=lang('share_type')?>
						<?php endif;?>
					</div>
				</div>
				
				<?php if($tour['departure'] != ''):?>
				<div class="row short_description">
					<div class="col_label">
						<?=lang('label_departure')?> :						
					</div>
					<div class="col_content">
						<?=get_departure_short_text($tour['departure'])?>
						
						<?php $tour_depart_dg = get_departure_full_text($tour['departure']);?>
						<?php if(!empty($tour_depart_dg)):?>
							<script>
							dg_content = '<?=$tour_depart_dg?>';
							d_help = '<?=$tour['cruise_name']?> <?=lang('departure_dates')?> <?=get_text_depart_year($tour['departure'])?>';
							$('.depart_help').tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '680px', autowidth: true});
							</script>
						<?php endif;?>
					</div>
				</div>
				<?php endif;?>
				
				
				<?php if ($tour['review_number'] > 0):?>
					
					<div class="row">
											
						<div class="col_label" style="margin-top:5px">
							<?=lang('reviewscore')?>:						
						</div>				
						
						<div class="col_content">
							<span style="font-size:18px;font-weight:bold;" class="highlight"><?=$tour['total_score']?></span>
							<span>&nbsp;of&nbsp;&nbsp;<a href="javascript:void(0)" style="font-style:italic;text-decoration:underline" onclick="see_reviews()"><?=$tour['review_number'].' '.($tour['review_number'] > 1 ? lang('reviews') : lang('review'))?></a></span>
							&nbsp;-&nbsp;<span style="font-size:18px;font-weight:bold;">
								<?=review_score_lang($tour['total_score'])?>
							</span>						
						</div>
						
					</div>
					
				<?php endif;?>				
				
				 
				<?php if(isset($tour['hot_deals']) && count($tour['hot_deals']) > 0):?>
						
						<div class="row">
						
							<div class="col_label special">
								<?=lang('special_offers')?>:						
							</div>
							
							<div class="col_content special">
								
								<ul style="float:left;margin-right:10px">
								<?php foreach ($tour['hot_deals'] as $hot_deal):?>
								
										<li style="margin-bottom: 4px;">								
											<a id="promotion_<?=$hot_deal['promotion_id']?>" href="javascript:void(0)" class="special"><?=$hot_deal['name']?> &raquo;</a>
										</li>
										
										<script type="text/javascript">		
											var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
											var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($hot_deal['name'], ENT_QUOTES)?></span>';
											$("#promotion_<?=$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
										</script>	
										
								<?php endforeach;?>
								</ul>
								
								<?php if(is_free_visa($tour) && isset($popup_free_visa)):?>
								<a class="free-visa-halong icon icon-free-visa-left" href="javascript:void(0)"></a>
								<?php endif;?>
							
							</div>
						
						</div>
						
				<?php elseif(is_free_visa($tour) && isset($popup_free_visa)):?>
					<div class="row">
						<div class="col_label special" style="padding-top:2px">
							<?=lang('special_offers')?>:						
						</div>
						<div class="col_content">
							<a class="free-visa-halong icon icon-free-visa-left" href="javascript:void(0)"></a>
						</div>
					</div>
				<?php endif;?>	
				
				<?php if(is_free_visa($tour) && isset($popup_free_visa)):?>
					<div style="display:none" id="free_visa_halong_content">
						<?=$popup_free_visa?>
					</div>
				<?php endif;?>
				 
				<?php if(!empty($tour['brief_description'])):?>
					<?php $descriptions = str_replace("\n", "<br>", $tour['brief_description'])?>
					<div class="row">
						<div id="short_desc" style="margin: 0">
							<?=content_shorten($descriptions, 300)?>
							
							<?php if(fit_content_shortening($descriptions, 300)):?>
								<a href="javascript:void(0)" onclick="readmore_desc()" style="text-decoration: underline;">more &raquo;</a>
							<?php endif;?>
							
						</div>
						
						<?php if(fit_content_shortening($descriptions, 300)):?>
						
						<div id="full_desc" style="display: none; margin: 0">
							
							<?=$descriptions?>
							<a href="javascript:void(0)" onclick="readless_desc()" style="text-decoration: underline;">less &laquo;</a>
						</div>
						
						<?php endif;?>
					</div>
				<?php endif;?>

				
			</div>
			
			<?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
				<div class="btn_general btn_book_together bnt_customize" onclick="go_url('/customize-tours/<?=$tour['url_title']?>/')"><?=lang('label_customize_this_tour')?></div>
			<?php endif;?>
			
			<div class="tour_detail_price">
				
				<?php
					
					$price_view = get_tour_price_view($tour); 
				?>
				
				<?php if($price_view['f_price'] > 0):?>
					<?php if($price_view['d_price'] > 0):?>
		        		<span class="b_discount"><?=CURRENCY_SYMBOL?><?=$price_view['d_price']?></span>
		        	<?php endif;?>
		        	<span class="price_from"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span> <?=lang('per_pax')?>
				<?php else:?>
					<span class="price_from"><?=lang('na')?></span>
				<?php endif;?>
						
			</div>
			
		</div>
		
		<div id="tabs" class="margin_top_10" style="margin-bottom: 20px;">
			<ul class="bpt-tabs">
			    <?php if(!empty($tour['cruise_id'])):?>
			    
			    <li><a href="#tour_check_rate"><?=lang('check_rates')?></a></li>
				
				<li><a href="#tour_itinerary"><?=lang('cruise_itinerary')?></a></li>
				
			    <?php else:?>
			    
			    <li><a href="#tour_itinerary"><?=lang('cruise_itinerary')?></a></li>
			    
			    <li><a href="#tour_check_rate"><?=lang('check_rates')?></a></li>
				
			    <?php endif;?>
				
		
				<li><a title="<?=lang('cruise_review')?>" href="<?='/tour_detail/tour_review/'.$tour['url_title'].'/'.REVIEWS_TAB.'/'?>"><?=lang('cruise_review')?></a></li>
			</ul>		
			<div id="tour_check_rate">
				<?=$tour_check_rate?>
				
				
				<div class="policy_header clearfix">
					<h3 class="highlight"><?=lang('tour_photos')?></h3>
				</div>
				
				<div style="float: left;padding-top:5px">
					<?=$tour_photos?>
				</div>
				
				
			</div>
			
			<div id="tour_itinerary">
				
				<?=$detail_itinerary?>
				
			</div>
			

		</div>
		
		<?=$recommendation_before_book_it?>	
		
		<?php if(empty($tour['cruise_id'])):?>
		<div class="text-center">
		  <div class="btn_general select_this_cruise highlight tour-book-now" style="margin: 20px 0 0" onclick="book_now()"><?=lang('label_book_this_tour')?></div>
		</div>
		<?php endif;?>
		
		<?php if(empty($tour['cruise_id'])):?>
				
		<?=load_tour_contact($tour, true)?>
		
		<?php endif;?>
	</div>
	
	<?=$similar_tours_bottom_view?>
	
	<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
	<div id="popup_container" class="popup_container">

	<span onclick="close_popup()" class="icon btn-popup-close"></span>
	
	<div class="popup_content" id="popup_content">
	
		<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>
	
	</div>
	
	</div>
	
<script type="text/javascript">	

function async_load(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery.min.js', '', true)?>';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);

    //document.body.appendChild(s);
}

function book_now(){
	go_check_rate_position();
	//$("#tabs").tabs({'selected': 0});
    $('#tabs').tiptab({"selected": 1});
}

function see_reviews(){
	go_check_rate_position();
	//$("#tabs").tabs({'selected': 2});
    $('#tabs').tiptab({"selected": 2});
}

$(document).ready(function(){

	async_load();

	<?php if(isset($action) && $action == 'check_rate'):?>
	go_check_rate_position();
	<?php endif;?>

    $('#tabs').tiptab({"selected": <?=$tab_selected?>});

    /*
	$( "#tabs" ).tabs({ cache: true, spinner:'Loading...',selected:<?=$tab_selected?>, ajaxOption:{cache:true},
		load: function(event, ui) {
			// only process for customer review
			if ($('#tabs').tabs('option','selected') == 2){
				$('a', ui.panel).click(function() {						 
					 var selected = $('#tabs').tabs('option', 'selected');
					 $('#tabs').tabs('url', selected, this.href);		
					 $('#tabs').tabs('load', selected);
					 return false;
		        });
				}
			}
		});
	*/

	<?php 
		
		$includes = $tour['services']['includes'];
		
		$excludes = $tour['services']['excludes'];
		
		if(!empty($includes)) {
			$includes = implode("\n", $includes);
		}
		
		if(!empty($excludes)) {
			$excludes = implode("\n", $excludes);
		}

	?>
	

	var dg_content = '<?=get_excludes_text($includes, $excludes)?>';
	
	var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($tour['name'], ENT_QUOTES)?>:</span>';

	$("#what_included_<?=$tour['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});

	<?php if(is_free_visa($tour)):?>
		var dg_content = $('#free_visa_halong_content').html();
		
		var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
	
		$(".free-visa-halong").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
	<?php endif;?>
});

function readmore_desc(){
	$('#short_desc').hide();
	$('#full_desc').show();
}

function readless_desc(){
	
	$('#full_desc').hide();

	$('#short_desc').show();
}

</script>

