<?php if(isset($best_tour)):?>
<div id="best-deal">
	<div class="header">
		<h2 class="special"><span class="icon icon_best"></span><?=$tour_vn_title?></h2>
	</div>
	<div class="content">
		<div class="deal-content">
			<div class="deal-name">
				<a href="<?=url_builder(TOUR_DETAIL, $best_tour['url_title'], true)?>"><?=$best_tour['name']?></a>
				<?=by_partner($best_tour)?>
			</div>
			<div class="deal-row" style="margin-top: 0">
				<div class="group_price">
					<span class="<?=$best_tour['id'].'promotion_price'?> b_discount"></span>
		        	<span class="price_from"><label class="<?=$best_tour['id'].'from_price'?>"></label></span>	
				</div>
			</div>
			
			<div class="deal-row special <?=$best_tour['id'].'block_text_promotion'?>" style="border: 0;display: none; margin-top: -15px">
				<div id="<?=$best_tour['id']?>_offer_title" rel="best_tour"><b><?=lang('special_offers')?>:</b></div>
				<div class="offer_best_tour" rel="best_tour">
					<ul class="deal-offers <?=$best_tour['id'].'text_promotion'?>" style="line-height: 1em"></ul>
				</div>
			</div>
			
			<div class="deal-row">
			 	<span><?=lang('cruise_destinations')?>:</span> <?=des_character_limiter($best_tour['route'])?>
			 </div>
			
			<?php if ($best_tour['review_number'] > 0):?>	
				<div class="deal-row"><?=lang('reviewscore')?>:
				<?=get_full_review_text($best_tour)?>
				</div>
			<?php endif;?>
			
			
			 <p class="deal-row short_description">
			 	<?=strip_tags(character_limiter($best_tour['brief_description'], 100))?>
			 </p>
			<a href="<?=url_builder(TOUR_DETAIL, $best_tour['url_title'], true)?>">  
			<div class="btn_general btn_see_deal" id="check_rate_<?=$best_tour['id']?>">
			 	<span><?=lang('btn_see_details')?></span>
			 	<span class="icon icon-go"></span>
			 </div>
			 </a>
		</div>
		
		<div class="deal-image">
			<img width="375" height="250" src="<?=$this->config->item('tour_375_250_path').$best_tour['picture_name']?>"></img>
		</div>
	</div>
</div>
<?php endif;?>