	<?php if(count($recommendations) > 0 && $show_header):?>
		<div class="border-title-organe margin-bottom-5  margin-top-20">
			<span class="icon icon-extra-saving-green pull-left margin-right-10"></span>
			<h2 class="text-highlight" id="booking_together_section">
				<?=lang('trip_saving_together')?>
			</h2>
		</div>
	
		<div class="margin-bottom-10"><?=lang('group_service_desc')?></div>
	<?php endif;?>
	
	<?php foreach ($recommendations as $key => $recommendation) :?>
	
		<?php
			$block_id = $recommendation['service_id'] == HOTEL ? 'hotel_': 'tour_';
			$block_id = $recommendation['service_id'] == CRUISE ? 'cruise_': $block_id;
			$block_id = $block_id. $recommendation['destination_id'];
		?>
		<?php 
			$icon_type = $recommendation['service_id'] == HOTEL ? 'icon icon-hotel-green' : 'icon icon-tour-green';
			$icon_type = $recommendation['service_id'] == CRUISE ? 'icon icon-cruise-green': $icon_type;
		?>
	<div class="<?=!empty($recommend_css) ? $recommend_css : '' ?> margin-top-20 margin-bottom-20"> <!-- bgr-quick-search -->
		<h3 class="text-highlight" id="block_recommendation_<?=$block_id?>">
			
			<?php if($recommendation['service_id'] == HOTEL):?>
				<span class="icon icon-hotel-green margin-right-5"></span>
			<?php elseif($recommendation['service_id'] == TOUR):?>
				<span class="icon icon-tour-green margin-right-5"></span>
			<?php else:?>
				<span class="icon icon-cruise-green margin-right-5"></span>
			<?php endif;?>
			
			<a show="show" href="javascript:void(0)" onclick="show_block(this, '<?=$block_id?>')" style="text-decoration: underline;"><?=$recommendation['name']?></a>
			<?php if(!empty($hotel) || !empty($tour)):?>
				&nbsp;&nbsp;<span style="font-weight:normal" class="text-special"><?=lang('together')?></span>&nbsp;&nbsp;
				<?php if(isset($hotel)):?>
					<?=$hotel['name']?>
				<?php elseif(isset($tour)):?>					 	
					<?=$tour['name']?>
				<?php endif;?>
			<?php endif;?>
			
		</h3>
		
	<div id="block_search_content_<?=$block_id?>">
		
		<?php foreach ($recommendation['services'] as $key=>$service):?>
			
			<?=load_service_recommend_item($service, $recommendation['service_id'], $current_item_info)?>
				
		<?php endforeach;?>
		
		
			<div class="text-right more-tour">
				
				
				<?php if(!empty($current_item_info)):?>
					<a class="link" href="javascript: void(0)" class="link" onclick="search_more('<?=$block_id?>')"> <?=lang('lb_more')?> <?=$recommendation['name']?></a>
				<?php else:?>
					<?php 
						$recommendation['url_title'] = $recommendation['d_url_title'];
					?>
					<a target="_blank" href="<?=$recommendation['service_id'] == HOTEL ? get_page_url(HOTELS_BY_DESTINATION_PAGE, $recommendation) : get_page_url(TOURS_BY_DESTINATION_PAGE, $recommendation)?>" class="link"><?=$recommendation['name']?></a>
				<?php endif;?>
				<span class="arrow text-special">&raquo;</span>
				<?=load_recommend_form_data($recommendation['destination_id'], $recommendation['service_id'], $block_id, $current_item_info)?>
		
			</div>
		</div>			
	</div>	
<?php endforeach;?>
	
<script type="text/javascript">
	var cal_load = new Loader();
	cal_load.require(
		<?=get_libary_asyn('recommendation')?>, 
      function() {
		      
      });
      
</script>
