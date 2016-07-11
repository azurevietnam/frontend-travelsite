<?php if(isset($indochina_tour) && !empty($indochina_tour)):?>
<div id="best-deal">
	<div class="header">
		<h2 class="special"><span class="icon icon_best"></span><?=lang_arg('most_recommended_of_vietnam_tour', date('Y'))?></h2>
	</div>
	<div class="content">
		<div class="deal-content">
			<div class="deal-name">
				<a href="<?=url_builder(TOUR_DETAIL, $indochina_tour['url_title'], true)?>"><?=$indochina_tour['name']?></a>
				<?=by_partner($indochina_tour)?>
			</div>
			<div class="deal-row" style="margin-top: 0">
				<div class="group_price">
					<span class="<?=$indochina_tour['id'].'promotion_price'?> b_discount"></span>
		        	<span class="price_from"><label class="<?=$indochina_tour['id'].'from_price'?>"></label></span>	
				</div>
			</div>
			
			<div class="deal-row special deal-block <?=$indochina_tour['id'].'block_text_promotion'?>" style="display: none;">
				<div style="width: 90px;" id="<?=$indochina_tour['id']?>_offer_title" rel="best_tour"><b><?=lang('special_offers')?>:</b></div>
				<div class="offer_best_tour" rel="best_tour">
					<ul class="deal-offers <?=$indochina_tour['id'].'text_promotion'?>"></ul>
				</div>
			</div>
			
			<div class="deal-row">
			 	<span style="color:#666;"><?=lang('cruise_destinations')?>:</span> <?=des_character_limiter($indochina_tour['route'])?>
			 </div>
			
			<?php if ($indochina_tour['review_number'] > 0):?>	
				<div class="deal-row"><?=lang('reviewscore')?>:
				<?=get_full_review_text($indochina_tour)?>
				</div>
			<?php endif;?>
			
			
			 <p class="deal-row short_description">
			 	<?=strip_tags(character_limiter($indochina_tour['brief_description'], 100))?>
			 </p>
			<a href="<?=url_builder(TOUR_DETAIL, $indochina_tour['url_title'], true)?>"> 
			<div class="btn_general btn_see_deal" id="check_rate_<?=$indochina_tour['id']?>">
			 	<span><?=lang('btn_see_details')?></span>
			 	<span class="icon icon-go"></span>
			 </div>
			 </a>
		</div>
		
		<div class="deal-image">
			<img width="375" height="250" src="<?=$this->config->item('tour_375_250_path').$indochina_tour['picture_name']?>"></img>
		</div>
	</div>
</div>
<?php endif;?>

<?php if(isset($indochina_styles) && !empty($indochina_styles)):?>
<div class="indochina_style">
	<h2 class="highlight"><span class="icon icon_tours"></span><?=lang('title_vn_tour_by_travel_style')?></h2>
	<div style="padding: 0 10px; margin-top: 10px">
	<?php foreach ($indochina_styles as $key => $style):?>
		<?php 
			$img_name = strtolower(str_replace(' ', '_', $style['en_style_name']));
			
			$style_name = get_style_short_name($style['style_name']);
			
			$en_style_name = get_style_short_name($style['en_style_name'], true, 'en');
			
			$style_url = url_builder(MODULE_TOURS, 'Vietnam'.'_'.$en_style_name);
		?>
		<div class="style_block <?php if($key < 3) echo('first_row');?>">
			<?php
				$st = ''; 
				if(($key+1)%3 == 0) $st = 'style="float:right"';
				if(($key+2)%3 == 0) $st = 'style="margin-left: 30px"';
			?>
			<div <?=$st?>>
				<img width="175" height="117" src="<?='/media/vietnam_tour/'.$img_name.'.jpg'?>">
				<ul>
					<li><a class="style_name" href="<?=$style_url?>"> <?=str_replace('-', ' ', $style_name)?></a></li>
					<li><label><?=$style['style_description']?></label></li>
				</ul>
			</div>
		</div>
	<?php endforeach;?>
	</div>
</div>
<?php endif;?>

<?php if(isset($indochina_countries) && !empty($indochina_countries)):?>
<div class="indochina_country grayBox">
	<h2 class="highlight"><span class="icon icon_tours"></span><?=lang('title_indochina_tours')?></h2>
	<ul>
		<?php foreach ($indochina_countries as $country):?>
		<li class="country">
			<?php 
				$pic_name = str_replace(ucfirst(lang('tours')), '', $country['name']);
				$pic_name = strtolower(trim($pic_name));
				$pic_name .= '.jpg';
			?>
			<img width="135" height="90" src="<?=get_static_resources('/media/'.$pic_name)?>" />
			<div>
				<h3>
					<a class="highlight" href="<?=$country['url']?>"><?=$country['name']?></a>
				</h3>

				<p class="country_info short_description">
					<?=character_limiter($country['detail_info'], 200)?>
				</p>

				<p class="country_styles">
					<?php foreach ($country['style'] as $key => $country_style):?>
					<span class="country_style"> 
						<label class="arrow">&rsaquo; </label>
						<a href="<?=$country_style['url']?>"><?=$country_style['name']?> </a>
					</span>
					<?php endforeach;?>
				</p>
			</div>
		</li>
		<?php endforeach;?>
	</ul>
</div>
<?php endif;?>

<?php if(!empty($tour_ids)):?>
<script type="text/javascript">
var tour_ids = '<?=$tour_ids?>';
</script>
<?php endif;?>

