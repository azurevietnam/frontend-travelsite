<h2 class="text-highlight" style="float: left;"><?=lang('popular_vietnam_flights')?></h2>
	<div class="popular-flights">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th align="left"><?=lang('col_flights')?></th>
					<th align="left"><?=lang('col_airlines')?></th>
					<th align="center"><?=lang('col_price_per_pax')?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($popular_routes as $k => $route):?>
				<?php				
					$custom_css = '';
					
					if($k >= 0 && count($popular_routes) >= 1 && ($k+1 <= count($popular_routes))) {
						$custom_css = 'style="vertical-align: middle; border-bottom: 3px solid #ddd"';
					}
				?>
				<tr>
					<td rowspan="<?=count($route['basic_prices']) +1?>" <?=$custom_css?>>
						<b id="sl_from_des_<?=$route['id']?>"><?=$route['from_des']?></b> - <b id="sl_to_des_<?=$route['id']?>"><?=$route['to_des']?></b>
					</td>
				</tr>
				<?php foreach ($route['basic_prices'] as $z => $price):?>
					<tr>
						<td class="fligh-item" <?php if($z+1==count($route['basic_prices'])) {echo $custom_css;}?>>
							<?php
								$airline = ''; 
								if($price['airline_id'] == 1) {
									$src = 'media/flight/VN.gif';
									$airline = 'VN';
								} elseif($price['airline_id'] == 2) {
									$src = 'media/flight/BL.gif';
									$airline = 'BL';
								} else {
									$src = 'media/flight/VJ.gif';
									$airline = 'VJ';
								}
							?>
							<img src="<?=$src?>" class="floatL" id="sl_airline_img_<?=$route['id']?>_<?=$price['airline_id']?>">
			
							<label class="floatL" id="sl_airline_name_<?=$price['airline_id']?>"><?=$price['name']?></label>
						</td>
						<td align="center" <?php if($z+1==count($route['basic_prices'])) echo $custom_css?>>
							<label style="margin-right: 10px; padding-top:9px;"><?=$price['price']?> USD</label>
														
							<div class="btn btn-sm btn-blue select-flight" data-from="<?=$route['from_des']?>(<?=$route['from_code']?>)"
							 data-to="<?=$route['to_des']?>(<?=$route['to_code']?>)"
							 data-airline="<?=$airline?>"
							 data-airline-name="<?=$price['name']?>"	
							 data-toggle="modal" data-target="#search_flight_modal">
							
							<?=lang('btn_select')?></div>
													
						</td>
					</tr>
					<?php endforeach;?>
				<?php endforeach;?>
			</tbody>
		</table>
		<p style="text-align: right; font-size: 11px" class="text-price"><?=lang('popular_flight_notes')?></p>
	</div>
	
	
	<!-- Modal -->
	<div class="modal fade" id="search_flight_modal" tabindex="-1" role="dialog" aria-labelledby="search_flight_modal"  aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	        	<span class="glyphicon glyphicon-remove"></span>
	        </button>
	        <h4 class="modal-title" id="search_flight_label">Flight Search</h4>
	      </div>
	      <div class="modal-body">
	        <?=$search_form_popup?>
	      </div>
	    </div>
	  </div>
	</div>

	
	
<script type="text/javascript">

	change_flight_depart_return_date('pop_departure','pop_returning');

	$('.select-flight').click(function () {
		
		var from = $(this).attr('data-from');
		var to = $(this).attr('data-to');
		var airline = $(this).attr('data-airline');
		var airline_name = $(this).attr('data-airline-name');

		$('.pop_flight_from').val(from);
		$('.pop_flight_to').val(to);
		$('.pop_flight_airline').val(airline);
		$('.pop_flight_img').attr('src', '/media/flight/' + airline + '.gif');
		$('.pop_flight_name').text(airline_name);

		$('#search_flight_label').text(from+ ' - ' +to);
		
	})
		
</script>
