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

<?php if(!empty($popup_free_visa)):?>
	<div>
		<?=$popup_free_visa?>
	</div>	
<?php endif;?>

<?php if(!$is_book_together):?>
	<form id="frm_tour_book_it_<?=$tour['id']?>" name="frm_tour_book_it" method="get" action="<?=get_page_url(TOUR_BOOK_IT_PAGE, $tour)?>">
<?php endif;?>

<?php if(!empty($parent_id)):?>
	<input name="parent_id" value="<?=$parent_id?>" type="hidden">
<?php endif;?>

<table class="table bpt-table-check-rate table-bordered">
      <thead>
        <tr>
          <th style="width: 40%; vertical-align:middle;"><?=$is_price_per_cabin ? lang('lbl_cruise_cabins') : lang('accommodations')?></th>
          <?php if($is_price_per_cabin):?>
          		<!-- Cabin Arrangement Here -->
	      		<?php foreach ($cabin_arrangements as $key => $cabin):?>	
	      		
	      		<th class="text-center bt-cabin-arrangements-<?=$tour['id']?>" data-key="<?=$key?>" data-cabin="<?=lang('lbl_cabin_index', $key)?>" data-arrangement="<?=$cabin['arrangement_text']?>">
	      			<?=lang('lbl_cabin_index', $key)?>
	      			<br>
	      			<span style="font-weight:normal"><?=$cabin['arrangement_text']?></span>
	      		</th>
	      		
	      	  	<?php endforeach;?>
          <?php else:?>
          		<!-- For normal tour with price per pax -->
          		<th class="text-center">
          			<?=($check_rates['adults'] > 1) ? lang('lbl_cabin_adults', $check_rates['adults']) : lang('lbl_cabin_adult', $check_rates['adults'])?>
          		</th>
          		
          		<?php if($is_single_sup):?>
					<th class="text-center"><?=lang('single_sup')?></th>
				<?php endif;?>
				
				<?php if($check_rates['children'] > 0):?>
					<th class="text-center">
						<?=($check_rates['children'] > 1) ? lang('lbl_cabin_children', $check_rates['children']) : lang('lbl_cabin_child', $check_rates['children'])?>
					</th>
				<?php endif;?>
				
				<?php if($check_rates['infants'] > 0):?>
					<th class="text-center">
						<?=($check_rates['infants'] > 1) ? lang('lbl_cabin_infants', $check_rates['infants']) : lang('lbl_cabin_infant', $check_rates['infants'])?>
					</th>
				<?php endif;?>
				
          <?php endif;?>
          
          
          <?php if($discount > 0):?>
				<th class="text-center"><?=lang('discount')?></th>
		  <?php endif;?>
				
				<th class="text-center"  style="vertical-align:middle;"><?=lang('total_price')?></th>
				
				<?php if(!$is_book_together):?>
					<th width="12%"></th>
				<?php else:?>
					<th width="20%"><?=lang('select_cabin')?></th>
				<?php endif;?>
        </tr>
      </thead>
      
      <?php foreach ($promotions as $k=>$pro):?>
      <tbody <?php if($k > 0):?> class='rate-hide-<?=$tour['id']?>' style="display: none"<?php endif;?>>
      	<?php foreach ($accommodations as $acc):?>
      		
      		<?php 
          		$acc_val = $acc['id'];
          		if(!empty($pro['id'])) $acc_val .= '_'.$pro['id'];
          		$is_triple_family = is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc);
          	?>  	
      			
      		 <?php if($is_triple_family):?>
      		 	<tbody style="border:none;">
	      		 	<tr >
	      		 		<td style="border-bottom: 0px solid red;" colspan="<?=($nr_table_col)?>"> </td>
	      		 	</tr>
      		 	</tbody>
      		 	<thead>
	      		 	<tr>
		      		 	<td class="bgr-header-table">
		      		 		<?=is_triple_cabin($tour, $acc) ? lang('lbl_triple_cabin') : lang('lbl_family_cabin', $acc['max_person'])?>
		      		 	</td>
	      		 		<td style="border-top: 0px solid #DDD;" colspan="<?=($nr_table_col-1)?>">
		      		 		
		      		 	</td>
	      		 	</tr>
      		 	</thead>
      		 <?php endif;?>
      		 
      		 <tr>
      		 	<td>
      		 		
      		 		<?php if(!empty($acc['picture']) && !$is_book_together):?>
      		 			<img class="img-check-rate" width="100" height="75" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $acc['picture'], '120_90')?>">
      		 		<?php endif;?>
      		 		
      		 			<a style="vertical-align:top" href="javascript:void()" data-toggle="modal" data-target="#acc_info_<?=$acc['id']?>">
	      		 			<span class="glyphicon glyphicon-triangle-right text-special"></span> <?=$acc['name']?>
	      		 		</a>
	      		 		
      		 			<div class="margin-bottom-5  margin-top-5"><?=!is_tour_no_vat($tour['id']) ? lang('room_price_included') : lang('tour_price_no_vat')?></div>
      		 			<div >
	      		 			<?php
	      		 				if(!empty($pro)){ 
			      		 			$offer_note = get_acc_pro_offer_note($acc, $pro);
			      		 			$pro['offer_note'] = $offer_note;
			      		 			
			      		 			echo load_promotion_popup(false, $pro, TOUR, false);
		      		 			}
		      		 		?>
	      		 		</div>
		      		 		
      		 	</td>
	          <?php if($is_price_per_cabin):?>
	          	
	          		<?php if(is_triple_cabin($tour, $acc) || is_family_cabin($tour, $acc)):?>
	          			<td class="text-right" colspan="<?=count($cabin_arrangements)?>">
          					<?php 
		      					$origin_price = get_triple_family_cabin_price($acc, array(), $check_rates);
		      					$promotion_price = get_triple_family_cabin_price($acc, $pro, $check_rates);
		      				?>
	          				<?php if($origin_price != $promotion_price):?>
		      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
		      				<?php endif;?>
		      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
	          			</td>
	          		<?php else:?>
	          		
		          		<!-- Cabin Arrangement Here -->
			            <?php foreach ($cabin_arrangements as $key => $cabin):?>	
		      				
		      					<?php 
			      					$origin_price = get_cabin_price($acc, array(), $cabin, $cabin_price_cnf, $num_pax);
			      					$promotion_price = get_cabin_price($acc, $pro, $cabin, $cabin_price_cnf, $num_pax);
			      				?>
			      				
			      			<td class="text-right" id="<?=$acc_val.'_'.$key?>" data-price="<?=$promotion_price?>">
			      				
			      				<?php if($origin_price != $promotion_price):?>
			      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
			      				<?php endif;?>
			      				
			      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
			      			</td>
			      		
			      	  	<?php endforeach;?>
		      	  	
		      	  	<?php endif;?>
	          <?php else:?>
	          		
	          		<!-- For normal tour with price per pax -->
	          		<td class="text-right">
          				<?php 
	      					$origin_price = get_adult_price($acc, array(), $num_pax, $check_rates);
	      					$promotion_price = get_adult_price($acc, $pro, $num_pax, $check_rates);
	      				?>
	      				
	      				<?php if($origin_price != $promotion_price):?>
	      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
	      				<?php endif;?>
	      				
	      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
	          		</td>
	          		
	          		<?php if($is_single_sup):?>
	          			<td class="text-right">
	          				<?php 
		      					$origin_price = get_singe_sup_price($acc, array(), $num_pax);
		      					$promotion_price = get_singe_sup_price($acc, $pro, $num_pax);
		      				?>
		      				
		      				<?php if($origin_price != $promotion_price):?>
		      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
		      				<?php endif;?>
		      				
		      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
	      				
	          			</td>
	          		<?php endif;?>
	          		
	          		<?php if($check_rates['children'] > 0):?>
	          			<td class="text-right">
	          				<?php 
		      					$origin_price = get_children_price($acc, array(), $num_pax, $check_rates);
		      					$promotion_price = get_children_price($acc, $pro, $num_pax, $check_rates);
		      				?>
		      				
		      				<?php if($origin_price != $promotion_price):?>
		      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
		      				<?php endif;?>
		      				
		      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
		      				
	          			</td>
	          		<?php endif;?>
	          		
	          		<?php if($check_rates['infants'] > 0):?>
	          			<td class="text-right">
	          				<?php 
		      					$origin_price = get_infant_price($acc, array(), $num_pax, $check_rates);
		      					$promotion_price = get_infant_price($acc, $pro, $num_pax, $check_rates);
		      				?>
		      				
		      				<?php if($origin_price != $promotion_price):?>
		      					<span class="price-origin"><?=show_usd_price($origin_price)?></span>
		      				<?php endif;?>
		      				
		      				<span class="price-from-check-rate price-from"><?=show_usd_price($promotion_price)?></span>
		      				
	          			</td>
	          		<?php endif;?>
	          		
	          <?php endif;?>
	          
	           <?php if($discount > 0):?>
					<td class="price-from-check-rate price-from text-right">
						-<?=show_usd_price($discount)?>
					</td>
		 	   <?php endif;?>
		 	   
		 	  <td class="price-from-check-rate price-from text-right" style="vertical-align: middle;font-weight:bold;" id="total_<?=$acc_val?>" data-name="<?=$acc['name']?>">
		 	  		<?php 
		 	  			$total_price = get_total_tour_acc_price($tour, $acc, $pro, $cabin_arrangements, $cabin_price_cnf, $num_pax, $check_rates, $discount);
		 	  		?>
		 	  		<?=show_usd_price($total_price)?>
		 	  </td>
	          
	          <td class="text-center">
	          	
	          	<?php if($is_ajax):?>
	          		<?php 
	          			$form_id = '#frm_tour_book_it_'.$tour['id'];
	          			$area_id = '#tour_'.$tour['id'];
	          		?>
	          		<button type="submit" class="btn btn-blue btn-sm" name="acc" value="<?=$acc_val?>" onclick="return book_it('<?=$form_id?>', '<?=$area_id?>', 'tour', this)">
		          		<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_it')?>
		          	</button>
	          	<?php else:?>
	          		<?php if(!$is_book_together):?>
			          	<button type="submit" class="btn btn-blue btn-sm" name="acc_<?=$tour['id']?>" value="<?=$acc_val?>">
			          		<span class="glyphicon glyphicon-shopping-cart"></span> <?=lang('book_it')?>
			          	</button>
		          	<?php else:?>
		          		<div class="radio btn btn-default btn-sm acc-selection acc-selection-<?=$tour['id']?>">
	          				<label>
	          					<input type="radio" value="<?=$acc_val?>" name="acc_<?=$tour['id']?>" onclick="select_acc('<?=$tour['id']?>', '<?=$acc_val?>', '<?=$service_type?>', '<?=$is_price_per_cabin?>', '<?=$is_triple_family?>', '<?=$traveller_text?>')">
	          					<?=lang('btn_select')?>
	          				</label>
	          			</div>
		          	<?php endif;?>
	          	<?php endif;?>
	          </td>
	        </tr>
      	<?php endforeach;?>
      </tbody>
      <?php endforeach;?>
      
      <tfoot>
      		
	      	<?php if(count($optional_services['additional_charge']) > 0):?>
			<tr style="background-color:#ffffc9">
				
				<td colspan="<?=$nr_table_col?>">
				
					<label><?=lang('additional_charge')?></label>
					
					<?php foreach ($optional_services['additional_charge'] as $charge):?>
					
					<div class="row">
						<div class="col-xs-3">
							<?=$charge['name']?>:
							<?php if($charge['description'] != ''):?>
					
								<span class="glyphicon glyphicon-question-sign" data-target="#charge_<?=$tour['id']?>_<?=$charge['id']?>"></span>
								
								<div class="hidden" id="charge_<?=$tour['id']?>_<?=$charge['id']?>">
									<?=$charge['description']?>
								</div>
								
							<?php endif;?>
						</div>
						
						<div class="col-xs-9 price-from-check-rate price-from">		
							<?php if ($charge['charge_type'] != -1):?>
							
								<?=show_usd_price($charge['price'])?>
								
								/<?=translate_text($op_service_unit_types[$charge['charge_type']]);?>
							
							<?php else:?>
							
								<?=number_format($charge['price'], CURRENCY_DECIMAL)?>% of total
								
							<?php endif;?>
						</div>
						
					</div>
					
					<?php endforeach;?>	
					
				</td>
			</tr>
			<?php endif;?>
		
      		
      		<tr>
      			<td colspan="<?=$nr_table_col?>" class="bgr-header-table">
      				<?php if(count($promotions) > 1):?>          					 
      					<div class="pull-left">
							<div style="background-color: #fff; padding:5px 10px; border-radius: 6px;" >
								<a href="javascript:void(0)" class="show-more-rate" data-target=".rate-hide-<?=$tour['id']?>" data-icon="#rate_hide_<?=$tour['id']?>" data-show="hide" style="text-decoration: underline; font-weight: bold;">
									<span class="glyphicon glyphicon-chevron-up text-special" id="rate_hide_<?=$tour['id']?>" data-show="glyphicon-chevron-up" data-hide="glyphicon-chevron-down"></span> 
									<?=$is_price_per_cabin ? lang('lbl_show_more_cabin') : lang('lbl_show_more_acc')?>
								</a>			
							</div>								
						</div>   					
      				<?php endif;?>
      				<?php if(!$is_ajax):?>
	      				<div class="pull-right margin-top-5">      				
	      					<span class="icon icon-claim-green"></span>
	      					<a href="/aboutus/contact/claim/<?=$tour['url_title']?>/<?=$check_rates['departure_date']?>/" target="blank" rel="nofollow"><b>Claim for Best Price Guaranteed</b></a>
	      				</div>
      				<?php endif;?>
      			</td>
      		</tr>
      </tfoot>
</table>

<?php if(!empty($get_params)):?>
	<?php foreach ($get_params as $key => $value):?>
		<input type="hidden" name="<?=$key?>" value="<?=$value?>">
	<?php endforeach;?>
<?php endif;?>

<?php if(!$is_book_together):?>
</form>
<?php endif;?>

<!-- Show Accommodation Detail Information for Popup Content -->
<?php foreach ($accommodations as $key => $acc):?>
	<?=$acc['acc_info']?>
<?php endforeach;?>


<script type="text/javascript">
	$('.show-more-rate').bpvToggle();
	set_popover('.pro-offer-note');
	set_show_hide('.show-more-rate');
</script>