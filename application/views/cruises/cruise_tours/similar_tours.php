<?php if(!empty($s_tours)):?>
<div class="bpv-box" id="box_recent_items">
	<h3 class="bpv-color-title">
		<?=lang('similar_cruise_tours')?>
	</h3>
	<?php foreach ($s_tours as $k => $tour):?>
	<div class="bpt-list-sm <?=($k == count($s_tours) - 1) ? 'no-border' : ''?>">
		<div class="col-xs-3 no-padding">
			<a href="<?=cruise_tour_build_url($tour, $search_criteria)?>">
				<img class="img-responsive" src="<?=get_image_path(CRUISE_TOUR, $tour['picture'],'120x90')?>">
			</a>
		</div>
		<div class="col-xs-9 pd-right-0">
			<ul class="list-unstyled">
				<li class="item-name">
					<a href="<?=cruise_tour_build_url($tour, $search_criteria)?>" style="font-size: 14px; margin-top: -5px; float: left;"><?=$tour['name']?></a>
				</li>
				<li style="float: left; clear: both; width: 100%">
					<span class="icon star-<?=str_replace('.', '_', $tour['star'])?>"></span>
					<?php if(!empty($tour['price_from'])):?>
					<span class="pull-right">
                        <span class="bpv-price-from" style="font-size:13px;line-height:0;font-weight:normal;">
                        	<?=bpv_format_currency($tour['price_from'])?>
                        	<small class="price-unit" <?php if ($tour['price_origin'] != $tour['price_from'])?>><?=lang('/pax')?></small>
                        </span>
					</span>
					<?php endif;?>
				</li>
			</ul>
		</div>
	</div>
	<?php endforeach;?>
</div>
<?php endif;?>