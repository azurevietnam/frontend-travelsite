<div class="info-box">
	<div class="title"><?=$hotel['name']?> <span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span></div>
	<table class="details">
		<tr>
			<td>
				<img width="90" height="68" src="<?=get_image_path(HOTEL, $hotel['picture'],'160x120')?>">
			</td>
			<td>
				<?=$hotel['address']?>
				<?php if( isset($hotel['price_from']) ):?>
		
				<?php if($hotel['price_origin'] != $hotel['price_from']):?>
					<div class="bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></div>
				<?php endif;?>
				
				<div class="bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></div>
				
				<?php endif;?>
			</td>
		</tr>
	</table>
</div>