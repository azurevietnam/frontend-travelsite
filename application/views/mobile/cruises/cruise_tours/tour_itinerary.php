<div class="bpv-collapse">
	<h5 class="heading no-margin" data-target="#tour_itinerary">
		<i class="icon icon-star-white"></i>
		<?=lang('tour_itinerary')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	<div id="tour_itinerary" class="content no-padding tour-itinerary">
	   <?php
			$highlights = $tour['tour_highlight'];
			
			$highlights = explode("\n", $highlights);
		?>
		<?php if(count($highlights) > 0):?>
        <div class="pd-10">
			<h4 class="margin-top-0"><?=lang('tour_highlight')?></h4>

			<ul class="tour-highlight">
				<?php foreach ($highlights as $value):?>
					<?php if(!empty($value)):?>
					<li class="margin-bottom-10"><?=ucfirst($value)?></li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>	
		<?php endif;?>
		
		<div class="panel-group margin-bottom-0" id="accordion">
			<?php foreach ($tour['itinerary'] as $idx => $itinerary):?>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
						<a class="itinerary-day" data-toggle="collapse" href="#collapse_<?=$idx?>">
							<?=$itinerary['title']?>
						</a>
						</h4>
					</div>
					<div id="collapse_<?=$idx?>" class="panel-collapse collapse in">
						<div class="panel-body">
						<?php if(count($itinerary['photos']) == 1):?>
							<ul class="itinerary-photos">
								<?php foreach ($itinerary['photos'] as $photo):?>
								<li class="photo">
									<?php if(!empty($photo['cruise_id'])):?>
									<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
										<img class="img-responsive" width="400" height="300" src="<?=get_image_path(CRUISE, $photo['name'], '400x300')?>">
									</a>
									<?php else:?>
									<a href="<?=get_image_path(CRUISE_TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
										<img class="img-responsive" width="400" height="300" src="<?=get_image_path(CRUISE_TOUR, $photo['name'], '400x300')?>">
									</a>
									<?php endif;?>
								</li>
								<li class="photo-caption"><?=$photo['caption']?></li>
								
								<?php endforeach;?>
							</ul>
						<?php else:?>
							<ul class="itinerary-photos">
								<?php foreach ($itinerary['photos'] as $photo):?>
								<li class="photo">
									<?php if(!empty($photo['cruise_id'])):?>
										<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
											<img class="img-responsive" width="400" height="300" src="<?=get_image_path(CRUISE, $photo['name'], '400x300')?>">
										</a>
									<?php else:?>
										<a href="<?=get_image_path(CRUISE_TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
											<img class="img-responsive" width="400" height="300" src="<?=get_image_path(CRUISE_TOUR, $photo['name'], '400x300')?>">
										</a>
									<?php endif;?>
								</li>
								<li class="photo-caption margin-bottom-5"><?=$photo['caption']?></li>
								
								<?php endforeach;?>
							</ul>
						<?php endif;?>
						
						    <?=$itinerary['content']?>
							
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
									<?=lang('itinerary_activities')?>: <?=strip_tags($itinerary['activities'])?>
								</b>
							</div>
							<?php endif;?>
						</div>
					</div>
				</div>
			<?php endforeach;?>
			
			
			<div class="margin-top-10 pd-10">
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
