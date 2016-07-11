<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>


<div id="contentMain" style="float: right;">
	<div class="header_area" <?php if($hotel['review_number'] > 0) echo(' xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate"');?>>

		<div class="col_1">

			<h1 class="highlight" style="padding-left: 0; padding-top: 0">
				<?php if($hotel['review_number'] > 0):?>
					<span property="v:itemreviewed"><?=$hotel['name']?></span>
				<?php else:?>
					<?=$hotel['name']?>
				<?php endif;?>

				<?php $star_infor = get_star_infor($hotel['star'], 1);?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>

				<?php if($hotel['is_new']):?>
					<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
				<?php endif;?>
			</h1>

			<div class="hotel_address">

				<?=$hotel['location']?>&nbsp;

			</div>

			<?php if($hotel['review_number'] > 0 || $is_free_visa):?>
				<div class="hotel_review" style="float:none;">
				   <span class="review_text"><?=review_score_lang($hotel['total_score'])?></span>

				   -

				   <span rel="v:rating">
				      <span typeof="v:Rating">
				         <b><span property="v:average"><?=$hotel['total_score']?></span>
				         <meta property="v:best" content="10" /></b>
				      </span>
				   </span>
				    <?=lang('common_paging_of') ?> <a style="text-decoration: underline" href="<?=url_builder(HOTEL_REVIEWS, $hotel['url_title'], true)?>">
				   <span property="v:count"><?=$hotel['review_number']?></span> <?=lang('hotel_reviews') ?></a>

				   <?php if($is_free_visa):?>
						<a class="free-visa-hotel icon icon-free-visa-right" href="javascript:void(0)" style="float:right;margin-top:5px"></a>
					<?php endif;?>

				</div>
			<?php endif;?>

		</div>

		<?php if($is_free_visa):?>
			<div style="display:none" id="free_visa_hotel_content">
				<?=$popup_free_visa?>
			</div>
		<?php endif;?>

		<div class="col_2">

			<div class="hotel_price" id="<?=$hotel['id'].'from_price'?>" style="visibility:hidden;margin-top:-5px">

				<span class="<?=$hotel['id'].'from_label'?>" style="margin-right:7px"><?=lang('hotel_from') ?></span>

				<span id="<?=$hotel['id'].'price'?>" class="b_discount" style="display:none;">$100</span>

				<span id="<?=$hotel['id'].'promotion_price'?>" class="price_from" style="visibility:hidden;">$100</span>

			</div>

			<?php if(isset($hotel['hot_deals']) && count($hotel['hot_deals']) > 0):?>

				<?php
					$promotion_title = count($hotel['hot_deals']) == 1 ? htmlspecialchars($hotel['hot_deals'][0]['name'], ENT_QUOTES) : lang('special_offers_available')
				?>

				<div class="deal_info" style="margin-bottom: 10px">
					<span class="icon icon-price"></span>
					<a id="promotion_<?=$hotel['id']?>" class="special" href="javascript:void(0)">
						<?=$promotion_title?> &raquo;
					</a>
				</div>

				<script>
					var dg_content = '<?=get_cruise_offer_content($hotel['hot_deals'])?>';
					var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
					$("#promotion_<?=$hotel['id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
				</script>

			<?php endif;?>

			<?php if($tab_index == 0):?>

				<div class="btn_general btn_book_together" onclick="go_hotel_check_rate_position()"><?=lang('book_now')?></div>

			<?php else:?>

				<div class="btn_general btn_book_together" onclick="go_url('<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>')"><?=lang('book_now')?></div>

			<?php endif;?>

		</div>

	</div>
	<div id="tabs" class="margin_top_10" style="margin-bottom: 10px;">

		<ul class="bpt-tabs">
			<li><a href="#overview_availability"><?=lang('overview_availability')?></a></li>
			<li>
			<a title="<?=lang('customer_reviews')?>" href="<?='/hotel_detail/hotel_review_ajax/'.$hotel['url_title'].'/'?>"><?=lang('customer_reviews')?></a>
			</li>
		</ul>

		<div id="overview_availability" style="background-color: white;">
			<?php if ($tab_index == 0):?>
				<?=$hotel_detail_view?>
			<?php endif;?>
		</div>

		<div id="customer_reviews" style="background-color: white;">
			<?php if ($tab_index == 1 && isset($hotel_review_view)):?>
				<?=$hotel_review_view?>
			<?php endif;?>
		</div>


	</div>

	<?=$recommendation_before_book_it?>
</div>

<div id="contentLeft" style="float: left;">
	<div id="search_area_list">
		<?=$search_view?>
	</div>

	<div id="top_destination_list">
		<?=$top_destination_view?>
	</div>

	<div id="hotel_faq_list">
		<?=$faq_context?>
	</div>

</div>

<?=$similar_hotels_view?>


<script type="text/javascript">

	function get_hotel_from_prices_ajax(){

		var current_date = getCookie('arrival_date');

		if (current_date == null || current_date ==''){
			current_date = '<?=date('d-m-Y', strtotime($search_criteria['arrival_date']))?>';
		}

		$.ajax({
			url: "/hotels/get_hotel_from_prices/",
			type: "POST",
			cache: true,
			dataType: "json",
			data: {
				"hotel_ids": "<?=$hotel['id']?>",
				"arrival_date": current_date
			},
			success:function(value){

				for(var i = 0; i < value.length; i++){

					var hotel = value[i];

					$('#'+ hotel.id + 'from_price').css('visibility','visible');

					if (hotel.is_promotion){
						$('#'+ hotel.id + 'price').text(hotel.price);

						$('#'+ hotel.id + 'price').show();
					}

					var fromPrice = hotel.promotion_price;
					if(hotel.promotion_price == "<?=CURRENCY_SYMBOL?>0") {
						fromPrice = "<?=lang('na')?>";
						$('.'+ hotel.id + 'from_label').html('&nbsp;');
					}

					$('#'+ hotel.id + 'promotion_price').text(fromPrice);
					if(fromPrice != "<?=lang('na')?>"){
						$('#'+ hotel.id + 'promotion_price').parent().append(" <?=lang('per_room_night')?>");
					}

					$('#'+ hotel.id + 'promotion_price').css('visibility','visible');
				}

			}
		});
	}


	$(function() {

		get_hotel_from_prices_ajax();

        $('#tabs').tiptab({
            selected: <?=$tab_index?>,
            select: function(index) {

                if (index == 0){
                    location.href = '<?=url_builder(HOTEL_DETAIL, $hotel['url_title'], true)?>';
                } else if (index == 1){
                    location.href = '<?=url_builder(HOTEL_REVIEWS, $hotel['url_title'], true)?>';
                }

                return false;
            }
        });

        <?php if($is_free_visa):?>
			var dg_content = $('#free_visa_hotel_content').html();

			var d_help = '<span class="special" style="font-size: 13px;"><?=lang('free_vietnam_visa')?>:</span>';

			$(".free-visa-hotel").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
		<?php endif;?>
	});
</script>