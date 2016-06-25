<div class="bpv-collapse">
	<h5 class="heading no-margin" data-target="#tour_itinerary">
		<i class="icon icon-star-white"></i>
		<?=lang('tour_itinerary')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	
	<div id="tour_itinerary" class="content no-padding tour-itinerary">
	
	   <div class="pd-10">
	       <div class="margin-bottom-20 pull-left block-content">
	            <?php if(count($tour_departures) > 1):?>
                <label for="cb_itinerary margin-top-5"><?=lang('itinerary_departing_short')?></label>
                <select id="cb_itinerary" class="form-control">
                    <?php foreach ($tour_departures as $value):?>
                    <option value="<?=$value['id']?>"><?=$value['name']?></option>
                    <?php endforeach;?>
                </select>
                <?php else:?>
                <div class="margin-top-5">
                <?=lang('itinerary_departing_short')?> <label><?=$tour_departures[0]['name']?></label>
                <input type="hidden" id="cb_itinerary" value="<?=$tour_departures[0]['id']?>">
                </div>
                <?php endif;?>
    	   </div>
            <?php
            	$highlights = $tour['tour_highlight'];
            	
            	$highlights = explode("\n", $highlights);
            ?>
            <?php if(count($highlights) > 0):?>
            
            	<h4 class="bpv-color-title"><?=lang('tour_highlight')?></h4>
            
            	<ul class="tour-highlight">
            		<?php foreach ($highlights as $value):?>
            			<?php if(!empty($value)):?>
            			<li class="margin-bottom-10"><?=$value?></li>
            			<?php endif;?>
            		<?php endforeach;?>
            	</ul>
            	
            <?php endif;?>
	   </div>
        
        <?php foreach ($tour_departures as $key => $dep_value):?>
    
        <div id="itinerary_<?=$dep_value['id']?>" class="itinerary-box<?php if($key > 0) echo' hide'?>">
        
            <div class="panel-group margin-bottom-0" id="accordion">
            <?php foreach ($tour['departure_itinerary'][$dep_value['id']] as $idx => $itinerary):?>
            
            <div class="panel panel-default">
    			<div class="panel-heading">
    				<h4 class="panel-title">
    				<a class="itinerary-day" data-toggle="collapse" href="#collapse_<?=$idx?>">
    					<?=$itinerary['title']?>
    					<span class="glyphicon glyphicon-chevron-right pull-right"></span>
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
    								<a href="<?=get_image_path(CRUISE, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
										<img class="img-responsive" width="400" height="300" src="<?=get_image_path(TOUR, $photo['name'], '400x300')?>">
									</a>
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
						
						<span class="transport"><?=get_tour_transportation($itinerary['transportations'])?></span>
					</div>
				</div>
			</div>
            
            <?php endforeach;?>
            </div>
        
        </div>
        
        <?php endforeach;?>
        
        
        <div class="box-download">
            <button type="button" class="btn btn-bpv btn-download" onclick="download_itinerary()">
            <span class="icon icon-download"></span><?=lang('download_itinerary')?>
            </button>
        </div>
	</div>
</div>

<script>
    $('#cb_itinerary').change(function() {
    	$('.itinerary-box').addClass('hide');
    	
    	var id = $(this).val();
    	$('#itinerary_'+id).removeClass('hide');
    	$('#itinerary_summary_'+id).removeClass('hide');
    });
    
    function download_itinerary()
    {
    	var dep_id = $('#cb_itinerary').val();
        var url = '<?=get_url(TOUR_DOWNLOAD, $tour).'?dep_id='?>'+dep_id;
        window.location = url;
    }
</script>