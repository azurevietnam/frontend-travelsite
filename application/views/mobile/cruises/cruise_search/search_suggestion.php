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
			<?php if(count($destination_suggestions) > 0):?>
				<?php foreach ($destination_suggestions as $des_type=>$des_arr):?>
					<p><?=$destination_types[$des_type]?></p>					
					<?php foreach ($des_arr as $value):?>
						
						<div class="suggestion-item clearfix">
							<div class="col-1">
								<a href="<?=cruise_search_destination_url($value, $search_criteria)?>">
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
			
			<?php if(count($cruise_suggestions) > 0):?>
			
			<p><?=lang('des_type_cruise')?></p>
			
			<?php foreach ($cruise_suggestions as $cruise):?>
				
				<div class="suggestion-item clearfix">
					<div class="col-1">
						<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
							<?=$cruise['name']?>
						</a>
					</div>
					
					<div class="col-2">
						<span class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></span>
					</div>
					
				</div>
			<?php endforeach;?>
			
			<?php endif;?>
			
		</div>
	</div>
</div>	