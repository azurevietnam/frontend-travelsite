<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if (count($hotels) >0 ) :?>
	<div id="sort_by">
		<ul class="item_radius">
			<li style="background-color: rgb(254, 186, 2);">
				<strong><?=lang('sort_by')?>:</strong>
			</li>
			<?php if($search_criteria['sort_by'] == 'best_deals'):?>
				<li class="selected">
					<span><?=lang('recommend')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('best_deals');"><?=lang('recommend')?></a>
				</li>
			<?php endif;?>
			
			<?php if($search_criteria['sort_by'] == 'price_low_high'):?>
				<li class="selected">
					<span><?=lang('price_low_high')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('price_low_high');"><?=lang('price_low_high')?></a>
				</li>
			<?php endif;?>
			
			<?php if($search_criteria['sort_by'] == 'price_high_low'):?>
				<li class="selected">
					<span><?=lang('price_high_low')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('price_high_low');"><?=lang('price_high_low')?></a>
				</li>
			<?php endif;?>
			
			<?php if($search_criteria['sort_by'] == 'stars_5_1'):?>
				<li class="selected">
					<span><?=lang('stars_5_1')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('stars_5_1');"><?=lang('stars_5_1')?></a>
				</li>
			<?php endif;?>
			
			<?php if($search_criteria['sort_by'] == 'stars_1_5'):?>
				<li class="selected">
					<span><?=lang('stars_1_5')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('stars_1_5');"><?=lang('stars_1_5')?></a>
				</li>
			<?php endif;?>
			
			<?php if($search_criteria['sort_by'] == 'review_score'):?>
				<li class="selected">
					<span><?=lang('review_score')?></span>
				</li>
			<?php else :?>
				<li>
					<a href="javascript:sort_By('review_score');"><?=lang('review_score')?></a>
				</li>
			<?php endif;?>
			
			
		</ul>
	</div>
	
	<?php foreach ($hotels as $hkey => $hotel) :?>
			
		
		<div class="bpt_item item_radius">
			
			<div class="item_header"></div>
					
			<div class="area_left">
				
				<div class="bpt_item_name">
					<a href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
					<?php 
						$star_infor = get_star_infor($hotel['star'], 0);
					?>
					<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
					
					<?php if($hotel['is_new']):?>
						<span class="special" style="font-weight: normal;"><?=lang('obj_new')?></span>
					<?php endif;?>
								
				</div>
				
				<div class="bpt_item_image">
					<img width="120" height="90" src="<?=$this->config->item('hotel_small_path').$hotel['picture']?>"></img>
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
							<span class="col_label"><?=lang('reviewscore')?>:</span>
							<span class="col_content"><?=get_full_hotel_review_text($hotel)?></span>
						</div>
					<?php endif;?>
					
					
					<?php if (!empty($hotel['offer_note'])):?>
				
						<?php 
							$deal_info = $hotel['deal_info'];
						?>
						
						<div class="row">
							<div class="special col_label">
								<?php if($deal_info['is_hot_deals']):?>
									<?=lang('special_offers')?>:
								<?php else:?>
									<?=lang('offers')?>:
								<?php endif;?>					
							</div>
							
							<div class="col_content special">
								<ul class="offer_lst" style="font-size: 11px; line-height: 1.3em">
								<?php $offers = explode("\n", $hotel['offer_note']); foreach ($offers as $k=>$item) :?>
								<?php if ($item != '') :?>
									<li><a class="special" href="javascript:void(0)" id="promotion_<?=$hotel['id'].'_'.$deal_info['promotion_id'].'_'.$k?>"><?=$item?> &raquo;</a></li>
								<?php endif;?>	
								<?php endforeach;?>
								</ul>
							</div>
						</div>
					<?php endif;?>
				
					
					<div class="row description">
						<?=character_limiter(strip_tags($hotel['description']), HOTEL_DESCRIPTION_CHR_LIMIT)?>
					</div>
					
				</div>
			
			</div>
			
			<div class="area_right">
				
				<div class="bpt_item_price">
					<ul>
						<?php if($hotel['promotion_price'] > 0):?>
						<li class="from"><?=lang('hotel_from') ?></li>
						<li>							
							<?php if ($hotel['promotion_price'] != $hotel['price']):?>
								<?=CURRENCY_SYMBOL?><span class="b_discount"><?=number_format($hotel['price'], CURRENCY_DECIMAL)?></span>
								&nbsp;
							<?php endif;?>
            				<span class="price_from"><?=CURRENCY_SYMBOL?><?=number_format($hotel['promotion_price'], CURRENCY_DECIMAL)?></span>
            				<?=lang('per_room_night')?>
						</li>
						<?php else:?>							
							<li><span class="price_from"><?=lang('na')?></span></li>
						<?php endif;?>
					</ul>
				</div>
				
				<div class="btn_general select_this_cruise highlight" onclick="go_url('<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>')">
					<?=lang('select_hotel')?>
				</div>
			</div>
		</div>
	<?php endforeach ;?>

	
	<div id="contentMainFooter">
		<div class="paging_text"><?=$paging_text?>&nbsp;<?=lang('hotels')?></div>
	    <div id="ajax_paging" class="paging_link"><?=$this->pagination->create_links();?></div>
	</div>
	
<?php else :?>
	<?=lang('hotel_not_found')?>
<?php endif?>
<div id="loading_data" style="display:none;"><b><?=lang('process_data')?></b></div>

<script type="text/javascript">

function sort_By(sort_by){
	$("#loading_data").css("display", "");
	$.ajax({
   		type: "POST",
   		cache: true,
   		url: "<?=site_url('/hotel_list/sort/').'/'?>",
    	data: "sort_by=" + sort_by + "&action=" + $("#action").val() + "&id=" + $("#id").val()+ "&url_title=" + $("#url_title").val(),
   		success: function(responseText){
     		$("#contentMain").html(responseText);
   		},
   		complete: function(){
   			$("#loading_data").css("display", "none");
   			applyPagination();
   		} 
 	});
}

function applyPagination() {
	$("#ajax_paging a").click(function() {

	$("html, body").animate({ scrollTop: 0 }, "fast");
	
	$('#loading_data').show();
	
	var url = $(this).attr("href") + "/";
	
	$.ajax({
			type: "POST",
			data: "ajax=1",
			url: url,
			beforeSend: function() {
				//$("#contentMain").html("");
			},
			success: function(msg) {
				$("#contentMain").html(msg);
				applyPagination();
				$('#loading_data').hide();
			}
		});
		
		return false;
	});
}

$(document).ready(function(){
	applyPagination();

	<?php foreach ($hotels as $key=>$hotel):?>

	<?php if(!empty($hotel['offer_note'])):?>
	
		<?php 
			$deal_info = $hotel['deal_info'];
		?>

		<?php $offers = explode("\n", $hotel['offer_note']); foreach ($offers as $k=>$item) :?>

			var dg_content = '<?=get_promotion_condition_text($deal_info)?>';
			
			var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($deal_info['name'], ENT_QUOTES)?>:</span>';

			$("#promotion_<?=$hotel['id'].'_'.$deal_info['promotion_id'].'_'.$k?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
				
		<?php endforeach;?>

	<?php endif;?>

	<?php endforeach;?>
});

</script>