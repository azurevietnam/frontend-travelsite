<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
 

	<h2 class="highlight" style="padding-left: 0">
		<?=lang('hotel_my_viewed_hotels')?>
	</h2>
	
	<?php foreach ($my_viewed_hotels as $hkey => $hotel):?>
		<div class="bpt_item" style="width: 240px;">
			<div class="bpt_item_name">
				<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
				<?php 
					$star_infor = get_star_infor($hotel['star'], 0);
				?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
					
			</div>
		
			<div class="row hotel_address">
			
				<?=$hotel['location']?>
				
			</div>

		</div>
	<?php endforeach;?>

	 
	<div style="height: 10px; width: 100%; float: left;">&nbsp;</div>
	<script>
		number_display_viewed_hotel = <?=count($my_viewed_hotels)?>
	</script>
