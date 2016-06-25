<div class="bpv-box cruise-itinerary">
	<h2 class="bpv-color-title"><?=lang('cruise_tours_title'). $cruise['name']?></h2>
	<div class="content">
		<?php
			$highlights = $tour['tour_highlight'];
			
			$highlights = explode("\n", $highlights);
		?>
		<?php if(count($highlights) > 0):?>

			<h4><?=lang('tour_highlight')?></h4>

			<ul class="tour-highlight">
				<?php foreach ($highlights as $value):?>
					<?php if(!empty($value)):?>
					<li class="margin-bottom-10"><?=$value?></li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
			
		<?php endif;?>
		
		<div class="panel-group" id="accordion">
			<?php foreach ($tour['itinerary'] as $idx => $itinerary):?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<a class="itinerary-day" data-toggle="collapse" href="#collapse_<?=$idx?>">
							<h4 class="panel-title">
								<?=$itinerary['title']?>
								<span class="icon icon-btn-more"></span>
							</h4>
						</a>
					</div>
					<div id="collapse_<?=$idx?>" class="panel-collapse collapse in">
						<div class="panel-body">
						<?php if(count($itinerary['photos']) == 1):?>
							<ul class="itinerary-photos">
								<?php foreach ($itinerary['photos'] as $photo):?>
								<li class="photo">
									<?php if(!empty($photo['cruise_id'])):?>
									<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
										<img class="img-responsive" width="268" height="201" src="<?=get_image_path(CRUISE, $photo['name'], '268x201')?>">
									</a>
									<?php else:?>
									<a href="<?=get_image_path(CRUISE_TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
										<img class="img-responsive" width="268" height="201" src="<?=get_image_path(CRUISE_TOUR, $photo['name'], '268x201')?>">
									</a>
									<?php endif;?>
								</li>
								<li class="caption"><?=$photo['caption']?></li>
								
								<?php endforeach;?>
							</ul>
						<?php else:?>
							<ul class="itinerary-photos" style="width: 200px">
								<?php foreach ($itinerary['photos'] as $photo):?>
								<li class="photo">
									<?php if(!empty($photo['cruise_id'])):?>
										<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
											<img class="img-responsive" width="200" height="150" src="<?=get_image_path(CRUISE, $photo['name'], '200x150')?>">
										</a>
									<?php else:?>
										<a href="<?=get_image_path(CRUISE_TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
											<img class="img-responsive" width="200" height="150" src="<?=get_image_path(CRUISE_TOUR, $photo['name'], '200x150')?>">
										</a>
									<?php endif;?>
								</li>
								<li class="caption margin-bottom-5"><?=$photo['caption']?></li>
								
								<?php endforeach;?>
							</ul>
						<?php endif;?>
							<div style="line-height: 22px;">
								<?=insert_data_link($itinerary['content'])?>
							</div>
							
							<?php if(!empty($itinerary['meals'])):?>
							<div class="margin-bottom-5">
								<b>
								<?=lang('meals')?>: <?=get_tour_meals($itinerary['meals'])?>
								</b>
							</div>
							<?php endif;?>
							
							<?php if(!empty($itinerary['accommodation'])):?>
							<div class="margin-bottom-5">
								<b>
									<?=lang('itinerary_accommodation')?>: <?=strip_tags($itinerary['accommodation'])?>
								</b>
							</div>
							<?php endif;?>
							
							<?php if(!empty($itinerary['activities'])):?>
							<div class="margin-bottom-5">
								<b>
									<?=lang('itinerary_activities')?> <?=strip_tags($itinerary['activities'])?>
								</b>
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			<?php endforeach;?>
			
			
			<div class="margin-top-10">
				<span class="bpv-color-price"><b><?=lang('important_notes')?></b></span>
				<ul class="bpv-color-price">
					<li><?=lang('tour_default_notes_1')?></li>
					<li><?=lang('tour_default_notes_2')?></li>
					<li><?=lang('tour_default_notes_3')?></li>
					<li><?=lang('tour_default_notes_4')?></li>
					<?php if(!empty($tour['notes'])):?>
					<li><?=$tour['notes']?></li>
					<?php endif;?>
				</ul>
			</div>
			
		</div>
	</div>
</div>