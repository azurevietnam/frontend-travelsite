<div class="container">
 	<?=$bpv_search?>
 	
	<div class="hotel-search-suggestion center-block">
		
		<h1>
			<?php if(isset($no_suggestion)):?>
				<?=lang('no_search_results_of_keyword')?>
			<?php else:?>
				<?=lang('search_results_of_keyword')?>
			<?php endif;?> 
			<span class="bpv-color-title"><?=$search_criteria['destination']?></span>
		</h1>
		<div class="search-results">
		<?php if(count($hotel_suggestions) > 0):?>
			
				<p><?=lang('des_type_hotel')?></p>
				
				<?php foreach ($hotel_suggestions as $k=>$hotel):?>
					
					<?php 
						$no_border = $k == count($hotel_suggestions) - 1 ? 'no-border': '';
						$hidden_class = $k > 4 ? 'hidden-item' : '';
					?>
					
					<div class="row suggestion-item clearfix <?=$hidden_class?> <?=$no_border?>" <?php if($k > 4):?> style="display:none"<?php endif;?>>
						<div class="col-xs-8">
							<a href="<?=hotel_build_url($hotel, $search_criteria)?>">
								<?=$hotel['name']?>
							</a>
						</div>
						
						<div class="col-xs-4">
							<?=$hotel['destination_name']?>
						</div>
						
					</div>
				<?php endforeach;?>
				
				<?php if(count($hotel_suggestions) > 5):?>
					<div class="margin-top-10">
						<a class="bpv-color-promotion" style="font-size:14px" href="javascript:void(0)" onclick="show_more(this)" show="hide"><?=lang('view_more_places')?></a>
					</div>
				<?php endif;?>
				 
		
			
		<?php endif;?>
		
		<?php if(count($destination_suggestions) > 0):?>
			
			<?php foreach ($destination_suggestions as $des_type=>$des_arr):?>
				<p><?=$destination_types[$des_type]?></p>
				 
				<?php foreach ($des_arr as $k=>$value):?>
			
					<div class="suggestion-item clearfix <?php if($k == count($des_arr)-1):?>no-border<?php endif;?>"">
						<div class="col-1">
							<a href="<?=hotel_search_destination_url($value, $search_criteria)?>">
								<?=$value['name']?>
							</a>
						</div>
						<div class="col-2">
							<?=$value['parent_name']?>
						</div>
					</div>
					
				<?php endforeach;?>
				  
			<?php endforeach;?>
		<?php endif;?>
		</div>
	</div>
</div>