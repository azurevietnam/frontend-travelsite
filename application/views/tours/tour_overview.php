<?php 
	$buton_text = empty($tour_name) ? lang('book_now') : lang('view_more_detail');
?>
	
<h1 style="padding-left: 0; padding-top: 5px;">
	<span class="highlight">	
		<?=$tour['name']?>
	</span>
	<?=by_partner($tour)?>
</h1>

<div class="overview_main_img">
	<img id="main_img_<?=$tour['id']?>" width="375" height="250" alt="<?=$tour['name']?>" title="<?=$tour['name']?>" src="<?=$this->config->item('tour_375_250_path') . $tour['picture_name']?>"/>
	
	<div class="img_caption">
		<span id="img_caption_<?=$tour['id']?>"><?=$tour['name']?></span>
	</div>
	
	<div style="margin-top: 5px;">
	<?php foreach ($tour['photos'] as $key=>$photo):?>
		
		<?php 
			$img_class = "img_style";

			if (($key + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}
			
			if ($key > 3){
				$img_class = $img_class. " img_hide";
			}
		?>
		
		<img style="display:none;" src="<?=$this->config->item('tour_375_250_path') . $photo['picture_name']?>">
		
		<div class="<?=$img_class?>" <?php if($key > 3):?>style="display:none"<?php endif;?>>
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$photo['picture_name']?>" imgcaption="<?=htmlentities($photo['comment'])?>" alt="" src="<?=$this->config->item('tour_80_60_path') . $photo['picture_name']?>">
			<br>
			<center style="font-size:9px"><?=$photo['comment']?></center>
		</div>
		
	<?php endforeach;?>
	</div>
	
	<?php if(count($tour['photos']) > 4):?>
		<div class="show_more"><a style="margin-right:10px" href="javascript:void(0)" onclick="show_hide_img(this)" class="function" stat="hide"><?=lang('label_show_more')?> &raquo;</a></div>
	<?php endif;?>
</div>

<div class="overview_row">

<div class="overview_row" style="padding-top: 7px;">
	<div class="col_label">
		<b><?=lang('price_from')?>:</b>
	</div>
	
	<div class="col_content" style="margin-top: -15px;">
		
		<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')"><?=$buton_text?></div>
		
		<div style="margin-right: 15px;">
			<?php $price_view = get_tour_price_view($tour); ?>
			
			<?php if($price_view['f_price'] > 0):?>
				<?php if($price_view['d_price'] > 0):?>
	        		<span class="b_discount" style="font-size:12px"><?=CURRENCY_SYMBOL?><?=$price_view['d_price']?></span>
	        	<?php endif;?>
	        	<span class="price_from"><?=CURRENCY_SYMBOL?><?=$price_view['f_price']?></span> <?=lang('per_pax')?>
			<?php else:?>
				<span class="price_from"><?=lang('na')?></span>
			<?php endif;?>
		</div>
	
	</div>
	
</div>
	
<?php if(!empty($tour['cruise_id'])):?>
	<?php $cruise_obj['url_title'] = url_title($tour['cruise_url_title']);?>							
	<div class="text-unhighlight col-label"><?=lang('cruise_ship')?>:</div>
	<div class="col-text">
		<a target="_blank"  href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise_obj)?>"><?=$tour['cruise_name']?></a>
			<?php $star_infor = get_star_infor_tour($tour['star'], 0);?>
		<span class="icon <?=get_icon_star($tour['star'])?>" title="<?=$star_infor['title']?>"></span>							
		<?php if($tour['is_new'] == 1):?>
			<span class="text-special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
		<?php endif;?>
	</div>
<?php endif;?>
				
<div class="overview_row">
	<div class="col_label">
		<?=lang('cruise_destinations')?>:
	</div>
	<div class="col_content destination">
		<?=$tour['route']?>
	</div>
</div>

<?php if ($tour['review_number'] > 0):?>	
	<div class="overview_row">
		<div class="col_label" style="margin-top:5px">
			<?=lang('reviewscore')?>:
		</div>
		<div class="col_content">
			
			<span style="font-size:18px;font-weight:bold;" class="highlight"><?=$tour['total_score']?></span>
			<span>&nbsp;of&nbsp;&nbsp;<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'] . '/Reviews', true)?>" style="font-style:italic;text-decoration:underline"><?=$tour['review_number'].' '.($tour['review_number'] > 1 ? lang('reviews') : lang('review'))?></a></span>
			&nbsp;-&nbsp;<span style="font-size:18px;font-weight:bold;">
				<?=review_score_lang($tour['total_score'])?>
			</span>		
							
		</div>
	</div>
<?php endif;?>

<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>
				
<?php 
	$deal_info = $tour['price']['deal_info'];
?>

<div class="overview_row">
	<div class="special col_label">
		<?php if($deal_info['is_hot_deals']):?>
			<?=lang('special_offers')?>:
		<?php else:?>
			<?=lang('offers')?>:
		<?php endif;?>					
	</div>
	
	<div class="col_content special">
		<ul class="offer_lst" style="font-size: 11px;">
		<?php $offers = explode("\n", $tour['price']['offer_note']); foreach ($offers as $k=>$item) :?>
		<?php if ($item != '') :?>
			<li><a class="special" href="javascript:void(0)" onclick="open_hot_deal(<?=$tour['id']?>, <?=$deal_info['promotion_id']?>)"><?=$item?> &raquo;</a></li>
		<?php endif;?>	
		<?php endforeach;?>
		</ul>
	</div>
	
	
	
	<div stat="hide" class="hide_area" id="promotion_<?=$tour['id'].'_'.$deal_info['promotion_id']?>">
					
		<span class="icon btn-popup-close" style="top:3px; right:3px" onclick="close_hot_deal(<?=$tour['id']?>, <?=$deal_info['promotion_id']?>)"></span>
		
		<?=get_promotion_condition_text($deal_info)?>
		
	</div>
				
</div>
<?php endif;?>
				

<?php 
				
	$highlights = $tour['tour_highlight'];
	
	$highlights = explode("\n", $highlights);

?>

<?php if(trim($tour['tour_highlight']) && count($highlights) > 0):?>
	
<div class="overview_row" style="padding-top: 5px; color: #669933">
	<b><?=lang('tour_highlight')?>:</b>
</div>

<div class="overview_row">
	<ul class="trip_highlight" style="list-style: disc outside url('/media/check.gif'); margin-left: 35px;">
		<?php foreach ($highlights as $value):?>
			<?php if(trim($value)):?>
			<li style="margin-bottom: 5px"><?=$value?></li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
</div>

<?php endif;?>

</div>

<p>
	<?=str_replace("\n", "<br>", $tour['brief_description'])?>
</p>


<?php if(count($tour['itineraries']) > 0):?>
<div class="clearfix"></div>
	<div class="cruise_tour_header" style="margin-bottom: 10px;">
		<h2><?=lang('brief_itnerary')?></h2>
	</div>
	
	<table class="tour_accom" style="margin-top:10px;">
		<thead>
		<tr style="line-height: 18px; font-weight: bold;">
			<th></th>
			<th align="center"><?=lang('itinerary_summary')?></th>
			<th align="center"><?=lang('accommodations')?></th>
			
		</tr>
		</thead>
		<tbody>
		<?php foreach ($tour['itineraries'] as $key=>$detail):?>
			<tr style="line-height: 18px">
				<?php if($detail['type'] <= 1):?>
					<td nowrap="nowrap" style="font-size: 11px"><?=$detail['label']?></td>
					<td><?=$detail['title']?></td>
					<td><?= (!empty($detail['accommodation'])) ? $detail['accommodation'] : 'NA';?></td>
				<?php elseif($detail['type'] == 3):?>
					<td colspan="3" class="highlight"><label style="margin-left: 20px; font-weight: bold;"><?=$detail['title']?></label></td>
				<?php else:?>
					<td colspan="3" class="highlight"><b><?=$detail['title']?></b></td>
				<?php endif;?>				
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	
<?php endif;?>

<div style="width: 100%; margin-top: 10px;">
	
	<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>')">	
		<?=$buton_text?>	
	</div>
</div>

<script type="text/javascript">

function update_main_img(img_obj){

	var img_name = $(img_obj).attr('imgname');

	var imgcaption = $(img_obj).attr('imgcaption');
	
	$('#main_img_<?=$tour['id']?>').attr("src",'<?=$this->config->item('tour_375_250_path')?>' + img_name);

	if (imgcaption != ''){
		
		$('#img_caption_<?=$tour['id']?>').text(imgcaption);

	} else {

		$('.img_caption').hide();
		
	}
	
}

<?php if (isset($tour['price']['deal_info']) && isset($tour['price']['offer_note']) && !empty($tour['price']['offer_note'])):?>

function open_hot_deal(tour_id, hot_deal_id){

	var status = $('#promotion_'+ tour_id + '_' + hot_deal_id).attr('stat');

	if (status == 'hide'){
	
		$('#promotion_'+ tour_id + '_' + hot_deal_id).show();

		$('#promotion_'+ tour_id + '_' + hot_deal_id).attr('stat', 'show');
		
	} else {

		$('#promotion_'+ tour_id + '_' + hot_deal_id).hide();

		$('#promotion_'+ tour_id + '_' + hot_deal_id).attr('stat', 'hide');
	}
}

function close_hot_deal(tour_id, hot_deal_id){
	$('#promotion_'+ tour_id + '_' + hot_deal_id).hide();
	$('#promotion_'+ tour_id + '_' + hot_deal_id).attr('stat', 'hide');
}

<?php endif;?>


</script>