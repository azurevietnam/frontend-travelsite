<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div >
	<div id="tabs">
		<ul class="bpt-tabs">
			<li><a href="#halong_cruises"><?=lang('halongbay_cruises')?></a></li>

			<li><a href="#mekong_cruises"><?=lang('mekong_cruises')?></a></li>

			<li><a href="#vietnam_tours"><?=lang('tour_home')?></a></li>

			<li><a href="#vietnam_hotels"><?=lang('mnu_vietnam_hotels')?></a></li>
		</ul>

		<div id="halong_cruises" class="most_recommend_junks">
			<?php if(count($list_date_halong) > 0):?>
				<ul class="departue_month margin_top_5" id="departure_month_halong">
					<li><span class="highlight"><b><?=lang('label_departure')?>:</b></span></li>
					<li><a class="date_selected" href="javascript: void(0)" onclick="select_month(this,'', 'halong_cruises','All months')"><?=lang('select_all')?></a></li>

					<?php foreach($list_date_halong as $value):?>
						<li><a href="javascript: void(0)" onclick="select_month(this,'<?=date('Ym',strtotime($value))?>','halong_cruises','<?=date('M, Y', strtotime($value))?>')"><?=date('M, Y', strtotime($value))?></a></li>
					<?php endforeach;?>

				</ul>
			<?php endif;?>
			<?php foreach ($hot_deals['halong_bay_deals'] as $key=>$value):?>

				<div name="halong_cruises"
						start="<?=date('Ym', strtotime($value['start_date']))?>"
						end="<?=$value['end_date'] == '' ? '' : date('Ym', strtotime($value['end_date']))?>"
						class="boxFeature" <?php if(($key+1) % 3 == 0) echo('style="margin-right:0;"');?>>

					<div class="imgFeature">
						<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<img width="210" height="140" alt="<?=$value['name']?>" title="<?=$value['name']?>" src="<?=$this->config->item('tour_220_165_path').$value['picture']?>">
						</a>
					</div>

					<div class="descFea">
						<div class="titFeatured">
							<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<?=character_limiter($value['name'], 26)?>
							</a>
						</div>

						<div class="f-clear small travel-date">
						<?=lang('travel_date')?>:
						<?php if(isset($value['travel_dates']) && $value['travel_dates'] != ''):?>

							<?php
								$travel_dates = explode("\n", $value['travel_dates']);
							?>

							<?php foreach ($travel_dates as $travel_date):?>
								<?=character_limiter($travel_date, 60);?><br>
							<?php endforeach;?>

						<?php else:?>

							<?php if(date('Y',strtotime($value['start_date'])) == date('Y',strtotime($value['end_date']))):?>
								<?=date('d M', strtotime($value['start_date']))?> - <?=date('d M', strtotime($value['end_date']))?>
							<?php else:?>
								<?=date('d M Y', strtotime($value['start_date']))?> - <?=date('d M Y', strtotime($value['end_date']))?>
							<?php endif?>

						<?php endif;?>
						</div>

						<?php if ($value['offer_note'] != ''):?>
						<ul class="f-clear">
							<?php
								$offers = explode("\n", $value['offer_note']);
							?>
							<?php foreach ($offers as $offer):?>
								<li>
									<a class="special small hot_deal_<?=$value['id']?>_<?=$value['promotion_id']?>" href="javascript:void(0)">
									<?=character_limiter($offer, 32);?></a>
								</li>
							<?php endforeach;?>
						</ul>
						<?php endif;?>

						<div class="price_block">
							<span style="color: #999"><?=lang('label_from')?></span>
							<span class="b_discount">
								<?php if($value['from_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['from_price'], CURRENCY_DECIMAL)?>
								<?php endif;?>
							</span>
							<span class="price_from">
								<?php if($value['selling_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['selling_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</span>
						</div>

						<?php $max_hot_deal = $value['offer_rate'];?>
						<?php if(!empty($max_hot_deal)):?>
						<div class="hot-deal-off">
						<span>-<?=$max_hot_deal?>%</span>
						</div>
						<?php endif;?>

						<?php if($key<3):?>
						<div class="btnBestDeal" onclick="go_url('<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>')">
							<?=lang('btn_best_deal')?>
						</div>
						<?php endif;?>
					</div>
				</div>

			<?php endforeach;?>
		</div>


		<div id="mekong_cruises" class="most_recommend_junks">
			<?php if(count($list_date_mekong) > 0):?>
			<ul class="departue_month margin_top_5" id="departure_month_mekong">
				<li><span class="highlight"><b><?=lang('label_departure')?>:</b></span></li>
				<li><a class="date_selected" href="javascript: void(0)" onclick="select_month(this,'', 'mekong_cruises','All months')"><?=lang('select_all')?></a></li>

				<?php foreach($list_date_mekong as $value):?>
					<li><a href="javascript: void(0)" onclick="select_month(this,'<?=date('Ym',strtotime($value))?>','mekong_cruises','<?=date('M, Y', strtotime($value))?>')"><?=date('M, Y', strtotime($value))?></a></li>
				<?php endforeach;?>


			</ul>
			<?php endif;?>
		<?php foreach ($hot_deals['mekong_river_deals'] as $key=>$value):?>
				<div name="mekong_cruises"
						start="<?=date('Ym', strtotime($value['start_date']))?>"
						end="<?=$value['end_date'] == '' ? '' : date('Ym', strtotime($value['end_date']))?>"
						class="boxFeature" <?php if(($key+1) % 3 == 0) echo('style="margin-right:0;"');?>>

					<div class="imgFeature">
						<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<img width="210" height="130" alt="<?=$value['name']?>" title="<?=$value['name']?>" src="<?=$this->config->item('tour_220_165_path').$value['picture']?>">
						</a>
					</div>

					<div class="descFea">
						<div class="titFeatured">
							<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<?=character_limiter($value['name'], 24)?>
							</a>
						</div>

						<div class="f-clear small travel-date">
						<?=lang('travel_date')?>:
						<?php if(isset($value['travel_dates']) && $value['travel_dates'] != ''):?>

							<?php
								$travel_dates = explode("\n", $value['travel_dates']);
							?>

							<?php foreach ($travel_dates as $travel_date):?>
								<?=character_limiter($travel_date, 60)?><br>
							<?php endforeach;?>

						<?php else:?>

						<?php if(date('Y',strtotime($value['start_date'])) == date('Y',strtotime($value['end_date']))):?>
							<?=date('d M', strtotime($value['start_date']))?> - <?=date('d M', strtotime($value['end_date']))?>
						<?php else:?>

							<?=date('d M Y', strtotime($value['start_date']))?> - <?=date('d M Y', strtotime($value['end_date']))?>

						<?php endif?>

						<?php endif;?>
						</div>

						<?php if ($value['offer_note'] != ''):?>
						<ul class="f-clear small">
						<?php
							$offers = explode("\n", $value['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
							<li>
								<a class="special small hot_deal_<?=$value['id']?>_<?=$value['promotion_id']?>" href="javascript:void(0)">
								<?=character_limiter($offer, 32)?></a>
							</li>
						<?php endforeach;?>
						</ul>
						<?php endif;?>

						<div class="price_block">
							<?php if($key>2):?>
							<span style="color: #999"><?=lang('label_from')?></span>
							<?php endif;?>
							<span class="b_discount">
								<?php if($value['from_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['from_price'], CURRENCY_DECIMAL)?>
								<?php endif;?>
							</span>
							<span class="price_from">
								<?php if($value['selling_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['selling_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</span>
						</div>

						<?php $max_hot_deal = $value['offer_rate'];?>
						<?php if(!empty($max_hot_deal)):?>
						<div class="hot-deal-off">
						<span>-<?=$max_hot_deal?>%</span>
						</div>
						<?php endif;?>

						<?php if($key<3):?>
						<div class="btnBestDeal" onclick="go_url('<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>')">
							<?=lang('btn_best_deal')?>
						</div>
						<?php endif;?>
					</div>
				</div>
		<?php endforeach;?>
		</div>

		<div id="vietnam_tours" class="most_recommend_junks">
			<?php if(count($list_date_vntour) > 0):?>
			<ul class="departue_month margin_top_5" id="departure_month_tour">
				<li><span class="highlight"><b><?=lang('label_departure')?>:</b></span></li>
				<li><a class="date_selected" href="javascript: void(0)" onclick="select_month(this,'', 'vietnam_tours','All months')"><?=lang('select_all')?></a></li>

				<?php foreach($list_date_vntour as $value):?>
					<li><a href="javascript: void(0)" onclick="select_month(this,'<?=date('Ym',strtotime($value))?>','vietnam_tours','<?=date('M, Y', strtotime($value))?>')"><?=date('M, Y', strtotime($value))?></a></li>
				<?php endforeach;?>


			</ul>
			<?php endif;?>
		<?php foreach ($hot_deals['vietnam_tour_deals'] as $key=>$value):?>
				<div	name="vietnam_tours"
						start="<?=date('Ym', strtotime($value['start_date']))?>"
						end="<?=$value['end_date'] == '' ? '' : date('Ym', strtotime($value['end_date']))?>"
						class="boxFeature" <?php if(($key+1) % 3 == 0) echo('style="margin-right:0;"');?>>

					<div class="imgFeature">
						<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<img width="210" height="130" alt="<?=$value['name']?>" title="<?=$value['name']?>" src="<?=$this->config->item('tour_220_165_path').$value['picture']?>">
						</a>
					</div>

					<div class="descFea">
						<div class="titFeatured">
							<a href="<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>">
							<?=character_limiter($value['name'], 26)?>
							</a>
						</div>

						<div class="f-clear small travel-date">
						<?=lang('travel_date')?>:
						<?php if(isset($value['travel_dates']) && $value['travel_dates'] != ''):?>

							<?php
								$travel_dates = explode("\n", $value['travel_dates']);
							?>

							<?php foreach ($travel_dates as $travel_date):?>
								<?=character_limiter($travel_dates, 60)?><br>
							<?php endforeach;?>

						<?php else:?>

						<?php if(date('Y',strtotime($value['start_date'])) == date('Y',strtotime($value['end_date']))):?>
							<?=date('d M', strtotime($value['start_date']))?> - <?=date('d M', strtotime($value['end_date']))?>
						<?php else:?>

							<?=date('d M Y', strtotime($value['start_date']))?> - <?=date('d M Y', strtotime($value['end_date']))?>

						<?php endif?>

						<?php endif;?>
						</div>

						<?php if ($value['offer_note'] != ''):?>
						<ul class="f-clear small">
						<?php
							$offers = explode("\n", $value['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
							<li>
								<a class="special small hot_deal_<?=$value['id']?>_<?=$value['promotion_id']?>" href="javascript:void(0)">
								<?=character_limiter($offer, 32)?></a>
							</li>
						<?php endforeach;?>
						</ul>
						<?php endif;?>

						<div class="price_block">
							<span style="color: #999">from</span>
							<span class="b_discount">
								<?php if($value['from_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['from_price'], CURRENCY_DECIMAL)?>
								<?php endif;?>
							</span>
							<span class="price_from">
								<?php if($value['selling_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['selling_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</span>
						</div>

						<?php $max_hot_deal = $value['offer_rate'];?>
						<?php if(!empty($max_hot_deal)):?>
						<div class="hot-deal-off">
						<span>-<?=$max_hot_deal?>%</span>
						</div>
						<?php endif;?>

						<?php if($key<3):?>
						<div class="btnBestDeal" onclick="go_url('<?=url_builder(TOUR_DETAIL, $value['url_title'], true)?>')">
							<?=lang('btn_best_deal')?>
						</div>
						<?php endif;?>
					</div>
				</div>
		<?php endforeach;?>
		</div>

		<div id="vietnam_hotels" class="most_recommend_junks">
			<?php
				$destinations = get_list_hotel_destination($hot_deals['hotel_deals']);
			?>

			<?php if(count($destinations) > 0):?>
				<ul class="departue_month margin_top_5" id="hotel_destination">
					<li style="width: 100px;"><span class="highlight"><b><?=lang('destinations')?>:</b></span></li>
					<li><a class="date_selected" href="javascript: void(0)" onclick="select_destination(this, '')"><?=lang('select_all')?></a></li>

					<?php foreach($destinations as $value):?>
						<li><a href="javascript: void(0)" onclick="select_destination(this, '<?=$value?>')"><?=$value?></a></li>
					<?php endforeach;?>


				</ul>
			<?php endif;?>

			<?php if(count($list_date_vnhotel) > 0):?>
			<ul class="departue_month margin_top_5" id="departue_month_hotel">
				<li style="width: 100px;"><span class="highlight"><b><?=lang('label_departure')?>:</b></span></li>
				<li><a class="date_selected" href="javascript: void(0)" onclick="select_month(this,'', 'vietnam_hotels','All months')"><?=lang('select_all')?></a></li>

				<?php foreach($list_date_vnhotel as $value):?>
					<li><a href="javascript: void(0)" onclick="select_month(this,'<?=date('Ym',strtotime($value))?>','vietnam_hotels','<?=date('M, Y', strtotime($value))?>')"><?=date('M, Y', strtotime($value))?></a></li>
				<?php endforeach;?>


			</ul>
			<?php endif;?>
		<?php foreach ($hot_deals['hotel_deals'] as $key=>$value):?>
				<div name="vietnam_hotels"
						des="<?=$value['destination']?>"
						start="<?=date('Ym', strtotime($value['start_date']))?>"
						end="<?=$value['end_date'] == '' ? '' : date('Ym', strtotime($value['end_date']))?>"
						class="boxFeature" <?php if(($key+1) % 3 == 0) echo('style="margin-right:0;"');?>>

					<div class="imgFeature">
						<a href="<?=url_builder(HOTEL_DETAIL, $value['url_title'], true)?>">
							<img width="210" height="130" alt="<?=$value['name']?>" title="<?=$value['name']?>" src="<?=$this->config->item('hotel_220_165_path').$value['picture']?>">
						</a>
					</div>

					<div class="descFea">
						<div class="titFeatured">
							<a href="<?=url_builder(HOTEL_DETAIL, $value['url_title'], true)?>">
							<?=character_limiter($value['name'], 26)?>
							</a>
						</div>

						<div class="f-clear small travel-date">
						<?=lang('travel_date')?>:
						<?php if(isset($value['travel_dates']) && $value['travel_dates'] != ''):?>

							<?php
								$travel_dates = explode("\n", $value['travel_dates']);
							?>

							<?php foreach ($travel_dates as $travel_date):?>
								<?=character_limiter($travel_date, 60)?><br>
							<?php endforeach;?>

						<?php else:?>

						<?php if(date('Y',strtotime($value['start_date'])) == date('Y',strtotime($value['end_date']))):?>
							<?=date('d M', strtotime($value['start_date']))?> - <?=date('d M', strtotime($value['end_date']))?>
						<?php else:?>

							<?=date('d M Y', strtotime($value['start_date']))?> - <?=date('d M Y', strtotime($value['end_date']))?>

						<?php endif?>

						<?php endif;?>
						</div>

						<?php if ($value['offer_note'] != ''):?>
						<ul class="f-clear small">
						<?php
							$offers = explode("\n", $value['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
							<li>
								<a class="special small hot_deal_<?=$value['id']?>_<?=$value['promotion_id']?>" href="javascript:void(0)">
								<?=character_limiter($offer, 32)?></a>
							</li>
						<?php endforeach;?>
						</ul>
						<?php endif;?>

						<div class="price_block">
							<span style="color: #999"><?=lang('label_from')?></span>
							<span class="b_discount">
								<?php if($value['from_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['from_price'], CURRENCY_DECIMAL)?>
								<?php endif;?>
							</span>
							<span class="price_from">
								<?php if($value['selling_price'] > 0):?>
									<?=CURRENCY_SYMBOL?><?=number_format($value['selling_price'], CURRENCY_DECIMAL)?>
								<?php else:?>
									<?=lang('na')?>
								<?php endif;?>
							</span>
						</div>

						<?php $max_hot_deal = $value['offer_rate'];?>
						<?php if(!empty($max_hot_deal)):?>
						<div class="hot-deal-off">
						<span>-<?=$max_hot_deal?>%</span>
						</div>
						<?php endif;?>

						<?php if($key<3):?>
						<div class="btnBestDeal" onclick="go_url('<?=url_builder(HOTEL_DETAIL, $value['url_title'], true)?>')">
							<?=lang('btn_best_deal')?>
						</div>
						<?php endif;?>
					</div>
				</div>
		<?php endforeach;?>
		</div>

		<div id="no_deal_avaiable"></div>
	</div>
</div>

<script>
$(document).ready(function(){
    $('#tabs').tiptab();
});

function select_destination(obj, destination){

	$('ul#hotel_destination').find('a.date_selected').removeClass('date_selected');

	$(obj).addClass('date_selected');

	var date = $.trim($('#month_selected').val());
	destination = $.trim(destination);

	var is_no_deal = true;

	$('div[name=vietnam_hotels]').each(function () {
		var start = $(this).attr('start');

		var end = $(this).attr('end');

		var des = $(this).attr('des');

		if ((destination == '' || destination == des) && (date == '' ||(date >= start && (end == '' || date <= end)))){
			$(this).show();
			is_no_deal = false;
		} else {
			$(this).hide();
		}

	});

	var index = 0;
	$('div[name=vietnam_hotels]').each(function () {
		if($(this).is(":visible")) {
			if((index+1) % 3 == 0) {
				$(this).css('margin-right', 0);
			} else {
				$(this).css('margin-right', '14px');
			}
			index++;
		}
	});

	if (is_no_deal){

		$('#no_hotel_deal').text('No Vietnam hotel deal in the selected month');

		$('#no_hotel_deal').show();

	} else {
		$('#no_hotel_deal').hide();
	}

}

function select_month(obj, date, tab_id, monh_display){

	var is_no_deal = true;

	$('div[name='+tab_id+']').each(function () {
		var start = $(this).attr('start');

		var end = $(this).attr('end');

		if (date == '' ||(date >= start && (end == '' || date <= end))){
			$(this).show();

			is_no_deal = false;

		} else {
			$(this).hide();
		}

	});

	var index = 0;
	$('div[name='+tab_id+']').each(function () {
		if($(this).is(":visible")) {
			if((index+1) % 3 == 0) {
				$(this).css('margin-right', 0);
			} else {
				$(this).css('margin-right', '14px');
			}
			index++;
		}
	});

	var empty_msg = '', ul_id = '';
	if (tab_id == 'halong_cruises'){
		empty_msg = 'Halong Bay cruise';
		ul_id = 'departure_month_halong';
	} else if (tab_id == 'mekong_cruises') {
		empty_msg = 'Mekong River cruise';
		ul_id = 'departure_month_mekong';
	} else if (tab_id == 'vietnam_tours') {
		empty_msg = 'Vietnam tour';
		ul_id = 'departure_month_tour';
	} else if (tab_id == 'vietnam_hotels') {
		empty_msg = 'Vietnam hotel';
		ul_id = 'departue_month_hotel';
	}

	$('ul#'+ul_id).find('a.date_selected').removeClass('date_selected');

	if (is_no_deal){

		$('#no_deal_avaiable').text('No '+empty_msg+' deal in ' + monh_display);

		$('#no_deal_avaiable').show();

	} else {
		$('#no_deal_avaiable').hide();
	}

	$(obj).addClass('date_selected');
}

<?php foreach ($hot_deals['halong_bay_deals'] as $tour):?>
	<?php
		$promotion_title = htmlspecialchars($tour['promotion_name'], ENT_QUOTES);
		$tour['note'] = $tour['p_note'];
	?>

	var dg_content = '<?=get_promotion_condition_text($tour)?>';
	var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?></span>';
	$(".hot_deal_<?=$tour['id']?>_<?=$tour['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
<?php endforeach;?>

<?php foreach ($hot_deals['mekong_river_deals'] as $tour):?>
<?php
	$promotion_title = htmlspecialchars($tour['promotion_name'], ENT_QUOTES);
	$tour['note'] = $tour['p_note'];
?>

var dg_content = '<?=get_promotion_condition_text($tour)?>';
var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?></span>';
$(".hot_deal_<?=$tour['id']?>_<?=$tour['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
<?php endforeach;?>

<?php foreach ($hot_deals['vietnam_tour_deals'] as $tour):?>
<?php
	$promotion_title = htmlspecialchars($tour['promotion_name'], ENT_QUOTES);
	$tour['note'] = $tour['p_note'];
?>

var dg_content = '<?=get_promotion_condition_text($tour)?>';
var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?></span>';
$(".hot_deal_<?=$tour['id']?>_<?=$tour['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
<?php endforeach;?>

<?php foreach ($hot_deals['hotel_deals'] as $hotel):?>
<?php
	$promotion_title = htmlspecialchars($hotel['promotion_name'], ENT_QUOTES);
	$hotel['expiry_date'] = $hotel['book_to'];
	$hotel['note'] = $hotel['p_note'];
?>

var dg_content = '<?=get_promotion_condition_text($hotel)?>';
var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?></span>';
$(".hot_deal_<?=$hotel['id']?>_<?=$hotel['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
<?php endforeach;?>
</script>