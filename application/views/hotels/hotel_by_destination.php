<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!-- 
<h1 class="highlight" style="padding-left: 0"><?=lang('hotel_top_recommended').$des['name']?></h1>
 -->
<?php $hotel_ids = "";?> 
<?php if (count($hotels) >0 ) :?>
	<?php foreach ($hotels as $hkey => $hotel) :?>
		
		<?php 
			$most_recommended_style = $hkey == 0? "style='border-color:#FEBA02;margin-top:0'" : '';
			$heaer_bg = $hkey == 0? "style='background-color:#FEBA02'" : '';
			
			$hotel_ids = $hotel_ids.$hotel['id']."-";
		?>
		
		<div class="bpt_item item_radius" <?=$most_recommended_style?>>
			
			<div class="item_header" <?=$heaer_bg?>></div>
			
			<div class="area_left">
				
				<div class="bpt_item_name">
					<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
					<?php 
						$star_infor = get_star_infor($hotel['star'], 0);
					?>
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>"></span>
					<?php if($hotel['is_new']):?>
						<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
					<?php endif;?>
								
				</div>
				
				<div class="bpt_item_image">
					<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>">
						<img width="120" height="90" src="<?=$this->config->item('hotel_small_path').$hotel['picture']?>"></img>
					</a>
				</div>
				
				<div class="item_content">
					<div class="row hotel_address">
					
						<?=$hotel['location']?>
						
					</div>
					
					<div class="row">
						<span class="col_label"><?=lang('hotel_rooms')?>:</span>
						<span class="col_content" style="color:#666"><b><?=$hotel['number_of_room'].'</b> '.lang('room_available')?></span>
					</div>
							
					<?php if ($hotel['review_number'] > 0):?>
						<div class="row hotel_score">
							<div class="col_label"><?=lang('reviewscore')?>:</div>
							<div class="col_content"><?=get_full_hotel_review_text($hotel)?></div>
						</div>
					<?php endif;?>
					
					<div class="row <?=$hotel['id'].'block_text_promotion'?>" style="display: none;">
						<div class="col_label special" id="<?=$hotel['id'].'_offer_title'?>">
							<?=lang('special_offers')?>:
						</div>
						<div class="col_content special description">
							<ul class="offer_lst <?=$hotel['id'].'text_promotion'?>">
							</ul>
						</div>
					</div>
				
					<div class="row description">
						<?=character_limiter(strip_tags($hotel['description']), HOTEL_DESCRIPTION_CHR_LIMIT)?>
					</div>					
				</div>
			
			</div>
			
			<div class="area_right">
				<div class="bpt_item_price" id="<?=$hotel['id'].'from_price'?>" style="visibility:hidden;">
					<ul>
						<li class="from <?=$hotel['id'].'from_label'?>"><?=lang('bt_from') ?></li>
						<li>
							<span id="<?=$hotel['id'].'price'?>" class="b_discount" style="visibility:hidden;">$100</span>										
							<span id="<?=$hotel['id'].'promotion_price'?>" class="price_from" style="visibility:hidden;">$100</span>
						</li>
					</ul>
				</div>
				
				<div class="btn_general select_this_cruise" onclick="go_url('<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>')">
					<?=lang('select_hotel')?>
				</div>
				
			</div>
		</div>		
		
	<?php endforeach ;?>

	<?php 
	
		if($hotel_ids != ""){
			
			$hotel_ids = substr($hotel_ids, 0, strlen($hotel_ids) - 1);
			
		}
	?>
	
	<script type="text/javascript">
	
	function get_hotel_from_prices_ajax(){

		var current_date = getCookie('arrival_date');
		
		if (current_date == null || current_date ==''){
			current_date = '<?=date('d-m-Y', strtotime($search_criteria['arrival_date']))?>';
		}
		
		$.ajax({
			url: "/hotels/get_hotel_from_prices/",
			type: "POST",
			cache: true,
			dataType: "json",
			data: {	
				"hotel_ids": "<?=$hotel_ids?>",
				"arrival_date": current_date						
			},
			success:function(value){
				
				for(var i = 0; i < value.length; i++){

					var hotel = value[i];
					
					$('#'+ hotel.id + 'from_price').css('visibility','visible');

					if (hotel.is_promotion){
						$('#'+ hotel.id + 'price').text(hotel.price);

						$('#'+ hotel.id + 'price').css('visibility','visible');
					}

					var fromPrice = hotel.promotion_price;
					if(hotel.promotion_price == "<?=CURRENCY_SYMBOL?>0") {
						fromPrice = "<?=lang('na')?>";
						$('.'+ hotel.id + 'from_label').html('&nbsp;');
					}
				
					$('#'+ hotel.id + 'promotion_price').text(fromPrice);
					if(fromPrice != "<?=lang('na')?>"){
						$('#'+ hotel.id + 'promotion_price').parent().append(" <?=lang('per_room_night')?>");
					}

					$('#'+ hotel.id + 'promotion_price').css('visibility','visible');


					// show offer note

					if(hotel.offer_note != '') {
						
						var text = hotel.offer_note_arr;

						for(var j=0; j<text.length; ++j) {

							$('.'+ hotel.id + 'text_promotion').append('<li><a class="special" href="javascript:void(0)" id="promotion_' + hotel.id + '_' + hotel.promotion_id + '_' + j + '">' + text[j] + ' &raquo;</a></li>');
														
							$('#promotion_' + hotel.id + '_' + hotel.promotion_id + '_' + j).tiptip({fallback: hotel.deal_content, gravity: 's', title: hotel.deal_title, width: '400px'});
						}
						
						$('.'+ hotel.id + 'block_text_promotion').show();
						
					} 
				}
				
			}
		});	
	}

	$(function() {
		
		get_hotel_from_prices_ajax();
	});
</script>
	

<?php else :?>
	<?=lang('hotel_not_found')?>
<?php endif?>
