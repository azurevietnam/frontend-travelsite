<div class="container main-content">

	<div class="row margin-bottom-20 mod-search">
		
		<div class="col-xs-12">
			<?=$bpv_ads?>
		</div>
		
		<?=$bpv_search?>
	</div>
	
	<div class="row">
		<div class="col-xs-6">
			<?=$bpv_why_us?>
			
			<a target="_blank" href="<?=get_url(NEWS_HOME_PAGE, $n_book_together)?>">
				<img class="margin-bottom-20 img-responsive" src="<?=get_static_resources('/media/banners/bpv-slogan.21102014.jpg')?>">
			</a>
			
			<div class="bpv-newbox top-destinations margin-bottom-20 margin-top-20">
				<h3><span class="icon icon-top-des"></span> <?=lang('halong_popular_cruises')?></h3>
				<div class="row content">
					<div class="col-xs-12">
						<h4 class="bpv-color-title" style="margin-top: 0;"><?=lang('luxury_cruises')?></h4>
					</div>
					<?php foreach ($popular_cruises as $k => $cruise):?>
					<?php if($cruise['star'] >= 4):?>
					<div class="col-xs-4">
						<span class="arrow-sm"></span>
						<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
							<?=$cruise['name']?>
							<br>
							<span class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></span>
						</a>
					</div>
					<?php endif;?>
					<?php endforeach;?>
					
					<div class="col-xs-12">
						<h4 class="bpv-color-title"><?=lang('budget_cruises')?></h4>
					</div>
					<?php foreach ($popular_cruises as $k => $cruise):?>
					<?php if($cruise['star'] < 4):?>
					<div class="col-xs-4">
						<span class="arrow-sm"></span>
						<a href="<?=cruise_build_url($cruise, $search_criteria)?>">
							<?=$cruise['name']?>
							<br>
							<span class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></span>
						</a>
					</div>
					<?php endif;?>
					<?php endforeach;?>
				</div>
			</div>
		</div>
		
		<div class="col-xs-6">			
			<?=$bpv_popular_tours?>
		</div>
	</div>
	
	<?php if(isset($halong_hotels)):?>
	<div class="bpv-hotel-destinations margin-top-20">
		<h2 class="bpv-color-title"><span class="icon icon-hotel-des"></span> <?=lang('halong_hotels')?></h2>
		<div class="row">
			<?php foreach ($halong_hotels as $hotel):?>
			<div class="col-xs-2">
				<a href="<?=hotel_build_url($hotel)?>"><?=$hotel['name']?></a>
			</div>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
</div>

<?=$bpv_register?>