<div class="row">
    <div class="col-xs-6">
        <h3 class="bpv-color-title no-margin"><span class="icon icon-itinerary-details"></span><?=lang('tour_itinerary')?></h3>
    </div>
    <?php if(!empty($tour_departures)):?>
    <div class="col-xs-6 text-right">
        <?php if(count($tour_departures) > 1):?>
        <label><?=lang('itinerary_departing')?></label>
        <select id="cb_itinerary">
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
    <?php endif;?>
</div>
<div class="tour-itinerary">
    <div class="tour-box">
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
    
        <?php foreach ($tour['departure_itinerary'][$dep_value['id']] as $itinerary):?>
        
        <div class="tour-box margin-top-20" id="itinerary_details_<?=$dep_value['id'].'_'.$itinerary['id']?>">
            <h4 class="panel-title bpv-color-title margin-bottom-20">
                <?php $titles = explode(':', $itinerary['title']);?>
                <?php if(count($titles) > 1):?>
        		    <span class="iti-day"><?=$titles[0].':'?></span>
        		    <span class="iti-day-title"><?=$titles[1]?></span>
        		<?php else:?>
                    <?=$itinerary['title']?>
        		<?php endif;?>	
            	<span class="transport"><?=get_tour_transportation($itinerary['transportations'])?></span>
        	</h4>
        	<div class="itinerary-content">
        	   <?=$itinerary['content']?>
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
    		
    		<ul class="itinerary-photos">
    			<?php foreach ($itinerary['photos'] as $photo):?>
    			<li class="photo">
    				<a href="<?=get_image_path(TOUR, $photo['name'])?>" title="<?=$photo['caption']?>" data-gallery>
						<img class="img-responsive" width="700" src="<?=get_image_path(TOUR, $photo['name'])?>"/>
					</a>
    			</li>
    			<li class="caption margin-bottom-5"><?=$photo['caption']?></li>
    			<?php endforeach;?>
    		</ul>
    	</div>
        
        <?php endforeach;?>
    
    </div>
    
    <?php endforeach;?>
    
    <div class="box-download">
        <button type="button" class="btn btn-bpv btn-download" onclick="download_itinerary()">
        <span class="icon icon-download"></span><?=lang('download_itinerary')?>
        </button>
    </div>
</div>

<script>
    	$('#cb_itinerary').change(function() {
        	$('.itinerary-box').addClass('hide');
        	
        	var id = $(this).val();
        	$('#itinerary_'+id).removeClass('hide');
        	$('#itinerary_summary_'+id).removeClass('hide');
        });

        $('.nav-itinerary').click(function() {
        	$('#tour_tabs a:first').tab('show');
        	
        	$('.nav-itinerary-pr').removeClass('active');

        	$(this).parent().addClass('active');

        	var id = $(this).attr('name');
        	$("html, body").animate({ scrollTop: $("#"+id).offset().top}, "fast");
        });

        function download_itinerary()
        {
            var dep_id = $('#cb_itinerary').val();
            var url = '<?=get_url(TOUR_DOWNLOAD, $tour).'?dep_id='?>'+dep_id;
            window.location = url;
        }
</script>