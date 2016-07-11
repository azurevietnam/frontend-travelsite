<?=$check_rate_form?>
<div class="tour_accommodations" style="margin-top: 10px;<?php if(isset($is_extra_booking)):?> width: 100%;<?php endif;?>">
<table class="tour_accom">
	<thead>
		<tr>
			<th width="77%" align="left"><?=lang('accommodation')?></th>
			<th width="23%"><?=lang('lb_rates')?></th>
		</tr>
	</thead>
	<tbody>
		<?php $cnt=0;?>
		<?php foreach ($tour['accommodations'] as $accommodation):?>
		<tr>
			<td>
				<a href="javascript:void(0)" onclick="return show_accomm_detail(<?=$accommodation['id']?>);"><span id="img_<?=$accommodation['id']?>" class="togglelink"></span><?=$accommodation['name']?></a>
				<div class="clearfix"></div>
				
				<div style="float: left;display: none; width: 100%;" id="accomm_detail_<?=$accommodation['id']?>">
					<?php if(!empty($accommodation['cruise_cabin_id'])):?>
						<div style="border: 0px solid #FEBA02; padding: 10px 0; float: left; width: 100%;">
							<div style="float: left;width: 100%; margin-bottom: 7px;">
								
								<?php if(!isset($is_extra_booking)):?>
									<div class="highslide-gallery">
										<a href="<?=$this->config->item('cruise_medium_path').$accommodation['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
											<img style="border:0" src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
										</a>
											
										<div class="highslide-caption">
											<center><b><?=$accommodation['name']?></b></center>
										</div>					
									</div>
								<?php else:?>
									<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<?php endif;?>
								
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							
							<?php if(!empty($accommodation['cabin_facilities'])):?>
								<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>						
								<ul class="accomm_cabin_facility" style="width: 100%;">
		
									<?php foreach ($accommodation['cabin_facilities'] as $fkey => $value) :?>																		
										
										<li><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>
																												
									<?php endforeach ;?>
								</ul>
								
							<?php endif;?>
							
						</div>
				
					<?php elseif(!empty($accommodation['content'])):?>
						
						<?php					
							$acc_contents = explode("\n", $accommodation['content']);					
						?>
						
						<ul style="margin-left: 12px;">
							<?php foreach ($acc_contents as $value):?>
								<?php if (trim($value) != ''):?>
									<li style="margin-top: 5px;"><?=format_object_overview($value)?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
						
					
					<?php endif;?>
				</div>	
			</td>
			<?php if($cnt==0):?>
				<td rowspan="<?=count($tour['accommodations'])?>" align="center">
					<span class="icon icon-arrow-up"></span><br>
					<b><?=lang('label_enter_your_departure_date')?></b>
				</td>
			<?php $cnt++;endif;?>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>

<?php if(!isset($is_extra_booking)):?>
	
	<?php if($tour['partner_id'] == BESTPRICE_VIETNAM_ID):?>
		<div class="claim_best_price"><span class="icon icon_checkmark" style="margin-bottom: -2px;"></span><a href="/customize-tours/<?=$tour['url_title']?>/" rel="nofollow"><b><?=lang('label_customize_this_tour')?> &raquo;</b></a></div>		
	<?php endif;?>
				
	<?php if(count($recommendations) > 0):?>
		
		<div class="saving_tips highlight">
			<span class="icon deal_icon"></span>
			<span class="tip_text"><?=lang('extra_saving')?>:</span>
			<span><?=get_recommendation_text($recommendations)?>&nbsp;</span>
			<a href="javascript:void(0)" class="tip_text" style="text-decoration:underline;" onclick="go_book_together_position()"><?=lang('see_deals')?> &raquo;</a>		
		</div>
		
	<?php endif;?>
		
<?php endif;?>
		
</div>
<!-- 
<?php if(!isset($is_extra_booking)):?>
	<div class="cleafix" style="padding-top: 10px;"></div>
	<?=$price_include_exclude?>

<?php endif;?>
 -->