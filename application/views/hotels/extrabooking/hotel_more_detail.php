<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div style="float: left; padding: 10px; margin-left: 5px" id="contentMain">
	
		<div style="float: left; width: 720px; position: relative;">
			
		<h1 class="highlight" style="padding-left: 0; padding-top: 0">
			<?=$hotel['name']?>
			
			<?php $star_infor = get_star_infor($hotel['star'], 1);?>
			<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			
			<?php if($hotel['is_new']):?>
				<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
			<?php endif;?>
		</h1>

		<span class="hotel_address">
			<?=$hotel['location']?>
			
			<a href="javascript:show_hotel_detail('<?=$hotel['url_title']?>')"></a>
		</span>
		
		<?php if($hotel['review_number'] > 0):?>
			<div class="bpt_item_review" style="z-index: 100;position:absolute;right:0;top:0">
				
				<div class="review_text" style="font-size:18px"><span class="highlight"><?=review_score_lang($hotel['total_score'])?></span></div>
				<div>
					<b><span class="review_score" itemprop="average"><?=$hotel['total_score']?></span>
					</b> <?=lang('hotel_of') ?> <span itemprop="count"><?=$hotel['review_number'].' '.( $hotel['review_number'] > 1 ? lang('reviews') : lang('review'))?></span>
				</div>
				
			</div>
		<?php endif;?>
		
</div>	
	<div id="tabs" class="margin_top_10" style="width: 720px; margin-top: 15px">
		
		<ul class="bpt-tabs">																					
			<li><a href="#overview_availability"><?=lang('hotel_detail') ?></a></li>
			
			<li>
				<a title="<?=lang('customer_reviews')?>" href="<?='/hotel_detail/hotel_review_ajax/'.$hotel['url_title'].'/'?>"><?=lang('customer_reviews')?></a>
			</li>
		</ul>	
		
		<div id="overview_availability" style="background-color: white;">
			
			<?=$detail?>
			
		</div>
	
		
	</div>
		
</div>

<script>
$('#tabs').tiptab({
    ajaxOptions: {cache:true, data:{is_more_detail:'1'}, type:"POST"}
});
/*
$( "#tabs" ).tabs({ cache: true, spinner:'Loading...', ajaxOptions:{cache:true, data:{is_more_detail:'1'}, type:"POST"},
	load: function(event, ui) {
		// only process for customer review
		if ($('#tabs').tabs('option','selected') == 1){
			$('a[id!="main_obj"]', ui.panel).click(function() {					 
				 var selected = $('#tabs').tabs('option', 'selected');
				 $('#tabs').tabs('url', selected, this.href);		
				 $('#tabs').tabs('load', selected);
				 return false;
	        });

			$('a[id="main_obj"]', ui.panel).click(function() {					 
				
				 return false;
	        });
	        
			}
		}
	});
*/
</script>
