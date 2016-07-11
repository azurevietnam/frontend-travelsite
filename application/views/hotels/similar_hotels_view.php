<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(isset($similar_hotels) && count($similar_hotels)>0):?>

	<div class="clearfix"></div>
	
	<div class="similar-items">
		
		<h2 class="highlight">
			<?=lang('hotel_detail_similar_hotels') ?>
		</h2>
	
	</div>

    <div class="tile-grid">

        <?php foreach ($similar_hotels as $key=>$other_hotel):?>
            <?php if($key > 3) continue;?>
            <div class="tile col">
                <h4>
                    <a class="item_name" href="<?=url_builder(HOTEL_DETAIL, $other_hotel['url_title'], true)?>" title="<?=$other_hotel['name']?>"><b><?=character_limiter($other_hotel['name'], TOUR_NAME_LIST_CHR_LIMIT)?></b></a>
                    <input type="hidden" class="h_id" value="<?=$other_hotel['id']?>">
                </h4>
                <a href="<?=url_builder(HOTEL_DETAIL, $other_hotel['url_title'], true)?>">
                    <img class="item_img" alt="<?=$other_hotel['name']?>" src="<?=$this->config->item('hotel_220_165_path').$other_hotel['picture']?>"/>
                </a>

                <?php if (!empty($other_hotel['review_number'])):?>
                    <div class="item-review">
                        <?=get_full_hotel_review_text($hotel, true , false)?>
                    </div>
                <?php endif;?>


                <div class="item-price" id="<?=$other_hotel['id'].'_from_price'?>">
                    <span id="<?=$other_hotel['id'].'_price'?>" class="b_discount promotion_price"></span>
                    <span id="<?=$other_hotel['id'].'_promotion_price'?>" class="price_from"></span>
                </div>
            </div>
        <?php endforeach;?>

        <div class="more_item">
            <span class="arrow">&rsaquo;</span>
            <a href="<?=url_builder(MODULE_HOTELS, $hotel_desc['url_title'].'-'.MODULE_HOTELS)?>"><?=lang('more_hotel_in')?><?=$hotel_desc['name']?></a>
        </div>
    </div>
	
	<script type="text/javascript">
	
	function get_similar_hotel_from_prices_ajax(){

		var hotel_ids = '';
		$( "input.h_id" ).each(function( index ) {
			hotel_ids += $(this).val()+'-';
		});
		if (hotel_ids.substring(hotel_ids.length-1) == '-') {
			hotel_ids = hotel_ids.substring(0, hotel_ids.length-1);
		}

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
				"hotel_ids": hotel_ids,
				"arrival_date": current_date						
			},
			success:function(value){
				
				for(var i = 0; i < value.length; i++){

					var hotel = value[i];
					
					$('#'+ hotel.id + '_from_price').show();

					if (hotel.is_promotion){
						$('#'+ hotel.id + '_price').text(hotel.price);

						$('#'+ hotel.id + '_price').show();
					}

					var fromPrice = hotel.promotion_price;
					if(hotel.promotion_price == "<?=CURRENCY_SYMBOL?>0") {
						fromPrice = "<?=lang('na')?>";
						//$('.'+ hotel.id + 'from_label').html('&nbsp;');
					}
				
					$('#'+ hotel.id + '_promotion_price').text(fromPrice);
					if(fromPrice != "<?=lang('na')?>"){
						$('#'+ hotel.id + '_promotion_price').parent().append(" <?=lang('per_room_night')?>");
					}

					$('#'+ hotel.id + '_promotion_price').show();
				}
				
			}
		});	
	}

	$(function() {
		get_similar_hotel_from_prices_ajax();
	});
	</script>
	
<?php endif;?>