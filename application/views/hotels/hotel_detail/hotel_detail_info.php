<?php if(count($hotel_facilities) > 0):?>
	<div class="bpv-box">
		<h2 class="bpv-color-title"><?=lang('hotel_facility_of')?> <?=$hotel['name']?></h2>
		<div class="content hotel-facility">
		<?php 
			$fa_index  = 0;
		?>
		<?php foreach ($hotel_facilities as $key=>$facility_values):?>
	
			<div class="item clearfix" <?php if($fa_index == count($hotel_facilities) - 1):?> style="border-bottom:0"<?php endif;?>>
				<div class="col-item-title bpv-color-title">
					<?=$facility_groups[$key]?>
				</div>
				
				<div class="col-item-content">
					<?php foreach ($facility_values as $value):?>
						<div class="col-fa">
							<img alt="" src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>" style="margin-right:3px">
							<span <?php if($value['is_important']):?>style="color:#4eac00;"<?php endif;?>>
							<?=$value['name']?>
							</span>	
						</div>
					<?php endforeach;?>
				</div>
			</div>	
			
			<?php 
				++$fa_index;
			?>
		
		<?php endforeach;?>
		</div>
	</div>
<?php endif;?>

<div class="bpv-box">
	<h2 class="bpv-color-title"><?=lang('hotel_description_of')?> <?=$hotel['name']?></h2>
	<div class="content hotel-detail-desc">
		<p>
			<?=$hotel['description']?>
		</p>
		
		<h3 class="margin-top-20"><?=lang('hotel_policy_of')?> <?=$hotel['name']?></h3>
		
		<div class="item clearfix">
			<div class="col-item-title bpv-color-title">
				<?=lang('checkin_time')?>
			</div>
			<div class="col-item-content"><?=$hotel['check_in']?></div>
		</div>
		
		<div class="item clearfix">
			<div class="col-item-title bpv-color-title">
				<?=lang('checkout_time')?>
			</div>
			<div class="col-item-content"><?=$hotel['check_out']?></div>
		</div>
		
		<div class="item clearfix">
			<div class="col-item-title bpv-color-title">
				<?=lang('checkin_policy')?>
			</div>
			<div class="col-item-content">
				<?=lang('checkin_policy_content')?>
			</div>
		</div>
		
		<div class="item clearfix">
			<div class="col-item-title bpv-color-title">
				<?=lang('cancellation_policy')?>
			</div>
			<div class="col-item-content">
				<div class="margin-bottom-5"><?=lang('cal_content_1')?></div>
				<div class="margin-bottom-5"><span class="icon icon-asterisk margin-right-5"></span> <?=lang('cal_content_2')?>:</div>
				<div class="margin-bottom-5" style="padding-left:15px">
					<?php if(!empty($hotel['extra_cancellation'])):?>
						<?=$hotel['extra_cancellation']?>
					<?php elseif(!empty($default_cancellation['content'])):?>
						<?=$default_cancellation['content']?>
					<?php endif;?>
				</div>
				
				<div class="margin-bottom-5"><span class="icon icon-asterisk margin-right-5"></span> <?=lang('cal_content_3')?>:</div>
				
				<div class="margin-bottom-5" style="padding-left:15px">
					<?=lang('cal_content_4')?>
				</div>
				
			</div>
		</div>
		
		<div class="item clearfix" <?php if(empty($des_around)) echo 'style="border-bottom:0"' ;?>>
			<div class="col-item-title bpv-color-title">
				<?=lang('children_extra_bed')?>
			</div>
			<div class="col-item-content">
				<table width="100%" class="margin-bottom-10">
					<tr>
						<td class="td-1"><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $hotel['infant_age_util'], lang('infant_policy_label'))?></td>
						<td class="td-2"><?=$hotel['infants_policy']?></td>
					</tr>
					<tr>
						<td>
							<span class="icon icon-child margin-right-5"></span>
							<?php 
								$chd_txt = lang('children_policy_label');
								$chd_txt = str_replace('<from>', $hotel['infant_age_util'], $chd_txt);
								$chd_txt = str_replace('<to>', $hotel['children_age_to'], $chd_txt);
							?>
							<?=$chd_txt?>
						</td>
						<td><?=$hotel['children_policy']?></td>
					</tr>
				</table>
				
				<div class="margin-bottom-10"><span class="icon icon-asterisk margin-right-5"></span> <?=str_replace('<year>',$hotel['children_age_to'],lang('adults_info'))?></div>
				<div><span class="icon icon-asterisk margin-right-5"></span> <?=lang('extra_bed_info')?></div>
				
			</div>
		</div>
		
		<?php if(!empty($des_around)) :?>
		<div class="item clearfix" style="border-bottom:0">
			<div class="col-item-title bpv-color-title">
				<?=lang('useful_information')?>
			</div>
			<div class="col-item-content useful-info">
				<?php if( !empty($des_around['attractions']) ):?>
				<h4><?=lang_arg('distance_to', lang('near_attraction'))?></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['attractions'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['area']) ):?>
				<h4><?=lang_arg('distance_to', strtolower(lang('area')))?></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['area'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['shopping_areas']) ):?>
				<h4><?=lang_arg('distance_to', strtolower(lang('shopping_areas')))?></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['shopping_areas'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['airport']) ):?>
				<h4><?=lang_arg('distance_to', lang('airport'))?></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['airport'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['train_station']) || !empty($des_around['bus_stop']) ):?>
				<h4><?=lang_arg('distance_to', lang('public_transport'))?></h4>
				<ul class="list-unstyled">
					<?php if( !empty($des_around['train_station']) ):?>
					<?php foreach ($des_around['train_station'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
					<?php endif;?>
					
					<?php if( !empty($des_around['bus_stop']) ):?>
					<?php foreach ($des_around['bus_stop'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<?php endforeach;?>
					<?php endif;?>
				</ul>
				<?php endif;?>
			</div>
		</div>
		<?php endif;?>
		 
	</div>
</div>

