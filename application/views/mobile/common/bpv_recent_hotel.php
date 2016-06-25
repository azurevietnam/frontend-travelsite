<?php if ( !empty($recent_hotels) ):?>

		<?php if( isset($is_small_layout) && $is_small_layout ):?>
		<div class="bpv-box" id="box_recent_items">
			<h3 class="bpv-color-title">
				<?=$recent_items_title?>
			</h3>
			<?php foreach ($recent_hotels as $k => $hotel):?>
			<div id="ritem-<?=$hotel['item_id']?>" class="bpt-list-sm <?=($k == count($recent_hotels) - 1) ? 'no-border' : ''?>">
				<div class="col-xs-3 no-padding">
					<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
						<img class="img-responsive" src="<?=get_image_path(HOTEL, $hotel['picture'],'120x90')?>">
					</a>
				</div>
				<div class="col-xs-9">
					<ul class="list-unstyled">
						<li class="item-name">
							<a href="<?=hotel_build_url($hotel, $search_criteria)?>" style="font-size: 14px; margin-top: -5px; float: left;"><?=$hotel['name']?></a>
						</li>
						<li style="float: left; clear: both;">
							<span class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></span>
						</li>
					</ul>
				</div>
				<div class="del-icon" onclick="not_interested('<?=$hotel['item_id']?>')" style="top: 40%">
					<span class="icon btn-search-close"></span>
				</div>
			</div>
			<?php endforeach;?>
		</div>
		<?php else:?>
		<div class="bpv-unbox" id="box_recent_items">
			<h2 class="bpv-color-title">
				<?=$recent_items_title?>
			</h2>
			<?php foreach ($recent_hotels as $k => $hotel):?>
			<div id="ritem-<?=$hotel['item_id']?>" class="bpt-list-sm <?=($k == count($recent_hotels) - 1) ? 'no-border' : ''?>" style="padding-left: 0">
				<div class="col-xs-2 no-padding">
					<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
						<img class="img-responsive" src="<?=get_image_path(HOTEL, $hotel['picture'],'160x120')?>">
					</a>
				</div>
				<div class="col-xs-6">
					<a class="item-name" href="<?=hotel_build_url($hotel, $search_criteria)?>"><?=$hotel['name']?></a>
					<p class="item-address"><?=$hotel['address']?></p>
				</div>
				<?php if (isset($hotel['price_from'])):?>
				<div class="col-xs-3 no-padding price-info">
					<?php if ($hotel['price_origin'] != $hotel['price_from']):?>
					<div class="bpv-price-origin">
						<?=bpv_format_currency($hotel['price_origin'])?>
					</div>
					<?php endif;?>
					
					<div class="bpv-price-from"><?=bpv_format_currency($hotel['price_from'])?></div>
				</div>
				<?php endif;?>
				
				<div class="del-icon" onclick="not_interested('<?=$hotel['item_id']?>')">&times;</div>
			</div>
			<?php endforeach;?>
		</div>	
		<?php endif;?>
<?php endif;?>