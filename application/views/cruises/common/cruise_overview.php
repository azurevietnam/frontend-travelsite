<?=$photo_slider?>
<div class="row bpt-overview" style="padding-top:5px;">
	<div class="col-xs-8">
		<div class="text-unhighlight margin-bottom-5">
			<b><?=$cruise['address']?></b>
		</div>
		<div class="margin-bottom-10">
        	<span class="text-unhighlight margin-bottom-10"><?=lang('cruise_type')?>:</span>
            <span><?=get_cruise_type($cruise)?></span>
        </div>

		<?php if ($cruise['review_number'] > 0):?>
			<div class="margin-bottom-10">
				<!-- <span class="text-unhighlight margin-bottom-5"><?=lang('reviewscore')?>:</span> -->
				<span class="icon icon-review margin-right-10"></span>
				<span class="review-text"><?=get_text_review($cruise, CRUISE)?></span>
			</div>
		<?php endif;?>

	</div>
	<div class="col-xs-4">
		<div class="text-right">
			<div class="bpt-overview-item-form" ><?=lang('label_from')?></div>
			<?php if(!empty($cruise['price'])):?>
				<?php if($cruise['price']['price_origin'] != $cruise['price']['price_from']):?>
					<span class="price-origin"><?=show_usd_price($cruise['price']['price_origin'])?></span>
				<?php endif?>
					<span class="price-from"><?=show_usd_price($cruise['price']['price_from'])?></span>
			<?php else:?>
				<span class="price-from"><?=lang('na')?></span>
			<?php endif;?>
		</div>
		<?php if(empty($cruise['special_offers'])):?>
			<div class="text-right">
				<?=$cruise['special_offers']?>
			</div>
		<?php endif;?>
	</div>
</div>

<?php if(!empty($cabins)):?>
	<table class="table bpt-table table-bordered">
      <thead>
        <tr class="bgr-header-table">
          <th><?=lang('lbl_cruise_cabins')?></th>
          <th class="text-center"><?=lang('lbl_max_person')?></th>
          <th class="text-center"><?=lang('lbl_cabin_size')?></th>
	      <th class="text-center"><?=lang('lbl_bed_size')?></th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($cabins as $cabin):?>
      		<tr>
      			<td>
      				<img src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cabin['picture'], '80_60')?>">
	      		 		<a href="javascript:void(0)" class="vertical-align-top c-overview-cabin" data-target="#c_o_cabin_<?=$cabin['id']?>" data-icon="#icon_c_o_cabin_<?=$cabin['id']?>" data-show="hide">

	      		 			<span class="glyphicon glyphicon-triangle-right text-special vertical-align-top" id="icon_c_o_cabin_<?=$cabin['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span>

	      		 			<?=$cabin['name']?>
	      		 		</a>
      		 	</td>

      		 	<td valign="middle" align="center">
      		 		<?=$cabin['max_person']?>
      		 	</td>

      		 	<td valign="middle" align="center">
		          	<?=lang('lbl_m2', $cabin['cabin_size'])?>
		          </td>

	          	<td valign="middle" align="center">
	          		<?=$cabin['bed_size']?>
	            </td>
      		</tr>

      		<tr id="c_o_cabin_<?=$cabin['id']?>" style="display:none">
      			<td colspan="4">

      				<div class="row">
      					<div class="col-xs-6">
      						<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $cabin['picture'], '375_250')?>">
      					</div>
      					<div class="col-xs-6">
      						<div>
	      						<?php if(!empty($cabin['facilities'])):?>
	      						<h3 class="text-highlight"><?=lang('lbl_cabin_facilities')?></h3>
	      						<ul class="list-unstyled bpt-list-checked">
			      					<?php foreach ($cabin['facilities'] as $value):?>
			      						<li class="col-xs-6" style="margin-bottom:5px;" >
			      						<?php if($value['important'] == STATUS_ACTIVE):?>
			      							<b><?=$value['name']?></b>
			      						<?php else:?>
			      							<?=$value['name']?>
			      						<?php endif;?>
			      						</li>
			      					<?php endforeach;?>
			      				</ul>
			      				<?php endif;?>
							</div>
		      				<div class="col-xs-12">
			      				<p><?=$cabin['description']?></p>
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
	<a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>" class="btn btn-green btn-lg">
		<?=strtoupper(lang('see_details'))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
	</a>
</div>

<script type="text/javascript">
	set_show_hide('.c-overview-cabin');
</script>
