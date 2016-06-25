<div class="container margin-bottom-20">
    <ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=site_url(TOUR_HOME_PAGE).'/'?>"><?=lang('mnu_tours')?></a></li>
	  <?php if($tour_destination_detail['is_outbound'] == TOUR_OUTBOUND):?>
	  <li><a href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"><?=lang('label_outbound_tours')?></a></li>
	  <?php else:?>
	  <li><a href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"><?=lang('label_domestic_tours')?></a></li>
	  <?php endif;?>
	  <li class="active">
	 	<?=$tour_destination_detail['name']?>
	  </li>
	</ol>
	<div class="bpv-col-left">
		<?=$bpv_search;?>
		
		<div class="bpv_call_us margin-top-20">
			<?=load_bpv_call_us(TOUR)?>
		</div>
		
		<?=load_hotline_suport(TOUR)?>
		
	</div>
	
	<div class="bpv-col-right">
		<div class="col-name">
			<h1 class="bpv-color-title margin-top-0"><?=$tour_destination_detail['name']?><?php if($tour_destination_detail['marketing_title'] != ''):?> - <?=$tour_destination_detail['marketing_title']?><?php endif;?></h1>
		</div>
		
		<div class="photos">
			<?=load_slider($photos, DESTINATION)?>
		</div>
		
		<div class="margin-top-20">
			<?=insert_data_link($tour_destination_detail['description']);?>
			
			<?php 
				$travel_tip = $tour_destination_detail['travel_tip'];
				$travel_tip_arr = explode("\n", $travel_tip);
			?>
		
			<?php if($travel_tip !=""):?>
			<?php if(count($travel_tip_arr) >0):?>
			<span class="bpv-color-title clearfix title_suggestions"><?=lang('destination_suggestions')?> <?=$tour_destination_detail['name']?></span>
			
				<?php foreach($travel_tip_arr as $k =>$tip):?>
					<?php if(isset($tip)):?>
					<p>
						<?=$k+1?>. <?=insert_data_link($tip)?>
					</p>
					<?php endif;?>
				<?php endforeach?>
				
			<?php endif;?>
			<?php endif;?>
			
			<?php if(count($activities) >0):?>
			<div class="activity">
				<h3><span class="icon icon-activity"></span><?=lang('destination_activities')?> <?=$tour_destination_detail['name']?></h3>
				<?php foreach($activities as $act):?>
					<div class="act margin-bottom-10">
						<img class="img-circle" width="110px" height="110px" src="<?=get_image_path(DESTINATION, $act['photo'])?>"/>
						<div class="content_act" style="float:left;">
							<span class="bpv-color-title"><?=$act['name']?></span>
							<?=insert_data_link($act['description']);?>
						</div>
					</div>
				
				<?php endforeach;?>
			</div>
			<?php endif;?>
			<?php if(count($destination_travel) >0):?>
			<div class="destination margin-top-20">
				<h3><?=lang('destination_of_travel')?> <?=$tour_destination_detail['name']?></h3>
				<div class="destination_box">
					<?php foreach($destination_travel as $des_travel):?>
						<div class="row margin-top-5 margin-bottom-20">
							<div class="col-xs-3">
								<a href="<?=get_url(TOUR_DESTINATION_DETAIL_PAGE, $des_travel)?>"><img src="<?=get_image_path(DESTINATION, $des_travel['photo'], '200x150')?>"/></a>
							</div>
							<div class="col-xs-9">
								<h4><a href="<?=get_url(TOUR_DESTINATION_DETAIL_PAGE, $des_travel)?>"><?=$des_travel['name']?></a></h4>
								
								<?=insert_data_link($des_travel['description_short']);?>
							
							</div>
						</div>
					<?php endforeach;?>
				</div>
			</div>
			<?php endif;?>
			
			<?php if($count_land_tour >0):?>
			<div class="destination margin-top-20">
				<h3><?=lang('tour_in_destination')?> <?=$tour_destination_detail['name']?></h3>
				<div class="destination_tour">
					<?=$tour_land;?>
				</div>
			</div>
			<?php endif;?>
			
			<?php if($count_over_land_tour >0):?>
			<div class="destination margin-top">
				<h3><?=lang('tour_over_destination')?> <?=$tour_destination_detail['name']?></h3>
				<div class="destination_tour">
					<?=$tour_over_land;?>
				</div>
			</div>
			<?php endif;?>
		 
		</div>
	</div>
</div>

<?=load_data_overview_modal()?>

<?=$bpv_register?>