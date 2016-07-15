<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div style="width: 720px; float: left; position: relative; padding: 10px; margin-left: 5px" id="contentMain">
		
		<div class="tour_header_area grayBox">
			
			<h1 style="padding-left: 0; padding-top:0px;">
				
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
						<i><?=get_duration($tour['duration'])?></i>&nbsp;
						<?php if($tour['departure'] == ''):?>
						- &nbsp;<b class="destination"><?=lang('label_departure')?>: &nbsp;</b> <i><?=lang('label_you_choose')?></i>&nbsp;
						<?php endif;?>
						- &nbsp;<b class="destination"><?=lang('type')?>: &nbsp;</b> 
						<i><?php if(is_private_tour($tour)):?>
							<?=lang('private_type')?>
						<?php else:?>
							<?=lang('share_type')?>
						<?php endif;?></i>
					</div>
				</div>
				
				
				
				<?php if($tour['departure'] != ''):?>
				<div class="row short_description">
					<div class="col_label">
						<?=lang('label_departure')?>:						
					</div>
					<div class="col_content">
						<?=get_departure_short_text($tour['departure'])?>
						
						<?php $tour_depart_dg = get_departure_full_text($tour['departure']);?>
						<?php if(!empty($tour_depart_dg)):?>
							<script>
							dg_content = '<?=$tour_depart_dg?>';
							d_help = '<?=$tour['cruise_name']?> Departure Dates <?=get_text_depart_year($tour['departure'])?>';
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
								
								<ul>
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
							
							</div>
						
						</div>
						
				<?php endif;?>	
				
				
				
				
				 
				<?php if(!empty($tour['brief_description'])):?>
					<div class="row">
						<?=$tour['brief_description']?>
					</div>
				<?php endif;?>
			
			
			</div>
			
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
		
		
					
		<div id="tabs" class="margin_top_10">
			<ul class="bpt-tabs">
				<li><a href="#tour_itinerary"><?=lang('cruise_itinerary')?></a></li>
				
				<li><a href="#tour_policy"><?=lang('label_policy')?></a></li>				
				
				<li><a title="<?=lang('cruise_review')?>" href="<?='/tour_detail/tour_review/'.$tour['url_title'].'/'.REVIEWS_TAB.'/'?>"><span><?=lang('cruise_review')?></span></a></li>
			</ul>		

			<div id="tour_itinerary">
			
				<?=$detail_itinerary?>
				
			</div>
			
			<div id="tour_policy">				
				
				<?=$price_include_exclude?>
				
			</div>
			
			
			
			<div id="tour_review">
				
			</div>
			
		
		</div>
		
		
	</div>
	
	<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
	<div id="popup_container" class="popup_container" style="left:0">

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
    s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery.min.js','',true)?>';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);

    //document.body.appendChild(s);
}
function see_reviews(){
	go_check_rate_position();
	$("#tabs").tiptab({'selected': 2});
}

$(document).ready(function(){

	async_load();

	$("#tabs").tiptab();

	/*
	$( "#tabs" ).tabs({ cache: true, spinner:'Loading...', ajaxOption:{cache:true},
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
});

</script>



