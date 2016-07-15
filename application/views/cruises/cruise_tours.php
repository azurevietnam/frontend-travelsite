
<?php if (isset($cruise['tours'])):?>
<?php foreach ($cruise['tours'] as $key => $tour):?>

	<?php 
		$odd = "";
		$first = "";
		if ($key%2 == 1) $odd = " odd";
		if ($key == 0) $first = " first";
	?>
		
	<div class="bpt_item">
	
		<div class="area_left<?=$first?>">
			
			<div class="bpt_item_name">
				<a title="<?=$tour['name']?>" href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>">
				<?=character_limiter($tour['name'], TOUR_NAME_LIST_CHR_LIMIT)?>
				</a>
				<?=by_partner($tour, PARTNER_CHR_LIMIT)?>
			</div>
			
			<div class="bpt_item_image">
				<img width="100%" height="100%" alt="<?=$tour['name']?>" title="<?=$tour['name']?>" src="<?=$this->config->item('tour_small_path') . $tour['picture_name']?>"/>
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
					</div>
				</div>
				<?php endif;?>
				
				<div class="row">
					<div class="col_label">
						<?=lang('cruise_destinations')?>:
					</div>
					<div class="col_content">
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
				
				
				
				<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
				
				<?php 
					$deal_info = $tour['price']['deal_info'];
				?>
				
				<div class="row">
					<div class="col_label special">
						<?php if($deal_info['is_hot_deals']):?>
							<?=lang('special_offers')?>:
						<?php else:?>
							<?=lang('offers')?>:
						<?php endif;?>	
					</div>
					<div class="col_content special">
						<?php 
							$offers = explode("\n", $tour['price']['offer_note']);
						?>
						
						<ul style="font-size: 11px;">
							<?php foreach ($offers as $k=>$offer):?>							
								
								<li><a class="special" href="javascript:void(0)" id="promotion_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$offer?> &raquo;</a></li>
								
							<?php endforeach;?>
						</ul>
					</div>
				</div>
				<?php endif;?>
				<div class="row description">
					<?=character_limiter(strip_tags($tour['brief_description']),TOUR_DESCRIPTION_CHR_LIMIT)?>
				</div>
			
			</div>
			
		</div>
		<div class="area_right<?=$first?>">		
			<div class="bpt_item_price">
				<ul>
					<?php $price_now = get_price_now($tour['price']);?>
					
					<?php if($price_now > 0):?>
					
					<li class="from">from</li>
					<li>
						
		        		<?php  if($price_now != $tour['price']['from_price']):?>
		        			<?=CURRENCY_SYMBOL?><label class="b_discount"><?=number_format($tour['price']['from_price'], CURRENCY_DECIMAL)?></label>
			        	<?php endif;?>
			        	<span class="price_from">
		        			<?=CURRENCY_SYMBOL?><?=number_format($price_now, CURRENCY_DECIMAL)?>
		        		</span><span><?=lang('per_pax')?></span>
			        	
					</li>
					
					<?php else:?>						
						<li><span class="price_from"><?=lang('na')?></span></li>
					<?php endif;?>
				</ul>
			</div>
		</div>
	</div>
<?php endforeach;?>


<script type="text/javascript">
	$(document).ready(function(){

		<?php foreach ($cruise['tours'] as $key=>$tour):?>

		<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
		
			<?php 
				$deal_info = $tour['price']['deal_info'];
			?>

			<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>

				var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
				
				var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';

				$("#promotion_<?=$tour['id'].'_'.$deal_info['promotion_id'].'_'.$k?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
					
			<?php endforeach;?>

		<?php endif;?>	
		
		<?php endforeach;?>
		
	});
</script>

<?php endif?>