<?=!empty($itinerary_highlights) ? $itinerary_highlights : ''?>

<?php if(!empty($routes)):?>

<div class="bpt-accordion">
<div class="panel-group" id="tour_itinerary" role="tablist" aria-multiselectable="true">
<?php foreach ($routes as $key => $route):?>
    
    <?php if(!empty($route['route']['title'])):?>
    <h2 class="text-highlight"><?=$route['route']['title']?></h2>
    <?php endif;?>

    <?php foreach ($route['itineraries'] as $idx => $value):?>
    
    <!-- Sub route -->
    <?php if($value['type'] == 3):?>
    <h2 class="text-highlight"><?=$value['title']?></h2>
    <?php else:?>
    
    <!-- Normal route -->
    <div class="panel panel-default">
		<div class="panel-heading collapse-header" role="tab" id="heading_<?=$idx?>">
			<h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?=$idx?>" aria-expanded="false" aria-controls="collapse_<?=$idx?>">
				<b><?=!empty($value['label']) ? $value['label'].': ' : ''?></b><?=$value['title']?>
				<span class="glyphicon glyphicon-menu-right"></span>
			</h4>
		</div>
		<div id="collapse_<?=$idx?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?=$idx?>">
			<div class="panel-body">
			
			<?php if(!empty($value['itinerary_photos'])):?>
    		<?=get_itinerary_photos($value, true, true)?>
            <?php endif;?>
		
            <?php if(!empty($value['content'])):?>
            <?=insert_see_overview_link(format_specialtext($value['content']))?>
            <?php endif;?>
            
            <?php if(!empty($value['meals_options'])):?>
            <div class="margin-bottom-5"><b><?=lang('meals')?>:</b> <?=get_tour_meals($value['meals_options'])?></div>
            <?php endif;?>
					
            <?php if($value['type'] <= 1):?>
        	<div class="margin-bottom-5"><b><?=lang('accommodation')?>:</b> <?=!empty($value['accommodation']) ? insert_see_overview_link($value['accommodation']) : lang('label_na');?></div>
        	<?php endif;?>
        	
        	<?php if(!empty($value['activities'])):?>
            <div class="margin-bottom-5"><b><?=lang('activities')?>:</b> <?=format_specialtext($value['activities'])?></div>
            <?php endif;?>
            
            <?php if(!empty($value['notes'])):?>
            <div class="margin-bottom-5"><em style="font-weight: bold;"><?=insert_see_overview_link($value['notes'])?></em></div>
        	<?php endif;?>
        	
			</div>
		</div>
	</div>
	<?php endif;?>
    
    <?php endforeach;?>
<?php endforeach;?>
</div>
</div>

<script>
// fix bug on ios
$('.collapse-header').on('click', function () {
    $($(this).data('target')).collapse('toggle');
});

// change css class
$('#tour_itinerary').on('shown.bs.collapse', function (e) {
    $(e.target).prev('.panel-heading').find('.panel-title').addClass('active');
});

$('#tour_itinerary').on('hidden.bs.collapse', function (e) {
	$(e.target).prev('.panel-heading').find('.panel-title').removeClass('active');
});
</script>
<?php endif;?>

<div class="container">
    <h3 class="text-price"><?=lang('important_notes')?>:</h3>
    <ul class="important-note">
        <li><?=lang('fixed_important_note')?></li>
        <?php if(!empty($tour['note'])):?>
    		<?php $notes = explode("\n", $tour['note']);?>
    		<?php foreach ($notes as $value):?>
    			<?php if(!empty($value)):?>
    			<li><?=$value?></li>
    			<?php endif;?>
    		<?php endforeach;?>
    	<?php endif;?>
    </ul>
    
    <?php if(!empty($tour['cruise_id']) && $tour['cruise_destination'] == HALONG_CRUISE_DESTINATION):?>
    
    <h3 class="text-highlight margin-top-10"><?=lang('cancellation_title')?>:</h3>
    <ul class="cancellation-note">
    	<li><?=lang('cancellation_note_1')?></li>
    	<li><?=lang('cancellation_note_2')?></li>
    	<li><?=lang('cancellation_note_3')?><b><?=lang('all_of_best')?></b></li>
    </ul>
    <?php endif;?>
</div>