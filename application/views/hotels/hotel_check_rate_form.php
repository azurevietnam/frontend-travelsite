
		<div class="hotel_check_rates">
			
			<?php 
				$start_date_id = '#arrival_day_check_rate_'.$hotel['id'];
				$start_month_id = '#arrival_month_check_rate_'.$hotel['id'];
				$departure_date_id = '#arrival_date_check_rate_'.$hotel['id'];
				$night_id = '#hotel_night_check_rate_'.$hotel['id'];
				$departure_day_display_id = '#departure_date_check_rate_display_'.$hotel['id'];
			?>
			
			<form id="frm_hotel_check_rate_<?=$hotel['id']?>" name="frm_hotel_check_rate_<?=$hotel['id']?>" method="POST"> 
				<input type="hidden" name="action_type" value="check_rate">				
	            <div class="col">
	        		<span><?=lang('hotel_arrive')?>:</span>
	        		<div class="clearfix" style="height: 3px;"></div>
		        	<div id="date_picker">
		                <select name="arrival_day_check_rate" id="arrival_day_check_rate_<?=$hotel['id']?>" onchange="changeDay('<?=$start_date_id?>','<?=$start_month_id?>', '<?=$departure_date_id?>', '<?=$night_id?>', '<?=$departure_day_display_id?>')">
		                	<option value=""><?=date('D, Y')?></option>
		                </select>
		                &nbsp;<select name="arrival_month_check_rate" id="arrival_month_check_rate_<?=$hotel['id']?>" onchange="changeMonth('<?=$start_date_id?>','<?=$start_month_id?>', '<?=$departure_date_id?>', '<?=$night_id?>', '<?=$departure_day_display_id?>')">
		                	<option value=""><?=date('M, Y')?></option>                
		                </select>
		                &nbsp;<input type="hidden" id="arrival_date_check_rate_<?=$hotel['id']?>" name="arrival_date_check_rate"/>
		            </div>
	        	</div>
	        	
	        	<div class="col">
	        		<span><?=lang('hotel_nights')?>:</span>
	        		<div class="clearfix" style="height: 3px;"></div>
		        	<select name="hotel_night_check_rate" id="hotel_night_check_rate_<?=$hotel['id']?>" onchange="changeNight('<?=$night_id?>', '<?=$departure_date_id?>', '<?=$departure_day_display_id?>')">				
						<?php foreach ($hotel_nights as $value) :?>
																						
							<option value="<?=$value?>" <?=set_select('hotel_night_check_rate',$value, $value == $search_criteria['hotel_night']? true: false)?>><?=$value?></option>
						
						<?php endforeach ;?>				
					</select>
	        	</div>
	        	
	        	<div class="col">
	        		<span><?=lang('hotel_depart')?>:</span>
	        		<div class="clearfix" style="height: 3px;"></div>
		        	<span id="departure_date_check_rate_display_<?=$hotel['id']?>"><?=lang('hotel_brithday_company') ?></span>
	        	</div>
	        	
	        	<div class="check_rates_block">
	        		<div class="btn_general btn_check_rates" id="btn_check_rate_<?=$hotel['id']?>"><?=lang('hotel_check_rates')?></div>
				</div>
			</form>
		</div>