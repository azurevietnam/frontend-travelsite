
<div class="search_area">
	<!-- Search Form -->
	<?=$tour_search_view?>
</div>

<div class="why_use_area">
	<div class="why_use">
		
		<h1 class="highlight"><?=lang('why_use')?></h1>
		
		<ul>
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="special why_use_item"><?=lang('best_price_guaranteed') ?></span>
			</li>
			
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="why_use_item"><?=lang('best_travel_deals') ?></span>
			</li>
			
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="why_use_item"><?=lang('reliable_services_true_value') ?></span>
			</li>
			
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="why_use_item"><?=lang('low_service_fees') ?></span>
			</li>
			
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="why_use_item special"><?=lang('lower_rates_for_group_booking') ?></span>
			</li>
			
			<li>
				<span class="icon icon_checkmark"></span>
				<span class="why_use_item special"><?=lang('discount_for_booking_services_together') ?></span>
			</li>
			 
		</ul>
		
		<div class="book-together-area">
			<h2 class="highlight"><?=lang('our_offer')?></h2>
			
			<img width="213" height="32" src="<?=get_static_resources('/media/book-together-home.png')?>">
			
			<span id="booking_together" class="icon icon-help" style="cursor: help;margin: 0 0 15px 5px;"></span>	
			<a href="/book_together.html" style="text-decoration: underline;"><?=lang('label_learn_more') ?></a>
		</div>
		
	</div>
</div>

<div class="clearfix"></div>

<div class="cruse_deal_area">

<?php if(count($halong_cruise_deals) > 0):?>
<div class="halong_mekong_deal_area">
	<h2 class="highlight"><?=lang('halong_bay_deals')?></h2>
	
	<div class="list_tour_hot_deals">
	<?php 
		$count = 0;
	?>
	<?php foreach ($halong_cruise_deals as $key=>$tour):?>
	
		<div class="deal_item">
			<div class="deal_item_price">
				<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($tour['from_price'], CURRENCY_DECIMAL)?></span>
				<span class="price_from" style="font-size:14px;"><?=CURRENCY_SYMBOL?><?=number_format($tour['selling_price'], CURRENCY_DECIMAL)?></span><br>
			</div>
			
			<div class="deal_item_content">				
				<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><img width="135" height="90" class="deal_item_image" src="<?=$this->config->item('tour_135_90_path').$tour['picture']?>" alt="<?=$tour['name']?>"></img></a>
			
				
				<div class="row">
					<a <?php if(strlen($tour['name']) > TOUR_NAME_HOT_DEAL_LIMIT):?> title="<?=$tour['name']?>" <?php endif;?> href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><b><?=character_limiter($tour['name'], TOUR_NAME_HOT_DEAL_LIMIT)?></b></a><br/>				
				</div>
				
				<?php if ($tour['offer_note'] != ''):?>
					
						<?php 
							$offers = explode("\n", $tour['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
								<div class="row special"><span><?=$offer?></span></div>
						<?php endforeach;?>
						
				<?php endif;?>
		
			</div>
		</div>
		
		<?php 
			$count++;
			if ($count == 3) break;
		?>
					
	<?php endforeach;?>	
	</div>
</div>

<?php endif;?>

<?php if(count($mekong_cruise_deals) > 0):?>
<div class="halong_mekong_deal_area">
	<h2 class="highlight"><?=lang('mekong_river_deals')?></h2>
	
	<div class="list_tour_hot_deals">
	
	<?php 
		$count = 0;
	?>
	
	<?php foreach ($mekong_cruise_deals as $key=>$tour):?>
		
		<div class="deal_item">
			<div class="deal_item_price">
				<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($tour['from_price'], CURRENCY_DECIMAL)?></span>
				<span class="price_from" style="font-size:14px;"><?=CURRENCY_SYMBOL?><?=number_format($tour['selling_price'], CURRENCY_DECIMAL)?></span><br>
			</div>
			
			<div class="deal_item_content">				
				<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><img width="135" height="90" class="deal_item_image" src="<?=$this->config->item('tour_135_90_path').$tour['picture']?>" alt="<?=$tour['name']?>"></img></a>
			
				
				<div class="row">
					<a <?php if(strlen($tour['name']) > TOUR_NAME_HOT_DEAL_LIMIT):?> title="<?=$tour['name']?>" <?php endif;?> href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><b><?=character_limiter($tour['name'], TOUR_NAME_HOT_DEAL_LIMIT)?></b></a><br/>				
				</div>
				
				<?php if ($tour['offer_note'] != ''):?>
					
						<?php 
							$offers = explode("\n", $tour['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
								<div class="row special"><span><?=$offer?></span></div>
						<?php endforeach;?>
						
				<?php endif;?>
		
			</div>
		</div>	
		
		<?php 
			$count++;
			if ($count == 3) break;
		?>
	<?php endforeach;?>
	</div>		
</div>

<?php endif;?>


<div class="halong_mekong_deal_area">
	
	<h2 class="highlight" style="border-top: 2px solid #eee"><?=lang('indochina_tours')?></h2>
	
	<?php foreach ($indochina_des as $key=>$des):?>
		<div style="float: left; width: 200px; text-align: center; padding:10px 0 5px 0;<?php if($key <2):?> margin-right:9px;<?php endif;?>"> 
			<a href="<?=url_builder(MODULE_TOURS, $des['url_title'].'-' .MODULE_TOURS)?>">
				<img width="180" alt="<?=$des['name'].ucfirst(lang('tours'))?>" title="<?=$des['name'].ucfirst(lang('tours'))?> " src="<?=$this->config->item('des_220_165_path') . $des['picture_name']?>"/>
			</a>
			
			<div class="clearfix"></div>
			<a style="font-size: 13px; font-weight: bold;" href="<?=url_builder(MODULE_TOURS, $des['url_title'].'-' .MODULE_TOURS)?>"><?=$des['name'].ucfirst(lang('tours'))?></a>
			<span class="block"><b><?=$des['number_tours']?></b> <?=lang('tours') ?></span>
		</div>
	<?php endforeach;?>

</div>


</div>

<?php if(count($hanoi_hotel_deals) > 0):?>

<div class="hotel_deal_area">

	<h2 class="highlight" style="padding-left: 0"><?=lang('hanoi_hotel_deals')?></h2>
	
	<ul>
	<?php foreach ($hanoi_hotel_deals as $key=>$hotel):?>
	 	
	 	<?php if($key <3):?>
	 	
		<li class="hotel_deal_item">
			
			<div class="bpt_item_image" style="width: 80px; height: 60px;">
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>">
					<img width="80" height="60" src="<?=$this->config->item('hotel_80_60_path').$hotel['picture']?>"></img>
				</a>
			</div>
			
			<div class="bpt_item_name">
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
			</div>
			
			<div>
				<?php 
						$star_infor = get_star_infor($hotel['star'], 0);
				?>
				<span style="margin-left: 0" class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
				
				<?php if($hotel['is_new']):?>
					<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
				<?php endif;?>
			</div>
			
			<div class="special" style="padding-top: 5px; font-size: 11px">
				<?=str_replace("\n", "<br>", $hotel['note'])?>
			</div>
		
		</li>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
</div>

<?php endif;?>

<?php if(count($hcm_hotel_deals) > 0):?>

<div class="hotel_deal_area">

	<h2 class="highlight" style="padding-left: 0"><?=lang('hochiminh_hotel_deals')?></h2>
	
	<ul>
	<?php foreach ($hcm_hotel_deals as $key=>$hotel):?>
	 	
	 	<?php if($key <3):?>
	 	
		<li class="hotel_deal_item">
			
			<div class="bpt_item_image" style="width: 80px; height: 60px;">
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>">
					<img width="80" height="60" src="<?=$this->config->item('hotel_80_60_path').$hotel['picture']?>"></img>
				</a>
			</div>
			
			<div class="bpt_item_name">
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
			</div>
			
			<div>
				<?php 
						$star_infor = get_star_infor($hotel['star'], 0);
				?>
				<span style="margin-left: 0" class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
				
				<?php if($hotel['is_new']):?>
					<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
				<?php endif;?>
			</div>
			
			<div class="special" style="padding-top: 5px; font-size: 11px">
				<?=str_replace("\n", "<br>", $hotel['note'])?>
			</div>
		
		</li>
		<?php endif;?>
	<?php endforeach;?>
	</ul>
</div>

<?php endif;?>

<div class="sepearation"></div>

<div style="float: left;width: 100%;">

	<h2 class="highlight" style="padding-bottom: 7px; padding-left: 0">
	<span class="icon icon_tours" style="margin-right: 2px;"></span>		
	<?=lang('top_tour_des')?>
	</h2>
	
	<p class="popular_desc">
		<?=lang('top_tour_description')?>
	</p>
	
	<ul class="list_popular_item">
		<?php foreach ($top_tour_des as  $des):?>
			<li class="popular_item"><a title="<?=$des['name']?>" href="<?=url_builder(MODULE_TOURS, $des['url_title'] . '-' .MODULE_TOURS)?>"><?=$des['name'].' '.ucfirst(lang('tours'))?></a></li>
		<?php endforeach;?>
	</ul>

</div>

<div style="float: left;width: 100%;">
	<h2 class="highlight" style="padding-left: 0">
		<span class="icon icon_hotel" style="margin-right: 2px;*margin-bottom:5px;"></span>
		<?=lang('featured_hotel_des')?>
	</h2>
	
	<p class="popular_desc">
		<?=lang('top_hotel_description')?>
	</p>
	
	<ul class="list_popular_item">
		<?php foreach ($top_hotel_des as $hotel):?>
			<li class="popular_item">
			
				<a title="<?=$hotel['name']?>" href="<?=url_builder(MODULE_HOTELS, $hotel['url_title'] . '-' .MODULE_HOTELS)?>"><?=$hotel['name'].' '.ucfirst(lang("hotels"))?></a>
	
			</li>
		<?php endforeach;?>
	</ul>
</div>

<div style="float: left;width: 100%;">
<h2 class="highlight" style="padding-left: 0">
	<span class="icon icon_cruises" style="margin-right: 2px;*margin-bottom:5px;"></span>
	<?=lang('popular_halong_cruises')?>
</h2>
<p class="popular_desc">
	<?=lang('popular_halong_cruises_description')?>
</p>

<ul class="list_popular_item">
	<?php foreach ($halongcruises as $cruise):?>
		<li class="popular_item">
		
			<a title="<?=$cruise['name']?>" href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
			
			<?php if($cruise['is_new'] == 1):?>
				<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
			<?php endif;?>
		</li>
	<?php endforeach;?>
</ul>
	
</div>

<div style="float: left;width: 100%;">
<h2 class="highlight" style="padding-left: 0">
	<span class="icon icon_cruises" style="margin-right: 2px;*margin-bottom:5px;"></span>
	<?=lang('popular_mekong_river_cruises')?>
</h2>
<p class="popular_desc">
	<?=lang('popular_mekong_cruises_description')?>
</p>

<ul class="list_popular_item">
	<?php foreach ($mekongcruises as $cruise):?>
		<li class="popular_item">
		
			<a title="<?=$cruise['name']?>" href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
			
			<?php if($cruise['is_new'] == 1):?>
				<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
			<?php endif;?>

		</li>
	<?php endforeach;?>
</ul>
	
</div>


<?php 
	$resource_path = $this->config->item('resource_path');
?>

<script type="text/javascript">
function async_load(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = '<?=$resource_path?>/js/home.hotdeals.js';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);

}

var booking_together = "<?=lang('more_saving_desc')?>";
$(function() {
	
	async_load();
	
	$('#booking_together').tipsy({fallback: booking_together, gravity: 's', width: '200px', title: 'Cruise + Hotel = More Savings'});
});

</script>