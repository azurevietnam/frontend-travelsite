
<?php if((isset($domestic_destinations) || isset($outbound_destinations)) && $tour_links):?>
<div class="bpv-hotel-destinations">
	<h2 class="bpv-color-title"><span class="icon icon-destination-none"></span> <?=lang('tour_by_destinations')?></h2>
	<div class="row">
		<div class="col-xs-4">
			<h4><?=lang('label_domestic_tours')?></h4>
			<div class="footer_tour_link margin-bottom-10"></div>
			
			<div class="row">
				<div class="col-xs-6">
					
				<?php foreach ($domestic_destinations as $k => $domestic_tour):?>
					<?php if(($k + 1)%2 == 1):?>	
					<ul class="list-unstyled bpv-line-dotted">
						<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $domestic_tour)?>"><span class="des_text_bold"> <?=lang_arg('label_travel', $domestic_tour['name'])?></span></a></li>
						<?php if(!empty( $domestic_tour['destinations'])):?>
						
							<?php foreach ( $domestic_tour['destinations'] as $domestic):?>
								<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $domestic)?>"> <?=lang_arg('label_travel', $domestic['name'])?></a></li>
							<?php endforeach;?>
							
						<?php endif;?>
					</ul>
					<?php endif;?>
				<?php endforeach;?>
					
				</div>
				
				<div class="col-xs-6">
					
					<?php foreach ($domestic_destinations as $k => $domestic_tour):?>
						<?php if(($k + 1)%2 == 0):?>
						<ul class="list-unstyled bpv-line-dotted">
							<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $domestic_tour)?>"><span class="des_text_bold"> <?=lang_arg('label_travel', $domestic_tour['name'])?></span></a></li>
							<?php if(!empty( $domestic_tour['destinations'])):?>
							
								<?php foreach ( $domestic_tour['destinations'] as $domestic):?>
									<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $domestic)?>"> <?=lang_arg('label_travel', $domestic['name'])?></a></li>
								<?php endforeach;?>
								
							<?php endif;?>
						</ul>
						<?php endif;?>
					<?php endforeach;?>
					
				</div>
				
				
			</div>
			
		</div>
		
		<div class="col-xs-6">
			<h4><?=lang('label_outbound_tours')?></h4>
			<div class="footer_tour_link margin-bottom-10"></div>
			<div class="row">
				
				<div class="col-xs-4">
					
					<?php foreach ($outbound_destinations as $k => $outbound_tour):?>
						<?php if(($k + 1)%3 == 1):?>			
						
							<ul class="list-unstyled bpv-line-dotted">
								<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound_tour)?>"><span class="des_text_bold"> <?=lang_arg('label_travel', $outbound_tour['name'])?></span></a></li>
								<?php if(!empty( $outbound_tour['destinations'])):?>
							
									<?php foreach ( $outbound_tour['destinations'] as $outbound):?>
									<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound)?>"> <?=lang_arg('label_travel', $outbound['name'])?></a></li>
									<?php endforeach;?>
								
								<?php endif;?>
							</ul>
						
						<?php endif;?>
					<?php endforeach;?>
					
				</div>
				
				<div class="col-xs-4">
					
					<?php foreach ($outbound_destinations as $k => $outbound_tour):?>
						<?php if(($k + 1)%3 == 2):?>			
						
							<ul class="list-unstyled bpv-line-dotted">
								<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound_tour)?>"><span class="des_text_bold"> <?=lang_arg('label_travel', $outbound_tour['name'])?></span></a></li>
								<?php if(!empty( $outbound_tour['destinations'])):?>
							
									<?php foreach ( $outbound_tour['destinations'] as $outbound):?>
									<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound)?>"> <?=lang_arg('label_travel', $outbound['name'])?></a></li>
									<?php endforeach;?>
								
								<?php endif;?>
							</ul>
						
						<?php endif;?>
					<?php endforeach;?>
					
				</div>
				
				<div class="col-xs-4">
				
					<?php foreach ($outbound_destinations as $k => $outbound_tour):?>
						<?php if(($k + 1)%3 == 0):?>			
						
							<ul class="list-unstyled bpv-line-dotted">
								<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound_tour)?>"><span class="des_text_bold"> <?=lang_arg('label_travel', $outbound_tour['name'])?></span></a></li>
								<?php if(!empty( $outbound_tour['destinations'])):?>
							
									<?php foreach ( $outbound_tour['destinations'] as $outbound):?>
									<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $outbound)?>"> <?=lang_arg('label_travel', $outbound['name'])?></a></li>
									<?php endforeach;?>
								
								<?php endif;?>
							</ul>
						
						<?php endif;?>
					<?php endforeach;?>
				
				</div>
			</div>
		</div>
		
		<div class="col-xs-2">
			<h4><?=lang('label_category_tours')?></h4>
			<div class="footer_tour_link margin-bottom-10"></div>
			<ul class="list-unstyled">
				<?php foreach ($tour_categories as $k => $categories):?>
					<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $categories)?>"><?=$categories['name']?></a>
					<?php if($categories['is_hot'] == 1):?> <img src="<?=get_static_resources('/media/icon/icon-hot.png')?>"> <?php endif;?> 
					</li>
				<?php endforeach;?>
			</ul>
		</div>
	</div>
</div>
<?php endif;?>	
 
<?php if(isset($footer_hotel_destinations) && $hotel_links):?>
<div class="bpv-hotel-destinations">
	<h2 class="bpv-color-title"><span class="icon icon-hotel-des"></span> <?=lang('hotels_by_destinations')?></h2>
	<div class="row">
		<?php foreach ($footer_hotel_destinations as $des):?>
		<div class="col-xs-2">
			<a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=lang('hotel_txt').' '.$des['name']?></a>
		</div>
		<?php endforeach;?>
	</div>
</div>
<?php endif;?>	

<?php if(isset($domestic_flights) && isset($international_flights) && $flight_links):?>
<div class="bpv-hotel-destinations margin-top-20">
	<h2 class="bpv-color-title"><span class="icon icon-flight-des"></span> <?=lang('search_label_flights')?></h2>
	<div class="row">
		<div class="col-xs-4">
			<h4><?=lang('international_flights')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($international_flights as $k => $des):?>
					<li style="float:left;width:50%"><a href="<?=get_url(FLIGHT_DESTINATION_PAGE, $des)?>"><?=lang('flights_to_text')?> <?=$des['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('domestic_flights')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($domestic_flights as $k => $des):?>
				<li><a href="<?=get_url(FLIGHT_DESTINATION_PAGE, $des)?>"><?=lang('flights_to_text')?> <?=$des['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('domestic_airlines')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($airlines as $airline):?>
					<?php if($airline['is_domistic'] == STATUS_ACTIVE):?>
						<li><a href="<?=get_url(FLIGHT_AIRLINE_PAGE, $airline)?>"><?=lang('flights_text')?> <?=$airline['name']?></a></li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('international_airlines')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($airlines as $airline):?>
					<?php if($airline['is_domistic'] == STATUS_INACTIVE):?>
						<li><a href="<?=get_url(FLIGHT_AIRLINE_PAGE, $airline)?>"><?=lang('flights_text')?> <?=$airline['name']?></a></li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
		</div>
		
		<?php if(!empty($flight_categories)):?>
		<div class="col-xs-2">
			<h4><?=lang('flights_class')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($flight_categories as $cat):?>
				<li>
					<a href="<?=get_url(FLIGHT_CATEGORY_PAGE, $cat)?>"><?=$cat['name']?></a>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
		<?php endif;?>
	</div>
</div>
<?php endif;?>