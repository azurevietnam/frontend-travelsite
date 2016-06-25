<?php if ( !empty($recent_cruises) ):?>
<div class="bpv-box" id="box_recent_items">
	<h3 class="bpv-color-title">
		<?=$recent_items_title?>
	</h3>
		<?php if( isset($is_small_layout) && $is_small_layout ):?>
		
			<?php foreach ($recent_cruises as $k => $cruise):?>
			<div id="ritem-<?=$cruise['item_id']?>" class="bpt-list-sm <?=($k == count($recent_cruises) - 1) ? 'no-border' : ''?>">
				<div class="col-xs-3 no-padding">
					<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
						<img class="img-responsive" src="<?=get_image_path(CRUISE, $cruise['picture'], '120x90')?>">
					</a>
				</div>
				<div class="col-xs-9">
					<ul class="list-unstyled">
						<li class="item-name">
							<a href="<?=cruise_build_url($cruise, $search_criteria)?>" style="font-size: 14px; margin-top: -5px; float: left;"><?=$cruise['name']?></a>
						</li>
						<li style="float: left; clear: both;">
							<span class="icon star-<?=$cruise['star']?>"></span>
						</li>
					</ul>
				</div>
				<div class="del-icon" onclick="not_interested('<?=$cruise['item_id']?>')" style="top: 40%">
					<span class="icon btn-search-close"></span>
				</div>
			</div>
			<?php endforeach;?>
		
		<?php else:?>
		
			<?php foreach ($recent_cruises as $k => $cruise):?>
			<div id="ritem-<?=$cruise['item_id']?>" class="bpt-list-sm <?=($k == count($recent_cruises) - 1) ? 'no-border' : ''?>">
				<div class="col-xs-3 no-padding">
					<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
						<img class="img-responsive" src="<?=get_image_path(CRUISE, $cruise['picture'], '160x120')?>">
					</a>
				</div>
				<div class="col-xs-6">
					<ul class="list-unstyled">
						<li class="item-name">
							<a href="<?=cruise_build_url($cruise, $search_criteria)?>"><?=$cruise['name']?></a>
						</li>
						<li class="item-address"><?=$cruise['address']?></li>
						
						<?php if(!empty($cruise['pro_content'])):?>
						<li class="bpv-color-promotion">
							<span class="icon icon-promotion pull-left"></span> 
							<div class="pull-left"><?=$cruise['pro_content']?></div>
						</li>
						<?php endif;?>
						
						<?php if(isset($cruise['review_score'])):?>
						<li class="item-review">
							<span class="bpv-color-very-good">Rất tốt</span>
							<span class="bpv-color-title">9,1</span>
							<a href="#">20 đánh giá</a>
						</li>
						<?php endif;?>
					</ul>
				</div>
				<?php if (isset($cruise['price_from'])):?>
				<div class="col-xs-3 no-padding price-info">
				
					<?php if ($cruise['price_origin'] != $cruise['price_from']):?>
					<div class="bpv-price-origin">
						<?=bpv_format_currency($cruise['price_origin'])?>
					</div>
					<?php endif;?>
					
					<div class="bpv-price-from"><?=bpv_format_currency($cruise['price_from'])?></div>
				</div>
				<?php endif;?>
				
				<div class="del-icon" onclick="not_interested('<?=$cruise['item_id']?>')">&times;</div>
			</div>
			<?php endforeach;?>
			
		<?php endif;?>
</div>
<?php endif;?>