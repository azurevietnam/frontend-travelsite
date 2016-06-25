<?php if(isset($destination)):?>
	<div class="photos">
		<?=load_slider($photos, DESTINATION)?>
	</div>
	<div class="destination_marketing">
		<h3><span class="icon icon-destination"></span><?=$destination['name']?><?php if($destination['marketing_title'] != ""):?> - <?=$destination['marketing_title']?><?php endif;?></h3>
		<div class="description_short_text margin-top-20">
			<?=$destination['description_short'];?>
		</div>
	</div>
	<?php if(count($activities) >0):?>
	<div class="activity">
		<h3><span class="icon icon-activity"></span><?=lang('destination_activities')?> <?=$destination['name']?></h3>
		<?php foreach($activities as $act):?>
			<div class="act margin-bottom-10">
				<img class="img-circle" width="110px" height="110px" src="<?=get_image_path(DESTINATION, $act['photo'])?>"/>
				<div class="content_act" style="float:left;">
					<span class="bpv-color-title"><?=$act['name']?></span>
					<?=$act['description'];?>
				</div>
			</div>
		
		<?php endforeach;?>
	</div>
	<?php endif;?>
	
	<?php if(count($destination_travel) >0):?>
	<div class="destination">
		<h3><span class="icon icon-travel"></span><?=lang('destination_of_travel')?> <?=$destination['name']?></h3>
		<div class="destination_box">
			<?php $i = 0;?>
			<?php foreach($destination_travel as $des_travel):?>
			<?php ++$i;?>
				<div class="col-xs-3">
					<a href="<?=get_url(TOUR_DESTINATION_DETAIL_PAGE, $des_travel)?>">
						<img src="<?=get_image_path(DESTINATION, $des_travel['photo'], '200x150')?>" width="100%"/>
					</a>
					<p class="text-center bpv-color-hightlight"><?=insert_data_link('<des id='.$des_travel['id'].'>'.character_limiter($des_travel['name'], 28).'</des>')?></p>
				</div>
			<?php if($i %4 ==0):?>
				<div class="clearfix"></div>
			<?php endif;?>
			<?php endforeach;?>
		</div>
	</div>
	<?php endif;?>
	<div class="destination">
		<?php 
			$travel_tip = $tour_destination_detail['travel_tip'];
			$travel_tip_arr = explode("\n", $travel_tip);
		?>
	
		<?php if($travel_tip !=""):?>
		<?php if(count($travel_tip_arr) >0):?>
		<h3 class="bpv-color-title"><span class="icon icon-suggestions"></span><?=lang('destination_suggestions')?> <?=$tour_destination_detail['name']?></h3>
		<div class="margin-top-20 description_short_text">
			<?php foreach($travel_tip_arr as $k =>$tip):?>
				<?php if(isset($tip)):?>
				<p>
					<?=$k+1?>. <?=$tip?>
				</p>
				<?php endif;?>
			<?php endforeach?>
		</div>
		<?php endif;?>
		<?php endif;?>
	
		<div class="margin-top-10">
			<a target="_blank" href="<?=get_url(TOUR_DESTINATION_DETAIL_PAGE, $destination);?>" class="btn btn-primary btn-lg btn-bpv btn-view-detail pull-right" role="button" style="margin-right:35px"><span class="icon icon-btn-arrow-blue"></span><?=lang('view_details')?></a>
			
		</div>
	</div>
	
<?php else:?>
	<center><?=lang('no_data_found')?></center>
<?php endif;?>
