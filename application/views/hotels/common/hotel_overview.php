<?=$photo_slider?>
<div class="row bpt-overview" style="padding:10px 0;">
	<div class="col-xs-8">
		<div class="text-unhighlight margin-bottom-10">
			<b><?=$hotel['location']?></b>
		</div>

		<?php if ($hotel['review_number'] > 0):?>
			<div class="margin-bottom-10">
				<span class="icon icon-review margin-right-10"></span>
				<span class="review-text"><?=get_text_review($hotel,true)?></span>
			</div>
		<?php endif;?>
	</div>
	<div class="col-xs-4 text-right">
		<div>
			<div class ="bpt-overview-item-form"><?=lang('label_from')?></div>
			<?php if(!empty($hotel['price'])):?>
				<?php if($hotel['price']['price_origin'] != $hotel['price']['price_from']):?>
					<span class="price-origin"><?=show_usd_price($hotel['price']['price_origin'])?></span>
				<?php endif?>
					<span class="price-from"><?=show_usd_price($hotel['price']['price_from'])?></span>
			<?php else:?>
				<span class="price-from"><?=lang('na')?></span>
			<?php endif;?>
		</div>
		<?php if(!empty($hotel['special_offers'])):?>
			<div>
				<?=$hotel['special_offers']?>
			</div>
		<?php endif;?>
	</div>
</div>

<?php if(!empty($room_types)):?>
	<table class="table bpt-table table-bordered">
      <thead>
        <tr class="bgr-header-table">
          <th><?=lang('lbl_room_types')?></th>
          <th class="text-center"><?=lang('lbl_max_person')?></th>
          <th class="text-center"><?=lang('lbl_room_size')?></th>
	      <th class="text-center"><?=lang('lbl_bed_size')?></th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($room_types as $room):?>
      		<tr>
      			<td>
      				<img src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $room['picture'], '80_60')?>">

      		 		<a href="javascript:void(0)" class="vertical-align-top h-overview-room" data-target="#h_o_room_<?=$room['id']?>" data-icon="#icon_h_o_room_<?=$room['id']?>" data-show="hide">

      		 			<span class="vertical-align-top glyphicon glyphicon-triangle-right text-special" id="icon_h_o_room_<?=$room['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span>

      		 			<?=$room['name']?>
      		 		</a>
      		 	</td>

      		 	<td>
      		 		<?=$room['max_person']?>
      		 	</td>

      		 	<td valign="middle" align="center">
		          	<?=lang('lbl_m2', $room['room_size'])?>
		          </td>

	          	<td valign="middle" align="center">
	          		<?=$room['bed_size']?>
	            </td>
      		</tr>

      		<tr id="h_o_room_<?=$room['id']?>" style="display:none">
      			<td colspan="4">
      				<div class="row" style="padding: 10px 0;">
      					<div class="col-xs-6">
      						<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_HOTEL, $room['picture'], '375_250')?>">
      					</div>
      					<div class="col-xs-6">
      						<?php if(!empty($room['facilities'])):?>
      						<h3 class="text-highlight"><?=lang('lbl_cabin_facilities')?></h3>

      						<ul class="list-unstyled bpt-list-checked">
		      					<?php foreach ($room['facilities'] as $value):?>
		      						<li class="col-xs-6 margin-bottom-5">
		      						<?php if($value['important'] == STATUS_ACTIVE):?>
		      							<b><?=$value['name']?></b>
		      						<?php else:?>
		      							<?=$value['name']?>
		      						<?php endif;?>
		      						</li>
		      					<?php endforeach;?>
		      				</ul>
		      				<?php endif;?>
		      				<div class="col-xs-12">
			      				<p><?=$room['description']?></p>
			      			</div>
      					</div>
      				</div>
      			</td>
      		</tr>

      	<?php endforeach;?>
	  </tbody>
	</table>
<?php endif;?>

<div class="text-center">
	<a href="<?=get_page_url(HOTEL_DETAIL_PAGE, $hotel)?>" class="btn btn-green btn-lg">
		<?=strtoupper(lang('see_details'))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
	</a>
</div>

<script type="text/javascript">
	set_show_hide('.h-overview-room');
</script>
