
<?php
	$today = date(DB_DATE_FORMAT);
	 
	$selected_date = $flight_type == FLIGHT_TYPE_DEPART ? format_bpv_date($search_criteria['Depart']) : format_bpv_date($search_criteria['Return']);
	
?>

<div class="row cal-row">
	<?php for ($i=-1; $i < 2; $i++):?>
	
		<?php
			$date_index = $i < 0 ? ' -'. (0 - $i). ' days' : ' +'.$i.' days'; 
			$cal_date = strtotime($selected_date . $date_index);
			
			$wd = date('w', $cal_date);
			
			$wd = $week_days[$wd];
			
			$wd = lang($wd);
			
			$str_date = date(DATE_FORMAT, $cal_date);
			
			$cal_item_css = $i == 0 ? 'cal-selected' : '';
			
			if ($flight_type == FLIGHT_TYPE_DEPART){
			
				if($i < 0 && date(DB_DATE_FORMAT, $cal_date) > $today)
				{
					$cal_item_css = 'cal-active';
				}
				
				if($i > 0){
					
					if($search_criteria['Type'] == FLIGHT_TYPE_ROUNDWAY){
						
						if(date(DB_DATE_FORMAT, $cal_date) <= format_bpv_date($search_criteria['Return'])){
							$cal_item_css = 'cal-active';
						}
						
					} else {
						$cal_item_css = 'cal-active';
					}
				}
			
			} else {
				
				if($i < 0 && date(DB_DATE_FORMAT, $cal_date) >= format_bpv_date($search_criteria['Depart']))
				{
					$cal_item_css = 'cal-active';
				}
					
				if ($i > 0){
					$cal_item_css = 'cal-active';
				}
			}
			
		?>
	
		<div class="cal-col">
		
			<div class="cal-item <?=$cal_item_css?>" dayindex="<?=$i?>" <?php if($cal_item_css == 'cal-active'):?> onclick="change_flight_date('<?=$flight_type?>','<?=$sid?>',<?=$i?>, '<?=$wd?>', '<?=$str_date?>')"<?php endif;?>>
				<div class="week-day text-center">
					<?=$wd?>
				</div>
				
				<div class="cal-date text-center">
					<?=$str_date?>
				</div>
				
			</div>
			<?php if($i == 0):?>
				<div class="cal-arrow-down center-block"></div>
			<?php endif;?>

		</div>
	
	<?php endfor;?>
</div>
