<?php if( !empty($in_and_around['attractions']) || !empty($in_and_around['area']) 
			|| !empty($in_and_around['shopping_areas']) || !empty($in_and_around['heritages'])
			|| !empty($in_and_around['bus_stop']) || !empty($in_and_around['airport']) || !empty($in_and_around['train_station']) ):?>
<div class="bpv-newbox margin-bottom-20 margin-top-20">
	<h3 class="bpv-color-title">
		<?=lang('in_and_around') . ' ' . $city['name']?>
	</h3>
	
	<div class="tab-content bpv-in-and-around">
	
		<?php if( !empty($in_and_around['attractions']) || !empty($in_and_around['area']) 
					|| !empty($in_and_around['shopping_areas']) || !empty($in_and_around['heritages']) ):?>
					
		<div class="row margin-bottom-10">
			<div class="col-xs-12">
				<span class="icon d-marker"></span>
				<label class="title"><?=lang('tourist_destination')?></label>
			</div>
		</div>
		
		<div class="row">
			<?php if( !empty($in_and_around['attractions']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('attraction')?></li>
				<?php foreach ($in_and_around['attractions'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_atn hide"'?>>
					<a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a>
				</li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['attractions']) > 5):?>
					<a class="show-more" data-name="place_atn" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
			
			<?php if( !empty($in_and_around['area']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('area')?></li>
				<?php foreach ($in_and_around['area'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_area hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['area']) > 5):?>
					<a class="show-more" data-name="place_area" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
		</div>
		
		<div class="row">
			<?php if( !empty($in_and_around['shopping_areas']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('shopping_areas')?></li>
				<?php foreach ($in_and_around['shopping_areas'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_sp hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['shopping_areas']) > 5):?>
					<a class="show-more" data-name="place_sp" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
			
			<?php if( !empty($in_and_around['heritages']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('heritage')?></li>
				<?php foreach ($in_and_around['heritages'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_ht hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['heritages']) > 5):?>
					<a class="show-more" data-name="place_ht" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
		</div>
		
		<?php endif;?>
		
		
		<?php if( !empty($in_and_around['bus_stop']) || !empty($in_and_around['airport'])
						|| !empty($in_and_around['train_station']) ):?>
		
		<div class="des-group">
			<span class="icon d-bus"></span>
			<label class="title"><?=lang('transportation')?></label>
		</div>
		
		<div class="row">
			<?php if( !empty($in_and_around['bus_stop']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('bus_stop')?></li>
				<?php foreach ($in_and_around['bus_stop'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_bus hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['bus_stop']) > 5):?>
					<a class="show-more" data-name="place_bus" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
		
			<?php if( !empty($in_and_around['airport']) ):?>
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('airport')?></li>
				<?php foreach ($in_and_around['airport'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_ap hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['airport']) > 5):?>
					<a class="show-more" data-name="place_ap" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
			<?php endif;?>
		</div>
		
		<?php if( !empty($in_and_around['train_station']) ):?>
		<div class="row">
			<ul class="col-xs-6 list-unstyled">
				<li class="sub-title"><?=lang('train_station')?></li>
				<?php foreach ($in_and_around['train_station'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_train hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['train_station'])  > 5):?>
					<a class="show-more" data-name="place_train" href="javascript:void(0)"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
		</div>
		<?php endif;?>
		
		<?php endif;?>
		
		
		<?php if( !empty($in_and_around['district']) ):?>
		<div class="des-group">
			<span class="icon d-marker"></span>
			<label class="title"><?=lang('district')?></label>
		</div>
		
		<div class="row">
			<ul class="col-xs-6 list-unstyled">
				<?php foreach ($in_and_around['district'] as $k => $des):?>
				<li <?php if($k>4) echo 'class="place_district hide"'?>><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
				<?php endforeach;?>
				
				<?php if(count($in_and_around['district']) > 5):?>
					<a class="show-more" href="javascript:show_more_places('place_district')"><?=lang('view_more_places')?></a>
				<?php endif;?>
			</ul>
		</div>
		<?php endif;?>
	</div>
</div>

<?php endif;?>

 <script>
	$('.show-more').click(function () {
		var name = $(this).attr('data-name');

		if ( $('.'+name).hasClass('hide') ) {
			$('.'+name).removeClass('hide');
			var txt = $(this).text();
			$(this).text(txt.replace("+", "-")); 
		} else {
			$('.'+name).addClass('hide');
			var txt = $(this).text();
			$(this).text(txt.replace("-", "+")); 
		}
	});
 </script>