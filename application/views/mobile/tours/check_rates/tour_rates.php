<?php 
	$is_price_per_cabin = is_price_per_cabin($tour);
	$nr_acc = count($accommodations);
	$is_single_sup = is_single_sup($check_rates['adults'], $check_rates['children'], $accommodations);
	
	// if the tour don't have promotion this time, add an empty array for processing below
	$promotions = empty($promotions) ? array(0=>array()) : $promotions;
	
	$discount = $discount_together['discount'];
	
	$nr_table_col = count_tour_rate_table_colum_nr($tour, $check_rates, $cabin_arrangements, $is_single_sup, $discount);
	
	$tour['url_title'];
	$check_rates['departure_date'];

	$service_type = $tour['cruise_id'] > 0 ? CRUISE : TOUR; // for booking-together module
	$traveller_text = generate_traveller_text($check_rates['adults'], $check_rates['children'], $check_rates['infants']);
	
?>

<form id="frm_tour_book_it_<?=$tour['id']?>" name="frm_tour_book_it" method="get" action="<?=get_page_url(TOUR_BOOK_IT_PAGE, $tour)?>">

<?php if(!empty($parent_id)):?>
	<input name="parent_id" value="<?=$parent_id?>" type="hidden">
<?php endif;?>

<?php foreach ($promotions as $k=>$pro):?>
    <?php foreach ($accommodations as $acc):?>
    
    <?php 
    	$acc_val = $acc['id'];
    	if(!empty($pro['id'])) $acc_val .= '_'.$pro['id'];
    	$is_triple_family = is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc);
    ?>
    <div class="bpv-panel">
        <div class="panel-heading">
            <div class="panel-title bpv-toggle" data-target="#acc_<?=$acc['id']?>">
                <div class="row">
                    <div class="col-xs-10">
                        <h3 class="bpv-color-title"><?=$acc['name']?></h3>
                        <?php if($is_price_per_cabin):?>
                            <?=lang('lbl_m2', $acc['cabin_size'])?>, <?=$acc['bed_size']?>
                        <?php endif;?>
                    </div>
                    <div class="col-xs-2 padding-left-0 text-right">
                        <span class="bpv-toggle-icon icon icon-chevron-down"></span>
                    </div>
                </div>
            </div>
            
            
            <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
            
                <?php if(!empty($tour['cruise_id'])):?>
                    <?php if(!empty($acc['picture'])):?>
          				<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $acc['picture'], '468_351')?>">
          			<?php endif;?>
          			<div class="margin-top-10">
          				<?=$acc['cabin_description']?>
          			</div>
          			
                    <button type="button" class="btn btn-default center-block margin-top-5" data-toggle="modal" data-target="#acc_info_<?=$acc['id']?>">
                        <?=lang('view_facilities')?> <span class="icon icon-chevron-right"></span>
                    </button>
                    <?=$acc['acc_info']?>
                <?php else:?>
                    <?=insert_see_overview_link(generate_string_to_list($acc['content']))?>
                <?php endif;?>
            </div>
            
        </div>
    	<div class="panel-body rate-tables">
    	
            <!-- Promotion -->
            <?php if(!empty($pro)):?>
            <div class="row">
                <?php 
                    $offer_note = get_acc_pro_offer_note($acc, $pro);
                    $pro['offer_note'] = $offer_note;
                    
                    echo load_promotion_popup(true, $pro, TOUR, false);
    	 		?>
            </div>
            <?php endif;?>
            
            <!-- Price Per Cabin: cabin auto arrangemant -->
            <?php if($is_price_per_cabin):?>
            
                <?php if(is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc)):?>
                    <div class="row">
                        <div class="col-xs-6 no-padding">
                            <?=is_triple_cabin($tour, $acc) ? lang('lbl_triple_cabin') : lang('lbl_family_cabin', $acc['max_person'])?>
                        </div>
                        <div class="col-xs-6 padding-right-0 text-right">
                            <?php 
              					$origin_price = get_triple_family_cabin_price($acc, array(), $check_rates);
              					$promotion_price = get_triple_family_cabin_price($acc, $pro, $check_rates);
              				?>
              				<?php if($origin_price != $promotion_price):?>
              					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
              				<?php endif;?>
              				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
          				</div>
      				</div>
                
                <?php else:?>
                
                    <?php foreach ($cabin_arrangements as $key => $cabin):?>	
    	      		<div class="row">
                        <div class="col-xs-6 no-padding">
                            <b><?=lang('lbl_cabin_index', $key)?>:</b> <?=$cabin['arrangement_text']?>
                        </div>
                        <div class="col-xs-6 padding-right-0 text-right">
                            <?php 
    	      					$origin_price = get_cabin_price($acc, array(), $cabin, $cabin_price_cnf, $num_pax);
    	      					$promotion_price = get_cabin_price($acc, $pro, $cabin, $cabin_price_cnf, $num_pax);
    	      				?>
    	      				<?php if($origin_price != $promotion_price):?>
    	      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
    	      				<?php endif;?>
    	      				
    	      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
                        </div>
                    </div>
    	      	  	<?php endforeach;?>
                
                <?php endif;?>
            
            <?php else:?>
            
            <!-- Price Per Pax: For normal tour with price per pax -->
            
            <div class="row">
                <div class="col-xs-6 no-padding">
                    <?=($check_rates['adults'] > 1) ? lang('lbl_cabin_adults', $check_rates['adults']) : lang('lbl_cabin_adult', $check_rates['adults'])?>
                </div>
                <div class="col-xs-6 padding-right-0 text-right">
                    <?php 
        				$origin_price = get_adult_price($acc, array(), $num_pax, $check_rates);
        				$promotion_price = get_adult_price($acc, $pro, $num_pax, $check_rates);
        			?>
        			<?php if($origin_price != $promotion_price):?>
        				<span class="price-origin"><?=show_usd_price($origin_price)?></span>
        			<?php endif;?>
        			
        			<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
    			</div>
            </div>
            
            <?php if($is_single_sup):?>
            <div class="row">
                <div class="col-xs-6 no-padding"><?=lang('single_sup')?></div>
                <div class="col-xs-6 padding-right-0 text-right">
                    <?php 
      					$origin_price = get_singe_sup_price($acc, array(), $num_pax);
      					$promotion_price = get_singe_sup_price($acc, $pro, $num_pax);
      				?>
      				
      				<?php if($origin_price != $promotion_price):?>
      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
      				<?php endif;?>
      				
      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
                </div>
            </div>
			<?php endif;?>
			
			<?php if($check_rates['children'] > 0):?>
			<div class="row">
                <div class="col-xs-6 no-padding">
                <?=($check_rates['children'] > 1) ? lang('lbl_cabin_children', $check_rates['children']) : lang('lbl_cabin_child', $check_rates['children'])?>
                </div>
                <div class="col-xs-6 padding-right-0 text-right">
                    <?php 
      					$origin_price = get_children_price($acc, array(), $num_pax, $check_rates);
      					$promotion_price = get_children_price($acc, $pro, $num_pax, $check_rates);
      				?>
      				
      				<?php if($origin_price != $promotion_price):?>
      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
      				<?php endif;?>
      				
      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
                </div>
            </div>
			<?php endif;?>
			
			<?php if($check_rates['infants'] > 0):?>
			<div class="row">
                <div class="col-xs-6 no-padding">
                <?=($check_rates['infants'] > 1) ? lang('lbl_cabin_infants', $check_rates['infants']) : lang('lbl_cabin_infant', $check_rates['infants'])?>
                </div>
                <div class="col-xs-6 padding-right-0 text-right">
                    <?php 
      					$origin_price = get_infant_price($acc, array(), $num_pax, $check_rates);
      					$promotion_price = get_infant_price($acc, $pro, $num_pax, $check_rates);
      				?>
      				
      				<?php if($origin_price != $promotion_price):?>
      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
      				<?php endif;?>
      				
      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
                </div>
            </div>
			<?php endif;?>
            
            <?php endif;?>
            
            <?php 
 	  			$total_price = get_total_tour_acc_price($tour, $acc, $pro, $cabin_arrangements, $cabin_price_cnf, $num_pax, $check_rates, $discount);
 	  		?>
            
            <!-- Discount -->
            <?php if($discount > 0):?>
            <div class="row">
                <div class="col-xs-6 no-padding"><?=lang('discount')?></div>
                <div class="col-xs-6 padding-right-0 text-right price-from">-<?=show_usd_price($discount)?></div>
            </div>
            <?php endif;?>
            
            <?php if(count($optional_services['additional_charge']) > 0):?>
            <?php foreach ($optional_services['additional_charge'] as $charge):?>
            <div class="row">
                <div class="col-xs-6 no-padding">
                <?=$charge['name']?> - 
                <?php if ($charge['charge_type'] != -1):?>
							
					<?=show_usd_price($charge['price'])?>
					
					/<?=translate_text($op_service_unit_types[$charge['charge_type']]);?>
				
				<?php else:?>
				
					<?=number_format($charge['price'], CURRENCY_DECIMAL)?>% of total
					
				<?php endif;?>
                </div>
                <div class="col-xs-6 padding-right-0 text-right price-from">
                <?php if ($charge['charge_type'] != -1):?>
                    <?php $charge_total = $charge['price'] * $num_pax?>
                    <?php $total_price += $charge_total?>
                    
                    <?=show_usd_price($charge_total)?>
                <?php else:?>
                    <?php $charge_total = ($charge['price']/100) * $total_price?>
                    <?php $total_price += $charge_total?>
                    
                    <?=show_usd_price($charge_total)?>
                <?php endif;?>
                </div>
            </div>
            <?php endforeach;?>
            <?php endif;?>
            
            <!-- Total Price -->
            <div class="row no-border">
                <div class="col-xs-6 no-padding"><b><?=lang('total_price')?></b></div>
                <div class="col-xs-6 padding-right-0 text-right price-from">
                <b><?=show_usd_price($total_price)?></b>
                </div>
            </div>
            <div class="row no-border text-right">
                <div class="col-xs-offset-6 col-xs-6 padding-right-0">
                <button type="submit" class="btn btn-blue btn-block" name="acc_<?=$tour['id']?>" value="<?=$acc_val?>">
                    <span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_it')?>
	          	</button>
	          	</div>
            </div>
    	</div>
    </div>
        
    <?php endforeach;?>
<?php endforeach;?>

<?php if(!empty($get_params)):?>
	<?php foreach ($get_params as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>">
	<?php endforeach;?>
<?php endif;?>

</form>

<!-- Show Accommodation Detail Information for Popup Content -->
<?php foreach ($accommodations as $key => $acc):?>
	<?=$acc['acc_info']?>
<?php endforeach;?>


<script>
$('.bpv-toggle').bpvToggle(function(){
	var icon = $( '.bpv-toggle-icon', $( this ));
	if( $(icon).hasClass ('icon-chevron-down') ) {
		$(icon).toggleClass ('icon-chevron-up');
	}
});
</script>