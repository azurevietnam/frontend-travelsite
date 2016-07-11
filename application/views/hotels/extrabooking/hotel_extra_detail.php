
<?php 

	$img_url = $this->config->item('hotel_medium_path');
							
	if ($hotel['img_status'] == 1){
		$img_url = $this->config->item('hotel_800_600_path');
	}
	
?>
	
<div class="main_image">
	<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$hotel['picture']?>" class="highslide" onclick="return hs.expand(this);">
	<img style="border: 0" alt="<?=get_alt_image_text_hotel($hotel)?>" src="<?=$this->config->item('hotel_375_250_path').$hotel['picture']?>"></img>
	</a>
			
	<div class="highslide-caption">
		<center><b><?=get_alt_image_text_hotel($hotel)?></b></center>
	</div>
</div>

<div id="list_image">
		<?php $count = 1;?>
		<?php foreach ($hotel['room_types'] as $key =>$value) :?>
			<?php if($count <= 9):?>
				
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['picture']?>" class="highslide" onclick="return hs.expand(this,{width:468});">
					<img style="cursor: pointer; padding: 10px; border: 1px solid #CCC;" id="img_room_<?=$key?>" src="<?=$this->config->item('hotel_80_60_path').$value['picture']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['name']?></b></center>
				</div>
					
			<?php endif;?>
			<?php $count++;?>	
		<?php endforeach;?>
		
		<?php foreach ($hotel['photos'] as $key =>$value) :?>
			<?php if($count <= 9):?>
			
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['name']?>" class="highslide" onclick="return hs.expand(this);">
						<img style="cursor: pointer; padding: 10px; border: 1px solid #CCC;" id="img_<?=$key?>" src="<?=$this->config->item('hotel_80_60_path').$value['name']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['description']?></b></center>
				</div>
				
			<?php endif;?>
			<?php $count++;?>
		<?php endforeach;?>
		
</div>
		
	
<div class="cleafix"></div>


	<p id="short_desc">
		<?=get_short_description($hotel['description'])?>
		
		<?php if(strlen(replace_newline_in_description($hotel['description'])) > SHORT_HOTEL_DESCRIPTION_CHR_LIMIT):?>
		
			<a href="javascript:void(0)" onclick="readmore()" class="function"><?=lang('hotel_more') ?> &raquo;</a>
		
		<?php endif;?>
	</p>

	<?php if(strlen(replace_newline_in_description($hotel['description'])) > SHORT_HOTEL_DESCRIPTION_CHR_LIMIT):?>
	<p id="full_desc" style="display: none;">
		<?=replace_newline_in_description($hotel['description'])?>
		
		<a href="javascript:void(0)" onclick="readless()" class="function"><?=lang('hotel_less') ?> &laquo;</a>
	</p>
	<?php endif;?>
	 
	
	<p><b><?=lang('hotel_rooms')?>: <?=$hotel['number_of_room']?></b></p>

<div class="clearfix"></div>

<table class="tour_accom margin_top_10" cellpadding="0" cellspacing="0" width="698">
		<thead>
			<tr>
				<td width="40%" align="center"><?=lang('hotel_room') ?></td>
				<td width="20%" align="center"><?=lang('room_size') ?></td>
				<td width="20%" align="center"><?=lang('bed_size') ?></td>
				<td width="20%" align="center"><?=lang('hotel_extra_bed') ?></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($hotel['room_types'] as $key => $value):?>
				<tr>
					<td>						
						<img id="room_<?=$key?>" align="top" width="80" height="60" style="cursor: pointer;" src="<?=$this->config->item('hotel_80_60_path').$value['picture']?>"></img>
								
						<a href="javascript:void(0)" onclick="openRoomTypeInfo(<?=$value['id']?>)">
							<span id="img_<?=$value['id']?>" class="togglelink"></span><?=$value['name']?> 
						</a>
					</td>
					<td align="center"><?=$value['room_size']?> m2</td>
					<td align="center">
						<?=$value['bed_size']?>
					</td>
					<td align="center">
						<?php if($value['extra_bed_allow'] == 1):?>
							Yes
						<?php else:?>
							No
						<?php endif;?>				
					</td>
				</tr>
				
				<tr id="detail_infor_<?=$value['id']?>" style="display: none;">
					<td colspan="4" style="padding-top: 0px;">				
							
							<div style="padding-bottom: 10px;">
								<div style="position: relative; float: left; padding: 0 10px 10px 0;">	
									<img width="220" height="165" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>"/>
								</div>	
								<?php 
									$descriptions = str_replace("\n", "<br>", $value['description']);
								?>
								<p>
								<?=$descriptions?>
								</p>	
								
								<?php if(isset($value['facilities'])):?>								
									
									<p style="clear: both;"><b><?=lang('hotel_room_facilites') ?>:</b></p>
									
									<ul>
									<?php foreach ($value['facilities'] as $f_value):?>																	
										<li style="float: left; width: 33%; padding-bottom: 5px;"><span class="icon icon_checkmark"></span><?=$f_value['name']?></li>																	
									<?php endforeach ;?>
											
									</ul>
								
								
								<?php endif;?>
																						
						</div>					
					</td>						
				</tr>	
			<?php endforeach;?>
		</tbody>
	</table>

<div id="hotel_photos" class="margin_top_10">
	<div class="item_header">
		<h2 class="item_header_text"><?=lang('hotel_photos') ?></h2>
	</div>
	
	<p><?=lang('hotel_photos_description').'<b>'.$hotel['name'].'</b>'?>:</p>
	
	<div style="width: 100%">
		<div class="highslide-gallery">	
		<?php foreach ($hotel['room_types'] as $key =>$value) :?>
			<div style="float: left; margin-right: 12px; width: 220px; height: 192px">
			
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['picture']?>" class="highslide" onclick="return hs.expand(this);">
					<img style="border: 0" alt="<?=$value['name']?>" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['name']?></b></center>
				</div>
					
				<div class="clearfix"></div>
				<center><b><?=$value['name']?></b></center>
				
			</div>
		<?php endforeach;?>
		
		<?php foreach ($hotel['photos'] as $key =>$value) :?>
			<div style="float: left; margin-right: 12px; width: 220px; height: 192px">
				
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['name']?>" class="highslide" onclick="return hs.expand(this);">		
					<img style="border: 0" alt="<?=$value['description']?>" src="<?=$this->config->item('hotel_220_165_path').$value['name']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['description']?></b></center>
				</div>
				
				<div class="clearfix"></div>
				<center><b><?=$value['description']?></b></center>				
			</div>					
		<?php endforeach;?>
		</div>
	</div>
	
</div>

<div id="hotel_facility" class="margin_top_10">
	<div class="item_header">
		<h2 class="item_header_text"><?=lang('hotel_facilities')?></h2>
	</div>
	
	<p><?=lang('hotel_facility_description').'<b>'.$hotel['name'].'</b>'?>:</p>
	
	<h2 class="highlight" style="padding-left:0; padding-top: 0"><?=lang('facility_general')?></h2>
	
	<div class="facility">
					
			<ul>
				<?php foreach ($system_hotel_facilities[HOTEL_FACILITY_GENERAL] as $key => $value) :?>
					
						
						<?php if (array_key_exists($key, $hotel_facilities) && $hotel_facilities[$key] == 1) :?>
							<li>							
								<span class="icon icon_checkmark"></span><?=$value?>
							</li>
						<?php else : ?>
							
						<?php endif ; ?>
															
								
					
				<?php endforeach ;?>
				
			</ul>
	</div>
	
	<h2 class="highlight" style="padding-left: 0; padding-top: 0"><?=lang('facility_services')?></h2>
	<div class="facility">
					
			<ul>
				<?php foreach ($system_hotel_facilities[HOTEL_FACILITY_SERVICE] as $key => $value) :?>
					
						
						<?php if (array_key_exists($key, $hotel_facilities) && $hotel_facilities[$key] == 1) :?>
							<li>							
								<span class="icon icon_checkmark"></span><?=$value?>
							</li>
						<?php else : ?>
							
						<?php endif ; ?>
															
								
					
				<?php endforeach ;?>
				
			</ul>
	</div>
	
	<h2 class="highlight" style="padding-left: 0; padding-top: 0"><?=lang('facility_activities')?></h2>
	<div class="facility">
					
			<ul>
				<?php foreach ($system_hotel_facilities[HOTEL_FACILITY_ACTIVITY] as $key => $value) :?>
					
						
						<?php if (array_key_exists($key, $hotel_facilities) && $hotel_facilities[$key] == 1) :?>
							<li>							
								<span class="icon icon_checkmark"></span><?=$value?>
							</li>
						<?php else : ?>
							
						<?php endif ; ?>
															
								
					
				<?php endforeach ;?>
				
			</ul>
	</div>
	
</div>

<div class="margin_top_10">
	<div class="item_header">
		<h2 class="item_header_text"><?=lang('hotel_policies')?></h2>
	</div>
	<p><?=lang('hotel_policies_description').'<b>'.$hotel['name'].'</b>'?>:</p>
	
	
	<div class="policy" style="padding-top: 0;">
		<div class="policy_item highlight">
			<p>						
				<?=lang('hotel_check_in')?>
			</p>
		</div>
		
		<div class="policy_content">
			<p><?=$hotel['check_in']?></p>
		</div>
	</div>
				
	<div class="policy" style="padding-top: 0;">
		<div class="policy_item highlight">
			<p>						
				<?=lang('hotel_check_out')?>
			</p>
		</div>
		
		<div class="policy_content">
			<p><?=$hotel['check_out']?></p>
		</div>
	</div>
	
	<div class="policy" style="padding-top: 0;">
		<div class="policy_item highlight">
			<p>						
				<?=lang('hotel_cancellation_prepayment')?>
			</p>
		</div>
		
		<div class="policy_content">
			<p><?=str_replace("\n", "<br>", $hotel['cancellation_prepayment'])?></p>
		</div>
	</div>
	
	
	<div class="policy" style="padding-top: 0;">
		<div class="policy_item highlight">
			<p>						
				<?=lang('children_extra_bed')?>
			</p>
		</div>
		
		<div class="policy_content">
			<p><?=str_replace("\n", "<br>", $hotel['children_extra_bed'])?></p>
		</div>
	</div>
	
	
	<?php if ($hotel['note'] != ''):?>
	
	<div class="policy" style="padding-top: 0;">
		<div class="policy_item highlight">
			<p>						
				<?=lang('note')?>
			</p>
		</div>
		
		<div class="policy_content">
			<p><?=str_replace("\n", "<br>", $hotel['note'])?></p>
		</div>
	</div>
	
	<?php endif;?>
</div>

<script type="text/javascript">

function readmore(){
	$('#short_desc').hide();
	$('#full_desc').show();
}

function readless(){
	
	$('#full_desc').hide();

	$('#short_desc').show();
}

function async_load(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = '/js/highslide/highslide-with-gallery.min.js';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);

    //document.body.appendChild(s);
}

//Create the tooltips only on document load
$(document).ready(function() 
{	
	async_load();
	
});

</script>
