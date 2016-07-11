<div class="row">
	<div class="col-xs-6 margin-bottom-10">
		<?=$photo_for_details?>
	</div>
	<div class="col-xs-6">

		<div class="row margin-bottom-10">
			<div class="col-xs-3 text-unhighlight" style="padding-top:10px;">
				<label><?=lang('price_from')?>:</label>
			</div>
			<div class="col-xs-5">
				<?php if(!empty($tour['price'])):?>
					<?php if($tour['price']['price_origin'] != $tour['price']['price_from']):?>
						<span class="price-origin"><?=show_usd_price($tour['price']['price_origin'])?></span>
					<?php endif?>
						<span class="price-from"><?=show_usd_price($tour['price']['price_from'])?></span>
				<?php else:?>
					<span class="price-from"><?=lang('na')?></span>
				<?php endif;?>
			</div>
			<div class="col-xs-4">
				<a class="btn btn-green btn-sm" href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>">
					<?=ucwords(lang('see_details'))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
				</a>
			</div>
		</div>

		<?php if(!empty($tour['cruise_id'])):?>
			<?php $cruise_obj['url_title'] = url_title($tour['cruise_url_title']);?>
			<div class="row">
				<div class="col-xs-4"><?=lang('cruise_ship')?>:</div>
				<div class="col-xs-8">
					<a target="_blank"  href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise_obj)?>"><?=$tour['cruise_name']?></a>
						<?php $star_infor = get_star_infor($tour['star'], 0);?>
					<span class="icon <?=get_icon_star($tour['star'])?>" title="<?=$star_infor['title']?>"></span>
					<?php if($tour['is_new'] == 1):?>
						<span class="text-special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</div>
			</div>
		<?php endif;?>

		<div class="row margin-bottom-5">
			<div class="col-xs-3 text-unhighlight">
				<?=lang('destinations')?>:
			</div>
			<div class="col-xs-9 text-unhighlight">
				<?=$tour['route']?>
			</div>
		</div>

		<?php if ($tour['review_number'] > 0):?>
			<div class="bpt-overview margin-bottom-10">
			<span class="icon icon-review margin-right-10"></span>
				<span class="review-text"><?=get_text_review($tour, CRUISE)?></span>

			</div>
		<?php endif;?>

		<?php if(!empty($tour['special_offers'])):?>
			<div class="row">
				<div class="col-xs-4">
					<?=lang('special_offers')?>:
				</div>
				<div class="col-xs-8">
					<?=$tour['special_offers']?>
				</div>
			</div>
		<?php endif;?>

		<?php if(!empty($tour['highlights'])):?>
		<div class="text-choice">
			<label><?=lang('tour_highlight')?>:</label>
		</div>
		<div>
			<ul class="clearfix padding-left-20">
                <?php foreach ($tour['highlights'] as $value):?>
                <li class="margin-bottom-5"><span><?=$value['label'].': '.$value['title']?></span></li>
                <?php endforeach;?>
            </ul>
		</div>
		<?php elseif(!empty($tour['tour_highlight'])):?>
			<div class="text-choice">
				<label><?=lang('tour_highlight')?>:</label>
			</div>
			<div>
				<?=generate_string_to_list($tour['tour_highlight'], 'bpt-list-checked')?>
			</div>
		<?php endif;?>
	</div>
</div>

<?php if(!empty($tour['itineraries'])):?>
	<h2 class="text-highlight margin-top-10 header-title"><?=lang('brief_itnerary')?></h2>

	<table class="table table-bordered table-striped">
      <thead>
        <tr class="table-bgr-header">
          <th>#</th>
          <th><?=lang('itinerary_summary')?></th>
          <th><?=lang('meals')?></th>
          <th><?=lang('accommodations')?></th>
        </tr>
      </thead>
      <tbody>
      		<?php foreach ($tour['itineraries'] as $key=>$detail):?>
      			<tr>
      				<!-- Type Default -->
	      			<?php if($detail['type'] <= 1):?>

						<td><?=$detail['label']?></td>
						<td>
							<?=$detail['title']?>
							<?php if(!empty($detail['transportations'])):?>
			            		<span class="margin-left-10"><?=get_icon_transportation($detail['transportations'], false)?></span>
			            	<?php endif;?>
						</td>
						<td>
						<?php if(!empty($detail['meals_options'])):?>
			            	 <?=get_tour_meals($detail['meals_options'])?>
			            <?php endif;?>
						</td>
						<td><?= (!empty($detail['accommodation'])) ? $detail['accommodation'] : 'NA';?></td>

					<!-- Type Sub-Route -->
					<?php elseif($detail['type'] == 3):?>

						<td colspan="3"><h4 class="text-highlight"><?=$detail['title']?></h4></td>

					<!-- Type Route -->
					<?php else:?>

						<td colspan="3"><h3 class="text-highlight"><?=$detail['title']?></h3></td>

					<?php endif;?>
      			</tr>
      		<?php endforeach;?>
      </tbody>
    </table>
<?php endif?>

<div class="text-center">
	<a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>" class="btn btn-green btn-lg">
		<?=strtoupper(lang('see_details'))?><span class="icon icon-circle-arrow-right margin-left-5"></span>
	</a>
</div>
