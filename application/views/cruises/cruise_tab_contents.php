<div id="tabs">
		
		<ul class="bpt-tabs">
			<li><a href="#cruise_photos_videos"><?=lang('check_rates')?></a></li>
			
			<li><a href="#cruise_itinerary"><?=lang('cruise_program_itinerary')?></a></li>
			
			<li><a href="#cruise_policies"><?=lang('cruise_policies_tab')?></a></li>
			
			<li><a href="#cruise_properties"><?=lang('cruise_facilities_deckplan')?></a></li>
			
			<?php if(count($cruise['upload_files']) > 0):?>
			<li><a href="#cruise_resources"><?=lang('cruise_resouces')?></a></li>
			<?php endif;?>
		</ul>	
		
		<div id="cruise_photos_videos">
			
			<div id="cruise_detail" style="border: 0">
				
				<?=$check_rate_form?>
				
				<div class="clearfix"></div>
				
				<?php if($selected_tour === FALSE || empty($action)):?>
				
					<?=$cruise_cabins?>
				
				<?php else:?>
					
					<?=$cabin_rates?>
					
				<?php endif;?>
							
			</div>
			
			<div class="back_to_top"><span class="icon icon-btn-up"></span><a href="javascript:void(0)" onclick="back_to_top()"><?=lang('back_to_top')?></a></div>
			
			<!-- 
			<p class="item_text_desc"><?=lang('cruise_photos_description')?> <b><?=$cruise['name']?>:</b></p>
			 -->
			 
			<div class="item_header">
				<h3><span><?=$cruise['name']?> <?=lang('cruise_photos')?></span></h3>
			</div>
			
			<div style="float: left;" id="cruise_photos">
				<?=$cruise_photos_view?>
			</div>	
			
			<?php if($videos_view != ''):?>
			
				<div class="back_to_top"><span class="icon icon-btn-up"></span><a href="javascript:void(0)" onclick="back_to_top()"><?=lang('back_to_top')?></a></div>
				
				<div class="item_header">
					<h3><span><?=$cruise['name']?> <?=lang('label_videos')?></span></h3>
				</div>
				
			<?php endif;?>
			
			<div style="float: left;" id="cruise_videos">	
				<?=$videos_view?>
			</div>
				
		</div>
		
		<div id="cruise_itinerary">
			
			<?=$cruise_itineraries?>
			
		</div>

		<div id="cruise_policies">
			
			<p class="item_text_desc"><span><?=lang('cruise_policies_description')?><b><?=$cruise['name']?></b>:</span></p>
			
			<?php if($selected_tour !== FALSE):?>
			
			<div class="policy" style="padding-top: 0;">
				<div class="policy_item highlight">
					<p>						
						<?=lang('label_cancellation_by_customer')?>:
					</p>
				</div>
				
				<div class="policy_content">
					<ul>
						<?php foreach ($selected_tour['policies']['cancellation'] as $item) :?>
						<?php if ($item != '') :?>
							<li><?=$item?></li>
						<?php endif;?>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<?php if($cancellation_weather != ''):?>
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('label_cancellation_policy_due_to_bad_weather')?>:
					</p>
				</div>
				
				<div class="policy_content">					
					<?=$cancellation_weather?>
				</div>
			</div>
			
			<?php endif;?>
			
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('children_extrabed')?>:
					</p>
				</div>
				
				<div class="policy_content">
					<ul>
						<?php foreach ($selected_tour['policies']['children_extrabed'] as $item) :?>
						<?php if ($item != '') :?>
							<li><?=$item?></li>
						<?php endif;?>	
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			
			<?php endif;?>
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('cruise_shuttle_bus')?>
					</p>
				</div>
				
				<div class="policy_content">
					<p><?=$cruise['shuttle_bus']?></p>
				</div>
			</div>
			
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('cruise_check_in')?>
					</p>
				</div>
				
				<div class="policy_content">
					<p><?=$cruise['check_in']?></p>
				</div>
			</div>
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('cruise_check_out')?>
					</p>
				</div>
				
				<div class="policy_content">
					<p><?=$cruise['check_out']?></p>
				</div>
			</div>
			
			<div class="policy">
				<div class="policy_item highlight">
					<p>						
						<?=lang('cruise_guide')?>
					</p>
				</div>
				
				<div class="policy_content">
					<p><?=$cruise['guide']?></p>
				</div>
			</div>
						
			<?php if ($cruise['note'] != ''):?>
				
				<div class="policy">
					<div class="policy_item highlight">
						<p>						
							<?=lang('cruise_other_notice')?>
						</p>
					</div>
					
					<div class="policy_content">
						<p><?=str_replace("\n", "<br>", $cruise['note'])?></p>
					</div>
				</div>
			<?php endif;?>
			
		</div>
				
		<div id="cruise_properties">
		
			<p class="item_text_desc"><?=lang('cruise_facility_description')?><b><?=$cruise['name']?></b>:</p>
			
			<h2 style="padding-left: 0; padding-top: 0" class="highlight" ><?=lang('facility_general')?></h2>
			
			<div class="facility">	
					<ul>
						<?php foreach ($cruise_facilities[CRUISE_FACILITY_GENERAL] as $value) :?>									
							
							
							<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																														
						<?php endforeach ;?>				
					</ul>
			</div>
			
			<h2 style="padding-left: 0; padding-top: 0" class="highlight"><?=lang('facility_services')?></h2>
			<div class="facility"> 
					<ul>
						<?php foreach ($cruise_facilities[CRUISE_FACILITY_SERVICE] as $value) :?>									
							<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>																									
						<?php endforeach ;?>
						
					</ul>
			</div>
			
			<h2 style="padding-left: 0; padding-top: 0" class="highlight"><?=lang('facility_activities')?></h2>
			<div class="facility">			
					<ul>
						<?php foreach ($cruise_facilities[CRUISE_FACILITY_ACTIVITY] as $value) :?>											
							<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
						<?php endforeach ;?>				
					</ul>
			</div>
			
			<div style="float: left; width: 100%;" id="cruise_properties_deckplans">
				<?/*=$properties_deckplans_view*/?>
			</div>
		</div>
		
	
		<?php if(count($cruise['upload_files']) > 0):?>
		<div id="cruise_resources">
				<p class="item_text_desc"><?=lang('label_cruise_sources_for_download')?>:</b></p>
					
				<ul>
					<?php foreach ($cruise['upload_files'] as $file):?>		
						
						<li>
							<a href="/cruise_detail/download/<?=$file['name']?>" title="<?=$file['description']?>">
								<?php if($file['title'] != ''):?>
									<?=$file['title']?>
								<?php else:?>
									<?=$file['name']?>
								<?php endif;?>
							</a>
						</li>
					
					<?php endforeach;?>	
				</ul>
			
		</div>
		<?php endif;?>
</div>

<div class="back_to_top"><span class="icon icon-btn-up"></span><a href="javascript:void(0)" onclick="back_to_top()"><?=lang('back_to_top')?></a></div>