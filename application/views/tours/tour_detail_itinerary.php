
<?php if(!empty($tour['tour_highlight'])):?>
	<h3 class="highlight" style="padding-left:0;font-size:14px"><?=lang('trip_highlights')?>:</h3>
	
	<?php 	
			$highlights = $tour['tour_highlight'];
				
			$highlights = explode("\n", $highlights);
			
		?>
			
		<?php if(count($highlights) > 0):?>
			
			<ul class="tour_itinerary_highlight" style="list-style: disc outside url('<?=get_static_resources('/media/check.gif')?>'); margin-left: 35px">
				<?php foreach ($highlights as $value):?>
					<?php if(trim($value) != ''):?>
					<li><?=format_object_overview($value)?></li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
			
		<?php endif;?>
	
	<div class="clearfix"></div>
	
<?php endif;?>
								
<?php if(isset($routes) && count($routes) > 0):?>

	<?php if(count($routes) > 1):?>
		
		<div class="itinerary_route">
		<?php foreach ($routes as $key=>$route):?>
			
			<?php if($key==0):?>
					
				<span class="itineray_route_name highlight" id="route_<?=$key?>">
				<?=($key + 1).'. '.$route['route']['title']?>
				</span>
			
			<?php else:?>
				
				<span class="itineray_route_name" id="route_<?=$key?>">				
					<a id="route_<?=$key?>_a" href="javascript:void(0)" style="text-decoration:underline;" onclick="show_route('route_<?=$key?>')">
					<?=($key + 1).'. '.$route['route']['title']?>
					</a>				
				</span>
				
			<?php endif;?>
			
		<?php endforeach;?>		
		</div>
		
	<?php endif;?>

	<?php foreach ($routes as $key=>$route):?>
		
		<div style="width:100%;float:left;<?php if($key>0):?>display:none<?php endif;?>" id="route_<?=$key?>_content">
		
		<?php foreach ($route['itineraries'] as $detail):?>
		
			<?php if($detail['type'] == 3):?>
				<div class="itinerary_sub_route highlight"><?=$detail['title']?>:</div>
			<?php else:?>
			
			<div class="itinerary_day" show="hide" id="it_<?=$detail['id']?>" onclick="show_hide_day('it_<?=$detail['id']?>')">
			
				<div class="label">
					<?php if(!empty($detail['label'])):?>
						<?=$detail['label']?>
					<?php elseif(count($route['itineraries']) == 1):?>
						<?=lang('label_full_day')?>
					<?php endif;?>
				</div>
				
				<div class="title">
					<?=$detail['title']?>
				</div>
				
				<div class="status" id="it_<?=$detail['id']?>_status">
					<img id="it_<?=$detail['id']?>_img" src="<?=get_static_resources('/media/itinerary_close.png')?>" style="margin-top:7px;">
				</div>
			
			</div>
			
			<div class="itinerary_content" id="it_<?=$detail['id']?>_content">
			
			    <?php if(!empty($detail['photos'])  && !empty($tour['cruise_id'])):?>
					<?=get_tour_itinerary_photos($detail['photos'], $tour)?>
				<?php endif;?>

				<?php if(!empty($detail['content'])):?>
				<div><?=format_object_overview(format_specialtext($detail['content']))?></div>
				<?php endif;?>
				
				<?php if(!empty($detail['meals'])):?>
				<em>
				<?php $meals = explode(',', $detail['meals']);?>
				<?=lang('meals')?>: <?=getTourMeals($detail['meals'])?>
				</em><br/>
				<?php endif;?>
				
				<?php if($detail['type'] <= 1):?>
				<em><?=lang('accommodation')?>: <?= (!empty($detail['accommodation'])) ? format_object_overview($detail['accommodation']) : lang('label_na');?></em>
				<br/>
				<?php endif;?>
				
				<?php if(!empty($detail['activities'])):?>
				<em>				
				<?=lang('activities')?>: <?=format_specialtext($detail['activities'])?>
				</em><br/>
				<?php endif;?>

				<?php if(!empty($detail['others'])):?>
				<?php $others = explode("\n", $detail['others'])?>
					<?php foreach ($others as $other):?>
					<?php if(!empty($other)):?>
					<em><?=format_object_overview($other)?></em><br/>
					<?php endif;?>
					<?php endforeach;?>
				<?php endif;?>
				
				<?php if(!empty($detail['photos']) && empty($tour['cruise_id'])):?>
					<?=get_tour_itinerary_photos($detail['photos'], $tour)?>
				<?php endif;?>
				
			</div>
			
		
			<?php endif;?>
		
		<?php endforeach;?>
		
		<?php if(count($routes) > 1):?>
		<div class="itinerary_view_more">
			
			<?php 
				$rt = isset($routes[$key + 1]) ? $routes[$key + 1]['route'] : $routes[$key - 1]['route'];
				
				$ix = isset($routes[$key + 1]) ? $key + 1 : $key - 1;
			?>
				
			<a href="javascript:void(0)" style="text-decoration:underline;" onclick="show_route('route_<?=$ix?>')"><?=lang('label_view')?> <?=$rt['title']?> &raquo;</a>
		</div>
		<?php endif;?>
			
		</div>
		
	<?php endforeach;?>


<?php else:?>
	<?=format_specialtext($tour['detail_itinerary'])?>
<?php endif;?>

<div class="clearfix"></div>
				
<h3 class="price" style="margin-top:10px;"><?=lang('important_notes')?>:</h3>
<ul class="tour_itinerary_highlight" style="list-style: disc;">
	<li><?=lang('fixed_important_note')?></li>
	<?php if(!empty($tour['note'])):?>
		<?php 
			$notes = $tour['note'];
			$notes = explode("\n", $notes);
		?>
		<?php foreach ($notes as $value):?>
			<?php if(trim($value)):?>
			<li><?=$value?></li>
			<?php endif;?>
		<?php endforeach;?>
	<?php endif;?>
</ul>

<?php if((isset($cruise) && $cruise['cruise_destination'] == 0)):?>

<ul class="tour_itinerary_highlight" style="list-style: disc;">
	<li style="list-style:none;font-weight:bold;text-decoration:underline;" class="highlight"><?=lang('cancellation_title')?>:</li>
	<li><?=lang('cancellation_note_1')?></li>
	<li><?=lang('cancellation_note_2')?></li>
	<li><?=lang('cancellation_note_3')?><b><?=lang('all_of_best')?></b></li>
</ul>

<?php endif;?>
				

<script type="text/javascript">

	function show_hide_day(id){

		var show = $('#'+id).attr('show');

		if (show == 'hide'){

			$('#'+id+'_status').css('background-color','#EBB750');

			$('#'+id+'_img').attr('src','<?=get_static_resources('/media/itinerary_open.png')?>');
			
			$('#'+id+'_content').show();

			$('#'+id).attr('show','show');
			
		} else {

			$('#'+id+'_status').css('background-color','#779BCA');

			$('#'+id+'_img').attr('src','<?=get_static_resources('/media/itinerary_close.png')?>');
			
			$('#'+id+'_content').hide();

			$('#'+id).attr('show','hide');
		}
		
	}

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
		go_check_rate_position();
	}

	$(document).ready(function(){
		
		<?php if(isset($routes) && count($routes) > 0):?>
	
			<?php foreach ($routes as $key=>$route):?>
	
				<?php foreach ($route['itineraries'] as $key=>$detail):?>
	
					<?php if($key == 0):?>
						
						show_hide_day('it_<?=$detail['id']?>');
	
						<?php break;?>
						
					<?php endif;?>
					
				<?php endforeach;?>
				
			<?php endforeach;?>
		
		<?php endif;?>
		
	});
	
</script>
