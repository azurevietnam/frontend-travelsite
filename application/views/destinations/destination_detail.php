<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="contentMain" style="float: right;">
	
	<div class="des_header_area">
		
		<h1 style="padding-left:0;padding-top:0" class="highlight">
			<?=$destination['name']?>
			
			<?php if($destination['title'] != ''):?>
				
				<?=' - '.$destination['title']?>
				
			<?php endif;?>
			
		</h1>
		
		<div class="highslide-gallery">
			<div class="main_img">
				
				<?php 
					$img_url = $this->config->item('des_medium_path').$destination['picture_name'];
				?>
			
				<a id="des_gallery_main" href="<?=$img_url?>" rel="nofollow" class="highslide" onclick="return hs.expand(this);">
					<img id="main_image" style="float: left;border:0" alt="<?=$destination['name']?>" src="<?=$this->config->item('des_375_250_path').$destination['picture_name']?>"></img>
				</a>
				
				<div class="highslide-caption">
					<center><b><?=$destination['name']?></b></center>
				</div>
		
			</div>
		
			<div>				
				
				<?php 
					$count = 0;
				?>
				
				<?php foreach ($destination['photos'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('des_medium_path').$value['picture_name'];
						$count ++ ;
					?>
				
					<?php if($count <= 9):?>
						<a rel="nofollow" href="<?=$img_url?>" class="highslide" onclick="return hs.expand(this);">
						<img alt="<?=$value['comment']?>" class="list_image_item" id="img_<?=$key?>" width="80" height="60" src="<?=$this->config->item('des_80_60_path').$value['picture_name']?>">
						</a>
						<div class="highslide-caption">
							<center><b><?=$value['comment']?></b></center>
						</div>
					<?php endif;?>					
				<?php endforeach;?>
				
				<?php foreach ($destination['activities'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('activity_medium_path').$value['picture_name'];
						$count ++ ;
					?>
				
					<?php if($count <= 9):?>
						<a rel="nofollow" href="<?=$img_url?>" class="highslide" onclick="return hs.expand(this);">
						<img alt="<?=$value['name']?>" class="list_image_item" id="img_<?=$key?>" width="80" height="60" src="<?=$this->config->item('activity_80_60_path').$value['picture_name']?>">
						</a>
						<div class="highslide-caption">
							<center><b><?=$value['name']?></b></center>
						</div>
					<?php endif;?>					
				<?php endforeach;?>
				
				<?php foreach ($destination['attractions'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('des_medium_path').$value['picture_name'];
						$count ++ ;
					?>
				
					<?php if($count <= 9):?>
						<a rel="nofollow" href="<?=$img_url?>" class="highslide" onclick="return hs.expand(this);">
						<img alt="<?=$value['name']?>" class="list_image_item" id="img_<?=$key?>" width="80" height="60" src="<?=$this->config->item('des_80_60_path').$value['picture_name']?>">
						</a>
						<div class="highslide-caption">
							<center><b><?=$value['name']?></b></center>
						</div>
					<?php endif;?>					
				<?php endforeach;?>
				
				
				<?php foreach ($destination['photos'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('des_medium_path').$value['picture_name'];
						$count ++ ;
					?>
						
					<?php 
						if ($count <= 9) continue;	
					?>
					<div class="hidden-container">
						<a href="<?=$img_url?>" rel="nofollow" class="highslide" onclick="return hs.expand(this, {thumbnailId: 'des_gallery_main'});">
						</a>
							
						<div class="highslide-caption">
							<center><b><?=$value['comment']?></b></center>
						</div>					
					</div>
					
				
				<?php endforeach;?>
				
				<?php foreach ($destination['activities'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('activity_medium_path').$value['picture_name'];
						$count ++ ;
					?>
						
					<?php 
						if ($count <= 9) continue;	
					?>
					<div class="hidden-container">
						<a href="<?=$img_url?>" rel="nofollow" class="highslide" onclick="return hs.expand(this, {thumbnailId: 'des_gallery_main'});">
						</a>
							
						<div class="highslide-caption">
							<center><b><?=$value['name']?></b></center>
						</div>					
					</div>
					
				
				<?php endforeach;?>
				
				<?php foreach ($destination['attractions'] as $key =>$value) :?>
					
					<?php 
						$img_url = $this->config->item('des_medium_path').$value['picture_name'];
						$count ++ ;
					?>
						
					<?php 
						if ($count <= 9) continue;	
					?>
				
					<div class="hidden-container">
						<a href="<?=$img_url?>" rel="nofollow" class="highslide" onclick="return hs.expand(this, {thumbnailId: 'des_gallery_main'});">
						</a>
							
						<div class="highslide-caption">
							<center><b><?=$value['name']?></b></center>
						</div>					
					</div>					
				<?php endforeach;?>
						
			</div>
		
		</div>

	</div>
	<div class="clearfix"></div>
	<p style="padding-left:10px"><?=str_replace("\n", "<br>", $destination['detail_info'])?></p>

	<?php if($destination['travel_tips'] != ''):?>
		<div class="clearfix"></div>
		<div style="padding-left:10px;margin-bottom:15px">
			<h3 class="highlight" style="padding-left:0"><?=lang('overview_travel_tip')?> <?=$destination['name']?></h3>
		
			<?php 
				
				$travel_tips = explode("\n", $destination['travel_tips']);
			
			?>
		
			<ul class="trip_highlight" style="list-style:decimal;">
				
				<?php foreach ($travel_tips as $tip):?>
					<?php if(trim($tip) != ''):?>			
						<li style="margin-bottom:7px">
							<?=$tip?>
						</li>
					<?php endif;?>
				<?php endforeach;?>
				
			</ul>
		</div>
	<?php endif;?>
	
	<?php if(count($destination['activities']) > 0):?>
		
		<div class="item_header">
			<h3><span><?=lang('overview_activities_in')?> <?=$destination['name']?></span></h3>
		</div>
		
		<?php foreach ($destination['activities'] as $activity):?>
		
			<div class="des_activity">
				<img width="220" height="165" alt="<?=$activity['name']?>" src="<?=$this->config->item('activity_220_165_path').$activity['picture_name']?>">
				<h2 class="highlight"><?=$activity['name']?></h2>
				<p><?=str_replace("\n", "<br>", $activity['description'])?></p>
			</div>
		
		<?php endforeach;?>		
	
	<?php endif;?>
	
	<?php if(count($destination['attractions']) > 0):?>
		
		<div class="clearfix"></div>
		<div class="item_header">
			<h3><span><?=lang('overview_attractions_in')?> <?=$destination['name']?></span></h3>
		</div>
		
		<?php foreach ($destination['attractions'] as $attraction):?>
		
			<div class="des_activity">
				<a style="border:0" href="<?=url_builder(DESTINATION_DETAIL, url_title($attraction['name']), true)?>">
					<img width="220" height="165" alt="<?=$attraction['name']?>" src="<?=$this->config->item('des_220_165_path').$attraction['picture_name']?>">
				</a>
				<h2>					
					<a href="<?=url_builder(DESTINATION_DETAIL, url_title($attraction['name']), true)?>"><?=$attraction['name']?></a>
				</h2>
				<p><?=str_replace("\n", "<br>", $attraction['general_info'])?></p>
			</div>
		
		<?php endforeach;?>
		
		
	<?php endif;?>	
	
	<?php if(count($destination['land_tours']) > 0):?>
		
		<div class="clearfix"></div>		
		
		<div class="item_header">
			<h3><span><?=lang('destination_most_recommend')?> <?=$destination['name']?></span></h3>
		</div>
		
		<div class="recommendation_items" style="border-bottom:0; margin-top: 0">
		<?php foreach ($destination['land_tours'] as $tour):?>
			
			<div class="item">
				
				<div class="item_img">
					<img alt="<?=$tour['name']?>" src="<?=$this->config->item('tour_80_60_path') . $tour['picture_name']?>"/>
				</div>
				
				<div class="item_content" style="width:340px;">
				
					<div class="bpt_item_name item_name">
						
						<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><?=$tour['name']?></a>
						
					</div>
					
					<div class="row item_address">
						<?=character_limiter($tour['route'], 50)?>
					</div>
					
					<div class="row item_review">
						<?=get_full_review_text($tour, false)?>
					</div>
					
					<div class="row special" id="<?='offer_note_'.$tour['id']?>" style="display:none; font-size: 11px"></div>
					
					
							
				</div>
				
				<div class="item_price_from" style="width:152px;">
					<div class="cruise_price_from <?=$tour['id'].'block_price'?>" style="visibility: hidden;">
						<div class="text_info"><?=lang('bt_from')?></div>				
						<span class="<?=$tour['id'].'block_pro_price'?> b_discount">
							<?=CURRENCY_SYMBOL?><span class="<?=$tour['id'].'promotion_price'?>"></span>
						</span>
			        	<span class="price_from <?=$tour['id'].'from_price'?>"></span>
			        	<span><?=lang('per_pax')?></span>
					</div>
					    
				</div>
				
				<div class="item_price_discount">
					<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')" style="margin-top: 20px; margin-right: 0; float: right; margin-left: 0">
					 	<?=lang('view_more_detail')?>			 	
					 </div>
				</div>	
			
			</div>
		
		<?php endforeach;?>
		
	</div>
		
	<?php endif;?>
	
	
	<?php if(count($destination['include_tours']) > 0):?>
		
		<div class="clearfix"></div>		
		
		<div class="item_header" style="margin-top:15px">
			<h3><span><?=lang('destination_tour_including')?> <?=$destination['name']?></span></h3>
		</div>
		
		<div class="recommendation_items" style="border-bottom:0; margin-top: 0">
		<?php foreach ($destination['include_tours'] as $tour):?>
			
			<div class="item">
				
				<div class="item_img">
					<img alt="<?=$tour['name']?>" src="<?=$this->config->item('tour_80_60_path') . $tour['picture_name']?>"/>
				</div>
				
				<div class="item_content" style="width:340px;">
				
					<div class="bpt_item_name item_name">
						
						<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><?=$tour['name']?></a>
						
					</div>
					
					<div class="row item_address">
						<?=character_limiter($tour['route'], 50)?>
					</div>
					
					<div class="row item_review">
						<?=get_full_review_text($tour, false)?>
					</div>
					
					<div class="row special" id="<?='offer_note_'.$tour['id']?>" style="display:none; font-size: 11px"></div>
					
					
							
				</div>
				
				<div class="item_price_from" style="width:152px;">
					<div class="cruise_price_from <?=$tour['id'].'block_price'?>" style="visibility: hidden;">
						<div class="text_info"><?=lang('bt_from')?></div>				
						<span class="<?=$tour['id'].'block_pro_price'?> b_discount">
							<?=CURRENCY_SYMBOL?><span class="<?=$tour['id'].'promotion_price'?>"></span>
						</span>
			        	<span class="price_from <?=$tour['id'].'from_price'?>"></span>
			        	<span><?=lang('per_pax')?></span>
					</div>
					    
				</div>
				
				<div class="item_price_discount">
					<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')" style="margin-top: 20px; margin-right: 0; float: right; margin-left: 0">
					 	<?=lang('view_more_detail')?>			 	
					 </div>
				</div>	
			
			</div>
		
		<?php endforeach;?>
		
	</div>
		
	<?php endif;?>
	
</div>

<div id="contentLeft" style="float: left;">
	<div id="searchForm">
		<?=$tour_search_view?>
	</div>
	
	<?=$why_use?>

	<?=$topDestinations?>
	
	<div id="tour_faq" class="left_list_item_block">
		<?=$faq_context?>
	</div>
	
</div>


<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
<div id="popup_container" class="popup_container">

<span onclick="close_popup()" class="icon btn-popup-close"></span>

<div class="popup_content" id="popup_content">

	<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>

</div>

</div>

<script type="text/javascript">

function async_load(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery.min.js','', true)?>';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);

    //document.body.appendChild(s);
}

<?php if(count($destination['land_tours']) > 0 || count($destination['include_tours']) > 0):?>

	<?php 
		$tour_ids = '';
		
		foreach ($destination['land_tours'] as $tour){
			$tour_ids = $tour_ids. $tour['id'] . ',';
		}
		
		foreach ($destination['include_tours'] as $tour){
			$tour_ids = $tour_ids. $tour['id'] . ',';
		}
		
		if ($tour_ids != ''){
			$tour_ids = substr($tour_ids, 0, strlen($tour_ids) - 1);
		}
	?>
	
function get_tours_from_price(){

	var current_date = getCookie('departure_date');

	if (current_date == null || current_date ==''){
		current_date = "<?=$search_criteria['departure_date']?>";
	}
	
	$.ajax({
		url: "/tours/get_cruise_price_from/",
		type: "POST",
		cache: true,
		dataType: "json",
		data: {	
			"tour_ids": "<?=$tour_ids?>",
			"departure_date": current_date						
		},
		success:function(value){
			
			for(var i = 0; i < value.length; i++){

				var tour = value[i];
				
				var fromPrice = "<?=CURRENCY_SYMBOL?>" + tour.f_price;
				
				if(tour.f_price == 0) {
					fromPrice = "<?=lang('na')?>";						
				}
				
				$('.'+ tour.id + 'from_price').html(fromPrice);
				
				
				
				if(tour.d_price != 0) {
					$('.'+ tour.id + 'promotion_price').html(tour.d_price);
					$('.'+ tour.id + 'block_pro_price').show();
				} else {
					$('.'+ tour.id + 'block_pro_price').hide();
				}

				if (tour.offer_note != ''){
					$('#offer_note_' + tour.id).html(tour.offer_note);
					$('#offer_note_' + tour.id).show();
				}

				$('.'+ tour.id + 'block_price').css('visibility','visible');
							
			}
			
		}
	});

	}

<?php endif;?>


$(document).ready(function(){

	
	async_load();

	get_tours_from_price();
	 
});

</script>