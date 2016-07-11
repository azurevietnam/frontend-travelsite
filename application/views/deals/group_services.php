<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h1 class="highlight" style="padding-left: 0">
	<span class="icon icon-saving" style="margin-bottom: -13px; margin-right: 3px;"></span>
	<?=lang('more_saving')?>
</h1>

<div style="float: left; width: 710px; padding-left: 10px; margin-bottom: 7px;">
	<p style="margin: 0"><?=lang('more_saving_desc')?></p>
</div>

<h2 class="highlight"><?=lang('halong_hanoi_hotel')?></h2>

<div style="float: left; width: 718px; border: 1px solid #CCC;">

	<div style="float: left; width: 708px; border-bottom: 1px solid #CCC;padding: 5px 0 5px 10px" class="deal_header_area">
		<div style="width: 425px; float: left; color: #666"">Name</div>
		<div style="width: 100px; float: left; text-align: right; padding-right: 10px; color: #666">Original Price</div>
		<div style="width: 163px; float: left; text-align: right; padding-right: 10px;color: #666""><b>+ Cruise: extra discount</b></div>
	</div>

<?php foreach ($hanoi_hotels as $key => $hotel):?>
	<?php 
		$is_last = ($key == count($hanoi_hotels) - 1);
	?>
	<div style="float: left; width: 708px; <?php if(!$is_last):?> border-bottom: 1px dashed #CCC; <?php endif;?>padding: 5px 0 5px 10px">
		<div class="bpt_item_name" style="width: 425px; float: left;">
			<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
			
			<?php 
				$star_infor = get_star_infor($hotel['star'], 0);
			?>
			<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			
			<?php if($hotel['is_new']):?>
				<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
			<?php endif;?>
						
		</div>
		
		<div style="float: left; width: 100px; text-align: right; padding-right: 10px;">
			<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($hotel['promotion_price'], CURRENCY_DECIMAL)?></span>
		</div>
		
		<div style="float: left; width: 163px; text-align: right; padding-right: 10px;">
			<span class="price_total">-<?=CURRENCY_SYMBOL?><?=$hotel['discount']?></span>
		</div>
	</div>
<?php endforeach;?>
</div>
<div style="float: right; color: #666; font-size: 11px;">* Price per room.night</div>
<div class="clearfix"></div>

<h2 class="highlight"><?=lang('halong_sapa_tour')?></h2>

<div style="float: left; width: 718px; border: 1px solid #CCC;">

<?php foreach ($sapa_tours as $key => $tour):?>
<?php 
	$is_last = ($key == count($sapa_tours) - 1);
?>
	<div style="float: left; width: 708px; <?php if(!$is_last):?> border-bottom: 1px dashed #CCC; <?php endif;?>padding: 5px 0 5px 10px">
		<div class="bpt_item_name" style="width: 425px; float: left;">
			<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><?=$tour['name']?></a>				
		</div>
		
		<?php $price_view = get_tour_price_view($tour); ?>
		
		<div style="float: left; width: 100px; text-align: right; padding-right: 10px;">
			<span class="price_total"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span>
		</div>
		
		<div style="float: left; width: 163px; text-align: right; padding-right: 10px;">
			<span class="price_total">-<?=CURRENCY_SYMBOL?><?=$price_view['discount']?></span>
		</div>
		
	</div>
<?php endforeach;?>
</div>
<div style="float: right; color: #666; font-size: 11px;">* Price per pax</div>
<div class="clearfix"></div>

<h2 class="highlight" style="padding-top: 0"><?=lang('mekong_hcm_hotel')?></h2>

<div style="float: left; width: 718px; border: 1px solid #CCC;">
<?php foreach ($hcm_hotels as $key => $hotel):?>
<?php 
	$is_last = ($key == count($hcm_hotels) - 1);
?>
	<div style="float: left; width: 708px; <?php if(!$is_last):?> border-bottom: 1px dashed #CCC; <?php endif;?>padding: 5px 0 5px 10px">
		<div class="bpt_item_name" style="width: 425px; float: left;">
			<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
			
			<?php 
				$star_infor = get_star_infor($hotel['star'], 0);
			?>
			<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			
			<?php if($hotel['is_new']):?>
				<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
			<?php endif;?>
						
		</div>
	
	
		<div style="float: left; width: 100px; text-align: right; padding-right: 10px;">
			<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($hotel['promotion_price'], CURRENCY_DECIMAL)?></span>
		</div>
		
		<div style="float: left; width: 163px; text-align: right; padding-right: 10px;">
			<span class="price_total">-<?=CURRENCY_SYMBOL?><?=$hotel['discount']?></span>
		</div>
	</div>
<?php endforeach;?>
</div>
<div style="float: right; color: #666; font-size: 11px;">* Price per room.night</div>
<div class="clearfix"></div>