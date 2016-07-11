
<div class="quick_search">

	<form class="ajax_form" id="form_<?=$block_id?>" name="form_<?=$block_id?>" method="POST" action="/tour_search_ajax/">
	
	<input type="hidden" name="parent_id" value="<?=$parent_id?>">
	
	<input type="hidden" name="service_type" value="<?=$service_type?>">
	
	<input type="hidden" name="start_date" value="<?=$start_date?>">
	
	<input type="hidden" name="block_id" value="<?=$block_id?>">
	
	
	<input type="hidden" name="current_service_id" value="<?=$current_item_info['service_id']?>">
	
	<input type="hidden" name="current_service_type" value="<?=$current_item_info['service_type']?>">
	
	<input type="hidden" name="current_service_url_title" value="<?=$current_item_info['url_title']?>">
	
	<input type="hidden" name="current_service_normal_discount" value="<?=$current_item_info['normal_discount']?>">
	
	<input type="hidden" name="current_service_is_main_service" value="<?=$current_item_info['is_main_service']?>">
	
	<input type="hidden" name="current_service_destination_id" value="<?=$current_item_info['destination_id']?>">
	
	<input type="hidden" name="current_service_is_booked_it" value="<?=$current_item_info['is_booked_it']?>">
	
	<input id="sort_by_<?=$block_id?>" type="hidden" name="sort_by" value="<?=$sort_by?>">
	
	<input id="destination_id_<?=$block_id?>" type="hidden" name="destination_id" value="<?=$destination_id?>">
	
	<b style="margin: 0 13px 0 5px"><?=lang('destination') ?></b> <input type="text" id="destination_ajax_<?=$block_id?>" name="destination_name" style="width: 280px">
	
	<label style="margin-left: 10px"><?=lang('duration')?>:</label>
	
	<select id="duration_<?=$block_id?>" name="duration">
		<option value="">
			<?=lang('select_all')?>
		</option>
		
		<?php foreach ($dur_list as $key => $value) :?>
		<option value="<?=$key?>"
			<?=set_select('duration', $key, $duration==strval($key)?TRUE:FALSE)?>>
			<?=lang($value)?>
		</option>
		<?php endforeach;?>
	</select>
	
	<div class="btn_general btn_quick_serch btn_quick_search" onclick="search_more('<?=$block_id?>', '', '1', 'tour')">
		<?=lang('label_quick_search') ?>
	</div>
	
	
	<div class="sort">
		<ul id="lst_sort_<?=$block_id?>">
			<li style="margin-left: 0;width: 65px"><b><?=lang('label_sort_by') ?>:</b></li>
			<li id="recommended"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>','','tour')"><?=lang('recommended') ?></a></li>
			<li id="price_low_high"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>','price_low_high','tour')"><?=lang('price_low_high') ?></a></li>
			<li id="price_high_low"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>','price_high_low','tour')"><?=lang('price_high_low') ?></a></li>
			<li id="review_score"><a href="javascript:void(0)" onclick="bt_sort_by('<?=$block_id?>','review_score','tour')"><?=lang('reviewscore') ?></a></li>
		</ul>
	</div>
	</form>
</div>



<div id="block_search_result_<?=$block_id?>">
<?php if(count($tours) > 0):?>
<?php foreach ($tours as $key => $tour) :?>
<div class="item">
	<?php 
		$service_id = $tour['id'];
		$obj_id = 'tour_';
		
		$obj_id = $obj_id. $service_id;
		
		$url = '';
		
		$service_name = $tour['url_title'];
		$url = site_url('/tourextrabooking/').'/'.url_title($service_name).'/'.$parent_id.'/';
		
	?>
	
	<div class="item_img">
		<img width="80" height="60" src="<?=$this->config->item('tour_80_60_path').$tour['picture_name']?>"/>
	</div>
				
	<div class="item_content">
	
		<div class="bpt_item_name item_name">
			
			<!-- in tour-booking page -->
			<?php if($parent_id != -1 && $parent_id != -2):?>
			
				<img id="<?=$obj_id.'_img_collapse'?>" onclick="show_service('<?=$obj_id?>','<?=$url?>')" src="/media/btn_mini.gif" style="cursor: pointer; margin-bottom: -1px;">
				
				<a href="javascript:void(0)" onclick="show_service('<?=$obj_id?>','<?=$url?>')"><?=$tour['name']?></a>
			
			<?php else:?>
				
				<!-- in tour-detail page -->
				
				<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>" target="_blank"><?=$tour['name']?></a>
				
			<?php endif;?>
						
		</div>
		
		<div class="row item_address">
			<?=$tour['route']?>
			&nbsp;
			<span><a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>" target="_blank" class="link_function"><?=lang('see_details') ?></a></span>
		</div>
		
		<div class="row item_review">
			<?=get_full_review_text($tour, false)?>
		</div>
		
	</div>
	
	<div class="item_price_from">
		<div class="text_info"><?=lang('bt_from')?></div>
					
		<?php 
			$discount_price_info = $tour['discount_price_info'];
		?>
		
		<?php if(!$discount_price_info['is_na']):?>
			
			<?php if($discount_price_info['list_price'] > 0):?>
				<?=CURRENCY_SYMBOL?><span class="b_discount"><?=number_format($discount_price_info['list_price'], CURRENCY_DECIMAL)?></span>
			<?php endif;?>
			
			<span class="price_total"><?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['promotion_price'], CURRENCY_DECIMAL)?></span><?=$discount_price_info['price_from_unit']?>
			
		<?php else:?>
			<span class="price_total"><?=lang('na')?></span>
		<?php endif;?>
	        
	</div>
	
	<div class="item_price_discount">
		
		<div class="row">
			
			<div class="discount_value">
				
				<?php if($discount_price_info['discount_value'] > 0):?>
						        	
		        	<div class="text_info"><?=lang('bt_you_save')?></div>
		        	
		        	<?php if($discount_price_info['discount_value'] < SUPER_SAVE):?>
		        					        	
		       			<span class="price_total special">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?></span><span class="special"><?=$discount_price_info['discount_unit']?></span>			       			
	       			
		        	<?php else:?>
	       			
	       				<span class="price_total special">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?>*</span><span class="special"><?=$discount_price_info['discount_unit']?></span>
	       			
		        	<?php endif;?>
	       		
	       		<?php endif;?>	
	        	
			</div>
		
		</div>
		
		<div class="row" style="margin-top: 10px;">
				
			<?php 
				$main_url_title = $current_item_info['url_title'];
			?>	
			
			<!-- in tour-booking page -->
			<?php if($parent_id != -1 && $parent_id != -2):?>			
				<div id="<?=$obj_id.'_button_book'?>" class="btn_general btn_book_together btn_compact" onclick="show_service('<?=$obj_id?>','<?=$url?>')"><?=lang('book_together')?></div>
			<?php else:?>
				
				<?php 
					if ($parent_id == -2){
						
						$bt_url_1 = $tour['url_title'];
						
						$bt_url_2 = $current_item_info['url_title'];
						
						$mode = 1;
						
					} else {
						
						$bt_url_1 = $current_item_info['url_title'];
						
						$bt_url_2 = $tour['url_title'];

						$mode = 2;
						
					}
				?>
				
				<div id="<?=$obj_id.'_button_book'?>" class="btn_general btn_book_together btn_compact" onclick="click_book_together('<?=$bt_url_1?>','<?=$bt_url_2?>', <?=$mode?>)"><?=lang('book_together')?></div>
			<?php endif;?>
		</div>	
	</div>
	
	<div id="<?=$obj_id?>" class="item_check_rate">
		<div style="float: left; width: 100%; text-align: center;"><img src="/media/loading-indicator.gif"></div>
	</div>
	
</div>
<?php endforeach;?>

<?php if(isset($paging_text)):?>
<div style="width: 720px; margin: 5px 0; float: left; *float: none;" id="ajax_pagination_<?=$block_id?>">
	<div class="pagingLink" style="float: right;"><?=$this->pagination->create_links();?></div>
	<div class="paging_text" style="font-size: 11px"><?=$paging_text?>&nbsp;<?=lang('tours')?></div>
</div>
<?php endif;?>

<?php else:?>
<div style="padding:10px;float:left;"><h1 style="padding:0">Search Not Found</h1> <?=lang('tour_search_not_found')?>.</div><div class="search_hint">
</div>
<?php endif;?>
</div>

<script type="text/javascript">

function applyPagination() {
	
	$("#ajax_pagination_<?=$block_id?> a").click(function() {
		
		var url = $(this).attr("href") + "/";


		search_more('<?=$block_id?>', url, '1', 'tour');

		return false;
	
	});
}

$(document).ready(function(){

	setAjaxAutocomplete('<?=$block_id?>', GLOBALS[0]);
	
	var destinationData = GLOBALS[0];
		
	for(var i=0; i<destinationData.length; ++i) {		
		if (destinationData[i][0] == '<?=$destination_id?>') {
			$("#destination_ajax_<?=$block_id?>").val(destinationData[i][1]);
		}
	}

	$("#lst_sort_<?=$block_id?> li").each(function() {
		 if($(this).attr('id') == '<?=$sort_by?>') {
			 $(this).addClass('selected');
		 } else {
			 $(this).removeClass('selected');
		 }	
	}); 

	applyPagination();
});
</script>