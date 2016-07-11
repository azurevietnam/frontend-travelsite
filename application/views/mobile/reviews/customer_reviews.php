<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<?php if ($review_rate_numbes[-1] >0 ) :?>

	<div class="floatL">
		<table>
			<tr>
				<?php
					$total_reviews = 0;
					switch ($review_for) {
						case TOUR:
							$total_reviews = $tour['review_number'];
							break;
						case HOTEL:
							$total_reviews = $hotel['review_number'];
							break;
						case CRUISE:
							$total_reviews = $cruise['num_reviews'];
							break;
					}
				?>
				<td><span style="float: left; font-size: 13px; font-weight: bold;"><?=$total_reviews?><?=lang('customer_review_for')?>:</span></td>
				<td>
					<h2 class="hightlight" style="padding: 0;">

					<?php
						$is_more_detail = $this->input->post('is_more_detail');
					?>


					<?php if(!isset($is_more_detail) || empty($is_more_detail)):?>

						<?php if ($review_for == TOUR):?>
							<?=$tour['name']?>
						<?php elseif ($review_for == HOTEL):?>
							<a datatype="no-ajax" id="main_obj" href="<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>"><?=$hotel['name']?></a>
						<?php elseif ($review_for == CRUISE):?>
							<a datatype="no-ajax" id="main_obj" href="<?=url_builder(CRUISE_DETAIL, url_title($cruise['url_title']), true)?>"><?=$cruise['name']?></a>
						<?php endif;?>

					<?php else:?>

						<?php if ($review_for == TOUR):?>
							<?=$tour['name']?>
						<?php elseif ($review_for == HOTEL):?>
							<?=$hotel['name']?>
						<?php elseif ($review_for == CRUISE):?>
							<?=$cruise['name']?>
						<?php endif;?>

					<?php endif;?>
					</h2>
				</td>
			</tr>
		</table>
	</div>

	<table class="review_table floatL">
		<tr>
			<td class="score_col">
				<?php if($total_score > 0):?>
					<span style="float: left; width:98%; text-align: center; font-weight: bold; font-size: 16px;"><?=review_score_lang($total_score)?></span>
				<?php endif;?>

				<span class="totscore" style="margin: 20px auto; margin-bottom: 0; height: 40px"><?=number_format($total_score, 1)?></span>

				<div style="font-size: 11px; float: left; width: 100%; text-align: center; margin-top: 0">
					<?=lang('text_based_on')?> <b><?=$total_rows?> <?=lang('reviews')?></b>
				</div>
			</td>
			<td class="score_detail_col">
				<table class="review_breakdown_block" style="margin-top: 5px; margin-bottom: 10px;">
					<tr>
						<td class="highlight" colspan="3" style="font-weight: bold; font-size: 13px"><?=lang('review_score_breakdown')?></td>
					</tr>
					<?php foreach ($score_types as $key => $value) :?>
						<tr>
							<td width="32%" nowrap="nowrap"><?=translate_text($value)?></td>
							<td width="60%" align="center" style="padding: 3px 0">
								<div class="per_bar_cover">
									<div id="color_bar_<?=$key?>" class="per_bar" style="width: <?=($average_scores[$key]*10)?>%;"></div>
								</div>
							</td>
							<td width="8%" align="center" <?php if ($review_for == HOTEL) echo('style="padding-top:3px;padding-bottom:3px"');?>>
								<?=$average_scores[$key]?>
							</td>
						</tr>
					<?php endforeach ;?>
				</table>
			</td>
			<?php
				if ($review_for == TOUR){
					$filter_type = $this->uri->segment(5);
				} else {
					$filter_type = $this->uri->segment(2);
				}

				if(($review_for == CRUISE || $review_for == HOTEL) && isset($cus_type_data)) {
					$filter_type = $cus_type_data;
				}

				if (strpos($filter_type, "_") !== FALSE) {
					$e_array = explode("_", $filter_type);
					$c_t = $e_array[0];
					$cus_t = $e_array[1];
				} else {
					$c_t = $filter_type;
					$cus_t = '-1';
				}
				if($c_t == '') $c_t = '-1';

				$review_url='';
				if ($review_for == TOUR) {
					$review_url = site_url().'tour_detail/tour_review/'.$tour['url_title'].'/Reviews/';
				} else if ($review_for == HOTEL) {
					$review_url = url_builder(HOTEL_REVIEWS, $hotel['url_title'], true).'/';
				} else if ($review_for == CRUISE) {
					$review_url = url_builder(CRUISE_REVIEWS, $cruise['url_title'], true).'/';
				}
			?>
			<td style="width: 25%; background-color: #E6EDF6; margin: 0; padding: 0;">
				<table class="review_filter_block" style="margin-top: 5px; margin-bottom: 10px;">
					<tr>
						<td class="highlight" colspan="3" style="font-weight: bold; font-size: 13px"><?=lang('review_score_filter')?></td>
					</tr>
					<?php foreach ($review_rate_types as $key => $value) :?>
						<tr>
							<td class="score_filter_text">
								<div <?php if ($review_rate_numbes[$key] == 0) echo('style="color: #949494"');?>>
								<?php if ($c_t == $key):?>
									<b><?=translate_text($value)?></b>:&nbsp;<span><?=$review_rate_numbes[$key]?></span>
								<?php else:?>
									<?php if($review_rate_numbes[$key] > 0):?>
										<a rel="nofollow"
											<?php if ($review_for == CRUISE):?>
												href="<?=$review_url.$key.'_'.$cus_t?>"
											<?php elseif ($review_for == HOTEL):?>
												href="<?='/hotel_detail/hotel_review_ajax/'.$hotel['url_title'].'/'.$key.'_'.$cus_t?>"
											<?php else:?>
												href="<?=$review_url . $key . '_' . $cus_t?>"
											<?php endif;?>
										>
										<?=translate_text($value)?>:</a>&nbsp;<span><?=$review_rate_numbes[$key]?></span>
									<?php else:?>
										<?=translate_text($value)?>:&nbsp;<span><?=$review_rate_numbes[$key]?></span>
									<?php endif;?>
								<?php endif;?>
								</div>
							</td>
						</tr>
					<?php endforeach ;?>
				</table>
			</td>
			<td style="width: 25%; background-color: #E6EDF6; margin: 0; padding: 0;">
				<table class="review_filter_block" style="margin-top: 5px; margin-bottom: 10px;">
					<tr>
						<td class="highlight" colspan="3" style="font-weight: bold; font-size: 13px"><?=lang('review_traveler_type_filter')?></td>
					</tr>
					<?php foreach ($customer_types as $key => $value) :?>
						<tr>
							<td class="score_filter_text">
								<div <?php if ($cus_type_numbes[$key] == 0) echo('style="color: #949494"');?>>
								<?php if ($cus_t != '-1' && $cus_t != '' && $cus_t == $key):?>
									<b><?=translate_text($value)?></b>:&nbsp;<span><?=$cus_type_numbes[$key]?></span>
								<?php else:?>
									<?php if($cus_type_numbes[$key] > 0):?>
										<a rel="nofollow"
											<?php if ($review_for == CRUISE):?>
												href="<?=$review_url.$c_t.'_'.$key?>"
											<?php elseif ($review_for == HOTEL):?>
												href="<?='/hotel_detail/hotel_review_ajax/'.$hotel['url_title'].'/'.$c_t.'_'.$key?>"
											<?php else:?>
												href="<?=$review_url . $c_t . '_' . $key?>"
											<?php endif;?>
										>
										<?=translate_text($value)?>:</a>&nbsp;<span><?=$cus_type_numbes[$key]?></span>
									<?php else:?>
										<?=translate_text($value)?>:&nbsp;<span><?=$cus_type_numbes[$key]?></span>
									<?php endif;?>
								<?php endif;?>
								</div>
							</td>
						</tr>
					<?php endforeach;?>
					<tr>
						<td class="score_filter_text">&nbsp;</td>
					</tr>
				</table>
			</td>
		</tr>
		<?php if ($c_t != -1 || $cus_t != -1):?>
		<tr>
			<td class="review_selections">
				<label style="font-weight: bold;float: left;"><?=lang('your_selections')?>:</label>
			</td>
			<td colspan="5" class="review_selections">
			<?php if ($review_for == CRUISE):?>
				<?=get_review_filter($review_rate_types, $customer_types, $c_t, $cus_t, $cruise['url_title'], $review_for)?>
			<?php elseif ($review_for == HOTEL):?>
				<?=get_review_filter($review_rate_types, $customer_types, $c_t, $cus_t, $hotel['url_title'], $review_for)?>
			<?php else:?>
				<?=get_review_filter($review_rate_types, $customer_types, $c_t, $cus_t, $review_url, $review_for)?>
			<?php endif;?>
			<label style="color: #999; font-size: 11px;font-style: italic; padding-left: 10px">(<?=lang('click_remore_selection')?>)</label>
			</td>
		</tr>
		<?php endif;?>
	</table>


	<table id="list_review" class="floatL">

	  	<?php if (count($reviews) >0 ) :?>

		<?php foreach ($reviews as $key => $review) :?>

		<tr <?php if($key%2) echo('style="background-color:#F8F8F8;"');?>>

			<td align="left" style="width: 20%;border-top: 1px solid #ccc; padding: 10px 5px">
				<div style="font-size: 13px;font-weight:bold;"><?=$review['guest_name']?></div>
				<div style="font-size: 11px"><?=translate_text($customer_types[$review['guest_type']])?></div>
				<div style="font-size: 11px">
					<?php if($review['guest_city'] != ''):?>
						<?=$review['guest_city']?>,
					<?php endif;?>

					<?php if(!empty($customer_countries[$review['guest_country']])):?>
					<?=$customer_countries[$review['guest_country']][0]?>
					<?php endif;?>
				</div>
				<div style="font-size: 12px"><?=date("j F, Y",strtotime($review['review_date']))?></div>
			</td>

			<td width="68%" valign="top" style="border-top: 1px solid #ccc">
				<p class="comments_good">

					<?php $good_comment = format_review_text($review['positive_review'])?>

					<span id="good_<?=$key?>_short">
						<?=content_shorten($good_comment, CUSTOMER_REVIEW_LIMIT)?>

						<?php if(fit_content_shortening($good_comment, CUSTOMER_REVIEW_LIMIT)):?>
							<a href="javascript:void(0)" onclick="readmore('good_<?=$key?>')" style="text-decoration: underline;"><?lang('lb_more') ?> &raquo;</a>
						<?php endif;?>

					</span>

					<?php if(fit_content_shortening($good_comment, CUSTOMER_REVIEW_LIMIT)):?>

						<span style="display: none;" id="good_<?=$key?>_full">

							<?=$good_comment?>
							<a href="javascript:void(0)" onclick="readless('good_<?=$key?>')" style="text-decoration: underline;"><?lang('lb_less') ?> &laquo;</a>
						</span>

					<?php endif;?>

				</p>
				<p class="comments_bad">

					<?php $bad_comment = format_review_text($review['negative_review'])?>

					<span id="bad_<?=$key?>_short">

						<?=content_shorten($bad_comment, CUSTOMER_REVIEW_LIMIT)?>

						<?php if(fit_content_shortening($bad_comment, CUSTOMER_REVIEW_LIMIT)):?>
							<a href="javascript:void(0)" onclick="readmore('bad_<?=$key?>')" style="text-decoration: underline;"><?lang('lb_more') ?> &raquo;</a>
						<?php endif;?>

					</span>

					<?php if(fit_content_shortening($bad_comment, CUSTOMER_REVIEW_LIMIT)):?>

						<span style="display: none;" id="bad_<?=$key?>_full">

							<?=$bad_comment?>
							<a href="javascript:void(0)" onclick="readless('bad_<?=$key?>')" style="text-decoration: underline;"><?lang('lb_less') ?> &laquo;</a>
						</span>

					<?php endif;?>

				</p>
			</td>

			<td align="right" width="12%" style="border-top: 1px solid #ccc" valign="top" id="review_<?=$review['id']?>"><span class="totscore"><?=$review['total_review_score']?></span></td>

		</tr>
		<?php endforeach ;?>

		<?php else: ?>
			<tr>
				<td align="center"><label><?=lang('rev_no_review_type')?></label></td>
			</tr>
		<?php endif ; ?>

	</table>

		<?php if (count($reviews) >0 ) :?>
			<div id="contentMainFooter" style="float: left;width: 100%;background-color: #F8F8F8;padding: 5px 0; margin-top: 20px; border: 1px solid #ccc; border-left: 0; border-right: 0">
				<div class="paging_text" style="float: left;padding-left: 10px;"><?=$paging_text?></div>
			    <div class="paging_link" style="float: right;padding-right: 10px;"><?=$this->pagination->create_links()?></div>
			</div>
		<?php endif ; ?>

	<?php else: ?>
			<?php if ($review_for == TOUR):?>
				<center><label><?=lang('rev_no_review')?></label></center>
			<?php elseif ($review_for == HOTEL):?>
				<center><label><?=lang('rev_no_review_hotel')?></label></center>
			<?php elseif ($review_for == CRUISE):?>
				<center><label><?=lang('rev_no_review')?></label></center>
			<?php endif;?>

	<?php endif ; ?>

<script type="text/javascript">


function readmore(id){
	$('#'+id+'_short').hide();

	$('#'+id+'_full').show();
}

function readless(id){

	$('#'+id+'_short').show();

	$('#'+id+'_full').hide();
}

$(document).ready(function(){

	<?php foreach ($reviews as $key => $review) :?>

		$('#review_<?=$review['id']?>').tipsy({fallback: '<?=$review['review_scores']?>', gravity: 'n', width: 'auto', title: '<?=htmlspecialchars($review['guest_name'], ENT_QUOTES)?>'});

	<?php endforeach;?>
});

</script>