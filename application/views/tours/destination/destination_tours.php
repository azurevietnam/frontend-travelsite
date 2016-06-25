<div class="container-fluid no-padding margin-bottom-20" style="position: relative;">
	<div class="container">
		<ol class="breadcrumb margin-bottom-10">
			<li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
			<li><a href="<?=site_url(TOUR_HOME_PAGE)?>"><?=lang('mnu_tours')?></a></li>
			<?php if($destination['is_outbound'] == TOUR_DOMESTIC):?>
    		<li><a href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"><?=lang('label_domestic_tours')?></a></li>
    		<?php else:?>
    		<li><a href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"><?=lang('label_outbound_tours')?></a></li>
    		<?php endif;?>
    		
    		<?php if(!empty($destination['nav_destinations'])):?>
    		<?php foreach ($destination['nav_destinations'] as $des):?>
    		<li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
    		<?php endforeach;?>
    		<?php endif;?>
    		
			<li class="active"><?=lang_arg('label_tour_departing', $destination['name'])?></li>
		</ol>
		<h1 class="bpv-color-title margin-top-0" style="display:inline-block; white-space: nowrap;">
			<span class="icon icon-destination-none"></span>
			<?=lang_arg('label_travel', $destination['name'])?>
			<?php if($destination['marketing_title']):?> 
				<span class="bpv-color-title margin-top-0" style="display:inline-block; font-weight: normal; font-size: 20px">- <?=$destination['marketing_title']?> </span>
			<?php endif;?>
		</h1>
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
				
			<?php if(isset($popular_sub_destination)):?>
				<?=$popular_sub_destination?>
			<?php endif;?>
			
			<?=$departure_from;?>
			
			<?=$tour_durations;?>
			
			<?=load_hotline_suport(TOUR)?>
			 
		</div>
		<div class="bpv-col-right">
			
			<h2 class="bpv-color-title"><?=lang_arg('popular_tours_in_des', $destination['name'])?></h2>
			
			<?=$destination_tours;?>
			
			<?php if($destination['is_outbound'] == TOUR_DOMESTIC && $destination['nr_tour_domistic'] > 10):?>
			<div class="view-more pull-right">
				<a href="<?=$more_link;?>">
					<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
					<?=lang_arg('view_more', $destination['nr_tour_domistic'])?> <?=$destination['name']?>
				</a>
			</div>
			<?php elseif($destination['is_outbound'] == TOUR_OUTBOUND && $destination['nr_tour_outbound'] > 10):?>
			<div class="view-more pull-right">
				<a href="<?=$more_link;?>">
					<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
					<?=lang_arg('view_more', $destination['nr_tour_outbound'])?> <?=$destination['name']?> 
				</a>
			</div>
			<?php endif;?>
			
			<div class="clearfix"></div>
			
			<?=$tour_contact?>	
		</div>
		<div class="clearfix margin-bottom-20"></div>
			<?=$footer_links?>
		
</div>

<?=$bpv_register?>