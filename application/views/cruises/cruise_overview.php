<?php 
	$buton_text = empty($cruise_name) ? lang('book_now') : lang('view_more_detail');
?>

<h1 style="padding-left: 0; padding-top: 5px;">
	<span class="highlight">	
		<?=$cruise['name']?>
	</span>
	<?php $star_infor = get_star_infor($cruise['star'], 1);?>
	<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
	
	<?php if($cruise['is_new'] == 1):?>
		<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
	<?php endif;?>
					
	<?=by_partner($cruise)?>
</h1>

<div style="font-style:italic;color:#666;padding-bottom:10px"><?=$cruise['address']?></div>

<div class="overview_main_img">
	<img id="main_img_<?=$cruise['id']?>" width="375" height="250" alt="<?=$cruise['name']?>" title="<?=$cruise['name']?>" src="<?=$this->config->item('cruise_375_250_path') . $cruise['picture']?>"/>
	
	<div class="img_caption">
		<span id="img_caption_<?=$cruise['id']?>"><?=$cruise['name']?></span>
	</div>
	
	<div style="margin-top: 5px;">
	
	<?php 
		$index = 0;
	?>
	
	<?php foreach ($cruise['cabins'] as $key=>$cabin):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('cruise_375_250_path') . $cabin['picture']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$cabin['picture']?>" imgcaption="<?=htmlentities($cabin['name'])?>" alt="" src="<?=$this->config->item('cruise_80_60_path') . $cabin['picture']?>">
			<br>
			<center style="font-size:9px"><?=$cabin['name']?></center>
		</div>
		
		<?php 
			$index++;
		?>
	
	<?php endforeach;?>
	<?php foreach ($cruise['photos'] as $key=>$photo):?>
		
		<?php
			 
			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('cruise_375_250_path') . $photo['name']?>">
		
		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
		
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$photo['name']?>" imgcaption="<?=htmlentities($photo['description'])?>"  alt="" src="<?=$this->config->item('cruise_80_60_path') . $photo['name']?>">
			<br>
			<center style="font-size:9px"><?=$photo['description']?></center>
		</div>
		
		<?php 
			$index++;
		?>
		
	<?php endforeach;?>
	</div>
	
	<?php if($index >= 4):?>
		<div class="show_more"><a style="margin-right: 10px;" href="javascript:void(0)" onclick="show_hide_img(this)" class="function" stat="hide"><?=lang('label_show_more')?> &raquo;</a></div>
	<?php endif;?>
</div>

<div class="overview_row">
<?php if(count($cruise['tours']) >0):?>

<div class="overview_row" style="padding-top: 7px;">
	<div class="col_label">
		<b><?=lang('price_from')?>:</b>
	</div>
	
	<div class="col_content" style="margin-top: -15px;">
		
		<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')"><?=$buton_text?></div>
		
		<div style="margin-right: 15px;">
			<?php
				$tour = $cruise['tours'][0]; 
				$price_view = get_tour_price_view($tour); 
			?>
			
			<?php if($price_view['f_price'] > 0):?>
				<?php if($price_view['d_price'] > 0):?>
	        		<span class="b_discount" style="font-size:12px"><?=CURRENCY_SYMBOL?><?=$price_view['d_price']?></span>
	        	<?php endif;?>
	        	<span class="price_from"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span> <?=lang('per_pax')?>
			<?php else:?>
				<span class="price_from"><?=lang('na')?></span>
			<?php endif;?>
		</div>
	
	</div>
	
</div>

<?php endif;?>

<div class="overview_row">
						
	<div class="col_label">
		<span><?=lang('cruise_type')?>:</span>
	</div>
	
	<div class="col_content">
		<span class="cruise_type"><?=get_cruise_type($cruise)?></span>
	</div>
	
</div>


<?php if($cruise['num_reviews'] > 0):?>	
	<div class="overview_row">
		<div class="col_label" style="margin-top:5px">
			<?=lang('reviewscore')?>:
		</div>
		<div class="col_content">
			
			<span style="font-size:18px;font-weight:bold;" class="highlight"><?=$cruise['review_score']?></span>
			<span>&nbsp;of&nbsp;&nbsp;<a href="<?=url_builder(CRUISE_REVIEWS, $cruise['url_title'], true)?>" style="font-style:italic;text-decoration:underline"><?=$cruise['num_reviews'].' '.($cruise['num_reviews'] > 1 ? 'reviews' : 'review')?></a></span>
			&nbsp;-&nbsp;<span style="font-size:18px;font-weight:bold;">
				<?=review_score_lang($cruise['review_score'])?>
			</span>		
			
		</div>
	</div>
<?php endif;?>

<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
	
	<div class="overview_row">
		<div class="col_label special">
			<?=lang('special_offers')?>:
		</div>
		
		<div class="col_content">
		
			<?php foreach ($cruise['hot_deals'] as $k=>$hot_deal):?>
				
				<?php if($k > 0):?><br><?php endif;?>
											
				<a class="special" stat="hide" id="ptext_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>" style="font-size: 11px;" href="javascript:void(0)" onclick="open_hot_deal(<?=$cruise['id']?>, <?=$hot_deal['promotion_id']?>)"><?=$hot_deal['name']?> &raquo;</a>
				
				<div class="hide_area" id="promotion_<?=$cruise['id'].'_'.$hot_deal['promotion_id']?>">
					
					<span class="icon btn-popup-close" style="top:3px; right:3px" onclick="close_hot_deal(<?=$cruise['id']?>, <?=$hot_deal['promotion_id']?>)"></span>
					<?=get_promotion_condition_text($hot_deal)?>
					
				</div>
			<?php endforeach;?>
		</div>
	</div>
	
<?php endif;?>

<?php if(count($cruise['cabins']) >0):?>
<div class="overview_row highlight" style="padding-top: 5px;">
	<b><?=lang('label_cruise_cabins')?>:</b>
</div>

<div class="overview_row">
	<ul class="trip_highlight">
	<?php foreach ($cruise['cabins'] as $cabin):?>
		<li style="margin-bottom: 7px">
			<a stat="hide" id="cabin_text_<?=$cabin['id']?>" onclick="open_cabin(<?=$cabin['id']?>)" style="text-decoration:underline;" href="javascript:void(0)"><b><?=$cabin['name']?></b> - <?=$cabin['cabin_size']?> <?=lang('cruise_m2')?> &raquo;</a>
			
			<?php if(trim($cabin['bed_size']) != '' && trim($cabin['bed_size']) != '0'):?>
			<div style="padding-top: 2px;font-size: 11px; color: #666;"><?=$cabin['bed_size']?></div>
			<?php endif;?>
			
			<div id="cabin_content_<?=$cabin['id']?>" class="hide_area">
				
				<span class="icon btn-popup-close" style="top: 3px; right: 3px" onclick="close_cabin(<?=$cabin['id']?>)"></span>
				
				<div style="position: relative; margin-right: 10px; float: left;cursor: pointer">
					<img onclick="update_main_img(this)" imgname="<?=$cabin['picture']?>" imgcaption="<?=htmlentities($cabin['name'])?>" alt="<?=$cabin['name']?>"  src="<?=$this->config->item('cruise_80_60_path').$cabin['picture']?>"/>
					<br>
					<center style="font-size:9px"><?=$cabin['name']?></center>
				</div>
				
				<?php 
					$descriptions = str_replace("\n", "<br>", $cabin['description']);
				?>
				<p style="margin-top: 0px; margin-bottom: 0;font-size:12px"><?=character_limiter($descriptions, 300)?></p>	
						
			</div>
			
		</li>
	<?php endforeach;?>
	</ul>
</div>

<?php endif;?>

</div>

<p>
	<?=str_replace("\n", "<br>", $cruise['description'])?>
</p>
				

<?php if(!empty($cruise['tours']) && count($cruise['tours']) > 0):?>
<div class="clearfix"></div>

<div class="cruise_tour_header">
	<h2><?=lang('cruise_tour_tab')?></h2>
</div>

<div class="recommendation_items" style="border-bottom:0; margin-top: 0;padding-left:0">
<?php foreach ($cruise['tours'] as $tour):?>
	
	<div class="item" style="width:720px">
		
		<div class="item_img">
			<img alt="<?=$tour['name']?>" src="<?=$this->config->item('tour_80_60_path') . $tour['picture_name']?>"/>
		</div>
		
		<div class="item_content" style="width:350px;">
		
			<div class="bpt_item_name item_name">
				
				<a href="javascript:void(0)" onclick="see_tour_overview(<?=$tour['id']?>, '<?=$departure_date?>')"><?=$tour['name']?></a>
				
			</div>
			
			<div class="row item_address">
				<?=$tour['route']?>
			</div>
			
			<div class="row item_review">
				<?=get_full_review_text($tour, false)?>
			</div>
					
		</div>
		
		<div class="item_price_from" style="width:152px;">
			<div class="text_info"><?=lang('bt_from')?></div>
			
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
		
		<div class="item_price_discount">
			<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')" style="margin-top: 20px; margin-right: 0; float: right; margin-left: 0">
			 	<?=$buton_text?>			 	
			 </div>
		</div>	
	
	</div>

<?php endforeach;?>

</div>
	
	
<?php endif;?>


<script type="text/javascript">

function update_main_img(img_obj){

	var img_name = $(img_obj).attr('imgname');

	var imgcaption = $(img_obj).attr('imgcaption');
	
	$('#main_img_<?=$cruise['id']?>').attr("src",'<?=$this->config->item('cruise_375_250_path')?>' + img_name);

	if (imgcaption != ''){
	
		$('#img_caption_<?=$cruise['id']?>').text(imgcaption);

	} else {

		$('.img_caption').hide();
		
	}
	
}

<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

function open_hot_deal(cruise_id, hot_deal_id){

	var status = $('#ptext_'+ cruise_id + '_' + hot_deal_id).attr('stat');

	if (status == 'hide'){
	
		$('#promotion_'+ cruise_id + '_' + hot_deal_id).show();

		$('#ptext_'+ cruise_id + '_' + hot_deal_id).attr('stat', 'show');
		
	} else {

		$('#promotion_'+ cruise_id + '_' + hot_deal_id).hide();

		$('#ptext_'+ cruise_id + '_' + hot_deal_id).attr('stat', 'hide');
	}
}

function close_hot_deal(cruise_id, hot_deal_id){
	$('#promotion_'+ cruise_id + '_' + hot_deal_id).hide();
	$('#ptext_'+ cruise_id + '_' + hot_deal_id).attr('stat', 'hide');
}

<?php endif;?>

<?php if(count($cruise['cabins']) > 0):?>

function open_cabin(cabin_id){

	$('#cabin_content_'+ cabin_id)
	
	var status = $('#cabin_text_'+ cabin_id).attr('stat');

	if (status == 'hide'){

		$('#cabin_content_'+ cabin_id).show();

		$('#cabin_text_'+ cabin_id).attr('stat', 'show');
		
	} else {

		$('#cabin_content_'+ cabin_id).hide();

		$('#cabin_text_'+ cabin_id).attr('stat', 'hide');
		
	}
	
}

function close_cabin(cabin_id){
	$('#cabin_content_'+ cabin_id).hide();
	$('#cabin_text_'+ cabin_id).attr('stat', 'hide');
}

<?php endif;?>


</script>