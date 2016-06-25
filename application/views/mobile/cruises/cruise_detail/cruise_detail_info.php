<?php if(count($cruise_facilities) > 0):?>
	<div class="bpv-collapse margin-top-2">
		<h5 class="heading no-margin" data-target="#cruise_facility">
    		<i class="icon icon-star-white"></i>
    		<?=lang('cruise_facility_of')?> <?=$cruise['name']?>
    		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
		</h5>
		
		<div id="cruise_facility" class="content hotel-facility">
		<?php 
			$fa_index  = 0;
		?>
		<?php foreach ($cruise_facilities as $key=>$facility_values):?>
	
			<div class="clearfix margin-bottom-10">
				<div class="item-title bpv-color-title">
					<?=$facility_groups[$key]?>
				</div>
				
				<div class="col-xs-12 no-padding">
					<?php foreach ($facility_values as $value):?>
						<div class="col-xs-6 pd-left-0 margin-bottom-5">
							<img src="<?=get_static_resources('media/icon/hotel_detail/fa_check.png')?>" class="margin-right-5">
							<span <?php if($value['is_important']):?>style="color:#4eac00;"<?php endif;?>>
							<?=$value['name']?>
							</span>	
						</div>
					<?php endforeach;?>
				</div>
			</div>	
			
			<?php 
				++$fa_index;
			?>
		
		<?php endforeach;?>
		</div>
	</div>
<?php endif;?>

<div class="bpv-collapse margin-top-2">
    <h5 class="heading no-margin" data-target="#cruise_detail_desc">
		<i class="icon icon-star-white"></i>
		<?=lang('cruise_description_of')?> <?=$cruise['name']?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white"></i>
	</h5>
	<div id="cruise_detail_desc" class="content">
		<p><?=$cruise['description']?></p>
		
		<h5 class="margin-top-10 bpv-color-title"><b><?=lang('cruise_policy_of')?> <?=$cruise['name']?></b></h5>
		
		<div class="row">
			<div class="col-xs-6"><?=lang('checkin_time')?>:</div>
			<div class="col-xs-6"><?=$cruise['check_in']?></div>
		</div>
		
		<div class="row">
			<div class="col-xs-6"><?=lang('checkout_time')?>:</div>
			<div class="col-xs-6"><?=$cruise['check_out']?></div>
		</div>
		
		<div class="row margin-top-10">
			<div class="col-xs-12"><b><?=lang('checkin_policy')?></b></div>
			<div class="col-xs-12">
				<?=lang('checkin_policy_content')?>
			</div>
		</div>
		
		<div class="row margin-top-10">
		    <div class="col-xs-12 margin-bottom-5"><b><?=lang('cancellation_policy')?></b></div>
			<div class="col-xs-12">
				<div class="margin-bottom-5"><?=lang('cal_content_1')?></div>
				<div class="margin-bottom-5"><span class="icon icon-asterisk margin-right-5"></span> <?=lang('cal_content_2')?>:</div>
				<div class="margin-bottom-5" style="padding-left:15px">
					<?php if(!empty($cruise['extra_cancellation'])):?>
						<?=$cruise['extra_cancellation']?>
					<?php elseif(!empty($default_cancellation['content'])):?>
						<?=$default_cancellation['content']?>
					<?php endif;?>
				</div>
				
				<div class="margin-bottom-5"><span class="icon icon-asterisk margin-right-5"></span> <?=lang('cal_content_3')?>:</div>
				
				<div class="margin-bottom-5">
					<?=lang('cal_content_4')?>
				</div>
				
			</div>
		</div>
		
		<div class="row margin-top-10">
		    <div class="col-xs-12 margin-bottom-5"><b><?=lang('children_extra_bed')?></b></div>
			<div class="col-xs-12">
			    <label> 
    			    <span class="icon icon-infant margin-right-5"></span>
    			    <?=str_replace('<year>', $cruise['infant_age_util'], lang('infant_policy_label'))?>
			    </label><br>
			    <p><?=$cruise['infants_policy']?></p>
				<label>
				     <?php 
    					$chd_txt = lang('children_policy_label');
    					$chd_txt = str_replace('<from>', $cruise['infant_age_util'], $chd_txt);
    					$chd_txt = str_replace('<to>', $cruise['children_age_to'], $chd_txt);
    					echo $chd_txt;
    				?>
				</label><br>
			    <p><?=$cruise['children_policy']?></p>
				
				<div class="margin-bottom-10">
    				<span class="icon icon-asterisk margin-right-5"></span> 
    				<?=str_replace('<year>',$cruise['children_age_to'],lang('adults_info'))?>
				</div>
				<div><span class="icon icon-asterisk margin-right-5"></span> <?=lang('extra_bed_info')?></div>
				
			</div>
		</div>
		 
	</div>
</div>