<?php if(count($hotel_facilities) > 0):?>
	<div class="bpv-collapse margin-top-10">
		<h5 class="heading no-margin" data-target="#hotel_facilities">
    		<i class="icon icon-star-white"></i>
        	<?=lang('hotel_facility_of')?> <?=lang('hotel_txt')?>
        	<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
        </h5>
    	<div id="hotel_facilities" class="content hotel-facility">
        <?php 
			$fa_index  = 0;
		?>
		<?php foreach ($hotel_facilities as $key=>$facility_values):?>
			<div class="clearfix margin-bottom-10">
				<div class="item-title bpv-color-title">
					<?=$facility_groups[$key]?>
				</div>
				
				<div class="col-xs-12 no-padding">
					<?php foreach ($facility_values as $value):?>
						<div class="col-xs-6 pd-left-0">
							<img alt="" src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>" class="margin-right-5">
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

		<div class="bpv-collapse margin-top-2">
		    <h5 class="heading no-margin" data-target="#hotel_detail_desc">
				<i class="icon icon-star-white"></i>
				<?=lang('hotel_description_of')?> <?=lang('hotel_txt')?>
				<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
			</h5>
			
			<div id="hotel_detail_desc" class="content">
				<p>
					<?=$hotel['description']?>
				</p>
				
				<h3 class="margin-top-20 bpv-color-title"><?=lang('hotel_policy_of')?> <?=$hotel['name']?></h3>
				
				<div>
					<?=lang('checkin_time')?> : <span class="bpv-color-title"><?=$hotel['check_in']?></span>
				</div>
				
				<div>
					<?=lang('checkout_time')?> : <span class="bpv-color-title"><?=$hotel['check_out']?> </span>
				</div>
	
				<div>
					<h4 class="bpv-color-title"><?=lang('checkin_policy')?>:</h4>
					<p>
						<?=lang('checkin_policy_content')?>
					</p>
				</div>
				
				<div>
					<h4 class="bpv-color-title"><?=lang('cancellation_policy')?>:</h4>
					<p>
						<?=lang('cal_content_1')?>
					</p>
					
					<p>
						<span class="bpv-color-title"><span class="glyphicon glyphicon-asterisk"></span> <?=lang('cal_content_2')?>:</span>
						<br>
						<?php if(!empty($hotel['extra_cancellation'])):?>
							<?=$hotel['extra_cancellation']?>
						<?php else:?>
							<?=$default_cancellation['content']?>
						<?php endif;?>
					</p>
					
					<p>
						<span class="bpv-color-title"><span class="glyphicon glyphicon-asterisk"></span> <?=lang('cal_content_3')?>:</span>
						<br>
						<?=lang('cal_content_4')?>
					</p>
				</div>
				
		
				
				
				<div>
					<h4 class="bpv-color-title"><?=lang('children_extra_bed')?>:</h4>
					<p>
						<b><?=str_replace('<year>', $hotel['infant_age_util'], lang('infant_policy_label'))?>:</b> <?=$hotel['infants_policy']?>
					</p>
					
					<p>
						<?php 
							$chd_txt = lang('children_policy_label');
							$chd_txt = str_replace('<from>', $hotel['infant_age_util'], $chd_txt);
							$chd_txt = str_replace('<to>', $hotel['children_age_to'], $chd_txt);
						?>
						<b><?=$chd_txt?>:</b> <?=$hotel['children_policy']?>
					
					</p>
					
					<p>
						<?=str_replace('<year>',$hotel['children_age_to'],lang('adults_info'))?>
						<br>
						<?=lang('extra_bed_info')?>
					</p>
					
				</div>
			</div>
		</div>


		<?php if(!empty($des_around)) :?>
		<div class="bpv-collapse margin-top-2">
			<h5 class="heading no-margin" data-target="#useful-info">
				<i class="icon icon-star-white"></i>
					<?=lang('useful_information')?>
				<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
			</h5>
			
			<div id="useful-info" class="col-item-content content">
				<?php if( !empty($des_around['attractions']) ):?>
				<h4 class="margin-top-15 bpv-color-title"><b><?=lang_arg('distance_to', lang('near_attraction'))?></b></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['attractions'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['area']) ):?>
				<h4 class="margin-top-15 bpv-color-title"><b><?=lang_arg('distance_to', strtolower(lang('area')))?></b></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['area'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['shopping_areas']) ):?>
				<h4 class="margin-top-15 bpv-color-title"><b><?=lang_arg('distance_to', strtolower(lang('shopping_areas')))?></b></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['shopping_areas'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
					
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['airport']) ):?>
				<h4 class="margin-top-15 bpv-color-title"><b><?=lang_arg('distance_to', lang('airport'))?></b></h4>
				<ul class="list-unstyled">
					<?php foreach ($des_around['airport'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
				</ul>
				<?php endif;?>
				
				<?php if( !empty($des_around['train_station']) || !empty($des_around['bus_stop']) ):?>
				<h4 class="margin-top-15 bpv-color-title"><b><?=lang_arg('distance_to', lang('public_transport'))?></b></h4>
				<ul class="list-unstyled">
					<?php if( !empty($des_around['train_station']) ):?>
					<?php foreach ($des_around['train_station'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
					<?php endif;?>
					
					<?php if( !empty($des_around['bus_stop']) ):?>
					<?php foreach ($des_around['bus_stop'] as $k => $des):?>
					<li>
						<a target="_blank" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
						<span style="float:right;"><?=distance($hotel['latitude'], $hotel['longitude'], $des['latitude'], $des['longitude'])?></span>
					</li>
					<div class="sep-line"></div>
					<?php endforeach;?>
					<?php endif;?>
				</ul>
				<?php endif;?>
			</div>
		</div>
		<?php endif;?>
		
		
		<div class="bpv-collapse margin-top-2">
		    <h5 class="heading no-margin" data-target="#show_hotel_map_mobile">
				<i class="icon icon-star-white"></i>
				<?=lang('view_map')?> <?=lang('hotel_txt')?>
				<i class="bpv-toggle-icon icon icon-arrow-right-white icon-arrow-right-white-up"></i>
			</h5>
			
			<div id="show_hotel_map_mobile" style="display:block">
				<div class="bpv-maps" id="hotel_des_map" style="height:380px; width:100%"
					data-lat="<?=$hotel['latitude']?>" 
					data-lng="<?=$hotel['longitude']?>" 
					data-place-name="<?=$hotel['name']?>" 
					data-hotel-id="<?=$hotel['id']?>" 
					data-des-id="<?=$hotel['destination_id']?>" 
					data-star="<?=$hotel['star']?>">
				</div>
				<div class="pd-10">
					<div class="row">
						<div class="col-xs-12">
				 			<span class="icon-hotel1"><?=lang('hm_hotel')?></span>
				 			
							<div class="checkbox checkbox-inline">
				 				<label>
				 					<input type="checkbox" id="hm_show_hotel" checked="checked" onclick="filter_map_data()"> <?=lang('hm_view_hotel')?>
				 				</label>
				 			</div>
				 		</div>
				 	</div>
				 	<div class="row">
				 		<div class="col-xs-12">
					 		<span class="icon-place1"><?=lang('hm_destination')?></span>
					 		<div class="checkbox checkbox-inline" style="margin-top: 10px;">
				 				<label>
				 					<input type="checkbox" id="hm_show_des" onclick="filter_map_data()"> <?=lang('hm_view_destination')?>
				 				</label>
					 		</div>
					 	</div>
				 	</div>		 	
			 	</div>
			 	
				<div class="star-filter" style="border: 1px solid #94c9ec; display:none">
					<?php for($i=1; $i <= 5; $i++):?>
				
						<div class="checkbox" >
		 					<label>
		 						<input type="checkbox" class="hm-filter-stars" value="<?=$i?>" checked="checked" onclick="filter_map_data()">
		 						<span class="icon star-<?=$i?>"></span>
		 					</label>
		 				</div>
				
					<?php endfor;?>
				</div>
			</div>
		</div>
