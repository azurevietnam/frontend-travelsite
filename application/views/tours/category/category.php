<div class="container-fluid no-padding margin-bottom-20" style="position: relative;">
	<div class="container">
		<ol class="breadcrumb margin-bottom-10">
			<li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
			<li><a href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
			<li class="active"><?=lang('label_category')?></li>
		</ol>
		<h1 class="bpv-color-title margin-top-0" style="display:inline-block;"><span class="icon icon-destination-none"></span><?=lang('label_category')?></h1>
		
		<h3 class="bpv-color-title margin-top-0" style="display:inline-block;"> - <?=lang('marketing_category_tours')?></h3>
		
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
		<div class="bpv-filter-box">
		<?=load_view_tour_destination(NAV_VIEW_DOMESTIC)?>
		</div>
		<div class="bpv-filter-box">
		<?=load_view_tour_destination(NAV_VIEW_OUTBOUND)?>
		</div>
		<?=$departure_from;?>
		
		<?=$tour_durations?>
		
		<?=load_hotline_suport(TOUR)?>
	</div>
	
	<div class="bpv-col-right">
	
		<p><?=lang('marketing_category_page')?></p>
	
		<div class="bpv-newbox clearfix margin-bottom-20">
		
			<h3><?=lang('popular_tour_categories')?></h3>
			<?php $i = 0;?>
			<?php foreach($categories as $ct):?>
			<div class="category-col text-center margin-bottom-10">
				<a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $ct);?>">
				<img class="margin-top-20 margin-bottom-20" src="<?=get_static_resources('images/categories/'.$ct['picture'])?>" /><br/>
				<span class="bpv-a-color-default" style="font-size:15px"><?=$ct['name']?></span></a>
			</div>
			<?php ++$i;?>
			<?php if($i%5 ==0):?>
				<div class="clearfix"></div>
			<?php endif;?>
			<?php endforeach;?>
			 
		</div>
		
		
		<?=$recommended_tours_by_cat?>	
			
		<?=$tour_contact?>	
	</div>
	<div class="clearfix margin-bottom-20"></div>
	<?=$footer_links?>
	
</div>
<?=$bpv_register?>

<script>
$('.group-name').bpvToggle();
</script>
