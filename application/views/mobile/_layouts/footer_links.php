<?php if(isset($footer_hotel_destinations)):?>
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

<?php if(isset($domestic_flights) && isset($international_flights)):?>
<div class="bpv-hotel-destinations margin-top-20">
	<h2 class="bpv-color-title"><span class="icon icon-flight-des"></span> <?=lang('search_label_flights')?></h2>
	<div class="row">
		<div class="col-xs-2">
			<h4><?=lang('international_flights')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($international_flights as $k => $des):?>
				<?php //if($k > 9) continue;?>
				<li><a href="<?=get_url(FLIGHT_DESTINATION_PAGE, $des)?>"><?=lang('flights_text')?> <?=$des['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('domestic_flights')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($domestic_flights as $k => $des):?>
				<li><a href="<?=get_url(FLIGHT_DESTINATION_PAGE, $des)?>"><?=lang('flights_text')?> <?=$des['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('domestic_airlines')?></h4>
			<ul class="list-unstyled">
				<?php foreach ($airlines as $airline):?>
				<li><a href="#"><?=lang('flights_text')?> <?=$airline['name']?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('international_airlines')?></h4>
			<ul class="list-unstyled">
				<li><a href="#"><?=lang('flights_text')?> Singapore Airlines</a></li>
				<li><a href="#"><?=lang('flights_text')?> Thai Airways</a></li>
				<li><a href="#"><?=lang('flights_text')?> Asian Airlines</a></li>
				<li><a href="#"><?=lang('flights_text')?> Air Asia</a></li>
				<li><a href="#"><?=lang('flights_text')?> Eva Airlines</a></li>
			</ul>
		</div>
		<div class="col-xs-2">
			<h4><?=lang('flights_class')?></h4>
			<ul class="list-unstyled">
				<?php if(!empty($lst_news)):?>
				<?php foreach ($lst_news as $news):?>
				<li>
					<a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
				</li>
				<?php endforeach;?>
				<?php endif;?>
			</ul>
		</div>
	</div>
</div>
<?php endif;?>