<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
 
<?php if (count($cruise['normal_cabins']) > 0 || count($cruise['room_cabins']) > 0):?>
<div class="tour_accommodations">
	<table class="tour_accom margin_top_10" cellpadding="0" cellspacing="0" width="698">
		<thead>
			<tr>
				<th width="40%" align="center"><?=lang('cruise_cabin')?></th>
				<th width="15%" align="center"><?=lang('cabin_size')?></th>
				<th width="20%" align="center"><?=lang('bed_size')?></th>
				<th width="25%" align="center"><?=lang('rates')?></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($cruise['normal_cabins'] as $key => $cabin):?>
				<tr>
					<td>						
						<img align="top" width="80" height="60" style="margin-right: 5px; float: left;" src="<?=$this->config->item('cruise_80_60_path').$cabin['picture']?>"></img>
								
						<a id="<?=$cabin['id']?>" href="javascript: void(0);" onclick="return openCabinInfo(this);"><span class="togglelink"></span><?=$cabin['name']?></a>
					</td>
					<td align="center"><?=$cabin['cabin_size']?> <?=lang('cruise_m2')?></td>
					<td align="center">
						<?=$cabin['bed_size']?>
					</td>
					
					<?php if($key == 0):?>
						<td align="center" rowspan="<?=count($cruise['normal_cabins'])?>">
							<span class="icon icon-arrow-up"></span><br>
							<b><?=lang('label_enter_your_departure_date')?></b>		
						</td>
					<?php endif;?>
				</tr>
				
				<tr id="cabin_detail_<?=$cabin['id']?>" style="display: none;">
					<td colspan="3">				
						<div class="cabin_image">
							<div style="position: relative;">	
								<div class="highslide-gallery">
									<a href="<?=$this->config->item('cruise_medium_path').$cabin['picture']?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
										<img style="border:0" id="cabin_<?=$cabin['id']?>" src="<?=$this->config->item('cruise_220_165_path').$cabin['picture']?>"/>
									</a>
										
									<div class="highslide-caption">
										<center><b><?=$cabin['name']?></b></center>
									</div>					
								</div>
								
							</div>
						</div>	
						<p style="margin-top: 0; margin-bottom: 7px;">
							<b><?=lang('cabin_size')?>:</b> <?=$cabin['cabin_size']?> <?=lang('cruise_m2')?><br>
							<b><?=lang('bed_size')?>:</b> <?=$cabin['bed_size']?>
						</p>
						<?php 
							$descriptions = str_replace("\n", "<br>", $cabin['description']);
						?>
						<p style="margin-top: 0px; margin-bottom: 0"><?=$descriptions?></p>		
						
						<?php if(isset($cruise_cabin_facilities[$cabin['id']])):?>
							
							<p style="clear: both; margin-top: 0; margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>
								
							<ul style="font-size: 11px;">
							<?php foreach ($cruise_cabin_facilities[$cabin['id']] as $value) :?>																		
								<li style="float: left; margin-bottom: 5px; width: 33%"><span class="icon icon_checkmark" style="margin-bottom:-2px"></span><?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?></li>																		
							<?php endforeach ;?>		
							</ul>										
						<?php endif;?>
										
					</td>						
				</tr>	
			<?php endforeach;?>
		</tbody>
	</table>
	
</div>
<?php endif;?>
