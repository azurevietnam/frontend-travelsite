<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="contentLeft">
	
	<div id="searchForm" style="margin-bottom: 10px;">
		<?=$tour_search_view?>
	</div>

	<?=$topDestinations?>

		
</div>
	


<div id="contentMain">
	<form name="frm" method="post" id="frmRequest">
	<h1 class="highlight" style="padding-left: 0; padding-top: 0"><?=lang('title_customize_tour')?></h1>
	<div id="contact" style="background-color:#eee;margin: 0; padding:10px;width:700px">
		<div class="items">
			<div class="col_1"><?=lang('full_name')?>: <?=mark_required()?></div>
			<div class="col_2">
			<?=form_error('full_name')?>
			<select name="title">
				<option value="1" <?=set_select('title', '1')?>><?=lang('mr')?></option>
				<option value="2" <?=set_select('title', '2')?>><?=lang('ms')?></option>
			</select>&nbsp;
			<input type="text" name="full_name" size="40" maxlength="50" value="<?=set_value('full_name')?>"/>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address')?>: <?=mark_required()?></div>
			<div class="col_2">
				<div class="clearfix">
				<?=form_error('email')?>
				</div>
				<div style="float: left;">
					<input type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>"/>
				</div>
				
				<div style="font-size: 11px; float: left; padding-left: 10px;">
					<span style="color: red;">(*)&nbsp;</span>	
					<span style="position: absolute; width: 350px;"><?=lang('spam_email_notify')?></span>
				
				</div>
				
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('email_address_confirm')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('email_cf')?><input type="text" name="email_cf" id="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" autocomplete="off"/></div>
		</div>		
		<div class="items">
			<div class="col_1"><?=lang('phone_number')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('phone')?><input type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>"/></div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('country')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('country')?>
			 <select name="country">
				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
				<?php foreach ($countries as $key => $country) :?>
				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
				<?php endforeach;?>
			</select>
			</div>
		</div>
		<div class="items">
			<div class="col_1"><?=lang('city')?>:</div>
			<div class="col_2"><input type="text" name="city" size="30" maxlength="50" value="<?=set_value('city')?>"/></div>
		</div>		
		
		<input type="hidden" name="subject" value="Customize Tour" <?=set_value('subject', 'Customize Tour')?>/>
		
		<div class="items" style="padding: 10px 0">
		</div>
		
		<?php if(isset($tour)):?>
		
		<div class="items">
			<div class="col_1"><?=lang('label_customize_this_tour')?>:</div>
			<div class="col_2"><b><?=$tour['name']?></b></div>
			<input type="hidden" name="tour_name" value="<?=$tour['name']?>" <?=set_value('tour_name', $tour['name'])?>/>
		</div>
		
		<?php endif;?>
		
		
		<div class="items">
			<div class="col_1"><?=lang('lb_people_in_your_group')?>:</div>
			<div class="col_2">
				<?=lang('adults')?>:&nbsp; 
				<select name="adults" style="margin-right: 15px">
					<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
	                 <option value="<?=$i?>" <?=set_select('adults', $i, $i=='2'? true: false)?>><?=$i?></option>
	                 <?php endfor;?>
	            </select>
	            
	            
	            <?=lang('children')?>:&nbsp;
	            <select name="children" style="margin-right: 15px">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                <option value="<?=$i?>" <?=set_select('children', $i)?>><?=$i?></option>
	                <?php endfor;?>
	            </select> 
	            
	            
	             <?=lang('infants')?>:&nbsp;
	           	<select name="infants">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
	                	<option value="<?=$i?>" <?=set_select('infants', $i)?>><?=$i?></option>
	                <?php endfor;?>
	            </select>
			</div>
		</div>
		
		
		<?php 
	
			$start_date_id = '#departure_day_customize';
			
			$start_month_id = '#departure_month_customize';
			
			$departure_date_id = '#departure_date_customize';
		
		?>
		
		<div class="items">
			<div class="col_1"><?=lang('lb_arrival_date')?>: <?=mark_required()?></div>
			<div class="col_2">
				
				<select name="departure_day_check_rates" id="departure_day_customize" onchange="changeDay_cus('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>')">
					<option value=""><?=lang('label_please_select')?></option>
					<option value=""><?=date('D, Y')?></option>
				</select>
				
				<select name="departure_month_check_rates" id="departure_month_customize" onchange="changeMonth_cus('<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','','')">
	            	<option value=""><?=lang('label_please_select')?></option>
	            	<option value=""><?=date('M, Y')?></option>                 
	            </select>
	            &nbsp;<input type="hidden" id="departure_date_customize" name="departure_date_customize"/>
		        <br>		        
		        <?=form_error('departure_month_check_rates')?>    
			</div>
		</div>
		
		<?php if($tour['duration'] > 1):?>
		<div class="items">
			<div class="col_1"><?=lang('label_tour_duration')?>: <?=mark_required()?></div>
			<div class="col_2">
				<select name="tour_duration" id="tour_duration">
					<option value=""><?=lang('label_please_select')?></option>
					<?php for ($i = 1; $i <= 30; ++$i) :?>
						<?php 
							$day_text = 'days';
							if ($i == 1) $day_text = 'day';
						?>
	                	<option value="<?=$i?>" <?=set_select('tour_duration', $i, isset($tour) && $tour['duration'] == $i)?>><?=$i. ' '.$day_text?></option>
	                <?php endfor;?>
	            </select>
	            
	            <?=form_error('tour_duration')?>
			</div>
		</div>
		
		<div class="items">
			<div class="col_1"><?=lang('lb_accomodation')?>: <?=mark_required()?></div>
			<div class="col_2">
				<select name="tour_accommodation" id="tour_accommodation">
					<option value=""><?=lang('label_please_select')?></option>
					<?php foreach ($tour_customize_class as $value):?>
					<option value="<?=lang($value['name'])?>" 
					   price_from="<?=$value['price_from']?>" <?=isset($value['price_to']) ? 'price_to="'.$value['price_to'].'"' : ''?> <?=set_select('tour_accommodation', lang($value['name']))?>>
					<?=lang($value['name'])?>
					</option>
					<?php endforeach;?>
	            </select>
	            <span style="margin-left: 10px"><?=lang('price_per_pax')?></span>
	            
	            <?=form_error('tour_accommodation')?>
			</div>
		</div>		
		
		
		<div class="items">
			<div class="col_1"><?=lang('lb_destination_to_visit')?>:</div>
			<div class="col_2">
				<?php foreach ($parent_dess as $country):?>
					<h3 style="padding: 0"><?=$country['name']?></h3>
					<ul style="width: 400px;">
						<?php foreach ($dess as $city):?>
							<?php if($city['parent_id'] == $country['id']):?>
								<li style="float: left;width: 33%;margin-top:5px"><input type="checkbox" value="<?=$city['name']?>" <?=set_checkbox('destination_visit', $city['name'])?> name="destination_visit[]">&nbsp;<?=$city['name']?></li>
							<?php endif;?>							
						<?php endforeach;?>
					</ul>
					<div style="clear: both;padding-bottom:10px"></div>
				<?php endforeach;?>
				<h3 style="padding: 0">Myanmar</h3>
				<ul style="width: 400px;">
				<?php foreach ($myanmar_tour_destinations as $value):?>
				    <li style="float: left;width: 33%;margin-top:5px"><input type="checkbox" value="<?=$value?>" <?=set_checkbox('destination_visit', $value)?> name="destination_visit[]">&nbsp;<?=$value?></li>
				<?php endforeach;?>
				</ul>
			</div>
		</div>	
		<?php endif;?>
		
		<div class="items" style="padding: 10px 0">
		</div>
		
		<div class="items">
			<div class="col_1"><?=lang('special_requests')?>: <?=mark_required()?></div>
			<div class="col_2"><?=form_error('message')?><textarea name="message" cols="53" rows="5"><?=set_value('message')?></textarea><br/><i><?=lang('text_maximum')?>.</i></div>
		</div>						
		<div class="items item_button">
			<div class="col_1"><?=note_required()?></div>
			<div class="col_2" style="margin-top: 10px">		
				
				<div class="btn_general btn_submit_booking" onclick="submit_request()" style="float: left;">
					<?=lang('submit')?>
				</div>
				
			</div>
		</div>
	</div>
	</form>
</div>


<script type="text/javascript">
	function submit_request() {
		$('#frmRequest').submit();
	}

	function changeDay_cus(a,b,c){
		if($('#departure_day_customize').val() != ''){
			changeDay(a,b,c);
		}
	}

	function changeMonth_cus(a,b,c,d,e,f){
		if($('#departure_month_customize').val() != ''){
			changeMonth(a,b,c,d,e,f);
		}
	}

	function calculate_tour_price() 
	{
		// it exists 
		if ($('#tour_accommodation').length > 0 && $('#tour_duration').length > 0) { 

			var duration = $('#tour_duration').val();
		    
			$("#tour_accommodation option").each(function() {

				if($(this).val() != '') {
					var price_between = '';
					var price_from = $(this).attr('price_from');

					price_from = parseInt(price_from, 10) * parseInt(duration, 10);

					if(typeof $(this).attr('price_to') != 'undefined')
					{
						var price_to = $(this).attr('price_to');

						price_to = parseInt(price_to, 10) * parseInt(duration, 10);
						
						price_between = ' ( $' + price_from + ' - $' + price_to +  ' )';	
					} else {
						
						price_between = ' ( >$' + price_from + ' )';
					}
					
					$(this).text( $(this).val() + price_between );
				}	
			});
		}
	}

	$(document).ready(function(){

		// Calculate customize tour price
		if($('#tour_duration').length > 0)
		{
			$( "#tour_duration" ).change(function() {
				calculate_tour_price();
			});

			calculate_tour_price();
		}
		// ---- end calculate
		
	    $('#email_cf').bind("cut copy paste",function(e) {
	        e.preventDefault();
	    });

	    var this_date = '<?=getDefaultDate()?>';
	    
		var current_date = this_date;

		<?php if(isset($arrival_date)):?>
		
			current_date = '<?=date('d-m-Y', strtotime($arrival_date))?>';

		<?php endif;?>
		
		initDate(this_date, current_date, '<?=$start_date_id?>', '<?=$start_month_id?>', '<?=$departure_date_id?>','','','');

		var days = $('#departure_day_customize').html();

		days = '<option value=""><?=lang('label_please_select')?></option>' + days;

		var months = $('#departure_month_customize').html();

		months = '<option value=""><?=lang('label_please_select')?></option>' + months;

		$('#departure_day_customize').html(days);

		$('#departure_month_customize').html(months);

		<?php if(!isset($arrival_date)):?>
			$('#departure_date_customize').val('');
			$('#departure_day_customize option').removeAttr('selected');
			$('#departure_month_customize option').removeAttr('selected');
		<?php endif;?>
	 });
</script>