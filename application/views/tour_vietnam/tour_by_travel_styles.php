<?=$best_tour_view?>

<?php if(!empty($tours)):?>

<h2 class="highlight" style="margin-top: 10px; float: left;"><span class="icon recommend_icon"></span><?=$tour_list_title?></h2>

<div id="tabs">	
	<ul class="bpt-tabs">
		<?php foreach ($des_styles as $k =>$style):?>
			<?php if(isset($tours[$style['style_name']])):?>
			<?php $tour_ts = get_tour_travel_style_text($tours, $destination_url_title, $style);?>
				<li><a href="<?=$tour_ts['href']?>"><?=$tour_ts['text']?></a></li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
	
	<?php foreach ($des_styles as $style):?>
	<?php if(isset($tours[$style['style_name']]) && count($tours[$style['style_name']]) > 0):?>
	<?php
		$destination_name =  str_replace('-', '_', $destination_url_title);
		
		$en_style_name = str_replace(' ', '-', $style['en_style_name']);
		
	?>
	<div id="<?=$destination_name.'_'.$en_style_name.'_Tours'?>">
		<?php foreach ($tours[$style['style_name']] as $key => $tour):?>
		
		<?php 
			$odd = "";			
			if ($key%2 == 1) $odd = " odd";
		?>
	
		<div class="bpt_item item_radius">
			<div class="item_header"></div>
			<div class="area_left">
				
				<div class="bpt_item_name">
					<a title="<?=$tour['name']?>" href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><?=$tour['name']?></a>
					<?=by_partner($tour)?>
				</div>
				
				<div class="img_area">
					<div class="bpt_item_image">			
						<img width="135" height="90" alt="<?=$tour['name']?>" title="<?=$tour['name']?>" src="<?=$this->config->item('tour_135_90_path') . $tour['picture_name']?>"/>				 
					</div>
									
					<div class="btn_general btn_book_together btn_overview" onclick="see_tour_overview(<?=$tour['id']?>, '<?=$search_criteria['departure_date']?>')"><?=lang('see_overview')?></div>
					
				</div>
				
				<div class="item_content">
				
					<?php if($tour['category_id'] == 2 || $tour['category_id'] == 3):?>
					<div class="row">
						<div class="col_label">
							<span><?=lang('cruise_ship')?>:</span>
						</div>
						<div class="col_content">
							<a href="<?=url_builder(CRUISE_DETAIL, url_title($tour['cruise_url_title']), true)?>"><?=$tour['cruise_name']?></a>
							<?php $star_infor = get_star_infor_tour($tour['star'], 0);?>
							<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
							
							<?php if($tour['is_new'] == 1):?>
								<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
							<?php endif;?>
						</div>
					</div>
					<?php endif;?>
					
					<div class="row">
						<div class="col_label">
							<?=lang('cruise_destinations')?>:
						</div>
						<div class="col_content destination">
							<?=$tour['route']?>
						</div>
					</div>
					
					<?php if ($tour['review_number'] > 0):?>	
						<div class="row">
							<div class="col_label">
								<?=lang('reviewscore')?>:
							</div>
							<div class="col_content">
								<?=get_full_review_text($tour)?>						
							</div>
						</div>
					<?php endif;?>
					
					<div class="row <?=$tour['id'].'block_text_promotion'?>" style="display: none;">
						<div class="col_label special" id="<?=$tour['id'].'_offer_title'?>">
							<?=lang('special_offers')?>:
						</div>
						<div class="col_content special description">
							<ul class="offer_lst <?=$tour['id'].'text_promotion'?>">
							</ul>
						</div>
					</div>
					
					<div class="row description">
						<?=character_limiter(strip_tags($tour['brief_description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
					</div>
				
				</div>
			</div>
			<div class="area_right">
				<div class="bpt_item_price <?=$tour['id'].'block_price'?>" style="display: none;width: auto;">
					<ul>
						
						<li class="from <?=$tour['id'].'from_label'?>"><?=lang('bt_from')?></li>
						<li>
				        	<span class="<?=$tour['id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$tour['id'].'promotion_price'?>"></span></span>
				        	<span class="price_from"><label class="<?=$tour['id'].'from_price'?>"></label></span>
						</li>
					</ul>
				</div>
				
				<div class="clearfix"></div>
			
				<div style="margin-top: 5px;clear:both;">
					<span class="icon icon-what-included"></span>
					<a href="javascript:void(0)" class="bpt_item_price_included" id="what_included_<?=$tour['id']?>_<?=url_title($style['en_style_name'])?>"><?=lang('what_included')?> &raquo;</a>
				</div>
			
				<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')">
				<?php if($tour['cruise_id'] >0):?>
					<?=lang('select_cruise')?>
				<?php else:?>
					<?=lang('select_tour')?>
				<?php endif;?>
				</div>		
			
			</div>
		</div>
		<?php endforeach;;?>
		<div class="more_tour"><span class="arrow">&rsaquo;</span>
			<?php
				$destination_url =  str_replace(' ', '-', $destinations);
			?>
			<a class="link_function" href="<?=url_builder(MODULE_TOURS, $destination_url.'_'.get_style_short_name($en_style_name, true, 'en'))?>"><?=lang('more')?> <?=$destinations. ' ' .get_style_short_name($style['style_name'], FALSE)?></a>
		</div>
	</div>
	<?php endif;?>
	<?php endforeach;?>

</div>


<?php endif;?>


<script type="text/javascript">

$(function() {

    $('#tabs').tiptab();
	//$( "#tabs" ).tabs({});

	<?php foreach ($des_styles as $style):?>

		<?php if(isset($tours[$style['style_name']]) && count($tours[$style['style_name']]) > 0):?>
		<?php foreach ($tours[$style['style_name']] as $key=>$tour):?>
		
		
			var dg_content = '<?=get_excludes_text($tour['includes'], $tour['excludes'])?>';
			
			var d_help = '<span class="highlight" style="font-size: 14px;"><?=htmlspecialchars($tour['name'], ENT_QUOTES)?>:</span>';
		
			$("#what_included_<?=$tour['id']?>_<?=url_title($style['en_style_name'])?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '600px'});
		
		
		<?php endforeach;?>

		<?php foreach ($tour_hot_deals as $tour):?>

			<?php
				
				$promotion_title = htmlspecialchars($tour['promotion_name'], ENT_QUOTES);
			?>
			
			var dg_content = '<?=get_promotion_condition_text($tour)?>';
			var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
			$(".hot_deal_<?=$tour['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
	
		<?php endforeach;?>
	
		<?php endif;?>
	<?php endforeach;?>
});

var tour_ids = '<?=$tour_ids?>';
</script>