<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>			

<?php 
	$is_free_visa = is_free_visa($cruise);
?>
<div id="contentMain" style="float: right;">
	
	<div class="cruise_header_area grayBox" <?php if($cruise['num_reviews'] > 0) echo(' xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate"');?>>		
			
		<div class="tour_area">
			
			<div class="col_1">
				
				<h1 class="highlight">	
						<?php $cruise_name = '';?>		
						<?php if($cruise['header_text'] != '') echo $cruise['header_text'];
							
							else {
								
								if ($cruise['cruise_destination'] == 1){
									$cruise_name = $cruise['name']; 
								} else {
									
									$cruise_name = $cruise['name']. ' '.lang('halong_bay');
								}
							}
												
						?>
						<?php if($cruise['num_reviews'] > 0):?>
							<span property="v:itemreviewed"><?=$cruise_name?></span>
						<?php else:?>
							<?=$cruise_name?>
						<?php endif;?>
						
						<?php if($tab_index == 2):?>
							<?=lang('label_review')?>
						<?php endif;?>
										
						<?php $star_infor = get_star_infor($cruise['star'], 1);?>
						<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
						
						<?php if($cruise['is_new'] == 1):?>
							<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
						<?php endif;?>
										
						<?=by_partner($cruise)?>
				</h1>
				
				
				<?php if(!empty($cruise['address'])):?>
					
					<div class="cruise_address">
						<?=$cruise['address']?>
					</div>
					
				<?php endif;?>
				
				<?php if($cruise['num_reviews'] > 0 || $is_free_visa):?>
					<div class="cruise_review">
						<?php if($cruise['num_reviews'] > 0):?>
							<meta property="v:itemreviewed" content="<?=$cruise['name']?>" />
							<meta rel="v:photo" content="<?=$this->config->item('cruise_small_path').$cruise['picture']?>" />
							
							<span class="review_text"><?=review_score_lang($cruise['review_score'])?></span>
							-
						   	<span rel="v:rating">
						      <span typeof="v:Rating">
						         <b><span property="v:average"><?=$cruise['review_score']?></span>
						         <meta property="v:best" content="10" /></b>
						      </span>
						   	</span>
							   
							<?=lang('common_paging_of')?> <a style="text-decoration: underline;" href="<?=url_builder(CRUISE_REVIEWS, $cruise['url_title'], true)?>">
							<span property="v:count"><?=$cruise['num_reviews']?></span> <?=lang('reviews')?></a>
						<?php endif;?>
						
						<?php if($is_free_visa):?>
							<a class="free-visa-halong icon icon-free-visa-right" href="javascript:void(0)" style="float:right;margin-top:5px"></a>
						<?php endif;?>
				
					</div>
					
				<?php endif;?>
				
			</div>
			
			<?php if($is_free_visa):?>
				<div style="display:none" id="free_visa_halong_content">
					<?=$popup_free_visa?>
				</div>
			<?php endif;?>
			
			<div class="col_2">
				
				<?php if(count($cruise['tours']) > 0):?>
				
				<?php 
					$tour = $cruise['tours'][0];
				?>
				
				
				
				
				
				<div class="cruise_price_from <?=$tour['id'].'block_price'?>" style="visibility: hidden; margin-top: -8px;">
					<span style="margin-right: 7px"><?=lang('bt_from')?></span>
					<span class="<?=$tour['id'].'block_pro_price'?> b_discount"><?=CURRENCY_SYMBOL?><span class="<?=$tour['id'].'promotion_price'?>">590</span></span>
		        	<span class="price_from"><label class="<?=$tour['id'].'from_price'?>">354</label></span>
		        	<span><?=lang('per_pax')?></span>
				</div>
				
				<?php endif;?>	
				
				<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>
					
					<?php 
						$promotion_title = count($cruise['hot_deals']) == 1 ? htmlspecialchars($cruise['hot_deals'][0]['name'], ENT_QUOTES) : lang('special_offers_available')
					?>
					
					<div class="deal_info">
						<span class="icon icon-price"></span> 
						<a id="promotion_<?=$cruise['id']?>" class="special" href="javascript:void(0)">
							<?=$promotion_title?> &raquo;
						</a>
					</div>
					
					<script>
						var dg_content = '<?=get_cruise_offer_content($cruise['hot_deals'])?>';
						var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
						$("#promotion_<?=$cruise['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
					</script>
					
				<?php endif;?>	
				
				<?php if(!isset($cruise_review_view)):?>
				
				<div class="btn_general btn_book_together" onclick="go_check_rate_position()"><?=lang('book_now')?></div>
				
				<?php else:?>
				
				<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>')"><?=lang('book_now')?></div>
				
				<?php endif;?>
				
			</div>
			
		</div>
			
		
		<div class="cruise_info">
			
			<?php if (isset($cruise_cabins)):?>
				<div class="highslide-gallery">
					<div class="main_img">
						
						<?php 
							$img_url = $this->config->item('cruise_medium_path').$cruise['picture'];
							
							if ($cruise['img_status'] == 1){
								$img_url = $this->config->item('cruise_800_600_path').$cruise['picture'];
							}
						?>
					
						<a href="javascript:void(0)" rel="nofollow" imgurl="<?=$img_url?>" class="highslide" onclick="return hs.expand(this);">
							<img id="main_image"  style="float: left;border:0" alt="<?=get_alt_image_text($cruise)?>" src="<?=$this->config->item('cruise_375_250_path').$cruise['picture']?>"></img>
						</a>
						
						<div class="highslide-caption">
							<center><b><?=get_alt_image_text($cruise)?></b></center>
						</div>
			
					</div>
					
					<div id="list_image">
						<?=$list_images?>		
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div style="margin: 7px 0;">
					
					<?php $descriptions = str_replace("\n", "<br>", $cruise['description'])?>
					
					<div id="short_desc">
						<?=content_shorten($descriptions, 220)?>
						
						<?php if(fit_content_shortening($descriptions, 220)):?>
							<a href="javascript:void(0)" onclick="readmore_desc()" style="text-decoration: underline;"><?=lang('label_more')?></a>
						<?php endif;?>
						
					</div>
					
					<?php if(fit_content_shortening($descriptions, 220)):?>
						
						<div id="full_desc" style="display: none;">
							
							<?=$descriptions?>
							<a href="javascript:void(0)" onclick="readless_desc()" style="text-decoration: underline;"><?=lang('label_less')?></a>
						</div>
						
					<?php endif;?>
						
				</div>
				
				<div class="clearfix"></div>
			
			<?php elseif(isset($cruise_review_view)):?>
			
				<?=$cruise_review_view?>
				
			<?php endif;?>
		
		</div>
				
	</div>
	
	<?php if (isset($cruise_tab_contents)):?>
		<?=$cruise_tab_contents?>
	<?php endif;?>

	
	<?php if(isset($recommendation_before_book_it)):?>
		<?=$recommendation_before_book_it?>
	<?php endif;?>
	
	<?php if(!empty($cruise['tours']) && count($cruise['tours']) > 0):?>

	<div class="item_header" style="margin-top: 15px;">
		<h3><span><?=lang_arg('tour_of_cruise', $cruise['name'])?></span></h3>
	</div>
	
	<div class="recommendation_items" style="border-bottom:0; margin-top: 0">
	<?php foreach ($cruise['tours'] as $tour):?>
		
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
				 	<?=lang('book_now')?>			 	
				 </div>
			</div>	
		
		</div>
	
	<?php endforeach;?>
	
	</div>
		
		
	<?php endif;?>

</div>

<div id="contentLeft" style="float: left;">
	<div id="search_cruise_list" style="margin-bottom:10px;">
		<?=$tour_search_view?>
	</div>
	
	<?=$booking_step?>
	
	<div id="TA_selfserveprop417" class="TA_selfserveprop">
    <ul id="dhusqLwQ94x" class="TA_links graXiO9gqk0">
    <li id="i5Qtnqvm" class="69f5CazOa">
    <a target="_blank" href="http://www.tripadvisor.com/"><img src="http://www.tripadvisor.com/img/cdsi/img2/branding/150_logo-11900-2.png" alt="TripAdvisor"/></a>
    </li>
    </ul>
    </div>
    <script src="http://www.jscache.com/wejs?wtype=selfserveprop&amp;uniq=417&amp;locationId=4869921&amp;lang=en_US&amp;rating=true&amp;nreviews=0&amp;writereviewlink=true&amp;popIdx=false&amp;iswide=false&amp;border=true&amp;langversion=2"></script>
	
	<?=getAds(true)?>
	
	<?=$other_cruises_view?>
			 
	<?=$similar_cruises_view?>	
			
	<div id="tour_faq" class="left_list_item_block">
		<?=$faq_context?>
	</div>
	
</div>

<?=$similar_cruises_bottom_view?>

<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>

<div id="popup_container" class="popup_container">

<span onclick="close_popup()" class="icon btn-popup-close"></span>

<div class="popup_content" id="popup_content">

	<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>

</div>

</div>

<script type="text/javascript">
	function init_tab(){
		//$( "#tabs" ).tabs({});
        $('#tabs').tiptab();
	}

	<?php if(count($cruise['tours']) > 0):?>

		<?php 
			$tour_ids = '';
			
			foreach ($cruise['tours'] as $tour){
				$tour_ids = $tour_ids. $tour['id'] . ',';
			}
			
			if ($tour_ids != ''){
				$tour_ids = substr($tour_ids, 0, strlen($tour_ids) - 1);
			}
		?>
		

			
	
	function get_cruise_from_price(){

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

	
	
	function openCabinInfo(obj){
		
		var id = obj.id;
		
		var cabin_detail_id = "cabin_detail_" + id;

		var rowobj = document.getElementById(cabin_detail_id);
		
		if (obj.childNodes[0].className == 'togglelink'){
			
			obj.childNodes[0].className = 'togglelink_open';		
			
			rowobj.style.display = '';
			
		} else {
			obj.childNodes[0].className = 'togglelink';
			
			rowobj.style.display = 'none';
		}

		return false;								
	}

	function showVideo(video_id){
		
		var img_id = "#video_" + video_id + "_img";

		var content_id = "#video_" + video_id + "_content";

		var src = $(img_id).attr("src");

		//alert(src);

		if (src == "<?=site_url('media').'/btn_mini.gif'?>"){
			
			src = "<?=site_url('media').'/btn_mini_hover.gif'?>";

			$(img_id).attr("src", src);

			$(content_id).show();
			
		} else {

			src = "<?=site_url('media').'/btn_mini.gif'?>";

			$(img_id).attr("src", src);

			$(content_id).hide();
		}
		
	}

	function getImage(cruise_id){
		$.ajax({
			url: "<?=site_url('cruise_detail/get_image').'/'?>",
			type: "POST",
			cache: true,
			data: {	
				"cruise_id": cruise_id,
				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){
								
				$("#cruise_photos").html(value);

			}
		});	
	}

	function get_cruise_properties_deckplans(cruise_id, cruise_name){
		
		$.ajax({
			url: "<?=site_url('cruise_detail/get_cruise_properties_deckplans').'/'?>",
			type: "POST",
			cache: true,
			data: {	
				"cruise_id": cruise_id,
				
				"cruise_name": cruise_name,

				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){

				//alert(value);
								
				$("#cruise_properties_deckplans").html(value);

			}
		});	
		
	}

	function get_videos(cruise_id, cruise_name){
		$.ajax({
			url: "<?=site_url('cruise_detail/get_videos').'/'?>",
			type: "POST",
			cache: true,
			data: {	
				"cruise_id": cruise_id,

				"cruise_name": cruise_name,

				"cruise_url_title":"<?=$cruise['url_title']?>"						
			},
			success:function(value){
								
				$("#cruise_videos").html(value);	

			}
		});	
	}

	
	
	function get_tour_itinerary(){

		var tour_id = $('#cruise_itineraries').val();
		
		var imgIndicator = '<?=base_url() ."media/loading-indicator.gif";?>';
		$('#detail_tour_itinerary').html('<center><img src="'+imgIndicator+'"/></center>');
		
		$.ajax({
			url: "<?=site_url('cruise_detail/get_tour_itinerary').'/'?>",
			type: "POST",
			cache: true,
			data: {
				"cruise_id":<?=$cruise['id']?>,
				"cruise_name":"<?=$cruise['name']?>",		
				"tour_id": tour_id,
				"is_halong_cruise": "<?=($cruise['cruise_destination'] == 0)?>"				
			},
			success:function(value){
								
				$("#detail_tour_itinerary").html(value);	

			}
		});	
		
	}
	
	function async_load(){
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery.min.js', '', true)?>';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);

        //document.body.appendChild(s);
	}

	function readmore_desc(){
		$('#short_desc').hide();
		$('#full_desc').show();
	}

	function readless_desc(){
		
		$('#full_desc').hide();

		$('#short_desc').show();
	}

	
	$(document).ready(function(){

		
		async_load();
		
		search_placeholder = "<?=lang('search_placeholder')?>";
		ac_width = 210;

		init_tab();

		<?php if(count($cruise['tours']) > 0):?>
			get_cruise_from_price();
		<?php endif;?>
		
		<?php if ($content == 'cruise' && $tab_index == 0):?>
	
			get_cruise_properties_deckplans("<?=$cruise['id']?>", "<?=htmlspecialchars($cruise['name'],ENT_QUOTES)?>");		
	
		<?php endif;?>


		<?php if(is_free_visa($cruise)):?>
			var dg_content = $('#free_visa_halong_content').html();
			
			var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';
		
			$(".free-visa-halong").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
		<?php endif;?>
		 
	});

</script>
