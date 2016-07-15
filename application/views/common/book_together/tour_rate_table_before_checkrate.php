<table class="tour_accom" style="width:720px">
	<thead>
		<tr>
			<th width="77%" align="left"><?=lang('accommodation')?></th>
			<th width="23%"><?=lang('rates')?></th>
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
								<img src="<?=$this->config->item('cruise_220_165_path').$accommodation['picture']?>" class="accomm_cabin_img">
								<ul>
									<li><b><?=lang('cabin_size')?>:</b> <?=$accommodation['cabin_size']?> m<sup style="font-size:8px;">2</sup></li>
									<li><b><?=lang('bed_size')?>:</b> <?=$accommodation['bed_size']?></li>							
								</ul>
								
								<p><?=$accommodation['cabin_description']?></p>	
							</div>
							<?php if(!empty($accommodation['cabin_facilities'])):?>
							
							<p style="margin-bottom: 7px;"><b><?=lang('cabin_facilities')?>:</b></p>							
							<ul class="accomm_cabin_facility">							
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
									<li style="margin-top: 5px;"><?=$value?></li>
								<?php endif;?>
							<?php endforeach;?>
						</ul>
						
					
					<?php endif;?>
				</div>	
			</td>
			<?php if($cnt==0):?>
				<td rowspan="<?=count($tour['accommodations'])?>" align="center">
					<span class="icon icon-arrow-up"></span><br>
					<b><?=lang('enter_your_departure_date')?></b>
				</td>
			<?php $cnt++;endif;?>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
