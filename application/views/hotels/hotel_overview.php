<?php
	$buton_text = empty($hotel_name) ? lang('book_now') : lang('view_more_detail');
?>

<h1 style="padding-left: 0; padding-top: 5px;">
	<span class="highlight">
		<?=$hotel['name']?>
	</span>
	<?php $star_infor = get_star_infor($hotel['star'], 1);?>
	<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>

	<?php if($hotel['is_new'] == 1):?>
		<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
	<?php endif;?>
</h1>

<div style="font-style:italic;color:#666;padding-bottom:10px"><?=$hotel['location']?></div>

<div class="overview_main_img">
	<img id="main_img_<?=$hotel['id']?>" width="375" height="250" alt="<?=$hotel['name']?>" title="<?=$hotel['name']?>" src="<?=$this->config->item('hotel_375_250_path') . $hotel['picture']?>"/>

	<div class="img_caption">
		<span id="img_caption_<?=$hotel['id']?>"><?=$hotel['name']?></span>
	</div>

	<div style="margin-top: 5px;">

	<?php
		$index = 0;
	?>


	<?php foreach ($hotel['room_types'] as $key=>$room_type):?>

		<?php

			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}

			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>

		<img style="display:none;" src="<?=$this->config->item('hotel_375_250_path') . $room_type['picture']?>">

		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>
			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$room_type['picture']?>" imgcaption="<?=htmlentities($room_type['name'])?>" alt="" src="<?=$this->config->item('hotel_80_60_path') . $room_type['picture']?>">
			<br>
			<center style="font-size:9px"><?=$room_type['name']?></center>
		</div>

		<?php
			$index++;
		?>

	<?php endforeach;?>
	<?php foreach ($hotel['photos'] as $key=>$photo):?>

		<?php

			$img_class = "img_style";

			if (($index + 1)%4 != 0){
				$img_class = "img_style margin_right_7";
			}

			if ($index > 3){
				$img_class = $img_class. " img_hide";
			}
		?>

		<img style="display:none;" src="<?=$this->config->item('hotel_375_250_path') . $photo['name']?>">

		<div class="<?=$img_class?>" <?php if($index > 3):?>style="display:none"<?php endif;?>>

			<img width="80" height="60" onclick="update_main_img(this)" imgname="<?=$photo['name']?>" imgcaption="<?=htmlentities($photo['description'])?>"  alt="" src="<?=$this->config->item('hotel_80_60_path') . $photo['name']?>">
			<br>
			<center style="font-size:9px"><?=$photo['description']?></center>
		</div>

		<?php
			$index++;
		?>

	<?php endforeach;?>
	</div>

	<?php if($index > 4):?>
		<div class="show_more"><a style="margin-right: 10px;" href="javascript:void(0)" onclick="show_hide_img(this)" class="function" stat="hide"><?=lang('hotel_show_more') ?> &raquo;</a></div>
	<?php endif;?>
</div>

<div class="overview_row">


<div class="overview_row" style="padding-top: 7px;">
	<div class="col_label">
		<b><?=lang('hotel_price_from') ?>:</b>
	</div>

	<div class="col_content" style="margin-top: -15px;">

		<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>')"><?=$buton_text?></div>

		<div style="margin-right: 15px;">

			<?php if($hotel['promotion_price'] > 0):?>
				<?php if ($hotel['promotion_price'] != $hotel['price']):?>
					<?=CURRENCY_SYMBOL?><span class="b_discount" style="font-size:12px"><?=number_format($hotel['price'], CURRENCY_DECIMAL)?></span>
					&nbsp;
				<?php endif;?>
            	<span class="price_from"><?=CURRENCY_SYMBOL?><?=number_format($hotel['promotion_price'], CURRENCY_DECIMAL)?></span>
            	<?=lang('per_room_night')?>

			<?php else:?>
				<span class="price_from"><?=lang('na')?></span>
			<?php endif;?>

		</div>

	</div>

</div>

<div class="overview_row">

	<div class="col_label">
		<?=lang('hotel_rooms') ?>:
	</div>

	<div class="col_content">
		<b><?=$hotel['number_of_room']?></b>
	</div>

</div>


<?php if($hotel['review_number'] > 0):?>
	<div class="overview_row">
		<div class="col_label" style="margin-top:5px">
			<?=lang('reviewscore')?>:
		</div>
		<div class="col_content">

			<span style="font-size:18px;font-weight:bold;" class="highlight"><?=$hotel['total_score']?></span>
			<span>&nbsp;of&nbsp;&nbsp;<a href="<?=url_builder(HOTEL_REVIEWS, $hotel['url_title'], true)?>" style="font-style:italic;text-decoration:underline"><?=$hotel['review_number'].' '.($hotel['review_number'] > 1 ? lang('reviews') : lang('review'))?></a></span>
			&nbsp;-&nbsp;<span style="font-size:18px;font-weight:bold;">
				<?=review_score_lang($hotel['total_score'])?>
			</span>

		</div>
	</div>
<?php endif;?>



<?php if(count($hotel['room_types']) >0):?>
<div class="overview_row highlight" style="padding-top: 5px;">
	<b><?=lang('hotel_room_types') ?>:</b>
</div>

<div class="overview_row">
	<ul class="trip_highlight">
	<?php foreach ($hotel['room_types'] as $room_type):?>
		<li style="margin-bottom: 7px">
			<a stat="hide" id="room_type_text_<?=$room_type['id']?>" onclick="open_room_type(<?=$room_type['id']?>)" style="text-decoration:underline;" href="javascript:void(0)"><b><?=$room_type['name']?></b> - <?=$room_type['room_size']?> m2 &raquo;</a>

			<?php if(trim($room_type['bed_size']) != '' && trim($room_type['bed_size']) != '0'):?>
			<div style="padding-top: 2px;font-size: 11px; color: #666;"><?=$room_type['bed_size']?></div>
			<?php endif;?>

			<div id="room_type_content_<?=$room_type['id']?>" class="hide_area">

				<span class="icon btn-popup-close" style="top: 3px; right: 3px" onclick="close_room_type(<?=$room_type['id']?>)"></span>

				<div style="position: relative; margin-right: 10px; float: left;cursor: pointer">
					<img onclick="update_main_img(this)" imgname="<?=$room_type['picture']?>" imgcaption="<?=htmlentities($room_type['name'])?>" alt="<?=$room_type['name']?>"  src="<?=$this->config->item('hotel_80_60_path').$room_type['picture']?>"/>
					<br>
					<center style="font-size:9px"><?=$room_type['name']?></center>
				</div>

				<?php
					$descriptions = str_replace("\n", "<br>", $room_type['description']);
				?>
				<p style="margin-top: 0px; margin-bottom: 0;font-size:12px"><?=character_limiter($descriptions, 300)?></p>

			</div>

		</li>
	<?php endforeach;?>
	</ul>
</div>

<?php endif;?>

</div>

<p>
	<?=str_replace("\n", "<br>", $hotel['description'])?>
</p>


<script type="text/javascript">

function update_main_img(img_obj){

	var img_name = $(img_obj).attr('imgname');

	var imgcaption = $(img_obj).attr('imgcaption');

	$('#main_img_<?=$hotel['id']?>').attr("src",'<?=$this->config->item('hotel_375_250_path')?>' + img_name);

	if (imgcaption != ''){

		$('#img_caption_<?=$hotel['id']?>').text(imgcaption);

	} else {

		$('.img_caption').hide();

	}

}



<?php if(count($hotel['room_types']) > 0):?>

function open_room_type(room_type_id){

	$('#room_type_content_'+ room_type_id)

	var status = $('#room_type_text_'+ room_type_id).attr('stat');

	if (status == 'hide'){

		$('#room_type_content_'+ room_type_id).show();

		$('#room_type_text_'+ room_type_id).attr('stat', 'show');

	} else {

		$('#room_type_content_'+ room_type_id).hide();

		$('#room_type_text_'+ room_type_id).attr('stat', 'hide');

	}

}

function close_room_type(room_type_id){
	$('#room_type_content_'+ room_type_id).hide();
	$('#room_type_text_'+ room_type_id).attr('stat', 'hide');
}

<?php endif;?>


</script>