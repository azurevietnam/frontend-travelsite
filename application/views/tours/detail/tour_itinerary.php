<?=empty($is_hide_itinerary) && !empty($itinerary_highlights) ? $itinerary_highlights : ''?>

<h3 class="text-highlight margin-top-10"><?=lang('lbl_full_itinerary')?></h3>

<?php if(!empty($routes)):?>

<?php if(count($routes) > 1):?>
	<div class="itinerary-route">
		<?php foreach ($routes as $k => $value):?>
		<?php if($k==0):?>
			<span class="route-name text-highlight" id="route_<?=$k?>">
			<?=($k + 1).'. '.$value['route']['title']?>
			</span>
		<?php else:?>
		<span class="route-name" id="route_<?=$k?>">				
			<a id="route_<?=$k?>_a" href="javascript:void(0)" style="text-decoration:underline;" onclick="show_route('route_<?=$k?>')">
			<?=($k + 1).'. '.$value['route']['title']?>
			</a>				
		</span>
		<?php endif;?>
		<?php endforeach;?>
	</div>
<?php endif;?>

<div class="tour-itinerary">
<?php foreach ($routes as $key => $route):?>

	<div style="width:100%;float:left;<?php if($key>0):?>display:none<?php endif;?>" id="route_<?=$key?>_content">
    <?php $cnt = 0;?>
    <?php foreach ($route['itineraries'] as $k => $value):?>
    <?php	 
        $is_visible = count($route['itineraries']) >= 3 && $cnt > 0 ? false : true;

        $cnt = $value['type'] == 1 ? $cnt + 1 : $cnt;
    ?>
    <div id="itinerary_details_<?=$value['id'].'_'.$k?>" class="itinerary-box<?= $k > 0 ? ' margin-top-10' : ''?>">
        <?php if($value['type'] == 3):?>
        <div class="text-highlight"><b><?=$value['title']?></b></div>
        <?php else:?>
        <div class="itinerary-title" data-target="#itinerary_content_<?=$value['id'].'_'.$k?>">
            <span class="iti-day"><?=$value['label']?></span>
            <span class="iti-day-title text-highlight"><?=$value['title']?><span class="transport margin-left-10"><?=get_icon_transportation($value['transportations'], true)?></span></span>
            <span class="glyphicon <?=$is_visible ? 'glyphicon-minus-sign' : 'glyphicon-plus-sign'?>" id="itinerary_icon_<?=$value['id'].'_'.$k?>"></span>
        </div>
        <div class="itinerary-content" id="itinerary_content_<?=$value['id'].'_'.$k?>" <?=!$is_visible ? 'style="display:none"' : ''?>>
        
        	<?php if(!empty($value['itinerary_photos'])):?>
        		<?=get_itinerary_photos($value)?>
        	<?php endif;?>
        	
            <?php if(!empty($value['content'])):?>
            <?=insert_see_overview_link(format_specialtext($value['content']))?>
            <?php endif;?>
            
            <?php if(!empty($value['meals_options'])):?>
            <div><b><?=lang('meals')?>:</b> <?=get_tour_meals($value['meals_options'])?></div>
            <?php endif;?>
            
            <?php if($value['type'] <= 1):?>
        	<div><b><?=lang('accommodation')?>:</b> <?=!empty($value['accommodation']) ? insert_see_overview_link($value['accommodation']) : lang('label_na');?></div>
        	<?php endif;?>
        	
        	<?php if(!empty($value['activities'])):?>
            <div><b><?=lang('activities')?>:</b> <?=format_specialtext($value['activities'])?></div>
            <?php endif;?>
            
            <?php if(!empty($value['notes'])):?>
            <div><em style="font-weight: bold;"><?=insert_see_overview_link($value['notes'])?></em></div>
        	<?php endif;?>
        	
        	<?php if(!empty($value['itinerary_photos'])):?>
        		<?=get_itinerary_photos($value, false)?>
        	<?php endif;?>
        </div>
        <?php endif;?>
    </div>
    <?php endforeach;?>
    
    <?php if(count($routes) > 1):?>
	<div class="itinerary-view-more">
		
		<?php 
			$rt = isset($routes[$key + 1]) ? $routes[$key + 1]['route'] : $routes[$key - 1]['route'];
			
			$ix = isset($routes[$key + 1]) ? $key + 1 : $key - 1;
		?>
			
		<a href="javascript:void(0)" style="text-decoration:underline;" onclick="show_route('route_<?=$ix?>')"><?=lang('label_view')?> <?=$rt['title']?> &raquo;</a>
	</div>
	<?php endif;?>
    </div>
<?php endforeach;?>
</div>

<?php endif;?>

<h3 class="text-price margin-top-10 full-width"><?=lang('important_notes')?>:</h3>
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

<ul class="cancellation-note">
	<li class="text-highlight cancellation-title"><?=lang('cancellation_title')?>:</li>
	<li><?=lang('cancellation_note_1')?></li>
	<li><?=lang('cancellation_note_2')?></li>
	<li><?=lang('cancellation_note_3')?><b><?=lang('all_of_best')?></b></li>
</ul>

<?php endif;?>
<script>
$('.itinerary-title').bpvToggle(function() {
	var icon = $( '.glyphicon', $( this ));
	var target = $( this ).attr('data-target');
		
	if( $(target).is(':visible') ) {
		$(icon).toggleClass ('glyphicon-minus-sign glyphicon-plus-sign');
	} else {
		$(icon).toggleClass ('glyphicon-plus-sign glyphicon-minus-sign');
	}
});

function show_route(id){

	var text = $('#'+id+'_a').text();

	$('#'+id).text(text);

	$('#'+id).addClass('highlight');

	$('#'+id+'_content').show();
	<?php if(isset($routes)):?>
	<?php foreach($routes as $key=>$route):?>

		if (id !=  'route_<?=$key?>'){

			var txt = $('#route_<?=$key?>').text();

			var html_txt = '<a id="route_<?=$key?>_a" href="javascript:void(0)" style="text-decoration:underline;" onclick="show_route(\'route_<?=$key?>\')">';

			html_txt = html_txt + txt + '</a>';

			$('#route_<?=$key?>').html(html_txt);

			$('#route_<?=$key?>_content').hide();
		}	
	
	<?php endforeach;?>
	<?php endif;?>
	go_position('#tour_itinerary');
}
</script>