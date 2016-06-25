<?php if(isset($cruise)):?>
	<div class="photos">
		<?=load_slider($photos, CRUISE)?>
	</div>
	<div class="cruise_popup">
		<h3><span class="icon icon-cruise-popup"></span><?=$cruise['name']?> <?=$cruise['star']?> <span class="icon star-large"></span></h3> 
		<span class="pull-right pd-right-10"> <?php //=show_review($cruise, cruise_build_url($cruise))?></span>
	</div>
	<div class="cruise_popup_text">
		<?=$cruise['description'];?>
	</div>
	<div class="cruise_popup_cabin">
		<h3><?=lang('cabin')?>:</h3>
		<div class="cruise_popup_cabin_box">
			<?php foreach($cruise_cabins as $key => $cabin):?>
				<div class="col-xs-4">
					<?php if(!empty($cabin['picture'])):?>
						<img src="<?=get_image_path(CRUISE, $cabin['picture'],'120x90')?>" alt="<?=$cabin['name']?>" width="100%" />
						<?php $info_arr = explode(",", get_cruise_cabin_square_m2($cabin));?>
						<p class="text-center bpv-color-hightlight margin-top-20"><b><?php if(isset($info_arr[0])){echo character_limiter($info_arr[0], 28);}?></b></p>
						<p class="text-center"><?php if(isset($info_arr[1])){ echo character_limiter($info_arr[1], 28); }?></p>
					<?php else:?>
						&nbsp;
					<?php endif;?>
				</div>
			<?php endforeach;?>
		</div>
		
		<div class="margin-top-20">
			<a target="_blank" href="<?=get_url(CRUISE_HL_DETAIL_PAGE, $cruise);?>" class="btn btn-primary btn-lg btn-bpv btn-view-detail pull-right" role="button" style="margin-right:35px"><span class="icon icon-btn-arrow-blue"></span><?=lang('view_details')?></a>
		</div>
	</div>
	
	
<?php else:?>
	<center><?=lang('no_data_found')?></center>
<?php endif;?>
