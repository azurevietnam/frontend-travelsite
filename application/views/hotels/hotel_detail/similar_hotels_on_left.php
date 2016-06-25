<?php if(count($s_hotels)):?>
<div class="bpv-box" id="box_recent_items">
	<h3 class="bpv-color-title">
		<?=lang('same_class_hotels')?>
	</h3>
	<?php foreach ($s_hotels as $k => $similar_hotel):?>
		<div class="bpt-list-sm <?=($k == count($s_hotels) - 1) ? 'no-border' : ''?>">
			<div class="col-xs-3 no-padding">
				<a href="<?=hotel_build_url($similar_hotel, $search_criteria)?>">
					<img class="img-responsive" src="<?=get_image_path(HOTEL, $similar_hotel['picture'],'120x90')?>">
				</a>
			</div>
			<div class="col-xs-9" style="padding-right:0">
				<div class="item-name clearfix">
					<a href="<?=hotel_build_url($similar_hotel, $search_criteria)?>" style="font-size: 14px; margin-top: -5px; float: left;"><?=$similar_hotel['name']?></a>
				</div>
				
				<div class="clearfix" style="margin-top:3px">
					<span class="icon star-<?=$similar_hotel['star']?>"></span>
					<span class="pull-right">
					<?php if(isset($similar_hotel['price_from'])):?>
						<!-- 
						<?php if($similar_hotel['price_from'] != $similar_hotel['price_origin']):?>
							<span class="bpv-price-origin" style="font-size:12px"><?=number_format($similar_hotel['price_origin'])?> <?=lang('vnd')?></span>
						<?php endif;?>
						 -->
							<span class="bpv-price-from" style="font-size:13px;line-height:0;font-weight:normal;"><?=number_format($similar_hotel['price_from'])?> <?=lang('vnd')?></span>
					<?php endif;?>
					</span>	
				</div>
					
			</div>
		</div>
	<?php endforeach;?>
	
	<div style="padding:15px; text-align: right;">
	
		<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
		
		<?php 
			$url_params['star'] = floor($hotel['star']);
		?>
	
		<a href="<?=get_url(HOTEL_SEARCH_PAGE, $url_params)?>">
			<?php 
				
				echo lang_arg('view_more_hotel_same_class', $hotel['destination_name']);
			?>
		</a>
		
	</div>
</div>
<?php endif;?>
