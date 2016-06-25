<div class="bpv-box margin-top-20">
	<h3 class="box-heading no-margin"><?=lang('hotel_by_filters') . ' ' . $city['name']?></h3>
	
	<?php 
		$search_info['destination'] = $search_criteria['destination'];
		$search_info['startdate'] = $search_criteria['startdate'];
		$search_info['enddate'] = $search_criteria['enddate'];
		$search_info['night'] = $search_criteria['night'];
		$search_info['oid'] = $search_criteria['oid'];
	?>
							
	<div class="tab-content bpv-in-and-around">
		<div class="row">
			
			<ul class="col-xs-12 list-unstyled">
				<li class="sub-title">
					<span class="glyphicon glyphicon-usd"></span> <?=lang('filter_price')?>
				</li>	
				
				<?php foreach ($filter_price as $value):?>
					<?php if($value['number'] > 0):?>
						<li>
							
							<?php 
								$search_info['price'] = $value['value'];
							?>
							
							<a href="<?=get_url(HOTEL_SEARCH_PAGE, $search_info)?>">
								<?=$value['label']?>
							</a>
						
							<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
						</li>
					<?php endif;?>
				<?php endforeach;?>
		
			</ul>
		</div>	
		<div class="row">
			<ul class="col-xs-12 list-unstyled">
				<li class="sub-title"><span class="icon star-1"></span> <?=lang('filter_star')?></li>
				
				<?php foreach ($filter_star as $value):?>
					<?php if($value['number'] > 0):?>
					<li>
						<?php 
							unset($search_info['price']);
							$search_info['star'] = $value['value'];
						?>
						<a href="<?=get_url(HOTEL_SEARCH_PAGE, $search_info)?>">
							<?=$value['label']?>
						</a>
						<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
					</li>
					<?php endif;?>
				<?php endforeach;?>	
			
			</ul>
		
		</div>
		
		<div class="row">
			<div class="col-xs-12" style="margin-bottom:7px; margin-left:5px;"><span class="glyphicon glyphicon-asterisk"></span> <?=lang('filter_facility')?></div>
			<?php foreach ($filter_facility as $value):?>
				<?php if($value['number'] > 0 && $value['is_important']):?>
					<div class="col-xs-12" style="margin-bottom:7px; padding-left:15px;">
						<?php 
							unset($search_info['price']);
							unset($search_info['star']);
							$search_info['facility'] = $value['value'];
						?>
						<a href="<?=get_url(HOTEL_SEARCH_PAGE, $search_info)?>">
							<?=$value['label']?>
						</a>
						<span class="help-block" style="display:inline">(<?=$value['number']?>)</span>
					</div>
				<?php endif;?>
			<?php endforeach;?>
		
		</div>
	</div>
</div>
