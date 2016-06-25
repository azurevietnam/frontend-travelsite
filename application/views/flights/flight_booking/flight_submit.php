
<?php if($flight_booking['is_unavailable'] || $flight_booking['is_timeout'] || isset($submit_status_nr)):?>
	<div class="container">
		<div class="bpv-col-left">
			<?=$flight_search_form?>
		</div>
		<div class="bpv-col-right">
			<ol class="breadcrumb">
			  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
			  <li><a href="<?=get_url(FLIGHT_HOME_PAGE)?>"><?=lang('mnu_flights')?></a></li>
			  <li><a href="<?=get_current_flight_search_url($search_criteria)?>"><?=lang_arg('flight_search_bredcum', $search_criteria['From'], $search_criteria['To'])?></a></li>
			  <li><a href="<?=get_url(FLIGHT_DETAIL_PAGE.'?sid='.$sid)?>"><?=lang('passenger_detail')?></a></li>
			  <li class="active"><?=lang('flight_step_3')?></li>
			</ol>
			<?php
		
				if($flight_booking['is_unavailable']) $code = 1; // seat unavailable
				
				if($flight_booking['is_timeout']) $code = 4; // time out
			
				if(isset($submit_status_nr)){
					if($submit_status_nr == -1){
						$code = 1; // default: seat unavailable
					} else {
						$code = 2; // fail to connect VNISC
					}
				} 
				
				echo load_flight_booking_exception($search_criteria, $code)
			?>
		</div>
	</div>
<?php else:?>

<div class="container booking-page">
	
	<ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=get_url(FLIGHT_HOME_PAGE)?>"><?=lang('mnu_flights')?></a></li>
	  <li><a href="<?=get_current_flight_search_url($search_criteria)?>"><?=lang_arg('flight_search_bredcum', $search_criteria['From'], $search_criteria['To'])?></a></li>
	  <li><a href="<?=get_url(FLIGHT_DETAIL_PAGE.'?sid='.$sid)?>"><?=lang('passenger_detail')?></a></li>
	  <li class="active"><?=lang('flight_step_3')?></li>
	</ol>	
		
	<div class="bpv-col-right">
		
		<?=$step_booking?>
		
		<div class="margin-top-20">
			<?=$flight_review?>
		</div>
		
		<form name="frm_book" id="frm_book" method="post">
			<div class="margin-top-20">
				
				<input type="hidden" value="<?=!empty($flight_booking['promotion_code']) ? $flight_booking['promotion_code'] : ''?>" name="promotion_code" id="promotion_code_used">
				<?=$contact_form?>
				
			</div>
			
			<div class="margin-top-20">
				<?=$payment_method?>
			</div>
			
			
			<?php if(isset($booking_note)):?>
				<p class="bpv-color-warning margin-top-20">* <?=$booking_note?></p>
			<?php endif;?>
			
				<p class="margin-top-20">* <?=lang_arg('c_term_agreement', lang('btn_flight_book'))?></p>
			
			<div class="margin-top-20">
				<button type="submit" name="action" value="<?=ACTION_MAKE_BOOKING?>" class="btn btn-bpv btn-lg center-block" onclick="return validate_contact_form()">
					<span class="glyphicon glyphicon-circle-arrow-right"></span>&nbsp;<?=lang('btn_flight_book')?>
				</button>
			</div>
		
		</form>
	</div>
	
	<div class="bpv-col-left">
		<?=$flight_summary?>
	</div>
	
</div>


<!-- Modal -->
<div class="modal fade" id="flight_details" tabindex="-1" role="dialog" aria-labelledby="label_flight_details" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room" style="width: 61.6398243045388%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="modal-title bpv-color-title" id="label_flight_details"><?=lang('flight_itineray')?></h4>
      </div>
      <div class="modal-body">
      	<?=$flight_itinerary?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bpv" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="flight_passengers" tabindex="-1" role="dialog" aria-labelledby="label_flight_passengers" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="modal-title bpv-color-title" id="label_flight_passengers"><?=lang('change_passenger')?></h4>
      </div>
      <div class="modal-body">
      	
      	<form id="frm_passenger" name="frm_passenger" method="post" action="<?=get_url(FLIGHT_DETAIL_PAGE)?>?sid=<?=$sid?>">
			<input type="hidden" value="change-passenger" name="action">
		
			<?=$flight_passenger?>
		</form>
		
      	
      </div>
      <div class="modal-footer" style="padding-bottom:15px">
      	<button type="button" class="btn btn-bpv btn-lg" onclick="apply_changes()"><?=lang('apply_changes')?></button>
      	
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('cancel_changes')?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="submit_data_waiting" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="label_submit_data_waiting" aria-hidden="true">
  <div class="modal-dialog modal-dialog-room">
    <div class="modal-content">
      <?=load_search_waiting(lang('process_flight_booking'))?>
    </div>
  </div>
</div>

<?php endif;?>


<script type="text/javascript">
	
	function apply_changes(){

		if(validate_passengers() && validate_chd_inf_birthday(<?=$search_criteria['CHD']?>, <?=$search_criteria['INF']?>, '<?=$search_criteria['Depart']?>')){

			$('#frm_passenger').submit();
		}
		
	}
</script>