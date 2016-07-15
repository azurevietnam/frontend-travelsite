<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	$start_date_id = '#arrival_day_check_rate_'.$hotel['id'];
	$start_month_id = '#arrival_month_check_rate_'.$hotel['id'];
	$departure_date_id = '#arrival_date_check_rate_'.$hotel['id'];
	$night_id = '#hotel_night_check_rate_'.$hotel['id'];
	$departure_day_display_id = '#departure_date_check_rate_display_'.$hotel['id'];
	
	$img_url = $this->config->item('hotel_medium_path');
							
	if ($hotel['img_status'] == 1){
		$img_url = $this->config->item('hotel_800_600_path');
	}
?>

<div>
	<div class="highslide-gallery">		
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
	</div>
	
	<div class="cleafix"></div>
	<p id="short_desc">
		<?=get_short_description($hotel['description'])?>
		
		<?php if(strlen(replace_newline_in_description($hotel['description'])) > SHORT_HOTEL_DESCRIPTION_CHR_LIMIT):?>
		
			<a href="javascript:void(0)" onclick="readmore()" class="function"><?=lang('hotel_more') ?>&raquo;</a>
		
		<?php endif;?>
	</p>

	<?php if(strlen(replace_newline_in_description($hotel['description'])) > SHORT_HOTEL_DESCRIPTION_CHR_LIMIT):?>
	<p id="full_desc" style="display: none;">
		<?=replace_newline_in_description($hotel['description'])?>
		
		<a href="javascript:void(0)" onclick="readless()" class="function"><?=lang('hotel_less') ?> &laquo;</a>
	</p>
	<?php endif;?>
	 
	
	<p><b><?=lang('hotel_rooms')?>: <?=$hotel['number_of_room']?></b></p>
		
</div>

<div class="margin_top_10" id="hotel_check_rate_area">
	<div class="item_header">
		<h2 class="item_header_text"><?=lang('hotel_availability')?></h2>
	</div>
	<?=$check_rate_form?>
	
	<?=$check_rate_table?>
</div>

<div class="margin_top_10" style="width: 100%;">
	<div class="item_header">
		<h2 class="item_header_text"><?=lang('hotel_photos')?></h2>
	</div>
	<p><?=lang('hotel_photos_description').'<b>'.$hotel['name'].'</b>'?>:</p>
	
	<div style="width: 100%">
		<div class="highslide-gallery">
        <?php $cnt=0;?>
		
        <?php foreach ($hotel['room_types'] as $key =>$value) :?>
	        <?php 
				$margin_right = ($cnt + 1)%3 == 0 ? '0px' : '18px';
			?>
			
			<div class="hotel-photo" style="margin-right:<?=$margin_right?>;">
			
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['picture']?>" class="highslide" onclick="return hs.expand(this);">
					<img style="border: 0" alt="<?=$value['name']?>" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['name']?></b></center>
				</div>
					
				<div class="clearfix"></div>
				<center><b><?=$value['name']?></b></center>
				
			</div>
            <?php $cnt++;?>
		<?php endforeach;?>
		
		<?php foreach ($hotel['photos'] as $key =>$value) :?>
            <?php 
				$margin_right = ($cnt + 1)%3 == 0 ? '0px' : '18px';
			?>
			
			<div class="hotel-photo" style="margin-right:<?=$margin_right?>;">
				
				<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url.$value['name']?>" class="highslide" onclick="return hs.expand(this);">		
					<img style="border: 0" alt="<?=$value['description']?>" src="<?=$this->config->item('hotel_220_165_path').$value['name']?>">
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$value['description']?></b></center>
				</div>
				
				<div class="clearfix"></div>
				<center><b><?=$value['description']?></b></center>				
			</div>
            <?php $cnt++;?>
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

	function async_load(){
	    var s = document.createElement('script');
	    s.type = 'text/javascript';
	    s.async = true;
	    s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery.min.js','',true)?>';
	    var x = document.getElementsByTagName('script')[0];
	    x.parentNode.insertBefore(s, x);
	
	    //document.body.appendChild(s);
	}

	function readmore(){
		$('#short_desc').hide();
		$('#full_desc').show();
	}

	function readless(){
		
		$('#full_desc').hide();

		$('#short_desc').show();
	}

	function go_hotel_check_rate_position(){
		
		$("html, body").animate({ scrollTop: $("#hotel_check_rate_area").offset().top}, "fast");
	}	
	
	 // Create the tooltips only on document load
	$(document).ready(function() 
	{
		<?php if (isset($action) && $action == 'check_rate'):?>
			go_hotel_check_rate_position();
		<?php endif;?>
		
		$("#btn_check_rate_<?=$hotel['id']?>").click(function() {

			
			$("#frm_hotel_check_rate_<?=$hotel['id']?>").submit();
			
		});

		var this_date = '<?=date('d-m-Y')?>';

		var current_date = getCookie('arrival_date');
		
		if (current_date == null || current_date ==''){
			current_date = '<?=date('d-m-Y', strtotime($search_criteria['arrival_date']))?>';
		}

		initDate(this_date, current_date, '<?=$start_date_id?>','<?=$start_month_id?>', '<?=$departure_date_id?>', '<?=$night_id?>', '<?=$departure_day_display_id?>');

		
		var img = '<?=lang('extra_bed_help')?>';
		
		$("span[name='info']").tipsy({fallback: img, gravity: 's', html: true, width: '250px'});	
		
		
		$("#btn_book_<?=$hotel['id']?>").click(function() {

			if (checkRoomTypeBooking('<?=$hotel['id']?>')){
				
				$("#frm_hotel_reservation_<?=$hotel['id']?>").submit();

			} else {
				
				$("#booking_warning_<?=$hotel['id']?>").show();
			}
		});

		async_load();
		
	});
</script>
