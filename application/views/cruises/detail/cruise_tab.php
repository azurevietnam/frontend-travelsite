<div role="tabpanel" class="bpt-tab bpt-tab-tours">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
            <a href="#cruise_rate" aria-controls="cruise_rate" role="tab" data-toggle="tab"><?=lang('check_rates')?></a>
        </li>
        <li role="presentation">
            <a href="#cruise_itinerary" aria-controls="cruise_itinerary" role="tab" data-toggle="tab"><?=lang('cruise_program_itinerary')?></a>
        </li>
        <li role="presentation">
            <a href="#cruise_policies" aria-controls="cruise_policies" role="tab" data-toggle="tab"><?=lang('cruise_policies_tab')?></a>
        </li>
        <li role="presentation">
            <a href="#cruise_facilities" aria-controls="cruise_facilities" role="tab" data-toggle="tab"><?=lang('cruise_facilities_deckplan')?></a>
        </li>
        <?php if(!empty($cruise_resources)):?>
        <li role="presentation">
            <a href="#cruise_resources" aria-controls="cruise_resources" role="tab" data-toggle="tab"><?=lang('cruise_resouces')?></a>
        </li>
        <?php endif;?>
    </ul>
</div>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="cruise_rate">
    	<?=$check_rate_form?>
    	
    	<?=$tour_rate_table?>
    	
    	<?php if(!empty($extra_saving_recommend)):?>
    		<?=$extra_saving_recommend?>
    	<?php endif;?>
    	
    	
    	<?=$tour_booking_conditions?>
    	
    	<h2 class="text-highlight header-title"><?=$cruise['name'] . ' ' . lang('cruise_photos')?></h2>
    	<?=$photo_list?>
    	
    	<div id="cruise_videos"></div>
    </div>
    <div role="tabpanel" class="tab-pane" id="cruise_itinerary">
    	<?=$cruise_itineraries?>
    </div>
    <div role="tabpanel" class="tab-pane" id="cruise_policies">
    	<?=$cruise_policies?>
    </div>
    <div role="tabpanel" class="tab-pane" id="cruise_facilities">
    	<?=$cruise_facilities?>
    </div>
    <?php if(!empty($cruise_resources)):?>
    <div role="tabpanel" class="tab-pane" id="cruise_resources">
    	<?=$cruise_resources?>
    </div>
    <?php endif;?>
</div>