<?php

	$obj_id = $service_type == HOTEL ? 'hotel_': 'tour_';

	$obj_id = $obj_id. $service['id'];

	$url = '';

	if(!empty($current_item_info)){

		if ($service_type == HOTEL){
			$url = '/hotel-extra-booking/'.$service['url_title'].'/'.$current_item_info['parent_id'].'/';
		} else {
			$url = '/tour-extra-booking/'.$service['url_title'].'/'.$current_item_info['parent_id'].'/';
		}

	}

	$photo_dir = $service_type == HOTEL ? PHOTO_FOLDER_HOTEL : PHOTO_FOLDER_TOUR;

	$page_detail = $service_type == HOTEL ? HOTEL_DETAIL_PAGE : TOUR_DETAIL_PAGE;
?>


<div class="bpt-item-compact margin-bottom-5">

	<div class="col-img">
		<a href="<?=get_page_url($page_detail, $service)?>" target="_blank">
			<img class="img-responsive" src="<?=get_image_path($photo_dir, $service['picture'], '135_90')?>">
		</a>
	</div>

	<div class="col-content col-content-recommend">
		<div class="recommend-title">
			<?php if(!empty($current_item_info) && $current_item_info['is_booked_it']):?>

				<img id="<?=$obj_id.'_img_collapse'?>" onclick="show_service('<?=$obj_id?>','<?=$url?>')" src="/media/btn_mini.gif" style="cursor: pointer; margin-bottom: -1px;">

				<a href="javascript:void(0)" onclick="show_service('<?=$obj_id?>','<?=$url?>')"><?=$service['name']?></a>

			<?php else:?>

			<a href="<?=get_page_url($page_detail, $service)?>" target="_blank"><?=$service['name']?></a>

			<?php endif;?>


			<?php if($service_type == HOTEL):?>

				<?php
					$star_infor = get_icon_star($service['star']);
				?>
				<span class="icon <?=$star_infor?>"></span>

				<?php if(!$service['is_new']):?>
					<span class="text-special" style="font-weight: 400;"><?=lang('obj_new')?></span>
				<?php endif;?>

			<?php endif;?>
		</div>

		<div class="margin-top-5 recommend-title-location">
			<?php if ($service_type == HOTEL):?>
				<?=$service['location']?>
			<?php else:?>
				<?=$service['route']?>
			<?php endif;?>

			&nbsp; <a style="text-decoration: underline;" href="<?=get_page_url($page_detail, $service)?>" target="_blank" class="link_function"><?=lang('see_details')?></a>

		</div>

		<div class="margin-top-5 recommend-title-location">
			<?=get_text_review($service, TOUR, true, false)?>
		</div>
	</div>

	<div class="col-price">
		<div class="item-from"><?=lang('bt_from')?></div>

		<?php
			$discount_price_info = $service['discount_price_info'];
		?>

		<?php if(!$discount_price_info['is_na']):?>

			<?php if($discount_price_info['list_price'] > 0):?>
				<?=CURRENCY_SYMBOL?><span class="price-origin"><?=number_format($discount_price_info['list_price'], CURRENCY_DECIMAL)?></span>
			<?php endif;?>

			<span class="price-from-recommend text-price"><?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['promotion_price'], CURRENCY_DECIMAL)?></span><?=$discount_price_info['price_from_unit']?>

		<?php else:?>
			<span class="price-from-recommend text-price"><?=lang('na')?></span>
		<?php endif;?>

	</div>

	<div class="col-book col-book-recommend">
		<div class="text-special margin-bottom-5" style="min-height:10px;" >
			<?php if($discount_price_info['discount_value'] > 0):?>

                <?php if(isset($current_item_info['service_type']) && $current_item_info['service_type'] == VISA && $service_type == CRUISE):?>
                    <div class="text-special" style="font-size: 16px"><b><?=lang('free_visa')?></b></div>
                <?php else:?>

                    <div class="item-from item-from-recommend"><?=lang('bt_you_save')?></div>

    	        	<?php if($discount_price_info['discount_value'] < SUPER_SAVE):?>
    		        	<div>
    		       			<span class="price-from-recommend">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?></span>
    		       			<span class=""><?=$discount_price_info['discount_unit']?></span>
    	       			</div>
    	        	<?php else:?>
    	       			<div>
    	       				<span class="price-from-recommend ">-<?=CURRENCY_SYMBOL?><?=number_format($discount_price_info['discount_value'], CURRENCY_DECIMAL)?>*</span>
    	       				<span class="" ><?=$discount_price_info['discount_unit']?></span>
    	       			</div>
    	        	<?php endif;?>

            	<?php endif;?>

	       	<?php endif;?>
		</div>
		<?php if(!empty($current_item_info)):?>
			<?php if($current_item_info['is_booked_it']):?>
				<div id="<?=$obj_id.'_button_book'?>" class="btn btn-green btn-sm" onclick="show_service('<?=$obj_id?>','<?=$url?>')"><?=lang('book_together')?></div>
			<?php else:?>
				<?php

					if ($current_item_info['service_type'] == HOTEL){

						$bt_url_1 = $service['url_title'];

						$bt_url_2 = $current_item_info['url_title'];

					} else {

						$bt_url_1 = $current_item_info['url_title'];

						$bt_url_2 = $service['url_title'];

					}

					$mode = $current_item_info['service_type'] == HOTEL ||  $service_type == HOTEL ? 1 : 2;

				?>

				<div id="<?=$obj_id.'_button_book'?>" class="btn btn-green btn-sm" onclick="click_book_together('<?=$bt_url_1?>','<?=$bt_url_2?>', <?=$mode?>)"><?=lang('book_together')?></div>
			<?php endif;?>
		<?php else :?>
			<a class="btn btn-green btn-sm" href="<?=get_page_url($page_detail, $service)?>" target="_blank"><?=lang('book_together')?></a>
		<?php endif;?>
	</div>

	<div id="<?=$obj_id?>" class="pull-left" style="width: 100%;" ></div>
</div>

