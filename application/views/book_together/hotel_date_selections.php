<h3 class="text-highlight"><?=$hotel['name']?></h3>

<div class="row more_date" style="display:none">
	<div class="col-xs-10">
		<table class="table table-bordered hotel-date-table tbl-together">
			<thead>
				<tr>
					<th width="70"></th>
					
					<?php for ($i=-19; $i <= -6; $i++):?>
						
						<?php 
							$h_date = date(DATE_FORMAT_STANDARD, strtotime($tour_start_date . ' '.$i.' days'));
							
							$is_in_past = date(DB_DATE_FORMAT, strtotime($h_date)) < date(DB_DATE_FORMAT);
							//echo $h_date. $is_in_past; exit();
						?>
						
						<td align="center" id="h_day_<?=$i?>">
							<input value="<?=$h_date?>" <?=set_checkbox('staying_dates', $h_date, !empty($check_rates['staying_dates']) && in_array($h_date, $check_rates['staying_dates']))?> 
								<?php if($is_in_past):?> disabled="disabled" <?php endif;?>type="checkbox" name="staying_dates[]" onclick="set_date_selected()">
						</td>
					<?php endfor;?>
					
					<th width="70"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th width="70" id="h_month_-19">
						<?=date('M Y', strtotime($tour_start_date . ' -19 days'))?>
					</th>
						
					<?php for ($i=-19; $i <= -6; $i++):?>
					
						<th align="center" id="h_label_<?=$i?>">
							<?=date('d', strtotime($tour_start_date . ' +'.$i.' days'))?>
						</th>
					<?php endfor;?>
						
					<th width="70" id="h_month_-6">
						<?=date('M Y', strtotime($tour_start_date . ' -6 days'))?>
					</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-xs-10">
		<table class="table  hotel-date-table tbl-together">
			<thead>
				<tr>
					<th width="70"></th>
					<?php for ($i=-5; $i <= -1; $i++):?>
					
							<?php 
								$h_date = date(DATE_FORMAT_STANDARD, strtotime($tour_start_date . ' '.$i.' days'));
								$is_in_past = date(DB_DATE_FORMAT, strtotime($h_date)) < date(DB_DATE_FORMAT);
							?>
						<td align="center" id="h_day_<?=$i?>">
							
							<input value="<?=$h_date?>" <?=set_checkbox('staying_dates', $h_date, !empty($check_rates['staying_dates']) && in_array($h_date, $check_rates['staying_dates']))?> 
									<?php if($is_in_past):?> disabled="disabled" <?php endif;?>type="checkbox" name="staying_dates[]" onclick="set_date_selected()">
									
						</td>
					<?php endfor;?>
					
					<td colspan="4" align="center"><?=character_limiter($tour['name'], 17)?></td>
					
					<?php for ($i=1; $i <= 5; $i++):?>
						<?php 
								$h_date = date(DATE_FORMAT_STANDARD, strtotime($tour_end_date . ' +'.$i.' days'));
								$is_in_past = date(DB_DATE_FORMAT, strtotime($h_date)) < date(DB_DATE_FORMAT);
							?>
							
						<td align="center" id="h_day_<?=$i?>">
							<input value="<?=$h_date?>" <?=set_checkbox('staying_dates', $h_date, !empty($check_rates['staying_dates']) && in_array($h_date, $check_rates['staying_dates']))?> 
									<?php if($is_in_past):?> disabled="disabled" <?php endif;?>type="checkbox" name="staying_dates[]" onclick="set_date_selected()">
							
						</td>
					<?php endfor;?>
					<th width="70"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th width="70" id="h_month_-5">
						<?=date('M Y', strtotime($tour_start_date . ' -5 days'))?>
					</th>
					
					<?php for ($i=-5; $i <= -1; $i++):?>
						<th align="center" id="h_label_<?=$i?>">
							<?=date('d', strtotime($tour_start_date . ' '.$i.' days'))?>
						</th>
					<?php endfor;?>
						<th align="center" colspan="4" id="h_label_0">
							<?=date('d', strtotime($tour_start_date))?> - <?=date('d', strtotime($tour_end_date))?>
						</th>
					<?php for ($i=1; $i <= 5; $i++):?>
						<th align="center" id="h_label_<?=$i?>">
							<?=date('d', strtotime($tour_end_date . ' +'.$i.' days'))?>
						</th>
					<?php endfor;?>
				
					<th width="70" id="h_month_5">
						<?=date('M Y', strtotime($tour_end_date . ' +5 days'))?>
					</th>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="col-xs-2" style="padding:25px 2px;">		
		<a href="javascript:void(0)" onclick="show_more_date()" class="show-more-dates" class="show-more-date" data-target=".more_date" data-icon="#show-more-dates" data-show="hide">
			<span class="glyphicon glyphicon-triangle-bottom text-special" style="margin-right: 3px; top: 2px;" id="show-more-dates" data-show="glyphicon-triangle-top" data-hide="glyphicon-triangle-bottom"></span>
			<span id="show-more" class="show-more" show="show" ><?=lang('show_more_date')?></span>	
			<span id="show-less" class="show-more" show="" style="display: none;"><?=lang('show_less_date')?></span>		
		</a>
	</div>
</div>

<div class="row more_date" style="display:none">
	<div class="col-xs-10">
		<table class="table table-bordered hotel-date-table tbl-together">
			<thead>
				<tr>
					<th width="70"></th>
					
					<?php for ($i=6; $i <= 19; $i++):?>
						<?php 
							$h_date = date(DATE_FORMAT_STANDARD, strtotime($tour_end_date . ' +'.$i.' days'));
								$is_in_past = date(DB_DATE_FORMAT, strtotime($h_date)) < date(DB_DATE_FORMAT);
							?>
							
						<td align="center" id="h_day_<?=$i?>">
							<input value="<?=$h_date?>" <?=set_checkbox('staying_dates', $h_date, !empty($check_rates['staying_dates']) && in_array($h_date, $check_rates['staying_dates']))?> 
									<?php if($is_in_past):?> disabled="disabled" <?php endif;?>type="checkbox" name="staying_dates[]" onclick="set_date_selected()">
							
						</td>
					<?php endfor;?>
					
					<th width="70"></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th width="70" id="h_month_6">
						<?=date('M Y', strtotime($tour_end_date . ' +6 days'))?>
					</th>
						
					<?php for ($i=6; $i <= 19; $i++):?>
						<th align="center" id="h_label_<?=$i?>">
							<?=date('d', strtotime($tour_end_date . ' '.$i.' days'))?>
						</th>
					<?php endfor;?>
						
					<th id="h_month_19">
						<?=date('M Y', strtotime($tour_end_date . ' +19 days'))?>
					</th>
				</tr>
			</tbody>
		</table>
	</div>
</div>

					
<div class="text-warning" id="hotel_error" style="display:none"><span class="glyphicon glyphicon-warning-sign"></span> <?=lang('label_please_select_dates_staying')?></div>


<script type="text/javascript">
	set_date_selected();
	$('#tour_date_<?=$tour['id']?>').change(function(){
		change_datepicker_date('#tour_date_<?=$tour['id']?>', <?=$tour['duration'] - 1?>);
		change_hotel_selection_date('#tour_date_<?=$tour['id']?>', <?=$tour['duration'] - 1?>);
	});

	set_show_hide('.show-more-dates');
	function show_more_date(){
		var show = $('.show-more').attr('show');
		if(show == 'show')
		{
			$('#show-more').attr('show', 'hide');
			$('#show-less').attr('show', 'show');
			$('#show-less').show();
			$('#show-more').hide();
		}
		else 
		{
			$('#show-more').attr('show', 'show');
			$('#show-less').attr('show', 'hide');
			$('#show-more').show();
			$('#show-less').hide();
		}
	}

</script>