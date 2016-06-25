<div class="container-fluid no-padding margin-bottom-20" style="position: relative;">
	<div class="container">
		<ol class="breadcrumb margin-bottom-10">
			<li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
			<li><a href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
			<li class="active"><?=lang('label_outbound_tours')?></li>
		</ol>
		<h1 class="bpv-color-title margin-top-0" style="display:inline-block; white-space: nowrap;">
			<span class="icon icon-destination-none"></span>
			<?=lang('label_outbound_tours')?>
		</h1>
		
		<h3 class="bpv-color-title margin-top-0" style="display:inline-block;"> - <?=lang('marketing_outbound_tours')?></h3>
	</div>
	
    <?=$bpv_ads?>
    <div class="container mod-search abs-center">
    	<?=$bpv_search?>
    </div>
</div>

<div class="container">
	
	<div class="bpv-col-left">
		
		<div class="bpv_call_us margin-bottom-20">
			<?=load_bpv_call_us(TOUR)?>
		</div>
		
		<?=$departure_from;?>
		
		<?=$tour_durations?>
		
		<?=load_hotline_suport(TOUR)?>
		
	</div>
	
	<div class="bpv-col-right">
		<p><?=lang('marketing_outbound_page')?></p>
		
		<?=$popular_destinations?>
		
		<?=$recommended_tours_by_cat?>
		
		<div class="margin-top-20">
			
			<h2 class="bpv-color-title">
				<span class="icon icon-more-category"></span>
				
				<?=lang('more_category_tours')?>
			</h2>
			
			<p><?=lang('marketing_category_page')?></p>
			
			<div>
				<?php foreach($categories as $ct):?>
					<?php if(empty($ct['tours'])):?>
					<div class="category-col text-center">
						<a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $ct);?>">
						<img class="margin-top-20 margin-bottom-20" src="<?=get_static_resources('images/categories/'.$ct['picture'])?>"/><br/>
						<span class="bpv-a-color-default" style="font-size:15px"><?=$ct['name']?></span></a>
					</div>
					<?php endif;?>
				<?php endforeach;?>
			</div>
		</div>
		<div class="clearfix"></div>
		<?=$tour_contact?>	
		
	</div>
	<div class="clearfix margin-bottom-20"></div>
	<?=$footer_links?>
	
</div>
<?=$bpv_register?>
